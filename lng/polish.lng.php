<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @author     Michal Gozdzik <michal@gozdzik.com> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Language
 *
 */

/**
 * Global
 */

$lng['translator'] = 'Michal Gozdzik';
$lng['panel']['edit'] = 'edytuj';
$lng['panel']['delete'] = 'kasuj';
$lng['panel']['create'] = 'utwï¿½rz';
$lng['panel']['save'] = 'zapisz';
$lng['panel']['yes'] = 'tak';
$lng['panel']['no'] = 'nie';
$lng['panel']['emptyfornochanges'] = 'pozostaw puste by nie zmieniać';
$lng['panel']['emptyfordefault'] = 'pozostaw puste by zostawić wartośc domyślną';
$lng['panel']['path'] = 'ścieżka';
$lng['panel']['toggle'] = 'Przełącz';
$lng['panel']['next'] = 'dalej';
$lng['panel']['dirsmissing'] = 'Nie można znaleźć lub czytać katalogu!';

/**
 * Login
 */

$lng['login']['username'] = 'Nazwa użytkownika';
$lng['login']['password'] = 'Hasło';
$lng['login']['language'] = 'Język';
$lng['login']['login'] = 'Zaloguj';
$lng['login']['logout'] = 'Wyloguj';
$lng['login']['profile_lng'] = 'Język profilu';

/**
 * Customer
 */

$lng['customer']['documentroot'] = 'Katalog domowy';
$lng['customer']['name'] = 'Nazwisko';
$lng['customer']['firstname'] = 'Imię';
$lng['customer']['company'] = 'Firma';
$lng['customer']['street'] = 'Ulica';
$lng['customer']['zipcode'] = 'Kod pocztowy';
$lng['customer']['city'] = 'Miasto';
$lng['customer']['phone'] = 'Telefon';
$lng['customer']['fax'] = 'Fax';
$lng['customer']['email'] = 'E-mail';
$lng['customer']['customernumber'] = 'ID Klienta';
$lng['customer']['diskspace'] = 'Pojemność (MB)';
$lng['customer']['traffic'] = 'Ruch (GB)';
$lng['customer']['mysqls'] = 'Bazy MySQL';
$lng['customer']['emails'] = 'Adresy E-mail';
$lng['customer']['accounts'] = 'Konta E-mail';
$lng['customer']['forwarders'] = 'E-mail przekierowania';
$lng['customer']['ftps'] = 'Konta FTP';
$lng['customer']['subdomains'] = 'Sub-Domeny';
$lng['customer']['domains'] = 'Domeny';
$lng['customer']['unlimited'] = 'bez limitu';

/**
 * Customermenue
 */

$lng['menue']['main']['main'] = 'Panel gï¿½ï¿½wny';
$lng['menue']['main']['changepassword'] = 'Zmień hasło';
$lng['menue']['main']['changelanguage'] = 'Zmień język';
$lng['menue']['email']['email'] = 'E-mail';
$lng['menue']['email']['emails'] = 'Adresy';
$lng['menue']['email']['webmail'] = 'WebMail';
$lng['menue']['mysql']['mysql'] = 'MySQL';
$lng['menue']['mysql']['databases'] = 'Bazy danych';
$lng['menue']['mysql']['phpmyadmin'] = 'phpMyAdmin';
$lng['menue']['domains']['domains'] = 'Domeny';
$lng['menue']['domains']['settings'] = 'Ustawienia';
$lng['menue']['ftp']['ftp'] = 'FTP';
$lng['menue']['ftp']['accounts'] = 'Konta';
$lng['menue']['ftp']['webftp'] = 'WebFTP';
$lng['menue']['extras']['extras'] = 'Dodatki';
$lng['menue']['extras']['directoryprotection'] = 'Foldery Chronione Hasłem';
$lng['menue']['extras']['pathoptions'] = 'Opcje ścieżki';

/**
 * Index
 */

$lng['index']['customerdetails'] = 'Szczegï¿½ły klienta';
$lng['index']['accountdetails'] = 'Szczegï¿½ły konta';

/**
 * Change Password
 */

$lng['changepassword']['old_password'] = 'Stare hasło';
$lng['changepassword']['new_password'] = 'Nowe hasło';
$lng['changepassword']['new_password_confirm'] = 'Nowe hasło (powtï¿½rz)';
$lng['changepassword']['new_password_ifnotempty'] = 'Nowe hasło (puste = bez zmien)';
$lng['changepassword']['also_change_ftp'] = ' oraz zmień hasło do głï¿½wnego konta FTP';

/**
 * Domains
 */

$lng['domains']['description'] = 'Here you can create (sub-)domains and change their paths.<br />The system will need some time to apply the new settings after every change.';
$lng['domains']['domainsettings'] = 'Ustawienia domeny';
$lng['domains']['domainname'] = 'Nazwa domeny';
$lng['domains']['subdomain_add'] = 'Utwï¿½rz (pod)domenę';
$lng['domains']['subdomain_edit'] = 'Edytuj (pod)domenę';
$lng['domains']['wildcarddomain'] = 'Utwï¿½rz jako wildcarddomain?';
$lng['domains']['aliasdomain'] = 'Alias dla domeny';
$lng['domains']['noaliasdomain'] = 'Bez aliasu dla domeny';

/**
 * E-mails
 */

$lng['emails']['description'] = 'W tym miejscu możesz utworzyć lub zmienić Twoje adresy e-mail.<br />An account is like your letterbox in front of your house. If someone sends you an email, it will be dropped into the account.<br /><br />To download your emails use the following settings in your mailprogram: (The data in <i>italics</i> has to be changed to the equivalents you typed in!)<br />Hostname: <b><i>Domainname</i></b><br />Username: <b><i>Account name / e-mail address</i></b><br />Password: <b><i>the password you\'ve chosen</i></b>';
$lng['emails']['emailaddress'] = 'Adresy E-mail';
$lng['emails']['emails_add'] = 'Utwï¿½rz adresy e-mail';
$lng['emails']['emails_edit'] = 'Edytuj adresy e-mail';
$lng['emails']['catchall'] = 'Catchall';
$lng['emails']['iscatchall'] = 'Zdefiniuj jako adres catchall?';
$lng['emails']['account'] = 'Konto';
$lng['emails']['account_add'] = 'Utwï¿½rz konto';
$lng['emails']['account_delete'] = 'Kasuj konto';
$lng['emails']['from'] = 'Source';
$lng['emails']['to'] = 'Destination';
$lng['emails']['forwarders'] = 'Przekierowania';
$lng['emails']['forwarder_add'] = 'Utwï¿½rz przekierowanie';

/**
 * FTP
 */

$lng['ftp']['description'] = 'W tym miejscu możesz utworzyć lub zmienić Twoje konta FTP.<br />Dokonane zmiany są wprowadzane natychmiastowo.';
$lng['ftp']['account_add'] = 'Utwï¿½rz konto';

/**
 * MySQL
 */

$lng['mysql']['databasename'] = 'użytkownik/nazwa bazy danych';
$lng['mysql']['databasedescription'] = 'Opis bazy danych';
$lng['mysql']['database_create'] = 'Utwï¿½rz bazę danych';

/**
 * Extras
 */

$lng['extras']['description'] = 'Here you can add some extras, for example directory protection.<br />The system will need some time to apply the new settings after every change.';
$lng['extras']['directoryprotection_add'] = 'Dodaj Ochronę folderu';
$lng['extras']['view_directory'] = 'wyświetl zawartość folderu';
$lng['extras']['pathoptions_add'] = 'dodaj opcję ścieżki';
$lng['extras']['directory_browsing'] = 'przeglądanie zawartości folderu';
$lng['extras']['pathoptions_edit'] = 'edytuj opcję ścieżki';
$lng['extras']['error404path'] = '404';
$lng['extras']['error403path'] = '403';
$lng['extras']['error500path'] = '500';
$lng['extras']['error401path'] = '401';
$lng['extras']['errordocument404path'] = 'URL do pliku błędu 404';
$lng['extras']['errordocument403path'] = 'URL do pliku błędu 403';
$lng['extras']['errordocument500path'] = 'URL do pliku błędu 500';
$lng['extras']['errordocument401path'] = 'URL do pliku błędu 401';

/**
 * Errors
 */

$lng['error']['error'] = 'Błąd';
$lng['error']['directorymustexist'] = 'Folder %s musi istnieć. Proszę go utworzyć przez klienta FTP.';
$lng['error']['filemustexist'] = 'Plik %s musi istnieć.';
$lng['error']['allresourcesused'] = 'You have already used all of your resources.';
$lng['error']['domains_cantdeletemaindomain'] = 'Nie możesz usunąć domeny, ktï¿½ra jest używana jako domena e-mailowa.';
$lng['error']['domains_canteditdomain'] = 'Nie możesz edytować tej domeny. Ta opcja została wyłączona przez administratora.';
$lng['error']['domains_cantdeletedomainwithemail'] = 'Nie możesz usunąć domeny, ktï¿½ra jest używana jako domena e-mailowa. Usuń w pierwszej kolejności wszystkie konta e-mail dla tej domeny.';
$lng['error']['firstdeleteallsubdomains'] = 'You have to delete all Subdomains first before you can create a wildcard domain.';
$lng['error']['youhavealreadyacatchallforthisdomain'] = 'Masz juz zdefiniowany catchall dla tej domeny.';
$lng['error']['ftp_cantdeletemainaccount'] = 'Nie możesz skasować swojego głï¿½wnego konat FTP';
$lng['error']['login'] = 'Login i hasło wpisane jest źle. Proszę sprï¿½bować ponownie!';
$lng['error']['login_blocked'] = 'This account has been suspended because of too many login errors. <br />Please try again in ' . $settings['login']['deactivatetime'] . ' seconds.';
$lng['error']['notallreqfieldsorerrors'] = 'You have not filled in all or filled in some fields incorrectly.';
$lng['error']['oldpasswordnotcorrect'] = 'Stare hasło jest nieprawidłowe.';
$lng['error']['youcantallocatemorethanyouhave'] = 'You cannot allocate more resources than you own for yourself.';
$lng['error']['mustbeurl'] = 'You have not typed a valid or complete url (e.g. http://somedomain.com/error404.htm)';
$lng['error']['invalidpath'] = 'You have not chosen a valid url (maybe problems with the dirlisting?)';
$lng['error']['stringisempty'] = 'Missing Input in Field';
$lng['error']['stringiswrong'] = 'Wrong Input in Field';
$lng['error']['myloginname'] = '\'' . $lng['login']['username'] . '\'';
$lng['error']['mypassword'] = '\'' . $lng['login']['password'] . '\'';
$lng['error']['oldpassword'] = '\'' . $lng['changepassword']['old_password'] . '\'';
$lng['error']['newpassword'] = '\'' . $lng['changepassword']['new_password'] . '\'';
$lng['error']['newpasswordconfirm'] = '\'' . $lng['changepassword']['new_password_confirm'] . '\'';
$lng['error']['newpasswordconfirmerror'] = 'Nowe hhasło i jego powtï¿½rzenie nie są takie same';
$lng['error']['myname'] = '\'' . $lng['customer']['name'] . '\'';
$lng['error']['myfirstname'] = '\'' . $lng['customer']['firstname'] . '\'';
$lng['error']['emailadd'] = '\'' . $lng['customer']['email'] . '\'';
$lng['error']['mydomain'] = '\'Domain\'';
$lng['error']['mydocumentroot'] = '\'Documentroot\'';
$lng['error']['loginnameexists'] = 'Login %s już istnieje';
$lng['error']['emailiswrong'] = 'E-mail-Address %s contains invalid characters or is incomplete';
$lng['error']['loginnameiswrong'] = 'Login-Name %s contains invalid characters';
$lng['error']['userpathcombinationdupe'] = 'Combination of Username and Path already exists';
$lng['error']['patherror'] = 'General Error! path cannot be empty';
$lng['error']['errordocpathdupe'] = 'Option for path %s already exists';
$lng['error']['adduserfirst'] = 'Proszę w pierwszej kolejności utworzyć klienta';
$lng['error']['domainalreadyexists'] = 'The domain %s is already assigned to a customer';
$lng['error']['nolanguageselect'] = 'Nie wybrano języka.';
$lng['error']['nosubjectcreate'] = 'Musisz zdefiniowaï¿½ temat dla szablonu e-maila.';
$lng['error']['nomailbodycreate'] = 'Musisz zdefiniowaï¿½ treï¿½ï¿½ dla szablonu e-maila.';
$lng['error']['templatenotfound'] = 'Szablon nie zostaï¿½ znaleziony.';
$lng['error']['alltemplatesdefined'] = 'You cant define more templates, all languages are supported already.';
$lng['error']['wwwnotallowed'] = 'www is not allowed for subdomains.';
$lng['error']['subdomainiswrong'] = 'The subdomain %s contains invalid characters.';
$lng['error']['domaincantbeempty'] = 'Nazwa domeny nie moï¿½e byï¿½ pusta.';
$lng['error']['domainexistalready'] = 'Domena %s juï¿½ istnieje.';
$lng['error']['domainisaliasorothercustomer'] = 'The selected alias domain is either itself an alias domain or belongs to another customer.';
$lng['error']['emailexistalready'] = 'Adres e-mail %s juï¿½ istnieje.';
$lng['error']['maindomainnonexist'] = 'The main-domain %s does not exist.';
$lng['error']['destinationnonexist'] = 'Please create your forwarder in the field \'Destination\'.';
$lng['error']['destinationalreadyexistasmail'] = 'The forwarder to %s already exists as active EMail-Address.';
$lng['error']['destinationalreadyexist'] = 'You have already defined a forwarder to %s .';
$lng['error']['destinationiswrong'] = 'The forwarder %s contains invalid character(s) or is incomplete.';
$lng['error']['domainname'] = $lng['domains']['domainname'];

