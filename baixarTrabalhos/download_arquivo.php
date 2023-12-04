<?php
session_start();

require_once '../conexao/conexao.php';

if (isset($_GET['id'])) {
    try {
        $idTrabalho = $_GET['id'];

        $sql = "SELECT anexo_atividade, matricula_usuario_fk FROM trabalhos WHERE anexo_atividade = :id AND matricula_usuario_fk = :matricula";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':id', $idTrabalho, PDO::PARAM_INT);
        $stmt->bindParam(':matricula', $_SESSION['matricula_usuario'], PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $caminhoArquivo = "../GradeCurricular/Cadastrar Portfolio/dadosUsuarios/" . $row['matricula_usuario_fk'] . "/" . $row['anexo_atividade'];


            // Verifica se o arquivo existe antes de iniciar o download
            if (file_exists($caminhoArquivo)) {
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . basename($caminhoArquivo) . '"');
                readfile($caminhoArquivo);
                exit;
            } else {
                echo '<script>alert("Arquivo não encontrado"); window.location="../perfil/perfil.php";<script>';
                exit;
            }
        } else {
            echo '<script>alert("Você não tem permissão para baixar este arquivo"); window.location="../perfil/perfil.php";<script>';
            exit;
        }
    } catch (Exception $erro) {
        echo '<script>alert("Erro ao processar o download"); window.location="../perfil/perfil.php";<script>';
        die();
    }
} else {
    echo '<script>alert("ID do trabalho não fornecido"); window.location="../perfil/perfil.php";<script>';
}
