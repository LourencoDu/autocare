<?php

include "autoload.php";
include "config.php";

session_start();

function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

include "routes/index.php";