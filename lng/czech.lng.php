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
 * @version    $Id$
 */

/**
 * Global
 */

$lng['translator'] = '';
$lng['panel']['edit'] = 'upravit';
$lng['panel']['delete'] = 'smazat';
$lng['panel']['create'] = 'vytvoøit';
$lng['panel']['save'] = 'uloit';
$lng['panel']['yes'] = 'ano';
$lng['panel']['no'] = 'ne';
$lng['panel']['emptyfornochanges'] = 'prázdné - ádné zmìny';
$lng['panel']['emptyfordefault'] = 'prázdné - pro vıchozí';
$lng['panel']['path'] = 'Cesta';
$lng['panel']['toggle'] = 'Pøepnout';
$lng['panel']['next'] = 'další';
$lng['panel']['dirsmissing'] = 'Nemohu nejít/èíst adresáø!';

/**
 * Login
 */

$lng['login']['username'] = 'Uivatel';
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
$lng['customer']['city'] = 'Mìsto';
$lng['customer']['phone'] = 'Telefon';
$lng['customer']['fax'] = 'Fax';
$lng['customer']['email'] = 'Email';
$lng['customer']['customernumber'] = 'Zákazníkovo ID';
$lng['customer']['diskspace'] = 'Webovı prostor (MB)';
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
$lng['menue']['main']['changepassword'] = 'Zmìnit heslo';
$lng['menue']['main']['changelanguage'] = 'Zmìnit jazyl';
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
$lng['index']['accountdetails'] = 'Detaily úètu';

/**
 * Change Password
 */

$lng['changepassword']['old_password'] = 'Staré heslo';
$lng['changepassword']['new_password'] = 'Nové heslo';
$lng['changepassword']['new_password_confirm'] = 'Nové heslo (potvrzení)';
$lng['changepassword']['new_password_ifnotempty'] = 'Nové heslo (prázdné = beze zmìn)';
$lng['changepassword']['also_change_ftp'] = ' také zmìnit heslo k hlavnímu FTP úètu';

/**
 * Domains
 */

$lng['domains']['description'] = 'Zde mùete vytvoøit (sub-)domény a mìnit jejich cesty.<br />Systém potøebuje nìjakı èas, ne se po úpravì nové nastavení projeví.';
$lng['domains']['domainsettings'] = 'Nastavení domény';
$lng['domains']['domainname'] = 'Jméno domény';
$lng['domains']['subdomain_add'] = 'Vytvoøit subdoménu';
$lng['domains']['subdomain_edit'] = 'Upravit (sub)doménu';
$lng['domains']['wildcarddomain'] = 'Vytvoøit jako wildcard doménu?';
$lng['domains']['aliasdomain'] = 'Alias pro doménu';
$lng['domains']['noaliasdomain'] = 'ádnı alias pro doménu';

/**
 * E-mails
 */

$lng['emails']['description'] = 'Zde mùete také vytvoøit a mìnit e-mailové adresy.<br />Úèet je jako Vaše poštovní schránka pøed Vaším domem. Pokud Vám nìkdo pošle e-mail, pøijde na tento úèet.<br /><br />Pro staení e-mailù pouijte následující nastavení ve svém poštovním klientu: (Data <i>kurzívou</i> musí bıt zmìnìna podle toho, co jste zadali!)<br />Host: <b><i>Jméno domény</i></b><br />Uivatelské jméno: <b><i>Jméno úètu / e-mailové adresy</i></b><br />Heslo: <b><i>heslo které jste zadali</i></b>';
$lng['emails']['emailaddress'] = 'E-mail-adresa';
$lng['emails']['emails_add'] = 'Vytvoøit e-mailovou-adresu';
$lng['emails']['emails_edit'] = 'Editovat e-mailovou-addresu';
$lng['emails']['catchall'] = 'Catchall';
$lng['emails']['iscatchall'] = 'Definovat jako catchall-adresu?';
$lng['emails']['account'] = 'Úèet';
$lng['emails']['account_add'] = 'Vytvoøit úèet';
$lng['emails']['account_delete'] = 'Smazat úèet';
$lng['emails']['from'] = 'Zdroj';
$lng['emails']['to'] = 'Cíl';
$lng['emails']['forwarders'] = 'Pøeposílatelé';
$lng['emails']['forwarder_add'] = 'Vytvoøit pøeposílatele';

/**
 * FTP
 */

$lng['ftp']['description'] = 'Zde mùete vytváøet a mìnit FTP úèty.<br />Zmìny jsou provedeny okamitì a úèty mohou bıt okamitì pouity.';
$lng['ftp']['account_add'] = 'Vytvoøit úèet';

/**
 * MySQL
 */

$lng['mysql']['databasename'] = 'jméno uivatele/databáze';
$lng['mysql']['databasedescription'] = 'popis databáze';
$lng['mysql']['database_create'] = 'Vytvoøit databázi';

/**
 * Extras
 */

