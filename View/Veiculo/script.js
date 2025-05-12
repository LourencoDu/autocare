function handleDeleteClick(id, apelido) {
  openDeleteModal({
    title: `Deletar veículo "${apelido}"`,
    confirmButtonText: "Sim, deletar veículo",
    text: `Tem certeza de que deseja deletar o veículo "${apelido}"?\nTodos os dados associados serão removidos permanentemente. Esta ação não poderá ser desfeita.`,
    onConfirm: () => handleDeleteConfirm(id) 
  });
}

async function handleDeleteConfirm(id) {
  setDeleteModalIsLoading(true);
  post(
    "/veiculo/deletar",
    new URLSearchParams({
      id
    })
  ).then(response => {
    setDeleteModalIsLoading(false);
    closeDeleteModal();
    location.reload();
  });
}