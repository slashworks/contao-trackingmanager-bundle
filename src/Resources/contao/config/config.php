<?php

/**
 * Register backend modules
 */
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
    ),
    'tmUnknownCookies' => array
    (
        'tables' => array('tl_tm_unknown_cookie'),
    ),
);


/**
 * Register models
 */
$GLOBALS['TL_MODELS']['tl_tm_cookie'] = \Slashworks\ContaoTrackingManagerBundle\Model\Cookie::class;
$GLOBALS['TL_MODELS']['tl_tm_statistic'] = \Slashworks\ContaoTrackingManagerBundle\Model\Statistic::class;
$GLOBALS['TL_MODELS']['tl_tm_unknown_cookie'] = \Slashworks\ContaoTrackingManagerBundle\Model\UnknownCookie::class;


/**
 * Register hooks
 */
$GLOBALS['TL_HOOKS']['generatePage'][] = array(\Slashworks\ContaoTrackingManagerBundle\Hook\GeneratePage::class, 'generateTrackingManager');
$GLOBALS['TL_HOOKS']['generatePage'][] = array(\Slashworks\ContaoTrackingManagerBundle\Hook\GeneratePage::class, 'checkUnknownCookies');

$GLOBALS['TL_HOOKS']['parseFrontendTemplate'][] = array(\Slashworks\ContaoTrackingManagerBundle\Hook\ParseFrontendTemplate::class, 'checkCookieDependency');

$GLOBALS['TL_HOOKS']['replaceInsertTags'][] = array(\Slashworks\ContaoTrackingManagerBundle\Hook\ReplaceInsertTags::class, 'replaceTrackingManagerEditor');

$GLOBALS['TL_HOOKS']['getSystemMessages'][] = array(\Slashworks\ContaoTrackingManagerBundle\Hook\GetSystemMessages::class, 'addUnknownCookiesMessage');


/**
 * Cron jobs
 */
$GLOBALS['TL_CRON']['minutely'][] = array(\Slashworks\ContaoTrackingManagerBundle\Cron\UnknownCookieNotification::class, 'run');


/**
 * Asset handling
 */
if (TL_MODE === 'FE') {

} else {
    $combiner = new \Combiner();
    $combiner->add('/bundles/contaotrackingmanager/css/backend.scss');
    $GLOBALS['TL_CSS'][] = $combiner->getCombinedFile();
}