$lng['extras']['description'] = 'Zde mùete vkládat extra vìci, napøíklad ochranu adresáøù.<br />Systém potøebuje nìjakı èas, ne se zmìny projeví.';
$lng['extras']['directoryprotection_add'] = 'Pøidat ochranu adresáøe';
$lng['extras']['view_directory'] = 'zobrazit obsah adresáøe';
$lng['extras']['pathoptions_add'] = 'pøidat nastavení cesty';
$lng['extras']['directory_browsing'] = 'prohlíení obsahu adresáøe';
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
$lng['error']['allresourcesused'] = 'U jste pouili všechny své zdroje.';
$lng['error']['domains_cantdeletemaindomain'] = 'Nemùete smazat doménu, která se pouívá jako e-mailová doména.';
$lng['error']['domains_canteditdomain'] = 'Nemùete upravovat tuto doménu. Byla zakázána adminem.';
$lng['error']['domains_cantdeletedomainwithemail'] = 'Nemùete smazat doménu, která se pouívá jako e-mailová doména. Nejdøíve smate všechny emailové adresy.';
$lng['error']['firstdeleteallsubdomains'] = 'Musíte smazat všechny subdomény ne budete moci vytvoøit "wildcard" doménu.';
$lng['error']['youhavealreadyacatchallforthisdomain'] = 'U jste definovali "catchall" pro tuto doménu.';
$lng['error']['ftp_cantdeletemainaccount'] = 'Nemùete smazat svùj hlavní FTP úèet';
$lng['error']['login'] = 'Uivatelské jméno nebo heslo, které jste zadali, je špatné. Prosím zkuste to znovu!';
$lng['error']['login_blocked'] = 'Tento úèet byl zablokován z dùvodu pøíliš velkého mnoství chyb pøi pøihlášení. <br />Prosím zkuste to znovu za ' . $settings['login']['deactivatetime'] . ' sekund.';
$lng['error']['notallreqfieldsorerrors'] = 'Nevyplnili jste všechna políèka nebo jsou nìkteré vyplnìna špatnì.';
$lng['error']['oldpasswordnotcorrect'] = 'Staré heslo není správné.';
$lng['error']['youcantallocatemorethanyouhave'] = 'Nemùete alokovat více zdrojù ne sami vlastníte';
$lng['error']['mustbeurl'] = 'Vloili jste nesprávnou nebo nekompletní url (napø. http://somedomain.com/error404.htm)';
$lng['error']['invalidpath'] = 'Nevybrali jste správnou url (moná problém s "dirlistingem"?)';
$lng['error']['stringisempty'] = 'Chybìjící vstup v poli';
$lng['error']['stringiswrong'] = 'Špatnı vstup v poli';
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
$lng['error']['loginnameexists'] = 'Pøihlašovací jméno %s ji existuje';
$lng['error']['emailiswrong'] = 'Emailová adresa %s obsahuje nepovolené znaky nebo je nekompletní';
$lng['error']['loginnameiswrong'] = 'Pøihlašovací jméno %s obsahuje nepovolené znaky';
$lng['error']['userpathcombinationdupe'] = 'Kombinace Uivatelského jména a cesty ji existuje';
$lng['error']['patherror'] = 'Obecná chyba! Cesta nemùe bıt prázdná';
$lng['error']['errordocpathdupe'] = 'Monost pro cestu %s ji existuje';
$lng['error']['adduserfirst'] = 'Vytvoøte prosím nejdøíve zákazníka';
$lng['error']['domainalreadyexists'] = 'Doména %s je ji pøiøazena k zákazníkovi';
$lng['error']['nolanguageselect'] = 'Nebyl vybrán ádnı jazyk.';
$lng['error']['nosubjectcreate'] = 'Musíte definovat téma pro tuto e-mailovou šablonu.';
$lng['error']['nomailbodycreate'] = 'Musíte definovat text e-mailu pro tuto e-mailovou šablonu.';
$lng['error']['templatenotfound'] = 'Šablona nebyla nalezena.';
$lng['error']['alltemplatesdefined'] = 'Nemùete definovat více šablon, všechny jazyky jsou ji podporovány.';
$lng['error']['wwwnotallowed'] = 'www není povoleno pro subdomény.';
$lng['error']['subdomainiswrong'] = 'Subdoména %s obsahuje neplatné znaky.';
$lng['error']['domaincantbeempty'] = 'Jméno domény nesmí bıt prázdné.';
$lng['error']['domainexistalready'] = 'Doména %s ji existuje.';
$lng['error']['domainisaliasorothercustomer'] = 'Vybranı alias pro doménu je buï sama aliasem domény nebo patøí jinému zákazníkovi.';
$lng['error']['emailexistalready'] = 'E-mailová adresa %s ji existuje.';
$lng['error']['maindomainnonexist'] = 'Hlavní doména %s neexistuje.';
$lng['error']['destinationnonexist'] = 'Prosím vytvoøte pøeposílatele v poli \'Cíl\'.';
$lng['error']['destinationalreadyexistasmail'] = 'Pøeposílaè na %s ji existuje jako aktivní emailová adresa.';
$lng['error']['destinationalreadyexist'] = 'U jste nastavili pøeposílaè na %s .';
$lng['error']['destinationiswrong'] = 'Pøeposílaè %s obsahuje nesprávné znaky nebo není kompletní.';
$lng['error']['domainname'] = $lng['domains']['domainname'];

/**
 * Questions
 */

$lng['question']['question'] = 'Bezpeènostní otázka';
$lng['question']['admin_customer_reallydelete'] = 'Chcete opravdu smazat uivatele %s? Akci nelze vzít zpìt!';
$lng['question']['admin_domain_reallydelete'] = 'Chcete opravdu smazat doménu %s?';
$lng['question']['admin_domain_reallydisablesecuritysetting'] = 'Chcete opravdu deaktivovat tato Bezpeènostní nastavení (OpenBasedir a/nebo SafeMode)?';
$lng['question']['admin_admin_reallydelete'] = 'Chcete opravdu smazat administrátory %s? Kadı zákazník a doména bude nastavena k Vašemu úètu.';
$lng['question']['admin_template_reallydelete'] = 'Chcete opravdu smazat šablonu \'%s\'?';
$lng['question']['domains_reallydelete'] = 'Chcete opravdu smazat doménu %s?';
$lng['question']['email_reallydelete'] = 'Opravdu chcete smazat e-mailovou adresu %s?';
$lng['question']['email_reallydelete_account'] = 'Chcete opravdu smazat e-mailovı úèet %s?';
$lng['question']['email_reallydelete_forwarder'] = 'Chcete opravdu smazat pøeposílaè %s?';
$lng['question']['extras_reallydelete'] = 'Chcete opravdu odstranit ochranu adresáøe %s?';
$lng['question']['extras_reallydelete_pathoptions'] = 'Opravdu chcete smazat nastavení cesty pro %s?';
$lng['question']['ftp_reallydelete'] = 'Opravdu chcete smazat FTP úèet %s?';
$lng['question']['mysql_reallydelete'] = 'Opravdu chcete smazat databázi %s? Tato akce nemùe bıt vzata zpìt!';
$lng['question']['admin_configs_reallyrebuild'] = 'Opravdu chcete rebuildovat apache a nabindovat konfiguraèní soubory?';

/**
 * Mails
 */

$lng['mails']['pop_success']['mailbody'] = 'Dobrı den,\n\nVáš e-mailovı úèet {EMAIL}\nbyl v poøádku nastaven.\n\nToto je automaticky vytvoøenı\ne-mail, prosím neodpovídejte na nìj!\n\nPøejeme hezkı den, Froxlor-Team';
$lng['mails']['pop_success']['subject'] = 'Poštovní úèet byl úspìšnì nastaven';
$lng['mails']['createcustomer']['mailbody'] = 'Dobrı den, {FIRSTNAME} {NAME},\n\nzde jsou informace o Vašem úètu:\n\nUivatel: {USERNAME}\nHeslo: {PASSWORD}\n\nDìkujeme,\nFroxlor-Team';
$lng['mails']['createcustomer']['subject'] = 'Informace o úètu';

