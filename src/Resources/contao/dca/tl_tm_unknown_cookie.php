<?php

$GLOBALS['TL_DCA']['tl_tm_unknown_cookie'] = array
(

    // Config
    'config'   => array
    (
        'dataContainer'   => 'Table',
        'onload_callback' => array(),
        'closed'          => true,
        'sql'             => array
        (
            'keys' => array
            (
                'id' => 'primary',
            ),
        ),
    ),

    // List
    'list'     => array
    (
        'sorting'           => array
        (
            'mode'            => 1,
            'fields'          => array('name'),
            'icon'            => 'pagemounts.svg',
            'panelLayout'     => 'filter;search,sort',
            'disableGrouping' => true,
        ),
        'label'             => array
        (
            'fields'      => array('name', 'tstamp'),
            'showColumns' => true,
            'label_callback' => array(\Slashworks\ContaoTrackingManagerBundle\DataContainer\UnknownCookie::class, 'labelCallback'),
        ),
        'global_operations' => array(),
        'operations'        => array
        (
            'delete' => array
            (
                'href'       => 'act=delete',
                'icon'       => 'delete.svg',
                'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"',
            ),
            'show'   => array
            (
                'href' => 'act=show',
                'icon' => 'show.svg',
            ),
        ),
    ),

    // Palettes
    'palettes' => array
    (
        'default' => '{title_legend},name,tstamp;{email_legend},notificationSent',
    ),

    // Fields
    'fields'   => array
    (
        'id'               => array
        (
            'sql' => "int(10) unsigned NOT NULL auto_increment",
        ),
        'tstamp'           => array
        (
            'label'   => &$GLOBALS['TL_LANG']['tl_tm_unknown_cookie']['tstamp'],
            'sorting' => true,
            'sql'     => "int(10) unsigned NOT NULL default '0'",
        ),
        'name'             => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_tm_unknown_cookie']['name'],
            'exclude'   => true,
            'search'    => true,
            'sorting'   => true,
            'inputType' => 'text',
            'eval'      => array('tl_class' => 'w50'),
            'sql'       => "varchar(255) NOT NULL default ''",
        ),
        'notificationSent' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_tm_unknown_cookie']['notificationSent'],
            'exclude'   => true,
            'search'    => true,
            'sorting'   => true,
            'inputType' => 'checkbox',
            'eval'      => array('tl_class' => 'w50'),
            'sql'       => "varchar(255) NOT NULL default ''",
        ),
    ),
);
