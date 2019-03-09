<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">

<head>

<?=add_metatags()?>

<?=add_title("Design Klasy biznes - SuperCMS - Kontakt")?>

<?=add_basehref()?>

<?=stylesheet_load('screen.css')?>

<?=javascript_load('jQuery.js,jquery.validate.js,main.contact.js,main.js')?> 
    
<?=icon_load("pp_fav.ico")?>

</head>

<body>
 
<div id="header">
    <?=module_load('LOGINPANEL')?>
    <?=module_load('MENU')?>
</div>

<div id="slogan" class="produkty">
  <div class="content">
 	<div id="motto" class="motto-produkty"><a href="#">Busines Design</a></div>
  </div>
</div>

<div id="main">
  <div class="content">
        <div class="box-kontakt produkty-opis">
                
                	<h2>Formularz kontaktowy</h2>
                    
                    <div class="formularz">
                    
                    <form name="kontakt-form" id="kontakt-form" action="mailer/" method="POST">
                    
                    <table class="objTable">
                        
                        <tbody>
                            
                            <tr>
                                <td>Podaj imię:</td>
                                <td><input type="text" value="" name="name" class="required" minlength="3" /></td>
                                <td></td>
                            </tr>
                            
                            <tr>
                                <td>Twój e-mail:</td>
                                <td><input type="text" value="" name="mail" class="required email" /></td>
                                <td></td>
                            </tr>
                            
                            <tr>
                                <td>Temat:</td>
                                <td><input type="text" value="" name="subject" class="subject" class="required" minlength="10" /></td>
                                <td></td>
                            </tr>
                            
                            <tr>
                                <td>Wiadomość:</td>
                                <td><textarea name="msg" class="required" minlength="20">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam vestibulum 
                        enim ut risus molestie nec pretium urna faucibus. Donec malesuada, neque 
                        sit amet sodales tincidunt, eros velit lobortis nibh, sed pellentesque lorem 
                        enim eget sapien. Ut scelerisque faucibus metus, et varius elit luctus quis. 
                        Etiam fermentum, erat vitae porta ornare, metus nisi sodales urna, eget 
                        egestas ligula velit quis lorem. Nunc vestibulum tempus porta. Integer 
                        scelerisque malesuada lacus tempor mollis. Quisque convallis ornare purus, 
                        nec lacinia massa euismod vitae.
                       </textarea></td>
                                <td></td>
                            </tr>
                            
                            <tr>
                                <td></td>
                                <td><input type="checkbox" checked="true" id="sent-to-me" /><label for="sent-to-me">Wyślij mi kopię tej wiadomości</label>
                                <td></td>
                            </tr>
                            
                        </tbody>
                        
                    </table>
                    
                       <br /><br />
                       
                       <input type="submit" name="submit-form" class="submit-form" value="Wyślij wiadomość" />
                       </form>
                       <br /><br /><br /><br />
                    
                    </div>
                    
                </div>
  </div>
</div>

<?=module_load('FOOTER')?>

</body>
</html>