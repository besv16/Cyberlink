<?php

declare(strict_types=1);

session_start();

if (isset($_POST['linkID'], ($_POST['up-vote']))) {
  $linkID = $_POST['linkID'];
  $newUpScore = $_POST['up-vote'];

  $pdo = new PDO('sqlite:../database/database.db');

  // TODO: Implement the database insert logic here.
  $statement_upVote = $pdo->prepare('UPDATE vote SET score = :newUpScore, link = :linkID WHERE link = :linkID');

  if (!$statement_upVote) {
    die(var_dump($pdo->errorInfo()));
  }

  // bind param linkID
  $statement_upVote->bindParam(':linkID', $linkID, PDO::PARAM_INT);
  // bind param newUpScore
  $statement_upVote->bindParam(':newUpScore', $newUpScore, PDO::PARAM_INT);
  $statement_upVote->execute();
  $result = $statement_upVote->fetch(PDO::FETCH_ASSOC);

  header('Location: /Cyberlink/feed.php');

}



if (isset($_POST['linkID'], ($_POST['down-vote']))) {

  if ($_POST['down-vote'] == -1) {
    $_POST['down-vote'] = 0;
  }
  $linkID = $_POST['linkID'];
  $newDownScore = $_POST['down-vote'];

  $pdo = new PDO('sqlite:../database/database.db');

  // TODO: Implement the database insert logic here.
  $statement_downVote = $pdo->prepare('UPDATE vote SET score = :newDownScore, link = :linkID WHERE link = :linkID');

  if (!$statement_downVote) {
    die(var_dump($pdo->errorInfo()));
  }


  // bind param linkID
  $statement_downVote->bindParam(':linkID', $linkID, PDO::PARAM_INT);
  // bind param newDownScore
  $statement_downVote->bindParam(':newDownScore', $newDownScore, PDO::PARAM_INT);

  $statement_downVote->execute();

  $result = $statement_downVote->fetch(PDO::FETCH_ASSOC);


  header('Location: /Cyberlink/feed.php');

}




?>
