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

/**
 * Global
 */
$lng['translator'] = '';
$lng['panel']['edit'] = 'bearbeiten';
$lng['panel']['delete'] = 'löschen';
$lng['panel']['create'] = 'anlegen';
$lng['panel']['save'] = 'Speichern';
$lng['panel']['yes'] = 'Ja';
$lng['panel']['no'] = 'Nein';
$lng['panel']['emptyfornochanges'] = 'leer für keine Änderung';
$lng['panel']['emptyfordefault'] = 'Leer für Standardeinstellung.';
$lng['panel']['path'] = 'Pfad';
$lng['panel']['toggle'] = 'Umschalten';
$lng['panel']['next'] = 'Weiter';
$lng['panel']['dirsmissing'] = 'Das angegebene Verzeichnis konnte nicht gefunden werden.';

/**
 * Login
 */

$lng['login']['username'] = 'Benutzername';
$lng['login']['password'] = 'Passwort';
$lng['login']['language'] = 'Sprache';
$lng['login']['login'] = 'Anmelden';
$lng['login']['logout'] = 'Abmelden';
$lng['login']['profile_lng'] = 'Profilsprache';

/**
 * Customer
 */

$lng['customer']['documentroot'] = 'Heimatverzeichnis';
$lng['customer']['name'] = 'Name';
$lng['customer']['firstname'] = 'Vorname';
$lng['customer']['company'] = 'Firma';
$lng['customer']['street'] = 'Straße';
$lng['customer']['zipcode'] = 'PLZ';
$lng['customer']['city'] = 'Ort';
$lng['customer']['phone'] = 'Telefon';
$lng['customer']['fax'] = 'Fax';
$lng['customer']['email'] = 'E-Mail-Adresse';
$lng['customer']['customernumber'] = 'Kundennummer';
$lng['customer']['diskspace'] = 'Webspace';
$lng['customer']['traffic'] = 'Traffic';
$lng['customer']['mysqls'] = 'MySQL-Datenbanken';
$lng['customer']['emails'] = 'E-Mail-Adressen';
$lng['customer']['accounts'] = 'E-Mail-Konten';
$lng['customer']['forwarders'] = 'E-Mail-Weiterleitungen';
$lng['customer']['ftps'] = 'FTP-Konten';
$lng['customer']['subdomains'] = 'Subdomain(s)';
$lng['customer']['domains'] = 'Domain(s)';

/**
 * Customermenue
 */

$lng['menue']['main']['main'] = 'Allgemein';
$lng['menue']['main']['changepassword'] = 'Passwort ändern';
$lng['menue']['main']['changelanguage'] = 'Sprache ändern';
$lng['menue']['email']['email'] = 'E-Mail';
$lng['menue']['email']['emails'] = 'Adressen';
$lng['menue']['email']['webmail'] = 'Webmail';
$lng['menue']['mysql']['mysql'] = 'MySQL';
$lng['menue']['mysql']['databases'] = 'Datenbanken';
$lng['menue']['mysql']['phpmyadmin'] = 'phpMyAdmin';
$lng['menue']['domains']['domains'] = 'Domains';
$lng['menue']['domains']['settings'] = 'Einstellungen';
$lng['menue']['ftp']['ftp'] = 'FTP';
$lng['menue']['ftp']['accounts'] = 'Benutzerkonten';
$lng['menue']['ftp']['webftp'] = 'WebFTP';
$lng['menue']['extras']['extras'] = 'Extras';
$lng['menue']['extras']['directoryprotection'] = 'Verzeichnisschutz';
$lng['menue']['extras']['pathoptions'] = 'Pfadoptionen';

/**
 * Index
 */

$lng['index']['customerdetails'] = 'Kundendaten';
$lng['index']['accountdetails'] = 'Kontodaten';

/**
 * Change Password
 */

$lng['changepassword']['old_password'] = 'Altes Passwort';
$lng['changepassword']['new_password'] = 'Neues Passwort';
$lng['changepassword']['new_password_confirm'] = 'Neues Passwort bestätigen';
$lng['changepassword']['new_password_ifnotempty'] = 'Neues Passwort (leer für keine Änderung)';
$lng['changepassword']['also_change_ftp'] = 'Auch Passwort des Haupt-FTP-Zugangs ändern';

/**
 * Domains
 */

$lng['domains']['description'] = 'Hier können Sie (Sub-)Domains erstellen und deren Pfade ändern.<br />Nach jeder Änderung braucht das System etwas Zeit, um die Konfiguration neu einzulesen.';
$lng['domains']['domainsettings'] = 'Domaineinstellungen';
$lng['domains']['domainname'] = 'Domainname';
$lng['domains']['subdomain_add'] = 'Subdomain anlegen';
$lng['domains']['subdomain_edit'] = '(Sub-)Domain bearbeiten';
$lng['domains']['wildcarddomain'] = 'Als Wildcarddomain eintragen?';
$lng['domains']['aliasdomain'] = 'Alias für Domain';
$lng['domains']['noaliasdomain'] = 'Keine Aliasdomain';

/**
 * eMails
 */

$lng['emails']['description'] = 'Hier können Sie Ihre E-Mail-Adressen einrichten.<br />Ein Konto ist wie Ihr Briefkasten vor der Haustür. Wenn jemand eine E-Mail an Sie schreibt, wird diese in dieses Konto gelegt.<br /><br />Die Zugangsdaten lauten wie folgt: (Die Angaben in <i>kursiver</i> Schrift sind durch die jeweiligen Einträge zu ersetzen)<br /><br />Hostname: <b><i>Domainname</i></b><br />Benutzername: <b><i>Kontoname / E-Mail-Adresse</i></b><br />Passwort: <b><i>das gewählte Passwort</i></b>';
$lng['emails']['emailaddress'] = 'E-Mail-Adresse';
$lng['emails']['emails_add'] = 'E-Mail-Adresse anlegen';
$lng['emails']['emails_edit'] = 'E-Mail-Adresse ändern';
$lng['emails']['catchall'] = 'Catchall';
$lng['emails']['iscatchall'] = 'Als Catchall-Adresse definieren?';
$lng['emails']['account'] = 'Konto';
$lng['emails']['account_add'] = 'Konto anlegen';
$lng['emails']['account_delete'] = 'Konto löschen';
$lng['emails']['from'] = 'Von';
$lng['emails']['to'] = 'Nach';
$lng['emails']['forwarders'] = 'Weiterleitungen';
$lng['emails']['forwarder_add'] = 'Weiterleitung hinzufügen';

/**
 * FTP
 */

$lng['ftp']['description'] = 'Hier können Sie zusätzliche FTP-Konten einrichten.<br />Die Änderungen sind sofort wirksam und die FTP-Konten sofort benutzbar.';
$lng['ftp']['account_add'] = 'Benutzerkonto anlegen';

/**
 * MySQL
 */

$lng['mysql']['databasename'] = 'Benutzer-/Datenbankname';
$lng['mysql']['databasedescription'] = 'Datenbankbeschreibung';
$lng['mysql']['database_create'] = 'Datenbank anlegen';

/**
 * Extras
 */

$lng['extras']['description'] = 'Hier können Sie zusätzliche Extras einrichten, wie zum Beispiel einen Verzeichnisschutz.<br />Die Änderungen sind erst nach einer kurzen Zeit wirksam.';
$lng['extras']['directoryprotection_add'] = 'Verzeichnisschutz anlegen';
$lng['extras']['view_directory'] = 'Verzeichnis anzeigen';
$lng['extras']['pathoptions_add'] = 'Pfadoptionen hinzufügen';
$lng['extras']['directory_browsing'] = 'Verzeichnisinhalt anzeigen';
$lng['extras']['pathoptions_edit'] = 'Pfadoptionen bearbeiten';
$lng['extras']['error404path'] = '404';
$lng['extras']['error403path'] = '403';
$lng['extras']['error500path'] = '500';
$lng['extras']['error401path'] = '401';
$lng['extras']['errordocument404path'] = 'Fehlerdokument 404';
$lng['extras']['errordocument403path'] = 'Fehlerdokument 403';
$lng['extras']['errordocument500path'] = 'Fehlerdokument 500';
$lng['extras']['errordocument401path'] = 'Fehlerdokument 401';

/**
 * Errors
 */

$lng['error']['error'] = 'Fehlermeldung';
$lng['error']['directorymustexist'] = 'Das Verzeichnis "%s" muss existieren. Legen Sie es bitte mit Ihrem FTP-Programm an.';
$lng['error']['filemustexist'] = 'Die Datei "%s" muss existieren.';
$lng['error']['allresourcesused'] = 'Sie haben bereits alle Ihnen zur Verfügung stehenden Ressourcen verbraucht.';
$lng['error']['domains_cantdeletemaindomain'] = 'Sie können keine Domain, die als E-Mail-Domain verwendet wird, löschen. ';
$lng['error']['domains_canteditdomain'] = 'Sie können diese Domain nicht bearbeiten. Dies wurde durch den Admin verweigert.';
$lng['error']['domains_cantdeletedomainwithemail'] = 'Sie können keine Domain löschen, die noch als E-Mail-Domain verwendet wird. Löschen Sie zuerst alle E-Mail-Adressen dieser Domain.';
$lng['error']['firstdeleteallsubdomains'] = 'Sie müssen zuerst alle Subdomains löschen, bevor Sie eine Wildcarddomain anlegen können.';
$lng['error']['youhavealreadyacatchallforthisdomain'] = 'Sie haben bereits eine E-Mail-Adresse als Catchall für diese Domain definiert.';
$lng['error']['ftp_cantdeletemainaccount'] = 'Sie können Ihren Hauptaccount nicht löschen.';
$lng['error']['login'] = 'Die Kombination aus Benutzername und Passwort ist ungültig.';
$lng['error']['login_blocked'] = 'Dieser Account wurde aufgrund zu vieler Fehlversuche vorübergehend geschlossen.<br />Bitte versuchen Sie es in "%s" Sekunden erneut.';
$lng['error']['notallreqfieldsorerrors'] = 'Sie haben nicht alle Felder bzw. ein Feld mit fehlerhaften Angaben ausgefüllt.';
$lng['error']['oldpasswordnotcorrect'] = 'Das alte Passwort ist nicht korrekt.';
$lng['error']['youcantallocatemorethanyouhave'] = 'Sie können nicht mehr Ressourcen verteilen als Ihnen noch zur Verfügung stehen.';
$lng['error']['mustbeurl'] = 'Sie müssen eine vollständige URL angeben (z. B. http://domain.de/error404.htm).';
$lng['error']['invalidpath'] = 'Sie haben keine gültige URL angegeben (evtl. Probleme beim Verzeichnislisting?).';
$lng['error']['stringisempty'] = 'Fehlende Eingabe im Feld';
$lng['error']['stringiswrong'] = 'Falsche Eingabe im Feld';
$lng['error']['newpasswordconfirmerror'] = 'Das neue Passwort und dessen Bestätigung sind nicht identisch.';
$lng['error']['mydomain'] = '\'Domain\'';
$lng['error']['mydocumentroot'] = '\'Documentroot\'';
$lng['error']['loginnameexists'] = 'Der Login-Name "%s" existiert bereits.';
$lng['error']['emailiswrong'] = 'Die E-Mail-Adresse "%s" enthält ungültige Zeichen oder ist nicht vollständig.';
$lng['error']['alternativeemailiswrong'] = 'Die angegebene alternative E-Mail Adresse "%s", an welche die Zugangsdaten geschickt werden soll, scheint ungültig zu sein.';
$lng['error']['loginnameiswrong'] = 'Der Login-Name "%s" enthält ungültige Zeichen.';
$lng['error']['loginnameiswrong2'] = 'Der Login-Name enthält zu viele Zeichen, es sind maximal %s Zeichen erlaubt.';
$lng['error']['userpathcombinationdupe'] = 'Die Kombination aus Benutzername und Pfad existiert bereits.';
$lng['error']['patherror'] = 'Allgemeiner Fehler! Pfad darf nicht leer sein.';
$lng['error']['errordocpathdupe'] = 'Option für Pfad "%s" existiert bereits.';
$lng['error']['adduserfirst'] = 'Sie müssen zuerst einen Kunden anlegen.';
$lng['error']['domainalreadyexists'] = 'Die Domain "%s" wurde bereits einem Kunden zugeordnet.';
$lng['error']['nolanguageselect'] = 'Es wurde keine Sprache ausgewählt.';
$lng['error']['nosubjectcreate'] = 'Sie müssen einen Betreff angeben.';
$lng['error']['nomailbodycreate'] = 'Sie müssen einen E-Mail-Text eingeben.';
$lng['error']['templatenotfound'] = 'Vorlage wurde nicht gefunden.';
$lng['error']['alltemplatesdefined'] = 'Sie können keine weiteren Vorlagen anlegen, da bereits für alle Sprachen eine Vorlage existiert.';
$lng['error']['wwwnotallowed'] = 'Ihre Subdomain darf nicht \'www\' heißen.';
$lng['error']['subdomainiswrong'] = 'Die Subdomain "%s" enthält ungültige Zeichen.';
$lng['error']['domaincantbeempty'] = 'Der Domainname darf nicht leer sein.';
$lng['error']['domainexistalready'] = 'Die Domain "%s" existiert bereits.';
$lng['error']['domainisaliasorothercustomer'] = 'Die ausgewählte Aliasdomain ist entweder selbst eine Aliasdomain, hat nicht die gleiche IP/Port-Kombination oder gehört einem anderen Kunden.';
$lng['error']['emailexistalready'] = 'Die E-Mail-Adresse "%s" existiert bereits.';
$lng['error']['maindomainnonexist'] = 'Die Hauptdomain "%s" existiert nicht.';
$lng['error']['destinationnonexist'] = 'Bitte geben Sie Ihre Weiterleitungsadresse im Feld \'Nach\' ein.';
$lng['error']['destinationalreadyexistasmail'] = 'Die Weiterleitung zu "%s" existiert bereits als aktive E-Mail-Adresse.';
$lng['error']['destinationalreadyexist'] = 'Es existiert bereits eine Weiterleitung nach "%s".';
$lng['error']['destinationiswrong'] = 'Die Weiterleitungsadresse "%s" enthält ungültige Zeichen oder ist nicht vollständig.';
$lng['error']['backupfoldercannotbedocroot'] = 'Der Ordner für Backups darf nicht das Heimatverzeichnis sein, wählen Sie einen Ordner unterhalb des Heimatverzeichnisses, z.B. /backups';

/**
 * Questions
 */

$lng['question']['question'] = 'Sicherheitsabfrage';
$lng['question']['admin_customer_reallydelete'] = 'Wollen Sie den Kunden "%s" wirklich löschen?<br />ACHTUNG! Alle Daten gehen unwiderruflich verloren! Nach dem Vorgang müssen die Daten manuell aus dem Dateisystem entfernt werden.';
$lng['question']['admin_domain_reallydelete'] = 'Wollen Sie die Domain "%s" wirklich löschen?';
$lng['question']['admin_domain_reallydisablesecuritysetting'] = 'Wollen Sie die wichtige Sicherheitseinstellung \'OpenBasedir\' wirklich deaktivieren?';
$lng['question']['admin_admin_reallydelete'] = 'Wollen Sie den Admin "%s" wirklich löschen?<br />Alle Kunden und Domains dieses Admins werden Ihnen zugeteilt.';
$lng['question']['admin_template_reallydelete'] = 'Wollen Sie die Vorlage "%s" wirklich löschen?';
$lng['question']['domains_reallydelete'] = 'Wollen Sie die Domain "%s" wirklich löschen?';
$lng['question']['email_reallydelete'] = 'Wollen Sie die E-Mail-Adresse "%s" wirklich löschen?';
$lng['question']['email_reallydelete_account'] = 'Wollen Sie das Konto von "%s" wirklich löschen?';
$lng['question']['email_reallydelete_forwarder'] = 'Wollen Sie die Weiterleitung "%s" wirklich löschen?';
$lng['question']['extras_reallydelete'] = 'Wollen Sie den Verzeichnisschutz für "%s" wirklich löschen?';
$lng['question']['extras_reallydelete_pathoptions'] = 'Wollen Sie die Optionen für den Pfad "%s" wirklich löschen?';
$lng['question']['ftp_reallydelete'] = 'Wollen Sie das FTP-Benutzerkonto "%s" wirklich löschen?';
$lng['question']['mysql_reallydelete'] = 'Wollen Sie die Datenbank "%s" wirklich löschen?<br />ACHTUNG! Alle Daten gehen unwiderruflich verloren!';
$lng['question']['admin_configs_reallyrebuild'] = 'Wollen Sie wirklich alle Konfigurationsdateien neu erstellen lassen?';
$lng['question']['admin_customer_alsoremovefiles'] = 'Kundendaten löschen?';
$lng['question']['admin_customer_alsoremovemail'] = 'E-Mail-Daten auf dem Dateisystem löschen?';
$lng['question']['admin_customer_alsoremoveftphomedir'] = 'Heimatverzeichnis des FTP-Benutzers löschen?';

/**
 * Mails
 */

$lng['mails']['pop_success']['mailbody'] = 'Hallo,\n\nIhr E-Mail-Konto {USERNAME}\nwurde erfolgreich eingerichtet.\n\nDies ist eine automatisch generierte\nE-Mail, bitte antworten Sie nicht auf\ndiese Mitteilung.\n\nIhr Administrator';
$lng['mails']['pop_success']['subject'] = 'E-Mail-Konto erfolgreich eingerichtet';
$lng['mails']['createcustomer']['mailbody'] = 'Hallo {FIRSTNAME} {NAME},\n\nhier Ihre Accountinformationen:\n\nBenutzername: {USERNAME}\nPasswort: {PASSWORD}\n\nVielen Dank,\nIhr Administrator';
$lng['mails']['createcustomer']['subject'] = 'Kontoinformationen';

/**
 * Admin
 */

$lng['admin']['overview'] = 'Übersicht';
$lng['admin']['ressourcedetails'] = 'Verbrauchte Ressourcen';
$lng['admin']['systemdetails'] = 'Systemdetails';
$lng['admin']['froxlordetails'] = 'Froxlor-Details';
$lng['admin']['installedversion'] = 'Installierte Version';
$lng['admin']['latestversion'] = 'Neueste Version';
$lng['admin']['lookfornewversion']['clickhere'] = 'per Webservice abfragen - Hier klicken';
$lng['admin']['lookfornewversion']['error'] = 'Fehler bei Abfrage';
$lng['admin']['resources'] = 'Ressourcen';
$lng['admin']['customer'] = 'Kunde';
$lng['admin']['customers'] = 'Kunden';
$lng['admin']['customer_add'] = 'Kunden anlegen';
$lng['admin']['customer_edit'] = 'Kunden bearbeiten';
$lng['admin']['domains'] = 'Domains';
$lng['admin']['domain_add'] = 'Domain anlegen';
$lng['admin']['domain_edit'] = 'Domain bearbeiten';
$lng['admin']['subdomainforemail'] = 'Subdomains als E-Mail-Domains erlauben';
$lng['admin']['admin'] = 'Admin';
$lng['admin']['admins'] = 'Admins';
$lng['admin']['admin_add'] = 'Admin anlegen';
$lng['admin']['admin_edit'] = 'Admin bearbeiten';
$lng['admin']['customers_see_all'] = 'Kann alle Kunden sehen?';
$lng['admin']['domains_see_all'] = 'Kann alle Domains sehen?';
$lng['admin']['change_serversettings'] = 'Kann Servereinstellungen bearbeiten?';
$lng['admin']['serversettings'] = 'Einstellungen';
$lng['admin']['rebuildconf'] = 'Configs neu schreiben';
$lng['admin']['stdsubdomain'] = 'Standardsubdomain';
$lng['admin']['stdsubdomain_add'] = 'Standardsubdomain anlegen';
$lng['admin']['phpenabled'] = 'PHP verfügbar';
$lng['admin']['deactivated'] = 'Gesperrt';
$lng['admin']['deactivated_user'] = 'Benutzer sperren';
$lng['admin']['sendpassword'] = 'Passwort zusenden';
$lng['admin']['ownvhostsettings'] = 'Eigene vHost-Einstellungen';
$lng['admin']['configfiles']['serverconfiguration'] = 'Konfiguration';
$lng['admin']['templates']['templates'] = 'E-Mail-Vorlagen';
$lng['admin']['templates']['template_add'] = 'Vorlage hinzufügen';
$lng['admin']['templates']['template_edit'] = 'Vorlage bearbeiten';
$lng['admin']['templates']['action'] = 'Aktion';
$lng['admin']['templates']['email'] = 'E-Mail- & Dateivorlagen';
$lng['admin']['templates']['subject'] = 'Betreff';
$lng['admin']['templates']['mailbody'] = 'Mailtext';
$lng['admin']['templates']['createcustomer'] = 'Willkommensmail für neue Kunden';
$lng['admin']['templates']['pop_success'] = 'Willkommensmail für neue E-Mail-Konten';
$lng['admin']['templates']['template_replace_vars'] = 'Variablen, die in den Vorlagen ersetzt werden:';
$lng['admin']['templates']['SALUTATION'] = 'Wird mit einer korrekten Anrede des Kunden ersetzt.';
$lng['admin']['templates']['FIRSTNAME'] = 'Wird mit dem Vornamen des Kunden ersetzt.';
$lng['admin']['templates']['NAME'] = 'Wird mit dem Namen des Kunden ersetzt.';
$lng['admin']['templates']['COMPANY'] = 'Wird mit dem Firmennamen des Kunden ersetzt.';
$lng['admin']['templates']['USERNAME'] = 'Wird mit dem Benutzernamen des neuen Kundenkontos ersetzt.';
$lng['admin']['templates']['PASSWORD'] = 'Wird mit dem Passwort des neuen Kundenkontos ersetzt.';
$lng['admin']['templates']['EMAIL'] = 'Wird mit der Adresse des neuen E-Mail-Kontos ersetzt.';
$lng['admin']['templates']['CUSTOMER_NO'] = 'Wir mit der Kunden-Nummer ersetzt';
$lng['admin']['bindzonewarning'] = $lng['panel']['emptyfordefault'] . '<br /><strong class="red">WARNUNG:</strong> Bei der Verwendung einer Zonendatei müssen alle benötigten Records aller Subdomains ebenfalls manuell verwaltet werden.';

/**
 * Serversettings
 */

