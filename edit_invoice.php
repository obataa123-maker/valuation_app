<?php 
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();
include('header.php');
include 'Invoice.php';
$invoice = new Invoice();
$invoice->checkLoggedIn();
$host = "localhost:3306"; /* Host name */
$user = "root"; /* User */
$password = ""; /* Password */
$dbname = "newhurungu"; /* Database name */

$conn = mysqli_connect($host, $user, $password, $dbname);
 $conn->set_charset("utf8");
$query1="SELECT * FROM `adduser`";
$result2 = mysqli_query($conn, $query1);
$result1 = mysqli_query($conn, $query1);

if(!empty($_POST['invoiceId']) && $_POST['invoiceId']) {	
	$invoice->updateInvoice($_POST);

			echo '<script type="text/javascript">
				location.replace("invoice_list.php");
			  </script>';	
}
if(!empty($_GET['update_id']) && $_GET['update_id']) {
	$invoiceValues = $invoice->getInvoice($_GET['update_id']);		
	$invoiceItems = $invoice->getInvoiceItems($_GET['update_id']);		
}
?>
<title>Тайлан засах</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" charset="utf-8">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="js/invoice.js"></script>
<link href="css/style.css" rel="stylesheet">
<?php include('container.php');?>

<div class="container content-invoice">
	    	<div class="load-animate animated fadeInUp">
		    	<div class="row">
		    		<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
		    			<h4 class="title">Үнэлгээний тайлан засварлах</h4>
						<?php include('menu.php');?>			
		    		</div>		    		
		    	</div>
		      	<input id="currency" type="hidden" value="$">

	
	<form action="" id="invoice-form" method="post" class="invoice-form" role="form" novalidate=""> 	
	<table style="width:70%">
	
	<tr height = 30px><td colspan="2" align="center";> <h4>Хөрөнгийн ерөнхий мэдээлэл</h4></td></tr>
	
    <tr bgcolor="#D6EEEE">
    <td><label>Тайлангийн огноо:</label></td> <td><input tabindex="1" type="date" value="<?php echo $invoiceValues['date']; ?>" id="date" name="date" readonly/></td> 
	<td><label>Биет үзлэг хийсэн өдөр:</label></td> <td><input tabindex="11" type="text" value="<?php echo $invoiceValues['ungu']; ?>" id="ungu" name="ungu" /></td>
    </tr>
	<tr bgcolor="#D6EEEE">
	<td><label>Захиалагч:</label></td><td> <input tabindex="7" type="text" value="<?php echo $invoiceValues['zahialagch']; ?>" id="zahialagch" name="zahialagch" /></td>
	<td><label>Захиалагчийг төлөөлж:</label></td> <td><input tabindex="17" type="text" value="<?php echo $invoiceValues['tuluulugch']; ?>" id="tuluulugch" name="tuluulugch" /></td>
	</tr>
	<tr bgcolor="#D6EEEE">
	<td><label>ҮХХ-ийн дугаар:</label></td> <td><input tabindex="12" type="text" value="<?php echo $invoiceValues['aral']; ?>" id="aral" name="aral"/></td>
	<td><label>Өмчлөгчийн нэр:</label></td> <td><input tabindex="13" value="<?php echo $invoiceValues['order_receiver_name']; ?>" type="text" name="companyName" id="companyName" hurungucomplete="off"></td>
	</tr>
	
	<tr bgcolor="#D6EEEE">
	<td><label>Зориулалт:</label></td>
					<td>
					<select tabindex="8" id="slct" type="text" name="zzune"> 
					<option value="<?php echo $invoiceValues['zzune']; ?>"><?php echo $invoiceValues['zzune']; ?></option> 
					<option value="Орон сууцны">Орон сууцны</option>
					<option value="Үйлчилгээний">Үйлчилгээний</option> 
					<option value="Үйлдвэрлэлийн">Үйлдвэрлэлийн</option> 
					<option value="Үйлдвэр, үйлчилгээний">Үйлдвэр, үйлчилгээний</option> 
					<option value="Автозогсоолын">Автозогсоолын</option>
					<option value="Гаражийн">Гаражийн</option> 
					<option value="Бусад">Бусад</option> 				
					</select>
					</td>
	
	
	<td><label>Талбайн хэмжээ:</label></td> <td><input tabindex="15" type="text" value="<?php echo $invoiceValues['utas']; ?>" id="utas" name="utas" /></td>
	</tr>
	
	<tr bgcolor="#D6EEEE">
	<td><label>ҮХХ-ийн хаяг:</label></td> <td><input tabindex="14" value="<?php echo $invoiceValues['order_receiver_address']; ?>" type="text" name="address" id="address" /></td>
	<td><label>УБГ-ний огноо:</label></td> <td><input tabindex="18" type="text" value="<?php echo $invoiceValues['hariutsagch']; ?>" id="tuluulugch" name="hariutsagch" /></td>
	</tr>
	
	<tr bgcolor="#D6EEEE">
	<td><label>Ашиглалтад орсон он:</label></td><td><input tabindex="5" type="text" value="<?php echo $invoiceValues['uild_on']; ?>" id="date" name="uild_on" /></td>
	<td><label>Үнэлгээний зорилго:</label></td> <td><input tabindex="19" type="text" value="Ослын улмаас учирсан хохирол тодорхойлох"/></td>
	</tr>
	
	<tr bgcolor="#D6EEEE">
					<td><label>Өрөөний тоо/хуваалт:</label></td>
					<td colspan="3"><textarea tabindex="20" class="form-control txt" rows="2" name="akt" id="akt" style="resize:vertical; width:98%; margin:14px"><?php echo $invoiceValues['akt']; ?></textarea></td>	
	</tr>
	
	<tr height = 60px><td colspan="2" align="center";> <h4>Хөрөнгийн дэлгэрэнгүй мэдээлэл</h4></td></tr>
	
	<tr bgcolor="#fad7a0">
		<td><label>Хөрөнгийн хийц:</label></td>
		<td>
				<div>
		    <select tabindex="2" name="category_item"  id="category_item" class="ml-sm-5 bg-warning"  data-live-search="true" title="<?php echo $invoiceValues['uildverlegch']; ?>" onchange="myFunction()">
			<option selected><?php echo $invoiceValues['uildverlegch']; ?></option>
            </select><input name="uname" id="uname" type="hidden" value="<?php echo $invoiceValues['uildverlegch']; ?>">
			<br>
		</div>
		</td>
			<td><label>Нэгжийн үнэлгээ:</label></td>
			<td>
				<div>
		    <select tabindex="3" name="sub_category_item"  id="sub_category_item" class="ml-sm-5 bg-warning"  data-live-search="true" title="<?php echo $invoiceValues['mark']; ?>" onchange="myFunction1()">
			<option selected><?php echo $invoiceValues['mark']; ?></option>
            </select><input name="uname1" id="uname1" type="hidden" value="<?php echo $invoiceValues['mark']; ?>">
			<br>
		</div>
	</td>
	</tr>
	
	<tr bgcolor="#fad7a0">
	<td><label>Үнийн өсөлтийн индекс:</label></td><td><input tabindex="4" type="text" value="<?php echo $invoiceValues['ulsiin_dugaar']; ?>" id="date" name="ulsiin_dugaar" /></td>
	<td><label>Чанар байдал:</label></td>
					<td>
					<select tabindex="8" id="slct" type="text" name="or_on"> 
					<option value="<?php echo $invoiceValues['or_on']; ?>"><?php echo $invoiceValues['or_on']; ?></option> 
					<option value="Шинэ /Ш/">Шинэ /Ш/</option> 
					<option value="Маш сайн /МС/">Маш сайн /МС/</option> 
					<option value="Сайн /С/">Сайн /С/</option> 
					<option value="Дунд /Д/">Дунд /Д/</option>
					<option value="Муу /М/">Муу /М/</option> 
					<option value="Маш муу">Маш муу /ММ/</option> 
					<option value="Актлах">Актлах /А/</option>
					<option value="Хаягдал">Хаягдал /Х/</option> 			
					</select>
					</td>
	
	</tr>
	
	<tr bgcolor="#fad7a0">
		<td><label>Норматив хугацаа:</label></td>
					<td>
					<select tabindex="8" id="slct" type="text" name="zereg"> 
					<option value="<?php echo $invoiceValues['zereg']; ?>"><?php echo $invoiceValues['zereg']; ?></option> 
					<option value="60">60</option> 
					<option value="40">40</option> 
					<option value="35">35</option> 
					<option value="30">30</option>
					<option value="25">25</option> 
					<option value="20">20</option> 				
					</select>
					</td>
					<td><label>Талбайн итгэлцүүр:</label></td>
					<td><p><select tabindex="9" id="slct" type="text" name="turul">
					<option value="<?php echo $invoiceValues['turul']; ?>"><?php echo $invoiceValues['turul']; ?></option> 
					<option value="MNS6058:2009">1.1</option> 
					<option value="Гадна ханын гадаргуу">0.95</option> 
					<option value="Тэнхлэгээрх">1</option> 
					</select></p></td>
	</tr>
		<tr bgcolor="#fad7a0">
					<td><label>Үнэлгээчин:</label></td>
					<td>
					<select type="text" id="slct" name="unelgeechin" tabindex="10">
					<option value="<?php echo $invoiceValues['unelgeechin']; ?>"><?php echo $invoiceValues['unelgeechin']; ?></option> 
					<?php while($row2 = mysqli_fetch_array($result2)):;?>
					<option value="<?php echo $row2[2];?>"><?php echo $row2[2];?></option>
					<?php endwhile;?>
					</select>
					</td>
					<td><label>Туслах үнэлгээчин:</label></td>
					<td>
					<select type="text" id="slct" name="tuslah" tabindex="20">
					<option value="<?php echo $invoiceValues['tuslah']; ?>"><?php echo $invoiceValues['tuslah']; ?></option> 
					<?php while($row1 = mysqli_fetch_array($result1)):;?>
					<option value="<?php echo $row1[2];?>"><?php echo $row1[2];?></option>
					<?php endwhile;?>
					</select>
					</td>
		</tr>
	
	<tr height = 60px><td colspan="2" align="center";> <h4>Тохируулгын индексүүд</h4></td></tr>

		<tr bgcolor="#d2b4de">
		<td><label>Шууд зардлын:</label></td><td><input tabindex="17" type="number" value="<?php echo $invoiceValues['shudzar_ind']; ?>" name="shudzar_ind" id="shudzar_ind"/></td>
		<td><label>Баягалын зарим хүчин зүйлийн:</label></td><td><input tabindex="17" type="number" value="<?php echo $invoiceValues['bzhz_ind']; ?>" name="bzhz_ind" id="bzhz_ind"/></td>
		</tr>
		<tr bgcolor="#d2b4de">
		<td><label>Тээврийн зардлын:</label></td><td><input tabindex="17" type="number" value="<?php echo $invoiceValues['tz_ind']; ?>" name="tz_ind" id="tz_ind"/></td>
		<td><label>Төхөөрөмжлөгдсөн байдлын:</label></td><td><input tabindex="17" type="number" value="1" name="tb_ind" id="tb_ind"/></td>
		</tr>
		<tr bgcolor="#d2b4de">
		<td><label>Инженерийн шугам сүлжээнд холбогдсон байдлын:</label></td><td><input tabindex="17" type="number" value="<?php echo $invoiceValues['inj_ind']; ?>" name="inj_ind" id="inj_ind"/></td>
		<td><label>Барилгын өндрийн:</label></td><td><input tabindex="17" type="number" value="<?php echo $invoiceValues['undur_ind']; ?>" name="undur_ind" id="undur_ind"/></td>
		</tr>
		<tr bgcolor="#d2b4de">
		<td><label>Барилгын ханын зузааны:</label></td><td><input tabindex="17" type="number" value="<?php echo $invoiceValues['hana_ind']; ?>" name="hana_ind" id="hana_ind"/></td>
		<td><label>Барилгын хийцийн:</label></td><td><input tabindex="17" type="number" value="<?php echo $invoiceValues['hiits_ind']; ?>" name="hiits_ind" id="hiits_ind"/></td>
		</tr>
		<tr bgcolor="#d2b4de">
		<td><label>Бусад хүчин зүйлсийн:</label></td><td><input tabindex="17" type="number" value="<?php echo $invoiceValues['bus_ind']; ?>" name="bus_ind" id="bus_ind"/></td>
		</tr>
	</tr>
	
