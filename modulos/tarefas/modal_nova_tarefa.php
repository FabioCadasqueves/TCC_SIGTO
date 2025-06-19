    <?php
    $usuario_logado_id = $_SESSION['usuario_id'];

    $sql = "SELECT id, nome, funcao FROM usuarios 
        WHERE admin_id = ? AND ativo = 1
        ORDER BY funcao, nome";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $admin_id);
    $stmt->execute();
    $resultadoUsuariosForm = $stmt->get_result();
    $ultimoCargo = '';
    ?>

    <!-- Modal Nova Tarefa -->
    <div class="modal fade" id="modalAdicionarTarefa" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content" method="POST" action="adicionar_tarefa.php">

                <input type="hidden" name="tipo_usuario_logado" value="<?= $_SESSION['tipo_usuario'] ?>">

                <div class="modal-header">
                    <h5 class="modal-title">Nova Tarefa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Descrição da Tarefa</label>
                        <input type="text" class="form-control" name="titulo_tarefa" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Responsável</label>
                        <select class="form-select"
                            id="responsavel_id"
                            name="responsavel_id"
                            required
                            data-user-logado="<?= $_SESSION['usuario_id'] ?>"
                            data-tipo-usuario="<?= $_SESSION['tipo_usuario'] ?>">
                            <option value="">Selecione o responsável</option>
                            <option value="<?= $_SESSION['tipo_usuario'] ?>_<?= $_SESSION['usuario_id'] ?>">Eu mesmo</option>
                            <?php while ($usuario = mysqli_fetch_assoc($resultadoUsuariosForm)): ?>
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
                        <select class="form-select" id="criticidade" name="criticidade" required>
                            <option value="Baixa">Baixa</option>
                            <option value="Média">Média</option>
                            <option value="Alta">Alta</option>
                        </select>
                    </div>

                    <div class="alert alert-warning d-none" id="alertaCriticidadeAlta">
                        <strong>Atenção:</strong> Tarefas de alta criticidade exigem aprovação do gestor. Ao confirmar, será enviada uma solicitação para aprovação.
                    </div>

                    <div class="mb-3 d-none" id="divComentarioGestor">
                        <label class="form-label">Comentário ao Gestor (opcional)</label>
                        <textarea class="form-control" name="comentario_gestor" rows="2" placeholder="Justifique brevemente a alta criticidade (opcional)."></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success" id="btnCriarTarefa">Criar Tarefa</button>
                </div>
            </form>
        </div>
    </div>