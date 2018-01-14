<?php

declare(strict_types=1);

// startar session
session_start();

// sätter en sessionsvariabel vid namn userID som har värdet av den inloggades ID-nummer
$userID = $_SESSION['userID'];


$authenticated = $_SESSION['authenticated'] ?? false;

require __DIR__.'/views/header.php';
require __DIR__.'/app/auth/edit-links.php';
require __DIR__.'/views/navigation.php';

foreach ($links as $link) {
  $linkID = $link['linkID'];
  ?>
  <div class="post">
    <div class="delete-links">
      <form class="delete-links" action="app/auth/edit-links.php" method="post">
        <input type="text" name="ID-delete" class="hidden" value="<?php echo $linkID; ?>">
        <input class="image" name="image" type="image" alt="Delete" src="/Cyberlink/media/img/delete.svg">
      </form>
    </div>
    <form class="edit-links" action="app/auth/edit-links.php" method="post">
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
