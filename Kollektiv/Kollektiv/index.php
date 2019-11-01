<?php
require "header.php"; 

?>

    <main>
        <div class="wrapper-main">
            <section>
            <?php
                if (isset($_SESSION['userId'])) {
                    echo '<p class="login-status"></p>'; 
                }
                else {
                    echo '<p class="login-status"></p> 
                    <div class="button">
                    <a href="login.php" class="btn" name="logginn">LOGG INN</a>
                    <a href="signup.php" class="btn" name="registrerdeg">REGISTRER DEG</a>
                    </div>';
                }
            ?>
            </section>
        </div>    
    </main>

    <div class="title">
        <h1>Kollektivet</h1>
    </div>


<?php
    require "footer.php"; 
?>
