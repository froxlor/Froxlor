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
 *
 */

/**
 * Global
 */

$lng['translator'] = 'Drakeman';
$lng['panel']['edit'] = 'Upravi�';
$lng['panel']['delete'] = 'Zmaza�';
$lng['panel']['create'] = 'Vytvori�';
$lng['panel']['save'] = 'Ulo�i�';
$lng['panel']['yes'] = '�no';
$lng['panel']['no'] = 'Nie';
$lng['panel']['emptyfornochanges'] = 'Ak pol��ko nevypln�te, ostane bez zmien';
$lng['panel']['emptyfordefault'] = 'Ak pol��ko nevypln�te, ostane nastaven� ako predvolen�';
$lng['panel']['path'] = 'Cesta';
$lng['panel']['toggle'] = 'Prepn�';
$lng['panel']['next'] = '�al�ie';
$lng['panel']['dirsmissing'] = 'Nepodarilo sa n�js� uveden� adres�r!';

/**
 * Login
 */

$lng['login']['username'] = 'U��vate�sk� meno';
$lng['login']['password'] = 'Heslo';
$lng['login']['language'] = 'Jazyk';
$lng['login']['login'] = 'Prihl�si�';
$lng['login']['logout'] = 'Odl�si�';
$lng['login']['profile_lng'] = 'Jazyk profilu';

/**
 * Customer
 */

$lng['customer']['documentroot'] = 'Domovsk� adres�r (root)';
$lng['customer']['name'] = 'Priezvisko';
$lng['customer']['firstname'] = 'Meno';
$lng['customer']['company'] = 'Spolo�nos�';
$lng['customer']['street'] = 'Ulica';
$lng['customer']['zipcode'] = 'PS�';
$lng['customer']['city'] = 'Mesto';
$lng['customer']['phone'] = 'Tel.';
$lng['customer']['fax'] = 'Fax';
$lng['customer']['email'] = 'E-mail';
$lng['customer']['customernumber'] = 'ID klienta';
$lng['customer']['diskspace'] = 'Diskov� priestor (MB)';
$lng['customer']['traffic'] = 'Traffic/prenos (GB)';
$lng['customer']['mysqls'] = 'MySQL-Datab�zy';
$lng['customer']['emails'] = 'E-mailov� adresy';
$lng['customer']['accounts'] = 'E-mailov� ��ty';
$lng['customer']['forwarders'] = 'E-mailov� presmerovania';
$lng['customer']['ftps'] = 'FTP-��ty';
$lng['customer']['subdomains'] = 'SubDom�na(y)';
$lng['customer']['domains'] = 'Dom�na(y)';
$lng['customer']['unlimited'] = 'Neobmedzen�';

/**
 * Customermenue
 */

$lng['menue']['main']['main'] = 'Hlavn� menu';
$lng['menue']['main']['changepassword'] = 'Zmeni� heslo';
$lng['menue']['main']['changelanguage'] = 'Zmeni� jazyk';
$lng['menue']['email']['email'] = 'E-mail';
$lng['menue']['email']['emails'] = 'Adresy';
$lng['menue']['email']['webmail'] = 'WebMail';
$lng['menue']['mysql']['mysql'] = 'MySQL';
$lng['menue']['mysql']['databases'] = 'Datab�zy';
$lng['menue']['mysql']['phpmyadmin'] = 'phpMyAdmin';
$lng['menue']['domains']['domains'] = 'Dom�ny';
$lng['menue']['domains']['settings'] = 'Nastavenia';
$lng['menue']['ftp']['ftp'] = 'FTP';
$lng['menue']['ftp']['accounts'] = '��ty';
$lng['menue']['ftp']['webftp'] = 'WebFTP';
$lng['menue']['extras']['extras'] = '�peci�lne';
$lng['menue']['extras']['directoryprotection'] = 'Ochrana adres�rov';
$lng['menue']['extras']['pathoptions'] = 'Mo�nosti cesty';

/**
 * Index
 */

$lng['index']['customerdetails'] = 'Detaily klienta';
$lng['index']['accountdetails'] = 'Detaily ��tu';

/**
 * Change Password
 */

$lng['changepassword']['old_password'] = 'Star� heslo';
$lng['changepassword']['new_password'] = 'Nov� heslo';
$lng['changepassword']['new_password_confirm'] = 'Potvr�te nov� heslo';
$lng['changepassword']['new_password_ifnotempty'] = 'Nov� heslo (pr�zdne = bez zmeny)';
$lng['changepassword']['also_change_ftp'] = ' Tie� zmeni� heslo FTP ��tu';

/**
 * Domains
 */

