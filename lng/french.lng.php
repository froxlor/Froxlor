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
$lng['panel']['toggle'] = 'Activer / D&eacute;sactiver';
$lng['panel']['next'] = 'continuer';
$lng['panel']['dirsmissing'] = 'Dossiers non disponibles ou illisibles';

/**
 * Login
 */

$lng['login']['username'] = 'Identifiant';
$lng['login']['password'] = 'Mot de passe';
$lng['login']['language'] = 'Langue';
$lng['login']['login'] = 'Se connecter';
$lng['login']['logout'] = 'Se d&eacute;connecter';
$lng['login']['profile_lng'] = 'Langue du profil';

/**
 * Customer
 */

$lng['customer']['documentroot'] = 'Chemin';
$lng['customer']['name'] = 'Nom';
$lng['customer']['firstname'] = 'Pr&eacute;nom';
$lng['customer']['company'] = 'Entreprise';
$lng['customer']['street'] = 'Rue';
$lng['customer']['zipcode'] = 'Code postal';
$lng['customer']['city'] = 'Ville';
$lng['customer']['phone'] = 'T&eacute;l&eacute;phone';
$lng['customer']['fax'] = 'Fax';
$lng['customer']['email'] = 'E-mail';
$lng['customer']['customernumber'] = 'Num&eacute;ro du client';
$lng['customer']['diskspace'] = 'Espace Web (Mo)';
$lng['customer']['traffic'] = 'Trafic (Go)';
$lng['customer']['mysqls'] = 'Base(s) de donn&eacute;es MySQL';
$lng['customer']['emails'] = 'Adresse(s) e-mail';
$lng['customer']['accounts'] = 'Acc&egrave;s e-mail';
$lng['customer']['forwarders'] = 'Transfert(s) e-mail';
$lng['customer']['ftps'] = 'Acc&egrave;s FTP';
$lng['customer']['subdomains'] = 'Sous-domaine(s)';
$lng['customer']['domains'] = 'Domaine(s)';
$lng['customer']['unlimited'] = 'illimit&eacute;';

/**
 * Customermenue
 */

$lng['menue']['main']['main'] = 'G&eacute;n&eacute;ral';
$lng['menue']['main']['changepassword'] = 'Changer de mot de passe';
$lng['menue']['main']['changelanguage'] = 'Changer de langue';
$lng['menue']['email']['email'] = 'E-mail';
$lng['menue']['email']['emails'] = 'Adresse(s) e-mail(s)';
$lng['menue']['email']['webmail'] = 'Webmail';
$lng['menue']['mysql']['mysql'] = 'MySQL';
$lng['menue']['mysql']['databases'] = 'Bases de donn&eacute;es';
$lng['menue']['mysql']['phpmyadmin'] = 'phpMyAdmin';
$lng['menue']['domains']['domains'] = 'Domaines';
$lng['menue']['domains']['settings'] = 'Param&eacute;tres des sites';
$lng['menue']['ftp']['ftp'] = 'FTP';
$lng['menue']['ftp']['accounts'] = 'Comptes d\'acc&egrave;s FTP';
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

$lng['domains']['description'] = 'Ici, vous pouvez ajouter des sites et domaines et changer leurs doosiers.<br />Il vous faudra patienter quelques minutes apr&egrave;s chaque changement pour que la configuration soit activ&eacute;e.';
$lng['domains']['domainsettings'] = 'Configuration des Domaines';
$lng['domains']['domainname'] = 'Nom du Domaine';
$lng['domains']['subdomain_add'] = 'Ajouter un sous-domaine';
$lng['domains']['subdomain_edit'] = 'Changer un sous-domaine';
$lng['domains']['wildcarddomain'] = 'Domaine g&eacute;n&eacute;rique (Wilcard) ?';
$lng['domains']['aliasdomain'] = 'Alias pour le domaine';
$lng['domains']['noaliasdomain'] = 'Domaine sans alias';

/**
 * E-mails
 */

$lng['emails']['description'] = 'Ici, vous pouvez ajouter vos bo&icirc;tes e-mails.<br /><br />Les informations pour configurer votre logiciel e-mail sont les suivantes : <br /><br />Nom du serveur : <b><i>votre-domaine.com</i></b><br />Identifiant : <b><i>l\'adresse e-mail</i></b><br />Mot de passe : <b><i>le mot de passe que vous avez choisi</i></b>';
$lng['emails']['emailaddress'] = 'Adresse';
$lng['emails']['emails_add'] = 'Ajouter une adresse e-mail';
$lng['emails']['emails_edit'] = 'Changer une adresse e-mail';
$lng['emails']['catchall'] = 'Catchall';
$lng['emails']['iscatchall'] = 'D&eacute;finir comme adresse "catchall" ?';
$lng['emails']['account'] = 'Acc&egrave;s';
$lng['emails']['account_add'] = 'Ajouter un acc&egrave;s';
$lng['emails']['account_delete'] = 'Supprimer l\'acc&egrave;s';
$lng['emails']['from'] = 'de';
$lng['emails']['to'] = '&agrave;';
$lng['emails']['forwarders'] = 'R&eacute;exp&eacute;dition';
$lng['emails']['forwarder_add'] = 'Ajouter un renvoi';

/**
 * FTP
 */

$lng['ftp']['description'] = 'Ici, vous pouvez ajouter des acc&egrave;s FTP suppl&eacute;mentaires.<br />Les changements, ainsi que l\'acc&egrave;s, sont imm&eacute;diatement op&eacute;rationnels.';
$lng['ftp']['account_add'] = 'Ajouter un acc&egrave;s';

/**
 * MySQL
 */

$lng['mysql']['databasename'] = 'Nom de la base de donn&eacute;es';
$lng['mysql']['databasedescription'] = 'Description de la base de donn&eacute;es';
$lng['mysql']['database_create'] = 'Ajouter une base de donn&eacute;es';

/**
 * Extras
 */

$lng['extras']['description'] = 'Ici, vous pouvez ajouter des extras, comme par exemple, la protection de dossiers du site.<br />Il vous faudra patienter quelques minutes apr&egrave;s chaque changement pour que la configuration soit activ&eacute;e.';
$lng['extras']['directoryprotection_add'] = 'Ajouter une protection de dossier';
$lng['extras']['view_directory'] = 'Aper&ccedil;u du dossier';
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
$lng['error']['filemustexist'] = 'Le fichier que vous avez s&eacute;lectionn&eacute; n\'existe pas.';
$lng['error']['allresourcesused'] = 'Vous avez d&eacute;j&agrave; utilis&eacute; toutes les ressources.';
$lng['error']['domains_cantdeletemaindomain'] = 'Vous ne pouvez pas supprimer un domaine qui est utilis&eacute; pour des adresses e-mails.';
$lng['error']['domains_canteditdomain'] = 'Vous n\'avez pas le droit de configurer ce domaine.';
$lng['error']['domains_cantdeletedomainwithemail'] = 'Vous ne pouvez pas supprimer un domaine qui est utilis&eacute; pour des e-mails. Vous devez d\'abord supprimer toutes les adresses e-mails qu\'il contient.';
$lng['error']['firstdeleteallsubdomains'] = 'Il faut d\'abord supprimer tous les sous-domaines avant d\'ajouter un domaine "wildcard".';
$lng['error']['youhavealreadyacatchallforthisdomain'] = 'Vous avez d&eacute;j&agrave; d&eacute;fini une adresse "catchall" pour ce domaine.';
$lng['error']['ftp_cantdeletemainaccount'] = 'Vous ne pouvez pas supprimer votre acc&egrave;s principal.';
$lng['error']['login'] = 'Identifiant / mot de passe invalide.';
$lng['error']['login_blocked'] = 'Cet identifiant a &eacute;t&eacute; bloqu&eacute; &agrave; cause de nombreuses tentatives de connexions invalides.<br />Veuillez r&eacute;essayer dans ' . $settings['login']['deactivatetime'] . ' secondes.';
$lng['error']['notallreqfieldsorerrors'] = 'Vous n\'avez pas rempli toutes les cases obligatoires ou vous les avez remplis avec des informations invalides.';
$lng['error']['oldpasswordnotcorrect'] = 'L\'ancien mot de passe n\'est pas correct.';
$lng['error']['youcantallocatemorethanyouhave'] = 'Vous ne pouvez pas distribuer plus de ressources qu\'il n\'en reste.';
$lng['error']['mustbeurl'] = 'Vous n\'avez pas entr&eacute; une adresse URL valide.';
$lng['error']['invalidpath'] = 'Vous n\'avez pas choisi une adresse URL valide (probablement &agrave; cause de probl&egrave;mes avec le listing de dossiers ?)';
$lng['error']['stringisempty'] = 'Entr&eacute;e manquante';
$lng['error']['stringiswrong'] = 'Entr&eacute;e invalide';
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
$lng['error']['loginnameexists'] = 'L\'identifiant "%s" existe d&eacute;j&agrave;.';
$lng['error']['emailiswrong'] = 'L\'adresse "%s" contient des signes invalides ou est incompl&egrave;te.';
$lng['error']['loginnameiswrong'] = 'L\'identifiant "%s" contient des signes invalides.';
$lng['error']['userpathcombinationdupe'] = 'Cette combinaison d\'identifiant et de dossier existe d&eacute;j&agrave;.';
$lng['error']['patherror'] = 'Erreur g&eacute;n&eacute;rale ! Le dossier ne doit pas &ecirc;tre vide.';
$lng['error']['errordocpathdupe'] = 'Il y a d&eacute;j&agrave; une option concernant le dossier "%s".';
$lng['error']['adduserfirst'] = 'Vous devez d\'abord ajouter un.';
$lng['error']['domainalreadyexists'] = 'Le domaine "%s" existe d&eacute;j&agrave;.';
$lng['error']['nolanguageselect'] = 'Aucune langue choisis.';
$lng['error']['nosubjectcreate'] = 'Il faut entrer un sujet.';
$lng['error']['nomailbodycreate'] = 'Il faut entrer un corps de texte.';
$lng['error']['templatenotfound'] = 'Aucun mod&egrave;le trouv&eacute;.';
$lng['error']['alltemplatesdefined'] = 'Vous avez d&eacute;j&agrave; appliqu&eacute; des mod&egrave;les pour toutes les langues.';
$lng['error']['wwwnotallowed'] = 'Un sous-domaine ne peut pas s\'appeler www.';
$lng['error']['subdomainiswrong'] = 'Le sous-domaine "%s" contient des signes invalides.';
$lng['error']['domaincantbeempty'] = 'Le nom de domaine ne doit pas &ecirc;tre vide.';
$lng['error']['domainexistalready'] = 'Le domaine "%s" existe d&eacute;j&agrave;.';
$lng['error']['domainisaliasorothercustomer'] = 'L\'alias du domaine choisi est soit un alias existant d\'un autre client ou soit fait r&eacute;f&eacute;rence &agrave; lui m&ecirc;me.';
$lng['error']['emailexistalready'] = 'L\'adresse "%s" existe d&eacute;j&agrave;.';
$lng['error']['maindomainnonexist'] = 'Le domaine "%s" n\'existe pas.';
$lng['error']['destinationnonexist'] = 'Veuillez &eacute;crire votre adresse de renvoi &agrave; l\'emplacement "&agrave;".';
$lng['error']['destinationalreadyexistasmail'] = 'Le renvoi vers l\'adresse "%s" existe d&eacute;j&agrave; comme adresse active.';
$lng['error']['destinationalreadyexist'] = 'Il existe d&eacute;j&agrave; une r&eacute;exp&eacute;dition vers l\'adresse "%s".';
$lng['error']['destinationiswrong'] = 'L\'adresse "%s" contient des signes invalides ou est incompl&egrave;te.';
$lng['error']['domainname'] = $lng['domains']['domainname'];
$lng['error']['loginnameissystemaccount'] = 'Vous ne pouvez pas cr&eacute;er un compte identique au compte syst&egrave;me, veuillez r&eacute;essayer avec un autre nom.';

