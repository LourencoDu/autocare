<?php
  header("Content-Type: application/json");
  header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
  error_reporting(0);
  date_default_timezone_set('America/Sao_Paulo');
  require_once 'routes/routes.php';
?>