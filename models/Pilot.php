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

}