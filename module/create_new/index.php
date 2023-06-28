<?php

require_once 'classes/account.cls.php';

$acc = new Account();

if (!$user->isUserLoggedIn()) {
    echo '<p>ERROR! U MOET EERST INLOGGEN OM IN DIT PROTAAL KUNNEN KOMEN. Klik <a href="?module=account&view=login">hier</a> om in te loggen.</p>';
    die;
}

?>

<p>Voeg hier het nieuwe pagina toe!</p>

<form action="?module=create_new" method="post" enctype="multipart/form-data">
    <lable for="titel">Titel: </lable>
        <br>
    <input type="text" name="titel" id="titel" class="modify">
        <br>
    <label for="img">Foto's: </label>
        <br>
    <input type="file" name="img" id="img" class="modify">
        <br>
    <label for="content">Tekst: </label>
        <br>
    <textarea name="content" id="content"></textarea>
        <br>
        <br>
    <input type="submit" name="createNew" value="Toevoegen">
</form>

