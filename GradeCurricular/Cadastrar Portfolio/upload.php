<?php
session_start();

require_once '../../conexao/conexao.php';




$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if ($dados) {
    try {
        // Configurar o fuso horário
        date_default_timezone_set('America/Sao_Paulo');
        $dataHoraAtual = date('Ymd_His');

        $arquivo = $_FILES['arquivo'];

        $sqlPortfolio = "INSERT INTO trabalhos (titulo, data_inicio, data_final, quantidade, periodo_trabalhos,competencias_fk, categoria_fk, matricula_usuario_fk, anexo_atividade, descricao) 
        VALUES (:titulo, :data_inicio, :data_final, :quantidade, :periodo_trabalhos, :competencias, :categoria, :matricula, :anexo, :descricao);";

        $stmtPortfolio = $conexao->prepare($sqlPortfolio);
        $nomeArquivo = $dataHoraAtual . "_" . $arquivo["name"];
        $dadosPortfolio = array(
            ':titulo' => $_POST['titulo'],
            ':data_inicio' => $_POST['data_inicio'],
            ':data_final' => $_POST['data_final'],
            ':quantidade' => $_POST['quantidade_pessoas'],
            'periodo_trabalhos' => $_POST['periodo'],
            ':competencias' => $_POST['competências'],
            ':categoria' => $_POST['categorias'],
            ':matricula' => $_SESSION['matricula_usuario'],
            ':anexo' => $nomeArquivo,
            ':descricao' => $_POST['comentario']
        );

        $matricula = $_SESSION['matricula_usuario'];
        $stmtPortfolio->execute($dadosPortfolio);
    
        if ($stmtPortfolio->rowCount()) {
            try{
                // Ajuste no caminho de destino
                $destino = "dadosUsuarios" . "/$matricula/" . $nomeArquivo;

                // Verificação e criação do diretório de destino
                $dir = dirname($destino);
                if (!is_dir($dir)) {
                    mkdir($dir, 0777, true);
                }

                // Tratamento apropriado do caminho do destino
                if (move_uploaded_file($arquivo['tmp_name'], $destino)) {
                    echo '<script>alert("Arquivo Enviado!"); window.location="../Tela Inicial/TelaInicial.html";</script>';
                } else{
                    die();
                }
            }catch (Exception $e) {
                die($erro->getMessage());
            }
        } else {
            echo '<script>alert("Preencha os dados!"); window.location="cadastro.html";</script>';
        }
    } catch (Exception $erro) {
        echo '<script>alert("Erro ao cadastrar!"); window.location="cadastro.html";</script>';
        die($erro->getMessage());
    }
} else {
    exit;
}
