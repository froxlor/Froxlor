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
 * @author     Bystrik Kacer <drakeman@phpnuke.sk>
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Language
 */

/**
 * Global
 */

$lng['translator'] = 'Drakeman';
$lng['panel']['edit'] = 'Upravi»';
$lng['panel']['delete'] = 'Zmaza»';
$lng['panel']['create'] = 'Vytvori»';
$lng['panel']['save'] = 'UloŸi»';
$lng['panel']['yes'] = 'Áno';
$lng['panel']['no'] = 'Nie';
$lng['panel']['emptyfornochanges'] = 'Ak políèko nevyplníte, ostane bez zmien';
$lng['panel']['emptyfordefault'] = 'Ak políèko nevyplníte, ostane nastavené ako predvolené';
$lng['panel']['path'] = 'Cesta';
$lng['panel']['toggle'] = 'Prepnú»';
$lng['panel']['next'] = 'Ïal¹ie';
$lng['panel']['dirsmissing'] = 'Nepodarilo sa nájs» uvedený adresár!';

/**
 * Login
 */

$lng['login']['username'] = 'UŸívateµské meno';
$lng['login']['password'] = 'Heslo';
$lng['login']['language'] = 'Jazyk';
$lng['login']['login'] = 'Prihlási»';
$lng['login']['logout'] = 'Odlási»';
$lng['login']['profile_lng'] = 'Jazyk profilu';

/**
 * Customer
 */

$lng['customer']['documentroot'] = 'Domovský adresár (root)';
$lng['customer']['name'] = 'Priezvisko';
$lng['customer']['firstname'] = 'Meno';
$lng['customer']['company'] = 'Spoloènos»';
$lng['customer']['street'] = 'Ulica';
$lng['customer']['zipcode'] = 'PSÈ';
$lng['customer']['city'] = 'Mesto';
$lng['customer']['phone'] = 'Tel.';
$lng['customer']['fax'] = 'Fax';
$lng['customer']['email'] = 'E-mail';
$lng['customer']['customernumber'] = 'ID klienta';
$lng['customer']['diskspace'] = 'Diskový priestor (MB)';
$lng['customer']['traffic'] = 'Traffic/prenos (GB)';
$lng['customer']['mysqls'] = 'MySQL-Databázy';
$lng['customer']['emails'] = 'E-mailové adresy';
$lng['customer']['accounts'] = 'E-mailové úèty';
$lng['customer']['forwarders'] = 'E-mailové presmerovania';
$lng['customer']['ftps'] = 'FTP-úèty';
$lng['customer']['subdomains'] = 'SubDoména(y)';
$lng['customer']['domains'] = 'Doména(y)';
$lng['customer']['unlimited'] = 'Neobmedzené';

/**
 * Customermenue
 */

$lng['menue']['main']['main'] = 'Hlavné menu';
$lng['menue']['main']['changepassword'] = 'Zmeni» heslo';
$lng['menue']['main']['changelanguage'] = 'Zmeni» jazyk';
$lng['menue']['email']['email'] = 'E-mail';
$lng['menue']['email']['emails'] = 'Adresy';
$lng['menue']['email']['webmail'] = 'WebMail';
$lng['menue']['mysql']['mysql'] = 'MySQL';
$lng['menue']['mysql']['databases'] = 'Databázy';
$lng['menue']['mysql']['phpmyadmin'] = 'phpMyAdmin';
$lng['menue']['domains']['domains'] = 'Domény';
$lng['menue']['domains']['settings'] = 'Nastavenia';
$lng['menue']['ftp']['ftp'] = 'FTP';
$lng['menue']['ftp']['accounts'] = 'Úèty';
$lng['menue']['ftp']['webftp'] = 'WebFTP';
$lng['menue']['extras']['extras'] = '©peciálne';
$lng['menue']['extras']['directoryprotection'] = 'Ochrana adresárov';
$lng['menue']['extras']['pathoptions'] = 'MoŸnosti cesty';

/**
 * Index
 */

$lng['index']['customerdetails'] = 'Detaily klienta';
$lng['index']['accountdetails'] = 'Detaily úètu';

/**
 * Change Password
 */

$lng['changepassword']['old_password'] = 'Staré heslo';
$lng['changepassword']['new_password'] = 'Nové heslo';
$lng['changepassword']['new_password_confirm'] = 'Potvrïte nové heslo';
$lng['changepassword']['new_password_ifnotempty'] = 'Nové heslo (prázdne = bez zmeny)';
$lng['changepassword']['also_change_ftp'] = ' TieŸ zmeni» heslo FTP úètu';

