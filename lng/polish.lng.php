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

$lng['translator'] = 'translator';
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
$lng['changepassword']['also_change_ftp'] = ' również zmienia hasło do głównego konta FTP';

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

$lng['serversettings']['mailpwcleartext']['title'] = 'Also save passwords of mail accounts unencrypted in database';
$lng['serversettings']['mailpwcleartext']['description'] = 'If this is set to yes, all passwords will also be saved unencrypted (clear text, plain readable for everyone with database access) in the mail_users-table. Only activate this if you intend to use SASL!';
$lng['serversettings']['mailpwcleartext']['removelink'] = 'Click here to wipe all unencrypted passwords from the table.';
$lng['question']['admin_cleartextmailpws_reallywipe'] = 'Do you really want to wipe all unencrypted mail account passwords from the table mail_users? This cannot be reverted!';
$lng['admin']['configfiles']['overview'] = 'Overview';
$lng['admin']['configfiles']['wizard'] = 'Wizard';
$lng['admin']['configfiles']['distribution'] = 'Distribution';
$lng['admin']['configfiles']['service'] = 'Service';
$lng['admin']['configfiles']['daemon'] = 'Daemon';
$lng['admin']['configfiles']['http'] = 'Webserver (HTTP)';
$lng['admin']['configfiles']['dns'] = 'Nameserver (DNS)';
$lng['admin']['configfiles']['mail'] = 'Mailserver (IMAP/POP3)';
$lng['admin']['configfiles']['smtp'] = 'Mailserver (SMTP)';
$lng['admin']['configfiles']['ftp'] = 'FTP-server';
$lng['admin']['configfiles']['etc'] = 'Others (System)';
$lng['admin']['configfiles']['choosedistribution'] = '-- Choose a distribution --';
$lng['admin']['configfiles']['chooseservice'] = '-- Choose a service --';
$lng['admin']['configfiles']['choosedaemon'] = '-- Choose a daemon --';

// ADDED IN 1.2.16-svn10

$lng['serversettings']['ftpdomain']['title'] = 'FTP accounts @domain';
$lng['serversettings']['ftpdomain']['description'] = 'Customers can create FTP accounts user@customerdomain?';
$lng['panel']['back'] = 'Back';

// ADDED IN 1.2.16-svn12

$lng['serversettings']['mod_fcgid']['title'] = 'Enable FCGID';
$lng['serversettings']['mod_fcgid']['description'] = 'Use this to run PHP with the corresponding useraccount.<br /><br /><b>This needs a special webserver configuration for Apache, see <a target="blank" href="http://redmine.froxlor.org/projects/froxlor/wiki/HandbookApache2_fcgid">FCGID - handbook</a></b>';
$lng['serversettings']['sendalternativemail']['title'] = 'Use alternative email-address';
$lng['serversettings']['sendalternativemail']['description'] = 'Send the password-email to a different address during email-account-creation';
$lng['emails']['alternative_emailaddress'] = 'Alternative e-mail-address';
$lng['mails']['pop_success_alternative']['mailbody'] = 'Hello,\n\nyour Mail account {EMAIL}\nwas set up successfully.\nYour password is {PASSWORD}.\n\nThis is an automatically created\ne-mail, please do not answer!\n\nYours sincerely, your administrator';
$lng['mails']['pop_success_alternative']['subject'] = 'Mail account set up successfully';
$lng['admin']['templates']['pop_success_alternative'] = 'Welcome mail for new email accounts sent to alternative address';
$lng['admin']['templates']['EMAIL_PASSWORD'] = 'Replaced with the POP3/IMAP account password.';

// ADDED IN 1.2.16-svn13

$lng['error']['documentrootexists'] = 'The directory "%s" already exists for this customer. Please remove this before adding the customer again.';

// ADDED IN 1.2.16-svn14

$lng['serversettings']['apacheconf_vhost']['title'] = 'Webserver vHost configuration file/dirname';
$lng['serversettings']['apacheconf_vhost']['description'] = 'Where should the vHost configuration be stored? You could either specify a file (all vHosts in one file) or directory (each vHost in his own file) here.';
$lng['serversettings']['apacheconf_diroptions']['title'] = 'Webserver diroptions configuration file/dirname';
$lng['serversettings']['apacheconf_diroptions']['description'] = 'Where should the diroptions configuration be stored? You could either specify a file (all diroptions in one file) or directory (each diroption in his own file) here.';
$lng['serversettings']['apacheconf_htpasswddir']['title'] = 'Webserver htpasswd dirname';
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

$lng['admin']['webalizersettings'] = 'Webalizer settings';
$lng['admin']['webalizer']['normal'] = 'Normal';
$lng['admin']['webalizer']['quiet'] = 'Quiet';
$lng['admin']['webalizer']['veryquiet'] = 'No output';
$lng['serversettings']['webalizer_quiet']['title'] = 'Webalizer output';
$lng['serversettings']['webalizer_quiet']['description'] = 'Verbosity of the webalizer-program';

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
$lng['ticket']['notmorethanxopentickets'] = 'Due to spam-protection you cannot have more than %s open tickets';
$lng['ticket']['supportstatus'] = 'Support-Status';
$lng['ticket']['supportavailable'] = '<span class="ticket_low">Our support engineers are available and ready to assist.</span>';
$lng['ticket']['supportnotavailable'] = '<span class="ticket_high">Our support engineers are currently not available</span>';
$lng['admin']['templates']['ticket'] = 'Notification-mails for support-tickets';
$lng['admin']['templates']['SUBJECT'] = 'Replaced with the support-ticket subject';
$lng['admin']['templates']['new_ticket_for_customer'] = 'Customer-information that the ticket has been sent';
$lng['admin']['templates']['new_ticket_by_customer'] = 'Admin-notification for a ticket opened by a customer';
$lng['admin']['templates']['new_reply_ticket_by_customer'] = 'Admin-notification for a ticket-reply by a customer';
$lng['admin']['templates']['new_ticket_by_staff'] = 'Customer-notification for a ticket opened by a staff';
$lng['admin']['templates']['new_reply_ticket_by_staff'] = 'Customer-notification for a ticket-reply by a staff';
$lng['mails']['new_ticket_for_customer']['mailbody'] = 'Hello {FIRSTNAME} {NAME},\n\nyour support-ticket with the subject "{SUBJECT}" has been sent.\n\nYou will be notified when your ticket has been answered.\n\nThank you,\nyour administrator';
$lng['mails']['new_ticket_for_customer']['subject'] = 'Your support ticket has been sent';
$lng['mails']['new_ticket_by_customer']['mailbody'] = 'Hello admin,\n\na new support-ticket with the subject "{SUBJECT}" has been submitted.\n\nPlease login to open the ticket.\n\nThank you,\nyour administrator';
$lng['mails']['new_ticket_by_customer']['subject'] = 'New support ticket submitted';
$lng['mails']['new_reply_ticket_by_customer']['mailbody'] = 'Hello admin,\n\nthe support-ticket "{SUBJECT}" has been answered by a customer.\n\nPlease login to open the ticket.\n\nThank you,\nyour administrator';
$lng['mails']['new_reply_ticket_by_customer']['subject'] = 'New reply to support ticket';
$lng['mails']['new_ticket_by_staff']['mailbody'] = 'Hello {FIRSTNAME} {NAME},\n\na support-ticket with the subject "{SUBJECT}" has been opened for you.\n\nPlease login to open the ticket.\n\nThank you,\nyour administrator';
$lng['mails']['new_ticket_by_staff']['subject'] = 'New support ticket submitted';
$lng['mails']['new_reply_ticket_by_staff']['mailbody'] = 'Hello {FIRSTNAME} {NAME},\n\nthe support-ticket with the subject "{SUBJECT}" has been answered by our staff.\n\nPlease login to view the ticket.\n\nThank you,\nyour administrator';
$lng['mails']['new_reply_ticket_by_staff']['subject'] = 'New reply to support ticket';
$lng['question']['ticket_reallyclose'] = 'Do you really want to close the ticket "%s"?';
$lng['question']['ticket_reallydelete'] = 'Do you really want to delete the ticket "%s"?';
$lng['question']['ticket_reallydeletecat'] = 'Do you really want to delete the category "%s"?';
$lng['question']['ticket_reallyarchive'] = 'Do you really want to move the ticket "%s" to the archive?';
$lng['error']['nomoreticketsavailable'] = 'You have used all your available tickets. Please contact your administrator.';
$lng['error']['nocustomerforticket'] = 'Cannot create tickets without customers';
$lng['error']['categoryhastickets'] = 'The category still has tickets in it.<br />Please delete the tickets to delete the category';
$lng['admin']['ticketsettings'] = 'Support-Ticket settings';
$lng['admin']['archivelastrun'] = 'Last ticket archiving';
$lng['serversettings']['ticket']['noreply_email']['title'] = 'No-reply e-mail address';
$lng['serversettings']['ticket']['noreply_email']['description'] = 'The sender-address for support-ticket, mostly something like no-reply@domain.tld';
$lng['serversettings']['ticket']['worktime_begin']['title'] = 'Begin support-time (hh:mm)';
$lng['serversettings']['ticket']['worktime_begin']['description'] = 'Start-time when support is available';
$lng['serversettings']['ticket']['worktime_end']['title'] = 'End support-time (hh:mm)';
$lng['serversettings']['ticket']['worktime_end']['description'] = 'End-time when support is available';
$lng['serversettings']['ticket']['worktime_sat'] = 'Support available on saturdays?';
$lng['serversettings']['ticket']['worktime_sun'] = 'Support available on sundays?';
$lng['serversettings']['ticket']['worktime_all']['title'] = 'No time limit for support';
$lng['serversettings']['ticket']['worktime_all']['description'] = 'If "Yes" the options for start- and endtime will be overwritten';
$lng['serversettings']['ticket']['archiving_days'] = 'After how many days should closed tickets be archived?';
$lng['customer']['tickets'] = 'Support-tickets';

