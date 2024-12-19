<?php

// Evitar la exposición de credenciales en el código
$servername = getenv('DB_SERVER') ?: 'localhost';
$username = getenv('DB_USER') ?: 'Cache3815';
$password = getenv('DB_PASS') ?: 'z1fVrI&ZVfyonsZ';
$dbname = getenv('DB_NAME') ?: 'COACHING';

// Configuración de la conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión
if ($conn->connect_error) {
    error_log("Error de conexión: " . $conn->connect_error);
    die(json_encode(["error" => "Error interno en el servidor."]));
}


// Obtener el ID del cliente (usuario) desde la URL
$id_cliente = filter_var($_GET['id_cliente'] ?? null, FILTER_VALIDATE_INT);
$mes = filter_var($_GET['mes'] ?? date('n'), FILTER_VALIDATE_INT);
$año = filter_var($_GET['año'] ?? date('Y'), FILTER_VALIDATE_INT);

if (!$id_cliente || !$mes || !$año) {
    die(json_encode(["error" => "Parámetros inválidos."]));
}
// Consulta para obtener las citas ocupadas del cliente para el mes y año especificados
$sql = "SELECT c.Fecha_Cita, c.Hora_Cita, e.Nombre_Especialista, e.Apellido_Especialista
        FROM CITAS c
        JOIN ESPECIALISTAS e ON c.ID_Especialista_Cita = e.ID_Especialista
        WHERE c.ID_Cliente_Cita = ? AND MONTH(c.Fecha_Cita) = ? AND YEAR(c.Fecha_Cita) = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $id_cliente, $mes, $año);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Retornar el JSON
header('Content-Type: application/json');
echo json_encode($data);
$stmt->close();
$conn->close();
?>
