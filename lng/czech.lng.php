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
 * @author     Florian Lippert <flo@syscp.org>
 * @author     Froxlor Team <team@froxlor.org>
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Language
 *
 */

/**
 * Global
 */
$lng['translator'] = '';
$lng['panel']['edit'] = 'Upravit';
$lng['panel']['delete'] = 'Smazat';
$lng['panel']['create'] = 'Vytvořit';
$lng['panel']['save'] = 'Uložit';
$lng['panel']['yes'] = 'Ano';
$lng['panel']['no'] = 'Ne';
$lng['panel']['path'] = 'Cesta';
$lng['panel']['toggle'] = 'Toggle';
$lng['panel']['next'] = 'Další';
$lng['panel']['dirsmissing'] = 'Nemůžu najít nebo přečíst adresář!';

/**
 * Login
 */

$lng['login']['username'] = 'Uživatelské jméno';
$lng['login']['password'] = 'Heslo';
$lng['login']['language'] = 'Jazyk';
$lng['login']['login'] = 'Přihlásit se';
$lng['login']['logout'] = 'Odhlásit se';
$lng['login']['profile_lng'] = 'Jazyk profilu';

/**
 * Customer
 */

$lng['customer']['documentroot'] = 'Domovský adresář';
$lng['customer']['name'] = 'Název';
$lng['customer']['firstname'] = 'Křestní jméno';
$lng['customer']['company'] = 'Společnost';
$lng['customer']['street'] = 'Ulice';
$lng['customer']['zipcode'] = 'PSČ';
$lng['customer']['city'] = 'Město';
$lng['customer']['phone'] = 'Telefon';
$lng['customer']['fax'] = 'Fax';
$lng['customer']['email'] = 'Email';
$lng['customer']['customernumber'] = 'ID Zákazníka';
$lng['customer']['diskspace'] = 'Webový prostor (MiB)';
$lng['customer']['traffic'] = 'Provoz (GiB)';
$lng['customer']['mysqls'] = 'MySQL-databáze';
$lng['customer']['emails'] = 'Email-adresy';
$lng['customer']['accounts'] = 'Email-účty';
$lng['customer']['forwarders'] = 'Email-forwarders';
$lng['customer']['ftps'] = 'FTP-účty';
$lng['customer']['subdomains'] = 'Subdomény';
$lng['customer']['domains'] = 'Domény';

/**
 * Customermenue
 */

$lng['menue']['main']['main'] = 'Hlavní';
$lng['menue']['main']['changepassword'] = 'Změnit heslo';
$lng['menue']['main']['changelanguage'] = 'Změnit jazyk';
$lng['menue']['email']['email'] = 'Email';
$lng['menue']['email']['emails'] = 'Adresy';
$lng['menue']['email']['webmail'] = 'Webmail';
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
$lng['menue']['extras']['pathoptions'] = 'Možnosti cesty';

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
$lng['changepassword']['new_password_confirm'] = 'Potvrdit heslo';
$lng['changepassword']['new_password_ifnotempty'] = 'Nové heslo (prázdné = beze změny)';
$lng['changepassword']['also_change_ftp'] = ' také změní heslo hlavního FTP účtu';

/**
 * Domains
 */

$lng['domains']['description'] = 'Zde můžeš vytvořit a upravit (sub-)domémny a změnit jejich cesty.<br />Systém bude chtít nějaký čas pro aplikování nového nastavení po každé změně.';
$lng['domains']['domainsettings'] = 'Nastavení domény';
$lng['domains']['domainname'] = 'Název domény';
$lng['domains']['subdomain_add'] = 'Vytvořit subdoménu';
$lng['domains']['subdomain_edit'] = 'Upravit (sub)doménu';
$lng['domains']['wildcarddomain'] = 'Vytvořit jako wildcarddoménu?';
$lng['domains']['aliasdomain'] = 'Alias pro doménu';
$lng['domains']['noaliasdomain'] = 'Doména bez aliasu';

/**
 * E-mails
 */

$lng['emails']['description'] = 'Zde můžeš vytvořit a upravit tvé emailové adresy.<br />Účet je jako poštovní schránka před tvým domem. Pokud ti někdo odešle email, přijde ti do tvého účtu.<br /><br />Pro stažení tvých emailů použij následující nastavení v tvém emailovém klientovi: (Data v <i>italském fontu</i> na ekvivalenty, které jsi vepsal/a!)<br />Název hostitele: <b><i>názevdomény</i></b><br />Uživatel: <b><i>název účtu / emailová addresa</i></b><br />heslo: <b><i>heslo, které jsi si zvolil/a</i></b>';
$lng['emails']['emailaddress'] = 'Emailová adresa';
$lng['emails']['emails_add'] = 'Vytvořit emailové adresy';
$lng['emails']['emails_edit'] = 'Upravit emailovou adresu';
$lng['emails']['catchall'] = 'Catchall';
$lng['emails']['iscatchall'] = 'Definovat jako catchall-adresu?';
$lng['emails']['account'] = 'Účet';
$lng['emails']['account_add'] = 'Vytvořit účet';
$lng['emails']['account_delete'] = 'Smazat účet';
$lng['emails']['from'] = 'Zdroj';
$lng['emails']['to'] = 'Cíl';
$lng['emails']['forwarders'] = 'Forwarders';
$lng['emails']['forwarder_add'] = 'Vytvořit forwarder';

/**
 * FTP
 */

$lng['ftp']['description'] = 'Zde můžeš tvořit a upravovat tvé FTP-účty.<br />Změny jsou uskutečněny okamžitě a účty mohou být použity ihned.';
$lng['ftp']['account_add'] = 'Vytvořit účet';

/**
 * MySQL
 */

$lng['mysql']['databasename'] = 'Název uživetele/databáze';
$lng['mysql']['databasedescription'] = 'Popis databáze';
$lng['mysql']['database_create'] = 'Vytvořit databázi';

/**
 * Extras
 */

$lng['extras']['description'] = 'Zde můžeš přidat dodatečné věci, např. ochranu odresáře.<br />Systém bude potřebovat nějaký čas pro aplikování změn.';
$lng['extras']['directoryprotection_add'] = 'Přidat ocrhanu adresáře';
$lng['extras']['view_directory'] = 'Zobrazit obsah adresáře';
$lng['extras']['pathoptions_add'] = 'Přidat možnosti cesty';
$lng['extras']['directory_browsing'] = 'Procházení obsahu adresáře';
$lng['extras']['pathoptions_edit'] = 'Upravit možnosti cesty';

/**
 * Errors
 */

