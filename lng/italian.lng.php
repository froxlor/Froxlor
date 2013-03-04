<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2003-2009 the SysCP Team (see authors).
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Luca Piona <info@havanastudio.ch>
 * @author     Luca Longinotti <chtekk@gentoo.org>
 * @author     Emilien
 * @author     Froxlor Team <team@froxlor.org>
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Language
 *
 */

/**
 * Global
 */

$lng['translator'] = 'Luca Longinotti  Luca Piona  Emilien';
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
 * E-mails
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
$lng['question']['admin_domain_reallydisablesecuritysetting'] = 'Sei sicuro di voler disattivare queste opzioni di sicurezza (OpenBasedir)?';
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
$lng['question']['admin_customer_alsoremovefiles'] = 'Cancellare anche i file dell\'utente?';

/**
 * Mails
 */

$lng['mails']['pop_success']['mailbody'] = 'Salve,\n\nil tuo indirizzo Email {EMAIL}\nè stato configurato con successo.\n\nQuesta è un\'Email creata automaticamente,\n per favore non rispondere!\n\nCordiali saluti, Amministratore.';
$lng['mails']['pop_success']['subject'] = 'Indirizzo Email configurato con successo';
$lng['mails']['createcustomer']['mailbody'] = 'Salve {FIRSTNAME} {NAME},\n\nqueste sono le informazioni per il tuo account:\n\nNome Utente: {USERNAME}\nPassword: {PASSWORD}\n\nGrazie,\nAmministratore.';
$lng['mails']['createcustomer']['subject'] = 'Informazioni account';

/**
 * Admin
 */

$lng['admin']['overview'] = 'Generale';
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
$lng['admin']['rebuildconf'] = 'Rigenera configurazione';
$lng['admin']['stdsubdomain'] = 'Sottodominio standard';
$lng['admin']['stdsubdomain_add'] = 'Crea sottodominio standard';
$lng['admin']['phpenabled'] = 'PHP abilitato';
$lng['admin']['deactivated'] = 'Disattiva';
$lng['admin']['deactivated_user'] = 'Disattiva utente';
$lng['admin']['sendpassword'] = 'Invia password';
$lng['admin']['ownvhostsettings'] = 'Impostazioni vHost speciali';
$lng['admin']['configfiles']['serverconfiguration'] = 'Configurazione servizi';
$lng['admin']['configfiles']['files'] = '<b>File di configurazione:</b> Per favore cambia questi file o creali<br />se non esistono, con il seguente contenuto.<br /><b>NOTA:</b> La password di MySQL non è stata rimpiazzata per ragioni di sicurezza.<br />Per favore rimpiazza "MYSQL_PASSWORD" con la password MySQL dell\'utente Froxlor. Se hai dimenticato la password per MySQL<br />la trovi in "lib/userdata.inc.php".';
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
$lng['admin']['templates']['pop_success'] = 'Benvenuto per ogni nuovo account Email';
$lng['admin']['templates']['template_replace_vars'] = 'Variabili da cambiare nel template:';
$lng['admin']['templates']['FIRSTNAME'] = 'Rimpiazzato con il nome del cliente.';
$lng['admin']['templates']['NAME'] = 'Rimpiazzato con il cognome del cliente.';
$lng['admin']['templates']['USERNAME'] = 'Rimpiazzato con il nome utente dell\'account.';
$lng['admin']['templates']['PASSWORD'] = 'Rimpiazzato con la password dell\'account.';
$lng['admin']['templates']['EMAIL'] = 'Rimapiazzato con l\'indirizzo dell\'account.';
$lng['admin']['webserver'] = 'Server Web';

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
$lng['serversettings']['nameservers']['title'] = 'Nameservers';
$lng['serversettings']['nameservers']['description'] = 'Lista degli hostname (separati dalla virgola) di tutti i nameserver. Il primo della lista sarà il impostato come primario.';
$lng['serversettings']['mxservers']['title'] = 'MX servers';
$lng['serversettings']['mxservers']['description'] = 'Lista dei server mx (separati dalla virgola) numero spazio hostname (es. \'10 mx.example.com\').';

/**
 * CHANGED BETWEEN 1.2.12 and 1.2.13
 */

$lng['mysql']['description'] = 'Qui puoi creare e modificare il tuo database MySQL<br />Le modifiche sono istantanee e puoi usare subito il database.<br />Nel menù a sinistra trovi phpMyAdmin con cui puoi amministrare il tuo database.<br /><br />Per usare i database nei tuoi script php usa le seguenti impostazioni: (Le parole in <i>corsivo</i> devono essere modificate con quello che hai scritto!)<br />Hostname: <b><SQL_HOST></b><br />Utente: <b><i>Nome database</i></b><br />Password: <b><i>La password che hai scelto</i></b><br />Database: <b><i>Nome database</i></b>';

/**
 * ADDED BETWEEN 1.2.12 and 1.2.13
 */

$lng['serversettings']['paging']['title'] = 'Elementi da visualizzare per pagina';
$lng['serversettings']['paging']['description'] = 'Quanti elementi dovrebbero essere visualizzati su una pagina? (0 = disattiva impaginazione)';
$lng['error']['ipstillhasdomains'] = 'La combinazione IP/Porta che vuoi eliminare ha ancora dei domini assegnati, per favore riassegna questi domini ad altre combinazioni IP/Porta prima di eliminare questa.';
$lng['error']['cantdeletedefaultip'] = 'Non puoi eliminare la combinazione IP/Porta default dei rivenditori, per favore imposta un\'altra combinazione IP/Porta come default dei rivenditori prima di eliminare questa.';
$lng['error']['cantdeletesystemip'] = 'Non puoi eliminare l\'ultima IP di sistema, crea un\'altra combinazione IP/Porta per l\'IP di sistema o cambia l\'IP di sistema.';
$lng['error']['myipaddress'] = '\'IP\'';
$lng['error']['myport'] = '\'Porta\'';
$lng['error']['myipdefault'] = 'Devi selezionare una combinazione IP/Porta che diventerà default.';
$lng['error']['myipnotdouble'] = 'Questa combinazione IP/Porta esiste già.';
$lng['error']['admin_domain_emailsystemhostname'] = 'Non puoi usare l\'hostname del server come dominio email';
$lng['question']['admin_ip_reallydelete'] = 'Vuoi veramente eliminare l\'indirizzo IP %s?';
$lng['admin']['ipsandports']['ipsandports'] = 'IP e Porte';
$lng['admin']['ipsandports']['add'] = 'Aggiungi IP/Porta';
$lng['admin']['ipsandports']['edit'] = 'Modifica IP/Porta';
$lng['admin']['ipsandports']['ipandport'] = 'IP/Porta';
$lng['admin']['ipsandports']['ip'] = 'IP';
$lng['admin']['ipsandports']['port'] = 'Porta';

// ADDED IN 1.2.13-rc3

$lng['error']['cantchangesystemip'] = 'Non puoi cambiare l\'ultima IP di sistema, crea un\'altra combinazione IP/Porta per l\'IP di sistema o cambia l\'IP di sistema.';
$lng['question']['admin_domain_reallydocrootoutofcustomerroot'] = 'Sei sicuro di volere la cartella base dei dati web di questo dominio al di fuori  della cartella base del cliente?';

// ADDED IN 1.2.14-rc1

$lng['admin']['memorylimitdisabled'] = 'Disabilitato';
$lng['error']['loginnameissystemaccount'] = 'Non puoi creare account con nomi simili agli account di sistema. Per favore cambia il nome dell\'account.';
$lng['domain']['openbasedirpath'] = 'Percorso OpenBasedir';
$lng['domain']['docroot'] = 'Percorso del campo sopra';
$lng['domain']['homedir'] = 'Cartella Home';
$lng['admin']['valuemandatory'] = 'Questo valore è obbligatorio';
$lng['admin']['valuemandatorycompany'] = 'O i campi "nome" e "cognome" O il capo "compagnia" devono essere riempiti';
$lng['menue']['main']['username'] = 'Utente: ';
$lng['panel']['urloverridespath'] = 'URL (sovrascrive il percorso)';
$lng['panel']['pathorurl'] = 'Percorso o URL';
$lng['error']['sessiontimeoutiswrong'] = '"Timeout Sessione" deve essere un numero.';
$lng['error']['maxloginattemptsiswrong'] = '"Numero Massimo Tentativi Login" deve essere un numero.';
$lng['error']['deactivatetimiswrong'] = '"Durata Disattivamento" deve essere un numero.';
$lng['error']['accountprefixiswrong'] = '&quopt;Prefisso Utente" incorretto.';
$lng['error']['mysqlprefixiswrong'] = '&quopt;Prefisso SQL" incorretto.';
$lng['error']['ftpprefixiswrong'] = '&quopt;Prefisso FTP" incorretto.';
$lng['error']['ipiswrong'] = '"Indirizzo IP" incorretto. È permesso solo un indirizzo IP valido.';
$lng['error']['vmailuidiswrong'] = '"UID Email" incorretto. È permessa solo una UID numerica.';
$lng['error']['vmailgidiswrong'] = '"GID Email" incorretto. È permessa solo una GID numerica.';
$lng['error']['adminmailiswrong'] = '"Mittente" incorretto. È permesso solo un indirizzo Email valido.';
$lng['error']['pagingiswrong'] = 'Valore degli "Elementi da visualizzare per pagina" incorretto. Sono permessi solo numeri.';
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

// ADDED IN 1.2.14-rc3

$lng['panel']['translator'] = 'Traduttore';

// ADDED IN 1.2.14-rc4

$lng['error']['stringformaterror'] = 'Il valore per il campo "%s" non è nel formato atteso.';

// ADDED IN 1.2.15-rc1
// Translated by marone42@googlemail.com on 03/15/2007 (see https://trac.froxlor.org/ticket/126#comment:21)

$lng['admin']['serversoftware'] = 'Serversoftware';
$lng['admin']['phpversion'] = 'Versione PHP';
$lng['admin']['phpmemorylimit'] = 'PHP-Memory-Limit';
$lng['admin']['mysqlserverversion'] = 'Versione MySQL Server';
$lng['admin']['mysqlclientversion'] = 'Version MySQL Client';
$lng['admin']['webserverinterface'] = 'Interfaccia Webserver';
$lng['domains']['isassigneddomain'] = 'È dominio assegnato';
$lng['serversettings']['phpappendopenbasedir']['title'] = 'Percoso da aggiungere a OpenBasedir';
$lng['serversettings']['phpappendopenbasedir']['description'] = 'Questi percorsi (separati da colonne) verranno aggiunti allo statement OpenBasedir in ognuno vhost-container.';

// CHANGED IN 1.2.15-rc1

$lng['error']['loginnameissystemaccount'] = 'Non puoi creare account che siano analoghi a quelli di sistema (per esempio quelli che iniziano con "%s"). Digita un\'altro nome account.';
$lng['error']['youcantdeleteyourself'] = 'Non puoi cancellare te stesso per motivi di sicurezza.';
$lng['error']['youcanteditallfieldsofyourself'] = 'Nota: non puoi modificare tutti i campi del tuo account per motivi di sicurezza.';

// ADDED IN 1.2.16-svn1

$lng['serversettings']['natsorting']['title'] = 'Usa l\'ordinamento naturale in vista elenco';
$lng['serversettings']['natsorting']['description'] = 'Disponi la lista come web1 -> web2 -> web11 al posto di web1 -> web11 -> web2.';

// ADDED IN 1.2.16-svn2

$lng['serversettings']['deactivateddocroot']['title'] = 'Docroot per gli utenti disattivati';
$lng['serversettings']['deactivateddocroot']['description'] = 'Quando un utente viene disattivato questo percorso viene usato come suo docroot. Lascia vuoto per non creare un vhost a tutti.';

// ADDED IN 1.2.16-svn4

$lng['panel']['reset'] = 'Annulla le modifiche';
$lng['admin']['accountsettings'] = 'Impostazioni Account';
$lng['admin']['panelsettings'] = 'Impostazioni Pannello';
$lng['admin']['systemsettings'] = 'Impostazioni di Sistema';
$lng['admin']['webserversettings'] = 'Impostazioni Server Web';
$lng['admin']['mailserversettings'] = 'Impostazioni Server di Posta';
$lng['admin']['nameserversettings'] = 'Impostazioni Nameserver';
$lng['admin']['updatecounters'] = 'Ricalcolo risorse';
$lng['question']['admin_counters_reallyupdate'] = 'Sei sicuro di voler ricacolare il consumo delle risorse?';
$lng['panel']['pathDescription'] = 'Se la cartella non esiste, viene creata automaticamente.';

// ADDED IN 1.2.16-svn6

$lng['mails']['trafficninetypercent']['mailbody'] = 'Salve {NAME},\n\nHai usato {TRAFFICUSED} MB su {TRAFFIC} MB di traffico disponibile.\nPiù del 90%.\n\nCordiali Saluti, Amministratore.';
$lng['mails']['trafficninetypercent']['subject'] = 'Hai raggiunto il limite di Traffico';
$lng['admin']['templates']['trafficninetypercent'] = 'Notifica email per i clienti che hanno superato il 90% del traffico';
$lng['admin']['templates']['TRAFFIC'] = 'Sostituito con il traffico che è stato assegnato al cliente.';
$lng['admin']['templates']['TRAFFICUSED'] = 'Sostituito con il traffico che è stato usato dal cliente.';

// ADDED IN 1.2.16-svn7

$lng['admin']['subcanemaildomain']['never'] = 'Mai';
$lng['admin']['subcanemaildomain']['choosableno'] = 'Selezionabile, predefinito no';
$lng['admin']['subcanemaildomain']['choosableyes'] = 'Selezionabile, predefinito si';
$lng['admin']['subcanemaildomain']['always'] = 'Sempre';
$lng['changepassword']['also_change_webalizer'] = ' modificare anche la password di webalizer';

// ADDED IN 1.2.16-svn8

