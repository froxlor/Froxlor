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

$lng['translator'] = 'Vladimir Krasnopoyas';
$lng['panel']['edit'] = 'Редактировать';
$lng['panel']['delete'] = 'Удалить';
$lng['panel']['create'] = 'Создать';
$lng['panel']['save'] = 'Сохранить';
$lng['panel']['yes'] = 'Да';
$lng['panel']['no'] = 'Нет';
$lng['panel']['emptyfornochanges'] = 'Не внесены изменения';
$lng['panel']['emptyfordefault'] = 'по-умолчанию';
$lng['panel']['path'] = 'Путь';
$lng['panel']['toggle'] = 'Toggle';
$lng['panel']['next'] = 'Далее';
$lng['panel']['dirsmissing'] = 'Невозможно найти или прочитать директорию!';

/**
 * Login
 */

$lng['login']['username'] = 'Пользователь';
$lng['login']['password'] = 'Пароль';
$lng['login']['language'] = 'Язык';
$lng['login']['login'] = 'Войти';
$lng['login']['logout'] = 'Выйти';
$lng['login']['profile_lng'] = 'Язык профиля';

/**
 * Customer
 */

$lng['customer']['documentroot'] = 'Домашняя директория';
$lng['customer']['name'] = 'Имя';
$lng['customer']['firstname'] = 'Фамилия';
$lng['customer']['company'] = 'Компания';
$lng['customer']['street'] = 'Улица';
$lng['customer']['zipcode'] = 'Индекс';
$lng['customer']['city'] = 'Город';
$lng['customer']['phone'] = 'Телефон';
$lng['customer']['fax'] = 'Факс';
$lng['customer']['email'] = 'E-mail';
$lng['customer']['customernumber'] = 'ID Пользователя';
$lng['customer']['diskspace'] = 'Web-пространство (MB)';
$lng['customer']['traffic'] = 'Траффик (GB)';
$lng['customer']['mysqls'] = 'MySQL-базы данных';
$lng['customer']['emails'] = 'Email-адреса';
$lng['customer']['accounts'] = 'Email-аккаунты';
$lng['customer']['forwarders'] = 'Email-пересылки';
$lng['customer']['ftps'] = 'FTP-аккаунты';
$lng['customer']['subdomains'] = 'Sub-домены';
$lng['customer']['domains'] = 'Домены';
$lng['customer']['unlimited'] = '∞';

/**
 * Customermenue
 */

$lng['menue']['main']['main'] = 'Главная';
$lng['menue']['main']['changepassword'] = 'Сменить пароль';
$lng['menue']['main']['changelanguage'] = 'Сменить язык';
$lng['menue']['email']['email'] = 'Email';
$lng['menue']['email']['emails'] = 'Адрес';
$lng['menue']['email']['webmail'] = 'Web-почта';
$lng['menue']['mysql']['mysql'] = 'MySQL';
$lng['menue']['mysql']['databases'] = 'Базы данных';
$lng['menue']['mysql']['phpmyadmin'] = 'phpMyAdmin';
$lng['menue']['domains']['domains'] = 'Домены';
$lng['menue']['domains']['settings'] = 'Настройки';
$lng['menue']['ftp']['ftp'] = 'FTP';
$lng['menue']['ftp']['accounts'] = 'Аккаунты';
$lng['menue']['ftp']['webftp'] = 'WebFTP';
$lng['menue']['extras']['extras'] = 'Дополнительно';
$lng['menue']['extras']['directoryprotection'] = 'Защита дирректории';
$lng['menue']['extras']['pathoptions'] = 'Опции путей';

/**
 * Index
 */

$lng['index']['customerdetails'] = 'Детали Заказчика';
$lng['index']['accountdetails'] = 'Детали Аккаунта';

/**
 * Change Password
 */

$lng['changepassword']['old_password'] = 'Старый пароль';
$lng['changepassword']['new_password'] = 'Новый пароль';
$lng['changepassword']['new_password_confirm'] = 'Повторите пароль';
$lng['changepassword']['new_password_ifnotempty'] = 'Новый пароль (пустой = не изменится)';
$lng['changepassword']['also_change_ftp'] = ' так же изменить пароль главного FTP аккаунта';

/**
 * Domains
 */

$lng['domains']['description'] = 'Здесь Вы можете создать домены и sub-домены и изменить их путь.<br />Системе необходимо некоторое время для применения изменений после их внесения.';
$lng['domains']['domainsettings'] = 'Настройки домена';
$lng['domains']['domainname'] = 'Имя домена';
$lng['domains']['subdomain_add'] = 'Создать sub-домен';
$lng['domains']['subdomain_edit'] = 'Изменить sub-домен';
$lng['domains']['wildcarddomain'] = 'Create as wildcarddomain?';
$lng['domains']['aliasdomain'] = 'Алиас домена';
$lng['domains']['noaliasdomain'] = 'Без алиаса';

/**
 * E-mails
 */

$lng['emails']['description'] = 'Здесь Вы можете создать или изменить Ваши email адреса.<br />Создавая почтовый ящик здесь Вы сможете отправлять и получать почту. Если кто-либо пошлет Вам письмо оно будет получено и отправлено к Вам в ящик.<br /><br />Для загрузки писем в Вашу почтовую программу: (Данные отмеченные <i>курсивом</i> должны быть изменены в соответствии с Вашими данными на сервере!)<br />Сервер: <b><i>имя_домена</i></b><br />Пользователь: <b><i>Аккаунт / e-mail адрес</i></b><br />Пароль: <b><i>Ваш_пароль</i></b>';
$lng['emails']['emailaddress'] = 'Email-адрес';
$lng['emails']['emails_add'] = 'Создать email-адрес';
$lng['emails']['emails_edit'] = 'Редактировать email-адрес';
$lng['emails']['catchall'] = 'Сборщик писем (catchall)';
$lng['emails']['iscatchall'] = 'Использовать catchall?';
$lng['emails']['account'] = 'Аккаунт';
$lng['emails']['account_add'] = 'Создать аккаунт';
$lng['emails']['account_delete'] = 'Удалить аккаунт';
$lng['emails']['from'] = 'От кого';
$lng['emails']['to'] = 'Кому';
$lng['emails']['forwarders'] = 'Пересылки';
$lng['emails']['forwarder_add'] = 'Создать пересылку';

/**
 * FTP
 */

$lng['ftp']['description'] = 'Здесь Вы можете создать или изменить Ваши FTP-аккаунты.<br />Изменения вносятся мнгновенно!';
$lng['ftp']['account_add'] = 'Создать аккаунт';

/**
 * MySQL
 */

$lng['mysql']['databasename'] = 'Имя базы данных';
$lng['mysql']['databasedescription'] = 'Описание базы данных';
$lng['mysql']['database_create'] = 'Создать базу данных';

/**
 * Extras
 */

$lng['extras']['description'] = 'Здесь Вы можете использовать некоторые дополнительные функции системы, такие как Защита web-директории паролем.<br />Системе нужно некоторое время, чтобы изменения вступили в силу.';
$lng['extras']['directoryprotection_add'] = 'Добавить защищенную директорию';
$lng['extras']['view_directory'] = 'Показать содержимое директории';
$lng['extras']['pathoptions_add'] = 'Добавить опции пути';
$lng['extras']['directory_browsing'] = 'Просмотр содержимого директори';
$lng['extras']['pathoptions_edit'] = 'Редактировать опции пути';
$lng['extras']['error404path'] = '404';
$lng['extras']['error403path'] = '403';
$lng['extras']['error500path'] = '500';
$lng['extras']['error401path'] = '401';
$lng['extras']['errordocument404path'] = 'ErrorDocument 404';
$lng['extras']['errordocument403path'] = 'ErrorDocument 403';
$lng['extras']['errordocument500path'] = 'ErrorDocument 500';
$lng['extras']['errordocument401path'] = 'ErrorDocument 401';

/**
 * Errors
 */

$lng['error']['error'] = 'Ошибка';
$lng['error']['directorymustexist'] = 'Даректория %s не найдена. Пожалуйста создайьее её в своем FTP-клиенте.';
$lng['error']['filemustexist'] = 'Файл %s Не найден.';
$lng['error']['allresourcesused'] = 'Вы уже использовали все ресурсы.';
$lng['error']['domains_cantdeletemaindomain'] = 'Вы не можете удалить домен, так как он используется в доменах почты.';
$lng['error']['domains_canteditdomain'] = 'Вы не можете редактировать домен. Он был отключен Администратором.';
$lng['error']['domains_cantdeletedomainwithemail'] = 'Вы не можете удалить домен, так как он используется в доменах почты. Сначала удалите все почтовые адреса.';
$lng['error']['firstdeleteallsubdomains'] = 'Вы можете удалить домен только после удаления всех sub-доменов.';
$lng['error']['youhavealreadyacatchallforthisdomain'] = 'You have already defined a catchall for this domain.';
$lng['error']['ftp_cantdeletemainaccount'] = 'Вы не можете удалить основной FTP-аккаунт.';
$lng['error']['login'] = 'Логин или пароль неверный. Пожалуйста попробуйте еще раз!';
$lng['error']['login_blocked'] = 'Аккаунт заблокирован из-за ошибок авторизации. <br />Пожалуйста попробуйте через %s секунд(ы).';
$lng['error']['notallreqfieldsorerrors'] = 'Некторые поля заполнены неверно или пусты!';
$lng['error']['oldpasswordnotcorrect'] = 'Старый пароль неверный.';
$lng['error']['youcantallocatemorethanyouhave'] = 'Вы не располагаете таким количеством ресурсов.';
$lng['error']['mustbeurl'] = 'Вы набрали неправильный или неполный URL (пример http://ваш_domain.com/error404.htm)';
$lng['error']['invalidpath'] = 'Вы не ввели правильный URL (проблемы с просмотром директорий?)';
$lng['error']['stringisempty'] = 'Поле не может быть пустым';
$lng['error']['stringiswrong'] = 'Ошибка ввода в поле';
$lng['error']['newpasswordconfirmerror'] = 'Новый пароль и подтверждение пароля не совпадают';
$lng['error']['mydomain'] = '\'Домен\'';
$lng['error']['mydocumentroot'] = '\'Документация\'';
$lng['error']['loginnameexists'] = 'Пользователь %s уже существует';
$lng['error']['emailiswrong'] = 'Email-адрес %s содержит недопустимые символы или неверен.';
$lng['error']['loginnameiswrong'] = 'Имя пользователя "%s" содержит недобустимые символы.';
$lng['error']['loginnameiswrong2'] = 'Имя пользователя слишком длинное. Логин может содержать %s символов.';
$lng['error']['userpathcombinationdupe'] = 'Комбинация Пользователь-Путь уже существует';
$lng['error']['patherror'] = 'Общая ошибка! Путь не может быть пустым!';
$lng['error']['errordocpathdupe'] = 'Option for path %s already exists';
$lng['error']['adduserfirst'] = 'Сначала создайте Клиента';
$lng['error']['domainalreadyexists'] = 'Доменное имя %s уже назначено Клиенту';
$lng['error']['nolanguageselect'] = 'Не выбран язык.';
$lng['error']['nosubjectcreate'] = 'Вы должны определить тему для этого почтового шаблона.';
$lng['error']['nomailbodycreate'] = 'Вы должны определить сообщение для этого почтового шаблона..';
$lng['error']['templatenotfound'] = 'Шаблон не найден.';
$lng['error']['alltemplatesdefined'] = 'Вы не можете определить несколько шаблонов, все языки поддерживаются уже.';
$lng['error']['wwwnotallowed'] = 'www не разрешено для sub-доменов.';
$lng['error']['subdomainiswrong'] = 'sub-домен %s содержит неверные символы.';
$lng['error']['domaincantbeempty'] = 'Доменное имя не может быть пустым.';
$lng['error']['domainexistalready'] = 'Домен %s уже используется.';
$lng['error']['domainisaliasorothercustomer'] = 'Выбранный псевдоним домена либо сам псевдоним домена, имеет другую комбинацию IP / порта или принадлежит другому клиенту.';
$lng['error']['emailexistalready'] = 'Этот email-адрес %s уже используется.';
$lng['error']['maindomainnonexist'] = 'Этот домен %s не найден.';
$lng['error']['destinationnonexist'] = 'Пожалуйста создайте свое перенаправление \'Назначение\'.';
$lng['error']['destinationalreadyexistasmail'] = 'Перенаправление %s уже существует в активных email-адресах.';
$lng['error']['destinationalreadyexist'] = 'Вы уже создали перенаправление к %s .';
$lng['error']['destinationiswrong'] = 'Перенаправление %s содержит недопустимые символы или неполное.';
$lng['error']['ticketnotaccessible'] = 'Нет доступа к этому тикету.';

