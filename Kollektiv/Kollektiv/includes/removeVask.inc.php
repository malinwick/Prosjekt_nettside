<?php

// Fjern produkt fra vaskeliste

if (isset($_POST['fjernvask-submit'])) { 

    $dato = $_POST['dato'];
    
    require 'dbh.inc.php';
    session_start();
    $sql = "DELETE FROM vask WHERE vask_dato =? AND kollektiv_id =?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt,$sql)) {
        header("Location: ../vaskeliste.php?error=sqlerror"); 
        exit();
    }
    else {
        mysqli_stmt_bind_param($stmt, "ss", $dato, $_SESSION['kollektivId']);
        mysqli_stmt_execute($stmt); 

        header("Location: ../vaskeliste.php?fjernvask=success");
        
        exit();
    }


}
else {
    header("Location: ../vaskeliste.php"); 
    exit(); 
}