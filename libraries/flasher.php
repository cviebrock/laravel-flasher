<?php

namespace Flasher;

use Laravel\Messages;
use Laravel\Session;


class Flasher {

	// the session key
	private static $sess_key = 'flasher';


	// default type
	private static $default_type = 'default';


	private static function load()
	{
		if ( $data = Session::get( static::$sess_key ) ) {
			return unserialize($data);
		}
		return array();
	}


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


	private static function flash( $data )
	{
		return Session::flash( static::$sess_key, serialize($data) );
	}



	public static function add($message, $type = null )
	{

		$flasher = static::load();

		$message = new Message($message, $type);

		$flasher[] = $message;

		static::flash( $flasher );

	}


	public static function all( $type = null )
	{
		return static::filter( static::load(), $type );
	}

	public static function first( $type = null )
	{
		$all = static::all($type);
		return array_shift( $all );
	}

	public static function last( $type = null )
	{
		$all = static::all($type);
		return array_pop( $all );
	}

	public static function has( $type = null )
	{
		$all = static::all($type);
		return count( $all ) > 0;
	}


	public static function __callStatic($method, $parameters)
	{
		static::add( $parameters[0], $method );
	}


}
