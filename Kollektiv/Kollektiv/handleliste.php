<?php
require "header.php"; 
?>


<div class="title-menu">
    <h1>Handleliste</h1>
</div>


<?php

if (isset($_SESSION['kollektivId'])){  

    echo ' 
    <p class="p-class">Her er oversikt over handlelisten for ditt kollektiv. Legg til og fjern produkt når du har handlet inn.</p>
    <form action="includes/addHandleliste.inc.php" method="post">
    <input class="menu-input" type="text" name="produkt" placeholder="Skriv produktnavn...">
    <input class="menu-input2" type="text" name="antall" placeholder="Skriv antall...">
    <button id="btn" class="menu-leggtil" type="submit" name="produkt-submit">Legg til produkt</button>
    </form>'; 


    require './includes/dbh.inc.php';
    $sql = "SELECT produkt_navn, produkt_antall FROM produkt WHERE kollektiv_id =?"; 
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt,$sql)) {
        header("Location: ../ditt_kollektiv?error=sqlerrorhandleliste"); 
        exit(); 
    }
    mysqli_stmt_bind_param($stmt, "s", $_SESSION['kollektivId']);
    mysqli_stmt_execute($stmt); 
    $result = mysqli_stmt_get_result($stmt);

    $datas = array(); 
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $datas[] = $row; 
        }
            
    }

    // skriver ut produkt: 
    echo "<div class='divliste'> 
    <ol class='liste'> "; 
    
    foreach ($datas as $data) {
        echo "<li>".$data['produkt_navn'].": ".$data['produkt_antall']."</li>"; 
    }

    echo "
    </ol> 
    </div>";
    
    echo '<form action="includes/removeHandleliste.inc.php" method="post">
    <input class="menu-input3" type="text" name="produkt" placeholder="Skriv produktnavn...">
    <button id="btn" class="menu-fjern" type="submit" name="fjernprodukt-submit">Fjern produkt</button>
    </form>  ';

}

?>