/**
 * Admin
 */

$lng['admin']['overview'] = 'Pøehled';
$lng['admin']['ressourcedetails'] = 'Pouité zdroje';
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
$lng['admin']['customers_see_all'] = 'Mùe vidìt všechy zákazníky?';
$lng['admin']['domains_see_all'] = 'Mùe vidìt všechny domény?';
$lng['admin']['change_serversettings'] = 'Mùe mìnit nastavení serveru?';
$lng['admin']['server'] = 'Server';
$lng['admin']['serversettings'] = 'Nastavení';
$lng['admin']['rebuildconf'] = 'Pøebudovat konfiguraèní soubory';
$lng['admin']['stdsubdomain'] = 'Standardní subdoména';
$lng['admin']['stdsubdomain_add'] = 'Vytvoøit standardní subdoménu';
$lng['admin']['phpenabled'] = 'PHP zapnuto';
$lng['admin']['deactivated'] = 'Deaktivováno';
$lng['admin']['deactivated_user'] = 'Deaktivovat uivatele';
$lng['admin']['sendpassword'] = 'Zaslat heslo';
$lng['admin']['ownvhostsettings'] = 'Vlastní vHost-nastavení';
$lng['admin']['configfiles']['serverconfiguration'] = 'Konfigurace';
$lng['admin']['configfiles']['files'] = '<b>Konfiguraèní soubory:</b> Prosím zmìòte následující soubory nabo je vytvoøte s<br /> následujícím obsahem, pokud neexistují.<br /><b>Poznámka:</b> MySQL heslo nebylo nahrazeno z bezpeènostních dùvodù.<br />Prosím nahraïte &quot;MYSQL_PASSWORD&quot; svım vlastním. Pokud jste zapomnìli své mysql heslo<br />najdete jej v &quot;lib/userdata.inc.php&quot;.';
$lng['admin']['configfiles']['commands'] = '<b>Pøíkazy:</b> Prosím spuste následující pøíkazy v pøíkazovém øádku.';
$lng['admin']['configfiles']['restart'] = '<b>Restart:</b> Prosím spuste nísledující pøíkazy v pøíkazovém øádku, aby jste nahráli novou konfiguraci.';
$lng['admin']['templates']['templates'] = 'Šablony';
$lng['admin']['templates']['template_add'] = 'Pøidat šablonu';
$lng['admin']['templates']['template_edit'] = 'Upravit šablonu';
$lng['admin']['templates']['action'] = 'Akce';
$lng['admin']['templates']['email'] = 'E-Mail';
$lng['admin']['templates']['subject'] = 'Pøedmìt';
$lng['admin']['templates']['mailbody'] = 'Tìlo mailu';
$lng['admin']['templates']['createcustomer'] = 'Uvítací mail pro nové zákazníky';
$lng['admin']['templates']['pop_success'] = 'Uvítací mail pro nové emailové úèty';
$lng['admin']['templates']['template_replace_vars'] = 'Promìnné k nahrazení v šablonì:';
$lng['admin']['templates']['FIRSTNAME'] = 'Nahrazeno køestním jménem zákazníka.';
$lng['admin']['templates']['NAME'] = 'Nahrazeno jménem zákazníka.';
$lng['admin']['templates']['USERNAME'] = 'Nahrazeno uivatelskım jménem zákazníka.';
$lng['admin']['templates']['PASSWORD'] = 'Nahrazeno zákazníkovım heslem.';
$lng['admin']['templates']['EMAIL'] = 'Nahrazeno adresou POP3/IMAP úètu.';

/**
 * Serversettings
 */

$lng['serversettings']['session_timeout']['title'] = 'Session Timeout';
$lng['serversettings']['session_timeout']['description'] = 'Jak dlouho musı bıt uivatel neaktivní, ne session vyprší (sekundy)?';
$lng['serversettings']['accountprefix']['title'] = 'Zákazníkova pøedpona';
$lng['serversettings']['accountprefix']['description'] = 'Jké pøedpony by mìly mít úèty zákazníkù?';
$lng['serversettings']['mysqlprefix']['title'] = 'SQL pøedpona';
$lng['serversettings']['mysqlprefix']['description'] = 'Jaké pøedpony by mìly mít úèty mysql?';
$lng['serversettings']['ftpprefix']['title'] = 'FTP pøedpona';
$lng['serversettings']['ftpprefix']['description'] = 'Jakou pøedponu by mìly mít ftp úèty?';
$lng['serversettings']['documentroot_prefix']['title'] = 'Domácí adresáø';
$lng['serversettings']['documentroot_prefix']['description'] = 'Kde by mìly bıt uloeny všechny domácí adresáøe?';
$lng['serversettings']['logfiles_directory']['title'] = 'Adresáø pro log soubory';
$lng['serversettings']['logfiles_directory']['description'] = 'Kde by mìly bıt všechny log soubory uloeny?';
$lng['serversettings']['ipaddress']['title'] = 'IP-Adresa';
$lng['serversettings']['ipaddress']['description'] = 'Jaká je IP adresa tohoto serveru?';
$lng['serversettings']['hostname']['title'] = 'Jméno hosta';
$lng['serversettings']['hostname']['description'] = 'Jaké je jméno hosta tohoto serveru?';
$lng['serversettings']['apachereload_command']['title'] = 'Pøíkaz pro reload apache';
$lng['serversettings']['apachereload_command']['description'] = 'Jakı je pøíkaz, kterım apache znovunahraje své konfiguraèní soubory?';
$lng['serversettings']['bindconf_directory']['title'] = 'Bindujte konfiguraèní adresáø';
$lng['serversettings']['bindconf_directory']['description'] = 'Kde by mìly bıt uloeny "bind configfiles"?';
$lng['serversettings']['bindreload_command']['title'] = 'Bind reload pøíkaz';
$lng['serversettings']['bindreload_command']['description'] = 'Jakı je pøíkaz pro znovunahrání "bind configfiles"?';
$lng['serversettings']['binddefaultzone']['title'] = 'Bind vıchozí zóna';
$lng['serversettings']['binddefaultzone']['description'] = 'Jakı je název vıchozí zóny?';
$lng['serversettings']['vmail_uid']['title'] = 'UID-mailù';
$lng['serversettings']['vmail_uid']['description'] = 'Jaké UserID by mìly e-maily mít?';
$lng['serversettings']['vmail_gid']['title'] = 'GID-mailù';
$lng['serversettings']['vmail_gid']['description'] = 'Jaké GroupID by mìly maily mít?';
$lng['serversettings']['vmail_homedir']['title'] = 'Mails-Home adresáø';
$lng['serversettings']['vmail_homedir']['description'] = 'Kam by se mìly všechny maily ukládat?';
$lng['serversettings']['adminmail']['title'] = 'Odesílatel';
$lng['serversettings']['adminmail']['description'] = 'Jaká je odesílatelova adresa pro emaily odeslané z Panelu?';
$lng['serversettings']['phpmyadmin_url']['title'] = 'phpMyAdminova URL';
$lng['serversettings']['phpmyadmin_url']['description'] = 'Jaká je URL adresa phpMyAdmin? (musí zaèínat http(s)://)';
$lng['serversettings']['webmail_url']['title'] = 'WebMailová URL';
$lng['serversettings']['webmail_url']['description'] = 'Jaká je URL adresa k WebMailu? (musí zaèínat with http(s)://)';
$lng['serversettings']['webftp_url']['title'] = 'WebFTP URL';
$lng['serversettings']['webftp_url']['description'] = 'Jaká je URL k WebFTP? (musí zaèínat with http(s)://)';
$lng['serversettings']['language']['description'] = 'Jakı je vıchozí jazyk Vašeho serveru?';
$lng['serversettings']['maxloginattempts']['title'] = 'Maximální poèet pokusù o pøihlášení';
$lng['serversettings']['maxloginattempts']['description'] = 'Maximální poèet pokusù o pøihlášení k úètu, ne se úèet zablokuje.';
$lng['serversettings']['deactivatetime']['title'] = 'Deaktivovanı po dobu';
$lng['serversettings']['deactivatetime']['description'] = 'Èas (sek.) po kterı bude úèet deaktivován pro pøíliš mnoho pokusù o pøihlášení.';
$lng['serversettings']['pathedit']['title'] = 'Typ vstupu cesty';
$lng['serversettings']['pathedit']['description'] = 'Mìla by bıt cesta vybírána pomocí vyskakovacího menu nebo vstupním polem?';
$lng['serversettings']['nameservers']['title'] = 'Nameservery';
$lng['serversettings']['nameservers']['description'] = 'Støedníkem oddìlenı seznam obsahující hostname všech nameserverù. První bude primární.';
$lng['serversettings']['mxservers']['title'] = 'MX servery';
$lng['serversettings']['mxservers']['description'] = 'Støedníkem oddìlenı seznam obsahující páry èísel a hostname oddìlenıch mezerou (napø. \'10 mx.example.com\') obsahující mx servery.';

