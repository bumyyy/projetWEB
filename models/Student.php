<?php

class Student extends Model {

    public function allStudent() {
        $sql = "SELECT 
        utilisateur.id AS id_student, 
        utilisateur.nom AS nom_student, 
        utilisateur.prenom AS prenom_student, 
        utilisateur.mail AS mail_student,
        utilisateur.type_, 
        promotion.id AS id_promotion,
        promotion.nom AS nom_promotion, 
        ville.id AS id_centre,
        ville.nom AS nom_centre
        FROM utilisateur
        JOIN promotion ON utilisateur.id_promotion = promotion.id
        LEFT JOIN ville ON promotion.id_ville = ville.id
        WHERE utilisateur.type_ = 3 -- Type étudiant
        ORDER BY utilisateur.nom;";
        $stmt = $this->conn->prepare($sql); 
        $stmt->execute(); 
        $data = $stmt->fetchAll(); 
        parent::sendJSON($data);
    }

    public function studentBySearch($search) {
        $sql = "SELECT 
        utilisateur.id AS id_student, 
        utilisateur.nom AS nom_student, 
        utilisateur.prenom AS prenom_student, 
        utilisateur.mail AS mail_student, 
        utilisateur.type_, 
        promotion.nom AS nom_promotion, 
        promotion.id AS id_promotion,
        ville.nom AS nom_centre,
        ville.id AS id_centre
        FROM utilisateur
        JOIN promotion ON utilisateur.id_promotion = promotion.id
        LEFT JOIN ville ON promotion.id_ville = ville.id
        WHERE utilisateur.type_ = 3 -- Type student
        AND (utilisateur.nom LIKE :recherche -- Remplacez par le critère de recherche sur le nom
        OR utilisateur.prenom LIKE :recherche) 
        ORDER BY utilisateur.nom";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['recherche' => '%'.$search.'%']); //permet de bind values et d'ajouter les % pour le like
        $data = $stmt->fetchAll(); 
        parent::sendJSON($data);
    }

    public function selectStudent($pilotId) {
        $sql = "SELECT 
        utilisateur.id AS id_student, 
        utilisateur.nom AS nom_student, 
        utilisateur.prenom AS prenom_student, 
        utilisateur.mail AS mail_student,
        utilisateur.type_, 
        promotion.nom AS nom_promotion, 
        ville.nom AS centre
        FROM utilisateur
        JOIN promotion ON utilisateur.id_promotion = promotion.id
        LEFT JOIN ville ON promotion.id_ville = ville.id
        WHERE utilisateur.type_ = 2 -- Type student
        AND utilisateur.id LIKE :id_utilisateur";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id_utilisateur' => $pilotId]);    //permet de bind values
        $data = $stmt->fetchAll(); 
        parent::sendJSON($data);
    }

    public function addStudent($nom, $prenom, $mail, $mdp, $centre, $promo){
        $sql = "INSERT INTO utilisateur(nom, prenom, mail, mdp, type_, id_promotion)
                VALUES (:nom, :prenom, :mail, SHA2(:mdp, 256), 3, 
                (SELECT id 
                FROM promotion 
                WHERE id_ville = :centre AND nom = :promo)
                );";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'nom' => $nom, 
            'prenom' => $prenom, 
            'mail' => $mail, 
            'mdp' => $mdp, 
            'centre' => $centre, 
            'promo' => $promo
        ]);

    }


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