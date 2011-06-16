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
 * @author     Jordi Romero (jordi@jrom.net)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Language
 *
 */

/**
 * Global
 */

$lng['translator'] = 'Jordi Romero';
$lng['panel']['edit'] = 'editar';
$lng['panel']['delete'] = 'esborrar';
$lng['panel']['create'] = 'crear';
$lng['panel']['save'] = 'guardar';
$lng['panel']['yes'] = 's&iacute;';
$lng['panel']['no'] = 'no';
$lng['panel']['emptyfornochanges'] = 'deixeu-ho buit per no canviar-ne el valor';
$lng['panel']['emptyfordefault'] = 'deixeu-ho buit per usar el valor predeterminat';
$lng['panel']['path'] = 'Ruta';
$lng['panel']['toggle'] = 'Marcar/Desmarcar';
$lng['panel']['next'] = 'seg�ent';
$lng['panel']['dirsmissing'] = 'No puc trobar o escriure en aquest directori!';

/**
 * Login
 */

$lng['login']['username'] = 'Nom d\'usuari';
$lng['login']['password'] = 'Contrassenya';
$lng['login']['language'] = 'Idioma';
$lng['login']['login'] = 'Identificar-se';
$lng['login']['logout'] = 'sortir';
$lng['login']['profile_lng'] = 'Idioma del perfil';

/**
 * Customer
 */

$lng['customer']['documentroot'] = 'Directori HOME';
$lng['customer']['name'] = 'Nom';
$lng['customer']['company'] = 'Empresa';
$lng['customer']['street'] = 'Carrer';
$lng['customer']['zipcode'] = 'Codi Postal';
$lng['customer']['city'] = 'ciutat';
$lng['customer']['phone'] = 'tel&egrave;fon';
$lng['customer']['fax'] = 'fax';
$lng['customer']['email'] = 'email';
$lng['customer']['customernumber'] = 'ID de client';
$lng['customer']['diskspace'] = 'Espai Web (MB)';
$lng['customer']['traffic'] = 'Trafic (GB)';
$lng['customer']['mysqls'] = 'Bases de dades MySQL';
$lng['customer']['emails'] = 'Adreces de correu';
$lng['customer']['accounts'] = 'Comptes d\'e-mail';
$lng['customer']['forwarders'] = 'Redireccionadors de correu';
$lng['customer']['ftps'] = 'Comptes FTP';
$lng['customer']['subdomains'] = 'Subdomini(s)';
$lng['customer']['domains'] = 'Domini(s)';
$lng['customer']['unlimited'] = 'ilimitat';

/**
 * Customermenue
 */

$lng['menue']['main']['main'] = 'Principal';
$lng['menue']['main']['changepassword'] = 'Canviar Clau';
$lng['menue']['main']['changelanguage'] = 'Canviar Idioma';
$lng['menue']['email']['email'] = 'email';
$lng['menue']['email']['emails'] = 'Adreces';
$lng['menue']['email']['webmail'] = 'WebMail';
$lng['menue']['mysql']['mysql'] = 'MySQL';
$lng['menue']['mysql']['databases'] = 'Bases de dades';
$lng['menue']['mysql']['phpmyadmin'] = 'phpMyAdmin';
$lng['menue']['domains']['domains'] = 'Dominis';
$lng['menue']['domains']['settings'] = 'Opcions';
$lng['menue']['ftp']['ftp'] = 'FTP';
$lng['menue']['ftp']['accounts'] = 'Comptes';
$lng['menue']['ftp']['webftp'] = 'WebFTP';
$lng['menue']['extras']['extras'] = 'Extres';
$lng['menue']['extras']['directoryprotection'] = 'Protecci&oacute; de directori(s)';
$lng['menue']['extras']['pathoptions'] = 'Opcions de la ruta (PATH)';

/**
 * Index
 */

$lng['index']['customerdetails'] = 'Detalls del client';
$lng['index']['accountdetails'] = 'Detalls del compte';

/**
 * Change Password
 */

$lng['changepassword']['old_password'] = 'Clau antiga';
$lng['changepassword']['new_password'] = 'Clau nova';
$lng['changepassword']['new_password_confirm'] = 'Clau nova (confirmaci&oacute;)';
$lng['changepassword']['new_password_ifnotempty'] = 'Clau nova (Deixa-ho buit per no canviar)';
$lng['changepassword']['also_change_ftp'] = ' canvia tamb&eacute; la clau del compte principal del FTP';

