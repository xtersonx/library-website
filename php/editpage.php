<?php

include 'dbconnection.php';
$conn = connect();
session_name("crid");
session_start();
$email = $_SESSION['email'];
$password = $_SESSION['password'];

//this create two dimensional array; multiple array in one array.
$names = [[]];
$ids = [];
$j=0;
$titlelist = [];
$authorl = [[]];
$categls = [];

//Create a querry for select all
$sql = "SELECT email,password FROM users";


//send the querry to the database and save the result
$result = $conn->query($sql);

$isadmin = false;


//store all the data in dimensional array
while($row = $result->fetch_assoc()and $j < mysqli_num_rows($result)){
    $names[$j] = array($row['email'],$row['password']);
    $j++;
}

$found = false;
    //check credential
    for ($i = 0; $i < sizeof($names); $i++) {
        if ($names[$i][0] === $email && password_verify($password,$names[$i][1]) === true) {
            $found = true;
            break;
        }
    }
    if($found == false){
        header("Location: Noaccerror.php");
    }
    //check the id for the admin
    $l = 0;
    $sql2 = "SELECT id FROM users WHERE email = '$email'";
    $idres = $conn->query($sql2);
    while($row = $idres->fetch_assoc()and $l < mysqli_num_rows($idres)){
        $ids[$l] = $row['id'];
        $l++;
    }
    if($ids[0] >= 999 && $ids[0] <= 1003){
        $isadmin = true;
    }
    else{
        $isadmin = false;

    }
    
    //kick out if not admin
    if($isadmin == false ){
        header("Location: Noaccerror.php");  
    }

    //sql to get the all books title 
    $j = 0;
    $sql33 = "SELECT title FROM books ORDER BY title ASC";
    $titleres = $conn->query($sql33);

    //store the  title in dimensional array
    while($row = $titleres->fetch_assoc()and $j < mysqli_num_rows($titleres)){
        $titlelist[$j] = $row['title'];
        $j++;
    }

    //sql to get the all  auther
    $b = 0;
    $sql55 = "SELECT name as authn, lastname,id FROM `author` ORDER BY name ASC";
    $authorres = $conn->query($sql55);
    //store the name and last name of the author in dimensional array
    while($row = $authorres->fetch_assoc()and $b < mysqli_num_rows($authorres)){
        $authorl[$b]= array($row['authn'],$row['lastname'],$row['id']);
        $b++;
    }

    //sql to get all category name
    $g = 0;
    $sql66 = "SELECT name FROM category ORDER BY name ASC";
    $caterres = $conn->query($sql66);
    //store the name and last name of the author in dimensional array
    while($row = $caterres->fetch_assoc()and $g < mysqli_num_rows($caterres)){
        $categls[$g]= $row['name'];
        $g++;
    }



   
    


 
?>

<html>
<head>
    <title></title>
    <link rel="stylesheet" href="../css/editpagestlye.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/logoutjs.js"></script>
    
    <!-- script for the drawer -->
    <script src='../js/adminpage.js'></script>
    <script src='../js/editbookjs.js'></script>
    <script src='../js/editauthorjs.js'></script>
    <script src='../js/editcatjs.js'></script>

    
    <!-- Style for the button -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    
</head>

<body>
    
<header>
   
    <div class="btn">
        <span class="fas fa-bars"></span>
    </div>
    
    
    <nav class="sidebar">
        <div class="text">
            Side Menu
        </div>
        <ul>
            <li><a href="mainpage.php">Home</a></li>
            <li><a id="logout">Logout</a></li>
            
            <?php
            if ($isadmin == true) {
                echo ' <li>
                <a href="#" class="feat-btn" id = "active">Control Center
                    <span class="fas fa-caret-down first"></span>
                </a>
                <ul class="feat-show">
                    <li><a href="adminedits.php">Add Operations</a></li>
                    <li class = "active"><a href="editpage.php">Edit Operations</a></li>
                </ul>
            </li>';
            }
            ?>

          
         
       
        </ul>
        
    </nav>
    <button id="addbook" onclick="editbook()">Edit book</button>
    <button id="addau" onclick="editauthor()">Edit author</button>
    <button id="addcat" onclick="editcat()">Edit category</button>
    

    

</header>


<!-- here i set the value as json of the titlelist-->
<input type="hidden" id="titlelist" value="<?php echo htmlspecialchars(json_encode($titlelist)); ?>">
<input type="hidden" id="authlist" value="<?php echo htmlspecialchars(json_encode($authorl)); ?>">
<input type="hidden" id="catelist" value="<?php echo htmlspecialchars(json_encode($categls)); ?>">
<div id="htmlcontent">
    

    

</div>

<div id = "imgcont">


    </div>
   

</body>





</html>