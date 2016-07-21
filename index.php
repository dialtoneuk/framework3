<?php

/**
 *  ______                                           _
 * |  ____|                                         | |
 * | |__ _ __ __ _ _ __ ___   _____      _____  _ __| | __
 * |  __| '__/ _` | '_ ` _ \ / _ \ \ /\ / / _ \| '__| |/ /
 * | |  | | | (_| | | | | | |  __/\ V  V / (_) | |  |   <   Version 3.1.0
 * |_|  |_|  \__,_|_| |_| |_|\___| \_/\_/ \___/|_|  |_|\_\
 *
 * This framework was created souly by Lewis Lancaster. Its an MVC/Restless/Hybrid that's powered by several suns, it
 * took me a few months to write ( but in all fairness, I did add to it slowly and /alot/ was removed ). I hope this is
 * nice to use if you are some developer out there, developing this application.
 *
 * FEATURES AS OF VERSION 3
 * ========================
 *
 *  + Added new application container.
 *  + Added new view system.
 */
require_once 'vendor/autoload.php';

/**
 * Start the application
 */

$application = new \Framework\Application();