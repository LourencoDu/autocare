<?php

spl_autoload_register(function ($nome_da_classe) {
    $prefixo = 'AutoCare\\';

    // Verifica se a classe começa com o prefixo
    if (strpos($nome_da_classe, $prefixo) === 0) {
        // Remove o prefixo
        $nome_da_classe = substr($nome_da_classe, strlen($prefixo));
    }

    $caminho = str_replace('\\', '/', ltrim($nome_da_classe, '\\'));
    $arquivo = rtrim(BASE_DIR, '/') . '/' . $caminho . '.php';

    if (file_exists($arquivo)) {
        include $arquivo;
    } else {
        echo "Tentando carregar: $arquivo\n";
        throw new Exception("Arquivo não encontrado");
    }
});
