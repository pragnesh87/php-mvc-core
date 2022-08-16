<?php

namespace Core\Exceptions;

use Core\Enums\HttpStatus;
use Exception;

class ForbiddenException extends Exception
{
	protected $code;
	protected $message = "You don't have permission to access this page.";

	public function __construct()
	{
		$this->code = HttpStatus::Forbidden->value;
	}
}