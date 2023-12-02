<?php
require 'include/funciones.php';
require 'include/funciones/recogeRequest.php';
include_once 'include/template/header.php'; 

require_once 'DAL/tour.php';

$id = recogeGet("id");

$validacion = eliminarTourEspecifico($id);

if ($validacion) {
    header("Location: tour.php");
}else{
    echo "Ha ocurrido un error al ejecutar la accion";
}

?>