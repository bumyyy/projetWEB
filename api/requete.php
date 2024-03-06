<?php



function isMdp($mail, $mdp_a_verif) {
    $pdo = getConnexion();
    $req = "SELECT mdp FROM utilisateur WHERE mail = :mail";
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(":mail", $mail);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC); 

    // Fermeture du curseur du statement
    $stmt->closeCursor();

    // Vérifiez si un mot de passe a été récupéré et comparez-le
    if ($data && $mdp_a_verif == $data['mdp']) {
        // Si le mot de passe correspond
        sendJSON(['success' => true]);
    } else {
        // Si le mot de passe ne correspond pas ou l'utilisateur n'existe pas
        sendJSON(['success' => false]);
    }
}


function getSecteur() {
    $pdo = getConnexion();
    $req = "SELECT nom FROM secteur";
    $stmt = $pdo->prepare($req);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Fermeture du curseur du statement
    $stmt->closeCursor();
    sendJSON($data);
}

function getVille() {
    $pdo = getConnexion();
    $req = "SELECT nom FROM ville";
    $stmt = $pdo->prepare($req);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Fermeture du curseur du statement
    $stmt->closeCursor();
    sendJSON($data);
}

function getAllEntreprise(){
    $pdo = getConnexion();
    $req = "SELECT 
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
GROUP BY entreprise.id;";
    $stmt = $pdo->prepare($req);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Fermeture du curseur du statement
    $stmt->closeCursor();
    sendJSON($data);
}

function getEntrepriseByRecherche($recherche){
    $pdo = getConnexion();
    $req = "SELECT 
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
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(":recherche", '%'.$recherche.'%');
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Fermeture du curseur du statement
    $stmt->closeCursor();
    sendJSON($data);
}


function getConnexion(){
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=stagetier;charset=utf8;port=3306', 'root', '1234');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Erreur de connexion à la base de données: " . $e->getMessage());
    }
}


function sendJSON($infos){
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    echo json_encode($infos, JSON_UNESCAPED_UNICODE);
}