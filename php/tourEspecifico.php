<?php
include_once 'include/template/header.php';

require 'include/funciones.php';
require 'include/funciones/recogeRequest.php';

$idJuego = recogeGet("id");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'include/funciones/recogeRequest.php';

    $comentario = recogePost("comentario");
    $idUsuario = $_SESSION['id'];

    require_once 'DAL/comentario.php';
    if (InsertarComentario($comentario, $idJuego, $idUsuario)) {
        require_once 'DAL/juego.php';
        mostrarJuegoEspecifico($idJuego);
    }
}
?>
<div class="contendorJuegos">
    <div>
        <?php
        require_once 'DAL/juego.php';
        mostrarTourEspecifico($idJuego);

        if (isset($_SESSION['username'])) {
            echo "<form method='POST'>";
            echo "<div>";
            echo "<h2> Comentarios </h2>";
            echo "<input type='text' id='comentario' name='comentario' maxlength='300' placeholder='Comentario'>";
            echo "</div>";

            echo "<br>";


            echo "<button type='submit' name='boton_especifico' class='custom-button'>Guardar</button>";
            echo "</form>";
        }

        require_once 'DAL/comentario.php';
        RetorneComentarios($idJuego);
        ?>
    </div>
</div>