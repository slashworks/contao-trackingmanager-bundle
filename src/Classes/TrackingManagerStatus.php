<?php

namespace Slashworks\ContaoTrackingManagerBundle\Classes;


class TrackingManagerStatus
{


    /**
     * @return int
     *
     * 0 = no tracking allowed
     * 1 = allow trackingCookies
     */
    public static function getTreckingStatus()
    {
        // TODO rausfinden zu was man das gebrauchen kann
        return 0;
    }


    /**
     * @return array
     *
     * return name of all Cookies that are allowed
     */
    public static function getCookieStatus($name)
    {

        if(\Input::cookie($name)){
            return true;
        };

        return false;

    }

    /**
     * @param $name
     *
     * @return bool|mixed
     */
    public static function getCookieValue($name)
    {

        if(\Input::cookie($name)){
            return \Input::cookie($name);
        };

        return false;

    }
}