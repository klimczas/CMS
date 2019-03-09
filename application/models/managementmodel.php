<?php

class managementmodel
{
    #zmienne członkowskie
	private $__config;
    private $__router;
    private $__db;
    private $__params;

    #oknstruktor który rejestruje te zmiennne
	public function __construct()
    {
        $this->__config = registry::register("config");
        $this->__router = registry::register("router");
        $this->__db = registry::register("db");
        $this->__params = $this->__router->getParams();
    }

    #wybiera wszystkie tabele które zaczynaja sie od tr
	private function getTranslationsTables()
    {
        $q = $this->__db->execute("SHOW TABLES");
        $bufor = Array();
        
        foreach($q as $val)
        {
            if(substr($val['Tables_in_'.$this->__config->db_name], 0, 3) == "tr_")
            {
                $bufor[] = $val['Tables_in_'.$this->__config->db_name];
            }
        }
        
        return $bufor;
    }

    #pobiera wszsytkie dostepne jezyki w bazie
	private function getAvailableLangs($tbl_name)
	{
		$q = $this->__db->execute("SELECT DISTINCT lang FROM $tbl_name");
		if(empty($q))
		{
			return ;
		}
		else
		{
			foreach($q as $lang)
			{
				$res[] = "<img src=\"".directory_images()."flags/".strtolower($lang['lang']).".png\" alt=\"".$lang['lang']."\" />";
			}
		}
		
		return $res;
	}

#lista wszystkich tłumaczen i nazw tłumaczen
	public function drawTranslationsTable()
	{

		$res = '<table class="text wideTable">
                        <tr class="legend">
                            <td>Nazwa</td>
                            <td class="sec">ID tłumaczenia</td>
                            <td class="thd">Języki strony</td>
                            <td>Funkcje</td>
                        </tr>';
						
		$langs = Array();
		
		$tbls = $this->getTranslationsTables();
		foreach($tbls as $tbl)
		{
			$cols = "";
			$res .= '<tr class="content">
                        <td><strong>'.str_replace("_", "/", substr($tbl, 3)).'</strong></td>';
			
			$q = $this->__db->execute("SHOW COLUMNS IN $tbl");
			
			foreach($q as $key => $val)
			{
				if($val['Field'] != "id" && $val['Field'] != "lang")
				{
					$cols .= $val['Field'].", ";
				}
			}
			
			$res .= "<td>".rtrim($cols, ", ")."</td>";
            $res .= "<td>".implode("&nbsp;", $this->getAvailableLangs($tbl))."</td>";
			$res .= '<td><input type="submit" value="Edycja" onclick="window.location.replace(\''.SERVER_ADDRESS.'administrator/management/translationEditor/'.$tbl.'\');" class="customBtn editBtn _m5" />
                         <input type="submit" value="Usuń" onclick="removeTranslation(\''.$tbl.'\');" class="customBtn removeBtn _m5" /></td>
                    </tr>';
		}

		$res .= "</table>";
		
		return $res;
	}
}

?>