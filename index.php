<?php

session_start();
require_once 'config.php';
require_once 'functions.php';
require_once 'account.cls.php';

$backend = false;

if(account::isUserLoggedIn() && isset($_GET['module']))
{
    $backend = true;
    $backend_path = __DIR__ . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . $_GET['module'] . DIRECTORY_SEPARATOR . 'index.php';

    if (!file_exists($backend_path)) { 
        echo 'ERROR DE ADMIN BESTAND IS NIET GEVONDEN!';
    }
}

if (isset($_GET['module'])) { 
    if (!empty($_GET['module'])) { 
        $path = __DIR__ . DIRECTORY_SEPARATOR . 'module' . DIRECTORY_SEPARATOR . $_GET['module'] . DIRECTORY_SEPARATOR . 'index.php';
        
        if (!file_exists($path)) { 
            echo 'ERROR DE MODULE BESTAND IS NIET GEVONDEN!';
        }
    } else {
        echo "module niet gevonden";
    }
} 


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rode Raketten</title>
    <link href="style/style.css" rel="stylesheet">
</head>
<body>
    <div class="page-container">
        <header>
            <div class="img">
                <a href="./">
                    <img src="img/logo.webp" width="125" height="125">
                </a>
            </div>
            <div class="navbar">
                <nav>
                    <a href="./?module=home">Home</a>
                    <a href="?module=teams">Teams</a>
                    <a href="?module=contact">Contact</a>
                    <a href="?module=account&view=login">Login</a>
                </nav>
            </div>
        </header>

        <div class="content">
            <?php

            if ($backend) {
                echo "<div class='uitlog'>
                        <a href='?module=account&view=logout'><button type='button'>Loguit</button></a>
                    </div>";
            }
            
            if (isset($path)) {
                require $path;
            } else { 
                $path = __DIR__ . DIRECTORY_SEPARATOR . 'module' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'index.php';
                require $path;
            }

            ?>
        </div>

        <footer>
            <div class="footer">
                <p><span>&#169</span> Minas Abeer 2022</p>
            </div>
        </footer>
    </div> 
</body>
</html>