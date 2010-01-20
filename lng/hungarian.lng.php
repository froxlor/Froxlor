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
 * @author     Laszlo (Laci) Puchner <puchnerl@konyvbroker.hu>
 * @license    GPLv2 http://files.syscp.org/misc/COPYING.txt
 * @package    Language
 * @version    $Id: hungarian.lng.php 2692 2009-03-27 18:04:47Z flo $
 */

/**
 * Global
 */

$lng['translator'] = 'Puchner L&aacute;szl&oacute;';
$lng['panel']['edit'] = 'szerkeszt';
$lng['panel']['delete'] = 't&ouml;r&ouml;l';
$lng['panel']['create'] = 'l&eacute;trehoz';
$lng['panel']['save'] = 'ment';
$lng['panel']['yes'] = 'igen';
$lng['panel']['no'] = 'nem';
$lng['panel']['emptyfornochanges'] = 'v&aacute;ltoztat&aacute;sig &uuml;res';
$lng['panel']['emptyfordefault'] = 'alap&eacute;rtelmez&eacute;sben &uuml;res';
$lng['panel']['path'] = '&Uacute;tvonal';
$lng['panel']['toggle'] = '&Aacute;tkapcsol';
$lng['panel']['next'] = 'k&ouml;vetkez&#337;';
$lng['panel']['dirsmissing'] = 'K&ouml;nyvt&aacute;r nem tal&aacute;lhat&oacute; vagy nem olvashat&oacute;!';

/**
 * Login
 */

$lng['login']['username'] = 'Felhaszn&aacute;l&oacute;n&eacute;v';
$lng['login']['password'] = 'Jelsz&oacute;';
$lng['login']['language'] = 'Nyelv';
$lng['login']['login'] = 'Bejelentkez&eacute;s';
$lng['login']['logout'] = 'Kijelentkez&eacute;s';
$lng['login']['profile_lng'] = 'Profile nyelve';

/**
 * Customer
 */

$lng['customer']['documentroot'] = 'Kezd&#337;k&ouml;nyvt&aacute;r';
$lng['customer']['name'] = 'N&eacute;v';
$lng['customer']['firstname'] = 'Keresztn&eacute;v';
$lng['customer']['company'] = 'C&eacute;gn&eacute;v';
$lng['customer']['street'] = 'Utca';
$lng['customer']['zipcode'] = 'Ir&aacute;ny&iacute;t&oacute;sz&aacute;m';
$lng['customer']['city'] = 'Telep&uuml;l&eacute;s';
$lng['customer']['phone'] = 'Telefon';
$lng['customer']['fax'] = 'Fax';
$lng['customer']['email'] = 'E-mail';
$lng['customer']['customernumber'] = 'Felhaszn&aacute;l&oacute;-azonos&iacute;t&oacute;';
$lng['customer']['diskspace'] = 'T&aacute;rhely (MB)';
$lng['customer']['traffic'] = 'Forgalom (GB)';
$lng['customer']['mysqls'] = 'MySQL-Adatb&aacute;zis';
$lng['customer']['emails'] = 'E-mail c&iacute;mek';
$lng['customer']['accounts'] = 'E-mail fi&oacute;kok';
$lng['customer']['forwarders'] = 'E-mail tov&aacute;bb&iacute;t&oacute;k';
$lng['customer']['ftps'] = 'FTP fi&oacute;kok';
$lng['customer']['subdomains'] = 'Aldomain(ek)';
$lng['customer']['domains'] = 'Domain(ek)';
$lng['customer']['unlimited'] = 'korl&aacute;tlan';

/**
 * Customermenue
 */

$lng['menue']['main']['main'] = 'F&#337;men&uuml;';
$lng['menue']['main']['changepassword'] = 'Jelsz&oacute;csere';
$lng['menue']['main']['changelanguage'] = 'Nyelv-v&aacute;ltoztat&aacute;s';
$lng['menue']['email']['email'] = 'E-mail';
$lng['menue']['email']['emails'] = 'C&iacute;mek';
$lng['menue']['email']['webmail'] = 'WebMail';
$lng['menue']['mysql']['mysql'] = 'MySQL';
$lng['menue']['mysql']['databases'] = 'Adatb&aacute;zisok';
$lng['menue']['mysql']['phpmyadmin'] = 'phpMyAdmin';
$lng['menue']['domains']['domains'] = 'Domainek';
$lng['menue']['domains']['settings'] = 'Be&aacute;ll&iacute;t&aacute;sok';
$lng['menue']['ftp']['ftp'] = 'FTP';
$lng['menue']['ftp']['accounts'] = 'Fi&oacute;kok';
$lng['menue']['ftp']['webftp'] = 'WebFTP';
$lng['menue']['extras']['extras'] = 'Extr&aacute;k';
$lng['menue']['extras']['directoryprotection'] = 'K&ouml;nyvt&aacute;rv&eacute;delem';
$lng['menue']['extras']['pathoptions'] = '&Uacute;tvonal opci&oacute;k';

/**
 * Index
 */

$lng['index']['customerdetails'] = 'Felhaszn&aacute;l&oacute;i adatok';
$lng['index']['accountdetails'] = 'Fi&oacute;k adatok';

/**
 * Change Password
 */

$lng['changepassword']['old_password'] = 'R&eacute;gi jelsz&oacute;';
$lng['changepassword']['new_password'] = '&Uacute;j jelsz&oacute;';
$lng['changepassword']['new_password_confirm'] = '&Uacute;j jelsz&oacute; (meger&#337;s&iacute;t&eacute;s)';
$lng['changepassword']['new_password_ifnotempty'] = '&Uacute;j jelsz&oacute; (&uuml;res = nem v&aacute;ltozik)';
$lng['changepassword']['also_change_ftp'] = ' a f&#337; FTP fi&oacute;k jelszav&aat is megv&aacute;ltoztatja';

/**
 * Domains
 */

