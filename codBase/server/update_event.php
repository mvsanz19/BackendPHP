<?php
  include('conector.php'); // Libreria de Conexión de BD
   
  session_start();
  if (isset($_SESSION['username'])) { // verifico la session iniciada por el usuario
	 $id   = $_POST['id'];   // tomo el id del evento en caso que ya se encuentre creado
     $data['fecha_inicio'] = "'".$_POST['start_date']."'"; // tomo la fecha de inicio a actualizar
     $data['fecha_finalizacion'] = "'".$_POST['start_date']."'"; // coloco la misma fecha fin igual a la de inicio
  
   
   $con = new ConectorBD('localhost','root','');
    if ($con->initConexion('agenda_db')=='OK') { // me conecto a la BD
      $resultado = $con->consultar(['usuarios'], ['nombre', 'id'], "WHERE email ='".$_SESSION['username']."'"); // consulto el ID del usuario
      $fila = $resultado->fetch_assoc();
      $resultado = $con->getEventoUser($fila['id']); // Consulto el Id del Evento del usuario en caso que sea nuevo el Evento 
	    while ($fila = $resultado->fetch_assoc()) {
	     if ($fila['fecha_inicio'] = $data['fecha_inicio']){ // Verifico si es la misma fecha para tomar el ID y actualizar
		  $id = $fila['id'];
		  }
		}
      if($con->actualizarRegistro('eventos', $data, "id = ".$id)){ // Actualizo el evento
        $response['msg']="OK";
      }else {
        $response['msg']= "Hubo un error y los datos no han sido actualizado";
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
