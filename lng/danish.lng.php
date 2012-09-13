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
 * @author     Simon Clausen
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Language
 *
 */

/**
 * Global
 */

$lng['translator'] = 'Simon Clausen';
$lng['panel']['edit'] = 'editer';
$lng['panel']['delete'] = 'slet';
$lng['panel']['create'] = 'opret';
$lng['panel']['save'] = 'gem';
$lng['panel']['yes'] = 'ja';
$lng['panel']['no'] = 'nej';
$lng['panel']['emptyfornochanges'] = 'tom: ingen ændringer';
$lng['panel']['emptyfordefault'] = 'tom: standart';
$lng['panel']['path'] = 'Sti';
$lng['panel']['toggle'] = 'Skift';
$lng['panel']['next'] = 'næste';
$lng['panel']['dirsmissing'] = 'Mappe findes ikke!';
$lng['panel']['translator'] = 'Oversættelse af';

/**
 * Login
 */

$lng['login']['username'] = 'Brugernavn';
$lng['login']['password'] = 'Kodeord';
$lng['login']['language'] = 'Sprog';
$lng['login']['login'] = 'Log ind';
$lng['login']['logout'] = 'log ud';
$lng['login']['profile_lng'] = 'Profil sprog';

/**
 * Customer
 */

$lng['customer']['documentroot'] = 'Rod mappe';
$lng['customer']['name'] = 'Efternavn';
$lng['customer']['firstname'] = 'Navn';
$lng['customer']['company'] = 'Firma';
$lng['customer']['street'] = 'Adresse';
$lng['customer']['zipcode'] = 'Postnr.';
$lng['customer']['city'] = 'By';
$lng['customer']['phone'] = 'Telefon';
$lng['customer']['fax'] = 'Fax';
$lng['customer']['email'] = 'Email';
$lng['customer']['customernumber'] = 'Kunde ID';
$lng['customer']['diskspace'] = 'Plads (MB)';
$lng['customer']['traffic'] = 'Traffik (GB)';
$lng['customer']['mysqls'] = 'MySQL-Databaser';
$lng['customer']['emails'] = 'eMail-Adresser';
$lng['customer']['accounts'] = 'eMail-Kontoer';
$lng['customer']['forwarders'] = 'eMail-Videresendere';
$lng['customer']['ftps'] = 'FTP-Accounts';
$lng['customer']['subdomains'] = 'Sub-Domæne(r)';
$lng['customer']['domains'] = 'Domæne(r)';
$lng['customer']['unlimited'] = 'ubegrænset';

/**
 * Customermenue
 */

$lng['menue']['main']['main'] = 'Hjem';
$lng['menue']['main']['changepassword'] = 'ændre kodeord';
$lng['menue']['main']['changelanguage'] = 'ændre sprog';
$lng['menue']['email']['email'] = 'eMail';
$lng['menue']['email']['emails'] = 'Adresser';
$lng['menue']['email']['webmail'] = 'WebMail';
$lng['menue']['mysql']['mysql'] = 'MySQL';
$lng['menue']['mysql']['databases'] = 'Databaser';
$lng['menue']['mysql']['phpmyadmin'] = 'phpMyAdmin';
$lng['menue']['domains']['domains'] = 'Domæner';
$lng['menue']['domains']['settings'] = 'Indstillinger';
$lng['menue']['ftp']['ftp'] = 'FTP';
$lng['menue']['ftp']['accounts'] = 'Kontoer';
$lng['menue']['ftp']['webftp'] = 'WebFTP';
$lng['menue']['extras']['extras'] = 'Ekstra';
$lng['menue']['extras']['directoryprotection'] = 'Mappe beskyttelse';
$lng['menue']['extras']['pathoptions'] = 'Mappe valg';

/**
 * Index
 */

$lng['index']['customerdetails'] = 'Kunde Detaljer';
$lng['index']['accountdetails'] = 'Konto Detaljer';

/**
 * Change Password
 */

