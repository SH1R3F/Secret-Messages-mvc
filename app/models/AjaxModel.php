<?php

class AjaxModel extends Model{

  public function love($msg_id){
    $getSql = "SELECT * FROM messages WHERE id = ?";
    $getQuery = $this->_db->query($getSql, [$msg_id]);
    if(!$getQuery->error() && $getQuery->count()){
      $cat = ($getQuery->first()->Category == '1') ? '0' : '1' ;
      $postSql = "UPDATE messages SET Category = ? WHERE id = ?";
      $postQuery = $this->_db->query($postSql, [$cat, $msg_id]);
      if(!$postQuery->error()){
        return true;
      }
    }
    return false;
  }

  public function delete($msg_id){
    $sql = "DELETE FROM messages WHERE id = ?";
    $query = $this->_db->query($sql, [$msg_id]);
    if(!$query->error()){
      return true;
    }
    return false;
  }

}
