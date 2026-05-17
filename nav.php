<?php
$current = str_replace('.php', '', basename($_SERVER['PHP_SELF']));

$nav_links = [
    'index'        => ['url' => '/',            'label' => 'Home'],
    'services'     => ['url' => 'services',     'label' => 'Services'],
    'industries'   => ['url' => 'industries',   'label' => 'Industries'],
    'how-it-works' => ['url' => 'how-it-works', 'label' => 'How It Works'],
    'why-sinergy'  => ['url' => 'why-sinergy',  'label' => 'Why Sinergy'],
    'about'        => ['url' => 'about',        'label' => 'About'],
    'careers'      => ['url' => 'careers',      'label' => 'Careers'],
];
?>
<nav class="nav" id="mainNav" aria-label="Main navigation">
  <?php foreach ($nav_links as $key => $item): ?>
    <a href="<?= $item['url'] ?>"<?= $current === $key ? ' class="active"' : '' ?>><?= $item['label'] ?></a>
  <?php endforeach; ?>
</nav>
