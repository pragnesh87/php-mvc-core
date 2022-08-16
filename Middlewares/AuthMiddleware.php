<?php

namespace Core\Middlewares;

use Core\Application;
use Core\Enums\HttpStatus;
use Core\Exceptions\ForbiddenException;

class AuthMiddleware extends BaseMiddleware
{
	public function __construct(public array $actions = [])
	{
	}

	public function execute()
	{
		if (Application::isGuest()) {
			if (
				empty($this->actions)
				|| in_array(Application::$app->controller->action, $this->actions)
			) {
				throw new ForbiddenException();
			}
		}
	}
}