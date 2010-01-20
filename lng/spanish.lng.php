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
 * @author     Carlo Pedro Woedl <carlopedrowoedl@hotmail.com>
 * @author     Ron Brand <ron.brand@web.de>
 * @author     Sandra Aders
 * @license    GPLv2 http://files.syscp.org/misc/COPYING.txt
 * @package    Language
 * @version    $Id: spanish.lng.php 2692 2009-03-27 18:04:47Z flo $
 */

/**
 * Global
 */

$lng['translator'] = 'Carlo Pedro Woedl, Ron Brand, Sandra Aders';
$lng['panel']['edit'] = 'modificar';
$lng['panel']['delete'] = 'borar';
$lng['panel']['create'] = 'crear';
$lng['panel']['save'] = 'almacenar';
$lng['panel']['yes'] = 'si';
$lng['panel']['no'] = 'no';
$lng['panel']['emptyfornochanges'] = 'vac&iacute;o si no hay cambios';
$lng['panel']['emptyfordefault'] = 'vacia para los valores por defecto';
$lng['panel']['path'] = 'camino';
$lng['panel']['toggle'] = 'cambio';
$lng['panel']['next'] = 'continuar';
$lng['panel']['dirsmissing'] = 'Los registros no est&aacute;n disponibles o no son le&iacute;bles.';

/**
 * Login
 */

$lng['login']['username'] = 'Nombre del usuario';
$lng['login']['password'] = 'contrase&ntilde;a';
$lng['login']['language'] = 'Lengua';
$lng['login']['login'] = 'Registrarse';
$lng['login']['logout'] = 'Finalizar sesi&oacute;n';
$lng['login']['profile_lng'] = 'Lenguaje del perfil';

/**
 * Customer
 */

$lng['customer']['documentroot'] = 'Hogar';
$lng['customer']['name'] = 'Apellido';
$lng['customer']['firstname'] = 'Nombre';
$lng['customer']['company'] = 'Raz&oacute;n social';
$lng['customer']['street'] = 'Direcci&oacute;n';
$lng['customer']['zipcode'] = 'Codigo Postal/Poblaci&oacute;n';
$lng['customer']['city'] = 'Ciudad';
$lng['customer']['phone'] = 'Tel&eacute;fono';
$lng['customer']['fax'] = 'Telefax';
$lng['customer']['email'] = 'Email';
$lng['customer']['customernumber'] = 'Numero de Cliente';
$lng['customer']['diskspace'] = 'Espacio de web (MB)';
$lng['customer']['traffic'] = 'Trafico (GB)';
$lng['customer']['mysqls'] = 'MySQL-Base de datos';
$lng['customer']['emails'] = 'Direcciones e-mail';
$lng['customer']['accounts'] = 'Cuentas e-mail';
$lng['customer']['forwarders'] = 'e-mail de reenv&iacute;o';
$lng['customer']['ftps'] = 'FTP-Cuentas';
$lng['customer']['subdomains'] = 'Subdominios';
$lng['customer']['domains'] = 'Dominios';
$lng['customer']['unlimited'] = 'infinito';

/**
 * Customermenue
 */

$lng['menue']['main']['main'] = 'Universal';
$lng['menue']['main']['changepassword'] = 'Cambiar contrase&ntilde;a';
$lng['menue']['main']['changelanguage'] = 'Cambiar Idioma';
$lng['menue']['email']['email'] = 'eMail';
$lng['menue']['email']['emails'] = 'Direcciones';
$lng['menue']['email']['webmail'] = 'Sistema Webmail';
$lng['menue']['mysql']['mysql'] = 'MySQL';
$lng['menue']['mysql']['databases'] = 'Base de datos';
$lng['menue']['mysql']['phpmyadmin'] = 'phpMyAdmin';
$lng['menue']['domains']['domains'] = 'Dominios';
$lng['menue']['domains']['settings'] = 'Configuraciones';
$lng['menue']['ftp']['ftp'] = 'FTP';
$lng['menue']['ftp']['accounts'] = 'Cuentas';
$lng['menue']['ftp']['webftp'] = 'WebFTP';
$lng['menue']['extras']['directoryprotection'] = 'directorio de protecci&oacute;n';
$lng['menue']['extras']['pathoptions'] = 'Opciones del camino';

/**
 * Index
 */

$lng['index']['customerdetails'] = 'Datos de Clientes';
$lng['index']['accountdetails'] = 'Datos Cuentas';

/**
 * Change Password
 */

