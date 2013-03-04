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
 * @author     Tim Zielosko <tim.zielosko@syscp.de>
 * @author     Aldo Reset <aldo.reset@placenet.org>
 * @author     Romain MARIADASSOU <roms2000@free.fr>
 * @author     Froxlor Team <team@froxlor.org>
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Language
 *
 */

/**
 * Some importants rules of typograhie in french :
 * These signs << ! ? : " & >> must be be preceded by white space
 *   ->  We can make the white space like that : << &nbsp; >>
 *   ->  so the white space is still committed to the previous letter and punctuation mark as follows.
 * These signs << . ; , ' >> should be glued to the previous letter
 * These signs << / | = >> would be preceded and followed with a white as mush as possible, it is much clear from reading.
 */

/**
 * Global
 */

$lng['translator'] = 'Tim Zielosko, Aldo Reset, Romain MARIADASSOU';
$lng['panel']['edit'] = 'Modifier';
$lng['panel']['delete'] = 'Supprimer';
$lng['panel']['create'] = 'Ajouter';
$lng['panel']['save'] = 'Sauvegarder';
$lng['panel']['yes'] = 'Oui';
$lng['panel']['no'] = 'Non';
$lng['panel']['emptyfornochanges'] = 'Laissez vide pour ne pas modifier';
$lng['panel']['emptyfordefault'] = 'Laissez vide pour l\'option standard';
$lng['panel']['path'] = 'Dossier';
$lng['panel']['toggle'] = 'Activer / Désactiver';
$lng['panel']['next'] = 'continuer';
$lng['panel']['dirsmissing'] = 'Dossiers non disponibles ou illisibles';

/**
 * Login
 */

$lng['login']['username'] = 'Identifiant';
$lng['login']['password'] = 'Mot de passe';
$lng['login']['language'] = 'Langue';
$lng['login']['login'] = 'Se connecter';
$lng['login']['logout'] = 'Se déconnecter';
$lng['login']['profile_lng'] = 'Langue du profil';

/**
 * Customer
 */

$lng['customer']['documentroot'] = 'Chemin';
$lng['customer']['name'] = 'Nom';
$lng['customer']['firstname'] = 'Prénom';
$lng['customer']['company'] = 'Entreprise';
$lng['customer']['street'] = 'Rue';
$lng['customer']['zipcode'] = 'Code postal';
$lng['customer']['city'] = 'Ville';
$lng['customer']['phone'] = 'Téléphone';
$lng['customer']['fax'] = 'Fax';
$lng['customer']['email'] = 'E-mail';
$lng['customer']['customernumber'] = 'Numéro du client';
$lng['customer']['diskspace'] = 'Espace Web (Mo)';
$lng['customer']['traffic'] = 'Trafic (Go)';
$lng['customer']['mysqls'] = 'Base(s) de données MySQL';
$lng['customer']['emails'] = 'Adresse(s) e-mail';
$lng['customer']['accounts'] = 'Accès e-mail';
$lng['customer']['forwarders'] = 'Transfert(s) e-mail';
$lng['customer']['ftps'] = 'Accès FTP';
$lng['customer']['subdomains'] = 'Sous-domaine(s)';
$lng['customer']['domains'] = 'Domaine(s)';
$lng['customer']['unlimited'] = 'illimité';

/**
 * Customermenue
 */

$lng['menue']['main']['main'] = 'Général';
$lng['menue']['main']['changepassword'] = 'Changer de mot de passe';
$lng['menue']['main']['changelanguage'] = 'Changer de langue';
$lng['menue']['email']['email'] = 'E-mail';
$lng['menue']['email']['emails'] = 'Adresse(s) e-mail(s)';
$lng['menue']['email']['webmail'] = 'Webmail';
$lng['menue']['mysql']['mysql'] = 'MySQL';
$lng['menue']['mysql']['databases'] = 'Bases de données';
$lng['menue']['mysql']['phpmyadmin'] = 'phpMyAdmin';
$lng['menue']['domains']['domains'] = 'Domaines';
$lng['menue']['domains']['settings'] = 'Paramétres des sites';
$lng['menue']['ftp']['ftp'] = 'FTP';
$lng['menue']['ftp']['accounts'] = 'Comptes d\'accès FTP';
$lng['menue']['ftp']['webftp'] = 'WebFTP';
$lng['menue']['extras']['extras'] = 'Extras';
$lng['menue']['extras']['directoryprotection'] = 'Protection des dossiers';
$lng['menue']['extras']['pathoptions'] = 'Options des dossiers';

/**
 * Index
 */

$lng['index']['customerdetails'] = 'Informations personnelles';
$lng['index']['accountdetails'] = 'Informations du compte';

/**
 * Change Password
 */

$lng['changepassword']['old_password'] = 'Ancien mot de passe';
$lng['changepassword']['new_password'] = 'Nouveau mot de passe';
$lng['changepassword']['new_password_confirm'] = 'Nouveau mot de passe (confirmation)';
$lng['changepassword']['new_password_ifnotempty'] = 'Nouveau mot de passe (Veuillez laisser vide pour ne pas changer)';
$lng['changepassword']['also_change_ftp'] = 'Changer aussi le mot de passe du compte FTP principal ?';

/**
 * Domains
 */

$lng['domains']['description'] = 'Ici, vous pouvez ajouter des sites et domaines et changer leurs doosiers.<br />Il vous faudra patienter quelques minutes après chaque changement pour que la configuration soit activée.';
$lng['domains']['domainsettings'] = 'Configuration des Domaines';
$lng['domains']['domainname'] = 'Nom du Domaine';
$lng['domains']['subdomain_add'] = 'Ajouter un sous-domaine';
$lng['domains']['subdomain_edit'] = 'Changer un sous-domaine';
$lng['domains']['wildcarddomain'] = 'Domaine générique (Wilcard) ?';
$lng['domains']['aliasdomain'] = 'Alias pour le domaine';
$lng['domains']['noaliasdomain'] = 'Domaine sans alias';

/**
 * E-mails
 */

$lng['emails']['description'] = 'Ici, vous pouvez ajouter vos boîtes e-mails.<br /><br />Les informations pour configurer votre logiciel e-mail sont les suivantes : <br /><br />Nom du serveur : <b><i>votre-domaine.com</i></b><br />Identifiant : <b><i>l\'adresse e-mail</i></b><br />Mot de passe : <b><i>le mot de passe que vous avez choisi</i></b>';
$lng['emails']['emailaddress'] = 'Adresse';
$lng['emails']['emails_add'] = 'Ajouter une adresse e-mail';
$lng['emails']['emails_edit'] = 'Changer une adresse e-mail';
$lng['emails']['catchall'] = 'Catchall';
$lng['emails']['iscatchall'] = 'Définir comme adresse "catchall" ?';
$lng['emails']['account'] = 'Accès';
$lng['emails']['account_add'] = 'Ajouter un accès';
$lng['emails']['account_delete'] = 'Supprimer l\'accès';
$lng['emails']['from'] = 'de';
$lng['emails']['to'] = 'à';
$lng['emails']['forwarders'] = 'Réexpédition';
$lng['emails']['forwarder_add'] = 'Ajouter un renvoi';

/**
 * FTP
 */

$lng['ftp']['description'] = 'Ici, vous pouvez ajouter des accès FTP supplémentaires.<br />Les changements, ainsi que l\'accès, sont immédiatement opérationnels.';
$lng['ftp']['account_add'] = 'Ajouter un accès';

/**
 * MySQL
 */

$lng['mysql']['databasename'] = 'Nom de la base de données';
$lng['mysql']['databasedescription'] = 'Description de la base de données';
$lng['mysql']['database_create'] = 'Ajouter une base de données';

/**
 * Extras
 */

$lng['extras']['description'] = 'Ici, vous pouvez ajouter des extras, comme par exemple, la protection de dossiers du site.<br />Il vous faudra patienter quelques minutes après chaque changement pour que la configuration soit activée.';
$lng['extras']['directoryprotection_add'] = 'Ajouter une protection de dossier';
$lng['extras']['view_directory'] = 'Aperçu du dossier';
$lng['extras']['pathoptions_add'] = 'Ajouter des options sur le dossier';
$lng['extras']['directory_browsing'] = 'Afficher le contenu des dossiers';
$lng['extras']['pathoptions_edit'] = 'Modifier les options de dossier';
$lng['extras']['error404path'] = '404';
$lng['extras']['error403path'] = '403';
$lng['extras']['error500path'] = '500';
$lng['extras']['error401path'] = '401';
$lng['extras']['errordocument404path'] = 'Emplacement du document "Erreur 404"';
$lng['extras']['errordocument403path'] = 'Emplacement du document "Erreur 403"';
$lng['extras']['errordocument500path'] = 'Emplacement du document "Erreur 500"';
$lng['extras']['errordocument401path'] = 'Emplacement du document "Erreur 401"';

/**
 * Errors
 */

