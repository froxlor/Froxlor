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
$lng['panel']['create'] = 'vytvoøit';
$lng['panel']['save'] = 'uložit';
$lng['panel']['yes'] = 'ano';
$lng['panel']['no'] = 'ne';
$lng['panel']['emptyfornochanges'] = 'prázdné - žádné zmì ny';
$lng['panel']['emptyfordefault'] = 'prázdné - pro výchozí';
$lng['panel']['path'] = 'Cesta';
$lng['panel']['toggle'] = 'Pøepnout';
$lng['panel']['next'] = 'další';
$lng['panel']['dirsmissing'] = 'Nemohu nejít/èíst adresáø!';

/**
 * Login
 */

$lng['login']['username'] = 'Uživatel';
$lng['login']['password'] = 'Heslo';
$lng['login']['language'] = 'Jazyk';
$lng['login']['login'] = 'Pøihlásit';
$lng['login']['logout'] = 'Odhlásit';
$lng['login']['profile_lng'] = 'Jazyk profilu';

/**
 * Customer
 */

$lng['customer']['documentroot'] = 'Domácí adresáø';
$lng['customer']['name'] = 'Jméno';
$lng['customer']['firstname'] = 'Køestní jméno';
$lng['customer']['company'] = 'Spoleènost';
$lng['customer']['street'] = 'Ulice';
$lng['customer']['zipcode'] = 'PSÈ';
$lng['customer']['city'] = 'Mì sto';
$lng['customer']['phone'] = 'Telefon';
$lng['customer']['fax'] = 'Fax';
$lng['customer']['email'] = 'Email';
$lng['customer']['customernumber'] = 'Zákazníkovo ID';
$lng['customer']['diskspace'] = 'Webový prostor (MB)';
$lng['customer']['traffic'] = 'Pøenosy (GB)';
$lng['customer']['mysqls'] = 'MySQL-Databáze';
$lng['customer']['emails'] = 'E-mailové-adresy';
$lng['customer']['accounts'] = 'E-mailvé-Úèty';
$lng['customer']['forwarders'] = 'E-mailové-Pøeposílaèe';
$lng['customer']['ftps'] = 'FTP-Úèty';
$lng['customer']['subdomains'] = 'Sub-Domény';
$lng['customer']['domains'] = 'Doména';
$lng['customer']['unlimited'] = 'neomezeno';

/**
 * Customermenue
 */

$lng['menue']['main']['main'] = 'Hlavní';
$lng['menue']['main']['changepassword'] = 'Zmì nit heslo';
$lng['menue']['main']['changelanguage'] = 'Zmì nit jazyl';
$lng['menue']['email']['email'] = 'E-mail';
$lng['menue']['email']['emails'] = 'Adresy';
$lng['menue']['email']['webmail'] = 'WebMail';
$lng['menue']['mysql']['mysql'] = 'MySQL';
$lng['menue']['mysql']['databases'] = 'Databáze';
$lng['menue']['mysql']['phpmyadmin'] = 'phpMyAdmin';
$lng['menue']['domains']['domains'] = 'Domény';
$lng['menue']['domains']['settings'] = 'Nastavení';
$lng['menue']['ftp']['ftp'] = 'FTP';
$lng['menue']['ftp']['accounts'] = 'Úèty';
$lng['menue']['ftp']['webftp'] = 'WebFTP';
$lng['menue']['extras']['extras'] = 'Extra';
$lng['menue']['extras']['directoryprotection'] = 'Ochrana adresáøe';
$lng['menue']['extras']['pathoptions'] = 'nastavení cesty';

/**
 * Index
 */

$lng['index']['customerdetails'] = 'Detaily zákazníka';
$lng['index']['accountdetails'] = 'Detaily Úètu';

/**
 * Change Password
 */

$lng['changepassword']['old_password'] = 'Staré heslo';
$lng['changepassword']['new_password'] = 'Nové heslo';
$lng['changepassword']['new_password_confirm'] = 'Nové heslo (potvrzení)';
$lng['changepassword']['new_password_ifnotempty'] = 'Nové heslo (prázdné = beze zmì n)';
$lng['changepassword']['also_change_ftp'] = ' také zmì nit heslo k hlavnímu FTP Úètu';

/**
 * Domains
 */

$lng['domains']['description'] = 'Zde mùžete vytvoøit (sub-)domény a mì nit jejich cesty.<br />Systém potøebuje nì jaký èas, než se po Úpravì  nové nastavení projeví.';
$lng['domains']['domainsettings'] = 'Nastavení domény';
$lng['domains']['domainname'] = 'Jméno domény';
$lng['domains']['subdomain_add'] = 'Vytvoøit subdoménu';
$lng['domains']['subdomain_edit'] = 'Upravit (sub)doménu';
$lng['domains']['wildcarddomain'] = 'Vytvoøit jako wildcard doménu?';
$lng['domains']['aliasdomain'] = 'Alias pro doménu';
$lng['domains']['noaliasdomain'] = 'žádný alias pro doménu';

/**
 * E-mails
 */

$lng['emails']['description'] = 'Zde mùžete také vytvoøit a mì nit e-mailové adresy.<br />Úèet je jako Vaše poštovní schránka pøed Vaším domem. Pokud Vám nì kdo pošle e-mail, pøijde na tento Úèet.<br /><br />Pro stažení e-mailù použijte následující nastavení ve svém poštovním klientu: (Data <i>kurzívou</i> musí být zmì nì na podle toho, co jste zadali!)<br />Host: <b><i>Jméno domény</i></b><br />Uživatelské jméno: <b><i>Jméno Úètu / e-mailové adresy</i></b><br />Heslo: <b><i>heslo které jste zadali</i></b>';
$lng['emails']['emailaddress'] = 'E-mail-adresa';
$lng['emails']['emails_add'] = 'Vytvoøit e-mailovou-adresu';
$lng['emails']['emails_edit'] = 'Editovat e-mailovou-addresu';
$lng['emails']['catchall'] = 'Catchall';
$lng['emails']['iscatchall'] = 'Definovat jako catchall-adresu?';
$lng['emails']['account'] = 'Úèet';
$lng['emails']['account_add'] = 'Vytvoøit Úèet';
$lng['emails']['account_delete'] = 'Smazat Úèet';
$lng['emails']['from'] = 'Zdroj';
$lng['emails']['to'] = 'Cíl';
$lng['emails']['forwarders'] = 'Pøeposílatelé';
$lng['emails']['forwarder_add'] = 'Vytvoøit pøeposílatele';

/**
 * FTP
 */

$lng['ftp']['description'] = 'Zde mùžete vytváøet a mì nit FTP Úèty.<br />Zmì ny jsou provedeny okamžitì  a Úèty mohou být okamžitì  použity.';
$lng['ftp']['account_add'] = 'Vytvoøit Úèet';

/**
 * MySQL
 */

