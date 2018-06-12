<?php require_once APP_PATH . '/views/inc/header.php'; ?>
<div class='container'>
  <div style='background: #FFF; border: 1px solid #CCC; padding: 0 50px 30px;' class='col-sm-10 col-sm-offset-1'>
    <h1 class='text-center page-header'><?php echo $data['state']; ?></h1>
    <form action='<?php echo APP_URL; ?>/Users/verify' method='POST'>
      <div class='row'>
        <?php if($data['status']): ?>
          <p class='lead alert alert-success'>
            <?php echo $data['comment']; ?>
          </p>
        <?php else: ?>
          <p class='lead alert alert-danger'>
            <?php echo $data['comment']; ?>
          </p>
        <?php endif; ?>
      </div>
    </form>
  </div>
</div>
<?php require_once APP_PATH . '/views/inc/footer.php'; ?>
