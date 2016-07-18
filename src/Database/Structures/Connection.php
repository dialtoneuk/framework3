<?php
namespace Framework\Database\Structures;

/**
 * Lewis Lancaster 2016
 *
 * Interface Connection
 *
 * @package Framework\Database\Structures
 */

interface Connection
{

    /**
     * Holds the server details for this class.
     *
     * @return mixed
     */

    public function serverDetails();

    /**
     * Holds the driver details for this class.
     *
     * @return mixed
     */

    public function driverDetails();
}