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
 * @author     Luca Piona <info@havanastudio.ch>
 * @author     Luca Longinotti <chtekk@gentoo.org>
 * @author     Froxlor Team <team@froxlor.org>
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Language
 * @version    $Id$
 */

/**
 * Global
 */

$lng['translator'] = 'Luca Longinotti & Luca Piona';
$lng['panel']['edit'] = 'Modifica';
$lng['panel']['delete'] = 'Cancella';
$lng['panel']['create'] = 'Crea';
$lng['panel']['save'] = 'Salva';
$lng['panel']['yes'] = 'Si';
$lng['panel']['no'] = 'No';
$lng['panel']['emptyfornochanges'] = 'lasciare vuoto se non si vuole cambiare';
$lng['panel']['emptyfordefault'] = 'lasciare vuoto per l\'impostazione di default';
$lng['panel']['path'] = 'Percorso';
$lng['panel']['toggle'] = 'Cambia';
$lng['panel']['next'] = 'Prossimo';
$lng['panel']['dirsmissing'] = 'Impossibile trovare o leggere la directory!';

/**
 * Login
 */

$lng['login']['username'] = 'Nome Utente';
$lng['login']['password'] = 'Password';
$lng['login']['language'] = 'Lingua';
$lng['login']['login'] = 'Login';
$lng['login']['logout'] = 'Logout';
$lng['login']['profile_lng'] = 'Scegli la lingua';

/**
 * Customer
 */

$lng['customer']['documentroot'] = 'Cartella Principale';
$lng['customer']['name'] = 'Cognome';
$lng['customer']['firstname'] = 'Nome';
$lng['customer']['company'] = 'Ditta';
$lng['customer']['street'] = 'Via';
$lng['customer']['zipcode'] = 'CAP';
$lng['customer']['city'] = 'Città';
$lng['customer']['phone'] = 'Telefono';
$lng['customer']['fax'] = 'Fax';
$lng['customer']['email'] = 'Email';
$lng['customer']['customernumber'] = 'ID Cliente';
$lng['customer']['diskspace'] = 'Spazio Web (MB)';
$lng['customer']['traffic'] = 'Traffico (GB)';
$lng['customer']['mysqls'] = 'Database MySQL';
$lng['customer']['emails'] = 'Indirizzi Email';
$lng['customer']['accounts'] = 'Account Email';
$lng['customer']['forwarders'] = 'Reindirizzamenti Email';
$lng['customer']['ftps'] = 'Account FTP';
$lng['customer']['subdomains'] = 'Sottodomini';
$lng['customer']['domains'] = 'Domini';
$lng['customer']['unlimited'] = 'illimitati';

/**
 * Customermenue
 */

$lng['menue']['main']['main'] = 'Principale';
$lng['menue']['main']['changepassword'] = 'Cambia la password';
$lng['menue']['main']['changelanguage'] = 'Cambia la lingua';
$lng['menue']['email']['email'] = 'Email';
$lng['menue']['email']['emails'] = 'Indirizzi';
$lng['menue']['email']['webmail'] = 'WebMail';
$lng['menue']['mysql']['mysql'] = 'MySQL';
$lng['menue']['mysql']['databases'] = 'Database';
$lng['menue']['mysql']['phpmyadmin'] = 'phpMyAdmin';
$lng['menue']['domains']['domains'] = 'Domini';
$lng['menue']['domains']['settings'] = 'Opzioni';
$lng['menue']['ftp']['ftp'] = 'FTP';
$lng['menue']['ftp']['accounts'] = 'Account';
$lng['menue']['ftp']['webftp'] = 'WebFTP';
$lng['menue']['extras']['extras'] = 'Extra';
$lng['menue']['extras']['directoryprotection'] = 'Cartelle Protette';
$lng['menue']['extras']['pathoptions'] = 'Opzioni Cartelle';

/**
 * Index
 */

$lng['index']['customerdetails'] = 'Dettagli Cliente';
$lng['index']['accountdetails'] = 'Dettagli Account';

/**
 * Change Password
 */

