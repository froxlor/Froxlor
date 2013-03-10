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
$lng['panel']['emptyfordefault'] = 'leer für Standardeinstellung';
$lng['panel']['path'] = 'Pfad';
$lng['panel']['toggle'] = 'Umschalten';
$lng['panel']['next'] = 'weiter';
$lng['panel']['dirsmissing'] = 'Verzeichnisse nicht verfügbar oder lesbar';

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
$lng['customer']['email'] = 'E-Mail';
$lng['customer']['customernumber'] = 'Kundennummer';
$lng['customer']['diskspace'] = 'Webspace (MB)';
$lng['customer']['traffic'] = 'Traffic (GB)';
$lng['customer']['mysqls'] = 'MySQL-Datenbanken';
$lng['customer']['emails'] = 'E-Mail-Adressen';
$lng['customer']['accounts'] = 'E-Mail-Konten';
$lng['customer']['forwarders'] = 'E-Mail-Weiterleitungen';
$lng['customer']['ftps'] = 'FTP-Konten';
$lng['customer']['subdomains'] = 'Sub-Domain(s)';
$lng['customer']['domains'] = 'Domain(s)';
$lng['customer']['unlimited'] = 'unbegrenzt';

/**
 * Customermenue
 */

$lng['menue']['main']['main'] = 'Allgemein';
$lng['menue']['main']['changepassword'] = 'Passwort ändern';
$lng['menue']['main']['changelanguage'] = 'Sprache ändern';
$lng['menue']['email']['email'] = 'E-Mail';
$lng['menue']['email']['emails'] = 'Adressen';
$lng['menue']['email']['webmail'] = 'WebMail';
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
$lng['changepassword']['new_password_confirm'] = 'Neues Passwort (bestätigen)';
$lng['changepassword']['new_password_ifnotempty'] = 'Neues Passwort (leer = nicht ändern)';
$lng['changepassword']['also_change_ftp'] = 'Auch Passwort vom Haupt-FTP-Zugang ändern';

/**
 * Domains
 */

$lng['domains']['description'] = 'Hier können Sie (Sub-)Domains erstellen und deren Pfade ändern.<br />Nach jeder Änderung braucht das System etwas Zeit um die Konfiguration neu einzulesen.';
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

$lng['emails']['description'] = 'Hier können Sie Ihre E-Mail Adressen einrichten.<br />Ein Konto ist wie Ihr Briefkasten vor der Haustüre. Wenn jemand eine E-Mail an Sie schreibt, dann wird diese in dieses Konto gelegt.<br /><br />Die Zugangsdaten von Ihrem Mailprogramm sind wie folgt: (Die Angaben in <i>kursiver</i> Schrift sind durch die jeweiligen Einträge zu ersetzen!)<br />Hostname: <b><i>Domainname</i></b><br />Benutzername: <b><i>Kontoname / E-Mail-Adresse</i></b><br />Passwort: <b><i>das gewählte Passwort</i></b>';
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

$lng['extras']['description'] = 'Hier können Sie zusätzliche Extras einrichten, wie zum Beispiel Verzeichnisschutz.<br />Die Änderungen sind erst nach einer bestimmten Zeit wirksam.';
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
$lng['error']['directorymustexist'] = 'Das Verzeichnis %s muss existieren. Legen Sie es bitte mit Ihrem FTP-Programm an.';
$lng['error']['filemustexist'] = 'Die Datei %s muss existieren.';
$lng['error']['allresourcesused'] = 'Sie haben bereits alle Ihnen zur Verfügung stehenden Ressourcen verbraucht.';
$lng['error']['domains_cantdeletemaindomain'] = 'Sie können keine Domain, die als E-Mail-Domain verwendet wird, löschen. ';
$lng['error']['domains_canteditdomain'] = 'Sie können diese Domain nicht bearbeiten. Dies wurde durch den Admin verweigert';
$lng['error']['domains_cantdeletedomainwithemail'] = 'Sie können keine Domain löschen, die noch als E-Mail-Domain verwendet wird. Löschen Sie zuerst alle E-Mail-Adressen dieser Domain.';
$lng['error']['firstdeleteallsubdomains'] = 'Sie müssen erst alle Subdomains löschen, bevor Sie eine Wildcarddomain anlegen können.';
$lng['error']['youhavealreadyacatchallforthisdomain'] = 'Sie haben bereits eine Adresse als Catchall für diese Domain definiert.';
$lng['error']['ftp_cantdeletemainaccount'] = 'Sie können Ihren Hauptaccount nicht löschen.';
$lng['error']['login'] = 'Der angegebene Benutzername/Passwort ist falsch.';
$lng['error']['login_blocked'] = 'Dieser Account wurde aufgrund zu vieler Fehlversuche vorrübergehend geschlossen. <br />Bitte versuchen Sie es in ' . $settings['login']['deactivatetime'] . ' Sekunden erneut.';
$lng['error']['notallreqfieldsorerrors'] = 'Sie haben nicht alle Felder oder ein Feld mit fehlerhaften Angaben ausgefüllt.';
$lng['error']['oldpasswordnotcorrect'] = 'Das alte Passwort ist nicht korrekt.';
$lng['error']['youcantallocatemorethanyouhave'] = 'Sie können nicht mehr Ressourcen verteilen als Sie noch frei haben.';
$lng['error']['mustbeurl'] = 'Sie müssen eine vollständige URL angeben (z.B. http://irgendwas.de/error404.htm)';
$lng['error']['invalidpath'] = 'Sie haben keine gültige URL ausgewählt (Evtl. Probleme beim Verzeichnislisting?)';
$lng['error']['stringisempty'] = 'Fehlende Eingabe im Feld';
$lng['error']['stringiswrong'] = 'Falsche Eingabe im Feld';
$lng['error']['myloginname'] = '\'' . $lng['login']['username'] . '\'';
$lng['error']['mypassword'] = '\'' . $lng['login']['password'] . '\'';
$lng['error']['oldpassword'] = '\'' . $lng['changepassword']['old_password'] . '\'';
$lng['error']['newpassword'] = '\'' . $lng['changepassword']['new_password'] . '\'';
$lng['error']['newpasswordconfirm'] = '\'' . $lng['changepassword']['new_password_confirm'] . '\'';
$lng['error']['newpasswordconfirmerror'] = 'Das neue Passwort und die Bestätigung sind nicht identisch.';
$lng['error']['myname'] = '\'' . $lng['customer']['name'] . '\'';
$lng['error']['myfirstname'] = '\'' . $lng['customer']['firstname'] . '\'';
$lng['error']['emailadd'] = '\'' . $lng['customer']['email'] . '\'';
$lng['error']['mydomain'] = '\'Domain\'';
$lng['error']['mydocumentroot'] = '\'Documentroot\'';
$lng['error']['loginnameexists'] = 'Der Login-Name %s existiert bereits.';
$lng['error']['emailiswrong'] = 'Die E-Mail-Adresse %s enthält ungültige Zeichen oder ist nicht vollständig.';
$lng['error']['loginnameiswrong'] = 'Der Login-Name %s enthält ungültige Zeichen.';
$lng['error']['userpathcombinationdupe'] = 'Kombination aus Benutzername und Pfad existiert bereits.';
$lng['error']['patherror'] = 'Allgemeiner Fehler! Pfad darf nicht leer sein.';
$lng['error']['errordocpathdupe'] = 'Option für Pfad %s existiert bereits.';
$lng['error']['adduserfirst'] = 'Sie müssen zuerst einen Kunden anlegen.';
$lng['error']['domainalreadyexists'] = 'Die Domain %s wurde bereits einem Kunden zugeordnet.';
$lng['error']['nolanguageselect'] = 'Keine Sprache ausgewählt.';
$lng['error']['nosubjectcreate'] = 'Sie müssen einen Betreff angeben.';
$lng['error']['nomailbodycreate'] = 'Sie müssen einen E-Mail-Text eingeben.';
$lng['error']['templatenotfound'] = 'Vorlage wurde nicht gefunden.';
$lng['error']['alltemplatesdefined'] = 'Sie können keine weiteren Vorlagen anlegen, da bereits alle Sprachen mit Vorlagen versorgt sind.';
$lng['error']['wwwnotallowed'] = 'Ihre Subdomain darf nicht www heißen.';
$lng['error']['subdomainiswrong'] = 'Die Subdomain %s enthält ungültige Zeichen.';
$lng['error']['domaincantbeempty'] = 'Der Domain-Name darf nicht leer sein.';
$lng['error']['domainexistalready'] = 'Die Domain %s existiert bereits.';
$lng['error']['domainisaliasorothercustomer'] = 'Die ausgewählte Aliasdomain ist entweder selber eine Aliasdomain, hat nicht die gleiche IP/Port Kombination oder gehört zu einem anderen Kunden.';
$lng['error']['emailexistalready'] = 'Die E-Mail-Adresse %s existiert bereits.';
$lng['error']['maindomainnonexist'] = 'Die Haupt-Domain %s existiert nicht.';
$lng['error']['destinationnonexist'] = 'Bitte geben Sie Ihre Weiterleitungsadresse im Feld \'Nach\' ein.';
$lng['error']['destinationalreadyexistasmail'] = 'Die Weiterleitung zu %s exisitiert bereits als aktive E-Mail-Adresse.';
$lng['error']['destinationalreadyexist'] = 'Es gibt bereits eine Weiterleitung nach %s .';
$lng['error']['destinationiswrong'] = 'Die Weiterleitungsadresse-Adresse %s enthält ungültige Zeichen oder ist nicht vollständig.';
$lng['error']['domainname'] = $lng['domains']['domainname'];
$lng['error']['ticketnotaccessible'] = 'Sie können sich das Ticket nicht ansehen.';

/**
 * Questions
 */

$lng['question']['question'] = 'Sicherheitsabfrage';
$lng['question']['admin_customer_reallydelete'] = 'Wollen Sie den Kunden %s wirklich löschen?<br />ACHTUNG! Alle Daten gehen unwiderruflich verloren! Nach dem Vorgang müssen Sie die Daten aus dem Dateisystem noch manuell entfernen.';
$lng['question']['admin_domain_reallydelete'] = 'Wollen Sie die Domain %s wirklich löschen?';
$lng['question']['admin_domain_reallydisablesecuritysetting'] = 'Wollen Sie diese wichtige Sicherheitseinstellung OpenBasedir wirklich deaktivieren?';
$lng['question']['admin_admin_reallydelete'] = 'Wollen Sie den Admin %s wirklich löschen?<br />Alle Kunden und Domains werden Ihrem Account zugeteilt.';
$lng['question']['admin_template_reallydelete'] = 'Wollen Sie die Vorlage \'%s\' wirklich löschen?';
$lng['question']['domains_reallydelete'] = 'Wollen Sie die Domain %s wirklich löschen?';
$lng['question']['email_reallydelete'] = 'Wollen Sie die E-Mail-Adresse %s wirklich löschen?';
$lng['question']['email_reallydelete_account'] = 'Wollen Sie das Konto von %s wirklich löschen?';
$lng['question']['email_reallydelete_forwarder'] = 'Wollen Sie die Weiterleitung %s wirklich löschen?';
$lng['question']['extras_reallydelete'] = 'Wollen Sie den Verzeichnisschutz für %s wirklich löschen?';
$lng['question']['extras_reallydelete_pathoptions'] = 'Wollen Sie die Optionen für den Pfad %s wirklich löschen?';
$lng['question']['ftp_reallydelete'] = 'Wollen Sie das FTP-Benutzerkonto %s wirklich löschen?';
$lng['question']['mysql_reallydelete'] = 'Wollen Sie die Datenbank %s wirklich löschen?<br />ACHTUNG! Alle Daten gehen unwiderruflich verloren!';
$lng['question']['admin_configs_reallyrebuild'] = 'Wollen Sie wirklich alle Konfigurationsdateien neu erstellen lassen?';
$lng['question']['admin_customer_alsoremovefiles'] = 'Auch Kunden-Daten löschen?';
$lng['question']['admin_customer_alsoremovemail'] = 'E-Mail Daten auf dem Dateisystem löschen?';
$lng['question']['admin_customer_alsoremoveftphomedir'] = 'Heimatverzeichnis des FTP-Benutzers löschen?';

/**
 * Mails
 */

$lng['mails']['pop_success']['mailbody'] = 'Hallo,\n\nIhr E-Mail-Konto {USERNAME}\nwurde erfolgreich eingerichtet.\n\nDies ist eine automatisch generierte\nE-Mail, bitte antworten Sie nicht auf\ndiese Mitteilung.\n\nIhr Administrator';
$lng['mails']['pop_success']['subject'] = 'E-Mail-Konto erfolgreich eingerichtet';
$lng['mails']['createcustomer']['mailbody'] = 'Hallo {FIRSTNAME} {NAME},\n\nhier ihre Accountinformationen:\n\nBenutzername: {USERNAME}\nPasswort: {PASSWORD}\n\nVielen Dank,\nIhr Administrator';
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
$lng['admin']['lookfornewversion']['clickhere'] = 'per Webservice abfragen';
$lng['admin']['lookfornewversion']['error'] = 'Fehler beim Auslesen';
$lng['admin']['resources'] = 'Ressourcen';
$lng['admin']['customer'] = 'Kunde';
$lng['admin']['customers'] = 'Kunden';
$lng['admin']['customer_add'] = 'Kunden anlegen';
$lng['admin']['customer_edit'] = 'Kunden bearbeiten';
$lng['admin']['domains'] = 'Domains';
$lng['admin']['domain_add'] = 'Domain anlegen';
$lng['admin']['domain_edit'] = 'Domain bearbeiten';
$lng['admin']['subdomainforemail'] = 'Subdomains als E-Mail-Domains';
$lng['admin']['admin'] = 'Admin';
$lng['admin']['admins'] = 'Admins';
$lng['admin']['admin_add'] = 'Admin anlegen';
$lng['admin']['admin_edit'] = 'Admin bearbeiten';
$lng['admin']['customers_see_all'] = 'Kann alle Kunden sehen?';
$lng['admin']['domains_see_all'] = 'Kann alle Domains sehen?';
$lng['admin']['change_serversettings'] = 'Kann Servereinstellungen bearbeiten?';
$lng['admin']['server'] = 'Server';
$lng['admin']['serversettings'] = 'Einstellungen';
$lng['admin']['rebuildconf'] = 'Configs neuschreiben';
$lng['admin']['stdsubdomain'] = 'Standardsubdomain';
$lng['admin']['stdsubdomain_add'] = 'Standardsubdomain anlegen';
$lng['admin']['phpenabled'] = 'PHP verfügbar';
$lng['admin']['deactivated'] = 'Gesperrt';
$lng['admin']['deactivated_user'] = 'Benutzer sperren';
$lng['admin']['sendpassword'] = 'Passwort zusenden';
$lng['admin']['ownvhostsettings'] = 'Eigene vHost-Einstellungen';
$lng['admin']['configfiles']['serverconfiguration'] = 'Konfiguration';
$lng['admin']['configfiles']['files'] = '<b>Konfigurationsdateien:</b> Bitte ändern Sie die entsprechenden Konfigurationsdateien<br />oder legen sie mit dem folgenden Inhalt neu an, falls sie nicht existieren.<br /><b>Bitte beachten Sie:</b> Das MySQL-Passwort wurde aus Sicherheitsgründen nicht ersetzt.<br />Bitte ersetzen Sie "MYSQL_PASSWORD" manuell durch das entsprechende Passwort.<br />Falls Sie es vergessen haben sollten, finden Sie es in der Datei "lib/userdata.inc.php".';
$lng['admin']['configfiles']['commands'] = '<b>Kommandos:</b> Bitte führen Sie die folgenden Kommandos in einer Shell aus.';
$lng['admin']['configfiles']['restart'] = '<b>Neustart:</b> Bitte führen Sie die folgenden Kommandos zum Neuladen<br />der Konfigurationsdateien in einer Shell aus.';
$lng['admin']['templates']['templates'] = 'E-Mail-Vorlagen';
$lng['admin']['templates']['template_add'] = 'Vorlage hinzufügen';
$lng['admin']['templates']['template_edit'] = 'Vorlage bearbeiten';
$lng['admin']['templates']['action'] = 'Aktion';
$lng['admin']['templates']['email'] = 'E-Mail & Dateivorlagen';
$lng['admin']['templates']['subject'] = 'Betreff';
$lng['admin']['templates']['mailbody'] = 'Mailtext';
$lng['admin']['templates']['createcustomer'] = 'Willkommensmail für neue Kunden';
$lng['admin']['templates']['pop_success'] = 'Willkommensmail für neue E-Mail Konten';
$lng['admin']['wwwserveralias'] = 'www. ServerAlias hinzufügen';
$lng['admin']['templates']['template_replace_vars'] = 'Variablen, die in den Vorlagen ersetzt werden:';
$lng['admin']['templates']['SALUTATION'] = 'Wird mit einer korrekten Anrede des Kunden ersetzt';
$lng['admin']['templates']['FIRSTNAME'] = 'Wird mit dem Vornamen des Kunden ersetzt.';
$lng['admin']['templates']['NAME'] = 'Wird mit dem Namen des Kunden ersetzt.';
$lng['admin']['templates']['COMPANY'] = 'Wird mit dem Firmennamen des Kunden ersetzt.';
$lng['admin']['templates']['USERNAME'] = 'Wird mit dem Benutzernamen des neuen Kundenkontos ersetzt.';
$lng['admin']['templates']['PASSWORD'] = 'Wird mit dem Passwort des neuen Kundenkontos ersetzt.';
$lng['admin']['templates']['EMAIL'] = 'Wird mit der Adresse des neuen POP3/IMAP Kontos ersetzt.';

