<?php

namespace Core;

class Request
{
	public function getPath(): string
	{
		$path = $_SERVER['REQUEST_URI'];
		$position = strpos($path, '?');
		if ($position !== false) {
			$path = substr($path, 0, $position);
		}
		return $path;
	}

	public function getMethod(): string
	{
		return strtolower($_SERVER['REQUEST_METHOD']);
	}

	public function isGet(): bool
	{
		return $this->getMethod() === 'get';
	}

	public function isPost(): bool
	{
		return $this->getMethod() === 'post';
	}

	//QUERY_STRING

	public function getBody()
	{
		$body = [];
		if ($this->isGet()) {
			foreach ($_GET as $key => $value) {
				$body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
			}
		}

		if ($this->isPost()) {
			foreach ($_POST as $key => $value) {
				$body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
			}
		}

		return $body;
	}

	public function getGet($key)
	{
		$gets = [];
		if ($this->isGet()) {
			foreach ($_GET as $key => $value) {
				$gets[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
			}
		}
		return $gets;
	}

	public function getPost()
	{
		$posts = [];
		if ($this->isPost()) {
			foreach ($_POST as $key => $value) {
				$posts[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
			}
		}
		return $posts;
	}
}