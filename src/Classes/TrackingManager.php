<?php

namespace Slashworks\ContaoTrackingManagerBundle\Classes;

use Slashworks\ContaoTrackingManagerBundle\Model\TmConfigModel;
use Contao\Frontend;
use Contao\FrontendTemplate;
use Contao\PageModel;
use Contao\System;
use Slashworks\ContaoTrackingManagerBundle\Model\TrackingmanagerSettingsModel;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Contao\Controller;

class TrackingManager
{

    protected $strTemplate = 'trackingmanager';

    /**
     *
     */
    public function generatePageHook(\PageModel $objPage, \LayoutModel $objLayout, \PageRegular $objPageRegular)
    {
        if ($objPage->type != "regular") {
            return;
        }

        $objRootPage = PageModel::findById($objPage->rootId);

        if (!$objRootPage->tm_active) {
            return;
        }

        //check sessionbag to save saved config
        /** @var SessionInterface $session */
        $session = System::getContainer()->get('session');
        $frontendSession = $session->getBag('contao_frontend');

        $objCookieSettings = TrackingmanagerSettingsModel::findBy('published', '1');
        $objBaseCookie = TrackingmanagerSettingsModel::findOneBy('isBaseCookie', '1');


        // get cookies set vs available values
        if (NULL == $objCookieSettings) {
            return;
        }
        if (NULL == $objBaseCookie) {
            return;
        }

        while ($objCookieSettings->next()) {

            // save cookie settings in DB
            if ($frontendSession->has('tm_config_set')) {
                if (!TrackingManagerStatus::getCookieStatus($objBaseCookie->name)) {
                    $configModel = new TmConfigModel();
                    $configModel->pid = $session->getId();
                    $configModel->tstamp = date('U');
                    $configModel->title = $objCookieSettings->label;
                    $configModel->save();
                }

            }

            $objCookieSettings->descriptions = \StringUtil::deserialize($objCookieSettings->descriptions);
            $arrCookies[$objCookieSettings->name] = $objCookieSettings->current();
        }

        $frontendSession->remove('tm_config_set');

        // template and frontend logic
        $config = sha1(serialize($arrCookies));
        $savedConfig = TrackingManagerStatus::getCookieValue($objBaseCookie->name);

        if (!TrackingManagerStatus::getCookieStatus($objBaseCookie->name) or ($config != $savedConfig)) {
            $objTpl = new FrontendTemplate($this->strTemplate);
            $objTpl->intro = $objRootPage->tm_intro;
            if ($objRootPage->tm_link) {
                $objTpl->url = Frontend::generateFrontendUrl(PageModel::findBy('id', $objRootPage->tm_link)->row());
            }
            $objTpl->baseCookieName = $objBaseCookie->name;
            $objTpl->linktext = $objRootPage->tm_linktext;
            $objTpl->submit_all = $objRootPage->tm_submit_all;
            $objTpl->submit = $objRootPage->tm_submit;
            $objTpl->cookies = $arrCookies;
            $objTpl->config = sha1(serialize($arrCookies));

            $GLOBALS['TL_BODY'][] = Controller::replaceInsertTags($objTpl->parse());
            $GLOBALS['TL_CSS'][] = '/bundles/contaotrackingmanager/css/trackingmanager.css';

            //add js
            $objJsTemplate = new FrontendTemplate('trackingmanagerjs');
            $GLOBALS['TL_BODY'][] = $objJsTemplate->parse();

            // save config preparation
            /** @var SessionInterface $session */
            $session = System::getContainer()->get('session');
            $frontendSession = $session->getBag('contao_frontend');
            $frontendSession->set('tm_config_set', 1);

        }

    }

}