/**
 * Questions
 */

$lng['question']['question'] = 'Вопрос безопасности';
$lng['question']['admin_customer_reallydelete'] = 'Вы действительно хотите удалить Клиента %s? Это не возможно отменить!';
$lng['question']['admin_domain_reallydelete'] = 'Вы действительно хотите удалить домен %s?';
$lng['question']['admin_domain_reallydisablesecuritysetting'] = 'Вы действительно хотите отключить функцию безопасности OpenBasedir?';
$lng['question']['admin_admin_reallydelete'] = 'Вы действительно хотите удалить администратора %s? Каждый клиент и домен будет переведен на ваш счет.';
$lng['question']['admin_template_reallydelete'] = 'Вы действительно хотите удалить шаблон \'%s\'?';
$lng['question']['domains_reallydelete'] = 'Вы действительно хотите удалить домен %s?';
$lng['question']['email_reallydelete'] = 'Вы действительно хотите удалить email-адрес %s?';
$lng['question']['email_reallydelete_account'] = 'Вы действительно хотите удалить email-аккаунт %s?';
$lng['question']['email_reallydelete_forwarder'] = 'Вы действительно хотите удалить перенаправление %s?';
$lng['question']['extras_reallydelete'] = 'Вы действительно хотите удалить безопасную директорию %s?';
$lng['question']['extras_reallydelete_pathoptions'] = 'Вы действительно хотите удалить опции пути для %s?';
$lng['question']['ftp_reallydelete'] = 'Вы действительно хотите удалить FTP-аккаунт %s?';
$lng['question']['mysql_reallydelete'] = 'Вы действительно хотите удалить базу данных %s? Это необратимо!';
$lng['question']['admin_configs_reallyrebuild'] = 'Вы действительно хотите пересобрать конфигурационные файлы?';
$lng['question']['admin_customer_alsoremovefiles'] = 'Удалить файл пользователя?';
$lng['question']['admin_customer_alsoremovemail'] = 'Удалить данные из email ящика?';
$lng['question']['admin_customer_alsoremoveftphomedir'] = 'Удалить директорию FTP-аккаунта?';

/**
 * Mails
 */

$lng['mails']['pop_success']['mailbody'] = 'Hello,\n\nyour mail account {EMAIL}\nwas set up successfully.\n\nThis is an automatically created\ne-mail, please do not answer!\n\nYours sincerely, your administrator';
$lng['mails']['pop_success']['subject'] = 'Mail account set up successfully';
$lng['mails']['createcustomer']['mailbody'] = 'Hello {FIRSTNAME} {NAME},\n\nhere is your account information:\n\nUsername: {USERNAME}\nPassword: {PASSWORD}\n\nThank you,\nyour administrator';
$lng['mails']['createcustomer']['subject'] = 'Account information';

/**
 * Admin
 */

$lng['admin']['overview'] = 'Обзор';
$lng['admin']['ressourcedetails'] = 'Используемые ресурсы';
$lng['admin']['systemdetails'] = 'Системные детали';
$lng['admin']['froxlordetails'] = 'Froxlor детали';
$lng['admin']['installedversion'] = 'Установленная версия';
$lng['admin']['latestversion'] = 'Последняя версия';
$lng['admin']['lookfornewversion']['clickhere'] = 'Искать через web-сервис';
$lng['admin']['lookfornewversion']['error'] = 'Ошибка при чтении';
$lng['admin']['resources'] = 'Ресурсы';
$lng['admin']['customer'] = 'Клиент';
$lng['admin']['customers'] = 'Клиенты';
$lng['admin']['customer_add'] = 'Создать Клиента';
$lng['admin']['customer_edit'] = 'Изменить Клиента';
$lng['admin']['domains'] = 'Домены';
$lng['admin']['domain_add'] = 'Создать домен';
$lng['admin']['domain_edit'] = 'Изменить домен';
$lng['admin']['subdomainforemail'] = 'Sub-домены как email-домены';
$lng['admin']['admin'] = 'Администратор';
$lng['admin']['admins'] = 'Администраторы';
$lng['admin']['admin_add'] = 'Создать Администратора';
$lng['admin']['admin_edit'] = 'Изменить Администратора';
$lng['admin']['customers_see_all'] = 'Просмотреть всех Клиентов?';
$lng['admin']['domains_see_all'] = 'Просмотреть все домены?';
$lng['admin']['change_serversettings'] = 'Хотите изменить настройки сервера?';
$lng['admin']['server'] = 'Сервер';
$lng['admin']['serversettings'] = 'Настройки';
$lng['admin']['rebuildconf'] = 'Пересоздать файл конфигурации';
$lng['admin']['stdsubdomain'] = 'Стандартный sub-домен';
$lng['admin']['stdsubdomain_add'] = 'Создать стандартный sub-домен';
$lng['admin']['phpenabled'] = 'PHP включен';
$lng['admin']['deactivated'] = 'Выключить';
$lng['admin']['deactivated_user'] = 'Выключить пользователя';
$lng['admin']['sendpassword'] = 'Отправить пароль';
$lng['admin']['ownvhostsettings'] = 'Own vHost-settings';
$lng['admin']['configfiles']['serverconfiguration'] = 'Конфигурация';
$lng['admin']['configfiles']['files'] = '<b>Конфигурационные файлы:</b> Please change the following files or create them with<br />the following content if they do not exist.<br /><b>Please note:</b> The MySQL-password has not been replaced for security reasons.<br />Please replace "MYSQL_PASSWORD" on your own. If you forgot your MySQL-password<br />you\'ll find it in "lib/userdata.inc.php".';
$lng['admin']['configfiles']['commands'] = '<b>Команды:</b> Please execute the following commands in a shell.';
$lng['admin']['configfiles']['restart'] = '<b>Перезапуск:</b> Please execute the following commands in a shell in order to reload the new configuration.';
$lng['admin']['templates']['templates'] = 'Email-шаблоны';
$lng['admin']['templates']['template_add'] = 'Добавить шаблон';
$lng['admin']['templates']['template_edit'] = 'Изменить шаблон';
$lng['admin']['templates']['action'] = 'Действие';
$lng['admin']['templates']['email'] = 'Email и File шаблон';
$lng['admin']['templates']['subject'] = 'Кому';
$lng['admin']['templates']['mailbody'] = 'Текст письма';
$lng['admin']['templates']['createcustomer'] = 'Приветствие нового Клиента!';
$lng['admin']['templates']['pop_success'] = 'Приветственное письмо для нового почтового аккаунта';
$lng['admin']['templates']['template_replace_vars'] = 'Переменные должны быть заменены в шаблоне:';
$lng['admin']['templates']['SALUTATION'] = 'Введите корректные данные (имя или компанию)';
$lng['admin']['templates']['FIRSTNAME'] = 'Заменить фамилию Клиента.';
$lng['admin']['templates']['NAME'] = 'Заменить имя Клиента.';
$lng['admin']['templates']['COMPANY'] = 'Заменить имя компании Клиента';
$lng['admin']['templates']['USERNAME'] = 'Заменить имя пользователя Клиента.';
$lng['admin']['templates']['PASSWORD'] = 'Заменить пароль Клиента.';
$lng['admin']['templates']['EMAIL'] = 'Заменить адрес для POP3/IMAP аккаунта.';
$lng['admin']['webserver'] = 'Web-Сервер';

/**
 * Serversettings
 */

$lng['serversettings']['session_timeout']['title'] = 'Таймаут Сессии';
$lng['serversettings']['session_timeout']['description'] = 'Время жизни сессии пользователя (в секундах)?';
$lng['serversettings']['accountprefix']['title'] = 'Префикс Клиента';
$lng['serversettings']['accountprefix']['description'] = 'Какой Префикс должен быть у аккаунта Клиента?';
$lng['serversettings']['mysqlprefix']['title'] = 'SQL Префикс';
$lng['serversettings']['mysqlprefix']['description'] = 'Какой префикс должен быть у MySQL аккаунтов?</br>Используйте "RANDOM" для использования случайного 3-х сивольного префикса.';
$lng['serversettings']['ftpprefix']['title'] = 'FTP Префикс';
$lng['serversettings']['ftpprefix']['description'] = 'Какой префикс должен использоваться для FTP-аккаунтов?';
$lng['serversettings']['documentroot_prefix']['title'] = 'Домашняя директория';
$lng['serversettings']['documentroot_prefix']['description'] = 'Где должны храниться все Домашние директории?';
$lng['serversettings']['logfiles_directory']['title'] = 'Директория log-файлов';
$lng['serversettings']['logfiles_directory']['description'] = 'Где должны храниться директории log-файлов?';
$lng['serversettings']['ipaddress']['title'] = 'IP-адрес';
$lng['serversettings']['ipaddress']['description'] = 'What\'s the IP-address of this server?';
$lng['serversettings']['hostname']['title'] = 'Hostname';
$lng['serversettings']['hostname']['description'] = 'What\'s the Hostname of this server?';
$lng['serversettings']['apachereload_command']['title'] = 'Webserver reload command';
$lng['serversettings']['apachereload_command']['description'] = 'What\'s the webserver command to reload configfiles?';
$lng['serversettings']['bindenable']['title'] = 'Enable Nameserver';
$lng['serversettings']['bindenable']['description'] = 'Here the Nameserver can be enabled and disabled globaly.';
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
$lng['serversettings']['vmail_homedir']['title'] = 'Mails-homedir';
$lng['serversettings']['vmail_homedir']['description'] = 'Where should all mails be stored?';
$lng['serversettings']['adminmail']['title'] = 'Sender';
$lng['serversettings']['adminmail']['description'] = 'What\'s the sender address for emails sent from the Panel?';
$lng['serversettings']['phpmyadmin_url']['title'] = 'phpMyAdmin URL';
$lng['serversettings']['phpmyadmin_url']['description'] = 'What\'s the URL to phpMyAdmin? (has to start with http(s)://)';
$lng['serversettings']['webmail_url']['title'] = 'Webmail URL';
$lng['serversettings']['webmail_url']['description'] = 'What\'s the URL to webmail? (has to start with http(s)://)';
$lng['serversettings']['webftp_url']['title'] = 'WebFTP URL';
$lng['serversettings']['webftp_url']['description'] = 'What\'s the URL to  WebFTP? (has to start with http(s)://)';
$lng['serversettings']['language']['description'] = 'What\'s your standard server language?';
$lng['serversettings']['maxloginattempts']['title'] = 'Max Login Attempts';
$lng['serversettings']['maxloginattempts']['description'] = 'Maximum login attempts after which the account gets disabled.';
$lng['serversettings']['deactivatetime']['title'] = 'Deactivation Time';
$lng['serversettings']['deactivatetime']['description'] = 'Time (sec.) an account gets disabled after too many login tries.';
$lng['serversettings']['pathedit']['title'] = 'Type of path input';
$lng['serversettings']['pathedit']['description'] = 'Should a path be selected by a dropdown menu or by an input field?';
$lng['serversettings']['nameservers']['title'] = 'Nameservers';
$lng['serversettings']['nameservers']['description'] = 'A comma separated list containing the hostnames of all nameservers. The first one will be the primary one.';
$lng['serversettings']['mxservers']['title'] = 'MX servers';
$lng['serversettings']['mxservers']['description'] = 'A comma seperated list containing a pair of a number and a hostname separated by whitespace (e.g. \'10 mx.example.com\') containing the mx servers.';

