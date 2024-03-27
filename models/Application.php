<?php

class Application extends Model {

    public function allApplication() {
        
        $userId = $_SESSION['userData']['id'];

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
        stage.nb_place - COUNT(DISTINCT candidater.id_utilisateur) AS nombre_places_restantes,
        COUNT(DISTINCT candidater.id_utilisateur) AS nombre_etudiants_postules,
        candidater.etat AS etat_candidature,
        CASE WHEN aimer.id_utilisateur IS NOT NULL THEN aimer.id_stage ELSE NULL END AS id_stage_aimé,
        CASE WHEN candidater.id_utilisateur IS NOT NULL THEN stage.id ELSE NULL END AS id_stage_candidaté,
        candidater.cv AS cv,
        candidater.lettre_de_motivation AS lettre_motivation
        FROM stage
        INNER JOIN entreprise ON stage.id_entreprise = entreprise.id
        LEFT JOIN rechercher ON stage.id = rechercher.id_stage
        LEFT JOIN competence ON competence.id = rechercher.id_competence
        LEFT JOIN ville ON stage.id_ville = ville.id
        LEFT JOIN promotion ON stage.id_promotion = promotion.id
        LEFT JOIN candidater ON stage.id = candidater.id_stage AND candidater.id_utilisateur = :id_user
        LEFT JOIN aimer ON stage.id = aimer.id_stage AND aimer.id_utilisateur = :id_user
        WHERE aimer.id_utilisateur = :id_user OR candidater.id_utilisateur = :id_user
        GROUP BY stage.id";
        $stmt = $this->conn->prepare($sql); 
        $stmt->execute(['id_user' => $userId]); 
        $data = $stmt->fetchAll(); 
        parent::sendJSON($data);
    }

    public function applicationBySearch($search) {

        $userId = $_SESSION['userData']['id'];

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
        stage.nb_place - COUNT(DISTINCT candidater.id_utilisateur) AS nombre_places_restantes,
        COUNT(DISTINCT candidater.id_utilisateur) AS nombre_etudiants_postules,
        candidater.etat AS etat_candidature,
        CASE WHEN aimer.id_utilisateur IS NOT NULL THEN aimer.id_stage ELSE NULL END AS id_stage_aimé,
        CASE WHEN candidater.id_utilisateur IS NOT NULL THEN stage.id ELSE NULL END AS id_stage_candidaté,
        candidater.cv AS cv,
        candidater.lettre_de_motivation AS lettre_motivation
        FROM stage
        INNER JOIN entreprise ON stage.id_entreprise = entreprise.id
        LEFT JOIN rechercher ON stage.id = rechercher.id_stage
        LEFT JOIN competence ON competence.id = rechercher.id_competence
        LEFT JOIN ville ON stage.id_ville = ville.id
        LEFT JOIN promotion ON stage.id_promotion = promotion.id
        LEFT JOIN candidater ON stage.id = candidater.id_stage AND candidater.id_utilisateur = :id_user
        LEFT JOIN aimer ON stage.id = aimer.id_stage AND aimer.id_utilisateur = :id_user
        WHERE stage_nom LIKE :recherche
        AND aimer.id_utilisateur = :id_user OR candidater.id_utilisateur = :id_user
        GROUP BY stage.id";
        $stmt = $this->conn->prepare($sql); 
        $stmt->execute(['recherche' => '%'.$search.'%',     //permet de bind values et d'ajouter les % pour le like
                        'id_user' => $userId]); 
        $data = $stmt->fetchAll(); 
        parent::sendJSON($data);
    }

    public function selectApplication($applicationId) {

        $userId = $_SESSION['userData']['id'];

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
        stage.nb_place - COUNT(DISTINCT candidater.id_utilisateur) AS nombre_places_restantes,
        COUNT(DISTINCT candidater.id_utilisateur) AS nombre_etudiants_postules,
        candidater.etat AS etat_candidature,
        CASE WHEN aimer.id_utilisateur IS NOT NULL THEN aimer.id_stage ELSE NULL END AS id_stage_aimé,
        CASE WHEN candidater.id_utilisateur IS NOT NULL THEN stage.id ELSE NULL END AS id_stage_candidaté,
        candidater.cv AS cv,
        candidater.lettre_de_motivation AS lettre_motivation
        FROM stage
        INNER JOIN entreprise ON stage.id_entreprise = entreprise.id
        LEFT JOIN rechercher ON stage.id = rechercher.id_stage
        LEFT JOIN competence ON competence.id = rechercher.id_competence
        LEFT JOIN ville ON stage.id_ville = ville.id
        LEFT JOIN promotion ON stage.id_promotion = promotion.id
        LEFT JOIN candidater ON stage.id = candidater.id_stage AND candidater.id_utilisateur = :id_user
        LEFT JOIN aimer ON stage.id = aimer.id_stage AND aimer.id_utilisateur = :id_user
        WHERE stage.id LIKE :id_stage
        GROUP BY stage.id";
        $stmt = $this->conn->prepare($sql); 
        $stmt->execute(['id_stage' => $applicationId,
                        'id_user' => $userId]); //permet de bind values et d'ajouter les % pour le like
        $data = $stmt->fetchAll(); 
        parent::sendJSON($data);
    }