$lng['domains']['description'] = 'Tu m��ete nastavi� a vytvori� subdom�ny a zmeni� ich cestu k adres�ru, kde maj� smerova�.<br />Syst�m bude potrebova� nieko�ko m�lo min�t na uskuto�nenie zmien (pribli�ne 5 min).';
$lng['domains']['domainsettings'] = 'Nastavenia dom�ny';
$lng['domains']['domainname'] = 'N�zov dom�ny';
$lng['domains']['subdomain_add'] = 'Vytvori� subdom�nu';
$lng['domains']['subdomain_edit'] = 'Upravi� subdom�nu';
$lng['domains']['wildcarddomain'] = 'Vytvori� dom�nu ako wildcarddomain <br />(v�etky subdom�ny smeruj� do root adres�ra hlavnej dom�ny)?';
$lng['domains']['aliasdomain'] = 'Alias pre dom�nu';
$lng['domains']['noaliasdomain'] = '�iaden alias pre dom�nu';

/**
 * E-mails
 */

$lng['emails']['description'] = 'Tu m��ete vytvori� a zmeni� Va�e E-mailov� adresy.<br />E-mail ��et je ako Va�a po�tov� schr�nka v dome. Ak V�m niekto po�le E-mail, bude vlo�en� do V�ho ��tu.<br /><br />Pre stiahnutie Va��ch E-mailov pou�ite do V�ho mailov�ho programu nasleduj�ce nastavenia: (Inform�cie ozna�en� <i>lomen�m p�smom</i>, musia by� zmenen� na Va�e pr�stupov� �daje!)<br />N�zov hosta: <b><i>N�zov dom�ny</i></b><br />U��vate�sk� meno: <b><i>N�zov ��tu / E-mailov� adresa</i></b><br />Heslo: <b><i>heslo, ktor� ste si zvolili</i></b>';
$lng['emails']['emailaddress'] = 'E-mailov� adresa';
$lng['emails']['emails_add'] = 'Vytvori� E-mailov� adresu';
$lng['emails']['emails_edit'] = 'Upravi� E-mailov� adresu';
$lng['emails']['catchall'] = 'Dom�nov� k��';
$lng['emails']['iscatchall'] = 'Definova� ako dom�nov� k��?';
$lng['emails']['account'] = '��et';
$lng['emails']['account_add'] = 'Vytvori� ��et';
$lng['emails']['account_delete'] = 'Vymaza� ��et';
$lng['emails']['from'] = 'Zdroj';
$lng['emails']['to'] = 'Cie�';
$lng['emails']['forwarders'] = 'Presmerovania';
$lng['emails']['forwarder_add'] = 'Vytvori� presmerovanie';

/**
 * FTP
 */

$lng['ftp']['description'] = 'Tu m��ete vytvori� a zmeni� Va�e FTP ��ty.<br />Zmeny s� okam�it� a ��ty m��ete pou��va� ihne�.';
$lng['ftp']['account_add'] = 'Vytvori� FTP ��et';

/**
 * MySQL
 */

$lng['mysql']['databasename'] = 'U��vate�/N�zov datab�zy';
$lng['mysql']['databasedescription'] = 'Popis datab�zy';
$lng['mysql']['database_create'] = 'Vytvori� datab�zu';

/**
 * Extras
 */

$lng['extras']['description'] = 'Tu m��ete prid�va� �a��ie doplnky, napr�klad ochranu s�borov.<br />Syst�m bude potrebova� nieko�ko m�lo min�t na uskuto�nenie zmien (pribli�ne 5 min).';
$lng['extras']['directoryprotection_add'] = 'Prida� ochranu adres�ra';
$lng['extras']['view_directory'] = 'Zobrazi� obsah adres�ra';
$lng['extras']['pathoptions_add'] = 'Prida� mo�nosti cesty';
$lng['extras']['directory_browsing'] = 'Prezeranie obsahu adres�ru';
$lng['extras']['pathoptions_edit'] = 'Upravi� mo�nosti cesty';
$lng['extras']['error404path'] = '404';
$lng['extras']['error403path'] = '403';
$lng['extras']['error500path'] = '500';
$lng['extras']['error401path'] = '401';
$lng['extras']['errordocument404path'] = 'URL pre Chybov� Dokument 404';
$lng['extras']['errordocument403path'] = 'URL pre Chybov� Dokument 403';
$lng['extras']['errordocument500path'] = 'URL pre Chybov� Dokument 500';
$lng['extras']['errordocument401path'] = 'URL pre Chybov� Dokument 401';

/**
 * Errors
 */

