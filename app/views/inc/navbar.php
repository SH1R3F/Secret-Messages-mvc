<!-- Starting Navbar -->
<nav class='navbar navbar-default' id='Main_navbar'>
  <div class="container">
    <div class='navbar-header'>
      <button aria-expanded='false' class='navbar-toggle' data-target='#mainNavigation' data-toggle='collapse' type='button'>
        <span class='sr-only'>Menu</span>
        <span class='icon-bar'></span>
        <span class='icon-bar'></span>
        <span class='icon-bar'></span>
      </button>
      <a href="<?php echo APP_URL; ?>" class='navbar-brand'>
        <?php echo SITENAME;?>
      </a>
    </div>
    <div class='collapse navbar-collapse' id='mainNavigation'>
      <ul class='nav navbar-nav pull-right'>
        <?php if(isset($_SESSION['user_id'])): ?>
          <li>
            <a href="<?php echo APP_URL; ?>/Messages">Messages</a>
          </li>
          <li>
            <a href="<?php echo APP_URL; ?>/Users/settings">Settings</a>
          </li>
          <li>
            <a href="<?php echo APP_URL; ?>/Pages/about">About Us</a>
          </li>
          <li>
            <a href="<?php echo APP_URL; ?>/users/logout">Logout</a>
          </li>
        <?php else: ?>
          <li>
            <a href="<?php echo APP_URL; ?>/users/register">Register</a>
          </li>
          <li>
            <a href="<?php echo APP_URL; ?>/users/login">Login</a>
          </li>
          <li>
            <a href="<?php echo APP_URL; ?>/Pages/about">About us</a>
          </li>
          <li>
            <a href="<?php echo APP_URL; ?>/Pages/contact">Contact Us</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav><!-- Ending Navbar -->
<?php

$url = 'home/default';
if(isset($_GET['url'])){
  $url = strtolower($_GET['url']);
}
$url = explode('/', trim($url));
if(count($url) === 1){
  $fpart = ['messages', 'default'];
}elseif(count($url) === 0){
  $fpart = ['home', 'default'];
}else{
  $fpart = [$url[0] , $url[1]];
}
$f2part = implode($fpart, '/');
if(
  isset($_SESSION['user_id'], $_SESSION['user_email'], $_SESSION['user_verified']) &&
  $_SESSION['user_verified'] == 0 &&
  !in_array($f2part, ['users/verify', 'users/verification', 'home/default'])
): ?>
  <!-- VERIFY YOUR ACCOUNT NOTIFY -->
  <div class='container'>
    <div class='lead alert alert-danger'>
      is this your email -> '<?php echo $_SESSION['user_email']; ?>'? you need to verify it <a href='<?php echo APP_URL . '/Users/verify'; ?>'><button class='btn btn-primary'>Verify now</button></a>
    </div>
  </div><!-- VERIFY YOUR ACCOUNT NOTIFY -->
<?php endif; ?>