/**
 * Questions
 */

$lng['question']['question'] = 'Question de s&eacute;curit&eacute;';
$lng['question']['admin_customer_reallydelete'] = 'Etes-vous s&ucirc;r de vouloir supprimer le compte "%s" ?<br />ATTENTION ! Toutes ses informations seront supprim&eacute;es ! Une fois fait, il vous appartiendra de supprimer manuellement tous les dossiers du compte sur le syst&egrave;me de fichiers.';
$lng['question']['admin_domain_reallydelete'] = 'Etes-vous s&ucirc;r de vouloir supprimer le domaine "%s" ?';
$lng['question']['admin_domain_reallydisablesecuritysetting'] = 'Etes-vous s&ucirc;r de vouloir d&eacute;sactiver les modes de s&eacute;curit&eacute; suivants : OpenBasedir et / o&ucirc; SafeMode ?';
$lng['question']['admin_admin_reallydelete'] = 'Etes-vous s&ucirc;r de vouloir supprimer l\'administrateur "%s" ?<br />Tous ses comptes seront affect&eacute;s &agrave; l\'administrateur principal.';
$lng['question']['admin_template_reallydelete'] = 'Etes-vous s&ucirc;r de vouloir supprimer le mod&egrave;le "%s" ?';
$lng['question']['domains_reallydelete'] = 'Etes-vous s&ucirc;r de vouloir supprimer le domaine "%s" ?';
$lng['question']['email_reallydelete'] = 'Etes-vous s&ucirc;r de vouloir supprimer l\'adresse e-mail "%s" ? ';
$lng['question']['email_reallydelete_account'] = 'Etes-vous s&ucirc;r de vouloir supprimer l\'acc&egrave;s e-mail "%s" ?';
$lng['question']['email_reallydelete_forwarder'] = 'Etes-vous s&ucirc;r de vouloir supprimer le renvoi vers "%s" ?';
$lng['question']['extras_reallydelete'] = 'Etes-vous s&ucirc;r de vouloir supprimer la protection du dossier "%s" ?';
$lng['question']['extras_reallydelete_pathoptions'] = 'Etes-vous s&ucirc;r de vouloir supprimer les options du dossier "%s" ?';
$lng['question']['ftp_reallydelete'] = 'Etes-vous s&ucirc;r de vouloir supprimer l\'acc&egrave;s ftp "%s" ?';
$lng['question']['mysql_reallydelete'] = 'Etes-vous s&ucirc;r de vouloir supprimer la base de donn&eacute;es "%s" ?<br />ATTENTION : Toutes les donn&eacute;es seront perdues &agrave; jamais !';
$lng['question']['admin_configs_reallyrebuild'] = 'Etes-vous s&ucirc;r de vouloir r&eacute;g&eacute;n&eacute;rer les fichiers de configuration Apache et Bind ?';

/**
 * Mails
 */

$lng['mails']['pop_success']['mailbody'] = 'Bonjour,\n\nvotre acc&egrave;s POP3 / IMAP {EMAIL}\na &eacute;t&eacute; cr&eacute;&eacute; avec succ&egrave;s.\n\nCeci est un e-mail g&eacute;n&eacute;r&eacute; automatiquement, veuillez ne pas r&eacute;pondre &agrave; ce message.\n\nCordialement,\nL\'&eacute;quipe Froxlor\nhttp://www.froxlor.org';
$lng['mails']['pop_success']['subject'] = 'Acc&egrave;s POP3 / IMAP cr&eacute;&eacute;';
$lng['mails']['createcustomer']['mailbody'] = 'Bonjour {FIRSTNAME} {NAME},\n\nVous trouverez ci-dessous vos informations d\'acc&egrave;s au panel d\'administration :\n\nAdresse d\'administration : http://demo.froxlor.org\n\nIdentifiant : {USERNAME}\nMot de passe : {PASSWORD}\n\nCordialement,\nL\'&eacute;quipe Froxlor\nhttp://www.froxlor.org\n';
$lng['mails']['createcustomer']['subject'] = 'Froxlor : Informations pour votre acc&egrave;s au panel d\'administration';

/**
 * Admin
 */

$lng['admin']['overview'] = 'Sommaire';
$lng['admin']['ressourcedetails'] = 'Ressources utilis&eacute;es';
$lng['admin']['systemdetails'] = 'Informations du syst&egrave;me';
$lng['admin']['froxlordetails'] = 'Informations de Froxlor';
$lng['admin']['installedversion'] = 'Version install&eacute;e';
$lng['admin']['latestversion'] = 'Derni&egrave;re version en date';
$lng['admin']['lookfornewversion']['clickhere'] = 'V&eacute;rifier par internet';
$lng['admin']['lookfornewversion']['error'] = 'Erreur pour v&eacute;rifier la derni&egrave;re version';
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
$lng['admin']['serversettings'] = 'Param&egrave;tres';
$lng['admin']['rebuildconf'] = 'R&eacute;g&eacute;n&eacute;rer la configuration';
$lng['admin']['stdsubdomain'] = 'Sous-domaine type';
$lng['admin']['stdsubdomain_add'] = 'Ajouter un sous-domaine type';
$lng['admin']['phpenabled'] = 'PHP activ&eacute;';
$lng['admin']['deactivated'] = 'D&eacute;sactiver';
$lng['admin']['deactivated_user'] = 'D&eacute;sactiver l\'utilisateur';
$lng['admin']['sendpassword'] = 'Envoyer le mot de passe';
$lng['admin']['ownvhostsettings'] = 'Configuration sp&eacute;ciale du vHost';
$lng['admin']['configfiles']['serverconfiguration'] = 'Exemple de configuration';
$lng['admin']['configfiles']['files'] = '<b>Fichiers de configuration :</b> Veuillez cr&eacute;er ou modifier les fichiers suivants avec le contenu ci-dessous.<br /><br /><b>IMPORTANT :</b> Le mot de passe MySQL n\'est pas donn&eacute; dans les informations ci-dessous<br />pour des raisons de s&eacute;curit&eacute;. Veuillez donc remplacer les "<b>MYSQL_PASSWORD</b>"<br />manuellement avec le mot de passe correspondant. En cas d\'oubli, vous pouvez le retrouver dans<br />le fichier "<b>lib/userdata.inc.php</b>".';
$lng['admin']['configfiles']['commands'] = '<b>Commandes :</b> Veuillez ex&eacute;cuter les commandes ci-dessous dans le shell.';
$lng['admin']['configfiles']['restart'] = '<b>Red&eacute;marrage :</b> Veuillez ex&eacute;cuter les commandes ci-dessous pour<br />prendre en compte les changements.';
$lng['admin']['templates']['templates'] = 'Mod&egrave;les';
$lng['admin']['templates']['template_add'] = 'Ajouter un mod&egrave;le';
$lng['admin']['templates']['template_edit'] = 'Modifier un mod&egrave;le';
$lng['admin']['templates']['action'] = 'Action';
$lng['admin']['templates']['email'] = 'E-mail';
$lng['admin']['templates']['subject'] = 'R&eacute;f&eacute;rence';
$lng['admin']['templates']['mailbody'] = 'Texte de l\'e-mail';
$lng['admin']['templates']['createcustomer'] = 'E-mail de bienvenue pour les nouveaux clients';
$lng['admin']['templates']['pop_success'] = 'E-mail de bienvenue pour les nouveaux acc&egrave;s e-mail';
$lng['admin']['templates']['template_replace_vars'] = 'Les variables qui seront remplac&eacute;es dans le template :';
$lng['admin']['templates']['FIRSTNAME'] = 'Sera remplac&eacute; par le pr&eacute;nom.';
$lng['admin']['templates']['NAME'] = 'Sera remplac&eacute; par le nom.';
$lng['admin']['templates']['USERNAME'] = 'Sera remplac&eacute; par le login.';
$lng['admin']['templates']['PASSWORD'] = 'Sera remplac&eacute; par le mot de passe du client.';
$lng['admin']['templates']['EMAIL'] = 'Sera remplac&eacute; par l\'acc&egrave;s e-mail.';

