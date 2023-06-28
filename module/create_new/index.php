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

<?php

if (isset($POST['createNew']) && !empty($_POST['titel']) || !empty($_FILES['img']) || !empty($_POST['content'])) {
    global $pdo;
    $pageTitle = $_POST['titel'];
    $pageContent = $_POST['content'];
    $img = $_FILES['img']['name'];
    
    $stmt = $pdo->prepare("INSERT INTO module (pagina) VALUES ('$pageTitle');");
    $stmt->execute();
    $moduleId = $pdo->lastInsertId();
    $stmt = null;
    
    $stmt = $pdo->prepare("INSERT INTO content (moduleID, title, page_content, img) VALUES ('$moduleId', '$pageTitle', '$pageContent', '$img');");
    $stmt->execute();
    $stmt = null;
    
    print_r("Het werkt");
}

?>