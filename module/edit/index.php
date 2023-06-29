<?php

require_once 'classes/account.cls.php';


$user = new Account();
if (!$user->isUserLoggedIn()) {
    echo '<p>ERROR! U MOET EERST INLOGGEN OM IN DIT PROTAAL KUNNEN KOMEN. Klik <a href="?module=account&view=login">hier</a> om in te loggen.</p>';
    die;
}

?>


<form action="?module=edit" method="post">
    <p>Wat wil je wijzigen?</p>

    <input type="radio" name="nav" id="nav" value="navigatie">
    <label for="nav">Navigatie</label>  
        <br>
    <input type="radio" name="logo" id="logo" value="logo">
    <label for="logo">Logo</label>
        <br>
    <select name="page" id="content">
        <option value="geen pagina">Geen pagina</option>
        <?php
        
        global $pdo;
        $modules = $pdo->query("SELECT pagina FROM module");
        $fetch = $modules->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($fetch as $module => $pagina) {
            $pagina = ucfirst($pagina['pagina']);
            echo "<option value='$pagina'>$pagina</option>";
        }
        ?>
    </select>
    <label for="content">Content van een pagina</label>
        <br>
        <br>
    <input type="submit" name="wijzigen" value="Volgende stap">
</form>
   
<?php

if (isset($_POST['wijzigen']) && isset($_POST['nav']) || isset($_POST['logo']) || isset($_POST['page'])) {
    echo "<hr>";
    echo "<h2>Hier kunt u de data wijzigen.</h2>";
    if ($_POST['page'] == 'geen pagina') {
        $_POST['page'] = NULL;
    }
    if (isset($_POST['nav'])) {
        echo "<form action='?module=edit' method='post'>
                <label for='Welke'>Welke navigatie wilt u wijzigen?</label>
                <select id='Welke' name='pagina'>";
                foreach ($fetch as $module => $pagina) {
                    $pagina = $pagina['pagina'];
                    echo "<option name='pagina' value='$pagina'>$pagina</option>";
                }
                echo "</select>
                    <br>
                <label for='in_wat'>In wat wilt u het wijzigen?</label>
                <input type='text' name='new_nav_name' id='in_wat' class='modify'>
                    <br>
                <input type='checkbox' name='delete_nav' id='delete_nav'>
                <label for='delete_nav'>Verwijderen</label>
                    <br>
                    <br>
                <input type='submit' name='edit-nav' value='Wijzigen'> 
             </form>";
    } elseif (isset($_POST['logo'])) {
        echo "<form action='?module=edit' method='post' enctype='multipart/form-data'>
                <label for='change_logo'>Selecteer het nieuwe logo.</label>
                    <br>
                <input type='file' id='change_logo' name='change_logo'>
                    <br>
                    <br>
                <input type='submit' name='edit_logo' value='Wijzigen'>
            </form>";
    } elseif(isset($_POST['page'])) {
        $editpage = $_POST['page'];
        echo "<p>U heeft er voor gekozen om de pagina '$editpage' te wijzigen.</p>";
        if ($editpage == 'Teams') {
            echo "
                <form action='?module=edit' method='post' enctype='multipart/form-data'>
                    <label for='team_name'>Welke team wilt u bewerken?</label>
                        <br>
                    <select id='team_name' name='team'>";
                        $teamName = $pdo->query("SELECT teamName FROM teams");
                        $teams = $teamName->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($teams as $index => $team) {
                            $team = $team['teamName'];
                            echo "<option name='$team' value='$team'>$team</option>";
                        }
            echo    "</select>
                        <br>
                        <br>
                    <label for='new_team_name'>Team Naam</label>
                        <br>
                    <input type='text' name='new_team_name' id='new_team_name' class='modify'>
                        <br>
                    <label for='captain'>Aanvoeder</label>
                        <br>
                    <input type='text' name='captain' id='captain' class='modify'>
                        <br>
                    <label for='team_info'>Team infromatie</label>
                        <br>
                    <textarea id='team_info' name='team_info'></textarea>
                        <br>
                    <label for='team_img'>Team foto</label>
                        <br>
                    <input type='file' name='team_img' id='team_img'>
                        <br>
                        <br>
                    <input type='submit' name='edit_team' value='Wijzigen'>
                </form>";
        } else {
            $page = $_POST['page'];
            echo "<form action='?module=edit' method='post' enctype='multipart/form-data'>
                    <input type='hidden' name=page value='$page'>
                    <label for='dataToEdit'>Wijzig tekst</label>
                    <textarea id='dataToEdit' name='dataToEdit'></textarea>
                        <br>
                    <lable for='change_img'>Wijzig de afbeeldingen</lable>
                        <br>
                    <input type='file' id='change_img' name='change_img'>
                        <br>
                        <br>
                    <input type='submit' name='edit_page' value='Wijzigen'>
                </form>";
        }
    }
}

