<?php

// Models
$GLOBALS['TL_MODELS']['tl_tmSettings'] = \Slashworks\ContaoTrackingManagerBundle\Model\TrackingmanagerSettingsModel::class;
$GLOBALS['TL_MODELS']['tl_tmConfig'] = \Slashworks\ContaoTrackingManagerBundle\Model\TmConfigModel::class;

// Hooks
$GLOBALS['TL_HOOKS']['generatePage'][] = array('Slashworks\ContaoTrackingManagerBundle\Classes\TrackingManager', 'generatePageHook');

// Backendmodul
$GLOBALS['BE_MOD']['trackingmanager'] = array(

    'tmSettings' => array
    (
        'tables'      => array('tl_tmSettings'),
        'createBase' => array('Slashworks\ContaoTrackingManagerBundle\Classes\CreateBase', 'createBase'),
    ),
    'tmConfig' => array
    (
        'callback' => \Slashworks\ContaoTrackingManagerBundle\Classes\Backend\ConfigDataManager::class,
        'tables'      => array('tl_tmConfig'),

    )
);
