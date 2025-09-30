<?php
// Include the database connection file
include('db.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data and escape to prevent SQL injection
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $gstin = mysqli_real_escape_string($conn, $_POST['gstin']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $price = floatval($_POST['price']);
    $quantity = intval($_POST['quantity']);

    // Calculate total and GST
    $total_amount = round($price * $quantity, 2);
    $gst_amount = round($total_amount * 0.18, 2); // 18% GST

    // Insert customer into 'customers'
    $sql_customer = "INSERT INTO customers (name, gstin, email) VALUES ('$name', '$gstin', '$email')";
    if ($conn->query($sql_customer) === TRUE) {
        $customer_id = $conn->insert_id;

        // Insert invoice into 'invoices'
        $sql_invoice = "INSERT INTO invoices (customer_id, invoice_date, total_amount, gst_amount) 
                        VALUES ('$customer_id', NOW(), '$total_amount', '$gst_amount')";
        if ($conn->query($sql_invoice) === TRUE) {
            $invoice_id = $conn->insert_id;

            // Check if product already exists to avoid duplicates
            $sql_check_product = "SELECT id FROM products WHERE name = '$product_name' AND price = '$price' LIMIT 1";
            $result_product = $conn->query($sql_check_product);

            if ($result_product->num_rows > 0) {
                // Product already exists, fetch its ID
                $row = $result_product->fetch_assoc();
                $product_id = $row['id'];
            } else {
                // Insert new product into 'products'
                $sql_product = "INSERT INTO products (name, price) VALUES ('$product_name', '$price')";
                if ($conn->query($sql_product) === TRUE) {
                    $product_id = $conn->insert_id;
                } else {
                    echo "Error inserting product: " . $conn->error;
                    exit();
                }
            }

            // Insert invoice item
            $sql_invoice_item = "INSERT INTO invoice_items (invoice_id, product_id, quantity, price, amount) 
                                 VALUES ('$invoice_id', '$product_id', '$quantity', '$price', '$total_amount')";
            if ($conn->query($sql_invoice_item) === TRUE) {
                // Redirect to view invoice
                header("Location: view_invoice.php?id=$invoice_id");
                exit();
            } else {
                echo "Error inserting invoice item: " . $conn->error;
            }

        } else {
            echo "Error inserting invoice: " . $conn->error;
        }

    } else {
        echo "Error inserting customer: " . $conn->error;
    }
} else {
    echo "Invalid request method!";
}

$conn->close();
?>