$lng['changepassword']['old_password'] = 'Old password';
$lng['changepassword']['new_password'] = 'New password';
$lng['changepassword']['new_password_confirm'] = 'Nyt kodeord (bekræft)';
$lng['changepassword']['new_password_ifnotempty'] = 'Nyt kodeord (tom = ingen ændringer)';
$lng['changepassword']['also_change_ftp'] = ' skift også kodeordet for hoved-ftp kontoen';

/**
 * Domains
 */

$lng['domains']['description'] = 'Her kan du oprette domæner og subdomæner i systemet, og ændre de stier som er tilknyttet<br />Det tager et stykke tid for ændringer at blive opdateret i systemet.';
$lng['domains']['domainsettings'] = 'Domæne indstillinger';
$lng['domains']['domainname'] = 'Domæne navn';
$lng['domains']['subdomain_add'] = 'Opræt suddomæne';
$lng['domains']['subdomain_edit'] = 'Editer (sub)domæne';
$lng['domains']['wildcarddomain'] = 'Opret som wildcarddomæne?';
$lng['domains']['aliasdomain'] = 'Domæne alias';
$lng['domains']['noaliasdomain'] = 'Intet domæne alias';

/**
 * eMails
 */

$lng['emails']['description'] = 'Her kan du oprette og ændre eMail adresser og kontoer.<br />eMail modtages af de adresser du opretter. For at kunne hente eMail skal du oprette en konto til adressen, dette gøres ved at vælge "opret konto" efter du har oprettet eMail adressen.<br />Dit email program skal konfigureres som følger: (Teksk i <i>italisk</i> skrift skal erstattes med de data du taster ind)<br />Hostname: <b><i>Domænenavn</i></b><br />Bruger: <b><i>Konto navn / eMail adresse</i></b><br />Kodeord: <b><i>kodeordet du har valgt</i></b>';
$lng['emails']['emailaddress'] = 'eMail-adresse';
$lng['emails']['emails_add'] = 'Opret eMail-adresse';
$lng['emails']['emails_edit'] = 'Editer eMail-adresse';
$lng['emails']['catchall'] = 'Fang-Alt';
$lng['emails']['iscatchall'] = 'Brug som "Fang-Alt" adresse?';
$lng['emails']['account'] = 'Konto';
$lng['emails']['account_add'] = 'Opret konto';
$lng['emails']['account_delete'] = 'Slet konto';
$lng['emails']['from'] = 'Kilde';
$lng['emails']['to'] = 'Til';
$lng['emails']['forwarders'] = 'Videresendere';
$lng['emails']['forwarder_add'] = 'Opret videresender';

/**
 * FTP
 */

$lng['ftp']['description'] = 'Her kan du oprette og ændre dine FTP kontoer.<br />ændringer bliver gennemført øjeblikeligt, og kontoerne kan straks tages i brug.';
$lng['ftp']['account_add'] = 'Opret konto';

/**
 * MySQL
 */

$lng['mysql']['databasename'] = 'bruger/database navn';
$lng['mysql']['databasedescription'] = 'database beskrivelse';
$lng['mysql']['database_create'] = 'Opret database';

/**
 * Extras
 */

$lng['extras']['description'] = 'Her kan du udføre ekstra indstillinger, for eksempel kodeords beskyttelse af mapper.<br />Det tager et stykke tid for ændringer at blive opdateret i systemet.';
$lng['extras']['directoryprotection_add'] = 'Tilføj mappe beskyttelse';
$lng['extras']['view_directory'] = 'vis mappe indhold';
$lng['extras']['pathoptions_add'] = 'tilføj regler for sti';
$lng['extras']['directory_browsing'] = 'vis mappe indhold?';
$lng['extras']['pathoptions_edit'] = 'ændre regler for sti';
$lng['extras']['error404path'] = '404';
$lng['extras']['error403path'] = '403';
$lng['extras']['error500path'] = '500';
$lng['extras']['error401path'] = '401';
$lng['extras']['errordocument404path'] = 'URL til ErrorDocument 404';
$lng['extras']['errordocument403path'] = 'URL til ErrorDocument 403';
$lng['extras']['errordocument500path'] = 'URL til ErrorDocument 500';
$lng['extras']['errordocument401path'] = 'URL til ErrorDocument 401';