$lng['mysql']['databasename'] = 'jméno uživatele/databáze';
$lng['mysql']['databasedescription'] = 'popis databáze';
$lng['mysql']['database_create'] = 'Vytvoøit databázi';

/**
 * Extras
 */

$lng['extras']['description'] = 'Zde mùžete vkládat extra vì ci, napøíklad ochranu adresáøù.<br />Systém potøebuje nì jaký èas, než se zmì ny projeví.';
$lng['extras']['directoryprotection_add'] = 'Pøidat ochranu adresáøe';
$lng['extras']['view_directory'] = 'zobrazit obsah adresáøe';
$lng['extras']['pathoptions_add'] = 'pøidat nastavení cesty';
$lng['extras']['directory_browsing'] = 'prohlížení obsahu adresáøe';
$lng['extras']['pathoptions_edit'] = 'upravit nastavení cesty';
$lng['extras']['error404path'] = '404';
$lng['extras']['error403path'] = '403';
$lng['extras']['error500path'] = '500';
$lng['extras']['error401path'] = '401';
$lng['extras']['errordocument404path'] = 'URL k Chybové stránce 404';
$lng['extras']['errordocument403path'] = 'URL k Chybové stránce 403';
$lng['extras']['errordocument500path'] = 'URL k Chybové stránce 500';
$lng['extras']['errordocument401path'] = 'URL k Chybové stránce 401';

/**
 * Errors
 */

$lng['error']['error'] = 'Chyba';
$lng['error']['directorymustexist'] = 'Adresáø %s musí existovat. Prosím vytvoøte jej s pomocí Vašeho FTP klienta.';
$lng['error']['filemustexist'] = 'Soubor %s musí existovat.';
$lng['error']['allresourcesused'] = 'Už jste použili všechny své zdroje.';
$lng['error']['domains_cantdeletemaindomain'] = 'Nemùžete smazat doménu, která se používá jako e-mailová doména.';
$lng['error']['domains_canteditdomain'] = 'Nemùžete upravovat tuto doménu. Byla zakázána adminem.';
$lng['error']['domains_cantdeletedomainwithemail'] = 'Nemùžete smazat doménu, která se používá jako e-mailová doména. Nejdøíve smažte všechny emailové adresy.';
$lng['error']['firstdeleteallsubdomains'] = 'Musíte smazat všechny subdomény než budete moci vytvoøit "wildcard" doménu.';
$lng['error']['youhavealreadyacatchallforthisdomain'] = 'Už jste definovali "catchall" pro tuto doménu.';
$lng['error']['ftp_cantdeletemainaccount'] = 'Nemùžete smazat svùj hlavní FTP Úèet';
$lng['error']['login'] = 'Uživatelské jméno nebo heslo, které jste zadali, je špatné. Prosím zkuste to znovu!';
$lng['error']['login_blocked'] = 'Tento Úèet byl zablokován z dùvodu pøíliš velkého množství chyb pøi pøihlášení. <br />Prosím zkuste to znovu za ' . $settings['login']['deactivatetime'] . ' sekund.';
$lng['error']['notallreqfieldsorerrors'] = 'Nevyplnili jste všechna políèka nebo jsou nì které vyplnì na špatnì .';
$lng['error']['oldpasswordnotcorrect'] = 'Staré heslo není správné.';
$lng['error']['youcantallocatemorethanyouhave'] = 'Nemùžete alokovat více zdrojù než sami vlastníte';
$lng['error']['mustbeurl'] = 'Vložili jste nesprávnou nebo nekompletní url (napø. http://somedomain.com/error404.htm)';
$lng['error']['invalidpath'] = 'Nevybrali jste správnou url (možná problém s "dirlistingem"?)';
$lng['error']['stringisempty'] = 'Chybì jící vstup v poli';
$lng['error']['stringiswrong'] = 'špatný vstup v poli';
$lng['error']['myloginname'] = '\'' . $lng['login']['username'] . '\'';
$lng['error']['mypassword'] = '\'' . $lng['login']['password'] . '\'';
$lng['error']['oldpassword'] = '\'' . $lng['changepassword']['old_password'] . '\'';
$lng['error']['newpassword'] = '\'' . $lng['changepassword']['new_password'] . '\'';
$lng['error']['newpasswordconfirm'] = '\'' . $lng['changepassword']['new_password_confirm'] . '\'';
$lng['error']['newpasswordconfirmerror'] = 'Nové heslo se neshoduje s tím pro potvrzení';
$lng['error']['myname'] = '\'' . $lng['customer']['name'] . '\'';
$lng['error']['myfirstname'] = '\'' . $lng['customer']['firstname'] . '\'';
$lng['error']['emailadd'] = '\'' . $lng['customer']['email'] . '\'';
$lng['error']['mydomain'] = '\'Domain\'';
$lng['error']['mydocumentroot'] = '\'Documentroot\'';
$lng['error']['loginnameexists'] = 'Pøihlašovací jméno %s již existuje';
$lng['error']['emailiswrong'] = 'Emailová adresa %s obsahuje nepovolené znaky nebo je nekompletní';
$lng['error']['loginnameiswrong'] = 'Pøihlašovací jméno %s obsahuje nepovolené znaky';
$lng['error']['userpathcombinationdupe'] = 'Kombinace Uživatelského jména a cesty již existuje';
$lng['error']['patherror'] = 'Obecná chyba! Cesta nemùže být prázdná';
$lng['error']['errordocpathdupe'] = 'Možnost pro cestu %s již existuje';
$lng['error']['adduserfirst'] = 'Vytvoøte prosím nejdøíve zákazníka';
$lng['error']['domainalreadyexists'] = 'Doména %s je již pøiøazena k zákazníkovi';
$lng['error']['nolanguageselect'] = 'Nebyl vybrán žádný jazyk.';
$lng['error']['nosubjectcreate'] = 'Musíte definovat téma pro tuto e-mailovou šablonu.';
$lng['error']['nomailbodycreate'] = 'Musíte definovat text e-mailu pro tuto e-mailovou šablonu.';
$lng['error']['templatenotfound'] = 'šablona nebyla nalezena.';
$lng['error']['alltemplatesdefined'] = 'Nemùžete definovat více šablon, všechny jazyky jsou již podporovány.';
$lng['error']['wwwnotallowed'] = 'www není povoleno pro subdomény.';
$lng['error']['subdomainiswrong'] = 'Subdoména %s obsahuje neplatné znaky.';
$lng['error']['domaincantbeempty'] = 'Jméno domény nesmí být prázdné.';
$lng['error']['domainexistalready'] = 'Doména %s již existuje.';
$lng['error']['domainisaliasorothercustomer'] = 'Vybraný alias pro doménu je buï sama aliasem domény nebo patøí jinému zákazníkovi.';
$lng['error']['emailexistalready'] = 'E-mailová adresa %s již existuje.';
$lng['error']['maindomainnonexist'] = 'Hlavní doména %s neexistuje.';
$lng['error']['destinationnonexist'] = 'Prosím vytvoøte pøeposílatele v poli \'Cíl\'.';
$lng['error']['destinationalreadyexistasmail'] = 'Pøeposílaè na %s již existuje jako aktivní emailová adresa.';
$lng['error']['destinationalreadyexist'] = 'Už jste nastavili pøeposílaè na %s .';
$lng['error']['destinationiswrong'] = 'Pøeposílaè %s obsahuje nesprávné znaky nebo není kompletní.';
$lng['error']['domainname'] = $lng['domains']['domainname'];

