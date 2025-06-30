<?php
require_once '../../login/autenticacao.php';
require_once 'carregar_tarefas.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarefas - SIGTO</title>

    <link rel="stylesheet" href="../../componentes/menu/estilo_menu.css">
    <link rel="stylesheet" href="estilo_tarefas.css">
    <link rel="stylesheet" href="../../componentes/cabecalho.css">
    <?php include '../../componentes/bootstrap.php'; ?>
</head>

<body>
    <?php include '../../componentes/menu/botao_menu.php'; ?>

    <div class="d-md-flex">
        <?php include '../../componentes/menu/menu.php'; ?>

        <main class="container py-4" style="max-width: 1200px;">
            <?php if (isset($_GET['cadastro']) && $_GET['cadastro'] === 'sucesso'): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Tarefa criada com sucesso!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                </div>
            <?php endif; ?>

            <div class="sticky-top bg-white border-bottom" style="z-index: 1020;">
                <div class="container-fluid px-0 py-1">
                    <div class="d-flex justify-content-between align-items-center flex-column flex-md-row gap-3">
                        <div class="w-100 w-md-auto">
                            <h1 class="titulo-pagina">Tarefas</h1>
                        </div>
                        <div class="d-flex gap-2 align-items-center justify-content-end w-100">
                            <select class="form-select" id="filtroResponsavel">
                                <?php if ($tipo_usuario === 'admin'): ?>
                                    <option value="todos" <?= ($filtro_usuario_id == 'todos') ? 'selected' : '' ?>>Todos</option>
                                <?php endif; ?>
                                <option value="<?= $tipo_usuario === 'admin' ? 'admin' : 'funcionario' ?>_<?= $usuario_id ?>" <?= ($filtro_usuario_id == ($tipo_usuario === 'admin' ? 'admin' : 'funcionario') . '_' . $usuario_id) ? 'selected' : '' ?>>Minhas tarefas</option>
                                <?php foreach ($usuariosPorFuncao as $funcao => $usuarios): ?>
                                    <optgroup label="<?= htmlspecialchars($funcao) ?>">
                                        <?php foreach ($usuarios as $u): ?>
                                            <?php if ($u['id'] == $_SESSION['usuario_id']) continue; ?>
                                            <option value="funcionario_<?= $u['id'] ?>" <?= ($filtro_usuario_id == 'funcionario_' . $u['id']) ? 'selected' : '' ?>><?= htmlspecialchars($u['nome']) ?></option>
                                        <?php endforeach; ?>
                                    </optgroup>
                                <?php endforeach; ?>
                            </select>

                            <button class="btn btn-primary d-flex align-items-center gap-2" style="height: 40px;"
                                data-bs-toggle="modal" data-bs-target="#modalAdicionarTarefa" title="Adicionar Tarefa">
                                <i class="bi bi-plus-circle fs-4"></i>
                            </button>
                        </div>

                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end mb-3 mt-3 align-items-center gap-2 flex-wrap">

                <select class="form-select" id="filtroStatus" style="width: 160px;">
                    <option value="todos" <?= (($_GET['status'] ?? 'todos') === 'todos') ? 'selected' : '' ?>>Todos</option>
                    <option value="Pendente" <?= (($_GET['status'] ?? 'todos') === 'Pendente') ? 'selected' : '' ?>>Pendentes</option>
                    <option value="Em andamento" <?= (($_GET['status'] ?? 'todos') === 'Em andamento') ? 'selected' : '' ?>>Em andamento</option>
                    <option value="Concluída" <?= (($_GET['status'] ?? 'todos') === 'Concluída') ? 'selected' : '' ?>>Concluídas</option>
                </select>
                <button class="btn btn-outline-secondary  btn-visualizacao d-none d-md-inline-flex" onclick="mudarVisualizacao('grade', this)" title="Visualizar em grade">
                    <i class="bi bi-grid-3x3-gap-fill"></i>
                </button>
                <button class="btn btn-outline-secondary btn-visualizacao d-none d-md-inline-flex" onclick="mudarVisualizacao('lista', this)" title="Visualizar em lista">
                    <i class="bi bi-list-ul"></i>
                </button>
            </div>

            <div id="containerTarefas" class="row modo-grade" style="max-height: calc(100vh - 150px); overflow-y: auto; padding-right: 2px;">
                <?php while ($tarefa = $resultado->fetch_assoc()): ?>

                    <div class="tarefa-col">
                        <?php
                        if (!function_exists('removerAcentos')) {
                            function removerAcentos($texto)
                            {
                                return preg_replace(
                                    ['/[áàãâä]/u', '/[éèêë]/u', '/[íìîï]/u', '/[óòõôö]/u', '/[úùûü]/u', '/[ç]/u'],
                                    ['a', 'e', 'i', 'o', 'u', 'c'],
                                    strtolower($texto)
                                );
                            }
                        }
                        ?>

                        <div class="tarefa-lista card-tarefa <?= removerAcentos($tarefa['criticidade']) ?>" data-tarefa>


                            <!-- Criticidade -->
                            <span class="badge mb-2 <?= match ($tarefa['criticidade']) {
                                                        'Alta' => 'bg-danger',
                                                        'Média' => 'bg-warning text-dark',
                                                        'Baixa' => 'bg-success',
                                                        default => 'bg-secondary'
                                                    } ?>">
                                <?= $tarefa['criticidade'] ?>
                            </span>

                            <!-- Título -->
                            <h6 class="titulo-tarefa mb-2"><?= htmlspecialchars($tarefa['descricao']) ?></h6>


                            <!-- Status e responsável -->
                            <div class="linha-badges ">
                                <?php
                                $statusClass = match ($tarefa['status']) {
                                    'Em andamento' => 'bg-primary-subtle text-primary',
                                    'Pendente'     => 'bg-danger-subtle text-danger',
                                    'Concluída'    => 'bg-success-subtle text-success',
                                    default        => 'bg-secondary-subtle text-secondary'
                                };
                                ?>
                            </div>

                            <!-- Ações + status + nome em uma única linha -->
                            <div class="acoes-bloco-container d-flex flex-wrap align-items-center gap-2 w-100">
                                <span class="badge status-badge <?= $statusClass ?>"><?= $tarefa['status'] ?></span>
                                <span class="responsavel"><?= htmlspecialchars($tarefa['usuario_nome'] ?? $tarefa['admin_nome'] ?? 'Não encontrado') ?></span>

                                <div class="acoes-bloco d-flex gap-2">
                                    <?php if ($tarefa['status'] === 'Pendente'): ?>
                                        <button class="btn-acao btn-azul iniciar-tarefa" data-id="<?= $tarefa['id'] ?>" title="Iniciar">
                                            <i class="bi bi-play-fill"></i>
                                        </button>
                                    <?php elseif ($tarefa['status'] === 'Em andamento'): ?>
                                        <button class="btn-acao btn-verde concluir-tarefa" data-id="<?= $tarefa['id'] ?>" title="Concluir">
                                            <i class="bi bi-check-lg"></i>
                                        </button>
                                    <?php endif; ?>

                                    <?php if ($tarefa['status'] !== 'Concluída'): ?>
                                        <button class="btn-acao btn-cinza editar-tarefa" data-id="<?= $tarefa['id'] ?>" title="Editar">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button class="btn-acao btn-vermelho excluir-tarefa" data-id="<?= $tarefa['id'] ?>" title="Excluir">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>


                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </main>
    </div>

    <?php include 'modal_nova_tarefa.php'; ?>
    <?php include 'modal_editar_tarefa.php'; ?>

    <script src="../../componentes/menu/js_menu.js"></script>
    <script src="js_tarefas.js"></script>
</body>

</html>