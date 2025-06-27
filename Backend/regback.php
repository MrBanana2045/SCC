<?php
session_start();

if (isset($_POST['user']) && isset($_POST['pass']) && isset($_POST['email'])) {
    $filename = 'data/users.json';

    if (file_exists($filename)) {
        $jsonData = file_get_contents($filename);
        $users = json_decode($jsonData, true);
        if (!is_array($users) || !isset($users['users'])) {
            $users = ['users' => []];
        }
    } else {
        $users = ['users' => []];
    }

    $username = trim($_POST['user']);
    $email = trim($_POST['email']);
    $password = trim($_POST['pass']);
    if (!preg_match('/^[a-zA-Z]+$/', $username)) {
    	header('Location: login.php');
    exit;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    }
    $isDuplicate = false;
    foreach ($users['users'] as $user) {
        if (isset($user['username']) && $user['username'] === $username) {
            $isDuplicate = true;
            break;
        }
    }

    if ($isDuplicate) {
    	header('Location: login.php');
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $users['users'][] = [
        'username' => htmlspecialchars($username),
        'email' => $email,
        'password' => $hashedPassword
    ];
    file_put_contents($filename, json_encode($users, JSON_PRETTY_PRINT));
    header('Location: login.php');
    exit;
}
?>
