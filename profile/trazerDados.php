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

        if ($stmt->rowCount() == 1) {
            foreach ($result as $row) {
                foreach ($row as $key => $value) {
                    echo $key . ': ' . $value . '<br>'; // Mostra chave e valor
                }
                echo '<br>'; // Quebra para a próxima linha
            }
        } else {
            echo "Nenhum usuário encontrado com esse email.";
        }
    } else {
        echo "O email não está definido na sessão.";
    }
} catch (PDOException $e) {
    die($e->getMessage());
}
?>
