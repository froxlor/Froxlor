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
 * @author     Staffan Starberg <staff@starberg.com>
 * @author     Froxlor Team <team@froxlor.org>
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Language
 *
 */

/**
 * Global
 */

$lng['translator'] = 'Staffan Starberg';
$lng['panel']['edit'] = '�ndra';
$lng['panel']['delete'] = 'Radera';
$lng['panel']['create'] = 'Skapa';
$lng['panel']['save'] = 'Spara';
$lng['panel']['yes'] = 'Ja';
$lng['panel']['no'] = 'Nej';
$lng['panel']['emptyfornochanges'] = 'Tomt f�lt = ingen �ndring';
$lng['panel']['emptyfordefault'] = 'F�rvalt v�rde anv�nds om f�ltet l�mnas tommt';
$lng['panel']['path'] = 'S�kv�g (Path)';
$lng['panel']['toggle'] = 'V�xla (Toggle)';
$lng['panel']['next'] = 'n�sta';
$lng['panel']['dirsmissing'] = 'Kan inte hitta eller l�sa katalogen!';

/**
 * Login
 */

$lng['login']['username'] = 'Anv�ndarnamn';
$lng['login']['password'] = 'L�senord';
$lng['login']['language'] = 'Spr�k';
$lng['login']['login'] = 'Logga in';
$lng['login']['logout'] = 'Logga ut';
$lng['login']['profile_lng'] = 'Profilspr�k';

/**
 * Customer
 */

$lng['customer']['documentroot'] = 'Hemkatalog';
$lng['customer']['name'] = 'Efternamn';
$lng['customer']['firstname'] = 'F�rnamn';
$lng['customer']['company'] = 'F�retag';
$lng['customer']['street'] = 'Postadress';
$lng['customer']['zipcode'] = 'Postnummer';
$lng['customer']['city'] = 'Postort';
$lng['customer']['phone'] = 'Telefon';
$lng['customer']['fax'] = 'Fax';
$lng['customer']['email'] = 'E-post';
$lng['customer']['customernumber'] = 'Kundnummer';
$lng['customer']['diskspace'] = 'Webb (MB)';
$lng['customer']['traffic'] = 'Trafik (GB)';
$lng['customer']['mysqls'] = 'SQL_DBas';
$lng['customer']['emails'] = 'E-post_adresser';
$lng['customer']['accounts'] = 'E-post_konton';
$lng['customer']['forwarders'] = 'E-post_skicka_vidare';
$lng['customer']['ftps'] = 'FTP_Kto';
$lng['customer']['subdomains'] = 'Sub-Dom�ner';
$lng['customer']['domains'] = 'Dom�ner';
$lng['customer']['unlimited'] = 'Obegr�nsad';

/**
 * Customermenue
 */

$lng['menue']['main']['main'] = 'Huvudsidan';
$lng['menue']['main']['changepassword'] = '�ndra l�senord';
$lng['menue']['main']['changelanguage'] = '�ndra spr�k';
$lng['menue']['email']['email'] = 'E-post';
$lng['menue']['email']['emails'] = 'E-post';
$lng['menue']['email']['webmail'] = 'WebMail';
$lng['menue']['mysql']['mysql'] = 'MySQL';
$lng['menue']['mysql']['databases'] = 'Databaser';
$lng['menue']['mysql']['phpmyadmin'] = 'phpMyAdmin';
$lng['menue']['domains']['domains'] = 'Dom�ner';
$lng['menue']['domains']['settings'] = 'Inst�llningar';
$lng['menue']['ftp']['ftp'] = 'FTP';
$lng['menue']['ftp']['accounts'] = 'Konton';
$lng['menue']['ftp']['webftp'] = 'WebFTP';
$lng['menue']['extras']['extras'] = 'Extras';
$lng['menue']['extras']['directoryprotection'] = 'Katalog s�kerhet';
$lng['menue']['extras']['pathoptions'] = 'Inst�llningar s�kv�g';

/**
 * Index
 */

$lng['index']['customerdetails'] = 'Kunddetaljer';
$lng['index']['accountdetails'] = 'Kontodetaljer';

/**
 * Change Password
 */

$lng['changepassword']['old_password'] = 'Gammalt l�senord';
$lng['changepassword']['new_password'] = 'Nytt l�senord';
$lng['changepassword']['new_password_confirm'] = 'Nytt l�senord (verifiera)';
$lng['changepassword']['new_password_ifnotempty'] = 'Nytt l�senord (Tomt f�ltet = inga �ndringar)';
$lng['changepassword']['also_change_ftp'] = ' �ndra �ven l�senord f�r huvud FTP kontot';

/**
 * Domains
 */

$lng['domains']['description'] = 'H�r kan du skapa (sub-)dom�ner och �ndra i dem.<br />Systemet beh�ver dock lite tid p� sig att genomf�ra �ndringarna.';
$lng['domains']['domainsettings'] = 'Dom�ninst�llningar';
$lng['domains']['domainname'] = 'Dom�nnamn';
$lng['domains']['subdomain_add'] = '[Skapa en ny subdom�n]';
$lng['domains']['subdomain_edit'] = '�ndra (sub)dom�n';
$lng['domains']['wildcarddomain'] = 'Skapa som ospecificerad dom�n (Create as wildcarddomain?)';
$lng['domains']['aliasdomain'] = 'Alias for dom�n';
$lng['domains']['noaliasdomain'] = '(inget alias)';

/**
 * E-mails
 */

$lng['emails']['description'] = 'H�r kan du skapa eller �ndra dina E-postadresser.<br />Ett konto �r som en brevl�da utanf�r huset. Om n�gon skickar dig E-post kommer det att hamna i din brevl�da (ditt konto).<br /><br />F�r att h�mta din E-post s� skall du anv�nda f�ljande inst�llningar i ditt E-postprogram: (Text i kursiv stil <i>italics</i> m�ste �ndras till det som motsvaras av det du knappade in tidigare!)<br />Servernamn (Hostname): <b><i>Dom�nnamn (Domainname)</i></b><br />Anv�ndarnamn (Username): <b><i>Konto namn (Account name) / E-postadress</i></b><br />L�senord (Password): <b><i>l�senordet som du valde</i></b>';
$lng['emails']['emailaddress'] = 'E-postadress';
$lng['emails']['emails_add'] = '[Skapa en E-postadress]';
$lng['emails']['emails_edit'] = '�ndra E-postadressen';
$lng['emails']['catchall'] = 'Maildump';
$lng['emails']['iscatchall'] = 'Skapa en maildump?';
$lng['emails']['account'] = 'Konto';
$lng['emails']['account_add'] = 'Skapa konto';
$lng['emails']['account_delete'] = 'Radera konto';
$lng['emails']['from'] = 'Fr�n';
$lng['emails']['to'] = 'Till';
$lng['emails']['forwarders'] = 'Skicka vidare:';
$lng['emails']['forwarder_add'] = '[Skapa ny "skicka vidare"]';

/**
 * FTP
 */

$lng['ftp']['description'] = 'H�r kan du skapa eller �nra i dina FTP konton.<br />�ndringen genomf�rs omedelbart s� man kan anv�nda det nya/�ndrade kontot direkt.';
$lng['ftp']['account_add'] = '[Skapa ett nytt FTP konto]';

/**
 * MySQL
 */

$lng['mysql']['databasename'] = 'Anv�ndare/databasnamn';
$lng['mysql']['databasedescription'] = 'Beskrivning av databasen';
$lng['mysql']['database_create'] = '[Skapa en ny databas]';

/**
 * Extras
 */

