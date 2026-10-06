<?php

// Exemple fourni dans le TP
$livre = new Livre('9782100545261', 'Algo', 'Cormen');
verifier($livre->estDisponible(), 'Un nouveau livre est disponible');
$livre->emprunter();
verifier(!$livre->estDisponible(), 'Après emprunt, le livre est indisponible');

// Test de l'exception lors de l'emprunt d'un livre indisponible
$exceptionEmprunt = false;
try {
    $livre->emprunter();
} catch (Exception $e) {
    $exceptionEmprunt = true;
}
verifier($exceptionEmprunt, 'Exception levée : impossible d\'emprunter un livre déjà emprunté');

// Test du rendu
$livre->rendre();
verifier($livre->estDisponible(), 'Après rendu, le livre est de nouveau disponible');

// Test de l'exception lors du rendu d'un livre déjà disponible
$exceptionRendre = false;
try {
    $livre->rendre();
} catch (Exception $e) {
    $exceptionRendre = true;
}
verifier($exceptionRendre, 'Exception levée : impossible de rendre un livre déjà disponible');

// Test de l'exception sur le constructeur avec un ISBN invalide
$exceptionIsbn = false;
try {
    $livreInvalide = new Livre('12345', 'Titre', 'Auteur'); // ISBN de 5 chiffres
} catch (InvalidArgumentException $e) {
    $exceptionIsbn = true;
}
verifier($exceptionIsbn, 'InvalidArgumentException levée si l\'ISBN n\'a pas 10 ou 13 chiffres');

// Test de la méthode magique __toString
verifier(is_string((string)$livre), 'La méthode __toString retourne bien une chaîne de caractères');