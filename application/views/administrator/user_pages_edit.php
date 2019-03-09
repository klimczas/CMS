<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<!--strona edycji widoku strony -->
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="Mateusz Manaj - Marcin i Joanna" />

<?=add_basehref()?>

<?=stylesheet_load('format.css,style.css,_cfe.css')?>

<?=javascript_load('administrator/_cfe.js,
                    administrator/jquery-1.7.1.min.js,administrator/jquery.blockUI.js,administrator/main.js')?>

<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
    
<?=icon_load("pp_fav.ico")?>

</head>

<body>

<div class="wrapper">

    <div class="header">
        <div class="_fLeft"><img src="<?=directory_images()?>main_header_logo.gif" alt="logotype" /></div>
        <div class="_fRight loginInfo"><div class="_auth">ZALOGOWANY JAKO:<br /><span><?=model_load("dashboardmodel", "getCredentials", "")?></span> (<a href="administrator/wylogowanie">Wyloguj</a>)</div></div>
    </div>
    
    <div class="wrapright">
     	  
	    <div id="colRight">
	    	
	    	<ul id="breadcrumbs">
	    		<li><a href="<?=SERVER_ADDRESS.'administrator'?>">Dashboard</a></li>
	    		<li><img src="<?=directory_images()?>bc.gif" alt="bc" /></li>
	    		<li><a href="<?=SERVER_ADDRESS.'administrator/'?><?=model_load("user_pagesmodel", "getUserPagesMenuElement", "")?>">Moje strony</a></li>
	    		<li><img src="<?=directory_images()?>bc.gif" alt="bc" /></li>
	    		<li><a href="<?=SERVER_ADDRESS.'administrator/'?><?=model_load("user_pagesmodel", "getUserPagesMenuElement", "")?>/controller/<?=model_load('user_pages_editmodel', 'getControllerName', '')?>">Kontroler <?=model_load("user_pages_editmodel", "getControllerName", "")?></a></li>
	    		<li><img src="<?=directory_images()?>bc.gif" alt="bc" /></li>
	    		<li><a class="active" href="javascript:void(0);">Edycja strony</a></li>
	    	</ul>
	    	
	    	<h2>Edycja strony <?=model_load("user_pages_editmodel", "getControllerName", "")?></h2><br />
	    	
	    	<div class="customTable _m5 _fLeft">
                <div class="tableTitle">Tytuł strony</div>
                <div class="tableContent">
                    <input type="text" id="pageTitle" class="customInput _mt10 _w300" name="pageTitle" value="<?=model_load("user_pages_editmodel", "getPageTitle")?>" />
                </div>
                <div class="tableActionButtons"></div>
            </div>
            
            <br class="_cb" /><br />
            
            <textarea cols="100" id="editor1" name="editor1" rows="90"><?=model_load("user_pages_editmodel", "getContextEditor", "")?></textarea>
            <?=add_javascript(directory_javascript()."administrator/main.page_editor.js")?>
            <br />
            <div id="customLinkBtn" class="_m5 _fLeft"><a href="javascript:void(0);" onclick="saveUserPage('<?=model_load("user_pages_editmodel", "getControllerName", "")?>', '<?=model_load("user_pages_editmodel", "getMethodName", "")?>');">Zapisz zmiany</a></div>
            <br class="_cb" />
            
        </div>
        
	</div> 
       
    <div id="colLeft">
        <?=module_load("ADMINMENU")?>
    </div>
      
</div>

</body>
</html>