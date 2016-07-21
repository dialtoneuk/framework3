<?php
namespace Framework;

/**
 * Lewis Lancaster 2016
 *
 * Class Application
 *
 * @package Framework
 */

use Framework\Error\Container;
use Framework\Controllers\Manager;
use Exception;
use Framework\Exceptions\AppException;

class Application
{

	/**
	 * @var Container
	 */

	protected $container;

	/**
	 * @var Manager
	 */

	protected $manager;

	/**
	 * @var array
	 */

	protected $array = array();

	/**
	 * Application constructor.
	 */

	public function __construct ()
	{

		$this->initialize();
	}

	/**
	 * Initializes the application
	 */

	public function initialize()
	{

		$this->container = new Container();

		try
		{

			$this->manager = new Manager();
		}
		catch( Exception $error )
		{

			$instance = $this->container->handleError( $error );

			if( empty( $instance ) )
			{

				throw new AppException();
			}

			$this->container->renderErrorPage( $instance );

			//TODO: Could expand here

			die();
		}
	}

	/**
	 * Gets a value
	 *
	 * @param $name
	 *
	 * @return mixed|null
	 */

	public function __get( $name )
	{

		if( isset( $this->array[ $name ] ) )
		{

			return $this->array[ $name ];
		}

		return null;
	}

	/**
	 * Sets a value
	 *
	 * @param $name
	 *
	 * @param $value
	 */

	public function __set( $name, $value )
	{

		$this->array[ $name ] = $value;
	}
}