/**
 * Questions
 */

$lng['question']['question'] = 'Pytanie bezpieczeństwa';
$lng['question']['admin_customer_reallydelete'] = 'Czy na pewno chcesz skasować klienta %s? Ta czynność jest niedwracalna!';
$lng['question']['admin_domain_reallydelete'] = 'Czy na pewno chcesz skasować domenę %s?';
$lng['question']['admin_domain_reallydisablesecuritysetting'] = 'Czy na pewno chcesz deaktywowaï¿½ ustawienia bezpieczeï¿½stwa (OpenBasedir)?';
$lng['question']['admin_admin_reallydelete'] = 'Czy na pewno chcesz skasować administratora %s? Wszystcy klienci i domeny zostaną przypisani do Twojego konta.';
$lng['question']['admin_template_reallydelete'] = 'Czy na pewno chcesz skasować szablon \'%s\'?';
$lng['question']['domains_reallydelete'] = 'Czy na pewno chcesz skasować domenę %s?';
$lng['question']['email_reallydelete'] = 'Czy na pewno chcesz skasować adres e-mail %s?';
$lng['question']['email_reallydelete_account'] = 'Czy na pewno chcesz skasować konto pocztowe of %s?';
$lng['question']['email_reallydelete_forwarder'] = 'Czy na pewno chcesz skasować przekierowanie %s?';
$lng['question']['extras_reallydelete'] = 'Czy na pewno chcesz skasować ochronę folderu %s?';
$lng['question']['extras_reallydelete_pathoptions'] = 'Do you really want to delete the path options for %s?';
$lng['question']['ftp_reallydelete'] = 'Czy na pewno chcesz skasować konto FTP %s?';
$lng['question']['mysql_reallydelete'] = 'Czy na pewno chcesz skasować bazę danych %s? Ta czynność jest niedwracalna!';
$lng['question']['admin_configs_reallyrebuild'] = 'Czy napewno chcesz przebudować pliki konfiguracyjne Apacha i Binda?';

/**
 * Mails
 */

$lng['mails']['pop_success']['mailbody'] = 'Witaj,\n\nTwoje konto pocztowe {EMAIL}\nzostało utworzone pomyślnie.\n\nWiadomość utworzona automatycznie\nproszę na nia nie odpowiadać!\n\nZ poważaniem, Froxlor';
$lng['mails']['pop_success']['subject'] = 'Konto pocztowe zostało utworzone pomyślnie';
$lng['mails']['createcustomer']['mailbody'] = 'Witaj {FIRSTNAME} {NAME},\n\nprzesyłamy informacje o Twoim koncie:\n\nNazwa użytkownika: {USERNAME}\nHasło: {PASSWORD}\n\nDziękujemy,\nFroxlor';
$lng['mails']['createcustomer']['subject'] = 'Informacje dotyczące konta';

/**
 * Admin
 */

$lng['admin']['overview'] = 'Przegląd';
$lng['admin']['ressourcedetails'] = 'Używane zasoby';
$lng['admin']['systemdetails'] = 'Szczegï¿½ły systemu';
$lng['admin']['froxlordetails'] = 'Szczegï¿½ły Froxlora';
$lng['admin']['installedversion'] = 'Zainstalowana wersja';
$lng['admin']['latestversion'] = 'Ostatnia wersja';
$lng['admin']['lookfornewversion']['clickhere'] = 'Wyszukaj przez webserwis';
$lng['admin']['lookfornewversion']['error'] = 'Błąd podszas czytania';
$lng['admin']['resources'] = 'Zasoby';
$lng['admin']['customer'] = 'Klient';
$lng['admin']['customers'] = 'Klienci';
$lng['admin']['customer_add'] = 'Utwï¿½rz klienta';
$lng['admin']['customer_edit'] = 'Edytuj klienta';
$lng['admin']['domains'] = 'Domeny';
$lng['admin']['domain_add'] = 'Utwï¿½rz domenę';
$lng['admin']['domain_edit'] = 'Edytuj domenę';
$lng['admin']['subdomainforemail'] = 'Subdomains as emaildomains';
$lng['admin']['admin'] = 'Administrator';
$lng['admin']['admins'] = 'Administratorzy';
$lng['admin']['admin_add'] = 'Utwï¿½rz administratora';
$lng['admin']['admin_edit'] = 'Edytuj administratora';
$lng['admin']['customers_see_all'] = 'Widzi wszystkich klientï¿½w?';
$lng['admin']['domains_see_all'] = 'Widzi wszystkie domeny?';
$lng['admin']['change_serversettings'] = 'Can change server settings?';
$lng['admin']['server'] = 'Serwer';
$lng['admin']['serversettings'] = 'Ustawienia';
$lng['admin']['rebuildconf'] = 'Przebuduj pliki konfig.';
$lng['admin']['stdsubdomain'] = 'Standard subdomain';
$lng['admin']['stdsubdomain_add'] = 'Utworzyć standardową domenę';
$lng['admin']['phpenabled'] = 'PHP włączone';
$lng['admin']['deactivated'] = 'Dezaktywowane';
$lng['admin']['deactivated_user'] = 'Dezaktywowany użytkownik';
$lng['admin']['sendpassword'] = 'Wyślij hasło';
$lng['admin']['ownvhostsettings'] = 'Own vHost-Settings';
$lng['admin']['configfiles']['serverconfiguration'] = 'Konfiguracja';
$lng['admin']['configfiles']['files'] = '<b>Configfiles:</b> Please change the following files or create them with<br />the following content if they do not exist.<br /><b>Please Note:</b> The MySQL-password has not been replaced for security reasons.<br />Please replace "MYSQL_PASSWORD" on your own. If you forgot your MySQL-password<br />you\'ll find it in "lib/userdata.inc.php".';
$lng['admin']['configfiles']['commands'] = '<b>Commands:</b> Please execute the following commands in a shell.';
$lng['admin']['configfiles']['restart'] = '<b>Restart:</b> Please execute the following commands in a shell in order to reload the new configuration.';
$lng['admin']['templates']['templates'] = 'Szablony e-maili';
$lng['admin']['templates']['template_add'] = 'Dodaj szablon';
$lng['admin']['templates']['template_edit'] = 'Edytuj szablon';
$lng['admin']['templates']['action'] = 'Action';
$lng['admin']['templates']['email'] = 'E-Maile i pliki szablonï¿½w';
$lng['admin']['templates']['subject'] = 'Temat';
$lng['admin']['templates']['mailbody'] = 'Treść wiadomości';
$lng['admin']['templates']['createcustomer'] = 'Wiadomość powitalna dla nowych klientï¿½w';
$lng['admin']['templates']['pop_success'] = 'Wiadomość powitalna dla nowych kont e-mail';
$lng['admin']['templates']['template_replace_vars'] = 'Variables to be replaced in the template:';
$lng['admin']['templates']['FIRSTNAME'] = 'Replaced with the customers firstname.';
$lng['admin']['templates']['NAME'] = 'Replaced with the customers name.';
$lng['admin']['templates']['USERNAME'] = 'Replaced with the customers account username.';
$lng['admin']['templates']['PASSWORD'] = 'Replaced with the customers account password.';
$lng['admin']['templates']['EMAIL'] = 'Replaced with the address of the POP3/IMAP account.';
$lng['admin']['webserver'] = 'Webserwer';

/**
 * Serversettings
 */

$lng['serversettings']['session_timeout']['title'] = 'Timeout Sesji';
$lng['serversettings']['session_timeout']['description'] = 'jak dï¿½ugo uï¿½ytkownik moï¿½e byï¿½ nieaktywny przed automatycznym wylogowaniem (sekund)?';
$lng['serversettings']['accountprefix']['title'] = 'Customer prefix';
$lng['serversettings']['accountprefix']['description'] = 'Which prefix should customer accounts have?';
$lng['serversettings']['mysqlprefix']['title'] = 'SQL Prefix';
$lng['serversettings']['mysqlprefix']['description'] = 'Which prefix should mysql accounts have?';
$lng['serversettings']['ftpprefix']['title'] = 'FTP Prefix';
$lng['serversettings']['ftpprefix']['description'] = 'Which prefix should ftp accounts have?';
$lng['serversettings']['documentroot_prefix']['title'] = 'Home directory';
$lng['serversettings']['documentroot_prefix']['description'] = 'Where should all home directories be stored?';
$lng['serversettings']['logfiles_directory']['title'] = 'Logfiles directory';
$lng['serversettings']['logfiles_directory']['description'] = 'Where should all log files be stored?';
$lng['serversettings']['ipaddress']['title'] = 'Adres IP';
$lng['serversettings']['ipaddress']['description'] = 'Jaki jest adres IP tego serwera?';
$lng['serversettings']['hostname']['title'] = 'Hostname';
$lng['serversettings']['hostname']['description'] = 'Jaki jest Hostname serwera?';
$lng['serversettings']['apachereload_command']['title'] = 'Apache reload command';
$lng['serversettings']['apachereload_command']['description'] = 'What\'s the apache command to reload apache configfiles?';
$lng['serversettings']['bindconf_directory']['title'] = 'Bind config directory';
$lng['serversettings']['bindconf_directory']['description'] = 'Where should bind configfiles be saved?';
$lng['serversettings']['bindreload_command']['title'] = 'Bind reload command';
$lng['serversettings']['bindreload_command']['description'] = 'What\'s the bind command to reload bind configfiles?';
$lng['serversettings']['binddefaultzone']['title'] = 'Bind default zone';
$lng['serversettings']['binddefaultzone']['description'] = 'What\'s the name of the default zone?';
$lng['serversettings']['vmail_uid']['title'] = 'Mails-UID';
$lng['serversettings']['vmail_uid']['description'] = 'Which UserID should mails have?';
$lng['serversettings']['vmail_gid']['title'] = 'Mails-GID';
$lng['serversettings']['vmail_gid']['description'] = 'Which GroupID should mails have?';
$lng['serversettings']['vmail_homedir']['title'] = 'Katalog domowy e-maili';
$lng['serversettings']['vmail_homedir']['description'] = 'Gdzie majï¿½ byï¿½ skï¿½adowane wiadomoï¿½ci e-mail?';
$lng['serversettings']['adminmail']['title'] = 'Nadawca';
$lng['serversettings']['adminmail']['description'] = 'Jaki jest adres nadawcy dla wiadomoï¿½ci wysyï¿½anych z panelu?';
$lng['serversettings']['phpmyadmin_url']['title'] = 'URL do phpMyAdmina';
$lng['serversettings']['phpmyadmin_url']['description'] = 'What\'s the URL to phpMyAdmin? (has to start with http(s)://)';
$lng['serversettings']['webmail_url']['title'] = 'WebMail URL';
$lng['serversettings']['webmail_url']['description'] = 'What\'s the URL to WebMail? (has to start with http(s)://)';
$lng['serversettings']['webftp_url']['title'] = 'WebFTP URL';
$lng['serversettings']['webftp_url']['description'] = 'What\'s the URL to  WebFTP? (has to start with http(s)://)';
$lng['serversettings']['language']['description'] = 'What\'s your standard server language?';
$lng['serversettings']['maxloginattempts']['title'] = 'Max Login Attempts';
$lng['serversettings']['maxloginattempts']['description'] = 'Maximum login attempts after which the account gets deactivated.';
$lng['serversettings']['deactivatetime']['title'] = 'Czas zablokowania';
$lng['serversettings']['deactivatetime']['description'] = 'Czas (sek.) zablokowania dostï¿½pu do konta po nieudanym logowaniu.';
$lng['serversettings']['pathedit']['title'] = 'Type of path input';
$lng['serversettings']['pathedit']['description'] = 'Should a path be selected by a dropdown menu or by an input field?';
$lng['serversettings']['nameservers']['title'] = 'Serwery Nazw (Nameserwery)';
$lng['serversettings']['nameservers']['description'] = 'A comma separated list containing the hostnames of all nameservers. The first one will be the primary one.';
$lng['serversettings']['mxservers']['title'] = 'Serwery MX';
$lng['serversettings']['mxservers']['description'] = 'A comma seperated list containing a pair of a number and a hostname separated by whitespace (e.g. \'10 mx.example.com\') containing the mx servers.';

