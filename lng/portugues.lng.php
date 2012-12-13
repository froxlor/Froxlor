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
 *
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
$lng['panel']['no'] = 'Não';
$lng['panel']['emptyfornochanges'] = 'Sair sem salvar';
$lng['panel']['emptyfordefault'] = 'Restaurar padrão';
$lng['panel']['path'] = 'Caminho';
$lng['panel']['toggle'] = 'Toggle';
$lng['panel']['next'] = 'Próximo';
$lng['panel']['dirsmissing'] = 'Directório não disponível ou ilegível';

/**
 * Login
 */

$lng['login']['username'] = 'Usuário';
$lng['login']['password'] = 'Senha';
$lng['login']['language'] = 'Idioma';
$lng['login']['login'] = 'Login';
$lng['login']['logout'] = 'Sair';
$lng['login']['profile_lng'] = 'Idioma padrão';

/**
 * Customer
 */

$lng['customer']['documentroot'] = 'Diretorio home';
$lng['customer']['name'] = 'Sobrenome';
$lng['customer']['firstname'] = 'Primeiro nome';
$lng['customer']['company'] = 'Empresa';
$lng['customer']['street'] = 'Endereço';
$lng['customer']['zipcode'] = 'Cep';
$lng['customer']['city'] = 'Cidade';
$lng['customer']['phone'] = 'Telefone';
$lng['customer']['fax'] = 'Fax';
$lng['customer']['email'] = 'E-mail';
$lng['customer']['customernumber'] = 'Cliente ID';
$lng['customer']['diskspace'] = 'Espaço de disco (MB)';
$lng['customer']['traffic'] = 'Tráfego (GB)';
$lng['customer']['mysqls'] = 'Bancos de dados-MySQL';
$lng['customer']['emails'] = 'Endereços de e-mail';
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
$lng['menue']['email']['emails'] = 'Endereços';
$lng['menue']['email']['webmail'] = 'WebMail';
$lng['menue']['mysql']['mysql'] = 'MySQL';
$lng['menue']['mysql']['databases'] = 'Banco de dados';
$lng['menue']['mysql']['phpmyadmin'] = 'phpMyAdmin';
$lng['menue']['domains']['domains'] = 'Dominios';
$lng['menue']['domains']['settings'] = 'Configurações';
$lng['menue']['ftp']['ftp'] = 'FTP';
$lng['menue']['ftp']['accounts'] = 'Contas';
$lng['menue']['ftp']['webftp'] = 'WebFTP';
$lng['menue']['extras']['extras'] = 'Extras';
$lng['menue']['extras']['directoryprotection'] = 'Diretorio protegido';
$lng['menue']['extras']['pathoptions'] = 'opções de caminhos';

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
$lng['changepassword']['new_password_ifnotempty'] = 'Nova senha (em branco = não alterar)';
$lng['changepassword']['also_change_ftp'] = ' trocar tambem a senha da conta principal de FTP';

/**
 * Domains
 */

$lng['domains']['description'] = 'Aqui voce pode criar(sub-)dominios e alterar seu destino.<br />O sistema irá levar algum tempo para aplicar as novas configurações depois de salvas.';
$lng['domains']['domainsettings'] = 'Configurar Dominio';
$lng['domains']['domainname'] = 'Nome do dominio';
$lng['domains']['subdomain_add'] = 'Criar Sub-dominio';
$lng['domains']['subdomain_edit'] = 'Editar (sub)dominio';
$lng['domains']['wildcarddomain'] = 'Criar um wildcarddomain?';
$lng['domains']['aliasdomain'] = 'Aliás para o dominio';
$lng['domains']['noaliasdomain'] = 'Não dominio do aliás';

/**
 * eMails
 */

$lng['emails']['description'] = 'Aqui voce pode criar e alterer seus e-mails.<br />Uma conta é como uma caixa de correio na frente de sua casa. Quando alguem envia para voce um e-mail, ele é colocado nesta conta.<br /><br />Para baixar seus e-mails use as seguintes configurações no seu propraga de e-mails favorito: (Os dados em <i>italico</i> devem ser substituidos pelo equivalente da conta que voce criou!)<br />Hostname: <b><i>Nome de seu dominio</i></b><br />Usuário: <b><i>Nome da conta / Endereço de e-mail</i></b><br />Senha: <b><i>a senha que voce escolheu</i></b>';
$lng['emails']['emailaddress'] = 'Endereços de e-mail';
$lng['emails']['emails_add'] = 'Criar e-mail';
$lng['emails']['emails_edit'] = 'Editar e-mail';
$lng['emails']['catchall'] = 'Pega tudo';
$lng['emails']['iscatchall'] = 'Definir como endereço pega tudo?';
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

$lng['ftp']['description'] = 'Aqui voce pode criar e alterar suas contas de FTP.<br />As alterações são instantâneas e podem ser utilizadas imediatamente depois de salvas.';
$lng['ftp']['account_add'] = 'Criar conta';

/**
 * MySQL
 */

$lng['mysql']['description'] = 'Aqui voce pode criar e alterar seus bancos de dados MySQL.<br />As alterações são instantâneas e podem ser utilizadas imediatamente depois de salvas.<br />No menu do lado esquerdo voce pode encontrar a ferramenta phpMyAdmin e com ela facilmente administrar seus bancos de dados.<br /><br />Para usar seu banco de dados com scripts em PHP use as seguintes configurações: (Os dados em <i>italico</i> devem ser substituidos pelo equivalente do banco de dados que voce criou!)<br />Hostname: <b><SQL_HOST></b><br />Usuario: <b><i>Nome do banco de dadose</i></b><br />Senha: <b><i>a senha que voce escolheu</i></b><br />Banco de dados: <b><i>Nome do banco de dados';
$lng['mysql']['databasename'] = 'Usuario / Nome do banco de dados';
$lng['mysql']['databasedescription'] = 'Descrição do banco de dados';
$lng['mysql']['database_create'] = 'Criar banco de dados';

/**
 * Extras
 */

$lng['extras']['description'] = 'Aqui voce pode adicoionar alguns recursos extras, como por exemplo um diretório protegido.<br />O sistema ira precisar de algum tempo para aplicar suas alterações depois de salvas.';
$lng['extras']['directoryprotection_add'] = 'Adicionar diretório pretogido';
$lng['extras']['view_directory'] = 'Mostrar conteúdo do diretório';
$lng['extras']['pathoptions_add'] = 'Adicionar opções de caminho';
$lng['extras']['directory_browsing'] = 'Pesquizar conteúdo de diretório';
$lng['extras']['pathoptions_edit'] = 'Esitar opções de caminhos';
$lng['extras']['error404path'] = '404';
$lng['extras']['error403path'] = '403';
$lng['extras']['error500path'] = '500';
$lng['extras']['error401path'] = '401';
$lng['extras']['errordocument404path'] = 'URL para página de erro 404';
$lng['extras']['errordocument403path'] = 'URL para página de erro 403';
$lng['extras']['errordocument500path'] = 'URL para página de erro 500';
$lng['extras']['errordocument401path'] = 'URL para página de erro 401';

/**
 * Errors
 */

$lng['error']['error'] = 'Erro';
$lng['error']['directorymustexist'] = 'O diretório %s deve existir. Por favor crie ele primeiro com seu programa de FTP.';
$lng['error']['filemustexist'] = 'O arquivo %s deve existir.';
$lng['error']['allresourcesused'] = 'Voce já usou todos os seus recursos.';
$lng['error']['domains_cantdeletemaindomain'] = 'Voce não pode deletar um dominio que esta sendo usado como email-domain.';
$lng['error']['domains_canteditdomain'] = 'Voce não pode editar este dominio. Ele foi desabilitado pelo administrador.';
$lng['error']['domains_cantdeletedomainwithemail'] = 'Voce não pode deletar um dominio que é usado como email-domain. Delete todos as contas de e-mail primeiro.';
$lng['error']['firstdeleteallsubdomains'] = 'Voce deve deletar todos subdominios antes de poder criar um wildcard domain.';
$lng['error']['youhavealreadyacatchallforthisdomain'] = 'Voce já definiu uma conta pega tudo para este dominio.';
$lng['error']['ftp_cantdeletemainaccount'] = 'Voce não pode deletar a conta principal de FTP';
$lng['error']['login'] = 'O usuário ou senha digitados, não estão corretos. Por favor tente novamente!';
$lng['error']['login_blocked'] = 'Esta conta está suspensa por exceder as tentativas de login permitidas. <br />Por favor tente novamente em ' . $settings['login']['deactivatetime'] . ' segundos.';
$lng['error']['notallreqfieldsorerrors'] = 'Voce não preencheu todos os campos ou preencheu algum campo incorretamente.';
$lng['error']['oldpasswordnotcorrect'] = 'A senha antiga não confere.';
$lng['error']['youcantallocatemorethanyouhave'] = 'Voce não pode alocar mais recursos do que voce mesmo possui.';
$lng['error']['mustbeurl'] = 'Voce não digitou uma URL válida (ex. http://seudominio.com/erro404.htm)';
$lng['error']['invalidpath'] = 'Optou por um URL não válido (eventuais problemas na lista do directório)';
$lng['error']['stringisempty'] = 'Faltando informação no campo';
$lng['error']['stringiswrong'] = 'Erro na informação do campo';
$lng['error']['myloginname'] = '\'' . $lng['login']['username'] . '\'';
$lng['error']['mypassword'] = '\'' . $lng['login']['password'] . '\'';
$lng['error']['oldpassword'] = '\'' . $lng['changepassword']['old_password'] . '\'';
$lng['error']['newpassword'] = '\'' . $lng['changepassword']['new_password'] . '\'';
$lng['error']['newpasswordconfirm'] = '\'' . $lng['changepassword']['new_password_confirm'] . '\'';
$lng['error']['newpasswordconfirmerror'] = 'A nova senha e a confirmação não conferem';
$lng['error']['myname'] = '\'' . $lng['customer']['name'] . '\'';
$lng['error']['myfirstname'] = '\'' . $lng['customer']['firstname'] . '\'';
$lng['error']['emailadd'] = '\'' . $lng['customer']['email'] . '\'';
$lng['error']['mydomain'] = '\'Dominio\'';
$lng['error']['mydocumentroot'] = '\'Documento principal\'';
$lng['error']['loginnameexists'] = 'Login %s já existe';
$lng['error']['emailiswrong'] = 'E-mail %s contem caracteres inválidos ou está incompleto';
$lng['error']['loginnameiswrong'] = 'Login %s contem caracteres inválidos';
$lng['error']['userpathcombinationdupe'] = 'Usuario e caminho já existem';
$lng['error']['patherror'] = 'Erro geral! o caminho não pode ficar em branco';
$lng['error']['errordocpathdupe'] = 'Opção de caminho %s já existe';
$lng['error']['adduserfirst'] = 'Por favor crie um cliente primeiro';
$lng['error']['domainalreadyexists'] = 'O dominio %s já está apontado para outro cliente';
$lng['error']['nolanguageselect'] = 'Nenhum idioma selecionado.';
$lng['error']['nosubjectcreate'] = 'Voce deve definir um nome para este e-mail template.';
$lng['error']['nomailbodycreate'] = 'Voce deve definir o texto para este e-mail template.';
$lng['error']['templatenotfound'] = 'Template não encontrado.';
$lng['error']['alltemplatesdefined'] = 'Voce não pode definir mais templates, todos idiomas já suportados.';
$lng['error']['wwwnotallowed'] = 'www não é permitido como nome de subdominio.';
$lng['error']['subdomainiswrong'] = 'O subdominio %s contém caracteres inválidos.';
$lng['error']['domaincantbeempty'] = 'O nome do dominio não pode estar vazio.';
$lng['error']['domainexistalready'] = 'O dominio %s já existe.';
$lng['error']['domainisaliasorothercustomer'] = 'O domínio-alias escolhido é ele próprio um domínio-alias ou este pertence a um outro cliente.';
$lng['error']['emailexistalready'] = 'O E-mail %s já existe.';
$lng['error']['maindomainnonexist'] = 'O dominio principal %s não existe.';
$lng['error']['destinationnonexist'] = 'Por favor crie seu redirecionamento no campo \'Destino\'.';
$lng['error']['destinationalreadyexistasmail'] = 'O redirecionamento %s já existe como uma conta de e-mail.';
$lng['error']['destinationalreadyexist'] = 'Voce já definiu um redirecionamento para %s .';
$lng['error']['destinationiswrong'] = 'O redirecionamento %s contem caracteres inválidos ou incompletos.';
$lng['error']['domainname'] = $lng['domains']['domainname'];

