<?php if (!empty($data['erro'])): ?>
  <div class="pb-4">
    <div class="flex flex-row items-start bg-red-50 border border-red-300 p-4 rounded-md gap-3">
      <div class="flex items-center min-h-6">
        <i class="fa-solid fa-circle-exclamation text-red-700 text-xl/6"></i>
      </div>
      <span class="text-lg/6 font-medium"><?= $data['erro'] ?></span>
    </div>
  </div>
<?php endif; ?>