<?php
$current = basename($_SERVER['PHP_SELF']);

$nav_links = [
  'index.php'       => 'Home',
  'services.php'    => 'Services',
  'industries.php'  => 'Industries',
  'how-it-works.php'=> 'How It Works',
  'why-sinergy.php' => 'Why Sinergy',
  'about.php'       => 'About',
  'careers.php'     => 'Careers',
];
?>

<nav class="nav" id="mainNav" aria-label="Main navigation">
  <?php foreach ($nav_links as $file => $label): ?>
    <a href="<?= $file ?>"<?= $current === $file ? ' class="active"' : '' ?>><?= $label ?></a>
  <?php endforeach; ?>
</nav>