$lng['error']['error'] = 'Chyba';
$lng['error']['directorymustexist'] = 'Adres�r %s mus� existova�. Pros�m, vytvorte ho pou�it�m FTP klienta.';
$lng['error']['filemustexist'] = 'S�bor %s mus� existova�.';
$lng['error']['allresourcesused'] = 'U� ste pou�ili v�etky Va�e zdroje (mo�nosti).';
$lng['error']['domains_cantdeletemaindomain'] = 'Nem��ete vymaza� dom�nu, ktor� sa pou��va ako E-mailov� dom�na.';
$lng['error']['domains_canteditdomain'] = 'Nem��ete upravi� t�to dom�nu. Bola zablokovan� admininistr�torom.';
$lng['error']['domains_cantdeletedomainwithemail'] = 'Nem��ete vymaza� dom�nu, ktor� sa pou��va ako E-mailov� dom�na. Najsk�r zma�te v�etky E-mailov� adresy.';
$lng['error']['firstdeleteallsubdomains'] = 'Pred vytvoren�m wildcard dom�ny najsk�r mus�te vymaza� v�etky subdom�ny.';
$lng['error']['youhavealreadyacatchallforthisdomain'] = 'Pre t�to dom�nu ste u� dom�nov� k�� nadefinovali.';
$lng['error']['ftp_cantdeletemainaccount'] = 'Nem��ete vymaza� V� hlavn� FTP ��et';
$lng['error']['login'] = 'U��vate�sk� meno alebo heslo, ktor� ste zadali je nespr�vne. Pros�m, sk�ste znovu!';
$lng['error']['login_blocked'] = 'Tento ��et bol suspendovan� z d�vodu ve�k�ho mno�sta chybov�ch prihlasen�. <br />Pros�m, sk�ste znovu za ' . $settings['login']['deactivatetime'] . ' sek�nd.';
$lng['error']['notallreqfieldsorerrors'] = 'Nevyplnili ste v�etky polia, alebo s� niektor� nespr�vne.';
$lng['error']['oldpasswordnotcorrect'] = 'Star� heslo nie je spr�vne.';
$lng['error']['youcantallocatemorethanyouhave'] = 'Nem��ete vymedzi� viac prostiedkov ako s� povolen� pre V�s.';
$lng['error']['mustbeurl'] = 'Nezadali ste spr�vu alebo kompletn� URL (napr. http://vasa_domena.tlk/error404.htm)';
$lng['error']['invalidpath'] = 'Nevybrali ste spr�vu URL (mo�no je probl�m so zoznamom adres�rov)';
$lng['error']['stringisempty'] = 'Ch�baj�ce vstupn� pole';
$lng['error']['stringiswrong'] = 'Nespr�vne vstupn� pole';
$lng['error']['myloginname'] = '\'' . $lng['login']['username'] . '\'';
$lng['error']['mypassword'] = '\'' . $lng['login']['password'] . '\'';
$lng['error']['oldpassword'] = '\'' . $lng['changepassword']['old_password'] . '\'';
$lng['error']['newpassword'] = '\'' . $lng['changepassword']['new_password'] . '\'';
$lng['error']['newpasswordconfirm'] = '\'' . $lng['changepassword']['new_password_confirm'] . '\'';
$lng['error']['newpasswordconfirmerror'] = 'Nov� a potvrdzuj�ce heslo sa nezhoduj�';
$lng['error']['myname'] = '\'' . $lng['customer']['name'] . '\'';
$lng['error']['myfirstname'] = '\'' . $lng['customer']['firstname'] . '\'';
$lng['error']['emailadd'] = '\'' . $lng['customer']['email'] . '\'';
$lng['error']['mydomain'] = '\'Domain\'';
$lng['error']['mydocumentroot'] = '\'Documentroot\'';
$lng['error']['loginnameexists'] = 'Prihlasovacie meno %s u� existuje';
$lng['error']['emailiswrong'] = 'E-mailov� adresa obsahuje %s obsahuje neplatn� znaky, alebo je nekompletn�';
$lng['error']['loginnameiswrong'] = 'Prihlasovacie meno %s obsahuje neplatn� znaky';
$lng['error']['userpathcombinationdupe'] = 'Kombin�cia u��vate�sk�ho mena a cesty u� existuje';
$lng['error']['patherror'] = 'V�eobecn� chyba! Cesta nem��e by� pr�zdna';
$lng['error']['errordocpathdupe'] = 'Mo�nos� pre cestu %s u� existuje';
$lng['error']['adduserfirst'] = 'Pros�m, najskor vytvorte u��vate�a';
$lng['error']['domainalreadyexists'] = 'Dom�na %s je u� priraden� u��vate�ovi';
$lng['error']['nolanguageselect'] = 'Nebol vybran� jazyk.';
$lng['error']['nosubjectcreate'] = 'Pre t�to E-mailov� �abl�nu mus�te zadefinova� t�mu.';
$lng['error']['nomailbodycreate'] = 'Pre t�to E-mailov� �abl�nu mus�te zadefinova� text E-mailu.';
$lng['error']['templatenotfound'] = '�abl�na nebola n�jden�.';
$lng['error']['alltemplatesdefined'] = 'Nem��ete definova� viac �abl�n. V�etky jazyky s� u� podporovan�.';
$lng['error']['wwwnotallowed'] = 'www nie je povolen� pre subdom�ny.';
$lng['error']['subdomainiswrong'] = 'Subdom�na obsahuje %s neplatn� znaky.';
$lng['error']['domaincantbeempty'] = 'N�zov dom�ny nem��e by� pr�zdny.';
$lng['error']['domainexistalready'] = 'Dom�na %s u� existuje.';
$lng['error']['domainisaliasorothercustomer'] = 'Zvolen� alias dom�ny je bu� s�m dom�nov� alias alebo patr� in�mu klientovi.';
$lng['error']['emailexistalready'] = 'E-maolov� adresa %s u� existuje.';
$lng['error']['maindomainnonexist'] = 'Hlavn� dom�na %s neexistuje.';
$lng['error']['destinationnonexist'] = 'Pros�m, vytvorte Va�e presmerovanie v poli�ku \'Cie�\'.';
$lng['error']['destinationalreadyexistasmail'] = 'Presmerovanie na %s u� existuje s akt�vnou E-mail adresou.';
$lng['error']['destinationalreadyexist'] = 'U� ste definovali presmerovanie na %s .';
$lng['error']['destinationiswrong'] = 'Presmerovanie %s obsahuje neplatn�(�) znak(y) alebo je nekompletn�.';
$lng['error']['domainname'] = $lng['domains']['domainname'];

