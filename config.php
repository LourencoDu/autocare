<?php

function loadEnv($path)
{
    if (!file_exists($path)) return;

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        if (str_starts_with(trim($line), '#')) continue;

        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);
        $_ENV[$name] = $value;
        putenv("$name=$value");
    }
}

loadEnv(__DIR__ . '/.env');

define("BASE_DIR", dirname(__FILE__, 2));
define("BASE_DIR_NAME", basename(__DIR__));

define("VIEWS", BASE_DIR."/AutoCare/View/");
define("COMPONENTS", BASE_DIR."/autocare/components/");

$baseUrl = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/';
define("BASE_URL", $baseUrl);

date_default_timezone_set('America/SaoPaulo');

$_ENV["db"]["host"] = "localhost:3306";
$_ENV["db"]["user"] = $_ENV['DB_USER'] ?? "root";
$_ENV["db"]["pass"] = $_ENV['DB_PASS'] ?? "";
$_ENV["db"]["database"] = "autocare";