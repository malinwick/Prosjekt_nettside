<?php

// Fjern produkt fra rombooking

if (isset($_POST['removerom-submit'])) { 

    $rom = $_POST['rom'];
    $start = $_POST['start']; 
    
    require 'dbh.inc.php';
    session_start();
    $sql = "DELETE FROM rombooking WHERE rom =? AND tidspunkt_start =? AND bruker_id =? AND kollektiv_id =?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt,$sql)) {
        header("Location: ../rombooking.php?error=sqlerror"); 
        exit();
    }
    else {
        mysqli_stmt_bind_param($stmt, "ssss", $rom, $start, $_SESSION['userId'], $_SESSION['kollektivId']);
        mysqli_stmt_execute($stmt); 

        header("Location: ../rombooking.php?removerom=success");
        
        exit();
    }


}
else {
    header("Location: ../rombooking.php"); 
    exit(); 
}