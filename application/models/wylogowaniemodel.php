<?php

class wylogowaniemodel
{
	private $__config;
	#wylogowanie i przekierowanie po wylogowaniu na home
	public function __construct()
	{
		$this->__config = registry::register("config");
		if(isset($_SESSION[$this->__config->default_session_auth_var])) #sprawdzamy czy jestesmy zalogowani aby moc sie wylogowac
		{
			unset($_SESSION[$this->__config->default_session_auth_var]);

			if(isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER']))
			{
				header("Location: ".$_SERVER['HTTP_REFERER']);
			}
			else
			{
				header("Location: ".SERVER_ADDRESS."home/index");
			}
		}
	}
}

?>