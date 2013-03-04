<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2003-2007 the SysCP Team (see authors).
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.syscp.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Florian Lippert <flo@syscp.org> (2003-2007)
 * @author     Froxlor Team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Language
 *
 */

/**
 * Begin
 */

$lng['install']['language'] = 'Installations - Sprache';
$lng['install']['welcome'] = 'Willkommen zur Froxlor Installation';
$lng['install']['welcometext'] = 'Vielen Dank dass Sie sich f&uuml;r Froxlor entschieden haben. Um Ihre Installation von Froxlor zu starten, f&uuml;llen Sie bitte alle Felder unten mit den geforderten Angaben.<br /><b>Achtung:</b> Eine eventuell bereits existierende Datenbank, die den selben Namen hat wie den, den Sie unten eingeben werden, wird mit allen enthaltenen Daten gel&ouml;scht!';
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
$lng['install']['installdata'] = 'Installation - Daten';

/**
 * Progress
 */

$lng['install']['testing_mysql'] = 'Teste, ob die MySQL-Root-Benutzerdaten richtig sind...';
$lng['install']['erasing_old_db'] = 'Entferne alte Datenbank...';
$lng['install']['backup_old_db'] = 'Sichere bisherige Datenbank...';
$lng['install']['backing_up'] = 'Sicherung l&auml;ft';
$lng['install']['backing_up_binary_missing'] = '/usr/bin/mysqldump nicht vorhanden';
$lng['install']['create_mysqluser_and_db'] = 'Erstelle Datenbank und Benutzer...';
$lng['install']['testing_new_db'] = 'Teste, ob die Datenbank und Passwort korrekt angelegt wurden...';
$lng['install']['importing_data'] = 'Importiere Daten in die MySQL-Datenbank...';
$lng['install']['changing_data'] = 'Passe die importierten Daten an...';
$lng['install']['adding_admin_user'] = 'F&uuml;ge den Admin-Benutzer hinzu...';
$lng['install']['creating_configfile'] = 'Erstelle Konfigurationsdatei...';
$lng['install']['creating_configfile_succ'] = 'OK, userdata.inc.php wurde in lib/ gespeichert.';
$lng['install']['creating_configfile_temp'] = 'Datei wurde in /tmp/userdata.inc.php gespeichert, bitte nach lib/ verschieben.';
$lng['install']['creating_configfile_failed'] = 'Konnte lib/userdata.inc.php nicht erstellen, bitte manuell mit folgendem Inhalt anlegen:';
$lng['install']['froxlor_succ_installed'] = 'Froxlor wurde erfolgreich installiert.';
$lng['install']['click_here_to_login'] = 'Hier geht es weiter zum Login-Fenster.';
$lng['install']['phpmysql'] = 'Teste, ob die PHP MySQL-Erweiterung installiert ist...';
$lng['install']['phpfilter'] = 'Teste, ob die PHP Filter-Erweiterung installiert ist...';
$lng['install']['diedbecauseofrequirements'] = 'Kann Froxlor ohne diese Voraussetzungen nicht installieren! Breche ab...';
$lng['install']['notinstalled'] = 'nicht installiert!';
$lng['install']['phpbcmath'] = 'Teste, ob die PHP bcmath-Erweiterung installiert ist...';
$lng['install']['bcmathdescription'] = 'Traffic-Berechnungs bezogene Funktionen stehen nicht vollst&auml;ndig zur Verf&uuml;gung!';
$lng['install']['openbasedir'] = 'Teste, ob open_basedir genutzt wird...';
$lng['install']['openbasedirenabled'] = 'aktiviert. Froxlor wird mit aktiviertem open_basedir nicht vollst&auml;ndig funktionieren. Bitte deaktivieren Sie open_basedir f&uuml;r Froxlor';
$lng['install']['httpuser'] = 'HTTP Username';
$lng['install']['httpgroup'] = 'HTTP Gruppenname';

/**
 * ADDED IN 1.2.19-svn7
 */

$lng['install']['servername_should_be_fqdn'] = 'Der Servername sollte eine FQDN sein und keine IP Adresse sein';

/**
 * Renamed in 1.2.19-svn40
 */

$lng['install']['webserver'] = 'Webserver';

/*
 * Added in Froxlor 0.9
 */
$lng['install']['phpversion'] = 'Pr&uuml;fe PHP Version >= 5.2';
$lng['install']['phpposix'] = 'Teste, ob die PHP Posix-Erweiterung installiert ist...';

/*
 * Added in Froxlor 0.9.4
 */
$lng['install']['click_here_to_refresh'] = 'Erneut pr&uuml;fen';
$lng['install']['click_here_to_continue'] = 'Installation fortf&uuml;hren';
$lng['install']['froxlor_succ_checks'] = 'Alle Vorraussetzungen sind erf&uuml;llt';

/*
 * Added in Froxlor 0.9.13
 */
$lng['install']['phpmagic_quotes_runtime'] = 'Pr&uuml;fe ob magic_quotes_runtime ausgeschalten ist';
$lng['install']['active'] = 'nein';
$lng['install']['phpmagic_quotes_runtime_description'] = 'Die PHP Einstellung "magic_quotes_runtime" muss deaktiviert sein ("Off"), um merkw&uuml;rdige Verhalten von Froxlor zu umgehen. Sie wurde deaktiviert (nur tempor&auml;r, bitte php.ini anpassen).';
$lng['install']['phpxml'] = 'Teste, ob die PHP XML-Erweiterung installiert ist...';
?>