/**
 * Serversettings
 */

$lng['serversettings']['session_timeout']['title'] = 'Session Timeout';
$lng['serversettings']['session_timeout']['description'] = 'Wie lange muss ein Benutzer inaktiv sein, damit die Session ungültig wird? (Sekunden)';
$lng['serversettings']['accountprefix']['title'] = 'Kundenprefix';
$lng['serversettings']['accountprefix']['description'] = 'Welchen Prefix sollen die Kundenaccounts haben?';
$lng['serversettings']['mysqlprefix']['title'] = 'SQL-Prefix';
$lng['serversettings']['mysqlprefix']['description'] = 'Welchen Prefix sollen die MySQL-Benutzerkonten haben?';
$lng['serversettings']['ftpprefix']['title'] = 'FTP-Prefix';
$lng['serversettings']['ftpprefix']['description'] = 'Welchen Prefix sollen die FTP-Benutzerkonten haben?';
$lng['serversettings']['documentroot_prefix']['title'] = 'Heimatverzeichnis';
$lng['serversettings']['documentroot_prefix']['description'] = 'Wo sollen alle Heimatverzeichnisse der Kunden liegen?';
$lng['serversettings']['logfiles_directory']['title'] = 'Webserver-Logdateien-Verzeichnis';
$lng['serversettings']['logfiles_directory']['description'] = 'Wo sollen alle Logdateien des Webservers liegen?';
$lng['serversettings']['ipaddress']['title'] = 'IP-Adresse';
$lng['serversettings']['ipaddress']['description'] = 'Welche IP-Adresse hat der Server?';
$lng['serversettings']['hostname']['title'] = 'Hostname';
$lng['serversettings']['hostname']['description'] = 'Welchen Hostnamen hat der Server?';
$lng['serversettings']['apachereload_command']['title'] = 'Webserver-Reload-Command';
$lng['serversettings']['apachereload_command']['description'] = 'Wie heißt das Skript zum Neuladen der Webserver-Konfigurationsdateien?';
$lng['serversettings']['bindenable']['title'] = 'Nameserver aktivieren';
$lng['serversettings']['bindenable']['description'] = 'Hier können Sie den Nameserver global aktivieren bzw. deaktivieren.';
$lng['serversettings']['bindconf_directory']['title'] = 'Bind-Config-Directory';
$lng['serversettings']['bindconf_directory']['description'] = 'Wo liegen die Bind-Konfigurationsdateien?';
$lng['serversettings']['bindreload_command']['title'] = 'Bind-Reload-Command';
$lng['serversettings']['bindreload_command']['description'] = 'Wie heißt das Skript zum Neuladen der Bind-Konfigurationsdateien?';
$lng['serversettings']['binddefaultzone']['title'] = 'Bind-Default-Zone';
$lng['serversettings']['binddefaultzone']['description'] = 'Wie heißt die Default-Zone für alle Domains?';
$lng['serversettings']['vmail_uid']['title'] = 'Mails-Uid';
$lng['serversettings']['vmail_uid']['description'] = 'Welche UID sollen die E-Mails haben?';
$lng['serversettings']['vmail_gid']['title'] = 'Mails-Gid';
$lng['serversettings']['vmail_gid']['description'] = 'Welche GID sollen die E-Mails haben?';
$lng['serversettings']['vmail_homedir']['title'] = 'Mails-Homedir';
$lng['serversettings']['vmail_homedir']['description'] = 'Wo sollen die E-Mails liegen?';
$lng['serversettings']['adminmail']['title'] = 'Absenderadresse';
$lng['serversettings']['adminmail']['description'] = 'Wie ist die Absenderadresse für E-Mails aus dem Panel?';
$lng['serversettings']['phpmyadmin_url']['title'] = 'phpMyAdmin-URL';
$lng['serversettings']['phpmyadmin_url']['description'] = 'Wo liegt der phpMyAdmin? (muss mit http(s):// beginnen)';
$lng['serversettings']['webmail_url']['title'] = 'WebMail-URL';
$lng['serversettings']['webmail_url']['description'] = 'Wo liegt das WebMail? (muss mit http(s):// beginnen)';
$lng['serversettings']['webftp_url']['title'] = 'WebFTP-URL';
$lng['serversettings']['webftp_url']['description'] = 'Wo liegt das WebFTP? (muss mit http(s):// beginnen)';
$lng['serversettings']['language']['description'] = 'Welche Sprache ist Ihre Standardsprache?';
$lng['serversettings']['maxloginattempts']['title'] = 'Maximale Loginversuche';
$lng['serversettings']['maxloginattempts']['description'] = 'Maximale Anzahl an Loginversuchen bis der Account deaktiviert wird.';
$lng['serversettings']['deactivatetime']['title'] = 'Länge der Deaktivierung';
$lng['serversettings']['deactivatetime']['description'] = 'Zeitraum (in Sek.) für den der Account deaktiviert ist.';
$lng['serversettings']['pathedit']['title'] = 'Pfad-Eingabemethode';
$lng['serversettings']['pathedit']['description'] = 'Soll ein Pfad via Auswahlliste ausgewählt oder manuell eingegeben werden können.';
$lng['serversettings']['nameservers']['title'] = 'Nameserver';
$lng['serversettings']['nameservers']['description'] = 'Eine durch Komma getrennte Liste mit den Hostnamen aller Nameserver. Der erste ist der primäre.';
$lng['serversettings']['mxservers']['title'] = 'MX Server';
$lng['serversettings']['mxservers']['description'] = 'Eine durch Komma getrenne Liste die ein Paar mit einer Nummer und den Hostnamen einen MX Servers, getrennt durch ein Leerzeichen, enthaelt (z.B. \'10 mx.example.com\').';

/**
 * CHANGED BETWEEN 1.2.12 and 1.2.13
 */

$lng['mysql']['description'] = 'Hier können Sie MySQL-Datenbanken anlegen und löschen.<br />Die Änderungen werden sofort wirksam und die Datenbanken sofort benutzbar.<br />Im Menü finden Sie einen Link zum phpMyAdmin, mit dem Sie Ihre Datenbankeninhalte einfach bearbeiten können.<br /><br />Die Zugangsdaten von php-Skripten sind wie folgt: (Die Angaben in <i>kursiver</i> Schrift sind durch die jeweiligen Einträge zu ersetzen!)<br />Hostname: <b><SQL_HOST></b><br />Benutzername: <b><i>Datenbankname</i></b><br />Passwort: <b><i>das gewählte Passwort</i></b><br />Datenbank: <b><i>Datenbankname</i></b>';

/**
 * ADDED BETWEEN 1.2.12 and 1.2.13
 */

$lng['serversettings']['paging']['title'] = 'Einträge pro Seite';
$lng['serversettings']['paging']['description'] = 'Wieviele Einträge sollen auf einer Seite gezeigt werden? (0 = Paging deaktivieren)';
$lng['error']['ipstillhasdomains'] = 'Die IP/Port Kombination, die Sie löschen wollen ist noch bei einer oder mehreren Domains eingetragen. Bitte ändern sie die Domains vorher auf eine andere IP/Port Kombination um diese löschen zu können.';
$lng['error']['cantdeletedefaultip'] = 'Sie können die Standard IP/Port Kombination für Reseller nicht löschen. Bitte setzen Sie eine andere IP/Port Kombination als Standard um diese löschen zu können.';
$lng['error']['cantdeletesystemip'] = 'Sie können die letzte System IP nicht löschen. Entweder legen Sie eine neue IP/Port Kombination als Systemeinstellung an oder ändern die System IP.';
$lng['error']['myipaddress'] = '\'IP\'';
$lng['error']['myport'] = '\'Port\'';
$lng['error']['myipdefault'] = 'Sie müssen eine IP/Port Kombination auswählen, die den Standard defninieren soll.';
$lng['error']['myipnotdouble'] = 'Diese Kombination aus IP und Post existiert bereits.';
$lng['question']['admin_ip_reallydelete'] = 'Wollen Sie wirklich die IP %s löschen?';
$lng['admin']['ipsandports']['ipsandports'] = 'IPs und Ports';
$lng['admin']['ipsandports']['add'] = 'IP/Port hinzufügen';
$lng['admin']['ipsandports']['edit'] = 'IP/Port bearbeiten';
$lng['admin']['ipsandports']['ipandport'] = 'IP/Port';
$lng['admin']['ipsandports']['ip'] = 'IP';
$lng['admin']['ipsandports']['port'] = 'Port';

// ADDED IN 1.2.13-rc3

$lng['error']['cantchangesystemip'] = 'Sie können die letzte System IP nicht löschen. Entweder legen Sie noch eine neue IP/Port Kombination als Systemeinstellung an oder ändern die System IP.';
$lng['question']['admin_domain_reallydocrootoutofcustomerroot'] = 'Sind Sie sicher, dass der DocumentRoot dieser Domain außerhalb des Heimatverzeichnisses des Kunden liegen soll?';

// ADDED IN 1.2.14-rc1

$lng['admin']['memorylimitdisabled'] = 'Deaktiviert';
$lng['domain']['openbasedirpath'] = 'OpenBasedir-Pfad';
$lng['domain']['docroot'] = 'Oben eingegebener Pfad';
$lng['domain']['homedir'] = 'Heimverzeichnis';
$lng['admin']['valuemandatory'] = 'Dieses Feld muss ausgefüllt werden';
$lng['admin']['valuemandatorycompany'] = 'Entweder "Name" und "Vorname" oder "Firma" muss ausgefüllt werden';
$lng['menue']['main']['username'] = 'Angemeldet als: ';
$lng['panel']['urloverridespath'] = 'URL (überschreibt Pfad)';
$lng['panel']['pathorurl'] = 'Pfad oder URL';
$lng['error']['sessiontimeoutiswrong'] = '"Session-Timeout" muss ein numerischer Wert sein.';
$lng['error']['maxloginattemptsiswrong'] = '"Maximale Loginversuche" muss ein numerischer Wert sein.';
$lng['error']['deactivatetimiswrong'] = '"Länge der Deaktivierung" muss numerisch sein.';
$lng['error']['accountprefixiswrong'] = 'Das "Kundenprefix" ist falsch.';
$lng['error']['mysqlprefixiswrong'] = 'Das "SQL-Prefix" ist falsch.';
$lng['error']['ftpprefixiswrong'] = 'Das "FTP-Prefix" ist falsch.';
$lng['error']['ipiswrong'] = 'Die "IP-Adresse" ist falsch. Es ist nur eine gültige IP-Adresse erlaubt.';
$lng['error']['vmailuidiswrong'] = 'Die "Mails-UID" ist falsch. Nur eine numerische UID ist erlaubt.';
$lng['error']['vmailgidiswrong'] = 'Die "Mails-GID" ist falsch. Nur eine numerische GID ist erlaubt.';
$lng['error']['adminmailiswrong'] = 'Die "Absenderadresse" ist fehlerhaft. Es ist nur eine gültige E-Mail-Adresse erlaubt';
$lng['error']['pagingiswrong'] = 'Die "Einträge pro Seite"-Einstellung ist falsch. Nur numerische Zeichen sind erlaubt.';
$lng['error']['phpmyadminiswrong'] = 'Die "phpMyAdmin-URL" ist keine gültige URL.';
$lng['error']['webmailiswrong'] = 'Die "WebMail-URL" ist keine gültige URL.';
$lng['error']['webftpiswrong'] = 'Die "WebFTP-URL" ist keine gültige URL.';
$lng['domains']['hasaliasdomains'] = 'Hat Aliasdomain(s)';
$lng['serversettings']['defaultip']['title'] = 'Standard IP/Port';
$lng['serversettings']['defaultip']['description'] = 'Welche IP/Port-Kombination soll standardmäßig verwendet werden?';
$lng['domains']['statstics'] = 'Statistiken';
$lng['panel']['ascending'] = 'aufsteigend';
$lng['panel']['decending'] = 'absteigend';
$lng['panel']['search'] = 'Suche';
$lng['panel']['used'] = 'benutzt';

// ADDED IN 1.2.14-rc3

$lng['panel']['translator'] = 'Übersetzung';

// ADDED IN 1.2.14-rc4

$lng['error']['stringformaterror'] = 'Der Wert des Feldes "%s" ist nicht im erwarteten Format.';

// ADDED IN 1.2.15-rc1

$lng['admin']['serversoftware'] = 'Serversoftware';
$lng['admin']['phpversion'] = 'PHP-Version';
$lng['admin']['phpmemorylimit'] = 'PHP-Memory-Limit';
$lng['admin']['mysqlserverversion'] = 'MySQL Server Version';
$lng['admin']['mysqlclientversion'] = 'MySQL Client Version';
$lng['admin']['webserverinterface'] = 'Webserver Interface';
$lng['domains']['isassigneddomain'] = 'Ist zugewiesene Domain';
$lng['serversettings']['phpappendopenbasedir']['title'] = 'An OpenBasedir anzuhängende Pfade';
$lng['serversettings']['phpappendopenbasedir']['description'] = 'Diese (durch Doppelpunkte getrennten) Pfade werden dem OpenBasedir-Statement in jedem vHost-Container angehängt.';

// CHANGED IN 1.2.15-rc1

$lng['error']['loginnameissystemaccount'] = 'Sie können keinen Account anlegen, welcher wie ein Systemaccount aussieht (also zum Beispiel mit "%s" anfängt). Bitte wählen Sie einen anderen Accountnamen.';
$lng['error']['youcantdeleteyourself'] = 'Aus Sicherheitsgründen können Sie sich nicht selbst löschen.';
$lng['error']['youcanteditallfieldsofyourself'] = 'Hinweis: Aus Sicherheitsgründen können Sie nicht alle Felder Ihres eigenen Accounts bearbeiten.';

// ADDED IN 1.2.16-svn1

$lng['serversettings']['natsorting']['title'] = 'Natürliche Sortierung in der Listenansicht nutzen';
$lng['serversettings']['natsorting']['description'] = 'Sortiert die Liste in der Reihenfolge web1 -> web2 -> web11 anstatt web1 -> web11 -> web2.';

// ADDED IN 1.2.16-svn2

$lng['serversettings']['deactivateddocroot']['title'] = 'Docroot für deaktivierte Benutzer';
$lng['serversettings']['deactivateddocroot']['description'] = 'Dieser Pfad wird als docroot für deaktivierte Benutzer verwendet. Wenn leer, wird kein vHost erstellt.';

// ADDED IN 1.2.16-svn4

$lng['panel']['reset'] = 'Änderungen verwerfen';
$lng['admin']['accountsettings'] = 'Konteneinstellungen';
$lng['admin']['panelsettings'] = 'Paneleinstellungen';
$lng['admin']['systemsettings'] = 'Systemeinstellungen';
$lng['admin']['webserversettings'] = 'Webservereinstellungen';
$lng['admin']['mailserversettings'] = 'Mailservereinstellungen';
$lng['admin']['nameserversettings'] = 'Nameservereinstellungen';
$lng['admin']['updatecounters'] = 'Ressourcenverbrauch';
$lng['question']['admin_counters_reallyupdate'] = 'Wollen Sie den Ressourcenverbrauch neu berechnen?';
$lng['panel']['pathDescription'] = 'Wenn das Verzeichnis nicht existiert, wird es automatisch erstellt.';
$lng['panel']['pathDescriptionEx'] = '<br /><br />Sollte eine Weiterleitung auf eine andere Domain gewünscht sein, muss der Eintrag mit http:// oder https:// beginnen';

// ADDED IN 1.2.16-svn6

$lng['admin']['templates']['TRAFFIC'] = 'Wird mit Traffic, der dem Kunden zugewiesen wurde, ersetzt (in MB).';
$lng['admin']['templates']['TRAFFICUSED'] = 'Wird mit Traffic, der vom Kunden bereits verbraucht wurde, ersetzt (in MB).';

