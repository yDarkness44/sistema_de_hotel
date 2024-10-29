<?php
session_start();

// Verificar se o id do comentário está definido
if (isset($_POST['id'])) {
    $id_comentario = $_POST['id'];

    // Conexão com o banco de dados
    $conn = new mysqli("localhost", "root", "", "sistema_hotel");
    if ($conn->connect_error) {
        die("Erro de conexão: " . $conn->connect_error);
    }

    // Remover o comentário
    $stmt = $conn->prepare("DELETE FROM comentarios WHERE id = ?");
    $stmt->bind_param("i", $id_comentario);
    
    if ($stmt->execute()) {
        $_SESSION['mensagem'] = "Comentário removido com sucesso!";
    } else {
        $_SESSION['mensagem'] = "Erro ao remover comentário: " . $stmt->error;
    }

    // Fechar a conexão
    $stmt->close();
    $conn->close();

    header("Location: ../Web/Painel-Controle/painel-controle-funcional"); // Redirecionar de volta
    exit();
}
?>
