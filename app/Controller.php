<?php

abstract class Controller{

    protected $twig;

    public function __construct() {
        // Configurez le chargeur pour spécifier le dossier de vos templates
        $loader = new \Twig\Loader\FilesystemLoader('C:\www\projetWEB\views');

        // Créez et configurez l'environnement Twig
        $this->twig = new \Twig\Environment($loader);
    }

    public function loadModel(string $model){
        require_once(ROOT.'/models/'.$model.'.php');
        $this->$model = new $model();
    }

    public function render(string $fichier, array $data = []){
        //extract($data); // On va pouvoir utiliser ces données dans la view avec comme variable le nom du tableau en entrée

        // Chargez le template et affichez-le avec les données fournies
        echo $this->twig->render( strtolower(get_class($this)) . '/' . $fichier . '.twig' );

    }
}