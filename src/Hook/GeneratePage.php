<?php

namespace Slashworks\ContaoTrackingManagerBundle\Hook;

use Contao\Combiner;
use Contao\FormCheckBox;
use Contao\StringUtil;
use Slashworks\ContaoTrackingManagerBundle\Classes\TrackingManagerStatus;
use Slashworks\ContaoTrackingManagerBundle\Model\Statistic;
use Contao\Frontend;
use Contao\FrontendTemplate;
use Contao\PageModel;
use Contao\System;
use Slashworks\ContaoTrackingManagerBundle\Model\Cookie;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Contao\Controller;
use Symfony\Component\VarDumper\VarDumper;

class GeneratePage
{
    /**
     *
     *
     * @param \PageModel   $page
     * @param \LayoutModel $layout
     * @param \PageRegular $pageRegular
     */
    public function generateTrackingManager(\PageModel $page, \LayoutModel $layout, \PageRegular $pageRegular)
    {
        if ($page->type != "regular") {
            return;
        }

        $rootPage = PageModel::findById($page->rootId);

        if (!$rootPage->tm_active) {
            return;
        }

        // check sessionbag to save saved config
        /** @var SessionInterface $session */
        $session = System::getContainer()->get('session');
        $frontendSession = $session->getBag('contao_frontend');

        $cookieSettings = Cookie::getCookiesByRootpage($rootPage);
        $baseCookie = Cookie::getBaseCookieByRootPage($rootPage);

        // get cookies set vs available values
        if ($cookieSettings === null) {
            System::log('No Cookies selected in Root Page', __METHOD__, TL_GENERAL);
            return;
        }
        if ($baseCookie === null) {
            System::log('No BaseCookie selected in Root Page', __METHOD__, TL_GENERAL);
            return;
        }

        while ($cookieSettings->next()) {
            // save cookie settings in DB
            if ($frontendSession->has('tm_config_set')) {
                    $configModel = new Statistic();
                    $configModel->pid = $session->getId();
                    $configModel->tstamp = date('U');
                    $configModel->title = $cookieSettings->current()->name;
                    $configModel->status = TrackingManagerStatus::getCookieStatus($cookieSettings->current()->name);
                    $configModel->save();
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

        $frontendSession->remove('tm_config_set');

        // template and frontend logic
        $config = sha1(serialize($arrCookies));
        $savedConfig = TrackingManagerStatus::getCookieValue($baseCookie->name);

        foreach ($arrCookies as $name => $cookie) {
            // Generate checkbox widget
            $widget = new FormCheckBox();
            $widget->name = $cookie['name'];
            $widget->id = 'tm_' . $cookie['id'];

            if ($cookie['name'] === $baseCookie->name) {
                $widget->disabled = true;
            }

            $widget->options = array
            (
                array
                (
                    'value' => ($cookie['name'] === $baseCookie->name) ? $config : '1',
                    'default' => ($cookie['name'] === $baseCookie->name),
                    'label' => $cookie['label'],
                ),
            );

            $arrCookies[$name]['widget'] = $widget->parse();
        }

        if (!TrackingManagerStatus::getCookieStatus($baseCookie->name) || ($config != $savedConfig)) {
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

            $template->baseCookieName = $baseCookie->name;
            $template->linktext = $rootPage->tm_linktext;
            $template->submit_all = $rootPage->tm_submit_all;
            $template->details = $rootPage->tm_details;
            $template->submit = $rootPage->tm_submit;
            $template->cookies = $arrCookies;
            $template->config = sha1(serialize($arrCookies));

            $GLOBALS['TL_BODY'][] = Controller::replaceInsertTags($template->parse());
            
            $combiner = new Combiner();
            $combiner->add('bundles/contaotrackingmanager/css/trackingmanager.scss');
            $GLOBALS['TL_CSS'][] = $combiner->getCombinedFile();

            // add js
            $jsTemplate = new FrontendTemplate('trackingmanagerjs');
            $jsTemplate->cookiesTTL = $rootPage->tm_cookies_ttl;
            $GLOBALS['TL_BODY'][] = $jsTemplate->parse();

            // save config preparation
            /** @var SessionInterface $session */
            $session = System::getContainer()->get('session');
            $frontendSession = $session->getBag('contao_frontend');
            $frontendSession->set('tm_config_set', 1);

        }

    }

}
