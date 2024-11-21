<?php
session_start();
include("includes/db.php");
include("functions/functions.php");

if (isset($_GET['c_id'])) {
    $customer_id = $_GET['c_id'];
}

$ip_add = getUserIp();
$status = "pending";
$invoice_no = mt_rand();

try {
    // Disable autocommit mode
    mysqli_begin_transaction($con);

    // Fetch all items in the cart for the current session
    $select_cart = "SELECT * FROM cart WHERE ip_add='$ip_add'";
    $run_cart = mysqli_query($con, $select_cart);

    while ($row_cart = mysqli_fetch_array($run_cart)) {
        $pro_id = $row_cart['p_id'];
        $size = $row_cart['size'];
        $qty = $row_cart['qty'];

        // Get product details
        $get_product = "SELECT * FROM products WHERE product_id='$pro_id'";
        $run_pro = mysqli_query($con, $get_product);
        $row_pro = mysqli_fetch_array($run_pro);
        
        $sub_total = $row_pro['product_price'] * $qty;

        // Insert customer order
        $insert_customer_order = "INSERT INTO customer_order 
            (customer_id, product_id, due_amount, invoice_no, qty, size, order_date, order_status) 
            VALUES 
            ('$customer_id', '$pro_id', '$sub_total', '$invoice_no', '$qty', '$size', NOW(), '$status')";
        $run_cust_order = mysqli_query($con, $insert_customer_order);
        
        if (!$run_cust_order) {
            throw new Exception("Error inserting customer order: " . mysqli_error($con));
        }
    }

    // Delete cart items after order is placed
    $delete_cart = "DELETE FROM cart WHERE ip_add='$ip_add'";
    $run_del = mysqli_query($con, $delete_cart);

    if (!$run_del) {
        throw new Exception("Error deleting cart: " . mysqli_error($con));
    }

    // Commit transaction
    mysqli_commit($con);
    
    echo "<script>alert('Your order has been submitted, Thanks')</script>";
    echo "<script>window.open('customer/my_account.php?my_order','_self')</script>";
    
} catch (Exception $e) {
    // Rollback if any error occurs
    mysqli_rollback($con);
    echo "<script>alert('Order submission failed: {$e->getMessage()}')</script>";
}

// Close the database connection
mysqli_close($con);
?>
