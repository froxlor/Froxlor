<?php


/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, you can also view it online at
 * https://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  the authors
 * @author     Froxlor team <team@froxlor.org>
 * @license    https://files.froxlor.org/misc/COPYING.txt GPLv2
 */

return [
	'languages' => [
		'cz' => 'Czech',

		'de' => 'German',

		'en' => 'English',

		'fr' => 'French',

		'it' => 'Italia',

		'nl' => 'Dutch',

		'pt' => 'Portuguese',

		'se' => 'Swedish',

		'es' => 'Spanish',

        'ru' => 'Russian'
	],

'2fa' => [
'2fa' => 'Опции 2FA',

'2fa_enabled' => 'Активировать двухфакторную аутентификацию (2FA)',

'2fa_removed' => '2FA успешно удалена',

'2fa_added' => '2FA успешно активирована<br><a class="alert-link" href="%s?page=2fa">Подробнее о 2FA</a>',

'2fa_add' => 'Активировать 2FA',

'2fa_delete' => 'Отключить 2FA',

'2fa_verify' => 'Проверить код',

'2fa_overview_desc' => 'Здесь вы можете активировать двухфакторную аутентификацию для своей учетной записи.<br><br>Вы можете либо использовать приложение-аутентификатор (одноразовый пароль на основе времени / TOTP), либо позволить froxlor отправить вам письмо на адрес вашей учетной записи после каждого успешного входа в систему с одноразовым паролем.',

'2fa_email_desc' => 'Ваша учетная запись настроена на использование одноразовых паролей по электронной почте. Для деактивации нажмите «Деактивировать 2FA»',

'2fa_ga_desc' => 'Ваша учетная запись настроена на использование одноразовых паролей на основе времени через приложение-аутентификатор. Отсканируйте приведенный ниже QR-код с помощью нужного приложения для аутентификации, чтобы сгенерировать коды. Для деактивации нажмите «Деактивировать 2FA»',

],

'admin' => [ 'overview' => 'Обзор',
 'ressourcedetails' => 'Используемые ресурсы',
 'systemdetails' => 'Информация о системе',
 'froxlordetails' => 'Информация о Froxlor',
 'installedversion' => 'Установленная версия',
 'latestversion' => 'Последняя версия',
 'lookfornewversion' => [ 'clickhere' => 'Поиск через веб-сервис',
 'error' => 'Ошибка при чтении',
 ], 'resources' => 'Ресурсы',
 'customer' => 'Клиент',
 'customers' => 'Клиенты',
 'customers_list_desc' => 'Управляйте своими клиентами',
 'customer_add' => 'Создать клиента',
 'customer_edit' => 'Редактировать клиента',
 'username_default_msg' => 'Оставьте пустым для автоматически генерируемого значения',
 'domains' => 'Домены',
 'domain_add' => 'Создать домен',
 'domain_edit' => 'Редактировать домен',
 'subdomainforemail' => 'Поддомены как почтовые домены',
 'admin' => 'Администратор',
 'admins' => 'Администраторы',
 'admin_add' => 'Создать администратора',
 'admin_edit' => 'Редактировать администратора',
 'customers_see_all' => 'Могут ли просматривать ресурсы других администраторов/реселлеров?',
 'change_serversettings' => 'Могут ли изменять настройки сервера?',
 'server' => 'Система',
 'serversettings' => 'Настройки',
 'serversettings_desc' => 'Управляйте вашей системой Froxlor',
 'rebuildconf' => 'Перестроить конфигурационные файлы',
 'stdsubdomain' => 'Стандартный субдомен',
 'stdsubdomain_add' => 'Создать стандартный субдомен',
 'phpenabled' => 'Включен PHP',
 'deactivated' => 'Деактивирован',
 'deactivated_user' => 'Деактивировать пользователя',
 'sendpassword' => 'Отправить пароль',
 'ownvhostsettings' => 'Собственные настройки vHost',
 'configfiles' => [ 'serverconfiguration' => 'Конфигурация',
 'overview' => 'Обзор',
 'wizard' => 'Мастер',
 'distribution' => 'Дистрибутив',
 'service' => 'Служба',
 'daemon' => 'Демон',
 'http' => 'Веб-сервер (HTTP)',
 'dns' => 'Сервер имен (DNS)',
 'mail' => 'Почтовый сервер (IMAP/POP3)',
 'smtp' => 'Почтовый сервер (SMTP)',
 'ftp' => 'FTP-сервер',
 'etc' => 'Прочее (Система)',
 'choosedistribution' => '-- Выберите дистрибутив --',
 'chooseservice' => '-- Выберите службу --',
 'choosedaemon' => '-- Выберите демона --',
 'statistics' => 'Статистика',
 'compactoverview' => 'Компактный обзор',
 'legend' => '<h3>Вы собираетесь настроить службу/демон</h3>',
 'commands' => '<span class="text-danger">Команды:</span> Эти команды следует выполнить построчно от имени root-пользователя в оболочке. Безопасно скопируйте все команды и вставьте их в оболочку.',
 'files' => '<span class="text-danger">Файлы конфигурации:</span> Команды перед полями ввода должны открыть редактор с целевым файлом. Просто скопируйте и вставьте содержимое в редактор и сохраните файл.<br><span class="text-danger">Пожалуйста, обратите внимание:</span> Пароль от MySQL не был заменен из соображений безопасности. Замените "FROXLOR_MYSQL_PASSWORD" самостоятельно или используйте форму JavaScript ниже, чтобы заменить его на месте. Если вы забыли пароль от MySQL, вы найдете его в "lib/userdata.inc.php"',
 'importexport' => 'Импорт/Экспорт',
 'finishnote' => 'Файл параметров успешно сгенерирован. Теперь выполните следующую команду от имени root:',
 'description' => 'Настройка системных служб',
 'minihowto' => 'На этой странице вы можете просмотреть различные шаблоны конфигурации для каждой службы, перенастроить определенные службы при необходимости или экспортировать текущий выбор в файл JSON для использования в скриптах CLI или на другом сервере.<br><br><b>Обратите внимание</b>, что отображаемые службы не отражают вашу текущую настройку, а показывают требования/рекомендации на основе текущих значений настроек.',
 'skipconfig' => 'Не (пере)настраивать',
 'recommendednote' => 'Рекомендуемые/обязательные службы на основе текущих настроек системы',
 'selectrecommended' => 'Выбрать рекомендованное',
 'downloadselected' => 'Экспортировать выбранное',
 ],

'templates' => [
		'templates' => 'Шаблоны электронной почты',

		'template_add' => 'Добавить шаблон',

		'template_fileadd' => 'Добавить файловый шаблон',

		'template_edit' => 'Редактировать шаблон',

		'action' => 'Действие',

		'email' => 'Шаблоны писем и файлов',

		'subject' => 'Тема',

		'mailbody' => 'Текст письма',

		'createcustomer' => 'Приветственное письмо для новых клиентов',

		'pop_success' => 'Приветственное письмо для новых почтовых аккаунтов',

		'template_replace_vars' => 'Переменные, которые будут заменены в шаблоне:',

		'SALUTATION' => 'Заменяется на правильное обращение (имя или название компании)',

		'FIRSTNAME' => 'Заменяется на имя клиента.',

		'NAME' => 'Заменяется на фамилию клиента.',

		'COMPANY' => 'Заменяется на название компании клиента',

		'USERNAME' => 'Заменяется на имя пользователя учетной записи клиента.',

		'PASSWORD' => 'Заменяется на пароль учетной записи клиента.',

		'EMAIL' => 'Заменяется на адрес почтового аккаунта POP3/IMAP.',

		'CUSTOMER_NO' => 'Заменяется на номер клиента',

		'TRAFFIC' => 'Заменяется на объем трафика, выделенный клиенту.',

		'TRAFFICUSED' => 'Заменяется на израсходованный клиентом объем трафика.',

		'pop_success_alternative' => 'Приветственное письмо для новых почтовых аккаунтов, отправленное на альтернативный адрес',

		'EMAIL_PASSWORD' => 'Заменяется на пароль почтового аккаунта POP3/IMAP.',

		'index_html' => 'Индексный файл для вновь созданных директорий клиентов',

		'SERVERNAME' => 'Заменяется на имя сервера.',

		'CUSTOMER' => 'Заменяется на имя входа клиента.',

		'ADMIN' => 'Заменяется на имя входа администратора.',

		'CUSTOMER_EMAIL' => 'Заменяется на адрес электронной почты клиента.',

		'ADMIN_EMAIL' => 'Заменяется на адрес электронной почты администратора.',

		'filetemplates' => 'Файловые шаблоны',

		'filecontent' => 'Содержимое файла',

		'new_database_by_customer' => 'Уведомление клиента о создании базы данных',

		'new_ftpaccount_by_customer' => 'Уведомление клиента о создании FTP-пользователя',

		'newdatabase' => 'Уведомления о создании новых баз данных',

		'newftpuser' => 'Уведомления о создании новых FTP-пользователей',

		'CUST_NAME' => 'Имя клиента',

		'DB_NAME' => 'Имя базы данных',

		'DB_PASS' => 'Пароль базы данных',

		'DB_DESC' => 'Описание базы данных',

		'DB_SRV' => 'Сервер базы данных',

		'PMA_URI' => 'URL для phpMyAdmin (если указан)',

		'USR_NAME' => 'Имя пользователя FTP',

		'USR_PASS' => 'Пароль FTP',

		'USR_PATH' => 'Домашняя директория FTP (относительно документ-корня клиента)',

		'forgotpwd' => 'Уведомления о сбросе пароля',

		'password_reset' => 'Уведомление клиента о сбросе пароля',

		'trafficmaxpercent' => 'Уведомление клиентам, когда заданный максимум процента трафика исчерпан',

		'MAX_PERCENT' => 'Заменяется на лимит дискового пространства/трафика для отправки отчетов в процентах.',

		'USAGE_PERCENT' => 'Заменяется на использование дискового пространства/трафика клиентом в процентах.',

		'diskmaxpercent' => 'Уведомление клиентам, когда заданный максимум процента дискового пространства исчерпан',

		'DISKAVAILABLE' => 'Заменяется на объем дискового пространства, выделенного клиенту.',

		'DISKUSED' => 'Заменяется на использование дискового пространства клиентом.',

		'LINK' => 'Заменяется на ссылку для сброса пароля клиента.',

		'SERVER_HOSTNAME' => 'Заменяет системное имя хоста (URL для Froxlor)',

		'SERVER_IP' => 'Заменяет IP-адрес сервера по умолчанию',

		'SERVER_PORT' => 'Заменяет порт сервера по умолчанию',

		'DOMAINNAME' => 'Заменяет стандартное поддоменное имя клиента (может быть пустым, если ни одно не сгенерировано)',

	],
	'webserver' => 'Веб-сервер',

	'createzonefile' => 'Создать файл зоны DNS для домена',

	'custombindzone' => 'Пользовательский/неконтролируемый файл зоны',

	'bindzonewarning' => 'пусто для значений по умолчанию<br /><strong class="text-danger">ВНИМАНИЕ:</strong> Если вы используете файл зоны, вам также потребуется управлять всеми необходимыми записями для всех подзон вручную.',

	'ipsandports' => [
		'ipsandports' => 'IP-адреса и порты',

		'add' => 'Добавить IP-адрес/порт',

		'edit' => 'Редактировать IP-адрес/порт',

		'ipandport' => 'IP-адрес/порт',

		'ip' => 'IP-адрес',

		'ipnote' => '<div id="ipnote" class="invalid-feedback">Примечание: Несмотря на то, что частные IP-адреса разрешены, некоторые функции, такие как DNS, могут работать неправильно.<br>Используйте только частные IP-адреса, если вы уверены.</div>',

		'port' => 'Порт',

		'create_listen_statement' => 'Создать инструкцию Listen',

		'create_namevirtualhost_statement' => 'Создать инструкцию NameVirtualHost',

		'create_vhostcontainer' => 'Создать контейнер vHost',

		'create_vhostcontainer_servername_statement' => 'Создать инструкцию ServerName в контейнере vHost',

		'enable_ssl' => 'Это SSL-порт?',

		'ssl_cert_file' => 'Путь до SSL-сертификата',

		'webserverdefaultconfig' => 'Конфигурация веб-сервера по умолчанию',

		'webserverdomainconfig' => 'Конфигурация домена веб-сервера',

		'webserverssldomainconfig' => 'Настройки SSL веб-сервера',

		'ssl_key_file' => 'Путь до SSL-ключа',

		'ssl_ca_file' => 'Путь до SSL-CA сертификата',

		'default_vhostconf_domain' => 'Настройки vHost по умолчанию для каждого контейнера домена',

		'ssl_cert_chainfile' => [
			'title' => 'Путь до файл рядов сертификатов SSL',

			'description' => 'Обычно CA_Bundle или подобное. Скорее всего, вы захотите установить это, если купили SSL-сертификат.',

		],
		'docroot' => [
			'title' => 'Пользовательский корневой каталог (пусто - указывает на Froxlor)',

			'description' => 'Здесь вы можете определить пользовательский корневой каталог (назначение для запроса) для данной комбинации IP-адреса/порта.<br /><strong>ВНИМАНИЕ:</strong> Пожалуйста, будьте осторожны с тем, что вводите здесь!',

		],

        'ssl_paste_description' => 'Вставьте полное содержимое сертификата в текстовое поле',
 'ssl_cert_file_content' => 'Содержимое SSL-сертификата',
 'ssl_key_file_content' => 'Содержимое SSL-ключа (приватного)',
 'ssl_ca_file_content' => 'Содержимое SSL CA-файла (необязательно)',
 'ssl_ca_file_content_desc' => '<br /><br />Аутентификация клиента, устанавливайте это только если вы знаете, что это такое.',
 'ssl_cert_chainfile_content' => 'Содержимое файла цепочки сертификатов (необязательно)',
 'ssl_cert_chainfile_content_desc' => '<br /><br />Обычно CA_Bundle или подобное. Скорее всего, вы захотите установить это, если купили SSL-сертификат.',
 'ssl_default_vhostconf_domain' => 'Настройки SSL vHost по умолчанию для каждого контейнера домена',
 ], 'memorylimitdisabled' => 'Отключено',
 'valuemandatory' => 'Это значение обязательно',
 'valuemandatorycompany' => 'Необходимо заполнить либо "имя" и "фамилию", либо "компанию"',
 'serversoftware' => 'Серверное программное обеспечение',
 'phpversion' => 'Версия PHP',
 'mysqlserverversion' => 'Версия сервера MySQL',
 'webserverinterface' => 'Интерфейс веб-сервера',
 'accountsettings' => 'Настройки учетной записи',
 'panelsettings' => 'Настройки панели',
 'systemsettings' => 'Системные настройки',
 'webserversettings' => 'Настройки веб-сервера',
 'mailserversettings' => 'Настройки почтового сервера',
 'nameserversettings' => 'Настройки DNS-сервера',
 'updatecounters' => 'Пересчитать использование ресурсов',
 'subcanemaildomain' => [ 'never' => 'Никогда',
 'choosableno' => 'Выбираемо, по умолчанию нет',
 'choosableyes' => 'Выбираемо, по умолчанию да',
 'always' => 'Всегда',
 ], 'wipecleartextmailpwd' => 'Очистить пароли в явном виде',
 'webalizersettings' => 'Настройки Webalizer',
 'webalizer' => [ 'normal' => 'Обычный',
 'quiet' => 'Тихий',
 'veryquiet' => 'Без вывода',
 ], 'domain_nocustomeraddingavailable' => 'В настоящее время невозможно добавить домен. Сначала вам нужно добавить хотя бы одного клиента.',
 'loggersettings' => 'Настройки журнала',
 'logger' => [ 'normal' => 'Обычный',
 'paranoid' => 'Параноид',
 ], 'emaildomain' => 'Домен электронной почты',
 'email_only' => 'Только электронная почта?',
 'wwwserveralias' => 'Добавить ServerAlias "www."',
 'subject' => 'Тема',
 'recipient' => 'Получатель',
 'message' => 'Введите сообщение',
 'text' => 'Сообщение',
 'sslsettings' => 'Настройки SSL',
 'specialsettings_replacements' => 'Вы можете использовать следующие переменные:<br/><code>{DOMAIN}</code>, <code>{DOCROOT}</code>, <code>{CUSTOMER}</code>, <code>{IP}</code>, <code>{PORT}</code>, <code>{SCHEME}</code>, <code>{FPMSOCKET}</code> (если применимо)<br/>',
 'dkimsettings' => 'Настройки DomainKeys',
 'caneditphpsettings' => 'Можно изменять настройки домена, связанные с PHP?',
 'allips' => 'Все IP-адреса',
 'awstatssettings' => 'Настройки AWstats',
 'domain_dns_settings' => 'Настройки DNS-домена',
 'activated' => 'Активирован',
 'statisticsettings' => 'Настройки статистики',
 'or' => 'или',
 'sysload' => 'Загрузка системы',
 'noloadavailable' => 'недоступно',
 'nouptimeavailable' => 'недоступно',
 'nosubject' => '(Без темы)',
 'security_settings' => 'Параметры безопасности',
 'know_what_youre_doing' => 'Изменяйте только, если вы знаете, что делаете!',
 'show_version_login' => [ 'title' => 'Показывать версию Froxlor при входе в систему',
 'description' => 'Показывать версию Froxlor в подвале на странице входа в систему',
 ], 'show_version_footer' => [ 'title' => 'Показывать версию Froxlor в подвале',
 'description' => 'Показывать версию Froxlor в подвале на остальных страницах',
 ], 'froxlor_graphic' => [ 'title' => 'Изображение в шапке Froxlor',
 'description' => 'Какое изображение должно отображаться в шапке',
 ],

         'phpsettings' => 
		 [ 'title' => 'Настройки PHP',
 'description' => 'Краткое описание',
 'actions' => 'Действия',
 'activedomains' => 'Используется для домена(ов)',
 'notused' => 'Конфигурация не используется',
 'editsettings' => 'Изменить настройки PHP',
 'addsettings' => 'Создать новые настройки PHP',
 'viewsettings' => 'Просмотреть настройки PHP',
 'phpinisettings' => 'Настройки php.ini',
 'addnew' => 'Создать новую конфигурацию PHP',
 'binary' => 'Бинарный файл PHP',
 'fpmdesc' => 'Настройки PHP-FPM',
 'file_extensions' => 'Расширения файлов',
 'file_extensions_note' => '(без точки, разделенные пробелами)',
 'enable_slowlog' => 'Включить slowlog (для каждого домена)',
 'request_terminate_timeout' => 'Тайм-аут завершения запроса',
 'request_slowlog_timeout' => 'Тайм-аут slowlog запроса',
 'activephpconfigs' => 'Используется для настроек php-config(s)',
 'pass_authorizationheader' => 'Передача заголовков HTTP AUTH BASIC/DIGEST от Apache к PHP',
 ], 'misc' => 'Разное',
 'fpmsettings' => [ 'addnew' => 'Создать новую версию PHP',
 'edit' => 'Изменить версию PHP' ], 'phpconfig' => [ 'template_replace_vars' => 'Переменные, которые будут заменены в конфигурациях',
 'pear_dir' => 'Будет заменено глобальным значением для каталога PEAR.',
 'open_basedir_c' => 'Будет вставлена ; (точка с запятой) для закомментирования/отключения open_basedir, если его установить',
 'open_basedir' => 'Будет заменено значением open_basedir для домена.',
 'tmp_dir' => 'Будет заменено временным каталогом для домена.',
 'open_basedir_global' => 'Будет заменено глобальным значением пути, который будет добавлен к open_basedir (см. настройки веб-сервера).',
 'customer_email' => 'Будет заменено адресом электронной почты клиента, которому принадлежит этот домен.',
 'admin_email' => 'Будет заменено адресом электронной почты администратора, которому принадлежит этот домен.',
 'domain' => 'Будет заменено доменом.',
 'customer' => 'Будет заменено именем входа клиента, которому принадлежит этот домен.',
 'admin' => 'Будет заменено именем входа администратора, которому принадлежит этот домен.',
 'docroot' => 'Будет заменено корневым каталогом домена.',
 'homedir' => 'Будет заменено домашним каталогом клиента.',
 ], 'expert_settings' => 'Настройки для экспертов!',
 'mod_fcgid_starter' => [ 'title' => 'PHP-процессы для этого домена (пусто для значения по умолчанию)',
 ], 'phpserversettings' => 'Настройки PHP-FPM',
 'mod_fcgid_maxrequests' => [ 'title' => 'Максимальное количество запросов PHP для этого домена (пусто для значения по умолчанию)',
 ], 'spfsettings' => 'Настройки SPF-домена',
 'specialsettingsforsubdomains' => 'Применить специальные настройки для всех поддоменов (.example.com)',
 'accountdata' => 'Данные учетной записи',
 'contactdata' => 'Контактные данные',
 'servicedata' => 'Данные об услугах',
 'newerversionavailable' => 'Доступна новая версия Froxlor.',
 'newerversiondetails' => 'Обновить до версии <b>%s</b> сейчас?<br/>(Ваша текущая версия: %s)',
 'extractdownloadedzip' => 'Распаковать загруженный архив "%s"?',
 'cron' => [ 'cronsettings' => 'Настройки задач Cron',
 'add' => 'Добавить задачу Cron',
 ], 'cronjob_edit' => 'Изменить задачу Cron',
 'warning' => 'ПРЕДУПРЕЖДЕНИЕ - Пожалуйста, обратите внимание!',
 'lastlogin_succ' => 'Последний вход',
 'ftpserver' => 'Сервер FTP',
 'ftpserversettings' => 'Настройки сервера FTP',
 'webserver_user' => 'Имя пользователя веб-сервера',
 'webserver_group' => 'Имя группы веб-сервера',
 'perlenabled' => 'Включен Perl',
 'fcgid_settings' => 'FCGID',
 'mod_fcgid_user' => 'Корневой пользователь для FCGID (Froxlor vHost)',
 'mod_fcgid_group' => 'Корневая группа для FCGID (Froxlor vHost)',
 'perl_settings' => 'Perl/CGI',
 'notgiven' => '[не указано]',
 'store_defaultindex' => 'Сохранить индексный файл по умолчанию в документ-корне клиента',
 'phpfpm_settings' => 'PHP-FPM',
 'traffic' => 'Трафик',
 'traffic_sub' => 'Детали использования трафика',
 'domaintraffic' => 'Домены',
 'customertraffic' => 'Клиенты',
 'assignedmax' => 'Назначено / Макс',
 'usedmax' => 'Использовано / Макс',
 'used' => 'Использовано',
 'speciallogwarning' => '<div id="speciallogfilenote" class="invalid-feedback">ПРЕДУПРЕЖДЕНИЕ: Изменение этой настройки приведет к потере старой статистики для этого домена.</div>',
 'speciallogfile' => [ 'title' => 'Отдельный журнал',
 'description' => 'Включить это, чтобы получить отдельный файл журнала доступа для этого домена',
 ], 'domain_editable' => [ 'title' => 'Разрешить редактирование домена',
 'desc' => 'Если установлено значение "да", клиенту разрешено изменять несколько настроек домена.<br />Если установлено значение "нет", клиент не может ничего изменить.',
 ], 'writeaccesslog' => [ 'title' => 'Записывать журнал доступа',
 'description' => 'Включить это, чтобы получить файл журнала доступа для этого домена',
 ], 'writeerrorlog' => [ 'title' => 'Записывать журнал ошибок',
 'description' => 'Включить это, чтобы получить файл журнала ошибок для этого домена',
 ], 'phpfpm.ininote' => 'Вы не можете использовать все значения, которые хотите определить, в конфигурации пула php-fpm.',
 'phpinfo' => 'PHPinfo()',
 'selectserveralias' => 'ServerAlias для домена',
 'selectserveralias_desc' => 'Выберите, создаст ли froxlor подстановочную запись (.domain.tld), WWW-alias (www.domain.tld) или не создаст никакой подстановочной записи',
 'show_news_feed' => [ 'title' => 'Показывать новости в основной панели администратора',
 'description' => 'Включить эту опцию, чтобы отображать официальные новости Froxlor (https://inside.froxlor.org/news/) на вашей панели инструментов и никогда не упускать важную информацию или объявления о выпуске.',
 ],

         'cronsettings' => 'Настройки задач Cron',
 
		 'integritycheck' => 'Проверка целостности базы данных',
 
		 'integrityname' => 'Имя',
 
		 'integrityresult' => 'Результат',
 
		 'integrityfix' => 'Автоматическое исправление проблем',
 
		 'customer_show_news_feed' => 'Показывать новостную ленту на панели клиента',
 
		 'customer_news_feed_url' => [ 'title' => 'Использовать пользовательскую RSS-ленту',
 
		 'description' => 'Укажите пользовательскую RSS-ленту, которая будет отображаться на панели клиента.<br /><small>Оставьте это поле пустым, чтобы использовать официальную новостную ленту Froxlor (https://inside.froxlor.org/news/).</small>',
 ], 'movetoadmin' => 'Переместить клиента',
 
		 'movecustomertoadmin' => 'Переместить клиента к выбранному администратору/реселлеру<br /><small>Оставьте это поле пустым, чтобы не изменять. Если нужного администратора нет в списке, значит, он достиг предела клиентов, которых может обслуживать.</small>',
 'note' => 'Примечание',
 'mod_fcgid_umask' => [ 'title' => 'Umask (по умолчанию: 022)',
 ], 'apcuinfo' => 'Информация об APCu',
 'opcacheinfo' => 'Информация об OPcache',
 'letsencrypt' => [ 'title' => 'Использовать Lets Encrypt',
 'description' => 'Получите бесплатный сертификат от <a href="https://letsencrypt.org">Lets Encrypt </a>. Сертификат будет создан и автоматически обновляться.<br><strong class="text-danger">ВНИМАНИЕ:</strong> Если используется подстановочные символы, эта опция будет автоматически отключена.',
 ], 'autoupdate' => 'Автообновление',
 'server_php' => 'PHP',
 'dnsenabled' => 'Включить редактор DNS',
 'froxlorvhost' => 'Настройки виртуального хоста Froxlor',
 'hostname' => 'Имя хоста',
 'memory' => 'Использование памяти',
 'webserversettings_ssl' => 'Настройки веб-сервера SSL',
 'domain_hsts_maxage' => [ 'title' => 'HTTP Strict Transport Security (HSTS)',
 'description' => 'Укажите значение max-age для заголовка Strict-Transport-Security<br>Значение <i>0</i> отключит HSTS для домена. Большинство пользователей устанавливают значение <i>31536000</i> (один год).',
 ],

         'domain_hsts_incsub' => [ 'title' => 'Включить HSTS для любого поддомена',
 'description' => 'Необязательная директива "includeSubDomains", если присутствует, указывает UA, что политика HSTS распространяется на этот хост HSTS, а также на любые поддомены домена хоста.',
 ], 'domain_hsts_preload' => [ 'title' => 'Включить домен в список предварительной загрузки HSTS <a href="https://hstspreload.org/" target="_blank">https://hstspreload.org/</a>',
 'description' => 'Если вы хотите, чтобы этот домен был включен в спискок предварительной загрузки HSTS, поддерживаемый Chrome (и используемыми Firefox и Safari), активируйте эту опцию.<br>Отправка директивы предварительной загрузки из вашего сайта может иметь ПОСТОЯННЫЕ ПОСЛЕДСТВИЯ и запретить пользователям получение доступа к вашему сайту и любому из его поддоменов.<br>Пожалуйста, прочитайте детали <a href="https://hstspreload.org/#removal" target="_blank">https://hstspreload.org/#removal</a>, прежде чем отправлять заголовок с "preload".',
 ], 'domain_ocsp_stapling' => [ 'title' => 'Степлер OCSP',
 'description' => 'Подробнее см. <a target="_blank" href="https://en.wikipedia.org/wiki/OCSP_stapling">Wikipedia</a> для подробного объяснения степлера OCSP',
 'nginx_version_warning' => '<br /><strong class="text-danger">ПРЕДУПРЕЖДЕНИЕ:</strong> Для степлера OCSP требуется версия Nginx 1.3.7 или выше. Если ваша версия более старая, веб-сервер НЕ будет правильно запущен при включенном степлере OCSP!',
 ], 'domain_http2' => [ 'title' => 'Поддержка HTTP2',
 'description' => 'Подробнее см. <a target="_blank" href="https://en.wikipedia.org/wiki/HTTP/2">Wikipedia</a> для подробного объяснения HTTP2',
 ], 'testmail' => 'Тест SMTP',
 'phpsettingsforsubdomains' => 'Применить настройки PHP для всех поддоменов:',
 'plans' => [ 'name' => 'Имя тарифа',
 'description' => 'Описание',
 'last_update' => 'Последнее обновление',
 'plans' => 'Тарифы хостинга',
 'plan_details' => 'Сведения о тарифе',
 'add' => 'Добавить новый тариф',
 'edit' => 'Изменить тариф',
 'use_plan' => 'Применить тариф',
 ], 'notryfiles' => [ 'title' => 'Не использовать автогенерируемый try_files',
 'description' => 'Выберите "да", если вы хотите указать специальную директиву try_files в specialsettings (например, для некоторых плагинов wordpress).',
 ], 'logviewenabled' => 'Включить доступ к файлам журнала доступа/ошибок',
 'novhostcontainer' => '<br><br><small class="text-danger">Ни один из IP-адресов и портов не имеет включенной опции "Create vHost-Container", множество настроек здесь будет недоступно</small>',
 'ownsslvhostsettings' => 'Собственные настройки SSL vHost',
 'domain_override_tls' => 'Переопределение системных настроек TLS',
 'domain_override_tls_addinfo' => '<br /><span class="text-danger">Используется только если "Override system TLS settings" установлено в "Да"</span>',
 'domain_sslenabled' => 'Включить использование SSL',
 'domain_honorcipherorder' => 'Соблюдение порядка шифров (квазипорядок), значение по умолчанию <strong>нет</strong>',
 'domain_sessiontickets' => 'Включить билеты TLS-сессии (RFC 5077), значение по умолчанию <strong>да</strong>',
 'domain_sessionticketsenabled' => [ 'title' => 'Включить использование билетов TLS-сессии глобально',
 'description' => 'Значение по умолчанию <strong>да</strong><br>Требуется apache-2.4.11+ или nginx-1.5.9+',
 ],

         'domaindefaultalias' => 'Значение по умолчанию для новых доменов в ServerAlias',
 'smtpsettings' => 'Настройки SMTP',
 'smtptestaddr' => 'Отправить тестовое письмо на',
 'smtptestnote' => 'Обратите внимание, что ниже приведены ваши текущие настройки и их можно изменить только там (см. ссылку в правом верхнем углу)',
 'smtptestsend' => 'Отправить тестовое письмо',
 'mysqlserver' => [ 'mysqlserver' => 'Сервер MySQL',
 'dbserver' => 'Сервер №',
 'caption' => 'Описание',
 'host' => 'Имя хоста / IP',
 'port' => 'Порт',
 'user' => 'Привилегированный пользователь',
 'add' => 'Добавить новый сервер MySQL',
 'edit' => 'Изменить сервер MySQL',
 'password' => 'Пароль привилегированного пользователя',
 'password_emptynochange' => 'Новый пароль, оставьте пустым для отсутствия изменений',
 'allowall' => [ 'title' => 'Разрешить использование этого сервера всем текущим клиентам',
 'description' => 'Установите значение "true", чтобы разрешить использование этого сервера баз данных всем текущим клиентам, чтобы они могли создавать на нем базы данных. Эта настройка не является постоянной, но может быть применена несколько раз.',
 ], 'testconn' => 'Проверить подключение при сохранении',
 'ssl' => 'Использовать SSL для подключения к серверу базы данных',
 'ssl_cert_file' => 'Путь к файлу SSL-сертификата',
 'verify_ca' => 'Включить проверку SSL-сертификата сервера',
 ], 'settings_importfile' => 'Выбрать файл импорта',
 'documentation' => 'Документация',
 'adminguide' => 'Руководство администратора',
 'userguide' => 'Руководство пользователя',
 'apiguide' => 'Руководство по API',
 ], 'apcuinfo' => [ 'clearcache' => 'Очистить кэш APCu',
 'generaltitle' => 'Общая информация о кэше',
 'version' => 'Версия APCu',
 'phpversion' => 'Версия PHP',
 'host' => 'Хост APCu',
 'sharedmem' => 'Общая память',
 'sharedmemval' => '%d сегмент(ы) на %s (%s памяти)',
 'start' => 'Время запуска',
 'uptime' => 'Время работы',
 'upload' => 'Поддержка загрузки файлов',
 'cachetitle' => 'Информация о кэше',
 'cvar' => 'Кэшированные переменные',
 'hit' => 'Попадания',
 'miss' => 'Промахи',
 'reqrate' => 'Частота запросов (попадания, промахи)',
 'creqsec' => 'запросов кэша в секунду',
 'hitrate' => 'Частота попаданий',
 'missrate' => 'Частота промахов',
 'insrate' => 'Частота вставок',
 'cachefull' => 'Количество заполненных кэшей',
 'runtime' => 'Настройки времени выполнения',
 'memnote' => 'Использование памяти',
 'total' => 'Всего',
 'free' => 'Свободно',
 'used' => 'Использовано',
 'hitmiss' => 'Попадания и промахи',
 'detailmem' => 'Подробное использование памяти и фрагментация',
 'fragment' => 'Фрагментация',
 'nofragment' => 'Без фрагментации',
 'fragments' => 'Фрагменты',
 ],


        'apikeys' => [ 'no_api_keys' => 'API-ключи не найдены',
 'key_add' => 'Добавить новый ключ',
 'apikey_removed' => 'API-ключ с ID #%s успешно удален',
 'apikey_added' => 'Новый API-ключ успешно создан',
 'clicktoview' => 'Нажмите для просмотра',
 'allowed_from' => 'Разрешено с',
 'allowed_from_help' => 'Список IP-адресов / сетей через запятую.<br>По умолчанию пусто (разрешено со всех).',
 'valid_until' => 'Действителен до',
 'valid_until_help' => 'Дата окончания действия в формате ГГГГ-ММ-ДДThh:mm',
 ], 'changepassword' => [ 'old_password' => 'Старый пароль',
 'new_password' => 'Новый пароль',
 'new_password_confirm' => 'Подтвердите пароль',
 'new_password_ifnotempty' => 'Новый пароль (пусто = без изменений)',
 'also_change_ftp' => ' также изменить пароль основного FTP-аккаунта',
 'also_change_stats' => ' также изменить пароль для страницы статистики',
 ], 'cron' => [ 'cronname' => 'Имя задания cron',
 'lastrun' => 'Последнее выполнение',
 'interval' => 'Интервал',
 'isactive' => 'Включено',
 'description' => 'Описание',
 'changewarning' => 'Изменение этих значений может привести к нежелательным последствиям для работы Froxlor и его автоматических задач.<br>Изменяйте значения только если вы уверены, что знаете, что делаете.',
 ],
		 'crondesc' => [ 'cron_unknown_desc' => 'Описание не предоставлено',
 'cron_tasks' => 'Генерация конфигурационных файлов',
 'cron_legacy' => 'Унаследованное (старое) задание cron',
 'cron_traffic' => 'Расчет трафика',
 'cron_usage_report' => 'Отчеты о веб- и трафике',
 'cron_mailboxsize' => 'Расчет размера почтового ящика',
 'cron_letsencrypt' => 'Обновление сертификатов Lets Encrypt ',
 
		 'cron_backup' => 'Обработка заданий резервного копирования',
 ], 'cronjob' => [ 'cronjobsettings' => 'Настройки задания cron',
 'cronjobintervalv' => 'Значение интервала выполнения',
 'cronjobinterval' => 'Интервал выполнения',
 ], 'cronjobs' => [ 'notyetrun' => 'Еще не запущено',
 ],


        'cronmgmt' => [ 'minutes' => 'минуты',
 'hours' => 'часы',
 'days' => 'дни',
 'weeks' => 'недели',
 'months' => 'месяцы',
 ], 'customer' => [ 'documentroot' => 'Домашняя директория',
 'name' => 'Имя',
 'firstname' => 'Имя',
 'lastname' => 'Фамилия',
 'company' => 'Компания',
 'nameorcompany_desc' => 'Требуется имя/фамилия или компания',
 'street' => 'Улица',
 'zipcode' => 'Почтовый индекс',
 'city' => 'Город',
 'phone' => 'Телефон',
 'fax' => 'Факс',
 'email' => 'Эл. почта',
 'customernumber' => 'ID клиента',
 'diskspace' => 'Веб-пространство',
 'traffic' => 'Трафик',
 'mysqls' => 'MySQL-базы данных',
 'emails' => 'Адреса эл. почты',
 'accounts' => 'Учетные записи эл. почты',
 'forwarders' => 'Переадресации эл. почты',
 'ftps' => 'FTP-аккаунты',
 'subdomains' => 'Поддомены',
 'domains' => 'Домены',
 'mib' => 'MiB',
 'gib' => 'GiB',
 'title' => 'Заголовок',
 'country' => 'Страна',
 'email_quota' => 'Квота эл. почты',
 'email_imap' => 'Эл. почта IMAP',
 'email_pop3' => 'Эл. почта POP3',
 'sendinfomail' => 'Отправить данные мне по эл. почте',
 'generated_pwd' => 'Предложение пароля',
 'usedmax' => 'Использовано / Макс.',
 'services' => 'Сервисы',
 'letsencrypt' => [ 'title' => 'Использовать Lets Encrypt ',
 'description' => 'Получите бесплатный сертификат от <a href="https://letsencrypt.org">Lets Encrypt </a>. Сертификат будет создан и обновляться автоматически.',
 ], 'selectserveralias_addinfo' => 'Эту опцию можно установить при редактировании домена. Его начальное значение наследуется от родительского домена.',
 'total_diskspace' => 'Всего дискового пространства',
 'mysqlserver' => 'Используемый MySQL-сервер',
 ],

'diskquota' => 'Квота',
 'dkim' => [ 'dkim_prefix' => [ 'title' => 'Префикс',
 'description' => 'Пожалуйста, укажите путь к файлам DKIM RSA, а также к файлам конфигурации для плагина Milter',
 ], 'dkim_domains' => [ 'title' => 'Имя файла домена',
 'description' => '<em>Имя файла</em> параметра DKIM Domains, указанного в конфигурации dkim-milter',
 ], 'dkim_dkimkeys' => [ 'title' => 'Имя файла списка ключей',
 'description' => '<em>Имя файла</em> параметра DKIM KeyList, указанного в конфигурации dkim-milter',
 ], 'dkimrestart_command' => [ 'title' => 'Команда перезапуска Milter',
 'description' => 'Пожалуйста, укажите команду перезапуска сервиса DKIM milter',
 ], 'privkeysuffix' => [ 'title' => 'Суффикс приватных ключей',
 'description' => 'Вы можете указать (необязательное) расширение/суффикс имени файла для генерации приватных ключей dkim. Некоторые службы, такие как dkim-filter, требуют, чтобы это поле было пустым',
 ], 'use_dkim' => [ 'title' => 'Активировать поддержку DKIM?',
 'description' => 'Вы хотите использовать систему Domain Keys (DKIM)?<br/><em class="text-danger">Примечание: Поддержка DKIM возможна только с использованием dkim-filter, а не opendkim (пока)</em>',
 ], 'dkim_algorithm' => [ 'title' => 'Разрешенные алгоритмы хеширования',
 'description' => 'Определите разрешенные алгоритмы хеширования, выберите "All" для всех алгоритмов или один или несколько из доступных алгоритмов',
 ], 'dkim_servicetype' => 'Типы служб',
 'dkim_keylength' => [ 'title' => 'Длина ключа',
 'description' => 'Внимание: Если вы измените эти значения, вам необходимо удалить все приватные/публичные ключи в "%s"',
 ], 'dkim_notes' => [ 'title' => 'Заметки DKIM',
 'description' => 'Заметки, которые могут быть интересны человеку, например, URL-адрес, такой как http://www.dnswatch.info. Никакая программа не делает интерпретацию. Этот тег следует использовать осторожно из-за ограничений пространства в DNS. Он предназначен для использования администраторами, а не конечными пользователями.',
 ], ], 'dns' => [ 'destinationip' => 'IP-адрес(а) домена',
 'standardip' => 'Стандартный IP-адрес сервера',
 'a_record' => 'A-запись (IPv6 - опционально)',
 'cname_record' => 'CNAME-запись',
 'mxrecords' => 'Определить записи MX',
 'standardmx' => 'Стандартная запись MX сервера',
 'mxconfig' => 'Пользовательские записи MX',
 'priority10' => 'Приоритет 10',
 'priority20' => 'Приоритет 20',
 'txtrecords' => 'Определить записи TXT',
 'txtexample' => 'Пример (SPF-запись):<br />v=spf1 ip4:xxx.xxx.xx.0/23 -all',
 'howitworks' => 'Здесь вы можете управлять записями DNS для вашего домена. Обратите внимание, что froxlor автоматически генерирует записи NS/MX/A/AAAA для вас. Пользовательские записи предпочтительны, автоматически будут сгенерированы только отсутствующие записи.',
 ], 'dnseditor' => [ 'edit' => 'Редактировать DNS',
 'records' => 'записи',
 'notes' => [ 'A' => '32-битный IPv4-адрес, который используется для сопоставления имен хостов с IP-адресом хоста.',
 'AAAA' => '128-битный IPv6-адрес, который используется для сопоставления имен хостов с IP-адресом хоста.',
 'CAA' => 'Запись ресурса CAA позволяет владельцу имени домена DNS указывать одну или несколько аккредитованных предприятием по сертификации (УЦ) учреждений, которые имеют право выдавать сертификаты для этого домена.<br>Структура: <code>flag tag[issue|issuewild|iodef|contactmail|contactphone] value</code><br>Пример: <code>0 issue "ca.example.net"<br>0 iodef "mailto:security@example.com"</code>',
 'CNAME' => 'Алиас имени домена, поиск DNS будет продолжен путем повторной попытки поиска с новым именем. Возможно только для поддоменов!',
 'DNAME' => 'Создает псевдоним для всего поддерева дерева имени домена',
 'LOC' => 'Географическая информация о местоположении домена.<br>Структура: <code>( d1 [m1 [s1]] {"N"|"S"} d2 [m2 [s2]] {"E"|"W"} alt["m"] [siz["m"] [hp["m"] [vp["m"]]]] )</code><br>Описание: <code>d1: [0 .. 90] (градусы широты) d2: [0 .. 180] (градусы долготы) m1, m2: [0 .. 59] (минуты широты/долготы) s1, s2: [0 .. 59.999] (секунды широты/долготы) alt: [-100000.00 .. 42849672.95] BY .01 (высота над уровнем моря в метрах) siz, hp, vp: [0 .. 90000000.00] (размер/точность в метрах)</code><br>Пример: <code>52 22 23.000 N 4 53 32.000 E -2.00m 0.00m 10000m 10m</code>',
 'MX' => 'Запись обмена почтой, сопоставляющая имя домена с почтовым сервером для этого домена.<br>Пример: <code>10 mail.example.com</code><br>Примечание: Для приоритета используйте поле выше',
 'NS' => 'Передает зону DNS для использования указанными проводниками имени.',
 'RP' => 'Запись Responsible Person<br>Структура: <code>текстовый_ящик[заменить @ на точку] имя-записи-txt</code><br>Пример: <code>team.froxlor.org. froxlor.org.</code>',
 'SRV' => 'Запись расположения службы, используется для более новых протоколов вместо создания протоколо-специфических записей, таких как MX.<br>Структура: <code>приоритет вес порт цель</code><br>Пример: <code>0 5 5060 sipserver.example.com.</code><br>Примечание: Для приоритета используйте поле выше',
 'SSHFP' => 'Запись ресурса SSHFP используется для публикации отпечатков ключей безопасного обмена (SSH) в DNS.<br>Структура: <code>алгоритм тип отпечатка</code><br>Алгоритмы: <code>0: зарезервировано, 1: RSA, 2: DSA, 3: ECDSA, 4: Ed25519, 6: Ed448</code><br>Типы: <code>0: зарезервировано, 1: SHA-1, 2: SHA-256</code><br>Пример: <code>2 1 123456789abcdef67890123456789abcdef67890</code>',
 'TXT' => 'Свободно определяемый, описательный текст.' ] ],

'domain' => [ 'openbasedirpath' => 'Путь OpenBasedir',
 'docroot' => 'Путь выше',
 
    'homedir' => 'Домашняя директория',
 'docparent' => 'Родительская директория пути выше',
 
    'ssl_certificate_placeholder' => '---- НАЧАЛО СЕРТИФИКАТА---' . PHP_EOL . '[...]' . PHP_EOL . '----КОНЕЦ СЕРТИФИКАТА----',
 
    'ssl_key_placeholder' => '---- НАЧАЛО ЧАСТНОГО КЛЮЧА RSA-----' . PHP_EOL . '[...]' . PHP_EOL . '-----КОНЕЦ ЧАСТНОГО КЛЮЧА RSA-----',
 ], 
    'domains' => [ 'description' => 'Здесь вы можете создавать (под)домены и изменять их пути.<br />Системе потребуется некоторое время для применения новых настроек после каждого изменения.',
 'domainsettings' => 'Настройки домена',
 'domainname' => 'Имя домена',
 'subdomain_add' => 'Создать поддомен',
 'subdomain_edit' => 'Изменить (под)домен',
 
        'wildcarddomain' => 'Создать как маскировочный домен?',
 'aliasdomain' => 'Псевдоним для домена',
 
        'noaliasdomain' => 'Нет псевдонима домена',
 'hasaliasdomains' => 'Есть псевдоним(ы) домена',
 'statstics' => 'Статистика использования',
 
        'isassigneddomain' => 'Назначенный домен',
 'add_date' => 'Добавлен в Froxlor',
 'registration_date' => 'Добавлен в реестр',
 
        'topleveldomain' => 'Домен верхнего уровня',
 'associated_with_domain' => 'Ассоциировано',
 'aliasdomains' => 'Псевдонимы доменов',
 
        'redirectifpathisurl' => 'Код перенаправления (по умолчанию: пусто)',
 
        'redirectifpathisurlinfo' => 'Вам нужно выбрать только один из них, если вы ввели URL-адрес в качестве пути<br/><strong class="text-danger">ВНИМАНИЕ:</strong> Изменения применяются только в том случае, если указанный путь является URL-адресом.',

        'issubof' => 'Этот домен является поддоменом другого домена',
 
        'issubofinfo' => 'Вы должны установить здесь правильный домен, если хотите добавить поддомен в качестве полного домена (например, если вы хотите добавить "www.domain.tld", вам необходимо выбрать здесь "domain.tld")',
 
        
     'nosubtomaindomain' => 'Нет поддомена для полного домена',
 
	 'ipandport_multi' => [ 'title' => 'IP-адрес(а)',
 
	 'description' => 'Укажите один или несколько IP-адресов для домена.<br /><br /><div class="text-danger">ЗАМЕЧАНИЕ: IP-адреса нельзя изменять, когда домен настроен как <strong>псевдоним-домена</strong> для другого домена.</div>',
 ],
	  'ipandport_ssl_multi' => [ 'title' => 'SSL IP-адрес(а)',
 ], 
	  'ssl_redirect' => [ 'title' => 
	  'SSL-перенаправление',
 
	  'description' => 'Эта опция создает перенаправления для виртуальных хостов без SSL, чтобы все запросы перенаправлялись на SSL-виртуальный хост.<br /><br />например, запрос к <strong>http</strong>://domain.tld/ будет перенаправлен на <strong>https</strong>://domain.tld/',
 ], 
	  'serveraliasoption_wildcard' => 'Шаблон (*.domain.tld)',
 'serveraliasoption_www' => 'WWW (www.domain.tld)',
 'serveraliasoption_none' => 'Без псевдонима',
 'domain_import' => 'Импорт доменов',
 'import_separator' => 'Разделитель',
 'import_offset' => 'Смещение',
 'import_file' => 'Файл CSV',
 'import_description' => 'Подробная информация о структуре файла импорта и способах успешного импорта вы можете найти на странице <a href="https://docs.froxlor.org/latest/admin-guide/domain-import/" target="_blank" class="alert-link">https://docs.froxlor.org/latest/admin-guide/domain-import/</a>',
 'ssl_redirect_temporarilydisabled' => '<br>SSL-перенаправление временно отключено при генерации нового сертификата Lets Encrypt. Оно будет активировано снова после создания сертификата.',
 'termination_date' => 'Дата завершения',
 'termination_date_overview' => 'Завершено с ',
 'ssl_certificates' => 'SSL-сертификаты',
 
	  
	  'ssl_certificate_removed' => 'Сертификат с идентификатором #%s успешно удален',

	   'ssl_certificate_error' => 'Ошибка чтения сертификата для домена: %s',
 
	   'no_ssl_certificates' => 'Нет доменов с SSL-сертификатом',
 
	   'isaliasdomainof' => 'Является псевдонимом для %s',
 'isbinddomain' => 'Создание DNS-зоны',

	    'dkimenabled' => 'DKIM включен',
 'openbasedirenabled' => 'Ограничение Openbasedir',
 
		'hsts' => 'Включен HSTS',
 'aliasdomainid' => 'Идентификатор псевдонима-домена',
 ],
		 'emails' => [ 
			'description' => 'Здесь вы можете создавать и изменять адреса электронной почты.<br />Аккаунт подобен вашему почтовому ящику перед вашим домом. Если кто-то отправляет вам электронное письмо, оно будет помещено в аккаунт.<br /><br />Чтобы загрузить свои электронные письма, используйте следующие настройки в вашей почтовой программе (данные в <i>курсиве</i> должны быть изменены на соответствующие введенные значения!)<br />Имя хоста: <b><i>имя_домена</i></b><br />Имя пользователя: <b><i>имя_аккаунта/адрес_электронной_почты</i></b><br />пароль: <b><i>ваш_пароль</i></b>',
 'emailaddress' => 'Адрес электронной почты',
 'emails_add' => 'Создать адрес электронной почты',
 'emails_edit' => 'Изменить адрес электронной почты',
 'catchall' => 'Catchall',
 'iscatchall' => 'Установите как адрес catchall?',
 'account' => 'Аккаунт',
 'account_add' => 'Создать аккаунт',
 'account_delete' => 'Удалить аккаунт',
 'from' => 'Исходный адрес',
 'to' => 'Направление',
 'forwarders' => 'Перенаправления',
 'forwarder_add' => 'Создать перенаправление',
 'alternative_emailaddress' => 'Альтернативный адрес электронной почты',
 'quota' => 'Квота',
 'noquota' => 'Без квоты',
 'updatequota' => 'Обновить квоту',
 'quota_edit' => 'Изменить квоту электронной почты',
 'noemaildomainaddedyet' => 'У вас пока нет (электронного) домена в вашей учетной записи.',
 'back_to_overview' => 'Вернуться к обзору домена',
 'accounts' => 'Аккаунты',
 'emails' => 'Адреса',
 ],   
 'error' => [
	'error' => 'Ошибка',
    'givendirnotallowed' => 'Указанная директория в поле %s не разрешена.',
 
	'sslredirectonlypossiblewithsslipport' => 'Использование Lets Encrypt  возможно только при наличии хотя бы одного назначенного разрешения SSL IP/порт для домена.',

	 'fcgidstillenableddeadlock' => 'FCGID в настоящее время активен. Пожалуйста, отключите его перед переключением на другой веб-сервер, отличный от Apache2 или lighttpd.',
 'send_report_title' => 'Отправить отчет об ошибке',
 
	 'send_report_desc' => 'Благодарим вас за сообщение об этой ошибке и помощь в улучшении Froxlor. <br />Вот электронное письмо, которое будет отправлено команде разработчиков Froxlor:',
 'send_report' => 'Отправить отчет',
 
	 'send_report_error' => 'Ошибка при отправке отчета: <br />%s',
 
	 'notallowedtouseaccounts' => 'Ваша учетная запись не позволяет использовать IMAP/POP3. Вы не можете добавлять учетные записи электронной почты.',
 'cannotdeletehostnamephpconfig' => 'Эта конфигурация PHP используется виртуальным хостом Froxlor и не может быть удалена.',
 'cannotdeletedefaultphpconfig' => 'Эта конфигурация PHP установлена по умолчанию и не может быть удалена.',
 'passwordshouldnotbeusername' => 'Пароль не должен совпадать с именем пользователя.',
 'no_phpinfo' => 'Извините, невозможно прочитать phpinfo ()',
 'moveofcustomerfailed' => 'Перемещение клиента в выбранный админ/реселлер не удалось. Имейте в виду, что все остальные изменения клиента успешно применены на этом этапе.<br><br>Ошибка: %s',
 'domain_import_error' => 'Возникла следующая ошибка при импорте доменов: %s',
 
	 'fcgidandphpfpmnogoodtogether' => 'FCGID и PHP-FPM не могут быть активированы одновременно',
 'no_apcuinfo' => 'Информация о кэше недоступна. Не удается запустить APCu.',
 'no_opcacheinfo' => 'Информация о кэше недоступна. OPCache не запущен.',
 'nowildcardwithletsencrypt' => 'Lets Encrypt  не может обрабатывать домены-шаблоны с использованием ACME в Froxlor (требуется проверка DNS), извините. Пожалуйста, установите ServerAlias в WWW или полностью его отключите',
 'customized_version' => 'Похоже, ваша установка Froxlor была изменена, мы не оказываем поддержку, извините.',
 'autoupdate_0' => 'Неизвестная ошибка',
 'autoupdate_1' => 'Настройка PHP allow_url_fopen отключена. Auto Update требует включенной этой настройки в php.ini',
 'autoupdate_2' => 'Не найдено расширение PHP zip, пожалуйста, убедитесь, что оно установлено и активировано',
 'autoupdate_4' => 'Архив Froxlor не может быть сохранен на диске :(',
 'autoupdate_5' => 'version.froxlor.org вернул неприемлемые значения :(',
 'autoupdate_6' => 'Уупс, не была указана (действительная) версия для загрузки :(',
 'autoupdate_7' => 'Не удалось найти загруженный архив :(',
 'autoupdate_8' => 'Не удалось извлечь архив :(',
 'autoupdate_9' => 'Загруженный файл не прошел проверку целостности. Попробуйте обновить еще раз.',
 'autoupdate_10' => 'Минимальная поддерживаемая версия PHP - 7.4.0',
 'autoupdate_11' => 'Webupdate отключен',
 'mailaccistobedeleted' => 'Другая учетная запись с тем же именем (%s) в настоящее время удаляется и поэтому не может быть добавлена в настоящий момент.',
 'customerhasongoingbackupjob' => 'Уже есть ожидающая обработки задача резервного копирования, пожалуйста, будьте терпеливы.',
 'backupfunctionnotenabled' => 'Функция резервного копирования не включена',
 'dns_domain_nodns' => 'DNS не включен для этого домена',
 'dns_content_empty' => 'Не указано содержимое',
 'dns_content_invalid' => 'Недопустимое содержимое DNS',
 'dns_arec_noipv4' => 'Не указан действительный IP-адрес для записи A',
 'dns_aaaarec_noipv6' => 'Не указан действительный IP-адрес для записи AAAA',
 'dns_mx_prioempty' => 'Указано недопустимое приоритет MX',
 'dns_mx_needdom' => 'Значением содержимого MX должно быть действительное доменное имя',
 'dns_mx_noalias' => 'Значение содержимого MX не может быть записью CNAME.',
 'dns_cname_invaliddom' => 'Недействительное доменное имя для записи CNAME',
 'dns_cname_nomorerr' => 'Уже существует ресурсная запись с тем же именем записи. Она не может быть использована как CNAME.',
 'dns_other_nomorerr' => 'Уже существует запись CNAME с тем же именем записи. Она не может быть использована для другого типа.',
 'dns_ns_invaliddom' => 'Недействительное доменное имя для записи NS',
 'dns_srv_prioempty' => 'Указано недопустимое значение приоритета SRV',
 'dns_srv_invalidcontent' => 'Недопустимое значение содержимого SRV, оно должно состоять из полей "вес", "порт" и "цель", например: 5 5060 sipserver.example.com.',
 'dns_srv_needdom' => 'Значение цели SRV должно быть действительным доменным именем',
 'dns_srv_noalias' => 'Значение цели SRV не может быть записью CNAME.',
 'dns_duplicate_entry' => 'Запись уже существует',
 'dns_notfoundorallowed' => 'Домен не найден или отсутствует разрешение',
 'domain_nopunycode' => 'Вы не должны указывать punycode (IDNA). Домен будет автоматически преобразован',
 'dns_record_toolong' => 'Записи/метки должны быть не более 63 символов',
 'noipportgiven' => 'IP/порт не указаны',
 'jsonextensionnotfound' => 'Эта функция требует расширения json для php.',
 'cannotdeletesuperadmin' => 'Первый администратор не может быть удален.',
 'no_wwwcnamae_ifwwwalias' => 'Нельзя установить запись CNAME для "www", так как для домена установлено создание псевдонима www. Пожалуйста, измените настройки на "Без псевдонима" или "Псевдоним по шаблону"',
 'local_group_exists' => 'Указанная группа уже существует на системе.',
 'local_group_invalid' => 'Указанное имя группы является недопустимым',
 'invaliddnsforletsencrypt' => 'DNS-домен не содержит ни одного из выбранных IP-адресов. Невозможно создать сертификат Lets Encrypt .',
 'notallowedphpconfigused' => 'Попытка использования php-config, которая не назначена клиенту',
 'pathmustberelative' => 'Пользователь не имеет разрешения на указание каталогов вне домашнего каталога клиента. Пожалуйста, укажите относительный путь (без ведущего /).',
 'mysqlserverstillhasdbs' => 'Невозможно удалить сервер баз данных из списка разрешенных клиента, так как на нем всё еще есть базы данных.',
 'domaincannotbeedited' => 'У вас нет прав на редактирование домена %s',
 'invalidcronjobintervalvalue' => 'Интервал Cronjob должен быть одним из: %s',
 'phpgdextensionnotavailable' => 'Расширение PHP GD недоступно. Не удалось проверить изображение',
 
	 '2fa_wrongcode' => 'Введенный код недействителен',
 ],
	 
	 'extras' => [ 
		'description' => 'Здесь вы можете добавить некоторые дополнительные элементы, например, защиту директории. <br />Системе потребуется некоторое время для применения новых настроек после каждого изменения.',
 'directoryprotection_add' => 'Добавить защиту директории',
 'view_directory' => 'Показать содержимое директории',
 'pathoptions_add' => 'Добавить параметры пути',
 'directory_browsing' => 'Просмотр содержимого директории',
 'pathoptions_edit' => 'Изменить параметры пути',
 'error404path' => '404',
 'error403path' => '403',
 'error500path' => '500',
 'error401path' => '401',
 'errordocument404path' => 'DocumentError 404',
 'errordocument403path' => 'DocumentError 403',
 'errordocument500path' => 'DocumentError 500',
 'errordocument401path' => 'DocumentError 401',
 'execute_perl' => 'Выполнение Perl/CGI',
 'htpasswdauthname' => 'Причина аутентификации(AuthName)',
 'directoryprotection_edit' => 'Изменить защиту директории',
 'backup' => 'Создать резервную копию',
 'backup_web' => 'Резервное копирование веб-данных',
 'backup_mail' => 'Резервное копирование данных почты',
 'backup_dbs' => 'Резервное копирование баз данных',
 'path_protection_label' => '<strong class="text-danger">Важно</strong>',
 'path_protection_info' => 'Мы настоятельно рекомендуем защитить указанный путь, см. "Дополнительно" -> "Защита директории"',
 ], 'ftp' => [ 'description' => 'Здесь вы можете создавать и изменять свои учетные записи FTP. <br />Изменения производятся немедленно и учетные записи можно использовать сразу.',
 'account_add' => 'Создать учетную запись',
 'account_edit' => 'Изменить учетную запись ftp',

	 'editpassdescription' => 'Установите новый пароль или оставьте поле пустым для отсутствия изменений.',
 ],
  'gender' => [ 'title' => 'Обращение',
 'male' => 'Г-н',
 'female' => 'Г-жа',
 'undef' => '',
 ], 'imprint' => 'Юридические указания',
 'index' => [ 'customerdetails' => 'Детали клиента',
 'accountdetails' => 'Детали учетной записи',
 ], 'integrity_check' => [ 'databaseCharset' => 'Кодировка базы данных (должна быть UTF-8)',
 'domainIpTable' => 'Сопоставление IP <‐> домены',
 'subdomainSslRedirect' => 'Флаг ложного SSL-перенаправления для не-SSL доменов',
 'froxlorLocalGroupMemberForFcgidPhpFpm' => 'Пользователь froxlor в группах клиента (для FCGID/php-fpm)',
 'webserverGroupMemberForFcgidPhpFpm' => 'Пользователь веб-сервера в группах клиента (для FCGID/php-fpm)',
 'subdomainLetsencrypt' => 'Основные домены без назначенного порта SSL не имеют ни одного поддомена, активирующего перенаправление SSL',
 ], 'logger' => [ 'date' => 'Дата',
 'type' => 'Тип',
 'action' => 'Действие',
 'user' => 'Пользователь',
 'truncate' => 'Очистить лог',
 'reseller' => 'Реселлер',
 'admin' => 'Администратор',
 'cron' => 'Cronjob',
 'login' => 'Вход',
 'intern' => 'Внутренний',
 'unknown' => 'Неизвестно',
 ], 'login' => [ 'username' => 'Имя пользователя',
 'password' => 'Пароль',
 'language' => 'Язык',
 'login' => 'Войти',
 'logout' => 'Выйти',
 'profile_lng' => 'Язык профиля',
 'welcomemsg' => 'Пожалуйста, войдите в систему, чтобы получить доступ к своей учетной записи.',
 'forgotpwd' => 'Забыли пароль?',
 'presend' => 'Сбросить пароль',
 'email' => 'Адрес электронной почты',
 'remind' => 'Сбросить пароль',
 'usernotfound' => 'Пользователь не найден!',
 'backtologin' => 'Вернуться к входу в систему',
 'combination_not_found' => 'Комбинация пользователя и адреса электронной почты не найдена.',
 '2fa' => 'Двухфакторная аутентификация (2FA)',
 '2facode' => 'Пожалуйста, введите код 2FA',
 ], 'mails' => [ 'pop_success' => [ 'mailbody' => 'Здравствуйте,\n\nваша учетная запись электронной почты {EMAIL}\nуспешно настроена.\n\nЭто автоматически созданное\nэлектронное письмо, пожалуйста, не отвечайте на него!\n\nС уважением, ваш администратор',
 'subject' => 'Учетная запись электронной почты успешно настроена',
 ], 'createcustomer' => [ 'mailbody' => 'Здравствуйте {SALUTATION},\n\nвот информация о вашей учетной записи:\n\nИмя пользователя: {USERNAME}\nПароль: {PASSWORD}\n\nСпасибо,\nваш администратор',
 'subject' => 'Информация об учетной записи',
 ], 'pop_success_alternative' => [ 'mailbody' => 'Здравствуйте {SALUTATION},\n\nваша учетная запись электронной почты {EMAIL}\nуспешно настроена.\nВаш пароль: {PASSWORD}.\n\nЭто автоматически созданное\nэлектронное письмо, пожалуйста, не отвечайте на него!\n\nС уважением, ваш администратор',
 'subject' => 'Учетная запись электронной почты успешно настроена',
 ], 'password_reset' => [ 'subject' => 'Сброс пароля',
 'mailbody' => 'Здравствуйте {SALUTATION},\n\nвот ваша ссылка для установки нового пароля. Ссылка действительна в течение следующих 24 часов.\n\n{LINK}\n\nСпасибо,\nваш администратор',
 ], 'new_database_by_customer' => [ 'subject' => '[Froxlor] Создана новая база данных',
 'mailbody' => 'Здравствуйте {CUST_NAME},

вы только что добавили новую базу данных. Вот введенная информация:

Имя базы данных: {DB_NAME} Пароль: {DB_PASS} Описание: {DB_DESC} DB-Hostname: {DB_SRV} phpMyAdmin: {PMA_URI} С уважением, ваш администратор',
 ], 'new_ftpaccount_by_customer' => [ 'subject' => 'Создан новый ftp-пользователь',
 'mailbody' => 'Здравствуйте {CUST_NAME},

вы только что создали нового ftp-пользователя. Вот введенная информация:

Имя пользователя: {USR_NAME} Пароль: {USR_PASS} Путь: {USR_PATH}

С уважением, ваш администратор',
 ], 'trafficmaxpercent' => [ 'mailbody' => 'Уважаемый {SALUTATION},\n\nвы использовали {TRAFFICUSED} из доступных {TRAFFIC} трафика.\nЭто больше {MAX_PERCENT}%%.\n\nС уважением, ваш администратор',
 'subject' => 'Достижение предела трафика',
 ], 'diskmaxpercent' => [ 'mailbody' => 'Уважаемый {SALUTATION},\n\nвы использовали {DISKUSED} из доступных {DISKAVAILABLE} дискового пространства.\nЭто больше {MAX_PERCENT}%%.\n\nС уважением, ваш администратор',
 'subject' => 'Достижение предела дискового пространства',
 ], '2fa' => [ 'mailbody' => 'Здравствуйте,\n\nваш код 2FA для входа: {CODE}.\n\nЭто автоматически созданное\nэлектронное письмо, пожалуйста, не отвечайте на него!\n\nС уважением, ваш администратор',
 'subject' => 'Froxlor - Код 2FA',
 ], ], 'menue' => [ 'main' => [ 'main' => 'Главная',
 'changepassword' => 'Сменить пароль',
 'changelanguage' => 'Сменить язык',
 'username' => 'Вы вошли как: ',
 'changetheme' => 'Сменить тему',
 'apihelp' => 'Справка по API',
 'apikeys' => 'API ключи',
 ], 'email' => [ 'email' => 'Почта',
 'emails' => 'Адреса',
 'webmail' => 'Веб-почта',
 'emailsoverview' => 'Обзор почтовых доменов',
 ], 'mysql' => [ 'mysql' => 'MySQL',
 'databases' => 'Базы данных',
 'phpmyadmin' => 'phpMyAdmin',
 ], 'domains' => [ 'domains' => 'Домены',
 'settings' => 'Обзор доменов',
 ], 'ftp' => [ 'ftp' => 'FTP',
 'accounts' => 'Учетные записи',
 'webftp' => 'WebFTP',
 ], 'extras' => [ 'extras' => 'Дополнительно',
 'directoryprotection' => 'Защита директории',
 'pathoptions' => 'Параметры пути',
 'backup' => 'Резервное копирование',
 ], 'traffic' => [ 'traffic' => 'Трафик',
 'current' => 'Текущий месяц',
 'overview' => 'Общий трафик',
 ], 'phpsettings' => [ 'maintitle' => 'Настройки PHP',
 'fpmdaemons' => 'Версии PHP-FPM',
 ], 'logger' => [ 'logger' => 'Системный журнал',
 ], ], 'message' => [ 'norecipients' => 'Не было отправлено ни одно письмо, так как в базе данных нет получателей',
 ],

'mysql' => [ 'databasename' => 'Имя пользователя/База данных',
 'databasedescription' => 'Описание базы данных',
 'database_create' => 'Создать базу данных',
 'description' => 'Здесь вы можете создавать и изменять свои MySQL-базы данных.<br />Изменения происходят мгновенно и база данных может быть использована немедленно.<br />В меню слева вы найдете инструмент phpMyAdmin, с помощью которого можно легко управлять базой данных.<br /><br />Для использования ваших баз данных в ваших собственных php-скриптах используйте следующие настройки: (Данные в <i>курсиве</i> должны быть заменены на введенные вами значения!)<br />Хост: <b><SQL_HOST></b><br />Имя пользователя: <b><i>имя пользователя</i></b><br />Пароль: <b><i>введенный вами пароль</i></b><br />База данных: <b><i>имя базы данных</i></b>',
 'mysql_server' => 'Сервер MySQL',
 'database_edit' => 'Изменить базу данных',
 'size' => 'Размер',
 'privileged_user' => 'Привилегированный пользователь базы данных',
 'privileged_passwd' => 'Пароль для привилегированного пользователя',
 'unprivileged_passwd' => 'Пароль для обычного пользователя',
 'mysql_ssl_ca_file' => 'SSL-серверный сертификат',
 'mysql_ssl_verify_server_certificate' => 'Проверка SSL-серверного сертификата',
 ], 'opcacheinfo' => [ 'generaltitle' => 'Общая информация',
 'resetcache' => 'Сбросить кеш OPCache',
 'version' => 'Версия OPCache',
 'phpversion' => 'Версия PHP',
 'runtimeconf' => 'Настройки времени выполнения',
 'start' => 'Время запуска',
 'lastreset' => 'Последний перезапуск',
 'oomrestarts' => 'Количество перезапусков из-за нехватки памяти',
 'hashrestarts' => 'Количество перезапусков из-за изменений хэша',
 'manualrestarts' => 'Количество ручных перезапусков',
 'hitsc' => 'Количество обращений',
 'missc' => 'Количество промахов',
 'blmissc' => 'Количество черных островов промахов',
 'status' => 'Статус',
 'never' => 'никогда',
 'enabled' => 'OPcache включен',
 'cachefull' => 'Кеш переполнен',
 'restartpending' => 'Ожидает перезапуска',
 'restartinprogress' => 'Идет перезапуск',
 'cachedscripts' => 'Количество кешированных скриптов',
 'memusage' => 'Использование памяти',
 'totalmem' => 'Общая память',
 'usedmem' => 'Использовано памяти',
 'freemem' => 'Свободно памяти',
 'wastedmem' => 'Потрачено памяти',
 'maxkey' => 'Максимальное количество ключей',
 'usedkey' => 'Использовано ключей',
 'wastedkey' => 'Потрачено ключей',
 'strinterning' => 'Внедрение строк',
 'strcount' => 'Количество строк',
 'keystat' => 'Статистика кешированных ключей',
 'used' => 'Используется',
 'free' => 'Свободно',
 'blacklist' => 'Черный список',
 'novalue' => '<i>нет значения</i>',
 'true' => '<i>true</i>',
 'false' => '<i>false</i>',
 'funcsavail' => 'Доступные функции',
 ], 'panel' => [ 'edit' => 'Изменить',
 'delete' => 'Удалить',
 'create' => 'Создать',
 'save' => 'Сохранить',
 'yes' => 'Да',
 'no' => 'Нет',
 'emptyfornochanges' => 'не заполняйте, если не хотите вносить изменений',
 'emptyfordefault' => 'не заполняйте, если хотите использовать значения по умолчанию',
 'path' => 'Путь',
 'toggle' => 'Переключить',
 'next' => 'Следующий',
 'dirsmissing' => 'Не удалось найти или прочитать директорию!',
 'unlimited' => '∞',
 'urloverridespath' => 'URL (заменяет путь)',
 'pathorurl' => 'Путь или URL',
 'ascending' => 'по возрастанию',
 'descending' => 'по убыванию',
 'search' => 'Поиск',
 'used' => 'используется',
 'translator' => 'Переводчик',
 'reset' => 'Отменить изменения',
 'pathDescription' => 'Если каталог не существует, он будет создан автоматически.',
 'pathDescriptionEx' => '<br /><br /><span class="text-danger">Обратите внимание:</span> Путь <code>/</code> не допускается из-за административных настроек, он будет автоматически установлен в <code>/chosen.subdomain.tld/</code>, если не установлен другой каталог.',
 'pathDescriptionSubdomain' => 'Если каталог не существует, он будет создан автоматически.<br /><br />Если вы хотите перенаправить на другой домен, введите URL, начинающийся с http:// или https://.<br /><br />Если URL заканчивается символом /, он считается папкой, в противном случае - файлом.',
 'back' => 'Назад',
 'reseller' => 'реселлер',
 'admin' => 'админ',
 'customer' => 'клиент(ов)',
 'send' => 'Отправить',
 'nosslipsavailable' => 'На данный момент для этого сервера не доступны комбинации ssl ip/port',
 'backtooverview' => 'Вернуться к обзору',
 'dateformat' => 'ГГГГ-ММ-ДД',
 'dateformat_function' => 'ГГГГ-М-Д',
 'timeformat_function' => 'Ч:М:С',
 'default' => 'По умолчанию',
 'neverloggedin' => 'Еще не был авторизован',
 'descriptionerrordocument' => 'Может быть URL, путь к файлу или просто строка, заключенная в кавычки " "<br />Оставьте пустым, чтобы использовать значение по умолчанию сервера.',
 'unlock' => 'Разблокировать',
 'theme' => 'Тема',
 'variable' => 'Переменная',
 'description' => 'Описание',
 'cancel' => 'Отмена',
 'ssleditor' => 'Настройки SSL для этого домена',
 'ssleditor_infoshared' => 'В настоящее время используется сертификат родительского домена',
 'ssleditor_infoglobal' => 'В настоящее время используется глобальный сертификат',
 'dashboard' => 'Панель управления',
 'assigned' => 'Назначено',
 'available' => 'Доступно',
 'news' => 'Новости',
 'newsfeed_disabled' => 'Канал новостей отключен. Щелкните по значку редактирования, чтобы перейти к настройкам.',
 'ftpdesc' => 'Описание FTP',
 'letsencrypt' => 'Использовать Lets Encrypt ',
 'set' => 'Установить',
 'shell' => 'Shell',
 'backuppath' => [ 'title' => 'Путь назначения для резервной копии',
 'description' => 'Здесь указывается путь, где будут храниться резервные копии. Если выбрано резервное копирование веб-данных, все файлы из домашнего каталога будут сохранены, за исключением папки резервной копии, указанной здесь.',
 ], 'none_value' => 'Нет',
 'viewlogs' => 'Просмотр журналов',
 'not_configured' => 'Система еще не настроена. Нажмите здесь, чтобы перейти к настройкам.',
 'ihave_configured' => 'Я настроил сервисы',
 'system_is_configured' => '<i class="fa-solid fa-circle-exclamation me-1"></i>Система уже настроена',
 'settings_before_configuration' => 'Пожалуйста, убедитесь, что вы настроили параметры до настройки сервисов здесь',
 'image_field_delete' => 'Удалить существующее текущее изображение',
 'usage_statistics' => 'Использование ресурсов',
 'security_question' => 'Контрольный вопрос',
 'listing_empty' => 'Записи не найдены',
 'unspecified' => 'не указано',
 'settingsmode' => 'Режим',
 'settingsmodebasic' => 'Базовый',
 'settingsmodeadvanced' => 'Расширенный',
 'settingsmodetoggle' => 'Нажмите, чтобы переключить режим',
 'modalclose' => 'Закрыть',
 'managetablecolumnsmodal' => [ 'title' => 'Управление столбцами таблицы',
 'description' => 'Здесь вы можете настроить видимые столбцы',
 ], 'mandatoryfield' => 'Поле обязательно для заполнения',
 'select_all' => 'Выбрать все',
 'unselect_all' => 'Отменить выбор',
 'searchtablecolumnsmodal' => [ 'title' => 'Поиск в полях',
 'description' => 'Выберите поле для поиска',
 ], 'upload_import' => 'Загрузить и импортировать',
 ],

  'phpfpm' => [
    'vhost_httpuser' => 'Локальный пользователь для использования PHP-FPM (Froxlor vHost)',

    'vhost_httpgroup' => 'Локальная группа для использования PHP-FPM (Froxlor vHost)',

    'ownvhost' => [
        'title' => 'Включить PHP-FPM для Froxlor vHost',

        'description' => 'Если включено, Froxlor также будет работать от имени локального пользователя',

    ],
    'use_mod_proxy' => [
        'title' => 'Использовать mod_proxy / mod_proxy_fcgi',

        'description' => '<strong class="text-danger">Должно быть включено при использовании Debian 9.x (Stretch) или новее</strong>. Активируйте, чтобы использовать php-fpm через mod_proxy_fcgi. Требуется, по меньшей мере, apache-2.4.9',

    ],
    'ini_flags' => 'Введите возможные <strong>php_flag</strong> для php.ini. Одна запись на строку.',

    'ini_values' => 'Введите возможные <strong>php_value</strong> для php.ini. Одна запись на строку.',

    'ini_admin_flags' => 'Введите возможные <strong>php_admin_flag</strong> для php.ini. Одна запись на строку.',

    'ini_admin_values' => 'Введите возможные <strong>php_admin_value</strong> для php.ini. Одна запись на строку.',

],
'privacy' => 'Политика конфиденциальности',

'pwdreminder' => [
    'success' => 'Запрос на сброс пароля успешно отправлен. Пожалуйста, следуйте инструкциям в полученном письме.',

    'notallowed' => 'Неизвестный пользователь или сброс пароля отключен',

    'changed' => 'Ваш пароль успешно обновлен. Теперь вы можете войти со своим новым паролем.',

    'wrongcode' => 'Извините, ваш код активации не существует или уже просрочен.',

    'choosenew' => 'Установить новый пароль',

],
'question' => [
    'question' => 'Вопрос безопасности',

    'admin_customer_reallydelete' => 'Вы действительно хотите удалить клиента %s? Это действие нельзя отменить!',

    'admin_domain_reallydelete' => 'Вы действительно хотите удалить домен %s?',

    'admin_domain_reallydisablesecuritysetting' => 'Вы действительно хотите отключить эту настройку безопасности OpenBasedir?',

    'admin_admin_reallydelete' => 'Вы действительно хотите удалить администратора %s? Каждый клиент и домен будет переприсвоен вашей учетной записи.',

    'admin_template_reallydelete' => 'Вы действительно хотите удалить шаблон \'%s\'?',

    'domains_reallydelete' => 'Вы действительно хотите удалить домен %s?',

    'email_reallydelete' => 'Вы действительно хотите удалить email-адрес %s?',

    'email_reallydelete_account' => 'Вы действительно хотите удалить email-аккаунт %s?',

    'email_reallydelete_forwarder' => 'Вы действительно хотите удалить пересылку %s?',

    'extras_reallydelete' => 'Вы действительно хотите удалить защиту каталога для %s?',

    'extras_reallydelete_pathoptions' => 'Вы действительно хотите удалить варианты пути для %s?',

    'extras_reallydelete_backup' => 'Вы действительно хотите прервать запланированную задачу резервного копирования?',

    'ftp_reallydelete' => 'Вы действительно хотите удалить FTP-аккаунт %s?',

    'mysql_reallydelete' => 'Вы действительно хотите удалить базу данных %s? Это действие нельзя отменить!',

    'admin_configs_reallyrebuild' => 'Вы действительно хотите перестроить все файлы конфигурации?',

    'admin_customer_alsoremovefiles' => 'Удалить также пользовательские файлы?',

    'admin_customer_alsoremovemail' => 'Полностью удалить email-данные с файловой системы?',

    'admin_customer_alsoremoveftphomedir' => 'Удалить также домашний каталог FTP-пользователя?',

    'admin_ip_reallydelete' => 'Вы действительно хотите удалить IP-адрес %s?',

    'admin_domain_reallydocrootoutofcustomerroot' => 'Вы уверены, что хотите разместить корневой каталог для этого домена не внутри корневого каталога клиента?',

    'admin_counters_reallyupdate' => 'Вы действительно хотите пересчитать использование ресурсов?',

    'admin_cleartextmailpws_reallywipe' => 'Вы действительно хотите удалить все незашифрованные пароли отчетов электронной почты из таблицы mail_users? Это действие нельзя отменить! Параметр для хранения паролей электронной почты в незашифрованном виде также будет отключен.',

    'logger_reallytruncate' => 'Вы действительно хотите усечь таблицу "%s"?',

    'admin_quotas_reallywipe' => 'Вы действительно хотите удалить все квоты в таблице mail_users? Это действие нельзя отменить!',

    'admin_quotas_reallyenforce' => 'Вы действительно хотите применить квоту по умолчанию ко всем пользователям? Это действие нельзя отменить!',

    'phpsetting_reallydelete' => 'Вы действительно хотите удалить эти настройки? Все домены, которые в настоящее время используют эти настройки, будут изменены на настройки по умолчанию.',

    'fpmsetting_reallydelete' => 'Вы действительно хотите удалить эти настройки php-fpm? Все конфигурации PHP, которые в настоящее время используют эти настройки, будут изменены на настройки по умолчанию.',

    'remove_subbutmain_domains' => 'Удалить также домены, которые добавлены в виде полных доменов, но являются поддоменами этого домена?',

    'customer_reallyunlock' => 'Вы действительно хотите разблокировать клиента %s?',

    'admin_integritycheck_reallyfix' => 'Вы действительно хотите попытаться автоматически исправить все проблемы целостности базы данных?',

    'plan_reallydelete' => 'Вы действительно хотите удалить хостинг-план %s?',

    'apikey_reallydelete' => 'Вы действительно хотите удалить этот ключ API?',

    'apikey_reallyadd' => 'Вы действительно хотите создать новый ключ API?',

    'dnsentry_reallydelete' => 'Вы действительно хотите удалить эту запись зоны?',

    'certificate_reallydelete' => 'Вы действительно хотите удалить этот сертификат?',

    'cache_reallydelete' => 'Вы действительно хотите очистить кэш?',

],
'redirect_desc' => [
    'rc_default' => 'по умолчанию',

    'rc_movedperm' => 'перемещено на постоянной основе',

    'rc_found' => 'найдено',

    'rc_seeother' => 'см. другой',

    'rc_tempred' => 'временное перенаправление',

],
'serversettings' => [
    'session_timeout' => [
        'title' => 'Таймаут сеанса',

        'description' => 'Как долго пользователь может быть неактивным, прежде чем сеанс станет недействительным (в секундах)?',

    ],
    'accountprefix' => [
        'title' => 'Префикс клиентского аккаунта',

        'description' => 'Какой префикс должны иметь клиентские аккаунты?',

    ],
    'mysqlprefix' => [
        'title' => 'Префикс SQL',

        'description' => 'Какой префикс должны иметь аккаунты MySQL?</br>Используйте "RANDOM" в качестве значения, чтобы получить случайный префикс из трех цифр</br>Используйте "DBNAME" в качестве значения, если поле имени базы данных используется вместе с именем клиента в качестве префикса.',

    ],
    'ftpprefix' => [
        'title' => 'Префикс FTP',

        'description' => 'Какой префикс должны иметь FTP-аккаунты?<br/><b>Если вы измените это, вам также нужно изменить запрос SQL квоты в файле конфигурации FTP-сервера, если вы используете его!</b> ',

    ],
    'documentroot_prefix' => [
        'title' => 'Домашний каталог',

        'description' => 'Где должны храниться все домашние каталоги?',

    ],
    'logfiles_directory' => [
        'title' => 'Каталог файлов журналов',

        'description' => 'Где должны храниться все файлы журналов?',

    ],
    'logfiles_script' => [
        'title' => 'Пользовательский скрипт для вывода файлов журналов',

        'description' => 'Вы можете указать здесь скрипт и использовать заполнители <strong>{LOGFILE}, {DOMAIN} и {CUSTOMER}</strong>, если это необходимо. В случае, если вы хотите использовать его, вам нужно также активировать опцию <strong>Перенаправление веб-сервера в файлы журналов</strong>. Префиксный символ "pipe" не требуется.',

    ],
    'logfiles_format' => [
        'title' => 'Формат файла журнала доступа',

        'description' => 'Введите здесь пользовательский формат журнала в соответствии с требованиями вашего веб-сервера, оставьте пустым для значения по умолчанию. В зависимости от вашего формата строка должна быть заключена в кавычки.<br/>Если используется с nginx, это будет выглядеть как <i>log_format frx_custom {CONFIGURED_VALUE}</i>.<br/>Если используется с Apache, это будет выглядеть как <i>LogFormat {CONFIGURED_VALUE} frx_custom</i>.<br/><strong>Внимание</strong>: Код не будет проверяться на наличие ошибок. Если в нем содержатся ошибки, веб-сервер может не запуститься снова!',

    ],
    'logfiles_type' => [
        'title' => 'Тип журнала доступа',

        'description' => 'Выберите здесь между <strong>combined</strong> или <strong>vhost_combined</strong>.',

    ],
    'logfiles_piped' => [
        'title' => 'Перенаправление веб-сервера в указанный скрипт (см. выше)',

        'description' => 'При использовании пользовательского скрипта для файлов журналов вы должны активировать это, чтобы он выполнился',

    ],
    'ipaddress' => [
        'title' => 'IP-адрес',

        'description' => 'Какой IP-адрес сервера?',

    ],
    'hostname' => [
        'title' => 'Имя хоста',

        'description' => 'Какое имя хоста сервера?',

    ],
    'apachereload_command' => [
        'title' => 'Команда перезагрузки веб-сервера',

        'description' => 'Какая команда веб-сервера для перезагрузки файлов конфигурации?',

    ],
    'bindenable' => [
        'title' => 'Включить DNS-сервер',

        'description' => 'Здесь вы можете включить и отключить DNS-сервер глобально.',

    ],
    'bindconf_directory' => [
        'title' => 'Каталог конфигурации DNS-сервера',

        'description' => 'Где должны сохраняться файлы конфигурации DNS-сервера?',

    ],
    'bindreload_command' => [
        'title' => 'Команда перезагрузки DNS-сервера',

        'description' => 'Какая команда для перезагрузки демона dns-сервера?',

    ],
    'vmail_uid' => [
        'title' => 'UID для писем',

        'description' => 'Какой UserID должны иметь письма?',

    ],
    'vmail_gid' => [
        'title' => 'GID для писем',

        'description' => 'Какой GroupID должны иметь письма?',

    ],
],


'vmail_homedir' => [
		'title' => 'Домашний каталог почты',

		'description' => 'Где должна храниться вся почта?',

	],
	'adminmail' => [
		'title' => 'Отправитель',

		'description' => 'Какой адрес отправителя для электронных писем, отправляемых из Панели?',

	],
	'phpmyadmin_url' => [
		'title' => 'URL phpMyAdmin',

		'description' => 'Какой URL для phpMyAdmin? (должен начинаться с http(s)://)',

	],
	'webmail_url' => [
		'title' => 'URL веб-почты',

		'description' => 'Какой URL для веб-почты? (должен начинаться с http(s)://)',

	],
	'webftp_url' => [
		'title' => 'URL веб-FTP',

		'description' => 'Какой URL для веб-FTP? (должен начинаться с http(s)://)',

	],
	'language' => [
		'description' => 'Какой язык используется на вашем сервере по умолчанию?',

	],
	'maxloginattempts' => [
		'title' => 'Максимальное количество попыток входа',

		'description' => 'Максимальное количество попыток входа после которых учетная запись будет отключена.',

	],
	'deactivatetime' => [
		'title' => 'Время отключения',

		'description' => 'Время (сек.) после которого учетная запись будет отключена после слишком многих попыток входа.',

	],
	'pathedit' => [
		'title' => 'Тип ввода пути',

		'description' => 'Путь должен выбираться из выпадающего меню или из поля ввода?',

	],
	'nameservers' => [
		'title' => 'Серверы имен',

		'description' => 'Список, разделенный запятыми, содержащий имена хостов всех серверов имен. Первый будет основным.',

	],
	'mxservers' => [
		'title' => 'MX-серверы',

		'description' => 'Список, разделенный запятыми, содержащий пару числа и имени хоста, разделенных пробелом (например, \'10 mx.example.com\'), содержащих MX-серверы.',

	],
	'paging' => [
		'title' => 'Записей на странице',

		'description' => 'Сколько записей должно отображаться на одной странице? (0 = отключить постраничный просмотр)',

	],
	'defaultip' => [
		'title' => 'IP/порт по умолчанию',

		'description' => 'Выберите все IP-адреса, которые вы хотите использовать для новых доменов по умолчанию',

	],
	'defaultsslip' => [
		'title' => 'IP/порт SSL по умолчанию',

		'description' => 'Выберите все включенные SSL IP-адреса, которые вы хотите использовать в новых доменах по умолчанию',

	],
	'phpappendopenbasedir' => [
		'title' => 'Пути для добавления в OpenBasedir',

		'description' => 'Эти пути (разделенные двоеточием) будут добавлены в инструкцию OpenBasedir в каждом контейнере vHost.',

	],
	'natsorting' => [
		'title' => 'Использовать естественную сортировку в списке',

		'description' => 'Сортирует списки как web1 -> web2 -> web11 вместо web1 -> web11 -> web2.',

	],
	'deactivateddocroot' => [
		'title' => 'Корневой каталог для отключенных пользователей',

		'description' => 'При деактивации пользователя этот путь используется как его корневой каталог. Оставьте пустым, чтобы не создавать вообще vHost.',

	],
	'mailpwcleartext' => [
		'title' => 'Также сохранять пароли почтовых аккаунтов в базе данных в открытом виде',

		'description' => 'Если это установлено в "yes", все пароли также будут сохранены в незашифрованном виде (в открытом виде, читаемом для всех, у кого есть доступ к базе данных) в таблице mail_users. Активируйте это только в случае, если планируете использовать SASL!',

	],
	'ftpdomain' => [
		'title' => 'FTP-аккаунты @домен',

		'description' => 'Клиенты могут создавать FTP-аккаунты пользователь@domain?',

	],
	'mod_fcgid' => [
		'title' => 'Включить FCGID',

		'description' => 'Используйте это для запуска PHP от имени соответствующей учетной записи пользователя.<br /><br /><b>Для этого требуется специальная конфигурация веб-сервера для Apache, смотрите <a target="_blank" href="https://docs.froxlor.org/latest/admin-guide/configuration/fcgid/">FCGID - руководство</a></b>',

		'configdir' => [
			'title' => 'Каталог конфигурации',

			'description' => 'Где должны храниться все файлы конфигурации fcgid? Если вы не используете самодельный программу suexec, что является обычной ситуацией, этот путь должен быть под /var/www/<br /><br /><div class="text-danger">ПРИМЕЧАНИЕ: Содержание этой папки регулярно удаляется, поэтому избегайте ручного сохранения данных в ней.</div>',

		],
		'tmpdir' => [
			'title' => 'Каталог временных файлов',

			'description' => 'Где должны храниться каталоги временных файлов',

		],
		'starter' => [
			'title' => 'Процессы на домен',

			'description' => 'Сколько процессов должно быть запущено/разрешено на домен? Рекомендуется значение 0, так как PHP будет самостоятельно эффективно управлять количеством процессов.',

		],
		'wrapper' => [
			'title' => 'Обертка в Vhosts',

			'description' => 'Как нужно включить обертку в Vhosts',

		],
		'peardir' => [
			'title' => 'Глобальные каталоги PEAR',

			'description' => 'Какие глобальные каталоги PEAR должны быть заменены во всех файлах конфигурации php.ini? Разные каталоги должны быть разделены двоеточием.',

		],
		'maxrequests' => [
			'title' => 'Максимальное количество запросов на домен',

			'description' => 'Сколько запросов должно быть разрешено на домен?',

		],


'defaultini' => 'Конфигурация PHP по умолчанию для новых доменов',
 'defaultini_ownvhost' => 'Конфигурация PHP по умолчанию для Froxlor-vHost',
 'idle_timeout' => [ 'title' => 'Время простоя',
 'description' => 'Настройка времени ожидания для Mod FastCGI.',
 ], ], 'sendalternativemail' => [ 'title' => 'Использовать альтернативный адрес электронной почты',
 'description' => 'Отправлять письмо с паролем на другой адрес при создании почтового аккаунта',
 ], 'apacheconf_vhost' => [ 'title' => 'Файл/каталог конфигурации VHost веб-сервера',
 'description' => 'Где должна храниться конфигурация VHost? Здесь вы можете указать файл (все VHost в одном файле) или каталог (каждый VHost в своем файле).',
 ], 'apacheconf_diroptions' => [ 'title' => 'Файл/каталог конфигурации опций каталога веб-сервера',
 'description' => 'Где должна храниться конфигурация опций каталога? Здесь вы можете указать файл (все опции каталога в одном файле) или каталог (каждая опция каталога в своем файле).',
 ], 'apacheconf_htpasswddir' => [ 'title' => 'Директория htpasswd веб-сервера',
 'description' => 'Где должны храниться файлы htpasswd для защиты каталога?',
 ], 'mysql_access_host' => [ 'title' => 'Хосты MySQL-исключений',
 'description' => 'Список, разделенный запятыми, хостов, с которых разрешено подключаться к серверу MySQL. Для разрешения подсети действителен формат netmask или cidr.',
 ], 'webalizer_quiet' => [ 'title' => 'Вывод Webalizer',
 'description' => 'Уровень подробности программы Webalizer',
 ], 'logger' => [ 'enable' => 'Регистрация включена/отключена',
 'severity' => 'Уровень регистрации',
 'types' => [ 'title' => 'Тип(ы) журнала',
 'description' => 'Укажите типы журнала. Чтобы выбрать несколько типов, удерживайте нажатой клавишу CTRL при выборе.<br />Доступные типы журналов: syslog, file, mysql',
 ], 'logfile' => [ 'title' => 'Имя файла журнала',
 'description' => 'Используется только при наличии типа журнала "file". Этот файл будет создан в froxlor/logs/. Этот каталог защищен от общего доступа.',
 ], 'logcron' => 'Логирование cron-задач',
 'logcronoption' => [ 'never' => 'Никогда',
 'once' => 'Один раз',
 'always' => 'Всегда',
 ], ], 'ssl' => [ 'use_ssl' => [ 'title' => 'Включить использование SSL',
 'description' => 'Установите флажок, если вы хотите использовать SSL для вашего веб-сервера',
 ], 'ssl_cert_file' => [ 'title' => 'Путь до SSL-сертификата',
 'description' => 'Укажите путь, включая имя файла .crt или .pem (основной сертификат)',
 ], 'openssl_cnf' => 'Настройки по умолчанию для создания файла сертификата',
 'ssl_key_file' => [ 'title' => 'Путь до файла с закрытым ключом SSL',
 'description' => 'Укажите путь, включая имя файла для файла с закрытым ключом (.key, в основном)',
 ], 'ssl_ca_file' => [ 'title' => 'Путь до файла SSL CA (необязательно)',
 'description' => 'Аутентификация клиента, установите это только, если вы знаете, что это такое.',
 ], 'ssl_cipher_list' => [ 'title' => 'Настройка разрешенных SSL-шифров',
 'description' => 'Это список шифров, которые вы хотите (или не хотите) использовать при общении по SSL. Для списка шифров и как включить/отключить их см. разделы "CIPHER LIST FORMAT" и "CIPHER STRINGS" на <a href="https://www.openssl.org/docs/manmaster/man1/openssl-ciphers.html">странице man ciphers</a>.<br /><br /><b>Значение по умолчанию:</b><pre>ECDH+AESGCM:ECDH+AES256:!aNULL:!MD5:!DSS:!DH:!AES128</pre>',
 ], 'apache24_ocsp_cache_path' => [ 'title' => 'Apache 2.4: путь до кэша OCSP stapling',
 'description' => 'Конфигурирует кэш, используемый для хранения ответов OCSP, которые включаются в рукопожатия TLS.',
 ], 'ssl_protocols' => [ 'title' => 'Настройка версии протокола TLS',
 'description' => 'Это список протоколов ssl, которые вы хотите (или не хотите) использовать при использовании SSL. <b>Внимание:</b> Некоторые старые браузеры могут не поддерживать новейшие версии протоколов.<br /><br /><b>Значение по умолчанию:</b><pre>TLSv1.2</pre>',
 ], 'tlsv13_cipher_list' => [ 'title' => 'Настройка конкретных шифров для TLSv1.3, если используется',
 'description' => 'Это список шифров, которые вы хотите (или не хотите) использовать при общении с TLSv1.3. Для списка шифров и как включать/отключать их, смотрите <a href="https://wiki.openssl.org/index.php/TLS1.3">документацию по TLSv1.3</a>.<br /><br /><b>Значение по умолчанию пустое.</b>',
 ], ], 'default_vhostconf' => [ 'title' => 'Настройки VHost по умолчанию',
 'description' => 'Содержимое этого поля будет включено непосредственно в контейнер ip/port VHost. Вы можете использовать следующие переменные:<br/><code>{DOMAIN}</code>, <code>{DOCROOT}</code>, <code>{CUSTOMER}</code>, <code>{IP}</code>, <code>{PORT}</code>, <code>{SCHEME}</code>, <code>{FPMSOCKET}</code> (если применимо)<br/>Внимание: Код не будет проверяться на наличие ошибок. Если в нем содержатся ошибки, веб-сервер может не перезагрузиться!',
 ], 'apache_globaldiropt' => [ 'title' => 'Опции каталога для префикса клиента',
 'description' => 'Содержимое этого поля будет включено в конфигурацию Apache 05_froxlor_dirfix_nofcgid.conf. Если оно пустое, будет использоваться значение по умолчанию:<br><br>apache >=2.4<br><code>Require all granted<br>AllowOverride All</code><br><br>apache <=2.2<br><code>Order allow,deny<br>allow from all</code>',
 ], 'default_vhostconf_domain' => [ 'description' => 'Содержимое этого поля будет включено непосредственно в контейнер домена VHost. Вы можете использовать следующие переменные:<br/><code>{DOMAIN}</code>, <code>{DOCROOT}</code>, <code>{CUSTOMER}</code>, <code>{IP}</code>, <code>{PORT}</code>, <code>{SCHEME}</code>, <code>{FPMSOCKET}</code> (если применимо)<br/>Внимание: Код не будет проверяться на наличие ошибок. Если в нем содержатся ошибки, веб-сервер может не перезагрузиться!',
 ], 'decimal_places' => 'Количество знаков после запятой в выводе трафика/пространства',
 'selfdns' => [ 'title' => 'Настройки DNS-домена клиента',
 ], 'selfdnscustomer' => [ 'title' => 'Разрешить клиентам редактировать настройки DNS-домена',
 ], 'unix_names' => [ 'title' => 'Использовать имена UNIX-совместимых пользователей',
 'description' => 'Позволяет использовать <strong>-</strong> и <strong>_</strong> в именах пользователей, если <strong>No</strong>',
 ], 'allow_password_reset' => [ 'title' => 'Разрешить сброс пароля клиентами',
 'description' => 'Клиенты могут сбросить свой пароль, и на их электронную почту будет отправлена ссылка активации',
 ], 'allow_password_reset_admin' => [ 'title' => 'Разрешить сброс пароля администраторами',
 'description' => 'Администраторы/реселлеры могут сбросить свой пароль, и на их электронную почту будет отправлена ссылка активации',
 ], 'mail_quota' => [ 'title' => 'Квота почтового ящика',
 'description' => 'Квота по умолчанию для новых созданных почтовых ящиков (Мегабайты).',
 ], 'mail_quota_enabled' => [ 'title' => 'Использовать квоту почтового ящика для клиентов',
 'description' => 'Активировать использование квот для почтовых ящиков. По умолчанию используется значение <b>Нет</b>, так как для этого требуется специальная настройка.',
 'removelink' => 'Нажмите здесь, чтобы удалить все квоты для почтовых аккаунтов.',
 'enforcelink' => 'Нажмите здесь, чтобы применить квоту по умолчанию ко всем почтовым аккаунтам пользователей.',
 ], 'index_file_extension' => [ 'description' => 'Какое расширение файла должно использоваться для индексного файла в новых созданных каталогах клиентов? Это расширение файла будет использоваться, если вы или один из ваших администраторов создали собственный шаблон файла индекса.',
 'title' => 'Расширение файла для индексного файла в новых созданных каталогах клиентов',
 ], 'session_allow_multiple_login' => [ 'title' => 'Разрешить множественный вход в систему',
 'description' => 'Если активировать, пользователь сможет войти несколько раз.',
 ], 'panel_allow_domain_change_admin' => [ 'title' => 'Разрешить перемещение доменов между администраторами',
 'description' => 'Если активировано, вы можете изменить администратора домена на странице настроек домена.<br /><b>Внимание:</b> Если клиент не назначен тому же администратору, что и домен, то администратор может видеть все другие домены этого клиента!',
 ],



'panel_allow_domain_change_customer' => [ 
	'title' => 'Разрешить перемещение доменов между клиентами',
 'description' => 'Если активировано, вы можете изменить клиента домена в настройках домена.<br /><b>Внимание:</b> Froxlor изменяет документацию для нового каталога клиента (+ папка домена, если активирована)',
 ], 
 'specialsettingsforsubdomains' => [ 
	'description' => 'Если да, эти пользовательские настройки vHost будут добавлены ко всем поддоменам; если нет, специальные настройки поддомена будут удалены.',
 ], 'panel_password_min_length' => [ 'title' => 'Минимальная длина пароля',
 'description' => 'Здесь вы можете установить минимальную длину паролей. 0 означает: минимальная длина не требуется.',
 ], 'system_store_index_file_subs' => [ 'title' => 'Сохранять файл индекса по умолчанию также в новых подпапках',
 'description' => 'Если включено, файл индекса по умолчанию сохраняется в каждом ново созданном поддоменном пути (не сохраняется, если папка уже существует!)',
 ], 'adminmail_return' => [ 'title' => 'Адрес для ответа',
 'description' => 'Укажите адрес электронной почты для ответа на электронные письма, отправленные панелью.',
 ], 'adminmail_defname' => 'Имя отправителя электронной почты панели управления',
 'stdsubdomainhost' => [ 'title' => 'Стандартное имя хоста клиента',
 'description' => 'Какое имя хоста должно использоваться для создания стандартных поддоменов для клиента. Если поле пустое, используется системное имя хоста.',
 ], 'awstats_path' => 'Путь к AWStats awstats_buildstaticpages.pl',
 'awstats_conf' => 'Путь конфигурации AWStats',
 'defaultttl' => 'Время жизни домена для привязки в секундах (по умолчанию 604800 = 1 неделя)',
 'defaultwebsrverrhandler_enabled' => 'Включить файлы ошибок по умолчанию для всех клиентов',
 'defaultwebsrverrhandler_err401' => [ 'title' => 'Файл/URL для ошибки 401',
 'description' => '<div class="text-danger">Не поддерживается в: lighttpd</div>',
 ], 'defaultwebsrverrhandler_err403' => [ 'title' => 'Файл/URL для ошибки 403',
 'description' => '<div class="text-danger">Не поддерживается в: lighttpd</div>',
 ], 'defaultwebsrverrhandler_err404' => 'Файл/URL для ошибки 404',
 'defaultwebsrverrhandler_err500' => [ 'title' => 'Файл/URL для ошибки 500',
 'description' => '<div class="text-danger">Не поддерживается в: lighttpd</div>',
 ], 'ftpserver' => [ 'desc' => 'Если выбран pureftpd, файлы .ftpquota для квот пользователей создаются и обновляются ежедневно',
 ], 'customredirect_enabled' => [ 'title' => 'Разрешить перенаправления клиентов',
 'description' => 'Разрешить клиентам выбирать код http-статуса для используемых перенаправлений',
 ], 'customredirect_default' => [ 'title' => 'Перенаправление по умолчанию',
 'description' => 'Установите код перенаправления, который будет использоваться по умолчанию, если клиент не установил его самостоятельно',
 ], 'mail_also_with_mxservers' => 'Создавайте также записи типа "A" для почты, imap, pop3 и smtp с установленными MX-серверами',
 'froxlordirectlyviahostname' => 'Доступ к Froxlor напрямую через имя хоста',
 'panel_password_regex' => [ 'title' => 'Регулярное выражение для пароля',
 'description' => 'Здесь вы можете установить регулярное выражение для сложности паролей.<br />Пусто = нет специальных требований',
 ], 'perl_path' => [ 'title' => 'Путь к perl',
 'description' => 'По умолчанию /usr/bin/perl',
 ], 'mod_fcgid_ownvhost' => [ 'title' => 'Включить FCGID для виртуального хоста Froxlor',
 'description' => 'Если включено, Froxlor будет работать также с локальным пользователем',
 ], 'perl' => [ 'suexecworkaround' => [ 'title' => 'Включить обход SuExec',
 'description' => 'Включите только в том случае, если домашние каталоги клиентов не находятся в рамках пути apache suexec.<br />Если включено, Froxlor сгенерирует символическую ссылку от директории клиента со включенным perl + /cgi-bin/ в указанный путь.<br />Обратите внимание, что perl будет работать только в поддиректории /cgi-bin/ и не в самой папке (как в обычном случае без этого исправления!)',
 ], 'suexeccgipath' => [ 'title' => 'Путь для символических ссылок в каталоге с включенным perl клиента',
 'description' => 'Вы должны указать это только в том случае, если обход SuExec включен.<br />ВНИМАНИЕ: Убедитесь, что этот путь находится в рамках пути suexec, иначе этот обход бесполезен',
 ], ], 'awstats_awstatspath' => 'Путь к AWStats awstats.pl',
 'awstats_icons' => [ 'title' => 'Путь к папке с иконками AWstats',
 'description' => 'например /usr/share/awstats/htdocs/icon/',
 ], 'login_domain_login' => 'Разрешить вход с помощью доменов',
 'perl_server' => [ 'title' => 'Местоположение сокета perl-сервера',
 'description' => 'Простое руководство можно найти по адресу: <a target="blank" href="https://www.nginx.com/resources/wiki/start/topics/examples/fcgiwrap/">nginx.com</a>',
 ], 'nginx_php_backend' => [ 'title' => 'Nginx PHP backend',
 'description' => 'здесь процесс PHP прослушивает запросы от nginx, может быть unix-сокетом или комбинацией ip:port<br />*Не используется с php-fpm',
 ], 'phpreload_command' => [ 'title' => 'Команда перезагрузки PHP',
 'description' => 'используется для перезагрузки PHP backend, если используется<br />По умолчанию: пусто<br />*Не используется с php-fpm',
 ], 'phpfpm' => [ 'title' => 'Включить php-fpm',
 'description' => '<b>Для этого требуется особая конфигурация веб-сервера, см. <a target="_blank" href="https://docs.froxlor.org/latest/admin-guide/configuration/php-fpm/">Руководство по PHP-FPM</a></b>',
 ], 'phpfpm_settings' => [ 'configdir' => 'Каталог конфигурации php-fpm',
 'aliasconfigdir' => 'Каталог псевдонимов конфигурации php-fpm',
 'reload' => 'Команда перезапуска php-fpm',
 'pm' => 'Управление процессом менеджера (pm)',
 'max_children' => [ 'title' => 'Количество дочерних процессов',
 'description' => 'Количество создаваемых дочерних процессов при установке pm в «статическом» и максимальное количество создаваемых дочерних процессов при установке pm в «динамическом/по требованию»<br />Эквивалентно PHP_FCGI_CHILDREN',
 ], 'start_servers' => [ 'title' => 'Количество дочерних процессов, создаваемых при запуске',
 'description' => 'Примечание: используется только при установке pm в «динамическом»',
 ], 'min_spare_servers' => [ 'title' => 'Желаемое минимальное количество простаивающих серверных процессов',
 'description' => 'Примечание: используется только при установке pm в «динамическом»<br />Примечание: обязательно, когда pm установлено в «динамическом»',
 ], 'max_spare_servers' => [ 'title' => 'Желаемое максимальное количество простаивающих серверных процессов',
 'description' => 'Примечание: используется только при установке pm в «динамическом»<br />Примечание: обязательно, когда pm установлено в «динамическом»',
 ], 'max_requests' => [ 'title' => 'Запросов на каждого потомка перед перезагрузкой',
 'description' => 'Для бесконечной обработки запросов укажите «0». Эквивалентно PHP_FCGI_MAX_REQUESTS.',
 ], 'idle_timeout' => [ 'title' => 'Задержка неактивности',
 'description' => 'Настройка тайм-аута для PHP FPM FastCGI.',
 ], 'ipcdir' => [ 'title' => 'Каталог FastCGI IPC',
 'description' => 'Каталог, в котором сокеты php-fpm будут храниться веб-сервером.<br />Этот каталог должен быть доступен для чтения веб-сервером',
 ], 'limit_extensions' => [ 'title' => 'Разрешенные расширения',
 'description' => 'Ограничивает расширения основного сценария, которые FPM разрешит анализировать. Это может предотвратить ошибки конфигурации на стороне веб-сервера. Вы должны ограничить FPM только расширениями .php, чтобы предотвратить использование злонамеренными пользователями других расширений для выполнения php-кода. Значение по умолчанию: .php',
 ],

'envpath' => 'Пути, которые нужно добавить в переменную среды PATH. Оставьте поле пустым, если переменная среды PATH не нужна',
 'override_fpmconfig' => 'Переопределить настройки FPM-демона (pm, max_children и т. д.)',
 'override_fpmconfig_addinfo' => '<br /><span class="text-danger">Используется только если параметр "Переопределить настройки FPM-демона" установлен на "Да"</span>',
 'restart_note' => 'Внимание: конфигурация не будет проверена на наличие ошибок. Если в ней есть ошибки, PHP-FPM может не запуститься снова!',
 'custom_config' => [ 'title' => 'Пользовательская конфигурация',
 'description' => 'Добавление пользовательской конфигурации в каждый экземпляр версии PHP-FPM, например <i>pm.status_path = /status</i> для мониторинга. Ниже можно использовать переменные. <strong>Внимание: конфигурация не будет проверена на наличие ошибок. Если в ней есть ошибки, PHP-FPM может не запуститься снова!</strong>',
 ], 'allow_all_customers' => [ 'title' => 'Назначить эту конфигурацию всем текущим клиентам',
 'description' => 'Установите значение "true", если хотите применить эту конфигурацию ко всем имеющимся на данный момент клиентам, чтобы они могли использовать ее. Эта настройка не является постоянной, но может быть выполнена несколько раз.',
 ], ], 'report' => [ 'report' => 'Включить отправку отчетов о использовании веб-сайтов и трафика',
 'webmax' => [ 'title' => 'Уровень предупреждения в процентах для веб-пространства',
 'description' => 'Допустимые значения от 0 до 150. Значение 0 отключает отчет.',
 ], 'trafficmax' => [ 'title' => 'Уровень предупреждения в процентах для трафика',
 'description' => 'Допустимые значения от 0 до 150. Значение 0 отключает отчет.',
 ], ], 'dropdown' => 'Выпадающий список',
 'manual' => 'Вручную',
 'default_theme' => 'Тема по умолчанию',
 'validate_domain' => 'Проверять домены',
 'diskquota_enabled' => 'Активирована квота?',
 'diskquota_repquota_path' => [ 'description' => 'Путь до команды repquota',
 ], 'diskquota_quotatool_path' => [ 'description' => 'Путь до команды quotatool',
 ], 'diskquota_customer_partition' => [ 'description' => 'Раздел, на котором хранятся файлы клиентов',
 ], 'vmail_maildirname' => [ 'title' => 'Имя Maildir',
 'description' => 'Каталог Maildir в учетной записи пользователя. Обычно используется Maildir, в некоторых реализациях maildir и напрямую в каталоге пользователя, если поле пустое.',
 ], 'catchall_enabled' => [ 'title' => 'Использовать Catchall',
 'description' => 'Хотите предоставить своим клиентам функцию перехвата всех адресов?',
 ], 'apache_24' => [ 'title' => 'Использовать модификации для Apache 2.4',
 'description' => '<strong class="text-danger">ВНИМАНИЕ:</strong> используйте только при установленной версии Apache 2.4 или выше<br />в противном случае ваш веб-сервер не сможет запуститься',
 ], 'nginx_fastcgiparams' => [ 'title' => 'Путь к файлу fastcgi_params для Nginx',
 'description' => 'Укажите путь к файлу fastcgi_params в Nginx, включая имя файла',
 ], 'documentroot_use_default_value' => [ 'title' => 'Использовать имя домена в качестве значения DocumentRoot по умолчанию',
 'description' => 'Если включено и путь DocumentRoot пустой, значение по умолчанию будет использоваться имя (под)домена.<br /><br />Примеры: <br />/var/customers/customer_name/example.com/<br />/var/customers/customer_name/subdomain.example.com/',
 ], 'panel_phpconfigs_hidesubdomains' => [ 'title' => 'Скрыть поддомены в обзоре PHP-конфигураций',
 'description' => 'Если активирована, поддомены клиентов не будут отображаться в обзоре php-конфигураций, будет показано только количество поддоменов.<br /><br />Примечание: Это видно только если включены FCGID или PHP-FPM',
 ], 'panel_phpconfigs_hidestdsubdomain' => [ 'title' => 'Скрыть стандартные поддомены в обзоре PHP-конфигураций',
 'description' => 'Если активирована, стандартные поддомены для клиентов не будут отображаться в обзоре php-конфигураций<br /><br />Примечание: Это видно только если включены FCGID или PHP-FPM',
 ], 'passwordcryptfunc' => [ 'title' => 'Выберите метод шифрования пароля',
 ], 'systemdefault' => 'Системное значение',
 'panel_allow_theme_change_admin' => 'Разрешить администраторам изменять тему',
 'panel_allow_theme_change_customer' => 'Разрешить клиентам изменять тему',
 'axfrservers' => [ 'title' => 'Серверы AXFR',
 'description' => 'Список адресов IP, разделенных запятыми, разрешенных для передачи (AXFR) доменных зон.',
 ], 'powerdns_mode' => [ 'title' => 'Режим работы PowerDNS',
 'description' => 'Выберите режим работы PoweDNS: Native для отсутствия репликации (по умолчанию) / Master, если требуется репликация DNS.',
 ], 'customerssl_directory' => [ 'title' => 'Директория сертификатов customer-ssl сервера',
 'description' => 'В какой папке будут создаваться сертификаты SSL, указанные клиентом?<br /><br /><div class="text-danger">ВНИМАНИЕ: Содержимое этой папки удаляется регулярно, поэтому избегайте вручную сохранять там данные.</div>',
 ],

'allow_error_report_admin' => [ 'title' => 'Разрешить администраторам/реселлерам отправлять отчеты об ошибках базы данных в Froxlor',
 'description' => 'Пожалуйста, обратите внимание: никогда не отправляйте нам личные (клиентские) данные!',
 ], 'allow_error_report_customer' => [ 'title' => 'Разрешить клиентам отправлять отчеты об ошибках базы данных в Froxlor',
 'description' => 'Пожалуйста, обратите внимание: никогда не отправляйте нам личные (клиентские) данные!',
 ], 'mailtraffic_enabled' => [ 'title' => 'Анализировать почтовый трафик',
 'description' => 'Включить анализирование журналов почтового сервера для подсчета трафика',
 ], 'mdaserver' => [ 'title' => 'Тип MDA-сервера',
 'description' => 'Тип почтового сервера доставки сообщений',
 ], 'mdalog' => [ 'title' => 'Лог MDA-сервера',
 'description' => 'Журнал MDA-сервера доставки сообщений',
 ], 'mtaserver' => [ 'title' => 'Тип MTA-сервера',
 'description' => 'Тип почтового сервера передачи сообщений',
 ], 'mtalog' => [ 'title' => 'Лог MTA-сервера',
 'description' => 'Журнал MTA-сервера передачи сообщений',
 ], 'system_cronconfig' => [ 'title' => 'Файл конфигурации cron',
 'description' => 'Путь к файлу конфигурации cron-сервиса. Этот файл будет регулярно и автоматически обновляться Froxlor.<br />Примечание: Пожалуйста, <b>убедитесь</b>, что вы используете то же имя файла, что и для основной cron-задачи Froxlor (по умолчанию: /etc/cron.d/froxlor)!<br><br>Если вы используете <b>FreeBSD</b>, укажите здесь <i>/etc/crontab</i>!',
 ], 'system_crondreload' => [ 'title' => 'Команда перезагрузки cron-демона',
 'description' => 'Укажите команду для перезагрузки cron-демона на вашей системе',
 ], 'system_croncmdline' => [ 'title' => 'Команда выполнения cron (бинарный файл php)',
 'description' => 'Команда для выполнения наших cron-задач. Изменяйте это только если вы знаете, что делаете (по умолчанию: "/usr/bin/nice -n 5 /usr/bin/php -q")!',
 ], 'system_cron_allowautoupdate' => [ 'title' => 'Разрешить автоматические обновления базы данных',
 'description' => '<div class="text-danger"><b>ВНИМАНИЕ:</b></div> Эта настройка позволяет обходимить проверку версии файлов и базы данных froxlor cronjob и выполнять обновления базы данных в случае несоответствия версии.<br><br><div class="text-danger">Авторучная настройка всегда устанавливает значения по умолчанию для новых настроек или изменений. Это может не всегда соответствовать вашей системе. Пожалуйста, дважды подумайте, прежде чем активировать эту опцию</div>',
 ], 'dns_createhostnameentry' => 'Создавать зону/конфигурацию для системного имени хоста',
 'panel_password_alpha_lower' => [ 'title' => 'Прописная буква',
 'description' => 'Пароль должен содержать хотя бы одну строчную букву (a-z).',
 ], 'panel_password_alpha_upper' => [ 'title' => 'Заглавная буква',
 'description' => 'Пароль должен содержать хотя бы одну заглавную букву (A-Z).',
 ], 'panel_password_numeric' => [ 'title' => 'Цифры',
 'description' => 'Пароль должен содержать хотя бы одну цифру (0-9).',
 ], 'panel_password_special_char_required' => [ 'title' => 'Специальный символ',
 'description' => 'Пароль должен содержать хотя бы один из заданных символов.',
 ], 'panel_password_special_char' => [ 'title' => 'Список специальных символов',
 'description' => 'Один из этих символов является обязательным, если установлена предыдущая опция.',
 ], 'apache_itksupport' => [ 'title' => 'Использовать модификации для Apache ITK-MPM',
 'description' => '<strong class="text-danger">ВНИМАНИЕ:</strong> используйте только в случае фактического включения apache itk-mpm<br />в противном случае ваш веб-сервер не сможет запуститься',
 ], 'letsencryptca' => [ 'title' => 'Среда ACME',
 'description' => 'Среда, которая будет использоваться для сертификатов Lets Encrypt  / ZeroSSL.',
 ], 'letsencryptchallengepath' => [ 'title' => 'Путь для вызовов Lets Encrypt ',
 'description' => 'Каталог, из которого должны предоставляться вызовы Lets Encrypt  с помощью глобального псевдонима.',
 ], 'letsencryptkeysize' => [ 'title' => 'Размер ключа для новых сертификатов Lets Encrypt ',
 'description' => 'Размер ключа в битах для новых сертификатов Lets Encrypt .',
 ], 'letsencryptreuseold' => [ 'title' => 'Повторное использование ключа Lets Encrypt ',
 'description' => 'Если активирован, один и тот же ключ будет использоваться для каждого возобновления, в противном случае каждый раз будет сгенерирован новый ключ.',
 ], 'leenabled' => [ 'title' => 'Включить Lets Encrypt ',
 'description' => 'Если активировано, клиенты смогут позволить Froxlor автоматически генерировать и обновлять сертификаты Lets Encrypt  для доменов с ssl IP/портом.<br /><br />Пожалуйста, помните, что вам нужно пройти через конфигурацию веб-сервера при включении этой функции, потому что она требует специальной настройки.',
 ],

'caa_entry' => [ 'title' => 'Генерировать записи CAA DNS',
 'description' => 'Автоматически генерирует записи CAA для доменов, включенных в использование Lets Encrypt ',
 ], 'caa_entry_custom' => [ 'title' => 'Дополнительные записи CAA DNS',
 'description' => 'DNS Certification Authority Authorization (CAA) - это механизм политики Интернет-безопасности, который позволяет держателям доменных имен указывать удостоверяющим центрам, разрешены ли они для выдачи цифровых сертификатов для конкретного доменного имени. Он делает это с помощью новой записи ресурса DNS (DNS) "CAA".<br><br>Содержимое этой поля будет включено непосредственно в зону DNS (каждая строка приводит к записи CAA).<br>Если для этого домена включен Lets Encrypt , эта запись будет автоматически добавлена и не требует ручного добавления:<br><code>0 issue "letsencrypt.org"</code> (если домен является доменом-шаблоном, вместо этого будет использовано issuewild).<br>Для активации функции предоставления отчетов об инцидентах вы можете добавить запись <code>iodef</code>. Пример для отправки такого отчета на адрес <code>me@example.com</code> будет таким:<br><code>0 iodef "mailto:me@example.com"</code><br><br><strong>Внимание:</strong> Код не будет проверен на наличие ошибок. Если он содержит ошибки, ваши записи CAA могут не работать!',
 ], 'backupenabled' => [ 'title' => 'Включить резервное копирование для клиентов',
 'description' => 'Если активировано, клиент сможет запланировать задачи резервного копирования (cron-backup), которые создадут архив в его docroot (подкаталог выбирается клиентом)',
 ], 'dnseditorenable' => [ 'title' => 'Включить редактор DNS',
 'description' => 'Позволяет администраторам и клиентам управлять записями DNS доменов',
 ], 'dns_server' => [ 'title' => 'Демон DNS-сервера',
 'description' => 'Не забудьте настроить демоны с помощью шаблонов конфигурации froxlor',
 ], 'panel_customer_hide_options' => [ 'title' => 'Скрыть пункты меню и графики трафика в панели клиента',
 'description' => 'Выберите элементы для скрытия в панели клиента. Чтобы выбрать несколько параметров, удерживайте нажатой клавишу CTRL при выборе.',
 ], 'allow_allow_customer_shell' => [ 'title' => 'Разрешить клиентам включать доступ к оболочке для ftp-пользователей',
 'description' => '<strong class="text-danger">Обратите внимание: доступ к оболочке позволяет пользователю выполнять различные бинарные файлы на вашей системе. Используйте с крайней осторожностью. Включайте только если вы ДЕЙСТВИТЕЛЬНО знаете, что делаете!!!</strong>',
 ], 'available_shells' => [ 'title' => 'Список доступных оболочек',
 'description' => 'Список оболочек, которые клиент может выбрать для своих ftp-пользователей, разделенных запятыми.<br><br>Обратите внимание, что оболочка по умолчанию <strong>/bin/false</ strong> будет всегда доступна (если включена), даже если этот параметр пуст. Он будет использоваться по умолчанию для ftp-пользователей в любом случае',
 ], 'le_froxlor_enabled' => [ 'title' => 'Включить Lets Encrypt  для vhost froxlor',
 'description' => 'Если активировано, vhost froxlor автоматически будет защищен сертификатом Lets Encrypt .',
 ], 'le_froxlor_redirect' => [ 'title' => 'Включить перенаправление SSL для vhost froxlor',
 'description' => 'Если активировано, все http-запросы к вашему froxlor будут перенаправляться на соответствующий SSL-сайт.',
 ], 'option_unavailable_websrv' => '<br><em class="text-danger">Доступно только для: %s</em>',
 'option_unavailable' => '<br><em class="text-danger">Параметр недоступен из-за других настроек.</em>',
 'letsencryptacmeconf' => [ 'title' => 'Путь до сниппета acme.conf',
 'description' => 'Имя файла сниппета конфигурации, позволяющего веб-серверу обслуживать вызовы acme challenge.',
 ], 'mail_use_smtp' => 'Установить способ отправки почты на SMTP',
 'mail_smtp_host' => 'Указать сервер SMTP',
 'mail_smtp_usetls' => 'Включить шифрование TLS',
 'mail_smtp_auth' => 'Включить аутентификацию SMTP',
 'mail_smtp_port' => 'TCP-порт для подключения',
 'mail_smtp_user' => 'Имя пользователя SMTP',
 'mail_smtp_passwd' => 'Пароль SMTP',
 'http2_support' => [ 'title' => 'Поддержка HTTP2',
 'description' => 'включить поддержку HTTP2 для SSL.<br><em class="text-danger">ВКЛЮЧАЙТЕ ТОЛЬКО ЕСЛИ ВАШ ВЕБ-СЕРВЕР ПОДДЕРЖИВАЕТ ЭТУ ФУНКЦИЮ (nginx версии 1.9.5+, apache2 версии 2.4.17+)</em>',
 ], 'nssextrausers' => [ 'title' => 'Использовать libnss-extrausers вместо libnss-mysql',
 'description' => 'Не считывать пользователей из базы данных, а из файлов. Включайте только в случае, когда вы уже прошли необходимые настройки (system -> libnss-extrausers).<br><strong class="text-danger">Только для Debian/Ubuntu (или если вы сами скомпилировали libnss-extrausers!)</strong>',
 ],

'le_domain_dnscheck' => [ 'title' => 'Проверка DNS-сервера для доменов при использовании Lets Encrypt ',
 'description' => 'Если активировано, Froxlor будет проверять, разрешается ли домен, который запрашивает сертификат Lets Encrypt , хотя бы одним из IP-адресов системы.',
 ], 'le_domain_dnscheck_resolver' => [ 'title' => 'Использовать внешний DNS-сервер для проверки DNS-сервера доменов при использовании Lets Encrypt ',
 'description' => 'Если установлено, Froxlor будет использовать этот DNS для проверки DNS-сервера доменов при использовании Lets Encrypt . Если значение пусто, будет использован DNS-сервер системы по умолчанию.',
 ], 'phpsettingsforsubdomains' => [ 'description' => 'Если установлено "да", выбранные настройки php будут обновлены для всех поддоменов',
 ], 'leapiversion' => [ 'title' => 'Выберите реализацию Lets Encrypt  ACME',
 'description' => 'В настоящее время поддерживается только реализация ACME v2 для Lets Encrypt .',
 ], 'enable_api' => [ 'title' => 'Включить внешнее использование API',
 'description' => 'Чтобы использовать API Froxlor, вам необходимо активировать эту опцию. Дополнительную информацию смотрите в <a href="https://docs.froxlor.org/latest/api-guide/" target="_new">https://docs.froxlor.org/</a>',
 ], 'api_customer_default' => 'Значение по умолчанию "Разрешить доступ к API" для новых клиентов',
 'dhparams_file' => [ 'title' => 'Файл DHParams (обмен ключами Диффи-Хеллмана)',
 'description' => 'Если здесь указан файл dhparams.pem, он будет включен в конфигурацию веб-сервера. Оставьте поле пустым, чтобы отключить.<br>Пример: /etc/ssl/webserver/dhparams.pem<br><br>Если файла нет, он будет автоматически создан следующей командой: <code>openssl dhparam -out /etc/ssl/webserver/dhparams.pem 4096</code>. Рекомендуется создать файл перед указанием его здесь, так как создание занимает довольно много времени и блокирует планировщик задач.',
 ], 'errorlog_level' => [ 'title' => 'Уровень журнала ошибок',
 'description' => 'Укажите уровень журнала ошибок. По умолчанию используется "warn" для пользователей Apache и "error" для пользователей Nginx.',
 ], 'letsencryptecc' => [ 'title' => 'Выдавать сертификат ECC / ECDSA',
 'description' => 'Если установлено соответствующее значение, выдаваемый сертификат будет использовать ECC / ECDSA',
 ], 'froxloraliases' => [ 'title' => 'Псевдонимы доменов для vHost Froxlor',
 'description' => 'Список доменов, разделенных запятыми, которые нужно добавить в качестве псевдонимов сервера для vHost Froxlor',
 ], 'default_sslvhostconf' => [ 'title' => 'Настройки SSL vHost по умолчанию',
 'description' => 'Содержимое этого поля будет включено непосредственно в контейнер этого IP/порта vHost. Вы можете использовать следующие переменные:<br/><code>{DOMAIN}</code>, <code>{DOCROOT}</code>, <code>{CUSTOMER}</code>, <code>{IP}</code>, <code>{PORT}</code>, <code>{SCHEME}</code>, <code>{FPMSOCKET}</code> (при наличии)<br/> Внимание: Код не будет проверяться на наличие ошибок. Если он содержит ошибки, веб-сервер может не запуститься снова!',
 ], 'includedefault_sslvhostconf' => 'Включить настройки SSL-vHost небезопасного vHost',
 'apply_specialsettings_default' => [ 'title' => 'Значение по умолчанию для настройки "Применить специальные настройки ко всем поддоменам (*.example.com) при редактировании домена',
 ], 'apply_phpconfigs_default' => 
 
 [ 'title' => 'Значение по умолчанию для настройки Применить настройки PHP ко всем поддоменам: при редактировании домена',
 ], 'awstats' => [ 'logformat' => [ 'title' => 'Настройка LogFormat',
 'description' => 'Если вы используете настраиваемый формат журнала для своего веб-сервера, вам необходимо изменить настройку LogFormat в awstats.<br/>По умолчанию используется 1. Дополнительную информацию смотрите в документации <a target="_blank" href="https://awstats.sourceforge.io/docs/awstats_config.html#LogFormat">здесь</a>.',
 ], ], 'hide_incompatible_settings' => 'Скрыть несовместимые настройки',
 'soaemail' => 'E-mail-адрес, используемый в записях SOA (по умолчанию — электронный адрес отправителя из настроек панели, если пусто)',
 'imprint_url' => [ 'title' => 'URL юридических примечаний / импринта',
 'description' => 'Укажите URL-адрес вашего сайта с юридическими примечаниями / импринтом. Ссылка будет видна на экране входа и внизу при входе в систему.',
 ], 'terms_url' => [ 'title' => 'URL условий использования',
 'description' => 'Укажите URL-адрес вашего сайта с условиями использования. Ссылка будет видна на экране входа и внизу при входе в систему.',
 ], 'privacy_url' => [ 'title' => 'URL политики конфиденциальности',
 'description' => 'Укажите URL-адрес вашего сайта с политикой конфиденциальности / импринтом. Ссылка будет видна на экране входа и внизу при входе в систему.',
 ], 'logo_image_header' => [ 'title' => 'Изображение логотипа (Заголовок)',
 'description' => 'Загрузите свое собственное изображение логотипа, которое будет отображаться в заголовке после входа в систему (рекомендуемая высота 30 пикселей)',
 ], 'logo_image_login' => [ 'title' => 'Изображение логотипа (Вход в систему)',
 'description' => 'Загрузите свое собственное изображение логотипа, которое будет отображаться во время входа в систему',
 ], 'logo_overridetheme' => [ 'title' => 'Перезаписать логотип, определенный в теме, значением "Изображение логотипа" (Заголовок и Вход в систему, см. ниже)',
 'description' => 'Если вы намерены использовать загруженный вами логотип, это значение должно быть установлено на "true"; в противном случае вы можете по-прежнему использовать возможность, предоставляемую темой, для загрузки логотипа "logo_custom.png" и "logo_custom_login.png".',
 ],

'logo_overridecustom' => [ 'title' => 'Перезаписать пользовательский логотип (logo_custom.png и logo_custom_login.png), определенный в теме значением "Изображение логотипа" (Заголовок и Вход в систему, см. ниже)',
 'description' => 'Установите значение "true", если вы хотите игнорировать пользовательские логотипы для заголовка и входа, определенные в теме, и использовать "Изображение логотипа"',
 ], 'createstdsubdom_default' => [ 'title' => 'Значение по умолчанию для настройки "Создание стандартного поддомена" при создании клиента',
 'description' => '',
 ], 'froxlorusergroup' => [ 'title' => 'Пользовательская системная группа для всех пользователей клиента',
 'description' => 'Для активации этой функции требуется использование libnss-extrausers (системные настройки). Если значение пусто, группа будет пропущена или удалена, если она уже существует.',
 ], 'acmeshpath' => [ 'title' => 'Путь до acme.sh',
 'description' => 'Установите здесь путь до установленного acme.sh, включая скрипт acme.sh<br>По умолчанию: <b>/root/.acme.sh/acme.sh</b>',
 ], 'update_channel' => [ 'title' => 'Канал обновлений Froxlor',
 'description' => 'Выберите канал обновления Froxlor. По умолчанию - "stable"',
 ], 'uc_stable' => 'stable',
 'uc_testing' => 'testing',
 'traffictool' => [ 'toolselect' => 'Анализатор трафика',
 'webalizer' => 'Webalizer',
 'awstats' => 'AWStats',
 'goaccess' => 'goaccess' ], 
 
 'requires_reconfiguration' => 'Изменение этих настроек может потребовать повторной настройки следующих сервисов:<br><strong>%s</strong>',
 
 'req_limit_per_interval' =>  [ 'title' => 'Количество HTTP-запросов в интервал',
 'description' => 'Ограничивает количество HTTP-запросов в интервале (см. ниже) к Froxlor, по умолчанию - "60"',
 ], 

 'req_limit_interval' => 
 	[ 'title' => 'Интервал для ограничения запросов',
 	'description' => 'Укажите время в секундах для количества HTTP-запросов, по умолчанию - 60',
	 ], 
], 

 'spf' => [ 'use_spf' => 'Активировать SPF для доменов?',
 'spf_entry' => 'SPF-запись для всех доменов',
 ], 'ssl_certificates' => [ 'certificate_for' => 'Сертификат для',
 'valid_from' => 'Действителен с',
 'valid_until' => 'Действителен до',
 'issuer' => 'Выдан',
 ], 'success' => [ 'messages_success' => 'Сообщение успешно отправлено %s получателям',
 'success' => 'Информация',
 'clickheretocontinue' => 'Нажмите здесь, чтобы продолжить',
 'settingssaved' => 'Настройки успешно сохранены.',
 'rebuildingconfigs' => 'Задачи для пересборки конфигурационных файлов успешно добавлены',
 'domain_import_successfully' => 'Успешно импортировано %s доменов.',
 'backupscheduled' => 'Резервная копия была запланирована. Пожалуйста, подождите ее обработки.',
 'backupaborted' => 'Ваша запланированная резервная копия была отменена.',
 'dns_record_added' => 'Запись успешно добавлена',
 'dns_record_deleted' => 'Запись успешно удалена',
 'testmailsent' => 'Тестовое письмо успешно отправлено',
 'settingsimported' => 'Настройки успешно импортированы',
 'sent_error_report' => 'Ошибка успешно отправлена. Спасибо за ваш вклад.',
 ], 'tasks' => [ 'outstanding_tasks' => 'Действия cron-планировщика',
 'REBUILD_VHOST' => 'Перестроение конфигурации веб-сервера',
 'CREATE_HOME' => 'Добавление нового клиента %s',
 'REBUILD_DNS' => 'Перестроение конфигурации bind',
 'CREATE_FTP' => 'Создание каталога для нового ftp-пользователя',
 'DELETE_CUSTOMER_FILES' => 'Удаление файлов клиента %s',
 'noneoutstanding' => 'На данный момент у Froxlor нет непримененных задач',
 'CREATE_QUOTA' => 'Установка квоты на файловой системе',
 'DELETE_EMAIL_DATA' => 'Удаление данных электронной почты клиента',
 'DELETE_FTP_DATA' => 'Удаление данных учетной записи FTP-клиента',
 'REBUILD_CRON' => 'Перестроение файла cron.d',
 'CREATE_CUSTOMER_BACKUP' => 'Резервное копирование данных клиента %s',
 'DELETE_DOMAIN_PDNS' => 'Удаление домена %s из базы данных PowerDNS',
 'DELETE_DOMAIN_SSL' => 'Удаление SSL-файлов домена %s',
 ],