$lng['changepassword']['old_password'] = 'Vecchia password';
$lng['changepassword']['new_password'] = 'Nuova password';
$lng['changepassword']['new_password_confirm'] = 'Nuova password (verifica)';
$lng['changepassword']['new_password_ifnotempty'] = 'Nuova password (vuota = non cambia)';
$lng['changepassword']['also_change_ftp'] = ' cambia la password dell\'account FTP principale?';

/**
 * Domains
 */

$lng['domains']['description'] = 'Qui puoi creare (sotto)domini e cambiare il loro percorso.<br />Il sistema, dopo ogni cambiamento, necessita di un po\' di tempo per applicare le nuove impostazioni.';
$lng['domains']['domainsettings'] = 'Opzioni del dominio';
$lng['domains']['domainname'] = 'Nome del dominio';
$lng['domains']['subdomain_add'] = 'Crea sottodominio';
$lng['domains']['subdomain_edit'] = 'Modifica il (sotto)dominio';
$lng['domains']['wildcarddomain'] = 'Crea una wildcarddomain?';
$lng['domains']['aliasdomain'] = 'Alias per questo dominio';
$lng['domains']['noaliasdomain'] = 'Nessun alias per il dominio';

/**
 * eMails
 */

$lng['emails']['description'] = 'Qui puoi creare e cambiare i tuoi indirizzi Email.<br />Un account è come la bucalettere davanti a casa tua. Se qualcuno ti manda un\'Email, essa sarà recapitata all\'interno del tuo account.<br /><br />Per scaricare le tue Email usa le seguenti impostazioni nel tuo programma di posta elettronica: (I dati scritti in <i>corsivo</i> vanno cambiati con i tuoi!)<br />Hostname: <b><i>Nome del dominio</i></b><br />Username: <b><i>Nome dell\'account / Indirizzo Email</i></b><br />Password: <b><i>La password scelta</i></b>';
$lng['emails']['emailaddress'] = 'Indirizzo Email';
$lng['emails']['emails_add'] = 'Crea indirizzo Email';
$lng['emails']['emails_edit'] = 'Modifica indirizzo Email';
$lng['emails']['catchall'] = 'Catch-all';
$lng['emails']['iscatchall'] = 'Definisci come indirizzo catch-all?';
$lng['emails']['account'] = 'Account';
$lng['emails']['account_add'] = 'Crea account';
$lng['emails']['account_delete'] = 'Cancella account';
$lng['emails']['from'] = 'Da';
$lng['emails']['to'] = 'Per';
$lng['emails']['forwarders'] = 'Reindirizzamenti';
$lng['emails']['forwarder_add'] = 'Crea reindirizzamento';

/**
 * FTP
 */

$lng['ftp']['description'] = 'Qui puoi creare e modificare i tuoi account FTP.<br />I cambiamenti sono effettuati in tempo reale e gli account si possono usare immediatamente.';
$lng['ftp']['account_add'] = 'Crea account';

/**
 * MySQL
 */

$lng['mysql']['description'] = 'Qui puoi creare e modificare i tuoi database MySQL.<br />I cambiamenti sono effettuati in tempo reale e i databases si possono usare immediatamente.<br />Nel menù di sinistra trovi il tool phpMyAdmin con il quale potrai comodamente amministrare i tuoi databases attraverso il tuo web-browser.<br /><br />Per utilizzare i database nei vostri script PHP, utilizzate le seguenti impostazioni: (I dati scritti in <i>corsivo</i> vanno cambiati con i tuoi!)<br />Hostname: <b><SQL_HOST></b><br />Username: <b><i>L\'username scelto</i></b><br />Password: <b><i>La password scelta per quell\'username</i></b><br />Database: <b><i>Nome del database</i></b>';
$lng['mysql']['databasename'] = 'Nome database';
$lng['mysql']['databasedescription'] = 'Descrizione database';
$lng['mysql']['database_create'] = 'Crea database';

/**
 * Extras
 */

$lng['extras']['description'] = 'Qui puoi aggiungere alcune opzioni extra, per esempio impostare delle cartelle protette.<br />Il sistema, dopo ogni cambiamento, necessita di un po\' di tempo per applicare le nuove impostazioni.';
$lng['extras']['directoryprotection_add'] = 'Aggiungi protezione cartella';
$lng['extras']['view_directory'] = 'Mostra protezione cartella';
$lng['extras']['pathoptions_add'] = 'Aggiungi opzioni cartella';
$lng['extras']['directory_browsing'] = 'Visualizza file e cartelle';
$lng['extras']['pathoptions_edit'] = 'Modifica opzioni cartella';
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

