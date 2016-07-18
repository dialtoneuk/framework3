<?php
namespace Framework\Views;


/**
 * Lewis Lancaster 2016
 *
 * Class Controller
 *
 * @package Framework\Views
 */


use Framework\Exceptions\ViewException;
use Framework\Views\Structures\Page;
use Flight;

class Controller
{

    /**
     * Processes a view
     *
     * @param $view
     *
     * @param null $splat
     *
     * @param null $post
     *
     * @return mixed
     */

    public function view( $view, $splat=null, $post=null )
    {

        if( $this->classExists( $view ) == false )
        {

            Flight::notFound();
        }

        $class = $this->createClass( $view );

        if( $class instanceof Page == false )
        {

            throw new ViewException();
        }

        return $this->callMethods( $class, $splat, $post );
    }

    /**
     * Calls either the post or get method, depending on what is given to the view method
     *
     * @param $class Page
     *
     * @param null $splat
     *
     * @param null $post
     *
     * @return mixed
     */

    public function callMethods( $class, $splat=null, $post=null )
    {

        if( $this->isPost() == true )
        {

            if( is_array( $post ) == false || $post == null )
            {

                throw new ViewException();
            }

            return $class->post( $post, $splat );
        }

        return $class->get( $splat );
    }

    /**
     * Creates a new class
     *
     * @param $class
     *
     * @return Page
     */

    public function createClass( $class )
    {

        $class = $this->getNamespace( $class );

        if( empty( $class ) )
        {

            throw new ViewException();
        }

        return new $class;
    }

    /**
     * If we have posted data
     *
     * @return bool
     */

    public function isPost()
    {

        if( empty( $_POST ) )
        {

            return false;
        }

        return true;
    }

    /**
     * Checks if the specific class exists
     *
     * @param $class
     *
     * @return bool
     */

    public function classExists( $class )
    {

        if( class_exists( $this->getNamespace( $class ) ) == false )
        {

            if( class_exists( $this->getNamespace( ucfirst( $class ) ) ) == false )
            {

                return false;
            }
        }

        return true;
    }

    /**
     * Gets the namespace of the classes.
     *
     * @param $class
     *
     * @return string
     */

    private function getNamespace( $class )
    {

        return "Framework\\Views\\Pages\\$class";
    }
}