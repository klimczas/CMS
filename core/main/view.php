<?php
#opracowanie klasy view która będzie stanowić o tym jaki będzie wczytany szablon oraz pozostałe opcje tej klasy będą wykonywane podczas wczytywania szablonu
class view
{
	private $vars = Array();
	private $template;
	
	public function __get($var)
	{
		return registry::register($var); #zwraca konstruktor egzamplarza klasy podanego w zmiennej var
	}
	
	public function __set($key, $value)
	{
		$this->vars[$key] = $value;
	}
	
	public function setTemplate($template) #ustawienie szablonu
	{
		$this->template = $template;
	}
	
	public function getTemplate($controller = null) #pobranie nazwy szablonu
	{
		return (empty($this->template)) ? $controller : $this->template;
	}
	#metoda która do aktualnego widoku wczyta jakiś inny plik
	public function addExternalView($controller, $view = "index")
	{
		$config = registry::register("config");
		$filepath = $config->view_path.$controller."/".$view.".php";
		
		if(file_exists($filepath)) include_once($filepath);
	}
}

?>