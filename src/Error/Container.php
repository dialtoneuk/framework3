<?php
namespace Framework\Error;

/**
 * Lewis Lancaster 2016
 *
 * Class Handler
 *
 * @package Framework\Error
 */

use Exception;

class Container
{

    /**
     * @var bool|false
     */

    protected $logerror;

    /**
     * @var string
     */

    protected $file;

    /**
     * Handler constructor.
     *
     * @param bool|true $logerror
     *
     * @param string $file
     */

    public function __construct( $logerror=false, $file="matchmaking/resources/errors/log.json" )
    {

        $this->logerror = $logerror;

        $this->file = $file;
    }

    /**
     * Handles an error and returns an error instance
     *
     * @param Exception $error
     *
     * @return Instance
     */

    public function handleError( Exception $error )
    {

        $instance = new Instance( $error, $this->createHash() );

        if( $instance instanceof Instance == false )
        {

            return false;
        }

        if( $this->logerror == true )
        {

            $this->logError( $instance );
        }

        return $instance;
    }

    /**
     * Logs an error
     *
     * @param Instance $instance
     *
     * @return bool
     */

    private function logError( Instance $instance )
    {

        if( file_exists( $this->getFileLocation() ) == false )
        {
            file_put_contents( $this->getFileLocation(), json_encode( array() ) );
        }

        $array = @json_decode( file_get_contents( $this->getFileLocation() ), true );

        if( $array === false )
        {
            return false;
        }

        $error = array(
            'hash'      => $instance->getErrorHash(),
            'line'      => $instance->getLine(),
            'message'   => $instance->getMessage(),
            'trace'     => $instance->getTrace()
        );

        $array[] = $error;

        file_put_contents( $this->getFileLocation(), json_encode( $array, JSON_PRETTY_PRINT ) );

        return true;
    }

    /**
     * Gets our file location
     *
     * @return string
     */

    private function getFileLocation()
    {

        return $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . $this->file;
    }

    /**
     * Creates a random MD5 string
     *
     * @return string
     */

    private function createHash()
    {

        return md5( time() * rand(1, time() ) );
    }
}
