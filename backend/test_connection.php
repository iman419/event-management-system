<?php
require_once __DIR__ . '/config.php';

try {
  $pdo = Database::connect();
  $stmt = $pdo->query('SELECT NOW() AS now');
  $row = $stmt->fetch();
  echo 'OK ✅ Connected. MySQL time: ' . $row['now'];
} catch (Throwable $e) {
  http_response_code(500);
  echo 'Connection error: ' . $e->getMessage();
}
