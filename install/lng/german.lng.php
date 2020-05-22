<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2003-2009 the SysCP Team (see authors).
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Florian Lippert <flo@syscp.org> (2003-2009)
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Language
 *
 */
$lng['requirements']['title'] = 'Prüfe Systemvoraussetzungen...';
$lng['requirements']['installed'] = 'installiert';
$lng['requirements']['not_true'] = 'nein';
$lng['requirements']['notfound'] = 'nicht gefunden';
$lng['requirements']['notinstalled'] = 'nicht installiert';
$lng['requirements']['activated'] = 'ist aktiviert.';
$lng['requirements']['phpversion'] = 'PHP Version >= 7.0';
$lng['requirements']['newerphpprefered'] = 'Passt, aber php-7.1 wird bevorzugt.';
$lng['requirements']['phppdo'] = 'PHP PDO Erweiterung und PDO-MySQL Treiber...';
$lng['requirements']['phpsession'] = 'PHP session-Erweiterung...';
$lng['requirements']['phpctype'] = 'PHP ctype-Erweiterung...';
$lng['requirements']['phpsimplexml'] = 'PHP SimpleXML-Erweiterung...';
$lng['requirements']['phpxml'] = 'PHP XML-Erweiterung...';
$lng['requirements']['phpfilter'] = 'PHP filter-Erweiterung...';
$lng['requirements']['phpposix'] = 'PHP posix-Erweiterung...';
$lng['requirements']['phpbcmath'] = 'PHP bcmath-Erweiterung...';
$lng['requirements']['phpcurl'] = 'PHP curl-Erweiterung...';
$lng['requirements']['phpmbstring'] = 'PHP mbstring-Erweiterung...';
$lng['requirements']['phpzip'] = 'PHP zip-Erweiterung...';
$lng['requirements']['phpjson'] = 'PHP json-Erweiterung...';
$lng['requirements']['bcmathdescription'] = 'Traffic-Berechnungs bezogene Funktionen stehen nicht vollständig zur Verfügung!';
$lng['requirements']['zipdescription'] = 'Die Auto-Update Funktion benötigt die zip Erweiterung.';
$lng['requirements']['openbasedir'] = 'open_basedir genutzt wird...';
$lng['requirements']['openbasedirenabled'] = 'Froxlor wird mit aktiviertem open_basedir nicht vollständig funktionieren. Bitte deaktivieren Sie open_basedir für Froxlor in der entsprechenden php.ini';
$lng['requirements']['mysqldump'] = 'MySQL dump Tool';
$lng['requirements']['mysqldumpmissing'] = 'Ein automatisches Backup einer möglicherweise schon existierenden Datenbank nicht möglich. Bitte mysql-client installieren';
$lng['requirements']['diedbecauseofrequirements'] = 'Kann Froxlor ohne diese Voraussetzungen nicht installieren! Beheben Sie die angezeigten Probleme und versuchen Sie es erneut.';
$lng['requirements']['froxlor_succ_checks'] = 'Alle Vorraussetzungen sind erfüllt';

$lng['install']['lngtitle'] = 'Froxlor Installation - Sprache auswählen';
$lng['install']['language'] = 'Sprache für die Installation';
$lng['install']['lngbtn_go'] = 'Sprache ändern';
$lng['install']['title'] = 'Froxlor Installation - Einrichtung';
$lng['install']['welcometext'] = 'Vielen Dank dass Sie sich für Froxlor entschieden haben. Um die Installation von Froxlor zu starten, füllen Sie bitte alle Felder mit den geforderten Angaben aus.<br /><b>Achtung:</b> Eine eventuell existierende Datenbank, die den selben Namen hat wie den Gewählten, wird mit allen enthaltenen Daten gelöscht!';
$lng['install']['database'] = 'Datenbankverbindung';
$lng['install']['mysql_host'] = 'MySQL-Hostname';
$lng['install']['mysql_database'] = 'Datenbank Name';
$lng['install']['mysql_unpriv_user'] = 'Benutzername für den unprivilegierten MySQL-Account';
$lng['install']['mysql_unpriv_pass'] = 'Passwort für den unprivilegierten MySQL-Account';
$lng['install']['mysql_root_user'] = 'Benutzername für den MySQL-Root-Account';
$lng['install']['mysql_root_pass'] = 'Passwort für den MySQL-Root-Account';
$lng['install']['admin_account'] = 'Admin-Zugang';
$lng['install']['admin_user'] = 'Administrator-Benutzername';
$lng['install']['admin_pass1'] = 'Administrator-Passwort';
$lng['install']['admin_pass2'] = 'Administrator-Passwort (Bestätigung)';
$lng['install']['activate_newsfeed'] = 'Aktiviere das offizielle Newsfeed<br><small>(https://inside.froxlor.org/news/)</small>';
$lng['install']['serversettings'] = 'Servereinstellungen';
$lng['install']['servername'] = 'Servername (FQDN, keine IP-Adresse)';
$lng['install']['serverip'] = 'Server-IP';
$lng['install']['webserver'] = 'Webserver';
$lng['install']['apache2'] = 'Apache 2';
$lng['install']['apache24'] = 'Apache 2.4';
$lng['install']['lighttpd'] = 'LigHTTPd';
$lng['install']['nginx'] = 'NGINX';
$lng['install']['httpuser'] = 'HTTP Username';
$lng['install']['httpgroup'] = 'HTTP Gruppenname';

$lng['install']['testing_mysql'] = 'Teste MySQL-Root Zugang...';
$lng['install']['testing_mysql_fail'] = 'Bei der Verwendung der Datenbank gibt es scheinbar Probleme. Installation kann nicht fortgesetzt werden. Bitte Zugangsdaten prüfen und erneut versuchen.';
$lng['install']['backup_old_db'] = 'Sicherung vorheriger Datenbank...';
$lng['install']['backup_binary_missing'] = 'Konnte mysqldump nicht finden';
$lng['install']['backup_failed'] = 'Sicherung fehlgeschlagen';
$lng['install']['prepare_db'] = 'Datenbank wird vorbereitet...';
$lng['install']['create_mysqluser_and_db'] = 'Erstelle Datenbank und Benutzer...';
$lng['install']['testing_new_db'] = 'Teste, ob Datenbank und Benutzer korrekt angelegt wurden...';
$lng['install']['importing_data'] = 'Importiere Daten...';
$lng['install']['changing_data'] = 'Einstellungen anpassen...';
$lng['install']['creating_entries'] = 'Trage neue Werte ein...';
$lng['install']['adding_admin_user'] = 'Erstelle Admin-Benutzer...';
$lng['install']['creating_configfile'] = 'Erstelle Konfigurationsdatei...';
$lng['install']['creating_configfile_temp'] = 'Datei wurde in %s gespeichert, bitte nach ' . dirname(dirname(__DIR__)) . '/lib/userdata.inc.php verschieben.';
$lng['install']['creating_configfile_failed'] = 'Konnte ' . dirname(dirname(__DIR__)) . '/lib/userdata.inc.php nicht erstellen, bitte manuell mit folgendem Inhalt anlegen:';
$lng['install']['froxlor_succ_installed'] = 'Froxlor wurde erfolgreich installiert.';

$lng['click_here_to_refresh'] = 'Hier klicken, um erneut zu prüfen';
$lng['click_here_to_goback'] = 'Einen Schritt zurück';
$lng['click_here_to_continue'] = 'Installation fortführen';
$lng['click_here_to_login'] = 'Hier geht es weiter zum Login-Fenster.';
