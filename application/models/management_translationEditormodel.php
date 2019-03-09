<?php

class management_translationEditormodel
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
        
        if(!isset($this->__params[1])) $_errObject->errorPage(404); #sprawdzamy czy params 1 jest ustawiony jesli nie przekieruj na strone 404
        if(!$this->_validateTablename($this->__params[1])) $_errObject->errorPage(404);
        if(isset($this->__params[2]) && !$this->_validateColumnname($this->__params[2])) $_errObject->errorPage(404); #sprawdza czy mamy dodatkowe parametry
    }

    #sprawdza nazwe tabeli. jesli jest pusta zwraca false jeśli nie pusta zwraca true
	private function _validateTablename($param)
    {
        $q = $this->__db->execute("SELECT * FROM ".addslashes($param));
        return !empty($q);
    }
    #sprawdza nazwe kolumny jesli jest pusta zwraca false jeśli nie pusta zwraca true
	private function _validateColumnname($column)
    {
        $q = $this->__db->execute("SELECT ".$column." FROM ".$this->__params[1]);
        return !empty($q);
    }

    #zwracamy zamieniajac _ na spacje.
	public function getTranslationSubject()
	{
		return str_replace("_", " ", substr($this->__params[1], 3));
	}

	#wszystkie kolumny ktore edytujemy w postaci linkow
	public function getTranslationButtonIDs()
	{
		$res = "";
		$nextCol = count($this->getTranslationID($this->__params[1])) + 3;
		
		foreach($this->getTranslationID($this->__params[1]) as $key => $val)
		{
			$res .= '<div id="customLinkBtn" class="_m5 customInlineBtn"><a href="'.SERVER_ADDRESS.'administrator/management/translationEditor/'.$this->__params[1].'/'.$val.'">'.$val.'</a></div>';
		}
		
		$res .= '<div id="customLinkBtn" class="_m5 customInlineBtn"><a href="javascript:addNewtranslationID(\''.$this->__params[1].'\', \'tekst'.$nextCol.'\');">+ DODAJ NOWY</a></div>';
		
		return $res;
	}
	#wszystkie nazwy kolmun (zwraca tablice z tymi elementami)
	private function getTranslationID($tbl_name)
    {
        $q = $this->__db->execute("SHOW COLUMNS IN $tbl_name");
        $bufor = Array();
        
        foreach($q as $key => $val)
        {
            if($val['Field'] != "id" && $val['Field'] != "lang")
                $bufor[] = $val['Field'];
        }
        
        return $bufor;
    }

    #ma wyswietlac wszsytkie dostepne edytory ze wszsytkimi tlumaczeniami
	public function getTranslationEditors()
	{
		$langs = $this->getAvailableLangs($this->__params[1]);
		$res = "";
		
		foreach($langs as $key => $lang)
		{
			$res .= '<p>Język tłumaczenia: <strong>'.strtoupper($lang).'</strong></p><textarea class="codeMirrorArea" id="code'.$key.'" name="'.$lang.'">'.$this->getTranslationText($lang).'</textarea><br /><br />';
		}
		
		return $res;
	}

	#jakie języki ą przypisane do konretnej kolumny
	private function getAvailableLangs($tbl_name)
	{
		$res = Array();
		$q = $this->__db->execute("SELECT DISTINCT lang FROM $tbl_name");
		
		if(!empty($q))
		{
			foreach($q as $lang)
			{
				$res[] = $lang['lang'];
			}
		}

		return $res;
	}

	#pobiera tekst tłumaczenia
	private function getTranslationText($lang)
	{
		if(!isset($this->__params[2]))
		{
			$col = $this->getTranslationID($this->__params[1]);
		}
		else
		{
			$col = $this->__params[2];
		}
		
		$q = $this->__db->execute("SELECT $col FROM {$this->__params[1]} WHERE lang = '{$lang}'");
		
		return $q[0][$col];
	}

	#zwraca do jakiej tabeli i kolumny chcemy się odnieść
	public function getTranslationInfoLoc()
	{
		return $this->__params[1].";".$this->__params[2];
	}
}

?>