$lng['error']['error'] = 'Chyba';
$lng['error']['directorymustexist'] = 'Adresář %s musí existovat. Vytvoř jej prosím v FTP klientovi.';
$lng['error']['filemustexist'] = 'Soubor %s musí existovat.';
$lng['error']['allresourcesused'] = 'Již jsi využil všechny svoje zdroje.';
$lng['error']['domains_cantdeletemaindomain'] = 'Nemůžeš smazat doménu, která je využívána pro emailovou doménu.';
$lng['error']['domains_canteditdomain'] = 'Tuto doménu nemůžeš měnit. Administrátor tuto možnost vypnul.';
$lng['error']['domains_cantdeletedomainwithemail'] = 'Nemůžeš smazat doménu, která je využívána pro emailovou doménu. Nejříve smaž všechny emailové adresy.';
$lng['error']['firstdeleteallsubdomains'] = 'Nejdříve musíš smazat všechny subdomény, než vytvoříš wildcard doménu.';
$lng['error']['youhavealreadyacatchallforthisdomain'] = 'Již jsi definoval catchall pro tuto doménu.';
$lng['error']['ftp_cantdeletemainaccount'] = 'Nemůžeš smazat svůj hlavní FTP účet';
$lng['error']['login'] = 'Zadané uživatelské jméno nebo heslo je špatné. Zkus to prosím za chvíli!';
$lng['error']['login_blocked'] = 'Tento účet byl zablokován po příliš mnoho selhaných pokusech o přihlášení. <br />Zkus to znovu za %s sekund.';
$lng['error']['notallreqfieldsorerrors'] = 'Nic jsi nevyplnil nebo jsi vyplnil některé kolonky špatně.';
$lng['error']['oldpasswordnotcorrect'] = 'Staré heslo není správné.';
$lng['error']['youcantallocatemorethanyouhave'] = 'Nemůžeš přiřadit více prostředků, než vlastníš.';
$lng['error']['mustbeurl'] = 'Nenapsal jsi správnou nebo kompletí odkaz (např. http://somedomain.com/error404.htm)';
$lng['error']['invalidpath'] = 'Nevybral jsi správný odkaz (možná se jedná o problém s dirlisting?)';
$lng['error']['stringisempty'] = 'Chybějící vstup v poli';
$lng['error']['stringiswrong'] = 'Špatný vstup v poli';
$lng['error']['newpasswordconfirmerror'] = 'Nové heslo a jeho potvrzení neodpovídá';
$lng['error']['mydomain'] = '\'Doména\'';
$lng['error']['mydocumentroot'] = '\'Documentroot\'';
$lng['error']['loginnameexists'] = 'Přihlašovací jméno %s již existuje';
$lng['error']['emailiswrong'] = 'Email. adresa %s neplatné znaky nebo není kompletní';
$lng['error']['alternativeemailiswrong'] = 'Zadaná alternativní email. adresa %s k odeslání údajů se zdá být neplatná';
$lng['error']['loginnameiswrong'] = 'Přihlašovací jméno "%s" obsahuje nepovolené znaky.';
$lng['error']['loginnameiswrong2'] = 'Přihlašovací jméno obsahuje příliš mnoho znaků. Jen %s znaky jsou povoleny.';
$lng['error']['userpathcombinationdupe'] = 'Kombinace přihlašovacího jména a cesty již existuje';
$lng['error']['patherror'] = 'Obecná chyba! Cesta nesmí být prázdná';
$lng['error']['errordocpathdupe'] = 'Možnost u cesty %s již existuje';
$lng['error']['adduserfirst'] = 'Nejdřív vytvoř zákazníka, prosím';
$lng['error']['domainalreadyexists'] = 'Doména %s je již přiřazena k zákazníkovi';
$lng['error']['nolanguageselect'] = 'Není vybrán žádný jazyk.';
$lng['error']['nosubjectcreate'] = 'Musíš definovat téma k této emailové šabloně.';
$lng['error']['nomailbodycreate'] = 'Musíš definovat text emailu pro tuto emailovou šablonu.';
$lng['error']['templatenotfound'] = 'Šablona nebyla nalezena.';
$lng['error']['alltemplatesdefined'] = 'Nemůžeš nadefinovat více šablon, všechny jazyky jsou již podporovány.';
$lng['error']['wwwnotallowed'] = 'www není povolena pro subdomény.';
$lng['error']['subdomainiswrong'] = 'Subdoména %s nemůže obsahovat neplatné znaky.';
$lng['error']['domaincantbeempty'] = 'Název domény nemůže být prázdná.';
$lng['error']['domainexistalready'] = 'Doména %s již existuje.';
$lng['error']['emailexistalready'] = 'Emailová adresa %s již existuje.';
$lng['error']['maindomainnonexist'] = 'Hlavní doména %s neexistuje.';

/**
 * Questions
 */

$lng['question']['question'] = 'Bezpečnostní otázka';
$lng['question']['admin_customer_reallydelete'] = 'Opravdu chceš smazat zákazníka %s? Tuto akci nelze vrátit zpět!';
$lng['question']['admin_domain_reallydelete'] = 'Opravdu chceš smazat doménu %s?';
$lng['question']['mysql_reallydelete'] = 'Opravdu chceš smazat databázi %s? Tento krok je nevratný!';
$lng['question']['admin_customer_alsoremovefiles'] = 'Smazat i soubory uživatelů?';

/**
 * Mails
 */

$lng['mails']['pop_success']['subject'] = 'Emailový účet nastaven úspěšně';
$lng['mails']['createcustomer']['subject'] = 'Informace o účtu';

/**
 * Admin
 */

