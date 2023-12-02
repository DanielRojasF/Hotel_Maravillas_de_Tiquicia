<?php

require_once "conexion.php";


function InsertarTour($pNombre, $pDescripcion, $pFecha, $pCosto, $pBinariosImagen, $pTipoArchivo) {
    $retorno = false;

    try {
        $conexion = Conecta();

        if(mysqli_set_charset($conexion, "utf8")){
            // $stmt = $conexion->prepare("insert into juegos(nombre, descripcion, costo, imagen, tipoImagen) values (?, ?, ?, ?, ?)");
            // $stmt->bind_param("ssibs", $iNombre, $iDescripcion, $iCosto, $iBinariosImagen, $iTipoArchivo);

            // //set parametros y ejecutar
            // $iNombre = $pNombre;
            // $iDescripcion = $pDescripcion;
            // $iCosto = $pCosto;
            // $iBinariosImagen = $pBinariosImagen;
            // $iTipoArchivo = $pTipoArchivo;

            // if($stmt->execute()){
            //     $retorno = true;
            // }else{
            //     $retorno = true;
            // }

            //Modo diferente para que se inserten correctamente los binarios, el modo de la clase me da error
            $query= "INSERT INTO tours (nombre_tour, descripcion_tour, fecha_tour, precio_tour, imagen, tipoImagen) values 
                    ('".$pNombre."', '".$pDescripcion."','".$pFecha."', '".$pCosto."', '".$pBinariosImagen."', '".$pTipoArchivo."') ";

            $res=mysqli_query($conexion, $query);    
            if ($res) {
                $retorno = true;
            }    

            
            
        }
    }catch (\PDOException $e) {
        echo "Error en base de datos: " . $e->getMessage();

        $fecha = date('d/m/Y H:i:s');
        $error = $e->getMessage();
        $archivo = fopen("BitacoraErrores.txt", "a");
        fwrite($archivo, "Fecha: $fecha -------- Error en base de datos: $error \n \n");
        fclose($archivo);

    }catch (\Throwable $th) {
        echo "Error: " . $th->getMessage();

        $fecha = date('d/m/Y H:i:s');
        $error = $th->getMessage();
        $archivo = fopen("BitacoraErrores.txt", "a");
        fwrite($archivo, "Fecha: $fecha -------- Error: $error \n \n");
        fclose($archivo);

    }finally{
        Desconecta($conexion);
    }

    return $retorno;
}

function RetorneTours() {
    try {
        //1. Establecer conexión
        $conexion = Conecta();
        //2. Ejecutar consulta
        $resultado = $conexion->query("select tour_id, nombre_tour, imagen, tipoImagen from tours");
        
        if($conexion->error != ""){
            echo "Ocurrió un error al ejecutar la consulta: $conexion->error";
        }

        //Mostrar los resultados de la consulta
        MostrarTours($resultado);
        



    }catch (\PDOException $e) {
        echo "Error en base de datos: " . $e->getMessage();

        $fecha = date('d/m/Y H:i:s');
        $error = $e->getMessage();
        $archivo = fopen("BitacoraErrores.txt", "a");
        fwrite($archivo, "Fecha: $fecha -------- Error en base de datos: $error \n \n");
        fclose($archivo);

    }catch (\Throwable $th) {
        echo "Error: " . $th->getMessage();

        $fecha = date('d/m/Y H:i:s');
        $error = $th->getMessage();
        $archivo = fopen("BitacoraErrores.txt", "a");
        fwrite($archivo, "Fecha: $fecha -------- Error: $error \n \n");
        fclose($archivo);

    }finally{
        Desconecta($conexion);
    }
}


