<?php

class user_pages_editmodel
{
    #zmienne członkowskie
    private $__config;
    private $__router;
    private $__db;
    private $__params;
    private $__objectInfo;
    private $__code;
	private $__method;

    #rejestracja odpowiadających  im elementy
	public function __construct()
    {
        $this->__config = registry::register("config");
        $this->__router = registry::register("router");
        $this->__db = registry::register("db");
        $this->__params = $this->__router->getParams();
        
        $_errObject = registry::register("sgException");
		
		if(!isset($this->__params[1])) $_errObject->errorPage(404);
		$this->__objectInfo = ReflectionUtil::getClassInfo($this->__params[1]);

		#przekierowanie na strone bledu 404
		if(!$this->_validateController()) $_errObject->errorPage(404);
		
		$this->__method = (isset($this->__params[2]) && !empty($this->__params[2])) ? $this->__params[2] : "index";
		$this->__code = FilesystemUtil::getSource($this->__config->view_path.$this->getControllerName()."/".$this->__method.".php");
    }

    #przekiruj na strone 404
	public function _validateController()
	{
		return (!empty($this->__objectInfo));
	}

	#zwraca wzgledem tego co wpislalimy w pasku adresu, nazwe naszego kontrolera
	public function getControllerName()
    {
        $obj = pathinfo($this->__objectInfo['filename']);
        return $obj['filename'];
    }

    #zwraca nazwe metody
	public function getMethodName()
    {
        return $this->__method;
    }

    #pobranie tytulu z gotowego kodu
	public function getPageTitle()
	{
		$w = preg_match('/add_title\\((\'|")([a-zA-Z0-9\-\s\ł\ę\ó\ł\ą\ś\ł\ż\ź\ć\ń]+)/', $this->__code, $m);
		return (!empty($m) && count($m) >= 3) ? $m[2] : "";
	}

    #pozbywamy sie tagu body
	private function substrTag($content, $stag, $ctag)
	{
		if(strpos($content, $stag) !== false && strpos($content, $ctag) !== false)
		{
			$_sBody = strpos($content, $stag);
			$_cBody = strpos($content, $ctag);
			
			return substr($content, $_sBody + strlen($stag), $_cBody - $_sBody - strlen($stag));
		}
		
		return $content;
	}

	#bedziemy zamieniac  na odpowiedni katalog z obrazkami
	private function dirImages($content)
	{
		return str_replace("<?=directory_images()?>", $this->__config->app_images_path, $content);
	}

	#podmienianie na [sTr]$2[eTr]
	private function replaceTranslationTags($code)
	{
		$w = preg_replace('/<\?=add_tr\\((\'|")([a-zA-Z0-9\-\s\ł\ę\ó\ł\ą\ś\ł\ż\ź\ć\ń]+)(\'|")[^,]\?>/i', '[sTr]$2[eTr]', $code);
		return $w;
	}

	#bedzie poebierac tresc dla edytora na tej stronie
	public function getContextEditor()
	{
	    #pozbywamy sie tagu body
		$result = $this->substrTag($this->__code, "<body>", "</body>");

		$result = $this->dirImages($result);
		$result = $this->replaceTranslationTags($result);
		#uodpornimy kod na wszystkie znkai specjalne
		$result = htmlspecialchars($result);
		
		return $result;
	}
}




















?>