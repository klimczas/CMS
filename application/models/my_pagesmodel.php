<?php

class my_pagesmodel
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
    }

#nazwy wszystkich metod z danej clasy
	private function _getAllClassMethods()
	{

		$files = FilesystemUtil::getFiles($this->__config->controller_path);
		foreach($files as $file)
		{
			$result[ReflectionUtil::getClassName($file)] = ReflectionUtil::_filterMethodByUserDefined(ReflectionUtil::getClassMethods(ReflectionUtil::getClassName($file)));
		}
		
		return $result;
	}
	#skanujemy caly katalog controollesrs w poszukiwaniu plikow oraz ich wlasciwosci
    #oraz wyswietla informacje na temat kazdej strony
	public function drawAllSitesTables()
	{
		$res = "";
		$info = $this->_getAllClassMethods();

		foreach($info as $key => $val)
		{
			$fprop = FilesystemUtil::getProperties($this->__config->controller_path.$key.".php");
			
			$res .= '<div class="customTable _m5 _fLeft">
					<div class="tableTitle">Strona '.$fprop['pathinfo']['filename'].'</div>
					<div class="tableContent">
						
						<br />
						<div id="customLinkBtn" class="_m5 _fLeft"><a href="'.SERVER_ADDRESS.'administrator/my_pages/controller/'.$key.'">WŁAŚCIWOŚCI</a></div>
						<div id="customLinkBtn" class="_m5 _fLeft"><a href="javascript:void(0);" onclick="removePage(\''.$key.'\');">SKASUJ</a></div>
						<br class="_cb" />
						
						<table class="text">
							<tr>
								<td>Nazwa pliku: </td>
								<td><strong>'.$fprop['pathinfo']['filename'].'.'.$fprop['pathinfo']['extension'].'</strong></td>
							</tr>
							<tr>
								<td>Rozmiar: </td>
								<td><strong>'.$fprop['size']['kB'].' kB</strong></td>
							</tr>
							<tr>
								<td>Utworzony: </td>
								<td><strong>'.date("d-m-Y H:i:s", $fprop['created']).'</strong></td>
							</tr>
							<tr>
								<td>Zmodyfikowany: </td>
								<td><strong>'.date("d-m-Y H:i:s", $fprop['modified']).'</strong></td>
							</tr>
							<tr>
								<td>Uprawnienia: </td>
								<td><strong>'.FilesystemUtil::_formatFilePermission($fprop['perms']).'</strong></td>
							</tr>
							<tr>
								<td>Podstron: </td>
								<td><strong>'.count($val).'</strong></td>
							</tr>
						</table>
						
					</div>
					<div class="tableActionButtons"></div>
				</div>';
		}

		return $res;
	}
}
	
?>