$lng['error']['error'] = 'Erreur';
$lng['error']['directorymustexist'] = 'Le dossier que vous avez choisi n\'existe pas. Veuillez ajouter le dossier avec votre client FTP.';
$lng['error']['filemustexist'] = 'Le fichier que vous avez sélectionné n\'existe pas.';
$lng['error']['allresourcesused'] = 'Vous avez déjà utilisé toutes les ressources.';
$lng['error']['domains_cantdeletemaindomain'] = 'Vous ne pouvez pas supprimer un domaine qui est utilisé pour des adresses e-mails.';
$lng['error']['domains_canteditdomain'] = 'Vous n\'avez pas le droit de configurer ce domaine.';
$lng['error']['domains_cantdeletedomainwithemail'] = 'Vous ne pouvez pas supprimer un domaine qui est utilisé pour des e-mails. Vous devez d\'abord supprimer toutes les adresses e-mails qu\'il contient.';
$lng['error']['firstdeleteallsubdomains'] = 'Il faut d\'abord supprimer tous les sous-domaines avant d\'ajouter un domaine "wildcard".';
$lng['error']['youhavealreadyacatchallforthisdomain'] = 'Vous avez déjà défini une adresse "catchall" pour ce domaine.';
$lng['error']['ftp_cantdeletemainaccount'] = 'Vous ne pouvez pas supprimer votre accès principal.';
$lng['error']['login'] = 'Identifiant / mot de passe invalide.';
$lng['error']['login_blocked'] = 'Cet identifiant a été bloqué à cause de nombreuses tentatives de connexions invalides.<br />Veuillez réessayer dans ' . $settings['login']['deactivatetime'] . ' secondes.';
$lng['error']['notallreqfieldsorerrors'] = 'Vous n\'avez pas rempli toutes les cases obligatoires ou vous les avez remplis avec des informations invalides.';
$lng['error']['oldpasswordnotcorrect'] = 'L\'ancien mot de passe n\'est pas correct.';
$lng['error']['youcantallocatemorethanyouhave'] = 'Vous ne pouvez pas distribuer plus de ressources qu\'il n\'en reste.';
$lng['error']['mustbeurl'] = 'Vous n\'avez pas entré une adresse URL valide.';
$lng['error']['invalidpath'] = 'Vous n\'avez pas choisi une adresse URL valide (probablement à cause de problèmes avec le listing de dossiers ?)';
$lng['error']['stringisempty'] = 'Entrée manquante';
$lng['error']['stringiswrong'] = 'Entrée invalide';
$lng['error']['myloginname'] = '"' . $lng['login']['username'] . '"';
$lng['error']['mypassword'] = '"' . $lng['login']['password'] . '"';
$lng['error']['oldpassword'] = '"' . $lng['changepassword']['old_password'] . '"';
$lng['error']['newpassword'] = '"' . $lng['changepassword']['new_password'] . '"';
$lng['error']['newpasswordconfirm'] = '"' . $lng['changepassword']['new_password_confirm'] . '"';
$lng['error']['newpasswordconfirmerror'] = 'Le nouveau mot de passe et sa confirmation ne sont pas identiques pas.';
$lng['error']['myname'] = '"' . $lng['customer']['name'] . '"';
$lng['error']['myfirstname'] = '"' . $lng['customer']['firstname'] . '"';
$lng['error']['emailadd'] = '"' . $lng['customer']['email'] . '"';
$lng['error']['mydomain'] = '"domaine"';
$lng['error']['mydocumentroot'] = '"Documentroot"';
$lng['error']['loginnameexists'] = 'L\'identifiant "%s" existe déjà.';
$lng['error']['emailiswrong'] = 'L\'adresse "%s" contient des signes invalides ou est incomplète.';
$lng['error']['loginnameiswrong'] = 'L\'identifiant "%s" contient des signes invalides.';
$lng['error']['userpathcombinationdupe'] = 'Cette combinaison d\'identifiant et de dossier existe déjà.';
$lng['error']['patherror'] = 'Erreur générale ! Le dossier ne doit pas être vide.';
$lng['error']['errordocpathdupe'] = 'Il y a déjà une option concernant le dossier "%s".';
$lng['error']['adduserfirst'] = 'Vous devez d\'abord ajouter un.';
$lng['error']['domainalreadyexists'] = 'Le domaine "%s" existe déjà.';
$lng['error']['nolanguageselect'] = 'Aucune langue choisis.';
$lng['error']['nosubjectcreate'] = 'Il faut entrer un sujet.';
$lng['error']['nomailbodycreate'] = 'Il faut entrer un corps de texte.';
$lng['error']['templatenotfound'] = 'Aucun modèle trouvé.';
$lng['error']['alltemplatesdefined'] = 'Vous avez déjà appliqué des modèles pour toutes les langues.';
$lng['error']['wwwnotallowed'] = 'Un sous-domaine ne peut pas s\'appeler www.';
$lng['error']['subdomainiswrong'] = 'Le sous-domaine "%s" contient des signes invalides.';
$lng['error']['domaincantbeempty'] = 'Le nom de domaine ne doit pas être vide.';
$lng['error']['domainexistalready'] = 'Le domaine "%s" existe déjà.';
$lng['error']['domainisaliasorothercustomer'] = 'L\'alias du domaine choisi est soit un alias existant d\'un autre client ou soit fait référence à lui même.';
$lng['error']['emailexistalready'] = 'L\'adresse "%s" existe déjà.';
$lng['error']['maindomainnonexist'] = 'Le domaine "%s" n\'existe pas.';
$lng['error']['destinationnonexist'] = 'Veuillez écrire votre adresse de renvoi à l\'emplacement "à".';
$lng['error']['destinationalreadyexistasmail'] = 'Le renvoi vers l\'adresse "%s" existe déjà comme adresse active.';
$lng['error']['destinationalreadyexist'] = 'Il existe déjà une réexpédition vers l\'adresse "%s".';
$lng['error']['destinationiswrong'] = 'L\'adresse "%s" contient des signes invalides ou est incomplète.';
$lng['error']['domainname'] = $lng['domains']['domainname'];
$lng['error']['loginnameissystemaccount'] = 'Vous ne pouvez pas créer un compte identique au compte système, veuillez réessayer avec un autre nom.';

/**
 * Questions
 */

$lng['question']['question'] = 'Question de sécurité';
$lng['question']['admin_customer_reallydelete'] = 'Etes-vous sûr de vouloir supprimer le compte "%s" ?<br />ATTENTION ! Toutes ses informations seront supprimées ! Une fois fait, il vous appartiendra de supprimer manuellement tous les dossiers du compte sur le système de fichiers.';
$lng['question']['admin_domain_reallydelete'] = 'Etes-vous sûr de vouloir supprimer le domaine "%s" ?';
$lng['question']['admin_domain_reallydisablesecuritysetting'] = 'Etes-vous sûr de vouloir désactiver les modes de sécurité suivants : OpenBasedir et / oû SafeMode ?';
$lng['question']['admin_admin_reallydelete'] = 'Etes-vous sûr de vouloir supprimer l\'administrateur "%s" ?<br />Tous ses comptes seront affectés à l\'administrateur principal.';
$lng['question']['admin_template_reallydelete'] = 'Etes-vous sûr de vouloir supprimer le modèle "%s" ?';
$lng['question']['domains_reallydelete'] = 'Etes-vous sûr de vouloir supprimer le domaine "%s" ?';
$lng['question']['email_reallydelete'] = 'Etes-vous sûr de vouloir supprimer l\'adresse e-mail "%s" ? ';
$lng['question']['email_reallydelete_account'] = 'Etes-vous sûr de vouloir supprimer l\'accès e-mail "%s" ?';
$lng['question']['email_reallydelete_forwarder'] = 'Etes-vous sûr de vouloir supprimer le renvoi vers "%s" ?';
$lng['question']['extras_reallydelete'] = 'Etes-vous sûr de vouloir supprimer la protection du dossier "%s" ?';
$lng['question']['extras_reallydelete_pathoptions'] = 'Etes-vous sûr de vouloir supprimer les options du dossier "%s" ?';
$lng['question']['ftp_reallydelete'] = 'Etes-vous sûr de vouloir supprimer l\'accès ftp "%s" ?';
$lng['question']['mysql_reallydelete'] = 'Etes-vous sûr de vouloir supprimer la base de données "%s" ?<br />ATTENTION : Toutes les données seront perdues à jamais !';
$lng['question']['admin_configs_reallyrebuild'] = 'Etes-vous sûr de vouloir régénérer les fichiers de configuration Apache et Bind ?';

/**
 * Mails
 */

$lng['mails']['pop_success']['mailbody'] = 'Bonjour,\n\nvotre accès POP3 / IMAP {EMAIL}\na été créé avec succès.\n\nCeci est un e-mail généré automatiquement, veuillez ne pas répondre à ce message.\n\nCordialement,\nL\'équipe Froxlor\nhttp://www.froxlor.org';
$lng['mails']['pop_success']['subject'] = 'Accès POP3 / IMAP créé';
$lng['mails']['createcustomer']['mailbody'] = 'Bonjour {FIRSTNAME} {NAME},\n\nVous trouverez ci-dessous vos informations d\'accès au panel d\'administration :\n\nAdresse d\'administration : http://demo.froxlor.org\n\nIdentifiant : {USERNAME}\nMot de passe : {PASSWORD}\n\nCordialement,\nL\'équipe Froxlor\nhttp://www.froxlor.org\n';
$lng['mails']['createcustomer']['subject'] = 'Froxlor : Informations pour votre accès au panel d\'administration';

