/* Autor ; Rodrigo Matheus 
Pit II - ano 2024
Projeto: site Hydratech*/

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Site</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* CSS para o botão e o menu lateral */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9; /* Cor de fundo do corpo */
        }

        .container {
            display: flex;
            flex-direction: row;
            min-height: 100vh;
            padding: 20px; /* Espaçamento interno para a container */
            box-sizing: border-box; /* Para incluir o padding na largura total */
        }

        .main-content {
            flex: 1;
            padding: 20px;
            padding-top: 60px;
            background-color: white; /* Cor de fundo para o conteúdo */
            border-radius: 8px; /* Bordas arredondadas */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Sombra leve */
            margin-left: 20px; /* Espaçamento da esquerda */
            margin-right: 20px; /* Espaçamento da direita */
        }

        .sidebar {
            width: 200px;
            background-color: #f4f4f4;
            padding: 20px;
            position: fixed;
            left: -200px; /* Começa fora da tela */
            top: 0;
            height: 100%;
            transition: left 0.3s; /* Transição suave */
        }

        .sidebar.show {
            left: 0; /* Move para dentro da tela */
        }

        .menu-button {
            position: fixed;
            top: 20px;
            left: 20px;
            background-color: #fff; /* Cor de fundo branca */
            color: #0066cc; /* Cor do texto */
            border: none;
            border-radius: 50%; /* Bordas arredondadas */
            padding: 15px; /* Espaçamento interno */
            cursor: pointer;
            z-index: 1000; /* Para garantir que o botão fique acima de outros elementos */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Sombra leve para o botão */
            transition: background-color 0.3s; /* Transição suave para a cor de fundo */
        }

        .menu-button:hover {
            background-color: #e0e0e0; /* Cor ao passar o mouse */
        }

        .footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px;
            position: relative; /* Ajusta para o rodapé ficar na parte inferior do conteúdo */
            bottom: 0;
            width: 100%;
            left: 0;
        }

        /* Banner */
        .header-banner {
            background-color: #066cc; /* Cor de fundo para o banner */
            text-align: center;
            padding: 20px 0; /* Ajusta a altura do banner */
            width: 100%;
            box-sizing: border-box;
        }

        .header-banner .logo {
            max-height: 290px; /* Ajusta o tamanho da logo */
            width: 1250px;
        }

        /* Mensagens de sucesso e erro */
        .success {
            color: green;
        }

        .error {
            color: red;
        }

        /* Estilos do carrossel */
        .carousel {
            position: relative;
            overflow: hidden;
            margin-top: 20px; /* Espaço acima do carrossel */
        }

        .carousel-images {
            display: flex;
            transition: transform 0.2s ease;
        }

        .carousel-images img {
            width: 100%;
            max-height: 400px; /* Altura máxima das imagens */
            object-fit: cover; /* Para cobrir o espaço mantendo a proporção */
        }

        .carousel-button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(255, 255, 255, 0.7);
            border: none;
            cursor: pointer;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        }

        .carousel-button.left {
            left: 10px;
        }

        .carousel-button.right {
            right: 10px;
        }
    </style>
