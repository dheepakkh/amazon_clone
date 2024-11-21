
<?php

$db=mysqli_connect("localhost","root","MySQL@1754","e_com");
function getPro(){
	global $db;
	$get_product="select * from products order by 1 DESC LIMIT 0,6";
	$run_products=mysqli_query($db,$get_product);
	while ($row_product=mysqli_fetch_array($run_products)) {
		$pro_id=$row_product['product_id'];
		$pro_title=$row_product['product_title'];
		$pro_price=$row_product['product_price'];
		$pro_img1=$row_product['product_img1'];

		echo "<div class='col-md-4 col-sm-6 single'>
		<div class='product'>
		<a href='details.php?pro_id=$pro_id'>
		<img src='admin_area/product_images/$pro_img1' class='img-responsive'>
		</a>
		
		<h3><a href='details.php?pro_id=$pro_id'>$pro_title  </a></h3>
		<p class='price'> INR $pro_price</p>
		<p class='buttons'> 
		<a href='details.php?pro_id=$pro_id' class='btn btn-default'>View Details</a>
		<a href='details.php?pro_id=$pro_id' class='btn btn-primary'><i class='fa fa-shopping-cart'></i>Add to Cart</a>
		 </p>

		
	
        </div>
        </div>";

	}
}


function getCustomerDetails($customer_id) {
	global $con;
	$query = "SELECT 
							c.*, 
							calculate_customer_total(c.customer_id) as total_spent,
							COUNT(co.order_id) as total_orders,
							MAX(co.order_date) as last_order_date
						FROM customers c
						LEFT JOIN customer_order co ON c.customer_id = co.customer_id
						WHERE c.customer_id = ?
						GROUP BY c.customer_id";
	
	$stmt = $con->prepare($query);
	$stmt->bind_param("i", $customer_id);
	$stmt->execute();
	return $stmt->get_result()->fetch_assoc();
}

function getAllCustomersReport() {
	global $con;
	$query = "SELECT 
							c.customer_id,
							c.customer_name,
							c.customer_email,
							calculate_customer_total(c.customer_id) as total_spent,
							COUNT(co.order_id) as total_orders,
							MAX(co.order_date) as last_order_date
						FROM customers c
						LEFT JOIN customer_order co ON c.customer_id = co.customer_id
						GROUP BY c.customer_id
						ORDER BY total_spent DESC";
	
	$result = $con->query($query);
	$customers = array();
	while($row = $result->fetch_assoc()) {
			$customers[] = $row;
	}
	return $customers;
}


  ?>
 