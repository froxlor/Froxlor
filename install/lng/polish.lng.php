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
 //-----    Polish Translator   ------//
 //-----    eSalamandra.com.pl  ------//
 */

$lng['requirements']['title'] = 'Sprawdzanie wymagań systemowych...'; 
$lng['requirements']['installed'] = 'Zainstalowane';
$lng['requirements']['not_true'] = 'Fałsz';
$lng['requirements']['notfound'] = 'Nie znaleziono';
$lng['requirements']['notinstalled'] = 'Nie zainstalowane';
$lng['requirements']['activated'] = 'Włączone';
$lng['requirements']['phpversion'] = 'Wersja PHP >= 5.3';
$lng['requirements']['phpmagic_quotes_runtime'] = 'magic_quotes_runtime...';
$lng['requirements']['phpmagic_quotes_runtime_description'] = 'Ustawienie PHP "magic_quotes_runtime" musi być ustawione na "Off". Tymczasowo wyłączymy je natomiast proszę skorygować ustawienie w oparciu o php.ini.';
$lng['requirements']['phppdo'] = 'rozszerzenie PHP PDO oraz sterownik PDO-MySQL...';
$lng['requirements']['phpxml'] = 'rozszerzenie PHP XML...';
$lng['requirements']['phpfilter'] = 'rozszerzenie PHP filter-...';
$lng['requirements']['phpposix'] = 'rozszerzenie PHP posix...';
$lng['requirements']['phpbcmath'] = 'rozszerzenie PHP bcmath...';
$lng['requirements']['phpcurl'] = 'rozszerzenie PHP curl...';
$lng['requirements']['phpmbstring'] = 'rozszerzenie PHP mbstring...';
$lng['requirements']['bcmathdescription'] = 'Kalkulacja ruchu może nie pracować poprawnie!';
$lng['requirements']['curldescription'] = 'Sprawdzenie wersji oraz kanału news może nie pracować poprawnie!';
$lng['requirements']['openbasedir'] = 'open_basedir...';
$lng['requirements']['openbasedirenabled'] = 'Froxlor nie praccuje poporawnie jeśli open_basedir jest włączone. Proszę wyłączyć open_basedir dla Froxlor w pliku php.ini';

$lng['requirements']['diedbecauseofrequirements'] = 'Nie można zainstalować Froxlor bez tych wymaganych elementow! Spróbuj naprawić te problemy i ponownie przystąpić do instalacji.';
$lng['requirements']['froxlor_succ_checks'] = 'Wszystkie wymagania zostały spełnione';
$lng['install']['lngtitle'] = 'Instalacja Froxlor-a  - wybierz język';
$lng['install']['language'] = 'Język instalacji';
$lng['install']['lngbtn_go'] = 'Zmień język';
$lng['install']['title'] = 'Froxlor Instalacja - setup';
$lng['install']['welcometext'] = 'Dziękujemy że wybrałeś Froxlor. proszę wypełnij poniższe pola wymagane do rozpoczęcia instalacji.<br /><b>Ostrzeżenie:</b> Jeżeli wybierzesz bazę danych istniejącą w Twoim systemie, zostanie ona wyczyszczona z całej zawartości!';
$lng['install']['database'] = 'Połączenie z bazą danych';
$lng['install']['mysql_host'] = 'MySQL-Nazwa hosta';
$lng['install']['mysql_database'] = 'Nazwa bazy danych';

$lng['install']['mysql_unpriv_user'] = 'Nazwa użytkownika dla nieuprzywilejowanego konta MySQL';
$lng['install']['mysql_unpriv_pass'] = 'Hasło dla nieuprzywilejowanego konta MySQL';
$lng['install']['mysql_root_user'] = 'Nazwa użytkownika dla konta root MySQL';
$lng['install']['mysql_root_pass'] = 'Hasło dla konta root MySQL';
$lng['install']['admin_account'] = 'Konto Administrator';
$lng['install']['admin_user'] = 'Administrator - Nazwa użytkownika';
$lng['install']['admin_pass1'] = 'Administrator Hasło';
$lng['install']['admin_pass2'] = 'Administrator-Hasło (potwierdznie)';
$lng['install']['serversettings'] = 'Ustawienia serwera';
$lng['install']['servername'] = 'Nazwa serwera (FQDN, Nie adres IP)';
$lng['install']['serverip'] = 'IP Serwera';
$lng['install']['webserver'] = 'Webserver';
$lng['install']['apache2'] = 'Apache 2';
$lng['install']['apache24'] = 'Apache 2.4';
$lng['install']['lighttpd'] = 'LigHTTPd';
$lng['install']['nginx'] = 'NGINX';
$lng['install']['httpuser'] = 'użytkownik HTTP';
$lng['install']['httpgroup'] = 'grupa HTTP';

$lng['install']['testing_mysql'] = 'Sprawdzanie dostępu do konta root MySQL...';
$lng['install']['testing_mysql_fail'] = 'Wygląda to na błąd połączenia z bazą. Nie można kontynuować instalacji. Proszę wrócić i sprawdzić Ustawienia.';
$lng['install']['backup_old_db'] = 'Tworzenie kopi starej bazy...';
$lng['install']['backup_binary_missing'] = 'Nie można odnaleźć polecenia mysqldump';
$lng['install']['backup_failed'] = 'Nie można wykonać kopi bazy';
$lng['install']['prepare_db'] = 'Przygotowanie baz danych...';
$lng['install']['create_mysqluser_and_db'] = 'Tworzenie bazy oraz użytkownika...';
$lng['install']['testing_new_db'] = 'Sprawdzanie czy baza danych oraz użytkownik utworzone poprawnie...';
$lng['install']['importing_data'] = 'Importowanie danych...';
$lng['install']['changing_data'] = 'Dostosowywanie ustawień...';
$lng['install']['creating_entries'] = 'Wprowadzanie nowych wartości...';
$lng['install']['adding_admin_user'] = 'Tworzenie konta admina...';
$lng['install']['creating_configfile'] = 'Tworzenie pliku konfiguracyjnego...';
$lng['install']['creating_configfile_temp'] = 'Plik został zapisany w /tmp/userdata.inc.php, proszę przenieść go do lib/.';
$lng['install']['creating_configfile_failed'] = 'Nie można utworzyć lib/userdata.inc.php, proszę utworzyć go ręcznie z następująca zawartością :';
$lng['install']['froxlor_succ_installed'] = 'Froxlor został zainstalowany pomyślnie.';

$lng['click_here_to_refresh'] = 'Naciśnij tutaj aby sprawdzić ponownie';
$lng['click_here_to_goback'] = 'Naciśnij tutaj aby wrócić';
$lng['click_here_to_continue'] = 'Naciśnij tutaj aby kontynuować';
$lng['click_here_to_login'] = 'Naciśnij tutaj aby się zalogować.';