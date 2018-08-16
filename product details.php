<?php
$db = mysqli_connect("localhost", "root", "", "authentication");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Products</title>
	<link rel="stylesheet" type="text/css" href="home.css">
	<link rel="stylesheet" type="text/css" href="profile.css">
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
<body>
	<header>
		<nav>
			<h1>PriceHero</h1>
			<ul id="nav"> 
				<li> <a class = "homered" href="homepage.php">Home</a></li>
				<li> <a class="homeblack" href="buyer cart.php">Cart</a></li>
				<li> <a class="homeblack" href="buyer notification.php">Notification</a></li>
				<li> <a class="homeblack" href="buyer about.php">About</a></li>
						<li> <a class="homeblack" id="pop" href="#popup1">Profile</a> </li>
				<li> <a class="homeblack" href="index.php">Logout</a></li>
			</ul>
			<form action="product details.php" class = "search-form" method="post" id="searchForm" />
			<input type="text" name="q" id="searchBox" placeholder="" value="Search..." maxlength="25" autocomplete="off" onmousedown="active();" onblur="inactive();" />
			<button type="submit" name="search_btn" id="searchBtn" formaction="#">GO!</button>

		</form>
	</nav>
</header>


<!-- <div class="divider"></div> -->


<div class="container">
<div id="heading-block">
		<h2>Products...</h2>
	</div>
</div>


<div class="categories">
	<div class="form">
		<form class="homepage_form" method="post" action="product details.php">

			<?php
			$db = mysqli_connect("localhost", "root", "", "authentication");
            // echo $_GET['text'];
//             session_start();
//             $logedInUsername = $_SESSION['username'];
// echo $logedInUsername;


$str =(string) $_GET['text'];
        				
			if(!isset($_POST['search_btn'])){
				// $str=(string)$_GET['text'];
             //echo $str;
				
				// <input type="hidden" name="cat" value="$str">
			
				

				$sql="SELECT productname,image,category FROM product_table  where category='$str' group by productname";
				$result = mysqli_query($db, $sql);
			if($result === FALSE) { 
				echo 'die';
             die(mysql_error()); // TODO: better error handling
        }


				while ($row = mysqli_fetch_array($result)) {
					?>

					<a href="shop_details.php?text=<?php echo $row['productname'] ?>">
						<div class = "catbox">
							<?php
							$category = $row['category'];

							echo "<img src='images/".$row['image']."' >";
							echo "<span>".$row['productname']."</span>";
							// echo " <form method= 'POST'>";
       //                      echo "<input type = 'hidden' name= 'category' value='".$row['category']."'/>";
       //                      echo "</form>";

							echo "</div>";

							echo "</a>";
						}  	

					}


					else if(isset($_POST['search_btn'])){
	               // $str=(string)$_GET['text'];
						// $cat = (string) $_POST['cat'];


						$q=$_POST['q'];      
						

                       
						$query =mysqli_query($db,"SELECT * from product_table where productname like '%$q%' and category='$str' group by productname");

						$num_rows = mysqli_num_rows($query);
						echo "<p>".$num_rows."  results for  "."'$q'"."</p>";
						// echo "<p>".$num_rows.'  results for '.'$q'."</p>";
						?>

						<?php



						while($row = mysqli_fetch_array($query)){

							?>


							<a href="shop_details.php?text=<?php echo $row['productname'] ?>">
								<div class = "catbox">


									<?php

									$productname= $row['productname'];
		// $category = $row['category'];
									$image=$row['image'];



// 		echo $productname;
// 		echo '<br>';
// 		echo "<img src='images/".$row['image']."'>";
// 	}
// }


									echo "<img src='images/".$row['image']."' >";
									echo "<span>".$row['productname']."</span>";



									echo "</div>";

									echo "</a>";
								}  	

							}

// echo $_GET['text'];



							?>   

 <!-- <?php
     
 ?> -->
 
<div id="popup1" class="overlay">
<div class="popup">
    <h2>Your Profile</h2>
    <a class="close" href="#">&times;</a>
    <div class="content">
      <img src="profile.png" style="height: 100px;width: 100px; margin-left: 40px;margin-bottom: 20px;"><br>
      <!-- Thank to pop me out of that button, but now i'm done so you can close this window. -->
      <?php
      $db = mysqli_connect("localhost","root","","authentication");
      session_start();
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