/**
 * Questions
 */

$lng['question']['question'] = 'Ot�zky bezpe�nosti';
$lng['question']['admin_customer_reallydelete'] = 'Naozaj chcete zmaza� klienta %s? Nemo�no vr�ti� sp�!';
$lng['question']['admin_domain_reallydelete'] = 'Naozaj chcete zmaza� dom�nu %s?';
$lng['question']['admin_domain_reallydisablesecuritysetting'] = 'Naozaj chcete deaktivova� tieto bezbe�nostn� nastavenias (OpenBasedir a/alebo SafeMode)?';
$lng['question']['admin_admin_reallydelete'] = 'Naozaj chcete zmaza� admina %s? Ka�d� klient a dom�na bude preraden� hlavn�mu administr�torovi.';
$lng['question']['admin_template_reallydelete'] = 'Naozaj chcete zmaza� �abl�nu \'%s\'?';
$lng['question']['domains_reallydelete'] = 'Naozaj chcete zmaza� dom�nu %s?';
$lng['question']['email_reallydelete'] = 'Naozaj chcete zmaza� E-mailov� adresu %s?';
$lng['question']['email_reallydelete_account'] = 'Naozaj chcete zmaza� E-mailov� ��et %s?';
$lng['question']['email_reallydelete_forwarder'] = 'Naozaj chcete zmaza� presmerovanie %s?';
$lng['question']['extras_reallydelete'] = 'Naozaj chcete zmaza� ochranu adres�ra pre %s?';
$lng['question']['extras_reallydelete_pathoptions'] = 'Naozaj chcete zmaza� cestu mo�nost� pre %s?';
$lng['question']['ftp_reallydelete'] = 'Naozaj chcete zmaza� FTP ��et %s?';
$lng['question']['mysql_reallydelete'] = 'Naozaj chcete zmaza� datab�zu %s? Nemo�no vr�ti� sp�!';
$lng['question']['admin_configs_reallyrebuild'] = 'Naozaj chcete pretvori� Va�e apache a bind (DNS) konfikura�n� s�bory?';

/**
 * Mails
 */

$lng['mails']['pop_success']['mailbody'] = 'Dobr� de�,\n\nV� E-mail ��et {EMAIL}\nbol �spe�ne zalo�en�.\n\nToto je automaticky generovan� E-mail.\n Pros�m, neodpovedajte na�!\n\nS pozdravom, Va� webhostingov� partner Iga s.r.o.';
$lng['mails']['pop_success']['subject'] = 'E-mailov� ��et bol �spe�ne zalo�en�';
$lng['mails']['createcustomer']['mailbody'] = 'Dobr� de� {FIRSTNAME} {NAME},\n\ntu s� Va�e inform�cie o ��te:\n\nPrihlasovacie meno: {USERNAME}\nHeslo: {PASSWORD}\n\n�akujeme,\n Iga s.r.o';
$lng['mails']['createcustomer']['subject'] = 'Inform�cie o ��te';

