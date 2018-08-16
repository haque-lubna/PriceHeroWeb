<!-- <?php

if($_POST['q'] == 'Search...'){
	header('Location: again.php');
}
if($_POST['q'] !== ''){
$con = mysql_connect('localhost','root','');
$db = mysql_select_db('authentication');
?> -->

<!DOCTYPE html>
<html>
<head>
	<title>Search</title>
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
	<form action="again.php" method="post" id="searchForm" />
		<input type="text" name="q" id="searchBox" placeholder="" value="Search..." maxlength="25" autocomplete="off" onmousedown="active();" onblur="inactive();" />
		<input type="submit" name="search_btn" id="searchBtn" value="GO!" />

	</form>
	<?php

	if(!isset($_POST['search_btn'])){
		echo '';
	} else {
		$q=$_POST['q'];
		$db = mysqli_connect("localhost","root","","authentication");
	$query =mysqli_query($db,"SELECT * from product_table where productname like '%$q%'");
	
	$num_rows = mysqli_num_rows($query);
	?>
	<p><strong><?php echo $num_rows; ?></strong> results for '<?php echo $q; ?>'</p>
	<?php

	while($row = mysqli_fetch_array($query)){
		$productname= $row['productname'];
		$category = $row['category'];
		$image=$row['image'];

		// echo $category;
		// echo '     ';
		echo $productname;
		echo '<br>';
		echo "<img src='images/".$row['image']."'>";
	}
}
	?>

</body>
</html>

<?php
} else {
	header('Location : again.php');
}
?>