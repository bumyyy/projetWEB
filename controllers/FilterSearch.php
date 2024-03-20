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
                return $stage['id_competence'] == $competence;
            });
        }

        // Filtrer les stages par promotion
        if ($promotion != "x"){
            $stages = array_filter($stages, function ($stage) use ($promotion) {
                return $stage['id_promotion'] == $promotion;
            });
        }
            
        // Filtrer les stages par ville
        if ($ville != "x"){
            $stages = array_filter($stages, function ($stage) use ($ville) {
                return $stage['id_ville'] == $ville;
            });
        }
        
        // Filtrer les stages par durée
        if ($duree != "x"){
            $stages = array_filter($stages, function ($stage) use ($duree) {
                return $stage['duree_mois_stage'] == $duree;
            });
        }

        // Filtrer les stages par date
        if ($date != "x"){
            $stages = array_filter($stages, function ($stage) use ($date) {
                return $stage['date_debut_offre'] == $date;
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
                return $pilote['id_promotion'] == $promotion;
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
            'pilotes' => array_values($pilotes), // Réindexe et inclut les entreprises filtrées
            'userType' => $utilisateur
        ];
        
        // Encodage et envoi de la réponse
        echo json_encode($response);
    }
    
    
}