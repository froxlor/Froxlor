<?php

/**
 * This file is part of the SysCP project.
 * Copyright (c) 2003-2009 the SysCP Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.syscp.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Simon Clausen
 * @license    GPLv2 http://files.syscp.org/misc/COPYING.txt
 * @package    Language
 * @version    $Id: danish.lng.php 2692 2009-03-27 18:04:47Z flo $
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
$lng['panel']['emptyfornochanges'] = 'tom: ingen &aelig;ndringer';
$lng['panel']['emptyfordefault'] = 'tom: standart';
$lng['panel']['path'] = 'Sti';
$lng['panel']['toggle'] = 'Skift';
$lng['panel']['next'] = 'n&aelig;ste';
$lng['panel']['dirsmissing'] = 'Mappe findes ikke!';
$lng['panel']['translator'] = 'Overs&aelig;ttelse af';

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
$lng['customer']['subdomains'] = 'Sub-Dom&aelig;ne(r)';
$lng['customer']['domains'] = 'Dom&aelig;ne(r)';
$lng['customer']['unlimited'] = 'ubegr&aelig;nset';

/**
 * Customermenue
 */

$lng['menue']['main']['main'] = 'Hjem';
$lng['menue']['main']['changepassword'] = '&aelig;ndre kodeord';
$lng['menue']['main']['changelanguage'] = '&aelig;ndre sprog';
$lng['menue']['email']['email'] = 'eMail';
$lng['menue']['email']['emails'] = 'Adresser';
$lng['menue']['email']['webmail'] = 'WebMail';
$lng['menue']['mysql']['mysql'] = 'MySQL';
$lng['menue']['mysql']['databases'] = 'Databaser';
$lng['menue']['mysql']['phpmyadmin'] = 'phpMyAdmin';
$lng['menue']['domains']['domains'] = 'Dom&aelig;ner';
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
$lng['changepassword']['new_password_confirm'] = 'Nyt kodeord (bekr&aelig;ft)';
$lng['changepassword']['new_password_ifnotempty'] = 'Nyt kodeord (tom = ingen &aelig;ndringer)';
$lng['changepassword']['also_change_ftp'] = ' skift ogs&aring; kodeordet for hoved-ftp kontoen';

/**
 * Domains
 */

$lng['domains']['description'] = 'Her kan du oprette dom&aelig;ner og subdom&aelig;ner i systemet, og &aelig;ndre de stier som er tilknyttet<br />Det tager et stykke tid for &aelig;ndringer at blive opdateret i systemet.';
$lng['domains']['domainsettings'] = 'Dom&aelig;ne indstillinger';
$lng['domains']['domainname'] = 'Dom&aelig;ne navn';
$lng['domains']['subdomain_add'] = 'Opr&aelig;t suddom&aelig;ne';
$lng['domains']['subdomain_edit'] = 'Editer (sub)dom&aelig;ne';
$lng['domains']['wildcarddomain'] = 'Opret som wildcarddom&aelig;ne?';
$lng['domains']['aliasdomain'] = 'Dom&aelig;ne alias';
$lng['domains']['noaliasdomain'] = 'Intet dom&aelig;ne alias';

/**
 * eMails
 */

$lng['emails']['description'] = 'Her kan du oprette og &aelig;ndre eMail adresser og kontoer.<br />eMail modtages af de adresser du opretter. For at kunne hente eMail skal du oprette en konto til adressen, dette g&oslash;res ved at v&aelig;lge &quot;opret konto&quot; efter du har oprettet eMail adressen.<br />Dit email program skal konfigureres som f&oslash;lger: (Teksk i <i>italisk</i> skrift skal erstattes med de data du taster ind)<br />Hostname: <b><i>Dom&aelig;nenavn</i></b><br />Bruger: <b><i>Konto navn / eMail adresse</i></b><br />Kodeord: <b><i>kodeordet du har valgt</i></b>';
$lng['emails']['emailaddress'] = 'eMail-adresse';
$lng['emails']['emails_add'] = 'Opret eMail-adresse';
$lng['emails']['emails_edit'] = 'Editer eMail-adresse';
$lng['emails']['catchall'] = 'Fang-Alt';
$lng['emails']['iscatchall'] = 'Brug som &quot;Fang-Alt&quot; adresse?';
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

