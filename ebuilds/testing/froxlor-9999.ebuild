# Copyright 1999-2010 Gentoo Foundation
# Distributed under the terms of the GNU General Public License v2
# $Header: $

EAPI="2"

inherit eutils depend.php

if [[ ${PV} == "9999" ]] ; then
	ESVN_REPO_URI="http://svn.froxlor.org/trunk"
	ESVN_PROJECT="froxlor"
	inherit subversion
	#KEYWORDS=""
else
	SRC_URI="http://files.froxlor.org/releases/tgz/${PN}-${PV}.tar.gz"
	KEYWORDS="~amd64 ~x86"
fi

DESCRIPTION="A PHP-based webhosting-oriented control panel for servers."
HOMEPAGE="http://www.froxlor.org/"
LICENSE="GPL-2"
SLOT="0"
IUSE="aps autoresponder bind domainkey dovecot fcgid lighttpd +log mailquota ssl +tickets"

DEPEND="
	>=mail-mta/postfix-2.4[mysql,ssl=]
	sys-process/vixie-cron
	dev-db/mysql
	dev-lang/php[bcmath,cli,ctype,filter,ftp,gd,mysql,nls,pcre,posix,session,simplexml,ssl=,tokenizer,xml,xsl,zlib]
	net-ftp/proftpd[mysql,ssl=]
	app-admin/webalizer
	bind? ( net-dns/bind
		domainkey? ( mail-filter/dkim-milter )
	)
	ssl? ( dev-libs/openssl )
	lighttpd? ( www-servers/lighttpd[fastcgi,php,ssl=] )
	!lighttpd? ( www-servers/apache[ssl=]
		     dev-lang/php[apache2]
	)
	fcgid? ( dev-lang/php[cgi,force-cgi-redirect]
		 sys-auth/libnss-mysql
			( !lighttpd? (
				www-server/apache[suexec]
				www-apache/mod_fcgid )
			)
	)
	dovecot? ( net-mail/dovecot[mysql,pop3d,ssl=]
		   >=mail-mta/postfix-2.4[dovecot-sasl]
	)
	!dovecot? ( dev-libs/cyrus-sasl[crypt,mysql,ssl=]
		    net-libs/courier-authlib[crypt,mysql]
		    net-mail/courier-imap
		    >=mail-mta/postfix-2.4[sasl]
	)
	aps? ( dev-lang/php[zip]
		( amd64? ( app-arch/unzip ) )
	)
	mailquota? ( >=mail-mta/postfix-2.4[vda] )"

RDEPEND="${DEPEND}"

# we need that to set the standardlanguage later
LANGS="bg ca cs de da en es fr hu it nl pt ru se sl zh_CN"
for X in ${LANGS} ; do
	IUSE="${IUSE} linguas_${X}"
done

need_php5_httpd
need_php5_cli

S="${WORKDIR}/${PN}"

src_unpack() {
	if [[ ${PV} == "9999" ]] ; then
		subversion_src_unpack
	else
		unpack ${A}
	fi
	cd "${S}"
}
pkg_preinst() {
	# Create the user and group that will own the Froxlor files
	einfo "Creating froxlor user ..."
	enewgroup froxlor 9995
	enewuser froxlor 9995 -1 /var/www/froxlor froxlor

	# Create the user and group that will run the FTPd
	einfo "Creating froxlorftpd user ..."
	enewgroup froxlorftpd 9996
	enewuser froxlorftpd 9996 -1 /var/kunden/webs froxlorftpd

	# Create the user and group that will run the virtual MTA
	einfo "Creating vmail user ..."
	enewgroup vmail 9997
	enewuser vmail 9997 -1 /var/kunden/mail vmail
}

src_prepare() {
	# Delete any mention of inserttask('4') if no Bind is used
	if ! use bind ; then
		find "${S}/" -type f -exec sed -e "s|inserttask('4');||g" -i {} \;
	fi
}

