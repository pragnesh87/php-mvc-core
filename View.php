<?php

namespace Core;

use Core\Constants\Path;

class View
{
	public string $title = '';

	public function renderView($view, array $params = [])
	{
		$viewContent = $this->renderOnlyView($view, $params);
		$layoutContent = $this->layoutContent();
		return str_replace("{#content#}", $viewContent, $layoutContent);
	}

	public function renderContent($viewContent)
	{
		$layoutContent = $this->layoutContent();
		return str_replace("{#content#}", $viewContent, $layoutContent);
	}

	protected function layoutContent()
	{
		$layout = Application::$app->layout;
		if (Application::$app->controller) {
			$layout = Application::$app->controller->layout;
		}

		ob_start();
		include_once Path::$ROOT_DIR . "/Views/layouts/$layout.php";
		return ob_get_clean();
	}

	protected function renderOnlyView($view, $params)
	{
		extract($params);
		ob_start();
		include_once Path::$ROOT_DIR . "/Views/$view.php";
		return ob_get_clean();
	}
}