$lng['serversettings']['mailpwcleartext']['title'] = 'Salva le password in chiaro degli account email nel database';
$lng['serversettings']['mailpwcleartext']['description'] = 'Se impostato a Si, tutte le password saranno salvate in chiaro (saranno leggibili a chiunque abbia accesso al database) nella tabella mail_users. Attiva questa opzione solo se necessaria!';
$lng['serversettings']['mailpwcleartext']['removelink'] = 'Clicca qui per cancellare tutte le password in chiaro dalla tabella.';
$lng['question']['admin_cleartextmailpws_reallywipe'] = 'Sei sicuro di voler cancellare tutte le password in chiaro degli account email dalla tabella mail_users? Attenzione non si può tornare indietro!';
$lng['admin']['configfiles']['overview'] = 'Panoramica';
$lng['admin']['configfiles']['wizard'] = 'Wizard';
$lng['admin']['configfiles']['distribution'] = 'Distribuzione';
$lng['admin']['configfiles']['service'] = 'Servizio';
$lng['admin']['configfiles']['daemon'] = 'Demone';
$lng['admin']['configfiles']['http'] = 'Webserver (HTTP)';
$lng['admin']['configfiles']['dns'] = 'Nameserver (DNS)';
$lng['admin']['configfiles']['mail'] = 'Mailserver (IMAP/POP3)';
$lng['admin']['configfiles']['smtp'] = 'Mailserver (SMTP)';
$lng['admin']['configfiles']['ftp'] = 'FTP-Server';
$lng['admin']['configfiles']['etc'] = 'Altro (Sistema)';
$lng['admin']['configfiles']['choosedistribution'] = '-- Scegli una distribuzione --';
$lng['admin']['configfiles']['chooseservice'] = '-- Scegli un servizio --';
$lng['admin']['configfiles']['choosedaemon'] = '-- Scegli un demone --';

// ADDED IN 1.2.16-svn10

$lng['serversettings']['ftpdomain']['title'] = 'Account FTP @domain';
$lng['serversettings']['ftpdomain']['description'] = 'I Clienti possono creare account ftp utente@dominiocliente?';
$lng['panel']['back'] = 'Indietro';

// ADDED IN 1.2.16-svn12

$lng['serversettings']['mod_log_sql']['title'] = 'Salva i log temporaneamente nel database';
$lng['serversettings']['mod_log_sql']['description'] = 'Usa <a target="blank" href="http://www.outoforder.cc/projects/apache/mod_log_sql/" title="mod_log_sql">mod_log_sql</a> per salvare temporaneamente le richieste web<br /><b>Questo richiede una <a target="blank" href="http://files.froxlor.org/docs/mod_log_sql/" title="mod_log_sql - documentation">configurazione di apache</a> particolare!</b>';
$lng['serversettings']['mod_fcgid']['title'] = 'Includi PHP via mod_fcgid/suexec';
$lng['serversettings']['mod_fcgid']['description'] = 'Usa mod_fcgid/suexec/libnss_mysql per avviare PHP con il corrispondente account-utente.<br/><b>Questo richiede una speciale configurazione del Webserver. Tutte le opzioni seguenti sono validi solo se il modulo è abilitato.</b>';
$lng['serversettings']['sendalternativemail']['title'] = 'Usa un\'indirizzo email alternativo';
$lng['serversettings']['sendalternativemail']['description'] = 'Invia la password dell\'email a un\'indirizzo diverso da quello creato';
$lng['emails']['alternative_emailaddress'] = 'Indirizzo email alternativo';
$lng['mails']['pop_success_alternative']['mailbody'] = 'Salve,\n\nil tuo account email {EMAIL}\nè stato creato correttamente.\nLa tua password è {PASSWORD}.\n\nQuesta è un\'email creata automaticamente,\n si prega di non rispondere a questa email!\n\nCordiali Saluti, Amministratore.';
$lng['mails']['pop_success_alternative']['subject'] = 'Account email creato correttamente';
$lng['admin']['templates']['pop_success_alternative'] = 'Email di Benvenuto spedita all\'indirizzo alternativo per i nuovi account email';
$lng['admin']['templates']['EMAIL_PASSWORD'] = 'Sostituito con la password dell\'account POP3/IMAP.';

// ADDED IN 1.2.16-svn13

$lng['error']['documentrootexists'] = 'La cartella "%s" è già presente per questo cliente. Cancella la cartella prima di aggiungere nuovamente il cliente.';

// ADDED IN 1.2.16-svn14

$lng['serversettings']['apacheconf_vhost']['title'] = 'File/cartella della configurazione vhost del Webserver';
$lng['serversettings']['apacheconf_vhost']['description'] = 'Dove vuoi che venga salvata la configurazione vhost? Qui puoi scegliere un file (tutti i vhosts in un file) o una cartella (ogni vhost avrà il suo file).';
$lng['serversettings']['apacheconf_diroptions']['title'] = 'Webserver diroptions configuration file/dirname';
$lng['serversettings']['apacheconf_diroptions']['description'] = 'Dove vuoi che venga salvata la configurazione dir-options? Qui puoi scegliere un file (tutti i vhosts in un file) o una cartella (ogni vhost avrà il suo file).';
$lng['serversettings']['apacheconf_htpasswddir']['title'] = 'Cartella htpasswd del Webserver';
$lng['serversettings']['apacheconf_htpasswddir']['description'] = 'Dove vuoi che vengano salvati i file htpasswd per la protezione delle cartelle?';

// ADDED IN 1.2.16-svn15

$lng['error']['formtokencompromised'] = 'La richiesta sembra essere compromessa. Per motivi di sicurezza sei stato disconnesso.';
$lng['serversettings']['mysql_access_host']['title'] = 'MySQL-Access-Hosts';
$lng['serversettings']['mysql_access_host']['description'] = 'Lista degli host (separati da una virgola) a cui gli utenti possono collegarsi al server MySQL.';

// ADDED IN 1.2.18-svn1

$lng['admin']['ipsandports']['create_listen_statement'] = 'Crea la direttiva Listen';
$lng['admin']['ipsandports']['create_namevirtualhost_statement'] = 'Crea la direttiva NameVirtualHost';
$lng['admin']['ipsandports']['create_vhostcontainer'] = 'Crea vHost-Container';
$lng['admin']['ipsandports']['create_vhostcontainer_servername_statement'] = 'Crea la direttiva ServerName in vHost-Container';

// ADDED IN 1.2.18-svn2

$lng['admin']['webalizersettings'] = 'Impostazioni Webalizer';
$lng['admin']['webalizer']['normal'] = 'Normale';
$lng['admin']['webalizer']['quiet'] = 'Modesto';
$lng['admin']['webalizer']['veryquiet'] = 'Niente';
$lng['serversettings']['webalizer_quiet']['title'] = 'Webalizer output';
$lng['serversettings']['webalizer_quiet']['description'] = 'Verbosità del programma webalizer';

// ADDED IN 1.2.18-svn3

$lng['ticket']['admin_email'] = 'root@localhost';
$lng['ticket']['noreply_email'] = 'tickets@froxlor';
$lng['admin']['ticketsystem'] = 'Supporto tecnico';
$lng['menue']['ticket']['ticket'] = 'Supporto ticket';
$lng['menue']['ticket']['categories'] = 'Categorie di supporto';
$lng['menue']['ticket']['archive'] = 'Archivio Ticket';
$lng['ticket']['description'] = 'Qui puoi inviare richieste di aiuto al supporto tecnico<br />La Notifica ti sarà spedita via e-mail.';
$lng['ticket']['ticket_new'] = 'Apri un nuovo ticket';
$lng['ticket']['ticket_reply'] = 'Rispondi al ticket';
$lng['ticket']['ticket_reopen'] = 'Riapri il ticket';
$lng['ticket']['ticket_newcateory'] = 'Crea una nuova categoria';
$lng['ticket']['ticket_editcateory'] = 'Modifica categoria';
$lng['ticket']['ticket_view'] = 'Visualizza il corso del ticket';
$lng['ticket']['ticketcount'] = 'Ticket';
$lng['ticket']['ticket_answers'] = 'Risposte';
$lng['ticket']['lastchange'] = 'Ultima azione';
$lng['ticket']['subject'] = 'Soggetto';
$lng['ticket']['status'] = 'Stato';
$lng['ticket']['lastreplier'] = 'Ultimo che ha risposto';
$lng['ticket']['priority'] = 'Priorità';
$lng['ticket']['low'] = 'Bassa';
$lng['ticket']['normal'] = 'Normale';
$lng['ticket']['high'] = 'Alta';
$lng['ticket']['lastchange'] = 'Ultima modifica';
$lng['ticket']['lastchange_from'] = 'Dalla data (dd.mm.yyyy)';
$lng['ticket']['lastchange_to'] = 'Alla data (dd.mm.yyyy)';
$lng['ticket']['category'] = 'Categoria';
$lng['ticket']['no_cat'] = 'Niente';
$lng['ticket']['message'] = 'Messaggio';
$lng['ticket']['show'] = 'Mostra';
$lng['ticket']['answer'] = 'Risposta';
$lng['ticket']['close'] = 'Chiudi';
$lng['ticket']['reopen'] = 'Riapri';
$lng['ticket']['archive'] = 'Archivio';
$lng['ticket']['ticket_delete'] = 'Cancella ticket';
$lng['ticket']['lastarchived'] = 'Ticket archiviati recentemente';
$lng['ticket']['archivedtime'] = 'Archiviato';
$lng['ticket']['open'] = 'Apri';
$lng['ticket']['wait_reply'] = 'In attesa di risposta';
$lng['ticket']['replied'] = 'Risposto';
$lng['ticket']['closed'] = 'Chiuso';
$lng['ticket']['staff'] = 'Staff';
$lng['ticket']['customer'] = 'Cliente';
$lng['ticket']['old_tickets'] = 'Messaggi Ticket';
$lng['ticket']['search'] = 'Ricerca Archivio';
$lng['ticket']['nocustomer'] = 'Nessuna scalta';
$lng['ticket']['archivesearch'] = 'Risultati della ricerca in archivio';
$lng['ticket']['noresults'] = 'Nessun ticket trovato';
$lng['ticket']['notmorethanxopentickets'] = 'Causa protezione antispam non si possono aprire più di %s ticket';
$lng['ticket']['supportstatus'] = 'Stato-Supporto';
$lng['ticket']['supportavailable'] = '<span class="ticket_low">I nostri tecnici sono disponibili ad aiutarti.</span>';
$lng['ticket']['supportnotavailable'] = '<span class="ticket_high">I nostri tecnici non sono al momento disponibili</span>';
$lng['admin']['templates']['ticket'] = 'Email di notifica del ticket';
$lng['admin']['templates']['SUBJECT'] = 'Sostituito con l\'oggetto del ticket';
$lng['admin']['templates']['new_ticket_for_customer'] = 'Informazioni clienti il ticket è stato inviato';
$lng['admin']['templates']['new_ticket_by_customer'] = 'Notifica Admin per un ticket aperto da un cliente';
$lng['admin']['templates']['new_reply_ticket_by_customer'] = 'Notifica Admin per una risposta di un ticket da un cliente';
$lng['admin']['templates']['new_ticket_by_staff'] = 'Notifica cliente per un ticket aperto dallo Staff';
$lng['admin']['templates']['new_reply_ticket_by_staff'] = 'Notifica cliente per una risposta di un ticket dallo Staff';
$lng['mails']['new_ticket_for_customer']['mailbody'] = 'Salve {FIRSTNAME} {NAME},\n\nil suo ticket con oggetto "{SUBJECT}" è stato spedito.\n\nRiceverai una notifica quando verrà data una risposta al tuo ticket.\n\nGrazie,\n Team Froxlor';
$lng['mails']['new_ticket_for_customer']['subject'] = 'Il tuo ticket è stato spedito al support';
$lng['mails']['new_ticket_by_customer']['mailbody'] = 'Salve amministratore,\n\nun nuovo ticket è stato aperto con oggetto: "{SUBJECT}".\n\nEffettua l\'accesso per aprire il ticket.\n\nGrazie,\n Team Froxlor';
$lng['mails']['new_ticket_by_customer']['subject'] = 'Il nuovo ticket è stato inviato';
$lng['mails']['new_reply_ticket_by_customer']['mailbody'] = 'Salve amministratore,\n\nil ticket con oggetto "{SUBJECT}" è stato replicato da un cliente.\n\nEffettua l\'accesso per aprire il ticket.\n\nGrazie,\n Team Froxlor';
$lng['mails']['new_reply_ticket_by_customer']['subject'] = 'È stato risposto ad un ticket';
$lng['mails']['new_ticket_by_staff']['mailbody'] = 'Salve {FIRSTNAME} {NAME},\n\nun nuovo ticket con oggetto "{SUBJECT}" è stato aperto a te.\n\nEffettua l\'accesso per aprire il ticket.\n\nGrazie,\n Team Froxlor';
$lng['mails']['new_ticket_by_staff']['subject'] = 'Il nuovo ticket è stato inviato';
$lng['mails']['new_reply_ticket_by_staff']['mailbody'] = 'Salve {FIRSTNAME} {NAME},\n\nil ticket con oggetto "{SUBJECT}" è stato replicato dal nostro Staff.\n\nEffettua l\'accesso per aprire il ticket.\n\nGrazie,\n Team Froxlor';
$lng['mails']['new_reply_ticket_by_staff']['subject'] = 'È stato risposto ad un ticket';
$lng['question']['ticket_reallyclose'] = 'Vuoi veramente chiudere il ticket"%s"?';
$lng['question']['ticket_reallydelete'] = 'Vuoi veramente cancellare il ticket"%s"?';
$lng['question']['ticket_reallydeletecat'] = 'Vuoi veramente eliminare la categoria "%s"?';
$lng['question']['ticket_reallyarchive'] = 'Vuoi veramente spostare il ticket "%s" in archivio?';
$lng['error']['mysubject'] = '\'' . $lng['ticket']['subject'] . '\'';
$lng['error']['mymessage'] = '\'' . $lng['ticket']['message'] . '\'';
$lng['error']['mycategory'] = '\'' . $lng['ticket']['category'] . '\'';
$lng['error']['nomoreticketsavailable'] = 'Sono stati usati tutti i ticket disponibili. Si prega di contattare l\'amministratore.';
$lng['error']['nocustomerforticket'] = 'Impossibile creare ticket senza clienti';
$lng['error']['categoryhastickets'] = 'La categoria contiene ancora ticket.<br />Si prega di cancellare i ticket per eliminare la categoria';
$lng['error']['notmorethanxopentickets'] = $lng['ticket']['notmorethanxopentickets'];
$lng['admin']['ticketsettings'] = 'Impostazioni Gestione Ticket';
$lng['admin']['archivelastrun'] = 'Ultimo ticket archiviato';
$lng['serversettings']['ticket']['noreply_email']['title'] = 'Non rispondere a questo indirizzo email';
$lng['serversettings']['ticket']['noreply_email']['description'] = 'L\'indirizzo email del mittente dei ticket di solito è no-reply@domain.tld';
$lng['serversettings']['ticket']['worktime_begin']['title'] = 'Ora inizio(hh:mm)';
$lng['serversettings']['ticket']['worktime_begin']['description'] = 'Ora di inizio quando il supporto è disponibile';
$lng['serversettings']['ticket']['worktime_end']['title'] = 'Ora fine (hh:mm)';
$lng['serversettings']['ticket']['worktime_end']['description'] = 'Ora di fine quando il supporto è online';
$lng['serversettings']['ticket']['worktime_sat'] = 'Il supporto è disponibile al sabato?';
$lng['serversettings']['ticket']['worktime_sun'] = 'Il supporto è disponibile la domenica?';
$lng['serversettings']['ticket']['worktime_all']['title'] = 'Nessun limite di tempo per il supporto ';
$lng['serversettings']['ticket']['worktime_all']['description'] = 'Se "Si" verranno sovrascritti gli orari di inizio e fine supporto';
$lng['serversettings']['ticket']['archiving_days'] = 'Dopo quanti giorni vengono archiviati automaticamente i ticket chiusi?';
$lng['customer']['tickets'] = 'Supporto tecnico - ticket';

