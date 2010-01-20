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
 * @author     Tim Zielosko <mail@zielosko.net>
 * @author     Romain MARIADASSOU <roms2000@free.fr>
 * @license    GPLv2 http://files.syscp.org/misc/COPYING.txt
 * @package    Language
 * @version    $Id: french.lng.php 2692 2009-03-27 18:04:47Z flo $
 */

/**
 * Begin
 */

$lng['install']['language'] = 'Langue d\'installation';
$lng['install']['welcome'] = 'Bienvenue à l\'installation de SysCP';
$lng['install']['welcometext'] = 'Merci beaucoup d\'avoir choisi SysCP. Pour installer SysCP remplissez les cases ci-dessous avec les informations demandées.<br /><b>Attention :</b> Si vous entrez le nom d\'une base de données existante, celle-ci sera effacée !';
$lng['install']['database'] = 'Base de données';
$lng['install']['mysql_hostname'] = 'Nom d\'hôte du serveur MySQL';
$lng['install']['mysql_database'] = 'Base de données MySQL';
$lng['install']['mysql_unpriv_user'] = 'Utilisateur pour l\'accès non privilégié à MySQL';
$lng['install']['mysql_unpriv_pass'] = 'Mot de passe pour l\'accès non privilégié à MySQL';
$lng['install']['mysql_root_user'] = 'Utilisateur pour l\'accès root à MySQL';
$lng['install']['mysql_root_pass'] = 'Mot de passe pour l\'accès root à MySQL';
$lng['install']['admin_account'] = 'Accès administratif';
$lng['install']['admin_user'] = 'Login de l\'administrateur';
$lng['install']['admin_pass'] = 'Mot de passe de l\'administrateur';
$lng['install']['admin_pass_confirm'] = 'Mot de passe de l\'administrateur (confirmation)';
$lng['install']['serversettings'] = 'Configuration du serveur';
$lng['install']['servername'] = 'Nom du serveur (FQDN)';
$lng['install']['serverip'] = 'Adresse IP du serveur';
$lng['install']['apacheversion'] = 'Version du serveur Apache';
$lng['install']['next'] = 'Continuer';

/**
 * Progress
 */

$lng['install']['testing_mysql'] = 'Vérification du login root de MySQL ...';
$lng['install']['erasing_old_db'] = 'Effacement de l\'ancienne base de données ...';
$lng['install']['create_mysqluser_and_db'] = 'Création de la base de données puis des utilisateurs ...';
$lng['install']['testing_new_db'] = 'Vérification de la base de données et des utilisateurs ...';
$lng['install']['importing_data'] = 'Importation des informations dans la base de données ...';
$lng['install']['changing_data'] = 'Modification des données importés ...';
$lng['install']['adding_admin_user'] = 'Ajout de l\'utilisateur administrateur ...';
$lng['install']['creating_configfile'] = 'Création du fichier de configuration ...';
$lng['install']['creating_configfile_succ'] = 'OK, userdata.inc.php a été sauvegardé dans le dossier lib/ de SysCP.';
$lng['install']['creating_configfile_temp'] = 'Le fichier a été sauvegardé dans /tmp/userdata.inc.php, veuillez le déplacer / copier dans le dossier lib/ de SysCP.';
$lng['install']['creating_configfile_failed'] = 'Erreur en créant le fichier lib/userdata.inc.php, veuillez le créer avec le contenu ci-dessous :';
$lng['install']['syscp_succ_installed'] = 'SysCP a été installé correctement.';
$lng['install']['click_here_to_login'] = 'Cliquez ici pour vous rendre à l\'invite de connexion.';
$lng['install']['httpuser'] = 'Nom du utilisateur du HTTP';
$lng['install']['httpgroup'] = 'Nom du la group du HTTP';

/**
 * Renamed in 1.2.19-svn40
 */

$lng['install']['webserver'] = 'Version du serveur';

?>
