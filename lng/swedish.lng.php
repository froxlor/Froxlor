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
$lng['panel']['edit'] = 'Ändra';
$lng['panel']['delete'] = 'Radera';
$lng['panel']['create'] = 'Skapa';
$lng['panel']['save'] = 'Spara';
$lng['panel']['yes'] = 'Ja';
$lng['panel']['no'] = 'Nej';
$lng['panel']['emptyfornochanges'] = 'Tomt fält = ingen ändring';
$lng['panel']['emptyfordefault'] = 'Förvalt värde används om fältet lämnas tommt';
$lng['panel']['path'] = 'Sökväg (Path)';
$lng['panel']['toggle'] = 'Växla (Toggle)';
$lng['panel']['next'] = 'nästa';
$lng['panel']['dirsmissing'] = 'Kan inte hitta eller läsa katalogen!';

/**
 * Login
 */

$lng['login']['username'] = 'Användarnamn';
$lng['login']['password'] = 'Lösenord';
$lng['login']['language'] = 'Språk';
$lng['login']['login'] = 'Logga in';
$lng['login']['logout'] = 'Logga ut';
$lng['login']['profile_lng'] = 'Profilspråk';

/**
 * Customer
 */

$lng['customer']['documentroot'] = 'Hemkatalog';
$lng['customer']['name'] = 'Efternamn';
$lng['customer']['firstname'] = 'Förnamn';
$lng['customer']['company'] = 'Företag';
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
$lng['customer']['subdomains'] = 'Sub-Domäner';
$lng['customer']['domains'] = 'Domäner';
$lng['customer']['unlimited'] = 'Obegränsad';

/**
 * Customermenue
 */

$lng['menue']['main']['main'] = 'Huvudsidan';
$lng['menue']['main']['changepassword'] = 'Ändra lösenord';
$lng['menue']['main']['changelanguage'] = 'Ändra språk';
$lng['menue']['email']['email'] = 'E-post';
$lng['menue']['email']['emails'] = 'E-post';
$lng['menue']['email']['webmail'] = 'WebMail';
$lng['menue']['mysql']['mysql'] = 'MySQL';
$lng['menue']['mysql']['databases'] = 'Databaser';
$lng['menue']['mysql']['phpmyadmin'] = 'phpMyAdmin';
$lng['menue']['domains']['domains'] = 'Domäner';
$lng['menue']['domains']['settings'] = 'Inställningar';
$lng['menue']['ftp']['ftp'] = 'FTP';
$lng['menue']['ftp']['accounts'] = 'Konton';
$lng['menue']['ftp']['webftp'] = 'WebFTP';
$lng['menue']['extras']['extras'] = 'Extras';
$lng['menue']['extras']['directoryprotection'] = 'Katalog säkerhet';
$lng['menue']['extras']['pathoptions'] = 'Inställningar sökväg';

/**
 * Index
 */

$lng['index']['customerdetails'] = 'Kunddetaljer';
$lng['index']['accountdetails'] = 'Kontodetaljer';

/**
 * Change Password
 */

$lng['changepassword']['old_password'] = 'Gammalt lösenord';
$lng['changepassword']['new_password'] = 'Nytt lösenord';
$lng['changepassword']['new_password_confirm'] = 'Nytt lösenord (verifiera)';
$lng['changepassword']['new_password_ifnotempty'] = 'Nytt lösenord (Tomt fältet = inga ändringar)';
$lng['changepassword']['also_change_ftp'] = ' Ändra även lösenord för huvud FTP kontot';

/**
 * Domains
 */

$lng['domains']['description'] = 'Här kan du skapa (sub-)domäner och ändra i dem.<br />Systemet behöver dock lite tid på sig att genomföra ändringarna.';
$lng['domains']['domainsettings'] = 'Domäninställningar';
$lng['domains']['domainname'] = 'Domännamn';
$lng['domains']['subdomain_add'] = '[Skapa en ny subdomän]';
$lng['domains']['subdomain_edit'] = 'Ändra (sub)domän';
$lng['domains']['wildcarddomain'] = 'Skapa som ospecificerad domän (Create as wildcarddomain?)';
$lng['domains']['aliasdomain'] = 'Alias for domän';
$lng['domains']['noaliasdomain'] = '(inget alias)';

/**
 * E-mails
 */

$lng['emails']['description'] = 'Här kan du skapa eller ändra dina E-postadresser.<br />Ett konto är som en brevlåda utanför huset. Om någon skickar dig E-post kommer det att hamna i din brevlåda (ditt konto).<br /><br />För att hämta din E-post så skall du använda följande inställningar i ditt E-postprogram: (Text i kursiv stil <i>italics</i> måste ändras till det som motsvaras av det du knappade in tidigare!)<br />Servernamn (Hostname): <b><i>Domännamn (Domainname)</i></b><br />Användarnamn (Username): <b><i>Konto namn (Account name) / E-postadress</i></b><br />Lösenord (Password): <b><i>lösenordet som du valde</i></b>';
$lng['emails']['emailaddress'] = 'E-postadress';
$lng['emails']['emails_add'] = '[Skapa en E-postadress]';
$lng['emails']['emails_edit'] = 'Ändra E-postadressen';
$lng['emails']['catchall'] = 'Maildump';
$lng['emails']['iscatchall'] = 'Skapa en maildump?';
$lng['emails']['account'] = 'Konto';
$lng['emails']['account_add'] = 'Skapa konto';
$lng['emails']['account_delete'] = 'Radera konto';
$lng['emails']['from'] = 'Från';
$lng['emails']['to'] = 'Till';
$lng['emails']['forwarders'] = 'Skicka vidare:';
$lng['emails']['forwarder_add'] = '[Skapa ny "skicka vidare"]';

/**
 * FTP
 */

$lng['ftp']['description'] = 'Här kan du skapa eller änra i dina FTP konton.<br />Ändringen genomförs omedelbart så man kan använda det nya/ändrade kontot direkt.';
$lng['ftp']['account_add'] = '[Skapa ett nytt FTP konto]';

/**
 * MySQL
 */

$lng['mysql']['databasename'] = 'Användare/databasnamn';
$lng['mysql']['databasedescription'] = 'Beskrivning av databasen';
$lng['mysql']['database_create'] = '[Skapa en ny databas]';

/**
 * Extras
 */

$lng['extras']['description'] = 'Här kan du ändra övriga saker såsom katalogskydd mm.<br />Systemet behöver dock lite tid på sig att genomföra ändringarna.';
$lng['extras']['directoryprotection_add'] = '[Skapa ett nytt katalogskydd]';
$lng['extras']['view_directory'] = 'Visa kataloginnehåll';
$lng['extras']['pathoptions_add'] = '[Skapa ny regel för sökvägar]';
$lng['extras']['directory_browsing'] = 'Visning av katalogstruktur';
$lng['extras']['pathoptions_edit'] = 'Ändra sökvägsinställningar';
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

