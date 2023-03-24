<?php 
ob_start();
   session_start();
$connect = new mysqli("localhost", "root", ""); 
$sql = "CREATE DATABASE if not exists scart"; 
if ($connect->query($sql) === TRUE) { 
//	echo "Database created successfully"; 
} else { 
	echo "Error creating database: ". $connect ->error; 
}
$connect = new mysqli("localhost", "root", "","scart");
if ($connect->connect_error) { 
die("Connection failed: " . $connect->connect_error); 
}
$sql="CREATE TABLE IF NOT EXISTS `tbl_product` ( 
`id` int(11) NOT NULL AUTO_INCREMENT, 
`name` varchar(255) NOT NULL, 
`image` varchar(255) NOT NULL, 
`price` double(10,2) NOT NULL, 
PRIMARY KEY (`id`))"; 
if ($connect->query($sql) === TRUE) { 
//	echo "Table tbl_product created successfully"; 
} else { 
	echo "Error creating table: " . $connect->error;
}
$sql ="SELECT * FROM tbl_product";
$result = $connect->query($sql);
//print $result->num_rows;
// exit;

if ($result->num_rows == 0) {
	$sql="INSERT INTO tbl_product (name, image, 
	price) VALUES 
	('Samsung J2 Pro', '1.jpg', 100.00), 
	('HP Notebook', '2.jpg', 299.00),  
	('Panasonic T44 Lite', '3.jpg', 125.00)"; 
	if ($connect->query($sql) === TRUE) { 
		echo "New record created successfully"; 
	} else { 
		echo "Error: " . $sql . "<br>" . $connect->error;
	}
}
if(isset($_POST["add_to_cart"])) { 
if(isset($_SESSION["shopping_cart"])) { 
		$item_array_id = array_column 
				($_SESSION["shopping_cart"], "item_id"); 
if(!in_array($_GET["id"], $item_array_id)) { 
            $count = count($_SESSION["shopping_cart"]); 
            $item_array = array( 
               'item_id' => $_GET["id"], 
			   'item_name' => $_POST["hidden_name"], 
			   'item_price' => $_POST["hidden_price"], 
			   'item_quantity' => $_POST["quantity"]
			);
$_SESSION["shopping_cart"][$count] = $item_array;
	}
else { 
echo '<script>alert("Item Already Added")</script>'; 
echo '<script>window.location="index.php"</script>'; 
	}
 }
else { 
	$item_array = array( 
		'item_id' => $_GET["id"], 
		'item_name' => $_POST["hidden_name"], 
		'item_price' => $_POST["hidden_price"], 
		'item_quantity' => $_POST["quantity"] 
	);
	$_SESSION["shopping_cart"][0] = $item_array;
  }
 }
if(isset($_GET["action"])) { 
if($_GET["action"] =="delete") { 
foreach($_SESSION["shopping_cart"] as $keys => $values) 
{
if($values["item_id"] == $_GET["id"]) { 
unset($_SESSION["shopping_cart"][$keys]); 
echo '<script>alert("Item Removed")</script>'; 
echo '<script>window.location="index.php"</script>'; 
				}
			}
		}
	}
?> 

<!DOCTYPE html> 
<html> 
<head> 
<title>Edwin Daya | Shopping Cart</title> 
</head> 
<body align="center"> 
<br /> 
<div class="container" style="width:700px; margin-left:200px"> 
<h3 align="center">Simple PHP Mysql Shopping Cart</h3><br /> 
<?php 
		$query = "SELECT * FROM tbl_product ORDER BY id 
		ASC"; 
		$result = mysqli_query($connect, $query);		
		if(mysqli_num_rows($result) > 0) { 
while($row =mysqli_fetch_array($result)) { ?> 
<div class="col-md-4"> 
<form method="post" action="index.php?action=add&id=<?php 
echo $row["id"]; ?>"> 
<div style="border:1px solid #333; background-color:#f1f1f1; 
border-radius:5px; padding:10px;" align="center"> 
<h4 class="text-info"><?php echo $row["name"]; ?></h4> 
<h4 class="text-danger">$ <?php echo $row["price"]; ?></h4> 
<input type="text" name="quantity" class="form-control" 
												value="1"> 
<input type="hidden" name="hidden_name" value="<?php echo 
									$row["name"]; ?>" /> 
<input type="hidden" name="hidden_price" value="<?php echo 
										$row["price"]; ?>" /> 
<input type="submit" name="add_to_cart" style="margin-top:5px., 
class="btnbtn-success" value="Add to Cart" /> 
</div> 
</form> 
</div> 
<?php } 
		}  ?>
<div style="clear:both"></div> 
<br /> 
<h3>Order Details</h3> 
<div class="table-responsive"> 
<table class="table table-bordered"> 
<tr> 
<th width="40%">Item Name</th> 
<th width="10%">Quantity</th> 
<th width="20%">Price</th> 
<th width="15%">Total</th> 
<th width="5%">Action</th> 
</tr> 
<?php 
if(!empty($_SESSION["shopping_cart"])) { 
					$total = 0; 
foreach($_SESSION["shopping_cart"] as $keys => $values) { 
			?> 
<tr> 
<td><?php echo $values["item_name"]; ?></td> 
<td><?php echo $values["item_quantity"]; ?></td> 
<td>$ <?php echo $values["item_price"]; ?></td> 
<td>$ <?php echo number_format($values["item_quantity"] * 
$values["item_price"], 2); ?></td> 
<td><a href="index.php?action=delete&id=<?php 
echo $values["item_id"]; ?>"><span class="text-danger">Remove</span></a></td> 
</tr> 
<?php 
		$total = $total + ($values["item_quantity"] * 
									$values["item_price"]);
							} ?> 
<tr> 
<td colspan="3" align="right">Total</td> 
<td align="right">$<?php echo number_format($total, 2); ?></td> 
<td></td> 
</tr> 
<?php    }  
//session_destroy();
?>
</table> 
</div> 
</div> 
<br /> 
</body> 
</html> 