$lng['error']['error'] = 'Errore';
$lng['error']['directorymustexist'] = 'La cartella %s deve esistere. Per favore creala tramite il tuo client FTP.';
$lng['error']['filemustexist'] = 'Il file %s deve esistere.';
$lng['error']['allresourcesused'] = 'Hai già usato tutte le tue risorse.';
$lng['error']['domains_cantdeletemaindomain'] = 'Non puoi cancellare un dominio usato come dominio Email.';
$lng['error']['domains_canteditdomain'] = 'Non puoi modificare questo dominio. La funzione è stata disabilitata dall\'admin.';
$lng['error']['domains_cantdeletedomainwithemail'] = 'Non puoi cancellare un dominio usato come dominio Email. Cancella prima tutti gli indirizzi Email che lo utilizzano.';
$lng['error']['firstdeleteallsubdomains'] = 'Prima di creare un dominio wildcard, cancella tutti i sottodomini presenti per quel dominio.';
$lng['error']['youhavealreadyacatchallforthisdomain'] = 'Hai già definito un catchall per questo dominio.';
$lng['error']['ftp_cantdeletemainaccount'] = 'Non puoi cancellare il tuo account FTP principale.';
$lng['error']['login'] = 'Il nome utente o la password da te immessi sono incorretti. Per favore riprova!';
$lng['error']['login_blocked'] = 'Questo account è stato sospeso per i troppi tentativi di login falliti. <br />Riprovi tra ' . $settings['login']['deactivatetime'] . ' secondi.';
$lng['error']['notallreqfieldsorerrors'] = 'Alcuni campi sono stati lasciati vuoti o sono stati riempiti incorrettamente.';
$lng['error']['oldpasswordnotcorrect'] = 'La vecchia password non è corretta.';
$lng['error']['youcantallocatemorethanyouhave'] = 'Non puoi assegnare più risorse di quante ne possieda tu stesso.';
$lng['error']['mustbeurl'] = 'Non hai inserito un\'indirizzo valido o completo (per es. http://qualchedominio.com/errore404.htm).';
$lng['error']['invalidpath'] = 'Non hai scelto un\'indirizzo valido.';
$lng['error']['stringisempty'] = 'Manca il dato nel campo.';
$lng['error']['stringiswrong'] = 'Dato incorretto.';
$lng['error']['myloginname'] = '\'' . $lng['login']['username'] . '\'';
$lng['error']['mypassword'] = '\'' . $lng['login']['password'] . '\'';
$lng['error']['oldpassword'] = '\'' . $lng['changepassword']['old_password'] . '\'';
$lng['error']['newpassword'] = '\'' . $lng['changepassword']['new_password'] . '\'';
$lng['error']['newpasswordconfirm'] = '\'' . $lng['changepassword']['new_password_confirm'] . '\'';
$lng['error']['newpasswordconfirmerror'] = 'La nuova password non corrisponde a quella vecchia.';
$lng['error']['myname'] = '\'' . $lng['customer']['name'] . '\'';
$lng['error']['myfirstname'] = '\'' . $lng['customer']['firstname'] . '\'';
$lng['error']['emailadd'] = '\'' . $lng['customer']['email'] . '\'';
$lng['error']['mydomain'] = '\'Dominio\'';
$lng['error']['mydocumentroot'] = '\'Documentroot\'';
$lng['error']['loginnameexists'] = 'Il login %s esiste già.';
$lng['error']['emailiswrong'] = 'L\'indirizzo Email %s contiene caratteri invalidi o è incompleto.';
$lng['error']['loginnameiswrong'] = 'Il login %s contiene caratteri invalidi.';
$lng['error']['userpathcombinationdupe'] = 'La combinazione tra nome utente e percorso esiste già.';
$lng['error']['patherror'] = 'Errore! Il percorso non può essere vuoto.';
$lng['error']['errordocpathdupe'] = 'Le opzioni per la cartella %s esistono già.';
$lng['error']['adduserfirst'] = 'Per favore crea prima un utente ...';
$lng['error']['domainalreadyexists'] = 'Il dominio %s è già assegnato ad un cliente.';
$lng['error']['nolanguageselect'] = 'Nessuna lingua selezionata.';
$lng['error']['nosubjectcreate'] = 'Devi definire un titolo per questo template Email.';
$lng['error']['nomailbodycreate'] = 'Devi definiro un testo per questo template Email.';
$lng['error']['templatenotfound'] = 'Il template non è stato trovato.';
$lng['error']['alltemplatesdefined'] = 'Non puoi definire altri template, tutte le lingue sono già definite.';
$lng['error']['wwwnotallowed'] = 'www non è ammesso come sottodominio.';
$lng['error']['subdomainiswrong'] = 'Il sottodominio %s contiene caratteri invalidi.';
$lng['error']['domaincantbeempty'] = 'Il nome dominio non può essere vuoto.';
$lng['error']['domainexistalready'] = 'Il dominio %s esiste già.';
$lng['error']['domainisaliasorothercustomer'] = 'Il dominio alias selezionato è a sua volta un dominio alias o appartiene ad un altro cliente.';
$lng['error']['emailexistalready'] = 'L\'indirizzo Email %s esiste già.';
$lng['error']['maindomainnonexist'] = 'Il dominio principale %s non esiste.';
$lng['error']['destinationnonexist'] = 'Per favore crea il tuo reindirizzamento nel campo \'Destinazione\'.';
$lng['error']['destinationalreadyexistasmail'] = 'Il reindirizzamento a %s esiste già come indirizzo Email attivo.';
$lng['error']['destinationalreadyexist'] = 'Hai già definito un reindirizzamento per %s .';
$lng['error']['destinationiswrong'] = 'Il reindirizzamento %s contiene caratteri invalidi o è incompleto.';
$lng['error']['domainname'] = $lng['domains']['domainname'];

