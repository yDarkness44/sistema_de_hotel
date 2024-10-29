<?php
// Configurações do banco de dados
$servername = "localhost";
$username = "root"; // usuário padrão
$password = ""; // senha em branco
$dbname = "sistema_hotel";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Obter dados do formulário
$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];
$tipo = $_POST['tipo'];

// Preparar e vincular
$stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha, tipo) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $nome, $email, $senha, $tipo);

// Executar
if ($stmt->execute()) {
    // Redirecionar para a página de login após o cadastro
    header("Location: ../Web/Cadastro-Login/login.html");
    exit;
} else {
    echo "Erro: " . $stmt->error;
}

// Fechar a conexão
$stmt->close();
$conn->close();
?>
