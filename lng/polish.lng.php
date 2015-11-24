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
 * @author     Florian Lippert <flo@syscp.org>
 * @author     Froxlor Team <team@froxlor.org>
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Language
 *
 */

/**
 * Global
 */

$lng['translator'] = 'Czauderna Tomasz - esalamandra.com.pl';
$lng['panel']['edit'] = 'Edytuj';
$lng['panel']['delete'] = 'Usuń';
$lng['panel']['create'] = 'Utwórz';
$lng['panel']['save'] = 'zapisz';
$lng['panel']['yes'] = 'tak';
$lng['panel']['no'] = 'nie';
$lng['panel']['emptyfornochanges'] = 'Pozostaw puste jeśli nie chcesz dokonywać zmian';
$lng['panel']['emptyfordefault'] = 'Pozostaw puste dla ustawień domyślnych';
$lng['panel']['path'] = 'Ścieżka';
$lng['panel']['toggle'] = 'Przełącznik';
$lng['panel']['next'] = 'Następne';
$lng['panel']['dirsmissing'] = 'Nie można odnaleźć lub odczytać katalogu';

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
$lng['customer']['name'] = 'Nazwa';
$lng['customer']['firstname'] = 'Pierwsze imię';
$lng['customer']['company'] = 'Firma';
$lng['customer']['street'] = 'Ulica';
$lng['customer']['zipcode'] = 'Kod pocztowy';
$lng['customer']['city'] = 'Miasto';
$lng['customer']['phone'] = 'Telefon';
$lng['customer']['fax'] = 'Fax';
$lng['customer']['email'] = 'Email';
$lng['customer']['customernumber'] = 'ID Klienta';
$lng['customer']['diskspace'] = 'Przestrzeń dyskowa (MiB)';
$lng['customer']['traffic'] = 'Ruch (GiB)';
$lng['customer']['mysqls'] = 'Bazy danych MySQL';
$lng['customer']['emails'] = 'Adresy Email';
$lng['customer']['accounts'] = 'Konta Email';
$lng['customer']['forwarders'] = 'Przekierowania Email';
$lng['customer']['ftps'] = 'Konta FTP';
$lng['customer']['subdomains'] = 'Sub domeny';
$lng['customer']['domains'] = 'Domeny';
$lng['customer']['unlimited'] = 'bez limitu';

/**
 * Customermenue
 */

$lng['menue']['main']['main'] = 'Main';
$lng['menue']['main']['changepassword'] = 'Zmień hasło';
$lng['menue']['main']['changelanguage'] = 'Zmień język';
$lng['menue']['email']['email'] = 'Email';
$lng['menue']['email']['emails'] = 'Adres email';
$lng['menue']['email']['webmail'] = 'Webmail';
$lng['menue']['mysql']['mysql'] = 'MySQL';
$lng['menue']['mysql']['databases'] = 'Bazy danych';
$lng['menue']['mysql']['phpmyadmin'] = 'phpMyAdmin';
$lng['menue']['domains']['domains'] = 'Domeny';
$lng['menue']['domains']['settings'] = 'ustawienia';
$lng['menue']['ftp']['ftp'] = 'FTP';
$lng['menue']['ftp']['accounts'] = 'Konta';
$lng['menue']['ftp']['webftp'] = 'WebFTP';
$lng['menue']['extras']['extras'] = 'Dodatki';
$lng['menue']['extras']['directoryprotection'] = 'Ochorna katalogu';
$lng['menue']['extras']['pathoptions'] = 'Opcje ścieżki';

/**
 * Index
 */

$lng['index']['customerdetails'] = 'Szczegóły Klienta';
$lng['index']['accountdetails'] = 'Szczegóły konta';

/**
 * Change Password
 */

$lng['changepassword']['old_password'] = 'Stare hasło';
$lng['changepassword']['new_password'] = 'Nowe hasło';
$lng['changepassword']['new_password_confirm'] = 'Potwierdź hasło';
$lng['changepassword']['new_password_ifnotempty'] = 'nowe hasło (puste = bez zmian)';
$lng['changepassword']['also_change_ftp'] = 'również zmienia hasło do głównego konta FTP';

/**
 * Domains
 */

$lng['domains']['description'] = 'Tutaj możesz utworzyć (pod-)domeny i ustawić ich ścieżki.<br />system po każdej zmianie potrzebuje troche czasu na zastosowanie zmian.';
$lng['domains']['domainsettings'] = 'Ustawienia domey';
$lng['domains']['domainname'] = 'Nazwa domeny';
$lng['domains']['subdomain_add'] = 'Utwórz pod domene';
$lng['domains']['subdomain_edit'] = 'Edytuj (pod)domene';
$lng['domains']['wildcarddomain'] = 'Utwórz jako wildcard-domain?';
$lng['domains']['aliasdomain'] = 'Alias dla domeny';
$lng['domains']['noaliasdomain'] = 'Brak aliasów do domeny';

/**
 * E-mails
 */

$lng['emails']['description'] = 'Tutaj można tworzyć i zmieniać adresy e-mail . <br /> Konto jest jak letterbox przed swoim domem . Jeśli ktoś wyśle ​​Ci wiadomość e-mail , zostanie ono odrzucone na konto /> <br /> <br> Aby pobrać wiadomości e-mail należy użyć następujących ustawień w swoim Kliencie poczty:<br /><br /> (Dane w<i>Kursywie</i> Będą zmienione na ekwiwalnetny typ w!)<br />Nazwa hosta: <b><i>Nazwa domeny</i></b><br />Użytkownik: <b><i>nazwa konta / adres e-mail </i></b><br />hasło: <b><i>Hasło jakie wybrałeś</i></b>';
$lng['emails']['emailaddress'] = 'Adres email';
$lng['emails']['emails_add'] = 'Utwórz adres email';
$lng['emails']['emails_edit'] = 'Edytuj adres email';
$lng['emails']['catchall'] = 'Catchall';
$lng['emails']['iscatchall'] = 'Zdefiniować jako adres catchall?';
$lng['emails']['account'] = 'Konto';
$lng['emails']['account_add'] = 'Utwórz konto';
$lng['emails']['account_delete'] = 'Usuń konto';
$lng['emails']['from'] = 'Źródło';
$lng['emails']['to'] = 'Cel';
$lng['emails']['forwarders'] = 'Przekierowanie';
$lng['emails']['forwarder_add'] = 'Utwórz przekierowanie';

/**
 * FTP
 */

$lng['ftp']['description'] = 'Tutaj możesz utworzyć i edytować ustawienia FTP.<br />Zmiany nastąpią natychmiastowo i konto może być używane od razu.';
$lng['ftp']['account_add'] = 'Utwórz konto';

/**
 * MySQL
 */

$lng['mysql']['databasename'] = 'Nazwa użytkownika i baza danych';
$lng['mysql']['databasedescription'] = 'Opis bazy danych';
$lng['mysql']['database_create'] = 'Utwórz bazę danych';

/**
 * Extras
 */

$lng['extras']['description'] = 'Tutaj możesz dodać troche dodatków, na przykład ochronę katalogu.<br />System potrzebuje trochę czasu na zastosowanie zmian.';
$lng['extras']['directoryprotection_add'] = 'Dodaj ochronę katalogu';
$lng['extras']['view_directory'] = 'Wyświetl zawartość katalogu';
$lng['extras']['pathoptions_add'] = 'Dodaj opcje ścieżki';
$lng['extras']['directory_browsing'] = 'Przeglądanie zawartości katalogu';
$lng['extras']['pathoptions_edit'] = 'Edytuj opcje ścieżki';
$lng['extras']['error404path'] = '404';
$lng['extras']['error403path'] = '403';
$lng['extras']['error500path'] = '500';
$lng['extras']['error401path'] = '401';
$lng['extras']['errordocument404path'] = 'Dokument błędu 404';
$lng['extras']['errordocument403path'] = 'Dokument błędu 403';
$lng['extras']['errordocument500path'] = 'Dokument błędu 500';
$lng['extras']['errordocument401path'] = 'Dokument błędu 401';

/**
 * Errors
 */

$lng['error']['error'] = 'Błąd';
$lng['error']['directorymustexist'] = 'Katalog %s musi istnieć. Prosimy utworzyć go za pomocą FTP clienta.';
$lng['error']['filemustexist'] = 'Plik %s musi istnieć.';
$lng['error']['allresourcesused'] = 'Zużywasz już wszystkie Twoje zasoby.';
$lng['error']['domains_cantdeletemaindomain'] = 'Nie możesz usunąć domeny która jest używana jako domena mailowa.';
$lng['error']['domains_canteditdomain'] = 'Nie możesz edytować tej domeny. Została wyłączona przez admina.';
$lng['error']['domains_cantdeletedomainwithemail'] = 'Nie możesz usunać domeny która jest używana jako domena mailowa. Usuń najpierw wszystkie adresy mailowe.';
$lng['error']['firstdeleteallsubdomains'] = 'Musisz usunąć wszystkie sub domeny przed dodaniem wildcard.';
$lng['error']['youhavealreadyacatchallforthisdomain'] = 'Posiadasz już zdefiniowany catchall dla tej domeny.';
$lng['error']['ftp_cantdeletemainaccount'] = 'Nie możesz usunąć głównego konta FTP';
$lng['error']['login'] = 'Nazwa użytkownika lub hasło. Proszę spróbować ponownie!';
$lng['error']['login_blocked'] = 'Konto zostało uśpione zbyt wiele nieudanych prób zalogowania. <br />Sprbuj za %s sekund.';
$lng['error']['notallreqfieldsorerrors'] = 'Nie wypełniłeś wszystkich pól lub wypełniłeś je nie prawidłowo.';
$lng['error']['oldpasswordnotcorrect'] = 'Stare hasło nie jest prawidłowe.';
$lng['error']['youcantallocatemorethanyouhave'] = 'Nie możesz przydzielić więcej zasobów niż sam posiadasz.';
$lng['error']['mustbeurl'] = 'Nie wprowadziłeś poprawnego adresu url (n.p. http://domena.com/error404.htm)';
$lng['error']['invalidpath'] = 'Nie wybrałeś poprawnego adresu URL (Może posiadasz problem z listowaniem katalogu?)';
$lng['error']['stringisempty'] = 'Wymagane pole do wprowadzania';
$lng['error']['stringiswrong'] = 'Złe wprowadzenie w polu';
$lng['error']['newpasswordconfirmerror'] = 'Nowe hasło i jego potwierdzenie się nie są takie same';
$lng['error']['mydomain'] = '\'Domena\'';
$lng['error']['mydocumentroot'] = '\'Dokument Root\'';
$lng['error']['loginnameexists'] = 'Login %s już istnieje';
$lng['error']['emailiswrong'] = 'Adres e-mail %s zawiera nieprawidłowe znaki lub nie jest kompletny';
$lng['error']['loginnameiswrong'] = 'Login "%s" zawiera nieprawidłowe znaki.';
$lng['error']['loginnameiswrong2'] = 'Login zawiera zbyt wiele znaków. Tylko %s znaków jest dozwolne.';
$lng['error']['userpathcombinationdupe'] = 'Kombinacja nazwy użytkownika i ścieżki już istnieje';
$lng['error']['patherror'] = 'Ogólny błąd! Ścieżka nie istnieje';
$lng['error']['errordocpathdupe'] = 'opcja dla ścieżki %s już istnieje';
$lng['error']['adduserfirst'] = 'Proszę pierwsze utworzyć Klienta';
$lng['error']['domainalreadyexists'] = 'Domena %s jest już przydzielona dla Klienta';
$lng['error']['nolanguageselect'] = 'Nie wybrano języka.';
$lng['error']['nosubjectcreate'] = 'Musisz zdefiniowany temat dla tego szablonu.';
$lng['error']['nomailbodycreate'] = 'Musisz zdefiniować tekst dla tego szablonu.';
$lng['error']['templatenotfound'] = 'Nie znaleziono szablonu.';
$lng['error']['alltemplatesdefined'] = 'Nie możesz zdefiniować więcej szablonów, wszystkie języki są już wspierane.';
$lng['error']['wwwnotallowed'] = 'www nie jest dozwolone dla tej sub domeny.';
$lng['error']['subdomainiswrong'] = 'Sub domena %s zawiera nieprawidłowe znaki.';
$lng['error']['domaincantbeempty'] = 'Nazwa domeny nie może być pusta.';
$lng['error']['domainexistalready'] = 'Domena %s już istnieje.';
$lng['error']['domainisaliasorothercustomer'] = 'Wybrany alias domeny jest już lub jest aliasem do samej siebie, posiada inną kombinacje ip/port lub jest zależna od innego klienta.';
$lng['error']['emailexistalready'] = 'Adres e-mail %s juz istnieje.';
$lng['error']['maindomainnonexist'] = 'Głowna domena %s nie istnieje.';
$lng['error']['destinationnonexist'] = 'Proszę utworzyć przekierowanie w polu \'Cel\'.';
$lng['error']['destinationalreadyexistasmail'] = 'Przekierowanie do %s już istnieje jako aktywny adres e-mail.';
$lng['error']['destinationalreadyexist'] = 'Posiadasz już zdefiniowane Przekierowanie do %s .';
$lng['error']['destinationiswrong'] = 'Przekierowanie %s zawiera nieprawidłowe znaki lub jest nie kompletne.';
$lng['error']['ticketnotaccessible'] = 'Nie posiadasz dostępu do ticketu.';

/**
 * Questions
 */

$lng['question']['question'] = 'Pytanie bezpieczeństwa';
$lng['question']['admin_customer_reallydelete'] = 'Na pewno chcesz usunąć klienta %s? Nie można cofnąć tej operacji!';
$lng['question']['admin_domain_reallydelete'] = 'Na pewno chcesz usunąć tą domenę %s?';
$lng['question']['admin_domain_reallydisablesecuritysetting'] = 'Na pewno chcesz wyłączyć regułę bezpieczeństwa OpenBasedir?';
$lng['question']['admin_admin_reallydelete'] = 'Na pewno chcesz usunąć konto admina %s? Każdy klient i domena zostaną Tobie przydzielone.';
$lng['question']['admin_template_reallydelete'] = 'Na pewno chcesz usunąć ten szablon \'%s\'?';
$lng['question']['domains_reallydelete'] = 'Napewno chcesz usunąc domenę %s?';
$lng['question']['email_reallydelete'] = 'Napewno chcesz usunąć adres email %s?';
$lng['question']['email_reallydelete_account'] = 'Czy Napewno chcesz usunać email z %s?';
$lng['question']['email_reallydelete_forwarder'] = 'Czy napewno chcesz usunąć przekierowanie %s?';
$lng['question']['extras_reallydelete'] = 'czy napewno chcesz usunąc ochronę katalogu %s?';
$lng['question']['extras_reallydelete_pathoptions'] = 'Czy napewo chcesz usunąć opcje ścieżki %s?';
$lng['question']['ftp_reallydelete'] = 'Czy napewno hcesz usunać konto FTP %s?';
$lng['question']['mysql_reallydelete'] = 'Czy napewno chcesz usunać bazę %s? Operajca jest nieodwracalna!';
$lng['question']['admin_configs_reallyrebuild'] = 'Czy napewno chcesz przebudować pliki konfguracyjne?';
$lng['question']['admin_customer_alsoremovefiles'] = 'Czy usunać pliki użytkownika?';
$lng['question']['admin_customer_alsoremovemail'] = 'Całkowicie usunąć pliki email użytkownika ?';
$lng['question']['admin_customer_alsoremoveftphomedir'] = 'Usunać ścieżkę użytkownika FTP?';

/**
 * Mails
 */

$lng['mails']['pop_success']['mailbody'] = 'Witaj,\n\n Twoje konto mailowe{EMAIL}\n zostało pomyślnie utworzone.\n\nTo jest automatycznie tworzona wiadomość\ne-mail, proimy nie odpowiadać na nią!\n\n Z poważaniem , administrator';
$lng['mails']['pop_success']['subject'] = 'Konto mailowe pomyślnie utworzone';
$lng['mails']['createcustomer']['mailbody'] = 'Witam {FIRSTNAME} {NAME},\n\n poniżej informacje do Twojego konta:\n\nNazwa użytkownika: {USERNAME}\nHasło: {PASSWORD}\n\nDziękujemy,\nTwójadministrator';
$lng['mails']['createcustomer']['subject'] = 'Informacje konta';

/**
 * Admin
 */

$lng['admin']['overview'] = 'Przeglądanie';
$lng['admin']['ressourcedetails'] = 'Użyte zasoby';
$lng['admin']['systemdetails'] = 'Szczegóły systemu';
$lng['admin']['froxlordetails'] = 'Szczegóły Froxlor';
$lng['admin']['installedversion'] = 'Zainstalowana wersja';
$lng['admin']['latestversion'] = 'Ostatnia wersja';
$lng['admin']['lookfornewversion']['clickhere'] = 'Szukaj poprzez webservice';
$lng['admin']['lookfornewversion']['error'] = 'Błąd podczas odczytu';
$lng['admin']['resources'] = 'Zasoby';
$lng['admin']['customer'] = 'Klient';
$lng['admin']['customers'] = 'Klienci';
$lng['admin']['customer_add'] = 'Utwórz klienta';
$lng['admin']['customer_edit'] = 'Edytuj klienta';
$lng['admin']['domains'] = 'Domeny';
$lng['admin']['domain_add'] = 'Utwórz domenę';
$lng['admin']['domain_edit'] = 'Edytuj domenę';
$lng['admin']['subdomainforemail'] = 'Sub domeny jako domeny mailowe';
$lng['admin']['admin'] = 'Administrator';
$lng['admin']['admins'] = 'Administratorzy';
$lng['admin']['admin_add'] = 'Utwórz Administratora';
$lng['admin']['admin_edit'] = 'Edytuj Administratora';
$lng['admin']['customers_see_all'] = 'Może widzieć wszystkich klientów?';
$lng['admin']['domains_see_all'] = 'Może widzieć wszystkie domeny?';
$lng['admin']['change_serversettings'] = 'Może zmieniać ustawienia serwera?';
$lng['admin']['server'] = 'Serwer';
$lng['admin']['serversettings'] = 'Ustawienia';
$lng['admin']['rebuildconf'] = 'Przebuduj pliki konfiguracyjne';
$lng['admin']['stdsubdomain'] = 'Standardowa sub domena';
$lng['admin']['stdsubdomain_add'] = 'Utwórz standardową sub domenę';
$lng['admin']['phpenabled'] = 'PHP włączone';
$lng['admin']['deactivated'] = 'Wyłaczone';
$lng['admin']['deactivated_user'] = 'Wyłączony użytkownik';
$lng['admin']['sendpassword'] = 'Wyślij hasło';
$lng['admin']['ownvhostsettings'] = 'Własne ustawienia vHost-a';
$lng['admin']['configfiles']['serverconfiguration'] = 'konfiguracja';
$lng['admin']['templates']['templates'] = 'Szablon email';
$lng['admin']['templates']['template_add'] = 'Dodaj szablon';
$lng['admin']['templates']['template_edit'] = 'Edytuj szablon';
$lng['admin']['templates']['action'] = 'Akcja';
$lng['admin']['templates']['email'] = 'Szablony plików i maili';
$lng['admin']['templates']['subject'] = 'temat';
$lng['admin']['templates']['mailbody'] = 'Zawartość maila';
$lng['admin']['templates']['createcustomer'] = 'Powitalny mail dla nowych klientów';
$lng['admin']['templates']['pop_success'] = 'Powitalny mail dla nowego konta pocztowego';
$lng['admin']['templates']['template_replace_vars'] = 'Zmienne które mogą być użyte w szablonie:';
$lng['admin']['templates']['SALUTATION'] = 'Zastąpiony poprawnym pozdrowieniem (Nazwa lub Firma)';
$lng['admin']['templates']['FIRSTNAME'] = 'Zastąpione klienta - firstname.';
$lng['admin']['templates']['NAME'] = 'Zastąpione klienta nazwy.';
$lng['admin']['templates']['COMPANY'] = 'Zastąpione klienta - nazwa firmy';
$lng['admin']['templates']['USERNAME'] = 'Zastąpione klienta -  nazwa konta.';
$lng['admin']['templates']['PASSWORD'] = 'Zastąpione klienta -  hasło konta.';
$lng['admin']['templates']['EMAIL'] = 'Zastąpione przez adres POP3/IMAP konta.';
$lng['admin']['webserver'] = 'Webserver';

