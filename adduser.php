<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();
$con=mysqli_connect("localhost:3306","root","","newhurungu");
$con->set_charset("utf8");
if(mysqli_connect_errno())
{
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>

<?php
if(!empty($_POST['mergejil']) && !empty($_POST['ner']))
{
	$mergejil =$_POST['mergejil'];
	$ner =$_POST['ner'];
	$company =$_POST['company'];
	//insert query
	$insert="INSERT INTO `adduser` (`mergejil`,`ner`,`company`) VALUES ('$mergejil','$ner','$company')";
	$query=mysqli_query($con,$insert) or die(mysqli_error($con));
}
			echo '<script type="text/javascript">
				location.replace("invoice_list.php");
			  </script>';

?>

