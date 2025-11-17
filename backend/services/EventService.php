<?php
require_once __DIR__ . '/../dao/EventDAO.php';

class EventService {
    private $dao;

    public function __construct() {
        $this->dao = new EventDAO();
    }

    public function getAll() { return $this->dao->getAll(); }
    public function getById($id) { return $this->dao->getById($id); }
    public function create($data) { return $this->dao->insert($data); }
    public function update($id, $data) { return $this->dao->update($id, $data); }
    public function delete($id) { return $this->dao->delete($id); }
}
