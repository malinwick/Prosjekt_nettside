<?php
require "header.php"; 

?>

<div class="header-login">
                <?php
                        echo '<form action="includes/login.inc.php" method="post" class="login_field">
                        <input class="btn" type="text" name="mailuid" placeholder="Skriv brukernavn/e-post...">
                        <input class ="btn"type="password" name="pwd" placeholder="Skriv passord...">
                        <button class="btn" id="btn" type="submit" name="login-submit">Logg inn</button>
                    </form>   '; 
                    
                ?>
                
</div> 

<div class="title">
        <h1>Kollektivet</h1>
</div>