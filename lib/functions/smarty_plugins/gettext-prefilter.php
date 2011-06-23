<?php
/*
 Projectname:	Smarty gettext Prefilter
 Description:	A prefilter for smarty that will filter for {t}....{/t} blocks
		To use simply include this file after declaring the $smarty object
		or register the filter normally using a similar command as shown below

		The function expects a HAVE_GETTEXT define set to true to actually do any
		work with gettext.

		{t} supports 3 variables:
			domain - To change the gettext domain to use from the default one
			plural - To mark a block as having a plural and normal form.
				 Set plural to the plural version of the block, eg:
				 {t count=$files|@count plural="{$files} files"}One file{/t}
			escape - Escape the resulting string for either:
				 js (JavaScript), html (HTML entities), url (URL Encode)
				 Defaults to no escaping at all.

		This work is licensed under the Creative Commons Attribution 2.5 License.
		To view a copy of this license, visit http://creativecommons.org/licenses/by/2.5/
		or send a letter to Creative Commons, 543 Howard Street, 5th Floor, San Francisco,
		California, 94105, USA.

 		This file is distributed in the hope that it will be useful, but WITHOUT
 		ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 		FITNESS FOR A PARTICULAR PURPOSE.
*/

	$smarty->registerFilter('pre', 'smarty_prefilter_t');
	$smarty->registerFilter('post', 'smarty_postfilter_t');

	function smarty_prefilter_t($tpl_source, &$smarty) {
		/* find all {t} ... {/t} uses regex */
		$tpl_source = preg_replace_callback(
				'|{t([^}]*)}(.*?){/t}|s',
				'smarty_helper_gettext_block',
				$tpl_source
		);

		/* return our new tpl_source */
		return $tpl_source;
	}
	function smarty_postfilter_t($tpl_source, &$smarty) {
		return preg_replace('/<!--GETTEXT (.*?) \/GETTEXT-->/',	'<?'.'php echo $1 ?'.'>', $tpl_source);
	}

	function smarty_helper_gettext_block($matches)
	{
		/* the actual text is the 2nd submatch */
		$text = stripslashes($matches[2]);

		/* if we do not have gettext, just return the text itself */
		if (!HAVE_GETTEXT) return $text;

		/* build our params via the 1st submatch */
		$params = Array();
		if(!isset($param_matches))
		{
			$param_matches = '';
		}
		$num = preg_match_all(
			"|(\\w+)=([\"'])([^\\2]*)\\2|",
			$param_matches,
			$matches[2]
		);
		if ($num) foreach($param_matches AS $param) $params[$param[1]] = $param[3];

		// set domain if needed
		if (isset($params['domain']))
		{
			$domain = $params['domain'];
			unset($params['domain']);
		}

		// set escape mode
		if (isset($params['escape'])) {
			$escape = $params['escape'];
			unset($params['escape']);
		}

		// set plural version
		if (isset($params['plural'])) {
			$plural = $params['plural'];
			unset($params['plural']);

			// set count
			if (isset($params['count'])) {
				$count = $params['count'];
				unset($params['count']);
			}
		}

		$text = str_replace("'", "\'", $text);
		// use plural if required parameters are set
		if (isset($count) && isset($plural))
		{
			$text = isset($domain) ? "_dngettext('$domain', '$text', '$plural', '$count')" : "ngettext('$text', '$plural', '$count')";
		}
		else
		{ // use normal
			$text = isset($domain) ? "dgettext('$domain', '$text')" : "gettext('$text')";
		}

		// default to noescaping at all
		if (isset($escape)) {
			switch ($escape) {
				case 'javascript':
				case 'js':
					// javascript escape
					$text = str_replace('\'', '\\\'', stripslashes($text));
					break;
				case 'url':
					// url escape
					$text = urlencode($text);
					break;
				case 'html':
					$text = nl2br(htmlspecialchars($text));
			}
		}

		return '<!--GETTEXT ' . $text . '; /GETTEXT-->';
	}
?>