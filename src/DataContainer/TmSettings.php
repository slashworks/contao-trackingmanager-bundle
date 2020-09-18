<?php

namespace Slashworks\ContaoTrackingManagerBundle\DataContainer;

use Contao\CoreBundle\DataContainer\PaletteManipulator;
use Contao\DataContainer;
use Slashworks\ContaoTrackingManagerBundle\Model\TrackingmanagerSettingsModel;
use Symfony\Component\VarDumper\VarDumper;

class TmSettings
{

    public function onloadCallback(DataContainer $dc)
    {
        $cookie = TrackingmanagerSettingsModel::findByPk($dc->id);

        if ($cookie->isBaseCookie) {
            PaletteManipulator::create()
                ->removeField('templates', 'template_legend')
                ->applyToPalette('default', TrackingmanagerSettingsModel::getTable());
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
