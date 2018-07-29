<?php

class Usuario{

private $idusuario;
private $deslogin;
private $dessenha;
private $dtcadastro;


public function getIdusuario(){
  return $this->idusuario;
}

public function setIdusuario($id){
  $this->idusuario = $id;
}

public function getDeslogin(){
  return $this->deslogin;
}

public function setDeslogin($login){
  $this->deslogin = $login;
}

public function getDessenha(){
  return $this->dessenha;
}

public function setDessenha($senha){
  $this->dessenha = $senha;
}

public function getDtcadastro(){
  return $this->dtcadastro;
}

public function setDtcadastro($data){
  $this->dtcadastro = $data;
}

public function loadById($id){

  $sql = new SQL();
  $results = $sql->select(
    "select * from tb_usuarios where idusuario = :ID",
    array(":ID"=>$id)
  );

  if(isset($results[0])){
    $this->setData($results[0]);
  }
}

public static function getAllUsers(){
  $sql = new Sql();
  return $sql->select("select * from tb_usuarios order by deslogin");
}

public static function search($login){
  $sql = new Sql();
  return $sql->select("select * from tb_usuarios where deslogin like :SEARCH order by deslogin",array(
    ":SEARCH"=>"%$login%"
  ));
}

  public function __toString(){
    return json_encode(array(
      "idusuario"=>$this->getIdusuario(),
      "deslogin"=>$this->getDeslogin(),
      "dessenha"=>$this->getDessenha(),
      "dtcadastro"=>$this->getDtcadastro()->format("d/m/Y")
    ));
  }

  public function login($login,$password){
    $sql = new SQL();
    $results = $sql->select("select * from tb_usuarios where deslogin = :LOGIN and dessenha = :PASSWORD",array(":LOGIN"=>$login,":PASSWORD"=>$password));

    if(isset($results[0])){
      $this->setData($results[0]);
    }
    else {
      throw new Exception("Login e/ou senha Inválidos!");
    }
  }

  public function insertUser(){

    $sql = new Sql();
    $results = $sql->select("CALL sp_usuarios_insert(:LOGIN,:PASSWORD)",array(
      ":LOGIN"=>$this->getDeslogin(),
      ":PASSWORD"=>$this->getDessenha()
    ));

    if(count($results) > 0){
      $this->setData($results[0]);
    }
  }

  public function setData($data){
    $this->setIdusuario($data['idusuario']);
    $this->setDeslogin($data['deslogin']);
    $this->setDessenha($data['dessenha']);
    $this->setDtcadastro(new DateTime($data['dtcadastro']));
  }

  public function __construct($login = "",$senha = ""){
    $this->setDeslogin($login);
    $this->setDessenha($senha);
  }

  public function update($login,$password){

    $this->setDeslogin($login);
    $this->setDessenha($password);

    $sql = new Sql();

    $sql->query("Update tb_usuarios set deslogin = :LOGIN, dessenha = :PASSWORD where idusuario = :ID",array(
      ":LOGIN"=>$this->getDeslogin(),
      ":PASSWORD"=>$this->getDessenha(),
      ":ID"=>$this->getIdusuario()
    ));
  }

  public function deleteUser(){
    $sql = new Sql();
    $sql->query("Delete from tb_usuarios where idusuario = :ID",array(
      ":ID"=>$this->getIdusuario()
    ));

    $this->setIdusuario(0);
    $this->setDeslogin("");
    $this->setDessenha("");
    $this->setDtcadastro(new DateTime());
  }
}

 ?>
