<?php
require_once __DIR__ . '/BaseDao.php';

class TicketTypeDao extends BaseDao {
  public function __construct() {
    parent::__construct('ticket_types');
  }

  public function getByEvent($eventId): array {
    $stmt = $this->connection->prepare("SELECT * FROM ticket_types WHERE event_id = :e");
    $stmt->bindParam(':e', $eventId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
  }
}
