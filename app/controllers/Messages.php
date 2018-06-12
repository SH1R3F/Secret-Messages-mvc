<?php

class Messages extends Controller{

  public function __construct(){
    $this->messagesModel = $this->model('Message');
  }
  public function default(){
    $data = array(
      'title'  => 'Your messages | ' . SITENAME,
      'Number' => $this->messagesModel->getMessages('Numbers'),
      'Results' => $this->messagesModel->getMessages('Results'),
    );
    $this->view('messages/default', $data);
  }

}
