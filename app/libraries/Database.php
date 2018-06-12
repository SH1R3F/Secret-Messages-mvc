<?php

//database class
class Database{

  private static $_instance = false;
  private $_host   = DB_HOST,
          $_user   = DB_USER,
          $_pass   = DB_PASS,
          $_dbname = DB_NAME,
          $_pdo,
          $_query,
          $_result,
          $_count,
          $_error = false;

  public function __construct(){
    try{
      $this->_pdo = new PDO('mysql:host=' . $this->_host . ';dbname=' . $this->_dbname, $this->_user, $this->_pass);
    }catch(PDOException $e){
      die('Error connecting to database please contact the admin !');
    }
  }

  public static function getInstance(){
    if(!self::$_instance){
      self::$_instance = new Database();
    }
    return self::$_instance;
  }

  public function query($sql, $params = []){
    $this->_query = $this->_pdo->prepare($sql);
    if($params){
      $x = 1;
      foreach($params as $param){
        $this->_query->bindValue($x, $param);
        $x++;
      }
    }
    if($this->_query->execute()){
      $this->_result = $this->_query->fetchAll(PDO::FETCH_OBJ);
      $this->_count  = $this->_query->rowCount();
    }else{
      $this->_error = true;
    }
    return $this;
  }

  public function result(){
    return $this->_result;
  }

  public function first(){
    return $this->result()[0];
  }

  public function count(){
    return $this->_count;
  }

  public function error(){
    return $this->_error;
  }

}
