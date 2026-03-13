<style>
/* ===== FIX: make valuation table clean & responsive (no ugly cards) ===== */
.val-table-wrap{overflow-x:auto;-webkit-overflow-scrolling:touch;}
@media (max-width: 768px){
  .val-table,
  .val-table thead,
  .val-table tbody,
  .val-table tr{
    display: table !important;
    width: 100%;
  }
  .val-table th,
  .val-table td{
    display: table-cell !important;
    font-size: 12px;
    white-space: nowrap;
  }
  .val-table thead{display: table-header-group !important;}
}

.rent-image-input{
  width: 100%;
  max-width: 100%;
  font-size: 12px;
  padding: 4px 6px;
  line-height: 1.2;
  box-sizing: border-box;
}

.rent-image-input::-webkit-file-upload-button{
  padding: 4px 8px;
  margin-right: 8px;
  font-size: 12px;
  border: 1px solid #ccc;
  background: #f7f7f7;
  border-radius: 6px;
  cursor: pointer;
}
td .rent-upload-box{
  display:flex;
  flex-direction:column;
  align-items:center;
  justify-content:center;
  gap:6px;
  text-align:center;
}

.rent-upload-btn{
  display:inline-block;
  padding:4px 10px;
  font-size:12px;
  border:1px solid #ccc;
  border-radius:6px;
  background:#f3f4f6;
  cursor:pointer;
}

.rent-upload-btn:hover{
  background:#e5e7eb;
}

.rent-thumb-preview{
  display:none;
  max-width:70px;
  max-height:70px;
  border:1px solid #ddd;
  border-radius:6px;
  object-fit:cover;
}

.rent-outlier td{
  background:#fff1f2 !important;
}
</style>

<?php 
session_start();
include('header.php');
include('Invoice.php');
$invoice = new Invoice();
$invoice->checkLoggedIn();
$host = "localhost:3306"; /* Host name */
$user = "root"; /* User */
$password = ""; /* Password */
$dbname = "newhurungu"; /* Database name */

$con = mysqli_connect($host, $user, $password, $dbname);
 $con->set_charset("utf8");
$query="SELECT * FROM `adduser`";
$result2 = mysqli_query($con, $query);
$result1 = mysqli_query($con, $query);

if(!empty($_POST['companyName']) && $_POST['companyName']) {	
	$invoice->saveInvoice($_POST);
			echo '<script type="text/javascript">
				location.replace("invoice_list.php");
			  </script>';
}
?>

<title>Авто үнэлгээ</title>
 <meta name="viewport" content="width=device-width, initial-scale=1" charset="utf-8">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 <script src="js/invoice.js"></script>
 <link href="css/style.css" rel="stylesheet">
<style>
/* Wizard UI (non-invasive) */
.wiz-wrap{margin:14px 0 18px;padding:14px 14px 10px;border:1px solid rgba(0,0,0,.08);border-radius:12px;background:#fff}
.wiz-top{display:flex;gap:12px;align-items:center;justify-content:space-between;flex-wrap:wrap}
.wiz-steps{display:flex;gap:8px;flex-wrap:wrap;align-items:center}
.wiz-pill{display:flex;gap:8px;align-items:center;padding:6px 10px;border-radius:999px;border:1px solid rgba(0,0,0,.12);font-size:13px;user-select:none}
.wiz-pill strong{font-weight:700}
.wiz-pill.active{border-color:rgba(0,0,0,.28)}
.wiz-pill.done{opacity:.75}
.wiz-progress{flex:1;min-width:220px;height:10px;border-radius:999px;background:rgba(0,0,0,.06);overflow:hidden}
.wiz-progress > div{height:100%;width:0%;background:var(--wiz-accent, rgba(0,0,0,.45))}
.wiz-actions{display:flex;gap:8px;justify-content:flex-end;margin-top:12px;flex-wrap:wrap}
.wiz-actions .btn{min-width:110px}
.wiz-step-panel{display:none;animation:fadeIn .18s ease-out}
.wiz-step-panel.active{display:block}
.wiz-draftbar{display:none;margin-top:10px;padding:10px 12px;border-radius:10px;background:rgba(255,193,7,.18);border:1px solid rgba(255,193,7,.35)}
.wiz-draftbar.show{display:block}
.wiz-error{border-color:rgba(220,53,69,.55)!important;outline:0;box-shadow:0 0 0 3px rgba(220,53,69,.12)!important}
.wiz-errtxt{color:#dc3545;font-size:12px;margin-top:6px}
@keyframes fadeIn{from{opacity:.25;transform:translateY(4px)}to{opacity:1;transform:translateY(0)}}
.wiz-hidden{display:none !important}

/* ==== Responsive + keep your original vibe ==== */
#invoice-form table{width:100% !important;max-width:1150px;margin:0 auto;border-collapse:separate;border-spacing:0 10px}
#invoice-form table tr{border-radius:12px;overflow:hidden}
#invoice-form table td{padding:10px 12px;vertical-align:top}
#invoice-form label{margin:0;font-weight:600}
#invoice-form input[type="text"],
#invoice-form input[type="date"],
#invoice-form input[type="number"],
#invoice-form select,
#invoice-form textarea{width:100%;max-width:100%;box-sizing:border-box}
#invoice-form textarea{min-height:70px}

/* Make the colored rows look like “cards” */
#invoice-form tr[bgcolor]{box-shadow:0 1px 0 rgba(0,0,0,.04), 0 6px 14px rgba(0,0,0,.06)}
#invoice-form tr[bgcolor]{background:#fff !important}
#invoice-form tr[bgcolor] td{background:transparent !important}


/* Wizard header - neutral (no red/yellow) */
.wiz-wrap{background:#fff}
.wiz-pill{background:#fff}
.wiz-pill.active{background:rgba(0,0,0,.04);border-color:var(--wiz-accent, rgba(0,0,0,.22))}
.wiz-pill.done{background:rgba(0,0,0,.02)}
.wiz-progress > div{background:var(--wiz-accent, rgba(0,0,0,.45))}
.wiz-draftbar{background:rgba(0,0,0,.03);border:1px solid rgba(0,0,0,.10)}
/* Better buttons on small screens */
@media (max-width: 992px){
  #invoice-form table{max-width:100%}
}
@media (max-width: 768px){
  .wiz-actions{justify-content:space-between}
  .wiz-actions .btn{flex:1 1 auto;min-width:0}
  /* turn table rows into responsive flex rows (without touching inputs) */
  #invoice-form table tr{display:flex;flex-wrap:wrap}
  #invoice-form table td{width:100%;padding:8px 10px}
  /* for typical 4-td rows: label + field + label + field */
  #invoice-form table tr td:nth-child(odd){padding-bottom:2px}
  #invoice-form table tr td:nth-child(even){padding-top:2px}
  /* keep textarea nicer when colspan exists */
  #invoice-form table td[colspan]{width:100%}
}


/* Pretty section titles inside tabs */
.wiz-headrow td{padding:0 !important}
.wiz-section-head{padding:14px 14px 10px;border-radius:12px;background:rgba(0,0,0,.02);border:1px solid rgba(0,0,0,.08)}
.wiz-kicker{font-size:11px;letter-spacing:.12em;text-transform:uppercase;opacity:.7;margin-bottom:6px}
.wiz-title{font-size:18px;font-weight:800;line-height:1.2;margin:0 0 4px}
.wiz-sub{font-size:13px;opacity:.75;margin:0}
#invoice-form h4{font-weight:800;letter-spacing:.02em}
#invoice-form tr[height] h4{margin:6px 0}


/* === UI polish to match your screenshot style === */
#invoice-form{
  font-family: system-ui,-apple-system,Segoe UI,Roboto,Ubuntu,Cantarell,Noto Sans,Arial,"Helvetica Neue",sans-serif;
}
#invoice-form table{color:#111;}
#invoice-form label{
  font-weight:700;
  font-size:13px;
  color:#111;
  letter-spacing:.01em;
}
#invoice-form td{font-size:14px;}
#invoice-form input[type="text"],
#invoice-form input[type="date"],
#invoice-form input[type="number"],
#invoice-form select,
#invoice-form textarea{
  font-size:14px;
  padding:10px 12px;
  border-radius:10px;
  border:1px solid rgba(0,0,0,.14);
  background:#fff;
}
#invoice-form input[type="text"]:focus,
#invoice-form input[type="date"]:focus,
#invoice-form input[type="number"]:focus,
#invoice-form select:focus,
#invoice-form textarea:focus{
  outline:0;
  border-color:rgba(0,0,0,.28);
  box-shadow:0 0 0 3px rgba(0,0,0,.06);
}

