<?php

function redirect($page){
  header('Location: ' . APP_URL . '/' . $page);
}
