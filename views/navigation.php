<?php

declare(strict_types=1);

$authenticated = $_SESSION['authenticated'] ?? false;

?>
<nav class="header">
  <h1 class="heading-slogan">Cyberlink</h1>
  <?php if ($authenticated): ?>
  <div class="navigation">
    <li><a href="/feed.php"><img class="nav-icon" src="/media/img/feed.svg"></img></a></li>
    <li><a href="/admin.php"><img class="nav-icon" src="/media/img/admin.svg"></img></a></li>
    <li><a href="/app/auth/logout.php"><img class="nav-icon" src="/media/img/exit.svg"></img></a></li>
  </div>
  <?php endif; ?>
</nav>
