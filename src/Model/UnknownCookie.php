<?php

namespace Slashworks\ContaoTrackingManagerBundle\Model;

use Contao\Model;
use Symfony\Component\VarDumper\VarDumper;

/**
 * Class UnknownCookie
 *
 * @package Slashworks\ContaoTrackingManagerBundle\Model
 *
 * @property integer $id
 * @property integer $tstamp
 * @property string  $name
 * @property boolean $notificationSent
 */
class UnknownCookie extends Model
{

    protected static $strTable = 'tl_tm_unknown_cookie';

    public static function findAllUnsent()
    {
        $options = array
        (
            'column' => array
            (
                'notificationSent != 1',
            ),
        );

        return static::find($options);
    }

}