$lng['ftp']['description'] = 'Her kan du oprette og &aelig;ndre dine FTP kontoer.<br />&aelig;ndringer bliver gennemf&oslash;rt &oslash;jeblikeligt, og kontoerne kan straks tages i brug.';
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

$lng['extras']['description'] = 'Her kan du udf&oslash;re ekstra indstillinger, for eksempel kodeords beskyttelse af mapper.<br />Det tager et stykke tid for &aelig;ndringer at blive opdateret i systemet.';
$lng['extras']['directoryprotection_add'] = 'Tilf&oslash;j mappe beskyttelse';
$lng['extras']['view_directory'] = 'vis mappe indhold';
$lng['extras']['pathoptions_add'] = 'tilf&oslash;j regler for sti';
$lng['extras']['directory_browsing'] = 'vis mappe indhold?';
$lng['extras']['pathoptions_edit'] = '&aelig;ndre regler for sti';
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
$lng['error']['filemustexist'] = 'Filen %s skal v&aelig;re oprettet.';
$lng['error']['allresourcesused'] = 'Du har brugt dine tilladte ressourcer.';
$lng['error']['domains_cantdeletemaindomain'] = 'Du kan ikke slette et eMail-dom&aelig;ne.';
$lng['error']['domains_canteditdomain'] = 'Du kan ikke lave &aelig;ndringer i dette dom&aelig;ne, da det er blevet l&aring;st af administratoren.';
$lng['error']['domains_cantdeletedomainwithemail'] = 'Du kan ikke slette et dom&aelig;ne med tilknyttede eMail-adresser. Slet alle email adresser f&oslash;rst.';
$lng['error']['firstdeleteallsubdomains'] = 'Du skal f&oslash;rst slette alle sub-dom&aelig;ner for du kan oprette et wildcarddom&aelig;ne.';
$lng['error']['youhavealreadyacatchallforthisdomain'] = 'Du har allerede valgt en Fang-Alt adresse for dette dom&aelig;ne.';
$lng['error']['ftp_cantdeletemainaccount'] = 'Du kan ikke slette din prim&aelig;re FTP konto.';
$lng['error']['login'] = 'Den indtastede bruger/kode er ikke korrekt. Fors&oslash;g venligst igen.';
$lng['error']['login_blocked'] = 'Denne konto er blevet midlertidigt lukket grundet for mange fejlagtige logind fors&oslash;g.<br />Fors&oslash;g venligst igen om ' . $settings['login']['deactivatetime'] . ' sekunder.';
$lng['error']['notallreqfieldsorerrors'] = 'Alle kr&aelig;vede felter er ikke udfyldt, eller der er fejl i en eller flere af udfyldningerne.';
$lng['error']['oldpasswordnotcorrect'] = 'Det gamle kodeord er ikke indtastet korrekt.';
$lng['error']['youcantallocatemorethanyouhave'] = 'Du kan ikke tildele flere ressourcer end du er blevet bevilliget.';
$lng['error']['mustbeurl'] = 'Din indtastning er ikke en gyldig URL (f.eks. http://eksempel.com/fejl404.htm)';
$lng['error']['invalidpath'] = 'Du har valgt en ikke gyldig url (m&aring;ske et problem med mappe list?)';
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
$lng['error']['mydomain'] = '\'Dom&aelig;ne\'';
$lng['error']['mydocumentroot'] = '\'Mapperod\'';
$lng['error']['loginnameexists'] = 'Brugernavnet %s eksisterer allerede';
$lng['error']['emailiswrong'] = 'eMail-Adressen %s indeholder ugyldige tegn eller er ikke komplet';
$lng['error']['loginnameiswrong'] = 'Brugernavnet %s indeholder ugyldige tegn';
$lng['error']['userpathcombinationdupe'] = 'Kombinationen af brugernavn og sti findes allerede.';
$lng['error']['patherror'] = 'Fejl! Sti kan ikke v&aelig;re tom';
$lng['error']['errordocpathdupe'] = 'Indstillinger for stien %s eksisterer allerede';
$lng['error']['adduserfirst'] = 'Opret venligst en kunde f&oslash;rst';
$lng['error']['domainalreadyexists'] = 'Dom&aelig;net %s er allerede delligeret til en kunde';
$lng['error']['nolanguageselect'] = 'Ingen sprog er valgt.';
$lng['error']['nosubjectcreate'] = 'Du skal angive en overskrift for denne eMail skabelon.';
$lng['error']['nomailbodycreate'] = 'Du skal skrive et indhold til denne eMail skabelon.';
$lng['error']['templatenotfound'] = 'Skabelon blev ikke fundet.';
$lng['error']['alltemplatesdefined'] = 'Du kan ikke oprette flere skabeloner da alle sprog allerede er underst&oslash;ttet.';
$lng['error']['wwwnotallowed'] = 'www er ikke tilladt som sub-dom&aelig;ne.';
$lng['error']['subdomainiswrong'] = 'Sub-dom&aelig;net %s indeholder ugyldige tegn.';
$lng['error']['domaincantbeempty'] = 'The domain-name can not be empty.';
$lng['error']['domainexistalready'] = 'Dom&aelig;net %s eksisterer allerede.';
$lng['error']['domainisaliasorothercustomer'] = 'Det valgte alias-dom&aelig;ne er enten selv et alias dom&aelig;ne, eller tilh&oslash;rer en anden kunde.';
$lng['error']['emailexistalready'] = 'eMail-Adressen %s eksisterer allerede.';
$lng['error']['maindomainnonexist'] = 'Hoved-dom&aelig;net %s eksisterer ikke.';
$lng['error']['destinationnonexist'] = 'Opret venligst videresenderen i feltet.';
$lng['error']['destinationalreadyexistasmail'] = 'Videresenderen til %s eksisterer allerede som en aktiv eMail-adresse.';
$lng['error']['destinationalreadyexist'] = 'Der er allerede angivet en videresender til %s .';
$lng['error']['destinationiswrong'] = 'Videresenderen %s indeholder ugyldige tegn eller er ikke komplet.';
$lng['error']['domainname'] = $lng['domains']['domainname'];

