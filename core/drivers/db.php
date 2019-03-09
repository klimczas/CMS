<?php

class db
{
	public $result = Array(); #rezultat naszych poczynań
	private $connect; #hendler połaczenia bazodanowego
	
	public function __construct($_host=false, $_user=false, $_pass=false, $_name=false)#sposób na ominięcie problemu łączenia się zewnętrznego kodu
	{
		$config = registry::register("config");
		#przypisanie do zmiennych lokalnych tej klasy
		$host = $config->db_host;
        $user = $config->db_user;
        $pass = $config->db_pass;
        $name = $config->db_name;
		
		if(!isset($host)) #warunek spełniony gdy łączymy się z zewnętrznego kodu
		{
			$host = $_host;
            $user = $_user;
            $pass = $_pass;
            $name = $_name;
		}
		
		if($host === false)
		{
			die('Nie przekazano danych dostępowych do bazy.');
		}
		
		$this->connect = new mysqli($host, $user, $pass, $name);#nowy egzemplarz klasy mysqli
		if(mysqli_connect_errno() !== 0) #sprawdzam czy jest blad połączenia
		{
			throw new Exception("Błąd połączenia z bazą danych : ".mysqli_connect_error());
		}
		else
		{
			$this->connect->query("SET NAMES 'utf8'"); #wszystko co pobieramy z bazy miało kodowanie utf8
			return $this->connect;
		}
	}
	
	public function execute($sql) #bedzie wykonywac polecenie podane w parametrze
	{
		$query_arr = explode(" ", trim($sql));
		$query_type = strtoupper($query_arr[0]); #wszytsko co podajemy nie miałe znaczenia dla skryptu czy duże czy małe litery itp
		
		if($query_type == 'SELECT' || $query_type == 'SHOW')
		{
			return $this->selectable($sql);
		}
		else if($query_type == 'UPDATE' || $query_type == 'DELETE' || $query_type == 'DROP' || $query_type == 'INSERT' || $query_type == 'ALTER' || $query_type == 'CREATE')
		{
			return $this->modifiable($sql);
		}
		
		return false;
	}
	
	private function selectable($query)
	{
		$this->result = array();
		
		$wynik = $this->connect->query($query);
		if(!$wynik)
		{
			return false;
		}
		else
		{
			while (($db_result = $wynik->fetch_assoc()) !== null)
			{
				array_push($this->result, $db_result);
				// mozna stosowac zamiennie $this->result[] = $db_result;
			}
			
			return $this->result;
		}
		
		$this->close();
	}
	
	private function modifiable($query)
	{
		$this->result = array();
		
		$wynik = $this->connect->query($query);
		return (!($wynik)) ? false : true;
	}
	
	public function getRow() #zwraca tablice wierszy  pobrana wczesniej z bazy
	{
		$row = mysqli_fetch_row($this->result);
		return $row;
	}
	
	public function count() #zliczy to co zaznaczylismy w bazie
	{
		$count = count($this->result);
		return (!$count || !is_int($count)) ? 0 : $count;
	}
	
	public function close() #zamykamy polaczenie bazodanowe
	{
		if($this->connect) mysqli_close($this->connect);
	}
	
	public function __destruct() #dodatkowy close na bazie danych
	{
		$this->close();
	}
}

?>