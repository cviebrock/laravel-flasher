<?php namespace Flasher;

/**
 * Laravel-Flasher - A simple flash-message handler
 *
 * @package  Laravel-Flasher
 * @version  1.0.0-beta
 * @author   Colin Viebrock <colin@viebrock.ca>
 */


use Laravel\Config;


class Message {

	/**
	 * The string message.
	 * @var string
	 */
	public $message;

	/**
	 * The type of message (e.g. "error", "info", "success", etc.).
	 * Can be anything, really.
	 * @var string
	 */
	public $type;


	/**
	 * Create a new Flasher message object.
	 *
	 * @param string $message
	 * @param string $type
	 */
	public function __construct( $message, $type=null )
	{
		$this->message = $message;
		$this->type = $type;
	}


	/**
	 * Return a formatted message string.
	 *
	 * @param  string $format
	 * @return string
	 */
	public function format( $format = null )
	{

		if ( $format === null ) {
			$format = Config::get( 'flasher.format', Config::get( 'flasher::flasher.format', ':message' ) );
		}

		return str_replace(
			array( ':type', ':message' ),
			array( $this->type, $this->message ),
			$format
		);

	}


	/**
	 * Magic method, casts object to string by formatting it.
	 *
	 * @return string
	 */
	public function __toString()
	{
		return $this->format();
	}


}