$lng['admin']['overview'] = 'Přehled';
$lng['admin']['ressourcedetails'] = 'Využité zdroje';
$lng['admin']['systemdetails'] = 'Detaily systému';
$lng['admin']['froxlordetails'] = 'Froxlor detaily';
$lng['admin']['installedversion'] = 'Nainstalovaná verze';
$lng['admin']['latestversion'] = 'Poslední verze';
$lng['admin']['lookfornewversion']['clickhere'] = 'Hledat pomocí webové služby';
$lng['admin']['lookfornewversion']['error'] = 'Chyba při čtení';
$lng['admin']['resources'] = 'Zdroje';
$lng['admin']['customer'] = 'Zákazník';
$lng['admin']['customers'] = 'Zákazníci';
$lng['admin']['customer_add'] = 'Vytvořit zákazníka';
$lng['admin']['customer_edit'] = 'Upravit zákazníka';
$lng['admin']['domains'] = 'Domény';
$lng['admin']['domain_add'] = 'Vytvořit doménu';
$lng['admin']['domain_edit'] = 'Upravit doménu';
$lng['admin']['subdomainforemail'] = 'Subdomény jako emailové domény';
$lng['admin']['admin'] = 'Admin';
$lng['admin']['admins'] = 'Admini';
$lng['admin']['admin_add'] = 'Vytvořit admina';
$lng['admin']['admin_edit'] = 'Upravit admina';
$lng['admin']['customers_see_all'] = 'Může vidět všechny zákazníky?';
$lng['admin']['domains_see_all'] = 'Může vidět všechny domény?';
$lng['admin']['change_serversettings'] = 'Může vidět nastavení serveru?';
$lng['admin']['server'] = 'Systém';
$lng['admin']['serversettings'] = 'Nastavení';
$lng['admin']['rebuildconf'] = 'Znovu setstavit konfigurační soubory';
$lng['admin']['stdsubdomain'] = 'Standartní subdoména';
$lng['admin']['stdsubdomain_add'] = 'Vytvořit standartní subdoménu';
$lng['admin']['phpenabled'] = 'PHP povoleno';
$lng['admin']['deactivated'] = 'Deaktivováno';
$lng['admin']['deactivated_user'] = 'Deaktivovat uživatele';
$lng['admin']['sendpassword'] = 'Odeslat heslo';
$lng['admin']['ownvhostsettings'] = 'Vlastní vHost-nastavení';
$lng['admin']['configfiles']['serverconfiguration'] = 'Konfigurace';
$lng['admin']['templates']['templates'] = 'Email-šablony';
$lng['admin']['templates']['template_add'] = 'Přidat šablonu';
$lng['admin']['templates']['template_edit'] = 'Upravit šablonu';
$lng['admin']['templates']['action'] = 'Akce';
$lng['admin']['templates']['email'] = 'Email & šablony souborů';
$lng['admin']['templates']['subject'] = 'Předmět';
$lng['admin']['templates']['mailbody'] = 'Tělo emailu';
$lng['admin']['templates']['createcustomer'] = 'Uvítací email pro nové zákazníky';
$lng['admin']['templates']['pop_success'] = 'Uvítací email pro nově založene emaily';
$lng['admin']['templates']['template_replace_vars'] = 'Variables to be replaced in the template:';
$lng['admin']['templates']['SALUTATION'] = 'Replaced with a correct salutation (name or company)';
$lng['admin']['templates']['FIRSTNAME'] = 'Replaced with the customer\'s first name.';
$lng['admin']['templates']['NAME'] = 'Nahrazeno jménem zákazníka.';
$lng['admin']['templates']['COMPANY'] = 'Replaces with the customer\'s company name';
$lng['admin']['templates']['USERNAME'] = 'Replaced with the customer\'s account username.';
$lng['admin']['templates']['PASSWORD'] = 'Replaced with the customer\'s account password.';
$lng['admin']['templates']['EMAIL'] = 'Replaced with the address of the POP3/IMAP account.';
$lng['admin']['templates']['CUSTOMER_NO'] = 'Replaces with the customer number';
$lng['admin']['webserver'] = 'Webový server';

/**
 * Serversettings
 */

$lng['serversettings']['documentroot_prefix']['title'] = 'Domovský adresář';
$lng['serversettings']['bindreload_command']['title'] = 'Příkaz pro znovu načtení DNS serveru';
$lng['serversettings']['bindreload_command']['description'] = 'Jaký je příkaz pro znovu načtení dns serveru?';
$lng['serversettings']['vmail_uid']['description'] = 'Jaké uživatelsk=e ID by měly emaily mít?';
$lng['serversettings']['vmail_gid']['description'] = 'Jaké skupinové ID by měly emaily mít?';
$lng['serversettings']['vmail_homedir']['title'] = 'Domovská složka pro emaily';
$lng['serversettings']['vmail_homedir']['description'] = 'Kde by všechny emaily měly být uloženy?';
$lng['serversettings']['adminmail']['title'] = 'Odesílatel';
$lng['serversettings']['adminmail']['description'] = 'Jaká je adresa odesílatele na emaily odeslané z panelu?';
$lng['serversettings']['phpmyadmin_url']['description'] = 'Jaké je URL do phpMyAdmin? (musí začínat with http(s)://)';
$lng['serversettings']['webmail_url']['title'] = 'Webový mail URL';
$lng['serversettings']['webmail_url']['description'] = 'Jaké je URL do webového mailu? (musí začínath http(s)://)';
$lng['serversettings']['webftp_url']['description'] = 'Jaké je URL do WebFTP? (musí začínat http(s)://)';
$lng['serversettings']['language']['description'] = 'Jaký je tvůj standartní jazyk serveru?';
$lng['serversettings']['maxloginattempts']['title'] = 'Max. pokusů o přihlášení';
$lng['serversettings']['maxloginattempts']['description'] = 'Maximum pokusů o přihlášení do deaktivace účtu.';
$lng['serversettings']['deactivatetime']['title'] = 'Čas deaktivace';
$lng['serversettings']['deactivatetime']['description'] = 'Čas (v sek.) po kterých se účet deaktivuje po několika neúspěšných pokusech o přihlášení.';
$lng['serversettings']['pathedit']['title'] = 'Typ obsahu cesty';
$lng['serversettings']['pathedit']['description'] = 'Měla by cesta být na výběr z rozbalovací nabídky nebo jen zadána do textového pole?';
$lng['serversettings']['nameservers']['title'] = 'Názvy serverů';
$lng['serversettings']['nameservers']['description'] = 'Seznam oddělený čárkami obsahující názvy hostitelů všech jmenných serverů. První bude primární.';
$lng['serversettings']['mxservers']['title'] = 'MX servery';
$lng['serversettings']['mxservers']['description'] = 'Seznam oddělený čárkami obsahující dvojici čísla a jméno hostitele oddělené mezerou (např. \'10 mx.example.com\') obsahující servery mx.';

/**
 * ADDED BETWEEN 1.2.12 and 1.2.13
 */

$lng['error']['myipnotdouble'] = 'Tato IP/Port kombinace již existuje.';
$lng['question']['admin_ip_reallydelete'] = 'Opravdu chceš odebrat IP adresu %s?';
$lng['admin']['ipsandports']['add'] = 'Přidat IP/Port';
$lng['admin']['ipsandports']['edit'] = 'Upravit IP/Port';

// ADDED IN 1.2.14-rc1

$lng['admin']['memorylimitdisabled'] = 'Vypnuto';
$lng['domain']['openbasedirpath'] = 'OpenBasedir-cesta';
$lng['domain']['docroot'] = 'Path from field above';
$lng['domain']['homedir'] = 'Domovský adresář';
$lng['admin']['valuemandatory'] = 'Tato hodnota je důležitá';
$lng['menue']['main']['username'] = 'Přihlášen/a jako: ';
$lng['panel']['pathorurl'] = 'Cesta nebo URL';
$lng['serversettings']['defaultip']['title'] = 'Výchozí IP/Port';
$lng['serversettings']['defaultsslip']['title'] = 'Výchozí SSL IP/Port';
$lng['domains']['statstics'] = 'Statistiky využití';
$lng['panel']['ascending'] = 'vzestupně';
$lng['panel']['descending'] = 'sestupně';
$lng['panel']['search'] = 'Hledat';
$lng['panel']['used'] = 'použito';

