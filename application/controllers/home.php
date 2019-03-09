<?php

class home extends controller
{
	public function __call($method, $args) #wykonuje sie gdy podajemy jakas metode do klasy home
	{
		if(!is_callable($method))
		{
			$this->sgException->errorPage(404); #jeśli nie widać tej moetody przekieruj na strone 404
		}
	}
	
	public function main() { } #moze sie jeszcze przydac aby wykonywac ja domyslnie
	
	public function index()
	{
		$this->addHook($this->i18n->languageDetector()); #jaki jest domyslny jezyk usera
		
		$this->main->metatags_helper; #do pliku main.php zostaje wczytany plik metatags_helper itd
		$this->main->head_helper;
		$this->main->loader_helper;
		$this->main->module_helper;
		$this->main->model_helper;
		$this->main->directory_helper;
		$this->main->translate_helper;
	}
}

?>