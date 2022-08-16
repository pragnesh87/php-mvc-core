<?php

namespace Core;

use Core\Middlewares\BaseMiddleware;

class Controller
{
	public string $layout = 'main';
	public string $action = '';

	/**
	 * @var BaseMiddleware[]
	 */
	protected array $middlewares = [];

	public function setLayout(string $layout): void
	{
		$this->layout = $layout;
	}
	public function render($view, $params = [])
	{
		return Application::$app->view->renderView($view, $params);
	}

	public function registerMiddleware(BaseMiddleware $middleware)
	{
		$this->middlewares[] = $middleware;
	}

	public function getMiddlewares()
	{
		return $this->middlewares;
	}
}