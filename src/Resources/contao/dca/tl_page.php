<?php

use \Contao\CoreBundle\DataContainer\PaletteManipulator;

$tmPalette = PaletteManipulator::create()
    ->addLegend('trackingmanager_legend','twoFactor_legend',\Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_AFTER)
    ->addField(array('tm_active,tm_intro,tm_submit_all,tm_submit,tm_link,tm_linktext'),'trackingmanager_legend',\Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND);

$tmPalette->applyToPalette('root', 'tl_page');

if (array_key_exists('rootfallback', $GLOBALS['TL_DCA']['tl_page']['palettes'])) {
    $tmPalette->applyToPalette('rootfallback', 'tl_page');
}

$GLOBALS['TL_DCA']['tl_page']['fields']['tm_active'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_page']['tm_active'],
    'exclude'                 => true,
    'search'                  => 'true',
    'inputType'               => 'checkbox',
    'eval'                    => array('mandatory'=>false, 'maxlength'=>255, 'decodeEntities'=>true, 'tl_class'=>'clr m12'),
    'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_page']['fields']['tm_intro'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_page']['tm_intro'],
    'exclude'                 => true,
    'search'                  => true,
    'inputType'               => 'textarea',
    'eval'                    => array('mandatory'=>false,'allowHtml'=>true),
    'sql'                     => "mediumtext NULL"
);

$GLOBALS['TL_DCA']['tl_page']['fields']['tm_submit_all'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_page']['tl_submit_all'],
    'exclude'                 => true,
    'search'                  => true,
    'inputType'               => 'text',
    'eval'                    => array('mandatory'=>false, 'maxlength'=>255, 'decodeEntities'=>true, 'tl_class'=>'w50'),
    'sql'                     => "varchar(255) NOT NULL default ''"
);


$GLOBALS['TL_DCA']['tl_page']['fields']['tm_submit'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_page']['tm_submit'],
    'exclude'                 => true,
    'search'                  => true,
    'inputType'               => 'text',
    'eval'                    => array('mandatory'=>false, 'maxlength'=>255, 'decodeEntities'=>true, 'tl_class'=>'w50'),
    'sql'                     => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_page']['fields']['tm_link'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_page']['tm_link'],
    'exclude'                 => true,
    'inputType'               => 'pageTree',
    'foreignKey'              => 'tl_page.title',
    'eval'                    => array('fieldType'=>'radio', 'tl_class'=>'clr autoheight w50'),
    'sql'                     => "int(10) unsigned NOT NULL default '0'"
    );

$GLOBALS['TL_DCA']['tl_page']['fields']['tm_linktext'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_page']['tm_linktext'],
    'exclude'                 => true,
    'search'                  => true,
    'inputType'               => 'text',
    'eval'                    => array('mandatory'=>false, 'maxlength'=>255, 'decodeEntities'=>true, 'tl_class'=>'w50'),
    'sql'                     => "varchar(255) NOT NULL default ''"
);
