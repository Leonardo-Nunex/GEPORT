<?php 
session_start();

if (isset($_SESSION['matricula_usuario'])) {
    require_once '../conexao/conexao.php';

    $matriculaUsuario = $_SESSION['matricula_usuario'];

    // Consulta para obter os dados do USUARIO  
    $queryUsuario = "SELECT * FROM usuario WHERE matricula_usuario = :matricula_usuario";
    $pdoResultUsuario = $conexao->prepare($queryUsuario);
    $pdoResultUsuario->execute(array(":matricula_usuario" => $matriculaUsuario));
    $dadosDoUsuario = $pdoResultUsuario->fetch(PDO::FETCH_ASSOC);

    // Consulta para obter os dados do TRABALHOS 

    // $queryTrabalho = "select * from chamar_trabalhos(:chave);";

    $queryTrabalho = "SELECT titulo, data_inicio, data_final, quantidade, competencias_fk, anexo_atividade, descricao, 
    competencias.competencias AS nome_competencia, categoria.categoria AS nome_categoria
    FROM trabalhos
    LEFT JOIN competencias ON trabalhos.competencias_fk = competencias.id_competencias 
    LEFT JOIN categoria ON trabalhos.categoria_fk = categoria.id_categoria
    WHERE trabalhos.matricula_usuario_fk = :chave;";

    $pdoResultTrabalho = $conexao->prepare($queryTrabalho);

    $pdoResultTrabalho->execute(array(":chave" => $matriculaUsuario));

    $dadosDosTrabalhos = $pdoResultTrabalho->fetchAll(PDO::FETCH_ASSOC);

    if ($dadosDoUsuario) {
        $nomeUsuario = $dadosDoUsuario['nome_usuario'];
        $telefone = $dadosDoUsuario['telefone'];
        $email = $dadosDoUsuario['email'];
    } else {
        echo 'Erro ao recuperar os dados do usuário.';
        exit;
    }
} else {
    echo 'Você não está logado ou não tem permissão para acessar esta página.';
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Perfil do Usuário</title>
    <link rel="stylesheet" href="perfil.css">
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
</head>

<body>
    <div class="sidebar">
        <img src="https://via.placeholder.com/100" alt="Profile Picture" class="profile-pic">
        <div class="profile-info">
            <h2><?php echo $nomeUsuario?></h2>
            <p>Descrição do perfil</p>
        </div>
        <div class="contact-info">
            <h3>Contatos</h3>
            <p>Email: <?php echo $email?></p>
            <p>Telefone: <?php echo $telefone?></p>
        </div>
        <div class="botoes">
            <button class="btn-atualizar"><a href="../atualizar/atualizar.php">Atualizar Dados</a></button>
            <button class="btn-atualizar"><a href="../GradeCurricular/Cadastrar Portfolio/cadastro.html">Adicionar Portfólio</a></button>
            <div class="botoes_bottom">
                <button id="btn-voltar"><a href="../GradeCurricular/Tela Inicial/TelaInicial.html">Voltar</a></button>
                <button id="btn-sair"><a href="../Encerrar Sessao/logout.php">Sair</a></button>
            </div>
           
        </div>
    </div>

    <div class="cards-container">
    <?php
        if($dadosDosTrabalhos){
            foreach ($dadosDosTrabalhos as $dadosDoTrabalho) {
                $titulo = $dadosDoTrabalho['titulo'];
                $dataInicio = $dadosDoTrabalho['data_inicio'];
                $dataFinal = $dadosDoTrabalho['data_final'];
                $quantidadePessoas = $dadosDoTrabalho['quantidade'];
                $competencias = $dadosDoTrabalho['competencias_fk'];
                $decricao = $dadosDoTrabalho['descricao'];
                $anexo = $dadosDoTrabalho['anexo_atividade'];
                $nomeCompetencia = $dadosDoTrabalho['nome_competencia'];
                $categoria = $dadosDoTrabalho['nome_categoria'];
            
                echo "
                    <div class='card_trabalhos'>
                        <h1> $titulo</h1>
                        <h2>Data:</h2>
                        <p>$dataInicio / $dataFinal</p>
                        <p>$quantidadePessoas</p>
                        <p>$categoria</p>
                        <p> $nomeCompetencia</p>
                        <a href='../baixarTrabalhos/download_arquivo.php?id=$anexo' id='downloadTrabalho'>
                            <p>$anexo</p>
                        </a>
                    </div>";}
        }else{
            echo "<div class='card_apresentacao'>
            <a href='../GradeCurricular/Cadastrar Portfolio/cadastro.html' id='clique'>
                <h1> Seja Bem-Vindo!</h1>
                <h2>Aqui ficaram depositados todos os seus trabalhos &#x1F929;</h2>
                <p>clique aqui e cadastre o seu primeiro trabalho!</p>
            </a>
            ";
        }   
        ?>
    </div>
</body>

</html>
