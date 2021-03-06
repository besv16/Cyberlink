<?php

declare(strict_types=1);

// från formuläret:
if (isset($_POST['title'])) {
  if (empty($_POST['title'])) {
  }
  else {
    // kopplar upp mot databasen
    $pdo = new PDO('sqlite:../database/database.db');
    $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
    $linkID = filter_var($_POST['ID'], FILTER_SANITIZE_STRING);
    // TODO: Implement the database insert logic here.
    $statement_1 = $pdo->prepare('UPDATE link SET title = :title WHERE linkID = :linkID');
    if (!$statement_1) {
      die(var_dump($pdo->errorInfo()));
    }
    // bind param title
    $statement_1->bindParam(':title', $title, PDO::PARAM_STR);
    // bind param linkID
    $statement_1->bindParam(':linkID', $linkID, PDO::PARAM_INT);
    $statement_1->execute();
    echo '<br/><br/>';
  }
  header('Location: /edit-links.php');
}

if (isset($_POST['description'])) {
  if (empty($_POST['description'])) {
  }
  else {
    // kopplar upp mot databasen
    $pdo = new PDO('sqlite:../database/database.db');

    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
    $linkID = filter_var($_POST['ID'], FILTER_SANITIZE_STRING);

    // TODO: Implement the database insert logic here.
    $statement_2 = $pdo->prepare('UPDATE link SET description = :description WHERE linkID = :linkID');
    if (!$statement_2) {
      die(var_dump($pdo->errorInfo()));
    }
    // bind param description
    $statement_2->bindParam(':description', $description, PDO::PARAM_STR);
    // bind param linkID
    $statement_2->bindParam(':linkID', $linkID, PDO::PARAM_INT);
    $statement_2->execute();
  }
  header('Location: /edit-links.php');
}

if (isset($_POST['url'])) {
  if (empty($_POST['url'])) {
  }
  else {
    // kopplar upp mot databasen
    $pdo = new PDO('sqlite:../database/database.db');

    $url = filter_var($_POST['url'], FILTER_SANITIZE_STRING);
    $linkID = filter_var($_POST['ID'], FILTER_SANITIZE_STRING);
    // TODO: Implement the database insert logic here.
    $statement_3 = $pdo->prepare('UPDATE link SET url = :url WHERE linkID = :linkID');
    if (!$statement_3) {
      die(var_dump($pdo->errorInfo()));
    }
    // bind param url
    $statement_3->bindParam(':url', $url, PDO::PARAM_STR);
    // bind param linkID
    $statement_3->bindParam(':linkID', $linkID, PDO::PARAM_INT);
    $statement_3->execute();
  }
  header('Location: /edit-links.php');
}

// HÄMTA LÄNK/AR UR DATABASEN OCH VISA UPP...
$pdo = new PDO('sqlite:app/database/database.db');
$statement = $pdo->prepare('SELECT * FROM link WHERE user = :userID');
$statement->bindParam(':userID', $userID, PDO::PARAM_STR);
$statement->execute();
$links = $statement->fetchAll(PDO::FETCH_ASSOC);