// ADDED IN 1.2.18-svn4

$lng['admin']['domain_nocustomeraddingavailable'] = 'It\'s not possible to add a domain currently. You first need to add at least one customer.';
$lng['serversettings']['ticket']['enable'] = 'Enable ticketsystem';
$lng['serversettings']['ticket']['concurrentlyopen'] = 'How many tickets shall be able to be opened at one time?';
$lng['error']['norepymailiswrong'] = 'The "Noreply-address" jest zły. Only a valid email-address są dozwolone.';
$lng['error']['tadminmailiswrong'] = 'The "Ticketadmin-address" jest zły. Only a valid email-address są dozwolone.';
$lng['ticket']['awaitingticketreply'] = 'You have %s unanswered support-ticket(s)';

// ADDED IN 1.2.18-svn5

$lng['serversettings']['ticket']['noreply_name'] = 'Ticket e-mail sendername';

// ADDED IN 1.2.19-svn1

$lng['serversettings']['mod_fcgid']['configdir']['title'] = 'Configuration directory';
$lng['serversettings']['mod_fcgid']['configdir']['description'] = 'Where should all fcgid-configuration files be stored? If you don\'t use a self compiled suexec binary, which is the normal situation, this path must be under /var/www/<br /><br /><div class="red">NOTE: This folder\'s content gets deleted regulary so avoid storing data in there manually.</div>';
$lng['serversettings']['mod_fcgid']['tmpdir']['title'] = 'Temp directory';

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

$lng['serversettings']['ssl']['use_ssl']['title'] = 'Enable SSL usage';
$lng['serversettings']['ssl']['use_ssl']['description'] = 'Check this if you want to use SSL for your webserver';
$lng['serversettings']['ssl']['ssl_cert_file']['title'] = 'Path to the SSL certificate';
$lng['serversettings']['ssl']['ssl_cert_file']['description'] = 'Specify the path including the filename of the .crt or .pem file (main certificate)';
$lng['serversettings']['ssl']['openssl_cnf'] = 'Defaults for creating the Cert file';
$lng['panel']['reseller'] = 'reseller';
$lng['panel']['admin'] = 'admin';
$lng['panel']['customer'] = 'customer/s';
$lng['error']['nomessagetosend'] = 'You did not enter a message.';
$lng['error']['noreceipientsgiven'] = 'You did not specify any receipient';
$lng['admin']['emaildomain'] = 'Emaildomain';
$lng['admin']['email_only'] = 'Only email?';
$lng['admin']['wwwserveralias'] = 'Add a "www." ServerAlias';
$lng['admin']['ipsandports']['enable_ssl'] = 'Is this an SSL Port?';
$lng['admin']['ipsandports']['ssl_cert_file'] = 'Path to the SSL Certificate';
$lng['panel']['send'] = 'send';
$lng['admin']['subject'] = 'Subject';
$lng['admin']['receipient'] = 'Recipient';
$lng['admin']['message'] = 'Write a Message';
$lng['admin']['text'] = 'Message';
$lng['menu']['message'] = 'Messages';
$lng['error']['errorsendingmail'] = 'The message to "%s" failed';
$lng['error']['cannotreaddir'] = 'Unable to read directory "%s"';
$lng['message']['success'] = 'Successfully sent message to %s recipients';
$lng['message']['noreceipients'] = 'No e-mail has been sent because there are no recipients in the database';
$lng['admin']['sslsettings'] = 'SSL settings';
$lng['cronjobs']['notyetrun'] = 'Not yet run';
$lng['serversettings']['default_vhostconf']['title'] = 'Default vHost-settings';
$lng['serversettings']['default_vhostconf']['description'] = 'The content of this field will be included into this ip/port vHost container directly. Attention: The code won\'t be checked for any errors. If it contains errors, webserver might not start again!';
$lng['serversettings']['default_vhostconf_domain']['description'] = 'The content of this field will be included into the domain vHost container directly. Attention: The code won\'t be checked for any errors. If it contains errors, webserver might not start again!';
$lng['error']['invalidip'] = 'Invalid IP address: %s';
$lng['serversettings']['decimal_places'] = 'Number of decimal places in traffic/webspace output';

// ADDED IN 1.2.19-svn8

$lng['admin']['dkimsettings'] = 'DomainKey settings';
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

$lng['admin']['allips'] = 'All IP\'s';
$lng['panel']['nosslipsavailable'] = 'There are currently no ssl ip/port combinations for this server';
$lng['ticket']['by'] = 'by';
$lng['dkim']['use_dkim']['title'] = 'Activate DKIM support?';
$lng['dkim']['use_dkim']['description'] = 'Would you like to use the Domain Keys (DKIM) system?<br/><em class="red">Note: DKIM is only supported using dkim-filter, not opendkim (yet)</em>';
$lng['error']['invalidmysqlhost'] = 'Invalid MySQL host address: %s';
$lng['error']['cannotuseawstatsandwebalizeratonetime'] = 'You cannot enable Webalizer and AWstats at the same time, please chose one of them';
$lng['serversettings']['webalizer_enabled'] = 'Enable webalizer statistics';
$lng['serversettings']['awstats_enabled'] = 'Enable AWstats statistics';
$lng['admin']['awstatssettings'] = 'AWstats settings';

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

$lng['serversettings']['allow_password_reset']['description'] = 'Customers can reset their password and an activation link will be sent to their e-mail address';
$lng['serversettings']['allow_password_reset_admin']['title'] = 'Allow password reset by admins';
$lng['serversettings']['allow_password_reset_admin']['description'] = 'Admins/reseller can reset their password and an activation link will be sent to their e-mail address';

// ADDED IN 1.2.19-svn25

$lng['emails']['quota'] = 'Przydział przestrzeni';
$lng['emails']['noquota'] = 'Brak przydziału przestrzeni';
$lng['emails']['updatequota'] = 'Uaktualnij użycie przestrzeni';
$lng['serversettings']['mail_quota']['title'] = 'Użycie przestrzeni skrzynki pocztowej';
$lng['serversettings']['mail_quota']['description'] = 'Domyślna przestrzeń dyskowa dla nowych skrzynek pocztowych (MB).';
$lng['serversettings']['mail_quota_enabled']['title'] = 'Użyj przestrzeni dyskowej dla skrzynek klientów';
$lng['serversettings']['mail_quota_enabled']['description'] = 'Aktywuj używanie przestrzeni dyskowej w skrzynkach pocztowych. Domyślnie <b>Nie</b> wymaga dodatkowej konfiguracji.';
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
$lng['error']['allocatetoomuchquota'] = 'You tried to allocate %s MB Quota, but you do not have enough left.';

