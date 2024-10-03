<?php

//create connection with mysql
function connect(){
$servername = "localhost";
$username = "root";
$password = "";
$db = "marketdata";
$conn = new mysqli($servername,$username,$password,$db);
if($conn->connect_error){
    die("Connection failed".$conn->connect_error);
}
return $conn;

}

?>