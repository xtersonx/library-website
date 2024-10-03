<?php

include 'dbconnection.php';
$conn = connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //take the info
    $catname = $_POST['caname'];
    $catid = $_POST['catid'];
    



    $catname = htmlspecialchars($catname);

    
    
   
    $sql = "UPDATE `category` SET`name`='$catname' WHERE `id` = '$catid'";
    $conn->query($sql);

//we send the response of the  title to the ajax so we can use it after page reload
echo $catname;


}

?>