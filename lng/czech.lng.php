<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2003-2007 the SysCP Team (see authors).
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Florian Lippert <flo@syscp.org> (2003-2007)
 * @author     Froxlor Team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Language
 *
 */

/**
 * Global
 */

$lng['translator'] = '';
$lng['panel']['edit'] = 'upravit';
$lng['panel']['delete'] = 'smazat';
$lng['panel']['create'] = 'vytvořit';
$lng['panel']['save'] = 'uložit';
$lng['panel']['yes'] = 'ano';
$lng['panel']['no'] = 'ne';
$lng['panel']['emptyfornochanges'] = 'prázdné - žádné změny';
$lng['panel']['emptyfordefault'] = 'prázdné - pro výchozí';
$lng['panel']['path'] = 'Cesta';
$lng['panel']['toggle'] = 'Přepnout';
$lng['panel']['next'] = 'další';
$lng['panel']['dirsmissing'] = 'Nemohu najít/číst adresář!';

/**
 * Login
 */

$lng['login']['username'] = 'Uživatel';
$lng['login']['password'] = 'Heslo';
$lng['login']['language'] = 'Jazyk';
$lng['login']['login'] = 'Přihlásit';
$lng['login']['logout'] = 'Odhlásit';
$lng['login']['profile_lng'] = 'Jazyk profilu';

/**
 * Customer
 */

$lng['customer']['documentroot'] = 'Domácí adresář';
$lng['customer']['name'] = 'Jméno';
$lng['customer']['firstname'] = 'Křestní jméno';
$lng['customer']['company'] = 'Společnost';
$lng['customer']['street'] = 'Ulice';
$lng['customer']['zipcode'] = 'PSČ';
$lng['customer']['city'] = 'Město';
$lng['customer']['phone'] = 'Telefon';
$lng['customer']['fax'] = 'Fax';
$lng['customer']['email'] = 'E-mail';
$lng['customer']['customernumber'] = 'Zákazníkovo ID';
$lng['customer']['diskspace'] = 'Webový prostor (MB)';
$lng['customer']['traffic'] = 'Přenosy (GB)';
$lng['customer']['mysqls'] = 'MySQL-Databáze';
$lng['customer']['emails'] = 'E-mailové adresy';
$lng['customer']['accounts'] = 'E-mailové účty';
$lng['customer']['forwarders'] = 'E-mailové přeposílače';
$lng['customer']['ftps'] = 'FTP účty';
$lng['customer']['subdomains'] = 'Sub-Domény';
$lng['customer']['domains'] = 'Doména';

/**
 * Customermenue
 */

$lng['menue']['main']['main'] = 'Hlavní';
$lng['menue']['main']['changepassword'] = 'Změnit heslo';
$lng['menue']['main']['changelanguage'] = 'Změnit jazyk';
$lng['menue']['email']['email'] = 'E-mail';
$lng['menue']['email']['emails'] = 'Adresy';
$lng['menue']['email']['webmail'] = 'WebMail';
$lng['menue']['mysql']['mysql'] = 'MySQL';
$lng['menue']['mysql']['databases'] = 'Databáze';
$lng['menue']['mysql']['phpmyadmin'] = 'phpMyAdmin';
$lng['menue']['domains']['domains'] = 'Domény';
$lng['menue']['domains']['settings'] = 'Nastavení';
$lng['menue']['ftp']['ftp'] = 'FTP';
$lng['menue']['ftp']['accounts'] = 'Účty';
$lng['menue']['ftp']['webftp'] = 'WebFTP';
$lng['menue']['extras']['extras'] = 'Extra';
$lng['menue']['extras']['directoryprotection'] = 'Ochrana adresáře';
$lng['menue']['extras']['pathoptions'] = 'nastavení cesty';

/**
 * Index
 */

$lng['index']['customerdetails'] = 'Detaily zákazníka';
$lng['index']['accountdetails'] = 'Detaily účtu';

/**
 * Change Password
 */

$lng['changepassword']['old_password'] = 'Staré heslo';
$lng['changepassword']['new_password'] = 'Nové heslo';
$lng['changepassword']['new_password_confirm'] = 'Nové heslo (potvrzení)';
$lng['changepassword']['new_password_ifnotempty'] = 'Nové heslo (prázdné = beze změn)';
$lng['changepassword']['also_change_ftp'] = ' také změnit heslo k hlavnímu FTP účtu';

/**
 * Domains
 */

$lng['domains']['description'] = 'Zde můžete vytvořit (sub-)domény a měnit jejich cesty.<br />Systém potřebuje nějaký čas, než se po úpravě nové nastavení projeví.';
$lng['domains']['domainsettings'] = 'Nastavení domény';
$lng['domains']['domainname'] = 'Jméno domény';
$lng['domains']['subdomain_add'] = 'Vytvořit subdoménu';
$lng['domains']['subdomain_edit'] = 'Upravit (sub)doménu';
$lng['domains']['wildcarddomain'] = 'Vytvořit jako wildcard doménu?';
$lng['domains']['aliasdomain'] = 'Alias pro doménu';
$lng['domains']['noaliasdomain'] = 'žádný alias pro doménu';

/**
 * E-mails
 */

$lng['emails']['description'] = 'Zde můžete také vytvořit a měnit e-mailové adresy.<br />Účet je jako Vaše poštovní schránka před Vaším domem. Pokud Vám někdo pošle e-mail, přijde na tento účet.<br /><br />Pro stažení e-mailů použijte následující nastavení ve svém poštovním klientu: (Data <i>kurzívou</i> musí být změněna podle toho, co jste zadali!)<br />Host: <b><i>Jméno domény</i></b><br />Uživatelské jméno: <b><i>Jméno účtu / e-mailové adresy</i></b><br />Heslo: <b><i>heslo které jste zadali</i></b>';
$lng['emails']['emailaddress'] = 'E-mailová adresa';
$lng['emails']['emails_add'] = 'Vytvořit e-mailovou adresu';
$lng['emails']['emails_edit'] = 'Editovat e-mailovou addresu';
$lng['emails']['catchall'] = 'Catchall';
$lng['emails']['iscatchall'] = 'Definovat jako catchall adresu?';
$lng['emails']['account'] = 'Účet';
$lng['emails']['account_add'] = 'Vytvořit účet';
$lng['emails']['account_delete'] = 'Smazat účet';
$lng['emails']['from'] = 'Zdroj';
$lng['emails']['to'] = 'Cíl';
$lng['emails']['forwarders'] = 'Přeposílatelé';
$lng['emails']['forwarder_add'] = 'Vytvořit přeposílatele';

