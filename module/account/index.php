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
        $path = __DIR__ . DIRECTORY_SEPARATOR . $_GET['view'] . '.php';
        
        if (!file_exists($path)) { 
            echo 'ERROR HET BESTAND IS NIET GEVONDEN';
        } else { 
            require($path);
        }

    } else { 
        echo 'error, bestand not found';
    }
}
else {
    header('loction: ?module=account&view=login');
}



?>