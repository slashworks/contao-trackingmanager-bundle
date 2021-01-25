<?php

namespace Slashworks\ContaoTrackingManagerBundle\Model;

use Contao\Model;
use Contao\PageModel;
use Contao\StringUtil;
use Symfony\Component\VarDumper\VarDumper;

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

        if (!$objRootPage->tm_active) {
            return null;
        }

        $arrCookies = StringUtil::deserialize($objRootPage->tm_cookies);
        $arrCookies = implode(',', $arrCookies);
        if (empty($arrCookies)) {
            return null;
        }

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

    public function getBrowserCookieNames()
    {
        $browserCookieNames = array();

        $descriptions = StringUtil::deserialize($this->descriptions, true);

        if (empty($descriptions[0]['label'])) {
            return $browserCookieNames;
        }

        foreach ($descriptions as $description) {
            $browserCookieNames[] = $description['label'];
        }

        return $browserCookieNames;
    }

}
