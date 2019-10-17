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
 * Google Analytics bozi_ga
 * Facebook Pixel   bozi_fbp
 * Optimizely       bozi_optimizely
 * Vimeo            bozi_vimeo
 * Youtube          bozi_youtube
 * Google Maps      bozi_gmaps
 *
 */

/* pflichtcookie für das Modul - System Relevante Cokkies */
$GLOBALS['TM'][] = array(

    //name des cookies
    'tm_base',

    //label des cookies
    'System relevante Cookies (erforderlich)',

    // cookie erklaerungen
    'description' => array(
        'PHPSESSID' => 'Behält die Zustände der jeweiligen Session bei allen Seitenanfragen bei.<br /><strong>Ablaufzeit: mit der Session</strong>',
        'tm_base' => 'Speichert den Zustimmungsstatus des Benutzers für Cookies auf der aktuellen Domäne.<br /><strong>Ablaufzeit: 4 Wochen</strong>',
    )
);


/* beispiel */
/* Google analaytics */
//$GLOBALS['TM'][] = array(
//
//    //name des cookies
//    'bozi_ga',
//
//    //label des cookies
//    'Google Analytics Tracking',
//
//    // cookie erklaerungen
//    'description' => array(
//        '_ga'   => 'Registriert eine eindeutige ID, die verwendet wird, um statistische Daten dazu, wie der Besucher die Website nutzt, zu generieren.<br><strong>Ablaufzeit: 2 Jahre</strong>',
//        '_gid'  => 'Registriert eine eindeutige ID, die verwendet wird, um statistische Daten dazu, wie der Besucher die Website nutzt, zu generieren.<br><strong>Ablaufzeit: 1 Tag</strong>',
//        '_gat'  => 'Wird von Google Analytics verwendet, um die Anforderungsrate einzuschränken.<br><strong>Ablaufzeit: 1 Tag</strong>',
//    )
//);

/* Facebook */
//$GLOBALS['TM'][] = array(
//
//    //name des cookies
//    'bozi_fbp',
//
//    //label des cookies
//    'Facebook Pixel',
//
//    // cookie erklaerungen
//    'description' => array(
//        '_fbp'   => 'Registriert eine eindeutige ID, die verwendet wird, um statistische Daten dazu, wie der Besucher die Website nutzt, zu generieren.<br><strong>Ablaufzeit: 3 Monate</strong>',
//    )
//);


/*  Youtube  */
//$GLOBALS['TM'][] = array(
//
//    //name des cookies
//    'bozi_youtube',
//
//    //label des cookies
//    'Youtube',
//
//    // cookie erklaerungen
////    'description' => array(
////        '_fbp'   => 'Registriert eine eindeutige ID, die verwendet wird, um statistische Daten dazu, wie der Besucher die Website nutzt, zu generieren.<br><strong>Ablaufzeit: 3 Monate</strong>',
////    )
//);


/*  Vimeo  */
//$GLOBALS['TM'][] = array(
//
//    //name des cookies
//    'bozi_vimeo',
//
//    //label des cookies
//    'Vimeo',
//
//    // cookie erklaerungen
////    'description' => array(
////        '_fbp'   => 'Registriert eine eindeutige ID, die verwendet wird, um statistische Daten dazu, wie der Besucher die Website nutzt, zu generieren.<br><strong>Ablaufzeit: 3 Monate</strong>',
////    )
//);

/*  Google Maps  */
//$GLOBALS['TM'][] = array(
//
//    //name des cookies
//    'bozi_gmaps',
//
//    //label des cookies
//    'Google Maps',
//
//    // cookie erklaerungen
////    'description' => array(
////        '_fbp'   => 'Registriert eine eindeutige ID, die verwendet wird, um statistische Daten dazu, wie der Besucher die Website nutzt, zu generieren.<br><strong>Ablaufzeit: 3 Monate</strong>',
////    )
//);
