<?php

class Internship extends Model {

    public function allInternship() {
        $sql = "SELECT 
        stage.id AS id_offre,
        stage.nom AS nom_offre,
        entreprise.nom AS nom_entreprise,
        competence.id AS id_competence,
        GROUP_CONCAT(DISTINCT competence.nom SEPARATOR ', ') AS competences_requises,
        ville.id AS id_ville,
        GROUP_CONCAT(DISTINCT ville.nom SEPARATOR ', ') AS localites,
        promotion.id AS id_promotion,
        promotion.nom AS nom_promotion,
        stage.date_debut AS date_debut_offre, 
        stage.date_fin AS date_fin_offre,
        DATEDIFF(stage.date_fin, stage.date_debut) AS duree_stage,
        FLOOR(DATEDIFF(stage.date_fin, stage.date_debut) / 30) AS duree_mois_stage,
        stage.remuneration AS remuneration_base,
        stage.nb_place AS nombre_places_offertes,
        COUNT(DISTINCT candidater.id_utilisateur) AS nombre_etudiants_postules
        FROM stage
        INNER JOIN entreprise ON stage.id_entreprise = entreprise.id
        LEFT JOIN rechercher ON stage.id = rechercher.id_stage
        LEFT JOIN competence ON competence.id = rechercher.id_competence
        LEFT JOIN ville ON stage.id_ville = ville.id
        LEFT JOIN promotion ON stage.id_promotion = promotion.id
        LEFT JOIN candidater ON stage.id = candidater.id_stage
        GROUP BY stage.id, competence.id, ville.id;";
        $stmt = $this->conn->prepare($sql); 
        $stmt->execute(); 
        $data = $stmt->fetchAll(); 
        parent::sendJSON($data);
    }

    public function internshipBySearch($search) {
        $sql = "SELECT 
        stage.id AS id_offre,
        stage.nom AS nom_offre,
        entreprise.nom AS nom_entreprise,
        GROUP_CONCAT(DISTINCT competence.nom SEPARATOR ', ') AS competences_requises,
        ville.id AS id_ville,
        GROUP_CONCAT(DISTINCT ville.nom SEPARATOR ', ') AS localites,
        promotion.nom AS type_promotion_concerne,
        stage.date_debut AS date_debut_offre, 
        stage.date_fin AS date_fin_offre,
        DATEDIFF(stage.date_fin, stage.date_debut) AS duree_stage, -- Calcul de la durée du stage en jour
        FLOOR(DATEDIFF(stage.date_fin, stage.date_debut) / 30) AS duree_mois_stage, -- Durée du stage en mois (approximatif)
        stage.remuneration AS remuneration_base,
        stage.nb_place AS nombre_places_offertes,
        COUNT(DISTINCT candidater.id_utilisateur) AS nombre_etudiants_postules
        FROM stage
        INNER JOIN entreprise ON stage.id_entreprise = entreprise.id
        LEFT JOIN rechercher ON stage.id = rechercher.id_stage
        LEFT JOIN competence ON competence.id = rechercher.id_competence
        LEFT JOIN ville ON stage.id_ville = ville.id
        LEFT JOIN promotion ON stage.id_promotion = promotion.id
        LEFT JOIN candidater ON stage.id = candidater.id_stage
        WHERE stage.nom LIKE :recherche
        GROUP BY stage.id;";
        $stmt = $this->conn->prepare($sql); 
        $stmt->execute(['recherche' => '%'.$search.'%']); //permet de bind values et d'ajouter les % pour le like
        $data = $stmt->fetchAll(); 
        parent::sendJSON($data);
    }

