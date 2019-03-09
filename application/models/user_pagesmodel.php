<?php

class user_pagesmodel
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
	}

	#sprawdza kto jest aktualnie zalogowany w systemie
	public function getUserPriv()
	{
		return $_SESSION[$this->__config->default_session_admin_priv_var];
	}

	#zwraca odpowiedni string w zaleznosci od tego kto jest zalogowany aby przekierowac na dobra strone
	public function getUserPagesMenuElement()
	{
		return ($this->getUserPriv() == "admin") ? "my_pages" : "user_pages";
	}

	#bedzie pobierac wszystkie metody z danje klasy
	public function _getAllClassMethods()
	{
		$files = FilesystemUtil::getFiles($this->__config->controller_path);
		
		foreach($files as $file)
		{
			$result[ReflectionUtil::getClassName($file)] = ReflectionUtil::_filterMethodByUserDefined(ReflectionUtil::getClassMethods(ReflectionUtil::getClassName($file)));
		}
		
		return $result;
	}

	#wyświetla widok dla użytkownika
	public function drawAllSitesTables()
	{
		$info = $this->_getAllClassMethods();
		
		foreach($info as $key => $val)
		{
			$fprop = FilesystemUtil::getProperties($this->__config->controller_path.$key.".php");
			
			echo '
            <div class="customTable _m5 _fLeft">
                <div class="tableTitle">Strona '.strtoupper($key).'</div>
                <div class="tableContent">
                    
                    <br />
                    <div id="customLinkBtn" class="_m5 _fLeft"><a href="'.SERVER_ADDRESS.'administrator/user_pages/edit/'.$key.'">EDYCJA STRONY</a></div>
                    <div id="customLinkBtn" class="_m5 _fLeft"><a href="javascript:void(0);" onclick="removePage(\''.$key.'\');">SKASUJ</a></div>
                    <br class="_cb" />
                    
                </div>
                <div class="tableActionButtons"></div>
            </div>';
		}
	}
	
}