$lng['error']['error'] = 'Följande fel har uppstått';
$lng['error']['directorymustexist'] = 'Katalogen %s måste finnas. Skapa den med ditt FTP program.';
$lng['error']['filemustexist'] = 'Filen %s måste existera.';
$lng['error']['allresourcesused'] = 'Du har redan skapt så många konton som du har tillstånd till.';
$lng['error']['domains_cantdeletemaindomain'] = 'Du kan inte radera en domän som användes för E-post.';
$lng['error']['domains_canteditdomain'] = 'Endast administratörer kan ändra denna domän.';
$lng['error']['domains_cantdeletedomainwithemail'] = 'Du kan inte radera en domän som användes för E-post. Radera alla E-postadresser först';
$lng['error']['firstdeleteallsubdomains'] = 'Du måste radera alla sub-domäner innan du kan skapa en maildump (wildcard domain).';
$lng['error']['youhavealreadyacatchallforthisdomain'] = 'Du har redan skapat en maildump för denna domän.';
$lng['error']['ftp_cantdeletemainaccount'] = 'Det går inte att radera huvud FTP kontot för domänen';
$lng['error']['login'] = 'Användarnamnet eller lösenordet var felaktigt, försök igen!';
$lng['error']['login_blocked'] = 'Kontot har blivit avstängt på grund av för många felaktiga inloggningsförsök. <br />Försök igen om ' . $settings['login']['deactivatetime'] . ' sekunder.';
$lng['error']['notallreqfieldsorerrors'] = 'Du har inte fyllt i alla fält eller så har du skrivit in något som inte accepteras.';
$lng['error']['oldpasswordnotcorrect'] = 'Det gamla lösenordet är fel.';
$lng['error']['youcantallocatemorethanyouhave'] = 'Du kan inte skapa fler resurser än du äger själv (You cannot allocate more resources than you own for yourself).';
$lng['error']['mustbeurl'] = 'Du har inte skrivit in en korrekt url (e.g. http://somedomain.com/error404.htm)';
$lng['error']['invalidpath'] = 'Du har inte valt en korrekt url (Kanske har du lagt till en katalogsäkerhet så att katalogerna inte kan visas?)';
$lng['error']['stringisempty'] = 'Du måste skriva in något i fältet';
$lng['error']['stringiswrong'] = 'Fel inatningsfält';
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
$lng['error']['loginnameexists'] = 'Login-Name %s är upptaget';
$lng['error']['emailiswrong'] = 'E-post-Adressen "%s" innehåller ogiltiga tecken eller så är den inte komplett';
$lng['error']['loginnameiswrong'] = 'Login-Namnet %s innehåller ogiltiga tecken';
$lng['error']['userpathcombinationdupe'] = 'Användarnamnet och sökvägen tillsammans finns redan';
$lng['error']['patherror'] = 'Generellt Fel! sökvägen till katalogen kan inte vara tom';
$lng['error']['errordocpathdupe'] = 'Option för sökvägen %s finns redan';
$lng['error']['adduserfirst'] = 'Skapa användaren först';
$lng['error']['domainalreadyexists'] = 'Domänen %s ägs redan av en kund';
$lng['error']['nolanguageselect'] = 'Inget språk är valt.';
$lng['error']['nosubjectcreate'] = 'Du måste ha ett rubrik för denna E-postmall.';
$lng['error']['nomailbodycreate'] = 'Du måste ha skrivit in en E-post text för denna mall.';
$lng['error']['templatenotfound'] = 'E-postmallen hittades inte.';
$lng['error']['alltemplatesdefined'] = 'Du kan inte skapa flera mallar, alla språk finns redan.';
$lng['error']['wwwnotallowed'] = 'www är inte tillåtet att använda för subdomäner.';
$lng['error']['subdomainiswrong'] = 'Subdomänen %s innehåller ogiltiga tecken.';
$lng['error']['domaincantbeempty'] = 'Fältet för domännamn får inte vara tommt.';
$lng['error']['domainexistalready'] = 'Domänen %s finns redan.';
$lng['error']['domainisaliasorothercustomer'] = 'Den valda domänen är antingen en aliasdomän eller så ägs den redan av en annan kund.';
$lng['error']['emailexistalready'] = 'E-postadressen %s finns redan.';
$lng['error']['maindomainnonexist'] = 'Huvuddomänen %s finns inte.';
$lng['error']['destinationnonexist'] = 'Skapa en forwarder i fältet \'Destination\'.';
$lng['error']['destinationalreadyexistasmail'] = 'Denna forwarder %s, finns redan som aktiv E-postadress.';
$lng['error']['destinationalreadyexist'] = 'Du har redan skapat en forwarder till %s .';
$lng['error']['destinationiswrong'] = 'Denna forwarder: %s innehåller ogiltiga tecken eller så är den inte komplett adress.';
$lng['error']['domainname'] = $lng['domains']['domainname'];

/**
 * Questions
 */

$lng['question']['question'] = 'Säkerhetsfråga';
$lng['question']['admin_customer_reallydelete'] = 'Är du säker på att du vill radera kunden %s? Om du väljer att radera går det inte att ångra sig efteråt!';
$lng['question']['admin_domain_reallydelete'] = 'Är du riktigt säker på att du vill radera domänen %s?';
$lng['question']['admin_domain_reallydisablesecuritysetting'] = 'Är du riktigt säker på att du vill avaktivera säkerhetsinställningarna (OpenBasedir and/or SafeMode)?';
$lng['question']['admin_admin_reallydelete'] = 'Är du riktigt säker på att du vill radera adminkontot %s? Alla kunder och domäner kommer att flyttas till ditt konto istället.';
$lng['question']['admin_template_reallydelete'] = 'Är du riktigt säker på att du vill radera mallen \'%s\'?';
$lng['question']['domains_reallydelete'] = 'Är du riktigt säker på att du vill radera domänen %s?';
$lng['question']['email_reallydelete'] = 'Är du riktigt säker på att du vill radera E-postadressen %s?';
$lng['question']['email_reallydelete_account'] = 'Är du riktigt säker på att du vill radera E-postkontot %s?';
$lng['question']['email_reallydelete_forwarder'] = 'Är du riktigt säker på att du vill radera forwardern till %s?';
$lng['question']['extras_reallydelete'] = 'Är du riktigt säker på att du vill radera katalogsäkerheten (directory protection) för %s?';
$lng['question']['extras_reallydelete_pathoptions'] = 'Är du riktigt säker på att du vill radera katalogalternativen (path options) för %s?';
$lng['question']['ftp_reallydelete'] = 'Är du riktigt säker på att du vill radera FTP kontot %s?';
$lng['question']['mysql_reallydelete'] = 'Är du riktigt säker på att du vill radera databasen %s? Om du väljer att radera går det inte att ångra sig efteråt!';
$lng['question']['admin_configs_reallyrebuild'] = 'Är du riktigt säker på att du vill skapa nya konfigurationsfiler för apache och bind?';

