<?php

 // Book Button active

if (isset($_GET['book_btn']) ){
  $db = mysqli_connect("localhost","root","","authentication");
  session_start();
  $buyeremail = $_SESSION['emailid'];

  $sql2 = "SELECT username,phonenumber from users where emailid='$buyeremail'";
  $result2 = mysqli_query($db,$sql2);
  $row2 = $result2->fetch_assoc();

  $buyername = $row2['username'];
  $buyerphone = $row2['phonenumber'];



  $amount = mysql_real_escape_string($_GET['amount']);

  $id= $_GET['id'];

  $sql3 = "SELECT productname,image,productowner,quantity from shop_table where id='$id'";
  $result3 = mysqli_query($db,$sql3);
  while ($row3 = $result3->fetch_assoc()){
   ?>
   <?php
   $productname =$row3['productname'];
   $image = $row3['image'];
   $productowner = $row3['productowner'];
   $quantity = $row3['quantity'];
 }
 date_default_timezone_set('Asia/Dhaka');
 $date =  date('m/d/Y h:i:s a', time());

 if($amount > $quantity){
   echo '<script language="javascript">';
   echo 'alert("Sorry.The amount is invalid")';
   echo '</script>';
 }
 $status = "unread";
 $sql1 = "INSERT into seller_notification (buyername,buyerphone,buyeremail,amount,productname,image,productowner,c_date, product_id,status)
 values ('$buyername','$buyerphone','$buyeremail','$amount','$productname','$image','$productowner','$date', '$id','$status') ";
 mysqli_query($db,$sql1);

}


?>

<!DOCTYPE html>
<html>
<head>
  <title>Shop Details</title>
  
    <!-- <script type="text/javascript">
function fun()
{
    document.write("<input type='text' name='text' >");
    return false;
}
</script> -->


<!--  <script type ='text/javascript'>
            

    function onclickbooknow(x){
      document.write('<input type='text' name='text' >');

         document.getElementById(x).value='OK';
                  document.getElementById(x).style.background='blue';
          return false;

    }     

  </script> -->
  <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&v=3&libraries=geometry"></script>

  <link rel="stylesheet" type="text/css" href="shop.css">
  <link rel="stylesheet" type="text/css" href="profile.css">
</head>
<body>

 <!-- Header -->
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

   <!-- SORT -->

   <!-- <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST"> -->
    <form action="shop_details.php" method="POST">
      <input type="submit" name="submit" value="GO!" formaction="#" style="height: 30px; width: 40px; margin-top: 15px; background: orange;color : white;float: right;margin-left: 0px;margin-right: 10px;border-radius: 0 5px 5px 0;border: none;cursor: pointer;">

      <select id="sort" name="sort" role="button" style="height: 30px; width: 200px; margin-top: 15px; background: white;color : orange;float: right;margin-right: 0px;">
        <option value="sort_by_price"  selected ="selected">Sort By Price</option>
        <option value="sort_by_location" >Sort By Location</option>
      </select>
    </form>

  </nav>
</header>

