<?php

// Include config.php file
include_once 'config.php';

class Combox extends Config {

    public function secteur() {
        $sql = 'SELECT id, nom FROM secteur ORDER BY nom ASC';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(); 
        $data = $stmt->fetchAll(); 
        sendJSON($data);
    }

    public function ville() {
        $sql = 'SELECT id, nom FROM ville ORDER BY nom ASC';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(); 
        $data = $stmt->fetchAll(); 
        sendJSON($data);
    }

    public function note() {
        $data = 'a faire';
        sendJSON($data);
    }

}