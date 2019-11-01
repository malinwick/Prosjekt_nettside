<?php
require "header.php"; 
?>

    <div class="title-ditt_kollektiv">
        <h2>Ditt kollektiv</h2>
    </div>



    <?php

        // det som skal vises når man er pålogget
        if (isset($_SESSION['userId'])) {
            
            echo '    <ul class="ditt_kollektiv-class">
            <div class="menu">
                <li><a href="handleliste.php">Handleliste</a></li>
                <li><a href="oppgjor.php">Oppgjør</a></li>
                <li><a href="vaskeliste.php">Vaskeliste</a></li>
            </div>
            <div class="menu">
                <li><a href="medlemmer.php">Medlemmer</a></li>
                <li><a href="rombooking.php">Rombooking</a></li>
                <li><a href="varsler.php">Varsler</a></li>
            </div>
        </ul>';
        
            // Alt som skal vises hvis du er medlem i et kollektiv
            if (isset($_SESSION['kollektivId'])) {
                echo '<p class="login-status">Du er medlem av et kollektiv.</p>
                <form action="includes/leaveKoll.inc.php" method="post">
                <div class="forlat">
                <button class="forlat_kollektiv"type="submit" name="leaveKoll-submit">Forlat kollektivet</button>
                </div>
                </form>'; 
            }
            // Alt som skal vises hvis du ikke er medlem i et kollektiv
            else {
                echo '<div class="ikke-medlem">
                <p>Du er ikke medlem av et kollektiv. Lag et nytt eller bli lagt til i et eksisterende kollektiv.</p>
                <form class="form-addKoll" action="includes/addKoll.inc.php" method="post">
                    <input class="kollektivnavn_input" type="text" name="Kollektiv_navn" placeholder="Skriv kollektivnavn her">
                    <button class="btn-legg_til" id="btn" type="submit" name="kollektiv-submit">Legg til</button>
                </form>
                </div>';
            }
        }
        else {
            echo '<p class="ikke-pålogget"> Du må være pålogget for å vise denne siden!</p>'; 
        }

        // feilmeldinger: 

        if (isset($_GET['error'])) {
            if ($_GET['error'] == "emptyfields") {
                echo '<p class="signuperror">Fyll inn kollektivnavn</p>'; 
            }
            elseif ($_GET['error'] == "invalidname") {
                echo '<p class="signuperror">Ugyldig kollektivnavn</p>';
            }
            elseif ($_GET['error'] == "usertaken") {
                echo '<p class="signuperror">Kollektivnavn er opptatt</p>';
            }
            elseif ($_GET['error'] == "sqlerrormedlemmer") {
                echo '<p class="signuperror">Feil i database medlemmer</p>';
            }
        }
        elseif (isset($_GET['makeKoll'])) {
            if ($_GET['makeKoll'] == "success") {
                echo '<p class="signupsuccess"></p>';
            }
        }
        elseif (isset($_GET['LeaveKoll'])) {
            if ($_GET['LeaveKoll'] == "success") {
                echo '<p class="signupsuccess"></p>';
            }
        }

    ?>


</body>
</html>