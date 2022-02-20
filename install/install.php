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
 * @author     Michael Kaufmann <mkaufmann@nutime.de>
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Install
 *
 */
// define default theme for configurehint, etc.
$_deftheme = 'Froxlor';

function view($template, $attributes) {
    $view = file_get_contents(dirname(__DIR__) . '/templates/' . $template);

    return str_replace(array_keys($attributes), array_values($attributes), $view);
}

// validate correct php version
if (version_compare("7.4.0", PHP_VERSION, ">=")) {
    die(
        view($_deftheme . '/misc/phprequirementfailed.html.twig', [
            '{{ basehref }}' => '../',
            '{{ froxlor_min_version }}' => '7.4.0',
            '{{ current_version }}' => PHP_VERSION,
            '{{ current_year }}' => date('Y', time()),
        ])
    );
}

// validate vendor autoloader
if (!file_exists(dirname(__DIR__) . '/vendor/autoload.php')) {
    die(
        view($_deftheme . '/misc/vendormissinghint.html.twig', [
            '{{ basehref }}' => '../',
            '{{ froxlor_install_dir }}' => dirname(__DIR__),
            '{{ current_year }}' => date('Y', time()),
        ])
    );
}

require dirname(__DIR__) . '/vendor/autoload.php';
require __DIR__ . '/lib/class.FroxlorInstall.php';

use Froxlor\UI\Panel\UI;

UI::initTwig(true);
UI::twig()->addGlobal('install_mode', '1');
UI::twig()->addGlobal('basehref', '../');

$frxinstall = new FroxlorInstall();
$frxinstall->run();

UI::twigOutputBuffer();
