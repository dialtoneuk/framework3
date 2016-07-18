<?php
namespace Framework\Login;

/**
 * Lewis Lancaster 2016
 *
 * Class Error
 *
 * @package Framework\Login
 */

use Framework\Exceptions\LoginException;
use Framework\Login\Structures\Error as Structure;

class Error implements Structure
{

	/**
	 * @var null
	 */

	protected $errormessage = null;

	/**
	 * @var null
	 */

	protected $errorinformation = null;

	/**
	 * Error constructor.
	 * 
	 * @param $message
	 *
	 * @param array $information
	 */

	public function __construct( $message, array $information )
	{

		$this->errormessage = $message;

		$this->errorinformation = $information;
	}

	/**
	 * Gets and sets the error information, this is normally the user information.
	 *
	 * @param array|null $information
	 *
	 * @return array|null
	 */

	public function information( array $information = null )
	{

		if( $information == null )
		{

			if( $this->errorinformation == null )
			{

				throw new LoginException('Error information has not been set');
			}

			return $this->errorinformation;
		}

		$this->errorinformation = $information;

		return $information;
	}

	/**
	 * gets and sets the error message
	 *
	 * @param null $message
	 *
	 * @return null
	 */

	public function message( $message = null )
	{

		if( $message == null )
		{

			if( $this->errormessage == null )
			{

				throw new LoginException('Message has not been set');
			}

			return $this->errormessage;
		}

		$this->errormessage = $message;

		return $message;
	}
}