$lng['domains']['description'] = 'Itt hozhat l&eacute;tre (al-)domaineket &eacute;s megv&aacute;ltoztathatja azok &uacute;tvonalait.<br />A rendszernek minden v&aacute;ltoztat&aacute;s ut&aacute;n sz&uuml;ks&eacute;ge van n&eacute;mi id&#337;re, m&iacute;g az &uacute;j be&aacute;ll&iacute;t&aacute;sokat &eacute;rv&eacute;nyes&iacute;ti.';
$lng['domains']['domainsettings'] = 'Domain be&aacute;ll&iacute;t&aacute;sok';
$lng['domains']['domainname'] = 'Domain név';
$lng['domains']['subdomain_add'] = '(Al-)domain l&eacute;trehoz&aacute;sa';
$lng['domains']['subdomain_edit'] = '(Al-)domain szerkeszt&eacute;se';
$lng['domains']['wildcarddomain'] = 'Helyettes&iacute;t&#337;k&eacute;nt hozza l&eacute;tre?';
$lng['domains']['aliasdomain'] = 'Domain alias (&aacute;ln&eacute;v)';
$lng['domains']['noaliasdomain'] = 'Nincs domain alias (&aacute;ln&eacute;v)';

/**
 * E-mails
 */

$lng['emails']['description'] = 'Itt hozhatja l&eacute;tre &eacute;s m&oacute;dos&iacute;thatja e-mail c&iacute;meit.<br />Egy fi&oacute;k olyan, mint az &Ouml;n postal&aacute;d&aacute;ja a h&aacute;z el&#337;tt. Ha valaki k&uuml;ld  &Ouml;nnek egy e-mailt, az a postal&aacute;d&aacute;ba &eacute;rkezik meg.<br /><br />Az e-mailek let&ouml;lt&eacute;s&eacute;hez &aacute;ll&iacute;sa be levelez&#337;-programj&aacute;t az al&aacute;bbiak szerint: (A <i>d&#337;ltbet&#369;s</i> adatokat v&aacute;ltoztassa meg azok alapj&aacute;n, amelyeket be&iacute;rt!)<br />Szerver (host) neve: <b><i>Domain n&eacute;v</i></b><br />felhaszn&aacute;l&oacute;n&eav: <b><i>Postafi&oacute;k neve / e-mail c&iacute;m</i></b><br />Jelsz&oacute;: <b><i>A jelsz&oacute;, amelyet v&aacute;lasztott</i></b>';
$lng['emails']['emailaddress'] = 'E-mail c&iacute;m';
$lng['emails']['emails_add'] = 'E-mail c&iacute;m l&eacute;trehoz&aacute;sa';
$lng['emails']['emails_edit'] = 'E-mail c&iacute;m szerkeszt&eacute;se';
$lng['emails']['catchall'] = 'Gy&#369;jt&#337;';
$lng['emails']['iscatchall'] = 'Be&aacute;ll&iacute;tja  gy&#369;jt&#337; c&iacute;mk&eacute;nt?';
$lng['emails']['account'] = 'Fi&oacute;k';
$lng['emails']['account_add'] = 'Fi&oacute;k l&eacute;trehoz&aacute;sa';
$lng['emails']['account_delete'] = 'Fi&oacute;k t&ouml;rl&eacute;se';
$lng['emails']['from'] = 'Felad&oacute;';
$lng['emails']['to'] = 'C&iacute;m';
$lng['emails']['forwarders'] = 'Tov&aacute;bb&iacute;t&oacute;k';
$lng['emails']['forwarder_add'] = 'Tov&aacute;bb&iacute;t&oacute; l&eacute;trehoz&aacute;sa';

/**
 * FTP
 */

$lng['ftp']['description'] = 'Itt hozhatja l&eacute;tre &eacute;s m&oacute;dos&iacute;thatja FTP fi&oacute;kjait.<br />A v&aacute;ltoz&aacute;sok azonnal &eacute;rv&eacute;nybe l&eacute;pnek &eacute;s haszn&aacute;lhat&oacute;k.';
$lng['ftp']['account_add'] = 'Fi&oacute;k l&eacute;trehoz&aacute;sa';

/**
 * MySQL
 */

$lng['mysql']['databasename'] = 'felhaszn&aacute;l&oacute;/adatb&aacute;zis neve';
$lng['mysql']['databasedescription'] = 'adatb&aacute;zis le&iacute;r&aacute;sa';
$lng['mysql']['database_create'] = 'Adatb&aacute;zis l&eacute;trehoz&aacute;sa';

/**
 * Extras
 */

$lng['extras']['description'] = 'Itt &aacute;ll&iacute;that be egyebeket, pl. k&ouml;nyvt&aacute;rv&eacute;delmet.<br />A rendszernek minden v&aacute;ltoztat&aacute;s ut&aacute;n sz&uuml;ks&eacute;ge van n&eacute;mi id&#337;re, m&iacute;g az &uacute;j be&aacute;ll&iacute;t&aacute;sokat &eacute;rv&eacute;nyes&iacute;ti.';
$lng['extras']['directoryprotection_add'] = 'K&ouml;nyvt&aacute;rv&eacute;delem hozz&aacute;ad&aacute;sa';
$lng['extras']['view_directory'] = 'A k&ouml;nyvt&aacute;r tartalm&aacute;nak megmutat&aacute;sa';
$lng['extras']['pathoptions_add'] = '&Uacute;tvonal opci&oacute;k hozz&aacute;ad&aacute;sa';
$lng['extras']['directory_browsing'] = 'A k&ouml;nyvt&aacute;r tartalm&aacute;na b&ouml;ng&eacute;sz&eacute;se';
$lng['extras']['pathoptions_edit'] = '&Uacute;tvonal opci&oacute;k szerkeszt&eacute;se';
$lng['extras']['error404path'] = '404';
$lng['extras']['error403path'] = '403';
$lng['extras']['error500path'] = '500';
$lng['extras']['error401path'] = '401';
$lng['extras']['errordocument404path'] = 'A 404-es hiba&uuml;zenet URL-je';
$lng['extras']['errordocument403path'] = 'A 403-as hiba&uuml;zenet URL-je';
$lng['extras']['errordocument500path'] = 'A 500-as hiba&uuml;zenet URL-je';
$lng['extras']['errordocument401path'] = 'A 401-es hiba&uuml;zenet URL-je';

/**
 * Errors
 */

