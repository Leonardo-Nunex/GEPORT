<?php
require_once '../conexao/conexao.php';

// Inicia a sessão (se já não estiver iniciada)
session_start();

try {
    // Verifica se o email está definido na sessão
    if (isset($_SESSION['email'])) {
        $email = $_SESSION['email'];

        // Prepara a consulta usando um placeholder para o email
        $sql = "SELECT * FROM usuario WHERE email = :email";

        $stmt = $conexao->prepare($sql);

        // Atribui o valor do email ao placeholder na consulta
        $stmt->bindParam(':email', $email);

        $stmt->execute();

        $result = $stmt->fetchAll();
        
        $teste = $result[0][1];

        echo "<input type='text' required name='nome_usuario' value='$teste';>";

        
        echo $result[0][2];

        echo $result[0][3];

        echo $result[0][4];

        echo $result[0][5];

        echo $result[0][6];


        
    } else {
        echo "O email não está definido na sessão.";
    }
} catch (PDOException $e) {
    die($e->getMessage());
}
?>
