<?php

declare(strict_types=1);

// startar session
session_start();

// sätter en sessionsvariabel vid namn userID som har värdet av den inloggades ID-nummer
$userID = $_SESSION['userID'];
// kopplar upp mot databasen
// $pdo = new PDO('sqlite:app/database/database.db');

$authenticated = $_SESSION['authenticated'] ?? false;

require __DIR__.'/views/header.php';
require __DIR__.'/views/navigation.php';
require __DIR__.'/app/auth/edit-acc.php';

?>

<div class="account">
  <img class="profile-avatar" src="<?php echo $image['avatar']; ?>"></img>
  <div class="meta">
    <form class="edit-acc" action="edit-acc.php" method="post">
      <input type="email" name="email" value="<?php echo $testing['email']; ?>">
      <input type="text" name="password" placeholder="Nytt lösenord">
      <button type="submit">Save</button>
    </form>
  </div>
</div>
<form class="upload-avatar" action="edit-acc.php" method="post" enctype="multipart/form-data">
  <input type="file" name="avatar" accept=".png" required>
  <button type="submit">Upload</button>
</form>
<div class="bio">
  <form class="edit-bio" action="edit-acc.php" method="post">
    <textarea name="bio"><?php echo $testing['bio']; ?></textarea>
    <button type="submit">Save</button>
  </form>
</div>

<?php require __DIR__.'/views/footer.php'; ?>
