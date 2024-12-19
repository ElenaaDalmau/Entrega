<?php
header('Content-Type: application/json');
$servername = "localhost";
$username = "hola";
$password = "12345";
$dbname = "coaching";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$month = $_GET['month'];  // Por ejemplo, el mes de la URL: getEvents.php?month=12
$year = $_GET['year'];  // Año de la URL: getEvents.php?year=2024

$sql = "SELECT 
            c.Fecha_Cita, 
            c.Hora_Cita, 
            cli.Nombre_Cliente, 
            cli.Apellido_Cliente, 
            esp.Nombre_Especialista
        FROM 
            CITAS c
        JOIN 
            CLIENTES cli ON c.ID_Cliente_Cita = cli.ID_Cliente
        JOIN 
            ESPECIALISTAS esp ON c.ID_Especialista_Cita = esp.ID_Especialista
        WHERE 
            YEAR(c.Fecha_Cita) = $year AND MONTH(c.Fecha_Cita) = $month";

$result = $conn->query($sql);

$events = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $events[] = [
            'date' => $row['Fecha_Cita'],
            'title' => "Cita con " . $row['Nombre_Cliente'] . " " . $row['Apellido_Cliente'],
            'info' => "Hora: " . $row['Hora_Cita'] . " | Especialista: " . $row['Nombre_Especialista']
        ];
    }
}

echo json_encode($events);

$conn->close();
?>
