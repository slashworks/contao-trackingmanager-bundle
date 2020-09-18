<?php

// Models
$GLOBALS['TL_MODELS']['tl_tm_cookie'] = \Slashworks\ContaoTrackingManagerBundle\Model\Cookie::class;
$GLOBALS['TL_MODELS']['tl_tm_statistic'] = \Slashworks\ContaoTrackingManagerBundle\Model\Statistic::class;

// Hooks
$GLOBALS['TL_HOOKS']['generatePage'][] = array('Slashworks\ContaoTrackingManagerBundle\Classes\TrackingManager', 'generatePageHook');
$GLOBALS['TL_HOOKS']['parseFrontendTemplate'][] = array(\Slashworks\ContaoTrackingManagerBundle\Hook\ParseFrontendTemplate::class, 'checkCookieDependency');

// Backendmodul
$GLOBALS['BE_MOD']['trackingmanager'] = array(

    'tmCookies' => array
    (
        'tables'      => array('tl_tm_cookie'),
        'createBase' => array('Slashworks\ContaoTrackingManagerBundle\Classes\CreateBase', 'createBase'),
    ),
    'tmStatistics' => array
    (
        'callback' => \Slashworks\ContaoTrackingManagerBundle\Classes\Backend\StatisticsDataManager::class,
        'tables'      => array('tl_tm_statistic'),

    )
);
