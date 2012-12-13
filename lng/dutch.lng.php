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
 * @author     Sander Klein <roedie@roedie.nl>
 * @author     Frits Letteboer <f.letteboer@radiotwenterand.nl>
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Language
 *
 */

/**
 * Global
 */

$lng['translator'] = 'Sander Klein/Frits Letteboer';
$lng['panel']['edit'] = 'bewerken';
$lng['panel']['delete'] = 'verwijderen';
$lng['panel']['create'] = 'nieuw';
$lng['panel']['save'] = 'opslaan';
$lng['panel']['yes'] = 'ja';
$lng['panel']['no'] = 'nee';
$lng['panel']['emptyfornochanges'] = 'leeg laten voor huidige instelling';
$lng['panel']['emptyfordefault'] = 'leeg laten voor de standaard instellingen';
$lng['panel']['path'] = 'Pad';
$lng['panel']['toggle'] = 'In- of uitschalen';
$lng['panel']['next'] = 'volgende';
$lng['panel']['dirsmissing'] = 'Kan de map niet lezen of vinden!';

/**
 * Login
 */

$lng['login']['username'] = 'Gebruikersnaam';
$lng['login']['password'] = 'Wachtwoord';
$lng['login']['language'] = 'Taal';
$lng['login']['login'] = 'Inloggen';
$lng['login']['logout'] = 'Uitloggen';
$lng['login']['profile_lng'] = 'Profiel taal';

/**
 * Customer
 */

$lng['customer']['documentroot'] = 'Home directory';
$lng['customer']['name'] = 'Naam';
$lng['customer']['firstname'] = 'Voornaam';
$lng['customer']['company'] = 'Bedrijfsnaam';
$lng['customer']['street'] = 'Straat';
$lng['customer']['zipcode'] = 'Postcode';
$lng['customer']['city'] = 'Plaats';
$lng['customer']['phone'] = 'Telefoonnummer';
$lng['customer']['fax'] = 'Faxnummer';
$lng['customer']['email'] = 'Email';
$lng['customer']['customernumber'] = 'Klant ID';
$lng['customer']['diskspace'] = 'Webruimte (MB)';
$lng['customer']['traffic'] = 'Verkeer (GB)';
$lng['customer']['mysqls'] = 'MySQL-Databases';
$lng['customer']['emails'] = 'E-mail-Adressen';
$lng['customer']['accounts'] = 'E-mail-Accounts';
$lng['customer']['forwarders'] = 'E-mail-Forwarders';
$lng['customer']['ftps'] = 'FTP-Accounts';
$lng['customer']['subdomains'] = 'Sub-Domein(en)';
$lng['customer']['domains'] = 'Domein(en)';
$lng['customer']['unlimited'] = 'onbeperkt';

/**
 * Customermenue
 */

$lng['menue']['main']['main'] = 'Main';
$lng['menue']['main']['changepassword'] = 'Wijzig wachtwoord';
$lng['menue']['main']['changelanguage'] = 'Wijzig taal';
$lng['menue']['email']['email'] = 'E-mail';
$lng['menue']['email']['emails'] = 'Adressen';
$lng['menue']['email']['webmail'] = 'WebMail';
$lng['menue']['mysql']['mysql'] = 'MySQL';
$lng['menue']['mysql']['databases'] = 'Databases';
$lng['menue']['mysql']['phpmyadmin'] = 'phpMyAdmin';
$lng['menue']['domains']['domains'] = 'Domeinen';
$lng['menue']['domains']['settings'] = 'Instellingen';
$lng['menue']['ftp']['ftp'] = 'FTP';
$lng['menue']['ftp']['accounts'] = 'Accounts';
$lng['menue']['ftp']['webftp'] = 'WebFTP';
$lng['menue']['extras']['extras'] = 'Extras';
$lng['menue']['extras']['directoryprotection'] = 'Map beveiliging';
$lng['menue']['extras']['pathoptions'] = 'pad opties';

/**
 * Index
 */

$lng['index']['customerdetails'] = 'Klant Details';
$lng['index']['accountdetails'] = 'Account Details';

/**
 * Change Password
 */

$lng['changepassword']['old_password'] = 'Oud wachtwoord';
$lng['changepassword']['new_password'] = 'Nieuw wachtwoord';
$lng['changepassword']['new_password_confirm'] = 'Nieuw wacthwoord (bevestigen)';
$lng['changepassword']['new_password_ifnotempty'] = 'Nieuw wachtwoord (leeg = niet veranderen)';
$lng['changepassword']['also_change_ftp'] = ' wijzig ook het wachtwoord van het hoofd FTP account';

/**
 * Domains
 */

$lng['domains']['description'] = 'Hier kunt u nieuwe (sub-) domeinen maken en de paden aanpassen.<br />Het systeem heeft een paar minuten nodig om de wijzigingen door te voeren na iedere varandering.';
$lng['domains']['domainsettings'] = 'Domein instellingen';
$lng['domains']['domainname'] = 'Domeinnaam';
$lng['domains']['subdomain_add'] = 'Maak subdomein';
$lng['domains']['subdomain_edit'] = 'Bewerk (sub)domein';
$lng['domains']['wildcarddomain'] = 'Maak als wildcarddomein?';
$lng['domains']['aliasdomain'] = 'Alias voor domein';
$lng['domains']['noaliasdomain'] = 'Geen alias domein';

/**
 * E-mails
 */

$lng['emails']['description'] = 'Hier kunt u e-mail adressen maken en wijzigen.<br />Een aacount is net als een brievenbus voor uw huis. Als iemand u mail stuurd word dit op uw account bezorgt.<br /><br />Om uw emails te downloaden moet u het volgende installen in uw mail programma: (De <i>schuigedrukte</i> gegevens moeten gewijzigd worden in hetgeen dat u ingegeven heeft!)<br />Servernaam: <b><i>Domeinnaam</i></b><br />Gebruikersnaam: <b><i>Account naam / e-mail adres</i></b><br />Wachtwoord: <b><i>het door u ingegeven wachtwoord</i></b>';
$lng['emails']['emailaddress'] = 'E-mail adres';
$lng['emails']['emails_add'] = 'Maak nieuw e-mail adres';
$lng['emails']['emails_edit'] = 'Bewerk e-mail-adres';
$lng['emails']['catchall'] = 'Catchall';
$lng['emails']['iscatchall'] = 'Definieer als catchall-adres?';
$lng['emails']['account'] = 'Account';
$lng['emails']['account_add'] = 'Maak nieuw account';
$lng['emails']['account_delete'] = 'Verwijder account';
$lng['emails']['from'] = 'Van';
$lng['emails']['to'] = 'Aan';
$lng['emails']['forwarders'] = 'Forwarders';
$lng['emails']['forwarder_add'] = 'Maak forwarder';

/**
 * FTP
 */

$lng['ftp']['description'] = 'Hier kunt u nieuwe FTP accounts maken of bestaande accounts wijzigen.<br />De wijzigingen worden direct doorgevoerd en het account kan direct gebruikt worden.';
$lng['ftp']['account_add'] = 'Maak nieuw account';

/**
 * MySQL
 */

$lng['mysql']['databasename'] = 'gebruiker/database naam';
$lng['mysql']['databasedescription'] = 'database omschrijving';
$lng['mysql']['database_create'] = 'Maak database';

/**
 * Extras
 */

$lng['extras']['description'] = 'Hier kunt u wat extra instellingen doen zoals map beveiliging.<br />Het systeem heeft enkele minuten nodig om elke wijziging door te voeren.';
$lng['extras']['directoryprotection_add'] = 'Map beveiliging toevoegen';
$lng['extras']['view_directory'] = 'map inhoud laten zien';
$lng['extras']['pathoptions_add'] = 'Pad opties toevoegen';
$lng['extras']['directory_browsing'] = 'map inhoud browsen';
$lng['extras']['pathoptions_edit'] = 'Pad opties bewerken';
$lng['extras']['error404path'] = '404';
$lng['extras']['error403path'] = '403';
$lng['extras']['error500path'] = '500';
$lng['extras']['error401path'] = '401';
$lng['extras']['errordocument404path'] = 'URL naar Foutdocument 404';
$lng['extras']['errordocument403path'] = 'URL naar Foutdocument 403';
$lng['extras']['errordocument500path'] = 'URL naar Foutdocument 500';
$lng['extras']['errordocument401path'] = 'URL naar Foutducument 401';

/**
 * Errors
 */

$lng['error']['error'] = 'Fout';
$lng['error']['directorymustexist'] = 'De map %s bestaat niet. Maak hem eerst aan met uw FTP client.';
$lng['error']['filemustexist'] = 'Het bestand %s bestaat niet.';
$lng['error']['allresourcesused'] = 'U heeft al uw resources al gebruikt.';
$lng['error']['domains_cantdeletemaindomain'] = 'U kunt een domein dat gebruikt word als email-domein niet verwijderen.';
$lng['error']['domains_canteditdomain'] = 'U kunt dit domein niet aanpassen. Dit is door de admin onbruikbaar gemaakt.';
$lng['error']['domains_cantdeletedomainwithemail'] = 'U kunt een domein dat gebruikt word als email-domein niet verwijderen. Verwijder eerst alle e-mail adressen.';
$lng['error']['firstdeleteallsubdomains'] = 'U moet eerst alle subdomeinen verwijderen voor u een wildcard domein kunt maken.';
$lng['error']['youhavealreadyacatchallforthisdomain'] = 'U heeft al een catchall voor dit domein aangemaakt.';
$lng['error']['ftp_cantdeletemainaccount'] = 'U kunt uw hoofd FTP account niet verwijderen';
$lng['error']['login'] = 'De door u ingegeven gebruikersnaam en wacthwoord zijn verkeerd. Probeer opnieuw!';
$lng['error']['login_blocked'] = 'Dit account is inactief vanwege teveel login fouten. <br />Probeer het nog eens over ' . $settings['login']['deactivatetime'] . ' seconden.';
$lng['error']['notallreqfieldsorerrors'] = 'U heeft niet alle velden goed, of helemaal niet ingevuld.';
$lng['error']['oldpasswordnotcorrect'] = 'Het oude wachtwoord is niet correct.';
$lng['error']['youcantallocatemorethanyouhave'] = 'U kunt niet meer resources gebruiken dan dat u bezit.';
$lng['error']['mustbeurl'] = 'U heeft geen goed of compleet URL ingegeven (bijv. http://eenserver.com/error404.htm)';
$lng['error']['invalidpath'] = 'U heeft geen goed URL ingegeven (misschien een probleem met dirlisting?)';
$lng['error']['stringisempty'] = 'Geen waarde in invoerveld';
$lng['error']['stringiswrong'] = 'Verkeerde waarde in invoerveld';
$lng['error']['myloginname'] = '\'' . $lng['login']['username'] . '\'';
$lng['error']['mypassword'] = '\'' . $lng['login']['password'] . '\'';
$lng['error']['oldpassword'] = '\'' . $lng['changepassword']['old_password'] . '\'';
$lng['error']['newpassword'] = '\'' . $lng['changepassword']['new_password'] . '\'';
$lng['error']['newpasswordconfirm'] = '\'' . $lng['changepassword']['new_password_confirm'] . '\'';
$lng['error']['newpasswordconfirmerror'] = 'Het nieuwe wacthwoord en de bevestiging zijn niet gelijk';
$lng['error']['myname'] = '\'' . $lng['customer']['name'] . '\'';
$lng['error']['myfirstname'] = '\'' . $lng['customer']['firstname'] . '\'';
$lng['error']['emailadd'] = '\'' . $lng['customer']['email'] . '\'';
$lng['error']['mydomain'] = '\'Domain\'';
$lng['error']['mydocumentroot'] = '\'Documentroot\'';
$lng['error']['loginnameexists'] = 'Loginnaam %s bestaat al';
$lng['error']['emailiswrong'] = 'E-mail Adres %s bevat illegale karakters of is niet compleet';
$lng['error']['loginnameiswrong'] = 'Loginnaame %s bevat illegale karakters';
$lng['error']['userpathcombinationdupe'] = 'Combinatie van Gebruikersnaam en Pad bestaat reeds';
$lng['error']['patherror'] = 'Generale Fout! pad kan niet leeg zijn';
$lng['error']['errordocpathdupe'] = 'Optie voor pad %s bestaat reeds';
$lng['error']['adduserfirst'] = 'Maak klant eerst aan, aub';
$lng['error']['domainalreadyexists'] = 'Het domein %s is al aan een klant toegewezen';
$lng['error']['nolanguageselect'] = 'Geen taal geselecteerd.';
$lng['error']['nosubjectcreate'] = 'U moet een onderwerp ingeven voor dit e-mail sjabloon.';
$lng['error']['nomailbodycreate'] = 'U moet een tekst ingeven voor dit e-mail sjabloon.';
$lng['error']['templatenotfound'] = 'Sjabloon niet gevonden.';
$lng['error']['alltemplatesdefined'] = 'U kunt niet meer sjablonen definieeren, alle talen worden al ondersteund.';
$lng['error']['wwwnotallowed'] = 'www is niet toegestaan voor subdomeinen.';
$lng['error']['subdomainiswrong'] = 'Het subdomein %s bevat illegale karakters.';
$lng['error']['domaincantbeempty'] = 'De domeinnaam kan niet leeg zijn.';
$lng['error']['domainexistalready'] = 'Het domein %s bestaads reeds.';
$lng['error']['domainisaliasorothercustomer'] = 'Het geselecteerde alias domein verwijsd naar zichzelf of is van een andere gebruiker.';
$lng['error']['emailexistalready'] = 'Het e-mail adres %s bestaat reeds.';
$lng['error']['maindomainnonexist'] = 'Het hoofd-domein %s bestaat niet.';
$lng['error']['destinationnonexist'] = 'Maak uw forwarder in het veld \'Destination\' alstublieft.';
$lng['error']['destinationalreadyexistasmail'] = 'De forwarder naar %s bestaat reeds als actief e-mail adres.';
$lng['error']['destinationalreadyexist'] = 'U heeft al een forwarder die verwijst naar %s .';
$lng['error']['destinationiswrong'] = 'De forwarder naar %s bevat illegale karakter(s) of is niet compleet.';
$lng['error']['domainname'] = $lng['domains']['domainname'];

/**
 * Questions
 */

$lng['question']['question'] = 'Beveiligings vraag';
$lng['question']['admin_customer_reallydelete'] = 'Weet u zeker dat u de klant %s wilt verwijderen? Dit kan niet ongedaan worden gemaakt!';
$lng['question']['admin_domain_reallydelete'] = 'Weet u zeker dat u het domein %s wilt verwijderen?';
$lng['question']['admin_domain_reallydisablesecuritysetting'] = 'Weet u echt heel zeker dat deze beveiligings instellingen wilt deactiveren (OpenBasedir)?';
$lng['question']['admin_admin_reallydelete'] = 'Weet u zeker dat u de admin %s verwijderen wilt? Iedere klant en domein zal worden toegewezen aan de hoofd administrator.';
$lng['question']['admin_template_reallydelete'] = 'Weet u zeker dat u het sjabloon \'%s\' verwijderen wilt?';
$lng['question']['domains_reallydelete'] = 'Weet u zeker dat u het domein %s verwijderen wilt?';
$lng['question']['email_reallydelete'] = 'Weet u zeker dat u het e-mail adres %s verwijderen wilt?';
$lng['question']['email_reallydelete_account'] = 'Weet u zeker dat het e-mail account van %s verwijderen wilt?';
$lng['question']['email_reallydelete_forwarder'] = 'Weet u zeker dat u de forwarder %s verwijderen wilt?';
$lng['question']['extras_reallydelete'] = 'Weet u zeker dat u de map beveiliging voor de map %s verwijderen wilt?';
$lng['question']['extras_reallydelete_pathoptions'] = 'Weet u zeker dat u de pad-opties voor %s verwijderen wilt?';
$lng['question']['ftp_reallydelete'] = 'Weet u zeker dat u het FTP account %s verwijderen wilt?';
$lng['question']['mysql_reallydelete'] = 'Weet u zeker dat u de database %s verwijderen wilt? Dit kan niet ongedaan gemaakt worden!';
$lng['question']['admin_configs_reallyrebuild'] = 'Weet u zeker dat u de configuratie bestanden voor Apache en Bind opnieuw wilt opbouwen?';

/**
 * Mails
 */

$lng['mails']['pop_success']['mailbody'] = 'Hallo,\n\nUw mail account {EMAIL}\nis succesvol aangemaakt.\n\nDit is een automatisch verstuurde\ne-mail, beantwoord deze niet AUB!\n\nMet vriendelijke groet, uw beheerder';
$lng['mails']['pop_success']['subject'] = 'Mail account succesvol aangemaakt';
$lng['mails']['createcustomer']['mailbody'] = 'Hallo {FIRSTNAME} {NAME},\n\nhierbij uw account informatie:\n\nGebruikersnaam: {USERNAME}\nWachtwoord: {PASSWORD}\n\nMet vriendelijke groet,\nuw beheerder';
$lng['mails']['createcustomer']['subject'] = 'Account informatie';

