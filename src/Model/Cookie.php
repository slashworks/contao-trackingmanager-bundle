<?php

namespace Slashworks\ContaoTrackingManagerBundle\Model;

use Contao\Model;
use Contao\PageModel;
use Contao\StringUtil;

/**
 * Class Cookie
 *
 * @package Slashworks\ContaoTrackingManagerBundle\Model
 *
 * @property integer $id
 * @property integer $tstamp
 * @property integer $pid
 * @property string  $name
 * @property string  $label
 * @property boolean $isBaseCookie
 * @property boolean $published
 * @property string  $descriptions
 * @property string  $templates
 */
class Cookie extends Model
{

    protected static $strTable = 'tl_tm_cookie';

    /**
     * @param PageModel|null $objRootPage
     *
     * @return Model|Model[]|Model\Collection|null
     */
    public static function getCookiesByRootpage(PageModel $objRootPage = null)
    {
        if ($objRootPage === null) {
            /** @var PageModel $objPage */
            global $objPage;

            $objRootPage = PageModel::findByPk($objPage->rootId);
        }

        $arrCookies = StringUtil::deserialize($objRootPage->tm_cookies);
        $arrCookies = implode(',', $arrCookies);

        $arrOptions = array(
            'column' => array('published = 1 and id IN(' . $arrCookies . ')'),
        );

        $objCookieSettings = self::find($arrOptions);

        return $objCookieSettings;
    }

    /**
     * @param PageModel $objRootPage
     *
     * @return Cookie|null
     */
    public static function getBaseCookieByRootPage(PageModel $objRootPage)
    {
        $arrCookies = StringUtil::deserialize($objRootPage->tm_cookies);
        $arrCookies = implode(',', $arrCookies);

        $arrOptions = array(
            'column' => array('published = 1 and id IN(' . $arrCookies . ') and isBaseCookie = 1'),
            'limit'  => 1,
            'return' => 'Model',
        );

        $objCookieSettings = self::find($arrOptions);

        return $objCookieSettings;
    }

}