/**
 * Questions
 */

$lng['question']['question'] = 'Sikkerhedssp&oslash;rgsm&aring;l';
$lng['question']['admin_customer_reallydelete'] = 'Er du sikker p&aring; du vil slette kunden %s? Dette kan ikke fortrydes!';
$lng['question']['admin_domain_reallydelete'] = 'Er du sikker p&aring; du vil slette dom&aelig;net %s?';
$lng['question']['admin_domain_reallydisablesecuritysetting'] = 'Er du sikker p&aring; du vil deaktivere disse sikkerheds indstillinger (OpenBasedir og/eller SafeMode)?';
$lng['question']['admin_admin_reallydelete'] = 'Er du sikker p&aring; du vil slette administrator %s? Alle kunder og dom&aelig;ner som h&oslash;rer hertil vil blive allokeret til &oslash;verste adminstartor.';
$lng['question']['admin_template_reallydelete'] = 'Er du sikker p&aring; du vil slette skabelonen \'%s*\'?';
$lng['question']['domains_reallydelete'] = 'Er du sikker p&aring; du vil slette dom&aelig;net %s?';
$lng['question']['email_reallydelete'] = 'Er du sikker p&aring; du vil slette eMail-adressen %s?';
$lng['question']['email_reallydelete_account'] = 'Er du sikker p&aring; du vil slette eMail-account fra %s?';
$lng['question']['email_reallydelete_forwarder'] = 'Er du sikker p&aring; du vil slette videresenderen %s?';
$lng['question']['extras_reallydelete'] = 'Er du sikker p&aring; du vil slette mappe beskyttelse for %s?';
$lng['question']['extras_reallydelete_pathoptions'] = 'Er du sikker p&aring; du vil slette regler for stien %s?';
$lng['question']['ftp_reallydelete'] = 'Er du sikker p&aring; du vil slette FTP kontoen %s?';
$lng['question']['mysql_reallydelete'] = 'Er du sikker p&aring; du vil slette databasen %s? Dette kan ikke fortrydes!';
$lng['question']['admin_configs_reallyrebuild'] = 'Er du sikker p&aring; du vil genbygge dine apache og bind konfigurations filer?';

