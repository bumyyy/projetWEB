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
                return $entreprise['secteur_activite'] == $secteur;
            });
        }
            
        // Filtrer les entreprises par ville
        if ($ville != "x"){
            $entreprises = array_filter($entreprises, function ($entreprise) use ($ville) {
                return $entreprise['ville'] == $ville;
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
    
    
}