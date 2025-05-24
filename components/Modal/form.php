<div id="form-modal" class="hidden relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
  <div class="fixed inset-0 bg-gray-500/75 transition-opacity" aria-hidden="true"></div>

  <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
      <form id="form-modal-form" novalidate="true" class="relative transform rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 w-full sm:max-w-lg">
        <div class="relative bg-white px-4 sm:px-6 h-14 flex items-center border-b border-gray-300 justify-between">
          <h3 class="text-base font-semibold text-gray-900" id="form-modal-title">Formulário</h3>
          <button id="form-modal-close-button" onclick="closeFormModal()" type="button" class="hidden flex items-center justify-center p-2 text-lg/10 text-gray-400 hover:text-gray-700 cursor-pointer transition">
            <i class="fa-solid fa-close"></i>
          </button>
        </div>

        <div id="form-modal-error" class="hidden px-4 sm:px-6 pt-2">
          <div class="flex flex-row items-start bg-red-50 border border-red-300 px-4 py-2 rounded-md gap-2">
            <div class="flex items-center min-h-6">
              <i class="fa-solid fa-circle-exclamation text-red-700 text-base/6"></i>
            </div>
            <span id="form-modal-error-text" class="text-base/6 font-medium">A senha atual está incorreta.</span>
          </div>
        </div>

        <div id="form-modal-campos" class="bg-white px-4 sm:px-6 py-5 flex flex-col gap-4">

        </div>

        <div class="bg-white px-4 py-4 sm:py-3 sm:px-6 flex flex-col sm:flex-row-reverse gap-3 items-center border-t border-gray-300">
          <button id="form-modal-confirm-button" type="submit" class="button min-h-8 sm:max-h-10 w-full">
            <span id="form-modal-confirm-button-text">Confirmar</span>
          </button>
          <button id="form-modal-cancel-button" onclick="closeFormModal()" type="button" class="button ghost min-h-8 sm:max-h-10 w-full">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>