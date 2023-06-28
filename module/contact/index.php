<?php

$form = 
'<form action="#" method="POST" class="contactForm">
    <input type="hidden" name="contactForm" value="1">
   <label for="name"> Naam: </label>
   <br />
   <input required="" type="text" name="name" id="name" class="contant_name"/>
   <br />
   <label for="email"> Email: </label>
   <br />
   <input required="" type="email" name="email" id="email" class="contant_email"/>
   <br />
   <label for="message"> Bericht: </label>
   <br />
   <textarea required="" name="message" id="message" cols="30" rows="10"></textarea>
   <br />
   <input required="" type="submit" value="Verstuur" />
</form>';

$succes = '<p> Bedankt voor het opsturen van de formulier. Wij zullen zo spoedig mogelijk contact met u opnemen. </p>';


if (isset($_POST['contactForm']) && ($_POST['contactForm'] == '1')) { //
    // succestext, dus als formulier succesvol is verzonden
    // Naast text, zul je ook data moeten verwerken in de database
    global $pdo;

    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];


    $data = $pdo->prepare("INSERT INTO contact (name, email, message) VALUES (:name, :email, :message)");
    $data->bindParam(':name', $name);
    $data->bindParam(':email', $email);
    $data->bindParam(':message', $message);
    $add = $data->execute();
    
    if ($add) { 
        echo $succes;
    } else { 
        throw new Exception('Er is iets fout gegaan');
    }
} else {
    getContent($_GET['module']);
    echo $form;
}


?>