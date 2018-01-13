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
$statement_1->bindParam(':userID', $userID, PDO::PARAM_INT);
$statement_1->execute();
$img = $statement_1->fetch(PDO::FETCH_ASSOC);

// HÄMTA ALLA LÄNKAR UR DATABASEN OCH VISA UPP...
$statement = $pdo->prepare('SELECT * FROM link JOIN user ON link.user = user.userID ORDER BY linkID DESC');
$statement->execute();

?>

<?php require __DIR__.'/views/navigation.php'; ?>
<div class="share-container">
  <img class="profile-avatar" src="<?php echo $img['avatar']; ?>"></img>
  <form action="app/links/store.php" method="post">
    <input type="text" name="title" placeholder="Title">
    <input type="text" name="url" placeholder="URL">
    <input type="text" name="description" placeholder="Description">
    <input type="hidden" name="score" value="0">
    <button type="submit">Share!</button>
  </form>
</div>

<?php

$links = $statement->fetchAll(PDO::FETCH_ASSOC);

foreach ($links as $link) {
  ?>
  <article class="post">

    <div class="meta-wrapper">


    <?php

    // HÄMTA VOTES UR DATABASEN OCH VISA UPP...
    $linkID = $link{'linkID'};
    $statement_2 = $pdo->prepare('SELECT score FROM vote WHERE link = :linkID');
    // bind param password
    $statement_2->bindParam(':linkID', $linkID, PDO::PARAM_INT);
    $statement_2->execute();
    $vote = $statement_2->fetch(PDO::FETCH_ASSOC);
    $vote = $vote{'score'};


    if ($vote == NULL) {

      $vote = 0;

      $statementTESTARLITEGRANN = $pdo->prepare('INSERT INTO vote (score, link) VALUES (:vote, :linkID)');
      // bind param LINKID
      $statementTESTARLITEGRANN->bindParam(':linkID', $linkID, PDO::PARAM_INT);
      // bind param SCORE
      $statementTESTARLITEGRANN->bindParam(':vote', $vote, PDO::PARAM_INT);

      $statementTESTARLITEGRANN->execute();
      $vote = $statementTESTARLITEGRANN->fetch(PDO::FETCH_ASSOC);


      // HÄMTA VOTES UR DATABASEN OCH VISA UPP...
      $linkID = $link{'linkID'};
      $statement_2 = $pdo->prepare('SELECT score FROM vote WHERE link = :linkID');
      // bind param password
      $statement_2->bindParam(':linkID', $linkID, PDO::PARAM_INT);
      $statement_2->execute();
      $vote = $statement_2->fetch(PDO::FETCH_ASSOC);
      $vote = $vote{'score'};

    }



    ?>

    <div class="vote-links">
      <form class="up-vote" action="/Cyberlink/app/auth/vote.php" method="post">
        <input type="text" class="hidden" name="linkID" value="<?php echo $linkID; ?>">
        <input type="text" class="hidden" name="up-vote" value="<?php echo $vote+1; ?>">
        <input class="image" name="image" type="image" alt="Vote up" src="/Cyberlink/media/img/up-arrow.svg">
      </form>
      <p class="score"><?php echo $vote;?></p>
      <form class="down-vote" action="/Cyberlink/app/auth/vote.php" method="post">
        <input type="text" class="hidden" name="linkID" value="<?php echo $linkID; ?>">
        <input type="text" class="hidden" name="down-vote" value="<?php echo $vote-1; ?>">
        <input class="image" name="image" type="image" alt="Vote down" src="/Cyberlink/media/img/down-arrow.svg">
      </form>
    </div>
    <div class="right">
      <div class="top"><img class="feed-avatar" src="<?php echo $link{'avatar'}; ?>"></img>
        <div class="title-url"><h4><?php echo $link{'title'}; ?></h4>
        <p><a href="<?php echo $link{'url'}; ?>"><?php echo $link{'url'}; ?></a></p></div>
      </div>
      <div class="description"><p><?php echo $link{'description'}; ?></p></div>
      <div class="email"><p>author: <?php echo $link{'email'}; ?></p></div>
    </div>
  </div>

  </article>

  <?php

}

require __DIR__.'/views/footer.php'; ?>