// ADDED IN 1.2.18-svn4

$lng['admin']['domain_nocustomeraddingavailable'] = 'Adesso non è possibile aggiungere un dominio. Prima è necessario aggiungere almeno un cliente.';
$lng['serversettings']['ticket']['enable'] = 'Abilita il sistema ticket';
$lng['serversettings']['ticket']['concurrentlyopen'] = 'Quanti ticket si possono aprire in una sola volta?';
$lng['error']['norepymailiswrong'] = '"Noreply-address" è errato. È ammesso solo un indirizzo email corretto.';
$lng['error']['tadminmailiswrong'] = '"Ticketadmin-address" è errato. È ammesso solo un indirizzo email corretto.';
$lng['ticket']['awaitingticketreply'] = 'Hai %s ticket senza risposta';

// ADDED IN 1.2.18-svn5

$lng['serversettings']['ticket']['noreply_name'] = 'Email del mittente del ticket';

// ADDED IN 1.2.19-svn1

$lng['serversettings']['mod_fcgid']['configdir']['title'] = 'Cartella della configurazione';
$lng['serversettings']['mod_fcgid']['configdir']['description'] = 'Dove vuoi che venga salvata la configurazione di fcgid? Se non ti sei compilato suexec da solo, di solito questo percorso è /var/www/';
$lng['serversettings']['mod_fcgid']['tmpdir']['title'] = 'Cartella Temp';

// ADDED IN 1.2.19-svn3

$lng['serversettings']['ticket']['reset_cycle']['title'] = 'Resetta il numero di ticker per un determinato periodo';
$lng['serversettings']['ticket']['reset_cycle']['description'] = 'Resetta il numero di ticket che hanno usato i clienti per un determinato periodo';
$lng['admin']['tickets']['daily'] = 'Giornaliero';
$lng['admin']['tickets']['weekly'] = 'Settimanale';
$lng['admin']['tickets']['monthly'] = 'Mensile';
$lng['admin']['tickets']['yearly'] = 'Annuale';
$lng['error']['ticketresetcycleiswrong'] = 'Il periodo di reset del numero ticket può essere "Giornaliero", "Settimanale", "Mensile" or "Annuale".';

// ADDED IN 1.2.19-svn4

$lng['menue']['traffic']['traffic'] = 'Traffico';
$lng['menue']['traffic']['current'] = 'Mese corrente';
$lng['traffic']['month'] = "Mese";
$lng['traffic']['day'] = "Giorno";
$lng['traffic']['months'][1] = "Gennaio";
$lng['traffic']['months'][2] = "Febbraio";
$lng['traffic']['months'][3] = "Marzo";
$lng['traffic']['months'][4] = "Aprile";
$lng['traffic']['months'][5] = "Maggio";
$lng['traffic']['months'][6] = "Giugno";
$lng['traffic']['months'][7] = "Luglio";
$lng['traffic']['months'][8] = "Agosto";
$lng['traffic']['months'][9] = "Settembre";
$lng['traffic']['months'][10] = "Ottobre";
$lng['traffic']['months'][11] = "Novembre";
$lng['traffic']['months'][12] = "Dicembre";
$lng['traffic']['mb'] = "Traffico (MB)";
$lng['traffic']['distribution'] = '<font color="#019522">FTP</font> | <font color="#0000FF">HTTP</font> | <font color="#800000">Mail</font>';
$lng['traffic']['sumhttp'] = 'Sommatoria Traffico in ingresso HTTP';
$lng['traffic']['sumftp'] = 'Sommatoria Traffico in ingresso FTP';
$lng['traffic']['summail'] = 'Sommatoria Traffico in ingresso Mail';

// ADDED IN 1.2.19-svn4.5

$lng['serversettings']['no_robots']['title'] = 'Permetti ai robot dei motori di ricerca di indicizzare l\'installazione di Froxlor';

// ADDED IN 1.2.19-svn6

$lng['admin']['loggersettings'] = 'Impostazioni Log';
$lng['serversettings']['logger']['enable'] = 'Abilita/Disabilita Log';
$lng['serversettings']['logger']['severity'] = 'Livello Log';
$lng['admin']['logger']['normal'] = 'normale';
$lng['admin']['logger']['paranoid'] = 'paranoico';
$lng['serversettings']['logger']['types']['title'] = 'Tipo di Log';
$lng['serversettings']['logger']['types']['description'] = 'Specificare tipo di Log. Per selezionare più tipi, tenere premuto CTRL durante la selezione.<br />Tipi di log disponibili: syslog, file, mysql';
$lng['serversettings']['logger']['logfile'] = 'Percorso completo e nome del file del Log';
$lng['error']['logerror'] = 'Errore Log: %s';
$lng['serversettings']['logger']['logcron'] = 'Log cronjobs (one run)';
$lng['question']['logger_reallytruncate'] = 'Sei sicuro di voler troncare la tabella "%s"?';
$lng['admin']['loggersystem'] = 'Log di Sistema';
$lng['menue']['logger']['logger'] = 'Log di Sistema';
$lng['logger']['date'] = 'Data';
$lng['logger']['type'] = 'Tipo';
$lng['logger']['action'] = 'Azione';
$lng['logger']['user'] = 'Utente';
$lng['logger']['truncate'] = 'Log vuoto';

// ADDED IN 1.2.19-svn7

$lng['serversettings']['ssl']['use_ssl'] = 'Usa SSL';
$lng['serversettings']['ssl']['ssl_cert_file'] = 'Percorso del certificato SSL (SSL certificate)';
$lng['serversettings']['ssl']['openssl_cnf'] = 'Defaults per la creazione del file Cert';
$lng['panel']['reseller'] = 'rivenditore';
$lng['panel']['admin'] = 'amministratore';
$lng['panel']['customer'] = 'cliente/i';
$lng['error']['nomessagetosend'] = 'Non hai inserito un messaggio.';
$lng['error']['noreceipientsgiven'] = 'Non hai specificato alcun destinatario';
$lng['admin']['emaildomain'] = 'Email dominio';
$lng['admin']['email_only'] = 'Solo email?';
$lng['admin']['wwwserveralias'] = 'Aggiungi a "www." ServerAlias';
$lng['admin']['ipsandports']['enable_ssl'] = 'Questa è una porta SSL?';
$lng['admin']['ipsandports']['ssl_cert_file'] = 'Percorso del certificato SSL (SSL certificate)';
$lng['panel']['send'] = 'invia';
$lng['admin']['subject'] = 'Oggetto';
$lng['admin']['receipient'] = 'Destinatario';
$lng['admin']['message'] = 'Scrivi un messaggio';
$lng['admin']['text'] = 'Messaggio';
$lng['menu']['message'] = 'Messaggi';
$lng['error']['errorsendingmail'] = 'Il messaggio a "%s" fallito';
$lng['error']['cannotreaddir'] = 'Impossibile leggere la cartella "%s"';
$lng['message']['success'] = 'Inviato correttamente il messaggio a %s recipients';
$lng['message']['noreceipients'] = 'Nessuna e-mail è stata inviata perch¸ non ci sono i destinatari nel database';
$lng['admin']['sslsettings'] = 'Impostazioni SSL';
$lng['cronjobs']['notyetrun'] = 'Non ancora avviato';
$lng['serversettings']['default_vhostconf']['title'] = 'Impostazioni default vhost';
$lng['serversettings']['default_vhostconf']['description'] = 'Il contenuto di questo campo sarà incluso direttamente nel contenitore di dominio vhost. Attenzione: Il codice non sarà controllato per eventuali errori. Se contiene errori, il webserver non riavviarsi correttamente!';
$lng['error']['invalidip'] = 'Indirizzo IP non valido: %s';
$lng['serversettings']['decimal_places'] = 'Numero di cifre decimali del traffico/spazio web in uscita';

// ADDED IN 1.2.19-svn8

$lng['admin']['dkimsettings'] = 'Impostazioni DomainKey';
$lng['dkim']['dkim_prefix']['title'] = 'Prefisso';
$lng['dkim']['dkim_prefix']['description'] = 'Si prega di specificare il percorso della DKIM RSA-files, nonch¸ i file di configurazione per il plugin Milter';
$lng['dkim']['dkim_domains']['title'] = 'Domini nomefile';
$lng['dkim']['dkim_domains']['description'] = '<em>Nome file</em> del parametro DKIM Domains specificata nella configurazione dkim-milter';
$lng['dkim']['dkim_dkimkeys']['title'] = 'Nome file del KeyList';
$lng['dkim']['dkim_dkimkeys']['description'] = '<em>Nome file</em> del parametro DKIM KeyList specificata nella configurazione dkim-milter';
$lng['dkim']['dkimrestart_command']['title'] = 'Milter commando riavvio';
$lng['dkim']['dkimrestart_command']['description'] = 'Si prega di specificare il comando per riavviare il servizio DKIM milter';

// ADDED IN 1.2.19-svn9

$lng['admin']['caneditphpsettings'] = 'È possibile modificare le impostazioni di dominio relative a php?';

// ADDED IN 1.2.19-svn12

$lng['admin']['allips'] = 'Tutti gli IP';
$lng['panel']['nosslipsavailable'] = 'Attualmente non ci sono combinazioni ssl ip/porta per questo server';
$lng['ticket']['by'] = 'da';
$lng['dkim']['use_dkim']['title'] = 'Attivare il supporto DKIM?';
$lng['dkim']['use_dkim']['description'] = 'Vuoi utilizzare il sistema Domain Keys (DKIM)?';
$lng['error']['invalidmysqlhost'] = 'Indirizzo MySQL non valido: %s';
$lng['error']['cannotuseawstatsandwebalizeratonetime'] = 'Non è possibile abilitare Webalizer e Awstats allo stesso tempo, si prega di sceglierne uno solo';
$lng['serversettings']['webalizer_enabled'] = 'Abilita le statistiche webalizer';
$lng['serversettings']['awstats_enabled'] = 'Abilita le statistiche awstats';
$lng['admin']['awstatssettings'] = 'Impostazioni Awstats';

// ADDED IN 1.2.19-svn16

$lng['admin']['domain_dns_settings'] = 'Impostazioni dominio dns';
$lng['dns']['destinationip'] = 'Dominio IP';
$lng['dns']['standardip'] = 'Server standard IP';
$lng['dns']['a_record'] = 'A-Record (IPv6 optionale)';
$lng['dns']['cname_record'] = 'CNAME-Record';
$lng['dns']['mxrecords'] = 'Definisci MX records';
$lng['dns']['standardmx'] = 'Server standard MX record';
$lng['dns']['mxconfig'] = 'Custom MX records';
$lng['dns']['priority10'] = 'Priority 10';
$lng['dns']['priority20'] = 'Priority 20';
$lng['dns']['txtrecords'] = 'Definisci TXT records';
$lng['dns']['txtexample'] = 'Esempio (SPF-entry):<br />v=spf1 ip4:xxx.xxx.xx.0/23 -all';
$lng['serversettings']['selfdns']['title'] = 'Impostazioni dominio dns del cliente';
$lng['serversettings']['selfdnscustomer']['title'] = 'Consenti ai clienti di modificare le impostazioni DNS del dominio';
$lng['admin']['activated'] = 'Attivato';
$lng['admin']['statisticsettings'] = 'Impostazioni Statistiche';
$lng['admin']['or'] = 'o';

// ADDED IN 1.2.19-svn17

$lng['serversettings']['unix_names']['title'] = 'Usa nomi utente UNIX compatibile';
$lng['serversettings']['unix_names']['description'] = 'Consente di utilizzare <strong>-</strong> e <strong>_</strong> nei nomi utente se <strong>No</strong>';
$lng['error']['cannotwritetologfile'] = 'Impossibile aprire il file di log %s in scrittura';
$lng['admin']['sysload'] = 'Carico del sistema';
$lng['admin']['noloadavailable'] = 'non disponibile';
$lng['admin']['nouptimeavailable'] = 'non disponibile';
$lng['panel']['backtooverview'] = 'Ritorna alla pagina precedente';
$lng['admin']['nosubject'] = '(Nessun Oggetto)';
$lng['admin']['configfiles']['statistics'] = 'Statistiche';
$lng['login']['forgotpwd'] = 'Dimenticato la password?';
$lng['login']['presend'] = 'Reimposta la password';
$lng['login']['email'] = 'Indirizzo E-mail';
$lng['login']['remind'] = 'Reimposta la mia password';
$lng['login']['usernotfound'] = 'Utente non trovata!';
$lng['pwdreminder']['subject'] = 'Froxlor - Reimposta password';
$lng['pwdreminder']['body'] = 'Salve %s,\n\nla tua password froxlor è stata reimpostata!\nLa nuova password è: %p\n\nGrazie,\n Team Froxlor';
$lng['pwdreminder']['success'] = 'La password è stata reimpostata con successo.<br />A questo punto riceverai una email con la nuova password.';

// ADDED IN 1.2.19-svn18

$lng['serversettings']['allow_password_reset']['title'] = 'Consenti ai clienti di reimpostare la password';
$lng['pwdreminder']['notallowed'] = 'Il reimposta password è disabilitato';