$lng['error']['error'] = 'Hiba';
$lng['error']['directorymustexist'] = 'L&eacute;teznie kell a %s k&ouml;nyvt&aacute;rnak. K&eacute;rem, hozza l&eacute;tre FTP cliens&eacute;vel.';
$lng['error']['filemustexist'] = 'L&eacute;teznie kell a %sf&aacute;jlnak.';
$lng['error']['allresourcesused'] = '&Ouml;n m&aacute;r minden er&#337;forr&aacute;s&aacute;t felhaszn&aacute;lta.';
$lng['error']['domains_cantdeletemaindomain'] = 'Nem t&ouml;r&ouml;lhet le olyan domain nevet, amelyet e-mail domaink&eacute;nt haszn&aacute;lnak.';
$lng['error']['domains_canteditdomain'] = 'Nem szerkeszthati ezt a domain nevet. Az adminisztr&aacute;tor letiltotta.';
$lng['error']['domains_cantdeletedomainwithemail'] = 'Nem t&ouml;r&ouml;lhet le olyan domain nevet, amelyet e-mail domaink&eacute;nt haszn&aacute;lnak. T&ouml;r&ouml;lj&ouml;n ki minden e-mail c&iacute;met el&#337;bb.';
$lng['error']['firstdeleteallsubdomains'] = 'Miel&#337;tt l&eacute;trehozna egy gy&#369;jt&#337;-domaint, t&ouml;r&ouml;lnie kell az &ouml;sszes al-domaint.';
$lng['error']['youhavealreadyacatchallforthisdomain'] = '&Ouml;n m&aacute;r meghat&aacute;rozott egy gy&#369;jt&#337;t erre a domain-re.';
$lng['error']['ftp_cantdeletemainaccount'] = 'Nem t&ouml;r&ouml;lheti f&#337; FTP hozz&aacute;f&eacute;r&eacute;s&eacute;t.';
$lng['error']['login'] = 'Helytelen a felhaszn&aacute;l&oacute;n&eacute;v vagy a jelsz&oacute;, amelyet beg&eacute;pelt. K&eacute;rem, pr&oacute;b&aacute;lja &uacute;jra!';
$lng['error']['login_blocked'] = 'Ezt a hozz&aacute;f&eacute;r&eacute;s fel lett f&uuml;ggesztve a t&uacute;l sok bejelentkez&eacute;si hiba miatt. K&eacute;rem, pr&oacute;b&aacute;lja &uacute;jra!';
$settings['login']['deactivatetime'] . ' seconds.';
$lng['error']['notallreqfieldsorerrors'] = 'Nem teljesen vagy helytelen&uuml;l t&ouml;lt&ouml;tte ki a mez&#337;ket.';
$lng['error']['oldpasswordnotcorrect'] = 'A r&eacute;gi jelsz&oacute; helytelen.';
$lng['error']['youcantallocatemorethanyouhave'] = 'Nem oszthat ki t&ouml;bb er&#337;forr&aacute;st, mint amennyit birtokol.';
$lng['error']['mustbeurl'] = 'Nem teljes vagy nem &eacute;rv&eacute;nyes URL-t (pl.: http://somedomain.com/error404.htm) g&eacute;pelt be';
$lng['error']['invalidpath'] = 'Nem v&aacute;lasztott ki &eacute;rv&eacute;nyes URL-t  (lehet, hogy probl&eacute;ma van a k&ouml;nyvt&aacute;rlist&aacute;z&aacute;ssal?).';
$lng['error']['stringisempty'] = 'A mez&#337;ben nincs adat.';
$lng['error']['stringiswrong'] = 'A mez&#337;ben helytelen adat van.';
$lng['error']['myloginname'] = '\'' . $lng['login']['username'] . '\'';
$lng['error']['mypassword'] = '\'' . $lng['login']['password'] . '\'';
$lng['error']['oldpassword'] = '\'' . $lng['changepassword']['old_password'] . '\'';
$lng['error']['newpassword'] = '\'' . $lng['changepassword']['new_password'] . '\'';
$lng['error']['newpasswordconfirm'] = '\'' . $lng['changepassword']['new_password_confirm'] . '\'';
$lng['error']['newpasswordconfirmerror'] = 'Az &uacute;j jelsz&oacute; &eacute;s annak meger&#337;s&iacute;t&eacute;se nem egyezik meg.';
$lng['error']['myname'] = '\'' . $lng['customer']['name'] . '\'';
$lng['error']['myfirstname'] = '\'' . $lng['customer']['firstname'] . '\'';
$lng['error']['emailadd'] = '\'' . $lng['customer']['email'] . '\'';
$lng['error']['mydomain'] = '\'Domain\'';
$lng['error']['mydocumentroot'] = '\'Dokumentum &uacute;tvonal\'';
$lng['error']['loginnameexists'] = 'A(z) %s felhaszn&aacute;l&oacute;n&eacute;v m&aacute;r l&eacute;tezik';
$lng['error']['emailiswrong'] = 'A(z) %s e-mail c&iacute;m &eacute;rv&eacute;nytelen karaktereket tartalmaz vagy nem teljes.';
$lng['error']['loginnameiswrong'] = 'A(z) %s felhaszn&aacute;l&oacute;n&eacute;v &eacute;rv&eacute;nytelen karaktereket tartalmaz.';
$lng['error']['userpathcombinationdupe'] = 'A felhaszn&aacute;l&oacute;n&eacute;v &eacute;s &uacute;tvonal kombin&aacute;ci&oacute;ja m&aacute;r l&eacute;tezik.';
$lng['error']['patherror'] = '&Aacute;ltal&aacute;nos hiba! Az &uacute;tvonal nem lehet &uuml;res.';
$lng['error']['errordocpathdupe'] = 'A(z) %s &uacute;tvonalra vonatkoz&oacute; opci&oacute; m&aacute;r l&eacute;tezik.';
$lng['error']['adduserfirst'] = 'K&eacute;rem, el&#337;bb hozzon l&eacute;tre egy felhaszn&aacute;l&oacute;t!';
$lng['error']['domainalreadyexists'] = 'A(z) %s domain n&eacute;v m&aacute;r hozz&aacute; van rendelve egy felhaszn&aacute;l&oacute;hoz.';
$lng['error']['nolanguageselect'] = 'Nincs kiv&aacute;lasztott nyelv.';
$lng['error']['nosubjectcreate'] = 'Meg kell hat&aacute;roznia egy t&aacute;rgyat ehhez a sablonhoz.';
$lng['error']['nomailbodycreate'] = 'Meg kell hat&aacute;roznia az &uuml;zenet sz&ouml;veg&eacute;t ehhez a sablonhoz.';
$lng['error']['templatenotfound'] = 'A sablon nem tal&aacute;lhat&oacute;.';
$lng['error']['alltemplatesdefined'] = 'Nem k&eacute;sz&iacute;thet t&ouml;bb sablont, m&aacute;r minden nyelv t&aacute;mogatva van.';
$lng['error']['wwwnotallowed'] = 'a www el&#337;tag  al-domainekn&eacute;l nem haszn&aacute;lhat&oacute;.';
$lng['error']['subdomainiswrong'] = 'A(z) %s al-domain &eacute;rv&eacute;nytelen karaktereket tartalmaz.';
$lng['error']['domaincantbeempty'] = 'A domain neve nem lehet &uuml;res.';
$lng['error']['domainexistalready'] = 'A(z) %s domain m&aacute;r l&eacute;tezik.';
$lng['error']['domainisaliasorothercustomer'] = 'A v&aacute;lasztott domain &aacute;ln&eacute;v (alias) vagy maga is domain &aacute;ln&eacute;v, vagy m&aacute;s felhaszn&aacute;l&oacute;hoz tartozik.';
$lng['error']['emailexistalready'] = 'A(z) %s e-mail c&iacute;m m&aacute;r l&eacute;tezik.';
$lng['error']['maindomainnonexist'] = 'A(z)  %s f&#337; domain nem l&eacute;tezik.';
$lng['error']['destinationnonexist'] = 'K&eacute;rem, lev&eacute;l-tov&aacute;bb&iacute;t&oacute;j&aacute;t a  \'C&eacute;l\' mapp&aacute;ban hozza l&eacute;tre.';
$lng['error']['destinationalreadyexistasmail'] = 'A(z) %s tov&aacute;bb&iacute;t&oacute; m&aacute;r l&eacute;tezik mint akt&iacute;v e-mail c&iacute;m.';
$lng['error']['destinationalreadyexist'] = '&Ouml;n m&aacute;r l&eacute;trehozott egy tov&aacute;bb&iacute;t&oacute;t ehhez: %s .';
$lng['error']['destinationiswrong'] = 'A(z) %s tov&aacute;bb&iacute;t&oacute; &eacute;rv&eacute;nytelen karakter(eke)t tartalmaz vagy nem teljes.';
$lng['error']['domainname'] = $lng['domains']['domainname'];