/**
 * Domains
 */

$lng['domains']['description'] = 'Des d\'aqu&iacute; pots crear (sub)dominis i canviar les seves rutes.<br />El sistema necessitar&agrave; una mica de temps per aplicar els nous canvis un cop efectuats.';
$lng['domains']['domainsettings'] = 'Opcions de domini';
$lng['domains']['domainname'] = 'Nom del domini';
$lng['domains']['subdomain_add'] = 'Crear subdomini';
$lng['domains']['subdomain_edit'] = 'Editar (sub)domini';
$lng['domains']['wildcarddomain'] = 'Crear un domini comod&iacute;? (wildcarddomain)';
$lng['domains']['aliasdomain'] = 'Sobrenom per a aquest domini';
$lng['domains']['noaliasdomain'] = 'No hi ha sobrenom del domini';

/**
 * eMails
 */

$lng['emails']['description'] = 'Des d\'aqu&iacute; pots modificar les adreces de correu, crear-ne de noves o esborrar les que hi ha.<br />Pensa que despr&eacute;s de crear la adre&ccedil;a de correu, has de crear o b&eacute; un COMPTE o b&eacute; un REDIRECCIONADOR, sense una de les dues coses la adre&ccedil;a &eacute;s in�til.<br /><br />Per baixar-te el correu en el teu client de correu (Outlook, Thunderbird, ...) utilitza la seg�ent informaci&oacute;: (La informaci&oacute; en <i>cursiva</i> ha de ser substituida per la que correspongui al compte de correu en questi&oacute;!)<br />Servidor de correu entrant o sortint: <b><i>el teu domini</i></b><br />Nom dusuari: <b><i>(usuari@exemple.com)</i></b> (ATENCI�: �s imprescindible posar la adre&ccedil;a sencera en el camp de l\'usuari, en cas contrari no funcionaria)<br />Clau: <b><i>la clau del compte de correu</i></b>';
$lng['emails']['emailaddress'] = 'adreces d\'email';
$lng['emails']['emails_add'] = 'Crear adre&ccedil;a d\'email';
$lng['emails']['emails_edit'] = 'Editar adreces d\'email';
$lng['emails']['catchall'] = 'Compte comod&iacute;';
$lng['emails']['iscatchall'] = 'Definir els Comptes comod&iacute;?';
$lng['emails']['account'] = 'Compte';
$lng['emails']['account_add'] = 'Crear compte';
$lng['emails']['account_delete'] = 'Esborrar compte';
$lng['emails']['from'] = 'Origen';
$lng['emails']['to'] = 'Dest&iacute;';
$lng['emails']['forwarders'] = 'Redireccions';
$lng['emails']['forwarder_add'] = 'Crear redirecci&oacute;';

/**
 * FTP
 */

$lng['ftp']['description'] = 'Aqu&iacute; pots crear els teus comptes FTP.<br />Els canis s\'aplicaran a l\'instant.';
$lng['ftp']['account_add'] = 'Crear compte';

/**
 * MySQL
 */

$lng['mysql']['description'] = 'Pendent de traduir<br />Here you can create and change your MySQL-Databases.<br />The changes are made instantly and the database can be used immediately.<br />At the menu on the left side you find the tool phpMyAdmin with which you can easily administer your database.<br /><br />To use your databases in your own php-scripts use the following settings: (The data in <i>italics</i> have to be changed into the equivalents you typed in!)<br />Hostname: <b><SQL_HOST></b><br />Username: <b><i>Databasename</i></b><br />Password: <b><i>the password you\'ve chosen</i></b><br />Database: <b><i>Databasename';
$lng['mysql']['databasename'] = 'nom d\'usuari/base de dades';
$lng['mysql']['databasedescription'] = 'descripci&oacute; de la base de dades';
$lng['mysql']['database_create'] = 'Crear base de dades';

/**
 * Extras
 */

