<?php

declare(strict_types=1);

$authenticated = $_SESSION['authenticated'] ?? false;

// kopplar upp mot databasen
$pdo = new PDO('sqlite:app/database/database.db');
$statement_2 = $pdo->prepare('SELECT score FROM vote WHERE link = :linkID');
// bind param password
$statement_2->bindParam(':linkID', $linkID, PDO::PARAM_INT);
$statement_2->execute();
$vote = $statement_2->fetch(PDO::FETCH_ASSOC);
$vote = $vote{'score'};

if ($vote == NULL) {
  $vote = 0;
  $statement_insert_vote = $pdo->prepare('INSERT INTO vote (score, link) VALUES (:vote, :linkID)');
  // bind param LINKID
  $statement_insert_vote->bindParam(':linkID', $linkID, PDO::PARAM_INT);
  // bind param SCORE
  $statement_insert_vote->bindParam(':vote', $vote, PDO::PARAM_INT);
  $statement_insert_vote->execute();
  $vote = $statement_insert_vote->fetch(PDO::FETCH_ASSOC);
}
