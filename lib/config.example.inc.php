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
	 */
	'enable_webupdate' => false,
];
