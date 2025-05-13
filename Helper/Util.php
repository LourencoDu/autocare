<?php

namespace AutoCare\Helper;

class Util
{
  /**
   * Remove qualquer caractere que não seja letra (a-z, A-Z) ou número (0-9).
   *
   * @param string $valor Texto com máscara.
   * @return string Texto limpo, apenas letras e números.
   */
  public static function removerMascara(string $valor): string
  {
    return preg_replace('/[^a-zA-Z0-9]/', '', $valor);
  }

  /**
   * Formata um número como telefone brasileiro.
   * Ex: 11987654321 → (11) 98765-4321
   */
  public static function formatarTelefone(string $telefone): string
  {
    $tel = self::removerMascara($telefone);
    if (strlen($tel) === 11) {
      return sprintf(
        '(%s) %s-%s',
        substr($tel, 0, 2),
        substr($tel, 2, 5),
        substr($tel, 7)
      );
    } elseif (strlen($tel) === 10) {
      return sprintf(
        '(%s) %s-%s',
        substr($tel, 0, 2),
        substr($tel, 2, 4),
        substr($tel, 6)
      );
    }
    return $telefone;
  }

  /**
   * Formata um número como CNPJ.
   * Ex: 12345678000199 → 12.345.678/0001-99
   */
  public static function formatarCnpj(string $cnpj): string
  {
    $cnpj = self::removerMascara($cnpj);
    if (strlen($cnpj) === 14) {
      return sprintf(
        '%s.%s.%s/%s-%s',
        substr($cnpj, 0, 2),
        substr($cnpj, 2, 3),
        substr($cnpj, 5, 3),
        substr($cnpj, 8, 4),
        substr($cnpj, 12, 2)
      );
    }
    return $cnpj;
  }

    /**
   * Remove acentos de uma string.
   * Ex: João Café → Joao Cafe
   */
  public static function removerAcentos($texto): string
  {
    return transliterator_transliterate('Any-Latin; Latin-ASCII;', $texto);
  }
}
