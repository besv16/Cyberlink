<?php

$authenticated = $_SESSION['authenticated'] ?? false;

?>
<nav class="header">
  <?php if ($authenticated): ?>
  <li><a href="/Cyberlink/feed.php">FEED</a></li>
  <li><a href="/Cyberlink/admin.php">ADMIN</a></li>
  <li><a href="/Cyberlink/app/auth/logout.php">LOG OUT</a></li>
  <?php endif; ?>
</nav>
