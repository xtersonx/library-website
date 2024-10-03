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
$authorlist = [[]];
$catlist = [];

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

    //sql to get the all author names
    $n = 0;
    $sql33 = "SELECT `name`,`lastname` FROM author ORDER BY name ASC, lastname ASC";
    $authres = $conn->query($sql33);

    //store the name and last name of the author in dimensional array
    while($row = $authres->fetch_assoc()and $n < mysqli_num_rows($authres)){
        $authorlist[$n] = array($row['name'],$row['lastname']);
        $n++;
    }

    //sql to get all category names
    $z = 0;
    $sql44 = "SELECT name FROM category ORDER BY name ASC";
    $catelist = $conn->query($sql44);

    //store the name and last name of the author in dimensional array
    while($row = $catelist->fetch_assoc()and $z < mysqli_num_rows($catelist)){
        $catlist[$z] = $row['name'];
        $z++;
    }
    


 
?>

<html>
<head>
    <title></title>
    <link rel="stylesheet" href="../css/adminpagestyle.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/logoutjs.js"></script>
    
    <!-- script for the drawer -->
    <script src='../js/adminpage.js'></script>
    <script src='../js/addbookjs.js'></script>
    <script src='../js/addauthorjs.js'></script>
    <script src='../js/addcatejs.js'></script>
    

    <!-- Style for the button -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    
</head>

<body>
    
<header>
<div class="backgroundWhite">

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
                    <li class = "active"><a href="adminedits.php">Add Operations</a></li>
                    <li><a href="editpage.php">Edit Operations</a></li>
                </ul>
            </li>';
            }
            ?>





        </ul>


    </nav>
    <button id="addbook" onclick="addbook()">Add book</button>
    <button id="addau" onclick="addauthor()">Add Author</button>
    <button id="addcat" onclick="addcat()">Add category</button>
  </div>

   
</header>



<!-- here i set the value as json of the authorlist-->
<input type="hidden" id="authlist" value="<?php echo htmlspecialchars(json_encode($authorlist)); ?>">
<!-- here i set the value as json of the catelist-->
<input type="hidden" id="catlist" value="<?php echo htmlspecialchars(json_encode($catlist)); ?>">
</body>
<div id="htmlcontent">

    
    

</div>


</html>