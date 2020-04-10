<?php

  include('conector.php');  // Libreria de Conexion BD
  session_start();	
  if (isset($_SESSION['username'])) {// si existe la session 
	   
   $con = new ConectorBD('localhost','root','');// Me conecto  a la base de datos
    if ($con->initConexion('agenda_db')=='OK') {
		 
      if($con->eliminarRegistro('eventos', "id = ".$_POST['id'])){ // Recibo de parametro el id del evento para eleminar.
        $response['msg']="Se elimino el registro correctamente";
      }else {
        $response['msg']= "Hubo un error y los datos no fueron eliminados";
       }
    }else {
       $response['msg']= "No se pudo conectar a la base de datos";
    }
    }else {
    $response['msg'] = "No se ha iniciado una sesión";
     }
  echo json_encode($response); // envio la respuesta
  
 $con->cerrarConexion();

 ?>
