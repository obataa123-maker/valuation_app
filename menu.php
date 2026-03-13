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


  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
	
<ul class="nav navbar-nav">

	<button class="btn btn" type="button"><a href="invoice_list.php">Тайлангийн жагсаалт</a></button>
	<button class="btn btn-group" type="button"><a href="create_invoice.php">Шинэ тайлан</a></button>
	<button type="button" class="btn btn-group" data-toggle="modal" data-target="#exampleModal">АвтоНэгжийн үнэлгээ/төрөл нэмэх</button>

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
						<input name="ind" id="ind" value="">
			<input type="submit" name="ok2" class="btn btn-primary" value="Нэмэх">
			</form>
		</div>
		</div>

      </div>
    </div>
  </div>
</div>


<!--<?php 
if($_SESSION['userid']) { ?>
	<li class="dropdown">
		<button class="btn btn-info" type="button" data-toggle="dropdown">Logged in <?php echo $_SESSION['user']; ?>
		<span class="caret"></span></button>
		<ul class="dropdown-menu">
			<li><a href="#">Account</a></li>
			<li><a href="action.php?action=logout">Logout</a></li>		  
		</ul>
	</li>
<?php } ?>-->

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
function myFunction(e) {
    document.getElementById("ind").value = e.target.value
}
</script>

</ul>
<br /><br /><br /><br />