// ADDED IN 1.2.14-rc3

$lng['panel']['translator'] = 'Překladač';

// ADDED IN 1.2.14-rc4

$lng['error']['stringformaterror'] = 'Hodnota pro pole "%s" není v očekávaném formátu.';

// ADDED IN 1.2.15-rc1

$lng['admin']['serversoftware'] = 'Serversoftware';
$lng['admin']['phpversion'] = 'PHP-Verze';
$lng['admin']['mysqlserverversion'] = 'MySQL verze serveru';
$lng['admin']['webserverinterface'] = 'Rozhraní webového serveru';
$lng['domains']['isassigneddomain'] = 'Je přiřazenou doménou';

// CHANGED IN 1.2.15-rc1

$lng['error']['youcantdeleteyourself'] = 'Z bezpečnostních důvodů nemůžeš smazat sám sebe.';
$lng['error']['youcanteditallfieldsofyourself'] = 'POZNÁMKA: Nemůžeš upravit všechna pole tvého vlastního účtu kvůli bezpečnosti.';


// ADDED IN 1.2.16-svn2

$lng['serversettings']['deactivateddocroot']['title'] = 'Docroot pro deaktivované uživatele';

// ADDED IN 1.2.16-svn4

$lng['panel']['reset'] = 'Zahodit změny';
$lng['admin']['accountsettings'] = 'Nastavení účtu';
$lng['admin']['panelsettings'] = 'Nastavení panelu';
$lng['admin']['systemsettings'] = 'Nastavení systému';
$lng['admin']['webserversettings'] = 'Nastavení webového serveru';
$lng['admin']['mailserversettings'] = 'Nastavení mailového serveru';
$lng['admin']['nameserversettings'] = 'Nameserver settings';
$lng['admin']['updatecounters'] = 'Přepočítat využití zdrojů';
$lng['question']['admin_counters_reallyupdate'] = 'Opravdu chceš přepočítat využití zdrojů?';
$lng['panel']['pathDescription'] = 'Pokud adresář neexistuje, bude automaticky vytvořen.';

// ADDED IN 1.2.16-svn7

$lng['admin']['subcanemaildomain']['never'] = 'Nikdy';
$lng['admin']['subcanemaildomain']['choosableno'] = 'Volitelné, výchozí ne';
$lng['admin']['subcanemaildomain']['choosableyes'] = 'Volitelné, výchozí ano';
$lng['admin']['subcanemaildomain']['always'] = 'Vždy';
$lng['changepassword']['also_change_stats'] = ' také změní heslo na stránku k statistikám';

// ADDED IN 1.2.16-svn8

$lng['serversettings']['mailpwcleartext']['title'] = 'Také ukládat hesla emailů nezašifrované v databázi';
$lng['admin']['configfiles']['overview'] = 'Přehled';
$lng['admin']['configfiles']['wizard'] = 'Průvodce';
$lng['admin']['configfiles']['distribution'] = 'Distribuce';
$lng['admin']['configfiles']['service'] = 'Služba';
$lng['admin']['configfiles']['etc'] = 'Ostatní (System)';
$lng['admin']['configfiles']['choosedistribution'] = '-- Vyber distribuci --';
$lng['admin']['configfiles']['chooseservice'] = '-- Vyber službu --';

// ADDED IN 1.2.16-svn10

$lng['serversettings']['ftpdomain']['title'] = 'FTP účty @domain';
$lng['serversettings']['ftpdomain']['description'] = 'Zákazníci mohou vytvářet FTP účty user@customerdomain?';
$lng['panel']['back'] = 'Zpět';

// ADDED IN 1.2.16-svn12

$lng['serversettings']['mod_fcgid']['title'] = 'Povolit FCGID';
$lng['emails']['alternative_emailaddress'] = 'Alternativní emailová adresa';
$lng['admin']['templates']['EMAIL_PASSWORD'] = 'Nahrazeno POP3/IMAP heslem účtu.';

// ADDED IN 1.2.16-svn13

$lng['error']['documentrootexists'] = 'Adresář "%s" pro tohoto zázaníka již existuje. Odeber to před znovu přidáním tohoto zákazníka.';

// ADDED IN 1.2.18-svn2

$lng['admin']['webalizersettings'] = 'Webalizer nastavení';
$lng['admin']['webalizer']['normal'] = 'Normální';
$lng['admin']['webalizer']['quiet'] = 'Tiché';
$lng['admin']['webalizer']['veryquiet'] = 'Bez výstupu';
$lng['serversettings']['webalizer_quiet']['title'] = 'Webalizer výstup';
$lng['serversettings']['webalizer_quiet']['description'] = 'Verbosity of the webalizer-program';

// ADDED IN 1.2.18-svn4

$lng['admin']['domain_nocustomeraddingavailable'] = 'Momentálně není možné přidat doménu. Nejdříve musíš přidat alespoň jednoho zákazníka.';

// ADDED IN 1.2.19-svn1

$lng['serversettings']['mod_fcgid']['configdir']['title'] = 'Konfigurace adresářů';
$lng['serversettings']['mod_fcgid']['configdir']['description'] = 'Kde by fcgid-konfigurační soubory měly být uloženy? Pokud nepoužíváš vlastně kompilovanou suexec knihovnu, tak tato cesta musí být pod /var/www/<br /><br /><div class="text-danger">POZNÁMKA: Obsah této složky se pravidělně promazává, takže se vyhýbej manuálnímu uklání dat zde.</div>';
$lng['serversettings']['mod_fcgid']['tmpdir']['title'] = 'Dočasný adresář';

// ADDED IN 1.2.19-svn4

$lng['menue']['traffic']['traffic'] = 'Provoz';
$lng['menue']['traffic']['current'] = 'Momentální měsíc';
$lng['traffic']['month'] = "Měsíc";
$lng['traffic']['day'] = "Den";
$lng['traffic']['months'][1] = "Leden";
$lng['traffic']['months'][2] = "Únor";
$lng['traffic']['months'][3] = "Březen";
$lng['traffic']['months'][4] = "Duben";
$lng['traffic']['months'][5] = "Květen";
$lng['traffic']['months'][6] = "Červen";
$lng['traffic']['months'][7] = "Červenec";
$lng['traffic']['months'][8] = "Srpen";
$lng['traffic']['months'][9] = "Září";
$lng['traffic']['months'][10] = "Říjen";
$lng['traffic']['months'][11] = "Listopad";
$lng['traffic']['months'][12] = "Prosinec";
$lng['traffic']['mb'] = "Provoz (MiB)";
$lng['traffic']['sumhttp'] = 'Celkový HTTP-Provoz';
$lng['traffic']['sumftp'] = 'Celkový FTP-Provoz';
$lng['traffic']['summail'] = 'Celkový Mail-Provoz';

