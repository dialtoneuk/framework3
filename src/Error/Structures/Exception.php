<?php
namespace Framework\Error\Structures;

/**
 * Lewis Lancaster 2016
 *
 * Interface Exception
 *
 * @package Framework\Error\Structures
 */

interface Exception
{

    /**
     * @return mixed
     */

    public function getErrorHash();

    /**
     * @return mixed
     */

    public function getMessage();

    /**
     * @return mixed
     */

    public function getTrace();

    /**
     * @return mixed
     */

    public function getLine();
}