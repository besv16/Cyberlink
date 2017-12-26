<?php

declare(strict_types=1);

session_start();
$authenticated = $_SESSION['authenticated'] ?? false;

require __DIR__.'/views/header.php';


$pdo = new PDO('sqlite:app/database/database.db');

// HÄMTA BILDEN UR DATABASEN OCH VISA UPP...
$statement = $pdo->prepare('SELECT * FROM link');
$statement->execute();



 ?>

<?php require __DIR__.'/views/header.php'; ?>
<?php require __DIR__.'/views/navigation.php'; ?>

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
