<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2003-2009 the SysCP Team (see authors).
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.syscp.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Jackie Zhang <jackie.zhang@arcor.de>
 * @author     Wang Changyi <wangchangyi@hotmail.com>
 * @author     Patrick Brueckner <patrick_brueckner@yahoo.de>
 * @author     Yuan Yang <melodieyy@web.de>
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Language
 *
 */

/**
 * Global
 */

$lng['translator'] = 'Jackie Zhang, Wang Changyi, Yuan Yang';
$lng['panel']['edit'] = '编辑';
$lng['panel']['delete'] = '删除';
$lng['panel']['create'] = '创建';
$lng['panel']['save'] = '保存';
$lng['panel']['yes'] = '是';
$lng['panel']['no'] = '否';
$lng['panel']['emptyfornochanges'] = '无改变清空';
$lng['panel']['emptyfordefault'] = '默认值清空';
$lng['panel']['path'] = '路径';
$lng['panel']['toggle'] = '触发器';
$lng['panel']['next'] = '下一个';
$lng['panel']['dirsmissing'] = '目录不可添加或者不可读';

/**
 * Login
 */

$lng['login']['username'] = '用户名';
$lng['login']['password'] = '密码';
$lng['login']['language'] = '语言';
$lng['login']['login'] = '登陆';
$lng['login']['logout'] = '登出';
$lng['login']['profile_lng'] = '用户标准语言';

/**
 * Customer
 */

$lng['customer']['documentroot'] = '根目录';
$lng['customer']['name'] = '姓';
$lng['customer']['firstname'] = '名';
$lng['customer']['company'] = '公司';
$lng['customer']['street'] = '街道';
$lng['customer']['zipcode'] = '邮政编码';
$lng['customer']['city'] = '城市';
$lng['customer']['phone'] = '电话';
$lng['customer']['fax'] = '传真';
$lng['customer']['email'] = '电子邮件';
$lng['customer']['customernumber'] = '顾客号';
$lng['customer']['diskspace'] = '磁盘空间(MB)';
$lng['customer']['traffic'] = '流量(GB)';
$lng['customer']['mysqls'] = 'MySQL数据库';
$lng['customer']['emails'] = '电子邮件地址';
$lng['customer']['accounts'] = '电子邮件帐户';
$lng['customer']['forwarders'] = '电子邮件转发';
$lng['customer']['ftps'] = 'FTP文件格式';
$lng['customer']['subdomains'] = '子域';
$lng['customer']['domains'] = '域';
$lng['customer']['unlimited'] = '无限的';

/**
 * Customermenue
 */

$lng['menue']['main']['main'] = '主要的';
$lng['menue']['main']['changepassword'] = '更改密码';
$lng['menue']['main']['changelanguage'] = '语言转换';
$lng['menue']['email']['email'] = '电子邮件';
$lng['menue']['email']['emails'] = '地址';
$lng['menue']['email']['webmail'] = '网络邮件';
$lng['menue']['mysql']['mysql'] = 'MySQL';
$lng['menue']['mysql']['databases'] = '数据库';
$lng['menue']['mysql']['phpmyadmin'] = 'phpMyAdmin';
$lng['menue']['domains']['domains'] = '域';
$lng['menue']['domains']['settings'] = '设置';
$lng['menue']['ftp']['ftp'] = 'FTP';
$lng['menue']['ftp']['accounts'] = '账户';
$lng['menue']['ftp']['webftp'] = '网络FTP地址';
$lng['menue']['extras']['extras'] = '专用';
$lng['menue']['extras']['directoryprotection'] = '目录保护';
$lng['menue']['extras']['pathoptions'] = '路径选择';

/**
 * Index
 */

$lng['index']['customerdetails'] = '用户数据';
$lng['index']['accountdetails'] = '账户数据';

/**
 * Change Password
 */

$lng['changepassword']['old_password'] = '旧密码';
$lng['changepassword']['new_password'] = '新密码';
$lng['changepassword']['new_password_confirm'] = '新密码(确认)';
$lng['changepassword']['new_password_ifnotempty'] = $lng['changepassword']['new_password'] . '(' . $lng['panel']['emptyfornochanges'] . ')';
$lng['changepassword']['also_change_ftp'] = '改变主FTP入口的密码';