/**
 * Domains
 */

$lng['domains']['description'] = 'Tu môŸete nastavi» a vytvori» subdomény a zmeni» ich cestu k adresáru, kde majú smerova».<br />Systém bude potrebova» niekoµko málo minút na uskutoènenie zmien (pribliŸne 5 min).';
$lng['domains']['domainsettings'] = 'Nastavenia domény';
$lng['domains']['domainname'] = 'Názov domény';
$lng['domains']['subdomain_add'] = 'Vytvori» subdoménu';
$lng['domains']['subdomain_edit'] = 'Upravi» subdoménu';
$lng['domains']['wildcarddomain'] = 'Vytvori» doménu ako wildcarddomain <br />(v¹etky subdomény smerujú do root adresára hlavnej domény)?';
$lng['domains']['aliasdomain'] = 'Alias pre doménu';
$lng['domains']['noaliasdomain'] = '®iaden alias pre doménu';

/**
 * E-mails
 */

$lng['emails']['description'] = 'Tu môŸete vytvori» a zmeni» Va¹e E-mailové adresy.<br />E-mail úèet je ako Va¹a po¹tová schránka v dome. Ak Vám niekto po¹le E-mail, bude vloŸený do Vá¹ho úètu.<br /><br />Pre stiahnutie Va¹ích E-mailov pouŸite do Vá¹ho mailového programu nasledujúce nastavenia: (Informácie oznaèené <i>lomeným písmom</i>, musia by» zmenené na Va¹e prístupové údaje!)<br />Názov hosta: <b><i>Názov domény</i></b><br />UŸívateµské meno: <b><i>Názov úètu / E-mailová adresa</i></b><br />Heslo: <b><i>heslo, ktoré ste si zvolili</i></b>';
$lng['emails']['emailaddress'] = 'E-mailová adresa';
$lng['emails']['emails_add'] = 'Vytvori» E-mailovú adresu';
$lng['emails']['emails_edit'] = 'Upravi» E-mailovú adresu';
$lng['emails']['catchall'] = 'Doménový kô¹';
$lng['emails']['iscatchall'] = 'Definova» ako doménový kô¹?';
$lng['emails']['account'] = 'Úèet';
$lng['emails']['account_add'] = 'Vytvori» úèet';
$lng['emails']['account_delete'] = 'Vymaza» úèet';
$lng['emails']['from'] = 'Zdroj';
$lng['emails']['to'] = 'Cieµ';
$lng['emails']['forwarders'] = 'Presmerovania';
$lng['emails']['forwarder_add'] = 'Vytvori» presmerovanie';

/**
 * FTP
 */

$lng['ftp']['description'] = 'Tu môŸete vytvori» a zmeni» Va¹e FTP úèty.<br />Zmeny sú okamŸité a úèty môŸete pouŸíva» ihneï.';
$lng['ftp']['account_add'] = 'Vytvori» FTP úèet';

/**
 * MySQL
 */

$lng['mysql']['databasename'] = 'UŸívateµ/Názov databázy';
$lng['mysql']['databasedescription'] = 'Popis databázy';
$lng['mysql']['database_create'] = 'Vytvori» databázu';

/**
 * Extras
 */

$lng['extras']['description'] = 'Tu môŸete pridáva» ïaµ¹ie doplnky, napríklad ochranu súborov.<br />Systém bude potrebova» niekoµko málo minút na uskutoènenie zmien (pribliŸne 5 min).';
$lng['extras']['directoryprotection_add'] = 'Prida» ochranu adresára';
$lng['extras']['view_directory'] = 'Zobrazi» obsah adresára';
$lng['extras']['pathoptions_add'] = 'Prida» moŸnosti cesty';
$lng['extras']['directory_browsing'] = 'Prezeranie obsahu adresáru';
$lng['extras']['pathoptions_edit'] = 'Upravi» moŸnosti cesty';
$lng['extras']['error404path'] = '404';
$lng['extras']['error403path'] = '403';
$lng['extras']['error500path'] = '500';
$lng['extras']['error401path'] = '401';
$lng['extras']['errordocument404path'] = 'URL pre Chybový Dokument 404';
$lng['extras']['errordocument403path'] = 'URL pre Chybový Dokument 403';
$lng['extras']['errordocument500path'] = 'URL pre Chybový Dokument 500';
$lng['extras']['errordocument401path'] = 'URL pre Chybový Dokument 401';

/**
 * Errors
 */

