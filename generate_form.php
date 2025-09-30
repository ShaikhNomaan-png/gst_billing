<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GST Billing System</title>
    <!-- Link to External CSS File -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>GST Billing System</h1>

    <form action="generate_invoice.php" method="post">
        <!-- Customer Information -->
        <div class="form-section">
            <h2>Customer Information</h2>
            <input type="text" name="name" placeholder="Customer Name" required><br>
            <input type="text" name="gstin" placeholder="GSTIN" required><br>
            <input type="email" name="email" placeholder="Email" required><br>
        </div>

        <!-- Product Information -->
        <div class="form-section">
            <h2>Product Information</h2>
            <input type="text" name="product_name" placeholder="Product Name" required><br>
            <input type="number" name="price" placeholder="Price" step="0.01" required><br>
            <input type="number" name="quantity" placeholder="Quantity" min="1" required><br>
        </div>

        <!-- Submit Button -->
        <div class="form-section">
            <input type="submit" value="Generate Invoice">
        </div>
    </form>
</body>
</html>
