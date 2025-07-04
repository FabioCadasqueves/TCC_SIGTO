<div id="sidebar" class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark" style="width: 250px; height: 100vh;">

    <!-- Botão de fechar (só visível no mobile) -->
    <div class="d-flex justify-content-end d-md-none mb-2">
        <button class="btn btn-close btn-close-white" onclick="fecharMenu()" aria-label="Fechar"></button>
    </div>

    <div class="d-flex justify-content-center">
        <a href="/" class="d-flex align-items-center text-white text-decoration-none">
            <img src="../../componentes/menu/Logo.png" alt="Logo SIGTO" width="32" height="32">
            <span class="fs-4 ms-2">SIGTO</span>
        </a>
    </div>

    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li>
            <a href="../../modulos/tarefas/tela_tarefas.php" class="nav-link text-white <?php if ($paginaAtual === 'tarefas') echo 'active'; ?>">
                <i class="bi bi-list-task me-2"></i> Tarefas
            </a>
        </li>

        <?php if ($_SESSION['tipo_usuario'] === 'admin'): ?>
            <!--<li class="nav-item">
                <a href="dashboard.php" class="nav-link text-white <?php if ($paginaAtual === 'dashboard') echo 'active'; ?>">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
            </li>-->
            <li>
                <a href="../../modulos/funcionarios/tela_funcionarios.php" class="nav-link text-white <?php if ($paginaAtual === 'funcionarios') echo 'active'; ?>">
                    <i class="bi bi-person-badge-fill me-2"></i> Funcionários
                </a>
            </li>
            <li>
                <a href="../../modulos/equipes/tela_equipes.php" class="nav-link text-white <?php if ($paginaAtual === 'equipes') echo 'active'; ?>">
                    <i class="bi bi-people-fill me-2"></i> Equipes
                </a>
            </li>
        <?php endif; ?>



        <?php if ($_SESSION['tipo_usuario'] === 'admin'): ?>
            <li>
                <a href="../../modulos/solicitacoes/tela_solicitacoes.php" class="nav-link text-white <?php if ($paginaAtual === 'solicitacoes') echo 'active'; ?>">
                    <i class="bi bi-chat-left-dots-fill me-2"></i> Solicitações
                </a>
            </li>
        <?php endif; ?>
    </ul>


    <hr>
    <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
            data-bs-toggle="dropdown" aria-expanded="false">
            <img src="../../componentes/menu/User.jpg.jpg" alt="" width="32" height="32" class="rounded-circle me-2">
            <strong>
                <?= $_SESSION['admin_nome'] ?? $_SESSION['nome_usuario'] ?? 'Usuário' ?>
            </strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
            <li><a class="dropdown-item" href="#">Perfil</a></li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="../../login/logout.php">Sair</a></li>

        </ul>
    </div>
</div>