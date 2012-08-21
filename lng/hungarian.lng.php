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
 * @author     Laszlo (Laci) Puchner <puchnerl@konyvbroker.hu>
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Language
 *
 */

/**
 * Global
 */

$lng['translator'] = 'Puchner László';
$lng['panel']['edit'] = 'szerkeszt';
$lng['panel']['delete'] = 'töröl';
$lng['panel']['create'] = 'létrehoz';
$lng['panel']['save'] = 'ment';
$lng['panel']['yes'] = 'igen';
$lng['panel']['no'] = 'nem';
$lng['panel']['emptyfornochanges'] = 'változtatásig üres';
$lng['panel']['emptyfordefault'] = 'alapértelmezésben üres';
$lng['panel']['path'] = 'Útvonal';
$lng['panel']['toggle'] = 'Átkapcsol';
$lng['panel']['next'] = 'következő';
$lng['panel']['dirsmissing'] = 'Könyvtár nem található vagy nem olvasható!';

/**
 * Login
 */

$lng['login']['username'] = 'Felhasználónév';
$lng['login']['password'] = 'Jelszó';
$lng['login']['language'] = 'Nyelv';
$lng['login']['login'] = 'Bejelentkezés';
$lng['login']['logout'] = 'Kijelentkezés';
$lng['login']['profile_lng'] = 'Profile nyelve';

/**
 * Customer
 */

$lng['customer']['documentroot'] = 'Kezdőkönyvtár';
$lng['customer']['name'] = 'Név';
$lng['customer']['firstname'] = 'Keresztnév';
$lng['customer']['company'] = 'Cégnév';
$lng['customer']['street'] = 'Utca';
$lng['customer']['zipcode'] = 'Irányítószám';
$lng['customer']['city'] = 'Település';
$lng['customer']['phone'] = 'Telefon';
$lng['customer']['fax'] = 'Fax';
$lng['customer']['email'] = 'E-mail';
$lng['customer']['customernumber'] = 'Felhasználó-azonosító';
$lng['customer']['diskspace'] = 'Tárhely (MB)';
$lng['customer']['traffic'] = 'Forgalom (GB)';
$lng['customer']['mysqls'] = 'MySQL-Adatbázis';
$lng['customer']['emails'] = 'E-mail címek';
$lng['customer']['accounts'] = 'E-mail fiókok';
$lng['customer']['forwarders'] = 'E-mail továbbítók';
$lng['customer']['ftps'] = 'FTP fiókok';
$lng['customer']['subdomains'] = 'Aldomain(ek)';
$lng['customer']['domains'] = 'Domain(ek)';
$lng['customer']['unlimited'] = 'korlátlan';

/**
 * Customermenue
 */

$lng['menue']['main']['main'] = 'Főmenü';
$lng['menue']['main']['changepassword'] = 'Jelszócsere';
$lng['menue']['main']['changelanguage'] = 'Nyelv-változtatás';
$lng['menue']['email']['email'] = 'E-mail';
$lng['menue']['email']['emails'] = 'Címek';
$lng['menue']['email']['webmail'] = 'WebMail';
$lng['menue']['mysql']['mysql'] = 'MySQL';
$lng['menue']['mysql']['databases'] = 'Adatbázisok';
$lng['menue']['mysql']['phpmyadmin'] = 'phpMyAdmin';
$lng['menue']['domains']['domains'] = 'Domainek';
$lng['menue']['domains']['settings'] = 'Beállítások';
$lng['menue']['ftp']['ftp'] = 'FTP';
$lng['menue']['ftp']['accounts'] = 'Fiókok';
$lng['menue']['ftp']['webftp'] = 'WebFTP';
$lng['menue']['extras']['extras'] = 'Extrák';
$lng['menue']['extras']['directoryprotection'] = 'Könyvtárvédelem';
$lng['menue']['extras']['pathoptions'] = 'Útvonal opciók';

/**
 * Index
 */

$lng['index']['customerdetails'] = 'Felhasználói adatok';
$lng['index']['accountdetails'] = 'Fiók adatok';

/**
 * Change Password
 */

$lng['changepassword']['old_password'] = 'Régi jelszó';
$lng['changepassword']['new_password'] = 'Új jelszó';
$lng['changepassword']['new_password_confirm'] = 'Új jelszó (megerősítés)';
$lng['changepassword']['new_password_ifnotempty'] = 'Új jelszó (üres = nem változik)';
$lng['changepassword']['also_change_ftp'] = ' a fő FTP fiók jelszav&aat is megváltoztatja';

