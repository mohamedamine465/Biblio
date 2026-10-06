<?php

class Bibliotheque {
    private array $livres = [];

    public function ajouter(Livre $l): void {
        $isbn = $l->getIsbn();
        
        if ($this->trouver($isbn) !== null) {
            throw new Exception("Le livre avec l'ISBN $isbn existe déjà dans la bibliothèque.");
        }

        $this->livres[$isbn] = $l;
    }


    public function trouver(string $isbn): ?Livre {
        return $this->livres[$isbn] ?? null;
    }

    public function tous(): array {
        return array_values($this->livres);
    }

    public function compter(): int {
        return count($this->livres);
    }

    public function rechercher(string $mot): array {
        $resultats = [];
        $motRecherche = strtolower($mot); 

        foreach ($this->livres as $livre) {
            $titre = strtolower($livre->getTitre());
            $auteur = strtolower($livre->getAuteur());


            if (str_contains($titre, $motRecherche) || str_contains($auteur, $motRecherche)) {
                $resultats[] = $livre;
            }
        }

        return $resultats;
    }
}