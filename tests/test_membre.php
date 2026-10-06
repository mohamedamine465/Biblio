<?php

$membre = new Membre(1, 'Alice');
$livreA = new Livre('1111111111', 'Titre A', 'Auteur A');
$livreB = new Livre('2222222222', 'Titre B', 'Auteur B');
$livreC = new Livre('3333333333', 'Titre C', 'Auteur C');
$livreD = new Livre('4444444444', 'Titre D', 'Auteur D');

verifier($membre->getId() === 1, 'Membre : l\'ID est correct');
verifier($membre->getNom() === 'Alice', 'Membre : le nom est correct');
verifier(count($membre->getEmprunts()) === 0, 'Membre : 0 emprunt initialement');

$membre->emprunter($livreA);
verifier(count($membre->getEmprunts()) === 1, 'Membre : le membre a emprunté 1 livre');
verifier(!$livreA->estDisponible(), 'Membre : le livre emprunté n\'est plus disponible (appel de l->emprunter())');

$membre->emprunter($livreB);
$membre->emprunter($livreC);
$exceptionLimite = false;
try {
    $membre->emprunter($livreD);
} catch (Exception $e) {
    $exceptionLimite = true;
}
verifier($exceptionLimite, 'Membre : exception levée au-delà de 3 emprunts');

$membre->rendre($livreA);
verifier(count($membre->getEmprunts()) === 2, 'Membre : le membre a rendu 1 livre, il lui en reste 2');
verifier($livreA->estDisponible(), 'Membre : le livre rendu est redevenu disponible (appel de l->rendre())');