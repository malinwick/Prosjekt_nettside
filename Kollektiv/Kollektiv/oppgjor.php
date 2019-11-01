<?php
require "header.php"; 
?>

    <div class="title-menu">
        <h1>Oppgjør</h1>
    </div>

    <?php


if (isset($_SESSION['kollektivId'])){  

    echo ' 
    <p class="p-class"> Skriv inn hvilke produkt du har kjøpt og hva det koster, og legg det til i oppgjøret for ditt kollektiv.</p>
    <form action="includes/addOppgjor.inc.php" method="post">
    <input class="menu-input" type="text" name="produkt" placeholder="Skriv produktnavn...">
    <input class="menu-input2" type="number" name="pris" placeholder="Pris i kroner...">
    <button id="btn" class="menu-leggtil" type="submit" name="oppgjor-submit">Legg til oppgjør</button>
    </form>'; 

    require './includes/dbh.inc.php';
    $sql = "SELECT * FROM oppgjor WHERE kollektiv_id =?"; 
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt,$sql)) {
        header("Location: ../ditt_kollektiv?error=sqlerroroppgjor"); 
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

        // finner navn til medlem:
        $sql = "SELECT bruker_brukernavn FROM bruker WHERE bruker_id =?"; 
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt,$sql)) {
            header("Location: ../ditt_kollektiv?error=sqlerroroppgjor"); 
            exit(); 
        }
        mysqli_stmt_bind_param($stmt, "s", $data['bruker_id']);
        mysqli_stmt_execute($stmt); 
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result); 
        $navn = $row['bruker_brukernavn']; 
        
        echo
        "<li>".$navn." har kjøpt ".$data['produkt']." for ".$data['pris']."kr</li>"; 

    }
    echo "
        </ol> 
        </div>";

    
    echo '<form action="includes/removeOppgjor.inc.php" method="post">
    <input class="menu-input3" type="text" name="produkt" placeholder="Skriv produktnavn...">
    <button id="btn" class="menu-fjern" type="submit" name="fjernoppgjor-submit">Fjern oppgjør</button>
    </form>  ';

}

?>
    