/**
 * Questions
 */

$lng['question']['question'] = 'Biztons&aacute;gi k&eacute;rd&eacute;s';
$lng['question']['admin_customer_reallydelete'] = 'T&eacute;nyleg t&ouml;r&ouml;lni akarja a(z)  %s felhaszn&aacute;l&oacute;t? Ezt a l&eacute;p&eacute;st nem lehet visszavonni!';
$lng['question']['admin_domain_reallydelete'] = 'T&eacute;nyleg t&ouml;r&ouml;lni akarja a(z) %s domain?';
$lng['question']['admin_domain_reallydisablesecuritysetting'] = 'T&eacute;nyleg hat&aacute;stalan&iacute;tani akarja ezeket a biztons&aacute;gi be&aacute;ll&iacute;t&aacute;sokat (OpenBasedir &eacute;s/vagy SafeMode)?';
$lng['question']['admin_admin_reallydelete'] = 'T&eacute;nyleg t&ouml;r&ouml;lni akarja a(z) %s adminisztr&aacute;tort? Minden hozz&aacute; tartoz&oacute; felhaszn&aacute;l&oacute; &eacute;s domain a f&#337;adminisztr&aacute;torhoz lesz rendelve.';
$lng['question']['admin_template_reallydelete'] = 'T&eacute;nyleg t&ouml;r&ouml;lni akarja a(z) \'%s\' sablont?';
$lng['question']['domains_reallydelete'] = 'T&eacute;nyleg t&ouml;r&ouml;lni akarja a(z)  %s domain-t?';
$lng['question']['email_reallydelete'] = 'T&eacute;nyleg t&ouml;r&ouml;lni akarja a(z)  %s e-mail c&iacute;met?';
$lng['question']['email_reallydelete_account'] = 'T&eacute;nyleg t&ouml;r&ouml;lni akarja a(z) %s e-mail postafi&oacute;kot?';
$lng['question']['email_reallydelete_forwarder'] = 'T&eacute;nyleg t&ouml;r&ouml;lni akarja a(z) %s tov&aacute;bb&iacute;t&oacute;t?';
$lng['question']['extras_reallydelete'] = 'T&eacute;nyleg t&ouml;r&ouml;lni akarja a(z)  %s k&ouml;nyvt&aacute;r-v&eacute;delm&eacute;t?';
$lng['question']['extras_reallydelete_pathoptions'] = 'T&eacute;nyleg t&ouml;r&ouml;lni akarja a(z) %s &uacute;tvonal-be&aacute;ll&iacute;t&aacute;sait?';
$lng['question']['ftp_reallydelete'] = 'T&eacute;nyleg t&ouml;r&ouml;lni akarja a(z)  %s FTP hozz&aacute;f&eacute;r&eacute;st?';
$lng['question']['mysql_reallydelete'] = 'T&eacute;nyleg t&ouml;r&ouml;lni szeretn&eacute; a(z) adatb&aacute;zist? Ez a l&eacute;p&eacute;s nem vonhat&oacute; vissza!';
$lng['question']['admin_configs_reallyrebuild'] = 'T&eacute;nyleg &uacute;jra szeretn&eacute; &eacute;p&iacute;teni az Apache &eacute;s Bind konfigur&aacute;ci&oacute;s &aacute;llom&aacute;nyait?';

/**
 * Mails
 */

$lng['mails']['pop_success']['mailbody'] = '&Uuml;dv&ouml;zl&ouml;m!\n\nE-mail fi&oacute;kja {EMAIL} l&eacute;trej&ouml;tt.\n\nEz egy automatikusan k&uuml;ld&ouml;tt\ne-mail, k&eacute;rem, ne v&aacute;laszoljon r&aacute;!\n\nTisztelettel: a SysCP csapata';
$lng['mails']['pop_success']['subject'] = 'E-mail fi&oacute;k l&eacute;trehozva.';
$lng['mails']['createcustomer']['mailbody'] = 'Tisztelt {FIRSTNAME} {NAME}!\n\nAz &Ouml;n postafi&oacute;k adatai:\n\nFelhaszn&aacute;l&oacute;n&eacute;v: {USERNAME}\nJelsz&oacute;: {PASSWORD}\n\nK&ouml;sz&ouml;nj&uuml;k:\na SysCP csapata';
$lng['mails']['createcustomer']['subject'] = 'Postafi&oacute;k inform&aacute;ci&oacute;';