/**
 * Serversettings
 */

$lng['serversettings']['session_timeout']['title'] = 'Dur&eacute;e d\'inactivit&eacute; maximale';
$lng['serversettings']['session_timeout']['description'] = 'Combien de secondes d\'inactivit&eacute; avant qu\'une session ne se ferme ?';
$lng['serversettings']['accountprefix']['title'] = 'Pr&eacute;fix des comptes';
$lng['serversettings']['accountprefix']['description'] = 'Quel pr&eacute;fix doivent avoir les comptes ?';
$lng['serversettings']['mysqlprefix']['title'] = 'Pr&eacute;fix SQL';
$lng['serversettings']['mysqlprefix']['description'] = 'Quel pr&eacute;fix doivent avoir les bases de donn&eacute;es ?';
$lng['serversettings']['ftpprefix']['title'] = 'Pr&eacute;fix FTP';
$lng['serversettings']['ftpprefix']['description'] = 'Quel pr&eacute;fix doivent avoir les acc&egrave;s FTP ?';
$lng['serversettings']['documentroot_prefix']['title'] = 'Dossier de stockage';
$lng['serversettings']['documentroot_prefix']['description'] = 'O&ucirc; doivent &ecirc;tre stock&eacute;s tous les dossiers et fichiers des diff&eacute;rents comptes ?';
$lng['serversettings']['logfiles_directory']['title'] = 'Dossier des fichiers de log';
$lng['serversettings']['logfiles_directory']['description'] = 'O&ucirc; doivent &ecirc;tre stock&eacute;s les archives des logs d\'acc&egrave;s du serveur Web ?';
$lng['serversettings']['ipaddress']['title'] = 'Adresse IP';
$lng['serversettings']['ipaddress']['description'] = 'Quelle est l\'adresse IP du serveur ?';
$lng['serversettings']['hostname']['title'] = 'Nom d\'h&ocirc;te';
$lng['serversettings']['hostname']['description'] = 'Quel est le nom d\'h&ocirc;te (hostname) du serveur ?';
$lng['serversettings']['apachereload_command']['title'] = 'Commande de rechargement d\'Apache';
$lng['serversettings']['apachereload_command']['description'] = 'Quelle est la commande pour recharger / red&eacute;marrer Apache ?';
$lng['serversettings']['bindconf_directory']['title'] = 'Emplacement du dossier de configuration de Bind / Named';
$lng['serversettings']['bindconf_directory']['description'] = 'O&ucirc; doit &ecirc;tre stock&eacute; la configuration de Bind / Named ?';
$lng['serversettings']['bindreload_command']['title'] = 'Commande de rechargement de Bind / Named';
$lng['serversettings']['bindreload_command']['description'] = 'Quelle est la commande pour recharger / red&eacute;marrer Bind / Named ?';
$lng['serversettings']['binddefaultzone']['title'] = 'Nom du fichier de zone par d&eacute;faut Bind / Named';
$lng['serversettings']['binddefaultzone']['description'] = 'Quel est le nom du fichier de zone par d&eacute;faut pour Bind / Named ?';
$lng['serversettings']['vmail_uid']['title'] = 'UID des e-mails';
$lng['serversettings']['vmail_uid']['description'] = 'Quel UID doivent avoir les e-mails ?';
$lng['serversettings']['vmail_gid']['title'] = 'GID des e-mails';
$lng['serversettings']['vmail_gid']['description'] = 'Quel GID doivent avoir les e-mails ?';
$lng['serversettings']['vmail_homedir']['title'] = 'Emplacement des e-mails';
$lng['serversettings']['vmail_homedir']['description'] = 'Dans quel dossier doivent &ecirc;tre stocker les e-mails ?';
$lng['serversettings']['adminmail']['title'] = 'Adresse e-mail de l\'administrateur';
$lng['serversettings']['adminmail']['description'] = 'Quelle est l\'adresse e-mail par d&eacute;faut des e-mails envoy&eacute;s par Froxlor ?';
$lng['serversettings']['phpmyadmin_url']['title'] = 'Adresse URL de phpMyAdmin';
$lng['serversettings']['phpmyadmin_url']['description'] = 'A quelle adresse se trouve phpMyAdmin ?';
$lng['serversettings']['webmail_url']['title'] = 'Adresse URL du WebMail';
$lng['serversettings']['webmail_url']['description'] = 'A quelle adresse se trouve le WebMail ?';
$lng['serversettings']['webftp_url']['title'] = 'Adresse URL du WebFTP';
$lng['serversettings']['webftp_url']['description'] = 'A quelle adresse se trouve le WebFTP ?';
$lng['serversettings']['language']['description'] = 'Quelle langue est la langue par d&eacute;faut ?';
$lng['serversettings']['maxloginattempts']['title'] = 'Nombre d\'essais maximum avant d&eacute;sactivation';
$lng['serversettings']['maxloginattempts']['description'] = 'Nombre de tentatives maximum avant la d&eacute;sactivation de l\'acc&egrave;s.';
$lng['serversettings']['deactivatetime']['title'] = 'Dur&eacute;e de la d&eacute;sactivation';
$lng['serversettings']['deactivatetime']['description'] = 'Dur&eacute;e (en secondes) pendant laquelle l\'acc&egrave;s sera d&eacute;sactiv&eacute;.';
$lng['serversettings']['pathedit']['title'] = 'Mode de s&eacute;lection des dossiers';
$lng['serversettings']['pathedit']['description'] = 'Choisir un dossier par une liste d&eacute;roulante ou l\'entrer manuellement ?';
$lng['serversettings']['nameservers']['title'] = 'Serveurs de nom &laquo;Nameservers&raquo;';
$lng['serversettings']['nameservers']['description'] = 'Une liste s&eacute;par&eacute;e par des virgules contenant les noms d\'h&ocirc;tes de tous les serveurs de noms. Le premier dans la liste sera le serveur primaire.';
$lng['serversettings']['mxservers']['title'] = 'Serveurs de messagerie &laquo;MX&raquo;';
$lng['serversettings']['mxservers']['description'] = 'Une liste s&eacute;par&eacute;e par des virgules contenant les serveurs de messagerie avec leur poid : un nombre et le nom d\'h&ocirc;te s&eacute;par&eacute; par un espace; par exemple : "10 mx.exemple.com".';

/**
 * CHANGED BETWEEN 1.2.12 and 1.2.13
 */

$lng['mysql']['description'] = 'Ici, vous pouvez ajouter et effacer des bases de donn&eacute;es MySQL.<br />Les changements, ainsi que les bases de donn&eacute;es, sont imm&eacute;diatement op&eacute;rationnels.<br />Dans le menu, vous trouverez un lien vers phpMyAdmin, avec lequel vous pouvez g&eacute;rer vos bases de donn&eacute;es.<br /><br />L\'acc&egrave;s aux bases de donn&eacute;es depuis les scripts PHP fonctionne comme suit : (Il faut remplacer les valeurs en <i><b>italique</b></i> par vos informations !)<br /><br />$connexion = mysql_connect(\'localhost\', \'<i><b>Votre identifiant</b></i>\', \'<i><b>Votre mot de passe</b></i>\');<br />mysql_select_db(\'<i><b>Le nom de la base de donn&eacute;es</b></i>\', $connexion);';

/**
 * ADDED BETWEEN 1.2.12 and 1.2.13
 */

$lng['serversettings']['paging']['title'] = 'Nombre de r&eacute;sultats par page';
$lng['serversettings']['paging']['description'] = 'Nombre de r&eacute;sultats par page ? (0 = D&eacute;sactive la pagination)';
$lng['error']['ipstillhasdomains'] = 'La combinaison IP / port est encore utilis&eacute;e, veuillez r&eacute;assigner le ou les domaines existant(s) avec cette adresse IP / port concern&eacute;(s) &agrave; une autre combinaison IP / port avant de supprimer celle-ci.';
$lng['error']['cantdeletedefaultip'] = 'Vous ne pouvez pas supprimer cette combinaison IP / Port, veuillez d\'abord attribuer une autre combinaison IP / Port par d&eacute;faut &agrave; ce revendeur avant de supprimer celle-ci.';
$lng['error']['cantdeletesystemip'] = 'Vous ne pouvez pas cr&eacute;er, modifier ou supprimer l\'IP du syst&egrave;me.';
$lng['error']['myipaddress'] = '"IP"';
$lng['error']['myport'] = '"Port"';
$lng['error']['myipdefault'] = 'Choissez une combinaison IP / port par d&eacute;faut.';
$lng['error']['myipnotdouble'] = 'Cette combinaison existe d&eacute;j&agrave;';
$lng['question']['admin_ip_reallydelete'] = 'Etes-vous s&ucirc;r de vouloir supprimer l\'adresse IP "%s" ?';
$lng['admin']['ipsandports']['ipsandports'] = 'IPs et ports';
$lng['admin']['ipsandports']['add'] = 'Ajouter une IP / port';
$lng['admin']['ipsandports']['edit'] = 'Modifier une IP / port';
$lng['admin']['ipsandports']['ipandport'] = 'IP / Port';
$lng['admin']['ipsandports']['ip'] = 'IP';
$lng['admin']['ipsandports']['port'] = 'Port';

