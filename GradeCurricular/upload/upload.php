<?php 
session_start();

require_once '../../conexao/conexao.php';

// Configurar o fuso horário
date_default_timezone_set('America/Sao_Paulo');

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if ($dados) {
    try {
        $arquivo = $_FILES['arquivo'];
      
        $sqlPortfolio = "INSERT INTO trabalhos (nome, data_inicio, data_final, quantidade_pessoas, anexo_atividade, decricao) 
        VALUES (:nome, :data_inicio, :data_final, :quantPart, :anexo, :descricao)";

        $stmtPortfolio = $conexao->prepare($sqlPortfolio);

        // Correção do formato da data
        $data = date('Y-m-d'); 
        $dadosPortfolio = array(
            ':nome' => $_POST['nome'],
            ':data_inicio' => $data,
            ':data_final' => $data,
            ':quantPart' => $_POST['quant_pessoas'],
            ':descricao' => $_POST['descricao'],
            ':anexo' => $arquivo['name']
        );

        $nome = $_SESSION['matricula_usuario'];
        
        $stmtPortfolio->execute($dadosPortfolio);

        $id = $conexao->lastInsertId();

        if($stmtPortfolio->rowCount()){
            $dataHoraAtual = date('Ymd_His');
            $nomeArquivo = $dataHoraAtual . "_" . $id . $arquivo["name"];
            // Ajuste no caminho de destino
            $destino = __DIR__ . "/$nome/" . $nomeArquivo;

            // Verificação e criação do diretório de destino
            $dir = dirname($destino);
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }

            // Tratamento apropriado do caminho do destino
            if (move_uploaded_file($arquivo['tmp_name'], $destino)) {
                echo '<script>alert("Arquivo Enviado!"); window.location="pag2.html";</script>';
            } else {
                die();
                // Logar em vez de exibir diretamente na página
                error_log("Erro ao mover o arquivo para o destino.");
            }
            
        } else {
            echo '<script>alert("Preencha os dados!"); window.location="pag2.html";</script>';
        }

    } catch (Exception $erro) {
        // Trate a exceção aqui se algo dentro do bloco try lançar uma exceção
        echo "Erro: " . $erro->getMessage();
    }
} else {
    exit; 
}
