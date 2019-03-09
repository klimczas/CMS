<?php

class homemodel
{
	private $config;
	
	public function __construct() #konstruktor
	{
		$this->config = registry::register("config");#rejestrowanie konfig
	}
	
	public function getLoginPanelTitle() #zmienia tytul panelu logowania
	{
		return (isset($_SESSION[$this->config->default_session_auth_var]) && !empty($_SESSION[$this->config->default_session_auth_var])) ? $_SESSION[$this->config->default_session_auth_var] : "Panel logowania";
	}
	
	public function addLogoutBtn() #dodaje przycisk wylogowania w momencie gdy jestesmy zalogowani
	{
		return (isset($_SESSION[$this->config->default_session_auth_var]) && !empty($_SESSION[$this->config->default_session_auth_var])) ? "<li><a id=\"logged\" href=\"wylogowanie/index\">Wyloguj</a></li>" : "";
	}
}

?>