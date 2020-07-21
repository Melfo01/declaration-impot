<?php

namespace Melfo01\DeclarationImpot\Infrastructure;

use DateTimeInterface;
use Melfo01\DeclarationImpot\Application\BankHttpClientInterface;
use Melfo01\DeclarationImpot\Application\Transaction;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class QontoBankHttpClient implements BankHttpClientInterface
{
    private HttpClientInterface $client;
    private string $slug;
    private string $iban;

    public function __construct(string $login, string $secretKey, string $slug, string $iban)
    {
        $this->client = HttpClient::create([
            'headers' => [
                'authorization' => "$login:$secretKey",
            ],
        ]);
        $this->slug = $slug;
        $this->iban = $iban;
    }

    /** @todo - We need to manage paginatation */
    public function getTransactions(DateTimeInterface $startDate, DateTimeInterface $endDate): array
    {
        $jsonResponse = $this->client->request(
            'GET',
            sprintf(
                "%s?slug=%s&iban=%s&settled_at_from=%s&settled_at_to=%s",
                'http://thirdparty.qonto.eu/v2/transactions',
                $this->slug,
                $this->iban,
                urlencode($startDate->format(DATE_ISO8601)),
                urlencode($endDate->format(DATE_ISO8601))
            )
        )->getContent();

        $response = json_decode($jsonResponse, true);

        if ($response['meta']['total_count'] == 0) {
            return [];
        }

        $transactions = [];
        foreach ($response['transactions'] as $transaction) {
            $transactions[] = new Transaction(
                $transaction['transaction_id'],
                $transaction['label'],
                $transaction['amount'],
                $transaction['side'],
                new \DateTimeImmutable($transaction['emitted_at']),
                $transaction['vat_amount'] ?? 0.0
            );
        }

        return $transactions;
    }
}
