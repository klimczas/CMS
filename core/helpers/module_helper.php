<?php
define("MODULE", true);
#wczytywanie modołow czyle elementow ktore sie nie zmianiaja na stronie
function module_load($module)
{
	$config = registry::register("config");
	$module = strtolower($module); #konwertujemy na małe litery
	$module_path = $config->module_path.$module.'_module'."/"; #odnosimyy sie do koniguracji i dopisujemy nasz modół
	
	if(!file_exists($module_path.$module.'.php')) #jesli ten plik nie istnieje
	{
		return "<script type=\"text/javascript\">alert(\"UWAGA!\\nNie znaleziono plików modułu '".$module."'\");</script>"; 
	}
	
	include_once($module_path.$module.'.php'); #włączamy pliki modułu aby były wykorzystane w systemie
	return ;
}

?>