/**
 * Questions
 */

$lng['question']['question'] = 'Domanda di sicurezza';
$lng['question']['admin_customer_reallydelete'] = 'Sei sicuro di voler cancellare il cliente %s? Quest\'azione non potrà essere annullata!';
$lng['question']['admin_domain_reallydelete'] = 'Sei sicuro di voler cancellare il dominio %s?';
$lng['question']['admin_domain_reallydisablesecuritysetting'] = 'Sei sicuro di voler disattivare queste opzioni di sicurezza (OpenBasedir e/o SafeMode)?';
$lng['question']['admin_admin_reallydelete'] = 'Sei sicuro di voler cancellare l\'admin %s? Tutti i clienti e i domini saranno affidati all\'amministratore principale.';
$lng['question']['admin_template_reallydelete'] = 'Sei sicuro di voler cancellare il template \'%s\'?';
$lng['question']['domains_reallydelete'] = 'Sei sicuro di voler cancellare il dominio %s?';
$lng['question']['email_reallydelete'] = 'Sei sicuro di voler cancellare l\'indirizzo Email %s?';
$lng['question']['email_reallydelete_account'] = 'Sei sicuro di voler cancellare l\'account Email di %s?';
$lng['question']['email_reallydelete_forwarder'] = 'Sei sicuro di voler cancellare il reindirizzamento a %s?';
$lng['question']['extras_reallydelete'] = 'Sei sicuro di voler cancellare la protezione per la cartella %s?';
$lng['question']['extras_reallydelete_pathoptions'] = 'Sei sicuro di voler cancellare le opzioni cartella per %s?';
$lng['question']['ftp_reallydelete'] = 'Sei sicuro di voler cancellare l\'account FTP %s?';
$lng['question']['mysql_reallydelete'] = 'Sei sicuro di voler cancellare il database %s? Quest\'azione non potrà essere annullata!';
$lng['question']['admin_configs_reallyrebuild'] = 'Sei sicuro di voler rigenerare i file di configurazione per Apache e Bind?';

/**
 * Mails
 */