/**
 * Serversettings
 */

$lng['serversettings']['session_timeout']['title'] = 'Czas zakończenia sesji';
$lng['serversettings']['session_timeout']['description'] = 'Jak długo użytkownik musi być nie aktywny zanim sesja będzie nie aktualna (sekundy)?';
$lng['serversettings']['accountprefix']['title'] = 'Prefix klient';
$lng['serversettings']['accountprefix']['description'] = 'Jaki prefix powinno posiadać konto klienta?';
$lng['serversettings']['mysqlprefix']['title'] = 'Prefix SQL';
$lng['serversettings']['mysqlprefix']['description'] = 'Jaki prefix powinny posiadać konta MySQL ?</br>Użyj "RANDOM" jako wartość aby otrzymać 3 cyfrowy wartość';
$lng['serversettings']['ftpprefix']['title'] = 'Prefix FTP';
$lng['serversettings']['ftpprefix']['description'] = 'Jaki prefix powinny posiadać konta FTP ?<br/><b>Jeśli się to zmieni trzeba także zmienić zawarotść przydziału dyskowego w zapytaniach SQL w pliku konfiguracyjnym serwera FTP w przypadku gdy go używasz!</b> ';
$lng['serversettings']['documentroot_prefix']['title'] = 'Katalog domowy';
$lng['serversettings']['documentroot_prefix']['description'] = 'Gdzie powinny być zapisywane katalogi domowe?';
$lng['serversettings']['logfiles_directory']['title'] = 'Katalog logowania';
$lng['serversettings']['logfiles_directory']['description'] = 'Gdzie powinny być zapisywane wszystkie katalogi z plikami logów?';
$lng['serversettings']['ipaddress']['title'] = 'Adres IP';
$lng['serversettings']['ipaddress']['description'] = 'Jaki jest adres IP serwera ?';
$lng['serversettings']['hostname']['title'] = 'Nazwa hosta';
$lng['serversettings']['hostname']['description'] = 'Jaka jest nazwa serwera?';
$lng['serversettings']['apachereload_command']['title'] = 'Polecenie reload server web';
$lng['serversettings']['apachereload_command']['description'] = 'Jakie jest polecenie przeładowania plików konfiguracyjnych serwera?';
$lng['serversettings']['bindenable']['title'] = 'Włącz serwer nazw';
$lng['serversettings']['bindenable']['description'] = 'Tutaj można włączyć wyłączyć serwer globalnie.';
$lng['serversettings']['bindconf_directory']['title'] = 'Katalog konfiguracji BIND-a';
$lng['serversettings']['bindconf_directory']['description'] = 'Gdzie powinny być zapisywane pliki konfiguracyjne BIND-a?';
$lng['serversettings']['bindreload_command']['title'] = 'Polecenie reload Bind';
$lng['serversettings']['bindreload_command']['description'] = 'Jakie jest polecenie do przeładowania plików konfiguracyjnych binda?';
$lng['serversettings']['binddefaultzone']['title'] = 'Strefa domyślna BIND-a';
$lng['serversettings']['binddefaultzone']['description'] = 'Jaka jest nazwa domyślnej strefy?';
$lng['serversettings']['vmail_uid']['title'] = 'UID Mail';
$lng['serversettings']['vmail_uid']['description'] = 'Który UserID powinien obsługiwać maile?';
$lng['serversettings']['vmail_gid']['title'] = 'GID Mail';
$lng['serversettings']['vmail_gid']['description'] = 'Która GroupID powinna obsługiwać maile?';
$lng['serversettings']['vmail_homedir']['title'] = 'Katalog domowy maili';
$lng['serversettings']['vmail_homedir']['description'] = 'Gdzie powinny być zapisywane wszystkie maile?';
$lng['serversettings']['adminmail']['title'] = 'Nadawca';
$lng['serversettings']['adminmail']['description'] = 'Jaki jest adres nadawcy dla maili wysyłanych z Panelu ?';
$lng['serversettings']['phpmyadmin_url']['title'] = 'URL phpMyAdmin';
$lng['serversettings']['phpmyadmin_url']['description'] = 'Jaki jest adres do phpMyAdmin? (powinien się zaczynać od http(s)://)';
$lng['serversettings']['webmail_url']['title'] = 'Webmail URL';
$lng['serversettings']['webmail_url']['description'] = 'What\'s the URL to webmail? powinien się zaczynać od http(s)://)';
$lng['serversettings']['webftp_url']['title'] = 'URL WebFTP';
$lng['serversettings']['webftp_url']['description'] = 'Jaki jest adres do klienta WebFTP? powinien się zaczynać od http(s)://)';
$lng['serversettings']['language']['description'] = 'Jaki jest domyślny język serwera?';
$lng['serversettings']['maxloginattempts']['title'] = 'Maksymalna ilość prób logowania';
$lng['serversettings']['maxloginattempts']['description'] = 'Maksymalna ilość prób logowania zanim konto zostanie zablokowane.';
$lng['serversettings']['deactivatetime']['title'] = 'Czas dezaktywacji';
$lng['serversettings']['deactivatetime']['description'] = 'Czas (sec.) na jaki będzie uśpione konto przy nieprawidłowych próbach zalogowania.';
$lng['serversettings']['pathedit']['title'] = 'Typ ścieżki wejściowej';
$lng['serversettings']['pathedit']['description'] = 'Powinna być w formie listy rozwijanej czy też wprowadzana ręcznie ?';
$lng['serversettings']['nameservers']['title'] = 'Serwery nazw';
$lng['serversettings']['nameservers']['description'] = 'Lista rozdzielona przecinkami zawierająca nazwy hostów serwerów mailowych. Pierwszy jest nadrzędny.';
$lng['serversettings']['mxservers']['title'] = 'Serwery MX';
$lng['serversettings']['mxservers']['description'] = 'Lista rozdzielona przecinkami zawierająca liczbę i nazwę serwera (przykład. \'10 mx.example.com\') zawierające serwery mx.';

/**
 * CHANGED BETWEEN 1.2.12 and 1.2.13
 */

$lng['mysql']['description'] = 'Tutaj można tworzyć i zmieniać swoje baz danych MySQL. <br /> Zmiany są wykonywane natychmiast, a baza danych może być użyta natychmiast. <br /> W menu po lewej stronie znajduje się  narzędzie phpMyAdmin, dzięki któremu można łatwo zarządzać bazy danych. <br /> <br /> aby Twoje skrypty mogły korzystać z baz danych w ustawieniach skryptu php użyj następujących ustawień: (! dane w <i> kursywa </ i>, muszą zostać zmienione w zamienniki wpisany w) <br /> Nazwa hosta: <b> <SQL_HOST> </ b> <br /> Nazwa użytkownika: <b> <i> databasename </ i> </ b> <br /> Hasło: <b> <i> hasło utworzone </ i> </ b> <br /> bazy danych: <b> <i> databasename </ i> </ b>';

/**
 * ADDED BETWEEN 1.2.12 and 1.2.13
 */

$lng['serversettings']['paging']['title'] = 'Wpisów na stronie';
$lng['serversettings']['paging']['description'] = 'Ile wpisów powinno występować na stronie? (0 = wyłączenie stronicowania)';
$lng['error']['ipstillhasdomains'] = 'Ta kombinacja IP/Port którą chcesz usunąć dalej posiada przypisane domeny, proszę o przydzielenie ich do innej kombinacji IP/Port przed usunięciem tej konfiguracji IP/PORT.';
$lng['error']['cantdeletedefaultip'] = 'Nie możesz usunąć domyślnej kombinacji IP/Port resellera, prosżę utwórz inna kombinację IP/Port domyślna dla resellera przed usunięciem tej kominacji IP/Port .';
$lng['error']['cantdeletesystemip'] = 'Nie możesz usunąć ostatniego IP, utwórz nową kombinację IP/Port w systemie IP lub zmień IP systemu.';
$lng['error']['myipaddress'] = '\'IP\'';
$lng['error']['myport'] = '\'Port\'';
$lng['error']['myipdefault'] = 'Musisz wybrać kombinację IP/Port która powinna być domyślna.';
$lng['error']['myipnotdouble'] = 'Ta kombinacja IP/Port już istnieje.';
$lng['error']['admin_domain_emailsystemhostname'] = 'Nazwa serwera nie może być używana jako nazwa hostowa klienta.';
$lng['question']['admin_ip_reallydelete'] = 'Czy na pewno chcesz usunąć adres IP %s?';
$lng['admin']['ipsandports']['ipsandports'] = 'IP i Porty';
$lng['admin']['ipsandports']['add'] = 'Dodaj IP/Port';
$lng['admin']['ipsandports']['edit'] = 'Edytuj IP/Port';
$lng['admin']['ipsandports']['ipandport'] = 'IP/Port';
$lng['admin']['ipsandports']['ip'] = 'IP';
$lng['admin']['ipsandports']['port'] = 'Port';

// ADDED IN 1.2.13-rc3

$lng['error']['cantchangesystemip'] = 'Nie możesz usunąć ostatniego adresu IP, najpierw utwórz inną kombinację IP/Port dla systemu lub zmien systemowy IP.';
$lng['question']['admin_domain_reallydocrootoutofcustomerroot'] = 'Jesteś pewnien, że chcesz aby document root dla tej domeny, nie był w katalogu root klienta?';

// ADDED IN 1.2.14-rc1

$lng['admin']['memorylimitdisabled'] = 'Wyłączony';
$lng['domain']['openbasedirpath'] = 'Ścieżka OpenBasedir';
$lng['domain']['docroot'] = 'Ścieżka z powyższego pola';
$lng['domain']['homedir'] = 'Katalog domowy';
$lng['admin']['valuemandatory'] = 'Ta wartość jest obowiązkowa';
$lng['admin']['valuemandatorycompany'] = '"nazwa" i "Imię" lub "Firma" muszą być wypełnione';
$lng['menue']['main']['username'] = 'Zalogowany jako: ';
$lng['panel']['urloverridespath'] = 'URL (ścieżka nadpisania)';
$lng['panel']['pathorurl'] = 'Ścieżka lub URL';
$lng['error']['sessiontimeoutiswrong'] = 'Tylko numeryczne wartości "sesji czas" są dozwolone.';
$lng['error']['maxloginattemptsiswrong'] = 'Tylko numeryczne wartości "maksymalna próba logowania" są dozwolone.';
$lng['error']['deactivatetimiswrong'] = 'Tylko numeryczne wartości "czas dezaktywacji" jest dozwolone.';
$lng['error']['accountprefixiswrong'] = '"Prefix klienta" jest zły.';
$lng['error']['mysqlprefixiswrong'] = '"Prefix SQL" jest zły.';
$lng['error']['ftpprefixiswrong'] = '"Prefix FTP" jest zły.';
$lng['error']['ipiswrong'] = '"Adres IP" jest zły. Tylko poprawne adesy są dozwolone.';
$lng['error']['vmailuidiswrong'] = '"UID mail" jest zły. Tylko numeryczne wartości UID są dozwolone.';
$lng['error']['vmailgidiswrong'] = '"GID mail" jest zły. Tylko numeryczne wartości GID są dozwolone.';
$lng['error']['adminmailiswrong'] = '"Adres nadawcy" jest zły. Tylko poprawny adres email jest dozwolony.';
$lng['error']['pagingiswrong'] = '"Wpisów na stronę" warotść jest zła. Tylko numeryczne wartości są dozwolone.';
$lng['error']['phpmyadminiswrong'] = 'Link phpMyAdmin nie jest poprawnym linkiem.';
$lng['error']['webmailiswrong'] = 'Link webmail nie jest poprawnym linkiem.';
$lng['error']['webftpiswrong'] = 'Link WebFTP nie jest poprawnym linkiem.';
$lng['domains']['hasaliasdomains'] = 'Posiada aliasy domen(y)';
$lng['serversettings']['defaultip']['title'] = 'Domyślny IP/Port';
$lng['serversettings']['defaultip']['description'] = 'Jaka jest domyślna kombinacja Ip/Port ?';
$lng['domains']['statstics'] = 'Statystyki Użycia';
$lng['panel']['ascending'] = 'Rosnąco';
$lng['panel']['decending'] = 'Malejąco';
$lng['panel']['search'] = 'Szukaj';
$lng['panel']['used'] = 'Użyty';

// ADDED IN 1.2.14-rc3

$lng['panel']['translator'] = 'Translator';

// ADDED IN 1.2.14-rc4

$lng['error']['stringformaterror'] = 'Wartośc pola "%s" nie jest w poprawnym formacie.';

// ADDED IN 1.2.15-rc1

$lng['admin']['serversoftware'] = 'Oprogramowanie serwera';
$lng['admin']['phpversion'] = 'Wersja PHP';
$lng['admin']['mysqlserverversion'] = 'Wersja MySQL';
$lng['admin']['webserverinterface'] = 'Interface Webserver-a';
$lng['domains']['isassigneddomain'] = 'Przydzielona domena';
$lng['serversettings']['phpappendopenbasedir']['title'] = 'Ścieżka dodana do OpenBasedir';
$lng['serversettings']['phpappendopenbasedir']['description'] = 'Te ścieżki (odseparowane dwukropkiem) składnia będzie dodana do OpenBasedir w każdym kontenerze vHost.';

// CHANGED IN 1.2.15-rc1

$lng['error']['loginnameissystemaccount'] = 'Nie możesz utworzyć nazwy która jest taka sama jak konto systemowe (jako przykład zaczynająca się od "%s"). Wprowadź inna nazwę konta.';
$lng['error']['youcantdeleteyourself'] = 'Nie możesz usunąć samego siebie z powodów bezpieczeństwa.';
$lng['error']['youcanteditallfieldsofyourself'] = 'Notka: nie możesz edytować wszystich pól ze względów bezpieczeństwa.';

// ADDED IN 1.2.16-svn1

$lng['serversettings']['natsorting']['title'] = 'Użyj naturalnego ludzkiego sortowania';
$lng['serversettings']['natsorting']['description'] = 'Sortuje listę web1 -> web2 -> web11 zamiast web1 -> web11 -> web2.';

// ADDED IN 1.2.16-svn2

$lng['serversettings']['deactivateddocroot']['title'] = 'Docroot dla dezaktywowanych użytkowników';
$lng['serversettings']['deactivateddocroot']['description'] = 'Kiedy użytkownik jest dezaktywowany jest używana ten docroot. Pozostaw puste jeśli nie chcesz tworzyć docroot dla wszystkich.';

// ADDED IN 1.2.16-svn4

$lng['panel']['reset'] = 'Odrzuć zmiany';
$lng['admin']['accountsettings'] = 'Ustawienia konta';
$lng['admin']['panelsettings'] = 'Ustawienia  Panelu';
$lng['admin']['systemsettings'] = 'Ustawienia  Systemu';
$lng['admin']['webserversettings'] = 'Ustawienia  Serwera Web';
$lng['admin']['mailserversettings'] = 'Ustawienia Serwera pocztowego';
$lng['admin']['nameserversettings'] = 'Ustawienia Serwera nazw';
$lng['admin']['updatecounters'] = 'Przelicz zużycie zasobów';
$lng['question']['admin_counters_reallyupdate'] = 'Czy na pewno chcesz przeliczyć zużycie zasobów?';
$lng['panel']['pathDescription'] = 'Jeśli katalog nie istnieje zostanie on utworzony automatycznie.';
$lng['panel']['pathDescriptionEx'] = '<br /><br />Jeśli chcesz użyć przekierowania do innej domeny powinno ono się zaczynać od http:// lub https://.';
$lng['panel']['pathDescriptionSubdomain'] = $lng['panel']['pathDescription'].$lng['panel']['pathDescriptionEx']."<br /><br />Jeśli URL kończy się na / wskazuje ono na folder, jeśli nie, jest ono plikiem.";

// ADDED IN 1.2.16-svn6

$lng['admin']['templates']['TRAFFIC'] = 'Zastąp ruchem w mB, który jest przydzielony do klienta.';
$lng['admin']['templates']['TRAFFICUSED'] = 'Zastąp ruchem w MB, który został wykorzystany przez klienta.';

// ADDED IN 1.2.16-svn7

$lng['admin']['subcanemaildomain']['never'] = 'Nigdy';
$lng['admin']['subcanemaildomain']['choosableno'] = 'Możliwość wyboru, domyślnie nie';
$lng['admin']['subcanemaildomain']['choosableyes'] = 'Możliwość wyboru, domyślnie tak';
$lng['admin']['subcanemaildomain']['always'] = 'Zawsze';
$lng['changepassword']['also_change_webalizer'] = 'również zmieni hasło na stronie statystyk';

// ADDED IN 1.2.16-svn8

$lng['serversettings']['mailpwcleartext']['title'] = 'Również zapisuj hasła kont pocztowych niekodowane w bazie';
$lng['serversettings']['mailpwcleartext']['description'] = 'Jeśli jest ustawiona na tak, wszystkie hasła będą również zapisywane bez szyfrowania (wyraźny tekst, zwykły czytelne dla każdego z dostępem do bazy danych) w tabeli mail_users. Tylko włączyć tę opcję, jeśli chcesz używać SASL!';
$lng['serversettings']['mailpwcleartext']['removelink'] = 'Kliknij tutaj, aby wytrzeć wszystkie niekodowanych hasła z tabeli.';
$lng['question']['admin_cleartextmailpws_reallywipe'] = 'Czy na pewno chcesz, aby wymazać wszystkie niekodowane hasła do kont poczty z tabeli mail_users? Nie można cofnąć!';
$lng['admin']['configfiles']['overview'] = 'Podgląd';
$lng['admin']['configfiles']['wizard'] = 'Konfigurator';
$lng['admin']['configfiles']['distribution'] = 'Dystrybucja';
$lng['admin']['configfiles']['service'] = 'Usługa';
$lng['admin']['configfiles']['daemon'] = 'Daemon';
$lng['admin']['configfiles']['http'] = 'Serwer web (HTTP)';
$lng['admin']['configfiles']['dns'] = 'Serwer Nazw (DNS)';
$lng['admin']['configfiles']['mail'] = 'Serwer nazw (IMAP/POP3)';
$lng['admin']['configfiles']['smtp'] = 'Serwer pocztowy (SMTP)';
$lng['admin']['configfiles']['ftp'] = 'Serwer FTP';
$lng['admin']['configfiles']['etc'] = 'Inne (Systemowe)';
$lng['admin']['configfiles']['choosedistribution'] = '-- Wybierz dystrybucję --';
$lng['admin']['configfiles']['chooseservice'] = '-- Wybierz usługę --';
$lng['admin']['configfiles']['choosedaemon'] = '-- Wybierz demona --';

// ADDED IN 1.2.16-svn10

$lng['serversettings']['ftpdomain']['title'] = 'Konta FTP @domena';
$lng['serversettings']['ftpdomain']['description'] = 'Klienci mogą tworzyć konta użytkownik@(domena klienta)?';
$lng['panel']['back'] = 'Cofnij';

// ADDED IN 1.2.16-svn12