// ADDED IN 1.2.13-rc3

$lng['error']['cantchangesystemip'] = 'Vous ne pouvez pas modifier l\'adresse IP du syst&egrave;me, ni en ajouter de nouvelle.';
$lng['question']['admin_domain_reallydocrootoutofcustomerroot'] = 'Etes-vous s&ucirc;r de vouloir diff&eacute;rencier la racine principale de ce domaine de la racine principale du client ?';

// ADDED IN 1.2.14-rc1

$lng['admin']['memorylimitdisabled'] = 'D&eacute;sactiv&eacute;';
$lng['domain']['openbasedirpath'] = 'Dossier "OpenBasedir"';
$lng['domain']['docroot'] = 'Identique au dossier ci-dessus';
$lng['domain']['homedir'] = 'Dossier Principal';
$lng['admin']['valuemandatory'] = 'Cette valeur est obligatoire';
$lng['admin']['valuemandatorycompany'] = 'Vous devez indiquer au moins l\'une des 3 valeurs suivantes : "nom" ou "pr&eacute;nom" ou "entreprise"';
$lng['menue']['main']['username'] = 'Utilisateur : ';
$lng['panel']['urloverridespath'] = 'URL (supplante la valeur dossier)';
$lng['panel']['pathorurl'] = 'Dossier ou URL';
$lng['error']['sessiontimeoutiswrong'] = 'Seule une valeur num&eacute;rique pour le temps d\'inactivit&eacute; est autoris&eacute;e.';
$lng['error']['maxloginattemptsiswrong'] = 'Seule une valeur num&eacute;rique pour "nombre maximum de tentative de connexion" est autoris&eacute;e.';
$lng['error']['deactivatetimiswrong'] = 'Seule une valeur num&eacute;rique pour la dur&eacute;e de d&eacute;sactivation est autoris&eacute;e.';
$lng['error']['accountprefixiswrong'] = 'Le "Pr&eacute;fixe client" n\'est pas valide.';
$lng['error']['mysqlprefixiswrong'] = 'Le "Pr&eacute;fixe SQL" n\'est pas valide.';
$lng['error']['ftpprefixiswrong'] = 'Le "Pr&eacute;fixe FTP" n\'est pas valide.';
$lng['error']['ipiswrong'] = 'L\'"Adresse IP" n\'est pas valide.';
$lng['error']['vmailuidiswrong'] = 'L\'"UID e-mail" est incorrect. Seul un UID num&eacute;rique est autoris&eacute;.';
$lng['error']['vmailgidiswrong'] = 'Le "GID e-mail" est incorrect. Seul un GID num&eacute;rique est autoris&eacute;.';
$lng['error']['adminmailiswrong'] = 'L\'adresse e-mail de l\'administrateur est incorrect. Seulement une adresse e-mail valide est autoris&eacute;.';
$lng['error']['pagingiswrong'] = 'La valeur "Nombre de r&eacute;sultats page" est incorrecte. Seul une valeur num&eacute;rique est autoris&eacute;e.';
$lng['error']['phpmyadminiswrong'] = 'Le lien pour phpMyAdmin n\'est pas valide.';
$lng['error']['webmailiswrong'] = 'Le lien pour le WebMail n\'est pas valide.';
$lng['error']['webftpiswrong'] = 'Le lien pour le WebFTP n\'est pas valide.';
$lng['domains']['hasaliasdomains'] = 'Le domaine poss&egrave;de un ou des alias.';
$lng['serversettings']['defaultip']['title'] = 'IP / Port par d&eacute;faut';
$lng['serversettings']['defaultip']['description'] = 'Quel est l\'IP / Port par d&eacute;faut ?';
$lng['domains']['statstics'] = 'Fr&eacute;quentation';
$lng['panel']['ascending'] = 'ascendant';
$lng['panel']['decending'] = 'descendant';
$lng['panel']['search'] = 'Rechercher';
$lng['panel']['used'] = 'utilis&eacute;';

// ADDED IN 1.2.14-rc3

$lng['panel']['translator'] = 'Traducteur(s)';

// ADDED IN 1.2.14-rc4

$lng['error']['stringformaterror'] = 'La valeur pour "%s" n\'est pas dans un format reconnu.';

// ADDED IN 1.2.15-rc1

$lng['admin']['serversoftware'] = 'Logiciel Serveur';
$lng['admin']['phpversion'] = 'Version de PHP';
$lng['admin']['phpmemorylimit'] = 'Limite m&eacute;moire de PHP';
$lng['admin']['mysqlserverversion'] = 'Version du serveur MySQL';
$lng['admin']['mysqlclientversion'] = 'Version du client MySQL';
$lng['admin']['webserverinterface'] = 'Interface Web';
$lng['domains']['isassigneddomain'] = 'Le domaine est attribu&eacute;';
$lng['serversettings']['phpappendopenbasedir']['title'] = 'Dossier(s) de l\'OpenBasedir';
$lng['serversettings']['phpappendopenbasedir']['description'] = 'Liste de dossiers s&eacute;par&eacute;e par des virgules qui sera ajout&eacute; &agrave; la variable "OpenBasedir" des conteneurs vHosts.';

// CHANGED IN 1.2.15-rc1

$lng['error']['loginnameissystemaccount'] = 'Vous ne pouvez pas cr&eacute;er de compte ressemblant aux comptes syst&egrave;me (ex : "%s"). Veuillez entrer un autre nom de compte.';
$lng['error']['youcantdeleteyourself'] = 'Vous ne pouvez pas supprimer votre propre compte pour des raisons &eacute;vidente de s&eacute;curit&eacute; ...';
$lng['error']['youcanteditallfieldsofyourself'] = 'Note : Vous ne pouvez pas &eacute;diter tous les champs de votre propre compte pour des raisons de s&eacute;curit&eacute;.';

// ADDED IN 1.2.16-svn1

$lng['serversettings']['natsorting']['title'] = 'Utiliser un tri naturel dans les diff&eacute;rentes vues';
$lng['serversettings']['natsorting']['description'] = 'Trier les listes comme web1 -> web2 -> etc ... -> web11 au lieu de web1 -> web11 -> web2.';

// ADDED IN 1.2.16-svn2

$lng['serversettings']['deactivateddocroot']['title'] = 'Dossier "DocumentRoot" pour les utilisateurs d&eacute;sactiv&eacute;s';
$lng['serversettings']['deactivateddocroot']['description'] = 'Quand un utilisateur est d&eacute;sactiv&eacute;, ce dossier sera utilis&eacute; comme dossier racine pour le serveur Web. Laissez vide pour ne pas cr&eacute;er de vHost et ne rien afficher du tout lorsque l\'utilisateur est d&eacute;sactiv&eacute;.';

// ADDED IN 1.2.16-svn4

$lng['panel']['reset'] = 'Ignorer les changements';
$lng['admin']['accountsettings'] = 'Param&egrave;tres du compte';
$lng['admin']['panelsettings'] = 'Param&egrave;tres du panel';
$lng['admin']['systemsettings'] = 'Param&egrave;tres du syst&egrave;me';
$lng['admin']['webserversettings'] = 'Param&egrave;tres du serveur Web';
$lng['admin']['mailserversettings'] = 'Param&egrave;tres du serveur de Mail';
$lng['admin']['nameserversettings'] = 'Param&egrave;tres du serveur de Noms';
$lng['admin']['updatecounters'] = 'Recalculer les ressources utilis&eacute;es';
$lng['question']['admin_counters_reallyupdate'] = 'Etes-vous s&ucirc;r de vouloir recalculer les ressources utilis&eacute;es ?';
$lng['panel']['pathDescription'] = 'Si le dossier n\'existe pas, il sera cr&eacute;&eacute; automatiquement.';

// ADDED IN 1.2.16-svn6

$lng['mails']['trafficninetypercent']['mailbody'] = 'Bonjour {FIRSTNAME} {NAME},\n\nVous utilisez {TRAFFICUSED} Mo sur {TRAFFIC} Mo de votre quota de trafic.\nCe dernier est &agrave; plus de 90%.\n\nCordialement,\nL\'&eacute;quipe Froxlor.';
$lng['mails']['trafficninetypercent']['subject'] = 'Limite de trafic bient&ocirc;t atteinte.';
$lng['admin']['templates']['trafficninetypercent'] = 'E-mail de notification pour les utilisateurs, lorsque leur taux de trafic atteint plus de 90%.';
$lng['admin']['templates']['TRAFFIC'] = 'Sera remplac&eacute; par le taux de trafic qui a &eacute;t&eacute; attribu&eacute; &agrave; l\'utilisateur.';
$lng['admin']['templates']['TRAFFICUSED'] = 'Sera remplac&eacute; par le taux de trafic qui a &eacute;t&eacute; consomm&eacute; par l\'utilisateur.';