<tr height = 60px><td colspan="2" align="center";> <h4>Тооцоолол</h4></td></tr>
		
	</table>
				
				<!--
				<div class="row">
		      		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
		      			<h3>From,</h3>
						<?php echo $_SESSION['user']; ?><br>	
						<?php echo $_SESSION['address']; ?><br>	
						<?php echo $_SESSION['mobile']; ?><br>
						<?php echo $_SESSION['email']; ?><br>		      						      									
		      		</div>      		
		      		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 pull-right">
		      			<h3>To,</h3>
		      			<div class="form-group">
							<input value="<?php echo $invoiceValues['order_receiver_name']; ?>" type="text" class="form-control" name="companyName" id="companyName" placeholder="Company Name" hurungucomplete="off">
						</div>
						<div class="form-group">
							<textarea class="form-control" rows="3" name="address" id="address" placeholder="Your Address"><?php echo $invoiceValues['order_receiver_address']; ?></textarea>
						</div>
						
		      		</div>
		      	</div>
				-->
				<br>
		      	<div class="row">
		      		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		      			<table class="table table-bordered table-hover" id="invoiceItem" onkeyup="fun()">	
							<tr>
								<th><input id="checkAll" class="formcontrol" type="checkbox" style="width: 100%;"></th>
							<th width="20%">Эвдэрсэн эд ангийн нэр</th>
							<th width="12%">Эвдрэл</th>
							<th width="10%">Засварлах</th>								
							<th width="12%">Солих</th>
							<th width="10%" bgcolor="#eee">Будгийн ажил</th>
							<th width="9%" bgcolor="#eee">Будаг /гр/</th>
							<th width="10%" bgcolor="#eee">Солих ажлын хөлс</th>
							<th width="13%" bgcolor="#eee">Эх сурвалж</th>
							</tr>
							<?php 
							$count = 0;
							foreach($invoiceItems as $invoiceItem){
								$count++;
							?>								
							<tr>
								<td><input class="itemRow" type="checkbox" style="width: 100%;"></td>
								<td><input tabindex="21" type="text" value="<?php echo $invoiceItem["item_code"]; ?>" name="productCode[]" id="productCode_<?php echo $count; ?>" class="form-control" hurungucomplete="off"></td>			
								<td>
									<select tabindex="22" class="form-control quantity" type="text" name="quantity[]" id="quantity_<?php echo $count; ?>" hurungucomplete="off" style="width: 100%;">
									<option value="<?php echo $invoiceItem["order_item_quantity"]; ?>"><?php echo $invoiceItem["order_item_quantity"]; ?></option> 
									<option value="Их">Их</option> 
									<option value="Дунд">Дунд</option> 
									<option value="Бага">Бага</option>
									<option value="Хагарсан">Хагарсан</option> 
									</select>
								</td>
								<td><input tabindex="23" type="number" value="<?php echo $invoiceItem["order_item_price"]; ?>" name="price[]" id="price_<?php echo $count; ?>" class="form-control price" hurungucomplete="off" onkeyup="fun()"></td>
								<td><input tabindex="24" type="number" value="<?php echo $invoiceItem["order_item_final_amount"]; ?>" name="total[]" id="total_<?php echo $count; ?>" class="form-control total" hurungucomplete="off" onkeyup="fun()"></td>
								<td bgcolor="#eee"><input tabindex="25" type="number" value="<?php echo $invoiceItem["zasvar"]; ?>" name="zasvar[]" id="zasvar_<?php echo $count; ?>" class="form-control total" hurungucomplete="off" onkeyup="fun()"></td>
								<td bgcolor="#eee"><input tabindex="26" type="number" value="<?php echo $invoiceItem["budag"]; ?>" name="budag[]" id="budag_<?php echo $count; ?>" class="form-control total" hurungucomplete="off" onkeyup="fun()"></td>
								<td bgcolor="#eee"><input tabindex="27" type="number" value="<?php echo $invoiceItem["solih"]; ?>" name="solih[]" id="solih_<?php echo $count; ?>" class="form-control total" hurungucomplete="off" onkeyup="fun()"></td>
								<td bgcolor="#eee"><input tabindex="28" type="text" value="<?php echo $invoiceItem["survalj"]; ?>" name="survalj[]" id="survalj_<?php echo $count; ?>" class="form-control total" hurungucomplete="off" onkeyup="fun()"></td>
								<input type="hidden" value="<?php echo $invoiceItem['order_item_id']; ?>" class="form-control" name="itemId[]" onkeyup="fun()">
							</tr>	
							<?php } ?>		
						</table>
		      		</div>
		      	</div>
		      	<div class="row">
		      		<div class="col-xs-4 col-sm-3 col-md-3 col-lg-3">
		      			<button class="btn btn-danger delete" id="removeRows" type="button" onkeyup="fun()">- Устгах</button>
		      			<button class="btn btn-success" id="addRows" type="button" onkeyup="fun()">+ Мөр нэмэх</button>
		      		</div>
		      	</div>
		      	<div class="row">	
		      		<div class="col-xs-5 col-sm-6 col-md-6 col-lg-6">
		      			<br></br>
						<b>Тэмдэглэл: </b>
		      			<div class="form-group">
							<textarea class="form-control txt" rows="2" name="notes" id="notes" placeholder="Тэмдэглэл" style="width: 50%;"><?php echo $invoiceValues['note']; ?></textarea>
						</div>
						<br>
						<div class="form-group">
							<input type="hidden" value="<?php echo $_SESSION['userid']; ?>" class="form-control" name="userId">
							<input type="hidden" value="<?php echo $invoiceValues['order_id']; ?>" class="form-control" name="invoiceId" id="invoiceId">
			      			<input tabindex="30" data-loading-text="Хадгалж байна..." type="submit" name="invoice_btn" value="Тайлан хадгалах" class="btn btn-success submit_btn invoice-save-btm">
			      		</div>
						
		      		</div>
		      		<div class="col-xs-7 col-sm-6 col-md-6 col-lg-6">
						<span class="form-inline" onkeyup="fun()">
							<div class="form-group">
								<label style="color:red;">100гр будгийн үнэ: &nbsp;</label>
								<div class="input-group">
									<input tabindex="29" value="<?php echo $invoiceValues['budagune']; ?>" type="number" class="form-control" name="budagune" id="budagune" onkeyup="fun()">
									<div class="input-group-addon currency"><span>&#8366;</span></div>
								</div>
							</div>
							<div class="form-group" onkeyup="fun()">
								<label>Будаг /гр/: &nbsp;</label>
								<div class="input-group">
									<input value="<?php echo $invoiceValues['order_total_amount_due']; ?>" type="number" class="form-control" name="amountDue" id="amountDue" style="background-color: #d2f0f8;" onkeyup="fun()" placeholder="" readonly>
									<div class="input-group-addon currency"><span>&#8366;</span></div>
								</div>
							</div>
							<div class="form-group" onkeyup="fun()">
								<label>Будгийн нийт үнэ: &nbsp;</label>
								<div class="input-group">
									<input value="<?php echo $invoiceValues['niitbudag']; ?>" type="number" class="form-control" name="niitbudag" id="niitbudag" style="background-color: #d2f0f8;" onkeyup="fun()" placeholder="" readonly >
									<div class="input-group-addon currency"><span>&#8366;</span></div>
								</div>
							</div>
							<div class="form-group">
								<label>Будгийн ажлын хөлс: &nbsp;</label>
								<div class="input-group">
									<input value="<?php echo $invoiceValues['order_amount_paid']; ?>" type="number" class="form-control" name="amountPaid" id="amountPaid" style="background-color: #d2f0f8;" onkeyup="fun()" placeholder="" readonly>
									<div class="input-group-addon currency"><span>&#8366;</span></div>
								</div>
							</div>
							<div class="form-group">
								<label>Засварын зардлын нийт дүн: &nbsp;</label>
								<div class="input-group">
									<input value="<?php echo $invoiceValues['zassum']; ?>" type="number" class="form-control" name="zassum" id="zassum" style="background-color: #b4f9bf;" onkeyup="fun()" readonly>
									<div class="input-group-addon currency"><span>&#8366;</span></div>
								</div>
							</div>
							<!--
							<div class="form-group">
								<label>Tax Amount: &nbsp;</label>
								<div class="input-group">
									<div class="input-group-addon currency">Т</div>
									<input value="<?php echo $invoiceValues['order_total_tax']; ?>" type="number" class="form-control" name="taxAmount" id="taxAmount" placeholder="Tax Amount">
								</div>
							</div>-->							
							<div class="form-group">
								<label>Эд анги солих хөлс: &nbsp;</label>
								<div class="input-group">
									<input value="<?php echo $invoiceValues['order_total_tax']; ?>" type="number" class="form-control" name="taxAmount" id="taxAmount" placeholder="" style="background-color: #b4f9bf;" readonly>
									<div class="input-group-addon currency"><span>&#8366;</span></div>
								</div>
							</div>
							<div class="form-group">
								<label>Нийт шууд бус зардал: &nbsp;</label>
								<div class="input-group">
									<input value="<?php echo $invoiceValues['shuudbus']; ?>" type="number" class="form-control" name="shuudbus" id="shuudbus" onkeyup="fun()" placeholder="" readonly>
									<div class="input-group-addon currency"><span>&#8366;</span></div>
								</div>
							</div>
							<div class="form-group">
								<label>Шууд зардлын нийт дүн: &nbsp;</label>
								<div class="input-group">
									<input value="<?php echo $invoiceValues['order_total_after_tax']; ?>" type="number" class="form-control" name="totalAftertax1" id="totalAftertax1" onkeyup="fun()" readonly>
									<div class="input-group-addon currency"><span>&#8366;</span></div>
								</div>
							</div>
							<div class="form-group">
								<label>Үнэлгээгээр тогтоогдсон дүн: &nbsp;</label>
								<div class="input-group">
									<input value="<?php echo $invoiceValues['zassum']+$invoiceValues['order_total_after_tax']+$invoiceValues['shuudbus']; ?>" type="number" class="form-control" name="subTotal" id="subTotal" onkeyup="fun()"  placeholder="Subtotal" readonly>
									<div class="input-group-addon currency"><span>&#8366;</span></div>
								</div>
							</div>
						</span>
					</div>
		      	</div>
		      	<div class="clearfix"></div>		      	
	      	</div>
		</form>			
    </div>