/* Section headings inside tabs: clean title + divider line */
#invoice-form table tr[height] td[colspan]{
  text-align:left !important;
  padding:14px 10px 6px !important;
}
#invoice-form table tr[height] td[colspan] h4{
  margin:0;
  font-size:16px;
  font-weight:800;
  letter-spacing:.01em;
  display:block;
  padding-bottom:10px;
}
#invoice-form table tr[height] td[colspan] h4:after{
  content:"";
  display:block;
  height:1px;
  background:rgba(0,0,0,.12);
  width:100%;
  margin-top:12px;
}

/* Card-like rows: tighter + modern */
#invoice-form tr[bgcolor]{
  border:1px solid rgba(0,0,0,.08);
  box-shadow:0 1px 0 rgba(0,0,0,.04), 0 8px 18px rgba(0,0,0,.05);
}
#invoice-form tr[bgcolor] td{padding:10px 12px;}

/* Wizard pills: a bit cleaner */
.wiz-pill{font-weight:700}
.wiz-pill span{font-weight:700}
.wiz-pill strong{font-weight:900}


/* === Input focus + filled highlight (non-invasive) === */
#invoice-form input[type="text"],
#invoice-form input[type="number"],
#invoice-form input[type="email"],
#invoice-form input[type="tel"],
#invoice-form input[type="date"],
#invoice-form input[type="search"],
#invoice-form input[type="url"],
#invoice-form input[type="password"],
#invoice-form select,
#invoice-form textarea,
#invoice-form .form-control{
  background:#fff;
  border:1px solid #dcdcdc;
  transition: background-color .18s ease, border-color .18s ease, box-shadow .18s ease;
}

/* Fix: selected text not visible (force readable text colors) */
#invoice-form input[type="text"],
#invoice-form input[type="number"],
#invoice-form input[type="email"],
#invoice-form input[type="tel"],
#invoice-form input[type="date"],
#invoice-form input[type="search"],
#invoice-form input[type="url"],
#invoice-form input[type="password"],
#invoice-form select,
#invoice-form textarea,
#invoice-form .form-control{
  color:#111 !important;
}

/* Dropdown options readable too */
#invoice-form select option{
  color:#111;
  background:#fff;
}

#invoice-form input[type="text"]:focus,
#invoice-form input[type="number"]:focus,
#invoice-form input[type="email"]:focus,
#invoice-form input[type="tel"]:focus,
#invoice-form input[type="date"]:focus,
#invoice-form input[type="search"]:focus,
#invoice-form input[type="url"]:focus,
#invoice-form input[type="password"]:focus,
#invoice-form select:focus,
#invoice-form textarea:focus,
#invoice-form .form-control:focus{
  background:#e9f5ff;
  border-color:#3b82f6;
  box-shadow:0 0 0 2px rgba(59,130,246,.15);
  outline:none;
}

#invoice-form input.is-filled,
#invoice-form select.is-filled,
#invoice-form textarea.is-filled,
#invoice-form .form-control.is-filled{
  background:#f0f9ff;
  border-color:#60a5fa;
}

/* === Fix: all dropdown/list values must be visible (bootstrap-select / bg-warning overrides) === */
#invoice-form .bg-warning,
#invoice-form tr[bgcolor="#fad7a0"] select,
#invoice-form tr[bgcolor="#fad7a0"] input,
#invoice-form tr[bgcolor="#fad7a0"] textarea{
  background:#fff !important;
  color:#111 !important;
}

/* If bootstrap-select is used (data-live-search), it renders a button. Make it readable. */
#invoice-form .bootstrap-select > .dropdown-toggle{
  background:#fff !important;
  color:#111 !important;
  border:1px solid #dcdcdc !important;
  border-radius:10px !important;
  padding:10px 12px !important;
  box-shadow:none !important;
}
#invoice-form .bootstrap-select > .dropdown-toggle:focus,
#invoice-form .bootstrap-select > .dropdown-toggle:active{
  outline:none !important;
  border-color:#3b82f6 !important;
  box-shadow:0 0 0 2px rgba(59,130,246,.15) !important;
}

/* Selected text inside bootstrap-select */
#invoice-form .bootstrap-select .filter-option,
#invoice-form .bootstrap-select .filter-option-inner,
#invoice-form .bootstrap-select .filter-option-inner-inner{
  color:#111 !important;
}

/* Dropdown menu items readable */
#invoice-form .bootstrap-select .dropdown-menu,
#invoice-form .bootstrap-select .dropdown-menu inner{
  background:#fff !important;
}
#invoice-form .bootstrap-select .dropdown-menu li a,
#invoice-form .bootstrap-select .dropdown-menu li a span.text{
  color:#111 !important;
}

/* Datalist suggestions: keep input readable */
#invoice-form input[list]{
  color:#111 !important;
}

.hint {
  display: none;
  color: #6b7280;
  font-size: 12px;
  margin-top: 4px;
}
input:focus + .hint {
  display: block;
}

.cap-methods-row{
  display:grid;
  grid-template-columns: repeat(3, minmax(320px, 1fr));
  gap:14px;
  margin-top:14px;
  align-items:stretch;
}

.cap-card{
  display:grid;
  grid-template-columns: 20px 1fr 110px;
  align-items:center;
  column-gap:10px;
  padding:12px 14px;
  border:1px solid #d9d9d9;
  border-radius:12px;
  background:#fff;
  margin:0;
  cursor:pointer;
  min-height:56px;
  box-sizing:border-box;
}

.cap-card input[type="radio"]{
  margin:0;
  justify-self:center;
}

.cap-title{
  font-size:14px;
  font-weight:600;
  color:#222;
  white-space:normal;      /* nowrap биш */
  line-height:1.2;
  overflow:visible;
}

.cap-rate-box{
  width:110px;
  height:36px;
  padding:6px 10px;
  border:1px solid #cfd6df;
  border-radius:10px;
  background:#f8fafc;
  text-align:center;
  font-weight:700;
  font-size:14px;
  box-sizing:border-box;
}

@media (max-width: 1150px){
  .cap-methods-row{
    grid-template-columns:1fr;
  }
}
</style>

 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="js/jquery-3.5.1.js"></script>
  <script src="js/jquery.dataTables.min.js"></script>
  <link href="css/jquery.dataTables.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/income_approach.css">
<script src="js/income_approach.js"></script>
<script src="js/market_approach.js"></script>
    <link rel="stylesheet" href="./style.css">
	<link rel="stylesheet" href="css/final_step.css?v=2">
<?php include('container.php');?>