/**
 * Admin
 */

$lng['admin']['overview'] = 'Sommaire';
$lng['admin']['ressourcedetails'] = 'Ressources utilisées';
$lng['admin']['systemdetails'] = 'Informations du système';
$lng['admin']['froxlordetails'] = 'Informations de Froxlor';
$lng['admin']['installedversion'] = 'Version installée';
$lng['admin']['latestversion'] = 'Dernière version en date';
$lng['admin']['lookfornewversion']['clickhere'] = 'Vérifier par internet';
$lng['admin']['lookfornewversion']['error'] = 'Erreur pour vérifier la dernière version';
$lng['admin']['resources'] = 'Ressources';
$lng['admin']['customer'] = 'Compte';
$lng['admin']['customers'] = 'Comptes';
$lng['admin']['customer_add'] = 'Ajouter un compte';
$lng['admin']['customer_edit'] = 'Modifier un compte';
$lng['admin']['domains'] = 'Domaines';
$lng['admin']['domain_add'] = 'Ajouter un domaine';
$lng['admin']['domain_edit'] = 'Modifier le domaine';
$lng['admin']['subdomainforemail'] = 'Sous-domaines comme domaine e-mail';
$lng['admin']['admin'] = 'Administrateur';
$lng['admin']['admins'] = 'Administrateurs';
$lng['admin']['admin_add'] = 'Ajouter un administrateur';
$lng['admin']['admin_edit'] = 'Modifier un administrateur';
$lng['admin']['customers_see_all'] = 'Peut voir tous les comptes ?';
$lng['admin']['domains_see_all'] = 'Peut voir tous les Domaines ?';
$lng['admin']['change_serversettings'] = 'Peut modifier la configuration du serveur ?';
$lng['admin']['server'] = 'Serveur';
$lng['admin']['serversettings'] = 'Paramètres';
$lng['admin']['rebuildconf'] = 'Régénérer la configuration';
$lng['admin']['stdsubdomain'] = 'Sous-domaine type';
$lng['admin']['stdsubdomain_add'] = 'Ajouter un sous-domaine type';
$lng['admin']['phpenabled'] = 'PHP activé';
$lng['admin']['deactivated'] = 'Désactiver';
$lng['admin']['deactivated_user'] = 'Désactiver l\'utilisateur';
$lng['admin']['sendpassword'] = 'Envoyer le mot de passe';
$lng['admin']['ownvhostsettings'] = 'Configuration spéciale du vHost';
$lng['admin']['configfiles']['serverconfiguration'] = 'Exemple de configuration';
$lng['admin']['configfiles']['files'] = '<b>Fichiers de configuration :</b> Veuillez créer ou modifier les fichiers suivants avec le contenu ci-dessous.<br /><br /><b>IMPORTANT :</b> Le mot de passe MySQL n\'est pas donné dans les informations ci-dessous<br />pour des raisons de sécurité. Veuillez donc remplacer les "<b>MYSQL_PASSWORD</b>"<br />manuellement avec le mot de passe correspondant. En cas d\'oubli, vous pouvez le retrouver dans<br />le fichier "<b>lib/userdata.inc.php</b>".';
$lng['admin']['configfiles']['commands'] = '<b>Commandes :</b> Veuillez exécuter les commandes ci-dessous dans le shell.';
$lng['admin']['configfiles']['restart'] = '<b>Redémarrage :</b> Veuillez exécuter les commandes ci-dessous pour<br />prendre en compte les changements.';
$lng['admin']['templates']['templates'] = 'Modèles';
$lng['admin']['templates']['template_add'] = 'Ajouter un modèle';
$lng['admin']['templates']['template_edit'] = 'Modifier un modèle';
$lng['admin']['templates']['action'] = 'Action';
$lng['admin']['templates']['email'] = 'E-mail';
$lng['admin']['templates']['subject'] = 'Référence';
$lng['admin']['templates']['mailbody'] = 'Texte de l\'e-mail';
$lng['admin']['templates']['createcustomer'] = 'E-mail de bienvenue pour les nouveaux clients';
$lng['admin']['templates']['pop_success'] = 'E-mail de bienvenue pour les nouveaux accès e-mail';
$lng['admin']['templates']['template_replace_vars'] = 'Les variables qui seront remplacées dans le template :';
$lng['admin']['templates']['FIRSTNAME'] = 'Sera remplacé par le prénom.';
$lng['admin']['templates']['NAME'] = 'Sera remplacé par le nom.';
$lng['admin']['templates']['USERNAME'] = 'Sera remplacé par le login.';
$lng['admin']['templates']['PASSWORD'] = 'Sera remplacé par le mot de passe du client.';
$lng['admin']['templates']['EMAIL'] = 'Sera remplacé par l\'accès e-mail.';

/**
 * Serversettings
 */

$lng['serversettings']['session_timeout']['title'] = 'Durée d\'inactivité maximale';
$lng['serversettings']['session_timeout']['description'] = 'Combien de secondes d\'inactivité avant qu\'une session ne se ferme ?';
$lng['serversettings']['accountprefix']['title'] = 'Préfix des comptes';
$lng['serversettings']['accountprefix']['description'] = 'Quel préfix doivent avoir les comptes ?';
$lng['serversettings']['mysqlprefix']['title'] = 'Préfix SQL';
$lng['serversettings']['mysqlprefix']['description'] = 'Quel préfix doivent avoir les bases de données ?';
$lng['serversettings']['ftpprefix']['title'] = 'Préfix FTP';
$lng['serversettings']['ftpprefix']['description'] = 'Quel préfix doivent avoir les accès FTP ?';
$lng['serversettings']['documentroot_prefix']['title'] = 'Dossier de stockage';
$lng['serversettings']['documentroot_prefix']['description'] = 'Oû doivent être stockés tous les dossiers et fichiers des différents comptes ?';
$lng['serversettings']['logfiles_directory']['title'] = 'Dossier des fichiers de log';
$lng['serversettings']['logfiles_directory']['description'] = 'Oû doivent être stockés les archives des logs d\'accès du serveur Web ?';
$lng['serversettings']['ipaddress']['title'] = 'Adresse IP';
$lng['serversettings']['ipaddress']['description'] = 'Quelle est l\'adresse IP du serveur ?';
$lng['serversettings']['hostname']['title'] = 'Nom d\'hôte';
$lng['serversettings']['hostname']['description'] = 'Quel est le nom d\'hôte (hostname) du serveur ?';
$lng['serversettings']['apachereload_command']['title'] = 'Commande de rechargement d\'Apache';
$lng['serversettings']['apachereload_command']['description'] = 'Quelle est la commande pour recharger / redémarrer Apache ?';
$lng['serversettings']['bindconf_directory']['title'] = 'Emplacement du dossier de configuration de Bind / Named';
$lng['serversettings']['bindconf_directory']['description'] = 'Oû doit être stocké la configuration de Bind / Named ?';
$lng['serversettings']['bindreload_command']['title'] = 'Commande de rechargement de Bind / Named';
$lng['serversettings']['bindreload_command']['description'] = 'Quelle est la commande pour recharger / redémarrer Bind / Named ?';
$lng['serversettings']['binddefaultzone']['title'] = 'Nom du fichier de zone par défaut Bind / Named';
$lng['serversettings']['binddefaultzone']['description'] = 'Quel est le nom du fichier de zone par défaut pour Bind / Named ?';
$lng['serversettings']['vmail_uid']['title'] = 'UID des e-mails';
$lng['serversettings']['vmail_uid']['description'] = 'Quel UID doivent avoir les e-mails ?';
$lng['serversettings']['vmail_gid']['title'] = 'GID des e-mails';
$lng['serversettings']['vmail_gid']['description'] = 'Quel GID doivent avoir les e-mails ?';
$lng['serversettings']['vmail_homedir']['title'] = 'Emplacement des e-mails';
$lng['serversettings']['vmail_homedir']['description'] = 'Dans quel dossier doivent être stocker les e-mails ?';
$lng['serversettings']['adminmail']['title'] = 'Adresse e-mail de l\'administrateur';
$lng['serversettings']['adminmail']['description'] = 'Quelle est l\'adresse e-mail par défaut des e-mails envoyés par Froxlor ?';
$lng['serversettings']['phpmyadmin_url']['title'] = 'Adresse URL de phpMyAdmin';
$lng['serversettings']['phpmyadmin_url']['description'] = 'A quelle adresse se trouve phpMyAdmin ?';
$lng['serversettings']['webmail_url']['title'] = 'Adresse URL du WebMail';
$lng['serversettings']['webmail_url']['description'] = 'A quelle adresse se trouve le WebMail ?';
$lng['serversettings']['webftp_url']['title'] = 'Adresse URL du WebFTP';
$lng['serversettings']['webftp_url']['description'] = 'A quelle adresse se trouve le WebFTP ?';
$lng['serversettings']['language']['description'] = 'Quelle langue est la langue par défaut ?';
$lng['serversettings']['maxloginattempts']['title'] = 'Nombre d\'essais maximum avant désactivation';
$lng['serversettings']['maxloginattempts']['description'] = 'Nombre de tentatives maximum avant la désactivation de l\'accès.';
$lng['serversettings']['deactivatetime']['title'] = 'Durée de la désactivation';
$lng['serversettings']['deactivatetime']['description'] = 'Durée (en secondes) pendant laquelle l\'accès sera désactivé.';
$lng['serversettings']['pathedit']['title'] = 'Mode de sélection des dossiers';
$lng['serversettings']['pathedit']['description'] = 'Choisir un dossier par une liste déroulante ou l\'entrer manuellement ?';
$lng['serversettings']['nameservers']['title'] = 'Serveurs de nom «Nameservers»';
$lng['serversettings']['nameservers']['description'] = 'Une liste séparée par des virgules contenant les noms d\'hôtes de tous les serveurs de noms. Le premier dans la liste sera le serveur primaire.';
$lng['serversettings']['mxservers']['title'] = 'Serveurs de messagerie «MX»';
$lng['serversettings']['mxservers']['description'] = 'Une liste séparée par des virgules contenant les serveurs de messagerie avec leur poid : un nombre et le nom d\'hôte séparé par un espace; par exemple : "10 mx.exemple.com".';

