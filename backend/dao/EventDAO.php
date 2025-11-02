<?php
require_once __DIR__ . '/BaseDao.php';

class EventDao extends BaseDao {
  public function __construct() {
    parent::__construct('events');
  }

 
  public function getAllWithVenue(): array {
    $sql = "SELECT e.*, v.name AS venue_name
            FROM events e
            JOIN venues v ON v.id = e.venue_id
            ORDER BY e.starts_at ASC";
    $stmt = $this->connection->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
  }
}
