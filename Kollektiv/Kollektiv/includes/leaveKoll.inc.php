<?php

// Forlate kollektiv

if (isset($_POST['leaveKoll-submit'])) { 
    
    require 'dbh.inc.php';
    session_start();
    $sql = "DELETE FROM medlem WHERE bruker_id =?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt,$sql)) {
        header("Location: ../ditt_kollektiv.php?error=sqlerror"); 
        exit();
    }
    else {
        mysqli_stmt_bind_param($stmt, "s", $_SESSION['userId']);
        mysqli_stmt_execute($stmt); 

        unset($_SESSION['kollektivId']);
        unset($_SESSION['kollektivNavn']);
        header("Location: ../ditt_kollektiv.php?LeaveKoll=success");
        
        exit();
    }


}
else {
    header("Location: ../ditt_kollektiv.php"); 
    exit(); 
}