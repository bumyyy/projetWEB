<?php

// Include config.php file
require_once 'Config.php';

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

    public function country() {
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
        WHERE entreprise.nom like :recherche
        GROUP BY entreprise.id;";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['recherche' => '%'.$search.'%']); //permet de bind values et d'ajouter les % pour le like
        $data = $stmt->fetchAll(); 
        parent::sendJSON($data);
    }
    function getStatsBySecteur(){
        $req = "SELECT secteur.nom AS nom_secteur,
        COUNT(*) AS nombre_apparition
    FROM secteur
    INNER JOIN entreprise ON secteur.id = entreprise.id_secteur
    GROUP BY secteur.nom
    ORDER BY COUNT(*) DESC";
        $stmt = $this->conn->prepare($req);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Fermeture du curseur du statement
        $stmt->closeCursor();
        parent::sendJSON($data);
    }
    
    function getStatsByVille(){
        $req = "SELECT ville.nom AS nom_ville,
        COUNT(*) AS nombre_entreprise
    FROM ville
    INNER JOIN situer ON situer.id_ville = ville.id
    GROUP BY ville.nom
    ORDER BY COUNT(*) DESC";
        $stmt = $this->conn->prepare($req);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Fermeture du curseur du statement
        $stmt->closeCursor();
        parent::sendJSON($data);
    }
    
    
    function getStatsByNote(){
        $req = "SELECT 
        entreprise.nom AS nom_entrprise,
        secteur.nom AS secteur_activite,
        GROUP_CONCAT(DISTINCT ville.nom SEPARATOR ', ') AS ville,
        AVG(evaluer.note) AS moyenne_evaluations
    FROM entreprise
    INNER JOIN secteur ON entreprise.id_secteur = secteur.id
    LEFT JOIN situer ON situer.id_entreprise = entreprise.id
    LEFT JOIN ville ON situer.id_ville = ville.id
    LEFT JOIN stage ON stage.id_entreprise = entreprise.id
    LEFT JOIN evaluer ON entreprise.id = evaluer.id_entreprise
    GROUP BY entreprise.id
    ORDER BY moyenne_evaluations DESC
    LIMIT 3";
        $stmt = $this->conn->prepare($req);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Fermeture du curseur du statement
        $stmt->closeCursor();
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

    public function editCompany($mail, $password) {
        $data = 'a faire'; 
    }

    public function deleteCompany($companyId) {
        $sql = "UPDATE entreprise SET hide = 1 WHERE id = :id;";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $companyId]);
        $_SESSION["message"] = "Deleted";
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