// ADDED IN 1.2.16-svn7

$lng['admin']['subcanemaildomain']['never'] = 'Jamais';
$lng['admin']['subcanemaildomain']['choosableno'] = 'A choisir, par d&eacute;faut : non';
$lng['admin']['subcanemaildomain']['choosableyes'] = 'A choisir, par d&eacute;faut : oui';
$lng['admin']['subcanemaildomain']['always'] = 'Toujours';
$lng['changepassword']['also_change_webalizer'] = 'Changer aussi le mot de passe des statistiques Webalizer ?';

// ADDED IN 1.2.16-svn8

$lng['serversettings']['mailpwcleartext']['title'] = 'Sauvegarder aussi les mots de passe des comptes e-mails de fa&ccedil;on d&eacute;crypter dans la base de donn&eacute;es';
$lng['serversettings']['mailpwcleartext']['description'] = 'Si cela est &agrave; Oui, tous les mots de passe seront aussi sauvegarder de fa&ccedil;on d&eacute;crypter dans la table mail_users (en texte clair pour toutes personnes qui auraient acc&egrave;s &agrave; la base de donn&eacute;es). Activer cette option, uniquement si vous en avez vraiment besoin !';
$lng['serversettings']['mailpwcleartext']['removelink'] = 'Cliquez ici pour retirer tous les mots de passe en texte clair de la base de donn&eacute;es.';
$lng['question']['admin_cleartextmailpws_reallywipe'] = 'Etes-vous s&ucirc;r de vouloir retirer tous les mots de passe en clairs des comptes e-mails de la table mail_users ? Cette action ne peut &ecirc;tre annul&eacute;e !';
$lng['admin']['configfiles']['overview'] = 'Aper&ccedil;u';
$lng['admin']['configfiles']['wizard'] = 'Assistant';
$lng['admin']['configfiles']['distribution'] = 'Distribution';
$lng['admin']['configfiles']['service'] = 'Service';
$lng['admin']['configfiles']['daemon'] = 'D&eacute;mon';
$lng['admin']['configfiles']['http'] = 'Serveur Web (HTTP)';
$lng['admin']['configfiles']['dns'] = 'Serveur de Noms (DNS)';
$lng['admin']['configfiles']['mail'] = 'Serveur de Mails (IMAP/POP3)';
$lng['admin']['configfiles']['smtp'] = 'Serveur de Mails (SMTP)';
$lng['admin']['configfiles']['ftp'] = 'Serveur FTP';
$lng['admin']['configfiles']['etc'] = 'Autres (Syst&egrave;me)';
$lng['admin']['configfiles']['choosedistribution'] = '-- Choisissez une distribution --';
$lng['admin']['configfiles']['chooseservice'] = '-- Choisissez un service --';
$lng['admin']['configfiles']['choosedaemon'] = '-- Choisissez un d&eacute;mon --';

// ADDED IN 1.2.16-svn10

$lng['serversettings']['ftpdomain']['title'] = 'Comptes FTP @domaine';
$lng['serversettings']['ftpdomain']['description'] = 'Les utilisateurs peuvent-ils cr&eacute;er des comptes FTP de la forme utilisateur@domaine.com ?';
$lng['panel']['back'] = 'Retour';

// ADDED IN 1.2.16-svn12

$lng['serversettings']['mod_log_sql']['title'] = 'Sauvegarder temporairement les logs dans la base de donn&eacute;es';
$lng['serversettings']['mod_log_sql']['description'] = 'Utiliser <a href="http://www.outoforder.cc/projects/apache/mod_log_sql/" title="mod_log_sql">mod_log_sql</a> pour sauvegarder temporairement les requ&egrave;tes Web.<br /><b>Cela &agrave; besoin d\'une configuration sp&eacute;cifique <a href="http://files.froxlor.org/docs/mod_log_sql/" title="mod_log_sql - documentation">d\'Apache</a> !</b>';
$lng['serversettings']['mod_fcgid']['title'] = 'Utiliser PHP par mod_fcgid / suexec';
$lng['serversettings']['mod_fcgid']['description'] = 'Utiliser mod_fcgid / suexec / libnss_mysql pour lancer PHP avec le compte correspondant &agrave; l\'utilisateur ?<br/><b>Cela &agrave; besoin d\'une configuration sp&eacute;cifique d\'Apache !</b>';
$lng['serversettings']['sendalternativemail']['title'] = 'Utiliser une adresse e-mail alternative';
$lng['serversettings']['sendalternativemail']['description'] = 'Envoyer le mot de passe du compte e-mail &agrave; une adresse diff&eacute;rents pour la cr&eacute;ation du compte e-mail ?';
$lng['emails']['alternative_emailaddress'] = 'Adresse e-mail alternative';
$lng['mails']['pop_success_alternative']['mailbody'] = 'Bonjour,\n\nVotre compte e-mail {EMAIL} a &eacute;t&eacute; correctement cr&eacute;&eacute;.\n\nVotre mot de passe est : {PASSWORD}.\n\nCeci est un message g&eacute;n&eacute;r&eacute; automatiquemenent, veuillez ne pas r&eacute;pondre &agrave; cet e-mail car il ne serait &ecirc;tre consulter.\n\nCordialement,\nL\'&eacute;quipe Froxlor.';
$lng['mails']['pop_success_alternative']['subject'] = 'Compte e-mail correctement cr&eacute;&eacute;';
$lng['admin']['templates']['pop_success_alternative'] = 'Message de bienvenue envoy&eacute; &agrave; l\'adresse e-mail alternative pour les nouveaux comptes e-mails';
$lng['admin']['templates']['EMAIL_PASSWORD'] = 'Remplacer par le mot de passe du compte POP3 / IMAP.';

// ADDED IN 1.2.16-svn13

$lng['error']['documentrootexists'] = 'Le dossier "%s" existe d&eacute;j&agrave; pour cet utilisateur. Veuillez le supprimer / d&eacute;placer avant de r&eacute;essayer l\'ajout de cet utilisateur.';

// ADDED IN 1.2.16-svn14

$lng['serversettings']['apacheconf_vhost']['title'] = 'Dossier / fichier de configuration des vHosts pour Apache';
$lng['serversettings']['apacheconf_vhost']['description'] = 'O&ucirc; doit &ecirc;tre stock&eacute; le fichier de configuration des vHosts ? Vous pouvez soit entrer le nom d\'un fichier (tous les vHosts dans un seul fichier), soit le nom d\'un dossier (chacun des vHosts dans un fichier s&eacute;par&eacute; du dossier).';
$lng['serversettings']['apacheconf_diroptions']['title'] = 'Fichier / dossier de configuration des options des dossiers pour Apache';
$lng['serversettings']['apacheconf_diroptions']['description'] = 'O&ucirc; doit &ecirc;tre stock&eacute; le fichier de configuration des options de dossiers ? Vous pouvez soit entrer le nom d\'un fichier (toutes les options des dossiers dans un seul fichier), soit le nom d\'un dossier (chacune des options de dossier dans un fichier s&eacute;par&eacute; du dossier).';
$lng['serversettings']['apacheconf_htpasswddir']['title'] = 'Dossier du fichier htpasswd pour Apache';
$lng['serversettings']['apacheconf_htpasswddir']['description'] = 'O&ucirc; doit &ecirc;tre stock&eacute; le fichier de configuration de protection des dossiers "htpasswd" pour Apache ?';

// ADDED IN 1.2.16-svn15

$lng['error']['formtokencompromised'] = 'La requ&egrave;te semble compromise. Pour des raisons de s&eacute;curit&eacute;, vous avez &eacute;t&eacute; d&eacute;connect&eacute;.';
$lng['serversettings']['mysql_access_host']['title'] = 'H&ocirc;tes de connexion MySQL';
$lng['serversettings']['mysql_access_host']['description'] = 'Une liste s&eacute;par&eacute;e par des virgules contenant la liste des h&ocirc;tes depuis lesquels les utilisateurs sont autoris&eacute;s &agrave; se connecter au serveur MySQL.';

// ADDED IN 1.2.18-svn1

$lng['admin']['ipsandports']['create_listen_statement'] = 'D&eacute;claration des ports d\'&eacute;coute';
$lng['admin']['ipsandports']['create_namevirtualhost_statement'] = 'D&eacute;claration des h&ocirc;tes virtuels "NameVirtualHost"';
$lng['admin']['ipsandports']['create_vhostcontainer'] = 'D&eacute;claration des conteneurs virtuels "vHost"';
$lng['admin']['ipsandports']['create_vhostcontainer_servername_statement'] = 'D&eacute;claration des noms d\'h&ocirc;tes "ServerName" dans les conteneurs virtuels "vHost"';

// ADDED IN 1.2.18-svn2

$lng['admin']['webalizersettings'] = 'Param&egrave;tres pour Webalizer';
$lng['admin']['webalizer']['normal'] = 'Normal';
$lng['admin']['webalizer']['quiet'] = 'Silencieux';
$lng['admin']['webalizer']['veryquiet'] = 'Aucune sortie';
$lng['serversettings']['webalizer_quiet']['title'] = 'Sortie Webalizer';
$lng['serversettings']['webalizer_quiet']['description'] = 'Verbosit&eacute; du programme Webalizer';

// ADDED IN 1.2.18-svn3

