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
 * @author     Ricardo Luiz Costa <ricardo@winger.com.br>
 * @author     Thiago Goncalves de Castro <thiago@davoi.com.br>
 * @author     Rafael Andrade <slyppp@gmail.com>
 * @author     Froxlor Team <team@froxlor.org>
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Language
 * @version    $Id$
 */

/**
 * Global
 */

$lng['translator'] = 'Ricardo Luiz Costa, Rafael Andrade, Thiago Goncalves de Castro';
$lng['panel']['edit'] = 'Editar';
$lng['panel']['delete'] = 'Deletar';
$lng['panel']['create'] = 'Criar';
$lng['panel']['save'] = 'Salvar';
$lng['panel']['yes'] = 'Sim';
$lng['panel']['no'] = 'N&atilde;o';
$lng['panel']['emptyfornochanges'] = 'Sair sem salvar';
$lng['panel']['emptyfordefault'] = 'Restaurar padr&atilde;o';
$lng['panel']['path'] = 'Caminho';
$lng['panel']['toggle'] = 'Toggle';
$lng['panel']['next'] = 'Pr&oacute;ximo';
$lng['panel']['dirsmissing'] = 'Direct&oacute;rio n&atilde;o dispon&iacute;vel ou ileg&iacute;vel';

/**
 * Login
 */

$lng['login']['username'] = 'Usu&aacute;rio';
$lng['login']['password'] = 'Senha';
$lng['login']['language'] = 'Idioma';
$lng['login']['login'] = 'Login';
$lng['login']['logout'] = 'Sair';
$lng['login']['profile_lng'] = 'Idioma padr&atilde;o';

/**
 * Customer
 */

$lng['customer']['documentroot'] = 'Diretorio home';
$lng['customer']['name'] = 'Sobrenome';
$lng['customer']['firstname'] = 'Primeiro nome';
$lng['customer']['company'] = 'Empresa';
$lng['customer']['street'] = 'Endere&ccedil;o';
$lng['customer']['zipcode'] = 'Cep';
$lng['customer']['city'] = 'Cidade';
$lng['customer']['phone'] = 'Telefone';
$lng['customer']['fax'] = 'Fax';
$lng['customer']['email'] = 'E-mail';
$lng['customer']['customernumber'] = 'Cliente ID';
$lng['customer']['diskspace'] = 'Espa&ccedil;o de disco (MB)';
$lng['customer']['traffic'] = 'Tr&aacute;fego (GB)';
$lng['customer']['mysqls'] = 'Bancos de dados-MySQL';
$lng['customer']['emails'] = 'Endere&ccedil;os de e-mail';
$lng['customer']['accounts'] = 'Contas de e-mail';
$lng['customer']['forwarders'] = 'Redirecionamentos de e-mail';
$lng['customer']['ftps'] = 'Contas de FTP';
$lng['customer']['subdomains'] = 'Sub-Dominio(s)';
$lng['customer']['domains'] = 'Dominio(s)';
$lng['customer']['unlimited'] = 'ilimitados';

/**
 * Customermenue
 */

$lng['menue']['main']['main'] = 'Principal';
$lng['menue']['main']['changepassword'] = 'Trocar senha';
$lng['menue']['main']['changelanguage'] = 'Trocar idioma';
$lng['menue']['email']['email'] = 'e-mail';
$lng['menue']['email']['emails'] = 'Endere&ccedil;os';
$lng['menue']['email']['webmail'] = 'WebMail';
$lng['menue']['mysql']['mysql'] = 'MySQL';
$lng['menue']['mysql']['databases'] = 'Banco de dados';
$lng['menue']['mysql']['phpmyadmin'] = 'phpMyAdmin';
$lng['menue']['domains']['domains'] = 'Dominios';
$lng['menue']['domains']['settings'] = 'Configura&ccedil;&otilde;es';
$lng['menue']['ftp']['ftp'] = 'FTP';
$lng['menue']['ftp']['accounts'] = 'Contas';
$lng['menue']['ftp']['webftp'] = 'WebFTP';
$lng['menue']['extras']['extras'] = 'Extras';
$lng['menue']['extras']['directoryprotection'] = 'Diretorio protegido';
$lng['menue']['extras']['pathoptions'] = 'op&ccedil;&otilde;es de caminhos';

/**
 * Index
 */

$lng['index']['customerdetails'] = 'Detalhes dos Clientes';
$lng['index']['accountdetails'] = 'Detalhes das Contas';

/**
 * Change Password
 */

$lng['changepassword']['old_password'] = 'Senha atual';
$lng['changepassword']['new_password'] = 'Nova senha';
$lng['changepassword']['new_password_confirm'] = 'Repita a nova senha';
$lng['changepassword']['new_password_ifnotempty'] = 'Nova senha (em branco = n&atilde;o alterar)';
$lng['changepassword']['also_change_ftp'] = ' trocar tambem a senha da conta principal de FTP';

/**
 * Domains
 */

$lng['domains']['description'] = 'Aqui voce pode criar(sub-)dominios e alterar seu destino.<br />O sistema ir&aacute; levar algum tempo para aplicar as novas configura&ccedil;&otilde;es depois de salvas.';
$lng['domains']['domainsettings'] = 'Configurar Dominio';
$lng['domains']['domainname'] = 'Nome do dominio';
$lng['domains']['subdomain_add'] = 'Criar Sub-dominio';
$lng['domains']['subdomain_edit'] = 'Editar (sub)dominio';
$lng['domains']['wildcarddomain'] = 'Criar um wildcarddomain?';
$lng['domains']['aliasdomain'] = 'Ali&aacute;s para o dominio';
$lng['domains']['noaliasdomain'] = 'N&atilde;o dominio do ali&aacute;s';

/**
 * eMails
 */

$lng['emails']['description'] = 'Aqui voce pode criar e alterer seus e-mails.<br />Uma conta &eacute; como uma caixa de correio na frente de sua casa. Quando alguem envia para voce um e-mail, ele &eacute; colocado nesta conta.<br /><br />Para baixar seus e-mails use as seguintes configura&ccedil;&otilde;es no seu propraga de e-mails favorito: (Os dados em <i>italico</i> devem ser substituidos pelo equivalente da conta que voce criou!)<br />Hostname: <b><i>Nome de seu dominio</i></b><br />Usu&aacute;rio: <b><i>Nome da conta / Endere&ccedil;o de e-mail</i></b><br />Senha: <b><i>a senha que voce escolheu</i></b>';
$lng['emails']['emailaddress'] = 'Endere&ccedil;os de e-mail';
$lng['emails']['emails_add'] = 'Criar e-mail';
$lng['emails']['emails_edit'] = 'Editar e-mail';
$lng['emails']['catchall'] = 'Pega tudo';
$lng['emails']['iscatchall'] = 'Definir como endere&ccedil;o pega tudo?';
$lng['emails']['account'] = 'Conta';
$lng['emails']['account_add'] = 'Criar conta';
$lng['emails']['account_delete'] = 'Excluir conta';
$lng['emails']['from'] = 'Origem';
$lng['emails']['to'] = 'Destino';
$lng['emails']['forwarders'] = 'Redirecionamentos';
$lng['emails']['forwarder_add'] = 'Criar redirecionamento';

/**
 * FTP
 */

$lng['ftp']['description'] = 'Aqui voce pode criar e alterar suas contas de FTP.<br />As altera&ccedil;&otilde;es s&atilde;o instant&acirc;neas e podem ser utilizadas imediatamente depois de salvas.';
$lng['ftp']['account_add'] = 'Criar conta';

/**
 * MySQL
 */

$lng['mysql']['description'] = 'Aqui voce pode criar e alterar seus bancos de dados MySQL.<br />As altera&ccedil;&otilde;es s&atilde;o instant&acirc;neas e podem ser utilizadas imediatamente depois de salvas.<br />No menu do lado esquerdo voce pode encontrar a ferramenta phpMyAdmin e com ela facilmente administrar seus bancos de dados.<br /><br />Para usar seu banco de dados com scripts em PHP use as seguintes configura&ccedil;&otilde;es: (Os dados em <i>italico</i> devem ser substituidos pelo equivalente do banco de dados que voce criou!)<br />Hostname: <b><SQL_HOST></b><br />Usuario: <b><i>Nome do banco de dadose</i></b><br />Senha: <b><i>a senha que voce escolheu</i></b><br />Banco de dados: <b><i>Nome do banco de dados';
$lng['mysql']['databasename'] = 'Usuario / Nome do banco de dados';
$lng['mysql']['databasedescription'] = 'Descri&ccedil;&atilde;o do banco de dados';
$lng['mysql']['database_create'] = 'Criar banco de dados';

/**
 * Extras
 */

$lng['extras']['description'] = 'Aqui voce pode adicoionar alguns recursos extras, como por exemplo um diret&oacute;rio protegido.<br />O sistema ira precisar de algum tempo para aplicar suas altera&ccedil;&otilde;es depois de salvas.';
$lng['extras']['directoryprotection_add'] = 'Adicionar diret&oacute;rio pretogido';
$lng['extras']['view_directory'] = 'Mostrar conte&uacute;do do diret&oacute;rio';
$lng['extras']['pathoptions_add'] = 'Adicionar op&ccedil;&otilde;es de caminho';
$lng['extras']['directory_browsing'] = 'Pesquizar conte&uacute;do de diret&oacute;rio';
$lng['extras']['pathoptions_edit'] = 'Esitar op&ccedil;&otilde;es de caminhos';
$lng['extras']['error404path'] = '404';
$lng['extras']['error403path'] = '403';
$lng['extras']['error500path'] = '500';
$lng['extras']['error401path'] = '401';
$lng['extras']['errordocument404path'] = 'URL para p&aacute;gina de erro 404';
$lng['extras']['errordocument403path'] = 'URL para p&aacute;gina de erro 403';
$lng['extras']['errordocument500path'] = 'URL para p&aacute;gina de erro 500';
$lng['extras']['errordocument401path'] = 'URL para p&aacute;gina de erro 401';

/**
 * Errors
 */

$lng['error']['error'] = 'Erro';
$lng['error']['directorymustexist'] = 'O diret&oacute;rio %s deve existir. Por favor crie ele primeiro com seu programa de FTP.';
$lng['error']['filemustexist'] = 'O arquivo %s deve existir.';
$lng['error']['allresourcesused'] = 'Voce j&aacute; usou todos os seus recursos.';
$lng['error']['domains_cantdeletemaindomain'] = 'Voce n&atilde;o pode deletar um dominio que esta sendo usado como email-domain.';
$lng['error']['domains_canteditdomain'] = 'Voce n&atilde;o pode editar este dominio. Ele foi desabilitado pelo administrador.';
$lng['error']['domains_cantdeletedomainwithemail'] = 'Voce n&atilde;o pode deletar um dominio que &eacute; usado como email-domain. Delete todos as contas de e-mail primeiro.';
$lng['error']['firstdeleteallsubdomains'] = 'Voce deve deletar todos subdominios antes de poder criar um wildcard domain.';
$lng['error']['youhavealreadyacatchallforthisdomain'] = 'Voce j&aacute; definiu uma conta pega tudo para este dominio.';
$lng['error']['ftp_cantdeletemainaccount'] = 'Voce n&atilde;o pode deletar a conta principal de FTP';
$lng['error']['login'] = 'O usu&aacute;rio ou senha digitados, n&atilde;o est&atilde;o corretos. Por favor tente novamente!';
$lng['error']['login_blocked'] = 'Esta conta est&aacute; suspensa por exceder as tentativas de login permitidas. <br />Por favor tente novamente em ' . $settings['login']['deactivatetime'] . ' segundos.';
$lng['error']['notallreqfieldsorerrors'] = 'Voce n&atilde;o preencheu todos os campos ou preencheu algum campo incorretamente.';
$lng['error']['oldpasswordnotcorrect'] = 'A senha antiga n&atilde;o confere.';
$lng['error']['youcantallocatemorethanyouhave'] = 'Voce n&atilde;o pode alocar mais recursos do que voce mesmo possui.';
$lng['error']['mustbeurl'] = 'Voce n&atilde;o digitou uma URL v&aacute;lida (ex. http://seudominio.com/erro404.htm)';
$lng['error']['invalidpath'] = 'Optou por um URL n&atilde;o v&aacute;lido (eventuais problemas na lista do direct&oacute;rio)';
$lng['error']['stringisempty'] = 'Faltando informa&ccedil;&atilde;o no campo';
$lng['error']['stringiswrong'] = 'Erro na informa&ccedil;&atilde;o do campo';
$lng['error']['myloginname'] = '\'' . $lng['login']['username'] . '\'';
$lng['error']['mypassword'] = '\'' . $lng['login']['password'] . '\'';
$lng['error']['oldpassword'] = '\'' . $lng['changepassword']['old_password'] . '\'';
$lng['error']['newpassword'] = '\'' . $lng['changepassword']['new_password'] . '\'';
$lng['error']['newpasswordconfirm'] = '\'' . $lng['changepassword']['new_password_confirm'] . '\'';
$lng['error']['newpasswordconfirmerror'] = 'A nova senha e a confirma&ccedil;&atilde;o n&atilde;o conferem';
$lng['error']['myname'] = '\'' . $lng['customer']['name'] . '\'';
$lng['error']['myfirstname'] = '\'' . $lng['customer']['firstname'] . '\'';
$lng['error']['emailadd'] = '\'' . $lng['customer']['email'] . '\'';
$lng['error']['mydomain'] = '\'Dominio\'';
$lng['error']['mydocumentroot'] = '\'Documento principal\'';
$lng['error']['loginnameexists'] = 'Login %s j&aacute; existe';
$lng['error']['emailiswrong'] = 'E-mail %s contem caracteres inv&aacute;lidos ou est&aacute; incompleto';
$lng['error']['loginnameiswrong'] = 'Login %s contem caracteres inv&aacute;lidos';
$lng['error']['userpathcombinationdupe'] = 'Usuario e caminho j&aacute; existem';
$lng['error']['patherror'] = 'Erro geral! o caminho n„o pode ficar em branco';
$lng['error']['errordocpathdupe'] = 'OpÁ„o de caminho %s j&aacute; existe';
$lng['error']['adduserfirst'] = 'Por favor crie um cliente primeiro';
$lng['error']['domainalreadyexists'] = 'O dominio %s j&aacute; est&aacute; apontado para outro cliente';
$lng['error']['nolanguageselect'] = 'Nenhum idioma selecionado.';
$lng['error']['nosubjectcreate'] = 'Voce deve definir um nome para este e-mail template.';
$lng['error']['nomailbodycreate'] = 'Voce deve definir o texto para este e-mail template.';
$lng['error']['templatenotfound'] = 'Template n&atilde;o encontrado.';
$lng['error']['alltemplatesdefined'] = 'Voce n&atilde;o pode definir mais templates, todos idiomas j&aacute; suportados.';
$lng['error']['wwwnotallowed'] = 'www n&atilde;o &eacute; permitido como nome de subdominio.';
$lng['error']['subdomainiswrong'] = 'O subdominio %s cont&eacute;m caracteres inv&aacute;lidos.';
$lng['error']['domaincantbeempty'] = 'O nome do dominio n&atilde;o pode estar vazio.';
$lng['error']['domainexistalready'] = 'O dominio %s j&aacute; existe.';
$lng['error']['domainisaliasorothercustomer'] = 'O dom&iacute;nio-alias escolhido &eacute; ele pr&oacute;prio um dom&iacute;nio-alias ou este pertence a um outro cliente.';
$lng['error']['emailexistalready'] = 'O E-mail %s j&aacute; existe.';
$lng['error']['maindomainnonexist'] = 'O dominio principal %s n&atilde;o existe.';
$lng['error']['destinationnonexist'] = 'Por favor crie seu redirecionamento no campo \'Destino\'.';
$lng['error']['destinationalreadyexistasmail'] = 'O redirecionamento %s j&aacute; existe como uma conta de e-mail.';
$lng['error']['destinationalreadyexist'] = 'Voce j&aacute; definiu um redirecionamento para %s .';
$lng['error']['destinationiswrong'] = 'O redirecionamento %s contem caracteres inv&aacute;lidos ou incompletos.';
$lng['error']['domainname'] = $lng['domains']['domainname'];