$lng['extras']['description'] = 'H�r kan du �ndra �vriga saker s�som katalogskydd mm.<br />Systemet beh�ver dock lite tid p� sig att genomf�ra �ndringarna.';
$lng['extras']['directoryprotection_add'] = '[Skapa ett nytt katalogskydd]';
$lng['extras']['view_directory'] = 'Visa kataloginneh�ll';
$lng['extras']['pathoptions_add'] = '[Skapa ny regel f�r s�kv�gar]';
$lng['extras']['directory_browsing'] = 'Visning av katalogstruktur';
$lng['extras']['pathoptions_edit'] = '�ndra s�kv�gsinst�llningar';
$lng['extras']['error404path'] = '404';
$lng['extras']['error403path'] = '403';
$lng['extras']['error500path'] = '500';
$lng['extras']['error401path'] = '401';
$lng['extras']['errordocument404path'] = 'URL to ErrorDocument 404';
$lng['extras']['errordocument403path'] = 'URL to ErrorDocument 403';
$lng['extras']['errordocument500path'] = 'URL to ErrorDocument 500';
$lng['extras']['errordocument401path'] = 'URL to ErrorDocument 401';

/**
 * Errors
 */

$lng['error']['error'] = 'F�ljande fel har uppst�tt';
$lng['error']['directorymustexist'] = 'Katalogen %s m�ste finnas. Skapa den med ditt FTP program.';
$lng['error']['filemustexist'] = 'Filen %s m�ste existera.';
$lng['error']['allresourcesused'] = 'Du har redan skapt s� m�nga konton som du har tillst�nd till.';
$lng['error']['domains_cantdeletemaindomain'] = 'Du kan inte radera en dom�n som anv�ndes f�r E-post.';
$lng['error']['domains_canteditdomain'] = 'Endast administrat�rer kan �ndra denna dom�n.';
$lng['error']['domains_cantdeletedomainwithemail'] = 'Du kan inte radera en dom�n som anv�ndes f�r E-post. Radera alla E-postadresser f�rst';
$lng['error']['firstdeleteallsubdomains'] = 'Du m�ste radera alla sub-dom�ner innan du kan skapa en maildump (wildcard domain).';
$lng['error']['youhavealreadyacatchallforthisdomain'] = 'Du har redan skapat en maildump f�r denna dom�n.';
$lng['error']['ftp_cantdeletemainaccount'] = 'Det g�r inte att radera huvud FTP kontot f�r dom�nen';
$lng['error']['login'] = 'Anv�ndarnamnet eller l�senordet var felaktigt, f�rs�k igen!';
$lng['error']['login_blocked'] = 'Kontot har blivit avst�ngt p� grund av f�r m�nga felaktiga inloggningsf�rs�k. <br />F�rs�k igen om ' . $settings['login']['deactivatetime'] . ' sekunder.';
$lng['error']['notallreqfieldsorerrors'] = 'Du har inte fyllt i alla f�lt eller s� har du skrivit in n�got som inte accepteras.';
$lng['error']['oldpasswordnotcorrect'] = 'Det gamla l�senordet �r fel.';
$lng['error']['youcantallocatemorethanyouhave'] = 'Du kan inte skapa fler resurser �n du �ger sj�lv (You cannot allocate more resources than you own for yourself).';
$lng['error']['mustbeurl'] = 'Du har inte skrivit in en korrekt url (e.g. http://somedomain.com/error404.htm)';
$lng['error']['invalidpath'] = 'Du har inte valt en korrekt url (Kanske har du lagt till en katalogs�kerhet s� att katalogerna inte kan visas?)';
$lng['error']['stringisempty'] = 'Du m�ste skriva in n�got i f�ltet';
$lng['error']['stringiswrong'] = 'Fel inatningsf�lt';
$lng['error']['myloginname'] = '\'' . $lng['login']['username'] . '\'';
$lng['error']['mypassword'] = '\'' . $lng['login']['password'] . '\'';
$lng['error']['oldpassword'] = '\'' . $lng['changepassword']['old_password'] . '\'';
$lng['error']['newpassword'] = '\'' . $lng['changepassword']['new_password'] . '\'';
$lng['error']['newpasswordconfirm'] = '\'' . $lng['changepassword']['new_password_confirm'] . '\'';
$lng['error']['newpasswordconfirmerror'] = 'New password and confirmation does not match';
$lng['error']['myname'] = '\'' . $lng['customer']['name'] . '\'';
$lng['error']['myfirstname'] = '\'' . $lng['customer']['firstname'] . '\'';
$lng['error']['emailadd'] = '\'' . $lng['customer']['email'] . '\'';
$lng['error']['mydomain'] = '\'Domain\'';
$lng['error']['mydocumentroot'] = '\'Documentroot\'';
$lng['error']['loginnameexists'] = 'Login-Name %s �r upptaget';
$lng['error']['emailiswrong'] = 'E-post-Adressen "%s" inneh�ller ogiltiga tecken eller s� �r den inte komplett';
$lng['error']['loginnameiswrong'] = 'Login-Namnet %s inneh�ller ogiltiga tecken';
$lng['error']['userpathcombinationdupe'] = 'Anv�ndarnamnet och s�kv�gen tillsammans finns redan';
$lng['error']['patherror'] = 'Generellt Fel! s�kv�gen till katalogen kan inte vara tom';
$lng['error']['errordocpathdupe'] = 'Option f�r s�kv�gen %s finns redan';
$lng['error']['adduserfirst'] = 'Skapa anv�ndaren f�rst';
$lng['error']['domainalreadyexists'] = 'Dom�nen %s �gs redan av en kund';
$lng['error']['nolanguageselect'] = 'Inget spr�k �r valt.';
$lng['error']['nosubjectcreate'] = 'Du m�ste ha ett rubrik f�r denna E-postmall.';
$lng['error']['nomailbodycreate'] = 'Du m�ste ha skrivit in en E-post text f�r denna mall.';
$lng['error']['templatenotfound'] = 'E-postmallen hittades inte.';
$lng['error']['alltemplatesdefined'] = 'Du kan inte skapa flera mallar, alla spr�k finns redan.';
$lng['error']['wwwnotallowed'] = 'www �r inte till�tet att anv�nda f�r subdom�ner.';
$lng['error']['subdomainiswrong'] = 'Subdom�nen %s inneh�ller ogiltiga tecken.';
$lng['error']['domaincantbeempty'] = 'F�ltet f�r dom�nnamn f�r inte vara tommt.';
$lng['error']['domainexistalready'] = 'Dom�nen %s finns redan.';
$lng['error']['domainisaliasorothercustomer'] = 'Den valda dom�nen �r antingen en aliasdom�n eller s� �gs den redan av en annan kund.';
$lng['error']['emailexistalready'] = 'E-postadressen %s finns redan.';
$lng['error']['maindomainnonexist'] = 'Huvuddom�nen %s finns inte.';
$lng['error']['destinationnonexist'] = 'Skapa en forwarder i f�ltet \'Destination\'.';
$lng['error']['destinationalreadyexistasmail'] = 'Denna forwarder %s, finns redan som aktiv E-postadress.';
$lng['error']['destinationalreadyexist'] = 'Du har redan skapat en forwarder till %s .';
$lng['error']['destinationiswrong'] = 'Denna forwarder: %s inneh�ller ogiltiga tecken eller s� �r den inte komplett adress.';
$lng['error']['domainname'] = $lng['domains']['domainname'];

/**
 * Questions
 */

