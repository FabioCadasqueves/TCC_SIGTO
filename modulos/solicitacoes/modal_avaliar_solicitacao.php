        <?php
        $usuario_logado_id = $_SESSION['usuario_id'];

        $sql = "SELECT id, nome, funcao FROM usuarios 
        WHERE admin_id = ? AND ativo = 1
        ORDER BY funcao, nome";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $admin_id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $ultimoCargo = '';
        ?>

        <!-- MODAL AVALIAR SOLICITACAO -->

        <div class="modal fade" id="modalAvaliarSolicitacao" tabindex="-1" aria-labelledby="modalAvaliarSolicitacaoLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <form class="modal-content" method="POST" action="editar_solicitacao.php">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAvaliarSolicitacaoLabel">Avaliar Solicitação</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>

                    <div class="modal-body">
                        <!-- Campo oculto para ID da tarefa -->
                        <input type="hidden" name="id_tarefa" id="idTarefaAvaliacao">

                        <div class="mb-3">
                            <label class="form-label">Solicitante</label>
                            <input type="text" class="form-control" id="nomeSolicitante" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="tituloTarefa" class="form-label">Título da Tarefa</label>
                            <input type="text" class="form-control" id="tituloTarefa" name="titulo" required>
                        </div>

                        <div class="mb-3">
                            <label for="criticidade" class="form-label">Criticidade</label>
                            <select class="form-select" id="criticidade" name="criticidade" required>
                                <option value="Baixa">Baixa</option>
                                <option value="Média">Média</option>
                                <option value="Alta">Alta</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="responsavel" class="form-label">Atribuir para</label>
                            <select class="form-select"
                                id="responsavel_id"
                                name="responsavel_id"
                                required
                                data-user-logado="<?= $usuario_logado_id ?>"
                                data-tipo-usuario="<?= $_SESSION['tipo_usuario'] ?>">
                                <option value="">Selecione o responsável</option>
                                <!--<option value="<?= $usuario_logado_id ?>">Eu mesmo</option>-->
                                <?php while ($usuario = mysqli_fetch_assoc($resultado)): ?>
                                    <?php if ($usuario['id'] == $usuario_logado_id) continue; ?>
                                    <?php if ($ultimoCargo !== $usuario['funcao']): ?>
                                        <?php
                                        if ($ultimoCargo !== '') echo '</optgroup>';
                                        $ultimoCargo = $usuario['funcao'];
                                        ?>
                                        <optgroup label="<?= htmlspecialchars($usuario['funcao']) ?>">
                                        <?php endif; ?>
                                        <option value="<?= $usuario['id'] ?>"><?= htmlspecialchars($usuario['nome']) ?></option>
                                    <?php endwhile; ?>
                                    <?php if ($ultimoCargo !== '') echo '</optgroup>'; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Justificativa do Funcionário</label>
                            <textarea class="form-control" id="justificativaFuncionario" name="justificativa_funcionario" readonly rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="justificativaGestor" class="form-label">Comentário do Gestor (opcional)</label>
                            <textarea class="form-control" name="justificativa_gestor" id="justificativaGestor" rows="2" placeholder="Deixe um comentário ou justificativa."></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Aprovar Tarefa</button>
                    </div>
                </form>
            </div>
        </div>