$lng['ticket']['admin_email'] = 'root@localhost';
$lng['ticket']['noreply_email'] = 'billets@froxlor';
$lng['admin']['ticketsystem'] = 'Syst&egrave;me de billets';
$lng['menue']['ticket']['ticket'] = 'Billets de support';
$lng['menue']['ticket']['categories'] = 'Cat&eacute;gories de support';
$lng['menue']['ticket']['archive'] = 'Archives de billets';
$lng['ticket']['description'] = 'Entrez une description !';
$lng['ticket']['ticket_new'] = 'Ouvrir un nouveau billet';
$lng['ticket']['ticket_reply'] = 'R&eacute;ponse au billet';
$lng['ticket']['ticket_reopen'] = 'R&eacute;ouvrir le billet';
$lng['ticket']['ticket_newcateory'] = 'Cr&eacute;er une nouvelle cat&eacute;gorie';
$lng['ticket']['ticket_editcateory'] = 'Editer la cat&eacute;gorie';
$lng['ticket']['ticket_view'] = 'Voir l\'historique du billet';
$lng['ticket']['ticketcount'] = 'Billets';
$lng['ticket']['ticket_answers'] = 'R&eacute;ponses';
$lng['ticket']['lastchange'] = 'Derni&egrave;re action';
$lng['ticket']['subject'] = 'Sujet';
$lng['ticket']['status'] = 'Etat';
$lng['ticket']['lastreplier'] = 'Derni&egrave;re r&eacute;ponse de';
$lng['ticket']['priority'] = 'Priorit&eacute;';
$lng['ticket']['low'] = 'Basse';
$lng['ticket']['normal'] = 'Normale';
$lng['ticket']['high'] = 'Haute';
$lng['ticket']['lastchange'] = 'Dernier changement';
$lng['ticket']['lastchange_from'] = 'Depuis (jj.mm.aaaa)';
$lng['ticket']['lastchange_to'] = 'Jusqu\'au (jj.mm.aaaa)';
$lng['ticket']['category'] = 'Cat&eacute;gorie';
$lng['ticket']['no_cat'] = 'Aucune';
$lng['ticket']['message'] = 'Message';
$lng['ticket']['show'] = 'Voir';
$lng['ticket']['answer'] = 'R&eacute;pondre';
$lng['ticket']['close'] = 'Fermer';
$lng['ticket']['reopen'] = 'R&eacute;ouvrir';
$lng['ticket']['archive'] = 'Archive';
$lng['ticket']['ticket_delete'] = 'Effacer le billet';
$lng['ticket']['lastarchived'] = 'Billets r&eacute;cemment archiv&eacute;s';
$lng['ticket']['archivedtime'] = 'Archiv&eacute;';
$lng['ticket']['open'] = 'Ouvert';
$lng['ticket']['wait_reply'] = 'Attente d\'une r&eacute;ponse';
$lng['ticket']['replied'] = 'R&eacute;pondu';
$lng['ticket']['closed'] = 'Ferm&eacute;';
$lng['ticket']['staff'] = 'L\'&eacute;quipe';
$lng['ticket']['customer'] = 'Client';
$lng['ticket']['old_tickets'] = 'Messages du billet';
$lng['ticket']['search'] = 'Rechercher dans les archives';
$lng['ticket']['nocustomer'] = 'Aucun choix';
$lng['ticket']['archivesearch'] = 'R&eacute;sultat de la recherche dans les archives';
$lng['ticket']['noresults'] = 'Aucun billet trouv&eacute;';
$lng['ticket']['notmorethanxopentickets'] = 'Pour &eacute;viter les abus, vous ne pouvez avoir plus de %s billets ouverts';
$lng['ticket']['supportstatus'] = 'Etat du support';
$lng['ticket']['supportavailable'] = '<span class="ticket_low">Nos &eacute;quipes de support sont disponibles et pr&egrave;tes &agrave; vous assister.</span>';
$lng['ticket']['supportnotavailable'] = '<span class="ticket_high">Nos &eacute;quipes de support ne sont actuellement pas disponibles.</span>';
$lng['admin']['templates']['ticket'] = 'E-mail de notification pour les billets de support';
$lng['admin']['templates']['SUBJECT'] = 'Sera remplac&eacute; par le sujet du billet de support.';
$lng['admin']['templates']['new_ticket_for_customer'] = 'Informe le client que le billet a &eacute;t&eacute; envoy&eacute;';
$lng['admin']['templates']['new_ticket_by_customer'] = 'Notifie l\'administrateur qu\'un nouveau billet a &eacute;t&eacute; ouvert par un client';
$lng['admin']['templates']['new_reply_ticket_by_customer'] = 'Notifie l\'administrateur d\'une r&eacute;ponse du client au billet';
$lng['admin']['templates']['new_ticket_by_staff'] = 'Informe le client qu\'un billet a &eacute;t&eacute; ouvert par l\'&eacute;quipe de support';
$lng['admin']['templates']['new_reply_ticket_by_staff'] = 'Informe le client d\'une r&eacute;ponse de l\'&eacute;quipe de support au billet';
$lng['mails']['new_ticket_for_customer']['mailbody'] = 'Bonjour {FIRSTNAME} {NAME},\n\nVotre demande de billet de support ayant comme sujet "{SUBJECT}" a &eacute;t&eacute; envoy&eacute;.\n\nVous receverez une notification lorsque votre billet aura une r&eacute;ponse.\n\nMerci,\nL\'&eacute;quipe Froxlor.';
$lng['mails']['new_ticket_for_customer']['subject'] = 'Votre billet de support a &eacute;t&eacute; envoy&eacute;';
$lng['mails']['new_ticket_by_customer']['mailbody'] = 'Bonjour administrateur,\n\nUn nouveau billet de support ayant comme sujet "{SUBJECT}" a &eacute;t&eacute; ouvert.\n\nVeuillez vous connecter pour consulter le billet.\n\nMerci,\nl\'&eacute;quipe Froxlor.';
$lng['mails']['new_ticket_by_customer']['subject'] = 'Nouveau billet de support soumis';
$lng['mails']['new_reply_ticket_by_customer']['mailbody'] = 'Bonjour administrateur,\n\nLe billet de support "{SUBJECT}" a re&ccedil;u une r&eacute;ponse de la part du client.\n\nVeuillez vous connecter pour consulter le billet.\n\nMerci,\nL\'&eacute;quipe Froxlor.';
$lng['mails']['new_reply_ticket_by_customer']['subject'] = 'Nouvelle r&eacute;ponse au billet de support';
$lng['mails']['new_ticket_by_staff']['mailbody'] = 'Bonjour {FIRSTNAME} {NAME},\n\nUn billet de support ayant comme sujet "{SUBJECT}" a &eacute;t&eacute; ouvert pour vous par notre &eacute;quipe.\n\nVeuillez vous connecter pour consulter le billet.\n\nMerci,\nL\'&eacute;quipe Froxlor.';
$lng['mails']['new_ticket_by_staff']['subject'] = 'Nouvelle demande de support soumise';
$lng['mails']['new_reply_ticket_by_staff']['mailbody'] = 'Bonjour {FIRSTNAME} {NAME},\n\nLe billet de support ayant comme sujet "{SUBJECT}" a re&ccedil;u une r&eacute;ponse par notre &eacute;quipe.\n\nVeuillez vous connecter pour consulter le billet.\n\nMerci,\nL\&eacute;quipe Froxlor.';
$lng['mails']['new_reply_ticket_by_staff']['subject'] = 'Nouvelle r&eacute;ponse au billet de support';
$lng['question']['ticket_reallyclose'] = 'Etes-vous s&ucirc;r de vouloir cl&ocirc;turer le billet "%s" ?';
$lng['question']['ticket_reallydelete'] = 'Etes-vous s&ucirc;r de vouloir supprimer le billet "%s" ?';
$lng['question']['ticket_reallydeletecat'] = 'Etes-vous s&ucirc;r de vouloir supprimer la cat&eacute;gorie "%s" ?';
$lng['question']['ticket_reallyarchive'] = 'Etes-vous s&ucirc;r de vouloir archiver le billet "%s" ?';
$lng['error']['mysubject'] = '"' . $lng['ticket']['subject'] . '"';
$lng['error']['mymessage'] = '"' . $lng['ticket']['message'] . '"';
$lng['error']['mycategory'] = '"' . $lng['ticket']['category'] . '"';
$lng['error']['nomoreticketsavailable'] = 'Vous n\'avez plus de billets de disponibles. Veuillez contacter votre administrateur.';
$lng['error']['nocustomerforticket'] = 'Ne peut cr&eacute;er de billet sans client';
$lng['error']['categoryhastickets'] = 'La cat&eacute;gorie poss&egrave;de des billets.<br />Veuillez d\'abord supprimer tous les billets de cette cat&eacute;gorie.';
$lng['error']['notmorethanxopentickets'] = $lng['ticket']['notmorethanxopentickets'];
$lng['admin']['ticketsettings'] = 'Param&egrave;tres des billets de support';
$lng['admin']['archivelastrun'] = 'Derniers billets archiv&eacute;s';
$lng['serversettings']['ticket']['noreply_email']['title'] = 'Adresse e-mail de non r&eacute;ponse';
$lng['serversettings']['ticket']['noreply_email']['description'] = 'L\'adresse e-mail de l\'exp&eacute;diteur de notification pour les billets de support, quelque chose du type no-reply@domaine.com';
$lng['serversettings']['ticket']['worktime_begin']['title'] = 'D&eacute;but du support (hh:mm)';
$lng['serversettings']['ticket']['worktime_begin']['description'] = 'Horaire de d&eacute;but du support';
$lng['serversettings']['ticket']['worktime_end']['title'] = 'Fin du support (hh:mm)';
$lng['serversettings']['ticket']['worktime_end']['description'] = 'Horaire de fin du support';
$lng['serversettings']['ticket']['worktime_sat'] = 'Support disponible le samedi ?';
$lng['serversettings']['ticket']['worktime_sun'] = 'Support disponible le dimanche ?';
$lng['serversettings']['ticket']['worktime_all']['title'] = 'Aucune limite horaire pour le support';
$lng['serversettings']['ticket']['worktime_all']['description'] = 'Si "Oui", les options pour le d&eacute;but et la fin du support seront &eacute;cras&eacute;s.';
$lng['serversettings']['ticket']['archiving_days'] = 'Apr&egrave;s combien de jours un billet ferm&eacute; sera automatiquement archiv&eacute; ?';
$lng['customer']['tickets'] = 'Billet de support';

