<?php
define("TRANSLATE", true);
#helper do tlumaczenia
function add_tr($subject, $view = '')
{
	$router = registry::register("router");
	
	if(empty($view)) $view = $router->getController()."_".$router->getAction();
	$tr = registry::register('translator');
	
	return $tr->translate($subject, $view);
}

?>