/**
 * CHANGED BETWEEN 1.2.12 and 1.2.13
 */

$lng['mysql']['description'] = 'Zde mùete vytváøet a mìnit své MySQL-Databáze.<br />Zmìny jsou provedeny okamitì a databáze mùe bıt okamitì pouívána.<br />V menu vlevo mùete najít nástroj phpMyAdmin se kterım mùete jednoduše upravovat svou databázi.<br /><br />Pro pouití databáze ve svıch php skriptech pouijte následující nastavení: (Data <i>kurzívou</i> musí bıt zmìnìna na Vámi vloené hodnoty!)<br />Host: <b><SQL_HOST></b><br />Uivatelské jméno: <b><i>Databasename</i></b><br />Heslo: <b><i>heslo které jste zvolili</i></b><br />Databáze: <b><i>Databasename</i></b>';

/**
 * ADDED BETWEEN 1.2.12 and 1.2.13
 */

$lng['admin']['cronlastrun'] = 'Poslední generování konfiguraèních souborù';
$lng['serversettings']['paging']['title'] = 'Záznamù na stránku';
$lng['serversettings']['paging']['description'] = 'Kolik záznamù by mìlo bıt zobrazeno na stránce? (0 = zrušit stránkování)';
$lng['error']['ipstillhasdomains'] = 'IP/Port kombinace, kterou chcete smazat má stále pøiøazené domény, prosím pøeøaïte je k jiné IP/Port kombinaci ne smaete tuto IP/Port kombinaci.';
$lng['error']['cantdeletedefaultip'] = 'Nemùete smazat IP/Port kombinaci vıchozího pøeprodejce, prosím vytvoøte jinou IP/Port kombinaci vıchozí pro pøeprodejce ne smaete tuto IP/Port kombinaci.';
$lng['error']['cantdeletesystemip'] = 'Nemùete smazat poslední systémovou IP, buï vytvoøte novou IP/Port kombinaci pro systémovou IP nebo zmìòte IP systému.';
$lng['error']['myipaddress'] = '\'IP\'';
$lng['error']['myport'] = '\'Port\'';
$lng['error']['myipdefault'] = 'Musíte vybrat IP/Port kombinaci která by se mìla stát vıchozí.';
$lng['error']['myipnotdouble'] = 'Tato kombinace IP/Portu ji existuje.';
$lng['question']['admin_ip_reallydelete'] = 'Chcete opravdu smayat IP adresu %s?';
$lng['admin']['ipsandports']['ipsandports'] = 'IP a Porty';
$lng['admin']['ipsandports']['add'] = 'Pøidat IP/Port';
$lng['admin']['ipsandports']['edit'] = 'Upravit IP/Port';
$lng['admin']['ipsandports']['ipandport'] = 'IP/Port';
$lng['admin']['ipsandports']['ip'] = 'IP';
$lng['admin']['ipsandports']['port'] = 'Port';

// ADDED IN 1.2.13-rc3

$lng['error']['cantchangesystemip'] = 'Nemùete zmìnit poslední systémovou IP, buï vytvoøte novou IP/Port kombinaci pro systémovou IP nebo zmìòte IP systému.';
$lng['question']['admin_domain_reallydocrootoutofcustomerroot'] = 'Jste si jisti, e chcete aby root dokumentù pro tuto doménu nebyl v "customerroot" zákazníka?';

// ADDED IN 1.2.14-rc1

