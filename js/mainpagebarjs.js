$(document).ready(function() {
    $('.btn1').click(function() {
      $(this).toggleClass("click");
      $('.sidebar').toggleClass("show");
    });
  
    $('.feat-btn1').click(function() {
      $('nav ul .feat-show').toggleClass("show");
      $('nav ul .first').toggleClass("rotate");
    });
  
  });

  function showDescription(element) {
    var bookDescription = element.querySelector('.book-description');
    bookDescription.style.display = 'block';
  }
  
  function hideDescription(element) {
    var bookDescription = element.querySelector('.book-description');
    bookDescription.style.display = 'none';
  }

  function callsearch(){
  var form = document.getElementById("searchform");
  form.addEventListener("submit", searchajax);
  
  }

// send the form with the ajax
function searchajax(event) {
  event.preventDefault();

  // Get the form data
  var bookform = new FormData(event.target);

  // send the ajax request
  $.ajax({
    url: "search.php", 
    type: "POST",
    data: bookform,
    processData: false,
    contentType: false,
    success: function (response) {
      var allboo  = JSON.parse(response);
    
      
     

      var bookcar = allboo.map(function(books, index) {
        $title = books[0];
        $img = books[1];
        $pdf = books[2];
        $desc = books[3];
        $firstn = books[4];
        $lastn = books[5];
  
        return `
        <li class="cardsear">
        <div class="img">
        <img src="${$img}" alt="img" draggable="false">
        </div>
        
        <div class="description">
        <p>${$desc}</p>
        </div>
        
        <h2 style = "font-size:25;">${$title}</h2>
        <h2 style = "font-size:15;margin-top:1">by ${$firstn} ${$lastn}</h2>
        <br>
        <p>
        <a href = "${$pdf}" target="_blank">
        <span class="fa-solid fa-book-open-reader" style ="margin-right:32;font-size:25"></span>
        </a>
        <a href = "${$pdf}" download>
        <span class ="fa-solid fa-download" style="color:black;font-size:25"></span>
        </a>
        </p>  
        </li>

        
        
        
        `;
      });
      var finalre = bookcar.join("");
      var doc = document.getElementById("showsearch");
      doc.innerHTML = `
      <h2 style="color:white;">Result</h2>
      <div class = "wrappersear">
      <i id="left" class="fa-solid fa-angle-left lefrigx"></i>
      <ul class= "carouselsear">
         
      ${finalre}

      </ul>
      <i id="right" class="fa-solid fa-angle-right lefrigx"></i>
     </div>
     <br>
     <br>
     <br>
    
      `;
     
      
      onsearch();
      
     
    },
   
  });


}






function onsearch(){
    
    $(document).ready(function() {
    const wrapper = document.querySelector(".wrappersear");
    const carousel = document.querySelector(".carouselsear");
    const firstCardWidth = carousel.querySelector(".cardsear").offsetWidth;
    const arrowBtns = document.querySelectorAll(".wrappersear i");
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
    arrowBtns.forEach(btn1 => {
        btn1.addEventListener("click", () => {
            carousel.scrollLeft += btn1.id == "left" ? -firstCardWidth : firstCardWidth;
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

}





function callrmv(){
  var form2 = document.getElementById("searchform");
  form2.addEventListener("reset", rmv);
  reinput();
  
  }



function rmv(event){
  
  event.preventDefault();

  var doc2 = new FormData(event.target);

  

  
  var doc2 = document.getElementById("showsearch");
      doc2.innerHTML = ``;

      reinput();

    
  
}
 
function reinput(){
  var reput = document.getElementById("sein");
  reput.value = '';
}