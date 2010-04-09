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
 * @author     Nickola Kolev <nikky@minus273.org>
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Language
 * @version    $Id$
 */

/**
 * Global
 */

$lng['translator'] = 'Никола Колев';
$lng['panel']['edit'] = 'редакция';
$lng['panel']['delete'] = 'изтриване';
$lng['panel']['create'] = 'създаване';
$lng['panel']['save'] = 'запазване';
$lng['panel']['yes'] = 'да';
$lng['panel']['no'] = 'не';
$lng['panel']['emptyfornochanges'] = 'оставете празно, ако няма промени';
$lng['panel']['emptyfordefault'] = 'оставете празно за стойности по подразбиране';
$lng['panel']['path'] = 'Път';
$lng['panel']['toggle'] = 'Изберете';
$lng['panel']['next'] = 'следващ';
$lng['panel']['dirsmissing'] = 'Не мога да намеря или да прочета директорията!';
$lng['panel']['urloverridespath'] = 'URL (отменя пътя)';
$lng['panel']['pathorurl'] = 'Път или URL';
$lng['panel']['ascending'] = 'възходящ';
$lng['panel']['decending'] = 'низходящ';
$lng['panel']['search'] = 'Търсете';
$lng['panel']['used'] = 'използвани';
$lng['panel']['translator'] = 'Преводач';

/**
 * Login
 */

$lng['login']['username'] = 'Потребителско име';
$lng['login']['password'] = 'Парола';
$lng['login']['language'] = 'Език';
$lng['login']['login'] = 'Вход';
$lng['login']['logout'] = 'Изход';
$lng['login']['profile_lng'] = 'Език от профила';

/**
 * Customer
 */

$lng['customer']['documentroot'] = 'Домашна директория';
$lng['customer']['name'] = 'Фамилия';
$lng['customer']['firstname'] = 'Име';
$lng['customer']['company'] = 'Фирма';
$lng['customer']['street'] = 'Улица';
$lng['customer']['zipcode'] = 'Пощенски код';
$lng['customer']['city'] = 'Град';
$lng['customer']['phone'] = 'Телефон';
$lng['customer']['fax'] = 'Факс';
$lng['customer']['email'] = 'E-поща';
$lng['customer']['customernumber'] = 'Клиентски номер';
$lng['customer']['diskspace'] = 'Уеб пространство (МБ)';
$lng['customer']['traffic'] = 'Трафик (ГБ)';
$lng['customer']['mysqls'] = 'MySQL бази данни';
$lng['customer']['emails'] = 'Адреси за е-поща';
$lng['customer']['accounts'] = 'Акаунти за е-поща';
$lng['customer']['forwarders'] = 'Препращане на е-поща';
$lng['customer']['ftps'] = 'FTP акаунти';
$lng['customer']['subdomains'] = 'Поддомейн(и)';
$lng['customer']['domains'] = 'Домейн(и)';
$lng['customer']['unlimited'] = 'неограничен';

/**
 * Customermenue
 */

$lng['menue']['main']['main'] = 'Начало';
$lng['menue']['main']['changepassword'] = 'Смяна на паролата';
$lng['menue']['main']['changelanguage'] = 'Смяна на езика';
$lng['menue']['email']['email'] = 'Е-поща';
$lng['menue']['email']['emails'] = 'Адреси';
$lng['menue']['email']['webmail'] = 'УебПоща';
$lng['menue']['mysql']['mysql'] = 'MySQL';
$lng['menue']['mysql']['databases'] = 'Бази данни';
$lng['menue']['mysql']['phpmyadmin'] = 'phpMyAdmin';
$lng['menue']['domains']['domains'] = 'Домейни';
$lng['menue']['domains']['settings'] = 'Настройки';
$lng['menue']['ftp']['ftp'] = 'FTP';
$lng['menue']['ftp']['accounts'] = 'Акаунти';
$lng['menue']['ftp']['webftp'] = 'WebFTP';
$lng['menue']['extras']['extras'] = 'Допълнителни';
$lng['menue']['extras']['directoryprotection'] = 'Защита на директории';
$lng['menue']['extras']['pathoptions'] = 'Опции за директории';
$lng['menue']['main']['username'] = 'Потребителско име: ';

