document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".avaliar-btn").forEach((botao) => {
    botao.addEventListener("click", () => {
      // Coleta os dados do botão
      const id = botao.dataset.id;
      const descricao = botao.dataset.descricao;
      const criticidade = botao.dataset.criticidade;
      const responsavelId = botao.dataset.responsavelId;
      const justificativa = botao.dataset.justificativa;
      const solicitante = botao.dataset.solicitante;

      // Preenche os campos do modal
      document.getElementById("idTarefaAvaliacao").value = id;
      document.getElementById("tituloTarefa").value = descricao;
      document.getElementById("criticidade").value = criticidade;
      document.getElementById("nomeSolicitante").value = solicitante;
      document.getElementById("responsavel_id").value = responsavelId;
      document.getElementById("justificativaFuncionario").value = justificativa;

      const select = document.getElementById("responsavel_id");

      // Abre o modal
      const modal = new bootstrap.Modal(
        document.getElementById("modalAvaliarSolicitacao")
      );
      modal.show();
    });
  });
});
