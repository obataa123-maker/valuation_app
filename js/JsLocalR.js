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