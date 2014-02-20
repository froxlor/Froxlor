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
 * @author     Konstantin Samofejew <samofejew@gmx.net>
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Language
 *
 */

/**
 * Global
 */
$lng['translator'] = 'Konstantin Samofejew (Константин Самофеев)';
$lng['panel']['edit'] = 'редактировать';
$lng['panel']['delete'] = 'удалить';
$lng['panel']['create'] = 'создать';
$lng['panel']['save'] = 'Сохранить';
$lng['panel']['yes'] = 'Да';
$lng['panel']['no'] = 'Нет';
$lng['panel']['emptyfornochanges'] = 'оставить пустым, если без изменений';
$lng['panel']['emptyfordefault'] = 'оставить пустым для стандартного значения';
$lng['panel']['path'] = 'Путь';
$lng['panel']['toggle'] = 'Переключить';
$lng['panel']['next'] = 'дальше';
$lng['panel']['dirsmissing'] = 'Каталоги (директории) не существуют или не читаемы';

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
$lng['customer']['documentroot'] = 'Домашний каталог (директория)';
$lng['customer']['name'] = 'Фамилия';
$lng['customer']['firstname'] = 'Имя';
$lng['customer']['company'] = 'Фирма';
$lng['customer']['street'] = 'Улица, дом, квартира';
$lng['customer']['zipcode'] = 'Почтовый индекс';
$lng['customer']['city'] = 'Город';
$lng['customer']['phone'] = 'Телефон';
$lng['customer']['fax'] = 'Факс';
$lng['customer']['email'] = 'eMail';
$lng['customer']['customernumber'] = 'Номер клиента';
$lng['customer']['diskspace'] = 'Объём под Web (MB)';
$lng['customer']['traffic'] = 'Трафик (GB)';
$lng['customer']['mysqls'] = 'Базы данных MySQL';
$lng['customer']['emails'] = 'Адреса eMail';
$lng['customer']['accounts'] = 'Аккаунты eMail';
$lng['customer']['forwarders'] = 'Пересылки eMail (forwarder)';
$lng['customer']['ftps'] = 'Аккаунты FTP';
$lng['customer']['subdomains'] = 'Поддомены';
$lng['customer']['domains'] = 'Домены';

/**
 * Customermenue
 */
$lng['menue']['main']['main'] = 'Общие настройки';
$lng['menue']['main']['changepassword'] = 'Изменить пароль';
$lng['menue']['main']['changelanguage'] = 'Изменить язык';
$lng['menue']['email']['email'] = 'eMail';
$lng['menue']['email']['emails'] = 'Адреса';
$lng['menue']['email']['webmail'] = 'WebMail';
$lng['menue']['mysql']['mysql'] = 'MySQL';
$lng['menue']['mysql']['databases'] = 'Базы данных';
$lng['menue']['mysql']['phpmyadmin'] = 'phpMyAdmin';
$lng['menue']['domains']['domains'] = 'Домены';
$lng['menue']['domains']['settings'] = 'Настройки';
$lng['menue']['ftp']['ftp'] = 'FTP';
$lng['menue']['ftp']['accounts'] = 'Аккаунты';
$lng['menue']['ftp']['webftp'] = 'WebFTP';
$lng['menue']['extras']['extras'] = 'Разное';
$lng['menue']['extras']['directoryprotection'] = 'Защита каталогов (директорий)';
$lng['menue']['extras']['pathoptions'] = 'Настройки путей';

/**
 * Index
 */

$lng['index']['customerdetails'] = 'Данные клиентов';

$lng['index']['accountdetails'] = 'Данные аккаунтов';
/**
 * Change Password
 */

$lng['changepassword']['old_password'] = 'Старый пароль';
$lng['changepassword']['new_password'] = 'Новый пароль';
$lng['changepassword']['new_password_confirm'] = 'Новый пароль (повторить)';
$lng['changepassword']['new_password_ifnotempty'] = 'Новый пароль (оставить пустым, чтобы не менять)';
$lng['changepassword']['also_change_ftp'] = ' Также изменить пароль и для основного аккаунта FTP';

/**
 * Domains
 */
