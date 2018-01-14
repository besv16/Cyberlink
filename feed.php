<?php

declare(strict_types=1);

session_start();

$userID = $_SESSION['userID'];
$authenticated = $_SESSION['authenticated'] ?? false;

require __DIR__.'/app/users/store.php';
require __DIR__.'/app/links/store.php';
require __DIR__.'/views/header.php';
require __DIR__.'/views/navigation.php';

?>

<div class="share-container">
  <img class="profile-avatar" src="<?php echo $image['avatar']; ?>"></img>
  <form action="app/links/store.php" method="post">
    <input type="text" name="title" placeholder="Title">
    <input type="text" name="url" placeholder="URL">
    <input type="text" name="description" placeholder="Description">
    <input type="hidden" name="score" value="0">
    <button type="submit">Share!</button>
  </form>
</div>

<?php

foreach ($links as $link) {

  ?>

  <article class="post">
    <div class="meta-wrapper">

    <?php

    // HÄMTA VOTES UR DATABASEN OCH VISA UPP...
    $linkID = $link{'linkID'};

    require __DIR__.'/app/votes/store.php';

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
