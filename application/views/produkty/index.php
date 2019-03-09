<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>

<?=add_metatags()?>

<?=add_title("Design Klasy biznes - SuperCMS - Usługi i ceny")?>

<?=add_basehref()?>

<?=stylesheet_load('screen.css')?>

<?=javascript_load('jQuery.js,script.js,main.js')?> 
    
<?=icon_load("pp_fav.ico")?>

</head>

<body><div id="header">
	<?=module_load('LOGINPANEL')?><?=module_load('MENU')?></div>
<div class="produkty" id="slogan">
	<div class="content">
		<div class="motto-produkty" id="motto">
			<a href="#">Busines Design</a></div>
	</div>
</div>
<div id="main">
	<div class="content">
		<div class="column">
			<div class="box produkty-opis">
				<?=add_tr("wprowadzenie")?><?=add_tr("testowe")?></div>
		</div>
		<div class="column">
			<div class="box produkty-cechy">
				<?=add_tr("rozwoj")?></div>
		</div>
	</div>
</div>
<?=module_load('FOOTER')?></body>
</html>