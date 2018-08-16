<?php
	$conn=mysqli_connect("localhost","root","","authentication")or die("Connection failed");
if(isset($_POST['search_btn'])){
$search=$_POST['search'];
$search=mysql_real_escape_string($search);
$sql="SELECT * FROM product_table WHERE productname LIKE '%$search%'";
$result=mysqli_query($conn,$sql) or die("Query failed");
$row=mysqli_fetch_array($result);
if($row['productname']==$search){
	while($row){
		?>
		<?php
		$productname= $row['productname'];
		$category = $row['category'];
		$image=$row['image'];

		echo $category;
		echo '     ';
		echo $productname;
		echo '<br>';
		// echo "<img src='images/".$row['image']."'>";
	}
}
}
mysqli_close($conn);
?>