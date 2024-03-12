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
    $req = "SELECT id, nom FROM secteur ORDER BY nom ASC";
    $stmt = $pdo->prepare($req);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Fermeture du curseur du statement
    $stmt->closeCursor();
    sendJSON($data);
}

function getVille() {
    $pdo = getConnexion();
    $req = "SELECT id, nom FROM ville ORDER BY nom ASC";
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
WHERE ville.nom :ville;
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


function getStage(){
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
GROUP BY stage.id";
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

function addCompany($nom_entreprise, $ville_ids, $secteur_id, $note) {
    $pdo = getConnexion();

    try {
        $pdo->beginTransaction();

        // Insérer l'entreprise
        $req_entreprise = "INSERT INTO entreprise (nom, id_secteur) VALUES (:nom_entreprise, :secteur_id)";
        $stmt_entreprise = $pdo->prepare($req_entreprise);
        $stmt_entreprise->bindValue(":nom_entreprise", $nom_entreprise);
        $stmt_entreprise->bindValue(":secteur_id", $secteur_id);
        $stmt_entreprise->execute();

        // Récupérer l'ID de l'entreprise insérée
        $entreprise_id = $pdo->lastInsertId();

        // Insérer les relations entre l'entreprise et les villes
        $req_situer = "INSERT INTO situer (id_entreprise, id_ville) VALUES (:entreprise_id, :ville_id)";
        $stmt_situer = $pdo->prepare($req_situer);

        $ville_ids = explode(',', $ville_ids);
        foreach ($ville_ids as $ville_id) {
            $stmt_situer->bindValue(":entreprise_id", $entreprise_id);
            $stmt_situer->bindValue(":ville_id", $ville_id);
            $stmt_situer->execute();
        }

        // Insérer l'évaluation de l'entreprise
        $req_evaluer = "INSERT INTO evaluer (id_entreprise, id_utilisateur, note) VALUES (:entreprise_id, 1, :note)";
        $stmt_evaluer = $pdo->prepare($req_evaluer);
        $stmt_evaluer->bindValue(":entreprise_id", $entreprise_id);
        $stmt_evaluer->bindValue(":note", $note);
        $stmt_evaluer->execute();

        // Valider la transaction
        $pdo->commit();

    } catch (PDOException $e) {
        // En cas d'erreur, annuler la transaction
        $pdo->rollBack();
        echo "Erreur : " . $e->getMessage();
    }
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