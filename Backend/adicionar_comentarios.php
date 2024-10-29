<?php
session_start();

// Verificar se o comentário foi enviado
if (isset($_POST['comentario'])) {
    $comentario = $_POST['comentario'];

    // Conexão com o banco de dados
    $conn = new mysqli("localhost", "root", "", "sistema_hotel");
    if ($conn->connect_error) {
        die("Erro de conexão: " . $conn->connect_error);
    }

    // Inserir o comentário no banco de dados
    $stmt = $conn->prepare("INSERT INTO comentarios (comentario) VALUES (?)");
    $stmt->bind_param("s", $comentario);
    
    if ($stmt->execute()) {
        $_SESSION['mensagem'] = "Comentário adicionado com sucesso!";
    } else {
        $_SESSION['mensagem'] = "Erro ao adicionar comentário: " . $stmt->error;
    }

    // Fechar a conexão
    $stmt->close();
    $conn->close();

    header("Location: ../Web/Painel-Controle/painel-controle-funcional"); // Redirecionar de volta
    exit();
}
?>
