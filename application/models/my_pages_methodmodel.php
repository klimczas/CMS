<?php

class my_pages_methodmodel
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

        #rejestrujemy klase bledow
        $_errObject = registry::register("sgException");
        
		if(!isset($this->__params[1]) || !isset($this->__params[2])) $_errObject->errorPage(404);
		$this->__objectInfo = ReflectionUtil::getClassInfo($this->__params[1]);
		if(!$this->_validateController() || !ReflectionUtil::isMethodExists($this->__params[1], $this->__params[2])) $_errObject->errorPage(404);
        
    }

    #sprawdzamy kontroler
	private function _validateController()
	{
		return (!empty($this->__objectInfo));
	}

	#metody pomocne w tworzeniu pliku widoku
	public function getControllerName() { return $this->__params[1]; } #podaje nazwe kontrolera
    public function getMethodName() { return $this->__params[2]; } #podaje nazwe metody
    public function getControllerLinkTo() { return SERVER_ADDRESS."administrator/my_pages/controller/".$this->getControllerName(); }

    #bedzie zwracac gotowy kod html ze wszystkim czego tylko sie chce (
	public function getMethodManagement()
	{
		$result = "";
		$i = 0;
		$a = 0;
		$x = 0;
		
		$hookref = ReflectionUtil::getMethodHookProperties($this->getControllerName(), $this->getMethodName());
		$hooks[] = Array("i18n", "languageDetector"); #tablica wszsytkich haczykow w systemie
		
		$result .= '
        <p>Pole odnosi się do dodania haczyka na stronie</p><br />
        <table class="customTable" cellspacing="0">
        <tr class="legend">
            <td>LP.</td>
            <td>Nazwa haczyka</td>
            <td>Nazwa metody</td>
        </tr>';
		
		foreach($hooks as $hookkey => $hook)
		{
			$in = (!empty($hookref)) ? (in_array($hook[1], $hookref) ? "checked=\"checked\"" : "") : "";
			
			$result .= '
            <tr class="content">
                <td>'.++$a.'</td>
                <td>
                    <input type="checkbox" name="hook" class="inputText" id="hook'.$a.'" value="'.$hook[0]."#".$hook[1].'" '.$in.' />
                    <label class="inputLabel" for="hook'.$a.'">'.$hook[0].'</label>
                </td>
                <td>'.$hook[1].'</td>
            </tr>';
		}
		
		$result .= '</table><br /><br />';

		#obsulga modelow
		$model_files = FilesystemUtil::getFiles($this->__config->model_path);
		$modelref = ReflectionUtil::getMethodReferencesProperties($this->getControllerName(), $this->getMethodName(), 'model');
		
		if($modelref && !empty($modelref))
		{
			foreach($modelref as $mfile)
			{
				$mfilename = pathinfo($mfile);
				if(file_exists($this->__config->model_path.$mfilename['filename']."model.php"))
				{
					$fbody = ReflectionUtil::getClassMethods($mfilename['filename']."model");
				}
				else
				{
					$fbody = Array("- BRAK -");
				}
				
				$mfunctions[$mfilename['filename']] = $fbody;
			}
			
			$result .= '
	            <p>Zaznaczone pole odnosi się do wywołania metody modelu w kontrolerze</p><br />
	            <table class="customTable" cellspacing="0">
	                <tr class="legend">
	                    <td>LP.</td>
	                    <td>Nazwa modelu</td>
	                    <td>Metody modelu</td>
	                </tr>';
					
			foreach($mfunctions as $mfunctionName => $mfunction)
			{
				$in = in_array(substr($mfunctionName, 0, -5), $modelref) ? "checked=\"checked\"" : "";
				
				$result .= '
	                    <tr class="content">
	                    <td>'.++$x.'</td>
	                    <td>
	                        <input type="checkbox" name="module" class="inputText" id="model'.$x.'" value="'.$mfunctionName.'" '.$in.' />
	                        <label class="inputLabel" for="model'.$x.'">'.$mfunctionName.'</label>
	                    </td>
	                    <td>
	                        <a class="subtle" onClick="toggleModelList('.$x.');" href="javascript:void(0);">Pokaż/Schowaj listę</a>
	                        <ul class="allModuleLists" id="modelList'.$x.'" style="list-style: inside square;">';
							
				foreach($mfunction as $val)
				{
					$result .= "<li>".$val."</li>";
				}
				
				$result .= "</ul></td></tr>";
			}

			$result .= '</table><br /><br />';
		}
		else
		{
			$result .= '<h2>Brak powiązanych modeli</h2><br />';
		}
		
		$files = FilesystemUtil::getFiles($this->__config->helper_path);
        $moduleref = ReflectionUtil::getMethodReferencesProperties($this->getControllerName(), $this->getMethodName(), 'main');
		
		foreach($files as $file)
		{
			$fname = explode("_", $file);
			$fbody = ReflectionUtil::getFileFunctions($this->__config->helper_path.$file);
			
			$functions[$fname[0]] = $fbody[1];
		}
		
		$result .= '
        <p>Zaznaczone pole <ins>daje możliwość</ins> używania danej funkcji w kodzie widoku.</p><br />
        <table class="customTable" cellspacing="0">
            <tr class="legend">
                <td>LP.</td>
                <td>Nazwa modułu</td>
                <td>Funkcje modułu</td>
            </tr>';
			
		foreach($functions as $functionName => $function)
		{
			$in = in_array($functionName."_helper", $moduleref) ? "checked=\"checked\"" : "";
			
			$result .= '
                <tr class="content">
                <td>'.++$i.'</td>
                <td>
                    <input type="checkbox" name="module" class="inputText" id="module'.$i.'" value="'.$functionName.'_helper" '.$in.' />
                    <label class="inputLabel" for="module'.$i.'">'.$functionName.'</label>
                </td>
                <td>
                    <a class="subtle" onClick="toggleModuleList('.$i.');" href="javascript:void(0);">Pokaż/Schowaj listę</a>
                    <ul class="allModuleLists" id="moduleList'.$i.'" style="list-style: inside square;">';
					
			foreach($function as $val)
            {
                $result .= "<li>".$val."</li>";
            }
			
			$result .= '</ul></td></tr>';
		}

		$result .='</table><br />
		<div class="customLinkBtn _m5 _fLeft"><a href="javascript:void(0);" onClick="saveMethod(\''.$this->getControllerName().'\', \''.$this->getMethodName().'\');">Zapisz</a></div>
        <br class="_cb" />';
		
		return $result;
	}

	#edycja kodu html strony plus jej zapis
	public function getMethodEditor()
	{
		$result = '<textarea name="methodEditor" id="methodEditor">'.ReflectionUtil::getClassMethodSource($this->getControllerName(), $this->getMethodName()).'</textarea>
		<br />
        <div class="customLinkBtn _m5 _fLeft"><a href="javascript:void(0);" onClick="saveMethodSource(\''.$this->getControllerName().'\', \''.$this->getMethodName().'\');">Zapisz</a></div>
        <br class="_cb" />';
		
		return $result;
	}
}



















?>