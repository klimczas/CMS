<?php

class main
{
	public function __get($name)
	{
		$arr = explode("_", $name);#rozdielamy metatags a helper
		$filename = $arr[0]."_".$arr[1].".php";
		$type = $arr[1];
		
		include_once($filename);
		
		if(!defined(strtoupper($arr[0]))) #jesli nie ma stales zdefiniowanej
		{
			throw new Exception("Błąd wczytania pliku '{$filename}' !");
		}
	}
	
	static public function _templateLoader($controller, $template) #nazwa kontroler/szablon
	{
		$config = registry::register("config"); #plik konfiguracyjny aby użyc sciezek bezwglednych
		$templatefile = $config->view_path.$controller."/".$template.".php"; #sciezka do szablonu ktory chcemy wczytac
		
		if(file_exists($templatefile)) #sprawdzam czy plik istnieje
		{
			include_once($templatefile);
		}
		else
		{
			$error = registry::register("sgException");
			$error->throwException("Widok ".$template.".php jest niedostępny w lokalizacji ".$config->view_path.$controller);
		}
	} 
}

?>