/**
 * Admin
 */

$lng['admin']['overview'] = '&Aacute;ttekint&eacute;s';
$lng['admin']['ressourcedetails'] = 'Felhaszn&aacute;lt er&#337;forr&aacute;sok';
$lng['admin']['systemdetails'] = 'Rendszeradatok';
$lng['admin']['syscpdetails'] = 'SysCP adatok';
$lng['admin']['installedversion'] = 'Install&aacute;lt Verzi&oacute;';
$lng['admin']['latestversion'] = 'Legutols&oacute; verzi&oacute;';
$lng['admin']['lookfornewversion']['clickhere'] = 'keresés a webszervizen kereszt&uuml;l';
$lng['admin']['lookfornewversion']['error'] = 'Olvas&aacute;si hiba';
$lng['admin']['resources'] = 'Er&#337;forr&aacute;sok';
$lng['admin']['customer'] = 'Felhaszn&aacute;ló';
$lng['admin']['customers'] = 'Felhaszn&aacute;lók';
$lng['admin']['customer_add'] = 'Felhaszn&aacute;ló hozz&aacute;ad&aacute;sa';
$lng['admin']['customer_edit'] = 'Felhaszn&aacute;ló szerkeszt&eacute;se';
$lng['admin']['domains'] = 'Domainek';
$lng['admin']['domain_add'] = 'Domain hozz&aacute;ad&aacute;sa';
$lng['admin']['domain_edit'] = 'Domain szerkeszt&eacute;se';
$lng['admin']['subdomainforemail'] = 'Aldomainek mint e-mail-domainek';
$lng['admin']['admin'] = 'Adminisztr&aacute;tor';
$lng['admin']['admins'] = 'Adminisztr&aacute;torok';
$lng['admin']['admin_add'] = 'Adminisztr&aacute;tor hozz&aacute;ad&aacute;sa';
$lng['admin']['admin_edit'] = 'Adminisztr&aacute;tor szerkeszt&eacute;se';
$lng['admin']['customers_see_all'] = 'L&aacute;thatja az &ouml;sszes felhaszn&aacute;l&oacute;t?';
$lng['admin']['domains_see_all'] = 'L&aacute;thatja az &ouml;sszes domaint?';
$lng['admin']['change_serversettings'] = 'Megv&aacute;ltoztathatja a szerver be&aacute;ll&iacute;t&aacute;sait?';
$lng['admin']['server'] = 'Szerver';
$lng['admin']['serversettings'] = 'Be&aacute;ll&iacute;t&aacute;sok';
$lng['admin']['rebuildconf'] = 'A konfig. f&aacute;jlok &uacute;jra&iacute;r&aacute;sa';
$lng['admin']['stdsubdomain'] = 'Egyszer&#369; aldomain';
$lng['admin']['stdsubdomain_add'] = 'Egyszer&#369; aldomain hozz&aacute;ad&aacute;sa';
$lng['admin']['deactivated'] = 'Kikapcsolva';
$lng['admin']['deactivated_user'] = 'Felhaszn&aacute;ló kikapcsol&aacute;sa';
$lng['admin']['sendpassword'] = 'Jelsz&oacute; küld&eacute;se';
$lng['admin']['ownvhostsettings'] = 'Saj&aacute;t vHost be&aacute;ll&iacute;t&aacute;sok';
$lng['admin']['configfiles']['serverconfiguration'] = 'Konfigur&aacute;ci&oacute;';
$lng['admin']['configfiles']['files'] = '<b>Konfig. f&aacute;jlok:</b> K&eacute;rem, v&aacute;ltoztassa meg a k&ouml;vetkez&#337; fájlokat, vagy - ha még nem léteznek - hozza létre &#337;ket a következ&#337; tartalommal.<br /><b>Fontos:</b> A MySQL jelsz&oacute; biztons&aacute;gi okokb&oacute;l nem lesz kicser&eacute;lve. K&eacute;rem, cser&eacute;lje ki a &quot;MYSQL_PASSWORD&quot;-&ouml;t! Ha elfelejtette a NySQL jelsz&oacute;t, megtal&aacute;lja a &quot;lib/userdata.inc.php&quot; f&aacute;jlban.';
$lng['admin']['configfiles']['commands'] = '<b>Parancsok:</b> K&eacute;rem, hajtsa v&eacute;gre a k&ouml;vetkez&#337; parancsokat egy h&eacute;jprogramban (shell)!';
$lng['admin']['configfiles']['restart'] = '<b>&Uacute;jraind&iacute;t&aacute;s:</b> K&eacute;rem, hajtsa v&eacute;gre a k&ouml;vetkez&#337; parancsokat egy h&eacute;jprogramban (shell), hogy az &uacute;j konfigur&aacute;ci&oacute; bet&ouml;lt&#337;dj&ouml;n.';
$lng['admin']['templates']['templates'] = 'Sablonok';
$lng['admin']['templates']['template_add'] = 'Sablon hozz&aacute;ad&aacute;sa';
$lng['admin']['templates']['template_edit'] = 'Sablon szerkeszt&eacute;se';
$lng['admin']['templates']['action'] = 'Alkalom';
$lng['admin']['templates']['email'] = 'E-mail';
$lng['admin']['templates']['subject'] = 'T&aacute;rgy';
$lng['admin']['templates']['mailbody'] = 'Sz&ouml;vegr&ouml;rzs';
$lng['admin']['templates']['createcustomer'] = '&Uuml;dv&ouml;zl&#337; lev&eacute;l &uacute;j felhaszn&aacute;l&oacute;knak';
$lng['admin']['templates']['pop_success'] = '&Uuml;dv&ouml;zl&#337; lev&eacute;l &uacute;j fi&oacute;k eset&eacute;n';
$lng['admin']['templates']['template_replace_vars'] = 'A sablonban haszn&aacute;lhat&oacute; v&aacute;ltoz&oacute;k';
$lng['admin']['templates']['FIRSTNAME'] = 'A felhaszn&aacute;l&oacute; keresztneve ';
$lng['admin']['templates']['NAME'] = 'A felhaszn&aacute;l&oacute; neve ';
$lng['admin']['templates']['USERNAME'] = 'A felhaszn&aacute;l&oacute; felhaszn&aacute;l&oacute;neve';
$lng['admin']['templates']['PASSWORD'] = 'A felhaszn&aacute;l&oacute; felhaszn&aacute;l&oacute;neve jelszava';
$lng['admin']['templates']['EMAIL'] = 'A POP3/IMAP fi&oacute;k c&iacute;me.';

