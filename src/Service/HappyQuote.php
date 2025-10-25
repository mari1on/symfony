<?php
namespace App\Service;

class HappyQuote
{
    private array $quotes = [
        "La vie est belle, profite de chaque instant.",
        "Chaque jour est une nouvelle opportunité.",
        "Le succès commence par un petit pas.",
        "Souris à la vie et elle te sourira.",
        "Fais ce que tu aimes et aime ce que tu fais."
    ];

    public function getHappyMessage(): string
    {
        return $this->quotes[array_rand($this->quotes)];
    }
}
