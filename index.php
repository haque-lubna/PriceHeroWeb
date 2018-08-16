<?php
session_start();
$db = mysqli_connect("localhost","root","","authentication");

if(isset($_POST['register_btn'])){
 session_start();
 $username = mysql_real_escape_string($_POST['username']);
 $emailid = mysql_real_escape_string($_POST['emailid']);
 $phonenumber = mysql_real_escape_string($_POST['phonenumber']);
 $password = mysql_real_escape_string($_POST['password']);

 $sql = "INSERT INTO users(username,emailid,phonenumber,password) VALUES ('$username','$emailid','$phonenumber','$password')";
 mysqli_query($db,$sql);

 header("location:index.php");   

}
?>

<?php

$db = mysqli_connect("localhost","root","","authentication");



if(isset($_POST['login_btn'])){

  if(isset($_POST['select'])){
   $select = $_POST['select'];

 }
 else{
   $select = NULL;
 }
 if($select != NULL){
   if($select =='Buyer'){
    $emailid = mysql_real_escape_string($_POST['emailid']);
    $password = mysql_real_escape_string($_POST['password']);

    $sql = "SELECT * FROM users WHERE emailid='$emailid' AND password = '$password'";
    $result = mysqli_query($db,$sql);

    if(mysqli_num_rows($result) ==1){

      $_SESSION['emailid'] = $emailid;
      header("location:homepage.php");

    } 
    else{

      $_SESSION['message'] = "Emailid/Password combination incorrect";
    }
  }
  if($select =='Seller'){
   $emailid = mysql_real_escape_string($_POST['emailid']);
   $password = mysql_real_escape_string($_POST['password']);

   $sql = "SELECT * FROM users WHERE emailid='$emailid' AND password = '$password'";
   $result = mysqli_query($db,$sql);

   if(mysqli_num_rows($result) ==1){

     $_SESSION['emailid'] = $emailid;
     header("location:post items.php");

   } 
   else{

     $_SESSION['message'] = "Emailid/Password combination incorrect";
   }
 }

}
else{
 $_SESSION['message'] = "You must specify are you a buyer  or a seller";

}


}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login & registration</title>
	<link rel="stylesheet" type="text/css" href="style.css">
  <style>
   @import url('https://fonts.googleapis.com/css?family=Pacifico');
   @import url('https://fonts.googleapis.com/css?family=Bree+Serif');
     #we{top: 10%;position: absolute;left: -50;font-size: 30px;font-family: Bree Sarif; margin-top: 0px;}
      #we:nth-child(1){
        color:white;
        animation: move 2s infinite cubic-bezier(.2,.64,.81,.23);

      }
      #we:nth-child(2){
        color:blue;
        animation: move 2s 100ms infinite cubic-bezier(.2,.64,.81,.23);

      }
      #we:nth-child(3){
        color:#62C90D;
        animation: move 2s 200ms  infinite cubic-bezier(.2,.64,.81,.23);

      }
     
      #we:nth-child(4){
        color:white;
        animation: move 2s 300ms infinite cubic-bezier(.2,.64,.81,.23);

      }
      #we:nth-child(5){
        color:blue;
        animation: move 2s 400ms infinite cubic-bezier(.2,.64,.81,.23);

      }
      #we:nth-child(6){
        color:#62C90D;
        animation: move 2s 500ms  infinite cubic-bezier(.2,.64,.81,.23);

      }
       #we:nth-child(7){
        color:white;
        animation: move 2s 600ms infinite cubic-bezier(.2,.64,.81,.23);

      }
      #we:nth-child(8){
        color:blue;
        animation: move 2s 700ms infinite cubic-bezier(.2,.64,.81,.23);

      }
      #we:nth-child(9){
        color:#62C90D;
        animation: move 2s 800ms  infinite cubic-bezier(.2,.64,.81,.23);

      }
      @keyframes move{
        0%{left:100%;}
        100%{left: 0;}
      }
   </style>
</head>

<body style="background-image: linear-gradient(rgba(0,0,0,0.6),rgba(0,0,0,0.6)),url(background.jpg); width: 100%;
    background-repeat:no-repeat;
    background-size:100% 1000px; 
 ">
 <div id="we">P</div>
 <div id="we">R</div>
 <div id="we">I</div>
 <div id="we">C</div>
 <div id="we">E</div>
 <div id="we">H</div>
 <div id="we">E</div>
 <div id="we">R</div>
 <div id="we">O</div>

 <div class="login_page">
  <div class="form">
   <img src="logo.png" style="display: block;margin-left: auto; margin-right: auto; margin-bottom: 20px; width: 200px;height: 200px;">
   <?php
   if(isset($_SESSION['message'])){
    echo "<div id='error_msg'>".$_SESSION['message']."</div>";
    unset($_SESSION['message']);
  }

  ?>

  <form class="register_form" method="post" action="index.php">

   <input type="text" name="username" placeholder ="User Name" required>
   <input type="text" name="phonenumber" placeholder="Phone Number" required>
   <input type="text" name="emailid" placeholder="Email Id" required>
   <input type="password" name="password" placeholder="Password" required>
   <button type="submit" name="register_btn">Create</button>
   <p class="message">Already registered?<a href="#">Login Here</a>

   </p>
 </form>
 <?php
 if(isset($_SESSION['message'])){
   echo "<div id='error_msg'>".$_SESSION['message']."</div>";
   unset($_SESSION['message']);
 }  	
 ?>
 <form class="login_form" method="post" action="index.php">

  <input type="text" name="emailid" placeholder="Email ID" required >
  <input type="password" name="password" placeholder="Password" required>
  <label style="color: white; margin-left :20px;">Enter as a buyer<input type="radio" style="margin-top: 0px;position: relative;top: -15px;    left: -128px;" name="select" value="Buyer"/> </label>
  
  <label style="color: white;margin-left :20px;">Enter as a seller<input type="radio" style="margin-top: 0px;position: relative;top: -15px;    left: -128px;" name="select" value="Seller" /> </label>

 <button type="submit" name="login_btn" class="btn">Login</button>

 <p class="message">Not registered? <a href="#">Register here</a>

 </p>

</form>
</div>	
</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

<script>
	$('.message a').click(function(){
    $('form').animate ({height: "toggle",opacity:"toggle"},"slow");
  });
	
</script>

</body>
</html>