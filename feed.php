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
$statement = $pdo->prepare('SELECT * FROM link JOIN user ON link.user = user.userID');
$statement->execute();

?>

<?php require __DIR__.'/views/navigation.php'; ?>
<div class="share-container">
  <img class="profile-avatar" src="<?php echo $img['avatar']; ?>"></img>
  <form action="app/links/store.php" method="post">
    <input type="text" name="title" placeholder="Title">
    <input type="text" name="url" placeholder="URL">
    <input type="text" name="description" placeholder="Description">
    <button type="submit">Share!</button>
  </form>
</div>

<?php

$links = $statement->fetchAll(PDO::FETCH_ASSOC);



foreach ($links as $link) {
  ?>
  <article class="post">
    <div class="top"><img class="feed-avatar" src="<?php echo $link{'avatar'}; ?>"></img>
    <div class="title-url"><p><?php echo $link{'title'}; ?></p>
    <p><?php echo $link{'url'}; ?></p></div></div>
    <div class="description"><p><?php echo $link{'description'}; ?></p></div>
    <div><p><?php echo $link{'email'}; ?></p></div>
    <p class="upp">Rösta upp</p>
    <p class="ned">Rösta ned</p>

    <?php
    // HÄMTA VOTES UR DATABASEN OCH VISA UPP...
    $linkID = $link{'linkID'};
    $statement_2 = $pdo->prepare('SELECT score FROM vote WHERE link = :linkID');
    // bind param password
    $statement_2->bindParam(':linkID', $linkID, PDO::PARAM_STR);
    $statement_2->execute();
    $vote = $statement_2->fetch(PDO::FETCH_ASSOC);
    echo $vote{'score'};
    ?>


  </article>
  <?php
}
?>

<?php require __DIR__.'/views/footer.php'; ?>
