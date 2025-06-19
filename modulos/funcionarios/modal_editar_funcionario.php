<!-- Modal Editar Funcionário -->
<div class="modal fade" id="modalEditarFuncionario" tabindex="-1" aria-labelledby="modalEditarFuncionarioLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" action="editar_funcionario.php" method="POST">
            <input type="hidden" name="id" id="editarIdFuncionario">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditarFuncionarioLabel">Editar Funcionário</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="editarNomeFuncionario" class="form-label">Nome</label>
                    <input type="text" class="form-control" name="nome" id="editarNomeFuncionario" required>
                </div>
                <div class="mb-3">
                    <label for="editarFuncaoFuncionario" class="form-label">Função</label>
                    <select class="form-select" name="funcao" id="editarFuncaoFuncionario" required>
                        <option>Operador</option>
                        <option>Mecânico</option>
                    </select>
                </div>
                <div class="mb-3 position-relative">
                    <label for="editarPinFuncionario" class="form-label">PIN de Acesso</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="editarPinFuncionario" value="1234" maxlength="6" readonly>
                        <button class="btn btn-outline-secondary" type="button" id="btnMostrarPin">
                            <i class="bi bi-eye"></i>
                        </button>
                        <button class="btn btn-outline-secondary" type="button" id="btnCopiarPinEditar">
                            <i class="bi bi-clipboard"></i>
                        </button>
                    </div>
                    <div class="form-text">Este PIN é usado para o acesso do funcionário e não pode ser alterado.</div>
                    <div id="feedbackPin" class="form-text text-success d-none">PIN copiado!</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-warning">Salvar Alterações</button>
            </div>
        </form>
    </div>
</div>