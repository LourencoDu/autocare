<?php
use AutoCare\DAO\PrestadorDAO;
require_once __DIR__ . 'autocare/autoload.php'; // Path to your autoloader
header('Content-Type: application/json');

$dao = new PrestadorDAO();
$prestadores = $dao->buscarTodos(); // Fetch all prestadores

$results = [];

foreach ($prestadores as $prestador) {
    $nome = $prestador['nome'];
    $cep = $prestador['endereco_cep'];

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