$lng['admin']['memorylimitdisabled'] = 'Zakázáno';
$lng['domain']['openbasedirpath'] = 'OpenBasedir-cesta';
$lng['domain']['docroot'] = 'Cesta z políèka nahoøe';
$lng['domain']['homedir'] = 'Domovní adresáø';
$lng['admin']['valuemandatory'] = 'Tato hodnota je povinná';
$lng['admin']['valuemandatorycompany'] = 'Buï &quot;jméno&quot; a &quot;køestní jméno&quot; nebo &quot;spoleènost&quot; musí bıt vyplnìna';
$lng['menue']['main']['username'] = 'Pøihlášen(a) jako: ';
$lng['panel']['urloverridespath'] = 'URL (pøepíše cestu)';
$lng['panel']['pathorurl'] = 'Cesta nebo URL';
$lng['error']['sessiontimeoutiswrong'] = 'Pouze èíselné &quot;Session Timeout&quot; je povoleno.';
$lng['error']['maxloginattemptsiswrong'] = 'ouze èíselné &quot;Maximální poèet pokusù o pøihlášení&quot; je povoleno.';
$lng['error']['deactivatetimiswrong'] = 'ouze èíselné &quot;Èas deaktivace&quot; je povoleno.';
$lng['error']['accountprefixiswrong'] = '&quot;Pøedpona uivatele&quot; je špatnì.';
$lng['error']['mysqlprefixiswrong'] = '&quot;SQL pøedpona&quot; je špatnì.';
$lng['error']['ftpprefixiswrong'] = '&quot;FTP pøedpona&quot; je špatnì.';
$lng['error']['ipiswrong'] = '&quot;IP-Adresa&quot; je špatnì. Pouze validní IP adresa je povolena.';
$lng['error']['vmailuidiswrong'] = '&quot;Mails-uid&quot; je špatnì. Je povoleno pouze èíselné UID.';
$lng['error']['vmailgidiswrong'] = '&quot;Mails-gid&quot; je špatnì. Je povoleno pouze èíselné GID.';
$lng['error']['adminmailiswrong'] = '&quot;Sender-address&quot; je špatnì. Je povolena pouze validní emailová adresa.';
$lng['error']['pagingiswrong'] = '&quot;Entries per Page&quot;-value je špatnì. Jsou povolena pouze èísla.';
$lng['error']['phpmyadminiswrong'] = 'phpMyAdmin-url naní správná url.';
$lng['error']['webmailiswrong'] = 'WebMail-odkaz není správnı odkaz.';
$lng['error']['webftpiswrong'] = 'WebFTP-odkaz není správnı odkaz.';
$lng['domains']['hasaliasdomains'] = 'Má aliasové domény';
$lng['serversettings']['defaultip']['title'] = 'Vıchozí IP/Port';
$lng['serversettings']['defaultip']['description'] = 'Jaká je vıchozí IP/Port kombinace?';
$lng['domains']['statstics'] = 'Statistika pouití';
$lng['panel']['ascending'] = 'sestupnì';
$lng['panel']['decending'] = 'vzestupnì';
$lng['panel']['search'] = 'Vyhledávání';
$lng['panel']['used'] = 'pouito';

// ADDED IN 1.2.14-rc3

$lng['panel']['translator'] = 'Pøekladatel';

// ADDED IN 1.2.14-rc4

$lng['error']['stringformaterror'] = 'Hodnota pole &quot;%s&quot; není v oèekávaném formátu.';

// ADDED IN 1.2.15-rc1

$lng['admin']['serversoftware'] = 'Software serveru';
$lng['admin']['phpversion'] = 'PHP-Verze';
$lng['admin']['phpmemorylimit'] = 'PHP-Limit-Pamìti';
$lng['admin']['mysqlserverversion'] = 'MySQL verze serveru';
$lng['admin']['mysqlclientversion'] = 'MySQL verze klienta';
$lng['admin']['webserverinterface'] = 'Webserver rozhraní';
$lng['domains']['isassigneddomain'] = 'Je pøiøazená doména';
$lng['serversettings']['phpappendopenbasedir']['title'] = 'Cesty k pøidání k OpenBasedir';
$lng['serversettings']['phpappendopenbasedir']['description'] = 'Tyto cesty (oddìleny pomocí "colons") budou vloeny  do OpenBasedir-statementu v kadém vhost-containeru.';

// CHANGED IN 1.2.15-rc1

$lng['error']['loginnameissystemaccount'] = 'Nemùete vytvoøit úèty, které jsou podobné systémovım úètùm (napøíklad zaèínají &quot;%s&quot;). Prosím vlote jiné jméno úètu.';
$lng['error']['youcantdeleteyourself'] = 'Z bezpeènostních dùvodù se nemùete smazat.';
$lng['error']['youcanteditallfieldsofyourself'] = 'Poznámka: Z bezpeènostních dùvodù nemùete upravovat všechna pole svého úètu.';

// ADDED IN 1.2.16-svn1

$lng['serversettings']['natsorting']['title'] = 'Pouít "lidské" tøídìní v seznamech';
$lng['serversettings']['natsorting']['description'] = 'Øadit seznamy jako web1 -> web2 -> web11 místo web1 -> web11 -> web2.';

// ADDED IN 1.2.16-svn2

$lng['serversettings']['deactivateddocroot']['title'] = 'Docroot pro deaktivované uivatele';
$lng['serversettings']['deactivateddocroot']['description'] = 'Kdy bude uivatel deaktivován, tato cesta bude pouita jako jeho docroot. Ponechte prázdné, pokud nechcete vytváøet.';

// ADDED IN 1.2.16-svn4

$lng['panel']['reset'] = 'zrušit zmìny';
$lng['admin']['accountsettings'] = 'Nastavení úètu';
$lng['admin']['panelsettings'] = 'Nastavení panelu';
$lng['admin']['systemsettings'] = 'Nastavení systému';
$lng['admin']['webserversettings'] = 'Nastavení webserveru';
$lng['admin']['mailserversettings'] = 'Nastavení mailserveru';
$lng['admin']['nameserversettings'] = 'Nastavení nameserveru';
$lng['admin']['updatecounters'] = 'Pøepoèítat vyuití zdrojù';
$lng['question']['admin_counters_reallyupdate'] = 'Opravdu chcete pøepoèítat vyuití zdrojù?';
$lng['panel']['pathDescription'] = 'Pokud adresáø neexistuje, bude vytvoøen automaticky.';

// ADDED IN 1.2.16-svn6

$lng['mails']['trafficninetypercent']['mailbody'] = 'Váenı uivateli {NAME},\n\nPouil jste {TRAFFICUSED} MB z Vámi dostupnıch {TRAFFIC} MB pøenosù.\nTo je více jak 90%.\n\nPøejeme hezkı den, Froxlor-Team';
$lng['mails']['trafficninetypercent']['subject'] = 'Dosahujíc vašeho limitu pøenosù';
$lng['admin']['templates']['trafficninetypercent'] = 'Upozoròovací mail pro zákazníky, pokud vyèerpají 90% z pøenosù';
$lng['admin']['templates']['TRAFFIC'] = 'Nahrazeno pøenosy, které byly pøidìleny uivateli.';
$lng['admin']['templates']['TRAFFICUSED'] = 'Nahrazeno pøenosy, které byly vyèerpány zákazníkem.';

