<?php

declare(strict_types=1);

require __DIR__.'/views/header.php';
require __DIR__.'/views/navigation.php';

?>

<div class="landing-page">
  <div class="img-demo">
    <img src="/Cyberlink/media/img/demo.png"></img>
  </div>
  <div class="login-signup">
    <h1>Sign up</h1>
    <form action="/Cyberlink/app/auth/register.php" method="post">
      <input type="text" name="email" placeholder="Email">
      <input type="password" name="password" placeholder="Password">
      <button type="submit">Join our community!</button>
    </form>
  </div>
</div>

<?php require __DIR__.'/views/footer.php'; ?>