$lng['serversettings']['session_timeout']['title'] = 'Session-Timeout';
$lng['serversettings']['session_timeout']['description'] = 'Wie lange muss ein Benutzer inaktiv sein, damit die Session ungültig wird? (in Sekunden)';
$lng['serversettings']['accountprefix']['title'] = 'Kundenpräfix';
$lng['serversettings']['accountprefix']['description'] = 'Welchen Präfix sollen die Kundenaccounts haben?';
$lng['serversettings']['mysqlprefix']['title'] = 'MySQL-Präfix';
$lng['serversettings']['mysqlprefix']['description'] = 'Welchen Präfix sollen die MySQL-Benutzerkonten haben?</br>Mit "RANDOM" als Wert wird ein 3-stelliger Zufallswert als Präfix verwendet.';
$lng['serversettings']['ftpprefix']['title'] = 'FTP-Präfix';
$lng['serversettings']['ftpprefix']['description'] = 'Welchen Präfix sollen die FTP-Benutzerkonten haben?<br/><b>Falls FTP-Quoatas verwendet werden, ist es notwendig das Quota-SQL-Query in der FTP-Server-Config ebenfalls zu ändern!</b>';
$lng['serversettings']['documentroot_prefix']['title'] = 'Heimatverzeichnis';
$lng['serversettings']['documentroot_prefix']['description'] = 'Wo sollen die Heimatverzeichnisse der Kunden liegen?';
$lng['serversettings']['logfiles_directory']['title'] = 'Webserver-Logdateien-Verzeichnis';
$lng['serversettings']['logfiles_directory']['description'] = 'Wo sollen die Logdateien des Webservers liegen?';
$lng['serversettings']['logfiles_script']['title'] = 'Eigenes Script zu dem Log-Files übergeben werden';
$lng['serversettings']['logfiles_script']['description'] = 'Hier kann ein Script an das die Loginhalte übergeben werden hinterlegt und die Platzhalter <strong>{LOGFILE}, {DOMAIN} und {CUSTOMER}</strong> genutzt werden, sofern nötig. Falls ein Script angegeben wird, muss die Option <strong>Webserver Logdateien umleiten</strong> gesetzt werden';
$lng['serversettings']['logfiles_format']['title'] = 'Access-Log Format';
$lng['serversettings']['logfiles_format']['description'] = 'Hier kann ein angepasstes Log-format entsprechend der Webserver-Dokumentation angegeben werden, leer lassen für Standard. Abhängig vom LogFormat muss die Angabe unter Anführungszeichen stehen.<br/>Wenn verwendet mit nginx, so kann es wie folgt aussehen: <i>log_format frx_custom {EINGESTELLTES_FORMAT}</i>.<br/>Wenn verwendet mit Apache, so kann es wie folgt aussehen: <i>LogFormat {EINGESTELLTES_FORMAT} frx_custom</i>.<br /><strong>ACHTUNG:</strong> Der Code wird nicht auf Fehler geprüft. Etwaige Fehler werden auch übernommen und der Webserver könnte nicht mehr starten!';
$lng['serversettings']['logfiles_type']['title'] = 'Access-Log Typ';
$lng['serversettings']['logfiles_type']['description'] = 'Wähle zwischen <strong>combined</strong> oder <strong>vhost_combined</strong>.';
$lng['serversettings']['logfiles_piped']['title'] = 'Webserver Logdateien zu eigenem Script umleiten (siehe oben)';
$lng['serversettings']['logfiles_piped']['description'] = 'Wenn ein Script für die Logdateien verwendet wird, muss diese Option aktiviert werden, damit der Webserver die Ausgabe an das Script weitergibt.';
$lng['serversettings']['ipaddress']['title'] = 'IP-Adresse';
$lng['serversettings']['ipaddress']['description'] = 'Welche Haupt-IP-Adresse hat der Server?';
$lng['serversettings']['hostname']['title'] = 'Hostname';
$lng['serversettings']['hostname']['description'] = 'Welchen Hostnamen hat der Server?';
$lng['serversettings']['apachereload_command']['title'] = 'Webserver-Reload-Befehl';
$lng['serversettings']['apachereload_command']['description'] = 'Wie heißt das Skript zum Neuladen der Webserver-Konfigurationsdateien?';
$lng['serversettings']['bindenable']['title'] = 'Nameserver aktivieren';
$lng['serversettings']['bindenable']['description'] = 'Hier können Sie den Nameserver global aktivieren bzw. deaktivieren.';
$lng['serversettings']['bindconf_directory']['title'] = 'DNS-Server Konfigurationsordner';
$lng['serversettings']['bindconf_directory']['description'] = 'Wo liegen die DNS-Server Konfigurationsdateien?';
$lng['serversettings']['bindreload_command']['title'] = 'DNS-Server Reload-Befehl';
$lng['serversettings']['bindreload_command']['description'] = 'Wie heißt das Skript zum Neuladen der DNS-Server Konfigurationsdateien?';
$lng['serversettings']['vmail_uid']['title'] = 'Mail-UID';
$lng['serversettings']['vmail_uid']['description'] = 'Welche UID sollen die E-Mails haben?';
$lng['serversettings']['vmail_gid']['title'] = 'Mail-GID';
$lng['serversettings']['vmail_gid']['description'] = 'Welche GID sollen die E-Mails haben?';
$lng['serversettings']['vmail_homedir']['title'] = 'Mail-Homedir';
$lng['serversettings']['vmail_homedir']['description'] = 'Wo sollen die E-Mails liegen?';
$lng['serversettings']['adminmail']['title'] = 'Absenderadresse';
$lng['serversettings']['adminmail']['description'] = 'Wie lautet die Absenderadresse für E-Mails aus dem Panel?';
$lng['serversettings']['phpmyadmin_url']['title'] = 'phpMyAdmin-URL';
$lng['serversettings']['phpmyadmin_url']['description'] = 'Wo liegt phpMyAdmin? (muss mit http(s):// beginnen)';
$lng['serversettings']['webmail_url']['title'] = 'Webmail-URL';
$lng['serversettings']['webmail_url']['description'] = 'Wo liegt der Webmail-Client? (muss mit http(s):// beginnen)';
$lng['serversettings']['webftp_url']['title'] = 'WebFTP-URL';
$lng['serversettings']['webftp_url']['description'] = 'Wo liegt der WebFTP-Client? (muss mit http(s):// beginnen)';
$lng['serversettings']['language']['description'] = 'Welche Sprache ist Ihre Standardsprache?';
$lng['serversettings']['maxloginattempts']['title'] = 'Maximale Loginversuche';
$lng['serversettings']['maxloginattempts']['description'] = 'Maximale Anzahl an Loginversuchen bis der Account deaktiviert wird.';
$lng['serversettings']['deactivatetime']['title'] = 'Länge der Deaktivierung';
$lng['serversettings']['deactivatetime']['description'] = 'Zeitraum (in Sekunden) für den der Account deaktiviert ist.';
$lng['serversettings']['pathedit']['title'] = 'Pfad-Eingabemethode';
$lng['serversettings']['pathedit']['description'] = 'Soll ein Pfad via Auswahlliste ausgewählt oder manuell eingegeben werden können?';
$lng['serversettings']['nameservers']['title'] = 'Nameserver';
$lng['serversettings']['nameservers']['description'] = 'Eine durch Komma getrennte Liste mit den Hostnamen aller Nameserver. Der Erste ist der Primäre.';
$lng['serversettings']['mxservers']['title'] = 'MX-Server';
$lng['serversettings']['mxservers']['description'] = 'Eine durch Komma getrenne Liste, die ein Paar mit einer Nummer und den Hostnamen einen MX-Servers, getrennt durch ein Leerzeichen, enthält (z. B. \'10 mx.example.tld\').';

/**
 * CHANGED BETWEEN 1.2.12 and 1.2.13
 */

$lng['mysql']['description'] = 'Hier können Sie MySQL-Datenbanken anlegen und löschen.<br />Die Änderungen werden sofort wirksam und die Datenbanken sind sofort benutzbar.<br />Im Menü finden Sie einen Link zu phpMyAdmin, mit dem Sie Ihre Datenbankinhalte komfortabel bearbeiten können.<br /><br />Die Zugangsdaten sind wie folgt: (Die Angaben in <i>kursiver</i> Schrift sind durch die jeweiligen Einträge zu ersetzen)<br />Hostname: <b><SQL_HOST></b><br />Benutzername: <b><i>Datenbankname</i></b><br />Passwort: <b><i>das gewählte Passwort</i></b><br />Datenbank: <b><i>Datenbankname</i></b>';

/**
 * ADDED BETWEEN 1.2.12 and 1.2.13
 */

$lng['serversettings']['paging']['title'] = 'Einträge pro Seite';
$lng['serversettings']['paging']['description'] = 'Wie viele Einträge sollen auf einer Seite angezeigt werden? (0 = Paging deaktivieren)';
$lng['error']['ipstillhasdomains'] = 'Die IP/Port-Kombination, die Sie löschen wollen, ist noch bei einer oder mehreren Domains eingetragen. Bitte ändern Sie die Domains vorher auf eine andere IP/Port-Kombination, um diese löschen zu können.';
$lng['error']['cantdeletedefaultip'] = 'Sie können die Standard-IP/Port-Kombination für Reseller nicht löschen. Bitte setzen Sie eine andere IP/Port-Kombination als Standard, um diese löschen zu können.';
$lng['error']['cantdeletesystemip'] = 'Sie können die letzte System-IP-Adresse nicht löschen. Entweder legen Sie eine neue IP/Port-Kombination an oder Sie ändern die System-IP-Adresse.';
$lng['error']['myipaddress'] = '\'IP-Adresse\'';
$lng['error']['myport'] = '\'Port\'';
$lng['error']['myipdefault'] = 'Sie müssen eine IP/Port-Kombination auswählen, die den Standard definieren soll.';
$lng['error']['myipnotdouble'] = 'Diese Kombination aus IP-Adresse und Port existiert bereits.';
$lng['question']['admin_ip_reallydelete'] = 'Wollen Sie wirklich die IP-Adresse "%s" löschen?';
$lng['admin']['ipsandports']['ipsandports'] = 'IPs und Ports';
$lng['admin']['ipsandports']['add'] = 'IP-Adresse/Port hinzufügen';
$lng['admin']['ipsandports']['edit'] = 'IP-Adresse/Port bearbeiten';
$lng['admin']['ipsandports']['ipandport'] = 'IP-Adresse/Port';
$lng['admin']['ipsandports']['ip'] = 'IP-Adresse';
$lng['admin']['ipsandports']['ipnote'] = '<div id="ipnote" class="red">Hinweis: Obwohl private IP Adressen erlaubt sind, kann es bei manchen Features wie DNS zu ungewolltem Verhalten kommen.<br>Verwende private Adressen nur wenn du sicher bist.</div>';
$lng['admin']['ipsandports']['port'] = 'Port';

// ADDED IN 1.2.13-rc3

$lng['error']['cantchangesystemip'] = 'Sie können die letzte System-IP-Adresse nicht löschen. Entweder legen Sie eine neue IP/Port-Kombination an oder Sie ändern die System-IP-Adresse.';
$lng['question']['admin_domain_reallydocrootoutofcustomerroot'] = 'Sind Sie sicher, dass der DocumentRoot dieser Domain außerhalb des Heimatverzeichnisses des Kunden liegen soll?';

// ADDED IN 1.2.14-rc1

$lng['admin']['memorylimitdisabled'] = 'Deaktiviert';
$lng['domain']['openbasedirpath'] = 'OpenBasedir-Pfad';
$lng['domain']['docroot'] = 'Oben angegebener Pfad';
$lng['domain']['homedir'] = 'Heimverzeichnis';
$lng['admin']['valuemandatory'] = 'Dieses Feld muss ausgefüllt werden.';
$lng['admin']['valuemandatorycompany'] = 'Entweder "Name" und "Vorname" oder "Firma" muss ausgefüllt werden.';
$lng['menue']['main']['username'] = 'Angemeldet als ';
$lng['panel']['urloverridespath'] = 'URL (überschreibt Pfad)';
$lng['panel']['pathorurl'] = 'Pfad oder URL';
$lng['error']['sessiontimeoutiswrong'] = '"Session-Timeout" muss ein numerischer Wert sein.';
$lng['error']['maxloginattemptsiswrong'] = '"Maximale Loginversuche" muss ein numerischer Wert sein.';
$lng['error']['deactivatetimiswrong'] = '"Länge der Deaktivierung" muss numerisch sein.';
$lng['error']['accountprefixiswrong'] = 'Das "Kundenpräfix" ist falsch.';
$lng['error']['mysqlprefixiswrong'] = 'Das "MySQL-Präfix" ist falsch.';
$lng['error']['ftpprefixiswrong'] = 'Das "FTP-Präfix" ist falsch.';
$lng['error']['ipiswrong'] = 'Die "IP-Adresse" ist falsch. Bitte geben Sie eine gültige IP-Adresse an.';
$lng['error']['vmailuidiswrong'] = 'Die "Mail-UID" ist falsch. Es ist nur eine numerische UID erlaubt.';
$lng['error']['vmailgidiswrong'] = 'Die "Mail-GID" ist falsch. Es ist nur eine numerische GID erlaubt.';
$lng['error']['adminmailiswrong'] = 'Die "Absenderadresse" ist fehlerhaft. Bitte geben Sie eine gültige E-Mail-Adresse an.';
$lng['error']['pagingiswrong'] = 'Die "Einträge pro Seite"-Einstellung ist falsch. Es sind nur numerische Zeichen erlaubt.';
$lng['error']['phpmyadminiswrong'] = 'Die "phpMyAdmin-URL" ist keine gültige URL.';
$lng['error']['webmailiswrong'] = 'Die "Webmail-URL" ist keine gültige URL.';
$lng['error']['webftpiswrong'] = 'Die "WebFTP-URL" ist keine gültige URL.';
$lng['domains']['hasaliasdomains'] = 'Hat Aliasdomain(s)';
$lng['serversettings']['defaultip']['title'] = 'Standard-IP/Port-Kombination';
$lng['serversettings']['defaultip']['description'] = 'Welche IP/Port-Kombination sollen standardmäßig verwendet werden?';
$lng['serversettings']['defaultsslip']['title'] = 'Standard SSL IP/Port-Kombination';
$lng['serversettings']['defaultsslip']['description'] = 'Welche ssl-fähigen IP/Port-Kombination sollen standardmäßig verwendet werden?';
$lng['domains']['statstics'] = 'Statistiken';
$lng['panel']['ascending'] = 'aufsteigend';
$lng['panel']['descending'] = 'absteigend';
$lng['panel']['search'] = 'Suche';
$lng['panel']['used'] = 'genutzt';

// ADDED IN 1.2.14-rc3

$lng['panel']['translator'] = 'Übersetzung';

// ADDED IN 1.2.14-rc4

$lng['error']['stringformaterror'] = 'Der Wert des Feldes "%s" hat nicht das erwartete Format.';

// ADDED IN 1.2.15-rc1

$lng['admin']['serversoftware'] = 'Webserver';
$lng['admin']['phpversion'] = 'PHP-Version';
$lng['admin']['mysqlserverversion'] = 'MySQL-Server-Version';
$lng['admin']['webserverinterface'] = 'Webserver-Interface';
$lng['domains']['isassigneddomain'] = 'zugewiesene Domain';
$lng['serversettings']['phpappendopenbasedir']['title'] = 'Anzuhängende Pfade bei OpenBasedir';
$lng['serversettings']['phpappendopenbasedir']['description'] = 'Diese (durch Doppelpunkte getrennten) Pfade werden dem OpenBasedir-Statement in jedem vHost-Container angehängt.';

// CHANGED IN 1.2.15-rc1

$lng['error']['loginnameissystemaccount'] = 'Sie können keinen Account anlegen, der wie ein Systemaccount aussieht (also zum Beispiel mit "%s" anfängt). Bitte wählen Sie einen anderen Accountnamen.';
$lng['error']['youcantdeleteyourself'] = 'Aus Sicherheitsgründen können Sie sich nicht selbst löschen.';
$lng['error']['youcanteditallfieldsofyourself'] = 'Hinweis: Aus Sicherheitsgründen können Sie nicht alle Felder Ihres eigenen Accounts bearbeiten.';

// ADDED IN 1.2.16-svn1

$lng['serversettings']['natsorting']['title'] = 'Natürliche Sortierung in der Listenansicht nutzen';
$lng['serversettings']['natsorting']['description'] = 'Sortiert die Liste in der Reihenfolge web1 -> web2 -> web11 statt web1 -> web11 -> web2.';

// ADDED IN 1.2.16-svn2

$lng['serversettings']['deactivateddocroot']['title'] = 'Docroot für deaktivierte Benutzer';
$lng['serversettings']['deactivateddocroot']['description'] = 'Dieser Pfad wird als Docroot für deaktivierte Benutzer verwendet. Ist das Feld leer, wird kein vHost erstellt.';

// ADDED IN 1.2.16-svn4

$lng['panel']['reset'] = 'Änderungen verwerfen';
$lng['admin']['accountsettings'] = 'Konteneinstellungen';
$lng['admin']['panelsettings'] = 'Panel-Einstellungen';
$lng['admin']['systemsettings'] = 'Systemeinstellungen';
$lng['admin']['webserversettings'] = 'Webserver-Einstellungen';
$lng['admin']['mailserversettings'] = 'Mailserver-Einstellungen';
$lng['admin']['nameserversettings'] = 'Nameserver-Einstellungen';
$lng['admin']['updatecounters'] = 'Ressourcenverbrauch';
$lng['question']['admin_counters_reallyupdate'] = 'Wollen Sie den Ressourcenverbrauch neu berechnen?';
$lng['panel']['pathDescription'] = 'Sollte das Verzeichnis nicht existieren, wird es automatisch erstellt.';
$lng['panel']['pathDescriptionEx'] = '<br />Sollte eine Weiterleitung auf eine andere Domain gewünscht sein, muss der Eintrag mit http:// oder https:// beginnen.';
$lng['panel']['pathDescriptionSubdomain'] = $lng['panel']['pathDescription'] . $lng['panel']['pathDescriptionEx'] . "<br />Endet die URL mit einem / (Slash) geht Froxlor von einem Ordner aus, wenn nicht, wird es wie eine Datei behandelt.";

// ADDED IN 1.2.16-svn6

$lng['admin']['templates']['TRAFFIC'] = 'Wird mit Traffic, der dem Kunden zugewiesen wurde, ersetzt (in MB).';
$lng['admin']['templates']['TRAFFICUSED'] = 'Wird mit Traffic, der vom Kunden bereits verbraucht wurde, ersetzt (in MB).';

// ADDED IN 1.2.16-svn7

$lng['admin']['subcanemaildomain']['never'] = 'Nie';
$lng['admin']['subcanemaildomain']['choosableno'] = 'Wählbar, Standardwert: Nein';
$lng['admin']['subcanemaildomain']['choosableyes'] = 'Wählbar, Standardwert: Ja';
$lng['admin']['subcanemaildomain']['always'] = 'Immer';
$lng['changepassword']['also_change_stats'] = ' Auch Passwort der Statistikseite ändern';

// ADDED IN 1.2.16-svn8

$lng['serversettings']['mailpwcleartext']['title'] = 'Passwörter der Mail-Konten auch im Klartext in der Datenbank speichern';
$lng['serversettings']['mailpwcleartext']['description'] = 'Wenn diese Einstellung auf Ja gesetzt wird, werden alle Passwörter auch unverschlüsselt (also im Klartext, für jeden mit Zugriff auf die Froxlor-Datenbank sofort lesbar) in der mail_users-Tabelle gespeichert. Aktivieren Sie diese Option nur dann, wenn Sie SASL nutzen!';
$lng['admin']['wipecleartextmailpwd'] = 'Klartext-Passwörter leeren';
$lng['question']['admin_cleartextmailpws_reallywipe'] = 'Wollen Sie wirklich alle unverschlüsselten Passwörter aus der Tabelle mail_users entfernen? Dieser Schritt kann nicht rückgängig gemacht werden! Die Einstellung für das Speichern der E-Mail-Konten-Passwörter in Klartext wird hierbei ebenfalls deaktiviert.';
$lng['admin']['configfiles']['overview'] = 'Übersicht';
$lng['admin']['configfiles']['wizard'] = 'Assistent';
$lng['admin']['configfiles']['distribution'] = 'Distribution';
$lng['admin']['configfiles']['service'] = 'Service';
$lng['admin']['configfiles']['daemon'] = 'Daemon';
$lng['admin']['configfiles']['http'] = 'Webserver (HTTP)';
$lng['admin']['configfiles']['dns'] = 'Nameserver (DNS)';
$lng['admin']['configfiles']['mail'] = 'Mailserver (IMAP/POP3)';
$lng['admin']['configfiles']['smtp'] = 'Mailserver (SMTP)';
$lng['admin']['configfiles']['ftp'] = 'FTP-Server';
$lng['admin']['configfiles']['etc'] = 'Sonstige (System)';
$lng['admin']['configfiles']['choosedistribution'] = '-- Distribution wählen --';
$lng['admin']['configfiles']['chooseservice'] = '-- Service wählen --';
$lng['admin']['configfiles']['choosedaemon'] = '-- Daemon wählen --';

// ADDED IN 1.2.16-svn10

$lng['serversettings']['ftpdomain']['title'] = 'FTP-Benutzerkonten @domain';
$lng['serversettings']['ftpdomain']['description'] = 'Können Kunden FTP-Benutzerkonten user@domain anlegen?';
$lng['panel']['back'] = 'Zurück';

// ADDED IN 1.2.16-svn12

$lng['serversettings']['mod_fcgid']['title'] = 'PHP über mod_fcgid/suexec einbinden';
$lng['serversettings']['mod_fcgid']['description'] = 'PHP wird unter dem Benutzer des Kunden ausgeführt.<br /><br /><b>Dies benötigt eine spezielle Webserver-Konfiguration für Apache, siehe <a target="blank" href="https://github.com/Froxlor/Froxlor/wiki/apache2-with-fcgid">FCGID-Handbuch</a>.</b>';
$lng['serversettings']['sendalternativemail']['title'] = 'Alternative E-Mail-Adresse benutzen';
$lng['serversettings']['sendalternativemail']['description'] = 'Während des Erstellens eines Accounts das Passwort an eine andere E-Mail-Adresse senden';
$lng['emails']['alternative_emailaddress'] = 'Alternative E-Mail-Adresse';
$lng['mails']['pop_success_alternative']['mailbody'] = 'Hallo,\n\nihr E-Mail-Konto {USERNAME}\nwurde erfolgreich eingerichtet.\nIhr Passwort lautet {PASSWORD}.\n\nDies ist eine automatisch generierte\neMail, bitte antworten Sie nicht auf\ndiese Mitteilung.\n\nIhr Administrator';
$lng['mails']['pop_success_alternative']['subject'] = 'E-Mail-Konto erfolgreich eingerichtet';
$lng['admin']['templates']['pop_success_alternative'] = 'Willkommensmail für neue E-Mail-Konten für die alternative E-Mail-Adresse';
$lng['admin']['templates']['EMAIL_PASSWORD'] = 'Wird mit dem Passwort des neuen POP3/IMAP Kontos ersetzt.';

