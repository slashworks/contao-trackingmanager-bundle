Contao 4 Tracking Manager Bundle
================================

## Installation
Via ContaoManager oder Composer `composer require slashworks/contao-trackingmanager-bundle`

## Einrichtung
In der jeweiligen Root Seite den Trackingmanager aktivieren und entsprechend die Felder füllen für Text, Buttons usw.

### Konfiguration der Cookies
Im Backend unter Trackingmanager lassen sich nun beliebig viele Cookies anlegen. Das dient lediglich der späteren Steuerung. Man kann eine Basiskonfigration erzeugen mit dem Button "Erstelle Basis Konfiguration".
Der legt einmal einen systemrelevanten Cookiehinweis an und Google Analytics (Stand 06-2020).
Wir müssen für jede Sprache die Hinweise einzeln anlegen und mindestens ein Basiscookie je Sprache definieren.

Zu guter letzt müssen wir wieder in die Wurzelseite unserer Srpache wechseln und auswählen, welche Cookies hier abgefragt werden sollen.

Bis hierhin steuern wir lediglich die Anzeige des Managers. Es findet noch keine Unterbindung der Cookies statt.


## Code zum verhindern der Cookie-Ausgabe bzw. des Skriptes welches die Cookies setzen würde
Wenn der Trackingmanager angezeigt wird und der User seine Cookies akzeptiert, setzt der Manager eigene Cookies, um sich die Auswahl zu merken. Der Name des Cookies entspricht dem der Konfiguration. (z.B. tm_base und bozi_ga).
Im tm_base Cookie speichern wir die aktuelle Konfiguration. Ändert sich diese, wird der Trackingmanager erneut angezeigt.

In deinem Code, welcher entsprechende Cookies setzen will, können wir nun eine Abfrage machen, ob Cookie XY akzeptiert wurde.

    if(TrackingManagerStatus::getCookieStatus('bozi_ga')){}

    //oder mehrsprachig falls es das selbe Skript ist
    if(TrackingManagerStatus::getCookieStatus('bozi_ga') or TrackingManagerStatus::getCookieStatus('bozi_ga_en')){} …usw

Das steuert die Ausgabe, wenn bozi_ga akzeptiert wurde. Also im Template einfach den Codebereich damit umschließen. Das kann mit jedem konfiguriertem Cookie so genutzt werden.


## Statistik erweitern
Die Statisitk lässt sich erweitern durch hinzufügen eines Hooks. Dieser muss wie folgt aussehen:

     $GLOBALS['TL_HOOKS']['generateTimeConfig'] =
            array('myRowTitle' => array(
                'start' => new \DateTime('01.01.1970'),
                'end' => new \DateTime(),
                'status' => 1
                )
            );

Dazu braucht ihr dann eine Sprachvariable für den Zeitraum-Titel.

     $GLOBALS['TL_LANG']['tl_tmConfig']['myRowTitle'] = 'My language variable';

