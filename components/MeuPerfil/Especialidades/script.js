function handleEspecialidadeDeleteClick(id_especialidade, titulo) {
  openDeleteModal({
    title: `Deletar especialidade "${titulo}"`,
    confirmButtonText: "Sim, deletar especialidade",
    text: `Tem certeza de que deseja deletar a especialidade "${titulo}"?\nTodos os dados associados serão removidos permanentemente. Esta ação não poderá ser desfeita.`,
    onConfirm: () => handleEspecialidadeDeleteConfirm(id_especialidade) 
  });
}

async function handleEspecialidadeDeleteConfirm(id_especialidade) {
  setDeleteModalIsLoading(true);
  post(
    "/especialidade/deletar",
    new URLSearchParams({
      id_especialidade
    })
  ).then(response => {    
    closeDeleteModal();
    location.reload();
  }).finally(() => {
    setDeleteModalIsLoading(false);
  });
}