/**
 * FTP
 */

$lng['ftp']['description'] = 'Zde můžete vytvářet a měnit FTP účty.<br />Změny jsou provedeny okamžitě a účty mohou být okamžitě použity.';
$lng['ftp']['account_add'] = 'Vytvořit účet';

/**
 * MySQL
 */

$lng['mysql']['databasename'] = 'jméno uživatele/databáze';
$lng['mysql']['databasedescription'] = 'popis databáze';
$lng['mysql']['database_create'] = 'Vytvořit databázi';

/**
 * Extras
 */

$lng['extras']['description'] = 'Zde můžete vkládat extra věci, například ochranu adresářů.<br />Systém potřebuje nějaký čas, než se změny projeví.';
$lng['extras']['directoryprotection_add'] = 'Přidat ochranu adresáře';
$lng['extras']['view_directory'] = 'zobrazit obsah adresáře';
$lng['extras']['pathoptions_add'] = 'přidat nastavení cesty';
$lng['extras']['directory_browsing'] = 'prohlížení obsahu adresáře';
$lng['extras']['pathoptions_edit'] = 'upravit nastavení cesty';
$lng['extras']['errordocument404path'] = 'URL k Chybové stránce 404';
$lng['extras']['errordocument403path'] = 'URL k Chybové stránce 403';
$lng['extras']['errordocument500path'] = 'URL k Chybové stránce 500';
$lng['extras']['errordocument401path'] = 'URL k Chybové stránce 401';

/**
 * Errors
 */

$lng['error']['error'] = 'Chyba';
$lng['error']['directorymustexist'] = 'Adresář %s musí existovat. Prosím vytvořte jej s pomocí Vašeho FTP klienta.';
$lng['error']['filemustexist'] = 'Soubor %s musí existovat.';
$lng['error']['allresourcesused'] = 'Už jste použili všechny své zdroje.';
$lng['error']['domains_cantdeletemaindomain'] = 'Nemůžete smazat doménu, která se používá jako e-mailová doména.';
$lng['error']['domains_canteditdomain'] = 'Nemůžete upravovat tuto doménu. Byla zakázána adminem.';
$lng['error']['domains_cantdeletedomainwithemail'] = 'Nemůžete smazat doménu, která se používá jako e-mailová doména. Nejdříve smažte všechny e-mailové adresy.';
$lng['error']['firstdeleteallsubdomains'] = 'Musíte smazat všechny subdomény než budete moci vytvořit „wildcard“ doménu.';
$lng['error']['youhavealreadyacatchallforthisdomain'] = 'Už jste definovali „catchall“ pro tuto doménu.';
$lng['error']['ftp_cantdeletemainaccount'] = 'Nemůžete smazat svůj hlavní FTP účet';
$lng['error']['login'] = 'Uživatelské jméno nebo heslo, které jste zadali, je špatné. Prosím zkuste to znovu!';
$lng['error']['login_blocked'] = 'Tento účet byl zablokován z důvodu příliš velkého množství chyb při přihlášení. <br />Prosím, zkuste to znovu za %s sekund.';
$lng['error']['notallreqfieldsorerrors'] = 'Nevyplnili jste všechna políčka nebo jsou některé vyplněna špatně.';
$lng['error']['oldpasswordnotcorrect'] = 'Staré heslo není správné.';
$lng['error']['youcantallocatemorethanyouhave'] = 'Nemůžete alokovat více zdrojů než sami vlastníte';
$lng['error']['mustbeurl'] = 'Vložili jste nesprávnou nebo nekompletní url (např. http://somedomain.com/error404.htm)';
$lng['error']['invalidpath'] = 'Nevybrali jste správnou url (možná problém s „dirlistingem“?)';
$lng['error']['stringisempty'] = 'Chybějící vstup v poli';
$lng['error']['stringiswrong'] = 'špatný vstup v poli';
$lng['error']['newpasswordconfirmerror'] = 'Nové heslo se neshoduje s tím pro potvrzení';
$lng['error']['mydomain'] = '\'Domain\'';
$lng['error']['loginnameexists'] = 'Přihlašovací jméno %s již existuje';
$lng['error']['emailiswrong'] = 'E-mailová adresa %s obsahuje nepovolené znaky nebo je nekompletní';
$lng['error']['loginnameiswrong'] = 'Přihlašovací jméno %s obsahuje nepovolené znaky';
$lng['error']['userpathcombinationdupe'] = 'Kombinace Uživatelského jména a cesty již existuje';
$lng['error']['patherror'] = 'Obecná chyba! Cesta nemůže být prázdná';
$lng['error']['errordocpathdupe'] = 'Možnost pro cestu %s již existuje';
$lng['error']['adduserfirst'] = 'Vytvořte prosím nejdříve zákazníka';
$lng['error']['domainalreadyexists'] = 'Doména %s je již přiřazena k zákazníkovi';
$lng['error']['nolanguageselect'] = 'Nebyl vybrán žádný jazyk.';
$lng['error']['nosubjectcreate'] = 'Musíte definovat téma pro tuto e-mailovou šablonu.';
$lng['error']['nomailbodycreate'] = 'Musíte definovat text e-mailu pro tuto e-mailovou šablonu.';
$lng['error']['templatenotfound'] = 'šablona nebyla nalezena.';
$lng['error']['alltemplatesdefined'] = 'Nemůžete definovat více šablon, všechny jazyky jsou již podporovány.';
$lng['error']['wwwnotallowed'] = 'www není povoleno pro subdomény.';
$lng['error']['subdomainiswrong'] = 'Subdoména %s obsahuje neplatné znaky.';
$lng['error']['domaincantbeempty'] = 'Jméno domény nesmí být prázdné.';
$lng['error']['domainexistalready'] = 'Doména %s již existuje.';
$lng['error']['domainisaliasorothercustomer'] = 'Vybraný alias pro doménu je buď sama aliasem domény nebo patří jinému zákazníkovi.';
$lng['error']['emailexistalready'] = 'E-mailová adresa %s již existuje.';
$lng['error']['maindomainnonexist'] = 'Hlavní doména %s neexistuje.';
$lng['error']['destinationnonexist'] = 'Prosím vytvořte přeposílatele v poli \'Cíl\'.';
$lng['error']['destinationalreadyexistasmail'] = 'Přeposílač na %s již existuje jako aktivní e-mailová adresa.';
$lng['error']['destinationalreadyexist'] = 'Už jste nastavili přeposílač na %s.';
$lng['error']['destinationiswrong'] = 'Přeposílač %s obsahuje nesprávné znaky nebo není kompletní.';

