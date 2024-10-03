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
$categ = [[]];
$bookli = [[]];
$j=0;

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

    $n = 0;
    $getallcat = "SELECT id,name FROM category";
    $catres = $conn->query($getallcat);
    while($row = $catres->fetch_assoc() and $n < mysqli_num_rows($catres)){
        $categ[$n] = array($row['id'],$row['name']);
        $n++;
    }
    $k = 0;
    $getallbook = "SELECT b.title, b.cover, b.pdf, b.description, a.name,a.lastname,b.categoryid
    FROM books b 
    JOIN author a ON b.authorid = a.id";
    $bookres = $conn->query($getallbook);
    while ($row = $bookres->fetch_assoc() and $k < mysqli_num_rows($bookres)) {
        $bookli[$k] = array($row['title'], $row['cover'], $row['pdf'], $row['description'], $row['name'],$row['lastname'],$row['categoryid']);
        $k++;
    }

    





?>


<html>

<head>
    <title></title>
    <link rel="stylesheet" href="../css/mainpagestyles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/logoutjs.js"></script>
    <!-- script for the drawer -->
    <script src='../js/mainpagebarjs.js'></script>
    <!-- Style for the button -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

</head>

<body>
    

<header>

<div class="backgroundWhite">
<div class="btn1">
        <span class="fas fa-bars"></span>
    </div>

    <nav class="sidebar">


        <div class="text">
            Menu
        </div>
        <ul>
            <li class="active"><a href="mainpage.php">Home</a></li>
            <li><a id="logout">Logout</a></li>

            <?php
            if ($isadmin == true) {
                echo '<li><a href="adminedits.php">Control Center</a></li>';
            }
            ?>

            <li>
                <a href="#" class="feat-btn1">Feautures
                    <span class="fas fa-caret-down first"></span>
                </a>
                <ul class="feat-show">
                    <li><a href="#">Pages</a></li>
                    <li><a href="#">Elements</a></li>
                </ul>
            </li>


        </ul>
    </nav>
          
    <form method="POST" id="searchform">
  <div class="search-container">
    <input type="text" name="searchin" placeholder="Search" id="sein" required>


    
    <button class="rmv-btn" type="reset" onclick="callrmv()">
    <i class="fa-solid fa-xmark"></i>
    </button>


    <button class="search-btn" type="submit" onclick="callsearch()">
    <i class="fa-solid fa-magnifying-glass"></i>
    </button>

  
    
  </div>
</form>
    


  
</header>

