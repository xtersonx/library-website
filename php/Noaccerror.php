<?php
//destroy the session when forwared to this page
session_name("crid");
session_start();
session_destroy();


?>


<html>

<body class="bg-purple">
<link rel="stylesheet" type="text/css" href="../css/errorpagestyle.css">
        
        <div class="stars">
            <div class="custom-navbar">
                <div class="brand-logo">
                    
                    <img src="../media/bookverse-high-resolution-logo-white-transparent.png" width="80px">
                </div>
            
                <div class="navbar-links">
                    
                </div>
            </div>
            <div class="central-body">
                <img class="image-404" src="../media/404page.svg" width="300px">
                <a href="../index.php" class="btn-go-home" target="_blank">GO BACK HOME</a>
            </div>
            <div class="objects">
                <img class="object_rocket" src="../media/rocket.svg" width="40px">
                <div class="earth-moon">
                    <img class="object_earth" src="../media/earth.svg" width="100px">
                    <img class="object_moon" src="../media/moon.svg" width="80px">
                </div>
                <div class="box_astronaut">
                    <img class="object_astronaut" src="../media/astronaut.svg" width="140px">
                </div>
            </div>
            <div class="glowing_stars">
                <div class="star"></div>
                <div class="star"></div>
                <div class="star"></div>
                <div class="star"></div>
                <div class="star"></div>

            </div>

        </div>

 </body>
</html>