$lng['mails']['pop_success']['mailbody'] = 'Salve,\n\nil tuo indirizzo Email {EMAIL}\nè stato configurato con successo.\n\nQuesta è un\'Email creata automaticamente,\n per favore non rispondere!\n\nCordiali saluti, Froxlor-Team.';
$lng['mails']['pop_success']['subject'] = 'Indirizzo Email configurato con successo';
$lng['mails']['createcustomer']['mailbody'] = 'Salve {FIRSTNAME} {NAME},\n\nqueste sono le informazioni per il tuo account:\n\nNome Utente: {USERNAME}\nPassword: {PASSWORD}\n\nGrazie,\nFroxlor-Team.';
$lng['mails']['createcustomer']['subject'] = 'Informazioni account';

/**
 * Admin
 */

$lng['admin']['overview'] = 'Visione d\'insieme';
$lng['admin']['ressourcedetails'] = 'Risorse utilizzate';
$lng['admin']['systemdetails'] = 'Dettagli sistema';
$lng['admin']['froxlordetails'] = 'Dettagli Froxlor';
$lng['admin']['installedversion'] = 'Versione installata';
$lng['admin']['latestversion'] = 'Ultima versione disponibile';
$lng['admin']['lookfornewversion']['clickhere'] = 'Cerca sul web';
$lng['admin']['lookfornewversion']['error'] = 'Errore durante la lettura';
$lng['admin']['resources'] = 'Risorse';
$lng['admin']['customer'] = 'Cliente';
$lng['admin']['customers'] = 'Clienti';
$lng['admin']['customer_add'] = 'Crea cliente';
$lng['admin']['customer_edit'] = 'Modifica cliente';
$lng['admin']['domains'] = 'Domini';
$lng['admin']['domain_add'] = 'Crea dominio';
$lng['admin']['domain_edit'] = 'Modifica dominio';
$lng['admin']['subdomainforemail'] = 'Sottodominio utilizzabile come dominio Email';
$lng['admin']['admin'] = 'Admin';
$lng['admin']['admins'] = 'Admin';
$lng['admin']['admin_add'] = 'Crea admin';
$lng['admin']['admin_edit'] = 'Modifica admin';
$lng['admin']['customers_see_all'] = 'Può vedere tutti i clienti?';
$lng['admin']['domains_see_all'] = 'Può vedere tutti i domini?';
$lng['admin']['change_serversettings'] = 'Può cambiare le impostazioni del server?';
$lng['admin']['server'] = 'Server';
$lng['admin']['serversettings'] = 'Opzioni';
$lng['admin']['rebuildconf'] = 'Rigenera file di configurazione';
$lng['admin']['stdsubdomain'] = 'Sottodominio standard';
$lng['admin']['stdsubdomain_add'] = 'Crea sottodominio standard';
$lng['admin']['deactivated'] = 'Disattiva';
$lng['admin']['deactivated_user'] = 'Disattiva utente';
$lng['admin']['sendpassword'] = 'Invia password';
$lng['admin']['ownvhostsettings'] = 'Impostazioni vHost speciali';
$lng['admin']['configfiles']['serverconfiguration'] = 'Configurazione servizi';
$lng['admin']['configfiles']['files'] = '<b>File di configurazione:</b> Per favore cambia questi file o creali<br />se non esistono, con il seguente contenuto.<br /><b>NOTA:</b> La password di MySQL non è stata rimpiazzata per ragioni di sicurezza.<br />Per favore rimpiazza &quot;MYSQL_PASSWORD&quot; con la password MySQL dell\'utente Froxlor. Se hai dimenticato la password per MySQL<br />la trovi in &quot;lib/userdata.inc.php&quot;.';
$lng['admin']['configfiles']['commands'] = '<b>Comandi:</b> Per favore esegui i seguenti comandi in una shell.';
$lng['admin']['configfiles']['restart'] = '<b>Ricarica:</b> Per favore esegui i seguenti comandi (in ordine) in una shell per ricaricare la configurazione.';
$lng['admin']['templates']['templates'] = 'Template';
$lng['admin']['templates']['template_add'] = 'Aggiungi template';
$lng['admin']['templates']['template_edit'] = 'Modifica template';
$lng['admin']['templates']['action'] = 'Azione';
$lng['admin']['templates']['email'] = 'Email';
$lng['admin']['templates']['subject'] = 'Soggetto:';
$lng['admin']['templates']['mailbody'] = 'Testo dell\'Email';
$lng['admin']['templates']['createcustomer'] = 'Email di benvenuto per i nuovi clienti';
$lng['admin']['templates']['pop_success'] = 'Benevenuto per ogni nuovo account Email';
$lng['admin']['templates']['template_replace_vars'] = 'Variabili da cambiare nel template:';
$lng['admin']['templates']['FIRSTNAME'] = 'Rimpiazzato con il nome del cliente.';
$lng['admin']['templates']['NAME'] = 'Rimpiazzato con il cognome del cliente.';
$lng['admin']['templates']['USERNAME'] = 'Rimpiazzato con il nome utente dell\'account.';
$lng['admin']['templates']['PASSWORD'] = 'Rimpiazzato con la password dell\'account.';
$lng['admin']['templates']['EMAIL'] = 'Rimapiazzato con l\'indirizzo dell\'account.';

