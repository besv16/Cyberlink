<?php

declare(strict_types=1);

$pdo = new PDO('sqlite:../database/database.db');

if (isset($_POST['email'], $_POST['password'])) {
    $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // TODO: Implement the database insert logic here.

    $statement_insert = $pdo->prepare('INSERT INTO user (email, password) VALUES (:email, :password)');

    if (!$statement_insert) {
      die(var_dump($pdo->errorInfo()));
    }

    // bind param email
    $statement_insert->bindParam(':email', $email, PDO::PARAM_STR);
    // bind param password
    $statement_insert->bindParam(':password', $password, PDO::PARAM_STR);
    $statement_insert->execute();

    header('Location: /Cyberlink/');

}

require __DIR__.'/../../views/header.php';
require __DIR__.'/../../views/navigation.php';

?>

<div class="landing-page">
  <div class="img-demo">
    <img src="/Cyberlink/media/img/demo-index.svg"></img>
  </div>
  <div class="login-signup">
    <h1>Sign up</h1>
    <form action="register.php" method="post">
      <input type="text" name="email" placeholder="Email">
      <input type="password" name="password" placeholder="Password">
      <button type="submit">Join our community!</button>
    </form>
  </div>
</div>

<?php require __DIR__.'/../../views/footer.php'; ?>
