<?php

$biblio = new Bibliotheque();
$livre1 = new Livre('1234567890', 'Le Petit Prince', 'Saint-Exupéry');
$livre2 = new Livre('0987654321', '1984', 'George Orwell');

verifier($biblio->compter() === 0, 'Bibliotheque : est vide au départ');
$biblio->ajouter($livre1);
verifier($biblio->compter() === 1, 'Bibliotheque : contient 1 livre après ajout');

verifier($biblio->trouver('1234567890') === $livre1, 'Bibliotheque : trouver un livre existant');
verifier($biblio->trouver('1111111111') === null, 'Bibliotheque : trouver un livre inexistant renvoie null');

$biblio->ajouter($livre2);
verifier(count($biblio->tous()) === 2, 'Bibliotheque : la méthode tous() retourne bien tous les livres');


$exceptionLevee = false;
try {
    $biblio->ajouter($livre1);
} catch (Exception $e) {
    $exceptionLevee = true;
}
verifier($exceptionLevee, 'Bibliotheque : exception levée si l\'ISBN existe déjà');

$resultatsTitre = $biblio->rechercher('prince');
verifier(count($resultatsTitre) === 1 && $resultatsTitre[0]->getIsbn() === '1234567890', 'Bibliotheque : recherche par titre insensible à la casse');

$resultatsAuteur = $biblio->rechercher('ORWELL');
verifier(count($resultatsAuteur) === 1, 'Bibliotheque : recherche par auteur insensible à la casse');