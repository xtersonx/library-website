<?php

include 'dbconnection.php';
$conn = connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //take the info
    $authfname = $_POST['fname'];
    $authlname = $_POST['lname'];
    $authid = $_POST['authid'];
    $nationa = $_POST['nationa'];



    $authfname = htmlspecialchars($authfname);
    $authlname = htmlspecialchars($authlname);
    $nationa = htmlspecialchars($nationa);
    
   
    $sql = "UPDATE `author` SET`name`='$authfname',`lastname`='$authlname',`nationality`='$nationa' WHERE `id` = '$authid'";
$conn->query($sql);

//we send the response of the  title to the ajax so we can use it after page reload
echo $authid;


}

?>