<?php require_once APP_PATH . '/views/inc/header.php'; ?>
<div class='container'>
  <div class='col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2' style='margin-top: 50px;'>
    <?php if($data['valid']): ?>
      <form action="<?php echo APP_URL . '/users/reset/' . $data['token']; ?>" method="POST">
        <div class="form-group row">
          <label for="NewPass" class="col-sm-2 col-form-label">New Password</label>
          <div class="col-sm-10">
            <input type="password" name="newpass" class="form-control" id="NewPass" placeholder="Choose a strong password." value="<?php echo $data['newpass']; ?>" />
            <a class='text text-danger'><?php echo $data['newpass_err']; ?></a>
          </div>
        </div>
        <div class="form-group row">
          <label for="ConfPass" class="col-sm-2 col-form-label">Confirm Password</label>
          <div class="col-sm-10">
            <input type="password" name="confpass" class="form-control" id="ConfPass" placeholder="Confirm your password." value="<?php echo $data['confpass']; ?>" />
            <a class='text text-danger'><?php echo $data['confpass_err']; ?></a>
          </div>
        </div>
        <div class="form-group row">
          <div style="margin-left: calc(16.6666667% + 15px);">
            <button type="submit" class="btn">Change Password</button>
          </div>
        </div>
      </form>
    <?php else: ?>
      <div class='alert alert-danger'>
        <p>
          <?php echo 'It seems that the link you have followed may be broken or invalid. request a new link and if the problem presists contact the adminstrator at -> <code>' . ADMIN_EMAIL . '</code>'; ?>
        </p>
      </div>
    <?php endif; ?>
  </div>
</div>
<?php require_once APP_PATH . '/views/inc/footer.php'; ?>