// ADDED IN 1.2.19-svn21

$lng['customer']['title'] = 'Titolo';
$lng['customer']['country'] = 'Paese';
$lng['panel']['dateformat'] = 'DD-MM-YYYY';
$lng['panel']['dateformat_function'] = 'd-m-Y';

// Y = Year, m = Month, d = Day

$lng['panel']['timeformat_function'] = 'H:i:s';

// H = Hour, i = Minute, s = Second

$lng['panel']['default'] = 'Predefinito';
$lng['panel']['never'] = 'Mai';
$lng['panel']['active'] = 'Attivo';
$lng['panel']['please_choose'] = 'Scegli';
$lng['panel']['allow_modifications'] = 'Permetti modifiche';
$lng['domains']['add_date'] = 'Aggiunto a Froxlor';
$lng['domains']['registration_date'] = 'Aggiunto al registro';
$lng['domains']['topleveldomain'] = 'Dominio di primo livello (TLD)';

// ADDED IN 1.2.19-svn22

$lng['serversettings']['allow_password_reset']['description'] = 'I clienti possono reimpostare la propria password e una nuova password verrà inviata al loro indirizzo e-mail';
$lng['serversettings']['allow_password_reset_admin']['title'] = 'Consenti di reimpostare la password agli ammministratori';
$lng['serversettings']['allow_password_reset_admin']['description'] = 'Amministratori/rivenditori possono reimpostare la propria password e una nuova password verrà inviata al loro indirizzo e-mail';

// ADDED IN 1.2.19-svn25

$lng['emails']['quota'] = 'Limite';
$lng['emails']['noquota'] = 'Nessun limite';
$lng['emails']['updatequota'] = 'Aggiorna Limite';
$lng['serversettings']['mail_quota']['title'] = 'Limite casella email';
$lng['serversettings']['mail_quota']['description'] = 'Limite predefinito per una nuova casella email creata (MegaByte).';
$lng['serversettings']['mail_quota_enabled']['title'] = 'Usa limiti per le caselle email dei clienti';
$lng['serversettings']['mail_quota_enabled']['description'] = 'Attiva per utilizzare i limiti nelle caselle email. Predefinito <b>No</b> poich¸ questo richiede una configurazione speciale.';
$lng['serversettings']['mail_quota_enabled']['removelink'] = 'Clicca qui per togliere tutti i limiti dalle caselle email.';
$lng['serversettings']['mail_quota_enabled']['enforcelink'] = 'Clicca qui per applicare il limite predefinito a tutte le caselle email degli utenti.';
$lng['question']['admin_quotas_reallywipe'] = 'Sei sicuro di voler cancellare tutti i limiti dalla tabella mail_users? Questa operazione non può essere annullata!';
$lng['question']['admin_quotas_reallyenforce'] = 'Sei sicuro di voler impostare il limite predefinito a tutti gli utenti? Questa operazione non può essere annullata!';
$lng['error']['vmailquotawrong'] = 'Il limite deve essere un numero positivo.';
$lng['customer']['email_quota'] = 'Limite E-mail';
$lng['customer']['email_imap'] = 'E-mail IMAP';
$lng['customer']['email_pop3'] = 'E-mail POP3';
$lng['customer']['mail_quota'] = 'Limite Mail';
$lng['panel']['megabyte'] = 'MegaByte';
$lng['panel']['not_supported'] = 'Non supportato in: ';
$lng['emails']['quota_edit'] = 'Cambia limite E-Mail';
$lng['error']['allocatetoomuchquota'] = 'Si è tentato di allocare %s MB ' . $lng['emails']['quota'] . ', ma non c\'è abbastanza spazio disponibile.';

// Autoresponder module

$lng['menue']['email']['autoresponder'] = 'Autorisponditore';
$lng['autoresponder']['active'] = 'Attivo';
$lng['autoresponder']['autoresponder_add'] = 'Aggiungi autorisponditore';
$lng['autoresponder']['autoresponder_edit'] = 'Modifica autorisponditore';
$lng['autoresponder']['autoresponder_new'] = 'Crea nuovo autorisponditore';
$lng['autoresponder']['subject'] = 'Oggetto';
$lng['autoresponder']['message'] = 'Messaggio';
$lng['autoresponder']['account'] = 'Account';
$lng['autoresponder']['sender'] = 'Mittente';
$lng['question']['autoresponderdelete'] = 'Sei sicuro di voler cancellare l\'autorisponditore?';
$lng['error']['noemailaccount'] = 'Ci possono essere due motivi per cui non è possibile creare un nuovo autorisponditore: Hai bisogno almeno di un account di posta elettronica per creare un nuovo autorisponditore. In secondo luogo può essere che tutti gli account abbiano già configurato un autorisponditore.';
$lng['error']['missingfields'] = 'Non tutti i campi obbligatori sono stati compilati.';
$lng['error']['accountnotexisting'] = 'L\'account di posta elettronica dato non esiste.';
$lng['error']['autoresponderalreadyexists'] = 'C\'è già un autorisponditore configurato per questo account.';
$lng['error']['invalidautoresponder'] = 'L\'account non è valido';
$lng['serversettings']['autoresponder_active']['title'] = 'Usa il modulo autorisponditore';
$lng['serversettings']['autoresponder_active']['description'] = 'Vuoi utilizzare il modulo autorisponditore?';
$lng['admin']['security_settings'] = 'Opzioni di Sicurezza';
$lng['admin']['know_what_youre_doing'] = 'Modifica solo, se sai quello che stai facendo!';
$lng['admin']['show_version_login']['title'] = 'Mostra la versione di Froxlor quando si effettua l\'accesso';
$lng['admin']['show_version_login']['description'] = 'Mostra la versione di Froxlor in fondo-pagina di accesso';
$lng['admin']['show_version_footer']['title'] = 'Mostra la versione di Froxlor in fondo-pagina';
$lng['admin']['show_version_footer']['description'] = 'Mostra la versione di Froxlor in fondo ad ogni pagina';
$lng['admin']['froxlor_graphic']['title'] = 'Intestazione grafica per Froxlor';
$lng['admin']['froxlor_graphic']['description'] = 'Quale grafica vuoi mostrare nell\'intestazione?';

//improved froxlor

$lng['menue']['phpsettings']['maintitle'] = 'Configurazioni PHP';
$lng['admin']['phpsettings']['title'] = 'Configurazione PHP';
$lng['admin']['phpsettings']['description'] = 'Descrizione breve';
$lng['admin']['phpsettings']['actions'] = 'Azioni';
$lng['admin']['phpsettings']['activedomains'] = 'In uso per dominio/i';
$lng['admin']['phpsettings']['notused'] = 'Configurazione non utilizzata';
$lng['admin']['misc'] = 'Varie';
$lng['admin']['phpsettings']['editsettings'] = 'Modific impostazioni PHP';
$lng['admin']['phpsettings']['addsettings'] = 'Crea una nuova impostazione PHP';
$lng['admin']['phpsettings']['viewsettings'] = 'Mostra impostazioni PHP';
$lng['admin']['phpsettings']['phpinisettings'] = 'Impostazioni php.ini';
$lng['error']['nopermissionsorinvalidid'] = 'Non hai i permessi necessari per modificare le impostazioni o è stato fornito un ID non valido.';
$lng['panel']['view'] = 'view';
$lng['question']['phpsetting_reallydelete'] = 'Do you really want to delete these settings? All domains which use these settings currently will be changed to the default config.';
$lng['admin']['phpsettings']['addnew'] = 'Crea nuove impostazioni';
$lng['error']['phpsettingidwrong'] = 'Una configurazione PHP con questo ID non esiste';
$lng['error']['descriptioninvalid'] = 'La descrizione è troppo corta, La descrizione è troppo corta o troppo lunga o contiene caratteri non validi.';
$lng['error']['info'] = 'Info';
$lng['admin']['phpconfig']['template_replace_vars'] = 'Variabili che saranno sostituite nei file di configurazione';
$lng['admin']['phpconfig']['safe_mode'] = 'Verrà sostituito con l\'impostazione safe_mode del dominio.';
$lng['admin']['phpconfig']['pear_dir'] = 'Verrà sostituito con le impostazioni globali per la cartella pear.';
$lng['admin']['phpconfig']['open_basedir_c'] = 'Inserirà un ; (punto e virgola) per commentare/disabilitare open_basedir se impostato';
$lng['admin']['phpconfig']['open_basedir'] = 'Verrà sostituito con l\'impostazione open_basedir del dominio.';
$lng['admin']['phpconfig']['tmp_dir'] = 'Verrà sostituito con la cartella temporanea del dominio.';
$lng['admin']['phpconfig']['open_basedir_global'] = 'Verrà sostituito con il valore globale del percorso che sarà allegato al open_basedir';
$lng['admin']['phpconfig']['customer_email'] = 'Verrà sostituito con l\'indirizzo email del cliente che possiede questo dominio.';
$lng['admin']['phpconfig']['admin_email'] = 'Verrà sostituito con l\'indirizzo email dell\'amministratore di questo dominio.';
$lng['admin']['phpconfig']['domain'] = 'Verrà sostituito con il dominio.';
$lng['admin']['phpconfig']['customer'] = 'Verrà sostituito con il nome utente del cliente che possiede questo dominio.';
$lng['admin']['phpconfig']['admin'] = 'Verrà sostituito con il nome utente dell\'amministratore che possiede questo dominio.';
$lng['login']['backtologin'] = 'Torna al login';
$lng['serversettings']['mod_fcgid']['starter']['title'] = 'Processi per Dominio';
$lng['serversettings']['mod_fcgid']['starter']['description'] = 'Quanti processi dovrebbero essere avviati/permessi per ogni dominio? Il valore 0 è raccomandato poichè PHP si autogestisce i processi in modo molto efficiente.';
$lng['serversettings']['mod_fcgid']['wrapper']['title'] = 'Wrapper in Vhosts';
$lng['serversettings']['mod_fcgid']['wrapper']['description'] = 'Come dovrebbe essere il wrapper incluso nel Vhosts';
$lng['serversettings']['mod_fcgid']['tmpdir']['description'] = 'Dove va salvata la cartella temp';
$lng['serversettings']['mod_fcgid']['peardir']['title'] = 'Cartella globale di PEAR';
$lng['serversettings']['mod_fcgid']['peardir']['description'] = 'Quali sono le cartelle globali di PEAR che dovrebbero essere sostituite in ogni configurazione php.ini? Più cartelle devono essere separate da : (due punti).';

//improved Froxlor  2

$lng['admin']['templates']['index_html'] = 'file index per le nuove cartelle create dai clienti';
$lng['admin']['templates']['SERVERNAME'] = 'Sostituito con il nomeserver.';
$lng['admin']['templates']['CUSTOMER'] = 'Sostituito con il nome utente del cliente.';
$lng['admin']['templates']['ADMIN'] = 'Sostituito con il nome utente dell\'amministratore.';
$lng['admin']['templates']['CUSTOMER_EMAIL'] = 'Sostituito con l\'indirizzo e-mail del cliente.';
$lng['admin']['templates']['ADMIN_EMAIL'] = 'Sostituito con l\'indirizzo e-mail dell\'amministratore.';
$lng['admin']['templates']['filetemplates'] = 'File Modelli';
$lng['admin']['templates']['filecontent'] = 'Contenuto File';
$lng['error']['filecontentnotset'] = 'Il file non può essere vuoto!';
$lng['serversettings']['index_file_extension']['description'] = 'Quale estensione di file deve essere usata per il file index nelle cartelle del cliente appena creato? Questa estensione di file sarà utilizzata se Lei o uno dei vostri amministratori ha creato il proprio file modello di index.';
$lng['serversettings']['index_file_extension']['title'] = 'Estensione file per il file index delle cartelle dei clienti appena creati';
$lng['error']['index_file_extension'] = 'L\'estensione file del file index deve essere compresa tra 1 e 6 caratteri. L\'estensione può contenere solo i caratteri a-z, A-Z and 0-9';
$lng['admin']['expert_settings'] = 'Impostazioni Avanzate!';
$lng['admin']['mod_fcgid_starter']['title'] = 'Processi PHP per questo dominio (vuoto per lasciare il valore predefinito)';

//added with aps installer

