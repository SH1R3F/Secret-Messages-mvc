<?php

abstract class Model{

  protected $_db;

  public function __construct(){
    $this->_db = Database::getInstance();
  }

}