function MostrarTours($datos){
    echo "<table class='toursTable'>";

    if($datos->num_rows > 0){
        while ($row = $datos->fetch_assoc()){
            $imagen = base64_encode($row['imagen']);
            $tipo = $row['tipoImagen'];
            echo "<tr class='toursTR'>";
            echo "<td class='toursTD'> <img src='data:$tipo;charset=utf8;base64,".$imagen."'/> </td>";
            echo "<td class='toursTD'>{$row['nombre_tour']}</td>";
            echo "<td class='toursTD'><a href=\"tourEspecifico.php?id={$row['id']}\">Mostrar</a></td>";
            echo "</tr>";
        }
    }else {
        echo "<tr><td>No hay tours disponibles</td></tr>";
    }
    echo "</table>";
}


function mostrarTourEspecifico($id) {
    try {
        $conexion = Conecta();

        $resultado = $conexion->query("select id_tour, nombre_tour, descripcion_tour, fecha_tour, precio_tour, imagen, tipoImagen from tours where id = $id");
        
        if($conexion->error != ""){
            echo "Ocurrió un error al ejecutar la consulta: $conexion->error";
        }

        $datos = $resultado->fetch_assoc();

        $imagen = base64_encode($datos['imagen']);
        $tipo = $datos['tipoImagen'];

        echo "<div class='contenedorTourEspecifico'>";
        echo "<h2> {$datos['nombre_tour']} </h2>";

        echo "<img src='data:$tipo;charset=utf8;base64,".$imagen."'/>";
        
        echo "<p> {$datos['descripcion_tour']} </p>";

        echo "<p> Precio en colones: {$datos['precio_tour']} </p>";

        //Validar opciones si está logueado un admin o un user
        //La opcion de compra solo se mostrará si hay una session iniciada
        if (isset( $_SESSION['username'] ) ) {
            $rol = $_SESSION['rol'];

            if ($rol == "admin") {
                //Actualizar
                echo "<a href=\"actualizarTour.php?id_tour={$datos['id']}&nombre_tour={$datos['nombre_tour']}&descripcion_tour={$datos['descripcion_tour']}&precio_tour={$datos['precio_tour']}\">Actualizar</a>";
        
                //Eliminar
                echo "<a class='custom_tour' href=\"eliminarTour.php?id_tour={$datos['id_tour']}\">Eliminar</a>";
            }else{
                echo "<a class='custom_tour' href=\"pantallaCompra.php?id_tour={$datos['id_tour']}&nombre_tour={$datos['nombre_tour']}&precio_tour={$datos['precio_tour']}\">Comprar</a>"; //Esto enviará a la pantalla de compra
            }

        }      
        echo "</div>";

    }catch (\PDOException $e) {
        echo "Error en base de datos: " . $e->getMessage();

        $fecha = date('d/m/Y H:i:s');
        $error = $e->getMessage();
        $archivo = fopen("BitacoraErrores.txt", "a");
        fwrite($archivo, "Fecha: $fecha -------- Error en base de datos: $error \n \n");
        fclose($archivo);

    }catch (\Throwable $th) {
        echo "Error: " . $th->getMessage();

        $fecha = date('d/m/Y H:i:s');
        $error = $th->getMessage();
        $archivo = fopen("BitacoraErrores.txt", "a");
        fwrite($archivo, "Fecha: $fecha -------- Error: $error \n \n");
        fclose($archivo);

    }finally{
        Desconecta($conexion);
    }
}

function eliminarTourEspecifico($id) {
    try {
        $conexion = Conecta();

        //Se deben eliminar los registros de compra y comentarios que tenga asociados para poder eliminarlo
        $resultado1 = $conexion->query("delete from compras where idTour = $id");
        $resultado2 = $conexion->query("delete from comentarios where idTour = $id");
        $resultado = $conexion->query("delete from juegos where id = $id");
        
        if($conexion->error != ""){
            return false;
        }else{
            return true;
        }


    }catch (\PDOException $e) {
        echo "Error en base de datos: " . $e->getMessage();

        $fecha = date('d/m/Y H:i:s');
        $error = $e->getMessage();
        $archivo = fopen("BitacoraErrores.txt", "a");
        fwrite($archivo, "Fecha: $fecha -------- Error en base de datos: $error \n \n");
        fclose($archivo);

    }catch (\Throwable $th) {
        echo "Error: " . $th->getMessage();

        $fecha = date('d/m/Y H:i:s');
        $error = $th->getMessage();
        $archivo = fopen("BitacoraErrores.txt", "a");
        fwrite($archivo, "Fecha: $fecha -------- Error: $error \n \n");
        fclose($archivo);

    }finally{
        Desconecta($conexion);
    }
}