/**
 * Domains
 */

$lng['domains']['description'] = '这里您可以设置域以及更改路径<br/>在每次更改后系统需要一些时间重新读取设置';
$lng['domains']['domainsettings'] = '域设置';
$lng['domains']['domainname'] = '域名';
$lng['domains']['subdomain_add'] = '添加子域';
$lng['domains']['subdomain_edit'] = '编辑子域';
$lng['domains']['wildcarddomain'] = '做为原始域登记';
$lng['domains']['aliasdomain'] = '域别名';
$lng['domains']['noaliasdomain'] = '无域别名';

/**
 * eMails
 */

$lng['emails']['description'] = '这里您可以创建您的电子邮件地址<br />POP账户如同您门前的邮箱，每当有人给您写电子邮件，电子邮件便会被放置在POP账户中<br/><br/>您邮件程序的进入数据如下所示：<i>斜体字</i>的说明会被每次的登记而替代<br /><b>主机名<b><i>域名</i></b><br />用户名):<b><i>账户名/电子邮件地址</i></b><br />密码:<b><i>被选密码</i></b>';
$lng['emails']['emailaddress'] = '电子邮件地址';
$lng['emails']['emails_add'] = '创建电子邮件地址';
$lng['emails']['emails_edit'] = '编辑电子邮件地址';
$lng['emails']['catchall'] = '电邮户口';
$lng['emails']['iscatchall'] = '设置成电邮户口?';
$lng['emails']['account'] = '帐户';
$lng['emails']['account_add'] = '创建帐户';
$lng['emails']['account_delete'] = '删除帐户';
$lng['emails']['from'] = '从';
$lng['emails']['to'] = '到';
$lng['emails']['forwarders'] = '代运人';
$lng['emails']['forwarder_add'] = '创建代运人';

/**
 * FTP
 */

$lng['ftp']['description'] = '这里您可以创建额外的FTP账户<br />更改立刻生效并且FTP账户立刻可以使用';
$lng['ftp']['account_add'] = '添加账户';

/**
 * MySQL
 */

$lng['mysql']['description'] = '这里您可以添加和删除MySQL数据库<br />更改立刻生效并且数据库立刻可以使用<br />在菜单中您可以找到去往phpMyAdmin的链接，在此您可以轻松编辑您数据库中的内容<br /><br />php原文件的进入数据如下所示:<i>斜体字</i>的说明会被每次的登记而替代<br />主机名:<b><SQL_HOST></b><br />用户名:<b><i>数据库名</i></b><br />密码:<b><i>被选密码</i></b><br />数据库:<b><i>数据库名';
$lng['mysql']['databasename'] = '用户名/数据库名';
$lng['mysql']['databasedescription'] = '数据库描述';
$lng['mysql']['database_create'] = '创建数据库';

/**
 * Extras
 */

$lng['extras']['description'] = '这里您可以创建额外的专用，譬如目录保护<br/>更改在一定时间后才生效';
$lng['extras']['directoryprotection_add'] = '添加目录保护';
$lng['extras']['view_directory'] = '显示记录';
$lng['extras']['pathoptions_add'] = '配置路径';
$lng['extras']['directory_browsing'] = '显示记录内容';
$lng['extras']['pathoptions_edit'] = '路径设置处理';
$lng['extras']['error404path'] = '404';
$lng['extras']['error403path'] = '403';
$lng['extras']['error500path'] = '500';
$lng['extras']['error401path'] = '401';
$lng['extras']['errordocument404path'] = '错误文件404路径';
$lng['extras']['errordocument403path'] = '错误文件403路径';
$lng['extras']['errordocument500path'] = '错误文件500路径';
$lng['extras']['errordocument401path'] = '错误文件401路径';

/**
 * Errors
 */

