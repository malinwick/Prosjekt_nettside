<?php

// Fjern produkt fra handleliste

if (isset($_POST['fjernprodukt-submit'])) { 

    $produkt = $_POST['produkt'];
    
    require 'dbh.inc.php';
    session_start();
    $sql = "DELETE FROM produkt WHERE produkt_navn =? AND kollektiv_id =?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt,$sql)) {
        header("Location: ../handleliste.php?error=sqlerror"); 
        exit();
    }
    else {
        mysqli_stmt_bind_param($stmt, "ss", $produkt, $_SESSION['kollektivId']);
        mysqli_stmt_execute($stmt); 

        header("Location: ../handleliste.php?fjernprodukt=success");
        
        exit();
    }


}
else {
    header("Location: ../handleliste.php"); 
    exit(); 
}