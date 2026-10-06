<?php

class Membre {
    private int $id;
    private string $nom;
    
    private array $emprunts = [];

    public function __construct(int $id, string $nom) {
        $this->id = $id;
        $this->nom = $nom;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getNom(): string {
        return $this->nom;
    }

    public function emprunter(Livre $l): void {

        if (count($this->emprunts) >= 3) {
            throw new Exception("Le membre {$this->nom} a déjà atteint la limite de 3 emprunts.");
        }

        $l->emprunter();

        $this->emprunts[$l->getIsbn()] = $l;
    }


    public function rendre(Livre $l): void {
        $isbn = $l->getIsbn();

        if (!isset($this->emprunts[$isbn])) {
            throw new Exception("Le membre {$this->nom} n'a pas emprunté ce livre.");
        }

        $l->rendre();

        unset($this->emprunts[$isbn]);
    }

    public function getEmprunts(): array {
        return array_values($this->emprunts);
    }
}