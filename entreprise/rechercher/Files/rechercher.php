<?php
$secteur = $_POST['act_sec'];
$ville = $_POST['localité'];
$note = $_POST['rate'];
$recherche = $_POST['rechercher'];

$entreprises = json_decode(file_get_contents("http://localhost/projetWEB/api/index.php?demande=entreprise"));

// Filtrer les entreprises par nom
if ($recherche != ""){
    $entreprises = json_decode(file_get_contents("http://localhost/projetWEB/api/index.php?demande=entreprise/recherche/{$recherche}"));
    }

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

?>