/**
 * Serversettings
 */

$lng['serversettings']['session_timeout']['title'] = 'Timeout della sessione';
$lng['serversettings']['session_timeout']['description'] = 'Quanto tempo un utente deve rimanere inattivo prima che la sessione diventi invalida (secondi)?';
$lng['serversettings']['accountprefix']['title'] = 'Prefisso Cliente';
$lng['serversettings']['accountprefix']['description'] = 'Che prefisso dovrebbero avere gli account dei clienti?';
$lng['serversettings']['mysqlprefix']['title'] = 'Prefisso SQL';
$lng['serversettings']['mysqlprefix']['description'] = 'Che prefisso dovrebbero avere i database SQL?';
$lng['serversettings']['ftpprefix']['title'] = 'Prefisso FTP';
$lng['serversettings']['ftpprefix']['description'] = 'Che prefisso dovrebbero avere gli account FTP?';
$lng['serversettings']['documentroot_prefix']['title'] = 'Cartella dati web';
$lng['serversettings']['documentroot_prefix']['description'] = 'Dove devono essere immagazzinati tutti i dati web?';
$lng['serversettings']['logfiles_directory']['title'] = 'Cartella logfiles';
$lng['serversettings']['logfiles_directory']['description'] = 'Dove devono essere immagazzinati tutti i log?';
$lng['serversettings']['ipaddress']['title'] = 'Indirizzo IP';
$lng['serversettings']['ipaddress']['description'] = 'Qual\'è l\'indirizzo IP di questo server?';
$lng['serversettings']['hostname']['title'] = 'Hostname';
$lng['serversettings']['hostname']['description'] = 'QUal\'è l\'hostname di questo server?';
$lng['serversettings']['apachereload_command']['title'] = 'Comando riavvio Apache';
$lng['serversettings']['apachereload_command']['description'] = 'Qual\'è il comando per riavviare Apache?';
$lng['serversettings']['bindconf_directory']['title'] = 'Cartella configurazione Bind';
$lng['serversettings']['bindconf_directory']['description'] = 'Dove sono i file di configurazione per Bind?';
$lng['serversettings']['bindreload_command']['title'] = 'Comando riavvio Bind';
$lng['serversettings']['bindreload_command']['description'] = 'Qual\'è il comando per riavviare Bind?';
$lng['serversettings']['binddefaultzone']['title'] = 'Zona di default Bind';
$lng['serversettings']['binddefaultzone']['description'] = 'Qual\'è il nome della zona di default Bind?';
$lng['serversettings']['vmail_uid']['title'] = 'UID Email';
$lng['serversettings']['vmail_uid']['description'] = 'Che UserID dovrebbe avere l\'utente che gestisce le Email?';
$lng['serversettings']['vmail_gid']['title'] = 'GID Email';
$lng['serversettings']['vmail_gid']['description'] = 'Che GroupID dovrebbe avere l\'utente che gestisce le Email?';
$lng['serversettings']['vmail_homedir']['title'] = 'Cartella Email';
$lng['serversettings']['vmail_homedir']['description'] = 'Dove devono essere immagazzinate tutte le Email?';
$lng['serversettings']['adminmail']['title'] = 'Mittente';
$lng['serversettings']['adminmail']['description'] = 'Qual\'è l\'indirizzo del mittente delle Email provenienti dal pannello?';
$lng['serversettings']['phpmyadmin_url']['title'] = 'URL phpMyAdmin';
$lng['serversettings']['phpmyadmin_url']['description'] = 'Qual\'è l\'URL di phpMyAdmin? (deve cominciare per http://)';
$lng['serversettings']['webmail_url']['title'] = 'URL WebMail';
$lng['serversettings']['webmail_url']['description'] = 'Qual\'è l\'URL della WebMail? (deve cominciare per http://)';
$lng['serversettings']['webftp_url']['title'] = 'URL WebFTP';
$lng['serversettings']['webftp_url']['description'] = 'Qual\'è l\'URL del WebFTP? (deve cominciare per http://)';
$lng['serversettings']['language']['description'] = 'Qual\'è la lingua standard del tuo server?';
$lng['serversettings']['maxloginattempts']['title'] = 'Numero massimo tentativi login';
$lng['serversettings']['maxloginattempts']['description'] = 'Numero massimo di tentativi di login prima che l\'account sia disattivato.';
$lng['serversettings']['deactivatetime']['title'] = 'Durata disattivamento';
$lng['serversettings']['deactivatetime']['description'] = 'Tempo (sec.) di disattivazione dell\'account dopo troppi tentativi di login.';
$lng['serversettings']['pathedit']['title'] = 'Modalità di scelta percorsi/cartelle';
$lng['serversettings']['pathedit']['description'] = 'Un percorso/cartella andrà scelto attraverso un menu a tendina o inserendolo a mano?';

