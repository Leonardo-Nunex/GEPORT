<?php
// Inicia a sessão (se já não estiver iniciada)
session_start();

// Remove todas as variáveis de sessão
$_SESSION = array();

// Se necessário, também pode invalidar o cookie de sessão
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finaliza a sessão
session_destroy();

// Redireciona para a página de login ou outra página desejada
header("Location: ../index.html");
exit;
?>