// ADDED IN 1.2.16-svn7

$lng['admin']['subcanemaildomain']['never'] = 'Nikdy';
$lng['admin']['subcanemaildomain']['choosableno'] = 'Vıbìr, vıchozí ne';
$lng['admin']['subcanemaildomain']['choosableyes'] = 'Vıbìr, vıchozí ano';
$lng['admin']['subcanemaildomain']['always'] = 'Vdy';
$lng['changepassword']['also_change_webalizer'] = ' také zmìòte heslo pro webalizer statistics';

// ADDED IN 1.2.16-svn8

$lng['serversettings']['mailpwcleartext']['title'] = 'Také ulote hesla mailovıch úètù nešifrovaná v databázi';
$lng['serversettings']['mailpwcleartext']['description'] = 'Pokud je toto nastaveno na "ano", všechna hesla budou ukládána bez šifrování (èístı text, èitelná pro kohokoliv s pøístupem k databázi) v tabulce mail_users. Toto aktivujte jen pokud to opravdu potøebujete!';
$lng['serversettings']['mailpwcleartext']['removelink'] = 'Kliknutím zde vymaete všechna nezašifrovaná hesla z tabulky.';
$lng['question']['admin_cleartextmailpws_reallywipe'] = 'Opravdu chcete vymazat všechna nezašifrovaná hesla pro e-mailové úèty z tabulky mail_users? Tento krok nelze vrátit zpìt!';
$lng['admin']['configfiles']['overview'] = 'Pøehled';
$lng['admin']['configfiles']['wizard'] = 'Prùvodce';
$lng['admin']['configfiles']['distribution'] = 'Distribuce';
$lng['admin']['configfiles']['service'] = 'Sluba';
$lng['admin']['configfiles']['daemon'] = 'Daemon';
$lng['admin']['configfiles']['http'] = 'Webserver (HTTP)';
$lng['admin']['configfiles']['dns'] = 'Nameserver (DNS)';
$lng['admin']['configfiles']['mail'] = 'Mailserver (IMAP/POP3)';
$lng['admin']['configfiles']['smtp'] = 'Mailserver (SMTP)';
$lng['admin']['configfiles']['ftp'] = 'FTP-Server';
$lng['admin']['configfiles']['etc'] = 'Ostatní (System)';
$lng['admin']['configfiles']['choosedistribution'] = '-- Vyberte distribuci --';
$lng['admin']['configfiles']['chooseservice'] = '-- Vyberte slubu --';
$lng['admin']['configfiles']['choosedaemon'] = '-- Vyberte daemona --';
$lng['admin']['trafficlastrun'] = 'Poslední kalkulace pøenosù';

// ADDED IN 1.2.16-svn10

$lng['serversettings']['ftpdomain']['title'] = 'FTP úèty na doménì';
$lng['serversettings']['ftpdomain']['description'] = 'Zákazníci mohou vytváøet FTP úèty user@customerdomain?';
$lng['panel']['back'] = 'Back';

// ADDED IN 1.2.16-svn12

$lng['serversettings']['mod_log_sql']['title'] = 'Doèasnì ukládat logy do databáze';
$lng['serversettings']['mod_log_sql']['description'] = 'Pouít <a href="http://www.outoforder.cc/projects/apache/mod_log_sql/" title="mod_log_sql">mod_log_sql</a> pro doèasné uloení webrequestù<br /><b>Toto vyaduje speciální <a href="http://files.syscp.org/docs/mod_log_sql/" title="mod_log_sql - documentation">konfiguraci apache</a>!</b>';
$lng['serversettings']['mod_fcgid']['title'] = 'Includuj PHP pøes mod_fcgid/suexec';
$lng['serversettings']['mod_fcgid']['description'] = 'Pouij mod_fcgid/suexec/libnss_mysql pro bìh PHP s odpovídajícím úøivatelskım úètem.<br/><b>toto vyaduje speciální konfiguraci apache!</b>';
$lng['serversettings']['sendalternativemail']['title'] = 'Pouij alternativní e-mailovou adresu';
$lng['serversettings']['sendalternativemail']['description'] = 'Pošli email s heslem na jinou adresu pøi vytváøení emailového úètu';
$lng['emails']['alternative_emailaddress'] = 'Alternativní e-mailová adresa';
$lng['mails']['pop_success_alternative']['mailbody'] = 'Váenı uivateli,\n\nVáš emailovı úèet {EMAIL}\nbyl úspìšnì nastaven.\nVaše heslo je {PASSWORD}.\n\nTento e-mail byl automaticky vygenerován,\nprosím neodpovídejte na nìj!\n\nPøejeme Vám hezkı den, Froxlor-Team';
$lng['mails']['pop_success_alternative']['subject'] = 'E-mailovı úèet byl úspìšnì vytvoøen';
$lng['admin']['templates']['pop_success_alternative'] = 'Uvítací e-mail pro nové úèty byl odeslán na alternativní adresu';
$lng['admin']['templates']['EMAIL_PASSWORD'] = 'Nahrazeno heslem úètu POP3/IMAP.';

// ADDED IN 1.2.16-svn13

$lng['error']['documentrootexists'] = 'Adresáø &quot;%s&quot; ji existuje pro tohoto zákazníka. Prosím odstraòte jej, ne budete znovu zákazníka vkládat.';

// ADDED IN 1.2.16-svn14

$lng['serversettings']['apacheconf_vhost']['title'] = 'Apache vhost konfiguraèní soubor/dirname';
$lng['serversettings']['apacheconf_vhost']['description'] = 'Kde by mìla bıt uloena konfigurace vhosta? Mùete zde buï specifikovat soubor (všichni vhosti v jednom souboru) nebo adresáø (kadı vhost má vlastní soubor).';
$lng['serversettings']['apacheconf_diroptions']['title'] = 'Apache diroptions konfiguraèní soubor/dirname';
$lng['serversettings']['apacheconf_diroptions']['description'] = 'Kde by mìla bıt uloena konfigurace diroptions?  Mùete zde buï specifikovat soubor (všichni diroptions v jednom souboru) nebo adresáø (kadı diroption má vlastní soubor).';
$lng['serversettings']['apacheconf_htpasswddir']['title'] = 'Apache htpasswd dirname';
$lng['serversettings']['apacheconf_htpasswddir']['description'] = 'Kde by mìly bıt uloeny htpasswd soubory pro ochranu adresáøù?';