// ADDED IN 1.2.19-svn6

$lng['admin']['loggersettings'] = 'Log nastavení';
$lng['serversettings']['logger']['enable'] = 'Logging zapnuto/vypnuto';
$lng['serversettings']['logger']['severity'] = 'Logging úroveň';
$lng['admin']['logger']['normal'] = 'normální';
$lng['admin']['logger']['paranoid'] = 'paranoidní';
$lng['error']['logerror'] = 'Log-Chyba: %s';
$lng['serversettings']['logger']['logcronoption']['never'] = 'Nikdy';
$lng['serversettings']['logger']['logcronoption']['once'] = 'Jednou';
$lng['serversettings']['logger']['logcronoption']['always'] = 'Vždy';
$lng['admin']['loggersystem'] = 'Systémový log';
$lng['logger']['date'] = 'Datum';
$lng['logger']['type'] = 'Typ';
$lng['logger']['action'] = 'Akce';
$lng['logger']['user'] = 'Uživatel';
$lng['logger']['truncate'] = 'Prázdný log';

// ADDED IN 1.2.19-svn7

$lng['serversettings']['ssl']['use_ssl']['title'] = 'Povolit SSL využití';
$lng['serversettings']['ssl']['use_ssl']['description'] = 'Tohle zaškrtni, pokud chceš používat SSL pro tvůj webový server';
$lng['serversettings']['ssl']['ssl_cert_file']['title'] = 'Cesta k SSL certifikátu';
$lng['serversettings']['ssl']['ssl_cert_file']['description'] = 'Specifikujte cestu k souboru obsahující v názvu .crt nebo .pem koncovku (hlavní certifikát)';
$lng['serversettings']['ssl']['openssl_cnf'] = 'Výchozí nastavení pro tvorbu Cert souboru';
$lng['panel']['reseller'] = 'prodejce';
$lng['panel']['admin'] = 'admin';
$lng['panel']['customer'] = 'zákazník/ci';
$lng['error']['nomessagetosend'] = 'Nezadal/a jsi zprávu.';
$lng['error']['norecipientsgiven'] = 'Nespecifikoval/a jsi žádného příjemce';
$lng['admin']['emaildomain'] = 'Emailová doména';
$lng['admin']['email_only'] = 'Jen email?';
$lng['admin']['wwwserveralias'] = 'Přidat "www." ServerAlias';
$lng['admin']['ipsandports']['enable_ssl'] = 'Je tohle SSL port?';
$lng['admin']['ipsandports']['ssl_cert_file'] = 'Cesta k SSL certifikátu';
$lng['panel']['send'] = 'odeslat';
$lng['admin']['subject'] = 'Předmět';
$lng['admin']['recipient'] = 'Příjemce';
$lng['admin']['message'] = 'Napsat zprávu';
$lng['admin']['text'] = 'Zpráva';
$lng['menu']['message'] = 'Zprávy';
$lng['error']['errorsendingmail'] = 'Zpráva uživateli "%s" selhala';
$lng['error']['cannotreaddir'] = 'Nelze přečíst adresář "%s"';
$lng['success']['messages_success'] = 'Zpráva úspěšně odeslána %s příjemcům,';
$lng['message']['norecipients'] = 'Email nebyl odeslán, protože databáze neobsahuje žádné příjemce';
$lng['admin']['sslsettings'] = 'SSL nastavení';
$lng['cronjobs']['notyetrun'] = 'Ještě nespuštěno';
$lng['serversettings']['default_vhostconf']['title'] = 'Výchozí vHost-nastavení';
$lng['error']['invalidip'] = 'Neplatná IP adresa: %s';

// ADDED IN 1.2.19-svn8

$lng['admin']['dkimsettings'] = 'DomainKey nastavení';

// ADDED IN 1.2.19-svn9

$lng['admin']['caneditphpsettings'] = 'Může změnit doménové nastavení spojené s php?';

// ADDED IN 1.2.19-svn12

$lng['admin']['allips'] = 'Všechny IP';
$lng['panel']['nosslipsavailable'] = 'Momentálně zde nejsou žádné ssl ip/port kombinace pro tento server';
$lng['dkim']['use_dkim']['title'] = 'Aktivovat DKIM podporu?';
$lng['serversettings']['webalizer_enabled'] = 'Povolit webalizer statistiky';
$lng['serversettings']['awstats_enabled'] = 'Povolit AWstats statistiky';
$lng['admin']['awstatssettings'] = 'AWstats nastavení';

// ADDED IN 1.2.19-svn16

$lng['admin']['domain_dns_settings'] = 'DNS nastavení domény';
$lng['dns']['a_record'] = 'A-Záznam (IPv6 volitelný)';
$lng['dns']['cname_record'] = 'CNAME-Záznam';
$lng['dns']['mxrecords'] = 'Definovat MX záznamy';
$lng['dns']['standardmx'] = 'Server standard MX record';
$lng['dns']['mxconfig'] = 'Vlastní MX záznamy';
$lng['dns']['priority10'] = 'Priorita 10';
$lng['dns']['priority20'] = 'Priorita 20';
$lng['dns']['txtrecords'] = 'Definovat TXT záznamy';
$lng['serversettings']['selfdnscustomer']['title'] = 'Povolit zákazníkům upravovat dns nastavení domén';
$lng['admin']['activated'] = 'Aktivováno';
$lng['admin']['statisticsettings'] = 'Nastavení statistik';

// ADDED IN 1.2.19-svn17

$lng['serversettings']['unix_names']['title'] = 'Použít kompatibilní přezdívky s UNIX ';
$lng['error']['cannotwritetologfile'] = 'Nelze otevřít log soubor %s pro zápis';
$lng['admin']['sysload'] = 'Systémové zatížení';
$lng['admin']['noloadavailable'] = 'nedostupné';
$lng['admin']['nouptimeavailable'] = 'nedostupné';
$lng['panel']['backtooverview'] = 'Zpět na přehled';
$lng['admin']['nosubject'] = '(Bez předmětu)';
$lng['admin']['configfiles']['statistics'] = 'Statistics';
$lng['login']['forgotpwd'] = 'Zapomněl jsi heslo?';
$lng['login']['presend'] = 'Resetovat heslo';
$lng['login']['email'] = 'Emailová addresa';
$lng['login']['remind'] = 'Resetovat mé heslo';
$lng['login']['usernotfound'] = 'Uživatel nenalezen!';
$lng['mails']['password_reset']['subject'] = 'Resetovat heslo';
$lng['pwdreminder']['success'] = 'Žádost o reset hesla úspěšně odeslána. Následuj prosím instrukce v emailu, který jsi obdržel/a.';

// ADDED IN 1.2.19-svn18

$lng['serversettings']['allow_password_reset']['title'] = 'Povolit resetování hesla pro zákazníky';
$lng['pwdreminder']['notallowed'] = 'Resetování hesla je vypnuto';

