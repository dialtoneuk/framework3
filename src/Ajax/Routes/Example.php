<?php
namespace Framework\Ajax;

/**
 * Lewis Lancaster 2016
 *
 * Class Example
 *
 * @package Framework\Ajax
 */

use Framework\Ajax\Structures\Route;
use Framework\Ajax\Traits\Authenticators\None;
use Framework\Ajax\Types\Result;

class Example implements Route
{

    /**
     * Removes the need for an Authenticator, can also just return null by hand
     */

    use None;

    /**
     * Creates a new 'routes' helper class, adding a basic route known as 'example' which points to the function
     * of the same name inside this class, requires a 'message' parameter.
     *
     * @return array
     */

    public function routes()
    {

        $routes = new Routes();

        $routes->addRoute('example', 'example', array(
            'message'
        ));

        return $routes->getRoutes();
    }

    /**
     * Called by accessing ajax.website.com/example/example/
     *
     * @param $message
     *
     * @return Result
     */

    public function example( $message )
    {

        /**
         * Returns a new JSON output
         */

        return new Result(array(
            'message' => $message
        ));
    }
}