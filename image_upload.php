<?php
$server = "localhost:3306"; /* Host name */
$username = "root"; /* User */
$password = ""; /* Password */
$dbname = "newhurungu"; /* Database name */
$conn = new mysqli($server, $username, $password, $dbname);

include 'Invoice.php';
$invoice = new Invoice();
if(!empty($_GET['invoice_id']) && $_GET['invoice_id']) {
	$invoiceValues = $invoice->getInvoice($_GET['invoice_id']);		
	$invoiceItems = $invoice->getInvoiceItems($_GET['invoice_id']);		
}

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$targetDir = "image/";
$image = $_FILES['files']['name'];
$fileName = implode(",",$image);
//echo $fileName;
if(!empty($image)){
	 foreach ($image as $key=>$val){
		 $targetFilePath =$targetDir . $val;
		 $image=imagecreatefromjpeg($_FILES['files']['tmp_name'][$key]);
		 imagejpeg($image, $targetFilePath, 20);
	 }
	 $query = "UPDATE invoice_order SET images ='$fileName' WHERE order_id='".$_GET['invoice_id']."'";
	 $statement = $conn->prepare($query);
	 	 $statement->execute();
     header('Location:invoice_list.php');
	 //echo "Амжилттай хадгалагдлаа";
}
?>