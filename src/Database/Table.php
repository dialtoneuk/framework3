<?php

namespace Framework\Database;

/**
 * Lewis Lancaster 2016
 *
 * Class Table
 *
 * @package Framework\Database;
 */

use Illuminate\Database\Capsule\Manager as Database;
use Framework\Database\Structures\Table as Structure;
use Framework\Exceptions\DatabaseException;
use ReflectionClass;

class Table implements Structure
{

    /**
     * @var Database
     */

    protected $database;

    /**
     * Table constructor.
     */

    public function __construct()
    {

        if( Controller::getCapsule() === null )
        {

            $this->createDatabase();
        }

        $this->database = Controller::getCapsule();
    }

    /**
     * Gets the table.
     *
     * @return \Illuminate\Database\Query\Builder
     */

    public function getTable()
    {

        $reflection = new ReflectionClass( $this );

        $shortname = $reflection->getShortName();

        if( Database::table( $shortname )->exists() )
        {

            return Database::table( $shortname );
        }
        else
        {

            if( Database::table( strtolower( $shortname ) )->exists() )
            {

                return Database::table( strtolower( $shortname ) );
            }
            else
            {

                /**
                 * There is currently a bug that even though the table exists, the exists method will still not
                 * return true.
                 */

                try
                {

                    Database::table( strtolower( $shortname ) )->get();
                }
                catch( \Exception $error )
                {

                    throw new DatabaseException();
                }

                return Database::table( strtolower( $shortname ) );
            }
        }
    }

    /**
     * If we are connected.
     *
     * @return bool
     */

    public function isConnected()
    {

        try
        {

            Database::connection()->getDatabaseName();
        }
        catch( \Exception $error )
        {

            return false;
        }

        return true;
    }

    /**
     * Creates the database.
     */

    private function createDatabase()
    {

        $controller = new Controller();

        if( $this->isConnected() === false )
        {

            throw new DatabaseException();
        }
    }
}