// ADDED IN 1.2.16-svn13

$lng['error']['documentrootexists'] = 'Es existiert noch ein Verzeichnis "%s" für diesen Kunden. Bitte löschen Sie dieses vorher.';

// ADDED IN 1.2.16-svn14

$lng['serversettings']['apacheconf_vhost']['title'] = 'Webserver vHost-Konfigurations-Datei/Verzeichnis-Name';
$lng['serversettings']['apacheconf_vhost']['description'] = 'Wo sollen die vHost-Konfigurationen abgelegt werden? Sie können entweder eine Datei (also mit allen vHosts) oder einen Ordner (mit einer Datei pro vHost) angeben.';
$lng['serversettings']['apacheconf_diroptions']['title'] = 'Webserver Verzeichnisoption-Konfigurations-Datei/Verzeichnis-Name';
$lng['serversettings']['apacheconf_diroptions']['description'] = 'Wo sollen die Verzeichnisoption-Konfigurationen abgelegt werden? Sie können entweder eine Datei (also mit allen vHosts) oder einen Ordner (mit einer Datei pro vHost) angeben.';
$lng['serversettings']['apacheconf_htpasswddir']['title'] = 'Webserver htpasswd Verzeichnisname';
$lng['serversettings']['apacheconf_htpasswddir']['description'] = 'Wo sollen die htpasswd-Dateien für den Verzeichnisschutz abgelegt werden?';

// ADDED IN 1.2.16-svn15

$lng['error']['formtokencompromised'] = 'Das Formular scheint manipuliert worden zu sein. Aus Sicherheitsgründen wurden Sie ausgelogged.';
$lng['serversettings']['mysql_access_host']['title'] = 'MySQL-Access-Hosts';
$lng['serversettings']['mysql_access_host']['description'] = 'Eine durch Komma getrennte Liste mit den Hostnamen aller Hostnames/IP-Adressen, von denen sich die Benutzer einloggen dürfen. Um ein Subnetz zu erlauben ist die Netzmaske oder CIDR Syntax erlaubt.';

// ADDED IN 1.2.18-svn1

$lng['admin']['ipsandports']['create_listen_statement'] = 'Erstelle Listen-Eintrag';
$lng['admin']['ipsandports']['create_namevirtualhost_statement'] = 'Erstelle NameVirtualHost-Eintrag';
$lng['admin']['ipsandports']['create_vhostcontainer'] = 'Erstelle vHost-Container';
$lng['admin']['ipsandports']['create_vhostcontainer_servername_statement'] = 'Erstelle ServerName-Eintrag im vHost-Container';

// ADDED IN 1.2.18-svn2

$lng['admin']['webalizersettings'] = 'Webalizereinstellungen';
$lng['admin']['webalizer']['normal'] = 'Normal';
$lng['admin']['webalizer']['quiet'] = 'Leise';
$lng['admin']['webalizer']['veryquiet'] = 'Keine Ausgaben';
$lng['serversettings']['webalizer_quiet']['title'] = 'Webalizerausgabe';
$lng['serversettings']['webalizer_quiet']['description'] = 'Ausgabefreudigkeit des Webalizer-Programms';

// ADDED IN 1.2.18-svn4

$lng['admin']['domain_nocustomeraddingavailable'] = 'Es können derzeit keine Domains angelegt werden. Sie müssen zuerst einen Kunden anlegen';

// ADDED IN 1.2.19-svn

$lng['serversettings']['mod_fcgid']['configdir']['title'] = 'Konfigurations-Verzeichnis';
$lng['serversettings']['mod_fcgid']['configdir']['description'] = 'Wo sollen alle Konfigurationsdateien von fcgid liegen? Wenn Sie keine selbst kompilierte suexec Binary benutzen, was in der Regel der Fall ist, muss dieser Pfad unter /var/www/ liegen.<br /><br /><div class="red">ACHTUNG: Der Inhalt dieses Ordners wird regelmäßig geleert, daher sollten dort keinerlei Daten manuell abgelegt werden.</div>';
$lng['serversettings']['mod_fcgid']['tmpdir']['title'] = 'Temporäres Verzeichnis';

// ADDED IN 1.2.19-svn4

$lng['menue']['traffic']['traffic'] = 'Traffic';
$lng['menue']['traffic']['current'] = 'Aktueller Monat';
$lng['traffic']['month'] = "Monat";
$lng['traffic']['months'][1] = "Januar";
$lng['traffic']['months'][2] = "Februar";
$lng['traffic']['months'][3] = "März";
$lng['traffic']['months'][4] = "April";
$lng['traffic']['months'][5] = "Mai";
$lng['traffic']['months'][6] = "Juni";
$lng['traffic']['months'][7] = "Juli";
$lng['traffic']['months'][8] = "August";
$lng['traffic']['months'][9] = "September";
$lng['traffic']['months'][10] = "Oktober";
$lng['traffic']['months'][11] = "November";
$lng['traffic']['months'][12] = "Dezember";
$lng['traffic']['mb'] = "Traffic";
$lng['traffic']['day'] = "Tag";
$lng['traffic']['distribution'] = '<span color="#019522">FTP</span> | <span color="#0000FF">HTTP</span> | <span color="#800000">Mail</span>';
$lng['traffic']['sumhttp'] = 'Gesamt HTTP-Traffic';
$lng['traffic']['sumftp'] = 'Gesamt FTP-Traffic';
$lng['traffic']['summail'] = 'Gesamt Mail-Traffic';

// ADDED IN 1.2.19-svn4.5

$lng['serversettings']['no_robots']['title'] = 'Erlaube die Indizierung Ihrer Froxlor-Installation durch Suchmaschinen';

// ADDED IN 1.2.19-svn6

$lng['admin']['loggersettings'] = 'Log-Einstellungen';
$lng['serversettings']['logger']['enable'] = 'Logging ja/nein';
$lng['serversettings']['logger']['severity'] = 'Logging Level';
$lng['admin']['logger']['normal'] = 'Normal';
$lng['admin']['logger']['paranoid'] = 'Paranoid';
$lng['serversettings']['logger']['types']['title'] = 'Log-Art(en)';
$lng['serversettings']['logger']['types']['description'] = 'Wählen Sie hier die gewünschten Logtypen. Für Mehrfachauswahl, halten Sie während der Auswahl STRG gedrückt<br />Mögliche Logtypen sind: syslog, file, mysql';
$lng['serversettings']['logger']['logfile'] = 'Log-Datei Pfad inklusive Dateinamen';
$lng['error']['logerror'] = 'Log-Fehler: "%s"';
$lng['serversettings']['logger']['logcron'] = 'Logge Cronjobs';
$lng['serversettings']['logger']['logcronoption']['never'] = 'Nie';
$lng['serversettings']['logger']['logcronoption']['once'] = 'Einmalig';
$lng['serversettings']['logger']['logcronoption']['always'] = 'Immer';
$lng['question']['logger_reallytruncate'] = 'Wollen Sie die Tabelle "%s" wirklich leeren?';
$lng['admin']['loggersystem'] = 'System-Log';
$lng['logger']['date'] = 'Datum';
$lng['logger']['type'] = 'Typ';
$lng['logger']['action'] = 'Aktion';
$lng['logger']['user'] = 'Benutzer';
$lng['logger']['truncate'] = 'Log leeren';

// ADDED IN 1.2.19-svn7

$lng['serversettings']['ssl']['use_ssl']['title'] = 'Aktiviere SSL';
$lng['serversettings']['ssl']['use_ssl']['description'] = 'Erlaubt die Nutzung von SSL für den Webserver';
$lng['serversettings']['ssl']['ssl_cert_file']['title'] = 'Pfad zum SSL-Zertifikat';
$lng['serversettings']['ssl']['ssl_cert_file']['description'] = 'Geben Sie den Pfad inklusive Dateinamen des Zertifikats an (meist .crt or .pem).';
$lng['serversettings']['ssl']['openssl_cnf'] = 'Standardwerte zum Erstellen eines Zertifikats';
$lng['panel']['reseller'] = 'Reseller';
$lng['panel']['admin'] = 'Administrator';
$lng['panel']['customer'] = 'Kunde/n';
$lng['error']['nomessagetosend'] = 'Keine Nachricht angegeben';
$lng['error']['noreceipientsgiven'] = 'Keine Empfänger angegeben';
$lng['admin']['emaildomain'] = 'E-Mail-Domain';
$lng['admin']['email_only'] = 'Nur als E-Mail-Domain verwenden?';
$lng['admin']['wwwserveralias'] = 'Einen "www." ServerAlias hinzufügen';
$lng['admin']['ipsandports']['enable_ssl'] = 'Ist dies ein SSL-Port?';
$lng['admin']['ipsandports']['ssl_cert_file'] = 'Pfad zum Zertifikat';
$lng['panel']['send'] = 'Versenden';
$lng['admin']['subject'] = 'Betreff';
$lng['admin']['receipient'] = 'Empfänger';
$lng['admin']['message'] = 'Rundmail senden';
$lng['admin']['text'] = 'Nachricht';
$lng['menu']['message'] = 'Nachrichten';
$lng['error']['errorsendingmail'] = 'Das Versenden der Nachricht an "%s" schlug fehl.';
$lng['error']['cannotreaddir'] = 'Der Ordner "%s" kann nicht gelesen werden';
$lng['message']['success'] = 'Nachricht erfolgreich an "%s" Empfänger gesendet';
$lng['message']['noreceipients'] = 'Es wurde keine E-Mail versendet, da sich keine Empfänger in der Datenbank befinden';
$lng['admin']['sslsettings'] = 'SSL-Einstellungen';
$lng['cronjobs']['notyetrun'] = 'Bisher nicht gestartet';
$lng['serversettings']['default_vhostconf']['title'] = 'Standard vHost-Einstellungen';
$lng['admin']['specialsettings_replacements'] = "Die folgenden Variablen können verwendet werden:<br/><code>{DOMAIN}</code>, <code>{DOCROOT}</code>, <code>{CUSTOMER}</code>, <code>{IP}</code>, <code>{PORT}</code>, <code>{SCHEME}</code><br/>";
$lng['serversettings']['default_vhostconf']['description'] = 'Der Inhalt dieses Feldes wird direkt in den IP/Port-vHost-Container übernommen. ' . $lng['admin']['specialsettings_replacements'] . '<br /><strong>ACHTUNG:</strong> Der Code wird nicht auf Fehler geprüft. Etwaige Fehler werden also auch übernommen. Der Webserver könnte nicht mehr starten!';
$lng['serversettings']['default_vhostconf_domain']['description'] = 'Der Inhalt dieses Feldes wird direkt in jeden Domain-vHost-Container übernommen. ' . $lng['admin']['specialsettings_replacements'] . '<strong>ACHTUNG:</strong> Der Code wird nicht auf Fehler geprüft. Etwaige Fehler werden also auch übernommen. Der Webserver könnte nicht mehr starten!';
$lng['serversettings']['apache_globaldiropt']['title'] = 'Kunden-Prefix Ordner-Optionen';
$lng['serversettings']['apache_globaldiropt']['description'] = 'Der Inhalt dieses Feldes wird in die 05_froxlor_dirfix_nofcgid.conf Apache Konfigurationsdatei eingefügt. Wenn leer werden folgende Standardwerte verwendet:<br><br>apache >=2.4<br><code>Require all granted<br>AllowOverride All</code><br><br>apache <=2.2<br><code>Order allow,deny<br>allow from all</code>';
$lng['error']['invalidip'] = 'Ungültige IP-Adresse: "%s"';
$lng['serversettings']['decimal_places'] = 'Nachkommastellen bei der Ausgabe von Traffic/Webspace';

// ADDED IN 1.2.19-svn8

$lng['admin']['dkimsettings'] = 'DomainKey-Einstellungen';
$lng['dkim']['dkim_prefix']['title'] = 'Prefix';
$lng['dkim']['dkim_prefix']['description'] = 'Wie lautet der Pfad zu den DKIM-RSA-Dateien sowie den Einstellungsdateien des Milter-Plugins?';
$lng['dkim']['dkim_domains']['title'] = 'Domains-Dateiname';
$lng['dkim']['dkim_domains']['description'] = 'Dateiname der DKIM-Domains-Angabe aus der DKIM-Milter-Konfigurationsdatei.';
$lng['dkim']['dkim_dkimkeys']['title'] = 'KeyList Dateiname';
$lng['dkim']['dkim_dkimkeys']['description'] = 'Dateiname der DKIM-KeyList-Angabe aus der DKIM-Milter-Konfigurationsdatei.';
$lng['dkim']['dkimrestart_command']['title'] = 'Milter-Restart-Kommando';
$lng['dkim']['dkimrestart_command']['description'] = 'Wie lautet das Kommando zum Neustarten des DKIM-Milter-Dienstes?';
$lng['dkim']['privkeysuffix']['title'] = 'Suffix für Private Keys';
$lng['dkim']['privkeysuffix']['description'] = 'Hier kann eine (optionale) Dateiendung für die generierten Private Keys angegeben werden. Manche Dienste, wie dkim-filter, erwarten, dass die Schlüssel keine Dateiendung haben (leer).';

// ADDED IN 1.2.19-svn9

$lng['admin']['caneditphpsettings'] = 'Kann PHP-bezogene Domaineinstellungen vornehmen?';

// ADDED IN 1.2.19-svn12

$lng['admin']['allips'] = 'Alle IP-Adressen';
$lng['panel']['nosslipsavailable'] = 'Für diesen Server wurden noch keine SSL IP/Port Kombinationen eingetragen';
$lng['dkim']['use_dkim']['title'] = 'DKIM-Support aktivieren?';
$lng['dkim']['use_dkim']['description'] = 'Wollen Sie das Domain-Keys-System (DKIM) benutzen?<br/><em class="red">Hinweis: Derzeit wird DKIM nur via dkim-filter unterstützt, nicht opendkim.</em>';
$lng['error']['invalidmysqlhost'] = 'Ungültige MySQL-Host-Adresse: "%s"';
$lng['error']['cannotuseawstatsandwebalizeratonetime'] = 'Webalizer und AWstats können nicht zur gleichen Zeit aktiviert werden, bitte wählen Sie eines aus.';
$lng['serversettings']['webalizer_enabled'] = 'Nutze Webalizer-Statistiken';
$lng['serversettings']['awstats_enabled'] = 'Nutze AWStats-Statistiken';
$lng['admin']['awstatssettings'] = 'AWstats-Einstellungen';

// ADDED IN 1.2.19-svn16

$lng['admin']['domain_dns_settings'] = 'Domain-DNS-Einstellungen';
$lng['dns']['destinationip'] = 'Domain-IP-Adresse(n)';
$lng['dns']['standardip'] = 'Server-Standard-IP-Adresse';
$lng['dns']['a_record'] = 'A-Eintrag (IPv6 optional)';
$lng['dns']['cname_record'] = 'CNAME-Eintrag';
$lng['dns']['mxrecords'] = 'MX Einträge definieren';
$lng['dns']['standardmx'] = 'Server Standard MX Eintrag';
$lng['dns']['mxconfig'] = 'Eigene MX Einträge';
$lng['dns']['priority10'] = 'Priorität 10';
$lng['dns']['priority20'] = 'Priorität 20';
$lng['dns']['txtrecords'] = 'TXT-Einträge definieren';
$lng['dns']['txtexample'] = 'Beispiel (SPF-Eintrag):<br />v=spf1 ip4:xxx.xxx.xx.0/23 -all';
$lng['serversettings']['selfdns']['title'] = 'Manuelle DNS-Einstellungen für Domains';
$lng['serversettings']['selfdnscustomer']['title'] = 'Erlaube Kunden eigene DNS-Einstellungen vorzunehmen.';
$lng['admin']['activated'] = 'Aktiviert';
$lng['admin']['statisticsettings'] = 'Statistik-Einstellungen';
$lng['admin']['or'] = 'oder';

// ADDED IN 1.2.19-svn17

$lng['serversettings']['unix_names']['title'] = 'Benutze UNIX-kompatible Benutzernamen.';
$lng['serversettings']['unix_names']['description'] = 'Erlaubt die Nutzung von <strong>-</strong> und <strong>_</strong> in Benutzernamen wenn <strong>Nein</strong>.';
$lng['error']['cannotwritetologfile'] = 'Logdatei "%s" konnte nicht für Schreiboperationen geöffnet werden.';
$lng['admin']['sysload'] = 'System-Auslastung';
$lng['admin']['noloadavailable'] = 'nicht verfügbar';
$lng['admin']['nouptimeavailable'] = 'nicht verfügbar';
$lng['panel']['backtooverview'] = 'Zurück zur Übersicht';
$lng['admin']['nosubject'] = '(Kein Betreff)';
$lng['admin']['configfiles']['statistics'] = 'Statistik';
$lng['login']['forgotpwd'] = 'Passwort vergessen?';
$lng['login']['presend'] = 'Passwort zurücksetzen';
$lng['login']['email'] = 'E-Mail-Adresse';
$lng['login']['remind'] = 'Passwort zurücksetzen';
$lng['login']['usernotfound'] = 'Fehler: Unbekannter Benutzer!';
$lng['mails']['password_reset']['subject'] = 'Passwort zurückgesetzt';
$lng['mails']['password_reset']['mailbody'] = 'Hallo {SALUTATION},\n\nhiermit erhalten Sie den Link, um ein neues Passwort zu setzen. Dieser Link ist für die nächsten 24 Stunden gültig.\n\n{LINK}\n\nVielen Dank,\nIhr Administrator';
$lng['pwdreminder']['success'] = 'Das Zurücksetzen des Passworts wurde erfolgreich angefordert. Sie sollten nun eine E-Mail mit weiteren Anweisungen erhalten.';

// ADDED IN 1.2.19-svn18

$lng['serversettings']['allow_password_reset']['title'] = 'Erlaube das Zurücksetzen des Kundenpassworts.';
$lng['pwdreminder']['notallowed'] = 'Das Zurücksetzen des Passworts ist deaktiviert.';

// ADDED IN 1.2.19-svn21

$lng['customer']['title'] = 'Titel';
$lng['customer']['country'] = 'Land';
$lng['panel']['dateformat'] = 'JJJJ-MM-TT';
$lng['panel']['dateformat_function'] = 'd.m.Y';

// Y = Year, m = Month, d = Day

$lng['panel']['timeformat_function'] = 'H:i:s';

// H = Hour, i = Minute, s = Second

$lng['panel']['default'] = 'Standard';
$lng['panel']['never'] = 'Nie';
$lng['panel']['active'] = 'Aktiv';
$lng['panel']['please_choose'] = 'Bitte auswählen';
$lng['panel']['allow_modifications'] = 'Änderungen zulassen';
$lng['domains']['add_date'] = 'Zu Froxlor hinzugefügt';
$lng['domains']['registration_date'] = 'Registriert am';
$lng['domains']['topleveldomain'] = 'Top-Level-Domain';

// ADDED IN 1.2.19-svn22

$lng['serversettings']['allow_password_reset']['description'] = 'Kunden können ihr Passwort zurücksetzen und bekommen einen Aktivierungs-Link per E-Mail zugesandt';
$lng['serversettings']['allow_password_reset_admin']['title'] = 'Erlaube das Zurücksetzen von Admin-/Reseller-Passwörtern.';
$lng['serversettings']['allow_password_reset_admin']['description'] = 'Admins/Reseller können ihr Passwort zurücksetzen und bekommen einen Aktivierungs-Link per E-Mail zugesandt';

// ADDED IN 1.2.19-svn25
// Mailquota

$lng['emails']['quota'] = 'Kontingent';
$lng['emails']['noquota'] = 'Kein Kontingent';
$lng['emails']['updatequota'] = 'Update Kontingent';
$lng['serversettings']['mail_quota']['title'] = 'Mailbox-Kontingent';
$lng['serversettings']['mail_quota']['description'] = 'Standard-Kontingent für neu erstellte E-Mail-Benutzerkonten (Megabyte).';
$lng['serversettings']['mail_quota_enabled']['title'] = 'Nutze E-Mail-Kontingent für Kunden';
$lng['serversettings']['mail_quota_enabled']['description'] = 'Aktiviere Kontingent für E-Mail-Konten. Standard ist <b>Nein</b>, da dies eine spezielle Konfiguration voraussetzt.';
$lng['serversettings']['mail_quota_enabled']['removelink'] = 'Hier klicken, um alle E-Mail-Kontingente zu entfernen';
$lng['serversettings']['mail_quota_enabled']['enforcelink'] = 'Hier klicken, um allen Benutzern das Standard-Kontingent zu zuweisen.';
$lng['question']['admin_quotas_reallywipe'] = 'Sind Sie sicher, dass alle E-Mail-Kontingente aus der Tabelle mail_users entfernt werden sollen? Dieser Schritt kann nicht rückgängig gemacht werden!';
$lng['question']['admin_quotas_reallyenforce'] = 'Sind Sie sicher, dass Sie allen Benutzern das Default-Quota zuweisen wollen? Dies kann nicht rückgängig gemacht werden!';
$lng['error']['vmailquotawrong'] = 'Die Kontingent-Größe muss positiv sein.';
$lng['customer']['email_quota'] = 'E-Mail-Kontingent';
$lng['customer']['email_imap'] = 'IMAP';
$lng['customer']['email_pop3'] = 'POP3';
$lng['customer']['mail_quota'] = 'E-Mail-Kontingent';
$lng['panel']['megabyte'] = 'Megabyte';
$lng['emails']['quota_edit'] = 'E-Mail-Kontingent ändern';
$lng['panel']['not_supported'] = 'Nicht unterstützt in: ';
$lng['error']['allocatetoomuchquota'] = 'Sie versuchen "%s" MB Kontingent zu zuweisen, haben aber nicht genug übrig.';

$lng['error']['missingfields'] = 'Es wurden nicht alle Felder augefüllt.';
$lng['error']['accountnotexisting'] = 'Der angegebene E-Mail-Account existiert nicht.';
$lng['admin']['show_version_login']['title'] = 'Zeige Froxlor Version beim Login';
$lng['admin']['show_version_login']['description'] = 'Zeige Froxlor Version in der Fußzeile der Loginseite';
$lng['admin']['show_version_footer']['title'] = 'Zeige Froxlor Version in Fußzeile';
$lng['admin']['show_version_footer']['description'] = 'Zeige Froxlor Version in der Fußzeile aller anderen Seiten';
$lng['admin']['froxlor_graphic']['title'] = 'Grafik im Kopfbereich des Panels';
$lng['admin']['froxlor_graphic']['description'] = 'Welche Grafik soll im Kopfbereich des Panels anstatt des Froxlor Logos angezeigt werden?';

