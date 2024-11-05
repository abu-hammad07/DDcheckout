<?php

$apiUrl = "https://api.request.finance/invoices";
$apiKey = "Y4VQKJ3-6ERMPED-K6XXRQT-MFGV6MP";

// Define the FIAT to USDC conversion details
$invoiceData = [
    "payerEmail" => "daniel@decensat.org",
    "amount" => 1500, // FIAT Amount
    "currency" => "USD", // FIAT Currency
    "dueDate" => "2024-11-01T00:00:00Z",
    "description" => "Service Invoice",
    "paymentDetails" => [
        "payableInFiat" => true, // Allow FIAT payments
        "receiveInCrypto" => [
            "cryptoCurrency" => "USDC",
            "network" => "BASE"
        ]
    ]
];

// Initialize cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($invoiceData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer $apiKey",
]);

$response = curl_exec($ch);
curl_close($ch);

// Handle the response
$invoice = json_decode($response, true);
if (isset($invoice['id'])) {
    echo "Self-invoice created successfully. ID: " . $invoice['id'];
} else {
    echo "Error creating self-invoice: " . $response;
}
