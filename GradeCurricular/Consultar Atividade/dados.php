<?php

session_start();

if (isset($_SESSION['matricula_usuario'])) {
    require_once '../../conexao/conexao.php';

    $chave = $_POST['pesquisa'];

    // Consulta para obter os dados do trabalho
    $queryTrabalho = "SELECT * FROM trabalhos WHERE titulo = :chave";
    $pdoResultTrabalho = $conexao->prepare($queryTrabalho);
    $pdoResultTrabalho->execute(array(":chave" => $chave));
    $dadosDoTrabalho = $pdoResultTrabalho->fetch(PDO::FETCH_ASSOC);

    if ($dadosDoTrabalho) {
        // Preencha as variáveis com os dados do trabalho
        $titulo = $dadosDoTrabalho['titulo'];
        $data_inicio = $dadosDoTrabalho['data_inicio'];
        $data_final = $dadosDoTrabalho['data_final'];
        $quantidade_pessoas = $dadosDoTrabalho['quantidade'];
        $feedback_aluno = $dadosDoTrabalho['feedback_aluno'];
        $competencias_fk = $dadosDoTrabalho['competencias_fk'];
        $categoria_fk = $dadosDoTrabalho['categoria_fk'];
        $decricao = $dadosDoTrabalho['descricao'];
        $anexo = $dadosDoTrabalho['anexo_atividade']; // corrigido para usar a coluna correta

    } else {
        echo 'Erro ao recuperar os dados do trabalho.';
        exit;
    }
} else {
    echo 'Você não está logado ou não tem permissão para acessar esta página.';
    exit;
}

?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grade Curricular</title>
    <link rel="stylesheet" href="style3.css">
</head>

<body>
    <div class="navbar">
        <ul>
            <a href="pag1.html"><img style="width: 250px;" src="../img/logo.png" alt=""></a>
            <div class="entrar"><a href="../../perfil/perfil.html">
                    <div class="entraricon">
                        <img style="height: 40px;" src="../img/icon.svg" alt="">
                    </div>
                </a>
            </div>
        </ul>
    </div>
    <div>
        <h1 id="titulo">Consultar</h1>
        <p id="subtitulo">Pesquise por trabalhos:</p>
        <br>
    </div>
    <div>
        <form class="formulario" action="dados.php" method="POST">
            <div class="input-2">
                <label for="titulo">nome aluno:</label><br>
                <input type="text" id="titulo" name="pesquisa" required class="inputS">
            </div>
            <div id="botao">
                <div>
                    <input type="submit">
                    <a class="button1" href="../Tela Inicial/TelaInicial.html">Voltar</a>
                </div>
            </div>
        </form>
    </div>

    <?php
    
    echo "
            <div class='print-atividade'>
            <div class='atividade'>
                <div class='titulo-atividade'>
                    <h2>Título</h2>
                    <p> $titulo</p>
                </div>
                <div class='data_inicio'>
                    <h2>Data de início </h2>
                    <p>$data_inicio</p>
                </div>
                <div class='data_final'>
                    <h2>Data de entrega</h2>
                    <p>$data_final</p>
                </div>
                <div class='quantidade_pessoas'>
                    <h2>Colaboração </h2>
                    <p>$quantidade_pessoas</p>
                </div>
                <div class='categorias'>
                    <h2>Categorias </h2>
                    <p> $categoria_fk</p>
                </div>
                <div class='competencias'>
                    <h2>Competências</h2>
                    <p> $competencias_fk</p>
                </div>
                <div class='arquivos-zip'>
                    $anexo
                </div>
            </div>
            </div>";
    ?>

</body>

</html>