src_install() {
	# set default language
	local MYLANG=""
	if useq linguas_bg ; then
		MYLANG="Bulgarian"
	elif useq linguas_ca ; then
		MYLANG="Catalan"
	elif useq linguas_cs ; then
		MYLANG="Czech"
	elif useq linguas_de ; then
		MYLANG="Deutsch"
	elif useq linguas_da ; then
		MYLANG="Danish"
	elif useq linguas_es ; then
		MYLANG="Espa&ntilde;ol"
	elif useq linguas_fr ; then
		MYLANG="Fran&ccedil;ais"
	elif useq linguas_hu ; then
		MYLANG="Hungarian"
	elif useq linguas_it ; then
		MYLANG="Italian"
	elif useq linguas_nl ; then
		MYLANG="Dutch"
	elif useq linguas_pt ; then
		MYLANG="Portugu&ecirc;s"
	elif useq linguas_ru ; then
		MYLANG="Russian"
	elif useq linguas_se ; then
		MYLANG="Swedish"
	elif useq linguas_sl ; then
		MYLANG="Slovak"
	elif useq linguas_zh_CN ; then
		MYLANG="Chinese"
	fi

	if [[ ${MYLANG} != '' ]] ; then
		einfo "Setting standardlanguage to '${MYLANG}'"
		sed -e "s|'standardlanguage', 'English'|'standardlanguage', '${MYLANG}'|g" -i "${S}/install/froxlor.sql" || die "Unable to change default language"
	fi

	# set lastguid to 10000
	einfo "Setting 'lastguid' to '10000'"
	sed -e "s|'lastguid', '9999'|'lastguid', '10000'|g" -i "${S}/install/froxlor.sql" || die "Unable to change lastguid"

	# set vmail uid/gid to 9997
	einfo "Setting 'vmail_uid' and 'vmail_gid' to '9997'"
	sed -e "s|'vmail_uid', '2000'|'vmail_uid', '9997'|g" -i "${S}/install/froxlor.sql" || die "Unable to change uid for user vmail"
	sed -e "s|'vmail_gid', '2000'|'vmail_gid', '9997'|g" -i "${S}/install/froxlor.sql" || die "Unable to change gid for user vmail"

	# set correct webserver reload
	if useq lighttpd; then
		einfo "Switching settings to fit 'lighttpd'"
		sed -e "s|/etc/init.d/apache reload|/etc/init.d/lighttpd restart|g" -i "${S}/install/froxlor.sql" || die "Unable to change webserver restart-command"
		sed -e "s|'webserver', 'apache2'|'webserver', 'lighttpd'|g" -i "${S}/install/froxlor.sql" || die "Unable to change webserver version"
		sed -e "s|'apacheconf_vhost', '/etc/apache/vhosts.conf'|'apacheconf_vhost', '/etc/lighttpd/froxlor-vhosts.conf'|g" -i "${S}/install/froxlor.sql" || die "Unable to change webserver vhost directory"
		sed -e "s|'apacheconf_diroptions', '/etc/apache/diroptions.conf'|'apacheconf_diroptions', '/etc/lighttpd/diroptions.conf'|g" -i "${S}/install/froxlor.sql" || die "Unable to change webserver diroptions file"
		sed -e "s|'apacheconf_htpasswddir', '/etc/apache/htpasswd/'|'apacheconf_htpasswddir', '/etc/lighttpd/htpasswd/'|g" -i "${S}/install/froxlor.sql" || die "Unable to change webserver htpasswd directory"
		sed -e "s|'httpuser', 'www-data'|'httpuser', 'lighttpd'|g" -i "${S}/install/froxlor.sql" || die "Unable to change webserver user"
		sed -e "s|'httpgroup', 'www-data'|'httpgroup', 'lighttpd'|g" -i "${S}/install/froxlor.sql" || die "Unable to change webserver group"
	else
		einfo "Switching settings to fit 'apache2'"
		sed -e "s|/etc/init.d/apache reload|/etc/init.d/apache2 reload|g" -i "${S}/install/froxlor.sql" || die "Unable to change webserver restart-command"
		sed -e "s|'apacheconf_vhost', '/etc/apache/vhosts.conf'|'apacheconf_vhost', '/etc/apache2/vhosts.d/99_froxlor-vhosts.conf'|g" -i "${S}/install/froxlor.sql" || die "Unable to change webserver vhost directory"
		sed -e "s|'apacheconf_diroptions', '/etc/apache/diroptions.conf'|'apacheconf_diroptions', '/etc/apache2/diroptions.conf'|g" -i "${S}/install/froxlor.sql" || die "Unable to change webserver diroptions file"
		sed -e "s|'apacheconf_htpasswddir', '/etc/apache/htpasswd/'|'apacheconf_htpasswddir', '/etc/apache2/htpasswd/'|g" -i "${S}/install/froxlor.sql" || die "Unable to change webserver htpasswd directory"
		sed -e "s|'httpuser', 'www-data'|'httpuser', 'apache'|g" -i "${S}/install/froxlor.sql" || die "Unable to change webserver user"
		sed -e "s|'httpgroup', 'www-data'|'httpgroup', 'apache'|g" -i "${S}/install/froxlor.sql" || die "Unable to change webserver group"
	fi

	# set mod_fcgid to "1" if it's wanted
	if useq fcgid && ! useq lighttpd ; then
		einfo "Switching 'fcgid' to 'On'"
		sed -e "s|'mod_fcgid', '0'|'mod_fcgid', '1'|g" -i "${S}/install/froxlor.sql" || die "Unable to set fcgid to 'On'"

		einfo "Setting wrapper to FCGIWrapper"
		sed -e "s|'mod_fcgid_wrapper', '0'|'mod_fcgid_wrapper', '1'|g" -i "${S}/install/froxlor.sql" || die "Unable to set fcgi-wrapper to 'FCGIWrapper'"

		einfo "Creating tmp-directory"
		dodir "/var/kunden/tmp"

		ewarn "You have to remove the '-D PHP5' entry from /etc/conf.d/apache2 if it exists!"
	fi

	# If Bind is not to be used, change the reload path for it
	if ! useq bind ; then
		einfo "Switching 'bind' to 'Off'"
		sed -e 's|/etc/init.d/named reload|/bin/true|g' -i "${S}/install/froxlor.sql" || die "Unable to change reload path for Bind"
	fi

	# default value is logging_enabled='1'
	if ! useq log ; then
		einfo "Switching 'log' to 'Off'"
		sed -e "s|'logger', 'enabled', '1'|'logger', 'enabled', '0'|g" -i "${S}/install/froxlor.sql" || die "Unable to set logging to 'Off'"
		# fix menu
		sed -e "s|'10', 'change_serversettings'|'10', 'logger.enabled'|g" -i "${S}/install/froxlor.sql" || die "Unable to fix logging menu-entry"
	fi

	# default value is tickets_enabled='1'
	if ! useq tickets ; then
		einfo "Switching 'tickets' to 'Off'"
		sed -e "s|'ticket', 'enabled', '1'|'ticket', 'enabled', '0'|g" -i "${S}/install/froxlor.sql" || die "Unable to set ticketsystem to 'Off'"
	fi

	# default value is mailquota='0'
	if useq mailquota ; then
		einfo "Switching 'mailquota' to 'On'"
		sed -e "s|'mail_quota_enabled', '0'|'mail_quota_enabled', '1'|g" -i "${S}/install/froxlor.sql" || die "Unable to set mailquota to 'On'"
	fi

	# default value is autoresponder='0'
	if useq autoresponder ; then
		einfo "Switching 'autoresponder' to 'On'"
		sed -e "s|'autoresponder_active', '0'|'autoresponder_active', '1'|g" -i "${S}/install/froxlor.sql" || die "Unable to set autoresponder to 'On'"
		# fix menu
		sed -e "s|40, 'autoresponder.autoresponder_active'|40, 'mails'|g" -i "${S}/install/froxlor.sql" || die "Unable to fix autoresponder menu-entry"
	fi

	# default value is dkim_enabled='0'
	if useq domainkey && useq bind ; then
		einfo "Switching 'domainkey' to 'On'"
		sed -e "s|'use_dkim', '0'|'use_dkim', '1'|g" -i "${S}/install/froxlor.sql" || die "Unable to set domainkey to 'On'"

		einfo "Setting dkim-path to gentoo value"
		sed -e "s|'dkim_prefix', '/etc/postfix/dkim/'|'dkim_prefix', '/etc/mail/dkim-filter/'|g" -i "${S}/install/froxlor.sql" || die "Unable to set domainkey prefix"
	fi

	# default value is aps_enabled='0'
	if useq aps ; then
		einfo "Switching 'APS' to 'On'"
		sed -e "s|'aps_active', '0'|'aps_active', '1'|g" -i "${S}/install/froxlor.sql" || die "Unable to set aps to 'On'"
		# fix menu
		sed -e "s|'admin_aps.nourl', 45, 'aps.aps_active'|'admin_aps.nourl', 45, 'can_manage_aps_packages'|g" -i "${S}/install/froxlor.sql" || die "Unable to fix aps admin-menu-entry"
		sed -e "s|'customer_aps.nourl', 50, 'aps.aps_active'|'customer_aps.nourl', 50, 'phpenabled'|g" -i "${S}/install/froxlor.sql" || die "Unable to fix aps customer-menu-entry"

		# if aps is used we enable required features in the php-cli php.ini
		ewarn
		ewarn "Please run the following command in your shell to change the php-cli php.ini file for APS"
		ewarn
		ewarn "sed -ie \"s|allow_url_fopen = Off|allow_url_fopen = On|g\" -i \"/etc/php/cli-php5/php.ini\""
		ewarn
	fi

	# default value is ssl_enabled='1'
	if ! useq ssl ; then
		einfo "Switching 'SSL' to 'Off'"
		sed -e "s|'use_ssl','1'|'use_ssl','0'|g" -i "${S}/install/froxlor.sql" || die "Unable to set ssl to 'Off'"
	fi

	# Install the Froxlor files
	einfo "Installing Froxlor files"
	dodir /var/www
	cp -Rf "${S}/" "${D}/var/www/" || die "Installation of the Froxlor files failed"

	# Fix the permissions for the Froxlor files
	einfo "Fixing permission of Froxlor files"
	if useq lighttpd ; then
		fowners -R froxlor:lighttpd /var/www/froxlor
	else
		fowners -R froxlor:apache /var/www/froxlor
	fi
	if useq fcgid ; then
		if ! useq lighttpd ; then
			fownwers -R froxlor:froxlor /var/www/froxlor
		else
			einfo "lighttpd overwrites fcgid USE-flag!"
			#fowners froxlor:lighttpd /var/www/froxlor
		fi
		fperms 0750 /var/www/froxlor
	else
		if useq lighttpd ; then
			fowners -R froxlor:lighttpd /var/www/froxlor/{temp,packages}
		else
			fowners -R froxlor:apache /var/www/froxlor/{temp,packages}
		fi
	fi
	fperms 0775 /var/www/froxlor/{temp,packages}

	# Create the main directories for customer data
	dodir /var/kunden/webs
	dodir /var/kunden/mail
	fowners vmail:vmail /var/kunden/mail
	fperms 0750 /var/kunden/mail
	dodir /var/kunden/logs

}

pkg_postinst() {
	# we need to check if this is going to be an update or a fresh install!
	if [[ -f "${ROOT}/var/www/froxlor/lib/userdata.inc.php" ]] ; then
		elog "Froxlor is already installed on this system!"
		elog
		elog "In this case 'emerge --config' mustn't be executed!"
		elog "Any configurationfiles will stay untouched!"
		elog
		elog "Froxlor will update the database when you open"
		elog "it in your browser the first time after the update-process"
		sleep 2
	else
		elog "Please run 'emerge --config =${PF}' to continue with"
		elog "the basic setup of Gentoo-Froxlor, *after* you have"
		elog "setup your MySQL databases root user and password"
		elog "like the MySQL ebuild tells you to do."
	fi
}