/**
 * CHANGED BETWEEN 1.2.12 and 1.2.13
 */

$lng['mysql']['description'] = 'W tym miejscu moï¿½esz tworzyï¿½ i zmieniaï¿½ Twoje bazy MySQL.<br />The changes are made instantly and the database can be used immediately.<br />At the menu on the left side you find the tool phpMyAdmin with which you can easily administer your database.<br /><br />To use your databases in your own php-scripts use the following settings: (The data in <i>italics</i> have to be changed into the equivalents you typed in!)<br />Hostname: <b><SQL_HOST></b><br />Username: <b><i>Databasename</i></b><br />Password: <b><i>the password you\'ve chosen</i></b><br />Database: <b><i>Databasename</i></b>';

/**
 * ADDED BETWEEN 1.2.12 and 1.2.13
 */

$lng['serversettings']['paging']['title'] = 'Wpisï¿½w na stronie';
$lng['serversettings']['paging']['description'] = 'Ilość wpisï¿½w jakie mają się pojaiwać na jednej wyświetlanej stronie? (0 = wyłączone stronnicowanie)';
$lng['error']['ipstillhasdomains'] = 'The IP/Port combination you want to delete still has domains assigned to it, please reassign those to other IP/Port combinations before deleting this IP/Port combination.';
$lng['error']['cantdeletedefaultip'] = 'You cannot delete the default reseller IP/Port combination, please make another IP/Port combination default for resellers before deleting this IP/Port combination.';
$lng['error']['cantdeletesystemip'] = 'You cannot delete the last system IP, either create a new IP/Port combination for the system IP or change the system IP.';
$lng['error']['myipaddress'] = '\'IP\'';
$lng['error']['myport'] = '\'Port\'';
$lng['error']['myipdefault'] = 'You need to select an IP/Port combination that should become default.';
$lng['error']['myipnotdouble'] = 'Kombinacja IP/Port juï¿½ istnieje.';
$lng['error']['admin_domain_emailsystemhostname'] = 'Sorry. You can not use the Server Hostname as email domain';
$lng['question']['admin_ip_reallydelete'] = 'Czy na pewno chcesz skasowaï¿½ adres IP %s?';
$lng['admin']['ipsandports']['ipsandports'] = 'IP i Porty';
$lng['admin']['ipsandports']['add'] = 'Dodaj IP/Port';
$lng['admin']['ipsandports']['edit'] = 'Edytuj IP/Port';
$lng['admin']['ipsandports']['ipandport'] = 'IP/Port';
$lng['admin']['ipsandports']['ip'] = 'IP';
$lng['admin']['ipsandports']['port'] = 'Port';

// ADDED IN 1.2.13-rc3

$lng['error']['cantchangesystemip'] = 'You cannot change the last system IP, either create another new IP/Port combination for the system IP or change the system IP.';
$lng['question']['admin_domain_reallydocrootoutofcustomerroot'] = 'Are you sure, you want the document root for this domain, not being within the customer root of the customer?';

// ADDED IN 1.2.14-rc1

$lng['admin']['memorylimitdisabled'] = 'Disabled';
$lng['domain']['openbasedirpath'] = 'OpenBasedir-path';
$lng['domain']['docroot'] = 'Katalog z powyższego pola';
$lng['domain']['homedir'] = 'Katalog domowy';
$lng['admin']['valuemandatory'] = 'Ta wartość jest obowiązkowa';
$lng['admin']['valuemandatorycompany'] = '"Nazwisko" i "Imię" lub "Firma" muszą być wypełnione';
$lng['menue']['main']['username'] = 'Zalogowany jako: ';
$lng['panel']['urloverridespath'] = 'URL (overrides path)';
$lng['panel']['pathorurl'] = 'Path or URL';
$lng['error']['sessiontimeoutiswrong'] = 'Only numerical "Session Timeout" is allowed.';
$lng['error']['maxloginattemptsiswrong'] = 'Only numerical "Max Login Attempts" are allowed.';
$lng['error']['deactivatetimiswrong'] = 'Only numerical "Deactivate Time" is allowed.';
$lng['error']['accountprefixiswrong'] = 'The "Customerprefix" is wrong.';
$lng['error']['mysqlprefixiswrong'] = 'The "SQL Prefix" is wrong.';
$lng['error']['ftpprefixiswrong'] = 'The "FTP Prefix" is wrong.';
$lng['error']['ipiswrong'] = 'The "IP-Address" is wrong. Only a valid IP-address is allowed.';
$lng['error']['vmailuidiswrong'] = 'The "Mails-uid" is wrong. Only a numerical UID is allowed.';
$lng['error']['vmailgidiswrong'] = 'The "Mails-gid" is wrong. Only a numerical GID is allowed.';
$lng['error']['adminmailiswrong'] = 'The "Sender-address" is wrong. Only a valid email-address is allowed.';
$lng['error']['pagingiswrong'] = 'The "Entries per Page"-value is wrong. Only numerical characters are allowed.';
$lng['error']['phpmyadminiswrong'] = 'The phpMyAdmin-link is not a valid link.';
$lng['error']['webmailiswrong'] = 'The WebMail-link is not a valid link.';
$lng['error']['webftpiswrong'] = 'The WebFTP-link is not a valid link.';
$lng['domains']['hasaliasdomains'] = 'Has alias domain(s)';
$lng['serversettings']['defaultip']['title'] = 'Default IP/Port';
$lng['serversettings']['defaultip']['description'] = 'What\'s the default IP/Port combination?';
$lng['domains']['statstics'] = 'Statystyki użycia';
$lng['panel']['ascending'] = 'rosnąco';
$lng['panel']['decending'] = 'malejąco';
$lng['panel']['search'] = 'Szukaj';
$lng['panel']['used'] = 'used';

// ADDED IN 1.2.14-rc3

$lng['panel']['translator'] = 'Translator';

// ADDED IN 1.2.14-rc4

$lng['error']['stringformaterror'] = 'The value for the field "%s" is not in the expected format.';

// ADDED IN 1.2.15-rc1

$lng['admin']['serversoftware'] = 'Wersja serwera';
$lng['admin']['phpversion'] = 'Wersja PHP';
$lng['admin']['phpmemorylimit'] = 'PHP-Memory-Limit';
$lng['admin']['mysqlserverversion'] = 'Wersja Serwera MySQL';
$lng['admin']['mysqlclientversion'] = 'Wersja Klienta MySQL';
$lng['admin']['webserverinterface'] = 'Interface Webserwera';
$lng['domains']['isassigneddomain'] = 'Is assigned domain';
$lng['serversettings']['phpappendopenbasedir']['title'] = 'Paths to append to OpenBasedir';
$lng['serversettings']['phpappendopenbasedir']['description'] = 'These paths (separated by colons) will be added to the OpenBasedir-statement in every vhost-container.';

// CHANGED IN 1.2.15-rc1

$lng['error']['loginnameissystemaccount'] = 'You cannot create accounts which are similar to system accounts (as for example begin with "%s"). Please enter another account name.';
$lng['error']['youcantdeleteyourself'] = 'You cannot delete yourself for security reasons.';
$lng['error']['youcanteditallfieldsofyourself'] = 'Note: You cannot edit all fields of your own account for security reasons.';

// ADDED IN 1.2.16-svn1

$lng['serversettings']['natsorting']['title'] = 'Użyj naturalnego dla ludzi sortowania w widoku listy';
$lng['serversettings']['natsorting']['description'] = 'Sortuj listy jako web1 -> web2 -> web11 zamiast web1 -> web11 -> web2.';

// ADDED IN 1.2.16-svn2

$lng['serversettings']['deactivateddocroot']['title'] = 'Docroot for deactivated users';
$lng['serversettings']['deactivateddocroot']['description'] = 'When a user is deactivated this path is used as his docroot. Leave empty for not creating a vhost at all.';

// ADDED IN 1.2.16-svn4

$lng['panel']['reset'] = 'anuluj zmiany';
$lng['admin']['accountsettings'] = 'Ustawienia Konta';
$lng['admin']['panelsettings'] = 'Ustawienia Panelu';
$lng['admin']['systemsettings'] = 'Ustawienia Systemu';
$lng['admin']['webserversettings'] = 'Ustawienia Webserwera';
$lng['admin']['mailserversettings'] = 'Ustawienia Serwera Pocztowego';
$lng['admin']['nameserversettings'] = 'Ustawienia Serwera Nazw';
$lng['admin']['updatecounters'] = 'Przelicz użycie zasobï¿½w';
$lng['question']['admin_counters_reallyupdate'] = 'Czy na pewno chcesz przeliczyć użycie zasobï¿½w?';
$lng['panel']['pathDescription'] = 'Jeśli folder nie istnieje, zostanie stworzony automatycznie.';

// ADDED IN 1.2.16-svn6

$lng['mails']['trafficninetypercent']['mailbody'] = 'Dear {NAME},\n\nYou used {TRAFFICUSED} MB of your available {TRAFFIC} MB of traffic.\nThis is more than 90%.\n\nYours sincerely, the Froxlor';
$lng['mails']['trafficninetypercent']['subject'] = 'Reaching your traffic limit';
$lng['admin']['templates']['trafficninetypercent'] = 'Notification mail for customers when ninety percent of traffic is exhausted';
$lng['admin']['templates']['TRAFFIC'] = 'Replaced with the traffic, which was assigned to the customer.';
$lng['admin']['templates']['TRAFFICUSED'] = 'Replaced with the traffic, which was exhausted by the customer.';

// ADDED IN 1.2.16-svn7

$lng['admin']['subcanemaildomain']['never'] = 'Nigdy';
$lng['admin']['subcanemaildomain']['choosableno'] = 'Wybï¿½r, domyślnie nie';
$lng['admin']['subcanemaildomain']['choosableyes'] = 'Wybï¿½r, domyślnie tak';
$lng['admin']['subcanemaildomain']['always'] = 'Zawsze';
$lng['changepassword']['also_change_webalizer'] = ' oraz zmień hasło do webalizera';

// ADDED IN 1.2.16-svn8

$lng['serversettings']['mailpwcleartext']['title'] = 'Also save passwords of mail accounts unencrypted in database';
$lng['serversettings']['mailpwcleartext']['description'] = 'If this is set to yes, all passwords will also be saved unencrypted (clear text, plain readable for everyone with database access) in the mail_users-table. Only activate this if you really need it!';
$lng['serversettings']['mailpwcleartext']['removelink'] = 'Click here to wipe all unencrypted passwords from the table.';
$lng['question']['admin_cleartextmailpws_reallywipe'] = 'Do you really want to wipe all unencrypted mail account passwords from the table mail_users? This cannot be reverted!';
$lng['admin']['configfiles']['overview'] = 'Przegląd';
$lng['admin']['configfiles']['wizard'] = 'Wizard';
$lng['admin']['configfiles']['distribution'] = 'Dystrybucja';
$lng['admin']['configfiles']['service'] = 'Usługa';
$lng['admin']['configfiles']['daemon'] = 'Daemon';
$lng['admin']['configfiles']['http'] = 'Webserwer (HTTP)';
$lng['admin']['configfiles']['dns'] = 'Serwer nazw (DNS)';
$lng['admin']['configfiles']['mail'] = 'Serwer pocztowy (IMAP/POP3)';
$lng['admin']['configfiles']['smtp'] = 'Serwer pocztowy (SMTP)';
$lng['admin']['configfiles']['ftp'] = 'Serwer FTP';
$lng['admin']['configfiles']['etc'] = 'Inne (Systemowe)';
$lng['admin']['configfiles']['choosedistribution'] = '-- Wybierz dystrybucję --';
$lng['admin']['configfiles']['chooseservice'] = '-- Wybierz usługę --';
$lng['admin']['configfiles']['choosedaemon'] = '-- Wybierz daemona --';

// ADDED IN 1.2.16-svn10

$lng['serversettings']['ftpdomain']['title'] = 'konta FTP @domena';
$lng['serversettings']['ftpdomain']['description'] = 'Klienci mogï¿½ tworzyï¿½ konta FTP uzytkownik@domenaklienta?';
$lng['panel']['back'] = 'Back';

// ADDED IN 1.2.16-svn12

