<?php
session_start();
$con=mysqli_connect("localhost:3306","root","","newhurungu");
if(mysqli_connect_errno())
{
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>

<?php
if(!empty($_POST['mner']) && !empty($_POST['email']))
{
	$mner =$_POST['mner'];
	$email =$_POST['email'];
	//insert query
	$insert="INSERT INTO `addmail` (`mner`,`email`) VALUES ('$mner','$email')";
	$query=mysqli_query($con,$insert) or die(mysqli_error($con));
}
header('Location:invoice_list.php');

?>