$lng['changepassword']['old_password'] = 'Contrase&ntilde;a anterior';
$lng['changepassword']['new_password'] = 'Contrase&ntilde;a nueva';
$lng['changepassword']['new_password_confirm'] = 'Contrase&ntilde;a (Repetir)';
$lng['changepassword']['new_password_ifnotempty'] = 'Contrase&ntilde;a nueva (libre=sin cambio)';
$lng['changepassword']['also_change_ftp'] = 'tambien cambiar la Contrase&ntilde;a del FTP';

/**
 * Domains
 */

$lng['domains']['description'] = 'Aqu&iacute; usted puede crear dominios (secundarios) y cambiar sus caminos.<br />El sistema necesitar&aacute; un cierto tiempo para aplicar las nuevas configuraciones despu&eacute;s de cada cambio.';
$lng['domains']['domainsettings'] = 'Configuraciones del dominio';
$lng['domains']['domainname'] = 'Nombre del dominio';
$lng['domains']['subdomain_add'] = 'Crear el secundario-dominio';
$lng['domains']['subdomain_edit'] = 'Corrija el dominio (secundario)';
$lng['domains']['wildcarddomain'] = '&#191;Crear como comod&Atilde;n-dominio?';
$lng['domains']['aliasdomain'] = 'Alias para dominio';
$lng['domains']['noaliasdomain'] = 'No es un alias de dominio';

/**
 * eMails
 */

$lng['emails']['description'] = 'Aqui puede Usted crear su propia direccion e-mail.<br />Una Cuenta es como un Buzon en la Puerta de la Casa . Cuando alguien le escribe una email , esta aparece en su cuenta.<br/><br />Para descargar sus email utilice las configuraciones siguientes en su email-programa: (Los datos en letra <i>kursiva</i> seran sustituidas por las asignadas!)<br />nombre del Host: <b><i>Nombre del Domain</i></b><br />Nombre del Usuario: <b><i>Cuenta / Direccion e-mail</i></b><br />Clave: <b><i>Clave Elegida</i></b>';
$lng['emails']['emailaddress'] = 'Direccion e-mail';
$lng['emails']['emails_add'] = 'Crear Direccion e-mail';
$lng['emails']['emails_edit'] = 'Cambiar Direccion e-mail';
$lng['emails']['catchall'] = 'Catchall';
$lng['emails']['iscatchall'] = 'Definir como Direccion Catchall';
$lng['emails']['account'] = 'Cuenta ';
$lng['emails']['account_add'] = 'Crear Cuenta';
$lng['emails']['account_delete'] = 'Borar Cuenta';
$lng['emails']['from'] = 'Fuente';
$lng['emails']['to'] = 'Destinaci&oacute;n';
$lng['emails']['forwarders'] = 'Reenviar';
$lng['emails']['forwarder_add'] = 'agregar reenvio';

/**
 * FTP
 */

$lng['ftp']['description'] = 'Aqui puede Usted crear FTP-Cuentas adicionales.<br />Los cambios se actualizan de inmediato y Usted puede Usar los FTP-Cuentas.';
$lng['ftp']['account_add'] = 'Crear Cuenta';

/**
 * MySQL
 */

$lng['mysql']['description'] = 'Aqui se puede crear/cancelar la MySQL Base de Datos.<br>Los Cambios se actualizan de inmediato y la Base de Datos se puede usar enseguida.<br />En el men&uacute; usted encuentra el phpMyAdmin de la herramienta con el cual usted puede administrar f&aacute;cilmente su base de datos.<br /><br />Para utilizar sus bases de datos en sus propias php-escrituras utilice las configuraciones siguientes: (Los datos en letra <i>cursiva</i> seran sustituidas por las asignadas!)<br />Nombre del Host:<b><SQL_HOST></b><br />Nombre del Usuario: <b><i>nombre de la base de datos</i></b><br />Clave: <b><i>contrase&ntilde;a elegida</i></b><br />Base de datos: <b><i>Nombre de la base de datos';
$lng['mysql']['databasename'] = 'Nombre -/Base de Datos';
$lng['mysql']['databasedescription'] = 'Indentificador de la Base de Datos';
$lng['mysql']['database_create'] = 'Abrir base de Datos';

/**
 * Extras
 */

