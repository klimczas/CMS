<?php
if(!isset($_SESSION)) session_start();

echo "OBSŁUGA BŁĘDÓW!<br />";

echo "<pre>";
print_r($_SESSION);
echo "</pre><br /><hr /><br />";

if(isset($_SESSION['debug'])) #czy w zmiennej superglobalnej istnieje klucz debug
{
	echo base64_decode($_SESSION['debug']); #jesli tak to go wyświetl
}

?>