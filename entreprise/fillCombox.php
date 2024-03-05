<?php 

$getSecteur = json_decode(file_get_contents("http://"));

foreach ($getSecteur as $secteur) {
    echo "<option value='{$secteur->nom}'></option>";
}


?>