$lng['domains']['description'] = 'Здесь Вы можете создавать поддомены и менять пути к ним.<br />После каждого изменения системе необходимо немного времени, чтобы загрузить обновлённые настройки.';
$lng['domains']['domainsettings'] = 'Настройки домена';
$lng['domains']['domainname'] = 'Имя домена';
$lng['domains']['subdomain_add'] = 'Создать поддомен';
$lng['domains']['subdomain_edit'] = 'Обработать (под)домен';
$lng['domains']['wildcarddomain'] = 'Занести как уайлдкард-домен? (Wildcard)';
$lng['domains']['aliasdomain'] = 'Алиас для домена';
$lng['domains']['noaliasdomain'] = 'Не алиас-домен';

/**
 * eMails
 */
$lng['emails']['description'] = 'Здесь Вы можете настроить Ваши email-адреса.<br />Аккаунт - это как обычный почтовый ящик. Если Вам кто-то напишет электронное письмо (email), оно попадёт в этот ящик.<br /><br />Данные для Вашей почтовй программы: (Текст <i>с наклоном</i> замените на Ваши данные!)<br />Сервер: <b><i>имя домена</i></b><br />Имя пользователя: <b><i>имя аккаунта или email-адрес</i></b><br />Пароль: <b><i>выбранный Вами пароль</i></b>';
$lng['emails']['emailaddress'] = 'eMail-адрес';
$lng['emails']['emails_add'] = 'создать eMail-адрес';
$lng['emails']['emails_edit'] = 'изменить eMail-адрес';
$lng['emails']['catchall'] = 'С функцией "лови всё" (catchall)';
$lng['emails']['iscatchall'] = 'Сделать catchall-адресом?';
$lng['emails']['account'] = 'Аккаунт';
$lng['emails']['account_add'] = 'Создать аккаунт';
$lng['emails']['account_delete'] = 'Удалить аккаунт';
$lng['emails']['from'] = 'От';
$lng['emails']['to'] = 'Куда';
$lng['emails']['forwarders'] = 'Пересылка';
$lng['emails']['forwarder_add'] = 'Добавить пересылку';

/**
 * FTP
 */
$lng['ftp']['description'] = 'Здесь Вы можете создать дополнительные FTP-аккаунты.<br />FTP-аккаунты активны сразу после сохранения изменений.';
$lng['ftp']['account_add'] = 'Создать аккаунт';

/**
 * MySQL
 */
$lng['mysql']['databasename'] = 'Имя пользователя / базы данных';
$lng['mysql']['databasedescription'] = 'Описание базы данных';
$lng['mysql']['database_create'] = 'Создать базу данных';

/**
 * Extras
 */
$lng['extras']['description'] = 'Здесь Вы можете сделать дополнительные настройки, например защиту каталога (директории).<br />После каждого изменения системе необходимо немного времени, чтобы загрузить обновлённые настройки.';
$lng['extras']['directoryprotection_add'] = 'Создать защиту каталога';
$lng['extras']['view_directory'] = 'Показать каталог';
$lng['extras']['pathoptions_add'] = 'Добавить настройки пути';
$lng['extras']['directory_browsing'] = 'Показать содержимое каталога';
$lng['extras']['pathoptions_edit'] = 'Изменить настройки пути';
$lng['extras']['errordocument404path'] = 'URL к документу ошибки 404';
$lng['extras']['errordocument403path'] = 'URL к документу ошибки 403';
$lng['extras']['errordocument500path'] = 'URL к документу ошибки 500';
$lng['extras']['errordocument401path'] = 'URL к документу ошибки 401';

/**
 * Errors
 */