// improved froxlor

$lng['menue']['phpsettings']['maintitle'] = 'PHP-Konfigurationen';
$lng['admin']['phpsettings']['title'] = 'PHP-Konfiguration';
$lng['admin']['phpsettings']['description'] = 'Kurzbeschreibung';
$lng['admin']['phpsettings']['actions'] = 'Aktionen';
$lng['admin']['phpsettings']['activedomains'] = 'In Verwendung für Domain(s)';
$lng['admin']['phpsettings']['notused'] = 'Konfiguration wird nicht verwendet';
$lng['admin']['misc'] = 'Sonstiges';
$lng['admin']['phpsettings']['editsettings'] = 'PHP-Konfiguration bearbeiten';
$lng['admin']['phpsettings']['addsettings'] = 'PHP-Konfiguration erstellen';
$lng['admin']['phpsettings']['viewsettings'] = 'PHP-Konfiguration ansehen';
$lng['admin']['phpsettings']['phpinisettings'] = 'php.ini-Einstellungen';
$lng['error']['nopermissionsorinvalidid'] = 'Entweder fehlen Ihnen die nötigen Rechte diese Einstellung zu ändern oder es wurde eine ungültige ID übergeben';
$lng['panel']['view'] = 'ansehen';
$lng['question']['phpsetting_reallydelete'] = 'Wollen Sie diese PHP-Einstellungen wirklich löschen? Alle Domains die diese Einstellungen bis jetzt verwendet haben, werden dann auf die Standardeinstellungen umgestellt.';
$lng['question']['fpmsetting_reallydelete'] = 'Wollen Sie diese PHP-FPM Einstellungen wirklich löschen? Alle PHP Konfigurationen die diese Einstellungen bis jetzt verwendet haben, werden dann auf die Standardeinstellungen umgestellt.';
$lng['admin']['phpsettings']['addnew'] = 'Neue PHP Konfiguration erstellen';
$lng['admin']['fpmsettings']['addnew'] = 'Neue PHP Version erstellen';
$lng['error']['phpsettingidwrong'] = 'Eine PHP-Konfiguration mit dieser ID existiert nicht';
$lng['error']['descriptioninvalid'] = 'Der Beschreibungstext ist zu kurz, zu lang oder enthält ungültige Zeichen';
$lng['error']['info'] = 'Info';
$lng['admin']['phpconfig']['template_replace_vars'] = 'Variablen, die in den Konfigurationen ersetzt werden';
$lng['admin']['phpconfig']['pear_dir'] = 'Wird mit dem globalen Wert für das Include Verzeichnis ersetzt.';
$lng['admin']['phpconfig']['open_basedir_c'] = 'Wird mit einem ; (Semikolon) ersetzt, um open_basedir auszukommentieren/deaktivieren, wenn eingestellt.';
$lng['admin']['phpconfig']['open_basedir'] = 'Wird mit der open_basedir-Einstellung der Domain ersetzt.';
$lng['admin']['phpconfig']['tmp_dir'] = 'Wird mit der Einstellung für das temporäre Verzeichnis der Domain ersetzt.';
$lng['admin']['phpconfig']['open_basedir_global'] = 'Wird mit der globalen Einstellung des Pfades ersetzt, der dem open_basedir hinzugefügt wird.';
$lng['admin']['phpconfig']['customer_email'] = 'Wird mit der E-Mail-Adresse des Kunden ersetzt, dem die Domain gehört.';
$lng['admin']['phpconfig']['admin_email'] = 'Wird mit der E-Mail-Adresse des Admins ersetzt, dem die Domain gehört.';
$lng['admin']['phpconfig']['domain'] = 'Wird mit der Domain ersetzt.';
$lng['admin']['phpconfig']['customer'] = 'Wird mit dem Loginnamen des Kunden ersetzt, dem die Domain gehört.';
$lng['admin']['phpconfig']['admin'] = 'Wird mit dem Loginnamen des Admins ersetzt, dem die Domain gehört.';
$lng['admin']['phpconfig']['docroot'] = 'Wird mit dem Heimatverzeichnis der Domain ersetzt.';
$lng['admin']['phpconfig']['homedir'] = 'Wird mit dem Heimatverzeichnis des Kunden ersetzt.';
$lng['login']['backtologin'] = 'Zurück zum Login';
$lng['serversettings']['mod_fcgid']['starter']['title'] = 'Prozesse je Domain';
$lng['serversettings']['mod_fcgid']['starter']['description'] = 'Wieviele PHP-Prozesse pro Domain sollen gestartet/erlaubt werden. Der Wert 0 wird empfohlen, da PHP die Anzahl dann selbst effizient verwaltet.';
$lng['serversettings']['mod_fcgid']['wrapper']['title'] = 'Wrappereinbindung in Vhosts';
$lng['serversettings']['mod_fcgid']['wrapper']['description'] = 'Wie sollen die Wrapper in den Vhosts eingebunden werden';
$lng['serversettings']['mod_fcgid']['tmpdir']['description'] = 'Wo sollen die temporären Verzeichnisse erstellt werden';
$lng['admin']['know_what_youre_doing'] = 'Ändern Sie diese Einstellungen nur, wenn Sie wissen was Sie tun!';
$lng['serversettings']['mod_fcgid']['peardir']['title'] = 'Globale PEAR Verzeichnisse';
$lng['serversettings']['mod_fcgid']['peardir']['description'] = 'Welche globalen PEAR Verzeichnisse sollen in den php.ini-Einstellungen ersetzt werden? Einzelne Verzeichnisse sind mit einem Doppelpunkt zu trennen.';

// improved Froxlor 2

$lng['admin']['templates']['index_html'] = 'index.html Datei für neu erzeugte Kundenverzeichnisse';
$lng['admin']['templates']['SERVERNAME'] = 'Wird mit dem Servernamen ersetzt.';
$lng['admin']['templates']['CUSTOMER'] = 'Wird mit dem Loginnamen des Kunden ersetzt.';
$lng['admin']['templates']['ADMIN'] = 'Wird mit dem Loginnamen des Admins ersetzt.';
$lng['admin']['templates']['CUSTOMER_EMAIL'] = 'Wird mit der E-Mail-Adresse des Kunden ersetzt.';
$lng['admin']['templates']['ADMIN_EMAIL'] = 'Wird mit der E-Mail-Adresse des Admin ersetzt.';
$lng['admin']['templates']['filetemplates'] = 'Dateivorlagen';
$lng['admin']['templates']['filecontent'] = 'Dateiinhalt';
$lng['error']['filecontentnotset'] = 'Diese Datei darf nicht leer sein!';
$lng['serversettings']['index_file_extension']['description'] = 'Welche Dateiendung soll die index Datei in neu erstellten Kundenverzeichnissen haben? Diese Dateiendung wird dann verwendet, wenn Sie bzw. einer Ihrer Admins eigene index Dateivorlagen erstellt haben.';
$lng['serversettings']['index_file_extension']['title'] = 'Dateiendung für index Datei in neu erstellen Kundenverzeichnissen';
$lng['error']['index_file_extension'] = 'Die Dateiendung für die index Datei muss zwischen 1 und 6 Zeichen lang sein und darf nur aus den Zeichen a-z, A-Z und 0-9 bestehen';
$lng['admin']['security_settings'] = 'Sicherheitseinstellungen';
$lng['admin']['expert_settings'] = 'Experteneinstellungen!';
$lng['admin']['mod_fcgid_starter']['title'] = 'PHP-Prozesse für diese Domain (leer für Standardwert)';

$lng['error']['customerdoesntexist'] = 'Der ausgewählte Kunde existiert nicht.';
$lng['error']['admindoesntexist'] = 'Der ausgewählte Admin existiert nicht.';

// ADDED IN 1.2.19-svn37

$lng['serversettings']['session_allow_multiple_login']['title'] = 'Erlaube gleichzeitigen Login';
$lng['serversettings']['session_allow_multiple_login']['description'] = 'Wenn diese Option aktiviert ist, können sich Nutzer mehrmals gleichzeitig anmelden.';
$lng['serversettings']['panel_allow_domain_change_admin']['title'] = 'Erlaube Verschieben von Domains unter Admins';
$lng['serversettings']['panel_allow_domain_change_admin']['description'] = 'Wenn diese Option aktiviert ist, kann unter Domaineinstellungen die Domain einem anderen Admin zugewiesen werden.<br /><b>Achtung:</b> Wenn der Kunde einer Domain nicht dem gleichen Admin zugeordnet ist wie die Domain selbst, kann dieser Admin alle anderen Domains des Kunden sehen!';
$lng['serversettings']['panel_allow_domain_change_customer']['title'] = 'Erlaube Verschieben von Domains unter Kunden';
$lng['serversettings']['panel_allow_domain_change_customer']['description'] = 'Wenn diese Option aktiviert ist, kann unter Domaineinstellungen die Domain einem anderen Kunden zugewiesen werden.<br /><b>Achtung:</b> Es werden keine Pfade bei dieser Aktion angepasst. Das kann dazu führen, dass die Domain nach dem Verschieben nicht mehr richtig funktioniert!';
$lng['domains']['associated_with_domain'] = 'Verbunden mit';
$lng['domains']['aliasdomains'] = 'Aliasdomains';
$lng['error']['ipportdoesntexist'] = 'Die gewählte IP/Port-Kombination existiert nicht.';

// ADDED IN 1.2.19-svn38

$lng['admin']['phpserversettings'] = 'PHP-Einstellungen';
$lng['admin']['phpsettings']['binary'] = 'PHP-Binary';
$lng['admin']['phpsettings']['fpmdesc'] = 'PHP-FPM Config';
$lng['admin']['phpsettings']['file_extensions'] = 'Dateiendungen';
$lng['admin']['phpsettings']['file_extensions_note'] = '(ohne Punkt, durch Leerzeichen getrennt)';
$lng['admin']['mod_fcgid_maxrequests']['title'] = 'Maximale PHP-Requests für diese Domain (leer für Standardwert)';
$lng['serversettings']['mod_fcgid']['maxrequests']['title'] = 'Maximale Requests pro Domain';
$lng['serversettings']['mod_fcgid']['maxrequests']['description'] = 'Wieviele PHP-Requests pro Domain sollen erlaubt werden?';

// fix bug #1124
$lng['admin']['webserver'] = 'Webserver';

// ADDED IN FROXLOR 0.9

$lng['admin']['spfsettings'] = 'Domain-SPF-Einstellungen';
$lng['spf']['use_spf'] = 'Aktiviere SPF für Domains?';
$lng['spf']['spf_entry'] = 'SPF-Eintrag für alle Domains';
$lng['panel']['toomanydirs'] = 'Zu viele Unterverzeichnisse. Weiche auf manuelle Verzeichniseingabe aus.';
$lng['panel']['abort'] = 'Abbrechen';
$lng['serversettings']['cron']['debug']['title'] = 'Debuggen des Cronscripts';
$lng['serversettings']['cron']['debug']['description'] = 'Wenn aktiviert, wird die Lockdatei nach dem Cronlauf zum Debuggen nicht gelöscht<br /><b>Achtung:</b> Eine alte Lockdatei kann weitere Cronjobs behindern und dafür sorgen, dass diese nicht vollständig ausgeführt werden.';
$lng['panel']['not_activated'] = 'Nicht aktiviert';
$lng['panel']['off'] = 'aus';
$lng['update']['updateinprogress_onlyadmincanlogin'] = 'Eine neuere Version von Froxlor wurde installiert, aber noch nicht eingerichtet.<br />Nur der Administrator kann sich anmelden und die Aktualisierung abschließen.';
$lng['update']['update'] = 'Froxlor Aktualisierung';
$lng['update']['proceed'] = 'Ausführen';
$lng['update']['update_information']['part_a'] = 'Die Froxlor-Dateien wurden aktualisiert. Neue Version ist <strong>%newversion</strong>. Die bisher installierte Version ist <strong>%curversion</strong>';
$lng['update']['update_information']['part_b'] = '<br /><br />Ein Kunden-Login ist vor Abschluss des Aktualisierungsvorganges nicht möglich.<br /><strong>Aktualisierung ausführen?</strong>';
$lng['update']['noupdatesavail'] = '<strong>Ihre Froxlor-Version ist aktuell.</strong>';
$lng['admin']['specialsettingsforsubdomains'] = 'Übernehme Einstellungen für alle Subdomains (*.beispiel.de)';
$lng['serversettings']['specialsettingsforsubdomains']['description'] = 'Wenn ja, werden die individuellen Einstellungen für alle Subdomains übernommen.<br />Wenn nein, werden Subdomain-Specialsettings entfernt.';
$lng['tasks']['outstanding_tasks'] = 'Ausstehende Cron-Aufgaben';
$lng['tasks']['rebuild_webserverconfig'] = 'Neuerstellung der Webserver-Konfiguration';
$lng['tasks']['adding_customer'] = 'Erstelle neuen Kunden %loginname%';
$lng['tasks']['rebuild_bindconfig'] = 'Neuerstellung der Bind-Konfiguration';
$lng['tasks']['creating_ftpdir'] = 'Erstelle Verzeichnis für neuen FTP-Benutzer';
$lng['tasks']['deleting_customerfiles'] = 'Löschen von Kunden-Dateien %loginname%';
$lng['tasks']['noneoutstanding'] = 'Zur Zeit gibt es keine ausstehenden Aufgaben für Froxlor';

// ADDED IN FROXLOR 0.9.1

$lng['admin']['accountdata'] = 'Benutzerdaten';
$lng['admin']['contactdata'] = 'Kontaktdaten';
$lng['admin']['servicedata'] = 'Dienstleistungsdaten';

// ADDED IN FROXLOR 0.9.2

$lng['admin']['newerversionavailable'] = 'Eine neuere Version von Froxlor wurde veröffentlicht';

// ADDED IN FROXLOR 0.9.3

$lng['emails']['noemaildomainaddedyet'] = 'Sie haben bisher noch keine (E-Mail-)Domain in Ihrem Konto.';
$lng['error']['hiddenfieldvaluechanged'] = 'Der Wert des verborgenen Feldes "%s" hat sich während dem Ändern der Einstellungen geändert.<br /><br />Dies ist im Grunde kein schwerwiegendes Problem, allerdings konnten so die Einstellungen nicht gespeichert werden.';

// ADDED IN FROXLOR 0.9.3-svn1

$lng['serversettings']['panel_password_min_length']['title'] = 'Mindestlänge von Passwörtern';
$lng['serversettings']['panel_password_min_length']['description'] = 'Hier können Sie die Mindestlänge für Passwörter festlegen. \'0\' bedeutet: Keine Mindestlänge';
$lng['error']['notrequiredpasswordlength'] = 'Das Passwort ist zu kurz. Bitte geben Sie mindestens "%s" Zeichen an.';
$lng['serversettings']['system_store_index_file_subs']['title'] = 'Erstelle Index-Datei auch in neuen Unterordnern';
$lng['serversettings']['system_store_index_file_subs']['description'] = 'Wenn aktiviert, wird für jede Subdomain mit neuem Unterordner die Standard-Index Datei angelegt.';

// ADDED IN FROXLOR 0.9.3-svn2

$lng['serversettings']['adminmail_return']['title'] = 'Antwort-Adresse';
$lng['serversettings']['adminmail_return']['description'] = 'Standard-Antwort-Adresse für E-Mails aus dem Panel.';
$lng['serversettings']['adminmail_defname'] = 'Panel-Absender-Name';

// ADDED IN FROXLOR 0.9.3-svn3
$lng['dkim']['dkim_algorithm']['title'] = 'Gültige Hash-Algorithmen';
$lng['dkim']['dkim_algorithm']['description'] = 'Wählen Sie einen Algorithmus, "All" für alle Algorithmen oder einen oder mehrere von den verfügbaren Algorithmen.';
$lng['dkim']['dkim_servicetype'] = 'Service Typen';
$lng['dkim']['dkim_keylength']['title'] = 'Schlüssel-Länge';
$lng['dkim']['dkim_keylength']['description'] = 'Achtung: Bei Änderung dieser Einstellung müssen alle private/public Schlüssel in "%s" gelöscht werden.';
$lng['dkim']['dkim_notes']['title'] = 'DKIM Notiz';
$lng['dkim']['dkim_notes']['description'] = 'Eine Notiz, welche für Menschen interessant sein könnte, z.B. eine URL wie http://www.dnswatch.info. Es gibt keine programmgesteuerte Interpretation für dieses Feld. Gehen Sie sparsam mit der Anzahl der Zeichen um, da es Einschränkungen seitens des DNS-Dienstes gibt. Dieses Feld ist für Administratoren gedacht, nicht für Benutzer.';

$lng['admin']['cron']['cronsettings'] = 'Cronjob-Einstellungen';
$lng['cron']['cronname'] = 'Cronjob-Name';
$lng['cron']['lastrun'] = 'Zuletzt gestartet';
$lng['cron']['interval'] = 'Intervall';
$lng['cron']['isactive'] = 'Aktiv';
$lng['cron']['description'] = 'Beschreibung';
$lng['crondesc']['cron_unknown_desc'] = 'Keine Beschreibung angegeben';
$lng['admin']['cron']['add'] = 'Cronjob hinzufügen';
$lng['crondesc']['cron_tasks'] = 'Erstellen von Konfigurationsdateien';
$lng['crondesc']['cron_legacy'] = 'Legacy (alter) Cronjob';
$lng['crondesc']['cron_traffic'] = 'Traffic-Berechnung';
$lng['cronmgmt']['minutes'] = 'Minuten';
$lng['cronmgmt']['hours'] = 'Stunden';
$lng['cronmgmt']['days'] = 'Tage';
$lng['cronmgmt']['weeks'] = 'Wochen';
$lng['cronmgmt']['months'] = 'Monate';
$lng['admin']['cronjob_edit'] = 'Cronjob bearbeiten';
$lng['cronjob']['cronjobsettings'] = 'Cronjob-Einstellungen';
$lng['cronjob']['cronjobintervalv'] = 'Laufzeit-Intervall Wert';
$lng['cronjob']['cronjobinterval'] = 'Laufzeit-Intervall';
$lng['panel']['options'] = 'Optionen';
$lng['admin']['warning'] = 'ACHTUNG - Wichtiger Hinweis!';
$lng['cron']['changewarning'] = 'Änderungen an diesen Werten können einen negativen Effekt auf das Verhalten von Froxlor und seinen automatisierten Aufgaben haben.<br /><br />Ändern Sie hier bitte nur etwas, wenn Sie sich über die Folgen im Klaren sind.';

$lng['serversettings']['stdsubdomainhost']['title'] = 'Kunden Standard-Subdomain';
$lng['serversettings']['stdsubdomainhost']['description'] = 'Welcher Hostname soll für das Erstellen der Kunden-Standard-Subdomain verwendet werden? Falls leer wird der System-Hostname verwendet.';

// ADDED IN FROXLOR 0.9.4-svn1
$lng['ftp']['account_edit'] = 'FTP-Konto bearbeiten';
$lng['ftp']['editpassdescription'] = 'Neues Passwort setzen oder leer für keine Änderung.';
$lng['customer']['sendinfomail'] = 'Daten per E-Mail an mich senden';
$lng['mails']['new_database_by_customer']['subject'] = '[Froxlor] Neue Datenbank erstellt';
$lng['mails']['new_database_by_customer']['mailbody'] = "Hallo {CUST_NAME},\n\ndu hast gerade eine neue Datenbank angelegt. Hier die angegebenen Informationen:\n\nDatenbankname: {DB_NAME}\nPasswort: {DB_PASS}\nBeschreibung: {DB_DESC}\nDatenbank-Server: {DB_SRV}\nphpMyAdmin: {PMA_URI}\nVielen Dank, Ihr Administrator";
$lng['serversettings']['awstats_path'] = 'Pfad zu AWStats \'awstats_buildstaticpages.pl\'';
$lng['serversettings']['awstats_conf'] = 'AWStats Konfigurations-Pfad';
$lng['error']['overviewsettingoptionisnotavalidfield'] = 'Hoppla, ein Feld, das als Option in der Konfigurationsübersicht angezeigt werden soll, hat nicht den erwarteten Wert. Sie können den Entwicklern die Schuld geben. Dies sollte nicht passieren!';
$lng['admin']['configfiles']['compactoverview'] = 'Kompakt-Übersicht';

$lng['mysql']['mysql_server'] = 'MySQL-Server';
$lng['admin']['ipsandports']['webserverdefaultconfig'] = 'Webserver-Standard-Konfiguration';
$lng['admin']['ipsandports']['webserverdomainconfig'] = 'Webserver-Domain-Konfiguration';
$lng['admin']['ipsandports']['webserverssldomainconfig'] = 'Webserver-SSL-Konfiguration';
$lng['admin']['ipsandports']['ssl_key_file'] = 'Pfad zum SSL-Private-Key';
$lng['admin']['ipsandports']['ssl_ca_file'] = 'Pfad zum SSL-CA-Zertifikat (optional)';
$lng['admin']['ipsandports']['default_vhostconf_domain'] = 'Standard vHost-Einstellungen für jeden Domain-Container';
$lng['serversettings']['ssl']['ssl_key_file']['title'] = 'Pfad zum SSL Private-Key';
$lng['serversettings']['ssl']['ssl_key_file']['description'] = 'Geben Sie den Pfad inklusive Dateinamen der Schlüssel-Datei an (der private-key, meist .key).';
$lng['serversettings']['ssl']['ssl_ca_file']['title'] = 'Pfad zum SSL-CA-Zertifikat (optional)';
$lng['serversettings']['ssl']['ssl_ca_file']['description'] = 'Client Authentifizierung, dieses Feld sollte nur gesetzt werden, wenn es wirklich gebraucht wird.';
$lng['error']['usernamealreadyexists'] = 'Der Benutzername "%s" existiert bereits.';
$lng['error']['plausibilitychecknotunderstood'] = 'Die Antwort des Plausibilitätschecks wurde nicht verstanden';
$lng['error']['errorwhensaving'] = 'Bei dem Speichern des Feldes "%s" trat ein Fehler auf';
$lng['success']['success'] = 'Information';
$lng['success']['clickheretocontinue'] = 'Hier klicken, um fortzufahren';
$lng['success']['settingssaved'] = 'Die Einstellungen wurden erfolgreich gespeichert.';
$lng['admin']['lastlogin_succ'] = 'Letzte Anmeldung';
$lng['panel']['neverloggedin'] = 'Keine Anmeldung bisher';

