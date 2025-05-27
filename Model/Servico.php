<?php

namespace AutoCare\Model;

use AutoCare\DAO\ServicoDAO;

final class Servico extends Model
{
  public $id, $id_usuario, $id_prestador, $id_veiculo, $id_especialidade;
  
  public string $descricao;
  public string $data_inicio;
  public ?string $data_fim;

  public ?Usuario $usuario;
  public ?Prestador $prestador;
  public ?Veiculo $veiculo;
  public ?Especialidade $especialidade;

  public static function getById(int $id): ?Servico
  {
    return (new ServicoDAO())->selectById($id);
  }

  public function getAllRows(): array
  {
    return (new ServicoDAO())->select();
  }

  public function getAllRowsByIdPrestador($id_prestador): array
  {
    return (new ServicoDAO())->selectByIdPrestador($id_prestador);
  }

  public function getAllRowsByIdVeiculo($id_veiculo): array
  {
    return (new ServicoDAO())->selectByIdVeiculo($id_veiculo);
  }

  public function getAllRowsByIdUsuario($id_usuario): array
  {
    return (new ServicoDAO())->selectByIdUsuario($id_usuario);
  }

  public function getAllRowsByIdVeiculoOnDataFimIsNull($id_veiculo): array
  {
    return (new ServicoDAO())->selectByIdVeiculoOnDataFimIsNull($id_veiculo);
  }

  public function save(): Servico
  {
    return (new ServicoDAO())->save($this);
  }

  public static function delete(int $id): bool
  {
    return (new ServicoDAO())->delete($id);
  }
}