    public function allApplicationByStudent($userId) {

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
        stage.nb_place - COUNT(DISTINCT candidater.id_utilisateur) AS nombre_places_restantes,
        COUNT(DISTINCT candidater.id_utilisateur) AS nombre_etudiants_postules,
        candidater.etat AS etat_candidature,
        CASE WHEN aimer.id_utilisateur IS NOT NULL THEN aimer.id_stage ELSE NULL END AS id_stage_aimé,
        CASE WHEN candidater.id_utilisateur IS NOT NULL THEN stage.id ELSE NULL END AS id_stage_candidaté,
        candidater.cv AS cv,
        candidater.lettre_de_motivation AS lettre_motivation
        FROM stage
        INNER JOIN entreprise ON stage.id_entreprise = entreprise.id
        LEFT JOIN rechercher ON stage.id = rechercher.id_stage
        LEFT JOIN competence ON competence.id = rechercher.id_competence
        LEFT JOIN ville ON stage.id_ville = ville.id
        LEFT JOIN promotion ON stage.id_promotion = promotion.id
        LEFT JOIN candidater ON stage.id = candidater.id_stage AND candidater.id_utilisateur = :id_user
        LEFT JOIN aimer ON stage.id = aimer.id_stage AND aimer.id_utilisateur = :id_user
        WHERE aimer.id_utilisateur = :id_user OR candidater.id_utilisateur = :id_user
        GROUP BY stage.id";
        $stmt = $this->conn->prepare($sql); 
        $stmt->execute(['id_user' => $userId]); 
        $data = $stmt->fetchAll(); 
        parent::sendJSON($data);
    }

    public function uploadFile($internshipId, $dest_filename) {

        $userId = $_SESSION['userData']['id'];

        $sql = "INSERT INTO candidater (id_stage, id_utilisateur, cv, lettre_de_motivation, etat)
                VALUES (:id_stage, :id_user, :cv, '', NULL);";
        $stmt = $this->conn->prepare($sql); 
        $stmt->execute(['id_stage' => $internshipId,
                        'id_user' => $userId,
                        'cv' => $dest_filename]); //permet de bind values et d'ajouter les % pour le like

        

        $this->conn->commit();

    }

    public function submitApplication($internshipId, $file, $letter) {

        $userId = $_SESSION['userData']['id'];

        define("DS", DIRECTORY_SEPARATOR);
        $dossier_destination = $_SERVER['DOCUMENT_ROOT'] . DS . 'uploads'. DS;
        // exemple : $dossier_destination contient "C:/www/projetWEB\uploads\"

        if (isset($_FILES['cv'])) {
            // ok, il y a un fichier uploadé
            // pour ne pas ré-écrire :
            $cv = $_FILES['cv'];

            // créer un nouveau nom de fichier :
            $dest_filename =  time() . "_" . $cv["name"];  // ex: 1499999999999_anglais.pptx
            // exemple : $cv["tmp_name"] => string(24) "C:\xampp\tmp\php8B01.tmp"
            //  "C:\xampp\tmp\php8B01.tmp"  =>  "C:/www/projetWEB\uploads\1499999999999_anglais.pptx"
            move_uploaded_file($cv['tmp_name'], $dossier_destination . $dest_filename);
        } else {
            $dest_filename = "";
        }

        $sql = "INSERT INTO candidater (id_stage, id_utilisateur, cv, lettre_de_motivation, etat)
                VALUES (:id_stage, :id_user, :cv, :lettre, 0);";

        $stmt = $this->conn->prepare($sql); 
        $stmt->execute(['id_stage' => $internshipId,
                        'id_user' => $userId,
                        'cv' => $dest_filename,
                        'lettre' => $letter]); //permet de bind values et d'ajouter les % pour le like

    }


}