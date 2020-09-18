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

        if ($cookie->isBaseCookie) {
            PaletteManipulator::create()
                ->removeField('templates', 'template_legend')
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
