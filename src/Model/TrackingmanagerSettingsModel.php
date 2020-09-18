<?php

namespace Slashworks\ContaoTrackingManagerBundle\Model;

use Contao\Model;
use Contao\PageModel;
use Contao\StringUtil;

Class TrackingmanagerSettingsModel extends Model
{

    protected static $strTable = 'tl_tmSettings';

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
        $arrCookies = implode(',',$arrCookies);

        $arrOptions = array(
            'column' => array('published = 1 and id IN('.$arrCookies.')')
        );

        $objCookieSettings = self::find($arrOptions);

        return $objCookieSettings;
    }

    /**
     * @param PageModel $objRootPage
     * @return Model|Model[]|Model\Collection|null
     */
    public static function getBaseCookieByRootPage(PageModel $objRootPage)
    {
        $arrCookies = StringUtil::deserialize($objRootPage->tm_cookies);
        $arrCookies = implode(',',$arrCookies);

        $arrOptions = array(
            'column' => array('published = 1 and id IN('.$arrCookies.') and isBaseCookie = 1'),
            'return' => 'Model',
        );

        $objCookieSettings = self::find($arrOptions);

        return $objCookieSettings;
    }

}
