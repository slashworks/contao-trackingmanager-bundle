<?php

use Contao\CoreBundle\DataContainer\PaletteManipulator;

/**
 * Extend core palettes
 */
$trackingManagerFields = PaletteManipulator::create()
    ->addLegend('trackingmanager_legend', 'twoFactor_legend',PaletteManipulator::POSITION_AFTER)
    ->addField(array('tm_active'), 'trackingmanager_legend',PaletteManipulator::POSITION_APPEND);

if (isset($GLOBALS['TL_DCA']['tl_page']['palettes']['rootfallback'])) {
    $trackingManagerFields->applyToPalette('rootfallback', 'tl_page');
}
if (isset($GLOBALS['TL_DCA']['tl_page']['palettes']['root'])) {
    $trackingManagerFields->applyToPalette('root', 'tl_page');
}


/**
 * Define subpalette
 */
$GLOBALS['TL_DCA']['tl_page']['palettes']['__selector__'][] = 'tm_active';
$GLOBALS['TL_DCA']['tl_page']['subpalettes']['tm_active'] = 'tm_headline,tm_intro,tm_submit_all,tm_details,tm_submit,tm_linktext,tm_cookies_ttl,tm_link,tm_cookies,tm_editable';


/**
 * Define fields
 */
$GLOBALS['TL_DCA']['tl_page']['fields']['tm_active'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_page']['tm_active'],
    'exclude'   => true,
    'search'    => 'true',
    'inputType' => 'checkbox',
    'eval'      => array('mandatory' => false, 'tl_class' => 'clr m12', 'submitOnChange' => true),
    'sql'       => "char(1) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_page']['fields']['tm_headline'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_page']['tm_headline'],
    'exclude'   => true,
    'search'    => true,
    'inputType' => 'text',
    'eval'      => array('mandatory' => false, 'maxlength' => 255, 'decodeEntities' => true, 'tl_class' => 'w50'),
    'sql'       => "varchar(255) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_page']['fields']['tm_intro'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_page']['tm_intro'],
    'exclude'   => true,
    'search'    => true,
    'inputType' => 'textarea',
    'eval'      => array('mandatory' => false, 'allowHtml' => true, 'tl_class' => 'clr'),
    'sql'       => "mediumtext NULL",
);

$GLOBALS['TL_DCA']['tl_page']['fields']['tm_submit_all'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_page']['tl_submit_all'],
    'exclude'   => true,
    'search'    => true,
    'inputType' => 'text',
    'eval'      => array('mandatory' => false, 'maxlength' => 255, 'decodeEntities' => true, 'tl_class' => 'w50'),
    'sql'       => "varchar(255) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_page']['fields']['tm_details'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_page']['tm_details'],
    'exclude'   => true,
    'search'    => true,
    'inputType' => 'text',
    'eval'      => array('mandatory' => false, 'maxlength' => 255, 'decodeEntities' => true, 'tl_class' => 'w50'),
    'sql'       => "varchar(255) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_page']['fields']['tm_submit'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_page']['tm_submit'],
    'exclude'   => true,
    'search'    => true,
    'inputType' => 'text',
    'eval'      => array('mandatory' => false, 'maxlength' => 255, 'decodeEntities' => true, 'tl_class' => 'w50'),
    'sql'       => "varchar(255) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_page']['fields']['tm_link'] = array
(
    'label'      => &$GLOBALS['TL_LANG']['tl_page']['tm_link'],
    'exclude'    => true,
    'inputType'  => 'pageTree',
    'foreignKey' => 'tl_page.title',
    'eval'       => array('fieldType' => 'radio', 'tl_class' => 'clr autoheight w50'),
    'sql'        => "int(10) unsigned NOT NULL default '0'",
);

$GLOBALS['TL_DCA']['tl_page']['fields']['tm_cookies_ttl'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_page']['tm_cookies_ttl'],
    'default'   => 30,
    'exclude'   => true,
    'search'    => true,
    'inputType' => 'text',
    'eval'      => array('mandatory' => true, 'tl_class' => 'w50'),
    'sql'       => "INT(10) unsigned NOT NULL default '30'",
);

$GLOBALS['TL_DCA']['tl_page']['fields']['tm_linktext'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_page']['tm_linktext'],
    'exclude'   => true,
    'search'    => true,
    'inputType' => 'text',
    'eval'      => array('mandatory' => false, 'maxlength' => 255, 'decodeEntities' => true, 'tl_class' => 'w50'),
    'sql'       => "varchar(255) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_page']['fields']['tm_cookies'] = array
(
    'label'      => &$GLOBALS['TL_LANG']['tl_page']['tm_cookies'],
    'exclude'    => true,
    'search'     => true,
    'inputType'  => 'checkboxWizard',
    'foreignKey' => 'tl_tm_cookie.name',
    'eval'       => array('mandatory' => true, 'multiple' => true, 'tl_class' => 'w50 autoheight'),
    'sql'        => "blob NULL",
    'relation'   => array('type' => 'hasMany', 'load' => 'lazy'),
);

$GLOBALS['TL_DCA']['tl_page']['fields']['tm_editable'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_page']['tm_editable'],
    'exclude'   => true,
    'default'   => '1',
    'inputType' => 'checkbox',
    'eval'      => array('mandatory' => false, 'tl_class' => 'clr m12'),
    'sql'       => "char(1) NOT NULL default '1'",
);
