<?php

/**
 * This file is part of slick/mail package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once dirname(__DIR__).'/vendor/autoload.php';

// Set up Slick\Template location path
$path = __DIR__.'/templates';
\Slick\Template\Template::addPath($path);