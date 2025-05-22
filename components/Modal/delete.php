<div id="delete-modal" class="hidden relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
  <div  class="fixed inset-0 bg-gray-500/75 transition-opacity" aria-hidden="true"></div>

  <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
      <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
          <div class="flex flex-col items-center gap-4 sm:flex sm:flex-row sm:items-start sm:gap-4">
            <div class="mx-auto flex size-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:size-10">
              <svg class="size-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
              </svg>
            </div>
            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
              <h3 class="text-lg font-semibold text-gray-900" id="delete-modal-title">Deletar registro</h3>
              <div class="mt-2">
                <p class="text-gray-700" id="delete-modal-text">Tem certeza de que deseja deletar este registro? Todos os dados associados serão removidos permanentemente. Esta ação não poderá ser desfeita.</p>
              </div>
            </div>
          </div>
        </div>
        <div class="bg-gray-50 px-4 sm:px-6 py-3 flex flex-col sm:flex-row-reverse gap-3">
          <button id="delete-modal-confirm-button" type="button" class="button danger min-h-8 sm:max-h-10 w-full">
            <span id="delete-modal-confirm-button-text">Sim, deletar registro</span>
          </button>
          <button id="delete-modal-cancel-button" onclick="closeDeleteModal()" type="button" class="button ghost min-h-8 sm:max-h-10 w-full">Cancelar</button>
        </div>
      </div>
    </div>
  </div>
</div>