<div class="container">
		<div class="load-animate animated fadeInUp">
			<div class="row">
				<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
					<h4 class="title">Үнэлгээний тайлан гаргах</h4>
					<?php include('menu.php');?>	
				</div>		    		
			</div>

	<form action="" id="invoice-form" method="post" enctype="multipart/form-data" class="invoice-form" role="form" novalidate="">
  <!-- Wizard header -->
  <div class="wiz-wrap" id="wizWrap">
    <div class="wiz-top">
      <div class="wiz-steps" id="wizSteps">
        <div class="wiz-pill" data-step="1"><strong>1</strong><span>Ерөнхий</span></div>
        <div class="wiz-pill" data-step="2"><strong>2</strong><span>Дэлгэрэнгүй</span></div>
        <div class="wiz-pill" data-step="3"><strong>3</strong><span>Өртгийн хандлага</span></div>
        <div class="wiz-pill" data-step="4"><strong>4</strong><span>Орлогын хандлага</span></div>
        <div class="wiz-pill" data-step="5"><strong>5</strong><span>Зах зээлийн хандлага</span></div>
        <div class="wiz-pill" data-step="6"><strong>6</strong><span>Дүн / Хадгалах</span></div>
      </div>
	  <div class="wiz-progress" aria-hidden="true"><div id="wizBar"></div></div>
    </div>
    <div class="wiz-draftbar" id="wizDraft">
      <div style="display:flex;gap:10px;align-items:center;justify-content:space-between;flex-wrap:wrap">
        <div>Өмнөх <b>ажил</b> олдлоо. Сэргээх үү?</div>
        <div style="display:flex;gap:8px;flex-wrap:wrap">
          <button type="button" class="btn btn-primary btn-sm" id="wizRestore">Ажлын файл сэргээх</button>
          <button type="button" class="btn btn-default btn-sm" id="wizDiscard">Хаях</button>
        </div>
      </div>
    </div>
    <div class="wiz-actions">
      <button type="button" class="btn btn-default" id="wizBack">Буцах</button>
      <button type="button" class="btn btn-primary" id="wizNext">Дараах</button>
      <button type="button" class="btn btn-success" id="wizSave">Хадгалах</button>
    </div>
  </div>
 
	<table style="width:70%">
<tbody class="wiz-step-panel" data-step="1">
		
			<tr height = 30px><td colspan="2" align="center";> <h4>Хөрөнгийн ерөнхий мэдээлэл</h4></td></tr>
	<tr>
	<tr bgcolor="#D6EEEE">
    <td><label>Тайлангийн огноо:</label></td> <td><input tabindex="1" type="date" value="<?php echo date('Y-m-d'); ?>" id="date" name="date" required/></td> <td><label>Биет үзлэг хийсэн өдөр:</label></td> <td><input tabindex="11" type="date" value="<?php echo date('Y-m-d'); ?>" name="ungu" id="ungu" required/></td>
    <td><label>Үнэлгээний өдөр /Мэдэгдэл гардан авсан огноо/:</label></td> <td><input tabindex="1" type="date" value="<?php echo date('Y-m-d'); ?>" id="date" name="date" required/></td>
	</tr>
		<tr bgcolor="#D6EEEE">
	<td><label>Захиалагч:</label></td>
			<td><input id="zahialagch" type="text" name="zahialagch" tabindex="7"> </td>
	<td><label>Захиалагчийг төлөөлж:</label></td> <td><input tabindex="17" type="text" name="tuluulugch" id="tuluulugch" /></td>
	<td><label>Өмчлөгчийн овог нэр:</label></td> <td><input tabindex="13" type="text" name="companyName" id="companyName" hurungucomplete="off" required></td>
	</tr>
	<tr bgcolor="#D6EEEE">
	<td><label>ҮХХ-ийн дугаар:</label></td> <td><input tabindex="12" type="text" name="aral" id="aral"/></td>
					<td><label>Зориулалт:</label></td> 
					<td>
					<select class="slct"  type="text" name="zzune" tabindex="16" id="zoriulalt"> 
					<option value="орон сууцны">сонгох</option>
					<option value="орон сууцны">орон сууцны</option>
					<option value="үйлчилгээний">үйлчилгээний</option> 
					<option value="үйлдвэрлэлийн">үйлдвэрлэлийн</option> 
					<option value="үйлдвэр, үйлчилгээний">үйлдвэр, үйлчилгээний</option> 
					<option value="автозогсоолын">автозогсоолын</option>
					<option value="гаражийн">гаражийн</option> 
					<option value="гаражийн">хувийн сууц, гараж</option>
					<option value="гаражийн">хувийн сууц</option>
					<option value="гаражийн">амины сууц</option> 						
					<option value="бусад">бусад</option> 						
					</select>
					</td>
					<td><label>Талбайн хэмжээ:</label></td> <td><input class="only-float" tabindex="15" type="text" name="utas" id="utas" data-sync="B1,ma_g" required/></td>
	</tr>
	<tr bgcolor="#D6EEEE">

	</tr>
	<tr bgcolor="#D6EEEE">
					<td><label>ҮХХ-ийн хаяг:</label></td> <td><input tabindex="14" type="text" name="address" id="address" required/></td>
					<td><label>УБГ-ний огноо:</label></td> <td><input tabindex="18" type="date" value="<?php echo date('Y-m-d'); ?>" name="hariutsagch" id="hariutsagch" /></td>
					<td><label>Ашиглалтад орсон он:</label></td><td><input type="text" name="uild_on" id="uild_on" placeholder="Жишээ: 2020" maxlength="4" inputmode="numeric" data-sync="A" /></td>
	</tr>
	<tr bgcolor="#D6EEEE">

	<td><label>Үнэлгээний зорилго:</label></td> 
				<td>
					<select class="slct"  type="text" tabindex="19" name="or_on" id="or_on" /> 
					<option value="орон сууцны">сонгох</option>
					<option value="Захзээл">Хөрөнгийн зах зээлийн үнэлгээ тогтоох зорилгоор</option>
					<option value="Худалдах">Худалдан борлуулах зорилгоор</option>
					<option value="Санхүү татварын">Санхүү татварын зорилгоор</option> 
					<option value="Маргаан шийдвэрлэх">Маргаан шийдвэрлэх зорилгоор</option> 
					<option value="Зээлийн барьцаа хөрөнгийн">Зээлийн барьцаа хөрөнгийн зорилгоор</option> 
					</select>
				</td>

		<td><label>Үнэ цэнийн суурь:</label></td> 
				<td>
					<select class="slct"  type="text" tabindex="19" name="or_on" id="or_on" /> 
					<option value="орон сууцны">сонгох</option>
					<option value="зэх зээл">Зах зээлийн үнэ цэнэ</option>
					<option value="зах зээлийн бодит">Зах зээлийн бодит үнэ цэнэ</option>
					<option value="бодит">Бодит үнэ цэнэ</option> 
					<option value="тэгш шудрага">Тэгш шудрага үнэ цэнэ</option> 
					<option value="Түрээс">Түрээсийн үнэ цэнэ</option> 
					</select>
				</td>
	<td><label>Чанар байдал:</label></td>
					<td>
					<select class="slct"  type="text" tabindex="6"> 
					<option value="орон сууцны">сонгох</option>
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
		</tr>
		<tr bgcolor="#D6EEEE">
					<td><label>Өрөөний тоо/хуваалт:</label></td>
					<td colspan="3"><textarea tabindex="20" class="form-control txt" rows="2" name="akt" id="akt" style="resize:vertical; width:98%; margin:14px">Зочны болон гал тогооны өрөө ...</textarea></td>
		</tr>
		
		
		</tbody>
