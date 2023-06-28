<?php

$account = '';

if (isset($_POST['loginbtn']) && !empty($_POST['login_username']) && !empty($_POST['login_password'])) {
    if ($user->login($_POST['login_username'], $_POST['login_password'])) {
        header('Location:?module=account&view=account');
    } else {
        $account = '<p>Probeer opnieuw</p>';
    }
} 

$account .= '
<h1> Login </h1>

<form action="?module=account&view=login" method="post">
    <label for="login_username">Username</label>
        <br>
    <input type="text" name="login_username" placeholder="Username" require>
        <br>
    <label for="login_password">Password</label>
        <br>
    <input type="password" name="login_password" placeholder="Password" require>
        <br>
        <br>
    <input type="submit" name="loginbtn" value="Login">
</form>

<hr style="border: 2px solid black;">

<p>Heeft u nog geen account? Klik <a href="index.php?module=account&view=register">hier</a> om te registreren.</p>';




echo $account;
?>