$lng['serversettings']['mod_log_sql']['title'] = 'Temporary save logs in the database';
$lng['serversettings']['mod_log_sql']['description'] = 'Use <a target="blank" href="http://www.outoforder.cc/projects/apache/mod_log_sql/" title="mod_log_sql">mod_log_sql</a> to save webrequests temporarily<br /><b>This needs a special <a target="blank" href="http://files.froxlor.org/docs/mod_log_sql/" title="mod_log_sql - documentation">apache-configuration</a>!</b>';
$lng['serversettings']['mod_fcgid']['title'] = 'Include PHP via mod_fcgid/suexec';
$lng['serversettings']['mod_fcgid']['description'] = 'Use mod_fcgid/suexec/libnss_mysql to run PHP with the corresponding useraccount.<br/><b>This needs a special Webserver configuration. All following options are only valid if the module is enabled.</b>';
$lng['serversettings']['sendalternativemail']['title'] = 'Use alternative email-address';
$lng['serversettings']['sendalternativemail']['description'] = 'Send the password-email to a different address during email-account-creation';
$lng['emails']['alternative_emailaddress'] = 'Alternative e-mail-address';
$lng['mails']['pop_success_alternative']['mailbody'] = 'Hello,\n\nyour Mail account {EMAIL}\nwas set up successfully.\nYour password is {PASSWORD}.\n\nThis is an automatically created\ne-mail, please do not answer!\n\nYours sincerely, Administrator';
$lng['mails']['pop_success_alternative']['subject'] = 'Mail account set up successfully';
$lng['admin']['templates']['pop_success_alternative'] = 'Welcome mail for new email accounts sent to alternative address';
$lng['admin']['templates']['EMAIL_PASSWORD'] = 'Replaced with the POP3/IMAP account password.';

// ADDED IN 1.2.16-svn13

$lng['error']['documentrootexists'] = 'The directory "%s" already exists for this customer. Please remove this before adding the customer again.';

// ADDED IN 1.2.16-svn14

$lng['serversettings']['apacheconf_vhost']['title'] = 'Apache vhost configuration file/dirname';
$lng['serversettings']['apacheconf_vhost']['description'] = 'Where should the vhost configuration be stored? You could either specify a file (all vhosts in one file) or directory (each vhost in his own file) here.';
$lng['serversettings']['apacheconf_diroptions']['title'] = 'Apache diroptions configuration file/dirname';
$lng['serversettings']['apacheconf_diroptions']['description'] = 'Where should the diroptions configuration be stored? You could either specify a file (all diroptions in one file) or directory (each diroption in his own file) here.';
$lng['serversettings']['apacheconf_htpasswddir']['title'] = 'Apache htpasswd dirname';
$lng['serversettings']['apacheconf_htpasswddir']['description'] = 'Where should the htpasswd files for directory protection be stored?';

// ADDED IN 1.2.16-svn15

$lng['error']['formtokencompromised'] = 'The request seems to be compromised. For security reasons you were logged out.';
$lng['serversettings']['mysql_access_host']['title'] = 'MySQL-Access-Hosts';
$lng['serversettings']['mysql_access_host']['description'] = 'A comma separated list of hosts from which users should be allowed to connect to the MySQL-Server.';

// ADDED IN 1.2.18-svn1

$lng['admin']['ipsandports']['create_listen_statement'] = 'Create Listen statement';
$lng['admin']['ipsandports']['create_namevirtualhost_statement'] = 'Create NameVirtualHost statement';
$lng['admin']['ipsandports']['create_vhostcontainer'] = 'Create vHost-Container';
$lng['admin']['ipsandports']['create_vhostcontainer_servername_statement'] = 'Create ServerName statement in vHost-Container';

// ADDED IN 1.2.18-svn2

$lng['admin']['webalizersettings'] = 'Usttawienia Webalizera';
$lng['admin']['webalizer']['normal'] = 'Normalny';
$lng['admin']['webalizer']['quiet'] = 'Cichy';
$lng['admin']['webalizer']['veryquiet'] = 'Bez danych wyjï¿½cia';
$lng['serversettings']['webalizer_quiet']['title'] = 'Dane wyjï¿½cia Webalizera';
$lng['serversettings']['webalizer_quiet']['description'] = 'Gadatliwoï¿½ï¿½ programu Webalizer';

// ADDED IN 1.2.18-svn3

$lng['ticket']['admin_email'] = 'root@localhost';
$lng['ticket']['noreply_email'] = 'tickets@froxlor';
$lng['admin']['ticketsystem'] = 'Wsparcie teczniczne';
$lng['menue']['ticket']['ticket'] = 'Zgłoszenia wsparcia tech.';
$lng['menue']['ticket']['categories'] = 'Kategorie wsparcia';
$lng['menue']['ticket']['archive'] = 'Archiwum zgłoszeń';
$lng['ticket']['description'] = 'Here you can send help-requests to your responsible administrator.<br />Notifications will be sent via e-mail.';
$lng['ticket']['ticket_new'] = 'Utwï¿½rz nowe zgłoszenie';
$lng['ticket']['ticket_reply'] = 'Odpowiedź na zgłoszenie';
$lng['ticket']['ticket_reopen'] = 'Ponownie otwï¿½rz zgï¿½oszenie';
$lng['ticket']['ticket_newcateory'] = 'Utwï¿½rz nową kategorię';
$lng['ticket']['ticket_editcateory'] = 'Edytuj kategorię';
$lng['ticket']['ticket_view'] = 'View ticketcourse';
$lng['ticket']['ticketcount'] = 'Zgłoszenia';
$lng['ticket']['ticket_answers'] = 'Odpowiedzi';
$lng['ticket']['lastchange'] = 'Last action';
$lng['ticket']['subject'] = 'Temat';
$lng['ticket']['status'] = 'Status';
$lng['ticket']['lastreplier'] = 'Ostatnia odpowiedź';
$lng['ticket']['priority'] = 'Priorytet';
$lng['ticket']['low'] = 'Niski';
$lng['ticket']['normal'] = 'Normalny';
$lng['ticket']['high'] = 'Wysoki';
$lng['ticket']['lastchange'] = 'Ostatnia zmiana';
$lng['ticket']['lastchange_from'] = 'Od daty (dd.mm.yyyy)';
$lng['ticket']['lastchange_to'] = 'Do daty (dd.mm.yyyy)';
$lng['ticket']['category'] = 'Kategoria';
$lng['ticket']['no_cat'] = 'Brak';
$lng['ticket']['message'] = 'Wiadomość';
$lng['ticket']['show'] = 'Zobacz';
$lng['ticket']['answer'] = 'Odpowiedź';
$lng['ticket']['close'] = 'Zamknij';
$lng['ticket']['reopen'] = 'Ponownie otwï¿½rz';
$lng['ticket']['archive'] = 'Zarchiwizuj';
$lng['ticket']['ticket_delete'] = 'Kasuj zgłoszenie';
$lng['ticket']['lastarchived'] = 'Recently archived tickets';
$lng['ticket']['archivedtime'] = 'Archived';
$lng['ticket']['open'] = 'Otwarte';
$lng['ticket']['wait_reply'] = 'czeka na odpowiedz';
$lng['ticket']['replied'] = 'Replied';
$lng['ticket']['closed'] = 'Zamknięte';
$lng['ticket']['staff'] = 'Dział pomocy technicznej';
$lng['ticket']['customer'] = 'Klient';
$lng['ticket']['old_tickets'] = 'Ticket messages';
$lng['ticket']['search'] = 'Search archive';
$lng['ticket']['nocustomer'] = 'Nie wybrano';
$lng['ticket']['archivesearch'] = 'Archive searchresults';
$lng['ticket']['noresults'] = 'Nie znaleziono zgłoszeń';
$lng['ticket']['notmorethanxopentickets'] = 'Due to spam-protection you cannot have more than %s open tickets';
$lng['ticket']['supportstatus'] = 'Status wsparcia technicznego';
$lng['ticket']['supportavailable'] = '<span class="ticket_low">Dział wsparcia technicznego jest aktualnie dostępny.</span>';
$lng['ticket']['supportnotavailable'] = '<span class="ticket_high">Dział wsparcia technicznego nie jest dostępny w tym momencie. Odpowiedź może zabrać chwilę czasu.</span>';
$lng['admin']['templates']['ticket'] = 'Notification-mails for support-tickets';
$lng['admin']['templates']['SUBJECT'] = 'Replaced with the support-ticket subject';
$lng['admin']['templates']['new_ticket_for_customer'] = 'Klient-informacja, że zgłoszenie pomocy technicznej zostały wysłane';
$lng['admin']['templates']['new_ticket_by_customer'] = 'Administrator-informacja, że zgłoszenie pomocy technicznej zostało otwarte przez klienta';
$lng['admin']['templates']['new_reply_ticket_by_customer'] = 'Administrator-powiadomienie o odpowiedzi klienta na zgłoszenie pomocy technicznej';
$lng['admin']['templates']['new_ticket_by_staff'] = 'Klient-informacja, że zgłoszenie pomocy technicznej zostało otwarte przez Administratora';
$lng['admin']['templates']['new_reply_ticket_by_staff'] = 'Klient-informacja, że pomoc techniczna wysłała odpowiedź na zgłoszenie';
$lng['mails']['new_ticket_for_customer']['mailbody'] = 'Witaj {FIRSTNAME} {NAME},\n\nTwoje zgłoszenie pomocy technicznej o temacie "{SUBJECT}" zostało wysłane.\n\nZostaniesz powiadomiony, kiedy Dział pomocy technicznej odpowie na Towje zgłoszenie.\n\nDziękujemy,\nFroxlor';
$lng['mails']['new_ticket_for_customer']['subject'] = 'Twoje zgłoszenie pomocy technicznej zostało wysłane';
$lng['mails']['new_ticket_by_customer']['mailbody'] = 'Hello admin,\n\na new support-ticket with the subject "{SUBJECT}" has been submitted.\n\nPlease login to open the ticket.\n\nThank you,\nthe Froxlor';
$lng['mails']['new_ticket_by_customer']['subject'] = 'New support ticket submitted';
$lng['mails']['new_reply_ticket_by_customer']['mailbody'] = 'Hello admin,\n\nthe support-ticket "{SUBJECT}" has been answered by a customer.\n\nPlease login to open the ticket.\n\nThank you,\nthe Froxlor';
$lng['mails']['new_reply_ticket_by_customer']['subject'] = 'New reply to support ticket';
$lng['mails']['new_ticket_by_staff']['mailbody'] = 'Hello {FIRSTNAME} {NAME},\n\na support-ticket with the subject "{SUBJECT}" has been opened for you.\n\nPlease login to open the ticket.\n\nThank you,\nthe Froxlor';
$lng['mails']['new_ticket_by_staff']['subject'] = 'New support ticket submitted';
$lng['mails']['new_reply_ticket_by_staff']['mailbody'] = 'Hello {FIRSTNAME} {NAME},\n\nthe support-ticket with the subject "{SUBJECT}" has been answered by our staff.\n\nPlease login to view the ticket.\n\nThank you,\nthe Froxlor';
$lng['mails']['new_reply_ticket_by_staff']['subject'] = 'New reply to support ticket';
$lng['question']['ticket_reallyclose'] = 'Czy na pewno chcesz zamknąć zgłoszenie "%s"?';
$lng['question']['ticket_reallydelete'] = 'Czy na pewno chcesz skasowac zgłoszenie "%s"?';
$lng['question']['ticket_reallydeletecat'] = 'Czy na pewno chcesz skasowac kategorię "%s"?';
$lng['question']['ticket_reallyarchive'] = 'Do you really want to move the ticket "%s" to the archive?';
$lng['error']['mysubject'] = '\'' . $lng['ticket']['subject'] . '\'';
$lng['error']['mymessage'] = '\'' . $lng['ticket']['message'] . '\'';
$lng['error']['mycategory'] = '\'' . $lng['ticket']['category'] . '\'';
$lng['error']['nomoreticketsavailable'] = 'You have used all your available tickets. Please contact your administrator.';
$lng['error']['nocustomerforticket'] = 'Cannot create tickets without customers';
$lng['error']['categoryhastickets'] = 'The category still has tickets in it.<br />Please delete the tickets to delete the category';
$lng['error']['notmorethanxopentickets'] = $lng['ticket']['notmorethanxopentickets'];
$lng['admin']['ticketsettings'] = 'Ustawienia wsparcia technicznego';
$lng['admin']['archivelastrun'] = 'Ostatnia archiwizacja zgłoszeń pomocy technicznej';
$lng['serversettings']['ticket']['noreply_email'] = 'No-reply e-mail address';
$lng['serversettings']['ticket']['noreply_email_desc'] = 'The sender-address for support-ticket, mostly something like no-reply@domain.tld';
$lng['serversettings']['ticket']['worktime_begin'] = 'Początek czasu wsparcia technicznego (hh:mm)';
$lng['serversettings']['ticket']['worktime_begin_desc'] = 'Początek czasu od kiedy wsparcie techniczne jest dostępne';
$lng['serversettings']['ticket']['worktime_end'] = 'Koniec czasu wsparcia technicznego (hh:mm)';
$lng['serversettings']['ticket']['worktime_end_desc'] = 'Koniec czasu do kiedy wsparcie techniczne jest dostępne';
$lng['serversettings']['ticket']['worktime_sat'] = 'Dział pomocy technicznej dostępny w soboty?';
$lng['serversettings']['ticket']['worktime_sun'] = 'Dział pomocy technicznej dostępny w niedziele?';
$lng['serversettings']['ticket']['worktime_all'] = 'Dział pomocy technicznej działa bez przerwy';
$lng['serversettings']['ticket']['worktime_all_desc'] = 'If "Yes" the options for start- and endtime will be overwritten';
$lng['serversettings']['ticket']['archiving_days'] = 'After how many days should closed tickets be archived?';
$lng['customer']['tickets'] = 'Zgłoszenia wsparcia technicznego';