</div>	
<?php include('footer.php');?>
<script>
function myFunction(e) {
   var d=document.getElementById("category_item");
   var displaytext=d.options[d.selectedIndex].text;
   document.getElementById("uname").value=displaytext; 
}
</script>

<script>
function myFunction1(e) {
   var d=document.getElementById("sub_category_item");
   var displaytext=d.options[d.selectedIndex].text;
   document.getElementById("uname1").value=displaytext; 
}
</script>
<script>
$("form").bind("keypress", function (e) {
    if (e.keyCode == 13) {
        return false;
    }
});
</script>
<script>
$(document).ready(function(){

  $('#category_item').selectpicker();

  $('#sub_category_item').selectpicker();

  load_data('category_data');

  function load_data(type, category_id = '')
  {
    $.ajax({
      url:"load_data.php",
      method:"POST",
      data:{type:type, category_id:category_id},
      dataType:"json",
      success:function(data)
      {
        var html = '';
        for(var count = 0; count < data.length; count++)
        {
          html += '<option value="'+data[count].id+'">'+data[count].name+'</option>';
        }
        if(type == 'category_data')
        {
          $('#category_item').html(html);
          $('#category_item').selectpicker('refresh');
        }
        else
        {
          $('#sub_category_item').html(html);
          $('#sub_category_item').selectpicker('refresh');
        }
      }
    })
  }

  $(document).on('change', '#category_item', function(){
    var category_id = $('#category_item').val();
    load_data('sub_category_data', category_id);
  });
  
});
</script>

<script>
function fun(){
var firstValue  = Number($('#budagune').val()); 
var secondValue = Number($('#amountDue').val())/100; 
var calculate = firstValue * secondValue;
var niitbud = (calculate);
	var firstV  = Number($('#amountPaid').val()); //будгийн ажлын нийт хөлс
    var secondV = Number($('#taxAmount').val());//Эд анги солих ажлын хөлс

    document.getElementById('shuudbus').innerHTML = firstV + secondV+niitbud;
document.getElementById("niitbudag").innerHTML = niitbud;
  }
</script>

<script>
$('input').keyup(function(){ // run anytime the value changes
    var firstValue  = Number($('#budagune').val()); 
    var secondValue = Number($('#amountDue').val())/100; 
	var firstV  = Number($('#amountPaid').val()); //будгийн ажлын нийт хөлс
    var secondV = Number($('#taxAmount').val());//Эд анги солих ажлын хөлс
	var calc=firstV + secondV;
    document.getElementById('shuudbus').value = calc+firstValue * secondValue;
    document.getElementById('niitbudag').value = firstValue * secondValue;
});
</script>
