<?php

ob_start(); #rozpoczynamy buforowanie

require_once("core/init.php");					// __autoload()

$router = registry::register("router"); #rejestrujemy klase router
dispatcher::dispatch($router);

$i18n = registry::register("i18n");
$i18n->setMainLanguage(); #wywolanie metody ktora ustawia jezyk

ob_end_flush(); #zakonczenie buforowania i wyswietlenie wszystkiego co jest w buforze

?>