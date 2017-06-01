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
 * @author     Florian Lippert <flo@syscp.org> (2003-2009)
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Language
 *
 */

$lng['requirements']['title'] = 'Comprobando requisitos del sistema...';
$lng['requirements']['installed'] = 'instalado';
$lng['requirements']['not_true'] = 'no';
$lng['requirements']['notfound'] = 'no encontrado';
$lng['requirements']['notinstalled'] = 'no instalado';
$lng['requirements']['activated'] = 'habilitado';
$lng['requirements']['phpversion'] = 'Version PHP >= 5.3';
$lng['requirements']['newerphpprefered'] = 'Está bien, pero es preferible php-5.6.';
$lng['requirements']['phpmagic_quotes_runtime'] = 'magic_quotes_runtime...';
$lng['requirements']['phpmagic_quotes_runtime_description'] = 'La configuración PHP "magic_quotes_runtime" debe establecerse en "Off". La hemos deshabilitado temporalmente. Por ahora, por favor, corrija el php.ini correspondiente.';
$lng['requirements']['phppdo'] = 'Extensión de PHP PDO y Controlador PDO-MySQL...';
$lng['requirements']['phpxml'] = 'Extensión de PHP XML...';
$lng['requirements']['phpfilter'] = 'Extensión PHP filter...';
$lng['requirements']['phpposix'] = 'Extensión PHP posix...';
$lng['requirements']['phpbcmath'] = 'Extensión PHP bcmathn...';
$lng['requirements']['phpcurl'] = 'Extensión PHP curl...';
$lng['requirements']['phpmbstring'] = 'Extensión PHP mbstring...';
$lng['requirements']['phpzip'] = 'Extensión PHP zip...';
$lng['requirements']['bcmathdescription'] = '¡Las funciones relacionadas con el cálculo de tráfico no funcionarán correctamente!';
$lng['requirements']['zipdescription'] = 'La actualización automática requiere una extensión zip.';
$lng['requirements']['openbasedir'] = 'open_basedir...';
$lng['requirements']['openbasedirenabled'] = 'Froxlor no funcionará correctamente con open_basedir habilitado. Por favor, deshabilite open_basedir para Froxlor en el php.ini correspondiente';
$lng['requirements']['diedbecauseofrequirements'] = '¡No se puede instalar Froxlor sin estos requisitos! Pruebe a solucionar esto e inténtelo de nuevo.';
$lng['requirements']['froxlor_succ_checks'] = 'Se han cumplido todos los requisitos';

$lng['install']['lngtitle'] = 'Instalación de Froxlor - Escoja un idioma';
$lng['install']['language'] = 'Idioma de la instalación';
$lng['install']['lngbtn_go'] = 'Cambiar idioma';
$lng['install']['title'] = 'Instalación de Froxlor - Configuración';
$lng['install']['welcometext'] = 'Gracias por escoger Froxlor. Por favor, rellene los siguientes campos con la información requerida para comenzar la instalación.<br /><b>Atención:</b> Si la base de datos que ha elegido para Froxlor ya existe en su Sistema, ¡será eliminada junto con todo su contenido!';
$lng['install']['database'] = 'Conexión con la Base de Datos';
$lng['install']['mysql_host'] = 'Nombre del Servidor MySQL';
$lng['install']['mysql_database'] = 'Nombre de la Base de Datos';
$lng['install']['mysql_unpriv_user'] = 'Usuario para la cuenta MySQL sin privilegios';
$lng['install']['mysql_unpriv_pass'] = 'Contraseña para la cuenta MySQL sin privilegios';
$lng['install']['mysql_root_user'] = 'Usuario para la cuenta Raíz MySQL (root de MySQL)';
$lng['install']['mysql_root_pass'] = 'Contraseña para la cuenta Raíz MySQL (root de MySQL)';
$lng['install']['admin_account'] = 'Cuenta del Administrador';
$lng['install']['admin_user'] = 'Nombre de Usuario del Administrador';
$lng['install']['admin_pass1'] = 'Contraseña del Administrador';
$lng['install']['admin_pass2'] = 'Confirme la Contraseña del Administrador';
$lng['install']['activate_newsfeed'] = 'Habilite el Canal Oficial de Noticias (En Inglés)<br><small>(https://inside.froxlor.org/news/)</small>';
$lng['install']['serversettings'] = 'Configuración del Servidor';
$lng['install']['servername'] = 'Nombre del Servidor (FQDN, no la dirección IP)';
$lng['install']['serverip'] = 'IP del Servidor';
$lng['install']['webserver'] = 'Servidor Web';
$lng['install']['apache2'] = 'Apache 2';
$lng['install']['apache24'] = 'Apache 2.4';
$lng['install']['lighttpd'] = 'LigHTTPd';
$lng['install']['nginx'] = 'NGINX';
$lng['install']['httpuser'] = 'Nombre de Usuario HTTP';
$lng['install']['httpgroup'] = 'Nombre del Grupo HTTP';

$lng['install']['testing_mysql'] = 'Comprobando el acceso a la cuenta Raíz MySQL...';
$lng['install']['testing_mysql_fail'] = 'Parece que ha ocurrido un problema en la conexión con la Base de Datos. No se puede continuar. Por favor, vuelva atrás y compruebe sus credenciales.';
$lng['install']['backup_old_db'] = 'Creando copia de seguridad de la antigua Base de Datos...';
$lng['install']['backup_binary_missing'] = 'No se puede encontrar mysqldump';
$lng['install']['backup_failed'] = 'No se puede crear una copia de seguridad de la Base de Datos';
$lng['install']['prepare_db'] = 'Preparando Base de Datos...';
$lng['install']['create_mysqluser_and_db'] = 'Creando Usuario y Base de Datos...';
$lng['install']['testing_new_db'] = 'Comprobando si la Base de Datos y el Usuario han sido creados correctamente...';
$lng['install']['importing_data'] = 'Importando Datos...';
$lng['install']['changing_data'] = 'Aplicando Configuraciones...';
$lng['install']['creating_entries'] = 'Insertando Nuevos Valores...';
$lng['install']['adding_admin_user'] = 'Creando la Cuenta de Administrador...';
$lng['install']['creating_configfile'] = 'Creando Archivo de Configuración (configfile)...';
$lng['install']['creating_configfile_temp'] = 'El Archivo fue guardado en /tmp/userdata.inc.php, por favor, muévalo a lib/.';
$lng['install']['creating_configfile_failed'] = 'No se puede crear lib/userdata.inc.php, por favor créalo manualmente con el siguiente contenido:';
$lng['install']['froxlor_succ_installed'] = '¡Froxlor Se Ha Instalado Satisfactoriamente!.';

$lng['click_here_to_refresh'] = 'Pulse aquí para comprobarlo de nuevo';
$lng['click_here_to_goback'] = 'Pulse aquí para volver atrás';
$lng['click_here_to_continue'] = 'Pulse aquí para continuar';
$lng['click_here_to_login'] = 'Pulse aquí para ingresar.';
