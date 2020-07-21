<?php

namespace Melfo01\DeclarationImpot\Application;

class DeclarationHandler
{
    private BankHttpClientInterface $bankHttpClient;

    public function __construct(BankHttpClientInterface $bankHttpClient)
    {
        $this->bankHttpClient = $bankHttpClient;
    }

    public function __invoke(string $month, int $year)
    {
        $transactions = $this->bankHttpClient->getTransactions(
            new \DateTime(sprintf('first day of %s %s 00:00:00', $month, $year)),
            new \DateTime(sprintf('last day of %s %s 23:59:59', $month, $year))
        );

        $montantImposableHT = $tvaRecolte = $tvaDeductible = 0;
        foreach ($transactions as $transaction) {
            $vatAmount = $transaction->getVatAmount();
            if ($transaction->getSide() == 'debit') {
                $tvaDeductible += $vatAmount;
                continue;
            }

            if ($transaction->getSide() == 'credit') {
                $montantImposableHT += $transaction->getAmount() - $vatAmount;
                if ($transaction->getVatAmount()) {
                    $tvaRecolte += $vatAmount;
                }
                continue;
            }

            throw new \Exception(
                sprintf(
                    '%s - The transaction : %s / %s - Has an side unauthorized',
                    $transaction->getEmittedAt(),
                    $transaction->getIdentifiant(),
                    $transaction->getLabel(),
                )
            );
        }

        /** @todo -  Improve this */
        dump(
            sprintf(
                'Montant imposable HT : %s - TVA Récolté : %s - TVA Déductible : %s',
                round($montantImposableHT),
                round($tvaRecolte),
                round($tvaDeductible),
            )
        );
    }
}
