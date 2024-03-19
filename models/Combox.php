<?php

class Combox extends Model {

public function sector() {
    $sql = 'SELECT id, nom FROM secteur ORDER BY nom ASC';
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(); 
    $data = $stmt->fetchAll(); 
    parent::sendJSON($data);
}

public function city() {
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