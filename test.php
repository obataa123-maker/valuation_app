<?php 
session_start();
include('header.php');
include 'Invoice.php';
$invoice = new Invoice();
$invoice->checkLoggedIn();
$con = mysqli_connect("localhost:3306","root","","newhurungu");
$query="SELECT * FROM `addmail`";
$result = mysqli_query($con, $query);
?>
<div>	
				<select type="text" id="slct" name="tuslah">
				<option></option>
				<?php while($row1 = mysqli_fetch_array($result1)):;?>
				<option value="<?php echo $row1[2];?>"><?php echo $row1[2];?></option>
				<?php endwhile;?>
				</select>
</div>