/**
 * Mails
 */

$lng['mails']['pop_success']['mailbody'] = 'Hej,\n\ndin eMail konto {EMAIL}\ner blevet oprettet.\n\nDette er en automatisk genereret\neMail, svar er ikke n&oslash;dvendig!\n\nHilsen, SysCP-Teamet';
$lng['mails']['pop_success']['subject'] = 'eMail konto er blevet oprettet';
$lng['mails']['createcustomer']['mailbody'] = 'Hej {FIRSTNAME} {NAME},\n\ndette er information til din konto:\n\nBruger: {USERNAME}\nKodeord: {PASSWORD}\n\nHilsen, SysCP-Teamet';
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
$lng['admin']['lookfornewversion']['clickhere'] = 's&oslash;g via webservice';
$lng['admin']['lookfornewversion']['error'] = 'Fejl under l&aelig;sning';
$lng['admin']['resources'] = 'Ressourcer';
$lng['admin']['customer'] = 'Kunde';
$lng['admin']['customers'] = 'Kunder';
$lng['admin']['customer_add'] = 'Opret kunde';
$lng['admin']['customer_edit'] = 'Editer kunde';
$lng['admin']['domains'] = 'Dom&aelig;ner';
$lng['admin']['domain_add'] = 'Opret dom&aelig;ne';
$lng['admin']['domain_edit'] = 'Editer dom&aelig;ne';
$lng['admin']['subdomainforemail'] = 'Subdom&aelig;ner som eMaildom&aelig;ner';
$lng['admin']['admin'] = 'Admin';
$lng['admin']['admins'] = 'Admins';
$lng['admin']['admin_add'] = 'Opret administrator';
$lng['admin']['admin_edit'] = 'Editer administrator';
$lng['admin']['customers_see_all'] = 'Kan se alle kunder?';
$lng['admin']['domains_see_all'] = 'Kan se alle dom&aelig;ner?';
$lng['admin']['change_serversettings'] = 'Kan &aelig;ndre server indstillinger?';
$lng['admin']['server'] = 'Server';
$lng['admin']['serversettings'] = 'Indstillinger';
$lng['admin']['rebuildconf'] = 'Genbyg konfigurations filer';
$lng['admin']['stdsubdomain'] = 'Standart subdom&aelig;ne';
$lng['admin']['stdsubdomain_add'] = 'Opret standart subdom&aelig;ne';
$lng['admin']['deactivated'] = 'Deaktiveret';
$lng['admin']['deactivated_user'] = 'Deaktiver Bruger';
$lng['admin']['sendpassword'] = 'Send kodeord';
$lng['admin']['ownvhostsettings'] = 'Egne vHost-indstillinger';
$lng['admin']['configfiles']['serverconfiguration'] = 'Konfiguration';
$lng['admin']['configfiles']['files'] = '<b>Konfigurationsfiler:</b> Lav venligst &aelig;ndringerne i de f&oslash;lgende filer eller opret<br />dem med dette indhold hvis de ikke eksisterer.<br /><b>Bem&aelig;rk:</b> MySQL Kodeordet er ikke blevet &aelig;ndre af sikkerhedsgrunde.<br />Udskift venligst &quot;MYSQL_PASSWORD&quot; manuelt. Hvis du har glemt dit MySQL kodeord<br />er det at finde i &quot;lib/userdata.inc.php&quot;.';
$lng['admin']['configfiles']['commands'] = '<b>Kommandoer:</b> Udf&oslash;r disse kommandoer i shell\'et.';
$lng['admin']['configfiles']['restart'] = '<b>Genstart:</b> Udf&oslash;r disse kommandoer i shell\'et for at aktivere den nye konfiguration.';
$lng['admin']['templates']['templates'] = 'Skabeloner';
$lng['admin']['templates']['template_add'] = 'Tilf&oslash;j skabelon';
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

