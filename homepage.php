<?php
$db = mysqli_connect("localhost", "root", "", "authentication");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Buyer homepage</title>
	<link rel="stylesheet" type="text/css" href="home.css">
	<link rel="stylesheet" type="text/css" href="profile.css">
</head>
<body>

	<header>
		<nav>
			<h1>PriceHero</h1>
			<ul id="nav"> 
				<li> <a class = "homered" id="home" href="homepage.php"> Home</a></li>
				<li> <a class="homeblack" id="cart" href="buyer cart.php"> Cart</a></li>
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
		<li> <a class="homeblack" id="about" href="buyer about.php">About</a></li>
		<li> <a class="homeblack" id="pop" href="#popup1">Profile</a> </li>
		<li> <a class="homeblack" id="logout" href="index.php">Logout</a></li>
	</ul>
	
	<form class="search-form" method="post">
		<input type="text" name="q" placeholder="Search">
		<button type="submit" name="search_btn">GO!</button>
	</form>
</nav>
</header>
<!-- <div class="divider"></div> -->





<!-- <?php
    if(isset($_SESSION['message'])){
   echo "<div id='error_msg'>".$_SESSION['message']."</div>";
   unset($_SESSION['message']);
}
?> -->
<div class="container">
	<div id="heading-block">
		<h2>Categories...</h2>
	</div>
</div>

<div class="categories">
	
	<div class = "form">

		<form class="homepage_form" method="post" action="homepage.php">


			<?php
			if(!isset($_POST['search_btn'])){
				$db = mysqli_connect("localhost", "root", "", "authentication");
				$sql="SELECT image, category FROM category_table group by category order by category desc";
				$result = mysqli_query($db, $sql);
				while ($row = mysqli_fetch_array($result)) {
					?>


					<a href="product details.php?text=<?php echo $row['category'] ?>" >
						<div class = "catbox">
							<?php
							echo "<img src='images/".$row['image']."' >";
							echo "<span>".$row['category']."</span>";

							echo "</div>";

							echo "</a>";
						}  	
					}
					else{
						$q=$_POST['q'];


						$query =mysqli_query($db,"SELECT * from category_table where category like '%$q%'  group by category");

						$num_rows = mysqli_num_rows($query);
						echo "<p>".$num_rows."  results for  "."'$q'"."</p>";
						// echo "<p>".$num_rows.'  results for '.'$q'."</p>";
						?>

						<?php



						while($row = mysqli_fetch_array($query)){

							?>


							<a href="product details.php?text=<?php echo $row['category'] ?>">
								<div class = "catbox">


									<?php

									$category= $row['category'];
		// $category = $row['category'];
									$image=$row['image'];



// 		echo $productname;
// 		echo '<br>';
// 		echo "<img src='images/".$row['image']."'>";
// 	}
// }


									echo "<img src='images/".$row['image']."' >";
									echo "<span>".$row['category']."</span>";



									echo "</div>";

									echo "</a>";
								}  	

							}


							?>   


						</form>
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
					</div>
				</div>


			</body>
			</html>