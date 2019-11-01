<?php
require "header.php";
?>

<body>
    <div class="title-menu">
        <h1>Medlemmer</h1>
    </div>
</body>


<?php


if (isset($_SESSION['kollektivId'])){ 
    

    require './includes/dbh.inc.php';
    $sql = "SELECT bruker_id FROM medlem WHERE kollektiv_id =?"; 
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt,$sql)) {
        header("Location: ../ditt_kollektiv?error=sqlerrormedlemmer"); 
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

    // skriver ut navn til medlemmer:
    echo "<div class='divliste'> 
        <h2>Medlemmer i ".$_SESSION['kollektivNavn']." </h2> 
        <ol class='liste'> ";  
    foreach ($datas as $data) {
         

        // finner navn til medlem:
        $sql = "SELECT bruker_brukernavn FROM bruker WHERE bruker_id =?"; 
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt,$sql)) {
            header("Location: ../ditt_kollektiv?error=sqlerrormedlemmer"); 
            exit(); 
        }
        mysqli_stmt_bind_param($stmt, "s", $data['bruker_id']);
        mysqli_stmt_execute($stmt); 
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result); 
        $navn = $row['bruker_brukernavn']; 
        echo "<li>".$navn."</li>"; 

    }
    echo "
        </ol> 
        </div>";


    // Legge til medlemmer: 

    echo '  <div>
            <p class="p-class">Legg til nye medlemmer. Skriv inn brukernavn eller e-post og trykk på "legg til medlem"-knappen.</p>
            <form action="includes/addMedlem.inc.php" method="post">
            <input id="input-felt" class="menu-input4" type="text" name="mailuid" placeholder="Skriv inn brukernavn...">
            <button id="btn" class="menu-leggtil2" type="submit" name="addMedlem-submit">Legg til medlem</button>
            </form>
            </div>'; 




    // feilmeldinger: 

    if (isset($_GET['error'])) {
        if ($_GET['error'] == "emptyfields") {
            echo '<p class="signuperror">Fyll inn alle felt!</p>'; 
        }
        elseif ($_GET['error'] == "userismember") {
            echo '<p class="signuperror">Bruker er allerede medlem i et kollektiv!</p>';
        }
        elseif ($_GET['error'] == "userdoesnotexist") {
            echo '<p class="signuperror">Bruker eksisterer ikke!</p>';
        }
    }
    elseif (isset($_GET['addMember'])) {
        if ($_GET['addMember'] == "success") {
            echo '<p class="signupsuccess">Bruker ble lagt til i kollektiv!</p>';
        }
    }

}   
?>