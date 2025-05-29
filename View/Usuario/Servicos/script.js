const _campoAvaliacao = {
    name: "avaliacao",
    label: "Avaliação",
    type: "select-search",
    validate: "required",
    isRequired: true,
    helperText: "Selecione a sua avaliação.",
    options: [],
};

const _campoComentario = {
    name: "comentario",
    label: "Comentário",
    type: "textarea",
    validate: "required",
    maxLength: 400,
    isRequired: true,
    placeholder:
        "Ex.: Empresa muito boa, excelente comunicação.",
    helperText: "Digite seu comentário.",
};

async function handleAvaliacaoClick(id, nota, comentario) {

    console.log(nota);
    console.log(comentario);
    const campoAvaliacao = { ..._campoAvaliacao };
    statusOptions = [
        { value: "5", label: "Muito Bom" },
        { value: "4", label: "Bom" },
        { value: "3", label: "Normal" },
        { value: "2", label: "Ruim" },
        { value: "1", label: "Muito Ruim" },
    ];

    campoAvaliacao.options = statusOptions;

    campoAvaliacao.value = nota;
    _campoComentario.value = comentario;

    openFormModal({
        title: `Avaliar Serviço #${id}`,
        onConfirm: (event) => onSubmitStatusChange(event, id),
        showCloseButton: true,
        confirmButtonText: "Salvar",
        campos: [campoAvaliacao, _campoComentario],
    });
}

async function onSubmitStatusChange(event, id) {
    event.preventDefault();
    const form = event.target;
    const dados = new FormData(form);
    const avaliacao = dados.get("avaliacao");
    const comentario = dados.get("comentario");

    setFormModalIsLoading(true);

    post(
        "/servico/avaliar",
        new URLSearchParams({
            id,
            avaliacao,
            comentario
        })
    ).then(response => {
        console.log(response);

        setFormModalIsLoading(false);
        showSnackbar("Status alterado com sucesso!", "success");
        closeFormModal();
        window.location.reload();
    })
}