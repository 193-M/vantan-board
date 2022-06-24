<?php
  session_start();
 
  $_SESSION = [];
  header('Location: /vantan-board/index.php');
  exit;