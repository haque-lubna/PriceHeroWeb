<?php
$msg= "";

//if submit button pressed
if(isset($_POST['post_btn'])){
 //the path to store the upload image
   $target = "images/".basename($_FILES['image']['name']);

//connect to db
   $db = mysqli_connect("localhost","root","","authentication");


   $category = mysql_real_escape_string($_POST['category']);
   $category=strtolower($category);
   $productname = mysql_real_escape_string($_POST['productname']);
   $productname=strtolower($productname);
   $storename = mysql_real_escape_string($_POST['storename']);
   $storename=strtolower($storename);
   $price = mysql_real_escape_string($_POST['price']);
   $description = mysql_real_escape_string($_POST['description']);
   $quantity = mysql_real_escape_string($_POST['quantity']);
   $offer = mysql_real_escape_string($_POST['offer']);
   session_start();
   $productowner = $_SESSION['emailid'];


   $image = $_FILES['image']['name'];

   
   $sql = "INSERT INTO seller(category,productname,storename,price,description,quantity,offer,image) VALUES ('$category','$productname','$storename','$price','$description','$quantity','$offer','$image')";
   mysqli_query($db,$sql);

   $sql2="INSERT INTO category_table(category,image) VALUES ('$category','$image')";
   mysqli_query($db,$sql2);

   $sql4="INSERT INTO shop_table(productname,image,description,storename,price,quantity,offer,productowner) VALUES('$productname','$image','$description','$storename','$price','$quantity','$offer','$productowner')";
   mysqli_query($db,$sql4); 

   $sql3="INSERT INTO product_table(category,productname,image,productowner) VALUES ('$category','$productname','$image','$productowner')";
   mysqli_query($db,$sql3);


   // mysqli_error('die');

   //now lets move the uploaded file into the image folder
   if (move_uploaded_file($_FILES['image']['tmp_name'],$target)){
   	$msg = "Image uploader successfully";
   }
   else{
   	$msg = "There was a problem uploading image";
   }

   header("post items.php");   

}
?>


<!DOCTYPE html>
<html>
<head>
	<title>Post Items</title>
	<link rel="stylesheet" type="text/css" href="homepage style.css">
    <link rel="stylesheet" type="text/css" href="profile.css">

    <script type ='text/javascript'>
              

      function onclicklocation(){

         document.getElementById('id').value='OK';
                  document.getElementById('id').style.background='blue';
                  return true;
        
      }    
//       function changeQuestion(answer)
//   {
// document.getElementById(answer).style.background = 'white';
//   }    

   </script>
</head>
<body style="background-image: linear-gradient(rgba(0,0,0,0.6),rgba(0,0,0,0.6)),url(postd.jpg); width: 100%;
    background-repeat:no-repeat;
    background-size:100% 1000px; 
 ">
   <header>
     <nav>
       <h1>PriceHero</h1>
       <ul id="nav"> 
         <li> <a class = "homered" href="post items.php">Post Items</a></li>
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
        //  mysqli_query($db,$update);

        ?>
      </div>
    </a></li>         <li> <a class="homeblack" href="seller about.php">About</a></li>
         <li> <a class="homeblack" href="buyer record.php"> Buyer's Info</a></li>
        <li> <a class="homeblack" href="#popup1">Profile</a> </li>
         <li> <a class="homeblack" href="index.php">Logout</a></li>
      </ul>
   </nav>
</header>

<!-- <div class="divider"></div> -->
<div class="post_items_page">
   <div class="form" id="content">
      <form class="post_items_form" method="post" action="post items.php" enctype="multipart/form-data">
       <input type="text" name="category" placeholder ="Product  Category" required>
       <input type="text" name="productname" placeholder="Product's Name" required>
       <input type="text" name="storename" placeholder="Store's Name" required>

       <input type="text" name="price" placeholder ="Price" required>
       <input type="text" name="description" placeholder="Description" required>
       <input type="text" name="quantity" placeholder="Quantity" required>
       <input type="text" name="offer" placeholder="Offers" required>
       <input type="hidden" name="size" value="1000000" required>
       <div>
         <input type="file" name="image"  required>
      </div>
<form>
      <button type="submit" name="location_btn"  formaction="micro map.php" id="id" value="location" >add location</button>
      <?php
       if(isset($_GET['location_btn']))
           {
               // echo "<input type=text name=txt_userinput />";
            echo "<p>".'location added'."<p>";
           }
      ?>
      <button type="submit" name="post_btn" >Submit</button>

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
   </form>

</div>
</div>

</body>
</html>