<?php
session_start();

require_once '../conexao/conexao.php';

if (isset($_GET['id'])) {
    try {
        $id_trabalho = $_GET['id'];

        $sql = "SELECT anexo_atividade, matricula_usuario_fk FROM trabalhos WHERE anexo_atividade = :id AND matricula_usuario_fk = :matricula";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':id', $id_trabalho, PDO::PARAM_INT);
        $stmt->bindParam(':matricula', $_SESSION['matricula_usuario'], PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $caminho_arquivo = "../GradeCurricular/Cadastrar Portfolio/dadosUsuarios/" . $row['matricula_usuario_fk'] . "/" . $row['anexo_atividade'];


            // Verifica se o arquivo existe antes de iniciar o download
            if (file_exists($caminho_arquivo)) {
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . basename($caminho_arquivo) . '"');
                readfile($caminho_arquivo);
                exit;
            } else {
                echo "Arquivo não encontrado.";
            }
        } else {
            echo "Você não tem permissão para baixar este arquivo.";
        }
    } catch (Exception $erro) {
        echo "Erro ao processar o download.";
        die($erro->getMessage());
    }
} else {
    echo "ID do trabalho não fornecido.";
}
