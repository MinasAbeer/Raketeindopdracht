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
                <select>";
                foreach ($fetch as $module => $pagina) {
                    $pagina = ucfirst($pagina['pagina']);
                    echo "<option value='$pagina'>$pagina</option>";
                }
                echo "</select>
                    <br>
                <label for='in_wat'>In wat wilt u het wijzigen?</label>
                <input type='text' name='new_nav_name' id='in_wat' class='edit'>
                    <br>
                <input type='checkbox' name='delete_nav' id='delete_nav'>
                <label for='delete_nav'>Verwijderen</label>
                    <br>
                    <br>
                <input type='submit' name='edit-nav' value='Wijzigen'> 
             </form>";
    } elseif (isset($_POST['logo'])) {
        echo "<form action='?module=edit' method='post' enctype='multipart/formdata'>
                <label for='change_logo'>Selecteer het nieuwe logo.</label>
                    <br>
                <input type='file' id='change_logo' name='change_logo'>
                    <br>
                    <br>
                <input type='submit' name='edit_logo' value='Wijzigen'>
            </form>";
    } elseif(isset($_POST['page'])) {
        echo "<p>U heeft er voor gekozen om de pagina '$_POST[page]' te wijzigen.</p> <br>";
        if ($_POST['page'] == 'Teams') {
             echo "<form action='?module=edit' method='post' enctype='multipart/formdata'>
                    <label for='team_name'>Team Naam</label>
                        <br>
                    <input type='text' name='team_name' id='team_name' class='edit'>
                        <br>
                    <label for='captain'>Aanvoeder</label>
                        <br>
                    <input type='text' name='captain' id='captain' class='edit'>
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
        echo "<form action='?module=edit' method='post' enctype='multipart/formdata'>
                <label for='dataToEdit'>Wijzig tekst</label>
                <textarea id='dataToEdit' name='dataToEdit'> </textarea>
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

?>