/**
 * Admin
 */

$lng['admin']['overview'] = 'Overzicht';
$lng['admin']['ressourcedetails'] = 'Gebruikte resources';
$lng['admin']['systemdetails'] = 'Systeem Details';
$lng['admin']['froxlordetails'] = 'Froxlor Details';
$lng['admin']['installedversion'] = 'Geinstalleerde Versie';
$lng['admin']['latestversion'] = 'Laatste Versie';
$lng['admin']['lookfornewversion']['clickhere'] = 'zoeken via webservice';
$lng['admin']['lookfornewversion']['error'] = 'Fout tijdens lezen';
$lng['admin']['resources'] = 'Resources';
$lng['admin']['customer'] = 'Klant';
$lng['admin']['customers'] = 'Klanten';
$lng['admin']['customer_add'] = 'Maak klant';
$lng['admin']['customer_edit'] = 'Bewerk klant';
$lng['admin']['domains'] = 'Domeinen';
$lng['admin']['domain_add'] = 'Maak domein';
$lng['admin']['domain_edit'] = 'Bewerk domein';
$lng['admin']['subdomainforemail'] = 'Subdomein als emaildomein';
$lng['admin']['admin'] = 'Beheerder';
$lng['admin']['admins'] = 'Beheerders';
$lng['admin']['admin_add'] = 'Maak beheerder';
$lng['admin']['admin_edit'] = 'Bewerk beheerder';
$lng['admin']['customers_see_all'] = 'Kan alle klanten zien?';
$lng['admin']['domains_see_all'] = 'Kan alle domeinen zien?';
$lng['admin']['change_serversettings'] = 'Kan server instellingen aanpassen?';
$lng['admin']['server'] = 'Server';
$lng['admin']['serversettings'] = 'Instellingen';
$lng['admin']['rebuildconf'] = 'Configuratie bestanden opnieuw aanmaken';
$lng['admin']['stdsubdomain'] = 'Standaard subdomein';
$lng['admin']['stdsubdomain_add'] = 'Maak standard subdomein';
$lng['admin']['deactivated'] = 'Gedeactieveerd';
$lng['admin']['deactivated_user'] = 'Gebruiker deactiveren';
$lng['admin']['sendpassword'] = 'Verstuur wachtwoord';
$lng['admin']['ownvhostsettings'] = 'Eigen vHost-Instellingen';
$lng['admin']['configfiles']['serverconfiguration'] = 'Configuratie';
$lng['admin']['configfiles']['files'] = '<b>Configuratiebestanden:</b> Wijzig de volgende bestanden of maak ze aan met<br />de volgende inhoud als u dit nog niet gedaan heeft.<br /><b>Let Op:</b> Het MySQL-wachtwoord is niet aangepast vanwege beveiligings overwegingen.<br />Vervang "MYSQL_PASSWORD" zelf. Als u uw MYSQl wachtwoord vergeten bent<br />kunt u het terugvinden in "lib/userdata.inc.php".';
$lng['admin']['configfiles']['commands'] = '<b>Commando\'s:</b> Start de volgende commando\'s in een shell.';
$lng['admin']['configfiles']['restart'] = '<b>Herstarten:</b> Start de volgende commando\'s in een shell zodat de configuratie opnieuw geladen wordt.';
$lng['admin']['templates']['templates'] = 'Sjablonen';
$lng['admin']['templates']['template_add'] = 'Maak sjabloon';
$lng['admin']['templates']['template_edit'] = 'Bewerk sjabloon';
$lng['admin']['templates']['action'] = 'Actie';
$lng['admin']['templates']['email'] = 'E-Mail';
$lng['admin']['templates']['subject'] = 'Onderwerp';
$lng['admin']['templates']['mailbody'] = 'Mail inhoud';
$lng['admin']['templates']['createcustomer'] = 'Welkomst bericht voor nieuwe klanten';
$lng['admin']['templates']['pop_success'] = 'Welkomst bericht voor e-mail nieuw account';
$lng['admin']['templates']['template_replace_vars'] = 'Variabelen die aangepast worden in het sjabloon:';
$lng['admin']['templates']['FIRSTNAME'] = 'Vervangen door de voornaam van de klant.';
$lng['admin']['templates']['NAME'] = 'Vervangen door de naam van de klant.';
$lng['admin']['templates']['USERNAME'] = 'Vervangen door de gebruikersnaam van de klant.';
$lng['admin']['templates']['PASSWORD'] = 'Vervangen door het wachtwoord van de klant.';
$lng['admin']['templates']['EMAIL'] = 'Vervangen door het adres van het POP3/IMAP account.';

/**
 * Serversettings
 */

$lng['serversettings']['session_timeout']['title'] = 'Sessie Timeout';
$lng['serversettings']['session_timeout']['description'] = 'Hoe lang moet een gebruiker inactief zijn voor dat de sessie ongeldig wordt (seconden)?';
$lng['serversettings']['accountprefix']['title'] = 'Klant Voorvoegsel';
$lng['serversettings']['accountprefix']['description'] = 'Welk voorvoegsel moet een klant account hebben?';
$lng['serversettings']['mysqlprefix']['title'] = 'SQL Voorvoegsel';
$lng['serversettings']['mysqlprefix']['description'] = 'Welk voorvoegsel moet een mysql account hebben?';
$lng['serversettings']['ftpprefix']['title'] = 'FTP Voorvoegsel';
$lng['serversettings']['ftpprefix']['description'] = 'Welk voorvoegsel moet een FTP account hebben?';
$lng['serversettings']['documentroot_prefix']['title'] = 'Document map';
$lng['serversettings']['documentroot_prefix']['description'] = 'Waar zullen alle gegeven opgeslagen worden?';
$lng['serversettings']['logfiles_directory']['title'] = 'Logfiles map';
$lng['serversettings']['logfiles_directory']['description'] = 'Waar zullen alle log-file opgeslagen worden?';
$lng['serversettings']['ipaddress']['title'] = 'IP-Adres';
$lng['serversettings']['ipaddress']['description'] = 'Wat is het IP-adres van deze server?';
$lng['serversettings']['hostname']['title'] = 'Hostnaam';
$lng['serversettings']['hostname']['description'] = 'Wat is de hostnaam van deze server?';
$lng['serversettings']['apachereload_command']['title'] = 'Apache reload commando';
$lng['serversettings']['apachereload_command']['description'] = 'Wat is het commando op apache te herladen?';
$lng['serversettings']['bindconf_directory']['title'] = 'Bind configuratie map';
$lng['serversettings']['bindconf_directory']['description'] = 'Waar staan de bind configuratie bestanden?';
$lng['serversettings']['bindreload_command']['title'] = 'Bind reload commando';
$lng['serversettings']['bindreload_command']['description'] = 'Wat is het command om bind te herladen?';
$lng['serversettings']['binddefaultzone']['title'] = 'Bind default zone';
$lng['serversettings']['binddefaultzone']['description'] = 'Wat is de naam van de default zone?';
$lng['serversettings']['vmail_uid']['title'] = 'Mails-Uid';
$lng['serversettings']['vmail_uid']['description'] = 'Welk UserID moeten de e-mails hebben?';
$lng['serversettings']['vmail_gid']['title'] = 'Mails-Gid';
$lng['serversettings']['vmail_gid']['description'] = 'Welke GroupID moeten e-mails hebben?';
$lng['serversettings']['vmail_homedir']['title'] = 'Mails-Homedir';
$lng['serversettings']['vmail_homedir']['description'] = 'Waar moeten alle e-mail opgeslagen worden?';
$lng['serversettings']['adminmail']['title'] = 'Afzender';
$lng['serversettings']['adminmail']['description'] = 'Wat is de afzender voor e-mail verstuurd vanuit het Panel?';
$lng['serversettings']['phpmyadmin_url']['title'] = 'phpMyAdmin URL';
$lng['serversettings']['phpmyadmin_url']['description'] = 'Wat is de URL die verwijst naar phpMyAdmin? (moet beginnen met http://)';
$lng['serversettings']['webmail_url']['title'] = 'WebMail URL';
$lng['serversettings']['webmail_url']['description'] = 'Wat is de URL die verwijst naar WebMail? (moet beginnen met http://)';
$lng['serversettings']['webftp_url']['title'] = 'WebFTP URL';
$lng['serversettings']['webftp_url']['description'] = 'Wat is de URL die verwijst naar WebFTP? (moet beginnen met http://)';
$lng['serversettings']['language']['description'] = 'Wat is uw standaard server taal?';
$lng['serversettings']['maxloginattempts']['title'] = 'Maximaal aantal inlog pogingen';
$lng['serversettings']['maxloginattempts']['description'] = 'Maximaam aantal inlog pogingen voor het account gedeactiveerd wordt.';
$lng['serversettings']['deactivatetime']['title'] = 'Deactivatie Tijd';
$lng['serversettings']['deactivatetime']['description'] = 'Tijd (in seconden) dat een account gedeactiveerd word na te veel inlogpogingen.';
$lng['serversettings']['pathedit']['title'] = 'Manier van Pad ingeven';
$lng['serversettings']['pathedit']['description'] = 'Moet het pad geselecteerd worden met een \'dropdown\' menu of met een invoerveld?';

/**
 * CHANGED BETWEEN 1.2.12 and 1.2.13
 */

$lng['mysql']['description'] = 'Hier kunt u MySQL-Databases maken en wijzigen.<br />De wijzigingen worden direct gemaakt en de database kan direkt gebruikt worden.<br />In het menu dat links staat vind u de tool phpMyAdmin welke u kunt gebruiken om uw database makkelijk te beheren.<br /><br />Om gebruikt te maken van uw database in uw eigen php programmas kunt u de volgende instellingen gebruiken: (De gegeven in <i>italics</i> moeten aangepast worden in wat u ingevoerd heeft!)<br />Hostnaam: <b><SQL_HOST></b><br />Gebruikersnaam: <b><i>Databasenaam</i></b><br />Wachtwoord: <b><i>het wachtwoord dat u gekozen heeft</i></b><br />Database: <b><i>Databasenaam</i></b>';

/**
 * ADDED BETWEEN 1.2.12 and 1.2.13
 */

$lng['serversettings']['paging']['title'] = 'Vermeldingen per pagina';
$lng['serversettings']['paging']['description'] = 'Hoeveel vermeldingen er getoond moeten worden per pagina? (0 = alles laten zien)';
$lng['error']['ipstillhasdomains'] = 'De IP/Port combinatie die u verwijderen wilt heeft nog domeinen toegewezen, wijs deze opnieuw to aan andere IP/Poort combinaties voordat u deze IP/Poort combinatie verwijderd.';
$lng['error']['cantdeletedefaultip'] = 'U kunt de standaard reseller IP/Poort combinatie niet verwijderen, maak eerst een andere IP/Port combinatie standaard voor reseller voor dat u deze IP/Port combinatie verwijderd.';
$lng['error']['cantdeletesystemip'] = 'U kunt het laatste IP/Poort combinatie van het systeem niet verwijderen, maak eerste een andere IP/Port combinatie aan voor het systeem of wijzig het ipadres van het systeem.';
$lng['error']['myipaddress'] = '\'IP\'';
$lng['error']['myport'] = '\'Poort\'';
$lng['error']['myipdefault'] = 'U moet een IP/Poort combinatie selecteren die standaard moet worden.';
$lng['error']['myipnotdouble'] = 'Deze IP/Poort combinatie bestaat reeds.';
$lng['question']['admin_ip_reallydelete'] = 'Weet u zeker dat u het IP adres %s verwijderen wilt?';
$lng['admin']['ipsandports']['ipsandports'] = 'IP-adressen en Poorten';
$lng['admin']['ipsandports']['add'] = 'Maak IP/Poort';
$lng['admin']['ipsandports']['edit'] = 'Bewerk IP/Poort';
$lng['admin']['ipsandports']['ipandport'] = 'IP/Poort';
$lng['admin']['ipsandports']['ip'] = 'IP';
$lng['admin']['ipsandports']['port'] = 'Poort';

// ADDED IN 1.2.13-rc3

$lng['error']['cantchangesystemip'] = 'U kunt het laatste system IP niet wijzigen, maak eerst een nieuwe IP/Poort cominatie aan of wijzig het ip-adres van het systeem.';
$lng['question']['admin_domain_reallydocrootoutofcustomerroot'] = 'Weet u zeker dat u de document root voor dit domein niet in de klant-root van de klant wil hebben?';

// ADDED IN 1.2.14-rc1

$lng['admin']['memorylimitdisabled'] = 'Gedeactiveerd';
$lng['domain']['openbasedirpath'] = 'OpenBasedir-pad';
$lng['domain']['docroot'] = 'Pad van bovenstaand veld';
$lng['domain']['homedir'] = 'Home directory';
$lng['admin']['valuemandatory'] = 'Deze waarde is verplicht';
$lng['admin']['valuemandatorycompany'] = 'De waarde "naam" en "voornaam" of "bedrijf" moet ingevoerd worden';
$lng['menue']['main']['username'] = 'Ingelogged als: ';
$lng['panel']['urloverridespath'] = 'URL (Vervangd path)';
$lng['panel']['pathorurl'] = 'Pad of URL';
$lng['error']['sessiontimeoutiswrong'] = 'Alleen nummerieke "Session Timeout" zijn toegestaan.';
$lng['error']['maxloginattemptsiswrong'] = 'Alleen nummerieke "Maximaal aantal inlogpogingen" zijn toegestaan.';
$lng['error']['deactivatetimiswrong'] = 'Allee nummerieke "Deactivatie Tijd" zijn toegestaan.';
$lng['error']['accountprefixiswrong'] = 'Het "Klan voorvoegsel" is verkeerd.';
$lng['error']['mysqlprefixiswrong'] = 'Het "SQL voorvoegsel" is verkeerd.';
$lng['error']['ftpprefixiswrong'] = 'Het "FTP voorvoegsel" is verkeerd.';
$lng['error']['ipiswrong'] = 'Het "IP-Adres" is verkeerd. Alleen een geldig ip-adres is toegestaan.';
$lng['error']['vmailuidiswrong'] = 'Het "Mails-uid" is verkeerd. Alleen een nummeriek UID is toegestaan.';
$lng['error']['vmailgidiswrong'] = 'Het "Mails-gid" is verkeerd. Alleen een nummeriek GID is toegestaan.';
$lng['error']['adminmailiswrong'] = 'Het "Afzender-adres" is verkeerd. Alleen geldige e-mail adressen zijn toegestaan.';
$lng['error']['pagingiswrong'] = 'Het aantal "Vermeldingen per pagina" is verkeerd. Alleen nummerieke karakters zijn toegestaan.';
$lng['error']['phpmyadminiswrong'] = 'De phpMyAdmin-link is niet een geldige link.';
$lng['error']['webmailiswrong'] = 'De WebMail-link is niet een geldige link.';
$lng['error']['webftpiswrong'] = 'De WebFTP-link is niet een geldige link.';
$lng['domains']['hasaliasdomains'] = 'Heeft alias domein(en)';
$lng['serversettings']['defaultip']['title'] = 'Standaard IP/Poort';
$lng['serversettings']['defaultip']['description'] = 'Wat is de standaard IP/Poort combinatie?';
$lng['domains']['statstics'] = 'Gebruiks Statistieken';
$lng['panel']['ascending'] = 'oplopend';
$lng['panel']['decending'] = 'aflopend';
$lng['panel']['search'] = 'Zoeken';
$lng['panel']['used'] = 'gebruikt';

// ADDED IN 1.2.14-rc3

$lng['panel']['translator'] = 'Vertaler';

// ADDED IN 1.2.14-rc4

$lng['error']['stringformaterror'] = 'De waarde voor het veld "%s" is niet in het verwachte formaat.';

// ADDED IN 1.2.15-rc1

$lng['admin']['serversoftware'] = 'Serversoftware';
$lng['admin']['phpversion'] = 'PHP-Versie';
$lng['admin']['phpmemorylimit'] = 'PHP-Geheugen-Limiet';
$lng['admin']['mysqlserverversion'] = 'MySQL Server Versie';
$lng['admin']['mysqlclientversion'] = 'MySQL Client Versie';
$lng['admin']['webserverinterface'] = 'Webserver Interface';
$lng['domains']['isassigneddomain'] = 'Is toegewezen domein';
$lng['serversettings']['phpappendopenbasedir']['title'] = 'Pad wat toegevoegd word aan OpenBasedir';
$lng['serversettings']['phpappendopenbasedir']['description'] = 'Deze paden (gescheiden door dubbele punten) zullen worden toegevoegd aan het OpenBasedir-statement in iedere vhost-container.';

