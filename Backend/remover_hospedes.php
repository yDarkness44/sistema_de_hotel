<?php
session_start();
$email = $_SESSION['email'];

// Verificar se o id_hospede está definido
if (isset($_POST['id'])) {
    $id_hospede = $_POST['id'];

    // Conexão com o banco de dados
    $conn = new mysqli("localhost", "root", "", "sistema_hotel");
    if ($conn->connect_error) {
        die("Erro de conexão: " . $conn->connect_error);
    }

    // Consulta para remover o hóspede
    $stmt = $conn->prepare("DELETE FROM hospedes WHERE id = ?");
    $stmt->bind_param("i", $id_hospede);
    
    if ($stmt->execute()) {
        echo "Hóspede removido com sucesso.";
    } else {
        echo "Erro ao remover hóspede: " . $stmt->error;
    }

    // Fechar a conexão
    $stmt->close();
    $conn->close();
} else {
    echo "ID do hóspede não foi enviado.";
}
?>