/**
 * Serversettings
 */

$lng['serversettings']['session_timeout']['title'] = 'Munkamenet id&#337;t&uacute;ll&eacute;p&eacute;s';
$lng['serversettings']['session_timeout']['description'] = 'Mennyi id&#337; m&uacute;lva v&aacute;ljon a munkamenet &eacute;rv&eacute;nytelenn&eacute; a felhaszn&aacute;l&oacute; utols&oacute; tev&eacute;kenys&eacute;g&eacute;t&#337;l (m&aacute;sodperc)?';
$lng['serversettings']['accountprefix']['title'] = 'Felhaszn&aacute;l&oacute;i el&#337;tag';
$lng['serversettings']['accountprefix']['description'] = 'Milyen el&#337;taggal legyenek a felhaszn&aacute;l&oacute;i hozz&aacute;f&eacute;r&eacute;sek ell&aacute;tva?';
$lng['serversettings']['mysqlprefix']['title'] = 'SQL el&#337;tag';
$lng['serversettings']['mysqlprefix']['description'] = 'Melyen el&#337;taggal legyenek a mysql hozz&aacute;f&eacute;r&eacute;sek ell&aacute;tva?';
$lng['serversettings']['ftpprefix']['title'] = 'FTP el&#337;tag';
$lng['serversettings']['ftpprefix']['description'] = 'Milyen el&#337;taggal legyenek az FTP hozz&aacute;f&eacute;r&eacute;sek ell&aacute;tva?';
$lng['serversettings']['documentroot_prefix']['title'] = 'Documentum k&ouml;nyvt&aacute;r';
$lng['serversettings']['documentroot_prefix']['description'] = 'Hol legyen minen adat t&aacute;rolva?';
$lng['serversettings']['logfiles_directory']['title'] = 'Napl&oacute;f&aacute;jlok k&ouml;nyvt&aacute;ra';
$lng['serversettings']['logfiles_directory']['description'] = 'Hol legyen minden napl&oacute;f&aacute;jl t&aacute;rolva?';
$lng['serversettings']['ipaddress']['title'] = 'IP c&iacute;m';
$lng['serversettings']['ipaddress']['description'] = 'Mi az  IP c&iacute;me ennek a szervernek?';
$lng['serversettings']['hostname']['title'] = 'Hostn&eacute;v (g&eacute;pn&eacute;v)';
$lng['serversettings']['hostname']['description'] = 'Mi legyen a neve ennek a szervernek?';
$lng['serversettings']['apachereload_command']['title'] = 'Apache &uacute;jraind&iacute;t&aacute;si parancs';
$lng['serversettings']['apachereload_command']['description'] = 'Mi az Apache &uacute;jraind&iacute;t&aacute;si parancsa?';
$lng['serversettings']['bindconf_directory']['title'] = 'Bind konfigur&aacute;ci&oacute;s k&ouml;nyvt&aacute;r';
$lng['serversettings']['bindconf_directory']['description'] = 'Hol vannak a Bind konfigur&aacute;ci&oacute;s &aacute;llom&aacute;nyok?';
$lng['serversettings']['bindreload_command']['title'] = 'Bind &uacute;jraind&iacute;t&aacute;si parancs';
$lng['serversettings']['bindreload_command']['description'] = 'Mi a Bind &uacute;jraind&iacute;t&aacute;si parancsa?';
$lng['serversettings']['binddefaultzone']['title'] = 'Bind alap&eacute;rtelmezett z&oacute;na';
$lng['serversettings']['binddefaultzone']['description'] = 'Mi az alap&eacute;rtelmezett z&oacute;na neve?';
$lng['serversettings']['vmail_uid']['title'] = 'E-mail felhaszn&aacute;l&oacute;-azonos&iacute;t&oacute; (UID)';
$lng['serversettings']['vmail_uid']['description'] = 'Melyik felhaszn&aacute;l&oacute;-azonos&iacute;t&oacute;t (UserID) haszn&aacute;lj&aacute;k a levelek?';
$lng['serversettings']['vmail_gid']['title'] = 'E-mail csoport-azonos&iacute;t&oacute; (GID)';
$lng['serversettings']['vmail_gid']['description'] = 'Melyik csoport-azonos&iacute;t&oacute;t (GroupID) haszn&aacute;lj&aacute;k a levelek?';
$lng['serversettings']['vmail_homedir']['title'] = 'E-mail k&ouml;nyvt&aacute;r';
$lng['serversettings']['vmail_homedir']['description'] = 'Hol legyenek az e-mailek t&aacute;rolva?';
$lng['serversettings']['adminmail']['title'] = 'Felad&oacute;';
$lng['serversettings']['adminmail']['description'] = 'Ki legyen a felad&oacute;ja a panelr&#337;l k&uuml;ld&ouml;tt leveleknek?';
$lng['serversettings']['phpmyadmin_url']['title'] = 'phpMyAdmin URL';
$lng['serversettings']['phpmyadmin_url']['description'] = 'Mi a  phpMyAdmin URL-je? (http://-vel kell kezd&#337;dnie)';
$lng['serversettings']['webmail_url']['title'] = 'WebMail URL';
$lng['serversettings']['webmail_url']['description'] = 'Mi a WebMail URL-je? (http://-vel kell kezd&#337;dnie)';
$lng['serversettings']['webftp_url']['title'] = 'WebFTP URL';
$lng['serversettings']['webftp_url']['description'] = 'Mi a WebFTP URL-je? (http://-vel kell kezd&#337;dnie)';
$lng['serversettings']['language']['description'] = 'Mi a szerver alap&eacute;rtelmezett nyelve?';
$lng['serversettings']['maxloginattempts']['title'] = 'Maxim&aacute;lis bejelentkez&eacute;si k&iacute;s&eacute;rlet';
$lng['serversettings']['maxloginattempts']['description'] = 'Bejelentkez&eacute;si k&iacute;s&eacute;rletek maxim&aacute;lis sz&aacute;ma, miel&#337;tt a hozz&aacute;f&eacute;r&eacute;s z&aacute;rolva lesz.';
$lng['serversettings']['deactivatetime']['title'] = 'Z&aacute;rlat-id&#337;';
$lng['serversettings']['deactivatetime']['description'] = 'Az id&#337;szak (m&aacute;sodpercekben), ameddig a t&uacute;l sok bejelentkez&eacute;si k&iacute;s&eacute;rlet ut&aacute;n a hozz&aacute;f&eacute;r&eacute;s z&aacute;rolva lesz.';
$lng['serversettings']['pathedit']['title'] = 'Az &uacute;tvonal-megad&aacute;s t&iacute;pusa';
$lng['serversettings']['pathedit']['description'] = 'Leg&ouml;rd&uuml;l&#337; men&uuml; vagy beviteli mez&#337; seg&iacute;ts&eacute;g&eacute;vel lesznek az &uacute;tvonalak kiv&aacute;lasztva?';