$lng['error']['missingfields'] = 'Not all required fields were filled out.';
$lng['error']['accountnotexisting'] = 'The given email account doesn\'t exist.';
$lng['admin']['security_settings'] = 'Security Options';
$lng['admin']['know_what_youre_doing'] = 'Change only, if you know what you\'re doing!';
$lng['admin']['show_version_login']['title'] = 'Show Froxlor version on login';
$lng['admin']['show_version_login']['description'] = 'Show the Froxlor version in the footer on the login page';
$lng['admin']['show_version_footer']['title'] = 'Show Froxlor version in footer';
$lng['admin']['show_version_footer']['description'] = 'Show the Froxlor version in the footer on the rest of the pages';
$lng['admin']['froxlor_graphic']['title'] = 'Header graphic for Froxlor';
$lng['admin']['froxlor_graphic']['description'] = 'What graphic should be shown in the header';

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
$lng['admin']['phpconfig']['template_replace_vars'] = 'Zmiene które są zastępowane w ustawieniach konfiguracyjnych';
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
$lng['login']['backtologin'] = 'Back to login';
$lng['serversettings']['mod_fcgid']['starter']['title'] = 'Processes per domain';
$lng['serversettings']['mod_fcgid']['starter']['description'] = 'How many processes should be started/allowed per domain? The value 0 is recommended cause PHP will then manage the amount of processes itself very efficiently.';
$lng['serversettings']['mod_fcgid']['wrapper']['title'] = 'Wrapper in Vhosts';
$lng['serversettings']['mod_fcgid']['wrapper']['description'] = 'How should the wrapper be included in the Vhosts';
$lng['serversettings']['mod_fcgid']['tmpdir']['description'] = 'Where should the temp directories be stored';
$lng['serversettings']['mod_fcgid']['peardir']['title'] = 'Global PEAR directories';
$lng['serversettings']['mod_fcgid']['peardir']['description'] = 'Which global PEAR directories should be replaced in every php.ini config? Different directories must be separated by a colon.';

//improved Froxlor  2

$lng['admin']['templates']['index_html'] = 'index file for newly created customer directories';
$lng['admin']['templates']['SERVERNAME'] = 'Replaced with the servername.';
$lng['admin']['templates']['CUSTOMER'] = 'Replaced with the loginname of the customer.';
$lng['admin']['templates']['ADMIN'] = 'Replaced with the loginname of the admin.';
$lng['admin']['templates']['CUSTOMER_EMAIL'] = 'Replaced with the e-mail address of the customer.';
$lng['admin']['templates']['ADMIN_EMAIL'] = 'Replaced with the e-mail address of the admin.';
$lng['admin']['templates']['filetemplates'] = 'File templates';
$lng['admin']['templates']['filecontent'] = 'File content';
$lng['error']['filecontentnotset'] = 'The file cannot be empty!';
$lng['serversettings']['index_file_extension']['description'] = 'Which file extension should be used for the index file in newly created customer directories? This file extension will be used, if you or one of your admins has created its own index file template.';
$lng['serversettings']['index_file_extension']['title'] = 'File extension for index file in newly created customer directories';
$lng['error']['index_file_extension'] = 'The file extension for the index file must be between 1 and 6 characters long. The extension can only contain characters like a-z, A-Z and 0-9';
$lng['admin']['expert_settings'] = 'Expert settings!';
$lng['admin']['mod_fcgid_starter']['title'] = 'PHP Processes for this domain (empty for default value)';

$lng['error']['customerdoesntexist'] = 'The customer you have chosen doesn\'t exist.';
$lng['error']['admindoesntexist'] = 'The admin you have chosen doesn\'t exist.';

// ADDED IN 1.2.19-svn37

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
$lng['admin']['phpsettings']['binary'] = 'Plik binarny PHP ';
$lng['admin']['phpsettings']['file_extensions'] = 'Rozszerzenia plików';
$lng['admin']['phpsettings']['file_extensions_note'] = '(bez kropki, odseparowane spacją)';
$lng['admin']['mod_fcgid_maxrequests']['title'] = 'Maksymalna liczba zapytań do PHP dla tej domeny (Puste wartość domyślna)';
$lng['serversettings']['mod_fcgid']['maxrequests']['title'] = 'Maksymalna ilość zapytań';
$lng['serversettings']['mod_fcgid']['maxrequests']['description'] = 'Ile zapytań powinno być dozwolne dla tej domeny?';

// ADDED IN 1.4.2.1-1

$lng['mysql']['mysql_server'] = 'Serwer MySQL';

// ADDED IN 1.4.2.1-2

$lng['admin']['ipsandports']['webserverdefaultconfig'] = 'Webserver default config';
$lng['admin']['ipsandports']['webserverdomainconfig'] = 'Webserver domain config';
$lng['admin']['ipsandports']['webserverssldomainconfig'] = 'Webserver SSL config';
$lng['admin']['ipsandports']['ssl_key_file'] = 'Path to the SSL Keyfile';
$lng['admin']['ipsandports']['ssl_ca_file'] = 'Path to the SSL CA certificate';
$lng['admin']['ipsandports']['default_vhostconf_domain'] = 'Default vHost-settings for every domain container';
$lng['serversettings']['ssl']['ssl_key_file']['title'] = 'Path to the SSL Keyfile';
$lng['serversettings']['ssl']['ssl_key_file']['description'] = 'Specify the path including the filename for the private-key file (.key mostly)';
$lng['serversettings']['ssl']['ssl_ca_file']['title'] = 'Path to the SSL CA certificate (optional)';
$lng['serversettings']['ssl']['ssl_ca_file']['description'] = 'Client authentification, set this only if you know what it is.';

$lng['error']['usernamealreadyexists'] = 'The username %s already exists.';

$lng['error']['plausibilitychecknotunderstood'] = 'Answer of plausibility check not understood.';
$lng['error']['errorwhensaving'] = 'An error occurred when saving the field %s';

$lng['success']['success'] = 'Information';
$lng['success']['clickheretocontinue'] = 'Click here to continue';
$lng['success']['settingssaved'] = 'The settings have been successfully saved.';

// ADDED IN FROXLOR 0.9

$lng['admin']['spfsettings'] = 'Domain SPF settings';
$lng['spf']['use_spf'] = 'Activate SPF for domains?';
$lng['spf']['spf_entry'] = 'SPF entry for all domains';
$lng['panel']['toomanydirs'] = 'Too many subdirectories. Falling back to manual path-select.';
$lng['panel']['abort'] = 'Abort';
$lng['serversettings']['cron']['debug']['title'] = 'Cronscript debugging';
$lng['serversettings']['cron']['debug']['description'] = 'Activate to keep the lockfile after a cron-run for debugging.<br /><b>Attention:</b>Keeping the lockfile can cause the next scheduled cron not to run properly.';
$lng['panel']['not_activated'] = 'not activated';
$lng['panel']['off'] = 'off';
$lng['update']['updateinprogress_onlyadmincanlogin'] = 'A newer version of Froxlor has been installed but not yet set up.<br />Only the administrator can log in and finish the update.';
$lng['update']['update'] = 'Froxlor update';
$lng['update']['proceed'] = 'Proceed';
$lng['update']['update_information']['part_a'] = 'The Froxlor files have been updated to version <strong>%newversion</strong>. The installed version is <strong>%curversion</strong>.';
$lng['update']['update_information']['part_b'] = '<br /><br />Customers will not be able to log in until the update has been finished.<br /><strong>Proceed?</strong>';
$lng['update']['noupdatesavail'] = '<strong>You already have the latest Froxlor version.</strong>';
$lng['admin']['specialsettingsforsubdomains'] = 'Apply specialsettings to all subdomains (*.example.com)';
$lng['serversettings']['specialsettingsforsubdomains']['description'] = 'If yes these custom vHost-settings will be added to all subdomains; if no subdomain-specialsettings are being removed.';
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

// ADDED IN FROXLOR 0.9.3-svn1

