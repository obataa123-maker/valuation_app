<?php
session_start();
include 'Invoice.php';
error_reporting(E_ALL & ~E_NOTICE);
$invoice = new Invoice();
$invoice->checkLoggedIn();
if(!empty($_GET['invoice_id']) && $_GET['invoice_id']) {
	$invoiceValues = $invoice->getInvoice($_GET['invoice_id']);		
	$invoiceItems = $invoice->getInvoiceItems($_GET['invoice_id']);		
}
$invoiceDate = date("d/M/Y, H:i:s", strtotime($invoiceValues['date']));
$output = '';
$output .= '<table width="100%" border="0" cellpadding="5" cellspacing="0">
	<tr>
	<td colspan="4" align="center" style="font-size:18px"><b>ХӨРӨНГИЙН ҮНЭЛГЭЭНИЙ ТАЙЛАНГИЙН ХУРААНГУЙЛАЛ</b></td>
	</tr>
	<tr>
		<td>
			<table width="100%" cellpadding="0">
				<tr>
					<td width="35%">Захиалагч:</td>
					<td width="65%">'.$invoiceValues['zahialagch'].'</td>
				</tr>
				<tr>
					<td width="35%">Захиалагчийг төлөөлж:</td>
					<td width="65%">'.$invoiceValues['tuluulugch'].'</td>
				</tr>
				<tr>
					<td width="35%">Үнэлгээний зүйл:</td>
					<td width="65%">Эрхийн улсын бүртгэлийн '.$invoiceValues['aral'].' дугаарт бүртгэлтэй </td>
				</tr>
				<tr>
					<td width="20%">Үнэлгээний зорилго:</td>
					<td width="45%">Ослын улмаас учирсан хохирол тодорхойлох</td>
					<td width="20%">Орж ирсэн он</td>
					<td width="15%">'.$invoiceValues['or_on'].'</td>
				</tr>
				<tr>
					<td width="20%">Зориулалт:</td>
					<td width="45%">'.$invoiceValues['zzune'].'  сая төгрөг</td>
					<td width="20%">Биет үзлэг хийсэн өдөр:</td>
					<td width="15%">'.$invoiceValues['ungu'].'</td>
				</tr>
				<tr>
					<td width="20%">Талбайн итгэлцүүр:</td>
					<td width="45%">'.$invoiceValues['turul'].'</td>
					<td width="20%">ҮХХ-ийн дугаар:</td>
					<td width="15%">'.$invoiceValues['aral'].'</td>
				</tr>
	</table>
	<br />
	<table width="100%" border="1" cellpadding="5" cellspacing="0">
	<tr>
	<th align="left">№</th>
	<th align="left">Эвдэрсэн эд ангийн нэр</th>
	<th align="left">Эвдрэл</th>
	<th align="left">Засварлах</th>
	<th align="left">Солих</th>
	</tr>';
$count = 0;   
foreach($invoiceItems as $invoiceItem){
	$count++;
	$output .= '
	<tr>
	<td align="left">'.$count.'</td>
	<td align="left">'.$invoiceItem["item_code"].'</td>
	<td align="left">'.$invoiceItem["order_item_quantity"].'</td>
	<td align="left">'.number_format($invoiceItem["order_item_price"]).'</td>
	<td align="left">'.number_format($invoiceItem["order_item_final_amount"]).'</td>
	</tr>';
}
$output .= '
	<tr>
		<td></td>
		<td align="left" colspan="2"><b>Шууд зардал</b></td>
		<td align="left"><b>'.number_format($invoiceValues['zassum']).'</b></td>
		<td align="left"><b>'.number_format($invoiceValues['order_total_after_tax']).'</b></td>
	</tr>
	<tr>
		<td align="left">1</td>
		<td align="left" colspan="2">Эд анги солих зардал</td>
		<td align="left">'.number_format($invoiceValues['order_total_tax']).'</td>
		<td align="left"></td>
	</tr>
	<tr>
		<td align="left">2</td>
		<td align="left" colspan="2">Эд анги будах зардал</td>
		<td align="left">'.number_format($invoiceValues['order_amount_paid']).'</td>
		<td align="left"></td>
	</tr>
	<tr>
		<td align="left">3</td>
		<td align="left" colspan="2">'.$invoiceValues['order_total_amount_due'].' гр будаг тус.мат.лак</td>
		<td align="left">'.number_format($invoiceValues['niitbudag']).'</td>
		<td align="left"></td>
	</tr>
		<tr>
		<td align="left"></td>
		<td align="left" colspan="2"><b>Шууд бус зардал</b></td>
		<td align="left"><b>'.number_format($invoiceValues['shuudbus']).'</b></td>
		<td align="left"></td>
	</tr>
	';