<tbody class="wiz-step-panel" data-step="2">
<tr height = 60px><td colspan="2" align="center";> <h4>Хөрөнгийн дэлгэрэнгүй мэдээлэл</h4></td></tr>
		<tr bgcolor="#fad7a0">
		<td><label>Хөрөнгийн ангилал:</label></td>
		<td>
		<div>
		    <select tabindex="2" name="category_item"  id="category_item" class="ml-sm-5 bg-warning"  data-live-search="true" title="сонгох" onchange="myFunction()">

            </select><input name="uname" id="uname" type="hidden" value="">
			<br>
		</div>
		<!--
		<div class="example"><input type="text" value="" style="width: 150px;"/><button type="button" data-toggle="modal" data-target="#myModal"><i class="fa fa-search"></i></button></div>
		-->
		</td>
		
			<td><label>Нэгжийн үнэлгээ:</label></td>
	<td>
	          <div>
            <select tabindex="3" name="sub_category_item"  id="sub_category_item" class="p-0 bg-warning" data-live-search="true" title="сонгох" onchange="myFunction1()">

            </select></select><input name="uname1" id="uname1" data-sync="G" type="hidden" value="" required>
          </div>
	<!--
	<div class="example"><input type="text" value="" style="width: 150px;"/><button id="myBtn"><i class="fa fa-search"></i></button></div>
	-->
	</td>
	</tr>

	<tr bgcolor="#fad7a0">
		<td><label>Норматив хугацаа:</label></td>
					<td>
					<select class="slct"  type="text" name="zereg" tabindex="8" data-sync="Tnorm"> 
					<option value="орон сууцны">сонгох</option>
					<option value="90">90</option> 
					<option value="85">85</option> 
					<option value="80">80</option> 
					<option value="75">75</option> 
					<option value="70">70</option> 
					<option value="65">65</option>
					<option value="60">60</option> 
					<option value="55">55</option> 	
					<option value="50">50</option> 
					<option value="45">45</option> 
					<option value="40">40</option> 
					<option value="35">35</option>
					<option value="30">30</option> 
					<option value="25">25</option> 
					<option value="20">20</option> 	
					<option value="15">15</option> 	
					<option value="10">10</option> 
					<option value="5">5</option> 					
					</select>
					</td>
		<td><label>Үнийн өсөлтийн индекс:</label></td><td><input tabindex="4" type="text" class="only-float" name="ulsiin_dugaar" id="ulsiin_dugaar" data-sync="I1" /></td>

	</tr>

		<tr bgcolor="#fad7a0">

					<td><label>Талбайн итгэлцүүр:</label></td>
					
					<td><p><select class="slct"  type="number" name="turul" tabindex="9" data-sync="B2"> 
					<option value="орон сууцны">сонгох</option>
					<option value="1.1">1.1</option> 
					<option value="0.95">0.95</option> 
					<option value="1">1</option> 
					</select></p></td>
		<td><label>Хөрөнгийн хийцлэл:</label></td> 
		<div class="form-group">
			<td><input tabindex="13" type="text" name="hiits" id="hiits" hurungucomplete="off" placeholder="Бүрэн цутгамал гм.." required></td>
			  <small class="hint">Жишээ: Бүрэн цутгамал</small>
		</div>
	</tr>

	<tr bgcolor="#fad7a0">
	<td><label>Үнэлгээчин:</label></td>
				<td>
				<select type="text" class="slct"  name="unelgeechin" tabindex="10">
				<option></option>
				<?php while($row2 = mysqli_fetch_array($result2)):;?>
				<option value="<?php echo $row2[2];?>"><?php echo $row2[2];?></option>
				<?php endwhile;?>
				</select>
				</td>
	<td><label>Туслах үнэлгээчин:</label></td>			
				<td>
				<select tabindex="20" type="text" class="slct"  name="tuslah">
				<option></option>
				<?php while($row1 = mysqli_fetch_array($result1)):;?>
				<option value="<?php echo $row1[2];?>"><?php echo $row1[2];?></option>
				<?php endwhile;?>
				</select>
				</td>
				
	</tr>
	</tbody>
<tbody class="wiz-step-panel" data-step="3">
	<tr class="wiz-headrow"><td colspan="4">
		<div class="wiz-section-head">
			<div class="wiz-kicker">Алхам 3</div>
			<div class="wiz-title"></div>

<?php include __DIR__ . '/valuation_table_block.php'; ?>


		</div>
	</td></tr>
	

	
</tbody>
<tbody class="wiz-step-panel" data-step="4">
  <tr class="wiz-headrow">
    <td colspan="4">
      <div class="wiz-section-head">
        <div class="wiz-kicker">Алхам 4</div>
        <div class="wiz-title">Орлогын хандлага</div>
        <div class="wiz-sub">Түрээсийн орлогын харьцуулалтын мэдээлэл</div>
		
		<div style="margin-top:15px; border-top:1px solid #e5e7eb; padding-top:12px;">

		<label style="margin-right:15px;">
		Орлогын хандлага ашиглах эсэх
		<input type="checkbox" id="use_income_method">
		</label>

<label style="margin-right:10px;">
Нөхөлтийн хувь (%)
<input type="number"
       id="return_rate"
       class="form-control"
       style="width:90px; display:inline-block; margin-left:6px;"
       step="0.01">
</label>

<label>
Эрсдэлгүй хувь (%)
<input type="number"
       id="risk_free_rate"
       class="form-control"
       style="width:90px; display:inline-block; margin-left:6px;"
       step="0.01">
</label>

</div>
		
      </div>
    </td>
  </tr>

  <tr bgcolor="#D6EEEE">
    <td colspan="4" style="padding:12px 14px">
      <div class="row">
        <div class="col-xs-12">
<table class="table table-bordered table-hover" id="rentTable">
<thead>
<tr>
<th><input id="checkAllRent" type="checkbox" style="width:100%;"></th>
<th width="15%">Фото зураг</th>
<th width="20%">Хаяг байршил</th>
<th width="12%">Түрээсийн үнэ</th>
<th width="10%">Талбай</th>
<th width="14%">Нэгжийн үнэ</th>
<th width="9%">Ач холбогдол</th>
<th width="9%">Тохируулагдсан нэгжийн үнэ</th>
<th width="13%">Эх сурвалж</th>
</tr>
</thead>

<tbody id="rentBody">

<tr class="rent-row">
<td><input class="itemRowRent" type="checkbox" style="width:100%;"></td>

<td>
  <div class="rent-upload-box">
    <input type="file"
           name="rent_productCode[]"
           class="rent-image-input"
           id="rent_img_1"
           accept="image/*"
           style="display:none">

    <label for="rent_img_1" class="rent-upload-btn">Зураг сонгох</label>

    <img class="rent-thumb-preview"
         src=""
         style="display:none; max-width:70px; max-height:70px; border:1px solid #ddd; border-radius:6px;">
  </div>
</td>

<td><input type="text" name="rent_address[]" class="form-control"></td>

<td><input type="number" name="rent_price[]" class="form-control rent-price"></td>

<td><input type="number" name="rent_area[]" class="form-control rent-area"></td>

<td bgcolor="#eee"><input type="number" name="rent_unit_price[]" class="form-control rent-unit-price" readonly></td>

<td bgcolor="#eee"><input type="number" name="rent_weight[]" class="form-control rent-weight" value="1"></td>

<td bgcolor="#eee"><input type="number" name="rent_adjusted_unit_price[]" class="form-control rent-adjusted-unit-price" readonly></td>

<td bgcolor="#eee"><input type="text" name="rent_source[]" class="form-control"></td>

</tr>

</tbody>
</table>
        </div>
      </div>

      <div class="row">
        <div class="col-xs-4 col-sm-3 col-md-3 col-lg-3">
          <button class="btn btn-danger" id="removeRentRows" type="button">- Мөр хасах</button>
          <button class="btn btn-success" id="addRentRows" type="button">+ Мөр нэмэх</button>
        </div>
      </div>
	  				<div style="display:flex; justify-content:flex-end; gap:18px; margin-top:10px; flex-wrap:wrap;">
				<label>Дундаж: <span id="rent_mean">0</span></label>
				<label>Медиан: <span id="rent_median">0</span></label>
				<label>Std Dev: <span id="rent_std">0</span></label>
				<label>Outlier: <span id="rent_outlier_count">0</span></label>
				</div>
				<div><br></br></div>
				
