<?php

namespace Slashworks\ContaoTrackingManagerBundle\DataContainer;

use Contao\Backend;
use Contao\DataContainer;
use Contao\Date;
use Contao\System;
use Symfony\Component\VarDumper\VarDumper;

class UnknownCookie
{

    public function labelCallback($row, $label, DataContainer $dc, $args)
    {
        $image = 'send';
        $notificationSent = $row['notificationSent'];
        if (!$notificationSent) {
            $image .= '_';
        }

        $args[0] = sprintf(
            '<div class="list_icon_new" style="display: inline-block; padding-right: 8px; background-image:url(\'bundles/contaotrackingmanager/img/%s.svg\')" data-icon="%s.svg" data-icon-disabled="%s.svg" title="%s">&nbsp;</div>',
            $image,
            $disabled ? $image : rtrim($image, '_'),
            rtrim($image, '_') . '_',
            $notificationSent ? $GLOBALS['TL_LANG']['tl_tm_unknown_cookie']['BE']['notificationSent'] : $GLOBALS['TL_LANG']['tl_tm_unknown_cookie']['BE']['notificationNotSent']) . $args[0];

        $args[1] = Date::parse($GLOBALS['TL_CONFIG']['datimFormat'], $args[1]);

        return $args;
    }

}