// ADDED IN 1.2.16-svn15

$lng['error']['formtokencompromised'] = 'The request seems to be compromised. Z bezpeènostních dùvodù jste byli odhlášeni.';
$lng['serversettings']['mysql_access_host']['title'] = 'MySQL-Access-Hosts';
$lng['serversettings']['mysql_access_host']['description'] = 'Støedníkem oddìlenı seznam hostù, ze kterıch bude dovoleno uivatelùm se pøipojit k MySQL-Serveru.';

// ADDED IN 1.2.18-svn1

$lng['admin']['ipsandports']['create_listen_statement'] = 'Vytvoøit Listen statement';
$lng['admin']['ipsandports']['create_namevirtualhost_statement'] = 'Vytvoøit NameVirtualHost statement';
$lng['admin']['ipsandports']['create_vhostcontainer'] = 'Vytvoøit vHost-Container';
$lng['admin']['ipsandports']['create_vhostcontainer_servername_statement'] = 'Vytvoøit ServerName statement v vHost-Container';

// ADDED IN 1.2.18-svn2

$lng['admin']['webalizersettings'] = 'Nastavení Webalizeru';
$lng['admin']['webalizer']['normal'] = 'Normální';
$lng['admin']['webalizer']['quiet'] = 'Tichı';
$lng['admin']['webalizer']['veryquiet'] = 'ádnı vıstup';
$lng['serversettings']['webalizer_quiet']['title'] = 'Vıstup Webalizeru';
$lng['serversettings']['webalizer_quiet']['description'] = 'Povídavost webalizer-programu';

// ADDED IN 1.2.18-svn3

