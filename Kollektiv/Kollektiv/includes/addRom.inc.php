<?php

if (isset($_POST['rom-submit'])) {
    session_start(); 
    require 'dbh.inc.php';

    $rom = $_POST['rom'];
    $start = $_POST['start'];
    $slutt = $_POST['slutt'];

    if (empty($rom) || empty($start) || empty($slutt)){
        header("Location: ../rombooking.php?error=emptyfields"); 
        exit();
    }
    else {
        $sql = "SELECT * FROM rombooking WHERE tidspunkt_start=? AND kollektiv_id =? AND rom =?;"; 
        $stmt = mysqli_stmt_init($conn); 
        if (!mysqli_stmt_prepare($stmt,$sql)) {
            header("Location: ../rombooking.php?error=sqlerror"); 
            exit();
        }
        else {
            mysqli_stmt_bind_param($stmt, "sss", $start, $_SESSION['kollektivId'], $rom);
            mysqli_stmt_execute($stmt); 
            $result = mysqli_stmt_get_result($stmt);
            // Hvis rombooking finnes:
            if ($row = mysqli_fetch_assoc($result)) {
                header("Location: ../rombooking.php?error=existingrombooking");
                exit(); 
            } // Hvis ikke, legg til rombooking:
            else {
                $sql = "INSERT INTO rombooking (tidspunkt_start, tidspunkt_slutt, rom, bruker_id, kollektiv_id) VALUES (?, ?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt,$sql)) {
                    header("Location: ../rombooking.php?error=sqlerror"); 
                    exit();
                }
                else {
                    mysqli_stmt_bind_param($stmt, "sssss", $start, $slutt, $rom, $_SESSION['userId'], $_SESSION['kollektivId']);
                    mysqli_stmt_execute($stmt); 

                    header("Location: ../rombooking.php?addRombooking=success");
                    exit();
                }
            } 
        
        
        }
        
    }






}
else {
    header("Location: ../rombooking.php"); 
    exit(); 
}