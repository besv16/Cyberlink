<?php

$authenticated = $_SESSION['authenticated'] ?? false;

?>
<nav class="header">
  <?php if ($authenticated): ?>
  <li><a href="/Cyberlink/feed.php"><img class="nav-icon" src="/Cyberlink/media/img/feed.svg"></img>FEED</a></li>
  <li><a href="/Cyberlink/admin.php"><img class="nav-icon" src="/Cyberlink/media/img/admin.svg"></img>ADMIN</a></li>
  <li><a href="/Cyberlink/app/auth/logout.php"><img class="nav-icon" src="/Cyberlink/media/img/exit.svg"></img>LOG OUT</a></li>
  <?php endif; ?>
</nav>