// ADDED IN 1.2.16-svn7

$lng['admin']['subcanemaildomain']['never'] = 'Nie';
$lng['admin']['subcanemaildomain']['choosableno'] = 'Wählbar, Standardwert: Nein';
$lng['admin']['subcanemaildomain']['choosableyes'] = 'Wählbar, Standardwert: Ja';
$lng['admin']['subcanemaildomain']['always'] = 'Immer';
$lng['changepassword']['also_change_webalizer'] = ' Auch Passwort der Statistikseite ändern';

// ADDED IN 1.2.16-svn8

$lng['serversettings']['mailpwcleartext']['title'] = 'Passwörter der Mail-Konten auch im Klartext in der Datenbank speichern';
$lng['serversettings']['mailpwcleartext']['description'] = 'Wenn diese Einstellung auf Ja gesetzt wird, werden alle Passwörter auch unverschlüsselt (also im Klartext, für jeden mit Zugriff auf die Froxlor-Datenbank sofort lesbar) in der mail_users-Tabelle gespeichert. Aktivieren Sie diese Option nur dann, wenn Sie SASL nutzen!';
$lng['serversettings']['mailpwcleartext']['removelink'] = 'Klicken Sie hier, um alle unverschlüsselten Passwörter aus der Tabelle zu entfernen.';
$lng['question']['admin_cleartextmailpws_reallywipe'] = 'Wollen Sie wirklich alle unverschlüsselten Passwörter aus der Tabelle mail_users entfernen? Dieser Schritt kann nicht rückgängig gemacht werden!';
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
$lng['serversettings']['ftpdomain']['description'] = 'Können Kunden FTP-Benutzerkonten user@customerdomain anlegen?';
$lng['panel']['back'] = 'Zurück';

// ADDED IN 1.2.16-svn12

$lng['serversettings']['mod_log_sql']['title'] = 'Logs in Datenbank zwischenspeichern';
$lng['serversettings']['mod_log_sql']['description'] = '<a target="blank" href="http://www.outoforder.cc/projects/apache/mod_log_sql/" title="mod_log_sql">mod_log_sql</a> benutzen um die Webzugriffe temporär zu speichern<br /><b>Dies benötigt eine spezielle Apache-Konfiguration</b>';
$lng['serversettings']['mod_fcgid']['title'] = 'PHP über mod_fcgid/suexec einbinden';
$lng['serversettings']['mod_fcgid']['description'] = 'PHP unter dem jeweiligen Useraccount laufen lassen.<br /><br /><b>Dies benötigt eine spezielle Webserver-Konfiguration für Apache, siehe <a target="blank" href="http://redmine.froxlor.org/projects/froxlor/wiki/FCGID_-_Handbuch">FCGID-Handbuch</a>.</b>';
$lng['serversettings']['sendalternativemail']['title'] = 'Alternative E-Mail-Adresse benutzen';
$lng['serversettings']['sendalternativemail']['description'] = 'Während des Erstellens eines Accounts das Passwort an eine andere E-Mail-Adresse senden';
$lng['emails']['alternative_emailaddress'] = 'Alternative E-Mail-Adresse';
$lng['mails']['pop_success_alternative']['mailbody'] = 'Hallo,\n\nihr E-Mail-Konto {USERNAME}\nwurde erfolgreich eingerichtet.\nIhr Passwort lautet {PASSWORD}.\n\nDies ist eine automatisch generierte\neMail, bitte antworten Sie nicht auf\ndiese Mitteilung.\n\nIhr Administrator';
$lng['mails']['pop_success_alternative']['subject'] = 'E-Mail-Konto erfolgreich eingerichtet';
$lng['admin']['templates']['pop_success_alternative'] = 'Willkommensmail für neue E-Mail Konten für die alternative Email Addresse';
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
$lng['serversettings']['mysql_access_host']['description'] = 'Eine durch Komma getrennte Liste mit den Hostnamen aller Hostnames/IP-Adressen, von denen sich die Benutzer einloggen dürfen.';

// CHANGED IN 1.2.18

$lng['serversettings']['mod_log_sql']['description'] = '<a target="blank" href="http://www.outoforder.cc/projects/apache/mod_log_sql/" title="mod_log_sql">mod_log_sql</a> benutzen um die Webzugriffe temporär zu speichern<br /><b>Dies benötigt eine spezielle <a target="blank" href="http://files.froxlor.org/docs/mod_log_sql/" title="mod_log_sql - Dokumentation">Apache-Konfiguration</a></b>';

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

// ADDED IN 1.2.18-svn3

$lng['ticket']['admin_email'] = 'root@localhost';
$lng['ticket']['noreply_email'] = 'tickets@froxlor';
$lng['admin']['ticketsystem'] = 'Support-Tickets';
$lng['menue']['ticket']['ticket'] = 'Support Tickets';
$lng['menue']['ticket']['categories'] = 'Support Kategorien';
$lng['menue']['ticket']['archive'] = 'Ticket-Archiv';
$lng['ticket']['description'] = 'Hier können Sie Hilfe-Anfragen an Ihren zuständigen Administrator senden.<br />Benachrichtigungen werden per E-Mail verschickt.';
$lng['ticket']['ticket_new'] = 'Neues Support-Ticket erstellen';
$lng['ticket']['ticket_reply'] = 'Auf Support-Ticket antworten';
$lng['ticket']['ticket_reopen'] = 'Ticket wiedereröffnen';
$lng['ticket']['ticket_newcateory'] = 'Neue Kategorie erstellen';
$lng['ticket']['ticket_editcateory'] = 'Kategorie bearbeiten';
$lng['ticket']['ticket_view'] = 'Ticketverlauf ansehen';
$lng['ticket']['ticketcount'] = 'Anzahl Tickets';
$lng['ticket']['ticket_answers'] = 'Antworten';
$lng['ticket']['lastchange'] = 'Letzte Aktualisierung';
$lng['ticket']['subject'] = 'Betreff';
$lng['ticket']['status'] = 'Status';
$lng['ticket']['lastreplier'] = 'Letzte Antwort';
$lng['ticket']['priority'] = 'Priorität';
$lng['ticket']['low'] = 'Niedrig';
$lng['ticket']['normal'] = 'Normal';
$lng['ticket']['high'] = 'Hoch';
$lng['ticket']['lastchange'] = 'Letzte Änderung';
$lng['ticket']['lastchange_from'] = 'Anfangsdatum (tt.mm.jjjj)';
$lng['ticket']['lastchange_to'] = 'Enddatum (tt.mm.jjjj)';
$lng['ticket']['category'] = 'Kategorie';
$lng['ticket']['no_cat'] = 'Keine';
$lng['ticket']['message'] = 'Nachricht';
$lng['ticket']['show'] = 'Anschauen';
$lng['ticket']['answer'] = 'Antworten';
$lng['ticket']['close'] = 'Schließen';
$lng['ticket']['reopen'] = 'Wiedereröffnen';
$lng['ticket']['archive'] = 'Archivieren';
$lng['ticket']['ticket_delete'] = 'Ticket löschen';
$lng['ticket']['lastarchived'] = 'Zuletzt archivierte Tickets';
$lng['ticket']['archivedtime'] = 'Archiviert';
$lng['ticket']['open'] = 'Offen';
$lng['ticket']['wait_reply'] = 'Warte auf Antwort';
$lng['ticket']['replied'] = 'Beantwortet';
$lng['ticket']['closed'] = 'Geschlossen';
$lng['ticket']['staff'] = 'Mitarbeiter';
$lng['ticket']['customer'] = 'Kunde';
$lng['ticket']['old_tickets'] = 'Bisheriger Ticketverlauf';
$lng['ticket']['search'] = 'Archiv durchsuchen';
$lng['ticket']['nocustomer'] = 'Keine Angabe';
$lng['ticket']['archivesearch'] = 'Archiv Suchergebnis';
$lng['ticket']['noresults'] = 'Keine Tickets gefunden';
$lng['ticket']['notmorethanxopentickets'] = 'Zum Schutz gegen Spam können Sie nicht mehr als %s offene Tickets haben';
$lng['ticket']['supportstatus'] = 'Support-Status';
$lng['ticket']['supportavailable'] = '<span class="ticket_low">Der Support ist besetzt und steht zu Ihrer Verfügung.</span>';
$lng['ticket']['supportnotavailable'] = '<span class="ticket_high">Der Support ist zur Zeit nicht besetzt.</span>';
$lng['admin']['templates']['ticket'] = 'Benachrichtigungs-Mails für Support-Tickets';
$lng['admin']['templates']['SUBJECT'] = 'Wird mit dem Betreff des Support-Tickets ersetzt';
$lng['admin']['templates']['new_ticket_for_customer'] = 'Kunden-Information das das Ticket übermittelt wurde';
$lng['admin']['templates']['new_ticket_by_customer'] = 'Admin-Benachrichtigung für ein Ticket eines Kunden';
$lng['admin']['templates']['new_reply_ticket_by_customer'] = 'Admin-Benachrichtigung für ein beantwortetes Ticket';
$lng['admin']['templates']['new_ticket_by_staff'] = 'Kunden-Benachrichtigung für ein Ticket eines Mitarbeiters';
$lng['admin']['templates']['new_reply_ticket_by_staff'] = 'Kunden-Benachrichtigung für ein beantwortetes Ticket';
$lng['mails']['new_ticket_for_customer']['mailbody'] = 'Hallo {FIRSTNAME} {NAME},\n\nihr Support-Ticket mit dem Betreff "{SUBJECT}" wurde erfolgreich gesendet.\n\nSobald ihr Ticket beantwortet wurde, werden Sie per E-Mail benachrichtigt.\n\nVielen Dank,\nIhr Administrator';
$lng['mails']['new_ticket_for_customer']['subject'] = 'Wir haben Ihr Support-Ticket erhalten.';
$lng['mails']['new_ticket_by_customer']['mailbody'] = 'Hallo Admin,\n\nein neues Support-Ticket wurde uebermittelt.\n\nBitte melde Dich an um es aufzurufen.\n\nVielen Dank,\nIhr Administrator';
$lng['mails']['new_ticket_by_customer']['subject'] = 'Neues Support-Ticket';
$lng['mails']['new_reply_ticket_by_customer']['mailbody'] = 'Hallo Admin,\n\ndas Support-Ticket "{SUBJECT}" wurde von einem Kunden beantwortet.\n\nBitte melde Dich an um es aufzurufen.\n\nVielen Dank,\nIhr Administrator';
$lng['mails']['new_reply_ticket_by_customer']['subject'] = 'Neue Antwort zu einem Support-Ticket';
$lng['mails']['new_ticket_by_staff']['mailbody'] = 'Hallo {FIRSTNAME} {NAME},\n\nein Support-Ticket mit dem Betreff "{SUBJECT}" wurde an Sie übermittelt.\n\nBitte melden Sie sich an, um das Ticket aufzurufen.\n\nVielen Dank,\nIhr Administrator';
$lng['mails']['new_ticket_by_staff']['subject'] = 'Neues Support-Ticket';
$lng['mails']['new_reply_ticket_by_staff']['mailbody'] = 'Hallo {FIRSTNAME} {NAME},\n\ndas Support-Ticket mit dem Betreff "{SUBJECT}" wurde von einem Mitarbeiter beantwortet.\n\nBitte melden Sie sich an, um das Ticket aufzurufen.\n\nVielen Dank,\nIhr Administrator';
$lng['mails']['new_reply_ticket_by_staff']['subject'] = 'Neue Antwort zu einem Support-Ticket';
$lng['question']['ticket_reallyclose'] = 'Wollen Sie das Ticket "%s" wirklich schließen?';
$lng['question']['ticket_reallydelete'] = 'Wollen Sie das Ticket "%s" wirklich löschen?';
$lng['question']['ticket_reallydeletecat'] = 'Wollen Sie die Kategorie "%s" wirklich löschen?';
$lng['question']['ticket_reallyarchive'] = 'Wollen Sie das Ticket "%s" wirklich in das Archiv verschieben?';
$lng['error']['mysubject'] = '\'' . $lng['ticket']['subject'] . '\'';
$lng['error']['mymessage'] = '\'' . $lng['ticket']['message'] . '\'';
$lng['error']['mycategory'] = '\'' . $lng['ticket']['category'] . '\'';
$lng['error']['nomoreticketsavailable'] = 'Sie haben Ihr Ticketkontingent aufgebraucht. Bitte kontaktieren Sie ihren Administrator.';
$lng['error']['nocustomerforticket'] = 'Keine Kunden vorhanden um ein Ticket zu erstellen.';
$lng['error']['categoryhastickets'] = 'In dieser Kategorie befinden sich noch Tickets.<br />Bitte löschen Sie diese um die Kategorie zu löschen';
$lng['error']['notmorethanxopentickets'] = $lng['ticket']['notmorethanxopentickets'];
$lng['admin']['ticketsettings'] = 'Support-Ticket Einstellungen';
$lng['admin']['archivelastrun'] = 'Letzte Ticket-Archivierung';
$lng['serversettings']['ticket']['noreply_email']['title'] = 'Keine-Antwort E-Mail Adresse';
$lng['serversettings']['ticket']['noreply_email']['description'] = 'Die Absender-Adresse der Support-Tickets. Meist sowas wie KEINE-ANTWORT@domain.tld';
$lng['serversettings']['ticket']['worktime_begin']['title'] = 'Beginn Support-Zeit (hh:mm)';
$lng['serversettings']['ticket']['worktime_begin']['description'] = 'Beginn der Zeit in der der Support besetzt ist.';
$lng['serversettings']['ticket']['worktime_end']['title'] = 'Ende Support-Zeit (hh:mm)';
$lng['serversettings']['ticket']['worktime_end']['description'] = 'Ende der Zeit in der der Support besetzt ist.';
$lng['serversettings']['ticket']['worktime_sat'] = 'Support an Samstagen besetzt?';
$lng['serversettings']['ticket']['worktime_sun'] = 'Support an Sonntagen besetzt?';
$lng['serversettings']['ticket']['worktime_all']['title'] = 'Kein zeitlich begrenzter Support';
$lng['serversettings']['ticket']['worktime_all']['description'] = 'Wenn "Ja" überschreibt diese Option Start- und Endzeit des Supports';
$lng['serversettings']['ticket']['archiving_days'] = 'Nach wievielen Tagen sollen abgeschlossene Tickets archiviert werden?';
$lng['customer']['tickets'] = 'Support-Tickets';

// ADDED IN 1.2.18-svn4

$lng['admin']['domain_nocustomeraddingavailable'] = 'Es können derzeit keine Domains angelegt werden. Sie müssen zuerst einen Kunden anlegen';
$lng['serversettings']['ticket']['enable'] = 'Ticketsystem aktivieren';
$lng['serversettings']['ticket']['concurrentlyopen'] = 'Wieviele Tickets kann ein Kunde gleichzeitig öffnen?';
$lng['error']['norepymailiswrong'] = 'Die "Keine-Antwort-Adresse" ist fehlerhaft. Es ist nur eine gültige E-Mail-Adresse erlaubt';
$lng['error']['tadminmailiswrong'] = 'Die "Ticket-Admin-Adresse" ist fehlerhaft. Es ist nur eine gültige E-Mail-Adresse erlaubt';
$lng['ticket']['awaitingticketreply'] = 'Sie haben %s unbeantwortete(s) Support-Ticket(s)';

// ADDED IN 1.2.18-svn5

$lng['serversettings']['ticket']['noreply_name'] = 'Ticket E-Mail Absendername';

// ADDED IN 1.2.19-svn

$lng['serversettings']['mod_fcgid']['configdir']['title'] = 'Konfigurations-Verzeichnis';
$lng['serversettings']['mod_fcgid']['configdir']['description'] = 'Wo sollen alle Konfigurationsdateien von fcgid liegen? Wenn Sie keine selbst kompilierte suexec Binary benutzen, was in der Regel der Fall ist, muss dieser Pfad unter /var/www/ liegen.<br /><br /><div style="color:red">ACHTUNG: Der Inhalt dieses Ordners wird regelmäßig geleert, daher sollten dort keinerlei Daten manuell abgelegt werden.</div>';
$lng['serversettings']['mod_fcgid']['tmpdir']['title'] = 'Temporäres Verzeichnis';

// ADDED IN 1.2.19-svn3

