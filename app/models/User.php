<?php

class User extends Model{

  public function is_value_exists($value, $field){
    $sql = "SELECT * FROM users WHERE {$field} = ?";
    $query = $this->_db->query($sql, [$value]);
    if(!$query->error()){
      return $query->count();
    }
  }

  public function mailer(){
    //Load Composer's autoloader
    require_once APP_PATH . '/helpers/phpmailer/autoload.php';
    return $mail = new PHPMailer\PHPMailer\PHPMailer(true);                              // Passing `true` enables exceptions
  }

  public function register($data){
    if(!$this->_db->query('INSERT INTO users (
      Name, Username, Email, Password, Creation_data, Gender, Country, notifications, photo
    ) VALUES(
      ?, ?, ?, ?, ?, ?, ?, ?, ?
    )', array(
      $data['name'], $data['username'], $data['email'], $data['password_hashed'], date('Y-m-d H:i:s'), $data['gender'], $data['country'], $data['notifications'], 'pics/default.jpg'
    ))->error()){
      return true;
    }
    return false;
  }

  public function login($email, $password){
    $sql = "SELECT * FROM users WHERE Email = ?";
    $query = $this->_db->query($sql, [$email]);
    if(!$query->error()){
      $record = $query->first();
      //check the password
      if(password_verify($password, $record->Password)){
        return $record;
      }
    }
    return false;
  }

  public function getUserData($username){
    $sql = "SELECT * FROM users WHERE username = ?";
    $query = $this->_db->query($sql, [$username]);
    if(!$query->error()){
      return $query->first();
    }
    return false;
  }

  public function sendMessage($user_id, $message){
    $curr_date = Date('Y-m-d H:i:s');
    $sql = "INSERT INTO messages ( Receiver_id, Message, Sending_time ) VALUES ( ?, ?, ? )";
    $query = $this->_db->query($sql, [$user_id, $message, $curr_date]);
    if(!$query->error()){
      return true;
    }
    return false;
  }

  public function getValue($field){
    $sql = "SELECT {$field} FROM users WHERE id = ?";
    $query = $this->_db->query($sql, [$_SESSION['user_id']]);
    if(!$query->error()){
      return $query->first();
    }
  }

  public function changeValue($field, $value, $id = ''){
    $sql = "UPDATE users SET {$field} = ? WHERE id = ?";
    if(isset($_SESSION['user_id'])){
      $id = $_SESSION['user_id'];
    }
    $query = $this->_db->query($sql, [$value, $id]);
    if(!$query->error()){
      return true;
    }
    return false;
  }

  public function checkPassword($password){
    $sql = 'SELECT Password FROM users WHERE id = ?';
    $query = $this->_db->query($sql, [$_SESSION['user_id']]);
    if(!$query->error()){
      $hash = $query->first()->Password;
      if(password_verify($password, $hash)){
        return true;
      }
    }
    return false;
  }

  public function RestorePassword($email){//create a token and send it to user email
    $token = bin2hex(random_bytes(60));
    $hash  = hash('sha256', $token);
    $link  = APP_URL . '/reset/' . $token;
    $user_id = $this->_db->query('SELECT id FROM users WHERE Email = ?', [$email])->first()->id;
    //delete any previous tokens in database
    $this->_db->query('DELETE FROM password_tokens WHERE user_id = ?', [$user_id]);

    //insert the hash
    $sql = "INSERT INTO password_tokens (user_id, token) VALUES (?, ?)";
    $query = $this->_db->query($sql, [$user_id, $hash]);
    if(!$query->error()){
      // send the token email to the user
      $mail = $this->mailer();
      try {
          //Server settings
          $mail->SMTPDebug = 0;                                 // Disable verbose debug output
          $mail->isSMTP();                                      // Set mailer to use SMTP
          $mail->Host = SMTP_HOST;  // Specify main and backup SMTP servers
          $mail->SMTPAuth = true;                               // Enable SMTP authentication
          $mail->Username = SMTP_USER;                 // SMTP username
          $mail->Password = SMTP_PASS;                           // SMTP password
          $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
          $mail->Port = SMTP_PORT;                                    // TCP port to connect to

          //Recipients
          $mail->setFrom(SMTP_FROM_EMAIL, SMTP_FROM_NAME);
          $mail->addAddress($email, SITENAME . ' user');     // Add a recipient

          //Content
          $mail->isHTML(true);                                  // Set email format to HTML
          $mail->Subject = 'Restore your password | ' . SITENAME;
          $mail->Body    = 'Visit this link to reset your password.. please note that this link is valid for only one time. <br /> ' . $link;
          $mail->AltBody = "Visit this link to reset your password.. please note that this link is valid for only one time. \n " . $link;
          $mail->send();
          return true;
      } catch (Exception $e) {
        return false;
      }
    }
    return false;
  }

  public function dealToken($token){
    $hash = hash('sha256', $token);
    $sql = "SELECT user_id FROM password_tokens WHERE token = ?";
    $query = $this->_db->query($sql, [$hash]);
    if(!$query->error()){
      if($query->count()){
        $id = $query->first()->user_id;
        return $id;
      }
    }
    return false;
  }

  public function burnToken($token){
    $hash = hash('sha256', $token);
    $this->_db->query('DELETE FROM password_tokens WHERE token = ?', [$hash]);
  }

  public function sendVerify(){
    $token = bin2hex(random_bytes(60));;
    $hash  = hash('sha256', $token);
    $id = $_SESSION['user_id'];
    $email = $_SESSION['user_email'];
    //delete any tokens before
    $this->_db->query('DELETE FROM email_tokens WHERE user_id = ?', [$id]);
    //insert a token
    $query = $this->_db->query('INSERT INTO email_tokens (user_id, token) VALUES (?, ?)', [$id, $hash]);
    if(!$query->error()){
      $link = APP_URL . '/Users/verification/' . $token;
      $mail = $this->mailer();
      try {
          return true;
          //Server settings
          $mail->SMTPDebug = 0;                                 // Disable verbose debug output
          $mail->isSMTP();                                      // Set mailer to use SMTP
          $mail->Host = SMTP_HOST;  // Specify main and backup SMTP servers
          $mail->SMTPAuth = true;                               // Enable SMTP authentication
          $mail->Username = SMTP_USER;                 // SMTP username
          $mail->Password = SMTP_PASS;                           // SMTP password
          $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
          $mail->Port = SMTP_PORT;                                    // TCP port to connect to

          //Recipients
          $mail->setFrom(SMTP_FROM_EMAIL, SMTP_FROM_NAME);
          $mail->addAddress($email, SITENAME . ' user');     // Add a recipient

          //Content
          $mail->isHTML(true);                                  // Set email format to HTML
          $mail->Subject = 'Verify your email | ' . SITENAME;
          $mail->Body    = 'Visit this link to verify your email.. please note that this link is valid for only one time. <br /> ' . $link;
          $mail->AltBody = "Visit this link to verify your email.. please note that this link is valid for only one time. \n " . $link;
          $mail->send();
          return true;
      } catch (Exception $e) {
        return false;
      }
    }
    return false;
  }

  public function verifyEmail($token){
    $hash  = hash('sha256', $token);
    $id = $this->_db->query('SELECT user_id FROM email_tokens WHERE token = ?', [$hash]);
    if(!$id->error() && $id->count()){
      $user_id = $id->first()->user_id;
      //now verify email
      $q = $this->_db->query('UPDATE users SET verified = ? WHERE id = ?', [1, $user_id]);
      if(!$q->error()){
        //burn the token
        $this->_db->query('DELETE FROM email_tokens WHERE user_id = ?', [$user_id]);
        $_SESSION['user_verified'] = 1;
        return true;
      }
    }
    return false;
  }
}
