<?php

class articlesmodel
{
    #zmienne członkowskie
    private $__config;
    private $__router;
    private $__db;
    private $__params;

    #konsruktor aby zalokować(rejestrujący) zmienne
    public function __construct()
    {
        $this->__config = registry::register("config");
        $this->__router = registry::register("router");
        $this->__db = registry::register("db");
        $this->__params = $this->__router->getParams();
	}

	#wyswietlanie tabeli ze wszystkimi artykulami
	public function drawArticlesList()
	{
		$result = "<table class=\"text wideTable\" cellspacing=\"0\">\n
		<tbody>
        <tr class=\"legend\">
            <td style=\"min-width: 30px!important\">ID</td>
            <td>Tytuł artykułu</td>
            <td style=\"max-width: 600px!important\">Skrócona treść</td> 
            <td>Data dodania</td>
            <td>Autor</td>
            <td>Ocena</td>
            <td>Funkcje</td>
        </tr>";
		
		$articles = $this->__db->execute("SELECT articles.id, articles.title, articles.text, articles.date, articles.author, SUM(ocena) as ocena 
		FROM articles 
		LEFT JOIN votes on articles.id = votes.id_artykul 
		GROUP BY votes.id_artykul");
		
		if(!empty($articles))
		{
			foreach($articles as $article)
			{
				$result .= "<tr class=\"content\">
					<td style=\"min-width: 30px!important\">{$article['id']}</td>
					<td>{$article['title']}</td>
					<td style=\"max-width: 600px!important\">".substr($article['text'], 0, 497)."...</td>
					<td>{$article['date']}</td>
					<td>{$article['author']}</td>
					<td>{$article['ocena']}</td>
					<td><a class=\"subtle\" href=\"".SERVER_ADDRESS."administrator/articles/view/".$article['id']."\">Edycja artykułu</a> | <a class=\"subtle\" href=\"javascript:void(0);\" onClick=\"removeArticle('".$article['id']."');\">Usuń artykuł</a></td>
				</tr>";
			}

			$result .= "</tbody></table>";
		}

			return $result;
	}
}



















?>