<?php

namespace Core\Exceptions;

use Core\Enums\HttpStatus;
use Exception;

class NotFoundException extends Exception
{
	protected $code;
	protected $message = "URL you're accessing not found.";

	public function __construct()
	{
		$this->code = HttpStatus::Not_Found->value;
	}
}