<?php

/**
 * froxlor php error handler
 *
 * @param int $errno
 * @param string $errstr
 * @param string $errfile
 * @param int $errline
 * @param array $errcontext
 *
 * @return void|boolean
 */
function phpErrHandler($errno, $errstr, $errfile, $errline, $errcontext) {

	if (!(error_reporting() & $errno)) {
		// This error code is not included in error_reporting
		return;
	}

	if (!isset($_SERVER['SHELL']) || (isset($_SERVER['SHELL']) && $_SERVER['SHELL'] == '')) {
		global $theme;

		// fallback
		if (empty($theme)) {
			$theme = "Sparkle";
		}
		// if we're not on the shell, output a nicer error-message
		$err_hint = file_get_contents(FROXLOR_INSTALL_DIR.'/templates/'.$theme.'/misc/phperrornice.tpl');
		// replace values
		$err_hint = str_replace("<TEXT>", '#'.$errno.' '.$errstr, $err_hint);
		$err_hint = str_replace("<DEBUG>", $errfile.':'.$errline, $err_hint);

		// show
		echo $err_hint;
		// return true to ignore php standard error-handler
		return true;
	}

	// of on shell, use the php standard error-handler
	return false;
}