<!-- <div class="divider"></div> -->
<?php
// Button click of sort by
if($_POST){
  // if click GO button
  if(isset($_POST['sort'])) {
    // if option is sort by price
    if($_POST['sort']=='sort_by_price') {
      echo '<p>You have selected: <strong>', $_POST['sort'], '</strong>.</p>';

      ?>
      <div id="shop">
        <div class="left">
         <?php

         $db = mysqli_connect("localhost", "root", "", "authentication");

      // echo $_GET['text'];
         $str=(string)$_GET['text'];
     // echo $str;
         $sql="SELECT id,image,description,storename,price,quantity,offer from shop_table where productname='$str' group by storename order by price  desc";
         $result = mysqli_query($db, $sql);

   // when query returns null
         if($result === FALSE) { 
          echo 'die';
             die(mysql_error()); // TODO: better error handling
           }
           // when query returns true
           while ($row = mysqli_fetch_array($result)) {
             ?>

             <div class = "right" action="shop_details.php">
               <?php
               $str1="Store's Name :  ";
               $str2="location :  ";
               $str3="Description :  ";
               $str4="Price :  ";
               $str5="Quantity :  ";
               $str6="Offer :  ";

               $id=$row['id'];
               $sql2 = "SELECT * from map where id=$id";
               $result2 = mysqli_query($db,$sql2);
               $row2 =$result2-> fetch_assoc();
               $location = $row2['location'];
               $lat = $row2['place_Lat'];
               $lng = $row2['place_Lng'];
               

       // print products sort by price
               echo "<img src='images/".$row['image']."' >";
        //echo "<p>". $strstore."</p>";
               echo "<p>".$str1.$row['storename']."</p>";
               echo "<p>".$str2.$location."</p>";
               echo "<p>".$str3.$row['description']."</p>";
               echo "<p>".$str4.$row['price']."</p>";
               echo "<p>".$str5.$row['quantity']."</p>";
               echo "<p>".$str6.$row['offer']."</p>";
               echo "<form method='GET'>";
               echo "<input type='hidden' name='text' value='".$_GET['text']."' />";
               echo "<input type='hidden' name='id' value='".$row['id']."' />";
               echo "<input type='text' name='amount' placeholder='Enter the quantity if you want to buy this product.' required>" ;
        // // echo "<input type='button' value='Book Now' id='".$row['id']."'  onclick='onclickbooknow(".$row['id'].")'/>";
               echo "<button type='submit' name ='book_btn'>Book Now</button>";

               echo "</form>";
         // echo '<button  type="button"  class="btn btn-primary" <a href="#" onclick="fun()" </a>>Click Me</button>';
       // echo '<button type="button" class="btn btn-primary" id="check" onclick="fun("check")" >Click Me</button>';
               echo "</div>";

             }

  // echo $_GET['amount']; 
// echo $_GET['text'];
             ?>   

    <!-- <input type="text" name="amount" placeholder="Enter the quantity if you want to buy this product" required>
      <button type="button" name ="book_btn"><a href="seller notification.php?text=<?php echo $amount ?>" >Book Now</button> -->
      </div>

    </div>
    <?php
    } //ends of sort by price
    

// if select sort by location



    else if ($_POST['sort']=='sort_by_location'){  
     echo '<p>You have selected: <strong>', $_POST['sort'],  '</strong>.</p>';
     ?>

     <script type="text/javascript">


        // Buyers current location
        function getLocation() {
          if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);

          } else {
            x.innerHTML = "Geolocation is not supported by this browser.";
          }

        }
        getLocation();
        // find out distance
        function showPosition(position) {
              // convert latlng php to javascript 
              var lat = "<?php echo $lat ?>";
              var lng = "<?php echo $lng ?>";
              
          // var currentLatLng=new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
           // document.writeln(check);
          // return currentLatLng;

          var distance =  google.maps.geometry.spherical.computeDistanceBetween(new google.maps.LatLng(position.coords.latitude, position.coords.longitude), new google.maps.LatLng(lat,lng))/1000;  

          


          var dis_id = {dist:distance,s_id:shop_id};
          
          array.push(dis_id);
          
          a++;

        }
        sorted();


        function sorted(){
          for (var i = 0; i <array.length-1; i++) {
            for (var j = i+1; j < array.length; j++) {
              if(array[i].dist>array[j].dist){
                var a=array[i],b=array[j];
                array[i]=b;
                array[j]=a;
              }
            }
          }
        }


      </script> 

      <div id="shop">
        <div class="left">
         <?php

         $db = mysqli_connect("localhost", "root", "", "authentication");

      // echo $_GET['text'];
         $str=(string)$_GET['text'];
     // echo $str;
         $sql="SELECT id,image,description,storename,price,quantity,offer from shop_table where productname='$str' group by storename order by id desc ";
         $result = mysqli_query($db, $sql);

   // when query returns null
         if($result === FALSE) { 
          echo 'die';
             die(mysql_error()); // TODO: better error handling
           }
           // when query returns true
           while ($row = mysqli_fetch_array($result)) {
             ?>

             <div class = "right" action="shop_details.php">
               <?php
               $str1="Store's Name :  ";
               $str2="location :  ";
               $str3="Description :  ";
               $str4="Price :  ";
               $str5="Quantity :  ";
               $str6="Offer :  ";

               $id=$row['id'];
               $sql2 = "SELECT * from map where id=$id";
               $result2 = mysqli_query($db,$sql2);
               $row2 =$result2-> fetch_assoc();
               $location = $row2['location'];
               $lat = $row2['place_Lat'];
               $lng = $row2['place_Lng'];

               ?>



               <?php
               

       // print products sort by price
               echo "<img src='images/".$row['image']."' >";
        //echo "<p>". $strstore."</p>";
               echo "<p>".$str1.$row['storename']."</p>";
               echo "<p>".$str2.$location."</p>";
               echo "<p>".$str3.$row['description']."</p>";
               echo "<p>".$str4.$row['price']."</p>";
               echo "<p>".$str5.$row['quantity']."</p>";
               echo "<p>".$str6.$row['offer']."</p>";
               echo "<form method='GET'>";
               echo "<input type='hidden' name='text' value='".$_GET['text']."' />";
               echo "<input type='hidden' name='id' value='".$row['id']."' />";
               echo "<input type='text' name='amount' placeholder='Enter the quantity if you want to buy this product.' required>" ;
        // // echo "<input type='button' value='Book Now' id='".$row['id']."'  onclick='onclickbooknow(".$row['id'].")'/>";
               echo "<button type='submit' name ='book_btn'>Book Now</button>";

               echo "</form>";
         // echo '<button  type="button"  class="btn btn-primary" <a href="#" onclick="fun()" </a>>Click Me</button>';
       // echo '<button type="button" class="btn btn-primary" id="check" onclick="fun("check")" >Click Me</button>';
               echo "</div>";

             }

  // echo $_GET['amount']; 
// echo $_GET['text'];
             ?>   

    <!-- <input type="text" name="amount" placeholder="Enter the quantity if you want to buy this product" required>
      <button type="button" name ="book_btn"><a href="seller notification.php?text=<?php echo $amount ?>" >Book Now</button> -->
      </div>

    </div>
    <?php

    } //end of sort by location
  }  // end of isset sort
} //end of click GO button

