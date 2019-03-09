<?php

class my_modulesmodel
{
    #zmienne członkowskie
    private $__config;
    private $__router;
    private $__db;
    private $__params;

    #konstruktor który uzupełnia te dane członkowskie
	public function __construct()
    {
        $this->__config = registry::register("config");
        $this->__router = registry::register("router");
        $this->__db = registry::register("db");
        $this->__params = $this->__router->getParams();
	}

	#metoda która bedzie wylistowywać wszystkie moduły
	public function drawModulesList()
	{
		$i = 0;
		$result = "<table class=\"customTable\" cellspacing=\"0\">\n
        <tr class=\"legend\">
            <td>Lp.</td>
            <td>Nazwa modułu</td>
            <td>Opis</td>
            <td>Akcje</td>
        </tr>";
		
		$allModules = FilesystemUtil::getFiles($this->__config->module_path);
		
		if(!empty($allModules))
		{
			foreach($allModules as $module)
			{
				$fileCommDesc = ReflectionUtil::getFileCommentDescription($this->__config->module_path.$module."/".substr($module, 0, -7).".php", "ModuleDesc");
				$_fcd = (empty($fileCommDesc)) ? "Brak opisu" : $fileCommDesc[0];
				
				$result .= "<tr>
					<td>".++$i."</td>
					<td>$module</td>
					<td>$_fcd</td>
					<td><a class=\"subtle\" href=\"".SERVER_ADDRESS."administrator/my_modules/view/".substr($module, 0, -7)."\">Edycja modułu</a> | <a class=\"subtle\" href=\"javascript:void(0);\" onClick=\"removeModule('".substr($module, 0, -7)."');\">Usuń moduł</a></td>
				</tr>";
			}
			
			$result .= "</table>";
		}
		
		return $result;
		
	}
}

?>