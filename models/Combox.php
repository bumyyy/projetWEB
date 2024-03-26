<?php

class Combox extends Model {

    public function sector() {
        $sql = 'SELECT id, nom FROM secteur ORDER BY nom ASC';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(); 
        $data = $stmt->fetchAll(); 
        parent::sendJSON($data);
    }

    public function city($villeId = null) {
        if($villeId == null) {
            $sql = 'SELECT id, nom FROM ville ORDER BY nom ASC';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(); 
        } else {
            $sql = 'SELECT id, nom FROM ville WHERE id = :id_ville ORDER BY nom ASC';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(array('id_ville' => $villeId));  
        }
        $data = $stmt->fetchAll(); 
        parent::sendJSON($data);
    }

    public function rate() {
        $data = 'a faire';
        parent::sendJSON($data);
    }

    public function promotion() {
        $sql = 'SELECT id, nom FROM promotion';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(); 
        $data = $stmt->fetchAll(); 
        parent::sendJSON($data);
    }

    public function skill() {
        $sql = 'SELECT id, nom FROM competence';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(); 
        $data = $stmt->fetchAll(); 
        parent::sendJSON($data);
    }

    public function state() {
        $sql = 'SELECT DISTINCT(etat) FROM candidater';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(); 
        $data = $stmt->fetchAll(); 
        parent::sendJSON($data);
    }

    public function company($villeId) {
        $sql = 'SELECT entreprise.id AS id, entreprise.nom AS nom
                FROM entreprise
                JOIN situer on entreprise.id = situer.id_entreprise
                JOIN ville on ville.id = situer.id_ville
                WHERE ville.id = :ville_id';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':ville_id' => $villeId]); 
        $data = $stmt->fetchAll(); 
        parent::sendJSON($data);
    }
}