/**
 * CHANGED BETWEEN 1.2.12 and 1.2.13
 */

$lng['mysql']['description'] = 'Ici, vous pouvez ajouter et effacer des bases de données MySQL.<br />Les changements, ainsi que les bases de données, sont immédiatement opérationnels.<br />Dans le menu, vous trouverez un lien vers phpMyAdmin, avec lequel vous pouvez gérer vos bases de données.<br /><br />L\'accès aux bases de données depuis les scripts PHP fonctionne comme suit : (Il faut remplacer les valeurs en <i><b>italique</b></i> par vos informations !)<br /><br />$connexion = mysql_connect(\'localhost\', \'<i><b>Votre identifiant</b></i>\', \'<i><b>Votre mot de passe</b></i>\');<br />mysql_select_db(\'<i><b>Le nom de la base de données</b></i>\', $connexion);';

/**
 * ADDED BETWEEN 1.2.12 and 1.2.13
 */

$lng['serversettings']['paging']['title'] = 'Nombre de résultats par page';
$lng['serversettings']['paging']['description'] = 'Nombre de résultats par page ? (0 = Désactive la pagination)';
$lng['error']['ipstillhasdomains'] = 'La combinaison IP / port est encore utilisée, veuillez réassigner le ou les domaines existant(s) avec cette adresse IP / port concerné(s) à une autre combinaison IP / port avant de supprimer celle-ci.';
$lng['error']['cantdeletedefaultip'] = 'Vous ne pouvez pas supprimer cette combinaison IP / Port, veuillez d\'abord attribuer une autre combinaison IP / Port par défaut à ce revendeur avant de supprimer celle-ci.';
$lng['error']['cantdeletesystemip'] = 'Vous ne pouvez pas créer, modifier ou supprimer l\'IP du système.';
$lng['error']['myipaddress'] = '"IP"';
$lng['error']['myport'] = '"Port"';
$lng['error']['myipdefault'] = 'Choissez une combinaison IP / port par défaut.';
$lng['error']['myipnotdouble'] = 'Cette combinaison existe déjà';
$lng['question']['admin_ip_reallydelete'] = 'Etes-vous sûr de vouloir supprimer l\'adresse IP "%s" ?';
$lng['admin']['ipsandports']['ipsandports'] = 'IPs et ports';
$lng['admin']['ipsandports']['add'] = 'Ajouter une IP / port';
$lng['admin']['ipsandports']['edit'] = 'Modifier une IP / port';
$lng['admin']['ipsandports']['ipandport'] = 'IP / Port';
$lng['admin']['ipsandports']['ip'] = 'IP';
$lng['admin']['ipsandports']['port'] = 'Port';

// ADDED IN 1.2.13-rc3

$lng['error']['cantchangesystemip'] = 'Vous ne pouvez pas modifier l\'adresse IP du système, ni en ajouter de nouvelle.';
$lng['question']['admin_domain_reallydocrootoutofcustomerroot'] = 'Etes-vous sûr de vouloir différencier la racine principale de ce domaine de la racine principale du client ?';

// ADDED IN 1.2.14-rc1

$lng['admin']['memorylimitdisabled'] = 'Désactivé';
$lng['domain']['openbasedirpath'] = 'Dossier "OpenBasedir"';
$lng['domain']['docroot'] = 'Identique au dossier ci-dessus';
$lng['domain']['homedir'] = 'Dossier Principal';
$lng['admin']['valuemandatory'] = 'Cette valeur est obligatoire';
$lng['admin']['valuemandatorycompany'] = 'Vous devez indiquer au moins l\'une des 3 valeurs suivantes : "nom" ou "prénom" ou "entreprise"';
$lng['menue']['main']['username'] = 'Utilisateur : ';
$lng['panel']['urloverridespath'] = 'URL (supplante la valeur dossier)';
$lng['panel']['pathorurl'] = 'Dossier ou URL';
$lng['error']['sessiontimeoutiswrong'] = 'Seule une valeur numérique pour le temps d\'inactivité est autorisée.';
$lng['error']['maxloginattemptsiswrong'] = 'Seule une valeur numérique pour "nombre maximum de tentative de connexion" est autorisée.';
$lng['error']['deactivatetimiswrong'] = 'Seule une valeur numérique pour la durée de désactivation est autorisée.';
$lng['error']['accountprefixiswrong'] = 'Le "Préfixe client" n\'est pas valide.';
$lng['error']['mysqlprefixiswrong'] = 'Le "Préfixe SQL" n\'est pas valide.';
$lng['error']['ftpprefixiswrong'] = 'Le "Préfixe FTP" n\'est pas valide.';
$lng['error']['ipiswrong'] = 'L\'"Adresse IP" n\'est pas valide.';
$lng['error']['vmailuidiswrong'] = 'L\'"UID e-mail" est incorrect. Seul un UID numérique est autorisé.';
$lng['error']['vmailgidiswrong'] = 'Le "GID e-mail" est incorrect. Seul un GID numérique est autorisé.';
$lng['error']['adminmailiswrong'] = 'L\'adresse e-mail de l\'administrateur est incorrect. Seulement une adresse e-mail valide est autorisé.';
$lng['error']['pagingiswrong'] = 'La valeur "Nombre de résultats page" est incorrecte. Seul une valeur numérique est autorisée.';
$lng['error']['phpmyadminiswrong'] = 'Le lien pour phpMyAdmin n\'est pas valide.';
$lng['error']['webmailiswrong'] = 'Le lien pour le WebMail n\'est pas valide.';
$lng['error']['webftpiswrong'] = 'Le lien pour le WebFTP n\'est pas valide.';
$lng['domains']['hasaliasdomains'] = 'Le domaine possède un ou des alias.';
$lng['serversettings']['defaultip']['title'] = 'IP / Port par défaut';
$lng['serversettings']['defaultip']['description'] = 'Quel est l\'IP / Port par défaut ?';
$lng['domains']['statstics'] = 'Fréquentation';
$lng['panel']['ascending'] = 'ascendant';
$lng['panel']['decending'] = 'descendant';
$lng['panel']['search'] = 'Rechercher';
$lng['panel']['used'] = 'utilisé';

// ADDED IN 1.2.14-rc3

$lng['panel']['translator'] = 'Traducteur(s)';

// ADDED IN 1.2.14-rc4

$lng['error']['stringformaterror'] = 'La valeur pour "%s" n\'est pas dans un format reconnu.';

// ADDED IN 1.2.15-rc1

$lng['admin']['serversoftware'] = 'Logiciel Serveur';
$lng['admin']['phpversion'] = 'Version de PHP';
$lng['admin']['phpmemorylimit'] = 'Limite mémoire de PHP';
$lng['admin']['mysqlserverversion'] = 'Version du serveur MySQL';
$lng['admin']['mysqlclientversion'] = 'Version du client MySQL';
$lng['admin']['webserverinterface'] = 'Interface Web';
$lng['domains']['isassigneddomain'] = 'Le domaine est attribué';
$lng['serversettings']['phpappendopenbasedir']['title'] = 'Dossier(s) de l\'OpenBasedir';
$lng['serversettings']['phpappendopenbasedir']['description'] = 'Liste de dossiers séparée par des virgules qui sera ajouté à la variable "OpenBasedir" des conteneurs vHosts.';

// CHANGED IN 1.2.15-rc1

$lng['error']['loginnameissystemaccount'] = 'Vous ne pouvez pas créer de compte ressemblant aux comptes système (ex : "%s"). Veuillez entrer un autre nom de compte.';
$lng['error']['youcantdeleteyourself'] = 'Vous ne pouvez pas supprimer votre propre compte pour des raisons évidente de sécurité ...';
$lng['error']['youcanteditallfieldsofyourself'] = 'Note : Vous ne pouvez pas éditer tous les champs de votre propre compte pour des raisons de sécurité.';

// ADDED IN 1.2.16-svn1

