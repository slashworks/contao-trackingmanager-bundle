<?php

namespace Slashworks\ContaoTrackingManagerBundle\Classes;

use Contao\Backend;
use Slashworks\ContaoTrackingManagerBundle\Model\TrackingmanagerSettingsModel;


class CreateBase extends Backend
{

    public function createBase()
    {
        $this->createBaseCookie();
        $this->createGoogleAnalytics();
//        $this->createFacebookPixel();
//        $this->createGoogleMaps();

        \Controller::redirect(\Controller::getReferer());
    }

    /**
     *
     */
    public function createBaseCookie()
    {
        $objModel = new TrackingmanagerSettingsModel();
        $objModel->name = 'tm_base';
        $objModel->label = 'systemrelevante Cookies (erforderlich)';
        $objModel->published = '1';
        $objModel->tstamp = time();
        $objModel->isBaseCookie = '1';
        $objModel->descriptions = serialize(array(
            array(
                'label' => 'PHPSESSID',
                'description' => 'Behält die Zustände der jeweiligen Session bei allen Seitenanfragen bei.<br /><strong>Ablaufzeit: mit der Session</strong>'
            ),
            array(
                'label' => 'tm_base',
                'description' => 'Speichert den Zustimmungsstatus des Benutzers für Cookies auf der aktuellen Domäne.<br /><strong>Ablaufzeit: 4 Wochen</strong>',
            )
        ));

        $objModel->save();
    }

    /**
     *
     */
    public function createGoogleAnalytics()
    {

        $objModel = new TrackingmanagerSettingsModel();
        $objModel->name = 'bozi_ga';
        $objModel->label = 'Google Analytics Tracking';
        $objModel->published = '1';
        $objModel->tstamp = time();
        $objModel->descriptions = serialize(array(
            array(
                'label' => '_ga',
                'description' => 'Registriert eine eindeutige ID, die verwendet wird, um statistische Daten dazu, wie der Besucher die Website nutzt, zu generieren.<br><strong>Ablaufzeit: 2 Jahre</strong>'
            ),
            array(
                'label' => '_gid',
                'description' => 'Registriert eine eindeutige ID, die verwendet wird, um statistische Daten dazu, wie der Besucher die Website nutzt, zu generieren.<br><strong>Ablaufzeit: 1 Tag</strong>',
            ),
            array(
                'label' => '_gat',
                'description' => 'Wird von Google Analytics verwendet, um die Anforderungsrate einzuschränken.<br><strong>Ablaufzeit: 1 Tag</strong>',
            )
        ));

        $objModel->save();
    }

    /**
     *
     */
    public function createFacebookPixel()
    {

        $objModel = new TrackingmanagerSettingsModel();
        $objModel->name = 'bozi_fbp';
        $objModel->label = 'Facebook Pixel';
        $objModel->published = '1';
        $objModel->tstamp = time();
        $objModel->descriptions = serialize(array(
            array(
                'label' => '_fbp',
                'description' => 'Registriert eine eindeutige ID, die verwendet wird, um statistische Daten dazu, wie der Besucher die Website nutzt, zu generieren.<br><strong>Ablaufzeit: 3 Monate</strong>'
            )
        ));

        $objModel->save();
    }

    /**
     *
     */
    public function createGoogleMaps()
    {

        $objModel = new TrackingmanagerSettingsModel();
        $objModel->name = 'bozi_gmaps';
        $objModel->label = 'Google Maps';
        $objModel->published = '1';
        $objModel->tstamp = time();
        $objModel->descriptions = serialize(array(
            array(
//                'label' => '_fbp',
//                'description' => 'Registriert eine eindeutige ID, die verwendet wird, um statistische Daten dazu, wie der Besucher die Website nutzt, zu generieren.<br><strong>Ablaufzeit: 3 Monate</strong>'
            )
        ));

        $objModel->save();
    }



}