/**
 * Questions
 */

$lng['question']['question'] = 'Bezpeènostní otázka';
$lng['question']['admin_customer_reallydelete'] = 'Chcete opravdu smazat uživatele %s? Akci nelze vzít zpì t!';
$lng['question']['admin_domain_reallydelete'] = 'Chcete opravdu smazat doménu %s?';
$lng['question']['admin_domain_reallydisablesecuritysetting'] = 'Chcete opravdu deaktivovat tato Bezpeènostní nastavení (OpenBasedir)?';
$lng['question']['admin_admin_reallydelete'] = 'Chcete opravdu smazat administrátory %s? Každý zákazník a doména bude nastavena k Vašemu Úètu.';
$lng['question']['admin_template_reallydelete'] = 'Chcete opravdu smazat šablonu \'%s\'?';
$lng['question']['domains_reallydelete'] = 'Chcete opravdu smazat doménu %s?';
$lng['question']['email_reallydelete'] = 'Opravdu chcete smazat e-mailovou adresu %s?';
$lng['question']['email_reallydelete_account'] = 'Chcete opravdu smazat e-mailový Úèet %s?';
$lng['question']['email_reallydelete_forwarder'] = 'Chcete opravdu smazat pøeposílaè %s?';
$lng['question']['extras_reallydelete'] = 'Chcete opravdu odstranit ochranu adresáøe %s?';
$lng['question']['extras_reallydelete_pathoptions'] = 'Opravdu chcete smazat nastavení cesty pro %s?';
$lng['question']['ftp_reallydelete'] = 'Opravdu chcete smazat FTP Úèet %s?';
$lng['question']['mysql_reallydelete'] = 'Opravdu chcete smazat databázi %s? Tato akce nemùže být vzata zpì t!';
$lng['question']['admin_configs_reallyrebuild'] = 'Opravdu chcete rebuildovat apache a nabindovat konfiguraèní soubory?';

/**
 * Mails
 */

$lng['mails']['pop_success']['mailbody'] = 'Dobrý den,\n\nVáš e-mailový Úèet {EMAIL}\nbyl v poøádku nastaven.\n\nToto je automaticky vytvoøený\ne-mail, prosím neodpovídejte na nì j!\n\nPøejeme hezký den, Administrator';
$lng['mails']['pop_success']['subject'] = 'Poštovní Úèet byl Úspì šnì  nastaven';
$lng['mails']['createcustomer']['mailbody'] = 'Dobrý den, {FIRSTNAME} {NAME},\n\nzde jsou informace o Vašem Úètu:\n\nUživatel: {USERNAME}\nHeslo: {PASSWORD}\n\nDì kujeme,\nváš správce';
$lng['mails']['createcustomer']['subject'] = 'Informace o Úètu';

/**
 * Admin
 */

$lng['admin']['overview'] = 'Pøehled';
$lng['admin']['ressourcedetails'] = 'Použité zdroje';
$lng['admin']['systemdetails'] = 'Detaily systému';
$lng['admin']['froxlordetails'] = 'Froxlor Detaily';
$lng['admin']['installedversion'] = 'Nainstalovaná verze';
$lng['admin']['latestversion'] = 'Poslední verze';
$lng['admin']['lookfornewversion']['clickhere'] = 'hledat pøes webservice';
$lng['admin']['lookfornewversion']['error'] = 'Chyba pøi ètení';
$lng['admin']['resources'] = 'Zdroje';
$lng['admin']['customer'] = 'Zákazník';
$lng['admin']['customers'] = 'Zákazníci';
$lng['admin']['customer_add'] = 'Vytvoøit zákazníka';
$lng['admin']['customer_edit'] = 'Upravit zákazníka';
$lng['admin']['domains'] = 'Domény';
$lng['admin']['domain_add'] = 'Vytvoøit doménu';
$lng['admin']['domain_edit'] = 'Upravit doménu';
$lng['admin']['subdomainforemail'] = 'Subdomény jako emailové domény';
$lng['admin']['admin'] = 'Administrátor';
$lng['admin']['admins'] = 'Administrátoøi';
$lng['admin']['admin_add'] = 'Vytvoøit administrátora';
$lng['admin']['admin_edit'] = 'Upravit administrátora';
$lng['admin']['customers_see_all'] = 'Mùže vidì t všechy zákazníky?';
$lng['admin']['domains_see_all'] = 'Mùže vidì t všechny domény?';
$lng['admin']['change_serversettings'] = 'Mùže mì nit nastavení serveru?';
$lng['admin']['server'] = 'Server';
$lng['admin']['serversettings'] = 'Nastavení';
$lng['admin']['rebuildconf'] = 'Pøebudovat konfiguraèní soubory';
$lng['admin']['stdsubdomain'] = 'Standardní subdoména';
$lng['admin']['stdsubdomain_add'] = 'Vytvoøit standardní subdoménu';
$lng['admin']['phpenabled'] = 'PHP zapnuto';
$lng['admin']['deactivated'] = 'Deaktivováno';
$lng['admin']['deactivated_user'] = 'Deaktivovat uživatele';
$lng['admin']['sendpassword'] = 'Zaslat heslo';
$lng['admin']['ownvhostsettings'] = 'Vlastní vHost-nastavení';
$lng['admin']['configfiles']['serverconfiguration'] = 'Konfigurace';
$lng['admin']['configfiles']['files'] = '<b>Konfiguraèní soubory:</b> Prosím zmì ï¿½te následující soubory nabo je vytvoøte s<br /> následujícím obsahem, pokud neexistují.<br /><b>Poznámka:</b> MySQL heslo nebylo nahrazeno z bezpeènostních dùvodù.<br />Prosím nahraïte "MYSQL_PASSWORD" svým vlastním. Pokud jste zapomnì li své mysql heslo<br />najdete jej v "lib/userdata.inc.php".';
$lng['admin']['configfiles']['commands'] = '<b>Pøíkazy:</b> Prosím spus?te následující pøíkazy v pøíkazovém øádku.';
$lng['admin']['configfiles']['restart'] = '<b>Restart:</b> Prosím spus?te nísledující pøíkazy v pøíkazovém øádku, aby jste nahráli novou konfiguraci.';
$lng['admin']['templates']['templates'] = 'šablony';
$lng['admin']['templates']['template_add'] = 'Pøidat šablonu';
$lng['admin']['templates']['template_edit'] = 'Upravit šablonu';
$lng['admin']['templates']['action'] = 'Akce';
$lng['admin']['templates']['email'] = 'E-Mail';
$lng['admin']['templates']['subject'] = 'Pøedmì t';
$lng['admin']['templates']['mailbody'] = 'Tì lo mailu';
$lng['admin']['templates']['createcustomer'] = 'Uvítací mail pro nové zákazníky';
$lng['admin']['templates']['pop_success'] = 'Uvítací mail pro nové emailové Úèty';
$lng['admin']['templates']['template_replace_vars'] = 'Promì nné k nahrazení v šablonì :';
$lng['admin']['templates']['FIRSTNAME'] = 'Nahrazeno køestním jménem zákazníka.';
$lng['admin']['templates']['NAME'] = 'Nahrazeno jménem zákazníka.';
$lng['admin']['templates']['USERNAME'] = 'Nahrazeno uživatelským jménem zákazníka.';
$lng['admin']['templates']['PASSWORD'] = 'Nahrazeno zákazníkovým heslem.';
$lng['admin']['templates']['EMAIL'] = 'Nahrazeno adresou POP3/IMAP Úètu.';

