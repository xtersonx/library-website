<?php

include 'dbconnection.php';
$conn = connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //take the info
    $aid = $_POST['authid'];

    $cand;
    $dmsg;
    



    $sql1 = "SELECT id FROM books WHERE authorid = '$aid'";
    $res = $conn->query($sql1);
    if(mysqli_num_rows($res) > 0){
        $cand = false;
        $dmsg = "Cannot delete author";
    }
    else{
        $cand = true;
    }

    
    //querry to delete the author
    if($cand){
    $deauth = "DELETE FROM author WHERE id = '$aid'";
    $conn->query($deauth);
    $dmsg = "Author deleted";
    }
    echo $dmsg;
    
    

    
    
}