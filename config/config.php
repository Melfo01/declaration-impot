<?php
/**
 * This is all parameters for your BankHttpClientInterface
 * This exemple is for QontoBankHttpClient that require 4 parameters
 */
$bankConstructorParameters = [
    'your-login',
    'your-secret-key',
    'your-slug',
    'your-iban',
];

/**
 * This soft require a month and a year to return your declaration information
 * Variables must be null or an instance DateTimeInterface
 */
$startDate = new \DateTime(sprintf('first day of %s %s 00:00:00', 'January', 2020));
$endDate = null;
