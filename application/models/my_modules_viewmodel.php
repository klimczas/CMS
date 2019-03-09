<?php

class my_modules_viewmodel
{

    #zmienne członkowskie
    private $__config;
    private $__router;
    private $__db;
    private $__params;
    private $__objectInfo;

    #uzupełnienie zmiennych członkowskich
	public function __construct()
    {
        $this->__config = registry::register("config");
        $this->__router = registry::register("router");
        $this->__db = registry::register("db");
        $this->__params = $this->__router->getParams();
        
        $_errObject = registry::register("sgException");
		
		if(!isset($this->__params[1])) $_errObject->errorPage(404);
		if(!$this->_validateModule($this->__params[1])) $_errObject->errorPage(404);
    }

    #metoda która validuje samą nazwę modułu
	private function _validateModule($module)
	{
		if(!file_exists($this->__config->module_path.$module."_module/".$module.".php"))
		{
			return false;
		}
		
		return true;
	}

	#pobiera nazwe modułu
	public function getModuleName()
	{
		return $this->__params[1];
	}

    #metoda ktora bedzie rysowaćgotowy edytor
	public function getModuleEditor()
	{
		$result = '<textarea name="moduleEditor" id="moduleEditor">'.FilesystemUtil::getSource($this->__config->module_path.$this->getModuleName()."_module/".$this->getModuleName().".php").'</textarea>';
		return $result;
	}
	
	
	
}

?>