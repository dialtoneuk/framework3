<?php
namespace Framework\Ajax;

/**
 * Lewis Lancaster 2016
 *
 * Class Manager
 *
 * @package Framework\Ajax
 */

use Framework\Exceptions\ApiException;
use Flight;

class Manager
{

    /**
     * @var Controller
     */

    protected $controller;

    /**
     * Manager constructor.
     */

    public function __construct()
    {

        $this->controller = new Controller();
    }

    /**
     * Processes that request.
     *
     * @param $class
     *
     * @param $method
     *
     * @return string
     */

    public function processRequest( $class, $method )
    {

        $result = null;

        try
        {

            $data = $this->createData();

            $result = $this->controller->route($class, $method, $data);
        }
        catch( ApiException $error )
        {

             Flight::json( $error->getArray(), 400 );
        }

        if( $result === null )
        {

            throw new ApiException("Result ended up being null");
        }

        if( is_array( $result->getResult() ) == false )
        {

            /**
             * Since this could be a method, we'll just output the result
             */

            $result->getResult();

            /**
             * Cease the method
             */

            return;
        }

        Flight::json( $result->getResult(), 200 );
    }

    /**
     * Creates our set of data
     *
     * @return null|array
     */

    private function createData()
    {

        $data = $this->getData();

        if( $data === null )
        {

            throw new ApiException();
        }

        $array = array();

        foreach( $data as $key=>$value )
        {

            if( strlen( $value ) > 2048 )
            {

                continue;
            }

            $array[ $key ] = addslashes( $value );
        }

        return $data;
    }

    /**
     * Gets the data
     *
     * @param bool|false $useget
     *
     * @return null
     */

    public function getData($useget=false)
    {

        $data = $_POST;

        if( empty( $data ) == true )
        {

            if( $useget == false )
            {

                return null;
            }

            if( empty( $_GET ) == false )
            {

                $data = $_GET;
            }
            else
            {

                return null;
            }
        }

        return $data;
    }
}