/**
 * Questions
 */

$lng['question']['question'] = 'Bezpečnostní otázka';
$lng['question']['admin_customer_reallydelete'] = 'Chcete opravdu smazat uživatele %s? Akci nelze vzít zpět!';
$lng['question']['admin_domain_reallydelete'] = 'Chcete opravdu smazat doménu %s?';
$lng['question']['admin_domain_reallydisablesecuritysetting'] = 'Chcete opravdu deaktivovat tato Bezpečnostní nastavení (OpenBasedir)?';
$lng['question']['admin_admin_reallydelete'] = 'Chcete opravdu smazat administrátory %s? Každý zákazník a doména bude nastavena k Vašemu účtu.';
$lng['question']['admin_template_reallydelete'] = 'Chcete opravdu smazat šablonu \'%s\'?';
$lng['question']['domains_reallydelete'] = 'Chcete opravdu smazat doménu %s?';
$lng['question']['email_reallydelete'] = 'Opravdu chcete smazat e-mailovou adresu %s?';
$lng['question']['email_reallydelete_account'] = 'Chcete opravdu smazat e-mailový účet %s?';
$lng['question']['email_reallydelete_forwarder'] = 'Chcete opravdu smazat přeposílač %s?';
$lng['question']['extras_reallydelete'] = 'Chcete opravdu odstranit ochranu adresáře %s?';
$lng['question']['extras_reallydelete_pathoptions'] = 'Opravdu chcete smazat nastavení cesty pro %s?';
$lng['question']['ftp_reallydelete'] = 'Opravdu chcete smazat FTP účet %s?';
$lng['question']['mysql_reallydelete'] = 'Opravdu chcete smazat databázi %s? Tato akce nemůže být vzata zpět!';
$lng['question']['admin_configs_reallyrebuild'] = 'Opravdu chcete rebuildovat apache a nabindovat konfigurační soubory?';

/**
 * Mails
 */

$lng['mails']['pop_success']['mailbody'] = 'Dobrý den,\n\nVáš e-mailový účet {EMAIL}\nbyl v pořádku nastaven.\n\nToto je automaticky vytvořený\ne-mail, prosím neodpovídejte na něj!\n\nPřejeme hezký den, Administrator';
$lng['mails']['pop_success']['subject'] = 'Poštovní účet byl úspěšně nastaven';
$lng['mails']['createcustomer']['mailbody'] = 'Dobrý den, {FIRSTNAME} {NAME},\n\nzde jsou informace o Vašem účtu:\n\nUživatel: {USERNAME}\nHeslo: {PASSWORD}\n\nDěkujeme,\nváš správce';
$lng['mails']['createcustomer']['subject'] = 'Informace o účtu';

/**
 * Admin
 */

$lng['admin']['overview'] = 'Přehled';
$lng['admin']['ressourcedetails'] = 'Použité zdroje';
$lng['admin']['systemdetails'] = 'Detaily systému';
$lng['admin']['froxlordetails'] = 'Froxlor Detaily';
$lng['admin']['installedversion'] = 'Nainstalovaná verze';
$lng['admin']['latestversion'] = 'Poslední verze';
$lng['admin']['lookfornewversion']['clickhere'] = 'hledat přes webservice';
$lng['admin']['lookfornewversion']['error'] = 'Chyba při čtení';
$lng['admin']['resources'] = 'Zdroje';
$lng['admin']['customer'] = 'Zákazník';
$lng['admin']['customers'] = 'Zákazníci';
$lng['admin']['customer_add'] = 'Vytvořit zákazníka';
$lng['admin']['customer_edit'] = 'Upravit zákazníka';
$lng['admin']['domains'] = 'Domény';
$lng['admin']['domain_add'] = 'Vytvořit doménu';
$lng['admin']['domain_edit'] = 'Upravit doménu';
$lng['admin']['subdomainforemail'] = 'Subdomény jako e-mailové domény';
$lng['admin']['admin'] = 'Administrátor';
$lng['admin']['admins'] = 'Administrátoři';
$lng['admin']['admin_add'] = 'Vytvořit administrátora';
$lng['admin']['admin_edit'] = 'Upravit administrátora';
$lng['admin']['customers_see_all'] = 'Může vidět všechy zákazníky?';
$lng['admin']['domains_see_all'] = 'Může vidět všechny domény?';
$lng['admin']['change_serversettings'] = 'Může měnit nastavení serveru?';
$lng['admin']['server'] = 'Server';
$lng['admin']['serversettings'] = 'Nastavení';
$lng['admin']['rebuildconf'] = 'Přebudovat konfigurační soubory';
$lng['admin']['stdsubdomain'] = 'Standardní subdoména';
$lng['admin']['stdsubdomain_add'] = 'Vytvořit standardní subdoménu';
$lng['admin']['phpenabled'] = 'PHP zapnuto';
$lng['admin']['deactivated'] = 'Deaktivováno';
$lng['admin']['deactivated_user'] = 'Deaktivovat uživatele';
$lng['admin']['sendpassword'] = 'Zaslat heslo';
$lng['admin']['ownvhostsettings'] = 'Vlastní vHost-nastavení';
$lng['admin']['configfiles']['serverconfiguration'] = 'Konfigurace';
$lng['admin']['configfiles']['files'] = '<b>Konfigurační soubory:</b> Prosím změňte následující soubory nabo je vytvořte s<br /> následujícím obsahem, pokud neexistují.<br /><b>Poznámka:</b> MySQL heslo nebylo nahrazeno z bezpečnostních důvodů.<br />Prosím nahraďte „MYSQL_PASSWORD“ svým vlastním. Pokud jste zapomněli své mysql heslo<br />najdete jej v „lib/userdata.inc.php“.';
$lng['admin']['configfiles']['commands'] = '<b>Příkazy:</b> Prosím spusťte následující příkazy v příkazovém řádku.';
$lng['admin']['configfiles']['restart'] = '<b>Restart:</b> Prosím spusťte nísledující příkazy v příkazovém řádku, aby jste nahráli novou konfiguraci.';
$lng['admin']['templates']['templates'] = 'šablony';
$lng['admin']['templates']['template_add'] = 'Přidat šablonu';
$lng['admin']['templates']['template_edit'] = 'Upravit šablonu';
$lng['admin']['templates']['action'] = 'Akce';
$lng['admin']['templates']['email'] = 'E-mail';
$lng['admin']['templates']['subject'] = 'Předmět';
$lng['admin']['templates']['mailbody'] = 'Tělo e-mailu';
$lng['admin']['templates']['createcustomer'] = 'Uvítací mail pro nové zákazníky';
$lng['admin']['templates']['pop_success'] = 'Uvítací mail pro nové e-mailové účty';
$lng['admin']['templates']['template_replace_vars'] = 'Proměnné k nahrazení v šabloně:';
$lng['admin']['templates']['FIRSTNAME'] = 'Nahrazeno křestním jménem zákazníka.';
$lng['admin']['templates']['NAME'] = 'Nahrazeno jménem zákazníka.';
$lng['admin']['templates']['USERNAME'] = 'Nahrazeno uživatelským jménem zákazníka.';
$lng['admin']['templates']['PASSWORD'] = 'Nahrazeno zákazníkovým heslem.';
$lng['admin']['templates']['EMAIL'] = 'Nahrazeno adresou POP3/IMAP účtu.';

