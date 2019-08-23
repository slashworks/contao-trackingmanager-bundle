<?php

// Hooks
$GLOBALS['TL_HOOKS']['generatePage'][] = array('Slashworks\ContaoTrackingManagerBundle\Classes', 'generatePageHook');


// Trackingmanager Config
$GLOBALS['TM'][] = array('trackingfb','Facebook Tracking erlauben');
$GLOBALS['TM'][] = array('analytics','Google Analytics erlauben');

$GLOBALS['BE_MOD']['Trackingmanager'] = array(

    'configs' => array
    (
        'tables'      => array('tl_tmConfig')
    )
);