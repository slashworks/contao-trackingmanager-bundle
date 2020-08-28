<?php

$GLOBALS['TL_DCA']['tl_tmConfig'] = array
(

    // Config
    'config' => array
    (
        'dataContainer' => 'Table',
        'sql' => array
        (
            'keys' => array
            (
                'id' => 'primary',
            ),
        ),
    ),

    // List
    'list' => array
    (
        'sorting' => array
        (
            'mode' => 2,
            'fields' => array('pid'),
            'icon' => 'pagemounts.svg',
            'panelLayout' => 'filter;search,sort',
        ),
        'label' => array
        (
            'fields' => array('tstamp','title'),
            'format' => "%s - %s",
            'showColumns' => false
        ),
        'global_operations' => array
        (),
        'operations' => array
        (),
    ),

    // Palettes
    'palettes' => array
    (
        'default' => '{title_legend},title,alias,type',
    ),

    // Subpalettes
    'subpalettes' => array
    (),

    // Fields
    'fields' => array
    (
        'id' => array
        (
            'label' => array('ID'),
            'sql' => "int(10) unsigned NOT NULL auto_increment",
        ),
        'tstamp' => array
        (
            'label' => &$GLOBALS['TL_LANG']['tl_tmConfig']['tstamp'],
            'sorting' => true,
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'pid' => array
        (
            'label' => &$GLOBALS['TL_LANG']['tl_tmConfig']['pid'],
            'sql' => "varchar(255) NOT NULL default ''",
        ),
        'title' => array
        (
            'label' => &$GLOBALS['TL_LANG']['tl_tmConfig']['title'],
            'exclude' => true,
            'search' => true,
            'sorting' => true,
            'inputType' => 'text',
            'eval' => array(),
            'sql' => "varchar(255) NOT NULL default ''",
        ),
        'status' => array
        (
            'label' => &$GLOBALS['TL_LANG']['tl_tmConfig']['status'],
            'sql' => "char(1) NOT NULL default ''",
        ),
    )
);