// ADDED IN FROXLOR 0.9.6-svn1
$lng['serversettings']['defaultttl'] = 'Domain TTL für Bind in Sekunden (default \'604800\' = 1 Woche)';

// ADDED IN FROXLOR 0.9.6-svn3
$lng['serversettings']['defaultwebsrverrhandler_enabled'] = 'Verwende Standard-Fehlerdokumente für alle Kunden';
$lng['serversettings']['defaultwebsrverrhandler_err401']['title'] = 'Datei/URL für Fehler 401';
$lng['serversettings']['defaultwebsrverrhandler_err401']['description'] = '<div class="red">Nicht unterstützt in: lighttpd</div>';
$lng['serversettings']['defaultwebsrverrhandler_err403']['title'] = 'Datei/URL für Fehler 403';
$lng['serversettings']['defaultwebsrverrhandler_err403']['description'] = '<div class="red">Nicht unterstützt in: lighttpd</div>';
$lng['serversettings']['defaultwebsrverrhandler_err404'] = 'Datei/URL für Fehler 404';
$lng['serversettings']['defaultwebsrverrhandler_err500']['title'] = 'Datei/URL für Fehler 500';
$lng['serversettings']['defaultwebsrverrhandler_err500']['description'] = '<div class="red">Nicht unterstützt in: lighttpd</div>';

// ADDED IN FROXLOR 0.9.6-svn5
$lng['serversettings']['mod_fcgid']['defaultini'] = 'Voreingestellte PHP-Konfiguration für neue Domains';

// ADDED IN FROXLOR 0.9.6-svn5
$lng['admin']['ftpserver'] = 'FTP-Server';
$lng['admin']['ftpserversettings'] = 'FTP-Server-Einstellungen';
$lng['serversettings']['ftpserver']['desc'] = 'Wenn pureftpd ausgewählt ist, werden die .ftpquota Dateien für das Quota erstellt und täglich aktualisiert.';

// ADDED IN FROXLOR 0.9.7-svn1
$lng['mails']['new_ftpaccount_by_customer']['subject'] = 'Neuer FTP-Benutzer erstellt';
$lng['mails']['new_ftpaccount_by_customer']['mailbody'] = "Hallo {CUST_NAME},\n\ndu hast gerade einen neuen FTP-Benutzer angelegt. Hier die angegebenen Informationen:\n\nBenutzername: {USR_NAME}\nPasswort: {USR_PASS}\nPfad: {USR_PATH}\n\nVielen Dank, Ihr Administrator";
$lng['domains']['redirectifpathisurl'] = 'Redirect-Code (Standard: leer)';
$lng['domains']['redirectifpathisurlinfo'] = 'Der Redirect-Code kann gewählt werden, wenn der eingegebene Pfad eine URL ist.<br/><strong class="red">HINWEIS:</strong>Änderungen werden nur wirksam wenn der Pfad eine URL ist.';
$lng['serversettings']['customredirect_enabled']['title'] = 'Erlaube Kunden-Redirect';
$lng['serversettings']['customredirect_enabled']['description'] = 'Erlaubt es Kunden den HTTP-Status Code für einen Redirect zu wählen';
$lng['serversettings']['customredirect_default']['title'] = 'Standard-Redirect';
$lng['serversettings']['customredirect_default']['description'] = 'Dieser Redirect wird immer genutzt, sofern der Kunde keinen anderen auswählt.';

// ADDED IN FROXLOR 0.9.7-svn2
$lng['error']['pathmaynotcontaincolon'] = 'Der eingegebene Pfad sollte keinen Doppelpunkt (":") enthalten. Bitte geben Sie einen korrekten Wert für den Pfad ein.';

// ADDED IN FROXLOR 0.9.9-svn1
$lng['serversettings']['mail_also_with_mxservers'] = 'Erstelle mail-, imap-, pop3- and smtp-"A Record" auch wenn MX-Server angegeben sind';

// ADDED IN FROXLOR 0.9.10-svn1
$lng['admin']['webserver_user'] = 'Benutzername Webserver';
$lng['admin']['webserver_group'] = 'Gruppenname Webserver';

// ADDED IN FROXLOR 0.9.10
$lng['serversettings']['froxlordirectlyviahostname'] = 'Froxlor direkt über den Hostnamen erreichbar machen';

// ADDED IN FROXLOR 0.9.11-svn1
$lng['serversettings']['panel_password_regex']['title'] = 'Regulärer Ausdruck für Passwörter';
$lng['serversettings']['panel_password_regex']['description'] = 'Hier können Sie einen regulären Ausdruck für Passwort-Komplexität festlegen.<br />Leer = keine bestimmten Anforderungen';
$lng['error']['notrequiredpasswordcomplexity'] = 'Die vorgegebene Passwort-Komplexität wurde nicht erfüllt.<br />Bitte kontaktieren Sie Ihren Administrator, wenn Sie Fragen zur Komplexitäts-Vorgabe haben.';

// ADDED IN FROXLOR 0.9.11-svn2
$lng['extras']['execute_perl'] = 'Perl/CGI ausführen';
$lng['admin']['perlenabled'] = 'Perl verfügbar';

// ADDED IN FROXLOR 0.9.11-svn3
$lng['serversettings']['perl_path']['title'] = 'Pfad zu Perl';
$lng['serversettings']['perl_path']['description'] = 'Standard ist /usr/bin/perl';

// ADDED IN FROXLOR 0.9.12-svn1
$lng['admin']['fcgid_settings'] = 'FCGID';
$lng['serversettings']['mod_fcgid_ownvhost']['title'] = 'Verwende FCGID im Froxlor-Vhost';
$lng['serversettings']['mod_fcgid_ownvhost']['description'] = 'Wenn verwendet, wird Froxlor selbst unter einem lokalen Benutzer ausgeführt';
$lng['admin']['mod_fcgid_user'] = 'Lokaler Benutzer für FCGID (Froxlor Vhost)';
$lng['admin']['mod_fcgid_group'] = 'Lokale Gruppe für FCGID (Froxlor Vhost)';

// ADDED IN FROXLOR 0.9.12-svn2
$lng['admin']['perl_settings'] = 'Perl/CGI';
$lng['serversettings']['perl']['suexecworkaround']['title'] = 'Aktiviere SuExec-Workaround';
$lng['serversettings']['perl']['suexecworkaround']['description'] = 'Aktivieren Sie den Workaround nur, wenn die Kunden-Heimatverzeichnisse sich nicht unterhalb des suexec-Pfades liegen.<br />Wenn aktiviert erstellt Froxlor eine Verknüpfung des vom Kunden für Perl aktiviertem Pfad + /cgi-bin/ im angegebenen suexec-Pfad.<br />Bitte beachten Sie, dass Perl dann nur im Unterordner /cgi-bin/ des Kunden-Ordners funktioniert und nicht direkt in diesem Ordner (wie es ohne den Workaround wäre!)';
$lng['serversettings']['perl']['suexeccgipath']['title'] = 'Pfad für Verknüpfungen zu Kunden-Perl-Verzeichnis';
$lng['serversettings']['perl']['suexeccgipath']['description'] = 'Diese Einstellung wird nur benötigt, wenn der SuExec-Workaround aktiviert ist.<br />ACHTUNG: Stellen Sie sicher, dass sich der angegebene Pfad innerhalb des Suexec-Pfades befindet ansonsten ist der Workaround nutzlos';
$lng['panel']['descriptionerrordocument'] = 'Mögliche Werte sind: URL, Pfad zu einer Datei oder ein Text, umgeben von Anführungszeichen (" ").<br />Leer für Server-Standardwert.';
$lng['error']['stringerrordocumentnotvalidforlighty'] = 'Ein Text als Fehlerdokument funktioniert leider in LigHTTPd nicht, bitte geben Sie einen Pfad zu einer Datei an';
$lng['error']['urlerrordocumentnotvalidforlighty'] = 'Eine URL als Fehlerdokument funktioniert leider in LigHTTPd nicht, bitte geben Sie einen Pfad zu einer Datei an';

// ADDED IN FROXLOR 0.9.12-svn3
$lng['question']['remove_subbutmain_domains'] = 'Auch Domains entfernen, welche als volle Domains hinzugefügt wurden, aber Subdomains von dieser Domain sind?';
$lng['domains']['issubof'] = 'Diese Domain ist eine Subdomain von der Domain';
$lng['domains']['issubofinfo'] = 'Diese Einstellung muss gesetzt werden, wenn Sie eine Subdomain einer Hauptdomain als Hauptdomain anlegen (z. B. soll "www.domain.tld" hinzugefügt werden, somit muss hier "domain.tld" ausgewählt werden).';
$lng['domains']['nosubtomaindomain'] = 'Keine Subdomain einer Hauptdomain';
$lng['admin']['templates']['new_database_by_customer'] = 'Kunden-Benachrichtigungs nach Erstellung einer neuen Datenbank';
$lng['admin']['templates']['new_ftpaccount_by_customer'] = 'Kunden-Benachrichtigung nach Erstellung eines neuen FTP-Benutzers';
$lng['admin']['templates']['newdatabase'] = 'Benachrichtigungs-Mails für neue Datenbank';
$lng['admin']['templates']['newftpuser'] = 'Benachrichtigungs-Mails für neuen FTP-Benutzer';
$lng['admin']['templates']['CUST_NAME'] = 'Kundenname';
$lng['admin']['templates']['DB_NAME'] = 'Datenbankname';
$lng['admin']['templates']['DB_PASS'] = 'Datenbankpasswort';
$lng['admin']['templates']['DB_DESC'] = 'Datenbankbeschreibung';
$lng['admin']['templates']['DB_SRV'] = 'Datenbankserver';
$lng['admin']['templates']['PMA_URI'] = 'URL zu phpMyAdmin (wenn angegeben)';
$lng['admin']['notgiven'] = '[nicht angegeben]';
$lng['admin']['templates']['USR_NAME'] = 'FTP-Benutzername';
$lng['admin']['templates']['USR_PASS'] = 'FTP-Passwort';
$lng['admin']['templates']['USR_PATH'] = 'FTP-Heimatverzeichnis (relativ zum Kunden-Heimatverzeichnis)';

// ADDED IN FROXLOR 0.9.12-svn4
$lng['serversettings']['awstats_awstatspath'] = 'Pfad zu AWStats \'awstats.pl\'';

// ADDED IN FROXLOR 0.9.12-svn6
$lng['extras']['htpasswdauthname'] = 'Grund der Authentifizierung (AuthName)';
$lng['extras']['directoryprotection_edit'] = 'Verzeichnisschutz bearbeiten';
$lng['admin']['templates']['forgotpwd'] = 'Benachrichtigungs-Mails bei Zurücksetzen des Passworts';
$lng['admin']['templates']['password_reset'] = 'Kunden-Benachrichtigung nach Zurücksetzen des Passworts';
$lng['admin']['store_defaultindex'] = 'Standard-Index-Datei im Kundenordner erstellen';

// ADDED IN FROXLOR 0.9.14
$lng['serversettings']['mod_fcgid']['defaultini_ownvhost'] = 'Voreingestellte PHP-Konfiguration für den Froxlor-Vhost';
$lng['serversettings']['awstats_icons']['title'] = 'Pfad zum AWstats-Icon-Ordner';
$lng['serversettings']['awstats_icons']['description'] = 'z. B. /usr/share/awstats/htdocs/icon/';
$lng['admin']['ipsandports']['ssl_cert_chainfile']['title'] = 'Pfad zu dem SSL-CertificateChainFile (optional)';
$lng['admin']['ipsandports']['ssl_cert_chainfile']['description'] = 'Meist CA_Bundle, o. Ä. Dies ist das Feld, das gesetzt werden sollte, wenn ein gekauftes SSL-Zertifikat vorliegt.';
$lng['admin']['ipsandports']['docroot']['title'] = 'Benutzerdefinierter Docroot (wenn leer, zeige auf Froxlor)';
$lng['admin']['ipsandports']['docroot']['description'] = 'Hier kann ein benutzerdefinierter Document-Root (der Zielordner für einen Zugriff) für diese IP/Port Kombination gesetzt werden.<br /><strong>ACHTUNG:</strong> Bitte überlege vorher, welchen Pfad du hier angibst!';
$lng['serversettings']['login_domain_login'] = 'Erlaube Anmeldung mit Domains';
$lng['panel']['unlock'] = 'entsperren';
$lng['question']['customer_reallyunlock'] = 'Wollen Sie den Kunden "%s" wirklich entsperren?';

// ADDED IN FROXLOR 0.9.15
$lng['serversettings']['perl_server']['title'] = 'Perl Server-Socket';
$lng['serversettings']['perl_server']['description'] = 'Eine einfache Anleitung hier zu findet man unter <a target="blank" href="http://wiki.nginx.org/SimpleCGIhttps://www.nginx.com/resources/wiki/start/topics/examples/fcgiwrap/">nginx.com</a>';
$lng['serversettings']['nginx_php_backend']['title'] = 'Nginx-PHP-Backend';
$lng['serversettings']['nginx_php_backend']['description'] = 'Dies ist das Backend, auf dem PHP auf Anfragen von Nginx hört. Kann ein UNIX Socket oder eine IP:Port Kombination sein<br />*NICHT relevant bei php-fpm';
$lng['serversettings']['phpreload_command']['title'] = 'PHP-Reload-Befehl';
$lng['serversettings']['phpreload_command']['description'] = 'Dieser wird benötigt, um das PHP-Backend bei Bedarf durch den Cronjob neu zu laden. (Standard: leer)<br />*NICHT relevant bei php-fpm';

// ADDED IN FROXLOR 0.9.16
$lng['error']['intvaluetoolow'] = 'Die angegebene Zahl ist zu klein (Feld "%s")';
$lng['error']['intvaluetoohigh'] = 'Die angegebene Zahl ist zu groß (Feld "%s")';
$lng['admin']['phpfpm_settings'] = 'PHP-FPM';
$lng['serversettings']['phpfpm']['title'] = 'Aktiviere PHP-FPM';
$lng['serversettings']['phpfpm']['description'] = '<b>Dies benötigt eine spezielle Webserver-Konfiguration, siehe FPM-Handbuch für <a target="blank" href="https://github.com/Froxlor/Froxlor/wiki/apache2-with-php-fpm">Apache2</a> oder <a target="blank" href="https://github.com/Froxlor/Froxlor/wiki/nginx-with-php-fpm">nginx</a></b>';
$lng['serversettings']['phpfpm_settings']['configdir'] = 'Pfad zu php-fpm-Konfigurationen';
$lng['serversettings']['phpfpm_settings']['aliasconfigdir'] = 'Alias-Ordner der php-fpm Konfiguration';
$lng['serversettings']['phpfpm_settings']['reload'] = 'Kommando zum Neustarten von php-fpm';
$lng['serversettings']['phpfpm_settings']['pm'] = 'Prozess Manager Control (PM)';
$lng['serversettings']['phpfpm_settings']['max_children']['title'] = 'Anzahl der Kind-Prozesse';
$lng['serversettings']['phpfpm_settings']['max_children']['description'] = 'Die Anzahl der zu startenden Kind-Prozesse wenn PM auf \'static\' steht und die maximale Anzahl der Prozesse wenn PM auf \'dynamic/ondemand\' steht.<br />Equivalent zu PHP_FCGI_CHILDREN';
$lng['serversettings']['phpfpm_settings']['start_servers']['title'] = 'Anzahl der beim Starten zu erstellenden Kind-Prozesse';
$lng['serversettings']['phpfpm_settings']['start_servers']['description'] = 'Hinweis: Nur wenn PM auf \'dynamic\' steht';
$lng['serversettings']['phpfpm_settings']['min_spare_servers']['title'] = 'Mindestanzahl der Idle-Prozesse';
$lng['serversettings']['phpfpm_settings']['min_spare_servers']['description'] = 'Hinweis: Nur wenn PM auf \'dynamic\' steht<br />Wichtig: Pflichtangabe wenn PM auf \'dynamic\' steht';
$lng['serversettings']['phpfpm_settings']['max_spare_servers']['title'] = 'Maximale Anzahl der Idle-Prozesse';
$lng['serversettings']['phpfpm_settings']['max_spare_servers']['description'] = 'Hinweis: Nur wenn PM auf \'dynamic\' steht<br />Wichtig: Pflichtangabe wenn PM auf \'dynamic\' steht';
$lng['serversettings']['phpfpm_settings']['max_requests']['title'] = 'Requests pro Kindprozess bevor Neuerstellung (respawning)';
$lng['serversettings']['phpfpm_settings']['max_requests']['description'] = 'Für keine Begrenzung \'0\' angeben. Equivalent zu PHP_FCGI_MAX_REQUESTS.';
$lng['error']['phpfpmstillenabled'] = 'PHP-FPM ist derzeit aktiviert. Bitte deaktivieren Sie es, um FCGID zu aktivieren';
$lng['error']['fcgidstillenabled'] = 'FCGID ist derzeit aktiviert. Bitte deaktivieren Sie es, um PHP-FPM zu aktivieren';
$lng['phpfpm']['vhost_httpuser'] = 'Lokaler Benutzer für PHP-FPM (Froxlor-Vhost)';
$lng['phpfpm']['vhost_httpgroup'] = 'Lokale Gruppe für PHP-FPM (Froxlor-Vhost)';
$lng['phpfpm']['ownvhost']['title'] = 'Verwende PHP-FPM im Froxlor-Vhost';
$lng['phpfpm']['ownvhost']['description'] = 'Wenn verwendet, wird Froxlor selbst unter einem lokalen Benutzer ausgeführt';

// ADDED IN FROXLOR 0.9.17
$lng['crondesc']['cron_usage_report'] = 'Webspace- und Trafficreport';
$lng['serversettings']['report']['report'] = 'Aktiviere das Senden von Reports über Webspace- und Trafficverbrauch';
$lng['serversettings']['report']['webmax']['title'] = 'Warn-Level in Prozent für Webspace';
$lng['serversettings']['report']['webmax']['description'] = 'Gültige Werte sind von 0 bis 150. Der Wert 0 deaktiviert diesen Report.';
$lng['serversettings']['report']['trafficmax']['title'] = 'Warn-Level in Prozent für Traffic';
$lng['serversettings']['report']['trafficmax']['description'] = 'Gültige Werte sind von 0 bis 150. Der Wert 0 deaktiviert diesen Report.';
$lng['mails']['trafficmaxpercent']['mailbody'] = 'Sehr geehrte(r) {NAME},\n\nSie haben bereits {TRAFFICUSED} MB von Ihren insgesamt {TRAFFIC} MB Traffic verbraucht.\nDies sind mehr als {MAX_PERCENT}%.\n\nVielen Dank,\nIhr Administrator';
$lng['mails']['trafficmaxpercent']['subject'] = 'Sie erreichen bald Ihr Traffic-Limit';
$lng['admin']['templates']['trafficmaxpercent'] = 'Hinweismail für Kunden, wenn sie die angegebenen Prozent des Traffics verbraucht haben';
$lng['admin']['templates']['MAX_PERCENT'] = 'Wird mit dem Webspace/Traffic-Limit, welches dem Kunden zugewiesen wurde, ersetzt.';
$lng['admin']['templates']['USAGE_PERCENT'] = 'Wird mit dem Webspace/Traffic, welcher vom Kunden bereits verbraucht wurde, ersetzt.';
$lng['admin']['templates']['diskmaxpercent'] = 'Hinweismail für Kunden, wenn sie die angegebenen Prozent des Webspaces verbraucht haben';
$lng['admin']['templates']['DISKAVAILABLE'] = 'Wird mit dem Webspace, der dem Kunden zugewiesen wurde, ersetzt (in MB).';
$lng['admin']['templates']['DISKUSED'] = 'Wird mit dem Webspace, welcher vom Kunden bereits verbraucht wurde, ersetzt (in MB).';
$lng['serversettings']['dropdown'] = 'Auswahlliste';
$lng['serversettings']['manual'] = 'Manuelle Eingabe';
$lng['mails']['diskmaxpercent']['mailbody'] = 'Sehr geehrte(r) {NAME},\n\nSie haben bereits {DISKUSED} MB von Ihren insgesamt {DISKAVAILABLE} MB Speicherplatz verbraucht.\nDies sind mehr als {MAX_PERCENT}%.\n\nVielen Dank,\nIhr Administrator';
$lng['mails']['diskmaxpercent']['subject'] = 'Sie erreichen bald Ihr Speicherplatz-Limit';
$lng['mysql']['database_edit'] = 'Datenbank bearbeiten';

// ADDED IN FROXLOR 0.9.18
$lng['error']['domains_cantdeletedomainwithaliases'] = 'Sie können keine Domain löschen, die noch von Alias-Domains verwendet wird. Löschen Sie zuerst alle Alias-Domains dieser Domain.';
$lng['serversettings']['default_theme'] = 'Standard-Theme';
$lng['menue']['main']['changetheme'] = 'Theme wechseln';
$lng['panel']['theme'] = 'Theme';
$lng['success']['rebuildingconfigs'] = 'Task für Neuerstellung der Konfigurationen wurde erfolgreich eingetragen';
$lng['panel']['variable'] = 'Variable';
$lng['panel']['description'] = 'Beschreibung';
$lng['emails']['back_to_overview'] = 'Zurück zur Übersicht';

// ADDED IN FROXLOR 0.9.20
$lng['error']['user_banned'] = 'Ihr Benutzerkonto wurde gesperrt. Bitte kontaktieren Sie Ihren Administrator für weitere Informationen.';
$lng['serversettings']['validate_domain'] = 'Validiere Domainnamen';
$lng['login']['combination_not_found'] = 'Kombination aus Benutzername und E-Mail Adresse stimmen nicht überein.';
$lng['customer']['generated_pwd'] = 'Passwortvorschlag';
$lng['customer']['usedmax'] = 'Benutzt / Max.';
$lng['admin']['traffic'] = 'Traffic';
$lng['admin']['customertraffic'] = 'Kunden';
$lng['traffic']['customer'] = 'Kunde';
$lng['traffic']['trafficoverview'] = 'Übersicht Traffic je';
$lng['traffic']['months']['jan'] = 'Jan';
$lng['traffic']['months']['feb'] = 'Feb';
$lng['traffic']['months']['mar'] = 'Mär';
$lng['traffic']['months']['apr'] = 'Apr';
$lng['traffic']['months']['may'] = 'Mai';
$lng['traffic']['months']['jun'] = 'Jun';
$lng['traffic']['months']['jul'] = 'Jul';
$lng['traffic']['months']['aug'] = 'Aug';
$lng['traffic']['months']['sep'] = 'Sep';
$lng['traffic']['months']['oct'] = 'Okt';
$lng['traffic']['months']['nov'] = 'Nov';
$lng['traffic']['months']['dec'] = 'Dez';
$lng['traffic']['months']['total'] = 'Gesamt';
$lng['traffic']['details'] = 'Details';
$lng['menue']['traffic']['table'] = 'Übersicht';
$lng['error']['admin_domain_emailsystemhostname'] = 'Der System-Hostname kann nicht als Kundendomain verwendet werden.';

