<?php
session_start();
class Company extends Model {

    public function allCompany() {
        $sql = "SELECT 
        entreprise.id AS id_entreprise,
        entreprise.nom AS nom_entreprise,
        secteur.nom AS secteur_activite,
        secteur.id AS id_secteur,
        GROUP_CONCAT(DISTINCT ville.nom SEPARATOR ',') AS ville,
        GROUP_CONCAT(DISTINCT ville.id SEPARATOR ',') AS id_ville,
        COUNT(DISTINCT candidater.id_stage) AS nb_stagiaires_postules,
        AVG(evaluer.note) AS moyenne_evaluations
        FROM entreprise
        INNER JOIN secteur ON entreprise.id_secteur = secteur.id
        LEFT JOIN situer ON situer.id_entreprise = entreprise.id
        LEFT JOIN ville ON situer.id_ville = ville.id
        LEFT JOIN stage ON stage.id_entreprise = entreprise.id
        LEFT JOIN candidater ON stage.id = candidater.id_stage
        LEFT JOIN evaluer ON entreprise.id = evaluer.id_entreprise
        WHERE hide = 0
        GROUP BY entreprise.id;";
        $stmt = $this->conn->prepare($sql); 
        $stmt->execute(); 
        $data = $stmt->fetchAll(); 
        parent::sendJSON($data);
    }

    public function companyBySearch($search) {
        $sql = "SELECT 
        entreprise.id AS id_entreprise,
        entreprise.nom AS nom_entreprise,
        secteur.nom AS secteur_activite,
        secteur.id AS id_secteur,
        GROUP_CONCAT(DISTINCT ville.nom SEPARATOR ', ') AS ville,
        GROUP_CONCAT(DISTINCT ville.id SEPARATOR ',') AS id_ville,
        COUNT(DISTINCT candidater.id_stage) AS nb_stagiaires_postules,
        AVG(evaluer.note) AS moyenne_evaluations
        FROM entreprise
        INNER JOIN secteur ON entreprise.id_secteur = secteur.id
        LEFT JOIN situer ON situer.id_entreprise = entreprise.id
        LEFT JOIN ville ON situer.id_ville = ville.id
        LEFT JOIN stage ON stage.id_entreprise = entreprise.id
        LEFT JOIN candidater ON stage.id = candidater.id_stage
        LEFT JOIN evaluer ON entreprise.id = evaluer.id_entreprise
        WHERE entreprise.nom like :recherche
        GROUP BY entreprise.id;";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['recherche' => '%'.$search.'%']); //permet de bind values et d'ajouter les % pour le like
        $data = $stmt->fetchAll(); 
        parent::sendJSON($data);
    }

    public function selectCompany($companyId) {         // faudra prendre en compte l'id de l'utilisateur pour la note
        $sql = "SELECT 
        entreprise.id AS id_entreprise,
        entreprise.nom AS nom_entreprise,
        secteur.nom AS secteur_activite,
        GROUP_CONCAT(DISTINCT ville.nom SEPARATOR ', ') AS ville,
        COUNT(DISTINCT candidater.id_stage) AS nb_stagiaires_postules,
        AVG(evaluer.note) AS moyenne_evaluations
        FROM entreprise
        INNER JOIN secteur ON entreprise.id_secteur = secteur.id
        LEFT JOIN situer ON situer.id_entreprise = entreprise.id
        LEFT JOIN ville ON situer.id_ville = ville.id
        LEFT JOIN stage ON stage.id_entreprise = entreprise.id
        LEFT JOIN candidater ON stage.id = candidater.id_stage
        LEFT JOIN evaluer ON entreprise.id = evaluer.id_entreprise
        WHERE entreprise.id LIKE :id_entreprise;";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id_entreprise' => $companyId]);    //permet de bind values
        $data = $stmt->fetchAll(); 
        parent::sendJSON($data);
    }


   
    public function addCompany($companyName, $countryIds, $sectorId, $rate) {
        $this->conn->beginTransaction();
        
        $sqlCompany = "INSERT INTO entreprise (nom, id_secteur) VALUES (:nom_entreprise, :secteur_id)";
        $stmtCompany = $this->conn->prepare($sqlCompany);
        $stmtCompany->execute(['nom_entreprise' => $companyName ,
                        'secteur_id' => $sectorId]); //permet de bind values
        
        $companyId = $this->conn->lastInsertId();

        $sqlLocation ="INSERT INTO situer (id_entreprise, id_ville) VALUES (:entreprise_id, :ville_id)";
        $stmtLocation = $this->conn->prepare($sqlLocation);

        $countryIds = explode(',', $countryIds);
        foreach ($countryIds as $countryId) {
            $stmtLocation->execute(['entreprise_id' => $companyId ,
                                    'ville_id' => $countryId]);
        }

        $sqlRating = "INSERT INTO evaluer (id_entreprise, id_utilisateur, note) VALUES (:entreprise_id, 1, :note)";
        $stmtRating = $this->conn->prepare($sqlRating);
        $stmtRating->execute(['entreprise_id' => $companyId ,
                              'note' => $rate]); //permet de bind values

        $this->conn->commit();
    }

    public function editCompany($companyId, $companyName, $cityIds, $sectorId, $rate) {
        $this->conn->beginTransaction();

        // Modifier l'entreprise
        $sqlCompany = "UPDATE entreprise SET nom = :nom_entreprise, id_secteur = :secteur_id WHERE id = :id_entreprise";
        $stmtCompany = $this->conn->prepare($sqlCompany);
        $stmtCompany->execute(['id_entreprise' => $companyId ,
                        'nom_entreprise' => $companyName , 
                        'secteur_id' => $sectorId]); //permet de bind values

        // Modifier les relations entre l'entreprise et les villes
        // Premièrement, supprimer toutes les anciennes relations pour cette entreprise
        $sqlDeleteLocation = "DELETE FROM situer WHERE id_entreprise = :id_entreprise";
        $stmtDeleteLocation = $this->conn->prepare($sqlDeleteLocation);
        $stmtDeleteLocation->execute(['id_entreprise' => $companyId]); //permet de bind values

        // Ensuite, insérer les nouvelles relations
        $sqlLocation = "INSERT INTO situer (id_entreprise, id_ville) VALUES (:id_entreprise, :ville_id)";
        $stmtLocation = $this->conn->prepare($sqlLocation);
        $cityIds = explode(',', $cityIds);
        foreach ($cityIds as $cityId) {
            $stmtLocation->execute(['id_entreprise' => $companyId ,
                              'ville_id' => $cityId]); //permet de bind values
        }

        // Modifier l'évaluation de l'entreprise
        $sqlRating = "UPDATE evaluer SET note = :note WHERE id_entreprise = :id_entreprise AND id_utilisateur = 1";
        $stmtRating = $this->conn->prepare($sqlRating);
        $stmtRating->execute(['id_entreprise' => $companyId ,
                        //'id_utilisateur' => $userId;
                        'note' => $rate]); //permet de bind values

        $this->conn->commit();
    }


    public function deleteCompany($companyId) {
        $sql = "UPDATE entreprise SET hide = 1 WHERE id = :id;";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $companyId]);
        $_SESSION["message"] = "Deleted";
    }

}