<?php

namespace Slashworks\ContaoTrackingManagerBundle\Classes;

use Contao\FormCheckBox;
use Contao\StringUtil;
use Slashworks\ContaoTrackingManagerBundle\Model\TmConfigModel;
use Contao\Frontend;
use Contao\FrontendTemplate;
use Contao\PageModel;
use Contao\System;
use Slashworks\ContaoTrackingManagerBundle\Model\TrackingmanagerSettingsModel;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Contao\Controller;
use Symfony\Component\VarDumper\VarDumper;

class TrackingManager
{

    protected $strTemplate = 'trackingmanager';

    /**
     *
     */
    public function generatePageHook(\PageModel $page, \LayoutModel $layout, \PageRegular $pageRegular)
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

        $cookieSettings = TrackingmanagerSettingsModel::getCookiesByRootpage($rootPage);
        $baseCookie = TrackingmanagerSettingsModel::getBaseCookieByRootPage($rootPage);

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
                    $configModel = new TmConfigModel();
                    $configModel->pid = $session->getId();
                    $configModel->tstamp = date('U');
                    $configModel->title = $cookieSettings->current()->name;
                    $configModel->status = TrackingManagerStatus::getCookieStatus($cookieSettings->current()->name);
                    $configModel->save();
            }
            $cookie = $cookieSettings->row();
            $cookie['descriptions'] = StringUtil::deserialize($cookie['descriptions']);

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
            $template = new FrontendTemplate($this->strTemplate);
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
            $GLOBALS['TL_CSS'][] = '/bundles/contaotrackingmanager/css/trackingmanager.css';

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