$lng['serversettings']['natsorting']['title'] = 'Utiliser un tri naturel dans les différentes vues';
$lng['serversettings']['natsorting']['description'] = 'Trier les listes comme web1 -> web2 -> etc ... -> web11 au lieu de web1 -> web11 -> web2.';

// ADDED IN 1.2.16-svn2

$lng['serversettings']['deactivateddocroot']['title'] = 'Dossier "DocumentRoot" pour les utilisateurs désactivés';
$lng['serversettings']['deactivateddocroot']['description'] = 'Quand un utilisateur est désactivé, ce dossier sera utilisé comme dossier racine pour le serveur Web. Laissez vide pour ne pas créer de vHost et ne rien afficher du tout lorsque l\'utilisateur est désactivé.';

// ADDED IN 1.2.16-svn4

$lng['panel']['reset'] = 'Ignorer les changements';
$lng['admin']['accountsettings'] = 'Paramètres du compte';
$lng['admin']['panelsettings'] = 'Paramètres du panel';
$lng['admin']['systemsettings'] = 'Paramètres du système';
$lng['admin']['webserversettings'] = 'Paramètres du serveur Web';
$lng['admin']['mailserversettings'] = 'Paramètres du serveur de Mail';
$lng['admin']['nameserversettings'] = 'Paramètres du serveur de Noms';
$lng['admin']['updatecounters'] = 'Recalculer les ressources utilisées';
$lng['question']['admin_counters_reallyupdate'] = 'Etes-vous sûr de vouloir recalculer les ressources utilisées ?';
$lng['panel']['pathDescription'] = 'Si le dossier n\'existe pas, il sera créé automatiquement.';

// ADDED IN 1.2.16-svn6

$lng['mails']['trafficninetypercent']['mailbody'] = 'Bonjour {FIRSTNAME} {NAME},\n\nVous utilisez {TRAFFICUSED} Mo sur {TRAFFIC} Mo de votre quota de trafic.\nCe dernier est à plus de 90%.\n\nCordialement,\nL\'équipe Froxlor.';
$lng['mails']['trafficninetypercent']['subject'] = 'Limite de trafic bientôt atteinte.';
$lng['admin']['templates']['trafficninetypercent'] = 'E-mail de notification pour les utilisateurs, lorsque leur taux de trafic atteint plus de 90%.';
$lng['admin']['templates']['TRAFFIC'] = 'Sera remplacé par le taux de trafic qui a été attribué à l\'utilisateur.';
$lng['admin']['templates']['TRAFFICUSED'] = 'Sera remplacé par le taux de trafic qui a été consommé par l\'utilisateur.';

// ADDED IN 1.2.16-svn7

$lng['admin']['subcanemaildomain']['never'] = 'Jamais';
$lng['admin']['subcanemaildomain']['choosableno'] = 'A choisir, par défaut : non';
$lng['admin']['subcanemaildomain']['choosableyes'] = 'A choisir, par défaut : oui';
$lng['admin']['subcanemaildomain']['always'] = 'Toujours';
$lng['changepassword']['also_change_webalizer'] = 'Changer aussi le mot de passe des statistiques Webalizer ?';

// ADDED IN 1.2.16-svn8

$lng['serversettings']['mailpwcleartext']['title'] = 'Sauvegarder aussi les mots de passe des comptes e-mails de façon décrypter dans la base de données';
$lng['serversettings']['mailpwcleartext']['description'] = 'Si cela est à Oui, tous les mots de passe seront aussi sauvegarder de façon décrypter dans la table mail_users (en texte clair pour toutes personnes qui auraient accès à la base de données). Activer cette option, uniquement si vous en avez vraiment besoin !';
$lng['serversettings']['mailpwcleartext']['removelink'] = 'Cliquez ici pour retirer tous les mots de passe en texte clair de la base de données.';
$lng['question']['admin_cleartextmailpws_reallywipe'] = 'Etes-vous sûr de vouloir retirer tous les mots de passe en clairs des comptes e-mails de la table mail_users ? Cette action ne peut être annulée !';
$lng['admin']['configfiles']['overview'] = 'Aperçu';
$lng['admin']['configfiles']['wizard'] = 'Assistant';
$lng['admin']['configfiles']['distribution'] = 'Distribution';
$lng['admin']['configfiles']['service'] = 'Service';
$lng['admin']['configfiles']['daemon'] = 'Démon';
$lng['admin']['configfiles']['http'] = 'Serveur Web (HTTP)';
$lng['admin']['configfiles']['dns'] = 'Serveur de Noms (DNS)';
$lng['admin']['configfiles']['mail'] = 'Serveur de Mails (IMAP/POP3)';
$lng['admin']['configfiles']['smtp'] = 'Serveur de Mails (SMTP)';
$lng['admin']['configfiles']['ftp'] = 'Serveur FTP';
$lng['admin']['configfiles']['etc'] = 'Autres (Système)';
$lng['admin']['configfiles']['choosedistribution'] = '-- Choisissez une distribution --';
$lng['admin']['configfiles']['chooseservice'] = '-- Choisissez un service --';
$lng['admin']['configfiles']['choosedaemon'] = '-- Choisissez un démon --';

// ADDED IN 1.2.16-svn10

$lng['serversettings']['ftpdomain']['title'] = 'Comptes FTP @domaine';
$lng['serversettings']['ftpdomain']['description'] = 'Les utilisateurs peuvent-ils créer des comptes FTP de la forme utilisateur@domaine.com ?';
$lng['panel']['back'] = 'Retour';

// ADDED IN 1.2.16-svn12

$lng['serversettings']['mod_log_sql']['title'] = 'Sauvegarder temporairement les logs dans la base de données';
$lng['serversettings']['mod_log_sql']['description'] = 'Utiliser <a href="http://www.outoforder.cc/projects/apache/mod_log_sql/" title="mod_log_sql">mod_log_sql</a> pour sauvegarder temporairement les requètes Web.<br /><b>Cela à besoin d\'une configuration spécifique <a href="http://files.froxlor.org/docs/mod_log_sql/" title="mod_log_sql - documentation">d\'Apache</a> !</b>';
$lng['serversettings']['mod_fcgid']['title'] = 'Utiliser PHP par mod_fcgid / suexec';
$lng['serversettings']['mod_fcgid']['description'] = 'Utiliser mod_fcgid / suexec / libnss_mysql pour lancer PHP avec le compte correspondant à l\'utilisateur ?<br/><b>Cela à besoin d\'une configuration spécifique d\'Apache !</b>';
$lng['serversettings']['sendalternativemail']['title'] = 'Utiliser une adresse e-mail alternative';
$lng['serversettings']['sendalternativemail']['description'] = 'Envoyer le mot de passe du compte e-mail à une adresse différents pour la création du compte e-mail ?';
$lng['emails']['alternative_emailaddress'] = 'Adresse e-mail alternative';
$lng['mails']['pop_success_alternative']['mailbody'] = 'Bonjour,\n\nVotre compte e-mail {EMAIL} a été correctement créé.\n\nVotre mot de passe est : {PASSWORD}.\n\nCeci est un message généré automatiquemenent, veuillez ne pas répondre à cet e-mail car il ne serait être consulter.\n\nCordialement,\nL\'équipe Froxlor.';
$lng['mails']['pop_success_alternative']['subject'] = 'Compte e-mail correctement créé';
$lng['admin']['templates']['pop_success_alternative'] = 'Message de bienvenue envoyé à l\'adresse e-mail alternative pour les nouveaux comptes e-mails';
$lng['admin']['templates']['EMAIL_PASSWORD'] = 'Remplacer par le mot de passe du compte POP3 / IMAP.';

// ADDED IN 1.2.16-svn13

$lng['error']['documentrootexists'] = 'Le dossier "%s" existe déjà pour cet utilisateur. Veuillez le supprimer / déplacer avant de réessayer l\'ajout de cet utilisateur.';

// ADDED IN 1.2.16-svn14

$lng['serversettings']['apacheconf_vhost']['title'] = 'Dossier / fichier de configuration des vHosts pour Apache';
$lng['serversettings']['apacheconf_vhost']['description'] = 'Oû doit être stocké le fichier de configuration des vHosts ? Vous pouvez soit entrer le nom d\'un fichier (tous les vHosts dans un seul fichier), soit le nom d\'un dossier (chacun des vHosts dans un fichier séparé du dossier).';
$lng['serversettings']['apacheconf_diroptions']['title'] = 'Fichier / dossier de configuration des options des dossiers pour Apache';
$lng['serversettings']['apacheconf_diroptions']['description'] = 'Oû doit être stocké le fichier de configuration des options de dossiers ? Vous pouvez soit entrer le nom d\'un fichier (toutes les options des dossiers dans un seul fichier), soit le nom d\'un dossier (chacune des options de dossier dans un fichier séparé du dossier).';
$lng['serversettings']['apacheconf_htpasswddir']['title'] = 'Dossier du fichier htpasswd pour Apache';
$lng['serversettings']['apacheconf_htpasswddir']['description'] = 'Oû doit être stocké le fichier de configuration de protection des dossiers "htpasswd" pour Apache ?';

