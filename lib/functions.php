<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, you can also view it online at
 * https://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  the authors
 * @author     Froxlor team <team@froxlor.org>
 * @license    https://files.froxlor.org/misc/COPYING.txt GPLv2
 */

use Froxlor\Language;
use Froxlor\UI\Request;

/**
 * Render a template with the given data.
 * Mostly used if we have no template-engine (twig).
 *
 * @param $template
 * @param $attributes
 * @return array|false|string|string[]
 */
function view($template, $attributes)
{
	$view = file_get_contents(dirname(__DIR__) . '/templates/' . $template);

	return str_replace(array_keys($attributes), array_values($attributes), $view);
}

/**
 * Get the current translation for a given string.
 *
 * @param string $identifier
 * @param array $arguments
 * @return array|string
 */
function lng(string $identifier, array $arguments = [])
{
	return Language::getTranslation($identifier, $arguments);
}

/**
 * Get the value of a request variable.
 *
 * @param string $identifier
 * @param string|null $default
 * @param string|null $session
 * @return mixed|string|null
 */
function old(string $identifier, string $default = null, string $session = null)
{
	if ($session && isset($_SESSION[$session])) {
		return $_SESSION[$session][$identifier] ?? $default;
	}
	return Request::any($identifier, $default);
}

/**
 * Loading the mix manifest file from given theme.
 * This file contains the hashed filenames of the assets.
 * It must be always placed in the theme assets folder.
 *
 * @param $filename
 * @return mixed|string
 */
function mix($filename)
{
	if (preg_match('/templates\/(.+)\/assets\/(.+)\/(.+)/', $filename, $matches)) {
		$mixManifest = dirname(__DIR__) . '/templates/' . $matches[1] . '/assets/mix-manifest.json';
		if (file_exists($mixManifest)) {
			$manifest = json_decode(file_get_contents($mixManifest), true);
			$key = '/' . $matches[2] . '/' . $matches[3];
			if ($manifest && !empty($manifest[$key])) {
				$filename = 'templates/' . $matches[1] . '/assets' . $manifest[$key];
			}
		}
	}
	return $filename;
}