/**
 * Questions
 */

$lng['question']['question'] = 'Pergunta de segurança';
$lng['question']['admin_customer_reallydelete'] = 'Voce realmente deseja deletar o cliente %s? Este comando não poderá ser cancelado!';
$lng['question']['admin_domain_reallydelete'] = 'Voce realmente deseja deletar o dominio %s?';
$lng['question']['admin_domain_reallydisablesecuritysetting'] = 'Voce realmente deseja desativar estas configurações de segurança (OpenBasedir)?';
$lng['question']['admin_admin_reallydelete'] = 'Voce realmente deseja deletar o administrador %s? Todos clientes e dominios serão realocados para o administrador principal.';
$lng['question']['admin_template_reallydelete'] = 'Voce realmente deseja deletar o template \'%s\'?';
$lng['question']['domains_reallydelete'] = 'Voce realmente deseja deletar o dominio %s?';
$lng['question']['email_reallydelete'] = 'Voce realmente deseja deletar o e-mail %s?';
$lng['question']['email_reallydelete_account'] = 'Voce realmente deseja deletar a conta de e-mail %s?';
$lng['question']['email_reallydelete_forwarder'] = 'Voce realmente deseja deletar o redirecionamento %s?';
$lng['question']['extras_reallydelete'] = 'Voce realmente deseja deletar a proteção do diretório %s?';
$lng['question']['extras_reallydelete_pathoptions'] = 'Voce realmente deseja deletar o caminho %s?';
$lng['question']['ftp_reallydelete'] = 'Voce realmente deseja deletar a conta de FTP %s?';
$lng['question']['mysql_reallydelete'] = 'Voce realmente deseja deletar o banco de dados %s? Este comando não poderá ser cancelado!';
$lng['question']['admin_configs_reallyrebuild'] = 'Está certo que quer deixar reconfigurar os ficheiros de configuração de Apache e Bind?';

/**
 * Mails
 */

$lng['mails']['pop_success']['mailbody'] = 'Olá,\n\n sua conta de e-mail {EMAIL}\n foi criada com sucesso.\n\nEsta é uma mensagem automática\neMail, por favor não responda!\n\nAtenciosamente, Equipe de desenvolvimento do Froxlor';
$lng['mails']['pop_success']['subject'] = 'Conta de e-mail criada com sucesso!';
$lng['mails']['createcustomer']['mailbody'] = 'Olá {FIRSTNAME} {NAME},\n\nseguem os detalhes de sua nova conta de e-mail:\n\nUsuario: {USERNAME}\nSenha: {PASSWORD}\n\nObrigado,\nEquipe de desenvolvimento do Froxlor';
$lng['mails']['createcustomer']['subject'] = 'Informações da conta';

/**
 * Admin
 */

$lng['admin']['overview'] = 'Visão geral';
$lng['admin']['ressourcedetails'] = 'Recursos usados';
$lng['admin']['systemdetails'] = 'Detalhes do sistema';
$lng['admin']['froxlordetails'] = 'Detalhes do Froxlor';
$lng['admin']['installedversion'] = 'Versão instalada';
$lng['admin']['latestversion'] = 'Ultima Versão';
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
$lng['admin']['subdomainforemail'] = 'Subdominio como "emaildomains"';
$lng['admin']['admin'] = 'Administrador';
$lng['admin']['admins'] = 'Administradores';
$lng['admin']['admin_add'] = 'Criar administrador';
$lng['admin']['admin_edit'] = 'Editar administrador';
$lng['admin']['customers_see_all'] = 'Mostrar todos os clientes';
$lng['admin']['domains_see_all'] = 'Mostrar todos os dominios';
$lng['admin']['change_serversettings'] = 'Alterar configuraççes do servidor?';
$lng['admin']['server'] = 'Servidor';
$lng['admin']['serversettings'] = 'Configuraççes';
$lng['admin']['rebuildconf'] = 'Escrever de novo os configs';
$lng['admin']['stdsubdomain'] = 'Subdominio padrão';
$lng['admin']['stdsubdomain_add'] = 'Criar Subdominio padrão';
$lng['admin']['deactivated'] = 'Desativado';
$lng['admin']['deactivated_user'] = 'Desativar usuário';
$lng['admin']['sendpassword'] = 'Enviar senha';
$lng['admin']['ownvhostsettings'] = 'Own vHost-Settings';
$lng['admin']['configfiles']['serverconfiguration'] = 'Configurações';
$lng['admin']['configfiles']['files'] = '<b>Configfiles:</b> Por favor altere os seguintes arquivos ou crie eles com<br />o seguinte conteúdo se ele não existir.<br /><b>Por favor observe:</b> A senha do MySQL nï¿½o foi alterada por razões de segurança.<br />Por favor substitua "MYSQL_PASSWORD" por uma sua. Se voce esqueceu a senha do MySQL<br />voce pode verificar em "lib/userdata.inc.php".';
$lng['admin']['configfiles']['commands'] = '<b>Commands:</b> Por favor execute as seguintes comandos no shell.';
$lng['admin']['configfiles']['restart'] = '<b>Restart:</b> Por favor execute as seguintes comandos no shell para carregar aas novas configurações.';
$lng['admin']['templates']['templates'] = 'Templates';
$lng['admin']['templates']['template_add'] = 'Adicionar template';
$lng['admin']['templates']['template_edit'] = 'Editar template';
$lng['admin']['templates']['action'] = 'Ação';
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
$lng['serversettings']['accountprefix']['description'] = 'Qual o prefixo "customeraccounts" deve ter?';
$lng['serversettings']['mysqlprefix']['title'] = 'SQL Prefixo';
$lng['serversettings']['mysqlprefix']['description'] = 'Qual prefixo as contas mysql devem ter?';
$lng['serversettings']['ftpprefix']['title'] = 'FTP Prefixo';
$lng['serversettings']['ftpprefix']['description'] = 'Qual prefixo as contas de FTP devem ter?';
$lng['serversettings']['documentroot_prefix']['title'] = 'Diretório de documentação';
$lng['serversettings']['documentroot_prefix']['description'] = 'Aonde os documentos dever ser gravados?';
$lng['serversettings']['logfiles_directory']['title'] = 'Diretório de LOG';
$lng['serversettings']['logfiles_directory']['description'] = 'Aonde os arquivos de log dever ser gravados?';
$lng['serversettings']['ipaddress']['title'] = 'Endereços de IP';
$lng['serversettings']['ipaddress']['description'] = 'Quais os Endereços IP deste servidor?';
$lng['serversettings']['hostname']['title'] = 'Hostname';
$lng['serversettings']['hostname']['description'] = 'Qual o Hostname deste servidor?';
$lng['serversettings']['apachereload_command']['title'] = 'Comando de reiniciar o Apache';
$lng['serversettings']['apachereload_command']['description'] = 'Qual o comando para reiniciar o apache?';
$lng['serversettings']['bindconf_directory']['title'] = 'Diretório de configuração do Bind';
$lng['serversettings']['bindconf_directory']['description'] = 'Aonde estão os arquivos de configuração do bind?';
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
$lng['serversettings']['language']['description'] = 'Qual o idioma padrão do servidor?';
$lng['serversettings']['maxloginattempts']['title'] = 'Tentativas maximas de Login';
$lng['serversettings']['maxloginattempts']['description'] = 'Tentativas maximas de Login para a conta ser desativada.';
$lng['serversettings']['deactivatetime']['title'] = 'Tempo que a conta deve permanecer desativada';
$lng['serversettings']['deactivatetime']['description'] = 'Tempo (sec.) qua a conta permanece desativada depois de muitas tentativas de login.';
$lng['serversettings']['pathedit']['title'] = 'File-Método de entrada';
$lng['serversettings']['pathedit']['description'] = 'A escolha do file tem que ser feita através do Dropdown-Menu ou pode ser feita manualmente?';

/**
 * ADDED BETWEEN 1.2.12 and 1.2.13
 */

