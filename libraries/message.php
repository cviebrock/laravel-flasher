<?php

namespace Flasher;


class Message {


	public $message;

	public $type;


	public function __construct($message, $type=null)
	{
		$this->message = $message;
		$this->type = $type;
	}

	public function __toString()
	{
		return $this->message;
	}

}
