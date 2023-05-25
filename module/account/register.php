<?php

if (isset($_POST['registerbtn']) && !empty($_POST['fname']) && !empty($_POST['lname']) && !empty($_POST['birthday']) && 
    !empty($_POST['register_username']) && !empty($_POST['register_password'])) {
    $user = new account();
    $user->register($_POST['fname'], $_POST['lname'], $_POST['birthday'], $_POST['register_username'], $_POST['register_password']);
}
else {
    $register = '
    <h1> Register </h1>
    <form action="?module=account&view=register" method="post">
        <label for="fname"> Firstname: </label>
            <br>
        <input type="text" name="fname" placeholder="Firstname" require>
            <br>
        <label for="lname"> Lastname: </label>
            <br>
        <input type="text" name="lname" placeholder="Lastname" require>
            <br>
        <label for="birthday"> Birthday: </label>
            <br>
        <input type="date" name="birthday" placeholder="Birthday" require>
            <br>
        <label for="register_username">Username</label>
            <br>
        <input type="text" name="register_username" placeholder="Username" require>
            <br>
        <label for="register_password">Password</label>
            <br>
        <input type="password" name="register_password" placeholder="Password" require>
            <br>
            <br>
        <button type="submit" name="registerbtn">Register</button>
    </form>';

    echo $register;
}

?>