<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title><?= isset($page_title) ? htmlspecialchars($page_title) . ' | Sinergy' : 'Sinergy | Philippines-Based Outsourcing Teams for Global Businesses' ?></title>

  <meta
    name="description"
    content="Sinergy helps businesses outside the Philippines scale customer support, technical support, sales support, data services, and AI annotation through reliable offshore teams and accountable workflows."
  />

  <meta name="keywords" content="outsourcing Philippines, customer support outsourcing, technical support outsourcing, data annotation, data entry, sales support, offshore teams" />

  <link rel="icon" type="image/png" href="img/favicon.png" />

  <link rel="stylesheet" href="styles.css" />
</head>

<body<?= isset($page_class) ? ' class="' . htmlspecialchars($page_class) . '"' : '' ?>>

  <header class="site-header">
    <div class="container nav-wrap">
      <a href="index.php" class="logo" aria-label="Sinergy Home">
        <img src="img/sinergy-logo.png" alt="Sinergy logo" class="site-logo-img" />
      </a>

      <?php include 'nav.php'; ?>

      <div class="nav-actions">
        <a href="contact.php" class="btn btn-primary">Get a Quote</a>

        <button class="mobile-toggle" id="mobileToggle" aria-label="Open mobile menu" aria-expanded="false">
          <span></span>
          <span></span>
          <span></span>
        </button>
      </div>
    </div>
  </header>