/**
 * Domains
 */

$lng['domains']['description'] = 'Itt hozhat létre (al-)domaineket és megváltoztathatja azok útvonalait.<br />A rendszernek minden változtatás után szüksége van némi időre, míg az új beállításokat érvényesíti.';
$lng['domains']['domainsettings'] = 'Domain beállítások';
$lng['domains']['domainname'] = 'Domain név';
$lng['domains']['subdomain_add'] = '(Al-)domain létrehozása';
$lng['domains']['subdomain_edit'] = '(Al-)domain szerkesztése';
$lng['domains']['wildcarddomain'] = 'Helyettesítőként hozza létre?';
$lng['domains']['aliasdomain'] = 'Domain alias (álnév)';
$lng['domains']['noaliasdomain'] = 'Nincs domain alias (álnév)';

/**
 * E-mails
 */

$lng['emails']['description'] = 'Itt hozhatja létre és módosíthatja e-mail címeit.<br />Egy fiók olyan, mint az Ön postaládája a ház előtt. Ha valaki küld  Önnek egy e-mailt, az a postaládába érkezik meg.<br /><br />Az e-mailek letöltéséhez állísa be levelező-programját az alábbiak szerint: (A <i>dőltbetűs</i> adatokat változtassa meg azok alapján, amelyeket beírt!)<br />Szerver (host) neve: <b><i>Domain név</i></b><br />felhasználón&eav: <b><i>Postafiók neve / e-mail cím</i></b><br />Jelszó: <b><i>A jelszó, amelyet választott</i></b>';
$lng['emails']['emailaddress'] = 'E-mail cím';
$lng['emails']['emails_add'] = 'E-mail cím létrehozása';
$lng['emails']['emails_edit'] = 'E-mail cím szerkesztése';
$lng['emails']['catchall'] = 'Gyűjtő';
$lng['emails']['iscatchall'] = 'Beállítja  gyűjtő címként?';
$lng['emails']['account'] = 'Fiók';
$lng['emails']['account_add'] = 'Fiók létrehozása';
$lng['emails']['account_delete'] = 'Fiók törlése';
$lng['emails']['from'] = 'Feladó';
$lng['emails']['to'] = 'Cím';
$lng['emails']['forwarders'] = 'Továbbítók';
$lng['emails']['forwarder_add'] = 'Továbbító létrehozása';

/**
 * FTP
 */

$lng['ftp']['description'] = 'Itt hozhatja létre és módosíthatja FTP fiókjait.<br />A változások azonnal érvénybe lépnek és használhatók.';
$lng['ftp']['account_add'] = 'Fiók létrehozása';

/**
 * MySQL
 */

$lng['mysql']['databasename'] = 'felhasználó/adatbázis neve';
$lng['mysql']['databasedescription'] = 'adatbázis leírása';
$lng['mysql']['database_create'] = 'Adatbázis létrehozása';

/**
 * Extras
 */

$lng['extras']['description'] = 'Itt állíthat be egyebeket, pl. könyvtárvédelmet.<br />A rendszernek minden változtatás után szüksége van némi időre, míg az új beállításokat érvényesíti.';
$lng['extras']['directoryprotection_add'] = 'Könyvtárvédelem hozzáadása';
$lng['extras']['view_directory'] = 'A könyvtár tartalmának megmutatása';
$lng['extras']['pathoptions_add'] = 'Útvonal opciók hozzáadása';
$lng['extras']['directory_browsing'] = 'A könyvtár tartalmána böngészése';
$lng['extras']['pathoptions_edit'] = 'Útvonal opciók szerkesztése';
$lng['extras']['error404path'] = '404';
$lng['extras']['error403path'] = '403';
$lng['extras']['error500path'] = '500';
$lng['extras']['error401path'] = '401';
$lng['extras']['errordocument404path'] = 'A 404-es hibaüzenet URL-je';
$lng['extras']['errordocument403path'] = 'A 403-as hibaüzenet URL-je';
$lng['extras']['errordocument500path'] = 'A 500-as hibaüzenet URL-je';
$lng['extras']['errordocument401path'] = 'A 401-es hibaüzenet URL-je';

/**
 * Errors
 */

