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

function getEntrepriseBySecteur($secteur){
    $pdo = getConnexion();
    $req = "SELECT 
    entreprise.nom AS nom_entreprise,
    secteur.nom AS secteur_activite
FROM entreprise
INNER JOIN secteur ON entreprise.id_secteur = secteur.id
WHERE secteur.nom = :secteur";
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(":secteur", $secteur);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Fermeture du curseur du statement
    $stmt->closeCursor();
    sendJSON($data);
}

function getEntrepriseByVille($ville){
    $pdo = getConnexion();
    $req = "SELECT 
    entreprise.nom AS nom_entreprise,
    GROUP_CONCAT(DISTINCT ville.nom SEPARATOR ', ') AS ville
FROM entreprise
LEFT JOIN situer ON situer.id_entreprise = entreprise.id
LEFT JOIN ville ON situer.id_ville = ville.id
WHERE ville.nom :ville";
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(":ville", $ville);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Fermeture du curseur du statement
    $stmt->closeCursor();
    sendJSON($data);
}


function getEntrepriseByNote($note_min, $note_max){
    $pdo = getConnexion();
    $req = "SELECT 
    entreprise.nom AS nom_entreprise,
    AVG(evaluer.note) AS moyenne_evaluations
FROM entreprise
INNER JOIN evaluer ON entreprise.id = evaluer.id_entreprise
GROUP BY entreprise.nom
HAVING AVG(evaluer.note) < :note_max AND AVG(evaluer.note) >= :note_min";
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(":note_min", $note_min);
    $stmt->bindValue(":note_max", $note_max);
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



function getStageRecherche($recherche){
    $pdo = getConnexion();
    $req = "SELECT 
    stage.nom AS nom_offre,
    entreprise.nom AS nom_entreprise,
    GROUP_CONCAT(DISTINCT competence.nom SEPARATOR ', ') AS competences_requises,
    GROUP_CONCAT(DISTINCT ville.nom SEPARATOR ', ') AS localites,
    promotion.nom AS type_promotion_concerne,
    stage.date_debut AS date_debut_offre, 
    stage.date_fin AS date_fin_offre,
    DATEDIFF(stage.date_fin, stage.date_debut) AS duree_stage, -- Calcul de la durée du stage en jour
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
GROUP BY stage.id";
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(":recherche", '%' . $recherche . '%');
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Fermeture du curseur du statement
    $stmt->closeCursor();
    sendJSON($data);
}


function getConnexion(){
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=stagetier;charset=utf8;port=3306', 'root', '');
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