<?php

abstract class Controller{


  public function model($model){
    //require the model and instantiate it
    require_once APP_PATH . '/models/' . $model . '.php';
    return $model = new $model();
  }

  public function view($view, $data = []){
    //require the view
    require_once APP_PATH . '/views/' . $view . '.php';
  }
}