$lng['serversettings']['ticket']['reset_cycle']['title'] = 'Turnus verbrauchte Tickets zurücksetzen';
$lng['serversettings']['ticket']['reset_cycle']['description'] = 'Setzt die Anzahl der vom Kunden verbrauchten Tickets in dem angegebenen Turnus auf 0';
$lng['admin']['tickets']['daily'] = 'Täglich';
$lng['admin']['tickets']['weekly'] = 'Wöchentlich';
$lng['admin']['tickets']['monthly'] = 'Monatlich';
$lng['admin']['tickets']['yearly'] = 'Jährlich';
$lng['error']['ticketresetcycleiswrong'] = 'Der Turnus des Ticket-Zurücksetzen muss "Täglich", "Wöchentlich", "Monatlich" oder "Jährlich" sein.';

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
$lng['traffic']['mb'] = "Traffic (MB)";
$lng['traffic']['day'] = "Tag";
$lng['traffic']['distribution'] = '<font color="#019522">FTP</font> | <font color="#0000FF">HTTP</font> | <font color="#800000">Mail</font>';
$lng['traffic']['sumhttp'] = 'Summe HTTP-Traffic in';
$lng['traffic']['sumftp'] = 'Summe FTP-Traffic in';
$lng['traffic']['summail'] = 'Summe Mail-Traffic in';

// ADDED IN 1.2.19-svn4.5

$lng['serversettings']['no_robots']['title'] = 'Erlaube die Indizierung Ihres Froxlor durch Suchmaschinen';

// ADDED IN 1.2.19-svn6

$lng['admin']['loggersettings'] = 'Log Einstellungen';
$lng['serversettings']['logger']['enable'] = 'Logging ja/nein';
$lng['serversettings']['logger']['severity'] = 'Logging Level';
$lng['admin']['logger']['normal'] = 'Normal';
$lng['admin']['logger']['paranoid'] = 'Paranoid';
$lng['serversettings']['logger']['types']['title'] = 'Log-Art(en)';
$lng['serversettings']['logger']['types']['description'] = 'Wählen Sie hier die gewünschten Logtypen. Für Mehrfachauswahl, halten Sie während der Auswahl STRG gedrückt<br />Mögliche Logtypen sind: syslog, file, mysql';
$lng['serversettings']['logger']['logfile'] = 'Log-Datei Pfad inklusive Dateinamen';
$lng['error']['logerror'] = 'Log-Fehler: %s';
$lng['serversettings']['logger']['logcron'] = 'Log Cronjobs (einen Durchgang)';
$lng['question']['logger_reallytruncate'] = 'Wollen Sie die Tabelle "%s" wirklich leeren?';
$lng['admin']['loggersystem'] = 'System-Logging';
$lng['menue']['logger']['logger'] = 'System-Logging';
$lng['logger']['date'] = 'Datum';
$lng['logger']['type'] = 'Typ';
$lng['logger']['action'] = 'Aktion';
$lng['logger']['user'] = 'Benutzer';
$lng['logger']['truncate'] = 'Log leeren';

// ADDED IN 1.2.19-svn7

$lng['serversettings']['ssl']['use_ssl'] = 'SSL nutzen';
$lng['serversettings']['ssl']['ssl_cert_file'] = 'Pfad zum Zertifikat';
$lng['serversettings']['ssl']['openssl_cnf'] = 'Standardwerte zum Erstellen eines Zertifikats';
$lng['panel']['reseller'] = 'Reseller';
$lng['panel']['admin'] = 'Administrator';
$lng['panel']['customer'] = 'Kunde/n';
$lng['error']['nomessagetosend'] = 'Keine Nachricht angegeben';
$lng['error']['noreceipientsgiven'] = 'Keine Empfänger angegeben';
$lng['admin']['emaildomain'] = 'E-Maildomain';
$lng['admin']['email_only'] = 'Nur E-Mail?';
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
$lng['message']['success'] = 'Nachricht erfolgreich an %s Empfänger gesendet';
$lng['message']['noreceipients'] = 'Es wurde keine E-Mail versendet da sich keine Empfänger in der Datenbank befinden';
$lng['admin']['sslsettings'] = 'SSL Einstellungen';
$lng['cronjobs']['notyetrun'] = 'Bisher nicht gestartet';
$lng['serversettings']['default_vhostconf']['title'] = 'Standard Vhost-Einstellungen';
$lng['serversettings']['default_vhostconf']['description'] = 'Der Inhalt dieses Feldes wird direkt in jeden Domain-vHost-Container übernommen. Achtung: Der Code wird nicht auf Fehler geprüft. Etwaige Fehler werden also auch übernommen. Der Webserver könnte nicht mehr starten!';
$lng['error']['invalidip'] = 'Ungültige IP Adresse: %s';
$lng['serversettings']['decimal_places'] = 'Nachkommastellen bei der Ausgabe von Traffic/Webspace';

// ADDED IN 1.2.19-svn8

$lng['admin']['dkimsettings'] = 'DomainKey - Einstellungen';
$lng['dkim']['dkim_prefix']['title'] = 'Prefix';
$lng['dkim']['dkim_prefix']['description'] = 'Wie lautet der Pfad zu den DKIM RSA-Dateien sowie den Einstellungsdateien des Milter-Plugins?';
$lng['dkim']['dkim_domains']['title'] = 'Domains Dateiname';
$lng['dkim']['dkim_domains']['description'] = '<em>Dateiname</em> der DKIM Domains Angabe aus der dkim-milter-Konfigurationsdatei';
$lng['dkim']['dkim_dkimkeys']['title'] = 'KeyList Dateiname';
$lng['dkim']['dkim_dkimkeys']['description'] = '<em>Dateiname</em> der DKIM KeyList Angabe aus der dkim-milter-Konfigurationsdatei';
$lng['dkim']['dkimrestart_command']['title'] = 'Milter Restart Kommando';
$lng['dkim']['dkimrestart_command']['description'] = 'Wie lautet das Kommando zum Neustarten des DKIM Milter Dienstes?';

// ADDED IN 1.2.19-svn9

$lng['admin']['caneditphpsettings'] = 'Kann PHP-bezogene Domaineinstellungen machen?';

// ADDED IN 1.2.19-svn12

$lng['admin']['allips'] = 'Alle IP\'s';
$lng['panel']['nosslipsavailable'] = 'Für diesen Server wurden noch keine SSL IP/Port Kombinationen eingetragen';
$lng['ticket']['by'] = 'von';
$lng['dkim']['use_dkim']['title'] = 'DKIM Support aktivieren?';
$lng['dkim']['use_dkim']['description'] = 'Wollen Sie das Domain Keys (DKIM) System benutzen?';
$lng['error']['invalidmysqlhost'] = 'Ungültige MySQL Host Adresse: %s';
$lng['error']['cannotuseawstatsandwebalizeratonetime'] = 'Webalizer und AWstats können nicht zur gleichen Zeit aktiviert werden, bitte wählen Sie eines aus';
$lng['serversettings']['webalizer_enabled'] = 'Nutze Webalizer Statistiken';
$lng['serversettings']['awstats_enabled'] = 'Nutze AWStats Statistiken';
$lng['admin']['awstatssettings'] = 'AWstats Einstellungen';

// ADDED IN 1.2.19-svn16

$lng['admin']['domain_dns_settings'] = 'Domain DNS Einstellungen';
$lng['dns']['destinationip'] = 'Domain IP';
$lng['dns']['standardip'] = 'Server Standard IP';
$lng['dns']['a_record'] = 'A-Eintrag (IPv6 optional)';
$lng['dns']['cname_record'] = 'CNAME-Eintrag';
$lng['dns']['mxrecords'] = 'MX Einträge definieren';
$lng['dns']['standardmx'] = 'Server Standard MX Eintrag';
$lng['dns']['mxconfig'] = 'Eigene MX Einträge';
$lng['dns']['priority10'] = 'Priorität 10';
$lng['dns']['priority20'] = 'Priorität 20';
$lng['dns']['txtrecords'] = 'TXT Einträge definieren';
$lng['dns']['txtexample'] = 'Beispiel (SPF-Eintrag):<br />v=spf1 ip4:xxx.xxx.xx.0/23 -all';
$lng['serversettings']['selfdns']['title'] = 'Manuelle DNS Einstellungen für Domains';
$lng['serversettings']['selfdnscustomer']['title'] = 'Erlaube Kunden eigene DNS Einstellungen vornehmen zu können';
$lng['admin']['activated'] = 'Aktiviert';
$lng['admin']['statisticsettings'] = 'Statistik Einstellungen';
$lng['admin']['or'] = 'oder';

// ADDED IN 1.2.19-svn17

$lng['serversettings']['unix_names']['title'] = 'Benutze UNIX kompatible Benutzernamen';
$lng['serversettings']['unix_names']['description'] = 'Erlaubt die Nutzung von <strong>-</strong> und <strong>_</strong> in Benutzernamen wenn <strong>Nein</strong>';
$lng['error']['cannotwritetologfile'] = 'Logdatei %s konnte nicht für Schreiboperationen geöffnet werden.';
$lng['admin']['sysload'] = 'System-Auslastung';
$lng['admin']['noloadavailable'] = 'nicht verfügbar';
$lng['admin']['nouptimeavailable'] = 'nicht verfügbar';
$lng['panel']['backtooverview'] = 'Zurück zur Übersicht';
$lng['admin']['nosubject'] = '(Kein Betreff)';
$lng['admin']['configfiles']['statistics'] = 'Statistik';
$lng['login']['forgotpwd'] = 'Passwort vergessen?';
$lng['login']['presend'] = 'Passwort zurücksetzen';
$lng['login']['email'] = 'E-Mail Adresse';
$lng['login']['remind'] = 'Passwort zurücksetzen';
$lng['login']['usernotfound'] = 'Fehler: Unbekannter Benutzer!';
$lng['pwdreminder']['subject'] = 'Froxlor - Passwort zurückgesetzt';
$lng['pwdreminder']['body'] = 'Hallo %s,\n\nIhr Froxlor Passwort wurde zurückgesetzt!\nDas neue Passwort lautet: %p\n\nVielen Dank,\nIhr Administrator';
$lng['pwdreminder']['success'] = 'Passwort erfolgreich zurückgesetzt.<br />Sie sollten nun eine E-Mail mit dem neuen Passwort erhalten.';

// ADDED IN 1.2.19-svn18

$lng['serversettings']['allow_password_reset']['title'] = 'Erlaube das Zurücksetzen des Kundenpassworts';
$lng['pwdreminder']['notallowed'] = 'Das Zurücksetzen des Passworts ist deaktiviert';

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
$lng['domains']['registration_date'] = 'Bei Registry hinzugefügt';
$lng['domains']['topleveldomain'] = 'Top-Level-Domain';

// ADDED IN 1.2.19-svn22

$lng['serversettings']['allow_password_reset']['description'] = 'Kunden können ihr Passwort zurücksetzen und bekommen ein Neues per E-Mail zugesandt';
$lng['serversettings']['allow_password_reset_admin']['title'] = 'Erlaube das Zurücksetzen von Admin-/Reseller-Passwörtern.';
$lng['serversettings']['allow_password_reset_admin']['description'] = 'Admins/Reseller können ihr Passwort zurücksetzen und bekommen ein Neues per E-Mail zugesandt';

// ADDED IN 1.2.19-svn25
// Mailquota

$lng['emails']['quota'] = 'Kontingent';
$lng['emails']['noquota'] = 'Kein Kontingent';
$lng['emails']['updatequota'] = 'Update Kontingent';
$lng['serversettings']['mail_quota']['title'] = 'Mailbox-Kontingent';
$lng['serversettings']['mail_quota']['description'] = 'Standard-Kontingent für neuerstellte E-Mail Benutzerkonten (MegaByte)';
$lng['serversettings']['mail_quota_enabled']['title'] = 'Nutze E-Mail Kontingent für Kunden';
$lng['serversettings']['mail_quota_enabled']['description'] = 'Aktiviere Kontingent für E-Mailkonten. Standard ist <b>Nein</b> da dies eine spezielle Konfiguration voraussetzt.';
$lng['serversettings']['mail_quota_enabled']['removelink'] = 'Hier klicken, um alle E-Mail Kontingente zu entfernen';
$lng['serversettings']['mail_quota_enabled']['enforcelink'] = 'Hier klicken, um allen Benutzern das Standard Kontingent zu zuweisen';
$lng['question']['admin_quotas_reallywipe'] = 'Sind Sie sicher, dass alle E-Mail Kontingente aus der Tabelle mail_users entfernt werden sollen? Dieser Schritt kann nicht rückgängig gemacht werden!';
$lng['question']['admin_quotas_reallyenforce'] = 'Sind Sie sicher, dass sie allen Benutzern das default Quota zuweisen wollen? Dies kann nicht rückgängig gemacht werden!';
$lng['error']['vmailquotawrong'] = 'Die Kontingent-Größe muss positiv sein.';
$lng['customer']['email_quota'] = 'E-Mail Kontingent';
$lng['customer']['email_imap'] = 'E-Mail IMAP';
$lng['customer']['email_pop3'] = 'E-Mail POP3';
$lng['customer']['mail_quota'] = 'E-Mail Kontingent';
$lng['panel']['megabyte'] = 'MegaByte';
$lng['emails']['quota_edit'] = 'E-Mail Kontingent ändern';
$lng['panel']['not_supported'] = 'Nicht unterstüzt in: ';
$lng['error']['allocatetoomuchquota'] = 'Sie versuchen %s MB ' . $lng['emails']['quota'] . ' zu zuweisen, haben aber nicht genug übrig.';

// Autoresponder module

$lng['menue']['email']['autoresponder'] = 'Abwesenheitsnachrichten';
$lng['autoresponder']['active'] = 'Aktiviert';
$lng['autoresponder']['autoresponder_add'] = 'Abwesenheitsnachricht hinzufügen';
$lng['autoresponder']['autoresponder_edit'] = 'Abwesenheitsnachricht bearbeiten';
$lng['autoresponder']['autoresponder_new'] = 'Neue Abwesenheitsnachricht erstellen';
$lng['autoresponder']['subject'] = 'Betreff';
$lng['autoresponder']['message'] = 'Nachricht';
$lng['autoresponder']['account'] = 'Konto';
$lng['autoresponder']['sender'] = 'Absender';
$lng['question']['autoresponderdelete'] = 'Abwesenheitsnachricht wirklich löschen?';
$lng['error']['noemailaccount'] = 'Es gibt zwei mögliche Gründe warum keine Abwesenheitsnachricht erstellt werden kann: Sie benötigen mindestens einen E-Mail Account. Zweitens kann es sein dass bereits für alle Accounts eine Abwesenheitsnachricht eingerichtet wurde.';
$lng['error']['missingfields'] = 'Es wurden nicht alle Felder augefüllt.';
$lng['error']['accountnotexisting'] = 'Der angegebene E-Mail-Account existiert nicht.';
$lng['error']['autoresponderalreadyexists'] = 'Für dieses Konto existiert bereits eine Abwesenheitsnachricht.';
$lng['error']['invalidautoresponder'] = 'Das angegebene Konto ist ungültig.';
$lng['serversettings']['autoresponder_active']['title'] = 'Abwesenheitsnachrichten-Modul verwenden';
$lng['serversettings']['autoresponder_active']['description'] = 'Möchten Sie das Abwesenheitsnachrichten-Modul verwenden?';
$lng['admin']['show_version_login']['title'] = 'Zeige Froxlor Version beim Login';
$lng['admin']['show_version_login']['description'] = 'Zeige Froxlor Version in der Fußzeile der Loginseite';
$lng['admin']['show_version_footer']['title'] = 'Zeige Froxlor Version in Fußzeile';
$lng['admin']['show_version_footer']['description'] = 'Zeige Froxlor Version in der Fußzeile aller anderen Seiten';
$lng['admin']['froxlor_graphic']['title'] = 'Grafik im Kopfbereich des Panels';
$lng['admin']['froxlor_graphic']['description'] = 'Welche Grafik soll im Kopfbereich des Panels anstatt des Froxlor Logos angezeigt werden?';

//improved froxlor

