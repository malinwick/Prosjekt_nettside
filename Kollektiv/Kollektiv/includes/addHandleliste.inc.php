<?php

if (isset($_POST['produkt-submit'])) {
    session_start(); 
    require 'dbh.inc.php';

    $produkt = $_POST['produkt'];
    $antall = $_POST['antall'];
    // må fikse for negative tall ?? 
    // feilmelding hvis antall ikke er int 

    if (empty($produkt) || empty($antall)){
        header("Location: ../handleliste.php?error=emptyfields"); 
        exit();
    }
    else {
        $sql = "SELECT * FROM produkt WHERE produkt_navn=?;"; 
        $stmt = mysqli_stmt_init($conn); 
        if (!mysqli_stmt_prepare($stmt,$sql)) {
            header("Location: ../handleliste.php?error=sqlerror"); 
            exit();
        }
        else {
            mysqli_stmt_bind_param($stmt, "s", $produkt);
            mysqli_stmt_execute($stmt); 
            $result = mysqli_stmt_get_result($stmt);

            // Hvis produkt finnes: Legg til antall
            if ($row = mysqli_fetch_assoc($result)) {
                $produkt_antall = $row['produkt_antall']; // antall i database
                 
                $nytt_antall = $produkt_antall + $antall; 
                
                $sql = "UPDATE produkt SET produkt_antall = ? WHERE produkt_navn =?;"; 
                $stmt = mysqli_stmt_init($conn); 
                if (!mysqli_stmt_prepare($stmt,$sql)) {
                    header("Location: ../handleliste.php?error=sqlerror"); 
                    exit();
                }
                else {
                    mysqli_stmt_bind_param($stmt, "ss", $nytt_antall, $produkt);
                    mysqli_stmt_execute($stmt); 
                    
                    header("Location: ../handleliste.php?addProdukt=success");
                    exit();
                }
            } // finnes ikke: 
            else {
                $sql = "INSERT INTO produkt (produkt_navn, produkt_antall, bruker_id, kollektiv_id) VALUES (?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt,$sql)) {
                    header("Location: ../handleliste.php?error=sqlerror"); 
                    exit();
                }
                else {
                    mysqli_stmt_bind_param($stmt, "ssss", $produkt, $antall, $_SESSION['userId'], $_SESSION['kollektivId']);
                    mysqli_stmt_execute($stmt); 

                    header("Location: ../handleliste.php?addProdukt=success");
                    exit();
                }

            }



        }


    }







}
else {
    header("Location: ../handleliste.php"); 
    exit(); 
}