/**
 * Errors
 */

$lng['error']['error'] = 'Fejl';
$lng['error']['directorymustexist'] = 'Mappen %s eksisterer ikke. Du skal oprette den via din FTP-klient.';
$lng['error']['filemustexist'] = 'Filen %s skal være oprettet.';
$lng['error']['allresourcesused'] = 'Du har brugt dine tilladte ressourcer.';
$lng['error']['domains_cantdeletemaindomain'] = 'Du kan ikke slette et eMail-domæne.';
$lng['error']['domains_canteditdomain'] = 'Du kan ikke lave ændringer i dette domæne, da det er blevet låst af administratoren.';
$lng['error']['domains_cantdeletedomainwithemail'] = 'Du kan ikke slette et domæne med tilknyttede eMail-adresser. Slet alle email adresser først.';
$lng['error']['firstdeleteallsubdomains'] = 'Du skal først slette alle sub-domæner for du kan oprette et wildcarddomæne.';
$lng['error']['youhavealreadyacatchallforthisdomain'] = 'Du har allerede valgt en Fang-Alt adresse for dette domæne.';
$lng['error']['ftp_cantdeletemainaccount'] = 'Du kan ikke slette din primære FTP konto.';
$lng['error']['login'] = 'Den indtastede bruger/kode er ikke korrekt. Forsøg venligst igen.';
$lng['error']['login_blocked'] = 'Denne konto er blevet midlertidigt lukket grundet for mange fejlagtige logind forsøg.<br />Forsøg venligst igen om ' . $settings['login']['deactivatetime'] . ' sekunder.';
$lng['error']['notallreqfieldsorerrors'] = 'Alle krævede felter er ikke udfyldt, eller der er fejl i en eller flere af udfyldningerne.';
$lng['error']['oldpasswordnotcorrect'] = 'Det gamle kodeord er ikke indtastet korrekt.';
$lng['error']['youcantallocatemorethanyouhave'] = 'Du kan ikke tildele flere ressourcer end du er blevet bevilliget.';
$lng['error']['mustbeurl'] = 'Din indtastning er ikke en gyldig URL (f.eks. http://eksempel.com/fejl404.htm)';
$lng['error']['invalidpath'] = 'Du har valgt en ikke gyldig url (måske et problem med mappe list?)';
$lng['error']['stringisempty'] = 'Manglende intasting i feltet';
$lng['error']['stringiswrong'] = 'Forkert indtastning i feltet';
$lng['error']['myloginname'] = '\'' . $lng['login']['username'] . '\'';
$lng['error']['mypassword'] = '\'' . $lng['login']['password'] . '\'';
$lng['error']['oldpassword'] = '\'' . $lng['changepassword']['old_password'] . '\'';
$lng['error']['newpassword'] = '\'' . $lng['changepassword']['new_password'] . '\'';
$lng['error']['newpasswordconfirm'] = '\'' . $lng['changepassword']['new_password_confirm'] . '\'';
$lng['error']['newpasswordconfirmerror'] = 'Det nye kodeord og kontrol indtastning stemmer ikke overens';
$lng['error']['myname'] = '\'' . $lng['customer']['name'] . '\'';
$lng['error']['myfirstname'] = '\'' . $lng['customer']['firstname'] . '\'';
$lng['error']['emailadd'] = '\'' . $lng['customer']['email'] . '\'';
$lng['error']['mydomain'] = '\'Domæne\'';
$lng['error']['mydocumentroot'] = '\'Mapperod\'';
$lng['error']['loginnameexists'] = 'Brugernavnet %s eksisterer allerede';
$lng['error']['emailiswrong'] = 'eMail-Adressen %s indeholder ugyldige tegn eller er ikke komplet';
$lng['error']['loginnameiswrong'] = 'Brugernavnet %s indeholder ugyldige tegn';
$lng['error']['userpathcombinationdupe'] = 'Kombinationen af brugernavn og sti findes allerede.';
$lng['error']['patherror'] = 'Fejl! Sti kan ikke være tom';
$lng['error']['errordocpathdupe'] = 'Indstillinger for stien %s eksisterer allerede';
$lng['error']['adduserfirst'] = 'Opret venligst en kunde først';
$lng['error']['domainalreadyexists'] = 'Domænet %s er allerede delligeret til en kunde';
$lng['error']['nolanguageselect'] = 'Ingen sprog er valgt.';
$lng['error']['nosubjectcreate'] = 'Du skal angive en overskrift for denne eMail skabelon.';
$lng['error']['nomailbodycreate'] = 'Du skal skrive et indhold til denne eMail skabelon.';
$lng['error']['templatenotfound'] = 'Skabelon blev ikke fundet.';
$lng['error']['alltemplatesdefined'] = 'Du kan ikke oprette flere skabeloner da alle sprog allerede er understøttet.';
$lng['error']['wwwnotallowed'] = 'www er ikke tilladt som sub-domæne.';
$lng['error']['subdomainiswrong'] = 'Sub-domænet %s indeholder ugyldige tegn.';
$lng['error']['domaincantbeempty'] = 'The domain-name can not be empty.';
$lng['error']['domainexistalready'] = 'Domænet %s eksisterer allerede.';
$lng['error']['domainisaliasorothercustomer'] = 'Det valgte alias-domæne er enten selv et alias domæne, eller tilhører en anden kunde.';
$lng['error']['emailexistalready'] = 'eMail-Adressen %s eksisterer allerede.';
$lng['error']['maindomainnonexist'] = 'Hoved-domænet %s eksisterer ikke.';
$lng['error']['destinationnonexist'] = 'Opret venligst videresenderen i feltet.';
$lng['error']['destinationalreadyexistasmail'] = 'Videresenderen til %s eksisterer allerede som en aktiv eMail-adresse.';
$lng['error']['destinationalreadyexist'] = 'Der er allerede angivet en videresender til %s .';
$lng['error']['destinationiswrong'] = 'Videresenderen %s indeholder ugyldige tegn eller er ikke komplet.';
$lng['error']['domainname'] = $lng['domains']['domainname'];

