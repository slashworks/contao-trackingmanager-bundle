<?php

// Hooks
$GLOBALS['TL_HOOKS']['generatePage'][] = array('Slashworks\ContaoTrackingManagerBundle\Classes\TrackingManager', 'generatePageHook');


/**
 * Trackingmanager Config
 *
 * namen bitte mit heiko absprechen falls die analyse ueber den trackingmanager laeuft
 *
 * aktuelle absprache ins sachen namen wie folgt:
 *
 */

//$GLOBALS['TM'][] = array(
//
//    //name des cookies
//    'trackingfb',
//
//    //label des cookies
//    'Facebook Tracking erlauben',
//
//    // cookie erklaerungen
//    'description' => array(
//        'gesetzterCookie_1' => 'wird genutzt um dich ueberall orten zu können',
//        'gesetzterCookie_2' => 'wird ebenfalls genutzt um dich ueberall orten zu können, falls du den 1. löscht',
//    )
//
//);

//$GLOBALS['TM'][] = array('analytics light','Google Analytics erlauben');