/**
 * Serversettings
 */

$lng['serversettings']['session_timeout']['description'] = 'Jak dlouho musí být uživatel neaktivní, než session vyprší (sekundy)?';
$lng['serversettings']['accountprefix']['title'] = 'Zákazníkova předpona';
$lng['serversettings']['accountprefix']['description'] = 'Jaké předpony by měly mít účty zákazníků?';
$lng['serversettings']['mysqlprefix']['title'] = 'SQL předpona';
$lng['serversettings']['mysqlprefix']['description'] = 'Jaké předpony by měly mít účty mysql?';
$lng['serversettings']['ftpprefix']['title'] = 'FTP předpona';
$lng['serversettings']['ftpprefix']['description'] = 'Jakou předponu by měly mít ftp účty?';
$lng['serversettings']['documentroot_prefix']['title'] = 'Domácí adresář';
$lng['serversettings']['documentroot_prefix']['description'] = 'Kde by měly být uloženy všechny domácí adresáře?';
$lng['serversettings']['logfiles_directory']['title'] = 'Adresář pro log soubory';
$lng['serversettings']['logfiles_directory']['description'] = 'Kde by měly být všechny log soubory uloženy?';
$lng['serversettings']['ipaddress']['title'] = 'IP adresa';
$lng['serversettings']['ipaddress']['description'] = 'Jaká je IP adresa tohoto serveru?';
$lng['serversettings']['hostname']['title'] = 'Jméno hosta';
$lng['serversettings']['hostname']['description'] = 'Jaké je jméno hosta tohoto serveru?';
$lng['serversettings']['apachereload_command']['title'] = 'Příkaz pro reload apache';
$lng['serversettings']['apachereload_command']['description'] = 'Jaký je příkaz, kterým apache znovunahraje své konfigurační soubory?';
$lng['serversettings']['bindconf_directory']['title'] = 'Bindujte konfigurační adresář';
$lng['serversettings']['bindconf_directory']['description'] = 'Kde by měly být uloženy „bind configfiles“?';
$lng['serversettings']['bindreload_command']['title'] = 'Bind reload příkaz';
$lng['serversettings']['bindreload_command']['description'] = 'Jaký je příkaz pro znovunahrání „bind configfiles“?';
$lng['serversettings']['binddefaultzone']['title'] = 'Bind výchozí zóna';
$lng['serversettings']['binddefaultzone']['description'] = 'Jaký je název výchozí zóny?';
$lng['serversettings']['vmail_uid']['title'] = 'UID e-mailů';
$lng['serversettings']['vmail_uid']['description'] = 'Jaké UserID by měly e-maily mít?';
$lng['serversettings']['vmail_gid']['title'] = 'GID e-mailů';
$lng['serversettings']['vmail_gid']['description'] = 'Jaké GroupID by měly e-maily mít?';
$lng['serversettings']['vmail_homedir']['title'] = 'Mails-Home adresář';
$lng['serversettings']['vmail_homedir']['description'] = 'Kam by se měly všechny e-maily ukládat?';
$lng['serversettings']['adminmail']['title'] = 'Odesílatel';
$lng['serversettings']['adminmail']['description'] = 'Jaká je odesílatelova adresa pro e-maily odeslané z Panelu?';
$lng['serversettings']['phpmyadmin_url']['title'] = 'phpMyAdminova URL';
$lng['serversettings']['phpmyadmin_url']['description'] = 'Jaká je URL adresa phpMyAdmin? (musí začínat http(s)://)';
$lng['serversettings']['webmail_url']['title'] = 'WebMailová URL';
$lng['serversettings']['webmail_url']['description'] = 'Jaká je URL adresa k WebMailu? (musí začínat with http(s)://)';
$lng['serversettings']['webftp_url']['title'] = 'WebFTP URL';
$lng['serversettings']['webftp_url']['description'] = 'Jaká je URL k WebFTP? (musí začínat with http(s)://)';
$lng['serversettings']['language']['description'] = 'Jaký je výchozí jazyk Vašeho serveru?';
$lng['serversettings']['maxloginattempts']['title'] = 'Maximální počet pokusů o přihlášení';
$lng['serversettings']['maxloginattempts']['description'] = 'Maximální počet pokusů o přihlášení k účtu, než se účet zablokuje.';
$lng['serversettings']['deactivatetime']['title'] = 'Deaktivovaný po dobu';
$lng['serversettings']['deactivatetime']['description'] = 'čas (sek.) po který bude účet deaktivován pro příliš mnoho pokusů o přihlášení.';
$lng['serversettings']['pathedit']['title'] = 'Typ vstupu cesty';
$lng['serversettings']['pathedit']['description'] = 'Měla by být cesta vybírána pomocí vyskakovacího menu nebo vstupním polem?';
$lng['serversettings']['nameservers']['title'] = 'Nameservery';
$lng['serversettings']['nameservers']['description'] = 'Středníkem oddělený seznam obsahující hostname všech nameserverů. První bude primární.';
$lng['serversettings']['mxservers']['title'] = 'MX servery';
$lng['serversettings']['mxservers']['description'] = 'Středníkem oddělený seznam obsahující páry čísel a hostname oddělených mezerou (např. \'10 mx.example.com\') obsahující mx servery.';

/**
 * CHANGED BETWEEN 1.2.12 and 1.2.13
 */

