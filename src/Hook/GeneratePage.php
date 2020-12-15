<?php

namespace Slashworks\ContaoTrackingManagerBundle\Hook;

use Contao\Input;
use Contao\LayoutModel;
use Contao\PageModel;
use Contao\PageRegular;
use Contao\System;
use Slashworks\ContaoTrackingManagerBundle\Classes\TrackingManager;
use Symfony\Component\VarDumper\VarDumper;

class GeneratePage
{
    /**
     *
     *
     * @param PageModel   $page
     * @param LayoutModel $layout
     * @param PageRegular $pageRegular
     */
    public function generateTrackingManager(PageModel $page, LayoutModel $layout, PageRegular $pageRegular)
    {
        $trackingManager = new TrackingManager();
        $trackingManager->setPage($page);
        $trackingManager->generate();
    }

    public function checkUnknownCookies(PageModel $page, LayoutModel $layout, PageRegular $pageRegular)
    {
        // Do not check them if a backend user is logged in because the contao backend generates cookies by itself.
        if ($this->backendUserLoggedIn()) {
            return false;
        }

        $trackingManager = new TrackingManager();
        $trackingManager->setPage($page);
        $trackingManager->checkCookies();
    }

    /**
     * @return bool
     */
    protected function backendUserLoggedIn()
    {
        if (version_compare(VERSION, '4.4', '<=')) {
            if (!isset($_COOKIE['BE_USER_AUTH'])) {
                return false;
            }

            return Input::cookie('BE_USER_AUTH') == System::getSessionHash('BE_USER_AUTH');
        } else {
            if (System::getContainer()->get('contao.security.token_checker')->hasBackendUser() || BE_USER_LOGGED_IN) {
                return true;
            }
        }

        return false;
    }

}
