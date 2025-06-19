    <!-- MODAL EXCLUIR EQUIPE -->
    <div class="modal fade" id="modalExcluirEquipe" tabindex="-1" aria-labelledby="modalExcluirEquipeLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="excluir_equipe.php" method="POST">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="modalExcluirEquipeLabel">Confirmar Exclusão</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="excluirIdEquipe">
                        <p>Tem certeza que deseja excluir a equipe <strong id="excluirNomeEquipe">NOME</strong>?</p>
                        <p class="text-danger small">Essa ação não poderá ser desfeita.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Excluir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>