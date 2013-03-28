<?php

namespace Flasher;

use Laravel\Config;


class Message {


	public $message;

	public $type;


	public function __construct($message, $type=null)
	{
		$this->message = $message;
		$this->type = $type;
	}

	public function format( $format = null )
	{

		if ( $format === null ) {
			$format = Config::get('flasher.format', Config::get('flasher::flasher.format', ':message') );
		}

		return str_replace(
			array(':type',      ':message' ),
			array( $this->type, $this->message ),
			$format
		);

	}

	public function __toString()
	{
		return $this->format();
	}


}
