<?php

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


function addCompany() {
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