/**
 * Admin
 */

$lng['admin']['overview'] = 'Preh�ad';
$lng['admin']['ressourcedetails'] = 'Pou�it� prostriedky';
$lng['admin']['systemdetails'] = 'Syst�mov� �daje';
$lng['admin']['froxlordetails'] = 'Froxlor �daje';
$lng['admin']['installedversion'] = 'In�talovan� verzia';
$lng['admin']['latestversion'] = 'Najnov�ia verzia';
$lng['admin']['lookfornewversion']['clickhere'] = 'Vyh�ad�va� pomocou webovej slo�by';
$lng['admin']['lookfornewversion']['error'] = 'Chyba po�as ��tania';
$lng['admin']['resources'] = 'Prostriedky';
$lng['admin']['customer'] = 'Klient';
$lng['admin']['customers'] = 'Klienti';
$lng['admin']['customer_add'] = 'Vytvori� klienta';
$lng['admin']['customer_edit'] = 'Upravi� klienta';
$lng['admin']['domains'] = 'Dom�ny';
$lng['admin']['domain_add'] = 'Vytvori� dom�nu';
$lng['admin']['domain_edit'] = 'Upravi� dom�nu';
$lng['admin']['subdomainforemail'] = 'Subdom�ny ako E-mailov� dom�ny';
$lng['admin']['admin'] = 'Administr�tor';
$lng['admin']['admins'] = 'Administr�tori';
$lng['admin']['admin_add'] = 'Vytvori� administr�tora';
$lng['admin']['admin_edit'] = 'Upravi� administr�tora';
$lng['admin']['customers_see_all'] = 'M��e vidie� v�etk�ch klientov?';
$lng['admin']['domains_see_all'] = 'M��e vidie� v�etky dom�ny?';
$lng['admin']['change_serversettings'] = 'M��e meni� nastavenia servra?';
$lng['admin']['server'] = 'Server';
$lng['admin']['serversettings'] = 'Nastavenia';
$lng['admin']['rebuildconf'] = 'Pretvori� konfikura�n� s�bory';
$lng['admin']['stdsubdomain'] = '�tandardn� subdom�ny';
$lng['admin']['stdsubdomain_add'] = 'Vytvori� �tandardn� subdom�nu';
$lng['admin']['deactivated'] = 'Deaktivov�';
$lng['admin']['deactivated_user'] = 'Dektivova� u��vate�a';
$lng['admin']['sendpassword'] = 'Zasla� heslo';
$lng['admin']['ownvhostsettings'] = 'Vlastn� vHost-Nastavenia';
$lng['admin']['configfiles']['serverconfiguration'] = 'Nastavenia';
$lng['admin']['configfiles']['files'] = '<b>Konfigura�n� s�bory:</b> Pros�m, zme�te nasledovn� s�bory alebo ak neexistuj�,<br />vytvorte v nich nasleduj�ci obsah.<br /><b>V�imnite si:</b> MySQL heslo nem��e by� z bezpe�nostn�ch d�vodov zmenen�.<br />Pros�m nahra�te &quot;MYSQL_PASSWORD&quot; Va��m vlastn�m. Ak ste zabudli Va�e MySQL heslo,<br />n�jdete ho v &quot;lib/userdata.inc.php&quot;.';
$lng['admin']['configfiles']['commands'] = '<b>Pr�kazy:</b> Pros�m vykonajte nasledovn� pr�kazy v pr�kazovom riadku.';
$lng['admin']['configfiles']['restart'] = '<b>Re�tart:</b> Pros�m vykonajte n�sledovn� pr�kazy v pr�kazovom riadku v presnom porad�, aby sa na��tali nov� nastavenia.';
$lng['admin']['templates']['templates'] = '�abl�ny';
$lng['admin']['templates']['template_add'] = 'Prida� �abl�nu';
$lng['admin']['templates']['template_edit'] = 'Upravi� �abl�nu';
$lng['admin']['templates']['action'] = 'Akcia';
$lng['admin']['templates']['email'] = 'E-Mail';
$lng['admin']['templates']['subject'] = 'Predmet';
$lng['admin']['templates']['mailbody'] = 'Telo spr�vy';
$lng['admin']['templates']['createcustomer'] = 'Uv�tac� E-mail pre nov�ho klienta';
$lng['admin']['templates']['pop_success'] = 'Uv�tac� E-mail pre nov� E-mailov� ��et';
$lng['admin']['templates']['template_replace_vars'] = 'Premenn� nahradzovan� v �abl�nach:';
$lng['admin']['templates']['FIRSTNAME'] = 'Nahradi� krstn�m menom klienta.';
$lng['admin']['templates']['NAME'] = 'Nahradi� menom klienta.';
$lng['admin']['templates']['USERNAME'] = 'Nahradi� menom ��tu klienta.';
$lng['admin']['templates']['PASSWORD'] = 'Nahradi� heslom ��tu klienta.';
$lng['admin']['templates']['EMAIL'] = 'Nahradi� adresou POP3/IMAP ��tu.';