// ADDED IN 1.2.19-svn21

$lng['customer']['title'] = 'Oslovení';
$lng['customer']['country'] = 'Země';
$lng['panel']['dateformat'] = 'RRRR-MM-DD';
$lng['panel']['dateformat_function'] = 'R-m-d';

// Y = Year, m = Month, d = Day

$lng['panel']['timeformat_function'] = 'H:i:s';

// H = Hour, i = Minute, s = Second

$lng['panel']['default'] = 'Výchozí';
$lng['panel']['never'] = 'Nikdy';
$lng['panel']['active'] = 'Aktivní';
$lng['panel']['please_choose'] = 'Zvol prosím';
$lng['panel']['allow_modifications'] = 'Povolit modifikace';
$lng['domains']['registration_date'] = 'Přidáno do registru';

// ADDED IN 1.2.19-svn22

$lng['serversettings']['allow_password_reset_admin']['title'] = 'Povolit reset hesla pro adminy';

// ADDED IN 1.2.19-svn25

$lng['emails']['quota'] = 'Kvóta';
$lng['emails']['noquota'] = 'Bez kvóty';
$lng['emails']['updatequota'] = 'Aktualizovat kvótu';
$lng['panel']['not_supported'] = 'Nepodporováno v: ';

// improved froxlor

$lng['menue']['phpsettings']['maintitle'] = 'PHP konfigurace';
$lng['admin']['phpsettings']['title'] = 'PHP konfigurace';
$lng['admin']['phpsettings']['description'] = 'Krátký popis';
$lng['admin']['phpsettings']['actions'] = 'Akce';
$lng['admin']['phpsettings']['editsettings'] = 'Změnit PHP nastavení';
$lng['admin']['phpsettings']['addsettings'] = 'Vytvořit nové PHP nastavení';
$lng['admin']['phpsettings']['viewsettings'] = 'Zobrazit PHP nastavení';
$lng['admin']['phpsettings']['phpinisettings'] = 'php.ini nastavení';
$lng['admin']['phpsettings']['addnew'] = 'Vytvořit novou PHP konfiguraci';
$lng['admin']['fpmsettings']['addnew'] = 'Vytvořit novou PHP verzi';
$lng['error']['phpsettingidwrong'] = 'Konfigurace s tímto ID neexistuje';
$lng['error']['descriptioninvalid'] = 'Popis je moc krátký, dlouhý nebo obsahuje nepovolené znaky.';

// improved Froxlor 2

$lng['admin']['templates']['filecontent'] = 'Öbsah souboru';
$lng['error']['filecontentnotset'] = 'Soubor nemůže být prázdný!';
$lng['admin']['expert_settings'] = 'Expertní nastavení!';

$lng['error']['customerdoesntexist'] = 'Zvolený zákazník neexistuje.';
$lng['error']['admindoesntexist'] = 'Zvolený administrátor neexistuje.';

// ADDED IN 1.2.19-svn37

$lng['domains']['aliasdomains'] = 'Alias domén';

// ADDED IN 1.2.19-svn38

$lng['admin']['phpserversettings'] = 'PHP nastavení';
$lng['admin']['phpsettings']['fpmdesc'] = 'PHP-FPM konfigurace';
$lng['admin']['phpsettings']['file_extensions'] = 'Přípony souborů';
$lng['admin']['phpsettings']['file_extensions_note'] = '(bez tečky, oddělené mezerou)';
$lng['admin']['mod_fcgid_maxrequests']['title'] = 'Maximum php žádostí pro tuto doménu (ponechte prázdné pro výchozí hodnotu)';
$lng['serversettings']['mod_fcgid']['maxrequests']['title'] = 'Maximum požadavků na doménu';
$lng['serversettings']['mod_fcgid']['maxrequests']['description'] = 'Kolik požadavků na doménu by mělo být povoleno?';

// ADDED IN 1.4.2.1-2

$lng['admin']['ipsandports']['webserverdefaultconfig'] = 'Výchozí konfigurace Webserveru';

$lng['success']['success'] = 'Informace';
$lng['success']['clickheretocontinue'] = 'Klikni zde pro pokračování';
$lng['success']['settingssaved'] = 'Nastavení bylo úspěšně uloženo.';

// ADDED IN FROXLOR 0.9.1

$lng['admin']['contactdata'] = 'Kontaktní data';

// ADDED IN FROXLOR 0.9.2

$lng['admin']['newerversionavailable'] = 'Nová verze Froxloru je dostupná';

// ADDED IN FROXLOR 0.9.3-svn1

$lng['serversettings']['panel_password_min_length']['title'] = 'Minimální délka hesla';

// ADDED IN FROXLOR 0.9.3-svn3
$lng['cron']['lastrun'] = 'naposledy spušteno';
$lng['cron']['isactive'] = 'povoleno';
$lng['cron']['description'] = 'popis';

// ADDED IN FROXLOR 0.9.4-svn1
$lng['ftp']['account_edit'] = 'Upravit ftp účet';
$lng['admin']['lastlogin_succ'] = 'Posledníí přihlášení';
$lng['panel']['neverloggedin'] = 'Zatím bez přihlášení';

// ADDED IN FROXLOR 0.9.6-svn6
$lng['admin']['ftpserversettings'] = 'Nastavení FTP serveru';

// ADDED IN FROXLOR 0.9.7-svn3

// these stay only in english.lng.php - they are the same
// for all other languages and are used if not found there
$lng['redirect_desc']['rc_movedperm'] = 'permanentně přesunuto';

// ADDED IN FROXLOR 0.9.11-svn2
$lng['extras']['execute_perl'] = 'Spustit perl/CGI';
$lng['admin']['perlenabled'] = 'Perl povolen';

// ADDED IN FROXLOR 0.9.11-svn3
$lng['serversettings']['perl_path']['title'] = 'Cesta k perl';
$lng['serversettings']['perl_path']['description'] = 'Výchozí je /usr/bin/perl';

// ADDED IN FROXLOR 0.9.12-svn3
$lng['domains']['nosubtomaindomain'] = 'Žádná subdoména celé domény';
$lng['admin']['templates']['newdatabase'] = 'Emailové notifikace o nových databázích';
$lng['admin']['templates']['newftpuser'] = 'Emailové notifikace o nových ftp uživatelů';
$lng['admin']['templates']['CUST_NAME'] = 'Jméno zákazníka';
$lng['admin']['templates']['DB_NAME'] = 'Název databáze';
$lng['admin']['templates']['DB_PASS'] = 'Heslo databáze';
$lng['admin']['templates']['DB_DESC'] = 'Popis databáze';
$lng['admin']['templates']['DB_SRV'] = 'Databázový server';
$lng['admin']['templates']['PMA_URI'] = 'Odkaz k phpMyAdmin (pokud je postytnut)';
$lng['admin']['templates']['USR_NAME'] = 'FTP uživatelské jméno';
$lng['admin']['templates']['USR_PASS'] = 'FTP heslo';