$lng['mysql']['description'] = 'Zde můžete vytvářet a měnit své MySQL-Databáze.<br />Změny jsou provedeny okamžitě a databáze může být okamžitě používána.<br />V menu vlevo můžete najít nástroj phpMyAdmin se kterým můžete jednoduše upravovat svou databázi.<br /><br />Pro použití databáze ve svých php skriptech použijte následující nastavení: (Data <i>kurzívou</i> musí být změněna na Vámi vložené hodnoty!)<br />Host: <b><SQL_HOST></b><br />Uživatelské jméno: <b><i>Databasename</i></b><br />Heslo: <b><i>heslo které jste zvolili</i></b><br />Databáze: <b><i>Databasename</i></b>';

/**
 * ADDED BETWEEN 1.2.12 and 1.2.13
 */

$lng['serversettings']['paging']['title'] = 'Záznamů na stránku';
$lng['serversettings']['paging']['description'] = 'Kolik záznamů by mělo být zobrazeno na stránce? (0 = zrušit stránkování)';
$lng['error']['ipstillhasdomains'] = 'IP/Port kombinace, kterou chcete smazat má stále přiřazené domény, prosím přeřaďte je k jiné IP/Port kombinaci než smažete tuto IP/Port kombinaci.';
$lng['error']['cantdeletedefaultip'] = 'Nemůžete smazat IP/Port kombinaci výchozího přeprodejce, prosím vytvořte jinou IP/Port kombinaci výchozí pro přeprodejce než smažete tuto IP/Port kombinaci.';
$lng['error']['cantdeletesystemip'] = 'Nemůžete smazat poslední systémovou IP, buď vytvořte novou IP/Port kombinaci pro systémovou IP nebo změňte IP systému.';
$lng['error']['myipaddress'] = '\'IP\'';
$lng['error']['myport'] = '\'Port\'';
$lng['error']['myipdefault'] = 'Musíte vybrat IP/Port kombinaci která by se měla stát výchozí.';
$lng['error']['myipnotdouble'] = 'Tato kombinace IP/Portu již existuje.';
$lng['question']['admin_ip_reallydelete'] = 'Chcete opravdu smazat IP adresu %s?';
$lng['admin']['ipsandports']['ipsandports'] = 'IP a Porty';
$lng['admin']['ipsandports']['add'] = 'Přidat IP/Port';
$lng['admin']['ipsandports']['edit'] = 'Upravit IP/Port';

// ADDED IN 1.2.13-rc3

$lng['error']['cantchangesystemip'] = 'Nemůžete změnit poslední systémovou IP, buď vytvořte novou IP/Port kombinaci pro systémovou IP nebo změňte IP systému.';
$lng['question']['admin_domain_reallydocrootoutofcustomerroot'] = 'Jste si jisti, že chcete aby root dokumentů pro tuto doménu nebyl v „customerroot“ zákazníka?';

// ADDED IN 1.2.14-rc1

$lng['admin']['memorylimitdisabled'] = 'Zakázáno';
$lng['domain']['openbasedirpath'] = 'OpenBasedir cesta';
$lng['domain']['docroot'] = 'Cesta z políčka nahoře';
$lng['domain']['homedir'] = 'Domovní adresář';
$lng['admin']['valuemandatory'] = 'Tato hodnota je povinná';
$lng['admin']['valuemandatorycompany'] = 'Buď „jméno“ a „křestní jméno“ nebo „společnost“ musí být vyplněna';
$lng['menue']['main']['username'] = 'Přihlášen(a) jako: ';
$lng['panel']['urloverridespath'] = 'URL (přepíše cestu)';
$lng['panel']['pathorurl'] = 'Cesta nebo URL';
$lng['error']['sessiontimeoutiswrong'] = 'Pouze číselné „Session Timeout“ je povoleno.';
$lng['error']['maxloginattemptsiswrong'] = 'Pouze číselné „Maximální počet pokusů o přihlášení“ je povoleno.';
$lng['error']['deactivatetimiswrong'] = 'Pouze číselné „čas deaktivace“ je povoleno.';
$lng['error']['accountprefixiswrong'] = '„Předpona uživatele“ je špatně.';
$lng['error']['mysqlprefixiswrong'] = '„SQL předpona“ je špatně.';
$lng['error']['ftpprefixiswrong'] = '„FTP předpona“ je špatně.';
$lng['error']['ipiswrong'] = '„IP adresa“ je špatně. Pouze validní IP adresa je povolena.';
$lng['error']['vmailuidiswrong'] = '„Mail uid“ je špatně. Je povoleno pouze číselné UID.';
$lng['error']['vmailgidiswrong'] = '„Mail gid“ je špatně. Je povoleno pouze číselné GID.';
$lng['error']['adminmailiswrong'] = '„Sender-address“ je špatně. Je povolena pouze validní e-mailová adresa.';
$lng['error']['pagingiswrong'] = '„Entries per Page“-value je špatně. Jsou povolena pouze čísla.';
$lng['error']['phpmyadminiswrong'] = 'phpMyAdmin url není správná url.';
$lng['error']['webmailiswrong'] = 'WebMail-odkaz není správný odkaz.';
$lng['error']['webftpiswrong'] = 'WebFTP-odkaz není správný odkaz.';
$lng['domains']['hasaliasdomains'] = 'Má aliasové domény';
$lng['serversettings']['defaultip']['title'] = 'Výchozí IP/Port';
$lng['serversettings']['defaultip']['description'] = 'Jaká je výchozí IP/Port kombinace?';
$lng['domains']['statstics'] = 'Statistika použití';
$lng['panel']['ascending'] = 'sestupně';
$lng['panel']['decending'] = 'vzestupně';
$lng['panel']['search'] = 'Vyhledávání';
$lng['panel']['used'] = 'použito';

// ADDED IN 1.2.14-rc3

$lng['panel']['translator'] = 'Překladatel';

// ADDED IN 1.2.14-rc4

$lng['error']['stringformaterror'] = 'Hodnota pole „%s“ není v očekávaném formátu.';

// ADDED IN 1.2.15-rc1

$lng['admin']['serversoftware'] = 'Software serveru';
$lng['admin']['phpversion'] = 'PHP-Verze';
$lng['admin']['phpmemorylimit'] = 'PHP-Limit-Paměti';
$lng['admin']['mysqlserverversion'] = 'MySQL verze serveru';
$lng['admin']['mysqlclientversion'] = 'MySQL verze klienta';
$lng['admin']['webserverinterface'] = 'Webserver rozhraní';
$lng['domains']['isassigneddomain'] = 'Je přiřazená doména';
$lng['serversettings']['phpappendopenbasedir']['title'] = 'Cesty k přidání k OpenBasedir';
$lng['serversettings']['phpappendopenbasedir']['description'] = 'Tyto cesty (odděleny pomocí „colons“) budou vloženy do OpenBasedir statementu v každém vhost-containeru.';