$lng['extras']['description'] = 'Aqui se pueden crear Extras , por Eje.protector de Directorio.<br />Los cambios son despues de cierto tiempo aplicables.';
$lng['extras']['directoryprotection_add'] = 'Crear Protecci&oacute;n de Directorio';
$lng['extras']['view_directory'] = 'Mostrar directorio';
$lng['extras']['pathoptions_add'] = 'agregue las opciones del camino';
$lng['extras']['directory_browsing'] = 'Mostrar contenido del Directorio';
$lng['extras']['error404path'] = '404';
$lng['extras']['error403path'] = '403';
$lng['extras']['error500path'] = '500';
$lng['extras']['error401path'] = '401';
$lng['extras']['errordocument404path'] = 'URL para errorDocumento 404';
$lng['extras']['errordocument403path'] = 'URL para errorDocumento 403';
$lng['extras']['errordocument500path'] = 'URL para errorDocumento 500';
$lng['extras']['errordocument401path'] = 'URL para errorDocumento 401';

/**
 * Errors
 */

$lng['error']['error'] = 'Error';
$lng['error']['directorymustexist'] = 'El Directorio %s tiene que Existir. Crearlo por Favor a traves del FTP-Programa.';
$lng['error']['filemustexist'] = 'El archivo %s debe existir';
$lng['error']['allresourcesused'] = 'Usted ha usado todos los recursos a su disposicion.';
$lng['error']['domains_cantdeletemaindomain'] = 'Usted no puede Borar un Domain el cual esta siendo usado como e-mail Domain.';
$lng['error']['domains_canteditdomain'] = 'Usted no puede trabajar con este Domain . Debido a que el Admin se lo niega.';
$lng['error']['domains_cantdeletedomainwithemail'] = 'Usted no puede Borar un Domain el cual esta siendo usado como e-mail Domain , Borre primero todos las Direcciones e-mail de este dominio.';
$lng['error']['firstdeleteallsubdomains'] = 'Usted debe primero borar todos los Subdomains, antes de Usted crear un dominio del comod&Atilde;n.';
$lng['error']['youhavealreadyacatchallforthisdomain'] = 'Usted acaba de definer una Direccion como Catchall para este dominio.';
$lng['error']['ftp_cantdeletemainaccount'] = 'Usted no puede suprimir su cuenta principal del ftp';
$lng['error']['login'] = 'El Nombre de Usuario/Clave esta Errado. Por favor intento otra vez!';
$lng['error']['login_blocked'] = 'Esta cuenta fue cerrada transitoriamente debido a demasiados intentos falsos. <br />Por favor intente otra vez en ' . $settings['login']['deactivatetime'] . ' segundos.';
$lng['error']['notallreqfieldsorerrors'] = 'Usted no ha llenado todos los espacios asignados o ha colocado un dato Erroneo.';
$lng['error']['oldpasswordnotcorrect'] = 'La Clave Vieja no es correcta.';
$lng['error']['youcantallocatemorethanyouhave'] = 'Usted no puede afectar un aparato m&aacute;s recursos que los que usted posee.';
$lng['error']['mustbeurl'] = 'Usted tiene que dar una completa direccion URL(por ejemplo: http://algo.de/error404.htm)';
$lng['error']['invalidpath'] = 'No ha seleccionado una URL v&aacute;lida (&#191;probablemente problemas con el listado de registros?)';
$lng['error']['stringisempty'] = 'Falta un dato';
$lng['error']['stringiswrong'] = 'Dato falso';
$lng['error']['myloginname'] = '\'' . $lng['login']['username'] . '\'';
$lng['error']['mypassword'] = '\'' . $lng['login']['password'] . '\'';
$lng['error']['oldpassword'] = '\'' . $lng['changepassword']['old_password'] . '\'';
$lng['error']['newpassword'] = '\'' . $lng['changepassword']['new_password'] . '\'';
$lng['error']['newpasswordconfirm'] = '\'' . $lng['changepassword']['new_password_confirm'] . '\'';
$lng['error']['newpasswordconfirmerror'] = 'La Clave Nueva a la Confirmacion de Clave no Coinciden';
$lng['error']['myname'] = '\'' . $lng['customer']['name'] . '\'';
$lng['error']['myfirstname'] = '\'' . $lng['customer']['firstname'] . '\'';
$lng['error']['emailadd'] = '\'' . $lng['customer']['email'] . '\'';
$lng['error']['mydomain'] = '\'dominio\'';
$lng['error']['mydocumentroot'] = '\'Documentroot\'';
$lng['error']['loginnameexists'] = 'Conexi&oacute;n-Nombre %s existe ya';
$lng['error']['emailiswrong'] = 'Email address %s contiene caracteres inv&aacute;lidos o es incompleta';
$lng['error']['loginnameiswrong'] = 'Conexi&oacute;n-Nombre %s contiene caracteres inv&aacute;lidos';
$lng['error']['userpathcombinationdupe'] = 'combinaci&oacute;n del nombre del usuario y del camino existe ya';
$lng['error']['patherror'] = '&Acirc;Â¡Error general! el camino no puede estar vac&Atilde;o';
$lng['error']['errordocpathdupe'] = 'Opci&oacute;n para el camino %s existe ya';
$lng['error']['adduserfirst'] = 'Usted debe primero crear un Cliente';
$lng['error']['domainalreadyexists'] = 'El dominio %s se ha asignado ya a un cliente';
$lng['error']['nolanguageselect'] = 'Asigne un Idioma.';
$lng['error']['nosubjectcreate'] = 'Usted debe de asignar un asunto.';
$lng['error']['nomailbodycreate'] = 'Usted debe de Agregar Texto al Mail.';
$lng['error']['templatenotfound'] = 'Modelo no encontrado.';
$lng['error']['alltemplatesdefined'] = 'Usted no puede definir m&aacute;s modelos, todos los lenguajes se utilizan ya.';
$lng['error']['wwwnotallowed'] = 'www no se permite como nombre para los secundario-dominios.';
$lng['error']['subdomainiswrong'] = 'El dominio-secundario %s contiene caracteres inv&aacute;lidos.';
$lng['error']['domaincantbeempty'] = 'El nombre del dominio-Apellido no puede estar Vacio.';
$lng['error']['domainexistalready'] = 'El dominio %s existe ya.';
$lng['error']['domainisaliasorothercustomer'] = 'El alias de dominio seleccionado es un propio alias de dominio o pertenece a otro cliente.';
$lng['error']['emailexistalready'] = 'El email address %s existe ya.';
$lng['error']['maindomainnonexist'] = 'El dominio-principal %s no existe.';
$lng['error']['destinationnonexist'] = 'Crear por favor su email-expedici&oacute;n en \'Destinaci&oacute;n\'.';
$lng['error']['destinationalreadyexistasmail'] = 'La direccion Secundaria %s ya existe como Direccion e-mail activa.';
$lng['error']['destinationalreadyexist'] = 'Ya existe una Direccion Secundaria para %s .';
$lng['error']['destinationiswrong'] = 'La Direccion Secundaria %s contiene simbolos invalidos o esta incompleta.';
$lng['error']['domainname'] = $lng['domains']['domainname'];

