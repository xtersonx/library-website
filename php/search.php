<?php
include 'dbconnection.php';
$conn = connect();

// after form submittion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //take the info
    $name = $_POST['searchin'];

    $name = htmlspecialchars($name);

    $booklis = [[]];
    

    $o = 0;
    $getallbook = "SELECT b.title, b.cover, b.pdf, b.description, a.name,a.lastname
    FROM books b 
    JOIN author a ON b.authorid = a.id
    WHERE b.title LIKE '$name%' ";
    $bookres = $conn->query($getallbook);
    while ($row = $bookres->fetch_assoc() and $o < mysqli_num_rows($bookres)) {
        $booklis[$o] = array($row['title'], $row['cover'], $row['pdf'], $row['description'], $row['name'],$row['lastname']);
        $o++;
    }

//we make a json for the response
$responsejs = json_encode($booklis);
echo $responsejs;



    



    
}



















?>