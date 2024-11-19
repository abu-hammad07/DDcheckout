<?php

// Define constants
define('API_TOKEN', 'Y4VQKJ3-6ERMPED-K6XXRQT-MFGV6MP');

// Function to generate invoice
function generateInvoice() {
    $invoice = [
        "id" => "672bd6e36c11a001eb13ff1d",
        "createdAt" => date(DATE_ATOM),
        "updatedAt" => date(DATE_ATOM),
        "creationDate" => date(DATE_ATOM),
        "invoiceItems" => [
            [
                "tax" => ["type" => "fixed", "amount" => "0"],
                "currency" => "USD",
                "quantity" => 1,
                "unitPrice" => "2000",
                "name" => "Fund Wallet"
            ]
        ],
        "invoiceNumber" => "Test-1",
        "paymentTerms" => ["dueDate" => "2024-12-12T23:59:59.999Z"],
        "meta" => ["format" => "rnf_invoice", "version" => "0.0.3"],
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
        "type" => "live",
        "buyerInfo" => [
            "email" => "daniel@jimenez.com.co",
            "isCreator" => false
        ],
        "sellerInfo" => [
            "email" => "j@decensat.org",
            "address" => [
                "streetAddress" => "1712 PIONEER AVE",
                "extendedAddress" => "STE 101",
                "city" => "Cheyenne",
                "postalCode" => "82001",
                "region" => "WY",
                "country" => "US",
                "locality" => "Cheyenne",
                "country-name" => "US",
                "extended-address" => "STE 101",
                "postal-code" => "82001",
                "street-address" => "1712 PIONEER AVE"
            ],
            "businessName" => "DC3",
            "taxRegistration" => "934146008",
            "userId" => "66c151e1ac3be3ea4e48c4da",
            "isVolumeIgnored" => false
        ],
        "createdBy" => "66c151e1ac3be3ea4e48c4da",
        "paymentCurrency" => "USDC-base",
        "paymentAddress" => "0xcf604e3cc07b1ea04846431adf260075384238f6",
        "miscellaneous" => [
            "notifications" => ["creation" => true]
        ],
        "denominationCurrency" => "USD",
        "role" => "seller",
        "tags" => ["funding wallet"]
    ];

    return json_encode($invoice, JSON_PRETTY_PRINT);
}

// Display the generated invoice
echo generateInvoice();

