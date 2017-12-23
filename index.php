<?php

declare(strict_types=1);

session_start();
$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);
$userID = $_SESSION['userID'] ?? '';
$authenticated = $_SESSION['authenticated'] ?? false;

 ?>
  <?php require __DIR__.'/views/header.php'; ?>
      <p><?php echo $userID; ?></p>
      <?php if ($message !== ''): ?>
        <p><?php echo $message; ?></p>
      <?php endif; ?>
      <div class="landing-page">
        <img src="media/img/demo-index.svg"></img>
        <div class="login-signup">
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
          <a href="app/auth/register.php">Registrera dig</a>
        </div>
        <a>Sign up</a>
      </div>
      <!-- ifall inloggning lyckades appliceras detta på sidan: -->
      <?php if ($authenticated): ?>
        <?php header('Location: admin.php'); ?>


      <!-- annars... -->
      <?php else: ?>
        <p>EJ inloggad..</p>
      <?php endif; ?>
  <?php require __DIR__.'/views/footer.php'; ?>
