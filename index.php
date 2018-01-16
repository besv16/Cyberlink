<?php

declare(strict_types=1);

session_start();
$userID = $_SESSION['userID'] ?? '';
$authenticated = $_SESSION['authenticated'] ?? false;

require __DIR__.'/views/header.php';
require __DIR__.'/views/navigation.php';

?>

<div class="landing-page">
  <div class="img-demo">
    <img src="media/img/demo.png"></img>
  </div>
  <div class="login-signup">
    <h1>Log in</h1>
    <form action="app/auth/login.php" method="post">
      <input type="text" name="email" placeholder="Email">
      <input type="password" name="password" placeholder="Password">
      <button type="submit">Sign in</button>
    </form>
    <p>Don't have an account? - Then <a href="registration.php"> sign up </a> for one!</p>
  </div>
</div>

<!-- ifall inloggning lyckades (authenticated = true): skicka användaren till feed.php -->
<?php if ($authenticated): ?>
  <?php header('Location: feed.php'); ?>
<?php endif; ?>
<?php require __DIR__.'/views/footer.php'; ?>
