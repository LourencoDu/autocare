<?php

namespace AutoCare\Helper;

class JsonResponse
{
    private string $status;
    private string $mensagem;
    private array $dados;
    private array $erros;
    private int $httpCode;

    public function __construct(
        string $status = 'success',
        string $mensagem = '',
        array $dados = [],
        array $erros = [],
        int $httpCode = 200
    ) {
        $this->status = $status;
        $this->mensagem = $mensagem;
        $this->dados = $dados;
        $this->erros = $erros;
        $this->httpCode = $httpCode;
    }

    public static function sucesso(string $mensagem = '', array $dados = [], int $httpCode = 200): self
    {
        return new self('success', $mensagem, $dados, [], $httpCode);
    }

    public static function erro(string $mensagem = '', array $erros = [], int $httpCode = 400): self
    {
        return new self('error', $mensagem, [], $erros, $httpCode);
    }

    public function enviar(): void
    {
        http_response_code($this->httpCode);
        header('Content-Type: application/json');
        echo json_encode([
            'status' => $this->status,
            'mensagem' => $this->mensagem,
            'dados' => $this->dados,
            'erros' => $this->erros
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }
}