$lng['error']['error'] = 'Hiba';
$lng['error']['directorymustexist'] = 'Léteznie kell a %s könyvtárnak. Kérem, hozza létre FTP cliensével.';
$lng['error']['filemustexist'] = 'Léteznie kell a %sfájlnak.';
$lng['error']['allresourcesused'] = 'Ön már minden erőforrását felhasználta.';
$lng['error']['domains_cantdeletemaindomain'] = 'Nem törölhet le olyan domain nevet, amelyet e-mail domainként használnak.';
$lng['error']['domains_canteditdomain'] = 'Nem szerkeszthati ezt a domain nevet. Az adminisztrátor letiltotta.';
$lng['error']['domains_cantdeletedomainwithemail'] = 'Nem törölhet le olyan domain nevet, amelyet e-mail domainként használnak. Töröljön ki minden e-mail címet előbb.';
$lng['error']['firstdeleteallsubdomains'] = 'Mielőtt létrehozna egy gyűjtő-domaint, törölnie kell az összes al-domaint.';
$lng['error']['youhavealreadyacatchallforthisdomain'] = 'Ön már meghatározott egy gyűjtőt erre a domain-re.';
$lng['error']['ftp_cantdeletemainaccount'] = 'Nem törölheti fő FTP hozzáférését.';
$lng['error']['login'] = 'Helytelen a felhasználónév vagy a jelszó, amelyet begépelt. Kérem, próbálja újra!';
$lng['error']['login_blocked'] = 'Ezt a hozzáférés fel lett függesztve a túl sok bejelentkezési hiba miatt. Kérem, próbálja újra!';
$lng['error']['notallreqfieldsorerrors'] = 'Nem teljesen vagy helytelenül töltötte ki a mezőket.';
$lng['error']['oldpasswordnotcorrect'] = 'A régi jelszó helytelen.';
$lng['error']['youcantallocatemorethanyouhave'] = 'Nem oszthat ki több erőforrást, mint amennyit birtokol.';
$lng['error']['mustbeurl'] = 'Nem teljes vagy nem érvényes URL-t (pl.: http://somedomain.com/error404.htm) gépelt be';
$lng['error']['invalidpath'] = 'Nem választott ki érvényes URL-t  (lehet, hogy probléma van a könyvtárlistázással?).';
$lng['error']['stringisempty'] = 'A mezőben nincs adat.';
$lng['error']['stringiswrong'] = 'A mezőben helytelen adat van.';
$lng['error']['myloginname'] = '\'' . $lng['login']['username'] . '\'';
$lng['error']['mypassword'] = '\'' . $lng['login']['password'] . '\'';
$lng['error']['oldpassword'] = '\'' . $lng['changepassword']['old_password'] . '\'';
$lng['error']['newpassword'] = '\'' . $lng['changepassword']['new_password'] . '\'';
$lng['error']['newpasswordconfirm'] = '\'' . $lng['changepassword']['new_password_confirm'] . '\'';
$lng['error']['newpasswordconfirmerror'] = 'Az új jelszó és annak megerősítése nem egyezik meg.';
$lng['error']['myname'] = '\'' . $lng['customer']['name'] . '\'';
$lng['error']['myfirstname'] = '\'' . $lng['customer']['firstname'] . '\'';
$lng['error']['emailadd'] = '\'' . $lng['customer']['email'] . '\'';
$lng['error']['mydomain'] = '\'Domain\'';
$lng['error']['mydocumentroot'] = '\'Dokumentum útvonal\'';
$lng['error']['loginnameexists'] = 'A(z) %s felhasználónév már létezik';
$lng['error']['emailiswrong'] = 'A(z) %s e-mail cím érvénytelen karaktereket tartalmaz vagy nem teljes.';
$lng['error']['loginnameiswrong'] = 'A(z) %s felhasználónév érvénytelen karaktereket tartalmaz.';
$lng['error']['userpathcombinationdupe'] = 'A felhasználónév és útvonal kombinációja már létezik.';
$lng['error']['patherror'] = 'Általános hiba! Az útvonal nem lehet üres.';
$lng['error']['errordocpathdupe'] = 'A(z) %s útvonalra vonatkozó opció már létezik.';
$lng['error']['adduserfirst'] = 'Kérem, előbb hozzon létre egy felhasználót!';
$lng['error']['domainalreadyexists'] = 'A(z) %s domain név már hozzá van rendelve egy felhasználóhoz.';
$lng['error']['nolanguageselect'] = 'Nincs kiválasztott nyelv.';
$lng['error']['nosubjectcreate'] = 'Meg kell határoznia egy tárgyat ehhez a sablonhoz.';
$lng['error']['nomailbodycreate'] = 'Meg kell határoznia az üzenet szövegét ehhez a sablonhoz.';
$lng['error']['templatenotfound'] = 'A sablon nem található.';
$lng['error']['alltemplatesdefined'] = 'Nem készíthet több sablont, már minden nyelv támogatva van.';
$lng['error']['wwwnotallowed'] = 'a www előtag  al-domaineknél nem használható.';
$lng['error']['subdomainiswrong'] = 'A(z) %s al-domain érvénytelen karaktereket tartalmaz.';
$lng['error']['domaincantbeempty'] = 'A domain neve nem lehet üres.';
$lng['error']['domainexistalready'] = 'A(z) %s domain már létezik.';
$lng['error']['domainisaliasorothercustomer'] = 'A választott domain álnév (alias) vagy maga is domain álnév, vagy más felhasználóhoz tartozik.';
$lng['error']['emailexistalready'] = 'A(z) %s e-mail cím már létezik.';
$lng['error']['maindomainnonexist'] = 'A(z)  %s fő domain nem létezik.';
$lng['error']['destinationnonexist'] = 'Kérem, levél-továbbítóját a  \'Cél\' mappában hozza létre.';
$lng['error']['destinationalreadyexistasmail'] = 'A(z) %s továbbító már létezik mint aktív e-mail cím.';
$lng['error']['destinationalreadyexist'] = 'Ön már létrehozott egy továbbítót ehhez: %s .';
$lng['error']['destinationiswrong'] = 'A(z) %s továbbító érvénytelen karakter(eke)t tartalmaz vagy nem teljes.';
$lng['error']['domainname'] = $lng['domains']['domainname'];

