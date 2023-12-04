<?php
require_once '../conexao/conexao.php';

if (!empty($_POST)) {
  session_start();
  try {

    $sql = "SELECT email, senha, matricula_usuario, nome_usuario FROM  usuario where email = :email AND senha = :senha;";

    $stmt = $conexao->prepare($sql);

    $dados = array(
      ':email' => $_POST['email'],
      ':senha' => $_POST['senha']
    );

    $stmt->execute($dados);

    $result = $stmt->fetchAll();

    if ($stmt->rowCount() == 1) {

      $result = $result[0];

      $_SESSION['email'] = $result['email'];
      $_SESSION['senha'] = $result['senha'];
      $_SESSION['matricula_usuario'] = $result['matricula_usuario'];
      $_SESSION['nome_usuario'] = $result['nome_usuario'];

      header('Location: ../GradeCurricular/Tela Inicial/TelaInicial.html?msgSucesso=SucessLogin');
      
    } else {
      echo '<script>alert("Usuário ou senha incorreta!"); window.location="login.html";</script>';
    }
  } catch (PDOException $e) {
    echo '<script>alert("Erro ao acessar o banco de dados!"); window.location="login.html";</script>';
  }
} else {
  session_destroy();
  echo '<script>alert("Acesso negado"); window.location="login.html";</script>';
}
die();