$lng['question']['question'] = 'S�kerhetsfr�ga';
$lng['question']['admin_customer_reallydelete'] = '�r du s�ker p� att du vill radera kunden %s? Om du v�ljer att radera g�r det inte att �ngra sig efter�t!';
$lng['question']['admin_domain_reallydelete'] = '�r du riktigt s�ker p� att du vill radera dom�nen %s?';
$lng['question']['admin_domain_reallydisablesecuritysetting'] = '�r du riktigt s�ker p� att du vill avaktivera s�kerhetsinst�llningarna (OpenBasedir)?';
$lng['question']['admin_admin_reallydelete'] = '�r du riktigt s�ker p� att du vill radera adminkontot %s? Alla kunder och dom�ner kommer att flyttas till ditt konto ist�llet.';
$lng['question']['admin_template_reallydelete'] = '�r du riktigt s�ker p� att du vill radera mallen \'%s\'?';
$lng['question']['domains_reallydelete'] = '�r du riktigt s�ker p� att du vill radera dom�nen %s?';
$lng['question']['email_reallydelete'] = '�r du riktigt s�ker p� att du vill radera E-postadressen %s?';
$lng['question']['email_reallydelete_account'] = '�r du riktigt s�ker p� att du vill radera E-postkontot %s?';
$lng['question']['email_reallydelete_forwarder'] = '�r du riktigt s�ker p� att du vill radera forwardern till %s?';
$lng['question']['extras_reallydelete'] = '�r du riktigt s�ker p� att du vill radera katalogs�kerheten (directory protection) f�r %s?';
$lng['question']['extras_reallydelete_pathoptions'] = '�r du riktigt s�ker p� att du vill radera katalogalternativen (path options) f�r %s?';
$lng['question']['ftp_reallydelete'] = '�r du riktigt s�ker p� att du vill radera FTP kontot %s?';
$lng['question']['mysql_reallydelete'] = '�r du riktigt s�ker p� att du vill radera databasen %s? Om du v�ljer att radera g�r det inte att �ngra sig efter�t!';
$lng['question']['admin_configs_reallyrebuild'] = '�r du riktigt s�ker p� att du vill skapa nya konfigurationsfiler f�r apache och bind?';

/**
 * Mails
 */

$lng['mails']['pop_success']['mailbody'] = 'Hej,\n\nDitt E-postkonto {EMAIL}\nhar nu skapats.\n\nDetta �r ett automatgenererat E-post meddelande\n, Det g�r d�rf�r inte att svara p� detta meddelande!\n';
$lng['mails']['pop_success']['subject'] = 'E-postkontot �r nu skapat';
$lng['mails']['createcustomer']['mailbody'] = 'Hej {FIRSTNAME} {NAME},\n\nH�r kommer kontoinformationen f�r ditt konto:\n\nAnv�ndarnamn (Username): {USERNAME}\nL�senord (Password): {PASSWORD}\n\n';
$lng['mails']['createcustomer']['subject'] = 'Kontoinformation';

/**
 * Admin
 */

$lng['admin']['overview'] = '�versikt';
$lng['admin']['ressourcedetails'] = 'Anv�nda resurser';
$lng['admin']['systemdetails'] = 'System Detaljer';
$lng['admin']['froxlordetails'] = 'Froxlor Detaljer';
$lng['admin']['installedversion'] = 'Installerad version av Froxlor';
$lng['admin']['latestversion'] = 'Senaste version av Froxlor';
$lng['admin']['lookfornewversion']['clickhere'] = '[S�k senaste verison av Froxlor via Internet]';
$lng['admin']['lookfornewversion']['error'] = 'Fel vid l�sning, kontrollera uppkopplingen mot Froxlor';
$lng['admin']['resources'] = 'Resurser';
$lng['admin']['customer'] = 'Kunder';
$lng['admin']['customers'] = 'Kunder';
$lng['admin']['customer_add'] = '[Skapa en ny kund]';
$lng['admin']['customer_edit'] = '�ndra ny kund';
$lng['admin']['domains'] = 'Dom�ner';
$lng['admin']['domain_add'] = '[Skapa en ny dom�n]';
$lng['admin']['domain_edit'] = 'Till�t �ndring av dom�nen';
$lng['admin']['subdomainforemail'] = 'Sub-dom�n som E-postdom�n (Subdomains as emaildomains)';
$lng['admin']['admin'] = 'Admin';
$lng['admin']['admins'] = 'Admins';
$lng['admin']['admin_add'] = '[Skapa en ny admin]';
$lng['admin']['admin_edit'] = '�ndra admin';
$lng['admin']['customers_see_all'] = 'Kan se alla kunder?';
$lng['admin']['domains_see_all'] = 'Kan se alla dom�ner?';
$lng['admin']['change_serversettings'] = 'Kan �ndra serverinst�llningar?';
$lng['admin']['server'] = 'Server';
$lng['admin']['serversettings'] = 'Inst�llningar';
$lng['admin']['rebuildconf'] = 'Uppdatera konfig filer';
$lng['admin']['stdsubdomain'] = 'Standard subdom�n';
$lng['admin']['stdsubdomain_add'] = '[Skapa en ny standard subdom�n]';
$lng['admin']['phpenabled'] = 'PHP p�slagen';
$lng['admin']['deactivated'] = 'Inaktiv';
$lng['admin']['deactivated_user'] = 'Avaktivera anv�ndare';
$lng['admin']['sendpassword'] = 'Skicka l�senord';
$lng['admin']['ownvhostsettings'] = 'Egna vHost-Inst�llningar';
$lng['admin']['configfiles']['serverconfiguration'] = 'Konfiguration';
$lng['admin']['configfiles']['files'] = '<b>Konfigurationsfiler:</b> �ndra eller skapa f�ljande filer med<br />f�ljande inneh�ll om de inte finns redan.<br /><b>Notera:</b> MySQL-l�senordet har inte �ndrats p� grund av s�kerhetssk�l.<br />Du m�ste sj�lv �ndra l�senordet &quot;MYSQL_PASSWORD&quot; p� egen hand. Om du gl�mt bort ditt MySQL-password<br />s� kan du hitta det h�r &quot;lib/userdata.inc.php&quot;.';
$lng['admin']['configfiles']['commands'] = '<b>Kommandon:</b> K�r f�ljande kommandon i ett terminalf�nster.';
$lng['admin']['configfiles']['restart'] = '<b>Omstart:</b> K�r f�ljande kommandon i ett terminalf�nster f�r att ladda in den nya konfigurationen.';
$lng['admin']['templates']['templates'] = 'Mallar';
$lng['admin']['templates']['template_add'] = '[L�gg till en ny mall]';
$lng['admin']['templates']['template_edit'] = '�ndra en befintlig mall';
$lng['admin']['templates']['action'] = 'Action';
$lng['admin']['templates']['email'] = 'E-Post';
$lng['admin']['templates']['subject'] = 'Rubrik (subjekt)';
$lng['admin']['templates']['mailbody'] = 'E-Postinneh�ll (Mail body)';
$lng['admin']['templates']['createcustomer'] = 'E-Post till nya kunder (V�lkommen)';
$lng['admin']['templates']['pop_success'] = 'E-Post f�r nya konton (V�lkommen)';
$lng['admin']['templates']['template_replace_vars'] = 'Variabler som kan �ndras i mallen:';
$lng['admin']['templates']['FIRSTNAME'] = '�ndra till kundens f�rnamn.';
$lng['admin']['templates']['NAME'] = '�ndra till kundens efternamn.';
$lng['admin']['templates']['USERNAME'] = '�ndra till kundens kontonamns anv�ndarnamn.';
$lng['admin']['templates']['PASSWORD'] = '�ndra till kundens kontonamns l�senord.';
$lng['admin']['templates']['EMAIL'] = '�ndra till adressen f�r POP3/IMAP kontot.';