// ADDED IN 1.2.18-svn4

$lng['admin']['domain_nocustomeraddingavailable'] = 'Nie jest możliwe, by dodać teraz domenę. W pierwszej kolejności trzeba dodać klienta.';
$lng['serversettings']['ticket']['enable'] = 'Wspracie techniczne włączone';
$lng['serversettings']['ticket']['concurrentlyopen'] = 'Ile zgï¿½oszeï¿½ moï¿½e byï¿½ otwartych w jednym czasie?';
$lng['error']['norepymailiswrong'] = 'The "Noreply-address" is wrong. Only a valid email-address is allowed.';
$lng['error']['tadminmailiswrong'] = 'The "Ticketadmin-address" is wrong. Only a valid email-address is allowed.';
$lng['ticket']['awaitingticketreply'] = 'Masz %s zgłoszeń do pomocy technicznej';

// ADDED IN 1.2.18-svn5

$lng['serversettings']['ticket']['noreply_name'] = 'Ticket e-mail sendername';

// ADDED IN 1.2.19-svn1

$lng['serversettings']['mod_fcgid']['configdir'] = 'Configuration directory';
$lng['serversettings']['mod_fcgid']['configdir_desc'] = 'Where should all fcgid-configuration files be stored? If you don\'t use a self compiled suexec binary, which is the normal situation, this path must be under /var/www/';
$lng['serversettings']['mod_fcgid']['tmpdir'] = 'Katalog plikï¿½w tymczasowych';

// ADDED IN 1.2.19-svn3

$lng['serversettings']['ticket']['reset_cycle'] = 'Okresowe reset licznika użycia zgłoszeń pomocy technicznej';
$lng['serversettings']['ticket']['reset_cycle_desc'] = 'Resetowanie zgłoszeń pomocy technicznej powoduje ustawienie licznika na wartość 0 przy każdym cyklu';
$lng['admin']['tickets']['daily'] = 'Dziennie';
$lng['admin']['tickets']['weekly'] = 'Wygodniowo';
$lng['admin']['tickets']['monthly'] = 'Miesięcznie';
$lng['admin']['tickets']['yearly'] = 'Rocznie';
$lng['error']['ticketresetcycleiswrong'] = 'The cycle for ticket-resets has to be "daily", "weekly", "monthly" or "yearly".';

// ADDED IN 1.2.19-svn4

$lng['menue']['traffic']['traffic'] = 'Ruch';
$lng['menue']['traffic']['current'] = 'Obecny miesiąc';
$lng['traffic']['month'] = "Miesiąc";
$lng['traffic']['day'] = "Dzień";
$lng['traffic']['months'][1] = "Styczeń";
$lng['traffic']['months'][2] = "Luty";
$lng['traffic']['months'][3] = "Marzec";
$lng['traffic']['months'][4] = "Kwiecień";
$lng['traffic']['months'][5] = "Maj";
$lng['traffic']['months'][6] = "Czerwiec";
$lng['traffic']['months'][7] = "Lipiec";
$lng['traffic']['months'][8] = "Sierpień";
$lng['traffic']['months'][9] = "Wrzesień";
$lng['traffic']['months'][10] = "Październik";
$lng['traffic']['months'][11] = "Listopad";
$lng['traffic']['months'][12] = "Grudzień";
$lng['traffic']['mb'] = "Ruch (MB)";
$lng['traffic']['distribution'] = '<font color="#019522">FTP</font> | <font color="#0000FF">HTTP</font> | <font color="#800000">Mail</font>';
$lng['traffic']['sumhttp'] = 'Sumaryczny ruch HTTP podany w';
$lng['traffic']['sumftp'] = 'Sumaryczny ruch FTP podany w';
$lng['traffic']['summail'] = 'Sumaryczny ruch e-Mail podany w';

// ADDED IN 1.2.19-svn4.5

$lng['serversettings']['no_robots']['title'] = 'Zezwalaj na indeksowanie panelu przez roboty wyszukiwarek';

// ADDED IN 1.2.19-svn6

$lng['admin']['loggersettings'] = 'Ustawienia Logï¿½w';
$lng['serversettings']['logger']['enable'] = 'Logowanie włączone/wyłączone';
$lng['serversettings']['logger']['severity'] = 'Poziom logowania';
$lng['admin']['logger']['normal'] = 'normalny';
$lng['admin']['logger']['paranoid'] = 'paranoidalny';
$lng['serversettings']['logger']['types'] = 'Rodzaj(e) logï¿½w';
$lng['serversettings']['logger']['types_desc'] = 'Specify logtypes seperated by comma.<br />Available logtypes are: syslog, file, mysql';
$lng['serversettings']['logger']['logfile'] = 'Logfile path including filename';
$lng['error']['logerror'] = 'System logowania błędï¿½w: %s';
$lng['serversettings']['logger']['logcron'] = 'Log cronjobs (one run)';
$lng['question']['logger_reallytruncate'] = 'Czy na pewno chcesz wyszyścić tabelę "%s"?';
$lng['admin']['loggersystem'] = 'System logowania';
$lng['menue']['logger']['logger'] = 'System logowania';
$lng['logger']['date'] = 'Data';
$lng['logger']['type'] = 'Typ';
$lng['logger']['action'] = 'Akcja';
$lng['logger']['user'] = 'Użytkownik';
$lng['logger']['truncate'] = 'Wyszyść logi';

// ADDED IN 1.2.19-svn7

$lng['serversettings']['ssl']['use_ssl'] = 'Uï¿½yj SSL';
$lng['serversettings']['ssl']['ssl_cert_file'] = 'Gdzie jest zlokalizowany Certyfikat';
$lng['serversettings']['ssl']['openssl_cnf'] = 'Standardowe dane do tworzenia pliku certyfikatu';
$lng['panel']['reseller'] = 'reseller';
$lng['panel']['admin'] = 'administrator';
$lng['panel']['customer'] = 'klient/ci';
$lng['error']['nomessagetosend'] = 'Nie wprowadzono wiadomości.';
$lng['error']['noreceipientsgiven'] = 'Nie wprowadzono żadnego odbiorcy';
$lng['admin']['emaildomain'] = 'Emaildomain';
$lng['admin']['email_only'] = 'Only email?';
$lng['admin']['wwwserveralias'] = 'Dodaï¿½ "www." ServerAlias';
$lng['admin']['ipsandports']['enable_ssl'] = 'Is this an SSL Port?';
$lng['admin']['ipsandports']['ssl_cert_file'] = 'Path to the SSL Certificate';
$lng['panel']['send'] = 'send';
$lng['admin']['subject'] = 'Temat';
$lng['admin']['receipient'] = 'Odbiorca';
$lng['admin']['message'] = 'Napisz wiadomość';
$lng['admin']['text'] = 'Wiadomość';
$lng['menu']['message'] = 'Wiadomości';
$lng['error']['errorsendingmail'] = 'The message to "%s" failed';
$lng['error']['cannotreaddir'] = 'Nie mogę przeczytać katalogu "%s"';
$lng['message']['success'] = 'Successfully sent message to %s recipients';
$lng['message']['noreceipients'] = 'No e-mail has been sent because there are no recipients in the database';
$lng['admin']['sslsettings'] = 'Ustawienia SSL';
$lng['cronjobs']['notyetrun'] = 'Nigdy nie uruchamiany';
$lng['install']['servername_should_be_fqdn'] = 'The servername should be a FQDN and not an IP address';
$lng['serversettings']['default_vhostconf']['title'] = 'Default vhost-settings';
$lng['serversettings']['default_vhostconf']['description'] = 'The content of this field will be included into every domain vhost container directly. Attention: The code won\'t be checked for any errors. If it contains errors, apache might ot start again!';
$lng['error']['invalidip'] = 'Niepoprawny adres IP: %s';
$lng['serversettings']['decimal_places'] = 'Number of decimal places in traffic/webspace output';

// ADDED IN 1.2.19-svn8

$lng['admin']['dkimsettings'] = 'Ustawienia DomainKey';
$lng['dkim']['dkim_prefix']['title'] = 'Prefix';
$lng['dkim']['dkim_prefix']['description'] = 'Please specify the path to the DKIM RSA-files as well as to the configuration files for the Milter-plugin';
$lng['dkim']['dkim_domains']['title'] = 'Domains filename';
$lng['dkim']['dkim_domains']['description'] = '<em>Filename</em> of the DKIM Domains parameter specified in the dkim-milter configuration';
$lng['dkim']['dkim_dkimkeys']['title'] = 'KeyList filename';
$lng['dkim']['dkim_dkimkeys']['description'] = '<em>Filename</em> of the  DKIM KeyList parameter specified in the dkim-milter configuration';
$lng['dkim']['dkimrestart_command']['title'] = 'Milter restart command';
$lng['dkim']['dkimrestart_command']['description'] = 'Please specify the restart command for the DKIM milter service';

// ADDED IN 1.2.19-svn9

$lng['admin']['caneditphpsettings'] = 'Can change php-related domain settings?';

// ADDED IN 1.2.19-svn12

$lng['admin']['allips'] = 'Wszystkie IP\'s';
$lng['panel']['nosslipsavailable'] = 'There are currently no ssl ip/port combinations for this server';
$lng['ticket']['by'] = 'przez';
$lng['dkim']['use_dkim']['title'] = 'Activate DKIM support?';
$lng['dkim']['use_dkim']['description'] = 'Would you like to use the Domain Keys (DKIM) system?';
$lng['error']['invalidmysqlhost'] = 'Invalid MySQL host address: %s';
$lng['error']['cannotuseawstatsandwebalizeratonetime'] = 'You cannot enable Webalizer and Awstats at the same time, please chose one of them';
$lng['serversettings']['webalizer_enabled'] = 'Enable webalizer statistics';
$lng['serversettings']['awstats_enabled'] = 'Enable awstats statistics';
$lng['admin']['awstatssettings'] = 'Ustawienia Awstats';
$lng['serversettings']['awstats_domain_file']['title'] = 'Awstats domainfiles directory';
$lng['serversettings']['awstats_model_file']['title'] = 'Awstats model file';

// ADDED IN 1.2.19-svn16

$lng['admin']['domain_dns_settings'] = 'Domain dns settings';
$lng['dns']['destinationip'] = 'Domain IP';
$lng['dns']['standardip'] = 'Server standard IP';
$lng['dns']['a_record'] = 'A-Record (IPv6 optional)';
$lng['dns']['cname_record'] = 'CNAME-Record';
$lng['dns']['mxrecords'] = 'Define MX records';
$lng['dns']['standardmx'] = 'Server tandard MX record';
$lng['dns']['mxconfig'] = 'Custom MX records';
$lng['dns']['priority10'] = 'Priority 10';
$lng['dns']['priority20'] = 'Priority 20';
$lng['dns']['txtrecords'] = 'Define TXT records';
$lng['dns']['txtexample'] = 'Example (SPF-entry):<br />v=spf1 ip4:xxx.xxx.xx.0/23 -all';
$lng['serversettings']['selfdns']['title'] = 'Customer domain dns settings';
$lng['serversettings']['selfdnscustomer']['title'] = 'Zezwalaj klientom na edycję ustawień DNS dla domeny';
$lng['admin']['activated'] = 'Uaktywniony';
$lng['admin']['statisticsettings'] = 'Ustawienia Statystyk';
$lng['admin']['or'] = 'or';

// ADDED IN 1.2.19-svn17