/**
 * Questions
 */

$lng['question']['question'] = 'Pregunta de seguridad';
$lng['question']['admin_customer_reallydelete'] = '&#191;Usted realmente desea suprimir el %s del cliente? ATENCI&Ograve;N!todos los datos se perder&aacute;n definitivamente, deber&aacute; borar los datos manualmente del sistema!';
$lng['question']['admin_domain_reallydelete'] = '&#191;Usted realmente desea suprimir el dominio %s?';
$lng['question']['admin_domain_reallydisablesecuritysetting'] = '&#191;Usted realmente desea desactivar estas configuraciones de seguridad (OpenBasedir y/o SafeMode)?';
$lng['question']['admin_admin_reallydelete'] = '&#191;Usted realmente desea suprimir al administrador %s? todos los clientes y dominios ser&aacute;n reasignados al administrador principal.';
$lng['question']['admin_template_reallydelete'] = 'desea usted realmente suprimir el modelo \'%s\'?';
$lng['question']['domains_reallydelete'] = '&#191;desea Usted realmente suprimir el dominio %s?';
$lng['question']['email_reallydelete'] = '&#191;Usted realmente desea suprimir el email address %s?';
$lng['question']['email_reallydelete_account'] = '&#191;Usted realmente desea suprimir la cuenta de email %s?';
$lng['question']['email_reallydelete_forwarder'] = '&#191;Usted realmente desea suprimir el reenv&iacute;o de email %s?';
$lng['question']['extras_reallydelete'] = '&#191;Usted realmente desea suprimir la protecci&oacute;n del directorio %s?';
$lng['question']['extras_reallydelete_pathoptions'] = '&#191;Usted realmente desea suprimir las opciones del camino para el %s?';
$lng['question']['ftp_reallydelete'] = '&#191;Usted realmente desea suprimir la cuenta %s del ftp?';
$lng['question']['mysql_reallydelete'] = '&#191;Usted realmente desea suprimir la base de datos %s?ATENCI&Ograve;N! todos los datos se perder&aacute;n definitivamente';
$lng['question']['admin_configs_reallyrebuild'] = '&#191;Realmente desea elaborar de nuevo sus archivos de configuraci&oacute;n de Apache y Bind? ';

/**
 * Mails
 */