/**
 * Serversettings
 */

$lng['serversettings']['session_timeout']['title'] = 'Session Timeout';
$lng['serversettings']['session_timeout']['description'] = 'Jak dlouho musý být uživatel neaktivní, než session vyprší (sekundy)?';
$lng['serversettings']['accountprefix']['title'] = 'Zákazníkova pøedpona';
$lng['serversettings']['accountprefix']['description'] = 'Jké pøedpony by mì ly mít Úèty zákazníkù?';
$lng['serversettings']['mysqlprefix']['title'] = 'SQL pøedpona';
$lng['serversettings']['mysqlprefix']['description'] = 'Jaké pøedpony by mì ly mít Úèty mysql?';
$lng['serversettings']['ftpprefix']['title'] = 'FTP pøedpona';
$lng['serversettings']['ftpprefix']['description'] = 'Jakou pøedponu by mì ly mít ftp Úèty?';
$lng['serversettings']['documentroot_prefix']['title'] = 'Domácí adresáø';
$lng['serversettings']['documentroot_prefix']['description'] = 'Kde by mì ly být uloženy všechny domácí adresáøe?';
$lng['serversettings']['logfiles_directory']['title'] = 'Adresáø pro log soubory';
$lng['serversettings']['logfiles_directory']['description'] = 'Kde by mì ly být všechny log soubory uloženy?';
$lng['serversettings']['ipaddress']['title'] = 'IP-Adresa';
$lng['serversettings']['ipaddress']['description'] = 'Jaká je IP adresa tohoto serveru?';
$lng['serversettings']['hostname']['title'] = 'Jméno hosta';
$lng['serversettings']['hostname']['description'] = 'Jaké je jméno hosta tohoto serveru?';
$lng['serversettings']['apachereload_command']['title'] = 'Pøíkaz pro reload apache';
$lng['serversettings']['apachereload_command']['description'] = 'Jaký je pøíkaz, kterým apache znovunahraje své konfiguraèní soubory?';
$lng['serversettings']['bindconf_directory']['title'] = 'Bindujte konfiguraèní adresáø';
$lng['serversettings']['bindconf_directory']['description'] = 'Kde by mì ly být uloženy "bind configfiles"?';
$lng['serversettings']['bindreload_command']['title'] = 'Bind reload pøíkaz';
$lng['serversettings']['bindreload_command']['description'] = 'Jaký je pøíkaz pro znovunahrání "bind configfiles"?';
$lng['serversettings']['binddefaultzone']['title'] = 'Bind výchozí zï¿½na';
$lng['serversettings']['binddefaultzone']['description'] = 'Jaký je název výchozí zï¿½ny?';
$lng['serversettings']['vmail_uid']['title'] = 'UID-mailù';
$lng['serversettings']['vmail_uid']['description'] = 'Jaké UserID by mì ly e-maily mít?';
$lng['serversettings']['vmail_gid']['title'] = 'GID-mailù';
$lng['serversettings']['vmail_gid']['description'] = 'Jaké GroupID by mì ly maily mít?';
$lng['serversettings']['vmail_homedir']['title'] = 'Mails-Home adresáø';
$lng['serversettings']['vmail_homedir']['description'] = 'Kam by se mì ly všechny maily ukládat?';
$lng['serversettings']['adminmail']['title'] = 'Odesílatel';
$lng['serversettings']['adminmail']['description'] = 'Jaká je odesílatelova adresa pro emaily odeslané z Panelu?';
$lng['serversettings']['phpmyadmin_url']['title'] = 'phpMyAdminova URL';
$lng['serversettings']['phpmyadmin_url']['description'] = 'Jaká je URL adresa phpMyAdmin? (musí zaèínat http(s)://)';
$lng['serversettings']['webmail_url']['title'] = 'WebMailová URL';
$lng['serversettings']['webmail_url']['description'] = 'Jaká je URL adresa k WebMailu? (musí zaèínat with http(s)://)';
$lng['serversettings']['webftp_url']['title'] = 'WebFTP URL';
$lng['serversettings']['webftp_url']['description'] = 'Jaká je URL k WebFTP? (musí zaèínat with http(s)://)';
$lng['serversettings']['language']['description'] = 'Jaký je výchozí jazyk Vašeho serveru?';
$lng['serversettings']['maxloginattempts']['title'] = 'Maximální poèet pokusù o pøihlášení';
$lng['serversettings']['maxloginattempts']['description'] = 'Maximální poèet pokusù o pøihlášení k Úètu, než se Úèet zablokuje.';
$lng['serversettings']['deactivatetime']['title'] = 'Deaktivovaný po dobu';
$lng['serversettings']['deactivatetime']['description'] = 'èas (sek.) po který bude Úèet deaktivován pro pøíliš mnoho pokusù o pøihlášení.';
$lng['serversettings']['pathedit']['title'] = 'Typ vstupu cesty';
$lng['serversettings']['pathedit']['description'] = 'Mì la by být cesta vybírána pomocí vyskakovacího menu nebo vstupním polem?';
$lng['serversettings']['nameservers']['title'] = 'Nameservery';
$lng['serversettings']['nameservers']['description'] = 'Støedníkem oddì lený seznam obsahující hostname všech nameserverù. První bude primární.';
$lng['serversettings']['mxservers']['title'] = 'MX servery';
$lng['serversettings']['mxservers']['description'] = 'Støedníkem oddì lený seznam obsahující páry èísel a hostname oddì lených mezerou (napø. \'10 mx.example.com\') obsahující mx servery.';

/**
 * CHANGED BETWEEN 1.2.12 and 1.2.13
 */

