<?php
require 'database_connection.php';

if (isset($_GET['id'])) {
    // Sanitize input to prevent SQL injection
    $id = intval($_GET['id']);

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

                // Calculate the time difference
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
} else {
    echo "No event ID provided.";
    exit;
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

    <div class="container">
        <div class="row mt-3 mb-5">

            <h1 class="text-center">Request Finance Payment</h1>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?php echo $_SESSION['error'];
                    unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <div class="col-md-6 offset-md-3 card mt-3">
                <form class="row g-3 needs-validation card-body" novalidate action="index2.php?page=create-payment"
                    method="POST">
                    <?php
                    $eventId = uniqid('event_', true); // Example of generating a unique ID
                    ?>
                    <input type="hidden" name="event_id" value="<?php echo $eventId; ?>">
                    <div class="col-md-12">
                        <label class="form-label">Email address</label>
                        <input type="email" class="form-control" name="email" required>
                        <div class="valid-feedback">Looks good!</div>
                    </div>
                    <div class="col-md-12">
                        <!-- <label class="form-label">Payment amount (in dollars or cents, <span class="text-danger">if
                                $10.00 type 1000</span>)</label> -->
                        <label class="form-label">Payment amount</label>
                        <!-- HTML Part -->
                        <!-- <input type="number" class="form-control" name="amount" required readonly
                            value="<?php //echo isset($price) ? $price * 100 : 0; ?>">  -->
                        <input type="number" class="form-control" name="amount" required readonly
                            value="<?php echo $price ?>"> <!-- Output price in pence -->

                        <div class="valid-feedback">Looks good!</div>
                    </div>
                    <!-- <div class="col-md-12">
                        <label class="form-label">Crypto wallet address</label>
                        <input type="text" class="form-control" name="crypto_wallet" required>
                        <div class="valid-feedback">Looks good!</div>
                    </div> -->
                    <!-- <div class="col-md-12">
                        <label class="form-label">Wallet Type (e.g., ethereum):</label>
                        <input type="text" class="form-control" name="wallet_type" required>
                        <div class="valid-feedback">Looks good!</div>
                    </div> -->
                    <div class="col-md-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" rows="6" class="form-control" required></textarea>
                        <div class="valid-feedback">Looks good!</div>
                    </div>

                    <div class="col-12">
                        <div class="btn-group">
                            <button class="btn btn-primary me-2" type="submit">Pay Now</button>
                            <a class="btn btn-outline-primary" href="home.php?id=<?= $id ?>">Cancel</a>
                            <!-- <a class="btn btn-outline-primary" href="https://ddcheckout.com/">Cancel</a> -->
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>

    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (() => {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            const forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
</body>

</html>