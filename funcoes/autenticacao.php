<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['tipo_usuario'])) {
    header('Location: ../login/login.php');
    exit;
}
