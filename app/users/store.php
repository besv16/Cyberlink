<?php

declare(strict_types=1);

// kopplar upp mot databasen
$pdo = new PDO('sqlite:app/database/database.db');

$authenticated = $_SESSION['authenticated'] ?? false;

// HÄMTA ANVÄNDARBILDEN UR DATABASEN OCH VISA UPP...
$statement_1 = $pdo->prepare('SELECT avatar FROM user WHERE userID = :userID');
$statement_1->bindParam(':userID', $userID, PDO::PARAM_STR);
$statement_1->execute();
$image = $statement_1->fetch(PDO::FETCH_ASSOC);

// HÄMTA LÄNK/AR UR DATABASEN OCH VISA UPP...
$statement_2 = $pdo->prepare('SELECT * FROM link WHERE user = :userID');
$statement_2->bindParam(':userID', $userID, PDO::PARAM_STR);
$statement_2->execute();
$links = $statement_2->fetchAll(PDO::FETCH_ASSOC);

// HÄMTA ALL USER INFO UR DATABASEN OCH VISA UPP...
$statement_3 = $pdo->prepare('SELECT * FROM user WHERE userID = :userID');
$statement_3->bindParam(':userID', $userID, PDO::PARAM_STR);
$statement_3->execute();
$user = $statement_3->fetch(PDO::FETCH_ASSOC);
