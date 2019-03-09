<?php

class artykulymodel
{
	private $config;
    private $params;
    private $router;
    private $db;

    #konsruktor aby zalokować zmienne
	public function __construct()
	{
		$this->config = registry::register("config");
        $this->router = registry::register("router");
        $this->db = registry::register("db");
		$this->params = $this->router->getParams();
	}
	#metoda ktora bedzie pobierac aktualny limit np(na stronie wyswietl po: 5 artykulow)
	public function getLimit()
	{
		if(isset($this->params['POST']['ilosc']))
		{
			if($this->params['POST']['ilosc'] == "ALL")
			{
				$limit = "<optgroup label=\"OSTATNIO:\"><option value=\"ALL\">wszystkie artykuły</option></optgroup>";
			}
			else
			{
				$limit =  "<optgroup label=\"OSTATNIO:\">
				<option value=\"{$this->params['POST']['ilosc']}\">po {$this->params['POST']['ilosc']} artykule</option>
				</optgroup>\n";
			}
		}
		else
		{
			$limit = "";
		}
		
		return $limit;
	}

	#metoda zwraca ostatnio wybrany sort (sposob sortowania)
	public function getSort()
	{
		if(isset($this->params['POST']['sort']))
		{
			$sort = "<optgroup label=\"OSTATNIO:\">";
			
			switch($this->params['POST']['sort'])
			{
				case "title":
				$sort .= "<option value=\"title\">Tytułu</option>";
				break;
					
				case "date":
				$sort .= "<option value=\"date\">Daty dodania</option>";
				break;
					
				case "author":
				$sort .= "<option value=\"author\">Autora</option>";
				break;
					
				case "vote":
				$sort .= "<option value=\"vote\">Rankingu</option>";
				break;
			}
			
			$sort .= "</optgroup>";
		}
		else
		{
			$sort = "";
		}
		
		return $sort;
	}

	#metoda zwracajaca rosnaco lub malejaco
	public function getAsc()
	{
		if(isset($this->params['POST']['sort-asc-desc']))
		{
			if($this->params['POST']['sort-asc-desc'] == "ASC")
			{
				$asc = "<optgroup label=\"OSTATNIO:\">
				<option value=\"".$this->params['POST']['sort-asc-desc']."\">Rosnąco</option>
                </optgroup>";
			}
			else
			{
				$asc = "<optgroup label=\"OSTATNIO:\">
                <option value=\"".$this->params['POST']['sort-asc-desc']."\">Malejąco</option>
                </optgroup>\n";
			}
		}
		else
		{
			$asc = "";
		}
		
		return $asc;
	}
	#glowna metoda aby wyswietlic artykuly
	public function getArticles()
	{
		$v = registry::register("voter");
		
		if(isset($this->params['POST']['ilosc']))
		{
			$limit = ($this->params['POST']['ilosc'] == "ALL") ? "" : "LIMIT {$this->params['POST']['ilosc']}";
			
			if($this->params['POST']['sort'] == "vote")
			{
				$articles = $this->db->execute("SELECT articles.id, articles.title, articles.text, articles.date, articles.author, votes.id_user, AVG(votes.ocena) AS ocena FROM articles LEFT JOIN votes ON articles.id=votes.id_artykul GROUP BY votes.id_artykul ORDER BY ocena {$this->params['POST']['sort-asc-desc']} {$limit}");
			}
			else
			{
				$articles = $this->db->execute("SELECT * FROM articles ORDER BY {$this->params['POST']['sort']} {$this->params['POST']['sort-asc-desc']} {$limit}");
			}
		}
		else
		{
			$articles = $this->db->execute("SELECT * FROM articles");
		}
		
		$login = (isset($_SESSION[$this->config->default_session_auth_var])) ? "" : "<span style=\"float:right;\"><a href=\"#top\">Zaloguj się</a> lub <a href=\"rejestracja/\">zarejestruj</a>, aby móc oceniać!</span>";
		
		foreach($articles as $article)
		{
			echo '
            <div class="artykul">
                <h3 class="title">'.$article['title'].'</h3>
                <p class="sub-title">Dodano: '.$article['date'].' przez '.$article['author'].'</p> 
                '.$article['text'].'<br />';
                            
                echo $v->RatingGenerator($article['id']);   
                echo $login.'
                        
            </div>';
                
                echo '<img src="'.directory_images().'hr.gif" alt="HR" id="hr" />';
		}
	}

	public function saveVote()
	{
		$res = false;
		
		if(isset($this->params['POST']['rating']))
		{
			$v = registry::register("voter");
			$artId = 0;
			$artVote = 0;
			
			foreach($this->params['POST'] as $key => $val)
			{
				if(substr($key, 0, 5) == "artId")
				{
					$artId = (int)substr($key, 6);
					$artVote = $val;
				}
			}
			
			$res = $v->setVote($artVote, $_SESSION['login'], $artId);
		}
		
		echo ($res) ? "true" : "Wystąpił błąd podczas zapisywania Twojego głosu! Przepraszamy!";
	}
}

?>