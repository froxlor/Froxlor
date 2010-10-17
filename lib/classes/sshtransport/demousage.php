<?php
/**
 * This file is for demonstration purpose and should NEVER be enabled
 * in a live enviroment.
 * 
 * @version SVN: $Id: class.FroxlorModule.php 1167 2010-06-22 11:46:34Z d00p $
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
?>