// ADDED IN FROXLOR 0.9.21
$lng['gender']['title'] = 'Geschlecht';
$lng['gender']['male'] = 'Herr';
$lng['gender']['female'] = 'Frau';
$lng['gender']['undef'] = '';

// ADDED IN FROXLOR 0.9.22-svn1
$lng['diskquota'] = 'Quota';
$lng['serversettings']['diskquota_enabled'] = 'Quota aktiviert?';
$lng['serversettings']['diskquota_repquota_path']['description'] = 'Pfad zu repquota';
$lng['serversettings']['diskquota_quotatool_path']['description'] = 'Pfad zu quotatool';
$lng['serversettings']['diskquota_customer_partition']['description'] = 'Partition, auf welcher die Kundendaten liegen';
$lng['tasks']['diskspace_set_quota'] = 'Quota auf dem Dateisystem setzen';
$lng['error']['session_timeout'] = 'Wert zu niedrig';
$lng['error']['session_timeout_desc'] = 'Der Wert der Session-Timeout sollte nicht unter einer Minute liegen.';

// ADDED IN FROXLOR 0.9.24-svn1
$lng['admin']['assignedmax'] = 'Zugewiesen / Max.';
$lng['admin']['usedmax'] = 'Benutzt / Max.';
$lng['admin']['used'] = 'Benutzt';
$lng['mysql']['size'] = 'Datenbankgröße';

$lng['error']['invalidhostname'] = 'Hostname muss eine gültige Domain sein. Er darf weder leer sein noch nur aus Leerzeichen bestehen';

$lng['traffic']['http'] = 'HTTP';
$lng['traffic']['ftp'] = 'FTP';
$lng['traffic']['mail'] = 'Mail';

// ADDED IN 0.9.27-svn1
$lng['serversettings']['mod_fcgid']['idle_timeout']['title'] = 'Idle-Timeout';
$lng['serversettings']['mod_fcgid']['idle_timeout']['description'] = 'Timeout-Einstellung für mod_FastCGI.';
$lng['serversettings']['phpfpm_settings']['idle_timeout']['title'] = 'Idle-Timeout';
$lng['serversettings']['phpfpm_settings']['idle_timeout']['description'] = 'Timeout-Einstellung für PHP-FPM FastCGI.';

// ADDED IN 0.9.27-svn2
$lng['admin']['delete_statistics'] = 'Statistiken Löschen';
$lng['admin']['speciallogwarning'] = 'ACHTUNG: Durch diese Einstellungen werden Sie alle bisherige Statistiken dieser Domain verlieren. Wenn Sie dabei wirklich sicher sind, geben Sie bitte folgenden Text in das nachfolgende Textfeld ein: "%s" und bestätigen Sie mit "Löschen".<br /><br />';

// ADDED IN 0.9.28-svn2
$lng['serversettings']['vmail_maildirname']['title'] = 'Maildir-(Unter-)Ordner';
$lng['serversettings']['vmail_maildirname']['description'] = 'Der Maildir-Ordner innerhalb des Kontos des Benutzers (normalerweise \'Maildir\', in manchen Fällen auch \'.maildir\'). Sollen die E-Mails direkt in das Verzeichnis, diese Option leer lassen.';
$lng['tasks']['remove_emailacc_files'] = 'E-Mail-Dateien des Kunden löschen';

// ADDED IN 0.9.28-svn5
$lng['error']['operationnotpermitted'] = 'Diese Aktion ist nicht erlaubt!';
$lng['error']['featureisdisabled'] = 'Die Funktion "%s" wurde deaktiviert. Kontaktieren Sie bitte Ihren Dienstleister.';
$lng['serversettings']['catchall_enabled']['title'] = 'Catchall verwenden';
$lng['serversettings']['catchall_enabled']['description'] = 'Möchten Sie Ihren Kunden die Funktion Catchall zur Verfügung stellen?';

// ADDED IN 0.9.28.svn6
$lng['serversettings']['apache_24']['title'] = 'Anpassungen für Apache 2.4 verwenden';
$lng['serversettings']['apache_24']['description'] = '<div class="red">Achtung: Bitte nur verwenden, wenn wirklich Apache mit Version 2.4 oder höher installiert ist, ansonsten wird der Webserver nicht starten.</div>';
$lng['serversettings']['nginx_fastcgiparams']['title'] = 'Pfad zur fastcgi_params Datei';
$lng['serversettings']['nginx_fastcgiparams']['description'] = 'Geben Sie den Pfad zu nginx\'s fastcgi_params Datei an. Inklusive Dateiname!';

// Added in Froxlor 0.9.28-rc2
$lng['serversettings']['documentroot_use_default_value']['title'] = 'Verwende Domainnamen im Documentroot';
$lng['serversettings']['documentroot_use_default_value']['description'] = 'Wenn aktiviert wird dem standard Documentroot zusätzlich der Domain-Name angehängt.<br /><br />Beispiel:<br />/var/customers/customer_name/example.tld/<br />/var/customers/customer_name/subdomain.example.tld/';

$lng['error']['usercurrentlydeactivated'] = 'Der Benutzer "%s" ist derzeit deaktiviert';
$lng['admin']['speciallogfile']['title'] = 'Eigene Log-Datei';
$lng['admin']['speciallogfile']['description'] = 'Aktivieren Sie diese Option, um für diese Domain eine eigene Access-Log Datei zu erhalten';
$lng['error']['setlessthanalreadyused'] = 'Es können nicht weniger Resourcen von "%s" gesetzt werden, als der Benutzer bereits vergeben hat<br />';
$lng['error']['stringmustntbeempty'] = 'Der Wert für das Feld "%s" darf nicht leer sein';
$lng['admin']['domain_editable']['title'] = 'Erlaube Bearbeiten der Domain';
$lng['admin']['domain_editable']['desc'] = 'Wenn ja, darf der Kunde verschiedene Einstellungen anpassen.<br />Wenn nein, darf nichts durch den Kunden geändert werden.';
$lng['admin']['writeaccesslog']['title'] = 'Zugriffslog schreiben';
$lng['admin']['writeaccesslog']['description'] = 'Aktiviere diese Option, um für diese Domain eine Access-Log Datei zu erhalten';
$lng['admin']['writeerrorlog']['title'] = 'Fehlerlog schreiben';
$lng['admin']['writeerrorlog']['description'] = 'Aktiviere diese Option, um für diese Domain eine Error-Log Datei zu erhalten';

// Added in Froxlor 0.9.29-dev
$lng['serversettings']['panel_phpconfigs_hidestdsubdomain']['title'] = 'Verstecke Standard-Subdomains in PHP-Konfigurations-Übersicht';
$lng['serversettings']['panel_phpconfigs_hidestdsubdomain']['description'] = 'Wenn aktiviert, werden die Standard-Subdomains der Kunden nicht mehr in der PHP-Konfigurations-Übersicht angezeigt.<br /><br />Hinweis: Nur relevant, wenn FCGID oder PHP-FPM aktiviert ist.';
$lng['serversettings']['passwordcryptfunc']['title'] = 'Wählen Sie die zu verwendende Passwort-Verschlüsselungsmethode';
$lng['serversettings']['systemdefault'] = 'Systemstandard';
$lng['serversettings']['panel_allow_theme_change_admin'] = 'Erlaube Admins das Theme zu wechseln';
$lng['serversettings']['panel_allow_theme_change_customer'] = 'Erlaube Kunden das Theme zu wechseln';
$lng['serversettings']['axfrservers']['title'] = 'AXFR Server';
$lng['serversettings']['axfrservers']['description'] = 'Eine durch Kommas getrennte Liste von IP Adressen, die DNS-Zonen transferieren dürfen (AXFR).';
$lng['panel']['ssleditor'] = 'SSL-Einstellungen für diese Domain';
$lng['admin']['ipsandports']['ssl_paste_description'] = 'Bitte den Inhalt der Zertifikatsdatei in das Textfeld kopieren.';
$lng['admin']['ipsandports']['ssl_cert_file_content'] = 'Inhalt des SSL-Zertifikats (Certificate)';
$lng['admin']['ipsandports']['ssl_key_file_content'] = 'Inhalt der Key-Datei (Private-Key)';
$lng['admin']['ipsandports']['ssl_ca_file_content'] = 'Inhalt der SSL-CA-Datei (optional)';
$lng['admin']['ipsandports']['ssl_ca_file_content_desc'] = '<br /><br />Client Authentifizierung, dieses Feld sollte nur gesetzt werden, wenn es wirklich gebraucht wird.';
$lng['admin']['ipsandports']['ssl_cert_chainfile_content'] = 'Inhalt des SSL-CertificateChainFile (optional)';
$lng['admin']['ipsandports']['ssl_cert_chainfile_content_desc'] = '<br /><br />Meist CA_Bundle, o. Ä. Dies ist das Feld, das gesetzt werden sollte, wenn ein gekauftes SSL-Zertifikat vorliegt.';
$lng['error']['sslcertificateismissingprivatekey'] = 'Für das Zertifikat muss eine Key-Datei (Private-Key) angegeben werden.';
$lng['error']['sslcertificatewrongdomain'] = 'Das angegebene Zertifikat gilt nicht für die gewählte Domain.';
$lng['error']['sslcertificateinvalidcert'] = 'Der angegebene Zertifikatsinhalt scheint kein gültiges Zertifikat zu sein.';
$lng['error']['sslcertificateinvalidcertkeypair'] = 'Der angegebene Key (Private-Key) gehört nicht zum angegebenen Zertifikat.';
$lng['error']['sslcertificateinvalidca'] = 'Das angegebene CA-Zertifikat scheint nicht gültig zu sein.';
$lng['error']['sslcertificateinvalidchain'] = 'Das angegebene CertificateChainFile scheint nicht gültig zu sein.';
$lng['serversettings']['customerssl_directory']['title'] = 'Webserver-Kunden-SSL-Zertifikatsverzeichnis';
$lng['serversettings']['customerssl_directory']['description'] = 'Wo sollen kundenspezifizierte SSL-Zertifikate erstellt werden?<br /><br /><div class="red">ACHTUNG: Der Inhalt dieses Ordners wird regelmäßig geleert, daher sollten dort keinerlei Daten manuell abgelegt werden.</div>';
$lng['admin']['phpfpm.ininote'] = 'Nicht alle gewünschten Werte können in der php-fpm-pool-Konfiguration verwendet werden.';

// Added in Froxlor 0.9.30
$lng['crondesc']['cron_mailboxsize'] = 'Berechnung der Mailbox-Größen';
$lng['domains']['ipandport_multi']['title'] = 'IP-Adresse(n)';
$lng['domains']['ipandport_multi']['description'] = 'Definieren Sie eine oder mehrere IP-Adresse(n) für diese Domain.<br /><br /><div class="red">Hinweis: Die IP-Adressen können nicht geändert werden, sollte die Domain als <strong>Alias-Domain</strong> für eine andere Domain konfiguriert worden sein.</div>';
$lng['domains']['ipandport_ssl_multi']['title'] = 'SSL-IP-Adresse(n)';
$lng['domains']['ssl_redirect']['title'] = 'SSL-Weiterleitung';
$lng['domains']['ssl_redirect']['description'] = 'Diese Option erstellt für alle Nicht-SSL-vHosts eine Weiterleitung (Redirect), so dass alle Anfragen an den SSL-vHost übermittelt werden (z. B. würde eine Anfrage an <strong>http</strong>://domain.tld/ weitergeleitet werden zu <strong>https</strong>://domain.tld/).';
$lng['admin']['selectserveralias'] = 'ServerAlias-Angabe für Domain';
$lng['admin']['selectserveralias_desc'] = 'Wählen Sie hier, ob für diese Domain ein Wildcard-Eintrag (*.domain.tld), ein www-Alias (www.domain.tld) oder gar kein Alias angelegt werden soll.';
$lng['domains']['serveraliasoption_wildcard'] = 'Wildcard (*.domain.tld)';
$lng['domains']['serveraliasoption_www'] = 'www (www.domain.tld)';
$lng['domains']['serveraliasoption_none'] = 'Kein Alias';
$lng['error']['givendirnotallowed'] = 'Das angegebene Verzeichnis im Feld %s ist nicht erlaubt.';
$lng['serversettings']['ssl']['ssl_cipher_list']['title'] = 'Erlaubte SSL Ciphers festlegen';
$lng['serversettings']['ssl']['ssl_cipher_list']['description'] = 'Dies ist eine Liste von Ciphers, die genutzt werden sollen (oder auch nicht genutzt werden sollen), wenn eine SSL Verbindung besteht. Eine Liste aller Ciphers und wie diese hinzugefügt/ausgeschlossen werden ist in den Abschnitten "CIPHER LIST FORMAT" und "CIPHER STRINGS" in <a href="https://www.openssl.org/docs/manmaster/man1/openssl-ciphers.html">der man-page für Ciphers</a> zu finden.<br /><br /><b>Standard-Wert ist:</b><pre>ECDH+AESGCM:ECDH+AES256:!aNULL:!MD5:!DSS:!DH:!AES128</pre>';

// Added in Froxlor 0.9.31
$lng['panel']['dashboard'] = 'Dashboard';
$lng['panel']['assigned'] = 'zugewiesen';
$lng['panel']['available'] = 'verfügbar';
$lng['customer']['services'] = 'Dienste';
$lng['serversettings']['phpfpm_settings']['ipcdir']['title'] = 'FastCGI IPC Verzeichnis';
$lng['serversettings']['phpfpm_settings']['ipcdir']['description'] = 'In dieses Verzeichnis werden die php-fpm Sockets vom Webserver abgelegt.<br />Das Verzeichnis muss für den Webserver lesbar sein.';
$lng['panel']['news'] = 'Neuigkeiten';
$lng['error']['sslredirectonlypossiblewithsslipport'] = 'Eine SSL-Weiterleitung ist nur möglich, wenn der Domain mindestens eine IP/Port Kombination zugewiesen wurde, bei der SSL aktiviert ist.';
$lng['error']['fcgidstillenableddeadlock'] = 'FCGID ist derzeit aktiviert.<br />Bitte deaktiviere es, um einen anderen Webserver als Apache2 oder lighttpd auswählen zu können.';
$lng['error']['send_report_title'] = 'Fehler melden';
$lng['error']['send_report_desc'] = 'Danke, dass Sie uns diesen Fehler melden und damit helfen Froxlor zu verbessern.<br />Folgender Bericht wird per Mail an das Froxlor Entwickler Team gesendet.';
$lng['error']['send_report'] = 'Fehlerbericht senden';
$lng['error']['send_report_error'] = 'Fehler beim Senden des Berichts: <br />%s';
$lng['error']['notallowedtouseaccounts'] = 'Ihrem Konto ist die Nutzung von IMAP/POP3 nicht erlaubt, daher können keine E-Mail-Konten angelegt werden';
$lng['pwdreminder']['changed'] = 'Ihr Passwort wurde erfolgreich geändert. Sie können sich nun damit anmelden.';
$lng['pwdreminder']['wrongcode'] = 'Der verwendete Aktivierungscode ist entweder nicht gültig oder bereits abgelaufen.';
$lng['admin']['templates']['LINK'] = 'Wird mit dem Link zum Zurücksetzen des Passworts ersetzt.';
$lng['pwdreminder']['choosenew'] = 'Neues Passwort auswählen';
$lng['serversettings']['allow_error_report_admin']['title'] = 'Erlaube Administrator/Reseller das Melden von Datenbankfehlern an Froxlor';
$lng['serversettings']['allow_error_report_admin']['description'] = 'Bitte beachten: Senden Sie zu keiner Zeit irgendwelche datenschutzrelevanten/persönlichen (Kunden-)Daten an uns!';
$lng['serversettings']['allow_error_report_customer']['title'] = 'Erlaube Kunden das Melden von Datenbankfehlern an Froxlor';
$lng['serversettings']['allow_error_report_customer']['description'] = 'Bitte beachten: Senden Sie zu keiner Zeit irgendwelche datenschutzrelevanten/persönlichen (Kunden-)Daten an uns!';
$lng['admin']['phpsettings']['enable_slowlog'] = 'FPM-slowlog pro Domain aktivieren';
$lng['admin']['phpsettings']['request_terminate_timeout'] = 'request_terminate_timeout';
$lng['admin']['phpsettings']['request_slowlog_timeout'] = 'request_slowlog_timeout';
$lng['admin']['templates']['SERVER_HOSTNAME'] = 'Wird mit dem System-Hostname (URL zu froxlor) ersetzt';
$lng['admin']['templates']['SERVER_IP'] = 'Wird mit der Standard-System-IP-Adresse ersetzt';
$lng['admin']['templates']['SERVER_PORT'] = 'Wird mit dem Standard-Port ersetzt';
$lng['admin']['templates']['DOMAINNAME'] = 'Wird mit der Standardsubdomain des Kunden ersetzt (kann leer sein, wenn keine erstellt werden soll)';
$lng['admin']['show_news_feed']['title'] = 'Zeige Newsfeed im Admin-Dashboard';
$lng['admin']['show_news_feed']['description'] = 'Aktivieren Sie diese Option, um das offizielle Froxlor newsfeed (https://inside.froxlor.org/news/) auf deinem Dashboard anzuzeigen und verpasse keine wichtigen Informationen oder Release-Announcements.';
$lng['panel']['newsfeed_disabled'] = 'Das Newsfeed ist deaktiviert. Klicken Sie auf das Editier-Icon, um zu den Einstellungen zu gelangen.';

// Added in Froxlfor 0.9.32
$lng['logger']['reseller'] = "Reseller";
$lng['logger']['admin'] = "Administrator";
$lng['logger']['cron'] = "Cronjob";
$lng['logger']['login'] = "Login";
$lng['logger']['intern'] = "Intern";
$lng['logger']['unknown'] = "Unbekannt";
$lng['serversettings']['mailtraffic_enabled']['title'] = "Analysiere Mailtraffic";
$lng['serversettings']['mailtraffic_enabled']['description'] = "Aktiviere das Analysieren der Logdateien des Mailsystems, um den verbrauchten Traffic zu berechnen.";
$lng['serversettings']['mdaserver']['title'] = "Typ des MDA";
$lng['serversettings']['mdaserver']['description'] = "Der eingesetzte Mail Delivery Server";
$lng['serversettings']['mdalog']['title'] = "Logdatei des MDA";
$lng['serversettings']['mdalog']['description'] = "Die Logdatei des Mail Delivery Server";
$lng['serversettings']['mtaserver']['title'] = "Typ des MTA";
$lng['serversettings']['mtaserver']['description'] = "Der eingesetzte Mail Transfer Agent";
$lng['serversettings']['mtalog']['title'] = "Logdatei des MTA";
$lng['serversettings']['mtalog']['description'] = "Die Logdatei des Mail Transfer Agent";
$lng['panel']['ftpdesc'] = 'FTP-Beschreibung';
$lng['admin']['cronsettings'] = 'Cronjob-Einstellungen';
$lng['serversettings']['system_cronconfig']['title'] = 'Cron-Konfigurationsdatei';
$lng['serversettings']['system_cronconfig']['description'] = 'Pfad zur Konfigurationsdatei des Cron-Dienstes. Diese Datei wird von Froxlor automatisch aktualisiert.<br />Hinweis: Bitte verwenden Sie <strong>exakt</strong> die gleiche Datei wie für den Froxlor-Haupt-Cronjob (Standard: /etc/cron.d/froxlor)!<br><br>Wird <b>FreeBSD</b> verwendet, sollte hier <i>/etc/crontab</i> angegeben werden!';
$lng['tasks']['remove_ftpacc_files'] = 'Kunden FTP-Konto Dateien löschen';
$lng['tasks']['regenerating_crond'] = 'Neuerstellung der cron.d-Datei';
$lng['serversettings']['system_crondreload']['title'] = 'Cron-Daemon reload Befehl';
$lng['serversettings']['system_crondreload']['description'] = 'Geben Sie hier den Befehl zum Neuladen des Cron-Daemons an';
$lng['admin']['integritycheck'] = 'Datenbankpr&uuml;fung';
$lng['admin']['integrityid'] = '#';
$lng['admin']['integrityname'] = 'Name';
$lng['admin']['integrityresult'] = 'Ergebnis';
$lng['admin']['integrityfix'] = 'Probleme automatisch beheben';
$lng['question']['admin_integritycheck_reallyfix'] = 'M&ouml;chten Sie wirklich versuchen s&auml;mtliche Datenbank-Integrit&auml;tsprobleme automatisch zu beheben?';
$lng['serversettings']['system_croncmdline']['title'] = 'Cron Startbefehl (php Programm)';
$lng['serversettings']['system_croncmdline']['description'] = 'Befehl zum Ausführen des Cronjobs. Ändern dieser Einstellung nur wenn nötig (Standard: "/usr/bin/nice -n 5 /usr/bin/php -q")!';
$lng['error']['cannotdeletehostnamephpconfig'] = 'Diese PHP-Konfiguration ist dem Froxlor-Vhost zugewiesen und kann daher nicht gelöscht werden.';
$lng['error']['cannotdeletedefaultphpconfig'] = 'Diese PHP-Konfiguration ist als Standard hinterlegt und kann daher nicht gelöscht werden.';
$lng['serversettings']['system_cron_allowautoupdate']['title'] = 'Erlaube automatische Datenbank-Aktualisierungen';
$lng['serversettings']['system_cron_allowautoupdate']['description'] = '<strong class="red">WARNUNG:</strong> Diese Einstellung erlaubt es dem Cronjob die Prüfung der Dateien- und Datenbank-Version zu umgehen und bei einem Versions-Unterschied die Datenbank-Aktualisierungen automatisiert auszuführen.<br /><br/><div class="red">Das automatische Update setzt für neue Einstellungen und Änderungen immer die default-Werte. Diese müssen nicht zwingend zu dem genutzten System passen. Bitte zwei mal nachdenken, bevor diese Option aktiviert wird.</div>';
$lng['error']['passwordshouldnotbeusername'] = 'Das Passwort sollte nicht mit dem Benutzernamen übereinstimmen.';