$lng['error']['error'] = '错误报告';
$lng['error']['directorymustexist'] = '目录%s必须存在.请创建您的FTP客户';
$lng['error']['filemustexist'] = '文件%s必须存在.';
$lng['error']['allresourcesused'] = '您已经使用了所有的资源';
$lng['error']['domains_cantdeletemaindomain'] = '您不能删除已经作为电邮域使用过的域';
$lng['error']['domains_canteditdomain'] = '您不能编辑这个域名，它已经被版主废除';
$lng['error']['domains_cantdeletedomainwithemail'] = '您不能删除电子邮件域名，请首先删除所有的电子邮件地址';
$lng['error']['firstdeleteallsubdomains'] = '在您创建一个新的原始域之前，必须先删除所有的子域。';
$lng['error']['youhavealreadyacatchallforthisdomain'] = '您已经为这项域名设置了一个电邮户口';
$lng['error']['ftp_cantdeletemainaccount'] = '您不能删除您的主账户';
$lng['error']['login'] = '被输入的用户名/密码错误';
$lng['error']['login_blocked'] = '由于多次错误的尝试这个账户将被关闭！<br/>请您在' . $settings['login']['deactivatetime'] . '秒后重新尝试。';
$lng['error']['notallreqfieldsorerrors'] = '您没有填写所有的文本栏或者有一个文本栏被错误填写';
$lng['error']['oldpasswordnotcorrect'] = '旧密码不正确';
$lng['error']['youcantallocatemorethanyouhave'] = '您不能分配比您现有的更多的资源。';
$lng['error']['mustbeurl'] = '您没有输入有效或者完整的url(例如http://somedomain.com/error404.htm)';
$lng['error']['invalidpath'] = '您没有选择有效的URL地址（可能是目录列表的问题）';
$lng['error']['stringisempty'] = '缺少区域内的输入';
$lng['error']['stringiswrong'] = '区域内输入错误';
$lng['error']['myloginname'] = '\'' . $lng['login']['username'] . '\'';
$lng['error']['mypassword'] = '\'' . $lng['login']['password'] . '\'';
$lng['error']['oldpassword'] = '\'' . $lng['changepassword']['old_password'] . '\'';
$lng['error']['newpassword'] = '\'' . $lng['changepassword']['new_password'] . '\'';
$lng['error']['newpasswordconfirm'] = '\'' . $lng['changepassword']['new_password_confirm'] . '\'';
$lng['error']['newpasswordconfirmerror'] = '新密码和新密码确定不匹配';
$lng['error']['myname'] = '\'' . $lng['customer']['name'] . '\'';
$lng['error']['myfirstname'] = '\'' . $lng['customer']['firstname'] . '\'';
$lng['error']['emailadd'] = '\'' . $lng['customer']['email'] . '\'';
$lng['error']['mydomain'] = '\'域名\'';
$lng['error']['mydocumentroot'] = '\'文件来源\'';
$lng['error']['loginnameexists'] = '登陆名%s已经存在';
$lng['error']['emailiswrong'] = '电子邮件地址 %s 包含了无效的字符或者不完整';
$lng['error']['loginnameiswrong'] = '电子邮件地址 %s 包含了无效的字符';
$lng['error']['userpathcombinationdupe'] = '用户名和路径已经存在';
$lng['error']['patherror'] = '常规错误! 路径不能空着';
$lng['error']['errordocpathdupe'] = '路径选项%s已经存在';
$lng['error']['adduserfirst'] = '请首先建立一个客户';
$lng['error']['domainalreadyexists'] = '域名%s已经指派给了客户';
$lng['error']['nolanguageselect'] = '没有选择语言';
$lng['error']['nosubjectcreate'] = '您必须为邮件模板定义一个主题';
$lng['error']['nomailbodycreate'] = '您必须为邮件模板定义邮件正文';
$lng['error']['templatenotfound'] = '模板没有找到';
$lng['error']['alltemplatesdefined'] = '您不能定义更多的模板，已经支持所有的语言';
$lng['error']['wwwnotallowed'] = 'www不能作为子域名名称';
$lng['error']['subdomainiswrong'] = '子域名%s包含了无效的字符';
$lng['error']['domaincantbeempty'] = '域名不能空着';
$lng['error']['domainexistalready'] = '域名%s已经存在';
$lng['error']['domainisaliasorothercustomer'] = '|所选域别名可自身为别名域 或属于另一客户.';
$lng['error']['emailexistalready'] = '电子邮件地址%s已经存在';
$lng['error']['maindomainnonexist'] = '主域名%s不存在';
$lng['error']['destinationnonexist'] = '请在区域内建立你的代运人\'目的地\'';
$lng['error']['destinationalreadyexistasmail'] = '到%s的代运人已经作为一个电子邮件地址存在';
$lng['error']['destinationalreadyexist'] = '你已经定义了到%s的代运人';
$lng['error']['destinationiswrong'] = '代运人%s包含了无效的字符或者不完整';
$lng['error']['domainname'] = $lng['domains']['domainname'];

