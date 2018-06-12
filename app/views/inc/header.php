<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge"  />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name='siteurl' content="<?php echo APP_URL; ?>" />
    <noscript>
      <?php if($_GET['url'] !== 'Home/nojs'): ?>
        <meta http-equiv="refresh" content="0;url=<?php echo APP_URL; ?>/Home/nojs" />
      <?php endif; ?>
    </noscript>
    <title>
      <?php
      echo isset($data['title']) ? $data['title'] : SITENAME ;
      ?>
    </title>
    <link href="https://fonts.googleapis.com/css?family=Abel|Cairo|Exo+2" rel="stylesheet">
    <link rel='stylesheet' href='<?php echo APP_URL; ?>/css/bootstrap.min.css' />
    <link rel='stylesheet' href='<?php echo APP_URL; ?>/css/font-awesome.min.css' />
    <link rel='stylesheet' href='<?php echo APP_URL; ?>/css/style.css' />
    <script src="<?php echo APP_URL; ?>/js/jquery.js"></script>
    <script src="<?php echo APP_URL; ?>/js/bootstrap.min.js"></script>
  </head>
  <body>
    <?php require_once APP_PATH . '/views/inc/navbar.php'; ?>
