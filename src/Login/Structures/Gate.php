<?php
namespace Framework\Login\Structures;

/**
 * Lewis Lancaster 2016
 *
 * Interface Gate
 *
 * @package Framework\Login\Structures
 */

interface Gate
{

	/**
	 * Process the login
	 *
	 * @param array $information
	 *
	 * @return mixed
	 */

	public function processLogin( array $information );

	/**
	 * Called when the login is made successful
	 *
	 * @param array $information
	 *
	 * @return mixed
	 */

	public function onSuccess( array $information );

	/**
	 * Called when the login is unsuccessful
	 *
	 * @param null $message
	 *
	 * @param array|null $information
	 *
	 * @return mixed
	 */

	public function onFailure( $message = null,  array $information = null );
}