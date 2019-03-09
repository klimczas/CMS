<?php
define("HEAD", true);

function icon_load($url) #dodaje icone do naszej strony
{
	if(!empty($url)) #sprawdza czy url nie jest pusty
	{
		$url = (substr($url, 0, 1) == "/") ? substr($url, 1) : $url;
		return "<link href=\"".SERVER_ADDRESS.$url."\" rel=\"shortcut icon\" type=\"image/x-icon\" />\n";
	}
	else
	{
		return ;
	}
}

function add_title($title) #dodaje tytl
{
	if(!empty($title)) #sprawdza czy ten parametr jest pusty
	{
		return "<title>{$title}</title>";
	}
	else
	{
		return ;
	}
}

function add_basehref()  #wpisuje base href
{
	return "<base href=\"".SERVER_ADDRESS."\" />";
}

?>