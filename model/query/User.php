<?php

include_once 'C:\www\projetWEB\model\apiConfig.php';

class User extends apiConfig {

public function getUserByMail($mail) {
    $sql = "SELECT id, type_  FROM utilisateur WHERE mail = :mail";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(["mail" => $mail]);
    $data = $stmt->fetchAll(); 
    parent::sendJSON($data);
}

}