/**
 * Index
 */

$lng['index']['customerdetails'] = 'Подробности за клиента';
$lng['index']['accountdetails'] = 'Подробности за акаунта';

/**
 * Change Password
 */

$lng['changepassword']['old_password'] = 'Стара парола';
$lng['changepassword']['new_password'] = 'Нова парола';
$lng['changepassword']['new_password_confirm'] = 'Нова парола (още веднъж)';
$lng['changepassword']['new_password_ifnotempty'] = 'Нова парола (ако оставите празно, няма да се промени)';
$lng['changepassword']['also_change_ftp'] = ' сменя също и паролата на главния FTP акаунт';

/**
 * Domains
 */

$lng['domains']['description'] = 'Тук можете да създавате (под)домейни и да променяте техните директории.<br />.Системата ще има нужда от известно време, за да влезе в сила всяка промяна.';
$lng['domains']['domainsettings'] = 'Настройки на домейна';
$lng['domains']['domainname'] = 'Име на домейна';
$lng['domains']['subdomain_add'] = 'Създаване на поддомейн';
$lng['domains']['subdomain_edit'] = 'Редакция на (под)домейн';
$lng['domains']['wildcarddomain'] = 'Създаване като домейн, който прихваща всички заявки?';
$lng['domains']['aliasdomain'] = 'Псевдоним за домейн';
$lng['domains']['noaliasdomain'] = 'Без псевдоним за домейн';
$lng['domain']['openbasedirpath'] = 'OpenBasedir-път';
$lng['domain']['docroot'] = 'Път за полето по-горе';
$lng['domain']['homedir'] = 'Домашна директория';
$lng['domains']['hasaliasdomains'] = 'Дали да има псевдоними на домейни';
$lng['domains']['statstics'] = 'Статистики на потреблението';

/**
 * eMails
 */

$lng['emails']['description'] = 'Тук можете да създавате и да променяте своите
адреси за електронна поща.<br />Акаунтът представлява нещо като пощенска кутия
пред дома ви. Ако някой иска да ви изпрати електронна поща, тя ще бъде доставена
във вашия акаунт.<br /><br />За да свалите своята електронна поща, използвайте
следните настройки за пощенската програма: (Данните в <i>курсив</i> трябва да
бъдат променени по съответния начин!)<br />Име на хост: <b><i>Име на
домейн</i></b><br />Потребителско име: <b><i>Име на акаунта/адрес за електронна
поща</i></b><br />Парола: <b><i>паролата, която сте си избрали</i><b>';
$lng['emails']['emailaddress'] = 'Email адрес';
$lng['emails']['emails_add'] = 'Създаване на email адрес';
$lng['emails']['emails_edit'] = 'Редакция на email адрес';
$lng['emails']['catchall'] = 'Catchall';
$lng['emails']['iscatchall'] = 'Да дефинирам ли като catchall адрес?';
$lng['emails']['account'] = 'Акаунт';
$lng['emails']['account_add'] = 'Създаване на акаунт';
$lng['emails']['account_delete'] = 'Изтриване на акаунт';
$lng['emails']['from'] = 'Източник';
$lng['emails']['to'] = 'Назначение';
$lng['emails']['forwarders'] = 'Пренасочване към';
$lng['emails']['forwarder_add'] = 'Създаване на пренасочване';

/**
 * FTP
 */

$lng['ftp']['description'] = 'Тук можете да създадете и да промените своите
сметки за достъп до FTP.<br />Промените се прилагат незабавно и акаунтите могат
да бъдат използвани веднага';
$lng['ftp']['account_add'] = 'Създаване на акаунт';

/**
 * MySQL
 */