/**
 * CHANGED BETWEEN 1.2.12 and 1.2.13
 */

$lng['mysql']['description'] = 'Here you can create and change your MySQL-databases.<br />The changes are made instantly and the database can be used immediately.<br />At the menu on the left side you find the tool phpMyAdmin with which you can easily administer your database.<br /><br />To use your databases in your own php-scripts use the following settings: (The data in <i>italics</i> have to be changed into the equivalents you typed in!)<br />Hostname: <b><SQL_HOST></b><br />Username: <b><i>databasename</i></b><br />Password: <b><i>the password you\'ve chosen</i></b><br />Database: <b><i>databasename</i></b>';

/**
 * ADDED BETWEEN 1.2.12 and 1.2.13
 */

lng['serversettings']['paging']['title'] = 'Кол-во записей на страницу';
$lng['serversettings']['paging']['description'] = 'Сколько записей показывать на одной странице? (0 = отключить разбивание на страницы)';
$lng['error']['ipstillhasdomains'] = 'Комбинация IP и порта, которую вы хотите удалить, ещё прописана для минимум одного домена. Пожалуйста измените у доменов комбинацию IP и порта на другую, чтобы можно было удалить эту.';
$lng['error']['cantdeletedefaultip'] = 'Вы не можете удалить стандартную для посредников комбинацию IP и порта. Пожулуйста установите другую комбинацию IP и порта как "по умолчанию", чтобы можно было удалить эту..';
$lng['error']['cantdeletesystemip'] = 'Вы не можете удалить последний адрес IP в системе. Создайте новую комбинацию IP и порта для системного IP или измените IP системы.';
$lng['error']['myipaddress'] = '\'IP\'';
$lng['error']['myport'] = '\'порт\'';
$lng['error']['myipdefault'] = 'Вам необходимо быврать комбинацию IP и порта, которая станет стандартной комбинацией по умолчанию.';
$lng['error']['myipnotdouble'] = 'Эта комбинация IP и порта уже существует.';
$lng['question']['admin_ip_reallydelete'] = 'Вы уверены, что хотите удалить IP %s?';
$lng['admin']['ipsandports']['ipsandports'] = 'IP-адреса и порты';
$lng['admin']['ipsandports']['add'] = 'Добавить комбинацию IP/порт';
$lng['admin']['ipsandports']['edit'] = 'Редактировать комбинацию IP/порт';
$lng['admin']['ipsandports']['ipandport'] = 'IP/порт';
$lng['admin']['ipsandports']['ip'] = 'IP';
$lng['admin']['ipsandports']['port'] = 'Порт'

// ADDED IN 1.2.13-rc3

$lng['error']['cantchangesystemip'] = 'You cannot change the last system IP, either create another new IP/Port combination for the system IP or change the system IP.';
$lng['question']['admin_domain_reallydocrootoutofcustomerroot'] = 'Are you sure, you want the document root for this domain, not being within the customer root of the customer?';

// ADDED IN 1.2.14-rc1

$lng['admin']['memorylimitdisabled'] = 'Отключено';
$lng['domain']['openbasedirpath'] = 'OpenBasedir-путь';
$lng['domain']['docroot'] = 'Path from field above';
$lng['domain']['homedir'] = 'Домашняя директория';
$lng['admin']['valuemandatory'] = 'Обязательное значение';
$lng['admin']['valuemandatorycompany'] = 'Каждое поле "имя", "фамилия" или "компания" должно быть заполнено' ;
$lng['menue']['main']['username'] = 'Вы вошли как: ';
$lng['panel']['urloverridespath'] = 'URL (overrides path)';
$lng['panel']['pathorurl'] = 'Путь или URL';
$lng['error']['sessiontimeoutiswrong'] = 'Only numerical "session timeout" is allowed.';
$lng['error']['maxloginattemptsiswrong'] = 'Only numerical "max login attempts" are allowed.';
$lng['error']['deactivatetimiswrong'] = 'Only numerical "deactivation time" is allowed.';
$lng['error']['accountprefixiswrong'] = '"customerprefix" неверный.';
$lng['error']['mysqlprefixiswrong'] = '"SQL prefix" неверный.';
$lng['error']['ftpprefixiswrong'] = '"FTP prefix" неверный.';
$lng['error']['ipiswrong'] = '"IP-address" неверный. Разрешается только действительный IP-address.';
$lng['error']['vmailuidiswrong'] = 'The "mails-uid" is wrong. Only a numerical UID is allowed.';
$lng['error']['vmailgidiswrong'] = 'The "mails-gid" is wrong. Only a numerical GID is allowed.';
$lng['error']['adminmailiswrong'] = '"sender-address" неверный. Разрешается только действительный email-адрес.';
$lng['error']['pagingiswrong'] = 'The "entries per page"-value is wrong. Only numerical characters are allowed.';
$lng['error']['phpmyadminiswrong'] = 'The phpMyAdmin-link is not a valid link.';
$lng['error']['webmailiswrong'] = 'Недопустимая ссылка на webmail.';
$lng['error']['webftpiswrong'] = 'Недопустимая ссылка на WebFTP.';
$lng['domains']['hasaliasdomains'] = 'Has alias domain(s)';
$lng['serversettings']['defaultip']['title'] = 'IP-порт по умолчанию.';
$lng['serversettings']['defaultip']['description'] = 'Комбинация IP-порта по умолчанию.';
$lng['domains']['statstics'] = 'Статистика использования сервера';
$lng['panel']['ascending'] = 'восходящий';
$lng['panel']['decending'] = 'нисходящий';
$lng['panel']['search'] = 'Поиск';
$lng['panel']['used'] = 'Использование';

// ADDED IN 1.2.14-rc3

$lng['panel']['translator'] = 'Переводчик';

// ADDED IN 1.2.14-rc4

$lng['error']['stringformaterror'] = 'Обозначение в поле "%s" - недопустимый формат.';

// ADDED IN 1.2.15-rc1

$lng['admin']['serversoftware'] = 'Программное обеспечение сервера';
$lng['admin']['phpversion'] = 'Версия PHP';
$lng['admin']['mysqlserverversion'] = 'Версия сервера MySQL';
$lng['admin']['webserverinterface'] = 'Интерфейс вебсервера';
$lng['domains']['isassigneddomain'] = 'Назначенный домен';
$lng['serversettings']['phpappendopenbasedir']['title'] = 'Пути добавления к OpenBasedir';
$lng['serversettings']['phpappendopenbasedir']['description'] = 'Эти пути (разделенные двоеточиями) будут добавлены к OpenBasedir-заявлению в каждом vHost-container.';

// CHANGED IN 1.2.15-rc1

$lng['error']['loginnameissystemaccount'] = 'Вы не можете создавать учетные записи, которые похожи на системные учетные записи (как те, которые начинаются с "%s"). Пожалуйста, введите другое имя учетной записи.';
$lng['error']['youcantdeleteyourself'] = 'Вы не можете удалять себя по соображениям безопасности.';
$lng['error']['youcanteditallfieldsofyourself'] = 'Примечание: Вы не можете редактировать все поля своего аккаунта по соображениям безопасности.';

// ADDED IN 1.2.16-svn1

$lng['serversettings']['natsorting']['title'] = 'Use natural human sorting in list view';
$lng['serversettings']['natsorting']['description'] = 'Sorts lists as web1 -> web2 -> web11 instead of web1 -> web11 -> web2.';

// ADDED IN 1.2.16-svn2

$lng['serversettings']['deactivateddocroot']['title'] = 'Docroot for deactivated users';
$lng['serversettings']['deactivateddocroot']['description'] = 'When a user is deactivated this path is used as his docroot. Leave empty for not creating a vHost at all.';

// ADDED IN 1.2.16-svn4

$lng['panel']['reset'] = 'discard changes';
$lng['admin']['accountsettings'] = 'Настройка аккаунта';
$lng['admin']['panelsettings'] = 'Настройки панели';
$lng['admin']['systemsettings'] = 'Системные настройки';
$lng['admin']['webserversettings'] = 'Настройки web-сервера';
$lng['admin']['mailserversettings'] = 'Настройки почтового сервера';
$lng['admin']['nameserversettings'] = 'Настройка сервера имен';
$lng['admin']['updatecounters'] = 'Пересчитать используемые ресурсы';
$lng['question']['admin_counters_reallyupdate'] = 'Вы действительно хотите пересчитать используемые ресурсы?';
$lng['panel']['pathDescription'] = 'Если каталог не муществует, то он будет создан автоматически.';
$lng['panel']['pathDescriptionEx'] = '<br /><br />If you want a redirect to another domain than this entry has to start with http:// or https://.';
$lng['panel']['pathDescriptionSubdomain'] = $lng['panel']['pathDescription'].$lng['panel']['pathDescriptionEx']."<br /><br />Если URL заканчивается / то он считается папкой, иначе, он будет рассмотрен как файл.";

// ADDED IN 1.2.16-svn6

$lng['admin']['templates']['TRAFFIC'] = 'Replaced with the traffic in mB, which was assigned to the customer.';
$lng['admin']['templates']['TRAFFICUSED'] = 'Replaced with the traffic in MB, which was exhausted by the customer.';

// ADDED IN 1.2.16-svn7

