<?php

class my_pages_controllermodel
{
    #zmienne członkowskie
	private $__config;
    private $__router;
    private $__db;
    private $__params;
    private $__objectInfo;

    #rejestracja odpowiadających  im elementy
	public function __construct()
	{
		$this->__config = registry::register("config");
        $this->__router = registry::register("router");
        $this->__db = registry::register("db");
        $this->__params = $this->__router->getParams();
        
        $_errObject = registry::register("sgException");
		
		if(!isset($this->__params[1])) $_errObject->errorPage(404);
		if(!$this->_validateController($this->__params[1])) $_errObject->errorPage(404);


		$this->__objectInfo = ReflectionUtil::getClassInfo($this->__params[1]);
	}

	#zwraca nazwe kotrolera
	public function getControllerName()
	{
		$obj = pathinfo($this->__objectInfo['filename']);
		return $obj['filename'];
	}

	#zwraca true lub false
	private function _validateController($controller)
	{
		return (!empty($controller));
	}

	#sprawdzamy po kim dziedziczy kontroler
	public function getParent()
	{
		$parent = ReflectionUtil::hasParent($this->getControllerName());
		return ($parent) ? $parent : "Brak";
	}

	#wyswietla okno  z informacjami na temat konkretnej strony
	public function getFileProperties()
	{
		$prop = FilesystemUtil::getProperties($this->__config->controller_path.$this->getControllerName().".php");
		$result = '
		<table class="customTable separate" cellspacing="0">
            <tr class="content">
                <td class="nrb">Nazwa pliku</td>
                <td><strong>'.$prop['pathinfo']['dirname'].'/'.$prop['pathinfo']['basename'].'</strong></td>
                <td class="nrb">Rozmiar</td>
                <td><strong>'.$prop['size']['kB'].' kB</strong></td>
            </tr>
            <tr class="content">
                <td class="nrb">Data utworzenia</td>
                <td><strong>'.date("d-m-Y H:i:s", $prop['created']).'</strong></td>
                <td class="nrb">Data modyfikacji</td>
                <td><strong>'.date("d-m-Y H:i:s", $prop['modified']).'</strong></td>
            </tr>
            <tr class="content">
                <td class="nrb">Uprawnienia</td>
                <td><strong>'.FilesystemUtil::_formatFilePermission($prop['perms']).'</strong></td>
                <td class="nrb">Właściciel</td>
                <td><strong>'.FilesystemUtil::_formatFileOwner($prop['owner']).'</strong></td>
            </tr>
        </table>';
        
		return $result;
	}

	#wyswietla tabelke z dostepnymi podstronami oraz modyfikatorami
    #zarzadzanie strona (menu)
	public function getFileManagement()
	{
		$methods = ReflectionUtil::_filterMethodByUserDefined(ReflectionUtil::getClassMethods($this->getControllerName()));
		$i = 0;
		
		$result = '
        <table class="customTable" cellspacing="0">
            <tr class="legend">
                <td>LP.</td>
                <td>Dostępne podstrony</td>
                <td>Modyfikator</td>
            </tr>';
			
		foreach($methods as $method)
		{
			$result .= '
			<tr>
				<td>'.++$i.'</td>
				<td><input type="checkbox" name="subpage" class="inputText" id="subpage'.$i.'" value="'.$method.'" /><label class="inputLabel" for="subpage'.$i.'">'.$method.'</label></td>
				<td><div class="customLinkBtn _m5 _fLeft"><a href="'.SERVER_ADDRESS.$this->getControllerName().'/'.$method.'">Podgląd</a></div>
                        <div class="customLinkBtn _m5 _fLeft"><a href="'.SERVER_ADDRESS.'administrator/my_pages/method/'.$this->getControllerName().'/'.$method.'">Właściwości</a></div>
                        <div class="customLinkBtn _m5 _fLeft"><a href="'.SERVER_ADDRESS.'administrator/user_pages/edit/'.$this->getControllerName().'/'.$method.'">Edytuj widok</a></div>
                        <br class="_cb" />
                </td>
			</tr>';
		}
		
		$result .= "</table>";
		
		return $result;
	}

	#edyzja kodu stony w panelu administratora
	public function getControllerEditor()
	{
		$result = '<textarea name="controllerEditor" id="controllerEditor">'.FilesystemUtil::getSource($this->__config->controller_path.$this->getControllerName().".php").'</textarea>';
		
		return $result;	
	}

	#wyswietla liste wszystkich stron
	public function getCharacteristics()
	{
		$methods = ReflectionUtil::_filterMethodByUserDefined(ReflectionUtil::getClassMethods($this->getControllerName()));
		
		$result = "<table class=\"customTable\" cellspacing=\"0\">\n
        <tr class=\"legend\">
            <td>Lista podstron</td>
            <td>Powiązane modele</td>
            <td>Powiązane moduły</td>
            <td>Powiązane strony</td>
        </tr>";
		
		foreach($methods as $method)
		{
			$mref = ReflectionUtil::getMethodReferencesProperties($this->getControllerName(), $method, 'model');
			$moduleref = ReflectionUtil::getMethodReferencesProperties($this->getControllerName(), $method, 'main');
			$fref = ReflectionUtil::getMethodReferencesFunction($this->getControllerName(), $method, 'addSubpage');
			
			$result .= "<tr class=\"content\">
                <td>".$method."</td>
                <td><ul>";
				
			if(!$mref)
			{
				$result .= "<li>Brak powiązań z modelami</li>";
			}
			else
			{
				foreach($mref as $ref)
				{
					$result .= "<li>".$ref."</li>";
				}
			}
			
			$result .= "</ul></td>
            <td><ol>";
			
			if(!$moduleref)
			{
				$result .= "<li>Brak powiązań z modułami</li>";
			}
			else
			{
				foreach($moduleref as $modref)
				{
					$result .= "<li>".$modref."</li>";
				}
			}
			
			$result .= "</ol></td>
			<td><ol>";
			
			if(!$fref)
			{
				$result .= "<li>Brak powiązania</li>";
			}
			else
			{
				foreach($fref as $funcref)
				{
					$result .= "<li>".$funcref."</li>";
				}
			}
			
			$result .= "</ol></td></tr>\n";
		}

			$result .= "</table>\n";
			
			return $result;
	}
}




















?>