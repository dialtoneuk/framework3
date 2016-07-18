<?php
namespace Framework\Exceptions;

/**
 * Lewis Lancaster 2016
 *
 * Class ApiException
 *
 * @package Framework\Exceptions
 */

use RuntimeException;

class ApiException extends RuntimeException
{

    /**
     * Returns json
     *
     * @return string
     */

    public function getJson()
    {

        $array = array(
            'error' => true,
            'message' => [
                'reason'   => $this->getMessage(),
                'line'      => $this->getLine(),
                'code'      => $this->getCode()
            ]
        );

        return json_encode( $array );
    }

    /**
     * Returns an array
     *
     * @return array
     */

    public function getArray()
    {

        $array = array(
            'error' => true,
            'message' => [
                'reason'   => $this->getMessage(),
                'line'      => $this->getLine(),
                'code'      => $this->getCode()
            ]
        );

        return $array;
    }
}