<div class="cap-methods-row">
  <label class="cap-card">
    <input type="radio" name="cap_method" class="cap-method-radio" value="ring" checked>
    <span class="cap-title">Ринг капиталжуулах хувь</span>
    <input type="text" id="ring_cap_rate" class="cap-rate-box" readonly>
  </label>

  <label class="cap-card">
    <input type="radio" name="cap_method" class="cap-method-radio" value="inwood" checked>
    <span class="cap-title">Инвуд капиталжуулах хувь</span>
    <input type="text" id="inwood_cap_rate" class="cap-rate-box" readonly>
  </label>

  <label class="cap-card">
    <input type="radio" name="cap_method" class="cap-method-radio" value="hoskold">
    <span class="cap-title">Хосколд капиталжуулах хувь</span>
    <input type="text" id="hoskold_cap_rate" class="cap-rate-box" readonly>
  </label>
</div>
				<div><br></br></div>
				<div>
				<?php include __DIR__ . '/income_approach_block.php'; ?>
				</div>
    </td>
	
	
  </tr>
</tbody>

</table>
            <br><br>
			
			<input id="currency" type="hidden" value="$">
			<div class="row" style="display: none;">

				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
					<?php echo $_SESSION['user']; ?><br>	
					<?php echo $_SESSION['address']; ?><br>	
					<?php echo $_SESSION['mobile']; ?><br>
					<?php echo $_SESSION['email']; ?><br>	
				</div> 
			<!--
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 pull-right">
					<h3>To,</h3>
					<div class="form-group">
						<input type="text" class="form-control" name="companyName" id="companyName" placeholder="Company Name" hurungucomplete="off">
					</div>
					<div class="form-group">
						<textarea class="form-control" rows="3" name="address" id="address" placeholder="Your Address"></textarea>
					</div>
					
				</div>
				-->
				<br>
				
			</div>
			<div class="wiz-step-panel" data-step="5">
  <div class="wiz-section-head" style="margin:0 0 12px">
    <div class="wiz-kicker">Алхам 5</div>
    <div class="wiz-title">Зах зээлийн хандлага</div>
    <div class="wiz-sub">Тооцоолол</div>
  </div>
  
<link rel="stylesheet" href="css/calculator.css">

<div class="report-section">
  <?php require_once __DIR__ . '/market_approach.php'; ?>
</div>

<script src="js/calculator.js"></script>
<script src="js/market_approach_calc.js"></script>

			</div>
<div class="wiz-step-panel" data-step="6">
  <div class="wiz-section-head" style="margin:0 0 12px">
    <div class="wiz-kicker">Алхам 6</div>
    <div class="wiz-title">Дүн / Хадгалах</div>
    <div class="wiz-sub">Тооцоолол, тэмдэглэл, эцсийн хадгалалт</div>
	
					<div>
				<?php include __DIR__ . '/final_step.php'; ?>
				</div>
	
  </div>
			<div class="clearfix"></div>		      	
        </div>
	</form>			
</div>
</div>	
<?php include('footer.php');?>
<script>
(function(){
  function getVal(el){
    if(!el) return "";
    if(el.type === "checkbox") return el.checked ? "1" : "0";
    if(el.type === "radio") return el.checked ? el.value : "";
    return el.value ?? "";
  }

  function setVal(el, v){
    if(!el) return;
    if(el.tagName === "SELECT"){
      // target select дээр option байхгүй бол зүгээр value тавина
      el.value = v;
      el.dispatchEvent(new Event("change", {bubbles:true}));
      return;
    }
    el.value = v;
    el.dispatchEvent(new Event("input", {bubbles:true}));
    el.dispatchEvent(new Event("change", {bubbles:true}));
  }

  function syncOne(src){
    const targetId = src.getAttribute("data-sync");
    if(!targetId) return;

    const target = document.getElementById(targetId);
    if(!target) return;

    setVal(target, getVal(src));
  }

  function bind(){
    document.querySelectorAll("[data-sync]").forEach(src=>{
      if(src.dataset.syncBound === "1") return;
      src.dataset.syncBound = "1";

      // input + select дээр заавал change сонсоно
      src.addEventListener("change", ()=>syncOne(src), true);
      src.addEventListener("input",  ()=>syncOne(src), true);
      src.addEventListener("keyup",  ()=>syncOne(src), true);
    });

    // анхны sync
    document.querySelectorAll("[data-sync]").forEach(syncOne);
  }

  function init(){
    bind();

    // Tab/DOM өөрчлөгдөх үед target гарч ирвэл автоматаар sync
    try{
      const mo = new MutationObserver(()=>bind());
      mo.observe(document.documentElement, {subtree:true, childList:true});
    }catch(e){}

    // bootstrap-select байвал тусгай эвент сонсоно
    try{
      if(window.jQuery){
        jQuery(document).on("changed.bs.select", "[data-sync]", function(){
          syncOne(this);
        });
      }
    }catch(e){}
  }

  if(document.readyState==="loading") document.addEventListener("DOMContentLoaded", init);
  else init();
})();
</script>


<script>
$(document).ready(function(){
 $('#gsearchsimple').keyup(function(){
  var query = $('#gsearchsimple').val();
  $('#detail').html('');
  $('.list-group').css('display', 'block');
  if(query.length == 2)
  {
   $.ajax({
    url:"fetch1.php",
    method:"POST",
    data:{query:query},
    success:function(data)
    {
     $('.list-group').html(data);
    }
   })
  }
  if(query.length == 0)
  {
   $('.list-group').css('display', 'none');
  }
 });

 $('#localSearchSimple').jsLocalSearch({
  action:"Show",
  html_search:true,
  mark_text:"marktext"
 });

 $(document).on('click', '.gsearch', function(){
  var ner = $(this).text();
  $('#gsearchsimple').val(ner);
  $('.list-group').css('display', 'none');
  $.ajax({
   url:"fetch1.php",
   method:"POST",
   data:{ner:ner},
   success:function(data)
   {
    $('#detail').html(data);
   }
  })
 });
});
</script>

<script>
$("form").bind("keypress", function (e) {
    if (e.keyCode == 13) {
        return false;
    }
});
</script>

<script>
function myFunction(e) {
   var d=document.getElementById("category_item");
   var displaytext=d.options[d.selectedIndex].text;
   document.getElementById("uname").value=displaytext; 
}
</script>

<script>
function myFunction1() {
  var d = document.getElementById("sub_category_item");
  var target = document.getElementById("uname1");
  if (!d || !target) return;

  var opt = d.options[d.selectedIndex];
  var text = opt ? opt.text : "";

  // 1054 /A/ , 2045.64 /B/ , 1,234.5 /C/ зэрэгээс тоог нь салгаж авна
  var match = String(text).match(/[\d,.]+/);

  if (!match) {
    target.value = "";
    target.dispatchEvent(new Event("input", { bubbles: true }));
    target.dispatchEvent(new Event("change", { bubbles: true }));
    return;
  }

  var num = parseFloat(match[0].replace(/,/g, ""));
  if (isNaN(num)) {
    target.value = "";
  } else {
    target.value = String(Math.round(num * 1000)); // hidden input тул comma хийхгүй
  }

  target.dispatchEvent(new Event("input", { bubbles: true }));
  target.dispatchEvent(new Event("change", { bubbles: true }));
  document.dispatchEvent(new Event("valuation:recalc"));
}
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


