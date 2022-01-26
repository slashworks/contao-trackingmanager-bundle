<?php

namespace Slashworks\ContaoTrackingManagerBundle\Hook;

use Contao\Controller;
use Contao\Environment;
use Slashworks\ContaoTrackingManagerBundle\Model\UnknownCookie;
use Symfony\Component\VarDumper\VarDumper;

class GetSystemMessages
{

    public function addUnknownCookiesMessage()
    {
        $message = '';

        if (UnknownCookie::countAll() > 0) {
            $backendUrl = Environment::get('url') . '/contao';

            $info = sprintf(
                $GLOBALS['TL_LANG']['MSC']['BE']['unknownCookiesMessage'],
                $backendUrl . '?do=tmCookies',
                $backendUrl . '?do=tmUnknownCookies'
            );
            $message .= '<p class="tl_info">' . $info . '</p>';
        }

        return $message;
    }

}
