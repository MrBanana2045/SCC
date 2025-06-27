<?php
if (isset($_POST['email']) && isset($_POST['pass'])) {
    $filename = 'data/users.json';

    if (file_exists($filename)) {
        $jsonData = file_get_contents($filename);
        $data = json_decode($jsonData, true);
    } else {
        $data = ['users' => []];
    }

    $users = &$data['users'];
    $email = $_POST['email'];
    $password = $_POST['pass'];

    $user_found = false;
    foreach ($users as &$user) {
        if ($user['email'] === $email) {
            $user['password'] = password_hash($password, PASSWORD_DEFAULT);
            $user_found = true;
            break;
        }
    }

    file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT));

    header('Location: login.php');
    exit;
}
?>
