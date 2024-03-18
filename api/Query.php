<?php

// Include config.php file
include_once 'Config.php';

// Database hérite de la classe Config
// Lorsque vous appelez le constructeur d'une classe enfant qui étend une classe parente, 
//le constructeur de la classe parente est automatiquement exécuté avant le constructeur de la classe enfant
class Password extends Config {

  public function isPassword($mail, $password) {
    $sql = 'SELECT mdp,type_, nom, prenom, id_promotion FROM utilisateur WHERE mail = :mail';
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['mail' => $mail]); //permet de bind values
    $data = $stmt->fetch(); 
    
    $passwordHashed = hash('sha256', $password);
    // Vérifiez si un mot de passe a été récupéré et comparez-le
    if ($data && $passwordHashed == $data['mdp']) {  //utilisée pour vérifier si le mot de passe fourni par l'utilisateur correspond au hash du mot de passe stocké dans la base de données
        // Si le mot de passe correspond
        parent::sendJSON(['success' => true, 'type_' => $data['type_'],
        'nom' => $data['nom'],
        'prenom' => $data['prenom'],
        'id_promotion' => $data['id_promotion']]) ;
    } else {
        // Si le mot de passe ne correspond pas ou l'utilisateur n'existe pas
        parent::sendJSON(['success' => false]);
    }
  }

}


class Combox extends Config {

    public function sector() {
        $sql = 'SELECT id, nom FROM secteur ORDER BY nom ASC';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(); 
        $data = $stmt->fetchAll(); 
        parent::sendJSON($data);
    }

    public function city() {
        $sql = 'SELECT id, nom FROM ville ORDER BY nom ASC';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(); 
        $data = $stmt->fetchAll(); 
        parent::sendJSON($data);
    }

    public function rate() {
        $data = 'a faire';
        parent::sendJSON($data);
    }

}


class Company extends Config {

    public function allCompany() {
        $sql = "SELECT 
        entreprise.id AS id_entreprise,
        entreprise.nom AS nom_entreprise,
        secteur.nom AS secteur_activite,
        GROUP_CONCAT(DISTINCT ville.nom SEPARATOR ',') AS ville,
        COUNT(DISTINCT candidater.id_stage) AS nb_stagiaires_postules,
        AVG(evaluer.note) AS moyenne_evaluations
        FROM entreprise
        INNER JOIN secteur ON entreprise.id_secteur = secteur.id
        LEFT JOIN situer ON situer.id_entreprise = entreprise.id
        LEFT JOIN ville ON situer.id_ville = ville.id
        LEFT JOIN stage ON stage.id_entreprise = entreprise.id
        LEFT JOIN candidater ON stage.id = candidater.id_stage
        LEFT JOIN evaluer ON entreprise.id = evaluer.id_entreprise
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
        WHERE entreprise.nom LIKE :recherche
        GROUP BY entreprise.id;";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['recherche' => '%'.$search.'%']); //permet de bind values et d'ajouter les % pour le like
        $data = $stmt->fetchAll(); 
        parent::sendJSON($data);
    }

   
    public function addCompany($companyName, $cityIds, $sectorId, $rate) {
        $this->conn->beginTransaction();
        
        $sqlCompany = "INSERT INTO entreprise (nom, id_secteur) VALUES (:nom_entreprise, :secteur_id)";
        $stmtCompany = $this->conn->prepare($sqlCompany);
        $stmtCompany->execute(['nom_entreprise' => $companyName ,
                        'secteur_id' => $sectorId]); //permet de bind values
        
        $companyId = $this->conn->lastInsertId();

        $sqlLocation ="INSERT INTO situer (id_entreprise, id_ville) VALUES (:entreprise_id, :ville_id)";
        $stmtLocation = $this->conn->prepare($sqlLocation);

        $cityIds = explode(',', $cityIds);
        foreach ($cityIds as $cityId) {
            $stmtLocation->execute(['entreprise_id' => $companyId ,
                                    'ville_id' => $cityId]);
        }

        $sqlRating = "INSERT INTO evaluer (id_entreprise, id_utilisateur, note) VALUES (:entreprise_id, 1, :note)";
        $stmtRating = $this->conn->prepare($sqlRating);
        $stmtRating->execute(['entreprise_id' => $companyId ,
                              'note' => $rate]); //permet de bind values

        $this->conn->commit();
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
        $sql = "DELETE FROM entreprise WHERE id = :id;";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $companyId]);
    }

}


class User extends Config {

    public function getUserByMail($mail) {
        $sql = "SELECT id, type_  FROM utilisateur WHERE mail = :mail";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(["mail" => $mail]); 
        $data = $stmt->fetchAll(); 
        parent::sendJSON($data);
    }

}