/**
 * Questions
 */

$lng['question']['question'] = 'Sikkerhedsspørgsmål';
$lng['question']['admin_customer_reallydelete'] = 'Er du sikker på du vil slette kunden %s? Dette kan ikke fortrydes!';
$lng['question']['admin_domain_reallydelete'] = 'Er du sikker på du vil slette domænet %s?';
$lng['question']['admin_domain_reallydisablesecuritysetting'] = 'Er du sikker på du vil deaktivere disse sikkerheds indstillinger (OpenBasedir)?';
$lng['question']['admin_admin_reallydelete'] = 'Er du sikker på du vil slette administrator %s? Alle kunder og domæner som hører hertil vil blive allokeret til øverste adminstartor.';
$lng['question']['admin_template_reallydelete'] = 'Er du sikker på du vil slette skabelonen \'%s*\'?';
$lng['question']['domains_reallydelete'] = 'Er du sikker på du vil slette domænet %s?';
$lng['question']['email_reallydelete'] = 'Er du sikker på du vil slette eMail-adressen %s?';
$lng['question']['email_reallydelete_account'] = 'Er du sikker på du vil slette eMail-account fra %s?';
$lng['question']['email_reallydelete_forwarder'] = 'Er du sikker på du vil slette videresenderen %s?';
$lng['question']['extras_reallydelete'] = 'Er du sikker på du vil slette mappe beskyttelse for %s?';
$lng['question']['extras_reallydelete_pathoptions'] = 'Er du sikker på du vil slette regler for stien %s?';
$lng['question']['ftp_reallydelete'] = 'Er du sikker på du vil slette FTP kontoen %s?';
$lng['question']['mysql_reallydelete'] = 'Er du sikker på du vil slette databasen %s? Dette kan ikke fortrydes!';
$lng['question']['admin_configs_reallyrebuild'] = 'Er du sikker på du vil genbygge dine apache og bind konfigurations filer?';

/**
 * Mails
 */