$lng['error']['error'] = 'Сообщение о ошибке';
$lng['error']['directorymustexist'] = 'Файл %s должен существовать.';
$lng['error']['filemustexist'] = 'Файл %s должен существовать.';
$lng['error']['allresourcesused'] = 'Вы уже израсходовали все ресурсы, находящиеся в Вашем распоряжении.';
$lng['error']['domains_cantdeletemaindomain'] = 'Вы не можете удалить домен, занесённый как eMail-домен.';
$lng['error']['domains_canteditdomain'] = 'Обработка этого домена запрещена админом.';
$lng['error']['domains_cantdeletedomainwithemail'] = 'Вы не можете удалить домен, который ещё используется как eMail-домен. Удалите сначала все eMail-адреса этого домена.';
$lng['error']['firstdeleteallsubdomains'] = 'Прежде чем создать уайлдкард-домен (wildcard), Вам необходимо удалить все поддомены.';
$lng['error']['youhavealreadyacatchallforthisdomain'] = 'Вы уже прописали один адрес как "лови всё" (catchall) для этого домена.';
$lng['error']['ftp_cantdeletemainaccount'] = 'Вы не можете удалить Ваш основной аккаунт.';
$lng['error']['login'] = 'Указанные имя пользователя или пароль не верны.';
$lng['error']['login_blocked'] = 'Из-за многочисленных ошибочных попыток логина аккаунт временно закрыт. <br />Пожалуйста попробуйте через %s секунд ещё раз.';
$lng['error']['notallreqfieldsorerrors'] = 'Вы заполнили не все поля или минимум одно поле неправильно.';
$lng['error']['oldpasswordnotcorrect'] = 'Старый пароль не верен.';
$lng['error']['youcantallocatemorethanyouhave'] = 'Вы не можете раздавать больше ресурсов, чем у Вас ещё есть.';
$lng['error']['mustbeurl'] = 'Вы должны указать полный адрес URL (например http://something.com/error404.htm)';
$lng['error']['invalidpath'] = 'Вы указали не действительный адрес URL.';
$lng['error']['stringisempty'] = 'Отсутствующие данные в поле';
$lng['error']['stringiswrong'] = 'Неправильные данные в поле';
$lng['error']['newpasswordconfirmerror'] = 'Новый пароль и повторённый новый пароль отличаются.';
$lng['error']['mydomain'] = '\'Домен\'';
$lng['error']['mydocumentroot'] = '\'Корень документа\'';
$lng['error']['loginnameexists'] = 'Имя %s уже существует.';
$lng['error']['emailiswrong'] = 'eMail-адрес %s содержит запрещённые символы или является не полным.';
$lng['error']['loginnameiswrong'] = 'Имя %s содержит запрещённые символы.';
$lng['error']['userpathcombinationdupe'] = 'Комбинация из имени пользователя и пути уже существует.';
$lng['error']['patherror'] = 'Общая ошибка! Путь не может быть пустым.';
$lng['error']['errordocpathdupe'] = 'Настройка для пути %s уже существует.';
$lng['error']['adduserfirst'] = 'Сначала необходимо создать клиента.';
$lng['error']['domainalreadyexists'] = 'Домен %s уже в распоряжении другого клиента.';
$lng['error']['nolanguageselect'] = 'Язык не выбран.';
$lng['error']['nosubjectcreate'] = 'Вам нужно указать тему.';
$lng['error']['nomailbodycreate'] = 'Вам нужно набрать текст сообщения.';
$lng['error']['templatenotfound'] = 'Шаблон не найден.';
$lng['error']['alltemplatesdefined'] = 'Вы не можете создавать шаблоны, потому-что во всех языках шаблоны уже существуют.';
$lng['error']['wwwnotallowed'] = 'Ваш поддомен не может носить имя www.';
$lng['error']['subdomainiswrong'] = 'Поддомен %s содержит недействительные символы.';
$lng['error']['domaincantbeempty'] = 'Имя домена не может быть пустым.';
$lng['error']['domainexistalready'] = 'Домен %s уже существует.';
$lng['error']['domainisaliasorothercustomer'] = 'Выбранный алиас-домен или сам является алиас-доменом, или принадлежит другому клиенту.';
$lng['error']['emailexistalready'] = 'eMail-адрес %s уже существует.';
$lng['error']['maindomainnonexist'] = 'Основной домен %s не существует.';
$lng['error']['destinationnonexist'] = 'Занесите адрес для пересылки в поле \'Куда\'.';
$lng['error']['destinationalreadyexistasmail'] = 'Пересылка на %s уже существует как активный eMail-адрес.';
$lng['error']['destinationalreadyexist'] = 'Пересылка на %s уже существует.';
$lng['error']['destinationiswrong'] = 'Адрес для пересылки %s содержит недействительные символы или является неполным.';

/**
 * Questions
 */