/**
 * Serversettings
 */

$lng['serversettings']['session_timeout']['title'] = 'Sessionen har avslutats f�r att den tog f�r l�ng tid att utf�ra (session Timeout)';
$lng['serversettings']['session_timeout']['description'] = 'Tiden (i sekunder) som anv�ndaren f�r vara inaktiv innan han m�ste logga in igen �r (seconds)?';
$lng['serversettings']['accountprefix']['title'] = 'Kund ID (Customer prefix)';
$lng['serversettings']['accountprefix']['description'] = 'Vilket prefix skall anv�ndas till ett kundkonto?';
$lng['serversettings']['mysqlprefix']['title'] = 'SQL ID (SQL Prefix)';
$lng['serversettings']['mysqlprefix']['description'] = 'Vilket prefix skall anv�ndas till mysql?';
$lng['serversettings']['ftpprefix']['title'] = 'FTP ID (FTP Prefix)';
$lng['serversettings']['ftpprefix']['description'] = 'Vilket prefix skall anv�ndas till ftp?';
$lng['serversettings']['documentroot_prefix']['title'] = 'Hemkatalog';
$lng['serversettings']['documentroot_prefix']['description'] = 'Vilken s�kv�g skall det vara till hemkatalogen?';
$lng['serversettings']['logfiles_directory']['title'] = 'Loggfilernas hemkatalog (Logfiles directory)';
$lng['serversettings']['logfiles_directory']['description'] = 'Vilken s�kv�g skall det vara till loggfilernas hemkatalog?';
$lng['serversettings']['ipaddress']['title'] = 'IP-Adress';
$lng['serversettings']['ipaddress']['description'] = 'Vilken IP-adress har denna server?';
$lng['serversettings']['hostname']['title'] = 'Datornamn (Hostname)';
$lng['serversettings']['hostname']['description'] = 'Villket Datornamn (Hostname) har denna server?';
$lng['serversettings']['apachereload_command']['title'] = 'Ladda om Apache kommandot (Apache reload)';
$lng['serversettings']['apachereload_command']['description'] = 'Ange s�kv�gen till programmet som laddar om Apache (reload apache) konfigurationsfiler?';
$lng['serversettings']['bindconf_directory']['title'] = 'Bind konfigurationskatalog (Bind config directory)';
$lng['serversettings']['bindconf_directory']['description'] = 'Vilken s�kv�g skall det vara till bind:s konfigurationsfiler?';
$lng['serversettings']['bindreload_command']['title'] = 'Ange s�kv�gen till programmet som laddar om Bind (reload bind) konfigurationsfiler?';
$lng['serversettings']['bindreload_command']['description'] = 'Ange s�kv�gen till programmet som laddar om Bind (reload bind) konfigurationsfiler?';
$lng['serversettings']['binddefaultzone']['title'] = 'Bind standard zone';
$lng['serversettings']['binddefaultzone']['description'] = 'Vad �r namnet p� standard zonen?';
$lng['serversettings']['vmail_uid']['title'] = 'Mails-UID';
$lng['serversettings']['vmail_uid']['description'] = 'Vilket anv�ndarID (UserID) ska E-posten ha?';
$lng['serversettings']['vmail_gid']['title'] = 'Mails-GID';
$lng['serversettings']['vmail_gid']['description'] = 'Vilket gruppID (GroupID) ska E-posten ha?';
$lng['serversettings']['vmail_homedir']['title'] = 'E-post hemkatalog';
$lng['serversettings']['vmail_homedir']['description'] = 'I vilken katalog skall E-posten sparas?';
$lng['serversettings']['adminmail']['title'] = 'Avs�ndare';
$lng['serversettings']['adminmail']['description'] = 'Vilken avs�ndaradress skall E-post fr�n admin panelen ha?';
$lng['serversettings']['phpmyadmin_url']['title'] = 'phpMyAdmin URL';
$lng['serversettings']['phpmyadmin_url']['description'] = 'Vilken URL �r det till phpMyAdmin? (M�ste b�rja med http(s)://)';
$lng['serversettings']['webmail_url']['title'] = 'WebMail URL';
$lng['serversettings']['webmail_url']['description'] = 'Vilken URL �r det till WebMail? (M�ste b�rja med http(s)://)';
$lng['serversettings']['webftp_url']['title'] = 'WebFTP URL';
$lng['serversettings']['webftp_url']['description'] = 'Vilken URL �r det till  WebFTP? (M�ste b�rja med http(s)://)';
$lng['serversettings']['language']['description'] = 'Vilket spr�k skall anv�ndas som standardspr�k?';
$lng['serversettings']['maxloginattempts']['title'] = 'Max antal Login f�rs�k';
$lng['serversettings']['maxloginattempts']['description'] = 'Maximalt antal inloggningsf�rs�k innan kontot st�ngs av.';
$lng['serversettings']['deactivatetime']['title'] = 'Avst�ngningstid';
$lng['serversettings']['deactivatetime']['description'] = 'Tid (sec.) som kontot st�ngs av efter f�r m�nga felaktiga f�rs�k.';
$lng['serversettings']['pathedit']['title'] = 'Typ av (path input)';
$lng['serversettings']['pathedit']['description'] = 'Skall en s�kv�g v�ljas i en rullist eller matas in f�r hand?';
$lng['serversettings']['nameservers']['title'] = 'Nameservers';
$lng['serversettings']['nameservers']['description'] = 'En kommaseparerad lista med namnet (hostname) p� alla DNS:er. Den f�rsta blir den f�rsta som s�ks (primary).';
$lng['serversettings']['mxservers']['title'] = 'MX servers';
$lng['serversettings']['mxservers']['description'] = 'En kommaseparerad lista med nummer och namn separerade men mellanslag (ex. \'10 mx.example.com\') inneh�ller mx servrarna.';

/**
 * CHANGED BETWEEN 1.2.12 and 1.2.13
 */

$lng['mysql']['description'] = 'H�r �ndras eller skapas MySQL-Databaser.<br />�ndringen sker omedelbart och databasen kan anv�ndas direkt.<br />I menyn p� v�nster sida finns verktyget phpMyAdmin med vilket man enkelt kan �ndra i sin databas.<br /><br />F�r att anv�nda databasen i dina egna php-scripts anv�nd f�ljande inst�llningar: (Data med kursiv stil <i>italics</i> m�ste �ndras till det du matat in!)<br />Servernamn (Hostname): <b><SQL_HOST></b><br />Anv�ndarnamn (Username): <b><i>Databsnamn (Databasename)</i></b><br />L�senord (Password): <b><i>L�senordet som du har valt</i></b><br />Databas (Database): <b><i>Databasnamn (Databasename)</i></b>';

/**
 * ADDED BETWEEN 1.2.12 and 1.2.13
 */

