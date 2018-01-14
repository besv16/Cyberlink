<?php

declare(strict_types=1);

// kopplar upp mot databasen
$pdo = new PDO('sqlite:app/database/database.db');

$authenticated = $_SESSION['authenticated'] ?? false;

// HÄMTA ANVÄNDARBILDEN UR DATABASEN OCH VISA UPP...
$statement = $pdo->prepare('SELECT avatar FROM user WHERE userID = :userID');
$statement->bindParam(':userID', $userID, PDO::PARAM_STR);
$statement->execute();
$image = $statement->fetch(PDO::FETCH_ASSOC);

// HÄMTA LÄNK/AR UR DATABASEN OCH VISA UPP...
$statement = $pdo->prepare('SELECT * FROM link WHERE user = :userID');
$statement->bindParam(':userID', $userID, PDO::PARAM_STR);
$statement->execute();
$links = $statement->fetchAll(PDO::FETCH_ASSOC);

// HÄMTA ALL USER INFO UR DATABASEN OCH VISA UPP...
$statement = $pdo->prepare('SELECT * FROM user WHERE userID = :userID');
$statement->bindParam(':userID', $userID, PDO::PARAM_STR);
$statement->execute();
$user = $statement->fetch(PDO::FETCH_ASSOC);
