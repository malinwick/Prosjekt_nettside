<?php

if (isset($_POST['addMedlem-submit'])) {
    session_start(); 
    require 'dbh.inc.php';

    $mailuid = $_POST['mailuid'];

    if (empty($mailuid)){
        header("Location: ../medlemmer.php?error=emptyfields"); 
        exit();
    }
    else {
        $sql = "SELECT * FROM bruker WHERE bruker_brukernavn=? OR bruker_epost=?;"; 
        $stmt = mysqli_stmt_init($conn); 
        if (!mysqli_stmt_prepare($stmt,$sql)) {
            header("Location: ../medlemmer.php?error=sqlerror"); 
            exit();
        }
        else {
            mysqli_stmt_bind_param($stmt, "ss", $mailuid, $mailuid);
            mysqli_stmt_execute($stmt); 
            $result = mysqli_stmt_get_result($stmt);
            // Hvis personen finnes:  
            if ($row = mysqli_fetch_assoc($result)) {
                $user_id = $row['bruker_id']; 
                
                // finne ut om personen er medlem i et annet kollektiv: 

                $sql = "SELECT * FROM medlem WHERE bruker_id=?;"; 
                $stmt = mysqli_stmt_init($conn); 
                if (!mysqli_stmt_prepare($stmt,$sql)) {
                    header("Location: ../medlemmer.php?error=sqlerror"); 
                    exit();
                }
                else {
                    mysqli_stmt_bind_param($stmt, "s", $user_id);
                    mysqli_stmt_execute($stmt); 
                    $result = mysqli_stmt_get_result($stmt);

                    if ($row = mysqli_fetch_assoc($result)) {
                        header("Location: ../medlemmer.php?error=userismember"); 
                        exit();    
                    }
                    else {
                        // Legge til medlem: 
                        $sql = "INSERT INTO medlem (bruker_id, kollektiv_id) VALUES (?, ?)";
                        $stmt = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($stmt,$sql)) {
                            header("Location: ../medlemmer.php?error=sqlerror"); 
                            exit();
                        }
                        else {
                            session_start();
                            mysqli_stmt_bind_param($stmt, "ss", $user_id, $_SESSION['kollektivId']);
                            mysqli_stmt_execute($stmt); 

                            header("Location: ../medlemmer.php?addMember=success");
                            exit();
                        }


                    }
                }




            }
            else{
                header("Location: ../medlemmer.php?error=userdoesnotexist"); 
                exit(); 
            }
        }
    }







}

else {
    header("Location: ../medlemmer.php"); 
    exit(); 
}