$lng['ticket']['admin_email'] = 'root@localhost';
$lng['ticket']['noreply_email'] = 'tikety@froxlor';
$lng['admin']['ticketsystem'] = 'Support-tikety';
$lng['menue']['ticket']['ticket'] = 'Support tikety';
$lng['menue']['ticket']['categories'] = 'Kategorie podpory';
$lng['menue']['ticket']['archive'] = 'Archiv-tiketù';
$lng['ticket']['description'] = 'Nastavit popis zde!';
$lng['ticket']['ticket_new'] = 'Otevøít novı tiket';
$lng['ticket']['ticket_reply'] = 'zodpovìdìt tiket';
$lng['ticket']['ticket_reopen'] = 'Znovuotevøít tiket';
$lng['ticket']['ticket_newcateory'] = 'Vytvoøit novou kategorii';
$lng['ticket']['ticket_editcateory'] = 'Upravit kategorii';
$lng['ticket']['ticket_view'] = 'Zobrazit ticketcourse';
$lng['ticket']['ticketcount'] = 'Tikety';
$lng['ticket']['ticket_answers'] = 'Odpovìdi';
$lng['ticket']['lastchange'] = 'Poslední akce';
$lng['ticket']['subject'] = 'Pøedmìt';
$lng['ticket']['status'] = 'Status';
$lng['ticket']['lastreplier'] = 'Poslední odpovídající';
$lng['ticket']['priority'] = 'Priorita';
$lng['ticket']['low'] = '<span class="ticket_low">Nízká</span>';
$lng['ticket']['normal'] = '<span class="ticket_normal">Normální</span>';
$lng['ticket']['high'] = '<span class="ticket_high">Vysoká</span>';
$lng['ticket']['unf_low'] = 'Nízká';
$lng['ticket']['unf_normal'] = 'Normální';
$lng['ticket']['unf_high'] = 'Vysoká';
$lng['ticket']['lastchange'] = 'Poslední zmìna';
$lng['ticket']['lastchange_from'] = 'Od data (dd.mm.yyyy)';
$lng['ticket']['lastchange_to'] = 'Do data (dd.mm.yyyy)';
$lng['ticket']['category'] = 'Kategorie';
$lng['ticket']['no_cat'] = 'ádná';
$lng['ticket']['message'] = 'Zpráva';
$lng['ticket']['show'] = 'Zobraz';
$lng['ticket']['answer'] = 'Odpovìï';
$lng['ticket']['close'] = 'Zavøít';
$lng['ticket']['reopen'] = 'Znovuotevøít';
$lng['ticket']['archive'] = 'Archiv';
$lng['ticket']['ticket_delete'] = 'Smazat tiket';
$lng['ticket']['lastarchived'] = 'Nedávno archivované tikety';
$lng['ticket']['archivedtime'] = 'Archivováno';
$lng['ticket']['open'] = 'Otevøít';
$lng['ticket']['wait_reply'] = 'Èeká na odpovìï';
$lng['ticket']['replied'] = 'Odpovìzeno';
$lng['ticket']['closed'] = 'Zavøenı';
$lng['ticket']['staff'] = 'Personál';
$lng['ticket']['customer'] = 'Zákazník';
$lng['ticket']['old_tickets'] = 'Tiket zprávy';
$lng['ticket']['search'] = 'Prohledat archiv';
$lng['ticket']['nocustomer'] = 'ádnı vıbìr';
$lng['ticket']['archivesearch'] = 'Vısledky prohledávání archivu';
$lng['ticket']['noresults'] = 'Nenalezeny ádné tikety';
$lng['ticket']['notmorethanxopentickets'] = 'Kvùli ochranì proti SPAMu nemùete mít otevøeno víc jak %s tiketù';
$lng['ticket']['supportstatus'] = 'Status-podpory';
$lng['ticket']['supportavailable'] = '<span class="ticket_low">Naše podpora jsou k dispozici a pøipraveni pomoci.</span>';
$lng['ticket']['supportnotavailable'] = '<span class="ticket_high">Naše podpora není momentálnì dostupná</span>';
$lng['admin']['templates']['ticket'] = 'Upozoròovací e-maily pro tikety podpory';
$lng['admin']['templates']['SUBJECT'] = 'Nahrazeno pøedmìtem tiketu podpory';
$lng['admin']['templates']['new_ticket_for_customer'] = 'Zákaznické upozornìní, e byl tiket odeslán';
$lng['admin']['templates']['new_ticket_by_customer'] = 'Administrátorské upozornìní, e byl tiket otevøen zákazníkem';
$lng['admin']['templates']['new_reply_ticket_by_customer'] = 'Administrátorské upozornìní, e pøišla odpovìï na tiket od zákazníka';
$lng['admin']['templates']['new_ticket_by_staff'] = 'Zákaznické upozornìní, e byl tiket otevøen personálem';
$lng['admin']['templates']['new_reply_ticket_by_staff'] = 'Zákaznické upozornìní na odpovìï na tiket od personálu';
$lng['mails']['new_ticket_for_customer']['mailbody'] = 'Váenı uivateli {FIRSTNAME} {NAME},\n\nVáš tiket podpory s pøedmìtem "{SUBJECT}" byl odeslán.\n\nA pøijde odpovìï na Váš tiket, budete upozornìni.\n\nDìkujeme,\n Froxlor-Team';
$lng['mails']['new_ticket_for_customer']['subject'] = 'Váš tiket na podporu byl odeslán';
$lng['mails']['new_ticket_by_customer']['mailbody'] = 'Milı administrátore,\n\nbyl odeslán novı tiket s pøedmìtem "{SUBJECT}".\n\nProsím pøihlašte se pro otevøení tiketu.\n\nDìkujeme,\n Froxlor-Team';
$lng['mails']['new_ticket_by_customer']['subject'] = 'Novı tiket podpory byl odeslán';
$lng['mails']['new_reply_ticket_by_customer']['mailbody'] = 'Milı administrátore,\n\ntiket podpory "{SUBJECT}" byl zodpovìzen zákazníkem.\n\nProsím pøihlašte se pro otevøení tiketu.\n\nDìkujeme,\n Froxlor-Team';
$lng['mails']['new_reply_ticket_by_customer']['subject'] = 'Nová odpovìï na tiket podpory';
$lng['mails']['new_ticket_by_staff']['mailbody'] = 'Váenı uivateli {FIRSTNAME} {NAME},\n\nbyl pro Vás otevøen tiket podpory s pøedmìtem "{SUBJECT}".\n\nProsím pøihlašte se pro otevøení tiketu.\n\nDìkujeme,\n Froxlor-Team';
$lng['mails']['new_ticket_by_staff']['subject'] = 'Novı tiket podpory byl odeslán';
$lng['mails']['new_reply_ticket_by_staff']['mailbody'] = 'Váenı uivateli {FIRSTNAME} {NAME},\n\ntiket podpory s pøedmìtem "{SUBJECT}" byl zodpovìzen naším personálem.\n\nPro pøeètení tiketu se prosím pøihlašte.\n\nDìkujem,\n Froxlor-Team';
$lng['mails']['new_reply_ticket_by_staff']['subject'] = 'Nová odpovìï na tiket podpory';
$lng['question']['ticket_reallyclose'] = 'Opravdu chcete zavøít tiket "%s"?';
$lng['question']['ticket_reallydelete'] = 'Opravdu chcete smazat tiket "%s"?';
$lng['question']['ticket_reallydeletecat'] = 'Opravdu chcete smazat kategorii "%s"?';
$lng['question']['ticket_reallyarchive'] = 'Opravdu chcete pøesunout tiket "%s" do archivu?';
$lng['error']['mysubject'] = '\'' . $lng['ticket']['subject'] . '\'';
$lng['error']['mymessage'] = '\'' . $lng['ticket']['message'] . '\'';
$lng['error']['mycategory'] = '\'' . $lng['ticket']['category'] . '\'';
$lng['error']['nomoreticketsavailable'] = 'Pouili jste všechny dostupné tikety. Prosím kontaktujte svého administrátora.';
$lng['error']['nocustomerforticket'] = 'Nemohu vytváøet tikety bez zákazníkù';
$lng['error']['categoryhastickets'] = 'Kategorie stále obsahuje tikety.<br />Prosím smate tikety aby jste mohli smazat kategorii';
$lng['error']['notmorethanxopentickets'] = $lng['ticket']['notmorethanxopentickets'];
$lng['admin']['ticketsettings'] = 'Tikety-podpory nastavení';
$lng['admin']['archivelastrun'] = 'Poslední archivace tiketù';
$lng['serversettings']['ticket']['noreply_email']['title'] = 'Bez odpovìdní e-mailová adresa';
$lng['serversettings']['ticket']['noreply_email']['description'] = 'Odesílatelova adresa pro tikety podpory, vìtšinou nìco jako no-reply@domain.tld';
$lng['serversettings']['ticket']['worktime_begin']['title'] = 'Zaèátek práce podpory (hh:mm)';
$lng['serversettings']['ticket']['worktime_begin']['description'] = 'Start-time pokud je podpora k dispozici';
$lng['serversettings']['ticket']['worktime_end']['title'] = 'Konec práce podpory (hh:mm)';
$lng['serversettings']['ticket']['worktime_end']['description'] = 'End-time pokud je podpora k dispozici';
$lng['serversettings']['ticket']['worktime_sat'] = 'Je podpora k dispozici o sobotách?';
$lng['serversettings']['ticket']['worktime_sun'] = 'Je podpora k dispozici o nedìlích?';
$lng['serversettings']['ticket']['worktime_all']['title'] = 'Podpora bez èasového omezení';
$lng['serversettings']['ticket']['worktime_all']['description'] = 'Pokud "Ano" monosti zaèátku a konce práce podpory bude pøepsána';
$lng['serversettings']['ticket']['archiving_days'] = 'Po kolika dnech by mìly bıt uzavøené tikety archivovány?';
$lng['customer']['tickets'] = 'Tikety podpory';

// ADDED IN 1.2.18-svn4

$lng['admin']['domain_nocustomeraddingavailable'] = 'Momentálnì není moné pøidat doménu. Nejdøíve musíte pøidat aspoò jednoho zákazníka.';
$lng['serversettings']['ticket']['enable'] = 'Zapnout systém tiketù';
$lng['serversettings']['ticket']['concurrentlyopen'] = 'Kolik tiketù by mìlo bıt k dispozici najednou?';
$lng['error']['norepymailiswrong'] = '&quot;Bezodpovìdní adresa&quot; je špatnì. Je povolena pouze validní e-mailová adresa.';
$lng['error']['tadminmailiswrong'] = '&quot;Ticketadmin-adresa&quot; je špatnì. Je povolena pouze validní e-mailová adresa.';
$lng['ticket']['awaitingticketreply'] = 'Máte %s nezodpovìzenıch tiketù podpory';

// ADDED IN 1.2.18-svn5

$lng['serversettings']['ticket']['noreply_name'] = 'Jméno odesílatele tiketù v emailu';

?>
