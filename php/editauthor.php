<?php

include 'dbconnection.php';
$conn = connect();
// after form submittion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //take the info
    $autherid = $_POST['author'];

    $autherinfo = [[]];
  
    //querrry to select the book info
    $sql = "SELECT id, name, lastname, nationality FROM `author` where id=$autherid";

   
    //send the querry 
    $result = $conn->query($sql);


    //store all the data in dimensional array
    $j = 0;
    while($row = $result->fetch_assoc()and $j < mysqli_num_rows($result)){
    $authorinfo[$j] = array($row['id'],$row['name'],$row['lastname'],$row['nationality']);
    $j++;
}
$authid = $authorinfo[0][0];
$authname = $authorinfo[0][1];
$authlname = $authorinfo[0][2];
$authnati = $authorinfo[0][3];


$authinfo = [$authid,$authname,$authlname,$authnati];
//json
$authjs = json_encode($authinfo);


echo $authjs;





}

?>