/**
 * Serversettings
 */

$lng['serversettings']['session_timeout']['title'] = '�asov� limit sedenia';
$lng['serversettings']['session_timeout']['description'] = 'Ako dlho m� by� u��vate� neakt�vny predt�m, ako sa pripojenie stane neplatn�m (v sekund�ch)?';
$lng['serversettings']['accountprefix']['title'] = 'Prefix klienta';
$lng['serversettings']['accountprefix']['description'] = 'Ak� prefix m��u ma� klientsk� ��ty?';
$lng['serversettings']['mysqlprefix']['title'] = 'SQL Prefix';
$lng['serversettings']['mysqlprefix']['description'] = 'Ak� prefix maj� ma� mySQL ��ty?';
$lng['serversettings']['ftpprefix']['title'] = 'FTP Prefix';
$lng['serversettings']['ftpprefix']['description'] = 'Ak� prefix maj� ma�  FTP ��ty?';
$lng['serversettings']['documentroot_prefix']['title'] = 'Adres�r dokumentov';
$lng['serversettings']['documentroot_prefix']['description'] = 'Kde maj� by� ukladan� v�etky d�ta?';
$lng['serversettings']['logfiles_directory']['title'] = 'Adres�r s�borov s logmi';
$lng['serversettings']['logfiles_directory']['description'] = 'Kde maj� by� ukladan� v�etky log s�bory?';
$lng['serversettings']['ipaddress']['title'] = 'IP-Addresy';
$lng['serversettings']['ipaddress']['description'] = 'Ak� je IP adresa tohto servera?';
$lng['serversettings']['hostname']['title'] = 'N�zov hosta';
$lng['serversettings']['hostname']['description'] = 'Ak� je n�zov hosta tohto servera?';
$lng['serversettings']['apachereload_command']['title'] = 'Pr�kaz na pretvorenie (reload) Apache';
$lng['serversettings']['apachereload_command']['description'] = 'Ak� je pr�kaz na pretvorenie (reload) Apache?';
$lng['serversettings']['bindconf_directory']['title'] = 'Adres�r konfigur�cie bind (DNS)';
$lng['serversettings']['bindconf_directory']['description'] = 'Kde sa nach�dzaj� konfigura�n� s�bory pre bind (DNS)?';
$lng['serversettings']['bindreload_command']['title'] = 'Pr�kaz na pretvorenie (reload) bind';
$lng['serversettings']['bindreload_command']['description'] = 'Ak� je pr�kaz na pretvorenie (reload) bind (DNS)?';
$lng['serversettings']['binddefaultzone']['title'] = 'Predvolen� z�na bind (DNS)';
$lng['serversettings']['binddefaultzone']['description'] = 'Ak� je n�zov predvolenej z�ny?';
$lng['serversettings']['vmail_uid']['title'] = 'Uid E-mailov (Mails-Uid)';
$lng['serversettings']['vmail_uid']['description'] = 'Ktor� ID u��vate�a m��u ma� E-mail?';
$lng['serversettings']['vmail_gid']['title'] = 'Mails-Gid';
$lng['serversettings']['vmail_gid']['description'] = 'Ktor� ID skupiny m��u ma� E-mail?';
$lng['serversettings']['vmail_homedir']['title'] = 'Domovsk� adres�r pre E-maily';
$lng['serversettings']['vmail_homedir']['description'] = 'Kde maj� by� ukladan� v�etky E-maily?';
$lng['serversettings']['adminmail']['title'] = 'Odosielate�';
$lng['serversettings']['adminmail']['description'] = 'Ak� je adresa odosielate�a pre E-maily odoslan� z panela?';
$lng['serversettings']['phpmyadmin_url']['title'] = 'URL pre phpMyAdmin';
$lng['serversettings']['phpmyadmin_url']['description'] = 'Ak� je URL pre phpMyAdmin? (mus� za��na� s http://)';
$lng['serversettings']['webmail_url']['title'] = 'URL pre WebMail';
$lng['serversettings']['webmail_url']['description'] = 'Ak� je URL pre WebMail? (mus� za��na� s http://)';
$lng['serversettings']['webftp_url']['title'] = 'URL pre WebFTP';
$lng['serversettings']['webftp_url']['description'] = 'Ak� je URL WebFTP? (mus� za��na� s http://)';
$lng['serversettings']['language']['description'] = 'Ak� je �tandardn� jazyk servera?';
$lng['serversettings']['maxloginattempts']['title'] = 'Maxim�lny po�et pokusov o prihl�senia';
$lng['serversettings']['maxloginattempts']['description'] = 'Maxim�lny po�et pokusov o prihl�senia po ktor�ch bude ��et deaktivovan�.';
$lng['serversettings']['deactivatetime']['title'] = 'D�tum/�as deaktiv�cie';
$lng['serversettings']['deactivatetime']['description'] = '�as v sekund�ch, za ktor� sa ��et deaktivuje po mno�stve pokusov o prihl�senie.';
$lng['serversettings']['pathedit']['title'] = 'Zadajte n�zov vstupu';
$lng['serversettings']['pathedit']['description'] = 'M��e by� cest zvolen� z vyskakovacieho menu alebo zadan� do pola?';