// ADDED IN 1.2.16-svn15

$lng['error']['formtokencompromised'] = 'La requète semble compromise. Pour des raisons de sécurité, vous avez été déconnecté.';
$lng['serversettings']['mysql_access_host']['title'] = 'Hôtes de connexion MySQL';
$lng['serversettings']['mysql_access_host']['description'] = 'Une liste séparée par des virgules contenant la liste des hôtes depuis lesquels les utilisateurs sont autorisés à se connecter au serveur MySQL.';

// ADDED IN 1.2.18-svn1

$lng['admin']['ipsandports']['create_listen_statement'] = 'Déclaration des ports d\'écoute';
$lng['admin']['ipsandports']['create_namevirtualhost_statement'] = 'Déclaration des hôtes virtuels "NameVirtualHost"';
$lng['admin']['ipsandports']['create_vhostcontainer'] = 'Déclaration des conteneurs virtuels "vHost"';
$lng['admin']['ipsandports']['create_vhostcontainer_servername_statement'] = 'Déclaration des noms d\'hôtes "ServerName" dans les conteneurs virtuels "vHost"';

// ADDED IN 1.2.18-svn2

$lng['admin']['webalizersettings'] = 'Paramètres pour Webalizer';
$lng['admin']['webalizer']['normal'] = 'Normal';
$lng['admin']['webalizer']['quiet'] = 'Silencieux';
$lng['admin']['webalizer']['veryquiet'] = 'Aucune sortie';
$lng['serversettings']['webalizer_quiet']['title'] = 'Sortie Webalizer';
$lng['serversettings']['webalizer_quiet']['description'] = 'Verbosité du programme Webalizer';

// ADDED IN 1.2.18-svn3

$lng['ticket']['admin_email'] = 'root@localhost';
$lng['ticket']['noreply_email'] = 'billets@froxlor';
$lng['admin']['ticketsystem'] = 'Système de billets';
$lng['menue']['ticket']['ticket'] = 'Billets de support';
$lng['menue']['ticket']['categories'] = 'Catégories de support';
$lng['menue']['ticket']['archive'] = 'Archives de billets';
$lng['ticket']['description'] = 'Entrez une description !';
$lng['ticket']['ticket_new'] = 'Ouvrir un nouveau billet';
$lng['ticket']['ticket_reply'] = 'Réponse au billet';
$lng['ticket']['ticket_reopen'] = 'Réouvrir le billet';
$lng['ticket']['ticket_newcateory'] = 'Créer une nouvelle catégorie';
$lng['ticket']['ticket_editcateory'] = 'Editer la catégorie';
$lng['ticket']['ticket_view'] = 'Voir l\'historique du billet';
$lng['ticket']['ticketcount'] = 'Billets';
$lng['ticket']['ticket_answers'] = 'Réponses';
$lng['ticket']['lastchange'] = 'Dernière action';
$lng['ticket']['subject'] = 'Sujet';
$lng['ticket']['status'] = 'Etat';
$lng['ticket']['lastreplier'] = 'Dernière réponse de';
$lng['ticket']['priority'] = 'Priorité';
$lng['ticket']['low'] = 'Basse';
$lng['ticket']['normal'] = 'Normale';
$lng['ticket']['high'] = 'Haute';
$lng['ticket']['lastchange'] = 'Dernier changement';
$lng['ticket']['lastchange_from'] = 'Depuis (jj.mm.aaaa)';
$lng['ticket']['lastchange_to'] = 'Jusqu\'au (jj.mm.aaaa)';
$lng['ticket']['category'] = 'Catégorie';
$lng['ticket']['no_cat'] = 'Aucune';
$lng['ticket']['message'] = 'Message';
$lng['ticket']['show'] = 'Voir';
$lng['ticket']['answer'] = 'Répondre';
$lng['ticket']['close'] = 'Fermer';
$lng['ticket']['reopen'] = 'Réouvrir';
$lng['ticket']['archive'] = 'Archive';
$lng['ticket']['ticket_delete'] = 'Effacer le billet';
$lng['ticket']['lastarchived'] = 'Billets récemment archivés';
$lng['ticket']['archivedtime'] = 'Archivé';
$lng['ticket']['open'] = 'Ouvert';
$lng['ticket']['wait_reply'] = 'Attente d\'une réponse';
$lng['ticket']['replied'] = 'Répondu';
$lng['ticket']['closed'] = 'Fermé';
$lng['ticket']['staff'] = 'L\'équipe';
$lng['ticket']['customer'] = 'Client';
$lng['ticket']['old_tickets'] = 'Messages du billet';
$lng['ticket']['search'] = 'Rechercher dans les archives';
$lng['ticket']['nocustomer'] = 'Aucun choix';
$lng['ticket']['archivesearch'] = 'Résultat de la recherche dans les archives';
$lng['ticket']['noresults'] = 'Aucun billet trouvé';
$lng['ticket']['notmorethanxopentickets'] = 'Pour éviter les abus, vous ne pouvez avoir plus de %s billets ouverts';
$lng['ticket']['supportstatus'] = 'Etat du support';
$lng['ticket']['supportavailable'] = '<span class="ticket_low">Nos équipes de support sont disponibles et prètes à vous assister.</span>';
$lng['ticket']['supportnotavailable'] = '<span class="ticket_high">Nos équipes de support ne sont actuellement pas disponibles.</span>';
$lng['admin']['templates']['ticket'] = 'E-mail de notification pour les billets de support';
$lng['admin']['templates']['SUBJECT'] = 'Sera remplacé par le sujet du billet de support.';
$lng['admin']['templates']['new_ticket_for_customer'] = 'Informe le client que le billet a été envoyé';
$lng['admin']['templates']['new_ticket_by_customer'] = 'Notifie l\'administrateur qu\'un nouveau billet a été ouvert par un client';
$lng['admin']['templates']['new_reply_ticket_by_customer'] = 'Notifie l\'administrateur d\'une réponse du client au billet';
$lng['admin']['templates']['new_ticket_by_staff'] = 'Informe le client qu\'un billet a été ouvert par l\'équipe de support';
$lng['admin']['templates']['new_reply_ticket_by_staff'] = 'Informe le client d\'une réponse de l\'équipe de support au billet';
$lng['mails']['new_ticket_for_customer']['mailbody'] = 'Bonjour {FIRSTNAME} {NAME},\n\nVotre demande de billet de support ayant comme sujet "{SUBJECT}" a été envoyé.\n\nVous receverez une notification lorsque votre billet aura une réponse.\n\nMerci,\nL\'équipe Froxlor.';
$lng['mails']['new_ticket_for_customer']['subject'] = 'Votre billet de support a été envoyé';
$lng['mails']['new_ticket_by_customer']['mailbody'] = 'Bonjour administrateur,\n\nUn nouveau billet de support ayant comme sujet "{SUBJECT}" a été ouvert.\n\nVeuillez vous connecter pour consulter le billet.\n\nMerci,\nl\'équipe Froxlor.';
$lng['mails']['new_ticket_by_customer']['subject'] = 'Nouveau billet de support soumis';
$lng['mails']['new_reply_ticket_by_customer']['mailbody'] = 'Bonjour administrateur,\n\nLe billet de support "{SUBJECT}" a reçu une réponse de la part du client.\n\nVeuillez vous connecter pour consulter le billet.\n\nMerci,\nL\'équipe Froxlor.';
$lng['mails']['new_reply_ticket_by_customer']['subject'] = 'Nouvelle réponse au billet de support';
$lng['mails']['new_ticket_by_staff']['mailbody'] = 'Bonjour {FIRSTNAME} {NAME},\n\nUn billet de support ayant comme sujet "{SUBJECT}" a été ouvert pour vous par notre équipe.\n\nVeuillez vous connecter pour consulter le billet.\n\nMerci,\nL\'équipe Froxlor.';
$lng['mails']['new_ticket_by_staff']['subject'] = 'Nouvelle demande de support soumise';
$lng['mails']['new_reply_ticket_by_staff']['mailbody'] = 'Bonjour {FIRSTNAME} {NAME},\n\nLe billet de support ayant comme sujet "{SUBJECT}" a reçu une réponse par notre équipe.\n\nVeuillez vous connecter pour consulter le billet.\n\nMerci,\nL\équipe Froxlor.';
$lng['mails']['new_reply_ticket_by_staff']['subject'] = 'Nouvelle réponse au billet de support';
$lng['question']['ticket_reallyclose'] = 'Etes-vous sûr de vouloir clôturer le billet "%s" ?';
$lng['question']['ticket_reallydelete'] = 'Etes-vous sûr de vouloir supprimer le billet "%s" ?';
$lng['question']['ticket_reallydeletecat'] = 'Etes-vous sûr de vouloir supprimer la catégorie "%s" ?';
$lng['question']['ticket_reallyarchive'] = 'Etes-vous sûr de vouloir archiver le billet "%s" ?';
$lng['error']['mysubject'] = '"' . $lng['ticket']['subject'] . '"';
$lng['error']['mymessage'] = '"' . $lng['ticket']['message'] . '"';
$lng['error']['mycategory'] = '"' . $lng['ticket']['category'] . '"';
$lng['error']['nomoreticketsavailable'] = 'Vous n\'avez plus de billets de disponibles. Veuillez contacter votre administrateur.';
$lng['error']['nocustomerforticket'] = 'Ne peut créer de billet sans client';
$lng['error']['categoryhastickets'] = 'La catégorie possède des billets.<br />Veuillez d\'abord supprimer tous les billets de cette catégorie.';
$lng['error']['notmorethanxopentickets'] = $lng['ticket']['notmorethanxopentickets'];
$lng['admin']['ticketsettings'] = 'Paramètres des billets de support';
$lng['admin']['archivelastrun'] = 'Derniers billets archivés';
$lng['serversettings']['ticket']['noreply_email']['title'] = 'Adresse e-mail de non réponse';
$lng['serversettings']['ticket']['noreply_email']['description'] = 'L\'adresse e-mail de l\'expéditeur de notification pour les billets de support, quelque chose du type no-reply@domaine.com';
$lng['serversettings']['ticket']['worktime_begin']['title'] = 'Début du support (hh:mm)';
$lng['serversettings']['ticket']['worktime_begin']['description'] = 'Horaire de début du support';
$lng['serversettings']['ticket']['worktime_end']['title'] = 'Fin du support (hh:mm)';
$lng['serversettings']['ticket']['worktime_end']['description'] = 'Horaire de fin du support';
$lng['serversettings']['ticket']['worktime_sat'] = 'Support disponible le samedi ?';
$lng['serversettings']['ticket']['worktime_sun'] = 'Support disponible le dimanche ?';
$lng['serversettings']['ticket']['worktime_all']['title'] = 'Aucune limite horaire pour le support';
$lng['serversettings']['ticket']['worktime_all']['description'] = 'Si "Oui", les options pour le début et la fin du support seront écrasés.';
$lng['serversettings']['ticket']['archiving_days'] = 'Après combien de jours un billet fermé sera automatiquement archivé ?';
$lng['customer']['tickets'] = 'Billet de support';

