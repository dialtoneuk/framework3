<?php
namespace Framework\Exceptions;

/**
 * Lewis Lancaster 2016
 *
 * Class DatabaseException
 *
 * @package Framework\Exceptions
 */

use RuntimeException;
use Illuminate\Database\Capsule\Manager;

class DatabaseException extends RuntimeException
{

    /**
     * Gets the last query from the query log
     *
     * @return mixed
     */

    public function getQuery()
    {

        return end( Manager::connection()->getQueryLog() );
    }
}