/**
 * Mails
 */

$lng['mails']['pop_success']['mailbody'] = 'Hej,\n\nDitt E-postkonto {EMAIL}\nhar nu skapats.\n\nDetta är ett automatgenererat E-post meddelande\n, Det går därför inte att svara på detta meddelande!\n';
$lng['mails']['pop_success']['subject'] = 'E-postkontot är nu skapat';
$lng['mails']['createcustomer']['mailbody'] = 'Hej {FIRSTNAME} {NAME},\n\nHär kommer kontoinformationen för ditt konto:\n\nAnvändarnamn (Username): {USERNAME}\nLösenord (Password): {PASSWORD}\n\n';
$lng['mails']['createcustomer']['subject'] = 'Kontoinformation';

/**
 * Admin
 */

$lng['admin']['overview'] = 'Översikt';
$lng['admin']['ressourcedetails'] = 'Använda resurser';
$lng['admin']['systemdetails'] = 'System Detaljer';
$lng['admin']['froxlordetails'] = 'Froxlor Detaljer';
$lng['admin']['installedversion'] = 'Installerad version av Froxlor';
$lng['admin']['latestversion'] = 'Senaste version av Froxlor';
$lng['admin']['lookfornewversion']['clickhere'] = '[Sök senaste verison av Froxlor via Internet]';
$lng['admin']['lookfornewversion']['error'] = 'Fel vid läsning, kontrollera uppkopplingen mot Froxlor';
$lng['admin']['resources'] = 'Resurser';
$lng['admin']['customer'] = 'Kunder';
$lng['admin']['customers'] = 'Kunder';
$lng['admin']['customer_add'] = '[Skapa en ny kund]';
$lng['admin']['customer_edit'] = 'Ändra ny kund';
$lng['admin']['domains'] = 'Domäner';
$lng['admin']['domain_add'] = '[Skapa en ny domän]';
$lng['admin']['domain_edit'] = 'Tillåt ändring av domänen';
$lng['admin']['subdomainforemail'] = 'Sub-domän som E-postdomän (Subdomains as emaildomains)';
$lng['admin']['admin'] = 'Admin';
$lng['admin']['admins'] = 'Admins';
$lng['admin']['admin_add'] = '[Skapa en ny admin]';
$lng['admin']['admin_edit'] = 'Ändra admin';
$lng['admin']['customers_see_all'] = 'Kan se alla kunder?';
$lng['admin']['domains_see_all'] = 'Kan se alla domäner?';
$lng['admin']['change_serversettings'] = 'Kan ändra serverinställningar?';
$lng['admin']['server'] = 'Server';
$lng['admin']['serversettings'] = 'Inställningar';
$lng['admin']['rebuildconf'] = 'Uppdatera konfig filer';
$lng['admin']['stdsubdomain'] = 'Standard subdomän';
$lng['admin']['stdsubdomain_add'] = '[Skapa en ny standard subdomän]';
$lng['admin']['phpenabled'] = 'PHP påslagen';
$lng['admin']['deactivated'] = 'Inaktiv';
$lng['admin']['deactivated_user'] = 'Avaktivera användare';
$lng['admin']['sendpassword'] = 'Skicka lösenord';
$lng['admin']['ownvhostsettings'] = 'Egna vHost-Inställningar';
$lng['admin']['configfiles']['serverconfiguration'] = 'Konfiguration';
$lng['admin']['configfiles']['files'] = '<b>Konfigurationsfiler:</b> Ändra eller skapa följande filer med<br />följande innehåll om de inte finns redan.<br /><b>Notera:</b> MySQL-lösenordet har inte ändrats på grund av säkerhetsskäl.<br />Du måste själv ändra lösenordet &quot;MYSQL_PASSWORD&quot; på egen hand. Om du glömt bort ditt MySQL-password<br />så kan du hitta det här &quot;lib/userdata.inc.php&quot;.';
$lng['admin']['configfiles']['commands'] = '<b>Kommandon:</b> Kör följande kommandon i ett terminalfönster.';
$lng['admin']['configfiles']['restart'] = '<b>Omstart:</b> Kör följande kommandon i ett terminalfönster för att ladda in den nya konfigurationen.';
$lng['admin']['templates']['templates'] = 'Mallar';
$lng['admin']['templates']['template_add'] = '[Lägg till en ny mall]';
$lng['admin']['templates']['template_edit'] = 'Ändra en befintlig mall';
$lng['admin']['templates']['action'] = 'Action';
$lng['admin']['templates']['email'] = 'E-Post';
$lng['admin']['templates']['subject'] = 'Rubrik (subjekt)';
$lng['admin']['templates']['mailbody'] = 'E-Postinnehåll (Mail body)';
$lng['admin']['templates']['createcustomer'] = 'E-Post till nya kunder (Välkommen)';
$lng['admin']['templates']['pop_success'] = 'E-Post för nya konton (Välkommen)';
$lng['admin']['templates']['template_replace_vars'] = 'Variabler som kan ändras i mallen:';
$lng['admin']['templates']['FIRSTNAME'] = 'Ändra till kundens förnamn.';
$lng['admin']['templates']['NAME'] = 'Ändra till kundens efternamn.';
$lng['admin']['templates']['USERNAME'] = 'Ändra till kundens kontonamns användarnamn.';
$lng['admin']['templates']['PASSWORD'] = 'Ändra till kundens kontonamns lösenord.';
$lng['admin']['templates']['EMAIL'] = 'Ändra till adressen för POP3/IMAP kontot.';

/**
 * Serversettings
 */

