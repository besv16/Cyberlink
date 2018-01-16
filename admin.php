<?php

declare(strict_types=1);

// startar session
session_start();

// sätter en sessionsvariabel vid namn userID som har värdet av den inloggades ID-nummer
$userID = $_SESSION['userID'];
$authenticated = $_SESSION['authenticated'] ?? false;

require __DIR__.'/app/users/store.php';
require __DIR__.'/views/header.php';
require __DIR__.'/views/navigation.php';

?>

<a class="edit-a" href="edit-acc.php">
  <img class="edit" src="/media/img/edit.svg"></img>
</a>
<div class="account">
  <img class="profile-avatar" src="<?php echo $image['avatar']; ?>"></img>
  <div class="meta">
    <p><?php echo $user['email']; ?></p>
  </div>
</div>
<div class="bio">
  <p><?php echo $user['bio']; ?></p>
</div>
<a class="edit-a" href="edit-links.php">
  <img class="edit" src="/media/img/edit.svg"></img>
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
