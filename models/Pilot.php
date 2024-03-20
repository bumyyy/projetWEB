<?php
session_start();
class Pilot extends Model {

    public function allPilot() {
        $sql = "SELECT 
        utilisateur.id AS id_pilote, 
        utilisateur.nom AS nom_pilote, 
        utilisateur.prenom AS prenom_pilote, 
        utilisateur.mail AS mail_pilote,
        utilisateur.type_, 
        promotion.id AS id_promotion,
        promotion.nom AS nom_promotion, 
        ville.id AS id_centre,
        ville.nom AS nom_centre
        FROM utilisateur
        JOIN promotion ON utilisateur.id_promotion = promotion.id
        LEFT JOIN ville ON promotion.id_ville = ville.id
        WHERE utilisateur.type_ = 2 -- Type pilote
        ORDER BY utilisateur.nom;";
        $stmt = $this->conn->prepare($sql); 
        $stmt->execute(); 
        $data = $stmt->fetchAll(); 
        parent::sendJSON($data);
    }

    public function pilotBySearch($search) {
        $sql = "SELECT 
        utilisateur.id AS id_pilote, 
        utilisateur.nom AS nom_pilote, 
        utilisateur.prenom AS prenom_pilote, 
        utilisateur.mail AS mail_pilote, 
        utilisateur.type_, 
        promotion.nom AS nom_promotion, 
        ville.nom AS centre
        FROM utilisateur
        JOIN promotion ON utilisateur.id_promotion = promotion.id
        LEFT JOIN ville ON promotion.id_ville = ville.id
        WHERE utilisateur.type_ = 2 -- Type pilote
        AND (utilisateur.nom LIKE :recherche -- Remplacez par le critère de recherche sur le nom
        OR utilisateur.prenom LIKE :recherche) 
        ORDER BY utilisateur.nom";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['recherche' => '%'.$search.'%']); //permet de bind values et d'ajouter les % pour le like
        $data = $stmt->fetchAll(); 
        parent::sendJSON($data);
    }

    public function selectPilot($pilotId) {
        $sql = "SELECT 
        utilisateur.id AS id_pilote, 
        utilisateur.nom AS nom_pilote, 
        utilisateur.prenom AS prenom_pilote, 
        utilisateur.mail AS mail_pilote,
        utilisateur.type_, 
        promotion.nom AS nom_promotion, 
        ville.nom AS centre
        FROM utilisateur
        JOIN promotion ON utilisateur.id_promotion = promotion.id
        LEFT JOIN ville ON promotion.id_ville = ville.id
        WHERE utilisateur.type_ = 2 -- Type pilote
        AND utilisateur.id LIKE :id_utilisateur";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id_utilisateur' => $pilotId]);    //permet de bind values
        $data = $stmt->fetchAll(); 
        parent::sendJSON($data);
    }
    public function addPilot($nom_pilote, $prenom_pilote, $adresse_mail, $mdp, $id_ville, $noms_promotions) {
        $this->conn->beginTransaction();
    
        try {
            // Insertion de l'utilisateur
            $sql = "INSERT INTO utilisateur(nom, prenom, mail, mdp, type_, id_promotion)
                    VALUES (:nom_pilote, :prenom_pilote, :adresse_mail, SHA2(:mdp, 256), 2, NULL);";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['nom_pilote' => $nom_pilote, 'prenom_pilote' => $prenom_pilote, 'adresse_mail' => $adresse_mail, 'mdp' => $mdp]);
    
            $pilotId = $this->conn->lastInsertId();
    
            // Correction pour l'insertion dans `gerer` en utilisant les IDs de promotions basées sur `id_ville` et `noms_promotions`
            $noms_promotions = explode(',', $noms_promotions); // Assumant que c'est une chaîne de caractères séparée par des virgules
            foreach ($noms_promotions as $nom_promotion) {
                $sqlPromotion = "SELECT id FROM promotion WHERE id_ville = :id_ville AND nom = :nom_promotion LIMIT 1;";
                $stmtPromotion = $this->conn->prepare($sqlPromotion);
                $stmtPromotion->execute(['id_ville' => $id_ville, 'nom_promotion' => $nom_promotion]);
                $promotionId = $stmtPromotion->fetchColumn();
    
                if ($promotionId) {
                    $sqlLocation = "INSERT INTO gerer (id_utilisateur, id_promotion) VALUES (:utilisateur_id, :promotion_id)";
                    $stmtLocation = $this->conn->prepare($sqlLocation);
                    $stmtLocation->execute([
                        'utilisateur_id' => $pilotId,
                        'promotion_id' => $promotionId
                    ]);
                }
            }
    
            $this->conn->commit();
        } catch (Exception $e) {
            $this->conn->rollBack();
            throw $e;
        }
    }
    
}