$lng['mysql']['description'] = 'Zde mùžete vytváøet a mì nit své MySQL-Databáze.<br />Zmì ny jsou provedeny okamžitì  a databáze mùže být okamžitì  používána.<br />V menu vlevo mùžete najít nástroj phpMyAdmin se kterým mùžete jednoduše upravovat svou databázi.<br /><br />Pro použití databáze ve svých php skriptech použijte následující nastavení: (Data <i>kurzívou</i> musí být zmì nì na na Vámi vložené hodnoty!)<br />Host: <b><SQL_HOST></b><br />Uživatelské jméno: <b><i>Databasename</i></b><br />Heslo: <b><i>heslo které jste zvolili</i></b><br />Databáze: <b><i>Databasename</i></b>';

/**
 * ADDED BETWEEN 1.2.12 and 1.2.13
 */

$lng['serversettings']['paging']['title'] = 'Záznamù na stránku';
$lng['serversettings']['paging']['description'] = 'Kolik záznamù by mì lo být zobrazeno na stránce? (0 = zrušit stránkování)';
$lng['error']['ipstillhasdomains'] = 'IP/Port kombinace, kterou chcete smazat má stále pøiøazené domény, prosím pøeøaïte je k jiné IP/Port kombinaci než smažete tuto IP/Port kombinaci.';
$lng['error']['cantdeletedefaultip'] = 'Nemùžete smazat IP/Port kombinaci výchozího pøeprodejce, prosím vytvoøte jinou IP/Port kombinaci výchozí pro pøeprodejce než smažete tuto IP/Port kombinaci.';
$lng['error']['cantdeletesystemip'] = 'Nemùžete smazat poslední systémovou IP, buï vytvoøte novou IP/Port kombinaci pro systémovou IP nebo zmì ï¿½te IP systému.';
$lng['error']['myipaddress'] = '\'IP\'';
$lng['error']['myport'] = '\'Port\'';
$lng['error']['myipdefault'] = 'Musíte vybrat IP/Port kombinaci která by se mì la stát výchozí.';
$lng['error']['myipnotdouble'] = 'Tato kombinace IP/Portu již existuje.';
$lng['question']['admin_ip_reallydelete'] = 'Chcete opravdu smayat IP adresu %s?';
$lng['admin']['ipsandports']['ipsandports'] = 'IP a Porty';
$lng['admin']['ipsandports']['add'] = 'Pøidat IP/Port';
$lng['admin']['ipsandports']['edit'] = 'Upravit IP/Port';
$lng['admin']['ipsandports']['ipandport'] = 'IP/Port';
$lng['admin']['ipsandports']['ip'] = 'IP';
$lng['admin']['ipsandports']['port'] = 'Port';

// ADDED IN 1.2.13-rc3

$lng['error']['cantchangesystemip'] = 'Nemùžete zmì nit poslední systémovou IP, buï vytvoøte novou IP/Port kombinaci pro systémovou IP nebo zmì ï¿½te IP systému.';
$lng['question']['admin_domain_reallydocrootoutofcustomerroot'] = 'Jste si jisti, že chcete aby root dokumentù pro tuto doménu nebyl v "customerroot" zákazníka?';

// ADDED IN 1.2.14-rc1

$lng['admin']['memorylimitdisabled'] = 'Zakázáno';
$lng['domain']['openbasedirpath'] = 'OpenBasedir-cesta';
$lng['domain']['docroot'] = 'Cesta z políèka nahoøe';
$lng['domain']['homedir'] = 'Domovní adresáø';
$lng['admin']['valuemandatory'] = 'Tato hodnota je povinná';
$lng['admin']['valuemandatorycompany'] = 'Buï "jméno" a "køestní jméno" nebo "spoleènost" musí být vyplnì na';
$lng['menue']['main']['username'] = 'Pøihlášen(a) jako: ';
$lng['panel']['urloverridespath'] = 'URL (pøepíše cestu)';
$lng['panel']['pathorurl'] = 'Cesta nebo URL';
$lng['error']['sessiontimeoutiswrong'] = 'Pouze èíselné "Session Timeout" je povoleno.';
$lng['error']['maxloginattemptsiswrong'] = 'ouze èíselné "Maximální poèet pokusù o pøihlášení" je povoleno.';
$lng['error']['deactivatetimiswrong'] = 'ouze èíselné "èas deaktivace" je povoleno.';
$lng['error']['accountprefixiswrong'] = '"Pøedpona uživatele" je špatnì .';
$lng['error']['mysqlprefixiswrong'] = '"SQL pøedpona" je špatnì .';
$lng['error']['ftpprefixiswrong'] = '"FTP pøedpona" je špatnì .';
$lng['error']['ipiswrong'] = '"IP-Adresa" je špatnì . Pouze validní IP adresa je povolena.';
$lng['error']['vmailuidiswrong'] = '"Mails-uid" je špatnì . Je povoleno pouze èíselné UID.';
$lng['error']['vmailgidiswrong'] = '"Mails-gid" je špatnì . Je povoleno pouze èíselné GID.';
$lng['error']['adminmailiswrong'] = '"Sender-address" je špatnì . Je povolena pouze validní emailová adresa.';
$lng['error']['pagingiswrong'] = '"Entries per Page"-value je špatnì . Jsou povolena pouze èísla.';
$lng['error']['phpmyadminiswrong'] = 'phpMyAdmin-url naní správná url.';
$lng['error']['webmailiswrong'] = 'WebMail-odkaz není správný odkaz.';
$lng['error']['webftpiswrong'] = 'WebFTP-odkaz není správný odkaz.';
$lng['domains']['hasaliasdomains'] = 'Má aliasové domény';
$lng['serversettings']['defaultip']['title'] = 'Výchozí IP/Port';
$lng['serversettings']['defaultip']['description'] = 'Jaká je výchozí IP/Port kombinace?';
$lng['domains']['statstics'] = 'Statistika použití';
$lng['panel']['ascending'] = 'sestupnì ';
$lng['panel']['decending'] = 'vzestupnì ';
$lng['panel']['search'] = 'Vyhledávání';
$lng['panel']['used'] = 'použito';

// ADDED IN 1.2.14-rc3

$lng['panel']['translator'] = 'Pøekladatel';

// ADDED IN 1.2.14-rc4

$lng['error']['stringformaterror'] = 'Hodnota pole "%s" není v oèekávaném formátu.';

// ADDED IN 1.2.15-rc1

$lng['admin']['serversoftware'] = 'Software serveru';
$lng['admin']['phpversion'] = 'PHP-Verze';
$lng['admin']['phpmemorylimit'] = 'PHP-Limit-Pamì ti';
$lng['admin']['mysqlserverversion'] = 'MySQL verze serveru';
$lng['admin']['mysqlclientversion'] = 'MySQL verze klienta';
$lng['admin']['webserverinterface'] = 'Webserver rozhraní';
$lng['domains']['isassigneddomain'] = 'Je pøiøazená doména';
$lng['serversettings']['phpappendopenbasedir']['title'] = 'Cesty k pøidání k OpenBasedir';
$lng['serversettings']['phpappendopenbasedir']['description'] = 'Tyto cesty (oddì leny pomocí "colons") budou vloženy  do OpenBasedir-statementu v každém vhost-containeru.';