/**
 * Questions
 */

$lng['question']['question'] = '安全问题';
$lng['question']['admin_customer_reallydelete'] = '您真的想要删除这个客户吗%s？<br/>注意！所有的数据将不可挽回的丢失！在操作后您必须还要用手把数据从数据系统中删除';
$lng['question']['admin_domain_reallydelete'] = '您真的想删除域%s吗？';
$lng['question']['admin_domain_reallydisablesecuritysetting'] = '您真的想关闭这些重要的安全设置吗？';
$lng['question']['admin_admin_reallydelete'] = '您真的要删除主要管理员%s？所有的客户和域可都是由它分配的！';
$lng['question']['admin_template_reallydelete'] = '您真的想删除\'%s\'模板吗?';
$lng['question']['domains_reallydelete'] = '您真的想删除域%s吗？';
$lng['question']['email_reallydelete'] = '您真的想删除电子邮件%s吗？';
$lng['question']['email_reallydelete_account'] = '您真的想删除电子邮件帐户%s吗？';
$lng['question']['email_reallydelete_forwarder'] = '您真的想删除代运人%s吗？';
$lng['question']['extras_reallydelete'] = '您真的想删除目录保护%s吗？';
$lng['question']['extras_reallydelete_pathoptions'] = '您真的想删除这个路径的配置%s吗？';
$lng['question']['ftp_reallydelete'] = '您真的想删FTP账户%s吗？';
$lng['question']['mysql_reallydelete'] = '您真的想删除数据库%s吗？注意！所有的数据将不可挽回的丢失！';
$lng['question']['admin_configs_reallyrebuild'] = '您真的想新建Apache和Bind配置文件吗？';

/**
 * Mails
 */

$lng['mails']['pop_success']['mailbody'] = '你好以被成功创建这是一个自动生成的这是一个自动生成的邮件，请不用答复这个通知您的服务小组';
$lng['mails']['pop_success']['subject'] = 'POP3账户成功被创建';
$lng['mails']['createcustomer']['mailbody'] = '您好{FIRSTNAME} {NAME},\n\n这里是您的账户信息:\n\n用户名: {USERNAME}\n密码: {PASSWORD}\n\n非常感谢，您的服务小组';
$lng['mails']['createcustomer']['subject'] = '账户信息';

/**
 * Admin
 */