$lng['serversettings']['paging']['title'] = 'Antal rader per sida';
$lng['serversettings']['paging']['description'] = 'Hur m�nga rader skall det vara p� en sida? (0 = St�ng av sidbrytning)';
$lng['error']['ipstillhasdomains'] = 'IP/Port kombinationen som du vill radera har fortfarande dom�ner anslutna till sig, Flytta dessa till n�gon annan IP/Port kombination innan du raderar denna IP/Port kombination.';
$lng['error']['cantdeletedefaultip'] = 'Det g�r inte att ta bort den f�rvalda �terf�rs�ljarens IP/Port kombination, V�lj en annan IP/Port kombination som f�rval f�r �terf�rs�ljare innan du raderar denna IP/Port kombination.';
$lng['error']['cantdeletesystemip'] = 'Det g�r inte att radera den sista system IP:n, Antingen skapar man en ny IP/Port kombination f�r system IP eller s� �ndrar man system IP:n.';
$lng['error']['myipaddress'] = '\'IP\'';
$lng['error']['myport'] = '\'Port\'';
$lng['error']['myipdefault'] = 'Man m�ste v�lja en IP/Port kombination som skall bli standardv�rdet.';
$lng['error']['myipnotdouble'] = 'Denna IP/Port kombination finns redan.';
$lng['question']['admin_ip_reallydelete'] = '�r du s�ker p� att du vill radera IP addressen %s?';
$lng['admin']['ipsandports']['ipsandports'] = 'IPs and Ports';
$lng['admin']['ipsandports']['add'] = '[L�gg till IP/Port]';
$lng['admin']['ipsandports']['edit'] = '�ndra IP/Port';
$lng['admin']['ipsandports']['ipandport'] = 'IP/Port';
$lng['admin']['ipsandports']['ip'] = 'IP';
$lng['admin']['ipsandports']['port'] = 'Port';

// ADDED IN 1.2.13-rc3

$lng['error']['cantchangesystemip'] = 'Man kan inte �ndra den senaste system IP-adressen. Skapa en helt ny IP/Port kombination f�r system IP:n eller �ndra system IP-adressen.';
$lng['question']['admin_domain_reallydocrootoutofcustomerroot'] = 'Dokumentkatalogen f�r denna dom�n inte kommer att ligga under kundkatalogen, �r du s�ker p� att du vill �ndra detta?';

// ADDED IN 1.2.14-rc1

$lng['admin']['memorylimitdisabled'] = 'Avst�ngd';
$lng['domain']['openbasedirpath'] = 'OpenBasedir-path';
$lng['domain']['docroot'] = 'S�kv�gen fr�n ovanst�ende f�lt';
$lng['domain']['homedir'] = 'Hemkatalog';
$lng['admin']['valuemandatory'] = 'Denna ruta m�ste fyllas i';
$lng['admin']['valuemandatorycompany'] = 'Fyll i &quot;f�rnamn&quot; och &quot;efternamn&quot; eller &quot;f�retagsnamn&quot;';
$lng['menue']['main']['username'] = 'Inloggad som: ';
$lng['panel']['urloverridespath'] = 'URL (skriver �ver s�kv�gen)';
$lng['panel']['pathorurl'] = 'S�kv�g eller URL';
$lng['error']['sessiontimeoutiswrong'] = 'Bara siffror &quot;Session Timeout&quot; �r till�tna.';
$lng['error']['maxloginattemptsiswrong'] = 'Bara siffror &quot;Max Login Attempts&quot; �r till�tna.';
$lng['error']['deactivatetimiswrong'] = 'Bara siffror &quot;Deactivate Time&quot; �r till�tna.';
$lng['error']['accountprefixiswrong'] = 'Det h�r &quot;Customerprefix&quot; �r fel.';
$lng['error']['mysqlprefixiswrong'] = 'Det h�r &quot;SQL Prefix&quot; �r fel.';
$lng['error']['ftpprefixiswrong'] = 'Det h�r &quot;FTP Prefix&quot; �r fel.';
$lng['error']['ipiswrong'] = 'Den h�r &quot;IP-Address&quot; �r fel. Endast en giltig IP-adress �r till�ten.';
$lng['error']['vmailuidiswrong'] = 'Den h�r &quot;Mails-uid&quot; �r fel. Endast numerisk UID �r till�tenis allowed.';
$lng['error']['vmailgidiswrong'] = 'Den h�r &quot;Mails-gid&quot; �r fel. Endast numerisk GID �r till�tenis allowed.';
$lng['error']['adminmailiswrong'] = 'Den h�r &quot;Sender-address&quot; �r fel. Endast en giltig E-postadress �r till�ten.';
$lng['error']['pagingiswrong'] = 'Den h�r &quot;Entries per Page&quot;-v�rdet �r fel. Endast siffror �r till�tna.';
$lng['error']['phpmyadminiswrong'] = 'Den h�r phpMyAdmin-link �r inte en giltig l�nk.';
$lng['error']['webmailiswrong'] = 'Den h�r WebMail-link �r inte en giltig l�nk.';
$lng['error']['webftpiswrong'] = 'Den h�r WebFTP-link �r inte en giltig l�nk.';
$lng['domains']['hasaliasdomains'] = 'Dom�nen har redan alias';
$lng['serversettings']['defaultip']['title'] = 'F�rvald IP/Port';
$lng['serversettings']['defaultip']['description'] = 'Vilken �r den f�rvalda IP/Port kombinationen?';
$lng['domains']['statstics'] = 'Anv�ndarstatistik';
$lng['panel']['ascending'] = 'Stigande';
$lng['panel']['decending'] = 'Fallande';
$lng['panel']['search'] = 'S�k';
$lng['panel']['used'] = 'anv�nd';

// ADDED IN 1.2.14-rc3

$lng['panel']['translator'] = '�vers�ttare';

// ADDED IN 1.2.14-rc4

$lng['error']['stringformaterror'] = 'V�rdet f�r f�ltet &quot;%s&quot; har inte r�tt format.';

// ADDED IN 1.2.15-rc1

$lng['admin']['serversoftware'] = 'Webserver version';
$lng['admin']['phpversion'] = 'PHP-Version';
$lng['admin']['phpmemorylimit'] = 'PHP-Minnesgr�ns';
$lng['admin']['mysqlserverversion'] = 'MySQL Server Version';
$lng['admin']['mysqlclientversion'] = 'MySQL Klient Version';
$lng['admin']['webserverinterface'] = 'Webserver Interface';
$lng['domains']['isassigneddomain'] = 'Tilldelad dom�n ';
$lng['serversettings']['phpappendopenbasedir']['title'] = 'S�kv�g att l�gga till OpenBasedir';
$lng['serversettings']['phpappendopenbasedir']['description'] = 'Dessa s�kv�gar (separerade med kolon) kommer att l�ggas till OpenBasedir-statement i alla  vhost-container.';

// CHANGED IN 1.2.15-rc1

$lng['error']['loginnameissystemaccount'] = 'Det g�r inte att skapa ett konto som liknar ett systemkonto (Om det till exempel b�rjar med &quot;%s&quot;). Vlj ett annat kontonamn.';
$lng['error']['youcantdeleteyourself'] = 'Av s�kerhetssk�l g�r inte att redera ditt eget konto.';
$lng['error']['youcanteditallfieldsofyourself'] = 'Notera: Av s�kerhetssk�l g�r det inte att �ndra ditt eget konto.';

// ADDED IN 1.2.16-svn1

$lng['serversettings']['natsorting']['title'] = 'Anv�nd m�nsklig sortertering i listvisning';
$lng['serversettings']['natsorting']['description'] = 'Sorterar listan s� h�r web1 -> web2 -> web11 ist�llet f�r web1 -> web11 -> web2.';

// ADDED IN 1.2.16-svn2

$lng['serversettings']['deactivateddocroot']['title'] = 'Dokumentroot f�r avst�ngda anv�ndare';
$lng['serversettings']['deactivateddocroot']['description'] = 'N�r en anv�ndare �r avst�ngd kommer denna s�kv�g att anv�ndas som dokumentroot. L�mna f�ltet tommt om du inte vill skapa n�gon vhost.';

// ADDED IN 1.2.16-svn4

