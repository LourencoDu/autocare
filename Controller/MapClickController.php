<?php
namespace AutoCare\Controller;

use AutoCare\Model\Prestador;
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

        $model = new \AutoCare\Model\Local();
        $model->latitude = $input['latitude'];
        $model->longitude = $input['longitude'];

        $saved = $model->save();

        echo json_encode([
            'success' => true,
            'id' => $saved->id
        ]);
    } catch (Throwable $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Exception: ' . $e->getMessage()
        ]);
    }
}


}
