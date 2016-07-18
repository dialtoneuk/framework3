<?php
namespace Framework\Database;

/**
 * Lewis Lancaster 2016
 *
 * Class Controller
 *
 * @package Framework\Database
 */

use Illuminate\Database\Capsule\Manager;
use Framework\Database\Structures\Connection;
use Framework\Exceptions\DatabaseException;
use Framework\Database\Connections\Framework;
use PDO;

class Controller
{

    /**
     * @var Manager
     */

    protected static $capsule;

    /**
     * Controller constructor.
     *
     * @param Connection $connection
     */

    public function __construct( Connection $connection=null )
    {

        //If we are already created, return null.

        if( self::$capsule !== null )
        {

            return;
        }
        else
        {

            if( $connection === null )
            {

                $connection = new Framework();
            }

            self::$capsule = new Manager();

            $this->createConnection( $connection );
        }
    }

    /**
     * Creates a new connection.
     *
     * @param Connection $connection
     */

    public function createConnection( Connection $connection )
    {

        if( $connection instanceof Connection == false )
        {

            throw new DatabaseException();
        }

        $config = $this->mergeArrays( $connection );

        if( empty( $config ) )
        {

            throw new DatabaseException();
        }

        self::$capsule->addConnection( $config );

        self::$capsule->setFetchMode( PDO::FETCH_ASSOC );

        self::$capsule->setAsGlobal();
    }

    /**
     * Returns the current capsule;
     *
     * @return Manager
     */

    public static function getCapsule()
    {

        return self::$capsule;
    }

    /**
     * Merges the two data arrays.
     *
     * @param Connection $connection
     *
     * @return array
     */

    private function mergeArrays( Connection $connection )
    {

        return array_merge( $connection->serverDetails(), $connection->driverDetails() );
    }
}