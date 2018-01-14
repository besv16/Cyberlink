<?php
declare(strict_types=1);

// startar session
session_start();

// sätter en sessionsvariabel vid namn userID som har värdet av den inloggades ID-nummer
$userID = $_SESSION['userID'];

// In this file we store/insert new posts in the database.

$pdo = new PDO('sqlite:../database/database.db');

echo $userID;

if (isset($_POST['title'], $_POST['description'], $_POST['url'])) {
    $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
    $url = filter_var($_POST['url'], FILTER_SANITIZE_STRING);

    // TODO: Implement the database insert logic here.
    $statement_insert = $pdo->prepare('INSERT INTO link (title, description, url, user) VALUES (:title, :description, :url, :user)');

    if (!$statement_insert) {
      die(var_dump($pdo->errorInfo()));
    }

    // bind param title
    $statement_insert->bindParam(':title', $title, PDO::PARAM_STR);
    // bind param description
    $statement_insert->bindParam(':description', $description, PDO::PARAM_STR);
    // bind param url
    $statement_insert->bindParam(':url', $url, PDO::PARAM_STR);
    // bind param user
    $statement_insert->bindParam(':user', $userID, PDO::PARAM_STR);
    $statement_insert->execute();

    header('Location: /Cyberlink/');

}