/**
 * Questions
 */

$lng['question']['question'] = 'Pergunta de seguran&ccedil;a';
$lng['question']['admin_customer_reallydelete'] = 'Voce realmente deseja deletar o cliente %s? Este comando n&atilde;o poder&aacute; ser cancelado!';
$lng['question']['admin_domain_reallydelete'] = 'Voce realmente deseja deletar o dominio %s?';
$lng['question']['admin_domain_reallydisablesecuritysetting'] = 'Voce realmente deseja desativar estas configura&ccedil;&otilde;es de seguran&ccedil;a (OpenBasedir e/ou SafeMode)?';
$lng['question']['admin_admin_reallydelete'] = 'Voce realmente deseja deletar o administrador %s? Todos clientes e dominios ser&atilde;o realocados para o administrador principal.';
$lng['question']['admin_template_reallydelete'] = 'Voce realmente deseja deletar o template \'%s\'?';
$lng['question']['domains_reallydelete'] = 'Voce realmente deseja deletar o dominio %s?';
$lng['question']['email_reallydelete'] = 'Voce realmente deseja deletar o e-mail %s?';
$lng['question']['email_reallydelete_account'] = 'Voce realmente deseja deletar a conta de e-mail %s?';
$lng['question']['email_reallydelete_forwarder'] = 'Voce realmente deseja deletar o redirecionamento %s?';
$lng['question']['extras_reallydelete'] = 'Voce realmente deseja deletar a prote&ccedil;&atilde;o do diret&oacute;rio %s?';
$lng['question']['extras_reallydelete_pathoptions'] = 'Voce realmente deseja deletar o caminho %s?';
$lng['question']['ftp_reallydelete'] = 'Voce realmente deseja deletar a conta de FTP %s?';
$lng['question']['mysql_reallydelete'] = 'Voce realmente deseja deletar o banco de dados %s? Este comando n&atilde;o poder&aacute; ser cancelado!';
$lng['question']['admin_configs_reallyrebuild'] = 'Est&aacute; certo que quer deixar reconfigurar os ficheiros de configura&ccedil;&atilde;o de Apache e Bind?';

/**
 * Mails
 */

$lng['mails']['pop_success']['mailbody'] = 'Ol&aacute;,\n\n sua conta de e-mail {EMAIL}\n foi criada com sucesso.\n\nEsta &eacute; uma mensagem autom&aacute;tica\neMail, por favor n&atilde;o responda!\n\nAtenciosamente, Equipe de desenvolvimento do Froxlor';
$lng['mails']['pop_success']['subject'] = 'Conta de e-mail criada com sucesso!';
$lng['mails']['createcustomer']['mailbody'] = 'Ol&aacute; {FIRSTNAME} {NAME},\n\nseguem os detalhes de sua nova conta de e-mail:\n\nUsuario: {USERNAME}\nSenha: {PASSWORD}\n\nObrigado,\nEquipe de desenvolvimento do Froxlor';
$lng['mails']['createcustomer']['subject'] = 'Informa&ccedil;&otilde;es da conta';

/**
 * Admin
 */

$lng['admin']['overview'] = 'Vis&atilde;o geral';
$lng['admin']['ressourcedetails'] = 'Recursos usados';
$lng['admin']['systemdetails'] = 'Detalhes do sistema';
$lng['admin']['froxlordetails'] = 'Detalhes do Froxlor';
$lng['admin']['installedversion'] = 'Vers&atilde;o instalada';
$lng['admin']['latestversion'] = 'Ultima Vers&atilde;o';
$lng['admin']['lookfornewversion']['clickhere'] = 'procurar pela internet';
$lng['admin']['lookfornewversion']['error'] = 'Erro de leitura';
$lng['admin']['resources'] = 'Recursos';
$lng['admin']['customer'] = 'Cliente';
$lng['admin']['customers'] = 'Clientes';
$lng['admin']['customer_add'] = 'Criar cliente';
$lng['admin']['customer_edit'] = 'Editar cliente';
$lng['admin']['domains'] = 'Dominios';
$lng['admin']['domain_add'] = 'Criar dominio';
$lng['admin']['domain_edit'] = 'Editar dominio';
$lng['admin']['subdomainforemail'] = 'Subdominio como &quot;emaildomains&quot;';
$lng['admin']['admin'] = 'Administrador';
$lng['admin']['admins'] = 'Administradores';
$lng['admin']['admin_add'] = 'Criar administrador';
$lng['admin']['admin_edit'] = 'Editar administrador';
$lng['admin']['customers_see_all'] = 'Mostrar todos os clientes';
$lng['admin']['domains_see_all'] = 'Mostrar todos os dominios';
$lng['admin']['change_serversettings'] = 'Alterar configura&ccedil;&ccedil;es do servidor?';
$lng['admin']['server'] = 'Servidor';
$lng['admin']['serversettings'] = 'Configura&ccedil;&ccedil;es';
$lng['admin']['rebuildconf'] = 'Escrever de novo os configs';
$lng['admin']['stdsubdomain'] = 'Subdominio padr&atilde;o';
$lng['admin']['stdsubdomain_add'] = 'Criar Subdominio padr&atilde;o';
$lng['admin']['deactivated'] = 'Desativado';
$lng['admin']['deactivated_user'] = 'Desativar usu&aacute;rio';
$lng['admin']['sendpassword'] = 'Enviar senha';
$lng['admin']['ownvhostsettings'] = 'Own vHost-Settings';
$lng['admin']['configfiles']['serverconfiguration'] = 'Configura&ccedil;&otilde;es';
$lng['admin']['configfiles']['files'] = '<b>Configfiles:</b> Por favor altere os seguintes arquivos ou crie eles com<br />o seguinte conte&uacute;do se ele n&atilde;o existir.<br /><b>Por favor observe:</b> A senha do MySQL n„o foi alterada por raz&otilde;es de seguran&ccedil;a.<br />Por favor substitua &quot;MYSQL_PASSWORD&quot; por uma sua. Se voce esqueceu a senha do MySQL<br />voce pode verificar em &quot;lib/userdata.inc.php&quot;.';
$lng['admin']['configfiles']['commands'] = '<b>Commands:</b> Por favor execute as seguintes comandos no shell.';
$lng['admin']['configfiles']['restart'] = '<b>Restart:</b> Por favor execute as seguintes comandos no shell para carregar aas novas configura&ccedil;&otilde;es.';
$lng['admin']['templates']['templates'] = 'Templates';
$lng['admin']['templates']['template_add'] = 'Adicionar template';
$lng['admin']['templates']['template_edit'] = 'Editar template';
$lng['admin']['templates']['action'] = 'A&ccedil;&atilde;o';
$lng['admin']['templates']['email'] = 'E-Mail';
$lng['admin']['templates']['subject'] = 'Assunto';
$lng['admin']['templates']['mailbody'] = 'Mensagem';
$lng['admin']['templates']['createcustomer'] = 'E-mail de boas-vindas para novos clientes';
$lng['admin']['templates']['pop_success'] = 'E-mail de boas-vindas para nova conta de e-mail';
$lng['admin']['templates']['template_replace_vars'] = 'Variaveis para serem substituidas no template:';
$lng['admin']['templates']['FIRSTNAME'] = 'Altere para o primeiro nome do cliente.';
$lng['admin']['templates']['NAME'] = 'Altere para o nome do cliente.';
$lng['admin']['templates']['USERNAME'] = 'Altere para nome da conta do cliente.';
$lng['admin']['templates']['PASSWORD'] = 'Altere com a senha da conta do cliente.';
$lng['admin']['templates']['EMAIL'] = 'Altere com os dados do servidor POP3/IMAP.';

/**
 * Serversettings
 */

$lng['serversettings']['session_timeout']['title'] = 'Tempo esgotado';
$lng['serversettings']['session_timeout']['description'] = 'Quanto tempo o usuario deve estar inativo para ser desconectado (segundos)?';
$lng['serversettings']['accountprefix']['title'] = 'Prefixo do cliente';
$lng['serversettings']['accountprefix']['description'] = 'Qual o prefixo &quot;customeraccounts&quot; deve ter?';
$lng['serversettings']['mysqlprefix']['title'] = 'SQL Prefixo';
$lng['serversettings']['mysqlprefix']['description'] = 'Qual prefixo as contas mysql devem ter?';
$lng['serversettings']['ftpprefix']['title'] = 'FTP Prefixo';
$lng['serversettings']['ftpprefix']['description'] = 'Qual prefixo as contas de FTP devem ter?';
$lng['serversettings']['documentroot_prefix']['title'] = 'Diret&oacute;rio de documenta&ccedil;&atilde;o';
$lng['serversettings']['documentroot_prefix']['description'] = 'Aonde os documentos dever ser gravados?';
$lng['serversettings']['logfiles_directory']['title'] = 'Diret&oacute;rio de LOG';
$lng['serversettings']['logfiles_directory']['description'] = 'Aonde os arquivos de log dever ser gravados?';
$lng['serversettings']['ipaddress']['title'] = 'Endere&ccedil;os de IP';
$lng['serversettings']['ipaddress']['description'] = 'Quais os Endere&ccedil;os IP deste servidor?';
$lng['serversettings']['hostname']['title'] = 'Hostname';
$lng['serversettings']['hostname']['description'] = 'Qual o Hostname deste servidor?';
$lng['serversettings']['apachereload_command']['title'] = 'Comando de reiniciar o Apache';
$lng['serversettings']['apachereload_command']['description'] = 'Qual o comando para reiniciar o apache?';
$lng['serversettings']['bindconf_directory']['title'] = 'Diret&oacute;rio de configura&ccedil;&atilde;o do Bind';
$lng['serversettings']['bindconf_directory']['description'] = 'Aonde est&atilde;o os arquivos de configura&ccedil;&atilde;o do bind?';
$lng['serversettings']['bindreload_command']['title'] = 'Comando de reiniciar o Bind';
$lng['serversettings']['bindreload_command']['description'] = 'Qual o comando para reiniciar o bind?';
$lng['serversettings']['binddefaultzone']['title'] = 'Bind default zone';
$lng['serversettings']['binddefaultzone']['description'] = 'Qual o nome da default zone?';
$lng['serversettings']['vmail_uid']['title'] = 'Mails-Uid';
$lng['serversettings']['vmail_uid']['description'] = 'Qual UserID os e-mails devem ter?';
$lng['serversettings']['vmail_gid']['title'] = 'Mails-Gid';
$lng['serversettings']['vmail_gid']['description'] = 'Qual GroupID os e-mails devem ter?';
$lng['serversettings']['vmail_homedir']['title'] = 'Mails-Homedir';
$lng['serversettings']['vmail_homedir']['description'] = 'Aonde os e-mails devem ser gravados?';
$lng['serversettings']['adminmail']['title'] = 'Remetente';
$lng['serversettings']['adminmail']['description'] = 'Qual o remetente dos e-mails enviados pelo painel?';
$lng['serversettings']['phpmyadmin_url']['title'] = 'phpMyAdmin URL';
$lng['serversettings']['phpmyadmin_url']['description'] = 'Qual a URL do phpMyAdmin? (deve iniciar com http://)';
$lng['serversettings']['webmail_url']['title'] = 'WebMail URL';
$lng['serversettings']['webmail_url']['description'] = 'Qual a URL do WebMail? (deve iniciar com http://)';
$lng['serversettings']['webftp_url']['title'] = 'WebFTP URL';
$lng['serversettings']['webftp_url']['description'] = 'Qual a URL do WebFTP? (deve iniciar com http://)';
$lng['serversettings']['language']['description'] = 'Qual o idioma padr&atilde;o do servidor?';
$lng['serversettings']['maxloginattempts']['title'] = 'Tentativas maximas de Login';
$lng['serversettings']['maxloginattempts']['description'] = 'Tentativas maximas de Login para a conta ser desativada.';
$lng['serversettings']['deactivatetime']['title'] = 'Tempo que a conta deve permanecer desativada';
$lng['serversettings']['deactivatetime']['description'] = 'Tempo (sec.) qua a conta permanece desativada depois de muitas tentativas de login.';
$lng['serversettings']['pathedit']['title'] = 'File-M&eacute;todo de entrada';
$lng['serversettings']['pathedit']['description'] = 'A escolha do file tem que ser feita atrav&eacute;s do Dropdown-Menu ou pode ser feita manualmente?';