$lng['serversettings']['session_timeout']['title'] = 'Sessionen har avslutats för att den tog för lång tid att utföra (session Timeout)';
$lng['serversettings']['session_timeout']['description'] = 'Tiden (i sekunder) som användaren får vara inaktiv innan han måste logga in igen är (seconds)?';
$lng['serversettings']['accountprefix']['title'] = 'Kund ID (Customer prefix)';
$lng['serversettings']['accountprefix']['description'] = 'Vilket prefix skall användas till ett kundkonto?';
$lng['serversettings']['mysqlprefix']['title'] = 'SQL ID (SQL Prefix)';
$lng['serversettings']['mysqlprefix']['description'] = 'Vilket prefix skall användas till mysql?';
$lng['serversettings']['ftpprefix']['title'] = 'FTP ID (FTP Prefix)';
$lng['serversettings']['ftpprefix']['description'] = 'Vilket prefix skall användas till ftp?';
$lng['serversettings']['documentroot_prefix']['title'] = 'Hemkatalog';
$lng['serversettings']['documentroot_prefix']['description'] = 'Vilken sökväg skall det vara till hemkatalogen?';
$lng['serversettings']['logfiles_directory']['title'] = 'Loggfilernas hemkatalog (Logfiles directory)';
$lng['serversettings']['logfiles_directory']['description'] = 'Vilken sökväg skall det vara till loggfilernas hemkatalog?';
$lng['serversettings']['ipaddress']['title'] = 'IP-Adress';
$lng['serversettings']['ipaddress']['description'] = 'Vilken IP-adress har denna server?';
$lng['serversettings']['hostname']['title'] = 'Datornamn (Hostname)';
$lng['serversettings']['hostname']['description'] = 'Villket Datornamn (Hostname) har denna server?';
$lng['serversettings']['apachereload_command']['title'] = 'Ladda om Apache kommandot (Apache reload)';
$lng['serversettings']['apachereload_command']['description'] = 'Ange sökvägen till programmet som laddar om Apache (reload apache) konfigurationsfiler?';
$lng['serversettings']['bindconf_directory']['title'] = 'Bind konfigurationskatalog (Bind config directory)';
$lng['serversettings']['bindconf_directory']['description'] = 'Vilken sökväg skall det vara till bind:s konfigurationsfiler?';
$lng['serversettings']['bindreload_command']['title'] = 'Ange sökvägen till programmet som laddar om Bind (reload bind) konfigurationsfiler?';
$lng['serversettings']['bindreload_command']['description'] = 'Ange sökvägen till programmet som laddar om Bind (reload bind) konfigurationsfiler?';
$lng['serversettings']['binddefaultzone']['title'] = 'Bind standard zone';
$lng['serversettings']['binddefaultzone']['description'] = 'Vad är namnet på standard zonen?';
$lng['serversettings']['vmail_uid']['title'] = 'Mails-UID';
$lng['serversettings']['vmail_uid']['description'] = 'Vilket användarID (UserID) ska E-posten ha?';
$lng['serversettings']['vmail_gid']['title'] = 'Mails-GID';
$lng['serversettings']['vmail_gid']['description'] = 'Vilket gruppID (GroupID) ska E-posten ha?';
$lng['serversettings']['vmail_homedir']['title'] = 'E-post hemkatalog';
$lng['serversettings']['vmail_homedir']['description'] = 'I vilken katalog skall E-posten sparas?';
$lng['serversettings']['adminmail']['title'] = 'Avsändare';
$lng['serversettings']['adminmail']['description'] = 'Vilken avsändaradress skall E-post från admin panelen ha?';
$lng['serversettings']['phpmyadmin_url']['title'] = 'phpMyAdmin URL';
$lng['serversettings']['phpmyadmin_url']['description'] = 'Vilken URL är det till phpMyAdmin? (Måste börja med http(s)://)';
$lng['serversettings']['webmail_url']['title'] = 'WebMail URL';
$lng['serversettings']['webmail_url']['description'] = 'Vilken URL är det till WebMail? (Måste börja med http(s)://)';
$lng['serversettings']['webftp_url']['title'] = 'WebFTP URL';
$lng['serversettings']['webftp_url']['description'] = 'Vilken URL är det till  WebFTP? (Måste börja med http(s)://)';
$lng['serversettings']['language']['description'] = 'Vilket språk skall användas som standardspråk?';
$lng['serversettings']['maxloginattempts']['title'] = 'Max antal Login försök';
$lng['serversettings']['maxloginattempts']['description'] = 'Maximalt antal inloggningsförsök innan kontot stängs av.';
$lng['serversettings']['deactivatetime']['title'] = 'Avstängningstid';
$lng['serversettings']['deactivatetime']['description'] = 'Tid (sec.) som kontot stängs av efter för många felaktiga försök.';
$lng['serversettings']['pathedit']['title'] = 'Typ av (path input)';
$lng['serversettings']['pathedit']['description'] = 'Skall en sökväg väljas i en rullist eller matas in för hand?';
$lng['serversettings']['nameservers']['title'] = 'Nameservers';
$lng['serversettings']['nameservers']['description'] = 'En kommaseparerad lista med namnet (hostname) på alla DNS:er. Den första blir den första som söks (primary).';
$lng['serversettings']['mxservers']['title'] = 'MX servers';
$lng['serversettings']['mxservers']['description'] = 'En kommaseparerad lista med nummer och namn separerade men mellanslag (ex. \'10 mx.example.com\') innehåller mx servrarna.';

/**
 * CHANGED BETWEEN 1.2.12 and 1.2.13
 */

$lng['mysql']['description'] = 'Här ändras eller skapas MySQL-Databaser.<br />Ändringen sker omedelbart och databasen kan användas direkt.<br />I menyn på vänster sida finns verktyget phpMyAdmin med vilket man enkelt kan ändra i sin databas.<br /><br />För att använda databasen i dina egna php-scripts använd följande inställningar: (Data med kursiv stil <i>italics</i> måste ändras till det du matat in!)<br />Servernamn (Hostname): <b><SQL_HOST></b><br />Användarnamn (Username): <b><i>Databsnamn (Databasename)</i></b><br />Lösenord (Password): <b><i>Lösenordet som du har valt</i></b><br />Databas (Database): <b><i>Databasnamn (Databasename)</i></b>';

/**
 * ADDED BETWEEN 1.2.12 and 1.2.13
 */

$lng['admin']['cronlastrun'] = 'Konfigurerinsfilerna skapades sist';
$lng['serversettings']['paging']['title'] = 'Antal rader per sida';
$lng['serversettings']['paging']['description'] = 'Hur många rader skall det vara på en sida? (0 = Stäng av sidbrytning)';
$lng['error']['ipstillhasdomains'] = 'IP/Port kombinationen som du vill radera har fortfarande domäner anslutna till sig, Flytta dessa till någon annan IP/Port kombination innan du raderar denna IP/Port kombination.';
$lng['error']['cantdeletedefaultip'] = 'Det går inte att ta bort den förvalda återförsäljarens IP/Port kombination, Välj en annan IP/Port kombination som förval för återförsäljare innan du raderar denna IP/Port kombination.';
$lng['error']['cantdeletesystemip'] = 'Det går inte att radera den sista system IP:n, Antingen skapar man en ny IP/Port kombination för system IP eller så ändrar man system IP:n.';
$lng['error']['myipaddress'] = '\'IP\'';
$lng['error']['myport'] = '\'Port\'';
$lng['error']['myipdefault'] = 'Man måste välja en IP/Port kombination som skall bli standardvärdet.';
$lng['error']['myipnotdouble'] = 'Denna IP/Port kombination finns redan.';
$lng['question']['admin_ip_reallydelete'] = 'Är du säker på att du vill radera IP addressen %s?';
$lng['admin']['ipsandports']['ipsandports'] = 'IPs and Ports';
$lng['admin']['ipsandports']['add'] = '[Lägg till IP/Port]';
$lng['admin']['ipsandports']['edit'] = 'Ändra IP/Port';
$lng['admin']['ipsandports']['ipandport'] = 'IP/Port';
$lng['admin']['ipsandports']['ip'] = 'IP';
$lng['admin']['ipsandports']['port'] = 'Port';

