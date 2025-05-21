function handleServicoDeleteClick(id_catalogo_servico, titulo) {
  openDeleteModal({
    title: `Deletar serviço "${titulo}"`,
    confirmButtonText: "Sim, deletar serviço",
    text: `Tem certeza de que deseja deletar o serviço "${titulo}" do catálogo da empresa?\nTodos os dados associados serão removidos permanentemente. Esta ação não poderá ser desfeita.`,
    onConfirm: () => handleServicoDeleteConfirm(id_catalogo_servico) 
  });
}

async function handleServicoDeleteConfirm(id_catalogo_servico) {
  setDeleteModalIsLoading(true);
  post(
    "/especialidade/deletar",
    new URLSearchParams({
      id_especialidade: id_catalogo_servico
    })
  ).then(response => {    
    closeDeleteModal();
    location.reload();
  }).finally(() => {
    setDeleteModalIsLoading(false);
  });
}