/**
 * Questions
 */

$lng['question']['question'] = 'Biztonsági kérdés';
$lng['question']['admin_customer_reallydelete'] = 'Tényleg törölni akarja a(z)  %s felhasználót? Ezt a lépést nem lehet visszavonni!';
$lng['question']['admin_domain_reallydelete'] = 'Tényleg törölni akarja a(z) %s domain?';
$lng['question']['admin_domain_reallydisablesecuritysetting'] = 'Tényleg hatástalanítani akarja ezeket a biztonsági beállításokat (OpenBasedir)?';
$lng['question']['admin_admin_reallydelete'] = 'Tényleg törölni akarja a(z) %s adminisztrátort? Minden hozzá tartozó felhasználó és domain a főadminisztrátorhoz lesz rendelve.';
$lng['question']['admin_template_reallydelete'] = 'Tényleg törölni akarja a(z) \'%s\' sablont?';
$lng['question']['domains_reallydelete'] = 'Tényleg törölni akarja a(z)  %s domain-t?';
$lng['question']['email_reallydelete'] = 'Tényleg törölni akarja a(z)  %s e-mail címet?';
$lng['question']['email_reallydelete_account'] = 'Tényleg törölni akarja a(z) %s e-mail postafiókot?';
$lng['question']['email_reallydelete_forwarder'] = 'Tényleg törölni akarja a(z) %s továbbítót?';
$lng['question']['extras_reallydelete'] = 'Tényleg törölni akarja a(z)  %s könyvtár-védelmét?';
$lng['question']['extras_reallydelete_pathoptions'] = 'Tényleg törölni akarja a(z) %s útvonal-beállításait?';
$lng['question']['ftp_reallydelete'] = 'Tényleg törölni akarja a(z)  %s FTP hozzáférést?';
$lng['question']['mysql_reallydelete'] = 'Tényleg törölni szeretné a(z) adatbázist? Ez a lépés nem vonható vissza!';
$lng['question']['admin_configs_reallyrebuild'] = 'Tényleg újra szeretné építeni az Apache és Bind konfigurációs állományait?';

/**
 * Mails
 */

$lng['mails']['pop_success']['mailbody'] = 'Üdvözlöm!\n\nE-mail fiókja {EMAIL} létrejött.\n\nEz egy automatikusan küldött\ne-mail, kérem, ne válaszoljon rá!\n\nTisztelettel: a Froxlor csapata';
$lng['mails']['pop_success']['subject'] = 'E-mail fiók létrehozva.';
$lng['mails']['createcustomer']['mailbody'] = 'Tisztelt {FIRSTNAME} {NAME}!\n\nAz Ön postafiók adatai:\n\nFelhasználónév: {USERNAME}\nJelszó: {PASSWORD}\n\nKöszönjük:\na Froxlor csapata';
$lng['mails']['createcustomer']['subject'] = 'Postafiók információ';

/**
 * Admin
 */

