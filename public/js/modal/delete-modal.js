const deleteModal = document.getElementById("delete-modal");

function openDeleteModal({ title, text, cancelButtonText, confirmButtonText, onConfirm }) {
  const titleEl = document.getElementById("delete-modal-title");
  const textEl = document.getElementById("delete-modal-text");
  const cancelButtonEl = document.getElementById("delete-modal-cancel-button");
  const confirmButtonEl = document.getElementById("delete-modal-confirm-button"); 
  const confirmButtonTextEl = document.getElementById("delete-modal-confirm-button-text");

  if(title) {
    titleEl.innerText = title;
  }

  if(text) {
    textEl.innerText = text;
  }

  if(cancelButtonText) {
    cancelButtonEl.innerText = cancelButtonText;
  }

  if(confirmButtonText) {
    confirmButtonTextEl.innerText = confirmButtonText;
  }

  if(!!onConfirm) {
    confirmButtonEl.onclick = onConfirm;
  }

  deleteModal.classList.toggle("hidden", false);  
}

function closeDeleteModal() {
  deleteModal.classList.toggle("hidden", true);
}

function setDeleteModalIsLoading(isLoading = false) {
  const cancelButtonEl = document.getElementById("delete-modal-cancel-button");
  const confirmButtonEl = document.getElementById("delete-modal-confirm-button");

  cancelButtonEl.disabled  = isLoading;
  confirmButtonEl.disabled  = isLoading;

  toggleLoading(isLoading);
}