$lng['admin']['aps'] = 'APS Installer';
$lng['customer']['aps'] = 'APS Installer';
$lng['aps']['scan'] = 'Cerca nuovi pacchetti';
$lng['aps']['upload'] = 'Invia nuovi pacchetti';
$lng['aps']['managepackages'] = 'Gestione Pacchetti';
$lng['aps']['manageinstances'] = 'Gestione Istanze';
$lng['aps']['overview'] = 'Panoramica pacchetto';
$lng['aps']['status'] = 'I miei pacchetti';
$lng['aps']['search'] = 'Ricerca pacchetti';
$lng['aps']['upload_description'] = 'Seleziona il file zip del pacchetto di installazione APS per installarlo nel sistema.';
$lng['aps']['search_description'] = 'Nome, Descrizione, Parola chiave, Versione';
$lng['aps']['detail'] = 'Maggiori informazioni';
$lng['aps']['install'] = 'Installa pacchetto';
$lng['aps']['data'] = 'Data';
$lng['aps']['version'] = 'Versione';
$lng['aps']['homepage'] = 'Homepage';
$lng['aps']['installed_size'] = 'Dimensioni dopo l\'Installazione';
$lng['aps']['categories'] = 'Categorie';
$lng['aps']['languages'] = 'Lingue';
$lng['aps']['long_description'] = 'Descrizione dettagliata';
$lng['aps']['configscript'] = 'Configuratione script';
$lng['aps']['changelog'] = 'Changelog';
$lng['aps']['license'] = 'Licenza';
$lng['aps']['license_link'] = 'Link alla Licenza';
$lng['aps']['screenshots'] = 'Screenshots';
$lng['aps']['back'] = 'Ritorna alla pagina precedente';
$lng['aps']['install_wizard'] = 'Installazione guidata...';
$lng['aps']['wizard_error'] = 'Quanto digitato contiene dati non validi. Si prega di correggere per continuare l\'installazione.';
$lng['aps']['basic_settings'] = 'Impostazioni di base';
$lng['aps']['application_location'] = 'Luogo di installazione';
$lng['aps']['application_location_description'] = 'Luogo in cui l\'applicazione verrà installata.';
$lng['aps']['no_domains'] = 'Nessun dominio trovato';
$lng['aps']['database_password'] = 'Password del database';
$lng['aps']['database_password_description'] = 'Password che dovrebbe essere utilizzato per il nuovo database creato.';
$lng['aps']['license_agreement'] = 'Accordo';
$lng['aps']['cancel_install'] = 'Interrompi Installazione';
$lng['aps']['notazipfile'] = 'Il file caricato non è un file zip';
$lng['aps']['filetoobig'] = 'Il file è troppo grande.';
$lng['aps']['filenotcomplete'] = 'Il file non è stato caricato completamente.';
$lng['aps']['phperror'] = 'C\'è stato un errore interno a PHP. Il codice errore dell\'upload PHP è #';
$lng['aps']['moveproblem'] = 'Lo script non è riuscito a spostare i file caricati nella cartella di destinazione. Si prega di assicurarsi che tutti i permessi siano impostati correttamente.';
$lng['aps']['uploaderrors'] = '<strong>Errori per il file<em>%s</em></strong><br/><ul>%s</ul>';
$lng['aps']['nospecialchars'] = 'I caratteri speciali non sono ammessi nella ricerca!';
$lng['aps']['noitemsfound'] = 'Non sono stati trovati Pacchetti!';
$lng['aps']['nopackagesinstalled'] = 'Non hai ancora installato alcun pacchetto che può essere visualizzato.';
$lng['aps']['instance_install'] = 'Installazioen di un pacchetto in sospeso';
$lng['aps']['instance_task_active'] = 'Installazione in esecuzione in questo momento';
$lng['aps']['instance_success'] = 'Pacchetto installato correttamente';
$lng['aps']['instance_error'] = 'Pacchetto non installato - si è verificato qualche errore nell\'installazione';
$lng['aps']['instance_uninstall'] = 'Pacchetto in attesa di disinstallazione';
$lng['aps']['unknown_status'] = 'Errore - Valore sconosciuto';
$lng['aps']['currentstatus'] = 'Stato attuale';
$lng['aps']['activetasks'] = 'Lavori attuali';
$lng['aps']['task_install'] = 'Installationi in attesa';
$lng['aps']['task_remove'] = 'Disinstallationi in attesa';
$lng['aps']['task_reconfigure'] = 'Riconfigurazioni in attesa';
$lng['aps']['task_upgrade'] = 'Aggiornamenti in attesa';
$lng['aps']['no_task'] = 'Nessun lavoro in attesa';
$lng['aps']['applicationlinks'] = 'Collegamenti applicazioni';
$lng['aps']['mainsite'] = 'Sito principale';
$lng['aps']['uninstall'] = 'Disinstallare Pacchetto';
$lng['aps']['reconfigure'] = 'Modifica impostazioni';
$lng['aps']['erroronnewinstance'] = '<strong>Questo pacchetto non può essere installato.</strong><br/><br/>Si prega di tornare alla pagina precedente dei pacchetti e avviare una nuova installazione';
$lng['aps']['successonnewinstance'] = '<strong><em>%s</em> verrò installato ora.</strong><br/><br/>Torna indietro in "Mie Pacchetti" e attendere che l\'installazione sia conclusa. Questo può richiedere del tempo.';
$lng['aps']['php_misc_handler'] = 'PHP - Varie - Il Parser PHP non supporta estensioni di file diverse da .php';
$lng['aps']['php_misc_directoryhandler'] = 'PHP - Varie - Non c\'è supporto per le cartelle che disabilitano gli Handlers PHP.';
$lng['aps']['asp_net'] = 'ASP.NET - Pacchetto non supportato.';
$lng['aps']['cgi'] = 'CGI - Pacchetto non support.';
$lng['aps']['php_extension'] = 'PHP - Estensione "%s" mancante.';
$lng['aps']['php_function'] = 'PHP - Funzione "%s" mancante.';
$lng['aps']['php_configuration'] = 'PHP - COnfigurazione - Le impostazioni correnti "%s" non sono supportate dal Pacchetto.';
$lng['aps']['php_configuration_post_max_size'] = 'PHP - Configurazione - "post_max_size" valore troppo basso.';
$lng['aps']['php_configuration_memory_limit'] = 'PHP - Configurazione - "memory_limit" valore troppo basso.';
$lng['aps']['php_configuration_max_execution_time'] = 'PHP - Configuration - "max_execution_time" valore troppo basso.';
$lng['aps']['php_general_old'] = 'PHP - Generale - la versione di PHP è troppo vecchia.';
$lng['aps']['php_general_new'] = 'PHP - Generale - la versione di PHP è troppo recente.';
$lng['aps']['db_mysql_support'] = 'Database - Il Pacchetto necessita di un altro tipo di database oltre a MySQL.';
$lng['aps']['db_mysql_version'] = 'Database - Il server MySQL è troppo vecchio.';
$lng['aps']['webserver_module'] = 'Webserver - Modulo "%s" mancante.';
$lng['aps']['webserver_fcgid'] = 'Webserver - Questo Pacchetto richiede moduli aggiuntivi del Webserver. Nell\'ambiante FastCGI/mod_fcgid la funzione "apache_get_modules" non esiste. Il Pacchetto non può essere installato perchè il programma di installazione APS non è in grado di verificare se questi moduli sono installati.';
$lng['aps']['webserver_htaccess'] = 'Webserver - Questo Pacchetto richiede che i file .htaccess vengano analizzati dal Webserver. Il pacchetto non può essere installato perch¸ il programma di installazione APS non è in grado di determinare se questo è attivato.';
$lng['aps']['misc_configscript'] = 'Varie - Il linguaggio dello script di configurazione non è supportato.';
$lng['aps']['misc_charset'] = 'Varie - Nella versione attuale dell\'installatore non è possibile convalidare i campi del modulo dal wizard su un set di caratteri specifici.';
$lng['aps']['misc_version_already_installed'] = 'La stessa versione del pacchetto è già installata.';
$lng['aps']['misc_only_newer_versions'] = 'Per motivi di sicurezza solo le versioni più recenti dei Pacchetti possono essere installate se sono già presenti nel sistema';
$lng['aps']['erroronscan'] = '<strong>Errori da <em>%s</em></strong><ul>%s</ul>';
$lng['aps']['invalidzipfile'] = '<strong>Errori per <em>%s</em></strong><br/><ul><li>Questo non è un file zip APS valido!</li></ul>';
$lng['aps']['successpackageupdate'] = '<strong><em>%s</em> installato con successo come Pacchetto di aggiornamento</strong>';
$lng['aps']['successpackageinstall'] = '<strong><em>%s</em> installato con successo come nuovo Pacchetto</strong>';
$lng['aps']['class_zip_missing'] = 'SimpleXML Class, la funzione exec o la funzione ZIP non sono presenti o non sono abilitate! Per ulteriori informazioni su questo problema guarda il manuale di questo module.';
$lng['aps']['dir_permissions'] = 'Il processo PHP/Webserver deve essere in grado di scrivere nelle cartelle {$path}temp/ e {$path}packages/';
$lng['aps']['initerror'] = '<strong>Ci sono alcuni problemi con questo modulo:</strong><ul>%s</ul>Risolvi questi problemi, altrimenti il modulo non può essere utilizzato!';
$lng['aps']['iderror'] = 'Id specificato errato!';
$lng['aps']['nopacketsforinstallation'] = 'Non ci sono pacchetti da installare.';
$lng['aps']['nopackagestoinstall'] = 'Non ci sono pacchetti da visualizzare o installare.';
$lng['aps']['nodomains'] = 'Selezionare un dominio dalla lista. Se non ne è presente nessuno, il pacchetto non può essere installato!';
$lng['aps']['wrongpath'] = 'Questo percorso contiene caratteri non validi oppure c\'è già installata un\'altra applicazione.';
$lng['aps']['dbpassword'] = 'Specificare una password con una lunghezza minima di 8 caratteri.';
$lng['aps']['error_text'] = 'Specificare un testo senza caratteri speciali.';
$lng['aps']['error_email'] = 'Specificare un indirizzo e-mail valido.';
$lng['aps']['error_domain'] = 'Specificare un URL valido come http://www.esempio.com/';
$lng['aps']['error_integer'] = 'Specificare un valore numerico (formato Intero) es. <em>5</em> o <em>7</em>.';
$lng['aps']['error_float'] = 'Specificare un valore numerico (formato Float) es. <em>5,2432</em> o <em>7,5346</em>.';
$lng['aps']['error_password'] = 'Specificare una password.';
$lng['aps']['error_license'] = 'SÃ¬, ho letto la licenza e saranno rispettate le condizioni.';
$lng['aps']['error_licensenoaccept'] = 'È necessario accettare la licenza per installare questa applicazione.';
$lng['aps']['stopinstall'] = 'Interrompi Installazione';
$lng['aps']['installstopped'] = 'L\'installazione di questo pacchetto è stata interrotta con successo.';
$lng['aps']['installstoperror'] = 'L\'installazione non può essere più interrotta perch¸ l\'installazione è già iniziata. Se si desidera disinstallare il Pacchetto, aspettare che l\'installazione sia finita e dopo andare in "I miei Pacchetti" per avviare la disinstallazione.';
$lng['aps']['waitfortask'] = 'Non ci sono azioni da selezionare. Attendere fino a quando tutti i lavori non sono finiti.';
$lng['aps']['removetaskexisting'] = '<strong>Esiste già un lavoro di Disinstallazione.</strong><br/><br/>Si prega di tornare a "I miei Pacchetti" e attendere che la disinstallazione sia terminata.';
$lng['aps']['packagewillberemoved'] = '<strong>Il pacchetto verrà disinstallato ora.</strong><br/><br/>Si prega di tornare a "I miei Pacchetti" e attendere che la disinstallazione sia terminata.';
$lng['question']['reallywanttoremove'] = '<strong>Sei sicuro di voler disinstallare questo pacchetto?</strong><br/><br/>Tutti i contenuti del database e i file verranno cancellati. Assicurarsi di effettuare un backup manuale dei file necessari per ogni utilizzo successivo!<br/><br/>';
$lng['aps']['searchoneresult'] = '%s Pacchetto trovato';
$lng['aps']['searchmultiresult'] = '%s Pacchetti trovati';
$lng['question']['reallywanttostop'] = 'Sei sicuro di voler interrompere l\'installazione di questo pacchetto?<br/><br/>';
$lng['aps']['packagenameandversion'] = 'Nome Pacchetto & Versione';
$lng['aps']['package_locked'] = 'Bloccato';
$lng['aps']['package_enabled'] = 'Abilitato';
$lng['aps']['lock'] = 'Blocca';
$lng['aps']['unlock'] = 'Abilita';
$lng['aps']['remove'] = 'Rimuovi';
$lng['aps']['allpackages'] = 'Tutti i Pacchetti';
$lng['question']['reallyremovepackages'] = '<strong>Sei sicuro di voler cancellare questi pacchetti?</strong><br/><br/>I Pacchetti con dipendenze possono essere rimossi solo se vengono rimosse le rispettive Istanze!<br/><br/>';
$lng['aps']['nopackagesinsystem'] = 'Non c\erano installati pacchetti nel sistema che potevano essere gestiti.';
$lng['aps']['packagenameandstatus'] = 'Nome Pacchetto & Stato';
$lng['aps']['activate_aps']['title'] = 'Abilita l\'installatore APS';
$lng['aps']['activate_aps']['description'] = 'Qui l\'installer APS può essere abilitato e disabilitato globalmente.';
$lng['aps']['packages_per_page']['title'] = 'Pacchetti per pagina';
$lng['aps']['packages_per_page']['description'] = 'Quanti pacchetti devono essere visualizzati per pagina ai clienti?';
$lng['aps']['upload_fields']['title'] = 'Campi di caricamento per pagina';
$lng['aps']['upload_fields']['description'] = 'Quanti campi di caricamento devono essere visualizzati nella pagina per installare nuovi pacchetti nel sistema?';
$lng['aps']['exceptions']['title'] = 'Eccezioni per la validazione dei pacchetti';
$lng['aps']['exceptions']['description'] = 'Alcuni pacchetti hanno bisogno di particolari parametri di configurazione o moduli. L\'installatore non riesce sempre a determinare se queste opzioni/estensioni siano disponibili. Per questo motivo è ora possibile definire delle eccezioni per far sÃ¬ che i pacchetti possano essere installati nel sistema. Si possono solo selezionare opzioni che corrispondono alla reale configuazione dell\'installatore. Per ulteriori informazioni su questo problema leggere il manuale di questo modulo.';
$lng['aps']['settings_php_extensions'] = 'Estensioni PHP';
$lng['aps']['settings_php_configuration'] = 'Configurazione PHP';
$lng['aps']['settings_webserver_modules'] = 'Moduli Webserver';
$lng['aps']['settings_webserver_misc'] = 'Varie Webserver';
$lng['aps']['specialoptions'] = 'Opzioni speciali';
$lng['aps']['removeunused'] = 'Rimuovi i pacchetti non utilizzati';
$lng['aps']['enablenewest'] = 'Abilita le nuove versioni dei pacchetti e blocca le altre';
$lng['aps']['installations'] = 'Installazioni';
$lng['aps']['statistics'] = 'Statistiche';
$lng['aps']['numerofpackagesinstalled'] = '%s Pacchetti installati<br/>';
$lng['aps']['numerofpackagesenabled'] = '%s Pacchetti abilitati<br/>';
$lng['aps']['numerofpackageslocked'] = '%s Pacchetti bloccati<br/>';
$lng['aps']['numerofinstances'] = '%s Instanza installate<br/>';
$lng['question']['reallydoaction'] = '<strong>Sei sicuro di voler eseguire le azioni selezionate?</strong><br/><br/>I dati cancellati durante l\'operazione non possono essere ripristinati in seguito.<br/><br/>';
$lng['aps']['linktolicense'] = 'Collegamento alla licenza';
$lng['aps']['initerror_customer'] = 'Attualmente c\'è un problema con questa estensione di Froxlor. Contattare l\'amministratore per ulteriori informazioni.';
$lng['aps']['numerofinstances'] = '%s Installazioni eseguite<br/>';
$lng['aps']['numerofinstancessuccess'] = '%s Installazioni completate<br/>';
$lng['aps']['numerofinstanceserror'] = '%s Installazioni fallite<br/>';
$lng['aps']['numerofinstancesaction'] = '%s Installazioni/Disinstallazioni pianificate';
$lng['aps']['downloadallpackages'] = 'Scarica tutti i pacchetti dal server di distribuzione';
$lng['aps']['updateallpackages'] = 'Aggiorna tutti i pacchetti dal server di distribuzione';
$lng['aps']['downloadtaskexists'] = 'Esiste già un processo per lo scaricamento di tutti i pacchetti. Si prega di attendere la conclusione del lavoro.';
$lng['aps']['downloadtaskinserted'] = 'Il processo per lo scaricamento di tutti i pacchetti è stato creato. Questo può richiedere diversi minuti.';
$lng['aps']['updatetaskexists'] = 'Esiste già un processo per l\'aggiornamento di tutti i pacchetti. Si prega di attendere la conclusione del lavoro.';
$lng['aps']['updatetaskinserted'] = 'Il processo per l\'aggiornamento di tutti i pacchetti è stato creato. Questo può richiedere diversi minuti.';
$lng['aps']['canmanagepackages'] = 'Può gestire paccheti APS';
$lng['aps']['numberofapspackages'] = 'Quantità di installazioni APS';
$lng['aps']['allpackagesused'] = '<strong>Errore</strong><br/><br/>È già stato raggiunto il numero massimo di applicazioni APS installabili.';
$lng['aps']['noinstancesexisting'] = 'Attualmente non ci sono istanze che possono essere gestite. Ci deve essere installata almeno una applicazione da un cliente.';
$lng['aps']['lightywarning'] = 'Attenzione';
$lng['aps']['lightywarningdescription'] = 'Si sta utilizzando lighttpd come webserver con Froxlor. Il modulo APS è stato scritto principalmente per Apache, per cui è possibile che alcune caratteristiche non funzionino con lighttpd. Si prega di ricordarsi di questa cosa quando si usa il modulo APS. Se hai trovato o visto dei problemi con il modulo APS e lighttpd segnalalo agli sviluppatori che cosÃ¬ possono correggerli entro la prossima versione di Froxlor.';
$lng['error']['customerdoesntexist'] = 'Il cliente che si è selezionato non esiste.';
$lng['error']['admindoesntexist'] = 'L\'amministratore che si è selezionato non esiste.';

