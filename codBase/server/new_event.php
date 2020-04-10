<?php
   include('conector.php'); // Libreria de Conexion de BD
   
  session_start();
  if (isset($_SESSION['username'])) { // Verifico  la session del usuario
	   // Tomo la informacion del nuevo evento
     $data['titulo'] = "'".$_POST['titulo']."'";
     $data['fecha_inicio'] = "'".$_POST['start_date']."'";
     $data['hora_inicio'] = "'".$_POST['start_hour']."'";
     $data['fecha_finalizacion'] = "'".$_POST['end_date']."'";
     $data['hora_finalizacion'] = "'".$_POST['end_hour']."'";
   
    if ($_POST['allDay']== true) {
       $data['diaCompleto']=0;
    }else {
      $data['diaCompleto']=1;
    }
   $con = new ConectorBD('localhost','root','');
    if ($con->initConexion('agenda_db')=='OK') {// me conecto a la BD
      $resultado = $con->consultar(['usuarios'], ['nombre', 'id'], "WHERE email ='".$_SESSION['username']."'"); // Consulto al usuario y su ID
      $fila = $resultado->fetch_assoc();	
      $data ['fk_usuario'] = $fila  ['id'];
      if($con->insertData('eventos', $data)){ // ingreso la informacion del evento con el ID del usuario
        $response['msg']="OK";
      }else {
        $response['msg']= "Hubo un error y los datos no han sido cargados";
       }
    }else {
       $response['msg']= "No se pudo conectar a la base de datos";
    }
 }else {
    $response['msg'] = "No se ha iniciado una sesión";
  }
  echo json_encode($response);
  
 $con->cerrarConexion();
   
 ?>
