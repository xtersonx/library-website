<?php

include 'dbconnection.php';
$conn = connect();
// after form submittion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //take the info
    $catego = $_POST['categ'];

    $categinfo = [[]];
  
    //querrry to select the book info
    $sql = "SELECT id, name FROM `category` where name = '$catego'";

   
    //send the querry 
    $result = $conn->query($sql);


    //store all the data in dimensional array
    $j = 0;
    while($row = $result->fetch_assoc()and $j < mysqli_num_rows($result)){
    $categoinfo[$j] = array($row['id'],$row['name']);
    $j++;
}
$cateid = $categoinfo[0][0];
$catename = $categoinfo[0][1];



$cateinfo = [$cateid,$catename];
//json
$catjs = json_encode($cateinfo);


echo $catjs;





}

?>