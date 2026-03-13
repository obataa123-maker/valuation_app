 $(document).ready(function(){
	$(document).on('click', '#checkAll', function() {          	
		$(".itemRow").prop("checked", this.checked);
	});	
	$(document).on('click', '.itemRow', function() {  	
		if ($('.itemRow:checked').length == $('.itemRow').length) {
			$('#checkAll').prop('checked', true);
		} else {
			$('#checkAll').prop('checked', false);
		}
	});  
	var count = $(".itemRow").length;
	$(document).on('click', '#addRows', function() { 
		count++;
		var htmlRows = '';
		htmlRows += '<tr>';
		htmlRows += '<td><input class="itemRow" type="checkbox" style="width: 100%;"></td>';            
		htmlRows += '<td><input type="text" name="productCode[]" id="productCode_'+count+'" class="form-control" hurungucomplete="off"></td>';    
		htmlRows += '<td><select type="text" name="quantity[]" id="quantity_'+count+'" class="form-control"  class="form-control quantity" hurungucomplete="off" style="width: 100%;"> <option selected>сонгох</option>  <option value="Их">Их</option> <option value="Дунд">Дунд</option> <option value="Бага">Бага</option><option value="Хагарсан">Хагарсан</option> </select></td>';   		
		htmlRows += '<td><input type="number" name="price[]" id="price_'+count+'" class="form-control price" hurungucomplete="off"></td>';		 
		htmlRows += '<td><input type="number" name="total[]" id="total_'+count+'" class="form-control total" hurungucomplete="off"></td>';
		htmlRows += '<td bgcolor="#eee"><input type="number" name="zasvar[]" id="zasvar_'+count+'" class="form-control total" hurungucomplete="off"></td>';
		htmlRows += '<td bgcolor="#eee"><input type="number" name="budag[]" id="budag_'+count+'" class="form-control total" hurungucomplete="off"></td>';
		htmlRows += '<td bgcolor="#eee"><input type="number" name="solih[]" id="solih_'+count+'" class="form-control total" hurungucomplete="off"></td>'; 
		htmlRows += '<td bgcolor="#eee"><input type="number" name="survalj[]" id="survalj_'+count+'" class="form-control total" hurungucomplete="off"></td>';     		
		htmlRows += '</tr>';
		$('#invoiceItem').append(htmlRows);
	}); 
	$(document).on('click', '#removeRows', function(){
		$(".itemRow:checked").each(function() {
			$(this).closest('tr').remove();
		});
		$('#checkAll').prop('checked', false);
		calculateTotal();
	});		
	$(document).on('blur', "[id^=quantity_]", function(){
		calculateTotal();
	});	
	$(document).on('blur', "[id^=price_]", function(){
		calculateTotal();
	});	
	$(document).on('blur', "[id^=total_]", function(){
	calculateTotal();
	});	
	$(document).on('blur', "[id^=zasvar_]", function(){		
		calculateTotal();
	});
	$(document).on('blur', "[id^=budag_]", function(){		
		calculateTotal();
	});
	$(document).on('blur', "[id^=solih_]", function(){		
		calculateTotal();
	});	
	
		
	
	$(document).on('click', '.deleteInvoice', function(){
		var id = $(this).attr("id");
		if(confirm("Are you sure you want to remove this?")){
			$.ajax({
				url:"action.php",
				method:"POST",
				dataType: "json",
				data:{id:id, action:'delete_invoice'},				
				success:function(response) {
					if(response.status == 1) {
						$('#'+id).closest("tr").remove();
					}
				}
			});
		} else {
			return false;
		}
	});
});	
function calculateTotal(){
	var totalP = 0; 
	$("[id^='price_']").each(function() {
		var id = $(this).attr('id');
		id = id.replace("price_",'');
		var price = $('#price_'+id).val();
		var price = price*1;
		$('#price_'+id).val(price);
		totalP += price;			
	});
		$('#zassum').val(parseFloat(totalP));
		
		var totalPS = 0; 
		$("[id^='total_']").each(function() {
		var id = $(this).attr('id');
		id = id.replace("total_",'');
		var total = $('#total_'+id).val();
		var total = total*1;
		$('#total_'+id).val(parseFloat(total));
		totalPS += total;			
	});
	$('#totalAftertax1').val(parseFloat(totalPS));
	
	var zasvarT=0;
		$("[id^='zasvar_']").each(function() {
		var id = $(this).attr('id');
		id = id.replace("zasvar_",'');
		var zasvar = $('#zasvar_'+id).val();
		var zasvar = zasvar*1;
		$('#zasvar_'+id).val(parseFloat(zasvar));
		zasvarT += zasvar;			
	});
	$('#amountPaid').val(parseFloat(zasvarT));
	
		var budagT=0;
		$("[id^='budag_']").each(function() {
		var id = $(this).attr('id');
		id = id.replace("budag_",'');
		var budag = $('#budag_'+id).val();
		var budag = budag*1;
		$('#budag_'+id).val(parseFloat(budag));
		budagT += budag;			
	});

	$('#amountDue').val(parseFloat(budagT));
	
		var solihT=0;
		$("[id^='solih_']").each(function() {
		var id = $(this).attr('id');
		id = id.replace("solih_",'');
		var solih = $('#solih_'+id).val();
		var solih = solih*1;
		$('#solih_'+id).val(parseFloat(solih));
		solihT += solih;			
	});
	$('#taxAmount').val(parseFloat(solihT));
		var niit=totalP+totalPS+zasvarT+solihT;
	$('#subTotal').val(parseFloat(niit));
	
	var taxRate = $("#taxRate").val();
	var subTotal = $('#subTotal').val();	

}

 