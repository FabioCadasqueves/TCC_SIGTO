<?php
session_start();
require_once '../conexao/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pin = trim($_POST['pin']);

    // Consulta o usuário com o PIN
    $stmt = $conn->prepare("SELECT id, nome, admin_id FROM usuarios WHERE pin = ? AND ativo = 1");
    $stmt->bind_param("s", $pin);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($usuario_id, $nome_usuario, $admin_id);
        $stmt->fetch();

        // Definindo variáveis de sessão
        $_SESSION['usuario_id'] = $usuario_id;
        $_SESSION['admin_id'] = $admin_id;
        $_SESSION['nome_usuario'] = $nome_usuario;
        $_SESSION['tipo_usuario'] = 'colaborador';

        // Redireciona para tela de tarefas
        header('Location: ../modulos/tarefas/tela_tarefas.php');
        exit;
    } else {
        // PIN incorreto ou usuário inativo
        header('Location: login.php?erro=pin');
        exit;
    }
}
