<?php
// Conexão com o banco de dados
$conn = new mysqli("localhost", "root", "", "sistema_hotel");
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Obter dados do formulário
$nome = $_POST['nome'];
$telefone = $_POST['telefone'];
$quarto = $_POST['quarto'];

// Inserir o hóspede no banco de dados
$stmt = $conn->prepare("INSERT INTO hospedes (nome, telefone, quarto) VALUES (?, ?, ?)");
$stmt->bind_param("ssi", $nome, $telefone, $quarto);

if ($stmt->execute()) {
    echo "Hóspede adicionado com sucesso";
} else {
    echo "Erro: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
