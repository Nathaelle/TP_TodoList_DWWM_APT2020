<?php

$aujd = new DateTimeImmutable("now", new DateTimeZone("europe/Paris"));

$annee_courante = $aujd->format("Y");
$mois_courant = $aujd->format("m");
$jour_courant = $aujd->format("d");

echo "Nous sommes le $jour_courant/$mois_courant/$annee_courante";

//$date = $aujd->modify("first day of next year");
//var_dump($date);


require "models/Month.php";

$month = new Month($mois_courant, $annee_courante);
var_dump($month);

echo "Nous sommes en {$month->getMonthName()} {$month->getYear()}";





