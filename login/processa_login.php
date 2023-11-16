<?php
require_once '../conexao/conexao.php';

if (!empty($_POST)) {
  session_start();
  try {
    
      $sql = "SELECT email, senha, matricula_usuario FROM  usuario where email = :email AND senha = :senha;";

      $stmt = $conexao->prepare($sql);

      $dados = array(
        ':email' => $_POST['email'],
        ':senha' => $_POST['senha']
      );

      $stmt->execute($dados);

      $result = $stmt->fetchAll();
      
      if($stmt->rowCount() == 1){

        $result = $result[0];

        $_SESSION['email'] = $result['email'];
        $_SESSION['senha'] = $result['senha'];
        $_SESSION['matricula_usuario'] = $result['matricula_usuario'];

        header('Location: ../GradeCurricular/pag1.html?msgSucesso = Deu certo');

      }else{
        echo '<script>alert("Usuário ou senha inválidos!"); window.location="login.html";</script>';
        // header('Location: login.html?msgErro = Deu errado');
      }

    }catch (PDOException $e) {
      echo '<script>alert("Usuário ou senha inválidos!"); window.location="login.html";</script>';;
      die($e->getMessage());
  }
}else{
  session_destroy();
  echo '<script>alert("Usuário ou senha inválidos!"); window.location="login.html";</script>';;
    // header('Location: login.html?msgErro = Sem permisão');
}
die();

?>