$lng['panel']['reset'] = 'Avbryt �ndringarna';
$lng['admin']['accountsettings'] = 'Kontoinst�llningar';
$lng['admin']['panelsettings'] = 'Panelinst�llningar';
$lng['admin']['systemsettings'] = 'Systeminst�llningar';
$lng['admin']['webserversettings'] = 'Webserverinst�llningar';
$lng['admin']['mailserversettings'] = 'E-postserverinst�llningar';
$lng['admin']['nameserversettings'] = 'Namnserverinst�llningar';
$lng['admin']['updatecounters'] = 'Uppdatera status';
$lng['question']['admin_counters_reallyupdate'] = 'Vill du uppdatera alla statusber�kningar f�r kunder och admins?';
$lng['panel']['pathDescription'] = 'Katalogen kommer att skapas om den inte redan finns.';

// ADDED IN 1.2.16-svn6

$lng['mails']['trafficninetypercent']['mailbody'] = 'Varning {NAME},\n\nDu har nu anv�nt {TRAFFICUSED} MB av ditt tillg�ngliga {TRAFFIC} MB f�r trafik.\nDetta �r mer �n 90%.\n\nH�lsningar, Froxlor team';
$lng['mails']['trafficninetypercent']['subject'] = 'Du �r p� v�g att n� din till�tna trafikgr�ns';
$lng['admin']['templates']['trafficninetypercent'] = 'Meddelande till kund n�r mer �n nittio procent av trafiken utnyttjas';
$lng['admin']['templates']['TRAFFIC'] = 'Ersatt med trafikbegrnsningen som var tilldelad till kunden.';
$lng['admin']['templates']['TRAFFICUSED'] = 'Ersatt med trafikbegrnsningen som var �verskriden av kunden.';

// ADDED IN 1.2.16-svn7

$lng['admin']['subcanemaildomain']['never'] = 'Aldrig';
$lng['admin']['subcanemaildomain']['choosableno'] = 'Valbar, standardv�rdet �r Nej';
$lng['admin']['subcanemaildomain']['choosableyes'] = 'Valbar, standardv�rdet �r Ja';
$lng['admin']['subcanemaildomain']['always'] = 'Alltid';
$lng['changepassword']['also_change_webalizer'] = ' �ndra �ven l�senord f�r webalizer statistik';

// ADDED IN 1.2.16-svn8

$lng['serversettings']['mailpwcleartext']['title'] = 'Spara �ven l�senord till E-postkonton okrypterade i databassen';
$lng['serversettings']['mailpwcleartext']['description'] = 'Om du valt Ja s� kommer alla l�senord att sparas okrypterade (klartext, fullt l�sbara f�r alla som har r�ttigheter till databasen) i tabellen mail_users-table. Aktivera detta endast om du �r s�ker p� vad du g�r!';
$lng['serversettings']['mailpwcleartext']['removelink'] = 'Klicka h�r f�r att radera alla okrypterade l�senord fr�n tabellen.';
$lng['question']['admin_cleartextmailpws_reallywipe'] = '�r du s�ker p� att du vill radera alla okrupterade l�senord fr�n tabellen mail_users? Du kan INTE �ndra dig efter�t!';
$lng['admin']['configfiles']['overview'] = '�versikt';
$lng['admin']['configfiles']['wizard'] = 'Guide';
$lng['admin']['configfiles']['distribution'] = 'Distribution';
$lng['admin']['configfiles']['service'] = 'Service';
$lng['admin']['configfiles']['daemon'] = 'Daemon';
$lng['admin']['configfiles']['http'] = 'Webserver (HTTP)';
$lng['admin']['configfiles']['dns'] = 'Namnserver (DNS)';
$lng['admin']['configfiles']['mail'] = 'E-postserver (POP3/IMAP)';
$lng['admin']['configfiles']['smtp'] = 'E-postserver (SMTP)';
$lng['admin']['configfiles']['ftp'] = 'FTP-Server';
$lng['admin']['configfiles']['etc'] = 'Others (System)';
$lng['admin']['configfiles']['choosedistribution'] = '-- Choose a distribution --';
$lng['admin']['configfiles']['chooseservice'] = '-- Choose a service --';
$lng['admin']['configfiles']['choosedaemon'] = '-- Choose a daemon --';

// ADDED IN 1.2.16-svn10

$lng['serversettings']['ftpdomain']['title'] = 'FTP konton @domain';
$lng['serversettings']['ftpdomain']['description'] = 'Kunder kan skapa Ftp accounts user@customerdomain?';
$lng['panel']['back'] = 'Tillbaka';

// ADDED IN 1.2.16-svn12

$lng['serversettings']['mod_log_sql']['title'] = 'Tillf�lligt spara loggfiler i databasen';
$lng['serversettings']['mod_log_sql']['description'] = 'Anv�nd <a href="http://www.outoforder.cc/projects/apache/mod_log_sql/" title="mod_log_sql">mod_log_sql</a> f�r att spara webfr�gor tillf�lligt<br /><b>Detta beh�ver en special <a href="http://files.froxlor.org/docs/mod_log_sql/" title="mod_log_sql - documentation">apache-configuration</a>!</b>';
$lng['serversettings']['mod_fcgid']['title'] = 'Inkludera PHP via mod_fcgid/suexec';
$lng['serversettings']['mod_fcgid']['description'] = 'Anv�nd mod_fcgid/suexec/libnss_mysql f�r att k�ra PHP med tillh�rande anv�ndarkonto.<br/><b>Denna inst�llning beh�ver en speciell apache-konfiguration!</b>';
$lng['serversettings']['sendalternativemail']['title'] = 'Anv�nd en alternativ E-postadress';
$lng['serversettings']['sendalternativemail']['description'] = 'Skicka l�senord med E-post till adressen under email-account-creation';
$lng['emails']['alternative_emailaddress'] = 'Alternative e-mail-address';
$lng['mails']['pop_success_alternative']['mailbody'] = 'Hej,\n\nditt E-postkonto {EMAIL}\nhar ny skapats.\nDitt l�senord �r {PASSWORD}.\n\nDetta �r ett automatgenererat E-postmeddelande som det INTE g�r att svara p�!\n\nLycka till �nskar, Froxlor';
$lng['mails']['pop_success_alternative']['subject'] = 'E-postkontot �r nu skapat';
$lng['admin']['templates']['pop_success_alternative'] = 'V�lkommstmeddelande f�r nya E-post konton som skickas till den alternativa adressen';
$lng['admin']['templates']['EMAIL_PASSWORD'] = 'Ersatt med POP3/IMAP kontots l�senord.';

// ADDED IN 1.2.16-svn13

$lng['error']['documentrootexists'] = 'Katalogen &quot;%s&quot; finns redan hos den h�r kunden. Radera detta f�rst innan kunden skapas igen.';

// ADDED IN 1.2.16-svn14

$lng['serversettings']['apacheconf_vhost']['title'] = 'Apache vhost konfiguration fil/katalognamn';
$lng['serversettings']['apacheconf_vhost']['description'] = 'Var skall vhost konfigurationen sparas? Det g�r att specificera alla vhost i en fil eller en katalog d�r alla filerna ligger (varje vhost i sin egen fil).';
$lng['serversettings']['apacheconf_diroptions']['title'] = 'Apache diroptions konfiguration fil/katalognamn';
$lng['serversettings']['apacheconf_diroptions']['description'] = 'Var skall diroptions konfigurationen sparas? Det g�r att specificera alla diroptions i en fil eller en katalog d�r alla filerna ligger (varje diroptions i sin egen fil).';
$lng['serversettings']['apacheconf_htpasswddir']['title'] = 'Apache htpasswd katalognamn';
$lng['serversettings']['apacheconf_htpasswddir']['description'] = 'Var skall htpasswd konfigurationen f�r katalogs�kerheten?';