$lng['serversettings']['mod_fcgid']['title'] = 'Włącz FCGID';
$lng['serversettings']['mod_fcgid']['description'] = 'Użyj tego, aby uruchomić PHP z odpowiednim kontem użytkownika.<br /><br /><b>To wymaga specjalnej konfiguracji serwera WWW Apache, patrz <a target="blank" href="http://redmine.froxlor.org/projects/froxlor/wiki/HandbookApache2_fcgid">FCGID - handbook</a></b>';
$lng['serversettings']['sendalternativemail']['title'] = 'Użyj alternatywnego adresu email';
$lng['serversettings']['sendalternativemail']['description'] = 'Wyślij maila hasłem na inny adres e-mail podany podczas tworzenia konta';
$lng['emails']['alternative_emailaddress'] = 'Alternatywny adres mailowy';
$lng['mails']['pop_success_alternative']['mailbody'] = 'Witaj,\n\nTwoje konto pocztowe{EMAIL}\nzostało utworzone pomyślnie.\nTwoje haslo to {PASSWORD}.\n\nTo konto zostało automatycznie utworzone\n, Prosimy nie odpowiadać!\n\nZ poważaniem, administrator';
$lng['mails']['pop_success_alternative']['subject'] = 'Konto mailowe utworzone pomyślnie';
$lng['admin']['templates']['pop_success_alternative'] = 'Powitalny mail z nowej poczty został wysłany na alternatywny adres';
$lng['admin']['templates']['EMAIL_PASSWORD'] = 'Zastąpiony przez hasło do konta POP3/IMAP .';

// ADDED IN 1.2.16-svn13

$lng['error']['documentrootexists'] = 'W katalogu %s już istnieje dla tego klienta. Proszę usunąć to przed dodaniem ponownie klienta.';

// ADDED IN 1.2.16-svn14

$lng['serversettings']['apacheconf_vhost']['title'] = 'Serwer web plik konfiguracyjny / katalog vHost ';
$lng['serversettings']['apacheconf_vhost']['description'] = 'Gdzie konfiguracja vhosta ma być przechowywana? Można też określić plik vhostów  (wszystkie w jednym pliku) lub katalog (każdego vhosta w swoim pliku) .';
$lng['serversettings']['apacheconf_diroptions']['title'] = 'Serwer web opcje katalogu konfguracji plik/katalog';
$lng['serversettings']['apacheconf_diroptions']['description'] = 'Gdzie konfiguracja katalogu ma być przechowywane? Można też określić plik (wszystkie konfiguracje w jednym pliku) lub katalog (każda konfiguracja w swoim pliku) .';
$lng['serversettings']['apacheconf_htpasswddir']['title'] = 'Nazwa katalogu serwera web dla htpasswd';
$lng['serversettings']['apacheconf_htpasswddir']['description'] = 'Gdzie powinny być przechowywane pliki do ochrony katalogu htpasswd?';

// ADDED IN 1.2.16-svn15

$lng['error']['formtokencompromised'] = 'Zapytanie wygląda na nieprawidłowe. Ze względów bezpieczeństwa zostałeś wylogowany.';
$lng['serversettings']['mysql_access_host']['title'] = 'Hosty z dostępem do Mysql';
$lng['serversettings']['mysql_access_host']['description'] = 'Oddzielone przecinkami listę hostów, z których użytkownicy powinni mieć możliwość, aby połączyć się z serwerem MySQL.';

// ADDED IN 1.2.18-svn1

$lng['admin']['ipsandports']['create_listen_statement'] = 'Utwórz wyrażenie Listen';
$lng['admin']['ipsandports']['create_namevirtualhost_statement'] = 'Utwórz wyrażenie NameVirtualHost';
$lng['admin']['ipsandports']['create_vhostcontainer'] = 'Utwórz kontener vHost';
$lng['admin']['ipsandports']['create_vhostcontainer_servername_statement'] = 'Utwórz wyrażenie ServerName w vHost-Container';

// ADDED IN 1.2.18-svn2

$lng['admin']['webalizersettings'] = 'Ustawienia analizatora web';
$lng['admin']['webalizer']['normal'] = 'Normalny';
$lng['admin']['webalizer']['quiet'] = 'Cichy';
$lng['admin']['webalizer']['veryquiet'] = 'Bez wyjścia';
$lng['serversettings']['webalizer_quiet']['title'] = 'Wyjście analizy';
$lng['serversettings']['webalizer_quiet']['description'] = 'Poziom logów programu analizującego';

// ADDED IN 1.2.18-svn3

$lng['ticket']['admin_email'] = 'root@localhost';
$lng['ticket']['noreply_email'] = 'tickets@froxlor';
$lng['admin']['ticketsystem'] = 'System zgłoszeń';
$lng['menue']['ticket']['ticket'] = 'Zgłoszenia';
$lng['menue']['ticket']['categories'] = 'Wspierane kategorie';
$lng['menue']['ticket']['archive'] = 'Archiwizuj zgłoszenia';
$lng['ticket']['description'] = 'Tutaj możesz wysłać zgłoszenia do właściwego administratora. <br /> Powiadomienia będą wysyłane za pośrednictwem poczty e-mail.';
$lng['ticket']['ticket_new'] = 'Otwórz nowe zgłoszenie';
$lng['ticket']['ticket_reply'] = 'Odpowiedz na zgłoszenie';
$lng['ticket']['ticket_reopen'] = 'Otwórz ponownie zgłoszenie';
$lng['ticket']['ticket_newcateory'] = 'Utwórz nową kategorie';
$lng['ticket']['ticket_editcateory'] = 'Edytuj kategorie';
$lng['ticket']['ticket_view'] = 'Wyświetl plan zgoszeń';
$lng['ticket']['ticketcount'] = 'Zgłoszenia';
$lng['ticket']['ticket_answers'] = 'Odpowiedzi';
$lng['ticket']['subject'] = 'Temat';
$lng['ticket']['status'] = 'Status';
$lng['ticket']['lastreplier'] = 'Ostatnia odpowiedz';
$lng['ticket']['priority'] = 'Priorytet';
$lng['ticket']['low'] = 'Niski';
$lng['ticket']['normal'] = 'Normalny';
$lng['ticket']['high'] = 'Wysoki';
$lng['ticket']['lastchange'] = 'Ostatnia zmiana';
$lng['ticket']['lastchange_from'] = 'Od daty (dd.mm.yyyy)';
$lng['ticket']['lastchange_to'] = 'Do daty (dd.mm.yyyy)';
$lng['ticket']['category'] = 'kategoria';
$lng['ticket']['no_cat'] = 'Brak';
$lng['ticket']['message'] = 'Wiadomość';
$lng['ticket']['show'] = 'Widok';
$lng['ticket']['answer'] = 'Odpowiedz';
$lng['ticket']['close'] = 'Zamknij';
$lng['ticket']['reopen'] = 'Otwórz ponownie';
$lng['ticket']['archive'] = 'Archwizuj';
$lng['ticket']['ticket_delete'] = 'Usuń zgłoszenie';
$lng['ticket']['lastarchived'] = 'Zgłoszenia ostatnio zarchiwizowane';
$lng['ticket']['archivedtime'] = 'Zarchwizowane';
$lng['ticket']['open'] = 'Otwórz';
$lng['ticket']['wait_reply'] = 'Oczekiwanie na odpowiedz';
$lng['ticket']['replied'] = 'Odpowiedziano';
$lng['ticket']['closed'] = 'Zamknięte';
$lng['ticket']['staff'] = 'Personel';
$lng['ticket']['customer'] = 'Klient';
$lng['ticket']['old_tickets'] = 'Wiadomość w zgłoszeniu';
$lng['ticket']['search'] = 'Szukaj w archiwum';
$lng['ticket']['nocustomer'] = 'Brak wyboru';
$lng['ticket']['archivesearch'] = 'Archiwizuj wyniki wyszukiwania';
$lng['ticket']['noresults'] = 'Nie znaleziono zgłoszeń';
$lng['ticket']['notmorethanxopentickets'] = 'Ze względu na ochronę spamową nie można mieć więcej niż %s otwartych biletów';
$lng['ticket']['supportstatus'] = 'Status wsparcia';
$lng['ticket']['supportavailable'] = '<span class="ticket_low">Nasi inżynierowie wsparcia są dostępne i gotowe do pomocy.</span>';
$lng['ticket']['supportnotavailable'] = '<span class="ticket_high">Nasi inżynierowie wsparcia są teraz nie dostępni</span>';
$lng['admin']['templates']['ticket'] = 'Powiadomienie mail do wsparcia technicznego';
$lng['admin']['templates']['SUBJECT'] = 'Zastąpiony przez support-ticket subject';
$lng['admin']['templates']['new_ticket_for_customer'] = 'Informacje dla klienta, że zgłoszenie zostało wysłane';
$lng['admin']['templates']['new_ticket_by_customer'] = 'Powiadomienie Administrator o otwartym zgłoszeniu przez klienta';
$lng['admin']['templates']['new_reply_ticket_by_customer'] = 'Powiadomienie Administrator o odpowiedzi klienta';
$lng['admin']['templates']['new_ticket_by_staff'] = 'Powiadomienie klienta o otwartym zgłoszeniu przez obsługę';
$lng['admin']['templates']['new_reply_ticket_by_staff'] = 'Powiadomienie klienta o odpowiedzi przez obsługę';
$lng['mails']['new_ticket_for_customer']['mailbody'] = 'Witaj {FIRSTNAME} {NAME},\n\nTwoje zgłoszenie z tematem "{SUBJECT}" zostało wysłane.\n\nZostaniesz powiadomiony o odpowiedzi.\n\nZ poważaniem,\nTwój administrator';
$lng['mails']['new_ticket_for_customer']['subject'] = 'Twoje zgłoszenie zostało wysłane';
$lng['mails']['new_ticket_by_customer']['mailbody'] = 'Witaj Administratorze,\n\na nowe zgłoszenie z tematem"{SUBJECT}" zostało zgłoszone.\n\nProszę sie zalogować do otwartego zgłoszenia.\n\nZ poważaniem,\nTwój administrator';
$lng['mails']['new_ticket_by_customer']['subject'] = 'Utworzono nowe zgłoszenie wsparcia technicznego';
$lng['mails']['new_reply_ticket_by_customer']['mailbody'] = 'Witaj admin,\n\nwsparcie techniczne "{SUBJECT}" ma nową odpowiedź klienta.\n\nProszę się zalogować do ticketu.\n\nZ poważaniem,\nTwój administrator';
$lng['mails']['new_reply_ticket_by_customer']['subject'] = 'Nowa odpowiedź w zgłoszeniu';
$lng['mails']['new_ticket_by_staff']['mailbody'] = 'Witaj {FIRSTNAME} {NAME},\n\na wsparcie techniczne z tematem "{SUBJECT}" zostało otwarte dla Ciebie.\n\nProszę sie zalogować do otwartego zgłoszenia.\n\nZ poważaniem,\nTwój administrator';
$lng['mails']['new_ticket_by_staff']['subject'] = 'Nowe zgłoszenie techniczne';
$lng['mails']['new_reply_ticket_by_staff']['mailbody'] = 'Witaj {FIRSTNAME} {NAME},\n\n wsparcie techniczne z tematem "{SUBJECT}" ma nową odpowiedź zamieszczoną przez obsługę.\n\nProsże sie zalogować aby zobaczyć odpowiedź.\n\nZ poważaniem,\nTwój administrator';
$lng['mails']['new_reply_ticket_by_staff']['subject'] = 'Nowa odpowiedź w zgłoszeniu';
$lng['question']['ticket_reallyclose'] = 'Czy na pewno chcesz zamknąć zgłoszenie "%s"?';
$lng['question']['ticket_reallydelete'] = 'Czy na pewno chcesz usunąć zgłoszenie "%s"?';
$lng['question']['ticket_reallydeletecat'] = 'Czy na pewno chcesz usunąć kategorie "%s"?';
$lng['question']['ticket_reallyarchive'] = 'Czy napewno chcesz przenieść zgłoszenie "%s" do archiwum  ?';
$lng['error']['nomoreticketsavailable'] = 'Zużyłeś już wszystkie zgłoszenia w danym okresie. Prosimy o kontakt z administratorem.';
$lng['error']['nocustomerforticket'] = 'Nie możesz utworzyć zgłoszenia';
$lng['error']['categoryhastickets'] = 'kategoria posiada zgłoszenia.<br />Proszę o usunięcie zgłoszeń z kategori';
$lng['admin']['ticketsettings'] = 'Ustawienia systemu zgłoszeń';
$lng['admin']['archivelastrun'] = 'Ostatnie zarchiwizowane zgłoszenie';
$lng['serversettings']['ticket']['noreply_email']['title'] = 'Adres odpowiedzi';
$lng['serversettings']['ticket']['noreply_email']['description'] = 'Adres nadawcy dla zgłoszeń, przeważnie coś no-reply@domain.tld';
$lng['serversettings']['ticket']['worktime_begin']['title'] = 'Czas rozpoczęcia pracy (hh:mm)';
$lng['serversettings']['ticket']['worktime_begin']['description'] = 'Godzina od której technicy są dostępni';
$lng['serversettings']['ticket']['worktime_end']['title'] = 'Czas zakończenia pracy (hh:mm)';
$lng['serversettings']['ticket']['worktime_end']['description'] = 'Godzina do której technicy są dostępni';
$lng['serversettings']['ticket']['worktime_sat'] = 'Wsparcie dostępne w soboty?';
$lng['serversettings']['ticket']['worktime_sun'] = 'Wsparcie dostępne w niedzielę?';
$lng['serversettings']['ticket']['worktime_all']['title'] = 'Brak ograniczenia czasowego';
$lng['serversettings']['ticket']['worktime_all']['description'] = 'Jeśli "tak" opcje dla rozpoczęcia i końca czasu zostaną nadpisane';
$lng['serversettings']['ticket']['archiving_days'] = 'Po ilu dniach zgłoszenie ma zostać zarchiwizowane?';
$lng['customer']['tickets'] = 'Wsparcie techniczne';

// ADDED IN 1.2.18-svn4

$lng['admin']['domain_nocustomeraddingavailable'] = 'Nie jest możliwe, aby dodać domenę obecnie. Najpierw trzeba dodać co najmniej jednego klienta.';
$lng['serversettings']['ticket']['enable'] = 'Włącz system zgłoszeń';
$lng['serversettings']['ticket']['concurrentlyopen'] = 'Ile zgłoszeń może być otwarte w tym samym czasie?';
$lng['error']['norepymailiswrong'] = '"Noreply-address" jest zły. Tylko poprawny adres email jest dozwolone.';
$lng['error']['tadminmailiswrong'] = '"Ticketadmin-address" jest zły. Tylko poprawny adres email jest dozwolone.';
$lng['ticket']['awaitingticketreply'] = 'Posiadasz %s zgłoszeń bez odpowiedzi';

// ADDED IN 1.2.18-svn5

$lng['serversettings']['ticket']['noreply_name'] = 'Nazwa nadwacy maila w systemie zgłoszeń';

// ADDED IN 1.2.19-svn1

$lng['serversettings']['mod_fcgid']['configdir']['title'] = 'Katalog konfiguracji';
$lng['serversettings']['mod_fcgid']['configdir']['description'] = 'Gdzie powinni być przechowywane pliki fcgid konfiguracji? Jeśli nie używasz u siebie skompilowanego suexec binarnego, który jest normalna sytuacja, ta ścieżka musi być w / var <br /> / www / <br /> <div class = "red"> UWAGA: Ten folder\zawartość  jest regularnie usuwana więc unikaj przechowywania danych w nim. </ div>';
$lng['serversettings']['mod_fcgid']['tmpdir']['title'] = 'Katalog tymczasowy';

// ADDED IN 1.2.19-svn3

$lng['serversettings']['ticket']['reset_cycle']['title'] = 'Resetuj użycie zgłoszeń';
$lng['serversettings']['ticket']['reset_cycle']['description'] = 'Resetuje użycie zgłoszeń dla klienta do 0 w danym cyklu';
$lng['admin']['tickets']['daily'] = 'Dziennie';
$lng['admin']['tickets']['weekly'] = 'Tygodniowo';
$lng['admin']['tickets']['monthly'] = 'Miesięcznie';
$lng['admin']['tickets']['yearly'] = 'Rocznie';
$lng['error']['ticketresetcycleiswrong'] = 'Cykl zgłoszeń będzie resetowany "dziennie", "tygodniowo", "miesięcznie" or "rocznie".';

// ADDED IN 1.2.19-svn4

$lng['menue']['traffic']['traffic'] = 'Ruch';
$lng['menue']['traffic']['current'] = 'Bieżący miesiąc';
$lng['traffic']['month'] = "miesiąc";
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
$lng['traffic']['mb'] = "Ruch (MiB)";
$lng['traffic']['distribution'] = '<font color="#019522">FTP</font> | <font color="#0000FF">HTTP</font> | <font color="#800000">Mail</font>';
$lng['traffic']['sumhttp'] = 'Całkowity ruch HTTP';
$lng['traffic']['sumftp'] = 'Całkowity ruch FTP';
$lng['traffic']['summail'] = 'Całkowity ruch Mail';

// ADDED IN 1.2.19-svn4.5

$lng['serversettings']['no_robots']['title'] = 'Pozwól robotą na indeksowanie Twojej instalacji Froxlor-a';

// ADDED IN 1.2.19-svn6

$lng['admin']['loggersettings'] = 'Ustawienia logowania';
$lng['serversettings']['logger']['enable'] = 'Logowanie włączone / Wyłączone';
$lng['serversettings']['logger']['severity'] = 'Poziom logowania';
$lng['admin']['logger']['normal'] = 'Normalny';
$lng['admin']['logger']['paranoid'] = 'Paranoidalny';
$lng['serversettings']['logger']['types']['title'] = 'Typ log(ów)';
$lng['serversettings']['logger']['types']['description'] = 'Określ typy logów. Do zaznaczenia wielu, przytrzymaj CTRL podczas zaznaczania.<br />Dotepne typy logów: syslog, plikowy , mysql';
$lng['serversettings']['logger']['logfile'] = 'Ścieżka do pliku z logiem wraz z nazwą';
$lng['error']['logerror'] = 'Błędy logu: %s';
$lng['serversettings']['logger']['logcron'] = 'Loguj zadania cron (jednorazowo)';
$lng['question']['logger_reallytruncate'] = 'Czy na pewno chcesz okroić tabelę "%s"?';
$lng['admin']['loggersystem'] = 'Logowanie systemowe';
$lng['menue']['logger']['logger'] = 'Loger Systemowy';   
$lng['logger']['date'] = 'Data';
$lng['logger']['type'] = 'Typ';
$lng['logger']['action'] = 'Akcja';
$lng['logger']['user'] = 'Użytkownik';
$lng['logger']['truncate'] = 'Wyczyść log';

// ADDED IN 1.2.19-svn7