<section style="height: 200; margin-top:100" >

    
    <div id = "showsearch" style="margin-top: 20;">

    

    </div>
  

    <style>
   
    .wrappersear {
      max-width: 1100px;
      width: 100%;
      position: relative;
    }
    .wrappersear #left,#right, i {
      top: 50%;
      height: 50px;
      width: 50px;
      cursor: pointer;
      font-size: 1.25rem;
      position: absolute;
      text-align: center;
      line-height: 50px;
      background: #fff;
      border-radius: 50%;
      box-shadow: 0 3px 6px rgba(0,0,0,0.23);
      transform: translateY(-50%);
      transition: transform 0.1s linear;
      color:black;
    }
    .wrappersear i:active{
      transform: translateY(-50%) scale(0.85);
    }
    .wrappersear i:first-child{
      left: -22px;
    }
    .wrappersear i:last-child{
      right: -22px;
    }
    .wrappersear .carouselsear{
      display: grid;
      grid-auto-flow: column;
      grid-auto-columns: calc((100% / 3) - 12px);
      overflow-x: auto;
      scroll-snap-type: x mandatory;
      gap: 16px;
      border-radius: 8px;
      scroll-behavior: smooth;
      scrollbar-width: none;
    }
    .carouselsear::-webkit-scrollbar {
      display: none;
    }
    .carouselsear.no-transition {
      scroll-behavior: auto;
    }
    .carouselsear.dragging {
      scroll-snap-type: none;
      scroll-behavior: auto;
    }
    .carouselsear.dragging .cardsear {
      cursor: grab;
      user-select: none;
    }
    .carouselsear :where(.cardsear, .img) {
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .carouselsear .cardsear {
      scroll-snap-align: start;
      height: 342px;
      list-style: none;
      background: #fff;
      cursor: pointer;
      padding-bottom: 15px;
      flex-direction: column;
      border-radius: 8px;
    }
    .carouselsear .cardsear .img {
      background: #000000;
      height: 148px;
      width: 148px;
      border-radius: 1%;
    }
    .cardsear .img img {
      width: 140px;
      height: 140px;
      border-radius: 1%;
      object-fit: cover;
      border: 4px solid #fff;
    }
    .carouselsear .cardsear h2 {
      font-weight: 500;
      font-size: 1.56rem;
      margin: 30px 0 5px;
      color:black;
    }
    .carouselsear .cardsear span {
      color: #6A6D78;
      font-size: 1.31rem;
    }
    
    @media screen and (max-width: 900px) {
      .wrappersear .carouselsear {
        grid-auto-columns: calc((100% / 2) - 9px);
      }
    }
    
    @media screen and (max-width: 600px) {
      .wrappersear .carouselsear {
        grid-auto-columns: 100%;
      }
    }
    @media screen and (min-width: 601px) {
      .wrappersear .carouselsear {
        grid-auto-columns: calc((100% / 5) - 12px);
      }
    }
    </style>



 
<?php
foreach ($categ as $category) {
    $categoryid = $category[0];
    $categoryname = $category[1];

    
    echo '
    <div class="wrapper'.$categoryid.'" style="margin-top:20">
        <i id="left" class="fa-solid fa-angle-left lefrig"></i>
        
        <h2 style="color:white;">'.$categoryname.'</h2>
        <ul class="carousel'.$categoryid.'">
          ';  
            
            foreach ($bookli as $books){
            $bookname = $books[0];
            $bookcover = $books[1];
            $bookpdf = $books[2];
            $bookdesc = $books[3];
            $bookauthna = $books[4];
            $bookautlast = $books[5];
            $bookcate = $books[6];
              
            if($bookcate == $categoryid){
            echo'
            <li class="card'.$categoryid.'">
                <div class="img">
                <img src="'.$bookcover.'" alt="img" draggable="false">
                </div>
                
            <div class="description">
            <p>'.$bookdesc.'</p>
            </div>
                
                <h2 style = "font-size:25;">'.$bookname.'</h2>
                <h2 style = "font-size:15;margin-top:1">by '.$bookauthna.' '.$bookautlast.'</h2>
                <br>
                <p>
                <a href = "'.$bookpdf.'" target="_blank">
                <span class="fa-solid fa-book-open-reader" style ="margin-right:32;font-size:25"></span>
                </a>
                <a href = "'.$bookpdf.'" download>
                <span class ="fa-solid fa-download" style="color:black;font-size:25"></span>
                </a>
                </p>
                
            </li>
            
              '; 
            } 
          }
            
            
          echo'
        </ul>
        <i id="right" class="fa-solid fa-angle-right lefrig"></i>
    </div>
    <br><br><br>
';
   echo '
    <script>
    
    $(document).ready(function() {
    const wrapper = document.querySelector(".wrapper'.$categoryid. '");
    const carousel = document.querySelector(".carousel'.$categoryid. '");
    const firstCardWidth = carousel.querySelector(".card'.$categoryid. '").offsetWidth;
    const arrowBtns = document.querySelectorAll(".wrapper'.$categoryid. ' .lefrig");
    const carouselChildrens = [...carousel.children];
    
    let isDragging = false, isAutoPlay = true, startX, startScrollLeft, timeoutId;
    
    // Get the number of cards that can fit in the carousel at once
    let cardPerView = Math.round(carousel.offsetWidth / firstCardWidth);
    
    // Insert copies of the last few cards to beginning of carousel for infinite scrolling
    carouselChildrens.slice(-cardPerView).reverse().forEach(card => {
        carousel.insertAdjacentHTML("afterbegin", card.outerHTML);
    });
    
    // Insert copies of the first few cards to end of carousel for infinite scrolling
    carouselChildrens.slice(0, cardPerView).forEach(card => {
        carousel.insertAdjacentHTML("beforeend", card.outerHTML);
    });
    
    // Scroll the carousel at appropriate postition to hide first few duplicate cards on Firefox
    carousel.classList.add("no-transition");
    carousel.scrollLeft = carousel.offsetWidth;
    carousel.classList.remove("no-transition");
    
    // Add event listeners for the arrow buttons to scroll the carousel left and right
    arrowBtns.forEach(btn => {
        btn.addEventListener("click", () => {
            carousel.scrollLeft += btn.id == "left" ? -firstCardWidth : firstCardWidth;
        });
    });
    
    const dragStart = (e) => {
        isDragging = true;
        carousel.classList.add("dragging");
        // Records the initial cursor and scroll position of the carousel
        startX = e.pageX;
        startScrollLeft = carousel.scrollLeft;
    }
    
    const dragging = (e) => {
        if(!isDragging) return; // if isDragging is false return from here
        // Updates the scroll position of the carousel based on the cursor movement
        carousel.scrollLeft = startScrollLeft - (e.pageX - startX);
    }
    
    const dragStop = () => {
        isDragging = false;
        carousel.classList.remove("dragging");
    }
    
    const infiniteScroll = () => {
        // If the carousel is at the beginning, scroll to the end
        if(carousel.scrollLeft === 0) {
            carousel.classList.add("no-transition");
            carousel.scrollLeft = carousel.scrollWidth - (2 * carousel.offsetWidth);
            carousel.classList.remove("no-transition");
        }
        // If the carousel is at the end, scroll to the beginning
        else if(Math.ceil(carousel.scrollLeft) === carousel.scrollWidth - carousel.offsetWidth) {
            carousel.classList.add("no-transition");
            carousel.scrollLeft = carousel.offsetWidth;
            carousel.classList.remove("no-transition");
        }
    
        // Clear existing timeout & start autoplay if mouse is not hovering over carousel
        clearTimeout(timeoutId);
        if(!wrapper.matches(":hover")) autoPlay();
    }
    
    const autoPlay = () => {
        if(window.innerWidth < 800 || !isAutoPlay) return; // Return if window is smaller than 800 or isAutoPlay is false
        // Autoplay the carousel after every 2500 ms
        timeoutId = setTimeout(() => carousel.scrollLeft += firstCardWidth, 2500);
    }
    autoPlay();
    
    carousel.addEventListener("mousedown", dragStart);
    carousel.addEventListener("mousemove", dragging);
    document.addEventListener("mouseup", dragStop);
    carousel.addEventListener("scroll", infiniteScroll);
    wrapper.addEventListener("mouseenter", () => clearTimeout(timeoutId));
    wrapper.addEventListener("mouseleave", autoPlay);
    
      });

    
    </script>
      ';
  
   echo'
    <style>
    
    
    .wrapper'.$categoryid. ' {
      max-width: 1100px;
      width: 100%;
      position: relative;
    }
    .wrapper'.$categoryid. ' #left,#right, i {
      top: 50%;
      height: 50px;
      width: 50px;
      cursor: pointer;
      font-size: 1.25rem;
      position: absolute;
      text-align: center;
      line-height: 50px;
      background: #fff;
      border-radius: 50%;
      box-shadow: 0 3px 6px rgba(0,0,0,0.23);
      transform: translateY(-50%);
      transition: transform 0.1s linear;
      color:black;
    }
    .wrapper'.$categoryid. ' i:active{
      transform: translateY(-50%) scale(0.85);
    }
    .wrapper'.$categoryid. ' i:first-child{
      left: -22px;
    }
    .wrapper'.$categoryid. ' i:last-child{
      right: -22px;
    }
    .wrapper'.$categoryid. ' .carousel'.$categoryid. '{
      display: grid;
      grid-auto-flow: column;
      grid-auto-columns: calc((100% / 3) - 12px);
      overflow-x: auto;
      scroll-snap-type: x mandatory;
      gap: 16px;
      border-radius: 8px;
      scroll-behavior: smooth;
      scrollbar-width: none;
    }
    .carousel'.$categoryid. '::-webkit-scrollbar {
      display: none;
    }
    .carousel'.$categoryid. '.no-transition {
      scroll-behavior: auto;
    }
    .carousel'.$categoryid. '.dragging {
      scroll-snap-type: none;
      scroll-behavior: auto;
    }
    .carousel'.$categoryid. '.dragging .card'.$categoryid. ' {
      cursor: grab;
      user-select: none;
    }
    .carousel'.$categoryid. ' :where(.card'.$categoryid. ', .img) {
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .carousel'.$categoryid. ' .card'.$categoryid. ' {
      scroll-snap-align: start;
      height: 342px;
      list-style: none;
      background: #fff;
      cursor: pointer;
      padding-bottom: 15px;
      flex-direction: column;
      border-radius: 8px;
    }
    .carousel'.$categoryid. ' .card'.$categoryid. ' .img {
      background: #000000;
      height: 148px;
      width: 148px;
      border-radius: 1%;
    }
    .card'.$categoryid. ' .img img {
      width: 140px;
      height: 140px;
      border-radius: 1%;
      object-fit: cover;
      border: 4px solid #fff;
    }
    .carousel'.$categoryid. ' .card'.$categoryid. ' h2 {
      font-weight: 500;
      font-size: 1.56rem;
      margin: 30px 0 5px;
      color:black;
    }
    .carousel'.$categoryid. ' .card'.$categoryid. ' span {
      color: #6A6D78;
      font-size: 1.31rem;
    }
    
    @media screen and (max-width: 900px) {
      .wrapper'.$categoryid. ' .carousel'.$categoryid. ' {
        grid-auto-columns: calc((100% / 2) - 9px);
      }
    }
    
    @media screen and (max-width: 600px) {
      .wrapper'.$categoryid. ' .carousel'.$categoryid. ' {
        grid-auto-columns: 100%;
      }
    }
    @media screen and (min-width: 601px) {
      .wrapper'.$categoryid. ' .carousel'.$categoryid. ' {
        grid-auto-columns: calc((100% / 5) - 12px);
      }
    }
    </style>
 ';

}

?>
</section>

</body>


</html>



          