<?php

declare(strict_types=1);

session_start();

$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);

$userID = $_SESSION['userID'] ?? '';

$authenticated = $_SESSION['authenticated'] ?? false;




$pdo = new PDO('sqlite:app/database/database.db');


// HÄMTA BILDEN UR DATABASEN OCH VISA UPP...
$statement = $pdo->prepare('SELECT avatar FROM user WHERE userID = :userID');
$statement->bindParam(':userID', $userID, PDO::PARAM_STR);
$statement->execute();

$image = $statement->fetch(PDO::FETCH_ASSOC);

// HÄMTA ALL USER INFO UR DATABASEN OCH VISA UPP...
$statement = $pdo->prepare('SELECT * FROM user WHERE userID = :userID');
$statement->bindParam(':userID', $userID, PDO::PARAM_STR);
$statement->execute();

$testing = $statement->fetch(PDO::FETCH_ASSOC);


// HÄMTA LÄNK/AR UR DATABASEN OCH VISA UPP...
$pdo = new PDO('sqlite:app/database/database.db');
$statement = $pdo->prepare('SELECT * FROM link WHERE user = :userID');
$statement->bindParam(':userID', $userID, PDO::PARAM_STR);
$statement->execute();

$links = $statement->fetch(PDO::FETCH_ASSOC);
foreach ($links as $link) {}

 ?>
  <?php require __DIR__.'/views/header.php'; ?>
      <p><?php echo $userID; ?></p>
      <?php if ($message !== ''): ?>
        <p><?php echo $message; ?></p>
      <?php endif; ?>
      <!-- ifall inloggning lyckades appliceras detta på sidan: -->
      <?php if ($authenticated): ?>
        <a href="admin.php">Din profil</a>
        <a href="app/auth/logout.php">Logga ut</a>
        <p><?php echo $testing['email']; ?></p>
        <p><?php echo $testing['bio']; ?></p>
        <img src="<?php echo $image['avatar']; ?>"></img>


        <h1>Din/a länk/ar</h1>
        <p><?php echo 'URL: ' . $links['url']; ?></p>
        <p><?php echo 'Uppladdad av användare: ' . $links['user']; ?></p>

        <h1>Lägg till en länk!</h1>
        <form action="app/links/store.php" method="post">
          <label for="name">URL</label>
          <input type="text" name="url">
          <br />
          <button type="submit">Lägg till!</button>
        </form>




      <!-- annars... -->
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
  <?php require __DIR__.'/views/footer.php'; ?>
