<?php
require_once 'config/config.php';
require_once 'helpers/session.php';
require_once 'helpers/redirect.php';

spl_autoload_register(function($class){
  require_once APP_PATH . '/libraries/' . $class . '.php';
});