$lng['serversettings']['unix_names']['title'] = 'Use UNIX compatible usernames';
$lng['serversettings']['unix_names']['description'] = 'Allows you to use <strong>-</strong> and <strong>_</strong> in usernames if <strong>No</strong>';
$lng['error']['cannotwritetologfile'] = 'Cannot open logfile %s for writing';
$lng['admin']['sysload'] = 'Obciążenie systemu';
$lng['admin']['noloadavailable'] = 'not available';
$lng['admin']['nouptimeavailable'] = 'not available';
$lng['panel']['backtooverview'] = 'Back to overview';
$lng['admin']['nosubject'] = '(Brak tematu)';
$lng['admin']['configfiles']['statistics'] = 'Statistics';
$lng['login']['forgotpwd'] = 'Zapomniane hasło?';
$lng['login']['presend'] = 'Zresetuj hasło';
$lng['login']['email'] = 'Adres e-mail';
$lng['login']['remind'] = 'Zresetuj moje hasło';
$lng['login']['usernotfound'] = 'Użytkownik nie znaleziony!';
$lng['pwdreminder']['subject'] = 'Froxlor - Password reset';
$lng['pwdreminder']['body'] = 'Hello %s,\n\nyour froxlor password has been reset!\nThe new password is: %p\n\nThank you,\nAdministrator';
$lng['pwdreminder']['success'] = 'Password reset successfully.<br />You now should receive an email with your new password.';

// ADDED IN 1.2.19-svn18

$lng['serversettings']['allow_preset'] = 'Allow password reset by customers';
$lng['pwdreminder']['notallowed'] = 'Password reset is deactivated';

// ADDED IN 1.2.19-svn20

$lng['serversettings']['awstats_path']['title'] = 'Path to awstats cgi-bin folder';
$lng['serversettings']['awstats_path']['description'] = 'e.g. /usr/share/webapps/awstats/6.1/webroot/cgi-bin/';
$lng['serversettings']['awstats_updateall_command']['title'] = 'Path to "awstats_updateall.pl"';
$lng['serversettings']['awstats_updateall_command']['description'] = 'e.g. /usr/bin/awstats_updateall.pl';

// ADDED IN 1.2.19-svn21

$lng['customer']['title'] = 'Tytuł';
$lng['customer']['country'] = 'Kraj';
$lng['panel']['dateformat'] = 'YYYY-MM-DD';
$lng['panel']['dateformat_function'] = 'Y-m-d';

// Y = Year, m = Month, d = Day

$lng['panel']['timeformat_function'] = 'H:i:s';

// H = Hour, i = Minute, s = Second

$lng['panel']['default'] = 'Default';
$lng['panel']['never'] = 'Never';
$lng['panel']['active'] = 'Active';
$lng['panel']['please_choose'] = 'Please choose';
$lng['panel']['allow_modifications'] = 'Allow modifications';
$lng['domains']['add_date'] = 'Added to Froxlor';
$lng['domains']['registration_date'] = 'Added at registry';
$lng['domains']['topleveldomain'] = 'Top-Level-Domain';

// ADDED IN 1.2.19-svn22

$lng['serversettings']['allow_password_reset']['description'] = 'Customers can reset their password and a new password will be sent to their e-mail address';
$lng['serversettings']['allow_password_reset_admin']['title'] = 'Allow password reset by admins';
$lng['serversettings']['allow_password_reset_admin']['description'] = 'Admins/reseller can reset their password and a new password will be sent to their e-mail address';

// ADDED IN 1.2.19-svn25

$lng['emails']['quota'] = 'Quota';
$lng['emails']['noquota'] = 'No quota';
$lng['emails']['updatequota'] = 'Update Quota';
$lng['serversettings']['mail_quota']['title'] = 'Mailbox-quota';
$lng['serversettings']['mail_quota']['description'] = 'The default quota for a new created mailboxes (MegaByte).';
$lng['serversettings']['mail_quota_enabled']['title'] = 'Use mailbox-quota for customers';
$lng['serversettings']['mail_quota_enabled']['description'] = 'Activate to use quotas on mailboxes. Default is <b>No</b> since this requires a special setup.';
$lng['serversettings']['mail_quota_enabled']['removelink'] = 'Click here to wipe all quotas for mail accounts.';
$lng['serversettings']['mail_quota_enabled']['enforcelink'] = 'Click here to enforce default quota to all User mail accounts.';
$lng['question']['admin_quotas_reallywipe'] = 'Do you really want to wipe all quotas on table mail_users? This cannot be reverted!';
$lng['question']['admin_quotas_reallyenforce'] = 'Do you really want to enforce the default quota to all Users? This cannot be reverted!';
$lng['error']['vmailquotawrong'] = 'The quotasize must be positive number.';
$lng['customer']['email_quota'] = 'E-mail quota';
$lng['customer']['email_imap'] = 'E-mail IMAP';
$lng['customer']['email_pop3'] = 'E-mail POP3';
$lng['customer']['mail_quota'] = 'Mailquota';
$lng['panel']['megabyte'] = 'MegaByte';
$lng['panel']['not_supported'] = 'Not supported in: ';
$lng['emails']['quota_edit'] = 'Change E-Mail Quota';
$lng['error']['allocatetoomuchquota'] = 'You tried to allocate %s MB ' . $lng['emails']['quota'] . ', but you do not have enough left.';

// Autoresponder module

$lng['menue']['email']['autoresponder'] = 'Autoresponder';
$lng['autoresponder']['active'] = 'Aktywny';
$lng['autoresponder']['autoresponder_add'] = 'Dodaj autoresponder';
$lng['autoresponder']['autoresponder_edit'] = 'Edytuj autoresponder';
$lng['autoresponder']['autoresponder_new'] = 'Utwï¿½rz nowy autoresponder';
$lng['autoresponder']['subject'] = 'Temat';
$lng['autoresponder']['message'] = 'Wiadomość';
$lng['autoresponder']['account'] = 'Konto';
$lng['autoresponder']['sender'] = 'Nadawca';
$lng['question']['autoresponderdelete'] = 'Czy napewno chcesz skasować autoresponder?';
$lng['error']['noemailaccount'] = 'There can be two reasons why you cannot create a new autoresponder: You need at least one email account to create a new autoresponder. Secondly it can be possible that all accounts already have an autoresponder configured.';
$lng['error']['missingfields'] = 'Not all required fields were filled out.';
$lng['error']['accountnotexisting'] = 'The given email account doesn\'t exist.';
$lng['error']['autoresponderalreadyexists'] = 'There is already an autoresponder configured for this account.';
$lng['error']['invalidautoresponder'] = 'The given account is invalid.';
$lng['serversettings']['autoresponder_active']['title'] = 'Użyj modułu autorespondera';
$lng['serversettings']['autoresponder_active']['description'] = 'Do you want to use the autoresponder module?';
$lng['admin']['security_settings'] = 'Security Options';
$lng['admin']['know_what_youre_doing'] = 'Zmień TYLKO jeśli wiesz co robisz!';
$lng['admin']['show_version_login']['title'] = 'Pokazuj wersję Froxlora przy logowaniu';
$lng['admin']['show_version_login']['description'] = 'Pokazuj wersję Froxlora w stopce struno logowania';
$lng['admin']['show_version_footer']['title'] = 'Pokazuj wersję Froxlora w stopce';
$lng['admin']['show_version_footer']['description'] = 'Pokazuj wersję Froxlora w stopce na pozostałych stronach';
$lng['admin']['froxlor_graphic']['title'] = 'Nagłï¿½wek graficzny dla Froxlora';
$lng['admin']['froxlor_graphic']['description'] = 'jaka grafika powinna być pokazywana w nagłï¿½wku';

//improved froxlor

$lng['menue']['phpsettings']['maintitle'] = 'Konfiguracje PHP';
$lng['admin']['phpsettings']['title'] = 'Konfiguracja PHP';
$lng['admin']['phpsettings']['description'] = 'krï¿½tki opis';
$lng['admin']['phpsettings']['actions'] = 'Actions';
$lng['admin']['phpsettings']['activedomains'] = 'In use for domain(s)';
$lng['admin']['phpsettings']['notused'] = 'Configuration not in use';
$lng['admin']['misc'] = 'Rï¿½żne';
$lng['admin']['phpsettings']['editsettings'] = 'Zmień ustawienia PHP';
$lng['admin']['phpsettings']['addsettings'] = 'Utwï¿½rz nowe ustawienia PHP';
$lng['admin']['phpsettings']['viewsettings'] = 'Zobacz ustawienia PHP';
$lng['admin']['phpsettings']['phpinisettings'] = 'ustawienia php.ini';
$lng['error']['nopermissionsorinvalidid'] = 'You don\'t have enough permissions to change these settings or an invalid id was given.';
$lng['panel']['view'] = 'view';
$lng['question']['phpsetting_reallydelete'] = 'Do you really want to delete these settings? All domains which use these settings currently will be changed to the default config.';
$lng['admin']['phpsettings']['addnew'] = 'Utwï¿½rz nowe ustawienia';
$lng['error']['phpsettingidwrong'] = 'A PHP Configuration with this id doesn\'t exist';
$lng['error']['descriptioninvalid'] = 'The description is too short, too long or contains illegal characters.';
$lng['error']['info'] = 'Info';
$lng['admin']['phpconfig']['template_replace_vars'] = 'Variables that will be replaced in the configs';
$lng['admin']['phpconfig']['safe_mode'] = 'Will be replaced with the safe_mode setting of the domain.';
$lng['admin']['phpconfig']['pear_dir'] = 'Will be replaced with the global setting for the pear directory.';
$lng['admin']['phpconfig']['open_basedir_c'] = 'Will insert a ; (semicolon) to comment-out/disable open_basedir when set';
$lng['admin']['phpconfig']['open_basedir'] = 'Will be replaced with the open_basedir setting of the domain.';
$lng['admin']['phpconfig']['tmp_dir'] = 'Will be replaced with the temporary directory of the domain.';
$lng['admin']['phpconfig']['open_basedir_global'] = 'Will be replaced with the global value of the path which will be attached to the open_basedir.';
$lng['admin']['phpconfig']['customer_email'] = 'Will be replaced with the e-mail address of the customer who owns this domain.';
$lng['admin']['phpconfig']['admin_email'] = 'Will be replaced with e-mail address of the admin who owns this domain.';
$lng['admin']['phpconfig']['domain'] = 'Will be replaced with the domain.';
$lng['admin']['phpconfig']['customer'] = 'Will be replaced with the loginname of the customer who owns this domain.';
$lng['admin']['phpconfig']['admin'] = 'Will be replaced with the loginname of the admin who owns this domain.';
$lng['login']['backtologin'] = 'Powrï¿½t do logowania';
$lng['serversettings']['mod_fcgid']['starter']['title'] = 'Procesï¿½w na Domenę';
$lng['serversettings']['mod_fcgid']['starter']['description'] = 'How many processes should be started/allowed per domain? The value 0 is recommended cause PHP will then manage the amount of processes itself very efficiently.';
$lng['serversettings']['mod_fcgid']['wrapper']['title'] = 'Wrapper in Vhosts';
$lng['serversettings']['mod_fcgid']['wrapper']['description'] = 'How should the wrapper be included in the Vhosts';
$lng['serversettings']['mod_fcgid']['tmpdir']['description'] = 'Where should the temp directories be stored';
$lng['serversettings']['mod_fcgid']['peardir']['title'] = 'Global PEAR directories';
$lng['serversettings']['mod_fcgid']['peardir']['description'] = 'Which global PEAR directories should be replaced in every php.ini config? Different directories must be separated by a colon.';

//improved Froxlor  2

$lng['admin']['templates']['index_html'] = 'index file for newly created customer directories';
$lng['admin']['templates']['SERVERNAME'] = 'Zamieniane na nazwę serwera.';
$lng['admin']['templates']['CUSTOMER'] = 'Zamieniane na login klienta.';
$lng['admin']['templates']['ADMIN'] = 'Zamieniane na nazwę administratora.';
$lng['admin']['templates']['CUSTOMER_EMAIL'] = 'Zamieniane na konto e-mail klienta.';
$lng['admin']['templates']['ADMIN_EMAIL'] = 'Zamieniane na konto e-mail administratora.';
$lng['admin']['templates']['filetemplates'] = 'Pliki szablonï¿½w';
$lng['admin']['templates']['filecontent'] = 'File content';
$lng['error']['filecontentnotset'] = 'Plik nie może być pusty!';
$lng['serversettings']['index_file_extension']['description'] = 'Which file extension should be used for the index file in newly created customer directories? This file extension will be used, if you or one of your admins has created its own index file template.';
$lng['serversettings']['index_file_extension']['title'] = 'File extension for index file in newly created customer directories';
$lng['error']['index_file_extension'] = 'The file extension for the index file must be between 1 and 6 characters long. The extension can only contain characters like a-z, A-Z and 0-9';
$lng['admin']['expert_settings'] = 'Ustawienia Experta!';
$lng['admin']['mod_fcgid_starter']['title'] = 'Procesï¿½w PHO na tą Domenę (pozostaw puste dla wartości domyślej)';

