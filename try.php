<?php
// if($_GET['q'] == 'Search...'){
// 	header('Location: professional.php');
// }

if($_GET['q'] !== ''){
$con=mysql_connect('localhost','root','');
$db=mysql_select_db('authentication');
?>

<!DOCTYPE html>
<html>
<head>
	<title>Professional</title>
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
	<form action="professional.php" method="GET" id="searchForm" />
		<input type="text" name="q" id="searchBox" placeholder="" value="Search..." maxlength="25" autocomplete="off" onmousedown="active();" onblur="inactive();" />
	<input type="submit" id="searchBtn" value="GO!" />
	</form>
	

	<?php
	// if(!isset($q)){
	// 	echo '';
	// }else{
    $query=mysql_query("SELECT productname,category,image from product_table where productname like '%$q%' or category like '%$q%' ");
    $num_rows =mysql_num_rows($query);
    ?>
    <!-- <p><strong><?php echo $num_rows; ?></strong>results for '<?php echo $q; ?>'</p> -->
    <?php
    while($row = mysql_fetch_array($query)){
    	$productname= $row['productname'];
    	$category=$row['category'];
    	$image=$row['image'];

        echo "<img src='images/".$row['image']."' >";
    	echo $category.'   '.$productname;

    }
}

	?>

</body>
</html>

<?php
// }else{
// 	header('Location: professional.php');
 
?>