$lng['serversettings']['ssl']['use_ssl']['title'] = 'Włącz obsługę SSL';
$lng['serversettings']['ssl']['use_ssl']['description'] = 'Zaznacz to, jeśli chcesz korzystać z protokołu SSL na swoim serwerze';
$lng['serversettings']['ssl']['ssl_cert_file']['title'] = 'Ścieżka do certyfikatów SSL';
$lng['serversettings']['ssl']['ssl_cert_file']['description'] = 'Określ ścieżkę, w tym nazwa pliku z .crt lub .pem pliku (głównym certyfikatem)';
$lng['serversettings']['ssl']['openssl_cnf'] = 'Ustawienia domyślne dla tworzenia pliku Cert';
$lng['panel']['reseller'] = 'Reseller';
$lng['panel']['admin'] = 'Administrator';
$lng['panel']['customer'] = 'Klient/ci';
$lng['error']['nomessagetosend'] = 'Nie wprowadziłeś wiadomości.';
$lng['error']['noreceipientsgiven'] = 'Nie wprowadziłeś odbiorcy';
$lng['admin']['emaildomain'] = 'Domena mailowa';
$lng['admin']['email_only'] = 'Tylko dolmena mailowa?';
$lng['admin']['wwwserveralias'] = 'Dodaj "www." jako Alias Serwera';
$lng['admin']['ipsandports']['enable_ssl'] = 'To jest Port SSL?';
$lng['admin']['ipsandports']['ssl_cert_file'] = 'Ścieżka do certyfikatu SSL ';
$lng['panel']['send'] = 'wyślij';
$lng['admin']['subject'] = 'Temat';
$lng['admin']['receipient'] = 'Odbiorca';
$lng['admin']['message'] = 'Napisz wiadomość';
$lng['admin']['text'] = 'Wiadomość';
$lng['menu']['message'] = 'Wiadomości';
$lng['error']['errorsendingmail'] = 'Wystąpił bład podczas wysyłania wiadomości do "%s"';
$lng['error']['cannotreaddir'] = 'Nie można odczytać katalogu "%s"';
$lng['message']['success'] = 'Pomyślnie wysłano wiadomości do %s odbiorców';
$lng['message']['noreceipients'] = 'e-mail nie został wysłany, ponieważ nie ma odbiorcy w bazie danych';
$lng['admin']['sslsettings'] = 'Ustawienia SSL';
$lng['cronjobs']['notyetrun'] = 'Jeszcze nie uruchomiono';
$lng['serversettings']['default_vhostconf']['title'] = 'Domyślne ustawienia vHost-a';
$lng['serversettings']['default_vhostconf']['description'] = 'Zawartość tego pola zostanie włączona bezpośrednio do kontenera ip/port vhosta. Uwaga: Kod nie jest sprawdzany pod kątem jakiekolwiek błędów. Jeśli zawiera błędy, serwer WWW może się nie uruchomić ponownie!';
$lng['serversettings']['default_vhostconf_domain']['description'] = 'Zawartość tego pola zostanie włączona bezpośrednio do kontenera domeny vHost. Uwaga: Kod nie jest sprawdzany pod kątem jakiekolwiek błędów. Jeśli zawiera błędy, serwer WWW może się nie uruchomić ponownie!';
$lng['error']['invalidip'] = 'Invalid IP address: %s';
$lng['serversettings']['decimal_places'] = 'Liczba miejsc po przecinku w ruchu oraz przestrzeni dyskowej';

// ADDED IN 1.2.19-svn8

$lng['admin']['dkimsettings'] = 'Ustawienia DomainKey';
$lng['dkim']['dkim_prefix']['title'] = 'Prefix';
$lng['dkim']['dkim_prefix']['description'] = 'Proszę podać ścieżkę do plików RSA DKIM, jak również do plików konfiguracyjnych dla Milter-plugin';
$lng['dkim']['dkim_domains']['title'] = 'Pliki domen';
$lng['dkim']['dkim_domains']['description'] = '<em>Nazwa pliku</em> dla domen DKIM z parmaterami dla konfguracji dkim-milter';
$lng['dkim']['dkim_dkimkeys']['title'] = 'Nazwa pliku z listą kluczy';
$lng['dkim']['dkim_dkimkeys']['description'] = '<em>Nazwa pliku</em> dla kluczy  DKIM z parmaterami dla konfguracji dkim-milter';
$lng['dkim']['dkimrestart_command']['title'] = 'Polecenie restarujące Milter-a';
$lng['dkim']['dkimrestart_command']['description'] = 'Proszę o określenie polecenia restarjącego usługę DKIM milter';

// ADDED IN 1.2.19-svn9

$lng['admin']['caneditphpsettings'] = 'Można zmienić ustawienia domeny związane z PHP?';

// ADDED IN 1.2.19-svn12

$lng['admin']['allips'] = 'Wszystkie IP';
$lng['panel']['nosslipsavailable'] = 'Obecnie nie ma ssl kombinacji IP / portów dla serwera';
$lng['ticket']['by'] = 'Przez';
$lng['dkim']['use_dkim']['title'] = 'Aktywuj obsługę DKIM?';
$lng['dkim']['use_dkim']['description'] = 'Jeżeli chcesz korzystać z systemu DomainKeys (DKIM) <br/> <em class = "red"> Uwaga: DKIM jest obsługiwane tylko przy użyciu filtra DKIM nie opendkim (jeszcze) </ em></em>';
$lng['error']['invalidmysqlhost'] = 'Nieprawidłowy MySQL adres hosta: %s';
$lng['error']['cannotuseawstatsandwebalizeratonetime'] = 'Nie można włączyć webalizer i Awstats w tym samym czasie, należy wybrać jedn z nich';
$lng['serversettings']['webalizer_enabled'] = 'Włącz statystyki webalizer';
$lng['serversettings']['awstats_enabled'] = 'Włącz statystyki AWstats';
$lng['admin']['awstatssettings'] = 'Ustawienia AWstats ';

// ADDED IN 1.2.19-svn16

$lng['admin']['domain_dns_settings'] = 'Ustawienia DNS domeny';
$lng['dns']['destinationip'] = 'IP(s) domen';
$lng['dns']['standardip'] = 'IP standardowe serwera';
$lng['dns']['a_record'] = 'Record A(IPv6 opcjonalnie)';
$lng['dns']['cname_record'] = 'Record CNAME';
$lng['dns']['mxrecords'] = 'Zdefinuj rekordy MX';
$lng['dns']['standardmx'] = 'Standardowe rekordy serwera MX';
$lng['dns']['mxconfig'] = 'Własne rekordy MX';
$lng['dns']['priority10'] = 'Priorytet 10';
$lng['dns']['priority20'] = 'Priorytet 20';
$lng['dns']['txtrecords'] = 'Definuj rekordy TXT';
$lng['dns']['txtexample'] = 'Przykład (SPF-wpis):<br />v=spf1 ip4:xxx.xxx.xx.0/23 -all';
$lng['serversettings']['selfdns']['title'] = 'Ustawienia dns dla domen klientów';
$lng['serversettings']['selfdnscustomer']['title'] = 'Pozwól klientą na zmianę ustawień domeny';
$lng['admin']['activated'] = 'Aktywowane';
$lng['admin']['statisticsettings'] = 'Ustawienia statystyk';
$lng['admin']['or'] = 'lub';

// ADDED IN 1.2.19-svn17

$lng['serversettings']['unix_names']['title'] = 'Użyj kompatybilnych nazw użytkowników z UNIX ';
$lng['serversettings']['unix_names']['description'] = 'Pozwól na używanie<strong>-</strong> i <strong>_</strong> w nazwach użytkowników jeżeli<strong>Nie</strong>';
$lng['error']['cannotwritetologfile'] = 'Nie można otworzyć pliku log %s do zapisu';
$lng['admin']['sysload'] = 'Obciążenie systemu';
$lng['admin']['noloadavailable'] = 'Nie dostępne';
$lng['admin']['nouptimeavailable'] = 'Nie dostępne';
$lng['panel']['backtooverview'] = 'Wróć do przeglądu systemu';
$lng['admin']['nosubject'] = '(Brak tematu)';
$lng['admin']['configfiles']['statistics'] = 'Statystyki';
$lng['login']['forgotpwd'] = 'Zapomniałeś hasła?';
$lng['login']['presend'] = 'Resetuj hasło';
$lng['login']['email'] = 'Adres E-mail ';
$lng['login']['remind'] = 'Resetuj moje hasło';
$lng['login']['usernotfound'] = 'Użytkownik nie odnaleziony!';
$lng['mails']['password_reset']['subject'] = 'Resetuj hasło';
$lng['mails']['password_reset']['mailbody'] = 'Witaj {SALUTATION},\n\ntutaj jest link do hasła. Ten link jest ważny przez 24 godziny.\n\n{LINK}\n\n Dziękujemy,\n Twój administrator';
$lng['pwdreminder']['success'] = 'Hasło zresetowane pomyślnie. Proszę o postępowanie zgodnie ze wskazówkami w mail-u.';

// ADDED IN 1.2.19-svn18

$lng['serversettings']['allow_password_reset']['title'] = 'Pozwól na resetowanie hasła przez klientów';
$lng['pwdreminder']['notallowed'] = 'Resetowanie hasła wyłączone';

// ADDED IN 1.2.19-svn21

$lng['customer']['title'] = 'Tytuł';
$lng['customer']['country'] = 'Kraj';
$lng['panel']['dateformat'] = 'YYYY-MM-DD';
$lng['panel']['dateformat_function'] = 'Y-m-d';

// Y = Year, m = Month, d = Day

$lng['panel']['timeformat_function'] = 'H:i:s';

// H = Hour, i = Minute, s = Second

$lng['panel']['default'] = 'Domyślnie';
$lng['panel']['never'] = 'Nigdy';
$lng['panel']['active'] = 'Aktywny';
$lng['panel']['please_choose'] = 'Proszę wybrać';
$lng['panel']['allow_modifications'] = 'Modyfikacje dozwolone';
$lng['domains']['add_date'] = 'Dodane do Froxlor-a';
$lng['domains']['registration_date'] = 'Dodane do rejestru';
$lng['domains']['topleveldomain'] = 'Top-Level-Domain';

// ADDED IN 1.2.19-svn22

$lng['serversettings']['allow_password_reset']['description'] = 'Klienci mogą zresetować swoje hasło ich link aktywacyjny zostanie wysłany na ich adres e-mail';
$lng['serversettings']['allow_password_reset_admin']['title'] = 'Pozwól na resetowanie hasła przez administrator-ów';
$lng['serversettings']['allow_password_reset_admin']['description'] = 'Admini / sprzedawcę można zresetować swoje hasło oraz link aktywacyjny zostanie wysłany na ich adres e-mail';

// ADDED IN 1.2.19-svn25

$lng['emails']['quota'] = 'Przydział przestrzeni';
$lng['emails']['noquota'] = 'Brak przydziału przestrzeni';
$lng['emails']['updatequota'] = 'Uaktualnij użycie przestrzeni';
$lng['serversettings']['mail_quota']['title'] = 'Użycie przestrzeni skrzynki pocztowej';
$lng['serversettings']['mail_quota']['description'] = 'Domyślna przestrzeń dyskowa dla nowych skrzynek pocztowych (MB).';
$lng['serversettings']['mail_quota_enabled']['title'] = 'Użyj przestrzeni dyskowej dla skrzynek klientów';
$lng['serversettings']['mail_quota_enabled']['description'] = 'Aktywuj używanie przestrzeni dyskowej w skrzynkach pocztowych. Domyślnie <b>Nie</b> wymaga dodatkowej konfiguracji.';
$lng['serversettings']['mail_quota_enabled']['removelink'] = 'Kliknij tutaj aby wyczyścić przydział dyskowy dla kont mailowych.';
$lng['serversettings']['mail_quota_enabled']['enforcelink'] = 'Kliknij tutaj aby wymusić domyślny przydział dyskowy dla wszystkich konto pocztowych.';
$lng['question']['admin_quotas_reallywipe'] = 'Czy na pewno chcesz wyczyścić cały przydział dyskowy w tabeli mail_users? Operacja jest nieodwracalna!';
$lng['question']['admin_quotas_reallyenforce'] = 'Czy naprawdę chcesz wymusić domyślny przydział dyskowy dla wszystkich użytkowników? Operacja nieodwracalna!';
$lng['error']['vmailquotawrong'] = 'Przydział dyskowy musi być liczbą dodatnią.';
$lng['customer']['email_quota'] = 'Przydział dyskowy E-mail';
$lng['customer']['email_imap'] = 'E-mail IMAP';
$lng['customer']['email_pop3'] = 'E-mail POP3';
$lng['customer']['mail_quota'] = 'Przydział dyskowy';
$lng['panel']['megabyte'] = 'MagaBajtów';
$lng['panel']['not_supported'] = 'Nie wspierane w: ';
$lng['emails']['quota_edit'] = 'Zmien przydział dyskowy dla E-Mail ';
$lng['error']['allocatetoomuchquota'] = 'Próbujesz przydzielić %s MB przydziału, ale nie masz wystarczająco zasobów.';

$lng['error']['missingfields'] = 'Nie wszystkie wymagane pola zostały wypełnione.';
$lng['error']['accountnotexisting'] = 'POdany adres email nie istnieje.';
$lng['admin']['security_settings'] = 'Opcje bezpieczeństwa';
$lng['admin']['know_what_youre_doing'] = 'Zmień jeśli wiesz co robisz!';
$lng['admin']['show_version_login']['title'] = 'Pokaż wersje Froxlora podczas logowania';
$lng['admin']['show_version_login']['description'] = 'Pokaż wersje Froxlora podczas logowania w stopce';
$lng['admin']['show_version_footer']['title'] = 'Pokaż wersje Froxlora w stopce';
$lng['admin']['show_version_footer']['description'] = 'Pokaż wersje Froxlora w stopce na pozostałych stronach';
$lng['admin']['froxlor_graphic']['title'] = 'Graficzny nagłówek w Froxlor';
$lng['admin']['froxlor_graphic']['description'] = 'Jaki graficzny nagłówek powinien być pokazywany';

//improved froxlor

$lng['menue']['phpsettings']['maintitle'] = 'Konfiguracja PHP ';
$lng['admin']['phpsettings']['title'] = 'Konfiguracja PHP';
$lng['admin']['phpsettings']['description'] = 'krótki opis';
$lng['admin']['phpsettings']['actions'] = 'Akcje';
$lng['admin']['phpsettings']['activedomains'] = 'Używane w domenie(ach)';
$lng['admin']['phpsettings']['notused'] = 'Konfiguracja nie jest w użyciu';
$lng['admin']['misc'] = 'Różne';
$lng['admin']['phpsettings']['editsettings'] = 'Zmień konfiguracje PHP';
$lng['admin']['phpsettings']['addsettings'] = 'Utwórz nową konfiguracje PHP';
$lng['admin']['phpsettings']['viewsettings'] = 'Pokaż konfiguracje PHP';
$lng['admin']['phpsettings']['phpinisettings'] = 'Ustawienia php.ini';
$lng['error']['nopermissionsorinvalidid'] = 'Nie masz wystarczająco uprawnień do zmiany lub nieprawidłowy id został podany.';
$lng['panel']['view'] = 'Pokaż';
$lng['question']['phpsetting_reallydelete'] = 'Czy na pewno chcesz usunąć te ustawienia? Wszystkie domeny, które wykorzystują te ustawienia zostaną zmienione do domyślnej konfiguracji.';
$lng['admin']['phpsettings']['addnew'] = 'Utwórz nowe ustawienia';
$lng['error']['phpsettingidwrong'] = 'Konfiguracja PHP z tym id nie istnieje';
$lng['error']['descriptioninvalid'] = 'Opis jest za krótki, za długi lub zawiera nie prawidłowe znaki.';
$lng['error']['info'] = 'Info';
$lng['admin']['phpconfig']['template_replace_vars'] = 'Zmienne które są zastępowane w ustawieniach konfiguracyjnych';
$lng['admin']['phpconfig']['pear_dir'] = 'Zostaną zastąpione przez globalne ustawienia dla PEAR-a.';
$lng['admin']['phpconfig']['open_basedir_c'] = 'Wstaw ; (średnik) do za komentowania/wyłączenia open_basedir jeśli ustawiony';
$lng['admin']['phpconfig']['open_basedir'] = 'Zostaną zastąpione ustawieniem open_basedir domeny.';
$lng['admin']['phpconfig']['tmp_dir'] = 'Zostanie zastąpiony tymczasowym katalogu domeny.';
$lng['admin']['phpconfig']['open_basedir_global'] = 'Zostanie zastąpiony wartością globalnego ścieżki, który będzie dołączony do open_basedir.';
$lng['admin']['phpconfig']['customer_email'] = 'Zostanie zastąpione adresem e-mail klienta, który jest właścicielem tej domeny.';
$lng['admin']['phpconfig']['admin_email'] = 'Zostaną zastąpione adres e-mail administratora, który jest właścicielem tej domeny.';
$lng['admin']['phpconfig']['domain'] = 'Zostaną zastąpione domeną.';
$lng['admin']['phpconfig']['customer'] = 'Zostanie zastąpione nazwą loginu klienta, który jest właścicielem tej domeny.';
$lng['admin']['phpconfig']['admin'] = 'Zostanie zastąpione nazwą loginu administratora, który jest właścicielem tej domeny.';
$lng['login']['backtologin'] = 'Wróć do logowania';
$lng['serversettings']['mod_fcgid']['starter']['title'] = 'Procesów na domenę';
$lng['serversettings']['mod_fcgid']['starter']['description'] = 'Ile procesów należy rozpocząć / dozwolone na domenie? Wartość 0 zalecane jest bo PHP będzie bardzo sprawnie zarządzać sam ilością procesów.';
$lng['serversettings']['mod_fcgid']['wrapper']['title'] = 'Wrapper w vhost-cie';
$lng['serversettings']['mod_fcgid']['wrapper']['description'] = 'Jak powinny wrappery być zawarte w vhost-ach';
$lng['serversettings']['mod_fcgid']['tmpdir']['description'] = 'Gdzie katalogi temp powinny być przechowywane';
$lng['serversettings']['mod_fcgid']['peardir']['title'] = 'Globalne katalogi PEAR';
$lng['serversettings']['mod_fcgid']['peardir']['description'] = 'PEAR globalne katalogi, które należy zastąpić w każdym php.ini? Wiele katalogów musi być rozdzielone dwukropkiem.';

//improved Froxlor  2

$lng['admin']['templates']['index_html'] = 'Plik indexu dla nowo utworzonych katalogów klienta';
$lng['admin']['templates']['SERVERNAME'] = 'Zastąpiony przez nazwę serera.';
$lng['admin']['templates']['CUSTOMER'] = 'Zastąpiony przez login klienta.';
$lng['admin']['templates']['ADMIN'] = 'Zastąpiony przez login administratora.';
$lng['admin']['templates']['CUSTOMER_EMAIL'] = 'Zastąpiony przez adres e-mail klienta.';
$lng['admin']['templates']['ADMIN_EMAIL'] = 'Zastąpiony przez adres e-mail administratora.';
$lng['admin']['templates']['filetemplates'] = 'Plik szablonów';
$lng['admin']['templates']['filecontent'] = 'Zawrtość pliku';
$lng['error']['filecontentnotset'] = 'Plik nie może być pusty!';
$lng['serversettings']['index_file_extension']['description'] = 'Rozszerzenie pliku, który należy stosować do pliku indeksu w nowo tworzonych katalogach klientów? To rozszerzenie pliku zostanie użyty, jeśli ty lub ktoś z twoich adminów stworzył swój własny szablon pliku index.';
$lng['serversettings']['index_file_extension']['title'] = 'Rozszerzenie nazwy pliku dla pliku indeksu w nowo tworzonych katalogów klienta';
$lng['error']['index_file_extension'] = 'Rozszerzenie pliku do pliku indeksu musi mieć długość od 1 do 6 znaków. Rozszerzenie może zawierać tylko znaki takie jak a-z, A-Z i 0-9';
$lng['admin']['expert_settings'] = 'Ustawienia Experta!';
$lng['admin']['mod_fcgid_starter']['title'] = 'Procesy PHP dla tej domeny (puste dla wartości domyślnej)';

$lng['error']['customerdoesntexist'] = 'Wybrana klient nie istnieje.';
$lng['error']['admindoesntexist'] = 'Wybrana admin nie istnieje.';

// ADDED IN 1.2.19-svn37