$lng['extras']['description'] = 'Aqu&iacute; pots controlar alguns extres, com protecci&oacute; de directoris.<br />El sistema requereix una mica de temps en aplicar els canvis un cop fets.';
$lng['extras']['directoryprotection_add'] = 'Afegir protecci&oacute; de directori';
$lng['extras']['view_directory'] = 'mostra el contingut del directori';
$lng['extras']['pathoptions_add'] = 'afegir opcions de la ruta (PATH)';
$lng['extras']['directory_browsing'] = 'navegar pel contingut del directori';
$lng['extras']['pathoptions_edit'] = 'editar opcions de la ruta (PATH)';
$lng['extras']['error404path'] = '404';
$lng['extras']['error403path'] = '403';
$lng['extras']['error500path'] = '500';
$lng['extras']['error401path'] = '401';
$lng['extras']['errordocument404path'] = 'Ruta a ErrorDocument 404';
$lng['extras']['errordocument403path'] = 'Ruta a ErrorDocument 403';
$lng['extras']['errordocument500path'] = 'Ruta a ErrorDocument 500';
$lng['extras']['errordocument401path'] = 'Ruta a ErrorDocument 401';

/**
 * Errors
 */

$lng['error']['error'] = 'Error';
$lng['error']['directorymustexist'] = 'El directori que has escrit no existeix. Si us plau, crea\'l per FTP.';
$lng['error']['filemustexist'] = 'El fitxer ha d\'existir.';
$lng['error']['allresourcesused'] = 'Ja has gastat tots els teus recursos!';
$lng['error']['domains_cantdeletemaindomain'] = 'No pots esborrar aquest domini perqu&egrave; est&agrave; sent usat en una adre&ccedil;a d\'email.';
$lng['error']['domains_canteditdomain'] = 'No pots editar aquests dominis. Han estat bloquejats per l\'administrador';
$lng['error']['domains_cantdeletedomainwithemail'] = 'No pots esborrar aquest domini perqu&egrave; est&agrave; sent usat per una direcci&oacute; de correu. Has d\'esborrar abans la direcci&oacute; de correu';
$lng['error']['firstdeleteallsubdomains'] = 'No pots esborrar tots els subdominis si no tens un domini comod&iacute; (Wildcarddomain).';
$lng['error']['youhavealreadyacatchallforthisdomain'] = 'Ja tens un compte comod&iacute;';
$lng['error']['ftp_cantdeletemainaccount'] = 'No pots esborrar el compte principal FTP';
$lng['error']['login'] = 'El nom d\'usuari o la Clau s&oacute;n incorrectes. Sisplau torna-ho a intentar!';
$lng['error']['login_blocked'] = 'Aquest compte ha estat susp&egrave;s a causa de massa intents fraudulents d\'identificaci&oacute;. <br />Si us plau, torna a provar-ho en ' . $settings['login']['deactivatetime'] . ' segons.';
$lng['error']['notallreqfieldsorerrors'] = 'No has omplert tots els camps o algun camp &eacute;s incorrecte.';
$lng['error']['oldpasswordnotcorrect'] = 'La clau antiga no &eacute;s la correcta.';
$lng['error']['youcantallocatemorethanyouhave'] = 'No pots ocupar m&eacute;s espai del que tens assignat!';
$lng['error']['mustbeurl'] = 'No has escrit una URL correcte';
$lng['error']['invalidpath'] = 'No has escrit una URL v&agrave;lida (potser hi ha algun problema en el llistat de directoris)';
$lng['error']['stringisempty'] = 'Camp de text buit';
$lng['error']['stringiswrong'] = 'Contingut erroni en el camp de text';
$lng['error']['myloginname'] = '\'' . $lng['login']['username'] . '\'';
$lng['error']['mypassword'] = '\'' . $lng['login']['password'] . '\'';
$lng['error']['oldpassword'] = '\'' . $lng['changepassword']['old_password'] . '\'';
$lng['error']['newpassword'] = '\'' . $lng['changepassword']['new_password'] . '\'';
$lng['error']['newpasswordconfirm'] = '\'' . $lng['changepassword']['new_password_confirm'] . '\'';
$lng['error']['newpasswordconfirmerror'] = 'La nova clau no coincideix amb la confirmaci&oacute;';
$lng['error']['myname'] = '\'' . $lng['customer']['name'] . '\'';
$lng['error']['myfirstname'] = '\'' . $lng['customer']['firstname'] . '\'';
$lng['error']['emailadd'] = '\'' . $lng['customer']['email'] . '\'';
$lng['error']['mydomain'] = '\'Domini\'';
$lng['error']['mydocumentroot'] = '\'Arrel dels documents\'';
$lng['error']['loginnameexists'] = 'Ja existeix l\'usuari %s';
$lng['error']['emailiswrong'] = 'L\'adre&ccedil;a de correu %s cont&eacute; car&agrave;cters inv&agrave;lids o est&agrave; incompleta';
$lng['error']['loginnameiswrong'] = 'El nom d\'usuari %s cont&eacute; no &eacute;s v&agrave;lid';
$lng['error']['userpathcombinationdupe'] = 'La combinaci&oacute; d\'usuari i Ruta escollida ja existeix';
$lng['error']['patherror'] = 'Error! Has d\'introduir una ruta';
$lng['error']['errordocpathdupe'] = 'Aquesta opci&oacute; per la ruta %s ja existeix';
$lng['error']['adduserfirst'] = 'Abans has de crear un client';
$lng['error']['domainalreadyexists'] = 'El domini %s ja est&agrave; assignat a un client';
$lng['error']['nolanguageselect'] = 'Has de sel&middot;leccionar un idioma.';
$lng['error']['nosubjectcreate'] = 'Has de definir l\'assumpte per aquesta plantilla de correu.';
$lng['error']['nomailbodycreate'] = 'Has de definir el cos del missatge per aquesta plantilla de correu.';
$lng['error']['templatenotfound'] = 'No s\'ha trobat la plantilla.';
$lng['error']['alltemplatesdefined'] = 'No pots definir noves plantilles. Tots els idiomes estan suportats.';
$lng['error']['wwwnotallowed'] = 'www no &eacute;s un subdomini perm&egrave;s.';
$lng['error']['subdomainiswrong'] = 'El subdomini %s cont&eacute; car&agrave;cters inv&agrave;lids.';
$lng['error']['domaincantbeempty'] = 'El domini no pot ser un camp buit.';
$lng['error']['domainexistalready'] = 'Ja existeix el domini %s.';
$lng['error']['domainisaliasorothercustomer'] = 'El sobrenom de domini escollit ja existeix, o pertany a un altre client.';
$lng['error']['emailexistalready'] = 'Ja existeix l\'adre&ccedil;a %s.';
$lng['error']['maindomainnonexist'] = 'El domini %s no existeix.';
$lng['error']['destinationnonexist'] = 'Si us plau crea la redirecci&oacute; a \'Dest&iacute;\'.';
$lng['error']['destinationalreadyexistasmail'] = 'La redirecci&oacute; a %s ja existeix com un compte de correu.';
$lng['error']['destinationalreadyexist'] = 'Ja hi ha una redirecci&oacute; a %s .';
$lng['error']['destinationiswrong'] = 'La redirecci&oacute; %s cont&eacute; car&agrave;cters inv&agrave;lids o &eacute;s incompleta.';
$lng['error']['domainname'] = $lng['domains']['domainname'];

