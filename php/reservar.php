<?php
// Recibir y validar los datos del formulario
$nombre = $_POST["nombre"];
$email = $_POST["email"];
$fecha_ingreso = $_POST["fecha_ingreso"];
$fecha_salida = $_POST["fecha_salida"];

// Validar si los campos están completos
if (empty($nombre) || empty($email) || empty($fecha_ingreso) || empty($fecha_salida)) {
    echo "Todos los campos son obligatorios. Por favor, completa el formulario.";
} else {
    // Conectar a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "hotel_maravillas";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Insertar la reserva en la base de datos
    $sql = "INSERT INTO Reservas (hotel_id, habitacion_id, fecha_inicio, fecha_fin, cliente_nombre, cliente_email)
            VALUES (1, 1, '$fecha_ingreso', '$fecha_salida', '$nombre', '$email')";

    if ($conn->query($sql) === TRUE) {
        echo "Reserva realizada con éxito.";
    } else {
        echo "Error al realizar la reserva: " . $conn->error;
    }

    $conn->close();
}
?>
