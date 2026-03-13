<?php
session_start();
include('Invoice.php');
$invoice = new Invoice();
if(isset($_POST["action"]))
{
        if($_POST['action'] == 'delete_invoice' && $_POST['id']) {
	            $invoice->deleteInvoice($_POST['id']);	
	            $jsonResponse = array(
		        "status" => 1);
	    echo json_encode($jsonResponse);	
        }

        if($_GET['action'] == 'logout') {
        session_unset();
        session_destroy();
        header("Location: https://unelgee.wiwa.mn/face_list.php");
        }
}
?>