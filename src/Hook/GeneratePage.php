<?php

namespace Slashworks\ContaoTrackingManagerBundle\Hook;

use Contao\LayoutModel;
use Contao\PageModel;
use Contao\PageRegular;
use Slashworks\ContaoTrackingManagerBundle\Classes\TrackingManager;

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

}
