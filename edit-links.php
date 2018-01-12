<?php

declare(strict_types=1);

// startar session
session_start();

// sätter en sessionsvariabel vid namn userID som har värdet av den inloggades ID-nummer
$userID = $_SESSION['userID'];

// kopplar upp mot databasen
$pdo = new PDO('sqlite:app/database/database.db');

$authenticated = $_SESSION['authenticated'] ?? false;


// från formuläret:

if (isset($_POST['title'])) {
  if (empty($_POST['title'])) {
  }
  else {
    // kopplar upp mot databasen
    $pdo = new PDO('sqlite:app/database/database.db');

    $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
    $linkID = filter_var($_POST['ID'], FILTER_SANITIZE_STRING);
    // $linkID = $link['linkID'];
    // TODO: Implement the database insert logic here.
    $statement_1 = $pdo->prepare('UPDATE link SET title = :title WHERE linkID = :linkID');
    if (!$statement_1) {
      die(var_dump($pdo->errorInfo()));
    }
    // bind param title
    $statement_1->bindParam(':title', $title, PDO::PARAM_STR);
    // bind param linkID
    $statement_1->bindParam(':linkID', $linkID, PDO::PARAM_INT);
    $statement_1->execute();
    echo '<br/><br/>';
  }
}

if (isset($_POST['description'])) {
  if (empty($_POST['description'])) {
  }
  else {
    // kopplar upp mot databasen
    $pdo = new PDO('sqlite:app/database/database.db');

    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
    $linkID = filter_var($_POST['ID'], FILTER_SANITIZE_STRING);

    // TODO: Implement the database insert logic here.
    $statement_2 = $pdo->prepare('UPDATE link SET description = :description WHERE linkID = :linkID');
    if (!$statement_2) {
      die(var_dump($pdo->errorInfo()));
    }
    // bind param description
    $statement_2->bindParam(':description', $description, PDO::PARAM_STR);
    // bind param linkID
    $statement_2->bindParam(':linkID', $linkID, PDO::PARAM_INT);
    $statement_2->execute();
  }
}

if (isset($_POST['url'])) {
  if (empty($_POST['url'])) {
  }
  else {
    // kopplar upp mot databasen
    $pdo = new PDO('sqlite:app/database/database.db');

    $url = filter_var($_POST['url'], FILTER_SANITIZE_STRING);
    $linkID = filter_var($_POST['ID'], FILTER_SANITIZE_STRING);
    // $linkID = $link['linkID'];
    // TODO: Implement the database insert logic here.
    $statement_3 = $pdo->prepare('UPDATE link SET url = :url WHERE linkID = :linkID');
    if (!$statement_3) {
      die(var_dump($pdo->errorInfo()));
    }
    // bind param url
    $statement_3->bindParam(':url', $url, PDO::PARAM_STR);
    // bind param linkID
    $statement_3->bindParam(':linkID', $linkID, PDO::PARAM_INT);
    $statement_3->execute();
  }
}


// TA BORT EN LÄNK

if (isset($_POST['ID-delete'])) {
  if (empty($_POST['ID-delete'])) {
  }
  else {
    // kopplar upp mot databasen
    $pdo = new PDO('sqlite:app/database/database.db');
    $linkID = filter_var($_POST['ID-delete'], FILTER_SANITIZE_STRING);
    echo $linkID;
    // TODO: Implement the database insert logic here.
    $statement_delete = $pdo->prepare('DELETE FROM link WHERE linkID = :linkID');
    if (!$statement_delete) {
      die(var_dump($pdo->errorInfo()));
    }

    // bind param linkID
    $statement_delete->bindParam(':linkID', $linkID, PDO::PARAM_INT);

    $statement_delete->execute();
  }
}


// HÄMTA LÄNK/AR UR DATABASEN OCH VISA UPP...
$pdo = new PDO('sqlite:app/database/database.db');
$statement = $pdo->prepare('SELECT * FROM link WHERE user = :userID');
$statement->bindParam(':userID', $userID, PDO::PARAM_STR);
$statement->execute();
$links = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<?php require __DIR__.'/views/header.php'; ?>
<?php require __DIR__.'/views/navigation.php'; ?>

<?php

foreach ($links as $link) {
  $linkID = $link['linkID'];
  ?>
  <div class="post">
    <div class="delete-links">
      <form class="delete-links" action="edit-links.php" method="post">
        <input type="text" name="ID-delete" class="hidden" value="<?php echo $linkID; ?>">
        <input class="image" name="image" type="image" alt="Delete" src="/Cyberlink/media/img/delete.svg">
      </form>
    </div>
    <form class="edit-links" action="edit-links.php" method="post">
      <input type="text" name="ID" class="hidden" value="<?php echo $linkID; ?>">
      <input type="text" name="title" placeholder="<?php echo $link['title']; ?>">
      <input type="text" name="description" placeholder="<?php echo $link['description']; ?>">
      <input type="text" name="url" placeholder="<?php echo $link['url']; ?>">
      <button type="submit">Save</button>
    </form>
  </div>
  <?php
}

require __DIR__.'/views/footer.php'; ?>
