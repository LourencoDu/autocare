<?php

define("BASE_DIR", dirname(__FILE__, 2));
define("BASE_DIR_NAME", basename(__DIR__));

define("VIEWS", BASE_DIR."/AutoCare/View/");

$_ENV["db"]["host"] = "localhost:3306";
$_ENV["db"]["user"] = "root";
$_ENV["db"]["pass"] = "root";
$_ENV["db"]["database"] = "autocare";