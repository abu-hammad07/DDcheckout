<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form input values
    $buyer_email = $_POST['buyer_email'];
    $currency = $_POST['currency'];
    $item_name = $_POST['item_name'];
    $quantity = (int)$_POST['quantity'];
    $unit_price = $_POST['unit_price'];
    $due_date = $_POST['due_date'] . "T23:59:59.999Z"; // Adding time to the due date
    $invoice_number = $_POST['invoice_number'];
    $payment_address = $_POST['payment_address'];
    $chain = $_POST['chain'];
    $tags = isset($_POST['tags']) ? explode(',', $_POST['tags']) : [];

    // Prepare the data array to be converted to JSON for the API request
    $data = [
        "id" => "63f2f5a7f00a45f276585b27", // Fixed ID for example
        "buyerInfo" => [
            "email" => $buyer_email
        ],
        "invoiceItems" => [
            [
                "currency" => $currency,
                "name" => $item_name,
                "quantity" => $quantity,
                "unitPrice" => $unit_price
            ]
        ],
        "paymentTerms" => [
            "dueDate" => $due_date
        ],
        "invoiceNumber" => $invoice_number,
        "paymentOptions" => [
            [
                "type" => "wallet",
                "value" => [
                    "currencies" => [$currency . "-base"],
                    "paymentInformation" => [
                        "paymentAddress" => $payment_address,
                        "chain" => $chain
                    ]
                ]
            ]
        ],
        "tags" => $tags
    ];

    // Initialize cURL
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.request.finance/invoices',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer YOUR_API_TOKEN', // Replace with your API token
            'Content-Type: application/json'
        ),
    ));

    // Execute the cURL request and capture the response
    $response = curl_exec($curl);

    // Check for errors
    if (curl_errno($curl)) {
        echo 'Error:' . curl_error($curl);
    } else {
        // Handle the response
        echo "Response from API: " . $response;
    }

    // Close cURL
    curl_close($curl);
}
