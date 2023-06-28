<?php
// http://127.0.0.1/Documents/leerjaar-3/php4/eindopdracht/index.php?module=account&view=account

if (!account::isUserLoggedIn()) {
    echo "U moet inloggen om deze pagina te kunnen betreden. Klik <a href='?module=account&view=login'>hier </a> om in te loggen.";
} else {
    var_dump(account::getUserData());
}

?>
