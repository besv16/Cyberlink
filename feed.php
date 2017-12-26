<?php

declare(strict_types=1);

session_start();

$authenticated = $_SESSION['authenticated'] ?? false;
$userID = $_SESSION['userID'] ?? '';

require __DIR__.'/views/header.php';


$pdo = new PDO('sqlite:app/database/database.db');

// HÄMTA ANVÄNDARBILDEN UR DATABASEN OCH VISA UPP...
$statement_1 = $pdo->prepare('SELECT avatar FROM user WHERE userID = :userID');
// bind param password
$statement_1->bindParam(':userID', $userID, PDO::PARAM_STR);
$statement_1->execute();
$img = $statement_1->fetch(PDO::FETCH_ASSOC);

// HÄMTA ALLA LÄNKAR UR DATABASEN OCH VISA UPP...
$statement = $pdo->prepare('SELECT * FROM link');
$statement->execute();



 ?>

<?php require __DIR__.'/views/header.php'; ?>
<?php require __DIR__.'/views/navigation.php'; ?>

<img src="<?php echo $img['avatar']; ?>"></img>
<form action="feed.php" method="post">
  <input type="text" name="title" placeholder="Title">
  <input type="text" name="url" placeholder="URL">
  <button type="submit">Share!</button>
</form>

<?php
$links = $statement->fetchAll(PDO::FETCH_ASSOC);

foreach ($links as $link) {
  ?>

  <article class="post">
    <div><?php echo $link{'title'}; ?></div>
    <div><?php echo $link{'description'}; ?></div>
    <div><?php echo $link{'url'}; ?></div>
  </article>

  <?php
}

?>


<?php require __DIR__.'/views/footer.php'; ?>
