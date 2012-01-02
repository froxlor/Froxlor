<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2011- the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Froxlor team <team@froxlor.org> (2011-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Classes
 *
 */

/**
 *
 * @property-write bool $useBrowser Determine if the browser should be used to detect the language
 */
class languageSelect
{
	/**
	 * Shall the browser be used to determine the language?
	 * @var bool
	 */
	private $useBrowser = true;

	/**
	 * The default language to be used if the chosen one is not working
	 * @var string
	 */
	private $defaultLanguage = 'en';

	/**
	 * All available languages shipped with Froxlor
	 * @var array Containing all languages available in Froxlor
	 */
	private $availableLanguages = array();

	/**
	 * All really working languages (codepage exists, Froxlor ships .mo .- file)
	 * @var array Containing all working languages, indexed by availableLanguages
	 */
	private $workingLanguages = array();

	/**
	 * The currently used language
	 * @var string
	 */
	private $selectedLanguage = 'en';

	/**
	 * Constructor for the class
	 * Here we search which languages are shipped with Froxlor and which ones are actually working
	 */
	public function __construct()
	{
		// Search for all available languages in 'locales'
		if ($handle = opendir('./locales/'))
		{
			$files = array();
			// Loop through the directory
			while(false!==($file = readdir($handle)))
			{
				// If there is a directory and it's not '.' or '..', it's a language
				if (is_dir('./locales/' . $file) && !preg_match('/^\.\.?$/', $file))
				{
					$files[] = $file;
				}
			}
			closedir($handle);
			sort($files);
			$this->availableLanguages = $files;
		}

		# See for which language the codepages are compiled
		foreach ($this->availableLanguages as $lang)
		{
			$tmplng = array();
			@exec("locale -a", $tmplng);
			$tmplng = join("\n", $tmplng);
			preg_match_all("/[^|\w]".$lang.'.*/', $tmplng, $matches);
			foreach($matches[0] as $m)
			{
				if(preg_match('/utf8/', $m))
				{
					$this->workingLanguages[$lang] = trim($m);
					break;
				}
			}
		}
	}

	/**
	 * Set the gettext - variables needed to a chosen language
	 *
	 * This function either tries to find a suitable language for the users browser
	 * (if $userBrowser is true) and sets the language to the desired one. A language given
	 * as a parameter overrides the "automagic" and forces the given language.
	 * If the desired language is not within workingLanguages, the fallback will be used
	 *
	 * @param string $lang An optional language to be forced, if it's not working, the default language will be used
	 * @return bool|string The used language if successful, otherwise "false"
	 */
	public function setLanguage($lang = '')
	{
		setLocale(LC_ALL,'en_US.utf8');
		bindtextdomain('default','./locales/');
		textdomain('default');
		if (!empty($lang))
		{
			if (isset($this->workingLanguages[$lang]))
			{
				return setLocale(LC_ALL, $this->workingLanguages[$this->selectedLanguage]);
			}
			else
			{
				return false;
			}
		}

		# Get Browser - languages
		if ($this->useBrowser)
		{
			$ls = array();
			if (!isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
			{
				$_SERVER['HTTP_ACCEPT_LANGUAGE'] = '';
			}
			$langs = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
			foreach($langs as $lang)
			{
				if (in_array(preg_replace('/;.*/','',trim($lang)), $this->availableLanguages))
				{
					$this->selectedLanguage = preg_replace('/;.*/','',trim($lang));
					break;
				}
			}

		}

		// Let's try the original language selected
		if(setLocale(LC_ALL, $this->selectedLanguage))
		{
			// Worked, okay, no more work needed
			return true;
		}

		// Okay, let's hope we have a working language with another name for the selected one
		if (isset($this->workingLanguages[$this->selectedLanguage]))
		{
			return setLocale(LC_ALL, $this->workingLanguages[$this->selectedLanguage]);
		}
		return false;
	}

	/**
	 * Get all working languages
	 *
	 * This will return an array indexed by availableLanguages which are actually working
	 * Languages which are available but where gettext can't be used because of missing
	 * compiled codepage are not returned at all
	 *
	 * @return array All languages found to be working
	 */
	public function getWorkingLanguages()
	{
		return $this->workingLanguages;
	}

	/**
	 * Get all available languages
	 *
	 * This will return an arraywhich contains all languages Froxlor ships. Please note:
	 * It does not mean, that all languages are really working {@link getWorkingLanguages()}
	 *
	 * @return array All languages shipped by Froxlor
	 */
	public function getAvailableLanguages()
	{
		return $this->availableLanguages;
	}

	public function __set($varname, $value)
	{
		switch ($varname)
		{
			case "useBrowser":
				$this->useBrowser = ($value === false) ? false : true;
				return true;
				break;
		}
		return false;
	}
}
