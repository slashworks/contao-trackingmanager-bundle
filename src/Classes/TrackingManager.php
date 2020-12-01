<?php

namespace Slashworks\ContaoTrackingManagerBundle\Classes;

use Contao\Combiner;
use Contao\Controller;
use Contao\CoreBundle\Monolog\ContaoContext;
use Contao\CoreBundle\Session\Attribute\ArrayAttributeBag;
use Contao\Environment;
use Contao\FormCheckBox;
use Contao\FrontendTemplate;
use Contao\Input;
use Contao\PageModel;
use Contao\StringUtil;
use Contao\System;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Slashworks\ContaoTrackingManagerBundle\Model\Cookie;
use Slashworks\ContaoTrackingManagerBundle\Model\Statistic;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\VarDumper\VarDumper;

class TrackingManager
{

    /** @var PageModel */
    protected $page;

    /** @var SessionInterface */
    protected $session;

    /** @var ArrayAttributeBag */
    protected $frontendSession;

    /**
     * @return Session
     */
    public function getSession(): Session
    {
        return $this->session;
    }

    /**
     * @param PageModel $page
     */
    public function setPage(PageModel $page): void
    {
        $this->page = $page;
    }

    /**
     * @return PageModel
     */
    public function getPage(): PageModel
    {
        return $this->page;
    }

    public function generate()
    {
        if ($this->page->type != "regular") {
            return;
        }

        $rootPage = PageModel::findById($this->page->rootId);
        if (!$rootPage->tm_active) {
            return;
        }

        /** @var LoggerInterface $logger */
        $logger = System::getContainer()->get('monolog.logger.contao');

        // check sessionbag to save saved config
        $this->session = System::getContainer()->get('session');
        $this->frontendSession = $this->session->getBag('contao_frontend');

        $cookieSettings = Cookie::getCookiesByRootpage($rootPage);
        $baseCookie = Cookie::getBaseCookieByRootPage($rootPage);

        // get cookies set vs available values
        if ($cookieSettings === null) {
            $logger->log(LogLevel::INFO, 'No cookies selected in root page.', array('contao' => new ContaoContext(__METHOD__, 'Tracking Manager')));
            return;
        }
        if ($baseCookie === null) {
            $logger->log(LogLevel::INFO, 'No baseCookie selected in root page.', array('contao' => new ContaoContext(__METHOD__, 'Tracking Manager')));
            return;
        }

        $arrCookies = $this->getCookieData();
        $this->frontendSession->remove('tm_config_set');

        // template and frontend logic
        $config = $this->getConfiguration();
        $savedConfig = TrackingManagerStatus::getBaseCookieValue();

        foreach ($arrCookies as $name => $cookie) {
            $arrCookies[$name]['widget'] = $this->parseWidgetForCookie($cookie);
        }

        $template = new FrontendTemplate('trackingmanager');
        $template->headline = $rootPage->tm_headline;
        $template->intro = $rootPage->tm_intro;

        if ($rootPage->tm_link) {
            $linkUrl = PageModel::findByPk($rootPage->tm_link)->getFrontendUrl();
            $linkText = $rootPage->tm_linktext;

            if ($linkText === '') {
                $linkText = $linkUrl;
            }

            $link = sprintf('<a href="%s" target="_blank">%s</a>', $linkUrl, $linkText);
            $template->intro = str_replace('{{link}}', $link, $template->intro);
        }

        $template->baseCookieName = TrackingManagerStatus::getBaseCookieName();
        $template->linktext = $rootPage->tm_linktext;
        $template->submit_all = $rootPage->tm_submit_all;
        $template->details = $rootPage->tm_details;
        $template->submit = $rootPage->tm_submit;
        $template->cookies = $arrCookies;
        $template->config = sha1(serialize($arrCookies));

        if (TrackingManagerStatus::isBaseCookieSet() && ($config == $savedConfig)) {
            $template->hidden = true;
        }

        $GLOBALS['TL_BODY'][] = Controller::replaceInsertTags($template->parse());

        $combiner = new Combiner();
        $combiner->add('bundles/contaotrackingmanager/css/trackingmanager.scss');
        $GLOBALS['TL_CSS'][] = $combiner->getCombinedFile();

        // add js
        $jsTemplate = new FrontendTemplate('trackingmanagerjs');
        $jsTemplate->cookiesTTL = $rootPage->tm_cookies_ttl;
        $GLOBALS['TL_BODY'][] = $jsTemplate->parse();

        // save config preparation
        $this->frontendSession->set('tm_config_set', 1);

        // Include default trackingmanager editor.
        if ($rootPage->tm_editable) {
            $editorTemplate = new FrontendTemplate('trackingmanager_editor');

            // Hide default trackingmanager editor if the trackingmanager is shown anyway.
            if (!TrackingManagerStatus::isBaseCookieSet() || ($config != $savedConfig)) {
                $editorTemplate->hidden = true;
            }

            $GLOBALS['TL_BODY'][] = Controller::replaceInsertTags($editorTemplate->parse());
        }

        $this->deleteDisabledBrowserCookies();
    }

    protected function getCookieData()
    {
        $cookieSettings = Cookie::getCookiesByRootpage($rootPage);

        /** @var Cookie $cookieSettings */
        while ($cookieSettings->next()) {
            // save cookie settings in DB
            if ($this->frontendSession->has('tm_config_set')) {
                $statistic = new Statistic();
                $statistic->pid = $this->session->getId();
                $statistic->tstamp = time();
                $statistic->title = $cookieSettings->current()->name;
                $statistic->status = TrackingManagerStatus::getCookieStatus($cookieSettings->current()->name);
                $statistic->save();
            }

            $cookie = $cookieSettings->row();

            $descriptions = StringUtil::deserialize($cookie['descriptions'], true);
            $firstDescription = $descriptions[0];
            $keys = array_keys($firstDescription);
            $firstKey = $keys[0];

            if (!empty($firstDescription[$firstKey])) {
                $cookie['descriptions'] = $descriptions;
            } else {
                $cookie['descriptions'] = array();
            }

            $arrCookies[$cookieSettings->name] = $cookie;
        }

        return $arrCookies;
    }

    protected function parseWidgetForCookie($cookie)
    {
        // Generate checkbox widget
        $widget = new FormCheckBox();
        $widget->name = $cookie['name'];
        $widget->id = 'tm_' . $cookie['id'];

        if ($cookie['name'] === TrackingManagerStatus::getBaseCookieName()) {
            $widget->disabled = true;
        }

        $options = array
        (
            'value' => ($cookie['name'] === TrackingManagerStatus::getBaseCookieName()) ? $this->getConfiguration() : '1',
            'label' => $cookie['label'],
        );

        // this sets the "checked" attribute
        if ($cookie['name'] === TrackingManagerStatus::getBaseCookieName()) {
            $options['default'] = true;
        } else {
            $options['default'] = TrackingManagerStatus::getCookieStatus($cookie['name']);
        }

        $widget->options = array($options);

        return $widget->parse();
    }

    protected function getConfiguration()
    {
        return sha1(serialize($this->getCookieData()));
    }

    protected function deleteDisabledBrowserCookies()
    {
        $cookies = $this->getCookieData();

        foreach ($cookies as $cookie) {
            $cookieModel = Cookie::findByPk($cookie['id']);

            if (TrackingManagerStatus::getCookieStatus($cookieModel->name) === true) {
                continue;
            }

            $browserCookies = $cookieModel->getBrowserCookieNames();
            foreach ($browserCookies as $name) {
                System::setCookie($name, '', time() - 3600, '/', Environment::get('host'));
            }
        }
    }

}