// CHANGED IN 1.2.15-rc1

$lng['error']['loginnameissystemaccount'] = 'U kunt geen accounts aanmaken die gelijk zijn aan systeem accounts (bijvoorbeeld beginnend met "%s"). Kies een andere accountnaam AUB.';
$lng['error']['youcantdeleteyourself'] = 'U kunt uw eigen account, omwille van veiligheidsredenen, niet verwijderen.';
$lng['error']['youcanteditallfieldsofyourself'] = 'Opmerking: U kunt, om veiligheidsredenen, niet alle velden van uw account aanpassen.';

// ADDED IN 1.2.16-svn1

$lng['serversettings']['natsorting']['title'] = 'Gebruik een natuurlijke manier van sorteren';
$lng['serversettings']['natsorting']['description'] = 'Lijsten worden gesorteerd zoals web1 -> web2 -> web11 inplaats van web1 -> web11 -> web2.';

// ADDED IN 1.2.16-svn2

$lng['serversettings']['deactivateddocroot']['title'] = 'Pad naar webinhoud voor gedeactiveerde gebruikers';
$lng['serversettings']['deactivateddocroot']['description'] = 'Wanneer een gebruiker geactiveerd is, wordt dit pad gebruikt voor zijn/haar webinhoud.';

// ADDED IN 1.2.16-svn4

$lng['panel']['reset'] = 'wijzigingen verwerpen';
$lng['admin']['accountsettings'] = 'Account-instellingen';
$lng['admin']['panelsettings'] = 'Paneel-instellingen';
$lng['admin']['systemsettings'] = 'Systeem-instellingen';
$lng['admin']['webserversettings'] = 'Webserver-instellingen';
$lng['admin']['mailserversettings'] = 'Mailserver-instellingen';
$lng['admin']['nameserversettings'] = 'Nameserver-instellingen';
$lng['admin']['updatecounters'] = 'Gebruikte bronnen hercalculeren';
$lng['question']['admin_counters_reallyupdate'] = 'Weet u zeker dat u gebruikte bronnen wilt hercalculeren?';
$lng['panel']['pathDescription'] = 'Indien de map niet bestaat wordt deze automatisch aangemaakt.<br /><br />Indien u wilt doorverwijzen naar een ander domein dient deze te beginnen met http:// of https://';

// ADDED IN 1.2.16-svn6

$lng['mails']['trafficninetypercent']['mailbody'] = 'Beste {NAME},\n\nU hebt {TRAFFICUSED} MB van de beschikbare {TRAFFIC} MB verbruikt.\nDit is meer dan 90%.\n\nMet vriendelijke groet, uw beheerder';
$lng['mails']['trafficninetypercent']['subject'] = 'Limiet dataverkeer bereikt';
$lng['admin']['templates']['trafficninetypercent'] = 'E-mail ter notificatie aan klanten indien zij 90 procent van het dataverkeer is verbruikt';
$lng['admin']['templates']['TRAFFIC'] = 'Wordt vervangen door aan klant toegewezen dataverkeer.';
$lng['admin']['templates']['TRAFFICUSED'] = 'Wordt vervangen door het verbruikte dataverkeer.';

// ADDED IN 1.2.16-svn7

$lng['admin']['subcanemaildomain']['never'] = 'Nooit';
$lng['admin']['subcanemaildomain']['choosableno'] = 'Kiesbaar, standaard nee';
$lng['admin']['subcanemaildomain']['choosableyes'] = 'Kiesbaar, standaard ja';
$lng['admin']['subcanemaildomain']['always'] = 'Altijd';
$lng['changepassword']['also_change_webalizer'] = ' wijzig ook het wachtwoord van de webalizer-statistieken';

// ADDED IN 1.2.16-svn8

$lng['serversettings']['mailpwcleartext']['title'] = 'Sla het wachtwoord ook onversleuteld op in de database';
$lng['serversettings']['mailpwcleartext']['description'] = 'Indien ingesteld op JA worden wachtwoorden in klare tekst opgeslagen in de database (zichtbaar voor iedereen die toegang heeft tot de tabel mail_users). Activeer dit alleen wanneer u gebruik gaat maken van SASL!';
$lng['serversettings']['mailpwcleartext']['removelink'] = 'Klik hier om alle onversleutelde wachtwoorden uit de database te verwijderen';
$lng['question']['admin_cleartextmailpws_reallywipe'] = 'Weet u zeker dat u alle onversleutelde wachtwoorden wilt verwijderen? Deze opdracht is niet terug te draaien!';
$lng['admin']['configfiles']['overview'] = 'Overzicht';
$lng['admin']['configfiles']['wizard'] = 'Wizard';
$lng['admin']['configfiles']['distribution'] = 'Distributie';
$lng['admin']['configfiles']['service'] = 'Dienst';
$lng['admin']['configfiles']['daemon'] = 'Daemon';
$lng['admin']['configfiles']['http'] = 'Webserver (HTTP)';
$lng['admin']['configfiles']['dns'] = 'Nameserver (DNS)';
$lng['admin']['configfiles']['mail'] = 'Mailserver (IMAP/POP3)';
$lng['admin']['configfiles']['smtp'] = 'Mailserver (SMTP)';
$lng['admin']['configfiles']['ftp'] = 'FTP-Server';
$lng['admin']['configfiles']['etc'] = 'Overigen (Systeem)';
$lng['admin']['configfiles']['choosedistribution'] = '-- Kies een distributie --';
$lng['admin']['configfiles']['chooseservice'] = '-- Kies een dienst --';
$lng['admin']['configfiles']['choosedaemon'] = '-- Kies een daemon --';

// ADDED IN 1.2.16-svn10

$lng['serversettings']['ftpdomain']['title'] = 'FTP accounts @domein';
$lng['serversettings']['ftpdomain']['description'] = 'Kunnen klanten FTP-accounts in de vorm gebruiker@domein aanmaken?';
$lng['panel']['back'] = 'Back';

// ADDED IN 1.2.16-svn12

$lng['serversettings']['mod_log_sql']['title'] = 'Logs tijdelijk opslaan in de database';
$lng['serversettings']['mod_log_sql']['description'] = 'Gebruike <a target="blank" href="http://www.outoforder.cc/projects/apache/mod_log_sql/" title="mod_log_sql">mod_log_sql</a> om toegangslogs tijdelijk in de database op te slaan<br /><b>Dit vereist een speciale <a target="blank" href="http://files.froxlor.org/docs/mod_log_sql/" title="mod_log_sql - documentation">configuratie van Apache</a>!</b>';
$lng['serversettings']['mod_fcgid']['title'] = 'PHP insluiten via mod_fcgid/suexec';
$lng['serversettings']['mod_fcgid']['description'] = 'Gebruik mod_fcgid/suexec/libnss_mysql om PHP uit te voeren onder het gebruikersaccount.<br/><b>Dit vereist een aangepaste configuratie van de webserver. Alle volgende optie\'s zijn alleen geldig wanneer deze module actief is.</b>';
$lng['serversettings']['sendalternativemail']['title'] = 'Gebruik alternatief emailadres';
$lng['serversettings']['sendalternativemail']['description'] = 'Stuur het wachtwoord naar een ander adres dan het adres dat opgegeven werd tijdens het aanmaken van het emailadres.';
$lng['emails']['alternative_emailaddress'] = 'Alternatief emailadres';
$lng['mails']['pop_success_alternative']['mailbody'] = 'Hallo,\n\nuw mailaccount {EMAIL}\nis met succes opgezet.\nUw wachtwoord is {PASSWORD}.\n\nDit is een automatisch gegenereerde\ne-mail, u kunt hierop niet antwoorden!\n\nMet vriendelijk groet, uw beheerder';
$lng['mails']['pop_success_alternative']['subject'] = 'Mailaccount actief gemaakt';
$lng['admin']['templates']['pop_success_alternative'] = 'Welkomstmail voor nieuwe emailaccounts, gestuurd naar een alternatief emailadres';
$lng['admin']['templates']['EMAIL_PASSWORD'] = 'Vervangen door het POP3/IMAP-wachtwoord.';

// ADDED IN 1.2.16-svn13

$lng['error']['documentrootexists'] = 'De map "%s" voor deze klant bestaat reeds. Verwijder deze map alvorens het account aan te maken.';

// ADDED IN 1.2.16-svn14

$lng['serversettings']['apacheconf_vhost']['title'] = 'Bestands-/mapnaam voor vhost-configuratie webserver';
$lng['serversettings']['apacheconf_vhost']['description'] = 'Waar dient het vhost-configuratiebestand opgeslagen te worden? U kunt hier zowel een bestand (alle configuratie\'s in 1 bestand) of een map (apart bestand voor iedere configuratie) opgeven.';
$lng['serversettings']['apacheconf_diroptions']['title'] = 'Bestands-/mapnaam voor diroptions-configuratie webserver';
$lng['serversettings']['apacheconf_diroptions']['description'] = 'Waar dient het diroptions-configuratiebestand opgeslagen te worden? U kunt hier zowel een bestand (alle configuratie\'s in 1 bestand) of een map (apart bestand voor iedere configuratie) opgeven.';
$lng['serversettings']['apacheconf_htpasswddir']['title'] = 'Mapnaam htpasswd-bestanden webserver';
$lng['serversettings']['apacheconf_htpasswddir']['description'] = 'Waar dienen de htpasswd-bestanden, voor beveiligde toegang, opgeslagen te worden?';

// ADDED IN 1.2.16-svn15

$lng['error']['formtokencompromised'] = 'Het verzoek lijkt te zijn gecompromitteerd. U bent veiligheidshalve uitgelogd.';
$lng['serversettings']['mysql_access_host']['title'] = 'Toegangshosts voor MySQL';
$lng['serversettings']['mysql_access_host']['description'] = 'Een door komma\'s gescheiden lijst met hosts waarvandaan gebruikers verbinding mogen maken met de MySQL-server.';

// ADDED IN 1.2.18-svn1

$lng['admin']['ipsandports']['create_listen_statement'] = '\'Listen\'-regel genereren';
$lng['admin']['ipsandports']['create_namevirtualhost_statement'] = '\'NameVirtualHost\'-regel genereren';
$lng['admin']['ipsandports']['create_vhostcontainer'] = 'vHost-Container genereren';
$lng['admin']['ipsandports']['create_vhostcontainer_servername_statement'] = '\'ServerName\'-regel vHost-Container genereren';

// ADDED IN 1.2.18-svn2

$lng['admin']['webalizersettings'] = 'Instellingen voor Webalize';
$lng['admin']['webalizer']['normal'] = 'Normaal';
$lng['admin']['webalizer']['quiet'] = 'Stil';
$lng['admin']['webalizer']['veryquiet'] = 'Geen uitvoer';
$lng['serversettings']['webalizer_quiet']['title'] = 'Uitvoer Webalizer';
$lng['serversettings']['webalizer_quiet']['description'] = 'Informatieniveau van Webalizer';

// ADDED IN 1.2.18-svn3

$lng['ticket']['admin_email'] = 'root@localhost';
$lng['ticket']['noreply_email'] = 'tickets@froxlor';
$lng['admin']['ticketsystem'] = 'Ondersteuningstickets';
$lng['menue']['ticket']['ticket'] = 'Ondersteuningstickets';
$lng['menue']['ticket']['categories'] = 'Ondersteuningscategorieën';
$lng['menue']['ticket']['archive'] = 'Ticket-archief';
$lng['ticket']['description'] = 'Hier kunt u hulpverzoeken naar uw beheerder sturen.<br /> Notificatie\'s worden verzonden via email.';
$lng['ticket']['ticket_new'] = 'Een nieuw ticket openen';
$lng['ticket']['ticket_reply'] = 'Ticket beantwoorden';
$lng['ticket']['ticket_reopen'] = 'Ticket heropenen';
$lng['ticket']['ticket_newcateory'] = 'Nieuwe categorie maken';
$lng['ticket']['ticket_editcateory'] = 'Categorie bewerken';
$lng['ticket']['ticket_view'] = 'Ticketverloop weergeven';
$lng['ticket']['ticketcount'] = 'Tickets';
$lng['ticket']['ticket_answers'] = 'Antwoorden';
$lng['ticket']['lastchange'] = 'Laatste actie';
$lng['ticket']['subject'] = 'Onderwerp';
$lng['ticket']['status'] = 'Status';
$lng['ticket']['lastreplier'] = 'Laatste beantwoorder';
$lng['ticket']['priority'] = 'Prioriteit';
$lng['ticket']['low'] = 'Laag';
$lng['ticket']['normal'] = 'Normaal';
$lng['ticket']['high'] = 'Hoog';
$lng['ticket']['lastchange'] = 'Laatste wijziging';
$lng['ticket']['lastchange_from'] = 'Datum vanaf (dd.mm.yyyy)';
$lng['ticket']['lastchange_to'] = 'Datum tot (dd.mm.yyyy)';
$lng['ticket']['category'] = 'Categorie';
$lng['ticket']['no_cat'] = 'Geen';
$lng['ticket']['message'] = 'Bericht';
$lng['ticket']['show'] = 'Tonen';
$lng['ticket']['answer'] = 'Beantwoorden';
$lng['ticket']['close'] = 'Sluiten';
$lng['ticket']['reopen'] = 'Heropenen';
$lng['ticket']['archive'] = 'Archiveren';
$lng['ticket']['ticket_delete'] = 'Ticket verwijderen';
$lng['ticket']['lastarchived'] = 'Recentelijk ontvangen tickets';
$lng['ticket']['archivedtime'] = 'Gearchiveerd';
$lng['ticket']['open'] = 'Openen';
$lng['ticket']['wait_reply'] = 'Gereed voor antwoord';
$lng['ticket']['replied'] = 'Beantwoord';
$lng['ticket']['closed'] = 'Gesloten';
$lng['ticket']['staff'] = 'Staf';
$lng['ticket']['customer'] = 'Klant';
$lng['ticket']['old_tickets'] = 'Berichten voor ticket';
$lng['ticket']['search'] = 'Archief doorzoeken';
$lng['ticket']['nocustomer'] = 'Geen keuze';
$lng['ticket']['archivesearch'] = 'Zoekresultaten archief';
$lng['ticket']['noresults'] = 'Geen resultaten gevonden';
$lng['ticket']['notmorethanxopentickets'] = 'Omwille van spambeveiliging kunt u niet meer dan %s tickets open hebben';
$lng['ticket']['supportstatus'] = 'Status support';
$lng['ticket']['supportavailable'] = '<span class="ticket_low">Onze ondersteuningsmedewerkers zijn beschikbaar.</span>';
$lng['ticket']['supportnotavailable'] = '<span class="ticket_high">Onze ondersteuningsmedewerkers zijn niet beschikbaar</span>';
$lng['admin']['templates']['ticket'] = 'Notificatie-mails voor ondersteuningstickets';
$lng['admin']['templates']['SUBJECT'] = 'Wordt vervangen door het onderwerp van het ondersteuni';
$lng['admin']['templates']['new_ticket_for_customer'] = 'Informatie voor de klant dat het ticket is verstuurd';
$lng['admin']['templates']['new_ticket_by_customer'] = 'Notificatie voor beheerder';
$lng['admin']['templates']['new_reply_ticket_by_customer'] = 'Notificatie voor beheerder voor antwoord van klant';
$lng['admin']['templates']['new_ticket_by_staff'] = 'Notificatie voor klant van ticket geopend door stafleden';
$lng['admin']['templates']['new_reply_ticket_by_staff'] = 'Notificatie voor klant van antwoorden door stafleden';
$lng['mails']['new_ticket_for_customer']['mailbody'] = 'Hallo {FIRSTNAME} {NAME},\n\nuw ondersteuningsticket met het onderwerp "{SUBJECT}" is verstuurd.\n\nU krijgt bericht wanneer uw ticket beantwoord is.\n\nMet vriendelijke groet,\nuw beheerder';
$lng['mails']['new_ticket_for_customer']['subject'] = 'Uw ondersteuningsticket is verzonden';
$lng['mails']['new_ticket_by_customer']['mailbody'] = 'Hallo beheerder,\n\neen nieuw ondersteuningsticket met onderwerp "{SUBJECT}" is verstuurd.\n\nU dient in te loggen om het ticket te behandelen.\n\nMet vriendelijke groet,\nuw beheerder';
$lng['mails']['new_ticket_by_customer']['subject'] = 'Nieuw ondersteuningsticket verzonden';
$lng['mails']['new_reply_ticket_by_customer']['mailbody'] = 'Hallo beheerder,\n\nhet ondersteuningsticket "{SUBJECT}" is beantwoord door een klant.\n\nU dient in te loggen om het ticket te behandelen.\n\nMet vriendelijk groet,\nuw beheerder';
$lng['mails']['new_reply_ticket_by_customer']['subject'] = 'Nieuw antwoord op ondersteuningsticket';
$lng['mails']['new_ticket_by_staff']['mailbody'] = 'Hallo {FIRSTNAME} {NAME},\n\neen ondersteuningsticket met onderwerp "{SUBJECT}" is voor u geopend.\n\nU dient in te loggen om het ticket te bekijken.\n\nMet vriendelijk groet,\nuw beheerder';
$lng['mails']['new_ticket_by_staff']['subject'] = 'Nieuw ondersteuningsticket verzonden';
$lng['mails']['new_reply_ticket_by_staff']['mailbody'] = 'Hallo {FIRSTNAME} {NAME},\n\nhet ondersteuningsticket met onderwerp "{SUBJECT}" is door onze staf beantwoord.\n\nU dient in te loggen om het ticket te bekijken.\n\nMet vriendelijk groet,\nuw beheerder';
$lng['mails']['new_reply_ticket_by_staff']['subject'] = 'Nieuw antwoord op ondersteuningsticket';
$lng['question']['ticket_reallyclose'] = 'Weet u zeker dat u ticket "%s" wilt sluiten?';
$lng['question']['ticket_reallydelete'] = 'Weet u zeker dat u ticket "%s" wilt verwijderen?';
$lng['question']['ticket_reallydeletecat'] = 'Weet u zeker dat u de categorie "%s" wilt verwijderen?';
$lng['question']['ticket_reallyarchive'] = 'Weet u zeker dat u ticket "%s" wilt archiveren?';
$lng['error']['mysubject'] = '\'' . $lng['ticket']['subject'] . '\'';
$lng['error']['mymessage'] = '\'' . $lng['ticket']['message'] . '\'';
$lng['error']['mycategory'] = '\'' . $lng['ticket']['category'] . '\'';
$lng['error']['nomoreticketsavailable'] = 'U hebt al uw beschikbare tickets verbruikt. Neem contact op met uw beheerder.';
$lng['error']['nocustomerforticket'] = 'U kunt geen tickets aanmaken zonder gebruikers';
$lng['error']['categoryhastickets'] = 'Deze categorie bevat nog tickets.<br />Verwijder de tickets eerst alvorens de categorie te verwijderen';
$lng['error']['notmorethanxopentickets'] = $lng['ticket']['notmorethanxopentickets'];
$lng['admin']['ticketsettings'] = 'Instellingen voor ondersteuningstickets';
$lng['admin']['archivelastrun'] = 'Laatste archivering tickets';
$lng['serversettings']['ticket']['noreply_email']['title'] = 'Emailadres voor geen-antwoord';
$lng['serversettings']['ticket']['noreply_email']['description'] = 'Het adres van de afzender, in de meeste gevallen zoiets als no-reply@domein.tld';
$lng['serversettings']['ticket']['worktime_begin']['title'] = 'Aanvang beschikbaarheid ondersteuning (hh:mm)';
$lng['serversettings']['ticket']['worktime_begin']['description'] = 'Tijd vanaf beschikbaarheid ondersteuning';
$lng['serversettings']['ticket']['worktime_end']['title'] = 'Eindtijd beschikbaarheid onder steuning (hh:mm)';
$lng['serversettings']['ticket']['worktime_end']['description'] = 'Eindtijd beschikbaarheid ondersteuning';
$lng['serversettings']['ticket']['worktime_sat'] = 'Ondersteuning beschikbaar op zaterdagen?';
$lng['serversettings']['ticket']['worktime_sun'] = 'Ondersteuning beschikbaar op zondagen?';
$lng['serversettings']['ticket']['worktime_all']['title'] = 'Geen tijdlimiet voor ondersteuning';
$lng['serversettings']['ticket']['worktime_all']['description'] = 'Indien "Ja" worden de instelling voor de tijd overschreven';
$lng['serversettings']['ticket']['archiving_days'] = 'Na hoeveel dagen dienen gesloten tickets te worden gearchiveerd?';
$lng['customer']['tickets'] = 'Ondersteuningstickets';

