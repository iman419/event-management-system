<?php
require_once __DIR__ . '/BaseDao.php';

class OrderItemDao extends BaseDao {
  public function __construct() {
    parent::__construct('order_items');
  }

  public function getByOrder($orderId): array {
    $stmt = $this->connection->prepare("SELECT * FROM order_items WHERE order_id = :o");
    $stmt->bindParam(':o', $orderId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
  }
}
