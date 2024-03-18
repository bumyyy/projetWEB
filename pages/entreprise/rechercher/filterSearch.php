<?php
header('Content-Type:application/json');

require_once "C:\\www\\projetWEB\\vendor\\autoload.php";
use App\UserSessionManager;
$sessionManager = new UserSessionManager();

// Récupération du corps de la requête POST et décodage du JSON
$input = file_get_contents('php://input');
$data = json_decode($input); // true pour obtenir un tableau associatif

$secteur = $data->secteur;
$ville = $data->ville;
$note = $data->rate;
$entreprises = $data->data;

// Filtrer les entreprises par secteur
if ($secteur != "x"){
$entreprises = array_filter($entreprises, function ($entreprise) use ($secteur) {
    return $entreprise->secteur_activite == $secteur;
});}

// Filtrer les entreprises par ville
if ($ville != "x"){
    $entreprises = array_filter($entreprises, function ($entreprise) use ($ville) {
        return $entreprise->ville == $ville;
    });}

// Filtrer les entreprises par note
if ($note != "x"){
    $entreprises = array_filter($entreprises, function ($entreprise) use ($note) {
        return ($entreprise->moyenne_evaluations >= $note) && ($entreprise->moyenne_evaluations < $note + 1);
    });}


$utilisateur = $sessionManager->getUserType();

$response = [
    'entreprises' => array_values($entreprises), // Réindexe et inclut les entreprises filtrées
    'userType' => $utilisateur
];

echo json_encode($response); // Encodage et envoi de la réponse



