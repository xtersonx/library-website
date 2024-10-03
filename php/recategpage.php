<?php

include 'dbconnection.php';
$conn = connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //take the info
    $caid = $_POST['catid'];

    $cand;
    $dmsg;
    



    $sql1 = "SELECT id FROM books WHERE categoryid = '$caid'";
    $res = $conn->query($sql1);
    if(mysqli_num_rows($res) > 0){
        $cand = false;
        $dmsg = "Cannot delete category";
    }
    else{
        $cand = true;
    }

    
    //querry to delete the author
    if($cand){
    $deauth = "DELETE FROM category WHERE id = '$caid'";
    $conn->query($deauth);
    $dmsg = "Category deleted";
    }
    echo $dmsg;
    
    
}