pkg_config() {
	local proceedyesno1
	local servername
	local serverip
	local mysqlhost
	local mysqlaccesshost
	local mysqlrootuser
	local mysqlrootpw1
	local mysqlrootpw2
	local mysqlrootpw
	local mysqldbname
	local mysqlunprivuser
	local mysqlunprivpw1
	local mysqlunprivpw2
	local mysqlunprivpw
	local adminuser
	local adminpw1
	local adminpw2
	local adminpw
	local proceedyesno2

	ewarn "Gentoo-Froxlor Basic Configuration"
	echo
	einfo "This will setup Gentoo-Froxlor on your system, it will create and"
	einfo "populate the MySQL database, create and chmod the needed files"
	einfo "correctly and configure all services to work out-of-the-box"
	einfo "with Gentoo-Froxlor, using a sane default configuration, and"
	einfo "start them, along with creating the correct Gentoo-Froxlor Apache"
	einfo "VirtualHost for you."
	einfo "CAUTION: this will backup and then replace your services"
	einfo "configuration and restart them!"
	echo
	einfo "Do you want to proceed? [Y/N]"
	echo
	read -rp " > " proceedyesno1 ; echo
	if [[ ${proceedyesno1} == "Y" ]] || [[ ${proceedyesno1} == "y" ]] || [[ ${proceedyesno1} == "Yes" ]] || [[ ${proceedyesno1} == "yes" ]] ; then
		echo
	else
		echo
		die "User abort: not proceeding!"
	fi
	einfo "Enter the domain under wich Froxlor shall be reached, this normally"
	einfo "is the FQDN (Fully Qualified Domain Name) of your system."
	einfo "If you don't know the FQDN of your system, execute 'hostname -f'."
	einfo "This installscript will try to guess your FQDN automatically if"
	einfo "you leave this field blank, setting it to the output of 'hostname -f'."
	echo
	read -rp " > " servername ; echo
	echo
	if [[ ${servername} == "" ]] ; then
		servername=`hostname -f`
	fi
	einfo "Enter the IP address of your system, under wich all"
	einfo "websites shall then be reached. This must be the same"
	einfo "IP address the domain you inserted above points to."
	einfo "You *must* set this to your correct IP address."
	echo
	read -rp " > " serverip ; echo
	echo
	if [[ ${serverip} == "" ]] ; then
		die "Abort: need correct IP address!"
	fi
	einfo "Enter the IP address of the MySQL server, if the MySQL"
	einfo "server is on the same machine, enter 'localhost' or"
	einfo "simply leave the field blank."
	echo
	read -rp " > " mysqlhost ; echo
	echo
	if [[ ${mysqlhost} == "" ]] ; then
		mysqlhost="localhost"
	fi
	if [[ ${mysqlhost} == "localhost" ]] ; then
		mysqlaccesshost="localhost"
	else
		mysqlaccesshost="${serverip}"
	fi
	einfo "Enter the username of the MySQL root user."
	einfo "The default is 'root'."
	echo
	read -rp " > " mysqlrootuser ; echo
	echo
	if [[ ${mysqlrootuser} == "" ]] ; then
		mysqlrootuser="root"
	fi
	einfo "Enter the password of the MySQL root user."
	echo
	read -rsp " > " mysqlrootpw1 ; echo
	echo
	if [[ ${mysqlrootpw1} == "" ]] ; then
		die "Abort: please insert a valid password!"
	fi
	einfo "Confirm the password of the MySQL root user."
	echo
	read -rsp " > " mysqlrootpw2 ; echo
	echo
	if [[ ${mysqlrootpw2} == "" ]] ; then
		die "Abort: please insert a valid password!"
	fi
	if [[ ${mysqlrootpw1} != ${mysqlrootpw2} ]] ; then
		die "Abort: the two passwords don't match!"
	else
		mysqlrootpw="${mysqlrootpw1}"
	fi
	einfo "Enter the name of the database you want to"
	einfo "use for Froxlor. The default is 'froxlor'."
	einfo "CAUTION: any database with that name will"
	einfo "be dropped!"
	echo
	read -rp " > " mysqldbname ; echo
	echo
	if [[ ${mysqldbname} == "" ]] ; then
		mysqldbname="froxlor"
	fi
	einfo "Enter the username of the unprivileged"
	einfo "MySQL user you want Froxlor to use."
	einfo "The default is 'froxlor'."
	einfo "CAUTION: any user with that name will"
	einfo "be deleted!"
	echo
	read -rp " > " mysqlunprivuser ; echo
	echo
	if [[ ${mysqlunprivuser} == "" ]] ; then
		mysqlunprivuser="froxlor"
	fi
	einfo "Enter the password of the unprivileged"
	einfo "MySQL user."
	echo
	read -rsp " > " mysqlunprivpw1 ; echo
	echo
	if [[ ${mysqlunprivpw1} == "" ]] ; then
		die "Abort: please insert a valid password!"
	fi
	einfo "Confirm the password of the unprivileged"
	einfo "MySQL user."
	echo
	read -rsp " > " mysqlunprivpw2 ; echo
	echo
	if [[ ${mysqlunprivpw2} == "" ]] ; then
		die "Abort: please insert a valid password!"
	fi
	if [[ ${mysqlunprivpw1} != ${mysqlunprivpw2} ]] ; then
		die "Abort: the two passwords don't match!"
	else
		mysqlunprivpw="${mysqlunprivpw1}"
	fi
	einfo "Enter the username of the admin user you"
	einfo "want in your Froxlor panel."
	einfo "Default is 'admin'."
	echo
	read -rp " > " adminuser ; echo
	echo
	if [[ ${adminuser} == "" ]] ; then
		adminuser="admin"
	fi
	einfo "Enter the password of the Froxlor admin user."
	echo
	read -rsp " > " adminpw1 ; echo
	echo
	if [[ ${adminpw1} == "" ]] ; then
		die "Abort: please insert a valid password!"
	fi
	einfo "Confirm the password of the Froxlor admin user."
	echo
	read -rsp " > " adminpw2 ; echo
	echo
	if [[ ${adminpw2} == "" ]] ; then
		die "Abort: please insert a valid password!"
	fi
	if [[ ${adminpw1} != ${adminpw2} ]] ; then
		die "Abort: the two passwords don't match!"
	else
		adminpw="${adminpw1}"
	fi

	einfo "Adding MySQL server to 'default' runlevel ..."
	rc-update add mysql default

	einfo "(Re)Starting MySQL server ..."
	"${ROOT}/etc/init.d/mysql" restart

	einfo "Creating temporary work directory ..."
	rm -Rf "${ROOT}/tmp/froxlor-install-by-emerge"
	mkdir -p "${ROOT}/tmp/froxlor-install-by-emerge"
	chown root:0 "${ROOT}/tmp/froxlor-install-by-emerge"
	chmod 0700 "${ROOT}/tmp/froxlor-install-by-emerge"

	einfo "Preparing SQL database files ..."
	cp -f "${ROOT}/var/www/froxlor/install/froxlor.sql" "${ROOT}/tmp/froxlor-install-by-emerge/"
	chown root:0 "${ROOT}/tmp/froxlor-install-by-emerge/froxlor.sql"
	chmod 0600 "${ROOT}/tmp/froxlor-install-by-emerge/froxlor.sql"
	sed -e "s|SERVERNAME|${servername}|g" -i "${ROOT}/tmp/froxlor-install-by-emerge/froxlor.sql"
	sed -e "s|SERVERIP|${serverip}|g" -i "${ROOT}/tmp/froxlor-install-by-emerge/froxlor.sql"
	sed -e "s|'mysql_access_host', 'localhost'|'mysql_access_host', '${mysqlaccesshost}'|g" -i "${ROOT}/tmp/froxlor-install-by-emerge/froxlor.sql"

	touch "${ROOT}/tmp/froxlor-install-by-emerge/createdb.sql"
	echo "DROP DATABASE IF EXISTS MYSQL_DATABASE_NAME;
CREATE DATABASE MYSQL_DATABASE_NAME;
GRANT ALL PRIVILEGES ON MYSQL_DATABASE_NAME.* TO MYSQL_UNPRIV_USER@MYSQL_ACCESS_HOST IDENTIFIED BY 'password';
SET PASSWORD FOR MYSQL_UNPRIV_USER@MYSQL_ACCESS_HOST = PASSWORD('MYSQL_UNPRIV_PASSWORD');
FLUSH PRIVILEGES;" > "${ROOT}/tmp/froxlor-install-by-emerge/createdb.sql"

	sed -e "s|MYSQL_ACCESS_HOST|${mysqlaccesshost}|g" -i "${ROOT}/tmp/froxlor-install-by-emerge/createdb.sql"
	sed -e "s|MYSQL_UNPRIV_USER|${mysqlunprivuser}|g" -i "${ROOT}/tmp/froxlor-install-by-emerge/createdb.sql"
	sed -e "s|MYSQL_UNPRIV_PASSWORD|${mysqlunprivpw}|g" -i "${ROOT}/tmp/froxlor-install-by-emerge/createdb.sql"
	sed -e "s|MYSQL_DATABASE_NAME|${mysqldbname}|g" -i "${ROOT}/tmp/froxlor-install-by-emerge/createdb.sql"

	einfo "Creating Froxlor database ..."
	mysql -u ${mysqlrootuser} -p${mysqlrootpw} < "${ROOT}/tmp/froxlor-install-by-emerge/createdb.sql"

	einfo "Installing SQL database files ..."
	mysql -u ${mysqlrootuser} -p${mysqlrootpw} ${mysqldbname} < "${ROOT}/tmp/froxlor-install-by-emerge/froxlor.sql"

	einfo "Adding system ip/port to database"
	touch "${ROOT}/tmp/froxlor-install-by-emerge/ipandport.sql"
	cat > "${ROOT}/tmp/froxlor-install-by-emerge/ipandport.sql" <<EOF
INSERT INTO \`panel_ipsandports\` (\`ip\`, \`port\`, \`namevirtualhost_statement\`) VALUES ('${serverip}', '80', '1');
EOF

	mysql -u ${mysqlrootuser} -p${mysqlrootpw} ${mysqldbname} < "${ROOT}/tmp/froxlor-install-by-emerge/ipandport.sql"

	einfo "Adding Froxlor admin-user"
	touch "${ROOT}/tmp/froxlor-install-by-emerge/admin.sql"
	cat > "${ROOT}/tmp/froxlor-install-by-emerge/admin.sql" <<EOF
INSERT INTO \`panel_admins\` SET
	\`loginname\` = '${adminuser}',
	\`password\` = MD5('${adminpw}'),
	\`name\` = 'Siteadmin',
	\`email\` = 'admin@${servername}',
	\`customers\` = -1,
	\`customers_used\` = 0,
	\`customers_see_all\` = 1,
	\`caneditphpsettings\` = 1,
	\`domains\` = -1,
	\`domains_used\` = 0,
	\`domains_see_all\` = 1,
	\`change_serversettings\` = 1,
	\`diskspace\` = -1024,
	\`diskspace_used\` = 0,
	\`mysqls\` = -1,
	\`mysqls_used\` = 0,
	\`emails\` = -1,
	\`emails_used\` = 0,
	\`email_accounts\` = -1,
	\`email_accounts_used\` = 0,
	\`email_forwarders\` = -1,
	\`email_forwarders_used\` = 0,
	\`email_quota\` = -1,
	\`email_quota_used\` = 0,
	\`ftps\` = -1,
	\`ftps_used\` = 0,
	\`tickets\` = -1,
	\`tickets_used\` = 0,
	\`subdomains\` = -1,
	\`subdomains_used\` = 0,
	\`traffic\` = -1048576,
	\`traffic_used\` = 0,
	\`deactivated\` = 0,
	\`aps_packages\` = -1;
EOF

	mysql -u ${mysqlrootuser} -p${mysqlrootpw} ${mysqldbname} < "${ROOT}/tmp/froxlor-install-by-emerge/admin.sql"

	einfo "Deleting SQL database files ..."
	rm -f "${ROOT}/tmp/froxlor-install-by-emerge/*.sql"

	einfo "Installing Froxlor data file ..."
	rm -f "${ROOT}/var/www/froxlor/lib/userdata.inc.php"
	touch "${ROOT}/var/www/froxlor/lib/userdata.inc.php"
	chmod 0440 "${ROOT}/var/www/froxlor/lib/userdata.inc.php"
	echo "<?php
//automatically generated userdata.inc.php for Froxlor
\$sql['host']='${mysqlhost}';
\$sql['user']='${mysqlunprivuser}';
\$sql['password']='${mysqlunprivpw}';
\$sql['db']='${mysqldbname}';
\$sql['root_user']='${mysqlrootuser}';
\$sql['root_password']='${mysqlrootpw}';
?>" > "${ROOT}/var/www/froxlor/lib/userdata.inc.php"

	if ! useq fcgid ; then
		if ! useq lighttpd ; then
			chown froxlor:apache "${ROOT}/var/www/froxlor/lib/userdata.inc.php"
		else
			chown froxlor:lighttpd "${ROOT}/var/www/froxlor/lib/userdata.inc.php"
		fi
	else
		if ! useq lighttpd ; then
			chown froxlor:froxlor "${ROOT}/var/www/froxlor/lib/userdata.inc.php"
		else
			# this stays as lighty doesn't use fcgid
			chown froxlor:lighttpd "${ROOT}/var/www/froxlor/lib/userdata.inc.php"
		fi
	fi

	if useq ssl ; then
		einfo "Creating needed SSL certificates ..."
		einfo "Please enter the correct input when it's requested."
		ewarn
		ewarn "ATTENTION: when you're requested to enter a"
		ewarn "'Common Name' enter ${servername} ."
		ewarn

		# Create the directories where we'll store our SSL
		# certificates and set secure permissions on them
		mkdir -p "${ROOT}/etc/ssl/server"
		chown root:0 "${ROOT}/etc/ssl/server"
		chmod 0700 "${ROOT}/etc/ssl/server"

		# We first generate our Private Key
		openssl genrsa -des3 -out "${ROOT}/etc/ssl/server/${servername}.key" 2048

		# Now we generate our CSR (Certificate Signing Request)
		openssl req -new -key "${ROOT}/etc/ssl/server/${servername}.key" -out "${ROOT}/etc/ssl/server/${servername}.csr"

		# Create an unencrypted key, to avoid having to always enter
		# the passphrase when a service using it is restarted (eg. Apache)
		cp -f "${ROOT}/etc/ssl/server/${servername}.key" "${ROOT}/etc/ssl/server/${servername}.key.orig"
		openssl rsa -in "${ROOT}/etc/ssl/server/${servername}.key.orig" -out "${ROOT}/etc/ssl/server/${servername}.key"

		einfo "You can now submit ${ROOT}/etc/ssl/server/${servername}.csr"
		einfo "to an official CA (Certification Authority) to be"
		einfo "signed (with costs) or you can sign it yourself (free)."
		einfo "For more informations regarding SSL please visit:"
		einfo "http://httpd.apache.org/docs/2.0/ssl/ssl_intro.html"

		echo
		einfo "Do you want to self-sign your certificate? [Y/N]"
		echo
		read -rp " > " proceedyesno2 ; echo
		if [[ ${proceedyesno2} == "Y" ]] || [[ ${proceedyesno2} == "y" ]] || [[ ${proceedyesno2} == "Yes" ]] || [[ ${proceedyesno2} == "yes" ]] ; then
			echo
			# We now generate a self-signed certificate that will
			# be valid for 365 days
			openssl x509 -req -days 365 -in "${ROOT}/etc/ssl/server/${servername}.csr" -signkey "${ROOT}/etc/ssl/server/${servername}.key" -out "${ROOT}/etc/ssl/server/${servername}.crt"

			# We now create a file that contains both the Private Key
			# and the signed certificate, this is needed for Courier
			cat "${ROOT}/etc/ssl/server/${servername}.crt" "${ROOT}/etc/ssl/server/${servername}.key" > "${ROOT}/etc/ssl/server/${servername}.pem"
		else
			einfo "Note: if you let your certificate be signed by an official"
			einfo "CA please be sure to copy the certificate they gave you to"
			einfo "${ROOT}/etc/ssl/server/${servername}.crt before starting"
			einfo "and using any of the SSL enabled services."
			echo
			einfo "You'll also need to create a file that contains both the"
			einfo "Private Key and the signed certificate, this is needed for"
			einfo "Courier to work correctly."
			einfo "You can do this with the following command:"
			einfo "cat \"${ROOT}/etc/ssl/server/${servername}.crt\" \"${ROOT}/etc/ssl/server/${servername}.key\" > \"${ROOT}/etc/ssl/server/${servername}.pem\""
			echo
			einfo "Additionally, don't forget to set the correct file permissions"
			einfo "on your SSL files, you can do this with the following commands:"
			einfo "chown root:0 \"${ROOT}/etc/ssl/server/${servername}.\"*"
			einfo "chmod 0400 \"${ROOT}/etc/ssl/server/${servername}.\"*"
		fi

		# Set secure permissions for our SSL files
		chown root:0 "${ROOT}/etc/ssl/server/${servername}."*
		chmod 0400 "${ROOT}/etc/ssl/server/${servername}."*
	fi

	einfo "Writing Gentoo-Froxlor vhost configuration ..."
	if useq lighttpd ; then
		rm -f "${ROOT}/etc/lighttpd/95_${servername}.conf"
		touch "${ROOT}/etc/lighttpd/95_${servername}.conf"
		chown root:0 "${ROOT}/etc/lighttpd/95_${servername}.conf"
		chmod 0600 "${ROOT}/etc/lighttpd/95_${servername}.conf"
	else
		rm -f "${ROOT}/etc/apache2/vhosts.d/95_${servername}.conf"
		touch "${ROOT}/etc/apache2/vhosts.d/95_${servername}.conf"
		chown root:0 "${ROOT}/etc/apache2/vhosts.d/95_${servername}.conf"
		chmod 0600 "${ROOT}/etc/apache2/vhosts.d/95_${servername}.conf"
	fi

	if useq lighttpd ; then
		einfo "Configuring lighttpd"
		rm -f "${ROOT}/etc/lighttpd/lighttpd.conf"
		cp -L "${ROOT}/var/www/froxlor/templates/misc/configfiles/gentoo/lighttpd/etc_lighttpd.conf" "${ROOT}/etc/lighttpd/lighttpd.conf"
		sed -e "s|<SERVERNAME>|${servername}|g" -i "${ROOT}/etc/lighttpd/lighttpd.conf"
		sed -e "s|<SERVERIP>|${serverip}|g" -i "${ROOT}/etc/lighttpd/lighttpd.conf"

		touch "${ROOT}/etc/lighttpd/froxlor-vhosts.conf"
		echo -e "\ninclude \"95_${servername}.conf\"" >> "${ROOT}/etc/lighttpd/lighttpd.conf"
		echo -e "\ninclude \"froxlor-vhosts.conf\"" >> "${ROOT}/etc/lighttpd/lighttpd.conf"

		echo -e "# Froxlor default vhost
\$HTTP[\"host\"] == \"${servername}\" {
	server.document-root = var.basedir + \"/froxlor\"
	server.name = \"${servername}\"" > "${ROOT}/etc/lighttpd/95_${servername}.conf"

		if useq ssl ; then
			echo -e "
	\$HTTP[\"scheme\"] == \"http\" {
		url.redirect = ( \"^/(.*)\" => \"https://${servername}/$1\" )
	}" >> "${ROOT}/etc/lighttpd/95_${servername}.conf"
		fi

		echo -e "
}" >> "${ROOT}/etc/lighttpd/95_${servername}.conf"

		if useq ssl ; then
		    echo -e "\n\$SERVER[\"socket\"] == \"${serverip}:443\" {
ssl.engine = \"enable\"
ssl.pemfile = \"${ROOT}etc/ssl/server/${servername}.pem\"
ssl.ca-file = \"${ROOT}etc/ssl/server/${servername}.pem\"
}" >> "${ROOT}/etc/lighttpd/lighttpd.conf"

		fi

		if useq perl ; then
		    echo -e "\nserver.modules += ("mod_cgi")" >> "${ROOT}/etc/lighttpd/lighttpd.conf"
		fi

	else
		einfo "Configuring apache2"
		if useq fcgid ; then
			# create php-starter file
			mkdir -p "${ROOT}/var/www/froxlor/php-fcgi-script"
			mkdir -p "${ROOT}/var/www/froxlor/php-fcgi-script/tmp"
			chmod 0750 "${ROOT}/var/www/froxlor/php-fcgi-script/tmp"
			touch "${ROOT}/var/www/froxlor/php-fcgi-script/php-fcgi-starter"
			echo "${FILESDIR}/php-fcgi-starter" >> "${ROOT}/var/www/froxlor/php-fcgi-script/php-fcgi-starter"
			chown froxlor:froxlor -R "${ROOT}/var/www/froxlor/php-fcgi-script" || die "Unable to fix owner for php-fcgi-script folder"
			chmod 0750 "${ROOT}/var/www/froxlor/php-fcgi-script/php-fcgi-starter"
			chattr +i "${ROOT}/var/www/froxlor/php-fcgi-script/php-fcgi-starter"
		fi

		if useq ssl ; then
			echo "# Gentoo-Froxlor SSL-enabled VirtualHost
<IfDefine SSL>
		<IfModule mod_ssl.c>
			<VirtualHost ${serverip}:443>
				DocumentRoot \"/var/www/froxlor\"
				ServerName ${servername}" >> "${ROOT}/etc/apache2/vhosts.d/95_${servername}.conf"

			echo "				ErrorLog /var/log/apache2/froxlor_ssl_error_log
				<IfModule mod_log_config.c>
					TransferLog /var/log/apache2/froxlor_ssl_access_log
				</IfModule>
				SSLEngine on
				SSLCipherSuite ALL:!ADH:!EXPORT56:RC4+RSA:+HIGH:+MEDIUM:+LOW:+SSLv2:+EXP:+eNULL
				SSLCertificateFile /etc/ssl/server/${servername}.crt
				SSLCertificateKeyFile /etc/ssl/server/${servername}.key
				<Files ~ \"\.(cgi|shtml|phtml|php?)$\">
					SSLOptions +StdEnvVars
				</Files>
				<IfModule mod_setenvif.c>
					SetEnvIf User-Agent \".*MSIE.*\" nokeepalive ssl-unclean-shutdown \\
					downgrade-1.0 force-response-1.0
				</IfModule>
				<IfModule mod_log_config.c>
					CustomLog /var/log/apache2/froxlor_ssl_request_log \\
					\"%t %h %{SSL_PROTOCOL}x %{SSL_CIPHER}x \\\"%r\\\" %b\"
				</IfModule>" >> "${ROOT}/etc/apache2/vhosts.d/95_${servername}.conf"

			if useq fcgid ; then
				echo "SuexecUserGroup \"froxlor\" \"froxlor\"
	<Directory \"/var/www/froxlor\">
		AddHandler fcgid-script .php
		FCGIWrapper /var/www/froxlor/php-fcgi-script/php-fcgi-starter .php
		Options +ExecCGI
</Directory>" >> "${ROOT}/etc/apache2/vhosts.d/95_${servername}.conf"

			else
				echo "	<Directory \"/var/www/froxlor\">
						Order allow,deny
						allow from all
					</Directory>" >> "${ROOT}/etc/apache2/vhosts.d/95_${servername}.conf"
			fi

			echo "
			</VirtualHost>
		</IfModule>
</IfDefine>

# Redirect to the SSL-enabled Gentoo-Froxlor vhost
<VirtualHost ${serverip}:80>
	RedirectPermanent / https://${servername}/index.php
</VirtualHost>" >> "${ROOT}/etc/apache2/vhosts.d/95_${servername}.conf"

		else

			echo "# Gentoo-Froxlor VirtualHost
	<VirtualHost ${serverip}:80>
		DocumentRoot \"/var/www/froxlor\"
		ServerName ${servername}" >> "${ROOT}/etc/apache2/vhosts.d/95_${servername}.conf"

			if useq fcgid ; then
				echo "SuexecUserGroup \"froxlor\" \"froxlor\"
	<Directory \"/var/www/froxlor\">
		AddHandler fcgid-script .php
		FCGIWrapper /var/www/froxlor/php-fcgi-script/php-fcgi-starter .php
		Options +ExecCGI
</Directory>" >> "${ROOT}/etc/apache2/vhosts.d/95_${servername}.conf"

			else
				echo "	<Directory \"/var/www/froxlor\">
						Order allow,deny
						allow from all
					</Directory>" >> "${ROOT}/etc/apache2/vhosts.d/95_${servername}.conf"
			fi

			echo "</VirtualHost>" >> "${ROOT}/etc/apache2/vhosts.d/95_${servername}.conf"
		fi
	fi

	if ! useq lighttpd ; then
		einfo "Fix general Apache configuration to work with Gentoo-Froxlor ..."
		sed -e "s|^\#ServerName localhost.*|ServerName ${servername}|g" -i "${ROOT}/etc/apache2/httpd.conf" || ewarn "Please make sure that the ServerName directive in ${ROOT}/etc/apache${USE_APACHE2}/httpd.conf is set to a valid value!"
		sed -e "s|^ServerAdmin root\@localhost.*|ServerAdmin root\@${servername}|g" -i "${ROOT}/etc/apache2/httpd.conf" || ewarn "Please make sure that the ServerAdmin directive in ${ROOT}/etc/apache${USE_APACHE2}/httpd.conf is set to a valid value!"
		sed -e "s|\*:80|${serverip}:80|g" -i "${ROOT}/etc/apache2/vhosts.d/00_default_vhost.conf" || ewarn "Please make sure the NameVirtualHost and VirtualHost directives in ${ROOT}/etc/apache${USE_APACHE2}/vhosts.d/00_default_vhost.conf are set to the Gentoo-Froxlor IP and Port 80!"
	fi

	if ! useq lighttpd ; then
		local DFCGID=""

		if useq fcgid ; then
			DFCGID="-D FCGID "
		else
			DFCGID=""
		fi

		# this is maybe automatically added to APACHE2_OPTS
		if [[ ${DFCGID} != "" ]] ; then
			einfo "Attempting to add FCGID to ${ROOT}/etc/conf.d/apache2 ..."
			sed -e "s|^APACHE2_OPTS=\"|APACHE2_OPTS=\"${DFCGID}|g" -i "${ROOT}/etc/conf.d/apache2" || ewarn "Unable to change APACHE2_OPTS in ${ROOT}/etc/conf.d/apache2, please change it manually to add '${DFCGID}'"
		fi
	fi

	# NSS-MySQL preparations
	if use fcgid ; then
		einfo "Modifying nsswitch.conf to use MySQL ..."
		sed -e "s|compat|compat mysql|g" -i "${ROOT}/etc/nsswitch.conf"
		rm -f "${ROOT}/etc/libnss-mysql.cfg"
		rm -f "${ROOT}/etc/libnss-mysql-root.cfg"
		cp -L "${ROOT}/var/www/froxlor/templates/misc/configfiles/gentoo/libnss/etc_libnss-mysql.cfg" "${ROOT}/etc/libnss-mysql.cfg"
		cp -L "${ROOT}/var/www/froxlor/templates/misc/configfiles/gentoo/libnss/etc_libnss-mysql-root.cfg" "${ROOT}/etc/libnss-mysql-root.cfg"

		sed -e "s|<SQL_DB>|${mysqldbname}|g" -i "${ROOT}/etc/libnss-mysql.cfg"
		sed -e "s|<SQL_HOST>|${mysqlaccesshost}|g" -i "${ROOT}/etc/libnss-mysql.cfg"
		sed -e "s|<SQL_UNPRIVILEGED_USER>|${mysqlunprivuser}|g" -i "${ROOT}/etc/libnss-mysql.cfg"
		sed -e "s|<SQL_UNPRIVILEGED_PASSWORD>|${mysqlunprivpw}|g" -i "${ROOT}/etc/libnss-mysql.cfg"

		sed -e "s|<SQL_UNPRIVILEGED_USER>|${mysqlunprivuser}|g" -i "${ROOT}/etc/libnss-mysql-root.cfg"
		sed -e "s|<SQL_UNPRIVILEGED_PASSWORD>|${mysqlunprivpw}|g" -i "${ROOT}/etc/libnss-mysql-root.cfg"
	fi

	einfo "Configuring ProFTPd ..."
	rm -f "${ROOT}/etc/proftpd/proftpd.conf"
	cp -L "${ROOT}/var/www/froxlor/templates/misc/configfiles/gentoo/proftpd/etc_proftpd_proftpd.conf" "${ROOT}/etc/proftpd/proftpd.conf"
	sed -e "s|<SERVERNAME>|${servername}|g" -i "${ROOT}/etc/proftpd/proftpd.conf"
	sed -e "s|<SQL_DB>|${mysqldbname}|g" -i "${ROOT}/etc/proftpd/proftpd.conf"
	sed -e "s|<SQL_HOST>|${mysqlaccesshost}|g" -i "${ROOT}/etc/proftpd/proftpd.conf"
	sed -e "s|<SQL_UNPRIVILEGED_USER>|${mysqlunprivuser}|g" -i "${ROOT}/etc/proftpd/proftpd.conf"
	sed -e "s|<SQL_UNPRIVILEGED_PASSWORD>|${mysqlunprivpw}|g" -i "${ROOT}/etc/proftpd/proftpd.conf"
	if useq ssl ; then
		sed -e "s|#<IfModule mod_tls.c>|<IfModule mod_tls.c>|g" -i "${ROOT}/etc/proftpd/proftpd.conf"
		sed -e "s|#TLSEngine|TLSEngine|g" -i "${ROOT}/etc/proftpd/proftpd.conf"
		sed -e "s|#TLSLog|TLSLog|g" -i "${ROOT}/etc/proftpd/proftpd.conf"
		sed -e "s|#TLSProtocol|TLSProtocol|g" -i "${ROOT}/etc/proftpd/proftpd.conf"
		sed -e "s|#TLSTimeoutHandshake|TLSTimeoutHandshake|g" -i "${ROOT}/etc/proftpd/proftpd.conf"
		sed -e "s|#TLSOptions|TLSOptions|g" -i "${ROOT}/etc/proftpd/proftpd.conf"
		sed -e "s|#TLSRSACertificateFile|TLSRSACertificateFile|g" -i "${ROOT}/etc/proftpd/proftpd.conf"
		sed -e "s|#TLSRSACertificateKeyFile|TLSRSACertificateKeyFile|g" -i "${ROOT}/etc/proftpd/proftpd.conf"
		sed -e "s|#TLSVerifyClient|TLSVerifyClient|g" -i "${ROOT}/etc/proftpd/proftpd.conf"
		sed -e "s|#TLSRequired|TLSRequired|g" -i "${ROOT}/etc/proftpd/proftpd.conf"
		sed -e "s|#</IfModule>|</IfModule>|g" -i "${ROOT}/etc/proftpd/proftpd.conf"
	fi
	chown root:0 "${ROOT}/etc/proftpd/proftpd.conf"
	chmod 0600 "${ROOT}/etc/proftpd/proftpd.conf"

	einfo "Configuring Gentoo-Froxlor cronjob ..."
	exeinto /etc/cron.d
	newexe "${FILESDIR}/froxlor.cron" froxlor

	if ! useq dovecot ; then
		einfo "Configuring Courier-IMAP ..."
		rm -f "${ROOT}/etc/courier/authlib/authdaemonrc"
		rm -f "${ROOT}/etc/courier/authlib/authmysqlrc"
		rm -f "${ROOT}/etc/courier-imap/pop3d"
		rm -f "${ROOT}/etc/courier-imap/imapd"
		rm -f "${ROOT}/etc/courier-imap/pop3d-ssl"
		rm -f "${ROOT}/etc/courier-imap/imapd-ssl"

		cp -L "${ROOT}/var/www/froxlor/templates/misc/configfiles/gentoo/courier/etc_courier_authlib_authdaemonrc" "${ROOT}/etc/courier/authlib/authdaemonrc"
		cp -L "${ROOT}/var/www/froxlor/templates/misc/configfiles/gentoo/courier/etc_courier_authlib_authmysqlrc" "${ROOT}/etc/courier/authlib/authmysqlrc"

		sed -e "s|<SQL_DB>|${mysqldbname}|g" -i "${ROOT}/etc/courier/authlib/authmysqlrc"
		sed -e "s|<SQL_HOST>|${mysqlaccesshost}|g" -i "${ROOT}/etc/courier/authlib/authmysqlrc"
		sed -e "s|<SQL_UNPRIVILEGED_USER>|${mysqlunprivuser}|g" -i "${ROOT}/etc/courier/authlib/authmysqlrc"
		sed -e "s|<SQL_UNPRIVILEGED_PASSWORD>|${mysqlunprivpw}|g" -i "${ROOT}/etc/courier/authlib/authmysqlrc"
		sed -e "s|<VIRTUAL_MAILBOX_BASE>|/var/kunden/mail|g" -i "${ROOT}/etc/courier/authlib/authmysqlrc"
		sed -e "s|<VIRTUAL_UID_MAPS>|9997|g" -i "${ROOT}/etc/courier/authlib/authmysqlrc"
		sed -e "s|<VIRTUAL_GID_MAPS>|9997|g" -i "${ROOT}/etc/courier/authlib/authmysqlrc"

		cp -L "${ROOT}/var/www/froxlor/templates/misc/configfiles/gentoo/courier/etc_courier-imap_pop3d" "${ROOT}/etc/courier-imap/pop3d"
		cp -L "${ROOT}/var/www/froxlor/templates/misc/configfiles/gentoo/courier/etc_courier-imap_imapd" "${ROOT}/etc/courier-imap/imapd"

		if useq ssl ; then
			cp -L "${ROOT}/var/www/froxlor/templates/misc/configfiles/gentoo/courier/etc_courier-imap_pop3d-ssl" "${ROOT}/etc/courier-imap/pop3d-ssl"
			cp -L "${ROOT}/var/www/froxlor/templates/misc/configfiles/gentoo/courier/etc_courier-imap_imapd-ssl" "${ROOT}/etc/courier-imap/imapd-ssl"

			sed -e "s|<SERVERNAME>|${servername}|g" -i "${ROOT}/etc/courier-imap/pop3d-ssl"
			sed -e "s|<SERVERNAME>|${servername}|g" -i "${ROOT}/etc/courier-imap/imapd-ssl"
		fi

		chown root:0 "${ROOT}/etc/courier/authlib/authdaemonrc"
		chown root:0 "${ROOT}/etc/courier/authlib/authmysqlrc"
		chown root:0 "${ROOT}/etc/courier-imap/pop3d"
		chown root:0 "${ROOT}/etc/courier-imap/imapd"
		if useq ssl ; then
			chown root:0 "${ROOT}/etc/courier-imap/pop3d-ssl"
			chown root:0 "${ROOT}/etc/courier-imap/imapd-ssl"
		fi
		chmod 0600 "${ROOT}/etc/courier/authlib/authdaemonrc"
		chmod 0600 "${ROOT}/etc/courier/authlib/authmysqlrc"
		chmod 0600 "${ROOT}/etc/courier-imap/pop3d"
		chmod 0600 "${ROOT}/etc/courier-imap/imapd"
		if useq ssl ; then
			chmod 0600 "${ROOT}/etc/courier-imap/pop3d-ssl"
			chmod 0600 "${ROOT}/etc/courier-imap/imapd-ssl"
		fi
	else
		einfo "Configuring Dovecot-IMAP ..."
		rm -f "${ROOT}/etc/dovecot/dovecot.conf"
		rm -f "${ROOT}/etc/dovecot/dovecot-sql.conf"

		cp -L "${ROOT}/var/www/froxlor/templates/misc/configfiles/gentoo/dovecot/etc_dovecot_dovecot.conf" "${ROOT}/etc/dovecot/dovecot.conf"
		cp -L "${ROOT}/var/www/froxlor/templates/misc/configfiles/gentoo/dovecot/etc_dovecot_dovecot-sql.conf" "${ROOT}/etc/dovecot/dovecot-sql.conf"

		if useq ssl ; then
			sed -e "s|<SSLPROTOCOLS>|imaps pop3s|g" -i "${ROOT}/etc/dovecot/dovecot.conf"
			sed -e "s|#ssl_cert_file|ssl_cert_file|g" -i "${ROOT}/etc/dovecot/dovecot.conf"
			sed -e "s|#ssl_key_file|ssl_key_file|g" -i "${ROOT}/etc/dovecot/dovecot.conf"
		else
			sed -e "s|<SSLPROTOCOLS>||g" -i "${ROOT}/etc/dovecot/dovecot.conf"
		fi

		sed -e "s|<postmaster-address>|root@${servername}|g" -i "${ROOT}/etc/dovecot/dovecot.conf"
		sed -e "s|<SERVERNAME>|${servername}|g" -i "${ROOT}/etc/dovecot/dovecot.conf"

		sed -e "s|<SQL_DB>|${mysqldbname}|g" -i "${ROOT}/etc/dovecot/dovecot-sql.conf"
		sed -e "s|<SQL_HOST>|${mysqlaccesshost}|g" -i "${ROOT}/etc/dovecot/dovecot-sql.conf"
		sed -e "s|<SQL_UNPRIVILEGED_USER>|${mysqlunprivuser}|g" -i "${ROOT}/etc/dovecot/dovecot-sql.conf"
		sed -e "s|<SQL_UNPRIVILEGED_PASSWORD>|${mysqlunprivpw}|g" -i "${ROOT}/etc/dovecot/dovecot-sql.conf"

		chown root:0 "${ROOT}/etc/dovecot/dovecot-sql.conf"
		chown root:0 "${ROOT}/etc/dovecot/dovecot-sql.conf"
		chmod 0600 "${ROOT}/etc/dovecot/dovecot-sql.conf"
		chmod 0600 "${ROOT}/etc/dovecot/dovecot-sql.conf"
	fi

	einfo "Configuring Postfix ..."
	rm -f "${ROOT}/etc/postfix/main.cf"
	cp -L "${ROOT}/var/www/froxlor/templates/misc/configfiles/gentoo/postfix/etc_postfix_main.cf" "${ROOT}/etc/postfix/main.cf"
	sed -e "s|<SERVERNAME>|${servername}|g" -i "${ROOT}/etc/postfix/main.cf"
	sed -e "s|<VIRTUAL_MAILBOX_BASE>|/var/kunden/mail|g" -i "${ROOT}/etc/postfix/main.cf"
	sed -e "s|<VIRTUAL_UID_MAPS>|9997|g" -i "${ROOT}/etc/postfix/main.cf"
	sed -e "s|<VIRTUAL_GID_MAPS>|9997|g" -i "${ROOT}/etc/postfix/main.cf"
	if useq dovecot ; then
		sed -e "s|#mailbox_command = /usr/libexec/dovecot/deliver|mailbox_command = /usr/libexec/dovecot/deliver|g" -i "${ROOT}/etc/postfix/main.cf"
		sed -e "s|#smtpd_sasl_type = dovecot|smtpd_sasl_type = dovecot|g" -i "${ROOT}/etc/postfix/main.cf"
		sed -e "s|#smtpd_sasl_path = private/auth|smtpd_sasl_path = private/auth|g" -i "${ROOT}/etc/postfix/main.cf"
		sed -e "s|#virtual_transport = dovecot|virtual_transport = dovecot|g" -i "${ROOT}/etc/postfix/main.cf"
		sed -e "s|#dovecot_destination_recipient_limit = 1|dovecot_destination_recipient_limit = 1|g" -i "${ROOT}/etc/postfix/main.cf"

		# add line to master.cf
		local MASTER_DOVECOT=""
		MASTER_DOVECOT=`cat ${ROOT}/var/www/froxlor/templates/misc/configfiles/gentoo/postfix/etc_postfix_master.cf`
		echo -e "\n${MASTER_DOVECOT}" >> "${ROOT}/etc/postfix/master.cf"
	fi
	if useq mailquota ; then
		cp -L "${ROOT}/var/www/froxlor/templates/misc/configfiles/gentoo/postfix/mysql-virtual_mailbox_limit_maps.cf" "${ROOT}/etc/postfix/mysql-virtual_mailbox_limit_maps.cf"
		sed -e "s|<SQL_DB>|${mysqldbname}|g" -i "${ROOT}/etc/postfix/mysql-virtual_mailbox_limit_maps.cf"
		sed -e "s|<SQL_HOST>|${mysqlaccesshost}|g" -i "${ROOT}/etc/postfix/mysql-virtual_mailbox_limit_maps.cf"
		sed -e "s|<SQL_UNPRIVILEGED_USER>|${mysqlunprivuser}|g" -i "${ROOT}/etc/postfix/mysql-virtual_mailbox_limit_maps.cf"
		sed -e "s|<SQL_UNPRIVILEGED_PASSWORD>|${mysqlunprivpw}|g" -i "${ROOT}/etc/postfix/mysql-virtual_mailbox_limit_maps.cf"

		sed -e "s|#virtual_transport = virtual|virtual_transport = virtual|g" -i "${ROOT}/etc/postfix/main.cf"
		sed -e "s|#virtual_create_maildirsize|virtual_create_maildirsize|g" -i "${ROOT}/etc/postfix/main.cf"
		sed -e "s|#virtual_mailbox_extended|virtual_mailbox_extended|g" -i "${ROOT}/etc/postfix/main.cf"
		sed -e "s|#virtual_mailbox_limit_inbox|virtual_mailbox_limit_inbox|g" -i "${ROOT}/etc/postfix/main.cf"
		sed -e "s|#virtual_mailbox_limit_maps|virtual_mailbox_limit_maps|g" -i "${ROOT}/etc/postfix/main.cf"
		sed -e "s|#virtual_maildir_limit_message|virtual_maildir_limit_message|g" -i "${ROOT}/etc/postfix/main.cf"
		sed -e "s|#virtual_overquota_bounce|virtual_overquota_bounce|g" -i "${ROOT}/etc/postfix/main.cf"

		chown root:postfix "${ROOT}/etc/postfix/mysql-virtual_mailbox_limit_maps.cf"
		chmod 0640 "${ROOT}/etc/postfix/mysql-virtual_mailbox_limit_maps.cf"
	fi
	if useq ssl ; then
		sed -e "s|<SERVERNAME>|${servername}|g" -i "${ROOT}/etc/postfix/main.cf"
		sed -e "s|#smtp_use_tls|smtp_use_tls|g" -i "${ROOT}/etc/postfix/main.cf"
		sed -e "s|#smtpd_tls_cert_file|smtpd_tls_cert_file|g" -i "${ROOT}/etc/postfix/main.cf"
		sed -e "s|#smtpd_tls_key_file|smtpd_tls_key_file|g" -i "${ROOT}/etc/postfix/main.cf"
		sed -e "s|#smtpd_tls_auth_only|smtpd_tls_auth_only|g" -i "${ROOT}/etc/postfix/main.cf"
		sed -e "s|#smtpd_tls_session_cache_timeout|smtpd_tls_session_cache_timeout|g" -i "${ROOT}/etc/postfix/main.cf"
		sed -e "s|#tls_random_source|tls_random_source|g" -i "${ROOT}/etc/postfix/main.cf"
	fi

	cp -L "${ROOT}/var/www/froxlor/templates/misc/configfiles/gentoo/postfix/etc_postfix_mysql-virtual_alias_maps.cf" "${ROOT}/etc/postfix/mysql-virtual_alias_maps.cf"
	cp -L "${ROOT}/var/www/froxlor/templates/misc/configfiles/gentoo/postfix/etc_postfix_mysql-virtual_mailbox_domains.cf" "${ROOT}/etc/postfix/mysql-virtual_mailbox_domains.cf"
	cp -L "${ROOT}/var/www/froxlor/templates/misc/configfiles/gentoo/postfix/etc_postfix_mysql-virtual_mailbox_maps.cf" "${ROOT}/etc/postfix/mysql-virtual_mailbox_maps.cf"

	sed -e "s|<SQL_DB>|${mysqldbname}|g" -i "${ROOT}/etc/postfix/mysql-virtual_alias_maps.cf"
	sed -e "s|<SQL_HOST>|${mysqlaccesshost}|g" -i "${ROOT}/etc/postfix/mysql-virtual_alias_maps.cf"
	sed -e "s|<SQL_UNPRIVILEGED_USER>|${mysqlunprivuser}|g" -i "${ROOT}/etc/postfix/mysql-virtual_alias_maps.cf"
	sed -e "s|<SQL_UNPRIVILEGED_PASSWORD>|${mysqlunprivpw}|g" -i "${ROOT}/etc/postfix/mysql-virtual_alias_maps.cf"
	sed -e "s|<SQL_DB>|${mysqldbname}|g" -i "${ROOT}/etc/postfix/mysql-virtual_mailbox_domains.cf"
	sed -e "s|<SQL_HOST>|${mysqlaccesshost}|g" -i "${ROOT}/etc/postfix/mysql-virtual_mailbox_domains.cf"
	sed -e "s|<SQL_UNPRIVILEGED_USER>|${mysqlunprivuser}|g" -i "${ROOT}/etc/postfix/mysql-virtual_mailbox_domains.cf"
	sed -e "s|<SQL_UNPRIVILEGED_PASSWORD>|${mysqlunprivpw}|g" -i "${ROOT}/etc/postfix/mysql-virtual_mailbox_domains.cf"
	sed -e "s|<SQL_DB>|${mysqldbname}|g" -i "${ROOT}/etc/postfix/mysql-virtual_mailbox_maps.cf"
	sed -e "s|<SQL_HOST>|${mysqlaccesshost}|g" -i "${ROOT}/etc/postfix/mysql-virtual_mailbox_maps.cf"
	sed -e "s|<SQL_UNPRIVILEGED_USER>|${mysqlunprivuser}|g" -i "${ROOT}/etc/postfix/mysql-virtual_mailbox_maps.cf"
	sed -e "s|<SQL_UNPRIVILEGED_PASSWORD>|${mysqlunprivpw}|g" -i "${ROOT}/etc/postfix/mysql-virtual_mailbox_maps.cf"

	chown root:postfix "${ROOT}/etc/postfix/mysql-virtual_alias_maps.cf"
	chown root:postfix "${ROOT}/etc/postfix/mysql-virtual_mailbox_domains.cf"
	chown root:postfix "${ROOT}/etc/postfix/mysql-virtual_mailbox_maps.cf"
	chmod 0640 "${ROOT}/etc/postfix/mysql-virtual_alias_maps.cf"
	chmod 0640 "${ROOT}/etc/postfix/mysql-virtual_mailbox_domains.cf"
	chmod 0640 "${ROOT}/etc/postfix/mysql-virtual_mailbox_maps.cf"

	if useq ! dovecot ; then
		rm -f "${ROOT}/etc/sasl2/smtpd.conf"
		cp -L "${ROOT}/var/www/froxlor/templates/misc/configfiles/gentoo/postfix/etc_sasl2_smtpd.conf" "${ROOT}/etc/sasl2/smtpd.conf"
		sed -e "s|<SQL_DB>|${mysqldbname}|g" -i "${ROOT}/etc/sasl2/smtpd.conf"
		sed -e "s|<SQL_HOST>|${mysqlaccesshost}|g" -i "${ROOT}/etc/sasl2/smtpd.conf"
		sed -e "s|<SQL_UNPRIVILEGED_USER>|${mysqlunprivuser}|g" -i "${ROOT}/etc/sasl2/smtpd.conf"
		sed -e "s|<SQL_UNPRIVILEGED_PASSWORD>|${mysqlunprivpw}|g" -i "${ROOT}/etc/sasl2/smtpd.conf"
		chown root:0 "${ROOT}/etc/sasl2/smtpd.conf"
		chmod 0600 "${ROOT}/etc/sasl2/smtpd.conf"
	fi

	if useq domainkey && useq bind ; then
		echo "${FILESDIR}/domainkey.conf" >> "${ROOT}/etc/postfix/main.cf"
	fi

	# Automatical Bind configuration, if Bind is installed
	if useq bind ; then
		einfo "Configuring Bind .."
		rm -f "${ROOT}/etc/bind/default.zone"
		cp -L "${ROOT}/var/www/froxlor/templates/misc/configfiles/gentoo/bind/etc_bind_default.zone" "${ROOT}/etc/bind/default.zone"
		sed -e "s|<SERVERIP>|${serverip}|g" -i "${ROOT}/etc/bind/default.zone"

		einfo "Add Gentoo-Froxlor include to Bind configuration ..."
		echo "include \"/etc/bind/froxlor_bind.conf\";" >> "${ROOT}/etc/bind/named.conf"
		touch "${ROOT}/etc/bind/froxlor_bind.conf"
		chown root:0 "${ROOT}/etc/bind/froxlor_bind.conf"
		chmod 0655 "${ROOT}/etc/bind/froxlor_bind.conf"
	fi

	srv_add_restart() {
		einfo "Adding ${1} to 'default' runlevel ..."
		rc-update add ${1} default
		einfo "(Re)Starting ${1} ..."
		"${ROOT}/etc/init.d/${1}" restart
	}

	# Automatical service starting

	sleep 2
	if useq lighttpd ; then
		srv_add_restart lighttpd
	else
		srv_add_restart apache2
	fi
	srv_add_restart vixie-cron
	if useq bind ; then
		srv_add_restart named
	fi
	srv_add_restart proftpd
	if ! useq dovecot ; then
		srv_add_restart courier-authlib
		srv_add_restart courier-pop3d
		srv_add_restart courier-imapd
		if useq ssl ; then
			srv_add_restart courier-pop3d-ssl
			srv_add_restart courier-imapd-ssl
		fi
	else
		srv_add_restart dovecot
	fi
	if useq domainkey && useq bind ; then
		srv_add_restart dkim-filter
	fi
	if useq fcgid ; then
		srv_add_restart nscd
	fi
	srv_add_restart postfix

	einfo "Configuration completed successfully!"
	einfo
	local URL=""
	if useq ssl ; then
		URL="https://${servername}/index.php"
	else
		URL="http://${servername}/index.php"
	fi
	einfo "You can now open your Froxlor under ${URL}"
}
