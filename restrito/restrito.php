<?php
session_start();
// Se o usuário não está logado, manda para página de login.
if (!isset($_SESSION['matricula_usuario'])) header("Location: http://localhost/PORTIFOLIO_V1.1.3/login.php");
exit; // Encerra a execução do script