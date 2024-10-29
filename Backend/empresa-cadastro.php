<?php
// Configurações do banco de dados
$servername = "localhost";
$username = "root"; // usuário padrão
$password = ""; // senha em branco
$dbname = "sistema_hotel";
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Obter dados do formulário
$email = $_POST['email'];
$senha = $_POST['senha'];
$nome_empresa = $_POST['nome_empresa'];
$quantidade_quartos = $_POST['quantidade_quartos'];

// Preparar e vincular
$stmt = $conn->prepare("INSERT INTO empresas (email, senha, nome_empresa, quantidade_quartos) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $email, $senha, $nome_empresa, $quantidade_quartos);

// Executar
if ($stmt->execute()) {
    // Redirecionar para a página de login após o cadastro
    header("Location: ../Web/Painel-Controle/painel-controle-login.html");
    exit;
} else {
    echo "Erro: " . $stmt->error;
}

// Fechar a conexão
$stmt->close();
$conn->close();
?>
