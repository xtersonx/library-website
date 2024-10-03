<?php
    include 'dbconnection.php';
    $conn = connect();
// after form submittion
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //take the info
        $auname = $_POST['auname'];
        $aulast = $_POST['aulast'];
        $aunat = $_POST['nation'];
        

        $auname = htmlspecialchars($auname);
        $aulast = htmlspecialchars($aulast);
        $aunat = htmlspecialchars($aunat);

        $nameav = false;
        $lastav = false;
        $natav = false;

        //check if the name are not empty
        if(!empty($auname)){
            $nameav = true;
        }
        //check if the last name are not empty
        if(!empty($aulast)){
            $lastav = true;
        }
        //check nationality not empty
        if(!empty($aunat)){
            $natav = true;
        }
        if($lastav == true && $nameav == true && $natav == true){
        $sql = "INSERT INTO `author`(`name`, `lastname`, `nationality`) VALUES ('$auname','$aulast','$aunat')";
        $conn->query($sql);
        $msgsucc = "Author added successfully";
        echo $msgsucc;
    
    }
    else{
        $msgsucc = "Failed to add author";
        echo $msgsucc;
    }
    
}
?>