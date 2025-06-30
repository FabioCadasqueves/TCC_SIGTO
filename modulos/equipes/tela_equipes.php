<?php

require_once '../../login/autenticacao_admin.php';

include 'buscar_funcionarios_equipes.php';

$paginaAtual = 'equipes';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipes - SIGTO</title>

    <link rel="stylesheet" href="../../componentes/menu/estilo_menu.css">
    <link rel="stylesheet" href="../../componentes/cabecalho.css">
    <?php
    include '../../componentes/bootstrap.php';
    include 'modal_cadastrar_equipe.php';
    include 'modal_editar_equipe.php';
    include 'modal_excluir_equipe.php';
    ?>
</head>

<body>

    <?php include '../../componentes/menu/botao_menu.php'; ?>

    <div class="d-md-flex">
        <?php include '../../componentes/menu/menu.php'; ?>

        <main class="container py-4" style="max-width: 1200px;">
            <?php if (isset($_GET['cadastro']) && $_GET['cadastro'] === 'sucesso'): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Equipe criada com sucesso!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                </div>
            <?php endif; ?>
            <div class="d-flex justify-content-between align-items-center mb-4" style="padding-bottom: 15px">
                <h1 class="titulo-pagina">Equipes</h1>
                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNovaEquipe">+ Nova Equipe</a>
            </div>

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" style="max-height: calc(100vh - 150px); overflow-y: auto; padding-right: 8px;">
                <?php
                $admin_id = $_SESSION['admin_id'];

                $sql = "SELECT e.id, e.nome, e.criado_em, COUNT(em.usuario_id) AS total_membros
                        FROM equipes e
                        LEFT JOIN membros_equipes em ON em.equipe_id = e.id AND em.ativo = 1
                        WHERE e.admin_id = ? AND e.ativo = 1
                        GROUP BY e.id, e.nome, e.criado_em
                        ORDER BY e.nome";

                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $admin_id);
                $stmt->execute();
                $result = $stmt->get_result();

                while ($equipe = $result->fetch_assoc()):
                ?>
                    <div class="col">
                        <div class="card border-0 shadow-sm h-100" style="background: #f8f9fc; border-left: 5px solid #0d6efd; transition: all 0.2s ease-in-out;">
                            <div class=" border shadow-sm card-body py-3">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="bi bi-people-fill fs-4"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold mb-0"><?= htmlspecialchars($equipe['nome']) ?></h5>
                                        <small class="text-muted"><?= intval($equipe['total_membros']) ?> membro<?= intval($equipe['total_membros']) !== 1 ? 's' : '' ?></small>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="#" class="btn btn-outline-warning btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalEditarEquipe"
                                        data-id="<?= $equipe['id'] ?>"
                                        title="Editar equipe">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="#" class="btn btn-outline-danger btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalExcluirEquipe"
                                        data-id="<?= $equipe['id'] ?>"
                                        data-nome="<?= htmlspecialchars($equipe['nome']) ?>"
                                        title="Excluir equipe">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>

        </main>
    </div>


    <script src="../../componentes/menu/js_menu.js"></script>
    <script src="js_equipes.js"></script>
</body>

</html>