// ADDED IN FROXLOR 0.9.15
$lng['serversettings']['perl_server']['title'] = 'Perl umístění na serveru';

// ADDED IN FROXLOR 0.9.16
$lng['error']['intvaluetoolow'] = 'Zadané číslo je přiliš malé (pole %s)';
$lng['error']['intvaluetoohigh'] = 'Zadané číslo je příliš vysoké (pole %s)';
$lng['serversettings']['phpfpm']['title'] = 'Zapnout php-fpm';

// ADDED IN FROXLOR 0.9.18
$lng['serversettings']['default_theme'] = 'Výchozí téma';
$lng['menue']['main']['changetheme'] = 'Změnit téma';
$lng['panel']['theme'] = 'Téma';
$lng['panel']['variable'] = 'Variable';
$lng['panel']['description'] = 'Popis';
$lng['emails']['back_to_overview'] = 'Zpět na přehled';

// ADDED IN FROXLOR 0.9.20
$lng['customer']['generated_pwd'] = 'Navrhnutí hesla';
$lng['customer']['usedmax'] = 'Použito / Max';
$lng['admin']['traffic'] = 'Provoz';
$lng['admin']['domaintraffic'] = 'Domény';
$lng['admin']['customertraffic'] = 'Zákazníci';
$lng['traffic']['customer'] = 'Zákazník';
$lng['traffic']['domain'] = 'Doména';
$lng['traffic']['trafficoverview'] = 'Shrnutí provozu podle';
$lng['traffic']['months']['jan'] = 'Led';
$lng['traffic']['months']['feb'] = 'Úno';
$lng['traffic']['months']['mar'] = 'Bře';
$lng['traffic']['months']['apr'] = 'Dub';
$lng['traffic']['months']['may'] = 'Kvě';
$lng['traffic']['months']['jun'] = 'Čer';
$lng['traffic']['months']['jul'] = 'Čer';
$lng['traffic']['months']['aug'] = 'Srp';
$lng['traffic']['months']['sep'] = 'Zář';
$lng['traffic']['months']['oct'] = 'Říj';
$lng['traffic']['months']['nov'] = 'Lis';
$lng['traffic']['months']['dec'] = 'Pro';
$lng['traffic']['months']['total'] = 'Celkem';
$lng['traffic']['details'] = 'Detaily';
$lng['menue']['traffic']['table'] = 'Provoz';

// ADDED IN FROXLOR 0.9.21
$lng['gender']['title'] = 'Titul';
$lng['gender']['male'] = 'Pan.';
$lng['gender']['female'] = 'Paní.';
$lng['gender']['undef'] = '';

// ADDED IN FROXLOR 0.9.22-svn1
$lng['diskquota'] = 'Quota';
$lng['serversettings']['diskquota_enabled'] = 'Kvóta aktivována?';
$lng['tasks']['CREATE_QUOTA'] = 'Set quota on filesystem';
$lng['error']['session_timeout'] = 'Moc nízká hodnota';

// ADDED IN FROXLOR 0.9.24-svn1
$lng['admin']['assignedmax'] = 'Přiřazeno / Max';
$lng['admin']['usedmax'] = 'Použito / Max';
$lng['admin']['used'] = 'Použito';
$lng['mysql']['size'] = 'Velikost';

// ADDED IN 0.9.27-svn2
$lng['panel']['cancel'] = 'Zrušit';
$lng['admin']['delete_statistics'] = 'Promazat statistiky';

// ADDED IN 0.9.28-svn5
$lng['error']['operationnotpermitted'] = 'Operace nepovolena!';
$lng['error']['featureisdisabled'] = 'Funkce %s je vypnuta. Kontaktuj prosím providera.';

// ADDED IN 0.9.28.svn6
$lng['serversettings']['apache_24']['title'] = 'Použít modifikace pro Apache 2.4';

// Added in Froxlor 0.9.28-rc2

$lng['error']['usercurrentlydeactivated'] = 'Uživatel %s je momentálně deaktivován';
$lng['admin']['speciallogfile']['title'] = 'Oddělit log soubor';
$lng['admin']['domain_editable']['title'] = 'Povolit upravování domény';

// Added in Froxlor 0.9.29-dev
$lng['serversettings']['systemdefault'] = 'Základní systém. nastavení';
$lng['serversettings']['panel_allow_theme_change_admin'] = 'Povolit amdinům změnit téma';
$lng['panel']['ssleditor'] = 'SSL nastavené pro tuto doménu';

// Added in Froxlor 0.9.30
$lng['domains']['ipandport_ssl_multi']['title'] = 'SSL IP adresa(y)';
$lng['domains']['ssl_redirect']['title'] = 'SSL přesměrování';
$lng['domains']['serveraliasoption_none'] = 'Bez aliasu';

// Added in Froxlor 0.9.31
$lng['panel']['dashboard'] = 'Nástěnka';
$lng['panel']['assigned'] = 'Přiřazen';
$lng['panel']['available'] = 'Dostupný';
$lng['customer']['services'] = 'Služby';

// Added in Froxlor 0.9.32
$lng['logger']['admin'] = "Administrátor";
$lng['logger']['login'] = "Přihlášení";
$lng['logger']['intern'] = "Interní";
$lng['logger']['unknown'] = "Neznámý";
$lng['serversettings']['mailtraffic_enabled']['title'] = "Analyzovat mailový provoz";
$lng['admin']['integritycheck'] = 'Ověření databáze';
$lng['admin']['integrityid'] = '#';
$lng['admin']['integrityname'] = 'Název';
$lng['admin']['integrityresult'] = 'Výsledek';
$lng['admin']['integrityfix'] = 'Opravit problémy automaticky';

// Added in Froxlor 0.9.33
$lng['error']['no_phpinfo'] = 'Omlouváme se, ale phpinfo() nelze načíst';

$lng['admin']['movetoadmin'] = 'Přesunout zákazníka';

$lng['domains']['domain_import'] = 'Importovat domény';
$lng['domains']['import_separator'] = 'Oddělovač';
$lng['domains']['import_file'] = 'CSV-Soubor';
$lng['success']['domain_import_successfully'] = 'Úspěšně importováno %s domén.';
$lng['admin']['note'] = 'Poznámka';

