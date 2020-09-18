<?php

namespace Slashworks\ContaoTrackingManagerBundle\Hook;

use Contao\Controller;
use Contao\PageModel;
use Contao\StringUtil;
use Slashworks\ContaoTrackingManagerBundle\Classes\TrackingManagerStatus;
use Slashworks\ContaoTrackingManagerBundle\Model\Cookie;
use Symfony\Component\VarDumper\VarDumper;

class ParseFrontendTemplate
{

    public function checkCookieDependency(string $buffer, string $template)
    {
        $analyticsTemplates = array_keys(Controller::getTemplateGroup('analytics'));
        if (!in_array($template, $analyticsTemplates)) {
            return $buffer;
        }

        $cookies = Cookie::getCookiesByRootpage();
        if ($cookies === null) {
            return $buffer;
        }

        $cancelOutput = false;

        foreach ($cookies as $cookie) {
            if ($cookie->isBaseCookie) {
                continue;
            }

            $templates = StringUtil::deserialize($cookie->templates);
            if (!in_array($template, $templates)) {
                continue;
            }

            if (!TrackingManagerStatus::getCookieStatus($cookie->name)) {
                $cancelOutput = true;
            } else {
                break;
            }
        }

        if ($cancelOutput) {
            return '';
        }

        return $buffer;
    }

}
