<?php
class Pages extends Controller{

  public function default(){
    $this->view('pages/about', ['title' => 'About Us | ' . SITENAME]);
  }

  public function about(){
    $this->view('pages/about', ['title' => 'About Us | ' . SITENAME]);
  }

  public function contact(){
    $this->view('pages/contact', ['title' => 'Contact Us | ' . SITENAME]);
  }

  public function privacy(){
    $this->view('pages/privacy', ['title' => 'Privacy policy | ' . SITENAME]);
  }

  public function terms(){
    $this->view('pages/terms', ['title' => 'Terms and Conditions | ' . SITENAME]);
  }

}
