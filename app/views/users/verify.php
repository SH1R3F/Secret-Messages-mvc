<?php require_once APP_PATH . '/views/inc/header.php'; ?>
<div class='container'>
  <div style='background: #FFF; border: 1px solid #CCC; padding: 0 50px 30px;' class='col-sm-10 col-sm-offset-1'>
    <h1 class='text-center page-header'>verify your email</h1>
    <form action='<?php echo APP_URL; ?>/Users/verify' method='POST'>
      <div class='row'>
        <?php if($data['sent']): ?>
          <a href='<?php echo APP_URL; ?>/Users/settings'><button class='btn btn-danger col-xs-12 col-sm-5' style='margin-bottom: 10px;'>No, change my email address.</button></a>
          <button type='submit' class='btn btn-success col-xs-12 col-sm-5 col-sm-offset-2'>yes, send me verification email.</button>
        <?php else: ?>
          <p class='lead alert alert-success'>
            We have sent you a verification link to your email. check it out!
          </p>
        <?php endif; ?>
      </div>
    </form>
  </div>
</div>
<?php require_once APP_PATH . '/views/inc/footer.php'; ?>