$lng['mysql']['description'] = 'Тук можете да създавате и редактирате MySQL бази от данни.<br />Промените влизат в сила незабавно, а базите могат да бъдат използвани веднага.<br />В менюто отляво ще намерите инструмента phpMyAdmin, с който лесно можете да администрирате своите бази от данни.<br /><br />За да ги използвате в php скриптове, ви трябват следните стойности: (Данните в <i>курсив</i> трябва да бъдат заменени със съответните стойности, които сте записали!)<br />Име на хост: <b>localhost</b><br />Потребителско име: <b><i>Име на база</i></b><br />Парола: <b><i>паролата, която сте избрали</i></b><br />База данни: <b><i>Име на базата';
$lng['mysql']['databasename'] = 'Име на базата или на потребителя';
$lng['mysql']['databasedescription'] = 'Описание на базата';
$lng['mysql']['database_create'] = 'Създаване на база';

/**
 * Extras
 */

$lng['extras']['description'] = 'Тук можете да добавите някои екстри, например защита на директориите. <br /> Системата ще има нужда от време, за да приложи новите настройки след всяка промяна.';
$lng['extras']['directoryprotection_add'] = 'Добавяне защита на директории';
$lng['extras']['view_directory'] = 'показване съдържанието на директорията';
$lng['extras']['pathoptions_add'] = 'добавяне опции на пътя';
$lng['extras']['directory_browsing'] = 'разглеждане съдържанието на директорията';
$lng['extras']['pathoptions_edit'] = 'редактиране опции на пътя';
$lng['extras']['error404path'] = '404';
$lng['extras']['error403path'] = '403';
$lng['extras']['error500path'] = '500';
$lng['extras']['error401path'] = '401';
$lng['extras']['errordocument404path'] = 'URL към ErrorDocument 404';
$lng['extras']['errordocument403path'] = 'URL към ErrorDocument 403';
$lng['extras']['errordocument500path'] = 'URL към ErrorDocument 500';
$lng['extras']['errordocument401path'] = 'URL към ErrorDocument 401';

/**
 * Errors
 */

