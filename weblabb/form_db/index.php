<?php
$connect=mysqli_connect("localhost","root","");
$sql="CREATE DATABASE if not exists items";
if($connect->query($sql) === TRUE) {
//	echo "Database created Sucessfully";	
} else {
		echo "Error creating database: " .$connect->error;
}
$connect=mysqli_connect("localhost","root","","items");
$sql="CREATE TABLE IF NOT EXISTS `tbl_product`(
`name` varchar(255)UNIQUE NOT NULL,
`quantity` int(6)NOT NULL,
`price`double(10,2)NOT NULL
) ";
if($connect->query($sql) === TRUE) {
//	echo "Table tbl_product created Successfully";
} else {
		echo "Error creating table: ". $connect->error;
}
if(isset($_POST["add_to_table"]))	{
		$name = $_POST["name"];
		$quantity = intval($_POST["quantity"]);
		$rate = intval($_POST["rate"]);
		$sql = "INSERT INTO `tbl_product` (`name`,`quantity`,`price`) VALUES ('".$name ."'," . $quantity . "," . $rate .")";
//		echo $sql;
		if ($connect->query($sql) === TRUE) {
		echo "New record created Successfully";
		} else {
		echo "Error: " .$sql . "<br>" .$connect->error;
		}
}	 	
if(isset($_GET["delete"]))     {
		$item_name=$_GET["item_name"];
$delete=$_GET["delete"];
		if($_GET["delete"] == 1)    {
$sql="DELETE FROM tbl_product WHERE name='".$item_name
		."'";
		if($connect->query($sql) === TRUE) {
		       echo "Record deleted Successfully";
        } else {
		         echo "Error deleting record; " .$connect->error;
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head><title>Edwin Daya</title></head>
<boby>
<br />
<div class="container" style="width:700px;">
<h3 align="center">Simple Item Table</h3><br />
<form method="post" action="index.php">
<?php
	$sql ="SELECT * FROM tbl_product";
	$result = $connect->query($sql);
	?>
<div style="clear:both"></div>
<br />
<h3>Items</h3>
<div class="table-responsive">
<table class="table table-bordered" border=3 >
<tr>
<th width="10%" style="text-align:center">S No</th>
<th width="30%" style="text-align:center">Item Name</th>
<th width="20%" style="text-align:center">Quantity</th>
<th width="20%" style="text-align:center">Price -Rs</th>
<th width="20%"></th>
</tr>
<?php if ($result->num_rows> 0) {
	$actual_link    =   "http://
	$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$ii=1;
	while($row = $result->fetch_assoc()) { ?>
	
<tr>
<td><?php echo $ii++; $ii; ?></td>
<td><?php echo $row["name"]; ?></td>
<td style="text-align:center"><?php echo $row["quantity"];?></td>
<td style="text-align:right"><?php echo $row["price"]; ?></td>
<td style="text-align:center"><a href="<?php echo $actual_link;
	?>?delete=1&item_name=<?php echo $row['name']; ?>">Delete</a></td>
</tr>
<?php }
	   }     ?>
<tr><td>&nbsp;</td><td><input type="text" name="name" /></
	td>
<td><input type="text" name="quantity" style="width:100px"	/
	></td>
<td><input type="text" name="rate" value="0" style="width:150px;
	text-align:right" /></td><td>
<input type="submit" name="add_to_table" value="Add to Table" /
	>
	
</td></tr>	
</table>
</div>
</form>
</div>
</body>
</html>