function handleDeleteClick(id, apelido) {
  openDeleteModal({
    title: `Deletar funcionário "${apelido}"`,
    confirmButtonText: "Sim, deletar funcionário",
    text: `Tem certeza de que deseja deletar o funcionário "${apelido}"?\nTodos os dados associados serão removidos permanentemente. Esta ação não poderá ser desfeita.`,
    onConfirm: () => handleDeleteConfirm(id) 
  });
}

async function handleDeleteConfirm(id) {
  setDeleteModalIsLoading(true);
  post(
    "/funcionario/deletar",
    new URLSearchParams({
      id
    })
  ).then(response => {
    setDeleteModalIsLoading(false);
    closeDeleteModal();
    location.reload();
  });
}