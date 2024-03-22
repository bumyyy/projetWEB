<?php

abstract class Controller{

    protected $twig;

    // public function session_destroy() {
    //     session_destroy();
    // }

    public function __construct() {
        // Configurez le chargeur pour spécifier le dossier de vos templates
        $loader = new \Twig\Loader\FilesystemLoader('C:\www\projetWEB\views');

        // Créez et configurez l'environnement Twig
        $this->twig = new \Twig\Environment($loader);

        session_start();
    }

    public function loadModel(string $model){
        require_once(ROOT.'/models/'.$model.'.php');
        $this->$model = new $model();
    }

    public function render(string $fichier, array $data = []){

        if (isset($_SESSION['userData'])) {        
            $userInfos = [
                'userId' => $_SESSION['userData']['id'],
                'userType' => $_SESSION['userData']['type'],
                'userName' => $_SESSION['userData']['lastName'],
                'userFirstName' => $_SESSION['userData']['firstName']
                ];
        } else { $userInfos = ['userId' => null, 'userType' => null, 'userName' => null, 'userFirstName' => null]; }
    

        // Chargez le template et affichez-le avec les données fournies
        echo $this->twig->render( strtolower(get_class($this)) . '/' . $fichier . '.twig' , array_merge($data, $userInfos));

    }
}