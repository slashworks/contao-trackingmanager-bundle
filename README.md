Contao 4 Tracking Manager Bundle
================================

## Installation

Via ContaoManager oder Composer `composer require slashworks/contao-trackingmanager-bundle`

## Einrichtung

In der jeweiligen Root Seite den Trackingmanager aktivieren und entsprechend die Felder füllen für Text, Buttons usw.

### Konfiguration der Cookies

In einer config oder einem Modul deiner Wahl müssen die Cookies und deren Beschreibung gepflegt werden. Ein aktuelles Beispiel findet sich in der Modulconfig.
Es gibt einen Pflichtcookie-Hinweis

    $GLOBALS['TM'][] = array(
        //name des cookies
        'tm_base',

        //label des cookies
        'System relevante Cookies (erforderlich)',

        // cookie erklaerungen
        'description' => array(
            'PHPSESSID' => 'Behält die Zustände der jeweiligen Session bei allen Seitenanfragen bei.<br /><strong>Ablaufzeit: mit der Session</strong>',
            'tm_base' => 'Speichert den Zustimmungsstatus des Benutzers für Cookies auf der aktuellen Domäne.<br /><strong>Ablaufzeit: 4 Wochen</strong>',
            'bozi_ga' => 'Speichert den Zustimmungsstatus des Benutzers für Cookies auf der aktuellen Domäne.<br /><strong>Ablaufzeit: 4 Wochen</strong>',
        )
    );



Für jedes weitere Cookie welches aktiviert / deaktiviert werden kann, muss das Array entsprechend der Vorgabe erweitert werden. Die Namen der Cookies brauchen wir später.

    // Beispiel fuer Google analytics
    $GLOBALS['TM'][] = array(

    //name des cookies
    'bozi_ga',

    //label des cookies
    'Google Analytics Tracking',

    // cookie erklaerungen
    'description' => array(
        '_ga'   => 'Registriert eine eindeutige ID, die verwendet wird, um statistische Daten dazu, wie der Besucher die Website nutzt, zu generieren.<br><strong>Ablaufzeit: 2 Jahre</strong>',
        '_gid'  => 'Registriert eine eindeutige ID, die verwendet wird, um statistische Daten dazu, wie der Besucher die Website nutzt, zu generieren.<br><strong>Ablaufzeit: 1 Tag</strong>',
        '_gat'  => 'Wird von Google Analytics verwendet, um die Anforderungsrate einzuschränken.<br><strong>Ablaufzeit: 1 Tag</strong>',
     )
    );

Bis hierhin steuern wir lediglich die Anzeige des Managers. Es findet noch keine Unterbindung der Cookies statt.


## Code zum verhindern der Cookies

Wenn der Trackingmanager angezeigt wird und der User seine Cookies akzeptiert, setzt der Manager eigene Cookies, um sich die Auswahl zu merken. Der Name des Cookies entspricht dem der Konfiguration. (z.B. tm_base und bozi_ga).
Im tm_base Cookie speichern wir die aktuelle Konfiguration. Ändert sich diese, wird der Trackingmanager erneut angezeigt.

In deinem Code, welcher entsprechende Cookies setzen will, können wir nun eine Abfrage machen, ob Cookie XY akzeptiert wurde.

    if(TrackingManagerStatus::getCookieStatus('bozi_ga')){}

Das steuert die Ausgabe, wenn bozi_ga akzeptiert wurde. Also im Template einfach den Codebereich damit umschließen. Das kann mit jedem konfiguriertem Cookie so genutzt werden.



