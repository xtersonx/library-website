<?php
    include 'dbconnection.php';
    $conn = connect();
// after form submittion
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //take the info
        $name = $_POST['catname'];
        
        $name = htmlspecialchars($name);
       
        $nameav = false;
       

        //check if the name are not empty
        if(!empty($name)){
            $nameav = true;
        }
        if($nameav == true){
        $sql = "INSERT INTO `category`(`name`) VALUES ('$name')";
        $conn->query($sql);
        $msgsucc = "Category added successfully";
        echo $msgsucc;
    
    }
    else{
        $msgsucc = "Failed to add category";
        echo $msgsucc;
    }
    
}
?>