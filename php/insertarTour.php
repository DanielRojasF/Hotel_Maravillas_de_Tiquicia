<!-- Para uso exclusivo de un usuario administrador -->
<?php
include_once 'include/template/header.php';

require 'include/funciones.php';
require_once 'DAL/conexion.php';

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'include/funciones/recogeRequest.php';

    $nombre = recogePost("nombre-tour");
    $descripcion = recogePost("descripcion-tour");
    $precio = recogePost("precio-tour");

    $nombreOK = false;
    $descripcionOK = false;
    $precioOK = false;

    if ($nombre === "") {
        $errores[] = "No ingresó el nombre del tour";
    } else {
        $nombreOK = true;
    }

    if ($descripcion === "") {
        $errores[] = "No ingresó la descripción del tour";
    } else {
        $descripcionOK = true;
    }

    if ($costo === "") {
        $errores[] = "No ingresó el precio del tour";
    } else {
        $costoOK = true;
    }

    //Procesar la imagen
    if (isset($_REQUEST['guardar'])) {
        if (isset($_FILES['imagen-tour']['name'])) {
            $tipoArchivo = $_FILES['imagen-tour']['type'];
            //$nombreArchivo=$_FILES['imagen-tour']['name'];
            $tamanoArchivo = $_FILES['imagen-tour']['size'];

            //Extraer binarios
            $imagenSubida = fopen($_FILES['imagen-tour']['tmp_name'], 'r');
            $binariosImagen = fread($imagenSubida, $tamanoArchivo);

            $conexion = Conecta();

            $binariosImagen = mysqli_escape_string($conexion, $binariosImagen);
        }
    }



    if ($nombreOK && $descripcion && $precio) {
        //Enviar los datos a base de datos, podria hacerse una validacion para que el archivo si esté subido
        require_once 'DAL/tour.php';
        if (InsertarTour($nombre, $descripcion, $precio, $binariosImagen, $tipoArchivo)) {
            header("Location: tienda.php");
        }
    }
}

?>

<main class="contenedorInsertarTour">
    <div class="contendor">

        <header class="header">
            <h2>Insertar Tour</h2>
        </header>

        <?php foreach ($errores as $error) : ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>

        <form method="POST" enctype="multipart/form-data">
            <div>
                <label for="nombre_tour">Nombre del Tour</label>
                <input type="text" id="nombre_tour" name="nombre-tour" maxlength="50" placeholder="Nombre del tour">
            </div>

            <div>
                <label for="descripcion_tour">Descripcion</label> <br>
                <textarea rows="10" cols="40" id="descripcion_tour" maxlength="300" name="descripcion-tour" placeholder="Descripcion del tour"></textarea>
            </div>

            <div>
                <label for="precio_tour">Precio</label> <br>
                <input type="number" id="precio_tour" name="precio-tour" maxlength="20" placeholder="Precio en colones">
            </div>

            <div class="subir_imagen">
                <input type="file" class="form-control-file" id="imagen" name="imagen-tour">
                <label for="imagen">Seleccionar imagen</label>
            </div>


            <br>

            <button type="submit" name="guardar">Guardar</button>
        </form>

    </div>

</main>