    <div class="modal fade" id="modalEditarEquipe" tabindex="-1" aria-labelledby="modalEditarEquipeLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <form class="modal-content" action="editar_equipe.php" method="POST">
                <input type="hidden" name="id_equipe" id="editarIdEquipe">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarEquipeLabel">Editar Equipe</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editarNomeEquipe" class="form-label">Nome da Equipe</label>
                        <input type="text" class="form-control" id="editarNomeEquipe" name="nome" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Editar Membros da Equipe</label>
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
                                    $usuario_equipe = $usuario['equipe_atual'] ?? '';
                                    ?>
                                    <div class="form-check">
                                        <input class="form-check-input"
                                            type="checkbox"
                                            name="membros[]"
                                            value="<?= $usuario_id ?>"
                                            id="editarUsuario<?= $usuario_id ?>"
                                            data-equipe="<?= $usuario_equipe ?>">
                                        <label class="form-check-label" for="editarUsuario<?= $usuario_id ?>">
                                            <?= $usuario_nome ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            <?php endforeach; ?>

                        </div>
                        <div class="form-text">Desmarque para remover ou marque para adicionar membros.</div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>