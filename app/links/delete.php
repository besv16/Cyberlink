<?php

declare(strict_types=1);

// TA BORT EN LÄNK

if (isset($_POST['ID-delete'])) {
  if (empty($_POST['ID-delete'])) {
  }
  else {
    // kopplar upp mot databasen
    $pdo = new PDO('sqlite:../database/database.db');
    $linkID = filter_var($_POST['ID-delete'], FILTER_SANITIZE_STRING);
    echo $linkID;
    // TODO: Implement the database insert logic here.
    $statement_delete = $pdo->prepare('DELETE FROM link WHERE linkID = :linkID');
    if (!$statement_delete) {
      die(var_dump($pdo->errorInfo()));
    }

    // bind param linkID
    $statement_delete->bindParam(':linkID', $linkID, PDO::PARAM_INT);

    $statement_delete->execute();
  }
  header('Location: /edit-links.php');
}