$lng['error']['error'] = 'Chyba';
$lng['error']['directorymustexist'] = 'Adresár %s musí existova». Prosím, vytvorte ho pouŸitím FTP klienta.';
$lng['error']['filemustexist'] = 'Súbor %s musí existova».';
$lng['error']['allresourcesused'] = 'UŸ ste pouŸili v¹etky Va¹e zdroje (moŸnosti).';
$lng['error']['domains_cantdeletemaindomain'] = 'NemôŸete vymaza» doménu, ktorá sa pouŸíva ako E-mailová doména.';
$lng['error']['domains_canteditdomain'] = 'NemôŸete upravi» túto doménu. Bola zablokovaná admininistrátorom.';
$lng['error']['domains_cantdeletedomainwithemail'] = 'NemôŸete vymaza» doménu, ktorá sa pouŸíva ako E-mailová doména. Najskôr zmaŸte v¹etky E-mailové adresy.';
$lng['error']['firstdeleteallsubdomains'] = 'Pred vytvorením wildcard domény najskôr musíte vymaza» v¹etky subdomény.';
$lng['error']['youhavealreadyacatchallforthisdomain'] = 'Pre túto doménu ste uŸ doménový kô¹ nadefinovali.';
$lng['error']['ftp_cantdeletemainaccount'] = 'NemôŸete vymaza» Vá¹ hlavný FTP úèet';
$lng['error']['login'] = 'UŸívateµské meno alebo heslo, ktoré ste zadali je nesprávne. Prosím, skúste znovu!';
$lng['error']['login_blocked'] = 'Tento úèet bol suspendovaný z dôvodu veµkého mnoŸsta chybových prihlasení. <br />Prosím, skúste znovu za ' . $settings['login']['deactivatetime'] . ' sekúnd.';
$lng['error']['notallreqfieldsorerrors'] = 'Nevyplnili ste v¹etky polia, alebo sú niektoré nesprávne.';
$lng['error']['oldpasswordnotcorrect'] = 'Stará heslo nie je správne.';
$lng['error']['youcantallocatemorethanyouhave'] = 'NemôŸete vymedzi» viac prostiedkov ako sú povolené pre Vás.';
$lng['error']['mustbeurl'] = 'Nezadali ste správu alebo kompletnú URL (napr. http://vasa_domena.tlk/error404.htm)';
$lng['error']['invalidpath'] = 'Nevybrali ste správu URL (moŸno je problém so zoznamom adresárov)';
$lng['error']['stringisempty'] = 'Chýbajúce vstupné pole';
$lng['error']['stringiswrong'] = 'Nesprávne vstupné pole';
$lng['error']['myloginname'] = '\'' . $lng['login']['username'] . '\'';
$lng['error']['mypassword'] = '\'' . $lng['login']['password'] . '\'';
$lng['error']['oldpassword'] = '\'' . $lng['changepassword']['old_password'] . '\'';
$lng['error']['newpassword'] = '\'' . $lng['changepassword']['new_password'] . '\'';
$lng['error']['newpasswordconfirm'] = '\'' . $lng['changepassword']['new_password_confirm'] . '\'';
$lng['error']['newpasswordconfirmerror'] = 'Nové a potvrdzujúce heslo sa nezhodujú';
$lng['error']['myname'] = '\'' . $lng['customer']['name'] . '\'';
$lng['error']['myfirstname'] = '\'' . $lng['customer']['firstname'] . '\'';
$lng['error']['emailadd'] = '\'' . $lng['customer']['email'] . '\'';
$lng['error']['mydomain'] = '\'Domain\'';
$lng['error']['mydocumentroot'] = '\'Documentroot\'';
$lng['error']['loginnameexists'] = 'Prihlasovacie meno %s uŸ existuje';
$lng['error']['emailiswrong'] = 'E-mailová adresa obsahuje %s obsahuje neplatné znaky, alebo je nekompletná';
$lng['error']['loginnameiswrong'] = 'Prihlasovacie meno %s obsahuje neplatné znaky';
$lng['error']['userpathcombinationdupe'] = 'Kombinácia uŸívateµského mena a cesty uŸ existuje';
$lng['error']['patherror'] = 'V¹eobecná chyba! Cesta nemôŸe by» prázdna';
$lng['error']['errordocpathdupe'] = 'MoŸnos» pre cestu %s uŸ existuje';
$lng['error']['adduserfirst'] = 'Prosím, najskor vytvorte uŸívateµa';
$lng['error']['domainalreadyexists'] = 'Doména %s je uŸ priradená uŸívateµovi';
$lng['error']['nolanguageselect'] = 'Nebol vybraný jazyk.';
$lng['error']['nosubjectcreate'] = 'Pre túto E-mailovú ¹ablónu musíte zadefinova» tému.';
$lng['error']['nomailbodycreate'] = 'Pre túto E-mailovú ¹ablónu musíte zadefinova» text E-mailu.';
$lng['error']['templatenotfound'] = '©ablóna nebola nájdená.';
$lng['error']['alltemplatesdefined'] = 'NemôŸete definova» viac ¹ablón. V¹etky jazyky sú uŸ podporované.';
$lng['error']['wwwnotallowed'] = 'www nie je povolené pre subdomény.';
$lng['error']['subdomainiswrong'] = 'Subdoména obsahuje %s neplatné znaky.';
$lng['error']['domaincantbeempty'] = 'Názov domény nemôŸe by» prázdny.';
$lng['error']['domainexistalready'] = 'Doména %s uŸ existuje.';
$lng['error']['domainisaliasorothercustomer'] = 'Zvolený alias domény je buï sám doménový alias alebo patrí inému klientovi.';
$lng['error']['emailexistalready'] = 'E-maolová adresa %s uŸ existuje.';
$lng['error']['maindomainnonexist'] = 'Hlavná doména %s neexistuje.';
$lng['error']['destinationnonexist'] = 'Prosím, vytvorte Va¹e presmerovanie v polièku \'Cieµ\'.';
$lng['error']['destinationalreadyexistasmail'] = 'Presmerovanie na %s uŸ existuje s aktívnou E-mail adresou.';
$lng['error']['destinationalreadyexist'] = 'UŸ ste definovali presmerovanie na %s .';
$lng['error']['destinationiswrong'] = 'Presmerovanie %s obsahuje neplatný(é) znak(y) alebo je nekompletné.';
$lng['error']['domainname'] = $lng['domains']['domainname'];

