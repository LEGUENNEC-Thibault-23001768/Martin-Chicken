<?php

final class Controleur
{
    private $_A_urlDecortique;

    public function __construct ($S_controleur, $S_action)
    {

        if (empty($S_controleur)) {
            // Nous avons pris le parti de préfixer tous les controleurs par "Controleur"
            $this->_A_urlDecortique['controleur'] = '';
        } else {
            $this->_A_urlDecortique['controleur'] = ucfirst($S_controleur) . 'Controller';
        }

        if (empty($S_action)) {
            // L'action est vide ! On la valorise par défaut
            $this->_A_urlDecortique['action'] = 'defautAction';
        } else {
            // On part du principe que toutes nos actions sont suffixées par 'Action'...à nous de le rajouter
            $this->_A_urlDecortique['action']  = $S_action . 'Action';
        }

    }
    
    protected function render($view, $data = []) {
        extract($data);
        require_once 'Vues/' . $view . '.php';
    }


    // On exécute
    public function executer()
    {

        //fonction de rappel de notre controleur cible (ControleurHelloworld pour notre premier exemple)
        call_user_func_array(array(new $this->_A_urlDecortique['controleur'],
            $this->_A_urlDecortique['action']), array());

    }
}