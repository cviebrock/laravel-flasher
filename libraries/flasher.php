<?php

namespace Flasher;

use Laravel\Messages;

class Flasher {

	// the session key
	private static $sess_key = 'flasher';



	public static function add($message, $type='default' )
	{

		$flasher = Session::get( static::$sess_key, new Messages );

		$message = new Message($message, $type);

		$flasher->add( $type, $message );

		Session::flash( static::$sess_key, $flasher );

	}


	public static function first($type=null)
	{
		if ( $flasher = Session::get( static::$sess_key ) ) {
			return $flasher->first( $type );
		}
	}


	public static function get($type=null)
	{
		if ( $flasher = Session::get( static::$sess_key ) ) {
			return $flasher->get( $type );
		}
	}


	public static function __callStatic($method, $parameters)
	{
		static::add( $method, $parameters[0] );
	}

}