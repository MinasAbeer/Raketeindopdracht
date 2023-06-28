<?php

$user = new account();

if (isset($_GET['view'])) { 

    // if(account::isUserLoggedIn() && ($_GET['view'] !== 'logout')) {
    //     $path = __DIR__ . DIRECTORY_SEPARATOR . 'account.php';
    //     if (!file_exists($path)) { 
    //         echo 'ERROR HET BESTAND IS NIET GEVONDEN VIEW INLOG';
    //     } else {
    //         return include($path);
    //     }
    // }
    

    if (!empty($_GET['view'])) { 
        $view = $_GET['view'];
        if ($view == 'login' && account::isUserLoggedIn()) {
            header('Location: ?module=account&view=account');
            exit;
        }
        $path = __DIR__ . DIRECTORY_SEPARATOR . $view . '.php';
        
        if (!file_exists($path)) { 
            echo 'ERROR HET BESTAND IS NIET GEVONDEN';
        } else { 
            require ($path);
        }

    } else { 
        echo 'error, bestand not found';
    }
}
else {
    header('loction: ?module=account&view=login');
}



?>