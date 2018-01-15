<?php

declare(strict_types=1);

session_start();

$pdo = new PDO('sqlite:../database/database.db');

$authenticated = $_SESSION['authenticated'] ?? false;

if (!$authenticated && isset($_POST['email'], $_POST['password'])) {
  $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));

  // TODO: Implement the database login logic here.
  $statement = $pdo->prepare('SELECT * FROM user WHERE email = :email');
  $statement->bindParam(':email', $email, PDO::PARAM_STR);
  $statement->execute();

  $user = $statement->fetch(PDO::FETCH_ASSOC);

  if (!$user) {
    $_SESSION['message'] = 'Whoops. Looks like you missed something. Please try again.';
  }
  else {
    if (password_verify($_POST['password'], $user['password'])) {
      $_SESSION['userID'] = $user['userID'];
      $_SESSION['message'] = 'You have successfully logged in ' . $email;
      $_SESSION['authenticated'] = true;
    }
  }
}

header('Location: ../../');
