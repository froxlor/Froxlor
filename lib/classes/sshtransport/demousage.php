<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Panel
 * @version    $Id$
 *
 * This file is for demonstration purpose and should NEVER be enabled
 * in a live enviroment.
 * 
 */
exit();

/* get a FroxlorSshTransport Object with plain password authentication
 * Note: to get this working you have to enable plain password authentication in 
 *       your sshd config!
 */
$transport = FroxlorSshTransport::usePlainPassword("test.froxlor.org", 22, "testSshUser", "plainpassword");

/*
 * Send a command to the ssh shell.
 */

$transport->sendCmd("ls -alF");

/*
 * The return result is an array with lines read from stdin
 */
$outputArray = $transport->readAll();

/*
 * Let's copy our sshd_config to the remote host.
 */
$transport->sendFile("/etc/ssh/sshd_config", "/etc/ssh/sshd_config", 0644);

/*
 * Close this session.
 */
$transport->close();

/*
 * Create a new ssh session with pubkey authentication.
 */
$transport = FroxlorSshTransport::usePublicKey("test.froxlor.org", 22, "testUserSSh", "/path/to/pubkey.key", "/path/to/private.key", "myPassphrase1337");

/*
 * Clean up and finish.
 */
$transport->close();


/*
 * *********************************************************************************************************************
 * 
 * Demousage about deploying
 */

/*
 * create a file list and save it internaly
 */
FroxlorDeployfileCreator::createList(
	array(
		"/var/www/froxlor/lib/",
		"/var/www/froxlor/lng/",
		"/var/www/froxlor/scripts/",
		"/var/www/froxlor/actions/",
		"/var/www/froxlor/templates/"
	)
);

/*
 * save it to disk file
 */
FroxlorDeployfileCreator::saveListTo("deploy.txt");

/*
 * and create a zip archive
 */
new FroxlorPkgCreator("deploy.txt", "deploy.zip");
