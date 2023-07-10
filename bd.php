<?php
  //vervidor del servicio (la IP) en este caso es
  //en nuestra pc por eso es localhost
  $servidor="localhost";
  //nombre de la base de datos
  $dbname="app";
  //nombre del usuario (esta en la base de datos)
  $user="root";
  //contaseña que tenga el usuario
  $password="";

try {
  

    $conexion = new PDO("mysql:host=$servidor;dbname=$dbname", $user, $password);

} catch (PDOException $e){

  echo $e->getMessage();

} 
?>