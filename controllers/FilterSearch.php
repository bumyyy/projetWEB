<?php

class FilterSearch extends Controller{

    public function filter($secteur, $ville, $note){

        // Récupérer le contenu JSON de la requête
        $jsonData = file_get_contents('php://input');
    
        // Décoder le contenu JSON en tableau associatif
        $entreprises = json_decode($jsonData, true);
        $entreprises = $entreprises['data'];
    
        // Filtrer les entreprises par secteur
        if ($secteur != "x"){
            $entreprises = array_filter($entreprises, function ($entreprise) use ($secteur) {
                return $entreprise['id_secteur'] == $secteur;
            });
        }
            
        // Filtrer les entreprises par ville
        if ($ville != "x"){
            $entreprises = array_filter($entreprises, function ($entreprise) use ($ville) {
                return $entreprise['id_ville'] == $ville;
            });
        }
        
        // Filtrer les entreprises par note
        if ($note != "x"){
            $entreprises = array_filter($entreprises, function ($entreprise) use ($note) {
                return ($entreprise['moyenne_evaluations'] >= $note) && ($entreprise['moyenne_evaluations'] < $note + 1);
            });
        }
        
        // Démarrer la session si elle n'est pas déjà démarrée
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        // Récupérer le type d'utilisateur depuis la session
        $utilisateur = isset($_SESSION['userData']['type']) ? $_SESSION['userData']['type'] : null;
        
        // Préparer la réponse
        $response = [
            'entreprises' => array_values($entreprises), // Réindexe et inclut les entreprises filtrées
            'userType' => $utilisateur
        ];
        
        // Encodage et envoi de la réponse
        echo json_encode($response);
    }
    

    public function filterInternship($competence, $ville, $promotion, $duree, $date){

        // Récupérer le contenu JSON de la requête
        $jsonData = file_get_contents('php://input');
    
        // Décoder le contenu JSON en tableau associatif
        $stages = json_decode($jsonData, true);
        $stages = $stages['data'];

        // Filtrer les stages par compétence
        if ($competence != "x"){
            $stages = array_filter($stages, function ($stage) use ($competence) {
                // Convertit la chaîne d'ID de compétences en tableau
                $competencesStage = explode(", ", $stage['id_competence']);
                // Vérifie si la compétence recherchée est dans le tableau des compétences du stage
                return in_array($competence, $competencesStage);
            });
        }
            
        // Filtrer les stages par ville
        if ($ville != "x"){
            $stages = array_filter($stages, function ($stage) use ($ville) {
                return $stage['id_ville'] == $ville;
            });
        }
        
        // Filtrer les stages par promotion
        if ($promotion != "x"){
            $stages = array_filter($stages, function ($stage) use ($promotion) {
                return $stage['nom_promotion'] == $promotion;
            });
        }
        
        // Filtrer les stages par durée
        if ($duree != "x"){
            $stages = array_filter($stages, function ($stage) use ($duree) {
                // Exemple de mapping de durée, ajuste selon tes besoins réels
                $dureeMapping = [
                    "1" => [0, 2],
                    "2" => [2, 4],
                    "3" => [4, 6],
                    "4" => [6, 8],
                    "5" => [8, 10],
                    "6" => [10, 12],
                ];

                if (isset($dureeMapping[$duree])) {
                    $range = $dureeMapping[$duree];
                    $dureeMois = intval($stage['duree_mois_stage']); // Assure-toi que c'est un entier
                    return $dureeMois >= $range[0] && $dureeMois <= $range[1];
                }
                return false;
            });
        }


        // Filtrer les stages par date de début
        if ($date != "x"){
            $stages = array_filter($stages, function ($stage) use ($date) {
                $moisDebut = date('m', strtotime($stage['date_debut_offre'])); // Extrait le mois en format "01", "02", etc.
                return $moisDebut == $date; // Comparaison directe avec la valeur de date sélectionnée
            });
        }

        // Démarrer la session si elle n'est pas déjà démarrée
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        // Récupérer le type d'utilisateur depuis la session
        $utilisateur = isset($_SESSION['userData']['type']) ? $_SESSION['userData']['type'] : null;
        
        // Préparer la réponse
        $response = [
            'pilotes' => array_values($stages), // Réindexe et inclut les entreprises filtrées
            'userType' => $utilisateur
        ];
        
        // Encodage et envoi de la réponse
        echo json_encode($response);
    }


    public function filterPilot($promotion, $ville){

        // Récupérer le contenu JSON de la requête
        $jsonData = file_get_contents('php://input');
    
        // Décoder le contenu JSON en tableau associatif
        $pilotes = json_decode($jsonData, true);
        $pilotes = $pilotes['data'];
    
        // Filtrer les pilotes par promotion
        if ($promotion != "x"){
            $pilotes = array_filter($pilotes, function ($pilote) use ($promotion) {
                // Convertit la chaîne d'ID de compétences en tableau
                $promotionArray = explode(", ", $pilote['nom_promotion']);
                // Vérifie si la compétence recherchée est dans le tableau des compétences du stage
                return in_array($promotion, $promotionArray);
            });
        }
            
        // Filtrer les pilotes par ville
        if ($ville != "x"){
            $pilotes = array_filter($pilotes, function ($pilote) use ($ville) {
                return $pilote['id_centre'] == $ville;
            });
        }
        

        // Démarrer la session si elle n'est pas déjà démarrée
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        // Récupérer le type d'utilisateur depuis la session
        $utilisateur = isset($_SESSION['userData']['type']) ? $_SESSION['userData']['type'] : null;
        
        // Préparer la réponse
        $response = [
            'pilotes' =>    array_values($pilotes), // Réindexe et inclut les entreprises filtrées
            'userType' => $utilisateur
        ];
        
        // Encodage et envoi de la réponse
        echo json_encode($response);
    }


    public function filterApplication($etat, $favorite) {

        // Récupérer le contenu JSON de la requête
        $jsonData = file_get_contents('php://input');
        
        // Décoder le contenu JSON en tableau associatif
        $candidatures = json_decode($jsonData, true);
        $candidatures = $candidatures['data'];
        
        // Filtrer les candidatures par état
        if ($etat != "x") {
            $candidatures = array_filter($candidatures, function ($candidature) use ($etat) {
                return $candidature['etat_candidature'] == $etat;
            });
        }
    
        // Filtrer les candidatures par favoris
        if ($favorite === "true") {
            $candidatures = array_filter($candidatures, function ($candidature) {
                return $candidature['id_stage_aimé'] !== null; // Supposons que 'id_stage_aimé' contienne l'ID du favori
            });
        }
        
        // Démarrer la session si elle n'est pas déjà démarrée
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Récupérer le type d'utilisateur depuis la session
        $utilisateur = isset($_SESSION['userData']['type']) ? $_SESSION['userData']['type'] : null;
        
        // Préparer la réponse
        $response = [
            'candidatures' => array_values($candidatures), // Réindexe et inclut les candidatures filtrées
            'userType' => $utilisateur
        ];
        
        // Encodage et envoi de la réponse
        echo json_encode($response);
    }
    
    
    
}