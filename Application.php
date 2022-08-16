<?php

namespace Core;

use Exception;
use Core\DB\Database;

class Application
{
	public Router $router;
	public static Application $app;
	public ?Controller $controller = null;
	public Database $db;
	public ?UserModel $user;
	public string $userClass;
	public string $layout = 'main';


	public function __construct(
		array $config,
		public Request $request = new Request(),
		public Response $response = new Response(),
		public Session $session = new Session(),
		public View $view = new View,
	) {
		$this->router = new Router($this->request, $this->response);
		$this->db = new Database($config['db']);
		$this->userClass = $config['userClass'];
		self::$app = $this;

		$primaryKey = $this->userClass::primaryKey();
		$primaryValue = $this->session->get('user');
		if ($primaryValue) {
			$this->user = $this->userClass::findOne([$primaryKey => $primaryValue]);
		} else {
			$this->user = null;
		}
	}

	public function run()
	{
		try {
			echo $this->router->resolve();
		} catch (Exception $e) {
			$this->response->setStatusCode($e->getCode());
			echo $this->view->renderView('errors/error', [
				'code' => $e->getCode(),
				'message' => $e->getMessage()
			]);
		}
	}

	public function setController(Controller $controller): void
	{
		$this->controller = $controller;
	}

	public function getController(): Controller
	{
		return $this->controller;
	}

	public function login(UserModel $user)
	{
		$this->user = $user;
		$className = get_class($user);
		$primaryKey = $className::primaryKey();
		$value = $user->{$primaryKey};
		Application::$app->session->set('user', $value);

		return true;
	}

	public function logout()
	{
		$this->user = null;
		$this->session->remove('user');
	}

	public static function isGuest()
	{
		return !self::$app->user;
	}
}