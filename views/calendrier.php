<?php

//Template responsable de l'affichage de mon calendrier
//Ici les données transmises par mon controller se trouvent dans $view["datas"]
$datas = $view["datas"];

//J'affiche le mois et l'année :
?>

<h1><?= $datas["mois"] ?> <?= $datas["annee"] ?></h1>