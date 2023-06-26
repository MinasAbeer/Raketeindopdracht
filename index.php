<?php

session_start();
require_once 'config.php';
require_once 'functions.php';
require_once 'classes/account.cls.php';

$backend = false;
$user = new Account();

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
                    <?php 
                    global $pdo;

                    $sql = "SELECT pagina FROM module";
                    $module_query = $pdo->query($sql);
                    $modules = $module_query->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($modules as $module => $navpagina) {
                        $nav = ucfirst($navpagina["pagina"]);
                        echo "<a href='?module=$nav'>$nav</a>";
                    }
                    if ($user->isUserLoggedIn()) {
                        echo '<a href="?module=create_new">Create new</a>';
                        echo '<a href="?module=edit">Edit</a>';
                        echo '<a href="?module=account&view=logout">Logout</a>';
                    } else {
                        echo '<a href="?module=account&view=login">Login</a>';
                    } 
                    
                    
                    

                    ?>
                </nav>
            </div>
        </header>

        <div class="content">
            <?php
            
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
                <p><span>&#169</span> Minas Abeer 2023</p>
            </div>
        </footer>
    </div> 
</body>
</html>