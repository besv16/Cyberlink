<?php

declare(strict_types=1);

session_start();

$authenticated = $_SESSION['authenticated'] ?? false;
$userID = $_SESSION['userID'] ?? '';

require __DIR__.'/views/header.php';

$pdo = new PDO('sqlite:app/database/database.db');

// HÄMTA ANVÄNDARBILDEN UR DATABASEN OCH VISA UPP...
$statement_1 = $pdo->prepare('SELECT avatar FROM user WHERE userID = :userID');
// bind param userID
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
    <p><?php echo $link{'linkID'}; ?></p>
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

  var newarray = [];

  function upVote (score, linkID) {
    console.log("score on link ID: " + linkID + " = " + ++score);
  }

  var up = document.querySelectorAll("p.up");
  var down = document.querySelectorAll("p.down");

  up.forEach(function(up) {
  up.addEventListener("click", function(event) {
    newarray.push(up);
    if (newarray.length == 1) {
      upVote(<?php echo $vote; ?>, <?php echo $linkID; ?>);
    }
    newarray.length = 0;
    console.log(newarray);
  })});


  </script>
  <?php

}

?>



<?php

// POSTA DEN NYA SCORE'n I DATABASEN...
//$statement_vote = $pdo->prepare('UPDATE vote SET score = ":vote" WHERE link = ":linkID"');
// bind param password
//$statement_vote->bindParam(':vote', $vote, PDO::PARAM_STR);
//$statement_vote->bindParam(':linkID', $linkID, PDO::PARAM_STR);
//$statement_vote->execute();
//$new_score = $statement_vote->fetch(PDO::FETCH_ASSOC);

require __DIR__.'/views/footer.php'; ?>
