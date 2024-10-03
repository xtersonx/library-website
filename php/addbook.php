<?php
    include 'dbconnection.php';
    $conn = connect();
// after form submittion
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //take the info
        $title = $_POST['title'];
        $author = $_POST['author'];
        $category = $_POST['category'];
        $description = $_POST['description'];

        $title = htmlspecialchars($title);
        $description = htmlspecialchars($description);
    
        //take the file and save them
        $coverfile = $_FILES['cover'];
        $pdffile = $_FILES['pdf'];

        //set the allowed format
        $coverallowed = ['image/jpeg', 'image/png', 'image/gif'];
        $pdfallowed = ['application/pdf'];

        $titleav = false;
        $descav = false;
        $coverav = false;
        $pdfav = false;

        //check if the title are not empty
        if(!empty($title)){
            $titleav = true;
        }
        //check if the description are not empty
        if(!empty($description)){
            $descav = true;
        }
        //check if cover not empty
        if(!empty($coverfile['name'])){
            $coverav = true;
        }
        //check if pdf are not empty
        if(!empty($pdffile['name'])){
            $pdfav = true;
        }
        
 
        // Check if cover file was uploaded
        if ($coverfile['error'] === UPLOAD_ERR_OK) {
            $coverfile2 = $coverfile['name'];
            $covertmp = $coverfile['tmp_name'];
            $coverdest = "../bookimg/" . $coverfile2;
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
    if ($pdffile['error'] === UPLOAD_ERR_OK) {
        $pdffile2 = $pdffile['name'];
        $pdftmp = $pdffile['tmp_name'];
        $pdfdest = "../bookpdf/" . $pdffile2;
        //get the file type
        $filetype = mime_content_type($pdftmp);
        //check if allowed file
        if(in_array($filetype,$pdfallowed)){    
        // move the pdf from the temp to the pdf folder
        move_uploaded_file($pdftmp, $pdfdest);
        $pdfpath = $pdfdest;
        }
    }


    //get the author id from the table based on the author name
    $k = 0;
    $sql = "SELECT id FROM author 
    WHERE CONCAT(name, ' ', lastname) = '$author'";
    $authid = $conn->query($sql);
    $auid;
    while($row = $authid->fetch_assoc()and $k < mysqli_num_rows($authid)){
        $auid = $row['id'];
        $k++;
    }
    //get the category id from the table based on the category name
    $v = 0;
    $sql2 = "SELECT id FROM category 
    WHERE name = '$category'";
    $cateid = $conn->query($sql2);
    $cid;
    while($row = $cateid->fetch_assoc()and $v < mysqli_num_rows($cateid)){
        $cid = $row['id'];
        $v++;
    }
    
    //insert the book info to the database
    if($titleav == true && $descav == true && $coverav == true && $pdfav == true){
    $sqladd = "INSERT INTO `books`(`title`, `description`, `authorid`, `cover`, `categoryid`, `pdf`)
    VALUES ('$title','$description',$auid,'$coverpath',$cid,'$pdfpath')";
    $conn->query($sqladd);
    //send the 
    $succmsg = "Book added successfully";
    echo $succmsg;
    
    }
    else{
        $succmsg = "Failed to add book";
        echo $succmsg;
    }
    
}
?>