// ADDED IN 1.2.19-svn37

$lng['serversettings']['system_realtime_port']['title'] = 'Porta per il realtime di Froxlor';
$lng['serversettings']['system_realtime_port']['description'] = 'Froxlor si connette a questa porta in localhost ogni volta che un nuovo task cron viene programmato. Se il valore è 0 (zero), questa funzionalità è disabilitata.<br />Vedi anche: <a target="blank" href="http://redmine.froxlor.org/projects/froxlor/wiki/En-realtime">Make Froxlor work in realtime (Froxlor Wiki)</a>';
$lng['serversettings']['session_allow_multiple_login']['title'] = 'Permettere login multipli';
$lng['serversettings']['session_allow_multiple_login']['description'] = 'Se attivato un utente può accedere più volte.';
$lng['serversettings']['panel_allow_domain_change_admin']['title'] = 'Permettere di spostare domini tra gli amministratori';
$lng['serversettings']['panel_allow_domain_change_admin']['description'] = 'Se attivato si può cambiare l\'amministratore di un dominio dalle impostazioni del dominio<br /><b>Attenzione:</b> Se un cliente non viene assegnato allo stesso amministratore e dominio, l\'amministratore può vedere tutti gli altri domini di questo cliente!';
$lng['serversettings']['panel_allow_domain_change_customer']['title'] = 'Permetti di spostare domini tra i clienti';
$lng['serversettings']['panel_allow_domain_change_customer']['description'] = 'Se attivato si può cambiare il cliente di un dominio dalle impostazioni del dominio.<br /><b>Attenzione:</b> Froxlor non cambierà alcun percorso. Ciò potrebbe rendere inutilizzabile un dominio!';
$lng['domains']['associated_with_domain'] = 'Associato';
$lng['domains']['aliasdomains'] = 'Alias domini';
$lng['error']['ipportdoesntexist'] = 'La combinazione IP/Porta selezionata non esiste.';

// ADDED IN 1.2.19-svn38

$lng['admin']['phpserversettings'] = 'Impostazioni PHP';
$lng['admin']['phpsettings']['binary'] = 'PHP Binary';
$lng['admin']['phpsettings']['file_extensions'] = 'Estensioni File';
$lng['admin']['phpsettings']['file_extensions_note'] = '(senza punto, separate da spazi)';
$lng['admin']['mod_fcgid_maxrequests']['title'] = 'Richieste PHP massime per questo dominio (vuoto per lasciare il valore predefinito)';
$lng['serversettings']['mod_fcgid']['maxrequests']['title'] = 'Richieste massime per dominio';
$lng['serversettings']['mod_fcgid']['maxrequests']['description'] = 'Quante richieste dovrebbero essere permesse per dominio?';

// fix bug #1124
$lng['admin']['webserver'] = 'Webserver';
$lng['error']['admin_domain_emailsystemhostname'] = 'L\'hostname del server non può essere utilizzato come dominio email.';
$lng['aps']['license_link'] = 'Collegamento alla licenza';

// ADDED IN 1.4.2.1-1

$lng['mysql']['mysql_server'] = 'Server MySQL';

// ADDED IN 1.4.2.1-2

$lng['admin']['ipsandports']['webserverdefaultconfig'] = 'Configurazione predefinita Webserver';
$lng['admin']['ipsandports']['webserverdomainconfig'] = 'Configurazione Dominio Webserver';
$lng['admin']['ipsandports']['webserverssldomainconfig'] = 'COnfigura SSL Webserver';
$lng['admin']['ipsandports']['ssl_key_file'] = 'Percorso al Keyfile SSL';
$lng['admin']['ipsandports']['ssl_ca_file'] = 'Percorso al CA certificate SSL';
$lng['admin']['ipsandports']['default_vhostconf_domain'] = 'Impostazioni predefinite vhost per ogni contenitore di dominio';
$lng['serversettings']['ssl']['ssl_key_file'] = 'Percorso al Keyfile SSL';
$lng['serversettings']['ssl']['ssl_ca_file'] = 'Percorso al CA certificate SSL';

$lng['error']['usernamealreadyexists'] = 'Esiste già il nome utente: %s';

$lng['error']['plausibilitychecknotunderstood'] = 'Il controllo non ha capito la risposta di plausibilità';
$lng['error']['errorwhensaving'] = 'Verificato un errore durante il salvataggio del campo %s';

$lng['success']['success'] = 'Informazioni';
$lng['success']['clickheretocontinue'] = 'Clicca qui per continuare';
$lng['success']['settingssaved'] = 'Le impostazioni sono state salvate con successo.';

// ADDED IN FROXLOR 0.9

$lng['admin']['spfsettings'] = 'Impostazioni Dominio SPF';
$lng['spf']['use_spf'] = 'Attiva SPF per i domini?';
$lng['spf']['spf_entry'] = 'Impostazioni SPF per tutti i domini';
$lng['panel']['dirsmissing'] = 'La cartella fornita non è stata trovata.';
$lng['panel']['toomanydirs'] = 'Troppe sottocartelle. Rifare tornando indietro nella selezione manuale della cartella.';
$lng['panel']['abort'] = 'Termina';
$lng['serversettings']['cron']['debug']['title'] = 'Debug Cronscript';
$lng['serversettings']['cron']['debug']['description'] = 'Attiva per mantenere il file lock dopo l\'avvio di cron, solo per debug<br /><b>Attenzione:</b>Mantenendo il file di lock al successivo avvio cron potrebbe non funzionare correttamente';
$lng['autoresponder']['date_from'] = 'Data di partenza';
$lng['autoresponder']['date_until'] = 'Data di fine';
$lng['autoresponder']['startenddate'] = 'Data di Inizio/Fine';
$lng['panel']['not_activated'] = 'non attivato';
$lng['panel']['off'] = 'off';
$lng['update']['updateinprogress_onlyadmincanlogin'] = 'Una nuova versione di Froxlor è stata installata ma non ancora impostata.<br />Solo l\'amministratore può accedere e completare l\'aggiornamento.';
$lng['update']['update'] = 'Aggiorna Froxlor';
$lng['update']['proceed'] = 'Procedi';
$lng['update']['update_information']['part_a'] = 'I file di Froxlor sono stati aggiornati alla versione <strong>%newversion</strong>. La versione installata è <strong>%curversion</strong>.';
$lng['update']['update_information']['part_b'] = '<br /><br />I clienti non potranno accedere fino a quando l\'aggiornamento non sarà completato.<br /><strong>Procedere?</strong>';
$lng['update']['noupdatesavail'] = '<strong>È già presente l\'ultima versione di Froxlor.</strong>';
$lng['admin']['specialsettingsforsubdomains'] = 'Applica le impostazioni speciali a tutti i sottodomini (*.esempio.com)';
$lng['serversettings']['specialsettingsforsubdomains']['description'] = 'Se si queste impostazioni personalizzate dei vhost saranno aggiunte a tutti sottodomini; se no le impostazioni speciali dei sottodomini verranno rimosse.';
$lng['tasks']['outstanding_tasks'] = 'Processi Cron in sospeso';
$lng['tasks']['rebuild_webserverconfig'] = 'Ricostruzione della configurazione del webserver';
$lng['tasks']['adding_customer'] = 'Aggiunto il nuovo cliente %loginname%';
$lng['tasks']['rebuild_bindconfig'] = 'Ricostruzione della configurazione di bind';
$lng['tasks']['creating_ftpdir'] = 'Creazione delle cartelle per i nuovi utenti ftp';
$lng['tasks']['deleting_customerfiles'] = 'Eliminazione dei file del cliente %loginname%';
$lng['tasks']['noneoutstanding'] = 'Attualmente non ci sono processi in sospeso per Froxlor';
$lng['ticket']['nonexistingcustomer'] = '(cliente cancellato)';
$lng['admin']['ticket_nocustomeraddingavailable'] = 'Non è possibile aprire un nuovo ticket di supporto, al momento. Prima è necessario aggiungere almeno un cliente.';

// ADDED IN FROXLOR 0.9.1

$lng['admin']['accountdata'] = 'Dati conto';
$lng['admin']['contactdata'] = 'Dati contatto';
$lng['admin']['servicedata'] = 'Dati di servizio';

// ADDED IN FROXLOR 0.9.2

$lng['admin']['newerversionavailable'] = 'È disponibile una nuova versione di Floxlor';

// ADDED IN FROXLOR 0.9.3

$lng['emails']['noemaildomainaddedyet'] = 'Non hai ancora un (email-)dominio nel tuo account.';
$lng['error']['hiddenfieldvaluechanged'] = 'Il valore per il campo nascosto "%s" è cambiato durante la modifica delle impostazioni.<br /><br />Questo non è solitamente un grosso problema, ma le impostazioni potrebbe non essere salvate a causa di questo.';

// ADDED IN FROXLOR 0.9.3-svn1

$lng['serversettings']['panel_password_min_length']['title'] = 'Lunghezza minima della password';
$lng['serversettings']['panel_password_min_length']['description'] = 'Qui è possibile impostare una lunghezza minima per le password.\'0\' significa: nessuna lunghezza minima richiesta.';
$lng['error']['notrequiredpasswordlength'] = 'La password scritta è troppo corta. Si prega di scrivere una password lunga almeno %s caratteri.';
$lng['serversettings']['system_store_index_file_subs']['title'] = 'Salva il file index predefinito anche nelle nuove sottocartelle';
$lng['serversettings']['system_store_index_file_subs']['description'] = 'Se abilitato, il file index predefinito viene memorizzato per ogni cartella sottodominio appena creata (non se la cartella esiste già!)';

// ADDED IN FROXLOR 0.9.3-svn2

$lng['serversettings']['adminmail_return']['title'] = 'Indirizzo di Risposta';
$lng['serversettings']['adminmail_return']['description'] = 'Definire un indirizzo email come \'Indirizzo di Risposta\' per le email inviate dal Pannello';
$lng['serversettings']['adminmail_defname'] = 'Nome del mittente del Pannello nell\'email';

// ADDED IN FROXLOR 0.9.3-svn3
$lng['dkim']['dkim_algorithm']['title'] = 'Ammessi Algoritmi Hash';
$lng['dkim']['dkim_algorithm']['description'] = 'Definire gli algoritmi di hash permessi, scegliere "Tutti" per permettere tutti gli algoritmi oppure uno o più tra gli altri algoritmi disponibili';
$lng['dkim']['dkim_servicetype'] = 'Tipi di Servizio';
$lng['dkim']['dkim_keylength']['title'] = 'Lunghezza Chiave';
$lng['dkim']['dkim_keylength']['description'] = 'Attenzione: Se si modifica questo valore è necessario eliminare tutte le chiavi private/pubbliche in "'.$settings['dkim']['dkim_prefix'].'"';
$lng['dkim']['dkim_notes']['title'] = 'Note DKIM';
$lng['dkim']['dkim_notes']['description'] = 'Nota potrebbe essere di interesse, es. un URL come http://www.dnswatch.info. Nessuna interpretazione è fatta da nessun programma. Questo tag deve essere usato con parsimonia per ragioni di spazio nel DNS. Questo è destinato ad essere utilizzato dagli amministratori e non dagli utenti finali.';
$lng['dkim']['dkim_add_adsp']['title'] = 'Aggiungi un valore DKIM ADSP';
$lng['dkim']['dkim_add_adsp']['description'] = 'Se non si sa di cosa si tratta, lasciare "enabled"';
$lng['dkim']['dkim_add_adsppolicy']['title'] = 'Regola ADSP';
$lng['dkim']['dkim_add_adsppolicy']['description'] = 'Per ulteriori informazioni su questa impostazione leggere <a target="blank" href="http://redmine.froxlor.org/projects/froxlor/wiki/En-dkim-adsp-policies">DKIM ADSP policies</a>';

