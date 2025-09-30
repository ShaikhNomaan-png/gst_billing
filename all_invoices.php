<?php
include('db.php');

// For invoice listing by date range or default
if (isset($_POST['start_date']) && isset($_POST['end_date'])) {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    $sql_list = "SELECT invoices.id, invoices.invoice_date, invoices.total_amount, customers.name AS customer_name 
                FROM invoices 
                JOIN customers ON invoices.customer_id = customers.id 
                WHERE invoice_date BETWEEN '$start_date' AND '$end_date'";
} else {
    $sql_list = "SELECT invoices.id, invoices.invoice_date, invoices.total_amount, customers.name AS customer_name 
                FROM invoices 
                JOIN customers ON invoices.customer_id = customers.id";
}

$result_list = $conn->query($sql_list);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Invoices</title>
    <link rel="stylesheet" href="style3.css">
</head>
<body>
<div id="react-root"></div>
<script type="module" src="assets/index-xxxxx.js"></script> <!-- Replace with actual filename -->

    <div class="container">
        <header>
            <h1>All Invoices</h1>
        </header>

        <!-- Search by Date Range Form -->
        <div class="date-search">
            <h3>Search Invoices by Date Range</h3>
            <form method="POST" action="all_invoices.php">
                <label for="start_date">Start Date:</label>
                <input type="date" name="start_date" required>
                <label for="end_date">End Date:</label>
                <input type="date" name="end_date" required>
                <input type="submit" value="Search">
            </form>
        </div>

        <!-- Display List of All Invoices -->
        <div class="invoice-list">
            <h3>List of All Invoices</h3>
            <?php if ($result_list->num_rows > 0) { ?>
                <table border="1">
                    <tr>
                        <th>Invoice ID</th>
                        <th>Customer Name</th>
                        <th>Invoice Date</th>
                        <th>Total Amount</th>
                    </tr>
                    <?php while ($row = $result_list->fetch_assoc()) { ?>
                        <tr>
                            <td><a href="view_invoice.php?id=<?php echo $row['id']; ?>">#<?php echo $row['id']; ?></a></td>
                            <td><?php echo $row['customer_name']; ?></td>
                            <td><?php echo $row['invoice_date']; ?></td>
                            <td>₹<?php echo $row['total_amount']; ?></td>
                        </tr>
                    <?php } ?>
                </table>
            <?php } else { ?>
                <p>No invoices found.</p>
            <?php } ?>
        </div>

        <!-- Button to go back to the invoice details page -->
        <div class="button-group">
            <a href="generate_form.php"><button>Add Bill</button></a>
            <a href="index.html"><button>Back to Home</button></a>
        </div>


    </div>
</body>
</html>

<?php $conn->close(); ?>
