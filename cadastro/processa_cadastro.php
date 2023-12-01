<?php

if (!empty($_POST)) {
    require_once '../conexao/conexao.php';

    // Mapeia os cursos para os respectivos IDs
  

    try {
        $conexao->beginTransaction();

        // Verifica se o curso enviado existe no mapeamento

            $sqlUsuario = "INSERT INTO usuario (codigo_curso_fk, nome_usuario, cpf, sexo, telefone, endereco, uf, cidade, data_nascimento, email, senha) 
                VALUES (:cursos, :nome_usuario, :cpf, :sexo, :telefone, :endereco, :uf, :cidade, :data_nascimento, :email, :senha)";

            $stmtUsuario = $conexao->prepare($sqlUsuario);

            $dadosUsuario = array(
                ':cursos' => $_POST['cursos'], 
                ':nome_usuario' => $_POST['nome'],
                ':cpf' => $_POST['cpf'],
                ':sexo' => $_POST['sexo'],
                ':telefone' => $_POST['telefone'],
                ':endereco' => $_POST['endereco'],
                ':uf' => $_POST['uf'],
                ':cidade' => $_POST['cidade'],
                ':data_nascimento' => $_POST['data_nascimento'],
                ':email' => $_POST['email'],
                ':senha' => md5($_POST['senha']),
                
            );

            $stmtUsuario->execute($dadosUsuario);
            $conexao->commit();
            
            echo '<script>alert("Dados Cadastrados"); window.location="../login/login.html";</script>';

    } catch (PDOException $e) {
        $conexao->rollBack();
        echo '<script>alert("Dados já cadastrados"); window.location="../login/login.html";</script>';
        die();
    }
} else {
    header("Location: ../login/login.html?msgErro=Erro de acesso.");
    die();
}
?>
