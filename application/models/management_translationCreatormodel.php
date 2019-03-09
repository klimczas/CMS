<?php

class management_translationCreatormodel
{
    #zmienne członkowskie
	private $__config;
    private $__router;
    private $__db;
    private $__params;

    #konsruktor aby zalokować zmienne
	public function __construct()
    {
        $this->__config = registry::register("config");
        $this->__router = registry::register("router");
        $this->__db = registry::register("db");
        $this->__params = $this->__router->getParams();
        
        $_errObject = registry::register("sgException");
		
		# __params[1] - Nazwa strony
        # __params[2] - Akcja dla tej strony (zapis, usunięcie, itd...)


		if(isset($this->__params[0]) && isset($this->__params['POST']['newTranslation'])) $this->_addNewTranslation();
	}

	#dodaj nowe tłumaczenie
	private function _addNewTranslation()
    {
    	$name = "tr_".$this->__params['POST']['name'];
		unset($this->__params['POST']['newTranslation'], $this->__params['POST']['name']);
		
		# Utwórz nową tabelę w bazie danych
		$this->__db->execute("CREATE TABLE {$name} (id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
													lang VARCHAR(10) NOT NULL)
													ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_polish_ci");
													
		# Przygotuj 2 stosy
        $id_stack = Array();
        $lang_stack = Array();
		
		foreach($this->__params['POST'] as $key => $val)
		{
			if((stripos($key, 'id') !== false) && (!empty($val)))
			{
				$id_stack[] = $val;
			}
			elseif((stripos($key, 'lang') !== false) && (!empty($val)))
			{
				$lang_stack[] = $val;
			}
		}
		
		if(!empty($id_stack) && !empty($lang_stack))
		{
			// Dodaj wiersze
			foreach($lang_stack as $key => $val)
			{
				$this->__db->execute("INSERT INTO $name VALUES (NULL, '{$val}')");
			}
			
			// Dodaj kolumny
			foreach($id_stack as $key => $val)
			{
				$this->__db->execute("ALTER TABLE $name ADD $val LONGTEXT NOT NULL");
			}
		}
		else
		{
			return false;
		}
	}
}





















?>