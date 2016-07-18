<?php
namespace Framework\Login;
use Framework\Exceptions\LoginException;
use Framework\Login\Structures\Error;
use Framework\Login\Structures\Gate;

/**
 * Lewis Lancaster 2016
 *
 * Class Manager
 *
 * @package Framework\Login
 */

class Manager
{

	/**
	 * Process a login and looks up a gate
	 *
	 * @param $gate
	 *
	 * @param array $arguments
	 *
	 * @param bool $halt
	 *
	 * @return mixed
	 */

	public function processLogin( $gate, array $arguments, $halt=false )
	{

		if( $this->gateExists( $gate ) == false )
		{

			throw new LoginException('Gate does not exist');
		}

		$class = $this->createGate( $gate );

		if( $class instanceof Gate == false )
		{

			throw new LoginException('Gate has no interface, give it an interface');
		}

		$result = call_user_func_array( array( $class, 'processLogin' ), array( $arguments ) );

		if( empty( $result ) )
		{

			throw new LoginException('No result returned from process login, please see documentation on how to use this');
		}

		if( is_bool( $result ) == false || $result instanceof Error )
		{

			if( $result->message() == null || $halt == true  )
			{

				throw new LoginException('Unable to gage why error happened, please add error context');
			}

			if( $halt == true )
			{

				throw new LoginException( $result->message() );
			}

			if( $result->information() == null )
			{

				throw new LoginException('Unable to provide information to onFailure function, please revise');
			}

			return call_user_func_array( array( $class, 'onFailure' ), array( $result->information() ) );
		}

		if( is_bool( $result ) == false || $result instanceof Error == false )
		{

			throw new LoginException('Returned something unexpected');
		}

		/**
		 * If the result is false, Framwework will call the onFailure function. But really, you should be using the
		 * error class.
		 */

		if( $result == false )
		{

			call_user_func_array( array( $class, 'onFailure' ), array( $arguments ) );
		}

		return call_user_func_array( array( $class, 'onSuccess' ), array( $arguments ) );
	}

	/**
	 * Creates this gate
	 *
	 * @param $gate
	 *
	 * @return null
	 */

	public function createGate( $gate )
	{

		if( $this->gateExists( $gate ) == false )
		{

			throw new LoginException();
		}

		$class = $this->returnGate( $gate );

		//If essentially gate was not concatenated.

		if( $class == $this->getNamespace() )
		{

			return null;
		}

		return new $class;
	}

	private function returnGate( $gate )
	{

		return $this->getNamespace() . $gate;
	}

	/**
	 * Checks if the gate exists
	 *
	 * @param $gate
	 *
	 * @return bool
	 */

	public function gateExists( $gate )
	{

		if( class_exists( $this->returnGate( $gate ) ) == false )
		{

			if( class_exists( $this->returnGate( ucfirst( $gate ) ) ) == false )
			{

				return false;
			}
		}

		return true;
	}

	/**
	 * Returns the namespace of the gates
	 *
	 * @return string
	 */

	private function getNamespace()
	{

		return "Framework//Login//Gates//";
	}
}