/**
 * CHANGED BETWEEN 1.2.12 and 1.2.13
 */

$lng['mysql']['description'] = 'Itt hozhatja l&eacute;tre &eacute;s v&aacute;ltoztathatja meg MySQL adatb&aacute;zisait. <br />
 A v&aacute;ltoz&aacute;sok azonnal &eacute;rv&eacute;nyre jutnak, &eacute;s az adatb&aacute;zis r&ouml;gt&ouml;n haszn&aacute;lhat&oacute;.<br />
 A bal oldali men&uuml;ben megtal&aacute;lja a  phpMyAdmin eszk&ouml;zt, amellyel k&ouml;nnyed&eacute;n kezelheti adatb&aacute;zis&aacute;t.<br />
 <br />Saj&aacute;t PHP k&oacute;djaib&oacute;l a k&ouml;vetkez&#337; be&aacute;ll&iacute;t&aacute;sokkal f&eacute;rhet hozz&aacute; adatb&aacute;zis&aacute;hoz: (A  <i>d&#337;ltbet&#369;s</i> adatokat helyettes&iacute;tenie kell az &Ouml;n &aacute;ltal megadottakkal!)<br /> Hostn&eacute;v: <b> <SQL_HOST></b><br />
 Felhaszn&aacute;l&oacute;n&eacute;v: <b><i>Adatb&aacute;zisn&eacute;v</i></b><br />Jelsz&oacute;: <b><i>a jelsz&oacute;, amelyet &Ouml;n kiv&aacute;lasztott </i></b><br />Adatb&aacute;zis: <b><i>Adatb&aacute;zisn&eacute;v</i></b>';

/**
 * ADDED BETWEEN 1.2.12 and 1.2.13
 */

$lng['admin']['cronlastrun'] = 'Utols&oacute; Cron fut&aacute;s';
$lng['serversettings']['paging']['title'] = 'Bejegyz&eacute;sek sz&aacute;ma egy lapon';
$lng['serversettings']['paging']['description'] = 'H&aacute;ny bejegyz&eacute;s jelenjen meg egy lapon? (0 = lapoz&aacute;s kikapcsol&aacute;sa)';
$lng['error']['ipstillhasdomains'] = 'A t&ouml;r&ouml;lni k&iacute;v&aacute;nt IP/Port kombin&aacute;ci&oacute;hoz domainek vannak rendelve. Rendelje hozz&aacute; ezeket egy m&aacute;sik IP/Port kombin&aacute;ci&oacute;hoz, miel&#337;tt a jelenlegi IP/Port kombin&aacute;ci&oacute;t t&ouml;rli.';
$lng['error']['cantdeletedefaultip'] = 'Nem t&ouml;r&ouml;lheti az alap&eacute;rtelmezett viszontelad&oacute;i  IP/Port kombin&aacute;ci&oacute;t. Hozzon l&eacute;tre &uacute;j  alap&eacute;rtelmezett IP/Port kombin&aacute;ci&oacute;t a viszontelad&oacute;knak, miel&#337;tt ezt az  IP/Port kombin&aacute;ci&oacute;t t&ouml;rli.';
$lng['error']['cantdeletesystemip'] = 'Nem t&ouml;r&ouml;lheti a rendszer utols&oacute; IP c&iacute;m&eacute;t. Hozzon l&eacute;tre egy &uacute;j IP/Port kombin&aacute;ci&oacute;t a rendszer IP c&iacute;m&eacute;re, vagy v&aacute;ltozatassa meg a rendszer IP c&iacute;m&eacute;t.';
$lng['error']['myipaddress'] = '\'IP\'';
$lng['error']['myport'] = '\'Port\'';
$lng['error']['myipdefault'] = 'V&aacute;lasztania kell egy IP/Port kombin&aacute;ci&oacute;t alap&eacute;rtelmez&eacute;snek.';
$lng['error']['myipnotdouble'] = 'Ez az  IP/Port kombin&aacute;ci&oacute; m&aacute;r l&eacute;tezik.';
$lng['question']['admin_ip_reallydelete'] = 'Val&oacute;ban t&ouml;r&ouml;lni akarja a(z) %s IP c&iacute;met?';
$lng['admin']['ipsandports']['ipsandports'] = 'IP c&iacute;mek &eacute;s Portok';
$lng['admin']['ipsandports']['add'] = 'IP/Port hozz&aacute;ad&aacute;sa';
$lng['admin']['ipsandports']['edit'] = 'IP/Port szerkeszt&eacute;se';
$lng['admin']['ipsandports']['ipandport'] = 'IP/Port';
$lng['admin']['ipsandports']['ip'] = 'IP';
$lng['admin']['ipsandports']['port'] = 'Port';

// ADDED IN 1.2.13-rc3

$lng['error']['cantchangesystemip'] = 'Nem v&aacute;ltoztathatja meg a rendszer utols&oacute; IP c&iacute;m&eacute;t. Hozzon l&eacute;tre egy &uacute;j IP/Port kombin&aacute;ci&oacute;t a rendszer IP c&iacute;m&eacute;re, vagy v&aacute;ltozatassa meg a rendszer IP c&iacute;m&eacute;t.';
$lng['question']['admin_domain_reallydocrootoutofcustomerroot'] = 'Biztos, hogy a dokumentum gy&ouml;ker&eacute;t (root) rendeli ehhez a domainhez, nem pedig a felhaszn&aacute;l&oacute;i k&ouml;nyvt&aacute;rban marad?';

