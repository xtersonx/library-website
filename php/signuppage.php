<?php

include 'dbconnection.php';
$conn = connect();
//check email if available
$emailavail = false;

//check if with the requirment
$emailpatt = false;
$namepatt = false;
$lastnamepatt = false;
$passwordpatt = false;

//phrase if pattern not true
$emailph = '';
$nameph = '';
$lastnameph = '';
$passwordph = '';
//email avail phrase
$emailavph = "";
$nameph = "";
$lastnameph="";
$emailph = "";
$passph = "";

//input pattern
$namelastpattern = '/^[A-Za-z]+$/';
$emailpattern = '/[A-Za-z0-9]{2,}@[A-Za-z0-9]{2,}\\.[A-Za-z]{2,}/';
$passwordpattern = '/.{8,}/';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $lastname = $_POST['last_name'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    //remove special char
    $name = htmlspecialchars($name);
    $lastname = htmlspecialchars($lastname);
    $password = htmlspecialchars($password);
    $email = htmlspecialchars($email);  

    //check name
    if (preg_match($namelastpattern, $name)) {
        $namepatt = true;

    }
    //check lastname
    if (preg_match($namelastpattern, $lastname)) {
        $lastnamepatt = true;

    }
    //check email
    if (preg_match($emailpattern, $email)) {
        $emailpatt = true;

    }
    //check password
    if (preg_match($passwordpattern, $password)) {
        $passwordpatt = true;
    }
    
    //check if email available in the database
    $sql1 = "SELECT email FROM users WHERE email = '$email'";
    $result = $conn->query($sql1);

    if(mysqli_num_rows($result) > 0){
        $emailavail = true;
    }
    //hash
    $password = password_hash($password, PASSWORD_DEFAULT);

    if($emailavail === false && $namepatt === true && $lastnamepatt === true && $emailpatt === true && $passwordpatt === true){
        $sql2 = "INSERT INTO users(email, name, lastname, password) VALUES ('$email','$name','$lastname','$password')";
        $conn->query($sql2);
        sleep(5);
        header("Location: loginpage.php");
        exit();
        
    }

    
    }
    
    if($emailavail === true){
        $emailavph = "⚠️ Email already in use.";
        $nameph = $name;
        $lastnameph = $lastname;
        $emailph = $email;

    }
       
?>

<html title="Sign Up">
<head>
<link rel="stylesheet" type="text/css" href="../css/signlogstyle.css">
<script src='../js/signupcek.js'></script>

<title>Sign Up</title>
</head>
<body>
<div id="formcont">
  <form method="POST" id="signfo" onsubmit="starttime()">
    <h1 id="signtitle">Sign Up</h1>

    <input type="text" name="name" placeholder="Name" id="namec" value="<?php echo isset($nameph) ? $nameph : "" ?>">
    <input type="text" name="last_name" placeholder="Last Name" id="lastc" value="<?php echo isset($lastnameph) ? $lastnameph : "" ?>">
    <input type="email" name="email" placeholder="Email" id="emailc" oninput="clearemailerr()" value="<?php echo isset($emailph) ? $emailph : "" ?>">
    <span id="emailerr" class="whyx"><?php echo isset($emailavph) ? $emailavph : ""; ?></span>
    <div class="showeye">
      <input type="password" name="password" placeholder="Password" id="passc">
      <span class="iconeye" onclick="iconchange()"><img src="../media/hiddeneye.png" style="width: 20 ; height:20" ></span>
    </div>

    <a id="agree"><input type="checkbox" id="cek1">  I agree to the terms of service</a>

    <button type="submit" onclick="checkform()">Sign Up</button>
    <a id="alrph">Already have an account?</a>
    <a href="loginpage.php" id="logph">Login</a>
    <a id="countdown"></a>
  </form>
</div>

</body>
</html>