// ADDED IN 1.2.18-svn4

$lng['admin']['domain_nocustomeraddingavailable'] = 'Het is niet mogelijk een domein toe te voegen. U dient tenminste een klant aan te maken.';
$lng['serversettings']['ticket']['enable'] = 'Ticketsysteem inschakelijk';
$lng['serversettings']['ticket']['concurrentlyopen'] = 'Hoeveel tickets kunnen per keer open staan?';
$lng['error']['norepymailiswrong'] = 'Het "geen-antwoord-adres" is onjuist. Alleen geldige emailadressen zijn toegestaan.';
$lng['error']['tadminmailiswrong'] = 'Het "Ticketbeheerder-adres" is onjuist. Alleen geldige emailadressen zijn toegestaan.';
$lng['ticket']['awaitingticketreply'] = 'U hebt %s onbeantwoorde ondersteuningsticket(s)';

// ADDED IN 1.2.18-svn5

$lng['serversettings']['ticket']['noreply_name'] = 'Afzender van emailas ondersteuningsticket';

// ADDED IN 1.2.19-svn1

$lng['serversettings']['mod_fcgid']['configdir']['title'] = 'Configuratiemap';
$lng['serversettings']['mod_fcgid']['configdir']['description'] = 'Waar dienen alle configuratiebestanden voor FCGID te worden opgeslagen? Indien u geen aangepaste versie van SuExec gebruikt, zoals gebruikelijk is, dient dit pad onder /var/www/ te liggen';
$lng['serversettings']['mod_fcgid']['tmpdir']['title'] = 'Map voor tijdelijke bestanden';

// ADDED IN 1.2.19-svn3

$lng['serversettings']['ticket']['reset_cycle']['title'] = 'Cyclus voor opnieuw instellen gebruikte tickets';
$lng['serversettings']['ticket']['reset_cycle']['description'] = 'Stelt het door klant gebruikte tickets in op 0 na deze periode';
$lng['admin']['tickets']['daily'] = 'Dagelijks';
$lng['admin']['tickets']['weekly'] = 'Wekelijks';
$lng['admin']['tickets']['monthly'] = 'Maandelijks';
$lng['admin']['tickets']['yearly'] = 'Jaarlijks';
$lng['error']['ticketresetcycleiswrong'] = 'De cyclus dient "Dagelijks", "Wekelijks", "Maandelijks" of "Jaarlijks" te zijn.';

// ADDED IN 1.2.19-svn4

$lng['menue']['traffic']['traffic'] = 'Dataverkeer';
$lng['menue']['traffic']['current'] = 'Deze maand';
$lng['traffic']['month'] = "Maand";
$lng['traffic']['day'] = "Dag";
$lng['traffic']['months'][1] = "Januari";
$lng['traffic']['months'][2] = "Februari";
$lng['traffic']['months'][3] = "Maart";
$lng['traffic']['months'][4] = "April";
$lng['traffic']['months'][5] = "Mei";
$lng['traffic']['months'][6] = "Juni";
$lng['traffic']['months'][7] = "Juli";
$lng['traffic']['months'][8] = "Augustus";
$lng['traffic']['months'][9] = "September";
$lng['traffic']['months'][10] = "Oktober";
$lng['traffic']['months'][11] = "November";
$lng['traffic']['months'][12] = "December";
$lng['traffic']['mb'] = "Datavekeer (MB)";
$lng['traffic']['distribution'] = '<font color="#019522">FTP</font> | <font color="#0000FF">HTTP</font> | <font color="#800000">Mail</font>';
$lng['traffic']['sumhttp'] = 'Samenvatting HTTP-verkeer in';
$lng['traffic']['sumftp'] = 'Samenvatting FTP-verkeer in';
$lng['traffic']['summail'] = 'Samenvatting Mail-verkeer in';

// ADDED IN 1.2.19-svn4.5

$lng['serversettings']['no_robots']['title'] = 'Zoekmachines toestaan uw Froxlor-installatie te indexeren';

// ADDED IN 1.2.19-svn6

$lng['admin']['loggersettings'] = 'Instellingen voor logs';
$lng['serversettings']['logger']['enable'] = 'Logs in-/uitgeschakeld';
$lng['serversettings']['logger']['severity'] = 'Logniveau';
$lng['admin']['logger']['normal'] = 'normaal';
$lng['admin']['logger']['paranoid'] = 'paranoide';
$lng['serversettings']['logger']['types']['title'] = 'Log-type(s)';
$lng['serversettings']['logger']['types']['description'] = 'Om meerdere types te selecteren, houd u CTRL ingedrukt terwijl u selecteert.<br />Beschikbare types zijn: syslog, bestand, mysql';
$lng['serversettings']['logger']['logfile'] = 'Pad naar logfile, inclusief bestandsnaam';
$lng['error']['logerror'] = 'Log-Fout: %s';
$lng['serversettings']['logger']['logcron'] = 'Cronjobs loggen (eenmalig)';
$lng['question']['logger_reallytruncate'] = 'Weet u zeker dat u de tabel "%s" wilt legen?';
$lng['admin']['loggersystem'] = 'Systeemlog';
$lng['menue']['logger']['logger'] = 'Systeemlog';
$lng['logger']['date'] = 'Datum';
$lng['logger']['type'] = 'Type';
$lng['logger']['action'] = 'Actie';
$lng['logger']['user'] = 'Gebruiker';
$lng['logger']['truncate'] = 'Log legen';

// ADDED IN 1.2.19-svn7

$lng['serversettings']['ssl']['use_ssl'] = 'Gebruik SSL';
$lng['serversettings']['ssl']['ssl_cert_file'] = 'Pad naar SSL-certificaat';
$lng['serversettings']['ssl']['openssl_cnf'] = 'Standaardinstellingen certificaat';
$lng['panel']['reseller'] = 'wederverkoper';
$lng['panel']['admin'] = 'beheerder';
$lng['panel']['customer'] = 'klant(en)';
$lng['error']['nomessagetosend'] = 'U hebt geen bericht opgegeven.';
$lng['error']['noreceipientsgiven'] = 'U hebt geen ontvanger opgegeven';
$lng['admin']['emaildomain'] = 'Emaildomein';
$lng['admin']['email_only'] = 'Alleen email?';
$lng['admin']['wwwserveralias'] = 'Voeg een "www." ServerAlias toe';
$lng['admin']['ipsandports']['enable_ssl'] = 'Is dit een SSL-poort?';
$lng['admin']['ipsandports']['ssl_cert_file'] = 'Pad naar SSL-certificaat';
$lng['panel']['send'] = 'verzenden';
$lng['admin']['subject'] = 'Onderwerp';
$lng['admin']['receipient'] = 'Ontvanger';
$lng['admin']['message'] = 'Bericht schrijven';
$lng['admin']['text'] = 'Bericht';
$lng['menu']['message'] = 'Berichten';
$lng['error']['errorsendingmail'] = 'Het versturen van het bericht naar "%s" is mislukt';
$lng['error']['cannotreaddir'] = 'De map "%s" kan niet gelezen worden';
$lng['message']['success'] = 'Bericht verzonden naar ontvagers %s';
$lng['message']['noreceipients'] = 'Er is geen email verstuurd omdat er geen ontvangers in de database zijn';
$lng['admin']['sslsettings'] = 'Instellingen voor SSL';
$lng['cronjobs']['notyetrun'] = 'Nog niet uitgevoerd';
$lng['serversettings']['default_vhostconf']['title'] = 'Standaard vhost-instellingen';
$lng['serversettings']['default_vhostconf']['description'] = 'De inhoud van dit veld wordt rechtstreeks in de vhost-container geplaatst. N.B.: Deze code wordt niet op fouten gecontroleerd. In geval van fouten kan het zijn dat de webserver niet meer start!';
$lng['error']['invalidip'] = '%s is een ongeldig IP-adres';
$lng['serversettings']['decimal_places'] = 'Aantal getallen achter de komma in uitvoer dataverkeer';

// ADDED IN 1.2.19-svn8

$lng['admin']['dkimsettings'] = 'Instellingen voor DomainKeys';
$lng['dkim']['dkim_prefix']['title'] = 'Prefix';
$lng['dkim']['dkim_prefix']['description'] = 'Geef het pad naar de DKIM RSA-files alsook naar de configuratie van de Milter-plugin';
$lng['dkim']['dkim_domains']['title'] = 'Bestandsnaam domeinen';
$lng['dkim']['dkim_domains']['description'] = '<em>Bestandsnaam</em> van het DKIM Domains-parameter zoals aangegeven in de configuratie van dkim-milter';
$lng['dkim']['dkim_dkimkeys']['title'] = 'KeyList filename';
$lng['dkim']['dkim_dkimkeys']['description'] = '<em>Bestandsnaam</em> van het DKIM KeyList-parameter zoals aangegeven in de configuratie van dkim-milter';
$lng['dkim']['dkimrestart_command']['title'] = 'Herstart-commando voor Milter';
$lng['dkim']['dkimrestart_command']['description'] = 'Geef het commando om de milter-plugin te herstarten';

// ADDED IN 1.2.19-svn9

$lng['admin']['caneditphpsettings'] = 'Can change php-related domain settings?';

// ADDED IN 1.2.19-svn12

$lng['admin']['allips'] = 'Alle IP\'s';
$lng['panel']['nosslipsavailable'] = 'Er zijn op dit moment geen SSL IP/poorten beschikbaar';
$lng['ticket']['by'] = 'door';
$lng['dkim']['use_dkim']['title'] = 'Activeer ondersteuning voor DKIM?';
$lng['dkim']['use_dkim']['description'] = 'Wilt u gebruikmaken van Domain Keys (DKIM) systeem?';
$lng['error']['invalidmysqlhost'] = 'Ongeldig adres voor MySQL-host: %s';
$lng['error']['cannotuseawstatsandwebalizeratonetime'] = 'U kunt Webalizer en AWstats niet tegelijkertijd gebruiken. Kies een van de twee.';
$lng['serversettings']['webalizer_enabled'] = 'Webalizer activeren';
$lng['serversettings']['awstats_enabled'] = 'AWstats activeren';
$lng['admin']['awstatssettings'] = 'Instellingen voor AWstats';

// ADDED IN 1.2.19-svn16

$lng['admin']['domain_dns_settings'] = 'DNS-instellingen voor domein';
$lng['dns']['destinationip'] = 'IP domein';
$lng['dns']['standardip'] = 'Standaard server IP';
$lng['dns']['a_record'] = 'A-record (IPv6 optioneel)';
$lng['dns']['cname_record'] = 'CNAME-record';
$lng['dns']['mxrecords'] = 'MX-records';
$lng['dns']['standardmx'] = 'Standaard server MX-record';
$lng['dns']['mxconfig'] = 'Aangepaste MX-records';
$lng['dns']['priority10'] = 'Prioriteit 10';
$lng['dns']['priority20'] = 'Prioriteit 20';
$lng['dns']['txtrecords'] = 'TXT-records';
$lng['dns']['txtexample'] = 'Voorbeeld (SPF-regel):<br />v=spf1 ip4:xxx.xxx.xx.0/23 -all';
$lng['serversettings']['selfdns']['title'] = 'Instellingen voor klantdomein';
$lng['serversettings']['selfdnscustomer']['title'] = 'Klanten toestaan de DNS-instellingen van het domein te wijzigen';
$lng['admin']['activated'] = 'Geactiveerd';
$lng['admin']['statisticsettings'] = 'Instellingen voor statistieken';
$lng['admin']['or'] = 'of';

// ADDED IN 1.2.19-svn17

$lng['serversettings']['unix_names']['title'] = 'Gebruik gebruikersnamen die compatible zijn met UNIX';
$lng['serversettings']['unix_names']['description'] = 'Staat het gebruik van <strong>-</strong> en <strong>_</strong> in gebruikersnaam toe, indien ingesteld op <strong>Nee</strong>';
$lng['error']['cannotwritetologfile'] = 'Kan logbestand %s niet openen om naartoe te schrijven';
$lng['admin']['sysload'] = 'Systeembelasting';
$lng['admin']['noloadavailable'] = 'niet beschikbaar';
$lng['admin']['nouptimeavailable'] = 'niet beschikbaar';
$lng['panel']['backtooverview'] = 'Terug naar overzicht';
$lng['admin']['nosubject'] = '(Geen onderwerp)';
$lng['admin']['configfiles']['statistics'] = 'Statistieken';
$lng['login']['forgotpwd'] = 'Wachtwoord vergeten?';
$lng['login']['presend'] = 'Wachtwoord opnieuw instellen';
$lng['login']['email'] = 'E-mailadres';
$lng['login']['remind'] = 'Mijn wachtwoord opnieuw instellen';
$lng['login']['usernotfound'] = 'Gebruiker niet gevonden!';
$lng['pwdreminder']['subject'] = 'Froxlor - Wachtwoord opnieuw instellen';
$lng['pwdreminder']['body'] = 'Hallo %s,\n\nuw wachtwoord voor Froxlor is opnieuw ingesteld!\nHet nieuwe wachtwoord is: %p\n\nMet vriendelijke groet,\nuw beheerder';
$lng['pwdreminder']['success'] = 'Wachtwoord opnieuw ingesteld.<br />U ontvangt spoedig een e-mail met uw nieuwe wachtwoord.';