$lng['admin']['overview'] = 'Áttekintés';
$lng['admin']['ressourcedetails'] = 'Felhasznált erőforrások';
$lng['admin']['systemdetails'] = 'Rendszeradatok';
$lng['admin']['froxlordetails'] = 'Froxlor adatok';
$lng['admin']['installedversion'] = 'Installált Verzió';
$lng['admin']['latestversion'] = 'Legutolsó verzió';
$lng['admin']['lookfornewversion']['clickhere'] = 'keresés a webszervizen keresztül';
$lng['admin']['lookfornewversion']['error'] = 'Olvasási hiba';
$lng['admin']['resources'] = 'Erőforrások';
$lng['admin']['customer'] = 'Felhasználó';
$lng['admin']['customers'] = 'Felhasználók';
$lng['admin']['customer_add'] = 'Felhasználó hozzáadása';
$lng['admin']['customer_edit'] = 'Felhasználó szerkesztése';
$lng['admin']['domains'] = 'Domainek';
$lng['admin']['domain_add'] = 'Domain hozzáadása';
$lng['admin']['domain_edit'] = 'Domain szerkesztése';
$lng['admin']['subdomainforemail'] = 'Aldomainek mint e-mail-domainek';
$lng['admin']['admin'] = 'Adminisztrátor';
$lng['admin']['admins'] = 'Adminisztrátorok';
$lng['admin']['admin_add'] = 'Adminisztrátor hozzáadása';
$lng['admin']['admin_edit'] = 'Adminisztrátor szerkesztése';
$lng['admin']['customers_see_all'] = 'Láthatja az összes felhasználót?';
$lng['admin']['domains_see_all'] = 'Láthatja az összes domaint?';
$lng['admin']['change_serversettings'] = 'Megváltoztathatja a szerver beállításait?';
$lng['admin']['server'] = 'Szerver';
$lng['admin']['serversettings'] = 'Beállítások';
$lng['admin']['rebuildconf'] = 'A konfig. fájlok újraírása';
$lng['admin']['stdsubdomain'] = 'Egyszerű aldomain';
$lng['admin']['stdsubdomain_add'] = 'Egyszerű aldomain hozzáadása';
$lng['admin']['deactivated'] = 'Kikapcsolva';
$lng['admin']['deactivated_user'] = 'Felhasználï¿½ kikapcsolása';
$lng['admin']['sendpassword'] = 'Jelszó kï¿½ldése';
$lng['admin']['ownvhostsettings'] = 'Saját vHost beállítások';
$lng['admin']['configfiles']['serverconfiguration'] = 'Konfiguráció';
$lng['admin']['configfiles']['files'] = '<b>Konfig. fájlok:</b> Kérem, változtassa meg a következő fájlokat, vagy - ha még nem léteznek - hozza létre őket a következő tartalommal.<br /><b>Fontos:</b> A MySQL jelszó biztonsági okokból nem lesz kicserélve. Kérem, cserélje ki a "MYSQL_PASSWORD"-öt! Ha elfelejtette a NySQL jelszót, megtalálja a "lib/userdata.inc.php" fájlban.';
$lng['admin']['configfiles']['commands'] = '<b>Parancsok:</b> Kérem, hajtsa végre a következő parancsokat egy héjprogramban (shell)!';
$lng['admin']['configfiles']['restart'] = '<b>Újraindítás:</b> Kérem, hajtsa végre a következő parancsokat egy héjprogramban (shell), hogy az új konfiguráció betöltődjön.';
$lng['admin']['templates']['templates'] = 'Sablonok';
$lng['admin']['templates']['template_add'] = 'Sablon hozzáadása';
$lng['admin']['templates']['template_edit'] = 'Sablon szerkesztése';
$lng['admin']['templates']['action'] = 'Alkalom';
$lng['admin']['templates']['email'] = 'E-mail';
$lng['admin']['templates']['subject'] = 'Tárgy';
$lng['admin']['templates']['mailbody'] = 'Szövegrörzs';
$lng['admin']['templates']['createcustomer'] = 'Üdvözlő levél új felhasználóknak';
$lng['admin']['templates']['pop_success'] = 'Üdvözlő levél új fiók esetén';
$lng['admin']['templates']['template_replace_vars'] = 'A sablonban használható változók';
$lng['admin']['templates']['FIRSTNAME'] = 'A felhasználó keresztneve ';
$lng['admin']['templates']['NAME'] = 'A felhasználó neve ';
$lng['admin']['templates']['USERNAME'] = 'A felhasználó felhasználóneve';
$lng['admin']['templates']['PASSWORD'] = 'A felhasználó felhasználóneve jelszava';
$lng['admin']['templates']['EMAIL'] = 'A POP3/IMAP fiók címe.';

