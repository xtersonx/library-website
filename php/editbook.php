<?php

include 'dbconnection.php';
$conn = connect();
// after form submittion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //take the info
    $title = $_POST['book'];

    $bookinfo = [[]];
    $catle = [];
    $aule = [[]];
    $tmptitle;
    
    //querrry to select the book info
    $sql = "SELECT b.`id` AS bid, a.`name` AS auname, c.`name` AS catname, b.`title`, b.`description`, b.`pdf`, b.`cover`, a.`lastname` AS aulastn
    FROM `books` b
    JOIN `author` a ON b.`authorid` = a.`id`
    JOIN `category` c ON b.`categoryid` = c.`id`
    WHERE b.`title` = '$title';";
    //send the querry 
    $result = $conn->query($sql);

    //store all the data in dimensional array
    $j = 0;
    while($row = $result->fetch_assoc()and $j < mysqli_num_rows($result)){
    $bookinfo[$j] = array($row['auname'],$row['aulastn'],$row['catname'],$row['title'],$row['description'],$row['pdf'],$row['cover'],$row['bid']);
    $j++;


}
$bimg = $bookinfo[0][6];
$bpdf = $bookinfo[0][5];
$btitle = $bookinfo[0][3];
$bdescr = $bookinfo[0][4];
$bau = $bookinfo[0][0];
$baul = $bookinfo[0][1];
$bcat = $bookinfo[0][2];
$bid = $bookinfo[0][7];

$bookinfo1 = [$bimg,$bpdf,$btitle,$bdescr,$bau,$bcat,$baul,$bid];
//json
$bookjs = json_encode($bookinfo1);

//send all category names except the selected book category
$sql2 = "SELECT name FROM category WHERE name <> '$bcat'";
$catres = $conn->query($sql2);
$v = 0;
while($row = $catres->fetch_assoc()and $v < mysqli_num_rows($catres)){
    $catle[$v] = $row['name'];
    $v++;
}
//json
$catjs = json_encode($catle);

//send all author name last name except the selected book category
$sql3 = "SELECT name,lastname FROM author WHERE name <> '$bau' AND lastname <> '$baul' ";
$aures = $conn->query($sql3);
$f = 0;
while($row = $aures->fetch_assoc()and $f < mysqli_num_rows($aures)){
    $aule[$f] = array($row['name'],$row['lastname']);
    $f++;
}
//json
$aujs = json_encode($aule);


// array to save inside it the two json and we give a name for each json
$response = [
    "catname" => $catjs,
    "bookin" => $bookjs,
    "auname" => $aujs 
];
//we make a json for the response
$responsejs = json_encode($response);
echo $responsejs;






}

?>
