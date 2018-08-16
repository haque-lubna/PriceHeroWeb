

<!DOCTYPE html>
<html>
<head>
	<title>Buyer Notification</title>
	<link rel="stylesheet" type="text/css" href="notification.css">
	<link rel="stylesheet" type="text/css" href="profile.css">
</head>
<header>
	<nav>
		<h1>PriceHero</h1>
		<ul id="nav"> 
			<li> <a class = "homeblack" href="homepage.php">Home</a></li>
			<li> <a class="homeblack" href="buyer cart.php">Cart</a></li>
			<li> <a class="homered" id="noti" href="buyer notification.php"> Notification<div style = "
				position: absolute;
				top: 33px;
				color: red;
				display: inline-block;">
				<?php 
				$db = mysqli_connect("localhost","root","","authentication");
				session_start();
				$current_logger = $_SESSION['emailid'];
				$unread = "SELECT * from buyer_notification where status = 'unread' and buyeremail = '$current_logger' ";
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
			<li> <a class="homeblack" href="buyer about.php">About</a></li>
					<li> <a class="homeblack" href="#popup1">Profile</a> </li>
			<li> <a class="homeblack" href="index.php">Logout</a></li>
		</ul>
		
	</nav>
</header>

<body>
	<!-- <div class="divider"></div> -->
<div id="notification">
	<div class="left">

		<?php
		$db = mysqli_connect("localhost","root","","authentication");
		// session_start();
	$current_logger = $_SESSION['emailid'];
		$update = "UPDATE buyer_notification set status = 'read' where buyeremail = '$current_logger' ";
        mysqli_query($db,$update);
		$dlt = "DELETE from buyer_notification where amount <1";
		mysqli_query($db,$dlt);

		// session_start();
		$current_logger =$_SESSION['emailid'];

		$sql = "SELECT * from buyer_notification where buyeremail = '$current_logger' order by id";
		$result = mysqli_query($db,$sql);
		$noti_count = mysqli_num_rows($result);

		// session_start();
		// $current_logger =$_SESSION['emailid'];
		$print = "no";
		
		if($noti_count === 0  )
		{
			?>
			<img src="notification.png" style="background-size :100%; position: center; background-color: #149576;border-radius: 50%;max-width: 100%;
			height: auto;margin-left: 500px;margin-top: 100px;">';
			<?php
			$print = "yes";
		}
		else{
		while($row = $result->fetch_assoc()){

			?>

			<div class = "right" action="buyer notification.php">
				<?php

				$amount = $row['amount'];
				$productname = $row['productname'];
				$buyeremail = $row['buyeremail'];
				$image = $row['image'];
				$date = $row['c_date'];
				$flag = $row['flag'];

				$str1="Your request for ";
				$str2 = " ";
				$str3 = " Collect it within next 3 hours.";
				
				if( $buyeremail != $current_logger )
				{
					if($print == "yes")
						break;
					else{
						?>
						<img src="notification.png" style="background-size :100%; position: center; background-color: #149576;border-radius: 50%;max-width: 100%;
						height: auto;margin-left: 500px;margin-top: 100px;">';
						<?php
						break;
					}
					
					
				}
				else if($current_logger == $buyeremail && $amount != 0){


					echo "<img src='images/".$row['image']."' >";

					if($flag == " is rejected. " ){
						echo "<p>".$str1.$row['amount'].$str2.$row['productname'].$flag."</p>";
						echo "<span>".$date."</span>";
						echo "</div>";
					}
					else{
						echo "<p>".$str1.$row['amount'].$str2.$row['productname'].$flag."</p>";
						echo "<p>".$str3."</p>";
						echo "<span>".$date."</span>";
						echo "</div>";
					}

					
				}


			}


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
