<?php
$connect = mysqli_connect("localhost:3306","root","","newhurungu");

 $connect->set_charset("utf8");
$columns = array('order_id', 'date', 'ulsiin_dugaar', 'uildverlegch', 'mark', 'uild_on', 'order_receiver_name', 'zahialagch', 'order_total_before_tax');

$query = "SELECT * FROM invoice_order WHERE ";

if($_POST["is_date_search"] == "yes")
{
 $query .= 'date BETWEEN "'.$_POST["start_date"].'" AND "'.$_POST["end_date"].'" AND ';
}

if(isset($_POST["search"]["value"]))
{
 $query .= '
  (order_id LIKE "%'.$_POST["search"]["value"].'%" 
  OR date LIKE "%'.$_POST["search"]["value"].'%" 
  OR ulsiin_dugaar LIKE "%'.$_POST["search"]["value"].'%" 
    OR uildverlegch LIKE "%'.$_POST["search"]["value"].'%" 
    
  OR mark LIKE "%'.$_POST["search"]["value"].'%" 
  OR uild_on LIKE "%'.$_POST["search"]["value"].'%" 
  OR order_receiver_name LIKE "%'.$_POST["search"]["value"].'%" 
  
  OR zahialagch LIKE "%'.$_POST["search"]["value"].'%" 
  OR order_total_before_tax LIKE "%'.$_POST["search"]["value"].'%" )
 ';
}

if(isset($_POST["order"]))
{
 $query .= 'ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' 
 ';
}
else
{
 $query .= 'ORDER BY order_id DESC ';
}

$query1 = '';

if($_POST["length"] != -1)
{
 $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$number_filter_row = mysqli_num_rows(mysqli_query($connect, $query));

$result = mysqli_query($connect, $query . $query1);

$data = array();
//<script  src="js/script.js"></script> modal hooson zaind huulhad davtaltiin toogoor zurag garaad baigaa anhaar!!


while($row = mysqli_fetch_array($result))
{
    
 $sub_array = array();
 $sub_array[] = $row["order_id"];
 $sub_array[] = $row["date"];
 $sub_array[] = $row["ulsiin_dugaar"];
 $sub_array[] = $row["uildverlegch"];
  $sub_array[] = $row["mark"];
 $sub_array[] = $row["uild_on"];
 $sub_array[] = $row["order_receiver_name"];
  $sub_array[] = $row["zahialagch"];
 $sub_array[] = number_format($row["order_total_before_tax"]);
 
   $sub_array[] ='
   <a data-toggle="modal" data-target="#'.$row["order_id"].'" title=""><span class="glyphicon glyphicon-picture"></span></a>
  <div class="modal fade" id="'.$row["order_id"].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header" align="center"
							<div class="modal-body">

							<form action="image_upload.php?invoice_id='.$row["order_id"].'" method="POST"  id="form" enctype="multipart/form-data">
							<div class="upload__box">
							<div class="upload__btn-box">
							<label class="upload__btn">
							<p>Зураг нэмэх</p>
							<input type="file" name="files[]" multiple="" data-max_length="30" class="upload__inputfile">
							</label>
							</div>
							<div class="upload__img-wrap"></div>
							</div>
							<input type="submit" value="Оруулах">
							</form>
						</div>
					</div>
				</div>
  ';
  
 
  $sub_array[] ='<a href="print_invoice.php?invoice_id='.$row["order_id"].'" title="Print Invoice"><span class="glyphicon glyphicon-book"></span></a>';
  
  $sub_array[] ='<a href="print.php?invoice_id='.$row["order_id"].'" title=""><span class="glyphicon glyphicon-print"></span></a>';
  $sub_array[] ='<a data-toggle="modal" data-target="#mymodal'.$row["order_id"].'" title=""><span class="glyphicon glyphicon-envelope"></span></a>
  <div class="modal fade" id="mymodal'.$row["order_id"].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header" align="center">
							И-мэйл илгээх

							<div class="modal-body">
							
							<form action="send.php?invoice_id='.$row["order_id"].'" method="POST" style="float: left;">
							<input type="text" name="email" id="mailto" />
							<input type="submit" class="button_active" value="Илгээх">
							</form>
						</div>
					</div>
				</div>
  ';
  
  
  $sub_array[] ='<a href="edit_invoice.php?update_id='.$row["order_id"].'"  title="Edit Invoice"><span class="glyphicon glyphicon-edit"></span></a>';
  $sub_array[] ='<a href="#" id="'.$row["order_id"].'" class="deleteInvoice"  title="Delete Invoice"><span class="glyphicon glyphicon-remove"></span></a>';
 $data[] = $sub_array;
}

function get_all_data($connect)
{
 $query = "SELECT * FROM invoice_order";
 $result = mysqli_query($connect, $query);
 return mysqli_num_rows($result);
}

$output = array(
 "draw"    => intval($_POST["draw"]),
 "recordsTotal"  =>  get_all_data($connect),
 "recordsFiltered" => $number_filter_row,
 "data"    => $data
);

echo json_encode($output);

?>