$lng['serversettings']['session_allow_multiple_login']['title'] = 'Pozwól na wielokrotne logowanie';
$lng['serversettings']['session_allow_multiple_login']['description'] = 'Jeśli aktywne użytkownik może być zalogowany wiele razy.';
$lng['serversettings']['panel_allow_domain_change_admin']['title'] = 'Pozwól na przemieszczanie domen między administratorami';
$lng['serversettings']['panel_allow_domain_change_admin']['description'] = 'Jeśli jest aktywna można zmienić administratora do domeny w ustawieniach domeny <br /> <b> Uwaga:. </ B> Jeśli klienta nie jest przypisany do tej domeny u innego administratora, każdy inny Administrator może zobaczyć domenę klienta!';
$lng['serversettings']['panel_allow_domain_change_customer']['title'] = 'Pozwól na przemieszczanie domen między klientami';
$lng['serversettings']['panel_allow_domain_change_customer']['description'] = 'Jeśli jest aktywna można zmienić klienta do domeny w ustawieniach domeny <br /> <b> Uwaga:. </ B> Froxlor nie zmienia żadnych ścieżek. Może to uczynić domenę bezużyteczna!';
$lng['domains']['associated_with_domain'] = 'Przydzielone';
$lng['domains']['aliasdomains'] = 'Aliasy domen';
$lng['error']['ipportdoesntexist'] = 'Kombinacja ip/port którą wybrałeś nie istnieje.';

// ADDED IN 1.2.19-svn38

$lng['admin']['phpserversettings'] = 'Ustawienia PHP';
$lng['admin']['phpsettings']['binary'] = 'Plik binarny PHP ';
$lng['admin']['phpsettings']['file_extensions'] = 'Rozszerzenia plików';
$lng['admin']['phpsettings']['file_extensions_note'] = '(bez kropki, odseparowane spacją)';
$lng['admin']['mod_fcgid_maxrequests']['title'] = 'Maksymalna liczba zapytań do PHP dla tej domeny (Puste wartość domyślna)';
$lng['serversettings']['mod_fcgid']['maxrequests']['title'] = 'Maksymalna ilość zapytań';
$lng['serversettings']['mod_fcgid']['maxrequests']['description'] = 'Ile zapytań powinno być dozwolne dla tej domeny?';

// ADDED IN 1.4.2.1-1

$lng['mysql']['mysql_server'] = 'Serwer MySQL';

// ADDED IN 1.4.2.1-2

$lng['admin']['ipsandports']['webserverdefaultconfig'] = 'Domyślna konfiguracja web serwera';
$lng['admin']['ipsandports']['webserverdomainconfig'] = 'Konfiguracja serwera web domeny';
$lng['admin']['ipsandports']['webserverssldomainconfig'] = 'Konfiguracja SSL Web serwera';
$lng['admin']['ipsandports']['ssl_key_file'] = 'Ścieżka do klucza SSL';
$lng['admin']['ipsandports']['ssl_ca_file'] = 'Ścieżka do Certyfikatu CA SSL';
$lng['admin']['ipsandports']['default_vhostconf_domain'] = 'Domyślne ustawienia dla kontenera domeny vHost';
$lng['serversettings']['ssl']['ssl_key_file']['title'] = 'Ścieżka do klucza SSL';
$lng['serversettings']['ssl']['ssl_key_file']['description'] = 'Określ ścieżkę zawierającą nazwe pliku dla prywatnego pliku klucza (Główny klucz)';
$lng['serversettings']['ssl']['ssl_ca_file']['title'] = 'Ścieżka do certyfikatu CA SSL (Opcjonalnie)';
$lng['serversettings']['ssl']['ssl_ca_file']['description'] = 'Autoryzacja klienta, staw tylko wtedy gdy wiesz co robisz.';
$lng['error']['usernamealreadyexists'] = 'Użytkownik %s już istnieje.';
$lng['error']['plausibilitychecknotunderstood'] = 'Odpowiedź kontroli wiarygodności nie zrozumiała.';
$lng['error']['errorwhensaving'] = 'Wystąpił błąd podczas zapisu pola %s';
$lng['success']['success'] = 'Informacja';
$lng['success']['clickheretocontinue'] = 'Naciśnij tutaj aby kontynuwać';
$lng['success']['settingssaved'] = 'Ustawienia zostały pomyślnie zapisane.';

// ADDED IN FROXLOR 0.9

$lng['admin']['spfsettings'] = 'ustawienia domeny SPF';
$lng['spf']['use_spf'] = 'Aktywuj SPF dla domen?';
$lng['spf']['spf_entry'] = 'SPF wpis dla wszystkich domen';
$lng['panel']['toomanydirs'] = 'Za dużo podkatalogów. Przejdź do manualnej konfiguracji ścieżek.';
$lng['panel']['abort'] = 'Przerwij';
$lng['serversettings']['cron']['debug']['title'] = 'Debugowanie skrypt Cron';
$lng['serversettings']['cron']['debug']['description'] = 'Aktywuj aby zachować plik blokady uruchomienia cron dla debugownaia .<br /><b>Uwaga:</b>Utrzymanie plik blokującego może spowodować że następne zaplanowana zadania cron nie będą działać prawidłowo.';
$lng['panel']['not_activated'] = 'Nie aktywowany';
$lng['panel']['off'] = 'off';
$lng['update']['updateinprogress_onlyadmincanlogin'] = 'Nowsza wersja Froxlor została zainstalowana, ale nie jest jeszcze skonfigurowana. <br /> Tylko administrator może zalogować się i zakończyć aktualizację.';
$lng['update']['update'] = 'Aktualizacja Froxlor';
$lng['update']['proceed'] = 'Kontynuj';
$lng['update']['update_information']['part_a'] = 'Pliki Froxlor-a będą uaktualnione do wersji <strong>%newversion</strong>. Zainstalowana wersja to<strong>%curversion</strong>.';
$lng['update']['update_information']['part_b'] = '<br /><br />Klienci nie będą mogli się zalogować dopuki akutalizacja się nie zakończy.<br /><strong>Kontynuwać?</strong>';
$lng['update']['noupdatesavail'] = '<strong>Posiadasz najnowszą wersję Froxlor-a.</strong>';
$lng['admin']['specialsettingsforsubdomains'] = 'Zastosuj specjalnie ustawienia dla wszystkich pod domen (*.example.com)';
$lng['serversettings']['specialsettingsforsubdomains']['description'] = 'Jeśli tak te niestandardowe ustawienia vhosta zostanią dodany do wszystkich pod domen; jeśli nie ustawienia pod domen są usuwane.';
$lng['tasks']['outstanding_tasks'] = 'Zaległe zadania cron';
$lng['tasks']['rebuild_webserverconfig'] = 'Przebuduj konfiguracje servera web';
$lng['tasks']['adding_customer'] = 'Dodaj nowego klienta %loginname%';
$lng['tasks']['rebuild_bindconfig'] = 'Przebuduj konfiguracje bind';
$lng['tasks']['creating_ftpdir'] = 'Utwórz katalog dla nowych użytkowników FTP';
$lng['tasks']['deleting_customerfiles'] = 'Usuwanie plików klienta %loginname%';
$lng['tasks']['noneoutstanding'] = 'Nie ma zaległych zadań Cron dla Froxlor';
$lng['ticket']['nonexistingcustomer'] = '(Klient usunięty)';
$lng['admin']['ticket_nocustomeraddingavailable'] = 'Nie jest możliwe, aby otworzyć nowy bilet wsparcia technicznego. Najpierw trzeba dodać co najmniej jednego klienta.';

// ADDED IN FROXLOR 0.9.1

$lng['admin']['accountdata'] = 'Dane konta';
$lng['admin']['contactdata'] = 'Dane kontaktu';
$lng['admin']['servicedata'] = 'Dane usługi';

// ADDED IN FROXLOR 0.9.2

$lng['admin']['newerversionavailable'] = 'Dostępna jest nowsza wersja froxlora';

// ADDED IN FROXLOR 0.9.3

$lng['emails']['noemaildomainaddedyet'] = 'Nie masz domeny mailowej jeszcze dla tej domeny.';
$lng['error']['hiddenfieldvaluechanged'] = 'Wartośc dla ukrytego pola "%s" zostanie zmieniona gdy edytujesz to pole.<br /><br />
Zwykle nie jest to duży problem, ale ustawienia nie można zapisać z tego powodu.';

// ADDED IN FROXLOR 0.9.3-svn1

$lng['serversettings']['panel_password_min_length']['title'] = 'Minimalna długość hasła';
$lng['serversettings']['panel_password_min_length']['description'] = 'Tutaj możesz ustawić minimalna długość hasła. \'0\' oznacza: minimalna długość nie jest wymgana.';
$lng['error']['notrequiredpasswordlength'] = 'Podane hasło jest za krótkie. Proszę podać %s znaków.';
$lng['serversettings']['system_store_index_file_subs']['title'] = 'Zapisz domyślny index w podfolderach';
$lng['serversettings']['system_store_index_file_subs']['description'] = 'Jeśli opcja jest włączona, plik indexu domyślnie jest przechowywany dla każdej pod domeny ścieżce zostanie utworzona (nie, jeśli folder już istnieje!)';

// ADDED IN FROXLOR 0.9.3-svn2

$lng['serversettings']['adminmail_return']['title'] = 'Adres odpowiedzi';
$lng['serversettings']['adminmail_return']['description'] = 'Zdefiniuj adres e-mail jako adress odpowiedzi do maili wysyłanych przez panel.';
$lng['serversettings']['adminmail_defname'] = 'Nazwa pod jaka są wysyłane wiadomości z panelu';

// ADDED IN FROXLOR 0.9.3-svn3
$lng['dkim']['dkim_algorithm']['title'] = 'Dozwolne algorytmy szyfrujące';
$lng['dkim']['dkim_algorithm']['description'] = 'Zdefinuj dozwolne algorytmy szyfrujące, Wybierz "Wszystkie" dla wszystkich algorytmów lub 1 lub więcej z dostepnych algorytmów';
$lng['dkim']['dkim_servicetype'] = 'Typu usług';
$lng['dkim']['dkim_keylength']['title'] = 'Długość klucza';
$lng['dkim']['dkim_keylength']['description'] = 'Ostrzeżenie: Jeśli zmienisz te wartości, Musisz usunąć wszystkie prywatne/publiczne pliki "%s"';
$lng['dkim']['dkim_notes']['title'] = 'DKIM Notatki';
$lng['dkim']['dkim_notes']['description'] = 'Notatki mogą być przydatne dla ludzi, przykład. URL typu http://www.dnswatch.info. Nie funkcjonuje jako program. Ten znacznik należy stosować z umiarem ze względu na ograniczenia miejsca w systemie DNS. Ten jest przeznaczony dla administratorów, nie dla użytkowników końcowych.';
$lng['dkim']['dkim_add_adsp']['title'] = 'Dodaj DKIM ADSP wpis';
$lng['dkim']['dkim_add_adsp']['description'] = 'Jeśli nie wiesz co to jest, pozsotaw "włączone"';
$lng['dkim']['dkim_add_adsppolicy']['title'] = 'Polityka ADSP';
$lng['dkim']['dkim_add_adsppolicy']['description'] = 'Aby uzyskać więcej informacji na temat tego ustawienia zobacz <a target="blank" href="http://redmine.froxlor.org/projects/froxlor/wiki/En-dkim-adsp-policies"> DKIM polityka ADSP </a>';

$lng['admin']['cron']['cronsettings'] = 'Ustawienia zadań CRON';
$lng['cron']['cronname'] = 'Nazwa zadania CRON';
$lng['cron']['lastrun'] = 'Ostanie uruchomienie';
$lng['cron']['interval'] = 'interwał';
$lng['cron']['isactive'] = 'Włączony';
$lng['cron']['description'] = 'Opis';
$lng['crondesc']['cron_unknown_desc'] = 'Brak podanego opisu';
$lng['admin']['cron']['add'] = 'Dodaj zadanie CRON';
$lng['crondesc']['cron_tasks'] = 'generowanie plików konfiguracyjnych';
$lng['crondesc']['cron_legacy'] = 'Ostatnie zadanie cron';
$lng['crondesc']['cron_traffic'] = 'Kalkulacja transferu';
$lng['crondesc']['cron_ticketsreset'] = 'Resetowanie licznika zgłoszeń';
$lng['crondesc']['cron_ticketarchive'] = 'Archiwizowanie starych zgłoszeń';
$lng['cronmgmt']['minutes'] = 'Minuty';
$lng['cronmgmt']['hours'] = 'godziny';
$lng['cronmgmt']['days'] = 'dni';
$lng['cronmgmt']['weeks'] = 'tygodnie';
$lng['cronmgmt']['months'] = 'miesiące';
$lng['admin']['cronjob_edit'] = 'Edytuj zadania cron';
$lng['cronjob']['cronjobsettings'] = 'Ustawienia zadania cron';
$lng['cronjob']['cronjobintervalv'] = 'Wartośc interwału uruchomienia';
$lng['cronjob']['cronjobinterval'] = 'Interwał uruchomienia';
$lng['panel']['options'] = 'Opcje';
$lng['admin']['warning'] = 'WARNING - Proszę przeczytaj!';
$lng['cron']['changewarning'] = 'Zmiana tych wartości może mieć negatywny powód do zachowania Froxlor i zautomatyzowanych zadań. <br /> <br /> Proszę zmienić tylko wtedy gdy jesteś pewien, że wiesz, co robisz.';

$lng['serversettings']['stdsubdomainhost']['title'] = 'Standardowa pod domena klienta';
$lng['serversettings']['stdsubdomainhost']['description'] = 'Jaka nazwa hosta powinny być wykorzystywane do tworzenia standardowych subdomen dla klienta. Jeśli puste, stosowany jest system-hosta.';

// ADDED IN FROXLOR 0.9.4-svn1
$lng['ftp']['account_edit'] = 'Edytuj konta ftp';
$lng['ftp']['editpassdescription'] = 'Wprowadź nowe hasło lub pozostaw puste aby nie wprowadzać zmian.';
$lng['customer']['sendinfomail'] = 'Wyślij dane na maila do mnie';
$lng['mails']['new_database_by_customer']['subject'] = '[Froxlor] Nowa baza danych utworzona';
$lng['mails']['new_database_by_customer']['mailbody'] = "Witaj {CUST_NAME},\n\nWłasnie dodałeś nową bazę. Tutaj są wprowadzone dane:\n\nNazwa bazy: {DB_NAME}\nHasło: {DB_PASS}\nOpis: {DB_DESC}\nNazwa hosta: {DB_SRV}\nphpMyAdmin: {PMA_URI}\nZ poważaniem Administrator";
$lng['serversettings']['awstats_path'] = 'Scieżka do AWStats \'awstats_buildstaticpages.pl\'';
$lng['serversettings']['awstats_conf'] = 'AWStats ścieżka konfiguracji';
$lng['error']['overviewsettingoptionisnotavalidfield'] = 'Woops, pole, które powinny być wyświetlane jako opcja w ustawieniach-przegląd nie jest typem wyłączonych. Można winić za to twórców. To nie powinno się zdarzyć!';
$lng['admin']['configfiles']['compactoverview'] = 'Zwarty podgląd';
$lng['admin']['lastlogin_succ'] = 'Ostatnie logowanie';
$lng['panel']['neverloggedin'] = 'Jeszcze nie zalogowany';

// ADDED IN FROXLOR 0.9.6-svn1
$lng['serversettings']['defaultttl'] = 'TTL dla domeny w bind w sekundach (domyślnie \'604800\' = 1 tydzień)';
$lng['ticket']['logicalorder'] = 'Kolejność logiczna';
$lng['ticket']['orderdesc'] = 'Tutaj możesz zdefiniować własny logiczny porządek dla kategorii wsparcia technicznego. Użyj 1 - 999, niższe numery są wyświetlane w pierwszej kolejności.';

// ADDED IN FROXLOR 0.9.6-svn3
$lng['serversettings']['defaultwebsrverrhandler_enabled'] = 'Włącz domyślne dokumenty błędów dla wszystkich klientów';
$lng['serversettings']['defaultwebsrverrhandler_err401']['title'] = 'Plik/URL dla błedu 401';
$lng['serversettings']['defaultwebsrverrhandler_err401']['description'] = '<div class="red">Nie wspierane w: lighttpd</div>';
$lng['serversettings']['defaultwebsrverrhandler_err403']['title'] = 'Plik/URL dla błedu 403';
$lng['serversettings']['defaultwebsrverrhandler_err403']['description'] = '<div class="red">Nie wspierane w: lighttpd</div>';
$lng['serversettings']['defaultwebsrverrhandler_err404'] = 'Plik/URL dla błedu 404';
$lng['serversettings']['defaultwebsrverrhandler_err500']['title'] = 'Plik/URL dla błedu 500';
$lng['serversettings']['defaultwebsrverrhandler_err500']['description'] = '<div class="red">Nie wspierane w: lighttpd</div>';

// ADDED IN FROXLOR 0.9.6-svn4
$lng['serversettings']['ticket']['default_priority'] = 'Domyślny piorytet zadania wsprcia technicznego';

// ADDED IN FROXLOR 0.9.6-svn5
$lng['serversettings']['mod_fcgid']['defaultini'] = 'Domyślna konfiguracja PHP dla nowych domen';

// ADDED IN FROXLOR 0.9.6-svn6
$lng['admin']['ftpserver'] = 'Serwer FTP';
$lng['admin']['ftpserversettings'] = 'Ustawienia serwera FTP';
$lng['serversettings']['ftpserver']['desc'] = 'Jeśli w pureftpd zostanie wybrana opcja .ftpquota pliki z przydziałem miejsca użytkowników są tworzone i aktualizowane codziennie';

// ADDED IN FROXLOR 0.9.7-svn1
$lng['mails']['new_ftpaccount_by_customer']['subject'] = 'Utworzono nowego użytkownika FTP';
$lng['mails']['new_ftpaccount_by_customer']['mailbody'] = "Witaj {CUST_NAME},\n\nwłasnie dodałeś użytkownika ftp. Oto wprowadzone informacje:\n\nNazwa użytkownika: {USR_NAME}\nHasło: {USR_PASS}\nŚcieżka: {USR_PATH}\n\nZ poważaniem, Administrator";
$lng['domains']['redirectifpathisurl'] = 'Kod przekierowania (Domyślnie: puste)';
$lng['domains']['redirectifpathisurlinfo'] = 'Wystarczy tylko wybrać jedną z nich, jeśli wpisany URL w ścieżce';
$lng['serversettings']['customredirect_enabled']['title'] = 'Pozwól na przekierowania klientów';
$lng['serversettings']['customredirect_enabled']['description'] = 'Pozwalają klientom wybrać kod stanu HTTP dla przekierowań, który będzie używany';
$lng['serversettings']['customredirect_default']['title'] = 'Domyślne przekierowanie';
$lng['serversettings']['customredirect_default']['description'] = 'Ustaw przekierowanie domyślny kod, który powinien być używany, jeśli klient nie określa to sam';

// ADDED IN FROXLOR 0.9.7-svn2
$lng['error']['pathmaynotcontaincolon'] = 'Ścieżka powinna zawierać (":"). Proszę wprowadzić poprawną ścieżkę.';

// ADDED IN FROXLOR 0.9.7-svn3

// these stay only in english.lng.php - they are the same
// for all other languages and are used if not found there
$lng['redirect_desc']['rc_default'] = 'Domyślnie';
$lng['redirect_desc']['rc_movedperm'] = 'Przekierowanie permanentne';
$lng['redirect_desc']['rc_found'] = 'odnalezione';
$lng['redirect_desc']['rc_seeother'] = 'zobacz inny';
$lng['redirect_desc']['rc_tempred'] = 'Przekierowanie tymczasowe';

