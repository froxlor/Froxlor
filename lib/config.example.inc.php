<?php

/**
 * change the options below to either true or false
 */
return [
	/**
	 * enable/disable the possibility to update froxlor from within the web-interface,
	 * recommended value for debian/ubuntu package users is false to rely on apt and not have version mixup.
	 * This is also useful for providers that manage the servers but give admin access to froxlor to handle
	 * updates the way the providers does it (e.g. automation, etc.)
	 *
	 * Default: false
	 */
	'enable_webupdate' => false,

	/**
	 * settings that have a major impact on the system or which values are used to be executed with high
	 * privileges on the system require the admin-user to have set up and enabled OTP for the corresponding
	 * account to change these values.
	 * To disable this extra security validation, set the value of this to true
	 *
	 * Default: false
	 */
	'disable_otp_security_check' => false,

	/**
	 * For debugging/development purposes only.
	 * Enable to display all php related issue (notices, warnings, etc.; depending on php.ini) for froxlor itself
	 *
	 * Default: false
	 */
	'display_php_errors' => false,
];
