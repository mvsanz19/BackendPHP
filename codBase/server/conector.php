<?php


  class ConectorBD
  {
    private $host;
    private $user;
    private $password;
    private $conexion;

    function __construct($host, $user, $password){
      $this->host = $host;
      $this->user = $user;
      $this->password = $password;
    }
// inicia conexion
    function initConexion($nombre_db){
      $this->conexion = new mysqli($this->host, $this->user, $this->password, $nombre_db);
      if ($this->conexion->connect_error) {
        return "Error:" . $this->conexion->connect_error;
      }else {
        return "OK";
      }
    }
// crear un nueva tabla
    function newTable($nombre_tbl, $campos){
      $sql = 'CREATE TABLE '.$nombre_tbl.' (';
      $length_array = count($campos);
      $i = 1;
      foreach ($campos as $key => $value) {
        $sql .= $key.' '.$value;
        if ($i!= $length_array) {
          $sql .= ', ';
        }else {
          $sql .= ');';
        }
        $i++;
      }
      return $this->ejecutarQuery($sql);
    }
// Ejecuta la sentencia SQL
    function ejecutarQuery($query){
      return $this->conexion->query($query);
    }
// Cierra la conexion
    function cerrarConexion(){
      $this->conexion->close();
    }
// generar una nueva restriccion a la tabla de BD
    function nuevaRestriccion($tabla, $restriccion){
      $sql = 'ALTER TABLE '.$tabla.' '.$restriccion;
      return $this->ejecutarQuery($sql);
    }
// crear una nueva relacion a una tabla
    function nuevaRelacion($from_tbl, $to_tbl, $from_field, $to_field){
      $sql = 'ALTER TABLE '.$from_tbl.' ADD FOREIGN KEY ('.$from_field.') REFERENCES '.$to_tbl.'('.$to_field.');';
      return $this->ejecutarQuery($sql);
    }
// inserta los registros a un tabla
    function insertData($tabla, $data){
      $sql = 'INSERT INTO '.$tabla.' (';
      $i = 1;
      foreach ($data as $key => $value) {
        $sql .= $key;
        if ($i<count($data)) {
          $sql .= ', ';
        }else $sql .= ')';
        $i++;
      }
      $sql .= ' VALUES (';
      $i = 1;
      foreach ($data as $key => $value) {
        $sql .= $value;
        if ($i<count($data)) {
          $sql .= ', ';
        }else $sql .= ');';
        $i++;
      }
	
      return $this->ejecutarQuery($sql);

    }
// obtiene la conexion iniciada
    function getConexion(){
      return $this->conexion;
    }
// actualiza los registros en una tabla
    function actualizarRegistro($tabla, $data, $condicion){
      $sql = 'UPDATE '.$tabla.' SET ';
      $i=1;
      foreach ($data as $key => $value) {
        $sql .= $key.'='.$value;
        if ($i<sizeof($data)) {
          $sql .= ', ';
        }else $sql .= ' WHERE '.$condicion.';';
        $i++;
      }
      return $this->ejecutarQuery($sql);
    }
//elimina los registros 
    function eliminarRegistro($tabla, $condicion){
      $sql = "DELETE FROM ".$tabla." WHERE ".$condicion.";";
	  return $this->ejecutarQuery($sql);
    }
// Consulta los registros de una tabla
    function consultar($tablas, $campos, $condicion = ""){
      $sql = "SELECT ";
       $ultima_key = array_keys($campos);
	  $ultima_key = end($ultima_key);
      foreach ($campos as $key => $value) {
        $sql .= $value;
        if ($key!=$ultima_key) {
          $sql.=", ";
        }else $sql .=" FROM ";
      }

      $ultima_key = array_keys($tablas);
	  $ultima_key = end($ultima_key);
      foreach ($tablas as $key => $value) {
        $sql .= $value;
        if ($key!=$ultima_key) {
          $sql.=", ";
        }else $sql .= " ";
      }

      if ($condicion == "") {
        $sql .= ";";
      }else {
        $sql .= $condicion.";";
      }
      return $this->ejecutarQuery($sql);
    }
	
// Consulta que obtiene los eventos de un usuario	
    function getEventoUser($user_id){
      $sql = "SELECT a.id, a.titulo , a.fecha_inicio , a.hora_inicio , a.fecha_finalizacion , a.hora_finalizacion, a.diaCompleto
              FROM eventos AS a
              WHERE a.fk_usuario = ".$user_id.";";			  
      return $this->ejecutarQuery($sql);
    }
	 
  }

 ?>
