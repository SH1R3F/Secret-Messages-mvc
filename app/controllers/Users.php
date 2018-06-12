<?php

class Users extends Controller{

  public function __construct(){
    $this->userModel = $this->model('User');
  }
  public function __call($method, $params){
    $this->default();
  }

  public function default(){
    if(isset($_SESSION['user_id'])){
      redirect('Messages');
    }else{
      $this->login();
    }
  }

  private function ClearInput($string){
    $string = trim($string);
    $string = stripslashes($string);
    $string = htmlspecialchars($string);
    return $string;
  }

  public function Register(){
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      //init the data
      $data = [
        'name' => $this->ClearInput($_POST['name']),
        'name_err' => '',
        'username' => $this->ClearInput($_POST['username']),
        'username_err' => '',
        'email' => $this->ClearInput($_POST['email']),
        'email_err' => '',
        'password' => $this->ClearInput($_POST['password']),
        'password_err' => '',
        'confirm_password' => $this->ClearInput($_POST['confirm_password']),
        'confirm_password_err' => '',
        'gender' => intval($_POST['gender']),
        'country' => $this->ClearInput($_POST['country']),
        'notifications' => isset($_POST['notifications']) ? '1' : '0'
      ];
      //validate Name
      if(empty($data['name'])){
        $data['name_err'] = 'You must enter your name';
      }

      //validate username
      if(empty($data['username'])){
        $data['username_err'] = 'You must enter a username';
      }elseif(!preg_match("/^[A-Za-z0-9]+(?:[ _-][A-Za-z0-9]+)*$/", $data['username'])){
        $data['username_err'] = 'You must enter a valid username';
      }elseif($this->userModel->is_value_exists($data['username'], 'Username')){//check if username exists in db
        $data['username_err'] = 'This username is already taken before, please choose another one.';
      }

      //validate email address
      if(empty($data['email'])){
        $data['email_err'] = 'You must enter an email';
      }elseif(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
        $data['email_err'] = 'Enter a valid email address.';
      }elseif($this->userModel->is_value_exists($data['email'], 'Email')){//check if email exists
        $data['email_err'] = 'This email is already registered.. <a href="' . APP_URL . '/users/login">Try to Login?</a>';
      }

      //validate password
      if(empty($data['password'])){
        $data['password_err'] = 'you must enter a password';
      }elseif(!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/", $data['password'])){
        $data['password_err'] = 'you must enter a strong password <sub>[note that it must be Minimum eight characters, at least one letter and one number]</sub>';
      }

      //validate password confirmation
      if($data['confirm_password'] !== $data['password']){
        $data['confirm_password_err'] = 'Password and Password Confirmation are not identical.';
      }

      if(
        empty($data['name_err']) &&
        empty($data['username_err']) &&
        empty($data['email_err']) &&
        empty($data['password_err']) &&
        empty($data['confirm_password_err'])
      ){
        //validated ==> Successifull registering
        $data['password_hashed'] = password_hash($data['password'], PASSWORD_DEFAULT);
        if($this->userModel->register($data)){
          flash('register_success', "You have been Successifull registered. now you can login", 'alert alert-success');
          redirect('users/login');
        }
      }else{
        //load the view with errors
        flash('register_error', "We couldn't create your account. please fix the mistakes in fields.", 'alert alert-danger');
        $data['title'] = 'Create a new account | ' . SITENAME;
        $this->view('users/register', $data);
      }

    }else{
      $data = [
        'name' => '',
        'name_err' => '',
        'username' => '',
        'username_err' => '',
        'email' => '',
        'email_err' => '',
        'password' => '',
        'password_err' => '',
        'confirm_password' => '',
        'confirm_password_err' => '',
        'gender' => '',
        'country' => '',
        'notifications' => ''
      ];
    }
    //load the view
    $data['title'] = 'Create a new account | ' . SITENAME;
    $this->view('users/register', $data);
  }

  public function login(){
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      //init the data
      $data = [
        'email' => $this->ClearInput($_POST['email']),
        'email_err' => '',
        'password' => $this->ClearInput($_POST['password']),
        'password_err' => ''
      ];
      //validate email address
      if(empty($data['email'])){
        $data['email_err'] = 'You must enter an email';
      }elseif(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
        $data['email_err'] = 'Enter a valid email address.';
      }elseif(!$this->userModel->is_value_exists($data['email'], 'Email')){//check if email exists
        $data['email_err'] = 'No user found with this email.';
      }

      //validate password
      if(empty($data['password'])){
        $data['password_err'] = 'you must enter a password';
      }
      if(
        empty($data['email_err']) &&
        empty($data['password_err'])
      ){
        //validated ==> now check login
        $loggedUser = $this->userModel->login($data['email'], $data['password']);
        if($loggedUser){
          //give session
          $_SESSION['user_id'] = $loggedUser->id;
          $_SESSION['user_name'] = $loggedUser->Name;
          $_SESSION['user_username'] = $loggedUser->Username;
          $_SESSION['user_email'] = $loggedUser->Email;
          $_SESSION['user_photo'] = $loggedUser->photo;
          $_SESSION['user_verified'] = $loggedUser->verified;
          $_SESSION['user_token'] = hash('sha256', uniqid());
          redirect('Messages');
        }else{
          //show error
          $data['password_err'] = 'Password is incorrect';
          $data['title'] = 'Sign in | ' . SITENAME;
          $this->view('users/login', $data);
        }
      }else{
        //load the view with errors
        $data['title'] = 'Sign in | ' . SITENAME;
        $this->view('users/login', $data);
      }
    }else{
      $data = [
        'email' => '',
        'email_err' => '',
        'password' => '',
        'password_err' => ''
      ];
      //load the view
      $data['title'] = 'Sign in | ' . SITENAME;
      $this->view('users/login', $data);
    }
  }

  public function logout(){
    unset($_SESSION['user_id']);
    unset($_SESSION['user_username']);
    unset($_SESSION['user_email']);
    unset($_SESSION['user_name']);
    unset($_SESSION['user_photo']);
    unset($_SESSION['user_verified']);
    unset($_SESSION['user_token']);

    flash('logout_success', 'You have been Successifully logged out', 'alert alert-success');
    redirect('users/login');
  }

  public function restore(){
    $data = [
      'title'     => 'Restore your password | ' . SITENAME,
      'email'     => '',
      'email_err' => '',
    ];
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      $data['email'] = $this->ClearInput($_POST['email']);
      if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
        $data['email_err'] = 'Enter a valid email address.';
      }elseif(!$this->userModel->is_value_exists($data['email'], 'Email')){//check if email exists
        $data['email_err'] = 'No user found with this email.';
      }else{//everything is good
        if($this->userModel->RestorePassword($data['email'])){
          flash('restore_state', 'We\'ve sent you an email to restore your password. check your email!', 'alert alert-success');
        }else{
          flash('restore_state', 'Sorry we couldn\'t sent you the restore link. please try again and if the problem presists contact the adminstrator -> ' . ADMIN_EMAIL, 'alert alert-danger');
        }
        Header('Refresh: 0');
        exit();
      }
    }
    $this->view('users/reset', $data);
  }

  public function reset($token = ''){
    if(!empty($token)){
      $user_id = $this->userModel->dealToken($token); //Deal with the token: -> find the token -> return user id -> burn token
      if($user_id){
        $data = [
          'title' => 'Reset your password | ' . SITENAME,
          'token' => $token,
          'newpass' => '',
          'newpass_err' => '',
          'confpass' => '',
          'confpass_err' => '',
          'valid'        => true
        ];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
          //validate and reset the password and send a flash message
          $data['newpass'] = $_POST['newpass'];
          $data['confpass'] = $_POST['confpass'];
          //validate password
          if(empty($data['newpass'])){
            $data['newpass_err'] = 'you must enter a password';
          }elseif(!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/", $data['newpass'])){
            $data['newpass_err'] = 'you must enter a strong password <sub>[note that it must be Minimum eight characters, at least one letter and one number]</sub>';
          }
          //validate password confirmation
          if(empty($data['confpass'])){
            $data['confpass_err'] = 'This field is required you can\'t leave it alone.';
          }elseif($data['confpass'] !== $data['newpass']){
            $data['confpass_err'] = 'The password confirmation and password aren\'t identical.';
          }

          if(
            empty($data['newpass_err']) &&
            empty($data['confpass_err'])
          ){
            //change the password
            $hash = password_hash($data['newpass'], PASSWORD_DEFAULT);
            if($this->userModel->changeValue('Password', $hash, $user_id)){
              flash('reset_state', 'Your password has been reset successifully. now you can login with the new password.', 'alert alert-success');
            }else{
              flash('reset_state', 'sorry we couldn\'t reset your password. try again and if this problem presists please contact the adminstrator -> ' . ADMIN_EMAIL, '');
            }
            redirect('Users/login');
            exit();
          }
        }
      }else{
        $data = [
          'title' => 'Invalid token | ' . SITENAME,
          'valid' => false
        ];
      }
      $this->view('users/restore', $data);
    }else{
      redirect('Users/restore');
    }
  }

  public function settings(){
    $default_name     = $this->userModel->getValue('Name')->Name;
    $default_username = $this->userModel->getValue('Username')->Username;
    $default_email    = $this->userModel->getValue('Email')->Email;
    $default_notify   = $this->userModel->getValue('notifications')->notifications;
    $default_photo    = $this->userModel->getValue('photo')->photo;
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      //Processing the first form
      if(isset($_POST['personal_change']) && $_POST['token'] === $_SESSION['user_token']){
        $data = array(
          'title'        => 'Change your settings | ' . SITENAME,
          'Name'         => $this->ClearInput($_POST['name']),
          'Name_err'     => '',
          'Username'     =>  $this->ClearInput($_POST['username']),
          'Username_err' => '',
          'Email'        =>  $this->ClearInput($_POST['email']),
          'Email_err'    => '',
          'Photo_err'    => '',
          'Notification' => ($_POST['notification'] == '1') ? '1' : '0',
          'currpassword'     => '',
          'currpassword_err' => '',
          'newpassword'      => '',
          'newpassword_err'  => '',
          'newpasswordC'     => '',
          'newpasswordC_err' => '',
        );
        //validate Name
        if(empty($data['name'])){
          $data['name_err'] = 'You must enter your name';
        }
        //validate username
        if(empty($data['Username'])){
          $data['Username_err'] = 'You must enter a username';
        }elseif(!preg_match("/^[A-Za-z0-9]+(?:[ _-][A-Za-z0-9]+)*$/", $data['Username'])){
          $data['Username_err'] = 'You must enter a valid username';
        }elseif($data['Username'] !== $default_username && $this->userModel->is_value_exists($data['Username'], 'Username')){//check if username exists in db
          $data['Username_err'] = 'This username is already taken before, please choose another one.';
        }

        //validate email address
        if(empty($data['Email'])){
          $data['Email_err'] = 'You must enter an email';
        }elseif(!filter_var($data['Email'], FILTER_VALIDATE_EMAIL)){
          $data['Email_err'] = 'Enter a valid email address.';
        }elseif($data['Email'] !== $default_email && $this->userModel->is_value_exists($data['Email'], 'Email')){//check if email exists
          $data['Email_err'] = 'This email is already registered..';
        }

        if(
        empty($data['Name_err']) &&
        empty($data['Username_err']) &&
        empty($data['Email_err']) &&
        empty($data['Photo_err'])
        ){
          $anyChange = false;
          //submit values [Submit name]
          if($data['Name'] !== $default_name){
            $this->userModel->changeValue('Name', $data['Name']);
            $_SESSION['user_name'] = $data['Name'];
            $anyChange = true;
          }
          //[submit username]
          if($data['Username'] !== $default_username){
            $this->userModel->changeValue('Username', $data['Username']);
            $_SESSION['user_username'] = $data['Username'];
            $anyChange = true;
          }
          //[submit email]
          if($data['Email'] !== $default_email){
            $this->userModel->changeValue('Email', $data['Email']);
            $this->userModel->changeValue('verified', '0');
            $_SESSION['Email'] = $data['Email'];
            $anyChange = true;
          }
          //[submit notifications]
          if($data['Notification'] !== $default_notify){
            $this->userModel->changeValue('notifications', $data['Notification']);
            $anyChange = true;
          }
          // [Submit photo]
          //when submit the photo delete the previous one and update with the new. but in case of default img don't remove the previous
          if(!empty($_FILES["photo"]["tmp_name"]) && getimagesize($_FILES["photo"]["tmp_name"])){
            $uploaded_name = $_FILES[ 'photo' ][ 'name' ];
            $uploaded_ext  = substr( $uploaded_name, strrpos( $uploaded_name, '.' ) + 1);
            $uploaded_size = $_FILES[ 'photo' ][ 'size' ];
            $uploaded_type = $_FILES[ 'photo' ][ 'type' ];
            $uploaded_tmp  = $_FILES[ 'photo' ][ 'tmp_name' ];
            $target_path   = UPLOADS_DIR . '/pics/';
            $target_file   =  md5( uniqid() . $uploaded_name ) . '.' . $uploaded_ext;
            $temp_file     = ( ( ini_get( 'upload_tmp_dir' ) == '' ) ? ( sys_get_temp_dir() ) : ( ini_get( 'upload_tmp_dir' ) ) );
            $temp_file    .= DIRECTORY_SEPARATOR . md5( uniqid() . $uploaded_name ) . '.' . $uploaded_ext;
            if(
                (
                  strtolower( $uploaded_ext ) == 'jpg' ||
                  strtolower( $uploaded_ext ) == 'jpeg' ||
                  strtolower( $uploaded_ext ) == 'png'
                ) &&
                ( $uploaded_size < 10000000 ) &&
                (
                  $uploaded_type == 'image/jpeg' ||
                  $uploaded_type == 'image/jpg' ||
                  $uploaded_type == 'image/png'
                ) &&
                getimagesize( $uploaded_tmp )
              ){
                error_reporting(0);
                try{
                  // re-encoding image (php-Imagick is recommended over php-GD)
                  if($uploaded_type == 'image/jpeg' || $uploaded_type == 'image/jpg') {
                    $img = imagecreatefromjpeg( $uploaded_tmp );
                    imagejpeg( $img, $temp_file, 100);
                  }else{
                    $img = imagecreatefrompng($uploaded_tmp);
                    imagepng($img, $temp_file, 9);
                  }
                  imagedestroy($img);
                  //now let's move it
                  if(rename($temp_file, ($target_path . $target_file))) {
                    // Uploaded
                    //delete the previous one
                    if($default_photo !== 'pics/default.jpg'){
                      unlink(UPLOADS_DIR . '/' . $default_photo);
                      //unlink($default_photo);
                    }
                    //now set it in database
                    $this->userModel->changeValue('photo', 'pics/' . $target_file);
                    $_SESSION['user_photo'] = 'pics/' . $target_file;
                    $anyChange = true;
                  }
                  else {
                    // Couldn't be uploaded
                    $data['Photo_err'] = 'Your image couldn\'t be uploaded. try a different ';
                  }
                  // Delete any temp files
                  if(file_exists($temp_file))
                  unlink( $temp_file );
                }catch(Exception $e){
                  $data['Photo_err'] = 'Your image couldn\'t be uploaded.';
                }

            }else{
              // Invalid file
              $data['Photo_err'] = 'Your image was not uploaded. We can only accept JPEG or PNG images.';
            }
          }
          if($anyChange){
            flash('personal_change_success', 'Your personal informations have been successifully changed', 'alert alert-success');
            Header('Refresh: 0');
            exit();
          }
        }
      }
      //Processing the second form
      elseif(isset($_POST['passwordChanger']) && $_POST['token'] === $_SESSION['user_token']){
        $data = array(
          'title'            => 'Change your settings | ' . SITENAME,
          'Name'             => $default_name,
          'Name_err'         => '',
          'Username'         =>  $default_username,
          'Username_err'     => '',
          'Email'            =>  $default_email,
          'Email_err'        => '',
          'Photo_err'        => '',
          'Notification'     => $default_notify,
          'currpassword'     => '',
          'currpassword_err' => '',
          'newpassword'      => '',
          'newpassword_err'  => '',
          'newpasswordC'     => '',
          'newpasswordC_err' => '',
        );

        $password        = $this->ClearInput($_POST['password']);
        $newpassword     = $this->ClearInput($_POST['newpassword']);
        $confnewpassword = $this->ClearInput($_POST['confnewpassword']);
        $data['currpassword']     = $password;
        $data['newpassword']      = $newpassword;
        $data['newpasswordC']     = $confnewpassword;
        if(!empty($password) && !empty($newpassword) && !empty($confnewpassword)){
          //check if password hash is the same in database
          if($this->userModel->checkPassword($password)){
            //PASSWORD IS CORRECT
            // Validate new password
            if(!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/", $data['newpassword'])){
              $data['newpassword_err'] = 'you must enter a strong password <sub>[note that it must be Minimum eight characters, at least one letter and one number]</sub>';
            }elseif($data['newpassword'] === $data['currpassword']){
              $data['newpassword_err'] = 'your new password is the same as the old one.';
            }

            //validate password confirmation
            if($data['newpasswordC'] !== $data['newpassword']){
              $data['newpasswordC_err'] = 'Password and Password Confirmation are not identical.';
            }

            if(
              empty($data['currpassword_err']) &&
              empty($data['newpassword_err']) &&
              empty($data['newpasswordC_err'])
            ){
              // You are good! now change the password in database
              $hash = password_hash($data['newpasswordC'], PASSWORD_DEFAULT);
              if($this->userModel->changeValue('Password', $hash)){
                flash('password_change_success', 'Your password has been successifully changed', 'alert alert-success');
                Header('Refresh: 0');
                exit();
              }
            }
          }else{
            //validate password
            // $data['password_err'] = 'you must enter a password';
            $data['currpassword_err'] = 'it seems like you mistyped your password. please rewrite your correct current password.';
          }
        }
      }
    }else{//If Get Request
      $data = array(
        'title'        => 'Change your settings | ' . SITENAME,
        'Name'         => $default_name,
        'Name_err'     => '',
        'Username'     =>  $default_username,
        'Username_err' => '',
        'Email'        =>  $default_email,
        'Email_err'    => '',
        'Photo_err'    => '',
        'Notification' => $default_notify,
        'currpassword'     => '',
        'currpassword_err' => '',
        'newpassword'      => '',
        'newpassword_err'  => '',
        'newpasswordC'     => '',
        'newpasswordC_err' => '',
      );
    }
    $this->view('users/settings', $data);
  }

  private function isLoggedIn(){
    if(isset($_SESSION['user_id'])){
      return true;
    }
    return false;
  }

  public function send(){//send messages function
    $username = explode('/', filter_var(trim($_GET['url'], '/'), FILTER_SANITIZE_URL))[0];
    $userData = $this->userModel->getUserData($username);

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      $data = array(
        'title' => 'Send a messages',
        'user_data' => $userData,
        'Inputs' => array(
          'message' => $this->ClearInput($_POST['message']),
          'message_err' => ''
        )
      );
      if(empty($data['Inputs']['message'])){
        $data['Inputs']['message_err'] = 'You must enter a message';
      }
      if(empty($data['Inputs']['message_err'])){
        //send the message
        $message = $this->ClearInput($_POST['message']);
        $message = implode("\n", array_filter(explode("\r\n", preg_replace('/\s+/', ' ', $message))));
        $this->userModel->sendMessage($userData->id, $message);
        flash('message_send', 'Your Message has been sent Successifully', 'alert alert-success');
        header('Refresh: 0');
        exit();
      }

    }else{//if GET request for example
      $data = array(
        'title' => 'Send a messages',
        'user_data' => $userData,
        'Inputs' => array(
          'message' => '',
          'message_err' => ''
        )
      );
    }

    $this->view('messages/send', $data);
  }

  public function verify(){
    $data = [
      'title' => 'Verify your email address',
      'sent'  => true
    ];
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      //send the verification link
      if($this->userModel->sendVerify()){
        $data['sent'] = false;
      }
    }
    $this->view('users/verify', $data);
  }

  public function verification($token = ''){
    if(!empty($token)){
      $data = [
        'title'   => 'Email Verification | ' . SITENAME,
        'status'  => true,
        'state'   => 'Account Verified',
        'comment' => 'Your account is now verified. you can use it with no more constraints.'
      ];
      if(!$this->userModel->verifyEmail($token)){
        $data['status']  = false;
        $data['state']   = 'Account is not verified';
        $data['comment'] = 'We couldn\'t verify your account due to some errors. try again with a new token and if the problem presists contact the adminstrator -> ' . ADMIN_EMAIL;
      }
      $this->view('users/verification', $data);
    }else{
      redirect('Users/verify');
    }
  }

}
