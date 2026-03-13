<html>  
    <head>  
        <title>Inline Table Insert Update Delete in PHP using jsGrid</title>  
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.css" />
  <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid-theme.min.css" />
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.js"></script>
  <style>
  .hide
  {
     display:none;
  }
  </style>
    </head>  
    <body>  
        <div class="container">  
   <br />
   <div class="table-responsive">  
    <h3 align="center">Автомашины гэмтлийн зэрэг, засварын ажлын жишиг хөлс</h3><br />
    <div id="grid_table"></div>
   </div>  
  </div>
    </body>  
</html>  
<script>
 
    $('#grid_table').jsGrid({

     width: "100%",
     height: "600px",

     filtering: true,
     inserting:true,
     editing: true,
     sorting: true,
     paging: true,
     hurunguload: true,
     pageSize: 50,
     pageButtonCount: 6,
     deleteConfirm: "Мэдээллийг устгах уу?",

     controller: {
      loadData: function(filter){
       return $.ajax({
        type: "GET",
        url: "fetch_data.php",
        data: filter
       });
      },
      insertItem: function(item){
       return $.ajax({
        type: "POST",
        url: "fetch_data.php",
        data:item
       });
      },
      updateItem: function(item){
       return $.ajax({
        type: "PUT",
        url: "fetch_data.php",
        data: item
       });
      },
      deleteItem: function(item){
       return $.ajax({
        type: "DELETE",
        url: "fetch_data.php",
        data: item
       });
      },
     },

     fields: [
      {
       name: "id",
    type: "hidden",
    css: 'hide'
      },
      {
		  title: "Эд ангийн нэршил",
       name: "ner", 
    type: "text", 
    width: 150, 
    validate: "required"
      },
      {
		  title: "Машины төрөл",
       name: "turul", 
    type: "text", 
    width: 150, 
    validate: "required"
      },
      {
		  title: "Сэв гаргах хөлс",
       name: "sev", 
    type: "text", 
    width: 50, 
    validate: function(value)
    {
     if(value > 0)
     {
      return true;
     }
    }
      },
	  {
		  title: "Будгийн зардал",
	         name: "budah", 
    type: "text", 
    width: 50, 
    validate: function(value)
    {
     if(value > 0)
     {
      return true;
     }
    }
      },
	  {
		  title: "100гр будгийн үнэ",
	         name: "budag", 
    type: "text", 
    width: 50, 
    validate: function(value)
    {
     if(value > 0)
     {
      return true;
     }
    }
      },
      {
		  title: "Норматив хугацаа",
       name: "zereg", 
    type: "select", 
    items: [
     { Name: "", Id: '' },
     { Name: "1", Id: '1' },
     { Name: "2", Id: '2' },
	 { Name: "3", Id: '3' },
     { Name: "4", Id: '4' },
	 { Name: "5", Id: '5' },
    ], 
    valueField: "Id", 
    textField: "Name", 
    validate: "required"
      },
      {
       type: "control"
      }
     ]

    });

</script>