<?php
ob_start(); // Start output buffering
session_start(); // Start the session
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Request</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h3>Create Invoice</h3>
                    </div>
                    <div class="card-body">
                        <!-- Display Response -->
                        <?php if (isset($_SESSION['response'])): ?>
                            <div class="alert alert-info alert-dismissible fade show" role="alert">
                                <?= $_SESSION['response'] ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <?php unset($_SESSION['response']); ?>
                        <?php endif; ?>

                        <!-- Form -->
                        <form method="post" action="">
                            <!-- Authorization -->
                            <div class="mb-3">
                                <label for="authorization" class="form-label">Buyer Authorization</label>
                                <input type="text" id="authorization" name="authorization" class="form-control" required>
                            </div>

                            <!-- Buyer Info -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Buyer Email</label>
                                <input type="email" id="email" name="email" class="form-control" required>
                            </div>

                            <!-- Invoice Items -->
                            <div class="mb-3">
                                <label for="itemName" class="form-label">Item Name</label>
                                <input type="text" id="itemName" name="itemName" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="itemCurrency" class="form-label">Currency</label>
                                <input type="text" id="itemCurrency" name="itemCurrency" class="form-control" value="USD" required>
                            </div>

                            <div class="mb-3">
                                <label for="itemQuantity" class="form-label">Quantity</label>
                                <input type="number" id="itemQuantity" name="itemQuantity" class="form-control" min="1" value="1" required>
                            </div>

                            <div class="mb-3">
                                <label for="unitPrice" class="form-label">Unit Price</label>
                                <input type="number" id="unitPrice" name="unitPrice" class="form-control" step="0.01" required>
                            </div>

                            <!-- Payment Terms -->
                            <div class="mb-3">
                                <label for="dueDate" class="form-label">Due Date</label>
                                <input type="datetime-local" id="dueDate" name="dueDate" class="form-control" required>
                            </div>

                            <!-- Invoice Number -->
                            <div class="mb-3">
                                <label for="invoiceNumber" class="form-label">Invoice Number</label>
                                <input type="text" id="invoiceNumber" name="invoiceNumber" class="form-control" required>
                            </div>

                            <!-- Payment Options -->
                            <div class="mb-3">
                                <label for="paymentAddress" class="form-label">Payment Address</label>
                                <input type="text" id="paymentAddress" name="paymentAddress" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="paymentChain" class="form-label">Chain</label>
                                <input type="text" id="paymentChain" name="paymentChain" class="form-control" value="base" required readonly>
                            </div>

                            <!-- Tags -->
                            <div class="mb-3">
                                <label for="tags" class="form-label">Tags</label>
                                <input type="text" id="tags" name="tags" class="form-control" value="funding wallet" required readonly>
                            </div>

                            <!-- Submit Button -->
                            <div class="text-center">
                                <button type="submit" name="submit" class="btn btn-primary">Submit Invoice</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        sendInvoiceRequest($_POST);
    }

    function sendInvoiceRequest($formData)
    {
        $url = "https://api.request.finance/invoices";

        // Prepare data for API
        $data = [
            "buyerInfo" => [
                "email" => $formData['email']
            ],
            "invoiceItems" => [
                [
                    "currency" => $formData['itemCurrency'],
                    "name" => $formData['itemName'],
                    "quantity" => (int)$formData['itemQuantity'],
                    "unitPrice" => $formData['unitPrice']
                ]
            ],
            "paymentTerms" => [
                "dueDate" => date(DATE_ISO8601, strtotime($formData['dueDate']))
            ],
            "invoiceNumber" => $formData['invoiceNumber'],
            "paymentOptions" => [
                [
                    "type" => "wallet",
                    "value" => [
                        "currencies" => ["USDC-base"],
                        "paymentInformation" => [
                            "paymentAddress" => $formData['paymentAddress'],
                            "chain" => $formData['paymentChain']
                        ]
                    ]
                ]
            ],
            "tags" => [$formData['tags']]
        ];

        // Set up cURL
        $payload = json_encode($data);
        $headers = [
            // "Authorization: DAQA4BW-4WSM3DV-MRZ6W69-JVJS52Z",
            "Authorization: " . $formData['authorization'], // Use the value from the form
            "Content-Type: application/json"
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            $_SESSION['response'] = 'Error: ' . curl_error($ch);
        } else {
            $_SESSION['response'] = 'Response: ' . htmlspecialchars($response);
        }

        curl_close($ch);
        header('Location: ' . $_SERVER['PHP_SELF']); // Refresh to display response
        exit;
    }
    ?>
</body>

</html>