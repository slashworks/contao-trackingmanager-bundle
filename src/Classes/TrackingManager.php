<?php

namespace Slashworks\ContaoTrackingManagerBundle\Classes;

use Slashworks\ContaoTrackingManagerBundle\Model\TmConfigModel;
use Trackingmanager\Classes\TrackingManagerStatus;
use Contao\Frontend;
use Contao\FrontendTemplate;
use Contao\PageModel;
use Contao\System;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class TrackingManager
{

    protected $strTemplate = 'trackingmanager';

    /**
     *
     */
    public function generatePageHook(\PageModel $objPage, \LayoutModel $objLayout, \PageRegular $objPageRegular)
    {
        $objRootPage =  PageModel::findById($objPage->rootId);

        if(!$objRootPage->tm_active){
            return;
        }


        //check sessionbag to save saved config
        /** @var SessionInterface $session */
        $session = System::getContainer()->get('session');
        $frontendSession = $session->getBag('contao_frontend');

        if($frontendSession->has('tm_config_set')){
            // get cookies set vs available values
            foreach ($GLOBALS['TM'] as $config) {
                if (!TrackingManagerStatus::getCookieStatus($config[0])) {
                    $configModel = new TmConfigModel();
                    $configModel->pid = $session->getId();
                    $configModel->tstamp = date('U');
                    $configModel->title = $config[0];
                    $configModel->save();
                }
            }
        }
        $frontendSession->remove('tm_config_set');


        // template and frontend logic
        $config = sha1(serialize($GLOBALS['TM']));
        $savedConfig = Tracking::getCookieValue('tm_base');

        if (!TrackingManagerStatus::getCookieStatus('tm_base') or ($config != $savedConfig)) {

            $objTpl = new FrontendTemplate($this->strTemplate);
            $objTpl->intro = $objRootPage->tm_intro;
            $objTpl->basecookieLabel = $objRootPage->tm_basecookie;
            $objTpl->url = Frontend::generateFrontendUrl(PageModel::findById($objRootPage->tm_link)->row());
            $objTpl->linktext = $objRootPage->tm_linktext;
            $objTpl->submit = $objRootPage->tm_submit;
            $objTpl->cookies = $GLOBALS['TM'];
            $objTpl->config = sha1(serialize($GLOBALS['TM']));

            $GLOBALS['TL_CSS'][] = '/bundles/app/css/trackingmanager.css';
            $GLOBALS['TL_JAVASCRIPT'][] = '/bundles/app/js/trackingmanager.js';
            $GLOBALS['TL_BODY'][]  = $objTpl->parse();

            // save config preparation
            /** @var SessionInterface $session */
            $session = System::getContainer()->get('session');
            $frontendSession = $session->getBag('contao_frontend');
            $frontendSession->set('tm_config_set', 1);

        }

    }


}