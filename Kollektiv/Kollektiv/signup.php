<?php
require "header.php"; 

?>

    <main>
        <div class="wrapper-main">
            <section class="section-default">

                <?php
                    if (isset($_GET['error'])) {
                        if ($_GET['error'] == "emptyfields") {
                            echo '<p class="signuperror">Fyll inn alle felt!</p>'; 
                        }
                        elseif ($_GET['error'] == "invalidmailuid") {
                            echo '<p class="signuperror">Ugyldig brukernavn og passord!</p>';
                        }
                        elseif ($_GET['error'] == "invaliduid") {
                            echo '<p class="signuperror">Ugyldig brukernavn!</p>';
                        }
                        elseif ($_GET['error'] == "invalidmail") {
                            echo '<p class="signuperror">Ugyldig epost!</p>';
                        }
                        elseif ($_GET['error'] == "passwordcheck") {
                            echo '<p class="signuperror">Dine passord er ikke like!</p>';
                        }
                        elseif ($_GET['error'] == "usertaken") {
                            echo '<p class="signuperror">Brukernavn er opptatt!</p>';
                        }
                    }
                    if (isset($_GET['signup'])) {
                        if ($_GET['signup'] == "success") {
                            echo '<p class="signupsuccess">Registrering fullført!</p>';
                        }
                    }
                ?>

                <form class="form-signup" action="includes/signup.inc.php" method="post">
                    <input class="btn-signup" type="text" name="uid" placeholder="Brukernavn">
                    <input class="btn-signup" type="text" name="mail" placeholder="E-post">
                    <input class="btn-signup" type="password" name="pwd" placeholder="Passord">
                    <input class="btn-signup" type="password" name="pwd-repeat" placeholder="Gjenta passord">
                    <button class="btn-signup" id="btn" type="submit" name="signup-submit">Registrer deg</button>
                </form>
            </section>
        </div>    
    </main>

    <div class="title">
        <h1>Kollektivet</h1>
    </div>

<?php
    require "footer.php"; 
?>