<?php

declare(strict_types=1);

// startar session
session_start();

// sätter en sessionsvariabel vid namn userID som har värdet av den inloggades ID-nummer
$userID = $_SESSION['userID'];

// kopplar upp mot databasen
$pdo = new PDO('sqlite:app/database/database.db');

$authenticated = $_SESSION['authenticated'] ?? false;

if (isset($_POST['email'])) {
  if (empty($_POST['email'])) {
  }
  else {
    $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
    // TODO: Implement the database insert logic here.
    $statement_insert = $pdo->prepare('UPDATE user SET email = :email WHERE userID = :userID');
    if (!$statement_insert) {
      die(var_dump($pdo->errorInfo()));
    }
    // bind param email
    $statement_insert->bindParam(':email', $email, PDO::PARAM_STR);
    // bind param userID
    $statement_insert->bindParam(':userID', $userID, PDO::PARAM_INT);

    $statement_insert->execute();
    $user = $statement_insert->fetch(PDO::FETCH_ASSOC);
  }
}

if (isset($_POST['password'])) {
  if (empty($_POST['password'])) {
  }
  else {
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    // TODO: Implement the database insert logic here.
    $statement_insert = $pdo->prepare('UPDATE user SET password = :password WHERE userID = :userID');
    if (!$statement_insert) {
      die(var_dump($pdo->errorInfo()));
    }
    // bind param password
    $statement_insert->bindParam(':password', $password, PDO::PARAM_STR);
    // bind param userID
    $statement_insert->bindParam(':userID', $userID, PDO::PARAM_INT);

    $statement_insert->execute();
    $user = $statement_insert->fetch(PDO::FETCH_ASSOC);
    }
  }

if (isset($_POST['bio'])) {
  if (empty($_POST['bio'])) {
  }
  else {
    $bio = filter_var($_POST['bio'], FILTER_SANITIZE_STRING);
    // TODO: Implement the database insert logic here.
    $statement_insert = $pdo->prepare('UPDATE user SET bio = :bio WHERE userID = :userID');
    if (!$statement_insert) {
      die(var_dump($pdo->errorInfo()));
    }
    // bind param bio
    $statement_insert->bindParam(':bio', $bio, PDO::PARAM_STR);
    // bind param userID
    $statement_insert->bindParam(':userID', $userID, PDO::PARAM_INT);

    $statement_insert->execute();
    $user = $statement_insert->fetch(PDO::FETCH_ASSOC);
  }
}

// BILDUPPLADDNINGEN

if (isset($_FILES['avatar'])) {

  $avatar = $_FILES['avatar'];
  $avatar2 = 'media\img\\'.$avatar['name'];
  $destination = sprintf('%s\%s', __DIR__.'\media\img', $avatar['name']);
  move_uploaded_file($avatar['tmp_name'], $destination);


  // TODO: Implement the database update (inserting img url) logic here.

  $statement_insert_avatar = $pdo->prepare('UPDATE user SET avatar = :avatar WHERE userID = :userID');

  if (!$statement_insert_avatar) {
    die(var_dump($pdo->errorInfo()));
  }

  // bind param email
  $statement_insert_avatar->bindParam(':avatar', $avatar2, PDO::PARAM_STR);// bind param userID
  $statement_insert_avatar->bindParam(':userID', $userID, PDO::PARAM_INT);
  $statement_insert_avatar->execute();
  $avatar3 = $statement_insert_avatar->fetch(PDO::FETCH_ASSOC);
}

// HÄMTA BILDEN UR DATABASEN OCH VISA UPP...

$statement = $pdo->prepare('SELECT avatar FROM user WHERE userID = :userID');
$statement->bindParam(':userID', $userID, PDO::PARAM_STR);
$statement->execute();
$image = $statement->fetch(PDO::FETCH_ASSOC);

// HÄMTA LÄNK/AR UR DATABASEN OCH VISA UPP...
$pdo = new PDO('sqlite:app/database/database.db');
$statement = $pdo->prepare('SELECT * FROM link WHERE user = :userID');
$statement->bindParam(':userID', $userID, PDO::PARAM_STR);
$statement->execute();
$links = $statement->fetchAll(PDO::FETCH_ASSOC);

$pdo = new PDO('sqlite:app/database/database.db');

// HÄMTA BILDEN UR DATABASEN OCH VISA UPP...
$statement = $pdo->prepare('SELECT avatar FROM user WHERE userID = :userID');
$statement->bindParam(':userID', $userID, PDO::PARAM_STR);
$statement->execute();

$image = $statement->fetch(PDO::FETCH_ASSOC);

// HÄMTA ALL USER INFO UR DATABASEN OCH VISA UPP...
$statement = $pdo->prepare('SELECT * FROM user WHERE userID = :userID');
$statement->bindParam(':userID', $userID, PDO::PARAM_STR);
$statement->execute();

$testing = $statement->fetch(PDO::FETCH_ASSOC);

?>

<?php require __DIR__.'/views/header.php'; ?>
<?php require __DIR__.'/views/navigation.php'; ?>

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
<form class="upload-avatar" action="admin.php" method="post" enctype="multipart/form-data">
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
