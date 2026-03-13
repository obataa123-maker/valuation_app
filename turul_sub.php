<?php
session_start();
$con=mysqli_connect("localhost:3306","root","","newhurungu");
if(mysqli_connect_errno())
{
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>

<?php

if(isset($_POST['ok2']))
{	$industry_id = $_POST['ind'];
	$sub_industry_name =$_POST['sub_industry_name'];
	//insert query
	$ins="INSERT INTO `tbl_sub_industry` (`industry_id`,`sub_industry_name`) VALUES ('$industry_id','$sub_industry_name')";
	$quey=mysqli_query($con,$ins) or die(mysqli_error($con));
}
			echo '<script type="text/javascript">
				location.replace("invoice_list.php");
			  </script>';
if(isset($_POST['ok1']))
{
	$ind=$_POST['ind'];
	$industry_name =$_POST['industry_name'];
	$sub_industry_name =$_POST['sub_industry_name'];
	//insert query
	$insert="INSERT INTO `tbl_industry` (`industry_id`,`industry_name`) VALUES ('$ind','$industry_name')";
	$query=mysqli_query($con,$insert) or die(mysqli_error($con));
	if($query==1)
	{
		$ins="INSERT INTO `tbl_sub_industry` (`industry_id`, `sub_industry_name`) VALUES ('$industry_id','$sub_industry_name')";
		$quey=mysqli_query($con,$ins) or die(mysqli_error($con));
		if($quey==1)
		{
		echo "Bolloo";
		}
	}
	else
	{
echo "Bolsongui";
	}
}

?>

