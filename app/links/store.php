<?php
declare(strict_types=1);

// startar session
session_start();

// sätter en sessionsvariabel vid namn userID som har värdet av den inloggades ID-nummer
$userID = $_SESSION['userID'];

// require __DIR__.'/../autoload.php';
// In this file we store/insert new posts in the database.

$pdo = new PDO('sqlite:../database/database.db');

echo $userID;

if (isset($_POST['url'])) {
    $url = filter_var($_POST['url'], FILTER_SANITIZE_STRING);

    // TODO: Implement the database insert logic here.

    $statement_insert = $pdo->prepare('INSERT INTO link (url, user) VALUES (:url, :user)');

    if (!$statement_insert) {
      die(var_dump($pdo->errorInfo()));
    }

    // bind param url
    $statement_insert->bindParam(':url', $url, PDO::PARAM_STR);
    // bind param user
    $statement_insert->bindParam(':user', $userID, PDO::PARAM_STR);
    $statement_insert->execute();

    header('Location: /Cyberlink/');

    // redirect('/Cyberlink/index.php');
}
