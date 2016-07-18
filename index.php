<?php

/**
 *  ______                                           _
 * |  ____|                                         | |
 * | |__ _ __ __ _ _ __ ___   _____      _____  _ __| | __
 * |  __| '__/ _` | '_ ` _ \ / _ \ \ /\ / / _ \| '__| |/ /
 * | |  | | | (_| | | | | | |  __/\ V  V / (_) | |  |   <   Version 3.0.0
 * |_|  |_|  \__,_|_| |_| |_|\___| \_/\_/ \___/|_|  |_|\_\
 *
 * This framework was created souly by Lewis Lancaster. Its an MVC/Restless/Hybrid that's powered by several suns, it
 * took me a few months to write ( but in all fairness, I did add to it slowly and /alot/ was removed ). I hope this is
 * nice to use if you are some developer out there, developing this application.
 *
 * FEATURES AS OF VERSION 3
 * ========================
 *
 * + New login gate system.
 *      = Easily create login gates for sites that want to take advantage of multiple logins.
 *      = Written as a MVC ( Minus the viewer ) style system.
 * + Added Bootstrap as the main front-end framework.
 * ~ Fixed bug with Ajax and viewer not seperating keys.
 * ~ Cleaned up the code and added disclaimer to each file.
 * ~ Now integrated with Bootstrap.
 *
 */

require_once "vendor/autoload.php";

use Framework\Views\Manager;

/** @noinspection PhpMethodParametersCountMismatchInspection */

Flight::route('/*', function( $route )
{

    $manager = new Manager();

    $manager->process( $route->splat );
}, true );

/**
 * Start the flight engine.
 */

Flight::start();