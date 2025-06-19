<?php
require_once 'autenticacao.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo_usuario'] !== 'admin') {
    header('Location: login.php');
    exit;
}
