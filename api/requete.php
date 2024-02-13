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