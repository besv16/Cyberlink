<?php

$authenticated = $_SESSION['authenticated'] ?? false;

?>
<nav class="header">
  <h1>Cyberlink</h1>
  <?php if ($authenticated): ?>
  <li><a href="/Cyberlink/feed.php"><img class="nav-icon" src="/Cyberlink/media/img/feed.svg"></img></a></li>
  <li><a href="/Cyberlink/admin.php"><img class="nav-icon" src="/Cyberlink/media/img/admin.svg"></img></a></li>
  <li><a href="/Cyberlink/app/auth/logout.php"><img class="nav-icon" src="/Cyberlink/media/img/exit.svg"></img></a></li>
  <?php endif; ?>
</nav>
