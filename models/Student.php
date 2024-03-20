<?php

class Student extends Model {



    
    public function statNbCandidature($studentId){
        $req = "SELECT utilisateur.nom AS nom_etudiant, 
        utilisateur.prenom AS preonm_etudiant, 
        COUNT(*) AS nombre_de_candidatures
        FROM utilisateur
        LEFT JOIN candidater ON utilisateur.id = candidater.id_utilisateur
        WHERE id_utilisateur = :studentId;"; // Remplacez par l'ID de l'étudiant que vous souhaitez vérifier;
        $stmt = $this->conn->prepare($req);
        $stmt->execute(['studentId' => $studentId]);    //permet de bind values
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Fermeture du curseur du statement
        $stmt->closeCursor();
        parent::sendJSON($data);
    }
    
    public function statNbAttente($studentId){
        $req = "SELECT utilisateur.nom AS nom_etudiant,      
        utilisateur.prenom AS prenom_etudiant, 
        COUNT(candidater.id_stage) AS nombre_offres_en_attentes 
        FROM utilisateur 
        LEFT JOIN candidater ON utilisateur.id = candidater.id_utilisateur
        WHERE utilisateur.id = :studentId 
        AND candidater.etat = 0
        GROUP BY utilisateur.id, utilisateur.nom, utilisateur.prenom;"; 
        $stmt = $this->conn->prepare($req);
        $stmt->execute(['studentId'=> $studentId]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Fermeture du curseur du statement
        $stmt->closeCursor();
        parent::sendJSON($data);
    }
    
    public function statNbAdmission($studentId){
        $req = "SELECT utilisateur.nom AS nom_etudiant, 
        utilisateur.prenom AS prenom_etudiant,
        COUNT(candidater.id_stage) AS nombre_offres_acceptees
        FROM utilisateur 
        LEFT JOIN candidater ON utilisateur.id = candidater.id_utilisateur 
        WHERE utilisateur.id = :studentId
        AND candidater.etat = 1
        GROUP BY utilisateur.id, utilisateur.nom, utilisateur.prenom; ";
        $stmt = $this->conn->prepare($req);
        $stmt->execute(['studentId'=> $studentId]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Fermeture du curseur du statement
        $stmt->closeCursor();
        parent::sendJSON($data);
    }

    public function statNbRefus($studentId){
        $req = "SELECT utilisateur.nom AS nom_etudiant, 
        utilisateur.prenom AS prenom_etudiant, 
        COUNT(candidater.id_stage) AS nombre_offres_acceptees 
        FROM utilisateur
        LEFT JOIN candidater ON utilisateur.id = candidater.id_utilisateur
        WHERE utilisateur.id = :studentId
        AND candidater.etat = 2
        GROUP BY utilisateur.id, utilisateur.nom, utilisateur.prenom;"; 
 
        $stmt = $this->conn->prepare($req);
        $stmt->execute(['studentId'=> $studentId]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Fermeture du curseur du statement
        $stmt->closeCursor();
        parent::sendJSON($data);
    }


    public function statNbLike($studentId){
        $req = "SELECT utilisateur.nom AS nom_etudiant,
        utilisateur.prenom AS prenom_etudiant, 
        COUNT(aimer.id_stage) AS nombre_offres_aimees
        FROM utilisateur 
        LEFT JOIN aimer ON utilisateur.id = aimer.id_utilisateur
        WHERE utilisateur.id = :studentId
        GROUP BY utilisateur.id, utilisateur.nom, utilisateur.prenom;";
        $stmt = $this->conn->prepare($req);
        $stmt->execute(['studentId'=> $studentId]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Fermeture du curseur du statement
        $stmt->closeCursor();
        parent::sendJSON($data);
    }
}