<?php
// Inicia a sessão
session_start();

// Destroi todas as variáveis de sessão
session_unset();

// Destrói a sessão
session_destroy();

// Redireciona para a página de login após o logout
header('Location: ../index.php');
?>