$lng['menue']['phpsettings']['maintitle'] = 'PHP Konfigurationen';
$lng['admin']['phpsettings']['title'] = 'PHP Konfiguration';
$lng['admin']['phpsettings']['description'] = 'Kurzbeschreibung';
$lng['admin']['phpsettings']['actions'] = 'Aktionen';
$lng['admin']['phpsettings']['activedomains'] = 'In Verwendung für Domain(s)';
$lng['admin']['phpsettings']['notused'] = 'Konfiguration wird nicht verwendet';
$lng['admin']['misc'] = 'Sonstiges';
$lng['admin']['phpsettings']['editsettings'] = 'PHP Konfiguration bearbeiten';
$lng['admin']['phpsettings']['addsettings'] = 'PHP Konfiguration erstellen';
$lng['admin']['phpsettings']['viewsettings'] = 'PHP Konfiguration ansehen';
$lng['admin']['phpsettings']['phpinisettings'] = 'php.ini Einstellungen';
$lng['error']['nopermissionsorinvalidid'] = 'Entweder fehlen Ihnen die nötigen Rechte diese Einstellung zu ändern oder es wurde eine ungültige Id übergeben';
$lng['panel']['view'] = 'ansehen';
$lng['question']['phpsetting_reallydelete'] = 'Wollen Sie diese PHP Einstellungen wirklich löschen? Alle Domains die diese Einstellungen bis jetzt verwendet haben, werden dann auf die Standard Einstellungen umgestellt.';
$lng['admin']['phpsettings']['addnew'] = 'Neue Konfiguration erstellen';
$lng['error']['phpsettingidwrong'] = 'Eine PHP Konfiguration mit dieser Id existiert nicht';
$lng['error']['descriptioninvalid'] = 'Der Beschreibungstext ist zu kurz, zu lang oder enthält ungültige Zeichen';
$lng['error']['info'] = 'Info';
$lng['admin']['phpconfig']['template_replace_vars'] = 'Variablen, die in den Konfigurationen ersetzt werden';
$lng['admin']['phpconfig']['safe_mode'] = 'Wird mit der safe_mode Einstellung der Domain ersetzt.';
$lng['admin']['phpconfig']['pear_dir'] = 'Wird mit dem globalen Wert für das Include Verzeichnis ersetzt.';
$lng['admin']['phpconfig']['open_basedir_c'] = 'Wird mit einem ; (Semikolon) ersetzt, um open_basedir auszukommentieren/deaktivieren, wenn eingestellt.';
$lng['admin']['phpconfig']['open_basedir'] = 'Wird mit der open_basedir Einstellung der Domain ersetzt.';
$lng['admin']['phpconfig']['tmp_dir'] = 'Wird mit der Einstellung für das temporäre Verzeichnis der Domain ersetzt.';
$lng['admin']['phpconfig']['open_basedir_global'] = 'Wird mit der globalen Einstellung des Pfades ersetzt, der dem open_basedir hinzugefügt wird.';
$lng['admin']['phpconfig']['customer_email'] = 'Wird mit der E-Mail Adresse des Kunden ersetzt, dem die Domain gehört.';
$lng['admin']['phpconfig']['admin_email'] = 'Wird mit der E-Mail Adresse des Admins ersetzt, dem die Domain gehört.';
$lng['admin']['phpconfig']['domain'] = 'Wird mit der Domain ersetzt.';
$lng['admin']['phpconfig']['customer'] = 'Wird mit dem Loginnamen des Kunden ersetzt, dem die Domain gehört.';
$lng['admin']['phpconfig']['admin'] = 'Wird mit dem Loginnamen des Admins ersetzt, dem die Domain gehört.';
$lng['login']['backtologin'] = 'Zurück zum Login';
$lng['serversettings']['mod_fcgid']['starter']['title'] = 'Prozesse je Domain';
$lng['serversettings']['mod_fcgid']['starter']['description'] = 'Wieviele PHP Prozesse pro Domain sollen gestartet/erlaubt werden. Der Wert 0 wird empfohlen, da PHP dann selbst die Anzahl effizient verwaltet.';
$lng['serversettings']['mod_fcgid']['wrapper']['title'] = 'Wrappereinbindung in Vhosts';
$lng['serversettings']['mod_fcgid']['wrapper']['description'] = 'Wie sollen die Wrapper in den Vhosts eingebunden werden';
$lng['serversettings']['mod_fcgid']['tmpdir']['description'] = 'Wo sollen die temporären Verzeichnisse erstellt werden';
$lng['admin']['know_what_youre_doing'] = 'Ändern Sie diese Einstellungen nur, wenn Sie wissen was Sie tun!';
$lng['serversettings']['mod_fcgid']['peardir']['title'] = 'Globale PEAR Verzeichnisse';
$lng['serversettings']['mod_fcgid']['peardir']['description'] = 'Welche globalen PEAR Verzeichnisse sollen in den php.ini Einstellungen ersetzt werden? Einzelne Verzeichnisse sind mit einem Doppelpunkt zu trennen.';

//improved Froxlor 2

$lng['admin']['templates']['index_html'] = 'index.html Datei für neu erzeugte Kundenverzeichnisse';
$lng['admin']['templates']['SERVERNAME'] = 'Wird mit dem Servernamen ersetzt.';
$lng['admin']['templates']['CUSTOMER'] = 'Wird mit dem Loginnamen des Kunden ersetzt.';
$lng['admin']['templates']['ADMIN'] = 'Wird mit dem Loginnamen des Admins ersetzt.';
$lng['admin']['templates']['CUSTOMER_EMAIL'] = 'Wird mit der E-Mail Adresse des Kunden ersetzt.';
$lng['admin']['templates']['ADMIN_EMAIL'] = 'Wird mit der E-Mail Adresse des Admin ersetzt.';
$lng['admin']['templates']['filetemplates'] = 'Dateivorlagen';
$lng['admin']['templates']['filecontent'] = 'Dateiinhalt';
$lng['error']['filecontentnotset'] = 'Diese Datei darf nicht leer sein!';
$lng['serversettings']['index_file_extension']['description'] = 'Welche Dateiendung soll die index Datei in neu erstellten Kundenverzeichnissen haben? Diese Dateiendung wird dann verwendet, wenn Sie bzw. einer Ihrer Admins eigene index Dateivorlagen erstellt haben.';
$lng['serversettings']['index_file_extension']['title'] = 'Dateiendung für index Datei in neu erstellen Kundenverzeichnissen';
$lng['error']['index_file_extension'] = 'Die Dateiendung für die index Datei muss zwischen 1 und 6 Zeichen lang sein und darf nur aus den Zeichen a-z, A-Z und 0-9 bestehen';
$lng['admin']['security_settings'] = 'Sicherheitseinstellungen';
$lng['admin']['expert_settings'] = 'Experteneinstellungen!';
$lng['admin']['mod_fcgid_starter']['title'] = 'PHP Prozesse für diese Domain (leer für Standardwert)';

//added with aps installer

$lng['admin']['aps'] = 'APS Installer';
$lng['customer']['aps'] = 'APS Installer';
$lng['aps']['scan'] = 'Neue Pakete einlesen';
$lng['aps']['upload'] = 'Neue Pakete hochladen';
$lng['aps']['managepackages'] = 'Pakete verwalten';
$lng['aps']['manageinstances'] = 'Instanzen verwalten';
$lng['aps']['overview'] = 'Paketübersicht';
$lng['aps']['status'] = 'Meine Pakete';
$lng['aps']['search'] = 'Paket suchen';
$lng['aps']['upload_description'] = 'Bitte wählen Sie die APS ZIP-Dateien aus, um diese im System zu installieren.';
$lng['aps']['search_description'] = 'Name, Beschreibung, Schlagwort, Version';
$lng['aps']['detail'] = 'Weitere Informationen';
$lng['aps']['install'] = 'Paket installieren';
$lng['aps']['data'] = 'Daten';
$lng['aps']['version'] = 'Version';
$lng['aps']['homepage'] = 'Homepage';
$lng['aps']['installed_size'] = 'Größe nach Installation';
$lng['aps']['categories'] = 'Kategorien';
$lng['aps']['languages'] = 'Sprachen';
$lng['aps']['long_description'] = 'Langbeschreibung';
$lng['aps']['configscript'] = 'Konfigurationskript';
$lng['aps']['changelog'] = 'Changelog';
$lng['aps']['license'] = 'Lizenz';
$lng['aps']['linktolicense'] = 'Link zur Lizenz';
$lng['aps']['screenshots'] = 'Screenshots';
$lng['aps']['back'] = 'Zurück zur Übersicht';
$lng['aps']['install_wizard'] = 'Installationsassistent...';
$lng['aps']['wizard_error'] = 'Ihre Eingaben enthalten ungültige Daten. Bitte korrigieren Sie diese, um mit der Installation fortzufahren.';
$lng['aps']['basic_settings'] = 'Grundlegende Einstellungen';
$lng['aps']['application_location'] = 'Installationsort';
$lng['aps']['application_location_description'] = 'Ort an dem die Anwendung installiert werden soll.';
$lng['aps']['no_domains'] = 'Keine Domains gefunden';
$lng['aps']['database_password'] = 'Datenbankpasswort';
$lng['aps']['database_password_description'] = 'Passwort welches für die neu zu erstellende Datenbank verwendet werden soll.';
$lng['aps']['license_agreement'] = 'Zustimmung';
$lng['aps']['cancel_install'] = 'Installation abbrechen';
$lng['aps']['notazipfile'] = 'Die hochgeladene Datei ist keine gültige ZIP-Datei.';
$lng['aps']['filetoobig'] = 'Die Datei ist zu groß.';
$lng['aps']['filenotcomplete'] = 'Die Datei wurde nicht vollständig hochgeladen.';
$lng['aps']['phperror'] = 'Es trat ein PHP interner Fehler auf. Der Upload Fehlercode lautet #';
$lng['aps']['moveproblem'] = 'Die hochgeladene Datei konnte nicht aus dem temporären Ordner verschoben werden. Prüfen Sie ob alle Rechte korrekt gesetzt sind. Dies gilt insbesondere fü die Ordner {$path}temp/ und {$path}packages/.';
$lng['aps']['uploaderrors'] = '<strong>Fehler für die Datei <em>%s</em></strong><br/><ul>%s</ul>';
$lng['aps']['nospecialchars'] = 'Sonderzeichen sind im Suchausdruck nicht erlaubt!';
$lng['aps']['noitemsfound'] = 'Es wurden keine Pakete gefunden!';
$lng['aps']['nopackagesinstalled'] = 'Sie haben noch kein Paket installiert welches angezeigt werden könnte.';
$lng['aps']['instance_install'] = 'Paket wurde zur Installation vorgemerkt';
$lng['aps']['instance_task_active'] = 'Paket wird gerade bearbeitet';
$lng['aps']['instance_success'] = 'Paket ist installiert bzw. wurde erfolgreich installiert';
$lng['aps']['instance_error'] = 'Paket ist nicht installiert - bei der Installation traten Fehler auf';
$lng['aps']['instance_uninstall'] = 'Paket wurde zur Deinstallation vorgemerkt';
$lng['aps']['unknown_status'] = 'Fehler - Unbekannter Wert';
$lng['aps']['currentstatus'] = 'Aktueller Status';
$lng['aps']['activetasks'] = 'Aktuelle Jobs';
$lng['aps']['task_install'] = 'Installation ausstehend';
$lng['aps']['task_remove'] = 'Deinstallation ausstehend';
$lng['aps']['task_reconfigure'] = 'Neukonfiguration ausstehend';
$lng['aps']['task_upgrade'] = 'Aktualisierung ausstehend';
$lng['aps']['no_task'] = 'Kein Task ausstehend';
$lng['aps']['applicationlinks'] = 'Anwendungslinks';
$lng['aps']['mainsite'] = 'Hauptseite';
$lng['aps']['uninstall'] = 'Paket deinstallieren';
$lng['aps']['reconfigure'] = 'Einstellungen ändern';
$lng['aps']['erroronnewinstance'] = '<strong>Dieses Paket kann nicht installiert werden.</strong><br/><br/>Bitte gehen Sie zurück zur Paketübersicht und starten Sie eine neue Installation.';
$lng['aps']['successonnewinstance'] = '<strong><em>%s</em> wird nun installiert.</strong><br/><br/>Gehen Sie zurück zu "Meine Pakete" und warten Sie bis die Installation abgeschlossen ist. Dies kann einige Minuten in Anspruch nehmen.';
$lng['aps']['php_misc_handler'] = 'PHP - Sonstiges - Es werden keine anderen Dateiendungen als .php zum Parsen unterstützt.';
$lng['aps']['php_misc_directoryhandler'] = 'PHP - Sonstiges - Je Verzeichnis deaktivierte PHP Handler werden nicht unterstützt.';
$lng['aps']['asp_net'] = 'ASP.NET - Paket wird nicht unterstützt.';
$lng['aps']['cgi'] = 'CGI - Paket wird nicht unterstützt.';
$lng['aps']['php_extension'] = 'PHP - Erweiterung "%s" fehlt.';
$lng['aps']['php_function'] = 'PHP - Funktion "%s" fehlt.';
$lng['aps']['php_configuration'] = 'PHP - Konfiguration - Aktuelle "%s" Einstellung wird von Paket nicht unterstützt.';
$lng['aps']['php_configuration_post_max_size'] = 'PHP - Konfiguration - "post_max_size" Wert zu klein.';
$lng['aps']['php_configuration_memory_limit'] = 'PHP - Konfiguration - "memory_limit" Wert zu klein.';
$lng['aps']['php_configuration_max_execution_time'] = 'PHP - Konfiguration - "max_execution_time" Wert zu klein.';
$lng['aps']['php_general_old'] = 'PHP - Generell - PHP Version zu alt.';
$lng['aps']['php_general_new'] = 'PHP - Generell - PHP Version zu neu.';
$lng['aps']['db_mysql_support'] = 'Datenbank - Das Paket benötigt eine andere Datenbank Engine als MySQL.';
$lng['aps']['db_mysql_version'] = 'Datenbank - MySQL Server zu alt.';
$lng['aps']['webserver_module'] = 'Webserver - Modul "%s" fehlt.';
$lng['aps']['webserver_fcgid'] = 'Webserver - Von diesem Paket werden einige Webserver Module benötigt. Da Sie Froxlor in einer FastCGI/mod_fcgid Umgebung verwenden existiert die Funktion "apache_get_modules" nicht. Es kann also nicht ermittelt werden ob das Paket unterstützt wird.';
$lng['aps']['webserver_htaccess'] = 'Webserver - Dieses Paket benötigt dass .htaccess Dateien vom Webserver geparst werden. Das Paket kann nicht installiert werden, da nicht ermittelt werden kann ob diese Funktion aktiviert ist.';
$lng['aps']['misc_configscript'] = 'Sonstiges - Die Sprache des Konfigurationsskriptes wird nicht unterstützt.';
$lng['aps']['misc_charset'] = 'Sonstiges - In der aktuellen Version wird eine Validierung gegen einen gewissen Zeichensatz im Installationsassitenten nicht unterstützt.';
$lng['aps']['misc_version_already_installed'] = 'Die gleiche Paketversion ist bereits installiert.';
$lng['aps']['misc_only_newer_versions'] = 'Aus Sicherheitsgründen können nur Pakete installiert werden die neuer sind als die, die bereits im System installiert sind.';
$lng['aps']['erroronscan'] = '<strong>Fehler für <em>%s</em></strong><ul>%s</ul>';
$lng['aps']['invalidzipfile'] = '<strong>Fehler für <em>%s</em></strong><br/><ul><li>Dies ist keine gültige APS ZIP-Datei!</li></ul>';
$lng['aps']['successpackageupdate'] = '<strong><em>%s</em> erfolgreich als Paketupdate installiert</strong>';
$lng['aps']['successpackageinstall'] = '<strong><em>%s</em> erfolgreich als neues Paket installiert</strong>';
$lng['aps']['class_zip_missing'] = 'SimpleXML Klasse, exec Funktion oder ZIP Funktionen nicht vorhanden bzw. aktiviert! Für genauere Informationen zu diesem Problem schauen Sie bitte in das Handbuch zu diesem Modul.';
$lng['aps']['dir_permissions'] = 'Der PHP bzw. Webserver Prozess muss Schreibrechte für {$path}temp/ und {$path}packages/ haben.';
$lng['aps']['initerror'] = '<strong>Es gibt ein paar Probleme mit diesem Modul:</strong><ul>%s</ul>Beheben Sie diese Probleme oder das Modul kann nicht genutzt werden!';
$lng['aps']['iderror'] = 'Es wurde eine falsche Id übergeben!';
$lng['aps']['nopacketsforinstallation'] = 'Es wurden keine Pakete zur Installation gefunden.';
$lng['aps']['nopackagestoinstall'] = 'Es existieren keine Pakete die angezeigt oder installiert werden könnten.';
$lng['aps']['nodomains'] = 'Wählen Sie eine Domain aus der Liste. Sollte keine Domain vorhanden sein können Sie keine Pakete installieren!';
$lng['aps']['wrongpath'] = 'Entweder enthält dieser Pfad ungültige Zeichen oder es ist bereits eine Anwendung am gegebenen Ort installiert.';
$lng['aps']['dbpassword'] = 'Geben Sie ein Passwort mit einer minimalen Länge von 8 Zeichen ein.';
$lng['aps']['error_text'] = 'Geben Sie einen Text ohne Sonderzeichen ein.';
$lng['aps']['error_email'] = 'Geben Sie eine gültige E-Mail Adresse ein.';
$lng['aps']['error_domain'] = 'Geben Sie eine gültige URL wie http://www.example.com/ ein.';
$lng['aps']['error_integer'] = 'Geben Sie eine Zahl (Integer-Format) ein. Beispiel: <em>5</em> oder <em>7</em>.';
$lng['aps']['error_float'] = 'Geben Sie eine Zahl (Float-Format) ein. Beispiel: <em>5,2432</em> oder <em>7,5346</em>.';
$lng['aps']['error_password'] = 'Geben Sie ein Passwort ein.';
$lng['aps']['error_license'] = 'Ja, ich habe die Lizenz gelesen und willige ein diese zu befolgen.';
$lng['aps']['error_licensenoaccept'] = 'Sie müssen die Lizenz annehmen um die Anwendung installieren zu können.';
$lng['aps']['stopinstall'] = 'Installation abbrechen';
$lng['aps']['installstopped'] = 'Die Installation für dieses Paket wurde erfolgreich abgebrochen.';
$lng['aps']['installstoperror'] = 'Die Installation kann nicht mehr abgebrochen werden, da diese bereits gestartet wurde. Möchten Sie das Paket entfernen, so warten Sie die Installation ab und entfernen Sie dann das Paket unter "Meine Pakete"';
$lng['aps']['waitfortask'] = 'Es stehen momentan keine Aktionen zur Verfügung. Warten Sie bis alle Tasks abgearbeitet wurden.';
$lng['aps']['removetaskexisting'] = '<strong>Es gibt bereits einen Task zur Deinstallation.</strong><br/><br/>Bitte gehen Sie zurück zu "Meine Pakete" und warten Sie bis die Deinstallation abgeschlossen ist.';
$lng['aps']['packagewillberemoved'] = '<strong>Das Paket wird nun deinstalliert.</strong><br/><br/>Gehen Sie zurück zu "Meine Pakete" und warten Sie bis die Deinstallation abgeschlossen ist.';
$lng['question']['reallywanttoremove'] = '<strong>Wollen Sie dieses Paket wirklich deinstallieren?</strong><br/><br/>Alle Datenbankinhalte und Dateien werden unwiderruflich gelöscht. Wenn Sie die enthaltenen Daten weiterhin benötigen, stellen Sie sicher dass Sie diese vorher sichern!<br/><br/>';
$lng['aps']['searchoneresult'] = '%s Paket gefunden';
$lng['aps']['searchmultiresult'] = '%s Pakete gefunden';
$lng['question']['reallywanttostop'] = 'Wollen Sie die Installation dieses Paketes wirklich abbrechen?<br/><br/>';
$lng['aps']['packagenameandversion'] = 'Paketname & Version';
$lng['aps']['package_locked'] = 'Gesperrt';
$lng['aps']['package_enabled'] = 'Freigegeben';
$lng['aps']['lock'] = 'Sperren';
$lng['aps']['unlock'] = 'Freigeben';
$lng['aps']['remove'] = 'Löschen';
$lng['aps']['allpackages'] = 'Alle Pakete';
$lng['question']['reallyremovepackages'] = '<strong>Wollen Sie diese Pakete wirklich löschen?</strong><br/><br/>Pakete mit Abhängigkeiten können erst gelöscht werden wenn die entsprechenden Instanzen dafür deinstalliert wurden!<br/><br/>';
$lng['aps']['nopackagesinsystem'] = 'Es wurden noch keine Pakete im System installiert, die verwaltet werden könnten.';
$lng['aps']['packagenameandstatus'] = 'Paketname & Status';
$lng['aps']['activate_aps']['title'] = 'APS Installer aktivieren';
$lng['aps']['activate_aps']['description'] = 'Hier können Sie den APS Installer global aktivieren bzw. deaktivieren.';
$lng['aps']['packages_per_page']['title'] = 'Pakete pro Seite';
$lng['aps']['packages_per_page']['description'] = 'Wieviele Pakete sollen Kunden pro Seite angezeigt bekommen?';
$lng['aps']['upload_fields']['title'] = 'Uploadfelder pro Seite';
$lng['aps']['upload_fields']['description'] = 'Wieviele Uploadfelder sollen im Panel zur Installation von Paketen angezeigt werden?';
$lng['aps']['exceptions']['title'] = 'Ausnahmen für Paketvalidierung';
$lng['aps']['exceptions']['description'] = 'Manche Pakete benötigen spezielle Konfigurationsparameter oder Module. Der Installer selbst kann nicht immer eindeutig feststellen ob diese Optionen/Erweiterungen aktiviert sind. Aus diesem Grund kann man hier nun Ausnahmen festlegen damit Pakete dann trotzdem installiert werden können. Wählen Sie nur die Optionen aus, die auch wirklich so mit der Realität übereinstimmen. Für genauere Informationen zu diesem Problem schauen Sie bitte in das Handbuch zu diesem Modul.';
$lng['aps']['settings_php_extensions'] = 'PHP-Erweiterungen';
$lng['aps']['settings_php_configuration'] = 'PHP-Konfiguration';
$lng['aps']['settings_webserver_modules'] = 'Webserver Module';
$lng['aps']['settings_webserver_misc'] = 'Webserver Sonstiges';
$lng['aps']['specialoptions'] = 'Sonderoptionen';
$lng['aps']['removeunused'] = 'Ungenutzte Pakete entfernen';
$lng['aps']['enablenewest'] = 'Von jedem Paket neueste Version freigeben, alte sperren';
$lng['aps']['installations'] = 'Installationen';
$lng['aps']['statistics'] = 'Statistiken';
$lng['aps']['numerofpackagesinstalled'] = '%s Pakete vorhanden<br/>';
$lng['aps']['numerofpackagesenabled'] = '%s Pakete freigegeben<br/>';
$lng['aps']['numerofpackageslocked'] = '%s Pakete gesperrt<br/>';
$lng['aps']['numerofinstances'] = '%s Instanzen installiert<br/>';
$lng['question']['reallydoaction'] = '<strong>Wollen Sie die gewählten Aktionen wirklich durchführen?</strong><br/><br/>Daten, die durch diese Vorgänge möglicherweise gelöscht werden, können anschließend nicht wieder hergestellt werden.<br/><br/>';
$lng['aps']['initerror_customer'] = 'Es gibt momentan ein Problem mit dieser Froxlor Erweiterung. Wenden Sie sich an Ihren Administrator für weitere Informationen.';
$lng['aps']['numerofinstances'] = '%s Installationen insgesamt<br/>';
$lng['aps']['numerofinstancessuccess'] = '%s erfolgreiche Installationen<br/>';
$lng['aps']['numerofinstanceserror'] = '%s fehlgeschlagene Installationen<br/>';
$lng['aps']['numerofinstancesaction'] = '%s geplante Installationen/Deinstallationen';
$lng['aps']['downloadallpackages'] = 'Alle Pakete vom Distributionsserver herunterladen';
$lng['aps']['updateallpackages'] = 'Alle Pakete über Distributionsserver aktualisieren';
$lng['aps']['downloadtaskexists'] = 'Es gibt bereits einen Task zum Download aller Pakete. Bitte warten Sie bis dieser abgeschlossen ist.';
$lng['aps']['downloadtaskinserted'] = 'Es wurde ein Task zum Download aller Pakete erstellt. Dieser Vorgang kann einige Minuten in Anspruch nehmen.';
$lng['aps']['updatetaskexists'] = 'Es gibt bereits einen Task zur Aktualisierung aller Pakete. Bitte warten Sie bis dieser abgeschlossen ist.';
$lng['aps']['updatetaskinserted'] = 'Es wurde ein Task zur Aktualisierung aller Pakete erstellt. Dieser Vorgang kann einige Minuten in Anspruch nehmen.';
$lng['aps']['canmanagepackages'] = 'Darf APS Pakete verwalten';
$lng['aps']['numberofapspackages'] = 'Anzahl an APS Installationen';
$lng['aps']['allpackagesused'] = '<strong>Fehler</strong><br/><br/>Sie haben bereits die Anzahl an installierbaren APS Anwendungen erreicht bzw. überschritten.';
$lng['aps']['noinstancesexisting'] = 'Es gibt momentan noch keine Instanzen, die verwaltet werden könnten. Es muss mindestens eine Anwendung von einem Kunden installiert worden sein.';
$lng['aps']['lightywarning'] = 'Warnung';
$lng['aps']['lightywarningdescription'] = 'Sie verwenden den lighttpd Webserver zusammen mit Froxlor. Da das APS Modul hauptsächlich für den Apache Webserver geschrieben wurde, kann es unter Umständen vorkommen, dass gewisse Features mit lighttpd nicht funktionieren. Bitte beachten Sie dies bei der Verwendung des APS Moduls. Sollten Sie Fehler bei der Verwendung oder Probleme bei der Nutzung haben, so leiten Sie diese bitte an die Entwickler weiter, damit diese Probleme in der nächsten Version behoben werden können.';
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