/**
 * Questions
 */

$lng['question']['question'] = 'Otázky bezpeènosti';
$lng['question']['admin_customer_reallydelete'] = 'Naozaj chcete zmaza» klienta %s? NemoŸno vráti» spä»!';
$lng['question']['admin_domain_reallydelete'] = 'Naozaj chcete zmaza» doménu %s?';
$lng['question']['admin_domain_reallydisablesecuritysetting'] = 'Naozaj chcete deaktivova» tieto bezbeènostné nastavenias (OpenBasedir a/alebo SafeMode)?';
$lng['question']['admin_admin_reallydelete'] = 'Naozaj chcete zmaza» admina %s? KaŸdý klient a doména bude preradená hlavnému administrátorovi.';
$lng['question']['admin_template_reallydelete'] = 'Naozaj chcete zmaza» ¹ablónu \'%s\'?';
$lng['question']['domains_reallydelete'] = 'Naozaj chcete zmaza» doménu %s?';
$lng['question']['email_reallydelete'] = 'Naozaj chcete zmaza» E-mailovú adresu %s?';
$lng['question']['email_reallydelete_account'] = 'Naozaj chcete zmaza» E-mailový úèet %s?';
$lng['question']['email_reallydelete_forwarder'] = 'Naozaj chcete zmaza» presmerovanie %s?';
$lng['question']['extras_reallydelete'] = 'Naozaj chcete zmaza» ochranu adresára pre %s?';
$lng['question']['extras_reallydelete_pathoptions'] = 'Naozaj chcete zmaza» cestu moŸností pre %s?';
$lng['question']['ftp_reallydelete'] = 'Naozaj chcete zmaza» FTP úèet %s?';
$lng['question']['mysql_reallydelete'] = 'Naozaj chcete zmaza» databázu %s? NemoŸno vráti» spä»!';
$lng['question']['admin_configs_reallyrebuild'] = 'Naozaj chcete pretvori» Va¹e apache a bind (DNS) konfikuraèné súbory?';

/**
 * Mails
 */

$lng['mails']['pop_success']['mailbody'] = 'Dobrý deò,\n\nVá¹ E-mail úèet {EMAIL}\nbol úspe¹ne zaloŸený.\n\nToto je automaticky generovaný E-mail.\n Prosím, neodpovedajte naò!\n\nS pozdravom, Va¹ webhostingový partner Iga s.r.o.';
$lng['mails']['pop_success']['subject'] = 'E-mailový úèet bol úspe¹ne zaloŸený';
$lng['mails']['createcustomer']['mailbody'] = 'Dobrý deò {FIRSTNAME} {NAME},\n\ntu sú Va¹e informácie o úète:\n\nPrihlasovacie meno: {USERNAME}\nHeslo: {PASSWORD}\n\nÏakujeme,\n Iga s.r.o';
$lng['mails']['createcustomer']['subject'] = 'Informácie o úète';