// ADDED IN FROXLOR 0.9.8
$lng['error']['exception'] = '%s';

// ADDED IN FROXLOR 0.9.9-svn1
$lng['serversettings']['mail_also_with_mxservers'] = 'Utwórz "A record" z ustawieniami serwera mx mail-, imap-, pop3- and smtp';

// ADDED IN FROXLOR 0.9.10-svn1
$lng['admin']['webserver_user'] = 'Użytkownik serwera web';
$lng['admin']['webserver_group'] = 'Grupa serwera web';

// ADDED IN FROXLOR 0.9.10
$lng['serversettings']['froxlordirectlyviahostname'] = 'Dostęp do FROXLOR-a bezpośrednio przez nazwę hosta';

// ADDED IN FROXLOR 0.9.11-svn1
$lng['serversettings']['panel_password_regex']['title'] = 'Wyrażenie regularne dla haseł';
$lng['serversettings']['panel_password_regex']['description'] = 'Tutaj możesz stworzyć wyrażenie regularne dla weryfikacji haseł.<br />Puste = brak wymagań';
$lng['error']['notrequiredpasswordcomplexity'] = 'Struktura hasła nie jest prawidłowa.<br />Proszę o kontakt z Administratorem jeśli masz pytania odnośnie struktury hasła';

// ADDED IN FROXLOR 0.9.11-svn2
$lng['extras']['execute_perl'] = 'Wykonaj perl/CGI';
$lng['admin']['perlenabled'] = 'Perl włączony';

// ADDED IN FROXLOR 0.9.11-svn3
$lng['serversettings']['perl_path']['title'] = 'Ścieżka do perl';
$lng['serversettings']['perl_path']['description'] = 'Domyślnie jest /usr/bin/perl';

// ADDED IN FROXLOR 0.9.12-svn1
$lng['admin']['fcgid_settings'] = 'FCGID';
$lng['serversettings']['mod_fcgid_ownvhost']['title'] = 'Włącz FCGID dla vHost Froxlor';
$lng['serversettings']['mod_fcgid_ownvhost']['description'] = 'Jeśli włączony, Froxlor będzie pracował jako lokalny użytkownik';
$lng['admin']['mod_fcgid_user'] = 'Lokalny użytkownik do używania FCGID (Froxlor vHost)';
$lng['admin']['mod_fcgid_group'] = 'Lokalna grupa do używania  FCGID (Froxlor vHost)';

// ADDED IN FROXLOR 0.9.12-svn2
$lng['admin']['perl_settings'] = 'Perl/CGI';
$lng['serversettings']['perl']['suexecworkaround']['title'] = 'Włącz obejście SuExec';
$lng['serversettings']['perl']['suexecworkaround']['description'] = 'Włacz tylko wtedy gdy klient docroots nie jest tylko apache suexec w ścieżce.<br />Jeśli włączone, Froxlor wygenerje link z katalogu klienta z włączonym perl + /cgi-bin/ dla danej ścieżki.<br />otka Perl może pracowac tylko z katalogiem /cgi-bin/ a nie w samym folderu (jak ma to miejsce bez tej poprawki!)';
$lng['serversettings']['perl']['suexeccgipath']['title'] = 'Ścieżka do katalogu z linkami włączonego perla';
$lng['serversettings']['perl']['suexeccgipath']['description'] = 'Potrzebujesz to ustawić tylko wtedy gdy obejście SuExec jest włączone.<br />Uwaga: Upewnij się, że ta ścieżka jest w ścieżce suexec albo to rozwiązanie będzie bezużyteczny';
$lng['panel']['descriptionerrordocument'] = 'Może być URL, ścieżka do pliku lub tekst otaczający" "<br />Pozstaw puste aby użyć ustawienia serwera.';
$lng['error']['stringerrordocumentnotvalidforlighty'] = 'Tekst ErrorDocument nie pracuje z lighttpd, proszę określić ścieżkę pliku';
$lng['error']['urlerrordocumentnotvalidforlighty'] = 'URL ErrorDocument nie pracuje z lighttpd, proszę określić ścieżkę pliku';

// ADDED IN FROXLOR 0.9.12-svn3
$lng['question']['remove_subbutmain_domains'] = 'Należy także usunąć domeny, które są dodawane jako pełne domeny, ale które są pod domenami tej domeny?';
$lng['domains']['issubof'] = 'Ta domena jest pod domena innej domeny';
$lng['domains']['issubofinfo'] = 'Musisz ustawić na odpowiedniej domenie, jeśli chcesz dodać pod domenę w pełnym domenie (np chcesz dodać "www.domena.tld", należy wybrać "domena.tld" tutaj)';
$lng['domains']['nosubtomaindomain'] = 'Brak pod domen w głównej domenie';
$lng['admin']['templates']['new_database_by_customer'] = 'Powiadomienia klienta, gdy baza danych została utworzona';
$lng['admin']['templates']['new_ftpaccount_by_customer'] = 'Powiadomienia klienta, gdy użytkownik ftp został utworzony';
$lng['admin']['templates']['newdatabase'] = 'Powiadomienie mailowe dla nowej bazy';
$lng['admin']['templates']['newftpuser'] = 'Powiadomienie mailowe dla nowego użytkownika FTP';
$lng['admin']['templates']['CUST_NAME'] = 'Nazwa klienta';
$lng['admin']['templates']['DB_NAME'] = 'Nazwa bazy danych';
$lng['admin']['templates']['DB_PASS'] = 'Hasło bazy danych';
$lng['admin']['templates']['DB_DESC'] = 'Opis bazy danych';
$lng['admin']['templates']['DB_SRV'] = 'Serwer bazodanowy';
$lng['admin']['templates']['PMA_URI'] = 'URL to phpMyAdmin (jeśli podany)';
$lng['admin']['notgiven'] = '[nie podany]';
$lng['admin']['templates']['USR_NAME'] = 'Użytkownik FTP';
$lng['admin']['templates']['USR_PASS'] = 'Hasło FTP';
$lng['admin']['templates']['USR_PATH'] = 'Katalog domowy FTP (w stosunku do katalogu głównego)';

// ADDED IN FROXLOR 0.9.12-svn4
$lng['serversettings']['awstats_awstatspath'] = 'Ścieżka do AWStats \'awstats.pl\'';

// ADDED IN FROXLOR 0.9.12-svn6
$lng['extras']['htpasswdauthname'] = 'Powodem uwierzytelniania (AuthName)';
$lng['extras']['directoryprotection_edit'] = 'edytuj ochronę katalogu';
$lng['admin']['templates']['forgotpwd'] = 'powiadomienie mailowe dla resetowania maila';
$lng['admin']['templates']['password_reset'] = 'Powiadomienie klienta dla resetowania hasła';
$lng['admin']['store_defaultindex'] = 'Zapisz domyślny plik index dla klienta w katalogu głównym';

// ADDED IN FROXLOR 0.9.14
$lng['serversettings']['mod_fcgid']['defaultini_ownvhost'] = 'Domyślna konfiguracja PHP dla Froxlor-vHost';
$lng['serversettings']['awstats_icons']['title'] = 'Ścieżka do katalogu z ikonami AWstats ';
$lng['serversettings']['awstats_icons']['description'] = 'przykład: /usr/share/awstats/htdocs/icon/';
$lng['admin']['ipsandports']['ssl_cert_chainfile']['title'] = 'Ścieżka do certyfikatu SSL CertificateChainFile';
$lng['admin']['ipsandports']['ssl_cert_chainfile']['description'] = 'Głównie CA_Bundle, lub podobny, prawdopodobnie chcesz, aby ustawić tę opcję, jeśli kupiłeś certyfikat SSL.';
$lng['admin']['ipsandports']['docroot']['title'] = 'Własny docroot (puste = wskazuje na Froxlora)';
$lng['admin']['ipsandports']['docroot']['description'] = 'Możesz zdefiniować własny dokument główny (Cel zapytania) dla tego combinacji ip/port.<br /><strong>Uwaga:</strong> Proszę uwarzać co tutaj wpisujesz!';
$lng['serversettings']['login_domain_login'] = 'Pozwól na logowanie z domenami';
$lng['panel']['unlock'] = 'Odblokuj';
$lng['question']['customer_reallyunlock'] = 'Napewno chcesz odblokować klienta %s?';

// ADDED IN FROXLOR 0.9.15
$lng['serversettings']['perl_server']['title'] = 'Lokalizacja Perl na serwerze';
$lng['serversettings']['perl_server']['description'] = 'Domyślnie jest ustawione wg przewodnika na stronie: <a target="blank" href="http://wiki.nginx.org/SimpleCGI">http://wiki.nginx.org/SimpleCGI</a>';
$lng['serversettings']['nginx_php_backend']['title'] = 'Nginx PHP backend';
$lng['serversettings']['nginx_php_backend']['description'] = 'To jest gdzie proces nasłuchuje zapytania z nginx, może być unix socket lub kombinacja ip:port <br />*nie używane z php-fpm';
$lng['serversettings']['phpreload_command']['title'] = 'Komenda na przeładowanie PHP';
$lng['serversettings']['phpreload_command']['description'] = 'Jest żywana do przeładowania backendu PHP jeśli jest używany<br />Domyślnie: Puste<br />*nie używane z php-fpm';

// ADDED IN FROXLOR 0.9.16
$lng['error']['intvaluetoolow'] = 'Podana wartość liczbowa za niska (pole %s)';
$lng['error']['intvaluetoohigh'] = 'Podana wartość liczbowa za wysoka (pole %s)';
$lng['admin']['phpfpm_settings'] = 'PHP-FPM';
$lng['serversettings']['phpfpm']['title'] = 'Włacz php-fpm';
$lng['serversettings']['phpfpm']['description'] = '<b>Opcja ta potrzebuje specjalnej konfiguracji serwera web zobacz FPM-handbook dla <a target="blank" href="http://redmine.froxlor.org/projects/froxlor/wiki/HandbookApache2_phpfpm">Apache2</a> lub <a target="blank" href="http://redmine.froxlor.org/projects/froxlor/wiki/HandbookNginx_phpfpm">nginx</a></b>';
$lng['serversettings']['phpfpm_settings']['configdir'] = 'Katalog konfiguracji dla php-fpm';
$lng['serversettings']['phpfpm_settings']['aliasconfigdir'] = 'Alias katalogu konfiguracji php-fpm';
$lng['serversettings']['phpfpm_settings']['reload'] = 'Komenda restartu  php-fpm';
$lng['serversettings']['phpfpm_settings']['pm'] = 'Zarządca procesów (pm)';
$lng['serversettings']['phpfpm_settings']['max_children']['title'] = 'Liczba procesów potomnych';
$lng['serversettings']['phpfpm_settings']['max_children']['description'] = 'Liczba procesów potomnych które zostaną utworzone w trybie\'static\' i maksymalna liczba procesów potomnych jakie mogą zostać utworzone gdy pm jest stawiona na\'dynamic/ondemand\'<br />Equivalent to the PHP_FCGI_CHILDREN';
$lng['serversettings']['phpfpm_settings']['start_servers']['title'] = 'Liczba procesów potomnych utworzonych podczas startu';
$lng['serversettings']['phpfpm_settings']['start_servers']['description'] = 'Notka: Używane gdy pm jest ustawiony na \'dynamic\'';
$lng['serversettings']['phpfpm_settings']['min_spare_servers']['title'] = 'Minimalna liczba procesów głównych tworzona podczas startu';
$lng['serversettings']['phpfpm_settings']['min_spare_servers']['description'] = 'Notka: Używane gdy pm jest ustawiony na \'dynamic\'<br />Note: Obowiązkowe gdy pm jest ustawione na \'dynamic\'';
$lng['serversettings']['phpfpm_settings']['max_spare_servers']['title'] = 'Maksymalna liczba procesów głównych';
$lng['serversettings']['phpfpm_settings']['max_spare_servers']['description'] = 'Notka: Używane gdy pm jest ustawiony na \'dynamic\'<br />Note: Obowiązkowe gdy pm jest ustawione na \'dynamic\'';
$lng['serversettings']['phpfpm_settings']['max_requests']['title'] = 'Ilość zapytań na każdy proces';
$lng['serversettings']['phpfpm_settings']['max_requests']['description'] = 'Dla nieskończonej wartości wprowadź \'0\'. Ekwiwalnetny do PHP_FCGI_MAX_REQUESTS.';
$lng['error']['phpfpmstillenabled'] = 'PHP-FPM jest obecnie aktywne. Proszę deaktywuj zanim włączony zostanie FCGID';
$lng['error']['fcgidstillenabled'] = 'FCGID jest obecnie aktywne. Proszę deaktywuj zanim włączony zostanie PHP-FPM';
$lng['phpfpm']['vhost_httpuser'] = 'Lokalny użytkownik do używania PHP-FPM (Froxlor vHost)';
$lng['phpfpm']['vhost_httpgroup'] = 'Lokalna grupa do używania PHP-FPM (Froxlor vHost)';
$lng['phpfpm']['ownvhost']['title'] = 'Włącz PHP-FPM dla Froxlor vHost';
$lng['phpfpm']['ownvhost']['description'] = 'Jeśli włączone, Froxlor froxlor będzie pracował pod lokalnym użytkownikiem';

// ADDED IN FROXLOR 0.9.17
$lng['crondesc']['cron_usage_report'] = 'Raporty web i transferu';
$lng['serversettings']['report']['report'] = 'Włącz wysyłanie raportów web oraz transferów';
$lng['serversettings']['report']['webmax'] = 'Poziom ostrzeżeń w procentach odnośnie przestrzeni web';
$lng['serversettings']['report']['trafficmax'] = 'Poziom ostrzeżeń w procentach odnośnie transferu';
$lng['mails']['trafficmaxpercent']['mailbody'] = 'Drogi {NAME},\n\n zużywasz {TRAFFICUSED} MB ze swoich {TRAFFIC} MB transferu.\nTo jest więcej niż {MAX_PERCENT}%.\n\ Proszę o kontakt,z Twoim administrator-em';
$lng['mails']['trafficmaxpercent']['subject'] = 'Osiągąłeś limit transferu';
$lng['admin']['templates']['trafficmaxpercent'] = 'Powiadomienie e-mail dla klientów , gdy podane maksymalnie procent ruchu jest wyczerpana';
$lng['admin']['templates']['MAX_PERCENT'] = 'Zastapione przez (użycie przestrzni)/transfer limit do wysłania raportu.';
$lng['admin']['templates']['USAGE_PERCENT'] = 'Zastąpiony (Przestrzeni dyskowej)/ Transferu, który został wyczerpany przez klienta w procentach.';
$lng['admin']['templates']['diskmaxpercent'] = 'Powiadomienie e-mail Dla klientów, gdy podane maksymalnie procent miejsca na dysku jest wyczerpana';
$lng['admin']['templates']['DISKAVAILABLE'] = 'Zastąpione przez zużycie dysku w MB, przydzielone do klienta.';
$lng['admin']['templates']['DISKUSED'] = 'Zastąpione przez zużycie dysku w MB, które zostały wykorzystane przez klienta.';
$lng['serversettings']['dropdown'] = 'Lista rozwijana';
$lng['serversettings']['manual'] = 'Recznie';
$lng['mails']['diskmaxpercent']['mailbody'] = 'Drogi {NAME},\n\nwykorzystjesz {DISKUSED} MB z Twojej dostępnej przestrzeni {DISKAVAILABLE} MB .\nTo jest więcej o {MAX_PERCENT}%.\n\nProsimy o kontakt z administratorem';
$lng['mails']['diskmaxpercent']['subject'] = 'Osiągnięcie limitu miejsca na dysku';
$lng['mysql']['database_edit'] = 'Edytuj bazę';

// ADDED IN FROXLOR 0.9.18
$lng['error']['domains_cantdeletedomainwithaliases'] = 'Nie można usunąć domeny, która jest wykorzystywana do aliasów domen. Musisz usunąć aliasy najpierw.';
$lng['serversettings']['default_theme'] = 'Domyślna skórka';
$lng['menue']['main']['changetheme'] = 'Zmień skórkę';
$lng['panel']['theme'] = 'Skórka';
$lng['success']['rebuildingconfigs'] = 'pomyślnie umieszczono zadanie do przebudowy zadań Cron';
$lng['panel']['variable'] = 'Zmienne';
$lng['panel']['description'] = 'Opis';
$lng['emails']['back_to_overview'] = 'Wróć do podglądu';

// ADDED IN FROXLOR 0.9.20
$lng['error']['user_banned'] = 'Twoje konto jest zablokowane. Prosimy o kontakt z administratorem w celu uzyskania dalszych informacji.';
$lng['serversettings']['validate_domain'] = 'Weryfikuj nazwy domen';
$lng['login']['combination_not_found'] = 'Kombinacja nazwy użytkownika oraz adresu email nie odnaleziona.';
$lng['customer']['generated_pwd'] = 'Sugerowane hasło';
$lng['customer']['usedmax'] = 'Użyty / Maksymalny';
$lng['admin']['traffic'] = 'Ruch';
$lng['admin']['domaintraffic'] = 'Domeny';
$lng['admin']['customertraffic'] = 'Klienci';
$lng['traffic']['customer'] = 'Klient';
$lng['traffic']['domain'] = 'Domena';
$lng['traffic']['trafficoverview'] = 'Podsumowanie ruchu wg:';
$lng['traffic']['months']['jan'] = 'Styczeń';
$lng['traffic']['months']['feb'] = 'Luty';
$lng['traffic']['months']['mar'] = 'Marzec';
$lng['traffic']['months']['apr'] = 'Kwiecień';
$lng['traffic']['months']['may'] = 'Maj';
$lng['traffic']['months']['jun'] = 'Czerwiec';
$lng['traffic']['months']['jul'] = 'Lipiec';
$lng['traffic']['months']['aug'] = 'Sierpień';
$lng['traffic']['months']['sep'] = 'Wrzesień';
$lng['traffic']['months']['oct'] = 'Październik';
$lng['traffic']['months']['nov'] = 'Listopad';
$lng['traffic']['months']['dec'] = 'Grudzień';
$lng['traffic']['months']['total'] = 'Całkowity';
$lng['traffic']['details'] = 'Szczegóły';
$lng['menue']['traffic']['table'] = 'Ruch';

// ADDED IN FROXLOR 0.9.21
$lng['gender']['title'] = 'Tytuł';
$lng['gender']['male'] = 'Pan';
$lng['gender']['female'] = 'Pani';
$lng['gender']['undef'] = '';