$lng['question']['question'] = 'Вопрос о выполнении';
$lng['question']['admin_customer_reallydelete'] = 'Вы уверены, что хотите удалить клиента %s?<br />ВНИМАНИЕ! Удалённые данные не смогут быть позже восстановлены! После этого шага Вам ещё будет необходимо от руки удалить данные из файловой системы.';
$lng['question']['admin_domain_reallydelete'] = 'Вы уверены, что хотите удалить домен %s?';
$lng['question']['admin_domain_reallydisablesecuritysetting'] = 'Вы уверены, что хотите отключить эти важные для безопасности настройки (OpenBasedir)?';
$lng['question']['admin_admin_reallydelete'] = 'Вы уверены, что хотите удалить админа %s?<br />Все клиенты и домены будут переданы главному админу.';
$lng['question']['admin_template_reallydelete'] = 'Вы уверены, что хотите удалить шаблон %s?';
$lng['question']['domains_reallydelete'] = 'Вы уверены, что хотите удалить домен %s?';
$lng['question']['email_reallydelete'] = 'Вы уверены, что хотите удалить eMail-адрес %s?';
$lng['question']['email_reallydelete_account'] = 'Вы уверены, что хотите удалить аккаунт %s?';
$lng['question']['email_reallydelete_forwarder'] = 'Вы уверены, что хотите удалить пересылку %s?';
$lng['question']['extras_reallydelete'] = 'Вы уверены, что хотите удалить защиту каталога (директории) для %s?';
$lng['question']['extras_reallydelete_pathoptions'] = 'Вы уверены, что хотите удалить настройки для пути %s?';
$lng['question']['ftp_reallydelete'] = 'Вы уверены, что хотите удалить FTP-аккаунт %s?';
$lng['question']['mysql_reallydelete'] = 'Вы уверены, что хотите удалить базу данных %s?<br />ВНИМАНИЕ! Все данные будут безвозвратно потеряны!';
$lng['question']['admin_configs_reallyrebuild'] = 'Вы уверены, что хотите заново создать Ваши файлы настройки для Apache и Bind?';

/**
 * Mails
 */
$lng['mails']['pop_success']['mailbody'] = 'Здравствуйте!\n\nВаш eMail-аккаунт {USERNAME}\nготов к пользованию.\n\nЭто автоматически созданное сообщение,\nпожалуйста не отвечайте на него.\n\nАдминистрация';
$lng['mails']['pop_success']['subject'] = 'eMail-аккаунт готов к пользованию';
$lng['mails']['createcustomer']['mailbody'] = 'Здравствуйте, {FIRSTNAME} {NAME}!\n\nДанные Вашего аккаунта:\n\nИмя пользователя: {USERNAME}\nПароль: {PASSWORD}\n\nЭто автоматически созданное сообщение,\nпожалуйста не отвечайте на него.\n\nС уважением,\nАдминистрация';
$lng['mails']['createcustomer']['subject'] = 'Данные к аккаунту';

/**
 * Admin
 */
