<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stage_tier</title>
    <link rel="stylesheet" href="Entreprises_accueil.css">
</head>
<body>
    
<header class="header">
    <div class="header-logo">
        <img src="img/logo.png" alt="Logo">
    </div>
    <nav>
        <ul class="header-nav">
            <li>Stages</li>
            <li>Entreprises</li>
            <li>Pilotes</li>
            <li>Étudiants</li>
            <li>Candidature</li>
        </ul>
    </nav>
    <div class="header-icons">
        <img src="img/reglage.png" alt="Réglages">
        <img src="img/profile.png" alt="Profil">
    </div>
</header>

<div class="content">
    <h1>Entreprises</h1>

    <input type="text" placeholder="Recherchez une Entreprises">

    <div class="combox">
    <select name="secteur d'activité" id="act_sec">
        <?php include 'fillCombox.php'; ?>
        </select>
    <select name="localité" id="localité">
        <option value="Aix-en-Provence">Aix-en-Provence</option>
        <option value="Marseille">Marseille</option>
        <option value="Paris">Paris</option>
        <option value="Nice">Nice</option>
        </select>

    <select name="évaluation" id="rate">
        <option value="1 étoile">1 étoile</option>
        <option value="2 étoiles">2 étoiles</option>
        <option value="3 étoiles">3 étoiles</option>
        <option value="4 étoiles">4 étoiles</option>
        <option value="5 étoiles">5 étoiles</option>
        </select>
    </div>

</div>

<footer class="footer">
    <img src="img/youtube.png" alt="YouTube">
    <img src="img/linkedin.png" alt="LinkedIn">
    <img src="img/facebook.png" alt="Facebook">
    <img src="img/twitter.png" alt="Twitter">
    <img src="img/instagram.png" alt="Instagram">
    <p>© 2024 Stage_Tier - Tous droits réservés</p>
</footer>

<!-- Popup -->
<div id="popup" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closePopup()">&times;</span>
        <p>L'entreprise a été créée avec succès !</p>
    </div>
</div>

<script src="Entreprises_accueil.js"></script>
</body>
</html>


<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données POST
    $nom_entreprise = $_POST['nom'];
    $secteur_nom = $_POST['secteur'][0]; // Comme c'est un tableau, prenez juste le premier élément
    $ville_nom = $_POST['localite'][0]; // Comme c'est un tableau, prenez juste le premier élément
    $note = $_POST['rating-value'];

    // Appeler la fonction pour insérer les données
    insererEntreprise($nom_entreprise, $secteur_nom, $ville_nom, $note);
}


function insererEntreprise($nom_entreprise, $secteur_nom, $ville_nom, $note) {
    // Récupérer l'ID du secteur d'activité
    $pdo = getConnexion();
    $req = "SELECT id FROM secteur WHERE nom = :secteur_nom";
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(':secteur_nom', $secteur_nom);
    $stmt->execute();
    $id_secteur = $stmt->fetchColumn();
    $stmt->closeCursor();

    // Récupérer l'ID de la ville
    $req = "SELECT id FROM ville WHERE nom = :ville_nom";
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(':ville_nom', $ville_nom);
    $stmt->execute();
    $id_ville = $stmt->fetchColumn();
    $stmt->closeCursor();

    // Insérer les données dans la table entreprise
    $req = "INSERT INTO entreprise (nom, id_secteur) VALUES (:nom_entreprise, :id_secteur)";
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(':nom_entreprise', $nom_entreprise);
    $stmt->bindValue(':id_secteur', $id_secteur);
    $stmt->execute();
    $id_entreprise = $pdo->lastInsertId();

    // Insérer les données dans la table situer
    $req = "INSERT INTO situer (id_entreprise, id_ville) VALUES (:id_entreprise, :id_ville)";
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(':id_entreprise', $id_entreprise);
    $stmt->bindValue(':id_ville', $id_ville);
    $stmt->execute();

    // Insérer les données dans la table evaluer
    $req = "INSERT INTO evaluer (id_entreprise, id_utilisateur, note) VALUES (:id_entreprise, 1,:note)";
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(':id_entreprise', $id_entreprise);
    $stmt->bindValue(':note', $note);
    $stmt->execute();

    // Fermer la connexion
    $pdo = null;
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

?>