$lng['mails']['pop_success']['mailbody'] = 'Hej,\n\ndin eMail konto {EMAIL}\ner blevet oprettet.\n\nDette er en automatisk genereret\neMail, svar er ikke nødvendig!\n\nHilsen, din administrator';
$lng['mails']['pop_success']['subject'] = 'eMail konto er blevet oprettet';
$lng['mails']['createcustomer']['mailbody'] = 'Hej {FIRSTNAME} {NAME},\n\ndette er information til din konto:\n\nBruger: {USERNAME}\nKodeord: {PASSWORD}\n\nHilsen, din administrator';
$lng['mails']['createcustomer']['subject'] = 'Konto information';

/**
 * Admin
 */

$lng['admin']['overview'] = 'Oversigt';
$lng['admin']['ressourcedetails'] = 'Brugte ressourcer';
$lng['admin']['systemdetails'] = 'System Detaljer';
$lng['admin']['froxlordetails'] = 'Froxlor Detaljer';
$lng['admin']['installedversion'] = 'Installeret Version';
$lng['admin']['latestversion'] = 'Seneste Version';
$lng['admin']['lookfornewversion']['clickhere'] = 'søg via webservice';
$lng['admin']['lookfornewversion']['error'] = 'Fejl under læsning';
$lng['admin']['resources'] = 'Ressourcer';
$lng['admin']['customer'] = 'Kunde';
$lng['admin']['customers'] = 'Kunder';
$lng['admin']['customer_add'] = 'Opret kunde';
$lng['admin']['customer_edit'] = 'Editer kunde';
$lng['admin']['domains'] = 'Domæner';
$lng['admin']['domain_add'] = 'Opret domæne';
$lng['admin']['domain_edit'] = 'Editer domæne';
$lng['admin']['subdomainforemail'] = 'Subdomæner som eMaildomæner';
$lng['admin']['admin'] = 'Admin';
$lng['admin']['admins'] = 'Admins';
$lng['admin']['admin_add'] = 'Opret administrator';
$lng['admin']['admin_edit'] = 'Editer administrator';
$lng['admin']['customers_see_all'] = 'Kan se alle kunder?';
$lng['admin']['domains_see_all'] = 'Kan se alle domæner?';
$lng['admin']['change_serversettings'] = 'Kan ændre server indstillinger?';
$lng['admin']['server'] = 'Server';
$lng['admin']['serversettings'] = 'Indstillinger';
$lng['admin']['rebuildconf'] = 'Genbyg konfigurations filer';
$lng['admin']['stdsubdomain'] = 'Standart subdomæne';
$lng['admin']['stdsubdomain_add'] = 'Opret standart subdomæne';
$lng['admin']['deactivated'] = 'Deaktiveret';
$lng['admin']['deactivated_user'] = 'Deaktiver Bruger';
$lng['admin']['sendpassword'] = 'Send kodeord';
$lng['admin']['ownvhostsettings'] = 'Egne vHost-indstillinger';
$lng['admin']['configfiles']['serverconfiguration'] = 'Konfiguration';
$lng['admin']['configfiles']['files'] = '<b>Konfigurationsfiler:</b> Lav venligst ændringerne i de følgende filer eller opret<br />dem med dette indhold hvis de ikke eksisterer.<br /><b>Bemærk:</b> MySQL Kodeordet er ikke blevet ændre af sikkerhedsgrunde.<br />Udskift venligst "MYSQL_PASSWORD" manuelt. Hvis du har glemt dit MySQL kodeord<br />er det at finde i "lib/userdata.inc.php".';
$lng['admin']['configfiles']['commands'] = '<b>Kommandoer:</b> Udfør disse kommandoer i shell\'et.';
$lng['admin']['configfiles']['restart'] = '<b>Genstart:</b> Udfør disse kommandoer i shell\'et for at aktivere den nye konfiguration.';
$lng['admin']['templates']['templates'] = 'Skabeloner';
$lng['admin']['templates']['template_add'] = 'Tilføj skabelon';
$lng['admin']['templates']['template_edit'] = 'Editer skabelon';
$lng['admin']['templates']['action'] = 'Handling';
$lng['admin']['templates']['email'] = 'E-Mail';
$lng['admin']['templates']['subject'] = 'Emne';
$lng['admin']['templates']['mailbody'] = 'Mail indhold';
$lng['admin']['templates']['createcustomer'] = 'Velkomst mail for nye kunder';
$lng['admin']['templates']['pop_success'] = 'Velkomst mail for nye email kontoer';
$lng['admin']['templates']['template_replace_vars'] = 'Variabler der udskiftes i skabelonen:';
$lng['admin']['templates']['FIRSTNAME'] = 'Udskiftes med kundes navn.';
$lng['admin']['templates']['NAME'] = 'Udskiftes med kundes efternavn.';
$lng['admin']['templates']['USERNAME'] = 'Udskiftes med kundes konto brugernavn.';
$lng['admin']['templates']['PASSWORD'] = 'Udskiftes med kundes konto kodeord.';
$lng['admin']['templates']['EMAIL'] = 'Udskiftes med adressen af POP3/IMAP kontoen.';