// Kod kraju (ISO-3166-2)
$lng['country']['AF'] = "Afganistan";
$lng['country']['AX'] = "Wyspy Alandzkie";
$lng['country']['AL'] = "Albania";
$lng['country']['DZ'] = "Algieria";
$lng['country']['AS'] = "Samoa Amerykańskie";
$lng['country']['AD'] = "Andorra";
$lng['country']['AO'] = "Angola";
$lng['country']['AI'] = "Anguilla";
$lng['country']['AQ'] = "Antarktyda";
$lng['country']['AG'] = "Antigua i Barbuda";
$lng['country']['AR'] = "Argentyna";
$lng['country']['AM'] = "Armenia";
$lng['country']['AW'] = "Aruba";
$lng['country']['AU'] = "Australia";
$lng['country']['AT'] = "Austria";
$lng['country']['AZ'] = "Azerbejdżan";
$lng['country']['PN'] = "Bahamas";
$lng['country']['BH'] = "Bahrajn";
$lng['country']['BD'] = "Bangladesz";
$lng['country']['BB'] = "Barbados";
$lng['country']['ZE'] = "Białoruś";
$lng['country']['BE'] = "Belgia";
$lng['country']['BZ'] = "Belize";
$lng['country']['BJ'] = "Benin";
$lng['country']['BM'] = "Bermuda";
$lng['country']['BT'] = "Bhutan";
$lng['country']['BO'] = "Boliwia, Wielonarodowe Państwo";
$lng['country']['BQ'] = "Bonaire, oruĹ";
$lng['country']['BA'] = "Bośnia i Hercegowina";
$lng['country']['BW'] = "Botswana";
$lng['country']['BV'] = "Wyspa Bouveta";
$lng['country']['BR'] = "Brazylia";
$lng['country']['IO'] = "Brytyjskie Terytorium Oceanu Indyjskiego";
$lng['country']['BN'] = "Brunei Darussalam";
$lng['country']['BG'] = "Bułgaria";
$lng['country']['BF'] = "Burkina Faso";
$lng['country']['BI'] = "Burundi";
$lng['country']['KH'] = "Kambodża";
$lng['country']['CM'] = "Kamerun";
$lng['country']['CA'] = "Kanada";
$lng['country']['CV'] = "Cape Verde";
$lng['country']['KY'] = "Kajmany";
$lng['country']['CF'] = "Central African Republic";
$lng['country']['TD'] = "Czad";
$lng['country']['CL'] = "Chile";
$lng['country']['CN'] = "Chiny";
$lng['country']['CN'] = "Chiny";
$lng['country']['CX'] = "Christmas Island";
$lng['country']['CC'] = "Cocos (Keeling)";
$lng['country']['CO'] = "Kolumbia";
$lng['country']['KM'] = "Komorów";
$lng['country']['CG'] = "Kongo";
$lng['country']['CD'] = "Kongo, Republika Demokratyczna";
$lng['country']['CK'] = "Wyspy Cooka";
$lng['country']['CR'] = "Kostaryka";
$lng['country']['CI'] = "Wybrzeże Kości Słoniowej";
$lng['country']['HR'] = "Chorwacja";
$lng['country']['CU'] = "Kuba";
$lng['country']['CW'] = "Curacao";
$lng['country']['CY'] = "Cypr";
$lng['country']['CZ'] = "Czechy";
$lng['country']['DK'] = "Dania";
$lng['country']['DJ'] = "Dżibuti";
$lng['country']['DM'] = "Dominika";
$lng['country']['NIE'] = "Dominikana";
$lng['country']['WE'] = "Ekwador";
$lng['country']['EG'] = "Egipt";
$lng['country']['SV'] = "Salwador";
$lng['country']['GQ'] = "Gwinea Równikowa";
$lng['country']['ER'] = "Erytrea";
$lng['country']['EE'] = "Estonia";
$lng['country']['ET'] = "Etiopia";
$lng['country']['FK'] = "Falklandy (Malwiny)";
$lng['country']['FO'] = "Wyspy Owcze";
$lng['country']['FJ'] = "Fiji";
$lng['country']['FI'] = "Finlandia";
$lng['country']['FR'] = "Francja";
$lng['country']['GF'] = "Gujana Francuska";
$lng['country']['PF'] = "Polinezja Francuska";
$lng['country']['TF'] = "Francuskie Terytoria Południowe";
$lng['country']['GA'] = "Gabon";
$lng['country']['GM'] = "Gambia";
$lng['country']['GE'] = "Georgia";
$lng['country']['de'] = "Niemcy";
$lng['country']['GH'] = "Ghana";
$lng['country']['GI'] = "Gibraltar";
$lng['country']['GR'] = "Grecja";
$lng['country']['GL'] = "Grenlandia";
$lng['country']['GD'] = "Grenada";
$lng['country']['GP'] = "Guadeloupe";
$lng['country']['GU'] = "Guam";
$lng['country']['GT'] = "Gwatemala";
$lng['country']['GG'] = "Guernsey";
$lng['country']['GN'] = "Świnka";
$lng['country']['GW'] = "Guinea-Bissau";
$lng['country']['GY'] = "Gujana";
$lng['country']['HT'] = "Haiti";
$lng['country']['HM'] = "Wyspy Heard i McDonalda";
$lng['country']['VA'] = "Stolica Apostolska (Państwo Watykańskie)";
$lng['country']['HN'] = "Honduras";
$lng['country']['HK'] = "Hong Kong";
$lng['country']['HU'] = "Węgry";
$lng['country']['TO'] = "Islandia";
$lng['country']['W'] = "Indie";
$lng['country']['id'] = "Indonezja";
$lng['country']['IR'] = "Iran, Islamska Republika";
$lng['country']['IQ'] = "Irak";
$lng['country']['IE'] = "Irlandia";
$lng['country']['IM'] = "Isle of Man";
$lng['country']['IL'] = "Izrael";
$lng['country']['IT'] = "Włochy";
$lng['country']['JM'] = "Jamajka";
$lng['country']['JP'] = "Japonia";
$lng['country']['JE'] = "Jersey";
$lng['country']['JO'] = "Jordan";
$lng['country']['KZ'] = "Kazachstan";
$lng['country']['KE'] = "Kenia";
$lng['country']['KI'] = "Kiribati";
$lng['country']['KP'] = "Koreańska Republika Ludowo-Demokratyczna";
$lng['country']['KR'] = "Republika Korei";
$lng['country']['KW'] = "Kuwejt";
$lng['country']['KG'] = "Kirgistan";
$lng['country']['LA'] = "Demokratyczna Republika Ludowo";
$lng['country']['LV'] = "Łotwa";
$lng['country']['LB'] = "Liban";
$lng['country']['LS'] = "Lesotho";
$lng['country']['LR'] = "Liberia";
$lng['country']['LY'] = "Libia";
$lng['country']['LI'] = "Liechtenstein";
$lng['country']['LT'] = "Litwa";
$lng['country']['LU'] = "Luksemburg";
$lng['country']['MO'] = "Macao";
$lng['country']['MK'] = "Macedonia, Była Jugosłowiańska Republika";
$lng['country']['MG'] = "Madagaskar";
$lng['country']['MW'] = "Malawi";
$lng['country']['MY'] = "Malezja";
$lng['country']['MV'] = "Malediwy";
$lng['country']['ML'] = "Mali";
$lng['country']['MT'] = "Malta";
$lng['country']['MH'] = "Wyspy Marshalla";
$lng['country']['MQ'] = "Martynika";
$lng['country']['MR'] = "Mauretania";
$lng['country']['MU'] = "Mauritius";
$lng['country']['YT'] = "Majotta";
$lng['country']['MX'] = "Meksyk";
$lng['country']['FM'] = "Mikronezja od";
$lng['country']['MD'] = "Mołdowa";
$lng['country']['MC'] = "Monako";
$lng['country']['MN'] = "Mongolia";
$lng['country']['JA'] = "Czarnogóra";
$lng['country']['MS'] = "Montserrat";
$lng['country']['MA'] = "Maroko";
$lng['country']['MZ'] = "Mozambik";
$lng['country']['MM'] = "Birma";
$lng['country']['NA'] = "Namibia";
$lng['country']['NR'] = "Nauru";
$lng['country']['NP'] = "Nepal";
$lng['country']['NL'] = "Holandia";
$lng['country']['NC'] = "Nowa Kaledonia";
$lng['country']['NZ'] = "Nowa Zelandia";
$lng['country']['NI'] = "Nikaragua";
$lng['country']['NE'] = "Niger";
$lng['country']['NG'] = "Nigeria";
$lng['country']['NU'] = "Niue";
$lng['country']['NF'] = "Norfolk";
$lng['country']['MP'] = "Mariany Północne";
$lng['country']['NIE'] = "Norwegia";
$lng['country']['OM'] = "Oman";
$lng['country']['PK'] = "Pakistan";
$lng['country']['PW'] = "Palau";
$lng['country']['PS'] = "Okupowane Terytorium Palestyny";
$lng['country']['PA'] = "Panama";
$lng['country']['PG'] = "Papua Nowa Gwinea";
$lng['country']['PY'] = "Paragwaj";
$lng['country']['PE'] = "Peru";
$lng['country']['PH'] = "Filipiny";
$lng['country']['PN'] = "Pitcairn";
$lng['country']['PL'] = "Polska";
$lng['country']['PT'] = "Portugalia";
$lng['country']['PR'] = "Puerto Rico";
$lng['country']['QA'] = "Katar";
$lng['country']['RE'] = "Reunion";
$lng['country']['RO'] = "Rumunia";
$lng['country']['RU'] = "Federacja Rosyjska";
$lng['country']['RW'] = "Rwanda";
$lng['country']['BL'] = "Saint Barthelemy";
$lng['country']['SH'] = "Wyspa Świętej Heleny, Wyspa Wniebowstąpienia i Tristan da Cunha";
$lng['country']['KN'] = "Saint Kitts i Nevis";
$lng['country']['LC'] = "St. Lucia";
$lng['country']['MF'] = "Saint Martin (francuska część)";
$lng['country']['AM'] = "Saint Pierre i Miquelon";
$lng['country']['VC'] = "Saint Vincent i Grenadyny";
$lng['country']['WS'] = "Samoa";
$lng['country']['SM'] = "San Marino";
$lng['country']['ST'] = "Świętego Tomasza i Książęca";
$lng['country']['SA'] = "Arabia Saudyjska";
$lng['country']['SN'] = "Senegal";
$lng['country']['RS'] = "Serbia";
$lng['country']['SC'] = "Seszele";
$lng['country']['SL'] = "Sierra Leone";
$lng['country']['SG'] = "Singapur";
$lng['country']['SX'] = "Sint Maarten (Holenderska część)";
$lng['country']['SK'] = "Słowacja";
$lng['country']['SI'] = "Słowenia";
$lng['country']['SB'] = "Wyspy Salomona";
$lng['country']['TAK'] = "Somalia";
$lng['country']['ZA'] = "Republika Południowej Afryki";
$lng['country']['GS'] = "Georgia Południowa i Sandwich Południowy";
$lng['country']['ES'] = "Hiszpania";
$lng['country']['LK'] = "Sri Lanka";
$lng['country']['SD'] = "Sudan";
$lng['country']['SR'] = "Surinam";
$lng['country']['SJ'] = "Svalbard i Jan Mayen";
$lng['country']['SZ'] = "Swaziland";
$lng['country']['SE'] = "Szwecja";
$lng['country']['CH'] = "Szwajcaria";
$lng['country']['SY'] = "Syria";
$lng['country']['TW'] = "Taiwan, Province of China";
$lng['country']['TJ'] = "Tadżykistan";
$lng['country']['TZ'] = "Tanzania, Zjednoczona Republika";
$lng['country']['TH'] = "Tajlandia";
$lng['country']['TL'] = "Timor Wschodni";
$lng['country']['TG'] = "Togo";
$lng['country']['TK'] = "Tokelau";
$lng['country']['do'] = "Tonga";
$lng['country']['TT'] = "Trynidad i Tobago";
$lng['country']['TN'] = "Tunezja";
$lng['country']['TR'] = "Turcja";
$lng['country']['TM'] = "Turkmenistan";
$lng['country']['TC'] = "Wyspy Turks i Caicos";
$lng['country']['TV'] = "Tuvalu";
$lng['country']['UG'] = "Uganda";
$lng['country']['UA'] = "Ukraina";
$lng['country']['AE'] = "Zjednoczone Emiraty Arabskie";
$lng['country']['PL'] = "Wielka Brytania";
$lng['country']['US'] = "Stany Zjednoczone";
$lng['country']['JM'] = "Stany Zjednoczone Dalekie Wyspy Mniejsze";
$lng['country']['UY'] = "Urugwaj";
$lng['country']['UZ'] = "Uzbekistan";
$lng['country']['JP'] = "Vanuatu";
$lng['country']['VE'] = "Wenezuela, Boliwariańskiej Republiki";
$lng['country']['VN'] = "Wietnam";
$lng['country']['VG'] = "Brytyjskie Wyspy Dziewicze";
$lng['country']['VI'] = "Wyspy Dziewicze, Stanów Zjednoczonych Ameryki";
$lng['country']['WF'] = "Wallis i Futuna";
$lng['country']['EH'] = "Sahara Zachodnia";
$lng['country']['YE'] = "Jemen";
$lng['country']['ZM'] = "Zambia";
$lng['country']['ZW'] = "Zimbabwe";

// ADDED IN FROXLOR 0.9.22-svn1
$lng['diskquota'] = 'Quota';
$lng['serversettings']['diskquota_enabled'] = 'Przydział dyskowy aktywny?';
$lng['serversettings']['diskquota_repquota_path']['description'] = 'Ścieżka do repquota';
$lng['serversettings']['diskquota_quotatool_path']['description'] = 'Ścieżka do quotatool';
$lng['serversettings']['diskquota_customer_partition']['description'] = 'Partycja, na którym przechowywane są pliki z klientami';
$lng['tasks']['diskspace_set_quota'] = 'Ustaw quote na systemie plików';
$lng['error']['session_timeout'] = 'Wartośc za niska';
$lng['error']['session_timeout_desc'] = 'Nie należy ustawić limit czasu sesji mniejsza niż 1 minuta.';

// ADDED IN FROXLOR 0.9.24-svn1
$lng['admin']['assignedmax'] = 'Przydział / Max';
$lng['admin']['usedmax'] = 'Użyte / Max';
$lng['admin']['used'] = 'Użyte';
$lng['mysql']['size'] = 'Rozmiar';

$lng['error']['invalidhostname'] = 'Nazwa hosta nie może być pusta ani też nie może składać się tylko z białych znaków';

$lng['traffic']['http'] = 'HTTP (MiB)';
$lng['traffic']['ftp'] = 'FTP (MiB)';
$lng['traffic']['mail'] = 'Poczta (MiB)';

// ADDED IN 0.9.27-svn1
$lng['serversettings']['mod_fcgid']['idle_timeout']['title'] = 'Limit czasu bezczynności';
$lng['serversettings']['mod_fcgid']['idle_timeout']['description'] = 'Ustawienie limitu czasu dla Mod FastCGI.';
$lng['serversettings']['phpfpm_settings']['idle_timeout']['title'] = 'Limit czasu bezczynności';
$lng['serversettings']['phpfpm_settings']['idle_timeout']['description'] = 'Ustawienie limitu czasu dla PHP5 FPM FastCGI.';

// ADDED IN 0.9.27-svn2
$lng['panel']['cancel'] = 'Anuluj';
$lng['admin']['delete_statistics'] = 'Usuń statystyki';
$lng['admin']['speciallogwarning'] = 'Ostrzeżenie: Zmieniając ustawienie to można stracić wszystkie swoje stare statystyki dla tej domeny. Jeżeli jesteś pewien, że chcesz zmienić ten typ %s w polu poniżej i kliknij przycisk "Usuń". <br /> <br/>';

// ADDED IN 0.9.28-svn2
$lng['serversettings']['vmail_maildirname']['title'] = 'Nazwa katalogu maildir';
$lng['serversettings']['vmail_maildirname']['description'] = 'Nazwa katalogu maildir konta użytkownika. Normalnie \'Maildir\', w niektórych  implementacjach \'.maildir\', i bezpośrednio w katalogu użytkownika jeśli puste.';
$lng['tasks']['remove_emailacc_files'] = 'Usuń dane klienta.';

// ADDED IN 0.9.28-svn5
$lng['error']['operationnotpermitted'] = 'Operacja nie dozwolona!';
$lng['error']['featureisdisabled'] = 'Rozszerzenie %s jest wyłączone. Proszę skontaktować się z dostawcą usług internetowych.';
$lng['serversettings']['catchall_enabled']['title']  = 'Użyj Catchall';
$lng['serversettings']['catchall_enabled']['description']  = 'Czy chcesz, aby zapewnić swoim klientom funkcje catchall?';

// ADDED IN 0.9.28.svn6
$lng['serversettings']['apache_24']['title'] = 'użyj modyfikacji dla Apache 2.4';
$lng['serversettings']['apache_24']['description'] = '<strong class = "red"> UWAGA: </ strong> używać tylko wtedy, gdy rzeczywiście posiadasz apache wersji 2.4 lub nowszej <br /> inaczej twój serwer nie będzie w stanie ruszyć';
$lng['admin']['tickets_see_all'] = 'Zobacz wszystkie kategorie zgłoszeń?';
$lng['serversettings']['nginx_fastcgiparams']['title'] = 'Ścieżka do pliku fastcgi_params';
$lng['serversettings']['nginx_fastcgiparams']['description'] = 'Określ ścieżkę pliku wraz z nazwą dla nginx dla fastcgi_params';

// Added in Froxlor 0.9.28-rc2
$lng['serversettings']['documentroot_use_default_value']['title'] = 'Użyj nazwy domeny jako wartości domyślnej dla ścieżki katalogu głownego';
$lng['serversettings']['documentroot_use_default_value']['description'] = 'Jeśli opcja jest włączona, a ścieżka DocumentRoot jest pusta, wartość domyślna będzie (pod) domeną<br /> <br /> Przykłady:. <br /> <br /> /var/customers/customer_name/example.com/ / Var /customers/customer_name/subdomain.example.com/ ';

$lng['error']['usercurrentlydeactivated'] = 'Użytkownik %s jest obecnie wyłączony';
$lng['admin']['speciallogfile']['title'] = 'Osobny plik logu';
$lng['admin']['speciallogfile']['description'] = 'Włącz aby utworzyć nowy plik access-log dla tej domeny';
$lng['error']['setlessthanalreadyused'] = 'Nie możesz przyznać mniej zasobów \'%s\' niż obecnie zużywa klient<br />';
$lng['error']['stringmustntbeempty'] = 'Wartość dla pola %s nie może być pusta';
$lng['admin']['domain_editable']['title'] = 'Pozwól na edycje domeny';
$lng['admin']['domain_editable']['desc'] = 'jeśli ustawione na tak, klient ma pozwolenie na zmianę części ustawień domeny.<br />Jeśli nie, nic nie może być zmienione przez klienta.';

// Added in Froxlor 0.9.29-dev
$lng['serversettings']['panel_phpconfigs_hidestdsubdomain']['title'] = 'Ukryj Standardowo pod domeny w konfiguracji PHP przegląd';
$lng['serversettings']['panel_phpconfigs_hidestdsubdomain']['description'] = 'Jeśli jest zaznaczone standardowe pod domeny nie będą Wyświetlane dla Klientów w przeglądzie konfiguracji<br /><br />Notka: Widoczne tylko gdy aktywne jest FCGID lub PHP-FPM';
$lng['serversettings']['passwordcryptfunc']['title'] = 'Wybierz system szyfrowania hasła';
$lng['serversettings']['systemdefault'] = 'Systemowe domyślnie';
$lng['serversettings']['panel_allow_theme_change_admin'] = 'Pozwól administratorą na zamianę skórki';
$lng['serversettings']['panel_allow_theme_change_customer'] = 'Pozwól klientą na zamianę skórki';
$lng['serversettings']['axfrservers']['title'] = 'Serwery AXFR ';
$lng['serversettings']['axfrservers']['description'] = 'Lista adresów IP oddzielona przecinkami dopuszczona do transferu stref dns (AXFR) .';
$lng['panel']['ssleditor'] = 'Ustawienia SSL dla domeny ';
$lng['admin']['ipsandports']['ssl_paste_description'] = 'Wklej cała zawarotść certyfikatu do textbox-a';
$lng['admin']['ipsandports']['ssl_cert_file_content'] = 'Zawartość certyfikatu ssl';
$lng['admin']['ipsandports']['ssl_key_file_content'] = 'Zawartość prywatnego klucza ssl';
$lng['admin']['ipsandports']['ssl_ca_file_content'] = 'Zawartość pliku CA ssl (opcjonalnie)';
$lng['admin']['ipsandports']['ssl_ca_file_content_desc'] = '<br /><br />Autoryzacja klienta, ustaw gdy wiesz co robisz.';
$lng['admin']['ipsandports']['ssl_cert_chainfile_content'] = 'Zawartość łańcucha certyfikatu(opcjonalnie)';
$lng['admin']['ipsandports']['ssl_cert_chainfile_content_desc'] = '<br /><br />Głównie CA_Bundle, lub podobny, prawdopodobnie chcesz, aby ustawić tę opcję, jeśli zakupiłeś certyfikat SSL.';
$lng['error']['sslcertificateismissingprivatekey'] = 'Musisz podać klucz prywatny do certyfikatu';
$lng['error']['sslcertificatewrongdomain'] = 'Dany certyfikat nie należy do tej domeny';
$lng['error']['sslcertificateinvalidcert'] = 'Podana treść certyfikatu nie wydaje się być ważnym certyfikatem';
$lng['error']['sslcertificateinvalidcertkeypair'] = 'Podany prywatny klucz nie należy do danego certyfikatu';
$lng['error']['sslcertificateinvalidca'] = 'Podane dane Certyfikatu CA nie wydaje się być ważnym certyfikat';
$lng['error']['sslcertificateinvalidchain'] = 'Podane dane Łańcucha certyfikatów wydaje się nie być ważny';
$lng['serversettings']['customerssl_directory']['title'] = 'Katalog serwera web dla certyfikatu ssl';
$lng['serversettings']['customerssl_directory']['description'] = 'Gdzie powinien być utworzony certyfikat dla klienta?<br /><br /><div class="red">Notka: Zawartość  Tego folderu jest regularnie usuwana, aby uniknąć przechowywania nie porządnych danych.</div>';
$lng['admin']['phpfpm.ininote'] = 'Nie wszystkie wartości, które warto zdefiniować można wykorzystać w konfiguracji puli php-fpm';