'terms' => 'Правила использования',
 'traffic' => [ 'month' => 'Месяц',
 'day' => 'День',
 'months' => [ 1 => 'Январь',
 2 => 'Февраль',
 3 => 'Март',
 4 => 'Апрель',
 5 => 'Май',
 6 => 'Июнь',
 7 => 'Июль',
 8 => 'Август',
 9 => 'Сентябрь',
 10 => 'Октябрь',
 11 => 'Ноябрь',
 12 => 'Декабрь',
 'jan' => 'Янв',
 'feb' => 'Фев',
 'mar' => 'Мар',
 'apr' => 'Апр',
 'may' => 'Май',
 'jun' => 'Июн',
 'jul' => 'Июл',
 'aug' => 'Авг',
 'sep' => 'Сен',
 'oct' => 'Окт',
 'nov' => 'Ноя',
 'dec' => 'Дек',
 'total' => 'Всего',
 ], 'mb' => 'Трафик',
 'sumtotal' => 'Общий трафик',
 'sumhttp' => 'HTTP трафик',
 'sumftp' => 'FTP трафик',
 'summail' => 'Почтовый трафик',
 'customer' => 'Клиент',
 'domain' => 'Домен',
 'trafficoverview' => 'Обзор трафика',
 'bycustomers' => 'Трафик по клиентам',
 'details' => 'Детали',
 'http' => 'HTTP',
 'ftp' => 'FTP',
 'mail' => 'Почта',
 'nocustomers' => 'Для просмотра отчетов о трафике вам необходимо добавить хотя бы одного клиента.',
 'top5customers' => 'Топ 5 клиентов',
 'nodata' => 'Данные за указанный период не найдены.',
 'ranges' => [ 'last24h' => 'последние 24 часа',
 'last7d' => 'последние 7 дней',
 'last30d' => 'последние 30 дней',
 'cm' => 'Текущий месяц',
 'last3m' => 'последние 3 месяца',
 'last6m' => 'последние 6 месяцев',
 'last12m' => 'последние 12 месяцев',
 'cy' => 'Текущий год',
 ], 'byrange' => 'Указанный период',
 ], 'translator' => '',
 'update' => [ 'updateinprogress_onlyadmincanlogin' => 'Установлена более новая версия Froxlor, но еще не завершена настройка.<br />Войти могут только администраторы для завершения обновления.',
 'update' => 'Обновление Froxlor',
 'proceed' => 'Продолжить',
 'update_information' => [ 'part_a' => 'Файлы Froxlor были обновлены до версии <strong>%s</strong>. Установленная версия: <strong>%s</strong>.',
 'part_b' => '<br /><br />Клиенты не смогут войти в систему, пока обновление не будет завершено.<br /><strong>Продолжить?</strong>',
 ], 'noupdatesavail' => 'У вас уже установлена последняя версия Froxlor %s.',
 'description' => 'Выполняются обновления вашей установки Froxlor',
 'uc_newinfo' => 'Доступна новая версия %s: "%s" (Ваша текущая версия: %s)',
 'notify_subject' => 'Доступно новое обновление',
 'dbupdate_required' => 'Файлы Froxlor были обновлены, требуется обновление базы данных',
 ],

