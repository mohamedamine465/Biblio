"<?php

class Livre {
    private string $isbn;
    private string $titre;
    private string $auteur;
    private bool $disponible;

    /**
     * @throws InvalidArgumentException si l'ISBN n'a pas 10 ou 13 chiffres.
     */
    public function __construct(string $isbn, string $titre, string $auteur) {
        // L'expression régulière vérifie qu'il y a exactement 10 ou 13 chiffres
        if (!preg_match('/^(\d{10}|\d{13})$/', $isbn)) {
            throw new InvalidArgumentException("L'ISBN doit contenir exactement 10 ou 13 chiffres.");
        }
        
        $this->isbn = $isbn;
        $this->titre = $titre;
        $this->auteur = $auteur;
        $this->disponible = true; // Un livre est disponible par défaut lors de sa création
    }

    public function getIsbn(): string {
        return $this->isbn;
    }

    public function getTitre(): string {
        return $this->titre;
    }

    public function getAuteur(): string {
        return $this->auteur;
    }

    public function estDisponible(): bool {
        return $this->disponible;
    }

    /**
     * @throws Exception si le livre est déjà emprunté.
     */
    public function emprunter(): void {
        if (!$this->disponible) {
            throw new Exception("Ce livre ({$this->titre}) est déjà emprunté.");
        }
        $this->disponible = false;
    }

    /**
     * @throws Exception si le livre est déjà disponible.
     */
    public function rendre(): void {
        if ($this->disponible) {
            throw new Exception("Ce livre ({$this->titre}) est déjà disponible, il ne peut pas être rendu.");
        }
        $this->disponible = true;
    }

    public function __toString(): string {
        $statut = $this->disponible ? "Disponible" : "Emprunté";
        return "{$this->titre} par {$this->auteur} (ISBN: {$this->isbn}) - [$statut]";
    }
}