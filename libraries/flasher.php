<?php namespace Flasher;

/**
 * Laravel-Flasher - A simple flash-message handler
 *
 * @package  Laravel-Flasher
 * @version  1.0.0-beta
 * @author   Colin Viebrock <colin@viebrock.ca>
 */


use Laravel\Session;


class Flasher {


	/**
	 * The session key when Flasher messages are stored.
	 */
	private static $sess_key = 'flasher';


	/**
	 * Load the array of Flasher messages from the session, or return an empty.
	 *
	 * @return array
	 */
	private static function load()
	{
		if ( $data = Session::get( static::$sess_key ) ) {
			return unserialize($data);
		}
		return array();
	}


	/**
	 * Filter an array of Flasher messages by type.
	 *
	 * @param  array  $array
	 * @param  string $type
	 * @return array
	 */
	private static function filter( array $array, $type = null )
	{
		if ( $type )
		{
			$array = array_filter($array, function($msg) use ($type) {
				return $msg->type == $type;
			});
		}
		return $array;
	}


	/**
	 * Save the Flasher message array to the session.
	 *
	 * @param  array $array
	 * @return void
	 */
	private static function flash( $array )
	{
		Session::flash( static::$sess_key, serialize( $array ) );
	}


	/**
	 * Add a message to the Flasher message array
	 *
	 * @param string $message
	 * @param string $type
	 */
	public static function add($message, $type = null )
	{

		$flasher = static::load();

		$message = new Message($message, $type);

		$flasher[] = $message;

		static::flash( $flasher );

	}


	/**
	 * Return all the Flasher messages, optionally filtering on type,
	 * formatted using the default format, and concatenated.
	 *
	 * @param  string $type
	 * @return string
	 */
	public static function showall( $type = null )
	{
		return join( PHP_EOL, static::all($type) );
	}


	/**
	 * Return all the Flasher messages, optionally filtering on type.
	 *
	 * @param  string $type
	 * @return array
	 */
	public static function all( $type = null )
	{
		return static::filter( static::load(), $type );
	}


	/**
	 * Return the first Flasher message, optionally filtering on type.
	 *
	 * @param  string $type
	 * @return Flasher\Message
	 */
	public static function first( $type = null )
	{
		$all = static::all($type);
		return array_shift( $all );
	}


	/**
	 * Return the last Flasher message, optionally filtering on type.
	 *
	 * @param  string $type
	 * @return Flasher\Message
	 */
	public static function last( $type = null )
	{
		$all = static::all($type);
		return array_pop( $all );
	}


	/**
	 * Return whether or not there are any Flasher messages, or whether there
	 * are any messages of a given type.
	 *
	 * @param  string $type
	 * @return boolean
	 */
	public static function has( $type = null )
	{
		$all = static::all($type);
		return count( $all ) > 0;
	}

	/**
	 * Magic method to dynamically store a Flasher message.
	 *
	 * @param  string $method
	 * @param  array $parameters 	First element is the message
	 */
	public static function __callStatic( $method, $parameters )
	{
		static::add( $parameters[0], $method );
	}


}