$lng['admin']['cron']['cronsettings'] = 'Impostazioni Cronjob';
$lng['cron']['cronname'] = 'Nome cronjob';
$lng['cron']['lastrun'] = 'ultima esecuzione';
$lng['cron']['interval'] = 'intervallo';
$lng['cron']['isactive'] = 'abilitato';
$lng['cron']['description'] = 'descrizione';
$lng['crondesc']['cron_unknown_desc'] = 'nessuna descrizione fornita';
$lng['admin']['cron']['add'] = 'Aggiungi cronjob';
$lng['crondesc']['cron_tasks'] = 'generazione del file di configurazione';
$lng['crondesc']['cron_legacy'] = 'legacy (vecchi) cronjob';
$lng['crondesc']['cron_apsinstaller'] = 'Installatore APS';
$lng['crondesc']['cron_autoresponder'] = 'autorisponditore e-mail';
$lng['crondesc']['cron_apsupdater'] = 'aggiornamento pacchetti APS';
$lng['crondesc']['cron_traffic'] = 'calcolo del traffico';
$lng['crondesc']['cron_ticketsreset'] = 'reset dei contatori dei ticket';
$lng['crondesc']['cron_ticketarchive'] = 'archiviazione vecchi ticket';
$lng['cronmgmt']['seconds'] = 'secondi';
$lng['cronmgmt']['minutes'] = 'minuti';
$lng['cronmgmt']['hours'] = 'ore';
$lng['cronmgmt']['days'] = 'giorni';
$lng['cronmgmt']['weeks'] = 'settimane';
$lng['cronmgmt']['months'] = 'mesi';
$lng['admin']['cronjob_edit'] = 'Modifica cronjob';
$lng['cronjob']['cronjobsettings'] = 'impostazioni Cronjob';
$lng['cronjob']['cronjobinterval'] = 'Durata intervallo';
$lng['panel']['options'] = 'opzioni';
$lng['admin']['warning'] = 'ATTENZIONE - Leggi attentamente!';
$lng['cron']['changewarning'] = 'La modifica di questi valori può avere conseguenze negative nel comportamento di Froxlor e dei suoi processi automatizzati<br /><br />Per favore modifica questi valori solo se sei sicuro di quello che stai facendo!';

$lng['serversettings']['stdsubdomainhost']['title'] = 'Sottodominio standard cliente';
$lng['serversettings']['stdsubdomainhost']['description'] = 'Quale hostname dovrebbe essere usato per creare sottodomini standard per i clienti. Se vuoto, viene utilizzato l\'hostname del sistema.';

// ADDED IN FROXLOR 0.9.4-svn1
$lng['ftp']['account_edit'] = 'Modifica acocunt FTP';
$lng['ftp']['editpassdescription'] = 'Imposta una nuova password o lascia vuoto per non cambiarla.';
$lng['customer']['sendinfomail'] = 'Inviami i dati via email';
$lng['customer']['mysql_add']['infomail_subject'] = '[Froxlor] Nuovo database creato';
$lng['customer']['mysql_add']['infomail_body']['pma'] = "\nPuoi accedere ai database da phpMyAdmin all\'indirizzo {URI}\n";
$lng['customer']['mysql_add']['infomail_body']['main'] = "Hello {CUST_NAME},\n\nhai appena aggiunto un nuovo database. Ecco le informazioni inserite:\n\nNome database: {DB_NAME}\nPassword: {DB_PASS}\nDescrizione: {DB_DESC}\nDB-Hostname: {DB_SRV}\n{PMA_URI}\nCordiali Saluti, Team Froxlor";
$lng['error']['domains_cantdeletedomainwithapsinstances'] = 'Non è possibile eliminare un dominio che è utilizzato da un pacchetto installato da APS. È necessario disinstallare prima il pacchetto APS.';
$lng['serversettings']['awstats_path'] = 'Percorso a AWStats \'awstats_buildstaticpages.pl\'';
$lng['serversettings']['awstats_conf'] = 'Cartella della configurazione di AWStats';
$lng['error']['overviewsettingoptionisnotavalidfield'] = 'Woops, un campo che dovrebbe essere mostrato come opzione in Impostazioni-Principale non è un tipo esclusivo. Si possono rimproverare gli sviluppatori per questo. Questo non deve accadere!';
$lng['admin']['configfiles']['compactoverview'] = 'Visualizzazione-Compatta';
$lng['admin']['lastlogin_succ'] = 'Ultimo accesso';
$lng['panel']['neverloggedin'] = 'Nessun login effettuato';

// ADDED IN FROXLOR 0.9.6-svn1
$lng['serversettings']['defaultttl'] = 'Dominio TTL per impegnare in secondi (predefinito \'604800\' = 1 settimana)';
$lng['ticket']['logicalorder'] = 'Ordine logico';
$lng['ticket']['orderdesc'] = 'Qui è possibile definire il tuo ordine logico per le categorie dei ticket. Usa 1 - 999, i numeri più bassi sono mostrati prima.';

// ADDED IN FROXLOR 0.9.6-svn3
$lng['serversettings']['defaultwebsrverrhandler_enabled'] = 'Abilita errordocuments in automatico per tutti i clienti';
$lng['serversettings']['defaultwebsrverrhandler_err401']['title'] = 'File/URL per l\'errore 401';
$lng['serversettings']['defaultwebsrverrhandler_err401']['description'] = '<div style="color:red">'.$lng['panel']['not_supported'].'lighttpd</div>';
$lng['serversettings']['defaultwebsrverrhandler_err403']['title'] = 'File/URL per l\'errore 403';
$lng['serversettings']['defaultwebsrverrhandler_err403']['description'] = '<div style="color:red">'.$lng['panel']['not_supported'].'lighttpd</div>';
$lng['serversettings']['defaultwebsrverrhandler_err404'] = 'File/URL per l\'errore 404';
$lng['serversettings']['defaultwebsrverrhandler_err500']['title'] = 'File/URL per l\'errore 500';
$lng['serversettings']['defaultwebsrverrhandler_err500']['description'] = '<div style="color:red">'.$lng['panel']['not_supported'].'lighttpd</div>';

// ADDED IN FROXLOR 0.9.6-svn4
$lng['serversettings']['ticket']['default_priority'] = 'Priorità predefinita per il supporto ticket';

// ADDED IN FROXLOR 0.9.6-svn5
$lng['serversettings']['mod_fcgid']['defaultini'] = 'Configurazione di default di PHP per i nuovi domini';

// ADDED IN FROXLOR 0.9.6-svn6
$lng['admin']['ftpserver'] = 'Server FTP';
$lng['admin']['ftpserversettings'] = 'Impostazioni del Server FTP';
$lng['serversettings']['ftpserver']['desc'] = 'Se pureftpd è selezionato i file .ftpquota per i limiti dell\'utente sono creati e aggiornati giornalmente';

// CHANGED IN FROXLOR 0.9.6-svn6
$lng['serversettings']['ftpprefix']['description'] = 'Che prefisso vuoi che per gli account ftp?<br/><b>Se si modifica questo devi anche modificare il limite (Quota) della query SQL nel file di configurazione del server FTP nel caso in cui venga usata!</b> ';

// ADDED IN FROXLOR 0.9.7-svn1
$lng['customer']['ftp_add']['infomail_subject'] = '[Froxlor] Nuovo utente ftp creato';
$lng['customer']['ftp_add']['infomail_body']['main'] = "Salve {CUST_NAME},\n\nhai appena aggiunto un nuovo utente ftp. Ecco le informazioni inserite:\n\nNome utente: {USR_NAME}\nPassword: {USR_PASS}\nPercorso: {USR_PATH}\n\nCordiali Saluti, Team Froxlor";
$lng['domains']['redirectifpathisurl'] = 'Codice di redirezione (Predefinito: vuoto)';
$lng['domains']['redirectifpathisurlinfo'] = 'È necessario selezionare uno di questi se hai inserito un URL come percorso';
$lng['serversettings']['customredirect_enabled']['title'] = 'Permetti ai clienti le redirezioni';
$lng['serversettings']['customredirect_enabled']['description'] = 'Consente ai clienti di scegliere il codice di stato http per le redirezioni che verranno utilizzate';
$lng['serversettings']['customredirect_default']['title'] = 'Redirezione Predefinita';
$lng['serversettings']['customredirect_default']['description'] = 'Imposta il codice della redirezione predefinito che dovrebbe essere usato se il cliente non lo imposta';

// ADDED IN FROXLOR 0.9.7-svn2
$lng['error']['pathmaynotcontaincolon'] = 'Il percorso che hai inserito non dovrebbe contenere i due punti (:). Inserisci un percorso valido.';
$lng['tasks']['aps_task_install'] = 'Installazione di uno o più pacchetti APS';
$lng['tasks']['aps_task_remove'] = 'Rimozione di uno o più pacchetti APS';
$lng['tasks']['aps_task_reconfigure'] = 'Riconfigurazioni di uno o più pacchetti APS';
$lng['tasks']['aps_task_upgrade'] = 'Aggiornamento di uno o più pacchetti APS';
$lng['tasks']['aps_task_sysupdate'] = 'Aggiornare tutti i pacchetti APS';
$lng['tasks']['aps_task_sysdownload'] = 'Scaricamento dei nuovi pacchetti APS';

// ADDED IN FROXLOR 0.9.7-svn3

// these stay only in english.lng.php - they are the same
// for all other languages and are used if not found there
$lng['redirect_desc']['rc_default'] = 'Predefinito';
$lng['redirect_desc']['rc_movedperm'] = 'spostato in modo permanente';
$lng['redirect_desc']['rc_found'] = 'trovato';
$lng['redirect_desc']['rc_seeother'] = 'vedi gli altri';
$lng['redirect_desc']['rc_tempred'] = 'reindirizzamento temporaneo';

// ADDED IN FROXLOR 0.9.8
$lng['error']['exception'] = '%s';

// ADDED IN FROXLOR 0.9.9-svn1
$lng['serversettings']['mail_also_with_mxservers'] = 'Crea mail-, imap-, pop3- and smtp-"A record" anche con MX-Servers impostato';

// ADDED IN FROXLOR 0.9.10-svn1
$lng['aps']['nocontingent'] = 'Il tuo APS contingente è insufficiente. Non è possibile installare qualsiasi pacchetto.';
$lng['aps']['packageneedsdb'] = 'Questo pacchetto ha bisogno di un database, ma il tuo potenziale è esaurito';
$lng['aps']['cannoteditordeleteapsdb'] = 'I database APS qui non possono essere modificati o rimossi';
$lng['admin']['webserver_user'] = 'Utente Webserver';
$lng['admin']['webserver_group'] = 'Gruppo Webserver';

// ADDED IN FROXLOR 0.9.10
$lng['serversettings']['froxlordirectlyviahostname'] = 'Accedi direttamente a Froxlor via hostname';

// ADDED IN FROXLOR 0.9.11-svn1
$lng['serversettings']['panel_password_regex']['title'] = 'Espressione per le password';
$lng['serversettings']['panel_password_regex']['description'] = 'Qui è possibile impostare una espressione regolare per la complessità delle password.<br />Vuoto = nessun requisito specificato<br />(<a target="blank" href="http://redmine.froxlor.org/projects/froxlor/wiki/En-password-regex-examples">aiuto/esempi regex</a>)';
$lng['error']['notrequiredpasswordcomplexity'] = 'La complessita della password specificata non è soddisfacente.<br />Si prega di contattare l\'amministratore se avete domande sulla complessità della password';

// ADDED IN FROXLOR 0.9.11-svn2
$lng['extras']['execute_perl'] = 'Esegui perl/CGI';
$lng['admin']['perlenabled'] = 'Perl abilitato';

// ADDED IN FROXLOR 0.9.11-svn3
$lng['serversettings']['perl_path']['title'] = 'Percorso perl';
$lng['serversettings']['perl_path']['description'] = 'Rilevante solo se si utilizza lighttpd. Predefinito /usr/bin/perl';

// ADDED IN FROXLOR 0.9.12-svn1
$lng['admin']['fcgid_settings'] = 'FCGID';
$lng['serversettings']['mod_fcgid_ownvhost']['title'] = 'Abilita FCGID per i vhost Froxlor';
$lng['serversettings']['mod_fcgid_ownvhost']['description'] = 'Se attivato, Froxlor verrà eseguito con un utente locale<br /><strong>ATTENZIONE:</strong>Questo richiede una configurazione manuale, vedi <a target="blank" href="http://redmine.froxlor.org/projects/froxlor/wiki/FCGID_-_handbook">FCGID - handbook</a>';
$lng['admin']['mod_fcgid_user'] = 'Utente locale per FCGID (Froxlor vhost)';
$lng['admin']['mod_fcgid_group'] = 'Gruppo locale per FCGID (Froxlor vhost)';

// ADDED IN FROXLOR 0.9.12-svn2
$lng['admin']['perl_settings'] = 'Perl/CGI';
$lng['serversettings']['perl']['suexecworkaround']['title'] = 'Abilita SuExec workaround (solo con Apache)';
$lng['serversettings']['perl']['suexecworkaround']['description'] = 'Abilita solo se la docroots del cliente non sono all\'interno del percorso suexec di Apache<br />Se attivato, Froxlor genererà un link simbolico dalla cartella perl abilitata dei clienti + /cgi-bin/ al percorso specificato.<br />Nota: Perl funziona solo nelle sottocartelle /cgi-bin/ e non nella cartella stessa (come farebbe normalmente senza questa correzione!)';
$lng['serversettings']['perl']['suexeccgipath']['title'] = 'Percorso dei link simbolici della cartella abilitata perl del cliente';
$lng['serversettings']['perl']['suexeccgipath']['description'] = 'Imposta questo solo se la soluzione SuExec è abilitata.<br />ATTENZIONE: Assicurati che questo percorso sia all\'interno del percorso suexec oppure questa soluzione è inutile';
$lng['panel']['descriptionerrordocument'] = 'Può essere un URL, un percorso ad un file o solo una stringa con un " "<br />Lasciare vuoto per usare il valore di default del server.';
$lng['error']['stringerrordocumentnotvalidforlighty'] = 'Una stringa come ErrorDocument non funziona in lighttpd, si prega di specificare un percorso di un file';
$lng['error']['urlerrordocumentnotvalidforlighty'] = 'Un URL come ErrorDocument non funziona in lighttpd, si prega di specificare un percorso di un file';

