<?php
  
 require('conector.php'); // Libreria de conexion de BD
  session_start();  
  if (isset($_SESSION['username'])) { // verifico la session del usuario
	$con = new ConectorBD('localhost','root','');
    if ($con->initConexion('agenda_db')=='OK') { // me conecto a la BD 
      $resultado = $con->consultar(['usuarios'], ['nombre', 'id'], "WHERE email ='".$_SESSION['username']."'"); // consulto al usuario y su ID
      $fila = $resultado->fetch_assoc();
      $response['nombre']=$fila['nombre'];
     
      $resultado = $con->getEventoUser($fila['id']); // Consulto los eventos asosciados al ID del Usuario
      $i=0;
      while ($fila = $resultado->fetch_assoc()) { // devuelvo un array con la informacion de los eventos asociados al usuario
		$response['eventos'][$i]['id'] = $fila['id'];
		if ($fila['diaCompleto'] = 0)  {
        $response['eventos'][$i]['allDay']=false;
		$response['eventos'][$i]['title'] = '-'.$fila['hora_finalizacion'].' '.$fila['titulo'];
		}
		else {
			
		$response['eventos'][$i]['allDay']=true;
        $response['eventos'][$i]['title'] = $fila['titulo'];		
		}
		
		$response['eventos'][$i]['start']=$fila['fecha_inicio'].' '.$fila['hora_inicio'];
        $response['eventos'][$i]['end']=$fila['fecha_finalizacion'].' '.$fila['hora_finalizacion'];
        $i++;
      }
      $response['msg'] = "OK";

    }else {
      $response['msg'] = "No se pudo conectar a la Base de Datos";
    }
  }else {
    $response['msg'] = "No se ha iniciado una sesión";
  }

  echo json_encode($response);

  $con->cerrarConexion();


 ?>