$lng['error']['error'] = 'Грешка';
$lng['error']['directorymustexist'] = 'Директорията %s трябва да съществува. Моля, създайте я със своя FTP клиент.';
$lng['error']['filemustexist'] = 'Файлът %s трябва да съществува.';
$lng['error']['allresourcesused'] = 'Вече сте изразходвали всичките си ресурси.';
$lng['error']['domains_cantdeletemaindomain'] = 'Не можете да изтриете домейн, който се използва като email домейн.';
$lng['error']['domains_canteditdomain'] = 'Не можете да редактиране този домейн. Това е забранено от администратора.';
$lng['error']['domains_cantdeletedomainwithemail'] = 'Не можете да изтриете домейн, който се използва като email домейн. Първо изтрийте всички email адреси.';
$lng['error']['firstdeleteallsubdomains'] = 'Първо трябва да изтриете всички поддомейни, за да можете да създадете общ домейн за пренасочване.';
$lng['error']['youhavealreadyacatchallforthisdomain'] = 'Вече сте дефинирали catchall адрес за този домейн.';
$lng['error']['ftp_cantdeletemainaccount'] = 'Не можете да изтриете главния си FTP акаунт';
$lng['error']['login'] = 'Потребителското име или паролата са грешни. Моля, опитайте отново!';
$lng['error']['login_blocked'] = 'Акаунтът е замразен поради твърде много грешни опити за влизане. <br />Моля, опитайте отново след ' . $settings['login']['deactivatetime'] . ' секунди.';
$lng['error']['notallreqfieldsorerrors'] = 'Не сте попълнили всичко, или някои от полетата са попълнени неправилно.';
$lng['error']['oldpasswordnotcorrect'] = 'Старата ви парола е неправилна.';
$lng['error']['youcantallocatemorethanyouhave'] = 'Не можете да раздадете повече ресурси, отколкото има отделени за самите вас.';
$lng['error']['mustbeurl'] = 'Не сте въвели правилно или пълно url (напр. http://somedomain.com/error404.htm)';
$lng['error']['stringisempty'] = 'Липсват въведени данни в поле';
$lng['error']['stringiswrong'] = 'Грешни въведени данни в поле';
$lng['error']['myloginname'] = '\'Потребителско име\'';
$lng['error']['mypassword'] = '\'Парола\'';
$lng['error']['oldpassword'] = '\'Стара парола\'';
$lng['error']['newpassword'] = '\'Нова парола\'';
$lng['error']['newpasswordconfirm'] = '\'Нова парола (отново)\'';
$lng['error']['newpasswordconfirmerror'] = 'Новата парола и потвърждението не съвпадат';
$lng['error']['myname'] = '\'Фамилия\'';
$lng['error']['myfirstname'] = '\'Име\'';
$lng['error']['emailadd'] = '\'Ел. поща\'';
$lng['error']['mydomain'] = '\'Домейн\'';
$lng['error']['mydocumentroot'] = '\'Основен път\'';
$lng['error']['loginnameexists'] = 'Потребителското име %s вече съществува';
$lng['error']['emailiswrong'] = 'Електронният адрес %s съдържа невалидни знаци или е непълен';
$lng['error']['loginnameiswrong'] = 'Потребителското име %s съдържа невалидни знаци';
$lng['error']['userpathcombinationdupe'] = 'Комбинацията от потребителско име и път вече съществува';
$lng['error']['patherror'] = 'Генерална грешка! Пътят не може да бъде празен!';
$lng['error']['errordocpathdupe'] = 'Опцията за път %s вече съществува';
$lng['error']['adduserfirst'] = 'Моля, първо създайте клиент';
$lng['error']['domainalreadyexists'] = 'Домейнът %s вече е даден на клиент';
$lng['error']['nolanguageselect'] = 'Не е избран език.';
$lng['error']['nosubjectcreate'] = 'Трябва да изберете тема за този шаблон за електронна поща.';
$lng['error']['nomailbodycreate'] = 'Трябва да изберете съдържание за този шаблон за електронна поща.';
$lng['error']['templatenotfound'] = 'Шаблонът не е открит.';
$lng['error']['alltemplatesdefined'] = 'Не можете да дефинирате повече шаблони. Вече се поддържат всички езици.';
$lng['error']['wwwnotallowed'] = 'www не е позволено като име на поддомейн.';
$lng['error']['subdomainiswrong'] = 'Поддомейнът %s съдържа невалидни знаци.';
$lng['error']['domaincantbeempty'] = 'Името на домейн не може да бъде празно.';
$lng['error']['domainexistalready'] = 'Домейнът %s вече съществува.';
$lng['error']['emailexistalready'] = 'Адресът за електронна поща %s вече съществува.';
$lng['error']['maindomainnonexist'] = 'Главният домейн %s не съществува.';
$lng['error']['destinationnonexist'] = 'Моля, създайте своeто препращане в полето \'Дестинация\'.';
$lng['error']['destinationalreadyexistasmail'] = 'Препращането към %s вече съществува като активен ел. адрес.';
$lng['error']['destinationalreadyexist'] = 'Вече сте дефинирали препращач %s .';
$lng['error']['destinationiswrong'] = 'Препращачът %s съдържа невалидни знаци или е непълен.';
$lng['error']['domainname'] = $lng['domains']['domainname'];
$lng['error']['invalidpath'] = 'Не сте избрали валиден URL (или може би проблем с показването съдържание на директория?)';
$lng['error']['domainisaliasorothercustomer'] = 'Избраният псевдоним на домейн е или псевдоним сам по себе си, или принадлежи на друг клиент.';
$lng['error']['ipstillhasdomains'] = 'Комбинацията от IP и порт все още има домейни, свързани с нея. Моля, прехвърлете ги към друга IP/порт комбинация, преди да изтриете тази.';
$lng['error']['cantdeletedefaultip'] = 'Не можете да изтриете комбинацията по подразбиране от IP и порт за риселъри. Моля, направете друга комбинация по подразбиране за риселъри, преди да изтриете тази.';
$lng['error']['cantdeletesystemip'] = 'Не можете да изтриете последното системно IP. Можете или да създадете нова IP/порт комбинация за системното IP или да зададете ново системно IP.';
$lng['error']['myipaddress'] = '\'IP\'';
$lng['error']['myport'] = '\'Порт\'';
$lng['error']['myipdefault'] = 'Трябва да изберете комбинация от IP и порт по подразбиране.';
$lng['error']['myipnotdouble'] = 'Тази комбинация IP/порт вече съществува.';
$lng['error']['cantchangesystemip'] = 'Не можете да промените последното системно IP. Можете или да създадете нова IP/порт комбинация за системното IP или да зададете ново системно IP..';
$lng['error']['loginnameissystemaccount'] = 'Не можете да създавате сметки, които са подобни на системните. Моля, въведете друго име на сметка.';
$lng['error']['sessiontimeoutiswrong'] = 'За &quot;Изтичане на сесия&quot; е позволена само числова стойност.';
$lng['error']['maxloginattemptsiswrong'] = 'За &quot;Максимален брой опити за влизане&quot; е позволена само числова стойност.';
$lng['error']['deactivatetimiswrong'] = 'За &quot;Време за деактивация&quot; е позволена само числова стойност.';
$lng['error']['accountprefixiswrong'] = '&quot;Клиентски префикс&quot; е грешен.';
$lng['error']['mysqlprefixiswrong'] = '&quot;SQL префикс&quot; е грешен.';
$lng['error']['ftpprefixiswrong'] = '&quot;FTP префикс&quot; е грешен.';
$lng['error']['ipiswrong'] = '&quot;IP адрес&quot; е грешен. Позволени са само валидни IP адреси.';
$lng['error']['vmailuidiswrong'] = '&quot;UID на поща&quot; е грешен. Позволени са само числови стойности на UID.';
$lng['error']['vmailgidiswrong'] = '&quot;GID на поща&quot; е грешен. Позволени са само числови стойности на GID.';
$lng['error']['adminmailiswrong'] = '&quot;Адрес на изпращач&quot; е грешен. Позволени са само валидни адреси за e-поща.';
$lng['error']['pagingiswrong'] = 'Стойността на &quot;Записи на страница&quot; е грешен. Позволени са само цифрови стойности.';
$lng['error']['phpmyadminiswrong'] = 'Връзката съм phpMyAdmin е невалидна.';
$lng['error']['webmailiswrong'] = 'Връзката към уеб поща е невалидна.';
$lng['error']['webftpiswrong'] = 'Връзката към WebFTP е невалидна.';
$lng['error']['stringformaterror'] = 'Стойността в полето &quot;%s&quot; не е в очаквания формат.';

