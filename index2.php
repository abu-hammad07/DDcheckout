<?php
session_start();

// Include the FinanceController class
include 'FinanceController.php';

// Instantiate the controller
$controller = new FinanceController();

// Routing logic
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    
    switch ($page) {
        case 'finance':
            $controller->financePayment(); // Load finance payment form
            break;
        case 'create-payment':
            $controller->createPaymentRequest(); // Process the payment request
            break;
        case 'webhook':
            $controller->handleWebhook(); // Handle webhook data
            break;
        default:
            $controller->financePayment(); // Default to finance payment form
            break;
    }
} else {
    $controller->financePayment(); // Default to finance payment form
}