//added with aps installer

$lng['admin']['aps'] = 'Instalator aplikacji';
$lng['customer']['aps'] = 'Instalator aplikacji';
$lng['aps']['scan'] = 'Szukaj aktualizacji';
$lng['aps']['upload'] = 'Upload nowych paczek';
$lng['aps']['managepackages'] = 'Zarządzaj paczkami';
$lng['aps']['manageinstances'] = 'Zarządzaj Instalacjami';
$lng['aps']['overview'] = 'Przegląd paczek';
$lng['aps']['status'] = 'Moje paczki';
$lng['aps']['search'] = 'Szukaj paczki';
$lng['aps']['upload_description'] = 'Please select the APS Installer zipfiles to install them in the system.';
$lng['aps']['search_description'] = 'Nazwa, Opis, Słowa kluczowe, Wersja';
$lng['aps']['detail'] = 'Więcej informacji';
$lng['aps']['install'] = 'Instaluj paczkę';
$lng['aps']['data'] = 'Dane';
$lng['aps']['version'] = 'Wersja';
$lng['aps']['homepage'] = 'Strona domowa';
$lng['aps']['installed_size'] = 'Rozmiar po instalacji';
$lng['aps']['categories'] = 'Kategorie';
$lng['aps']['languages'] = 'Języki';
$lng['aps']['long_description'] = 'Długi opis';
$lng['aps']['configscript'] = 'Skrypt konfiguracyjny';
$lng['aps']['changelog'] = 'Hostoria zmian';
$lng['aps']['license'] = 'Licencja';
$lng['aps']['license_link'] = 'Link do licencji';
$lng['aps']['screenshots'] = 'Zrzuty ekranowe';
$lng['aps']['back'] = 'Powrï¿½t do listy';
$lng['aps']['install_wizard'] = 'Installation wizard...';
$lng['aps']['wizard_error'] = 'Your input contains invalid data. Please correct yourself to continue the installation.';
$lng['aps']['basic_settings'] = 'Proste ustawienia';
$lng['aps']['application_location'] = 'Lokalizacji instalacji';
$lng['aps']['application_location_description'] = 'Lokalizacja, gdzie ma być przeprowadzona instalacja.';
$lng['aps']['no_domains'] = 'Nie znaleziono domen';
$lng['aps']['database_password'] = 'Hasło bazy danych';
$lng['aps']['database_password_description'] = 'Password which should be used for the new created database.';
$lng['aps']['license_agreement'] = 'Agreement';
$lng['aps']['cancel_install'] = 'Przerwij instalację';
$lng['aps']['notazipfile'] = 'Uploadowany plik nie jest plikiem typu ZIP.';
$lng['aps']['filetoobig'] = 'Plik jest za duży.';
$lng['aps']['filenotcomplete'] = 'Plik nie został załadowany w całońci.';
$lng['aps']['phperror'] = 'There occured a PHP internal error. The PHP upload errorcode is #';
$lng['aps']['moveproblem'] = 'The script failed to move the uploaded file into the destination directory. Please ensure that all permissions are set correctly.';
$lng['aps']['uploaderrors'] = '<strong>Errors for the file <em>%s</em></strong><br/><ul>%s</ul>';
$lng['aps']['nospecialchars'] = 'Special characters are not allowed in the search term!';
$lng['aps']['noitemsfound'] = 'Nie znaleziono paczek!';
$lng['aps']['nopackagesinstalled'] = 'You haven\'t installed any package yet which could be shown.';
$lng['aps']['instance_install'] = 'Instalacja Paczki w toku';
$lng['aps']['instance_task_active'] = 'Instalacja właśnie jest realizowana';
$lng['aps']['instance_success'] = 'Paczka jest zainstalowana/Instalacja przebiegła pomyślnie';
$lng['aps']['instance_error'] = 'Paczka nie została zainstalowana - Wystąpiły błędy podczas instalacji';
$lng['aps']['instance_uninstall'] = 'Deinstalacja w toku';
$lng['aps']['unknown_status'] = 'Błąd  o nieznanej wartości';
$lng['aps']['currentstatus'] = 'Obecny status';
$lng['aps']['activetasks'] = 'Obecne zadanie';
$lng['aps']['task_install'] = 'Instalacja w toku';
$lng['aps']['task_remove'] = 'Deinstalacja w toku';
$lng['aps']['task_reconfigure'] = 'Rekonfiguracja w toku';
$lng['aps']['task_upgrade'] = 'Aktualizacja w toku';
$lng['aps']['no_task'] = 'Brak zaplanowanych zadań';
$lng['aps']['applicationlinks'] = 'Linki aplikacji';
$lng['aps']['mainsite'] = 'Strona głï¿½wna aplikacji';
$lng['aps']['uninstall'] = 'Odinstaluj paczkę';
$lng['aps']['reconfigure'] = 'Zmiana ustawień';
$lng['aps']['erroronnewinstance'] = '<strong>This Package cannot be installed.</strong><br/><br/>Please go back to the Package overview and start a new Installation.';
$lng['aps']['successonnewinstance'] = '<strong><em>%s</em> zostanie zainstalowany.</strong><br/><br/>Wrï¿½ć do zakładki "Moje paczki" i poczekaj aż instalator oprogramowania skończy instalację. Może to chwilę zająć.';
$lng['aps']['php_misc_handler'] = 'PHP - Misc - There is no support for other file extensions than .php for the PHP Parser.';
$lng['aps']['php_misc_directoryhandler'] = 'PHP - Misc - There is no support for per directory disabled PHP Handlers.';
$lng['aps']['asp_net'] = 'ASP.NET - Paczka nie jest wspierana.';
$lng['aps']['cgi'] = 'CGI - Paczka nie jest wspierana.';
$lng['aps']['php_extension'] = 'PHP - Brakujący moduł "%s".';
$lng['aps']['php_function'] = 'PHP - Brakująca funkcja "%s".';
$lng['aps']['php_configuration'] = 'PHP - Configuracja - Current "%s" setting not supported by Package.';
$lng['aps']['php_configuration_post_max_size'] = 'PHP - Configuracja - "post_max_size" ma za małą wartość.';
$lng['aps']['php_configuration_memory_limit'] = 'PHP - Configuracja - "memory_limit" ma za małą wartość.';
$lng['aps']['php_configuration_max_execution_time'] = 'PHP - Configuracja - "max_execution_time" ma za małą wartość.';
$lng['aps']['php_general_old'] = 'PHP - Ogï¿½lne - Wersja PHP jest za stara.';
$lng['aps']['php_general_new'] = 'PHP - Ogï¿½lne - Wersja PHP jest za nowa.';
$lng['aps']['db_mysql_support'] = 'Database - The Package needs another database engine than MySQL.';
$lng['aps']['db_mysql_version'] = 'Baza danych - Serwer MySQL jest za stary.';
$lng['aps']['webserver_module'] = 'Webserwer - Brakujący moduł "%s".';
$lng['aps']['webserver_fcgid'] = 'Webserver - This Package requires additional modules from the Webserver. In your FastCGI/mod_fcgid environment the function "apache_get_modules" doesn\'t exist. The Package cannot be installed because the APS Installer is unable to verify if this modules are installed.';
$lng['aps']['webserver_htaccess'] = 'Webserver - This Package requires that .htaccess files are parsed by the Webserver. The Package cannot be installed because the APS Installer is unable to determine if this is enabled.';
$lng['aps']['misc_configscript'] = 'Misc - The language of the configuration script is not supported.';
$lng['aps']['misc_charset'] = 'Misc - In the current Installer version its not possibel to validate formfields from the wizard against a specific charset. The Package cannot be installed.';
$lng['aps']['misc_version_already_installed'] = 'Same version of Package already installed.';
$lng['aps']['misc_only_newer_versions'] = 'For security reasons only newer Package versions can be installed on the system than them which are already installed.';
$lng['aps']['erroronscan'] = '<strong>Errors for <em>%s</em></strong><ul>%s</ul>';
$lng['aps']['invalidzipfile'] = '<strong>Errors for <em>%s</em></strong><br/><ul><li>This is not a valid APS zipfile!</li></ul>';
$lng['aps']['successpackageupdate'] = '<strong><em>%s</em> successfully installed as a Package update</strong>';
$lng['aps']['successpackageinstall'] = '<strong><em>%s</em> successfully installed as a new Package</strong>';
$lng['aps']['class_zip_missing'] = 'SimpleXML Class, exec function or ZIP Functions missing or not enabled! For further information about this problem look into the handbook for this module.';
$lng['aps']['dir_permissions'] = 'The PHP/Webserver process must be able to write in the directory {$path}temp/ and {$path}packages/';
$lng['aps']['initerror'] = '<strong>There are some problems with this module:</strong><ul>%s</ul>Fix these problems, otherwise the module cannot be used!';
$lng['aps']['iderror'] = 'Wrong id specified!';
$lng['aps']['nopacketsforinstallation'] = 'Brak paczek do instalacji.';
$lng['aps']['nopackagestoinstall'] = 'There are no packages to view or install.';
$lng['aps']['nodomains'] = 'Select a domain from the list. If there is none, the Package cannot be installed!';
$lng['aps']['wrongpath'] = 'Either this path contains invalid characters or there is another application installed already.';
$lng['aps']['dbpassword'] = 'Specify a password with a minimum length of 8 characters.';
$lng['aps']['error_text'] = 'Specify a text without special characters.';
$lng['aps']['error_email'] = 'Specify a valid e-mail address.';
$lng['aps']['error_domain'] = 'Specify a valid URL like http://www.example.com/';
$lng['aps']['error_integer'] = 'Specify a numeric value (Integer-Format) e.g. <em>5</em> or <em>7</em>.';
$lng['aps']['error_float'] = 'Specify a numeric value (Float-Format) e.g. <em>5,2432</em> or <em>7,5346</em>.';
$lng['aps']['error_password'] = 'Specify a password.';
$lng['aps']['error_license'] = 'Yes, I have read the license and will abide by its terms.';
$lng['aps']['error_licensenoaccept'] = 'You must accept the license to install this application.';
$lng['aps']['stopinstall'] = 'Anuluj instalację';
$lng['aps']['installstopped'] = 'The Installation of this Package was aborted successfully.';
$lng['aps']['installstoperror'] = 'The Installation cannot be aborted anymore because installation has started already. If you\'d like to uninstall the Package, wait until the Installation has finished and then go to "My Packages" to trigger an Uninstallation.';
$lng['aps']['waitfortask'] = 'Brak akcji do wybrania. Oczykiwanie na zakończenie wszystkich zadań.';
$lng['aps']['removetaskexisting'] = '<strong>There is already a task for Uninstallation.</strong><br/><br/>Proszć wrï¿½ć do zakładki "Moje Paczki" i poczekaj, aż deinstalacja zostanie zakończona.';
$lng['aps']['packagewillberemoved'] = '<strong>Paczka zostanie odinstalowana.</strong><br/><br/>Proszć wrï¿½ć do zakładki "Moje Paczki" i poczekaj, aż deinstalacja zostanie zakończona.';
$lng['question']['reallywanttoremove'] = '<strong>Czy na pewno chcesz odinstalować tą paczkę?</strong><br/><br/>Wszystkie bazy danych i pliki zostaną usunięte. Be sure to make a manual backup of a files you need for any further usage!<br/><br/>';
$lng['aps']['searchoneresult'] = '%s Package found';
$lng['aps']['searchmultiresult'] = '%s Packages found';
$lng['question']['reallywanttostop'] = 'Do you really want to abort the Installation of this Package?<br/><br/>';
$lng['aps']['packagenameandversion'] = 'Packagename & Version';
$lng['aps']['package_locked'] = 'Locked';
$lng['aps']['package_enabled'] = 'Enabled';
$lng['aps']['lock'] = 'Lock';
$lng['aps']['unlock'] = 'Enable';
$lng['aps']['remove'] = 'Remove';
$lng['aps']['allpackages'] = 'All Packages';
$lng['question']['reallyremovepackages'] = '<strong>Do you really want to delete these packages?</strong><br/><br/>Packages with dependencies can only be remove if the corresponding Instances have been removed!<br/><br/>';
$lng['aps']['nopackagesinsystem'] = 'There were no packages installed in the system which could be managed.';
$lng['aps']['packagenameandstatus'] = 'Packagename & Status';
$lng['aps']['activate_aps']['title'] = 'Enable APS Installer';
$lng['aps']['activate_aps']['description'] = 'Here the APS Installer can be enabled and disabled globaly.';
$lng['aps']['packages_per_page']['title'] = 'Packages per page';
$lng['aps']['packages_per_page']['description'] = 'How many packages should be displayed per page for customers?';
$lng['aps']['upload_fields']['title'] = 'Upload fields per page';
$lng['aps']['upload_fields']['description'] = 'How many upload fields should be displayed on the page to install new packages in the system?';
$lng['aps']['exceptions']['title'] = 'Exceptions for Package validation';
$lng['aps']['exceptions']['description'] = 'Some packages need special configuration parameters or modules. The Installer cannot always determine if this options/extensions are available. For this reason you can now define exceptions that packages can be installed in the system. Do only select options which match your real configuration setup. For further information about this problem look into the handbook for this module.';
$lng['aps']['settings_php_extensions'] = 'PHP-Extensions';
$lng['aps']['settings_php_configuration'] = 'PHP-Configuration';
$lng['aps']['settings_webserver_modules'] = 'Webserver modules';
$lng['aps']['settings_webserver_misc'] = 'Webserver miscellaneous';
$lng['aps']['specialoptions'] = 'Special options';
$lng['aps']['removeunused'] = 'Remove unused packages';
$lng['aps']['enablenewest'] = 'Enabled newest version of package, lock others';
$lng['aps']['installations'] = 'Installations';
$lng['aps']['statistics'] = 'Statistics';
$lng['aps']['numerofpackagesinstalled'] = '%s Packages installed<br/>';
$lng['aps']['numerofpackagesenabled'] = '%s Packages enabled<br/>';
$lng['aps']['numerofpackageslocked'] = '%s Packages locked<br/>';
$lng['aps']['numerofinstances'] = '%s Instances installed<br/>';
$lng['question']['reallydoaction'] = '<strong>Do you really want to execute the selected actions?</strong><br/><br/>Data which can be lost by continuing, cannot be restored later.<br/><br/>';
$lng['aps']['linktolicense'] = 'Link to license';
$lng['aps']['initerror_customer'] = 'There is currently a problem with this Froxlor extension. Contact your administrator for further information.';
$lng['aps']['numerofinstances'] = '%s Installations at all<br/>';
$lng['aps']['numerofinstancessuccess'] = '%s successful Installations<br/>';
$lng['aps']['numerofinstanceserror'] = '%s failed Installations<br/>';
$lng['aps']['numerofinstancesaction'] = '%s planed Installations/Uninstallations';
$lng['aps']['downloadallpackages'] = 'Download all packages from distribution server';
$lng['aps']['updateallpackages'] = 'Update all packages by distribution server';
$lng['aps']['downloadtaskexists'] = 'There is already a task for the download of all packages. Please wait until this task has finished.';
$lng['aps']['downloadtaskinserted'] = 'A task for the download of all packages has been created. This can take up to several minutes.';
$lng['aps']['updatetaskexists'] = 'There is already an task for the update of all packages. Please wait until this task has finished.';
$lng['aps']['updatetaskinserted'] = 'A task for the update of all packages has been created. This can take up to several minutes.';
$lng['aps']['canmanagepackages'] = 'Can manage APS packages';
$lng['aps']['numberofapspackages'] = 'Aplikacji zainstalowanych przez instalator aplikacji';
$lng['aps']['allpackagesused'] = '<strong>Error</strong><br/><br/>You have already reached the number of installable APS applications.';
$lng['aps']['noinstancesexisting'] = 'There are currently no instances which could be managed. There must be installed at least one application by a customer.';
$lng['aps']['lightywarning'] = 'Warning';
$lng['aps']['lightywarningdescription'] = 'You are using the lighttpd webserver together with Froxlor. The APS module was mainly written for Apache, so it can be possible that some features do not work with lighttpd. Please remember this when using the APS module. If you have found or experienced any problems in connection with lighttpd and the APS module please report them to the developers that they can be fixed within the next release if Froxlor.';
$lng['error']['customerdoesntexist'] = 'The customer you have chosen doesn\'t exist.';
$lng['error']['admindoesntexist'] = 'The admin you have chosen doesn\'t exist.';