/**
 * Questions
 */

$lng['question']['question'] = 'Таен въпрос';
$lng['question']['admin_customer_reallydelete'] = 'Наистина ли искате да изтриете клиент %s? Това е необратимо!';
$lng['question']['admin_domain_reallydelete'] = 'Наистина ли искате да изтриете домейн %s?';
$lng['question']['admin_domain_reallydisablesecuritysetting'] = 'Наистина ли искате да деактивирате тези настройки на сигурността (OpenBasedir и/или SafeMode)?';
$lng['question']['admin_admin_reallydelete'] = 'Наистина ли искате да изтриете администраторът %s? Всеки негов клиент и домейн ще бъдат прикрепени към главния администратор.';
$lng['question']['admin_template_reallydelete'] = 'Наистина ли искате да изтриете шаблона \'%s\'?';
$lng['question']['domains_reallydelete'] = 'Наистина ли искате да изтриете домейна %s?';
$lng['question']['email_reallydelete'] = 'Наистина ли искате да изтриете адреса за електронна поща %s?';
$lng['question']['email_reallydelete_account'] = 'Наистина ли искате да изтриете сметката за електронна поща на %s?';
$lng['question']['email_reallydelete_forwarder'] = 'Наистина ли искате да изтриете препращането за %s?';
$lng['question']['extras_reallydelete'] = 'Наистина ли искате да изтриете защитата на директория %s?';
$lng['question']['extras_reallydelete_pathoptions'] = 'Наистина ли искате да изтриете опциите на пътя %s?';
$lng['question']['ftp_reallydelete'] = 'Наистина ли искате да изтриете FTP сметката %s?';
$lng['question']['mysql_reallydelete'] = 'Наистина ли искате да изтриете базата данни %s? Това е необратимо!';
$lng['question']['admin_configs_reallyrebuild'] = 'Наистина ли искате да изградите отново конфигурационните файлове на bind и apache?';
$lng['question']['admin_ip_reallydelete'] = 'Наистина ли искате да изтриете IP адресът %s?';
$lng['question']['admin_domain_reallydocrootoutofcustomerroot'] = 'Сигурни ли сте, че искате главната директория на този домейн да не попада в главната директория на клиента?';