if (isset($_POST['edit-nav']) && !empty($_POST['new_nav_name']) || !empty($_POST['delete_nav'])) {
    // HERE COMES THE NAVBAR EDIT FUNCTIONALITY
    if (!empty($_POST['new_nav_name'])) {
        try {
            $sql = "UPDATE module SET pagina = '$_POST[new_nav_name]' WHERE pagina = '$_POST[pagina]';";

            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            rename("./module/$_POST[pagina]", "./module/$_POST[new_nav_name]");

            echo "<hr> <p>'$_POST[pagina]' succesvol gewijzigd in '$_POST[new_nav_name]'.</p>";

        } catch (PDOException $e) {
            echo "ERROR: " . $e->getMessage();
        }
    } elseif (isset($_POST['delete_nav'])) {
        try {
            $sql = "DELETE FROM content WHERE title = '$_POST[pagina]';";
    
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $stmt = null;

            $stmt = $pdo->prepare("DELETE FROM module WHERE pagina = '$_POST[pagina]';");
            $stmt->execute();
            $stmt = null;

            rrmdir("./module/$_POST[pagina]");

            echo "<hr> <p>'$_POST[pagina]' succesvol verwijderd.</p>";
        } catch (PDOException $e) {
            echo "ERROR: " . $e->getMessage();
        }
    }
} 

if (isset($_POST['edit_logo']) && !empty($_FILES['change_logo'])) {
    //HERE COMES THE LOGO EDIT FUNCTIONALITY
    $targetDir = "./img/";
    $targetFile = $targetDir . basename($_FILES["change_logo"]['name']);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    if (isset($_POST['edit_logo'])) {
        $check = getimagesize($_FILES['change_logo']['tmp_name']);
        if ($check !== false) {
            $upload = 1;
        } else {
            echo "Het bestand is geen afbeelding";
            $upload = 0;
        }
    }

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "webp") {
        echo "Sorry alleen JPG, JPEG, PNG bestanden zijn toegestaan.";
        $uploadOk = 0;
    }

    if ($upload = 1) {
        if (move_uploaded_file($_FILES['change_logo']['tmp_name'], $targetFile)) {
            $sql = "UPDATE logo SET logoPath = '$targetFile';";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            echo "<hr> <p>Het bestand " . htmlspecialchars(basename($_FILES['change_logo']['name'])) . " is geüpload.</p>";
        } else {
            echo "<p>Er is iets fout gegaan met het uploaden van het bestand.</p>";
        }
    } else {
        echo "<p>Sorry het bestand kan niet geüpload worden.</p>";
    }
}

if (isset($_POST['edit_page']) || isset($_POST['edit_team']) && !empty($_POST['dataToEdit']) || !empty($_POST['change_img']) || !empty($_POST['new_team_name']) || 
    !empty($_POST['captain']) || !empty($_POST['team_info']) || !empty($_POST['team_img'])) {
        var_dump($_FILES);
        var_dump($_POST);
        exit;
    // HERE COMES THE PAGE EDIT FUNCTIONALITY
    if(isset($_POST['edit_page'])) {
        try {
            $sql = "UPDATE content JOIN module ON content.moduleID = module.moduleID SET content.page_content = '$_POST[dataToEdit]' WHERE module.pagina = '$_POST[page]';";
    
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            echo "<hr> <p>De data van de pagina $_POST[page] succesvol geüpdate.</p>";

        } catch (PDOException $e) {
            echo "ERROR: " . $e->getMessage();
        }
    } elseif (isset($_POST['edit_team'])) {
        try {
            $sql = "UPDATE teams SET teamName = '$_POST[new_team_name]', captain = '$_POST[captain]', teamData = '$_POST[team_info]',
            img = '$_POST[team_img]' WHERE teamName = '$_POST[team]'";
            // prepare the query
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            
            // rename("./module/teams/team_img/$_POST[team]", "./module/teams/team_img/$_POST[new_team_name]");
            
            // $targetDir = "./module/teams/team_img/$_POST[new_team_name]";
            // $targetFile = $targetDir . basename($_FILES['team_img']['name']);
            // $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            // $check = getimagesize($_FILES['team_img']['tmp_name']);
            // if ($check !== false) {
            //     $upload = 1;
            // } else {
            //     echo "Het bestand is geen afbeelding";
            //     $upload = 0;
            // }

            // if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "webp") {
            //     echo "Sorry alleen JPG, JPEG, PNG en WEBP bestanden zijn toegestaan.";
            //     $upload = 0;
            // }

            // if ($upload = 1) {
            //     if (move_uploaded_file($_FILES['team_img']['tmp_name'], $targetFile)) {
            //         $sql = "UPDATE teams SET img = '$targetFile';";
            //         $stmt = $pdo->prepare($sql);
            //         $stmt->execute();
            //         echo "<hr> <p>Het bestand " . htmlspecialchars(basename($_FILES['change_logo']['name'])) . " is geüpload.</p>";
            //     } else {
            //         echo "<p>Er is iets fout gegaan met het uploaden van het bestand.</p>";
            //     }
            // } else {
            //     echo "<p>Sorry het bestand kan niet geüpload worden.</p>";
            // }
            
            echo "<hr> <p>Team $_POST[team] succesvol geüpdate.</p>";
        } catch (PDOException $e) {
            echo "ERROR: " . $e->getMessage();
        }
    }
}

?>