/**
 * Serversettings
 */

$lng['serversettings']['session_timeout']['title'] = 'Munkamenet időtúllépés';
$lng['serversettings']['session_timeout']['description'] = 'Mennyi idő múlva váljon a munkamenet érvénytelenné a felhasználó utolsó tevékenységétől (másodperc)?';
$lng['serversettings']['accountprefix']['title'] = 'Felhasználói előtag';
$lng['serversettings']['accountprefix']['description'] = 'Milyen előtaggal legyenek a felhasználói hozzáférések ellátva?';
$lng['serversettings']['mysqlprefix']['title'] = 'SQL előtag';
$lng['serversettings']['mysqlprefix']['description'] = 'Melyen előtaggal legyenek a mysql hozzáférések ellátva?';
$lng['serversettings']['ftpprefix']['title'] = 'FTP előtag';
$lng['serversettings']['ftpprefix']['description'] = 'Milyen előtaggal legyenek az FTP hozzáférések ellátva?';
$lng['serversettings']['documentroot_prefix']['title'] = 'Documentum könyvtár';
$lng['serversettings']['documentroot_prefix']['description'] = 'Hol legyen minen adat tárolva?';
$lng['serversettings']['logfiles_directory']['title'] = 'Naplófájlok könyvtára';
$lng['serversettings']['logfiles_directory']['description'] = 'Hol legyen minden naplófájl tárolva?';
$lng['serversettings']['ipaddress']['title'] = 'IP cím';
$lng['serversettings']['ipaddress']['description'] = 'Mi az  IP címe ennek a szervernek?';
$lng['serversettings']['hostname']['title'] = 'Hostnév (gépnév)';
$lng['serversettings']['hostname']['description'] = 'Mi legyen a neve ennek a szervernek?';
$lng['serversettings']['apachereload_command']['title'] = 'Apache újraindítási parancs';
$lng['serversettings']['apachereload_command']['description'] = 'Mi az Apache újraindítási parancsa?';
$lng['serversettings']['bindconf_directory']['title'] = 'Bind konfigurációs könyvtár';
$lng['serversettings']['bindconf_directory']['description'] = 'Hol vannak a Bind konfigurációs állományok?';
$lng['serversettings']['bindreload_command']['title'] = 'Bind újraindítási parancs';
$lng['serversettings']['bindreload_command']['description'] = 'Mi a Bind újraindítási parancsa?';
$lng['serversettings']['binddefaultzone']['title'] = 'Bind alapértelmezett zóna';
$lng['serversettings']['binddefaultzone']['description'] = 'Mi az alapértelmezett zóna neve?';
$lng['serversettings']['vmail_uid']['title'] = 'E-mail felhasználó-azonosító (UID)';
$lng['serversettings']['vmail_uid']['description'] = 'Melyik felhasználó-azonosítót (UserID) használják a levelek?';
$lng['serversettings']['vmail_gid']['title'] = 'E-mail csoport-azonosító (GID)';
$lng['serversettings']['vmail_gid']['description'] = 'Melyik csoport-azonosítót (GroupID) használják a levelek?';
$lng['serversettings']['vmail_homedir']['title'] = 'E-mail könyvtár';
$lng['serversettings']['vmail_homedir']['description'] = 'Hol legyenek az e-mailek tárolva?';
$lng['serversettings']['adminmail']['title'] = 'Feladó';
$lng['serversettings']['adminmail']['description'] = 'Ki legyen a feladója a panelről küldött leveleknek?';
$lng['serversettings']['phpmyadmin_url']['title'] = 'phpMyAdmin URL';
$lng['serversettings']['phpmyadmin_url']['description'] = 'Mi a  phpMyAdmin URL-je? (http://-vel kell kezdődnie)';
$lng['serversettings']['webmail_url']['title'] = 'WebMail URL';
$lng['serversettings']['webmail_url']['description'] = 'Mi a WebMail URL-je? (http://-vel kell kezdődnie)';
$lng['serversettings']['webftp_url']['title'] = 'WebFTP URL';
$lng['serversettings']['webftp_url']['description'] = 'Mi a WebFTP URL-je? (http://-vel kell kezdődnie)';
$lng['serversettings']['language']['description'] = 'Mi a szerver alapértelmezett nyelve?';
$lng['serversettings']['maxloginattempts']['title'] = 'Maximális bejelentkezési kísérlet';
$lng['serversettings']['maxloginattempts']['description'] = 'Bejelentkezési kísérletek maximális száma, mielőtt a hozzáférés zárolva lesz.';
$lng['serversettings']['deactivatetime']['title'] = 'Zárlat-idő';
$lng['serversettings']['deactivatetime']['description'] = 'Az időszak (másodpercekben), ameddig a túl sok bejelentkezési kísérlet után a hozzáférés zárolva lesz.';
$lng['serversettings']['pathedit']['title'] = 'Az útvonal-megadás típusa';
$lng['serversettings']['pathedit']['description'] = 'Legördülő menü vagy beviteli mező segítségével lesznek az útvonalak kiválasztva?';