/**
 * Mails
 */

$lng['mails']['pop_success']['mailbody'] = 'Здравейте,\n\nвашият пощенски акаунт {EMAIL}\nе създаден успешно.\n\nТова съобщение е генерирано автоматично, затова\nмоля, не отговаряйте!\n\nПоздрави, екипът на МНЕТ';
$lng['mails']['pop_success']['subject'] = 'Пощенският акаунт е създаден успешно';
$lng['mails']['createcustomer']['mailbody'] = 'Здравейте {FIRSTNAME} {NAME},\n\nето информация за вашия акаунт:\n\nПотребителско име: {USERNAME}\nПарола: {PASSWORD}\n\nПоздрави,\nекипът на МНЕТ';
$lng['mails']['createcustomer']['subject'] = 'Информация за сметката';

/**
 * Admin
 */

$lng['admin']['overview'] = 'Преглед';
$lng['admin']['ressourcedetails'] = 'Използвани ресурси';
$lng['admin']['systemdetails'] = 'Системни детайли';
$lng['admin']['froxlordetails'] = 'Froxlor детайли';
$lng['admin']['installedversion'] = 'Инсталирана версия';
$lng['admin']['latestversion'] = 'Последна версия';
$lng['admin']['lookfornewversion']['clickhere'] = 'Потърсете чрез уеб услуга';
$lng['admin']['lookfornewversion']['error'] = 'Грешка при четене';
$lng['admin']['resources'] = 'Ресурси';
$lng['admin']['customer'] = 'Клиент';
$lng['admin']['customers'] = 'Клиенти';
$lng['admin']['customer_add'] = 'Добавяне на клиент';
$lng['admin']['customer_edit'] = 'Редакция на клиент';
$lng['admin']['domains'] = 'Домейни';
$lng['admin']['domain_add'] = 'Добавяне на домейн';
$lng['admin']['domain_edit'] = 'Редакция на домейн';
$lng['admin']['subdomainforemail'] = 'Поддомейни като емайл домейни';
$lng['admin']['admin'] = 'Администратор';
$lng['admin']['admins'] = 'Администратори';
$lng['admin']['admin_add'] = 'Добавяне на администратор';
$lng['admin']['admin_edit'] = 'Редакция на администратор';
$lng['admin']['customers_see_all'] = 'Може ли да вижда всички клиенти?';
$lng['admin']['domains_see_all'] = 'Може ли да вижда всички домейни?';
$lng['admin']['change_serversettings'] = 'Може ли да променя настройките на сървъра?';
$lng['admin']['server'] = 'Сървър';
$lng['admin']['serversettings'] = 'Настройки';
$lng['admin']['stdsubdomain'] = 'Стандартен поддомейн';
$lng['admin']['stdsubdomain_add'] = 'Създаване на стандартен поддомейн';
$lng['admin']['deactivated'] = 'Деактивиран';
$lng['admin']['deactivated_user'] = 'Деактивирай потребител';
$lng['admin']['sendpassword'] = 'Изпрати парола';
$lng['admin']['ownvhostsettings'] = 'Собствени настройки на виртуален хост';
$lng['admin']['configfiles']['serverconfiguration'] = 'Конфигурация';
$lng['admin']['configfiles']['files'] = '<b>Конфигурационни файлове:</b> Моля, променете следните файлове или ги създайте със<br />следното съдържание, ако не съществуват.<br /> <b>Внимание:</b> Паролата за MySQL не е сменена поради съображения за сигурност.<br />Моля, сменете &quot;MYSQL_PASSWORD&quot; сами. Ако забравите своята MySQL md,f.d<br />можете да я намерите в &quot;lib/userdata.inc.php&quot;.';
$lng['admin']['configfiles']['commands'] = '<b>Команди:</b> Моля, изпълнете следните команди в командния ред на обвивката.';
$lng['admin']['configfiles']['restart'] = '<b>Restart:</b> Моля, изпълнете следните команди в командния ред на обвивката, за да се презареди новата конфигурация.';
$lng['admin']['templates']['templates'] = 'Шаблони';
$lng['admin']['templates']['template_add'] = 'Добавяне на шаблон';
$lng['admin']['templates']['template_edit'] = 'Редакция на шаблон';
$lng['admin']['templates']['action'] = 'Действие';
$lng['admin']['templates']['email'] = 'Ел. поща';
$lng['admin']['templates']['subject'] = 'Тема';
$lng['admin']['templates']['mailbody'] = 'Съдържание';
$lng['admin']['templates']['createcustomer'] = 'Поздравителна поща за всички клиенти';
$lng['admin']['templates']['pop_success'] = 'Поздравителна поща за нови сметки за ел. поща';
$lng['admin']['templates']['template_replace_vars'] = 'Променлива, която да бъде заменена в шаблона:';
$lng['admin']['templates']['FIRSTNAME'] = 'Ще бъде заменено с първото име на клиента.';
$lng['admin']['templates']['NAME'] = 'Ще бъде заменено с името на клиента.';
$lng['admin']['templates']['USERNAME'] = 'Ще бъде заменено с потребителското име на клиента.';
$lng['admin']['templates']['PASSWORD'] = 'Ще бъде заменено с паролата за сметката на клиента.';
$lng['admin']['templates']['EMAIL'] = 'Ще бъде заменено със сметка за POP3/IMAP.';
$lng['admin']['rebuildconf'] = 'Възстановяване на конфигурационни файлове';
$lng['admin']['ipsandports']['ipsandports'] = 'IP адреси и портове';
$lng['admin']['ipsandports']['add'] = 'Добавяне на IP/порт';
$lng['admin']['ipsandports']['edit'] = 'Редакция на на IP/порт';
$lng['admin']['ipsandports']['ipandport'] = 'IP/порт';
$lng['admin']['ipsandports']['ip'] = 'IP';
$lng['admin']['ipsandports']['port'] = 'Порт';
$lng['admin']['memorylimitdisabled'] = 'Забранен';
$lng['admin']['valuemandatory'] = 'Тази стойност е задължителна';
$lng['admin']['valuemandatorycompany'] = 'Трябва да бъдат попълнени или &quot;фамилия&quot; и &quot;първо име&quot; or &quot;фирма&quot;';

