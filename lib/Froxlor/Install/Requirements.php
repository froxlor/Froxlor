<?php

namespace Froxlor\Install;

class Requirements
{
	const REQUIRED_VERSION = '7.4.0';
	const REQUIRED_EXTENSIONS = ['session', 'ctype', 'xml', 'filter', 'posix', 'mbstring', 'pdo_mysql', 'curl', 'gmp', 'json', 'gd'];
	const SUGGESTED_EXTENSIONS = ['bcmath', 'zip', 'gnupg'];
}
