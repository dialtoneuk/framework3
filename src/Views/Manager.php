<?php
namespace Framework\Views;

/**
 * Lewis Lancaster 2016
 * 
 * Class Manager
 *
 * @package Framework\Views
 */

use Framework\Error\Container;
use Framework\Error\Instance;
use Framework\Exceptions\ViewException;
use Exception;
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
     * Processes a route
     *
     * @param $splat
     *
     * @return mixed
     */

    public function processRoute( $splat )
    {

        $array = $this->splatToArray( $splat );

        if( empty( $array ) )
        {

            throw new ViewException('Failed to retrieve splatmap');
        }

        $view = $this->getView( $array );

        if( $this->isPHPSafe( $view ) == false )
        {

            throw new ViewException('Invalid URL');
        }

        $splat = $this->mapSplat( $array );

        if( $this->isPost() )
        {

            $post = $this->mapPostData( $_POST );

            if( empty( $post ) )
            {

                throw new ViewException('Failed to build post parameters');
            }

            return $this->controller->view( $view, $splat, $post );
        }

        return $this->controller->view( $view, $splat );
    }

    /**
     * Processes a view request
     *
     * @param $splat
     */

    public function process( $splat )
    {

	    if( substr( $splat, 0, 1 ) != '?' || substr( $splat, 0, 1 ) != '#' || $splat == null )
	    {

		    $splat = 'index/';
	    }

	    if( $this->hasGetKeys( $splat ) )
	    {

		    $splat = $this->removeGetKeys( $splat );
	    }

        if( substr( $splat, -1 ) != '/' )
        {

            $splat = $splat . '/';
        }

        try
        {

            $this->processRoute( $splat );
        }
        catch( Exception $error )
        {

            $this->handleError( $error, false );
        }
    }

    /**
     * Handles an error thrown by our web application inside a view
     *
     * @param Exception $error
     *
     * @param bool|true $live
     *
     * @return bool
     */

    public function handleError( Exception $error, $live = true )
    {

        $handler = new Container();

        if( empty( $error ) )
        {

            return false;
        }

        $instance = $handler->handleError( $error );

        if( $instance instanceof Instance == false )
        {

            return false;
        }

        if( $live == true )
        {

            Flight::render('error/live', array(
               'hash'   =>  $instance->getErrorHash()
            ));
        }
        else
        {

            Flight::render('error/developer', array(
	            'hash'      =>  $instance->getErrorHash(),
                'message'   =>  $instance->getMessage(),
                'line'      =>  $instance->getLine(),
                'trace'     =>  $instance->getTrace()
            ));
        }

        return true;
    }

    /**
     * Maps our post data into a safe array
     *
     * @param $post
     *
     * @return array
     */

    public function mapPostData( $post )
    {

        $array = array();

        foreach( $post as $key=>$value )
        {

            if( strlen( $value ) > 2500 || empty( $value ) )
            {

                throw new ViewException('Post data invalid, please limit the length of strings to 2500');
            }

            $array[ $key ] = htmlspecialchars( $value );
        }

        if( empty( $array ) )
        {

            throw new ViewException();
        }

        return $array;
    }

    /**
     * Is this post (loss?)
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
     * If we have URL keys
     *
     * @param $splat
     *
     * @return bool
     */

    public function hasKeys( $splat)
    {

        if( empty( explode('?', $splat )))
        {

            return false;
        }

        return true;
    }

    /**
     * Gets the view from the first key
     *
     * @param array $splat
     *
     * @return string
     */

    private function getView( array $splat )
    {

        if( isset( $splat[0] ) == false )
        {

            throw new ViewException();
        }

        return htmlspecialchars( $splat[0] );
    }

    /**
     * Checks if this view is 'php safe'
     *
     * @param $view
     *
     * @return bool
     */

    private function isPHPSafe( $view )
    {

        if( preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $view ) )
        {

            return false;
        }

        return true;
    }

	/**
	 * Checks to see if we have get keys,
	 *
	 * @param $splat
	 *
	 * @return bool
	 */

    private function hasGetKeys( $splat )
    {

	    if( str_contains( $splat, '?' ) )
	    {

		    return true;
	    }

	    return false;
    }

	/**
	 * Removes our get keys.
	 *
	 * @param $splat
	 *
	 * @return mixed
	 */

	private function removeGetKeys( $splat )
	{

		return explode('?', $splat)[0];
	}

    /**
     * Maps our splat, removing any special chars and removing the first
     *
     * @param array $splat
     *
     * @return array
     */

    private function mapSplat( array $splat )
    {

        if( isset( $splat[0] ) == false )
        {

            throw new ViewException();
        }

        $array = array();

        foreach( $splat as $key=>$value )
        {

            if( $value == $splat[0] )
            {

                continue;
            }

            if( $value == "" )
            {

                continue;
            }

            $array[] = htmlspecialchars( $value );
        }

        return $array;
    }

    /**
     * Converts the splat into the array
     *
     * @param $splat
     *
     * @return array
     */

    private function splatToArray( $splat )
    {

        $explode = explode('/', $splat );

        if( empty( $explode ) )
        {

            throw new ViewException();
        }

        return $explode;
    }
}