$lng['admin']['overview'] = 'Обзор';
$lng['admin']['ressourcedetails'] = 'Использованные ресурсы';
$lng['admin']['systemdetails'] = 'Подробности системы';
$lng['admin']['froxlordetails'] = 'Подробности Froxlor';
$lng['admin']['installedversion'] = 'Установленная версия';
$lng['admin']['latestversion'] = 'Последняя версия';
$lng['admin']['lookfornewversion']['clickhere'] = 'Запросить через веб-сервис';
$lng['admin']['lookfornewversion']['error'] = 'Ошибка при запросе';
$lng['admin']['resources'] = 'Ресурсы';
$lng['admin']['customer'] = 'Клиент';
$lng['admin']['customers'] = 'Клиенты';
$lng['admin']['customer_add'] = 'Добавить клиента';
$lng['admin']['customer_edit'] = 'Изменить данные клиента';
$lng['admin']['domains'] = 'Домены';
$lng['admin']['domain_add'] = 'Добавить домен';
$lng['admin']['domain_edit'] = 'Изменить домен';
$lng['admin']['subdomainforemail'] = 'Поддомены в качестве eMail-доменов';
$lng['admin']['admin'] = 'Админ';
$lng['admin']['admins'] = 'Админы';
$lng['admin']['admin_add'] = 'Добавить админа';
$lng['admin']['admin_edit'] = 'Изменить данные админа';
$lng['admin']['customers_see_all'] = 'Может видеть всех клиентов?';
$lng['admin']['domains_see_all'] = 'Может видеть все домены?';
$lng['admin']['change_serversettings'] = 'Может менять настройки сервера?';
$lng['admin']['server'] = 'Сервер';
$lng['admin']['serversettings'] = 'Настройки сервера';
$lng['admin']['rebuildconf'] = 'Заново создать настройки';
$lng['admin']['stdsubdomain'] = 'Поддомен по умолчанию';
$lng['admin']['stdsubdomain_add'] = 'Добавить поддомен по умолчанию';
$lng['admin']['deactivated'] = 'Доступ закрыт';
$lng['admin']['deactivated_user'] = 'Закрыть доступ пользователю';
$lng['admin']['sendpassword'] = 'Послать пароль';
$lng['admin']['ownvhostsettings'] = 'Собственные vHost-настройки';
$lng['admin']['configfiles']['serverconfiguration'] = 'Настройки служб';
$lng['admin']['configfiles']['files'] = '<b>Файлы настроек:</b> Пожалуйста измените соответствующие файлы настроек<br />или добавьте новые, если они не существуют, со следующим содержимым.<br /><b>Обратите внимание:</b> MySQL-пароль не был заменён из соображений безопасности.<br />Пожалуйста замените вручную "MYSQL_PASSWORD" на соответствующий пароль.<br />Если Вы его не помните, посмотрите в файле "lib/userdata.inc.php".';
$lng['admin']['configfiles']['commands'] = '<b>Команды:</b> Пожалуйста выполните следующие команды в shell.';
$lng['admin']['configfiles']['restart'] = '<b>Перезагрузка:</b> Пожалуйста выполните следующие команды в shell для<br />перезагрузки файлов настроек.';
$lng['admin']['templates']['templates'] = 'Шаблоны';
$lng['admin']['templates']['template_add'] = 'Добавить шаблон';
$lng['admin']['templates']['template_edit'] = 'Изменить шаблон';
$lng['admin']['templates']['action'] = 'Операция';
$lng['admin']['templates']['email'] = 'E-Mail';
$lng['admin']['templates']['subject'] = 'Тема';
$lng['admin']['templates']['mailbody'] = 'Текст сообщения';
$lng['admin']['templates']['createcustomer'] = 'Приветствие нового клиента';
$lng['admin']['templates']['pop_success'] = 'Приветствие для новых eMail-аккаунтов';
$lng['admin']['templates']['template_replace_vars'] = 'Переменные, которые будут заменены в шаблонах:';
$lng['admin']['templates']['FIRSTNAME'] = 'Будет заменено именем клиента.';
$lng['admin']['templates']['NAME'] = 'Будет заменено фамилией клиента.';
$lng['admin']['templates']['USERNAME'] = 'Будет заменено именем пользователя нового аккаунта.';
$lng['admin']['templates']['PASSWORD'] = 'Будет заменено паролем нового аккаунта.';
$lng['admin']['templates']['EMAIL'] = 'Будет заменено адресом нового POP3/IMAP-аккаунта.';

/**
 * Serversettings
 */
