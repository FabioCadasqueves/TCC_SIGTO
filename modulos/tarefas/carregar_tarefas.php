<?php

if (
    $_SESSION['tipo_usuario'] === 'admin' &&
    (!isset($_GET['usuario_id']) || empty($_GET['usuario_id']))
) {
    header('Location: tela_tarefas.php?usuario_id=todos');
    exit;
}


//Váriaveis da sessão

$admin_id = $_SESSION['admin_id'];
$usuario_id = $_SESSION['usuario_id'];
$tipo_usuario = $_SESSION['tipo_usuario'];
$paginaAtual = 'tarefas';

$filtro_usuario_id = $_GET['usuario_id']
    ?? (
        $_SESSION['tipo_usuario'] === 'admin'
        ? 'admin_' . $_SESSION['usuario_id']
        : 'funcionario_' . $_SESSION['usuario_id']
    );

if ($filtro_usuario_id === 'todos') {
    $filtro_tipo = 'todos';
    $filtro_id = null;
} else {
    list($filtro_tipo, $filtro_id) = explode('_', $filtro_usuario_id);
}


// Consulta tarefas filtradas, ordenadas por criticidade personalizada
$statusFiltro = $_GET['status'] ?? 'todos';

// Define o trecho do WHERE para o status
if ($statusFiltro === 'todos') {
    $statusWhere = "";  // Não filtra nada
} else {
    $statusWhere = "AND t.status = ?";
}


$ordenacaoCustomizada = "
    CASE t.status
        WHEN 'Em andamento' THEN 0
        WHEN 'Pendente' THEN 1
        WHEN 'Concluída' THEN 2
        ELSE 3
    END,
    CASE t.criticidade
        WHEN 'Alta' THEN 1
        WHEN 'Média' THEN 2
        WHEN 'Baixa' THEN 3
        ELSE 4
    END,
    t.criado_em DESC
";



$statusFiltro = $_GET['status'] ?? 'todos';

if ($statusFiltro === 'todos') {
    $statusWhere = "";  // Não filtra status
} else {
    $statusWhere = "AND t.status = ?";
}

// ADMIN visualizando todos
if ($filtro_tipo === 'todos' && $tipo_usuario === 'admin') {
    $sql = "SELECT t.*, 
                u.nome AS usuario_nome, 
                a.nome AS admin_nome
            FROM tarefas t
            LEFT JOIN usuarios u ON u.id = t.atribuido_para AND t.atribuido_para_tipo = 'funcionario'
            LEFT JOIN admins a  ON a.id = t.atribuido_para AND t.atribuido_para_tipo = 'admin'
            WHERE (
                (t.atribuido_para IN (SELECT id FROM usuarios WHERE admin_id = ?) AND t.atribuido_para_tipo = 'funcionario')
                OR (t.atribuido_para = ? AND t.atribuido_para_tipo = 'admin')
            )
            AND t.aprovada = 'Sim'
            $statusWhere
            ORDER BY $ordenacaoCustomizada";
    if ($statusFiltro === 'todos') {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $admin_id, $admin_id);
    } else {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $admin_id, $admin_id, $statusFiltro);
    }
    $stmt->execute();
    $resultado = $stmt->get_result();
} else {
    $sql = "SELECT t.*, 
                u.nome AS usuario_nome, 
                a.nome AS admin_nome
            FROM tarefas t
            LEFT JOIN usuarios u ON u.id = t.atribuido_para AND t.atribuido_para_tipo = 'funcionario'
            LEFT JOIN admins a  ON a.id = t.atribuido_para AND t.atribuido_para_tipo = 'admin'
            WHERE t.atribuido_para = ? 
              AND t.atribuido_para_tipo = ?
              AND t.aprovada = 'Sim'
              $statusWhere
            ORDER BY $ordenacaoCustomizada";
    if ($statusFiltro === 'todos') {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $filtro_id, $filtro_tipo);
    } else {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $filtro_id, $filtro_tipo, $statusFiltro);
    }
    $stmt->execute();
    $resultado = $stmt->get_result();
}

// Lista de usuários para o select
$sql = "SELECT id, nome, funcao FROM usuarios 
        WHERE admin_id = ? AND ativo = 1
        ORDER BY funcao, nome";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$resultadoUsuarios = $stmt->get_result();

$usuariosPorFuncao = [];
while ($usuario = $resultadoUsuarios->fetch_assoc()) {
    if ($usuario['id'] == $usuario_id) continue;
    $funcao = $usuario['funcao'];
    if (!isset($usuariosPorFuncao[$funcao])) {
        $usuariosPorFuncao[$funcao] = [];
    }
    $usuariosPorFuncao[$funcao][] = $usuario;
}