</head>
<body>
    <?php
    $mensagemSucesso = "";
    $mensagemErro = "";

    // Verifica se o formulário de contato foi enviado
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['page']) && $_GET['page'] == 'contato') {
        $nome = htmlspecialchars(trim($_POST['nome']));
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
        $assunto = htmlspecialchars(trim($_POST['assunto']));
        $mensagem = htmlspecialchars(trim($_POST['mensagem']));
        
        // Verifica se o e-mail é válido
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $mensagemErro = "E-mail inválido.";
        } else {
            // Configurações do e-mail
            $to = "contato@hydratech.com.br";
            $subject = "Contato de $nome: $assunto";
            $body = "Nome: $nome\nEmail: $email\nAssunto: $assunto\n\nMensagem:\n$mensagem";
            $headers = "From: $email";

            // Envia o e-mail
            if (mail($to, $subject, $body, $headers)) {
                $mensagemSucesso = "Mensagem enviada com sucesso!";
            } else {
                $mensagemErro = "Erro ao enviar a mensagem. Tente novamente.";
            }
        }
    }
    ?>
    
    <!-- Banner -->
    <div class="header-banner">
        <img src="logo.jpg" alt="Hydratech - Soluções em PeAD" class="logo">
    </div>
    
    <div class="container">
        <!-- Botão para abrir/fechar o menu lateral -->
        <button class="menu-button" onclick="toggleMenu()">☰</button>

        <!-- Menu lateral -->
        <div class="sidebar" id="sidebar">
            <a href="index.php?page=home">Home</a>
            <a href="index.php?page=servicos">Serviços</a>
            <a href="index.php?page=contato">Contato</a>
            <a href="index.php?page=quem_somos">Quem Somos</a>
            <button class="close-menu" onclick="toggleMenu()">Fechar Menu</button>
        </div>

        <!-- Conteúdo principal -->
        <div class="main-content">
            <?php
            // Define o conteúdo com base na página selecionada
            $pagina = isset($_GET['page']) ? $_GET['page'] : 'home';

            switch($pagina) {
                case 'home':
                    echo "<h1>Bem-vindo à Hydratech</h1>";
                    echo "<p>Na Hydratech, somos especialistas em soluções de PEAD (Polietileno de Alta Densidade) para projetos de saneamento, indústria e infraestrutura, oferecendo serviços de alta qualidade e durabilidade.</p>";
                    
                    echo "<h2>Missão, Visão e Valores</h2>";
                    echo "<p><strong>Missão:</strong> Modernizar o saneamento e promover soluções sustentáveis e de alta durabilidade em PEAD.</p>";
                    echo "<p><strong>Visão:</strong> Ser referência nacional em soluções de PEAD, impactando positivamente os setores de infraestrutura e saneamento.</p>";
                    echo "<p><strong>Valores:</strong> Compromisso com a qualidade, inovação contínua e foco na sustentabilidade e na satisfação do cliente.</p>";

                    echo "<h2>Nossos Serviços</h2>";
                    echo "<ul>
                            <li>Solda em PEAD</li>
                            <li>Acessórios completos para conexões e transições PEAD</li>
                            <li>Visitas técnicas e releitura de projetos</li>
                          </ul>";
                    echo "<p>Explore a seção de <a href='index.php?page=servicos'>Serviços</a> para saber mais sobre como podemos apoiar seu projeto.</p>";

                    echo "<h2>Diferenciais Hydratech</h2>";
                    echo "<p>Nossos serviços são realizados por uma equipe qualificada, com equipamentos de última geração, garantindo a máxima eficiência e durabilidade para nossos clientes.</p>";
                    echo "<p>Convidamos você a conhecer mais sobre nossos <a href='index.php?page=quem_somos'>Valores e Benefícios</a>.</p>";
                    
                    echo "<h2>Solicite seu Orçamento</h2>";
                    echo "<p>Entre em contato conosco e saiba mais sobre as soluções que a Hydratech oferece para otimizar e modernizar seu projeto.</p>";
                    echo "<p><a href='index.php?page=contato'>Clique aqui para falar conosco!</a></p>";
                    break;

                case 'servicos':
                    echo "<h1>Serviços</h1>";
                    echo "<p>SOLICITE SEU ORÇAMENTO:</p>";
                    echo "<div class='carousel'>";
                    echo "<div class='carousel-images'>";
                    echo "<img src='imagem2.jpeg' alt='Serviço 2'>";
                    echo "<img src='imagem3.jpeg' alt='Serviço 3'>";
                    echo "<img src='imagem4.jpeg' alt='Serviço 4'>";
                    echo "<img src='imagem5.jpeg' alt='Serviço 5'>";
                    echo "<img src='imagem6.jpeg' alt='Serviço 6'>";
                    echo "<img src='imagem7.jpeg' alt='Serviço 7'>";
                    echo "<img src='imagem8.jpeg' alt='Serviço 8'>";
                    echo "<img src='imagem9.jpeg' alt='Serviço 9'>";
                    echo "<img src='imagem10.jpeg' alt='Serviço 10'>";
                    echo "<img src='imagem11.jpeg' alt='Serviço 11'>";
                    echo "<img src='imagem12.jpeg' alt='Serviço 12'>";
                    echo "</div>";
                    echo "<button class='carousel-button left' onclick='moveSlide(-1)'>&lt;</button>";
                    echo "<button class='carousel-button right' onclick='moveSlide(1)'>&gt;</button>";
                    echo "</div>";
                    echo "<ul>
                            <li>Execução de serviços de solda em PEAD, PP ou PPR</li>
                            <li>Linha completa de acessórios em PEAD, incluindo conexões de eletrofusão</li>
                            <li>Conexões mecânicas em PP</li>
                            <li>Transições PEAD x Aço</li>
                            <li>Visita técnica para análise de projetos</li>
                            <li>Orçamentos personalizados para cada necessidade</li>
                            <li>Releitura de projetos e quantitativos de peças</li>
                          </ul>";
                    break;

                case 'contato':
                    echo "<h1>Contato</h1>";
                    if ($mensagemSucesso) {
                        echo "<p class='success'>$mensagemSucesso</p>";
                    }
                    if ($mensagemErro) {
                        echo "<p class='error'>$mensagemErro</p>";
                    }
                    echo '<form method="POST" action="index.php?page=contato">
                            <label for="nome">Nome:</label>
                            <input type="text" id="nome" name="nome" required><br><br>
                            
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" required><br><br>
                            
                            <label for="assunto">Assunto:</label>
                            <input type="text" id="assunto" name="assunto" required><br><br>
                            
                            <label for="mensagem">Mensagem:</label>
                            <textarea id="mensagem" name="mensagem" rows="4" required></textarea><br><br>
                            
                            <input type="submit" value="Enviar">
                          </form>';
                    break;

                case 'quem_somos':
                    echo "<h1>Quem Somos?</h1>";
                    echo "<p>Hydratech foi fundada com o objetivo de tornar o futuro presente e modernizar o saneamento. Especialista em soluções em PEAD (Polietileno de Alta Densidade) com alta durabilidade e qualidade.</p>";
                    echo "<p>Atendemos projetos e obras de todos os segmentos de distribuição de água, gás, biogás, saneamento, esgoto, irrigações, redes de combate a incêndio e linhas industriais, químico e farmacêuticos.</p>";
                    echo "<p>Nossa equipe é formada por profissionais altamente qualificados, sempre dispostos a atender nossos clientes com excelência.</p>";
                    break;

                default:
                    echo "<h1>Página não encontrada</h1>";
                    break;
            }
            ?>
        </div>
    </div>

    <!-- Rodapé -->
    <div class="footer">
        <p>Endereço: Rua Angelin Mosele 405 - Irati - PR</p>
        <p>Telefone: (42) 99963-7458</p>
        <p>Redes sociais: <a href="https://www.instagram.com/hydratech_pr/" target="_blank">Instagram</a></p>
        <p><a href="https://maps.app.goo.gl/PeX42L1fQGA5YLna8" target="_blank">Ver no mapa</a></p>
        <p>Email: <a href="mailto:comercial@hydratech.com.br">comercial@hydratech.com.br</a></p>
    </div>

    <script>
        // Função para mostrar/ocultar o menu lateral