<script>
(function(){
  var form = document.getElementById('invoice-form');
  if(!form) return;

  var KEY = 'invoiceDraft_v1';
  var current = 1;
  var total = 0; // will be set after pills are collected

  var pills = Array.prototype.slice.call(document.querySelectorAll('#wizSteps .wiz-pill'));
  var total = pills.length || 1;
  var panels = Array.prototype.slice.call(document.querySelectorAll('.wiz-step-panel[data-step]'));
  var bar = document.getElementById('wizBar');
  var backBtn = document.getElementById('wizBack');
  var nextBtn = document.getElementById('wizNext');
  var saveBtn = document.getElementById('wizSave');
  var draftBar = document.getElementById('wizDraft');
  var restoreBtn = document.getElementById('wizRestore');
  var discardBtn = document.getElementById('wizDiscard');

  // Sync progress/active colors with the “Дараах” button color
  try{
    var wrap = document.getElementById('wizWrap');
    if(wrap && nextBtn){
      var c = window.getComputedStyle(nextBtn).backgroundColor;
      if(c) wrap.style.setProperty('--wiz-accent', c);
    }
  }catch(e){}


  function setProgress(){
    var pct = (total<=1) ? 100 : Math.round((current-1) * 100 / (total-1));
    if(bar) bar.style.width = pct + '%';
  }

  function setActive(){
    panels.forEach(function(p){
      var s = Number(p.getAttribute('data-step'));
      p.classList.toggle('active', s === current);
    });
    pills.forEach(function(p){
      var s = Number(p.getAttribute('data-step'));
      p.classList.toggle('active', s === current);
      p.classList.toggle('done', s < current);
    });
    backBtn.style.display = (current === 1) ? 'none' : '';
    nextBtn.style.display = (current === total) ? 'none' : '';
    saveBtn.style.display = (current === total) ? '' : 'none';
    setProgress();
    window.scrollTo({top:0, behavior:'smooth'});
  }

  function visibleRequiredIn(panel){
    var required = panel.querySelectorAll('[required]');
    var list = [];
    required.forEach(function(el){
      if(el.disabled) return;
      // ignore hidden inputs & hidden via display:none
      if(el.type === 'hidden') return;
      var style = window.getComputedStyle(el);
      if(style.display === 'none' || style.visibility === 'hidden') return;
      // in case parent hidden
      if(el.offsetParent === null) return;
      list.push(el);
    });
    return list;
  }

  function clearErrors(panel){
    panel.querySelectorAll('.wiz-error').forEach(function(el){ el.classList.remove('wiz-error'); });
    panel.querySelectorAll('.wiz-errtxt').forEach(function(el){ el.parentNode.removeChild(el); });
  }

  function showError(el, msg){
    el.classList.add('wiz-error');
    var small = document.createElement('div');
    small.className = 'wiz-errtxt';
    small.textContent = msg || 'Заавал бөглөнө';
    // try to place under input
    if(el.parentNode) el.parentNode.appendChild(small);
  }

  function validateStep(step){
    var panel = document.querySelector('.wiz-step-panel[data-step="'+step+'"]');
    if(!panel) return true;

    clearErrors(panel);

    var ok = true;
    visibleRequiredIn(panel).forEach(function(el){
      var val = (el.value || '').trim();
      if(el.tagName === 'SELECT'){
        if(!val) { ok=false; showError(el); }
      } else if(!val){
        ok=false; showError(el);
      }
    });

    // Step 3: at least 1 itemRow should have productCode or anything filled (soft check)
    if(step === 5){
      var any = false;
      var pcs = panel.querySelectorAll('input[name="productCode[]"]');
      pcs.forEach(function(i){ if((i.value||'').trim()) any = true; });
      if(!any && pcs.length){
        ok = false;
        showError(pcs[0], 'Дор хаяж 1 мөр бөглөнө');
      }
    }

    if(!ok){
      var first = panel.querySelector('.wiz-error');
      if(first) first.scrollIntoView({behavior:'smooth', block:'center'});
    }
    return ok;
  }

  function serializeForm(){
    var data = {};
    var els = form.querySelectorAll('input, select, textarea');
    els.forEach(function(el){
      if(!el.name) return;
      if(el.type === 'password') return;
      if(el.type === 'checkbox'){
        data[el.name] = el.checked ? '1' : '';
        return;
      }
      if(el.type === 'radio'){
        if(el.checked) data[el.name] = el.value;
        return;
      }
      // arrays (name ends with [])
      if(el.name.endsWith('[]')){
        if(!data[el.name]) data[el.name] = [];
        data[el.name].push(el.value);
      } else {
        data[el.name] = el.value;
      }
    });
    return data;
  }

  function applyDraft(d){
    var els = form.querySelectorAll('input, select, textarea');
    els.forEach(function(el){
      if(!el.name) return;
      if(el.type === 'password') return;
      var v = d[el.name];
      if(typeof v === 'undefined') return;

      if(el.type === 'checkbox'){
        el.checked = (v === '1' || v === true);
        return;
      }
      if(el.type === 'radio'){
        el.checked = (el.value === v);
        return;
      }
      if(el.name.endsWith('[]') && Array.isArray(v)){
        // find index by order
        var name = el.name;
        var all = Array.prototype.slice.call(form.querySelectorAll('[name="'+CSS.escape(name)+'"]'));
        all.forEach(function(one, idx){
          if(typeof v[idx] !== 'undefined') one.value = v[idx];
        });
        return;
      }
      el.value = v;
    });
    // trigger keyup so totals recalc if existing scripts rely on it
    var e = document.createEvent('Event');
    e.initEvent('keyup', true, true);
    form.dispatchEvent(e);
  }

  var saveTimer = null;
  function scheduleDraftSave(){
    clearTimeout(saveTimer);
    saveTimer = setTimeout(function(){
      try{
        localStorage.setItem(KEY, JSON.stringify({t: Date.now(), data: serializeForm()}));
      }catch(e){}
    }, 400);
  }

  form.addEventListener('input', scheduleDraftSave);
  form.addEventListener('change', scheduleDraftSave);

  // Draft detection
  try{
    var raw = localStorage.getItem(KEY);
    if(raw){
      draftBar.classList.add('show');
      restoreBtn.addEventListener('click', function(){
        try{
          var obj = JSON.parse(raw);
          if(obj && obj.data) applyDraft(obj.data);
          localStorage.removeItem(KEY);
          draftBar.classList.remove('show');
        }catch(e){}
      });
      discardBtn.addEventListener('click', function(){
        localStorage.removeItem(KEY);
        draftBar.classList.remove('show');
      });
    }
  }catch(e){}

  backBtn.addEventListener('click', function(){
    if(current > 1){ current--; setActive(); }
  });

  nextBtn.addEventListener('click', function(){
    if(!validateStep(current)) return;
    if(current < total){ current++; setActive(); }
  });

  pills.forEach(function(p){
    p.addEventListener('click', function(){
      var target = Number(p.getAttribute('data-step'));
      if(target < current){
        current = target; setActive(); return;
      }
      // moving forward: validate each step in between
      for(var s=current; s<target; s++){
        if(!validateStep(s)) return;
      }
      current = target; setActive();
    });
  });

  saveBtn.addEventListener('click', function(){
    // validate all steps
    for(var s=1; s<=total; s++){
      if(!validateStep(s)){ current = s; setActive(); return; }
    }
    // clear draft on successful submit
    try{ localStorage.removeItem(KEY); }catch(e){}
    var submit = document.getElementById('invoiceSubmit');
    if(submit) submit.click();
    else form.submit();
  });

  // init
  setActive();
})();
</script>


