<?php
/**
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the General Public License (GPL 3.0)
 * that is bundled with this package in the file LICENSE
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/GPL-3.0
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future.
 *
 * @author      Jeroen Bleijenberg
 *
 * @copyright   Copyright (c) 2017
 * @license     http://opensource.org/licenses/GPL-3.0 General Public License (GPL 3.0)
 */
ini_set('display_errors', true);
error_reporting(E_ALL);

define('BP', dirname(__FILE__, 1));
define('DS', DIRECTORY_SEPARATOR);

require_once BP . '/vendor/autoload.php';
require_once BP . '/vendor/jcode/framework/src/Functions.php';

$di = new \Jcode\ObjectManager();

/* @var \Jcode\Application $application */
$application = $di->get('\Jcode\Application');
$application::isDeveloperMode(true);
$application::showTemplateHints(false);
$application::logMysqlQueries(false);
$application::run();

\Jcode\Application::getClass('\Jcode\Cron')->run();