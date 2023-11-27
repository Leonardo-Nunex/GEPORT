<?php
session_start();

if (isset($_POST['update'])) {
    require_once '../conexao/conexao.php';

    // Verifique se o usuário está logado
    if (isset($_SESSION['matricula_usuario'])) {
        $matricula_usuario = $_SESSION['matricula_usuario']; // Use a matrícula do usuário logado
        $codigo_curso_fk = isset($_POST['Cursos']) ? $_POST['Cursos'] : null; 
        $nome_usuario = $_POST['nome_usuario'];
        $cpf = $_POST['cpf'];
        $sexo = $_POST['sexo'];
        $telefone = $_POST['telefone'];
        $endereco = $_POST['endereco'];
        $uf = $_POST['uf'];
        $cidade = $_POST['cidade'];
        $data_nascimento = $_POST['data_nascimento'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $query = "UPDATE usuario SET codigo_curso_fk = :codigo_curso_fk, nome_usuario = :nome_usuario, cpf = :cpf, sexo = :sexo, telefone = :telefone, endereco = :endereco, uf = :uf, cidade = :cidade, data_nascimento = :data_nascimento, email = :email, senha = :senha WHERE matricula_usuario = :matricula_usuario";

        $pdoResult = $conexao->prepare($query);

        $pdoExec = $pdoResult->execute(array(
            ":codigo_curso_fk" => $codigo_curso_fk,
            ":nome_usuario" => $nome_usuario,
            ":cpf" => $cpf,
            ":sexo" => $sexo,
            ":telefone" => $telefone,
            ":endereco" => $endereco,
            ":uf" => $uf,
            ":cidade" => $cidade,
            ":data_nascimento" => $data_nascimento,
            ":email" => $email,
            ":senha" => $senha,
            ":matricula_usuario" => $matricula_usuario
        ));

        if ($pdoExec) {
            header('Location: ../perfil/perfil.html?msgSucesso=DadosCadastrados');
        } else {
            echo 'ERRO, não foi possível atualizar seus dados';
        }
    } else {
        echo 'Você não está logado ou não tem permissão para acessar esta página.';
    }
} else {
    // Se o parâmetro 'update' não estiver definido, você pode exibir uma mensagem de erro ou redirecionar o usuário.
    echo 'Requisição inválida.';
}
?>