// ADDED IN 1.2.13-rc3

$lng['error']['cantchangesystemip'] = 'Man kan inte ändra den senaste system IP-adressen. Skapa en helt ny IP/Port kombination för system IP:n eller ändra system IP-adressen.';
$lng['question']['admin_domain_reallydocrootoutofcustomerroot'] = 'Dokumentkatalogen för denna domän inte kommer att ligga under kundkatalogen, är du säker på att du vill ändra detta?';

// ADDED IN 1.2.14-rc1

$lng['admin']['memorylimitdisabled'] = 'Avstängd';
$lng['domain']['openbasedirpath'] = 'OpenBasedir-path';
$lng['domain']['docroot'] = 'Sökvägen från ovanstående fält';
$lng['domain']['homedir'] = 'Hemkatalog';
$lng['admin']['valuemandatory'] = 'Denna ruta måste fyllas i';
$lng['admin']['valuemandatorycompany'] = 'Fyll i &quot;förnamn&quot; och &quot;efternamn&quot; eller &quot;företagsnamn&quot;';
$lng['menue']['main']['username'] = 'Inloggad som: ';
$lng['panel']['urloverridespath'] = 'URL (skriver över sökvägen)';
$lng['panel']['pathorurl'] = 'Sökväg eller URL';
$lng['error']['sessiontimeoutiswrong'] = 'Bara siffror &quot;Session Timeout&quot; är tillåtna.';
$lng['error']['maxloginattemptsiswrong'] = 'Bara siffror &quot;Max Login Attempts&quot; är tillåtna.';
$lng['error']['deactivatetimiswrong'] = 'Bara siffror &quot;Deactivate Time&quot; är tillåtna.';
$lng['error']['accountprefixiswrong'] = 'Det här &quot;Customerprefix&quot; är fel.';
$lng['error']['mysqlprefixiswrong'] = 'Det här &quot;SQL Prefix&quot; är fel.';
$lng['error']['ftpprefixiswrong'] = 'Det här &quot;FTP Prefix&quot; är fel.';
$lng['error']['ipiswrong'] = 'Den här &quot;IP-Address&quot; är fel. Endast en giltig IP-adress är tillåten.';
$lng['error']['vmailuidiswrong'] = 'Den här &quot;Mails-uid&quot; är fel. Endast numerisk UID är tillåtenis allowed.';
$lng['error']['vmailgidiswrong'] = 'Den här &quot;Mails-gid&quot; är fel. Endast numerisk GID är tillåtenis allowed.';
$lng['error']['adminmailiswrong'] = 'Den här &quot;Sender-address&quot; är fel. Endast en giltig E-postadress är tillåten.';
$lng['error']['pagingiswrong'] = 'Den här &quot;Entries per Page&quot;-värdet är fel. Endast siffror är tillåtna.';
$lng['error']['phpmyadminiswrong'] = 'Den här phpMyAdmin-link är inte en giltig länk.';
$lng['error']['webmailiswrong'] = 'Den här WebMail-link är inte en giltig länk.';
$lng['error']['webftpiswrong'] = 'Den här WebFTP-link är inte en giltig länk.';
$lng['domains']['hasaliasdomains'] = 'Domänen har redan alias';
$lng['serversettings']['defaultip']['title'] = 'Förvald IP/Port';
$lng['serversettings']['defaultip']['description'] = 'Vilken är den förvalda IP/Port kombinationen?';
$lng['domains']['statstics'] = 'Användarstatistik';
$lng['panel']['ascending'] = 'Stigande';
$lng['panel']['decending'] = 'Fallande';
$lng['panel']['search'] = 'Sök';
$lng['panel']['used'] = 'använd';

// ADDED IN 1.2.14-rc3

$lng['panel']['translator'] = 'Översättare';

// ADDED IN 1.2.14-rc4

$lng['error']['stringformaterror'] = 'Värdet för fältet &quot;%s&quot; har inte rätt format.';

// ADDED IN 1.2.15-rc1

$lng['admin']['serversoftware'] = 'Webserver version';
$lng['admin']['phpversion'] = 'PHP-Version';
$lng['admin']['phpmemorylimit'] = 'PHP-Minnesgräns';
$lng['admin']['mysqlserverversion'] = 'MySQL Server Version';
$lng['admin']['mysqlclientversion'] = 'MySQL Klient Version';
$lng['admin']['webserverinterface'] = 'Webserver Interface';
$lng['domains']['isassigneddomain'] = 'Tilldelad domän ';
$lng['serversettings']['phpappendopenbasedir']['title'] = 'Sökväg att lägga till OpenBasedir';
$lng['serversettings']['phpappendopenbasedir']['description'] = 'Dessa sökvägar (separerade med kolon) kommer att läggas till OpenBasedir-statement i alla  vhost-container.';

// CHANGED IN 1.2.15-rc1

$lng['error']['loginnameissystemaccount'] = 'Det går inte att skapa ett konto som liknar ett systemkonto (Om det till exempel börjar med &quot;%s&quot;). Vlj ett annat kontonamn.';
$lng['error']['youcantdeleteyourself'] = 'Av säkerhetsskäl går inte att redera ditt eget konto.';
$lng['error']['youcanteditallfieldsofyourself'] = 'Notera: Av säkerhetsskäl går det inte att ändra ditt eget konto.';

// ADDED IN 1.2.16-svn1

$lng['serversettings']['natsorting']['title'] = 'Använd mänsklig sortertering i listvisning';
$lng['serversettings']['natsorting']['description'] = 'Sorterar listan så här web1 -> web2 -> web11 istället för web1 -> web11 -> web2.';

// ADDED IN 1.2.16-svn2

$lng['serversettings']['deactivateddocroot']['title'] = 'Dokumentroot för avstängda användare';
$lng['serversettings']['deactivateddocroot']['description'] = 'När en användare är avstängd kommer denna sökväg att användas som dokumentroot. Lämna fältet tommt om du inte vill skapa någon vhost.';

// ADDED IN 1.2.16-svn4