$lng['admin']['overview'] = '概要';
$lng['admin']['ressourcedetails'] = '被使用的资源';
$lng['admin']['systemdetails'] = '系统详情';
$lng['admin']['froxlordetails'] = 'Froxlor-详情';
$lng['admin']['installedversion'] = '安装版本';
$lng['admin']['latestversion'] = '最新版本';
$lng['admin']['lookfornewversion']['clickhere'] = '通过网络服务询问';
$lng['admin']['lookfornewversion']['error'] = '在挑选上出现错误';
$lng['admin']['resources'] = '资源';
$lng['admin']['customer'] = '客户';
$lng['admin']['customers'] = '客户群';
$lng['admin']['customer_add'] = '添加客户群';
$lng['admin']['customer_edit'] = '编辑客户群';
$lng['admin']['domains'] = '组域';
$lng['admin']['domain_add'] = '添加域';
$lng['admin']['domain_edit'] = '编辑域';
$lng['admin']['subdomainforemail'] = '副域名作为电子邮件域名';
$lng['admin']['admin'] = '主管';
$lng['admin']['admins'] = '管理';
$lng['admin']['admin_add'] = '加入新的主管';
$lng['admin']['admin_edit'] = '对主管进行编辑';
$lng['admin']['customers_see_all'] = '所有的客户都能看到吗？';
$lng['admin']['domains_see_all'] = '所有的域都能看到吗？';
$lng['admin']['change_serversettings'] = '服务设置能被修改吗？';
$lng['admin']['server'] = '服务器';
$lng['admin']['serversettings'] = '设置';
$lng['admin']['rebuildconf'] = '配置新建';
$lng['admin']['stdsubdomain'] = '默认子域';
$lng['admin']['stdsubdomain_add'] = '添加默认子域';
$lng['admin']['deactivated'] = '被禁止';
$lng['admin']['deactivated_user'] = '封锁用户';
$lng['admin']['sendpassword'] = '寄出密码';
$lng['admin']['configfiles']['serverconfiguration'] = '配置';
$lng['admin']['ownvhostsettings'] = '自己的主机设置(vHost)';
$lng['admin']['configfiles']['files'] = '<b>编辑数据:</b>请您更改成相符的编辑数据。<br />如果它们不存在，就请您输入下面的内容。<br /><b>请您注意：</b>由于保密原因,MySQL的密码将不被替换。）<br />请您通过手动的方式替换MySQL的密码。<br />如果您忘记了密码，您可以在`lib/userdata.inc.php`找到。';
$lng['admin']['configfiles']['commands'] = '<b>命令：</b>请您在一页内输出以下的命令。';
$lng['admin']['configfiles']['restart'] = '<b>重新开始：</b>请您输出以下命令以便重新装载。编辑数据应不超过一页';
$lng['admin']['templates']['templates'] = '模板';
$lng['admin']['templates']['template_add'] = '添加模板';
$lng['admin']['templates']['template_edit'] = '编辑模板';
$lng['admin']['templates']['action'] = '动作';
$lng['admin']['templates']['email'] = '电子邮件';
$lng['admin']['templates']['subject'] = '主题';
$lng['admin']['templates']['mailbody'] = '邮件内容';
$lng['admin']['templates']['createcustomer'] = '对新客户的欢迎函';
$lng['admin']['templates']['pop_success'] = '对新邮件帐户的欢迎函';
$lng['admin']['templates']['template_replace_vars'] = '模板中的替换变量:';
$lng['admin']['templates']['FIRSTNAME'] = '更换客户名';
$lng['admin']['templates']['NAME'] = '更换客户姓';
$lng['admin']['templates']['USERNAME'] = '更换客户帐户用户名';
$lng['admin']['templates']['PASSWORD'] = '更换客户帐户密码';
$lng['admin']['templates']['EMAIL'] = '更换 POP3/IMAP 帐户地址';

/**
 * Serversettings
 */

