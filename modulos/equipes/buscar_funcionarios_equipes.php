<?php
// Buscar usuários do banco
$usuarios = [];
$admin_id = $_SESSION['admin_id'];

$sql = "SELECT u.id, u.nome, u.funcao,
               me.equipe_id AS equipe_atual
        FROM usuarios u
        LEFT JOIN (
            SELECT usuario_id, equipe_id
            FROM membros_equipes
            WHERE ativo = 1
        ) me ON me.usuario_id = u.id
        WHERE u.ativo = 1 AND u.admin_id = ?
        ORDER BY u.funcao, u.nome";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$resultado = $stmt->get_result();

$usuarios = [];
while ($linha = $resultado->fetch_assoc()) {
    $usuarios[] = $linha;
}

// Separar por cargo
$grupos = [
    'Operador' => [],
    'Mecânico' => []
];

foreach ($usuarios as $usuario) {
    if (isset($grupos[$usuario['funcao']])) {
        $grupos[$usuario['funcao']][] = $usuario;
    }
}