// CHANGED IN 1.2.15-rc1

$lng['error']['loginnameissystemaccount'] = 'Nemùžete vytvoøit Úèty, které jsou podobné systémovým Úètùm (napøíklad zaèínají "%s"). Prosím vložte jiné jméno Úètu.';
$lng['error']['youcantdeleteyourself'] = 'Z bezpeènostních dùvodù se nemùžete smazat.';
$lng['error']['youcanteditallfieldsofyourself'] = 'Poznámka: Z bezpeènostních dùvodù nemùžete upravovat všechna pole svého Úètu.';

// ADDED IN 1.2.16-svn1

$lng['serversettings']['natsorting']['title'] = 'Použít "lidské" tøídì ní v seznamech';
$lng['serversettings']['natsorting']['description'] = 'øadit seznamy jako web1 -> web2 -> web11 místo web1 -> web11 -> web2.';

// ADDED IN 1.2.16-svn2

$lng['serversettings']['deactivateddocroot']['title'] = 'Docroot pro deaktivované uživatele';
$lng['serversettings']['deactivateddocroot']['description'] = 'Když bude uživatel deaktivován, tato cesta bude použita jako jeho docroot. Ponechte prázdné, pokud nechcete vytváøet.';

// ADDED IN 1.2.16-svn4

$lng['panel']['reset'] = 'zrušit zmì ny';
$lng['admin']['accountsettings'] = 'Nastavení Úètu';
$lng['admin']['panelsettings'] = 'Nastavení panelu';
$lng['admin']['systemsettings'] = 'Nastavení systému';
$lng['admin']['webserversettings'] = 'Nastavení webserveru';
$lng['admin']['mailserversettings'] = 'Nastavení mailserveru';
$lng['admin']['nameserversettings'] = 'Nastavení nameserveru';
$lng['admin']['updatecounters'] = 'Pøepoèítat využití zdrojù';
$lng['question']['admin_counters_reallyupdate'] = 'Opravdu chcete pøepoèítat využití zdrojù?';
$lng['panel']['pathDescription'] = 'Pokud adresáø neexistuje, bude vytvoøen automaticky.';

// ADDED IN 1.2.16-svn6

$lng['mails']['trafficninetypercent']['mailbody'] = 'Vážený uživateli {NAME},\n\nPoužil jste {TRAFFICUSED} MB z Vámi dostupných {TRAFFIC} MB pøenosù.\nTo je více jak 90%.\n\nPøejeme hezký den, váš správce';
$lng['mails']['trafficninetypercent']['subject'] = 'Dosahujíc vašeho limitu pøenosù';
$lng['admin']['templates']['trafficninetypercent'] = 'Upozorï¿½ovací mail pro zákazníky, pokud vyèerpají 90% z pøenosù';
$lng['admin']['templates']['TRAFFIC'] = 'Nahrazeno pøenosy, které byly pøidì leny uživateli.';
$lng['admin']['templates']['TRAFFICUSED'] = 'Nahrazeno pøenosy, které byly vyèerpány zákazníkem.';

// ADDED IN 1.2.16-svn7

$lng['admin']['subcanemaildomain']['never'] = 'Nikdy';
$lng['admin']['subcanemaildomain']['choosableno'] = 'Výbì r, výchozí ne';
$lng['admin']['subcanemaildomain']['choosableyes'] = 'Výbì r, výchozí ano';
$lng['admin']['subcanemaildomain']['always'] = 'Vždy';
$lng['changepassword']['also_change_webalizer'] = ' také zmì ï¿½te heslo pro webalizer statistics';

// ADDED IN 1.2.16-svn8

$lng['serversettings']['mailpwcleartext']['title'] = 'Také uložte hesla mailových Úètù nešifrovaná v databázi';
$lng['serversettings']['mailpwcleartext']['description'] = 'Pokud je toto nastaveno na "ano", všechna hesla budou ukládána bez šifrování (èístý text, èitelná pro kohokoliv s pøístupem k databázi) v tabulce mail_users. Toto aktivujte jen pokud to opravdu potøebujete!';
$lng['serversettings']['mailpwcleartext']['removelink'] = 'Kliknutím zde vymažete všechna nezašifrovaná hesla z tabulky.';
$lng['question']['admin_cleartextmailpws_reallywipe'] = 'Opravdu chcete vymazat všechna nezašifrovaná hesla pro e-mailové Úèty z tabulky mail_users? Tento krok nelze vrátit zpì t!';
$lng['admin']['configfiles']['overview'] = 'Pøehled';
$lng['admin']['configfiles']['wizard'] = 'Prùvodce';
$lng['admin']['configfiles']['distribution'] = 'Distribuce';
$lng['admin']['configfiles']['service'] = 'Služba';
$lng['admin']['configfiles']['daemon'] = 'Daemon';
$lng['admin']['configfiles']['http'] = 'Webserver (HTTP)';
$lng['admin']['configfiles']['dns'] = 'Nameserver (DNS)';
$lng['admin']['configfiles']['mail'] = 'Mailserver (IMAP/POP3)';
$lng['admin']['configfiles']['smtp'] = 'Mailserver (SMTP)';
$lng['admin']['configfiles']['ftp'] = 'FTP-Server';
$lng['admin']['configfiles']['etc'] = 'Ostatní (System)';
$lng['admin']['configfiles']['choosedistribution'] = '-- Vyberte distribuci --';
$lng['admin']['configfiles']['chooseservice'] = '-- Vyberte službu --';
$lng['admin']['configfiles']['choosedaemon'] = '-- Vyberte daemona --';

// ADDED IN 1.2.16-svn10

$lng['serversettings']['ftpdomain']['title'] = 'FTP Úèty na doménì ';
$lng['serversettings']['ftpdomain']['description'] = 'Zákazníci mohou vytváøet FTP Úèty user@customerdomain?';
$lng['panel']['back'] = 'Back';

// ADDED IN 1.2.16-svn12