$output .= '
	</table>
	</td>
	</tr>
	</table>';
?>   

<!DOCTYPE html>
<html>
    <head>
        <title>Үнэлгээний тайлан</title>
        <style>
            html, body {
				background: white;
				width: 21cm;
				height: 29.7cm;
                margin: 10px;
                padding: 0;
				padding-top: 10px;
				margin-top: 300px;
            }
            #container {
                width: inherit;
                height: inherit;
                margin: 0;
                padding: 0;
                background-color: pink;
            }
            h1 {
                margin: 0;
                padding: 0;
            }
			
.page-header, .page-header-space {
  height: 200px;
}

.page-footer, .page-footer-space {
  height: 50px;

}

.page-footer {
  position: fixed;
  bottom: 0;
  width: 21cm;
  border-top: 1px solid black;
  background: yellow;
}

.page-header {
  position: absolute;
  top: 0mm;
  width: 21cm;
}

			.page {
			page-break-after: always;
					}

			@page {
					margin: 20mm; 
					}
			@media print {
			thead {display: table-header-group;} 
			tfoot {display: table-row-group;}
			button {display: none;}
			body {margin: 0;}
			}
			
			.wrap{
					text-align:center
					}
			.left{
					float: left;
					}
			.right{
					float: right;
					}
			.center{
					text-align:left;
					margin:0 hurungu !important; 
					display:inline-block;
					}
			table { 
					border-collapse: collapse;
					width: 100%;
					}
			th, td {
					padding-left: 5px;
					padding-right: 5px;
					}
			tr {
				page-break-inside: avoid;
				height: 70px;
			}
			hr { 
			display: block;
			margin-top: 0.5em 
			margin-bottom: 0.5em;
			border-width: 0px;

			} 
        </style>
    </head>
<body>
 <div class="invoice">


  <div class="page-header" style="text-align: center">
    <img src="upload/logo2.png" alt="logo2.png" align="right" width=220 height=129>
    <hr>
			<div class="wrap">
			<div align="left"><label value="<?php echo $invoiceValues['order_id']; ?>" id="order_id" name="order_id"><?php echo "№" .$invoiceValues['order_id']; ?></label></div>
			<div align="left">Огноо: <label value="<?php echo $invoiceValues['date']; ?>" id="date" name="date"><?php echo $invoiceValues['date']; ?></label> </div>
			</div>
	<div class="right">		
    <button type="button" onClick="window.print()" id="print" style="background: pink">
      ХЭВЛЭХ!
    </button>
	</div>
  </div>	
<div class="page" align="justify">
  <h1 align="center">
    ХӨРӨНГИЙН ҮНЭЛГЭЭНИЙ ТАЙЛАН
  </h1>
  <br></br>
		<table style="width:100%" border="0">
			<tr>
				<td width="28%">Захиалагч:</td>
				<td width="72%"><?php echo $invoiceValues['zahialagch']; ?></td> 
			</tr>
			<tr>
				<td>Захиалагчийг төлөөлж:</td>
				<td><?php echo $invoiceValues['tuluulugch']; ?></td>
			</tr>
			<tr>
				<td>Үнэлгээний зүйл:</td>
				<td>Эрхийн улсын бүртгэлийн <?php echo $invoiceValues['aral']; ?> дугаарт бүртгэлтэй <?php echo $invoiceValues['utas']; ?> м.кв талбайтай <?php echo $invoiceValues['zzune']; ?> зориулалттай үл хөдлөх эд хөрөнгө</td>
			</tr>
			<tr>
				<td>Үл хөдлөх хөрөнгийн хаяг:</td>
				<td><?php echo $invoiceValues['order_receiver_address']; ?></td>
			</tr>
			<tr>
				<td>Үнэлгээгээр тогтоогдсон дүн:</td>
				<td><?php echo number_format($invoiceValues['zassum']+$invoiceValues['order_total_after_tax']+$invoiceValues['shuudbus']); ?>&nbsp <input type="hidden" id="numeral_in" name="numberal_in" value="<?php echo $invoiceValues['zassum']+$invoiceValues['order_total_after_tax']+$invoiceValues['shuudbus']; ?>">/<label id="numeral_out"></label>/ төгрөг</td>
			</tr>
				<tr>
				<td>Үнэлгээний өдөр</td>
				<td><?php echo $invoiceValues['date']; ?></td>
			</tr>
		</table>
	<h4>
   
	<div align="center">
	<br></br><br></br><br></br><br></br><br></br>
	</div>
	<table style="width:100%" border="0">
			<tr>
				<td width="10%" rowspan="5">
												<script type="text/javascript" src="js/qrcode.min.js"></script>
												<div id="qrcode"></div>
												<script type="text/javascript">
												var qrcode = new QRCode(document.getElementById("qrcode"), {
												text: window.location.href,
												width: 70,
												height: 70,
												colorDark : "#000000",
												colorLight : "#ffffff",
												correctLevel : QRCode.CorrectLevel.H
												});
												</script></td>
				<td width="30%"></td>
				<td width="30%"></td>
				<td width="30%"></td> 
			</tr>
	</table>
