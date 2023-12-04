<?php
session_start();

// Verifica se o usuário está logado
if (isset($_SESSION['nome_usuario'])) {
    echo $_SESSION['nome_usuario'];
} else {
    echo "Usuário não autenticado";
}
?>
