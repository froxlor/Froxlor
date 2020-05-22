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
$lng['requirements']['title'] = 'Vérification des prérequis système...';
$lng['requirements']['installed'] = 'installé';
$lng['requirements']['not_true'] = 'non';
$lng['requirements']['notfound'] = 'introuvable';
$lng['requirements']['notinstalled'] = 'non installé';
$lng['requirements']['activated'] = 'activé';
$lng['requirements']['phpversion'] = 'PHP version >= 7.0';
$lng['requirements']['phppdo'] = 'extension PHP PDO et pilote PDO-MySQL ...';
$lng['requirements']['phpxml'] = 'extension PHP XML...';
$lng['requirements']['phpfilter'] = 'extension PHP filter ...';
$lng['requirements']['phpposix'] = 'extension PHP posix ...';
$lng['requirements']['phpbcmath'] = 'extension PHP bcmath ...';
$lng['requirements']['phpcurl'] = 'extension PHP curl...';
$lng['requirements']['phpmbstring'] = 'extension PHP mbstring...';
$lng['requirements']['bcmathdescription'] = 'Les fonctions de calcul de traffic ne fonctionneront pas correctement!';
$lng['requirements']['openbasedir'] = 'open_basedir...';
$lng['requirements']['openbasedirenabled'] = 'Froxlor ne fonctionnera pas correctement avec open_basedir activé. Merci de désactiver open_basedir pour Froxlor dans le php.ini correspondant';
$lng['requirements']['diedbecauseofrequirements'] = 'Impossible d\'installer Froxlor sans ces prérequis! Essayez de les corriger et essayez à nouveau.';
$lng['requirements']['froxlor_succ_checks'] = 'Tous les prérequis sont vérifiés';

$lng['install']['lngtitle'] = 'Installation de Froxlor - choisisez la langue';
$lng['install']['language'] = 'Langue d\'installation';
$lng['install']['lngbtn_go'] = 'Changer la langue';
$lng['install']['title'] = 'Installation de Froxlor - paramètrage';
$lng['install']['welcometext'] = 'Merci d\'avoir choisi Froxlor. Merci de remplir les champs suivant avec les informations nécessaires pour démarrer l\'installation.<br /><b>Attention:</b> Si la base de données que vous choisissez existe déjà sur votre système, elle sera écrasée ainsi que les données contenues!';
$lng['install']['database'] = 'Connexion à la base de données';
$lng['install']['mysql_host'] = 'Nom d\'hôte MySQL';
$lng['install']['mysql_database'] = 'Nom de la base de données';
$lng['install']['mysql_unpriv_user'] = 'Nom d\'utilisateur pour le compte non priviligié MySQL';
$lng['install']['mysql_unpriv_pass'] = 'Mot de passe pour le compte non priviligié MySQL';
$lng['install']['mysql_root_user'] = 'Nom d\'utilisateur pour le compte MySQL root';
$lng['install']['mysql_root_pass'] = 'Mot de passe pour le compte MySQL root';
$lng['install']['admin_account'] = 'Compte administrateur';
$lng['install']['admin_user'] = 'Nom d\'utilisateur administrateur';
$lng['install']['admin_pass1'] = 'Mot de passe administrateur';
$lng['install']['admin_pass2'] = 'Mot de passe administrateur (confirmez)';
$lng['install']['serversettings'] = 'Réglages serveur';
$lng['install']['servername'] = 'Nom du serveur (FQDN, pas d\'adresse IP)';
$lng['install']['serverip'] = 'Adresse IP du serveur';
$lng['install']['webserver'] = 'Serveur Web';
$lng['install']['apache2'] = 'Apache 2';
$lng['install']['apache24'] = 'Apache 2.4';
$lng['install']['lighttpd'] = 'LigHTTPd';
$lng['install']['nginx'] = 'NGINX';
$lng['install']['httpuser'] = 'Nom d\'utilisateur HTTP';
$lng['install']['httpgroup'] = 'Nom de groupe HTTP';

$lng['install']['testing_mysql'] = 'Vérification de l\'accès root MySQL...';
$lng['install']['testing_mysql_fail'] = 'Il semble y avoir un problème avec la connexion à la base de données. Impossible de continuer. Merci de revenir en arrière et de vérifier les informations d\'identification.';
$lng['install']['backup_old_db'] = 'Création des sauvegardes de l\'ancienne base de données...';
$lng['install']['backup_binary_missing'] = 'Impossible de trouver mysqldump';
$lng['install']['backup_failed'] = 'Impossible de sauvegarde la base de données';
$lng['install']['prepare_db'] = 'Préparation de la base de données...';
$lng['install']['create_mysqluser_and_db'] = 'Création de la base de données et l\'utilisateur...';
$lng['install']['testing_new_db'] = 'Teste si la base de données et l\'utilisateur ont été créés correctement...';
$lng['install']['importing_data'] = 'Import des données...';
$lng['install']['changing_data'] = 'Ajustement des paramètres...';
$lng['install']['creating_entries'] = 'Insertion des nouvelles valeurs...';
$lng['install']['adding_admin_user'] = 'Création du compte administrateur...';
$lng['install']['creating_configfile'] = 'Création du fichier de configuration...';
$lng['install']['creating_configfile_temp'] = 'Le fichier a été enregistré dans %s, merci de le déplacer dans ' . dirname(dirname(__DIR__)) . '/lib/userdata.inc.php';
$lng['install']['creating_configfile_failed'] = 'Impossible de créer ' . dirname(dirname(__DIR__)) . '/lib/userdata.inc.php, merci de le créer manuellement avec le contenu suivant:';
$lng['install']['froxlor_succ_installed'] = 'Froxlor a été installé avec succès.';

$lng['click_here_to_refresh'] = 'Cliquez ici pour vérifier à nouveau';
$lng['click_here_to_goback'] = 'Cliquez ici pour revenir';
$lng['click_here_to_continue'] = 'Cliquez ici pour continuer';
$lng['click_here_to_login'] = 'Cliquez ici pour vous connecter.';
