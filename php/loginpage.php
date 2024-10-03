<?php

$conn = null;
//this make the connection
 include 'dbconnection.php';
 $conn = connect();

//this create two dimensional array; multiple array in one array.
$names = [[]];
$j=0;

//Create a querry for select all
$sql = "SELECT email,password FROM users";

//send the querry to the database and save the result
$result = $conn->query($sql);

//store all the data in dimensional array
while($row = $result->fetch_assoc()and $j < mysqli_num_rows($result)){
    $names[$j] = array($row['email'],$row['password']);
    $j++;

}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    //remove special char
    $password = htmlspecialchars($password);
    $email = htmlspecialchars($email);  

    $found = false;
    //check credential
    for ($i = 0; $i < sizeof($names); $i++) {
        if ($names[$i][0] === $email && password_verify($password,$names[$i][1]) === true) {
            $found = true;
            break;
        }
    }
    if ($found) {
        session_name("crid");
        session_start();
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $password;
        // Redirect the user to the desired page
        header("Location:mainpage.php");
        exit();
        
    } 
    else {
        // Email and password do not match
        echo '<script>alert("Invalid email or password.");</script>';
        $emailph = $email;
    }

}

?>

<html title="Sign Up">
<link rel="stylesheet" type="text/css" href="../css/signlogstyle.css">
<script src='../js/signup.js'></script>
<script src='../js/logincek.js'></script>

<title>Login</title>
</head>
<body>
    <div id="formcont">
    <form method="POST" id="signfo" style="margin-top: 150;">
    <h1 id="signtitle">Login</h1>
        <input type="email" name="email" placeholder="Email" id="emailc" value="<?php echo isset($emailph) ? $emailph: ""?>">
        <div class="showeye">
      <input type="password" name="password" placeholder="Password" id="passc">
      <span class="iconeye" onclick="iconchange()"><img src="../media/hiddeneye.png" style="width: 20 ; height:20" ></span>
    </div>
        
        <button type="submit" onclick="checkform()">Login</button>
   
        <a id="alrph">Dont have an account?</a>
        <a href="signuppage.php" id="logph">Sign up</a>

    </form>

</div>

</body>
</html>