function editarTour($id, $nombre, $descripcion, $fecha, $precio) {
    try {
        //1. Establecer conexión
        $conexion = Conecta();
        
        if($conexion->error != ""){
            echo "Ocurrió un error al ejecutar la consulta: $conexion->error";
        }

        //Metodo clase
        //$conexion->query("update alumno set nombre=$nombre, correo=$correo, telefono=$telefono where id = $id");


        //Metodo aprendido funcional
        $query = "UPDATE tours SET nombre_tour='$nombre', descripcion_tour='$descripcion', fecha_tour='$fecha', precio_tour='$precio' WHERE id_tour= '$id'";
        mysqli_query($conexion, $query);
        
    }catch (\PDOException $e) {
        echo "Error en base de datos: " . $e->getMessage();

        $fecha = date('d/m/Y H:i:s');
        $error = $e->getMessage();
        $archivo = fopen("BitacoraErrores.txt", "a");
        fwrite($archivo, "Fecha: $fecha -------- Error en base de datos: $error \n \n");
        fclose($archivo);

    }catch (\Throwable $th) {
        echo "Error: " . $th->getMessage();

        $fecha = date('d/m/Y H:i:s');
        $error = $th->getMessage();
        $archivo = fopen("BitacoraErrores.txt", "a");
        fwrite($archivo, "Fecha: $fecha -------- Error: $error \n \n");
        fclose($archivo);

    }finally{
        Desconecta($conexion);
    }
}


function RetorneToursInventario($id) {
    try {
        //1. Establecer conexión
        $conexion = Conecta();
        //2. Ejecutar consulta
        $resultado = $conexion->query("select t.id_tour, t.nombre_tour, t.imagen, t.tipoImagen from tours t, compras c where t.id_tours = c.idJuego and c.idUsuario = $id");
        
        if($conexion->error != ""){
            echo "Ocurrió un error al ejecutar la consulta: $conexion->error";
        }

        //Mostrar los resultados de la consulta
        MostrarToursInventario($resultado);
        



    }catch (\PDOException $e) {
        echo "Error en base de datos: " . $e->getMessage();

        $fecha = date('d/m/Y H:i:s');
        $error = $e->getMessage();
        $archivo = fopen("BitacoraErrores.txt", "a");
        fwrite($archivo, "Fecha: $fecha -------- Error en base de datos: $error \n \n");
        fclose($archivo);

    }catch (\Throwable $th) {
        echo "Error: " . $th->getMessage();

        $fecha = date('d/m/Y H:i:s');
        $error = $th->getMessage();
        $archivo = fopen("BitacoraErrores.txt", "a");
        fwrite($archivo, "Fecha: $fecha -------- Error: $error \n \n");
        fclose($archivo);

    }finally{
        Desconecta($conexion);
    }
}


function MostrarToursInventario($datos){
    echo "<table>";

    if($datos->num_rows > 0){
        while ($row = $datos->fetch_assoc()){
            $imagen = base64_encode($row['imagen']);
            $tipo = $row['tipoImagen'];
            echo "<tr>";
            echo "<td> <img src='data:$tipo;charset=utf8;base64,".$imagen."'/> </td>";
            echo "<td>{$row['nombre_tour']}</td>";
            echo "<td><a href=\"descargasTours/descargarItenerario.php?nombre_tour={$row['nombre_tour']}\">Descargar</a></td>";
            echo "</tr>";
        }
    }else {
        echo "<tr><td>No hay tours disponibles</td></tr>";
    }
    echo "</table>";
}