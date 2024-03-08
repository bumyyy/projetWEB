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

    $mdpHashVerif = hash('sha256', $mdp_a_verif);
    // Vérifiez si un mot de passe a été récupéré et comparez-le
    if ($data && $mdpHashVerif == $data['mdp']) {  //utilisée pour vérifier si le mot de passe fourni par l'utilisateur correspond au hash du mot de passe stocké dans la base de données
        // Si le mot de passe correspond
        sendJSON(['success' => true]);
    } else {
        // Si le mot de passe ne correspond pas ou l'utilisateur n'existe pas
        sendJSON(['success' => false]);
    }
}

function getUtilisateur($mail){
    $pdo = getConnexion();
    $req = "SELECT id, type_  FROM utilisateur WHERE mail = :mail";
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(":mail", $mail);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Fermeture du curseur du statement
    $stmt->closeCursor();
    sendJSON($data);    
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
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(":recherche", '%'.$recherche.'%');
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Fermeture du curseur du statement
    $stmt->closeCursor();
    sendJSON($data);
}



function getStatsBySecteur(){
    $pdo = getConnexion();
    $req = "SELECT secteur.nom AS nom_secteur,
    COUNT(*) AS nombre_apparition
FROM secteur
INNER JOIN entreprise ON secteur.id = entreprise.id_secteur
GROUP BY secteur.nom
ORDER BY COUNT(*) DESC";
    $stmt = $pdo->prepare($req);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Fermeture du curseur du statement
    $stmt->closeCursor();
    sendJSON($data);
}

function getStatsByVille(){
    $pdo = getConnexion();
    $req = "SELECT ville.nom AS nom_ville,
    COUNT(*) AS nombre_entreprise
FROM ville
INNER JOIN situer ON situer.id_ville = ville.id
GROUP BY ville.nom
ORDER BY COUNT(*) DESC";
    $stmt = $pdo->prepare($req);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Fermeture du curseur du statement
    $stmt->closeCursor();
    sendJSON($data);
}


function getStatsByNote(){
    $pdo = getConnexion();
    $req = "SELECT 
    secteur.nom AS secteur_activite,
    GROUP_CONCAT(DISTINCT ville.nom SEPARATOR ', ') AS ville,
    AVG(evaluer.note) AS moyenne_evaluations
FROM entreprise
INNER JOIN secteur ON entreprise.id_secteur = secteur.id
LEFT JOIN situer ON situer.id_entreprise = entreprise.id
LEFT JOIN ville ON situer.id_ville = ville.id
LEFT JOIN stage ON stage.id_entreprise = entreprise.id
LEFT JOIN evaluer ON entreprise.id = evaluer.id_entreprise
GROUP BY entreprise.id";
    $stmt = $pdo->prepare($req);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Fermeture du curseur du statement
    $stmt->closeCursor();
    sendJSON($data);
}

function deleteEntreprise($idEntreprise){
    $pdo = getConnexion();
    $req = "DELETE FROM entreprise WHERE id = :id;";
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(":id",$idEntreprise);
    $stmt->execute();
    // Fermeture du curseur du statement
    $stmt->closeCursor();
    if ($stmt->rowCount() > 0){ //retourne le nombre de lignes affectées par la dernière requête
    sendJSON(['success' => true]);}
    else { sendJSON(['success' => false]);}
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