<?php

declare(strict_types=1);

$pdo = new PDO('sqlite:../database/database.db');

if (isset($_POST['email'], $_POST['password'])) {
    $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $avatar = "media\img\avatar-temp.png";

    // TODO: Implement the database insert logic here.

    $statement_insert = $pdo->prepare('INSERT INTO user (email, password, avatar) VALUES (:email, :password, :avatar)');

    if (!$statement_insert) {
      die(var_dump($pdo->errorInfo()));
    }

    // bind param email
    $statement_insert->bindParam(':email', $email, PDO::PARAM_STR);
    // bind param password
    $statement_insert->bindParam(':password', $password, PDO::PARAM_STR);
    // bind param avatar
    $statement_insert->bindParam(':avatar', $avatar, PDO::PARAM_STR);
    $statement_insert->execute();

    header('Location: ../../index.php');

}
