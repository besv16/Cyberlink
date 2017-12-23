<?php

declare(strict_types=1);

session_start();
$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);
$userID = $_SESSION['userID'] ?? '';
$authenticated = $_SESSION['authenticated'] ?? false;

 ?>
 <?php require __DIR__.'/views/header.php'; ?>
 <?php require __DIR__.'/views/navigation.php'; ?>
<?php //if ($message !== ''): ?>
<!-- <p><?php //echo $message; ?></p> -->
<?php //endif; ?>
<div class="landing-page">
  <div class="img-demo">
    <img src="media/img/demo-index.svg"></img>
  </div>
  <div class="login-signup">
    <h1>Log in</h1>
    <form action="app/auth/login.php" method="post">
      <input type="text" name="email" placeholder="Email">

      <input type="password" name="password" placeholder="Password">

      <button type="submit">Sign in</button>
    </form>
    <a href="app/auth/register.php">Don't have an account? - Then sign up for one!</a>
  </div>
</div>
<!-- ifall inloggning lyckades appliceras detta på sidan: -->
<?php if ($authenticated): ?>
  <?php header('Location: admin.php'); ?>
<?php endif; ?>
  <?php require __DIR__.'/views/footer.php'; ?>
