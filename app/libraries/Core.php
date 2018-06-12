<?php

class Core{

  private $_controller = 'Home',
          $_method     = 'default',
          $_params     = [],
          $_db;

  public function __construct(){

    $this->_db = Database::getInstance();

    $url = $this->parseUrl();

    if(file_exists('../app/controllers/' . ucfirst($url[0]) . '.php')){

      $this->_controller = ucfirst($url[0]);

    }elseif($this->_db->query('SELECT 1 FROM users WHERE username = ?', [$url[0]])->count()){//if the controller is not exists check if it is a username

      $this->_controller = 'Users';
      $this->_method = 'send';

    }elseif(!empty($url[0])){
      $this->_controller = 'Errors';
      $this->_method = 'PageNotFound';
    }
    unset($url[0]);
    require_once '../app/controllers/' . $this->_controller . '.php';
    $this->_controller = new $this->_controller;

    if(isset($url[1])){
      if(method_exists($this->_controller, $url[1])){
        $this->_method = $url[1];
      }
      unset($url[1]);
    }
    $this->_params = $url ? array_values($url) : [];

    //if directed to login, or register pages and I'm already logged in then redirect me to messages directory
    if(
      strtolower(get_class($this->_controller)) === 'users' &&
      in_array(strtolower($this->_method), ['login', 'register', 'restore', 'reset']) && //the page is login or register
      isset($_SESSION['user_id']) //User is logged in
    ){
      redirect('Messages');
      exit();
    }
    //if user is not logged in. only permitted to visit login, register, home/default, or send page
    if(!isset($_SESSION['user_id'])){
      if(strtolower(get_class($this->_controller)) === 'users'){
        if(!in_array(strtolower($this->_method), ['login', 'register', 'send', 'restore', 'reset', 'verification'])){
          redirect('Users/login');
          exit();
        }
      }elseif(get_class($this->_controller) === 'Home'){
        if(!in_array($this->_method, ['default', 'nojs'])){
          redirect('Users/login');
          exit();
        }
      }else{
        if(get_class($this->_controller) !== 'Pages'){
          redirect('Users/login');
          exit();
        }
      }
    }

    call_user_func_array([$this->_controller, $this->_method], $this->_params);
  }

  public function parseUrl(){
    if(isset($_GET['url'])){
      $url = filter_var(trim($_GET['url'], '/'), FILTER_SANITIZE_URL);
      return explode('/', $url);
    }
  }

}