// ADDED IN FROXLOR 0.9.12-svn3
$lng['question']['remove_subbutmain_domains'] = 'Rimuover anche i domini che sono stati aggiunti come domini completi, ma quali sono i sottodomini di questo dominio?';
$lng['domains']['issubof'] = 'Questo dominio è un sottodominio di un altro dominio';
$lng['domains']['issubofinfo'] = 'Devi impostare correttamente questo dominio se si desidera aggiungere un sottodominio come dominio completo (es. si vuole aggiungere "www.domain.tld", devi selezionare qui "domain.tld")';
$lng['domains']['nosubtomaindomain'] = 'No sottodominio di un dominio completo';
$lng['admin']['templates']['new_database_by_customer'] = 'Notifica al cliente quando un database è stato creato';
$lng['admin']['templates']['new_ftpaccount_by_customer'] = 'Notifica al cliente quando un utente FTP è stato creato';
$lng['admin']['templates']['newdatabase'] = 'Mail di notifica per i nuovi database';
$lng['admin']['templates']['newftpuser'] = 'Mail di notifica per i nuovi utenti ftp';
$lng['admin']['templates']['CUST_NAME'] = 'Nome del Cliente';
$lng['admin']['templates']['DB_NAME'] = 'Nome del Database';
$lng['admin']['templates']['DB_PASS'] = 'Password del Database';
$lng['admin']['templates']['DB_DESC'] = 'Descrizione del Database';
$lng['admin']['templates']['DB_SRV'] = 'Server del Database';
$lng['admin']['templates']['PMA_URI'] = 'URL a phpMyAdmin (se presente)';
$lng['admin']['notgiven'] = '[se presente]';
$lng['admin']['templates']['USR_NAME'] = 'Nome utente FTP';
$lng['admin']['templates']['USR_PASS'] = 'Password FTP';
$lng['admin']['templates']['USR_PATH'] = 'Cartella utente FTP (rispetto alla cartella docroot del cliente)';

// ADDED IN FROXLOR 0.9.12-svn4
$lng['serversettings']['awstats_awstatspath'] = 'Percorso AWStats \'awstats.pl\'';

// ADDED IN FROXLOR 0.9.12-svn6
$lng['extras']['htpasswdauthname'] = 'Argomento di Autenticazione (AuthName)';
$lng['extras']['directoryprotection_edit'] = 'modifica la protezione della directory';
$lng['admin']['templates']['forgotpwd'] = 'Mail di notifica per il reset della password';
$lng['admin']['templates']['password_reset'] = 'Notifica al cliente per il reset della password';

// ADDED IN FROXLOR 0.9.13-svn1
$lng['customer']['autoresponder'] = 'Risponditore Automatico';

// ADDED IN FROXLOR 0.9.14-svn1
$lng['serversettings']['mod_fcgid']['defaultini_ownvhost'] = 'Configurazione di Default di PHP per Froxlor-vhost';

// ADDED IN FROXLOR 0.9.14-svn3
$lng['serversettings']['awstats_icons']['title'] = 'Percorso della cartella delle icone di AWstats';
$lng['serversettings']['awstats_icons']['description'] = 'es. /usr/share/awstats/htdocs/icon/';

// ADDED IN FROXLOR 0.9.14-svn4
$lng['admin']['ipsandports']['ssl_cert_chainfile'] = 'Percorso SSL CertificateChainFile';

// ADDED IN FROXLOR 0.9.14-svn5
$lng['admin']['ipsandports']['docroot']['title'] = 'Imposta Cartella principale (vuoto = va in Froxlor)';
$lng['admin']['ipsandports']['docroot']['description'] = 'Qui puoi definire una tua cartella principale (la destinazione di una richiesta) per questa combinazione IP/Porta.<br /><strong>ATTENZIONE:</strong> Fai molta attenzione a quello che scrivi qui!';

// ADDED IN FROXLOR 0.9.14-svn6
$lng['serversettings']['login_domain_login'] = 'Permetti il login con i domini';

// ADDED IN FROXLOR 0.9.14
$lng['panel']['unlock'] = 'unlock';
$lng['question']['customer_reallyunlock'] = 'Sei sicuro di voler sbloccare il cliente %s?';

// ADDED IN FROXLOR 0.9.15-svn1
$lng['serversettings']['perl_server']['title'] = 'Localizzazione del server Perl';
$lng['serversettings']['perl_server']['description'] = 'Di default è impostato per utilizzare la guida disponibile sul sito: <a target="blank" href="http://wiki.nginx.org/SimpleCGI">http://wiki.nginx.org/SimpleCGI</a>';
$lng['serversettings']['nginx_php_backend']['title'] = 'Nginx PHP backend';
$lng['serversettings']['nginx_php_backend']['description'] = 'questo è dove in ascolto il processo PHP per le richieste da nginx, può essere un socket unix combinazione IP:Porta';
$lng['serversettings']['phpreload_command']['title'] = 'Comando riavvio PHP';
$lng['serversettings']['phpreload_command']['description'] = 'questo viene utilizzato per ricaricare il backend PHP se è in uso<br />Predefinito: vuoto';

// ADDED IN FROXLOR 0.9.16
$lng['error']['intvaluetoolow'] = 'Il numero dato è troppo basso (campo %s)';
$lng['error']['intvaluetoohigh'] = 'Il numero dato è troppo alto (campo %s)';
$lng['admin']['phpfpm_settings'] = 'PHP-FPM';
$lng['serversettings']['phpfpm'] = 'Abilita php-fpm';
$lng['serversettings']['phpfpm_settings']['configdir'] = 'Cartella di configurazione php-fpm';
$lng['serversettings']['phpfpm_settings']['reload'] = 'comando di riavvio php-fpm';
$lng['serversettings']['phpfpm_settings']['pm'] = 'Gestore processi (pm)';
$lng['serversettings']['phpfpm_settings']['max_children']['title'] = 'Il numero di processi figli';
$lng['serversettings']['phpfpm_settings']['max_children']['description'] = 'Il numero di processi figli che vengono creati quando il pm è impostato a  \'static\' e il numero massimo di processi figli che vengono creati quando il pm è impostato a \'dynamic\'<br />Equivalente a PHP_FCGI_CHILDREN';
$lng['serversettings']['phpfpm_settings']['start_servers']['title'] = 'Il numero di processi figli creati all\'avvio';
$lng['serversettings']['phpfpm_settings']['start_servers']['description'] = 'Nota: Usato solo quando il pm è impostato a \'dynamic\'';
$lng['serversettings']['phpfpm_settings']['min_spare_servers']['title'] = 'Il numero minimo di processi inattivi nel server';
$lng['serversettings']['phpfpm_settings']['min_spare_servers']['description'] = 'Nota: Usato solo quando il pm è impostato a \'dynamic\'<br />Nota: Obbligatorio quando il pm è impostato a \'dynamic\'';
$lng['serversettings']['phpfpm_settings']['max_spare_servers']['title'] = 'Il numero massimo di processi inattivi nel server';
$lng['serversettings']['phpfpm_settings']['max_spare_servers']['description'] = 'Nota: Usato solo quando il pm è impostato a \'dynamic\'<br />Nota: Obbligatorio quando il pm è impostato a \'dynamic\'';
$lng['serversettings']['phpfpm_settings']['max_requests']['title'] = 'Richieste per figli prima di rigenerare';
$lng['serversettings']['phpfpm_settings']['max_requests']['description'] = 'Per le richieste senza fine specificare \'0\'. Equivalente a PHP_FCGI_MAX_REQUESTS.';
$lng['error']['phpfpmstillenabled'] = 'PHP-FPM è attivo. Si prega di disattivarlo prima di attivare FCGID';
$lng['error']['fcgidstillenabled'] = 'FCGID è attivo. Si prega di disattivarlo prima di attivare PHP-FPM';
$lng['phpfpm']['vhost_httpuser'] = 'Utente locale per PHP-FPM (Froxlor vHost)';
$lng['phpfpm']['vhost_httpgroup'] = 'Gruppo locale per PHP-FPM (Froxlor vHost)';
$lng['phpfpm']['ownvhost']['title'] = 'Abilita PHP-FPM per i vHost Froxlor';
$lng['phpfpm']['ownvhost']['description'] = 'Se abilitato, Froxlor potrà essere avviato attraverso un utente locale';

// ADDED IN FROXLOR 0.9.17
$lng['crondesc']['cron_usage_report'] = 'Invia i report di utilizzo web e del traffico';
$lng['serversettings']['report']['report'] = 'Abilita l\'invio dei report di utilizzo web e del traffico';
$lng['serversettings']['report']['webmax'] = 'Percentuale di avviso per lo spazio web';
$lng['serversettings']['report']['trafficmax'] = 'Percentuale di avviso per il traffico';
$lng['mails']['trafficmaxpercent']['mailbody'] = 'Salve {NAME},\n\nhai utilizzato {TRAFFICUSED} MB di {TRAFFIC} MB traffico disponibile.\nQuesto è più del {MAX_PERCENT}%.\n\nCordiali Saluti, il Team Froxlor';
$lng['mails']['trafficmaxpercent']['subject'] = 'Raggiunto il limite di traffico';
$lng['admin']['templates']['trafficmaxpercent'] = 'Mail di notifica per i clienti che hanno raggiunto il limite di traffico';
$lng['admin']['templates']['MAX_PERCENT'] = 'Sostituito con spazio/limite di traffico per l\'invio dei report in precentuale.';
$lng['admin']['templates']['USAGE_PERCENT'] = 'Sostituito con l\'utilizzo del disco/limite di traffico, che è stato esaurito da parte del cliente in percentuale.';
$lng['admin']['templates']['diskmaxpercent'] = 'Mail di notifica per i clienti che hanno raggiunto il limite di spazio su disco';
$lng['admin']['templates']['DISKAVAILABLE'] = 'Sostituito con il spazio utilizzato in MB, che è stato assegnato al cliente.';
$lng['admin']['templates']['DISKUSED'] = 'Sostituito con il spazio utilizzato in MB, che è stato esaurito da parte del cliente.';
$lng['serversettings']['dropdown'] = 'Dropdown';
$lng['serversettings']['manual'] = 'Manuale';
$lng['mails']['webmaxpercent']['mailbody'] = 'Salve {NAME},\n\nhai utilizzato {DISKUSED} MB di {DISKAVAILABLE} MB di spazio disponibile.\nQuesto è più del {MAX_PERCENT}%.\n\nCordiali Saluti, il Team Froxlor';
$lng['mails']['webmaxpercent']['subject'] = 'Raggiungere il limite di spazio su disco';
$lng['mysql']['database_edit'] = 'Modifica database';

// ADDED IN FROXLOR 0.9.18
$lng['error']['domains_cantdeletedomainwithaliases'] = 'Non è possibile cancellare un dominio che viene utilizzato per alias-domains. È necessario eliminare prima gli alias.';
$lng['serversettings']['default_theme'] = 'Tema predefinito';
$lng['menue']['main']['changetheme'] = 'Cambia tema';
$lng['panel']['theme'] = 'Tema';
$lng['success']['rebuildingconfigs'] = 'Inseriti con successo i lavori per la ricostruzione del file di configurazione';
$lng['panel']['variable'] = 'Variabile';
$lng['panel']['description'] = 'Descrizione';
$lng['emails']['back_to_overview'] = 'Torna indietro nel riepilogo';

// ADDED IN FROXLOR 0.9.20
$lng['error']['user_banned'] = 'Il tuo account è stato bannato. Contatta l\'amministratore per maggiori informazioni.';
$lng['serversettings']['validate_domain'] = 'Convalida dei domini';
$lng['login']['combination_not_found'] = 'Combinazione utente-indirizzo email non trovata.';
$lng['customer']['generated_pwd'] = 'Password suggerita';
$lng['customer']['usedmax'] = 'Usato / Massimo';
$lng['admin']['traffic'] = 'Traffico';
$lng['admin']['domaintraffic'] = 'Domimi';
$lng['admin']['customertraffic'] = 'Clienti';
$lng['traffic']['customer'] = 'Cliente';
$lng['traffic']['domain'] = 'Domini';
$lng['traffic']['trafficoverview'] = 'Riepilogo del traffico di';
$lng['traffic']['months']['jan'] = 'Gen';
$lng['traffic']['months']['feb'] = 'Feb';
$lng['traffic']['months']['mar'] = 'Mar';
$lng['traffic']['months']['apr'] = 'Apr';
$lng['traffic']['months']['may'] = 'Mag';
$lng['traffic']['months']['jun'] = 'Giu';
$lng['traffic']['months']['jul'] = 'Lug';
$lng['traffic']['months']['aug'] = 'Ago';
$lng['traffic']['months']['sep'] = 'Set';
$lng['traffic']['months']['oct'] = 'Ott';
$lng['traffic']['months']['nov'] = 'Nov';
$lng['traffic']['months']['dec'] = 'Dic';
$lng['traffic']['months']['total'] = 'Totale';
$lng['traffic']['details'] = 'Dettagli';
$lng['menue']['traffic']['table'] = 'Traffico';
$lng['error']['admin_domain_emailsystemhostname'] = 'Spiacente, l\'hostname di sistema non può essere usato come dominio di un cliente';
$lng['backup'] = 'Backup';
$lng['backup_allowed'] = 'Backup permesso';
$lng['extras']['backup_create'] = 'Creare il Backup?';
$lng['extras']['backup_info'] = 'Il Backup sarà eseguito una volta al giorno nella cartella "' . $settings['system']['backup_dir'] . '".';
$lng['extras']['backup_info_sep'] = 'Contiene gli archivi compressi dei file HTML Files e dei Database.';
$lng['extras']['backup_info_big'] = 'Contiene un archivio compresso dei file HTML Files e dei Database.';
$lng['extras']['backup_count_info'] = '<br /><br />Si tenga in considerazione che il backup utilizza lo spazio web!';
$lng['serversettings']['backup_count'] = 'Viene sottratta la dimensione del backup dalla spazio web disponibile?';
$lng['serversettings']['backup_enabled'] = 'Attivo il Backup?';
$lng['serversettings']['backupdir']['description'] = 'Qual\'è il nome della cartella di backup dell\'utente?';
$lng['serversettings']['mysqldump_path']['description'] = 'Percorso del comando mysqldump?';
$lng['serversettings']['backup_bigfile'] = 'Salvare il backup in un unico grande file al posto di salvare separatamente i file html e i database?';
$lng['serversettings']['backup_ftp_enabled'] = 'Attiva o l\'upload FTP?';
$lng['serversettings']['backup_ftp_server'] = 'Server FTP:';
$lng['serversettings']['backup_ftp_user'] = 'Utente FTP:';
$lng['serversettings']['backup_ftp_pass'] = 'Password FTP:';
$lng['crondesc']['cron_backup'] = 'Backup cronjob';
