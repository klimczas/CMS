<?php
define("MODEL", true);

#załadowanie modelu która bedzie wczytywać konretną metodę do naszego widoku
function model_load($model, $method = '', $params = Array())
{
	$model = registry::register($model);
	
	if(!empty($method))
	{
		$method = $model->$method($params); #wykonanie tej motody
	}
	
	return $method;
}

?>