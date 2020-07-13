<?php
session_start();
//var_dump($_SESSION);

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

    case "home" : $view = showHome(); //Afficher la page d'accueil avec mon formulaire 
    break;
    case "task_lst" : taskLst();
    break;
    case "membre" : $view = showMembre(); //Afficher l'espace membre pour un utilisateur connecté 
    break;
    case "calendar" : $view = showCalendar(); //Afficher le calendrier
    break;
    case "insert_user" : insertUser(); // Déclencher une action-> enregistrer un nouvel utilisateur puis de rappeler ma page d'accueil
    break;
    case "connect_user" : connectUser(); // Déclencher une action-> connecter un utilisateur puis de rediriger vers l'espace membre si OK
    break;
    case "insert_tache" : insertTache(); // Déclencher une action-> enregistrer un nouvel utilisateur puis de rappeler ma page d'accueil
    break;
    case "mod_task" : modTache(); // Déclencher une action-> enregistrer un nouvel utilisateur puis de rappeler ma page d'accueil
    break;
    case "del_task" : delTache(); // Déclencher une action-> enregistrer un nouvel utilisateur puis de rappeler ma page d'accueil
    break;
    case "deconnect" : deconnectUser();
    break;
    default : $view = showHome(); //Afficher la page d'accueil avec mon formulaire 

}

// ------------------------------------------------------------------------------------
// 3. FONCTIONS DE CONTROLE
// Actions déclenchées en fonction du choix de l'utilisateur
// 1 choix = 1 fonction avec deux "types" de fonctions, celles qui mèneront à un affichage, et celles qui seront redirigées (vers un choix conduisant à un affichage)

// Fonctionnalité(s) d'affichage :
function showHome() {
    if(isset($_SESSION["user"])) {
        header("Location:membre");
    }

    $datas = [];
    return ["template" => "home.html", "datas" => $datas];
}

function showMembre() {

    if(!isset($_SESSION["user"])) {
        header("Location:home");
    }

    $tache = new Tache();
    $tache->setIdUtilisateur($_SESSION["user"]['id']);
    
    $datas = [];

    if(isset($_GET["id"])) {
        $tache->setIdTache($_GET["id"]);
        $task = $tache->select();
        $datas["task"] = $task;
        var_dump($task->getProperties());
    }
    
    //$datas['tasks'] = $tache->selectByUser();

    return ["template" => "membre.php", "datas" => $datas];
}

function taskLst() {


    sleep(3);
    $tache = new Tache();
    $tache->setIdUtilisateur($_SESSION["user"]['id']);
    $tasks = $tache->selectByUser();
    
    echo json_encode($tasks);
    exit;
}

function showCalendar() {

    $aujd = new DateTimeImmutable("now", new DateTimeZone("europe/Paris"));
    $annee_courante = $aujd->format("Y");
    $mois_courant = $aujd->format("m");
    $month = new Month($mois_courant, $annee_courante);

    $datas = [
        "mois" => $month->getMonthName(),
        "annee" => $month->getYear()
    ];
    return ["template" => "calendrier.php", "datas" => $datas];
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

        $user->insert();
    }
    

    header("Location:index");
}

function connectUser() {

    if(!empty($_POST["pseudo"]) && !empty($_POST["passwd"])) {
        
        $user = new Utilisateur();
        $user->setPseudo($_POST["pseudo"]);
        $new = $user->selectByPseudo()?? false;

        if($new) {
            if(password_verify($_POST["passwd"], $new->getPasswd())) {
                
                $_SESSION["user"]["id"] = $new->getIdUtilisateur();
                $_SESSION["user"]["pseudo"] = $new->getPseudo();
                
                header("Location:membre");
                exit;
            }
        }
    } 
        
    header("Location:index");
    exit;
}

function deconnectUser() {
    unset($_SESSION["utilisateur"]);
    header("Location:index");
}

function insertTache() {

    $nomImage = "default.png";
    
    if(!empty($_FILES['image']['tmp_name'])) {
        $uploader = new UploadImage($_FILES['image'], 450, 450);
        $nomImage = $uploader->set_image();
    }

    $tache = new Tache();
    $tache->setIdUtilisateur($_SESSION['user']['id']);
    $tache->setDescription($_POST["description"]);
    $tache->setDeadline(new DateTime($_POST["deadline"], new DateTimeZone("europe/paris")));
    $tache->setImage($nomImage);

    $tache->insert();

    header("Location:membre");
}

function modTache() {

    $tache = new Tache();
    $tache->setIdTache($_POST["id_tache"]);
    $tache->setIdUtilisateur($_SESSION['user']['id']);
    $tache->setDescription($_POST["description"]);
    $tache->setDeadline(new DateTime($_POST["deadline"], new DateTimeZone("europe/paris")));
    
    $tache->update();
    header("Location:membre");
}

function delTache() {
    
    if(isset($_REQUEST["id"])) {

        $tache = new Tache();
        $tache->setIdTache($_REQUEST["id"]);
        $tache->select();

        if($tache->getIdUtilisateur() == $_SESSION['user']['id']) {
            $tache->delete();
            if($tache->getImage() != "default.png") {
                unlink("img/".$tache->getImage());
            }
        }
    }
    header("Location:membre");
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
    <?php require "views/{$view['template']}"; ?>

    <script src="js/ajax.js"></script>
</body>
</html>