<?php
namespace Framework\Login\Gates;

/**
 * Lewis Lancaster 2016
 *
 * Class Steam
 *
 * @package Framework\Login\Gates
 */

use Framework\Exceptions\LoginException;
use Framework\Login\Error;
use Framework\Login\Structures\Gate;
use LightOpenID as OpenID;

class Steam implements Gate
{

	/**
	 * @var OpenID
	 */

	protected $openid;

	/**
	 * Checks the current situation of the session and creates a new
	 *
	 * Steam constructor.
	 */

	public function __construct ()
	{

		if( session_status() == PHP_SESSION_NONE || session_status() == PHP_SESSION_DISABLED )
		{

			//TODO: Merge this with the session manager and create a temporary anon session

			session_start();
		}

		$this->openid = new OpenID( $_SERVER['SERVER_NAME'] );
	}

	/**
	 * Processes the login
	 *
	 * @param array $information
	 *
	 * @return bool|Error
	 */
	
	public function processLogin (array $information)
	{

		//TODO: Preform checks to see if banned here ( VAC Banned or what ever )

		if( !$this->openid->mode || $this->openid->mode == 'cancel' )
		{

			return new Error('OpenID: Mode is false and or canceled', $information );
		}

		if( $this->openid->validate() == false )
		{

			return new Error('Failed to validate', $information );
		}

		return true;
	}

	/**
	 * Creates the new session and returns an array of data
	 *
	 * @param array $information
	 *
	 * @return mixed
	 */

	public function onSuccess (array $information)
	{

		//TODO: Set session variables here and do session things right here

		$steamid = $this->getSteamID( $this->openid->identity );

		//TODO: Preform checks if first time logging in here

		if( empty( $steamid ) )
		{

			throw new LoginException('Steam ID appears to be empty');
		}

		$array = array(
			'steamid' => $steamid
		);

		return $array;
	}
	
	/**
	 * Thrown on failure
	 *
	 * @param null $message
	 *
	 * @param array|null $information
	 *
	 * @return mixed
	 */

	public function onFailure ( $message=null, array $information = null)
	{

		throw new LoginException( $message );
	}

	/**
	 * Returns the Steam ID of the authenticated user
	 *
	 * @param $identity
	 *
	 * @return mixed
	 */

	private function getSteamID( $identity )
	{

		preg_match("/^http:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/", $identity, $matches );

		if( empty( $matches ) )
		{

			throw new LoginException('OpenID: Unable to grab SteamID');
		}

		return $matches[1];
	}
}