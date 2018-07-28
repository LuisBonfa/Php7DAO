<?php

  require_once("config.php");
  $user= new Usuario();
  $user->loadbyId(4);

  echo $user;



 ?>