    public function selectInternship($internshipId) {
        $sql = "SELECT 
        stage.id AS id_offre,
        stage.nom AS nom_offre,
        entreprise.nom AS nom_entreprise,
        GROUP_CONCAT(DISTINCT competence.nom SEPARATOR ', ') AS competences_requises,
        ville.id AS id_ville,
        GROUP_CONCAT(DISTINCT ville.nom SEPARATOR ', ') AS localites,
        promotion.nom AS type_promotion_concerne,
        stage.date_debut AS date_debut_offre, 
        stage.date_fin AS date_fin_offre,
        DATEDIFF(stage.date_fin, stage.date_debut) AS duree_stage, -- Calcul de la durée du stage en jour
        FLOOR(DATEDIFF(stage.date_fin, stage.date_debut) / 30) AS duree_mois_stage, -- Durée du stage en mois (approximatif)
        stage.remuneration AS remuneration_base,
        stage.nb_place AS nombre_places_offertes,
        COUNT(DISTINCT candidater.id_utilisateur) AS nombre_etudiants_postules
        FROM stage
        INNER JOIN entreprise ON stage.id_entreprise = entreprise.id
        LEFT JOIN rechercher ON stage.id = rechercher.id_stage
        LEFT JOIN competence ON competence.id = rechercher.id_competence
        LEFT JOIN ville ON stage.id_ville = ville.id
        LEFT JOIN promotion ON stage.id_promotion = promotion.id
        LEFT JOIN candidater ON stage.id = candidater.id_stage
        WHERE stage.id LIKE :id_stage
        GROUP BY stage.id;";
        $stmt = $this->conn->prepare($sql); 
        $stmt->execute(['id_stage' => $internshipId]); //permet de bind values et d'ajouter les % pour le like
        $data = $stmt->fetchAll(); 
        parent::sendJSON($data);
    }




    
    public function statSkill(){
        $req = "SELECT 
        competence.nom AS nom_competence,
        COUNT(*) AS nombre_apparition
        FROM competence
        INNER JOIN rechercher ON competence.id = rechercher.id_competence
        GROUP BY competence.nom
        ORDER BY COUNT(*) DESC";
        $stmt = $this->conn->prepare($req);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Fermeture du curseur du statement
        $stmt->closeCursor();
        parent::sendJSON($data);
    }

    
    public function statCity(){
        $req = "SELECT 
        ville.nom AS nom_ville,
        COUNT(*) AS nombre_apparition
        FROM stage
        INNER JOIN entreprise ON stage.id_entreprise = entreprise.id
        LEFT JOIN situer ON entreprise.id = situer.id_entreprise
        LEFT JOIN ville ON stage.id_ville = ville.id
        GROUP BY ville.nom
        ORDER BY COUNT(*) DESC";
        $stmt = $this->conn->prepare($req);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Fermeture du curseur du statement
        $stmt->closeCursor();
        parent::sendJSON($data);
    }

    
    public function statPromo(){
        $req = "SELECT 
        promotion.nom AS nom_promotion,
        COUNT(*) AS nombre_apparition
        FROM stage
        INNER JOIN promotion ON stage.id_promotion = promotion.id
        GROUP BY promotion.nom
        ORDER BY COUNT(*) DESC";
        $stmt = $this->conn->prepare($req);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Fermeture du curseur du statement
        $stmt->closeCursor();
        parent::sendJSON($data);
    }

    
    public function statDuration(){
        $req = "SELECT 
        DATEDIFF(stage.date_fin, stage.date_debut) AS duree_stage, -- Calcul de la durée du stage en jour
        COUNT(*) AS nombre_apparition
        FROM stage
        GROUP BY duree_stage
        ORDER BY duree_stage DESC";
        $stmt = $this->conn->prepare($req);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Fermeture du curseur du statement
        $stmt->closeCursor();
        parent::sendJSON($data);
    }

    
    public function statWish(){
        $req = "SELECT 
        stage.nom AS nom_stage,
        COUNT(*) AS nombre_apparition
        FROM stage
        INNER JOIN aimer ON stage.id = aimer.id_stage
        GROUP BY stage.id
        ORDER BY COUNT(*) DESC";
        $stmt = $this->conn->prepare($req);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Fermeture du curseur du statement
        $stmt->closeCursor();
        parent::sendJSON($data);
    }


}