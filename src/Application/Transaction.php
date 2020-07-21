<?php

namespace Melfo01\DeclarationImpot\Application;


class Transaction
{
    private string $identifiant;
    private string $label;
    private float $amount;
    /** @todo - Switch this variable to an Enum ? */
    private string $side;
    private \DateTimeImmutable $emittedAt;
    private ?float $vatAmount;

    public function __construct(
        string $identifiant,
        string $label,
        float $amount,
        string $side,
        \DateTimeImmutable $emittedAt,
        float $vatAmount = 0.0
    )
    {
        $this->identifiant = $identifiant;
        $this->label = $label;
        $this->amount = $amount;
        $this->side = $side;
        $this->emittedAt = $emittedAt;
        $this->vatAmount = $vatAmount;
    }

    public function getIdentifiant(): string
    {
        return $this->identifiant;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getSide(): string
    {
        return $this->side;
    }

    public function getEmittedAt(): \DateTimeImmutable
    {
        return $this->emittedAt;
    }

    public function getVatAmount(): ?float
    {
        return $this->vatAmount;
    }
}