function toggleMenu() {
    var sidebar = document.getElementById('sidebar');
    var menuButton = document.querySelector('.menu-button');
    var closeButton = document.querySelector('.close-menu');

    sidebar.classList.toggle('show');

    // Esconder ou mostrar o botão do menu e o botão "Fechar Menu"
    if (sidebar.classList.contains('show')) {
        menuButton.style.display = 'none'; // Esconde o botão do menu
        closeButton.style.display = 'block'; // Mostra o botão "Fechar Menu"
    } else {
        menuButton.style.display = 'block'; // Mostra o botão do menu
        closeButton.style.display = 'none'; // Esconde o botão "Fechar Menu"
    }
}

        // Carrossel de imagens
        let slideIndex = 0;
        const slides = document.querySelectorAll('.carousel-images img');

        function showSlide(index) {
            const totalSlides = slides.length;
            slideIndex = (index + totalSlides) % totalSlides; // Looping no carrossel
            const offset = -slideIndex * 100; // Movendo os slides para a esquerda
            document.querySelector('.carousel-images').style.transform = `translateX(${offset}%)`;
        }

        function moveSlide(n) {
            showSlide(slideIndex + n);
        }

        // Exibir o primeiro slide ao carregar a página
        showSlide(slideIndex);
    </script>
</body>
</html>
