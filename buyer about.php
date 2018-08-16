<!DOCTYPE html>
<html>
<head>
	<title>About PriceHero</title>
	<link rel="stylesheet" type="text/css" href="homepage style.css">
	<link rel="stylesheet" type="text/css" href="profile.css">
</head>
<body style="background-image: linear-gradient(rgba(0,0,0,0.6),rgba(0,0,0,0.6)),url(background.jpg); width: 100%;
    background-repeat:no-repeat;
    background-size:100% 1000px; 
 ">
<header>
	<nav>
		<h1>PriceHero</h1>
		<ul id="nav"> 
			<li> <a class = "homeblack" href="homepage.php">Home</a></li>
			<li> <a class="homeblack" href="buyer cart.php">Cart</a></li>
			<li> <a class="homeblack" id="noti" href="buyer notification.php"> Notification<div style = "
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
			<li> <a class="homered" href="buyer about.php">About</a></li>
					<li> <a class="homeblack" href="#popup1">Profile</a> </li>
			<li> <a class="homeblack" href="index.php">Logout</a></li>
		</ul>
	</nav>
</header>
<!-- <div class="divider"></div> -->


 <div class="about_page">
   <div class="form">
   	<img src="logo.png" style="display: block;margin-left: auto; margin-right: auto; margin-bottom: 0px; width: 200px;height: 200px;">
<form class="about_form" method="post" action="buyer about.html">
	<P  class="message">
		For Buyers: <br> A buyer can find the cheapest and quality local deals of his necessary grocery items through this app. You can also  find the nearest shops.  This app informs about any current offers going on in any shop. Get information about the available stock of your desired product in various shops.Buyer have to collect his product within the given time of  seller.<br><br><br> For Sellers:<br>A seller can sell any product through this app.Just post your product with detail informations and pictures!
</P>
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
				

</form>
</div>
</div>





</body>
</html>