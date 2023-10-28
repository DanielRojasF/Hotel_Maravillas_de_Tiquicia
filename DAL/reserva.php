<?php

require_once "conexion.php"; //asegura que el archivo se incluye solo una vez para evitar problemas de duplicación.

function IngresaReserva($pNombre_cliente, $pEmail_cliente,$pFecha_inicio,$pFecha_Fin) {
    $retorno = false;

    try {
        $oConexion = Conecta();

        //formato utf8
        if(mysqli_set_charset($oConexion, "utf8")){
            $stmt = $oConexion->prepare("insert into reserva (nombre_cliente, email_cliente, fecha_inicio, fecha_fin) values (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $iNombre_cliente, $iEmail_cliente,$iFecha_inicio,$iFecha_Fin);

            //set parametros y luego ejecutarlo
            $iNombre_cliente = $pNombre_cliente;
            $iEmail_cliente = $pEmail_cliente;
            $iFecha_inicio = $pFecha_inicio;
            $iFecha_Fin = $pFecha_Fin; 

            if($stmt->execute()){
                $retorno = true;
            }
        }
    } catch (\Throwable $th) {
        //Bitacora
        echo $th;
    } finally {
        Desconecta($oConexion);
    }

    return $retorno;
}

function getArray($sql) {
    try {
        $oConexion = Conecta();

        //formato utf8
        if(mysqli_set_charset($oConexion, "utf8")){
            if(!$result = mysqli_query($oConexion, $sql)) die(); //cancelar el programa
            $retorno = array();
            while ($row = mysqli_fetch_array($result)) {
                $retorno[] = $row;
            }
        }
    } catch (\Throwable $th) {
        //Bitacora
        echo $th;
    } finally {
        Desconecta($oConexion);
    }
    return $retorno;
}

function getObject($sql) {
    try {
        $oConexion = Conecta();

        //formato utf8
        if(mysqli_set_charset($oConexion, "utf8")){
            if(!$result = mysqli_query($oConexion, $sql)) die(); //cancelar el programa
            $retorno = null;
            while ($row = mysqli_fetch_array($result)) {
                $retorno = $row;
            }
        }
    } catch (\Throwable $th) {
        //Bitacora
        echo $th;
    } finally {
        Desconecta($oConexion);
    }
    return $retorno;
}

// function DefinirContrasena($pCorreo, $pPassword) {
//     $retorno = false;

//     try {
//         $oConexion = Conecta();

//         //formato utf8
//         if(mysqli_set_charset($oConexion, "utf8")){
//             $stmt = $oConexion->prepare("update alumno set contrasena = ? where correo = ?");
//             $stmt->bind_param("ss", $iContrasena, $iCorreo);

//             //set parametros y luego ejecutarlo
//             $iContrasena = $pPassword;
//             $iCorreo = $pCorreo;

//             if($stmt->execute()){
//                 $retorno = true;
//             }
//         }
//     } catch (\Throwable $th) {
//         //Bitacora
//         echo $th;
//     } finally {
//         Desconecta($oConexion);
//     }

//     return $retorno;
// }