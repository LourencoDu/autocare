<?php

define("BASE_DIR", dirname(__FILE__, 2));

define("VIEWS", BASE_DIR."/AutoCare/View/");

$_ENV["db"]["host"] = "localhost:3306";
$_ENV["db"]["user"] = "root";
$_ENV["db"]["pass"] = "";
$_ENV["db"]["database"] = "autocare";