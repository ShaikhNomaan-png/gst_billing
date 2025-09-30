<?php
include('db.php');

// Fetch specific invoice if ID is provided
if (isset($_GET['id'])) {
    $invoice_id = $_GET['id'];

    $sql = "SELECT invoices.*, customers.name AS customer_name 
            FROM invoices 
            JOIN customers ON invoices.customer_id = customers.id 
            WHERE invoices.id = '$invoice_id'";
    
    $result_invoice = $conn->query($sql);

    if ($result_invoice->num_rows > 0) {
        $invoice = $result_invoice->fetch_assoc();
    } else {
        echo "Invoice not found!";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice <?php echo isset($invoice) ? "#".$invoice['id'] : ""; ?></title>
    <link rel="stylesheet" href="style2.css">
    <script>
        function printInvoice() {
            window.print();
        }
    </script>
</head>
<body>
    <div class="container">
        <header>
            <h1><?php echo isset($invoice) ? "Invoice #".$invoice['id'] : "Invoice Details"; ?></h1>
        </header>

        <?php if (isset($invoice)) { ?>
        <div class="invoice-details">
            <h3>Invoice Details</h3>
            <p><strong>Customer Name:</strong> <?php echo $invoice['customer_name']; ?></p>
            <p><strong>Date:</strong> <?php echo $invoice['invoice_date']; ?></p>
            <p><strong>Total Amount:</strong> ₹<?php echo number_format($invoice['total_amount'], 2); ?></p>
            <p><strong>GST Amount:</strong> ₹<?php echo number_format($invoice['gst_amount'], 2); ?></p>
            
            <!-- Print Invoice Button -->
            <button onclick="printInvoice()">Print Invoice</button>
        </div>
        <?php } ?>

        <!-- Button to go to the new page showing all invoices -->
        <div>
            <a href="all_invoices.php"><button>View All Invoices</button></a>
        </div>

    </div>
</body>
</html>

<?php $conn->close(); ?>