// ADDED IN 1.2.19-svn37

$lng['serversettings']['system_realtime_port']['title'] = 'Port for realtime Froxlor';
$lng['serversettings']['system_realtime_port']['description'] = 'Froxlor connects to this port at localhost everytime a new cron task is scheduled. If value is 0 (zero), this feature is disabled.<br />See also: <a target="blank" href="https://wiki.froxlor.org/contrib/realtime">Make Froxlor work in realtime (Froxlor Wiki)</a>';
$lng['serversettings']['session_allow_multiple_login']['title'] = 'Allow multiple login';
$lng['serversettings']['session_allow_multiple_login']['description'] = 'If activated a user could login multiple times.';
$lng['serversettings']['panel_allow_domain_change_admin']['title'] = 'Allow moving domains between admins';
$lng['serversettings']['panel_allow_domain_change_admin']['description'] = 'If activated you can change the admin of a domain at domainsettings.<br /><b>Attention:</b> If a customer isn\'t assigned to the same admin as the domain, the admin can see every other domain of that customer!';
$lng['serversettings']['panel_allow_domain_change_customer']['title'] = 'Allow moving domains between customers';
$lng['serversettings']['panel_allow_domain_change_customer']['description'] = 'If activated you can change the customer of a domain at domainsettings.<br /><b>Attention:</b> Froxlor won\'t change any paths. This could render a domain unusable!';
$lng['domains']['associated_with_domain'] = 'Associated';
$lng['domains']['aliasdomains'] = 'Alias domains';
$lng['error']['ipportdoesntexist'] = 'The ip/port combination you have chosen doesn\'t exist.';

// ADDED IN 1.2.19-svn38

$lng['admin']['phpserversettings'] = 'Ustawienia PHP';
$lng['admin']['phpsettings']['binary'] = 'PHP Binary';
$lng['admin']['phpsettings']['file_extensions'] = 'File extensions';
$lng['admin']['phpsettings']['file_extensions_note'] = '(without dot, separated by spaces)';
$lng['admin']['mod_fcgid_maxrequests']['title'] = 'Maximum php requests for this domain (empty for default value)';
$lng['serversettings']['mod_fcgid']['maxrequests']['title'] = 'Maximum Requests per Domain';
$lng['serversettings']['mod_fcgid']['maxrequests']['description'] = 'How many requests should be allowed per domain?';

// fix bug #1124
$lng['admin']['webserver'] = 'Webserver';
$lng['error']['admin_domain_emailsystemhostname'] = 'The server-hostname cannot be used as email-domain.';
$lng['aps']['license_link'] = 'Link to the license';

// ADDED IN 1.4.2.1-1

$lng['mysql']['mysql_server'] = 'MySQL-Server';

// ADDED IN 1.4.2.1-2

$lng['admin']['ipsandports']['webserverdefaultconfig'] = 'Webserver Default Config';
$lng['admin']['ipsandports']['webserverdomainconfig'] = 'Webserver Domain Config';
$lng['admin']['ipsandports']['webserverssldomainconfig'] = 'Webserver SSL Config';
$lng['admin']['ipsandports']['ssl_key_file'] = 'Path to the SSL Keyfile';
$lng['admin']['ipsandports']['ssl_ca_file'] = 'Path to the SSL CA certificate';
$lng['admin']['ipsandports']['default_vhostconf_domain'] = 'Default vhost-settings for every domain container';
$lng['serversettings']['ssl']['ssl_key_file'] = 'Path to the SSL Keyfile';
$lng['serversettings']['ssl']['ssl_ca_file'] = 'Path to the SSL CA certificate';

$lng['error']['usernamealreadyexists'] = 'The username %s already exists.';

$lng['error']['plausibilitychecknotunderstood'] = 'Answer of plausibility check not understood.';
$lng['error']['errorwhensaving'] = 'An error occured when saving the field %s';

$lng['success']['success'] = 'Information';
$lng['success']['clickheretocontinue'] = 'Click here to continue';
$lng['success']['settingssaved'] = 'The settings have been successfully saved.';

// ADDED IN FROXLOR 0.9

$lng['admin']['spfsettings'] = 'Ustawienia SPF dla domeny';
$lng['spf']['use_spf'] = 'SPF dla domeny aktywne?';
$lng['spf']['spf_entry'] = 'SPF entry for all domains';
$lng['panel']['dirsmissing'] = 'The given directory could not be found.';
$lng['panel']['toomanydirs'] = 'Too many subdirectories. Falling back to manual path-select.';
$lng['panel']['abort'] = 'Abort';
$lng['serversettings']['cron']['debug']['title'] = 'Cronscript debugging';
$lng['serversettings']['cron']['debug']['description'] = 'Activate to keep the lockfile after a cron-run for debugging.<br /><b>Attention:</b>Keeping the lockfile can cause the next scheduled cron not to run properly.';
$lng['autoresponder']['date_from'] = 'Data początkowa';
$lng['autoresponder']['date_until'] = 'Data końcowa';
$lng['autoresponder']['startenddate'] = 'Początek/koniec daty';
$lng['panel']['not_activated'] = 'Nie aktywowany';
$lng['panel']['off'] = 'off';
$lng['update']['updateinprogress_onlyadmincanlogin'] = 'A newer version of Froxlor has been installed but not yet set up.<br />Only the administrator can log in and finish the update.';
$lng['update']['update'] = 'Aktualizacja Froxlora';
$lng['update']['proceed'] = 'Proceed';
$lng['update']['update_information'] = 'The Froxlor files have been updated to version <strong>%newversion</strong>. The installed version is <strong>%curversion</strong>.<br /><br />Customers will not be able to log in until the update has been finished.<br /><strong>Proceed?</strong>';
$lng['update']['noupdatesavail'] = '<strong>You already have the latest Froxlor version.</strong>';
$lng['admin']['cron']['cronsettings'] = 'ustawienia Cronjob';
$lng['cron']['cronname'] = 'cronjob-name';
$lng['cron']['lastrun'] = 'last run';
$lng['cron']['interval'] = 'interval';
$lng['cron']['isactive'] = 'enabled';
$lng['admin']['cron']['add'] = 'Add a new cronjob';
$lng['cron']['description'] = 'description';
$lng['crondesc']['cron_unknown_desc'] = 'no description given';
$lng['crondesc']['cron_tasks'] = 'przebudowanie plikï¿½w konfiguracyjnych';
$lng['crondesc']['cron_legacy'] = 'legacy (old) cronjob';
$lng['crondesc']['cron_apsinstaller'] = 'Instalator aplikacji';
$lng['crondesc']['cron_autoresponder'] = 'e-mail autoresponder';
$lng['crondesc']['cron_apsupdater'] = 'Aktualizacja pakietï¿½w instalatora aplikacji';
$lng['crondesc']['cron_traffic'] = 'obliczanie ruchu';
$lng['crondesc']['cron_ticketsreset'] = 'resetowanie licznika zgłoszeń';
$lng['crondesc']['cron_ticketarchive'] = 'archiwizowanie starych zgłoszeń';
$lng['admin']['specialsettingsforsubdomains'] = 'Apply specialsettings to all subdomains (*.example.com)';
$lng['serversettings']['specialsettingsforsubdomains']['description'] = 'If yes these custom vhost-settings will be added to all subdomains; if no subdomain-specialsettings are being removed.';
$lng['tasks']['outstanding_tasks'] = 'Outstanding cron-tasks';
$lng['tasks']['rebuild_webserverconfig'] = 'Rebuilding webserver-configuration';
$lng['tasks']['adding_customer'] = 'Adding new customer %loginname%';
$lng['tasks']['rebuild_bindconfig'] = 'Rebuilding bind-configuration';
$lng['tasks']['creating_ftpdir'] = 'Creating directory for new ftp-user';
$lng['tasks']['deleting_customerfiles'] = 'Deleting customer-files %loginname%';
$lng['tasks']['noneoutstanding'] = 'There are currently no outstanding tasks for Froxlor';
$lng['ticket']['nonexistingcustomer'] = '(deleted customer)';
$lng['admin']['ticket_nocustomeraddingavailable'] = 'It\'s not possible to open a new support-ticket currently. You first need to add at least one customer.';

// ADDED IN FROXLOR 0.9.1

$lng['admin']['accountdata'] = 'Account Data';
$lng['admin']['contactdata'] = 'Contact Data';
$lng['admin']['servicedata'] = 'Service Data';

// ADDED IN FROXLOR 0.9.2

$lng['admin']['newerversionavailable'] = 'There is a newer version of Froxlor available';

// ADDED IN FROXLOR 0.9.3

$lng['emails']['noemaildomainaddedyet'] = 'You do not have a (email-)domain in your account yet.';
$lng['error']['hiddenfieldvaluechanged'] = 'The value for the hidden field "%s" changed while editing the settings.<br /><br />This is usually not a big problem but the settings could not be saved because of this.';

?>
