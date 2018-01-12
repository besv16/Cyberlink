<?php

session_start();

if (isset($_POST['linkID'], ($_POST['up-vote']))) {
  $linkID = $_POST['linkID'];
  $newUpScore = $_POST['up-vote'];

  echo "LINK ID: " . $linkID . ", new score: " . $newUpScore;

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

if (isset($_POST['down-vote'])) {
  $newDownScore = $_POST['down-vote'];
  echo "Score: " . $newDownScore;
}


?>
