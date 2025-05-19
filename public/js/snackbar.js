function showSnackbar(mensagem, tipo = 'info', duracao = 3000) {
  const snackbar = document.getElementById('snackbar');
  if (!snackbar) return;

  const cores = {
    info: 'bg-gray-800 text-white',
    success: 'bg-green-600 text-white',
    erro: 'bg-red-600 text-white',
    aviso: 'bg-yellow-500 text-black',
  };

  snackbar.className =
    `fixed bottom-5 right-5 z-50 hidden px-4 py-3 rounded-lg shadow-lg transition-opacity duration-300 opacity-0 ${cores[tipo] || cores.info}`;

  snackbar.textContent = mensagem;
  snackbar.classList.remove('hidden');
  snackbar.classList.remove('opacity-0');
  snackbar.classList.add('opacity-100');

  setTimeout(() => {
    snackbar.classList.remove('opacity-100');
    snackbar.classList.add('opacity-0');

    setTimeout(() => {
      snackbar.classList.add('hidden');
    }, 300); // após transição
  }, duracao);
}
