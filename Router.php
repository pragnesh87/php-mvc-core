<?php

namespace Core;

use Core\Constants\Path;
use Core\Enums\HttpStatus;
use Core\Exceptions\NotFoundException;

class Router
{
	private array $routes = [];
	public string $title = '';

	public function __construct(
		public Request $request = new Request(),
		public Response $response = new Response(),
	) {
	}

	public function get($path, $callback): void
	{
		$this->routes['get'][$path] = $callback;
	}

	public function post($path, $callback): void
	{
		$this->routes['post'][$path] = $callback;
	}

	public function resolve()
	{
		$path = $this->request->getPath();
		$method = $this->request->getMethod();
		$callback = $this->routes[$method][$path] ?? false;

		if ($callback === false) {
			throw new NotFoundException;
		} elseif (is_string($callback)) {
			return Application::$app->view->renderView($callback);
		} elseif (is_array($callback)) {
			/**
			 * @var Controller
			 */
			$controller = new $callback[0];
			Application::$app->controller = $controller;
			$controller->action = $callback[1];
			$callback[0] = $controller;

			foreach ($controller->getMiddlewares() as $middleware) {
				$middleware->execute();
			}
		}

		return call_user_func($callback, $this->request, $this->response);
	}
}