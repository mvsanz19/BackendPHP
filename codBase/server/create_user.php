<?php
 include('conector.php');
  $psw = '12345';
  $data['nombre'] = "'Monica'";
  $data['fecha_nacimiento'] = "'1982/06/19'";
  $data['email'] ="'monica@gmail.com'";
  $data['psw'] = "'".password_hash($psw , PASSWORD_DEFAULT)."'";
  $psw = '12346';
  $data2['nombre'] = "'Carlos'";
  $data2['fecha_nacimiento'] = "'1983/09/21'";
  $data2['email'] ="'carlos@gmail.com'";
  $data2['psw'] = "'".password_hash($psw, PASSWORD_DEFAULT)."'";
  $psw = '12347';
  $data3['nombre'] = "'Maria'";
  $data3['fecha_nacimiento'] = "'1994/04/05'";
  $data3['email'] ="'maria@gmail.com'";
  $data3['psw'] = "'".password_hash($psw, PASSWORD_DEFAULT)."'";
  $val = 0;
  $con = new ConectorBD('localhost','root','');
  if ($con->initConexion('agenda_db')=='OK') {
     if($con->insertData('usuarios', $data)){
      $response['msg']="OK";
     }
	if($con->insertData('usuarios', $data2)){
      $response['msg']="OK";
    }
	if($con->insertData('usuarios', $data3)){
      $response['msg']="OK";
    }
  }else {
    $response['msg']= "No se pudo conectar a la base de datos";
  }

   echo json_encode($response);
   
   $con->cerrarConexion();
 ?>
