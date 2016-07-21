<?php
namespace Framework\Controllers;

/**
 * Lewis Lancaster 2016
 *
 * Class Manager
 *
 * @package Framework\Controllers
 */

use Flight;
use Framework\Exceptions\ControllerException;
use Framework\Controllers\Structures\View;
use ReflectionClass;

class Manager
{

	/**
	 * Manager constructor.
	 */

	public function __construct ()
	{

		Flight::route('/@view/*', function( $view, $splat )
		{

			if( $this->hasURLKeys( $splat ) )
			{

				$splat = $this->removeURLKeys( $splat );
			}

			$this->processView( $view, $splat );
		}, true );

		Flight::start();
	}

	/**
	 * Removes the URL keys
	 *
	 * @param $splat
	 *
	 * @return mixed
	 */

	private function removeURLKeys( $splat )
	{

		return explode('?', $splat )[0];
	}

	/**
	 * If you have URL keys
	 *
	 * @param $splat
	 *
	 * @return bool
	 */

	private function hasURLKeys( $splat )
	{

		if( empty( explode('?', $splat ) ) == false )
		{

			return true;
		}

		return false;
	}

	/**
	 * Process the view
	 *
	 * @param $view
	 *
	 * @param $splat
	 *
	 * @return mixed
	 */

	public function processView( $view, $splat )
	{

		if( $this->isPost() )
		{

			return $this->processPost( $view, $splat );
		}

		if( $this->isGet() )
		{

			return $this->processGet( $view, $splat );
		}

		throw new ControllerException();
	}

	/**
	 * Is this post?
	 *
	 * @return bool
	 */

	public function isPost()
	{

		if( $_SERVER['REQUEST_METHOD'] !== 'POST' )
		{

			return false;
		}

		return true;
	}

	/**
	 * Is this get?
	 *
	 * @return bool
	 */

	public function isGet()
	{

		if( $_SERVER['REQUEST_METHOD'] !== 'GET' )
		{

			return false;
		}

		return true;
	}

	/**
	 * Does this view have a map to seperate views?
	 *
	 * @param View $view
	 *
	 * @return bool
	 */

	public function hasMap( View $view )
	{

		if( $view->getMap() == null )
		{

			return false;
		}

		return true;
	}

	/**
	 * Processes a post
	 *
	 * @param $view
	 *
	 * @param $splat
	 *
	 * @return mixed
	 */

	private function processPost( $view, $splat )
	{

		if( $this->viewExists( $view, 'Post') == false )
		{

			throw new ControllerException('Class does not exist');
		}

		$class = $this->createView( $view, 'Post' );

		if( $class instanceof View == false )
		{

			throw new ControllerException('Class is not correct');
		}

		$post = $this->preparePost();

		if( $this->hasMap( $class ) == false )
		{

			if( empty( $post ) )
			{

				return $class->process();
			}

			return $class->process( $post );
		}

		return $this->processMap( $view, $splat, $post );
	}

	/**
	 * Processes a get
	 *
	 * @param $view
	 *
	 * @param $splat
	 *
	 * @return mixed
	 */

	private function processGet( $view, $splat )
	{

		if( $this->viewExists( $view, 'Get') == false )
		{

			throw new ControllerException('Class does not exist');
		}

		$class = $this->createView( $view, 'Get' );

		if( $class instanceof View == false )
		{

			throw new ControllerException('Class is not correct');
		}

		if( $this->hasMap( $class ) == false )
		{

			if( empty( $post ) )
			{

				return $class->process();
			}

			return $class->process( $post );
		}

		return $this->processMap( $view, $splat );
	}

	/**
	 * Splat to array.
	 *
	 * @param $splat
	 *
	 * @return array|null
	 */

	private function splatToArray( $splat, $view )
	{

		$splat = explode('/', $splat );

		$array = array();

		if( $splat[0] == $view )
		{

			foreach( $splat as $key=>$value )
			{

				if( $value != $view )
				{

					$array[0] = $value;
				}
			}
		}

		if( empty( $splat ) )
		{

			return null;
		}

		return $splat;
	}

	/**
	 * Processes a map
	 *
	 * @param View $view
	 *
	 * @param $splat
	 *
	 * @param null $data
	 *
	 * @return mixed
	 */

	private function processMap( View $view, $splat, $data=null )
	{

		$map = $view->getMap();

		if( empty( $map ) || is_array( $map ) == false )
		{

			throw new ControllerException();
		}

		foreach( $map as $key=>$value )
		{

			if( empty( $splat ) )
			{

				if( $key == '/' )
				{

					return call_user_func_array( array( $view, $value ), array( $data, $this->splatToArray( $splat, $this->getViewName( $view )  ) ) );
				}
			}

			if( $splat == $key )
			{

				return call_user_func_array( array( $view, $value ), array( $data, $this->splatToArray( $splat, $this->getViewName( $view ) ) ) );
			}
		}

		return $view->process( $data );
	}

	/**
	 * Gets the name of our view
	 *
	 * @param View $view
	 *
	 * @return string
	 */

	private function getViewName( View $view )
	{

		$reflection = new ReflectionClass( $view );

		if( empty( $reflection ) )
		{

			throw new ControllerException();
		}

		return strtolower( $reflection->getShortName() );
	}

	/**
	 * Prepares a post.
	 *
	 * @return null
	 */

	private function preparePost()
	{

		$array = array();

		if( empty( $_POST ) )
		{

			return null;
		}

		foreach( $_POST as $key=>$value )
		{

			if( strlen( $key ) > 1024 || strlen( $value ) > 1024 )
			{

				throw new ControllerException();
			}

			$array[ htmlspecialchars($key) ] =htmlspecialchars($value);
		}
	}

	/**
	 * Creates a new view
	 *
	 * @param $view
	 *
	 * @param string $method
	 *
	 * @return mixed
	 */

	private function createView( $view, $method = 'Post')
	{

		if( $method != 'Post' && $method != 'Get' )
		{

			throw new ControllerException();
		}

		$view = $this->getNamespace( $method ) . $view;

		if( $this->viewExists( $view ) == false )
		{

			throw new ControllerException();
		}

		return new $view;
	}

	/**
	 * Checks to see if the view exists.
	 *
	 * @param $view
	 *
	 * @param string $method
	 *
	 * @return bool
	 */

	private function viewExists( $view, $method = 'Post' )
	{

		if( $method != 'Post' && $method != 'Get' )
		{

			throw new ControllerException();
		}

		return class_exists( $this->getNamespace( $method ) . $view );
	}

	/**
	 * Get namespace
	 *
	 * @param string $method
	 *
	 * @return string
	 */

	private function getNamespace( $method = 'Post' )
	{

		if( $method != 'Post' && $method != 'Get' )
		{

			throw new ControllerException();
		}

		return "Framework//Controllers//Views//{$method}//";
	}
}