$lng['mails']['pop_success']['mailbody'] = 'Hola,\n\nsu cuenta del correo {EMAIL}\nfue instalada con &eacute;xito .\n\nEsto es un email autom&aacute;ticamente creado,\n\nno conteste por favor!\n\nSinceramente suyo, el SysCP-Equipo';
$lng['mails']['pop_success']['subject'] = 'cuenta del email instalada con &eacute;xito';
$lng['mails']['createcustomer']['mailbody'] = 'Hola {FIRSTNAME} {NAME},\n\naqu&Atilde; est&aacute; su informaci&oacute;n de la cuenta:\n\nNombre del usuario: {USERNAME}\nContrase&ntilde;a: {PASSWORD}\n\nGracias,\nel SysCP-Equipo';
$lng['mails']['createcustomer']['subject'] = 'Informaci&oacute;n de la cuenta';

/**
 * Admin
 */

$lng['admin']['overview'] = 'Descripci&oacute;n';
$lng['admin']['ressourcedetails'] = 'Recursos usados';
$lng['admin']['systemdetails'] = 'Detalles del sistema';
$lng['admin']['syscpdetails'] = 'Detalles de SysCP';
$lng['admin']['installedversion'] = 'Versi&oacute;n instalada';
$lng['admin']['latestversion'] = 'La &uacute;ltima versi&oacute;n';
$lng['admin']['lookfornewversion']['clickhere'] = 'b&uacute;squeda via Web-servicio';
$lng['admin']['lookfornewversion']['error'] = 'Error de lectura';
$lng['admin']['resources'] = 'Recursos';
$lng['admin']['customer'] = 'Cliente';
$lng['admin']['customers'] = 'Clientes';
$lng['admin']['customer_add'] = 'Crear un cliente nuevo';
$lng['admin']['customer_edit'] = 'Corrija a un cliente';
$lng['admin']['domains'] = 'Dominios';
$lng['admin']['domain_add'] = 'Crear el dominio';
$lng['admin']['domain_edit'] = 'Corrija el dominio';
$lng['admin']['subdomainforemail'] = 'dominio-secundario como dominio de email';
$lng['admin']['admin'] = 'Administrador';
$lng['admin']['admins'] = 'Administradores';
$lng['admin']['admin_add'] = 'Crear un admininstrator';
$lng['admin']['admin_edit'] = 'corrija el admininstrator';
$lng['admin']['customers_see_all'] = '&#191;Puede ver a todos los clientes?';
$lng['admin']['domains_see_all'] = '&#191;Puede ver todos los dominios?';
$lng['admin']['change_serversettings'] = '&#191;Puede cambiar configuraciones del servidor?';
$lng['admin']['server'] = 'Servidor';
$lng['admin']['serversettings'] = 'Configuraciones';
$lng['admin']['rebuildconf'] = 'Reescribir las configuraciones';
$lng['admin']['stdsubdomain'] = 'dominio-secundario est&aacute;ndar';
$lng['admin']['stdsubdomain_add'] = 'Crear el subdomain est&aacute;ndar';
$lng['admin']['deactivated'] = 'Desactivado';
$lng['admin']['deactivated_user'] = 'Desactive a utilizador';
$lng['admin']['sendpassword'] = 'Env&Atilde;e la contrase&ntilde;a';
$lng['admin']['ownvhostsettings'] = 'vHost-Configuraciones propias';
$lng['admin']['configfiles']['serverconfiguration'] = 'Configuraci&oacute;n';
$lng['admin']['configfiles']['files'] = '<b>Configfiles:</b> Cambie por favor los ficheros siguientes<br />o cr&eacute;elos con el contenido siguiente si no existen.<br /><b>Por favor note:</b> La MySQL-contrase&ntilde;a  no se ha substituido por razones de seguridad.<br />Substituya por favor &quot;MYSQL_PASSWORD&quot;manualmente por la propia. Si usted se olvid&oacute; de su MySQL-contrase&ntilde;a<br />usted la encontrar&aacute; en el &quot;lib/userdata.inc.php&quot;.';
$lng['admin']['configfiles']['commands'] = '<b>Commands:</b> Ejecute por favor los comandos siguientes en un shell.';
$lng['admin']['configfiles']['restart'] = '<b>Relanzar:</b> Ejecute por favor los comandos siguientes en un shell para recargar la nueva configuraci&oacute;n.';
$lng['admin']['templates']['templates'] = 'Modelos';
$lng['admin']['templates']['template_add'] = 'Agregue el modelo';
$lng['admin']['templates']['template_edit'] = 'Corrija el modelo';
$lng['admin']['templates']['action'] = 'Acci&oacute;n';
$lng['admin']['templates']['email'] = 'E-Mail';
$lng['admin']['templates']['subject'] = 'asunto';
$lng['admin']['templates']['mailbody'] = 'email-texto';
$lng['admin']['templates']['createcustomer'] = 'email de Bienvenida para los nuevos clientes';
$lng['admin']['templates']['pop_success'] = 'email de Bienvenida para las nuevas cuentas del email';
$lng['admin']['templates']['template_replace_vars'] = 'Variables que se substituir&aacute;n en el modelo:';
$lng['admin']['templates']['FIRSTNAME'] = 'Substituido por el nombre de los clientes.';
$lng['admin']['templates']['NAME'] = 'Substituido por el Apellido de los clientes.';
$lng['admin']['templates']['USERNAME'] = 'Substituido por el username de la cuenta de clientes.';
$lng['admin']['templates']['PASSWORD'] = 'Substituido por la contrase&ntilde;a de la cuenta de clientes.';
$lng['admin']['templates']['EMAIL'] = 'Substituido por la direccion de la cuenta de POP3/del IMAP.';

