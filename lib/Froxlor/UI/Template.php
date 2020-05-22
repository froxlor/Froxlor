<?php
namespace Froxlor\UI;

class Template
{

	/**
	 * returns an array for the settings-array
	 *
	 * @return array
	 */
	public static function getThemes()
	{
		$themespath = \Froxlor\FileDir::makeCorrectDir(\Froxlor\Froxlor::getInstallDir() . '/templates/');
		$themes_available = array();

		if (is_dir($themespath)) {
			$its = new \DirectoryIterator($themespath);

			foreach ($its as $it) {
				if ($it->isDir() && $it->getFilename() != '.' && $it->getFilename() != '..' && $it->getFilename() != 'misc') {
					$theme = $themespath . $it->getFilename();
					if (file_exists($theme . '/config.json')) {
						$themeconfig = json_decode(file_get_contents($theme . '/config.json'), true);
						if (array_key_exists('variants', $themeconfig) && is_array($themeconfig['variants'])) {
							foreach ($themeconfig['variants'] as $variant => $data) {
								if ($variant == "default") {
									$themes_available[$it->getFilename()] = $it->getFilename();
								} elseif (array_key_exists('description', $data)) {
									$themes_available[$it->getFilename() . '_' . $variant] = $data['description'];
								} else {
									$themes_available[$it->getFilename() . '_' . $variant] = $it->getFilename() . ' (' . $variant . ')';
								}
							}
						} else {
							$themes_available[$it->getFilename()] = $it->getFilename();
						}
					}
				}
			}
		}
		return $themes_available;
	}

	/**
	 * Get template from filesystem
	 *
	 * @param
	 *        	string Templatename
	 * @param
	 *        	string noarea If area should be used to get template
	 * @return string The Template
	 * @author Florian Lippert <flo@syscp.org>
	 */
	public static function getTemplate($template, $noarea = 0)
	{
		global $templatecache, $theme;

		$fallback_theme = 'Sparkle';

		if (! isset($theme) || $theme == '') {
			$theme = $fallback_theme;
		}

		if ($noarea != 1) {
			$template = AREA . '/' . $template;
		}

		if (! isset($templatecache[$theme][$template])) {

			$filename = \Froxlor\Froxlor::getInstallDir() . 'templates/' . $theme . '/' . $template . '.tpl';

			// check the current selected theme for the template
			$templatefile = self::checkAndParseTpl($filename);

			if ($templatefile == false && $theme != $fallback_theme) {
				// check fallback
				$_filename = \Froxlor\Froxlor::getInstallDir() . 'templates/' . $fallback_theme . '/' . $template . '.tpl';
				$templatefile = self::checkAndParseTpl($_filename);

				if ($templatefile == false) {
					// check for old layout
					$_filename = \Froxlor\Froxlor::getInstallDir() . 'templates/' . $template . '.tpl';
					$templatefile = self::checkAndParseTpl($_filename);

					if ($templatefile == false) {
						// not found
						$templatefile = 'TEMPLATE NOT FOUND: ' . $filename;
					}
				}
			}

			$output = $templatefile;
			$templatecache[$theme][$template] = $output;
		}

		return $templatecache[$theme][$template];
	}

	/**
	 * check whether a tpl file exists and if so, return it's content or else return false
	 *
	 * @param string $filename
	 *
	 * @return string|bool content on success, else false
	 */
	private static function checkAndParseTpl($filename)
	{
		$templatefile = "";

		if (file_exists($filename) && is_readable($filename)) {

			$templatefile = addcslashes(file_get_contents($filename), '"\\');

			// loop through template more than once in case we have an "if"-statement in another one
			while (preg_match('/<if[ \t]*(.*)>(.*)(<\/if>|<else>(.*)<\/if>)/Uis', $templatefile)) {
				$templatefile = preg_replace('/<if[ \t]*(.*)>(.*)(<\/if>|<else>(.*)<\/if>)/Uis', '".( ($1) ? ("$2") : ("$4") )."', $templatefile);
				$templatefile = str_replace('\\\\', '\\', $templatefile);
			}

			return $templatefile;
		}
		return false;
	}
}
