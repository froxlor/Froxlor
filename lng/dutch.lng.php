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
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Language
 * @version    $Id$
 */

/**
 * Global
 */

$lng['translator'] = 'Sander Klein';
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
$lng['question']['admin_domain_reallydisablesecuritysetting'] = 'Weet u echt heel zeker dat deze beveiligings instellingen wilt deactiveren (OpenBasedir en/of SafeMode)?';
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

$lng['mails']['pop_success']['mailbody'] = 'Hallo,\n\nUw mail account {EMAIL}\nis succesvol aangemaakt.\n\nDit is een automatisch verstuurde\ne-mail, beantwoord deze niet AUB!\n\nMet vriendelijke groet, het Froxlor-Team';
$lng['mails']['pop_success']['subject'] = 'Mail account succesvol aangemaakt';
$lng['mails']['createcustomer']['mailbody'] = 'Hallo {FIRSTNAME} {NAME},\n\nhierbij uw account informatie:\n\nGebruikersnaam: {USERNAME}\nWachtwoord: {PASSWORD}\n\nMet vriendelijke groet,\nhet Froxlor-Team';
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
$lng['admin']['configfiles']['files'] = '<b>Configuratiebestanden:</b> Wijzig de volgende bestanden of maak ze aan met<br />de volgende inhoud als u dit nog niet gedaan heeft.<br /><b>Let Op:</b> Het MySQL-wachtwoord is niet aangepast vanwege beveiligings overwegingen.<br />Vervang &quot;MYSQL_PASSWORD&quot; zelf. Als u uw MYSQl wachtwoord vergeten bent<br />kunt u het terugvinden in &quot;lib/userdata.inc.php&quot;.';
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

$lng['admin']['cronlastrun'] = 'Laatste Cron-run';
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
$lng['admin']['valuemandatorycompany'] = 'De waarde &quot;naam&quot; en &quot;voornaam&quot; of &quot;bedrijf&quot; moet ingevoerd worden';
$lng['menue']['main']['username'] = 'Ingelogged als: ';
$lng['panel']['urloverridespath'] = 'URL (Vervangd path)';
$lng['panel']['pathorurl'] = 'Pad of URL';
$lng['error']['sessiontimeoutiswrong'] = 'Alleen nummerieke &quot;Session Timeout&quot; zijn toegestaan.';
$lng['error']['maxloginattemptsiswrong'] = 'Alleen nummerieke &quot;Maximaal aantal inlogpogingen&quot; zijn toegestaan.';
$lng['error']['deactivatetimiswrong'] = 'Allee nummerieke &quot;Deactivatie Tijd&quot; zijn toegestaan.';
$lng['error']['accountprefixiswrong'] = 'Het &quot;Klan voorvoegsel&quot; is verkeerd.';
$lng['error']['mysqlprefixiswrong'] = 'Het &quot;SQL voorvoegsel&quot; is verkeerd.';
$lng['error']['ftpprefixiswrong'] = 'Het &quot;FTP voorvoegsel&quot; is verkeerd.';
$lng['error']['ipiswrong'] = 'Het &quot;IP-Adres&quot; is verkeerd. Alleen een geldig ip-adres is toegestaan.';
$lng['error']['vmailuidiswrong'] = 'Het &quot;Mails-uid&quot; is verkeerd. Alleen een nummeriek UID is toegestaan.';
$lng['error']['vmailgidiswrong'] = 'Het &quot;Mails-gid&quot; is verkeerd. Alleen een nummeriek GID is toegestaan.';
$lng['error']['adminmailiswrong'] = 'Het &quot;Afzender-adres&quot; is verkeerd. Alleen geldige e-mail adressen zijn toegestaan.';
$lng['error']['pagingiswrong'] = 'Het aantal &quot;Vermeldingen per pagina&quot; is verkeerd. Alleen nummerieke karakters zijn toegestaan.';
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

$lng['error']['stringformaterror'] = 'De waarde voor het veld &quot;%s&quot; is niet in het verwachte formaat.';

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

$lng['error']['loginnameissystemaccount'] = 'U kunt geen accounts aanmaken die gelijk zijn aan systeem accounts (bijvoorbeeld beginnend met &quot;%s&quot;). Kies een andere accountnaam AUB.';

?>