<script>
/* === Input filled state (adds .is-filled when value is not empty) === */
document.addEventListener("DOMContentLoaded", function () {
  var scope = document.getElementById("invoice-form");
  if(!scope) return;

  var els = scope.querySelectorAll('input, select, textarea, .form-control');
  els.forEach(function(el){
    // ignore hidden/submit/button
    var tag = (el.tagName || '').toLowerCase();
    var type = (el.getAttribute && (el.getAttribute('type') || '')).toLowerCase();
    if(tag === 'input' && ['hidden','submit','button','reset','file'].includes(type)) return;

    function sync(){
      var v = (el.value || '').toString().trim();
      if(v !== '') el.classList.add('is-filled');
      else el.classList.remove('is-filled');
    }

    sync();
    el.addEventListener('input', sync);
    el.addEventListener('change', sync);
  });
});
</script>

<script>
(function(){
  function wire(){
    var el = document.getElementById("uild_on");
    if(!el) return;

    el.addEventListener("input", function(){
      this.value = (this.value || "").replace(/\D+/g, "").slice(0, 4);
    });

    el.addEventListener("blur", function(){
      if(!this.value) return;
      var y = parseInt(this.value, 10);
      if(isNaN(y)) { this.value = ""; return; }
      if(y < 1900) y = 1900;
      var maxY = new Date().getFullYear();
      if(y > maxY) y = maxY;
      this.value = String(y);
    });
  }

  if(document.readyState === "loading") document.addEventListener("DOMContentLoaded", wire);
  else wire();
})();
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {

  function sanitizeInt(v){
    return (v || "").replace(/[^\d]/g, "");
  }

  function sanitizeFloat(v){
    v = (v || "").replace(/\s+/g, "");

    // зөвхөн тоо + . , үлдээнэ
    v = v.replace(/[^\d\.,]/g, "");

    // , → . болгож нэг стандарт болгоно
    v = v.replace(/,/g, ".");

    // эхний цэгийг үлдээгээд бусдыг хасна
    const parts = v.split(".");
    if (parts.length > 2) {
      v = parts[0] + "." + parts.slice(1).join("");
    }

    // эхэнд олон 0-ийг "0" болгож цэгтэй байвал зөвшөөрнө
    // (ж: 00012.3 -> 12.3, 00.5 -> 0.5)
    if (v.startsWith(".")) v = "0" + v;

    return v;
  }

  function bind(el, sanitizer){
    el.addEventListener("input", function(){
      this.value = sanitizer(this.value);
    });

    el.addEventListener("paste", function(e){
      e.preventDefault();
      const text = (e.clipboardData || window.clipboardData).getData("text");
      this.value = sanitizer(text);
    });
  }

  document.querySelectorAll(".only-int").forEach(el => bind(el, sanitizeInt));
  document.querySelectorAll(".only-float").forEach(el => bind(el, sanitizeFloat));

});
</script>

<script>
function num(v){
  const m = String(v || '').match(/[\d.]+/);
  return m ? parseFloat(m[0]) : 0;
}
</script>


<script id="datasync_engine">
(function(){
  if(window.__dataSyncBound) return;
  window.__dataSyncBound = true;

  function getVal(el){
    if(!el) return "";
    if(el.type === "checkbox") return el.checked ? "1" : "0";
    if(el.type === "radio") return el.checked ? el.value : "";
    return (el.value ?? "");
  }

  function setVal(el, v){
    if(!el) return;

    if("value" in el){
      if(String(el.value ?? "") === String(v ?? "")) return;
      el.value = v;
    }else{
      if(String(el.textContent ?? "") === String(v ?? "")) return;
      el.textContent = v;
    }

    el.dispatchEvent(new Event("input", {bubbles:true}));
    el.dispatchEvent(new Event("change", {bubbles:true}));
  }

  function syncFrom(src){
    const raw = src.getAttribute("data-sync");
    if(!raw) return;

    const ids = raw.split(",").map(s => s.trim()).filter(Boolean);
    if(!ids.length) return;

    const value = getVal(src);

    ids.forEach(function(id){
      const target = document.getElementById(id);
      if(target) setVal(target, value);
    });

    document.dispatchEvent(new Event("valuation:recalc"));
  }

  function handler(e){
    const el = e.target;
    if(!el || !el.getAttribute) return;
    if(!el.hasAttribute("data-sync")) return;
    syncFrom(el);
  }

  document.addEventListener("input", handler, true);
  document.addEventListener("change", handler, true);
  document.addEventListener("keyup", handler, true);

  try{
    if(window.jQuery){
      jQuery(document).on("changed.bs.select", "[data-sync]", function(){
        syncFrom(this);
      });
    }
  }catch(e){}

  function initial(){
    document.querySelectorAll("[data-sync]").forEach(syncFrom);
  }

  if(document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initial);
  } else {
    initial();
  }
})();
</script>