$lng['serversettings']['session_timeout']['title'] = 'Срок действия сессии';
$lng['serversettings']['session_timeout']['description'] = 'Как долго пользовать должен быть не активен, чтобы сессия стала недействительной? (в секундах)';
$lng['serversettings']['accountprefix']['title'] = 'Приставка клиента';
$lng['serversettings']['accountprefix']['description'] = 'Какая приставка должна быть у аккаунтов клиентов?';
$lng['serversettings']['mysqlprefix']['title'] = 'Приставка для SQL';
$lng['serversettings']['mysqlprefix']['description'] = 'Какая приставка должна быть у MySQL-аккаунтов?';
$lng['serversettings']['ftpprefix']['title'] = 'Приставка для FTP';
$lng['serversettings']['ftpprefix']['description'] = 'Какая приставка должна быть у FTP-аккаунтов?';
$lng['serversettings']['documentroot_prefix']['title'] = 'Каталог (директория) для документов';
$lng['serversettings']['documentroot_prefix']['description'] = 'Куда помещать данные клиентов?';
$lng['serversettings']['logfiles_directory']['title'] = 'Каталог (директория) для протоколов';
$lng['serversettings']['logfiles_directory']['description'] = 'Куда помещать все протоколы (лог-файлы)?';
$lng['serversettings']['ipaddress']['title'] = 'IP-адрес';
$lng['serversettings']['ipaddress']['description'] = 'Какой у сервера адрес IP?';
$lng['serversettings']['hostname']['title'] = 'Имя хоста';
$lng['serversettings']['hostname']['description'] = 'Какое у сервера имя хоста (hostname)?';
$lng['serversettings']['apachereload_command']['title'] = 'Команда для перезагрузки Apache';
$lng['serversettings']['apachereload_command']['description'] = 'Как называется скрипт для перезагрузки Apache?';
$lng['serversettings']['bindconf_directory']['title'] = 'Каталог (директория) для настрек Bind';
$lng['serversettings']['bindconf_directory']['description'] = 'Где находятся файлы настроек Bind?';
$lng['serversettings']['bindreload_command']['title'] = 'Команда для перезагрузки Bind';
$lng['serversettings']['bindreload_command']['description'] = 'Как называется скрипт для перезагрузки Bind?';
$lng['serversettings']['binddefaultzone']['title'] = 'Зона по умолчанию для Bind';
$lng['serversettings']['binddefaultzone']['description'] = 'Как называется стандартная зона для всех доменов?';
$lng['serversettings']['vmail_uid']['title'] = 'Mail-Uid';
$lng['serversettings']['vmail_uid']['description'] = 'Какую UID должна использовать почтовая служба?';
$lng['serversettings']['vmail_gid']['title'] = 'Mail-Gid';
$lng['serversettings']['vmail_gid']['description'] = 'Какую GID должна использовать почтовая служба?';
$lng['serversettings']['vmail_homedir']['title'] = 'Каталог почтовой службы';
$lng['serversettings']['vmail_homedir']['description'] = 'Где должна храниться электронная почта (eMail)?';
$lng['serversettings']['adminmail']['title'] = 'Адрес отправителя';
$lng['serversettings']['adminmail']['description'] = 'Каким должен быть адрес отправителя для писем от системы?';
$lng['serversettings']['phpmyadmin_url']['title'] = 'phpMyAdmin-URL';
$lng['serversettings']['phpmyadmin_url']['description'] = 'Где находится phpMyAdmin? (начинается с http://)';
$lng['serversettings']['webmail_url']['title'] = 'WebMail-URL';
$lng['serversettings']['webmail_url']['description'] = 'Где находится WebMail? (начинается с http://)';
$lng['serversettings']['webftp_url']['title'] = 'WebFTP-URL';
$lng['serversettings']['webftp_url']['description'] = 'Где находится WebFTP? (начинается с http://)';
$lng['serversettings']['language']['description'] = 'Какой язык является языком по умолчанию?';
$lng['serversettings']['maxloginattempts']['title'] = 'Макс. попыток входа';
$lng['serversettings']['maxloginattempts']['description'] = 'Максимальное количество попыток входа до отключения аккаунта.';
$lng['serversettings']['deactivatetime']['title'] = 'Время отключения';
$lng['serversettings']['deactivatetime']['description'] = 'Время (в сек.), на которое отключается аккаунт.';
$lng['serversettings']['pathedit']['title'] = 'Способ ввода пути';
$lng['serversettings']['pathedit']['description'] = 'Выбирать путь в меню, или набирать вручную?';

/**
 * CHANGED BETWEEN 1.2.12 and 1.2.13
 */
$lng['mysql']['description'] = 'Здесь вы можете создавать и удалять базы данных MySQL.<br />Базы данных готовы к пользованию сразу после сохранения изменений.<br />В меню Вы найдёте ссылку на phpMyAdmin, которым вы можете обрабатывать базы данных.<br /><br />Данные для доступа из скриптов PHP: (Текст <i>с наклоном</i> замените соответствующими записями!)<br />Имя хоста: <b><SQL_HOST></b><br />Имя пользователя: <b><i>имя базы данных</i></b><br />Пароль: <b><i>выбранный пароль</i></b><br />База данных: <b><i>Имя базы данных</i></b>';

/**
 * ADDED BETWEEN 1.2.12 and 1.2.13
 */
