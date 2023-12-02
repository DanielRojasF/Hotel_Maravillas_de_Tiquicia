<!-- Para uso exclusivo de un usuario administrador -->
<?php
include_once 'include/template/header.php'; 

require 'include/funciones.php';
require_once 'DAL/conexion.php';
require 'include/funciones/recogeRequest.php';
require_once 'DAL/tour.php';

$id = recogeGet("id_tour");
$nombre = recogeGet("nombre_tour");
$descripcion = recogeGet("descripcion_tour");
$precio = recogeGet("precio_tour");


// Validar el método de solicitud
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'include/funciones/recogeRequest.php';

    // Validar y sanitizar los datos recibidos por POST
    $Enombre = recogePost("nombre-tour");
    $Edescripcion = recogePost("descripcion-tour");
    $Eprecio = recogePost("precio-tour");

    // Validar y sanitizar los datos antes de usarlos en la base de datos
    $Enombre = filter_var($Enombre, FILTER_SANITIZE_STRING);
    $Edescripcion = filter_var($Edescripcion, FILTER_SANITIZE_STRING);
    $Eprecio = filter_var($Eprecio, FILTER_VALIDATE_INT);

    // Validar que los datos sean válidos antes de continuar
    if ($Enombre && $Edescripcion && $Eprecio !== false) {
        // Actualizar el juego en la base de datos
        require_once 'DAL/juego.php';
        editarTour($id, $Enombre, $Edescripcion, $Eprecio); 
        
        // Redirigir después de la actualización
        header("Location: tour.php");
        exit; // Prevenir que el código siga ejecutándose
    }
}

?>

    <main class="contenedorInsertarJuegos">
        <div class="contendor">

            <header class="header">
                <h2>Actualizar Tour</h2>
            </header>

            <form method="POST" enctype="multipart/form-data">
                <div>
                    <label for="nombre_tour">Nombre del Tour</label>
                    <input type="text" value="<?php echo $nombre;?>" id="nombre" name="nombre-tour" maxlength="50" placeholder="Nombre del Tour">
                </div>

                <div>
                    <label for="descripcion_tour">Descripcion</label> <br>
                    <input type="text" value="<?php echo $descripcion;?>" id="descripcion" maxlength="300" name="descripcion-tour" placeholder="Descripcion del tour">
                </div>

                <div>
                    <label for="precio_tour">Precio</label> <br>
                    <input type="number" value="<?php echo $precio;?>" id="precio_tour" name="precio-tour" maxlength="20" placeholder="Precio en colones">
                </div>

                <!-- hay que modificar para actualizar imagen tambien <div>
                    <label for="imagen">Imagen</label><br>
                    <input type="file" class="form-control-file" id="imagen" name="imagen-tour">
                </div> -->

                <br>

                <button type="submit" name="guardar">Guardar</button>
            </form>


        </div>

    </main>