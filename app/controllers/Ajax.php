<?php

class Ajax extends Controller{

  public function __construct(){
    $this->ajaxModel = $this->model('AjaxModel');
  }

  public function default(){
    redirect('Home');
  }

  public function love(){
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'love'){
      //set like
      if($_POST['token'] === $_SESSION['user_token']){//csrf protection
        $msg_id = intval($_POST['msg_id']);
        if($this->ajaxModel->love($msg_id)){
          echo 'Success';
        }
      }
    }else{
      redirect('Home');
    }
  }

  public function delete(){
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete'){
      //delete
      if($_POST['token'] === $_SESSION['user_token']){//csrf protection
        $msg_id = intval($_POST['msg_id']);
        if($this->ajaxModel->delete($msg_id)){
          echo 'Success';
        }
      }
    }else{
      redirect('Home');
    }
  }

}