$lng['serversettings']['panel_password_min_length']['title'] = 'Minimum password length';
$lng['serversettings']['panel_password_min_length']['description'] = 'Here you can set a minimum length for passwords. \'0\' means: no minimum length required.';
$lng['error']['notrequiredpasswordlength'] = 'The given password is too short. Please enter at least %s characters.';
$lng['serversettings']['system_store_index_file_subs']['title'] = 'Store default index file also to new subfolders';
$lng['serversettings']['system_store_index_file_subs']['description'] = 'If enabled, the default index-file is being stored to every subdomain-path newly created (not if the folder already exists!)';

// ADDED IN FROXLOR 0.9.3-svn2

$lng['serversettings']['adminmail_return']['title'] = 'Reply-To address';
$lng['serversettings']['adminmail_return']['description'] = 'Define an e-mail address as reply-to-address for mails sent by the panel.';
$lng['serversettings']['adminmail_defname'] = 'Panel e-mail sender name';

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
$lng['crondesc']['cron_ticketsreset'] = 'Resetowananie licznika zgłoszeń';
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
$lng['serversettings']['stdsubdomainhost']['description'] = 'What hostname should be used to create standard subdomains for customer. If empty, the system-hostname is used.';

// ADDED IN FROXLOR 0.9.4-svn1
$lng['ftp']['account_edit'] = 'Edit ftp account';
$lng['ftp']['editpassdescription'] = 'Set new password or leave blank for no change.';
$lng['customer']['sendinfomail'] = 'Send data via email to me';
$lng['mails']['new_database_by_customer']['subject'] = '[Froxlor] New database created';
$lng['mails']['new_database_by_customer']['mailbody'] = "Hello {CUST_NAME},\n\nyou have just added a new database. Here is the entered information:\n\nDatabasename: {DB_NAME}\nPassword: {DB_PASS}\nDescription: {DB_DESC}\nDB-Hostname: {DB_SRV}\nphpMyAdmin: {PMA_URI}\nYours sincerely, your administrator";
$lng['serversettings']['awstats_path'] = 'Path to AWStats \'awstats_buildstaticpages.pl\'';
$lng['serversettings']['awstats_conf'] = 'AWStats configuration path';
$lng['error']['overviewsettingoptionisnotavalidfield'] = 'Woops, a field that should be displayed as an option in the settings-overview is not an excepted type. You can blame the developers for this. This should not happen!';
$lng['admin']['configfiles']['compactoverview'] = 'Compact-overview';
$lng['admin']['lastlogin_succ'] = 'Last login';
$lng['panel']['neverloggedin'] = 'No login yet';

// ADDED IN FROXLOR 0.9.6-svn1
$lng['serversettings']['defaultttl'] = 'Domain TTL for bind in seconds (default \'604800\' = 1 week)';
$lng['ticket']['logicalorder'] = 'Logical order';
$lng['ticket']['orderdesc'] = 'Here you can define your own logical order for the ticket-category. Use 1 - 999, lower numbers are displayed first.';

// ADDED IN FROXLOR 0.9.6-svn3
$lng['serversettings']['defaultwebsrverrhandler_enabled'] = 'Enable default errordocuments for all customers';
$lng['serversettings']['defaultwebsrverrhandler_err401']['title'] = 'File/URL for error 401';
$lng['serversettings']['defaultwebsrverrhandler_err401']['description'] = '<div class="red">Not supported in: lighttpd</div>';
$lng['serversettings']['defaultwebsrverrhandler_err403']['title'] = 'File/URL for error 403';
$lng['serversettings']['defaultwebsrverrhandler_err403']['description'] = '<div class="red">Not supported in: lighttpd</div>';
$lng['serversettings']['defaultwebsrverrhandler_err404'] = 'File/URL for error 404';
$lng['serversettings']['defaultwebsrverrhandler_err500']['title'] = 'File/URL for error 500';
$lng['serversettings']['defaultwebsrverrhandler_err500']['description'] = '<div class="red">Not supported in: lighttpd</div>';

// ADDED IN FROXLOR 0.9.6-svn4
$lng['serversettings']['ticket']['default_priority'] = 'Default support-ticket priority';

// ADDED IN FROXLOR 0.9.6-svn5
$lng['serversettings']['mod_fcgid']['defaultini'] = 'Default PHP configuration for new domains';

// ADDED IN FROXLOR 0.9.6-svn6
$lng['admin']['ftpserver'] = 'FTP Server';
$lng['admin']['ftpserversettings'] = 'FTP Server settings';
$lng['serversettings']['ftpserver']['desc'] = 'If pureftpd is selected the .ftpquota files for user quotas are created and updated daily';

// ADDED IN FROXLOR 0.9.7-svn1
$lng['mails']['new_ftpaccount_by_customer']['subject'] = 'New ftp-user created';
$lng['mails']['new_ftpaccount_by_customer']['mailbody'] = "Hello {CUST_NAME},\n\nyou have just added a new ftp-user. Here is the entered information:\n\nUsername: {USR_NAME}\nPassword: {USR_PASS}\nPath: {USR_PATH}\n\nYours sincerely, your administrator";
$lng['domains']['redirectifpathisurl'] = 'Redirect code (default: empty)';
$lng['domains']['redirectifpathisurlinfo'] = 'You only need to select one of these if you entered an URL as path';
$lng['serversettings']['customredirect_enabled']['title'] = 'Allow customer redirects';
$lng['serversettings']['customredirect_enabled']['description'] = 'Allow customers to choose the http-status code for redirects which will be used';
$lng['serversettings']['customredirect_default']['title'] = 'Default redirect';
$lng['serversettings']['customredirect_default']['description'] = 'Set the default redirect-code which should be used if the customer does not set it himself';

// ADDED IN FROXLOR 0.9.7-svn2
$lng['error']['pathmaynotcontaincolon'] = 'Ścieżka powinna zawierać (":"). Proszę wprowadzić poprawną ścieżkę.';

// ADDED IN FROXLOR 0.9.7-svn3

// these stay only in english.lng.php - they are the same
// for all other languages and are used if not found there
$lng['redirect_desc']['rc_default'] = 'Domyślnie';
$lng['redirect_desc']['rc_movedperm'] = 'Przekierowanie pernamentne';
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
$lng['serversettings']['perl']['suexecworkaround']['title'] = 'Enable SuExec workaround';
$lng['serversettings']['perl']['suexecworkaround']['description'] = 'Enable only if customer docroots are not within the apache suexec path.<br />If enabled, Froxlor will generate a symlink from the customers perl-enabled directory + /cgi-bin/ to the given path.<br />Note that perl will then only work in the folders subdirectory /cgi-bin/ and not in the folder itself (as it does without this fix!)';
$lng['serversettings']['perl']['suexeccgipath']['title'] = 'Path for customer perl-enabled directory symlinks';
$lng['serversettings']['perl']['suexeccgipath']['description'] = 'You only need to set this if the SuExec-workaround is enabled.<br />ATTENTION: Be sure this path is within the suexec path or else this workaround is uselsess';
$lng['panel']['descriptionerrordocument'] = 'Can be an URL, path to a file or just a string wrapped around " "<br />Leave empty to use server default value.';
$lng['error']['stringerrordocumentnotvalidforlighty'] = 'A string as ErrorDocument does not work in lighttpd, please specify a path to a file';
$lng['error']['urlerrordocumentnotvalidforlighty'] = 'An URL as ErrorDocument does not work in lighttpd, please specify a path to a file';

// ADDED IN FROXLOR 0.9.12-svn3
$lng['question']['remove_subbutmain_domains'] = 'Also remove domains which are added as full domains but which are subdomains of this domain?';
$lng['domains']['issubof'] = 'This domain is a subdomain of another domain';
$lng['domains']['issubofinfo'] = 'You have to set this to the correct domain if you want to add a subdomain as full-domain (e.g. you want to add "www.domain.tld", you have to select "domain.tld" here)';
$lng['domains']['nosubtomaindomain'] = 'No subdomain of a full domain';
$lng['admin']['templates']['new_database_by_customer'] = 'Customer-notification when a database has been created';
$lng['admin']['templates']['new_ftpaccount_by_customer'] = 'Customer-notification when a ftp-user has been created';
$lng['admin']['templates']['newdatabase'] = 'Notification-mails for new databases';
$lng['admin']['templates']['newftpuser'] = 'Notification-mails for new ftp-user';
$lng['admin']['templates']['CUST_NAME'] = 'Customer name';
$lng['admin']['templates']['DB_NAME'] = 'Database name';
$lng['admin']['templates']['DB_PASS'] = 'Database password';
$lng['admin']['templates']['DB_DESC'] = 'Database description';
$lng['admin']['templates']['DB_SRV'] = 'Database server';
$lng['admin']['templates']['PMA_URI'] = 'URL to phpMyAdmin (if given)';
$lng['admin']['notgiven'] = '[not given]';
$lng['admin']['templates']['USR_NAME'] = 'FTP username';
$lng['admin']['templates']['USR_PASS'] = 'FTP password';
$lng['admin']['templates']['USR_PATH'] = 'FTP homedir (relative to customer-docroot)';

