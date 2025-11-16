<?php
require_once __DIR__ . '/../dao/UserDAO.php';

class UserService {

    private UserDao $dao;

    public function __construct() {
        $this->dao = new UserDao();
    }

    public function get_all_users() {
        return $this->dao->get_all();
    }
}