/**
 * Serversettings
 */

$lng['serversettings']['session_timeout']['title'] = 'Descanso de la sesi&oacute;n';
$lng['serversettings']['session_timeout']['description'] = '&#191;Cuanto tiempo un utilizador tiene que estar inactivo antes de que una sesi&oacute;n consiga quedar inv&aacute;lida (segundos)?';
$lng['serversettings']['accountprefix']['title'] = 'Cliente-prefijo';
$lng['serversettings']['accountprefix']['description'] = '&#191;Qu&eacute; prefijo deben las cuentas de cliente tener??';
$lng['serversettings']['mysqlprefix']['title'] = 'Prefijo del SQL';
$lng['serversettings']['mysqlprefix']['description'] = '&#191;Qu&eacute; prefijo deben tener las cuentas del mysql?';
$lng['serversettings']['ftpprefix']['title'] = 'Prefijo del ftp';
$lng['serversettings']['ftpprefix']['description'] = 'Qu&eacute; prefijo deben tener las cuentas del ftp?';
$lng['serversettings']['documentroot_prefix']['title'] = 'Directorio de documento';
$lng['serversettings']['documentroot_prefix']['description'] = '&#191;D&oacute;nde deben quedar todos los clientes?';
$lng['serversettings']['logfiles_directory']['title'] = 'Directorio de los ficheros de diario';
$lng['serversettings']['logfiles_directory']['description'] = '&#191;D&oacute;nde deben todos los ficheros de diario ser salvados?';
$lng['serversettings']['ipaddress']['title'] = 'IP address';
$lng['serversettings']['ipaddress']['description'] = '&#191;Cu&aacute;l es el IP address de este servidor?';
$lng['serversettings']['hostname']['title'] = 'Hostname';
$lng['serversettings']['hostname']['description'] = '&#191;Cu&aacute;l es el hostname de este servidor?';
$lng['serversettings']['apachereload_command']['title'] = 'Comando de la recarga de Apache';
$lng['serversettings']['apachereload_command']['description'] = '&#191;Cu&aacute;l es el comando de la recarga de Apache?';
$lng['serversettings']['bindconf_directory']['title'] = 'Directorio de la configuraci&oacute;n de Bind';
$lng['serversettings']['bindconf_directory']['description'] = '&#191;D&oacute;nde est&aacute; la configuraci&oacute;n del Bind?';
$lng['serversettings']['bindreload_command']['title'] = 'Comando de la recarga de Bindmm';
$lng['serversettings']['bindreload_command']['description'] = '&#191;Cu&aacute;l es el comando de la recarga de Bind?';
$lng['serversettings']['binddefaultzone']['title'] = 'Zona del valor por defecto de Bind';
$lng['serversettings']['binddefaultzone']['description'] = '&#191;Cu&aacute;l es el nombre de la zona del valor por defecto?';
$lng['serversettings']['vmail_uid']['title'] = 'eMail-Uid';
$lng['serversettings']['vmail_uid']['description'] = '&#191;Qu&eacute; UserID deben tener los email?';
$lng['serversettings']['vmail_gid']['title'] = 'eMail-Gid';
$lng['serversettings']['vmail_gid']['description'] = '&#191;Qu&eacute; identificaci&oacute;n del grupo deben tener los email?';
$lng['serversettings']['vmail_homedir']['title'] = 'Hogar-directorio de los email';
$lng['serversettings']['vmail_homedir']['description'] = '&#191;D&oacute;nde deben quedar todos los email?';
$lng['serversettings']['adminmail']['title'] = 'Remitente';
$lng['serversettings']['adminmail']['description'] = '&#191;Qu&eacute; remitente-tratan para los email se env&Atilde;a del panel?';
$lng['serversettings']['phpmyadmin_url']['title'] = 'phpMyAdmin URL';
$lng['serversettings']['phpmyadmin_url']['description'] = '&#191;Cu&aacute;l es el URL al phpMyAdmin? (tienen que comenzar con http://)';
$lng['serversettings']['webmail_url']['title'] = 'WebMail URL';
$lng['serversettings']['webmail_url']['description'] = '&#191;Cu&aacute;l es el URL a WebMail? (tienen que comenzar con http://)';
$lng['serversettings']['webftp_url']['title'] = 'WebFTP URL';
$lng['serversettings']['webftp_url']['description'] = '&#191;Cu&aacute;l es el URL a WebFTP?? (tienen que comenzar con http://)';
$lng['serversettings']['language']['description'] = 'Cu&aacute;l es su lenguaje est&aacute;ndar del servidor?';
$lng['serversettings']['maxloginattempts']['title'] = 'Tentativas m&aacute;ximas de registro';
$lng['serversettings']['maxloginattempts']['description'] = 'Las tentativas m&aacute;ximas de registro despu&eacute;s de lo cual la cuenta se desactiva.';
$lng['serversettings']['deactivatetime']['title'] = 'tiempo de la desactivaci&oacute;n';
$lng['serversettings']['deactivatetime']['description'] = 'tiempo (en segundos) para el cual la cuenta est&aacute; desactivada.';
$lng['serversettings']['pathedit']['title'] = 'M&eacute;todo de introducci&oacute;n de datos del trayecto ';
$lng['serversettings']['pathedit']['description'] = 'Prefiere seleccionar un trayecto a trav&eacute;s de un men&uacute;-dropdown o introducirlo manualmente.';

