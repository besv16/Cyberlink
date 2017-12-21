<?php

declare(strict_types=1);

session_start();

$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);

$userID = $_SESSION['userID'] ?? '';

$authenticated = $_SESSION['authenticated'] ?? false;

 ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="assets/styles/main.css" type="text/css"/>
    </head>
    <body>
      <p><?php echo $userID; ?></p>
      <?php if ($message !== ''): ?>
        <p><?php echo $message; ?></p>
      <?php endif; ?>
      <?php if ($authenticated): ?>
        <a href="admin.php">Din profil</a>
        <a href="app/auth/logout.php">Logga ut</a>
      <?php else: ?>
        <a href="app/auth/register.php">Registrera dig</a>
        <h1>Logga in</h1>
        <form action="app/auth/login.php" method="post">
          <label for="name">Email</label>
          <input type="text" name="email">
          <br />
          <label for="password">Lösenord</label>
          <input type="password" name="password">
          <br />
          <button type="submit">Logga in</button>
        </form>
      <?php endif; ?>
    </body>
</html>
