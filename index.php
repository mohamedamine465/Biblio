<?php
// On charge l'autoload pour inclure automatiquement les classes de A, B et C
require_once __DIR__ . '/autoload.php';

// Initialisation de la bibliothèque (Classe de B) et d'un membre (Classe de C)
$biblio = new Bibliotheque();
$membre = new Membre(1, "Étudiant C"); 

while (true) {
    echo "\n=== MENU BIBLIOTHÈQUE ===\n";
    echo "1. Ajouter un livre\n";
    echo "2. Lister les livres\n";
    echo "3. Rechercher un livre\n";
    echo "4. Emprunter un livre\n";
    echo "5. Rendre un livre\n";
    echo "0. Quitter\n";
    echo "Votre choix : ";

    $choix = trim(fgets(STDIN));

    switch ($choix) {
        case '1': // Ajouter
            echo "ISBN (10 ou 13 chiffres) : ";
            $isbn = trim(fgets(STDIN));
            echo "Titre : ";
            $titre = trim(fgets(STDIN));
            echo "Auteur : ";
            $auteur = trim(fgets(STDIN));
            
            try {
                // Utilise la classe Livre de A et la classe Bibliotheque de B
                $livre = new Livre($isbn, $titre, $auteur);
                $biblio->ajouter($livre);
                echo "[Succès] Livre ajouté à la bibliothèque.\n";
            } catch (Exception $e) {
                echo "[Erreur] " . $e->getMessage() . "\n";
            }
            break;

        case '2': // Lister
            $livres = $biblio->tous();
            if (empty($livres)) {
                echo "La bibliothèque est vide.\n";
            } else {
                echo "\n--- Liste des livres ---\n";
                foreach ($livres as $l) {
                    echo "- " . $l . "\n"; // Fait appel à la méthode __toString() de Livre
                }
                echo "Total : " . $biblio->compter() . " livre(s).\n";
            }
            break;

        case '3': // Rechercher
            echo "Mot-clé (titre ou auteur) : ";
            $mot = trim(fgets(STDIN));
            $resultats = $biblio->rechercher($mot);
            
            if (empty($resultats)) {
                echo "Aucun livre trouvé pour '$mot'.\n";
            } else {
                echo "\n--- Résultats de recherche ---\n";
                foreach ($resultats as $l) {
                    echo "- " . $l . "\n";
                }
            }
            break;

        case '4': // Emprunter
            echo "ISBN du livre à emprunter : ";
            $isbn = trim(fgets(STDIN));
            $livre = $biblio->trouver($isbn);
            
            if ($livre) {
                try {
                    // Utilise la méthode emprunter() de la classe Membre de C
                    $membre->emprunter($livre);
                    echo "[Succès] Vous avez emprunté '{$livre->getTitre()}'.\n";
                } catch (Exception $e) {
                    echo "[Erreur] " . $e->getMessage() . "\n";
                }
            } else {
                echo "[Erreur] Livre introuvable dans la bibliothèque.\n";
            }
            break;

        case '5': // Rendre
            echo "ISBN du livre à rendre : ";
            $isbn = trim(fgets(STDIN));
            $livre = $biblio->trouver($isbn);
            
            if ($livre) {
                try {
                    // Utilise la méthode rendre() de la classe Membre de C
                    $membre->rendre($livre);
                    echo "[Succès] Vous avez rendu '{$livre->getTitre()}'.\n";
                } catch (Exception $e) {
                    echo "[Erreur] " . $e->getMessage() . "\n";
                }
            } else {
                echo "[Erreur] Livre introuvable.\n";
            }
            break;

        case '0': // Quitter
            echo "Fermeture du programme.\n";
            exit(0);

        default:
            echo "[Erreur] Choix invalide.\n";
            break;
    }
}