$lng['admin']['subcanemaildomain']['never'] = 'Никогда';
$lng['admin']['subcanemaildomain']['choosableno'] = 'Choosable, default no';
$lng['admin']['subcanemaildomain']['choosableyes'] = 'Choosable, default yes';
$lng['admin']['subcanemaildomain']['always'] = 'Всегда';
$lng['changepassword']['also_change_webalizer'] = 'также изменить пароль странице статистики';

// ADDED IN 1.2.16-svn8

$lng['serversettings']['mailpwcleartext']['title'] = 'Сохранить пароли учетных записей электронной почты в открытом виде в базе данных';
$lng['serversettings']['mailpwcleartext']['description'] = 'Если этот параметр установлен на да, все пароли также будут сохранены в незашифрованном виде (открытый текст, простой читаемый для всех, с доступом к базе данных) в mail_users. Включите, если вы собираетесь использовать SASL!';
$lng['serversettings']['mailpwcleartext']['removelink'] = 'Кликните здесь, чтобы стереть все незашифрованные пароли из таблицы.';
$lng['question']['admin_cleartextmailpws_reallywipe'] = 'Вы действительно хотите стереть все незашифрованные пароли учетной записи электронной почты из таблицы mail_users? Это необратимая операция!';
$lng['admin']['configfiles']['overview'] = 'Обзор';
$lng['admin']['configfiles']['wizard'] = 'Мастер';
$lng['admin']['configfiles']['distribution'] = 'Дистрибутив';
$lng['admin']['configfiles']['service'] = 'Служба';
$lng['admin']['configfiles']['daemon'] = 'Демон';
$lng['admin']['configfiles']['http'] = 'Web-сервер (HTTP)';
$lng['admin']['configfiles']['dns'] = 'Сервер имен (DNS)';
$lng['admin']['configfiles']['mail'] = 'Почтовый сервер (IMAP/POP3)';
$lng['admin']['configfiles']['smtp'] = 'Почтовый сервер (SMTP)';
$lng['admin']['configfiles']['ftp'] = 'FTP-сервер';
$lng['admin']['configfiles']['etc'] = 'Другое (Система)';
$lng['admin']['configfiles']['choosedistribution'] = '-- Выбрать дистрибутив --';
$lng['admin']['configfiles']['chooseservice'] = '-- Выбрать службу --';
$lng['admin']['configfiles']['choosedaemon'] = '-- Выбрать демон --';

// ADDED IN 1.2.16-svn10

$lng['serversettings']['ftpdomain']['title'] = 'FTP аккаунт @domain.com';
$lng['serversettings']['ftpdomain']['description'] = 'Клиент может создавать FTP аккаунты вида user@domain.com?';
$lng['panel']['back'] = 'Назад';

// ADDED IN 1.2.16-svn12

$lng['serversettings']['mod_fcgid']['title'] = 'Включить FCGID';
$lng['serversettings']['mod_fcgid']['description'] = 'Use this to run PHP with the corresponding useraccount.<br /><br /><b>This needs a special webserver configuration for Apache, see <a target="blank" href="http://redmine.froxlor.org/projects/froxlor/wiki/HandbookApache2_fcgid">FCGID - handbook</a></b>';
$lng['serversettings']['sendalternativemail']['title'] = 'Use alternative email-address';
$lng['serversettings']['sendalternativemail']['description'] = 'Send the password-email to a different address during email-account-creation';
$lng['emails']['alternative_emailaddress'] = 'Alternative e-mail-address';
$lng['mails']['pop_success_alternative']['mailbody'] = 'Hello,\n\nyour Mail account {EMAIL}\nwas set up successfully.\nYour password is {PASSWORD}.\n\nThis is an automatically created\ne-mail, please do not answer!\n\nYours sincerely, your administrator';
$lng['mails']['pop_success_alternative']['subject'] = 'Mail account set up successfully';
$lng['admin']['templates']['pop_success_alternative'] = 'Welcome mail for new email accounts sent to alternative address';
$lng['admin']['templates']['EMAIL_PASSWORD'] = 'Replaced with the POP3/IMAP account password.';

// ADDED IN 1.2.16-svn13

$lng['error']['documentrootexists'] = 'Директория "%s" уже сучествует для Клиента. Пожалуйста, удалите ее, прежде чем снова добавить Клиента';

// ADDED IN 1.2.16-svn14

$lng['serversettings']['apacheconf_vhost']['title'] = 'Web-сервер vHost файл/папка настроек.';
$lng['serversettings']['apacheconf_vhost']['description'] = 'Где должны храниться файлы конфигурации виртуального хоста? Вы можете либо указать файл (для всех виртуальных хостов в одном файле) или каталог (каждый виртуальный хост в собственном файле).';
$lng['serversettings']['apacheconf_diroptions']['title'] = 'Файл конфигурации Web-сервера/каталог';
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
$lng['admin']['ticketsystem'] = 'Support-tickets';
$lng['menue']['ticket']['ticket'] = 'Support tickets';
$lng['menue']['ticket']['categories'] = 'Support categories';
$lng['menue']['ticket']['archive'] = 'Ticket-archive';
$lng['ticket']['description'] = 'Here you can send help-requests to your responsible administrator.<br />Notifications will be sent via e-mail.';
$lng['ticket']['ticket_new'] = 'Open a new ticket';
$lng['ticket']['ticket_reply'] = 'Answer ticket';
$lng['ticket']['ticket_reopen'] = 'Reopen ticket';
$lng['ticket']['ticket_newcateory'] = 'Create new category';
$lng['ticket']['ticket_editcateory'] = 'Edit category';
$lng['ticket']['ticket_view'] = 'View ticketcourse';
$lng['ticket']['ticketcount'] = 'Tickets';
$lng['ticket']['ticket_answers'] = 'Replies';
$lng['ticket']['lastchange'] = 'Last action';
$lng['ticket']['subject'] = 'Subject';
$lng['ticket']['status'] = 'Status';
$lng['ticket']['lastreplier'] = 'Last replier';
$lng['ticket']['priority'] = 'Priority';
$lng['ticket']['low'] = 'Low';
$lng['ticket']['normal'] = 'Normal';
$lng['ticket']['high'] = 'High';
$lng['ticket']['lastchange'] = 'Last change';
$lng['ticket']['lastchange_from'] = 'From date (dd.mm.yyyy)';
$lng['ticket']['lastchange_to'] = 'To date (dd.mm.yyyy)';
$lng['ticket']['category'] = 'Category';
$lng['ticket']['no_cat'] = 'None';
$lng['ticket']['message'] = 'Message';
$lng['ticket']['show'] = 'View';
$lng['ticket']['answer'] = 'Answer';
$lng['ticket']['close'] = 'Close';
$lng['ticket']['reopen'] = 'Re-open';
$lng['ticket']['archive'] = 'Archive';
$lng['ticket']['ticket_delete'] = 'Delete ticket';
$lng['ticket']['lastarchived'] = 'Recently archived tickets';
$lng['ticket']['archivedtime'] = 'Archived';
$lng['ticket']['open'] = 'Open';
$lng['ticket']['wait_reply'] = 'Waiting for reply';
$lng['ticket']['replied'] = 'Replied';
$lng['ticket']['closed'] = 'Closed';
$lng['ticket']['staff'] = 'Staff';
$lng['ticket']['customer'] = 'Customer';
$lng['ticket']['old_tickets'] = 'Ticket messages';
$lng['ticket']['search'] = 'Search archive';
$lng['ticket']['nocustomer'] = 'No choice';
$lng['ticket']['archivesearch'] = 'Archive searchresults';
$lng['ticket']['noresults'] = 'No tickets found';
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
$lng['error']['norepymailiswrong'] = 'The "Noreply-address" is wrong. Only a valid email-address is allowed.';
$lng['error']['tadminmailiswrong'] = 'The "Ticketadmin-address" is wrong. Only a valid email-address is allowed.';
$lng['ticket']['awaitingticketreply'] = 'You have %s unanswered support-ticket(s)';

// ADDED IN 1.2.18-svn5

$lng['serversettings']['ticket']['noreply_name'] = 'Ticket e-mail sendername';

// ADDED IN 1.2.19-svn1

$lng['serversettings']['mod_fcgid']['configdir']['title'] = 'Configuration directory';
$lng['serversettings']['mod_fcgid']['configdir']['description'] = 'Where should all fcgid-configuration files be stored? If you don\'t use a self compiled suexec binary, which is the normal situation, this path must be under /var/www/<br /><br /><div style="color:red">NOTE: This folder\'s content gets deleted regulary so avoid storing data in there manually.</div>';
$lng['serversettings']['mod_fcgid']['tmpdir']['title'] = 'Temp directory';

// ADDED IN 1.2.19-svn3

$lng['serversettings']['ticket']['reset_cycle']['title'] = 'Reset used tickets cycle';
$lng['serversettings']['ticket']['reset_cycle']['description'] = 'Reset the customers used ticket counter to 0 in the chosen cycle';
$lng['admin']['tickets']['daily'] = 'Daily';
$lng['admin']['tickets']['weekly'] = 'Weekly';
$lng['admin']['tickets']['monthly'] = 'Monthly';
$lng['admin']['tickets']['yearly'] = 'Yearly';
$lng['error']['ticketresetcycleiswrong'] = 'The cycle for ticket-resets has to be "daily", "weekly", "monthly" or "yearly".';

// ADDED IN 1.2.19-svn4

$lng['menue']['traffic']['traffic'] = 'Траффик';
$lng['menue']['traffic']['current'] = 'Текущий месяц';
$lng['traffic']['month'] = "Месяц";
$lng['traffic']['day'] = "День";
$lng['traffic']['months'][1] = "Январь";
$lng['traffic']['months'][2] = "Февраль";
$lng['traffic']['months'][3] = "Март";
$lng['traffic']['months'][4] = "Апрель";
$lng['traffic']['months'][5] = "Май";
$lng['traffic']['months'][6] = "Июнь";
$lng['traffic']['months'][7] = "Июль";
$lng['traffic']['months'][8] = "Август";
$lng['traffic']['months'][9] = "Сентябрь";
$lng['traffic']['months'][10] = "Октябрь";
$lng['traffic']['months'][11] = "Ноябрь";
$lng['traffic']['months'][12] = "Декабрь";
$lng['traffic']['mb'] = "Траффик (MB)";
$lng['traffic']['distribution'] = '<font color="#019522">FTP</font> | <font color="#0000FF">HTTP</font> | <font color="#800000">Mail</font>';
$lng['traffic']['sumhttp'] = 'Общий HTTP-Траффик';
$lng['traffic']['sumftp'] = 'Общий FTP-Траффик';
$lng['traffic']['summail'] = 'Общий Mail-Траффик';

// ADDED IN 1.2.19-svn4.5

$lng['serversettings']['no_robots']['title'] = 'Allow searchengine-robots to index your Froxlor installation';

// ADDED IN 1.2.19-svn6

