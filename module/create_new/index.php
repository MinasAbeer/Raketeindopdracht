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
    <input type="text" name="titel" id="titel" class="modify" required>
        <br>
    <label for="img">Foto's: </label>
        <br>
    <input type="file" name="img" id="img" class="modify" required>
        <br>
    <label for="content">Tekst: </label>
        <br>
    <textarea name="content" id="content"></textarea>
        <br>
        <br>
    <input type="submit" name="createNew" value="Toevoegen">
</form>

<?php

if (isset($POST['createNew']) && !empty($_POST['titel']) && !empty($_FILES['img']) && !empty($_POST['content'])) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    global $pdo;
    $pageTitle = $_POST['titel'];
    $pageContent = '<p>' . $_POST['content'] . '</p>';
    $imgPath = "./module/$pageTitle";
    $stmt = $pdo->prepare("INSERT INTO module (pagina) VALUES ('$pageTitle');");
    $stmt->execute();
    $moduleId = $pdo->lastInsertId();
    $stmt = null;
    
    $stmt = $pdo->prepare("INSERT INTO content (moduleID, title, page_content, img) VALUES ('$moduleId', '$pageTitle', '$pageContent', '$imgPath');");
    $stmt->execute();
    $stmt = null;

    ob_start();
    getContent($pageTitle);
    $fileContent = ob_get_clean();
    
    $fileImg = "<img src='./module/$pageTitle/" . $_FILES['img']['name'] . "' width='250' height='250'>";
    $contentArr = array(
        "content" => $fileContent,
        "img" => $fileImg
    );
    // var_dump($contentArr);

    if (!is_dir($imgPath)) {
        mkdir($imgPath, 0777, true);
    }

    file_put_contents("./module/$pageTitle/index.php", $pageContent . $fileImg, FILE_APPEND);

    $targetDir = "./module/$pageTitle/";
    $targetFile = $targetDir . basename($_FILES["img"]['name']);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    if (isset($_POST['createNew'])) {
        $check = getimagesize($_FILES['img']['tmp_name']);
        if ($check !== false) {
            $upload = 1;
        } else {
            echo "Het bestand is geen afbeelding";
            $upload = 0;
        }
    }

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "webp") {
        echo "Sorry alleen JPG, JPEG, PNG bestanden zijn toegestaan.";
        $upload = 0;
    }

    if ($upload = 1) {
        if (move_uploaded_file($_FILES['img']['tmp_name'], $targetFile)) {
            $sql = "UPDATE logo SET logoPath = '$targetFile';";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            echo "<hr> <p>Het bestand " . htmlspecialchars(basename($_FILES['img']['name'])) . " is geüpload.</p>";
        } else {
            echo "<p>Er is iets fout gegaan met het uploaden van het bestand.</p>";
        }
    } else {
        echo "<p>Sorry het bestand kan niet geüpload worden.</p>";
    }
    
}

?>