<?php

  require_once("config.php");
  //get user by id
  //$user= new Usuario();
  //$user->loadbyId(4);

  //get All Users
  //$lista = Usuario::getAllUsers();
  //echo json_encode($lista);

  //Search for login
  //$search = Usuario::search("jo");
  //echo json_encode($search);

  $login = new Usuario();

  $login->login("jose","1234");
  echo $login;
 ?>