// Added in Froxlor 0.9.33
$lng['admin']['customer_show_news_feed'] = "Zeige Newsfeed im Kunden-Dashboard";
$lng['admin']['customer_news_feed_url']['title'] = "Benutzerdefiniertes RSS-Feed";
$lng['admin']['customer_news_feed_url']['description'] = "Hier kann ein eigenes RSS-Feed angegeben werden, welches den Kunden auf dem Dashboard angezeigt wird.<br /><small>Leerlassen um das offizielle Froxlor Newsfeed (https://inside.froxlor.org/news/) zu verwenden.</small>";
$lng['serversettings']['dns_createhostnameentry'] = "Erstelle bind-Zone/Konfiguration für den System-Hostnamen";
$lng['serversettings']['panel_password_alpha_lower']['title'] = 'Kleinbuchstaben';
$lng['serversettings']['panel_password_alpha_lower']['description'] = 'Das Passwort muss mindestens einen Kleinbuchstaben (a-z) enthalten.';
$lng['serversettings']['panel_password_alpha_upper']['title'] = 'Großbuchstaben';
$lng['serversettings']['panel_password_alpha_upper']['description'] = 'Das Passwort muss mindestens einen Großbuchstaben (A-Z) enthalten.';
$lng['serversettings']['panel_password_numeric']['title'] = 'Zahlen';
$lng['serversettings']['panel_password_numeric']['description'] = 'Das Passwort muss mindestens eine Zahl (0-9) enhalten.';
$lng['serversettings']['panel_password_special_char_required']['title'] = 'Sonderzeichen';
$lng['serversettings']['panel_password_special_char_required']['description'] = 'Das Passwort muss mindestens eines der untenstehenden Sonderzeichen enthalten';
$lng['serversettings']['panel_password_special_char']['title'] = 'Sonderzeichen-Liste';
$lng['serversettings']['panel_password_special_char']['description'] = 'Mindestens eines dieser Sonderzeichen muss in dem Passwort vorkommen, sofern die Sonderzeichen-Option aktiviert ist.';
$lng['phpfpm']['use_mod_proxy']['title'] = 'Verwende mod_proxy / mod_proxy_fcgi';
$lng['phpfpm']['use_mod_proxy']['description'] = '<strong class="red">Muss gesetzt sein bei Debian 9.x (Stretch)</strong>. Diese Option kann aktiviert werden, um php-fpm via mod_proxy_fcgi einzubinden. Dies setzt mindestens apache-2.4.9 voraus';
$lng['error']['no_phpinfo'] = 'Entschuldigung, es ist nicht möglich die phpinfo() auszulesen.';

$lng['admin']['movetoadmin'] = 'Kunde verschieben';
$lng['admin']['movecustomertoadmin'] = 'Verschiebe den Kunden zum angegebenen Admin/Reseller<br /><small>Leerlassen für keine Änderung.<br />Wird der gewünschte Admin/Reseller hier nicht aufgelistet, hat er sein Kunden-Kontigent erreicht.</small>';
$lng['error']['moveofcustomerfailed'] = 'Das Verschieben des Kunden ist fehlgeschlagen. Alle übrigen Änderungen wurden durchgeführt und gespeichert.<br><br>Fehlermeldung: %s';

$lng['domains']['domain_import'] = 'Domains importieren';
$lng['domains']['import_separator'] = 'Trennzeichen';
$lng['domains']['import_offset'] = 'Versatz (offset)';
$lng['domains']['import_file'] = 'CSV-Datei';
$lng['success']['domain_import_successfully'] = 'Erfolgreich %s Domains importiert.';
$lng['error']['domain_import_error'] = 'Der folgende Fehler trat beim Importieren der Domains auf: %s';
$lng['admin']['note'] = 'Hinweis';
$lng['domains']['import_description'] = 'Detaillierte Informationen über den Aufbau der Importdatei und einen erfolgreichen Import gibt es hier: <a href="https://github.com/Froxlor/Froxlor/wiki/Domain-import-documenation" target="_blank">https://github.com/Froxlor/Froxlor/wiki/Domain-import-documenation</a> (englisch)';
$lng['usersettings']['custom_notes']['title'] = 'Eigene Notizen';
$lng['usersettings']['custom_notes']['description'] = 'Hier können Notizen je nach Lust und Laune eingetragen werden. Diese werden in der Administrator/Kunden-Übersicht bei dem jeweiligen Benutzer angezeigt.';
$lng['usersettings']['custom_notes']['show'] = 'Zeige die Notizen auf dem Dashboard des Benutzers';
$lng['error']['fcgidandphpfpmnogoodtogether'] = 'FCGID und PHP-FPM können nicht gleichzeitig aktiviert werden.';

// Added in Froxlor 0.9.34
$lng['admin']['configfiles']['legend'] = '<h3>Sie konfigurieren nun einen Service/Daemon.</h3>';
$lng['admin']['configfiles']['commands'] = '<span class="red">Kommandos:</span> Die angezeigten Befehle müssen als Benutzer root in einer Shell ausgeführt werden. Es kann auch problemlos der ganze Block kopiert und in die Shell eingefügt werden.';
$lng['admin']['configfiles']['files'] = '<span class="red">Konfigurationsdateien:</span> Der Befehl direkt vor dem Textfeld sollte einen Editor mit der Zieldatei öffnen. Der Inhalt kann nun einfach kopiert und in den Editor eingefügt und die Datei gespeichert werden.<br><span class="red">Bitte beachten:</span> Das MySQL-Passwort wurde aus Sicherheitsgründen nicht ersetzt. Bitte ersetzen Sie "FROXLOR_MYSQL_PASSWORD" manuell oder nutzen Sie das folgende Formular, um es temporär auf dieser Seite zu setzen. Falls das Passwort vergessen wurde, findet es sich in der Datei "lib/userdata.inc.php".';
$lng['serversettings']['apache_itksupport']['title'] = 'Anpassungen für Apache ITK-MPM verwenden';
$lng['serversettings']['apache_itksupport']['description'] = '<div class="red">Achtung: Bitte nur verwenden, wenn wirklich Apache itk-mpm verwendet wird, ansonsten wird der Webserver nicht starten.</div>';
$lng['integrity_check']['databaseCharset'] = 'Characterset der Datenbank (sollte UTF-8 sein)';
$lng['integrity_check']['domainIpTable'] = 'IP &lt;&dash;&gt; Domain Verkn&uuml;pfung';
$lng['integrity_check']['subdomainSslRedirect'] = 'Falsches SSL-redirect Flag bei nicht-SSL Domains';
$lng['integrity_check']['froxlorLocalGroupMemberForFcgidPhpFpm'] = 'froxlor-Benutzer in Kunden-Gruppen (f&uuml;r FCGID/php-fpm)';
$lng['integrity_check']['webserverGroupMemberForFcgidPhpFpm'] = 'Webserver-Benutzer in Kunden-Gruppen (f&uuml;r FCGID/php-fpm)';
$lng['integrity_check']['subdomainLetsencrypt'] = 'Hauptdomains ohne zugewiesenen SSL-Port haben keine Subdomain mit aktiviertem SSL-Redirect';
$lng['admin']['mod_fcgid_umask']['title'] = 'Umask (Standard: 022)';

// Added for let's encrypt
$lng['admin']['letsencrypt']['title'] = 'SSL Zertifikat erstellen (Let\'s Encrypt)';
$lng['admin']['letsencrypt']['description'] = 'Holt ein kostenloses Zertifikat von <a href="https://letsencrypt.org">Let\'s Encrypt</a>. Das Zertifikat wird automatisch erstellt und verlängert.<br><strong class="red">ACHTUNG:</strong> Wenn Wildcards aktiviert sind, wird diese Option automatisch deaktiviert. Dieses Feature befindet sich noch im Test.';
$lng['customer']['letsencrypt']['title'] = 'SSL Zertifikat erstellen (Let\'s Encrypt)';
$lng['customer']['letsencrypt']['description'] = 'Holt ein kostenloses Zertifikat von <a href="https://letsencrypt.org">Let\'s Encrypt</a>. Das Zertifikat wird automatisch erstellt und verlängert.<br><strong class="red">ACHTUNG:</strong> Dieses Feature befindet sich noch im Test.';
$lng['error']['sslredirectonlypossiblewithsslipport'] = 'Die Nutzung von Let\'s Encrypt ist nur möglich, wenn die Domain mindestens eine IP/Port - Kombination mit aktiviertem SSL zugewiesen hat.';
$lng['error']['nowildcardwithletsencrypt'] = 'Let\'s Encrypt kann mittels ACME Wildcard-Domains nur via DNS validieren, sorry. Bitte den ServerAlias auf WWW setzen oder deaktivieren';
$lng['panel']['letsencrypt'] = 'Benutzt Let\'s encrypt';
$lng['crondesc']['cron_letsencrypt'] = 'Aktualisierung der Let\'s Encrypt Zertifikate';
$lng['serversettings']['letsencryptca']['title'] = "Let's Encrypt Umgebung";
$lng['serversettings']['letsencryptca']['description'] = "Let's Encrypt - Umgebung, welche genutzt wird um Zertifikate zu bestellen.";
$lng['serversettings']['letsencryptcountrycode']['title'] = "Let's Encrypt Ländercode";
$lng['serversettings']['letsencryptcountrycode']['description'] = "2 - stelliger Ländercode, welcher benutzt wird um Let's Encrypt - Zertifikate zu bestellen.";
$lng['serversettings']['letsencryptstate']['title'] = "Let's Encrypt Bundesland";
$lng['serversettings']['letsencryptstate']['description'] = "Bundesland, welches benutzt wird, um Let's Encrypt - Zertifikate zu bestellen.";
$lng['serversettings']['letsencryptchallengepath']['title'] = "Verzeichnis für Let's Encrypt challenges";
$lng['serversettings']['letsencryptchallengepath']['description'] = "Let's Encrypt challenges werden aus diesem Verzeichnis über einen globalen Alias ausgeliefert.";
$lng['serversettings']['letsencryptkeysize']['title'] = "Schlüsselgröße für neue Let's Encrypt Zertifikate";
$lng['serversettings']['letsencryptkeysize']['description'] = "Größe des Schlüssels in Bit für neue Let's Encrypt Zertifikate.";
$lng['serversettings']['letsencryptreuseold']['title'] = "Let's Encrypt Schlüssel wiederverwenden";
$lng['serversettings']['letsencryptreuseold']['description'] = "Wenn dies aktiviert ist, wird der alte Schlüssel bei jeder Verlängerung verwendet, andernfalls wird ein neues Paar generiert.";
$lng['serversettings']['leenabled']['title'] = "Let's Encrypt verwenden";
$lng['serversettings']['leenabled']['description'] = "Wenn dies aktiviert ist, können Kunden durch Froxlor automatisch generierte und verlängerbare Let's Encrypt SSL-Zertifikate für Domains mit SSL IP/Port nutzen.<br /><br />Bitte die Webserver-Konfiguration beachten wenn aktiviert, da dieses Feature eine spezielle Konfiguration benötigt.";
$lng['domains']['ssl_redirect_temporarilydisabled'] = "<br>Die SSL-Umleitung ist, während ein neues Let's Encrypt - Zertifikat erstellt wird, temporär deaktiviert. Die Umleitung wird nach der Zertifikatserstellung wieder aktiviert.";

// Added for CAA record support
$lng['serversettings']['caa_entry']['title'] = 'CAA DNS Einträge generieren';
$lng['serversettings']['caa_entry']['description'] = 'Generiert CAA Einträge automatisch für alle Domains mit aktiviertem SSL und Let\'s Encrypt';
$lng['serversettings']['caa_entry_custom']['title'] = 'Zusätzliche CAA DNS Einträge';
$lng['serversettings']['caa_entry_custom']['description'] = 'DNS Certification Authority Authorization (CAA) verwendet das Domain Name System, um dem Besitzer einer Domain die Möglichkeit zu bieten, gewisse Zertifizierungsstellen (CAs) dazu zu berechtigen,<br>ein Zertifikat für die betroffene Domain auszustellen. CAA Records sollen verhindern, dass Zertifikate fälschlicherweise für eine Domain ausgestellt werden.<br><br>Der Inhalt dieses Feldes wird direkt in die DNS Zone übernommen (eine Zeile pro CAA Record). Wenn Let\'s Encrypt für eine Domain aktiviert wurde und die obige Option aktiviert wurde, wird immer automatisch dieser Eintrag angefügt und muss nicht selber angegeben werden:<br><code>0 issue "letsencrypt.org"</code> (Wenn wildcard aktiviert ist, wird statdessen issuewild benutzt).<br>Um Incident Reporting per Mail zu aktivieren, muss eine <code>iodef</code> Zeile angefügt werden. Ein Beispiel für einen Report an <code>me@example.com</code> wäre:<br><code>0 iodef "mailto:me@example.com"</code><br><br><strong>ACHTUNG:</strong> Der Code wird nicht auf Fehler geprüft. Etwaige Fehler werden also auch übernommen. Die CAA finalen Einträge könnten daher falsch sein!';

// Autoupdate
$lng['admin']['autoupdate'] = 'Auto-Update';
$lng['error']['customized_version'] = 'Es scheint als wäre die Froxlor Installation angepasst worden. Kein Support, sorry.';
$lng['error']['autoupdate_0'] = 'Unbekannter Fehler';
$lng['error']['autoupdate_1'] = 'PHP Einstellung allow_url_fopen ist deaktiviert. Autoupdate benötigt diese Option, bitte in der php.ini aktivieren.';
$lng['error']['autoupdate_2'] = 'PHP zip Erweiterung nicht gefunden, bitte prüfen, ob diese installiert und aktiviert ist.';
$lng['error']['autoupdate_4'] = 'Das froxlor Archiv konnte nicht auf der Festplatte gespeichert werden :(';
$lng['error']['autoupdate_5'] = 'version.froxlor.org gab ungültige Werte zurück :(';
$lng['error']['autoupdate_6'] = 'Woops, keine (gültige) Version angegeben für den Download :(';
$lng['error']['autoupdate_7'] = 'Das heruntergeladene Archiv konnte nicht gefunden werden :(';
$lng['error']['autoupdate_8'] = 'Das Archiv konnte nicht entpackt werden :(';
$lng['error']['autoupdate_9'] = 'Die heruntergeladene Datei konnte nicht verifiziert werden. Bitte erneut versuchen zu aktualisieren.';
$lng['error']['autoupdate_10'] = 'Minimum unterstützte Version von PHP ist 7.0';

$lng['domains']['termination_date'] = 'Kündigungsdatum';
$lng['domains']['termination_date_overview'] = 'gekündigt zum ';
$lng['panel']['set'] = 'Setzen';
$lng['customer']['selectserveralias_addinfo'] = 'Diese Option steht beim Bearbeiten der Domain zur Verfügung. Als Initial-Wert wird die Einstellung der Hauptdomain vererbt.';
$lng['error']['mailaccistobedeleted'] = "Ein vorheriges Konto mit dem gleichen Namen (%s) wird aktuell noch gelöscht und kann daher derzeit nicht angelegt werden";

$lng['menue']['extras']['backup'] = 'Sicherung';
$lng['extras']['backup'] = 'Sicherung erstellen';
$lng['extras']['backup_web'] = 'Web-Daten sichern';
$lng['extras']['backup_mail'] = 'E-Mail Daten sichern';
$lng['extras']['backup_dbs'] = 'Datenbanken sichern';
$lng['error']['customerhasongoingbackupjob'] = 'Es gibt noch einen austehenden Backup-Job. Bitte haben Sie etwas Geduld.';
$lng['success']['backupscheduled'] = 'Ihre Sicherung wurde erfolgreich geplant. Bitte warten Sie nun, bis diese abgearbeitet wurde.';
$lng['success']['backupaborted'] = 'Die geplante Sicherung wurde abgebrochen';
$lng['crondesc']['cron_backup'] = 'Ausstehende Sicherungen erstellen';
$lng['error']['backupfunctionnotenabled'] = 'Die Sicherungs-Funktion is nicht aktiviert';
$lng['serversettings']['backupenabled']['title'] = "Backup für Kunden aktivieren";
$lng['serversettings']['backupenabled']['description'] = "Wenn dies aktiviert ist, kann der Kunde Sicherungen planen (cron-backup) welche ein Archiv in sein Heimatverzeichnis ablegt (Unterordner vom Kunden wählbar)";
$lng['extras']['path_protection_label'] = '<strong class="red">Wichtig</strong>';
$lng['extras']['path_protection_info'] = '<strong class="red">Wir raten dringend dazu den angegebenen Pfad zu schützen, siehe "Extras" -> "Verzeichnisschutz"</strong>';
$lng['tasks']['backup_customerfiles'] = 'Datensicherung für Kunde %loginname%';

$lng['error']['dns_domain_nodns'] = 'DNS ist für diese Domain nicht aktiviert';
$lng['error']['dns_content_empty'] = 'Keinen Inhalt angegeben';
$lng['error']['dns_content_invalid'] = 'DNS Eintrag ungültig';
$lng['error']['dns_arec_noipv4'] = 'Keine gültige IP-Adresse für A-Eintrag angegeben';
$lng['error']['dns_aaaarec_noipv6'] = 'Keine gültige IP-Adresse für AAAA-Eintrag angegeben';
$lng['error']['dns_mx_prioempty'] = 'Ungültige MX Priorität angegeben';
$lng['error']['dns_mx_needdom'] = 'Der Wert des MX Eintrags muss ein gültiger Domainname sein';
$lng['error']['dns_mx_noalias'] = 'Der MX Eintrag darf kein CNAME Eintrag sein.';
$lng['error']['dns_cname_invaliddom'] = 'Ungültiger Domain-Name für CNAME Eintrag';
$lng['error']['dns_cname_nomorerr'] = 'Es existiert bereits ein Eintrag mit dem gleichen Namen. Dieser Eintrag kann daher nicht für CNAME genutzt werden.';
$lng['error']['dns_ns_invaliddom'] = 'Ungültiger Domain-Name für NS Eintrag';
$lng['error']['dns_srv_prioempty'] = 'Ungültige SRV Priorität angegeben';
$lng['error']['dns_srv_invalidcontent'] = 'Ungültiger Wert des SRV Eintrags, dieser muss aus den Feldern weight, port und target, bestehen. Bsp.: 5 5060 sipserver.example.com.';
$lng['error']['dns_srv_needdom'] = 'Der Wert des SRV Eintrags muss ein gültiger Domainname sein';
$lng['error']['dns_srv_noalias'] = 'Der SRV Eintrag darf kein CNAME Eintrag sein.';
$lng['error']['dns_duplicate_entry'] = 'Eintrag existiert bereits';
$lng['success']['dns_record_added'] = 'Eintrag erfolgreich hinzugefügt';
$lng['success']['dns_record_deleted'] = 'Eintrag erfolgreich entfernt';
$lng['dnseditor']['edit'] = 'DNS editieren';
$lng['dnseditor']['records'] = 'Einträge';
$lng['error']['dns_notfoundorallowed'] = 'Domain nicht gefunden oder keine Berechtigung';
$lng['serversettings']['dnseditorenable']['title'] = 'DNS Editor aktivieren';
$lng['serversettings']['dnseditorenable']['description'] = 'Erlaubt es Admins und Kunden die DNS Einträge ihrer Domains zu verwalten.';
$lng['dns']['howitworks'] = 'Hier können DNS Einträge für die Domain verwaltet werden. Beachten Sie, dass Froxlor automatisch NS/MX/A/AAAA Einträge generiert. Die benutzerdefinierten Einträge werden bevorzugt, nur fehlende Einträge werden automatisch generiert.';
$lng['serversettings']['dns_server']['title'] = 'DNS Server Dienst';
$lng['serversettings']['dns_server']['description'] = 'Dienste müssen mit den froxlor Konfigurationstemplates konfiguriert werden';

$lng['error']['domain_nopunycode'] = 'Die Eingabe von Punycode (IDNA) ist nicht notwendig. Die Domain wird automatisch konvertiert.';
$lng['admin']['dnsenabled'] = 'Zugriff auf DNS Editor';
$lng['error']['dns_record_toolong'] = 'Records/Labels können maximal 63 Zeichen lang sein';

// Added in froxlor 0.9.37-rc1
$lng['serversettings']['panel_customer_hide_options']['title'] = 'Menüpunkte und Traffic-Charts im Kundenbereich ausblenden';
$lng['serversettings']['panel_customer_hide_options']['description'] = 'Wählen Sie hier die gewünschten Menüpunkte und Traffic-Charts aus, welche im Kundenbereich ausgeblendet werden sollen. Für Mehrfachauswahl, halten Sie während der Auswahl STRG gedrückt.';

