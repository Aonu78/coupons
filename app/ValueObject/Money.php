<?php

namespace App\ValueObject;

final class Money
{
    public function __construct(
        private float $amount
    ) {}

    public function getAmountString(): string
    {
        return number_format($this->amount, 2, '.', '');
    }

    public function getAmountFloat(): float
    {
        return $this->amount;
    }

    public function add(Money $money): self
    {
        $this->setAmount($this->getAmountFloat() + $money->getAmountFloat());

        return $this;
    }

    public function sub(Money $money): self
    {
        $this->setAmount($this->getAmountFloat() - $money->getAmountFloat());

        return $this;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function moreThen(Money $money): bool
    {
        return $this->getAmountFloat() > $money->getAmountFloat();
    }

    public function lessThen(Money $money): bool
    {
        return $this->getAmountFloat() < $money->getAmountFloat();
    }
}
