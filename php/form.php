<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Form</title>
</head>

<body>

    <h2>Create an Invoice</h2>
    <form action="stripe.php" method="POST" class="g-3 needs-validation" novalidate>
        <label for="email" class="form-label">Buyer Email:</label>
        <input class="form-control" type="email" id="email" name="buyer_email" required>
        <br><br>

        <label class="form-label" for="currency">Currency:</label>
        <select class="form-control" id="currency" name="currency" required>
            <option value="USD">USD</option>
        </select><br><br>

        <label class="form-label" for="item_name">Item Name:</label>
        <input class="form-control" type="text" id="item_name" name="item_name" required>
        <br><br>

        <label class="form-label" for="quantity">Quantity:</label>
        <input class="form-control" type="number" id="quantity" name="quantity" value="1" required>
        <br><br>

        <label class="form-label" for="unit_price">Unit Price:</label>
        <input class="form-control" type="number" id="unit_price" name="unit_price" required>
        <br><br>

        <label class="form-label" for="due_date">Due Date:</label>
        <input class="form-control" type="date" id="due_date" name="due_date" required>
        <br><br>

        <label class="form-label" for="invoice_number">Invoice Number:</label>
        <input class="form-control" type="text" id="invoice_number" name="invoice_number" required>
        <br><br>

        <label class="form-label" for="payment_address">Payment Address:</label>
        <input class="form-control" type="text" id="payment_address" name="payment_address" required>
        <br><br>

        <label class="form-label" for="chain">Blockchain Network:</label>
        <select class="form-control" id="chain" name="chain">
            <option value="base">Base</option>
        </select>
        <br><br>

        <label class="form-label" for="tags">Tags:</label>
        <input class="form-control" type="text" id="tags" name="tags" placeholder="e.g., funding wallet"><br><br>

        <input type="submit" value="Create Invoice">
    </form>


</body>

</html> -->



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

    <div class="container">
        <div class="row mt-3 mb-5">

            <h1 class="text-center">Request Finance Payment</h1>

            <div class="col-md-6 offset-md-3 card mt-3">
                <form class="row g-3 needs-validation card-body" novalidate action="stripe.php" method="POST">

                    <div class="col-md-12">
                        <!-- Buyer Information -->
                        <label for="email" class="form-label">Buyer Email:</label>
                        <input class="form-control" type="email" id="email" name="buyer_email" required>
                        <div class="valid-feedback">Looks good!</div>
                    </div>
                    

                    <div class="col-md-12">
                        <!-- Invoice Item Details -->
                        <label class="form-label" for="currency">Currency:</label>
                        <select class="form-control" id="currency" name="currency" required>
                            <option value="USD">USD</option>
                        </select>
                        <div class="valid-feedback">Looks good!</div>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label" for="item_name">Item Name:</label>
                        <input class="form-control" type="text" id="item_name" name="item_name" required>
                        <div class="valid-feedback">Looks good!</div>
                    </div>
                    

                    <div class="col-md-12">
                        <label class="form-label" for="quantity">Quantity:</label>
                        <input class="form-control" type="number" id="quantity" name="quantity" value="1" required>
                        <div class="valid-feedback">Looks good!</div>
                    </div>
                    

                    <div class="col-md-12">
                        <label class="form-label" for="unit_price">Unit Price:</label>
                        <input class="form-control" type="number" id="unit_price" name="unit_price" required>
                        <div class="valid-feedback">Looks good!</div>
                    </div>
                    

                    <div class="col-md-12">
                        <!-- Payment Terms -->
                        <label class="form-label" for="due_date">Due Date:</label>
                        <input class="form-control" type="date" id="due_date" name="due_date" required>
                        <div class="valid-feedback">Looks good!</div>
                    </div>
                    

                    <div class="col-md-12">
                        <!-- Invoice Number -->
                        <label class="form-label" for="invoice_number">Invoice Number:</label>
                        <input class="form-control" type="text" id="invoice_number" name="invoice_number" required>
                        <div class="valid-feedback">Looks good!</div>
                    </div>
                    

                    <div class="col-md-12">
                        <!-- Payment Options -->
                        <label class="form-label" for="payment_address">Payment Address:</label>
                        <input class="form-control" type="text" id="payment_address" name="payment_address" required>
                        <div class="valid-feedback">Looks good!</div>
                    </div>

                    
                    <div class="col-md-12">
                        <label class="form-label" for="chain">Blockchain Network:</label>
                        <select class="form-control" id="chain" name="chain">
                            <option value="base">Base</option>
                        </select>
                        <div class="valid-feedback">Looks good!</div>
                    </div>

                    <div class="col-12">
                        <div class="btn-group">
                            <button class="btn btn-primary me-2" type="submit">Pay Now</button>
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