/**
 * Serversettings
 */

$lng['serversettings']['session_timeout']['title'] = 'Sæssion Timeout';
$lng['serversettings']['session_timeout']['description'] = 'Hvor længe skal en bruger være inaktiv før sæssionen bliver ugyldig (i sekunder)?';
$lng['serversettings']['accountprefix']['title'] = 'Kundepræfiks';
$lng['serversettings']['accountprefix']['description'] = 'Hvilket præfiks skal kunde kontoer have?';
$lng['serversettings']['mysqlprefix']['title'] = 'SQL Præfiks';
$lng['serversettings']['mysqlprefix']['description'] = 'Hvilket præfiks skal MySQL databaser have?';
$lng['serversettings']['ftpprefix']['title'] = 'FTP Præfiks';
$lng['serversettings']['ftpprefix']['description'] = 'Hvilket præfiks skal FTP kontoer have?';
$lng['serversettings']['documentroot_prefix']['title'] = 'Dokument mappe';
$lng['serversettings']['documentroot_prefix']['description'] = 'Hvor skal data opbevares?';
$lng['serversettings']['logfiles_directory']['title'] = 'Logfilmappe';
$lng['serversettings']['logfiles_directory']['description'] = 'Hvor skal alle logfilerne opbevares?';
$lng['serversettings']['ipaddress']['title'] = 'IP-Adresse';
$lng['serversettings']['ipaddress']['description'] = 'Hvad er denne servers IP-adresse?';
$lng['serversettings']['hostname']['title'] = 'Hostname';
$lng['serversettings']['hostname']['description'] = 'Hvad er denne servers hostname?';
$lng['serversettings']['apachereload_command']['title'] = 'Apache genstart kommando';
$lng['serversettings']['apachereload_command']['description'] = 'Hvad er kommandoen til at genstarte apache?';
$lng['serversettings']['bindconf_directory']['title'] = 'Bind konfigurations mappe';
$lng['serversettings']['bindconf_directory']['description'] = 'Hvor er bind\'s konfigurationsfiler?';
$lng['serversettings']['bindreload_command']['title'] = 'Bind genstart kommando';
$lng['serversettings']['bindreload_command']['description'] = 'Hvad er kommandoen til at genstarte bind?';
$lng['serversettings']['binddefaultzone']['title'] = 'Bind default zone';
$lng['serversettings']['binddefaultzone']['description'] = 'Hvad er navnet på default zone?';
$lng['serversettings']['vmail_uid']['title'] = 'Mails-Uid';
$lng['serversettings']['vmail_uid']['description'] = 'Hvilket UserID skal mails bruge?';
$lng['serversettings']['vmail_gid']['title'] = 'Mails-Gid';
$lng['serversettings']['vmail_gid']['description'] = 'Hvilket GroupID skal mails bruge?';
$lng['serversettings']['vmail_homedir']['title'] = 'Mails-Homedir';
$lng['serversettings']['vmail_homedir']['description'] = 'Hvor skal alle mails opbevares?';
$lng['serversettings']['adminmail']['title'] = 'Afsender';
$lng['serversettings']['adminmail']['description'] = 'Hvilken adresse skal eMails sendt fra kontrol panelet være?';
$lng['serversettings']['phpmyadmin_url']['title'] = 'phpMyAdmin URL';
$lng['serversettings']['phpmyadmin_url']['description'] = 'Hvad er URL\'en til phpMyAdmin? (skal starte med http://)';
$lng['serversettings']['webmail_url']['title'] = 'WebMail URL';
$lng['serversettings']['webmail_url']['description'] = 'Hvad er URL\'en til WebMail? (skal starte med http://)';
$lng['serversettings']['webftp_url']['title'] = 'WebFTP URL';
$lng['serversettings']['webftp_url']['description'] = 'Hvad er URL\'en til WebFTP? (skal starte med http://)';
$lng['serversettings']['language']['description'] = 'Hvilket sprog er standart på din server?';
$lng['serversettings']['maxloginattempts']['title'] = 'Maksimum log ind forsøg';
$lng['serversettings']['maxloginattempts']['description'] = 'Maksimum log ind forsøg hvorefter kontoen bliver spærret.';
$lng['serversettings']['deactivatetime']['title'] = 'Spærrings periode';
$lng['serversettings']['deactivatetime']['description'] = 'Tid i sekunder en konto skal forblive spærret.';
$lng['serversettings']['pathedit']['title'] = 'Sti valg type';
$lng['serversettings']['pathedit']['description'] = 'SKal sti vælges via et indtastningfelt eller en dropdown menu?';