// ADDED IN 1.2.16-svn15

$lng['error']['formtokencompromised'] = 'Den s�kra anslutningen till Froxlor har avslutats och du har av s�kerhetssk�l automatiskt loggats ur.';
$lng['serversettings']['mysql_access_host']['title'] = 'MySQL-Access-Hosts';
$lng['serversettings']['mysql_access_host']['description'] = 'En kommaseparerad lista med datornamn som till�ts att kontakta MySQL servern.';

// ADDED IN 1.2.18-svn1

$lng['admin']['ipsandports']['create_listen_statement'] = 'Skapa "Listen statement"';
$lng['admin']['ipsandports']['create_namevirtualhost_statement'] = 'Skapa NameVirtualHost statement';
$lng['admin']['ipsandports']['create_vhostcontainer'] = 'Skapa vHost-Container';
$lng['admin']['ipsandports']['create_vhostcontainer_servername_statement'] = 'Skapa ServerName statement i vHost-Container';

// ADDED IN 1.2.18-svn2

$lng['admin']['webalizersettings'] = 'Webalizer inst�llningar';
$lng['admin']['webalizer']['normal'] = 'Normal';
$lng['admin']['webalizer']['quiet'] = 'Tyst';
$lng['admin']['webalizer']['veryquiet'] = 'V�ldigt tyst';
$lng['serversettings']['webalizer_quiet']['title'] = 'Webalizer output';
$lng['serversettings']['webalizer_quiet']['description'] = 'Verbosity of the webalizer-program';

// ADDED IN 1.2.18-svn3

$lng['ticket']['admin_email'] = 'root@localhost';
$lng['ticket']['noreply_email'] = 'tickets@froxlor';
$lng['admin']['ticketsystem'] = 'Support';
$lng['menue']['ticket']['ticket'] = 'Support�renden';
$lng['menue']['ticket']['categories'] = 'Kategorier';
$lng['menue']['ticket']['archive'] = 'Arkivet';
$lng['ticket']['description'] = 'Skriv en beskrivning av �rendet h�r!';
$lng['ticket']['ticket_new'] = '[Skapa ett nytt �rende]';
$lng['ticket']['ticket_reply'] = 'Svara �rende';
$lng['ticket']['ticket_reopen'] = '�ter�ppna �rende';
$lng['ticket']['ticket_newcateory'] = '[Skapa ny kategori]';
$lng['ticket']['ticket_editcateory'] = '�ndra kategori';
$lng['ticket']['ticket_view'] = 'View ticketcourse';
$lng['ticket']['ticketcount'] = '�rendenummer';
$lng['ticket']['ticket_answers'] = 'Svar';
$lng['ticket']['lastchange'] = 'Senaste �ndring';
$lng['ticket']['subject'] = 'Rubrik';
$lng['ticket']['status'] = 'Status';
$lng['ticket']['lastreplier'] = '�gare';
$lng['ticket']['priority'] = 'Prioritet';
$lng['ticket']['low'] = '<span class="�rende_l�g">L�g</span>';
$lng['ticket']['normal'] = '<span class="�rende_norm">Normal</span>';
$lng['ticket']['high'] = '<span class="�rende_h�g">H�g</span>';
$lng['ticket']['unf_low'] = 'L�g';
$lng['ticket']['unf_normal'] = 'Normal';
$lng['ticket']['unf_high'] = 'H�g';
$lng['ticket']['lastchange'] = '�ndrad';
$lng['ticket']['lastchange_from'] = 'Fr�n datum (dd.mm.yyyy)';
$lng['ticket']['lastchange_to'] = 'Till datum (dd.mm.yyyy)';
$lng['ticket']['category'] = 'Kategori';
$lng['ticket']['no_cat'] = 'None';
$lng['ticket']['message'] = 'Meddeland';
$lng['ticket']['show'] = 'Visa';
$lng['ticket']['answer'] = 'Svara';
$lng['ticket']['close'] = 'St�ng';
$lng['ticket']['reopen'] = '�ppna igen';
$lng['ticket']['archive'] = 'Arkivera';
$lng['ticket']['ticket_delete'] = 'Radera ett �rende';
$lng['ticket']['lastarchived'] = 'Recently archived tickets';
$lng['ticket']['archivedtime'] = 'Arkiverad';
$lng['ticket']['open'] = '�ppnad';
$lng['ticket']['wait_reply'] = 'V�ntar p� svar';
$lng['ticket']['replied'] = 'Besvarad';
$lng['ticket']['closed'] = 'St�ngd';
$lng['ticket']['staff'] = 'Staff';
$lng['ticket']['customer'] = 'Kund';
$lng['ticket']['old_tickets'] = '�rende meddelanden';
$lng['ticket']['search'] = 'S�k i arkivet';
$lng['ticket']['nocustomer'] = 'Inget val';
$lng['ticket']['archivesearch'] = 'Arkiv s�kresultat';
$lng['ticket']['noresults'] = 'Inget �rende funnet';
$lng['ticket']['notmorethanxopentickets'] = 'P� grund av spamhanteringen kan du inte ha mer �n %s �ppna �renden';
$lng['ticket']['supportstatus'] = 'Support-Status';
$lng['ticket']['supportavailable'] = '<span class="ticket_low">V�ra supporttekniker tar nu g�rna emot era support�renden.</span>';
$lng['ticket']['supportnotavailable'] = '<span class="ticket_high">V�ra supporttekniker �r inte tillg�ngliga just nu.</span>';
$lng['admin']['templates']['ticket'] = 'Informations E-post f�r support�renden';
$lng['admin']['templates']['SUBJECT'] = 'Ersatt med support�rendet rubrik';
$lng['admin']['templates']['new_ticket_for_customer'] = 'Kundinformation som �rendet har skickat';
$lng['admin']['templates']['new_ticket_by_customer'] = 'Admininformation f�r ett �rende �ppnat av kund';
$lng['admin']['templates']['new_reply_ticket_by_customer'] = 'Admininformation f�r ett svar fr�n kund';
$lng['admin']['templates']['new_ticket_by_staff'] = 'Kundinformation f�r ett �rende �ppnat av ledningen';
$lng['admin']['templates']['new_reply_ticket_by_staff'] = 'Kundinformation f�r ett �rende besvarat av ledningen';
$lng['mails']['new_ticket_for_customer']['mailbody'] = 'Hej {FIRSTNAME} {NAME},\n\nDitt support�rende med rubriken "{SUBJECT}" har skickats till supporten.\n\nVi meddelar dig n�r ditt �rende har blivit besvarat.\n\nMed v�nliga h�lsningar,\n Froxlor';
$lng['mails']['new_ticket_for_customer']['subject'] = 'Ditt support�rende har nu skickats';
$lng['mails']['new_ticket_by_customer']['mailbody'] = 'Hej admin,\n\nEtt nytt support�rende med rubriken "{SUBJECT}" har nu skapats.\n\nV�nligen logga in f�r att �ppna �rendet.\n\nMed v�nliga h�lsningar,\n Froxlor';
$lng['mails']['new_ticket_by_customer']['subject'] = 'Nytt support�rende skapat';
$lng['mails']['new_reply_ticket_by_customer']['mailbody'] = 'Hej admin,\n\nDitt support�rende "{SUBJECT}" har blivit besvarat an en kund.\n\nV�nligen logga in f�r att �ppna �rendet.\n\nMed v�nliga h�lsningar,\n Froxlor';
$lng['mails']['new_reply_ticket_by_customer']['subject'] = 'Nytt svar f�r support�rendet';
$lng['mails']['new_ticket_by_staff']['mailbody'] = 'Hej {FIRSTNAME} {NAME},\n\nEtt nytt support�rende har �ppnats med rubriken "{SUBJECT}".\n\nV�nligen logga in f�r att �ppna �rendet.\n\nMed v�nliga h�lsningar,\n Froxlor';
$lng['mails']['new_ticket_by_staff']['subject'] = 'Nytt support�rede behandlat';
$lng['mails']['new_reply_ticket_by_staff']['mailbody'] = 'Hej {FIRSTNAME} {NAME},\n\nSupport�rendet med rubriken "{SUBJECT}" har besvarats av v�r personal.\n\nV�nligen logga in f�r att �ppna �rendet.\n\nMed v�nliga h�lsningar,\n Froxlor';
$lng['mails']['new_reply_ticket_by_staff']['subject'] = 'Svar p� ert support�rende';
$lng['question']['ticket_reallyclose'] = '�r du s�ker p� att du vill st�nga support�rendet "%s"?';
$lng['question']['ticket_reallydelete'] = '�r du s�ker p� att du vill radera support�rendet "%s"?';
$lng['question']['ticket_reallydeletecat'] = '�r du s�ker p� att du vill radera kategorin "%s"?';
$lng['question']['ticket_reallyarchive'] = '�r du s�ker p� att du vill flytta support�rendet "%s" till arkivet?';
$lng['error']['mysubject'] = '\'' . $lng['ticket']['subject'] . '\'';
$lng['error']['mymessage'] = '\'' . $lng['ticket']['message'] . '\'';
$lng['error']['mycategory'] = '\'' . $lng['ticket']['category'] . '\'';
$lng['error']['nomoreticketsavailable'] = 'Du har redan anv�nt alla support�renden som du f�tt tilldelade. Kontakta administrat�ren om du beh�ver fler.';
$lng['error']['nocustomerforticket'] = 'Det g�r inte att skapa ett support�rende utan kunder';
$lng['error']['categoryhastickets'] = 'Denna kategori har fortfarande support�renden.<br />Du m�ste radera dessa �renden innan du kan radera denna kategori';
$lng['error']['notmorethanxopentickets'] = $lng['ticket']['notmorethanxopentickets'];
$lng['admin']['ticketsettings'] = 'Support�rende inst�llningar';
$lng['admin']['archivelastrun'] = 'Sista support�rende som arkiverats';
$lng['serversettings']['ticket']['noreply_email']['title'] = 'Svara-Inte E-post adress';
$lng['serversettings']['ticket']['noreply_email']['description'] = 'Avs�ndaradressen f�r support-ticket, exempel: inget-svar@example.org';
$lng['serversettings']['ticket']['worktime_begin']['title'] = 'Start av support-tid (hh:mm)';
$lng['serversettings']['ticket']['worktime_begin']['description'] = 'Start-tid, n�r supporten �r tillg�nglig';
$lng['serversettings']['ticket']['worktime_end']['title'] = 'Slut p� support-tid (hh:mm)';
$lng['serversettings']['ticket']['worktime_end']['description'] = 'Slut-tid, n�r supporten inte l�ngre �r tillg�nglig';
$lng['serversettings']['ticket']['worktime_sat'] = 'Supporten har �ppet p� l�rdagar?';
$lng['serversettings']['ticket']['worktime_sun'] = 'Supporten har �ppet p� s�ndagar?';
$lng['serversettings']['ticket']['worktime_all']['title'] = 'Supporten �r tillg�nglig dygnet runt';
$lng['serversettings']['ticket']['worktime_all']['description'] = 'Om du v�ljer "Ja" s� kommer start och stopp tiderna att skrivas �ver';
$lng['serversettings']['ticket']['archiving_days'] = 'Efter hur m�nga dagar skall st�ngda tickets arkiveras?';
$lng['customer']['tickets'] = 'Support �renden';

