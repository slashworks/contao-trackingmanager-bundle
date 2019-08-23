<?php


$GLOBALS['TL_DCA']['tl_page']['palettes']['root'] = str_replace('includeLayout;','includeLayout;{trackingmanager_legend},tm_active,tm_intro,tm_basecookie,tm_submit,tm_link,tm_linktext;',$GLOBALS['TL_DCA']['tl_page']['palettes']['root']);

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
    'inputType'               => 'text',
    'eval'                    => array('mandatory'=>false, 'maxlength'=>255, 'decodeEntities'=>true, 'tl_class'=>'w50'),
    'sql'                     => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_page']['fields']['tm_basecookie'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_page']['tm_basecookie'],
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
    'eval'                    => array('fieldType'=>'radio','tl_class'=>'w50 autoHeight'), // do not set mandatory (see #5453)
    'sql'                     => "int(10) unsigned NOT NULL default '0'",
    'relation'                => array('type'=>'hasOne', 'load'=>'lazy')
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