/**
 * ADDED BETWEEN 1.2.12 and 1.2.13
 */

$lng['serversettings']['paging']['title'] = 'Entradas por pagina';
$lng['serversettings']['paging']['description'] = 'Quantas entradas devem ser mostradas por pagina? (0 = desabilitar paginas)';
$lng['error']['ipstillhasdomains'] = 'O IP/Porta que voce quer deletar ainda possui dominios associados e eles, por favor altere o IP/Porta destes dominios antes de delet&aacute;-los.';
$lng['error']['cantdeletedefaultip'] = 'Voce n&atilde;o pode deletar o IP/Porta padr&atilde;o do revendedor, por favor defina outro IP/Porta como padr&atilde;o antes deletar o IP/Porta desejado';
$lng['error']['cantdeletesystemip'] = 'Voce n&atilde;o pode deletar o IP do sistema, nem criar uma nova combina&ccedil;&atilde;o IP/Porta para o sistema ou trocar o IP do sistema.';
$lng['error']['myipaddress'] = '\'IP\'';
$lng['error']['myport'] = '\'Porta\'';
$lng['error']['myipdefault'] = 'Voce precisa selecionar o IP/Porta que ser&aacute; padr&atilde;o.';
$lng['error']['myipnotdouble'] = 'Esta combina&ccedil;&atilde;o  IP/Porta j&aacute; existe.';
$lng['question']['admin_ip_reallydelete'] = 'Voce realmente deseja deletar este endere&ccedil;o IP?';
$lng['admin']['ipsandports']['ipsandports'] = 'IPs e Portas';
$lng['admin']['ipsandports']['add'] = 'Adicionar IP/Porta';
$lng['admin']['ipsandports']['edit'] = 'Editar IP/Porta';
$lng['admin']['ipsandports']['ipandport'] = 'IP/Porta';
$lng['admin']['ipsandports']['ip'] = 'IP';
$lng['admin']['ipsandports']['port'] = 'Porta';
$lng['error']['cantchangesystemip'] = 'Voc&ecirc; n&atilde;o pode mudar o &uacute;ltimo sistema IP, para criar uma outra combina&ccedil;&atilde;o nova de IP/Port para o sistema IP ou para mudar o sistema IP';
$lng['question']['admin_domain_reallydocrootoutofcustomerroot'] = '&Eacute; voc&ecirc; certo, voc&ecirc; quer a raiz do original para este dom&iacute;nio, n&atilde;o estando dentro do customerroot do cliente?';
$lng['error']['loginnameissystemaccount'] = 'Voc&ecirc; n&atilde;o pode criar os clientes que s&atilde;o similares aos systemaccounts. Incorpore por favor um outro accountname.';
$lng['domain']['docroot'] = 'trajeto da linha acima de';
$lng['domain']['homedir'] = 'diret&oacute;rio da casa';
$lng['admin']['valuemandatory'] = 'Este valor &eacute; imperativo.';
$lng['admin']['valuemandatorycompany'] = 'Qualquer um &quot;nome&quot; e &quot;nome&quot; o &quot;companhia&quot; deve ser enchido.';
$lng['admin']['phpenabled'] = 'PHP Habilitado';
$lng['admin']['webserver'] = 'Servidor Web';
$lng['serversettings']['nameservers']['title'] = 'Servidores DNS';
$lng['serversettings']['mxservers']['title'] = 'Servidores de Email';
$lng['serversettings']['mxservers']['description'] = 'Uma lista separada por v&iacute;rgulas que cont&eacute;m o numero de prioridade e o hostname separados por um espa&ccedil;o (por exemplo: \'mx.example.com 10 \'), contendo os servidores mx.';
$lng['error']['admin_domain_emailsystemhostname'] = 'Desculpe. Voc&ecirc; n&atilde;o pode usar o hostname do servidor como dom&iacute;nio de email';
$lng['admin']['memorylimitdisabled'] = 'Desabilitado';
$lng['domain']['openbasedirpath'] = 'Caminho do OpenBaseDir';
$lng['menue']['main']['username'] = 'Logado como';
$lng['panel']['urloverridespath'] = 'URL (Caminho Completo)';
$lng['panel']['pathorurl'] = 'Caminho ou URL';
$lng['error']['sessiontimeoutiswrong'] = 'Apenas numeros &quot;Timeout da sess&atilde;o&quot; permitido.';
$lng['error']['maxloginattemptsiswrong'] = 'Apenas numero &quot;Tentativa maxima de Login&quot; permitido.';
$lng['error']['deactivatetimiswrong'] = 'Apenas numero &quot;Desativar Tempo&quot; permitido.';
$lng['error']['accountprefixiswrong'] = 'O &quot;Prefixo&quot; est&aacute; errado.';
$lng['error']['mysqlprefixiswrong'] = 'O &quot;Prefixo SQL&quot; est&aacute; errado.';
$lng['error']['ftpprefixiswrong'] = 'O &quot;Prefixo FTP&quot; est&aacute; errado.';
$lng['error']['ipiswrong'] = 'O &quot;Endere&ccedil;o-IP&quot; est&aacute; errado. Apenas um Endere&ccedil;o-IP v&aacute;lido &eacute; permitido.';
$lng['error']['vmailuidiswrong'] = 'O &quot;UID do E-mail&quot; Est&aacute; errado. S&oacute; &eacute; permitido um n&uacute;mero de ID.';
$lng['error']['vmailgidiswrong'] = 'O &quot;GID do E-mail&quot; Est&aacute; errado. S&oacute; &eacute; permitido um n&uacute;mero de ID.';
$lng['error']['adminmailiswrong'] = 'O &quot;Endere&ccedil;o de Envio&quot; est&aacute; errado. Apenas um endere&ccedil;o de e-mail v&aacute;lido &eacute; permitido.';
$lng['error']['pagingiswrong'] = 'O &quot;Entradas por p&aacute;ginas&quot;-value est&aacute; errado. Somente caracteres n&uacute;mericos s&atilde;o permitidos.';
$lng['error']['phpmyadminiswrong'] = 'O caminho para o phpMyAmin n&atilde;o &eacute; v&aacute;lido';
$lng['error']['webmailiswrong'] = 'O caminho para o Webmail n&atilde;o &eacute; v&aacute;lido';
$lng['error']['webftpiswrong'] = 'O caminho para o WebFTP n&atilde;o &eacute; v&aacute;lido';
$lng['domains']['hasaliasdomains'] = 'Possui alinhas de dom&iacute;nio(s)';
$lng['serversettings']['defaultip']['title'] = 'IP/Porta Padr&atilde;o';
$lng['serversettings']['defaultip']['description'] = 'Qual &eacute; a IP/Porta Padr&atilde;o?';
$lng['domains']['statstics'] = 'Estat&iacute;sticas de Uso';
$lng['panel']['ascending'] = 'Crescente';
$lng['panel']['decending'] = 'Decrescente';
$lng['panel']['search'] = 'Procurar';
$lng['panel']['used'] = 'Usado';
$lng['panel']['translator'] = 'Tradutor';
$lng['error']['stringformaterror'] = 'O valor par ao campo &quot;%s&quot; n&atilde;o esta no formato correto.';
$lng['admin']['serversoftware'] = 'Servidor de Software';
$lng['admin']['phpversion'] = 'Vers&atilde;o do PHP';
$lng['admin']['phpmemorylimit'] = 'Mem&oacute;ria Limite do PHP';
$lng['admin']['mysqlserverversion'] = 'Vers&atilde;o do MySQL Server';
$lng['admin']['mysqlclientversion'] = 'Vers&atilde;o do MySQL Client';
$lng['admin']['webserverinterface'] = 'Interface do Servidor Web';
$lng['domains']['isassigneddomain'] = '&Eacute; um dom&iacute;nio assinado';
$lng['serversettings']['phpappendopenbasedir']['title'] = 'Caminho para adicionar OpenBasedir';
$lng['serversettings']['phpappendopenbasedir']['description'] = 'Estes caminhos (separados por dois pontos) ser&atilde;o acrescentados ao OpenBasedir em cada vhost.';
$lng['error']['youcantdeleteyourself'] = 'Voc&ecirc; n&atilde;o pode apagar voc&ecirc; mesmo por motivos de seguran&ccedil;a';
$lng['error']['youcanteditallfieldsofyourself'] = 'Nota: Voc&ecirc; n&atilde;o pode editar todos os campos de sua pr&oacute;pria conta por motivos de seguran&ccedil;a';
$lng['serversettings']['natsorting']['title'] = 'Usar classifica&ccedil;&atilde;o natural na visualiza&ccedil;&atilde;o';
$lng['serversettings']['natsorting']['description'] = 'Ordenar listas como: web1 -> web2 -> web11 ao inv&eacute;z de web1 -> web11 -> web2.';
$lng['serversettings']['deactivateddocroot']['title'] = 'Docroots desativado para usu&aacute;rios';
$lng['serversettings']['deactivateddocroot']['description'] = 'Quando um usu&aacute;rio estiver desativado, esse caminho &eacute; usado como seu docroot. Deixe em branco para n&atilde;o criar um vhost a todos.';
$lng['panel']['reset'] = 'Descartar Mudan&ccedil;as';
$lng['admin']['accountsettings'] = 'Configura&ccedil;&otilde;es de Conta';
$lng['admin']['panelsettings'] = 'Painel de Controle';
$lng['admin']['systemsettings'] = 'Configura&ccedil;&otilde;es do Sistema';
$lng['admin']['webserversettings'] = 'Configura&ccedil;&otilde;es do WebServer';
$lng['admin']['mailserversettings'] = 'Configura&ccedil;&otilde;es do Servidor de Email';
$lng['admin']['nameserversettings'] = 'Configura&ccedil;&otilde;es dos Servidores de Nomes';
$lng['admin']['updatecounters'] = 'Recalcular utiliza&ccedil;&atilde;o de recursos';
$lng['question']['admin_counters_reallyupdate'] = 'Voce deseja recalcular os recursos utilizados?';
$lng['panel']['pathDescription'] = 'Se o diret&oacute;rio n&atilde;o existir, ser&aacute; criado automaticamente';
$lng['mails']['trafficninetypercent']['mailbody'] = 'Querido {NAME},\n\nVoc&ecirc; usou {TRAFFICUSED} MB do seu dispon&iacute;vel {TRAFFIC} MB de tr&aacute;fego.\nisto &eacute; mais que 90%.\n\nHonestamente, Equipe Froxlor';
$lng['mails']['trafficninetypercent']['subject'] = 'Atingindo o seu limite de tr&aacute;fego';
$lng['admin']['templates']['trafficninetypercent'] = 'Email de notifica&ccedil;&atilde;o para clientes quando atingirem 90% do uso do tr&aacute;fego';
$lng['admin']['templates']['TRAFFIC'] = 'Substitu&iacute;do com o tr&aacute;fego, o que foi atribu&iacute;do ao cliente.';
$lng['admin']['templates']['TRAFFICUSED'] = 'Substitu&iacute;do com o tr&aacute;fego, que foi esgotado pela cliente.';
$lng['admin']['subcanemaildomain']['never'] = 'Nunca';
$lng['admin']['subcanemaildomain']['choosableno'] = 'Escolhe, default n&atilde;o';
$lng['admin']['subcanemaildomain']['choosableyes'] = 'Escolher, default sim';
$lng['admin']['subcanemaildomain']['always'] = 'Sempre';
$lng['changepassword']['also_change_webalizer'] = 'Troca a senha das estat&iacute;sticas do webalizer';
$lng['serversettings']['mailpwcleartext']['title'] = 'Salva as senhas de usu&aacute;rios sempre criptografia no banco de dados';
$lng['serversettings']['mailpwcleartext']['description'] = 'Se voc&ecirc; selecionar sim, todas as senhas ser&atilde;o guardadas descriptografadas (Poder&aacute; ser lido por todos com acesso ao banco de dados ) na tabela mail_users-table. Somente ative essa op&ccedil;&atilde;o se voc&ecirc; realmente precise!';
$lng['serversettings']['mailpwcleartext']['removelink'] = 'Clique aqui para limpar todas as senhas n&atilde;o criptografadas da tabela<br />Voc&ecirc; realmente deseja limpar todas as senhas n&atilde;o encriptadas a partir da tabela mail_users? Isto n&atilde;o pode ser revertido!';
$lng['admin']['configfiles']['overview'] = 'Vis&atilde;o Geral';
$lng['admin']['configfiles']['wizard'] = 'Assistente';
$lng['admin']['configfiles']['distribution'] = 'Distribui&ccedil;&atilde;o';
$lng['admin']['configfiles']['service'] = 'Servi&ccedil;o';
$lng['admin']['configfiles']['daemon'] = 'Daemon';
$lng['admin']['configfiles']['http'] = 'Servidor Web (HTTP)';
$lng['admin']['configfiles']['dns'] = 'Servidor de Nomes (DNS)';
$lng['admin']['configfiles']['mail'] = 'Servidor de Emails (POP3/IMAP)';
$lng['admin']['configfiles']['smtp'] = 'Servidor de Emails (SMTP)';
$lng['admin']['configfiles']['ftp'] = 'Servidor FTP';
$lng['admin']['configfiles']['etc'] = 'Outros (Sistema)';
$lng['admin']['configfiles']['choosedistribution'] = 'Escolha uma distribui&ccedil;&atilde;o';
$lng['admin']['configfiles']['chooseservice'] = 'Escolha um servi&ccedil;o';
$lng['admin']['configfiles']['choosedaemon'] = 'Escolha um daemon';
$lng['serversettings']['ftpdomain']['title'] = 'Contas FTP @dom&iacute;nio';
$lng['serversettings']['ftpdomain']['description'] = 'Clientes podem criar contas de FTP user@dom&iacute;niodocliente?';
$lng['panel']['back'] = 'Volta';
$lng['serversettings']['mod_log_sql']['title'] = 'Temporariamente salva os logs no banco de dados';
$lng['serversettings']['mod_fcgid']['title'] = 'Incluir PHP via mod_fcgid/suexec';
$lng['serversettings']['mod_fcgid']['description'] = 'Use mod_fcgid/suexec/libnss_mysql to run PHP with the corresponding useraccount.<br/><b>This needs a special Apache configuration. All following options are only valid if the module is enabled.</b>';
$lng['serversettings']['sendalternativemail']['title'] = 'Utilize endere&ccedil;o de e-mail alternativo';
$lng['serversettings']['sendalternativemail']['description'] = 'Enviar e-mail a senha para um endere&ccedil;o diferente durante uma cria&ccedil;&atilde;o de conta de e-mail';
$lng['emails']['alternative_emailaddress'] = 'Endere&ccedil;o de E-mail alternativo';
$lng['mails']['pop_success_alternative']['mailbody'] = 'Oi,\n\nSua conta de email {EMAIL}\nfoi configurada corretamente.\nSua senha &eacute;{PASSWORD}.\n\nEmail criado automaticamente\n, Por favor n&atilde;o responda!\n\nCumprimentos, Equipe Froxlor.';
$lng['mails']['pop_success_alternative']['subject'] = 'Conta de email criada com sucesso';
$lng['admin']['templates']['pop_success_alternative'] = 'Bem-vindo para novas contas e-mail enviado ao endere&ccedil;o alternativo';
$lng['admin']['templates']['EMAIL_PASSWORD'] = 'Substitu&iacute;do a senha da conta POP3/IMAP.';
$lng['error']['documentrootexists'] = 'O Diret&oacute;rio &quot;%s&quot; j&aacute; existe para este usuario. Por favor remova-o e depois tente novamente.';
$lng['serversettings']['apacheconf_vhost']['title'] = 'Arquivo/Diret&oacute;rio de configura&ccedil;&otilde;es do Apache Vhost';
$lng['serversettings']['apacheconf_vhost']['description'] = 'Onde as configura&ccedil;&atilde;o de Vhost devem ser guardadas? Voc&ecirc; pode especificar um arquivo (todos os vhosts em um arquivo) ou diret&oacute;rio (cada vhost com seu pr&oacute;prio arquivo) aqui.';
$lng['serversettings']['apacheconf_diroptions']['title'] = 'Configura&ccedil;&atilde;o de diret&oacute;rio do Apache Arquivo/Nome do Diret&oacute;rio.';
$lng['serversettings']['apacheconf_diroptions']['description'] = 'Quando as op&ccedil;&otilde;es de configura&ccedil;&atilde;o de diret&oacute;rio deve ser armazenada? Voc&ecirc; poderia especificar um arquivo (todas as op&ccedil;&otilde;es em um arquivo) ou diret&oacute;rio ( cada op&ccedil;&atilde;o no seu pr&oacute;prio arquivo).';
$lng['serversettings']['apacheconf_htpasswddir']['title'] = 'Apache htpasswd dirname';
$lng['serversettings']['apacheconf_htpasswddir']['description'] = 'Onde deve ser o diret&oacute;rio de arquivos htpasswd?';
$lng['error']['formtokencompromised'] = 'O Pedido parece estar correto. Por motivos de seguran&ccedil;a voc&ecirc; est&aacute; desconectado.';
$lng['serversettings']['mysql_access_host']['title'] = 'Hosts de Acesso MySQL';
$lng['serversettings']['mysql_access_host']['description'] = 'Uma lista separada por v&iacute;rgulas de hosts a partir do qual os utilizadores devem ter a possibilidade de conectar-se ao MySQL-Server.';
$lng['admin']['ipsandports']['create_listen_statement'] = 'Criar instru&ccedil;&atilde;o de escuta';
$lng['admin']['ipsandports']['create_namevirtualhost_statement'] = 'Criar instru&ccedil;&atilde;o de NameVirtualHost';
$lng['admin']['ipsandports']['create_vhostcontainer'] = 'Criar vHost-Container';
$lng['admin']['ipsandports']['create_vhostcontainer_servername_statement'] = 'Criar instru&ccedil;&atilde;o de ServerName  no vHost-Container';
$lng['admin']['webalizersettings'] = 'Configura&ccedil;&otilde;es do Webalizer';
$lng['admin']['webalizer']['normal'] = 'Normal';
$lng['admin']['webalizer']['quiet'] = 'Quieto';
$lng['admin']['webalizer']['veryquiet'] = 'Sem Sa&iacute;da';
$lng['serversettings']['webalizer_quiet']['title'] = 'Saida do Webalizer';
$lng['serversettings']['webalizer_quiet']['description'] = 'Modo verbose do webalizer';
$lng['ticket']['admin_email'] = 'root@localhost';
$lng['ticket']['noreply_email'] = 'tickets@froxlor';
$lng['admin']['ticketsystem'] = 'Tickets de Suporte';
$lng['menue']['ticket']['ticket'] = 'Tickets';
$lng['menue']['ticket']['categories'] = 'Cotegorias de Suporte';
$lng['menue']['ticket']['archive'] = 'Arquivo de Tickets';
$lng['ticket']['description'] = 'Aqui voc&ecirc; pode fazer perguntas ao administrador respons&aacute;vel';
$lng['ticket']['ticket_new'] = 'Abrir um novo ticket';
$lng['ticket']['ticket_reply'] = 'Responder um ticket';
$lng['ticket']['ticket_reopen'] = 'Re-abrir um ticket';
$lng['ticket']['ticket_newcateory'] = 'Recriar uma categoria';
$lng['ticket']['ticket_editcateory'] = 'Editar uma categoria';
$lng['ticket']['ticket_view'] = 'Ver Ticket';
$lng['ticket']['ticketcount'] = 'Tickets';
$lng['ticket']['ticket_answers'] = 'Respostas';
$lng['ticket']['lastchange'] = '&Uacute;ltima troca';
$lng['ticket']['subject'] = 'Assunto';
$lng['ticket']['status'] = 'Status';
$lng['ticket']['lastreplier'] = '&Uacute;ltimo que respondeu';
$lng['ticket']['priority'] = 'Prioridade';
$lng['ticket']['low'] = '<span class="ticket_low">Baixa</span>';
$lng['ticket']['normal'] = '<span class="ticket_normal">Normal</span>';
$lng['ticket']['high'] = '<span class="ticket_high">Alta</span>';
$lng['ticket']['unf_low'] = 'Baixa';
$lng['ticket']['unf_normal'] = 'Normal';
$lng['ticket']['unf_high'] = 'Alta';
$lng['ticket']['lastchange_from'] = 'De data (dd.mm.aaaa)';
$lng['ticket']['lastchange_to'] = 'At&eacute; data (dd.mm.aaaa)';
$lng['ticket']['category'] = 'Categoria';
$lng['ticket']['no_cat'] = 'Nenhuma';
$lng['ticket']['message'] = 'Mensagem';
$lng['ticket']['show'] = 'Visualizar';
$lng['ticket']['answer'] = 'Responder um ticket';
$lng['ticket']['close'] = 'Fechar';
$lng['ticket']['reopen'] = 'Re-abrir';
$lng['ticket']['archive'] = 'Arquivo';
$lng['ticket']['ticket_delete'] = 'Deletar Ticket';
$lng['ticket']['lastarchived'] = 'Tickets rec&eacute;m arquivados';
$lng['ticket']['archivedtime'] = 'Arquivado';
$lng['ticket']['open'] = 'Aberto';
$lng['ticket']['wait_reply'] = 'Esperando resposta';
$lng['ticket']['replied'] = 'Respondido';
$lng['ticket']['closed'] = 'Fechado';
$lng['ticket']['staff'] = 'Equipe';
$lng['ticket']['customer'] = 'Cliente';
$lng['ticket']['old_tickets'] = 'Ticket de mensagens';
$lng['ticket']['search'] = 'Procurar arquivo';
$lng['ticket']['nocustomer'] = 'Sem escolha';
$lng['ticket']['archivesearch'] = 'Arquivar resultados de busca';
$lng['ticket']['noresults'] = 'Nenhum ticket encontrado';
$lng['ticket']['notmorethanxopentickets'] = 'Devido a prote&ccedil;&atilde;o anti-spam n&atilde;o se pode ter mais de %s bilhetes abertos';
$lng['ticket']['supportstatus'] = 'Status de Suporte';
$lng['ticket']['supportavailable'] = '<span class="ticket_low">Nossos engenheiros de suporte est&atilde;o dispon&iacute;veis e prontos a ajudar.</span>';
$lng['ticket']['supportnotavailable'] = '<span class="ticket_high">Nossos engenheiros de suporte n&atilde;o est&atilde;o actualmente dispon&iacute;veis</span>';
$lng['admin']['templates']['ticket'] = 'Emails de notifica&ccedil;&atilde;o para tickets de suporte';
$lng['admin']['templates']['SUBJECT'] = 'Substitu&iacute;do por um assunto de ticket de suporte';
$lng['admin']['templates']['new_ticket_for_customer'] = 'Informa&ccedil;&atilde;o do Cliente de que de que o Ticket foi gerado.';
$lng['admin']['templates']['new_ticket_by_customer'] = 'Notifica&ccedil;&atilde;o do Admin para um ticket aberto por um cliente';
$lng['admin']['templates']['new_reply_ticket_by_customer'] = 'Notifica&ccedil;&atilde;o do Admin para um ticket respondido por um cliente';
$lng['admin']['templates']['new_ticket_by_staff'] = 'Notifica&ccedil;&atilde;o de cliente para um ticket aberto pela administra&ccedil;&atilde;o';
$lng['admin']['templates']['new_reply_ticket_by_staff'] = 'Notifica&ccedil;&atilde;o do cliente para um ticket respondido pela administra&ccedil;&atilde;o';
$lng['mails']['new_ticket_for_customer']['subject'] = 'Seu ticket de Suporte foi Enviado';
$lng['mails']['new_ticket_by_customer']['subject'] = 'Novo pedido de Suporte';
$lng['mails']['new_reply_ticket_by_customer']['mailbody'] = 'Oi admin,\n\no ticket de suporte "{SUBJECT}" foi respondido para o cliente.\n\nPor favor logue para abrir o ticket.\n\Obrigado,\nequipe Froxlor';
$lng['mails']['new_reply_ticket_by_customer']['subject'] = 'Nova resposta para um ticket de supote';
$lng['mails']['new_ticket_by_staff']['subject'] = 'Novo ticket enviado';
$lng['mails']['new_reply_ticket_by_staff']['mailbody'] = 'Oi {FIRSTNAME} {NAME},\n\o ticket de suporte com o assunto "{SUBJECT}" foi respondido pelos seus administradores.\n\nPor favor logue para abrir esse ticket.\n\nObrigado,\nequipe Froxlor';
$lng['mails']['new_reply_ticket_by_staff']['subject'] = 'Nova resposta para um ticket de supote';
$lng['question']['ticket_reallyclose'] = 'Voc&ecirc; deseja fechar o ticket"%s"?';
$lng['question']['ticket_reallydelete'] = 'Voc&ecirc; deseja apagar o ticket"%s"?';
$lng['question']['ticket_reallydeletecat'] = 'Voc&ecirc; deseja deletar a categoria "%s"?';
$lng['question']['ticket_reallyarchive'] = 'Voc&ecirc; deseja mover o ticket "%s" para o arquivo?';
$lng['error']['mysubject'] = '\'' . $lng['ticket']['subject'] . '\'';
$lng['error']['mymessage'] = '\'' . $lng['ticket']['message'] . '\'';
$lng['error']['mycategory'] = '\'' . $lng['ticket']['category'] . '\'';
$lng['error']['nomoreticketsavailable'] = 'Voc&ecirc; j&aacute; utilizou todos seus tickets dispon&iacute;veis. Por favor contacte seu administrador';
$lng['error']['nocustomerforticket'] = 'N&atilde;o pode criar Tickets sem Clientes';
$lng['error']['categoryhastickets'] = 'A categoria ainda tem tikets na mesma. <br /> Por favor elimine os bilhetes para eliminar a categoria';
$lng['error']['notmorethanxopentickets'] = $lng['ticket']['notmorethanxopentickets'];
$lng['admin']['ticketsettings'] = 'Configura&ccedil;&otilde;es de Ticket de Suporte';
$lng['admin']['archivelastrun'] = '&Uacute;ltimo arquivamento de ticket';
$lng['serversettings']['ticket']['noreply_email']['title'] = 'N&atilde;o responder endere&ccedil;o de email';
$lng['serversettings']['ticket']['noreply_email']['description'] = 'O endere&ccedil;o de envio para tickets de suporte, normalmente &eacute; no-reply@domain.com';
$lng['serversettings']['ticket']['worktime_begin']['title'] = 'Iniciado tempo de suporte (hh:mm)';
$lng['serversettings']['ticket']['worktime_begin']['description'] = 'In&iacute;cio quando o suporte estiver dispon&iacute;vel';
$lng['serversettings']['ticket']['worktime_end']['title'] = 'Fim do tempo de suporte (hh:mm)';
$lng['serversettings']['ticket']['worktime_end']['description'] = 'Fim do tempo quando o suporte estiver dispon&iacute;vel';
$lng['serversettings']['ticket']['worktime_sat'] = 'Suporte dispon&iacute;vel nos s&aacute;bados?';
$lng['serversettings']['ticket']['worktime_sun'] = 'Suporte dispon&iacute;vel nos domingos?';
$lng['serversettings']['ticket']['worktime_all']['title'] = 'Sem tempo limite para suporte';
$lng['serversettings']['ticket']['worktime_all']['description'] = 'Se "Sim" para op&ccedil;&atilde;o para iniciar e finalizar vai ser substitu&iacute;da';
$lng['serversettings']['ticket']['archiving_days'] = 'Depois de quantoas dias tickets fechado s&atilde;o arquivados?';
$lng['customer']['tickets'] = 'Tickets de Suporte';
$lng['admin']['domain_nocustomeraddingavailable'] = 'N&atilde;o adicionar um dom&iacute;nio corretamente. Voc&ecirc; primeiro precisa adicionar um cliente.';
$lng['serversettings']['ticket']['enable'] = 'Ativar tickets de sistema';
$lng['serversettings']['ticket']['concurrentlyopen'] = 'Quantos tickes poderam ser abertos ao mesmo tempo?';
$lng['error']['norepymailiswrong'] = 'O &quot;Endere&ccedil;o (Noreply)&quot; est&aacute; errado. Somente um endere&ccedil;o v&aacute;lido &eacute; aceito.';
$lng['error']['tadminmailiswrong'] = 'O &quot;Endere&ccedil;o de admin &quot; est&aacute; errado. Somente um endere&ccedil;o v&aacute;lido &eacute; aceito.';
$lng['ticket']['awaitingticketreply'] = 'Voc&ecirc; tem %s tickes de suporte n&atilde;o respondido(s)';
$lng['serversettings']['ticket']['noreply_name'] = 'E-mail do remetente do Ticket';
$lng['serversettings']['mod_fcgid']['configdir']['title'] = 'Diret&oacute;rio de configura&ccedil;&atilde;o';
$lng['serversettings']['mod_fcgid']['configdir']['description'] = 'Aonde todos os arquivos de configura&ccedil;&atilde;o do fcgid v&atilde;o ser guardados? Se voc&ecirc; n&atilde;o utiliza um bin&aacute;rio compilado, est&aacute; &eacute; uma situa&ccedil;&atilde;o normal, deve estar dentro de /var/www/';
$lng['serversettings']['mod_fcgid']['tmpdir']['title'] = 'Diret&oacute;rio Tempor&aacute;rio';
$lng['serversettings']['ticket']['reset_cycle']['title'] = 'Resetar ciclo de tickers usados';
$lng['serversettings']['ticket']['reset_cycle']['description'] = 'Resetar tickets usados por clientes';
$lng['admin']['tickets']['daily'] = 'Diariamente';
$lng['admin']['tickets']['weekly'] = 'Semanalmente';
$lng['admin']['tickets']['monthly'] = 'Mensalmente';
$lng['admin']['tickets']['yearly'] = 'Anualmente';
$lng['error']['ticketresetcycleiswrong'] = 'O ciclo de resetes de ticket pode ser "di&aacute;rio", "semanal", "mensal" or "anual".';
$lng['menue']['traffic']['traffic'] = 'Tr&aacute;fego';
$lng['menue']['traffic']['current'] = 'M&ecirc;s corrente';
$lng['traffic']['month'] = "M&ecirc;s";
$lng['traffic']['day'] = "Diariamente";
$lng['traffic']['months'][1] = "Janeiro";
$lng['traffic']['months'][2] = "Fevereiro";
$lng['traffic']['months'][3] = "Mar&ccedil;o";
$lng['traffic']['months'][4] = "Abril";
$lng['traffic']['months'][5] = "Maio";
$lng['traffic']['months'][6] = "Junho";
$lng['traffic']['months'][7] = "Julho";
$lng['traffic']['months'][8] = "Agosto";
$lng['traffic']['months'][9] = "Setembro";
$lng['traffic']['months'][10] = "Outubro";
$lng['traffic']['months'][11] = "Novembro";
$lng['traffic']['months'][12] = "Dezembro";
$lng['traffic']['mb'] = "Tr&aacute;fego (MB)";
$lng['traffic']['distribution'] = '<font color="#019522">FTP</font> | <font color="#0000FF">HTTP</font> | <font color="#800000">E-Mail</font>';
$lng['traffic']['sumhttp'] = 'Resumo Tr&aacute;fego de HTTP em';
$lng['traffic']['sumftp'] = 'Resumo Tr&aacute;fego de FTP em';
$lng['traffic']['summail'] = 'Resumo Tr&aacute;fego de HTTP em';
$lng['serversettings']['no_robots']['title'] = 'Aceitar rob√¥s de procura na index de seuFroxlor';
$lng['admin']['loggersettings'] = 'Configura&ccedil;&otilde;es de Logs';
$lng['serversettings']['logger']['enable'] = 'Habilitar/Desabilitar Logs';
$lng['serversettings']['logger']['severity'] = 'N&iacute;vel de Logs';
$lng['admin']['logger']['normal'] = 'normal';
$lng['admin']['logger']['paranoid'] = 'paran&oacute;ico';
$lng['serversettings']['logger']['types']['title'] = 'Tipos de Log(s)';
$lng['serversettings']['logger']['types']['description'] = 'Especificar tipos de logs separados por v&iacute;rgula.<br />Tipos de l&oacute;gs dispon&iacute;veis: syslog, file, mysql';
$lng['serversettings']['logger']['logfile'] = 'Caminho do Arquivo de Log incluindo nome de arquivo';
$lng['error']['logerror'] = 'Log-Erro: %s';
$lng['serversettings']['logger']['logcron'] = 'Logar tarefas do cron';
$lng['question']['logger_reallytruncate'] = 'Voc&ecirc; realmente deseja dividir a tabela &quot;%s&quot;?';
$lng['admin']['loggersystem'] = 'Systema-Logging';
$lng['menue']['logger']['logger'] = 'Systema-Logging';
$lng['logger']['date'] = 'Data';
$lng['logger']['type'] = 'Tipo';
$lng['logger']['action'] = 'A&ccedil;&atilde;o';
$lng['logger']['user'] = 'Usu&aacute;rio';
$lng['logger']['truncate'] = 'Log Vazio';
$lng['serversettings']['ssl']['use_ssl'] = 'Usar SSL';
$lng['serversettings']['ssl']['ssl_cert_file'] = 'Aonde est&atilde;o localizados os certificados';
$lng['serversettings']['ssl']['openssl_cnf'] = 'Padr&atilde;o para criar o arquivo de certificado';
$lng['panel']['reseller'] = 'Revenda';
$lng['panel']['admin'] = 'Administrador';
$lng['panel']['customer'] = 'Cliente(s)';
$lng['error']['nomessagetosend'] = 'Voc&ecirc; n&atilde;o entrou com uma mensagem';
$lng['error']['noreceipientsgiven'] = 'Voc&ecirc; n&atilde;o especificou um destinat&aacute;rio';
$lng['admin']['emaildomain'] = 'Dom&iacute;nio de Email';
$lng['admin']['email_only'] = 'Somente Email?';
$lng['admin']['wwwserveralias'] = 'Adicionar um &quot;www.&quot; ServerAlias';
$lng['admin']['ipsandports']['enable_ssl'] = 'Esta &eacute; uma porta SSL?';
$lng['admin']['ipsandports']['ssl_cert_file'] = 'Caminho para o certificado SSL';
$lng['panel']['send'] = 'Enviar';
$lng['admin']['subject'] = 'Assunto';
$lng['admin']['receipient'] = 'Destinat&aacute;rio';
$lng['admin']['message'] = 'Escrever uma mensagem';
$lng['admin']['text'] = 'Mensagem';
$lng['menu']['message'] = 'Mensagens';
$lng['error']['errorsendingmail'] = 'A mensagem para &quot;%s&quot; falhou';
$lng['error']['cannotreaddir'] = 'N&atilde;o &eacute; poss&iacute;vel ler o diret&oacute;rio &quot;%s&quot';
$lng['message']['success'] = 'Mensagens enviadas para %s destinat&aacute;rios com sucesso';
$lng['message']['noreceipients'] = 'Email n&atilde;o enviado porque n&atilde;o tem destinat&aacute;rio no banco de dados';
$lng['admin']['sslsettings'] = 'Configura&ccedil;&atilde;o de SSL';
$lng['cronjobs']['notyetrun'] = 'Ainda n&atilde;o est&aacute; rodando';
$lng['install']['servername_should_be_fqdn'] = 'O nome do servidor deve ser a FQDN e n&atilde;o um endere&ccedil;o de IP';
$lng['serversettings']['default_vhostconf']['title'] = 'Configura&ccedil;&atilde;o de Vhost padr&atilde;o';
$lng['serversettings']['default_vhostconf']['description'] = 'O conte&uacute;do deste campo ser&aacute; inclu&iacute;do a cada novo vhost criado. Aten&ccedil;&atilde;o: O c&oacute;digo ser&aacute; checado para algum erro. Se contiver erros, o apache pode n&atilde;o iniciar mais';
$lng['emails']['quota'] = 'Quota';
$lng['emails']['noquota'] = 'Sem quota';
$lng['emails']['updatequota'] = 'Atualizar';
$lng['serversettings']['mail_quota']['title'] = 'Quota de Email';
$lng['serversettings']['mail_quota']['description'] = 'Quota default para novas caixas criadas';
$lng['serversettings']['mail_quota_enabled']['title'] = 'Usar quota para clientes';
$lng['serversettings']['mail_quota_enabled']['description'] = 'Ative para usar cotas em caixas de email. Padr&atilde;o &eacute; <b>N&atilde;o</b> visto que requer uma configura&ccedil;&atilde;o especial.';
$lng['serversettings']['mail_quota_enabled']['removelink'] = 'Clique aqui para limpar todas as quotas para as contas de email.';
$lng['question']['admin_quotas_reallywipe'] = 'Voc&ecirc; realmente deseja limpar todas as quotas na tabela  mail_users? Isto n&atilde;o pode ser revertido';
$lng['error']['vmailquotawrong'] = 'A tamanho da quota deve ser entre 1 e 999';
$lng['customer']['email_quota'] = 'E-mail Quota';
$lng['customer']['email_imap'] = 'E-mail IMAP';
$lng['customer']['email_pop3'] = 'E-mail POP3';
$lng['customer']['mail_quota'] = 'Quota de Email';
$lng['error']['invalidip'] = 'Endere&ccedil;o de IP Inv&aacute;lido: %s';
$lng['serversettings']['decimal_places'] = 'N&uacute;mero de casas decimais no tr&aacute;fego / espa&ccedil;o de paginas web';
$lng['admin']['dkimsettings'] = 'Configura&ccedil;&otilde;es de Chave de Dom&iacute;nios';
$lng['dkim']['dkim_prefix']['title'] = 'Prefixo';
$lng['dkim']['dkim_prefix']['description'] = 'Por favor, especifique o caminho para o os arquivos DKIM RSA, bem como para os arquivos de configura&ccedil;&atilde;o para o plugin Milter';
$lng['dkim']['dkim_domains']['title'] = 'Nome de arquivo de dom&iacute;nios';
$lng['dkim']['dkim_domains']['description'] = '<em>Nome do Arquivo</em> dos Dom&iacute;nios do DKIM, par&acirc;metro especificado na configura&ccedil;&atilde;o do dkim-Milter';
$lng['dkim']['dkim_dkimkeys']['title'] = 'Nome de arquivo de chaves';
$lng['dkim']['dkim_dkimkeys']['description'] = '<em>Nome do Arquivo</em>DKIM KeyList do par&acirc;metro especificado na configura&ccedil;&atilde;o dkim-Milter';
$lng['dkim']['dkimrestart_command']['title'] = 'Comando para reiniciar o Milter';
$lng['dkim']['dkimrestart_command']['description'] = 'Por favor especifique um comando para reiniciar o DKIM Milter';
$lng['admin']['caneditphpsettings'] = 'Pode alterar as configura&ccedil;&otilde;es PHP relacionadas com o dom&iacute;nio?';
$lng['admin']['allips'] = 'Todos os IPs';
$lng['panel']['nosslipsavailable'] = 'N&atilde;o existem atualmente IP SSL / Porta para este servidor.';
$lng['ticket']['by'] = 'Por';
$lng['dkim']['use_dkim']['title'] = 'Ativar suporte para DKIM?';
$lng['dkim']['use_dkim']['description'] = 'Voc&ecirc; deseja usar o sistema de chaves de dom&iacute;nio (DKIM) ?';
$lng['error']['invalidmysqlhost'] = 'Endere&ccedil;o de servidor MySQL inv&aacute;lido: %s';
$lng['error']['cannotuseawstatsandwebalizeratonetime'] = 'Voc&ecirc; n&atilde;o pode ativar Webalizer e Awstats  ao mesmo tempo, por favor, escolha uma delas';
$lng['serversettings']['webalizer_enabled'] = 'Ativar estat&iacute;sticas webalizer';
$lng['serversettings']['awstats_enabled'] = 'Ativar estat&iacute;sticas awstats';
$lng['admin']['awstatssettings'] = 'Configura&ccedil;&otilde;es Awtats';
$lng['admin']['domain_dns_settings'] = 'Configura&ccedil;&otilde;es de DNS';
$lng['dns']['destinationip'] = 'Dom&iacute;nio IP';
$lng['dns']['standardip'] = 'IP padr&atilde;o do servidor';
$lng['dns']['a_record'] = 'Gravar-A(Opcional IPV6)';
$lng['dns']['cname_record'] = 'Gravar-CNAME';
$lng['dns']['mxrecords'] = 'Definir entradas MX';
$lng['dns']['standardmx'] = 'Servidor MX padr&atilde;o';
$lng['dns']['mxconfig'] = 'Registros MX personalizados';
$lng['dns']['priority10'] = 'Prioridade 10';
$lng['dns']['priority20'] = 'Prioridade 20';
$lng['dns']['txtrecords'] = 'Difinir entradas TXT';
$lng['dns']['txtexample'] = 'Exemplo (Entrada-SPF):<br />v=spf1 ip4:xxx.xxx.xx.0/23 -all';
$lng['serversettings']['selfdns']['title'] = 'Configura&ccedil;&otilde;es DNS-Domiio personalizadas';
$lng['serversettings']['selfdnscustomer']['title'] = 'Aceita clientes para editar configura&ccedil;&otilde;es de DNS';
$lng['admin']['activated'] = 'Ativado';
$lng['admin']['statisticsettings'] = 'Configura&ccedil;&otilde;es de Estat&iacute;sticas';
$lng['admin']['or'] = 'ou';
$lng['serversettings']['unix_names']['title'] = 'Usar nomes compat&iacute;veis com UNIX';
$lng['serversettings']['unix_names']['description'] = 'Aceita voce usar <strong>-</strong> and <strong>_</strong> em nomes de usu&aacute;rios se <strong>No</strong>estiver marcado';
$lng['error']['cannotwritetologfile'] = 'N&atilde;o pode abrir arquivo de log %s para escrita';
$lng['admin']['sysload'] = 'Carga do Sistema';
$lng['admin']['noloadavailable'] = 'N&atilde;o dispon&iacute;vel';
$lng['admin']['nouptimeavailable'] = 'N&atilde;o dispon&iacute;vel';
$lng['panel']['backtooverview'] = 'Voltar para Vis&atilde;o Geral';
$lng['admin']['nosubject'] = '(Sem Assunto)';
$lng['admin']['configfiles']['statistics'] = 'Estat&iacute;sticas';
$lng['login']['forgotpwd'] = 'Perdeu sua senha?';
$lng['login']['presend'] = 'Resetar senha';
$lng['login']['email'] = 'Endere&ccedil;o de E-mail';
$lng['login']['remind'] = 'Resetar minha senha';
$lng['login']['usernotfound'] = '&Uacute;suario n&atilde;o encontrado';
$lng['pwdreminder']['subject'] = 'Froxlor - Reset de Senha';
$lng['pwdreminder']['body'] = 'Oi %s,\n\nsua senha do Froxlor foi resetada!\nA nova senha &eacute;: %p\n\nObrigado,\nequipe Froxlor';
$lng['pwdreminder']['success'] = 'Redefini&ccedil;&atilde;o de senha com sucesso. <br /> Voc&ecirc; agora deve receber um e-mail com sua nova senha.';
$lng['serversettings']['allow_password_reset']['title'] = 'Aceita reset de senha por clientes';
$lng['pwdreminder']['notallowed'] = 'Reset de senhas est&aacute; desativado';
$lng['serversettings']['awstats_path']['title'] = 'Caminho para pasta awstats cgi-bin';
$lng['serversettings']['awstats_path']['description'] = 'Exemplo: /usr/share/webapps/awstats/6.1/webroot/cgi-bin/';
$lng['serversettings']['awstats_updateall_command']['title'] = 'Caminho para &quot;awstats_updateall.pl&quot;';
$lng['serversettings']['awstats_updateall_command']['description'] = 'Exemplo: /usr/bin/awstats_updateall.pl';
$lng['customer']['title'] = 'T&iacute;tulo';
$lng['customer']['country'] = 'Pa&iacute;s';
$lng['panel']['dateformat'] = 'AAAA-MM-DD';
$lng['panel']['dateformat_function'] = 'A-m-d';
$lng['panel']['timeformat_function'] = 'H:i:S';
$lng['panel']['default'] = 'Padr&atilde;o';
$lng['panel']['never'] = 'Nunca';
$lng['panel']['active'] = 'Ativo';
$lng['panel']['please_choose'] = 'Por favor escolha';
$lng['panel']['allow_modifications'] = 'Aceita altera&ccedil;oes';
$lng['domains']['add_date'] = 'Adicionado no Froxlor';
$lng['domains']['registration_date'] = 'Adicionado no Registro';
$lng['domains']['topleveldomain'] = 'Top-Level-Domain';
$lng['admin']['accountdata'] = 'Data da Conta';
$lng['admin']['contactdata'] = 'Data de Contato';
$lng['admin']['servicedata'] = 'Data de Servi&ccedil;o';
$lng['serversettings']['allow_password_reset']['description'] = 'Os clientes podem redefinir sua senha e  ser&atilde;o enviadas para seu endere&ccedil;o de e-mail';
$lng['serversettings']['allow_password_reset_admin']['title'] = 'Ativa reset de senhas pelos administradores';
$lng['serversettings']['allow_password_reset_admin']['description'] = 'Admins / Revendedor pode redefinir sua senha e a nova senha ser&aacute; enviada para seu endere&ccedil;o de e-mail';
$lng['panel']['not_supported'] = 'N&atilde;o suportado em:';
$lng['menue']['email']['autoresponder'] = 'Auto-Responder';
$lng['autoresponder']['active'] = 'Ativar';
$lng['autoresponder']['autoresponder_add'] = 'Adicionar Auto-Responder';
$lng['autoresponder']['autoresponder_edit'] = 'Edita Auto-Responder';
$lng['autoresponder']['autoresponder_new'] = 'Criar novo Auto-Responder';
$lng['autoresponder']['subject'] = 'Assunto';
$lng['autoresponder']['message'] = 'Mensagem';
$lng['autoresponder']['account'] = 'Aconta';
$lng['autoresponder']['sender'] = 'Remetente';
$lng['question']['autoresponderdelete'] = 'Voc&ecirc; deseja apagar o auto-responder?';
$lng['error']['noemailaccount'] = 'Pode haver duas raz&otilde;es pelas quais voc&ecirc; n&atilde;o pode criar uma nova resposta autom&aacute;tica: Voc&ecirc; precisar&aacute; de pelo menos um e-mail para criar um novo utilit&aacute;rio de resposta autom&aacute;tica. Em segundo lugar, pode ser poss&iacute;vel que todas as contas j&aacute; tenham uma resposta autom&aacute;tica configuradas';
$lng['error']['missingfields'] = 'Nem todos os campos necess&aacute;rios estavam no campo.';
$lng['error']['accountnotexisting'] = 'Esta conta n&atilde;o existe.';
$lng['error']['autoresponderalreadyexists'] = 'J&aacute; existe um auto-responder configurado para esta conta.';
$lng['error']['invalidautoresponder'] = 'Esta determinada est&aacute; inv&aacute;lida.';
$lng['serversettings']['autoresponder_active']['title'] = 'Usar m&oacute;dulo de auto-responder';
$lng['serversettings']['autoresponder_active']['description'] = 'Voc&ecirc; deseja utilizar o m&oacute;dulo do auto-responder?';
$lng['admin']['security_settings'] = 'Op&ccedil;&otilde;es de Seguran&ccedil;a';
$lng['admin']['know_what_youre_doing'] = 'Somente altere, se voc&ecirc; sabe o que est&aacute; fazendo';
$lng['admin']['show_version_login']['title'] = 'Mostrar vers&atilde;o do Froxlor no login';
$lng['admin']['show_version_login']['description'] = 'Mostar a vers&atilde;o do Froxlor no rodap&eacute; da p&aacute;gina de login';
$lng['admin']['show_version_footer']['title'] = 'Mostar vers&atilde;o do Froxlor no rodap&eacute;';
$lng['admin']['show_version_footer']['description'] = 'Mostar a vers&atilde;o do Froxlor no rodap&eacute; do resto das p&aacute;ginas';
$lng['admin']['froxlor_graphic']['title'] = 'Cabe&ccedil;alho gr&aacute;fico do Froxlor';
$lng['admin']['froxlor_graphic']['description'] = 'Quais gr&aacute;ficos devem aparece no topor';
$lng['menue']['phpsettings']['maintitle'] = 'Configura&ccedil;&otilde;es do PHP';
$lng['admin']['phpsettings']['title'] = 'Configura&ccedil;&otilde;es do PHP';
$lng['admin']['phpsettings']['description'] = 'Descri&ccedil;&atilde;o';
$lng['admin']['phpsettings']['actions'] = 'A&ccedil;&otilde;es';
$lng['admin']['phpsettings']['activedomains'] = 'Em uso pelo(s) dom&iacute;nio(s)';
$lng['admin']['phpsettings']['notused'] = 'Configura&ccedil;&atilde;o n&atilde;o est&aacute; em uso';
$lng['admin']['misc'] = 'Variados';
$lng['admin']['phpsettings']['editsettings'] = 'Alterar Configura&ccedil;&atilde;o do PHP';
$lng['admin']['phpsettings']['addsettings'] = 'Criar novas configura&ccedil;&otilde;es do PHP';
$lng['admin']['phpsettings']['viewsettings'] = 'Visualizar Configura&ccedil;&atilde;o do PHP';
$lng['admin']['phpsettings']['phpinisettings'] = 'Configura&ccedil;&otilde;es do php.ini';
$lng['error']['nopermissionsorinvalidid'] = 'Voc&ecirc; n&atilde;o tem permiss&otilde;es suficientes para alterar essa configura&ccedil;&atilde;o ou um ID inv&aacute;lido foi dado.';
$lng['panel']['view'] = 'Visualizar';
$lng['question']['phpsetting_reallydelete'] = 'Voc&ecirc; realmente deseja apagar esta configura&ccedil;&atilde;o? Todos os dom&iacute;nios que atualmente utilizam esta configura&ccedil;&atilde;o ser&atilde;o alterada para a configura&ccedil;&atilde;o padr&atilde;o.';
$lng['admin']['phpsettings']['addnew'] = 'Criar novas configura&ccedil;&otilde;es';
$lng['error']['phpsettingidwrong'] = 'N&atilde;o existe uma configura&ccedil;&atilde;o de PHP para este ID';
$lng['error']['descriptioninvalid'] = 'A descri&ccedil;&atilde;o &eacute; muito curta, muito longa ou contem car&aacute;cters ilegais';
$lng['error']['info'] = 'Iinforma&ccedil;&otilde;es';
$lng['admin']['phpconfig']['template_replace_vars'] = 'As vari&aacute;veis que ser&atilde;o substitu&iacute;das nas Configura&ccedil;&otilde;es';
$lng['admin']['phpconfig']['safe_mode'] = 'Vai ser substitu&iacute;do pelas configura&ccedil;&otilde;es seguras deste dom&iacute;nios.';
$lng['admin']['phpconfig']['pear_dir'] = 'Ser&atilde;o substitu&iacute;dos com a defini&ccedil;&atilde;o global para o diret&oacute;rio pear.';
$lng['admin']['phpconfig']['open_basedir'] = 'Ser&atilde;o substitu&iacute;dos com a defini&ccedil;&atilde;o do dom&iacute;nio open_basedir.';
$lng['admin']['phpconfig']['tmp_dir'] = 'Substitu&iacute;do com o diret&oacute;rio tempor&aacute;rio do dom&iacute;nio.';
$lng['admin']['phpconfig']['open_basedir_global'] = 'Ser&atilde;o substitu&iacute;dos com o valor global do caminho que ser&aacute; anexado ao open_basedir.';
$lng['admin']['phpconfig']['customer_email'] = 'Ser&atilde;o substitu&iacute;dos com o endere&ccedil;o de e-mail do cliente que &eacute; dono desse dom&iacute;nio.';
$lng['admin']['phpconfig']['admin_email'] = 'Ser&atilde;o substitu&iacute;dos por e-mail do administrador quem possui esse dom&iacute;nio.';
$lng['admin']['phpconfig']['domain'] = 'Ser&atilde;o substitu&iacute;dos com o dom&iacute;nio.';
$lng['admin']['phpconfig']['customer'] = 'Ser&aacute; substitu&iacute;da pelo nome do login do cliente que &eacute; dono desse dom&iacute;nio.';
$lng['admin']['phpconfig']['admin'] = 'Ser&aacute; substitu&iacute;da pelo nome de login do administrador que possui esse dom&iacute;nio.';
$lng['login']['backtologin'] = 'Voltar ao Login';
$lng['serversettings']['mod_fcgid']['starter']['title'] = 'Processos por dom&iacute;nio';
$lng['serversettings']['mod_fcgid']['starter']['description'] = 'Quantos processos devem ser iniciadas / permitidas por dom&iacute;nio? O valor 0 &eacute; recomendado. O PHP ir&aacute; ent&atilde;o gerir a quantidade de processos.';
$lng['serversettings']['mod_fcgid']['wrapper']['title'] = 'Wrapper in Vhosts';
$lng['serversettings']['mod_fcgid']['wrapper']['description'] = 'Como os  wrapper v&atilde;o ser inclu&iacute;dos nos vhosts';
$lng['serversettings']['mod_fcgid']['tmpdir']['description'] = 'Aonde os arquivos tempor&aacute;rios devem ser guardados';
$lng['serversettings']['mod_fcgid']['peardir']['title'] = 'Diret&oacute;rios globais do PEAR';
$lng['serversettings']['mod_fcgid']['peardir']['description'] = 'Diret&oacute;rios globais do PEAR que dever&atilde;o ser substitu&iacute;dos em cada configura&ccedil;&atilde;o php.ini? Diferentes diret&oacute;rios devem ser separados por dois pontos.';
$lng['admin']['templates']['index_html'] = 'Indice de arquivo rec&eacute;m-criado no diret&oacute;rio de cliente';
$lng['admin']['templates']['SERVERNAME'] = 'Substitua pelo nome do servidor.';
$lng['admin']['templates']['CUSTOMER'] = 'Substitua pelo login do cliente.';
$lng['admin']['templates']['ADMIN'] = 'Substitua pelo login do admin.';
$lng['admin']['templates']['CUSTOMER_EMAIL'] = 'Substitua pelo endere&ccedil;o de email do cliente.';
$lng['admin']['templates']['ADMIN_EMAIL'] = 'Substitua pelo endere&ccedil;o de email do administrador.';
$lng['admin']['templates']['filetemplates'] = 'Modelo de Arquivo';
$lng['admin']['templates']['filecontent'] = 'Conte&uacute;do do Arquivo';
$lng['error']['filecontentnotset'] = 'O arquivo n&atilde;o pode ser vazio';
$lng['serversettings']['index_file_extension']['description'] = 'Qual extens&atilde;o deve ser utilizada para o &iacute;ndice no arquivo rec&eacute;m-criado no diret&oacute;rio do cliente? Esta extens&atilde;o ser&aacute; utilizado, se voc&ecirc; ou um de seus administradores criou o seu pr&oacute;prio &iacute;ndice no arquivo modelo.';
$lng['serversettings']['index_file_extension']['title'] = 'Extens&atilde;o do arquivo rec&eacute;m-criado no √çndice do diret&oacute;rio do cliente.';
$lng['error']['index_file_extension'] = 'A extens&atilde;o do &iacute;ndice do arquivo deve ficar entre 1 e 6 caracteres. A prorroga&ccedil;&atilde;o s&oacute; pode conter caracteres como az, AZ e 0-9';
$lng['admin']['expert_settings'] = 'Configura&ccedil;&otilde;es Avan&ccedil;adas';
$lng['admin']['mod_fcgid_starter']['title'] = 'Processos PHP para este dom&iacute;nio (vazio para usar valor padr&atilde;o)';
$lng['admin']['aps'] = 'APS Instalado';
$lng['customer']['aps'] = 'Instalador do APS';
$lng['aps']['scan'] = 'Procurar por novos pacotes';
$lng['aps']['upload'] = 'Atualizar novos pacotes';
$lng['aps']['managepackages'] = 'Gerenciar Pacotes';
$lng['aps']['manageinstances'] = 'Gerenciar Est&acirc;ncias';
$lng['aps']['overview'] = 'Resumo de Pacote';
$lng['aps']['status'] = 'Meus Pacotes';
$lng['aps']['search'] = 'Procurar por Pacotes';
$lng['aps']['upload_description'] = 'Por favor seleciona o instalador APS (zipfiles) para istalar no sistema';
$lng['aps']['search_description'] = 'Nome, Descri&ccedil;&atilde;o, Palavra Chave, Vers&atilde;o';
$lng['aps']['detail'] = 'Mais informa&ccedil;&atilde;o';
$lng['aps']['install'] = 'Pacote de Instala&ccedil;&atilde;o';
$lng['aps']['data'] = 'Data';
$lng['aps']['version'] = 'Vers&atilde;o';
$lng['aps']['homepage'] = 'Homepage';
$lng['aps']['installed_size'] = 'Tamanho ap&oacute;s instala&ccedil;&atilde;o';
$lng['aps']['categories'] = 'Categorias';
$lng['aps']['languages'] = 'L&iacute;nguas';
$lng['aps']['long_description'] = 'Descri&ccedil;&atilde;o Longa';
$lng['aps']['configscript'] = 'Configura&ccedil;&atilde;o de Script';
$lng['aps']['changelog'] = 'Log de Altera&ccedil;&otilde;es';
$lng['aps']['license'] = 'Licen&ccedil;a';
$lng['aps']['license_link'] = 'Caminho para Licen&ccedil;a';
$lng['aps']['screenshots'] = 'Screenshots';
$lng['aps']['back'] = 'Voltar para Vis&atilde;o Geral';
$lng['aps']['install_wizard'] = 'Assistente de Instala&ccedil;&atilde;o';
$lng['aps']['wizard_error'] = 'Yoc&ecirc; preencheu com dados inv&aacute;lidos. Por favor corrija voc&ecirc; mesmo para continuar a instala&ccedil;&atilde;o';
$lng['aps']['basic_settings'] = 'Configura&ccedil;&otilde;es B&aacute;sicas';
$lng['aps']['application_location'] = 'Local de Instala&ccedil;&atilde;o';
$lng['aps']['application_location_description'] = 'Local aonde a aplica&ccedil;&atilde;o vai ser instalada';
$lng['aps']['no_domains'] = 'Dom&iacute;nios n&atilde;o encontrados';
$lng['aps']['database_password'] = 'Senha de Banco de Dados';
$lng['aps']['database_password_description'] = 'Senha que deve ser utilizada para novos bancos de dados';
$lng['aps']['license_agreement'] = 'Contrato';
$lng['aps']['cancel_install'] = 'Cancelar Instala&ccedil;&atilde;o';
$lng['aps']['notazipfile'] = 'O arquivo de upload n&atilde;o &eacute; um arquivo .zip';
$lng['aps']['filetoobig'] = 'O arquivo &eacute; muito grande';
$lng['aps']['filenotcomplete'] = 'O arquivo n&atilde;o foi enviado corretamente';
$lng['aps']['phperror'] = 'Ocorreu um erro interno no PHP. O c&oacute;digo de erro &eacute; #';
$lng['aps']['moveproblem'] = 'O script falhou em fazer o upload dos arquivos para diret&oacute;rio de destino. Por favor tenha certeza de que as permiss&otilde;es est&atilde;o setadas corretamente.';
$lng['aps']['uploaderrors'] = '<strong>Erros de Arquivo <em>%s</em></strong><br/><ul>%s</ul>';
$lng['aps']['nospecialchars'] = 'Sar&aacute;cters especiais n&atilde;o s&atilde;o aceitos nos termos de pesquisa';
$lng['aps']['noitemsfound'] = 'Nenhum pacote foi encontrado';
$lng['aps']['nopackagesinstalled'] = 'Voc&ecirc; n&atilde;o tem nenhum pacote instalado.';
$lng['aps']['instance_install'] = 'Pend&ecirc;ncia de Instala&ccedil;&atilde;o de Pacote';
$lng['aps']['instance_task_active'] = 'Instala&ccedil;&atilde;o est&aacute; em execu&ccedil;&atilde;o neste momento';
$lng['aps']['instance_success'] = 'Pacote est&aacute; instalado corretamente';
$lng['aps']['instance_error'] = 'Pacote n&atilde;o est&aacute; instalado corretamente, erros ocorreram durante a instala&ccedil;&atilde;o';
$lng['aps']['instance_uninstall'] = 'Pend&ecirc;ncia de Desinstala&ccedil;&atilde;o de Pacotes';
$lng['aps']['unknown_status'] = 'Erro, valor desconhecido';
$lng['aps']['currentstatus'] = 'Status Atual';
$lng['aps']['activetasks'] = 'Status de Tarejas';
$lng['aps']['task_install'] = 'Instala&ccedil;&atilde;o pendente';
$lng['aps']['task_remove'] = 'Desinsta&ccedil;&atilde;o pendente';
$lng['aps']['task_reconfigure'] = 'Reconfigura&ccedil;&atilde;o Pendente';
$lng['aps']['task_upgrade'] = 'Atualizar pend&ecirc;ncia';
$lng['aps']['no_task'] = 'Sem tarefas pendentes';
$lng['aps']['applicationlinks'] = 'Links de Aplica&ccedil;&otilde;es';
$lng['aps']['mainsite'] = 'Site Principal';
$lng['aps']['uninstall'] = 'Desinstalar Pacote';
$lng['aps']['reconfigure'] = 'Alterar configura&ccedil;&otilde;es';
$lng['aps']['erroronnewinstance'] = '<strong>Este pacote n&atilde;o pode ser instalado.</strong><br/><br/>Por favor volte a visualiza&ccedil;&atilde;o de pacotes e comece uma nova instala&ccedil;&atilde;o.';
$lng['aps']['successonnewinstance'] = '<strong><em>%s</em> vai ser instalado agora.</strong><br/><br/>Volte para "Meus Pacotes" e espere a instala&ccedil;&atilde;o acabar. Isto pode demorar alguns minutos.';
$lng['aps']['php_misc_handler'] = 'PHP - N&atilde;o tem suporte para outras extens&otilde;es al&eacute;m de .php .';
$lng['aps']['php_misc_directoryhandler'] = 'PHP - N&atilde;o tem suporte para diret&oacute;rios.';
$lng['aps']['asp_net'] = 'ASP.NET - Pacote n&atilde;o suportado';
$lng['aps']['cgi'] = 'CGI - Pacote n&atilde;o suportado';
$lng['aps']['php_extension'] = 'Extens&atilde;o PHP &quot;%s&quot; missing';
$lng['aps']['php_function'] = 'Fun&ccedil;&atilde;o PHP &quot;%s&quot; missing';
$lng['aps']['php_configuration'] = 'Configura&ccedil;&atilde;o de PHP atual &quot;%s&quot; n&atilde;o suportado pelo pacote';
$lng['aps']['php_configuration_post_max_size'] = 'Configura&ccedil;&atilde;o do PHP - &quot;post_max_size&quot; valor muito baixo';
$lng['aps']['php_configuration_memory_limit'] = 'Configura&ccedil;&atilde;o do PHP - &quot;memory_limit&quot; valor muito baixo';
$lng['aps']['php_configuration_max_execution_time'] = 'Configura&ccedil;&atilde;o do PHP - &quot;max_execution_time&quot; valor muito baixo';
$lng['aps']['php_general_old'] = 'PHP - Geral - Vers&atilde;o do PHP Muito Antiga';
$lng['aps']['php_general_new'] = 'PHP - Geral - Vers&atilde;o do PHP Muito Nova';
$lng['aps']['db_mysql_support'] = 'Base de Dados - Este pacote precisa outra base de dados do que MySQL';
$lng['aps']['db_mysql_version'] = 'Base de Dados - Servidor MySQL &eacute; muito antigo';
$lng['aps']['webserver_module'] = 'Servidor Web - M&oacute;dulo &quot;%s&quot; n&atilde;o encontrado';
$lng['aps']['misc_configscript'] = 'Misc - A linguagem de configura&ccedil;&atilde;o do script n&atilde;o &eacute; suportada&uuml;tzt.';
$lng['aps']['misc_version_already_installed'] = 'A mesma vers&atilde;o do pacote j&aacute; est&aacute; instalada.';
$lng['aps']['misc_version_already_installed'] = 'Mesma vers&atilde;o de pacote instalado.';
$lng['aps']['misc_only_newer_versions'] = 'Por raz&otilde;es de seguran&ccedil;a somente pacotes instalados podem ser reinstalados e atualizados.';
$lng['aps']['erroronscan'] = '<strong>Erros para <em>%s</em></strong><ul>%s</ul>';
$lng['aps']['invalidzipfile'] = '<strong>Erros para <em>%s</em></strong><br/><ul><li>Este n&atilde;o &eacute; um pacote valido de APS compactado!</li></ul>';
$lng['aps']['successpackageupdate'] = '<strong><em>%s</em> Pacote atualizado com sucesso</strong>';
$lng['aps']['successpackageinstall'] = '<strong><em>%s</em> Novo pacote instalado com sucesso</strong>';
$lng['aps']['class_zip_missing'] = 'SimpleXML Class, fun&ccedil;&otilde;es exec ou fun&ccedil;&otilde;es ZIP podem estar perdidas ou desabilitadas! Para futuras informa&ccedil;&otilde;es sobre este problema procure no manual sobre este m&oacute;dulo';
$lng['aps']['dir_permissions'] = 'O PHP/Servidor Web tem que estar apto em escrever nos diret&oacute;rios /var/www/froxlor/temp/ e /var/www/froxlor/packages/';
$lng['aps']['initerror'] = '<strong>Foi encontrado erros neste m&oacute;dulo:</strong><ul>%s</ul>Corrija o problema, ou o m&oacute;dulo n&atilde;o poder&aacute; ser usado!';
$lng['aps']['iderror'] = 'ID incorretamente especificado';
$lng['aps']['nopacketsforinstallation'] = 'Nenhum para para instalar';
$lng['aps']['nopackagestoinstall'] = 'Nenhum pacote para visualizar ou instalar';
$lng['aps']['nodomains'] = 'Seleciona um dom&iacute;nio da lisa. Se n&atilde;o tiver nenhum, o pacote n&atilde;o pode ser instalado';
$lng['aps']['wrongpath'] = 'Either this path contains invalid characters or there is another application installed already.';
$lng['aps']['dbpassword'] = 'Especifique uma senha com um m&iacute;nimo de 8 car&aacute;cters';
$lng['aps']['error_text'] = 'Especifique um texto sem car&aacute;cters especiais';
$lng['aps']['error_email'] = 'Especifique um endere&ccedil;o de e-mail v&aacute;lido';
$lng['aps']['error_domain'] = 'Especifique uma URL v&aacute;lida como http://www.exemplo.com/';
$lng['aps']['error_integer'] = 'Especifique um valor n&uacute;merico (Formato-Integer)';
$lng['aps']['error_float'] = 'Especifique um valor n&uacute;merico (Formato-Float)';
$lng['aps']['error_password'] = 'Especifique uma senha';
$lng['aps']['error_license'] = 'Yes, I have the license and will abide by its terms.';
$lng['aps']['error_licensenoaccept'] = 'Voc&ecirc; deve aceitar a licen&ccedil;a de instala&ccedil;&atilde;o desta aplica&ccedil;&atilde;o';
$lng['aps']['stopinstall'] = 'Cancelar Instala&ccedil;&atilde;o';
$lng['aps']['installstopped'] = 'A instala&ccedil;&atilde;o deste pacote foi cancelada com sucesso';
$lng['aps']['installstoperror'] = 'A instala&ccedil;&atilde;o n&atilde;o pode ser abortada porque a instala&ccedil;&atilde;o j&aacute; foi iniciada. Se voc&ecirc; deseja remover o pacote, primeiro esperer instalar, depois remova-o em "Meus Pacotes".';
$lng['aps']['waitfortask'] = 'N&atilde;o tem op&ccedil;&otilde;es para selecionar. Espere o final de todas as tarefas para terminar';
$lng['aps']['removetaskexisting'] = '<strong>Existe uma tarefa para desinsta&ccedil;&atilde;o.</strong><br/><br/>Por favor volte para "Meus Pacotes" e espere terminar.';
$lng['aps']['packagewillberemoved'] = '<strong>O pacote vai ser desinstalado agora.</strong><br/><br/>Por favor volte para "Meus Pacotes" e espere terminar.';
$lng['question']['reallywanttoremove'] = '<strong>Voc&ecirc; realmente deseja desinstalar este pacote?</strong><br/><br/>Todo conte&uacute;do de banco de dados e arquivo ir&aacute; ser apagado. Tenha certeza que voc&ecirc; tem o backup para uso futuro!<br/><br/>';
$lng['aps']['searchoneresult'] = '%s pacote achado';
$lng['aps']['searchmultiresult'] = '%s pacotes achados';
$lng['question']['reallywanttostop'] = 'Voc&ecirc; deseja cancelar a instala&ccedil;&atilde;o deste pacote?';
$lng['aps']['packagenameandversion'] = 'Nome do Pacote &amp; Vers&atilde;o';
$lng['aps']['package_locked'] = 'Destrava';
$lng['aps']['package_enabled'] = 'Trava';
$lng['aps']['lock'] = 'Trava';
$lng['aps']['unlock'] = 'Destrava';
$lng['aps']['remove'] = 'Remover';
$lng['aps']['allpackages'] = 'Todos os pacotes';
$lng['question']['reallyremovepackages'] = '<strong>Do you really want to delete this packages?</strong><br/><br/>Packages with dependencies can only be remove if the corresponding Instances have been removed!<br/><br/>';
$lng['aps']['nopackagesinsystem'] = 'There were no packages installed in the system which could be managed.';
$lng['aps']['packagenameandstatus'] = 'Nome do Pacote &amp; Status';
$lng['aps']['activate_aps']['title'] = 'A\'tiva instalados APS';
$lng['aps']['activate_aps']['description'] = 'Aqui o instalador do APS pode ser ativado ou desativado globalmente';
$lng['aps']['packages_per_page']['title'] = 'Pacotes por p&aacute;gina';
$lng['aps']['packages_per_page']['description'] = 'Quantos pacotes devem aparecer por p&aacute;gina para os clientes ';
$lng['aps']['upload_fields']['title'] = 'Upload de campos por p&aacute;gina';
$lng['aps']['upload_fields']['description'] = 'Quantos campos devem aparecer por p&aacute;gina para a instala&ccedil;&atilde;o de novos pacotes no sistema?';
$lng['aps']['exceptions']['title'] = 'Exce&ccedil;&atilde;o para valida&ccedil;&atilde;o de pacote';
$lng['aps']['exceptions']['description'] = 'Some packages need special configuration parameters or modules. The Installer cannot always determine if this options/extensions are available. For this reason you can now define exceptions that packages can be installed in the system. Do only select options which match your real configuration setup. For further information about this problem look into the handbook for this module.';
$lng['aps']['settings_php_extensions'] = 'Extens&otilde;es do PHP';
$lng['aps']['settings_php_configuration'] = 'Configura&ccedil;&atilde;o do PHP';
$lng['aps']['settings_webserver_modules'] = 'M&oacute;dulos do Webserver';
$lng['aps']['settings_webserver_misc'] = 'Servidor Web Variados';
$lng['aps']['specialoptions'] = 'Op&ccedil;&otilde;es Especiais';
$lng['aps']['removeunused'] = 'Remover pacotes n&atilde;o usados';
$lng['aps']['enablenewest'] = 'Ativa nova vers&atilde;o de pacote, tranca outras';
$lng['aps']['installations'] = 'Instala&ccedil;&otilde;es';
$lng['aps']['statistics'] = 'Estat&iacute;sticas';
$lng['aps']['numerofpackagesinstalled'] = '%s pacotes instalados';
$lng['aps']['numerofpackagesenabled'] = '%s pacotes ativos';
$lng['aps']['numerofpackageslocked'] = '%s Pacotes Trancados';
$lng['aps']['numerofinstances'] = '%s Instala&ccedil;&atilde;o de todos<br/>';
$lng['question']['reallydoaction'] = '<strong>Do you really want to execute the selected actions?</strong><br/><br/>Data which can be lost by continuing, cannot be restored later.<br/><br/>';
$lng['aps']['linktolicense'] = 'Caminho para Licen&ccedil;a';
$lng['aps']['initerror_customer'] = 'Existe um problema com esta extens&atilde;o do Froxlor. Contate seu administrador para maiores informa&ccedil;&otilde;es.';
$lng['aps']['numerofinstancessuccess'] = '%s instala&ccedil;&otilde;es executadas';
$lng['aps']['numerofinstanceserror'] = '%s instala&ccedil;&otilde;es falhadas';
$lng['aps']['numerofinstancesaction'] = '%s planejou instala&ccedil;&otilde;es/desinstala&ccedil;&otilde;es';
$lng['aps']['downloadallpackages'] = 'Fazer download de todos os pacotes da distribui&ccedil;&atilde;o do servidor';
$lng['aps']['updateallpackages'] = 'Atualizar todos os pacote pela distribui&ccedil;&atilde;o do servidor';
$lng['aps']['downloadtaskexists'] = 'Existe downloads em andamento. Por favor espere terminar.';
$lng['aps']['downloadtaskinserted'] = 'Uma tarefa de download de fotos os pacotes foi criada. Esta tarefa pode demorar alguns minutos.';
$lng['aps']['updatetaskexists'] = 'Existe uma atualiza&ccedil;&atilde;o em andamento. Por favor espere esta atualiza&ccedil;&atilde;o terminar.';
$lng['aps']['updatetaskinserted'] = 'Uma tarefa para a atualiza&ccedil;&atilde;o de todos os pacotes foi criado. Esta tarefa pode demorar alguns minutos.';
$lng['aps']['canmanagepackages'] = 'Pode gerenciar pacotes APS';
$lng['aps']['numberofapspackages'] = 'Quantia de instala&ccedil;&otilde;es APS';
$lng['aps']['allpackagesused'] = '<strong>Erro</strong><br/><br/>Voc&ecirc; j&aacute; atingiu o n&uacute;mero m&aacute;ximo de instala&ccedil;&atilde;o de apli&ccedil;a&ccedil;&otilde;es APS';
$lng['aps']['noinstancesexisting'] = 'N&atilde;o existem est&acirc;ncias para administrar.';
$lng['error']['customerdoesntexist'] = 'O cliente que voc&ecirc; escolheu n&atilde;o existe';
$lng['error']['admindoesntexist'] = 'O administrador que voc&ecirc; escolheu n&atilde;o existe';
$lng['serversettings']['system_realtime_port']['title'] = 'Porta para Froxlor em tempo real';
$lng['serversettings']['system_realtime_port']['description'] = 'Froxlor connects to this port at localhost everytime a new cron task is scheduled. If value is 0 (zero), this feature is disabled.<br />See also: <a href="http://wiki.froxlor.org/contrib/realtime">Make Froxlor work in realtime (Froxlor Wiki)</a>';
$lng['serversettings']['session_allow_multiple_login']['title'] = 'AAtiva login m&uacute;ltiplo';
$lng['serversettings']['session_allow_multiple_login']['description'] = 'Se ativado um usu&aacute;rio pode ter m&uacute;ltiplos logins';
$lng['serversettings']['panel_allow_domain_change_admin']['title'] = 'Ativa mover dom&iacute;nios entre admins';
$lng['serversettings']['panel_allow_domain_change_admin']['description'] = 'If activated you can change the admin of a domain at domainsettings.<br /><b>Attention:</b> If a customer isn\'t assigned to the same admin as the domain, the admin can see every other domain of that customer!';
$lng['serversettings']['panel_allow_domain_change_customer']['title'] = 'Ativa mover dom&iacute;nios entre clientes';
$lng['serversettings']['panel_allow_domain_change_customer']['description'] = 'Se ativado voc&ecirc; pode trocar o cliente de um dom&iacute;nio para administra&ccedil;&atilde;o de outro.<br /><b>Attention:</b> Froxlor n&atilde;o troca nenhum caminho. Isto pode fazer com que dom&iacute;nios parem de funcionar';
$lng['domains']['associated_with_domain'] = 'Associado';
$lng['domains']['aliasdomains'] = 'Encaminhamento de dom&iacute;nios';
$lng['error']['ipportdoesntexist'] = 'A combina&ccedil;&atilde;o de IP/Porta que voc&ecirc; escolheu n&atilde;o existe';
$lng['admin']['phpserversettings'] = 'Configura&ccedil;&atilde;o do PHP';
$lng['admin']['phpsettings']['binary'] = 'Bin&aacute;rio do PHP';
$lng['admin']['phpsettings']['file_extensions'] = 'Extens&otilde;es de arquivos';
$lng['admin']['phpsettings']['file_extensions_note'] = '(Sem pontos, separados por espa&ccedil;os)';
$lng['admin']['mod_fcgid_maxrequests']['title'] = 'M&aacute;ximo de requisi&ccedil;&otilde;es php para este dom&iacute;nio (vazio para valor default)';
$lng['serversettings']['mod_fcgid']['maxrequests']['title'] = 'M&aacute;ximo de solicita&ccedil;&otilde;es por Dom&iacute;nio';
$lng['serversettings']['mod_fcgid']['maxrequests']['description'] = 'Quantas solicita&ccedil;&otilde;es ser&atilde;o aceitas por dom&iacute;nio?';

?>
