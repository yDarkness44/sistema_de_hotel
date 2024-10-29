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
$email = $_POST['email'];
$senha = $_POST['senha'];

// Preparar e executar a consulta
$stmt = $conn->prepare("SELECT email FROM empresas WHERE email = ? AND senha = ?");
$stmt->bind_param("ss", $email, $senha); // Define o tipo de parâmetro como string
$stmt->execute();
$stmt->store_result();

// Verificar se o usuário foi encontrado
if ($stmt->num_rows > 0) {
    // Iniciar a sessão e armazenar as informações do usuário
    session_start();
    $_SESSION['email'] = $email;

    // Redirecionar para o painel de controle
    header("Location: ../Web/Painel-Controle/painel-controle-funcional.php");
    exit;
} else {
    echo "Email ou senha incorretos.";
}

// Fechar a conexão
$stmt->close();
$conn->close();
?>