// ADDED IN 1.2.19-svn18

$lng['serversettings']['allow_password_reset']['title'] = 'Klanten toestaan hun wachtwoord opnieuw in te stellen';
$lng['pwdreminder']['notallowed'] = 'Het opnieuw instellen van wachtwoorden is uitgeschakeld';

// ADDED IN 1.2.19-svn20

$lng['serversettings']['awstats_path']['title'] = 'Pad naar AWstats cgi-bin-map';
$lng['serversettings']['awstats_path']['description'] = 'bijvoorbeeld /usr/share/webapps/awstats/6.1/webroot/cgi-bin/';
$lng['serversettings']['awstats_updateall_command']['title'] = 'Pad naar "awstats_updateall.pl"';
$lng['serversettings']['awstats_updateall_command']['description'] = 'bijvoorbeeld /usr/bin/awstats_updateall.pl';

// ADDED IN 1.2.19-svn21

$lng['customer']['title'] = 'Titel';
$lng['customer']['country'] = 'Land';
$lng['panel']['dateformat'] = 'YYYY-MM-DD';
$lng['panel']['dateformat_function'] = 'Y-m-d';

// Y = Year, m = Month, d = Day

$lng['panel']['timeformat_function'] = 'H:i:s';

// H = Hour, i = Minute, s = Second

$lng['panel']['default'] = 'Standaard';
$lng['panel']['never'] = 'Nooit';
$lng['panel']['active'] = 'Actief';
$lng['panel']['please_choose'] = 'Maak een keuze';
$lng['panel']['allow_modifications'] = 'Aanpassingen toestaan';
$lng['domains']['add_date'] = 'Toegevoegd aan Froxlor';
$lng['domains']['registration_date'] = 'Toegevoegd aan register';
$lng['domains']['topleveldomain'] = 'Top-Level-Domein';

// ADDED IN 1.2.19-svn22

$lng['serversettings']['allow_password_reset']['description'] = 'Klanten kunnen hun wachtwoorden opnieuw instellen. Het nieuwe wachtwoord word hen per e-mail toegestuurd.';
$lng['serversettings']['allow_password_reset_admin']['title'] = 'Beheerders/wederverkopers toestaan hun wachtwoorden opnieuw in te stellen.';
$lng['serversettings']['allow_password_reset_admin']['description'] = 'Beheerders/wederverkopers kunnen hun wachtwoorden opnieuw instellen. Het nieuwe wachtwoord word hen per e-mail toegestuurd.';

// ADDED IN 1.2.19-svn25

$lng['emails']['quota'] = 'Quotum';
$lng['emails']['noquota'] = 'Geen quotum';
$lng['emails']['updatequota'] = 'Quotum aanpassen';
$lng['serversettings']['mail_quota']['title'] = 'Quotum voor mailbox';
$lng['serversettings']['mail_quota']['description'] = 'Het standaard quotum voor nieuwe mailboxen (MegaByte).';
$lng['serversettings']['mail_quota_enabled']['title'] = 'Gebruik mailbox-quota voor mailboxen';
$lng['serversettings']['mail_quota_enabled']['description'] = 'Activeert het gebruik van quota voor mailboxen. Standaard is <b>Nee</b>, aangezien dit verdere configuratie vereist.';
$lng['serversettings']['mail_quota_enabled']['removelink'] = 'Klik hier om alle quota van mailbox te verwijderen.';
$lng['serversettings']['mail_quota_enabled']['enforcelink'] = 'Klik hier om het standaard quotum af te dwingen voor alle accounts.';
$lng['question']['admin_quotas_reallywipe'] = 'Weet u zeker dat u alle quota wilt verwijderen? Dit is niet terug te draaien!';
$lng['question']['admin_quotas_reallyenforce'] = 'Weet u zeker dat u quota wilt afdwingen? Dit is niet terug te draaien!';
$lng['error']['vmailquotawrong'] = 'Het quotum dient een positief getal te zijn.';
$lng['customer']['email_quota'] = 'quotem voor e-mail';
$lng['customer']['email_imap'] = 'E-mail IMAP';
$lng['customer']['email_pop3'] = 'E-mail POP3';
$lng['customer']['mail_quota'] = 'Mailquotum';
$lng['panel']['megabyte'] = 'MegaByte';
$lng['panel']['not_supported'] = 'Wordt niet ondersteund in: ';
$lng['emails']['quota_edit'] = 'E-mailquotum aanpassen';
$lng['error']['allocatetoomuchquota'] = 'U probeerde %s MB ' . $lng['emails']['quota'] . ' toe te kennen, maar u heeft niet voldoende over.';

// Autoresponder module

$lng['menue']['email']['autoresponder'] = 'Automatische beantwoorder';
$lng['autoresponder']['active'] = 'Active';
$lng['autoresponder']['autoresponder_add'] = 'Automatische beantwoorder toevoegen';
$lng['autoresponder']['autoresponder_edit'] = 'Automatische beantwoorder aanpassen';
$lng['autoresponder']['autoresponder_new'] = 'Automatische beantwoorder aanmaken';
$lng['autoresponder']['subject'] = 'Onderwerp';
$lng['autoresponder']['message'] = 'Bericht';
$lng['autoresponder']['account'] = 'Account';
$lng['autoresponder']['sender'] = 'Afzender';
$lng['question']['autoresponderdelete'] = 'Weet u zeker dat u de automatische beantwoorder wilt verwijderen?';
$lng['error']['noemailaccount'] = 'Er kunnen twee redenen zijn waarom u geen automatische beantwoorder kunt aanmaken: 1) U dient minimaal een (1) e-mailaccount te hebben. 2) Het is mogelijk dat alle accounts reeds een automatische beantwoorder hebben';
$lng['error']['missingfields'] = 'Niet alle vereiste velden zijn ingevuld.';
$lng['error']['accountnotexisting'] = 'Het opgegeven e-mailaccount bestaat niet.';
$lng['error']['autoresponderalreadyexists'] = 'Er is reeds een automatische beantwoorder voor dit account geconfigureerd.';
$lng['error']['invalidautoresponder'] = 'Het opgegeven account is ongeldig.';
$lng['serversettings']['autoresponder_active']['title'] = 'Module \'Automatische beantwoorder\' gebruiken';
$lng['serversettings']['autoresponder_active']['description'] = 'Wilt u deze module gebruiken?';
$lng['admin']['security_settings'] = 'Beveiliging';
$lng['admin']['know_what_youre_doing'] = 'Verander dit alleen wanneer u zeker weet wat u doet!';
$lng['admin']['show_version_login']['title'] = 'Toon versie van Froxlor bij het inloggen';
$lng['admin']['show_version_login']['description'] = 'Toont de versie van Froxlor in de voettekst van de inlogpagina';
$lng['admin']['show_version_footer']['title'] = 'Toon versie van Froxlor in de voettekst';
$lng['admin']['show_version_footer']['description'] = 'Toont de versie van Froxlor in de voettekst op de rest van de pagina\'s';
$lng['admin']['froxlor_graphic']['title'] = 'Kopgrafiek voor Froxlor';
$lng['admin']['froxlor_graphic']['description'] = 'Afbeelding die getoond wordt in de kop';

//improved froxlor

$lng['menue']['phpsettings']['maintitle'] = 'PHP Configuratie\'s';
$lng['admin']['phpsettings']['title'] = 'PHP Configuratie';
$lng['admin']['phpsettings']['description'] = 'Korte omschrijven';
$lng['admin']['phpsettings']['actions'] = 'Actie\'s';
$lng['admin']['phpsettings']['activedomains'] = 'Wordt gebruikt door domein(en)';
$lng['admin']['phpsettings']['notused'] = 'Configuratie niet in gebruik';
$lng['admin']['misc'] = 'Diversen';
$lng['admin']['phpsettings']['editsettings'] = 'Instellingen voor PHP aanpassen';
$lng['admin']['phpsettings']['addsettings'] = 'Nieuwe instellingen voor PHP aanmaken';
$lng['admin']['phpsettings']['viewsettings'] = 'Instellingen voor PHP weergeven';
$lng['admin']['phpsettings']['phpinisettings'] = 'Instellingen in php.ini';
$lng['error']['nopermissionsorinvalidid'] = 'U hebt geen toestemming om deze instellingen te wijzigen, of u hebt een ongeldig ID opgegeven.';
$lng['panel']['view'] = 'weergeven';
$lng['question']['phpsetting_reallydelete'] = 'Weet u zeker dat u deze instellingen wilt verwijderen? Alle domeinen die deze configuratie gebruiken zullen terugvallen op de standaardinstellingen.';
$lng['admin']['phpsettings']['addnew'] = 'Nieuwe instellingen aanmaken';
$lng['error']['phpsettingidwrong'] = 'Een configuratie voor PHP met dit ID bestaat niet';
$lng['error']['descriptioninvalid'] = 'De omschrijving is te kort, te lang of bevat ongeldige karakters.';
$lng['error']['info'] = 'Informatie';
$lng['admin']['phpconfig']['template_replace_vars'] = 'Variabelen die worden vervangen in de instellingen';
$lng['admin']['phpconfig']['safe_mode'] = 'Wordt vervangen door de safe_mode-instellingen voor het domein.';
$lng['admin']['phpconfig']['pear_dir'] = 'Wordt vervangen door de globale pear-map.';
$lng['admin']['phpconfig']['open_basedir_c'] = 'Voegt een ; (puntkomma) toe om open_basedir in- of uit te schakelen';
$lng['admin']['phpconfig']['open_basedir'] = 'Wordt vervangen door de open_basedir-instellingen voor het domein.';
$lng['admin']['phpconfig']['tmp_dir'] = 'Wordt vervangen door de tijdelijke map voor dit domein';
$lng['admin']['phpconfig']['open_basedir_global'] = 'Wordt vervangen door de globale waarde van het pad dat wordt toegevoegd aan de open_basedir.';
$lng['admin']['phpconfig']['customer_email'] = 'Wordt vervangen door het e-mailadres van de klant van het domein.';
$lng['admin']['phpconfig']['admin_email'] = 'Wordt vervangen door het e-mailadres van de beheerder van het domein.';
$lng['admin']['phpconfig']['domain'] = 'Wordt vervangen door het domein.';
$lng['admin']['phpconfig']['customer'] = 'Wordt vervangen door de loginnaam van de eigenaar van het domein.';
$lng['admin']['phpconfig']['admin'] = 'Wordt vervangen door de loginnaam van de beheerder van het domein.';
$lng['login']['backtologin'] = 'Terug naar inlogpagina';
$lng['serversettings']['mod_fcgid']['starter']['title'] = 'Processen per domein';
$lng['serversettings']['mod_fcgid']['starter']['description'] = 'Hoeveel processen moeten gestart/toegestaan worden per domein? De waarde 0 wordt aangeraden, aangezien PHP zelf het aantal processen goed kan inschatten.';
$lng['serversettings']['mod_fcgid']['wrapper']['title'] = 'Wrapper in vhosts';
$lng['serversettings']['mod_fcgid']['wrapper']['description'] = 'Hoe moet de wrapper ingesloten worden in vhosts?';
$lng['serversettings']['mod_fcgid']['tmpdir']['description'] = 'Waar dienen de tijdelijke mappen te worden opgeslagen?';
$lng['serversettings']['mod_fcgid']['peardir']['title'] = 'Globale PEAR-mappen';
$lng['serversettings']['mod_fcgid']['peardir']['description'] = 'Welke PEAR-mappen dienen te worden ingesloten in elke php.ini? Bij meerdere mappen dienen deze te worden gescheiden door dubbele punten.';

//improved Froxlor  2

$lng['admin']['templates']['index_html'] = 'Standaardpagina voor nieuwe mappen/domeinen';
$lng['admin']['templates']['SERVERNAME'] = 'Wordt vervangen door de naam van de server.';
$lng['admin']['templates']['CUSTOMER'] = 'Wordt vervangen door de inlognaam van de klant.';
$lng['admin']['templates']['ADMIN'] = 'Wordt vervangen door de inlognaam van de beheerder.';
$lng['admin']['templates']['CUSTOMER_EMAIL'] = 'Wordt vervangen door het e-mailadres van de klant.';
$lng['admin']['templates']['ADMIN_EMAIL'] = 'Wordt vervangen door het e-mailadres van de beheerder.';
$lng['admin']['templates']['filetemplates'] = 'Bestandssjablonen';
$lng['admin']['templates']['filecontent'] = 'Bestandsinhoud';
$lng['error']['filecontentnotset'] = 'Het bestand mag niet leeg zijn!';
$lng['serversettings']['index_file_extension']['description'] = 'Welk achtervoegsel moet gebruikt worden voor het indexbestand? Dit achtervoegsel wordt gebruikt wanneer een van de beheerders een eigen indexsjabloon heeft gemaakt.';
$lng['serversettings']['index_file_extension']['title'] = 'Achtervoegsel van het indexbestand in nieuwe mappen voor klanten.';
$lng['error']['index_file_extension'] = 'Het achtervoegsel dient tussen de 1 en 6 tekens lang te zijn. Het mag alleen tekens zal a-z, A-Z en 0-9 bevatten.';
$lng['admin']['expert_settings'] = 'Instellingen voor experts!';
$lng['admin']['mod_fcgid_starter']['title'] = 'Aantal PHP-processen voor dit domein. (Leeg betekent standaardinstellingen.)';

//added with aps installer

