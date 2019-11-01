<?php

if (isset($_POST['vask-submit'])) {
    session_start(); 
    require 'dbh.inc.php';

    $name = $_POST['navn'];
    $date = $_POST['dato'];

    if (empty($name) || empty($date)){
        header("Location: ../vaskeliste.php?error=emptyfields"); 
        exit();
    }
    // Finne bruker id fra navnet
    else {
        $sql = "SELECT * FROM bruker WHERE bruker_brukernavn=?;"; 
        $stmt = mysqli_stmt_init($conn); 
        if (!mysqli_stmt_prepare($stmt,$sql)) {
            header("Location: ../vaskeliste.php?error=sqlerror"); 
            exit();
        }
        else {
            mysqli_stmt_bind_param($stmt, "s", $name);
            mysqli_stmt_execute($stmt); 
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) {
                $bruker_id = $row['bruker_id'];
                
                // finne ut om person er i samme kollektiv: 
                $sql = "SELECT * FROM medlem WHERE bruker_id=?;"; 
                $stmt = mysqli_stmt_init($conn); 
                if (!mysqli_stmt_prepare($stmt,$sql)) {
                    header("Location: ../vaskeliste.php?error=sqlerror"); 
                    exit();
                }
                else {
                    mysqli_stmt_bind_param($stmt, "s", $bruker_id);
                    mysqli_stmt_execute($stmt); 
                    $result = mysqli_stmt_get_result($stmt);
                
                    if ($row = mysqli_fetch_assoc($result)['kollektiv_id']==$_SESSION['kollektivId']) {
                        // Se om dato eksisterer: 
                        $sql = "SELECT * FROM vask WHERE vask_dato =?;"; 
                        $stmt = mysqli_stmt_init($conn); 
                        if (!mysqli_stmt_prepare($stmt,$sql)) {
                            header("Location: ../vaskeliste.php?error=sqlerror"); 
                            exit();
                        }
                        else {
                            mysqli_stmt_bind_param($stmt, "s", $date);
                            mysqli_stmt_execute($stmt); 
                            $result = mysqli_stmt_get_result($stmt); 
                            
                            if ($row = mysqli_fetch_assoc($result)) {
                                // Vask finnes
                                header("Location: ../vaskeliste.php?error=dateistaken"); 
                                exit();
                            }
                            else {
                                // Legg til vask:
                                $sql = "INSERT INTO vask (vask_dato, bruker_id, kollektiv_id) VALUES (?, ?, ?)";
                                $stmt = mysqli_stmt_init($conn);
                                if (!mysqli_stmt_prepare($stmt,$sql)) {
                                    header("Location: ../vaskeliste.php?error=sqlerror"); 
                                    exit();
                                }
                                else {
                                    mysqli_stmt_bind_param($stmt, "sss", $date, $bruker_id, $_SESSION['kollektivId']);
                                    mysqli_stmt_execute($stmt); 
                
                                    header("Location: ../vaskeliste.php?addVask=success");
                                    exit();
                                }
                                
                            }




                        }

                    }
                    else {
                        header("Location: ../vaskeliste.php?error=usernotinkollektiv"); 
                        exit();
                    }
                }

            }
            else {
                header("Location: ../vaskeliste.php?error=userdontexist"); 
                exit();
            }
        
        }

    }

}
else {
    header("Location: ../vaskeliste.php"); 
    exit(); 
}
