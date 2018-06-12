<?php require_once APP_PATH . '/views/inc/header.php'; ?>
<div class='container'>
  <div class='col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2' style='margin-top: 50px;'>
    <form action="<?php echo APP_URL . '/users/login'; ?>" method="POST">
      <?php echo flash('register_success'); ?>
      <?php echo flash('logout_success'); ?>
      <?php echo flash('reset_state'); ?>
      <div class="form-group row">
        <label for="EmailInput" class="col-sm-2 col-form-label">Email</label>
        <div class="col-sm-10">
          <input type="email" name="email" class="form-control" id="EmailInput" placeholder="Type your email" value="<?php echo $data['email'];?>" />
          <span class='text text-danger'><?php echo $data['email_err']; ?></span>
        </div>
      </div>

      <div class="form-group row">
        <label for="PasswordInput" class="col-sm-2 col-form-label">Password</label>
        <div class="col-sm-10">
          <input type="password" name="password" class="form-control" id="PasswordInput" placeholder="choose a password" value="<?php echo $data['password'];?>" />
          <span class='text text-danger'><?php echo $data['password_err']; ?></span>
          <a class='text text-primary' href='<?php echo APP_URL; ?>/Users/restore' target="_blank" >Forgot your password?</a>
        </div>
      </div>

      <div class="form-group row">
        <div style="margin-left: calc(16.6666667% + 15px);">
          <button type="submit" class="btn">Sign in</button>
        </div>
      </div>

    </form>
  </div>
</div>
<?php require_once APP_PATH . '/views/inc/footer.php'; ?>
