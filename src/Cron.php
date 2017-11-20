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
namespace Jcode;

use Cron\CronExpression;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;

class Cron
{

    protected static $environment;

    protected static $eventManager;

    protected static $registry;

    protected static $objectManager;

    /**
     * Initialize application and dispatch it
     */
    public function run()
    {
        $finder = new Finder();

        $finder
            ->files()
            ->ignoreUnreadableDirs()
            ->followLinks()
            ->name('cron.yaml')
            ->depth('> 2')
            ->in(BP);

        foreach ($finder as $cronConfig) {
            $tasks = Yaml::parseFile($cronConfig->getPathname());

            array_walk($tasks['cron'], function($task) {
                $cron = CronExpression::factory($task['schedule']);

                if($cron->isDue()) {
                    $segments = explode('::', $task['task']);
                    $method   = $segments[1];
                    $class    = Application::getClass($segments[0]);

                    $class->$method();
                }
            });
        }
    }
}