<?php

declare(strict_types=1);

// kopplar upp mot databasen
$pdo = new PDO('sqlite:app/database/database.db');

$authenticated = $_SESSION['authenticated'] ?? false;

$statement_2 = $pdo->prepare('SELECT score FROM vote WHERE link = :linkID');
// bind param password
$statement_2->bindParam(':linkID', $linkID, PDO::PARAM_INT);
$statement_2->execute();
$vote = $statement_2->fetch(PDO::FETCH_ASSOC);
$vote = $vote{'score'};