$lng['admin']['aps'] = 'APS installatie-programma';
$lng['customer']['aps'] = 'APS installatie-programma';
$lng['aps']['scan'] = 'Zoeken naar nieuwe pakketten';
$lng['aps']['upload'] = 'Nieuwe pakketten uploaden';
$lng['aps']['managepackages'] = 'Pakketten beheren';
$lng['aps']['manageinstances'] = 'Instanties beheren';
$lng['aps']['overview'] = 'Overzicht pakketten';
$lng['aps']['status'] = 'Mijn pakketten';
$lng['aps']['search'] = 'Zoeken naar pakketten';
$lng['aps']['upload_description'] = 'Kies de ZIP-bestanden van het APS installatieprogramma om te installeren op het systeem.';
$lng['aps']['search_description'] = 'Naam, omschrijving, sleutelwoord, versie';
$lng['aps']['detail'] = 'Meer informatie';
$lng['aps']['install'] = 'Pakket installeren';
$lng['aps']['data'] = 'Data';
$lng['aps']['version'] = 'Versie';
$lng['aps']['homepage'] = 'Homepage';
$lng['aps']['installed_size'] = 'Grootte na installatie';
$lng['aps']['categories'] = 'CategorieÃ«n';
$lng['aps']['languages'] = 'Talen';
$lng['aps']['long_description'] = 'Lange omschrijving';
$lng['aps']['configscript'] = 'Configuratiescript';
$lng['aps']['changelog'] = 'Lijst met veranderingen';
$lng['aps']['license'] = 'Licentie';
$lng['aps']['license_link'] = 'Link naar licentie';
$lng['aps']['screenshots'] = 'Schermafdrukken';
$lng['aps']['back'] = 'Terug naar overzicht';
$lng['aps']['install_wizard'] = 'Installatie-wizard...';
$lng['aps']['wizard_error'] = 'Uw invoer bevat ongeldige gegevens. Verbeter deze om de installatie voort te zetten.';
$lng['aps']['basic_settings'] = 'Basisinstellingen';
$lng['aps']['application_location'] = 'Locatie';
$lng['aps']['application_location_description'] = 'Locatie waar de applicatie geinstalleerd wordt.';
$lng['aps']['no_domains'] = 'Geen domeinen gevonden';
$lng['aps']['database_password'] = 'Wachtwoord voor database';
$lng['aps']['database_password_description'] = 'Wachtwoord dat gebruikt wordt voor installatie.';
$lng['aps']['license_agreement'] = 'Overeenkomst';
$lng['aps']['cancel_install'] = 'Installatie afbreken';
$lng['aps']['notazipfile'] = 'Het geuploade bestand is geen ZIP-bestand.';
$lng['aps']['filetoobig'] = 'Het bestand is te groot.';
$lng['aps']['filenotcomplete'] = 'Het bestand werd niet volledig ontvangen.';
$lng['aps']['phperror'] = 'Er is een interne fout van PHP opgetreden. De foutcode van PHP is #';
$lng['aps']['moveproblem'] = 'Het script kon het geuploade bestand niet naar de doelmap verplaatsen. Zorg ervoor dat de rechten juist staan ingesteld.';
$lng['aps']['uploaderrors'] = '<strong>Fouten voor het bestand <em>%s</em></strong><br/><ul>%s</ul>';
$lng['aps']['nospecialchars'] = 'Speciale tekens zijn niet toegestaan in de zoekterm!';
$lng['aps']['noitemsfound'] = 'Geen pakketten gevonden!';
$lng['aps']['nopackagesinstalled'] = 'U hebt nog geen pakketten geinstalleerd die kunnen worden weergegeven.';
$lng['aps']['instance_install'] = 'Installatie van het pakket in afwachting';
$lng['aps']['instance_task_active'] = 'Het pakket wordt op dit moment verwerkt';
$lng['aps']['instance_success'] = 'Het pakket is correct geinstalleerd';
$lng['aps']['instance_error'] = 'Het pakket is niet geinstalleerd. - Er zijn enkele fouten opgetreden:';
$lng['aps']['instance_uninstall'] = 'Het deinstalleren van het pakket is in afwachting';
$lng['aps']['unknown_status'] = 'Fout - Onbekende waarde';
$lng['aps']['currentstatus'] = 'Huidige status';
$lng['aps']['activetasks'] = 'Actieve taken';
$lng['aps']['task_install'] = 'Installatie in afwachting';
$lng['aps']['task_remove'] = 'Deinstallatie in afwachting';
$lng['aps']['task_reconfigure'] = 'Herconfiguratie in afwachting';
$lng['aps']['task_upgrade'] = 'Opwaarderen in afwachting';
$lng['aps']['no_task'] = 'Geen wachtende taken';
$lng['aps']['applicationlinks'] = 'Links van applicatie';
$lng['aps']['mainsite'] = 'Hoofdsite';
$lng['aps']['uninstall'] = 'Pakket deinstalleren';
$lng['aps']['reconfigure'] = 'Instellingen wijzigen';
$lng['aps']['erroronnewinstance'] = '<strong>Dit pakket kan niet geinstalleerd worden.</strong><br/><br/>U kunt een nieuw pakket installeren wanneer u teruggaat naar het overzicht.';
$lng['aps']['successonnewinstance'] = '<strong><em>%s</em> wordt op dit moment geinstalleerd.</strong><br/><br/>U kunt het verloop van de installatie volgen onder "Mijn pakketten". Installatie kan enige tijd duren.';
$lng['aps']['php_misc_handler'] = 'PHP - Diversen - Er is geen ondersteuning voor achtervoegsel anders dan .php voor PHP.';
$lng['aps']['php_misc_directoryhandler'] = 'PHP - Diversen - Er is geen ondersteuning voor PHP met instellingen per map.';
$lng['aps']['asp_net'] = 'ASP.NET - Pakket wordt niet ondersteund.';
$lng['aps']['cgi'] = 'CGI - Pakket wordt niet ondersteund.';
$lng['aps']['php_extension'] = 'PHP - Extensie "%s" ontbreekt.';
$lng['aps']['php_function'] = 'PHP - Functie "%s" ontbreekt.';
$lng['aps']['php_configuration'] = 'PHP - Configuratie - Huidge instelling "%s" wordt niet door het pakket ondersteund.';
$lng['aps']['php_configuration_post_max_size'] = 'PHP - Configuratie - Waarde voor "post_max_size" is te laag.';
$lng['aps']['php_configuration_memory_limit'] = 'PHP - Configuratie - Waarde voor "memory_limit" is te laag.';
$lng['aps']['php_configuration_max_execution_time'] = 'PHP - Configuratie - Waarde voor "max_execution_time" is te laag.';
$lng['aps']['php_general_old'] = 'PHP - Algemeen - Versie van PHP is te oud.';
$lng['aps']['php_general_new'] = 'PHP - Algemeen - Versie van PHP is te oud.';
$lng['aps']['db_mysql_support'] = 'Database - Het pakket vereist een andere databaseserver dan MySQL.';
$lng['aps']['db_mysql_version'] = 'Database - MySQL server te oud';
$lng['aps']['webserver_module'] = 'Webserver - Module "%s" ontbreekt.';
$lng['aps']['webserver_fcgid'] = 'Webserver - Dit pakket vereist aanvullende modules van de webserver. In uw FastCGI/mod_fcgid-omgeving bestaat de functie "apache_get_modules" niet. Het pakket kan niet geinstalleerd worden omdat de aanwezigheid van deze modules niet kan worden gecontroleerd.';
$lng['aps']['webserver_htaccess'] = 'Webserver - Dit pakket vereist dat .htaccess-bestanden worden verwerkt door de webserver. Dit pakket kan niet worden geinstalleerd omdat APS installatieprogramma niet vast kan stellen of dit het geval is.';
$lng['aps']['misc_configscript'] = 'Diversen - De taal van het configuratiescript wordt niet ondersteund.';
$lng['aps']['misc_charset'] = 'Diversen - In de huidge versie van het installatieprogramma is het niet mogelijk om formuliervelden te controleren op een specifieke tekenset. Het pakket kan niet worden geinstalleerd.';
$lng['aps']['misc_version_already_installed'] = 'Dezelfde versie van het pakket is reeds geinstalleerd.';
$lng['aps']['misc_only_newer_versions'] = 'Om veiligheidsredenen kunnen alleen nieuwere versie\'s van bestaande pakketten worden geinstalleerd.';
$lng['aps']['erroronscan'] = '<strong>Fouten voor <em>%s</em></strong><ul>%s</ul>';
$lng['aps']['invalidzipfile'] = '<strong>Fouten voor <em>%s</em></strong><br/><ul><li>Dit is geen geldig APS ZIP-bestand.</li></ul>';
$lng['aps']['successpackageupdate'] = '<strong><em>%s</em> met succes geinstalleerd als opgewaardeerd pakket</strong>';
$lng['aps']['successpackageinstall'] = '<strong><em>%s</em> met succes geinstalleerd als nieuw pakket</strong>';
$lng['aps']['class_zip_missing'] = 'Klasse SimpleXML, de functie exec of functionaliteit voor ZIP ontbreken of zijn niet actief! Voor meer informatie over dit probleem kunt u de handleiding van de betreffende module raadplegen.';
$lng['aps']['dir_permissions'] = 'Het proces van PHP/de webserver moet in staat zijn om naar de mappen {$path}temp/ en {$path}packages/ te schrijven';
$lng['aps']['initerror'] = '<strong>Er zijn enkele problemen met deze module:</strong><ul>%s</ul>U dient deze problemen te verhelpen voordat de module gebruikt kan worden!';
$lng['aps']['iderror'] = 'Verkeerde ID op gegeven.';
$lng['aps']['nopacketsforinstallation'] = 'Er zijn geen te installeren pakketten.';
$lng['aps']['nopackagestoinstall'] = 'Er zijn geen pakketten om weer te geven of te installeren.';
$lng['aps']['nodomains'] = 'Kies een domein uit de lijst. Indien de lijst leeg is kan het pakket niet worden geinstalleerd!';
$lng['aps']['wrongpath'] = 'Het pad bevat ongeldige karakters of er is reeds een andere applicatie geinstalleerd.';
$lng['aps']['dbpassword'] = 'Het wachtwoord dient minimaal 8 karakters te bevatten.';
$lng['aps']['error_text'] = 'Geef een tekst zonder speciale karakters op.';
$lng['aps']['error_email'] = 'Geef een geldig e-mailadres op.';
$lng['aps']['error_domain'] = 'Geef een geldige URL op, bijvoorbeeld http://www.example.com/';
$lng['aps']['error_integer'] = 'Geef een numerieke waarde (gehele getallen), bijvoorbeeld <em>5</em> of <em>7</em>.';
$lng['aps']['error_float'] = 'Geef een numerieke waarde (gebroken getallen) bijvoorbeeld <em>5,2432</em> of <em>7,5346</em>.';
$lng['aps']['error_password'] = 'Geef een wachtwoord.';
$lng['aps']['error_license'] = 'Ja, ik heb de licentie gelezen en zal mij aan de voorwaarden houden.';
$lng['aps']['error_licensenoaccept'] = 'Om deze applicatie te installeren dient u akkoord te gaan met de licentievoorwaarden.';
$lng['aps']['stopinstall'] = 'Installatie afbreken.';
$lng['aps']['installstopped'] = 'De installatie van dit pakket is afgebroken.';
$lng['aps']['installstoperror'] = 'De installatie kan niet meer worden afgebroken aangezien de installatie reeds gestart is. Indien u een installatie ongedaan wenst te maken, dient u te wachten tot de installatie is voltooid en kunt vervolgens het pakket markeren voor verwijderen onder "Mijn pakketten".';
$lng['aps']['waitfortask'] = 'Er zijn geen te kiezen acties. Wacht totdat alle taken zijn beeindigd.';
$lng['aps']['removetaskexisting'] = '<strong>Er staat reeds een taak voor verwijdering.</strong><br/><br/>Ga terug naar "Mijn pakketten" en wacht totdat het verwijderen is voltooid.';
$lng['aps']['packagewillberemoved'] = '<strong>Het pakket wordt nu verwijderd.</strong><br/><br/>Ga terug naar "Mijn pakketten" en wacht totdat het verwijderen is voltooid.';
$lng['question']['reallywanttoremove'] = '<strong>Weet u zeker dat u dit pakket wilt verwijderen?</strong><br/><br/>Alle database-inhoud en bestanden van dit pakket worden verwijderd. Maak zelf een reservekopie van de database en/of de bestanden die u wenst te behouden!<br/><br/>';
$lng['aps']['searchoneresult'] = '%s pakket gevonden';
$lng['aps']['searchmultiresult'] = '%s pakketten gevonden';
$lng['question']['reallywanttostop'] = 'Weet u zeker dat u de installatie van dit pakket wilt afbreken?<br/><br/>';
$lng['aps']['packagenameandversion'] = 'Pakket & versie';
$lng['aps']['package_locked'] = 'Vergrendeld';
$lng['aps']['package_enabled'] = 'Beschikbaar';
$lng['aps']['lock'] = 'Vergrendelen';
$lng['aps']['unlock'] = 'Beschikbaar maken';
$lng['aps']['remove'] = 'Verwijderen';
$lng['aps']['allpackages'] = 'Alle pakketten';
$lng['question']['reallyremovepackages'] = '<strong>Weet u zeker dat u deze pakketten wilt verwijderen?</strong><br/><br/>Pakketten met afhankelijkheden kunnen alleen verwijderd worden indien de betreffende afhankelijkheden zijn verwijderd!<br/><br/>';
$lng['aps']['nopackagesinsystem'] = 'Er zijn geen pakketten op dit systeem geinstalleerd die beheerd kunnen worden.';
$lng['aps']['packagenameandstatus'] = 'Pakket & status';
$lng['aps']['activate_aps']['title'] = 'APS Installatieprogramma inschakelen';
$lng['aps']['activate_aps']['description'] = 'Het APS installatieprogramma kan hier ingeschakeld worden.';
$lng['aps']['packages_per_page']['title'] = 'Pakketten per pagina';
$lng['aps']['packages_per_page']['description'] = 'Hoeveel pakketten worden er voor de klant getoond per pagina?';
$lng['aps']['upload_fields']['title'] = 'Aantal velden voor uploads';
$lng['aps']['upload_fields']['description'] = 'Hoeveel gelijktijdige uploads wilt u toestaan?';
$lng['aps']['exceptions']['title'] = 'Uitzonderingen voor pakketten';
$lng['aps']['exceptions']['description'] = 'Enkele pakketten vereisen speciale parameters of modules. Het installatieprogramma kan niet in alle gevallen vaststellen of deze instellingen of uitbreidingen beschikbaar zijn. Om deze reden kunt u hier uitzonderingen opgeven waarvan het pakket worden geinstalleerd. Kies alleen de instellingen die overeenkomen met de echte configuratie van het systeem. Voor meer informatie kunt u de handleiding van de betreffende module raadplegen.';
$lng['aps']['settings_php_extensions'] = 'PHP-uitbreidingen';
$lng['aps']['settings_php_configuration'] = 'PHP-configuratie';
$lng['aps']['settings_webserver_modules'] = 'Webserver modules';
$lng['aps']['settings_webserver_misc'] = 'Webserver diversen';
$lng['aps']['specialoptions'] = 'Speciale instellingen';
$lng['aps']['removeunused'] = 'Ongebruikte pakketten verwijderen';
$lng['aps']['enablenewest'] = 'Nieuwste versies van de pakketten beschikbaar maken en de overigen uitschakelen';
$lng['aps']['installations'] = 'Installaties';
$lng['aps']['statistics'] = 'Statistieken';
$lng['aps']['numerofpackagesinstalled'] = '%s pakketten geinstalleerd<br/>';
$lng['aps']['numerofpackagesenabled'] = '%s pakketten beschikbaar<br/>';
$lng['aps']['numerofpackageslocked'] = '%s pakketten vergrendeld<br/>';
$lng['aps']['numerofinstances'] = '%s pakketten geinstalleerd<br/>';
$lng['question']['reallydoaction'] = '<strong>Weet u zeker dat u de geselecteerde opdrachten wilt uitvoeren?</strong><br/><br/>Er kan permanente dataverlies optreden wanneer u doorgaat.<br/><br/>';
$lng['aps']['linktolicense'] = 'Koppeling naar licentie';
$lng['aps']['initerror_customer'] = 'Er is op dit moment een fout met dit programma. Neem contact op met uw beheerder voor meer informatie.';
$lng['aps']['numerofinstances'] = '%s installaties over het geheel<br/>';
$lng['aps']['numerofinstancessuccess'] = '%s succesvolle installaties<br/>';
$lng['aps']['numerofinstanceserror'] = '%s mislukte installaties<br/>';
$lng['aps']['numerofinstancesaction'] = '%s geplande installaties/deinstallaties';
$lng['aps']['downloadallpackages'] = 'Alle pakketten downloaden van distributieserver';
$lng['aps']['updateallpackages'] = 'Alle pakketten bijwerken van distributieserver';
$lng['aps']['downloadtaskexists'] = 'Er is reeds een taak om alle pakketten te downloaden. Wacht totdat deze taak is voltooid.';
$lng['aps']['downloadtaskinserted'] = 'Er is een taak voor het downloaden van alle pakketten gemaakt. Dit kan enige tijd in beslag nemen.';
$lng['aps']['updatetaskexists'] = 'Er is reeds een taak om alle pakketten bij te werken. Wacht totdat deze taak is voltooid.';
$lng['aps']['updatetaskinserted'] = 'Er is een taak voor het downloaden van alle pakketten gemaakt. Dit kan enige tijd in beslag nemen.';
$lng['aps']['canmanagepackages'] = 'Kan APS pakketten beheren';
$lng['aps']['numberofapspackages'] = 'Aantal APS installaties';
$lng['aps']['allpackagesused'] = '<strong>Fout</strong><br/><br/>U hebt de limiet van het te aantal te installeren APS pakketten bereikt.';
$lng['aps']['noinstancesexisting'] = 'Er zijn op dit moment geen pakketten die kunnen worden beheerd. Er dient minimaal een pakket bij een klant zijn geinstalleerd.';
$lng['aps']['lightywarning'] = 'Waarschuwing';
$lng['aps']['lightywarningdescription'] = 'U maakt gebruik van de lighttpd server in combinatie met Froxlor. De APS module is voornamelijk bedoeld voor Apache, het is mogelijk dat enige functionaliteit niet werkt. Indien u tegen problemen aanloopt tijdens het gebruik van deze module, dan wordt u verzocht dit aan de ontwikkelaars van Froxlor te melden. Zij kunnen dan het probleem eventueel verhelpen.';
$lng['error']['customerdoesntexist'] = 'De gekozen klant bestaat niet.';
$lng['error']['admindoesntexist'] = 'De gekozen beheerder bestaat niet.';

// ADDED IN 1.2.19-svn37

