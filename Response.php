<?php

namespace Core;

class Response
{
	public function setStatusCode($code)
	{
		http_response_code($code);
	}

	public function redirect(string $url): never
	{
		header("Location: $url");
		exit;
	}
}