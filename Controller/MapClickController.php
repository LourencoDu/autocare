<?php
namespace AutoCare\Controller;

use AutoCare\Model\Prestador;
use AutoCare\Model\Local;
use Throwable;


echo "User ID is: " . ($_SESSION['id_usuario'] ?? 'Not set');


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
        

        
        $model = new Local();
        $model->latitude = $input['latitude'];
        $model->longitude = $input['longitude'];
        $localSave = $model->save();

        $prestador = new Prestador();
        $prestador->id_usuario = $_SESSION['id_usuario'];
        $prestador->id_localizacao = $localSave;

        $saved = $prestador->save();



        echo json_encode([
            'success' => true,
            'id_Prestador' => $saved->id,
            'id_Local' => $localSave,
            'id_usuario' => $_SESSION['id_usuario']
        ]);
    } catch (Throwable $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Exception: ' . $e->getMessage()
        ]);
    }
}


}
