<!-- Modal Novo Funcionário -->
<div class="modal fade" id="modalNovoFuncionario" tabindex="-1" aria-labelledby="modalNovoFuncionarioLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" action="cadastrar_funcionario.php" method="POST">
            <div class="modal-header">
                <h5 class="modal-title" id="modalNovoFuncionarioLabel">Cadastrar Novo Funcionário</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="nomeFuncionario" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="nomeFuncionario" name="nome" required>
                </div>
                <div class="mb-3">
                    <label for="funcaoFuncionario" class="form-label">Função</label>
                    <select class="form-select" id="funcaoFuncionario" name="funcao" required>
                        <option></option>
                        <option>Operador</option>
                        <option>Mecânico</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="pinFuncionario" class="form-label">PIN de Acesso</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="pinFuncionario" name="pin" maxlength="6" readonly>
                        <button class="btn btn-outline-secondary" type="button" id="copiarPin" title="Copiar PIN">
                            <i class="bi bi-clipboard"></i>
                        </button>
                    </div>
                    <small id="mensagemCopiado" class="text-success ms-2 d-none">PIN copiado!</small>
                    <div class="form-text">Gerado automaticamente. Compartilhe com o funcionário.</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-success">Salvar</button>
            </div>
        </form>
    </div>
</div>