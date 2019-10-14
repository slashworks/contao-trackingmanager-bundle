<?php

// Hooks
$GLOBALS['TL_HOOKS']['generatePage'][] = array('Slashworks\ContaoTrackingManagerBundle\Classes\TrackingManager', 'generatePageHook');


// Trackingmanager Config
//$GLOBALS['TM'][] = array('trackingfb','Facebook Tracking erlauben');
//$GLOBALS['TM'][] = array('analytics','Google Analytics erlauben');