$lng['panel']['reset'] = 'Avbryt ändringarna';
$lng['admin']['accountsettings'] = 'Kontoinställningar';
$lng['admin']['panelsettings'] = 'Panelinställningar';
$lng['admin']['systemsettings'] = 'Systeminställningar';
$lng['admin']['webserversettings'] = 'Webserverinställningar';
$lng['admin']['mailserversettings'] = 'E-postserverinställningar';
$lng['admin']['nameserversettings'] = 'Namnserverinställningar';
$lng['admin']['updatecounters'] = 'Uppdatera status';
$lng['question']['admin_counters_reallyupdate'] = 'Vill du uppdatera alla statusberäkningar för kunder och admins?';
$lng['panel']['pathDescription'] = 'Katalogen kommer att skapas om den inte redan finns.';

// ADDED IN 1.2.16-svn6

$lng['mails']['trafficninetypercent']['mailbody'] = 'Varning {NAME},\n\nDu har nu använt {TRAFFICUSED} MB av ditt tillgängliga {TRAFFIC} MB för trafik.\nDetta är mer än 90%.\n\nHälsningar, Froxlor team';
$lng['mails']['trafficninetypercent']['subject'] = 'Du är på väg att nå din tillåtna trafikgräns';
$lng['admin']['templates']['trafficninetypercent'] = 'Meddelande till kund när mer än nittio procent av trafiken utnyttjas';
$lng['admin']['templates']['TRAFFIC'] = 'Ersatt med trafikbegrnsningen som var tilldelad till kunden.';
$lng['admin']['templates']['TRAFFICUSED'] = 'Ersatt med trafikbegrnsningen som var överskriden av kunden.';

// ADDED IN 1.2.16-svn7

$lng['admin']['subcanemaildomain']['never'] = 'Aldrig';
$lng['admin']['subcanemaildomain']['choosableno'] = 'Valbar, standardvärdet är Nej';
$lng['admin']['subcanemaildomain']['choosableyes'] = 'Valbar, standardvärdet är Ja';
$lng['admin']['subcanemaildomain']['always'] = 'Alltid';
$lng['changepassword']['also_change_webalizer'] = ' Ändra även lösenord för webalizer statistik';

// ADDED IN 1.2.16-svn8

$lng['serversettings']['mailpwcleartext']['title'] = 'Spara även lösenord till E-postkonton okrypterade i databassen';
$lng['serversettings']['mailpwcleartext']['description'] = 'Om du valt Ja så kommer alla lösenord att sparas okrypterade (klartext, fullt läsbara för alla som har rättigheter till databasen) i tabellen mail_users-table. Aktivera detta endast om du är säker på vad du gör!';
$lng['serversettings']['mailpwcleartext']['removelink'] = 'Klicka här för att radera alla okrypterade lösenord från tabellen.';
$lng['question']['admin_cleartextmailpws_reallywipe'] = 'Är du säker på att du vill radera alla okrupterade lösenord från tabellen mail_users? Du kan INTE ändra dig efteråt!';
$lng['admin']['configfiles']['overview'] = 'Översikt';
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
$lng['admin']['trafficlastrun'] = 'Senaste trafikberäkningen gjordes';

// ADDED IN 1.2.16-svn10

$lng['serversettings']['ftpdomain']['title'] = 'FTP konton @domain';
$lng['serversettings']['ftpdomain']['description'] = 'Kunder kan skapa Ftp accounts user@customerdomain?';
$lng['panel']['back'] = 'Tillbaka';

// ADDED IN 1.2.16-svn12

$lng['serversettings']['mod_log_sql']['title'] = 'Tillfälligt spara loggfiler i databasen';
$lng['serversettings']['mod_log_sql']['description'] = 'Använd <a href="http://www.outoforder.cc/projects/apache/mod_log_sql/" title="mod_log_sql">mod_log_sql</a> för att spara webfrågor tillfälligt<br /><b>Detta behöver en special <a href="http://files.syscp.org/docs/mod_log_sql/" title="mod_log_sql - documentation">apache-configuration</a>!</b>';
$lng['serversettings']['mod_fcgid']['title'] = 'Inkludera PHP via mod_fcgid/suexec';
$lng['serversettings']['mod_fcgid']['description'] = 'Använd mod_fcgid/suexec/libnss_mysql för att köra PHP med tillhörande användarkonto.<br/><b>Denna inställning behöver en speciell apache-konfiguration!</b>';
$lng['serversettings']['sendalternativemail']['title'] = 'Använd en alternativ E-postadress';
$lng['serversettings']['sendalternativemail']['description'] = 'Skicka lösenord med E-post till adressen under email-account-creation';
$lng['emails']['alternative_emailaddress'] = 'Alternative e-mail-address';
$lng['mails']['pop_success_alternative']['mailbody'] = 'Hej,\n\nditt E-postkonto {EMAIL}\nhar ny skapats.\nDitt lösenord är {PASSWORD}.\n\nDetta är ett automatgenererat E-postmeddelande som det INTE går att svara på!\n\nLycka till önskar, Froxlor';
$lng['mails']['pop_success_alternative']['subject'] = 'E-postkontot är nu skapat';
$lng['admin']['templates']['pop_success_alternative'] = 'Välkommstmeddelande för nya E-post konton som skickas till den alternativa adressen';
$lng['admin']['templates']['EMAIL_PASSWORD'] = 'Ersatt med POP3/IMAP kontots lösenord.';

// ADDED IN 1.2.16-svn13

$lng['error']['documentrootexists'] = 'Katalogen &quot;%s&quot; finns redan hos den här kunden. Radera detta först innan kunden skapas igen.';

// ADDED IN 1.2.16-svn14

$lng['serversettings']['apacheconf_vhost']['title'] = 'Apache vhost konfiguration fil/katalognamn';
$lng['serversettings']['apacheconf_vhost']['description'] = 'Var skall vhost konfigurationen sparas? Det går att specificera alla vhost i en fil eller en katalog där alla filerna ligger (varje vhost i sin egen fil).';
$lng['serversettings']['apacheconf_diroptions']['title'] = 'Apache diroptions konfiguration fil/katalognamn';
$lng['serversettings']['apacheconf_diroptions']['description'] = 'Var skall diroptions konfigurationen sparas? Det går att specificera alla diroptions i en fil eller en katalog där alla filerna ligger (varje diroptions i sin egen fil).';
$lng['serversettings']['apacheconf_htpasswddir']['title'] = 'Apache htpasswd katalognamn';
$lng['serversettings']['apacheconf_htpasswddir']['description'] = 'Var skall htpasswd konfigurationen för katalogsäkerheten?';

// ADDED IN 1.2.16-svn15