// Added in froxlor 0.9.38-rc1
$lng['serversettings']['allow_allow_customer_shell']['title'] = 'Erlaube Kunden für FTP Benutzer eine Shell auszuwählen';
$lng['serversettings']['allow_allow_customer_shell']['description'] = '<strong class="red">Bitte beachten: Shell Zugriff gestattet dem Benutzer verschiedene Programme auf Ihrem System auszuführen. Mit großer Vorsicht verwenden. Bitte aktiviere dies nur wenn WIRKLICH bekannt ist, was das bedeutet!!!</strong>';
$lng['serversettings']['available_shells']['title'] = 'Liste der verfügbaren Shells';
$lng['serversettings']['available_shells']['description'] = 'Komma-getrennte Liste von Shells, die der Kunde für seine FTP-Konten wählen kann.<br><br>Hinweis: Die Standard-Shell <strong>/bin/false</strong> wird immer eine Auswahlmöglichkeit sein (wenn aktiviert), auch wenn diese Einstellung leer ist. Sie ist in jedem Fall der Standardwert für alle FTP-Konten';
$lng['serversettings']['le_froxlor_enabled']['title'] = "Let's Encrypt für den froxlor Vhost verwenden";
$lng['serversettings']['le_froxlor_enabled']['description'] = "Wenn dies aktiviert ist, erstellt froxlor für seinen vhost automatisch ein Let's Encrypt Zertifikat.";
$lng['serversettings']['le_froxlor_redirect']['title'] = "SSL-Weiterleitung für den froxlor Vhost aktivieren";
$lng['serversettings']['le_froxlor_redirect']['description'] = "Wenn dies aktiviert ist, werden alle HTTP Anfragen an die entsprechende SSL Seite weitergeleitet.";
$lng['admin']['froxlorvhost'] = 'Froxlor VirtualHost Einstellungen';
$lng['serversettings']['option_unavailable_websrv'] = '<br><em class="red">Nur verfügbar für: %s</em>';
$lng['serversettings']['option_unavailable'] = '<br><em class="red">Option aufgrund anderer Einstellungen nicht verfügbar.</em>';
$lng['serversettings']['letsencryptacmeconf']['title'] = "Pfad zu acme.conf";
$lng['serversettings']['letsencryptacmeconf']['description'] = "Dateiname der Konfiguration, die dem Webserver erlaubt, die ACME-Challenges zu bedienen.";
$lng['admin']['hostname'] = 'Hostname';
$lng['admin']['memory'] = 'Speicherauslastung';
$lng['serversettings']['mail_use_smtp'] = 'Nutze SMTP für das Senden von E-Mails';
$lng['serversettings']['mail_smtp_host'] = 'SMTP Server';
$lng['serversettings']['mail_smtp_usetls'] = 'Aktiviere TLS Verschlüsselung';
$lng['serversettings']['mail_smtp_auth'] = 'Nutze SMTP Authentifizierung';
$lng['serversettings']['mail_smtp_port'] = 'TCP Port für SMTP';
$lng['serversettings']['mail_smtp_user'] = 'SMTP Benutzer';
$lng['serversettings']['mail_smtp_passwd'] = 'SMTP Passwort';
$lng['domains']['ssl_certificates'] = 'SSL Zertifikate';
$lng['domains']['ssl_certificate_removed'] = 'Das Zertifikat mit der ID #%s wurde erfolgreich gelöscht.';
$lng['domains']['ssl_certificate_error'] = "Fehler beim Lesen des Zertifikats für die Domain: %s";
$lng['domains']['no_ssl_certificates'] = "Es wurden keine SSL-Zertifikate gefunden";
$lng['admin']['webserversettings_ssl'] = 'Webserver SSL-Einstellungen';
$lng['admin']['domain_hsts_maxage']['title'] = 'HTTP Strict Transport Security (HSTS)';
$lng['admin']['domain_hsts_maxage']['description'] = '"max-age" Wert für den Strict-Transport-Security Header<br>Der Wert <i>0</i> deaktiviert HSTS für diese Domain. Meist wird der Wert <i>31536000</i> gerne genutzt (ein Jahr).';
$lng['admin']['domain_hsts_incsub']['title'] = 'Inkludiere HSTS für jede Subdomain';
$lng['admin']['domain_hsts_incsub']['description'] = 'Die optionale "includeSubDomains" Direktive, wenn vorhanden, signalisiert dem UA, dass die HSTS Regel für diese Domain und auch jede Subdomain dieser gilt.';
$lng['admin']['domain_hsts_preload']['title'] = 'Füge Domain in die <a href="https://hstspreload.appspot.com/" target="_blank">HSTS preload Liste</a> hinzu';
$lng['admin']['domain_hsts_preload']['description'] = 'Wenn die Domain in die HSTS preload Liste, verwaltet von Chrome (und genutzt von Firefox und Safari), hinzugefügt werden soll, dann aktivieren Sie diese Einstellung.<br>Die preload-Direktive zu senden kann PERMANTENTE KONSEQUENZEN haben und dazu führen, dass Benutzer auf diese Domain und auch Subdomains nicht zugreifen können.<br>Beachten Sie die Details unter <a href="https://hstspreload.appspot.com/#removal" target="_blank">hstspreload.appspot.com/#removal</a> bevor ein Header mit "preload" gesendet wird.';

$lng['serversettings']['http2_support']['title'] = 'HTTP2 Unterstützung';
$lng['serversettings']['http2_support']['description'] = 'Aktiviere HTTP2 Unterstützung für SSL.<br><em class="red">NUR AKTIVIEREN, WENN DER WEBSERVER DIESE FUNKTION UNTERSTÜTZT (nginx version 1.9.5+, apache2 version 2.4.17+)</em>';

$lng['error']['noipportgiven'] = 'Keine IP/Port angegeben';

// Added in froxlor 0.9.38.8
$lng['admin']['domain_ocsp_stapling']['title'] = 'OCSP stapling';
$lng['admin']['domain_ocsp_stapling']['description'] = 'Siehe <a target="_blank" href="https://de.wikipedia.org/wiki/Online_Certificate_Status_Protocol_stapling">Wikipedia</a> für eine ausführliche Beschreibung von OCSP-Stapling';
$lng['admin']['domain_ocsp_stapling']['nginx_version_warning'] = '<br /><strong class="red">WARNUNG:</strong> Nginx unterstützt OCSP-Stapling erst ab Version 1.3.7. Wenn Ihre Version älter ist, wird der Webserver bei aktiviertem OCSP-Stapling NICHT korrekt starten.';
$lng['serversettings']['ssl']['apache24_ocsp_cache_path']['title'] = 'Apache 2.4: Pfad zum OCSP-Stapling-Cache';
$lng['serversettings']['ssl']['apache24_ocsp_cache_path']['description'] = 'Konfiguriert den Cache-Pfad zum Zwischenspeichern der OCSP-Antworten,<br />die an TLS-Handshakes angehängt werden.';
$lng['serversettings']['nssextrausers']['title'] = 'Verwende libnss-extrausers anstatt libnss-mysql';
$lng['serversettings']['nssextrausers']['description'] = 'Lese Benutzer nicht direkt aus der Datenbank sondern über Dateien. Bitte nur aktivieren, wenn die entsprechende Konfiguration vorgenommen wurde (System -> libnss-extrausers).<br><strong class="red">Nur für Debian/Ubuntu (oder wenn libnss-extrausers manuell kompiliert wurde!)</strong>';
$lng['admin']['domain_http2']['title'] = 'HTTP2 Unterstützung';
$lng['admin']['domain_http2']['description'] = 'Siehe <a target="_blank" href="https://de.wikipedia.org/wiki/Hypertext_Transfer_Protocol#HTTP.2F2">Wikipedia</a> für eine ausführliche Beschreibung von HTTP2';
$lng['admin']['testmail'] = 'SMTP Test';
$lng['success']['testmailsent'] = 'Test E-Mail erfolgreich gesendet';
$lng['serversettings']['le_domain_dnscheck']['title'] = "Validiere DNS der Domains wenn Let's Encrypt genutzt wird";
$lng['serversettings']['le_domain_dnscheck']['description'] = "Wenn aktiviert wird froxlor überprüfen ob die DNS Einträge der Domains, welche ein Let's Encrypt Zertifikat beantragt, mindestens auf eine der System IP Adressen auflöst.";
$lng['menue']['phpsettings']['fpmdaemons'] = 'PHP-FPM Versionen';
$lng['admin']['phpsettings']['activephpconfigs'] = 'In Verwendung für PHP-Konfiguration(en)';
$lng['admin']['phpsettingsforsubdomains'] = 'PHP-Config für alle Subdomains übernehmen:';
$lng['serversettings']['phpsettingsforsubdomains']['description'] = 'Wenn ja, wird die gewählte PHP-Config für alle Subdomains übernommen';
$lng['serversettings']['leapiversion']['title'] = "Wählen Sie die Let's Encrypt ACME Implementierung";
$lng['serversettings']['leapiversion']['description'] = "Aktuell unterstützt froxlor lediglich die ACME v2 Implementierung von Let's Encrypt.";
$lng['admin']['phpsettings']['pass_authorizationheader'] = 'Füge "-pass-header Authorization" / "CGIPassAuth On" in Vhosts ein';
$lng['serversettings']['ssl']['ssl_protocols']['title'] = 'SSL Protokollversion festlegen';
$lng['serversettings']['ssl']['ssl_protocols']['description'] = 'Dies ist eine Liste von SSL/TLS Protokollversionen die genutzt werden sollen (oder auch nicht genutzt werden sollen), wenn SSL verwendet wird. <b>Hinweis:</b> Ältere Browser sind möglicherweise nicht vollständig zum neusten Protokoll kompatibel.<br /><br /><b>Standard-Wert ist:</b><pre>TLSv1.2</pre>';
$lng['serversettings']['phpfpm_settings']['limit_extensions']['title'] = 'Erlaubte Dateiendungen';
$lng['serversettings']['phpfpm_settings']['limit_extensions']['description'] = 'Beschränkt die Dateierweiterungen des Haupt-Skripts, das FPM zu parsen erlaubt. Dies kann Konfigurationsfehler auf der Webserverseite verhindern. Sie sollten FPM nur auf .php Erweiterungen beschränken, um zu verhindern, dass bösartige Nutzter andere Erweiterungen verwenden, um PHP Code auszuführen. Standardwert: .php';
$lng['phpfpm']['ini_flags'] = 'Mögliche <strong>php_flag</strong>s für die php.ini. Pro Zeile eine Direktive';
$lng['phpfpm']['ini_values'] = 'Mögliche <strong>php_value</strong>s für die php.ini. Pro Zeile eine Direktive';
$lng['phpfpm']['ini_admin_flags'] = 'Mögliche <strong>php_admin_flag</strong>s für die php.ini. Pro Zeile eine Direktive';
$lng['phpfpm']['ini_admin_values'] = 'Mögliche <strong>php_admin_value</strong>s für die php.ini. Pro Zeile eine Direktive';
$lng['serversettings']['phpfpm_settings']['envpath'] = 'Pfade für die PATH Umgebungsvariable. Leerlassen, um keine PATH Umgebungsvariable zu setzen.';
$lng['success']['settingsimported'] = 'Einstellungnen erfolgreich importiert';
$lng['error']['jsonextensionnotfound'] = 'Diese Funktion benötigt die PHP json-Erweiterung.';

// added in froxlor 0.9.39
$lng['admin']['plans']['name'] = 'Plan Name';
$lng['admin']['plans']['description'] = 'Beschreibung';
$lng['admin']['plans']['last_update'] = 'Zuletzt aktualisiert';
$lng['admin']['plans']['plans'] = 'Hosting Pläne';
$lng['admin']['plans']['plan_details'] = 'Plan Details';
$lng['admin']['plans']['add'] = 'Neuen Plan anlegen';
$lng['admin']['plans']['edit'] = 'Plan editieren';
$lng['admin']['plans']['use_plan'] = 'Plan übernehmen';
$lng['question']['plan_reallydelete'] = 'Wollen Sie den Hosting-Plan "%s" wirklich löschen?';
$lng['admin']['notryfiles']['title'] = 'Keine generierte try_files Anweisung';
$lng['admin']['notryfiles']['description'] = 'Wählen Sie "Ja", wenn eine eigene try_files Direktive in den "eigenen Vhost Einstellungen" angegeben werden soll (z.B. nötig für manche Wordpress Plugins).';
$lng['serversettings']['phpfpm_settings']['override_fpmconfig'] = 'Überschreibe FPM-Daemon Einstellungen (pm, max_children, etc.)';
$lng['serversettings']['phpfpm_settings']['override_fpmconfig_addinfo'] = '<br /><span class="red">Nur verwendet wenn "Überschreibe FPM-Daemon Einstellungen" auf "Ja" gestellt ist</span>';
$lng['panel']['backuppath']['title'] = 'Pfad zur Ablage der Backups';
$lng['panel']['backuppath']['description'] = 'In diesem Ordner werden die Backups abgelegt. Wenn das Sichern von Web-Daten aktiviert ist, werden alle Dateien aus dem Heimatverzeichnis gesichert, exklusive des hier angegebenen Backup-Ordners.';

// added in froxlor 0.10.0
$lng['panel']['none_value'] = 'Keine';
$lng['menue']['main']['apihelp'] = 'API Hilfe';
$lng['menue']['main']['apikeys'] = 'API Keys';
$lng['apikeys']['no_api_keys'] = 'Keine API Keys gefunden';
$lng['apikeys']['key_add'] = 'API Key hinzufügen';
$lng['apikeys']['apikey_removed'] = 'Der API Key mit der ID #%s wurde erfolgreich gelöscht.';
$lng['apikeys']['allowed_from'] = 'Erlaube Zugriff von';
$lng['apikeys']['allowed_from_help'] = 'Komma getrennte Liste von IPs. Standard ist leer.<br>Angabe von Subnetzen z.B. 192.168.1.1/24 wird derzeit nicht unterstützt.';
$lng['apikeys']['valid_until'] = 'Gültig bis';
$lng['apikeys']['valid_until_help'] = 'Datum Gültigkeitsende, Format JJJJ-MM-TT';
$lng['serversettings']['enable_api']['title'] = 'Aktiviere externe API Nutzung';
$lng['serversettings']['enable_api']['description'] = 'Um die froxlor API nutzen zu können, muss diese Option aktiviert sein. Für detaillierte Informationen siehe <a href="https://api.froxlor.org/" target="_new">https://api.froxlor.org/</a>';
$lng['serversettings']['dhparams_file']['title'] = 'DHParams Datei (Diffie–Hellman key exchange)';
$lng['serversettings']['dhparams_file']['description'] = 'Wird eine dhparams.pem Datei hier angegeben, wir sie in die Webserver Konfiguration mit eingefügt.<br>Beispiel: /etc/ssl/webserver/dhparams.pem<br><br>Existiert die Datei nicht, wird sie wie folgt erstellt: <em>openssl dhparam -out /etc/ssl/webserver/dhparams.pem 4096<em>. Es wird empfohlen die Datei zu erstellen, bevor sie hier angegeben wird, da die Erstellung längere Zeit in Anspruch nimmt und den Cronjob blockiert.';
$lng['2fa']['2fa'] = '2FA Optionen';
$lng['2fa']['2fa_enabled'] = 'Aktiviere Zwei-Faktor Authentifizierung (2FA)';
$lng['login']['2fa'] = 'Zwei-Faktor Authentifizierung (2FA)';
$lng['login']['2facode'] = 'Bitte 2FA Code angeben';
$lng['2fa']['2fa_removed'] = '2FA erfolgreich gelöscht';
$lng['2fa']['2fa_added'] = '2FA erfolgreich aktiviert<br><a href="%s?s=%s&page=2fa">2FA Details öffnen</a>';
$lng['2fa']['2fa_add'] = '2FA aktivieren';
$lng['2fa']['2fa_delete'] = '2FA deaktivieren';
$lng['2fa']['2fa_verify'] = 'Code verifizieren';
$lng['mails']['2fa']['mailbody'] = 'Hallo,\n\nihr 2FA-Login Code lautet: {CODE}\n\nDies ist eine automatisch generierte\neMail, bitte antworten Sie nicht auf\ndiese Mitteilung.\n\nIhr Administrator';
$lng['mails']['2fa']['subject'] = 'Froxlor - 2FA Code';
$lng['2fa']['2fa_overview_desc'] = 'Hier kann für das Konto eine Zwei-Faktor-Authentisierung aktiviert werden.<br><br>Es kann entweder eine Authenticator-App (time-based one-time password / TOTP) genutzt werden oder ein Einmalpasswort, welches nach erfolgreichem Login an die hinterlegte E-Mail Adresse gesendet wird.';
$lng['2fa']['2fa_email_desc'] = 'Das Konto ist eingerichtet, um Einmalpasswörter per E-Mail zu erhalten. Zum Deaktivieren, klicke auf "' . $lng['2fa']['2fa_delete'] . '"';
$lng['2fa']['2fa_ga_desc'] = 'Das Konto ist eingerichtet, um zeitbasierte Einmalpasswörter via Authenticator-App zu erhalten. Um die gewünschte Authenticator-App einzurichten, scanne bitte den untenstehenden QR-Code. Zum Deaktivieren, klicke auf "' . $lng['2fa']['2fa_delete'] . '"';
$lng['admin']['logviewenabled'] = 'Zugriff auf access/error-Logdateien';
$lng['panel']['viewlogs'] = 'Logdateien einsehen';
$lng['panel']['not_configured'] = 'Das System wurde noch nicht konfiguriert. Hier klicken für Konfiguration.';
$lng['panel']['done_configuring'] = 'Nach Abschluss der Konfiguration der Dienste,<br>untenstehenden Link klicken';
$lng['panel']['ihave_configured'] = 'Ich habe die Dienste konfiguriert';
$lng['panel']['system_is_configured'] = 'Das System ist bereits konfiguriert';
$lng['panel']['settings_before_configuration'] = 'Stelle sicher, dass die Einstellungen angepasst wurden bevor die Dienste konfiguriert werden.';
$lng['panel']['alternative_cmdline_config'] = 'Alternativ, führe den folgenden Befehl als root-Benutzer auf der Shell aus, um die Dienste automatisch zu konfigurieren.';
$lng['tasks']['remove_pdns_domain'] = 'Lösche Domain %s von PowerDNS Datenbank';
$lng['tasks']['remove_ssl_domain'] = 'Lösche SSL Dateien von Domain %s';
$lng['admin']['novhostcontainer'] = '<br><br><small class="red">Keine der IPs und Ports hat die Option "' . $lng['admin']['ipsandports']['create_vhostcontainer'] . '" aktiviert, einige Einstellungen sind daher nicht verfügbar.</small>';
$lng['serversettings']['errorlog_level']['title'] = 'Ausführlichkeit des Fehlerprotokolls';
$lng['serversettings']['errorlog_level']['description'] = 'Steuert die Ausführlichkeit des Fehlerprotokolls. Voreinstellung ist "warn" bei Apache und "error" bei Nginx.';
$lng['serversettings']['letsencryptecc']['title'] = "ECC / ECDSA Zertifikate ausstellen";
$lng['serversettings']['letsencryptecc']['description'] = "Wenn eine Schlüsselgröße ausgewählt wird, werden ECC / ECDSA Zertifikate erstellt";
$lng['serversettings']['froxloraliases']['title'] = "Domain Aliase für Froxlor Vhost";
$lng['serversettings']['froxloraliases']['description'] = "Komma getrennte Liste von Domains, welche als Server Alias zum Froxlor Vhost hinzugefügt werden";

$lng['serversettings']['ssl']['tlsv13_cipher_list']['title'] = 'Explizite TLSv1.3 Ciphers, wenn genutzt';
$lng['serversettings']['ssl']['tlsv13_cipher_list']['description'] = 'Dies ist eine Liste von Ciphers, die genutzt werden sollen (oder auch nicht genutzt werden sollen), wenn eine TLSv1.3 Verbindung hergestellt werden soll. Eine Liste aller Ciphers und wie diese hinzugefügt/ausgeschlossen werden ist <a href="https://wiki.openssl.org/index.php/TLS1.3">der Dokumentation für TLSv1.3</a> zu entnehmen.<br /><br /><b>Standard-Wert ist leer</b>';
$lng['usersettings']['api_allowed']['title'] = 'Erlaube API Zugriff';
$lng['usersettings']['api_allowed']['description'] = 'Wenn in den Einstellungen aktiviert, kann der Benutzer API Schlüssel erstellen und auf die froxlor API Zugreifen';
$lng['usersettings']['api_allowed']['notice'] = 'API Zugriff ist für dieses Konto deaktiviert.';
$lng['serversettings']['default_sslvhostconf']['title'] = 'Standard SSL vHost-Einstellungen';
$lng['serversettings']['includedefault_sslvhostconf'] = 'Nicht-SSL vHost-Einstellungen in SSL-vHost inkludieren';
$lng['admin']['ownsslvhostsettings'] = 'Eigene SSL vHost-Einstellungen';
$lng['admin']['ipsandports']['ssl_default_vhostconf_domain'] = 'Standard SSL vHost-Einstellungen für jeden Domain-Container';
$lng['customer']['total_diskspace'] = 'Gesamtspeicherplatz';
$lng['admin']['domain_override_tls'] = 'Überschreibe System TLS Einstellungen';
$lng['domains']['isaliasdomainof'] = 'Ist Aliasdomain für %s';
$lng['serversettings']['apply_specialsettings_default']['title'] = 'Standardwert für "' . $lng['admin']['specialsettingsforsubdomains'] . "' Einstellung beim Bearbeiten einer Domain";
$lng['serversettings']['apply_phpconfigs_default']['title'] = 'Standardwert für "' . $lng['admin']['phpsettingsforsubdomains'] . "' Einstellung beim Bearbeiten einer Domain";
$lng['admin']['domain_sslenabled'] = 'Aktiviere Nutzung von SSL';
$lng['admin']['domain_honorcipherorder'] = 'Bevorzuge die serverseitige Cipher Reihenfolge, Standardwert <strong>nein</strong>';
$lng['admin']['domain_sessiontickets'] = 'Aktiviere TLS Sessiontickets (RFC 5077), Standardwert <strong>ja</strong>';

$lng['admin']['domain_sessionticketsenabled']['title'] = 'Aktiviere Nutzung von TLS Sessiontickets systemweit';
$lng['admin']['domain_sessionticketsenabled']['description'] = 'Standardwert <strong>yes</strong><br>Erfordert apache-2.4.11+ oder nginx-1.5.9+';

$lng['serversettings']['phpfpm_settings']['restart_note'] = 'Achtung: Der Code wird nicht auf Fehler geprüft. Bei etwaigen Fehlern könnte der PHP-FPM-Prozess nicht mehr starten!';
$lng['serversettings']['phpfpm_settings']['custom_config']['title'] = 'Benutzerdefinierte Konfiguration';
$lng['serversettings']['phpfpm_settings']['custom_config']['description'] = 'Füge eine benutzerdefinierte Einstellungen zur PHP-FPM Instanz hinzu, beispielsweise <i>pm.status_path = /status</i> für Monitoring. Unten ersichtliche Variablen können verwendet werden.' . ' <strong>' . $lng['serversettings']['phpfpm_settings']['restart_note'] . '</strong>';

$lng['serversettings']['awstats']['logformat']['title'] = 'LogFormat Einstellung';
$lng['serversettings']['awstats']['logformat']['description'] = 'Wenn ein benutzerdefiniertes LogFormat beim Webserver verwendet wird, muss LogFormat von awstats ebenso angepasst werden.<br/>Standard ist 1. Für weitere Informationen siehe Dokumentation unter <a target="_blank" href="https://awstats.sourceforge.io/docs/awstats_config.html#LogFormat">hier</a>.';
$lng['error']['cannotdeletesuperadmin'] = 'Der erste Administrator kann nicht gelöscht werden.';
$lng['error']['no_wwwcnamae_ifwwwalias'] = 'Es kann kein CNAME Eintrag für "www" angelegt werden, da die Domain einen www-Alias aktiviert hat. Ändere diese Einstellung auf "Kein Alias" oder "Wildcard Alias"';
$lng['serversettings']['hide_incompatible_settings'] = 'Inkompatible Einstellungen ausblenden';

$lng['serversettings']['soaemail'] = 'Mail-Adresse für SOA-Einträge (verwendet Panel-Absender-Name der Panel-Einstellungen falls leer)';
