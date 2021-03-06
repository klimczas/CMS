<?php

class translator extends i18n #clasa translator rozszerzona o klase i18n
{
	private function assemblyName($obj) #
	{
		if(is_object($obj))
		{
			return get_class($obj); #zwraca nazwe klasy tego obiektu
		}
		else if(is_string($obj))
		{
			return $obj; # zwraca wartosc tego stingu (obj)
		}
		else
		{
			return ;
		}
	}

	#funkcja dokonująca tłumaczenia i odwowyłać się prosto z bazy danych do tłumaczeń
	public function translate($subject, $view)
	{
		$view = $this->assemblyName($view);

		#rejestrujemy baze danych
		$db = registry::register("db");
        $sgException = registry::register("sgException");
        $conf = registry::register("config");

        #zapytanie wykonywane w trakcie pobierania tlumaczenia z  bazy
		$query = "SELECT {$subject} FROM tr_{$view} WHERE lang='{$this->getDefaultLanguage()}'"; // tr_home_index
		$query = $db->execute($query);
		
		if($conf->no_lang_action == "SET_404")
		{
			if(!$query) $sgException->errorPage(404);
		}
		else if($conf->no_lang_action == "SET_ERROR_TEXT")
		{
			if(!$query) return $conf->no_lang_error_text;
		}
		else
		{
			if(!$query) return ;
		}
		
		return $query[0][$subject];
		
	}
}

?>