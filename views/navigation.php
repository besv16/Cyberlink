<?php

declare(strict_types=1);

$authenticated = $_SESSION['authenticated'] ?? false;

?>
<nav class="header">
  <h1 class="heading-slogan">Cyberlink</h1>
  <?php if ($authenticated): ?>
  <div class="navigation">
    <li><a href="/Cyberlink/feed.php"><img class="nav-icon" src="/Cyberlink/media/img/feed.svg"></img></a></li>
    <li><a href="/Cyberlink/admin.php"><img class="nav-icon" src="/Cyberlink/media/img/admin.svg"></img></a></li>
    <li><a href="/Cyberlink/app/auth/logout.php"><img class="nav-icon" src="/Cyberlink/media/img/exit.svg"></img></a></li>
  </div>
  <?php endif; ?>
</nav>
