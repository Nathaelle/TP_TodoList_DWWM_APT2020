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

// ........

// ------------------------------------------------------------------------------------
// 3. FONCTIONS DE CONTROLE
// Actions déclenchées en fonction du choix de l'utilisateur
// 1 choix = 1 fonction

// ........

// ------------------------------------------------------------------------------------
// 4. TEMPLATE
// Affichage du système de templates HTML