$lng['admin']['loggersettings'] = 'Log settings';
$lng['serversettings']['logger']['enable'] = 'Logging enabled/disabled';
$lng['serversettings']['logger']['severity'] = 'Logging level';
$lng['admin']['logger']['normal'] = 'normal';
$lng['admin']['logger']['paranoid'] = 'paranoid';
$lng['serversettings']['logger']['types']['title'] = 'Log-type(s)';
$lng['serversettings']['logger']['types']['description'] = 'Specify logtypes. To select multiple types, hold down CTRL while selecting.<br />Available logtypes are: syslog, file, mysql';
$lng['serversettings']['logger']['logfile'] = 'Logfile path including filename';
$lng['error']['logerror'] = 'Log-Error: %s';
$lng['serversettings']['logger']['logcron'] = 'Log cronjobs (one run)';
$lng['question']['logger_reallytruncate'] = 'Do you really want to truncate the table "%s"?';
$lng['admin']['loggersystem'] = 'System-logging';
$lng['menue']['logger']['logger'] = 'System-logging';
$lng['logger']['date'] = 'Date';
$lng['logger']['type'] = 'Type';
$lng['logger']['action'] = 'Action';
$lng['logger']['user'] = 'User';
$lng['logger']['truncate'] = 'Empty log';

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
$lng['dkim']['use_dkim']['description'] = 'Would you like to use the Domain Keys (DKIM) system?<br/><em style="color:red;font-weight:bold;">Note: DKIM is only supported using dkim-filter, not opendkim (yet)</em>';
$lng['error']['invalidmysqlhost'] = 'Invalid MySQL host address: %s';
$lng['error']['cannotuseawstatsandwebalizeratonetime'] = 'You cannot enable Webalizer and AWstats at the same time, please chose one of them';
$lng['serversettings']['webalizer_enabled'] = 'Enable webalizer statistics';
$lng['serversettings']['awstats_enabled'] = 'Enable AWstats statistics';
$lng['admin']['awstatssettings'] = 'AWstats settings';

// ADDED IN 1.2.19-svn16

$lng['admin']['domain_dns_settings'] = 'Domain dns settings';
$lng['dns']['destinationip'] = 'Domain IP(s)';
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
$lng['serversettings']['selfdnscustomer']['title'] = 'Allow customers to edit domain dns settings';
$lng['admin']['activated'] = 'Activated';
$lng['admin']['statisticsettings'] = 'Statistic settings';
$lng['admin']['or'] = 'or';

// ADDED IN 1.2.19-svn17

$lng['serversettings']['unix_names']['title'] = 'Use UNIX compatible usernames';
$lng['serversettings']['unix_names']['description'] = 'Allows you to use <strong>-</strong> and <strong>_</strong> in usernames if <strong>No</strong>';
$lng['error']['cannotwritetologfile'] = 'Cannot open logfile %s for writing';
$lng['admin']['sysload'] = 'System load';
$lng['admin']['noloadavailable'] = 'not available';
$lng['admin']['nouptimeavailable'] = 'not available';
$lng['panel']['backtooverview'] = 'Back to overview';
$lng['admin']['nosubject'] = '(No Subject)';
$lng['admin']['configfiles']['statistics'] = 'Statistics';
$lng['login']['forgotpwd'] = 'Forgot your password?';
$lng['login']['presend'] = 'Reset password';
$lng['login']['email'] = 'E-mail address';
$lng['login']['remind'] = 'Reset my password';
$lng['login']['usernotfound'] = 'User not found!';
$lng['pwdreminder']['subject'] = 'Froxlor - Password reset';
$lng['pwdreminder']['body'] = 'Hello %s,\n\nhere is your link for setting a new password. This link is valid for the next 24 hours.\n\n%a\n\nThank you,\nyour administrator';
$lng['pwdreminder']['success'] = 'Password reset successfully requested. Please follow the instructions in the email you received.';

// ADDED IN 1.2.19-svn18

$lng['serversettings']['allow_password_reset']['title'] = 'Allow password reset by customers';
$lng['pwdreminder']['notallowed'] = 'Password reset is disabled';

// ADDED IN 1.2.19-svn21

$lng['customer']['title'] = 'Title';
$lng['customer']['country'] = 'Country';
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

$lng['serversettings']['allow_password_reset']['description'] = 'Customers can reset their password and an activation link will be sent to their e-mail address';
$lng['serversettings']['allow_password_reset_admin']['title'] = 'Allow password reset by admins';
$lng['serversettings']['allow_password_reset_admin']['description'] = 'Admins/reseller can reset their password and an activation link will be sent to their e-mail address';

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

$lng['menue']['phpsettings']['maintitle'] = 'PHP Configurations';
$lng['admin']['phpsettings']['title'] = 'PHP Configuration';
$lng['admin']['phpsettings']['description'] = 'Short description';
$lng['admin']['phpsettings']['actions'] = 'Actions';
$lng['admin']['phpsettings']['activedomains'] = 'In use for domain(s)';
$lng['admin']['phpsettings']['notused'] = 'Configuration not in use';
$lng['admin']['misc'] = 'Miscellaneous';
$lng['admin']['phpsettings']['editsettings'] = 'Change PHP settings';
$lng['admin']['phpsettings']['addsettings'] = 'Create new PHP settings';
$lng['admin']['phpsettings']['viewsettings'] = 'View PHP settings';
$lng['admin']['phpsettings']['phpinisettings'] = 'php.ini settings';
$lng['error']['nopermissionsorinvalidid'] = 'You don\'t have enough permissions to change these settings or an invalid id was given.';
$lng['panel']['view'] = 'view';
$lng['question']['phpsetting_reallydelete'] = 'Do you really want to delete these settings? All domains which use these settings currently will be changed to the default config.';
$lng['admin']['phpsettings']['addnew'] = 'Create new settings';
$lng['error']['phpsettingidwrong'] = 'A PHP Configuration with this id doesn\'t exist';
$lng['error']['descriptioninvalid'] = 'The description is too short, too long or contains illegal characters.';
$lng['error']['info'] = 'Info';
$lng['admin']['phpconfig']['template_replace_vars'] = 'Variables that will be replaced in the configs';
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
$lng['serversettings']['mod_fcgid']['starter']['title'] = 'Processes per Domain';
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

$lng['admin']['phpserversettings'] = 'PHP Settings';
$lng['admin']['phpsettings']['binary'] = 'PHP Binary';
$lng['admin']['phpsettings']['file_extensions'] = 'File extensions';
$lng['admin']['phpsettings']['file_extensions_note'] = '(without dot, separated by spaces)';
$lng['admin']['mod_fcgid_maxrequests']['title'] = 'Maximum php requests for this domain (empty for default value)';
$lng['serversettings']['mod_fcgid']['maxrequests']['title'] = 'Maximum Requests per domain';
$lng['serversettings']['mod_fcgid']['maxrequests']['description'] = 'How many requests should be allowed per domain?';

// fix bug #1124
$lng['admin']['webserver'] = 'Webserver';
$lng['error']['admin_domain_emailsystemhostname'] = 'The server-hostname cannot be used as email-domain.';

// ADDED IN 1.4.2.1-1

$lng['mysql']['mysql_server'] = 'MySQL-Server';

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
$lng['error']['errorwhensaving'] = 'An error occured when saving the field %s';

$lng['success']['success'] = 'Information';
$lng['success']['clickheretocontinue'] = 'Click here to continue';
$lng['success']['settingssaved'] = 'The settings have been successfully saved.';

// ADDED IN FROXLOR 0.9

$lng['admin']['spfsettings'] = 'Domain SPF settings';
$lng['spf']['use_spf'] = 'Activate SPF for domains?';
$lng['spf']['spf_entry'] = 'SPF entry for all domains';
$lng['panel']['dirsmissing'] = 'The given directory could not be found.';
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
$lng['dkim']['dkim_algorithm']['title'] = 'Allowed Hash Algorithms';
$lng['dkim']['dkim_algorithm']['description'] = 'Define allowed hash algorithms, chose "All" for all algorithms or one or more from the other available algorithms';
$lng['dkim']['dkim_servicetype'] = 'Service Types';
$lng['dkim']['dkim_keylength']['title'] = 'Key-length';
$lng['dkim']['dkim_keylength']['description'] = 'Attention: If you change this values, you need to delete all the private/public keys in "%s"';
$lng['dkim']['dkim_notes']['title'] = 'DKIM Notes';
$lng['dkim']['dkim_notes']['description'] = 'Notes that might be of interest to a human, e.g. a URL like http://www.dnswatch.info. No interpretation is made by any program. This tag should be used sparingly due to space limitations in DNS. This is intended for use by administrators, not end users.';
$lng['dkim']['dkim_add_adsp']['title'] = 'Add DKIM ADSP entry';
$lng['dkim']['dkim_add_adsp']['description'] = 'If you don\'t know what this is, leave it "enabled"';
$lng['dkim']['dkim_add_adsppolicy']['title'] = 'ADSP policy';
$lng['dkim']['dkim_add_adsppolicy']['description'] = 'For more information about this setting see <a target="blank" href="http://redmine.froxlor.org/projects/froxlor/wiki/En-dkim-adsp-policies">DKIM ADSP policies</a>';

$lng['admin']['cron']['cronsettings'] = 'Cronjob settings';
$lng['cron']['cronname'] = 'cronjob-name';
$lng['cron']['lastrun'] = 'last run';
$lng['cron']['interval'] = 'interval';
$lng['cron']['isactive'] = 'enabled';
$lng['cron']['description'] = 'description';
$lng['crondesc']['cron_unknown_desc'] = 'no description given';
$lng['admin']['cron']['add'] = 'Add cronjob';
$lng['crondesc']['cron_tasks'] = 'generating of configfiles';
$lng['crondesc']['cron_legacy'] = 'legacy (old) cronjob';
$lng['crondesc']['cron_traffic'] = 'traffic calculation';
$lng['crondesc']['cron_ticketsreset'] = 'resetting ticket-counters';
$lng['crondesc']['cron_ticketarchive'] = 'archiving old tickets';
$lng['cronmgmt']['minutes'] = 'minutes';
$lng['cronmgmt']['hours'] = 'hours';
$lng['cronmgmt']['days'] = 'days';
$lng['cronmgmt']['weeks'] = 'weeks';
$lng['cronmgmt']['months'] = 'months';
$lng['admin']['cronjob_edit'] = 'Edit cronjob';
$lng['cronjob']['cronjobsettings'] = 'Cronjob settings';
$lng['cronjob']['cronjobintervalv'] = 'Runtime interval value';
$lng['cronjob']['cronjobinterval'] = 'Runtime interval';
$lng['panel']['options'] = 'Options';
$lng['admin']['warning'] = 'WARNING - Please note!';
$lng['cron']['changewarning'] = 'Changing these values can have a negative cause to the behavior of Froxlor and its automated tasks.<br /><br />Please only change values here, if you are sure you know what you are doing.';

$lng['serversettings']['stdsubdomainhost']['title'] = 'Customer standard subdomain';
$lng['serversettings']['stdsubdomainhost']['description'] = 'What hostname should be used to create standard subdomains for customer. If empty, the system-hostname is used.';

