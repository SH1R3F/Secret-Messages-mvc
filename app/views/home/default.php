<?php require_once APP_PATH . '/views/inc/header.php'; ?>
<!-- Start Page Content -->
<section class="Home">
  <div class="container">
    <p class="describe">
      Get honest feedback from your coworkers and friends
    </p>
    <div class="row">
      <div class="intro-list col-sm-6 col-xs-12">
        <ul><h3>At work</h3>
          <li>
            Enhance your areas of strength
          </li>
          <li>
            Strengthen Areas for Improvement
          </li>
        </ul>
      </div>
      <div class="intro-list col-sm-6 col-xs-12">
        <ul><h3>With Your Friends</h3>
          <li>
            Improve your friendship by discovering your strengths and areas for improvement
          </li>
          <li>
            Let your friends be honest with you
          </li>
        </ul>
      </div>
      <div class="links col-xs-12">
        <?php if(!isset($_SESSION['user_id'])): ?>
          <a href="<?php echo APP_URL; ?>/Users/register">Register</a><span> | </span><a href="<?php echo APP_URL; ?>/Users/login">Login</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
<!-- End Page Content -->
<?php require_once APP_PATH . '/views/inc/footer.php'; ?>
