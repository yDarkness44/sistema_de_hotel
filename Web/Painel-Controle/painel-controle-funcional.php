<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Controle - Sistema de Hotel</title>
    <link rel="stylesheet" href="../Estilos/estilo1.css">
    <link rel="stylesheet" href="../Estilos/estilo-cadastro.css">
    <link rel="stylesheet" href="../Estilos/estilo-login.css">
    <link rel="stylesheet" href="../Estilos/painel-controle.css">
</head>
<body class="corpo-da-pagina">

    <!-- Barra de navegação -->
    <section class="barra-de-navegacao">
        <header class="header-navegacao">
            <div id="header-navegacao-imagem">
                <a href="../Paginas Web/pagina-logada.html"><img src="../Imagens/Icons/bedside-table.png" alt="Ícone logo" id="div-imagem-logo"></a>
            </div>
            <div id="header-navegacao-div-logo">
                <h1><strong id="titulo-palavra-blue">Blue</strong><strong id="titulo-palavra-host">Host</strong> <strong id="titulo-palavra-solutions">Solutions</strong></h1>
                <h2>A melhor ferramenta para controle de hóspedes!</h2>
            </div>
            <div class="header-navegacao-entrar-empresa">
                <div id="header-navegacao-empresa-entrar-botao"><a href="../Paginas Web/pagina-home.html">Sair</a></div>
            </div>
        </header>
    </section>

    <!-- Conteúdo do Painel de Controle -->
    <main class="painel-controle">
        <!-- Seção de informações da empresa -->
        <section class="informacoes-empresa">
            <h2>Informações da Empresa</h2>
            <?php
                session_start();
                $email = $_SESSION['email'];

                // Conexão com o banco de dados
                $conn = new mysqli("localhost", "root", "", "sistema_hotel");
                if ($conn->connect_error) {
                    die("Erro de conexão: " . $conn->connect_error);
                }

                // Consulta para obter informações da empresa
                $stmt = $conn->prepare("SELECT nome_empresa, quantidade_quartos FROM empresas WHERE email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->bind_result($nome_empresa, $quantidade_quartos);
                $stmt->fetch();

                // Exibir as informações da empresa
                if ($nome_empresa && $quantidade_quartos) {
                    echo "<p><strong>Nome da Empresa:</strong> $nome_empresa</p>";
                    echo "<p><strong>Quantidade de Quartos:</strong> $quantidade_quartos</p>";
                } else {
                    echo "<p>Informações não encontradas.</p>";
                }

                // Fechar a conexão
                $stmt->close();
                $conn->close();
            ?>
        </section>

        <!-- Verifica se há uma mensagem para exibir -->
        <?php
            if (isset($_SESSION['mensagem'])) {
                echo "<div id='notification' class='notification'>{$_SESSION['mensagem']}</div>";
                unset($_SESSION['mensagem']); // Limpa a mensagem após exibi-la
            }
        ?>
    </main>

    <main class="painel-controle">
        <!-- Abas de funcionalidades -->
        <div class="abas">
            <button onclick="abrirAba('adicionarHospede')">Adicionar Hóspede</button>
            <button onclick="abrirAba('listaHospedes')">Lista de Hóspedes</button>
            <button onclick="abrirAba('comentarios')">Comentários</button>
        </div>

        <!-- Conteúdo das Abas -->
        <section id="adicionarHospede" class="conteudo-aba">
            <h2>Adicionar Hóspede</h2>
            <form action="../../Backend/adicionar_hospede.php" method="post" id="form-adicionar-hospede">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>

                <label for="telefone">Telefone:</label>
                <input type="text" id="telefone" name="telefone" required>

                <label for="quarto">Quarto:</label>
                <input type="number" id="quarto" name="quarto" required>

                <button type="submit">Adicionar Hóspede</button>
            </form>
        </section>

        <section id="listaHospedes" class="conteudo-aba" style="display: none;">
            <h2>Lista de Hóspedes</h2>
            <?php
                // Conexão com o banco de dados
                $conn = new mysqli("localhost", "root", "", "sistema_hotel");
                if ($conn->connect_error) {
                    die("Erro de conexão: " . $conn->connect_error);
                }

                // Consulta para obter os hóspedes
                $sql = "SELECT id, nome, telefone, quarto FROM hospedes";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo "<table><tr><th>Nome</th><th>Telefone</th><th>Quarto</th><th>Ações</th></tr>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['nome']}</td>
                                <td>{$row['telefone']}</td>
                                <td>{$row['quarto']}</td>
                                <td>
                                    <form action='../../Backend/remover_hospedes.php' method='post' style='display:inline;'>
                                        <input type='hidden' name='id' value='{$row['id']}'>
                                        <button type='submit'>Remover</button>
                                    </form>
                                </td>
                            </tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>Nenhum hóspede adicionado.</p>";
                }

                $conn->close();
            ?>
        </section>

        <!-- Seção de Comentários -->
        <section id="comentarios" class="conteudo-aba" style="display: none;">
            <h2>Comentários</h2>
            <form action="../../Backend/adicionar_comentarios.php" method="post">
                <label for="comentario">Digite seu comentário:</label>
                <textarea id="comentario" name="comentario" required></textarea>
                <button type="submit">Adicionar Comentário</button>
            </form>

            <h3>Lista de Comentários</h3>
            <?php
                // Conexão com o banco de dados
                $conn = new mysqli("localhost", "root", "", "sistema_hotel");
                if ($conn->connect_error) {
                    die("Erro de conexão: " . $conn->connect_error);
                }

                // Consulta para obter os comentários
                $sql = "SELECT id, comentario FROM comentarios";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo "<table><tr><th>Comentário</th><th>Ações</th></tr>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['comentario']}</td>
                                <td>
                                    <form action='../../Backend/remover_comentarios.php' method='post' style='display:inline;'>
                                        <input type='hidden' name='id' value='{$row['id']}'>
                                        <button type='submit'>Remover</button>
                                    </form>
                                </td>
                            </tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>Nenhum comentário encontrado.</p>";
                }

                $conn->close();
            ?>
        </section>
    </main>

    <!-- Rodapé -->
    <footer class="footer">
        <div class="footer-conteudo">
            <p>Contato: <a href="mailto:seuemail@exemplo.com">joaojott44@gmail.com</a></p>
            <p>Telefone: (88) 98855-0170</p>
            <p>Desenvolvido em 2024</p>
            <p>&copy; 2024 Todos os direitos reservados.</p>
        </div>
    </footer>

    <script src="../../Scripts/abas.js"></script>
    <script src="../../Scripts/adicionar-hospedes.js"></script>
    <script src="../../Scripts/carregar-remover-hospedes.js"></script>
</body>
</html>
