<?php

class User extends Model {

    public function getUserByMail($mail) {
        $sql = "SELECT id, type_  FROM utilisateur WHERE mail = :mail";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(["mail" => $mail]); 
        $data = $stmt->fetchAll(); 
        return $data;
    }

}