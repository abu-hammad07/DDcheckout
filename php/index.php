<?php

// Function to create an off-chain invoice
// function createInvoice($apiUrl, $apiKey, $invoiceData) {
//     $ch = curl_init();

//     curl_setopt($ch, CURLOPT_URL, $apiUrl . '/invoices');
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     curl_setopt($ch, CURLOPT_POST, true);
//     curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($invoiceData));
//     curl_setopt($ch, CURLOPT_HTTPHEADER, [
//         'Content-Type: application/json',
//         'Authorization: Bearer ' . trim($apiKey), // Trim to remove any spaces
//         'X-Network: live'
//     ]);

//     $response = curl_exec($ch);
//     $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//     $curlError = curl_error($ch); // Capture any cURL errors
//     curl_close($ch);

//     if ($curlError) {
//         return ['error' => $curlError];
//     }

//     return ['response' => json_decode($response, true), 'httpCode' => $httpCode];
// }

function createInvoice($apiUrl, $apiKey, $invoiceData)
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $apiUrl . '/invoices');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($invoiceData));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . trim($apiKey),
        'X-Network: live'
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($curlError) {
        return ['error' => $curlError];
    }

    return ['response' => json_decode($response, true), 'httpCode' => $httpCode];
}


// Function to convert an off-chain invoice to an on-chain request
function convertInvoiceToRequest($apiUrl, $apiKey, $invoiceId)
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $apiUrl . '/invoices/' . $invoiceId);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . trim($apiKey),
        'X-Network: live'
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($curlError) {
        return ['error' => $curlError];
    }

    return ['response' => json_decode($response, true), 'httpCode' => $httpCode];
}

// Function to fetch the status of an invoice
function fetchInvoiceStatus($apiUrl, $apiKey, $invoiceId)
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $apiUrl . '/invoices/' . $invoiceId . '?withLinks=true');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . trim($apiKey),
        'X-Network: live'
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($curlError) {
        return ['error' => $curlError];
    }

    return ['response' => json_decode($response, true), 'httpCode' => $httpCode];
}

// Configuration
$apiUrl = 'https://api.request.finance';
$apiKey = 'Y4VQKJ3-6ERMPED-K6XXRQT-MFGV6MP'; // Replace with your actual API key

// Step 1: Create an Invoice
$invoiceData = [
    "creationDate" => date('c'), // Current date in ISO 8601 format
    "invoiceItems" => [
        [
            "currency" => "USD",
            "name" => "Television",
            "quantity" => 1,
            "tax" => [
                "type" => "percentage",
                "amount" => "1"
            ],
            "unitPrice" => "1"
        ]
    ],
    "invoiceNumber" => "13",
    "buyerInfo" => [
        "businessName" => "Acme Wholesaler Ltd.",
        "address" => [
            "streetAddress" => "4933 Oakwood Avenue",
            "extendedAddress" => "",
            "city" => "New York",
            "postalCode" => "10038",
            "region" => "New York",
            "country" => "US"
        ],
        "email" => "daniel@decensat.org",
        "firstName" => "Justin",
        "lastName" => "Walton",
        "taxRegistration" => "985-80-3313"
    ],
    "paymentTerms" => [
        "dueDate" => date('c', strtotime('+30 days')) // Due date is 30 days from now
    ],
    "paymentOptions" => [
        [
            "type" => "wallet",
            "value" => [
                "currencies" => ["USDC-matic"],
                "paymentInformation" => [
                    "paymentAddress" => "0x9c063327a626996BD7179c170807F090f9D0BE77",
                    "chain" => "matic"
                ]
            ]
        ]
    ],
    "tags" => ["my_tag"]
];

$response = createInvoice($apiUrl, $apiKey, $invoiceData);

if (isset($response['error'])) {
    echo "cURL Error: " . $response['error'] . "\n";
    exit;
} elseif ($response['httpCode'] === 201) {
    $invoiceId = $response['response']['id'];
    echo "Invoice ID: $invoiceId\n";
} else {
    echo "Failed to create invoice. HTTP Code: " . $response['httpCode'] . "\n";
    echo "Response: " . json_encode($response['response']) . "\n";
    exit;
}

// Step 2: Convert Invoice to Request
$requestResponse = convertInvoiceToRequest($apiUrl, $apiKey, $invoiceId);

if (isset($requestResponse['error'])) {
    echo "cURL Error: " . $requestResponse['error'] . "\n";
    exit;
} elseif ($requestResponse['httpCode'] === 200) {
    $requestId = $requestResponse['response']['requestId'];
    echo "Request ID: $requestId\n";
} else {
    echo "Failed to convert invoice to request. HTTP Code: " . $requestResponse['httpCode'] . "\n";
    echo "Response: " . json_encode($requestResponse['response']) . "\n";
    exit;
}

// Step 3: Fetch Invoice Status
$statusResponse = fetchInvoiceStatus($apiUrl, $apiKey, $invoiceId);

if (isset($statusResponse['error'])) {
    echo "cURL Error: " . $statusResponse['error'] . "\n";
    exit;
} elseif ($statusResponse['httpCode'] === 200) {
    $status = $statusResponse['response']['status'];
    echo "Invoice Status: $status\n";
} else {
    echo "Failed to fetch invoice status. HTTP Code: " . $statusResponse['httpCode'] . "\n";
    echo "Response: " . json_encode($statusResponse['response']) . "\n";
    exit;
}