$lng['admin']['phpserversettings'] = 'PHP Einstellungen';
$lng['admin']['phpsettings']['binary'] = 'PHP Binary';
$lng['admin']['phpsettings']['file_extensions'] = 'Dateiendungen';
$lng['admin']['phpsettings']['file_extensions_note'] = '(ohne Punkt, durch Leerzeichen getrennt)';
$lng['admin']['mod_fcgid_maxrequests']['title'] = 'Maxmale PHP Requests für diese Domain (leer für Standardwert)';
$lng['serversettings']['mod_fcgid']['maxrequests']['title'] = 'Maximale Requests pro Domain';
$lng['serversettings']['mod_fcgid']['maxrequests']['description'] = 'Wieviele PHP Requests pro Domain sollen erlaubt werden?';

// fix bug #1124
$lng['admin']['webserver'] = 'Webserver';
$lng['error']['admin_domain_emailsystemhostname'] = 'Der Server-Hostname kann leider nicht als E-Mail-Domain verwendet werden.';
$lng['aps']['license_link'] = 'Link zur Lizenz';

// ADDED IN FROXLOR 0.9

$lng['admin']['spfsettings'] = 'Domain SPF Einstellungen';
$lng['spf']['use_spf'] = 'Aktiviere SPF für Domains?';
$lng['spf']['spf_entry'] = 'SPF Eintrag für alle Domains';
$lng['panel']['dirsmissing'] = 'Das angegebene Verzeichnis konnte nicht gefunden werden.';
$lng['panel']['toomanydirs'] = 'Zu viele Unterverzeichnisse. Weiche auf manuelle Verzeichniseingabe aus.';
$lng['panel']['abort'] = 'Abbrechen';
$lng['serversettings']['cron']['debug']['title'] = 'Debuggen des Cronscripts';
$lng['serversettings']['cron']['debug']['description'] = 'Wenn aktiviert, wird die Lockdatei nach dem Cronlauf zum Debuggen nicht gelöscht<br /><b>Achtung:</b> Eine alte Lockdatei kann weitere Cronjobs behindern und dafür sorgen, dass diese nicht vollständig ausgeführt werden.';
$lng['autoresponder']['date_from'] = 'Start-Datum';
$lng['autoresponder']['date_until'] = 'End-Datum';
$lng['autoresponder']['startenddate'] = 'Start/End-Datum';
$lng['panel']['not_activated'] = 'Nicht aktiviert';
$lng['panel']['off'] = 'aus';
$lng['update']['updateinprogress_onlyadmincanlogin'] = 'Eine neuere Version von Froxlor wurde installiert, aber noch nicht eingerichtet.<br />Nur der Administrator kann sich anmelden und die Aktualisierung abschließen.';
$lng['update']['update'] = 'Froxlor Aktualisierung';
$lng['update']['proceed'] = 'Ausführen';
$lng['update']['update_information']['part_a'] = 'Die Froxlor Dateien wurden aktualisiert. Neue Version ist <strong>%newversion</strong>. Die bisher installierte Version ist <strong>%curversion</strong>';
$lng['update']['update_information']['part_b'] = '<br /><br />Ein Kunden-Login ist vor Abschluss des Aktualisierungsvorganges nicht möglich.<br /><strong>Aktualisierung ausführen?</strong>';
$lng['update']['noupdatesavail'] = '<strong>Ihre Froxlor-Version ist aktuell.</strong>';
$lng['admin']['specialsettingsforsubdomains'] = 'Übernehme Einstellungen für alle Subdomains (*.beispiel.de)';
$lng['serversettings']['specialsettingsforsubdomains']['description'] = 'Wenn ja, werden die individuellen Einstellungen für alle Subdomains übernommen; wenn nein, werden Subdomain-Specialsettings entfernt.';
$lng['tasks']['outstanding_tasks'] = 'Ausstehende Cron-Aufgaben';
$lng['tasks']['rebuild_webserverconfig'] = 'Neuerstellung der Webserver-Konfiguration';
$lng['tasks']['adding_customer'] = 'Erstelle neuen Kunden %loginname%';
$lng['tasks']['rebuild_bindconfig'] = 'Neuerstellung der Bind-Konfiguration';
$lng['tasks']['creating_ftpdir'] = 'Erstelle Verzeichnis für neuen FTP-Benutzer';
$lng['tasks']['deleting_customerfiles'] = 'Löschen von Kunden-Dateien %loginname%';
$lng['tasks']['noneoutstanding'] = 'Zur Zeit gibt es keine ausstehenden Aufgaben für Froxlor';
$lng['ticket']['nonexistingcustomer'] = '(gelöschter Kunde)';
$lng['admin']['ticket_nocustomeraddingavailable'] = 'Es können derzeit keine neuen Support-Tickets eröffnet werden. Sie müssen zuerst einen Kunden anlegen';

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
$lng['error']['notrequiredpasswordlength'] = 'Das Passwort ist zu kurz. Bitte geben Sie mindestens %s Zeichen an.';
$lng['serversettings']['system_store_index_file_subs']['title'] = 'Erstelle Index-Datei auch in neuen Unterordnern';
$lng['serversettings']['system_store_index_file_subs']['description'] = 'Wenn aktiviert, wird für jede Subdomain mit neuem Unterordner die Standard-Index Datei angelegt.';

// ADDED IN FROXLOR 0.9.3-svn2

$lng['serversettings']['adminmail_return']['title'] = 'Antwort-Adresse';
$lng['serversettings']['adminmail_return']['description'] = 'Standard-Antwort-Adresse für E-Mails aus dem Panel.';
$lng['serversettings']['adminmail_defname'] = 'Panel Absender Name';

// ADDED IN FROXLOR 0.9.3-svn3
$lng['dkim']['dkim_algorithm']['title'] = 'Gültige Hash Algorithmen';
$lng['dkim']['dkim_algorithm']['description'] = 'Wählen sie einen Algorithmus, "All" für alle Algorithmen oder Einen oder Mehrere von den verfügbaren Algorithmen';
$lng['dkim']['dkim_servicetype'] = 'Service Typen';
$lng['dkim']['dkim_keylength']['title'] = 'Schlüssel-Länge';
$lng['dkim']['dkim_keylength']['description'] = 'Achtung: Bei Änderung dieser Einstellung müssen alle private/public Schlüssel in "'.$settings['dkim']['dkim_prefix'].'" gelöscht werden.';
$lng['dkim']['dkim_notes']['title'] = 'DKIM Notiz';
$lng['dkim']['dkim_notes']['description'] = 'Eine Notiz, welche für Menschen interessant sein könnte, Z.B. eine URL wie http://www.dnswatch.info. Es gibt keine programmgesteuerte Interpretation für dieses Feld. Gehen sie sparsam mit der Anzahl der Zeichen um, da es Einschränkungen seitens des DNS Dienstes gibt. Dieses Feld ist für Administratoren gedacht, nicht für Benutzer.';
$lng['dkim']['dkim_add_adsp']['title'] = 'DKIM ADSP Eintrag hinzufügen';
$lng['dkim']['dkim_add_adsp']['description'] = 'Wenn unsicher oder unbekannt, belassen sie es auf "aktiviert"';
$lng['dkim']['dkim_add_adsppolicy']['title'] = 'ADSP Richtlinie';
$lng['dkim']['dkim_add_adsppolicy']['description'] = 'Mehr Informationen zu dieser Einstellung (englisch) <a target="blank" href="http://redmine.froxlor.org/projects/froxlor/wiki/En-dkim-adsp-policies">DKIM ADSP Policies</a>';