/**
 * Admin
 */

$lng['admin']['overview'] = 'Prehµad';
$lng['admin']['ressourcedetails'] = 'PouŸité prostriedky';
$lng['admin']['systemdetails'] = 'Systémové údaje';
$lng['admin']['froxlordetails'] = 'Froxlor údaje';
$lng['admin']['installedversion'] = 'In¹talovaná verzia';
$lng['admin']['latestversion'] = 'Najnov¹ia verzia';
$lng['admin']['lookfornewversion']['clickhere'] = 'Vyhµadáva» pomocou webovej sloŸby';
$lng['admin']['lookfornewversion']['error'] = 'Chyba poèas èítania';
$lng['admin']['resources'] = 'Prostriedky';
$lng['admin']['customer'] = 'Klient';
$lng['admin']['customers'] = 'Klienti';
$lng['admin']['customer_add'] = 'Vytvori» klienta';
$lng['admin']['customer_edit'] = 'Upravi» klienta';
$lng['admin']['domains'] = 'Domény';
$lng['admin']['domain_add'] = 'Vytvori» doménu';
$lng['admin']['domain_edit'] = 'Upravi» doménu';
$lng['admin']['subdomainforemail'] = 'Subdomény ako E-mailové domény';
$lng['admin']['admin'] = 'Administrátor';
$lng['admin']['admins'] = 'Administrátori';
$lng['admin']['admin_add'] = 'Vytvori» administrátora';
$lng['admin']['admin_edit'] = 'Upravi» administrátora';
$lng['admin']['customers_see_all'] = 'MôŸe vidie» v¹etkých klientov?';
$lng['admin']['domains_see_all'] = 'MôŸe vidie» v¹etky domény?';
$lng['admin']['change_serversettings'] = 'MôŸe meni» nastavenia servra?';
$lng['admin']['server'] = 'Server';
$lng['admin']['serversettings'] = 'Nastavenia';
$lng['admin']['rebuildconf'] = 'Pretvori» konfikuraèné súbory';
$lng['admin']['stdsubdomain'] = '©tandardné subdomény';
$lng['admin']['stdsubdomain_add'] = 'Vytvori» ¹tandardnú subdoménu';
$lng['admin']['deactivated'] = 'Deaktivové';
$lng['admin']['deactivated_user'] = 'Dektivova» uŸívateµa';
$lng['admin']['sendpassword'] = 'Zasla» heslo';
$lng['admin']['ownvhostsettings'] = 'Vlastné vHost-Nastavenia';
$lng['admin']['configfiles']['serverconfiguration'] = 'Nastavenia';
$lng['admin']['configfiles']['files'] = '<b>Konfiguraèné súbory:</b> Prosím, zmeòte nasledovné súbory alebo ak neexistujú,<br />vytvorte v nich nasledujúci obsah.<br /><b>V¹imnite si:</b> MySQL heslo nemôŸe by» z bezpeènostných dôvodov zmenené.<br />Prosím nahraïte &quot;MYSQL_PASSWORD&quot; Va¹ím vlastným. Ak ste zabudli Va¹e MySQL heslo,<br />nájdete ho v &quot;lib/userdata.inc.php&quot;.';
$lng['admin']['configfiles']['commands'] = '<b>Príkazy:</b> Prosím vykonajte nasledovné príkazy v príkazovom riadku.';
$lng['admin']['configfiles']['restart'] = '<b>Re¹tart:</b> Prosím vykonajte následovné príkazy v príkazovom riadku v presnom poradí, aby sa naèítali nové nastavenia.';
$lng['admin']['templates']['templates'] = '©ablóny';
$lng['admin']['templates']['template_add'] = 'Prida» ¹ablónu';
$lng['admin']['templates']['template_edit'] = 'Upravi» ¹ablónu';
$lng['admin']['templates']['action'] = 'Akcia';
$lng['admin']['templates']['email'] = 'E-Mail';
$lng['admin']['templates']['subject'] = 'Predmet';
$lng['admin']['templates']['mailbody'] = 'Telo správy';
$lng['admin']['templates']['createcustomer'] = 'Uvítací E-mail pre nového klienta';
$lng['admin']['templates']['pop_success'] = 'Uvítací E-mail pre nov» E-mailový úèet';
$lng['admin']['templates']['template_replace_vars'] = 'Premenné nahradzované v ¹ablónach:';
$lng['admin']['templates']['FIRSTNAME'] = 'Nahradi» krstným menom klienta.';
$lng['admin']['templates']['NAME'] = 'Nahradi» menom klienta.';
$lng['admin']['templates']['USERNAME'] = 'Nahradi» menom úètu klienta.';
$lng['admin']['templates']['PASSWORD'] = 'Nahradi» heslom úètu klienta.';
$lng['admin']['templates']['EMAIL'] = 'Nahradi» adresou POP3/IMAP úètu.';

