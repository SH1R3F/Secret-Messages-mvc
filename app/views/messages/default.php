<?php require_once APP_PATH . '/views/inc/header.php'; ?>
<div class="container">
  <section class="my-details">
    <div class="my-img" style="background-image: url('<?php echo file_exists(APP_PATH . '/../public/uploads/' . $_SESSION['user_photo']) ? APP_URL . '/uploads/' . $_SESSION['user_photo'] : APP_URL . '/uploads/' . 'pics/default.jpg' ; ?>');"></div>
    <h4 class="bold" id="user_id">
      <a href="<?php echo APP_URL; ?>/Users/settings"><i class="fa fa-cog"></i></a>
       <?php echo $_SESSION['user_name']; ?>
     </h4>
     <h4 class="bold">Messages: <span id="numOfMsg"><?php echo $data['Number']; ?></span></h4>
     <a href="<?php echo APP_URL . '/' . $_SESSION['user_username']; ?>" class="bold" target="_blank"><?php echo APP_URL . '/' . $_SESSION['user_username']; ?></a>
  </section>

  <section class="my-messages">
    <h2 class="page-header"><i class="fa fa-comments"></i> Messages</h2>
    <div class="row">
      <div class="col-xs-6 messages-cat category active" data-filter="cat-all">Received</div>
      <div class="col-xs-6 messages-cat category" data-filter="loved">Favorite</div>
    </div>
    <div class="messages">
      <input type='hidden' name='token' value='<?php echo $_SESSION['user_token']; ?>' />
      <?php
      if(count($data['Results'])):
        foreach($data['Results'] as $message):
        ?>
          <div class="message cat-all<?php echo ($message->Category == '0') ? ' received' : ' loved' ; ?>">
            <span class="delete" data-hold="<?php echo $message->id; ?>"><i class="fa fa-window-close"></i></span>
            <p class="lead" dir="auto"><?php echo $message->Message; ?></p>
            <span class="info"><a class="date"><?php echo date('g:i a - jS F Y', strtotime($message->Sending_time)); ?></a></span>
            <span class="love" data-hold="<?php echo $message->id; ?>"><i class="fa fa-heart"></i></span>
          </div>
        <?php
        endforeach;
      else:
      ?>
      <div class="alert alert-info" style="margin-top: 35px;">
        <p class="lead">
          You don't have messages yet.. You need to share your link with your friends
        </p>
        Your Link is <a href="<?php echo APP_URL . '/' . $_SESSION['user_username']; ?>" target="_blank"><?php echo APP_URL . '/' . $_SESSION['user_username']; ?></a>
      </div>
      <?php
      endif;
      ?>
    </div>
  </section>
</div>
<?php require_once APP_PATH . '/views/inc/footer.php';?>
