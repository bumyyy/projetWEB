<?php

class Favorite extends Model {


    public function allFavorite() {
        $sql = "SELECT id_stage, id_utilisateur FROM aimer";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(); 
        $data = $stmt->fetchAll(); 
        parent::sendJSON($data);
    }

    public function addFavorite($internshipId) {
        $this->conn->beginTransaction();

        // Vérifier d'abord si l'ID de stage existe dans la table stage
        $stageExists = $this->checkStageExists($internshipId);
    
        if ($stageExists) {
            $sql = "INSERT INTO aimer (id_stage, id_utilisateur) VALUES (:id_stage, 1)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['id_stage' => $internshipId]); 
                        //'id_utilisateur' => $userId]);

            $_SESSION["message"] = "Application added successfully.";
        } else {
            $_SESSION["message"] = "Invalid internship ID. Cannot add application.";
        }

        $this->conn->commit();
    }
    
    // Fonction pour vérifier si l'ID de stage existe dans la table stage
    private function checkStageExists($internshipId) {
        $sql = "SELECT COUNT(*) AS count FROM stage WHERE id = :id_stage";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id_stage' => $internshipId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }
    

    public function deleteFavorite($internshipId) {
        $sql = "DELETE FROM aimer WHERE id_stage = :id_stage AND id_utilisateur = 1;";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id_stage' => $internshipId]);
        $_SESSION["message"] = "Deleted";
    }








}