$lng['serversettings']['session_timeout']['title'] = 'S&aelig;ssion Timeout';
$lng['serversettings']['session_timeout']['description'] = 'Hvor l&aelig;nge skal en bruger v&aelig;re inaktiv f&oslash;r s&aelig;ssionen bliver ugyldig (i sekunder)?';
$lng['serversettings']['accountprefix']['title'] = 'Kundepr&aelig;fiks';
$lng['serversettings']['accountprefix']['description'] = 'Hvilket pr&aelig;fiks skal kunde kontoer have?';
$lng['serversettings']['mysqlprefix']['title'] = 'SQL Pr&aelig;fiks';
$lng['serversettings']['mysqlprefix']['description'] = 'Hvilket pr&aelig;fiks skal MySQL databaser have?';
$lng['serversettings']['ftpprefix']['title'] = 'FTP Pr&aelig;fiks';
$lng['serversettings']['ftpprefix']['description'] = 'Hvilket pr&aelig;fiks skal FTP kontoer have?';
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
$lng['serversettings']['binddefaultzone']['description'] = 'Hvad er navnet p&aring; default zone?';
$lng['serversettings']['vmail_uid']['title'] = 'Mails-Uid';
$lng['serversettings']['vmail_uid']['description'] = 'Hvilket UserID skal mails bruge?';
$lng['serversettings']['vmail_gid']['title'] = 'Mails-Gid';
$lng['serversettings']['vmail_gid']['description'] = 'Hvilket GroupID skal mails bruge?';
$lng['serversettings']['vmail_homedir']['title'] = 'Mails-Homedir';
$lng['serversettings']['vmail_homedir']['description'] = 'Hvor skal alle mails opbevares?';
$lng['serversettings']['adminmail']['title'] = 'Afsender';
$lng['serversettings']['adminmail']['description'] = 'Hvilken adresse skal eMails sendt fra kontrol panelet v&aelig;re?';
$lng['serversettings']['phpmyadmin_url']['title'] = 'phpMyAdmin URL';
$lng['serversettings']['phpmyadmin_url']['description'] = 'Hvad er URL\'en til phpMyAdmin? (skal starte med http://)';
$lng['serversettings']['webmail_url']['title'] = 'WebMail URL';
$lng['serversettings']['webmail_url']['description'] = 'Hvad er URL\'en til WebMail? (skal starte med http://)';
$lng['serversettings']['webftp_url']['title'] = 'WebFTP URL';
$lng['serversettings']['webftp_url']['description'] = 'Hvad er URL\'en til WebFTP? (skal starte med http://)';
$lng['serversettings']['language']['description'] = 'Hvilket sprog er standart p&aring; din server?';
$lng['serversettings']['maxloginattempts']['title'] = 'Maksimum log ind fors&oslash;g';
$lng['serversettings']['maxloginattempts']['description'] = 'Maksimum log ind fors&oslash;g hvorefter kontoen bliver sp&aelig;rret.';
$lng['serversettings']['deactivatetime']['title'] = 'Sp&aelig;rrings periode';
$lng['serversettings']['deactivatetime']['description'] = 'Tid i sekunder en konto skal forblive sp&aelig;rret.';
$lng['serversettings']['pathedit']['title'] = 'Sti valg type';
$lng['serversettings']['pathedit']['description'] = 'SKal sti v&aelig;lges via et indtastningfelt eller en dropdown menu?';