// Added for apcuinfo
$lng['apcuinfo']['clearcache'] = 'Vyčistit APCu cache';
$lng['apcuinfo']['version'] = 'APCu verze';
$lng['apcuinfo']['phpversion'] = 'PHP verze';
$lng['apcuinfo']['sharedmem'] = 'Sdílená pamět';
$lng['apcuinfo']['sharedmemval'] = '%d Segment(s) with %s (%s memory)';
$lng['apcuinfo']['start'] = 'Čas zapnutí';
$lng['apcuinfo']['uptime'] = 'Uptime';
$lng['apcuinfo']['upload'] = 'Podpora nahrávání souborů';
$lng['apcuinfo']['cachetitle'] = 'Cache Information';
$lng['apcuinfo']['memnote'] = 'Využití paměti <font size=-2>(několik krajíců indikuje fragmenty)</font>';
$lng['apcuinfo']['free'] = 'Volné';
$lng['apcuinfo']['used'] = 'Využité';
$lng['apcuinfo']['detailmem'] = 'Detailní využití paměti a fragmentace';
$lng['apcuinfo']['fragment'] = 'Fragmentace';

// Added for opcache info
$lng['opcacheinfo']['resetcache'] = 'Resetovat OPcache';
$lng['opcacheinfo']['version'] = 'OPCache verze';
$lng['opcacheinfo']['phpversion'] = 'PHP verze';
$lng['opcacheinfo']['start'] = 'Čas zapnutí';
$lng['opcacheinfo']['lastreset'] = 'Poslední restart';
$lng['opcacheinfo']['oomrestarts'] = 'OOM restart count';
$lng['opcacheinfo']['hashrestarts'] = 'Hash restart count';
$lng['opcacheinfo']['manualrestarts'] = 'Manual restart count';
$lng['opcacheinfo']['status'] = 'Stav';
$lng['opcacheinfo']['cachefull'] = 'Cache je plný';
$lng['opcacheinfo']['restartinprogress'] = 'Restart právě probíhá';
$lng['opcacheinfo']['memusage'] = 'Využití paměti';
$lng['opcacheinfo']['totalmem'] = 'Celková pamět';
$lng['opcacheinfo']['usedmem'] = 'Využitá paměť';
$lng['opcacheinfo']['freemem'] = 'Volná pamět';
$lng['opcacheinfo']['used'] = 'Využité';
$lng['opcacheinfo']['free'] = 'Volné';
$lng['opcacheinfo']['blacklist'] = 'Černá listina';
$lng['opcacheinfo']['novalue'] = '<i>bez hodnoty</i>';

// Added for let's encrypt
$lng['admin']['letsencrypt']['title'] = 'Používat Let\'s Encrypt';
$lng['panel']['letsencrypt'] = 'Používá Let\'s encrypt';
$lng['crondesc']['cron_letsencrypt'] = 'aktualizuji Let\'s Encrypt certifikáty';
$lng['serversettings']['letsencryptstate']['description'] = "State used to generate Let's Encrypt certificates.";
$lng['serversettings']['leenabled']['title'] = "Zapnout Let's Encrypt";

// Added for CAA record support
$lng['serversettings']['caa_entry']['title'] = 'Generovat CAA DNS záznamy';

// Autoupdate
$lng['admin']['autoupdate'] = 'Auto-Aktualizace';
$lng['error']['customized_version'] = 'Vypadá to, že tvá instalace Froxloru byla upravována, podpora byla zrušena, promiň.';
$lng['error']['autoupdate_0'] = 'Neznámá chyba';
$lng['error']['autoupdate_1'] = 'PHP nastavení allow_url_fopen je vypnuté. Automatická aktualizace toto nastavení potřebuje v php.ini';
$lng['error']['autoupdate_2'] = 'PHP zip rozšíření nebylo nalezeno, ujisti se, že je nainstalované a aktivované';
$lng['error']['autoupdate_4'] = 'Froxlor archiv nemohl být uložen na disku :(';
$lng['error']['autoupdate_5'] = 'version.froxlor.org vrátila nepřijatelné hodnoty :(';
$lng['error']['autoupdate_6'] = 'Uf, nebyla nalezena (platná) verze ke stažení :(';
$lng['error']['autoupdate_7'] = 'Stažený archiv nebyl nalezen :(';
$lng['error']['autoupdate_8'] = 'Archiv nemohl být extrahován :(';
$lng['error']['autoupdate_9'] = 'Stažený soubor neprošel testem integrity. Zkus aktualizaci znovu.';
$lng['error']['autoupdate_10'] = 'Minimální podporovaná verze PHP je 7.4.0';

$lng['domains']['termination_date'] = 'Datum zrušení';
$lng['domains']['termination_date_overview'] = 'zrušeno datem ';
$lng['panel']['set'] = 'Použít';

$lng['menue']['extras']['backup'] = 'Záloha';
$lng['extras']['backup'] = 'Vytvořit zálohu';
$lng['extras']['backup_web'] = 'Zálohovat web-data';
$lng['extras']['backup_mail'] = 'Zálohovat mail-data';
$lng['extras']['backup_dbs'] = 'Zálohovat databáze';
$lng['serversettings']['backupenabled']['title'] = "Povolit zálohy pro zákazníky";

$lng['error']['dns_domain_nodns'] = 'DNS pro tuto doménu je vypnuto';
$lng['dnseditor']['edit'] = 'upravit DNS';
$lng['dnseditor']['records'] = 'záznamy';

$lng['admin']['dnsenabled'] = 'Povolit DNS editor';

// Added in froxlor 0.9.38-rc1
$lng['serversettings']['mail_smtp_passwd'] = 'SMTP heslo';

// Added in froxlor 0.9.38.8
$lng['success']['testmailsent'] = 'Testovací email byl odeslán úspěšně';

// added in froxlor 0.9.39
$lng['admin']['plans']['description'] = 'Popis';
$lng['admin']['plans']['last_update'] = 'Naposledy aktualizováno';

// added in froxlor 0.10.0
$lng['panel']['none_value'] = 'Nic';
$lng['menue']['main']['apihelp'] = 'API pomoc';
$lng['menue']['main']['apikeys'] = 'API klíče';
$lng['apikeys']['no_api_keys'] = 'Žádné API klíče nalezeny';
$lng['apikeys']['key_add'] = 'přidat nový klíč';
$lng['apikeys']['clicktoview'] = 'Klikni pro zobrazení';
$lng['apikeys']['allowed_from'] = 'Povoleno od';
$lng['apikeys']['valid_until'] = 'Platné do';
$lng['2fa']['2fa'] = '2FA možnosti';
$lng['2fa']['2fa_enabled'] = 'Aktivovat dvoufázové ověření (2FA)';
$lng['login']['2fa'] = 'Dvoufázové ověření (2FA)';
$lng['login']['2facode'] = 'Prosím zadej 2FA kód';
$lng['2fa']['2fa_removed'] = '2FA úspěšně odstraněno';
$lng['2fa']['2fa_add'] = 'Aktivovat 2FA';
$lng['2fa']['2fa_delete'] = 'Deaktivovat 2FA';
$lng['2fa']['2fa_verify'] = 'Ověřit kód';
$lng['admin']['domain_sslenabled'] = 'Povolit použití SSL';
