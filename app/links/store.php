<?php

declare(strict_types=1);

// In this file we store/insert new posts in the database.
if (isset($_POST['title'], $_POST['description'], $_POST['url'])) {

  session_start();
  $authenticated = $_SESSION['authenticated'] ?? false;
  $userID = $_SESSION['userID'];

  $pdo = new PDO('sqlite:../database/database.db');

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

   header('Location: /');

}

// HÄMTA ALLA LÄNKAR UR DATABASEN OCH VISA UPP...
$statement = $pdo->prepare('SELECT * FROM link JOIN user ON link.user = user.userID ORDER BY linkID DESC');
$statement->execute();

$links = $statement->fetchAll(PDO::FETCH_ASSOC);
