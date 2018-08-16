
<!DOCTYPE html>
<html>
<head>

	<title>Buyer's Information</title>
	<link rel="stylesheet" type="text/css" href="homepage style.css">
	<link rel="stylesheet" type="text/css" href="home.css">
	<link rel="stylesheet" type="text/css" href="profile.css">

	<style type="text/css">
	#complete_btn{
		font-family: "Roboto",sans-serif;
		t/*ext-transform: uppercase;*/
		outline: 0;
		background:green;
		width: 90px;
		height: 35px;
		/*margin-left: 10px;*/
		border: 0;
	/*margin-top: 10px;
	margin-bottom: 10PX;*/
	/*padding: 15px;*/
	border-radius: 5px 5px 5px 5px;
	color: #FFFFFF;
	font-size: 12px;
	cursor: pointer;
	text-decoration: none;
}
#restore_btn{
	font-family: "Roboto",sans-serif;
	/*ext-transform: uppercase;*/
	outline: 0;
	background:orange;
	width: 90px;
	height: 35px;
	border-radius: 5px 5px 5px 5px;
	/*margin-left: 10px;*/
	border: 0;
	/*margin-top: 10px;
	margin-bottom: 10PX;*/
	/*padding: 15px;*/
	color: #FFFFFF;
	font-size: 12px;
	cursor: pointer;
	text-decoration: none;
}
</style>
<script type="text/javascript">
	function active(){
		var sb = document.getElementById('searchBox');

		if(sb.value=='Search...'){
			sb.value=''
			sb.placeholder= 'Search...'
		}
	}

	function inactive(){
		var sb = document.getElementById('searchBox');

		if(sb.value==''){
			sb.value='Search...'
			sb.placeholder= ''
		}
	}
</script>
</head>
<body style="background-color: #eff5f5">
	<header>
		<nav>
			<h1>PriceHero</h1>
			<ul id="nav"> 
				<li> <a class = "homeblack" href="post items.php"> Post Items</a></li>
				<li> <a class="homeblack" id="noti" href="seller notification.php"> Notification<div style = "
				position: absolute;
				top: 33px;
				color: red;
				display: inline-block;">
				<?php 
				$db = mysqli_connect("localhost","root","","authentication");
				session_start();
				$current_logger = $_SESSION['emailid'];
				$unread = "SELECT * from seller_notification where status = 'unread' and productowner = '$current_logger' ";
				$unread = mysqli_query($db,$unread);
				$newNotification = mysqli_num_rows($unread);

				if($newNotification > 0){

					echo '('.$newNotification.')';
				}
				// $update = "UPDATE buyer_notification set status = 'read' where buyeremail = '$current_logger' ";
				// 	mysqli_query($db,$update);

				?>
			</div>
		</a></li>
		<li> <a class="homeblack" href="seller about.php"> About</a></li>
		<li> <a class="homered" href="buyer record.php"> Buyer's Info</a></li>
		<li> <a class="homeblack" href="#popup1"> Profile</a> </li>
		<li> <a class="homeblack" href="index.php"> Logout</a></li>
	</ul>
	<form action="buyer record.php" class = "search-form" method="post" id="searchForm" />
	<input type="text" name="q" id="searchBox" placeholder="" value="Search..." maxlength="25" autocomplete="off" onmousedown="active();" onblur="inactive();" />
	<button type="submit" name="search_btn" id="searchBtn" formaction="#">GO!</button>

</form>
</nav>
</header>


