<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">

<head>

<?=add_metatags()?>

<?=add_title("Design Klasy biznes - SuperCMS")?>

<?=add_basehref()?>

<?=stylesheet_load('screen.css,allRating.css')?>

<?=javascript_load('jQuery.js,jquery.allRating.js,main.rating.js,main.js')?> 
    
<?=icon_load("pp_fav.ico")?>

</head>

<body>
 
<div id="header">
    <?=module_load('LOGINPANEL')?>
    <?=module_load('MENU')?>
</div>

<div id="slogan" class="artykuly">
  <div class="content">
 	<div id="motto" class="motto-artykuly"><a href="#">Business Design</a></div>
  </div>
</div>

<div id="main">
  <div class="content">
        <div class="box-artykuly produkty-opis">
       	    <img src="<?=directory_images()?>naglowek1-produkty.jpg" alt="HEADER" id="art-header" />
            <div id="art-tools">
                <form name="art-tools" method="POST" action="">
                    
                        <ul>
                        
                            <li class="ilosc">
                            
                                <label for="ilosc">Wyświetl </label>
                            
                                <select name="ilosc" id="ilosc">
                                	
                                	<?=model_load('artykulymodel', 'getLimit', '')?>
                                    
                                    <option value="1">po 1 artykule</option>
                                    <option value="3">po 3 artykuły</option>
                                    <option value="5">po 5 artykułów</option>
                                    <option value="10">po 10 artykułów</option>
                                    <option value="20">po 20 artykułów</option>
                                    <option value="ALL">wszystkie artykuły</option>
                                
                                </select>
                            </li>
                            
                            <li class="sort">
                            
                                <label for="sort">posortowane wg. </label>
                            
                                <select name="sort" id="sort">
									
									<?=model_load('artykulymodel', 'getSort', '')?>
									
                                    <option value="title">Tytułu</option>
                                    <option value="date">Daty dodania</option>
                                    <option value="author">Autora</option>
                                    <option value="vote">Rankingu</option>
                                
                                </select>
                            </li>
                            
                            <li class="sort-asc-desc">
                                <select name="sort-asc-desc" id="sort-asc-desc">
                                    
                                    <?=model_load('artykulymodel', 'getAsc', '')?>
                                    
                                    <option value="ASC">Rosnąco</option>
                                    <option value="DESC">Malejąco</option>
                                
                                </select>
                            </li>
                            
                            <li class="btn">
                            
                                <input type="submit" name="submit-filter" class="submit-filter" value="filtruj" />
                            
                            </li>
                        
                        </ul>
                    
                    </form>
                    </div>
                    
                    <?=model_load('artykulymodel', 'getArticles', '')?>
                    
        </div>
  </div>
</div>

<?=module_load('FOOTER')?>

</body>
</html>