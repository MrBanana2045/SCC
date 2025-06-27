<?php
session_start();
if(isset($_POST['user']) && isset($_POST['pass'])){
    $username = $_POST['user'];
    $password = $_POST['pass'];
    $jsonData = file_get_contents('data/users.json');
    $users = json_decode($jsonData, true); 

    $userFound = false;
    foreach ($users['users'] as $user) {
        if ($user['username'] === $username && $user['password'] == password_verify($password,  $user['password'])) {
            $_SESSION['user'] = $username;
            $userFound = true;
            break;
        }
    }

    if ($userFound) {
        header('Location: index.php');
    } else {
        echo "Error";
    }
}
?