$lng['serversettings']['system_realtime_port']['title'] = 'Poort voor realtime Froxlor';
$lng['serversettings']['system_realtime_port']['description'] = 'Froxlor maakt verbinding met deze poort wanneer een nieuwe taak gepland wordt. Indien deze waarde 0 (nul) is, is deze uitgeschakeld.<br />Zie ook: <a target="blank" href="http://redmine.froxlor.org/projects/froxlor/wiki/En-realtime">Make Froxlor work in realtime (Froxlor Wiki)</a>';
$lng['serversettings']['session_allow_multiple_login']['title'] = 'Meerdere logins toestaan';
$lng['serversettings']['session_allow_multiple_login']['description'] = 'Indien dit is ingeschakeld kan een klant meerdere malen tegelijkertijd inloggen.';
$lng['serversettings']['panel_allow_domain_change_admin']['title'] = 'Het verplaatsen van domeinen tussen beheerders toestaan';
$lng['serversettings']['panel_allow_domain_change_admin']['description'] = 'Indien actief, kunt u een domein toewijzen aan een andere beheerder.<br /><b>Let op:</b> Indien een klant niet is toegewezen aan de beheerder van het domein, kan de betreffende beheerde alle domeinen van deze klant zien!';
$lng['serversettings']['panel_allow_domain_change_customer']['title'] = 'Het verplaatsen van domeinen tussen klanten toestaan';
$lng['serversettings']['panel_allow_domain_change_customer']['description'] = 'Indien actief, kunt u de klant van een domein veranderen.<br /><b>Let op:</b> Froxlor zal niet het pad aanpassen. Dit kan ervoor zorgen dat het domein onbruikbaar wordt!';
$lng['domains']['associated_with_domain'] = 'Toegekend';
$lng['domains']['aliasdomains'] = 'Alternatieve domeinnamen';
$lng['error']['ipportdoesntexist'] = 'De kozen combinatie poort/IP-adres bestaat niet.';

// ADDED IN 1.2.19-svn38

$lng['admin']['phpserversettings'] = 'PHP Instellingen';
$lng['admin']['phpsettings']['binary'] = 'PHP Uitvoerbaar bestand';
$lng['admin']['phpsettings']['file_extensions'] = 'Bestandsextensies';
$lng['admin']['phpsettings']['file_extensions_note'] = '(zonder punt, gescheiden door spaties)';
$lng['admin']['mod_fcgid_maxrequests']['title'] = 'Maximaal aantal PHP verzoeken voor dit domein (leeg geldt als standaardwaarde)';
$lng['serversettings']['mod_fcgid']['maxrequests']['title'] = 'Maximaal aantal verzoeken per domein';
$lng['serversettings']['mod_fcgid']['maxrequests']['description'] = 'Toegestane aantal verzoeken per domein';

// fix bug #1124
$lng['admin']['webserver'] = 'Webserver';
$lng['error']['admin_domain_emailsystemhostname'] = 'De naam van de server kan niet gebruikt worden als domein voor e-mail.';
$lng['aps']['license_link'] = 'Koppeling naar licentie';

// ADDED IN 1.4.2.1-1

$lng['mysql']['mysql_server'] = 'MySQL-Server';

// ADDED IN 1.4.2.1-2

$lng['admin']['ipsandports']['webserverdefaultconfig'] = 'Standaarconfiguratie webserver';
$lng['admin']['ipsandports']['webserverdomainconfig'] = 'Domeinconfiguratie webserver';
$lng['admin']['ipsandports']['webserverssldomainconfig'] = 'SSL-configuratie webserver';
$lng['admin']['ipsandports']['ssl_key_file'] = 'Pad naar SSL keyfile';
$lng['admin']['ipsandports']['ssl_ca_file'] = 'Pad naar SSL CA certificaat';
$lng['admin']['ipsandports']['default_vhostconf_domain'] = 'Standaard VHost-instellingen voor iedere domeincontainer';
$lng['serversettings']['ssl']['ssl_key_file'] = 'Pad naar SSL keyfile';
$lng['serversettings']['ssl']['ssl_ca_file'] = 'Pad naar SSL CA certificaat';

$lng['error']['usernamealreadyexists'] = 'De gebruikersnaam %s is reeds in gebruik.';

$lng['error']['plausibilitychecknotunderstood'] = 'Answer of plausibility check not understood.';
$lng['error']['errorwhensaving'] = 'Fout tijdens opslaan veld %s';

$lng['success']['success'] = 'Informatie';
$lng['success']['clickheretocontinue'] = 'Klik hier om verder te gaan';
$lng['success']['settingssaved'] = 'De instellingen zijn opgeslagen.';

// ADDED IN FROXLOR 0.9

$lng['admin']['spfsettings'] = 'SPF-instellingen domein';
$lng['spf']['use_spf'] = 'SPF voor domeinen activeren?';
$lng['spf']['spf_entry'] = 'SPF regel voor alle domeinen';
$lng['panel']['dirsmissing'] = 'De opgegeven map bestaat niet.';
$lng['panel']['toomanydirs'] = 'Teveel submappen. Er wordt teruggevallen op handmatige invoer.';
$lng['panel']['abort'] = 'Afbreken';
$lng['serversettings']['cron']['debug']['title'] = 'Foutopsporing cronscript';
$lng['serversettings']['cron']['debug']['description'] = 'Activeer dit om het lockbestand te bewaren nadat de cron-taak is afgehandeld, zodat het gerbuikt kan worden voor het opsporen van fouten.<br /><b>Let op:</b>Het vastzetten van het lockbestand kan ervoor zorgen dat de volgende cron-taak niet naar behoren functioneert.';
$lng['autoresponder']['date_from'] = 'Startdatum';
$lng['autoresponder']['date_until'] = 'Einddatum';
$lng['autoresponder']['startenddate'] = 'Start-/einddatum';
$lng['panel']['not_activated'] = 'niet actief';
$lng['panel']['off'] = 'uit';
$lng['update']['updateinprogress_onlyadmincanlogin'] = 'Een nieuwere versie van Froxlor is geinstalleerd maar is nog niet geconfigureerd.<br />Alleen de beheerder kan inloggen en de update voltooien.';
$lng['update']['update'] = 'Froxlor Update';
$lng['update']['proceed'] = 'Verdergaan';
$lng['update']['update_information']['part_a'] = 'De bestanden van Froxlor zijn bijgewerkt naar versie <strong>%newversion</strong>. De geinstalleerde versie is <strong>%curversion</strong>.';
$lng['update']['update_information']['part_b'] = '<br /><br />Klanten kunnen niet inloggen totdat de update voltooid is.<br /><strong>Verdergaan?</strong>';
$lng['update']['noupdatesavail'] = '<strong>U gebruikt reeds de meest recente versie van Froxlor.</strong>';
$lng['admin']['specialsettingsforsubdomains'] = 'Speciale instellingen toepassen op alle subdomeinen (*.example.com)';
$lng['serversettings']['specialsettingsforsubdomains']['description'] = 'Indien "Ja" zullen deze aangepaste VHost-instellingen worden toegepast op alle subdomeinen.';
$lng['tasks']['outstanding_tasks'] = 'Uitstaande cron-taken';
$lng['tasks']['rebuild_webserverconfig'] = 'Bezig met opnieuw opbouwen van de configuratie van de webserver';
$lng['tasks']['adding_customer'] = 'Klant met naam %loginname% wordt toegevoegd';
$lng['tasks']['rebuild_bindconfig'] = 'Opnieuw opbouwen bind-configuratie';
$lng['tasks']['creating_ftpdir'] = 'Map aanmaken voor nieuwe FTP-gebruiker';
$lng['tasks']['deleting_customerfiles'] = 'Verwijderen klantbestanden van %loginname%';
$lng['tasks']['noneoutstanding'] = 'Er zijn op dit moment geen uitstaande taken voor Froxlor';
$lng['ticket']['nonexistingcustomer'] = '(verwijderde klant)';
$lng['admin']['ticket_nocustomeraddingavailable'] = 'Het is niet mogelijk een nieuw supportticket te openen. U dient minimaal 1 klant toe te voegen.';

// ADDED IN FROXLOR 0.9.1

$lng['admin']['accountdata'] = 'Accountgegevens';
$lng['admin']['contactdata'] = 'Contactgegevens';
$lng['admin']['servicedata'] = 'Ondersteuningsgegevens';

// ADDED IN FROXLOR 0.9.2

$lng['admin']['newerversionavailable'] = 'Er is een nieuwe versie van Froxlor beschikbaar';

// ADDED IN FROXLOR 0.9.3

$lng['emails']['noemaildomainaddedyet'] = 'U hebt nog geen (email-)domein gekoppeld aan uw account.';
$lng['error']['hiddenfieldvaluechanged'] = 'De waarde van het verborgen veld "%s" is gewijzigd tijdens het aanpassen van de instellingen.<br /><br />Dit is normaliter geen groot probleem maar heeft wel verhinderd dat de instellingen niet zijn opgeslagen.';

// ADDED IN FROXLOR 0.9.3-svn1

$lng['serversettings']['panel_password_min_length']['title'] = 'Minimumlengte wachtwoord';
$lng['serversettings']['panel_password_min_length']['description'] = 'Hier kunt u een minimumlengte voor wachtwoorden opgeven. \'0\' betekent geen minimumlengte.';
$lng['error']['notrequiredpasswordlength'] = 'Het opgegeven wachtwoord is te kort. Geef tenminste %s tekens op.';
$lng['serversettings']['system_store_index_file_subs']['title'] = 'Standaard indexbestand ook plaatsen in nieuwe submappen';
$lng['serversettings']['system_store_index_file_subs']['description'] = 'Indiend actief wordt dit bestand automatisch geplaatst in nieuw aangemaakte submappen (indien deze nog niet bestaat).';

// ADDED IN FROXLOR 0.9.3-svn2

$lng['serversettings']['adminmail_return']['title'] = 'Reply-To adres';
$lng['serversettings']['adminmail_return']['description'] = 'Geef een e-mailadres dat gebruikt wordt als antwoord-aan adres voor mails die verzonden worden door het paneel.';
$lng['serversettings']['adminmail_defname'] = 'Panel e-mail sender name';

// ADDED IN FROXLOR 0.9.3-svn3
$lng['dkim']['dkim_algorithm']['title'] = 'Toegestane hash-algoritmen';
$lng['dkim']['dkim_algorithm']['description'] = 'Toegestane hash-algoritmen, kies "Alle" voor alle algoritmen of 1 of meerdere van onderstaande';
$lng['dkim']['dkim_servicetype'] = 'Type services';
$lng['dkim']['dkim_keylength']['title'] = 'Lengte sleutel';
$lng['dkim']['dkim_keylength']['description'] = 'Let op: Indien u deze waarde wijzigt, dient u allen geheime en publieke sleutels in "'.$settings['dkim']['dkim_prefix'].'" te verwijderen';
$lng['dkim']['dkim_notes']['title'] = 'Notities voor DKIM';
$lng['dkim']['dkim_notes']['description'] = 'Notities die van belang kunnen zijn voor mensen, bijvoorbeeld een URL als http://www.dnswatch.info. Geen enkel programma zal deze informatie verwerken. Deze informatie dient schaars te zijn gezien de beperkte ruimte in DNS. Dit is bedoeld voor beheerders, niet voor eindgebruikers.';
$lng['dkim']['dkim_add_adsp']['title'] = 'DKIM ADSP toevoegen';
$lng['dkim']['dkim_add_adsp']['description'] = 'Indien u niet weet wat dit is, laat het op "actief" staan.';
$lng['dkim']['dkim_add_adsppolicy']['title'] = 'ADSP beleid';
$lng['dkim']['dkim_add_adsppolicy']['description'] = 'Voor meer informatie inzake deze instelling zie <a target="blank" href="http://redmine.froxlor.org/projects/froxlor/wiki/En-dkim-adsp-policies">DKIM ADSP policies</a>';

$lng['admin']['cron']['cronsettings'] = 'Instellingen cron-taken';
$lng['cron']['cronname'] = 'naam cron-taak';
$lng['cron']['lastrun'] = 'laatst uitgevoerd';
$lng['cron']['interval'] = 'interval';
$lng['cron']['isactive'] = 'actief';
$lng['cron']['description'] = 'beschrijving';
$lng['crondesc']['cron_unknown_desc'] = 'geen beschrijving opgegeven';
$lng['admin']['cron']['add'] = 'Cron-taak toevoegen';
$lng['crondesc']['cron_tasks'] = 'aanmaken configuratiebestanden';
$lng['crondesc']['cron_legacy'] = 'oude cron-taak';
$lng['crondesc']['cron_apsinstaller'] = 'APS-installatieprogramma';
$lng['crondesc']['cron_autoresponder'] = 'autobeantwoorder e-mail';
$lng['crondesc']['cron_apsupdater'] = 'bijwerken APS-pakketten';
$lng['crondesc']['cron_traffic'] = 'berekenen verkeersgegevens';
$lng['crondesc']['cron_ticketsreset'] = 'opnieuw instellen ticket-tellers';
$lng['crondesc']['cron_ticketarchive'] = 'oude tickets archiveren';
$lng['cronmgmt']['seconds'] = 'seconden';
$lng['cronmgmt']['minutes'] = 'minuten';
$lng['cronmgmt']['hours'] = 'uren';
$lng['cronmgmt']['days'] = 'days';
$lng['cronmgmt']['weeks'] = 'weken';
$lng['cronmgmt']['months'] = 'maanden';
$lng['admin']['cronjob_edit'] = 'Cron-taak aanpassen';
$lng['cronjob']['cronjobsettings'] = 'Instellingen cron-taak';
$lng['cronjob']['cronjobinterval'] = 'Interval uitvoeren';
$lng['panel']['options'] = 'opties';
$lng['admin']['warning'] = 'WAARSCHUWING - Let op!';
$lng['cron']['changewarning'] = 'Het aanpassen van de ze waarden kunnen van negatieve invloeg zijn op het gedrag van Froxlor en haar geautomatiseerde taken.<br /><br />Pas deze waarden alleen aan wanneer u *zeer zeker* bent van wat u doet.';

$lng['serversettings']['stdsubdomainhost']['title'] = 'Standaarddomein voor klanten';
$lng['serversettings']['stdsubdomainhost']['description'] = 'Welke hostnaam dient gebruikt te worden voor standaard subdomeinen voor klanten. Indien leeg zal de naam van het systeem gebruikt worden.';

// ADDED IN FROXLOR 0.9.4-svn1
$lng['ftp']['account_edit'] = 'FTP account aanpassen';
$lng['ftp']['editpassdescription'] = 'Nieuw wachtwoord of leeg voor het oude wachtwoord.';
$lng['customer']['sendinfomail'] = 'Stuur gegevens naar mij via e-mail';
$lng['customer']['mysql_add']['infomail_subject'] = '[Froxlor] Nieuwe database aangemaakt';
$lng['customer']['mysql_add']['infomail_body']['main'] = "Geachte {CUST_NAME},\n\nu hebt zojuist een nieuwe database aangemaakt. Hier zijn nogmaals de ingevoerde gegevens:\n\nNaam database: {DB_NAME}\nWachtwoord: {DB_PASS}\nBeschrijving: {DB_DESC}\nHostnaam database: {DB_SRV}\nphpMyAdmin: {PMA_URI}\nMet vriendelijke groet, uw beheerder";
$lng['error']['domains_cantdeletedomainwithapsinstances'] = 'U kunt geen domeinen verwijderen die in gebruik zijn door APS-pakketten. U dient deze eerst te verwijderen.';
$lng['serversettings']['awstats_path'] = 'Pad naar \'awstats_buildstaticpages.pl\' van AWStats';
$lng['serversettings']['awstats_conf'] = 'AWStats configuratiepad';
$lng['error']['overviewsettingoptionisnotavalidfield'] = 'Woops, a field that should be displayed as an option in the settings-overview is not an excepted type. You can blame the developers for this. This should not happen!';
$lng['admin']['configfiles']['compactoverview'] = 'Compacte weergave';
$lng['admin']['lastlogin_succ'] = 'Laatste login';
$lng['panel']['neverloggedin'] = 'Nog niet ingelogd';

// ADDED IN FROXLOR 0.9.6-svn1
$lng['serversettings']['defaultttl'] = 'Standaard TTL voor domeinen in seconden (standaard \'604800\' = 1 week)';
$lng['ticket']['logicalorder'] = 'Logische volgorde';
$lng['ticket']['orderdesc'] = 'Hier kunt u uw eigen logische volgorde instellen voor het weergeven van de categorie voor tickets. Gebruik 1 - 999, lage nummers worden bovenaan getoond.';

// ADDED IN FROXLOR 0.9.6-svn3
$lng['serversettings']['defaultwebsrverrhandler_enabled'] = 'Standaard foutdocumenten voor alle klanten activeren';
$lng['serversettings']['defaultwebsrverrhandler_err401']['title'] = 'Bestand/URL voor foutcode 401';
$lng['serversettings']['defaultwebsrverrhandler_err401']['description'] = '<div style="color:red">'.$lng['panel']['not_supported'].'lighttpd</div>';
$lng['serversettings']['defaultwebsrverrhandler_err403']['title'] = 'Bestand/URL voor foutcode 403';
$lng['serversettings']['defaultwebsrverrhandler_err403']['description'] = '<div style="color:red">'.$lng['panel']['not_supported'].'lighttpd</div>';
$lng['serversettings']['defaultwebsrverrhandler_err404'] = 'Bestand/URL voor foutcode 404';
$lng['serversettings']['defaultwebsrverrhandler_err500']['title'] = 'Bestand/URL voor foutcode 500';
$lng['serversettings']['defaultwebsrverrhandler_err500']['description'] = '<div style="color:red">'.$lng['panel']['not_supported'].'lighttpd</div>';

