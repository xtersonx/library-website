<?php





























?>
<html>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<body>

<div id = "showsearch">

<div class="wrappersear">
        <i id="left" class="fa-solid fa-angle-left lefrigx"></i>
        
        <h2>Result</h2>
        <ul class="carouselsear">

        <li class="cardsear">
        <div class="img">
        <img src="" alt="img" draggable="false">
        </div>
        
        <div class="description">
        <p>asd</p>
        </div>
        
        <h2 style = "font-size:25;">dassdasd</h2>
        <h2 style = "font-size:15;margin-top:1">by aasdasd</h2>
        <br>
        <p>
        <a href = "${$pdf}" target="_blank">
        <span class="fa-solid fa-book-open-reader" style ="margin-right:32;font-size:25"></span>
        </a>
        <a href = "" download>
        <span class ="fa-solid fa-download" style="color:black;font-size:25"></span>
        </a>
        </p>
        </li>



        <li class="cardsear">
        <div class="img">
        <img src="" alt="img" draggable="false">
        </div>
        
        <div class="description">
        <p>asd</p>
        </div>
        
        <h2 style = "font-size:25;">dassdasd</h2>
        <h2 style = "font-size:15;margin-top:1">by aasdasd</h2>
        <br>
        <p>
        <a href = "${$pdf}" target="_blank">
        <span class="fa-solid fa-book-open-reader" style ="margin-right:32;font-size:25"></span>
        </a>
        <a href = "" download>
        <span class ="fa-solid fa-download" style="color:black;font-size:25"></span>
        </a>
        </p>
        </li>

        <li class="cardsear">
        <div class="img">
        <img src="" alt="img" draggable="false">
        </div>
        
        <div class="description">
        <p>asd</p>
        </div>
        
        <h2 style = "font-size:25;">dassdasd</h2>
        <h2 style = "font-size:15;margin-top:1">by aasdasd</h2>
        <br>
        <p>
        <a href = "${$pdf}" target="_blank">
        <span class="fa-solid fa-book-open-reader" style ="margin-right:32;font-size:25"></span>
        </a>
        <a href = "" download>
        <span class ="fa-solid fa-download" style="color:black;font-size:25"></span>
        </a>
        </p>
        </li>

  
        </ul>
        <i id="right" class="fa-solid fa-angle-right lefrigx"></i>
    </div>
    <br>
    <br>
    <br>
      
</div>























<style>
    body{
        background-color: black;
    }
    
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
    

<script>
    
    $(document).ready(function() {
    const wrapperx = document.querySelector(".wrappersear");
    const carouselx = document.querySelector(".carouselsear");
    const firstCardWidth = carousel.querySelector(".cardsear").offsetWidth;
    const arrowBtns = document.querySelectorAll(".wrappersear .lefrigx");
    const carouselChildrens = [...carousel.children];
    
    let isDragging = false, isAutoPlay = true, startX, startScrollLeft, timeoutId;
    
    // Get the number of cards that can fit in the carousel at once
    let cardPerView = Math.round(carousel.offsetWidth / firstCardWidth);
    
    // Insert copies of the last few cards to beginning of carousel for infinite scrolling
    carouselChildrens.slice(-cardPerView).reverse().forEach(cardsear => {
        carousel.insertAdjacentHTML("afterbegin", cardsear.outerHTML);
    });
    
    // Insert copies of the first few cards to end of carousel for infinite scrolling
    carouselChildrens.slice(0, cardPerView).forEach(cardsear => {
        carousel.insertAdjacentHTML("beforeend", cardsear.outerHTML);
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
































    </body>











</html>