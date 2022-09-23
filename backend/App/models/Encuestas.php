<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \Core\MasterDom;
use \App\interfaces\Crud;
use \App\controllers\UtileriasLog;

class Encuestas{


  public static function insert($datos){
    $mysqli = Database::getInstance(1);
    $query=<<<sql
    INSERT INTO encuesta (nombre, email, preg_1, preg_2, preg_3, preg_3_txt, preg_4, preg_6, preg_8, 
    preg_8_1, preg_9, preg_10) 
    VALUES (:nombre, :email, :preg_1, :preg_2, :preg_3 , :preg_3_txt, :preg_4, :preg_6, :preg_8, 
    :preg_8_1, :preg_9, :preg_10);
sql;



  $parametros = array(
    ':nombre'=>$datos->_nombre,
    ':email'=>$datos->_email,
    ':preg_1'=>$datos->_preg_1,
    ':preg_2'=>$datos->_preg_2,
    ':preg_3'=>$datos->_preg_3,
    ':preg_3_txt'=>$datos->_text_preg_3,
    ':preg_4'=>$datos->_preg_4,    
    // ':preg_5_1'=>$datos->_preg_5_1,
    // ':preg_5_2'=>$datos->_preg_5_2,
    // ':preg_5_3'=>$datos->_preg_5_3,
    // ':preg_5_4'=>$datos->_preg_5_4,
    // ':preg_5_5'=>$datos->_preg_5_5,
    // ':preg_5_6'=>$datos->_preg_5_6,
    // ':preg_5_7'=>$datos->_preg_5_7,
    // ':preg_5_8'=>$datos->_preg_5_8,
    // ':preg_5_9'=>$datos->_preg_5_9,
    // ':preg_5_10'=>$datos->_preg_5_10,
    // ':preg_5_11'=>$datos->_preg_5_11,
    // ':preg_5_12'=>$datos->_preg_5_12,
    // ':preg_5_13'=>$datos->_preg_5_13,
    // ':preg_5_14'=>$datos->_preg_5_14,
    // ':preg_5_15'=>$datos->_preg_5_15,
    ':preg_6'=>$datos->_preg_6,
    // ':preg_7_1'=>$datos->_preg_7_1,
    // ':preg_7_2'=>$datos->_preg_7_2,
    // ':preg_7_3'=>$datos->_preg_7_3,
    // ':preg_7_4'=>$datos->_preg_7_4,
    ':preg_8'=>$datos->_preg_8,
    ':preg_8_1'=>$datos->_preg_8_1,
    ':preg_9'=>$datos->_preg_9,
    ':preg_10'=>$datos->_preg_10,
   
  );
  $id = $mysqli->insert($query,$parametros);
  // $accion = new \stdClass();
  // $accion->_sql= $query;
  // $accion->_parametros = $parametros;
  // $accion->_id = $id;

  // UtileriasLog::addAccion($accion);
  return $id;
}

public static function searchUserEncuesta($usuario){
    $mysqli = Database::getInstance();
    $query=<<<sql
    SELECT * FROM encuesta WHERE email = '$usuario'   
sql;
  return $mysqli->queryAll($query);
}


public static function getUserEncuesta($email){
  $mysqli = Database::getInstance();
  $query=<<<sql
  SELECT ra.id_registro_acceso,ra.nombre,ra.segundo_nombre,ra.apellido_paterno,ra.apellido_materno,
  ra.email,ra.clave FROM registros_acceso ra 
  WHERE ra.email = '$email'
sql;
return $mysqli->queryAll($query);
}

}