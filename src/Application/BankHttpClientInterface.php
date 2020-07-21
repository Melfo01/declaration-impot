<?php


namespace Melfo01\DeclarationImpot\Application;

use \DateTimeInterface;

interface BankHttpClientInterface
{
    /** @return Transaction[] */
    public function getTransactions(DateTimeInterface $startDate, DateTimeInterface $endDate): array;
}
