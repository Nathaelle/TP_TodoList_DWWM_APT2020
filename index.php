<?php
// FRONT CONTROLLER -> Toutes les requêtes arrivent ici et sont traitées par le ROUTER
// ------------------------------------------------------------------------------------
// 1. INCLUSIONS CLASSES
// Dans un premier temps, nous allons inclure les fichiers de nos classes ici pour pouvoir les utiliser
require_once "models/Utilisateur.php";

// (nous verrons très prochainement comment automatiser le chargement des classes)

// ------------------------------------------------------------------------------------
// 2. ROUTER
// Structure permettant d'appeler une action en fonction de la requête utilisateur

$route = isset($_POST["route"])? $_POST["route"] : "home";

switch($route) {
    case "home" : showHome();
        break;
    case "insert_user" : insertUser();
        break;
    default : showHome();
}

// ------------------------------------------------------------------------------------
// 3. FONCTIONS DE CONTROLE
// Actions déclenchées en fonction du choix de l'utilisateur
// 1 choix = 1 fonction avec deux "types" de fonctions, celles qui mèneront à un affichage, et celles qui seront redirigées (vers un choix conduisant à un affichage)

// Fonctionnalité(s) d'affichage :
function showHome() {

}

// Fonctionnalité(s) redirigées :
function insertUser() {

}

// ------------------------------------------------------------------------------------
// 4. TEMPLATE
// Affichage du système de templates HTML