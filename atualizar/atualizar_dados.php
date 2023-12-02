<?php
session_start();

if (isset($_POST['update'])) {
    require_once '../conexao/conexao.php';

    // Verifique se o usuário está logado
    if (isset($_SESSION['matricula_usuario'])) {
        $matriculaUsuario = $_SESSION['matricula_usuario'];
        $codigoCursoFk = isset($_POST['Cursos']) ? $_POST['Cursos'] : null; 
        $nomeUsuario = $_POST['nome_usuario'];
        $cpf = $_POST['cpf'];
        $sexo = $_POST['sexo'];
        $telefone = $_POST['telefone'];
        $endereco = $_POST['endereco'];
        $uf = $_POST['uf'];
        $cidade = $_POST['cidade'];
        $dataNascimento = $_POST['data_nascimento'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $query = "UPDATE usuario SET codigo_curso_fk = :codigo_curso_fk, nome_usuario = :nome_usuario, cpf = :cpf, sexo = :sexo, telefone = :telefone, endereco = :endereco, uf = :uf, cidade = :cidade, data_nascimento = :data_nascimento, email = :email, senha = :senha WHERE matricula_usuario = :matricula_usuario";

        $pdoResult = $conexao->prepare($query);

        $pdoExec = $pdoResult->execute(array(
            ":codigo_curso_fk" => $codigoCursoFk,
            ":nome_usuario" => $nomeUsuario,
            ":cpf" => $cpf,
            ":sexo" => $sexo,
            ":telefone" => $telefone,
            ":endereco" => $endereco,
            ":uf" => $uf,
            ":cidade" => $cidade,
            ":data_nascimento" => $dataNascimento,
            ":email" => $email,
            ":senha" => $senha,
            ":matricula_usuario" => $matriculaUsuario
            
        ));
        var_dump($matriculaUsuario);

        if ($pdoExec) {
            header('Location: ../perfil/perfil.php?msgSucesso=DadosCadastrados');
        } else {
            echo '<script>alert("ERRO, não foi possível atualizar seus dados"); window.location="atualizarDados.php";<script>';
        }
    } else {
        echo '<script>alert("Você não está logado ou não tem permissão para acessar esta página"); window.location="atualizarDados.php";<script>';
    }
} else {
    echo '<script>alert("Requisição inválida"); window.location="atualizarDados.php";<script>';
}
?>
