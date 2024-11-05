<?php
// create_invoice.php

// Include configuration file
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $buyerEmail = trim($_POST['buyer_email']);
    $currency = trim($_POST['currency']);
    $itemName = trim($_POST['item_name']);
    $quantity = intval($_POST['quantity']);
    $unitPrice = floatval($_POST['unit_price']);
    $dueDate = trim($_POST['due_date']);
    $invoiceNumber = trim($_POST['invoice_number']);
    $paymentAddress = trim($_POST['payment_address']);
    $chain = trim($_POST['chain']);
    $tagsInput = trim($_POST['tags']);
    $tags = $tagsInput ? explode(',', $tagsInput) : [];

    // Initialize an array to hold errors
    $errors = [];

    // Validate Buyer Email
    if (!filter_var($buyerEmail, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid buyer email format.";
    }

    // Validate Currency
    $allowedCurrencies = ['USD', 'EUR', 'GBP']; // Extend as needed
    if (!in_array($currency, $allowedCurrencies)) {
        $errors[] = "Unsupported currency selected.";
    }

    // Validate Quantity
    if ($quantity < 1) {
        $errors[] = "Quantity must be at least 1.";
    }

    // Validate Unit Price
    if ($unitPrice <= 0) {
        $errors[] = "Unit price must be greater than 0.";
    }

    // Validate Due Date
    if (!DateTime::createFromFormat('Y-m-d', $dueDate)) {
        $errors[] = "Invalid due date format.";
    }

    // Validate Invoice Number
    if (empty($invoiceNumber)) {
        $errors[] = "Invoice number cannot be empty.";
    }

    // If there are errors, display them and stop execution
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
        exit;
    }

    // Convert due date to ISO 8601 format with time
    $dueDateISO = date('c', strtotime($dueDate . ' 23:59:59'));

    // Prepare the JSON payload
    $data = [
        "id" => "63f2f5a7f00a45f276585b27", // Replace with dynamic ID if needed
        "buyerInfo" => [
            "email" => $buyerEmail
        ],
        "invoiceItems" => [
            [
                "currency" => $currency,
                "name" => $itemName,
                "quantity" => $quantity,
                "unitPrice" => (string)$unitPrice
            ]
        ],
        "paymentTerms" => [
            "dueDate" => $dueDateISO
        ],
        "invoiceNumber" => $invoiceNumber,
        "paymentOptions" => [
            [
                "type" => "wallet",
                "value" => [
                    "currencies" => [
                        "USDC-base"
                    ],
                    "paymentInformation" => [
                        "paymentAddress" => $paymentAddress,
                        "chain" => $chain
                    ]
                ]
            ]
        ],
        "tags" => $tags
    ];

    $jsonData = json_encode($data, JSON_PRETTY_PRINT);

    // Initialize cURL
    $curl = curl_init();

    // Set cURL options
    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://api.request.finance/invoices',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $jsonData,
        CURLOPT_HTTPHEADER => [
            'Authorization: Bearer ' . API_TOKEN,
            'Content-Type: application/json',
            'X-Network: base' // Add your required network here, like "base", "Ethereum", etc.
        ],
    ]);

    // Execute cURL request
    $response = curl_exec($curl);

    // Check for cURL errors
    if ($response === false) {
        $error = curl_error($curl);
        echo "<p style='color:red;'>cURL Error: $error</p>";
        curl_close($curl);
        exit;
    }

    // Get HTTP status code
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    // Close cURL
    curl_close($curl);

    // Parse the JSON response
    $responseData = json_decode($response, true);

    // Check if the response was successful
    if ($httpCode >= 200 && $httpCode < 300) {
        echo "<p style='color:green;'>Invoice created successfully!</p>";
        echo "<pre>" . htmlspecialchars(print_r($responseData, true)) . "</pre>";
    } else {
        // Handle API errors
        $errorMessage = isset($responseData['message']) ? $responseData['message'] : 'An error occurred.';
        echo "<p style='color:red;'>Error: $errorMessage</p>";
        echo "<pre>" . htmlspecialchars(print_r($responseData, true)) . "</pre>";
    }
}