/**
 * Serversettings
 */

$lng['serversettings']['session_timeout']['title'] = 'Изтичане на сесия';
$lng['serversettings']['session_timeout']['description'] = 'Колко дълго трябва да е неактивен един потребител, преди сесията да стане невалидна (в секунди)?';
$lng['serversettings']['accountprefix']['title'] = 'Префикс на клиент';
$lng['serversettings']['accountprefix']['description'] = 'Какъв ще бъде префикса на сметките на клиенти?';
$lng['serversettings']['mysqlprefix']['title'] = 'SQL префикс';
$lng['serversettings']['mysqlprefix']['description'] = 'Какъв префикс ще имат сметките за MySQL?';
$lng['serversettings']['ftpprefix']['title'] = 'FTP префикс';
$lng['serversettings']['ftpprefix']['description'] = 'Какъв префикс ще имат сметките за FTP?';
$lng['serversettings']['documentroot_prefix']['title'] = 'Директория за документи';
$lng['serversettings']['documentroot_prefix']['description'] = 'Къде ще се съхраняват всички данни?';
$lng['serversettings']['logfiles_directory']['title'] = 'Директория за журнални файлове';
$lng['serversettings']['logfiles_directory']['description'] = 'Къде ще се съхраняват всички журнални файлове?';
$lng['serversettings']['ipaddress']['title'] = 'IP адрес';
$lng['serversettings']['ipaddress']['description'] = 'Какъв е IP адресът на този сървър?';
$lng['serversettings']['hostname']['title'] = 'Име на хост';
$lng['serversettings']['hostname']['description'] = 'Какво е името на хост на този сървър?';
$lng['serversettings']['apachereload_command']['title'] = 'Команда за презареждане на apache';
$lng['serversettings']['apachereload_command']['description'] = 'Каква е командата за презареждане на apache?';
$lng['serversettings']['bindconf_directory']['title'] = 'Конфигурационна директория на Bind';
$lng['serversettings']['bindconf_directory']['description'] = 'Къде се намират конфигурационните файлове на bind?';
$lng['serversettings']['bindreload_command']['title'] = 'Команда за презареждане на bind';
$lng['serversettings']['bindreload_command']['description'] = 'Каква е командата за презареждане на bind?';
$lng['serversettings']['binddefaultzone']['title'] = 'Зона по подразбиране на Bind';
$lng['serversettings']['binddefaultzone']['description'] = 'Какво е името на зоната по подразбиране?';
$lng['serversettings']['vmail_uid']['title'] = 'UID на пощите';
$lng['serversettings']['vmail_uid']['description'] = 'Какво ще бъде потребителското ID на пощите?';
$lng['serversettings']['vmail_gid']['title'] = 'GID на пощите';
$lng['serversettings']['vmail_gid']['description'] = 'Какво ще бъде груповото ID на пощите?';
$lng['serversettings']['vmail_homedir']['title'] = 'Директория за пощи';
$lng['serversettings']['vmail_homedir']['description'] = 'Къде ще се съхраняват всички пощи?';
$lng['serversettings']['adminmail']['title'] = 'Изпращач';
$lng['serversettings']['adminmail']['description'] = 'Какъв ще бъде адреса на изпращача на всички пощи от този панел?';
$lng['serversettings']['phpmyadmin_url']['title'] = 'phpMyAdmin URL';
$lng['serversettings']['phpmyadmin_url']['description'] = 'Какъв е адресът на phpMyAdmin? (трябва да започва с http://)';
$lng['serversettings']['webmail_url']['title'] = 'Адрес на уеб поща';
$lng['serversettings']['webmail_url']['description'] = 'Какъв е адресът на уеб пощата? (трябва да започва с http://)';
$lng['serversettings']['webftp_url']['title'] = 'WebFTP URL';
$lng['serversettings']['webftp_url']['description'] = 'Какъв е адресът на WebFTP? (трябва да започва с http://)';
$lng['serversettings']['language']['description'] = 'Какъв е езикът по подразбиране на вашия сървър?';
$lng['serversettings']['maxloginattempts']['title'] = 'Максимален брой опити за влизане';
$lng['serversettings']['maxloginattempts']['description'] = 'Максимален брой неуспешни опити за влизане, преди сметката да бъде деактивирана.';
$lng['serversettings']['deactivatetime']['title'] = 'Продължителност на деактивацията';
$lng['serversettings']['deactivatetime']['description'] = 'Време в секунди, за което ще бъде деактивирана дадена сметка при прекалено голям брой неуспешни опити за влизане.';
$lng['serversettings']['pathedit']['title'] = 'Тип на въвеждането на пътя';
$lng['serversettings']['pathedit']['description'] = 'Пътят да бъде избиран посредством падащо меню или поле за вход?';
$lng['serversettings']['paging']['title'] = 'Записи на страница';
$lng['serversettings']['paging']['description'] = 'Колко записа да бъдат показвани на страница? (0 = забранява странирането)';
$lng['serversettings']['defaultip']['title'] = 'IP/порт по подразбиране';
$lng['serversettings']['defaultip']['description'] = 'Коя е комбинацията IP/порт по подразбиране?';

?>
