<?php
namespace Framework\Database\Connections;

/**
 * Lewis Lancaster 2016
 *
 * Class Framework
 *
 * @package Framework\Database\Connections
 */

use Framework\Database\Structures\Connection;

class Framework implements Connection
{

    /**
     * Our server details
     *
     * @return array
     */

    public function serverDetails()
    {

        return array(
            "username"  => "root",
            "password"  => "",
            "database"  => "matchmaking",
            "host"      => "localhost"
        );
    }

    /**
     * Our driver details, and misc options
     *
     * @return array
     */

    public function driverDetails()
    {

        return array(
            'driver'    => 'mysql',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        );
    }
}