<?php

abstract class Controller{

    public function loadModel(string $model){
        require_once(ROOT.'/models/'.$model.'.php');
        $this->$model = new $model();
    }

    public function render(string $fichier, array $data = []){
        extract($data); // On va pouvoir utiliser ces données dans la view avec comme variable le nom du tableau en entrée

        //On demarre le buffer
        ob_start(); //Il va recuperer en memoire tous les 'echo'

        require_once(ROOT.'/views/'.strtolower(get_class($this)).'/'.$fichier.'.php');
        
        $content = ob_get_clean();

        if(get_class($this) == 'Login'){
            require_once(ROOT.'/views/layout/noLayout.php');
        }else{
            require_once(ROOT.'/views/layout/default.php');
        }

    }
}