// ADDED IN FROXLOR 0.9.6-svn4
$lng['serversettings']['ticket']['default_priority'] = 'Standaardprioriteit voor support-tickets';

// ADDED IN FROXLOR 0.9.6-svn5
$lng['serversettings']['mod_fcgid']['defaultini'] = 'Standaard PHP-configuratie voor nieuwe domeinen';

// ADDED IN FROXLOR 0.9.6-svn6
$lng['admin']['ftpserver'] = 'FTP Server';
$lng['admin']['ftpserversettings'] = 'Instellingen FTP-server';
$lng['serversettings']['ftpserver']['desc'] = 'Indien PureFTPD geselecteerd is, worden .ftpquota bestanden dagelijks aangemaakt en/of bijgewerkt';

// CHANGED IN FROXLOR 0.9.6-svn6
$lng['serversettings']['ftpprefix']['description'] = 'Welk voorvoegsel dienen nieuwe FTP-accounts te krijgen?<br/><b>Indien u dit wijzigt, dient ook de query voor Quota in het configuratiebestand van de FTP-server aan te passen!</b> ';

// ADDED IN FROXLOR 0.9.7-svn1
$lng['customer']['ftp_add']['infomail_subject'] = '[Froxlor] Nieuwe FTP-gebruiker aangemaakt';
$lng['customer']['ftp_add']['infomail_body']['main'] = "Geachte {CUST_NAME},\n\nu hebt zojuist een nieuwe FTP-gebruiker aangemaakt. Hier is de opgegeven informatie:\n\nGebruikersnaam: {USR_NAME}\nWachtwoord: {USR_PASS}\nPad: {USR_PATH}\n\nMet vriendelijke groet, uw beheerder";
$lng['domains']['redirectifpathisurl'] = 'Doorverwijzingscode (standaard: leegt)';
$lng['domains']['redirectifpathisurlinfo'] = 'U dient deze alleen op te geven indien u een URL als pad hebt opgegeven';
$lng['serversettings']['customredirect_enabled']['title'] = 'Klanten toestaan doorverwijzingen te maken';
$lng['serversettings']['customredirect_enabled']['description'] = 'Klanten toestaan de HTTP-statuscode aan te passen die voor dooverwijzingen gebruikt worden';
$lng['serversettings']['customredirect_default']['title'] = 'Standaard doorverwijzing';
$lng['serversettings']['customredirect_default']['description'] = 'Kies de standaard doorverwijzingscode indien de klant dit zelf niet gedaan heeft';

// ADDED IN FROXLOR 0.9.7-svn2
$lng['error']['pathmaynotcontaincolon'] = 'Het opgegeven pad mag geen dubbele punt (":") bevatten. Geef een correct pad op.';
$lng['tasks']['aps_task_install'] = 'Installeren van 1 of meerdere APS-pakketten';
$lng['tasks']['aps_task_remove'] = 'Verwijderen van 1 of meerdere APS-pakketten';
$lng['tasks']['aps_task_reconfigure'] = 'Herconfigureren van 1 of meerdere APS-pakketten';
$lng['tasks']['aps_task_upgrade'] = 'Bijwerken van 1 of meerdere APS-pakketten';
$lng['tasks']['aps_task_sysupdate'] = 'Bijwerken van alle APS-pakketten';
$lng['tasks']['aps_task_sysdownload'] = 'Downloaden van alle APS-pakketten';

// ADDED IN FROXLOR 0.9.8
$lng['error']['exception'] = '%s';

// ADDED IN FROXLOR 0.9.9-svn1
$lng['serversettings']['mail_also_with_mxservers'] = 'Maak mail-, imap-, pop3- en smtp-"A record" ook wanneer MX-Servers zijn ingesteld';

// ADDED IN FROXLOR 0.9.10-svn1
$lng['aps']['nocontingent'] = 'Uw aantal APS-installaties is onvoldoende. U kunt geen enkel pakket installeren.';
$lng['aps']['packageneedsdb'] = 'Dit pakket vereist een database, maar uw quotum is reeds verbruikt';
$lng['aps']['cannoteditordeleteapsdb'] = 'APS databases kunnen hier niet verwijderd of aangepast worden';
$lng['admin']['webserver_user'] = 'Gebruikersnaam webserver';
$lng['admin']['webserver_group'] = 'Groepnaam webserver';

// ADDED IN FROXLOR 0.9.10
$lng['serversettings']['froxlordirectlyviahostname'] = 'Froxlor is direct toegankelijk via hostnaam';

// ADDED IN FROXLOR 0.9.11-svn1
$lng['serversettings']['panel_password_regex']['title'] = 'Reguliere expressie voor wachtwoorden';
$lng['serversettings']['panel_password_regex']['description'] = 'Hier kunt u een reguliere expressie opgeven voor de complexiteit van wachtwoorden.<br />Leeg betekent geen speciale complexiteit<br />(<a target="blank" href="http://redmine.froxlor.org/projects/froxlor/wiki/En-password-regex-examples">regex hulp/voorbeelden</a>)';
$lng['error']['notrequiredpasswordcomplexity'] = 'Er is niet voldaan aan de complexiteit voor het wachtwoord (regex: %s)';

// ADDED IN FROXLOR 0.9.11-svn2
$lng['extras']['execute_perl'] = 'perl/CGI uitvoeren';
$lng['admin']['perlenabled'] = 'Perl ingeschakeld';

// ADDED IN FROXLOR 0.9.11-svn3
$lng['serversettings']['perl_path']['title'] = 'Pad naar Perl';
$lng['serversettings']['perl_path']['description'] = 'Alleen relevant voor lighttpd. Standaard is /usr/bin/perl';

// ADDED IN FROXLOR 0.9.12-svn1
$lng['admin']['fcgid_settings'] = 'FCGID';
$lng['serversettings']['mod_fcgid_ownvhost']['title'] = 'FCGID inschakelen voor de VHost voor Froxlor';
$lng['serversettings']['mod_fcgid_ownvhost']['description'] = 'Indien ingeschakeld wordt Froxlor ook uitgevoerd onder een lokale gebruiker<br /><strong>Let op:</strong>Dit vereist handmatige configuratie, zie <a target="blank" href="http://redmine.froxlor.org/projects/froxlor/wiki/FCGID_-_handbook">FCGID - handbook</a>';
$lng['admin']['mod_fcgid_user'] = 'Lokale gebruiker voor FCGID (Froxlor vhost)';
$lng['admin']['mod_fcgid_group'] = 'Lokale groep voor FCGID (Froxlor vhost)';

// ADDED IN FROXLOR 0.9.12-svn2
$lng['admin']['perl_settings'] = 'Perl/CGI';
$lng['serversettings']['perl']['suexecworkaround']['title'] = 'Om SuExec heenwerken (Geldt alleen voor Apache)';
$lng['serversettings']['perl']['suexecworkaround']['description'] = 'Schakel dit alleen in indien de documentmappen van klanten niet in het pad van Apache SuExec vallen.<br />Indien ingeschakeld zal Froxlor een symbolische link maken voor het pad waarvoor Perl actief is + /cgi-bin/.<br />Merk op dat Perl dan alleen werkt in de submap /cgi-bin/ en niet in de map zelf (zoals het werkt zonder deze oplossing!)';
$lng['serversettings']['perl']['suexeccgipath']['title'] = 'Pad naar symbolische links naar Perl-mappen van klanten';
$lng['serversettings']['perl']['suexeccgipath']['description'] = 'U dient dit alleen op te geven indien "Om SuExec heenwerken" actief is.<br />LET OP: Zorg ervoor dat deze map onder het pad van SuExec valt, anders is deze oplossing waardeloos';
$lng['panel']['descriptionerrordocument'] = 'Kan een URL, pad naar een bestand of een tekenreeks zijn die is omsloten door " "<br />Laat leeg voor de standaardwaarde.';
$lng['error']['stringerrordocumentnotvalidforlighty'] = 'Een tekenreeks als ErrorDocuemtn werkt niet in lighttpd. Geef een pad naar een bestand';
$lng['error']['urlerrordocumentnotvalidforlighty'] = 'Een tekenreeks als ErrorDocuemtn werkt niet in lighttpd. Geef een pad naar een bestand';

// ADDED IN FROXLOR 0.9.12-svn3
$lng['question']['remove_subbutmain_domains'] = 'Verwijder ook domeinen die als volledige domeinen zijn opgegeven maar een subdomein zijn van dit domein?';
$lng['domains']['issubof'] = 'Dit domein is een subdomein van een ander domein';
$lng['domains']['issubofinfo'] = 'U dient het correcte domein op te geven indien u een subdomein als volledig domein wilt (bijvoorbeeld als u "www.domain.tld" wilt gebruiken, dan geeft u hier "domain.tld")';
$lng['domains']['nosubtomaindomain'] = 'Geen subdomein van volledig domein';
$lng['admin']['templates']['new_database_by_customer'] = 'Klantnotificatie wanneer een database is aangemaakt';
$lng['admin']['templates']['new_ftpaccount_by_customer'] = 'Klantnotificatie wanneer een FTP-gebruiker is aangemaakt';
$lng['admin']['templates']['newdatabase'] = 'Notificatie mails voor nieuwe databases';
$lng['admin']['templates']['newftpuser'] = 'Notificatie mails voor nieuwe FTP-gebruikers';
$lng['admin']['templates']['CUST_NAME'] = 'Naam klant';
$lng['admin']['templates']['DB_NAME'] = 'Naam database';
$lng['admin']['templates']['DB_PASS'] = 'Wachtwoord database';
$lng['admin']['templates']['DB_DESC'] = 'Beschrijving database';
$lng['admin']['templates']['DB_SRV'] = 'Database server';
$lng['admin']['templates']['PMA_URI'] = 'URL naar phpMyAdmin (indien opgegeven)';
$lng['admin']['notgiven'] = '[niet opgegeven]';
$lng['admin']['templates']['USR_NAME'] = 'Gebruikersnaam FTP';
$lng['admin']['templates']['USR_PASS'] = 'Wachtwoord FTP';
$lng['admin']['templates']['USR_PATH'] = 'Map FTP (relatief aan docroot van klant)';

// ADDED IN FROXLOR 0.9.12-svn4
$lng['serversettings']['awstats_awstatspath'] = 'Pad naar AWStats \'awstats.pl\'';

// ADDED IN FROXLOR 0.9.12-svn6
$lng['extras']['htpasswdauthname'] = 'Reden voor authenticatie (AuthName)';
$lng['extras']['directoryprotection_edit'] = 'mapbeveiliging aanpassen';
$lng['admin']['templates']['forgotpwd'] = 'Notificatie mails voor opnieuw instellen wachtwoord';
$lng['admin']['templates']['password_reset'] = 'Klantnotificatie voor opnieuw instellen wachtwoord';
$lng['admin']['store_defaultindex'] = 'Standaard indexbestand opslaan in map klant';

// ADDED IN FROXLOR 0.9.13-svn1
$lng['customer']['autoresponder'] = 'Automatische beantwoorder';
// ADDED IN FROXLOR 0.9.14-svn1
$lng['serversettings']['mod_fcgid']['defaultini_ownvhost'] = 'Standaard configuratie voor Froxlor-vHost';

// ADDED IN FROXLOR 0.9.14-svn3
$lng['serversettings']['awstats_icons']['title'] = 'Pad naar iconen AWstats icons';
$lng['serversettings']['awstats_icons']['description'] = 'bijvoorbeeld /usr/share/awstats/htdocs/icon/';

// ADDED IN FROXLOR 0.9.14-svn4
$lng['admin']['ipsandports']['ssl_cert_chainfile'] = 'Pad naar SSL CertificateChainFile';

// ADDED IN FROXLOR 0.9.14-svn5
$lng['admin']['ipsandports']['docroot']['title'] = 'Aangepaste docroot (leeg = verwijzing naar Froxlor)';
$lng['admin']['ipsandports']['docroot']['description'] = 'U kunt voor deze IP/poortcombinatie een aangepaste document-root opgeven.<br /><strong>LET OP:</strong> Pas op wat u hier neerzet!';

// ADDED IN FROXLOR 0.9.14-svn6
$lng['serversettings']['login_domain_login'] = 'Login met domeinen toestaan';

// ADDED IN FROXLOR 0.9.14
$lng['panel']['unlock'] = 'ontgrendelen';
$lng['question']['customer_reallyunlock'] = 'Weet u zeker dat u klant %s? wilt ontgrendelen';

// ADDED IN FROXLOR 0.9.15-svn1
$lng['serversettings']['perl_server']['title'] = 'Server locatie Perl';
$lng['serversettings']['perl_server']['description'] = 'Standaard is ingesteld op de gids: <a target="blank" href="http://wiki.nginx.org/SimpleCGI">http://wiki.nginx.org/SimpleCGI</a>';
$lng['serversettings']['nginx_php_backend']['title'] = 'Nginx PHP backend';
$lng['serversettings']['nginx_php_backend']['description'] = 'dit is waar het PHP-proces luistert naar verzoeken van nginx, kan een unix socket van ip:poort combinatie zijn';
$lng['serversettings']['phpreload_command']['title'] = 'Commando voor het herladen van PHP';
$lng['serversettings']['phpreload_command']['description'] = 'wordt gebruikt om de PHP backend opnieuw te laden, indien actief<br />Standaard: leeg';

// ADDED IN FROXLOR 0.9.16
$lng['error']['intvaluetoolow'] = 'Het opgegeven nummer is te laag (veld %s)';
$lng['error']['intvaluetoohigh'] = 'Het opgegeven nummer is te hoog (veld %s)';
$lng['admin']['phpfpm_settings'] = 'PHP-FPM';
$lng['serversettings']['phpfpm'] = 'php-fpm inschakelen';
$lng['serversettings']['phpfpm_settings']['configdir'] = 'Configuratiemap van php-fpm';
$lng['serversettings']['phpfpm_settings']['reload'] = 'Commando voor het herstarten van php-fpm';
$lng['serversettings']['phpfpm_settings']['pm'] = 'Process manager control (pm)';
$lng['serversettings']['phpfpm_settings']['max_children']['title'] = 'Het aantal subprocessen';
$lng['serversettings']['phpfpm_settings']['max_children']['description'] = 'Het aantal subprocessen dat gestart wordt indien PM is ingesteld op  \'statisch\' en het maximum aantal subprocessen wanneer PM is ingesteld op \'dynamisch\'<br />Gelijk aan PHP_FCGI_CHILDREN';
$lng['serversettings']['phpfpm_settings']['start_servers']['title'] = 'Het aantal subprocessen bij het starten';
$lng['serversettings']['phpfpm_settings']['start_servers']['description'] = 'Noot: Wordt alleen gebruikt indien PM is ingesteld op \'dynamisch\'';
$lng['serversettings']['phpfpm_settings']['min_spare_servers']['title'] = 'Het gewenste minimum aantal vrije subprocessen';
$lng['serversettings']['phpfpm_settings']['min_spare_servers']['description'] = 'Noot: Wordt alleen gebruikt indien PM is ingesteld op \'dynamisch\'<br />Noot: Verplicht wanneer PM ingesteld is op \'dynamisch\'';
$lng['serversettings']['phpfpm_settings']['max_spare_servers']['title'] = 'THet gewenste minimum aantal vrije subprocessen';
$lng['serversettings']['phpfpm_settings']['max_spare_servers']['description'] = 'Noot: Wordt alleen gebruikt indien PM is ingesteld op \'dynamisch\'<br />Noot: Verplicht wanneer PM ingesteld is op \'dynamisch\'';
$lng['serversettings']['phpfpm_settings']['max_requests']['title'] = 'Verzoeken voor subproces voordat het opnieuw gestart wordt';
$lng['serversettings']['phpfpm_settings']['max_requests']['description'] = 'Voor het eindeloos verwerken kunt u deze waarde instellen op \'0\'. Gelijk aan PHP_FCGI_MAX_REQUESTS.';
$lng['error']['phpfpmstillenabled'] = 'PHP-FPM is op dit moment actief, schakel dit eerst uit voordat u FCGID inschakelt';
$lng['error']['fcgidstillenabled'] = 'FCGID is op dit moment actief. schakel dit eerst uit voordat u PHP-FPM inschakelt';