// ADDED IN 1.2.18-svn4

$lng['admin']['domain_nocustomeraddingavailable'] = 'Il n\'est acutellement pas possible d\'ajouter de domaines. Vous devez d\'abord ajouter un client.';
$lng['serversettings']['ticket']['enable'] = 'Activer le système de billets';
$lng['serversettings']['ticket']['concurrentlyopen'] = 'Combien  de billets peuvent être ouverts au même moment ?';
$lng['error']['norepymailiswrong'] = 'L\'adresse de "non réponse" n\'est pas bonne. Une adresse e-mail valide doit être entrée.';
$lng['error']['tadminmailiswrong'] = 'L\'adresse de "l\'administrateur de billets" n\'est pas bonne. Une adresse e-mail valide doit être entrée.';
$lng['ticket']['awaitingticketreply'] = 'Vous avez %s billet(s) de support non répondu(s).';

// ADDED IN 1.2.18-svn5

$lng['serversettings']['ticket']['noreply_name'] = 'Nom de l\'expéditeur e-mail des billets';

// ADDED IN 1.2.19-svn1

$lng['serversettings']['mod_fcgid']['configdir']['title'] = 'Dossier de configuration FCGI';
$lng['serversettings']['mod_fcgid']['configdir']['description'] = 'Oû doivent être stockés les fichiers de configuration pour FCGI ?';
$lng['serversettings']['mod_fcgid']['tmpdir']['title'] = 'Dossier temporaire pour FCGI';

// ADDED IN 1.2.19-svn3

$lng['serversettings']['ticket']['reset_cycle']['title'] = 'Intervalle de réinitialisation des billets utilisés';
$lng['serversettings']['ticket']['reset_cycle']['description'] = 'Remettre le compteur de billets à 0 dans le temps imparti';
$lng['admin']['tickets']['daily'] = 'Journalière';
$lng['admin']['tickets']['weekly'] = 'Hebdomadaire';
$lng['admin']['tickets']['monthly'] = 'Mensuelle';
$lng['admin']['tickets']['yearly'] = 'Annuelle';
$lng['error']['ticketresetcycleiswrong'] = 'L\'intervalle de réinitialisation doit être "journalière", "hebdomadaire", "mensuelle" ou "annuelle".';

// ADDED IN 1.2.19-svn4

$lng['menue']['traffic']['traffic'] = 'Trafic';
$lng['menue']['traffic']['current'] = 'Mois actuel';
$lng['traffic']['month'] = 'Mois';
$lng['traffic']['day'] = 'Jour';
$lng['traffic']['months'][1] = 'Janvier';
$lng['traffic']['months'][2] = 'Février';
$lng['traffic']['months'][3] = 'Mars';
$lng['traffic']['months'][4] = 'Avril';
$lng['traffic']['months'][5] = 'Mai';
$lng['traffic']['months'][6] = 'Juin';
$lng['traffic']['months'][7] = 'Juillet';
$lng['traffic']['months'][8] = 'Août';
$lng['traffic']['months'][9] = 'Septembre';
$lng['traffic']['months'][10] = 'Octobre';
$lng['traffic']['months'][11] = 'Novembre';
$lng['traffic']['months'][12] = 'Décembre';
$lng['traffic']['mb'] = 'Trafic (Mo)';
$lng['traffic']['distribution'] = '<font color="#019522">FTP</font> | <font color="#0000FF">HTTP</font> | <font color="#800000">E-mail</font>';
$lng['traffic']['sumhttp'] = 'Trafic HTTP total entrant';
$lng['traffic']['sumftp'] = 'Trafic FTP total entrant';
$lng['traffic']['summail'] = 'Trafic E-mail total entrant';

// ADDED IN 1.2.19-svn4.5

$lng['serversettings']['no_robots']['title'] = 'Permettre aux robots des moteurs de recherche d\'indexer l\'installation de Froxlor';

// ADDED IN 1.2.19-svn6

$lng['admin']['loggersettings'] = 'Paramètres des logs';
$lng['serversettings']['logger']['enable'] = 'Activer / Désactiver les logs';
$lng['serversettings']['logger']['severity'] = 'Niveau de log';
$lng['admin']['logger']['normal'] = 'normal';
$lng['admin']['logger']['paranoid'] = 'paranoÃ¯aque';
$lng['serversettings']['logger']['types']['title'] = 'Type(s) de log';
$lng['serversettings']['logger']['types']['description'] = 'Spécifiez les types de log séparés par des virgules.<br />Les types de log disponible sont : syslog, file, mysql';
$lng['serversettings']['logger']['logfile'] = 'Nom du fichier de log, dossier + nom du fichier';
$lng['error']['logerror'] = 'Erreur log : %s';
$lng['serversettings']['logger']['logcron'] = 'Loguer les travaux de cron (lancer une fois)';
$lng['question']['logger_reallytruncate'] = 'Etes-vous sûr de vouloir vider la table "%s" ?';
$lng['admin']['loggersystem'] = 'Log système';
$lng['menue']['logger']['logger'] = 'Log système';
$lng['logger']['date'] = 'Date';
$lng['logger']['type'] = 'Type';
$lng['logger']['action'] = 'Action';
$lng['logger']['user'] = 'Utilisateur';
$lng['logger']['truncate'] = 'Vider les logs';

// ADDED IN 1.2.19-svn7

$lng['serversettings']['ssl']['use_ssl'] = 'Utiliser SSL ?';
$lng['serversettings']['ssl']['ssl_cert_file'] = 'Oû est situé le fichier de certificat ?';
$lng['serversettings']['ssl']['openssl_cnf'] = 'Paramètres par défaut pour créer le certificat';
$lng['panel']['reseller'] = 'revendeur';
$lng['panel']['admin'] = 'administrateur';
$lng['panel']['customer'] = 'client(s)';
$lng['error']['nomessagetosend'] = 'Vous n\'avez pas entré de message.';
$lng['error']['noreceipientsgiven'] = 'Vous n\'avez pas spécifier de destinataire';
$lng['admin']['emaildomain'] = 'Domaine e-mail';
$lng['admin']['email_only'] = 'Seulement des e-mails ?';
$lng['admin']['wwwserveralias'] = 'Ajouter un "www." à l\'alias du serveur "ServerAlias"';
$lng['admin']['ipsandports']['enable_ssl'] = 'Est-ce un port SSL ?';
$lng['admin']['ipsandports']['ssl_cert_file'] = 'Emplacement du certificat SSL';
$lng['panel']['send'] = 'envoyé';
$lng['admin']['subject'] = 'Sujet';
$lng['admin']['receipient'] = 'Destinataire';
$lng['admin']['message'] = 'Ecrire un message';
$lng['admin']['text'] = 'Message';
$lng['menu']['message'] = 'Messages';
$lng['error']['errorsendingmail'] = 'Echec d\'envoi du message à "%s"';
$lng['error']['cannotreaddir'] = 'Impossible de lire dossier "%s"';
$lng['message']['success'] = 'Le message a été envoyé aux destinataires "%s"';
$lng['message']['noreceipients'] = 'Aucun e-mail n\'a été envoyé car il n\'existe aucun destinataire dans la base de données';
$lng['admin']['sslsettings'] = 'Paramètres SSL';
$lng['cronjobs']['notyetrun'] = 'Pas encore lancé';
$lng['serversettings']['default_vhostconf']['title'] = 'Paramètres par défaut pour les vHosts';
$lng['emails']['quota'] = 'Quota';
$lng['emails']['noquota'] = 'Pas de quota';
$lng['emails']['updatequota'] = 'Mise à jour';
$lng['serversettings']['mail_quota']['title'] = 'Quota de la boîte aux lettres';
$lng['serversettings']['mail_quota']['description'] = 'Quota par défaut pour toutes nouvelles boîtes aux lettres créées.';
$lng['serversettings']['mail_quota_enabled']['title'] = 'Utiliser les quotas de boîtes aux lettres pour les clients';
$lng['serversettings']['mail_quota_enabled']['description'] = 'Activez cette option pour utiliser les quotas sur les boîtes aux lettres. Par défaut, cette option est à <b>Non</b> car cela requiert une configuration spécifique.';
$lng['serversettings']['mail_quota_enabled']['removelink'] = 'Cliquez ici pour retirer tous les quotas de tous les comptes e-mails.';
$lng['question']['admin_quotas_reallywipe'] = 'Etes-vous sûr de vouloir retirer tous les quotas de la table mail_users ? Cette action ne peut être annulée !';
$lng['error']['vmailquotawrong'] = 'La taille du quota doit être entre 1 et 999';
$lng['customer']['email_quota'] = 'Quota e-mail';
$lng['customer']['email_imap'] = 'E-mail IMAP';
$lng['customer']['email_pop3'] = 'E-mail POP3';
$lng['customer']['mail_quota'] = 'Quota e-mail';
$lng['error']['invalidip'] = 'Adresse IP invalide : %s';
$lng['serversettings']['decimal_places'] = 'Nombre de décimales à afficher pour le trafic / espace web';