/**
 * Serversettings
 */

$lng['serversettings']['session_timeout']['title'] = 'Èasový limit sedenia';
$lng['serversettings']['session_timeout']['description'] = 'Ako dlho má by» uŸívateµ neaktívny predtým, ako sa pripojenie stane neplatným (v sekundách)?';
$lng['serversettings']['accountprefix']['title'] = 'Prefix klienta';
$lng['serversettings']['accountprefix']['description'] = 'Aký prefix môŸu ma» klientské úèty?';
$lng['serversettings']['mysqlprefix']['title'] = 'SQL Prefix';
$lng['serversettings']['mysqlprefix']['description'] = 'Aký prefix majú ma» mySQL úèty?';
$lng['serversettings']['ftpprefix']['title'] = 'FTP Prefix';
$lng['serversettings']['ftpprefix']['description'] = 'Aký prefix majú ma»  FTP úèty?';
$lng['serversettings']['documentroot_prefix']['title'] = 'Adresár dokumentov';
$lng['serversettings']['documentroot_prefix']['description'] = 'Kde majú by» ukladané v¹etky dáta?';
$lng['serversettings']['logfiles_directory']['title'] = 'Adresár súborov s logmi';
$lng['serversettings']['logfiles_directory']['description'] = 'Kde majú by» ukladané v¹etky log súbory?';
$lng['serversettings']['ipaddress']['title'] = 'IP-Addresy';
$lng['serversettings']['ipaddress']['description'] = 'Aká je IP adresa tohto servera?';
$lng['serversettings']['hostname']['title'] = 'Názov hosta';
$lng['serversettings']['hostname']['description'] = 'Aký je názov hosta tohto servera?';
$lng['serversettings']['apachereload_command']['title'] = 'Príkaz na pretvorenie (reload) Apache';
$lng['serversettings']['apachereload_command']['description'] = 'Aký je príkaz na pretvorenie (reload) Apache?';
$lng['serversettings']['bindconf_directory']['title'] = 'Adresár konfigurácie bind (DNS)';
$lng['serversettings']['bindconf_directory']['description'] = 'Kde sa nachádzajú konfiguraèné súbory pre bind (DNS)?';
$lng['serversettings']['bindreload_command']['title'] = 'Príkaz na pretvorenie (reload) bind';
$lng['serversettings']['bindreload_command']['description'] = 'Aký je príkaz na pretvorenie (reload) bind (DNS)?';
$lng['serversettings']['binddefaultzone']['title'] = 'Predvolená zóna bind (DNS)';
$lng['serversettings']['binddefaultzone']['description'] = 'Aký je názov predvolenej zóny?';
$lng['serversettings']['vmail_uid']['title'] = 'Uid E-mailov (Mails-Uid)';
$lng['serversettings']['vmail_uid']['description'] = 'Ktoré ID uŸívateµa môŸu ma» E-mail?';
$lng['serversettings']['vmail_gid']['title'] = 'Mails-Gid';
$lng['serversettings']['vmail_gid']['description'] = 'Ktoré ID skupiny môŸu ma» E-mail?';
$lng['serversettings']['vmail_homedir']['title'] = 'Domovský adresár pre E-maily';
$lng['serversettings']['vmail_homedir']['description'] = 'Kde majú by» ukladané v¹etky E-maily?';
$lng['serversettings']['adminmail']['title'] = 'Odosielateµ';
$lng['serversettings']['adminmail']['description'] = 'Aká je adresa odosielateµa pre E-maily odoslané z panela?';
$lng['serversettings']['phpmyadmin_url']['title'] = 'URL pre phpMyAdmin';
$lng['serversettings']['phpmyadmin_url']['description'] = 'Aká je URL pre phpMyAdmin? (musí zaèína» s http://)';
$lng['serversettings']['webmail_url']['title'] = 'URL pre WebMail';
$lng['serversettings']['webmail_url']['description'] = 'Aká je URL pre WebMail? (musí zaèína» s http://)';
$lng['serversettings']['webftp_url']['title'] = 'URL pre WebFTP';
$lng['serversettings']['webftp_url']['description'] = 'Aká je URL WebFTP? (musí zaèína» s http://)';
$lng['serversettings']['language']['description'] = 'Aký je ¹tandardný jazyk servera?';
$lng['serversettings']['maxloginattempts']['title'] = 'Maximálny poèet pokusov o prihlásenia';
$lng['serversettings']['maxloginattempts']['description'] = 'Maximálny poèet pokusov o prihlásenia po ktorých bude úèet deaktivovaný.';
$lng['serversettings']['deactivatetime']['title'] = 'Dátum/èas deaktivácie';
$lng['serversettings']['deactivatetime']['description'] = 'Èas v sekundách, za ktorý sa úèet deaktivuje po mnoŸstve pokusov o prihlásenie.';
$lng['serversettings']['pathedit']['title'] = 'Zadajte názov vstupu';
$lng['serversettings']['pathedit']['description'] = 'MôŸe by» cest zvolená z vyskakovacieho menu alebo zadaná do pola?';

