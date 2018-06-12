<?php require_once APP_PATH . '/views/inc/header.php';
?>
<div class='container'>
  <div class='col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2' style='margin-top: 50px;'>
    <form action="<?php echo APP_URL . '/users/register'; ?>" method="POST">
      <?php echo flash('register_error'); ?>
      <div class="form-group row">
        <label for="NameInput" class="col-sm-2 col-form-label">Name</label>
        <div class="col-sm-10">
          <input type="text" name="name" class="form-control" id="NameInput" placeholder="Type your name" value="<?php echo $data['name'];?>" />
          <span class='text text-danger'><?php echo $data['name_err']; ?></span>
        </div>
      </div>

      <div class="form-group row">
        <label for="UsernameInput" class="col-sm-2 col-form-label">Username</label>
        <div class="col-sm-10">
          <input type="text" name="username" class="form-control" id="UsernameInput" placeholder="Choose a username" value="<?php echo $data['username'];?>" />
          <span class='text text-danger'><?php echo $data['username_err']; ?></span>
        </div>
      </div>

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
        </div>
      </div>

      <div class="form-group row">
        <label for="Password1Input" class="col-sm-2 col-form-label">Confirm password</label>
        <div class="col-sm-10">
          <input type="password" name="confirm_password" class="form-control" id="Password1Input" placeholder="Confirm your password" value="<?php echo $data['confirm_password'];?>" />
          <span class='text text-danger'><?php echo $data['confirm_password_err']; ?></span>
        </div>
      </div>

      <div class="form-group row">
        <label for="GenderInput" class="col-sm-2 col-form-label">Gender</label>
        <div class="col-sm-10">
          <select class='form-control' name="gender" id="GenderInput">
            <option value="1">Male</option>
            <option value="2">Female</option>
          </select>
        </div>
      </div>

      <div class="form-group row">
        <label for="CountryInput" class="col-sm-2 col-form-label">Country</label>
        <div class="col-sm-10">
          <select class='form-control' name="country" id="CountryInput">
            <option value="EG">Egypt</option>
            <option value="RU">Russia</option>
          </select>
        </div>
      </div>

      <div class="form-group row">
        <div class="col-sm-10 col-sm-offset-2">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="notifications" id="CheckInput">
            <label class="form-check-label" for="CheckInput">
              Notifications
            </label>
          </div>
        </div>
      </div>

      <div class="form-group row">
        <button type="submit" class="btn">Sign up</button>
        <a href="<?php echo APP_URL . '/users/login'; ?>" style="color: #000; text-decoration: none; margin-left: 20px;">Have an account? Login</a>
      </div>

    </form>
  </div>
</div>
<?php require_once APP_PATH . '/views/inc/footer.php'; ?>