/**
 * CHANGED BETWEEN 1.2.12 and 1.2.13
 */

$lng['mysql']['description'] = 'Her kan du oprette og editere dine MySQL-Databaser.<br />&aelig;ndringerne er &oslash;jeblikkelige og databaserne kan bruges med det samme.<br />I menuen til venstre finder du v&aelig;rkt&oslash;jet phpMyAdmin hvilket kan bruges til nemt at administrere din(e) database(r).<br /><br />For at g&oslash;re brug af databaser i dine egne php-scripts skal de f&oslash;lgende indstillinger bruges: (Teksk i <i>italisk</i> skrift skal erstattes med de data du taster ind)<br />V&aelig;rt: <b><SQL_HOST></b><br />Bruger: <b><i>Databasenavn</i></b><br />Kodeord: <b><i>kodeordet du har valgt</i></b><br />Database: <b><i>Databasenavn</i></b>';

/**
 * ADDED BETWEEN 1.2.12 and 1.2.13
 */

$lng['admin']['cronlastrun'] = 'Sidste Cron';
$lng['serversettings']['paging']['title'] = 'Genstande per side';
$lng['serversettings']['paging']['description'] = 'Hvor mange genstande skal vises per side? (0 = brug ikke side inddeling)';
$lng['error']['ipstillhasdomains'] = 'IP/Port kombinationen du vil slette har stadig dom&aelig;ner tilknyttet. Overf&oslash;r disse dom&aelig;ner til en anden IP/Port kombination for at slette denne.';
$lng['error']['cantdeletedefaultip'] = 'Du kan ikke slette standart IP/Port kombinationen for s&aelig;lgere. Opret venligst en anden IP/Port kombination som standart f&oslash;rst.';
$lng['error']['cantdeletesystemip'] = 'Du kan ikke slette den sidste system IP. Opret en ny IP/Port f&oslash;rst eller lav denne om.';
$lng['error']['myipaddress'] = '\'IP\'';
$lng['error']['myport'] = '\'Port\'';
$lng['error']['myipdefault'] = 'Do skal v&aelig;lge en IP/Port kombination som skal bruges som standart.';
$lng['error']['myipnotdouble'] = 'Denne IP/Port kombination eksisterer allerede.';
$lng['question']['admin_ip_reallydelete'] = 'Er du sikker p&aring; du vil slette IP-adressen %s?';
$lng['admin']['ipsandports']['ipsandports'] = 'IP\'er og Porte';
$lng['admin']['ipsandports']['add'] = 'Tilf&oslash;j IP/Port';
$lng['admin']['ipsandports']['edit'] = 'Editer IP/Port';
$lng['admin']['ipsandports']['ipandport'] = 'IP/Port';
$lng['admin']['ipsandports']['ip'] = 'IP';
$lng['admin']['ipsandports']['port'] = 'Port';

// ADDED IN 1.2.13-rc3

$lng['error']['cantchangesystemip'] = 'Du kan ikke &aelig;ndre den sidste system IP. Opret endten en ny IP/Port kombination til system IP\'en eller skift system IP\'en.';
$lng['question']['admin_domain_reallydocrootoutofcustomerroot'] = 'Er du sikker p&aring; du vil &aelig;ndre mappe roden for dette dom&aelig;ne til en sti som ikke er i kundes mappe?';

// ADDED IN 1.2.14-rc1