// Added in Froxlor 0.9.30
$lng['crondesc']['cron_mailboxsize'] = 'Obliczanie wielkości skrzynek pocztowych';
$lng['domains']['ipandport_multi']['title'] = 'Adres(y) IP ';
$lng['domains']['ipandport_multi']['description'] = 'Określ jeden lub więcej adresów IP dla domeny <br /> <br /> <div class = "red"> UWAGA:. Adresy IP nie można zmienić, gdy domena jest skonfigurowana jako alias <strong> domeny </ strong> kolejny domeny. </ div>';
$lng['domains']['ipandport_ssl_multi']['title'] = 'Adres(y) IP dla SSL';
$lng['domains']['ssl_redirect']['title'] = 'SSL przekierowanie';
$lng['domains']['ssl_redirect']['description'] = 'Ta opcja tworzy przekierowanie z hosta bez SSL na opcje z SSL.<br /><br />przykład: zapytanie <strong>http</strong>://domain.tld/ będzie przekierowane na<strong>https</strong>://domain.tld/';
$lng['admin']['phpinfo'] = 'PHPinfo()';
$lng['admin']['selectserveralias'] = 'Wartość aliasu Servera dla tej domeny';
$lng['admin']['selectserveralias_desc'] = 'Wybierz jeżeli froxlor powinien tworzyć wpis wildcard(*.domain.tld), alias WWW (www.domain.tld) lub nie powinien tworzyć aliasu';
$lng['domains']['serveraliasoption_wildcard'] = 'Wildcard (*.domain.tld)';
$lng['domains']['serveraliasoption_www'] = 'WWW (www.domain.tld)';
$lng['domains']['serveraliasoption_none'] = 'Brak alias';
$lng['error']['givendirnotallowed'] = 'Podany katalog w polu %s nie jest dozwolny.';
$lng['serversettings']['ssl']['ssl_cipher_list']['title'] = 'Konfiguruj dozwolne metody szyfrowania SSL';
$lng['serversettings']['ssl']['ssl_cipher_list']['description'] = 'To jest lista szyfrów które chcesz lub nie użyć przy SSL. Do listy szyfrów i jak włączyć / wyłączyć je, patrz punkt "format listy CIPHER" i "CIPHER Strings" na <a href="http://openssl.org/docs/apps/ciphers.html"> człowiek -page dla szyfrów </a> <br /> <br /> <b> domyślna wartość to:. </ b> <pre> ECDH + AESGCM: ECDH + AES256: aNULL: MD5: DSS: DH! :! AES128 </ pre>';

// Added in Froxlor 0.9.31
$lng['panel']['dashboard'] = 'Dashboard';
$lng['panel']['assigned'] = 'przydzielone';
$lng['panel']['available'] = 'dostępne';
$lng['customer']['services'] = 'Usługi';
$lng['serversettings']['phpfpm_settings']['ipcdir']['title'] = 'Katalog FastCGI IPC';
$lng['serversettings']['phpfpm_settings']['ipcdir']['description'] = 'Katalog gdzie php-fpm sockets beda zapisywane dla serwera web.<br />Katlog musi być odczytywany przez serwer web';
$lng['panel']['news'] = 'News';
$lng['error']['sslredirectonlypossiblewithsslipport'] = 'Użycie przekierowania SSL jest możliwe gdy domena posiada kombinację IP/POR';
$lng['error']['send_report_desc'] = 'Dziękujemy za raportowanie błędów pomaga nam to udoskanaleniu froxlora.<br />Ten mail będzie wysłany do develoerów:';
$lng['error']['send_report'] = 'Wyślij raport';
$lng['error']['send_report_error'] = 'Błąd podczas wysyłania raportu: <br />%s';
$lng['error']['notallowedtouseaccounts'] = 'Twoje konto nie jest dopuszczone do używania IMAP/POP3. Nie mozesz dodać kont email.';
$lng['pwdreminder']['changed'] = 'Twoje hasło ostało pomyślnie zmienione. Możesz się zalogować z nowym hasłem.';
$lng['pwdreminder']['wrongcode'] = 'Przepraszamy, Twój kod aktywacyjny wygasł.';
$lng['admin']['templates']['LINK'] = 'Zastąpione przez link do resetowania hasła.';
$lng['pwdreminder']['choosenew'] = 'Ustaw nowe hasło';
$lng['serversettings']['allow_error_report_admin']['title'] = 'Pozwól administratorą lub reselerowi na raportowanie błędów w bazie do Froxlor-a';
$lng['serversettings']['allow_error_report_admin']['description'] = 'Prosżę pamiętaj: nigdy nie wysyłaj prywatnych danych (klienta-)do Nas!';
$lng['serversettings']['allow_error_report_customer']['title'] = 'Pozwól klientą na raportowanie błędów w bazie do Froxlor-a';
$lng['serversettings']['allow_error_report_customer']['description'] = 'Proszę pamiętaj: nigdy nie wysyłaj prywatnych danych (klienta-)do Nas!';
$lng['admin']['phpsettings']['enable_slowlog'] = 'Włącz slowlog (dla domeny)';
$lng['admin']['phpsettings']['request_terminate_timeout'] = 'Time out dla zapytania';
$lng['admin']['phpsettings']['request_slowlog_timeout'] = 'Time out zapytanie dla slowlog';
$lng['admin']['templates']['SERVER_HOSTNAME'] = 'Zastępuje systemową nazwą hosta (URL do froxlora)';
$lng['admin']['templates']['SERVER_IP'] = 'Zastępuje na domyślny IP';
$lng['admin']['templates']['SERVER_PORT'] = 'Zastępuje na domyślny port';
$lng['admin']['templates']['DOMAINNAME'] = 'Zastępuje domyślną domenę klienta (może być puste aby nic nie generować)';
$lng['admin']['show_news_feed'] = 'Pokaż kanał news w stronie głównej Administratora';

// Added in Froxlor 0.9.32
$lng['logger']['reseller'] = "Reseller";
$lng['logger']['admin'] = "Administrator";
$lng['logger']['cron'] = "Zadania Cron";
$lng['logger']['login'] = "Logowanie";
$lng['logger']['intern'] = "Wewnętrzny";
$lng['logger']['unknown'] = "Nieznany";
$lng['serversettings']['mailtraffic_enabled']['title'] = "Analizuj ruch mailowy";
$lng['serversettings']['mailtraffic_enabled']['description'] = "Włącz analizę logów serwera pocztowego dla obliczenia ruchu";
$lng['serversettings']['mdaserver']['title'] = "MDA typ";
$lng['serversettings']['mdaserver']['description'] = "Typ serwera mailowego dostarczającego pocztę";
$lng['serversettings']['mdalog']['title'] = "MDA log";
$lng['serversettings']['mdalog']['description'] = "Plik log serwera mailowego dostarczającego pocztę";
$lng['serversettings']['mtaserver']['title'] = "MTA type";
$lng['serversettings']['mtaserver']['description'] = "Typ agenta transportującego pocztę";
$lng['serversettings']['mtalog']['title'] = "MTA log";
$lng['serversettings']['mtalog']['description'] = "Plik logu agenta transportującego pocztę";
$lng['panel']['ftpdesc'] = 'opis FTP';
$lng['admin']['cronsettings'] = 'Ustawienia Cronjob';
$lng['serversettings']['system_cronconfig']['title'] = 'Plik konfiguracyjny CRON';
$lng['serversettings']['system_cronconfig']['description'] = 'Ścieżka do pliku konfiguracyjnego usługi Cron. Ten plik będzie aktualizowany regularnie przez frxlor-a.<br />Notatki: Proszę<b>bądź pewny</b> że używasz tej samej nazwy w zadaniach Cron (domyślnie: /etc/cron.d/froxlor)!<br><br>Jeśli używasz FreeBSD<b>FreeBSD</b>, Proszę wpisz <i>/etc/crontab</i> tutaj!';
$lng['tasks']['remove_ftpacc_files'] = 'Usuń dane konta ftp klienta.';
$lng['tasks']['regenerating_crond'] = 'Przebuduj plik cron.d';
$lng['serversettings']['system_crondreload']['title'] = 'Polecenie przeładowania demona Cron';
$lng['serversettings']['system_crondreload']['description'] = 'Określić polecenie wykonywane, aby przeładować systemów demonów cron';
$lng['admin']['integritycheck'] = 'Weryfikacja bazy danych';
$lng['admin']['integrityid'] = '#';
$lng['admin']['integrityname'] = 'Nazwa';
$lng['admin']['integrityresult'] = 'Wynik';
$lng['admin']['integrityfix'] = 'Napraw problemy automatycznie';
$lng['question']['admin_integritycheck_reallyfix'] = 'Czy napewno chcesz aby problemy z integralnością bazy były naprawiane automatycznie?';
$lng['serversettings']['system_croncmdline']['title'] = 'Polecenie wykonywania Crond (php-binary)';
$lng['serversettings']['system_croncmdline']['description'] = 'Polecenie do wykonania zadań Cron. Zmień tylko wtedy gdy wiesz co robisz (domyślnie: "/usr/bin/nice -n 5 /usr/bin/php5 -q")!';
$lng['error']['cannotdeletehostnamephpconfig'] = 'Ta konfiguracja PHP jest używana przez Froxlor-vhost nie może być usunięta.';
$lng['error']['cannotdeletedefaultphpconfig'] = 'Ta konfiguracja PHP jest ustawiona jako domyślna nie może być usunięta.';
$lng['serversettings']['system_cron_allowautoupdate']['title'] = 'Pozwól na automatyczne uaktualnianie bazy';
$lng['serversettings']['system_cron_allowautoupdate']['description'] = '<div class="red"><b>ostrzeżenie:</b></div> To ustawienie umożliwia cronjob ominąć sprawdzanie wersji plików froxlor-a i bazy danych i uruchamia aktualizacje bazy danych w przypadku niedopasowania wersji. <br> <Div class = "red"> Automatyczna aktualizacja będzie zawsze ustawiona domyślne dla nowych ustawień lub zmian. Nie zawsze może być korzystne dla systemu. Proszę pomyśleć dwa razy przed uruchomieniem tej opcji </ div>';
$lng['error']['passwordshouldnotbeusername'] = 'Hasło nie może być takie same jak nazwa użytkownika.';

// Added in Froxlor 0.9.33
$lng['admin']['customer_show_news_feed'] = "Pokaż domyślnie newsfeed na tablicy klienta";
$lng['admin']['customer_news_feed_url'] = "RSS-Feed dla własnego newsfeed";
$lng['serversettings']['dns_createhostnameentry'] = "Utwórz konfigurację strefy bind dla systemowej nazwy hosta";
$lng['serversettings']['panel_password_alpha_lower']['title'] = 'małe znaki';
$lng['serversettings']['panel_password_alpha_lower']['description'] = 'Hasło musi zawierać przynajmniej 1 mały znak(a-z).';
$lng['serversettings']['panel_password_alpha_upper']['title'] = 'Duże znaki';
$lng['serversettings']['panel_password_alpha_upper']['description'] = 'Hasło musi zawierać przynajmniej 1 duży znak(A-Z).';
$lng['serversettings']['panel_password_numeric']['title'] = 'Liczby';
$lng['serversettings']['panel_password_numeric']['description'] = 'Hasło musi zawierać przynajmniej 1 liczbę (0-9).';
$lng['serversettings']['panel_password_special_char_required']['title'] = 'Znaki specjalne';
$lng['serversettings']['panel_password_special_char_required']['description'] = 'Hasło musi zawierać przynajmniej 1 znak specjalny z poniższej listy.';
$lng['serversettings']['panel_password_special_char']['title'] = 'Lista znaków specjalnych';
$lng['serversettings']['panel_password_special_char']['description'] = '1 z Tych znaków jest wymagany jeśli powyższa opcja jest włączona.';
$lng['phpfpm']['use_mod_proxy']['title'] = 'Użyj mod_proxy / mod_proxy_fcgi';
$lng['phpfpm']['use_mod_proxy']['description'] = 'Aktywuj aby użyć php-fpm poprzez mod_proxy_fcgi. wymaga apache-2.4.9';
$lng['error']['no_phpinfo'] = 'Przepraszamy, nie możemy odczytać phpinfo()';

$lng['admin']['movetoadmin'] = 'Przenieś klienta';
$lng['admin']['movecustomertoadmin'] = 'Przenieś klienta do zaznaczonego admin/reseller<br /><small>Pozostaw puste aby nie dokonać zmian.<br />Jeśli żądany admin nie pojawi się na liście, jego limit klientów został wykorzystany.</small>';
$lng['error']['moveofcustomerfailed'] = 'Przeniesienie klienta do zaznaczonego admin/reseller ie powiodło się. Należy pamiętać, że wszystkie inne zmiany zostały zastosowane klienta na tym etapie z powodzeniem <br> Komunikat błędu: %s . ';

$lng['domains']['domain_import'] = 'Importuj domeny';
$lng['domains']['import_separator'] = 'Separator';
$lng['domains']['import_offset'] = 'Zakończenie';
$lng['domains']['import_file'] = 'Plik CSV';
$lng['success']['domain_import_successfully'] = 'Pomyślnie zaimportowano %s domen.';
$lng['error']['domain_import_error'] = 'Wystąpił następujący problem podczas importu domen: %s';
$lng['admin']['note'] = 'Notka';
$lng['domains']['import_description'] = 'Szczegółowe informacje na temat struktury import pliku i jak zaimportować, odwiedź <a href="http://redmine.froxlor.org/projects/froxlor/wiki/DomainBulkActionDoc" target="_blank"> http: / /redmine.froxlor.org/projects/froxlor/wiki/DomainBulkActionDoc </a>';
$lng['usersettings']['custom_notes']['title'] = 'Własne notatki';
$lng['usersettings']['custom_notes']['description'] = 'Śmiało umieszczaj notatki jakie chcesz/potrzebujesz tutaj. Będą one wyświetlane w przeglądzie admin / klienta do odpowiedniego użytkownika.';
$lng['usersettings']['custom_notes']['show'] = 'Pokaż notatki na stronie startowej użytkownika';
$lng['serversettings']['system_send_cron_errors']['title'] = 'Wyślij błędy crona ';
$lng['serversettings']['system_send_cron_errors']['description'] = 'Wybierz, czy chcesz otrzymywać wiadomości e-mail od błędów zadań Cron. Należy pamiętać, że może to prowadzić do wiadomości e-mail są wysyłane co 5 minut w zależności od błędu i ustawień cronjob.';
$lng['error']['fcgidandphpfpmnogoodtogether'] = 'FCGID i PHP-FPM nie mogą być aktywowane w tym samym czasie';

// Added in Froxlor 0.9.34
$lng['admin']['configfiles']['legend'] = 'Jesteś na temat konfigurowania usług / demona. Poniższa legenda wyjaśnia nomenklatury.';
$lng['admin']['configfiles']['commands'] = '<span class = "red"> polecenia: </ span> Polecenia te mają być wykonywane wiersz po wierszu, jako głównego użytkownika w powłoce. Jest to bezpieczne, aby skopiować cały blok i wklej go do powłoki';
$lng['admin']['configfiles']['files'] = '<span class = "red"> Pliki konfiguracyjne: </ span> To jest przykład zawartości pliku konfiguracyjnego. Poleceniem z przed tych pól tekstowych należy otworzyć edytor pliku docelowego. Wystarczy skopiować i wkleić zawartość do edytora i zapisz plik <br> <span class = "red"> Uwaga:. </ Span> MySQL hasło nie zostało zastąpione ze względów bezpieczeństwa. Proszę wymienić "MYSQL_PASSWORD" na własną rękę. Jeśli zapomniałeś hasło, MySQL znajdziesz je w "lib / userdata.inc.php"';
$lng['serversettings']['apache_itksupport']['title'] = 'Użyj modyfikacji dla Apache ITK-MPM';
$lng['serversettings']['apache_itksupport']['description'] = '<strong class = "red"> UWAGA: </ strong> używać tylko wtedy, gdy rzeczywiście apache ITK-MPM aktywowany <br /> inaczej twój serwer nie będzie w stanie rozpocząć działania';
$lng['integrity_check']['DatabaseCharset'] = 'Kodowanie bazy danych (powinno być UTF-8)';
$lng['integrity_check']['DomainIpTable'] = 'IP &lt;&dash;&gt; referencje domeny';
$lng['integrity_check']['SubdomainSslRedirect'] = 'Błędne przekierowanie do SSL dla domen bez SSL ';
$lng['integrity_check']['FroxlorLocalGroupMemberForFcgidPhpFpm'] = 'Użytkonik froxlor w grupie klientów (for FCGID/php-fpm)';
$lng['integrity_check']['WebserverGroupMemberForFcgidPhpFpm'] = 'Użytkownik Serwer web w grupie klientów (for FCGID/php-fpm)';
$lng['admin']['specialsettings_replacements'] = "Możesz użyć następujących zmiennych: <br/> <code> {DOMAIN} </ code>, <code> {docroot} </ code>, <code> {CUSTOMER} </ code>, <code> {IP} </ code>, <code> {PORT} </ code>, <code> {SCHEME} </ code> <br/>";
$lng['serversettings']['default_vhostconf']['description'] = 'Treść tego pola zostanie włączona do kontenera vHost ip/port. ';
$lng['admin']['specialsettings_replacements'] = ' Uwaga: Kod nie jest sprawdzany pod kątem jakiekolwiek błędów. Jeśli zawiera błędy, serwer WWW może się nie uruchomić ponownie!';
$lng['serversettings']['default_vhostconf_domain']['description'] = 'Treść tego pola zostanie włączona do kontenera vhosta z domeną. ';
$lng['admin']['specialsettings_replacements'].' Uwaga: Kod nie jest sprawdzany pod kątem jakiekolwiek błędów. Jeśli zawiera błędy, serwer WWW może się nie uruchomić ponownie!';
$lng['admin']['mod_fcgid_umask']['title'] = 'Umask (Domyśnie: 022)';