// ADDED IN FROXLOR 0.9.12-svn4
$lng['serversettings']['awstats_awstatspath'] = 'Path to AWStats \'awstats.pl\'';

// ADDED IN FROXLOR 0.9.12-svn6
$lng['extras']['htpasswdauthname'] = 'Authentication reason (AuthName)';
$lng['extras']['directoryprotection_edit'] = 'edit directory protection';
$lng['admin']['templates']['forgotpwd'] = 'Notification-mails for password-reset';
$lng['admin']['templates']['password_reset'] = 'Customer-notification for passwort-reset';
$lng['admin']['store_defaultindex'] = 'Store default index-file to customers docroot';

// ADDED IN FROXLOR 0.9.14
$lng['serversettings']['mod_fcgid']['defaultini_ownvhost'] = 'Default PHP configuration for Froxlor-vHost';
$lng['serversettings']['awstats_icons']['title'] = 'Path to AWstats icons folder';
$lng['serversettings']['awstats_icons']['description'] = 'e.g. /usr/share/awstats/htdocs/icon/';
$lng['admin']['ipsandports']['ssl_cert_chainfile']['title'] = 'Path to the SSL CertificateChainFile';
$lng['admin']['ipsandports']['ssl_cert_chainfile']['description'] = 'Mostly CA_Bundle, or similar, you probably want to set this if you bought a SSL certificate.';
$lng['admin']['ipsandports']['docroot']['title'] = 'Custom docroot (empty = point to Froxlor)';
$lng['admin']['ipsandports']['docroot']['description'] = 'You can define a custom document-root (the destination for a request) for this ip/port combination here.<br /><strong>ATTENTION:</strong> Please be careful with what you enter here!';
$lng['serversettings']['login_domain_login'] = 'Allow login with domains';
$lng['panel']['unlock'] = 'unlock';
$lng['question']['customer_reallyunlock'] = 'Do you really want to unlock customer %s?';

// ADDED IN FROXLOR 0.9.15
$lng['serversettings']['perl_server']['title'] = 'Perl server location';
$lng['serversettings']['perl_server']['description'] = 'Default is set for using the guide found at: <a target="blank" href="http://wiki.nginx.org/SimpleCGI">http://wiki.nginx.org/SimpleCGI</a>';
$lng['serversettings']['nginx_php_backend']['title'] = 'Nginx PHP backend';
$lng['serversettings']['nginx_php_backend']['description'] = 'this is where the PHP process is listening for requests from nginx, can be a unix socket of ip:port combination<br />*NOT used with php-fpm';
$lng['serversettings']['phpreload_command']['title'] = 'PHP reload command';
$lng['serversettings']['phpreload_command']['description'] = 'this is used to reload the PHP backend if any is used<br />Default: blank<br />*NOT used with php-fpm';

// ADDED IN FROXLOR 0.9.16
$lng['error']['intvaluetoolow'] = 'The given number is too low (field %s)';
$lng['error']['intvaluetoohigh'] = 'The given number is too high (field %s)';
$lng['admin']['phpfpm_settings'] = 'PHP-FPM';
$lng['serversettings']['phpfpm']['title'] = 'Enable php-fpm';
$lng['serversettings']['phpfpm']['description'] = '<b>This needs a special webserver configuration see FPM-handbook for <a target="blank" href="http://redmine.froxlor.org/projects/froxlor/wiki/HandbookApache2_phpfpm">Apache2</a> or <a target="blank" href="http://redmine.froxlor.org/projects/froxlor/wiki/HandbookNginx_phpfpm">nginx</a></b>';
$lng['serversettings']['phpfpm_settings']['configdir'] = 'Configuration directory of php-fpm';
$lng['serversettings']['phpfpm_settings']['aliasconfigdir'] = 'Configuration Alias-directory of php-fpm';
$lng['serversettings']['phpfpm_settings']['reload'] = 'php-fpm restart command';
$lng['serversettings']['phpfpm_settings']['pm'] = 'Process manager control (pm)';
$lng['serversettings']['phpfpm_settings']['max_children']['title'] = 'The number of child processes';
$lng['serversettings']['phpfpm_settings']['max_children']['description'] = 'The number of child processes to be created when pm is set to \'static\' and the maximum number of child processes to be created when pm is set to \'dynamic/ondemand\'<br />Equivalent to the PHP_FCGI_CHILDREN';
$lng['serversettings']['phpfpm_settings']['start_servers']['title'] = 'The number of child processes created on startup';
$lng['serversettings']['phpfpm_settings']['start_servers']['description'] = 'Note: Used only when pm is set to \'dynamic\'';
$lng['serversettings']['phpfpm_settings']['min_spare_servers']['title'] = 'The desired minimum number of idle server processes';
$lng['serversettings']['phpfpm_settings']['min_spare_servers']['description'] = 'Note: Used only when pm is set to \'dynamic\'<br />Note: Mandatory when pm is set to \'dynamic\'';
$lng['serversettings']['phpfpm_settings']['max_spare_servers']['title'] = 'The desired maximum number of idle server processes';
$lng['serversettings']['phpfpm_settings']['max_spare_servers']['description'] = 'Note: Used only when pm is set to \'dynamic\'<br />Note: Mandatory when pm is set to \'dynamic\'';
$lng['serversettings']['phpfpm_settings']['max_requests']['title'] = 'Requests per child before respawning';
$lng['serversettings']['phpfpm_settings']['max_requests']['description'] = 'For endless request processing specify \'0\'. Equivalent to PHP_FCGI_MAX_REQUESTS.';
$lng['error']['phpfpmstillenabled'] = 'PHP-FPM is currently active. Please deactivate it before activating FCGID';
$lng['error']['fcgidstillenabled'] = 'FCGID is currently active. Please deactivate it before activating PHP-FPM';
$lng['phpfpm']['vhost_httpuser'] = 'Local user to use for PHP-FPM (Froxlor vHost)';
$lng['phpfpm']['vhost_httpgroup'] = 'Local group to use for PHP-FPM (Froxlor vHost)';
$lng['phpfpm']['ownvhost']['title'] = 'Enable PHP-FPM for the Froxlor vHost';
$lng['phpfpm']['ownvhost']['description'] = 'If enabled, Froxlor will also be running under a local user';

// ADDED IN FROXLOR 0.9.17
$lng['crondesc']['cron_usage_report'] = 'Web- and traffic-reports';
$lng['serversettings']['report']['report'] = 'Enable sending of reports about web- and traffic-usage';
$lng['serversettings']['report']['webmax'] = 'Warning-level in percent for webspace';
$lng['serversettings']['report']['trafficmax'] = 'Warning-level in percent for traffic';
$lng['mails']['trafficmaxpercent']['mailbody'] = 'Dear {NAME},\n\nyou used {TRAFFICUSED} MB of your available {TRAFFIC} MB of traffic.\nThis is more than {MAX_PERCENT}%.\n\nYours sincerely, your administrator';
$lng['mails']['trafficmaxpercent']['subject'] = 'Reaching your traffic limit';
$lng['admin']['templates']['trafficmaxpercent'] = 'Notification mail for customers when given maximum of percent of traffic is exhausted';
$lng['admin']['templates']['MAX_PERCENT'] = 'Replaced with the diskusage/traffic limit for sending reports in percent.';
$lng['admin']['templates']['USAGE_PERCENT'] = 'Replaced with the diskusage/traffic, which was exhausted by the customer in percent.';
$lng['admin']['templates']['diskmaxpercent'] = 'Notification mail for customers when given maximum of percent of diskspace is exhausted';
$lng['admin']['templates']['DISKAVAILABLE'] = 'Replaced with the diskusage in MB, which was assigned to the customer.';
$lng['admin']['templates']['DISKUSED'] = 'Replaced with the diskusage in MB, which was exhausted by the customer.';
$lng['serversettings']['dropdown'] = 'Dropdown';
$lng['serversettings']['manual'] = 'Manual';
$lng['mails']['diskmaxpercent']['mailbody'] = 'Dear {NAME},\n\nyou used {DISKUSED} MB of your available {DISKAVAILABLE} MB of diskspace.\nThis is more than {MAX_PERCENT}%.\n\nYours sincerely, your administrator';
$lng['mails']['diskmaxpercent']['subject'] = 'Reaching your diskspace limit';
$lng['mysql']['database_edit'] = 'Edit database';

