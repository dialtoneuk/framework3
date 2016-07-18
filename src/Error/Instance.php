<?php
namespace Framework\Error;

/**
 * Lewis Lancaster 2016
 *
 * Class Instance
 *
 * @package Framework\Error
 */

use Framework\Error\Structures\Exception as Structure;
use Exception;

class Instance implements Structure
{

    /**
     * @var string
     */

    protected $hash;

    /**
     * @var Exception
     */

    protected $exception;

    /**
     * Instance constructor.
     *
     * @param Exception $error
     *
     * @param $hash
     */

    public function __construct( Exception $error, $hash )
    {

        $this->exception = $error;

        $this->hash = $hash;
    }

    /**
     * Gets the hash for this exception
     *
     * @return string
     */

    public function getErrorHash()
    {

        return $this->hash;
    }

    /**
     * Gets the message for this exception
     *
     * @return string
     */

    public function getMessage()
    {

        return $this->exception->getMessage();
    }

    /**
     * Gets the trace
     *
     * @return array
     */

    public function getTrace()
    {

        return $this->exception->getTraceAsString();
    }

    /**
     * Gets the line
     *
     * @return int
     */

    public function getLine()
    {

        return $this->exception->getLine();
    }
}