/**
 * CHANGED BETWEEN 1.2.12 and 1.2.13
 */

$lng['mysql']['description'] = 'Tu m��ete vytv�ra� a meni� Va�e MySQL datab�zy.<br />Zmeny s� okam�it� a ��ty m��ete pou��va� ihne�.<br />Na �avej strane sa nach�dza menu, v ktorom je n�stroj phpMyAdmin, cez ktor� m��ete r�chlo a jednoducho spravova� Va�e datab�zy.<br /><br />Pre pou�itie Va��ch datab�z vo Va��ch PHP skriptoch pou�ite nasleduj�ce nastavenia: (Inform�cie ozna�en� <i>lomen�m p�smom</i>, musia by� zmenen� na Va�e pr�stupov� �daje!)<br />N�zov hosta: <b>localhost</b><br />U��vate�sk� meno: <b><i>N�zov_datab�zy</i></b><br />Heslo: <b><i>heslo, ktor� ste si zvolili</i></b><br />Datab�za: <b><i>N�zov_datab�zy';

/**
 * ADDED BETWEEN 1.2.12 and 1.2.13
 */

$lng['serversettings']['paging']['title'] = 'Z�znamov na str�nku';
$lng['serversettings']['paging']['description'] = 'Ko�ko z�znamov bude zobrazen�ch na jednej str�nke? (0 = zak�zan� str�nkovanie)';
$lng['error']['ipstillhasdomains'] = 'IP/Port kombin�cia ktor� chcete zmaza� m� st�le priraden� domen�ny. Pred zmazan�m tejto IP/Port kombin�cie pros�m znovu prira�te tieto k ostatn�m IP/Port kombin�ciam.';
$lng['error']['cantdeletedefaultip'] = 'Nem��ete zmaza� predvolen� reseller IP/Port kombin�ciu. Pred zmazan�m tejto IP/Port kombin�cie pros�m vytvorte in� predvolen� IP/Port kombin�ciu pre resellerov.';
$lng['error']['cantdeletesystemip'] = 'Nem��ete zmaza� posledn� IP syst�mu, ani vytvori� �a��iu nov� IP/Port kombin�ciu pre IP syst�m alebo zmeni� syst�mov� IP.';
$lng['error']['myipaddress'] = '\'IP\'';
$lng['error']['myport'] = '\'Port\'';
$lng['error']['myipdefault'] = 'Mus�te vybra� kombin�ciu IP/Port ktor� sa stane predvolenou.';
$lng['error']['myipnotdouble'] = 'T�to kombin�cia IP/Port u� existuje.';
$lng['question']['admin_ip_reallydelete'] = 'Naozaj chcete zmaza� IP adresu %s?';
$lng['admin']['ipsandports']['ipsandports'] = 'IP a Port(y)';
$lng['admin']['ipsandports']['add'] = 'Prida� IP/Port';
$lng['admin']['ipsandports']['edit'] = 'Upravi�t IP/Port';
$lng['admin']['ipsandports']['ipandport'] = 'IP/Port';
$lng['admin']['ipsandports']['ip'] = 'IP';
$lng['admin']['ipsandports']['port'] = 'Port';

// ADDED IN 1.2.13-rc3

$lng['error']['cantchangesystemip'] = 'Nem��ete zmeni� posledn� IP syst�mu, ani vytvori� �a��iu nov� IP/Port kombin�ciu pre IP syst�m alebo zmeni� syst�mov� IP.';
$lng['question']['admin_domain_reallydocrootoutofcustomerroot'] = 'Are you sure, you want the document root for this domain, not being within the customerroot of the customer?';

// ADDED IN 1.2.14-rc1