$lng['serversettings']['mod_log_sql']['title'] = 'Doèasnì  ukládat logy do databáze';
$lng['serversettings']['mod_log_sql']['description'] = 'Použít <a target="blank" href="http://www.outoforder.cc/projects/apache/mod_log_sql/" title="mod_log_sql">mod_log_sql</a> pro doèasné uložení webrequestù<br /><b>Toto vyžaduje speciální <a target="blank" href="http://files.syscp.org/docs/mod_log_sql/" title="mod_log_sql - documentation">konfiguraci apache</a>!</b>';
$lng['serversettings']['mod_fcgid']['title'] = 'Includuj PHP pøes mod_fcgid/suexec';
$lng['serversettings']['mod_fcgid']['description'] = 'Použij mod_fcgid/suexec/libnss_mysql pro bì h PHP s odpovídajícím Úøivatelským Úètem.<br/><b>toto vyžaduje speciální konfiguraci apache!</b>';
$lng['serversettings']['sendalternativemail']['title'] = 'Použij alternativní e-mailovou adresu';
$lng['serversettings']['sendalternativemail']['description'] = 'Pošli email s heslem na jinou adresu pøi vytváøení emailového Úètu';
$lng['emails']['alternative_emailaddress'] = 'Alternativní e-mailová adresa';
$lng['mails']['pop_success_alternative']['mailbody'] = 'Vážený uživateli,\n\nVáš emailový Úèet {EMAIL}\nbyl Úspì šnì  nastaven.\nVaše heslo je {PASSWORD}.\n\nTento e-mail byl automaticky vygenerován,\nprosím neodpovídejte na nì j!\n\nPøejeme Vám hezký den, váš správce';
$lng['mails']['pop_success_alternative']['subject'] = 'E-mailový Úèet byl Úspì šnì  vytvoøen';
$lng['admin']['templates']['pop_success_alternative'] = 'Uvítací e-mail pro nové Úèty byl odeslán na alternativní adresu';
$lng['admin']['templates']['EMAIL_PASSWORD'] = 'Nahrazeno heslem Úètu POP3/IMAP.';

// ADDED IN 1.2.16-svn13

$lng['error']['documentrootexists'] = 'Adresáø "%s" již existuje pro tohoto zákazníka. Prosím odstraï¿½te jej, než budete znovu zákazníka vkládat.';

// ADDED IN 1.2.16-svn14

$lng['serversettings']['apacheconf_vhost']['title'] = 'Apache vhost konfiguraèní soubor/dirname';
$lng['serversettings']['apacheconf_vhost']['description'] = 'Kde by mì la být uložena konfigurace vhosta? Mùžete zde buï specifikovat soubor (všichni vhosti v jednom souboru) nebo adresáø (každý vhost má vlastní soubor).';
$lng['serversettings']['apacheconf_diroptions']['title'] = 'Apache diroptions konfiguraèní soubor/dirname';
$lng['serversettings']['apacheconf_diroptions']['description'] = 'Kde by mì la být uložena konfigurace diroptions?  Mùžete zde buï specifikovat soubor (všichni diroptions v jednom souboru) nebo adresáø (každý diroption má vlastní soubor).';
$lng['serversettings']['apacheconf_htpasswddir']['title'] = 'Apache htpasswd dirname';
$lng['serversettings']['apacheconf_htpasswddir']['description'] = 'Kde by mì ly být uloženy htpasswd soubory pro ochranu adresáøù?';

// ADDED IN 1.2.16-svn15

$lng['error']['formtokencompromised'] = 'The request seems to be compromised. Z bezpeènostních dùvodù jste byli odhlášeni.';
$lng['serversettings']['mysql_access_host']['title'] = 'MySQL-Access-Hosts';
$lng['serversettings']['mysql_access_host']['description'] = 'Støedníkem oddì lený seznam hostù, ze kterých bude dovoleno uživatelùm se pøipojit k MySQL-Serveru.';

// ADDED IN 1.2.18-svn1

