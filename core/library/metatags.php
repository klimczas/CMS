<?php

class metatags
{
	private $_config; # aby pobrac wszystkie ustawienia konfiguracyjne
    private $_router; # aby dostac sie do widoku
    private $_db; #baza danych aby odczytac jakies metatagi
    private $__view; #widok (w jakim widoku umiescic meta tagi )
	
	public function __construct($name = "")
	{
	    #nowe obiekty
		$this->_config = registry::register("config");
        $this->_router = registry::register("router");
        $this->_db = registry::register("db");
		
		$this->__view = (empty($name)) ? $this->_config->default_meta_tags_index : $name; #sprawdzamy czy zmienna name jest pusta
	}
	
	public function _load()
	{
	    #zapytanie MSQL
		$query = "SELECT * FROM meta_tags, meta_tags_index WHERE meta_tags.id = meta_tags_index.meta_tags_id AND meta_tags_index.name = '{$this->__view}'";
		$query = $this->_db->execute($query);
		
		return $query;
	}
}

?>