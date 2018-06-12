<?php
class Home extends Controller{

  public function default(){
    $this->view('home/default', ['title' => 'Welcome to ' . SITENAME]);
  }

  public function nojs(){
    $this->view('home/nojs', ['title' => 'Javascript is required | ' . SITENAME]);
  }

}