$lng['admin']['cron']['cronsettings'] = 'Cronjob Einstellungen';
$lng['cron']['cronname'] = 'Cronjob-Name';
$lng['cron']['lastrun'] = 'zuletzt gestartet';
$lng['cron']['interval'] = 'Intervall';
$lng['cron']['isactive'] = 'Aktiv';
$lng['cron']['description'] = 'Beschreibung';
$lng['crondesc']['cron_unknown_desc'] = 'Keine Beschreibung angegeben';
$lng['admin']['cron']['add'] = 'Cronjob hinzufügen';
$lng['crondesc']['cron_tasks'] = 'Erstellen von Konfigurationsdateien';
$lng['crondesc']['cron_legacy'] = 'Legacy (alter) Cronjob';
$lng['crondesc']['cron_apsinstaller'] = 'APS-Installer';
$lng['crondesc']['cron_autoresponder'] = 'E-Mail Autoresponder';
$lng['crondesc']['cron_apsupdater'] = 'Aktualisieren der APS Pakete';
$lng['crondesc']['cron_traffic'] = 'Traffic-Berechnung';
$lng['crondesc']['cron_ticketsreset'] = 'Zurücksetzen der Ticket-Zähler';
$lng['crondesc']['cron_ticketarchive'] = 'Archivieren alter Tickets';
$lng['cronmgmt']['seconds'] = 'Sekunden';
$lng['cronmgmt']['minutes'] = 'Minuten';
$lng['cronmgmt']['hours'] = 'Stunden';
$lng['cronmgmt']['days'] = 'Tage';
$lng['cronmgmt']['weeks'] = 'Wochen';
$lng['cronmgmt']['months'] = 'Monate';
$lng['admin']['cronjob_edit'] = 'Cronjob bearbeiten';
$lng['cronjob']['cronjobsettings'] = 'Cronjob Einstellungen';
$lng['cronjob']['cronjobintervalv'] = 'Laufzeit-Intervall Wert';
$lng['cronjob']['cronjobinterval'] = 'Laufzeit-Intervall';
$lng['panel']['options'] = 'Optionen';
$lng['admin']['warning'] = 'ACHTUNG - Wichtiger Hinweis!';
$lng['cron']['changewarning'] = 'Änderungen an diesen Werten können einen negativen Effekt auf das Verhalten von Froxlor und seinen automatisierten Aufgaben haben.<br /><br />Ändern Sie hier etwas bitte nur, wenn Sie sich dessen Folgen im Klaren sind.';

$lng['serversettings']['stdsubdomainhost']['title'] = 'Kunden Standard-Subdomain';
$lng['serversettings']['stdsubdomainhost']['description'] = 'Welcher Hostname soll für das Erstellen der Kunden-Standard-Subdomain verwendet werden? Falls leer wird der System-Hostname verwendet.';

// ADDED IN FROXLOR 0.9.4-svn1
$lng['ftp']['account_edit'] = 'FTP Konto bearbeiten';
$lng['ftp']['editpassdescription'] = 'Neues Passwort setzen oder leer für keine Änderung.';
$lng['customer']['sendinfomail'] = 'Daten per E-Mail an mich senden';
$lng['customer']['mysql_add']['infomail_subject'] = '[Froxlor] Neue Datenbank erstellt';
$lng['customer']['mysql_add']['infomail_body']['main'] = "Hallo {CUST_NAME},\n\ndu hast gerade eine neue Datenbank angelegt. Hier die angegebenen Informationen:\n\nDatenbankname: {DB_NAME}\nPasswort: {DB_PASS}\nBeschreibung: {DB_DESC}\nDatenbank-Server: {DB_SRV}\nphpMyAdmin: {PMA_URI}\nVielen Dank, Ihr Administrator";
$lng['error']['domains_cantdeletedomainwithapsinstances'] = 'Sie können keine Domain löschen, die noch von APS Paketen verwendet wird. Löschen Sie zuerst alle installierten APS Pakete dieser Domain.';
$lng['serversettings']['awstats_path'] = 'Pfad zu AWStats \'awstats_buildstaticpages.pl\'';
$lng['serversettings']['awstats_conf'] = 'AWStats Konfigurations-Pfad';
$lng['error']['overviewsettingoptionisnotavalidfield'] = 'Hoppla, ein Feld, dass als Option in der Konfigurationsübersicht angezeigt werden soll, hat nicht den erwarteten Wert. Sie können den Entwicklern die Schuld geben. Dies sollte nicht passieren!';
$lng['admin']['configfiles']['compactoverview'] = 'Kompakt-Übersicht';

$lng['mysql']['mysql_server'] = 'MySQL-Server';
$lng['admin']['ipsandports']['webserverdefaultconfig'] = 'Webserver Standard Konfiguration';
$lng['admin']['ipsandports']['webserverdomainconfig'] = 'Webserver Domain Konfiguration';
$lng['admin']['ipsandports']['webserverssldomainconfig'] = 'Webserver SSL Konfiguration';
$lng['admin']['ipsandports']['ssl_key_file'] = 'Pfad zu der SSL Schlüsseldatei';
$lng['admin']['ipsandports']['ssl_ca_file'] = 'Pfad zu dem SSL CA Zertifikat';
$lng['admin']['ipsandports']['default_vhostconf_domain'] = 'Standard vHost - Einstellungen für jeden Domain - Kontainer';
$lng['serversettings']['ssl']['ssl_key_file'] = 'Pfad zu der SSL Schlüsseldatei';
$lng['serversettings']['ssl']['ssl_ca_file'] = 'Pfad zu dem SSL CA Zertifikat';
$lng['error']['usernamealreadyexists'] = 'Der Benutzername %s existiert bereits.';
$lng['error']['plausibilitychecknotunderstood'] = 'Die Antwort des Plausibilitätschecks wurde nicht verstanden';
$lng['error']['errorwhensaving'] = 'Bei dem Speichern des Feldes %s trat ein Fehler auf';
$lng['success']['success'] = 'Information';
$lng['success']['clickheretocontinue'] = 'Hier klicken um fortzufahren';
$lng['success']['settingssaved'] = 'Die Einstellungen wurden erfolgreich gespeichert.';
$lng['admin']['lastlogin_succ'] = 'Letzte Anmeldung';
$lng['panel']['neverloggedin'] = 'Keine Anmeldung bisher';

// ADDED IN FROXLOR 0.9.6-svn1
$lng['serversettings']['defaultttl'] = 'Domain TTL für Bind in Sekunden (default \'604800\' = 1 Woche)';
$lng['ticket']['logicalorder'] = 'Logische Sortierung';
$lng['ticket']['orderdesc'] = 'Hier kann eine logische Sortierung für die Ticket-Kategorien angegeben werden. Benutze 1 - 999, niedrigere Zahlen werden zuerst angezeigt.';

// ADDED IN FROXLOR 0.9.6-svn3
$lng['serversettings']['defaultwebsrverrhandler_enabled'] = 'Verwende Standard-Fehlerdokumente für alle Kunden';
$lng['serversettings']['defaultwebsrverrhandler_err401']['title'] = 'Datei/URL für Fehler 401';
$lng['serversettings']['defaultwebsrverrhandler_err401']['description'] = '<div style="color:red">'.$lng['panel']['not_supported'].'lighttpd</div>';
$lng['serversettings']['defaultwebsrverrhandler_err403']['title'] = 'Datei/URL für Fehler 403';
$lng['serversettings']['defaultwebsrverrhandler_err403']['description'] = '<div style="color:red">'.$lng['panel']['not_supported'].'lighttpd</div>';
$lng['serversettings']['defaultwebsrverrhandler_err404'] = 'Datei/URL für Fehler 404';
$lng['serversettings']['defaultwebsrverrhandler_err500']['title'] = 'Datei/URL für Fehler 500';
$lng['serversettings']['defaultwebsrverrhandler_err500']['description'] = '<div style="color:red">'.$lng['panel']['not_supported'].'lighttpd</div>';

// ADDED IN FROXLOR 0.9.6-svn4
$lng['serversettings']['ticket']['default_priority'] = 'Voreingestellte Support-Ticket Priorität';

// ADDED IN FROXLOR 0.9.6-svn5
$lng['serversettings']['mod_fcgid']['defaultini'] = 'Voreingestellte PHP Konfiguration für neue Domains';

// ADDED IN FROXLOR 0.9.6-svn5
$lng['admin']['ftpserver'] = 'FTP Server';
$lng['admin']['ftpserversettings'] = 'FTP Server Einstellungen';
$lng['serversettings']['ftpserver']['desc'] = 'Wenn pureftpd ausgewählt ist, werden die .ftpquota Dateien für das Quota erstellt und täglich aktualisiert.';

// CHANGED IN FROXLOR 0.9.6-svn5
$lng['serversettings']['ftpprefix']['description'] = 'Welchen Prefix sollen die FTP-Benutzerkonten haben?<br/><b>Wenn du das änderst, musst du auch das Quota SQL Query in der FTP Server Config ändern, solltest du FTP-Quotas benutzen!</b>';

// ADDED IN FROXLOR 0.9.7-svn1
$lng['customer']['ftp_add']['infomail_subject'] = '[Froxlor] Neuer FTP-Benutzer erstellt';
$lng['customer']['ftp_add']['infomail_body']['main'] = "Hallo {CUST_NAME},\n\ndu hast gerade einen neuen FTP-Benutzer angelegt. Hier die angegebenen Informationen:\n\nBenutzername: {USR_NAME}\nPasswort: {USR_PASS}\nPfad: {USR_PATH}\n\nVielen Dank, Ihr Administrator";
$lng['domains']['redirectifpathisurl'] = 'Redirect code (Standard: leer)';
$lng['domains']['redirectifpathisurlinfo'] = 'Der Redirect code kann gewählt werden, wenn der eingegebene Pfad eine URL ist';
$lng['serversettings']['customredirect_enabled']['title'] = 'Erlaube Kunden-Redirect';
$lng['serversettings']['customredirect_enabled']['description'] = 'Erlaubt es Kunden den HTTP-Status Code für einen Redirect zu wählen';
$lng['serversettings']['customredirect_default']['title'] = 'Standard Redirect';
$lng['serversettings']['customredirect_default']['description'] = 'Dieser Redirect wird immer genutzt, sofern der Kunde keinen anderen auswählt.';

// ADDED IN FROXLOR 0.9.7-svn2
$lng['error']['pathmaynotcontaincolon'] = 'Der eingegebene Pfad sollte keinen Doppelpunkt (":") enthalten. Bitte geben Sie einen korrekten Wert für den Pfad ein.';
$lng['tasks']['aps_task_install'] = 'Installation eines oder mehrerer APS Pakete';
$lng['tasks']['aps_task_remove'] = 'Deinstallation eines oder mehrerer APS Pakete';
$lng['tasks']['aps_task_reconfigure'] = 'Rekonfiguration eines oder mehrerer APS Pakete';
$lng['tasks']['aps_task_upgrade'] = 'Upgrade eines oder mehrerer APS Pakete';
$lng['tasks']['aps_task_sysupdate'] = 'Aktualisiere alle APS Pakete';
$lng['tasks']['aps_task_sysdownload'] = 'Herunterladen neuer APS Pakete';

// ADDED IN FROXLOR 0.9.9-svn1
$lng['serversettings']['mail_also_with_mxservers'] = 'Erstelle mail-, imap-, pop3- and smtp-"A Record" auch wenn MX-Server angegeben sind';

// ADDED IN FROXLOR 0.9.10-svn1
$lng['aps']['nocontingent'] = 'Sie haben kein ausreichendes APS-Kontingent und können daher keine Pakete installieren.';
$lng['aps']['packageneedsdb'] = 'Dieses Paket benötigt eine Datenbank, Sie haben allerdings keine mehr frei';
$lng['aps']['cannoteditordeleteapsdb'] = 'APS-Datenbanken können hier nicht bearbeitet oder gelöscht werden';
$lng['admin']['webserver_user'] = 'Benutzername Webserver';
$lng['admin']['webserver_group'] = 'Gruppenname Webserver';

// ADDED IN FROXLOR 0.9.10
$lng['serversettings']['froxlordirectlyviahostname'] = 'Froxlor direkt über den Hostnamen erreichbar machen';

// ADDED IN FROXLOR 0.9.11-svn1
$lng['serversettings']['panel_password_regex']['title'] = 'Regulärer Ausdruck für Passwörter';
$lng['serversettings']['panel_password_regex']['description'] = 'Hier können Sie einen regulären Ausdruck für Passwort-Komplexität festlegen.<br />Leer = keine bestimmten Anforderungen<br />(<a target="blank" href="http://redmine.froxlor.org/projects/froxlor/wiki/En-password-regex-examples">RegEx Hilfe/Beispiele</a>)';
$lng['error']['notrequiredpasswordcomplexity'] = 'Die vorgegebene Passwort-Komplexität wurde nicht erfüllt.<br />Bitte kontaktieren Sie Ihren Administrator, wenn Sie Fragen zur Komplexitäts-Vorgabe haben.';

// ADDED IN FROXLOR 0.9.11-svn2
$lng['extras']['execute_perl'] = 'Perl/CGI ausführen';
$lng['admin']['perlenabled'] = 'Perl verfügbar';

// ADDED IN FROXLOR 0.9.11-svn3
$lng['serversettings']['perl_path']['title'] = 'Pfad zu Perl';
$lng['serversettings']['perl_path']['description'] = 'Standard ist /usr/bin/perl';

// ADDED IN FROXLOR 0.9.12-svn1
$lng['admin']['fcgid_settings'] = 'FCGID';
$lng['serversettings']['mod_fcgid_ownvhost']['title'] = 'Verwende FCGID im Froxlor Vhost';
$lng['serversettings']['mod_fcgid_ownvhost']['description'] = 'Wenn verwendet, wird Froxlor selbst unter einem lokalem Benutzer ausgeführt';
$lng['admin']['mod_fcgid_user'] = 'Lokaler Benutzer für FCGID (Froxlor Vhost)';
$lng['admin']['mod_fcgid_group'] = 'Lokale Gruppe für FCGID (Froxlor Vhost)';

// ADDED IN FROXLOR 0.9.12-svn2
$lng['admin']['perl_settings'] = 'Perl/CGI';
$lng['serversettings']['perl']['suexecworkaround']['title'] = 'Aktiviere SuExec Workaround';
$lng['serversettings']['perl']['suexecworkaround']['description'] = 'Aktivieren Sie den Workaround nur, wenn die Kunden-Heimatverzeichnisse sich nicht unterhalb des suexec-Pfades liegen.<br />Wenn aktiviert erstellt Froxlor eine Verknüpfung des vom Kunden für Perl aktiviertem Pfad + /cgi-bin/ im angegebenen suexec-Pfad.<br />Bitte beachten Sie, dass Perl dann nur im Unterordner /cgi-bin/ des Kunden-Ordners funktioniert und nicht direkt in diesem Ordner (wie es ohne den Workaround wäre!)';
$lng['serversettings']['perl']['suexeccgipath']['title'] = 'Pfad für Verknüpfungen zu Kunden-Perl-Verzeichnis';
$lng['serversettings']['perl']['suexeccgipath']['description'] = 'Diese Einstellung wird nur benötigt, wenn der SuExec-Workaround aktiviert ist.<br />ACHTUNG: Stellen Sie sicher, dass sich der angegebene Pfad innerhalb des Suexec-Pfades befindet ansonsten ist der Workaround nutzlos';
$lng['panel']['descriptionerrordocument'] = 'Mögliche Werte sind: URL, Pfad zu einer Datei oder ein Text umgeben von Anführungszeichen (" ")<br />Leer für Server-Standardwert.';
$lng['error']['stringerrordocumentnotvalidforlighty'] = 'Ein Text als Fehlerdokument funktioniert leider in LigHTTPd nicht, bitte geben Sie einen Pfad zu einer Datei an';
$lng['error']['urlerrordocumentnotvalidforlighty'] = 'Eine URL als Fehlerdokument funktioniert leider in LigHTTPd nicht, bitte geben Sie einen Pfad zu einer Datei an';

// ADDED IN FROXLOR 0.9.12-svn3
$lng['question']['remove_subbutmain_domains'] = 'Auch Domains entfernen, welche als volle Domains hinzugefügt wurden, aber Subdomains von dieser Domain sind?';
$lng['domains']['issubof'] = 'Diese Domain ist eine Subdomain von der Domain';
$lng['domains']['issubofinfo'] = 'Diese Einstellung muss gesetzt werden, wenn Sie eine Subdomain einer Hauptdomain als Hauptdomain anlegen (z.B. soll "www.domain.tld" hinzugefügt werden, somit muss hier "domain.tld" ausgewählt werden)';
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
$lng['admin']['templates']['USR_NAME'] = 'FTP Benutzername';
$lng['admin']['templates']['USR_PASS'] = 'FTP Passwort';
$lng['admin']['templates']['USR_PATH'] = 'FTP Heimatverzeichnis (relativ zum Kunden-Heimatverzeichnis)';

// ADDED IN FROXLOR 0.9.12-svn4
$lng['serversettings']['awstats_awstatspath'] = 'Pfad zu AWStats \'awstats.pl\'';

