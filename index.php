<?php
// Include Composer's autoloader to use Stripe SDK
require 'vendor/autoload.php'; // This loads Stripe PHP SDK

// Start session to track data if needed
session_start();

// Routing Logic
if (isset($_GET['page'])) {
    if ($_GET['page'] == 'checkout') {
        checkout();
    } elseif ($_GET['page'] == 'success') {
        success();
    } else {
        index();
    }
} else {
    index();
}

function index()
{
    // Redirect to the home.php page
    header("Location: dashboard.php?price={$_GET['price']}");
    // header("Location: https://decensatdesign.com");
    exit;
}



// Function to handle the Stripe Checkout session
function checkout()
{
    require 'database_connection.php';
    // Set your Stripe Secret Key
    \Stripe\Stripe::setApiKey('sk_test_51Q7hfYH4t5vduQNBWYZf8F9DMQqMR5f9T9oHjHfeaE6m8OfRB1DWARDZA54RQ3ibm6Mhaq2GPOFxNf7SGE0CvCLK00A0lToz38'); // Replace with your actual secret key from Stripe

    if (isset($_GET['id'])) {
        $id = intval($_GET['id']); // Sanitize input to prevent SQL injection

        // Prepare SQL statement to prevent SQL injection
        $sql = "SELECT event_calendar.*, event_customer.* 
                FROM event_calendar 
                LEFT JOIN event_customer 
                ON event_calendar.customer_id = event_customer.id 
                WHERE event_calendar.event_id = ?";

        // Use prepared statements
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            // Ensure $price is numeric
            if (isset($row['price']) && is_numeric($row['price'])) {
                $price = floatval($row['price']); // Convert to a float

                // Fetch created_at time and ensure it's valid
                if (isset($row['created_at'])) {
                    $created_at = $row['created_at'];

                    // Get current time and calculate the time difference
                    $current_time = new DateTime('now', new DateTimeZone('Asia/Karachi'));
                    $event_time = new DateTime($created_at, new DateTimeZone('Asia/Karachi'));

                    // Calculate the time difference in hours and minutes
                    $time_difference = $event_time->diff($current_time);
                    $hours_difference = $time_difference->h;
                    $minutes_difference = $time_difference->i;

                    // Apply $100 discount if within 2 hours
                    if ($hours_difference < 2 || ($hours_difference == 2 && $minutes_difference == 0)) {
                        $price -= 100;
                        // Ensure price doesn't go below zero
                        $price = max(0, $price);
                    }
                } else {
                    echo "Invalid event time data.";
                    exit;
                }
            } else {
                echo "Invalid price data.";
                exit;
            }
        } else {
            echo "No event found.";
            exit;
        }
    }

    try {
        // Create a Stripe Checkout session
        $session = \Stripe\Checkout\Session::create([
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'gbp', // Set the currency
                        'product_data' => [
                            'name' => 'Send me money!!!', // Name of the product
                        ],
                        'unit_amount' => (int) ($price * 100), // Price in pence
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => 'http://localhost/stripe_finance_payments/index.php?page=success', // Success URL after payment
            'cancel_url' => 'http://localhost/stripe_finance_payments/index.php', // Cancel URL if the payment fails
        ]);

        // Redirect the user to the Stripe Checkout page
        header("Location: " . $session->url);
        exit;

    } catch (Exception $e) {
        // Handle any errors
        echo 'Error creating checkout session: ' . $e->getMessage();
    }




}

// Function to display the success page
function success()
{
    echo '<h1>Payment Successful!</h1>';
    echo '<p>Thank you for your payment.</p>';
    echo '<a href="index.php">Back to Home</a>';
}