// CHANGED IN 1.2.15-rc1

$lng['error']['loginnameissystemaccount'] = 'Nemůžete vytvořit účty, které jsou podobné systémovým účtům (například začínají „%s“). Prosím vložte jiné jméno účtu.';
$lng['error']['youcantdeleteyourself'] = 'Z bezpečnostních důvodů se nemůžete smazat.';
$lng['error']['youcanteditallfieldsofyourself'] = 'Poznámka: Z bezpečnostních důvodů nemůžete upravovat všechna pole svého účtu.';

// ADDED IN 1.2.16-svn1

$lng['serversettings']['natsorting']['title'] = 'Použít „lidské“ třídění v seznamech';
$lng['serversettings']['natsorting']['description'] = 'řadit seznamy jako web1 -> web2 -> web11 místo web1 -> web11 -> web2.';

// ADDED IN 1.2.16-svn2

$lng['serversettings']['deactivateddocroot']['title'] = 'Docroot pro deaktivované uživatele';
$lng['serversettings']['deactivateddocroot']['description'] = 'Když bude uživatel deaktivován, tato cesta bude použita jako jeho docroot. Ponechte prázdné, pokud nechcete vytvářet.';

// ADDED IN 1.2.16-svn4

$lng['panel']['reset'] = 'zrušit změny';
$lng['admin']['accountsettings'] = 'Nastavení účtu';
$lng['admin']['panelsettings'] = 'Nastavení panelu';
$lng['admin']['systemsettings'] = 'Nastavení systému';
$lng['admin']['webserversettings'] = 'Nastavení webserveru';
$lng['admin']['mailserversettings'] = 'Nastavení mailserveru';
$lng['admin']['nameserversettings'] = 'Nastavení nameserveru';
$lng['admin']['updatecounters'] = 'Přepočítat využití zdrojů';
$lng['question']['admin_counters_reallyupdate'] = 'Opravdu chcete přepočítat využití zdrojů?';
$lng['panel']['pathDescription'] = 'Pokud adresář neexistuje, bude vytvořen automaticky.';

// ADDED IN 1.2.16-svn6
$lng['admin']['templates']['TRAFFIC'] = 'Nahrazeno přenosy, které byly přiděleny uživateli.';
$lng['admin']['templates']['TRAFFICUSED'] = 'Nahrazeno přenosy, které byly vyčerpány zákazníkem.';

// ADDED IN 1.2.16-svn7

$lng['admin']['subcanemaildomain']['never'] = 'Nikdy';
$lng['admin']['subcanemaildomain']['choosableno'] = 'Výběr, výchozí ne';
$lng['admin']['subcanemaildomain']['choosableyes'] = 'Výběr, výchozí ano';
$lng['admin']['subcanemaildomain']['always'] = 'Vždy';
$lng['changepassword']['also_change_webalizer'] = ' také změňte heslo pro webalizer statistics';

// ADDED IN 1.2.16-svn8

$lng['serversettings']['mailpwcleartext']['title'] = 'Také uložte hesla e-mailových účtů nešifrovaná v databázi';
$lng['serversettings']['mailpwcleartext']['description'] = 'Pokud je toto nastaveno na „ano“, všechna hesla budou ukládána bez šifrování (čístý text, čitelná pro kohokoliv s přístupem k databázi) v tabulce mail_users. Toto aktivujte jen pokud to opravdu potřebujete!';
$lng['serversettings']['mailpwcleartext']['removelink'] = 'Kliknutím zde vymažete všechna nezašifrovaná hesla z tabulky.';
$lng['question']['admin_cleartextmailpws_reallywipe'] = 'Opravdu chcete vymazat všechna nezašifrovaná hesla pro e-mailové účty z tabulky mail_users? Tento krok nelze vrátit zpět!';
$lng['admin']['configfiles']['overview'] = 'Přehled';
$lng['admin']['configfiles']['wizard'] = 'Průvodce';
$lng['admin']['configfiles']['distribution'] = 'Distribuce';
$lng['admin']['configfiles']['service'] = 'Služba';
$lng['admin']['configfiles']['etc'] = 'Ostatní (System)';
$lng['admin']['configfiles']['choosedistribution'] = '-- Vyberte distribuci --';
$lng['admin']['configfiles']['chooseservice'] = '-- Vyberte službu --';
$lng['admin']['configfiles']['choosedaemon'] = '-- Vyberte daemona --';

// ADDED IN 1.2.16-svn10

$lng['serversettings']['ftpdomain']['title'] = 'FTP účty na doméně';
$lng['serversettings']['ftpdomain']['description'] = 'Zákazníci mohou vytvářet FTP účty user@customerdomain?';
$lng['panel']['back'] = 'Back';

// ADDED IN 1.2.16-svn12

$lng['serversettings']['mod_fcgid']['title'] = 'Zpracuj PHP přes mod_fcgid/suexec';
$lng['serversettings']['mod_fcgid']['description'] = 'Použij mod_fcgid/suexec/libnss_mysql pro běh PHP s odpovídajícím uživatelským účtem.<br/><b>toto vyžaduje speciální konfiguraci apache!</b>';
$lng['serversettings']['sendalternativemail']['title'] = 'Použij alternativní e-mailovou adresu';
$lng['serversettings']['sendalternativemail']['description'] = 'Pošli e-mail s heslem na jinou adresu při vytváření e-mailového účtu';
$lng['emails']['alternative_emailaddress'] = 'Alternativní e-mailová adresa';
$lng['mails']['pop_success_alternative']['mailbody'] = 'Vážený uživateli,\n\nVáš e-mailový účet {EMAIL}\nbyl úspěšně nastaven.\nVaše heslo je {PASSWORD}.\n\nTento e-mail byl automaticky vygenerován,\nprosím neodpovídejte na něj!\n\nPřejeme Vám hezký den, váš správce';
$lng['mails']['pop_success_alternative']['subject'] = 'E-mailový účet byl úspěšně vytvořen';
$lng['admin']['templates']['pop_success_alternative'] = 'Uvítací e-mail pro nové účty byl odeslán na alternativní adresu';
$lng['admin']['templates']['EMAIL_PASSWORD'] = 'Nahrazeno heslem účtu POP3/IMAP.';

// ADDED IN 1.2.16-svn13

