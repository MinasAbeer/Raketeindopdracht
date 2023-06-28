<?php

if (!isset($_GET['module'])) {
    $_GET['module'] = 'home';
}

getContent($_GET['module'])

?>