<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2016 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Oskar Eisemuth
 * @author     Froxlor team <team@froxlor.org> (2016-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Classes
 *
 */


class FroxlorPluginTemplate {
	private $pluginid;
	private $templatedir;
	
	public function __construct($id) {
		$this->pluginid = $id;
		$plugins = FroxlorPlugins::getInstance();
		$this->templatedir = $plugins->getPluginDir($this->pluginid).'templates/';
	}

	protected function _createTPLFunction($filename) {
		$innertpl = _checkAndParseTpl($filename);
		
		$regex_foreach = "#<foreach[ \t]*(?'loop'[^>]+)>(?'inner'(?:(?:[^<]*|<(?!foreach))|(?R))*)<\/foreach>#s";
		while(preg_match($regex_foreach, $innertpl)) {
			$innertpl = preg_replace_callback($regex_foreach, 
				function($m) { 
					$foreachcode = <<<EOT
"; foreach {$m['loop']} { \$_tpl_result .= "{$m['inner']}"; } \$_tpl_result .= "
EOT;
					return $foreachcode;
				}
			, $innertpl);
		}
		
// Note: To keep line numbers of eval in sync with tpl, keep anything on first line until $innertpl
$fnccode = <<<EOT
function(\$tpldata, \$lngplugin) { extract(\$tpldata, EXTR_REFS | EXTR_SKIP); extract(\$GLOBALS, EXTR_REFS | EXTR_SKIP); \$_tpl_result = "{$innertpl}";
	return \$_tpl_result;
};
EOT;
		$fnc = false;
		//echo '$fnc = '.$fnccode;
		eval('$fnc = '.$fnccode);
		return $fnc;
	}
	protected function _getTemplate($tplname) {
		if (file_exists($this->templatedir.$tplname.'.tpl')) {
			$output = $this->_createTPLFunction($this->templatedir.$tplname.'.tpl');
		} else {
			$output = getTemplate($tplname, 1);
		}
		return $output;
	}
	
	public function show($tplname, $tpldata = array()) {
		global $lng;
		if (file_exists($this->templatedir.$tplname.'.tpl')) {
			$fnc = $this->_createTPLFunction($this->templatedir.$tplname.'.tpl');
			echo $fnc($tpldata, $lng[$this->pluginid]);
		} else {
			$output = getTemplate($tplname, 1);
			extract($tpldata, EXTR_REFS | EXTR_SKIP);
		
			// As the template system require variables from the GLOBAL scope
			// Examples: $header, $footer, $linker
			extract($GLOBALS, EXTR_REFS | EXTR_SKIP);
			eval("echo \"" . $output . "\";");
		}
	}	
}
