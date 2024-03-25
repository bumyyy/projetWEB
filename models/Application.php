<?php

class Application extends Model {

    public function allApplication() {
        $sql = "SELECT 
        stage.id AS id_offre,
        stage.nom AS nom_offre,
        entreprise.nom AS nom_entreprise,
        GROUP_CONCAT(DISTINCT competence.nom SEPARATOR ', ') AS competences_requises,
        ville.id AS id_ville,
        GROUP_CONCAT(DISTINCT ville.nom SEPARATOR ', ') AS nom_ville,
        promotion.nom AS nom_promotion,
        stage.date_debut AS date_debut_offre, 
        stage.date_fin AS date_fin_offre,
        DATEDIFF(stage.date_fin, stage.date_debut) AS duree_stage,
        FLOOR(DATEDIFF(stage.date_fin, stage.date_debut) / 30) AS duree_mois_stage,
        stage.remuneration AS remuneration_base,
        stage.nb_place AS nombre_places_offertes,
        COUNT(DISTINCT candidater.id_utilisateur) AS nombre_etudiants_postules,
        candidater.etat AS etat_candidature,
        CASE WHEN aimer.id_utilisateur IS NOT NULL THEN aimer.id_stage ELSE NULL END AS id_stage_aimé,
        CASE WHEN candidater.id_utilisateur IS NOT NULL THEN stage.id ELSE NULL END AS id_stage_candidaté
        FROM stage
        INNER JOIN entreprise ON stage.id_entreprise = entreprise.id
        LEFT JOIN rechercher ON stage.id = rechercher.id_stage
        LEFT JOIN competence ON competence.id = rechercher.id_competence
        LEFT JOIN ville ON stage.id_ville = ville.id
        LEFT JOIN promotion ON stage.id_promotion = promotion.id
        LEFT JOIN candidater ON stage.id = candidater.id_stage AND candidater.id_utilisateur = 1
        LEFT JOIN aimer ON stage.id = aimer.id_stage AND aimer.id_utilisateur = 1
        WHERE aimer.id_utilisateur = 1 OR candidater.id_utilisateur = 1
        GROUP BY stage.id";
        $stmt = $this->conn->prepare($sql); 
        $stmt->execute(); 
        $data = $stmt->fetchAll(); 
        parent::sendJSON($data);
    }

    public function applicationBySearch($search) {
        $sql = "SELECT 
        stage.id AS id_offre,
        stage.nom AS nom_offre,
        entreprise.nom AS nom_entreprise,
        GROUP_CONCAT(DISTINCT competence.nom SEPARATOR ', ') AS competences_requises,
        ville.id AS id_ville,
        GROUP_CONCAT(DISTINCT ville.nom SEPARATOR ', ') AS nom_ville,
        promotion.nom AS nom_promotion,
        stage.date_debut AS date_debut_offre, 
        stage.date_fin AS date_fin_offre,
        DATEDIFF(stage.date_fin, stage.date_debut) AS duree_stage,
        FLOOR(DATEDIFF(stage.date_fin, stage.date_debut) / 30) AS duree_mois_stage,
        stage.remuneration AS remuneration_base,
        stage.nb_place AS nombre_places_offertes,
        COUNT(DISTINCT candidater.id_utilisateur) AS nombre_etudiants_postules,
        candidater.etat AS etat_candidature,
        CASE WHEN aimer.id_utilisateur IS NOT NULL THEN aimer.id_stage ELSE NULL END AS id_stage_aimé,
        CASE WHEN candidater.id_utilisateur IS NOT NULL THEN stage.id ELSE NULL END AS id_stage_candidaté
        FROM stage
        INNER JOIN entreprise ON stage.id_entreprise = entreprise.id
        LEFT JOIN rechercher ON stage.id = rechercher.id_stage
        LEFT JOIN competence ON competence.id = rechercher.id_competence
        LEFT JOIN ville ON stage.id_ville = ville.id
        LEFT JOIN promotion ON stage.id_promotion = promotion.id
        LEFT JOIN candidater ON stage.id = candidater.id_stage AND candidater.id_utilisateur = 1
        LEFT JOIN aimer ON stage.id = aimer.id_stage AND aimer.id_utilisateur = 1
        WHERE stage_nom LIKE :recherche
        AND aimer.id_utilisateur = 1 OR candidater.id_utilisateur = 1
        GROUP BY stage.id";
        $stmt = $this->conn->prepare($sql); 
        $stmt->execute(['recherche' => '%'.$search.'%']); //permet de bind values et d'ajouter les % pour le like
        $data = $stmt->fetchAll(); 
        parent::sendJSON($data);
    }

    public function selectApplication($applicationId) {
        $sql = "SELECT 
        stage.id AS id_offre,
        stage.nom AS nom_offre,
        entreprise.nom AS nom_entreprise,
        GROUP_CONCAT(DISTINCT competence.nom SEPARATOR ', ') AS competences_requises,
        ville.id AS id_ville,
        GROUP_CONCAT(DISTINCT ville.nom SEPARATOR ', ') AS nom_ville,
        promotion.nom AS nom_promotion,
        stage.date_debut AS date_debut_offre, 
        stage.date_fin AS date_fin_offre,
        DATEDIFF(stage.date_fin, stage.date_debut) AS duree_stage, -- Calcul de la durée du stage en jour
        FLOOR(DATEDIFF(stage.date_fin, stage.date_debut) / 30) AS duree_mois_stage, -- Durée du stage en mois (approximatif)
        stage.remuneration AS remuneration_base,
        stage.nb_place AS nombre_places_offertes,
        COUNT(DISTINCT candidater.id_utilisateur) AS nombre_etudiants_postules,
        candidater.etat AS etat_candidature,
        aimer.id_stage AS id_stage
        FROM stage
        INNER JOIN entreprise ON stage.id_entreprise = entreprise.id
        LEFT JOIN rechercher ON stage.id = rechercher.id_stage
        LEFT JOIN competence ON competence.id = rechercher.id_competence
        LEFT JOIN ville ON stage.id_ville = ville.id
        LEFT JOIN promotion ON stage.id_promotion = promotion.id
        LEFT JOIN candidater ON stage.id = candidater.id_stage
        WHERE stage.id LIKE :id_stage
        GROUP BY stage.id";
        $stmt = $this->conn->prepare($sql); 
        $stmt->execute(['id_stage' => $applicationId]); //permet de bind values et d'ajouter les % pour le like
        $data = $stmt->fetchAll(); 
        parent::sendJSON($data);
    }


}