/**
 * CHANGED BETWEEN 1.2.12 and 1.2.13
 */

$lng['mysql']['description'] = 'Itt hozhatja létre és változtathatja meg MySQL adatbázisait. <br />
 A változások azonnal érvényre jutnak, és az adatbázis rögtön használható.<br />
 A bal oldali menüben megtalálja a  phpMyAdmin eszközt, amellyel könnyedén kezelheti adatbázisát.<br />
 <br />Saját PHP kódjaiból a következő beállításokkal férhet hozzá adatbázisához: (A  <i>dőltbetűs</i> adatokat helyettesítenie kell az Ön által megadottakkal!)<br /> Hostnév: <b> <SQL_HOST></b><br />
 Felhasználónév: <b><i>Adatbázisnév</i></b><br />Jelszó: <b><i>a jelszó, amelyet Ön kiválasztott </i></b><br />Adatbázis: <b><i>Adatbázisnév</i></b>';

/**
 * ADDED BETWEEN 1.2.12 and 1.2.13
 */

$lng['serversettings']['paging']['title'] = 'Bejegyzések száma egy lapon';
$lng['serversettings']['paging']['description'] = 'Hány bejegyzés jelenjen meg egy lapon? (0 = lapozás kikapcsolása)';
$lng['error']['ipstillhasdomains'] = 'A törölni kívánt IP/Port kombinációhoz domainek vannak rendelve. Rendelje hozzá ezeket egy másik IP/Port kombinációhoz, mielőtt a jelenlegi IP/Port kombinációt törli.';
$lng['error']['cantdeletedefaultip'] = 'Nem törölheti az alapértelmezett viszonteladói  IP/Port kombinációt. Hozzon létre új  alapértelmezett IP/Port kombinációt a viszonteladóknak, mielőtt ezt az  IP/Port kombinációt törli.';
$lng['error']['cantdeletesystemip'] = 'Nem törölheti a rendszer utolsó IP címét. Hozzon létre egy új IP/Port kombinációt a rendszer IP címére, vagy változatassa meg a rendszer IP címét.';
$lng['error']['myipaddress'] = '\'IP\'';
$lng['error']['myport'] = '\'Port\'';
$lng['error']['myipdefault'] = 'Választania kell egy IP/Port kombinációt alapértelmezésnek.';
$lng['error']['myipnotdouble'] = 'Ez az  IP/Port kombináció már létezik.';
$lng['question']['admin_ip_reallydelete'] = 'Valóban törölni akarja a(z) %s IP címet?';
$lng['admin']['ipsandports']['ipsandports'] = 'IP címek és Portok';
$lng['admin']['ipsandports']['add'] = 'IP/Port hozzáadása';
$lng['admin']['ipsandports']['edit'] = 'IP/Port szerkesztése';
$lng['admin']['ipsandports']['ipandport'] = 'IP/Port';
$lng['admin']['ipsandports']['ip'] = 'IP';
$lng['admin']['ipsandports']['port'] = 'Port';

// ADDED IN 1.2.13-rc3

$lng['error']['cantchangesystemip'] = 'Nem változtathatja meg a rendszer utolsó IP címét. Hozzon létre egy új IP/Port kombinációt a rendszer IP címére, vagy változatassa meg a rendszer IP címét.';
$lng['question']['admin_domain_reallydocrootoutofcustomerroot'] = 'Biztos, hogy a dokumentum gyökerét (root) rendeli ehhez a domainhez, nem pedig a felhasználói könyvtárban marad?';

// ADDED IN 1.2.14-rc1

