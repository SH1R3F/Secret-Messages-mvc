<?php require_once APP_PATH . '/views/inc/header.php'; ?>
<section class="settings" id="settings">
  <div class="container">
    <div class="row">
      <div class="col-sm-10 col-sm-offset-1" id="content-area">
        <!-- Personal Information modification section -->
        <div class="setting" id="personal_informations">
          <h3 class="page-header bold">Edit personal information</h3>
          <?php echo flash('personal_change_success'); ?>
          <form class="form-horizontal" role="form" method="post" action="<?php echo APP_URL; ?>/Users/settings" enctype="multipart/form-data">
            <div class="form-group row">
              <label for="name" class="col-sm-2 control-label">Name</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="<?php echo $data['Name']; ?>" required>
                <a class='text text-danger'><?php echo $data['Name_err']; ?></a>
              </div>
            </div>
            <div class="form-group row">
              <label for="username" class="col-sm-2 control-label">Username</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?php echo $data['Username']; ?>" required>
                <a class='text text-danger'><?php echo $data['Username_err']; ?></a>
              </div>
            </div>
            <div class="form-group row">
              <label for="email" class="col-sm-2 control-label">Email</label>
              <div class="col-sm-10">
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $data['Email']; ?>" required>
                <a class='text text-danger'><?php echo $data['Email_err']; ?></a>
              </div>
            </div>
            <div class="form-group">
              <label for="photo" class="col-sm-2 control-label">Photo</label>
              <div class="col-sm-10">
                <input type="file" class="form-control" id="photo" name="photo">
                <a class='text text-danger'><?php echo $data['Photo_err']; ?></a>
              </div>
            </div>
            <div class="col-sm-2 control-label">
              <label>Notification</label>
            </div>
            <div class="col-sm-10">
              <select name="notification" class='form-control'>
                <option value='1' <?php echo ($data['Notification'] == '1') ? 'selected' : '' ; ?>>On</option>
                <option value='0' <?php echo ($data['Notification'] == '0') ? 'selected' : '' ; ?>>Off</option>
              </select>
            </div>
            <input type='hidden' name='token' value='<?php echo $_SESSION['user_token']; ?>' />
            <input type="submit" class="submit-btn btn btn-default col-sm-offset-2" name="personal_change" value="Save Changes">
          </form>
        </div><!-- Personal Information modification section -->

        <!-- Changing Password Section -->
        <div class="setting" id="change_password">
          <h3 class="page-header bold">Change password</h3>
          <?php echo flash('password_change_success'); ?>
          <form class="form-horizontal" role="form" method="post" action="<?php echo APP_URL; ?>/Users/settings">
            <div class="form-group row">
              <label for="password" class="col-sm-2 control-label">Current Password</label>
              <div class="col-sm-10">
                <input type="password" class="form-control" id="password" name="password" placeholder="Current Password" value="<?php echo $data['currpassword']; ?>">
                <a class='text text-danger'><?php echo $data['currpassword_err']; ?></a>
              </div>
            </div>

            <div class="form-group row">
              <label for="newpassword" class="col-sm-2 control-label">New Password</label>
              <div class="col-sm-10">
                <input type="password" class="form-control" id="newpassword" name="newpassword" placeholder="New Password" value="<?php echo $data['newpassword']; ?>">
                <a class='text text-danger'><?php echo $data['newpassword_err']; ?></a>
              </div>
            </div>
            <div class="form-group row">
              <label for="confnewpassword" class="col-sm-2 control-label">Confirm New Password</label>
              <div class="col-sm-10">
                <input type="password" class="form-control" id="confnewpassword" name="confnewpassword" placeholder="Confirm New Password" value="<?php echo $data['newpasswordC']; ?>">
                <a class='text text-danger'><?php echo $data['newpasswordC_err']; ?></a>
              </div>
            </div>
            <input type='hidden' name='token' value='<?php echo $_SESSION['user_token']; ?>' />
            <button type="submit" class="submit-btn btn btn-default col-sm-offset-2" name="passwordChanger">Change</button>
          </form>
        </div><!-- Changing Password Section -->


      </div>
    </div>
  </div>
</div>
<?php require_once APP_PATH . '/views/inc/footer.php'; ?>