// ADDED IN FROXLOR 0.9.4-svn1
$lng['ftp']['account_edit'] = 'Edit ftp account';
$lng['ftp']['editpassdescription'] = 'Set new password or leave blank for no change.';
$lng['customer']['sendinfomail'] = 'Send data via email to me';
$lng['customer']['mysql_add']['infomail_subject'] = '[Froxlor] New database created';
$lng['customer']['mysql_add']['infomail_body']['main'] = "Hello {CUST_NAME},\n\nyou have just added a new database. Here is the entered information:\n\nDatabasename: {DB_NAME}\nPassword: {DB_PASS}\nDescription: {DB_DESC}\nDB-Hostname: {DB_SRV}\nphpMyAdmin: {PMA_URI}\nYours sincerely, your administrator";
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
$lng['serversettings']['defaultwebsrverrhandler_err401']['description'] = '<div style="color:red">Not supported in: lighttpd</div>';
$lng['serversettings']['defaultwebsrverrhandler_err403']['title'] = 'File/URL for error 403';
$lng['serversettings']['defaultwebsrverrhandler_err403']['description'] = '<div style="color:red">Not supported in: lighttpd</div>';
$lng['serversettings']['defaultwebsrverrhandler_err404'] = 'File/URL for error 404';
$lng['serversettings']['defaultwebsrverrhandler_err500']['title'] = 'File/URL for error 500';
$lng['serversettings']['defaultwebsrverrhandler_err500']['description'] = '<div style="color:red">Not supported in: lighttpd</div>';

// ADDED IN FROXLOR 0.9.6-svn4
$lng['serversettings']['ticket']['default_priority'] = 'Default support-ticket priority';

// ADDED IN FROXLOR 0.9.6-svn5
$lng['serversettings']['mod_fcgid']['defaultini'] = 'Default PHP configuration for new domains';

// ADDED IN FROXLOR 0.9.6-svn6
$lng['admin']['ftpserver'] = 'FTP Server';
$lng['admin']['ftpserversettings'] = 'FTP Server settings';
$lng['serversettings']['ftpserver']['desc'] = 'If pureftpd is selected the .ftpquota files for user quotas are created and updated daily';

// CHANGED IN FROXLOR 0.9.6-svn6
$lng['serversettings']['ftpprefix']['description'] = 'Which prefix should ftp accounts have?<br/><b>If you change this you also have to change the Quota SQL Query in your FTP Server config file in case you use it!</b> ';

// ADDED IN FROXLOR 0.9.7-svn1
$lng['customer']['ftp_add']['infomail_subject'] = '[Froxlor] New ftp-user created';
$lng['customer']['ftp_add']['infomail_body']['main'] = "Hello {CUST_NAME},\n\nyou have just added a new ftp-user. Here is the entered information:\n\nUsername: {USR_NAME}\nPassword: {USR_PASS}\nPath: {USR_PATH}\n\nYours sincerely, your administrator";
$lng['domains']['redirectifpathisurl'] = 'Redirect code (default: empty)';
$lng['domains']['redirectifpathisurlinfo'] = 'You only need to select one of these if you entered an URL as path';
$lng['serversettings']['customredirect_enabled']['title'] = 'Allow customer redirects';
$lng['serversettings']['customredirect_enabled']['description'] = 'Allow customers to choose the http-status code for redirects which will be used';
$lng['serversettings']['customredirect_default']['title'] = 'Default redirect';
$lng['serversettings']['customredirect_default']['description'] = 'Set the default redirect-code which should be used if the customer does not set it himself';

// ADDED IN FROXLOR 0.9.7-svn2
$lng['error']['pathmaynotcontaincolon'] = 'The path you have entered should not contain a colon (":"). Please enter a correct path value.';

// ADDED IN FROXLOR 0.9.7-svn3

// these stay only in english.lng.php - they are the same
// for all other languages and are used if not found there
$lng['redirect_desc']['rc_default'] = 'default';
$lng['redirect_desc']['rc_movedperm'] = 'moved permanently';
$lng['redirect_desc']['rc_found'] = 'found';
$lng['redirect_desc']['rc_seeother'] = 'see other';
$lng['redirect_desc']['rc_tempred'] = 'temporary redirect';

// ADDED IN FROXLOR 0.9.8
$lng['error']['exception'] = '%s';

// ADDED IN FROXLOR 0.9.9-svn1
$lng['serversettings']['mail_also_with_mxservers'] = 'Create mail-, imap-, pop3- and smtp-"A record" also with MX-Servers set';

// ADDED IN FROXLOR 0.9.10-svn1
$lng['admin']['webserver_user'] = 'Webserver user-name';
$lng['admin']['webserver_group'] = 'Webserver group-name';

// ADDED IN FROXLOR 0.9.10
$lng['serversettings']['froxlordirectlyviahostname'] = 'Access Froxlor directly via the hostname';

// ADDED IN FROXLOR 0.9.11-svn1
$lng['serversettings']['panel_password_regex']['title'] = 'Regular expression for passwords';
$lng['serversettings']['panel_password_regex']['description'] = 'Here you can set a regular expression for passwords-complexity.<br />Empty = no specific requirement';
$lng['error']['notrequiredpasswordcomplexity'] = 'The specified password-complexity was not satisfied.<br />Please contact your administrator if you have any questions about the complexity-specification';

// ADDED IN FROXLOR 0.9.11-svn2
$lng['extras']['execute_perl'] = 'Execute perl/CGI';
$lng['admin']['perlenabled'] = 'Perl enabled';

// ADDED IN FROXLOR 0.9.11-svn3
$lng['serversettings']['perl_path']['title'] = 'Path to perl';
$lng['serversettings']['perl_path']['description'] = 'Default is /usr/bin/perl';

// ADDED IN FROXLOR 0.9.12-svn1
$lng['admin']['fcgid_settings'] = 'FCGID';
$lng['serversettings']['mod_fcgid_ownvhost']['title'] = 'Enable FCGID for the Froxlor vHost';
$lng['serversettings']['mod_fcgid_ownvhost']['description'] = 'If enabled, Froxlor will also be running under a local user';
$lng['admin']['mod_fcgid_user'] = 'Local user to use for FCGID (Froxlor vHost)';
$lng['admin']['mod_fcgid_group'] = 'Local group to use for FCGID (Froxlor vHost)';

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
$lng['serversettings']['phpfpm_settings']['start_servers']['description'] = 'Note: Used only when pm is set to \'dynamic/ondemand\'';
$lng['serversettings']['phpfpm_settings']['min_spare_servers']['title'] = 'The desired minimum number of idle server processes';
$lng['serversettings']['phpfpm_settings']['min_spare_servers']['description'] = 'Note: Used only when pm is set to \'dynamic/ondemand\'<br />Note: Mandatory when pm is set to \'dynamic/ondemand\'';
$lng['serversettings']['phpfpm_settings']['max_spare_servers']['title'] = 'The desired maximum number of idle server processes';
$lng['serversettings']['phpfpm_settings']['max_spare_servers']['description'] = 'Note: Used only when pm is set to \'dynamic/ondemand\'<br />Note: Mandatory when pm is set to \'dynamic/ondemand\'';
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
$lng['mails']['webmaxpercent']['mailbody'] = 'Dear {NAME},\n\nyou used {DISKUSED} MB of your available {DISKAVAILABLE} MB of diskspace.\nThis is more than {MAX_PERCENT}%.\n\nYours sincerely, your administrator';
$lng['mails']['webmaxpercent']['subject'] = 'Reaching your diskspace limit';
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
$lng['error']['user_banned'] = 'Your account has been locked. Please contact your administrator for further information.';
$lng['serversettings']['validate_domain'] = 'Validate domain names';
$lng['login']['combination_not_found'] = 'Combination of user and email adress not found.';
$lng['customer']['generated_pwd'] = 'Password suggestion';
$lng['customer']['usedmax'] = 'Used / Max';
$lng['admin']['traffic'] = 'Traffic';
$lng['admin']['domaintraffic'] = 'Domains';
$lng['admin']['customertraffic'] = 'Customers';
$lng['traffic']['customer'] = 'Customer';
$lng['traffic']['domain'] = 'Domain';
$lng['traffic']['trafficoverview'] = 'Traffic summary by';
$lng['traffic']['months']['jan'] = 'Jan';
$lng['traffic']['months']['feb'] = 'Feb';
$lng['traffic']['months']['mar'] = 'Mar';
$lng['traffic']['months']['apr'] = 'Apr';
$lng['traffic']['months']['may'] = 'May';
$lng['traffic']['months']['jun'] = 'Jun';
$lng['traffic']['months']['jul'] = 'Jul';
$lng['traffic']['months']['aug'] = 'Aug';
$lng['traffic']['months']['sep'] = 'Sep';
$lng['traffic']['months']['oct'] = 'Oct';
$lng['traffic']['months']['nov'] = 'Nov';
$lng['traffic']['months']['dec'] = 'Dec';
$lng['traffic']['months']['total'] = 'Total';
$lng['traffic']['details'] = 'Details';
$lng['menue']['traffic']['table'] = 'Traffic';
$lng['error']['admin_domain_emailsystemhostname'] = 'Sorry, the system - hostname may not be used as a customer domain';

// ADDED IN FROXLOR 0.9.21
$lng['gender']['title'] = 'Title';
$lng['gender']['male'] = 'Mr.';
$lng['gender']['female'] = 'Mrs.';
$lng['gender']['undef'] = '';

