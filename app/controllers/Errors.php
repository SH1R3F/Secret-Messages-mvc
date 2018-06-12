<?php

class Errors extends Controller{
  public function PageNotFound(){
    $this->view('errors/404', ['title' => 'Page not found']);
  }
}
