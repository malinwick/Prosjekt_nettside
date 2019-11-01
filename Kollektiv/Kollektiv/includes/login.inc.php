<?php

if (isset($_POST['login-submit'])) {
    
    require 'dbh.inc.php'; 

    $mailuid = $_POST['mailuid']; 
    $password = $_POST['pwd'];

    if (empty($mailuid) || empty($password)) {
        header("Location: ../index.php?error=emptyfields"); 
        exit();
    }
    else {
        $sql = "SELECT * FROM bruker WHERE bruker_brukernavn=? OR bruker_epost=?;"; 
        $stmt = mysqli_stmt_init($conn); 
        if (!mysqli_stmt_prepare($stmt,$sql)) {
            header("Location: ../index.php?error=sqlerror"); 
            exit();
        }
        else {
            mysqli_stmt_bind_param($stmt, "ss", $mailuid, $mailuid);
            mysqli_stmt_execute($stmt); 
            $result = mysqli_stmt_get_result($stmt); 
            if ($row = mysqli_fetch_assoc($result)) {
               $pwdCheck = password_verify($password, $row['bruker_passord']);
               if ($pwdCheck == false) {
                header("Location: ../index.php?error=wrongpwd"); 
                exit(); 
               }
               elseif ($pwdCheck == true) {
                    session_start(); 
                    $_SESSION[userId] = $row['bruker_id'];
                    $_SESSION[userUid] = $row['bruker_brukernavn']; 

                    // legg inn session variabler for kollektiv 
                    // kollektivId
                    $sql = "SELECT * FROM medlem WHERE bruker_id=?;"; 
                    $result = mysqli_query($conn, $sql);
                    if (!mysqli_stmt_prepare($stmt,$sql)) {
                        header("Location: ../index.php?error=sqlerror"); 
                        exit();
                    }
                    else {
                        mysqli_stmt_bind_param($stmt, "s", $_SESSION[userId]);
                        mysqli_stmt_execute($stmt); 
                        $result = mysqli_stmt_get_result($stmt);
                        $row = mysqli_fetch_assoc($result);
                        $_SESSION[kollektivId] = $row['kollektiv_id'];

                        // kollektivNavn

                        $sql = "SELECT * FROM kollektiv WHERE kollektiv_id=?;"; 
                        $result = mysqli_query($conn, $sql);
                        if (!mysqli_stmt_prepare($stmt,$sql)) {
                            header("Location: ../index.php?error=sqlerror"); 
                            exit();
                        }
                        else {
                            mysqli_stmt_bind_param($stmt, "s", $_SESSION[kollektivId]);
                            mysqli_stmt_execute($stmt); 
                            $result = mysqli_stmt_get_result($stmt);
                            $row = mysqli_fetch_assoc($result);
                            $_SESSION[kollektivNavn] = $row['kollektiv_navn'];

                            header("Location: ../index.php?login=success"); 
                            exit();
                        }
                    }
               }
               else {
                header("Location: ../index.php?error=wrongpwd"); 
                exit();
               }  
            }
            else {
                header("Location: ../index.php?error=nouser"); 
                exit();
            }
        }
    }

}
else {
    header("Location: ../index.php"); 
    exit();
}