// Country code (ISO-3166-2)
$lng['country']['AF']="Афганистан";
$lng['country']['AX']="Аландскиеострова";
$lng['country']['AL']="Албания";
$lng['country']['DZ']="Алжир";
$lng['country']['AS']="АмериканскоеСамоа";
$lng['country']['AD']="Андорра";
$lng['country']['АО']="Ангола";
$lng['country']['AN']="Ангилья";
$lng['country']['AQ']="Антарктида";
$lng['country']['AG']="АнтигуаиБарбуда";
$lng['country']['AR']="Аргентина";
$lng['country']['AM']="Армения";
$lng['country']['AW']="Аруба";
$lng['country']['АС']="Австралия";
$lng['country']['AT']="Австрия";
$lng['country']['AZ']="Азербайджан";
$lng['country']['BS']="Багамы";
$lng['country']['ВН']="Бахрейн";
$lng['country']['BD']="Бангладеш";
$lng['country']['BB']="Барбадос";
$lng['country']['ПО']="Беларусь";
$lng['country']['BE']="Бельгия";
$lng['country']['BZ']="Белиз";
$lng['country']['BJ']="Бенин";
$lng['country']['ВМ']="Бермуды";
$lng['country']['BT']="Бутан";
$lng['country']['БО']="Боливия,МногонациональноеГосударство";
$lng['country']['BQ']="Бонайре,Синт-ЭстатиусиСаба";
$lng['country']['BA']="БоснияиГерцеговина";
$lng['country']['BW']="Ботсвана";
$lng['country']['BV']="ОстровБуве";
$lng['country']['BR']="Бразилия";
$lng['country']['IO']="БританскаятерриторияИндийскогоокеана";
$lng['country']['BN']="Бруней-Даруссалам";
$lng['country']['BG']="Болгария";
$lng['country']['BF']="Буркина-Фасо";
$lng['country']['БИ']="Бурунди";
$lng['country']['КН']="Камбоджа";
$lng['country']['СМ']="Камерун";
$lng['country']['CN']="Канада";
$lng['country']['CV']="Кабо-Верде";
$lng['country']['CM']="Каймановыострова";
$lng['country']['CF']="Центрально-АфриканскаяРеспублика»;
$lng['country']['ТД']="Чад";
$lng['country']['CL']="Чили";
$lng['country']['CN']="Китай";
$lng['country']['CX']="ОстровРождества";
$lng['country']['CC']="Кокосовые(Килинг)острова";
$lng['country']['СО']="Колумбия";
$lng['country']['КМ']="Коморы";
$lng['country']['CG']="Конго";
$lng['country']['CD']="Конго,Демократическая Республика";
$lng['country']['СК']="ОстроваКука";
$lng['country']['CR']="Коста-Рика";
$lng['country']['ДИ']="Кот-д'Ивуар";
$lng['country']['HR']="Хорватия";
$lng['country']['CU']="Куба";
$lng['country']['CW']="Кюрасао";
$lng['country']['CY']="Кипр";
$lng['country']['CZ']="Чехия";
$lng['country']['ДК']="Дания";
$lng['country']['DJ']="Джибути";
$lng['country']['ДМ']="Доминика";
$lng['country']['НЕ']="ДоминиканскаяРеспублика";
$lng['country']['ЕК']="Эквадор";
$lng['country']['EG']="Египет";
$lng['country']['SV']="Сальвадор";
$lng['country']['GQ']="ЭкваториальнаяГвинея";
$lng['country']['ER']="Эритрея";
$lng['country']['EE']="Эстония";
$lng['country']['ET']="Эфиопия";
$lng['country']['ФК']="Фолклендские(Мальвинские)";
$lng['country']['FO']="Фарерскиеострова";
$lng['country']['FJ']="Фиджи";
$lng['country']['FI']="Финляндия";
$lng['country']['FR']="Франция";
$lng['country']['GF']="ФранцузскаяГвиана";
$lng['country']['PF']="ФранцузскаяПолинезия";
$lng['country']['TF']="Французскиеюжныетерритории";
$lng['country']['GA']="Габон";
$lng['country']['GM']="Гамбия";
$lng['country']['GE']="Грузия";
$lng['country']['DE']="Германия";
$lng['country']['GH']="Гана";
$lng['country']['GB']="Гибралтар";
$lng['country']['GR']="Греция";
$lng['country']['GL']="Гренландия";
$lng['country']['GD']="Гренада";
$lng['country']['GL']="Гваделупа";
$lng['country']['GU']="Гуам";
$lng['country']['GT']="Гватемала";
$lng['country']['GG']="Гернси";
$lng['country']['GN']="Гвинея";
$lng['country']['GW']="Гвинея-Бисау";
$lng['country']['GY']="Гайана";
$lng['country']['HT']="Гаити";
$lng['country']['HM']="ОстровХердиостроваМакдональд";
$lng['country']['VA']="СвятойПрестол(Ватикан)";
$lng['country']['HN']="Гондурас";
$lng['country']['HK']="Гонконг";
$lng['country']['HU']="Венгрия";
$lng['country']['IS']="Исландия";
$lng['country']['В']="Индия";
$lng['country']['ID']="Индонезия";
$lng['country']['IR']="Иран,ИсламскаяРеспублика";
$lng['country']['IQ']="Ирак";
$lng['country']['IE']="Ирландия";
$lng['country']['IM']="ОстровМэн";
$lng['country']['Ил']="Израиль";
$lng['country']['IT']="Италия";
$lng['country']['JM']="Ямайка";
$lng['country']['JP']="Япония";
$lng['country']['JE']="Джерси";
$lng['country']['JO']="Иордания";
$lng['country']['KZ']="Казахстан";
$lng['country']['КЕ']="Кения";
$lng['country']['KI']="Кирибати";
$lng['country']['KP']="КорейскаяНародно-ДемократическаяРеспублика";
$lng['country']['KR']="РеспубликаКорея";
$lng['country']['KW']="Кувейт";
$lng['country']['KG']="Кыргызстан";
$lng['country']['LA']="ЛаосскаяНародно-ДемократическаяРеспублика";
$lng['country']['LV']="Латвия";
$lng['country']['LB']="Ливан";
$lng['country']['LS']="Лесото";
$lng['country']['LR']="Либерия";
$lng['country']['LY']="ЛивийскаяАрабскаяДжамахирия";
$lng['country']['LI']="Лихтенштейн";
$lng['country']['LT']="Литва";
$lng['country']['LU']="Люксембург";
$lng['country']['МО']="Макао";
$lng['country']['МК']="Македония,бывшаяЮгославскаяРеспублика";
$lng['country']['MG']="Мадагаскар";
$lng['country']['MVt']="Малави";
$lng['country']['MOY']="Малайзия";
$lng['country']['MV']="Мальдивы";
$lng['country']['ML']="Мали";
$lng['country']['МТ']="Мальта";
$lng['country']['МН']="Маршалловыострова";
$lng['country']['MQ']="Мартиника";
$lng['country']['МР']="Мавритания";
$lng['country']['MU']="Маврикий";
$lng['country']['UT']="Майотта";
$lng['country']['MX']="Мексика";
$lng['country']['FM']="Микронезия,ФедеративныеШтаты";
$lng['country']['MD']="Молдова";
$lng['country']['MC']="Монако";
$lng['country']['МН']="Монголия";
$lng['country']['ME']="Черногория";
$lng['country']['МС']="Монтсеррат";
$lng['country']['MA']="Марокко";
$lng['country']['MZ']="Мозамбик";
$lng['country']['ММ']="Мьянма";
$lng['country']['NA']="Намибия";
$lng['country']['NR']="Науру";
$lng['country']['НП']="Непал";
$lng['country']['ND']="Нидерланды";
$lng['country']['НК']="НоваяКаледония";
$lng['country']['NZ']="НоваяЗеландия";
$lng['country']['NI']="Никарагуа";
$lng['country']['Z']="Нигер";
$lng['country']['NG']="Нигерия";
$lng['country']['NU']="Ниуэ";
$lng['country']['NF']="ОстровНорфолк";
$lng['country']['MP']="СеверныеМарианскиеострова";
$lng['country']['NO']="Норвегия";
$lng['country']['ОМ']="Оман";
$lng['country']['PK']="Пакистан";
$lng['country']['PW']="Палау";
$lng['country']['PS']="Палестины,оккупированнаятерритория";
$lng['country']['PA']="Панама";
$lng['country']['PG']="Папуа-НоваяГвинея";
$lng['country']['PY']="Парагвай";
$lng['country']['CP']="Перу";
$lng['country']['РН']="Филиппины";
$lng['country']['PN']="Питкэрн";
$lng['country']['PL']="Польша";
$lng['country']['PT']="Португалия";
$lng['country']['PR']="Пуэрто-Рико";
$lng['country']['ОК']="Катар";
$lng['country']['RE']="Воссоединение";
$lng['country']['RO']="Румыния";
$lng['country']['RU']="РусскийФедерация";
$lng['country']['RW']="Руанда";
$lng['country']['BL']="Сен-Бартельми";
$lng['country']['SH']="СвятойЕлены,ВознесенияиТристан-да-Кунья";
$lng['country']['KN']="Сент-КитсиНевис";
$lng['country']['LC']="Сент-Люсия";
$lng['country']['MF']="Сен-Мартен(Французскаячасть)";
$lng['country']['PM']="Сен-ПьериМикелон»;
$lng['country']['ВК']="Сент-ВинсентиГренадины";
$lng['country']['WS']="Самоа";
$lng['country']['SM']="Сан-Марино";
$lng['country']['ST']="Сан-ТомеиПринсипи";
$lng['country']['SA']="СаудовскаяАравия";
$lng['country']['CN']="Сенегал";
$lng['country']['RS']="Сербия";
$lng['country']['SC']="Сейшелы";
$lng['country']['SL']="Сьерра-Леоне";
$lng['country']['SG']="Сингапур";
$lng['country']['SX']="Синт-Маартен(ГолландскийЧасть)";
$lng['country']['СК']="Словакия";
$lng['country']['CL']="Словения";
$lng['country']['СО']="Соломоновыострова";
$lng['country']['SO']="Сомали";
$lng['country']['ZA']="ЮжнаяАфрика";
$lng['country']['GS']="ЮжнаяГеоргияиЮжныеСандвичевыострова";
$lng['country']['ES']="Испания";
$lng['country']['ЛК']="Шри-Ланка";
$lng['country']['SD']="Судан";
$lng['country']['SR']="Суринам";
$lng['country']['SJ']="ШпицбергениЯн-Майен";
$lng['country']['SZ']="Свазиленд";
$lng['country']['SE']="Швеция";
$lng['country']['СН']="Швейцария";
$lng['country']['SY']="СирийскаяАрабскаяРеспублика";
$lng['country']['TW']="Тайвань,провинцияКитая";
$lng['country']['TJ']="Таджикистан";
$lng['country']['TZ']="Танзания,ОбъединеннаяРеспублика";
$lng['country']['TH']="Таиланд";
$lng['country']['TL']="Тимор-Лешти";
$lng['country']['ТГ']="Того"​​;
$lng['country']['ТК']="Токелау";
$lng['country']['К']="Тонга";
$lng['country']['TT']="ТринидадиТобаго";
$lng['country']['TN']="Тунис";
$lng['country']['TR']="Турция";
$lng['country']['ТМ']="Туркменистан";
$lng['country']['ТК']="ОстроваТерксиКайкос";
$lng['country']['TV']="Тувалу";
$lng['country']['UG']="Уганда";
$lng['country']['UA']="Украина";
$lng['country']['AE']="ОбъединенныеАрабскиеЭмираты";
$lng['country']['GB']="Великобритания";
$lng['country']['USA']="США";
$lng['country']['UM']="СШАВнешниемалыеострова";
$lng['country']['UY']="Уругвай";
$lng['country']['UZ']="Узбекистан";
$lng['country']['VU']="Вануату";
$lng['country']['VE']="Венесуэла,БоливарианскаяРеспублика";
$lng['country']['VN']="Вьетнам";
$lng['country']['VG']="Виргинскиеострова,Британские";
$lng['country']['VI']="Виргинскиеострова,США";
$lng['country']['WF']="УоллисиФутуна";
$lng['country']['EH']="ЗападнаяСахара";
$lng['country']['YE']="Йемен";
$lng['country']['ZM']="Замбия";
$lng['country']['ZW']="Зимбабве";

// ADDED IN FROXLOR 0.9.22-svn1
$lng['diskquota'] = 'Квота';
$lng['serversettings']['diskquota_enabled'] = 'Квота активна?';
$lng['serversettings']['diskquota_repquota_path']['description'] = 'Путь до квоты';
$lng['serversettings']['diskquota_quotatool_path']['description'] = 'Путь до общей квоты';
$lng['serversettings']['diskquota_customer_partition']['description'] = 'Хранилище файлов клиента';
$lng['tasks']['diskspace_set_quota'] = 'Ввести квоту в файловую систему';
$lng['error']['session_timeout'] = 'Value too low';
$lng['error']['session_timeout_desc'] = 'You should not set the session timeout lower than 1 minute.';

