<?php

/**
 * This file is part of the SysCP project.
 * Copyright (c) 2003-2007 the SysCP Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.syscp.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Florian Lippert <flo@syscp.org>
 * @license    GPLv2 http://files.syscp.org/misc/COPYING.txt
 * @package    Language
 * @version    $Id: german.lng.php 2452 2008-11-30 13:12:36Z flo $
 */

/**
 * Begin
 */

$lng['install']['language'] = 'Installations - Sprache';
$lng['install']['welcome'] = 'Willkommen zur SysCP Installation';
$lng['install']['welcometext'] = 'Vielen Dank dass Sie sich f&uuml;r SysCP entschieden haben. Um Ihre Installation von SysCP zu starten, f&uuml;llen Sie bitte alle Felder unten mit den geforderten Angaben.<br /><b>Achtung:</b> Eine eventuell bereits existierende Datenbank, die den selben Namen hat wie den, den Sie unten eingeben werden, wird mit allen enthaltenen Daten gel&ouml;scht!';
$lng['install']['database'] = 'Datenbank';
$lng['install']['mysql_hostname'] = 'MySQL-Hostname';
$lng['install']['mysql_database'] = 'MySQL-Datenbank';
$lng['install']['mysql_unpriv_user'] = 'Benutzername f&uuml;r den unprivilegierten MySQL-Account';
$lng['install']['mysql_unpriv_pass'] = 'Passwort f&uuml;r den unprivilegierten MySQL-Account';
$lng['install']['mysql_root_user'] = 'Benutzername f&uuml;r den MySQL-Root-Account';
$lng['install']['mysql_root_pass'] = 'Passwort f&uuml;r den MySQL-Root-Account';
$lng['install']['admin_account'] = 'Admin-Zugang';
$lng['install']['admin_user'] = 'Administrator-Benutzername';
$lng['install']['admin_pass'] = 'Administrator-Passwort';
$lng['install']['admin_pass_confirm'] = 'Administrator-Passwort (Best&auml;tigung)';
$lng['install']['serversettings'] = 'Servereinstellungen';
$lng['install']['servername'] = 'Servername (FQDN)';
$lng['install']['serverip'] = 'Server-IP';
$lng['install']['apacheversion'] = 'Apacheversion';
$lng['install']['next'] = 'Fortfahren';

/**
 * Progress
 */

$lng['install']['testing_mysql'] = 'Teste, ob die MySQL-Root-Benutzerdaten richtig sind...';
$lng['install']['erasing_old_db'] = 'Entferne alte Datenbank...';
$lng['install']['create_mysqluser_and_db'] = 'Erstelle Datenbank und Benutzer...';
$lng['install']['testing_new_db'] = 'Teste, ob die Datenbank und Passwort korrekt angelegt wurden...';
$lng['install']['importing_data'] = 'Importiere Daten in die MySQL-Datenbank...';
$lng['install']['changing_data'] = 'Passe die importierten Daten an...';
$lng['install']['adding_admin_user'] = 'F&uuml;ge den Admin-Benutzer hinzu...';
$lng['install']['creating_configfile'] = 'Erstelle Konfigurationsdatei...';
$lng['install']['creating_configfile_succ'] = 'OK, userdata.inc.php wurde in lib/ gespeichert.';
$lng['install']['creating_configfile_temp'] = 'Datei wurde in /tmp/userdata.inc.php gespeichert, bitte nach lib/ verschieben.';
$lng['install']['creating_configfile_failed'] = 'Konnte lib/userdata.inc.php nicht erstellen, bitte manuell mit folgendem Inhalt anlegen:';
$lng['install']['syscp_succ_installed'] = 'SysCP wurde erfolgreich installiert.';
$lng['install']['click_here_to_login'] = 'Hier geht es weiter zum Login-Fenster.';
$lng['install']['phpmysql'] = 'Teste, ob die PHP MySQL-Erweiterung installiert ist...';
$lng['install']['phpfilter'] = 'Teste, ob die PHP Filter-Erweiterung installiert ist...';
$lng['install']['diedbecauseofextensions'] = 'Kann SysCP ohne diese Erweiterungen nicht installieren! Breche ab...';
$lng['install']['notinstalled'] = 'nicht installiert!';
$lng['install']['phpbcmath'] = 'Teste, ob die PHP bcmath-Erweiterung installiert ist...';
$lng['install']['bcmathdescription'] = 'Traffic-Berechnungs bezogene Funktionen stehen nicht vollst&auml;ndig zur Verf&uuml;gung!';
$lng['install']['openbasedir'] = 'Teste, ob open_basedir genutzt wird...';
$lng['install']['openbasedirenabled'] = 'aktiviert. SysCP wird mit aktiviertem open_basedir nicht vollst&auml;ndig funktionieren. Bitte deaktivieren Sie open_basedir f&uuml;r SysCP';
$lng['install']['httpuser'] = 'HTTP Username';
$lng['install']['httpgroup'] = 'HTTP Gruppenname';

/**
 * Renamed in 1.2.19-svn40
 */

$lng['install']['webserver'] = 'Webserver';

?>
