<?php

function sendInvoiceRequest() {
    // API endpoint URL
    $url = "https://api.request.finance/invoices";

    // The payload as an array
    $data = [
        "buyerInfo" => [
            "email" => "daniel@jimenez.com.co"
        ],
        "invoiceItems" => [
            [
                "currency" => "USD",
                "name" => "Fund Wallet",
                "quantity" => 1,
                "unitPrice" => "2000"
            ]
        ],
        "paymentTerms" => [
            "dueDate" => "2024-12-12T23:59:59.999Z"
        ],
        "invoiceNumber" => "Test-1",
        "paymentOptions" => [
            [
                "type" => "wallet",
                "value" => [
                    "currencies" => ["USDC-base"],
                    "paymentInformation" => [
                        "paymentAddress" => "0xcf604e3cc07b1ea04846431adf260075384238f6",
                        "chain" => "base"
                    ]
                ]
            ]
        ],
        "tags" => ["funding wallet"]
    ];

    // Convert the data array to JSON
    $payload = json_encode($data);

    // Set up the headers
    $headers = [
        "Authorization: DAQA4BW-4WSM3DV-MRZ6W69-JVJS52Z",
        "Content-Type: application/json"
    ];

    // Initialize cURL
    $ch = curl_init($url);

    // Set cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    // Execute the request
    $response = curl_exec($ch);

    // Check for errors
    if (curl_errno($ch)) {
        echo 'cURL error: ' . curl_error($ch);
    } else {
        echo 'Response: ' . $response;
    }

    // Close the cURL session
    curl_close($ch);
}

// Call the function when the page loads
sendInvoiceRequest();