// ADDED IN FROXLOR 0.9.24-svn1
$lng['admin']['assignedmax'] = 'Разрешено / Максимум';
$lng['admin']['usedmax'] = 'Используется / Максимум';
$lng['admin']['used'] = 'Использовано';
$lng['mysql']['size'] = 'Размер';

$lng['error']['invalidhostname'] = 'Имя хоста не может быть пустым';

$lng['traffic']['http'] = 'HTTP (MB)';
$lng['traffic']['ftp'] = 'FTP (MB)';
$lng['traffic']['mail'] = 'Mail (MB)';

// ADDED IN 0.9.27-svn1
$lng['serversettings']['mod_fcgid']['idle_timeout']['title'] = 'Таймаут простоя';
$lng['serversettings']['mod_fcgid']['idle_timeout']['description'] = 'Настройка таймаута для Mod FastCGI.';
$lng['serversettings']['phpfpm_settings']['idle_timeout']['title'] = 'Таймаут простоя';
$lng['serversettings']['phpfpm_settings']['idle_timeout']['description'] = 'Настройка таймаута для PHP5 FPM FastCGI.';

// ADDED IN 0.9.27-svn2
$lng['panel']['cancel'] = 'Отмена';
$lng['admin']['delete_statistics'] = 'Удалить Статистику';
$lng['admin']['speciallogwarning'] = 'WARNING: By changing this setting you will lose all your old statistics for this domain. If you are sure you wish to change this type "%s" in the field below and click the "delete" button.<br /><br />';

// ADDED IN 0.9.28-svn2
$lng['serversettings']['vmail_maildirname']['title'] = 'Имя почтовой директории';
$lng['serversettings']['vmail_maildirname']['description'] = 'Maildir directory into user\'s account. Normally \'Maildir\', in some implementations \'.maildir\', and directly into user\'s directory if left blank.';
$lng['tasks']['remove_emailacc_files'] = 'Удалить данные e-mail Клиента.';

// ADDED IN 0.9.28-svn5
$lng['error']['operationnotpermitted'] = 'Operation not permitted!';
$lng['error']['featureisdisabled'] = 'Feature %s is disabled. Please contact your service provider.';
$lng['serversettings']['catchall_enabled']['title']  = 'Use Catchall';
$lng['serversettings']['catchall_enabled']['description']  = 'Do you want to provide your customers the catchall-feature?';

// ADDED IN 0.9.28.svn6
$lng['serversettings']['apache_24']['title'] = 'Use modifications for Apache 2.4';
$lng['serversettings']['apache_24']['description'] = '<strong style="color:red;">ATTENTION:</strong> use only if you acutally have apache version 2.4 or higher installed<br />otherwise your webserver will not be able to start';
$lng['admin']['tickets_see_all'] = 'Can see all ticket-categories?';
$lng['serversettings']['nginx_fastcgiparams']['title'] = 'Path to fastcgi_params file';
$lng['serversettings']['nginx_fastcgiparams']['description'] = 'Specify the path to nginx\'s fastcgi_params file including filename';
$lng['serversettings']['enablewebfonts']['title'] = 'Enable usage of a google webfont for the panel';
$lng['serversettings']['enablewebfonts']['description'] = 'If enabled, the defined webfont is being used for the font-display';
$lng['serversettings']['definewebfont']['title'] = 'Define a <a href="http://www.google.com/webfonts" rel="external">google-webfont</a> for the panel';
$lng['serversettings']['definewebfont']['description'] = 'If enabled, this wefont will be used for the font-display.<br />Note: replace spaces with the "+" sign, e.g. "Open+Sans"';

// Added in Froxlor 0.9.28-rc2
$lng['serversettings']['documentroot_use_default_value']['title'] = 'Use domain name as default value for DocumentRoot path';
$lng['serversettings']['documentroot_use_default_value']['description'] = 'If enabled and DocumentRoot path is empty, default value will be the (sub)domain name.<br /><br />Examples: <br />/var/customers/customer_name/example.com/<br />/var/customers/customer_name/subdomain.example.com/';

$lng['error']['usercurrentlydeactivated'] = 'The user %s is currently deactivated';
$lng['admin']['speciallogfile']['title'] = 'Separate logfile';
$lng['admin']['speciallogfile']['description'] = 'Enable this to get a separate access-log file for this domain';
$lng['error']['setlessthanalreadyused'] = 'You cannot set less resources of \'%s\' than this user already used<br />';
$lng['error']['stringmustntbeempty'] = 'The value for the field %s must not be empty';
$lng['admin']['domain_editable']['title'] = 'Allow editing of domain';
$lng['admin']['domain_editable']['desc'] = 'If set to yes, the customer is allowed to change several domain-settings.<br />If set to no, nothing can be changed by the customer.';

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
$lng['serversettings']['customerssl_directory']['description'] = 'Where should customer-specified ssl-certificates be created?<br /><br /><div style="color:red">NOTE: This folder\'s content gets deleted regulary so avoid storing data in there manually.</div>';
$lng['admin']['note'] = 'Please note';
$lng['admin']['phpfpm.ininote'] = 'Not all values you may want to define can be used in the php-fpm pool configuration';

// Added in Froxlor 0.9.30
$lng['crondesc']['cron_mailboxsize'] = 'Calculating of mailbox-sizes';
$lng['domains']['ipandport_multi']['title'] = 'IP address(es)';
$lng['domains']['ipandport_multi']['description'] = 'Specify one or more IP address for the domain.<br /><br /><div style="color:red">NOTE: IP addresses cannot be changed when the domain is configured as <strong>alias-domain</strong> of another domain.</div>';
$lng['domains']['ipandport_ssl_multi']['title'] = 'SSL IP address(es)';
$lng['domains']['ssl_redirect']['title'] = 'SSL redirect';
$lng['domains']['ssl_redirect']['description'] = 'This option creates redirects for non-ssl vhosts so that all requests are redirected to the SSL-vhost.<br /><br />e.g. a request to <strong>http</strong>://domain.tld/ will redirect you to <strong>https</strong>://domain.tld/';
$lng['admin']['phpinfo'] = 'PHPinfo()';
$lng['admin']['selectserveralias'] = 'ServerAlias value for the domain';
$lng['admin']['selectserveralias_desc'] = 'Chose whether froxlor should create a wildcard-entry (*.domain.tld), a WWW-alias (www.domain.tld) or no alias at all';
$lng['domains']['serveraliasoption_wildcard'] = 'Wildcard (*.domain.tld)';
$lng['domains']['serveraliasoption_www'] = 'WWW (www.domain.tld)';
$lng['domains']['serveraliasoption_none'] = 'Нет алиаса';
$lng['error']['givendirnotallowed'] = 'The given directory in field %s is not allowed.';
$lng['serversettings']['ssl']['ssl_cipher_list']['title'] = 'Configure the allowed SSL ciphers';
$lng['serversettings']['ssl']['ssl_cipher_list']['description'] = 'This is a list of ciphers that you want (or don\'t want) to use when talking SSL. For a list of ciphers and how to include/exclude them, see sections "CIPHER LIST FORMAT" and "CIPHER STRINGS" on <a href="http://openssl.org/docs/apps/ciphers.html">the man-page for ciphers</a>.<br /><br /><b>Default value is:</b><pre>ECDHE-RSA-AES128-SHA256:AES128-GCM-SHA256:RC4:HIGH:!MD5:!aNULL:!EDH</pre>';

// Added in Froxlor 0.9.31
$lng['panel']['dashboard'] = 'Панель';
$lng['panel']['used'] = 'Использовано';
$lng['panel']['assigned'] = 'Назначено';
$lng['panel']['available'] = 'Доступно';
$lng['customer']['services'] = 'Службы';
$lng['serversettings']['phpfpm_settings']['ipcdir']['title'] = 'FastCGI IPC директория';
$lng['serversettings']['phpfpm_settings']['ipcdir']['description'] = 'The directory where the php-fpm sockets will be stored by the webserver.<br />This directory has to be readable for the webserver';
$lng['panel']['news'] = 'News';
$lng['error']['sslredirectonlypossiblewithsslipport'] = 'Using the SSL redirect is only possible when the domain has at least one ssl-enabled IP/port combination assigned.';
$lng['error']['fcgidstillenableddeadlock'] = 'FCGID is currently active.<br />Please deactivate it before switching to another webserver than Apache2';
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
$lng['logger']['reseller'] = "Продавец";
$lng['logger']['admin'] = "Администратор";
$lng['logger']['cron'] = "Cron-задания";
$lng['logger']['login'] = "Логин";
$lng['logger']['intern'] = "Внутренний";
$lng['logger']['unknown'] = "Unknown";
$lng['serversettings']['mailtraffic_enabled']['title'] = "Проанализировать mail траффик";
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
$lng['serversettings']['system_cronconfig']['description'] = 'Path to the cron-service configuration-file. This file will be updated regularly and automatically by froxlor.<br />Note: Please <b>be sure</b> to use the same filename as for the main froxlor cronjob (default: /etc/cron.d/froxlor)!';
$lng['tasks']['remove_ftpacc_files'] = 'Delete customer ftp-account data.';
$lng['tasks']['regenerating_crond'] = 'Rebuilding the cron.d-file';
$lng['serversettings']['system_crondreload']['title'] = 'Cron-daemon reload command';
$lng['serversettings']['system_crondreload']['description'] = 'Specify the command to execute in order to reload your systems cron-daemon';
$lng['admin']['integritycheck'] = 'Проверка Базы Данных';
$lng['admin']['integrityid'] = '#';
$lng['admin']['integrityname'] = 'Имя';
$lng['admin']['integrityresult'] = 'Результат';
$lng['admin']['integrityfix'] = 'Исправить проблему автоматически';
$lng['question']['admin_integritycheck_reallyfix'] = 'Do you really want to try fixing all database integrity problems automatically?';
$lng['serversettings']['system_croncmdline']['title'] = 'Cron execution command (php-binary)';
$lng['serversettings']['system_croncmdline']['description'] = 'Command to execute our cronjobs. Change this only if you know what you are doing (default: "/usr/bin/nice -n 5 /usr/bin/php5 -q")!';
$lng['error']['cannotdeletehostnamephpconfig'] = 'This PHP-configuration is used by the Froxlor-vhost and cannot be deleted.';
$lng['error']['cannotdeletedefaultphpconfig'] = 'This PHP-configuration is set as default and cannot be deleted.';
$lng['serversettings']['system_cron_allowautoupdate']['title'] = 'Allow automatic database updates';
$lng['serversettings']['system_cron_allowautoupdate']['description'] = '<div style="color:red"><b>ATTENTION:</b></div> This settings allows the cronjob to bypass the version-check of froxlors files and database and runs the database-updates in case a version-mismatch occurs.<br><br><div style="color:red">Auto-update will always set default values for new settings or changes. This might not always suite your system. Please think twice before activating this option</div>';
$lng['error']['passwordshouldnotbeusername'] = 'Пароль не должен быть таким же, как имя пользователя.';