$lng['admin']['memorylimitdisabled'] = 'Deaktiveret';
$lng['error']['loginnameissystemaccount'] = 'Du kan ikke oprette konto\'er hvis navn minder om system kontoer. Fors&oslash;g venligst med et andet navn.';
$lng['domain']['openbasedirpath'] = 'OpenBasedir-sti';
$lng['domain']['docroot'] = 'Sti fra feltet ovenfor';
$lng['domain']['homedir'] = 'Hjemme mappe';
$lng['admin']['valuemandatory'] = 'Denne v&aelig;rdi er obligatorisk';
$lng['admin']['valuemandatorycompany'] = 'Enten &quot;Navn&quot;, &quot;Efternavn&quot; eller &quot;Firma&quot skal v&aelig;re udfyldt';
$lng['menue']['main']['username'] = 'Logget ind som: ';
$lng['panel']['urloverridespath'] = 'URL (Tilsides&aelig;tter sti)';
$lng['panel']['pathorurl'] = 'Sti eller URL';
$lng['error']['sessiontimeoutiswrong'] = '&quot;Session Timeout&quot; m&aring; kun best&aring; af tal.';
$lng['error']['maxloginattemptsiswrong'] = '&quot;Max Login Attempts&quot; m&aring; kun best&aring; af tal.';
$lng['error']['deactivatetimiswrong'] = '&quot;Deactivate Time&quot; m&aring; kun best&aring; af tal.';
$lng['error']['accountprefixiswrong'] = '&quopt;Kundepr&aelig;fiks&quot; er ikke korrekt.';
$lng['error']['mysqlprefixiswrong'] = '&quot;SQL Pr&aelig;fiks&quot; er ikke korrekt.';
$lng['error']['ftpprefixiswrong'] = '&quot;FTP Pr&aelig;fiks&quot; er ikke korrekt.';
$lng['error']['ipiswrong'] = '&quot;IP-Adresse&quot; er ikke en gyldig IP adresse';
$lng['error']['vmailuidiswrong'] = '&quot;Mails-uid&quot; er ikke korrekt. UID skal best&aring; af tal.';
$lng['error']['vmailgidiswrong'] = '&quot;Mails-gid&quot; er ikke korrekt. GID skal best&aring; af tal.';
$lng['error']['adminmailiswrong'] = '&quot;Afsender-adresse&quot; er ikke en gyldig eMail adresse.';
$lng['error']['pagingiswrong'] = '&quot;Genstande per side&quot; m&aring; kun best&aring; af tal.';
$lng['error']['phpmyadminiswrong'] = 'phpMyAdmin linket er ikke gyldigt.';
$lng['error']['webmailiswrong'] = 'WebMail linket er ikke gyldigt.';
$lng['error']['webftpiswrong'] = 'WebFTP linket er ikke gyldigt.';
$lng['domains']['hasaliasdomains'] = 'Har aliasdom&aelig;ne(r)';
$lng['serversettings']['defaultip']['title'] = 'Standart IP/Port';
$lng['serversettings']['defaultip']['description'] = 'Hvilket IP/Port kombination skal bruges som standart?';
$lng['domains']['statstics'] = 'Forbrugs statestik';
$lng['panel']['ascending'] = 'kronologisk';
$lng['panel']['decending'] = 'omvendt kronologisk';
$lng['panel']['search'] = 'S&oslash;g';
$lng['panel']['used'] = 'brugt';
$lng['error']['stringformaterror'] = 'Den indtastede v&aelig;rdi i feltet &quot;%s&quot; er ugyldig';

// ADDED IN 1.2.15-svn1

$lng['admin']['serversoftware'] = 'Serversoftware';
$lng['admin']['phpversion'] = 'PHP-Version';
$lng['admin']['phpmemorylimit'] = 'PHP Hukommelses Gr&aelig;se';
$lng['admin']['mysqlserverversion'] = 'MySQL Server Version';
$lng['admin']['mysqlclientversion'] = 'MySQL Klient Version';
$lng['admin']['webserverinterface'] = 'Webserver Brugerflade';

?>
