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
    <p class="up">Rösta upp</p>
    <p class="down">Rösta ned</p>



    <?php
    // HÄMTA VOTES UR DATABASEN OCH VISA UPP...
    $linkID = $link{'linkID'};
    $statement_2 = $pdo->prepare('SELECT score FROM vote WHERE link = :linkID');
    // bind param password
    $statement_2->bindParam(':linkID', $linkID, PDO::PARAM_STR);
    $statement_2->execute();
    $vote = $statement_2->fetch(PDO::FETCH_ASSOC);
    $vote = $vote{'score'};
    echo "variabel vote = " . $vote;

    ?>

  </article>
  <script type="text/javascript">

  'use strict';

  console.log('score on LINKID ' + <?php echo $linkID; ?> + ' : ' + <?php echo $vote; ?>);

  var up = document.querySelectorAll("p.up");
  var down = document.querySelectorAll("p.down");


    up.forEach(function(up) {
    up.addEventListener("click", function(event) {
      console.log(<?php echo $linkID; ?>);
      if (<?php echo $linkID; ?> == 1) {
        console.log("hi");
      }
      console.log('score after upvote on link with ID ' + <?php echo $linkID; ?> + ': ' + <?php echo ++$vote; ?>);
    })});

    down.forEach(function(down) {
    down.addEventListener("click", function(event) {
      console.log('score after downvote on link with ID ' + <?php echo $linkID; ?> + ': ' + <?php echo --$vote; ?>);
    })});


  </script>
  <?php



}

?>



<?php

// HÄMTA ANVÄNDARBILDEN UR DATABASEN OCH VISA UPP...
//$statement_vote = $pdo->prepare('UPDATE vote SET score = ":vote" WHERE link = ":linkID"');
// bind param password
//$statement_vote->bindParam(':vote', $vote, PDO::PARAM_STR);
//$statement_vote->bindParam(':linkID', $linkID, PDO::PARAM_STR);
//$statement_vote->execute();
//$new_score = $statement_vote->fetch(PDO::FETCH_ASSOC);

?>

<?php require __DIR__.'/views/footer.php'; ?>
