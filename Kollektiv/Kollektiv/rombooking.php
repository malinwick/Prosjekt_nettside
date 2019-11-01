<?php
require "header.php"; 
?>


    <div class="title-menu">
        <h1>Rombooking</h1>
    </div>

<?php

if (isset($_SESSION['kollektivId'])){  

    echo ' 
    <p class="p-class">Skriv inn rommet du vil booke og tast deretter inn start- og sluttidspunkt. Trykk så på "book rom"-knappen.</p>
    <form action="includes/addRom.inc.php" method="post">
    <input class="menu-input5" type="text" name="rom" placeholder="Rom du vil booke...">
    <input class="menu-input6" type="datetime-local" name="start" placeholder="Start tidspunkt...">
    <input class="menu-input7" type="datetime-local" name="slutt" placeholder="Slutt tidspunkt...">
    <button id="btn" class="menu-leggtil3" type="submit" name="rom-submit">Book rom</button>
    </form>'; 


    require './includes/dbh.inc.php';
    $sql = "SELECT * FROM rombooking WHERE kollektiv_id =? AND tidspunkt_slutt > DATE_SUB(NOW(), INTERVAL 15 MINUTE)"; 
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt,$sql)) {
        header("Location: ../ditt_kollektiv?error=sqlerrorrombooking"); 
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

    // skriver ut rombooking:
    echo "<div class='divliste'> 
    <ol class='liste'> ";  
    foreach ($datas as $data) {

        // finner navn til medlem:
        $sql = "SELECT bruker_brukernavn FROM bruker WHERE bruker_id =?"; 
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt,$sql)) {
            header("Location: ../ditt_kollektiv?error=sqlerrorrombooking"); 
            exit(); 
        }
        mysqli_stmt_bind_param($stmt, "s", $data['bruker_id']);
        mysqli_stmt_execute($stmt); 
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result); 
        $navn = $row['bruker_brukernavn']; 

       

        echo "<li>".$navn.": ".$data['rom']." - tidspunkt:".$data['tidspunkt_start']."-".$data['tidspunkt_slutt']."</li>";
        
    }
    echo "
    </ol> 
    </div>";

    
    echo ' <form action="includes/removeRom.inc.php" method="post">
    <input class="menu-input8" type="text" name="rom" placeholder="Rom du vil fjerne...">
    <input class="menu-input9" type="datetime-local" name="start" placeholder="Start tidspunkt...">
    <button id="btn" class="menu-fjern2" type="submit" name="removerom-submit">Fjern rom booking</button>
    </form>';

    

    // echo $dt->format('m/d/Y, H:i:s');


}

?>