$lng['admin']['memorylimitdisabled'] = 'Zak�zan�';
$lng['domain']['openbasedirpath'] = 'OpenBasedir cesta';
$lng['domain']['docroot'] = 'Cesta z pola vy��ie';
$lng['domain']['homedir'] = 'Domovsk� adres�r';
$lng['admin']['valuemandatory'] = 'T�to hodnota je povinn�';
$lng['admin']['valuemandatorycompany'] = 'Oboje &quot;meno&quot; a &quot;priezvisko&quot; alebo &quot;spolo�nos�&quot; musia by� vyplnen�';
$lng['menue']['main']['username'] = 'Prihl�sen� ako: ';
$lng['panel']['urloverridespath'] = 'URL (nadraden� cesta)';
$lng['panel']['pathorurl'] = 'Cesta alebo URL';
$lng['error']['sessiontimeoutiswrong'] = 'Je povolen� len ��seln� &quot;�asov� limit sedenia&quot;.';
$lng['error']['maxloginattemptsiswrong'] = 'Je povolen� len ��seln� &quot;maxim�lny po�et prihl�sen�&quot;.';
$lng['error']['deactivatetimiswrong'] = 'Je povolen� len ��seln� &quot;�as deaktiv�cie&quot;.';
$lng['error']['accountprefixiswrong'] = '&quot;Prefix klienta&quot; je nespr�vny.';
$lng['error']['mysqlprefixiswrong'] = '&quot;SQL prefix&quot; je nespr�vny.';
$lng['error']['ftpprefixiswrong'] = '&quot;FTP prefix&quot; je nespr�vny.';
$lng['error']['ipiswrong'] = '&quot;IP-Adresa&quot; je nespr�vna. Je povolen� len platn� IP-adresa.';
$lng['error']['vmailuidiswrong'] = '&quot;Mails-uid&quot; je nespr�vne. Je povolen� len ��seln� UID.';
$lng['error']['vmailgidiswrong'] = '&quot;Mails-gid&quot; je nespr�vne. Je povolen� len ��seln� GID.';
$lng['error']['adminmailiswrong'] = '&quot;Adresa odosielate�a&quot; je nespr�vna. Je povolen� len platn� E-mail-adresa.';
$lng['error']['pagingiswrong'] = 'Hodnota &quot;z�znamov na str�nku&quot je neplatn�. S� povolen� len ��seln� znaky.';
$lng['error']['phpmyadminiswrong'] = 'phpMyAdmin odkaz nie je platn�m odkazov.';
$lng['error']['webmailiswrong'] = 'WebMail odkaz nie je plat�m odkazom.';
$lng['error']['webftpiswrong'] = 'WebFTP odkaz nie je plat�m odkazom.';
$lng['domains']['hasaliasdomains'] = 'M� alias dom�ny(�n)';
$lng['serversettings']['defaultip']['title'] = 'Predvolen� IP/Port';
$lng['serversettings']['defaultip']['description'] = '�o je predvolen� IP/Port kombin�cia?';
$lng['domains']['statstics'] = 'Pou�i� �tatistiky';
$lng['panel']['ascending'] = 'Vzostupne';
$lng['panel']['decending'] = 'Zostupne';
$lng['panel']['search'] = 'Vyh�ada�';
$lng['panel']['used'] = 'pou�it�';

// ADDED IN 1.2.14-rc3

$lng['panel']['translator'] = 'Preklada�';

// ADDED IN 1.2.14-rc4

$lng['error']['stringformaterror'] = 'Hodnota pre pole &quot;%s&quot; nie je v o�ak�vanom form�te.';

// ADDED IN 1.2.15-rc1

$lng['admin']['serversoftware'] = 'Server software';
$lng['admin']['phpversion'] = 'PHP verzia';
$lng['admin']['phpmemorylimit'] = 'PHP Memory Limit';
$lng['admin']['mysqlserverversion'] = 'MySQL Server verzia';
$lng['admin']['mysqlclientversion'] = 'MySQL Client verzia';
$lng['admin']['webserverinterface'] = 'Webserver rozhranie';
$lng['domains']['isassigneddomain'] = 'Je priradenou dom�nou';
$lng['serversettings']['phpappendopenbasedir']['title'] = 'Cesty na pripojenie k OpenBasedir';
$lng['serversettings']['phpappendopenbasedir']['description'] = 'Tieto cesty (oddelen� dvojbodkou) bud� pridan� do OpenBasedir pr�kazu (statement) v ka�dom vhost-z�zobn�ku (container).';

// CHANGED IN 1.2.15-rc1

$lng['error']['loginnameissystemaccount'] = 'Nem��ete vytvori� ��et, ktor� je podobn� syst�mov�mu ��tu (napr�klad za�nite s &quot;%s&quot;). Pros�m, zadajte in� n�zov ��tu.';

?>
