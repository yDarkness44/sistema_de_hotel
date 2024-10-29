<?php
// Conexão com o banco de dados
$conn = new mysqli("localhost", "root", "", "sistema_hotel");
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Consultar a lista de hóspedes
$result = $conn->query("SELECT id, nome, telefone, quarto FROM hospedes");

$hospedes = [];
while ($row = $result->fetch_assoc()) {
    $hospedes[] = $row;
}

echo json_encode($hospedes);

$conn->close();
?>
