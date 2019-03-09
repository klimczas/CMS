<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">


<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="Mateusz Manaj - Marcin i Joanna" />

<?=add_basehref()?>

<?=stylesheet_load('format.css,
                    style.css,
                    _cfe.css,
                    themes/base/jquery.ui.core.css,
                    themes/base/jquery.ui.tabs.css,
                    themes/custom-theme/jquery-ui-1.8.17.custom.css,
                    CodeMirror/codemirror.css,
                    CodeMirror/theme/elegant.css')?>

<?=javascript_load('administrator/_cfe.js,
                    administrator/jquery-1.7.1.min.js,
                    jquery/jquery-ui-1.8.17.custom.min.js,
                    jquery/jquery.ui.core.js,
                    jquery/jquery.ui.widget.js,
                    jquery/jquery.ui.tabs.js,
                    administrator/jquery.blockUI.js,
                    administrator/main.js,
                    administrator/main.tabs.js,
                    CodeMirror/codemirror.js,
                    CodeMirror/mode/javascript/javascript.js,
                    CodeMirror/mode/css/css.js,
                    CodeMirror/mode/xml/xml.js,
                    CodeMirror/mode/clike/clike.js,
                    CodeMirror/mode/php/php.js')?> 
    
<?=icon_load("pp_fav.ico")?>
<style>.CodeMirror { font-size: 12px !important; font-family: monospace; border: 1px solid #bab8b8; }
.CodeMirror-scroll { height: 600px; overflow-x: auto; width: 100% }
</style>
</head>

<body>

<div class="wrapper">

    <div class="header">
        <div class="_fLeft"><img src="<?=directory_images()?>main_header_logo.gif" alt="logotype" /></div>
        <div class="_fRight loginInfo"><div class="_auth">ZALOGOWANY JAKO:<br /><span><?=model_load("dashboardmodel", "getCredentials", "")?></span> (<a href="administrator/wylogowanie">Wyloguj</a>)</div></div>
    </div>
    
    <div class="wrapright">
     	  
	    <div id="colRight">
	    	
	    	<a href="administrator/my_modules/">Powrót</a>
        
            <div id="tabs">
            	<ul>
            		<li><a href="#tabs-1">Edycja kodu</a></li>
            	</ul>
            	<div id="tabs-1" style="min-width: 600px;">
            		<?=model_load("my_modules_viewmodel", "getModuleEditor", "")?>
            		<br />
            		<div id="customLinkBtn" class="_m5 _fLeft"><a href="javascript:void(0);" onclick="saveModule('<?=model_load("my_modules_viewmodel", "getModuleName", "")?>');">Zapisz</a></div>
                    <br class="_cb" />
                    
                    <script>
                      var editor = CodeMirror.fromTextArea(document.getElementById("moduleEditor"), {
                        lineNumbers: true,
                        lineWrapping: true,
                        matchBrackets: true,
                        mode: "application/text-html",
                        indentUnit: 4, 
                        indentWithTabs: true,
                        enterMode: "keep",
                        tabMode: "shift",
                        theme: "elegant"
                      });
                      
                      function getCode()
                      {
                        return editor.getValue();
                      }
                    </script>
                    
            	</div>
            </div>
            
        </div>
        
	</div> 
       
    <div id="colLeft">
        <?=module_load("ADMINMENU")?>
    </div>
      
</div>

</body>
</html>