// ADDED IN FROXLOR 0.9.18
$lng['error']['domains_cantdeletedomainwithaliases'] = 'You cannot delete a domain which is used for alias-domains. You have to delete the aliases first.';
$lng['serversettings']['default_theme'] = 'Default theme';
$lng['menue']['main']['changetheme'] = 'Change theme';
$lng['panel']['theme'] = 'Theme';
$lng['success']['rebuildingconfigs'] = 'Successfully inserted tasks for rebuild configfiles';
$lng['panel']['variable'] = 'Variable';
$lng['panel']['description'] = 'Description';
$lng['emails']['back_to_overview'] = 'Back to overview';

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
$lng['country']['CN'] =" Chiny ";
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
$lng['serversettings']['diskquota_enabled'] = 'Quota activated?';
$lng['serversettings']['diskquota_repquota_path']['description'] = 'Path to repquota';
$lng['serversettings']['diskquota_quotatool_path']['description'] = 'Path to quotatool';
$lng['serversettings']['diskquota_customer_partition']['description'] = 'Partition, on which the customer files are stored';
$lng['tasks']['diskspace_set_quota'] = 'Set quota on filesystem';
$lng['error']['session_timeout'] = 'Value too low';
$lng['error']['session_timeout_desc'] = 'You should not set the session timeout lower than 1 minute.';

// ADDED IN FROXLOR 0.9.24-svn1
$lng['admin']['assignedmax'] = 'Assigned / Max';
$lng['admin']['usedmax'] = 'Used / Max';
$lng['admin']['used'] = 'Used';
$lng['mysql']['size'] = 'Size';

$lng['error']['invalidhostname'] = 'Hostname can\'t be empty nor can it consist only of whitespaces';

$lng['traffic']['http'] = 'HTTP (MiB)';
$lng['traffic']['ftp'] = 'FTP (MiB)';
$lng['traffic']['mail'] = 'Mail (MiB)';

// ADDED IN 0.9.27-svn1
$lng['serversettings']['mod_fcgid']['idle_timeout']['title'] = 'Idle Timeout';
$lng['serversettings']['mod_fcgid']['idle_timeout']['description'] = 'Timeout setting for Mod FastCGI.';
$lng['serversettings']['phpfpm_settings']['idle_timeout']['title'] = 'Idle Timeout';
$lng['serversettings']['phpfpm_settings']['idle_timeout']['description'] = 'Timeout setting for PHP5 FPM FastCGI.';

// ADDED IN 0.9.27-svn2
$lng['panel']['cancel'] = 'Cancel';
$lng['admin']['delete_statistics'] = 'Delete Statistics';
$lng['admin']['speciallogwarning'] = 'WARNING: By changing this setting you will lose all your old statistics for this domain. If you are sure you wish to change this type "%s" in the field below and click the "delete" button.<br /><br />';

// ADDED IN 0.9.28-svn2
$lng['serversettings']['vmail_maildirname']['title'] = 'Maildir name';
$lng['serversettings']['vmail_maildirname']['description'] = 'Maildir directory into user\'s account. Normally \'Maildir\', in some implementations \'.maildir\', and directly into user\'s directory if left blank.';
$lng['tasks']['remove_emailacc_files'] = 'Delete customer e-mail data.';

// ADDED IN 0.9.28-svn5
$lng['error']['operationnotpermitted'] = 'Operation not permitted!';
$lng['error']['featureisdisabled'] = 'Feature %s is disabled. Please contact your service provider.';
$lng['serversettings']['catchall_enabled']['title']  = 'Use Catchall';
$lng['serversettings']['catchall_enabled']['description']  = 'Do you want to provide your customers the catchall-feature?';

// ADDED IN 0.9.28.svn6
$lng['serversettings']['apache_24']['title'] = 'Use modifications for Apache 2.4';
$lng['serversettings']['apache_24']['description'] = '<strong class="red">ATTENTION:</strong> use only if you acutally have apache version 2.4 or higher installed<br />otherwise your webserver will not be able to start';
$lng['admin']['tickets_see_all'] = 'Can see all ticket-categories?';
$lng['serversettings']['nginx_fastcgiparams']['title'] = 'Path to fastcgi_params file';
$lng['serversettings']['nginx_fastcgiparams']['description'] = 'Specify the path to nginx\'s fastcgi_params file including filename';

// Added in Froxlor 0.9.28-rc2
$lng['serversettings']['documentroot_use_default_value']['title'] = 'Use domain name as default value for DocumentRoot path';
$lng['serversettings']['documentroot_use_default_value']['description'] = 'If enabled and DocumentRoot path is empty, default value will be the (sub)domain name.<br /><br />Examples: <br />/var/customers/customer_name/example.com/<br />/var/customers/customer_name/subdomain.example.com/';

$lng['error']['usercurrentlydeactivated'] = 'The user %s is currently deactivated';
$lng['admin']['speciallogfile']['title'] = 'Separate logfile';
$lng['admin']['speciallogfile']['description'] = 'Enable this to get a separate access-log file for this domain';
$lng['error']['setlessthanalreadyused'] = 'You cannot set less resources of \'%s\' than this user already used<br />';
$lng['error']['stringmustntbeempty'] = 'The value for the field %s must not be empty';
$lng['admin']['domain_editable']['title'] = 'Allow editing of domain';
$lng['admin']['domain_editable']['desc'] = 'If set to yes, the customer są dozwolone to change several domain-settings.<br />If set to no, nothing can be changed by the customer.';

// Added in Froxlor 0.9.29-dev
$lng['serversettings']['panel_phpconfigs_hidestdsubdomain']['title'] = 'Hide standard-subdomains in PHP-configuration overview';
$lng['serversettings']['panel_phpconfigs_hidestdsubdomain']['description'] = 'If activated the standard-subdomains for customers will not be displayed in the php-configurations overview<br /><br />Note: This is only visible if you have enabled FCGID or PHP-FPM';
$lng['serversettings']['passwordcryptfunc']['title'] = 'Chose which password-crypt method is to be used';
$lng['serversettings']['systemdefault'] = 'System default';
$lng['serversettings']['panel_allow_theme_change_admin'] = 'Allow admins to change the theme';
$lng['serversettings']['panel_allow_theme_change_customer'] = 'Allow customers to change the theme';
$lng['serversettings']['axfrservers']['title'] = 'AXFR servers';
$lng['serversettings']['axfrservers']['description'] = 'A comma separated list of IP addresses allowed to transfer (AXFR) dns zones.';
$lng['panel']['ssleditor'] = 'SSL settings for this domain';
$lng['admin']['ipsandports']['ssl_paste_description'] = 'Paste your complete certificate content in the textbox';
$lng['admin']['ipsandports']['ssl_cert_file_content'] = 'Content of the ssl certificate';
$lng['admin']['ipsandports']['ssl_key_file_content'] = 'Content of the ssl (private-) key file';
$lng['admin']['ipsandports']['ssl_ca_file_content'] = 'Content of the ssl CA file (optional)';
$lng['admin']['ipsandports']['ssl_ca_file_content_desc'] = '<br /><br />Client authentification, set this only if you know what it is.';
$lng['admin']['ipsandports']['ssl_cert_chainfile_content'] = 'Content of the certificate chainfile (optional)';
$lng['admin']['ipsandports']['ssl_cert_chainfile_content_desc'] = '<br /><br />Mostly CA_Bundle, or similar, you probably want to set this if you bought a SSL certificate.';
$lng['error']['sslcertificateismissingprivatekey'] = 'You need to specify a private key for your certificate';
$lng['error']['sslcertificatewrongdomain'] = 'The given certificate does not belong to this domain';
$lng['error']['sslcertificateinvalidcert'] = 'The given certificate-content does not seem to be a valid certificate';
$lng['error']['sslcertificateinvalidcertkeypair'] = 'The given private-key does not belong to the given certificate';
$lng['error']['sslcertificateinvalidca'] = 'The given CA certificate data does not seem to be a valid certificate';
$lng['error']['sslcertificateinvalidchain'] = 'The given certificate chain data does not seem to be a valid certificate';
$lng['serversettings']['customerssl_directory']['title'] = 'Webserver customer-ssl certificates-directory';
$lng['serversettings']['customerssl_directory']['description'] = 'Where should customer-specified ssl-certificates be created?<br /><br /><div class="red">NOTE: This folder\'s content gets deleted regulary so avoid storing data in there manually.</div>';
$lng['admin']['phpfpm.ininote'] = 'Not all values you may want to define can be used in the php-fpm pool configuration';