/**
 * CHANGED BETWEEN 1.2.12 and 1.2.13
 */

$lng['mysql']['description'] = 'Her kan du oprette og editere dine MySQL-Databaser.<br />ændringerne er øjeblikkelige og databaserne kan bruges med det samme.<br />I menuen til venstre finder du værktøjet phpMyAdmin hvilket kan bruges til nemt at administrere din(e) database(r).<br /><br />For at gøre brug af databaser i dine egne php-scripts skal de følgende indstillinger bruges: (Teksk i <i>italisk</i> skrift skal erstattes med de data du taster ind)<br />Vært: <b><SQL_HOST></b><br />Bruger: <b><i>Databasenavn</i></b><br />Kodeord: <b><i>kodeordet du har valgt</i></b><br />Database: <b><i>Databasenavn</i></b>';

/**
 * ADDED BETWEEN 1.2.12 and 1.2.13
 */

$lng['serversettings']['paging']['title'] = 'Genstande per side';
$lng['serversettings']['paging']['description'] = 'Hvor mange genstande skal vises per side? (0 = brug ikke side inddeling)';
$lng['error']['ipstillhasdomains'] = 'IP/Port kombinationen du vil slette har stadig domæner tilknyttet. Overfør disse domæner til en anden IP/Port kombination for at slette denne.';
$lng['error']['cantdeletedefaultip'] = 'Du kan ikke slette standart IP/Port kombinationen for sælgere. Opret venligst en anden IP/Port kombination som standart først.';
$lng['error']['cantdeletesystemip'] = 'Du kan ikke slette den sidste system IP. Opret en ny IP/Port først eller lav denne om.';
$lng['error']['myipaddress'] = '\'IP\'';
$lng['error']['myport'] = '\'Port\'';
$lng['error']['myipdefault'] = 'Do skal vælge en IP/Port kombination som skal bruges som standart.';
$lng['error']['myipnotdouble'] = 'Denne IP/Port kombination eksisterer allerede.';
$lng['question']['admin_ip_reallydelete'] = 'Er du sikker på du vil slette IP-adressen %s?';
$lng['admin']['ipsandports']['ipsandports'] = 'IP\'er og Porte';
$lng['admin']['ipsandports']['add'] = 'Tilføj IP/Port';
$lng['admin']['ipsandports']['edit'] = 'Editer IP/Port';
$lng['admin']['ipsandports']['ipandport'] = 'IP/Port';
$lng['admin']['ipsandports']['ip'] = 'IP';
$lng['admin']['ipsandports']['port'] = 'Port';

