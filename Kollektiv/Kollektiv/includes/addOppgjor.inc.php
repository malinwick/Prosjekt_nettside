<?php

if (isset($_POST['oppgjor-submit'])) {
    session_start(); 
    require 'dbh.inc.php';

    $produkt = $_POST['produkt'];
    $pris = $_POST['pris'];
    if (empty($produkt) || empty($pris)){
        header("Location: ../oppgjor.php?error=emptyfields"); 
        exit();
    }
    else {
        $sql = "SELECT * FROM oppgjor WHERE produkt=? AND bruker_id =?;"; 
        $stmt = mysqli_stmt_init($conn); 
        if (!mysqli_stmt_prepare($stmt,$sql)) {
            header("Location: ../oppgjor.php?error=sqlerror"); 
            exit();
        }
        else {
            mysqli_stmt_bind_param($stmt, "ss", $produkt, $_SESSION['userId']);
            mysqli_stmt_execute($stmt); 
            $result = mysqli_stmt_get_result($stmt);
            // Hvis oppgjør finnes:
            if ($row = mysqli_fetch_assoc($result)) {
                header("Location: ../oppgjor.php?error=existingoppgjor");
                exit(); 
            } // Hvis ikke, legg til oppgjør: 
            else {
                $sql = "INSERT INTO oppgjor (produkt, pris, bruker_id, kollektiv_id) VALUES (?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt,$sql)) {
                    header("Location: ../oppgjor.php?error=sqlerror"); 
                    exit();
                }
                else {
                    mysqli_stmt_bind_param($stmt, "ssss", $produkt, $pris, $_SESSION['userId'], $_SESSION['kollektivId']);
                    mysqli_stmt_execute($stmt); 

                    header("Location: ../oppgjor.php?addOppgjor=success");
                    exit();
                }
            }    
            
        

        
        
        }
    }




}