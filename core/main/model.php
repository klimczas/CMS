<?php
#model wczytany w wartstwie jądrze  moze wczytać inne modele z warstwy aplikacji
#robi to czego nie chce sie robic kontrolerowi
#
class model
{
	public function __get($model)
	{
		$config = registry::register("config");
		
		$_model = $model.'model';
		$modelfile = $config->model_path.$_model.".php"; #sciezka pliku z modelami
		
		if(!file_exists($modelfile))
		{
			$modelfile = "core/models/nullmodel.php";
			$_model = "nullmodel";
		}
		
		include_once($modelfile);
		
		$modelobj = registry::register($_model);
		
		return $modelobj;
	}
}

?>