// ADDED IN 1.2.14-rc1

$lng['admin']['memorylimitdisabled'] = 'Letiltva';
$lng['domain']['openbasedirpath'] = 'OpenBasedir &uacute;tvonal';
$lng['domain']['docroot'] = '&Uacute;tvonal a a fenti mez&#337;b&#337;l';
$lng['domain']['homedir'] = 'Kezd&#337;k&ouml;nyvt&aacute;r';
$lng['admin']['valuemandatory'] = 'Ez a mez&#337; k&ouml;telez&#337;';
$lng['admin']['valuemandatorycompany'] = 'Vagy a &quot;n&eacute;v&quot; &eacute;s &quot;keresztn&eacute;v&quot;, vagy  a &quot;c&eacute;gn&eacute;v&quot; mez&#337;t ki kell t&ouml;lteni.';
$lng['menue']['main']['username'] = 'Bejelentkezve mint: ';
$lng['panel']['urloverridespath'] = 'URL (figyelmen k&iacute;v&uuml;l hagyja az &uacute;tvonalat)';
$lng['panel']['pathorurl'] = '&Uacute;tvonal az URL-hez';
$lng['error']['sessiontimeoutiswrong'] = 'Csak numerikus &quot;Munkamenet Id&#337;t&uacute;ll&eacute;p&eacute;s&quot;adhat&oacute; meg.';
$lng['error']['maxloginattemptsiswrong'] = 'Csak numerikus  &quot;Maxim&aacute;lis Bejelentkez&eacute;si K&iacute;s&eacute;rlet&quot;adhat&oacute; meg. ';
$lng['error']['deactivatetimiswrong'] = 'Csak numerikus &quot;Kikapcsol&aacute;si Id&#337;&quot; adhat&oacute; meg.';
$lng['error']['accountprefixiswrong'] = 'A &quot;Felhaszn&aacute;l&oacute;i El&#337;tag&quot; helytelen.';
$lng['error']['mysqlprefixiswrong'] = 'Az &quot;SQL El&#337;tag&quot; helytelen.';
$lng['error']['ftpprefixiswrong'] = 'Az &quot;FTP El&#337;tag &quot;helytelen.';
$lng['error']['ipiswrong'] = 'Az &quot;IP C&iacute;m&quot; helytelen. Csak &eacute;rv&eacute;nyes IPc&iacute;m adhat&oacute; meg.';
$lng['error']['vmailuidiswrong'] = 'A &quot;Levelez&eacute;si Felhaszn&aacute;l&oacute;-azonos&iacute;t&oacute; (LFA) &quot; helytelen. Csak numerikus LFA adhat&oacute; meg.';
$lng['error']['vmailgidiswrong'] = 'A &quot;Levelez&eacute;si GID &quot; helytelen. Csak numerikus GID adhat&oacute; meg.';
$lng['error']['adminmailiswrong'] = 'A &quot;Felad&oacute; C&iacute;me &quot; helytelen. Csak &eacute;rv&eacute;nyes e-mail c&iacute;m adhat&oacute; meg.';
$lng['error']['pagingiswrong'] = 'A &quot;Laponk&eacute;nti Bejegyz&eacute;s &quot; &eacute;rt&eacute;ke helytelen. Csak numerikus karaktereket lehet megadni..';
$lng['error']['phpmyadminiswrong'] = 'A phpMyAdmin hivatkoz&aacute;s &eacute;rv&eacute;nytelen.';
$lng['error']['webmailiswrong'] = 'A WebMail hivatkoz&aacute;s &eacute;rv&eacute;nytelen.';
$lng['error']['webftpiswrong'] = 'A WebFTP hivatkoz&aacute;s &eacute;rv&eacute;nytelen';
$lng['domains']['hasaliasdomains'] = 'Alias (al-)domainjei';
$lng['serversettings']['defaultip']['title'] = 'Alap&eacute;rtelmezett IP/Port';
$lng['serversettings']['defaultip']['description'] = 'Mi az alap&eacute;rtelmezett IP/Port kombin&aacute;ci&oacute;?';
$lng['domains']['statstics'] = 'Haszn&aacute;lati statisztika';
$lng['panel']['ascending'] = 'n&ouml;vekv&#337;';
$lng['panel']['decending'] = 'csökken&#337;';
$lng['panel']['search'] = 'Keres&eacute;s';
$lng['panel']['used'] = 'felhaszn&aacute;lt';

// ADDED IN 1.2.14-rc3

$lng['panel']['translator'] = 'Ford&iacute;t&oacute;';

// ADDED IN 1.2.14-rc4

$lng['error']['stringformaterror'] = 'A &quot;%s&quot; mez&#337; &eacute;rt&eacute;ke nem megfelel&#337; form&aacute;tum&uacute;.';

// ADDED IN 1.2.15-rc1

$lng['admin']['serversoftware'] = 'Szerverszoftver';
$lng['admin']['phpversion'] = 'PHP verzi&oacute;';
$lng['admin']['phpmemorylimit'] = 'PHP mem&oacute;ria korl&aacute;t';
$lng['admin']['mysqlserverversion'] = 'MySQL szerver verzi&oacute';
$lng['admin']['mysqlclientversion'] = 'MySQL kliens verzi&oacute';
$lng['admin']['webserverinterface'] = 'Webszerver Interf&eacute;sz';
$lng['domains']['isassigneddomain'] = 'Hozz&aacute;rendelt domain';
$lng['serversettings']['phpappendopenbasedir']['title'] = 'Az OpenBasedir-hez csatolt &uacute;tvonalak';
$lng['serversettings']['phpappendopenbasedir']['description'] = 'Ezek az &uacute;tvonalak (kett&#337;sponttal elv&aacute;lasztva) lesznek hozz&aacute;adva az OpenBasedir jegyz&eacute;khez minden vhost t&aacute;rol&oacute;ban.';

// CHANGED IN 1.2.15-rc1

$lng['error']['loginnameissystemaccount'] = 'Nem hozhat l&eacute;tre olyan fi&oacute;kot, amely hasonl&iacute;t a rendszerfi&oacute;kokhoz (mint pl. a &quot;%s&quot; kezdet&#369;ek). K&eacute;rem, adjon meg m&aacute;sik fi&oacute;knevet!';

?>