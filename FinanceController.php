<?php

class FinanceController
{
    public function financePayment()
    {
        // Load the finance.php page (form)
        include 'finance.php';
    }

    // public function createPaymentRequest()
    // {
    //     // Get the request data
    //     $amount = isset($_POST['amount']) ? $_POST['amount'] : null;
    //     $email = isset($_POST['email']) ? trim($_POST['email']) : null;
    //     $description = isset($_POST['description']) ? trim($_POST['description']) : null;
    //     // $crypto_wallet = isset($_POST['crypto_wallet']) ? trim($_POST['crypto_wallet']) : null;
    //     // $wallet_type = isset($_POST['wallet_type']) ? trim($_POST['wallet_type']) : null;

    //     // Check if required fields are provided
    //     if (!$amount || !$email || !$description) {
    //         $_SESSION['error'] = 'All fields are required!';
    //         header('Location: index2.php?page=finance'); // Redirect back to the form if fields are missing
    //         exit;
    //     }

    //     // Set up the API endpoint
    //     $apiUrl = 'https://api.request.finance/invoices'; // API endpoint

    //     // Set up the data for the API request
    //     $postData = [
    //         'currency' => 'USD', // Currency
    //         'amount' => $amount, // Payment amount
    //         'payerEmail' => $email, // Payer's email
    //         'description' => $description, // Payment description
    //         'dueDate' => date('c', strtotime('+7 days')), // Payment due date
    //         'payerWallet' => '0x9c063327a626996BD7179c170807F090f9D0BE77', // Crypto wallet address
    //         'payerWalletType' => 'BASE'
    //     ];

    //     // Set the API key (ensure you set this in your server environment)
    //     $apiKey = getenv('Y4VQKJ3-6ERMPED-K6XXRQT-MFGV6MP');

    //     // Send the API request using cURL
    //     $ch = curl_init($apiUrl);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, [
    //         'Authorization: Bearer ' . $apiKey,
    //         'Content-Type: application/json',
    //     ]);
    //     curl_setopt($ch, CURLOPT_POST, true);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

    //     $response = curl_exec($ch);

    //     if ($response === false) {
    //         $_SESSION['error'] = 'Payment request failed. Please try again.';
    //         header('Location: index2.php?page=finance');
    //         exit;
    //     }

    //     $responseData = json_decode($response, true);

    //     if (isset($responseData['paymentLink'])) {
    //         // Redirect to the payment link
    //         header('Location: ' . $responseData['paymentLink']);
    //         exit;
    //     } else {
    //         $_SESSION['error'] = 'Payment request failed. Please try again.';
    //         header('Location: index2.php?page=finance');
    //         exit;
    //     }

    //     curl_close($ch);
    // }


    // public function createPaymentRequest()
    // {
    //     $amount = isset($_POST['amount']) ? $_POST['amount'] : null;
    //     $email = isset($_POST['email']) ? trim($_POST['email']) : null;
    //     $description = isset($_POST['description']) ? trim($_POST['description']) : null;

    //     if (!$amount || !$email || !$description) {
    //         $_SESSION['error'] = 'All fields are required!';
    //         header('Location: index2.php?page=finance');
    //         exit;
    //     }

    //     $apiUrl = "https://api.request.finance/invoices";
    //     $apiKey = getenv('DAQA4BW-4WSM3DV-MRZ6W69-JVJS5AZ');

    //     if (!$apiKey) {
    //         $_SESSION['error'] = 'API key not found. Please check your environment variables.';
    //         header('Location: index2.php?page=finance');
    //         exit;
    //     }

    //     $invoiceData = [
    //         "payerEmail" => $email,
    //         "amount" => $amount,
    //         "currency" => "USD",
    //         "dueDate" => date('c', strtotime('+7 days')),
    //         "description" => $description,
    //         "paymentDetails" => [
    //             "payableInFiat" => true,
    //             "receiveInCrypto" => [
    //                 "cryptoCurrency" => "USDC",
    //                 "network" => "BASE"
    //             ]
    //         ]
    //     ];