// ADDED IN FROXLOR 0.9.12-svn6
$lng['extras']['htpasswdauthname'] = 'Authentifizierungs-Grund (AuthName)';
$lng['extras']['directoryprotection_edit'] = 'Verzeichnisschutz bearbeiten';
$lng['admin']['templates']['forgotpwd'] = 'Benachrichtigungs-Mails bei Zurücksetzen des Passworts';
$lng['admin']['templates']['password_reset'] = 'Kunden-Benachrichtigung nach Zurücksetzen des Passworts';
$lng['admin']['store_defaultindex'] = 'Erstelle standard Index-Datei in Kunden-Ordner';

// ADDED IN FROXLOR 0.9.13-svn1
$lng['customer']['autoresponder'] = 'Abwesenheitsnachrichten';

// ADDED IN FROXLOR 0.9.14-svn1
$lng['serversettings']['mod_fcgid']['defaultini_ownvhost'] = 'Voreingestellte PHP Konfiguration für den Froxlor-Vhost';

// ADDED IN FROXLOR 0.9.14-svn3
$lng['serversettings']['awstats_icons']['title'] = 'Pfad zum AWstats icons Ordner';
$lng['serversettings']['awstats_icons']['description'] = 'z.B. /usr/share/awstats/htdocs/icon/';

// ADDED IN FROXLOR 0.9.14-svn4
$lng['admin']['ipsandports']['ssl_cert_chainfile'] = 'Pfad zu dem SSL CertificateChainFile';

// ADDED IN FROXLOR 0.9.14-svn5
$lng['admin']['ipsandports']['docroot']['title'] = 'Benutzerdefinierter Docroot (leer = zeige auf Froxlor)';
$lng['admin']['ipsandports']['docroot']['description'] = 'Hier kann ein benutzerdefinierter Document-Root (der Zielordner für einen Zugriff) für diese IP/Port Kombination gesetzt werden.<br /><strong>ACHTUNG:</strong> Bitte überlege vorher, welchen Pfad du hier angibst!';

// ADDED IN FROXLOR 0.9.14-svn6
$lng['serversettings']['login_domain_login'] = 'Erlaube Anmeldung mit Domains';

// ADDED IN FROXLOR 0.9.14
$lng['panel']['unlock'] = 'entsperren';
$lng['question']['customer_reallyunlock'] = 'Wollen Sie den Kunden %s wirklich entsperren?';

// ADDED IN FROXLOR 0.9.15-svn1
$lng['serversettings']['perl_server']['title'] = 'Perl Server Ort';
$lng['serversettings']['perl_server']['description'] = 'Der Standardwert ist diesem Guide entnommen: <a target="blank" href="http://wiki.nginx.org/SimpleCGI">http://wiki.nginx.org/SimpleCGI</a>';
$lng['serversettings']['nginx_php_backend']['title'] = 'Nginx PHP Backend';
$lng['serversettings']['nginx_php_backend']['description'] = 'Dies ist das Backend, auf dem PHP auf Anfragen von Nginx hört. Kann ein UNIX Socket oder eine IP:Port Kombination sein<br />*NICHT relevant bei php-fpm';
$lng['serversettings']['phpreload_command']['title'] = 'PHP Reload Befehl';
$lng['serversettings']['phpreload_command']['description'] = 'Dieser wird benötigt, um das PHP Backend bei Bedarf durch den Cronjob neu zu laden. (Standard: leer)<br />*NICHT relevant bei php-fpm';

// ADDED IN FROXLOR 0.9.16
$lng['error']['intvaluetoolow'] = 'Die angegebene Zahl ist zu klein (Feld %s)';
$lng['error']['intvaluetoohigh'] = 'Die angegebene Zahl ist zu groß (Feld %s)';
$lng['admin']['phpfpm_settings'] = 'PHP-FPM';
$lng['serversettings']['phpfpm'] = 'Aktiviere php-fpm';
$lng['serversettings']['phpfpm_settings']['configdir'] = 'Pfad zu php-fpm Konfigurationen';
$lng['serversettings']['phpfpm_settings']['reload'] = 'Kommando zum Neustarten von php-fpm';
$lng['serversettings']['phpfpm_settings']['pm'] = 'Prozess Manager Control (PM)';
$lng['serversettings']['phpfpm_settings']['max_children']['title'] = 'Anzahl der Kind-Prozesse';
$lng['serversettings']['phpfpm_settings']['max_children']['description'] = 'Die Anzahl der zu startenden Kind-Prozesse wenn PM auf \'static\' steht und die maximale Anzahl der Prozesse wenn PM auf \'dynamic/ondemand\' steht.<br />Equivalent zu PHP_FCGI_CHILDREN';
$lng['serversettings']['phpfpm_settings']['start_servers']['title'] = 'Anzahl der beim Starten zu erstellenden Kind-Prozesse';
$lng['serversettings']['phpfpm_settings']['start_servers']['description'] = 'Hinweis: Nur wenn PM auf \'dynamic/ondemand\' steht';
$lng['serversettings']['phpfpm_settings']['min_spare_servers']['title'] = 'Mindestanzahl der Idle-Prozesse';
$lng['serversettings']['phpfpm_settings']['min_spare_servers']['description'] = 'Hinweis: Nur wenn PM auf \'dynamic/ondemand\' steht<br />Wichtig: Pflichtangabe wenn PM auf \'dynamic/ondemand\' steht';
$lng['serversettings']['phpfpm_settings']['max_spare_servers']['title'] = 'Maximale Anzahl der Idle-Prozesse';
$lng['serversettings']['phpfpm_settings']['max_spare_servers']['description'] = 'Hinweis: Nur wenn PM auf \'dynamic/ondemand\' steht<br />Wichtig: Pflichtangabe wenn PM auf \'dynamic/ondemand\' steht';
$lng['serversettings']['phpfpm_settings']['max_requests']['title'] = 'Requests pro Kindprozess bevor Neuerstellung (respawning)';
$lng['serversettings']['phpfpm_settings']['max_requests']['description'] = 'Für keine Begrenzung \'0\' angeben. Equivalent zu PHP_FCGI_MAX_REQUESTS.';
$lng['error']['phpfpmstillenabled'] = 'PHP-FPM ist derzeit aktiviert. Bitte deaktiviere es, um FCGID zu aktivieren';
$lng['error']['fcgidstillenabled'] = 'FCGID ist derzeit aktiviert. Bitte deaktiviere es, um PHP-FPM zu aktivieren';
$lng['phpfpm']['vhost_httpuser'] = 'Lokaler Benutzer für PHP-FPM (Froxlor Vhost)';
$lng['phpfpm']['vhost_httpgroup'] = 'Lokale Gruppe für PHP-FPM (Froxlor Vhost)';
$lng['phpfpm']['ownvhost']['title'] = 'Verwende PHP-FPM im Froxlor Vhost';
$lng['phpfpm']['ownvhost']['description'] = 'Wenn verwendet, wird Froxlor selbst unter einem lokalem Benutzer ausgeführt';

// ADDED IN FROXLOR 0.9.17
$lng['crondesc']['cron_usage_report'] = 'Sende Reports über Webspace- und Trafficverbrauch';
$lng['serversettings']['report']['report'] = 'Aktiviere das Senden von Reports über Webspace- und Trafficverbrauch';
$lng['serversettings']['report']['webmax'] = 'Warn-Level in Prozent für Webspace';
$lng['serversettings']['report']['trafficmax'] = 'Warn-Level in Prozent für Traffic';
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
$lng['mails']['webmaxpercent']['mailbody'] = 'Sehr geehrte(r) {NAME},\n\nSie haben bereits {DISKUSED} MB von Ihren insgesamt {DISKAVAILABLE} MB Speicherplatz verbraucht.\nDies sind mehr als {MAX_PERCENT}%.\n\nVielen Dank,\nIhr Administrator';
$lng['mails']['webmaxpercent']['subject'] = 'Sie erreichen bald Ihr Speicherplatz-Limit';
$lng['mysql']['database_edit'] = 'Datenbank bearbeiten';

// ADDED IN FROXLOR 0.9.18
$lng['error']['domains_cantdeletedomainwithaliases'] = 'Sie können keine Domain löschen, die noch von Alias-Domains verwendet wird. Löschen Sie zuerst alle Alias-Domains dieser Domain.';
$lng['serversettings']['default_theme'] = 'Standard Theme';
$lng['menue']['main']['changetheme'] = 'Theme wechseln';
$lng['panel']['theme'] = 'Theme';
$lng['success']['rebuildingconfigs'] = 'Task für das Neuerstellen der Konfigurationen wurde erfolgreich eingetragen';
$lng['panel']['variable'] = 'Variable';
$lng['panel']['description'] = 'Beschreibung';
$lng['emails']['back_to_overview'] = 'Zurück zur Übersicht';

// ADDED IN FROXLOR 0.9.20
$lng['error']['user_banned'] = 'Ihr Benutzerkonto wurde gesperrt. Bitte kontaktieren Sie Ihren Administrator für weitere Informationen.';
$lng['serversettings']['validate_domain'] = 'Validiere Domainnamen';
$lng['login']['combination_not_found'] = 'Kombination aus Benutzername und E-Mail Adresse stimmen nicht überein.';
$lng['customer']['generated_pwd'] = 'Passwortvorschlag';
$lng['customer']['usedmax'] = 'Benutzt / Max.';
$lng['admin']['traffic'] = 'Datentransfer';
$lng['admin']['customertraffic'] = 'Kunden';
$lng['traffic']['customer'] = 'Kunde';
$lng['traffic']['trafficoverview'] = 'Übersicht Datentransfervolumen je';
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
$lng['error']['admin_domain_emailsystemhostname'] = 'Der System - Hostname kann leider nicht als Kundendomain verwendet werden.';
$lng['backup'] = 'Backup';
$lng['backup_allowed'] = 'Backup erlaubt';
$lng['extras']['backup_create'] = 'Backup erstellen?';
$lng['extras']['backup_info'] = 'Das Backup wird täglich in einem FTP Verzeichnis abgelegt. Der FTP Username ist "<Froxloruser>_backup". Das FTP Passwort ist das gleiche wie bei ihrem Haupt FTP Account.';
$lng['extras']['backup_info_sep'] = 'Es sind komprimierte Archive von Ihrem Webverzeichnis und Ihren Datenbanken enthalten.';
$lng['extras']['backup_info_big'] = 'Es ist ein komprimiertes Archiv von Ihrem Webverzeichnis und Ihren Datenbanken enthalten.';
$lng['extras']['backup_count_info'] = '<br /><br />Beachten Sie bitte, dass das Backup den verfügbaren Speicherplatz belastet!';
$lng['serversettings']['backup_count'] = 'Soll die Größe des Backups vom verfügbaren Webspace-Limit abgezogen werden?';
$lng['serversettings']['backup_enabled'] = 'Backup aktivieren?';
$lng['serversettings']['backup_ftp_enabled'] = 'FTP Upload aktivieren?';
$lng['serversettings']['backup_ftp_server'] = 'FTP Server:';
$lng['serversettings']['backup_ftp_user'] = 'FTP Benutzer:';
$lng['serversettings']['backup_ftp_pass'] = 'FTP Passwort:';
$lng['serversettings']['backupdir']['description'] = 'Pfad des Backup-Verzeichnisses?';
$lng['serversettings']['mysqldump_path']['description'] = 'Pfad zum mysqldump Programm:';
$lng['serversettings']['backup_count'] = 'Soll die Größe des Backups vom verfügbaren Webspace abgezogen werden?';
$lng['crondesc']['cron_backup'] = 'Backup Cronjob';

// ADDED IN FROXLOR 0.9.21
$lng['gender']['title'] = 'Geschlecht';
$lng['gender']['male'] = 'Herr';
$lng['gender']['female'] = 'Frau';
$lng['gender']['undef'] = '';
$lng['serversettings']['backup_ftp_passive_mode'] = 'Passiven Übertragungsmodus verwenden';
$lng['serversettings']['backup_bigfile'] = 'Backup von Kundenverzeichnissen und Datenbanken in eine Datei speichern, statt zu splitten?';

// ADDED IN FROXLOR 0.9.22-svn1
$lng['diskquota'] = 'Quota';
$lng['serversettings']['diskquota_enabled'] = 'Quota aktiviert?';
$lng['serversettings']['diskquota_repquota_path']['description'] = 'Pfad zu repquota';
$lng['serversettings']['diskquota_quotatool_path']['description'] = 'Pfad zu quotatool';
$lng['serversettings']['diskquota_customer_partition']['description'] = 'Partition, auf welcher die Kundendaten liegen';
$lng['tasks']['diskspace_set_quota'] = 'Quota auf dem Dateisystem setzen';
$lng['error']['session_timeout'] = 'Wert zu niedrig';
$lng['error']['session_timeout_desc'] = 'Der Wert der Session Timeout sollte nicht unter einer Minute liegen.';

// ADDED IN FROXLOR 0.9.24-svn1
$lng['logrotate'] = 'Logrotate';
$lng['logrotate_enabled'] = 'Logrotate aktivieren?';
$lng['logrotate_binary'] = 'Pfad zum logrotate binary?';
$lng['logrotate_interval'] = 'Intervall?';
$lng['logrotate_keep'] = 'Wie viele Logdateien sollen aufbewahrt werden?';
$lng['admin']['assignedmax'] = 'Zugewiesen / Max.';
$lng['admin']['usedmax'] = 'Benutzt / Max.';
$lng['admin']['used'] = 'Benutzt';
$lng['mysql']['size'] = 'Datenbankgröße (MB)';

$lng['error']['invalidhostname'] = 'Hostname darf nicht leer sein oder nur aus Leerzeichen bestehen';

$lng['traffic']['http'] = 'HTTP (MB)';
$lng['traffic']['ftp'] = 'FTP (MB)';
$lng['traffic']['mail'] = 'Mail (MB)';

// ADDED IN 0.9.27-svn1
$lng['serversettings']['mod_fcgid']['idle_timeout']['title'] = 'Idle Timeout';
$lng['serversettings']['mod_fcgid']['idle_timeout']['description'] = 'Timeout einstellung für Mod FastCGI.';
$lng['serversettings']['phpfpm_settings']['idle_timeout']['title'] = 'Idle Timeout';
$lng['serversettings']['phpfpm_settings']['idle_timeout']['description'] = 'Timeout einstellung für PHP5 FPM FastCGI.';

// ADDED IN 0.9.27-svn2
$lng['panel']['cancel'] = 'abbrechen';
$lng['admin']['delete_statistics'] = 'Statistiken Löschen';
$lng['admin']['speciallogwarning'] = 'ACHTUNG: Durch diese Einstellungen werden Sie alle bisherige Statistiken dieser Domain verlieren. Wenn Sie dabei wirklich sicher sind, geben Sie bitte folgenden Text in das nachfolgende Textfeld ein: "'.$lng['admin']['delete_statistics'].'" und bestätigen Sie mit "'.$lng['panel']['delete'].'".<br /><br />';

// ADDED IN 0.9.28-svn5
$lng['error']['operationnotpermitted'] = 'Diese Aktion ist nicht erlaubt!';
$lng['error']['featureisdisabled'] = 'Die Funktion %s wurde deaktiviert. Kontaktieren Sie bitte Ihren Dienstleister.';
$lng['serversettings']['catchall_enabled']['title']  = 'Catchall verwenden';
$lng['serversettings']['catchall_enabled']['description']  = 'Möchten Sie Ihren Kunden die Funktion Catchall zur Verfügung stellen?';

// ADDED IN 0.9.28.svn6
$lng['serversettings']['apache_24'] = 'Anpassungen f&uuml;r Apache 2.4 verwenden';
$lng['admin']['tickets_see_all'] = 'Kann alle Ticket-Kategorien sehen?';
$lng['serversettings']['nginx_fastcgiparams']['title'] = 'Pfad zur fastcgi_params Datei';
$lng['serversettings']['nginx_fastcgiparams']['description'] = 'Geben Sie den Pfad zu nginx\'s fastcgi_params Datei an. Inlkusive Dateiname!';
$lng['serversettings']['enablewebfonts']['title'] = 'Verwende Google Webfonts im Panel';
$lng['serversettings']['enablewebfonts']['description'] = 'Wenn aktiviert, wird die angegebene Google-Schriftart eingebunden und verwendet';
$lng['serversettings']['definewebfont']['title'] = '<a href="http://www.google.com/webfonts" rel="external">Google Webfont</a> festlegen';
$lng['serversettings']['definewebfont']['description'] = 'Wenn aktiviert, wird diese Schriftart im Panel verwendet.<br />Hinweis: Leerzeichen bitte mit einem "+" ersetzen, z.B. "Open+Sans"';
