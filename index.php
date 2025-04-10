<?php

$baseUrl = dirname($_SERVER['SCRIPT_NAME']);
define('BASE_URL', $baseUrl);

require_once 'core/App.php';
require_once 'core/Controller.php';
require_once 'core/Model.php';

$app = new App();