// Added in Froxlor 0.9.30
$lng['crondesc']['cron_mailboxsize'] = 'Calculating of mailbox-sizes';
$lng['domains']['ipandport_multi']['title'] = 'IP address(es)';
$lng['domains']['ipandport_multi']['description'] = 'Specify one or more IP address for the domain.<br /><br /><div class="red">NOTE: IP addresses cannot be changed when the domain is configured as <strong>alias-domain</strong> of another domain.</div>';
$lng['domains']['ipandport_ssl_multi']['title'] = 'SSL IP address(es)';
$lng['domains']['ssl_redirect']['title'] = 'SSL redirect';
$lng['domains']['ssl_redirect']['description'] = 'This option creates redirects for non-ssl vhosts so that all requests are redirected to the SSL-vhost.<br /><br />e.g. a request to <strong>http</strong>://domain.tld/ will redirect you to <strong>https</strong>://domain.tld/';
$lng['admin']['phpinfo'] = 'PHPinfo()';
$lng['admin']['selectserveralias'] = 'ServerAlias value for the domain';
$lng['admin']['selectserveralias_desc'] = 'Chose whether froxlor should create a wildcard-entry (*.domain.tld), a WWW-alias (www.domain.tld) or no alias at all';
$lng['domains']['serveraliasoption_wildcard'] = 'Wildcard (*.domain.tld)';
$lng['domains']['serveraliasoption_www'] = 'WWW (www.domain.tld)';
$lng['domains']['serveraliasoption_none'] = 'No alias';
$lng['error']['givendirnotallowed'] = 'The given directory in field %s is not allowed.';
$lng['serversettings']['ssl']['ssl_cipher_list']['title'] = 'Configure the allowed SSL ciphers';
$lng['serversettings']['ssl']['ssl_cipher_list']['description'] = 'This is a list of ciphers that you want (or don\'t want) to use when talking SSL. For a list of ciphers and how to include/exclude them, see sections "CIPHER LIST FORMAT" and "CIPHER STRINGS" on <a href="http://openssl.org/docs/apps/ciphers.html">the man-page for ciphers</a>.<br /><br /><b>Default value is:</b><pre>ECDH+AESGCM:ECDH+AES256:!aNULL:!MD5:!DSS:!DH:!AES128</pre>';

// Added in Froxlor 0.9.31
$lng['panel']['dashboard'] = 'Dashboard';
$lng['panel']['assigned'] = 'assigned';
$lng['panel']['available'] = 'available';
$lng['customer']['services'] = 'Services';
$lng['serversettings']['phpfpm_settings']['ipcdir']['title'] = 'FastCGI IPC directory';
$lng['serversettings']['phpfpm_settings']['ipcdir']['description'] = 'The directory where the php-fpm sockets will be stored by the webserver.<br />This directory has to be readable for the webserver';
$lng['panel']['news'] = 'News';
$lng['error']['sslredirectonlypossiblewithsslipport'] = 'Using the SSL redirect is only possible when the domain has at least one ssl-enabled IP/port combination assigned.';
$lng['error']['fcgidstillenableddeadlock'] = 'FCGID is currently active.<br />Please deactivate it before switching to another webserver than Apache2 or lighttpd';
$lng['error']['send_report_title'] = 'Send error report';
$lng['error']['send_report_desc'] = 'Thank you for reporting this error and helping us to froxlor improve froxlor.<br />This is the email which will be sent to the froxlor developer team:';
$lng['error']['send_report'] = 'Send report';
$lng['error']['send_report_error'] = 'Error when sending report: <br />%s';
$lng['error']['notallowedtouseaccounts'] = 'Your account does not allow using IMAP/POP3. You cannot add email accounts.';
$lng['pwdreminder']['changed'] = 'Your password has been updated successfully. You can now login with your new password.';
$lng['pwdreminder']['wrongcode'] = 'Sorry, your activation-code does not exist or has already expired.';
$lng['admin']['templates']['LINK'] = 'Replaced with the customers password reset link.';
$lng['pwdreminder']['choosenew'] = 'Set new password';
$lng['serversettings']['allow_error_report_admin']['title'] = 'Allow administrators/resellers to report database-errors to Froxlor';
$lng['serversettings']['allow_error_report_admin']['description'] = 'Please note: Never send any personal (customer-)data to us!';
$lng['serversettings']['allow_error_report_customer']['title'] = 'Allow customers to report database-errors to Froxlor';
$lng['serversettings']['allow_error_report_customer']['description'] = 'Please note: Never send any personal (customer-)data to us!';
$lng['admin']['phpsettings']['enable_slowlog'] = 'Enable slowlog (per domain)';
$lng['admin']['phpsettings']['request_terminate_timeout'] = 'Request terminate-timeout';
$lng['admin']['phpsettings']['request_slowlog_timeout'] = 'Request slowlog-timeout';
$lng['admin']['templates']['SERVER_HOSTNAME'] = 'Replaces the system-hostname (URL to froxlor)';
$lng['admin']['templates']['SERVER_IP'] = 'Replaces the default server ip-address';
$lng['admin']['templates']['SERVER_PORT'] = 'Replaces the default server port';
$lng['admin']['templates']['DOMAINNAME'] = 'Replaces the customers standard-subdomain (can be empty if none is generated)';
$lng['admin']['show_news_feed'] = 'Show news-feed on admin-dashboard';

// Added in Froxlor 0.9.32
$lng['logger']['reseller'] = "Reseller";
$lng['logger']['admin'] = "Administrator";
$lng['logger']['cron'] = "Cronjob";
$lng['logger']['login'] = "Login";
$lng['logger']['intern'] = "Internal";
$lng['logger']['unknown'] = "Unknown";
$lng['serversettings']['mailtraffic_enabled']['title'] = "Analyse mail traffic";
$lng['serversettings']['mailtraffic_enabled']['description'] = "Enable analysing of mailserver logs to calculate the traffic";
$lng['serversettings']['mdaserver']['title'] = "MDA type";
$lng['serversettings']['mdaserver']['description'] = "Type of the Mail Delivery Server";
$lng['serversettings']['mdalog']['title'] = "MDA log";
$lng['serversettings']['mdalog']['description'] = "Logfile of the Mail Delivery Server";
$lng['serversettings']['mtaserver']['title'] = "MTA type";
$lng['serversettings']['mtaserver']['description'] = "Type of the Mail Transfer Agent";
$lng['serversettings']['mtalog']['title'] = "MTA log";
$lng['serversettings']['mtalog']['description'] = "Logfile of the Mail Transfer Agent";
$lng['panel']['ftpdesc'] = 'FTP description';
$lng['admin']['cronsettings'] = 'Cronjob settings';
$lng['serversettings']['system_cronconfig']['title'] = 'Cron configuration file';
$lng['serversettings']['system_cronconfig']['description'] = 'Path to the cron-service configuration-file. This file will be updated regularly and automatically by froxlor.<br />Note: Please <b>be sure</b> to use the same filename as for the main froxlor cronjob (default: /etc/cron.d/froxlor)!<br><br>If you are using <b>FreeBSD</b>, please specify <i>/etc/crontab</i> here!';
$lng['tasks']['remove_ftpacc_files'] = 'Delete customer ftp-account data.';
$lng['tasks']['regenerating_crond'] = 'Rebuilding the cron.d-file';
$lng['serversettings']['system_crondreload']['title'] = 'Cron-daemon reload command';
$lng['serversettings']['system_crondreload']['description'] = 'Specify the command to execute in order to reload your systems cron-daemon';
$lng['admin']['integritycheck'] = 'Database validation';
$lng['admin']['integrityid'] = '#';
$lng['admin']['integrityname'] = 'Name';
$lng['admin']['integrityresult'] = 'Result';
$lng['admin']['integrityfix'] = 'Fix problems automatically';
$lng['question']['admin_integritycheck_reallyfix'] = 'Do you really want to try fixing all database integrity problems automatically?';
$lng['serversettings']['system_croncmdline']['title'] = 'Cron execution command (php-binary)';
$lng['serversettings']['system_croncmdline']['description'] = 'Command to execute our cronjobs. Change this only if you know what you are doing (default: "/usr/bin/nice -n 5 /usr/bin/php5 -q")!';
$lng['error']['cannotdeletehostnamephpconfig'] = 'This PHP-configuration is used by the Froxlor-vhost and cannot be deleted.';
$lng['error']['cannotdeletedefaultphpconfig'] = 'This PHP-configuration is set as default and cannot be deleted.';
$lng['serversettings']['system_cron_allowautoupdate']['title'] = 'Allow automatic database updates';
$lng['serversettings']['system_cron_allowautoupdate']['description'] = '<div class="red"><b>ATTENTION:</b></div> This settings allows the cronjob to bypass the version-check of froxlors files and database and runs the database-updates in case a version-mismatch occurs.<br><br><div class="red">Auto-update will always set default values for new settings or changes. This might not always suite your system. Please think twice before activating this option</div>';
$lng['error']['passwordshouldnotbeusername'] = 'The password should not be the same as the username.';

