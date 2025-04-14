<?php

namespace AutoCare\Helper;

final class ResponseHelper {
  public static function response($success = false, $error = false) {
    header("Content-Type: application/json");
    error_reporting(0);

    echo json_encode(['success' => $success, 'erro' => $error]);
  }
}