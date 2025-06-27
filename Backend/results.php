<?php
session_start();

if (isset($_POST['number']) && isset($_POST['code']) && isset($_POST['desc'])) {
    if (mb_strlen($_POST['desc']) > 200) {
        echo "<script>
                alert('200 Character');
                window.location='index.php';
              </script>";
        exit;
    }
    $filename = 'data/messagesdata.json';

    if (file_exists($filename)) {
        $jsonData = file_get_contents($filename);
        $users = json_decode($jsonData, true);
        if (!is_array($users) || !isset($users['results'])) {
            $users = ['results' => []];
        }
    } else {
        $users = ['results' => []];
    }

    $challengesFile = 'data/challenges.json';
    $challengesData = json_decode(file_get_contents($challengesFile), true);
    if (!is_array($challengesData) || !isset($challengesData['challenges'])) {
        echo "<script>alert('Error'); window.location='index.php';</script>";
        exit;
    }

    $numberInput = htmlspecialchars($_POST['number']);
    $passMatch = false;

    foreach ($challengesData['challenges'] as $challenge) {
        if (isset($challenge['pass']) && $challenge['pass'] == $numberInput) {
            $passMatch = true;
            break;
        }
    }

    if ($passMatch) {
     $users['results'][] = [
            'user' => htmlspecialchars($_SESSION['user']),
            'number' => htmlspecialchars($_POST['number']),
            'code' => htmlspecialchars($_POST['code']),
            'desc' => htmlspecialchars($_POST['desc']),
            'time' => htmlspecialchars(date('h:i') . ' | ' . date('Y-m-d'))
        ];

        $statis['statis'][] = [
            'user' => htmlspecialchars($_SESSION['user']),
            'solved' => htmlspecialchars($_POST['number'])
        ];

        file_put_contents($filename, json_encode($users, JSON_UNESCAPED_UNICODE));
        file_put_contents('data/statis.json', json_encode($statis, JSON_UNESCAPED_UNICODE));

        header('Location: index.php');
        exit;
    } else {
        echo "<script>
                alert('Error Code Challenge');
                window.location='index.php';
              </script>";
        exit;
    }
}
?>
