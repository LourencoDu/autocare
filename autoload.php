<?php

spl_autoload_register(function ($nome_da_classe) {
  // Remove barra invertida inicial, se existir
  $nome_da_classe = ltrim($nome_da_classe, '\\');
  
  // Converte namespace para caminho (troca \ por /)
  $arquivo = BASE_DIR . '/' . str_replace('\\', '/', $nome_da_classe) . '.php';

  if (file_exists($arquivo)) {
    include $arquivo;
  } else {
    echo var_dump($arquivo);
    throw new Exception("Arquivo não encontrado");
  }
});