/**
 * Questions
 */

$lng['question']['question'] = 'Preguntes de seguretat..';
$lng['question']['admin_customer_reallydelete'] = 'Estas segur que vols esborrar el client %s? Aquesta acci&oacute; &eacute;s irreversible!';
$lng['question']['admin_domain_reallydelete'] = 'Segur que vols esborrar el domini %s?';
$lng['question']['admin_domain_reallydisablesecuritysetting'] = 'Segur que vols desactivar aquesta opci&oacute; de seguretat? (OpenBasedir)?';
$lng['question']['admin_admin_reallydelete'] = 'Segur que vols esborrar l\'administrador %s? Tots els seus clients aniran a parar a l\'administrador principal.';
$lng['question']['admin_template_reallydelete'] = 'Segur que vols esborrar aquesta plantilla \'%s\'?';
$lng['question']['domains_reallydelete'] = 'Segur que vols esborrar el domini %s?';
$lng['question']['email_reallydelete'] = 'Segur que vols esborrar la adre&ccedil;a %s?';
$lng['question']['email_reallydelete_account'] = 'Segur que vols esborrar el compte %s?';
$lng['question']['email_reallydelete_forwarder'] = 'Segur que vols esborrar la redirecci&oacute; %s?';
$lng['question']['extras_reallydelete'] = 'Segur que vols esborrar la direcci&oacute; de directori de %s?';
$lng['question']['extras_reallydelete_pathoptions'] = 'Segur que vols eliminar les opcions de ruta (PATH) de %s?';
$lng['question']['ftp_reallydelete'] = 'Segur que vols esborrar el compte FTP %s?';
$lng['question']['mysql_reallydelete'] = 'Segur que vols eliminar la base de dades %s? Aquesta acci&oacute; &eacute;s irreversible!';
$lng['question']['admin_configs_reallyrebuild'] = 'Segur que vols regenerar les configuracions dels servidors apache i bind?';