<br></br>
</div>

<div class="page" style="page-break-before: always"  align="justify">	
  <div style="text-align: center">
    <img src="upload/logo.png" alt="logo" align="left" width=60 height=40>
  </div>	
	<div>
	<table style="width:100%" border="0">
				<tr>
				<td colspan="4" align="center" style="font-size:18px"><b>ХӨРӨНГИЙН ҮНЭЛГЭЭНИЙ ТАЙЛАНГИЙН ХУРААНГУЙЛАЛ</b></td>
				</tr>
			
			<tr>
				<td width="28%">Захиалагч:</td>
				<td width="72%"><?php echo $invoiceValues['zahialagch']; ?></td> 
			</tr>
			<tr>
				<td>Захиалагчийг төлөөлж:</td>
				<td><?php echo $invoiceValues['tuluulugch']; ?></td>
			</tr>
			<tr>
				<td>Үнэлгээний зүйл:</td>
				<td>Эрхийн улсын бүртгэлийн: <?php echo $invoiceValues['aral']; ?> дугаарт бүртгэлтэй <?php echo $invoiceValues['utas']; ?> м.кв талбайтай <?php echo $invoiceValues['zzune']; ?> зориулалттай үл хөдлөх эд хөрөнгө</td>
			</tr>
			<tr>
				<td>Үл хөдлөх хөрөнгийн хаяг:</td>
				<td><?php echo $invoiceValues['order_receiver_address']; ?></td>
			</tr>
			<tr>
				<td>Үнэлгээгээр тогтоогдсон дүн:</td>
				<td><?php echo number_format($invoiceValues['zassum']+$invoiceValues['order_total_after_tax']+$invoiceValues['shuudbus']); ?>&nbsp <input type="hidden" id="numeral_in" name="numberal_in" value="<?php echo $invoiceValues['zassum']+$invoiceValues['order_total_after_tax']+$invoiceValues['shuudbus']; ?>">төгрөг</td>
			</tr>
			
			<tr>
				<td>Гүйцэтгэгч:</td>
				<td>
				“Виннэрвэй Үнэлгээ” ХХК
				<br />Регистр: 5518113
				<br />Улсын бүртгэлийн дугаар: 9011309097
				<br />Утас: 70110200, 88051144
				Имэйл: contact@wiwa.mn
				</td>
			</tr>
			
				<tr align="justify">
				<td>Гишүүнчлэл:</td>
				<td>
				<br />Монгол Улсын Сангийн сайдын Хөрөнгийн үнэлгээ хийх тусгай зөвшөөрөл
				<br />Монголын Мэргэшсэн Үнэлгээчдийн Институт /ММҮИ/-ийн гишүүн
				<br />Монголын хөрөнгө болон хохирол үнэлэгч, мэргэшсэн үнэлгээчдийн нэгдсэн холбоо /МАОЛА/-ийн гишүүн
				</td>
				</tr>
				<tr>
				<td>Биет үзлэг хийсэн огноо:</td>
				<td><?php echo $invoiceValues['ungu']; ?></td>
				</tr>
				<tr>
				<td>Үнэлгээний өдөр</td>
				<td><?php echo $invoiceValues['date']; ?></td>
			</tr>
		</table>
	</div>



  <?php echo $output; ?>
  <div>
    <br></br>
		<table>
				<tr>
					<td width="10%" rowspan="3">
							<div id='qrcode'></div>
					</td>
				<td></td>
				</tr>
				<tr>
						<td><b align="left">Шууд зардлын дүн: <?php echo number_format($invoiceValues['zassum']+$invoiceValues['order_total_after_tax']); ?></b></td>
				</tr>
				<tr>
						<td><b align="left">Үнэлгээгээр тогтоогдсон дүн:<?php echo number_format($invoiceValues['zassum']+$invoiceValues['order_total_after_tax']+$invoiceValues['shuudbus']); ?></b></td>
				</tr>
		</table>
		
  </div>
</div>
</body>
</html>
<script src="js/convert.js"></script>