/**
 * ADDED BETWEEN 1.2.12 and 1.2.13
 */

$lng['admin']['cronlastrun'] = '&Uacute;ltimo Cron';
$lng['serversettings']['paging']['title'] = 'Entradas por p&aacute;gina';
$lng['serversettings']['paging']['description'] = '&iquest;Cuantas entradas deben ser mostradas en una p&aacute;gina? (0=desactivar paginaci&oacute;n)';
$lng['error']['ipstillhasdomains'] = 'La combinaci&oacute;n IP/Puerto que Usted quiere eliminar todav&iacute;a tiene dominios asignados, por favor vuelva a reasignar estas combinaciones IP/Puerto antes de eliminar esta combinaci&oacute;n IP/Puerto.';
$lng['error']['cantdeletedefaultip'] = 'Usted no puede eliminar la combinaci&oacute;n IP/Puerto del distribuidor predeterminada, por favor crea otra combinaci&oacute;n IP/Puerto predeterminada para distribuidores antes de eliminar esta combinaci&oacute;n IP/Puerto.';
$lng['error']['cantdeletesystemip'] = 'No puede eliminar la IP del sistema, crea una nueva combinaci&oacute;n IP/Puerto para el sistema IP o cambia the sistema IP.';
$lng['error']['myipaddress'] = '\'IP\'';
$lng['error']['myport'] = '\'Port\'';
$lng['error']['myipdefault'] = 'Debe seleccionar una combinaci&oacute;n IP/Puerto que se convierta de manera predeterminado.';
$lng['error']['myipnotdouble'] = 'Esta combinaci&oacute;n IP/Puerto ya existe.';
$lng['question']['admin_ip_reallydelete'] = '&iquest;Realmente quiere eliminar esta direcci&oacute;n IP %s?';
$lng['admin']['ipsandports']['ipsandports'] = 'IPs y Puertos';
$lng['admin']['ipsandports']['add'] = 'A&ntilde;adir IP/Puerto';
$lng['admin']['ipsandports']['edit'] = 'Editar IP/Puerto';
$lng['admin']['ipsandports']['ipandport'] = 'IP/Puerto';
$lng['admin']['ipsandports']['ip'] = 'IP';
$lng['admin']['ipsandports']['port'] = 'Puerto';

// ADDED IN 1.2.13-rc3

$lng['error']['cantchangesystemip'] = 'No puede cambiar el &uacute;ltimo IP de sistema, cree una nueva combinaci&oacute;n de IP/Puerto para la IP de sistema o cambie la IP de sistema.';
$lng['question']['admin_domain_reallydocrootoutofcustomerroot'] = '&iquest;Est&aacute; seguro de que quiere la ra&iacute;z de documento para este dominio, ya que no se encuentra dentro de la ra&iacute;z cliente del cliente?';

