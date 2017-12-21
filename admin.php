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
    echo "Du måste fylla i en email-adress";
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
    echo "Du måste fylla i ett lösenord";
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
    echo "Du måste fylla i en biotext";
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



 ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
      <p><?php echo 'Your user ID is: ' . $userID; ?></p>
      <?php if ($authenticated): ?>
        <a href="index.php">Index</a>
        <a href="app/auth/logout.php">Logga ut</a>
      <?php else: ?>
        <a href="index.php">Logga in</a>
      <?php endif; ?>
        <h1>Ändra profil</h1>
        <form action="admin.php" method="post">
          <label for="email">Email</label>
          <input type="email" name="email">
          <br />
          <label for="password">Lösenord</label>
          <input type="password" name="password">
          <br />
          <label for="bio">Biografi</label>
          <input type="text" name="bio">
          <br />
          <button type="submit">Spara</button>
        </form>
        <form action="admin.php" method="post" enctype="multipart/form-data">
          <label for="avatar">Choose a PNG image to upload</label>
          <input type="file" name="avatar" accept=".png" required>
          <button type="submit">Upload</button>
        </form>
        <img src="<?php echo $image['avatar']; ?>"></img>
    </body>
</html>