$lng['error']['documentrootexists'] = 'Adresář „%s“ již existuje pro tohoto zákazníka. Prosím odstraňte jej, než budete znovu zákazníka vkládat.';

// ADDED IN 1.2.16-svn14

$lng['serversettings']['apacheconf_vhost']['title'] = 'Apache vhost konfigurační soubor/dirname';
$lng['serversettings']['apacheconf_vhost']['description'] = 'Kde by měla být uložena konfigurace vhosta? Můžete zde buď specifikovat soubor (všichni vhosti v jednom souboru) nebo adresář (každý vhost má vlastní soubor).';
$lng['serversettings']['apacheconf_diroptions']['title'] = 'Apache diroptions konfigurační soubor/dirname';
$lng['serversettings']['apacheconf_diroptions']['description'] = 'Kde by měla být uložena konfigurace diroptions? Můžete zde buď specifikovat soubor (všichni diroptions v jednom souboru) nebo adresář (každý diroption má vlastní soubor).';
$lng['serversettings']['apacheconf_htpasswddir']['title'] = 'Apache htpasswd dirname';
$lng['serversettings']['apacheconf_htpasswddir']['description'] = 'Kde by měly být uloženy htpasswd soubory pro ochranu adresářů?';

// ADDED IN 1.2.16-svn15

$lng['error']['formtokencompromised'] = 'The request seems to be compromised. Z bezpečnostních důvodů jste byli odhlášeni.';
$lng['serversettings']['mysql_access_host']['title'] = 'MySQL-Access-Hosts';
$lng['serversettings']['mysql_access_host']['description'] = 'Středníkem oddělený seznam hostů, ze kterých bude dovoleno uživatelům se připojit k MySQL-Serveru.';

// ADDED IN 1.2.18-svn1

$lng['admin']['ipsandports']['create_listen_statement'] = 'Vytvořit Listen statement';
$lng['admin']['ipsandports']['create_namevirtualhost_statement'] = 'Vytvořit NameVirtualHost statement';
$lng['admin']['ipsandports']['create_vhostcontainer'] = 'Vytvořit vHost-Container';
$lng['admin']['ipsandports']['create_vhostcontainer_servername_statement'] = 'Vytvořit ServerName statement v vHost-Container';

// ADDED IN 1.2.18-svn2

$lng['admin']['webalizersettings'] = 'Nastavení Webalizeru';
$lng['admin']['webalizer']['normal'] = 'Normální';
$lng['admin']['webalizer']['quiet'] = 'Tichý';
$lng['admin']['webalizer']['veryquiet'] = 'žádný výstup';
$lng['serversettings']['webalizer_quiet']['title'] = 'Výstup Webalizeru';
$lng['serversettings']['webalizer_quiet']['description'] = 'Povídavost webalizer-programu';

// ADDED IN 1.2.18-svn3