// Added in Froxlor 0.9.33
$lng['admin']['customer_show_news_feed'] = "Show custom newsfeed on customer-dashboard";
$lng['admin']['customer_news_feed_url'] = "RSS-Feed for the custom newsfeed";
$lng['serversettings']['dns_createhostnameentry'] = "Create bind-zone/config for system hostname";
$lng['serversettings']['panel_password_alpha_lower']['title'] = 'Lowercase character';
$lng['serversettings']['panel_password_alpha_lower']['description'] = 'Password must contain at least one lowercase letter (a-z).';
$lng['serversettings']['panel_password_alpha_upper']['title'] = 'Uppercase character';
$lng['serversettings']['panel_password_alpha_upper']['description'] = 'Password must contain at least one  uppercase letter (A-Z).';
$lng['serversettings']['panel_password_numeric']['title'] = 'Numbers';
$lng['serversettings']['panel_password_numeric']['description'] = 'Password must contain at least one number (0-9).';
$lng['serversettings']['panel_password_special_char_required']['title'] = 'Special character';
$lng['serversettings']['panel_password_special_char_required']['description'] = 'Password must contain at least one of the characters defined below.';
$lng['serversettings']['panel_password_special_char']['title'] = 'Special characters list';
$lng['serversettings']['panel_password_special_char']['description'] = 'One of these characters is required if the above option is set.';
$lng['phpfpm']['use_mod_proxy']['title'] = 'Use mod_proxy / mod_proxy_fcgi';
$lng['phpfpm']['use_mod_proxy']['description'] = 'Activate to use php-fpm via mod_proxy_fcgi. Requires at least apache-2.4.9';
$lng['error']['no_phpinfo'] = 'Sorry, unable to read phpinfo()';

$lng['admin']['movetoadmin'] = 'Move customer';
$lng['admin']['movecustomertoadmin'] = 'Move customer to the selected admin/reseller<br /><small>Leave this empty for no change.<br />If the desired admin does not show up in the list, his customer-limit has been reached.</small>';
$lng['error']['moveofcustomerfailed'] = 'Moving the customer to the selected admin/reseller failed. Keep in mind that all other changes to the customer were applied successfully at this stage.<br><br>Error-message: %s';

$lng['domains']['domain_import'] = 'Import Domains';
$lng['domains']['import_separator'] = 'Separator';
$lng['domains']['import_offset'] = 'Offset';
$lng['domains']['import_file'] = 'CSV-File';
$lng['success']['domain_import_successfully'] = 'Successfully imported %s domains.';
$lng['error']['domain_import_error'] = 'Following error occurred while importing domains: %s';
$lng['admin']['note'] = 'Note';
$lng['domains']['import_description'] = 'Detailed information about the structure of the import-file and how to import successfully, please visit <a href="http://redmine.froxlor.org/projects/froxlor/wiki/DomainBulkActionDoc" target="_blank">http://redmine.froxlor.org/projects/froxlor/wiki/DomainBulkActionDoc</a>';
$lng['usersettings']['custom_notes']['title'] = 'Custom notes';
$lng['usersettings']['custom_notes']['description'] = 'Feel free to put any notes you want/need in here. They will show up in the admin/customer overview for the corresponding user.';
$lng['usersettings']['custom_notes']['show'] = 'Show your notes on the dashboard of the user';
$lng['serversettings']['system_send_cron_errors']['title'] = 'Send cron-errors to froxlor-admin via e-mail';
$lng['serversettings']['system_send_cron_errors']['description'] = 'Choose whether you want to receive an e-mail on cronjob errors. Keep in mind that this can lead to an e-mail being sent every 5 minutes depending on the error and your cronjob settings.';
$lng['error']['fcgidandphpfpmnogoodtogether'] = 'FCGID and PHP-FPM cannot be activated at the same time';

// Added in Froxlor 0.9.34
$lng['admin']['configfiles']['legend'] = 'You are about to configure a service/daemon. The following legend explains the nomenclature.';
$lng['admin']['configfiles']['commands'] = '<span class="red">Commands:</span> These commands are to be executed line by line as root-user in a shell. It is safe to copy the whole block and paste it into the shell.';
$lng['admin']['configfiles']['files'] = '<span class="red">Configfiles:</span> This is an example of the contents of a configuration file. The commands before these textfields should open an editor with the target file. Just copy and paste the contents into the editor and save the file.<br><br><span class="red">Please note:</span> The MySQL-password has not been replaced for security reasons. Please replace "MYSQL_PASSWORD" on your own. If you forgot your MySQL-password you\'ll find it in "lib/userdata.inc.php"';
$lng['serversettings']['apache_itksupport']['title'] = 'Use modifications for Apache ITK-MPM';
$lng['serversettings']['apache_itksupport']['description'] = '<strong class="red">ATTENTION:</strong> use only if you acutally have apache itk-mpm enabled<br />otherwise your webserver will not be able to start';
$lng['integrity_check']['DatabaseCharset'] = 'Characterset of database (should be UTF-8)';
$lng['integrity_check']['DomainIpTable'] = 'IP &lt;&dash;&gt; domain references';
$lng['integrity_check']['SubdomainSslRedirect'] = 'False SSL-redirect flag for non-ssl domains';
$lng['integrity_check']['FroxlorLocalGroupMemberForFcgidPhpFpm'] = 'froxlor-user in the customer groups (for FCGID/php-fpm)';
$lng['integrity_check']['WebserverGroupMemberForFcgidPhpFpm'] = 'Webserver-user in the customer groups (for FCGID/php-fpm)';
$lng['admin']['specialsettings_replacements'] = "You can use the following variables:<br/><code>{DOMAIN}</code>, <code>{DOCROOT}</code>, <code>{CUSTOMER}</code>, <code>{IP}</code>, <code>{PORT}</code>, <code>{SCHEME}</code><br/>";
$lng['serversettings']['default_vhostconf']['description'] = 'The content of this field will be included into this ip/port vHost container directly. '.$lng['admin']['specialsettings_replacements'].' Attention: The code won\'t be checked for any errors. If it contains errors, webserver might not start again!';
$lng['serversettings']['default_vhostconf_domain']['description'] = 'The content of this field will be included into the domain vHost container directly. '.$lng['admin']['specialsettings_replacements'].' Attention: The code won\'t be checked for any errors. If it contains errors, webserver might not start again!';
$lng['admin']['mod_fcgid_umask']['title'] = 'Umask (default: 022)';
