<?php

$db = mysql_connect("localhost","root","","authentication");
if(!isset($_POST['search'])){
	header("Location:search.php");
     
 }
     $search_sql = "SELECT productname from product_table where name like '%".$_POST['search']."%";
     $search_query=mysql_query($search_sql);
    if (mysql_num_rows($search_query)>0){
    	    $search_rs=mysql_fetch_assoc($search_query);

    }

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<p>Search result</p>
<?php if(mysql_num_rows($search_query)>0){
	do{
		?>
		<p><?php echo $search_rs['productname']; ?></p>
		<?php
	}while ($search_rs=mysql_fetch_assoc($search_query)); {
		# code...
	}
	
}
else{
		echo "No result found";
	}
	?>
</body>
</html>