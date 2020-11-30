<?php

namespace Slashworks\ContaoTrackingManagerBundle\Classes;


use Contao\PageModel;
use Slashworks\ContaoTrackingManagerBundle\Model\Cookie;
use Symfony\Component\VarDumper\VarDumper;

class TrackingManagerStatus
{


    /**
     * @return int
     *
     * 0 = no tracking allowed
     * 1 = allow trackingCookies
     */
    public static function getTrackingStatus()
    {
        // TODO rausfinden zu was man das gebrauchen kann
        return 0;
    }

    public static function getBaseCookieName()
    {
        /** @var PageModel $objPage */
        global $objPage;

        $rootpage = PageModel::findByPk($objPage->rootId);
        $baseCookie = Cookie::getBaseCookieByRootPage($rootpage);
        if ($baseCookie === null) {
            return false;
        }

        return $baseCookie->name;
    }

    public static function isBaseCookieSet()
    {
        return !empty(\Input::cookie(static::getBaseCookieName()));
    }

    /**
     * @return array
     *
     * return name of all Cookies that are allowed
     */
    public static function getCookieStatus($name)
    {
        if (\Input::cookie($name) && static::isBaseCookieSet()) {
            return true;
        }

        return false;
    }

    /**
     * @param $name
     *
     * @return bool|mixed
     */
    public static function getCookieValue($name)
    {
        if (\Input::cookie($name)) {
            return \Input::cookie($name);
        }

        return false;
    }

    public static function getBaseCookieValue()
    {
        return static::getCookieValue(static::getBaseCookieName());
    }
}
