<?php

class Message extends Model{

  /**
  * Returns the number of messages
  * @param required: if I want to get number of messages or messages result
  */
  public function getMessages($required){
    $sql = "SELECT * FROM messages WHERE Receiver_id = ? ORDER BY id DESC";
    $query = $this->_db->query($sql, [$_SESSION['user_id']]);
    if(!$query->error()){
      if($required === 'Numbers'){
        return $query->count();
      }elseif($required === 'Results'){
        return $query->result();
      }
    }
    return false;
  }
}
