<?php
namespace Framework\Login\Structures;

/**
 * Lewis Lancaster 2016
 *
 * Interface Error
 *
 * @package Framework\Login\Structures
 */

Interface Error
{

	/**
	 * Gets the message or sets the message
	 *
	 * @param string $message
	 *
	 * @return mixed
	 */

	public function message( $message = null );

	/**
	 * Gets or sets the information
	 *
	 * @param array $information
	 *
	 * @return mixed
	 */

	public function information( array $information = null );
}