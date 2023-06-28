<?php

class account 
{
    private $con;   

    public function __construct()
    {
        global $pdo;
        $this->con = $pdo;

        $sql = "CREATE TABLE IF NOT EXISTS `userdata` (
            `id` int(3) NOT NULL AUTO_INCREMENT,
            `firstname` varchar(50) NOT NULL,
            `lastname` varchar(50) NOT NULL,
            `birthday` date NOT NULL,
            `username` varchar(50) NOT NULL,
            `password` varchar(255) NOT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
          ";

          $pdo->query($sql);
    }

    public function login ($username, $password)
    { 
        global $pdo;

        $sql = "SELECT * FROM userdata WHERE username = BINARY(:username)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        if ($user) {
            if (password_verify($password, $user['password'])) { 
   
                $_SESSION['user'] = [];
                $_SESSION['user']['user_id'] = $user['id'];
                $_SESSION['user']['username'] = $user['username'];
                
                return true;    
            } else {
                echo "Wachtwoord is onjuist!";
            }
        } else {
            echo "Gebruikersnaam is onjuist!";
        }
        return false;
    }

    public function register ($firstname, $lastname, $birthday, $username, $password)
    {
        global $pdo;

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $usernameCheck = "SELECT username FROM userdata WHERE username = :username";
        $stmt = $pdo->prepare($usernameCheck);
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        if ($user) {
            echo "Gebruikersnaam bestaat al. <br>";
            echo "<a href='index.php'>Klik hier om te terug te gaan naar de inlog/registreer pagina</a>";
            exit;
        } 

        $sql = "INSERT INTO userdata (`firstname`, `lastname`, `birthday`, `username`, `password`) 
                VALUES (:firstname, :lastname, :birthday, :username, :password)";
        $prep = $pdo->prepare($sql);
        $exec = $prep->execute(['firstname' => $firstname, 'lastname' => $lastname, 'birthday' => $birthday, 'username' => $username, 
        'password' => $hash]);

        if ($exec) {
            echo "Account registratie gelukt! Welkom $firstname. <br>
                Klik <a href='?module=account&view=login'>hier</a> om te kunnen inloggen.";     
        } else {
            echo "Er is iets misgegaan";
        }
    }

    public function logout()
    {
        if (self::isUserLoggedIn())
        {
            unset($_SESSION['user']);
        }
    }

    static public function isUserLoggedIn()
    {
        if (isset($_SESSION['user'])) { 
            return true;
        } else {
            return false;
        }
    }

    static public function getUserData()
    {
        if (self::isUserLoggedIn()) {
            global $pdo;
            $id = $_SESSION['user']['user_id'];
            $sql = "SELECT * FROM userdata WHERE id = :id;";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['id' => $id]);
            $user = $stmt->fetch();
            return $user;
        } else {
            return false;
        }
    }
}

?>
