<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");  // Redirect to login page if not logged in
    exit();
}

include('db.php');

// Fetch invoice data or any other information needed for the dashboard
$sql = "SELECT * FROM invoices";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Welcome, Admin!</h1>
    <a href="logout.php">Logout</a>

    <h2>Invoice List</h2>
    <table>
        <tr>
            <th>Invoice ID</th>
            <th>Customer Name</th>
            <th>Total Amount</th>
            <th>Date</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><a href="view_invoice.php?id=<?php echo $row['id']; ?>">#<?php echo $row['id']; ?></a></td>
            <td><?php echo $row['customer_name']; ?></td>
            <td>₹<?php echo $row['total_amount']; ?></td>
            <td><?php echo $row['invoice_date']; ?></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
