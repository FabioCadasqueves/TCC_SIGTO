    <div class="modal fade" id="modalNovaEquipe" tabindex="-1" aria-labelledby="modalNovaEquipeLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <form class="modal-content" action="cadastrar_equipe.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalNovaEquipeLabel">Criar Nova Equipe</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nomeEquipe" class="form-label">Nome da Equipe</label>
                        <input type="text" class="form-control" id="nomeEquipe" name="nomeEquipe" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Selecione os Membros</label>

                        <div class="border rounded p-3" style="max-height: 300px; overflow-y: auto;">
                            <?php
                            $nomes_plurais = [
                                'Operador' => 'Operadores',
                                'Mecânico' => 'Mecânicos'
                            ];
                            ?>
                            <?php foreach ($grupos as $cargo => $lista): ?>
                                <strong class="d-block mb-2 mt-2"><?= $nomes_plurais[$cargo] ?? $cargo ?></strong>
                                <?php foreach ($lista as $usuario): ?>
                                    <?php
                                    $usuario_id = $usuario['id'];
                                    $usuario_nome = htmlspecialchars($usuario['nome']);
                                    $usuario_equipe = $usuario['equipe_atual'] ?? null;
                                    $desabilitado = !empty($usuario_equipe);
                                    ?>
                                    <div class="form-check">
                                        <input class="form-check-input"
                                            type="checkbox"
                                            name="membros[]"
                                            value="<?= $usuario_id ?>"
                                            id="usuario<?= $usuario_id ?>"
                                            <?= $desabilitado ? 'disabled' : '' ?>>
                                        <label class="form-check-label" for="usuario<?= $usuario_id ?>">
                                            <?= $usuario_nome ?>
                                            <?= $desabilitado ? '<span class="text-muted">(já em uma equipe)</span>' : '' ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            <?php endforeach; ?>

                        </div>

                        <div class="form-text">Marque os funcionários que farão parte da equipe.</div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Salvar Equipe</button>
                </div>
            </form>
        </div>
    </div>