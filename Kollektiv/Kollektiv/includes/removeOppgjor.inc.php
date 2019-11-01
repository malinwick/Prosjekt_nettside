<?php

// Fjern produkt fra oppgjor

if (isset($_POST['fjernoppgjor-submit'])) { 

    $produkt = $_POST['produkt'];
    
    require 'dbh.inc.php';
    session_start();
    $sql = "DELETE FROM oppgjor WHERE produkt =? AND bruker_id =? AND kollektiv_id =?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt,$sql)) {
        header("Location: ../oppgjor.php?error=sqlerror"); 
        exit();
    }
    else {
        mysqli_stmt_bind_param($stmt, "sss", $produkt, $_SESSION['userId'], $_SESSION['kollektivId']);
        mysqli_stmt_execute($stmt); 

        header("Location: ../oppgjor.php?fjernprodukt=success");
        
        exit();
    }


}
else {
    header("Location: ../oppgjor.php"); 
    exit(); 
}