$lng['serversettings']['paging']['title'] = 'Entradas por pagina';
$lng['serversettings']['paging']['description'] = 'Quantas entradas devem ser mostradas por pagina? (0 = desabilitar paginas)';
$lng['error']['ipstillhasdomains'] = 'O IP/Porta que voce quer deletar ainda possui dominios associados e eles, por favor altere o IP/Porta destes dominios antes de deletá-los.';
$lng['error']['cantdeletedefaultip'] = 'Voce não pode deletar o IP/Porta padrão do revendedor, por favor defina outro IP/Porta como padrão antes deletar o IP/Porta desejado';
$lng['error']['cantdeletesystemip'] = 'Voce não pode deletar o IP do sistema, nem criar uma nova combinação IP/Porta para o sistema ou trocar o IP do sistema.';
$lng['error']['myipaddress'] = '\'IP\'';
$lng['error']['myport'] = '\'Porta\'';
$lng['error']['myipdefault'] = 'Voce precisa selecionar o IP/Porta que será padrão.';
$lng['error']['myipnotdouble'] = 'Esta combinação  IP/Porta já existe.';
$lng['question']['admin_ip_reallydelete'] = 'Voce realmente deseja deletar este endereço IP?';
$lng['admin']['ipsandports']['ipsandports'] = 'IPs e Portas';
$lng['admin']['ipsandports']['add'] = 'Adicionar IP/Porta';
$lng['admin']['ipsandports']['edit'] = 'Editar IP/Porta';
$lng['admin']['ipsandports']['ipandport'] = 'IP/Porta';
$lng['admin']['ipsandports']['ip'] = 'IP';
$lng['admin']['ipsandports']['port'] = 'Porta';
$lng['error']['cantchangesystemip'] = 'Você não pode mudar o último sistema IP, para criar uma outra combinação nova de IP/Port para o sistema IP ou para mudar o sistema IP';
$lng['question']['admin_domain_reallydocrootoutofcustomerroot'] = 'É você certo, você quer a raiz do original para este domínio, não estando dentro do customerroot do cliente?';
$lng['error']['loginnameissystemaccount'] = 'Você não pode criar os clientes que são similares aos systemaccounts. Incorpore por favor um outro accountname.';
$lng['domain']['docroot'] = 'trajeto da linha acima de';
$lng['domain']['homedir'] = 'diretório da casa';
$lng['admin']['valuemandatory'] = 'Este valor é imperativo.';
$lng['admin']['valuemandatorycompany'] = 'Qualquer um "nome" e "nome" o "companhia" deve ser enchido.';
$lng['admin']['phpenabled'] = 'PHP Habilitado';
$lng['admin']['webserver'] = 'Servidor Web';
$lng['serversettings']['nameservers']['title'] = 'Servidores DNS';
$lng['serversettings']['mxservers']['title'] = 'Servidores de Email';
$lng['serversettings']['mxservers']['description'] = 'Uma lista separada por vírgulas que contém o numero de prioridade e o hostname separados por um espaço (por exemplo: \'mx.example.com 10 \'), contendo os servidores mx.';
$lng['error']['admin_domain_emailsystemhostname'] = 'Desculpe. Você não pode usar o hostname do servidor como domínio de email';
$lng['admin']['memorylimitdisabled'] = 'Desabilitado';
$lng['domain']['openbasedirpath'] = 'Caminho do OpenBaseDir';
$lng['menue']['main']['username'] = 'Logado como';
$lng['panel']['urloverridespath'] = 'URL (Caminho Completo)';
$lng['panel']['pathorurl'] = 'Caminho ou URL';
$lng['error']['sessiontimeoutiswrong'] = 'Apenas numeros "Timeout da sessão" permitido.';
$lng['error']['maxloginattemptsiswrong'] = 'Apenas numero "Tentativa maxima de Login" permitido.';
$lng['error']['deactivatetimiswrong'] = 'Apenas numero "Desativar Tempo" permitido.';
$lng['error']['accountprefixiswrong'] = 'O "Prefixo" está errado.';
$lng['error']['mysqlprefixiswrong'] = 'O "Prefixo SQL" está errado.';
$lng['error']['ftpprefixiswrong'] = 'O "Prefixo FTP" está errado.';
$lng['error']['ipiswrong'] = 'O "Endereço-IP" está errado. Apenas um Endereço-IP válido é permitido.';
$lng['error']['vmailuidiswrong'] = 'O "UID do E-mail" Está errado. Só é permitido um número de ID.';
$lng['error']['vmailgidiswrong'] = 'O "GID do E-mail" Está errado. Só é permitido um número de ID.';
$lng['error']['adminmailiswrong'] = 'O "Endereço de Envio" está errado. Apenas um endereço de e-mail válido é permitido.';
$lng['error']['pagingiswrong'] = 'O "Entradas por páginas"-value está errado. Somente caracteres númericos são permitidos.';
$lng['error']['phpmyadminiswrong'] = 'O caminho para o phpMyAmin não é válido';
$lng['error']['webmailiswrong'] = 'O caminho para o Webmail não é válido';
$lng['error']['webftpiswrong'] = 'O caminho para o WebFTP não é válido';
$lng['domains']['hasaliasdomains'] = 'Possui alinhas de domínio(s)';
$lng['serversettings']['defaultip']['title'] = 'IP/Porta Padrão';
$lng['serversettings']['defaultip']['description'] = 'Qual é a IP/Porta Padrão?';
$lng['domains']['statstics'] = 'Estatísticas de Uso';
$lng['panel']['ascending'] = 'Crescente';
$lng['panel']['decending'] = 'Decrescente';
$lng['panel']['search'] = 'Procurar';
$lng['panel']['used'] = 'Usado';
$lng['panel']['translator'] = 'Tradutor';
$lng['error']['stringformaterror'] = 'O valor par ao campo "%s" não esta no formato correto.';
$lng['admin']['serversoftware'] = 'Servidor de Software';
$lng['admin']['phpversion'] = 'Versão do PHP';
$lng['admin']['phpmemorylimit'] = 'Memória Limite do PHP';
$lng['admin']['mysqlserverversion'] = 'Versão do MySQL Server';
$lng['admin']['mysqlclientversion'] = 'Versão do MySQL Client';
$lng['admin']['webserverinterface'] = 'Interface do Servidor Web';
$lng['domains']['isassigneddomain'] = 'É um domínio assinado';
$lng['serversettings']['phpappendopenbasedir']['title'] = 'Caminho para adicionar OpenBasedir';
$lng['serversettings']['phpappendopenbasedir']['description'] = 'Estes caminhos (separados por dois pontos) serão acrescentados ao OpenBasedir em cada vhost.';
$lng['error']['youcantdeleteyourself'] = 'Você não pode apagar você mesmo por motivos de segurança';
$lng['error']['youcanteditallfieldsofyourself'] = 'Nota: Você não pode editar todos os campos de sua própria conta por motivos de segurança';
$lng['serversettings']['natsorting']['title'] = 'Usar classificação natural na visualização';
$lng['serversettings']['natsorting']['description'] = 'Ordenar listas como: web1 -> web2 -> web11 ao invéz de web1 -> web11 -> web2.';
$lng['serversettings']['deactivateddocroot']['title'] = 'Docroots desativado para usuários';
$lng['serversettings']['deactivateddocroot']['description'] = 'Quando um usuário estiver desativado, esse caminho é usado como seu docroot. Deixe em branco para não criar um vhost a todos.';
$lng['panel']['reset'] = 'Descartar Mudanças';
$lng['admin']['accountsettings'] = 'Configurações de Conta';
$lng['admin']['panelsettings'] = 'Painel de Controle';
$lng['admin']['systemsettings'] = 'Configurações do Sistema';
$lng['admin']['webserversettings'] = 'Configurações do WebServer';
$lng['admin']['mailserversettings'] = 'Configurações do Servidor de Email';
$lng['admin']['nameserversettings'] = 'Configurações dos Servidores de Nomes';
$lng['admin']['updatecounters'] = 'Recalcular utilização de recursos';
$lng['question']['admin_counters_reallyupdate'] = 'Voce deseja recalcular os recursos utilizados?';
$lng['panel']['pathDescription'] = 'Se o diretório não existir, será criado automaticamente';
$lng['mails']['trafficninetypercent']['mailbody'] = 'Querido {NAME},\n\nVocê usou {TRAFFICUSED} MB do seu disponível {TRAFFIC} MB de tráfego.\nisto é mais que 90%.\n\nHonestamente, Equipe Froxlor';
$lng['mails']['trafficninetypercent']['subject'] = 'Atingindo o seu limite de tráfego';
$lng['admin']['templates']['trafficninetypercent'] = 'Email de notificação para clientes quando atingirem 90% do uso do tráfego';
$lng['admin']['templates']['TRAFFIC'] = 'Substituído com o tráfego, o que foi atribuído ao cliente.';
$lng['admin']['templates']['TRAFFICUSED'] = 'Substituído com o tráfego, que foi esgotado pela cliente.';
$lng['admin']['subcanemaildomain']['never'] = 'Nunca';
$lng['admin']['subcanemaildomain']['choosableno'] = 'Escolhe, default não';
$lng['admin']['subcanemaildomain']['choosableyes'] = 'Escolher, default sim';
$lng['admin']['subcanemaildomain']['always'] = 'Sempre';
$lng['changepassword']['also_change_webalizer'] = 'Troca a senha das estatísticas do webalizer';
$lng['serversettings']['mailpwcleartext']['title'] = 'Salva as senhas de usuários sempre criptografia no banco de dados';
$lng['serversettings']['mailpwcleartext']['description'] = 'Se você selecionar sim, todas as senhas serão guardadas descriptografadas (Poderá ser lido por todos com acesso ao banco de dados ) na tabela mail_users-table. Somente ative essa opção se você realmente precise!';
$lng['serversettings']['mailpwcleartext']['removelink'] = 'Clique aqui para limpar todas as senhas não criptografadas da tabela<br />Você realmente deseja limpar todas as senhas não encriptadas a partir da tabela mail_users? Isto não pode ser revertido!';
$lng['admin']['configfiles']['overview'] = 'Visão Geral';
$lng['admin']['configfiles']['wizard'] = 'Assistente';
$lng['admin']['configfiles']['distribution'] = 'Distribuição';
$lng['admin']['configfiles']['service'] = 'Serviço';
$lng['admin']['configfiles']['daemon'] = 'Daemon';
$lng['admin']['configfiles']['http'] = 'Servidor Web (HTTP)';
$lng['admin']['configfiles']['dns'] = 'Servidor de Nomes (DNS)';
$lng['admin']['configfiles']['mail'] = 'Servidor de Emails (POP3/IMAP)';
$lng['admin']['configfiles']['smtp'] = 'Servidor de Emails (SMTP)';
$lng['admin']['configfiles']['ftp'] = 'Servidor FTP';
$lng['admin']['configfiles']['etc'] = 'Outros (Sistema)';
$lng['admin']['configfiles']['choosedistribution'] = 'Escolha uma distribuição';
$lng['admin']['configfiles']['chooseservice'] = 'Escolha um serviço';
$lng['admin']['configfiles']['choosedaemon'] = 'Escolha um daemon';
$lng['serversettings']['ftpdomain']['title'] = 'Contas FTP @domínio';
$lng['serversettings']['ftpdomain']['description'] = 'Clientes podem criar contas de FTP user@domíniodocliente?';
$lng['panel']['back'] = 'Volta';
$lng['serversettings']['mod_log_sql']['title'] = 'Temporariamente salva os logs no banco de dados';
$lng['serversettings']['mod_fcgid']['title'] = 'Incluir PHP via mod_fcgid/suexec';
$lng['serversettings']['mod_fcgid']['description'] = 'Use mod_fcgid/suexec/libnss_mysql to run PHP with the corresponding useraccount.<br/><b>This needs a special Apache configuration. All following options are only valid if the module is enabled.</b>';
$lng['serversettings']['sendalternativemail']['title'] = 'Utilize endereço de e-mail alternativo';
$lng['serversettings']['sendalternativemail']['description'] = 'Enviar e-mail a senha para um endereço diferente durante uma criação de conta de e-mail';
$lng['emails']['alternative_emailaddress'] = 'Endereço de E-mail alternativo';
$lng['mails']['pop_success_alternative']['mailbody'] = 'Oi,\n\nSua conta de email {EMAIL}\nfoi configurada corretamente.\nSua senha é{PASSWORD}.\n\nEmail criado automaticamente\n, Por favor não responda!\n\nCumprimentos, Equipe Froxlor.';
$lng['mails']['pop_success_alternative']['subject'] = 'Conta de email criada com sucesso';
$lng['admin']['templates']['pop_success_alternative'] = 'Bem-vindo para novas contas e-mail enviado ao endereço alternativo';
$lng['admin']['templates']['EMAIL_PASSWORD'] = 'Substituído a senha da conta POP3/IMAP.';
$lng['error']['documentrootexists'] = 'O Diretório "%s" já existe para este usuario. Por favor remova-o e depois tente novamente.';
$lng['serversettings']['apacheconf_vhost']['title'] = 'Arquivo/Diretório de configurações do Apache Vhost';
$lng['serversettings']['apacheconf_vhost']['description'] = 'Onde as configuração de Vhost devem ser guardadas? Você pode especificar um arquivo (todos os vhosts em um arquivo) ou diretório (cada vhost com seu próprio arquivo) aqui.';
$lng['serversettings']['apacheconf_diroptions']['title'] = 'Configuração de diretório do Apache Arquivo/Nome do Diretório.';
$lng['serversettings']['apacheconf_diroptions']['description'] = 'Quando as opções de configuração de diretório deve ser armazenada? Você poderia especificar um arquivo (todas as opções em um arquivo) ou diretório ( cada opção no seu próprio arquivo).';
$lng['serversettings']['apacheconf_htpasswddir']['title'] = 'Apache htpasswd dirname';
$lng['serversettings']['apacheconf_htpasswddir']['description'] = 'Onde deve ser o diretório de arquivos htpasswd?';
$lng['error']['formtokencompromised'] = 'O Pedido parece estar correto. Por motivos de segurança você está desconectado.';
$lng['serversettings']['mysql_access_host']['title'] = 'Hosts de Acesso MySQL';
$lng['serversettings']['mysql_access_host']['description'] = 'Uma lista separada por vírgulas de hosts a partir do qual os utilizadores devem ter a possibilidade de conectar-se ao MySQL-Server.';
$lng['admin']['ipsandports']['create_listen_statement'] = 'Criar instrução de escuta';
$lng['admin']['ipsandports']['create_namevirtualhost_statement'] = 'Criar instrução de NameVirtualHost';
$lng['admin']['ipsandports']['create_vhostcontainer'] = 'Criar vHost-Container';
$lng['admin']['ipsandports']['create_vhostcontainer_servername_statement'] = 'Criar instrução de ServerName  no vHost-Container';
$lng['admin']['webalizersettings'] = 'Configurações do Webalizer';
$lng['admin']['webalizer']['normal'] = 'Normal';
$lng['admin']['webalizer']['quiet'] = 'Quieto';
$lng['admin']['webalizer']['veryquiet'] = 'Sem Saída';
$lng['serversettings']['webalizer_quiet']['title'] = 'Saida do Webalizer';
$lng['serversettings']['webalizer_quiet']['description'] = 'Modo verbose do webalizer';
$lng['ticket']['admin_email'] = 'root@localhost';
$lng['ticket']['noreply_email'] = 'tickets@froxlor';
$lng['admin']['ticketsystem'] = 'Tickets de Suporte';
$lng['menue']['ticket']['ticket'] = 'Tickets';
$lng['menue']['ticket']['categories'] = 'Cotegorias de Suporte';
$lng['menue']['ticket']['archive'] = 'Arquivo de Tickets';
$lng['ticket']['description'] = 'Aqui você pode fazer perguntas ao administrador responsável';
$lng['ticket']['ticket_new'] = 'Abrir um novo ticket';
$lng['ticket']['ticket_reply'] = 'Responder um ticket';
$lng['ticket']['ticket_reopen'] = 'Re-abrir um ticket';
$lng['ticket']['ticket_newcateory'] = 'Recriar uma categoria';
$lng['ticket']['ticket_editcateory'] = 'Editar uma categoria';
$lng['ticket']['ticket_view'] = 'Ver Ticket';
$lng['ticket']['ticketcount'] = 'Tickets';
$lng['ticket']['ticket_answers'] = 'Respostas';
$lng['ticket']['lastchange'] = 'Última troca';
$lng['ticket']['subject'] = 'Assunto';
$lng['ticket']['status'] = 'Status';
$lng['ticket']['lastreplier'] = 'Último que respondeu';
$lng['ticket']['priority'] = 'Prioridade';
$lng['ticket']['low'] = 'Baixa';
$lng['ticket']['normal'] = 'Normal';
$lng['ticket']['high'] = 'Alta';
$lng['ticket']['lastchange_from'] = 'De data (dd.mm.aaaa)';
$lng['ticket']['lastchange_to'] = 'Até data (dd.mm.aaaa)';
$lng['ticket']['category'] = 'Categoria';
$lng['ticket']['no_cat'] = 'Nenhuma';
$lng['ticket']['message'] = 'Mensagem';
$lng['ticket']['show'] = 'Visualizar';
$lng['ticket']['answer'] = 'Responder um ticket';
$lng['ticket']['close'] = 'Fechar';
$lng['ticket']['reopen'] = 'Re-abrir';
$lng['ticket']['archive'] = 'Arquivo';
$lng['ticket']['ticket_delete'] = 'Deletar Ticket';
$lng['ticket']['lastarchived'] = 'Tickets recém arquivados';
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
$lng['ticket']['notmorethanxopentickets'] = 'Devido a proteção anti-spam não se pode ter mais de %s bilhetes abertos';
$lng['ticket']['supportstatus'] = 'Status de Suporte';
$lng['ticket']['supportavailable'] = '<span class="ticket_low">Nossos engenheiros de suporte estão disponíveis e prontos a ajudar.</span>';
$lng['ticket']['supportnotavailable'] = '<span class="ticket_high">Nossos engenheiros de suporte não estão actualmente disponíveis</span>';
$lng['admin']['templates']['ticket'] = 'Emails de notificação para tickets de suporte';
$lng['admin']['templates']['SUBJECT'] = 'Substituído por um assunto de ticket de suporte';
$lng['admin']['templates']['new_ticket_for_customer'] = 'Informação do Cliente de que de que o Ticket foi gerado.';
$lng['admin']['templates']['new_ticket_by_customer'] = 'Notificação do Admin para um ticket aberto por um cliente';
$lng['admin']['templates']['new_reply_ticket_by_customer'] = 'Notificação do Admin para um ticket respondido por um cliente';
$lng['admin']['templates']['new_ticket_by_staff'] = 'Notificação de cliente para um ticket aberto pela administração';
$lng['admin']['templates']['new_reply_ticket_by_staff'] = 'Notificação do cliente para um ticket respondido pela administração';
$lng['mails']['new_ticket_for_customer']['subject'] = 'Seu ticket de Suporte foi Enviado';
$lng['mails']['new_ticket_by_customer']['subject'] = 'Novo pedido de Suporte';
$lng['mails']['new_reply_ticket_by_customer']['mailbody'] = 'Oi admin,\n\no ticket de suporte "{SUBJECT}" foi respondido para o cliente.\n\nPor favor logue para abrir o ticket.\n\Obrigado,\nequipe Froxlor';
$lng['mails']['new_reply_ticket_by_customer']['subject'] = 'Nova resposta para um ticket de supote';
$lng['mails']['new_ticket_by_staff']['subject'] = 'Novo ticket enviado';
$lng['mails']['new_reply_ticket_by_staff']['mailbody'] = 'Oi {FIRSTNAME} {NAME},\n\o ticket de suporte com o assunto "{SUBJECT}" foi respondido pelos seus administradores.\n\nPor favor logue para abrir esse ticket.\n\nObrigado,\nequipe Froxlor';
$lng['mails']['new_reply_ticket_by_staff']['subject'] = 'Nova resposta para um ticket de supote';
$lng['question']['ticket_reallyclose'] = 'Você deseja fechar o ticket"%s"?';
$lng['question']['ticket_reallydelete'] = 'Você deseja apagar o ticket"%s"?';
$lng['question']['ticket_reallydeletecat'] = 'Você deseja deletar a categoria "%s"?';
$lng['question']['ticket_reallyarchive'] = 'Você deseja mover o ticket "%s" para o arquivo?';
$lng['error']['mysubject'] = '\'' . $lng['ticket']['subject'] . '\'';
$lng['error']['mymessage'] = '\'' . $lng['ticket']['message'] . '\'';
$lng['error']['mycategory'] = '\'' . $lng['ticket']['category'] . '\'';
$lng['error']['nomoreticketsavailable'] = 'Você já utilizou todos seus tickets disponíveis. Por favor contacte seu administrador';
$lng['error']['nocustomerforticket'] = 'Não pode criar Tickets sem Clientes';
$lng['error']['categoryhastickets'] = 'A categoria ainda tem tikets na mesma. <br /> Por favor elimine os bilhetes para eliminar a categoria';
$lng['error']['notmorethanxopentickets'] = $lng['ticket']['notmorethanxopentickets'];
$lng['admin']['ticketsettings'] = 'Configurações de Ticket de Suporte';
$lng['admin']['archivelastrun'] = 'Último arquivamento de ticket';
$lng['serversettings']['ticket']['noreply_email']['title'] = 'Não responder endereço de email';
$lng['serversettings']['ticket']['noreply_email']['description'] = 'O endereço de envio para tickets de suporte, normalmente é no-reply@domain.com';
$lng['serversettings']['ticket']['worktime_begin']['title'] = 'Iniciado tempo de suporte (hh:mm)';
$lng['serversettings']['ticket']['worktime_begin']['description'] = 'Início quando o suporte estiver disponível';
$lng['serversettings']['ticket']['worktime_end']['title'] = 'Fim do tempo de suporte (hh:mm)';
$lng['serversettings']['ticket']['worktime_end']['description'] = 'Fim do tempo quando o suporte estiver disponível';
$lng['serversettings']['ticket']['worktime_sat'] = 'Suporte disponível nos sábados?';
$lng['serversettings']['ticket']['worktime_sun'] = 'Suporte disponível nos domingos?';
$lng['serversettings']['ticket']['worktime_all']['title'] = 'Sem tempo limite para suporte';
$lng['serversettings']['ticket']['worktime_all']['description'] = 'Se "Sim" para opção para iniciar e finalizar vai ser substituída';
$lng['serversettings']['ticket']['archiving_days'] = 'Depois de quantoas dias tickets fechado são arquivados?';
$lng['customer']['tickets'] = 'Tickets de Suporte';
$lng['admin']['domain_nocustomeraddingavailable'] = 'Não adicionar um domínio corretamente. Você primeiro precisa adicionar um cliente.';
$lng['serversettings']['ticket']['enable'] = 'Ativar tickets de sistema';
$lng['serversettings']['ticket']['concurrentlyopen'] = 'Quantos tickes poderam ser abertos ao mesmo tempo?';
$lng['error']['norepymailiswrong'] = 'O "Endereço (Noreply)" está errado. Somente um endereço válido é aceito.';
$lng['error']['tadminmailiswrong'] = 'O "Endereço de admin " está errado. Somente um endereço válido é aceito.';
$lng['ticket']['awaitingticketreply'] = 'Você tem %s tickes de suporte não respondido(s)';
$lng['serversettings']['ticket']['noreply_name'] = 'E-mail do remetente do Ticket';
$lng['serversettings']['mod_fcgid']['configdir']['title'] = 'Diretório de configuração';
$lng['serversettings']['mod_fcgid']['configdir']['description'] = 'Aonde todos os arquivos de configuração do fcgid vão ser guardados? Se você não utiliza um binário compilado, está é uma situação normal, deve estar dentro de /var/www/';
$lng['serversettings']['mod_fcgid']['tmpdir']['title'] = 'Diretório Temporário';
$lng['serversettings']['ticket']['reset_cycle']['title'] = 'Resetar ciclo de tickers usados';
$lng['serversettings']['ticket']['reset_cycle']['description'] = 'Resetar tickets usados por clientes';
$lng['admin']['tickets']['daily'] = 'Diariamente';
$lng['admin']['tickets']['weekly'] = 'Semanalmente';
$lng['admin']['tickets']['monthly'] = 'Mensalmente';
$lng['admin']['tickets']['yearly'] = 'Anualmente';
$lng['error']['ticketresetcycleiswrong'] = 'O ciclo de resetes de ticket pode ser "diário", "semanal", "mensal" or "anual".';
$lng['menue']['traffic']['traffic'] = 'Tráfego';
$lng['menue']['traffic']['current'] = 'Mês corrente';
$lng['traffic']['month'] = "Mês";
$lng['traffic']['day'] = "Diariamente";
$lng['traffic']['months'][1] = "Janeiro";
$lng['traffic']['months'][2] = "Fevereiro";
$lng['traffic']['months'][3] = "Março";
$lng['traffic']['months'][4] = "Abril";
$lng['traffic']['months'][5] = "Maio";
$lng['traffic']['months'][6] = "Junho";
$lng['traffic']['months'][7] = "Julho";
$lng['traffic']['months'][8] = "Agosto";
$lng['traffic']['months'][9] = "Setembro";
$lng['traffic']['months'][10] = "Outubro";
$lng['traffic']['months'][11] = "Novembro";
$lng['traffic']['months'][12] = "Dezembro";
$lng['traffic']['mb'] = "Tráfego (MB)";
$lng['traffic']['distribution'] = '<font color="#019522">FTP</font> | <font color="#0000FF">HTTP</font> | <font color="#800000">E-Mail</font>';
$lng['traffic']['sumhttp'] = 'Resumo Tráfego de HTTP em';
$lng['traffic']['sumftp'] = 'Resumo Tráfego de FTP em';
$lng['traffic']['summail'] = 'Resumo Tráfego de HTTP em';
$lng['serversettings']['no_robots']['title'] = 'Aceitar robÃ´s de procura na index de seuFroxlor';
$lng['admin']['loggersettings'] = 'Configurações de Logs';
$lng['serversettings']['logger']['enable'] = 'Habilitar/Desabilitar Logs';
$lng['serversettings']['logger']['severity'] = 'Nível de Logs';
$lng['admin']['logger']['normal'] = 'normal';
$lng['admin']['logger']['paranoid'] = 'paranóico';
$lng['serversettings']['logger']['types']['title'] = 'Tipos de Log(s)';
$lng['serversettings']['logger']['types']['description'] = 'Especificar tipos de logs separados por vírgula.<br />Tipos de lógs disponíveis: syslog, file, mysql';
$lng['serversettings']['logger']['logfile'] = 'Caminho do Arquivo de Log incluindo nome de arquivo';
$lng['error']['logerror'] = 'Log-Erro: %s';
$lng['serversettings']['logger']['logcron'] = 'Logar tarefas do cron';
$lng['question']['logger_reallytruncate'] = 'Você realmente deseja dividir a tabela "%s"?';
$lng['admin']['loggersystem'] = 'Systema-Logging';
$lng['menue']['logger']['logger'] = 'Systema-Logging';
$lng['logger']['date'] = 'Data';
$lng['logger']['type'] = 'Tipo';
$lng['logger']['action'] = 'Ação';
$lng['logger']['user'] = 'Usuário';
$lng['logger']['truncate'] = 'Log Vazio';
$lng['serversettings']['ssl']['use_ssl'] = 'Usar SSL';
$lng['serversettings']['ssl']['ssl_cert_file'] = 'Aonde estão localizados os certificados';
$lng['serversettings']['ssl']['openssl_cnf'] = 'Padrão para criar o arquivo de certificado';
$lng['panel']['reseller'] = 'Revenda';
$lng['panel']['admin'] = 'Administrador';
$lng['panel']['customer'] = 'Cliente(s)';
$lng['error']['nomessagetosend'] = 'Você não entrou com uma mensagem';
$lng['error']['noreceipientsgiven'] = 'Você não especificou um destinatário';
$lng['admin']['emaildomain'] = 'Domínio de Email';
$lng['admin']['email_only'] = 'Somente Email?';
$lng['admin']['wwwserveralias'] = 'Adicionar um "www." ServerAlias';
$lng['admin']['ipsandports']['enable_ssl'] = 'Esta é uma porta SSL?';
$lng['admin']['ipsandports']['ssl_cert_file'] = 'Caminho para o certificado SSL';
$lng['panel']['send'] = 'Enviar';
$lng['admin']['subject'] = 'Assunto';
$lng['admin']['receipient'] = 'Destinatário';
$lng['admin']['message'] = 'Escrever uma mensagem';
$lng['admin']['text'] = 'Mensagem';
$lng['menu']['message'] = 'Mensagens';
$lng['error']['errorsendingmail'] = 'A mensagem para "%s" falhou';
$lng['error']['cannotreaddir'] = 'Não é possível ler o diretório "%s"';
$lng['message']['success'] = 'Mensagens enviadas para %s destinatários com sucesso';
$lng['message']['noreceipients'] = 'Email não enviado porque não tem destinatário no banco de dados';
$lng['admin']['sslsettings'] = 'Configuração de SSL';
$lng['cronjobs']['notyetrun'] = 'Ainda não está rodando';
$lng['serversettings']['default_vhostconf']['title'] = 'Configuração de Vhost padrão';
$lng['serversettings']['default_vhostconf']['description'] = 'O conteúdo deste campo será incluído a cada novo vhost criado. Atenção: O código será checado para algum erro. Se contiver erros, o apache pode não iniciar mais';
$lng['emails']['quota'] = 'Quota';
$lng['emails']['noquota'] = 'Sem quota';
$lng['emails']['updatequota'] = 'Atualizar';
$lng['serversettings']['mail_quota']['title'] = 'Quota de Email';
$lng['serversettings']['mail_quota']['description'] = 'Quota default para novas caixas criadas';
$lng['serversettings']['mail_quota_enabled']['title'] = 'Usar quota para clientes';
$lng['serversettings']['mail_quota_enabled']['description'] = 'Ative para usar cotas em caixas de email. Padrão é <b>Não</b> visto que requer uma configuração especial.';
$lng['serversettings']['mail_quota_enabled']['removelink'] = 'Clique aqui para limpar todas as quotas para as contas de email.';
$lng['question']['admin_quotas_reallywipe'] = 'Você realmente deseja limpar todas as quotas na tabela  mail_users? Isto não pode ser revertido';
$lng['error']['vmailquotawrong'] = 'A tamanho da quota deve ser entre 1 e 999';
$lng['customer']['email_quota'] = 'E-mail Quota';
$lng['customer']['email_imap'] = 'E-mail IMAP';
$lng['customer']['email_pop3'] = 'E-mail POP3';
$lng['customer']['mail_quota'] = 'Quota de Email';
$lng['error']['invalidip'] = 'Endereço de IP Inválido: %s';
$lng['serversettings']['decimal_places'] = 'Número de casas decimais no tráfego / espaço de paginas web';
$lng['admin']['dkimsettings'] = 'Configurações de Chave de Domínios';
$lng['dkim']['dkim_prefix']['title'] = 'Prefixo';
$lng['dkim']['dkim_prefix']['description'] = 'Por favor, especifique o caminho para o os arquivos DKIM RSA, bem como para os arquivos de configuração para o plugin Milter';
$lng['dkim']['dkim_domains']['title'] = 'Nome de arquivo de domínios';
$lng['dkim']['dkim_domains']['description'] = '<em>Nome do Arquivo</em> dos Domínios do DKIM, parâmetro especificado na configuração do dkim-Milter';
$lng['dkim']['dkim_dkimkeys']['title'] = 'Nome de arquivo de chaves';
$lng['dkim']['dkim_dkimkeys']['description'] = '<em>Nome do Arquivo</em>DKIM KeyList do parâmetro especificado na configuração dkim-Milter';
$lng['dkim']['dkimrestart_command']['title'] = 'Comando para reiniciar o Milter';
$lng['dkim']['dkimrestart_command']['description'] = 'Por favor especifique um comando para reiniciar o DKIM Milter';
$lng['admin']['caneditphpsettings'] = 'Pode alterar as configurações PHP relacionadas com o domínio?';
$lng['admin']['allips'] = 'Todos os IPs';
$lng['panel']['nosslipsavailable'] = 'Não existem atualmente IP SSL / Porta para este servidor.';
$lng['ticket']['by'] = 'Por';
$lng['dkim']['use_dkim']['title'] = 'Ativar suporte para DKIM?';
$lng['dkim']['use_dkim']['description'] = 'Você deseja usar o sistema de chaves de domínio (DKIM) ?';
$lng['error']['invalidmysqlhost'] = 'Endereço de servidor MySQL inválido: %s';
$lng['error']['cannotuseawstatsandwebalizeratonetime'] = 'Você não pode ativar Webalizer e Awstats  ao mesmo tempo, por favor, escolha uma delas';
$lng['serversettings']['webalizer_enabled'] = 'Ativar estatísticas webalizer';
$lng['serversettings']['awstats_enabled'] = 'Ativar estatísticas awstats';
$lng['admin']['awstatssettings'] = 'Configurações Awtats';
$lng['admin']['domain_dns_settings'] = 'Configurações de DNS';
$lng['dns']['destinationip'] = 'Domínio IP';
$lng['dns']['standardip'] = 'IP padrão do servidor';
$lng['dns']['a_record'] = 'Gravar-A(Opcional IPV6)';
$lng['dns']['cname_record'] = 'Gravar-CNAME';
$lng['dns']['mxrecords'] = 'Definir entradas MX';
$lng['dns']['standardmx'] = 'Servidor MX padrão';
$lng['dns']['mxconfig'] = 'Registros MX personalizados';
$lng['dns']['priority10'] = 'Prioridade 10';
$lng['dns']['priority20'] = 'Prioridade 20';
$lng['dns']['txtrecords'] = 'Difinir entradas TXT';
$lng['dns']['txtexample'] = 'Exemplo (Entrada-SPF):<br />v=spf1 ip4:xxx.xxx.xx.0/23 -all';
$lng['serversettings']['selfdns']['title'] = 'Configurações DNS-Domiio personalizadas';
$lng['serversettings']['selfdnscustomer']['title'] = 'Aceita clientes para editar configurações de DNS';
$lng['admin']['activated'] = 'Ativado';
$lng['admin']['statisticsettings'] = 'Configurações de Estatísticas';
$lng['admin']['or'] = 'ou';
$lng['serversettings']['unix_names']['title'] = 'Usar nomes compatíveis com UNIX';
$lng['serversettings']['unix_names']['description'] = 'Aceita voce usar <strong>-</strong> and <strong>_</strong> em nomes de usuários se <strong>No</strong>estiver marcado';
$lng['error']['cannotwritetologfile'] = 'Não pode abrir arquivo de log %s para escrita';
$lng['admin']['sysload'] = 'Carga do Sistema';
$lng['admin']['noloadavailable'] = 'Não disponível';
$lng['admin']['nouptimeavailable'] = 'Não disponível';
$lng['panel']['backtooverview'] = 'Voltar para Visão Geral';
$lng['admin']['nosubject'] = '(Sem Assunto)';
$lng['admin']['configfiles']['statistics'] = 'Estatísticas';
$lng['login']['forgotpwd'] = 'Perdeu sua senha?';
$lng['login']['presend'] = 'Resetar senha';
$lng['login']['email'] = 'Endereço de E-mail';
$lng['login']['remind'] = 'Resetar minha senha';
$lng['login']['usernotfound'] = 'Úsuario não encontrado';
$lng['pwdreminder']['subject'] = 'Froxlor - Reset de Senha';
$lng['pwdreminder']['body'] = 'Oi %s,\n\nsua senha do Froxlor foi resetada!\nA nova senha é: %p\n\nObrigado,\nequipe Froxlor';
$lng['pwdreminder']['success'] = 'Redefinição de senha com sucesso. <br /> Você agora deve receber um e-mail com sua nova senha.';
$lng['serversettings']['allow_password_reset']['title'] = 'Aceita reset de senha por clientes';
$lng['pwdreminder']['notallowed'] = 'Reset de senhas está desativado';
$lng['customer']['title'] = 'Título';
$lng['customer']['country'] = 'País';
$lng['panel']['dateformat'] = 'AAAA-MM-DD';
$lng['panel']['dateformat_function'] = 'A-m-d';
$lng['panel']['timeformat_function'] = 'H:i:S';
$lng['panel']['default'] = 'Padrão';
$lng['panel']['never'] = 'Nunca';
$lng['panel']['active'] = 'Ativo';
$lng['panel']['please_choose'] = 'Por favor escolha';
$lng['panel']['allow_modifications'] = 'Aceita alteraçoes';
$lng['domains']['add_date'] = 'Adicionado no Froxlor';
$lng['domains']['registration_date'] = 'Adicionado no Registro';
$lng['domains']['topleveldomain'] = 'Top-Level-Domain';
$lng['admin']['accountdata'] = 'Data da Conta';
$lng['admin']['contactdata'] = 'Data de Contato';
$lng['admin']['servicedata'] = 'Data de Serviço';
$lng['serversettings']['allow_password_reset']['description'] = 'Os clientes podem redefinir sua senha e  serão enviadas para seu endereço de e-mail';
$lng['serversettings']['allow_password_reset_admin']['title'] = 'Ativa reset de senhas pelos administradores';
$lng['serversettings']['allow_password_reset_admin']['description'] = 'Admins / Revendedor pode redefinir sua senha e a nova senha será enviada para seu endereço de e-mail';
$lng['panel']['not_supported'] = 'Não suportado em:';
$lng['menue']['email']['autoresponder'] = 'Auto-Responder';
$lng['autoresponder']['active'] = 'Ativar';
$lng['autoresponder']['autoresponder_add'] = 'Adicionar Auto-Responder';
$lng['autoresponder']['autoresponder_edit'] = 'Edita Auto-Responder';
$lng['autoresponder']['autoresponder_new'] = 'Criar novo Auto-Responder';
$lng['autoresponder']['subject'] = 'Assunto';
$lng['autoresponder']['message'] = 'Mensagem';
$lng['autoresponder']['account'] = 'Aconta';
$lng['autoresponder']['sender'] = 'Remetente';
$lng['question']['autoresponderdelete'] = 'Você deseja apagar o auto-responder?';
$lng['error']['noemailaccount'] = 'Pode haver duas razões pelas quais você não pode criar uma nova resposta automática: Você precisará de pelo menos um e-mail para criar um novo utilitário de resposta automática. Em segundo lugar, pode ser possível que todas as contas já tenham uma resposta automática configuradas';
$lng['error']['missingfields'] = 'Nem todos os campos necessários estavam no campo.';
$lng['error']['accountnotexisting'] = 'Esta conta não existe.';
$lng['error']['autoresponderalreadyexists'] = 'Já existe um auto-responder configurado para esta conta.';
$lng['error']['invalidautoresponder'] = 'Esta determinada está inválida.';
$lng['serversettings']['autoresponder_active']['title'] = 'Usar módulo de auto-responder';
$lng['serversettings']['autoresponder_active']['description'] = 'Você deseja utilizar o módulo do auto-responder?';
$lng['admin']['security_settings'] = 'Opções de Segurança';
$lng['admin']['know_what_youre_doing'] = 'Somente altere, se você sabe o que está fazendo';
$lng['admin']['show_version_login']['title'] = 'Mostrar versão do Froxlor no login';
$lng['admin']['show_version_login']['description'] = 'Mostar a versão do Froxlor no rodapé da página de login';
$lng['admin']['show_version_footer']['title'] = 'Mostar versão do Froxlor no rodapé';
$lng['admin']['show_version_footer']['description'] = 'Mostar a versão do Froxlor no rodapé do resto das páginas';
$lng['admin']['froxlor_graphic']['title'] = 'Cabeçalho gráfico do Froxlor';
$lng['admin']['froxlor_graphic']['description'] = 'Quais gráficos devem aparece no topor';
$lng['menue']['phpsettings']['maintitle'] = 'Configurações do PHP';
$lng['admin']['phpsettings']['title'] = 'Configurações do PHP';
$lng['admin']['phpsettings']['description'] = 'Descrição';
$lng['admin']['phpsettings']['actions'] = 'Ações';
$lng['admin']['phpsettings']['activedomains'] = 'Em uso pelo(s) domínio(s)';
$lng['admin']['phpsettings']['notused'] = 'Configuração não está em uso';
$lng['admin']['misc'] = 'Variados';
$lng['admin']['phpsettings']['editsettings'] = 'Alterar Configuração do PHP';
$lng['admin']['phpsettings']['addsettings'] = 'Criar novas configurações do PHP';
$lng['admin']['phpsettings']['viewsettings'] = 'Visualizar Configuração do PHP';
$lng['admin']['phpsettings']['phpinisettings'] = 'Configurações do php.ini';
$lng['error']['nopermissionsorinvalidid'] = 'Você não tem permissões suficientes para alterar essa configuração ou um ID inválido foi dado.';
$lng['panel']['view'] = 'Visualizar';
$lng['question']['phpsetting_reallydelete'] = 'Você realmente deseja apagar esta configuração? Todos os domínios que atualmente utilizam esta configuração serão alterada para a configuração padrão.';
$lng['admin']['phpsettings']['addnew'] = 'Criar novas configurações';
$lng['error']['phpsettingidwrong'] = 'Não existe uma configuração de PHP para este ID';
$lng['error']['descriptioninvalid'] = 'A descrição é muito curta, muito longa ou contem carácters ilegais';
$lng['error']['info'] = 'Iinformações';
$lng['admin']['phpconfig']['template_replace_vars'] = 'As variáveis que serão substituídas nas Configurações';
$lng['admin']['phpconfig']['safe_mode'] = 'Vai ser substituído pelas configurações seguras deste domínios.';
$lng['admin']['phpconfig']['pear_dir'] = 'Serão substituídos com a definição global para o diretório pear.';
$lng['admin']['phpconfig']['open_basedir'] = 'Serão substituídos com a definição do domínio open_basedir.';
$lng['admin']['phpconfig']['tmp_dir'] = 'Substituído com o diretório temporário do domínio.';
$lng['admin']['phpconfig']['open_basedir_global'] = 'Serão substituídos com o valor global do caminho que será anexado ao open_basedir.';
$lng['admin']['phpconfig']['customer_email'] = 'Serão substituídos com o endereço de e-mail do cliente que é dono desse domínio.';
$lng['admin']['phpconfig']['admin_email'] = 'Serão substituídos por e-mail do administrador quem possui esse domínio.';
$lng['admin']['phpconfig']['domain'] = 'Serão substituídos com o domínio.';
$lng['admin']['phpconfig']['customer'] = 'Será substituída pelo nome do login do cliente que é dono desse domínio.';
$lng['admin']['phpconfig']['admin'] = 'Será substituída pelo nome de login do administrador que possui esse domínio.';
$lng['login']['backtologin'] = 'Voltar ao Login';
$lng['serversettings']['mod_fcgid']['starter']['title'] = 'Processos por domínio';
$lng['serversettings']['mod_fcgid']['starter']['description'] = 'Quantos processos devem ser iniciadas / permitidas por domínio? O valor 0 é recomendado. O PHP irá então gerir a quantidade de processos.';
$lng['serversettings']['mod_fcgid']['wrapper']['title'] = 'Wrapper in Vhosts';
$lng['serversettings']['mod_fcgid']['wrapper']['description'] = 'Como os  wrapper vão ser incluídos nos vhosts';
$lng['serversettings']['mod_fcgid']['tmpdir']['description'] = 'Aonde os arquivos temporários devem ser guardados';
$lng['serversettings']['mod_fcgid']['peardir']['title'] = 'Diretórios globais do PEAR';
$lng['serversettings']['mod_fcgid']['peardir']['description'] = 'Diretórios globais do PEAR que deverão ser substituídos em cada configuração php.ini? Diferentes diretórios devem ser separados por dois pontos.';
$lng['admin']['templates']['index_html'] = 'Indice de arquivo recém-criado no diretório de cliente';
$lng['admin']['templates']['SERVERNAME'] = 'Substitua pelo nome do servidor.';
$lng['admin']['templates']['CUSTOMER'] = 'Substitua pelo login do cliente.';
$lng['admin']['templates']['ADMIN'] = 'Substitua pelo login do admin.';
$lng['admin']['templates']['CUSTOMER_EMAIL'] = 'Substitua pelo endereço de email do cliente.';
$lng['admin']['templates']['ADMIN_EMAIL'] = 'Substitua pelo endereço de email do administrador.';
$lng['admin']['templates']['filetemplates'] = 'Modelo de Arquivo';
$lng['admin']['templates']['filecontent'] = 'Conteúdo do Arquivo';
$lng['error']['filecontentnotset'] = 'O arquivo não pode ser vazio';
$lng['serversettings']['index_file_extension']['description'] = 'Qual extensão deve ser utilizada para o índice no arquivo recém-criado no diretório do cliente? Esta extensão será utilizado, se você ou um de seus administradores criou o seu próprio índice no arquivo modelo.';
$lng['serversettings']['index_file_extension']['title'] = 'Extensão do arquivo recém-criado no Ãndice do diretório do cliente.';
$lng['error']['index_file_extension'] = 'A extensão do índice do arquivo deve ficar entre 1 e 6 caracteres. A prorrogação só pode conter caracteres como az, AZ e 0-9';
$lng['admin']['expert_settings'] = 'Configurações Avançadas';
$lng['admin']['mod_fcgid_starter']['title'] = 'Processos PHP para este domínio (vazio para usar valor padrão)';
$lng['admin']['aps'] = 'APS Instalado';
$lng['customer']['aps'] = 'Instalador do APS';
$lng['aps']['scan'] = 'Procurar por novos pacotes';
$lng['aps']['upload'] = 'Atualizar novos pacotes';
$lng['aps']['managepackages'] = 'Gerenciar Pacotes';
$lng['aps']['manageinstances'] = 'Gerenciar Estâncias';
$lng['aps']['overview'] = 'Resumo de Pacote';
$lng['aps']['status'] = 'Meus Pacotes';
$lng['aps']['search'] = 'Procurar por Pacotes';
$lng['aps']['upload_description'] = 'Por favor seleciona o instalador APS (zipfiles) para istalar no sistema';
$lng['aps']['search_description'] = 'Nome, Descrição, Palavra Chave, Versão';
$lng['aps']['detail'] = 'Mais informação';
$lng['aps']['install'] = 'Pacote de Instalação';
$lng['aps']['data'] = 'Data';
$lng['aps']['version'] = 'Versão';
$lng['aps']['homepage'] = 'Homepage';
$lng['aps']['installed_size'] = 'Tamanho após instalação';
$lng['aps']['categories'] = 'Categorias';
$lng['aps']['languages'] = 'Línguas';
$lng['aps']['long_description'] = 'Descrição Longa';
$lng['aps']['configscript'] = 'Configuração de Script';
$lng['aps']['changelog'] = 'Log de Alterações';
$lng['aps']['license'] = 'Licença';
$lng['aps']['license_link'] = 'Caminho para Licença';
$lng['aps']['screenshots'] = 'Screenshots';
$lng['aps']['back'] = 'Voltar para Visão Geral';
$lng['aps']['install_wizard'] = 'Assistente de Instalação';
$lng['aps']['wizard_error'] = 'Yocê preencheu com dados inválidos. Por favor corrija você mesmo para continuar a instalação';
$lng['aps']['basic_settings'] = 'Configurações Básicas';
$lng['aps']['application_location'] = 'Local de Instalação';
$lng['aps']['application_location_description'] = 'Local aonde a aplicação vai ser instalada';
$lng['aps']['no_domains'] = 'Domínios não encontrados';
$lng['aps']['database_password'] = 'Senha de Banco de Dados';
$lng['aps']['database_password_description'] = 'Senha que deve ser utilizada para novos bancos de dados';
$lng['aps']['license_agreement'] = 'Contrato';
$lng['aps']['cancel_install'] = 'Cancelar Instalação';
$lng['aps']['notazipfile'] = 'O arquivo de upload não é um arquivo .zip';
$lng['aps']['filetoobig'] = 'O arquivo é muito grande';
$lng['aps']['filenotcomplete'] = 'O arquivo não foi enviado corretamente';
$lng['aps']['phperror'] = 'Ocorreu um erro interno no PHP. O código de erro é #';
$lng['aps']['moveproblem'] = 'O script falhou em fazer o upload dos arquivos para diretório de destino. Por favor tenha certeza de que as permissões estão setadas corretamente.';
$lng['aps']['uploaderrors'] = '<strong>Erros de Arquivo <em>%s</em></strong><br/><ul>%s</ul>';
$lng['aps']['nospecialchars'] = 'Sarácters especiais não são aceitos nos termos de pesquisa';
$lng['aps']['noitemsfound'] = 'Nenhum pacote foi encontrado';
$lng['aps']['nopackagesinstalled'] = 'Você não tem nenhum pacote instalado.';
$lng['aps']['instance_install'] = 'Pendência de Instalação de Pacote';
$lng['aps']['instance_task_active'] = 'Instalação está em execução neste momento';
$lng['aps']['instance_success'] = 'Pacote está instalado corretamente';
$lng['aps']['instance_error'] = 'Pacote não está instalado corretamente, erros ocorreram durante a instalação';
$lng['aps']['instance_uninstall'] = 'Pendência de Desinstalação de Pacotes';
$lng['aps']['unknown_status'] = 'Erro, valor desconhecido';
$lng['aps']['currentstatus'] = 'Status Atual';
$lng['aps']['activetasks'] = 'Status de Tarejas';
$lng['aps']['task_install'] = 'Instalação pendente';
$lng['aps']['task_remove'] = 'Desinstação pendente';
$lng['aps']['task_reconfigure'] = 'Reconfiguração Pendente';
$lng['aps']['task_upgrade'] = 'Atualizar pendência';
$lng['aps']['no_task'] = 'Sem tarefas pendentes';
$lng['aps']['applicationlinks'] = 'Links de Aplicações';
$lng['aps']['mainsite'] = 'Site Principal';
$lng['aps']['uninstall'] = 'Desinstalar Pacote';
$lng['aps']['reconfigure'] = 'Alterar configurações';
$lng['aps']['erroronnewinstance'] = '<strong>Este pacote não pode ser instalado.</strong><br/><br/>Por favor volte a visualização de pacotes e comece uma nova instalação.';
$lng['aps']['successonnewinstance'] = '<strong><em>%s</em> vai ser instalado agora.</strong><br/><br/>Volte para "Meus Pacotes" e espere a instalação acabar. Isto pode demorar alguns minutos.';
$lng['aps']['php_misc_handler'] = 'PHP - Não tem suporte para outras extensões além de .php .';
$lng['aps']['php_misc_directoryhandler'] = 'PHP - Não tem suporte para diretórios.';
$lng['aps']['asp_net'] = 'ASP.NET - Pacote não suportado';
$lng['aps']['cgi'] = 'CGI - Pacote não suportado';
$lng['aps']['php_extension'] = 'Extensão PHP "%s" missing';
$lng['aps']['php_function'] = 'Função PHP "%s" missing';
$lng['aps']['php_configuration'] = 'Configuração de PHP atual "%s" não suportado pelo pacote';
$lng['aps']['php_configuration_post_max_size'] = 'Configuração do PHP - "post_max_size" valor muito baixo';
$lng['aps']['php_configuration_memory_limit'] = 'Configuração do PHP - "memory_limit" valor muito baixo';
$lng['aps']['php_configuration_max_execution_time'] = 'Configuração do PHP - "max_execution_time" valor muito baixo';
$lng['aps']['php_general_old'] = 'PHP - Geral - Versão do PHP Muito Antiga';
$lng['aps']['php_general_new'] = 'PHP - Geral - Versão do PHP Muito Nova';
$lng['aps']['db_mysql_support'] = 'Base de Dados - Este pacote precisa outra base de dados do que MySQL';
$lng['aps']['db_mysql_version'] = 'Base de Dados - Servidor MySQL é muito antigo';
$lng['aps']['webserver_module'] = 'Servidor Web - Módulo "%s" não encontrado';
$lng['aps']['misc_configscript'] = 'Misc - A linguagem de configuração do script não é suportadaützt.';
$lng['aps']['misc_version_already_installed'] = 'A mesma versão do pacote já está instalada.';
$lng['aps']['misc_version_already_installed'] = 'Mesma versão de pacote instalado.';
$lng['aps']['misc_only_newer_versions'] = 'Por razões de segurança somente pacotes instalados podem ser reinstalados e atualizados.';
$lng['aps']['erroronscan'] = '<strong>Erros para <em>%s</em></strong><ul>%s</ul>';
$lng['aps']['invalidzipfile'] = '<strong>Erros para <em>%s</em></strong><br/><ul><li>Este não é um pacote valido de APS compactado!</li></ul>';
$lng['aps']['successpackageupdate'] = '<strong><em>%s</em> Pacote atualizado com sucesso</strong>';
$lng['aps']['successpackageinstall'] = '<strong><em>%s</em> Novo pacote instalado com sucesso</strong>';
$lng['aps']['class_zip_missing'] = 'SimpleXML Class, funções exec ou funções ZIP podem estar perdidas ou desabilitadas! Para futuras informações sobre este problema procure no manual sobre este módulo';
$lng['aps']['dir_permissions'] = 'O PHP/Servidor Web tem que estar apto em escrever nos diretórios /var/www/froxlor/temp/ e /var/www/froxlor/packages/';
$lng['aps']['initerror'] = '<strong>Foi encontrado erros neste módulo:</strong><ul>%s</ul>Corrija o problema, ou o módulo não poderá ser usado!';
$lng['aps']['iderror'] = 'ID incorretamente especificado';
$lng['aps']['nopacketsforinstallation'] = 'Nenhum para para instalar';
$lng['aps']['nopackagestoinstall'] = 'Nenhum pacote para visualizar ou instalar';
$lng['aps']['nodomains'] = 'Seleciona um domínio da lisa. Se não tiver nenhum, o pacote não pode ser instalado';
$lng['aps']['wrongpath'] = 'Either this path contains invalid characters or there is another application installed already.';
$lng['aps']['dbpassword'] = 'Especifique uma senha com um mínimo de 8 carácters';
$lng['aps']['error_text'] = 'Especifique um texto sem carácters especiais';
$lng['aps']['error_email'] = 'Especifique um endereço de e-mail válido';
$lng['aps']['error_domain'] = 'Especifique uma URL válida como http://www.exemplo.com/';
$lng['aps']['error_integer'] = 'Especifique um valor númerico (Formato-Integer)';
$lng['aps']['error_float'] = 'Especifique um valor númerico (Formato-Float)';
$lng['aps']['error_password'] = 'Especifique uma senha';
$lng['aps']['error_license'] = 'Yes, I have the license and will abide by its terms.';
$lng['aps']['error_licensenoaccept'] = 'Você deve aceitar a licença de instalação desta aplicação';
$lng['aps']['stopinstall'] = 'Cancelar Instalação';
$lng['aps']['installstopped'] = 'A instalação deste pacote foi cancelada com sucesso';
$lng['aps']['installstoperror'] = 'A instalação não pode ser abortada porque a instalação já foi iniciada. Se você deseja remover o pacote, primeiro esperer instalar, depois remova-o em "Meus Pacotes".';
$lng['aps']['waitfortask'] = 'Não tem opções para selecionar. Espere o final de todas as tarefas para terminar';
$lng['aps']['removetaskexisting'] = '<strong>Existe uma tarefa para desinstação.</strong><br/><br/>Por favor volte para "Meus Pacotes" e espere terminar.';
$lng['aps']['packagewillberemoved'] = '<strong>O pacote vai ser desinstalado agora.</strong><br/><br/>Por favor volte para "Meus Pacotes" e espere terminar.';
$lng['question']['reallywanttoremove'] = '<strong>Você realmente deseja desinstalar este pacote?</strong><br/><br/>Todo conteúdo de banco de dados e arquivo irá ser apagado. Tenha certeza que você tem o backup para uso futuro!<br/><br/>';
$lng['aps']['searchoneresult'] = '%s pacote achado';
$lng['aps']['searchmultiresult'] = '%s pacotes achados';
$lng['question']['reallywanttostop'] = 'Você deseja cancelar a instalação deste pacote?';
$lng['aps']['packagenameandversion'] = 'Nome do Pacote & Versão';
$lng['aps']['package_locked'] = 'Destrava';
$lng['aps']['package_enabled'] = 'Trava';
$lng['aps']['lock'] = 'Trava';
$lng['aps']['unlock'] = 'Destrava';
$lng['aps']['remove'] = 'Remover';
$lng['aps']['allpackages'] = 'Todos os pacotes';
$lng['question']['reallyremovepackages'] = '<strong>Do you really want to delete this packages?</strong><br/><br/>Packages with dependencies can only be remove if the corresponding Instances have been removed!<br/><br/>';
$lng['aps']['nopackagesinsystem'] = 'There were no packages installed in the system which could be managed.';
$lng['aps']['packagenameandstatus'] = 'Nome do Pacote & Status';
$lng['aps']['activate_aps']['title'] = 'A\'tiva instalados APS';
$lng['aps']['activate_aps']['description'] = 'Aqui o instalador do APS pode ser ativado ou desativado globalmente';
$lng['aps']['packages_per_page']['title'] = 'Pacotes por página';
$lng['aps']['packages_per_page']['description'] = 'Quantos pacotes devem aparecer por página para os clientes ';
$lng['aps']['upload_fields']['title'] = 'Upload de campos por página';
$lng['aps']['upload_fields']['description'] = 'Quantos campos devem aparecer por página para a instalação de novos pacotes no sistema?';
$lng['aps']['exceptions']['title'] = 'Exceção para validação de pacote';
$lng['aps']['exceptions']['description'] = 'Some packages need special configuration parameters or modules. The Installer cannot always determine if this options/extensions are available. For this reason you can now define exceptions that packages can be installed in the system. Do only select options which match your real configuration setup. For further information about this problem look into the handbook for this module.';
$lng['aps']['settings_php_extensions'] = 'Extensões do PHP';
$lng['aps']['settings_php_configuration'] = 'Configuração do PHP';
$lng['aps']['settings_webserver_modules'] = 'Módulos do Webserver';
$lng['aps']['settings_webserver_misc'] = 'Servidor Web Variados';
$lng['aps']['specialoptions'] = 'Opções Especiais';
$lng['aps']['removeunused'] = 'Remover pacotes não usados';
$lng['aps']['enablenewest'] = 'Ativa nova versão de pacote, tranca outras';
$lng['aps']['installations'] = 'Instalações';
$lng['aps']['statistics'] = 'Estatísticas';
$lng['aps']['numerofpackagesinstalled'] = '%s pacotes instalados';
$lng['aps']['numerofpackagesenabled'] = '%s pacotes ativos';
$lng['aps']['numerofpackageslocked'] = '%s Pacotes Trancados';
$lng['aps']['numerofinstances'] = '%s Instalação de todos<br/>';
$lng['question']['reallydoaction'] = '<strong>Do you really want to execute the selected actions?</strong><br/><br/>Data which can be lost by continuing, cannot be restored later.<br/><br/>';
$lng['aps']['linktolicense'] = 'Caminho para Licença';
$lng['aps']['initerror_customer'] = 'Existe um problema com esta extensão do Froxlor. Contate seu administrador para maiores informações.';
$lng['aps']['numerofinstancessuccess'] = '%s instalações executadas';
$lng['aps']['numerofinstanceserror'] = '%s instalações falhadas';
$lng['aps']['numerofinstancesaction'] = '%s planejou instalações/desinstalações';
$lng['aps']['downloadallpackages'] = 'Fazer download de todos os pacotes da distribuição do servidor';
$lng['aps']['updateallpackages'] = 'Atualizar todos os pacote pela distribuição do servidor';
$lng['aps']['downloadtaskexists'] = 'Existe downloads em andamento. Por favor espere terminar.';
$lng['aps']['downloadtaskinserted'] = 'Uma tarefa de download de fotos os pacotes foi criada. Esta tarefa pode demorar alguns minutos.';
$lng['aps']['updatetaskexists'] = 'Existe uma atualização em andamento. Por favor espere esta atualização terminar.';
$lng['aps']['updatetaskinserted'] = 'Uma tarefa para a atualização de todos os pacotes foi criado. Esta tarefa pode demorar alguns minutos.';
$lng['aps']['canmanagepackages'] = 'Pode gerenciar pacotes APS';
$lng['aps']['numberofapspackages'] = 'Quantia de instalações APS';
$lng['aps']['allpackagesused'] = '<strong>Erro</strong><br/><br/>Você já atingiu o número máximo de instalação de apliçações APS';
$lng['aps']['noinstancesexisting'] = 'Não existem estâncias para administrar.';
$lng['error']['customerdoesntexist'] = 'O cliente que você escolheu não existe';
$lng['error']['admindoesntexist'] = 'O administrador que você escolheu não existe';
$lng['serversettings']['system_realtime_port']['title'] = 'Porta para Froxlor em tempo real';
$lng['serversettings']['system_realtime_port']['description'] = 'Froxlor connects to this port at localhost everytime a new cron task is scheduled. If value is 0 (zero), this feature is disabled.<br />See also: <a target="blank" href="http://redmine.froxlor.org/projects/froxlor/wiki/En-realtime">Make Froxlor work in realtime (Froxlor Wiki)</a>';
$lng['serversettings']['session_allow_multiple_login']['title'] = 'AAtiva login múltiplo';
$lng['serversettings']['session_allow_multiple_login']['description'] = 'Se ativado um usuário pode ter múltiplos logins';
$lng['serversettings']['panel_allow_domain_change_admin']['title'] = 'Ativa mover domínios entre admins';
$lng['serversettings']['panel_allow_domain_change_admin']['description'] = 'If activated you can change the admin of a domain at domainsettings.<br /><b>Attention:</b> If a customer isn\'t assigned to the same admin as the domain, the admin can see every other domain of that customer!';
$lng['serversettings']['panel_allow_domain_change_customer']['title'] = 'Ativa mover domínios entre clientes';
$lng['serversettings']['panel_allow_domain_change_customer']['description'] = 'Se ativado você pode trocar o cliente de um domínio para administração de outro.<br /><b>Attention:</b> Froxlor não troca nenhum caminho. Isto pode fazer com que domínios parem de funcionar';
$lng['domains']['associated_with_domain'] = 'Associado';
$lng['domains']['aliasdomains'] = 'Encaminhamento de domínios';
$lng['error']['ipportdoesntexist'] = 'A combinação de IP/Porta que você escolheu não existe';
$lng['admin']['phpserversettings'] = 'Configuração do PHP';
$lng['admin']['phpsettings']['binary'] = 'Binário do PHP';
$lng['admin']['phpsettings']['file_extensions'] = 'Extensões de arquivos';
$lng['admin']['phpsettings']['file_extensions_note'] = '(Sem pontos, separados por espaços)';
$lng['admin']['mod_fcgid_maxrequests']['title'] = 'Máximo de requisições php para este domínio (vazio para valor default)';
$lng['serversettings']['mod_fcgid']['maxrequests']['title'] = 'Máximo de solicitações por Domínio';
$lng['serversettings']['mod_fcgid']['maxrequests']['description'] = 'Quantas solicitações serão aceitas por domínio?';

?>