/**
 * Mails
 */

$lng['mails']['pop_success']['mailbody'] = 'Hola,\n\nel teu compte d\'email $destination\ns\'ha creat satisfactoriament.\n\nAix� &eacute;s un missatge creat autom&agrave;ticament, si us plau uno responguis. Gr&agrave;cies.';
$lng['mails']['pop_success']['subject'] = 'Compte de correu creat satisfactoriament';
$lng['mails']['createcustomer']['mailbody'] = 'Hola {FIRSTNAME} {NAME},\n\n aqu&iacute; te la seva informaci&oacute;:\n\nNom d\'usuari: $loginname\nClau: $password\n\n Gr&agrave;cies per tot, disfruta del teu compte';
$lng['mails']['createcustomer']['subject'] = 'Informaci&oacute; del compte';

/**
 * Admin
 */

$lng['admin']['overview'] = 'Resum';
$lng['admin']['ressourcedetails'] = 'Recursos utilitzats';
$lng['admin']['systemdetails'] = 'Detalls del sistema';
$lng['admin']['froxlordetails'] = 'Detalls de Froxlor';
$lng['admin']['installedversion'] = 'Versi&oacute;';
$lng['admin']['latestversion'] = '�ltima versi&oacute;';
$lng['admin']['lookfornewversion']['clickhere'] = 'cerca a internet';
$lng['admin']['lookfornewversion']['error'] = 'Error carregant';
$lng['admin']['resources'] = 'Personal';
$lng['admin']['customer'] = 'Client';
$lng['admin']['customers'] = 'Clients';
$lng['admin']['customer_add'] = 'Crear client';
$lng['admin']['customer_edit'] = 'Editar client';
$lng['admin']['domains'] = 'Dominis';
$lng['admin']['domain_add'] = 'Crear domini';
$lng['admin']['domain_edit'] = 'Editar domini';
$lng['admin']['subdomainforemail'] = 'Subdomini com a subdomini de correu';
$lng['admin']['admin'] = 'Administrador';
$lng['admin']['admins'] = 'Administradors';
$lng['admin']['admin_add'] = 'Crear administrador';
$lng['admin']['admin_edit'] = 'Editar administrador';
$lng['admin']['customers_see_all'] = 'Pot veure tots els clients?';
$lng['admin']['domains_see_all'] = 'Pot veure tots els dominis?';
$lng['admin']['change_serversettings'] = 'Pot canviar configuracions del servidor?';
$lng['admin']['server'] = 'Servidor';
$lng['admin']['serversettings'] = 'Opcions del servidor';
$lng['admin']['rebuildconf'] = 'Regenerar fitxers de configuraci&oacute;';
$lng['admin']['stdsubdomain'] = 'Subdomini est&agrave;ndar';
$lng['admin']['stdsubdomain_add'] = 'Crear subdomini est&agrave;ndar';
$lng['admin']['deactivated'] = 'Desactivat';
$lng['admin']['deactivated_user'] = 'Desactivar Usuari';
$lng['admin']['sendpassword'] = 'Enviar Clau';
$lng['admin']['ownvhostsettings'] = 'Opcions dels vhost propis';
$lng['admin']['configfiles']['serverconfiguration'] = 'Configuracions del servidor';
$lng['admin']['configfiles']['files'] = '<b>Fitxers de configuraci&oacute;:</b> Si us plau, canvia els continguts fitxers o crea\'ls<br />amb el cotingut que surt a continuaci&oacute; si no existeixen.<br /><b>Nota:</b> El Mysql-password no ha estat modificat per questions de seguretat.<br />Canvia &quot;MYSQL_PASSWORD&quot; per la clau que desitgi';
$lng['admin']['configfiles']['commands'] = '<b>Comandaments:</b> Executa\'ls en una consola.';
$lng['admin']['configfiles']['restart'] = '<b>Restart:</b> Executa els seg�ents comandaments en la consola per carregar la nova configuraci&oacute;.';
$lng['admin']['templates']['templates'] = 'Plantilles';
$lng['admin']['templates']['template_add'] = 'Afegir plantilla';
$lng['admin']['templates']['template_edit'] = 'Editar plantilla';
$lng['admin']['templates']['action'] = 'Acci&oacute;';
$lng['admin']['templates']['email'] = 'E-Mail';
$lng['admin']['templates']['subject'] = 'Assumpte';
$lng['admin']['templates']['mailbody'] = 'Cos del missatge';
$lng['admin']['templates']['createcustomer'] = 'Missatge de benvinguda a nous clients';
$lng['admin']['templates']['pop_success'] = 'Missatge de benvinguda a les noves comptes de correu';
$lng['admin']['templates']['template_replace_vars'] = 'Variables per substituir a la plantilla:';
$lng['admin']['templates']['FIRSTNAME'] = 'Substituit pel cognom del client.';
$lng['admin']['templates']['NAME'] = 'Substituit pel nom del client.';
$lng['admin']['templates']['USERNAME'] = 'Reempla&ccedil;at pel nom d\'usuari';
$lng['admin']['templates']['PASSWORD'] = 'Reempla&ccedil;at per la contrassenya.';
$lng['admin']['templates']['EMAIL'] = 'Reempla&ccedil;at per l\'adre&ccedil;a de correu';