$lng['serversettings']['session_timeout']['title'] = '对话超时';
$lng['serversettings']['session_timeout']['description'] = '用户多长时间必须呈现冻结状态，与此同时对话也变为无效';
$lng['serversettings']['accountprefix']['title'] = '客户前缀';
$lng['serversettings']['accountprefix']['description'] = '客户账户应该有哪种前缀？';
$lng['serversettings']['mysqlprefix']['title'] = 'MySQL-前缀';
$lng['serversettings']['mysqlprefix']['description'] = 'MySQL 账户应该有哪些前缀？';
$lng['serversettings']['ftpprefix']['title'] = 'FTP前缀';
$lng['serversettings']['ftpprefix']['description'] = 'FTP账户应该有哪些前缀？';
$lng['serversettings']['documentroot_prefix']['title'] = '文档目录';
$lng['serversettings']['documentroot_prefix']['description'] = '所有的客户应位于哪里？';
$lng['serversettings']['logfiles_directory']['title'] = '登陆文件目录';
$lng['serversettings']['logfiles_directory']['description'] = '所有的登陆文件应位于哪里';
$lng['serversettings']['ipaddress']['title'] = 'IP地址';
$lng['serversettings']['ipaddress']['description'] = '这个服务器IP地址是什么?';
$lng['serversettings']['hostname']['title'] = '主机名';
$lng['serversettings']['hostname']['description'] = '这个服务器的主机名是什么?';
$lng['serversettings']['apachereload_command']['title'] = '阿帕奇重新读取命令';
$lng['serversettings']['apachereload_command']['description'] = '被读取的阿帕奇文稿叫什么名字';
$lng['serversettings']['bindconf_directory']['title'] = '连接配置目录';
$lng['serversettings']['bindconf_directory']['description'] = '连接配置数据位于哪里？';
$lng['serversettings']['bindreload_command']['title'] = '连接-重新读取命令';
$lng['serversettings']['bindreload_command']['description'] = '连接的重置文本叫作什么';
$lng['serversettings']['binddefaultzone']['title'] = '连接-默认区域';
$lng['serversettings']['binddefaultzone']['description'] = '所有域的默认区域叫作什么？';
$lng['serversettings']['vmail_uid']['title'] = '邮件UID';
$lng['serversettings']['vmail_uid']['description'] = '邮件应该有哪些UID';
$lng['serversettings']['vmail_gid']['title'] = '邮件Gid';
$lng['serversettings']['vmail_gid']['description'] = '邮件应该有哪些Gid?';
$lng['serversettings']['vmail_homedir']['title'] = '邮件地址目录';
$lng['serversettings']['vmail_homedir']['description'] = '邮件应该位于哪里？';
$lng['serversettings']['adminmail']['title'] = '发信人地址';
$lng['serversettings']['adminmail']['description'] = '来自调查对象的邮件发信人地址是什么？';
$lng['serversettings']['phpmyadmin_url']['title'] = 'phpMyAdmin地址';
$lng['serversettings']['phpmyadmin_url']['description'] = 'phpMyAdmin位于哪里？';
$lng['serversettings']['webmail_url']['title'] = '网络邮件的URL';
$lng['serversettings']['webmail_url']['description'] = '网络邮件放在哪里?';
$lng['serversettings']['webftp_url']['title'] = '网络FTP的URL';
$lng['serversettings']['webftp_url']['description'] = '网络FTP放在哪里?';
$lng['serversettings']['language']['description'] = '您的标准语言是什么语？';
$lng['serversettings']['maxloginattempts']['title'] = '最多登陆次数';
$lng['serversettings']['maxloginattempts']['description'] = '最多登陆次数直到帐户失效';
$lng['serversettings']['deactivatetime']['title'] = '帐户失效时间';
$lng['serversettings']['deactivatetime']['description'] = '帐户失效时间（以秒计算）';
$lng['serversettings']['pathedit']['title'] = '路径输入方法';
$lng['serversettings']['pathedit']['description'] = '路径是通过下拉菜单选择，还是自行输入？';

/**
 * ADDED BETWEEN 1.2.12 and 1.2.13
 */

$lng['serversettings']['paging']['title'] = '每页进入次数';
$lng['serversettings']['paging']['description'] = '一页上应该显示多少次 进入?(0 =无效分页)';
$lng['error']['ipstillhasdomains'] = '你想要删除的IP/ 端口连接仍然占有分 配给他的域,在删除此IP/端口连接之前，请把这些域分配给其他IP/端口连接.';
$lng['error']['cantdeletedefaultip'] = '你不能删除默认的分销商IP/端口连 接, 请在删除这个IP/端口连接前为分销商另设置默认IP/端口连接.';
$lng['error']['cantdeletesystemip'] = '你不能删除系统IP, 你可以为系统IP 另生成一个新的IP/端口连接, 或者改变系统IP.';
$lng['error']['myipaddress'] = '\'IP\'';
$lng['error']['myport'] = '\'端口\'';
$lng['error']['myipdefault'] = '你需要选择一个IP/端口连接并设为默认值.';
$lng['error']['myipnotdouble'] = '这一IP/端口连接已存在.';
$lng['question']['admin_ip_reallydelete'] = '你真的决定删除IP地址 %s?';
$lng['admin']['ipsandports']['ipsandports'] = '多个IP和端口';
$lng['admin']['ipsandports']['add'] = '添加IP/端口';
$lng['admin']['ipsandports']['edit'] = '编辑IP/端口';
$lng['admin']['ipsandports']['ipandport'] = 'IP/端口';
$lng['admin']['ipsandports']['ip'] = 'IP';
$lng['admin']['ipsandports']['port'] = '端口';

