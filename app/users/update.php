<?php

declare(strict_types=1);
$pdo = new PDO('sqlite:app/database/database.db');

// från formuläret:
if (isset($_POST['email'])) {
  if (empty($_POST['email'])) {
  }
  else {
    $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
    // TODO: Implement the database insert logic here.
    $statement_insert = $pdo->prepare('UPDATE user SET email = :email WHERE userID = :userID');
    if (!$statement_insert) {
      die(var_dump($pdo->errorInfo()));
    }
    // bind param email
    $statement_insert->bindParam(':email', $email, PDO::PARAM_STR);
    // bind param userID
    $statement_insert->bindParam(':userID', $userID, PDO::PARAM_INT);

    $statement_insert->execute();
    $user = $statement_insert->fetch(PDO::FETCH_ASSOC);
  }
    header('Location: /edit-acc.php');
}

if (isset($_POST['password'])) {
  if (empty($_POST['password'])) {
  }
  else {
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    // TODO: Implement the database insert logic here.
    $statement_insert = $pdo->prepare('UPDATE user SET password = :password WHERE userID = :userID');
    if (!$statement_insert) {
      die(var_dump($pdo->errorInfo()));
    }
    // bind param password
    $statement_insert->bindParam(':password', $password, PDO::PARAM_STR);
    // bind param userID
    $statement_insert->bindParam(':userID', $userID, PDO::PARAM_INT);

    $statement_insert->execute();
    $user = $statement_insert->fetch(PDO::FETCH_ASSOC);
    }
      header('Location: /edit-acc.php');
  }

if (isset($_POST['bio'])) {
  if (empty($_POST['bio'])) {
  }
  else {
    $bio = filter_var($_POST['bio'], FILTER_SANITIZE_STRING);
    // TODO: Implement the database insert logic here.
    $statement_insert = $pdo->prepare('UPDATE user SET bio = :bio WHERE userID = :userID');
    if (!$statement_insert) {
      die(var_dump($pdo->errorInfo()));
    }
    // bind param bio
    $statement_insert->bindParam(':bio', $bio, PDO::PARAM_STR);
    // bind param userID
    $statement_insert->bindParam(':userID', $userID, PDO::PARAM_INT);

    $statement_insert->execute();
    $user = $statement_insert->fetch(PDO::FETCH_ASSOC);
  }
    header('Location: /edit-acc.php');
}

// BILDUPPLADDNINGEN

if (isset($_FILES['avatar'])) {

  $avatar = $_FILES['avatar'];
  $avatar2 = 'media\img\\'.$avatar['name'];
  $destination = sprintf('%s\%s', __DIR__.'\media\img', $avatar['name']);
  move_uploaded_file($avatar['tmp_name'], $destination);


  // TODO: Implement the database update (inserting img url) logic here.

  $statement_insert_avatar = $pdo->prepare('UPDATE user SET avatar = :avatar WHERE userID = :userID');

  if (!$statement_insert_avatar) {
    die(var_dump($pdo->errorInfo()));
  }

  $statement_insert_avatar->bindParam(':avatar', $avatar2, PDO::PARAM_STR);// bind param userID
  $statement_insert_avatar->bindParam(':userID', $userID, PDO::PARAM_INT);
  $statement_insert_avatar->execute();
  $avatar3 = $statement_insert_avatar->fetch(PDO::FETCH_ASSOC);

  header('Location: /edit-acc.php');

}

// HÄMTA BILDEN UR DATABASEN OCH VISA UPP...
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

$testing = $statement->fetch(PDO::FETCH_ASSOC);