// when the GO button is not clicked
else{
  echo '<p>You have selected: <strong>'.'sort_by_price'.'</strong>.</p>';
  ?>
  <div id="shop">
    <div class="left">
     <?php

     $db = mysqli_connect("localhost", "root", "", "authentication");

      // echo $_GET['text'];
     $str=(string)$_GET['text'];
     // echo $str;
     $sql="SELECT id,image,description,storename,price,quantity,offer from shop_table where productname='$str' group by storename order by price  desc";
     $result = mysqli_query($db, $sql);

   // when query returns null
     if($result === FALSE) { 
      echo 'die';
             die(mysql_error()); // TODO: better error handling
           }


   //store latlang of products and call findDistance for every product location
           while ($row = mysqli_fetch_array($result)) {
             ?>

             <div class = "right" action="shop_details.php">
               <?php
               $str1="Store's Name :  ";
               $str2="location :  ";
               $str3="Description :  ";
               $str4="Price :  ";
               $str5="Quantity :  ";
               $str6="Offer :  ";

               $id=$row['id'];
               $sql2 = "SELECT * from map where id=$id";
               $result2 = mysqli_query($db,$sql2);
               $row2 =$result2-> fetch_assoc();
               $location = $row2['location'];
               $lat = $row2['place_Lat'];
               $lng = $row2['place_Lng'];
               ?>


               <!-- Find out distance between store and buyers current location -->

               <?php


       // print products sort by price
               echo "<img src='images/".$row['image']."' >";
        //echo "<p>". $strstore."</p>";
               echo "<p>".$str1.$row['storename']."</p>";
               echo "<p>".$str2.$location."</p>";
               echo "<p>".$str3.$row['description']."</p>";
               echo "<p>".$str4.$row['price']."</p>";
               echo "<p>".$str5.$row['quantity']."</p>";
               echo "<p>".$str6.$row['offer']."</p>";
               echo "<form method='GET'>";
               echo "<input type='hidden' name='text' value='".$_GET['text']."' />";
               echo "<input type='hidden' name='id' value='".$row['id']."' />";
               echo "<input type='text' name='amount' placeholder='Enter the quantity if you want to buy this product.' required>" ;
        // // echo "<input type='button' value='Book Now' id='".$row['id']."'  onclick='onclickbooknow(".$row['id'].")'/>";
               echo "<button type='submit' name ='book_btn'>Book Now</button>";

               echo "</form>";
         // echo '<button  type="button"  class="btn btn-primary" <a href="#" onclick="fun()" </a>>Click Me</button>';
       // echo '<button type="button" class="btn btn-primary" id="check" onclick="fun("check")" >Click Me</button>';
               echo "</div>";

             }

  // echo $_GET['amount']; 
// echo $_GET['text'];
             ?>   

    <!-- <input type="text" name="amount" placeholder="Enter the quantity if you want to buy this product" required>
      <button type="button" name ="book_btn"><a href="seller notification.php?text=<?php echo $amount ?>" >Book Now</button> -->
      </div>

    </div>
    <?php
} //end of without click GO button
?>
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