/**
 * Serversettings
 */

$lng['serversettings']['session_timeout']['title'] = 'Sessi&oacute; Timeout';
$lng['serversettings']['session_timeout']['description'] = 'Quant triga un usuari en esdevenir inactiu (segons)?';
$lng['serversettings']['accountprefix']['title'] = 'Prefix del client';
$lng['serversettings']['accountprefix']['description'] = 'Quin prefix han de tenir els clients?';
$lng['serversettings']['mysqlprefix']['title'] = 'Prefix SQL';
$lng['serversettings']['mysqlprefix']['description'] = 'Quin prefix han de tenir els comptes SQL?';
$lng['serversettings']['ftpprefix']['title'] = 'Prefix FTP';
$lng['serversettings']['ftpprefix']['description'] = 'Quin prefix han de tenir els comptes FTP?';
$lng['serversettings']['documentroot_prefix']['title'] = 'Directori principal';
$lng['serversettings']['documentroot_prefix']['description'] = 'On es desen els documents?';
$lng['serversettings']['logfiles_directory']['title'] = 'Directori de logs';
$lng['serversettings']['logfiles_directory']['description'] = 'On es desen els fitxers de registre (log)?';
$lng['serversettings']['ipaddress']['title'] = 'Adre&ccedil;a IP';
$lng['serversettings']['ipaddress']['description'] = 'Quina &eacute;s la adre&ccedil;a IP del servidor?';
$lng['serversettings']['hostname']['title'] = 'Hostname';
$lng['serversettings']['hostname']['description'] = 'Quin &eacute;s el hostname del servidor?';
$lng['serversettings']['apachereload_command']['title'] = 'Comanda de reinici d\'Apache';
$lng['serversettings']['apachereload_command']['description'] = 'Quina &eacute;s la comanda per reiniciar Apache?';
$lng['serversettings']['bindconf_directory']['title'] = 'Directori de configuraci&oacute; de Bind';
$lng['serversettings']['bindconf_directory']['description'] = 'On s&oacute;n els fitxers de configuraci&oacute; de Bind?';
$lng['serversettings']['bindreload_command']['title'] = 'Comanda de reinici de Bind';
$lng['serversettings']['bindreload_command']['description'] = 'Quina &eacute;s la comanda per reiniciar Bind?';
$lng['serversettings']['binddefaultzone']['title'] = 'Zona predeterminada de Bind';
$lng['serversettings']['binddefaultzone']['description'] = 'Quina &eacute;s la zona per defecte de Bind?';
$lng['serversettings']['vmail_uid']['title'] = 'UID de les adreces de correu';
$lng['serversettings']['vmail_uid']['description'] = 'Quina User ID han de tenir les adreces de correu?';
$lng['serversettings']['vmail_gid']['title'] = 'GID de les adreces de correu';
$lng['serversettings']['vmail_gid']['description'] = 'Quina Group ID han de tenir les adreces de correu?';
$lng['serversettings']['vmail_homedir']['title'] = 'Directori dels correus';
$lng['serversettings']['vmail_homedir']['description'] = 'Quin &eacute;s el directori on es desaran tots els missatges de correu?';
$lng['serversettings']['adminmail']['title'] = 'Remitent';
$lng['serversettings']['adminmail']['description'] = 'Quin &eacute;s el remitent dels missatges del Froxlor?';
$lng['serversettings']['phpmyadmin_url']['title'] = 'Adre&ccedil;a de phpMyAdmin';
$lng['serversettings']['phpmyadmin_url']['description'] = 'Quina &eacute;s la URL del phpMyAdmin? (ha de comen&ccedil;ar amb http://)';
$lng['serversettings']['webmail_url']['title'] = 'Adre&ccedil;a de WebMail';
$lng['serversettings']['webmail_url']['description'] = 'Quina &eacute;s la URL del WebMail? (ha de comen&ccedil;ar amb http://)';
$lng['serversettings']['webftp_url']['title'] = 'Adre&ccedil;a de WebFTP';
$lng['serversettings']['webftp_url']['description'] = 'Quina &eacute;s la URL del WebFTP? (ha de comen&ccedil;ar amb http://)';
$lng['serversettings']['language']['description'] = 'Quin &eacute;s l\'idioma per defecte?';
$lng['serversettings']['maxloginattempts']['title'] = 'Intents de logueix m&agrave;xims';
$lng['serversettings']['maxloginattempts']['description'] = 'N�mero de vegades que pots intentar identificar-te abans de que la compta es desactivi.';
$lng['serversettings']['deactivatetime']['title'] = 'Temps de desactivacio';
$lng['serversettings']['deactivatetime']['description'] = 'Segons que la compta estar&agrave; inactiva quan s\'ha produit un seguit d\'intents frustrats d\'identificaci&oacute;.';
$lng['serversettings']['pathedit']['title'] = 'Tipus d\'entrada de ruta';
$lng['serversettings']['pathedit']['description'] = 'Vols que la ruta sigui escrita en una casella de text o en un men&uacute; desplegable?';

