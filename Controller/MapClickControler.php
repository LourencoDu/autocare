<?php
//Apenas uma Copia do MapControler por enquanto 
namespace AutoCare\Controller;

use AutoCare\Model\Prestador;

final class MapController extends Controller
{
  public function index(): void
  {
    parent::isProtected();

    $this->view = "Prestador/Map/ClickIndex.php";
    $this->titulo = "Click";
    $this->render();
  }

  public function listar()
  {
    $model = new Prestador();
    $prestadores = $model->getAllRows();

    $results = [];

    foreach ($prestadores as $prestador) {
      $nome = $prestador->nome;
      $cep = $prestador->endereco_cep;

      $cep = preg_replace('/[^0-9]/', '', $cep);

      $url = "https://nominatim.openstreetmap.org/search?postalcode=$cep&country=Brazil&format=json";

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

      sleep(1);
    }

    echo json_encode($results);
  }
}
