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
<html>
 <head>
  <title>Хөрөнгийн үнэлгээний тайлан</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
  <script src="js/invoice.js"></script>
  <script  src="js/script.js"></script>	
<link href="css/style.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
		<script>
	$('#form').submit(function(event){
	var formdata = new FormData(this);
	$.ajax({
		url:'image_upload.php',
		data:formdata,
		contentType:false,
		cache:false,
		processData:false,
		type:"POST",
		success:function(response){
		alert(response);
		},
		error:function(){
		alert("Алдаа гарлаа");
		}
	});
	event.preventDefault();
	});
	</script>
  <style>
   body
   {
    margin:0;
    padding:0;
    background-color:#f1f1f1;
   }
   .box
   {
    width:1400px;
    padding:10px;
    background-color:#fff;
    border:1px solid #ccc;
    border-radius:1px;
    margin-top:10px;
   }
  </style>
  <style>
body {margin:0}

.icon-bar {
  width: 90px;
  background-color: #fbfbfd;
}

.icon-bar a {
  display: block;
  text-align: center;
  padding: 16px;
  transition: all 0.3s ease;
  color: black;
  font-size: 36px;
}

.icon-bar a:hover {
  background-color: #e6e6f3;
}

.active {

}
</style>
  

 </head>
 <?php include('container.php');?>
<div class="sidebar">
<div class="icon-bar">
<img src="upload/logo.png" alt="logo" class="center" >
<p></p>
<a class="active" href="#"><i class="fa fa-home"></i></a> 
  <a href="create_invoice.php"><i class="fa fa-pencil-square-o"></i></a> 
  <a type="button" class="btn btn-group" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-car"></i></a> 
  <a href="nershil.php"><i class="fa fa-wrench"></i></a> 
  <a href=""><i class="fa fa-search"></i></a> 
  <a href=""><i class="fa fa-pie-chart"></i></a>
  <a type="button" class="btn btn-group" data-toggle="modal" data-target="#modaladd"><i class="fa fa-user-plus"></i></a>
  <a href="http://localhost/unelgee/face_list.php"><i class="fa fa-sign-out"></i></a> 
  
</div>
</div>
 <body>
  <div class="container box">
   <h4 align="center">Хөрөнгийн үнэлгээний тайлан</h4>

   <script>
    function myFunction(e) {
    document.getElementById("mailto").value = e.target.value
    }
</script>
   <div class="table-responsive">
    <br />
    <div class="row">
     <div class="input-daterange">
      <div class="col-md-4">
       <input type="text" name="start_date" id="start_date" class="form-control" value="Эхлэх огноо"/>
      </div>
      <div class="col-md-4">
       <input type="text" name="end_date" id="end_date" class="form-control" value="Дуусах огноо"/>
      </div>      
     </div>
     <div class="col-md-4">
      <input type="button" name="search" id="search" value="Хайлт" class="btn btn-info" />
     </div>
    </div>
    <br />
   
    <table id="order_data" class="table table-hover table-striped" style="font-size:12px">
     <thead>
      <tr>
            <th>№</th>
            <th>Огноо</th>
            <th>Үнийн өсөлтийн индекс</th>
			<th>Үйлдвэр</th>
			<th>Марк</th>
			<th>Үйлд/он</th>
			<th style="text-align:right">Эзэмшигч</th>
			<th style="text-align:right">Захиалагч</th>
            <th>Хохирлын дүн</th>
 			<th>Зураг +</th>           
            <th>PDF</th>
            <th>Хэвлэх</th>
			<th>Илгээх</th>
            <th>Засах</th>
            <th>Устгах</th>
      </tr>
     </thead>
    </table>
    
    <div class="modal fade" id="modaladd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        Үнэлгээчин/Туслах үнэлгээчин нэмэх
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  		<form action="adduser.php" method="POST">
			<div><label>Мэргэжил :</label><input type="text" name="mergejil" id="mergejil" required/></div><br>
			<div><label>Үнэлгээний мэргэжилтэн нэр:</label><input type="text" name="ner" id="ner" required/></div><br>
			<input type="hidden" name="company" id="company" required/>
			<input type="submit" class="btn btn-primary" value="Нэмэх">
			</form>


      </div>
    </div>
  </div>
</div>
   </div>
  </div>
 </body>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        АвтоНэгжийн үнэлгээ/төрөл нэмэх
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  
		<div class="tab">
		<button class="tablinks" onclick="openCity(event, 'uildverlegch')">Үйлдвэрлэгч нэмэх</button>
		<button class="tablinks" onclick="openCity(event, 'mark')">Марк нэмэх</button>
		</div>
	  
		<div id="uildverlegch" class="tabcontent">
		<div>
			
		    <select name="category_item1" id="category_item1" class="ml-sm-5 bg-warning"  data-live-search="true" title="сонгох" onchange="myFunction(event)">

            </select>
			
			
			<br><br>
			<form action="turul.php" method="POST">
			<div><label>Шинээр нэмэх:</label><input type="text" name="industry_name" id="industry_name"/></div><br>
			<input type="submit" name="ok1" class="btn btn-primary" value="Нэмэх">
			</form>
		</div>
		</div>

		<div id="mark" class="tabcontent">
		<div>
			<br><br>
			<form action="turul_sub.php" method="POST">
			<div><label>Нэгжийн үнэлгээ нэмэх:</label><input type="text" name="sub_industry_name" id="sub_industry_name"/></div><br>
						<input name="ind" id="ind" type="hidden" value="">
			<input type="submit" name="ok2" class="btn btn-primary" value="Нэмэх">
			</form>
		</div>
		</div>

      </div>
    </div>
  </div>
</div>
</html>


<script type="text/javascript" language="javascript" >
$(document).ready(function(){
 
 $('.input-daterange').datepicker({
  todayBtn:'linked',
  format: "yyyy-mm-dd",
  hurunguclose: true
 });

 fetch_data('no');

 function fetch_data(is_date_search, start_date='', end_date='')
 {
  var dataTable = $('#order_data').DataTable({
   "processing" : true,
   "serverSide" : true,
   "order" : [],
   "language": {
  "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Mongolian.json"
},
   "ajax" : {
    url:"fetch.php",
    type:"POST",
    data:{
     is_date_search:is_date_search, start_date:start_date, end_date:end_date
    }
   }
  });
 }

 $('#search').click(function(){
  var start_date = $('#start_date').val();
  var end_date = $('#end_date').val();
  if(start_date != '' && end_date !='')
  {
   $('#order_data').DataTable().destroy();
   fetch_data('yes', start_date, end_date);
  }
  else
  {
   alert("Both Date is Required");
  }
 }); 
 
});
</script>

<script>
$(document).ready(function(){

  $('#category_item1').selectpicker();

  $('#sub_category_item1').selectpicker();

  load_data('category_data');

  function load_data(type, category_id = '')
  {
    $.ajax({
      url:"load_data_type.php",
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
          $('#category_item1').html(html);
          $('#category_item1').selectpicker('refresh');
        }
        else
        {
          $('#sub_category_item1').html(html);
          $('#sub_category_item1').selectpicker('refresh');
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
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
</script>

<script>
function myFunction(e) {
    document.getElementById("ind").value = e.target.value
}
</script>

<?php include('footer.php');?>

