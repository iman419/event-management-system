<?php
require_once __DIR__ . '/BaseDao.php';

class OrderDao extends BaseDao {
  public function __construct() {
    parent::__construct('orders');
  }

  public function getByUser($userId): array {
    $stmt = $this->connection->prepare("SELECT * FROM orders WHERE user_id = :u ORDER BY created_at DESC");
    $stmt->bindParam(':u', $userId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
  }
}
