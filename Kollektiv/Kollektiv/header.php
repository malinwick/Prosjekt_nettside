<?php
session_start(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <link href="./css/style-ditt_kollektiv.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    <link href="./css/style-index.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    <link href="./css/login_signup.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    <link href="./css/style-header.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    <link href="./css/style-menu.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />

    <title>Kollektivet</title>
</head>
<body>
    <header>
        <div class="loggut">
            <?php
                if (isset($_SESSION['userId'])) {
                            echo '<form action="includes/logout.inc.php" method="post">
                            <button class="loggut-knapp" type="submit" name="logout-submit">Logg ut</button>
                            </form> '; 
                        }
            ?>
        </div>
        
        <nav class ="nav-header-main">
            <a class="header-logo" href="index.php"><img id="logo-pic" src="" alt="logo her">
            </a>
            <ul class="homepage-class">
                <li class="active"><a href="index.php">Hjem</a></li>
                <li><a href="ditt_kollektiv.php">Ditt kollektiv</a></li>
                <li><a href="tips.php">Tips</a></li>
                <li><a href="kontakt_oss.php">Kontakt oss</a></li>
            </ul>


        </nav>
    </header>

<hr>