$lng['serversettings']['paging']['title'] = 'Кол-во записей на страницу';
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
$lng['admin']['ipsandports']['port'] = 'Порт';

/**
 * ADDED BETWEEN 1.2.13 and 1.2.14
 */
$lng['panel']['translator'] = 'Переводчик';
$lng['error']['cantchangesystemip'] = 'Вы не можете удалить последний системный адрес IP. Создайте новую комбинацию IP/порт в качестве системного адреса IP или измените существующий системный адрес IP.';
$lng['question']['admin_domain_reallydocrootoutofcustomerroot'] = 'Вы уверены, что DocumentRoot этого домена должен находиться вне домашнего каталога (директории) клиента?';
$lng['admin']['memorylimitdisabled'] = 'Отключено';
$lng['error']['loginnameissystemaccount'] = 'Вы не можете создать аккаунт, похожий на системный. Выберите пожалуйста другое имя для аккаунта.';
$lng['domain']['openbasedirpath'] = 'Путь OpenBasedir';
$lng['domain']['docroot'] = 'Выше указанный путь';
$lng['domain']['homedir'] = 'Домашний каталог';
$lng['admin']['valuemandatory'] = 'Это поле обязательно для заполнения';
$lng['admin']['valuemandatorycompany'] = 'Необходимо заполнить поля "Фамилия" и "Имя" или "Фирма"';
$lng['menue']['main']['username'] = 'В системе как: ';
$lng['panel']['urloverridespath'] = 'URL (переписывет путь)';
$lng['panel']['pathorurl'] = 'Путь или URL';
$lng['error']['sessiontimeoutiswrong'] = '"Срок действия сессии" должно являться числовым значением.';
$lng['error']['maxloginattemptsiswrong'] = '"Макс. попыток входа" должно являться числовым значением.';
$lng['error']['deactivatetimiswrong'] = '"Время отключения" должно являться числовым значением.';
$lng['error']['accountprefixiswrong'] = 'Неправильная "приставка клиента".';
$lng['error']['mysqlprefixiswrong'] = 'Неправильная "Приставка для SQL".';
$lng['error']['ftpprefixiswrong'] = 'Неправильная "Приставка для FTP".';
$lng['error']['ipiswrong'] = 'Неправильный "IP-адрес". Разрешён только действительный адрес IP.';
$lng['error']['vmailuidiswrong'] = '"Mails-UID" должно являться числовым значением.';
$lng['error']['vmailgidiswrong'] = 'Die "Mails-GID" должно являться числовым значением.';
$lng['error']['adminmailiswrong'] = 'Неправильный "Адрес отправителя". Разрешён только действительный E-Mail-адрес';
$lng['error']['pagingiswrong'] = 'Настройка "Кол-во записей на страницу" должна иметь числовое значение.';
$lng['error']['phpmyadminiswrong'] = '"phpMyAdmin-URL" не является действительным URL.';
$lng['error']['webmailiswrong'] = '"WebMail-URL" не является действительным URL.';
$lng['error']['webftpiswrong'] = '"WebFTP-URL" не является действительным URL.';
$lng['domains']['hasaliasdomains'] = 'Имеет alias-домен(ы)';
$lng['serversettings']['defaultip']['title'] = 'IP/порт по умолчанию';
$lng['serversettings']['defaultip']['description'] = 'Какая комбинация IP/порт должна быть использована по умолчанию?';
$lng['domains']['statstics'] = 'Статистика';
$lng['panel']['ascending'] = 'по возрастанию';
$lng['panel']['decending'] = 'по убыванию';
$lng['panel']['search'] = 'Поиск';
$lng['panel']['used'] = 'в пользовании';
$lng['error']['stringformaterror'] = 'Значение поля "%s" не соответствует ожидаемому формату.';

/**
 * ADDED BETWEEN 1.2.14 and 1.2.15
 */
$lng['admin']['serversoftware'] = 'Программное обеспечение сервера';
$lng['admin']['phpversion'] = 'Версия PHP';
$lng['admin']['phpmemorylimit'] = 'Ограничение памяти для PHP';
$lng['admin']['mysqlserverversion'] = 'Версия сервера MySQL';
$lng['admin']['mysqlclientversion'] = 'Версия клиента MySQL';
$lng['admin']['webserverinterface'] = 'Интерфейс вебсервера';
