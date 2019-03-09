<?php
#działania na obiekcie router
class dispatcher
{
	public static function dispatch($router)
	{
		ob_start(); #rozpoczynamy buforowanie
		$config = registry::register("config"); #rejetrujemy nasza klase configuracji
		$sgException = registry::register("sgException"); #rejetrujemy nasza klase sgexception
		
		if($router instanceof router)
		{
		    #przypisanie do zmiennych
			$controller     = $router->getController();
            $action         = $router->getAction();
            $params         = $router->getParams();
		}
		else
		{
			$sgException->throwException("Router nie został znaleziony lub nie jest instancją tej klasy.");
		}
		
		$controllerfile = $config->controller_path.$controller.".php"; #cala sciezka dostepu do tego kontrolera
		
		if(!file_exists($controllerfile))
		{
			$sgException->throwException("Kontroler '".$controller."' nie został znaleziony w systemie!");
		}
		
		include_once($controllerfile);
		$sys = new $controller($params); #nowy egzemplarz klasy kontroler
		$sys->$action(); #odnosimy sie do akcji z paski adresu
		
		ob_start();#rozpoczynamy buforowanie
		#rejestrujemy nasz widok
		$view = registry::register("view");
		
		if(!empty($sys->template)) $view->setTemplate($sys->template);
		
		$template = $view->getTemplate($action);
		
		main::_templateLoader($controller, $template);
	}
}

?>