/**
 * ADDED BETWEEN 1.2.12 and 1.2.13
 */

$lng['serversettings']['paging']['title'] = 'Entrades per p&agrave;gina';
$lng['serversettings']['paging']['description'] = 'Entrades per p&agrave;gina? (0 = sense paginar)';
$lng['error']['ipstillhasdomains'] = 'La combinaci&oacute; IP/Port que vols esborrar t&eacute; dominis assignats. Si us plau, reassigna els dominis a una altra IP/Port abans d\'esborrar.';
$lng['error']['cantdeletedefaultip'] = 'No pots esborrar la combinaci&oacute; IP/Port per defecte del resseller, si us plau, assigna una nova combinaci&oacute; IP/Port al resseller abans d\'esborrar.';
$lng['error']['cantdeletesystemip'] = 'No pots esborrar la IP del sistema, abans crea una nova combinaci&oacute; IP/Port pel sistema.';
$lng['error']['myipaddress'] = '\'IP\'';
$lng['error']['myport'] = '\'Port\'';
$lng['error']['myipdefault'] = 'Has de sel&middot;leccionar una combinaci&oacute; IP/Port per defecte.';
$lng['error']['myipnotdouble'] = 'Aquesta combinaci&oacute; IP/Port ja existeix.';
$lng['question']['admin_ip_reallydelete'] = 'Segur que vols esborrar la IP %s?';
$lng['admin']['ipsandports']['ipsandports'] = 'IPs i Ports';
$lng['admin']['ipsandports']['add'] = 'Afegir IP/Port';
$lng['admin']['ipsandports']['edit'] = 'Editar IP/Port';
$lng['admin']['ipsandports']['ipandport'] = 'IP/Port';
$lng['admin']['ipsandports']['ip'] = 'IP';
$lng['admin']['ipsandports']['port'] = 'Port';

?>