// ADDED IN 1.2.18-svn4

$lng['admin']['domain_nocustomeraddingavailable'] = 'Il n\'est acutellement pas possible d\'ajouter de domaines. Vous devez d\'abord ajouter un client.';
$lng['serversettings']['ticket']['enable'] = 'Activer le syst&egrave;me de billets';
$lng['serversettings']['ticket']['concurrentlyopen'] = 'Combien  de billets peuvent &ecirc;tre ouverts au m&ecirc;me moment ?';
$lng['error']['norepymailiswrong'] = 'L\'adresse de "non r&eacute;ponse" n\'est pas bonne. Une adresse e-mail valide doit &ecirc;tre entr&eacute;e.';
$lng['error']['tadminmailiswrong'] = 'L\'adresse de "l\'administrateur de billets" n\'est pas bonne. Une adresse e-mail valide doit &ecirc;tre entr&eacute;e.';
$lng['ticket']['awaitingticketreply'] = 'Vous avez %s billet(s) de support non r&eacute;pondu(s).';

// ADDED IN 1.2.18-svn5

$lng['serversettings']['ticket']['noreply_name'] = 'Nom de l\'exp&eacute;diteur e-mail des billets';

// ADDED IN 1.2.19-svn1

$lng['serversettings']['mod_fcgid']['configdir']['title'] = 'Dossier de configuration FCGI';
$lng['serversettings']['mod_fcgid']['configdir']['description'] = 'O&ucirc; doivent &ecirc;tre stock&eacute;s les fichiers de configuration pour FCGI ?';
$lng['serversettings']['mod_fcgid']['tmpdir']['title'] = 'Dossier temporaire pour FCGI';

// ADDED IN 1.2.19-svn3

$lng['serversettings']['ticket']['reset_cycle']['title'] = 'Intervalle de r&eacute;initialisation des billets utilis&eacute;s';
$lng['serversettings']['ticket']['reset_cycle']['description'] = 'Remettre le compteur de billets &agrave; 0 dans le temps imparti';
$lng['admin']['tickets']['daily'] = 'Journali&egrave;re';
$lng['admin']['tickets']['weekly'] = 'Hebdomadaire';
$lng['admin']['tickets']['monthly'] = 'Mensuelle';
$lng['admin']['tickets']['yearly'] = 'Annuelle';
$lng['error']['ticketresetcycleiswrong'] = 'L\'intervalle de r&eacute;initialisation doit &ecirc;tre "journali&egrave;re", "hebdomadaire", "mensuelle" ou "annuelle".';

// ADDED IN 1.2.19-svn4

$lng['menue']['traffic']['traffic'] = 'Trafic';
$lng['menue']['traffic']['current'] = 'Mois actuel';
$lng['traffic']['month'] = 'Mois';
$lng['traffic']['day'] = 'Jour';
$lng['traffic']['months'][1] = 'Janvier';
$lng['traffic']['months'][2] = 'F&eacute;vrier';
$lng['traffic']['months'][3] = 'Mars';
$lng['traffic']['months'][4] = 'Avril';
$lng['traffic']['months'][5] = 'Mai';
$lng['traffic']['months'][6] = 'Juin';
$lng['traffic']['months'][7] = 'Juillet';
$lng['traffic']['months'][8] = 'Ao&ucirc;t';
$lng['traffic']['months'][9] = 'Septembre';
$lng['traffic']['months'][10] = 'Octobre';
$lng['traffic']['months'][11] = 'Novembre';
$lng['traffic']['months'][12] = 'D&eacute;cembre';
$lng['traffic']['mb'] = 'Trafic (Mo)';
$lng['traffic']['distribution'] = '<font color="#019522">FTP</font> | <font color="#0000FF">HTTP</font> | <font color="#800000">E-mail</font>';
$lng['traffic']['sumhttp'] = 'Trafic HTTP total entrant';
$lng['traffic']['sumftp'] = 'Trafic FTP total entrant';
$lng['traffic']['summail'] = 'Trafic E-mail total entrant';

// ADDED IN 1.2.19-svn4.5

$lng['serversettings']['no_robots']['title'] = 'Permettre aux robots des moteurs de recherche d\'indexer l\'installation de Froxlor';

// ADDED IN 1.2.19-svn6

$lng['admin']['loggersettings'] = 'Param&egrave;tres des logs';
$lng['serversettings']['logger']['enable'] = 'Activer / D&eacute;sactiver les logs';
$lng['serversettings']['logger']['severity'] = 'Niveau de log';
$lng['admin']['logger']['normal'] = 'normal';
$lng['admin']['logger']['paranoid'] = 'paranoïaque';
$lng['serversettings']['logger']['types']['title'] = 'Type(s) de log';
$lng['serversettings']['logger']['types']['description'] = 'Sp&eacute;cifiez les types de log s&eacute;par&eacute;s par des virgules.<br />Les types de log disponible sont : syslog, file, mysql';
$lng['serversettings']['logger']['logfile'] = 'Nom du fichier de log, dossier + nom du fichier';
$lng['error']['logerror'] = 'Erreur log : %s';
$lng['serversettings']['logger']['logcron'] = 'Loguer les travaux de cron (lancer une fois)';
$lng['question']['logger_reallytruncate'] = 'Etes-vous s&ucirc;r de vouloir vider la table "%s" ?';
$lng['admin']['loggersystem'] = 'Log syst&egrave;me';
$lng['menue']['logger']['logger'] = 'Log syst&egrave;me';
$lng['logger']['date'] = 'Date';
$lng['logger']['type'] = 'Type';
$lng['logger']['action'] = 'Action';
$lng['logger']['user'] = 'Utilisateur';
$lng['logger']['truncate'] = 'Vider les logs';

// ADDED IN 1.2.19-svn7

$lng['serversettings']['ssl']['use_ssl'] = 'Utiliser SSL ?';
$lng['serversettings']['ssl']['ssl_cert_file'] = 'O&ucirc; est situ&eacute; le fichier de certificat ?';
$lng['serversettings']['ssl']['openssl_cnf'] = 'Param&egrave;tres par d&eacute;faut pour cr&eacute;er le certificat';
$lng['panel']['reseller'] = 'revendeur';
$lng['panel']['admin'] = 'administrateur';
$lng['panel']['customer'] = 'client(s)';
$lng['error']['nomessagetosend'] = 'Vous n\'avez pas entr&eacute; de message.';
$lng['error']['noreceipientsgiven'] = 'Vous n\'avez pas sp&eacute;cifier de destinataire';
$lng['admin']['emaildomain'] = 'Domaine e-mail';
$lng['admin']['email_only'] = 'Seulement des e-mails ?';
$lng['admin']['wwwserveralias'] = 'Ajouter un "www." &agrave; l\'alias du serveur "ServerAlias"';
$lng['admin']['ipsandports']['enable_ssl'] = 'Est-ce un port SSL ?';
$lng['admin']['ipsandports']['ssl_cert_file'] = 'Emplacement du certificat SSL';
$lng['panel']['send'] = 'envoy&eacute;';
$lng['admin']['subject'] = 'Sujet';
$lng['admin']['receipient'] = 'Destinataire';
$lng['admin']['message'] = 'Ecrire un message';
$lng['admin']['text'] = 'Message';
$lng['menu']['message'] = 'Messages';
$lng['error']['errorsendingmail'] = 'Echec d\'envoi du message &agrave; "%s"';
$lng['error']['cannotreaddir'] = 'Impossible de lire dossier "%s"';
$lng['message']['success'] = 'Le message a &eacute;t&eacute; envoy&eacute; aux destinataires "%s"';
$lng['message']['noreceipients'] = 'Aucun e-mail n\'a &eacute;t&eacute; envoy&eacute; car il n\'existe aucun destinataire dans la base de donn&eacute;es';
$lng['admin']['sslsettings'] = 'Param&egrave;tres SSL';
$lng['cronjobs']['notyetrun'] = 'Pas encore lanc&eacute;';
$lng['install']['servername_should_be_fqdn'] = 'Le nom du serveur doit &ecirc;tre un nom FQDN, pas une adresse IP';
$lng['serversettings']['default_vhostconf']['title'] = 'Param&egrave;tres par d&eacute;faut pour les vHosts';
$lng['emails']['quota'] = 'Quota';
$lng['emails']['noquota'] = 'Pas de quota';
$lng['emails']['updatequota'] = 'Mise &agrave; jour';
$lng['serversettings']['mail_quota']['title'] = 'Quota de la bo&icirc;te aux lettres';
$lng['serversettings']['mail_quota']['description'] = 'Quota par d&eacute;faut pour toutes nouvelles bo&icirc;tes aux lettres cr&eacute;&eacute;es.';
$lng['serversettings']['mail_quota_enabled']['title'] = 'Utiliser les quotas de bo&icirc;tes aux lettres pour les clients';
$lng['serversettings']['mail_quota_enabled']['description'] = 'Activez cette option pour utiliser les quotas sur les bo&icirc;tes aux lettres. Par d&eacute;faut, cette option est &agrave; <b>Non</b> car cela requiert une configuration sp&eacute;cifique.';
$lng['serversettings']['mail_quota_enabled']['removelink'] = 'Cliquez ici pour retirer tous les quotas de tous les comptes e-mails.';
$lng['question']['admin_quotas_reallywipe'] = 'Etes-vous s&ucirc;r de vouloir retirer tous les quotas de la table mail_users ? Cette action ne peut &ecirc;tre annul&eacute;e !';
$lng['error']['vmailquotawrong'] = 'La taille du quota doit &ecirc;tre entre 1 et 999';
$lng['customer']['email_quota'] = 'Quota e-mail';
$lng['customer']['email_imap'] = 'E-mail IMAP';
$lng['customer']['email_pop3'] = 'E-mail POP3';
$lng['customer']['mail_quota'] = 'Quota e-mail';
$lng['error']['invalidip'] = 'Adresse IP invalide : %s';
$lng['serversettings']['decimal_places'] = 'Nombre de d&eacute;cimales &agrave; afficher pour le trafic / espace web';