/**
 * CHANGED BETWEEN 1.2.12 and 1.2.13
 */

$lng['mysql']['description'] = 'Tu môŸete vytvára» a meni» Va¹e MySQL databázy.<br />Zmeny sú okamŸité a úèty môŸete pouŸíva» ihneï.<br />Na µavej strane sa nachádza menu, v ktorom je nástroj phpMyAdmin, cez ktorý môŸete rýchlo a jednoducho spravova» Va¹e databázy.<br /><br />Pre pouŸitie Va¹ích databáz vo Va¹ích PHP skriptoch pouŸite nasledujúce nastavenia: (Informácie oznaèené <i>lomeným písmom</i>, musia by» zmenené na Va¹e prístupové údaje!)<br />Názov hosta: <b>localhost</b><br />UŸívateµské meno: <b><i>Názov_databázy</i></b><br />Heslo: <b><i>heslo, ktoré ste si zvolili</i></b><br />Databáza: <b><i>Názov_databázy';

/**
 * ADDED BETWEEN 1.2.12 and 1.2.13
 */

$lng['admin']['cronlastrun'] = 'Posledný Cron';
$lng['serversettings']['paging']['title'] = 'Záznamov na stránku';
$lng['serversettings']['paging']['description'] = 'Koµko záznamov bude zobrazených na jednej stránke? (0 = zakázané stránkovanie)';
$lng['error']['ipstillhasdomains'] = 'IP/Port kombinácia ktorú chcete zmaza» má stále priradené domenény. Pred zmazaním tejto IP/Port kombinácie prosím znovu priraïte tieto k ostatným IP/Port kombináciam.';
$lng['error']['cantdeletedefaultip'] = 'NemôŸete zmaza» predvolenú reseller IP/Port kombináciu. Pred zmazaním tejto IP/Port kombinácie prosím vytvorte inú predvolenú IP/Port kombináciu pre resellerov.';
$lng['error']['cantdeletesystemip'] = 'NemôŸete zmaza» poslednú IP systému, ani vytvori» ïaµ¹iu novú IP/Port kombináciu pre IP systém alebo zmeni» systémovú IP.';
$lng['error']['myipaddress'] = '\'IP\'';
$lng['error']['myport'] = '\'Port\'';
$lng['error']['myipdefault'] = 'Musíte vybra» kombináciu IP/Port ktorá sa stane predvolenou.';
$lng['error']['myipnotdouble'] = 'Táto kombinácia IP/Port uŸ existuje.';
$lng['question']['admin_ip_reallydelete'] = 'Naozaj chcete zmaza» IP adresu %s?';
$lng['admin']['ipsandports']['ipsandports'] = 'IP a Port(y)';
$lng['admin']['ipsandports']['add'] = 'Prida» IP/Port';
$lng['admin']['ipsandports']['edit'] = 'Upravi»t IP/Port';
$lng['admin']['ipsandports']['ipandport'] = 'IP/Port';
$lng['admin']['ipsandports']['ip'] = 'IP';
$lng['admin']['ipsandports']['port'] = 'Port';

// ADDED IN 1.2.13-rc3

$lng['error']['cantchangesystemip'] = 'NemôŸete zmeni» poslednú IP systému, ani vytvori» ïaµ¹iu novú IP/Port kombináciu pre IP systém alebo zmeni» systémovú IP.';
$lng['question']['admin_domain_reallydocrootoutofcustomerroot'] = 'Are you sure, you want the document root for this domain, not being within the customerroot of the customer?';

// ADDED IN 1.2.14-rc1

