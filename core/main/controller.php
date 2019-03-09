<?php

Abstract class controller
{
	public $params; #parametry przekazywane do kontrolera glownego
	public $post;
	public $template; #nazwa szablonu uzywanego w systemie
	public $_ActionHooks = Array(); #lista metod wykonane przed rozpoczeciem wykonania akzji z paska adresu
	
	abstract public function main();
	
	public function __construct($params = Array()) #konstruktor
	{
		$this->params = $params;
	}
	
	public function __get($var) #metoda magiczna get
	{
		if($var == "params")
		{
			return $this->params;
		}
		else
		{
			return registry::register($var);
		}
	}
	
	public function addSubpage($view, $subpage) #metoda sluzy do dodanai podstrony
	{
		if(isset($this->params[0]))
		{
			if($this->params[0] == $subpage)
			{
				$templatefile = $view."_".$this->params[0];
				$this->view->setTemplate($templatefile);
				$this->model->$templatefile;
			}
		}
	}
	
	public function setParams($params)
	{
		$this->params[] = $params;
	}
	
	public function setPostParams($post) #przekazanie prametrow w post
	{
		$this->post = $post;
	}
	
	public function setView($view) #ustawia aktualny widok
	{
		$this->template = $view;
	}
	
	public function addHook($callbackFunc) # lista metod wykonane przed rozpoczeciem wykonania akzji z paska adresu
	{
		$this->_ActionHooks[$callbackFunc] = $callbackFunc;
	}
	
	public function getActionHooks() #pobiera wszsytkie elementy z tablicy i je zwraca
	{
		return $this->_ActionHooks;
	}
}

?>