// ADDED IN 1.2.14-rc1

$lng['admin']['memorylimitdisabled'] = 'Desactivado';
$lng['error']['loginnameissystemaccount'] = 'No puede crear cuentas parecidas a cuentas de sistema. Por favor, introduzca otro nombre de cuenta.';
$lng['domain']['docroot'] = 'Path del campo de arriba';
$lng['domain']['homedir'] = 'Hogar-directorio';
$lng['admin']['valuemandatory'] = 'Este valor es obligatorio';
$lng['admin']['valuemandatorycompany'] = 'Hay que rellenar &oacute; &quot;apellido&quot; y &quot;nombre&quot; &oacute; &quot;empresa&quot;';
$lng['panel']['pathorurl'] = 'Path &oacute; URL';
$lng['error']['sessiontimeoutiswrong'] = 'S&oacute;lo est&aacute;n permitidos &quot;descansos de la sesi&oacute;n&quot; numéricos';
$lng['error']['maxloginattemptsiswrong'] = 'S&oacute;lo est&aacute;n permitidos &quot;intentos m&aacute;ximas de registro&quot; numéricos';
$lng['error']['deactivatetimiswrong'] = 'S&oacute;lo est&aacute; permitido un &quot;tiempo de desactivaci&oacute;n&quot; numérico';
$lng['error']['accountprefixiswrong'] = 'El prefijo de cliente est&aacute; mal.';
$lng['error']['mysqlprefixiswrong'] = 'El prefijo del SQL est&aacute; mal.';
$lng['error']['ftpprefixiswrong'] = 'El prefijo del FTP est&aacute; mal.';
$lng['error']['ipiswrong'] = 'La direcci&oacute;n IP est&aacute; mal. S&oacute;lo se permiten direcciones IP v&aacute;lidas.';
$lng['error']['vmailuidiswrong'] = 'El eMail-Uid est&aacute; mal. S&oacute;lo se permiten UIDs numéricos.';
$lng['error']['vmailgidiswrong'] = 'El eMail-Gid est&aacute; mal. S&oacute;lo se permiten GIDs numéricos.';
$lng['error']['adminmailiswrong'] = 'La direcci&oacute;n del remitente est&aacute; mal. S&oacute;lo se permiten direcciones de correo electr&oacute;nico v&aacute;lidas.';
$lng['error']['pagingiswrong'] = 'Las entradas por p&aacute;gina est&aacute;n mal. S&oacute;lo se permiten caracteres numéricos.';
$lng['error']['phpmyadminiswrong'] = 'La URL de phpMyAdmin no es una URL v&aacute;lida.';
$lng['error']['webmailiswrong'] = 'La URL de WebMail no es una URL v&aacute;lida.';
$lng['error']['webftpiswrong'] = 'La URL de WebFTP no es una URL v&aacute;lida.';

// ADDED IN 1.2.15-rc1

$lng['admin']['serversoftware'] = 'Software del servidor';
$lng['admin']['phpversion'] = 'Versi&oacute;n PHP';
$lng['admin']['phpmemorylimit'] = 'Limite memoria PHP';
$lng['admin']['mysqlserverversion'] = 'Versi&oacute;n servidor MySQL';
$lng['admin']['mysqlclientversion'] = 'Versi&oacute;n cliente MySQL';
$lng['admin']['webserverinterface'] = 'Interface servidor de red';
$lng['menue']['extras']['extras'] = 'Extras';
$lng['extras']['pathoptions_edit'] = 'editar opciones de ruta/directorio';
$lng['domain']['openbasedirpath'] = 'Directorio OpenBasedir';
$lng['menue']['main']['username'] = 'Ingreso como: ';
$lng['serversettings']['defaultip']['title'] = 'IP/Puerto por defecto';
$lng['serversettings']['defaultip']['description'] = '&#191;Cu&aacute;l es la combinaci&oacute;n de IP y Puerto por defecto?';
$lng['domains']['statstics'] = 'Estadisticas de uso';
$lng['panel']['ascending'] = 'ascendiente';
$lng['panel']['decending'] = 'descendiente';
$lng['panel']['search'] = 'Buscar';
$lng['panel']['used'] = 'usado';
$lng['panel']['translator'] = 'Traductor';
$lng['error']['stringformaterror'] = 'El valor para la fila &quot;%s&quot; no esta dentro de los formatos esperados.';

?>