$lng['admin']['memorylimitdisabled'] = 'Zakázaný';
$lng['domain']['openbasedirpath'] = 'OpenBasedir cesta';
$lng['domain']['docroot'] = 'Cesta z pola vy¹¹ie';
$lng['domain']['homedir'] = 'Domovský adresár';
$lng['admin']['valuemandatory'] = 'Táto hodnota je povinná';
$lng['admin']['valuemandatorycompany'] = 'Oboje &quot;meno&quot; a &quot;priezvisko&quot; alebo &quot;spoloènos»&quot; musia by» vyplnené';
$lng['menue']['main']['username'] = 'Prihlásený ako: ';
$lng['panel']['urloverridespath'] = 'URL (nadradená cesta)';
$lng['panel']['pathorurl'] = 'Cesta alebo URL';
$lng['error']['sessiontimeoutiswrong'] = 'Je povolený len èíselný &quot;èasový limit sedenia&quot;.';
$lng['error']['maxloginattemptsiswrong'] = 'Je povolený len èíselný &quot;maximálny poèet prihlásení&quot;.';
$lng['error']['deactivatetimiswrong'] = 'Je povolený len èíselný &quot;èas deaktivácie&quot;.';
$lng['error']['accountprefixiswrong'] = '&quot;Prefix klienta&quot; je nesprávny.';
$lng['error']['mysqlprefixiswrong'] = '&quot;SQL prefix&quot; je nesprávny.';
$lng['error']['ftpprefixiswrong'] = '&quot;FTP prefix&quot; je nesprávny.';
$lng['error']['ipiswrong'] = '&quot;IP-Adresa&quot; je nesprávna. Je povolená len platná IP-adresa.';
$lng['error']['vmailuidiswrong'] = '&quot;Mails-uid&quot; je nesprávne. Je povolené len èíselné UID.';
$lng['error']['vmailgidiswrong'] = '&quot;Mails-gid&quot; je nesprávne. Je povolené len èíselné GID.';
$lng['error']['adminmailiswrong'] = '&quot;Adresa odosielateµa&quot; je nesprávna. Je povolená len platná E-mail-adresa.';
$lng['error']['pagingiswrong'] = 'Hodnota &quot;záznamov na stránku&quot je neplatná. Sú povolené len èíselné znaky.';
$lng['error']['phpmyadminiswrong'] = 'phpMyAdmin odkaz nie je platným odkazov.';
$lng['error']['webmailiswrong'] = 'WebMail odkaz nie je platým odkazom.';
$lng['error']['webftpiswrong'] = 'WebFTP odkaz nie je platým odkazom.';
$lng['domains']['hasaliasdomains'] = 'Má alias domény(én)';
$lng['serversettings']['defaultip']['title'] = 'Predvolený IP/Port';
$lng['serversettings']['defaultip']['description'] = 'Èo je predvolená IP/Port kombinácia?';
$lng['domains']['statstics'] = 'PouŸi» ¹tatistiky';
$lng['panel']['ascending'] = 'Vzostupne';
$lng['panel']['decending'] = 'Zostupne';
$lng['panel']['search'] = 'Vyhµada»';
$lng['panel']['used'] = 'pouŸité';

// ADDED IN 1.2.14-rc3

$lng['panel']['translator'] = 'Prekladaè';

// ADDED IN 1.2.14-rc4

$lng['error']['stringformaterror'] = 'Hodnota pre pole &quot;%s&quot; nie je v oèakávanom formáte.';

// ADDED IN 1.2.15-rc1

$lng['admin']['serversoftware'] = 'Server software';
$lng['admin']['phpversion'] = 'PHP verzia';
$lng['admin']['phpmemorylimit'] = 'PHP Memory Limit';
$lng['admin']['mysqlserverversion'] = 'MySQL Server verzia';
$lng['admin']['mysqlclientversion'] = 'MySQL Client verzia';
$lng['admin']['webserverinterface'] = 'Webserver rozhranie';
$lng['domains']['isassigneddomain'] = 'Je priradenou doménou';
$lng['serversettings']['phpappendopenbasedir']['title'] = 'Cesty na pripojenie k OpenBasedir';
$lng['serversettings']['phpappendopenbasedir']['description'] = 'Tieto cesty (oddelené dvojbodkou) budú pridané do OpenBasedir príkazu (statement) v kaŸdom vhost-zázobníku (container).';

// CHANGED IN 1.2.15-rc1

$lng['error']['loginnameissystemaccount'] = 'NemôŸete vytvori» úèet, ktorý je podobný systémovému úètu (napríklad zaènite s &quot;%s&quot;). Prosím, zadajte iný názov úètu.';

?>
