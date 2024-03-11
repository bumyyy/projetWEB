<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stage_tier</title>
    <link rel="stylesheet" href="Entreprises_creer.css">
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
    
</div>
<!-- 
<div class="sub">
    <input type="text" placeholder="Rechercher entreprises">
    <div class="combox">
    <select name="secteur d'activité" id="act_sec">
        <option value="informatique">informatique</option>
        <option value="informatique">BTP</option>
        <option value="informatique">economie</option>
        <option value="informatique">commerce</option>
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
    <div class="create">
        <button>+</button>
    </div>
</div>-->

<div class="main">
 <form class="create_entrep" id="myform" method="POST" > <!-- action="Entreprises_accueil.php" -->
    <h1>Créer une entreprise</h1>
    <div class="company">
        <h2>Nom de l'entreprise</h2>
        <input type="text" name="nom" id="form_input" required>
    </div>

    <h2>Secteur d'activité</h2>
<div class="activite">
    <div id="secteur-container">
        <select name="secteur[]" class="secteur-select" id="secteur-select" required>
            <?php
            // Appeler votre API pour récupérer les secteurs d'activité
            $data = json_decode(file_get_contents("http://localhost/projetWEB/api/index.php?demande=combox/secteur"));

            // Parcourir les données récupérées et créer les options pour le menu déroulant
            foreach ($data as $secteur) {
                echo "<option value='{$secteur->nom}'>$secteur->nom</option>";
            }
            ?>
        </select>
    </div>
    <input type="button" value="+" id="secteur">
</div>

<h2>Localité</h2>
<div class="localite">
    <div id="localite-container">
        <select name="localite[]" class="localite-select" id="localite-select" required>
            <?php
            // Appeler votre API pour récupérer les secteurs d'activité
            $data = json_decode(file_get_contents("http://localhost/projetWEB/api/index.php?demande=combox/ville"));

            // Générer les options pour le select
            foreach ($data as $ville) {
                echo "<option value='{$ville->nom}'>$ville->nom</option>";
            }
            ?>
        </select>
    </div>
    <input type="button" value="+" id="ville">
</div>


<div class="note">
    <h2>Note</h2>
    <div class="rating" data-rating="3">
    <input type="hidden" id="rating-value" name="rating-value" value="0">
  <span class="star" data-value="1">&#9733;</span>
  <span class="star" data-value="2">&#9733;</span>
  <span class="star" data-value="3">&#9733;</span>
  <span class="star" data-value="4">&#9733;</span>
  <span class="star" data-value="5">&#9733;</span>
    </div>
    </div>
    <div class="submit">
        <button type="submit" id="submit_btn">Soumettre</button>
    </div>
 </form>
</div>


<footer class="footer">
    <img src="img/youtube.png" alt="YouTube">
    <img src="img/linkedin.png" alt="LinkedIn">
    <img src="img/facebook.png" alt="Facebook">
    <img src="img/twitter.png" alt="Twitter">
    <img src="img/instagram.png" alt="Instagram">
    <p>© 2024 Stage_Tier - Tous droits réservés</p>
</footer>
<script src="Entreprises_creer.js"></script>
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

    echo "Les données ont été insérées avec succès.";

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




?>