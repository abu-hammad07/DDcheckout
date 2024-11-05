<?php

class FinanceController
{
    public function financePayment()
    {
        // Load the finance.php page (form)
        include 'finance.php';
    }

    public function createPaymentRequest()
    {
        // Get the request data
        $amount = isset($_POST['amount']) ? $_POST['amount'] : null;
        $email = isset($_POST['email']) ? trim($_POST['email']) : null;
        $description = isset($_POST['description']) ? trim($_POST['description']) : null;
        // $crypto_wallet = isset($_POST['crypto_wallet']) ? trim($_POST['crypto_wallet']) : null;
        $wallet_type = isset($_POST['wallet_type']) ? trim($_POST['wallet_type']) : null;

        // Check if required fields are provided
        if (!$amount || !$email || !$description || !$wallet_type) {
            $_SESSION['error'] = 'All fields are required!';
            header('Location: index2.php?page=finance'); // Redirect back to the form if fields are missing
            exit;
        }

        // Set up the API endpoint
        $apiUrl = 'https://api.request.finance/invoices'; // API endpoint

        // Set up the data for the API request
        $postData = [
            'currency' => 'USD', // Currency
            'amount' => $amount, // Payment amount
            'payerEmail' => $email, // Payer's email
            'description' => $description, // Payment description
            'dueDate' => date('c', strtotime('+7 days')), // Payment due date
            'payerWallet' => '0x9c063327a626996BD7179c170807F090f9D0BE77', // Crypto wallet address
            'payerWalletType' => $wallet_type // Wallet type (e.g., 'ethereum')
        ];

        // Set the API key (ensure you set this in your server environment)
        $apiKey = getenv('Y4VQKJ3-6ERMPED-K6XXRQT-MFGV6MP');

        // Send the API request using cURL
        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $apiKey,
            'Content-Type: application/json',
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

        $response = curl_exec($ch);

        if ($response === false) {
            $_SESSION['error'] = 'Payment request failed. Please try again.';
            header('Location: index2.php?page=finance');
            exit;
        }

        $responseData = json_decode($response, true);

        if (isset($responseData['paymentLink'])) {
            // Redirect to the payment link
            header('Location: ' . $responseData['paymentLink']);
            exit;
        } else {
            $_SESSION['error'] = 'Payment request failed. Please try again.';
            header('Location: index2.php?page=finance');
            exit;
        }

        curl_close($ch);
    }

    public function handleWebhook()
    {
        $webhookContent = file_get_contents("php://input");
        $webhookData = json_decode($webhookContent, true);

        if ($webhookData) {
            // Handle webhook event (e.g., update order status)
        }

        http_response_code(200); // Acknowledge receipt of the webhook
    }
}