'usersettings' => [ 'custom_notes' => [ 'title' => 'Пользовательские заметки',
 'description' => 'Вы можете вносить любые заметки, которые вам нужны/необходимы. Они будут отображаться в обзоре администратора/клиента для соответствующего пользователя.',
 'show' => 'Показывать ваши заметки на рабочем столе пользователя',
 ], 'api_allowed' => [ 'title' => 'Разрешить доступ к API',
 'description' => 'При включении в настройках этот пользователь может создавать ключи API и получать доступ к API Froxlor',
 'notice' => 'Доступ к API не разрешен для вашей учетной записи.',
 ], ], 'install' => [ 'slogal' => 'froxlor - панель управления сервером',
 'preflight' => 'Проверка системы',
 'critical_error' => 'Критическая ошибка',
 'suggestions' => 'Не обязательно, но рекомендуется',
 'phpinfosuccess' => 'Ваша система работает на PHP версии %s',
 'phpinfowarn' => 'Ваша система работает на более низкой версии PHP, чем %s',
 'phpinfoupdate' => 'Обновите текущую версию PHP с %s до %s или выше',
 'start_installation' => 'Начать установку',
 'check_again' => 'Перезагрузите страницу для повторной проверки',
 'switchmode_advanced' => 'Показать дополнительные параметры',
 'switchmode_basic' => 'Скрыть дополнительные параметры',
 'dependency_check' => [ 'title' => 'Добро пожаловать в Froxlor',
 'description' => 'Мы проверяем систему на наличие зависимостей, чтобы убедиться, что все необходимые расширения и модули PHP включены и Froxlor работает должным образом.',
 ], 'database' => [ 'top' => 'База данных',
 'title' => 'Создание базы данных и пользователя',
 'description' => 'Для работы Froxlor требуется база данных и, дополнительно, привилегированный пользователь, чтобы иметь возможность создавать пользователей и базы данных (опция GRANT). В процессе будет создан указанный база данных и привилегированный пользователь базы данных. Привилегированный пользователь должен уже существовать.',
 'user' => 'Пользователь базы данных без прав',
 'dbname' => 'Имя базы данных',
 'force_create' => 'Создать резервную копию и перезаписать базу данных, если существует?',
 ], 'admin' => [ 'top' => 'Администратор',
 'title' => 'Создание главного администратора',
 'description' => 'Этому пользователю будет предоставлены все привилегии для настройки системы и добавления/обновления/удаления ресурсов, таких как клиенты, домены и т.д.',
 ], 'system' => [ 'top' => 'Настройка системы',
 'title' => 'Информация о вашем сервере',
 'description' => 'Установите здесь вашу среду и серверные данные и параметры, чтобы Froxlor знал о вашей системе. Эти значения являются ключевыми для конфигурации и работы системы.',
 'ipv4' => 'Основной IPv4-адрес (при применимости)',
 'ipv6' => 'Основной IPv6-адрес (при применимости)',
 'servername' => 'Имя сервера (FQDN, без IP-адреса)',
 'phpbackend' => 'Фоновый процесс PHP',
 'activate_newsfeed' => 'Включить официальную ленту новостей<br><small>(внешний источник: https://inside.froxlor.org/news/)</small>',
 ], 'install' => [ 'top' => 'Завершение установки',
 'title' => 'Последний шаг...',
 'description' => 'Ниже приведена команда, которая загрузит, установит и настроит необходимые службы на вашей системе в соответствии с данными, указанными в процессе установки.<br><br><span class="text-danger">Обязательно запустите следующую команду как <b>root</b> на консоли/терминале сервера.</span>',
 'runcmd' => 'Выполните следующую команду, чтобы завершить установку:',
 'manual_config' => 'Я самостоятельно настрою службы, перейдите к входу в систему',
 'waitforconfig' => 'Ожидание настройки служб...',
 ],

'errors' => [ 'wrong_ownership' => 'Убедитесь, что файлы Froxlor принадлежат пользователю %s:%s',
 'missing_extensions' => 'Следующие расширения PHP требуются, но не установлены',
 'suggestedextensions' => 'Следующие расширения PHP не найдены, но рекомендуются',
 'databaseexists' => 'База данных уже существует, пожалуйста, установите опцию перезаписи для создания заново или выберите другое имя',
 'unabletocreatedb' => 'Тестовая база данных не может быть создана',
 'unabletodropdb' => 'Тестовая база данных не может быть удалена',
 'mysqlusernameexists' => 'Указанный привилегированный пользователь уже существует. Пожалуйста, используйте другое имя пользователя или удалите его сначала.',
 'unabletocreateuser' => 'Тестовый пользователь не может быть создан',
 'unabletodropuser' => 'Тестовый пользователь не может быть удален',
 'unabletoflushprivs' => 'Указанному привилегированному пользователю не удалось сбросить привилегии',
 'nov4andnov6ip' => 'Необходимо указать либо IPv4-адрес, либо IPv6-адрес',
 'servernameneedstobevalid' => 'Указанный серверное имя не является полным доменным именем (FQDN) или именем хоста',
 'websrvuserdoesnotexist' => 'Указанный пользователь веб-сервера не существует в системе',
 'websrvgrpdoesnotexist' => 'Указанная группа веб-сервера не существует в системе',
 'notyetconfigured' => 'Похоже, что службы еще не были настроены (успешно). Пожалуйста, либо выполните команду, указанную ниже, либо отметьте флажок, чтобы сделать это позже.',
 'mandatory_field_not_set' => 'Обязательное поле "%s" не заполнено!',
 'unexpected_database_error' => 'Возникло неожиданное исключение базы данных. %s',
 'sql_import_failed' => 'Не удалось импортировать SQL-данные!',
 'unprivileged_sql_connection_failed' => 'Не удалось инициализировать непривилегированное SQL-соединение!',
 'privileged_sql_connection_failed' => 'Не удалось инициализировать привилегированное SQL-соединение!',
 'mysqldump_backup_failed' => 'Не удалось создать резервную копию базы данных, получили ошибку от mysqldump.',
 'sql_backup_file_missing' => 'Не удалось создать резервную копию базы данных, файл резервной копии не существует.',
 'backup_binary_missing' => 'Не удалось создать резервную копию базы данных, убедитесь, что установлен mysqldump.',
 'creating_configfile_failed' => 'Не удалось создать файлы конфигурации, невозможно записать файл.',
 'database_already_exiting' => 'Мы обнаружили базу данных и не можем ее заменить!' ], 'welcome' => [ 'title' => 'Добро пожаловать в Froxlor!',
 'config_note' => 'Для того, чтобы Froxlor мог правильно взаимодействовать с бэкэндом, вам необходимо его настроить.',
 'config_now' => 'Настроить сейчас' ],