// ADDED IN 1.2.13-rc3

$lng['error']['cantchangesystemip'] = 'Du kan ikke ændre den sidste system IP. Opret endten en ny IP/Port kombination til system IP\'en eller skift system IP\'en.';
$lng['question']['admin_domain_reallydocrootoutofcustomerroot'] = 'Er du sikker på du vil ændre mappe roden for dette domæne til en sti som ikke er i kundes mappe?';

// ADDED IN 1.2.14-rc1

$lng['admin']['memorylimitdisabled'] = 'Deaktiveret';
$lng['error']['loginnameissystemaccount'] = 'Du kan ikke oprette konto\'er hvis navn minder om system kontoer. Forsøg venligst med et andet navn.';
$lng['domain']['openbasedirpath'] = 'OpenBasedir-sti';
$lng['domain']['docroot'] = 'Sti fra feltet ovenfor';
$lng['domain']['homedir'] = 'Hjemme mappe';
$lng['admin']['valuemandatory'] = 'Denne værdi er obligatorisk';
$lng['admin']['valuemandatorycompany'] = 'Enten "Navn", "Efternavn" eller "Firma" skal være udfyldt';
$lng['menue']['main']['username'] = 'Logget ind som: ';
$lng['panel']['urloverridespath'] = 'URL (Tilsidesætter sti)';
$lng['panel']['pathorurl'] = 'Sti eller URL';
$lng['error']['sessiontimeoutiswrong'] = '"Session Timeout" må kun bestå af tal.';
$lng['error']['maxloginattemptsiswrong'] = '"Max Login Attempts" må kun bestå af tal.';
$lng['error']['deactivatetimiswrong'] = '"Deactivate Time" må kun bestå af tal.';
$lng['error']['accountprefixiswrong'] = '&quopt;Kundepræfiks" er ikke korrekt.';
$lng['error']['mysqlprefixiswrong'] = '"SQL Præfiks" er ikke korrekt.';
$lng['error']['ftpprefixiswrong'] = '"FTP Præfiks" er ikke korrekt.';
$lng['error']['ipiswrong'] = '"IP-Adresse" er ikke en gyldig IP adresse';
$lng['error']['vmailuidiswrong'] = '"Mails-uid" er ikke korrekt. UID skal bestå af tal.';
$lng['error']['vmailgidiswrong'] = '"Mails-gid" er ikke korrekt. GID skal bestå af tal.';
$lng['error']['adminmailiswrong'] = '"Afsender-adresse" er ikke en gyldig eMail adresse.';
$lng['error']['pagingiswrong'] = '"Genstande per side" må kun bestå af tal.';
$lng['error']['phpmyadminiswrong'] = 'phpMyAdmin linket er ikke gyldigt.';
$lng['error']['webmailiswrong'] = 'WebMail linket er ikke gyldigt.';
$lng['error']['webftpiswrong'] = 'WebFTP linket er ikke gyldigt.';
$lng['domains']['hasaliasdomains'] = 'Har aliasdomæne(r)';
$lng['serversettings']['defaultip']['title'] = 'Standart IP/Port';
$lng['serversettings']['defaultip']['description'] = 'Hvilket IP/Port kombination skal bruges som standart?';
$lng['domains']['statstics'] = 'Forbrugs statestik';
$lng['panel']['ascending'] = 'kronologisk';
$lng['panel']['decending'] = 'omvendt kronologisk';
$lng['panel']['search'] = 'Søg';
$lng['panel']['used'] = 'brugt';
$lng['error']['stringformaterror'] = 'Den indtastede værdi i feltet "%s" er ugyldig';

// ADDED IN 1.2.15-svn1

$lng['admin']['serversoftware'] = 'Serversoftware';
$lng['admin']['phpversion'] = 'PHP-Version';
$lng['admin']['phpmemorylimit'] = 'PHP Hukommelses Græse';
$lng['admin']['mysqlserverversion'] = 'MySQL Server Version';
$lng['admin']['mysqlclientversion'] = 'MySQL Klient Version';
$lng['admin']['webserverinterface'] = 'Webserver Brugerflade';

?>
