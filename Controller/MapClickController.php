<?php
namespace AutoCare\Controller;

use AutoCare\Model\Prestador;
use AutoCare\Model\Local;
use Throwable;



final class MapClickController extends Controller
{
  public function index(): void
  {
    parent::isProtected();

    $this->view = "Prestador/Map/ClickIndex.php";
    $this->titulo = "Click";
    $this->render();

  }
 public function salvar(): void
{
    header('Content-Type: application/json');

    try {
        $input = json_decode(file_get_contents('php://input'), true);

        if (!isset($input['latitude'], $input['longitude'])) {
            echo json_encode(['success' => false, 'message' => 'Missing data']);
            return;
        }

        $local = new Local();
        $local->latitude = $input['latitude'];
        $local->longitude = $input['longitude'];
        $savedLocal = $local->save();

        $prestador = $_SESSION['usuario']->prestador ?? null;

        if (!$prestador) {
            echo json_encode(['success' => false, 'message' => 'Prestador sem login']);
            return;
        }

        $prestador->localizacao = $savedLocal; 
        $prestador->save();

        $_SESSION['usuario']->prestador = $prestador;

        echo json_encode([
            'success' => true,
            'id_prestador' => $prestador->id,
            'id_localizacao' => $savedLocal->id,
            'new_lat' => $savedLocal->latitude,
            'new_lon' => $savedLocal->longitude
        ]);
    } catch (Throwable $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Exception: ' . $e->getMessage(),
        
        ]);
    }
}



}
