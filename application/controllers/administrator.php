<?php

class administrator extends controller
{
	public function __call($method, $args)
	{
		if(!is_callable($method))
		{
			$this->sgException->errorPage(404);
		}
	}
	
	public function main() { }
	
	public function index()
	{
		$this->model->administrator; #łaczy sie z modelem administratormodel.php
			
		$this->main->metatags_helper;
		$this->main->head_helper;
		$this->main->loader_helper;
		$this->main->module_helper;
		$this->main->model_helper;
		$this->main->directory_helper;
		$this->main->translate_helper;
	}
	
	public function dashboard()
	{
		$this->model->administrator; #sprawdza czy uzytkownik jest zalogowany jesli jest pozstaje jesli nie z powrotem do logowania
			
		$this->main->metatags_helper;
		$this->main->head_helper;
		$this->main->loader_helper;
		$this->main->module_helper;
		$this->main->model_helper;
		$this->main->directory_helper;
		$this->main->translate_helper;
	}
	
	public function management()
	{
		$this->model->administrator;
		
		$this->addSubpage(__FUNCTION__, "translationCreator");
		$this->addSubpage(__FUNCTION__, "translationEditor"); #dodajemy podstrone translator editor
			
		$this->main->metatags_helper;
		$this->main->head_helper;
		$this->main->loader_helper;
		$this->main->module_helper;
		$this->main->model_helper;
		$this->main->directory_helper;
		$this->main->translate_helper;
	}
	
	public function my_pages()
	{
		$this->model->administrator;
		
		$this->addSubpage(__FUNCTION__, "controller");#podstrona z kontrolerami
		$this->addSubpage(__FUNCTION__, "method"); #podstrona w ktorej bedziemy modyfikowac wszystkie metody kontrolera
			
		$this->main->metatags_helper;
		$this->main->head_helper;
		$this->main->loader_helper;
		$this->main->module_helper;
		$this->main->model_helper;
		$this->main->directory_helper;
		$this->main->translate_helper;
	}
	
	public function user_pages()
	{
		$this->model->administrator;
		
		$this->addSubpage(__FUNCTION__, "edit");
			
		$this->main->metatags_helper;
		$this->main->head_helper;
		$this->main->loader_helper;
		$this->main->module_helper;
		$this->main->model_helper;
		$this->main->directory_helper;
		$this->main->translate_helper;
	}

	#moduły
	public function my_modules()
	{
		$this->model->administrator;
		
		$this->addSubpage(__FUNCTION__, "view");
			
		$this->main->metatags_helper;
		$this->main->head_helper;
		$this->main->loader_helper;
		$this->main->module_helper;
		$this->main->model_helper;
		$this->main->directory_helper;
		$this->main->translate_helper;
	}
	
	public function wylogowanie()
	{
		$this->model->administrator->logout();
	}
	
	public function articles()
	{
		$this->model->administrator;
		
		$this->addSubpage(__FUNCTION__, "view");
			
		$this->main->metatags_helper;
		$this->main->head_helper;
		$this->main->loader_helper;
		$this->main->module_helper;
		$this->main->model_helper;
		$this->main->directory_helper;
		$this->main->translate_helper;
	}
}

?>