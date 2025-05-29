function handleComentarioDeleteClick(id_comentario) {
  openDeleteModal({
    title: `Deletar comentário "#${id_comentario}"?`,
    confirmButtonText: "Sim, deletar comentário",
    text: `Tem certeza de que deseja deletar o comentário "#${id_comentario}"?\nTodos os dados associados serão removidos permanentemente. Esta ação não poderá ser desfeita.`,
    onConfirm: () => handleComentarioDeleteConfirm(id_comentario) 
  });
}

async function handleComentarioDeleteConfirm(id_comentario) {
  setDeleteModalIsLoading(true);
  post(
    "/admin/comentario/deletar",
    new URLSearchParams({
      id_comentario
    })
  ).then(response => {    
    if(response?.status === "success") {
      showSnackbar("Comentário deletado com sucesso!", "success");
    } else {
      showSnackbar("Falha ao deletar comentário.", "erro");
    }
    closeDeleteModal();
  }).finally(() => {
    setDeleteModalIsLoading(false);
    atualizarListagem();
  });
}

async function atualizarListagem() {
  const params = new URLSearchParams(window.location.search);
  const id = params.get("id");

  const html = await getText(`/comentario/listarTabela${id ? `?id=${id}` : ""}`);

  // Cria um container temporário para interpretar a string HTML
  const tempDiv = document.createElement("div");
  tempDiv.innerHTML = html;

  // Pega a nova div#lista-comentarios que veio do backend
  const novaDiv = tempDiv.querySelector("#lista-comentarios");
  if (!novaDiv) {
    console.error("HTML recebido não contém a div#lista-comentarios");
    return;
  }

  // Substitui apenas o conteúdo interno da div original
  const container = document.getElementById("lista-comentarios");
  container.innerHTML = novaDiv.innerHTML;
}