// ADDED IN 1.2.19-svn8

$lng['admin']['dkimsettings'] = 'Paramètres DKIM';
$lng['dkim']['dkim_prefix']['title'] = 'Prefix DKIM';
$lng['dkim']['dkim_prefix']['description'] = 'Veuillez entrer l\'emplacement des fichiers RSA pour DKIM ainsi que l\'emplacement du fichier de configuration pour le plugin Milter';
$lng['dkim']['dkim_domains']['title'] = 'Nom du fichier DKIM';
$lng['dkim']['dkim_domains']['description'] = '<strong>Nom du fichier</strong> des paramètres DKIM pour les domaines tel que entré dans la configuration de DKIM-milter';
$lng['dkim']['dkim_dkimkeys']['title'] = 'Nom du fichier des clefs DKIM';
$lng['dkim']['dkim_dkimkeys']['description'] = '<strong>Nom du fichier</strong> des paramètres des clefs DKIM tel que entré dans la configuration de DKIM-milter';
$lng['dkim']['dkimrestart_command']['title'] = 'Commande de redémarrage de DKIM-milter';
$lng['dkim']['dkimrestart_command']['description'] = 'Veuillez entrer la commande de redémarrage du service DKIM-milter';

// ADDED IN 1.2.19-svn9

$lng['admin']['caneditphpsettings'] = 'Peut changer les paramétres PHP du domaine ?';

// ADDED IN 1.2.19-svn12

$lng['admin']['allips'] = 'Toutes les adresses IP';
$lng['panel']['nosslipsavailable'] = 'Il n\'y a actuellement aucune combinaison IP / Port configurer pour SSL';
$lng['ticket']['by'] = 'de ';
$lng['dkim']['use_dkim']['title'] = 'Activer le support DKIM ?';
$lng['dkim']['use_dkim']['description'] = 'Voulez-vous utiliser le système DKIM (DomainKeys Identified Mail) ?';
$lng['error']['invalidmysqlhost'] = 'Adresse hôte MySQL invalide : "%s"';
$lng['error']['cannotuseawstatsandwebalizeratonetime'] = 'Vous ne pouvez pas activer AWStats <u>et</u> Webalizer en même temps. Veuillez n\'en choisir qu\'un seul.';
$lng['serversettings']['webalizer_enabled'] = 'Activer les statistiques Webalizer';
$lng['serversettings']['awstats_enabled'] = 'Activer les statistiques AWStats';
$lng['admin']['awstatssettings'] = 'Paramètres Awstats';

// ADDED IN 1.2.19-svn16

$lng['admin']['domain_dns_settings'] = 'Paramètres DNS';
$lng['dns']['destinationip'] = 'IP du domaine';
$lng['dns']['standardip'] = 'IP standard du serveur';
$lng['dns']['a_record'] = 'Enregistrement de type "A" (IPv6 optionnel)';
$lng['dns']['cname_record'] = 'Enregistrement CNAME';
$lng['dns']['mxrecords'] = 'Définition des enregistrements MX';
$lng['dns']['standardmx'] = 'Enregistrements MX standard du serveur';
$lng['dns']['mxconfig'] = 'Enregistrements MX personnalisé';
$lng['dns']['priority10'] = 'Priorité 10';
$lng['dns']['priority20'] = 'Priorité 20';
$lng['dns']['txtrecords'] = 'Définir des enregistrement TXT';
$lng['dns']['txtexample'] = 'Exemple (pour SPF) :<br />v=spf1 ip4:xxx.xxx.xx.0/23 -all';
$lng['serversettings']['selfdns']['title'] = 'Paramètres manuel des DNS du domaine';
$lng['serversettings']['selfdnscustomer']['title'] = 'Permettre aux clients de modifier les paramètes DNS du domaine';
$lng['admin']['activated'] = 'Activé';
$lng['admin']['statisticsettings'] = 'Paramètres des statistiques';
$lng['admin']['or'] = 'ou';

// ADDED IN 1.2.19-svn17

$lng['serversettings']['unix_names']['title'] = 'Utiliser des noms d\'utilisateurs compatible UNIX';
$lng['serversettings']['unix_names']['description'] = 'Vous permet d\'utiliser les <strong>-</strong> et <strong>_</strong> dans les noms d\'utilisateurs si l\'option est à <strong>Non</strong>';
$lng['error']['cannotwritetologfile'] = 'Ne peut ouvrir le fichier de log %s en écriture';
$lng['admin']['sysload'] = 'Charge du système';
$lng['admin']['noloadavailable'] = 'Non disponible';
$lng['admin']['nouptimeavailable'] = 'Non disponible';
$lng['panel']['backtooverview'] = 'Retour à l\'aperçu';
$lng['admin']['nosubject'] = '(Aucun sujet)';
$lng['admin']['configfiles']['statistics'] = 'Statistiques';
$lng['login']['forgotpwd'] = 'Mot de passe oublié ?';
$lng['login']['presend'] = 'Réinitialiser le mot de passe';
$lng['login']['email'] = 'Adresse e-mail';
$lng['login']['remind'] = 'Réinitialiser mon mot de passe';
$lng['login']['usernotfound'] = 'Erreur : utilisateur inconnu !';
$lng['pwdreminder']['subject'] = 'Froxlor - réinitialisation du mot de passe';
$lng['pwdreminder']['body'] = 'Bonjour %s,\n\nVotre mot de passe pour Froxlor a été réinitialiser !\nLe nouveau mot de passe est : %p\n\nCordialement,\nL\'équipe Froxlor.';
$lng['pwdreminder']['success'] = 'Mot de passe correctement réinitialiser.<br />Vous devriez recevoir un e-mail avec votre nouveau mot de passe d\'ici quelques minutes.';

// ADDED IN 1.2.19-svn18

$lng['serversettings']['allow_password_reset']['title'] = 'Permettre aux clients de réinitialiser leurs mots de passe';
$lng['pwdreminder']['notallowed'] = 'La réinitialisation des mots de passe est désactivée.';

// ADDED IN 1.2.19-svn21

$lng['customer']['title'] = 'Titre';
$lng['customer']['country'] = 'Pays';
$lng['panel']['dateformat'] = 'YYYY-MM-DD';
$lng['panel']['dateformat_function'] = 'Y-m-d';

// Y = Year, m = Month, d = Day

$lng['panel']['timeformat_function'] = 'H:i:s';

// H = Hour, i = Minute, s = Second

$lng['panel']['default'] = 'Par défaut';
$lng['panel']['never'] = 'Jamais';
$lng['panel']['active'] = 'Actif';
$lng['panel']['please_choose'] = 'Veuillez choisir';
$lng['domains']['add_date'] = 'Ajouter à Froxlor';
$lng['domains']['registration_date'] = 'Ajouter à l\'enregistrement';

// ADDED IN 1.2.19-svn22

$lng['serversettings']['allow_password_reset']['description'] = 'Les clients peuvent réinitialiser leurs mots de passe et il sera envoyé à leurs propres adresses e-mails';
$lng['serversettings']['allow_password_reset_admin']['title'] = 'Permettre la réinitialisation des mots de passe par les administrateurs';
$lng['serversettings']['allow_password_reset_admin']['description'] = 'Les administrateurs / revendeurs peuvent réinitialiser leurs mots de passe et il sera envoyé à leurs propres adresses e-mails';

?>