$lng['ticket']['admin_email'] = 'root@localhost';
$lng['ticket']['noreply_email'] = 'tikety@froxlor';
$lng['admin']['ticketsystem'] = 'Support-tikety';
$lng['menue']['ticket']['ticket'] = 'Support tikety';
$lng['menue']['ticket']['categories'] = 'Kategorie podpory';
$lng['menue']['ticket']['archive'] = 'Archiv-tiketů';
$lng['ticket']['description'] = 'Nastavit popis zde!';
$lng['ticket']['ticket_new'] = 'Otevřít nový tiket';
$lng['ticket']['ticket_reply'] = 'zodpovědět tiket';
$lng['ticket']['ticket_reopen'] = 'Znovuotevřít tiket';
$lng['ticket']['ticket_newcateory'] = 'Vytvořit novou kategorii';
$lng['ticket']['ticket_editcateory'] = 'Upravit kategorii';
$lng['ticket']['ticket_view'] = 'Zobrazit ticketcourse';
$lng['ticket']['ticketcount'] = 'Tikety';
$lng['ticket']['ticket_answers'] = 'Odpovědi';
$lng['ticket']['lastchange'] = 'Poslední akce';
$lng['ticket']['subject'] = 'Předmět';
$lng['ticket']['status'] = 'Stav';
$lng['ticket']['lastreplier'] = 'Poslední odpovídající';
$lng['ticket']['priority'] = 'Priorita';
$lng['ticket']['low'] = 'Nízká';
$lng['ticket']['normal'] = 'Normální';
$lng['ticket']['high'] = 'Vysoká';
$lng['ticket']['lastchange'] = 'Poslední změna';
$lng['ticket']['lastchange_from'] = 'Od data (dd.mm.yyyy)';
$lng['ticket']['lastchange_to'] = 'Do data (dd.mm.yyyy)';
$lng['ticket']['category'] = 'Kategorie';
$lng['ticket']['no_cat'] = 'žádná';
$lng['ticket']['message'] = 'Zpráva';
$lng['ticket']['show'] = 'Zobraz';
$lng['ticket']['answer'] = 'Odpověď';
$lng['ticket']['close'] = 'Zavřít';
$lng['ticket']['reopen'] = 'Znovuotevřít';
$lng['ticket']['archive'] = 'Archiv';
$lng['ticket']['ticket_delete'] = 'Smazat tiket';
$lng['ticket']['lastarchived'] = 'Nedávno archivované tikety';
$lng['ticket']['archivedtime'] = 'Archivováno';
$lng['ticket']['open'] = 'Otevřít';
$lng['ticket']['wait_reply'] = 'čeká na odpověď';
$lng['ticket']['replied'] = 'Odpovězeno';
$lng['ticket']['closed'] = 'Zavřený';
$lng['ticket']['staff'] = 'Personál';
$lng['ticket']['customer'] = 'Zákazník';
$lng['ticket']['old_tickets'] = 'Tiket zprávy';
$lng['ticket']['search'] = 'Prohledat archiv';
$lng['ticket']['nocustomer'] = 'žádný výběr';
$lng['ticket']['archivesearch'] = 'Výsledky prohledávání archivu';
$lng['ticket']['noresults'] = 'Nenalezeny žádné tikety';
$lng['ticket']['notmorethanxopentickets'] = 'Kvůli ochraně proti SPAMu nemůžete mít otevřeno víc jak %s tiketů';
$lng['ticket']['supportstatus'] = 'Stav podpory';
$lng['ticket']['supportavailable'] = '<span class="ticket_low">Naše podpora jsou k dispozici a připraveni pomoci.</span>';
$lng['ticket']['supportnotavailable'] = '<span class="ticket_high">Naše podpora není momentálně dostupná</span>';
$lng['admin']['templates']['ticket'] = 'Upozorňovací e-maily pro tikety podpory';
$lng['admin']['templates']['SUBJECT'] = 'Nahrazeno předmětem tiketu podpory';
$lng['admin']['templates']['new_ticket_for_customer'] = 'Zákaznické upozornění, že byl tiket odeslán';
$lng['admin']['templates']['new_ticket_by_customer'] = 'Administrátorské upozornění, že byl tiket otevřen zákazníkem';
$lng['admin']['templates']['new_reply_ticket_by_customer'] = 'Administrátorské upozornění, že přišla odpověď na tiket od zákazníka';
$lng['admin']['templates']['new_ticket_by_staff'] = 'Zákaznické upozornění, že byl tiket otevřen personálem';
$lng['admin']['templates']['new_reply_ticket_by_staff'] = 'Zákaznické upozornění na odpověď na tiket od personálu';
$lng['mails']['new_ticket_for_customer']['mailbody'] = 'Vážený uživateli {FIRSTNAME} {NAME},\n\nVáš tiket podpory s předmětem „{SUBJECT}“ byl odeslán.\n\nAž přijde odpověď na Váš tiket, budete upozorněni.\n\nDěkujeme,\n váš správce';
$lng['mails']['new_ticket_for_customer']['subject'] = 'Váš tiket na podporu byl odeslán';
$lng['mails']['new_ticket_by_customer']['mailbody'] = 'Milý administrátore,\n\nbyl odeslán nový tiket s předmětem „{SUBJECT}“.\n\nProsím přihlašte se pro otevření tiketu.\n\nDěkujeme,\n váš správce';
$lng['mails']['new_ticket_by_customer']['subject'] = 'Nový tiket podpory byl odeslán';
$lng['mails']['new_reply_ticket_by_customer']['mailbody'] = 'Milý administrátore,\n\ntiket podpory „{SUBJECT}“ byl zodpovězen zákazníkem.\n\nProsím přihlašte se pro otevření tiketu.\n\nDěkujeme,\n váš správce';
$lng['mails']['new_reply_ticket_by_customer']['subject'] = 'Nová odpověď na tiket podpory';
$lng['mails']['new_ticket_by_staff']['mailbody'] = 'Vážený uživateli {FIRSTNAME} {NAME},\n\nbyl pro Vás otevřen tiket podpory s předmětem „{SUBJECT}“.\n\nProsím přihlašte se pro otevření tiketu.\n\nDěkujeme,\n váš správce';
$lng['mails']['new_ticket_by_staff']['subject'] = 'Nový tiket podpory byl odeslán';
$lng['mails']['new_reply_ticket_by_staff']['mailbody'] = 'Vážený uživateli {FIRSTNAME} {NAME},\n\ntiket podpory s předmětem „{SUBJECT}“ byl zodpovězen naším personálem.\n\nPro přečtení tiketu se prosím přihlašte.\n\nDěkujem,\n váš správce';
$lng['mails']['new_reply_ticket_by_staff']['subject'] = 'Nová odpověď na tiket podpory';
$lng['question']['ticket_reallyclose'] = 'Opravdu chcete zavřít tiket „%s“?';
$lng['question']['ticket_reallydelete'] = 'Opravdu chcete smazat tiket „%s“?';
$lng['question']['ticket_reallydeletecat'] = 'Opravdu chcete smazat kategorii „%s“?';
$lng['question']['ticket_reallyarchive'] = 'Opravdu chcete přesunout tiket „%s“ do archivu?';
$lng['error']['nomoreticketsavailable'] = 'Použili jste všechny dostupné tikety. Prosím kontaktujte svého administrátora.';
$lng['error']['nocustomerforticket'] = 'Nemohu vytvářet tikety bez zákazníků';
$lng['error']['categoryhastickets'] = 'Kategorie stále obsahuje tikety.<br />Prosím smažte tikety aby jste mohli smazat kategorii';
$lng['admin']['ticketsettings'] = 'Tikety-podpory nastavení';
$lng['admin']['archivelastrun'] = 'Poslední archivace tiketů';
$lng['serversettings']['ticket']['noreply_email']['title'] = 'Bez odpovědní e-mailová adresa';
$lng['serversettings']['ticket']['noreply_email']['description'] = 'Odesílatelova adresa pro tikety podpory, většinou něco jako no-reply@domain.tld';
$lng['serversettings']['ticket']['worktime_begin']['title'] = 'Začátek práce podpory (hh:mm)';
$lng['serversettings']['ticket']['worktime_begin']['description'] = 'Start-time pokud je podpora k dispozici';
$lng['serversettings']['ticket']['worktime_end']['title'] = 'Konec práce podpory (hh:mm)';
$lng['serversettings']['ticket']['worktime_end']['description'] = 'End-time pokud je podpora k dispozici';
$lng['serversettings']['ticket']['worktime_sat'] = 'Je podpora k dispozici o sobotách?';
$lng['serversettings']['ticket']['worktime_sun'] = 'Je podpora k dispozici o nedělích?';
$lng['serversettings']['ticket']['worktime_all']['title'] = 'Podpora bez časového omezení';
$lng['serversettings']['ticket']['worktime_all']['description'] = 'Pokud „Ano“ možnosti začátku a konce práce podpory bude přepsána';
$lng['serversettings']['ticket']['archiving_days'] = 'Po kolika dnech by měly být uzavřené tikety archivovány?';
$lng['customer']['tickets'] = 'Tikety podpory';

// ADDED IN 1.2.18-svn4

$lng['admin']['domain_nocustomeraddingavailable'] = 'Momentálně není možné přidat doménu. Nejdříve musíte přidat aspoň jednoho zákazníka.';
$lng['serversettings']['ticket']['enable'] = 'Zapnout systém tiketů';
$lng['serversettings']['ticket']['concurrentlyopen'] = 'Kolik tiketů by mělo být k dispozici najednou?';
$lng['error']['norepymailiswrong'] = '„Bezodpovědní adresa“ je špatně. Je povolena pouze validní e-mailová adresa.';
$lng['error']['tadminmailiswrong'] = '„Ticketadmin-adresa“ je špatně. Je povolena pouze validní e-mailová adresa.';
$lng['ticket']['awaitingticketreply'] = 'Máte %s nezodpovězených tiketů podpory';

// ADDED IN 1.2.18-svn5

$lng['serversettings']['ticket']['noreply_name'] = 'Jméno odesílatele tiketů v e-mailu';
