<?php
session_start();
var_dump($_SESSION);

require "conf/global.php";

// FRONT CONTROLLER -> Toutes les requêtes arrivent ici et sont traitées par le ROUTER
// ------------------------------------------------------------------------------------
// 1. INCLUSIONS CLASSES
// Dans un premier temps, nous allons inclure les fichiers de nos classes ici pour pouvoir les utiliser

spl_autoload_register(function ($class) {
    if(file_exists("models/$class.php")) {
        require_once "models/$class.php";
    } 
});

// (nous verrons très prochainement comment automatiser le chargement des classes)

// ------------------------------------------------------------------------------------
// 2. ROUTER
// Structure permettant d'appeler une action en fonction de la requête utilisateur

$route = isset($_REQUEST["route"])? $_REQUEST["route"] : "home";

switch($route) {

    case "home" : $include = showHome(); //Afficher la page d'accueil avec mon formulaire 
    break;
    case "membre" : $include = showMembre(); //Afficher l'espace membre pour un utilisateur connecté 
    break;
    case "insert_user" : insertUser(); // Déclencher une action-> enregistrer un nouvel utilisateur puis de rappeler ma page d'accueil
    break;
    case "connect_user" : connectUser(); // Déclencher une action-> connecter un utilisateur puis de rediriger vers l'espace membre si OK
    break;
    case "deconnect" : deconnectUser();
    break;
    default : $include = showHome(); //Afficher la page d'accueil avec mon formulaire 

}

// ------------------------------------------------------------------------------------
// 3. FONCTIONS DE CONTROLE
// Actions déclenchées en fonction du choix de l'utilisateur
// 1 choix = 1 fonction avec deux "types" de fonctions, celles qui mèneront à un affichage, et celles qui seront redirigées (vers un choix conduisant à un affichage)

// Fonctionnalité(s) d'affichage :
function showHome() {
    if(isset($_SESSION["utilisateur"])) {
        header("Location:index.php?route=membre");
    }
    return "home.html";
}

function showMembre() {
    return "membre.php";
}

// Fonctionnalité(s) redirigées :
function insertUser() {

    if(!empty($_POST["pseudo"]) && !empty($_POST["passwd"]) && !empty($_POST["nom"]) && !empty($_POST["prenom"]) && !empty($_POST["email"]) && $_POST["passwd"] === $_POST["passwd2"]) {
        
        $user = new Utilisateur();
        $user->setPseudo($_POST["pseudo"]);
        $user->setPasswd(password_hash($_POST["passwd"], PASSWORD_DEFAULT));
        $user->setNom($_POST["nom"]);
        $user->setPrenom($_POST["prenom"]);
        $user->setEmail($_POST["email"]);

        $user->saveUser();
    }
    

    header("Location:index.php");
}

function connectUser() {

    if(!empty($_POST["pseudo"]) && !empty($_POST["passwd"])) {
        
        $user = new Utilisateur();
        $user->setPseudo($_POST["pseudo"]);
        $new = $user->verifyUser()?? false;

        if($new) {
            if(password_verify($_POST["passwd"], $new->passwd)) {
                $_SESSION["utilisateur"] = $new;
            }
        }
    } 
        
    header("Location:index.php");
}

function deconnectUser() {
    unset($_SESSION["utilisateur"]);
    header("Location:index.php");
}


// ------------------------------------------------------------------------------------
// 4. TEMPLATE
// Affichage du système de templates HTML

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TodoList</title>
</head>
<body>
    
    <!-- Inclusion sous-templates -->
    <?php require "views/$include"; ?>

</body>
</html>