$lng['error']['formtokencompromised'] = 'Den säkra anslutningen till Froxlor har avslutats och du har av säkerhetsskäl automatiskt loggats ur.';
$lng['serversettings']['mysql_access_host']['title'] = 'MySQL-Access-Hosts';
$lng['serversettings']['mysql_access_host']['description'] = 'En kommaseparerad lista med datornamn som tillåts att kontakta MySQL servern.';

// ADDED IN 1.2.18-svn1

$lng['admin']['ipsandports']['create_listen_statement'] = 'Skapa "Listen statement"';
$lng['admin']['ipsandports']['create_namevirtualhost_statement'] = 'Skapa NameVirtualHost statement';
$lng['admin']['ipsandports']['create_vhostcontainer'] = 'Skapa vHost-Container';
$lng['admin']['ipsandports']['create_vhostcontainer_servername_statement'] = 'Skapa ServerName statement i vHost-Container';

// ADDED IN 1.2.18-svn2

$lng['admin']['webalizersettings'] = 'Webalizer inställningar';
$lng['admin']['webalizer']['normal'] = 'Normal';
$lng['admin']['webalizer']['quiet'] = 'Tyst';
$lng['admin']['webalizer']['veryquiet'] = 'Väldigt tyst';
$lng['serversettings']['webalizer_quiet']['title'] = 'Webalizer output';
$lng['serversettings']['webalizer_quiet']['description'] = 'Verbosity of the webalizer-program';

// ADDED IN 1.2.18-svn3

$lng['ticket']['admin_email'] = 'root@localhost';
$lng['ticket']['noreply_email'] = 'tickets@Froxlor';
$lng['admin']['ticketsystem'] = 'Support';
$lng['menue']['ticket']['ticket'] = 'Supportärenden';
$lng['menue']['ticket']['categories'] = 'Kategorier';
$lng['menue']['ticket']['archive'] = 'Arkivet';
$lng['ticket']['description'] = 'Skriv en beskrivning av ärendet här!';
$lng['ticket']['ticket_new'] = '[Skapa ett nytt ärende]';
$lng['ticket']['ticket_reply'] = 'Svara ärende';
$lng['ticket']['ticket_reopen'] = 'Återöppna ärende';
$lng['ticket']['ticket_newcateory'] = '[Skapa ny kategori]';
$lng['ticket']['ticket_editcateory'] = 'Ändra kategori';
$lng['ticket']['ticket_view'] = 'View ticketcourse';
$lng['ticket']['ticketcount'] = 'Ärendenummer';
$lng['ticket']['ticket_answers'] = 'Svar';
$lng['ticket']['lastchange'] = 'Senaste ändring';
$lng['ticket']['subject'] = 'Rubrik';
$lng['ticket']['status'] = 'Status';
$lng['ticket']['lastreplier'] = 'Ägare';
$lng['ticket']['priority'] = 'Prioritet';
$lng['ticket']['low'] = '<span class="Ärende_låg">Låg</span>';
$lng['ticket']['normal'] = '<span class="Ärende_norm">Normal</span>';
$lng['ticket']['high'] = '<span class="Ärende_hög">Hög</span>';
$lng['ticket']['unf_low'] = 'Låg';
$lng['ticket']['unf_normal'] = 'Normal';
$lng['ticket']['unf_high'] = 'Hög';
$lng['ticket']['lastchange'] = 'Ändrad';
$lng['ticket']['lastchange_from'] = 'Från datum (dd.mm.yyyy)';
$lng['ticket']['lastchange_to'] = 'Till datum (dd.mm.yyyy)';
$lng['ticket']['category'] = 'Kategori';
$lng['ticket']['no_cat'] = 'None';
$lng['ticket']['message'] = 'Meddeland';
$lng['ticket']['show'] = 'Visa';
$lng['ticket']['answer'] = 'Svara';
$lng['ticket']['close'] = 'Stäng';
$lng['ticket']['reopen'] = 'Öppna igen';
$lng['ticket']['archive'] = 'Arkivera';
$lng['ticket']['ticket_delete'] = 'Radera ett ärende';
$lng['ticket']['lastarchived'] = 'Recently archived tickets';
$lng['ticket']['archivedtime'] = 'Arkiverad';
$lng['ticket']['open'] = 'Öppnad';
$lng['ticket']['wait_reply'] = 'Väntar på svar';
$lng['ticket']['replied'] = 'Besvarad';
$lng['ticket']['closed'] = 'Stängd';
$lng['ticket']['staff'] = 'Staff';
$lng['ticket']['customer'] = 'Kund';
$lng['ticket']['old_tickets'] = 'Ärende meddelanden';
$lng['ticket']['search'] = 'Sök i arkivet';
$lng['ticket']['nocustomer'] = 'Inget val';
$lng['ticket']['archivesearch'] = 'Arkiv sökresultat';
$lng['ticket']['noresults'] = 'Inget ärende funnet';
$lng['ticket']['notmorethanxopentickets'] = 'På grund av spamhanteringen kan du inte ha mer än %s öppna ärenden';
$lng['ticket']['supportstatus'] = 'Support-Status';
$lng['ticket']['supportavailable'] = '<span class="ticket_low">Våra supporttekniker tar nu gärna emot era supportärenden.</span>';
$lng['ticket']['supportnotavailable'] = '<span class="ticket_high">Våra supporttekniker är inte tillgängliga just nu.</span>';
$lng['admin']['templates']['ticket'] = 'Informations E-post för supportärenden';
$lng['admin']['templates']['SUBJECT'] = 'Ersatt med supportärendet rubrik';
$lng['admin']['templates']['new_ticket_for_customer'] = 'Kundinformation som ärendet har skickat';
$lng['admin']['templates']['new_ticket_by_customer'] = 'Admininformation för ett ärende öppnat av kund';
$lng['admin']['templates']['new_reply_ticket_by_customer'] = 'Admininformation för ett svar från kund';
$lng['admin']['templates']['new_ticket_by_staff'] = 'Kundinformation för ett ärende öppnat av ledningen';
$lng['admin']['templates']['new_reply_ticket_by_staff'] = 'Kundinformation för ett ärende besvarat av ledningen';
$lng['mails']['new_ticket_for_customer']['mailbody'] = 'Hej {FIRSTNAME} {NAME},\n\nDitt supportärende med rubriken "{SUBJECT}" har skickats till supporten.\n\nVi meddelar dig när ditt ärende har blivit besvarat.\n\nMed vänliga hälsningar,\n Froxlor';
$lng['mails']['new_ticket_for_customer']['subject'] = 'Ditt supportärende har nu skickats';
$lng['mails']['new_ticket_by_customer']['mailbody'] = 'Hej admin,\n\nEtt nytt supportärende med rubriken "{SUBJECT}" har nu skapats.\n\nVänligen logga in för att öppna ärendet.\n\nMed vänliga hälsningar,\n Froxlor';
$lng['mails']['new_ticket_by_customer']['subject'] = 'Nytt supportärende skapat';
$lng['mails']['new_reply_ticket_by_customer']['mailbody'] = 'Hej admin,\n\nDitt supportärende "{SUBJECT}" har blivit besvarat an en kund.\n\nVänligen logga in för att öppna ärendet.\n\nMed vänliga hälsningar,\n Froxlor';
$lng['mails']['new_reply_ticket_by_customer']['subject'] = 'Nytt svar för supportärendet';
$lng['mails']['new_ticket_by_staff']['mailbody'] = 'Hej {FIRSTNAME} {NAME},\n\nEtt nytt supportärende har öppnats med rubriken "{SUBJECT}".\n\nVänligen logga in för att öppna ärendet.\n\nMed vänliga hälsningar,\n Froxlor';
$lng['mails']['new_ticket_by_staff']['subject'] = 'Nytt supportärede behandlat';
$lng['mails']['new_reply_ticket_by_staff']['mailbody'] = 'Hej {FIRSTNAME} {NAME},\n\nSupportärendet med rubriken "{SUBJECT}" har besvarats av vår personal.\n\nVänligen logga in för att öppna ärendet.\n\nMed vänliga hälsningar,\n Froxlor';
$lng['mails']['new_reply_ticket_by_staff']['subject'] = 'Svar på ert supportärende';
$lng['question']['ticket_reallyclose'] = 'Är du säker på att du vill stänga supportärendet "%s"?';
$lng['question']['ticket_reallydelete'] = 'Är du säker på att du vill radera supportärendet "%s"?';
$lng['question']['ticket_reallydeletecat'] = 'Är du säker på att du vill radera kategorin "%s"?';
$lng['question']['ticket_reallyarchive'] = 'Är du säker på att du vill flytta supportärendet "%s" till arkivet?';
$lng['error']['mysubject'] = '\'' . $lng['ticket']['subject'] . '\'';
$lng['error']['mymessage'] = '\'' . $lng['ticket']['message'] . '\'';
$lng['error']['mycategory'] = '\'' . $lng['ticket']['category'] . '\'';
$lng['error']['nomoreticketsavailable'] = 'Du har redan använt alla supportärenden som du fått tilldelade. Kontakta administratören om du behöver fler.';
$lng['error']['nocustomerforticket'] = 'Det går inte att skapa ett supportärende utan kunder';
$lng['error']['categoryhastickets'] = 'Denna kategori har fortfarande supportärenden.<br />Du måste radera dessa ärenden innan du kan radera denna kategori';
$lng['error']['notmorethanxopentickets'] = $lng['ticket']['notmorethanxopentickets'];
$lng['admin']['ticketsettings'] = 'Supportärende inställningar';
$lng['admin']['archivelastrun'] = 'Sista supportärende som arkiverats';
$lng['serversettings']['ticket']['noreply_email']['title'] = 'Svara-Inte E-post adress';
$lng['serversettings']['ticket']['noreply_email']['description'] = 'Avsändaradressen för support-ticket, exempel: inget-svar@Froxlor.se';
$lng['serversettings']['ticket']['worktime_begin']['title'] = 'Start av support-tid (hh:mm)';
$lng['serversettings']['ticket']['worktime_begin']['description'] = 'Start-tid, när supporten är tillgänglig';
$lng['serversettings']['ticket']['worktime_end']['title'] = 'Slut på support-tid (hh:mm)';
$lng['serversettings']['ticket']['worktime_end']['description'] = 'Slut-tid, när supporten inte längre är tillgänglig';
$lng['serversettings']['ticket']['worktime_sat'] = 'Supporten har öppet på lördagar?';
$lng['serversettings']['ticket']['worktime_sun'] = 'Supporten har öppet på söndagar?';
$lng['serversettings']['ticket']['worktime_all']['title'] = 'Supporten är tillgänglig dygnet runt';
$lng['serversettings']['ticket']['worktime_all']['description'] = 'Om du väljer "Ja" så kommer start och stopp tiderna att skrivas över';
$lng['serversettings']['ticket']['archiving_days'] = 'Efter hur många dagar skall stängda tickets arkiveras?';
$lng['customer']['tickets'] = 'Support ärenden';

