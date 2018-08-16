
<!DOCTYPE html>
<html>
<head>
	<title>Seller Notification</title>
	<link rel="stylesheet" type="text/css" href="notification.css">
		<link rel="stylesheet" type="text/css" href="profile.css">

</head>
<body>
	<header>
		<nav>
			<h1>PriceHero</h1>
			<ul id="nav"> 
				<li> <a class = "homeblack" href="post items.php">Post Items</a></li>
                <li> <a class="homered" id="noti" href="seller notification.php"> Notification<div style = "
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
		</a></li>				<li> <a class="homeblack" href="seller about.php">About</a></li>
				<li> <a class="homeblack" href="buyer record.php"> Buyer's Info</a></li>
				<li> <a class="homeblack" href="#popup1">Profile</a> </li>
				<li> <a class="homeblack" href="index.php">Logout</a></li>
			</ul>
		</nav>
	</header>
	<!-- <div class="divider"></div> -->


	<div id="notification">
		<div class="left">

			<?php
			$db = mysqli_connect("localhost","root","","authentication");
			// session_start();
			$current_logger =$_SESSION['emailid'];
			$update = "UPDATE seller_notification set status = 'read' where productowner = '$current_logger' ";
        mysqli_query($db,$update);
			$sql = "SELECT * from seller_notification where productowner = '$current_logger' order by id";
			$result = mysqli_query($db,$sql);
			$noti_count = mysqli_num_rows($result);
			// session_start();
			// $current_logger =$_SESSION['emailid'];
			$print = "no";
			if($noti_count ==0 )
			{
					// echo "<img src='dbms images/notification.png' width='2000' height='2000' />"  ;
				// echo '<img src="dbms images/notification.png" width="2000" height="2000" />';
				?>
				<img src="notification.png" style="background-size :100%; position: center; background-color: #149576;border-radius: 50%;max-width: 100%;
				height: auto;margin-left: 500px;margin-top: 100px;">';
				<?php
				$print = "yes";
			}

			while($row = $result->fetch_assoc()){

				?>

				<div class = "right" action="seller notification.php">
					<?php
					$buyername=$row['buyername'];
					$productowner = $row['productowner'];
					$amount = $row['amount'];
					$productname = $row['productname'];
					$buyerphone = $row['buyerphone'];
					$image = $row['image'];
					$product_id = $row['product_id'];
					$buyeremail = $row['buyeremail'];
					$date = $row['c_date'];
					$str1=" wants to buy ";
					$str2 = " ";
					$str3 = "Phone Number : ";

					if($productowner != $current_logger )
					{
						if($print == "yes")
							break;
						else{
							?>
							<img src="notification.png" style="background-size :100%; position: center; background-color: #149576;border-radius: 50%;max-width: 100%;
							height: auto;margin-left: 500px;margin-top: 100px;">;
							<?php
							break;
						}
					// echo "<img src='dbms images/notification.png' width='2000' height='2000' />"  ;
							// echo '<img src="dbms images/notification.png" width="2000" height="2000" />';

					}
					else if($productowner == $current_logger){


						echo "<img src='images/".$row['image']."' >";

						echo "<p>".$row['buyername'].$str1.$row['amount'].$str2.$row['productname']."</p>";
						echo "<p>".$str3.$row['buyerphone']."</p>";
						echo "<span>".$date."</span>";
						




						echo "<form method='GET'>";
						echo "<input type='hidden' name='buyeremail' value='$buyeremail' />";
						echo "<input type='hidden' name='product_id' value='$product_id' />";
						echo "<button type='submit' name ='allow_btn'>Allow</button>";
						echo "<button type='submit' name ='deny_btn'>Deny</button>";
					// echo "<input type='hidden' name='productowner' value='$productowner'/>";


						echo "</form>";
						echo "</div>";
					}



				}



				if (isset($_GET['allow_btn'])){

					$product_id = $_GET["product_id"];
					$r_product_id = $product_id;
					$buyeremail = $_GET["buyeremail"];



					$db = mysqli_connect("localhost","root","","authentication");

					$info = "SELECT * from users where emailid = '$buyeremail'";
					$result_info = mysqli_query($db,$info);
					$row_info = $result_info->fetch_assoc();
					$buyername = $row_info['username'];
					$buyerphone = $row_info['phonenumber'];

					$sql3 = "SELECT id,amount,productname,image,buyeremail from seller_notification where product_id=$product_id and buyeremail='$buyeremail'";
					$result3 = mysqli_query($db,$sql3);

					$row3 = $result3->fetch_assoc();
					$amount = $row3['amount'];
					$productname = $row3['productname'];
					$image = $row3['image'];
					$buyeremail = $row3['buyeremail'];
					$flag = " is accepted. ";
					date_default_timezone_set('Asia/Dhaka');
					$date =  date('m/d/Y h:i:s a', time());
					$ids = $row3['id'];
					$status = "unread";


					$sql4 = "INSERT into buyer_notification (image,amount,productname,sellermail,buyeremail,c_date,flag,status) values ('$image','$amount','$productname','$current_logger','$buyeremail','$date','$flag','$status')";
					mysqli_query($db,$sql4);

					$sub_amount = "SELECT amount,product_id from seller_notification where id = '$ids'";
					$res = mysqli_query($db,$sub_amount);
					$row_amount = $res->fetch_assoc();
					$final_amount = $row_amount['amount'];
					$product_ids = $row_amount['product_id'];

					$update = "UPDATE shop_table set quantity = quantity - $final_amount where id = '$product_ids'";
					mysqli_query($db,$update);

					$from_shop = "SELECT * from shop_table where id = '$product_ids'";
					$res_shop = mysqli_query($db,$from_shop);
					$row_shop = $res_shop->fetch_assoc();

					$productname = $row_shop['productname'];
					$storename = $row_shop['storename'];
					$price = $row_shop['price'];
					$offer = $row_shop['offer'];
					$image = $row_shop['image'];
					$selleremail = $row_shop['productowner'];
       
                    $from_map = "SELECT * from map where id = '$product_ids'";
					$res_map = mysqli_query($db,$from_map);
					$row_map = $res_map->fetch_assoc();
					$location = $row_map['location'];

					$from_seller = "SELECT * from seller_notification where id = '$ids'";
					$res_seller = mysqli_query($db,$from_seller);
					$row_seller = $res_seller->fetch_assoc();
					$amount = $row_seller['amount'];
					$buyeremail = $row_seller['buyeremail'];
					$c_date = $row_seller['c_date'];
					
					$product_id = $row['product_id'];
					date_default_timezone_set('Asia/Dhaka');
					$deadline = date('m/d/Y  h:i:s a',strtotime('+3 hour',strtotime($c_date)));

					$cart ="INSERT into cart_table(image,productname,storename,location,price,amount,offer,deadline,buyeremail,c_date,product_id)values('$image','$productname','$storename','$location','$price','$amount','$offer','$deadline','$buyeremail','$c_date','$r_product_id')";
					mysqli_query($db,$cart);

					$record = "INSERT into buyer_record(buyername,buyerphone,buyeremail,productname,image,product_id,amount,deadline,selleremail) values ('$buyername','$buyerphone','$buyeremail','$productname','$image','$r_product_id','$amount','$deadline','$selleremail')";
					mysqli_query($db,$record);



					$delete_notification = "DELETE FROM seller_notification where id = $ids";
					mysqli_query($db,$delete_notification);

				}

				if (isset($_GET['deny_btn'])){

					$product_id = $_GET["product_id"];
					$buyeremail = $_GET["buyeremail"];


					$db = mysqli_connect("localhost","root","","authentication");

					$sql3 = "SELECT id,amount,productname,image,buyeremail from seller_notification where product_id=$product_id and buyeremail='$buyeremail'";
					$result3 = mysqli_query($db,$sql3);

					$row3 = $result3->fetch_assoc();
					$amount = $row3['amount'];
					$productname = $row3['productname'];
					$image = $row3['image'];
					$buyeremail = $row3['buyeremail'];
					$flag = " is rejected. ";
					date_default_timezone_set('Asia/Dhaka');
					$date =  date('m/d/Y    h:i:s a', time());
					
					$ids = $row3['id'];
					$status = "unread";
					$delete_notification = "DELETE FROM seller_notification where id = $ids";
					mysqli_query($db,$delete_notification);

					$sql4 = "INSERT into buyer_notification (image,amount,productname,sellermail,buyeremail,c_date,flag,status) values ('$image','$amount','$productname','$current_logger','$buyeremail','$date','$flag','$status')";
					mysqli_query($db,$sql4);


				}

				?>   

			</div>

		</div>
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