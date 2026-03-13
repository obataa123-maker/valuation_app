<?php

//fetch.php;

$connect = new PDO("mysql:host=localhost:3306;dbname=newhurungu", "root", "");

if(isset($_POST['query']))
{
 $query = "
 SELECT DISTINCT ner FROM sample_data 
 WHERE ner LIKE '%".trim($_POST["query"])."%'
 ";

 $statement = $connect->prepare($query);

 $statement->execute();

 $result = $statement->fetchAll();

 $output = '';

 foreach($result as $row)
 {
  $output .= '
  <li class="list-group-item contsearch">
   <a href="javascript:void(0)" class="gsearch" style="color:#333;text-decoration:none;">'.$row["ner"].'</a>
  </li>
  ';
 }

 echo $output;
}

if(isset($_POST['ner']))
{
 $query = "
 SELECT * FROM sample_data 
 WHERE ner = '".trim($_POST["ner"])."' 
 LIMIT 1
 ";

 $statement = $connect->prepare($query);

 $statement->execute();

 $result = $statement->fetchAll();

 $output = '
 <table class="table table-responsive table-hover">
  <tr>
   <th>Нэр</th>
   <th>Төрөл</th>
   <th>Норматив хугацаа</th>
   <th>Засварлах</th>
   <th>Будгийн зардал</th>
   <th>Будгийн үнэ /100гр/</th>
  </tr>
 ';

 foreach($result as $row)
 {
  $output .= '
  <tr>
   <td class="text-left">'.$row["ner"].'</td>
   <td class="text-left">'.$row["turul"].'</td>
   <td class="text-left">'.$row["zereg"].'</td>
   <td class="text-left">'.$row["sev"].'</td>
   <td class="text-left">'.$row["budah"].'</td>
   <td class="text-left">'.$row["budag"].'</td>
  </tr>
  ';
 }
 $output .= '</table>';

 echo $output;
}

?>
