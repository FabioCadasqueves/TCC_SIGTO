<?php
require_once 'autenticacao.php';

if ($_SESSION['tipo_usuario'] !== 'admin') {
    header('Location: ../../modulos/tarefas/index.php');
    exit;
}