$lng['admin']['memorylimitdisabled'] = 'Letiltva';
$lng['domain']['openbasedirpath'] = 'OpenBasedir útvonal';
$lng['domain']['docroot'] = 'Útvonal a a fenti mezőből';
$lng['domain']['homedir'] = 'Kezdőkönyvtár';
$lng['admin']['valuemandatory'] = 'Ez a mező kötelező';
$lng['admin']['valuemandatorycompany'] = 'Vagy a "név" és "keresztnév", vagy  a "cégnév" mezőt ki kell tölteni.';
$lng['menue']['main']['username'] = 'Bejelentkezve mint: ';
$lng['panel']['urloverridespath'] = 'URL (figyelmen kívül hagyja az útvonalat)';
$lng['panel']['pathorurl'] = 'Útvonal az URL-hez';
$lng['error']['sessiontimeoutiswrong'] = 'Csak numerikus "Munkamenet Időtúllépés"adható meg.';
$lng['error']['maxloginattemptsiswrong'] = 'Csak numerikus  "Maximális Bejelentkezési Kísérlet"adható meg. ';
$lng['error']['deactivatetimiswrong'] = 'Csak numerikus "Kikapcsolási Idő" adható meg.';
$lng['error']['accountprefixiswrong'] = 'A "Felhasználói Előtag" helytelen.';
$lng['error']['mysqlprefixiswrong'] = 'Az "SQL Előtag" helytelen.';
$lng['error']['ftpprefixiswrong'] = 'Az "FTP Előtag "helytelen.';
$lng['error']['ipiswrong'] = 'Az "IP Cím" helytelen. Csak érvényes IPcím adható meg.';
$lng['error']['vmailuidiswrong'] = 'A "Levelezési Felhasználó-azonosító (LFA) " helytelen. Csak numerikus LFA adható meg.';
$lng['error']['vmailgidiswrong'] = 'A "Levelezési GID " helytelen. Csak numerikus GID adható meg.';
$lng['error']['adminmailiswrong'] = 'A "Feladó Címe " helytelen. Csak érvényes e-mail cím adható meg.';
$lng['error']['pagingiswrong'] = 'A "Laponkénti Bejegyzés " értéke helytelen. Csak numerikus karaktereket lehet megadni..';
$lng['error']['phpmyadminiswrong'] = 'A phpMyAdmin hivatkozás érvénytelen.';
$lng['error']['webmailiswrong'] = 'A WebMail hivatkozás érvénytelen.';
$lng['error']['webftpiswrong'] = 'A WebFTP hivatkozás érvénytelen';
$lng['domains']['hasaliasdomains'] = 'Alias (al-)domainjei';
$lng['serversettings']['defaultip']['title'] = 'Alapértelmezett IP/Port';
$lng['serversettings']['defaultip']['description'] = 'Mi az alapértelmezett IP/Port kombináció?';
$lng['domains']['statstics'] = 'Használati statisztika';
$lng['panel']['ascending'] = 'növekvő';
$lng['panel']['decending'] = 'csökkenő';
$lng['panel']['search'] = 'Keresés';
$lng['panel']['used'] = 'felhasznált';

// ADDED IN 1.2.14-rc3

$lng['panel']['translator'] = 'Fordító';

// ADDED IN 1.2.14-rc4

$lng['error']['stringformaterror'] = 'A "%s" mező értéke nem megfelelő formátumú.';

// ADDED IN 1.2.15-rc1

$lng['admin']['serversoftware'] = 'Szerverszoftver';
$lng['admin']['phpversion'] = 'PHP verzió';
$lng['admin']['phpmemorylimit'] = 'PHP memória korlát';
$lng['admin']['mysqlserverversion'] = 'MySQL szerver verzió';
$lng['admin']['mysqlclientversion'] = 'MySQL kliens verzió';
$lng['admin']['webserverinterface'] = 'Webszerver Interfész';
$lng['domains']['isassigneddomain'] = 'Hozzárendelt domain';
$lng['serversettings']['phpappendopenbasedir']['title'] = 'Az OpenBasedir-hez csatolt útvonalak';
$lng['serversettings']['phpappendopenbasedir']['description'] = 'Ezek az útvonalak (kettősponttal elválasztva) lesznek hozzáadva az OpenBasedir jegyzékhez minden vhost tárolóban.';

// CHANGED IN 1.2.15-rc1

$lng['error']['loginnameissystemaccount'] = 'Nem hozhat létre olyan fiókot, amely hasonlít a rendszerfiókokhoz (mint pl. a "%s" kezdetűek). Kérem, adjon meg másik fióknevet!';

?>
