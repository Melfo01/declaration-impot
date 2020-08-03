<?php

namespace Melfo01\DeclarationImpot\Application;

class DeclarationHandler
{
    private BankHttpClientInterface $bankHttpClient;

    public function __construct(BankHttpClientInterface $bankHttpClient)
    {
        $this->bankHttpClient = $bankHttpClient;
    }

    public function __invoke(?\DateTimeInterface $startDate, ?\DateTimeInterface $endDate)
    {
        $transactions = $this->bankHttpClient->getTransactions($startDate, $endDate);

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
