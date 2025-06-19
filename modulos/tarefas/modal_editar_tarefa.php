    <?php
    $usuario_logado_id = $_SESSION['usuario_id'];

    $sql = "SELECT id, nome, funcao FROM usuarios 
        WHERE admin_id = ? AND ativo = 1
        ORDER BY funcao, nome";
    // Consulta nova só para o formulário de editar tarefa
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $admin_id);
    $stmt->execute();
    $resultadoUsuariosEdit = $stmt->get_result();
    $ultimoCargo = '';

    ?>

    <!-- Modal Editar Tarefa -->
    <div class="modal fade" id="modalEditarTarefa" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content" method="POST" action="editar_tarefa.php">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Tarefa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="tarefa_id" id="editar_tarefa_id">

                    <div class="mb-3">
                        <label class="form-label">Descrição da Tarefa</label>
                        <input type="text" class="form-control" name="titulo_tarefa" id="editar_titulo_tarefa" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Responsável</label>
                        <select class="form-select"
                            name="responsavel_id"
                            id="editar_responsavel_id"
                            required
                            data-user-logado="<?= $_SESSION['usuario_id'] ?>"
                            data-tipo-usuario="<?= $_SESSION['tipo_usuario'] ?>">
                            <option value="">Selecione o responsável</option>
                            <option value="<?= $_SESSION['tipo_usuario'] ?>_<?= $_SESSION['usuario_id'] ?>">Eu mesmo</option>
                            <?php while ($usuario = mysqli_fetch_assoc($resultadoUsuariosEdit)): ?>
                                <?php if ($usuario['id'] == $_SESSION['usuario_id']) continue; ?>
                                <?php if ($ultimoCargo !== $usuario['funcao']): ?>
                                    <?php
                                    if ($ultimoCargo !== '') echo '</optgroup>';
                                    $ultimoCargo = $usuario['funcao'];
                                    ?>
                                    <optgroup label="<?= htmlspecialchars($usuario['funcao']) ?>">
                                    <?php endif; ?>
                                    <option value="funcionario_<?= $usuario['id'] ?>"><?= htmlspecialchars($usuario['nome']) ?></option>
                                <?php endwhile; ?>
                                <?php if ($ultimoCargo !== '') echo '</optgroup>'; ?>
                        </select>

                    </div>

                    <div class="mb-3">
                        <label class="form-label">Criticidade</label>
                        <select class="form-select" name="criticidade" id="editar_criticidade" required>
                            <option value="Baixa">Baixa</option>
                            <option value="Média">Média</option>
                            <option value="Alta">Alta</option>
                        </select>
                    </div>

                    <div class="alert alert-warning d-none" id="editar_alertaCriticidadeAlta">
                        <strong>Atenção:</strong> Tarefas de alta criticidade exigem aprovação do gestor. Ao confirmar, será enviada uma solicitação para aprovação.
                    </div>

                    <div class="mb-3 d-none" id="editar_divComentarioGestor">
                        <label class="form-label">Comentário ao Gestor (opcional)</label>
                        <textarea class="form-control" name="comentario_gestor" id="editar_comentario_gestor" rows="2" placeholder="Justifique brevemente a alta criticidade (opcional)."></textarea>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>