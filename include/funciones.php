<?php

define('TEMPLATES_URL', __DIR__ . '/template');
define('FUNCIONES_URL', __DIR__ . 'funciones.php');

function incluirTemplate($nombre, $inicio = false) {
    include TEMPLATES_URL . "/$nombre.php";
}