// ADDED IN 1.2.13-rc3

$lng['error']['cantchangesystemip'] = '你不能改变最近用过的系统IP,要么生成一个新的IP/端口组合, 要么改变系统IP.';
$lng['question']['admin_domain_reallydocrootoutofcustomerroot'] = '你确定你想要这个域的文件源生成于客户的客户根目录之外?';

// ADDED IN 1.2.14-rc1

$lng['admin']['memorylimitdisabled'] = '关闭';
$lng['error']['loginnameissystemaccount'] = '你不能生成与系统帐号相似的帐户. 请另输入一个帐户名';
$lng['domain']['openbasedirpath'] = '公开基址目录路径';
$lng['domain']['docroot'] = '来自上一信息组的路径';
$lng['domain']['homedir'] = '家目录';
$lng['admin']['valuemandatory'] = '此值为强制性的';
$lng['admin']['valuemandatorycompany'] = '"姓"与"名"或者"公司名"为必填项';
$lng['menue']['main']['username'] = '以:  登录 ';
$lng['panel']['urloverridespath'] = 'URL (覆盖路径)';
$lng['panel']['pathorurl'] = '路径或URL';
$lng['error']['sessiontimeoutiswrong'] = '只容许数字的"对话超时".';
$lng['error']['maxloginattemptsiswrong'] = '只容许数字的"登录尝试最大值".';
$lng['error']['deactivatetimiswrong'] = '只容许数字的"停用时间".';
$lng['error']['accountprefixiswrong'] = '"客户前缀"错误.';
$lng['error']['mysqlprefixiswrong'] = '"SQL前缀"错误.';
$lng['error']['ftpprefixiswrong'] = '"FTP前缀"错误.';
$lng['error']['ipiswrong'] = '"IP地址"错误. 只容许有效的IP地址.';
$lng['error']['vmailuidiswrong'] = '"Mails-uid"错误. 只容许数字的UID.';
$lng['error']['vmailgidiswrong'] = '"Mails-gid"错误. 只容许数字的GID.';
$lng['error']['adminmailiswrong'] = '"寄件人地址"错误. 只容许有效的Email地址.';
$lng['error']['pagingiswrong'] = '"每页记录"值错误. 只容许数字符号.';
$lng['error']['phpmyadminiswrong'] = 'phpmyadmin-链接不是一个有效链接.';
$lng['error']['webmailiswrong'] = 'WebMail-链接不是一个有效链接.';
$lng['error']['webftpiswrong'] = 'WebFTP-链接不是一个有效链接.';
$lng['domains']['hasaliasdomains'] = '有别名域';
$lng['serversettings']['defaultip']['title'] = '默认IP/端口';
$lng['serversettings']['defaultip']['description'] = '默认的IP/端口组合是什么?';
$lng['domains']['statstics'] = '使用统计';
$lng['panel']['ascending'] = '向上的';
$lng['panel']['decending'] = '向下的';
$lng['panel']['search'] = '搜寻';
$lng['panel']['used'] = '已用';

// ADDED IN 1.2.14-rc3

$lng['panel']['translator'] = '翻译者';

// ADDED IN 1.2.14-rc4

$lng['error']['stringformaterror'] = '信息组"%s"值不是期望格式';

// ADDED in 1.2.15-svn1

$lng['admin']['serversoftware'] = '服务器软件';
$lng['admin']['phpversion'] = 'php版本';
$lng['admin']['phpmemorylimit'] = 'php内存限制';
$lng['admin']['mysqlserverversion'] = 'mysql服务器版本';
$lng['admin']['mysqlclientversion'] = 'mysql客户端版本';
$lng['admin']['webserverinterface'] = '网页服务器接口';

?>
