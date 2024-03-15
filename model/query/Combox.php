<?php

include_once 'C:\www\projetWEB\model\apiConfig.php';

class Combox extends apiConfig {

    public function sector() {
        $sql = 'SELECT id, nom FROM secteur ORDER BY nom ASC';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(); 
        $data = $stmt->fetchAll(); 
        parent::sendJSON($data);
    }

    public function country() {
        $sql = 'SELECT id, nom FROM ville ORDER BY nom ASC';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(); 
        $data = $stmt->fetchAll(); 
        parent::sendJSON($data);
    }

    public function rate() {
        $data = 'a faire';
        parent::sendJSON($data);
    }

}