// ADDED IN 1.2.18-svn4

$lng['admin']['domain_nocustomeraddingavailable'] = 'Det g�r inte att skapa en ny dom�n innan det finns mins en upplagd kund.';
$lng['serversettings']['ticket']['enable'] = 'Till�t anv�ndninga av ticketsystemet';
$lng['serversettings']['ticket']['concurrentlyopen'] = 'Maximalt antal tickets som kan �ppnas samtidigt?';
$lng['error']['norepymailiswrong'] = 'Den h�r adressen  &quot;Noreply-address&quot; �r felaktig. Bara giltiga E-post adresser �r till�tna.';
$lng['error']['tadminmailiswrong'] = 'Den h�r adressen &quot;Ticketadmin-address&quot; �r felaktig. Bara giltiga E-post adresser �r till�tna.';
$lng['ticket']['awaitingticketreply'] = 'Du har %s obesvarade support-ticket(s)';

// ADDED IN 1.2.18-svn5

$lng['serversettings']['ticket']['noreply_name'] = 'Support�rendes namn p� E-postadressen';

// ADDED IN 1.2.19-svn1

$lng['serversettings']['mod_fcgid']['configdir']['title'] = 'FCGI konfigurationskatalog';
$lng['serversettings']['mod_fcgid']['configdir']['description'] = 'I vilken katalog skall alla fcgi-konfigurationfiler lagras?';
$lng['serversettings']['mod_fcgid']['tmpdir']['title'] = 'FCGI tempor�rkatalog';

// ADDED IN 1.2.19-svn3

$lng['serversettings']['ticket']['reset_cycle']['title'] = '�terst�ll cykeln f�r anv�nda support�renden';
$lng['serversettings']['ticket']['reset_cycle']['description'] = '�terst�ll kundens r�knare f�r anv�nda support�renden. Vald cykel = 0';
$lng['admin']['tickets']['daily'] = 'Dagligen';
$lng['admin']['tickets']['weekly'] = 'Varje vecka';
$lng['admin']['tickets']['monthly'] = 'Varje m�nad';
$lng['admin']['tickets']['yearly'] = 'Varje �r';
$lng['error']['ticketresetcycleiswrong'] = 'Cykeln f�r �terst�llning av support�renden m�ste vara "Dagligen", "Varje vecka", "varje m�nad" or "varje �r".';

// ADDED IN 1.2.19-svn4

$lng['menue']['traffic']['traffic'] = 'Trafik';
$lng['menue']['traffic']['current'] = 'Nuvarande m�nad';
$lng['traffic']['month'] = "M�nad";
$lng['traffic']['day'] = "Dag";
$lng['traffic']['months'][1] = "Januari";
$lng['traffic']['months'][2] = "Februari";
$lng['traffic']['months'][3] = "Mars";
$lng['traffic']['months'][4] = "April";
$lng['traffic']['months'][5] = "Maj";
$lng['traffic']['months'][6] = "Juni";
$lng['traffic']['months'][7] = "Juli";
$lng['traffic']['months'][8] = "Augusti";
$lng['traffic']['months'][9] = "September";
$lng['traffic']['months'][10] = "Oktober";
$lng['traffic']['months'][11] = "November";
$lng['traffic']['months'][12] = "December";
$lng['traffic']['mb'] = "Trafik (MB)";
$lng['traffic']['distribution'] = '<font color="#019522">FTP</font> | <font color="#0000FF">HTTP</font> | <font color="#800000">Mail</font>';
$lng['traffic']['sumhttp'] = 'Summa HTTP-Trafik i';
$lng['traffic']['sumftp'] = 'Summa FTP-Trafik i';
$lng['traffic']['summail'] = 'Summa E-posttrafik i';

?>
