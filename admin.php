<?php

declare(strict_types=1);

// startar session
session_start();

// sätter en sessionsvariabel vid namn userID som har värdet av den inloggades ID-nummer
$userID = $_SESSION['userID'];

// kopplar upp mot databasen
$pdo = new PDO('sqlite:app/database/database.db');

$authenticated = $_SESSION['authenticated'] ?? false;

// HÄMTA BILDEN UR DATABASEN OCH VISA UPP...

$statement = $pdo->prepare('SELECT avatar FROM user WHERE userID = :userID');
$statement->bindParam(':userID', $userID, PDO::PARAM_STR);
$statement->execute();

$image = $statement->fetch(PDO::FETCH_ASSOC);




// HÄMTA LÄNK/AR UR DATABASEN OCH VISA UPP...
$pdo = new PDO('sqlite:app/database/database.db');
$statement = $pdo->prepare('SELECT * FROM link WHERE user = :userID');
$statement->bindParam(':userID', $userID, PDO::PARAM_STR);
$statement->execute();

$links = $statement->fetchAll(PDO::FETCH_ASSOC);




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


 ?>

<?php require __DIR__.'/views/header.php'; ?>
<?php require __DIR__.'/views/navigation.php'; ?>

  <a class="edit-a" href="edit-acc.php">
    <img class="edit" src="/Cyberlink/media/img/edit.svg"></img>
  </a>
<div class="account">
  <img class="profile-avatar" src="<?php echo $image['avatar']; ?>"></img>
  <div class="meta">
    <p><?php echo $testing['email']; ?></p>
  </div>
</div>
<div class="bio">
  <p><?php echo $testing['bio']; ?></p>
</div>

<hr />
<a class="edit-a" href="edit-links.php">
  <img class="edit" src="/Cyberlink/media/img/edit.svg"></img>
</a>
<div class="link-heading">
  <h1>Your shared links</h1>
</div>

<?php

foreach ($links as $link) {
  ?>
  <div class="post">
    <p><?php echo $link['title']; ?></p>
    <p><?php echo $link['description']; ?></p>
    <p><?php echo $link['url']; ?></p>
  </div>
  <?php
}

require __DIR__.'/views/footer.php'; ?>
