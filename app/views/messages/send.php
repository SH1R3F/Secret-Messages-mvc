<?php require_once APP_PATH . '/views/inc/header.php'; ?>
  <div class="send-message">
    <div class="container">
      <div class="sending-box">
        <div class="profile-img" style="background-image: url('<?php echo APP_URL . '/uploads/' . $data['user_data']->photo; ?>') ;">
        </div>
        <div class="message-box text-center">
          <h4 class="bold">
            <?php echo $data['user_data']->Name; ?>
          </h4>
          <p>Leave a constructive message :)</p>
          <form method="post" action="<?php echo APP_URL . '/' . $data['user_data']->Username; ?>">
            <?php echo flash('message_send'); ?>
            <textarea placeholder="Leave a message" name="message" required dir="auto"><?php echo $data['Inputs']['message']; ?></textarea>
            <a class='text text-danger'><?php echo $data['Inputs']['message_err']; ?></a>
            <button type="submit" name="submitMessage" class="submit-btn btn btn-default"> <i class="fa fa-pencil"></i> Send</button>
          </form>
        </div>
      </div>
    </div>
  </div>
<?php require_once APP_PATH . '/views/inc/footer.php'; ?>
