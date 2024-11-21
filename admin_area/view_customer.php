<?php  
if (!isset($_SESSION['admin_email'])){
  echo "<script>window.open('login.php','_self')</script>";
} else {
?>

<div class="row"><!--breadcrump start-->
	<div class="col-lg-12">
		<div class="breadcrump">
			<li class="active">
				<i class="fa fa-bar-chart"></i>
				Dashboard / View Customers
			</li>
		</div>
	</div>
</div><!--breadcrump End-->
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">
					<i class="fa fa-money fa-fw"></i>
					View Customers
				</h3>
			</div>
			<div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Customer No: </th>
                                <th>Customer Name: </th>
                                <th>Customer Email: </th>
                                <th>Customer Image: </th>
                                <th>Customer Country: </th>
                                <th>Customer City: </th>
                                <th>Customer Phone Number: </th>
                                <th>Customer Delete: </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $i=0;
                            $get_c="select * from customers";
                            $run_c=mysqli_query($con,$get_c);

                            while ($row_c=mysqli_fetch_array($run_c)) {
                                $c_id=$row_c['customer_id'];
                                $c_name=$row_c['customer_name'];
                                $c_email=$row_c['customer_email'];
                                $c_image=$row_c['customer_image'];
                                $c_country=$row_c['customer_country'];
                                $c_city=$row_c['customer_city'];
                                $c_contact=$row_c['customer_contact'];
                                $i++;
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $c_name; ?></td>
                                <td><?php echo $c_email; ?></td>
                                <td><img src="../customer/customer_images/<?php echo $c_image; ?>" width="60" height="60"></td>
                                <td><?php echo $c_country; ?></td>
                                <td><?php echo $c_city; ?></td>
                                <td><?php echo $c_contact; ?></td>
                                <td>
                                    <a href="index.php?customer_delete=<?php echo $c_id; ?>"> <i class="fa fa-trash"></i> Delete </a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <!-- Customer Analysis Section -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Customer Analysis</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Customer ID</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Total Orders</th>
                                                <th>Total Spent</th>
                                                <th>Last Order</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $customers = getAllCustomersReport();
                                            foreach($customers as $customer): 
                                            ?>
                                            <tr>
                                                <td><?php echo $customer['customer_id']; ?></td>
                                                <td><?php echo $customer['customer_name']; ?></td>
                                                <td><?php echo $customer['customer_email']; ?></td>
                                                <td><?php echo $customer['total_orders']; ?></td>
                                                <td>$<?php echo number_format($customer['total_spent'], 2); ?></td>
                                                <td><?php echo $customer['last_order_date'] ? date('M d, Y', strtotime($customer['last_order_date'])) : 'No orders'; ?></td>
                                                <td>
                                                    <a href="view_customer_details.php?customer_id=<?php echo $customer['customer_id']; ?>" 
                                                       class="btn btn-info btn-sm">View Details</a>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End of Customer Analysis Section -->

            </div>
        </div>
    </div>
</div>

<?php } ?>