<table align="center" style="width: 1000px;line-height: 40px; background: white; margin-left: 50px; ">
	<tr>
		<th colspan="10" ><h2>Buyer's Record</h2></th>
	</tr>

	<t><th>Name</th>
		<th>PhoneNumber</th>
		<th>Email ID</th>
		<th>Productname</th>
		<th>Amount</th>
		<th>Deadline</th>
		<th>sell_btn</th>
		<th>restore_btn</th>
	</t>
	<?php
	$db = mysqli_connect("localhost","root","","authentication");
	// session_start();
	$current_logger = $_SESSION['emailid'];
	if(!isset($_POST['search_btn'])){
		$record = "SELECT * from buyer_record where selleremail='$current_logger'";
		$record_res = mysqli_query($db,$record);
		while($record_row = $record_res->fetch_assoc()){
			$buyername = $record_row['buyername'];
			$selleremail = $record_row['buyeremail'];
			$phonenumber = $record_row['buyerphone'];
			$image = $record_row['image'];
			$deadline = $record_row['deadline'];
			$productname= $record_row['productname'];
			$amount = $record_row['amount'];
			$product_id=$record_row['product_id'];
			date_default_timezone_set('Asia/Dhaka');
			$date = date('m/d/Y    h:i:s a', time());
			// echo 'deadline'.$deadline;
			// echo 'current'.$date;
			// $diff=date_diff($date,$deadline);
// echo $diff;			// echo 'hey'.$d;

// strtotime($deadline)<strtotime($date)

			if(strtotime($date)>strtotime($deadline)){
	?>
	<tr style="background: #f443364a;">
		<td  id="row" align="center"><?php echo $buyername?></td>
		<td  id="row" align="center"><?php echo $phonenumber?></td>
		<td  id="row" align="center"><?php echo $selleremail?></td>
		<td  id="row"align="center"><?php echo $productname?></td>
		<td id="row" align="center"><?php echo $amount?></td>
		<td id="row" align="center"><?php echo $deadline?></td>
		<?php
		echo "<form method='GET'>";
		echo "<input type='hidden' name='product_id' value='$product_id' />";
		echo '<td align="center"><button type="submit" name ="complete_btn" id="complete_btn">Complete</button></td>';
		echo '<td align="center"><button type="submit" name ="restore_btn" id="restore_btn">Restore</button></td>';
		echo "</form>";

		

		?>

	</tr>
	<?php

}
else{
	?>
	<tr>
		<td  id="row" align="center"><?php echo $buyername?></td>
		<td  id="row" align="center"><?php echo $phonenumber?></td>
		<td  id="row" align="center"><?php echo $selleremail?></td>
		<td  id="row"align="center"><?php echo $productname?></td>
		<td id="row" align="center"><?php echo $amount?></td>
		<td id="row" align="center"><?php echo $deadline?></td>

		<?php
		echo "<form method='GET'>";
		echo "<input type='hidden' name='product_id' value='$product_id' />";
		echo '<td align="center"><button type="submit" name ="complete_btn" id="complete_btn">Complete</button></td>';
		echo '<td align="center"><button type="submit" name ="restore_btn" id="restore_btn">Restore</button></td>';
		echo "</form>";

		?>

	</tr>
	<?php
		      // echo "<input type='hidden' name='product_id' value='$product_id' />";

}



}


}
else if(isset($_POST['search_btn'])){
	$q=$_POST['q']; 
	$record = "SELECT * from buyer_record where buyerphone like '%$q%' and  selleremail='$current_logger'";
	$record_res = mysqli_query($db,$record);
	while($record_row = $record_res->fetch_assoc()){
		$buyername = $record_row['buyername'];
		$selleremail = $record_row['buyeremail'];
		$phonenumber = $record_row['buyerphone'];
		$image = $record_row['image'];
		$deadline = $record_row['deadline'];
		$productname= $record_row['productname'];
		$amount = $record_row['amount'];
		$product_id=$record_row['product_id'];
		date_default_timezone_set('Asia/Dhaka');
		$date = date('m/d/Y h:i:s a', time());


		if(strtotime($date)>strtotime($deadline)){
			?>
			<tr style="background: #f443364a;">
				<td  id="row" align="center"><?php echo $buyername?></td>
				<td  id="row" align="center"><?php echo $phonenumber?></td>
				<td  id="row" align="center"><?php echo $selleremail?></td>
				<td  id="row"align="center"><?php echo $productname?></td>
				<td id="row" align="center"><?php echo $amount?></td>
				<td id="row" align="center"><?php echo $deadline?></td>
				<?php
				echo "<form method='GET'>";
				echo "<input type='hidden' name='product_id' value='$product_id' />";
					// echo "<input type='hidden' name='amount' value='$amount' />";
				echo '<td align="center"><button type="submit" name ="complete_btn"id="complete_btn">Complete</button></td>';
				echo '<td align="center"><button type="submit" name ="restore_btn" id="restore_btn">Restore</button></td>';
				echo "</form>";

				?>
			</tr>
			<?php

		}
		else{
			?>
			<tr>
				<td  id="row" align="center"><?php echo $buyername?></td>
				<td  id="row" align="center"><?php echo $phonenumber?></td>
				<td  id="row" align="center"><?php echo $selleremail?></td>
				<td  id="row"align="center"><?php echo $productname?></td>
				<td id="row" align="center"><?php echo $amount?></td>
				<td id="row" align="center"><?php echo $deadline?></td>
				<?php
				echo "<form method='GET'>";
				echo "<input type='hidden' name='product_id' value='$product_id' />";
					// echo "<input type='hidden' name='amount' value='$amount' />";
				echo '<td align="center"><button type="submit" name ="complete_btn" id="complete_btn">Complete</button></td>';
				echo '<td align="center"><button type="submit" name ="restore_btn" id="restore_btn">Restore</button></td>';
				echo "</form>";

				?>

			</tr>
			<?php

		}

	}
}

if(isset($_GET['complete_btn'])){
	date_default_timezone_set('Asia/Dhaka');
	$date = date('m/d/Y h:i:s a', time());
	$id= $_GET["product_id"];

    if(strtotime($date)<strtotime($deadline)){
	$delete = "DELETE from buyer_record where product_id = '$id'";
	mysqli_query($db,$delete);
}
}
if(isset($_GET['restore_btn'])){
	date_default_timezone_set('Asia/Dhaka');
	$date = date('m/d/Y h:i:s a', time());
	$id = $_GET["product_id"];
		// $final_amount = $_GET['amount'];
     if(strtotime($date)>strtotime($deadline)){
	$update = "UPDATE shop_table set quantity = quantity + $amount where id = '$id'";
	mysqli_query($db,$update);

	$delete = "DELETE from buyer_record where product_id = '$id'";
	mysqli_query($db,$delete);
}
}

?>
</table>
<div id="popup1" class="overlay">
	<div class="popup">
		<h2>Your Profile</h2>
		<a class="close" href="#">&times;</a>
		<div class="content">
			<img src="profile.png" style="height: 100px;width: 100px; margin-left: 40px;margin-bottom: 20px;"><br>
			<!-- Thank to pop me out of that button, but now i'm done so you can close this window. -->
			<?php
			$db = mysqli_connect("localhost","root","","authentication");
      // session_start();
			$current_logger = $_SESSION['emailid'];

			$sql = "SELECT* from users where emailid = '$current_logger'";
			$result = mysqli_query($db,$sql);
			$row = $result->fetch_assoc();
			$name = $row['username'];
			$phone = $row['phonenumber'];
			$email = $row['emailid'];
			echo 'Name : '.$name.'<br>';
			echo 'Phone Number : '.$phone.'<br>';
			echo 'Email Id : '.$email.'<br>';
			?>

		</div>
	</div>
</div>


</body>
</html>