// ADDED IN 1.2.19-svn8

$lng['admin']['dkimsettings'] = 'Param&egrave;tres DKIM';
$lng['dkim']['dkim_prefix']['title'] = 'Prefix DKIM';
$lng['dkim']['dkim_prefix']['description'] = 'Veuillez entrer l\'emplacement des fichiers RSA pour DKIM ainsi que l\'emplacement du fichier de configuration pour le plugin Milter';
$lng['dkim']['dkim_domains']['title'] = 'Nom du fichier DKIM';
$lng['dkim']['dkim_domains']['description'] = '<strong>Nom du fichier</strong> des param&egrave;tres DKIM pour les domaines tel que entr&eacute; dans la configuration de DKIM-milter';
$lng['dkim']['dkim_dkimkeys']['title'] = 'Nom du fichier des clefs DKIM';
$lng['dkim']['dkim_dkimkeys']['description'] = '<strong>Nom du fichier</strong> des param&egrave;tres des clefs DKIM tel que entr&eacute; dans la configuration de DKIM-milter';
$lng['dkim']['dkimrestart_command']['title'] = 'Commande de red&eacute;marrage de DKIM-milter';
$lng['dkim']['dkimrestart_command']['description'] = 'Veuillez entrer la commande de red&eacute;marrage du service DKIM-milter';

// ADDED IN 1.2.19-svn9

$lng['admin']['caneditphpsettings'] = 'Peut changer les param&eacute;tres PHP du domaine ?';

// ADDED IN 1.2.19-svn12

$lng['admin']['allips'] = 'Toutes les adresses IP';
$lng['panel']['nosslipsavailable'] = 'Il n\'y a actuellement aucune combinaison IP / Port configurer pour SSL';
$lng['ticket']['by'] = 'de ';
$lng['dkim']['use_dkim']['title'] = 'Activer le support DKIM ?';
$lng['dkim']['use_dkim']['description'] = 'Voulez-vous utiliser le syst&egrave;me DKIM (DomainKeys Identified Mail) ?';
$lng['error']['invalidmysqlhost'] = 'Adresse h&ocirc;te MySQL invalide : "%s"';
$lng['error']['cannotuseawstatsandwebalizeratonetime'] = 'Vous ne pouvez pas activer AWStats <u>et</u> Webalizer en m&ecirc;me temps. Veuillez n\'en choisir qu\'un seul.';
$lng['serversettings']['webalizer_enabled'] = 'Activer les statistiques Webalizer';
$lng['serversettings']['awstats_enabled'] = 'Activer les statistiques AWStats';
$lng['admin']['awstatssettings'] = 'Param&egrave;tres Awstats';

// ADDED IN 1.2.19-svn16

$lng['admin']['domain_dns_settings'] = 'Param&egrave;tres DNS';
$lng['dns']['destinationip'] = 'IP du domaine';
$lng['dns']['standardip'] = 'IP standard du serveur';
$lng['dns']['a_record'] = 'Enregistrement de type "A" (IPv6 optionnel)';
$lng['dns']['cname_record'] = 'Enregistrement CNAME';
$lng['dns']['mxrecords'] = 'D&eacute;finition des enregistrements MX';
$lng['dns']['standardmx'] = 'Enregistrements MX standard du serveur';
$lng['dns']['mxconfig'] = 'Enregistrements MX personnalis&eacute;';
$lng['dns']['priority10'] = 'Priorit&eacute; 10';
$lng['dns']['priority20'] = 'Priorit&eacute; 20';
$lng['dns']['txtrecords'] = 'D&eacute;finir des enregistrement TXT';
$lng['dns']['txtexample'] = 'Exemple (pour SPF) :<br />v=spf1 ip4:xxx.xxx.xx.0/23 -all';
$lng['serversettings']['selfdns']['title'] = 'Param&egrave;tres manuel des DNS du domaine';
$lng['serversettings']['selfdnscustomer']['title'] = 'Permettre aux clients de modifier les param&egrave;tes DNS du domaine';
$lng['admin']['activated'] = 'Activ&eacute;';
$lng['admin']['statisticsettings'] = 'Param&egrave;tres des statistiques';
$lng['admin']['or'] = 'ou';

// ADDED IN 1.2.19-svn17

$lng['serversettings']['unix_names']['title'] = 'Utiliser des noms d\'utilisateurs compatible UNIX';
$lng['serversettings']['unix_names']['description'] = 'Vous permet d\'utiliser les <strong>-</strong> et <strong>_</strong> dans les noms d\'utilisateurs si l\'option est &agrave; <strong>Non</strong>';
$lng['error']['cannotwritetologfile'] = 'Ne peut ouvrir le fichier de log %s en &eacute;criture';
$lng['admin']['sysload'] = 'Charge du syst&egrave;me';
$lng['admin']['noloadavailable'] = 'Non disponible';
$lng['admin']['nouptimeavailable'] = 'Non disponible';
$lng['panel']['backtooverview'] = 'Retour &agrave; l\'aper&ccedil;u';
$lng['admin']['nosubject'] = '(Aucun sujet)';
$lng['admin']['configfiles']['statistics'] = 'Statistiques';
$lng['login']['forgotpwd'] = 'Mot de passe oubli&eacute; ?';
$lng['login']['presend'] = 'R&eacute;initialiser le mot de passe';
$lng['login']['email'] = 'Adresse e-mail';
$lng['login']['remind'] = 'R&eacute;initialiser mon mot de passe';
$lng['login']['usernotfound'] = 'Erreur : utilisateur inconnu !';
$lng['pwdreminder']['subject'] = 'Froxlor - r&eacute;initialisation du mot de passe';
$lng['pwdreminder']['body'] = 'Bonjour %s,\n\nVotre mot de passe pour Froxlor a &eacute;t&eacute; r&eacute;initialiser !\nLe nouveau mot de passe est : %p\n\nCordialement,\nL\'&eacute;quipe Froxlor.';
$lng['pwdreminder']['success'] = 'Mot de passe correctement r&eacute;initialiser.<br />Vous devriez recevoir un e-mail avec votre nouveau mot de passe d\'ici quelques minutes.';

// ADDED IN 1.2.19-svn18

$lng['serversettings']['allow_password_reset']['title'] = 'Permettre aux clients de r&eacute;initialiser leurs mots de passe';
$lng['pwdreminder']['notallowed'] = 'La r&eacute;initialisation des mots de passe est d&eacute;sactiv&eacute;e.';

// ADDED IN 1.2.19-svn21

$lng['customer']['title'] = 'Titre';
$lng['customer']['country'] = 'Pays';
$lng['panel']['dateformat'] = 'YYYY-MM-DD';
$lng['panel']['dateformat_function'] = 'Y-m-d';

// Y = Year, m = Month, d = Day

$lng['panel']['timeformat_function'] = 'H:i:s';

// H = Hour, i = Minute, s = Second

$lng['panel']['default'] = 'Par d&eacute;faut';
$lng['panel']['never'] = 'Jamais';
$lng['panel']['active'] = 'Actif';
$lng['panel']['please_choose'] = 'Veuillez choisir';
$lng['domains']['add_date'] = 'Ajouter &agrave; Froxlor';
$lng['domains']['registration_date'] = 'Ajouter &agrave; l\'enregistrement';

// ADDED IN 1.2.19-svn22

$lng['serversettings']['allow_password_reset']['description'] = 'Les clients peuvent r&eacute;initialiser leurs mots de passe et il sera envoy&eacute; &agrave; leurs propres adresses e-mails';
$lng['serversettings']['allow_password_reset_admin']['title'] = 'Permettre la r&eacute;initialisation des mots de passe par les administrateurs';
$lng['serversettings']['allow_password_reset_admin']['description'] = 'Les administrateurs / revendeurs peuvent r&eacute;initialiser leurs mots de passe et il sera envoy&eacute; &agrave; leurs propres adresses e-mails';

?>