<script id="valuation_autocalc">
(function(){
  if(window.__valuationAutoCalcBound) return;
  window.__valuationAutoCalcBound = true;

  function num(v){
    if(v === null || v === undefined) return 0;
    v = String(v).trim();
    if(!v || v === '-') return 0;
    v = v.replace(/,/g,'');
    var n = parseFloat(v);
    return isNaN(n) ? 0 : n;
  }
  function fmt(n, dec){
    dec = (dec===undefined) ? 1 : dec;
    if(!isFinite(n)) n = 0;
    return n.toLocaleString('en-US', {minimumFractionDigits: dec, maximumFractionDigits: dec});
  }

  // ✅ id олдохгүй бол name-аар нь олно
  function field(key){
    return document.getElementById(key) || document.querySelector('[name="'+key+'"]');
  }
  function val(key){
    var el = field(key);
    return el ? el.value : '';
  }
  function setOut(key, v){
    var el = field(key);
    if(!el) return;
    if(el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') el.value = v;
    else el.textContent = v;
  }

  let raf = 0;
  function scheduleCalc(){
    if(raf) return;
    raf = requestAnimationFrame(function(){ raf = 0; calc(); });
  }

  function calc(){
    // ====== INPUTS ======
    var B1 = num(val('B1'));
    var B2 = num(val('B2'));
    var B  = B1 * B2;

    var G  = num(val('G'));

    var prod = 1;
    for(var i=1;i<=10;i++){
      var v = num(val('I'+i));
      if(!v) v = 1;
      prod *= v;
    }

    var unitCost = G * prod;
    var BOO = B * unitCost;

    // ====== Үлдсэн ашиглах жил (Tash) ======
    var curY = parseInt((val('date') || '').split('-')[0], 10) || 0;

    var buildY = parseInt(val('uild_on'), 10) || 0;
    if(!buildY) buildY = parseInt(val('A'), 10) || 0;

    var usedYear = (curY && buildY) ? Math.max(0, curY - buildY) : 0;

    var Tnorm = num(val('Tnorm'));

    // ✅ Tash = үлдсэн жил
    var Tash = (Tnorm > 0) ? Math.max(0, Tnorm - usedYear) : 0;

    // Tash-г харагдуулна (input байвал value руу)
    setOut('Tash', Tash);

    // ====== Элэгдэл ======
    var Ephys = (Tnorm > 0) ? (BOO * (usedYear / Tnorm)) : 0;

    var Eua  = num(val('Eua'));
    var Eeco = num(val('Eeco'));
    var HEE  = Ephys + Eua + Eeco;

    var P = BOO - HEE;

    // ====== OUTPUTS ======
    setOut('B', fmt(B, 2));
    setOut('K', fmt(prod, 4));
    setOut('unitCost', fmt(unitCost, 1));
    setOut('BOO', fmt(BOO, 1));
    setOut('Ephys', fmt(Ephys, 1));
    setOut('HEE', fmt(HEE, 1));
    setOut('P', fmt(P, 1));
  }

  function bind(){
    // ✅ Аль ч input/select өөрчлөгдвөл бодно (loop үүсгэхгүй: rAF debounce)
    document.addEventListener('input', scheduleCalc, true);
    document.addEventListener('change', scheduleCalc, true);

    // data-sync дохио
    document.addEventListener('valuation:recalc', scheduleCalc);

    scheduleCalc();
  }

  if(document.readyState === 'loading') document.addEventListener("DOMContentLoaded", bind);
  else bind();
})();
</script>

<script>
$(document).on('click','#addRentRows',function(e){
  e.preventDefault();

  var rowIndex = $('#rentBody .rent-row').length + 1;
  var fileId = 'rent_img_' + rowIndex;

  var html = `
    <tr class="rent-row">
      <td><input class="itemRowRent" type="checkbox" style="width:100%;"></td>

      <td>
        <div class="rent-upload-box">
          <input type="file"
                 name="rent_productCode[]"
                 class="rent-image-input"
                 id="${fileId}"
                 accept="image/*"
                 style="display:none">

          <label for="${fileId}" class="rent-upload-btn">Зураг сонгох</label>

          <img class="rent-thumb-preview"
               src=""
               style="display:none; max-width:70px; max-height:70px; border:1px solid #ddd; border-radius:6px;">
        </div>
      </td>

      <td><input type="text" name="rent_address[]" class="form-control"></td>
      <td><input type="number" name="rent_price[]" class="form-control rent-price"></td>
      <td><input type="number" name="rent_area[]" class="form-control rent-area"></td>
      <td bgcolor="#eee"><input type="number" name="rent_unit_price[]" class="form-control rent-unit-price" readonly></td>
      <td bgcolor="#eee"><input type="number" name="rent_weight[]" class="form-control rent-weight" value="1"></td>
      <td bgcolor="#eee"><input type="number" name="rent_adjusted_unit_price[]" class="form-control rent-adjusted-unit-price" readonly></td>
      <td bgcolor="#eee"><input type="text" name="rent_source[]" class="form-control"></td>
    </tr>
  `;

  $('#rentBody').append(html);
});
</script>

<script>
function calcRentRow(row){
  var price = parseFloat(row.find('.rent-price').val()) || 0;
  var area = parseFloat(row.find('.rent-area').val()) || 0;
  var weight = parseFloat(row.find('.rent-weight').val()) || 0;

  var unit = 0;
  if(area > 0){
    unit = price / area;
    row.find('.rent-unit-price').val(unit.toFixed(2));
  } else {
    row.find('.rent-unit-price').val('');
  }

  var adjusted = unit * weight;
  if(area > 0){
    row.find('.rent-adjusted-unit-price').val(adjusted.toFixed(2));
  } else {
    row.find('.rent-adjusted-unit-price').val('');
  }
}

function calcRentStats(){
  var values = [];

  $('.rent-adjusted-unit-price').each(function(){
    var v = parseFloat($(this).val());
    if(!isNaN(v) && v > 0){
      values.push(v);
    }
  });

  if(values.length === 0){
    $('#rent_mean').text('0');
    $('#rent_median').text('0');
    $('#rent_std').text('0');
    $('#rent_outlier_count').text('0');
    $('.rent-row').removeClass('rent-outlier');
    return;
  }

  values.sort(function(a,b){ return a-b; });

  var n = values.length;
  var sum = values.reduce(function(a,b){ return a+b; }, 0);
  var mean = sum / n;

  var median = 0;
  var mid = Math.floor(n / 2);
  if(n % 2 === 0){
    median = (values[mid - 1] + values[mid]) / 2;
  } else {
    median = values[mid];
  }

  var variance = 0;
  for(var i = 0; i < n; i++){
    variance += Math.pow(values[i] - mean, 2);
  }
  variance = variance / n;
  var std = Math.sqrt(variance);

  // 2 std-оос их зөрүүтэйг outlier гэж тооцъё
  var lower = mean - (2 * std);
  var upper = mean + (2 * std);
  var outlierCount = 0;

  $('.rent-row').removeClass('rent-outlier');

  $('.rent-row').each(function(){
    var v = parseFloat($(this).find('.rent-adjusted-unit-price').val());
    if(!isNaN(v) && v > 0){
      if(v < lower || v > upper){
        $(this).addClass('rent-outlier');
        outlierCount++;
      }
    }
  });

  $('#rent_mean').text(mean.toFixed(2));
  $('#rent_median').text(median.toFixed(2));
  $('#rent_std').text(std.toFixed(2));
  $('#rent_outlier_count').text(outlierCount);
}

$(document).on('input', '.rent-price, .rent-area, .rent-weight', function(){
  var row = $(this).closest('tr');
  calcRentRow(row);
  calcRentStats();
});

$(document).on('click', '#addRentRows', function(){
  setTimeout(function(){
    calcRentStats();
  }, 0);
});

$(document).on('click', '#removeRentRows', function(){
  setTimeout(function(){
    calcRentStats();
  }, 0);
});
</script>

<script>
$(document).on('change', '.rent-image-input', function(){
  var input = this;
  var $row = $(this).closest('tr');
  var $preview = $row.find('.rent-thumb-preview');

  if (input.files && input.files[0]) {
    var file = input.files[0];

    if (!file.type.match(/^image\//)) {
      alert('Зөвхөн зураг файл сонгоно уу.');
      input.value = '';
      $preview.attr('src', '').hide();
      return;
    }

    var reader = new FileReader();
    reader.onload = function(e){
      $preview.attr('src', e.target.result).show();
    };
    reader.readAsDataURL(file);
  } else {
    $preview.attr('src', '').hide();
  }
});
</script>

<script>

$('#return_rate').prop('disabled', true);
$('#risk_free_rate').prop('disabled', true);

$(document).on('change','#use_income_method',function(){

if($(this).is(':checked')){

$('#return_rate').prop('disabled', false);
$('#risk_free_rate').prop('disabled', false);

}else{

$('#return_rate').prop('disabled', true);
$('#risk_free_rate').prop('disabled', true);

}

});

</script>

<script>
function calcRecaptureRates(){
  var n = parseFloat($('#Tash').val()) || 0;
  var Y = parseFloat($('#return_rate').val()) || 0;
  var S = parseFloat($('#risk_free_rate').val()) || 0;

  Y = Y / 100;
  S = S / 100;

  if(n <= 0){
    $('#ring_rate').val('');
    $('#inwood_rate').val('');
    $('#hoskold_rate').val('');
    $('#ring_cap_rate').val('');
    $('#inwood_cap_rate').val('');
    $('#hoskold_cap_rate').val('');
    return;
  }

  var ring = 1 / n;

  var inwood = 0;
  if(Y > 0){
    inwood = Y / (Math.pow(1 + Y, n) - 1);
  }

  var hoskold = 0;
  if(S > 0){
    hoskold = S / (Math.pow(1 + S, n) - 1);
  }

  var ringCap = Y + ring;
  var inwoodCap = Y + inwood;
  var hoskoldCap = Y + hoskold;

  $('#ring_rate').val((ring * 100).toFixed(4));
  $('#inwood_rate').val((inwood * 100).toFixed(4));
  $('#hoskold_rate').val((hoskold * 100).toFixed(4));

  $('#ring_cap_rate').val((ringCap * 100).toFixed(4));
  $('#inwood_cap_rate').val((inwoodCap * 100).toFixed(4));
  $('#hoskold_cap_rate').val((hoskoldCap * 100).toFixed(4));
}

$(document).on('input change', '#Tash, #return_rate, #risk_free_rate', function(){
  calcRecaptureRates();
});

$(document).ready(function(){
  calcRecaptureRates();
});
</script>