<?php

session_start();

function flash($name, $message = '', $class = ''){
  if(isset($_SESSION[$name]) && empty($message)){
    $value = $_SESSION[$name];
    unset($_SESSION[$name]);
    return $value;
  }elseif(!empty($message)){
    $message = $class ? "<div class='" . $class . "'>" . $message . "</div>" : "<div>" . $message . "</div>";
    return $_SESSION[$name] = $message;
  }
}
