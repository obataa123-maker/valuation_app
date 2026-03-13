<?php

//fetch_data.php

$connect = new PDO("mysql:host=localhost:3306;dbname=newhurungu", "root", "");

$method = $_SERVER['REQUEST_METHOD'];

if($method == 'GET')
{
 $data = array(
  ':ner'   => "%" . $_GET['ner'] . "%",
  ':turul'   => "%" . $_GET['turul'] . "%",
  ':sev'     => "%" . $_GET['sev'] . "%",
  ':zereg'    => "%" . $_GET['zereg'] . "%",
  ':budah'     => "%" . $_GET['budah'] . "%",
  ':budag'    => "%" . $_GET['budag'] . "%"
 );
 $query = "SELECT * FROM sample_data WHERE ner LIKE :ner AND turul LIKE :turul AND sev LIKE :sev AND zereg LIKE :zereg AND budah LIKE :budah AND budag LIKE :budag ORDER BY id DESC";

 $statement = $connect->prepare($query);
 $statement->execute($data);
 $result = $statement->fetchAll();
 foreach($result as $row)
 {
  $output[] = array(
   'id'    => $row['id'],   
   'ner'  => $row['ner'],
   'turul'   => $row['turul'],
   'zereg'    => $row['zereg'],
   'sev'   => $row['sev'],
   'budah'    => $row['budah'],
   'budag'   => $row['budag']
  );
 }
 header("Content-Type: application/json");
 echo json_encode($output);
}

if($method == "POST")
{
 $data = array(
  ':ner'  => $_POST['ner'],
  ':turul'  => $_POST["turul"],
  ':sev'    => $_POST["sev"],
  ':zereg'   => $_POST["zereg"],
  ':budah'    => $_POST["budah"],
  ':budag'   => $_POST["budag"]
 );

 $query = "INSERT INTO sample_data (ner, turul, sev, zereg, budah, budag) VALUES (:ner, :turul, :sev, :zereg, :budah, :budag)";
 $statement = $connect->prepare($query);
 $statement->execute($data);
}

if($method == 'PUT')
{
 parse_str(file_get_contents("php://input"), $_PUT);
 $data = array(
  ':id'   => $_PUT['id'],
  ':ner' => $_PUT['ner'],
  ':turul' => $_PUT['turul'],
  ':sev'   => $_PUT['sev'],
  ':zereg'  => $_PUT['zereg'],
  ':budah'   => $_PUT['budah'],
  ':budag'  => $_PUT['budag']
 );
 $query = "
 UPDATE sample_data 
 SET ner = :ner, 
 turul = :turul, 
 sev = :sev, 
 zereg = :zereg,
 budah = :budah, 
 budag = :budag
 WHERE id = :id
 ";
 $statement = $connect->prepare($query);
 $statement->execute($data);
}

if($method == "DELETE")
{
 parse_str(file_get_contents("php://input"), $_DELETE);
 $query = "DELETE FROM sample_data WHERE id = '".$_DELETE["id"]."'";
 $statement = $connect->prepare($query);
 $statement->execute();
}

?>