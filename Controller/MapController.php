<?php

namespace AutoCare\Controller;

use AutoCare\Model\Local;
use AutoCare\Model\Prestador;
use AutoCare\DAO\PrestadorCatalogoDAO;

final class MapController extends Controller
{
  public function index(): void
  {
    parent::isProtected();

    $this->view = "Prestador/Map/index.php";
    $this->titulo = "Prestadores próximos";
    $this->render();
  }
/* Código antigo com geocodificação via CEP - mantido para referência
  public function listar()
  {
    $model = new Local();
    $prestadores = $model->getAllRows();

    $results = [];

    foreach ($prestadores as $prestador) {
      $nome = $prestador->nome;
      $cep = $prestador->endereco_cep;

      // Clean the CEP to remove hyphens etc
      $cep = preg_replace('/[^0-9]/', '', $cep);

      // Geocode the CEP using Nominatim
      $url = "https://nominatim.openstreetmap.org/search?postalcode=$cep&country=Brazil&format=json";

      // Set user agent (VERY important for Nominatim!)
      $opts = [
        "http" => [
          "method" => "GET",
          "header" => "User-Agent: MyPrestadorMap/1.0\r\n"
        ]
      ];
      $context = stream_context_create($opts);

      $response = file_get_contents($url, false, $context);
      
      if ($response !== false) {
        $data = json_decode($response, true);
        if (!empty($data)) {
          $lat = $data[0]['lat'];
          $lon = $data[0]['lon'];

          $results[] = [
            'nome' => $nome,
            'lat' => $lat,
            'lon' => $lon
          ];
        }
      }

      // Sleep 1 second to respect Nominatim API rate limit
      sleep(1);
    }
    
    echo json_encode($results);
  }*/
public function listar()
{
    $prestadores = (new Prestador())->getAllRows();

    $results = [];

    foreach ($prestadores as $prestador) {
        if ($prestador->localizacao && !empty($prestador->localizacao->latitude) && !empty($prestador->localizacao->longitude)) {
            $results[] = [
                'lat' => $prestador->localizacao->latitude,
                'lon' => $prestador->localizacao->longitude,
                'nome' => $prestador->usuario->nome 
            ];
        }
    }

    echo json_encode($results);
}
public function listarPorEspecialidade(): void
    {
        header('Content-Type: application/json');

        $idEsp = (int)($_GET['id'] ?? 0);
        if ($idEsp <= 0) {
            echo json_encode([]);
            return;
        }

        $catalogos = (new PrestadorCatalogoDAO())->selectByEspecialidade($idEsp);
        $results = [];

        foreach ($catalogos as $cat) {
            $prest = Prestador::getById($cat->id_prestador);
            if (!$prest || !$prest->localizacao) {
                continue;
            }
            $results[] = [
                'lat'  => $prest->localizacao->latitude,
                'lon'  => $prest->localizacao->longitude,
                'nome' => $prest->usuario->nome,
                'esp'  => $cat->especialidade->nome
            ];
        }

        echo json_encode($results);
    }






}
