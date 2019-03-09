<?php

class router #tak jak nazwa pliku gdyż taką stosujemy notacje
{
	private $controller;
	private $action;
	private $params; #tablica parametrow z naszego paska adresu
	
	public function __construct()
	{
		$config = registry::register("config");#rejestrujemy klase konfiguracji
		
		if(!isset($_GET['page']))
		{
			$path = $config->default_controller;
		}
		else
		{
			$path = $_GET['page'];
		}
		
		/* http://www.example.com/controller/action/param1/.../paramN */
		
		$routParts = explode("/", $path);
		
		$this->controller = $routParts[0]; #pierwszy element po rozdzielniu to kontroler
		$this->action = isset($routParts[1]) ? $routParts[1] : "index";

		#usuwamy pierwsze dwa elementy tablicy
		array_shift($routParts);
		array_shift($routParts);
		
		$this->params = $routParts;
	}
	
	public function getController()
	{
		return $this->controller;
	}
	
	public function getAction()
	{
		return $this->action;
	}
	
	public function getParams()
	{
		if(isset($_POST) && count($_POST) > 0)
		{
			foreach($_POST as $key => $val)
			{
				$this->params['POST'][$key] = $val;
			}
		}
		
		return $this->params;
	}
}

?>