/**
 * New strings
 */

$lng['admin']['cronlastrun'] = 'Ultimo Cronjob';
$lng['serversettings']['paging']['title'] = 'Elementi da visualizzare per pagina';
$lng['serversettings']['paging']['description'] = 'Quanti elementi dovrebbero essere visualizzati su una pagina? (0 = disattiva impaginazione)';
$lng['error']['ipstillhasdomains'] = 'La combinazione IP/Porta che vuoi eliminare ha ancora dei domini assegnati, per favore riassegna questi domini ad altre combinazioni IP/Porta prima di eliminare questa.';
$lng['error']['cantdeletedefaultip'] = 'Non puoi eliminare la combinazione IP/Porta default dei rivenditori, per favore imposta un\'altra combinazione IP/Porta come default dei rivenditori prima di eliminare questa.';
$lng['error']['cantdeletesystemip'] = 'Non puoi eliminare l\'ultima IP di sistema, crea un\'altra combinazione IP/Porta per l\'IP di sistema o cambia l\'IP di sistema.';
$lng['error']['myipaddress'] = '\'IP\'';
$lng['error']['myport'] = '\'Porta\'';
$lng['error']['myipdefault'] = 'Devi selezionare una combinazione IP/Porta che diventerà default.';
$lng['error']['myipnotdouble'] = 'Questa combinazione IP/Porta esiste già.';
$lng['question']['admin_ip_reallydelete'] = 'Vuoi veramente eliminare l\'indirizzo IP %s?';
$lng['admin']['ipsandports']['ipsandports'] = 'IP e Porte';
$lng['admin']['ipsandports']['add'] = 'Aggiungi IP/Porta';
$lng['admin']['ipsandports']['edit'] = 'Modifica IP/Porta';
$lng['admin']['ipsandports']['ipandport'] = 'IP/Porta';
$lng['admin']['ipsandports']['ip'] = 'IP';
$lng['admin']['ipsandports']['port'] = 'Porta';
$lng['error']['cantchangesystemip'] = 'Non puoi cambiare l\'ultima IP di sistema, crea un\'altra combinazione IP/Porta per l\'IP di sistema o cambia l\'IP di sistema.';
$lng['question']['admin_domain_reallydocrootoutofcustomerroot'] = 'Sei sicuro di volere la cartella base dei dati web di questo dominio al di fuori  della cartella base del cliente?';
$lng['admin']['memorylimitdisabled'] = 'Disabilitato';
$lng['error']['loginnameissystemaccount'] = 'Non puoi creare account con nomi simili agli account di sistema. Per favore cambia il nome dell\'account.';
$lng['domain']['openbasedirpath'] = 'Percorso OpenBasedir';
$lng['domain']['docroot'] = 'Percorso del campo sopra';
$lng['domain']['homedir'] = 'Cartella Home';
$lng['admin']['valuemandatory'] = 'Questo valore è obbligatorio';
$lng['admin']['valuemandatorycompany'] = 'O i campi "nome" e "cognome" O il capo "compagnia" devono essere riempiti';
$lng['menue']['main']['username'] = 'Connesso come utente: ';
$lng['panel']['urloverridespath'] = 'URL (sovrascrive il percorso)';
$lng['panel']['pathorurl'] = 'Percorso o URL';
$lng['error']['sessiontimeoutiswrong'] = '&quot;Timeout Sessione&quot; deve essere un numero.';
$lng['error']['maxloginattemptsiswrong'] = '&quot;Numero Massimo Tentativi Login&quot; deve essere un numero.';
$lng['error']['deactivatetimiswrong'] = '&quot;Durata Disattivamento&quot; deve essere un numero.';
$lng['error']['accountprefixiswrong'] = '&quopt;Prefisso Utente&quot; incorretto.';
$lng['error']['mysqlprefixiswrong'] = '&quopt;Prefisso SQL&quot; incorretto.';
$lng['error']['ftpprefixiswrong'] = '&quopt;Prefisso FTP&quot; incorretto.';
$lng['error']['ipiswrong'] = '&quot;Indirizzo IP&quot; incorretto. È permesso solo un indirizzo IP valido.';
$lng['error']['vmailuidiswrong'] = '&quot;UID Email&quot; incorretto. È permessa solo una UID numerica.';
$lng['error']['vmailgidiswrong'] = '&quot;GID Email&quot; incorretto. È permessa solo una GID numerica.';
$lng['error']['adminmailiswrong'] = '&quot;Mittente&quot; incorretto. È permesso solo un indirizzo Email valido.';
$lng['error']['pagingiswrong'] = 'Valore degli &quot;Elementi da visualizzare per pagina&quot; incorretto. Sono permessi solo numeri.';
$lng['error']['phpmyadminiswrong'] = 'Il link a phpMyAdmin è invalido.';
$lng['error']['webmailiswrong'] = 'Il link alla WebMail è invalido.';
$lng['error']['webftpiswrong'] = 'Il link al WebFTP è invalido.';
$lng['domains']['hasaliasdomains'] = 'Ha domini alias';
$lng['serversettings']['defaultip']['title'] = 'IP/Porta default';
$lng['serversettings']['defaultip']['description'] = 'Qual\'è la combinazione IP/Porta default?';
$lng['domains']['statstics'] = 'Statistiche d\'utilizzo';
$lng['panel']['ascending'] = 'ascendente';
$lng['panel']['decending'] = 'discendente';
$lng['panel']['search'] = 'Cerca';
$lng['panel']['used'] = 'utilizzato';
$lng['panel']['translator'] = 'Traduttore';
$lng['error']['stringformaterror'] = 'Il valore per il campo &quot;%s&quot; non è nel formato atteso.';

// Translated by marone42@googlemail.com on 03/15/2007 (see https://trac.froxlor.org/ticket/126#comment:21)

$lng['admin']['serversoftware'] = 'Serversoftware';
$lng['admin']['phpversion'] = 'Versione PHP';
$lng['admin']['phpmemorylimit'] = 'PHP-Memory-Limit';
$lng['admin']['mysqlserverversion'] = 'Versione MySQL Server';
$lng['admin']['mysqlclientversion'] = 'Version MySQL Client';
$lng['admin']['webserverinterface'] = 'Interfaccia Webserver';
$lng['domains']['isassigneddomain'] = '&Egrave; dominio assegnato';
$lng['serversettings']['phpappendopenbasedir']['title'] = 'Percoso da aggiungere a OpenBasedir';
$lng['serversettings']['phpappendopenbasedir']['description'] = 'Questi percorsi (separati da colonne) verranno aggiunti allo statement OpenBasedir in ognuno vhost-container.';

?>
