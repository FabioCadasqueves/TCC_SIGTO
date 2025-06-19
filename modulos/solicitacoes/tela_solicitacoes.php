<?php
require_once '../../login/autenticacao_admin.php';

$paginaAtual = 'solicitacoes';
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitações - SIGTO</title>

    <link rel="stylesheet" href="../../componentes/menu/estilo_menu.css">
    <link rel="stylesheet" href="estilo_solicitacoes.css">
    <?php include '../../componentes/bootstrap.php'; ?>
    <link rel="stylesheet" href="../../componentes/cabecalho.css">

</head>

<body>
    <?php include '../../componentes/menu/botao_menu.php'; ?>

    <div class="d-md-flex">
        <?php include '../../componentes/menu/menu.php'; ?>

        <main class="container py-4" style="max-width: 1200px;">
            <div class="d-flex justify-content-between align-items-center mb-4" style="padding-bottom: 15px">
                <h1 class="titulo-pagina">Solicitações de Tarefas Críticas</h1>
            </div>

            <div style="max-height: 100vh; overflow-y: auto;" class="custom-scrollbar">
                <ul class="list-group">
                    <?php
                    require_once '../../conexao/conexao.php';

                    $admin_id = $_SESSION['admin_id'];

                    $sql = "SELECT t.id, t.descricao, t.criticidade, t.justificativa_funcionario,
                                t.atribuido_para,
                                u.nome AS solicitante_nome, u.funcao AS solicitante_funcao,
                                r.nome AS responsavel_nome, r.funcao AS responsavel_funcao
                            FROM tarefas t
                            INNER JOIN usuarios u ON u.id = t.criado_por
                            INNER JOIN usuarios r ON r.id = t.atribuido_para
                            WHERE u.admin_id = ? AND t.criticidade = 'Alta' 
                            AND (t.aprovada IS NULL OR t.aprovada = 'Pendente')
                            ORDER BY t.criado_em DESC
                            ";


                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $admin_id);
                    $stmt->execute();
                    $resultado = $stmt->get_result();
                    ?>

                    <ul class="list-group">
                        <?php while ($tarefa = $resultado->fetch_assoc()): ?>
                            <li class="list-group-item bg-white rounded-3 border shadow-sm mb-1 px-4 py-3">
                                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 fw-semibold text-primary">
                                            <i class="bi bi-exclamation-triangle-fill me-1 text-danger"></i>
                                            Solicitação - <?= htmlspecialchars($tarefa['descricao']) ?>
                                        </h6>
                                        <div class="small text-muted">
                                            <div><i class="bi bi-person-circle me-1"></i>Solicitante: <?= htmlspecialchars($tarefa['solicitante_nome']) ?> - <?= $tarefa['solicitante_funcao'] ?></div>
                                            <div><i class="bi bi-box-arrow-in-right me-1"></i>Sugerido para: <?= htmlspecialchars($tarefa['responsavel_nome']) ?> - <?= $tarefa['responsavel_funcao'] ?></div>
                                        </div>
                                    </div>
                                    <div class="mt-2 mt-md-0">
                                        <button class="btn btn-sm btn-primary avaliar-btn"
                                            data-id="<?= $tarefa['id'] ?>"
                                            data-descricao="<?= htmlspecialchars($tarefa['descricao'], ENT_QUOTES, 'UTF-8') ?>"
                                            data-criticidade="<?= htmlspecialchars($tarefa['criticidade'], ENT_QUOTES, 'UTF-8') ?>"
                                            data-responsavel-id="<?= htmlspecialchars($tarefa['atribuido_para'], ENT_QUOTES, 'UTF-8') ?>"
                                            data-solicitante="<?= htmlspecialchars($tarefa['solicitante_nome'], ENT_QUOTES, 'UTF-8') ?>"
                                            data-justificativa="<?= htmlspecialchars($tarefa['justificativa_funcionario'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                                            <i class="bi bi-search me-1"></i> Avaliar
                                        </button>

                                    </div>
                                </div>
                            </li>

                        <?php endwhile; ?>
                    </ul>

                </ul>
            </div>


        </main>
    </div>

    <?php include 'modal_avaliar_solicitacao.php'; ?>

    <script src="../../componentes/menu/js_menu.js"></script>
    <script src="js_solicitacoes.js"></script>
</body>

</html>