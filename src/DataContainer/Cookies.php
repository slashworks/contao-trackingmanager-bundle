<?php

namespace Slashworks\ContaoTrackingManagerBundle\DataContainer;

use Contao\CoreBundle\DataContainer\PaletteManipulator;
use Contao\DataContainer;
use Slashworks\ContaoTrackingManagerBundle\Model\Cookie;
use Symfony\Component\VarDumper\VarDumper;

class Cookies
{

    public function onloadCallback(DataContainer $dc)
    {
        $cookie = Cookie::findByPk($dc->id);

        // Add template selection to all cookies, except the base cookie.
        if (!$cookie->isBaseCookie) {
            PaletteManipulator::create()
                ->addLegend('template_legend', 'title_legend', PaletteManipulator::POSITION_AFTER)
                ->addField('templates', 'template_legend', PaletteManipulator::POSITION_APPEND)
                ->applyToPalette('default', Cookie::getTable());
        }
    }

    public function getTemplates()
    {
        $templates = array();

        $analyticsTemplates = \Contao\Controller::getTemplateGroup('analytics');

        $templates = array_merge($templates, $analyticsTemplates);

        return $templates;
    }

}