    //     $ch = curl_init();
    //     curl_setopt($ch, CURLOPT_URL, $apiUrl);
    //     curl_setopt($ch, CURLOPT_POST, true);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($invoiceData));
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, [
    //         "Content-Type: application/json",
    //         "Authorization: Bearer " . $apiKey,
    //     ]);

    //     $response = curl_exec($ch);

    //     if (curl_errno($ch)) {
    //         $_SESSION['error'] = 'cURL error: ' . curl_error($ch);
    //         curl_close($ch);
    //         header('Location: index2.php?page=finance');
    //         exit;
    //     }

    //     curl_close($ch);

    //     $responseData = json_decode($response, true);

    //     if (!$responseData) {
    //         error_log('API response could not be parsed as JSON: ' . $response);
    //         $_SESSION['error'] = 'Payment request failed. Please try again.';
    //         header('Location: index2.php?page=finance');
    //         exit;
    //     }

    //     if (isset($responseData['paymentLink'])) {
    //         header('Location: ' . $responseData['paymentLink']);
    //         exit;
    //     } else {
    //         error_log('API response: ' . print_r($responseData, true));

    //         $_SESSION['error'] = isset($responseData['error']['message']) ?
    //             'API Error: ' . $responseData['error']['message'] :
    //             'Payment request failed. Please try again.';

    //         header('Location: index2.php?page=finance');
    //         exit;
    //     }
    // }




    // public function createPaymentRequest()
    // {
    //     $amount = isset($_POST['amount']) ? $_POST['amount'] : null;
    //     $email = isset($_POST['email']) ? trim($_POST['email']) : null;
    //     $description = isset($_POST['description']) ? trim($_POST['description']) : null;
    //     $eventId = isset($_POST['event_id']) ? trim($_POST['event_id']) : null;

    //     if (!$amount || !$email || !$description || !$eventId) {
    //         $_SESSION['error'] = 'All fields are required!';
    //         header('Location: index2.php?page=finance');
    //         exit;
    //     }

    //     $apiUrl = "https://api.request.finance/invoices";
    //     $apiKey = getenv('DAQA4BW-4WSM3DV-MRZ6W69-JVJS5AZ');

    //     if (!$apiKey) {
    //         $_SESSION['error'] = 'API key not found. Please check your environment variables.';
    //         header('Location: index2.php?page=finance');
    //         exit;
    //     }

    //     $invoiceData = [
    //         "payerEmail" => $email,
    //         "amount" => $amount,
    //         "currency" => "USD",
    //         "dueDate" => date('c', strtotime('+7 days')),
    //         "description" => $description,
    //         "eventId" => $eventId, // Add the event ID here
    //         "paymentDetails" => [
    //             "payableInFiat" => true,
    //             "receiveInCrypto" => [
    //                 "cryptoCurrency" => "USDC",
    //                 "network" => "BASE"
    //             ]
    //         ]
    //     ];

    //     $ch = curl_init();
    //     curl_setopt($ch, CURLOPT_URL, $apiUrl);
    //     curl_setopt($ch, CURLOPT_POST, true);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($invoiceData));
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, [
    //         "Content-Type: application/json",
    //         "Authorization: Bearer " . $apiKey,
    //     ]);

    //     $response = curl_exec($ch);

    //     if (curl_errno($ch)) {
    //         $_SESSION['error'] = 'cURL error: ' . curl_error($ch);
    //         curl_close($ch);
    //         header('Location: index2.php?page=finance');
    //         exit;
    //     }

    //     curl_close($ch);

    //     $responseData = json_decode($response, true);

    //     if (!$responseData) {
    //         error_log('API response could not be parsed as JSON: ' . $response);
    //         $_SESSION['error'] = 'Payment request failed. Please try again.';
    //         header('Location: index2.php?page=finance');
    //         exit;
    //     }

    //     if (isset($responseData['paymentLink'])) {
    //         header('Location: ' . $responseData['paymentLink']);
    //         exit;
    //     } else {
    //         error_log('API response: ' . print_r($responseData, true));

    //         $_SESSION['error'] = isset($responseData['error']['message']) ?
    //             'API Error: ' . $responseData['error']['message'] :
    //             'Payment request failed. Please try again.';

    //         header('Location: index2.php?page=finance');
    //         exit;
    //     }
    // }



    public function createPaymentRequest()
{
    // Step 1: Input Validation
    $amount = isset($_POST['amount']) ? $_POST['amount'] : null;
    $email = isset($_POST['email']) ? trim($_POST['email']) : null;
    $description = isset($_POST['description']) ? trim($_POST['description']) : null;
    $eventId = isset($_POST['event_id']) ? trim($_POST['event_id']) : null;

    // Check for required fields
    if (!$amount || !$email || !$description || !$eventId) {
        $_SESSION['error'] = 'All fields are required!';
        header('Location: index2.php?page=finance');
        exit;
    }

    // Step 2: API Key Retrieval
    $apiUrl = "https://api.request.finance/invoices";
    $apiKey = getenv('DAQA4BW-4WSM3DV-MRZ6W69-JVJS5AZ'); // Ensure your environment variable is set correctly

    if (!$apiKey) {
        $_SESSION['error'] = 'API key not found. Please check your environment variables.';
        header('Location: index2.php?page=finance');
        exit;
    }

    // Step 3: Prepare Invoice Data
    $invoiceData = [
        "creationDate" => date('c'), // Current date in ISO 8601 format
        "invoiceItems" => [
            [
                "currency" => "USD",
                "name" => $description,
                "quantity" => 1, // Assuming 1 item for the description
                "unitPrice" => $amount,
                "tax" => [
                    "type" => "fixed", // Change to percentage if needed
                    "amount" => 0 // Assuming no tax for simplicity
                ]
            ]
        ],
        "invoiceNumber" => uniqid(), // Generate a unique invoice number
        "buyerInfo" => [
            "email" => $email,
            "firstName" => 'abu', // Optional: Add first name if available
            "lastName" => 'hammad', // Optional: Add last name if available
            "businessName" => 'hammad', // Optional: Add business name if available
        ],
        "paymentTerms" => [
            "dueDate" => date('c', strtotime('+7 days')) // Due date 7 days from now
        ],
        "paymentOptions" => [
            [
                "type" => "wallet",
                "value" => [
                    "currencies" => ["USDC-matic"], // Specify the currency you want to receive
                    "paymentInformation" => [
                        "paymentAddress" => "0x9c063327a626996BD7179c170807F090f9D0BE77", // Replace with your wallet address
                        "chain" => "matic" // Specify the blockchain
                    ]
                ]
            ]
        ],
        "tags" => ["event_$eventId"] // Tag the invoice with the event ID
    ];

    // Step 4: Send API Request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($invoiceData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer " . $apiKey,
    ]);

    $response = curl_exec($ch);

    // Handle cURL errors
    if (curl_errno($ch)) {
        $_SESSION['error'] = 'cURL error: ' . curl_error($ch);
        curl_close($ch);
        header('Location: index2.php?page=finance');
        exit;
    }

    curl_close($ch);

    // Step 5: Handle Response
    $responseData = json_decode($response, true);

    if (!$responseData) {
        error_log('API response could not be parsed as JSON: ' . $response);
        $_SESSION['error'] = 'Payment request failed. Please try again.';
        header('Location: index2.php?page=finance');
        exit ;
    }

    // Assuming the API returns a payment link
    if (isset($responseData['paymentLink'])) {
        header('Location: ' . $responseData['paymentLink']);
        exit;
    } else {
        error_log('API response: ' . print_r($responseData, true));

        $_SESSION['error'] = isset($responseData['error']['message']) ?
            'API Error: ' . $responseData['error']['message'] :
            'Payment request failed. Please try again.';

        header('Location: index2.php?page=finance');
        exit;
    }
}




    // public function handleWebhook()
    // {
    //     $webhookContent = file_get_contents("php://input");
    //     $webhookData = json_decode($webhookContent, true);

    //     if ($webhookData) {
    //         // Check for a specific event type, like "payment.success"
    //         if (isset($webhookData['event_type']) && $webhookData['event_type'] === 'payment.success') {
    //             $orderId = $webhookData['order_id']; // Example order ID from webhook data
    //             $status = $webhookData['status'];    // Example status from webhook data

    //             // Update the order status in your database
    //             $this->updateOrderStatus($orderId, $status);
    //         }
    //     }

    //     http_response_code(200); // Acknowledge receipt of the webhook
    // }

}

