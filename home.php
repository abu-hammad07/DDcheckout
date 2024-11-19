<?php
session_start();

require 'database_connection.php';

if (isset($_GET['id'])) {
    $customer_id = $_GET['id'];
    $sql = "SELECT event_calendar.*, event_customer.* 
            FROM event_calendar 
            LEFT JOIN event_customer 
            ON event_calendar.customer_id = event_customer.id 
            WHERE event_calendar.event_id = $customer_id";

    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Ensure $price is numeric
        if (is_numeric($row['price'])) {
            $price = floatval($row['price']); // Convert to a float or int if needed
            $created_at = $row['created_at']; // Fetch created_at time

            // Get current time and calculate the time difference
            $current_time = new DateTime('now', new DateTimeZone('Asia/Karachi'));
            $event_time = new DateTime($created_at, new DateTimeZone('Asia/Karachi'));

            // Calculate the time difference in seconds
            $time_difference_in_seconds = ($event_time->getTimestamp() + (2 * 60 * 60)) - $current_time->getTimestamp();

            // Apply $100 discount if within 2 hours
            if ($time_difference_in_seconds > 0) {
                $price -= 100;
                if ($price < 0) {
                    $price = 0;
                }
            }
        } else {
            echo "Invalid price data.";
            exit;
        }
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payment Method</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<style>
    /* Center the entire timer-box */
    .timer-box {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        /* Adds space between each span */
        font-size: 24px;
        color: #fff;
        margin-bottom: 15px;
    }

    /* Individual time units (span) styling */
    .timer-box span {
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #8fd13f;
        border-radius: 8px;
        padding: 10px 15px;
        min-width: 60px;
        /* Ensure all time units have equal width */
    }

    /* Button group centering */
    .btn-group {
        text-align: center;
    }

    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        margin: 5px;
        cursor: pointer;
    }

    .btn-primary {
        background-color: #5856d6;
        color: white;
    }

    .btn-outline-primary {
        background-color: transparent;
        border: 1px solid #5856d6;
        color: #5856d6;
    }
</style>

<body class="bg-dark">

    <div class="container">
        <div class="row text-center mt-5 justify-content-center align-items-center">

            <h1 class="text-white">Payment Method</h1>

            <?php
            if (isset($_SESSION['error'])) {  // Ensure the session variable is set
                echo '<div class="alert alert-danger">';
                echo $_SESSION['error'];      // Display the error message
                echo '</div>';
                unset($_SESSION['error']);    // Optionally clear the error after displaying
            }
            ?>

            <div class="timer-box mt-2">
                <span id="days">00</span> :
                <span id="hours">02</span> :
                <span id="minutes">00</span> :
                <span id="seconds">00</span>
            </div>

            <p class="text-white">Left to avail 100$ discount 💸</p>
            <div class="btn-group mt-2 justify-content-center">


                <form method="POST" action="index.php?id=<?= $customer_id ?>&page=checkout">
                    <button type="submit" class="btn btn-primary me-2">Stripe Payment</button>
                </form>

                <!-- <form action="index2.php?id=<?= $customer_id ?>" method="POST">
                    <button type="submit" class="btn btn-outline-primary">Finance Payment</button>
                </form> -->
                <form action="stripe-payment/index.php?id=<?= $customer_id ?>" method="POST">
                    <button type="submit" class="btn btn-outline-primary">Finance Payment</button>
                </form>

            </div>

            <a href="https://ddcheckout.com/" class="mt-3">Not Now</a>

        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>

    <script>
        // PHP will echo the remaining time in milliseconds (from server-side PHP)
        var countdownTime = <?php echo $time_difference_in_seconds * 1000; ?>;
        var endTime = new Date().getTime() + countdownTime;

        function updateTimer() {
            var now = new Date().getTime();
            var distance = endTime - now;

            // Time calculations for days, hours, minutes, and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Output the result in the respective elements
            document.getElementById("days").innerHTML = ('0' + days).slice(-2);
            document.getElementById("hours").innerHTML = ('0' + hours).slice(-2);
            document.getElementById("minutes").innerHTML = ('0' + minutes).slice(-2);
            document.getElementById("seconds").innerHTML = ('0' + seconds).slice(-2);

            // If the countdown is finished, stop the timer and display a message
            if (distance < 0) {
                clearInterval(timerInterval);
                document.querySelector('.timer-box').innerHTML = "Time is up!";
            }
        }

        // Update the timer every 1 second
        var timerInterval = setInterval(updateTimer, 1000);
    </script>


</body>

</html>