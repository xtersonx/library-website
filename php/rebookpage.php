<?php

include 'dbconnection.php';
$conn = connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //get the book id
    $bid = $_POST['bookid'];

    

    //get the cover and pdf path
    $bome = [[]];
    $sql1 = "SELECT `pdf`, `cover` FROM `books` WHERE id = $bid";
    $repco = $conn->query($sql1);

    $a = 0;
    while($row = $repco->fetch_assoc()and $a < mysqli_num_rows($repco)){
        $bome[$a] = array($row['pdf'],$row['cover']);
        $a++;
        
    }
    //delete the book
    $debook = "DELETE FROM books WHERE id = '$bid'";
    $conn->query($debook);

    $pdfpath = $bome[0][0];
    $coverpath = $bome[0][1];

    //remove the delete book pdf from folder
    if (!empty($pdfpath) && file_exists($pdfpath)) {
        unlink($pdfpath);
    }

     //remove the delete book cover from folder
     if (!empty($coverpath) && file_exists($coverpath)) {
        unlink($coverpath);
    }
    echo "Book deleted";
    
    

}
















?>