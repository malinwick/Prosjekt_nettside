<?php

if (isset($_POST['kollektiv-submit'])) {
    require 'dbh.inc.php'; 

    $kollNavn = $_POST['Kollektiv_navn']; 

    if (empty($kollNavn)){
        header("Location: ../ditt_kollektiv.php?error=emptyfields"); 
        exit();
    }
    elseif (!preg_match("/^[a-zA-Z0-9]*$/", $kollNavn)) {
        header("Location: ../ditt_kollektiv.php?error=invalidname");  
        exit(); 
    }
    else {
        $sql = "SELECT kollektiv_navn FROM kollektiv WHERE kollektiv_navn=?";
        $stmt = mysqli_stmt_init($conn); 
        if (!mysqli_stmt_prepare($stmt,$sql)) {
            header("Location: ../ditt_kollektiv?error=sqlerror"); 
            exit(); 
        }
        else {
            mysqli_stmt_bind_param($stmt, "s", $kollNavn);
            mysqli_stmt_execute($stmt);  
            mysqli_stmt_store_result($stmt); 
            $resultCheck = mysqli_stmt_num_rows($stmt);
            if ($resultCheck > 0) {
                header("Location: ../ditt_kollektiv.php?error=usertaken"); 
                exit();
            }
            else {
                $sql = "INSERT INTO kollektiv (kollektiv_navn) VALUES (?)";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt,$sql)) {
                    header("Location: ../ditt_kollektiv.php?error=sqlerror"); 
                    exit();
                }
                else {
                    mysqli_stmt_bind_param($stmt, "s", $kollNavn);
                    mysqli_stmt_execute($stmt); 
                      
                    
                    // Legger til bruker i nytt kollektiv: 
                    $sql = "SELECT * FROM kollektiv WHERE kollektiv_navn=?;"; 
                    $result = mysqli_query($conn, $sql);
                    if (!mysqli_stmt_prepare($stmt,$sql)) {
                        header("Location: ../ditt_kollektiv.php?error=sqlerror"); 
                        exit();
                    }
                    else {
                        mysqli_stmt_bind_param($stmt, "s", $kollNavn);
                        mysqli_stmt_execute($stmt); 
                        $result = mysqli_stmt_get_result($stmt);
                        $row = mysqli_fetch_assoc($result);
                        $kollId = $row['kollektiv_id']; 

                        $sql = "INSERT INTO medlem (bruker_id, kollektiv_id) VALUES (?, ?)";
                        $stmt = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($stmt,$sql)) {
                            header("Location: ../ditt_kollektiv.php?error=sqlerror"); 
                            exit();
                        }
                        else {
                            session_start();
                            mysqli_stmt_bind_param($stmt, "ss", $_SESSION['userId'], $kollId);
                            mysqli_stmt_execute($stmt); 

                            $_SESSION[kollektivId] = $row['kollektiv_id'];
                            $_SESSION[kollektivNavn] = $row['kollektiv_navn'];
                            header("Location: ../ditt_kollektiv.php?makeKoll=success");
                            exit();
                        }

                        
                    }

                    // header("Location: ../ditt_kollektiv.php?makeKoll=success");
                    // exit(); 
                }
            }


        } 
    }

    mysqli_stmt_close($stmt); 
    mysqli_close($conn);
}
else {
    header("Location: ../ditt_kollektiv.php"); 
    exit(); 
}


