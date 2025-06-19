<?php
require_once 'autenticacao.php';

if ($_SESSION['tipo_usuario'] !== 'admin') {
    header('Location: ../../modulos/tarefas/tela_tarefas');
    exit;
}