// ADDED IN 1.2.18-svn4

$lng['admin']['domain_nocustomeraddingavailable'] = 'Det går inte att skapa en ny domän innan det finns mins en upplagd kund.';
$lng['serversettings']['ticket']['enable'] = 'Tillåt användninga av ticketsystemet';
$lng['serversettings']['ticket']['concurrentlyopen'] = 'Maximalt antal tickets som kan öppnas samtidigt?';
$lng['error']['norepymailiswrong'] = 'Den här adressen  &quot;Noreply-address&quot; är felaktig. Bara giltiga E-post adresser är tillåtna.';
$lng['error']['tadminmailiswrong'] = 'Den här adressen &quot;Ticketadmin-address&quot; är felaktig. Bara giltiga E-post adresser är tillåtna.';
$lng['ticket']['awaitingticketreply'] = 'Du har %s obesvarade support-ticket(s)';

// ADDED IN 1.2.18-svn5

$lng['serversettings']['ticket']['noreply_name'] = 'Supportärendes namn på E-postadressen';

// ADDED IN 1.2.19-svn1

$lng['serversettings']['mod_fcgid']['configdir']['title'] = 'FCGI konfigurationskatalog';
$lng['serversettings']['mod_fcgid']['configdir']['description'] = 'I vilken katalog skall alla fcgi-konfigurationfiler lagras?';
$lng['serversettings']['mod_fcgid']['tmpdir']['title'] = 'FCGI temporärkatalog';

// ADDED IN 1.2.19-svn3

$lng['serversettings']['ticket']['reset_cycle']['title'] = 'Återställ cykeln för använda supportärenden';
$lng['serversettings']['ticket']['reset_cycle']['description'] = 'Återställ kundens räknare för använda supportärenden. Vald cykel = 0';
$lng['admin']['tickets']['daily'] = 'Dagligen';
$lng['admin']['tickets']['weekly'] = 'Varje vecka';
$lng['admin']['tickets']['monthly'] = 'Varje månad';
$lng['admin']['tickets']['yearly'] = 'Varje år';
$lng['error']['ticketresetcycleiswrong'] = 'Cykeln för återställning av supportärenden måste vara "Dagligen", "Varje vecka", "varje månad" or "varje år".';

// ADDED IN 1.2.19-svn4

$lng['menue']['traffic']['traffic'] = 'Trafik';
$lng['menue']['traffic']['current'] = 'Nuvarande månad';
$lng['traffic']['month'] = "Månad";
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
