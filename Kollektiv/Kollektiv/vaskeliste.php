<?php
require "header.php"; 

?>


    <div class="title-menu">
        <h1>Vaskeliste</h1>
    </div>


<?php

if (isset($_SESSION['kollektivId'])){  

    echo ' 
    <p class="p-class">Skriv inn brukernavnet ditt eller brukernavnet til noen i kollektivet, og velg hvilke dato som er deres vaskedag.</p>
    <form action="includes/addVask.inc.php" method="post">
    <input class="menu-input" type="text" name="navn" placeholder="Skriv inn brukernavn...">
    <input class="menu-input2" type="date" name="dato" placeholder="dato: YYYY-MM-DD">
    <button id="btn" class="menu-leggtil" type="submit" name="vask-submit">Legg til vask</button>
    </form>'; 


    require './includes/dbh.inc.php';
    $sql = "SELECT * FROM vask WHERE kollektiv_id =? AND vask_dato > DATE_SUB(NOW(), INTERVAL 15 MINUTE)"; 
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt,$sql)) {
        header("Location: ../ditt_kollektiv?error=sqlerrorvask"); 
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
            header("Location: ../ditt_kollektiv?error=sqlerrorvask"); 
            exit(); 
        }
        mysqli_stmt_bind_param($stmt, "s", $data['bruker_id']);
        mysqli_stmt_execute($stmt); 
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result); 
        $navn = $row['bruker_brukernavn']; 
        
        echo "<li>".$navn." :".$data['vask_dato']."</li>"; 
        
    }
    echo "
    </ol> 
    </div>";

    
    echo '<form action="includes/removeVask.inc.php" method="post">
    <input class="menu-input3" type="date" name="dato" placeholder="dato: YYYY-MM-DD">
    <button id="btn" class="menu-fjern" type="submit" name="fjernvask-submit">Fjern vask</button>
    </form>  ';

}

?>