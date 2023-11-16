<?php
require_once '../conexao/conexao.php';

try {
        $sql = "SELECT * FROM  usuario where matricula_usuario = 21295220;";

        $stmt = $conexao->prepare($sql);
    
        $stmt->execute();
    
        $result = $stmt->fetchAll();

        

        // $result = $result[0];

        echo $result[0][3];
    

}catch (PDOException $e) {
    echo '<script>alert("Usuário ou senha inválidos!"); window.location="login.html";</script>';;
    die($e->getMessage());
}

die();

?>
