<?php

include 'dbconnection.php';
$conn = connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //take the info
    $titleb = $_POST['titleb'];
    $authorb = $_POST['auth'];
    $categoryb = $_POST['categ'];
    $descriptionb = $_POST['desc'];
    $bid = $_POST['bookid'];
    
    

    //get the new selected author name id
    $seauid;
    $auidsql = "SELECT id FROM author 
    WHERE CONCAT(name, ' ', lastname) = '$authorb'";
    $auidres = $conn->query($auidsql);

    while($row = $auidres->fetch_assoc()){
        $seauid = $row['id'];
    }
    //get the new selected category name id
    $secid;
    $catidsql = "SELECT id FROM category 
    WHERE name = '$categoryb'";
    $cateidres = $conn->query($catidsql);
    while($row = $cateidres->fetch_assoc()){
        $secid = $row['id'];

    }



    $pdfav = false;
    $coverav = false;

    $titleb = htmlspecialchars($titleb);
    $descriptionb = htmlspecialchars($descriptionb);
    
    //take the file and save them
    $coverfileb = $_FILES['coverb'];
    $pdffileb = $_FILES['pdffileb'];

    
    //set the allowed format
    $coverallowed = ['image/jpeg', 'image/png', 'image/gif'];
    $pdfallowed = ['application/pdf'];


     // Check if cover file was uploaded
     if ($coverfileb['error'] === UPLOAD_ERR_OK) {
        $coverav = true;
        $coverfileb2 = $coverfileb['name'];
        $covertmp = $coverfileb['tmp_name'];
        $coverdest = "../bookimg/" . $coverfileb2;
        // get the cover type
        $covertype = mime_content_type($covertmp);
        // check the type of the cover if in the allowed files
        if(in_array($covertype,$coverallowed)){
        // move the cover from the temp to the cover folder
        move_uploaded_file($covertmp, $coverdest);
        $coverpath = $coverdest;

         
    }
}

 // Check if PDF file was uploaded
 if ($pdffileb['error'] === UPLOAD_ERR_OK) {
    $pdfav = true;
    $pdffileb2 = $pdffileb['name'];
    $pdftmp = $pdffileb['tmp_name'];
    $pdfdest = "../bookpdf/" . $pdffileb2;
    //get the file type
    $filetype = mime_content_type($pdftmp);
    //check if allowed file
    if(in_array($filetype,$pdfallowed)){    
    // move the pdf from the temp to the pdf folder
    move_uploaded_file($pdftmp, $pdfdest);
    $pdfpath = $pdfdest;
    }
}
if($pdfav && $coverav){
$sql = "UPDATE `books` SET `authorid`= $seauid,`categoryid` = $secid,`title`='$titleb',`description`='$descriptionb',`pdf`='$pdfpath',`cover`='$coverpath' WHERE `id` = '$bid'";
$conn->query($sql);
}
else if($pdfav && $coverav == false){
    $sql = "UPDATE `books` SET `authorid`= $seauid,`categoryid` = $secid,`title`='$titleb',`description`='$descriptionb',`pdf`='$pdfpath' WHERE `id` = '$bid'";
    $conn->query($sql);
}
else if($coverav && $pdfav == false){
    $sql = "UPDATE `books` SET `authorid`= $seauid,`categoryid` = $secid,`title`='$titleb',`description`='$descriptionb',`cover`='$coverpath' WHERE `id` = '$bid'";
    $conn->query($sql);

}
else if($coverav == false && $pdfav == false){
    $sql = "UPDATE `books` SET `authorid`= $seauid,`categoryid` = $secid, `title`='$titleb',`description`='$descriptionb' WHERE `id` = '$bid'";
$conn->query($sql);

}
//we send the response of the  title to the ajax so we can use it after page reload
echo $titleb;






}









?>