$lng['admin']['ipsandports']['create_listen_statement'] = 'Vytvoøit Listen statement';
$lng['admin']['ipsandports']['create_namevirtualhost_statement'] = 'Vytvoøit NameVirtualHost statement';
$lng['admin']['ipsandports']['create_vhostcontainer'] = 'Vytvoøit vHost-Container';
$lng['admin']['ipsandports']['create_vhostcontainer_servername_statement'] = 'Vytvoøit ServerName statement v vHost-Container';

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
$lng['menue']['ticket']['archive'] = 'Archiv-tiketù';
$lng['ticket']['description'] = 'Nastavit popis zde!';
$lng['ticket']['ticket_new'] = 'Otevøít nový tiket';
$lng['ticket']['ticket_reply'] = 'zodpovì dì t tiket';
$lng['ticket']['ticket_reopen'] = 'Znovuotevøít tiket';
$lng['ticket']['ticket_newcateory'] = 'Vytvoøit novou kategorii';
$lng['ticket']['ticket_editcateory'] = 'Upravit kategorii';
$lng['ticket']['ticket_view'] = 'Zobrazit ticketcourse';
$lng['ticket']['ticketcount'] = 'Tikety';
$lng['ticket']['ticket_answers'] = 'Odpovì di';
$lng['ticket']['lastchange'] = 'Poslední akce';
$lng['ticket']['subject'] = 'Pøedmì t';
$lng['ticket']['status'] = 'Status';
$lng['ticket']['lastreplier'] = 'Poslední odpovídající';
$lng['ticket']['priority'] = 'Priorita';
$lng['ticket']['low'] = 'Nízká';
$lng['ticket']['normal'] = 'Normální';
$lng['ticket']['high'] = 'Vysoká';
$lng['ticket']['lastchange'] = 'Poslední zmì na';
$lng['ticket']['lastchange_from'] = 'Od data (dd.mm.yyyy)';
$lng['ticket']['lastchange_to'] = 'Do data (dd.mm.yyyy)';
$lng['ticket']['category'] = 'Kategorie';
$lng['ticket']['no_cat'] = 'žádná';
$lng['ticket']['message'] = 'Zpráva';
$lng['ticket']['show'] = 'Zobraz';
$lng['ticket']['answer'] = 'Odpovì ï';
$lng['ticket']['close'] = 'Zavøít';
$lng['ticket']['reopen'] = 'Znovuotevøít';
$lng['ticket']['archive'] = 'Archiv';
$lng['ticket']['ticket_delete'] = 'Smazat tiket';
$lng['ticket']['lastarchived'] = 'Nedávno archivované tikety';
$lng['ticket']['archivedtime'] = 'Archivováno';
$lng['ticket']['open'] = 'Otevøít';
$lng['ticket']['wait_reply'] = 'èeká na odpovì ï';
$lng['ticket']['replied'] = 'Odpovì zeno';
$lng['ticket']['closed'] = 'Zavøený';
$lng['ticket']['staff'] = 'Personál';
$lng['ticket']['customer'] = 'Zákazník';
$lng['ticket']['old_tickets'] = 'Tiket zprávy';
$lng['ticket']['search'] = 'Prohledat archiv';
$lng['ticket']['nocustomer'] = 'žádný výbì r';
$lng['ticket']['archivesearch'] = 'Výsledky prohledávání archivu';
$lng['ticket']['noresults'] = 'Nenalezeny žádné tikety';
$lng['ticket']['notmorethanxopentickets'] = 'Kvùli ochranì  proti SPAMu nemùžete mít otevøeno víc jak %s tiketù';
$lng['ticket']['supportstatus'] = 'Status-podpory';
$lng['ticket']['supportavailable'] = '<span class="ticket_low">Naše podpora jsou k dispozici a pøipraveni pomoci.</span>';
$lng['ticket']['supportnotavailable'] = '<span class="ticket_high">Naše podpora není momentálnì  dostupná</span>';
$lng['admin']['templates']['ticket'] = 'Upozorï¿½ovací e-maily pro tikety podpory';
$lng['admin']['templates']['SUBJECT'] = 'Nahrazeno pøedmì tem tiketu podpory';
$lng['admin']['templates']['new_ticket_for_customer'] = 'Zákaznické upozornì ní, že byl tiket odeslán';
$lng['admin']['templates']['new_ticket_by_customer'] = 'Administrátorské upozornì ní, že byl tiket otevøen zákazníkem';
$lng['admin']['templates']['new_reply_ticket_by_customer'] = 'Administrátorské upozornì ní, že pøišla odpovì ï na tiket od zákazníka';
$lng['admin']['templates']['new_ticket_by_staff'] = 'Zákaznické upozornì ní, že byl tiket otevøen personálem';
$lng['admin']['templates']['new_reply_ticket_by_staff'] = 'Zákaznické upozornì ní na odpovì ï na tiket od personálu';
$lng['mails']['new_ticket_for_customer']['mailbody'] = 'Vážený uživateli {FIRSTNAME} {NAME},\n\nVáš tiket podpory s pøedmì tem "{SUBJECT}" byl odeslán.\n\nAž pøijde odpovì ï na Váš tiket, budete upozornì ni.\n\nDì kujeme,\n váš správce';
$lng['mails']['new_ticket_for_customer']['subject'] = 'Váš tiket na podporu byl odeslán';
$lng['mails']['new_ticket_by_customer']['mailbody'] = 'Milý administrátore,\n\nbyl odeslán nový tiket s pøedmì tem "{SUBJECT}".\n\nProsím pøihlašte se pro otevøení tiketu.\n\nDì kujeme,\n váš správce';
$lng['mails']['new_ticket_by_customer']['subject'] = 'Nový tiket podpory byl odeslán';
$lng['mails']['new_reply_ticket_by_customer']['mailbody'] = 'Milý administrátore,\n\ntiket podpory "{SUBJECT}" byl zodpovì zen zákazníkem.\n\nProsím pøihlašte se pro otevøení tiketu.\n\nDì kujeme,\n váš správce';
$lng['mails']['new_reply_ticket_by_customer']['subject'] = 'Nová odpovì ï na tiket podpory';
$lng['mails']['new_ticket_by_staff']['mailbody'] = 'Vážený uživateli {FIRSTNAME} {NAME},\n\nbyl pro Vás otevøen tiket podpory s pøedmì tem "{SUBJECT}".\n\nProsím pøihlašte se pro otevøení tiketu.\n\nDì kujeme,\n váš správce';
$lng['mails']['new_ticket_by_staff']['subject'] = 'Nový tiket podpory byl odeslán';
$lng['mails']['new_reply_ticket_by_staff']['mailbody'] = 'Vážený uživateli {FIRSTNAME} {NAME},\n\ntiket podpory s pøedmì tem "{SUBJECT}" byl zodpovì zen naším personálem.\n\nPro pøeètení tiketu se prosím pøihlašte.\n\nDì kujem,\n váš správce';
$lng['mails']['new_reply_ticket_by_staff']['subject'] = 'Nová odpovì ï na tiket podpory';
$lng['question']['ticket_reallyclose'] = 'Opravdu chcete zavøít tiket "%s"?';
$lng['question']['ticket_reallydelete'] = 'Opravdu chcete smazat tiket "%s"?';
$lng['question']['ticket_reallydeletecat'] = 'Opravdu chcete smazat kategorii "%s"?';
$lng['question']['ticket_reallyarchive'] = 'Opravdu chcete pøesunout tiket "%s" do archivu?';
$lng['error']['mysubject'] = '\'' . $lng['ticket']['subject'] . '\'';
$lng['error']['mymessage'] = '\'' . $lng['ticket']['message'] . '\'';
$lng['error']['mycategory'] = '\'' . $lng['ticket']['category'] . '\'';
$lng['error']['nomoreticketsavailable'] = 'Použili jste všechny dostupné tikety. Prosím kontaktujte svého administrátora.';
$lng['error']['nocustomerforticket'] = 'Nemohu vytváøet tikety bez zákazníkù';
$lng['error']['categoryhastickets'] = 'Kategorie stále obsahuje tikety.<br />Prosím smažte tikety aby jste mohli smazat kategorii';
$lng['error']['notmorethanxopentickets'] = $lng['ticket']['notmorethanxopentickets'];
$lng['admin']['ticketsettings'] = 'Tikety-podpory nastavení';
$lng['admin']['archivelastrun'] = 'Poslední archivace tiketù';
$lng['serversettings']['ticket']['noreply_email']['title'] = 'Bez odpovì dní e-mailová adresa';
$lng['serversettings']['ticket']['noreply_email']['description'] = 'Odesílatelova adresa pro tikety podpory, vì tšinou nì co jako no-reply@domain.tld';
$lng['serversettings']['ticket']['worktime_begin']['title'] = 'Zaèátek práce podpory (hh:mm)';
$lng['serversettings']['ticket']['worktime_begin']['description'] = 'Start-time pokud je podpora k dispozici';
$lng['serversettings']['ticket']['worktime_end']['title'] = 'Konec práce podpory (hh:mm)';
$lng['serversettings']['ticket']['worktime_end']['description'] = 'End-time pokud je podpora k dispozici';
$lng['serversettings']['ticket']['worktime_sat'] = 'Je podpora k dispozici o sobotách?';
$lng['serversettings']['ticket']['worktime_sun'] = 'Je podpora k dispozici o nedì lích?';
$lng['serversettings']['ticket']['worktime_all']['title'] = 'Podpora bez èasového omezení';
$lng['serversettings']['ticket']['worktime_all']['description'] = 'Pokud "Ano" možnosti zaèátku a konce práce podpory bude pøepsána';
$lng['serversettings']['ticket']['archiving_days'] = 'Po kolika dnech by mì ly být uzavøené tikety archivovány?';
$lng['customer']['tickets'] = 'Tikety podpory';

// ADDED IN 1.2.18-svn4

$lng['admin']['domain_nocustomeraddingavailable'] = 'Momentálnì  není možné pøidat doménu. Nejdøíve musíte pøidat aspoï¿½ jednoho zákazníka.';
$lng['serversettings']['ticket']['enable'] = 'Zapnout systém tiketù';
$lng['serversettings']['ticket']['concurrentlyopen'] = 'Kolik tiketù by mì lo být k dispozici najednou?';
$lng['error']['norepymailiswrong'] = '"Bezodpovì dní adresa" je špatnì . Je povolena pouze validní e-mailová adresa.';
$lng['error']['tadminmailiswrong'] = '"Ticketadmin-adresa" je špatnì . Je povolena pouze validní e-mailová adresa.';
$lng['ticket']['awaitingticketreply'] = 'Máte %s nezodpovì zených tiketù podpory';

// ADDED IN 1.2.18-svn5

$lng['serversettings']['ticket']['noreply_name'] = 'Jméno odesílatele tiketù v emailu';

?>
