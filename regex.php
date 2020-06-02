<?php

$str = "Bonjour et au revoir ! Je m'appelle John Doe, j'ai 27 ans, j'habite en France et travaille depuis que j'ai 20 ans. Ma passion : écrire des mots, mits, mets, mats, mat... Pour me contacter, vous pouvez envoyer un email à contact@johndoe.fr ou contact@johndoe.com ou bien m'appeler au 06 07 08 09 10. Vous pouvez aussi aller voir mon blog à l'adresse johndoe-blog.fr. Bonjour et au revoir";

//var_dump(preg_match_all("#m[a-z]ts#", $str, $test, PREG_UNMATCHED_AS_NULL));
//var_dump($test);

/*$numero0 = "+33685974582";
$numero1 = "+336-85-97-45-82";
$numero2 = "+336-85-97--45-82";
$numero3 = "+336-8597-45-82";
$numero4 = "+3368597 45 82";
$numero5 = "+33 685974582";
$numero6 = "33685974582";
$numero7 = "3368597458";
$numero8 = "336859745825";
$numero9 = "3368597z4582";

if (preg_match('#(0|\+33)[1-9](( *|-?)[0-9]{2}){4}#', $numero3)) {
    echo "Le numéro de téléphone entré est correct.";
    // On peut ajouter le numéro à la base de donnée
} else {
    echo "Le numéro de téléphone entré est incorrect.";
    // On ne peut pas ajouter le numéro à la base de donnée
}*/

$noms = [
    "Dupont",
    "Dupont123",
    "Dupont#",
    "L'hôtelier",
    "Bernard-Martin",
    "De machin",
    "Lebœuf",
    "azertyuiopazertyuiopazertyuiopazertyuiopazertyuiopazertyuiopazertyuiopazertyuiopazertyuiop"
];


foreach($passwd as $pw) {
    if (preg_match("#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W)#", $pw)) {
        echo "Le mot de passe $pw est correct.<br>";
        // On peut ajouter le nom à la base de donnée
    } else {
        echo "Le mot de passe $pw est incorrect.<br>";
        // On ne peut pas ajouter le nom à la base de donnée
    }
}

foreach($noms as $nom) {
    if (preg_match("#^[a-zA-Z-àâäéèêëïîôöùûüçàâäéèêëïîôöùûüçÀÂÄÉÈËÏÔÖÙÛÜŸÇæœÆŒ'( )]{1,70}$#", $nom)) {
        echo "Le nom $nom est correct.<br>";
        // On peut ajouter le nom à la base de donnée
    } else {
        echo "Le nom $nom est incorrect.<br>";
        // On ne peut pas ajouter le nom à la base de donnée
    }
}
